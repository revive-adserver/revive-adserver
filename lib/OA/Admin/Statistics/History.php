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

require_once MAX_PATH . '/lib/max/Admin_DA.php';

/**
 * A class of helper methods that can be called from the statistics
 * classes when generating "history" style statistics.
 *
 * @package    OpenadsAdmin
 * @subpackage Statistics
 * @author     Matteo Beccati <matteo@beccati.com>
 * @author     Andrew Hill <andrew.hill@openads.org>
 */
class OA_Admin_Statistics_History
{

    /**
     * A method that can be inherited and used by children classes to get the
     * required date span of a statistics page.
     *
     * @param object $oCaller      The calling object. Expected to have the
     *                             the following class variables:
     *                                  $oCaller->aPlugins    - An array of statistics fields plugins
     *                                  $oCaller->oStartDate  - Will be set by method
     *                                  $oCaller->spanDays    - Will be set by method
     *                                  $oCaller->spanWeeks   - Will be set by method
     *                                  $oCaller->spanMonths  - Will be set by method
     * @param array  $aParams      An array of query parameters for
     *                             {@link Admin_DA::fromCache()}.
     * @param string $type         The name of the method to pass to the
     *                             {@link Admin_DA::fromCache()} method.
     *                             Default is the name required for delivery
     *                             statistics.
     * @param string $pluginMethod The name of the method to call on the
     *                             display plugins to determine if there
     *                             are any custom parameters to pass to the
     *                             {@link Admin_DA::fromCache()} method.
     *                             Default is the name of the method for
     *                             delivery statistics.
     */
    function getSpan(&$oCaller, $aParams, $type = 'getHistorySpan', $pluginMethod = 'getHistorySpanParams')
    {
        $oStartDate = new Date(date('Y-m-d'));
        // Check span using all plugins
        foreach ($oCaller->aPlugins as $oPlugin) {
            $aPluginParams = call_user_func(array($oPlugin, $pluginMethod));
            $aSpan = Admin_DA::fromCache($type, $aParams + $aPluginParams);
            if (!empty($aSpan['start_date'])) {
                $oDate = new Date($aSpan['start_date']);
                if ($oDate->before($oStartDate)) {
                    $oStartDate = new Date($oDate);
                }
            }
        }
        $oNow  = new Date();
        $oSpan = new Date_Span($oStartDate, new Date(date('Y-m-d')));
        $oCaller->oStartDate = $oStartDate;
        $oCaller->spanDays   = (int)ceil($oSpan->toDays());
        $oCaller->spanWeeks  = (int)ceil($oCaller->spanDays / 7) + ($oCaller->spanDays % 7 ? 1 : 0);
        $oCaller->spanMonths = (($oNow->getYear() - $oStartDate->getYear()) * 12) + ($oNow->getMonth() - $oStartDate->getMonth()) + 1;
    }

    /**
     * A method to set the required variables used in generating historical
     * data, and to obtain a partial Admin_DA method name to use to obtain
     * this data.
     *
     * @param object $oCaller The calling object. Expected to have the
     *                        the following class variables:
     *                             $oCaller->statsBreakdown - One of "week", "month", "dow",
     *                                                        "hour", or unset, in which case
     *                                                        will be set to "day" by method
     *                             $oCaller->weekDays       - May be set by method
     *                             $oCaller->statsKey       - Will be set by method
     *                             $oCaller->averageDesc    - Will be set by method
     * @param string $type    One of "history" or "targeting".
     * @return string The partial Admin_DA method name (eg. "getDay") to be used to
     *                obtain the historical data - combined with other text to get the
     *                full method name (eg. "getDayHistory", "getDayTargeting").
     */
    function setBreakdownInfo(&$oCaller, $type = 'history')
    {
        switch ($oCaller->statsBreakdown) {
        case 'week':
            $oCaller->weekDays = array();
            $oDaySpan = new OA_Admin_DaySpan('this_week');
            $oDate    = $oDaySpan->getStartDate();
            for ($i = 0; $i < 7; $i++) {
                $oCaller->weekDays[$oDate->getDayOfWeek()] = $GLOBALS['strDayShortCuts'][$oDate->getDayOfWeek()];
                $oDate->addSpan(new Date_Span('1, 0, 0, 0'));
            }
            $oCaller->statsKey       = $GLOBALS['strWeek'];
            $oCaller->averageDesc    = $GLOBALS['strWeeks'];
            if ($type == 'history') {
                $method = 'getDayHistory';
            } else {
                $method = 'getTargetingStatisticsSpanByWeek';
            }
            break;

        case 'month':
            $oCaller->statsKey       = $GLOBALS['strSingleMonth'];
            $oCaller->averageDesc    = $GLOBALS['strMonths'];
            if ($type == 'history') {
                $method = 'getMonthHistory';
            } else {
                $method = 'getTargetingStatisticsSpanByMonth';
            }
            break;

        case 'dow'  :
            $oCaller->statsKey       = $GLOBALS['strDayOfWeek'];
            $oCaller->averageDesc    = $GLOBALS['strWeekDays'];
            if ($type == 'history') {
                $method = 'getDayOfWeekHistory';
            } else {
                $method = 'getTargetingStatisticsSpanByDow';
            }
            break;

        case 'hour' :
            $oCaller->statsKey       = $GLOBALS['strHour'];
            $oCaller->averageDesc    = $GLOBALS['strHours'];
            if ($type == 'history') {
                $method = 'getHourHistory';
            } else {
                $method = 'getTargetingStatisticsSpanByHour';
            }
            break;

        default     :
            $oCaller->statsBreakdown = 'day';
            $oCaller->statsKey       = $GLOBALS['strDay'];
            $oCaller->averageDesc    = $GLOBALS['strDays'];
            if ($type == 'history') {
                $method = 'getDayHistory';
            } else {
                $method = 'getTargetingStatisticsSpanByDay';
            }
            break;
        }
        return $method;
    }

    /**
     * A method to fill an array of statistics data with any weeks, days, months, day
     * of weeks or hours of data that need to be included to make the statistics screen
     * "complete".
     *
     * Also ensures that any already set weeks, days, months, day of weeks or hours have
     * the correct formatting for display applied, and that the correct URI is used for
     * the week, day, month, day of week or hour column items.
     *
     * @param array $aStats   A reference to the array of statistics that needs to be filled.
     * @param array $aDates   An array of the days, months, days of week or hours that should
     *                        be filled in $aStats.
     * @param object $oCaller The calling object. Expected to have the the following class
     *                        variables set:
     *                                  $oCaller->statsBreakdown - The way stats are broken down
     *                                  $oCaller->aEmptyRow      - What an empty row looks like
     * @param string $link    Optional partial URL to be used for creating the link for the
     *                        week, day, month, day of week or hour column items.
     */
    function fillGapsAndLink(&$aStats, $aDates, $oCaller, $link = '')
    {
        foreach ($aDates as $key => $date_f) {

            // Ensure that all the required items are set by adding empty rows, if required.
            if (!isset($aStats[$key])) {
                $aStats[$key] = array($oCaller->statsBreakdown => $key) + $oCaller->aEmptyRow;
            }
            $aStats[$key]['date_f'] = $date_f;

            // Prepare the array of parameters for creating the LHC day-breakdown link,
            // if required - simply the $oCaller->aPageParams array with "entity" and
            // "breakdown" set as required
            if (!empty($link)) {
                $aDayLinkParams = array();
                $aDayLinkParams['entity']    = $oCaller->entity;
                $aDayLinkParams['breakdown'] = $oCaller->dayLinkBreakdown;
                $aDayLinkParams = array_merge($oCaller->aPageParams, $aDayLinkParams);
            }

            // Add links to the left hand column items, if required
            switch ($oCaller->statsBreakdown) {

                case 'week' :
                case 'day' :
                    // Set the "day/week" value
                    $aStats[$key]['day'] = $key;
                    if (!empty($link)) {
                    // Set LHC day-breakdown link, if required:
                        $aStats[$key]['link'] = $oCaller->_addPageParamsToURI($link, $aDayLinkParams) . 'day=' . str_replace('-', '', $key);

                        $aParams = $oCaller->_removeDuplicateParams($link);
                        $aStats[$key]['linkparams'] = substr($oCaller->_addPageParamsToURI('', $aParams).
                            'day='.str_replace('-', '', $key), 1);
                        $aStats[$key]['convlinkparams'] = substr($oCaller->_addPageParamsToURI('', $aParams).
                            'day='.str_replace('-', '', $key), 1);
                    }
                    break;

                case 'month' :
                    // Set the "month" value
                    $oMonthStart = new Date(sprintf('%s-%02d', $key, 1));
                    $oMonthEnd = new Date();
                    $oMonthEnd->copy($oMonthStart);
                    $oMonthEnd->setDay($oMonthEnd->getDaysInMonth());
                    $aStats[$key]['month'] = $key;
                    if (!empty($link)) {
                        $aParams = $oCaller->_removeDuplicateParams($link);
                        $aStats[$key]['linkparams'] = substr($oCaller->_addPageParamsToURI('', $aParams).
                            'period_preset=specific&'.
                            'period_start='.$oMonthStart->format('%Y-%m-%d').'&'.
                            'period_end='.$oMonthEnd->format('%Y-%m-%d'), 1);
                        $aStats[$key]['convlinkparams'] = substr($oCaller->_addPageParamsToURI('', $aParams).
                            'period_preset=specific&'.
                            'period_start='.$oMonthStart->format('%Y-%m-%d').'&'.
                            'period_end='.$oMonthEnd->format('%Y-%m-%d'), 1);
                    }
                    break;

                case 'dow' :
                    // Set the "dow" value
                    $aStats[$key]['dow'] = $key;
                    break;

                case 'hour' :
                    // Set the "hour" value
                    $aStats[$key]['hour'] = $key;
                    if (
                        !empty($link) &&
                        !empty($this->aDates['day_begin']) &&
                        !empty($this->aDates['day_end']) &&
                        $this->aDates['day_begin'] == $this->aDates['day_end']
                    ) {
                        $aParams = $oCaller->_removeDuplicateParams($link);
                        $aStats[$key]['linkparams'] = substr($oCaller->_addPageParamsToURI('', $aParams).
                            'day='.str_replace('-', '', $this->aDates['day_begin']).'&'.
                            'hour='.sprintf('%02d', $key), 1);
                        $aStats[$key]['convlinkparams'] = substr($oCaller->_addPageParamsToURI('', $aParams).
                            'day='.str_replace('-', '', $this->aDates['day_begin']).'&'.
                            'hour='.sprintf('%02d', $key), 1);
                    }
                    break;

            }
        }
    }

    /**
     * A method to calculate the range of dates that a statistics screen needs to display.
     *
     * Returns an array of values where:
     *
     *  - If "week" or "day" is the breakdown, array is of days, indexed by "YYYY-MM-DD",
     *    and formatted using the user's local format for days.
     *
     *  - If "month" is the breakdown, array is of months, indexed by "YYYY-MM",
     *    and formatted using the user's local format for months and days.
     *
     *  - If "dow" is the breakdown, array is of days of the week, indexed by the integers
     *    0 to 6, and formatted with the user's local weekday names.
     *
     *  - If "hour" is the breakdown, array is of hours of the day, indexed by the integers
     *    0 to 23, and formatted in the format "00:00 - 00:59", "01:00 01:59", etc.
     *
     * @param array      $aDates          An array of the start and end dates in use by the day
     *                                    span selector element, if set.
     * @param string     $breakdown       The breakdown type in use. One of "week", "day", "month",
     *                                    "dow" or "hour".
     * @param PEAR::Date $oStatsStartDate A date object representing the first day of statistics
     *                                    that are available.
     * @return array The array, as described above.
     */
    function getDatesArray(&$aDates, $breakdown, $oStatsStartDate)
    {
        // Does the day span selector element have dates set?
        if ($aDates['day_begin'] && $aDates['day_end']) {
            // Use the dates given by the day span selector element
            $oStartDate = new Date($aDates['day_begin']);
            $oEndDate   = new Date($aDates['day_end']);
            // Increase the start date in the day span selector element
            // if no stats are available from its original start date
            if ($oStartDate->before($oStatsStartDate)) {
                $oStartDate = new Date();
                $oStartDate->copy($oStatsStartDate);
                $aDates['day_begin'] = new Date();
                $aDates['day_begin']->copy($oStatsStartDate);
                $aDates['day_begin'] = $aDates['day_begin']->format('%Y-%m-%d');
            }
            // Adjust end date to be now, if it's in the future
            if ($oEndDate->isFuture()) {
                $oEndDate = new Date();
                $aDates['day_end'] = new Date();
                $aDates['day_end'] = $aDates['day_end']->format('%Y-%m-%d');
            }
        } else {
            // Use the dates given by the statistics date limitation
            // and now
            $oStartDate = new Date();
            $oStartDate->copy($oStatsStartDate);
            $oEndDate   = new Date();
        }
        // Prepare the return array
        $aDates = array();
        switch ($breakdown) {
            case 'week' :
            case 'day' :
                $oOneDaySpan = new Date_Span('1', '%d');
                $oEndDate->addSpan($oOneDaySpan);
                $oDate = new Date();
                $oDate->copy($oStartDate);
                while ($oDate->before($oEndDate)) {
                    $aDates[$oDate->format('%Y-%m-%d')] = $oDate->format($GLOBALS['date_format']);
                    $oDate->addSpan($oOneDaySpan);
                }
                break;
            case 'month' :
                $oOneMonthSpan = new Date_Span((string)($oEndDate->getDaysInMonth() - $oEndDate->getDay() + 1), '%d');
                $oEndDate->addSpan($oOneMonthSpan);
                $oDate = new Date();
                $oDate->copy($oStartDate);
                while ($oDate->before($oEndDate)) {
                    $aDates[$oDate->format('%Y-%m')] = $oDate->format($GLOBALS['month_format']);
                    $oOneMonthSpan = new Date_Span((string)($oDate->getDaysInMonth() - $oDate->getDay() + 1), '%d');
                    $oDate->addSpan($oOneMonthSpan);
                }
                break;
            case 'dow' :
                for ($dow = 0; $dow < 7; $dow++) {
                    $aDates[$dow] = $GLOBALS['strDayFullNames'][$dow];
                }
                break;
            case 'hour' :
                for ($hour = 0; $hour < 24; $hour++) {
                    $aDates[$hour] = sprintf('%02d:00 - %02d:59', $hour, $hour);
                }
                break;
        }
        return $aDates;
    }

}

?>