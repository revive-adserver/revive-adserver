<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
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

require_once MAX_PATH . '//lib/OA/Maintenance/Priority/Zone.php';

require_once MAX_PATH . '/lib/OA.php';
require_once MAX_PATH . '/lib/OA/Maintenance/Priority/AdServer/Task.php';
require_once MAX_PATH . '/lib/OA/ServiceLocator.php';
require_once MAX_PATH . '/lib/pear/Date.php';

// Number of weeks to average actual impressions
// for in order to obtain the baseline impression forecast
if (!defined('ZONE_FORECAST_BASELINE_WEEKS')) {
    define('ZONE_FORECAST_BASELINE_WEEKS', 2);
}
// Set the number of operation intervals to offset the trend calculation view
if (!defined('ZONE_FORECAST_TREND_OFFSET')) {
    define('ZONE_FORECAST_TREND_OFFSET', 1);
}
// Set the number of operation intervals to use for the trend calculation view
if (!defined('ZONE_FORECAST_TREND_OPERATION_INTERVALS')) {
    define('ZONE_FORECAST_TREND_OPERATION_INTERVALS', 16);
}
// Set the default number of impressions to use as a forecast value when there
// is simply no other data to use for calculation of forecasts, based on an
// operation interval of 60 minutes (the value will be reduced for smaller
// operation intervals)
if (!defined('ZONE_FORECAST_DEFAULT_ZONE_IMPRESSIONS')) {
    define('ZONE_FORECAST_DEFAULT_ZONE_IMPRESSIONS', 1000);
}
// Set the minimum value of an operation interval's zone impression forecast,
// even when using operation intervals less than 60 minutes
if (!defined('ZONE_FORECAST_DEFAULT_ZONE_IMPRESSIONS_MINIMUM')) {
    define('ZONE_FORECAST_DEFAULT_ZONE_IMPRESSIONS_MINIMUM', 10);
}

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
     * A date representing the date to which the Maintenance Statistics Engine
     * has most recently updated statistics to; when null, the MSE has never run.
     *
     * @var PEAR::Date
     */
    var $oStatisticsUpdatedToDate;

    /**
     * A date representing the date to which the Maintenance Priority Engine
     * has most recently updated zone impression forecast values to; when null,
     * the MPE has never run.
     *
     * @var PEAR::Date
     */
    var $oPriorityUpdatedToDate;

    /**
     * The Operation Interval value that was in use the last time that the
     * MPE ran.
     *
     * @var integer
     */
    var $priorityOperationInterval;

    /**
     * An array of all the active zone IDs in the system, including the
     * special "direct selection" zone ID 0.
     *
     * @var array
     */
    var $aActiveZoneIDs;

    /**
     * An array of all active zone IDs in the system, including the
     * special "direct selection" zone ID 0, where the zones currently
     * do not have *any* past ZIF values.
     *
     * @var array
     */
    var $aNewZoneIDs;

    /**
     * An array of all active zone IDs in the system, including the
     * special "direct selection" zone ID 0, where the zones currently
     * have used the default forecast value within the previous week.
     *
     * @var array
     */
    var $aRecentZoneIDs;

    /**
     * An array to store the complete set of "last week" operation
     * interval ranges that require being updated, in the event that
     * the ZIF update is NOT for the complete last week, but there is
     * at least one new zone that DOES require the complete last
     * week to be updated.
     *
     * @var array
     */
    var $aFullWeekRanges;

    /**
     * An array to store details of newly calculated ZIF data.
     *
     * @var array
     */
    var $aForecastResults;

    /**
     * An array to store details of any zones with previous ZIF
     * data based on the default value that need to be updated
     * with newer "past" estimates, to allow Zone Patterning
     * to operation in a meaningful way for newly created zones.
     *
     * @var array
     */
    var $aPastForecastResults;

    /**
     * A store of the default zone forecast value, as appropriate
     * to the current operation interval length (the constant
     * ZONE_FORECAST_DEFAULT_ZONE_IMPRESSIONS is defined for an
     * operation interval of 60 minutes).
     *
     * @var integer
     */
    var $ZONE_FORECAST_DEFAULT_ZONE_IMPRESSIONS;

    /**
     * The constructor method.
     */
    function OA_Maintenance_Priority_AdServer_Task_ForecastZoneImpressions()
    {
        parent::OA_Maintenance_Priority_AdServer_Task();
        // Store the configuration array
        $this->aConf = $GLOBALS['_MAX']['CONF'];
        // Get the current "now" time from the OA_ServiceLocator,
        // or set it if required
        $oServiceLocator =& OA_ServiceLocator::instance();
        $this->oDateNow =& $oServiceLocator->get('now');
        if (!$this->oDateNow) {
            $this->oDateNow = new Date();
            $oServiceLocator->register('now', $this->oDateNow);
        }
        // Set the date to update ZIF values until - that is, the end of the
        // current operation interval
        $aDates = OA_OperationInterval::convertDateToOperationIntervalStartAndEndDates($this->oDateNow);
        $this->oUpdateToDate = $aDates['end'];
        // Obtain the information about the last MSE run
        $aData = $this->oDal->getMaintenanceStatisticsLastRunInfo();
        $this->oStatisticsUpdatedToDate = (is_null($aData['updated_to'])) ? null : new Date($aData['updated_to']);
        // Obtain the information about the last MPE run
        $aData = $this->oDal->getMaintenancePriorityLastRunInfo(DAL_PRIORITY_UPDATE_ZIF);
        $this->oPriorityUpdatedToDate = (is_null($aData['updated_to'])) ? null : new Date($aData['updated_to']);
        $this->priorityOperationInterval = $aData['operation_interval'];
        // Prepare the list of all active zones in the system
        $this->aActiveZoneIDs = $this->_getActiveZonesIDs();
        // Set other zone ID arrays to empty arrays
        $this->aNewZoneIDs = array();
        $this->aRecentZoneIDs = array();
        // Set the results arrays to an empty arrays
        $this->aForecastResults = array();
        $this->aPastForecastResults = array();
        // Set the default forecast value
        $multiplier = $this->aConf['maintenance']['operationInterval'] / 60;
        $this->ZONE_FORECAST_DEFAULT_ZONE_IMPRESSIONS = (int) round(ZONE_FORECAST_DEFAULT_ZONE_IMPRESSIONS * $multiplier);
        if ($this->ZONE_FORECAST_DEFAULT_ZONE_IMPRESSIONS < ZONE_FORECAST_DEFAULT_ZONE_IMPRESSIONS_MINIMUM) {
            $this->ZONE_FORECAST_DEFAULT_ZONE_IMPRESSIONS = ZONE_FORECAST_DEFAULT_ZONE_IMPRESSIONS_MINIMUM;
        }
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
        OA::debug('Running Maintenance Priority Engine: Zone Impression Forecast Update', PEAR_LOG_DEBUG);
        $oStartDate = new Date();
        // Determine type of update required
        $type = $this->_getUpdateTypeRequired();
        // Are we updating the ZIF values for all operation intervals?
        if ($type !== true) {
            // No, only updating the ZIF values for some operation intervals,
            // so, need to check to see if there are any active zones in the
            // system that do NOT have any ZIF values yet (ie. they are newly
            // added zones that need to be fully updated) or if there are
            // any active zones that have used the default forecast value at
            // any point in the past week (ie. recently added zones that need
            // to have their past forecast values updated so that Zone Patterning
            // will not allocate impressions on the basis of the default forecast
            $this->aNewZoneIDs = $this->oDal->getNewZones($this->aActiveZoneIDs);
            if (PEAR::isError($this->aNewZoneIDs)) {
                OA::debug('- Error retrieving new zone list, exiting', PEAR_LOG_CRIT);
                exit();
            }
            $this->aRecentZoneIDs = $this->oDal->getRecentZones($this->aActiveZoneIDs, $this->oDateNow);
            if (PEAR::isError($this->aRecentZoneIDs)) {
                OA::debug('- Error retrieving recent zone list, exiting', PEAR_LOG_CRIT);
                exit();
            }
            // If there are new zones found, then the "complete last week" range of
            // operation intervals will be needed for these zones - prepare this
            // range now, in advance of it being needed
            $this->aFullWeekRanges = $this->_getOperationIntervalRanges(true);
        }
        // Convert the required update type into an array of operation interval ID
        // ranges, being the operation interval IDs where all zones require their
        // ZIF values to be udpated
        $aRanges = $this->_getOperationIntervalRanges($type);
        // For every active zone in the system...
        foreach ($this->aActiveZoneIDs as $zoneId) {
            // ... calculate that zone's ZIF data as required
            OA::debug("- Calculating the ZIF data for Zone ID $zoneId", PEAR_LOG_DEBUG);
            // Is this a new zone?
            if (in_array($zoneId, $this->aNewZoneIDs)) {
                // Calculate the ZIF values for the complete last week, as this
                // new zone won't have any ZIF information, even if the MPE has
                // previously been run
                OA::debug("  - Found as new zone, updating for complete week", PEAR_LOG_DEBUG);
                $aUseRanges =& $this->aFullWeekRanges;
            } else {
                // Calculate the ZIF values for just the required ranges, if present
                $aUseRanges =& $aRanges;
            }
            $this->_calculateZoneImpressionForecastValues($zoneId, $aUseRanges);
            // ... and also calculate the zone's new "past" ZIF update data, if required
            if (in_array($zoneId, $this->aRecentZoneIDs)) {
                $this->_calculatePastZoneImpressionForecastValues($zoneId);
            }
        }
        // Save any ZIF data that has been calculated
        if (!empty($this->aForecastResults)) {
            $this->oDal->saveZoneImpressionForecasts($this->aForecastResults);
        }
        // Update any "past" ZIF data for recently created zones that has been calculated
        if (!empty($this->aPastForecastResults)) {
            // Calcuate the date from which to update the "past" ZIF values
            $aDates = OA_OperationInterval::convertDateToOperationIntervalStartAndEndDates($this->oDateNow);
            $oPastStartDate = new Date();
            $oPastStartDate->copy($aDates['start']);
            $oPastStartDate->subtractSeconds(SECONDS_PER_WEEK - OA_OperationInterval::secondsPerOperationInterval());
            $this->oDal->updatePastZoneImpressionForecasts($this->aPastForecastResults, $oPastStartDate);
        }
        // Record the completion of the task in the database
        OA::debug('- Recording completion of the Forecast Zone Impressions task', PEAR_LOG_DEBUG);
        $oEndDate = new Date();
        $this->oDal->setMaintenancePriorityLastRunInfo($oStartDate, $oEndDate, $this->oUpdateToDate, DAL_PRIORITY_UPDATE_ZIF);
    }

    /**
     * A private method that determines which (if any) operation intervals need the zone
     * impression forecast values to be updated for ALL zones.
     *
     * @access private
     * @return mixed One of the following three values will be returned, depending on what
     *               ZIF values need to be updated:
     *          - true:  Update the ZIF values for all operation intervals.
     *          - false: No ZIF values need to be updated (eg. this is the second, or greater,
     *                   time that the MPE has been run in this operation interval, so there
     *                   are no new statistics values summarised by the MSE to allow the ZIF
     *                   values to be udpated).
     *          - array: An array with the start and end operation interval IDs of the
     *                   range to update; the first may be higher than the second, in
     *                   the event that the range spans from the end of one week into the
     *                   start of the next week.
     */
    function _getUpdateTypeRequired()
    {
        OA::debug('- Calculating range of operation intervals which require ZIF update', PEAR_LOG_DEBUG);
        // Set default return value
        $return = false;
        if (is_null($this->oStatisticsUpdatedToDate)) {
            // The MSE has never been run; there are no stats. Update all operation intervals (with the
            // default zone forecast value) so that this new installation of OpenX can ran: return true
            OA::debug('  - No previous maintenance statisitcs run, so update all OIs required', PEAR_LOG_DEBUG);
            $return = true;
        } elseif (is_null($this->oPriorityUpdatedToDate)) {
            // The MPE has never updated zone forecasts before. Update all operation intervals (with the
            // default zone forecast value) so that this new installation of OpenX can ran: return true
            OA::debug('  - No previous maintenance priority run, so update all OIs required', PEAR_LOG_DEBUG);
            $return = true;
        } elseif (OA_OperationInterval::getOperationInterval() != $this->priorityOperationInterval) {
            // The operation interval has changed since the last run, force an update all: return true
            OA::debug('  - OPERATION INTERVAL LENGTH CHANGE SINCE LAST RUN', PEAR_LOG_DEBUG);
            OA::debug('  - Update of all OIs required', PEAR_LOG_DEBUG);
            $return = true;
        } else {
            // If stats was run after priority, then the maintenance stats updated to date will be equal to,
            // or after, the maintenance priority updated to date (as the maintenance priority updated to
            // date is one operation interval ahead of where statistics is)
            if ($this->oStatisticsUpdatedToDate->equals($this->oPriorityUpdatedToDate) ||
                $this->oStatisticsUpdatedToDate->after($this->oPriorityUpdatedToDate)) {
                // If a week or more has passed since the last priority update, update all: return true
                $oSpan = new Date_Span();
                $oUpdatedToDateCopy = new Date();
                $oUpdatedToDateCopy->copy($this->oPriorityUpdatedToDate);
                $oDateNowCopy = new Date();
                $oDateNowCopy->copy($this->oDateNow);
                $oSpan->setFromDateDiff($oUpdatedToDateCopy, $oDateNowCopy);
                if ($oSpan->day >= 7) {
                    OA::debug('  - One week has passed since last run, so update all OIs required', PEAR_LOG_DEBUG);
                    $return = true;
                } else {
                    // Get the operation intervals for each run
                    $statsOpIntId = OA_OperationInterval::convertDateToOperationIntervalID($this->oStatisticsUpdatedToDate);
                    $priorityOpIntId = OA_OperationInterval::convertDateToOperationIntervalID($this->oPriorityUpdatedToDate);
                    // Always predict one interval ahead of the statistics engine
                    $statsOpIntId = OA_OperationInterval::nextOperationIntervalID($statsOpIntId, 1);
                    // As long as the operation intervals are not in the same interval, priority should be run
                    if ($statsOpIntId != $priorityOpIntId) {
                        OA::debug('  - Found OI range to update', PEAR_LOG_DEBUG);
                        $return = array($priorityOpIntId, $statsOpIntId);
                    } else {
                        OA::debug('  - MPE has already run this operation interval, no ZIF update required', PEAR_LOG_DEBUG);
                        $return = false;
                    }
                }
            }
        }
        return $return;
    }

    /**
     * A private method to convert the ZIF update type from _getUpdateTypeRequired() into
     * a range of operation intervals where all zones require their ZIF values to be updated.
     *
     * @access private
     * @param mixed $type The update type required. Possible values are the same as
     *                    those returned from the
     *                    {@link OA_Maintenance_Priority_AdServer_Task_ForecastZoneImpressions::getUpdateTypeRequired()}
     *                    method.
     * @return array An array of hashes where keys are operation interval IDs, and
     *               values are PEAR Dates. One element in the array indicates a
     *               contiguous range, two elements indicate a non-contiguous range.
     */
    function _getOperationIntervalRanges($type)
    {
        // Initialise result array
        $aResult = array();
        switch (true) {
            case is_bool($type) && $type === false:
                // Update none, return an empty array
                return $aResult;

            case is_bool($type) && $type === true:
                // Update all - need one week's worth of operation intervals up until the end
                // of the operation interval *after* the one that statistics have been updated
                // to, as we need to predict one interval ahead of now
                $oStatsDates =
                    OA_OperationInterval::convertDateToNextOperationIntervalStartAndEndDates($this->oDateNow);
                $oStartDate = new Date();
                $oStartDate->copy($oStatsDates['start']);
                $oStartDate->subtractSeconds(SECONDS_PER_WEEK);
                $startId = OA_OperationInterval::convertDateToOperationIntervalID($oStartDate);
                $totalIntervals = OA_OperationInterval::operationIntervalsPerWeek();
                break;

            case is_array($type) && ($type[0] < $type[1]):
                // A contiguous (ie. inter-week) range, where the first operation interval
                // ID is the lower bound, and the second operation interval ID is the upper
                // The start operation interval ID is the operation interval ID right after
                // the operation interval ID that priority was updated to (ie. $type[0])
                $aDates = OA_OperationInterval::convertDateToNextOperationIntervalStartAndEndDates($this->oPriorityUpdatedToDate);
                $oStartDate = $aDates['start'];
                $startId = OA_OperationInterval::nextOperationIntervalID($type[0], 1);
                $totalIntervals = $type[1] - $type[0];
                break;

            case is_array($type) && ($type[0] > $type[1]):
                // A non-contiguous range, so calculate as above, but use the first operation
                // interval ID as the upper bound, and the second operation interval ID as the
                // lower bound in the proceeding week
                // The start operation interval ID is the operation interval ID right after
                // the operation interval ID that priority was updated to (ie. $type[0])
                $aDates = OA_OperationInterval::convertDateToNextOperationIntervalStartAndEndDates($this->oPriorityUpdatedToDate);
                $oStartDate = $aDates['start'];
                $startId = OA_OperationInterval::nextOperationIntervalID($type[0], 1);
                $totalIntervals = (OA_OperationInterval::operationIntervalsPerWeek() - $type[0]) +  $type[1];
                break;

            default:
                OA::debug(
                    'OA_Maintenance_Priority_AdServer_Task_ForecastZoneImpressions::getOperationIntRangeByType() called with unexpected type, exiting',
                    PEAR_LOG_CRIT
                );
                exit();

        }
        // Build the update range array
        $aRange = array();
        $totalIntervalPerWeek = OA_OperationInterval::operationIntervalsPerWeek();
        for ($x = $startId, $y = 0; $y < $totalIntervals; $x++, $y++) {
            if ($x == $totalIntervalPerWeek) {
               $x = 0;
            }
            $aDates = array();
            $aDates['start'] = new Date($oStartDate); //->format('%Y-%m-%d %H:%M:%S');
            $oEndDate = new Date();
            $oEndDate->copy($oStartDate);
            $oEndDate->addSeconds(OA_OperationInterval::secondsPerOperationInterval() - 1);
            $aDates['end'] = $oEndDate; //->format('%Y-%m-%d %H:%M:%S');
            unset($oEndDate);
            $aRange[$x] = $aDates;
            $oStartDate->addSeconds(OA_OperationInterval::secondsPerOperationInterval());
        }
        // Is the update range array a contiguous (inter-weeek) range?
        if (array_key_exists($totalIntervalPerWeek - 1, $aRange) &&
            array_key_exists(0, $aRange)) {
            // The range contains the first and the last operation interval IDs, is the
            // last date before the first date?
            $oFirstIntervalStartDate = new Date($aRange[0]['start']);
            $oLastIntervalStartDate  = new Date($aRange[$totalIntervalPerWeek - 1]['start']);
            if ($oLastIntervalStartDate->before($oFirstIntervalStartDate)) {
                // It's a non-contiguous range, so split into two ranges
                $aRange1 = array();
                $aRange2 = array();
                for ($x = $startId; $x < $totalIntervalPerWeek; $x++) {
                    $aRange1[$x] = $aRange[$x];
                }
                for ($x = 0; $x < $startId; $x++) {
                    if (isset($aRange[$x])) {
                        $aRange2[$x] = $aRange[$x];
                    }
                }
                $aResult[] = $aRange1;
                $aResult[] = $aRange2;
                return $aResult;
            }
        }
        $aResult[] = $aRange;
        return $aResult;
    }

    /**
     * A private method that calcualtes the ZIF value(s) for a given zone.
     *
     * For each operation interval that requires the zone's ZIF value to be updated,
     * the ZIF value for the zone is calculated via the following algorithm:
     *
     * - If the zone has been operational for at least ZONE_FORECAST_BASELINE_WEEKS weeks
     *   (i.e. the zone has actual impressions for the past ZONE_FORECAST_BASELINE_WEEKS
     *   occurrences of the same operation interval as is currently being updated), then
     *   the expected impressions value is the average of the past two operation intervals'
     *   actual impressions of the zone, multiplied by a moving average trend value.
     * - Else, if the zone has not been operational for at least
     *   ZONE_FORECAST_BASELINE_WEEKS weeks, then the expected impressions is set to the
     *   actual number of impressions in the previous operation interval for that zone.
     * - Else the previous operation interval for that zone does not have an actual
     *   number of impressions, then the expected number of impressions for that
     *   zone is set to ZONE_FORECAST_DEFAULT_ZONE_IMPRESSIONS.
     *
     * Note also:
     *  - If the zone ID exists in the $this->aNewZoneIDs array, then all operation
     *    intervals for the past week will be updated, not just those in $aRanges.
     *
     * @access private
     * @param integer $zoneId The ID of the zone which may require its ZIF value(s)
     *                        to be calculated.
     * @param array   $aRanges An array of arrays, containing ranges of operation
     *                         intervals that the zone will need its ZIF values
     *                         updated for.
     * @return void
     */
    function _calculateZoneImpressionForecastValues($zoneId, $aRanges)
    {
        // Check the parameters
        if (!is_integer($zoneId) || $zoneId < 0) {
            return;
        }
        if (!is_array($aRanges) || empty($aRanges)) {
            return;
        }
        // Update the ZIF for all ranges
        foreach ($aRanges as $aRange) {
            // Get the two dates representing operation interval start
            // dates for the two operation interval IDs at the lower and
            // upper bounds of the range
            $tmp = array_keys($aRange);
            $min = min($tmp);
            $max = max($tmp);
            $oRangeLowerDate = new Date();
            $oRangeLowerDate->copy($aRange[$min]['start']);
            $oRangeUpperDate = new Date();
            $oRangeUpperDate->copy($aRange[$max]['start']);
            // Get the average impressions delivered by the zone in previous
            // operation intervals, for the required operation interval range
            $aZoneImpressionAverages = $this->_getZoneImpressionAverages($zoneId, $oRangeLowerDate, $oRageUpperDate);
            // Get the details of all forecast and actual impressions of the
            // zone for the required operation interval range, offset by the
            // required time interval, so that current trends in differences
            // between forecast and actual delivery can be calculated
            $oTrendLowerDate = $this->_getTrendLowerDate($oRangeLowerDate);
            $oTrendUpperDate = $this->_getTrendUpperDate($oRangeUpperDate);
            $aZoneForecastAndImpressionHistory = $this->oDal->getZonePastForecastAndImpressionHistory($zoneId, $oTrendLowerDate, $oTrendUpperDate);
            foreach ($aRange as $intervalId => $aInterval) {
                if (!isset($aZoneImpressionAverages[$intervalId])) {
                    // This zone does not have a past average actual impressions delivered
                    // value for this operation interval ID, and so cannot have been running
                    // for longer than ZONE_FORECAST_BASELINE_WEEKS - as a result, either
                    // forecast the value based on the past operation interval's data, or
                    // use the default value
                    $previousIntervalID = OA_OperationInterval::previousOperationIntervalID($intervalId);
                    if (isset($aZoneForecastAndImpressionHistory[$previousIntervalID]['actual_impressions']) &&
                        ($aZoneForecastAndImpressionHistory[$previousIntervalID]['actual_impressions'] > 0)) {
                        // Use the previous operation interval's actual impressions value as the
                        // new forecast
                        OA::debug("  - Forecasting for OI $intervalId (starting '" . $aInterval['start']->format('%Y-%m-%d %H:%M:%S') .
                                  ' ' . $aInterval['start']->tz->getShortName() . "') based on previous OI value", PEAR_LOG_DEBUG);
                        $this->_storeForecast(
                            $this->aForecastResults,
                            $aZoneForecastAndImpressionHistory,
                            $zoneId,
                            $intervalId,
                            $aInterval,
                            $aZoneForecastAndImpressionHistory[$previousIntervalID]['actual_impressions']
                        );
                    } else {
                        // Use the default value as the new forecast, and note that the forecast
                        // is so based
                        OA::debug("  - Forecasting for OI $intervalId (starting '" . $aInterval['start']->format('%Y-%m-%d %H:%M:%S') .
                                  ' ' . $aInterval['start']->tz->getShortName() . "') based on default value", PEAR_LOG_DEBUG);
                        $this->_storeForecast(
                            $this->aForecastResults,
                            $aZoneForecastAndImpressionHistory,
                            $zoneId,
                            $intervalId,
                            $aInterval,
                            $this->ZONE_FORECAST_DEFAULT_ZONE_IMPRESSIONS,
                            true
                        );
                    }
                } else {
                    // Get the lower bound operation interval ID of the trend calculation
                    // range required for this operation interval ID
                    $offetOperationId = OA_OperationInterval::previousOperationIntervalID($intervalId, null, $this->_getTrendOperationIntervalStartOffset());
                    // Set the initial forecast and actual impressions values
                    $forecastImpressions = 0;
                    $actualImpressions   = 0;
                    // Loop over the trend adjustment range data appropriate to this operation
                    // interval ID, and sum up the forecast and actual impression values
                    for ($i = 0; $i < ZONE_FORECAST_TREND_OPERATION_INTERVALS; $i++) {
                        if (!isset($aZoneForecastAndImpressionHistory[$offetOperationId])) {
                            // The forecast/impression history of this zone is incomplete, so the
                            // trend adjustment information cannot be calculated
                            $forecastImpressions = false;
                            $actualImpressions   = false;
                            break;
                        }
                        // Sum the actual impression value for the current trend adjustment interval
                        if (!empty($aZoneForecastAndImpressionHistory[$offetOperationId]['actual_impressions'])) {
                            $actualImpressions += $aZoneForecastAndImpressionHistory[$offetOperationId]['actual_impressions'];
                        }
                        // Sum the forecast impression value for the current trend adjustment interval
                        if ($aZoneForecastAndImpressionHistory[$offetOperationId]['forecast_impressions'] < 1) {
                            // Ack, that's a bad forecast impression value - don't trust the data!
                            $forecastImpressions = false;
                            $actualImpressions   = false;
                            break;
                        }
                        $forecastImpressions += $aZoneForecastAndImpressionHistory[$offetOperationId]['forecast_impressions'];
                        // Go to the next operation ID in the trend range
                        $offetOperationId = OA_OperationInterval::nextOperationIntervalID($offetOperationId);
                    }
                    unset($forecastAverage);
                    if ($forecastImpressions !== false) {
                        // Calculate the average forecast impression value for the trend adjustment range
                        $forecastAverage = ($forecastImpressions / ZONE_FORECAST_TREND_OPERATION_INTERVALS);
                    }
                    unset($actualAverage);
                    if ($actualImpressions !== false) {
                        // Calculate the average actual impression value for the trend adjustment range
                        $actualAverage = round($actualImpressions / ZONE_FORECAST_TREND_OPERATION_INTERVALS);
                    }
                    if (isset($forecastAverage) && ($forecastAverage > 0) && isset($actualAverage)) {
                        // The past average forecast and actual impression values exist, so calculate the
                        // trend adjustment value, and calculate the new forecast from the past average and
                        // the trend adjustment value
                        OA::debug("  - Forecasting for OI $intervalId (starting '" . $aInterval['start']->format('%Y-%m-%d %H:%M:%S') .
                                  ' ' . $aInterval['start']->tz->getShortName() . "') based on past average and recent trend", PEAR_LOG_DEBUG);
                        $trendValue = $actualAverage / $forecastAverage;
                        $this->_storeForecast(
                            $this->aForecastResults,
                            $aZoneForecastAndImpressionHistory,
                            $zoneId,
                            $intervalId,
                            $aInterval,
                            $aZoneImpressionAverages[$intervalId] * $trendValue
                        );
                    } else {
                        // The trend data could not be calculated, so simply use the past average as the
                        // new forecast
                        OA::debug("  - Forecasting for OI $intervalId (starting '" . $aInterval['start']->format('%Y-%m-%d %H:%M:%S') .
                                  ' ' . $aInterval['start']->tz->getShortName() . "') based on past average only", PEAR_LOG_DEBUG);
                        $this->_storeForecast(
                            $this->aForecastResults,
                            $aZoneForecastAndImpressionHistory,
                            $zoneId,
                            $intervalId,
                            $aInterval,
                            $aZoneImpressionAverages[$intervalId]
                        );
                    }
                }
            }
        }
    }

    /**
     * A private method that calculates what the past ZIF value(s) for a given
     * zone should be updated to, in the event that the zone is a recently
     * created zone, so that Zone Patterning can work in a reasonable way.
     *
     * @access private
     * @param integer $zoneId The ID of the zone which may require its past ZIF
     *                        value(s) to be re-calculated.
     * @return void
     */
    function _calculatePastZoneImpressionForecastValues($zoneId)
    {
        // Check the parameters
        if (!is_integer($zoneId) || $zoneId < 0) {
            return;
        }
        // Get the average value, to date, of the actual impressions
        // delivered by this zone
        $newAverage = $this->oDal->getZonePastImpressionAverage($zoneId);
        if (!is_null($newAverage)) {
            $this->aPastForecastResults[$zoneId] = $newAverage;
        }
    }

    /**
     * A private method to calculate the operation interval start date at the
     * lower bound of a range of operation intervals that require a ZIF update,
     * where the lower bound has been set back by the required number of
     * operation intervals so that current trends in differences between
     * forecast and actual delivery can be calculated.
     *
     * @access private
     * @param PEAR::Date $oDate The start date of the operation interval at the
     *                          lower bound of the operation interval range
     *                          requiring a ZIF update.
     * @return PEAR::Date The new lower bound date.
     */
    function _getTrendLowerDate($oDate)
    {
        $seconds = $this->_getTrendOperationIntervalStartOffset() * OA_OperationInterval::secondsPerOperationInterval();
        $oDate->subtractSeconds($seconds);
        return $oDate;
    }

    /**
     * A private method to calculate the operation interval start date at the
     * upper bound of a range of operation intervals that require a ZIF update,
     * where the upper bound has been set back by the required number of
     * operation intervals so that current trends in differences between
     * forecast and actual delivery can be calculated.
     *
     * @access private
     * @param PEAR::Date $oDate The start date of the operation interval at the
     *                          upper bound of the operation interval range
     *                          requiring a ZIF update.
     * @return PEAR::Date The new upper bound date.
     */
    function _getTrendUpperDate($oDate)
    {
        $seconds = ZONE_FORECAST_TREND_OFFSET * OA_OperationInterval::secondsPerOperationInterval();
        $oDate->subtractSeconds($seconds);
        return $oDate;
    }

    /**
     * A private method to return the number of operation intervals by which
     * the lower bound of an operation interval range should be set back to
     * allow current trends in differences between forecast and actual delivery
     * to be calculated.
     *
     * @access private
     * @return integer The number of operation intervals for the trend offset.
     */
    function _getTrendOperationIntervalStartOffset()
    {
        return (ZONE_FORECAST_TREND_OFFSET + ZONE_FORECAST_TREND_OPERATION_INTERVALS - 1);
    }

    /**
     * A private metod to obtain a zone's average number of impressions per
     * operation interval, for a given range of operation interval IDs.
     *
     * The average is calculated from the values in the same operation interval
     * IDs from previous weeks to the operatin interval range supplied,
     * over ZONE_FORECAST_BASELINE_WEEKS weeks.
     *
     * If the zone does not have sufficient data to calculate the average over
     * the required number of past weeks, then no average value will be returned.
     *
     * @access private
     * @param integer $zoneId The zone ID to obtain the averages for.
     * @param PEAR::Date $oStartDate The start date/time of the operation interval
     *                               of the lower range of the operation interval
     *                               IDs to calculate the past average impressions
     *                               delivered for.
     * @param PEAR::Date $oEndDate The start date/time of the operation interval
     *                             of the upper range of the operation interval
     *                             IDs to calculate the past average impressions
     *                             delivered for.
     * @return array An array, indexed by operation interval IDs, containing the
     *               the average numer of impressions that the zone with ID
     *               $zoneId actually delivered in the past
     *               ZONE_FORECAST_BASELINE_WEEKS weeks in the same operatation
     *               interval IDs.
     */
    function _getZoneImpressionAverages($zoneId, $oStartDate, $oEndDate)
    {
        // Get average impressions for the zone
        $aZoneImpressionAverages = $this->oDal->getZonePastImpressionAverageByOI(
            $zoneId,
            $oStartDate,
            $oEndDate,
            ZONE_FORECAST_BASELINE_WEEKS
        );
        if (PEAR::isError($aZoneImpressionAverages)) {
            OA::debug("- Error retrieving zone ID $zoneId's average past impressions, exiting", PEAR_LOG_CRIT);
            exit();
        }
        return $aZoneImpressionAverages;
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
    function _storeForecast(&$aForecastResults, &$aZFAIH, $zoneId, $intervalId, $aInterval, $forecast, $estimated = false)
    {
        $aForecastResults[$zoneId][$intervalId] = array(
            'forecast_impressions' => $forecast,
            'interval_start'       => $aInterval['start']->format('%Y-%m-%d %H:%M:%S'),
            'interval_end'         => $aInterval['end']->format('%Y-%m-%d %H:%M:%S'),
            'est'                  => $estimated ? 1 : 0
        );
        $aZFAIH[$intervalId]['forecast_impressions'] = $forecast;
    }

}

?>