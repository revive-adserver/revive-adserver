<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
| For contact details, see: http://www.openx.org/                           |
|                                                                           |
| This program is free software; you can redistribute it and/or modify      |
| it under the terms of the GNU General Public License as published by      |
| the Free Software Foundation; either version 2 of the License, or         |
| (at your option) any later version.                                       |
|                                                                           |
| This program is distributed in the hope that it will be useful,           |
| but WITHOUT ANY WARRANTY; without even the implied warranty of            |
| MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
| GNU General Public License for more details.                              |
|                                                                           |
| You should have received a copy of the GNU General Public License         |
| along with this program; if not, write to the Free Software               |
| Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA |
+---------------------------------------------------------------------------+
$Id$
*/

require_once MAX_PATH . '/lib/OA.php';
require_once MAX_PATH . '/lib/OA/Maintenance/Priority/AdServer/Task.php';
require_once MAX_PATH . '/lib/OA/ServiceLocator.php';
require_once MAX_PATH . '/lib/OX/Maintenance/Priority/Zone.php';
require_once MAX_PATH . '/lib/pear/Date.php';

/**
 * A class used to forecast the expected number of impressions in each
 * operation interval, for each zone.
 *
 * @package    OpenXMaintenance
 * @subpackage Priority
 * @author     Andrew Hill <andrew.hill@openx.org>
 */
class OA_Maintenance_Priority_AdServer_Task_ForecastZoneImpressions extends OA_Maintenance_Priority_AdServer_Task
{

    /**
     * Local copy of the OpenX configuration array.
     *
     * @var array
     */
    var $aConf;

    /**
     * A date representing "now", ie. the current date/time.
     *
     * @var PEAR::Date
     */
    var $oDateNow;

    /**
     * A date representing the end of the current operation interval - this is the
     * date to which the ZIF values will be updated until.
     *
     * @var PEAR::Date
     */
    var $oUpdateToDate;

    /**
     * An array of all the active zone IDs in the system, including the
     * special "direct selection" zone ID 0.
     *
     * @var array
     */
    var $aActiveZoneIDs;

    /**
     * An array to store details of newly calculated ZIF data.
     *
     * @var array
     */
    var $aForecastResults;

    /**
     * The constructor method.
     */
    function OA_Maintenance_Priority_AdServer_Task_ForecastZoneImpressions()
    {
        parent::OA_Maintenance_Priority_AdServer_Task();

        // Store the configuration array
        $this->aConf = $GLOBALS['_MAX']['CONF'];

        // Store the current date/time
        $this->oDateNow = $this->getDateNow();

        // Set the date to update ZIF values until - that is, the end of the
        // current operation interval
        $aDates = OX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($this->oDateNow);
        $this->oUpdateToDate = $aDates['end'];

        // Prepare the list of all active zones in the system
        $this->aActiveZoneIDs = $this->_getActiveZonesIDs();

        // Set the results arrays to an empty arrays
        $this->aForecastResults = array();
    }

    /**
     * Get the current "now" time from the OA_ServiceLocator,
     * or create it if not set yet
     *
     * TODO: Move this somewhere to Date utility
     */
    function getDateNow()
    {
        $oServiceLocator =& OA_ServiceLocator::instance();
        $oDateNow =& $oServiceLocator->get('now');
        if (!$oDateNow) {
            $oDateNow = new Date();
            $oServiceLocator->register('now', $oDateNow);
        }
        return $oDateNow;
    }

    /**
     * A private method to return an array of all zone IDs in the system where
     * the zones are active (ie. they have at least one active banner linked
     * to them), as well as the special "direct selection" zone ID 0.
     *
     * @access private
     * @return array An array of zone IDs
     */
    function _getActiveZonesIDs()
    {
        $aZonesIDs = array();
        // Add the special "direct selection" zone ID 0.
        $aZonesIDs[] = 0;
        // Add all real active zones
        $aResult = $this->oDal->getActiveZones();
        if (PEAR::isError($aResult)) {
            OA::debug('- Error retrieving active zone list, exiting', PEAR_LOG_CRIT);
            exit();
        }
        if (empty($aResult)) {
            // Return only Zone ID 0
            return $aZonesIDs;
        }
        foreach ($aResult as $aRow) {
            $aZonesIDs[] = (int) $aRow['zoneid'];
        }
        // Return the zones
        return $aZonesIDs;
    }

    /**
     * The main method of the class, that is run by the controlling
     * task runner class.
     */
    function run()
    {
        // Initial debugging output and task start date
        OA::debug('Running Maintenance Priority Engine: Zone Impression Forecast Update', PEAR_LOG_DEBUG);
        $oStartDate = new Date();

        // Perform the zone forecasting
        $this->forecast();

        // Record the completion of the task in the database
        OA::debug('- Recording completion of the Forecast Zone Impressions task', PEAR_LOG_DEBUG);
        $oEndDate = new Date();
        $this->oDal->setMaintenancePriorityLastRunInfo($oStartDate, $oEndDate, $this->oUpdateToDate, DAL_PRIORITY_UPDATE_ZIF);
    }

    function forecast()
    {
        // Convert the required update type into an array of operation interval ID
        // ranges, being the operation interval IDs where all zones require their
        // ZIF values to be udpated
        $nextIntervalIdDates = $this->_getOperationIntervalRanges();
        // For every active zone in the system...
        foreach ($this->aActiveZoneIDs as $zoneId) {
            // ... calculate that zone's ZIF data as required
            OA::debug("- Calculating the ZIF data for Zone ID $zoneId", PEAR_LOG_DEBUG);
            // Calculate the ZIF values for just the required ranges, if present
            $this->_calculateZoneImpressionForecastValues($zoneId, $nextIntervalIdDates['intervalId'], $nextIntervalIdDates['dates']);
        }
        // Save any ZIF data that has been calculated
        if (!empty($this->aForecastResults)) {
            $this->oDal->saveZoneImpressionForecasts($this->aForecastResults); // Update to ensure additional info passed in about how to save...
        }
    }

    /**
     * Returns intervalId and start/end dates for the current operation interval 
     * for which ZIF needs to process forecast
     */
    function _getOperationIntervalRanges()
    {
        // Update all - need one week's worth of operation intervals up until the end
        // of the operation interval *after* the one that statistics have been updated
        // to, as we need to predict one interval ahead of now
        $oStatsDates = OX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($this->oDateNow);
        $intervalId = OX_OperationInterval::convertDateToOperationIntervalID($this->oDateNow);
        return array( 
        	'intervalId' => $intervalId,
            'dates' => $oStatsDates 
        );
    }

    /**
     * A private method that calcualtes the ZIF value(s) for a given zone.
     *
     * For each operation interval that requires the zone's ZIF value to be updated,
     * the ZIF value for the zone is calculated via the following algorithm:
     *
     * - Uses latest available OI actual_impressions if found
     * - If the zone never served anything, then the expected number of impressions for that
     *   zone is set to the default forecast for a zone .
     *
     * Note also:
     *  - If the zone ID exists in the $this->aNewZoneIDs array, then all operation
     *    intervals for the past week will be updated, not just those in $aRanges.
     *
     * @access private
     * @param integer $zoneId The ID of the zone which may require its ZIF value(s)
     *                        to be calculated.
     * @param array   $nextIntervalIdDates  intervalId => array('start' => Date, 'end' => End )
     *
     * @return void
     */
    function _calculateZoneImpressionForecastValues($zoneId, $intervalId, $aInterval)
    {
        // Check the parameters
        if (!is_integer($zoneId) || $zoneId < 0) {
            return;
        }
        $latestAvailableActualImpressionsForZone = $this->oDal->getLatestAvailableActualImpressionsForZone($zoneId);
        // forecast the value based on the past operation interval's data
        if ($latestAvailableActualImpressionsForZone > 0) {
            // Use the previous operation interval's actual impressions value as the new forecast
            OA::debug("  - Forecasting for zone $zoneId for OI $intervalId (starting '" . $aInterval['start']->format('%Y-%m-%d %H:%M:%S') .
                      ' ' . $aInterval['start']->tz->getShortName() . "') based on previous OI value", PEAR_LOG_DEBUG);
            $this->_storeForecast(
                $this->aForecastResults,
                $zoneId,
                $intervalId,
                $aInterval,
                $latestAvailableActualImpressionsForZone
            );
        } else {
            // Use the default value as the new forecast, and note that the forecast is so based
            OA::debug("  - Forecasting for zone $zoneId for OI $intervalId (starting '" . $aInterval['start']->format('%Y-%m-%d %H:%M:%S') .
                      ' ' . $aInterval['start']->tz->getShortName() . "') based on default value", PEAR_LOG_DEBUG);
            $this->_storeForecast(
                $this->aForecastResults,
                $zoneId,
                $intervalId,
                $aInterval,
                $this->oDal->getZoneForecastDefaultZoneImpressions(),
                true
            );
        }
    }

    /**
     * A private method to store forecast values into an array in the format
     * required by the OA_Dal_Maintenance_Priority::saveZoneImpressionForecasts()
     * method; and to also store forecast values back into an array of history
     * information, so that the newly calculated forecast can be used for
     * future forecasting calculations.
     *
     * @access private
     * @param array   $aForecastResults A reference to an array to store forecast data in for use by
     *                                  the OA_Dal_Maintenance_Priority::saveZoneImpressionForecasts()
     *                                  method.
     * @param array   $aZFAIH           A reference to an array to store forecast data in for use in
     *                                  future forecasting calculations.
     * @param integer $zoneId           The zone ID the forecast is for.
     * @param integer $intervalId       The operation interval ID the forecast is for.
     * @param array   $aInterval        An array containing indexes "start" and "end", being
     *                                  the start and end dates of the operation interval,
     *                                  respectively.
     * @param integer $forecast         The forecast value for the zone/operation interval.
     * @param boolean $estimated        True if the forecast is based on the default, false otherwise.
     * @return void
     */
    function _storeForecast(&$aForecastResults, $zoneId, $intervalId, $aInterval, $forecast, $estimated = false)
    {
        $aForecastResults[$zoneId][$intervalId] = array(
            'forecast_impressions' => $forecast,
            'interval_start'       => $aInterval['start']->format('%Y-%m-%d %H:%M:%S'),
            'interval_end'         => $aInterval['end']->format('%Y-%m-%d %H:%M:%S'),
            'est'                  => $estimated ? 1 : 0
        );
    }
}

