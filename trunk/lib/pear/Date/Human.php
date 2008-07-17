<?php
//
// +----------------------------------------------------------------------+
// | PHP Version 4                                                        |
// +----------------------------------------------------------------------+
// | Copyright (c) 1997-2003 The PHP Group                                |
// +----------------------------------------------------------------------+
// | This source file is subject to version 2.0 of the PHP license,       |
// | that is bundled with this package in the file LICENSE, and is        |
// | available at through the world-wide-web at                           |
// | http://www.php.net/license/2_02.txt.                                 |
// | If you did not receive a copy of the PHP license and are unable to   |
// | obtain it through the world-wide-web, please send a note to          |
// | license@php.net so we can mail you a copy immediately.               |
// +----------------------------------------------------------------------+
// | Author: Allan Kent <allan@lodestone.co.za>                           |
// +----------------------------------------------------------------------+
//
// $Id$
//

/**
 * Class to convert date strings between Gregorian and Human calendar formats.
 * The Human Calendar format has been proposed by Scott Flansburg and can be
 * explained as follows:
 *  The year is made up of 13 months
 *  Each month has 28 days
 *  Counting of months starts from 0 (zero) so the months will run from 0 to 12
 *  New Years day (00) is a monthless day
 *  Note: Leap Years are not yet accounted for in the Human Calendar system
 *
 * @since PHP 4.0.4
 * @author Allan Kent <allan@lodestone.co.za>
 */
class Date_Human
{

    /**
     * Returns an associative array containing the converted date information
     * in 'Human Calendar' format.
     *
     * @param int day in DD format, default current local day
     * @param int month in MM format, default current local month
     * @param int year in CCYY format, default to current local year
     *
     * @access public
     *
     * @return associative array(
     *               hdom,       // Human Day Of Month, starting at 1
     *               hdow,       // Human Day Of Week, starting at 1
     *               hwom,       // Human Week of Month, starting at 1
     *               hwoy,       // Human Week of Year, starting at 1
     *               hmoy,       // Human Month of Year, starting at 0
     *               )
     *
     * If the day is New Years Day, the function will return
     * "hdom" =>  0
     * "hdow" =>  0
     * "hwom" =>  0
     * "hwoy" =>  0
     * "hmoy" => -1
     *  Since 0 is a valid month number under the Human Calendar, I have left
     *  the month as -1 for New Years Day.
     */
    function gregorianToHuman($day=0, $month=0, $year=0)
    {
        /**
         * Check to see if any of the arguments are empty
         * If they are then populate the $dateinfo array
         * Then check to see which arguments are empty and fill
         * those with the current date info
         */
        if ((empty($day) || (empty($month)) || empty($year))) {
            $dateinfo = getdate(time());
        }
        if (empty($day)) {
            $day = $dateinfo["mday"];
        }
        if (empty($month)) {
            $month = $dateinfo["mon"];
        }
        if (empty($year)) {
            $year = $dateinfo["year"];
        }
        /**
         * We need to know how many days into the year we are
         */
        $dateinfo = getdate(mktime(0, 0, 0, $month, $day, $year));
        $dayofyear = $dateinfo["yday"];
        /**
         * Human Calendar starts at 0 for months and the first day of the year
         * is designated 00, so we need to start our day of the year at 0 for
         * these calculations.
         * Also, the day of the month is calculated with a modulus of 28.
         * Because a day is 28 days, the last day of the month would have a
         * remainder of 0 and not 28 as it should be.  Decrementing $dayofyear
         * gets around this.
         */
        $dayofyear--;
        /**
         * 28 days in a month...
         */
        $humanMonthOfYear = floor($dayofyear / 28);
        /**
         * If we are in the first month then the day of the month is $dayofyear
         * else we need to find the modulus of 28.
         */
        if ($humanMonthOfYear == 0) {
            $humanDayOfMonth = $dayofyear;
        } else {
            $humanDayOfMonth = ($dayofyear) % 28;
        }
        /**
         * Day of the week is modulus 7
         */
        $humanDayOfWeek = $dayofyear % 7;
        /**
         * We can now increment $dayofyear back to it's correct value for
         * the remainder of the calculations
         */
        $dayofyear++;
        /**
         * $humanDayOfMonth needs to be incremented now - recall that we fudged
         * it a bit by decrementing $dayofyear earlier
         * Same goes for $humanDayOfWeek
         */
        $humanDayOfMonth++;
        $humanDayOfWeek++;
        /**
         * Week of the month is day of the month divided by 7, rounded up
         * Same for week of the year, but use $dayofyear instead $humanDayOfMonth
         */
        $humanWeekOfMonth = ceil($humanDayOfMonth / 7);
        $humanWeekOfYear = ceil($dayofyear / 7);
        /**
         * Return an associative array of the values
         */
        return array(
                     "hdom" => $humanDayOfMonth,
                     "hdow" => $humanDayOfWeek,
                     "hwom" => $humanWeekOfMonth,
                     "hwoy" => $humanWeekOfYear,
                     "hmoy" => $humanMonthOfYear );
    }

    /**
     * Returns unix timestamp for a given Human Calendar date
     *
     * @param int day in DD format
     * @param int month in MM format
     * @param int year in CCYY format, default to current local year
     *
     * @access public
     *
     * @return int unix timestamp of date
     */
    function HumanToGregorian($day, $month, $year=0)
    {
        /**
         * Check to see if the year has been passed through.
         * If not get current year
         */
        if (empty($year)) {
            $dateinfo = getdate(time());
            $year = $dateinfo["year"];
        }
        /**
         * We need to get the day of the year that we are currently at so that
         * we can work out the Gregorian Month and day
         */
        $DayOfYear = $month * 28;
        $DayOfYear += $day;
        /**
         * Human Calendar starts at 0, so we need to increment $DayOfYear
         * to take into account the day 00
         */
        $DayOfYear++;
        /**
         * the mktime() function will correctly calculate the date for out of
         * range values, so putting $DayOfYear instead of the day of the month
         * will work fine.
         */
        $GregorianTimeStamp = mktime(0, 0, 0, 1, $DayOfYear, $year);
        return $GregorianTimeStamp;
    }

}
?>
