<?php

/*
+---------------------------------------------------------------------------+
| Max Media Manager v0.3                                                    |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2006 m3 Media Services Limited                         |
| For contact details, see: http://www.m3.net/                              |
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

require_once MAX_PATH . '/lib/max/core/ServiceLocator.php';
require_once MAX_PATH . '/lib/max/Maintenance/Priority/AdServer/Task.php';
require_once MAX_PATH . '/lib/max/Maintenance/Priority/Entities.php';
require_once 'Date.php';

// Number of weeks to average actual impressions
// for in order to obtain the baseline impression forecast
define("ZONE_FORECAST_BASELINE_WEEKS", 2);
// Set the number of operation intervals to offset the trend calculation view
define("ZONE_FORECAST_TREND_OFFSET", 1);
// Set the number of operation intervals to use for the trend calculation view
define("ZONE_FORECAST_TREND_OPERATION_INTERVALS", 16);

/**
 * A class used to forecast the expected number of impressions in each
 * operation interval, for each zone.
 *
 * @package    MaxMaintenance
 * @subpackage Priority
 * @author     Andrew Hill <andrew@m3.net>
 * @author     Demain Turner <demian@m3.net>
 * @author     James Floyd <james@m3.net>
 */
class ForecastZoneImpressions extends MAX_Maintenance_Priority_AdServer_Task
{

    var $conf;
    var $oDateNow;
    var $oUpdateToDate;
    var $mtceStatsLastRun;
    var $mtcePriorityLastRun;

    /**
     * The constructor method.
     */
    function ForecastZoneImpressions()
    {
        parent::MAX_Maintenance_Priority_AdServer_Task();
        $this->conf = $GLOBALS['_MAX']['CONF'];
        $oServiceLocator = &ServiceLocator::instance();
        $this->oDateNow = &$oServiceLocator->get('now');
        if (!$this->oDateNow) {
            $this->oDateNow = new Date();
        }
        $aDates = MAX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($this->oDateNow);
        $this->oUpdateToDate = $aDates['end'];
        $this->mtceStatsLastRun    = new MtceStatsLastRun();
        $this->mtcePriorityLastRun = new MtcePriorityLastRun();
    }

    /**
     * The main method of the class, that is run by the controlling
     * task runner class.
     */
    function run()
    {
        MAX::debug('Starting to Forecast Zone Impressions.', PEAR_LOG_DEBUG);
        $oStartDate = new Date();
        // Determine type of update required
        if ($type = $this->getUpdateTypeRequired()) {
            // Get the operation interval ID range(s) that need to be updated
            $aRanges = $this->getOperationIntRangeByType($type);
            foreach ($aRanges as $range) {
                // Update the zone impression forecasts for each operation
                // interval in the range being updated
                $this->doForecast($range);
            }
            // Record the completion of the task in the database
            MAX::debug('Recording completion of the Forecast Zone Impressions task', PEAR_LOG_DEBUG);
            $oEndDate = new Date();
            $this->oDal->setMaintenancePriorityLastRunInfo($oStartDate, $oEndDate, $this->oUpdateToDate, DAL_PRIORITY_UPDATE_ZIF);
        }
    }

    /**
     * A method that determins which (if any) operation intervals need to have their
     * forecast impression values updated. Returns true for 'update forcast for all
     * operation intervals', false for 'do not update any operation intervals', or
     * returns a range of operation intervals to update.
     *
     * @return mixed Whether or not to update at least some zone impression forecasts
     *          - true:  Update all zone impression forecasts
     *          - false: Don't update any zone impression forecasts
     *          - array: An array with the start and end operation interval IDs of the
     *                   range to update; the first may be higher than the second, in
     *                   the event that the range spans from one week into the next
     */
    function getUpdateTypeRequired()
    {
        MAX::debug('Calculating range of operation intervals which require ZIF update', PEAR_LOG_DEBUG);
        // Set default return value
        $ret = false;
        if (is_null($this->mtceStatsLastRun->oUpdatedToDate)) {
            // mtceStatsLastRun date is null, there are no stats, update all so new install can run: return true
            MAX::debug('No previous maintenance statisitcs run, so update all required', PEAR_LOG_DEBUG);
            // Not safe to simply insert data, otherwise multiple rows may result
            $ret = true;
        } elseif (is_null($this->mtcePriorityLastRun->oUpdatedToDate)) {
            // mtcePriorityLastRun date is null, priority has never been run before, update all: return true
            MAX::debug('No previous maintenance priority run, so update all required', PEAR_LOG_DEBUG);
            $ret = true;
        } elseif (MAX_OperationInterval::getOperationInterval() != $this->mtcePriorityLastRun->operationInt) {
            // The operation interval has changed since the last run, force an update all: return true
            MAX::debug('Operation interval length change since last run, so update all required', PEAR_LOG_DEBUG);
            $ret = true;
        } else {
            // If stats was run after priority, then the maintenance stats updated to date will be equal to,
            // or after, the maintenance priority updated to date (as the maintenance priority updated to
            // date is one operation interval ahead of where statistics is)
            if ($this->mtceStatsLastRun->oUpdatedToDate->equals($this->mtcePriorityLastRun->oUpdatedToDate) ||
                $this->mtceStatsLastRun->oUpdatedToDate->after($this->mtcePriorityLastRun->oUpdatedToDate)) {
                // If a week or more has passed since the last priority update, update all: return true
                $oSpan = new Date_Span();
                $oUpdatedToDateCopy = new Date();
                $oUpdatedToDateCopy->copy($this->mtcePriorityLastRun->oUpdatedToDate);
                $oDateNowCopy = new Date();
                $oDateNowCopy->copy($this->oDateNow);
                $oSpan->setFromDateDiff($oUpdatedToDateCopy, $oDateNowCopy);
                if ($oSpan->day >= 7) {
                    MAX::debug('One week passed since last run, so update all required', PEAR_LOG_DEBUG);
                    $ret = true;
                } else {
                    // Get the operation intervals for each run
                    $statsOpIntId = MAX_OperationInterval::convertDateToOperationIntervalID($this->mtceStatsLastRun->oUpdatedToDate);
                    $priorityOpIntId = MAX_OperationInterval::convertDateToOperationIntervalID($this->mtcePriorityLastRun->oUpdatedToDate);
                    // Always predict one interval ahead of the statistics engine
                    $statsOpIntId = MAX_OperationInterval::nextOperationIntervalID($statsOpIntId, 1);
                    // As long as the operation intervals are not in the same interval, priority should be run
                    if ($statsOpIntId != $priorityOpIntId) {
                        MAX::debug('Found range to update', PEAR_LOG_DEBUG);
                        $ret = array($priorityOpIntId, $statsOpIntId);
                    } else {
                        MAX::debug('Update range is simply current interval, so no update required', PEAR_LOG_DEBUG);
                        $ret = false;
                    }
                }
            }
        }
        return $ret;
    }

    /**
     * Returns the range of operation intervals to be updated.
     *
     * @param mixed $type The update type required. Possible values are the same as
     *                    those returned from the {@link ForecastZoneImpressions::getUpdateTypeRequired()}
     *                    method.
     * @return array An array of hashes where keys are operation interval IDs, and
     *               values are date strings. One element in the array indicates a
     *               contiguous range, two elements indicate a non-contiguous range.
     */
    function getOperationIntRangeByType($type)
    {
        // Initialise result array
        $aRes = array();
        switch (true) {
            case is_bool($type) && $type === true:
                // Update all - need one week's worth of operation intervals up until the end
                // of the operation interval *after* the one that statistics have been updated
                // to, as we need to predict one interval ahead of now
                $oStatsDates =
                    MAX_OperationInterval::convertDateToNextOperationIntervalStartAndEndDates($this->oDateNow);
                $oStartDate = $oStatsDates['start'];
                $oStartDate->subtractSeconds(SECONDS_PER_WEEK);
                $startId = MAX_OperationInterval::convertDateToOperationIntervalID($oStartDate);
                $totalIntervals = MAX_OperationInterval::operationIntervalsPerWeek();
                break;

            case is_array($type) && ($type[0] < $type[1]):
                // A contiguous (ie. inter-week) range, where the first operation interval
                // ID is the lower bound, and the second operation interval ID is the upper
                // The start operation interval ID is the operation interval ID right after
                // the operation interval ID that priority was updated to (ie. $type[0])
                $aDates = MAX_OperationInterval::convertDateToNextOperationIntervalStartAndEndDates($this->mtcePriorityLastRun->oUpdatedToDate);
                $oStartDate = $aDates['start'];
                $startId = MAX_OperationInterval::nextOperationIntervalID($type[0], 1);
                $totalIntervals = $type[1] - $type[0];
                break;

            case is_array($type) && ($type[0] > $type[1]):
                // A non-contiguous range, so calculate as above, but use the first operation
                // interval ID as the upper bound, and the second operation interval ID as the
                // lower bound in the proceeding week
                // The start operation interval ID is the operation interval ID right after
                // the operation interval ID that priority was updated to (ie. $type[0])
                $aDates = MAX_OperationInterval::convertDateToNextOperationIntervalStartAndEndDates($this->mtcePriorityLastRun->oUpdatedToDate);
                $oStartDate = $aDates['start'];
                $startId = MAX_OperationInterval::nextOperationIntervalID($type[0], 1);
                $totalIntervals = (MAX_OperationInterval::operationIntervalsPerWeek() - $type[0]) +  $type[1];
                break;

            default:
                PEAR::popErrorHandling(null);
                $aRes = PEAR::raiseError('Unexpected parameters');
                PEAR::pushErrorHandling();
        }
        // Build the update range array
        $aRange = array();
        $totalIntervalPerWeek = MAX_OperationInterval::operationIntervalsPerWeek();
        for ($x = $startId, $y = 0; $y < $totalIntervals; $x++, $y++) {
            if ($x == $totalIntervalPerWeek) {
               $x = 0;
            }
            $aDates = array();
            $aDates['start'] = $oStartDate->format('%Y-%m-%d %H:%M:%S');
            $oEndDate = new Date($oStartDate);
            $oEndDate->addSeconds(MAX_OperationInterval::secondsPerOperationInterval());
            $oEndDate->subtractSeconds(1);
            $aDates['end'] = $oEndDate->format('%Y-%m-%d %H:%M:%S');
            unset($oEndDate);
            $aRange[$x] = $aDates;
            $oStartDate->addSeconds(MAX_OperationInterval::secondsPerOperationInterval());
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
                $aRes[] = $aRange1;
                $aRes[] = $aRange2;
                return $aRes;
            }
        }
        $aRes[] = $aRange;
        return $aRes;
    }

    /**
     * The method that performs the zone impression forecasting.
     *
     * For each operation interval that needs to be updated, the expected impressions
     * for each zone are calculated via the following algorithm:
     *
     * - If the zone has been operational for at least two weeks (i.e. the zone has
     *   actual impressions for the past two occurrences of the same operation interval
     *   as is currently being updated), then the expected impressions value is the average
     *   of the past two operation intervals' actual impressions of that zone, multiplied
     *   by a moving average trend value. The moving average trend value is the actual
     *   number of zone impressions in the previous operation interval for that zone,
     *   divided by the forecast number of zone impressions in the previous operation
     *   interval for that zone.
     * - Else, if the zone has not been operational for at least two weeks, then the
     *   expected impressions is set to the actual number of impressions in the
     *   previous operation interval for that zone.
     * - Else the previous operation interval for that zone does not have an actual
     *   number of impressions, then the expected number of impressions for that
     *   zone is set to $conf[priority][defaultZoneForecastImpressions].
     *
     * @param array An array of the range of operation intervals that need the
     *              forecast to be updated.
     * @return mixed One of:
     *                  - False if no forecasts updated.
     *                  - True if forecasts updated successfully.
     *                  - A PEAR Error object is there was an error.
     */
    function doForecast($range)
    {
        // Check the parameter
        if (!is_array($range) || (is_array($range) && (count($range) == 0))) {
            return false;
        }
        // Obtain an array of all the active zones
        $aZones = $this->getActiveZones();
        // If no active zones - return false
        if (count($aZones) == 0) {
            return false;
        }
        // Get start dates representing range start & end
        $tmp = array_keys($range);
        $min = min($tmp);
        $max = max($tmp);
        $oStartDate = new Date($range[$min]['start']);
        $oEndDate = new Date($range[$max]['start']);
        // Get average impressions and assign to Zone array of intervals
        $res = $this->setZonesImpressionAverage($aZones, $oStartDate, $oEndDate);
        if (PEAR::isError($res)) {
              return $res;
        }
        // Get recorded active impressions, and forecast impressions (if exists)
        // for all zones for given OI range
        if (is_array($aZones)) {
            // Convert all Zone object id values for use in DB query
            foreach ($aZones as $oZone) {
                $aZoneIds[] = $oZone->id;
            }
            // Get start dates of start and end of trend range
            $oTrendStartDate = $this->getTrendStartDate($oStartDate);
            $oTrendEndDate = $this->getTrendEndDate($oEndDate);
            // Get forecast and actual impression data for trend range
            $aImpressionsResults =
                $this->oDal->getZonesImpressionHistoryByRange(
                    $aZoneIds,
                    $oTrendStartDate,
                    $oTrendEndDate
                );
            //$aImpressionsResults = Array
            //(
            //    [zone_id] => Array
            //        (
            //            [operation_interval_id] => Array
            //                (
            //                    [zone_id] => 1
            //                    [operation_interval_id] => 1
            //                    [forecast_impressions] => 200
            //                    [actual_impressions] => 300
            //                )
            //
            //            [operation_interval_id] => Array
            //                (
            //                    [zone_id] => 1
            //                    [operation_interval_id] => 2
            //                    [forecast_impressions] => 300
            //                    [actual_impressions] => 400
            //                )
            //        )
            //)
            if (PEAR::isError($aImpressionsResults)) {
                return $aImpressionsResults;
            }
            foreach ($aZones as $key => $oZone) {
                foreach ($range as $intervalId => $aInterval) {
                    // Get trend range in terms of operation ID
                    $offetStartOperationId =
                        MAX_OperationInterval::previousOperationIntervalID(
                            $intervalId,
                            $this->getTrendOperationIntervalStartOffset()
                        );
                    // Set actual impressions and forecast values to zero
                    $actualImpressions = 0;
                    $forecastImpressions = 0;
                    // For current zone & operation interval loop associated trend data
                    for ($i = 0; $i < ZONE_FORECAST_TREND_OPERATION_INTERVALS; $i++) {
                        // If data from trend interval does not exist then do not calculate for this interval
                        if (!isset($aImpressionsResults[$oZone->id][$offetStartOperationId])) {
                            $actualImpressions = false;
                            $forecastImpressions = false;
                            break;
                        }
                        // Sum actual impressions for trend interval
                        $actualImpressions += $aImpressionsResults[$oZone->id][$offetStartOperationId]['actual_impressions'];
                        // Sum forecast - if no forecast data set impressions to be ignored
                        if ($aImpressionsResults[$oZone->id][$offetStartOperationId]['forecast_impressions'] < 1) {
                            $forecastImpressions = false;
                        } elseif ($forecastImpressions !== false) {
                            $forecastImpressions += $aImpressionsResults[$oZone->id][$offetStartOperationId]['forecast_impressions'];
                        }
                        // Get next trend operation ID in this trend range
                        $offetStartOperationId = MAX_OperationInterval::nextOperationIntervalID($offetStartOperationId);
                    }
                    // Calculate trend average actual impressions for range
                    if ($actualImpressions !== false) {
                        $actualAverage = round($actualImpressions / ZONE_FORECAST_TREND_OPERATION_INTERVALS);
                        // Store trend actual impressions average in Zone object
                        $aZones[$key]->setIntervalIdImpressionActual($intervalId, $actualAverage);
                    }
                    // Calculate trend average forecast impressions
                    if ($forecastImpressions !== false) {
                        $forecastAverage = ($forecastImpressions / ZONE_FORECAST_TREND_OPERATION_INTERVALS);
                        // Store trend forecast value in Zone object
                        $aZones[$key]->setIntervalIdImpressionForecast($intervalId, $forecastAverage);
                    }
                    // Store the actual impression for the previous operation interval
                    $previousIntervalID = MAX_OperationInterval::previousOperationIntervalID($intervalId);
                    if (isset($aImpressionsResults[$oZone->id][$previousIntervalID]['actual_impressions'])) {
                        $aZones[$key]->pastActualImpressions =
                            $aImpressionsResults[$oZone->id][$previousIntervalID]['actual_impressions'];
                    }
                    // Calculate zone forcast using calculated data
                    $forecastResults[$oZone->id][$intervalId]['forecast_impressions'] =
                        $this->calculateForecast($aZones[$key], $intervalId);
                    $forecastResults[$oZone->id][$intervalId]['interval_start'] = $aInterval['start'];
                    $forecastResults[$oZone->id][$intervalId]['interval_end'] = $aInterval['end'];
                    // Update main DB results set to include forecast so its available in subsequent iterations
                    $aImpressionsResults[$oZone->id][$intervalId]['forecast_impressions'] =
                        $forecastResults[$oZone->id][$intervalId]['forecast_impressions'];
                }
            }
            $this->oDal->saveZoneImpressionForecasts($forecastResults);
        }
        unset($aZones);
        unset($aImpressionsResults);
        unset($forecastResults);
        return true;
    }

    /**
     * Method to calculate zone forecast value considering the values of
     * average impressions, average trend forecast impressions, average
     * trend actual impressions, and past operation interval actual
     * impressions, for a given operation interval ID.
     *
     * @return integer
     */
    function calculateForecast($oZone, $id)
    {
        // Does the average impressions value exist?
        if (isset($oZone->aOperationIntId[$id]['averageImpressions'])) {
            // YES
            // Do average trend forecast impressions & actual impressions exist, and
            // is the average trend forecast impression value > 0?
            if (isset($oZone->aOperationIntId[$id]['forecastImpressions']) &&
                isset($oZone->aOperationIntId[$id]['actualImpressions']) &&
                ($oZone->aOperationIntId[$id]['forecastImpressions'] > 0)) {
                // YES
                $trendValue =
                    $oZone->aOperationIntId[$id]['actualImpressions'] / $oZone->aOperationIntId[$id]['forecastImpressions'];
                $ret = $oZone->aOperationIntId[$id]['averageImpressions'] * $trendValue;
             } else {
                // NO
                $ret = $oZone->aOperationIntId[$id]['averageImpressions'];
             }
        } else {
            // NO
            // Does the past operation interval actual impressions value exist?
            if (isset($oZone->pastActualImpressions) && ($oZone->pastActualImpressions > 0)) {
                // YES
                // Set the forecast value to the past operation interval actual
                // impressons value
                $ret = $oZone->pastActualImpressions;
            } else {
                // NO
                // Set the forecast value to $conf[priority][defaultZoneForecastImpressions]
                $ret = $this->conf['priority']['defaultZoneForecastImpressions'];
            }
        }
        return round($ret);
    }

    /**
     * Method to return an array of zones objects representing
     * all active zones
     *
     * @return array of Zone objects
     * @access public
     * @todo change new Zone to pass array of properties
     *
     * OUTPUT
     * Array =
     *     (
     *         [0] => Object Zone,
     *         [1] => Object Zone,
     *         [2] => Object Zone,
     *     )
     */
    function getActiveZones()
    {
        $aZones = array();
        $aActiveZones = $this->oDal->getActiveZones();
        if (is_array($aActiveZones) && (count($aActiveZones) > 0)) {
            foreach ($aActiveZones as $aZone) {
                $aZones[] = new Zone($aZone);
            }
        }
        return $aZones;
    }

    /**
     * Method to resolve zone impression average for each operation
     * interval in date rage.  Average calculated using zone data
     * from the same operation interval in previous weeks.
     *
     * The number of previous week to be considered is defined by
     * ZONE_FORECAST_BASELINE_WEEKS.  Both PEAR::Date objects defining
     * the date range to be evaluated should be a valid start of
     * operation interval
     *
     * @param array $aZones zone IDs to be considered
     * @param object $oStartdDate Date start of range to be evaluated
     * @param object $oEndDate Date end of range to be evaluated
     * @return void
     * @access public
     *
     * INPUT
     *     $aZones = Array =
     *     (
     *         [0] => Object Zone,
     *         [1] => Object Zone,
     *         [2] => Object Zone,
     *     )
     *
     *     $oStartdDate = PEAR::Date object
     *     $oEndDate = PEAR::Date object
     *
     *  <pre>
     * $aAverageImpressions =  Array =>
     *      [zone_id] => Array
     *          (
     *              [operation_interval_id] => Array
     *                  (
     *                      ['average_impressions'] => Average Impressions
     *                  )
     *              [operation_interval_id] => Array
     *                  (
     *                      ['average_impressions'] => Average Impressions
     *                  )
     *          )
     *      [zone_id] => Array
     *          (
     *              [operation_interval_id] => Array
     *                  (
     *                      ['average_impressions'] => Average Impressions
     *                  )
     *              [operation_interval_id] => Array
     *                  (
     *                      ['average_impressions'] => Average Impressions
     *                  )
     *          )
     *  </pre>
     */
    function setZonesImpressionAverage(&$aZones, $oStartDate, $oEndDate)
    {
        if (is_array($aZones) && (count($aZones))) {
            foreach ($aZones as $oZone) {
                $aZoneIds[] = $oZone->id;
            }
            // Get average impressions for zones
            $aAverageImpressions = $this->oDal->getZonesImpressionAverageByRange(
                $aZoneIds,
                $oStartDate,
                $oEndDate,
                ZONE_FORECAST_BASELINE_WEEKS
            );
            if (PEAR::isError($aAverageImpressions)) {
                return $aAverageImpressions;
            }
        }
        // Assign values to zone objects
         foreach ($aZones as $key => $oZone) {
            // Assign average impressions to each zone
            if (isset($aAverageImpressions[$oZone->id])) {
                $this->_setZoneIntervalIdImpressionAverage(
                    $aZones[$key],
                    $aAverageImpressions[$oZone->id]
                );
            }
        }
    }

    /**
     * Method to set Zone object average_impressions by operation interval id
     */
    function _setZoneIntervalIdImpressionAverage(&$oZone, $aResults)
    {
        if (is_array($aResults) && (count($aResults))) {
            foreach($aResults as $intervalId => $aValues) {
                $oZone->setIntervalIdImpressionAverage(
                    $intervalId,
                    $aValues['average_impressions']
                );
            }
        }
    }

    /**
     * Method to return the number of operation intervals to offset
     * to the start of the trend range group...?  WHAT?
     */
    function getTrendOperationIntervalStartOffset()
    {
        return (ZONE_FORECAST_TREND_OFFSET + ZONE_FORECAST_TREND_OPERATION_INTERVALS - 1);
    }

    function getTrendStartDate($oStartDate)
    {
        $seconds = $this->getTrendOperationIntervalStartOffset() * MAX_OperationInterval::secondsPerOperationInterval();
        $oStartDate->subtractSeconds($seconds);
        return $oStartDate;
    }

    function getTrendEndDate($oEndDate)
    {
        $seconds = ZONE_FORECAST_TREND_OFFSET * MAX_OperationInterval::secondsPerOperationInterval();
        $oEndDate->subtractSeconds($seconds);
        return $oEndDate;
    }

}

/**
 * A class used to represent the last time the MPE process ran.
 *
 * @package    MaxMaintenance
 * @subpackage Priority
 * @author     Demain Turner <demian@m3.net>
 * @author     James Floyd <james@m3.net>
 *
 * @TODO Get rid of this class, and find a cleaner way to get the data.
 */
class MtcePriorityLastRun
{
    var $oUpdatedToDate;
    var $operationInt;

    function MtcePriorityLastRun()
    {
        $oDal = &$this->_getDal();
        $aData = $oDal->getMaintenancePriorityLastRunInfo(DAL_PRIORITY_UPDATE_ZIF);
        $this->oUpdatedToDate = (is_null($aData['updated_to'])) ? null : new Date($aData['updated_to']);
        $this->operationInt = $aData['operation_interval'];
    }

    function &_getDal()
    {
        $oServiceLocator = &ServiceLocator::instance();
        $oDal = $oServiceLocator->get('MAX_Dal_Maintenance_Priority');
        if (!$oDal) {
            $oDal = new MAX_Dal_Maintenance_Priority();
            $oServiceLocator->register('MAX_Dal_Maintenance_Priority', $oDal);
        }
        return $oDal;
    }
}

/**
 * A class used to represent the last time the MSE process ran.
 *
 * @package    MaxMaintenance
 * @subpackage Priority
 * @author     Demain Turner <demian@m3.net>
 * @author     James Floyd <james@m3.net>
 *
 * @TODO Get rid of this class, and find a cleaner way to get the data.
 */
class MtceStatsLastRun
{
    var $oUpdatedToDate;
    var $runType;

    function MtceStatsLastRun()
    {
        $oDal = &$this->_getDal();
        $aData = $oDal->getMaintenanceStatisticsLastRunInfo();
        $this->oUpdatedToDate = (is_null($aData['updated_to'])) ? null : new Date($aData['updated_to']);
        $this->runType = $aData['adserver_run_type'];
    }

    function &_getDal()
    {
        $oServiceLocator = &ServiceLocator::instance();
        $oDal = $oServiceLocator->get('MAX_Dal_Maintenance_Priority');
        if (!$oDal) {
            $oDal = new MAX_Dal_Maintenance_Priority();
            $oServiceLocator->register('MAX_Dal_Maintenance_Priority', $oDal);
        }
        return $oDal;
    }
}

?>
