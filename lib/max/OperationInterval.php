<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
| For contact details, see: http://www.openads.org/                         |
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
require_once 'Date.php';

/**
 * A library class for providing methods to work with Operation Intervals.
 *
 * @static
 * @package    Max
 * @author     Andrew Hill <andrew@m3.net>
 */
class MAX_OperationInterval
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
            // Operation interval is less often than once an hour
            if (($oi % 60) != 0) {
                // Operation interval must be a multiple of 60 minutes
                $error = 'The operation interval of ' . $oi . ' is invalud';
                return MAX::raiseError($error, MAX_ERROR_INVALIDOPERATIONINT);
            }
            if ($oi > 1440) {
                // Operation interval must not be more than one week (24 * 60 = 1440 minutes)
                $error = 'The operation interval of ' . $oi . ' is invalud';
                return MAX::raiseError($error, MAX_ERROR_INVALIDOPERATIONINT);
            }
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
            $operationInterval = MAX_OperationInterval::getOperationInterval();
        }
        // Ensure the dates are in the same week
        if ($oStart->getYear() != $oEnd->getYear()) {
            return false;
        }
        if ($oStart->getWeekOfYear() != $oEnd->getWeekOfYear()) {
            return false;
        }
        // Find the operation interval ID of the start date
        $startID = MAX_OperationInterval::convertDateToOperationIntervalID($oStart, $operationInterval);
        // Find the operation interval ID of the end date
        $endID = MAX_OperationInterval::convertDateToOperationIntervalID($oEnd, $operationInterval);
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
            $operationInterval = MAX_OperationInterval::getOperationInterval();
        }
        $days = $oDate->getDayOfWeek();
        $hours = $oDate->getHour();
        $minutes = $oDate->getMinute();
        $totalMinutes = ($days * 24 * 60) + ($hours * 60) + $minutes;
        return(floor($totalMinutes / $operationInterval));
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
     * @return array An array of the start and end Dates of the operation interval.
     */
    function convertDateToOperationIntervalStartAndEndDates($oDate, $operationInterval = 0)
    {
        if ($operationInterval < 1) {
            $operationInterval = MAX_OperationInterval::getOperationInterval();
        }
        // Get the date representing the start of the week
        $oStartOfWeek = new Date(Date_Calc::beginOfWeek($oDate->getDay(), $oDate->getMonth(), $oDate->getYear(), '%Y-%m-%d 00:00:00'));
        // Get the operation interval ID of the date
        $operationIntervalID = MAX_OperationInterval::convertDateToOperationIntervalID($oDate, $operationInterval);
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
        $aResult = MAX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oDate, $operationInterval);
        // Subtract one second from the start Date
        $oNewDate = new Date();
        $oNewDate->copy($aResult['start']);
        $oNewDate->subtractSeconds(1);
        // Return the result from the new date
        return MAX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oNewDate, $operationInterval);
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
        $aResult = MAX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oDate, $operationInterval);
        // Subtract one second from the start Date
        $oNewDate = new Date();
        $oNewDate->copy($aResult['end']);
        $oNewDate->addSeconds(1);
        // Return the result from the new date
        return MAX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oNewDate, $operationInterval);
    }

    /**
     * A method to find the previous operation interval ID.
     *
     * @static
     * @param integer $operationIntervalID The operation interval ID.
     * @param integer $operationInterval Optional length of the operation interval
     *                                   in minutes. If not given, will use the
     *                                   currently defined operation interval.
     * @return integer The previous operation interval ID.
     */
    function previousOperationIntervalID($operationIntervalID, $operationInterval = 0)
    {
        if ($operationInterval < 1) {
            $operationInterval = MAX_OperationInterval::getOperationInterval();
        }
        if ($operationIntervalID == 0) {
            return ((MINUTES_PER_WEEK / $operationInterval) - 1);
        } else {
            return ($operationIntervalID - 1);
        }
    }

    /**
     * A method to find the next operation interval ID.
     *
     * @static
     * @param integer $operationIntervalID The operation interval ID.
     * @param integer $operationInterval Optional length of the operation interval
     *                                   in minutes. If not given, will use the
     *                                   currently defined operation interval.
     * @return integer The next operation interval ID.
     */
    function nextOperationIntervalID($operationIntervalID, $operationInterval = 0)
    {
        if ($operationInterval < 1) {
            $operationInterval = MAX_OperationInterval::getOperationInterval();
        }
        if ($operationIntervalID == ((MINUTES_PER_WEEK / $operationInterval) - 1)) {
            return 0;
        } else {
            return ($operationIntervalID + 1);
        }
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
            $operationInterval = MAX_OperationInterval::getOperationInterval();
        }
        if ($operationInterval <= 60) {
            // Must ensure that only one operation interval is being summarised
            $operationIntervalID = MAX_OperationInterval::convertDateRangeToOperationIntervalID($oStart, $oEnd, $operationInterval);
            if (is_bool($operationIntervalID) && !$operationIntervalID) {
                return false;
            }
            // Now check that the start and end dates match the start and end
            // of the operation interval
            $aDates = MAX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oStart, $operationInterval);
            if (!$oStart->equals($aDates['start'])) {
                return false;
            }
            if (!$oEnd->equals($aDates['end'])) {
                return false;
            }
        } else {
            // Must ensure that only one hour is being summarised
            if (!MAX_OperationInterval::checkDatesInSameHour($oStart, $oEnd)) {
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
        return (60 * MAX_OperationInterval::getOperationInterval());
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
        return (SECONDS_PER_DAY / MAX_OperationInterval::secondsPerOperationInterval());
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
        return (7 * MAX_OperationInterval::operationIntervalsPerDay());
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
        $operationIntervalSeconds = (MAX_OperationInterval::getOperationInterval() * 60);

        // Get timestamp of start date/time - in seconds
        $startDateSeconds = mktime($oStartDate->getHour(), $oStartDate->getMinute(),
            $oStartDate->getSecond(), $oStartDate->getMonth(),
            $oStartDate->getDay(), $oStartDate->getYear());

        // Get timestamp of end date/time - in seconds
        $endDateSeconds = mktime($oEndDate->getHour(), $oEndDate->getMinute(),
            $oEndDate->getSecond(), $oEndDate->getMonth(),
            $oEndDate->getDay(), $oEndDate->getYear());

        // calculate interval length in seconds
        $interval = $endDateSeconds - $startDateSeconds;

        // find number of operation intervals during interval
        return ($interval <= 0) ? 0 : round($interval / $operationIntervalSeconds);
    }

}

?>
