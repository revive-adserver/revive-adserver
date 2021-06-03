<?php

// The constant telling us what day starts the week. Monday (1) is the
// international standard. Redefine this to 0 if you want weeks to
// begin on Sunday.
if (!defined('DATE_CALC_BEGIN_WEEKDAY')) {
    define('DATE_CALC_BEGIN_WEEKDAY', 1);
}

/**
 * Date_Calc is a calendar class used to calculate and
 * manipulate calendar dates and retrieve dates in a calendar
 * format. It does not rely on 32-bit system date stamps, so
 * you can display calendars and compare dates that date
 * pre 1970 and post 2038.
 *
 * This source file is subject to version 2.02 of the PHP license,
 * that is bundled with this package in the file LICENSE, and is
 * available at through the world-wide-web at
 * http://www.php.net/license/2_02.txt.
 * If you did not receive a copy of the PHP license and are unable to
 * obtain it through the world-wide-web, please send a note to
 * license@php.net so we can mail you a copy immediately.
 *
 * Copyright (c) 1999, 2002, 2003 ispi
 *
 * @access public
 *
 * @version 1.2.6
 * @author Monte Ohrt <monte@ispi.net>
 */

class Date_Calc
{
    /**
     * Returns the current local date. NOTE: This function
     * retrieves the local date using strftime(), which may
     * or may not be 32-bit safe on your system.
     *
     * @param string the strftime() format to return the date
     *
     * @access public
     *
     * @return string the current date in specified format
     */

    public static function dateNow($format='%Y%m%d')
    {
        return(strftime($format,time()));

    } // end func dateNow

     /**
     * Returns true for valid date, false for invalid date.
     *
     * @param string year in format CCYY
     * @param string month in format MM
     * @param string day in format DD
     *
     * @access public
     *
     * @return boolean true/false
     */

    public static function isValidDate($day, $month, $year)
    {
        if ($year < 0 || $year > 9999) {
            return false;
        }
        if (!checkdate($month,$day,$year)) {
            return false;
        }

        return true;
    } // end func isValidDate

     /**
     * Returns true for a leap year, else false
     *
     * @param string year in format CCYY
     *
     * @access public
     *
     * @return boolean true/false
     */

    public static function isLeapYear($year='')
    {
        if (empty($year)) {
            $year = Date_Calc::dateNow('%Y');
        }

        if (preg_match('/\D/',$year)) {
            return false;
        }

        if ($year < 1000) {
            return false;
        }

        if ($year < 1582) {
            // pre Gregorio XIII - 1582
            return ($year % 4 == 0);
        } else {
            // post Gregorio XIII - 1582
            return ( (($year % 4 == 0) and ($year % 100 != 0)) or ($year % 400 == 0) );
        }
    } // end func isLeapYear

    /**
     * Determines if given date is a future date from now.
     *
     * @param string day in format DD
     * @param string month in format MM
     * @param string year in format CCYY
     *
     * @access public
     *
     * @return boolean true/false
     */

    public static function isFutureDate($day,$month,$year)
    {
        $this_year = Date_Calc::dateNow('%Y');
        $this_month = Date_Calc::dateNow('%m');
        $this_day = Date_Calc::dateNow('%d');

        if ($year > $this_year) {
            return true;
        } elseif ($year == $this_year) {
            if ($month > $this_month) {
                return true;
            } elseif ($month == $this_month) {
                if ($day > $this_day) {
                    return true;
                }
            }
        }

        return false;
    } // end func isFutureDate

    /**
     * Determines if given date is a past date from now.
     *
     * @param string day in format DD
     * @param string month in format MM
     * @param string year in format CCYY
     *
     * @access public
     *
     * @return boolean true/false
     */

    public static function isPastDate($day,$month,$year)
    {
        $this_year = Date_Calc::dateNow('%Y');
        $this_month = Date_Calc::dateNow('%m');
        $this_day = Date_Calc::dateNow('%d');

        if ($year < $this_year) {
            return true;
        } elseif ($year == $this_year) {
            if ($month < $this_month) {
                return true;
            } elseif ($month == $this_month) {
                if ($day < $this_day) {
                    return true;
                }
            }
        }

        return false;
    } // end func isPastDate

    /**
     * Returns day of week for given date, 0=Sunday
     *
     * @param string day in format DD, default is current local day
     * @param string month in format MM, default is current local month
     * @param string year in format CCYY, default is current local year
     *
     * @access public
     *
     * @return int $weekday_number
     */

    public static function dayOfWeek($day='',$month='',$year='')
    {
        if (empty($year)) {
            $year = Date_Calc::dateNow('%Y');
        }
        if (empty($month)) {
            $month = Date_Calc::dateNow('%m');
        }
        if (empty($day)) {
            $day = Date_Calc::dateNow('%d');
        }

        if ($month > 2) {
            $month -= 2;
        } else {
            $month += 10;
            $year--;
        }

        $day = ( floor((13 * $month - 1) / 5) +
            $day + ($year % 100) +
            floor(($year % 100) / 4) +
            floor(($year / 100) / 4) - 2 *
            floor($year / 100) + 77);

        $weekday_number = (($day - 7 * floor($day / 7)));

        return $weekday_number;
    } // end func dayOfWeek

    /**
     * Returns week of the year, first Sunday is first day of first week
     *
     * @param string day in format DD, default is current local day
     * @param string month in format MM, default is current local month
     * @param string year in format CCYY, default is current local year
     *
     * @access public
     *
     * @return integer $week_number
     */

    public static function weekOfYear($day='',$month='',$year='')
    {
        if (empty($year)) {
            $year = Date_Calc::dateNow('%Y');
        }
        if (empty($month)) {
            $month = Date_Calc::dateNow('%m');
        }
        if (empty($day)) {
            $day = Date_Calc::dateNow('%d');
        }
        $iso    = Date_Calc::gregorianToISO($day, $month, $year);
        $parts  = explode('-',$iso);
        $week_number = intval($parts[1]);
        return $week_number;
    } // end func weekOfYear

    /**
     * Returns number of days since 31 December of year before given date.
     *
     * @param string day in format DD, default is current local day
     * @param string month in format MM, default is current local month
     * @param string year in format CCYY, default is current local year
     *
     * @access public
     *
     * @return int $julian
     */

    public static function julianDate($day='',$month='',$year='')
    {
        if (empty($year)) {
            $year = Date_Calc::dateNow('%Y');
        }
        if (empty($month)) {
            $month = Date_Calc::dateNow('%m');
        }
        if (empty($day)) {
            $day = Date_Calc::dateNow('%d');
        }

        $days = array(0,31,59,90,120,151,181,212,243,273,304,334);

        $julian = ($days[$month - 1] + $day);

        if ($month > 2 && Date_Calc::isLeapYear($year)) {
            $julian++;
        }

        return($julian);
    } // end func julianDate

    /**
     * Returns quarter of the year for given date
     *
     * @param string day in format DD, default is current local day
     * @param string month in format MM, default is current local month
     * @param string year in format CCYY, default is current local year
     *
     * @access public
     *
     * @return int $year_quarter
     */

    public static function quarterOfYear($day='',$month='',$year='')
    {
        if (empty($year)) {
            $year = Date_Calc::dateNow('%Y');
        }
        if (empty($month)) {
            $month = Date_Calc::dateNow('%m');
        }
        if (empty($day)) {
            $day = Date_Calc::dateNow('%d');
        }

        $year_quarter = (intval(($month - 1) / 3 + 1));

        return $year_quarter;
    } // end func quarterOfYear

    /**
     * Returns date of begin of next month of given date.
     *
     * @param string day in format DD, default is current local day
     * @param string month in format MM, default is current local month
     * @param string year in format CCYY, default is current local year
     * @param string format for returned date
     *
     * @access public
     *
     * @return string date in given format
     */

    public static function beginOfNextMonth($day='',$month='',$year='',$format='%Y%m%d')
    {
        if (empty($year)) {
            $year = Date_Calc::dateNow('%Y');
        }
        if (empty($month)) {
            $month = Date_Calc::dateNow('%m');
        }
        if (empty($day)) {
            $day = Date_Calc::dateNow('%d');
        }

        if ($month < 12) {
            $month++;
            $day=1;
        } else {
            $year++;
            $month=1;
            $day=1;
        }

        return Date_Calc::dateFormat($day,$month,$year,$format);
    } // end func beginOfNextMonth

    /**
     * Returns date of the last day of next month of given date.
     *
     * @param string day in format DD, default is current local day
     * @param string month in format MM, default is current local month
     * @param string year in format CCYY, default is current local year
     * @param string format for returned date
     *
     * @access public
     *
     * @return string date in given format
     */

    public static function endOfNextMonth($day='',$month='',$year='',$format='%Y%m%d')
    {
        if (empty($year)) {
            $year = Date_Calc::dateNow('%Y');
        }
        if (empty($month)) {
            $month = Date_Calc::dateNow('%m');
        }
        if (empty($day)) {
            $day = Date_Calc::dateNow('%d');
        }

        if ($month < 12) {
            $month++;
        } else {
            $year++;
            $month=1;
        }

        $day = Date_Calc::daysInMonth($month,$year);

        return Date_Calc::dateFormat($day,$month,$year,$format);
    } // end func endOfNextMonth

    /**
     * Returns date of the first day of previous month of given date.
     *
     * @param string day in format DD, default is current local day
     * @param string month in format MM, default is current local month
     * @param string year in format CCYY, default is current local year
     * @param string format for returned date
     *
     * @access public
     *
     * @return string date in given format
     */

    public static function beginOfPrevMonth($day='',$month='',$year='',$format='%Y%m%d')
    {
        if (empty($year)) {
            $year = Date_Calc::dateNow('%Y');
        }
        if (empty($month)) {
            $month = Date_Calc::dateNow('%m');
        }
        if (empty($day)) {
            $day = Date_Calc::dateNow('%d');
        }

        if ($month > 1) {
            $month--;
            $day=1;
        } else {
            $year--;
            $month=12;
            $day=1;
        }

        return Date_Calc::dateFormat($day,$month,$year,$format);
    } // end func beginOfPrevMonth

    /**
     * Returns date of the last day of previous month for given date.
     *
     * @param string day in format DD, default is current local day
     * @param string month in format MM, default is current local month
     * @param string year in format CCYY, default is current local year
     * @param string format for returned date
     *
     * @access public
     *
     * @return string date in given format
     */

    public static function endOfPrevMonth($day='',$month='',$year='',$format='%Y%m%d')
    {
        if (empty($year)) {
            $year = Date_Calc::dateNow('%Y');
        }
        if (empty($month)) {
            $month = Date_Calc::dateNow('%m');
        }
        if (empty($day)) {
            $day = Date_Calc::dateNow('%d');
        }

        if ($month > 1) {
            $month--;
        } else {
            $year--;
            $month=12;
        }

        $day = Date_Calc::daysInMonth($month,$year);

        return Date_Calc::dateFormat($day,$month,$year,$format);
    } // end func endOfPrevMonth

    /**
     * Returns date of the next weekday of given date,
     * skipping from Friday to Monday.
     *
     * @param string day in format DD, default is current local day
     * @param string month in format MM, default is current local month
     * @param string year in format CCYY, default is current local year
     * @param string format for returned date
     *
     * @access public
     *
     * @return string date in given format
     */

    public static function nextWeekday($day='',$month='',$year='',$format='%Y%m%d')
    {
        if (empty($year)) {
            $year = Date_Calc::dateNow('%Y');
        }
        if (empty($month)) {
            $month = Date_Calc::dateNow('%m');
        }
        if (empty($day)) {
            $day = Date_Calc::dateNow('%d');
        }

        $days = Date_Calc::dateToDays($day,$month,$year);

        if (Date_Calc::dayOfWeek($day,$month,$year) == 5) {
            $days += 3;
        } elseif (Date_Calc::dayOfWeek($day,$month,$year) == 6) {
            $days += 2;
        } else {
            $days += 1;
        }

        return(Date_Calc::daysToDate($days,$format));
    } // end func nextWeekday

    /**
     * Returns date of the previous weekday,
     * skipping from Monday to Friday.
     *
     * @param string day in format DD, default is current local day
     * @param string month in format MM, default is current local month
     * @param string year in format CCYY, default is current local year
     * @param string format for returned date
     *
     * @access public
     *
     * @return string date in given format
     */

    public static function prevWeekday($day='',$month='',$year='',$format='%Y%m%d')
    {
        if (empty($year)) {
            $year = Date_Calc::dateNow('%Y');
        }
        if (empty($month)) {
            $month = Date_Calc::dateNow('%m');
        }
        if (empty($day)) {
            $day = Date_Calc::dateNow('%d');
        }

        $days = Date_Calc::dateToDays($day,$month,$year);

        if (Date_Calc::dayOfWeek($day,$month,$year) == 1) {
            $days -= 3;
        } elseif (Date_Calc::dayOfWeek($day,$month,$year) == 0) {
            $days -= 2;
        } else {
            $days -= 1;
        }

        return(Date_Calc::daysToDate($days,$format));
    } // end func prevWeekday

    /**
     * Returns date of the next specific day of the week
     * from the given date.
     *
     * @param int day of week, 0=Sunday
     * @param string day in format DD, default is current local day
     * @param string month in format MM, default is current local month
     * @param string year in format CCYY, default is current local year
     * @param boolean onOrAfter if true and days are same, returns current day
     * @param string format for returned date
     *
     * @access public
     *
     * @return string date in given format
     */

    public static function nextDayOfWeek($dow,$day='',$month='',$year='',$format='%Y%m%d',$onOrAfter=false)
    {
        if (empty($year)) {
            $year = Date_Calc::dateNow('%Y');
        }
        if (empty($month)) {
            $month = Date_Calc::dateNow('%m');
        }
        if (empty($day)) {
            $day = Date_Calc::dateNow('%d');
        }

        $days = Date_Calc::dateToDays($day,$month,$year);
        $curr_weekday = Date_Calc::dayOfWeek($day,$month,$year);

        if ($curr_weekday == $dow) {
            if (!$onOrAfter) {
                $days += 7;
            }
        }
        elseif ($curr_weekday > $dow) {
            $days += 7 - ( $curr_weekday - $dow );
        } else {
            $days += $dow - $curr_weekday;
        }

        return(Date_Calc::daysToDate($days,$format));
    } // end func nextDayOfWeek

    /**
     * Returns date of the previous specific day of the week
     * from the given date.
     *
     * @param int day of week, 0=Sunday
     * @param string day in format DD, default is current local day
     * @param string month in format MM, default is current local month
     * @param string year in format CCYY, default is current local year
     * @param boolean onOrBefore if true and days are same, returns current day
     * @param string format for returned date
     *
     * @access public
     *
     * @return string date in given format
     */

    public static function prevDayOfWeek($dow,$day='',$month='',$year='',$format='%Y%m%d',$onOrBefore=false)
    {
        if (empty($year)) {
            $year = Date_Calc::dateNow('%Y');
        }
        if (empty($month)) {
            $month = Date_Calc::dateNow('%m');
        }
        if (empty($day)) {
            $day = Date_Calc::dateNow('%d');
        }

        $days = Date_Calc::dateToDays($day,$month,$year);
        $curr_weekday = Date_Calc::dayOfWeek($day,$month,$year);

        if ($curr_weekday == $dow) {
            if (!$onOrBefore) {
                $days -= 7;
            }
        }
        elseif ($curr_weekday < $dow) {
            $days -= 7 - ( $dow - $curr_weekday );
        } else {
            $days -= $curr_weekday - $dow;
        }

        return(Date_Calc::daysToDate($days,$format));
    } // end func prevDayOfWeek

    /**
     * Returns date of the next specific day of the week
     * on or after the given date.
     *
     * @param int day of week, 0=Sunday
     * @param string day in format DD, default is current local day
     * @param string month in format MM, default is current local month
     * @param string year in format CCYY, default is current local year
     * @param string format for returned date
     *
     * @access public
     *
     * @return string date in given format
     */

    public static function nextDayOfWeekOnOrAfter($dow,$day='',$month='',$year='',$format='%Y%m%d')
    {
        return(Date_Calc::nextDayOfWeek($dow,$day,$month,$year,$format,true));
    } // end func nextDayOfWeekOnOrAfter

    /**
     * Returns date of the previous specific day of the week
     * on or before the given date.
     *
     * @param int day of week, 0=Sunday
     * @param string day in format DD, default is current local day
     * @param string month in format MM, default is current local month
     * @param string year in format CCYY, default is current local year
     * @param string format for returned date
     *
     * @access public
     *
     * @return string date in given format
     */

    public static function prevDayOfWeekOnOrBefore($dow,$day='',$month='',$year='',$format='%Y%m%d')
    {
        return(Date_Calc::prevDayOfWeek($dow,$day,$month,$year,$format,true));
    } // end func prevDayOfWeekOnOrAfter

    /**
     * Returns date of day after given date.
     *
     * @param string day in format DD, default is current local day
     * @param string month in format MM, default is current local month
     * @param string year in format CCYY, default is current local year
     * @param string format for returned date
     *
     * @access public
     *
     * @return string date in given format
     */

    public static function nextDay($day='',$month='',$year='',$format='%Y%m%d')
    {
        if (empty($year)) {
            $year = Date_Calc::dateNow('%Y');
        }
        if (empty($month)) {
            $month = Date_Calc::dateNow('%m');
        }
        if (empty($day)) {
            $day = Date_Calc::dateNow('%d');
        }

        $days = Date_Calc::dateToDays($day,$month,$year);

        return(Date_Calc::daysToDate($days + 1,$format));
    } // end func nextDay

    /**
     * Returns date of day before given date.
     *
     * @param string day in format DD, default is current local day
     * @param string month in format MM, default is current local month
     * @param string year in format CCYY, default is current local year
     * @param string format for returned date
     *
     * @access public
     *
     * @return string date in given format
     */

    public static function prevDay($day='',$month='',$year='',$format='%Y%m%d')
    {
        if (empty($year)) {
            $year = Date_Calc::dateNow('%Y');
        }
        if (empty($month)) {
            $month = Date_Calc::dateNow('%m');
        }
        if (empty($day)) {
            $day = Date_Calc::dateNow('%d');
        }

        $days = Date_Calc::dateToDays($day,$month,$year);

        return(Date_Calc::daysToDate($days - 1,$format));
    } // end func prevDay

    /**
     * Sets century for 2 digit year.
     * 51-99 is 19, else 20
     *
     * @param string 2 digit year
     *
     * @access public
     *
     * @return string 4 digit year
     */

    public static function defaultCentury($year)
    {
        if (strlen($year) == 1) {
            $year = "0$year";
        }
        if ($year > 50) {
            return( "19$year" );
        } else {
            return( "20$year" );
        }
    } // end func defaultCentury

    /**
     * Returns number of days between two given dates.
     *
    * @param string $day1   day in format DD
    * @param string $month1 month in format MM
    * @param string $year1  year in format CCYY
    * @param string $day2   day in format DD
    * @param string $month2 month in format MM
    * @param string $year2  year in format CCYY
     *
     * @access public
     *
     * @return int absolute number of days between dates,
     *      -1 if there is an error.
     */

    public static function dateDiff($day1,$month1,$year1,$day2,$month2,$year2)
    {
        if (!Date_Calc::isValidDate($day1,$month1,$year1)) {
            return -1;
        }
        if (!Date_Calc::isValidDate($day2,$month2,$year2)) {
            return -1;
        }

        return(abs((Date_Calc::dateToDays($day1,$month1,$year1))
                    - (Date_Calc::dateToDays($day2,$month2,$year2))));
    } // end func dateDiff

    /**
    * Compares two dates
    *
    * @param string $day1   day in format DD
    * @param string $month1 month in format MM
    * @param string $year1  year in format CCYY
    * @param string $day2   day in format DD
    * @param string $month2 month in format MM
    * @param string $year2  year in format CCYY
    *
    * @access public
    * @return int 0 on equality, 1 if date 1 is greater, -1 if smaller
    */
    public static function compareDates($day1,$month1,$year1,$day2,$month2,$year2)
    {
        $ndays1 = Date_Calc::dateToDays($day1, $month1, $year1);
        $ndays2 = Date_Calc::dateToDays($day2, $month2, $year2);
        if ($ndays1 == $ndays2) {
            return 0;
        }
        return ($ndays1 > $ndays2) ? 1 : -1;
    } // end func compareDates

    /**
     * Find the number of days in the given month.
     *
     * @param string month in format MM, default is current local month
     * @param string year in format CCYY, default is current local year
     *
     * @access public
     *
     * @return int number of days
     */

    public static function daysInMonth($month='',$year='')
    {
        if (empty($year)) {
            $year = Date_Calc::dateNow('%Y');
        }
        if (empty($month)) {
            $month = Date_Calc::dateNow('%m');
        }

        if ($year == 1582 && $month == 10) {
            return 21;  // October 1582 only had 1st-4th and 15th-31st
        }

        if ($month == 2) {
            if (Date_Calc::isLeapYear($year)) {
                return 29;
             } else {
                return 28;
            }
        } elseif ($month == 4 or $month == 6 or $month == 9 or $month == 11) {
            return 30;
        } else {
            return 31;
        }
    } // end func daysInMonth

    /**
     * Returns the number of rows on a calendar month. Useful for
     * determining the number of rows when displaying a typical
     * month calendar.
     *
     * @param string month in format MM, default is current local month
     * @param string year in format CCYY, default is current local year
     *
     * @access public
     *
     * @return int number of weeks
     */

    public static function weeksInMonth($month='',$year='')
    {
        if (empty($year)) {
            $year = Date_Calc::dateNow('%Y');
        }
        if (empty($month)) {
            $month = Date_Calc::dateNow('%m');
        }
        $FDOM = Date_Calc::firstOfMonthWeekday($month, $year);
        if (DATE_CALC_BEGIN_WEEKDAY==1 && $FDOM==0) {
            $first_week_days = 7 - $FDOM + DATE_CALC_BEGIN_WEEKDAY;
            $weeks = 1;
        } elseif (DATE_CALC_BEGIN_WEEKDAY==0 && $FDOM == 6) {
            $first_week_days = 7 - $FDOM + DATE_CALC_BEGIN_WEEKDAY;
            $weeks = 1;
        } else {
            $first_week_days = DATE_CALC_BEGIN_WEEKDAY - $FDOM;
            $weeks = 0;
        }
        $first_week_days %= 7;
        return (ceil((Date_Calc::daysInMonth($month, $year) - $first_week_days) / 7) + $weeks);
    } // end func weeksInMonth

    /**
     * Find the day of the week for the first of the month of given date.
     *
     * @param string month in format MM, default is current local month
     * @param string year in format CCYY, default is current local year
     *
     * @access public
     *
     * @return int number of weekday for the first day, 0=Sunday
     */

    public static function firstOfMonthWeekday($month='',$year='')
    {
        if (empty($year)) {
            $year = Date_Calc::dateNow('%Y');
        }
        if (empty($month)) {
            $month = Date_Calc::dateNow('%m');
        }

        return(Date_Calc::dayOfWeek('01',$month,$year));
    } // end func firstOfMonthWeekday

    /**
     * Return date of first day of month of given date.
     *
     * @param string month in format MM, default is current local month
     * @param string year in format CCYY, default is current local year
     * @param string format for returned date
     *
     * @access public
     *
     * @return string date in given format
     */

    public static function beginOfMonth($month='',$year='',$format='%Y%m%d')
    {
        if (empty($year)) {
            $year = Date_Calc::dateNow('%Y');
        }
        if (empty($month)) {
            $month = Date_Calc::dateNow('%m');
        }

        return(Date_Calc::dateFormat('01',$month,$year,$format));
    } // end of func beginOfMonth

    /**
     * Find the month day of the beginning of week for given date,
     * using DATE_CALC_BEGIN_WEEKDAY. (can return weekday of prev month.)
     *
     * @param string day in format DD, default is current local day
     * @param string month in format MM, default is current local month
     * @param string year in format CCYY, default is current local year
     * @param string format for returned date
     *
     * @access public
     *
     * @return string date in given format
     */

    public static function beginOfWeek($day='',$month='',$year='',$format='%Y%m%d')
    {
        if (empty($year)) {
            $year = Date_Calc::dateNow('%Y');
        }
        if (empty($month)) {
            $month = Date_Calc::dateNow('%m');
        }
        if (empty($day)) {
            $day = Date_Calc::dateNow('%d');
        }

        $this_weekday = Date_Calc::dayOfWeek($day,$month,$year);

        $interval = (7 - DATE_CALC_BEGIN_WEEKDAY + $this_weekday) % 7;

        return(Date_Calc::daysToDate(Date_Calc::dateToDays($day,$month,$year) - $interval,$format));
    } // end of func beginOfWeek

    /**
     * Find the month day of the end of week for given date,
     * using DATE_CALC_BEGIN_WEEKDAY. (can return weekday
     * of following month.)
     *
     * @param string day in format DD, default is current local day
     * @param string month in format MM, default is current local month
     * @param string year in format CCYY, default is current local year
     * @param string format for returned date
     *
     * @access public
     *
     * @return string date in given format
     */

    public static function endOfWeek($day='',$month='',$year='',$format='%Y%m%d')
    {
        if (empty($year)) {
            $year = Date_Calc::dateNow('%Y');
        }
        if (empty($month)) {
            $month = Date_Calc::dateNow('%m');
        }
        if (empty($day)) {
            $day = Date_Calc::dateNow('%d');
        }


        $this_weekday = Date_Calc::dayOfWeek($day,$month,$year);

        $interval = (6 + DATE_CALC_BEGIN_WEEKDAY - $this_weekday) % 7;

        return(Date_Calc::daysToDate(Date_Calc::dateToDays($day,$month,$year) + $interval,$format));
    } // end func endOfWeek

    /**
     * Find the month day of the beginning of week after given date,
     * using DATE_CALC_BEGIN_WEEKDAY. (can return weekday of prev month.)
     *
     * @param string day in format DD, default is current local day
     * @param string month in format MM, default is current local month
     * @param string year in format CCYY, default is current local year
     * @param string format for returned date
     *
     * @access public
     *
     * @return string date in given format
     */

    public static function beginOfNextWeek($day='',$month='',$year='',$format='%Y%m%d')
    {
        if (empty($year)) {
            $year = Date_Calc::dateNow("%Y");
        }
        if (empty($month)) {
            $month = Date_Calc::dateNow("%m");
        }
        if (empty($day)) {
            $day = Date_Calc::dateNow("%d");
        }

        $date = Date_Calc::daysToDate(
                    Date_Calc::dateToDays($day+7,$month,$year),"%Y%m%d"
                );

        $next_week_year = substr($date,0,4);
        $next_week_month = substr($date,4,2);
        $next_week_day = substr($date,6,2);

        return Date_Calc::beginOfWeek(
                            $next_week_day,$next_week_month,$next_week_year,
                            $format
                        );

        $date = Date_Calc::daysToDate(Date_Calc::dateToDays($day+7,$month,$year),"%Y%m%d");
    } // end func beginOfNextWeek

    /**
     * Find the month day of the beginning of week before given date,
     * using DATE_CALC_BEGIN_WEEKDAY. (can return weekday of prev month.)
     *
     * @param string day in format DD, default is current local day
     * @param string month in format MM, default is current local month
     * @param string year in format CCYY, default is current local year
     * @param string format for returned date
     *
     * @access public
     *
     * @return string date in given format
     */

    public static function beginOfPrevWeek($day='',$month='',$year='',$format='%Y%m%d')
    {
        if (empty($year)) {
            $year = Date_Calc::dateNow("%Y");
        }
        if (empty($month)) {
            $month = Date_Calc::dateNow("%m");
        }
        if (empty($day)) {
            $day = Date_Calc::dateNow("%d");
        }

        $date = Date_Calc::daysToDate(
                        Date_Calc::dateToDays($day-7,$month,$year),"%Y%m%d"
                    );

        $prev_week_year = substr($date,0,4);
        $prev_week_month = substr($date,4,2);
        $prev_week_day = substr($date,6,2);

        return Date_Calc::beginOfWeek($prev_week_day,$prev_week_month,$prev_week_year,$format);


        $date = Date_Calc::daysToDate(Date_Calc::dateToDays($day-7,$month,$year),"%Y%m%d");
    } // end func beginOfPrevWeek

    /**
     * Return an array with days in week
     *
     * @param string day in format DD, default is current local day
     * @param string month in format MM, default is current local month
     * @param string year in format CCYY, default is current local year
     * @param string format for returned date
     *
     * @access public
     *
     * @return array $week[$weekday]
     */

    public static function getCalendarWeek($day='',$month='',$year='',$format='%Y%m%d')
    {
        if (empty($year)) {
            $year = Date_Calc::dateNow('%Y');
        }
        if (empty($month)) {
            $month = Date_Calc::dateNow('%m');
        }
        if (empty($day)) {
            $day = Date_Calc::dateNow('%d');
        }

        $week_array = array();

        // date for the column of week

        $curr_day = Date_Calc::beginOfWeek($day,$month,$year,'%E');

        for($counter=0; $counter <= 6; $counter++) {
            $week_array[$counter] = Date_Calc::daysToDate($curr_day,$format);
            $curr_day++;
        }

        return $week_array;
    } // end func getCalendarWeek

    /**
     * Return a set of arrays to construct a calendar month for
     * the given date.
     *
     * @param string month in format MM, default is current local month
     * @param string year in format CCYY, default is current local year
     * @param string format for returned date
     *
     * @access public
     *
     * @return array $month[$row][$col]
     */

    public static function getCalendarMonth($month='',$year='',$format='%Y%m%d')
    {
        if (empty($year)) {
            $year = Date_Calc::dateNow('%Y');
        }
        if (empty($month)) {
            $month = Date_Calc::dateNow('%m');
        }

        $month_array = array();

        // date for the first row, first column of calendar month
        if (DATE_CALC_BEGIN_WEEKDAY == 1) {
            if (Date_Calc::firstOfMonthWeekday($month,$year) == 0) {
                $curr_day = Date_Calc::dateToDays('01',$month,$year) - 6;
            } else {
                $curr_day = Date_Calc::dateToDays('01',$month,$year)
                    - Date_Calc::firstOfMonthWeekday($month,$year) + 1;
            }
        } else {
            $curr_day = (Date_Calc::dateToDays('01',$month,$year)
                - Date_Calc::firstOfMonthWeekday($month,$year));
        }

        // number of days in this month
        $daysInMonth = Date_Calc::daysInMonth($month,$year);

        $weeksInMonth = Date_Calc::weeksInMonth($month,$year);
        for($row_counter=0; $row_counter < $weeksInMonth; $row_counter++) {
            for($column_counter=0; $column_counter <= 6; $column_counter++) {
                $month_array[$row_counter][$column_counter] =
                    Date_Calc::daysToDate($curr_day,$format);
                $curr_day++;
            }
        }

        return $month_array;
    } // end func getCalendarMonth

    /**
     * Return a set of arrays to construct a calendar year for
     * the given date.
     *
     * @param string year in format CCYY, default current local year
     * @param string format for returned date
     *
     * @access public
     *
     * @return array $year[$month][$row][$col]
     */

    public static function getCalendarYear($year='',$format='%Y%m%d')
    {
        if (empty($year)) {
            $year = Date_Calc::dateNow('%Y');
        }

        $year_array = array();

        for($curr_month=0; $curr_month <=11; $curr_month++) {
            $year_array[$curr_month] =
                Date_Calc::getCalendarMonth(sprintf('%02d',$curr_month+1),$year,$format);
        }

        return $year_array;
    } // end func getCalendarYear

    /**
     * Converts a date to number of days since a
     * distant unspecified epoch.
     *
     * @param string day in format DD
     * @param string month in format MM
     * @param string year in format CCYY
     *
     * @access public
     *
     * @return integer number of days
     */

    public static function dateToDays($day,$month,$year)
    {

        $century = (int) substr($year,0,2);
        $year = (int) substr($year,2,2);

        if ($month > 2) {
            $month -= 3;
        } else {
            $month += 9;
            if ($year) {
                $year--;
            } else {
                $year = 99;
                $century --;
            }
        }

        return (floor(( 146097 * $century) / 4 ) +
            floor(( 1461 * $year) / 4 ) +
            floor(( 153 * $month + 2) / 5 ) +
            $day + 1721119);
    } // end func dateToDays

    /**
     * Converts number of days to a distant unspecified epoch.
     *
     * @param int number of days
     * @param string format for returned date
     *
     * @access public
     *
     * @return string date in specified format
     */

    public static function daysToDate($days,$format='%Y%m%d')
    {

        $days       -=  1721119;
        $century    =   floor(( 4 * $days - 1) / 146097);
        $days       =   floor(4 * $days - 1 - 146097 * $century);
        $day        =   floor($days / 4);

        $year       =   floor(( 4 * $day +  3) / 1461);
        $day        =   floor(4 * $day +  3 - 1461 * $year);
        $day        =   floor(($day +  4) / 4);

        $month      =   floor(( 5 * $day - 3) / 153);
        $day        =   floor(5 * $day - 3 - 153 * $month);
        $day        =   floor(($day +  5) /  5);

        if ($month < 10) {
            $month +=3;
        } else {
            $month -=9;
            if ($year++ == 99) {
                $year = 0;
                $century++;
            }
        }

        $century = sprintf('%02d',$century);
        $year = sprintf('%02d',$year);
        return(Date_Calc::dateFormat($day,$month,$century.$year,$format));
    } // end func daysToDate

    /**
     * Calculates the date of the Nth weekday of the month,
     * such as the second Saturday of January 2000.
     *
     * @param string occurance: 1=first, 2=second, 3=third, etc.
     * @param string dayOfWeek: 0=Sunday, 1=Monday, etc.
     * @param string month in format MM
     * @param string year in format CCYY
     * @param string format for returned date
     *
     * @access public
     *
     * @return string date in given format
     */

    public static function NWeekdayOfMonth($occurance,$dayOfWeek,$month,$year,$format='%Y%m%d')
    {
        $year = sprintf('%04d',$year);
        $month = sprintf('%02d',$month);

        $DOW1day = sprintf('%02d',(($occurance - 1) * 7 + 1));
        $DOW1 = Date_Calc::dayOfWeek($DOW1day,$month,$year);

        $wdate = ($occurance - 1) * 7 + 1 +
                (7 + $dayOfWeek - $DOW1) % 7;

        if ( $wdate > Date_Calc::daysInMonth($month,$year)) {
            return -1;
        } else {
            return(Date_Calc::dateFormat($wdate,$month,$year,$format));
        }
    } // end func NWeekdayOfMonth

    /**
     *  Formats the date in the given format, much like
     *  strfmt(). This function is used to alleviate the
     *  problem with 32-bit numbers for dates pre 1970
     *  or post 2038, as strfmt() has on most systems.
     *  Most of the formatting options are compatible.
     *
     *  formatting options:
     *
     *  %a        abbreviated weekday name (Sun, Mon, Tue)
     *  %A        full weekday name (Sunday, Monday, Tuesday)
     *  %b        abbreviated month name (Jan, Feb, Mar)
     *  %B        full month name (January, February, March)
     *  %d        day of month (range 00 to 31)
     *  %e        day of month, single digit (range 0 to 31)
     *  %E        number of days since unspecified epoch (integer)
     *             (%E is useful for passing a date in a URL as
     *             an integer value. Then simply use
     *             daysToDate() to convert back to a date.)
     *  %j        day of year (range 001 to 366)
     *  %m        month as decimal number (range 1 to 12)
     *  %n        newline character (\n)
     *  %t        tab character (\t)
     *  %w        weekday as decimal (0 = Sunday)
     *  %U        week number of current year, first sunday as first week
     *  %y        year as decimal (range 00 to 99)
     *  %Y        year as decimal including century (range 0000 to 9999)
     *  %%        literal '%'
     *
     * @param string day in format DD
     * @param string month in format MM
     * @param string year in format CCYY
     * @param string format for returned date
     *
     * @access public
     *
     * @return string date in given format
     */

    public static function dateFormat($day,$month,$year,$format)
    {
        if (!Date_Calc::isValidDate($day,$month,$year)) {
            $year = Date_Calc::dateNow('%Y');
            $month = Date_Calc::dateNow('%m');
            $day = Date_Calc::dateNow('%d');
        }

        $output = '';

        for($strpos = 0; $strpos < strlen($format); $strpos++) {
            $char = substr($format,$strpos,1);
            if ($char == '%') {
                $nextchar = substr($format,$strpos + 1,1);
                switch($nextchar) {
                    case 'a':
                        $output .= Date_Calc::getWeekdayAbbrname($day,$month,$year);
                        break;
                    case 'A':
                        $output .= Date_Calc::getWeekdayFullname($day,$month,$year);
                        break;
                    case 'b':
                        $output .= Date_Calc::getMonthAbbrname($month);
                        break;
                    case 'B':
                        $output .= Date_Calc::getMonthFullname($month);
                        break;
                    case 'd':
                        $output .= sprintf('%02d',$day);
                        break;
                    case 'e':
                        $output .= $day;
                        break;
                    case 'E':
                        $output .= Date_Calc::dateToDays($day,$month,$year);
                        break;
                    case 'j':
                        $output .= Date_Calc::julianDate($day,$month,$year);
                        break;
                    case 'm':
                        $output .= sprintf('%02d',$month);
                        break;
                    case 'n':
                        $output .= "\n";
                        break;
                    case "t":
                        $output .= "\t";
                        break;
                    case 'w':
                        $output .= Date_Calc::dayOfWeek($day,$month,$year);
                        break;
                    case 'U':
                        $output .= Date_Calc::weekOfYear($day,$month,$year);
                        break;
                    case 'y':
                        $output .= substr($year,2,2);
                        break;
                    case 'Y':
                        $output .= $year;
                        break;
                    case '%':
                        $output .= '%';
                        break;
                    default:
                        $output .= $char.$nextchar;
                }
                $strpos++;
            } else {
                $output .= $char;
            }
        }
        return $output;
    } // end func dateFormat

    /**
     * Returns the current local year in format CCYY
     *
     * @access public
     *
     * @return string year in format CCYY
     */

    public static function getYear()
    {
        return Date_Calc::dateNow('%Y');
    } // end func getYear

    /**
     * Returns the current local month in format MM
     *
     * @access public
     *
     * @return string month in format MM
     */

    public static function getMonth()
    {
        return Date_Calc::dateNow('%m');
    } // end func getMonth

    /**
     * Returns the current local day in format DD
     *
     * @access public
     *
     * @return string day in format DD
     */

    public static function getDay()
    {
        return Date_Calc::dateNow('%d');
    } // end func getDay

    /**
     * Returns the full month name for the given month
     *
     * @param string month in format MM
     *
     * @access public
     *
     * @return string full month name
     */

    public static function getMonthFullname($month)
    {
        $month = (int)$month;

        if (empty($month)) {
            $month = (int) Date_Calc::dateNow('%m');
        }

        $month_names = Date_Calc::getMonthNames();

        return $month_names[$month];
        // getMonthNames returns months with correct indexes
        //return $month_names[($month - 1)];
    } // end func getMonthFullname

    /**
     * Returns the abbreviated month name for the given month
     *
     * @param string month in format MM
     * @param int optional length of abbreviation, default is 3
     *
     * @access public
     *
     * @return string abbreviated month name
     * @see Date_Calc::getMonthFullname
     */

    public static function getMonthAbbrname($month,$length=3)
    {
        $month = (int)$month;

        if (empty($month)) {
            $month = Date_Calc::dateNow('%m');
        }

        return substr(Date_Calc::getMonthFullname($month), 0, $length);
    } // end func getMonthAbbrname

    /**
     * Returns the full weekday name for the given date
     *
     * @param string day in format DD, default is current local day
     * @param string month in format MM, default is current local month
     * @param string year in format CCYY, default is current local year
     *
     * @access public
     *
     * @return string full month name
     */

    public static function getWeekdayFullname($day='',$month='',$year='')
    {
        if (empty($year)) {
            $year = Date_Calc::dateNow('%Y');
        }
        if (empty($month)) {
            $month = Date_Calc::dateNow('%m');
        }
        if (empty($day)) {
            $day = Date_Calc::dateNow('%d');
        }

        $weekday_names = Date_Calc::getWeekDays();
        $weekday = Date_Calc::dayOfWeek($day,$month,$year);

        return $weekday_names[$weekday];
    } // end func getWeekdayFullname

    /**
     * Returns the abbreviated weekday name for the given date
     *
     * @param string day in format DD, default is current local day
     * @param string month in format MM, default is current local month
     * @param string year in format CCYY, default is current local year
     * @param int optional length of abbreviation, default is 3
     *
     * @access public
     *
     * @return string full month name
     * @see Date_Calc::getWeekdayFullname
     */

    public static function getWeekdayAbbrname($day='',$month='',$year='',$length=3)
    {
        if (empty($year)) {
            $year = Date_Calc::dateNow('%Y');
        }
        if (empty($month)) {
            $month = Date_Calc::dateNow('%m');
        }
        if (empty($day)) {
            $day = Date_Calc::dateNow('%d');
        }

        return substr(Date_Calc::getWeekdayFullname($day,$month,$year),0,$length);
    } // end func getWeekdayFullname

    /**
    * Returns the numeric month from the month name or an abreviation
    *
    * Both August and Aug would return 8.
    * Month name is case insensitive.
    *
    * @param    string  month name
    * @return   integer month number
    */
    public static function getMonthFromFullName($month)
    {
        $month = strtolower($month);
        $months = Date_Calc::getMonthNames();
        while(list($id, $name) = each($months)) {
            if (strpos(strtolower($name), $month) !== false) {
                return($id);
            }
        }

        return(0);
    } // end func getMonthFromFullName

    /**
    * Returns an array of month names
    *
    * Used to take advantage of the setlocale function to return
    * language specific month names.
    * XXX cache values to some global array to avoid preformace
    * hits when called more than once.
    *
    * @returns array An array of month names
    */
    public static function getMonthNames()
    {
        for($i=1;$i<13;$i++) {
            $months[$i] = strftime('%B', mktime(0, 0, 0, $i, 1, 2001));
        }
        return($months);
    } // end func getMonthNames

    /**
    * Returns an array of week days
    *
    * Used to take advantage of the setlocale function to
    * return language specific week days
    * XXX cache values to some global array to avoid preformace
    * hits when called more than once.
    *
    * @returns array An array of week day names
    */
    public static function getWeekDays()
    {
        for($i=0;$i<7;$i++) {
            $weekdays[$i] = strftime('%A', mktime(0, 0, 0, 1, $i, 2001));
        }
        return($weekdays);
    } // end func getWeekDays

    /**
     * Converts from Gregorian Year-Month-Day to
     * ISO YearNumber-WeekNumber-WeekDay
     *
     * Uses ISO 8601 definitions.
     * Algorithm from Rick McCarty, 1999 at
     * http://personal.ecu.edu/mccartyr/ISOwdALG.txt
     *
     * @param string day in format DD
     * @param string month in format MM
     * @param string year in format CCYY
     * @return string
     * @access public
     */
    // Transcribed to PHP by Jesus M. Castagnetto (blame him if it is fubared ;-)
    public static function gregorianToISO($day,$month,$year) {
        $mnth = array (0,31,59,90,120,151,181,212,243,273,304,334);
        $y_isleap = Date_Calc::isLeapYear($year);
        $y_1_isleap = Date_Calc::isLeapYear($year - 1);
        $day_of_year_number = $day + $mnth[$month - 1];
        if ($y_isleap && $month > 2) {
            $day_of_year_number++;
        }
        // find Jan 1 weekday (monday = 1, sunday = 7)
        $yy = ($year - 1) % 100;
        $c = ($year - 1) - $yy;
        $g = $yy + intval($yy/4);
        $jan1_weekday = 1 + intval((((($c / 100) % 4) * 5) + $g) % 7);
        // Convert Jan 1 weekday to different date format if required (sunday = 1, saturday = 7)
        if (DATE_CALC_BEGIN_WEEKDAY == 0) {
            $jan1_weekday = ($jan1_weekday + 1) % 7;
        }
        // weekday for year-month-day
        $h = $day_of_year_number + ($jan1_weekday - 1);
        $weekday = 1 + intval(($h - 1) % 7);
        // find if Y M D falls in YearNumber Y-1, WeekNumber 52 or
        if ($day_of_year_number <= (8 - $jan1_weekday) && $jan1_weekday > 4){
            $yearnumber = $year - 1;
            if ($jan1_weekday == 5 || ($jan1_weekday == 6 && $y_1_isleap)) {
                $weeknumber = 53;
            } else {
                $weeknumber = 52;
            }
        } else {
            $yearnumber = $year;
        }
        // find if Y M D falls in YearNumber Y+1, WeekNumber 1
        if ($yearnumber == $year) {
            if ($y_isleap) {
                $i = 366;
            } else {
                $i = 365;
            }
            if (($i - $day_of_year_number) < (4 - $weekday)) {
                $yearnumber++;
                $weeknumber = 1;
            }
        }
        // find if Y M D falls in YearNumber Y, WeekNumber 1 through 53
        if ($yearnumber == $year) {
            $j = $day_of_year_number + (7 - $weekday) + ($jan1_weekday - 1);
            $weeknumber = intval($j / 7);
            if ($jan1_weekday > 4) {
                $weeknumber--;
            }
        }
        // put it all together
        if ($weeknumber < 10)
            $weeknumber = '0'.$weeknumber;
        return "{$yearnumber}-{$weeknumber}-{$weekday}";
    }

    /**
    * Determines julian date of the given season
    * Adapted from previous work in Java by James Mark Hamilton, mhamilton@qwest.net
    *
    * @author Robert Butler <rob@maxwellcreek.org>
    *
    * @param string is VERNALEQUINOX, SUMMERSOLSTICE, AUTUMNALEQUINOX, or WINTERSOLSTICE.
    * @param string year in format CCYY, must be a calendar year between -1000BC and 3000AD.
    *
    * @access public
    *
    * @return float $juliandate
    */

    public static function dateSeason ($season, $year = '') {
            if ($year == '') {
                    $year = Date_Calc::dateNow('%Y');
            }

            if (($year >= -1000) && ($year <= 1000)) {
                    $y = $year / 1000.0;
                    if ($season == 'VERNALEQUINOX') {
                            $juliandate = (((((((-0.00071 * $y) - 0.00111) * $y) + 0.06134) * $y) + 365242.1374) * $y) + 1721139.29189;
                    } else if ($season == 'SUMMERSOLSTICE') {
                            $juliandate = ((((((( 0.00025 * $y) + 0.00907) * $y) - 0.05323) * $y) + 365241.72562) * $y) + 1721233.25401;
                    } else if ($season == 'AUTUMNALEQUINOX') {
                            $juliandate = ((((((( 0.00074 * $y) - 0.00297) * $y) - 0.11677) * $y) + 365242.49558) * $y) + 1721325.70455;
                    } else if ($season == 'WINTERSOLSTICE') {
                            $juliandate = (((((((-0.00006 * $y) - 0.00933) * $y) - 0.00769) * $y) + 365242.88257) * $y) + 1721414.39987;
                    }
            } elseif (($year > 1000) && ($year <= 3000)) {
                    $y = ($year - 2000) / 1000;
                    if ($season == 'VERNALEQUINOX') {
                            $juliandate = (((((((-0.00057 * $y) - 0.00411) * $y) + 0.05169) * $y) + 365242.37404) * $y) + 2451623.80984;
                    } else if ($season == 'SUMMERSOLSTICE') {
                            $juliandate = (((((((-0.0003 * $y) + 0.00888) * $y) + 0.00325) * $y) + 365241.62603) * $y) + 2451716.56767;
                    } else if ($season == 'AUTUMNALEQUINOX') {
                            $juliandate = ((((((( 0.00078 * $y) + 0.00337) * $y) - 0.11575) * $y) + 365242.01767) * $y) + 2451810.21715;
                    } else if ($season == 'WINTERSOLSTICE') {
                            $juliandate = ((((((( 0.00032 * $y) - 0.00823) * $y) - 0.06223) * $y) + 365242.74049) * $y) + 2451900.05952;
                    }
            }

            return ($juliandate);
    } // end func dateSeason

} // end class Date_Calc

?>
