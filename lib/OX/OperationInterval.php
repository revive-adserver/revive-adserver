<?php

/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
*/

require_once MAX_PATH . '/lib/OA/ServiceLocator.php';
require_once MAX_PATH . '/lib/pear/Date.php';

/**
 * A library class for providing methods to work with Operation Intervals.
 *
 * @static
 * @package    OpenX
 * @author     Andrew Hill <andrew.hill@openx.org>
 */
class OX_OperationInterval
{

    /**
     * A class to test if an operation interval value is valid.
     *
     * @static
     * @param integer $oi The operation interval value in minutes.
     * @param mixed True if the operation interval value is valid, a {@link PEAR_Error}
     *              object with error type MAX_ERROR_INVALIDOPERATIONINT otherwise.
     */
    function checkOperationIntervalValue($oi)
    {
        if ($oi < 1) {
            // Operation interval must be at least every minute
            $error = 'The operation interval of ' . $oi . ' is invalud';
            return MAX::raiseError($error, MAX_ERROR_INVALIDOPERATIONINT);
        } elseif ($oi < 60) {
            // Operation interval is more often than once an hour
            if ((60 % $oi) != 0) {
                // Operation interval must be a factor of 60 minutes
                $error = 'The operation interval of ' . $oi . ' is invalud';
                return MAX::raiseError($error, MAX_ERROR_INVALIDOPERATIONINT);
            }
        } elseif ($oi > 60) {
            // Operation interval must not be more than 60
            $error = 'The operation interval of ' . $oi . ' is invalud';
            return MAX::raiseError($error, MAX_ERROR_INVALIDOPERATIONINT);
        }
        return true;
    }

    /**
     * A method to convert a date range (in the form of two Dates)
     * and return the operation interval ID represented by the range, or
     * false if the date range spans more than one operation interval ID.
     *
     * @static
     * @param Date $oStart The start date of the date range.
     * @param Date $oEnd The end date of the date range.
     * @param integer $operationInterval Optional length of the operation interval
     *                                   in minutes. If not given, will use the
     *                                   currently defined operation interval.
     * @return mixed The operation interval ID as an integer, or false if the date
     *               range spans more than one operation interval.
     */
    function convertDateRangeToOperationIntervalID($oStart, $oEnd, $operationInterval = 0)
    {
        if ($operationInterval < 1) {
            $operationInterval = OX_OperationInterval::getOperationInterval();
        }
        $oStartCopy = new Date($oStart);
        $oStartCopy->toUTC();
        $oEndCopy = new Date($oEnd);
        $oEndCopy->toUTC();
        // Ensure the dates are in the same week
        if ($oStartCopy->getYear() != $oEndCopy->getYear()) {
            return false;
        }
        if ($oStartCopy->getWeekOfYear() != $oEndCopy->getWeekOfYear()) {
            return false;
        }
        // Find the operation interval ID of the start date
        $startID = OX_OperationInterval::convertDateToOperationIntervalID($oStartCopy, $operationInterval);
        // Find the operation interval ID of the end date
        $endID = OX_OperationInterval::convertDateToOperationIntervalID($oEndCopy, $operationInterval);
        // Compare the two IDs
        if ($startID != $endID) {
            return false;
        }
        return $startID;
    }

    /**
     * A method to convert a Date object into the appropriate operation
     * interval ID (of the week).
     *
     * Works by finding out how many days, hours, minutes into the week the time is, and
     * then converting that into how many minutes into the week the time is. This value
     * is then divided by the interval length (in minutes) to determine how many intervals
     * into the week the time is.
     *
     * @static
     * @param Date $oDate The date to convert.
     * @param integer $operation_interval Optional length of the operation interval
     *                                    in minutes. If not given, will use the
     *                                    currently defined operation interval.
     * @return integer The operation interval ID that the time is in.
     */
    function convertDateToOperationIntervalID($oDate, $operationInterval = 0)
    {
        if ($operationInterval < 1) {
            $operationInterval = OX_OperationInterval::getOperationInterval();
        }
        // Convert to UTC
        $oDateCopy = new Date($oDate);
        $oDateCopy->toUTC();
        $days = $oDateCopy->getDayOfWeek();
        $hours = $oDateCopy->getHour();
        $minutes = $oDateCopy->getMinute();
        $totalMinutes = ($days * 24 * 60) + ($hours * 60) + $minutes;
        return (int) (floor($totalMinutes / $operationInterval));
    }

    /**
     * This method gets the start date for next operation, assumming that
     * the operatio
     *
     * Simplicity and performance assumptions:
     * $oDate is in UTC
     *
     * @static
     * @param Date $oDate The date to convert
     * @param integer $operation_interval Optional length of the operation interval
     *                                    in minutes. If not given, will use the
     *                                    currently defined operation interval.
     * @param boolean $cacheResult  If true the data should be cached
     * @param Date $oDate
     */
    function addOperationIntervalTimeSpan($oDate, $operationInterval = null)
    {
        $oDateCopy = new Date($oDate);
        if (is_null($operationInterval)) {
            $operationInterval = OX_OperationInterval::getOperationInterval();
        }
        $oDateCopy->addSeconds($operationInterval * 60);
        return $oDateCopy;
    }

    /**
     * A method to convert a Date into an array containing the start
     * and end Dates of the operation interval that the date is in.
     *
     * @static
     * @param Date $oDate The date to convert.
     * @param integer $operation_interval Optional length of the operation interval
     *                                    in minutes. If not given, will use the
     *                                    currently defined operation interval.
     * @param boolean $cacheResult  If true the data should be cached
     * @return array An array of the start and end Dates of the operation interval.
     */
    function convertDateToOperationIntervalStartAndEndDates($oDate, $operationInterval = 0, $cacheResult = true)
    {
        // Convert to UTC
        $oDateCopy = new Date($oDate);
        $oDateCopy->toUTC();
        // Check cache
        static $aCache;
        if ($cacheResult && isset($aCache[$oDateCopy->getDate()][$operationInterval])) {
            $cachedDates = $aCache[$oDateCopy->getDate()][$operationInterval];
            $oStart = new Date($cachedDates['start']);
            $oStart->setTZbyID('UTC');
            $oEnd = new Date($cachedDates['end']);
            $oEnd->setTZbyID('UTC');
            return array(
                'start' => $oStart,
                'end'   => $oEnd
                );
        }
        if ($operationInterval < 1) {
            $operationInterval = OX_OperationInterval::getOperationInterval();
        }
        // Get the date representing the start of the week
        $oStartOfWeek = new Date(Date_Calc::beginOfWeek($oDateCopy->getDay(), $oDateCopy->getMonth(), $oDateCopy->getYear(), '%Y-%m-%d 00:00:00'));
        $oStartOfWeek->setTZbyID('UTC');
        // Get the operation interval ID of the date
        $operationIntervalID = OX_OperationInterval::convertDateToOperationIntervalID($oDateCopy, $operationInterval);
        // The start of the operation interval is the start of the week plus the
        // operation interval ID multiplied by the operation interval
        $oStart = new Date();
        $oStart->copy($oStartOfWeek);
        $oStart->addSeconds($operationIntervalID * $operationInterval * 60);
        // The end of the operation interval is the start of the week plus the
        // operation interval ID + 1 multiplied by the operation interval
        $oEnd = new Date();
        $oEnd->copy($oStart);
        $oEnd->addSeconds(($operationInterval * 60) - 1);
        // Cache result - cache as string to save memory
        if ($cacheResult) {
            $aCache[$oDate->getDate()][$operationInterval] = array(
                'start' => $oStart->getDate(),
                'end'   => $oEnd->getDate(),
            );
        }
        // Return the result
        return array('start' => $oStart, 'end' => $oEnd);
    }

    /**
     * A method to convert a Date into an array containing the start
     * and end Dates of the operation interval before the operation
     * interval that the date is in.
     *
     * @static
     * @param Date $oDate The date to convert.
     * @param integer $operationInterval Optional length of the operation interval
     *                                   in minutes. If not given, will use the
     *                                   currently defined operation interval.
     * @return array An array of the start and end Dates of the operation interval.
     */
    function convertDateToPreviousOperationIntervalStartAndEndDates($oDate, $operationInterval = 0)
    {
        // Get the start and end Dates of the operation interval that
        // contains the current date
        $aResult = OX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oDate, $operationInterval);
        // Subtract one second from the start Date
        $oNewDate = new Date();
        $oNewDate->copy($aResult['start']);
        $oNewDate->subtractSeconds(1);
        // Return the result from the new date
        return OX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oNewDate, $operationInterval);
    }

    /**
     * A method to convert a Date into an array containing the start
     * and end Dates of the operation interval after the operation
     * interval that the date is in.
     *
     * @static
     * @param Date $oDate The date to convert.
     * @param integer $operationInterval Optional length of the operation interval
     *                                   in minutes. If not given, will use the
     *                                   currently defined operation interval.
     * @return array An array of the start and end Dates of the operation interval.
     */
    function convertDateToNextOperationIntervalStartAndEndDates($oDate, $operationInterval = 0)
    {
        // Get the start and end Dates of the operation interval that
        // contains the current date
        $aResult = OX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oDate, $operationInterval);
        // Subtract one second from the start Date
        $oNewDate = new Date();
        $oNewDate->copy($aResult['end']);
        $oNewDate->addSeconds(1);
        // Return the result from the new date
        return OX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oNewDate, $operationInterval);
    }

    /**
     * A method to find the previous operation interval ID.
     *
     * @static
     * @param integer $operationIntervalID The operation interval ID.
     * @param integer $operationInterval Optional length of the operation interval
     *                                   in minutes. If not given, will use the
     *                                   currently defined operation interval.
     * @param integer $intervals The number of intervals to go back. Default is 1.
     * @return integer The previous operation interval ID.
     */
    function previousOperationIntervalID($operationIntervalID, $operationInterval = null, $intervals = 1)
    {
        // Set the operation interval length, if required
        if (is_null($operationInterval)) {
            $operationInterval = OX_OperationInterval::getOperationInterval();
        }
        // Go backward the required number of intervals
        $newOperationIntervalID = $operationIntervalID - $intervals;
        // Have we passed the end?
        $highestIntervalID = (MINUTES_PER_WEEK / $operationInterval) - 1;
        if ($newOperationIntervalID < 0) {
            $newOperationIntervalID = $highestIntervalID - ($intervals - $operationIntervalID) + 1;
        }
        return $newOperationIntervalID;
    }

    /**
     * A method to find the next operation interval ID.
     *
     * @static
     * @param integer $operationIntervalID The operation interval ID.
     * @param integer $operationInterval Optional length of the operation interval
     *                                   in minutes. If not given, will use the
     *                                   currently defined operation interval.
     * @param integer $intervals The number of intervals to go forward. Default is 1.
     * @return integer The next operation interval ID.
     */
    function nextOperationIntervalID($operationIntervalID, $operationInterval = null, $intervals = 1)
    {
        // Set the operation interval length, if required
        if (is_null($operationInterval)) {
            $operationInterval = OX_OperationInterval::getOperationInterval();
        }
        // Go forward the required number of intervals
        $newOperationIntervalID = $operationIntervalID + $intervals;
        // Have we passed the end?
        $highestIntervalID = (MINUTES_PER_WEEK / $operationInterval) - 1;
        if ($newOperationIntervalID > $highestIntervalID) {
            $newOperationIntervalID = $highestIntervalID - $operationIntervalID;
        }
        return $newOperationIntervalID;
    }

    /**
     * A method to check that a Date represents the start of an operation
     * interval.
     *
     * @static
     * @param Date    $oDate             The date to test.
     * @param integer $operationInterval Optional length of the operation interval
     *                                   in minutes. If not given, will use the
     *                                   currently defined operation interval.
     * @return bool Returns true if the date is an operation interval start date,
     *              false otherwise.
     */
    function checkDateIsStartDate($oDate, $operationInterval = null)
    {
        // Set the operation interval length, if required
        if (is_null($operationInterval)) {
            $operationInterval = OX_OperationInterval::getOperationInterval();
        }
        // Get the start/end dates for the operation interval the supplied
        // date is in
        $oDateCopy = new Date();
        $oDateCopy->copy($oDate);
        $aDates = OX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oDateCopy, $operationInterval);
        // Do the start dates match?
        if ($oDate->equals($aDates['start'])) {
            return true;
        }
        return false;
    }

    /**
     * A method to check that a Date represents the end of an operation
     * interval.
     *
     * @static
     * @param Date    $oDate             The date to test.
     * @param integer $operationInterval Optional length of the operation interval
     *                                   in minutes. If not given, will use the
     *                                   currently defined operation interval.
     * @return bool Returns true if the date is an operation interval end date,
     *              false otherwise.
     */
    function checkDateIsEndDate($oDate, $operationInterval = null)
    {
        // Set the operation interval length, if required
        if (is_null($operationInterval)) {
            $operationInterval = OX_OperationInterval::getOperationInterval();
        }
        // Get the start/end dates for the operation interval the supplied
        // date is in
        $oDateCopy = new Date();
        $oDateCopy->copy($oDate);
        $aDates = OX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oDateCopy, $operationInterval);
        // Do the start dates match?
        if ($oDate->equals($aDates['end'])) {
            return true;
        }
        return false;
    }

    /**
     * A method to ensure that a Date range is in the same hour.
     *
     * @static
     * @param Date $start The start date to check.
     * @param Date $end The end date to check.
     * @return boolean Returns true if the dates are in the same hour, false otherwise.
     */
    function checkDatesInSameHour($start, $end)
    {
        if ($start->getYear() != $end->getYear()) {
            return false;
        }
        if ($start->getMonth() != $end->getMonth()) {
            return false;
        }
        if ($start->getDay() != $end->getDay()) {
            return false;
        }
        if ($start->getHour() != $end->getHour()) {
            return false;
        }
        return true;
    }

    /**
     * A method to check that two Dates represent either the start and end
     * of an operation interval, if the operation interval is less than an
     * hour, or the start and end of an hour otherwise.
     *
     * @static
     * @param Date $oStart The interval start date.
     * @param Date $oEnd The interval end date.
     * @param integer $operationInterval The operation interval in minutes.
     * @return bool Returns true if the dates are correct interval
     *              start/end dates, false otherwise.
     */
    function checkIntervalDates($oStart, $oEnd, $operationInterval = 0)
    {
        if ($operationInterval < 1) {
            $operationInterval = OX_OperationInterval::getOperationInterval();
        }
        if ($operationInterval <= 60) {
            // Must ensure that only one operation interval is being summarised
            $operationIntervalID = OX_OperationInterval::convertDateRangeToOperationIntervalID($oStart, $oEnd, $operationInterval);
            if (is_bool($operationIntervalID) && !$operationIntervalID) {
                return false;
            }
            // Now check that the start and end dates match the start and end
            // of the operation interval
            $aDates = OX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oStart, $operationInterval);
            if (!$oStart->equals($aDates['start'])) {
                return false;
            }
            if (!$oEnd->equals($aDates['end'])) {
                return false;
            }
        } else {
            // Must ensure that only one hour is being summarised
            if (!OX_OperationInterval::checkDatesInSameHour($oStart, $oEnd)) {
                return false;
            }
            // Now check that the start and end dates are match the start and
            // end of the hour
            $oHourStart = new Date();
            $oHourStart->copy($oStart);
            $oHourStart->setMinute('00');
            $oHourStart->setSecond('00');
            $oHourEnd = new Date();
            $oHourEnd->copy($oEnd);
            $oHourEnd->setMinute('59');
            $oHourEnd->setSecond('59');
            if (!$oStart->equals($oHourStart)) {
                return false;
            }
            if (!$oEnd->equals($oHourEnd)) {
                return false;
            }
        }
        return true;
    }

     /**
     * A method to return the operation interval value set in global ini file.
     *
     * @static
     * @return integer The value of the operation interval value from the
     *                 global ini file.
     */
    function getOperationInterval() {
        return $GLOBALS['_MAX']['CONF']['maintenance']['operationInterval'];
    }

    /**
     * A method to return the number of seconds per opertaion interval.
     *
     * @static
     * @return integer The number of seconds per operation interval.
     */
    function secondsPerOperationInterval()
    {
        return (60 * OX_OperationInterval::getOperationInterval());
    }

    /**
     * A method to return the number of operation intervals
     * during per day.
     *
     * @static
     * @return integer The number of operation intervals per day.
     */
    function operationIntervalsPerDay()
    {
        return (SECONDS_PER_DAY / OX_OperationInterval::secondsPerOperationInterval());
    }

    /**
     * A method to return the number of operation intervals
     * during per day.
     *
     * @static
     * @return integer The number of operation intervals per week.
     */
    function operationIntervalsPerWeek()
    {
        return (7 * OX_OperationInterval::operationIntervalsPerDay());
    }

    /**
     * A method to get the number of operation intervals in a given
     * start & end date range must be valid OI start & end date range
     *
     * @static
     * @param object $oStartDate PEAR::Date object
     * @param object $oEndDate PEAR::Date object
     * @return integer number of operation intervals remaining
     */
    function getIntervalsRemaining($oStartDate, $oEndDate)
    {
        $operationIntervalSeconds = (OX_OperationInterval::getOperationInterval() * 60);

        // Convert to UTC
        $oStartCopy = new Date($oStartDate);
        $oStartCopy->toUTC();
        $oEndCopy = new Date($oEndDate);
        $oEndCopy->toUTC();

        // Get timestamp of start date/time - in seconds
        $startDateSeconds = mktime($oStartCopy->getHour(), $oStartCopy->getMinute(),
            $oStartCopy->getSecond(), $oStartCopy->getMonth(),
            $oStartCopy->getDay(), $oStartCopy->getYear());

        // Get timestamp of end date/time - in seconds
        $endDateSeconds = mktime($oEndCopy->getHour(), $oEndCopy->getMinute(),
            $oEndCopy->getSecond(), $oEndCopy->getMonth(),
            $oEndCopy->getDay(), $oEndCopy->getYear());

        // calculate interval length in seconds
        $interval = $endDateSeconds - $startDateSeconds;

        // find number of operation intervals during interval
        return ($interval <= 0) ? 0 : round($interval / $operationIntervalSeconds);
    }

}

?>