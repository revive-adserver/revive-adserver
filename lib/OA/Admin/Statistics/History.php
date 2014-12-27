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

require_once MAX_PATH . '/lib/max/Admin_DA.php';
require_once MAX_PATH . '/lib/OA/Admin/DaySpan.php';
require_once MAX_PATH . '/lib/pear/Date.php';

/**
 * A class of helper methods that can be called from the statistics
 * classes when generating "history" style statistics.
 *
 * @package    OpenXAdmin
 * @subpackage Statistics
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
     */
    function getSpan(&$oCaller, $aParams)
    {
        $oStartDate = new Date(date('Y-m-d'));
        $oStartDate->setHour(0);
        $oStartDate->setMinute(0);
        $oStartDate->setSecond(0);
        // Check span using all plugins
        foreach ($oCaller->aPlugins as $oPlugin) {
            $aPluginParams = call_user_func(array($oPlugin, 'getHistorySpanParams'));
            $aSpan = Admin_DA::fromCache('getHistorySpan', $aParams + $aPluginParams);
            if (!empty($aSpan['start_date'])) {
                $oDate = new Date($aSpan['start_date']);
                $oDate->setTZbyID('UTC');
                if ($oDate->before($oStartDate)) {
                    $oDate->convertTZ($oStartDate->tz);
                    $oStartDate = new Date($oDate);
                }
            }
        }
        $oStartDate->setHour(0);
        $oStartDate->setMinute(0);
        $oStartDate->setSecond(0);
        $oNow  = new Date();
        $oSpan = new Date_Span(new Date($oStartDate), new Date($oNow->format('%Y-%m-%d')));
        // Store the span data required for stats display
        $oCaller->oStartDate = $oStartDate;
        $oCaller->spanDays   = (int)ceil($oSpan->toDays());
        $oCaller->spanWeeks  = (int)ceil($oCaller->spanDays / 7) + ($oCaller->spanDays % 7 ? 1 : 0);
        $oCaller->spanMonths = (($oNow->getYear() - $oStartDate->getYear()) * 12) + ($oNow->getMonth() - $oStartDate->getMonth()) + 1;
        // Set the caller's aDates span in the event that it's empty
        if (empty($oCaller->aDates)) {
            $oCaller->aDates['day_begin'] = $oStartDate->format('%Y-%m-%d');
            $oCaller->aDates['day_end']   = $oNow->format('%Y-%m-%d');
        }
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
     *                full method name (eg. "getDayHistory").
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
            $method = 'getDayHistory';
            break;

        case 'month':
            $oCaller->statsKey       = $GLOBALS['strSingleMonth'];
            $oCaller->averageDesc    = $GLOBALS['strMonths'];
            $method = 'getMonthHistory';
            break;

        case 'dow'  :
            $oCaller->statsKey       = $GLOBALS['strDayOfWeek'];
            $oCaller->averageDesc    = $GLOBALS['strWeekDays'];
            $method = 'getDayOfWeekHistory';
            break;

        case 'hour' :
            $oCaller->statsKey       = $GLOBALS['strHour'];
            $oCaller->averageDesc    = $GLOBALS['strHours'];
            $method = 'getHourHistory';
            break;

        default     :
            $oCaller->statsBreakdown = 'day';
            $oCaller->statsKey       = $GLOBALS['strDay'];
            $oCaller->averageDesc    = $GLOBALS['strDays'];
            $method = 'getDayHistory';
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

            // Calculate CTR and other columns, making sure that the method is available
            if (is_callable(array($oCaller, '_summarizeStats'))) {
                $oCaller->_summarizeStats($aStats[$key]);
            }

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
                    $oDate = new Date($key);
                    $aStats[$key]['day'] = $oDate->format($GLOBALS['date_format']);
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
    function getDatesArray($aDates, $breakdown, $oStatsStartDate)
    {
        // Does the day span selector element have dates set?
        if (($aDates['day_begin'] && $aDates['day_end']) || ($aDates['period_start'] && $aDates['period_end'])) {
            if ($aDates['day_begin'] && $aDates['day_end']) {
                // Use the dates given by the day span selector element
                $oStartDate = new Date($aDates['day_begin']);
                $oEndDate   = new Date($aDates['day_end']);
            } else {
                // Use the dates given by the period_start and period_end
                $oStartDate = new Date($aDates['period_start']);
                $oEndDate   = new Date($aDates['period_end']);
            }
            // Adjust end date to be now, if it's in the future
            if ($oEndDate->isFuture()) {
                $oEndDate = new Date();
                $aDates['day_end'] = date('Y-m-d');
            }
        } else {
            // Use the dates given by the statistics date limitation
            // and now
            $oStartDate = new Date($oStatsStartDate);
            $oEndDate   = new Date(date('Y-m-d'));
        }
        // Prepare the return array
        $aDatesResult = array();
        switch ($breakdown) {
            case 'week' :
            case 'day' :
                $oOneDaySpan = new Date_Span('1', '%d');
                $oEndDate->addSpan($oOneDaySpan);
                $oDate = new Date($oStartDate);
                while ($oDate->before($oEndDate)) {
                    $aDatesResult[$oDate->format('%Y-%m-%d')] = $oDate->format($GLOBALS['date_format']);
                    $oDate->addSpan($oOneDaySpan);
                }
                break;
            case 'month' :
                $oOneMonthSpan = new Date_Span((string)($oEndDate->getDaysInMonth() - $oEndDate->getDay() + 1), '%d');
                $oEndDate->addSpan($oOneMonthSpan);
                $oDate = new Date($oStartDate);
                while ($oDate->before($oEndDate)) {
                    $aDatesResult[$oDate->format('%Y-%m')] = $oDate->format($GLOBALS['month_format']);
                    $oOneMonthSpan = new Date_Span((string)($oDate->getDaysInMonth() - $oDate->getDay() + 1), '%d');
                    $oDate->addSpan($oOneMonthSpan);
                }
                break;
            case 'dow' :
                for ($dow = 0; $dow < 7; $dow++) {
                    $aDatesResult[$dow] = $GLOBALS['strDayFullNames'][$dow];
                }
                break;
            case 'hour' :
                for ($hour = 0; $hour < 24; $hour++) {
                    $aDatesResult[$hour] = sprintf('%02d:00 - %02d:59', $hour, $hour);
                }
                break;
        }
        return $aDatesResult;
    }

    /**
     * A method to modify an array of history data so that it can be displayed in a format
     * compatible with the weekly breakdown template.
     *
     * @param array $aData    A reference to an array of arrays, containing the rows of data.
     * @param object $oCaller The calling object. Expected to have the the class variable
     *                        "statsBreakdown" set.
     */
    function prepareWeekBreakdown(&$aData, $oCaller)
    {
        // Only prepare the weekly breakdown if the statsBreakdown
        // in the caller is set to "week"
        if ($oCaller->statsBreakdown != 'week') {
            return;
        }
        $beginOfWeek = OA_Admin_DaySpan::getBeginOfWeek();
        $aWeekData = array();
        ksort($aData);
        foreach ($aData as $key => $aRowData) {
            // Get the date for this row's data
            $oDate = new Date($key);
            if ($beginOfWeek != 0) {
                // Need to change the date used for the data so
                // that the day appears in the correct week
                $daysToGoback = (int) (SECONDS_PER_DAY * $beginOfWeek);
                $oDate->subtractSeconds($daysToGoback);
            }
            // Get the week this date is in, in YYYY-MM format
            $week = sprintf('%04d-%02d', $oDate->getYear(), $oDate->getWeekOfYear());
            // Prepare the data array for this week, if not set, where
            // the week is in the "week" index, there is a "data" index
            // for all the rows that make up the week, and the array
            // has all the columns of an empty data row
            if (!isset($aWeekData[$week])) {
                $aWeekData[$week] = $oCaller->aEmptyRow;
                $aWeekData[$week]['week'] = $week;
                $aWeekData[$week]['data'] = array();
            }
            // Add the data from the row to the totals of the week
            foreach (array_keys($oCaller->aColumns) as $colKey) {
                $aWeekData[$week][$colKey] += $aRowData[$colKey];
            }
            // Store the row in the week
            $aWeekData[$week]['data'][$key] = $aRowData;
        }
        foreach (array_keys($aWeekData) as $week) {
            // Now that the totals are complete, fill any
            // remaining days in the week with empty data
            $days = count($aWeekData[$week]['data']);
            if ($days < 7) {
                // Locate the first day of the week in the days that make
                // up the week so far
                ksort($aWeekData[$week]['data']);
                $key = key($aWeekData[$week]['data']);
                $oDate = new Date($key);
                $firstDataDayOfWeek = $oDate->getDayOfWeek();
                // Is this after the start of the week?
                if ($firstDataDayOfWeek > $beginOfWeek) {
                    // Change the date to be the first day of this week
                    $daysToGoback = (int) (SECONDS_PER_DAY * ($firstDataDayOfWeek - $beginOfWeek));
                    $oDate->subtractSeconds($daysToGoback);
                }
                // Check each day in the week
                for ($counter = 0; $counter < 7; $counter++) {
                    if (is_null($aWeekData[$week]['data'][$oDate->format('%Y-%m-%d')])) {
                        // Set the day's data to the empty row, plus the "day" heading for the day
                        $aWeekData[$week]['data'][$oDate->format('%Y-%m-%d')] = $oCaller->aEmptyRow;
                        $aWeekData[$week]['data'][$oDate->format('%Y-%m-%d')]['day'] = $oDate->format($GLOBALS['date_format']);
                    } elseif (!is_null($aWeekData[$week]['data'][$oDate->format('%Y-%m-%d')])
                            && !array_key_exists('day', $aWeekData[$week]['data'][$oDate->format('%Y-%m-%d')]))
                    {
                        $aWeekData[$week]['data'][$oDate->format('%Y-%m-%d')]['day'] = $oDate->format($GLOBALS['date_format']);
                    }
                    $oDate->addSeconds(SECONDS_PER_DAY);
                }
            }
            // Ensure the day data is sorted correctly
            ksort($aWeekData[$week]['data']);
            // Format all day rows
            foreach (array_keys($aWeekData[$week]['data']) as $key) {
                $oCaller->_formatStatsRowRecursive($aWeekData[$week]['data'][$key]);
            }

            // Calculate CTR and other columns, making sure that the method is available
            if (is_callable(array($oCaller, '_summarizeStats'))) {
                $oCaller->_summarizeStats($aWeekData[$week]);
            }
        }
        // Set the new weekly-formatted data as the new data array to use
        $aData = $aWeekData;
    }

    /**
     * A method to format the rows of display data to work with the standard "history" style
     * templates.
     *
     * @param array  $aData   A reference to an array of arrays, containing the rows of data.
     * @param object $oCaller The calling object. Expected to have the the class variable
     *                        "statsBreakdown" set.
     */
    function formatRows(&$aData, $oCaller)
    {
        // Re-order the "day of week" breakdown, if required
        if ($oCaller->statsBreakdown == 'dow') {
            $beginOfWeek = OA_Admin_DaySpan::getBeginOfWeek();
            // Re-order when not starting on a Sunday
            for ($counter = 0; $counter < $beginOfWeek; $counter++) {
                $aElement = array_shift($aData);
                $aData[] = $aElement;
            }
        }
        // Format the rows
        if (count($aData) > 0) {
            $i = 1;
            reset($aData);
            foreach (array_keys($aData) as $key) {
                // Is there a set target ratio?
                if (preg_match('/(\d+\.\d*)%/', $aData[$key]['target_ratio'], $aMatches)) {
                    $targetPercent = $aMatches[0];
                    if ($targetPercent < 90) {
                        $aData[$key]['htmlclass'] = 'reddark';
                    } else if ($targetPercent > 110) {
                        $aData[$key]['htmlclass'] = 'redlight';
                    }

                } else if (($aData[$key]['ad_required_impressions'] > 0 || $aData[$key]['placement_required_impressions'] > 0) && $aData[$key]['target_ratio'] == '-') {
                    $aData[$key]['htmlclass'] = 'reddark';
                }
                // Set the row's "htmlclass" value as being light, or dark
                if (empty($aData[$key]['htmlclass'])) {
                    $aData[$key]['htmlclass'] = ($i++ % 2 == 0) ? 'dark' : 'light';
                }
                // Extend the "last" row's "htmlclass" value
                if ($setLast && $i == count($aData)) {
                    $aData[$key]['htmlclass'] .= ' last';
                }
            }
        }
    }

    /**
     * A method to format the rows of display data to work with the standard "history" style
     * templates when in the weekly breakdown - for targeting statistics only!
     *
     * @param array  $aData   A reference to an array of arrays, containing the rows of data.
     * @param object $oCaller The calling object. Expected to have the the class variable
     *                        "statsBreakdown" set.
     * @param string $colour  An optional, fixed non-targeting issue colour for all items.
     */
    function formatWeekRows(&$aData, $oCaller, $colour = null)
    {
        // Format the rows
        if (count($aData) > 0) {
            $i = 1;
            reset($aData);
            foreach (array_keys($aData) as $key) {
                // Format the total row - is there a set target ratio?
                if (preg_match('/(\d+\.\d*)%/', $aData[$key]['target_ratio'], $aMatches)) {
                    $targetPercent = $aMatches[0];
                    if ($targetPercent < 90) {
                        $aData[$key]['htmlcolclass'] = 'reddark';
                    } else if ($targetPercent > 110) {
                        $aData[$key]['htmlcolclass'] = 'redlight';
                    }
                }
                // Is there a weekly data array to format as well?
                if (isset($aData[$key]['data']) && is_array($aData[$key]['data']) && count($aData[$key]['data']) > 0) {
                    $colour = ($i++ % 2 == 0) ? 'dark' : 'light';
                    $this->formatWeekRows($aData[$key]['data'], $oCaller, $colour);
                }
                // Set the row's "htmlclass" value as being light, or dark
                if (!isset($colour)) {
                    $colour = ($i++ % 2 == 0) ? 'dark' : 'light';
                }
                $aData[$key]['htmlclass'] = $colour;
                // Also set the "htmlcolclass" if not set already
                if (empty($aData[$key]['htmlcolclass'])) {
                    $aData[$key]['htmlcolclass'] = $colour;
                }
            }
        }
    }

    /**
     * A method to format the rows of display data to work with the standard "history" style
     * templates when in the weekly breakdown - for targeting statistics only!
     *
     * @param array  $aData   A reference to an array, containing the a row of data.
     * @param object $oCaller The calling object. Expected to have the the class variable
     *                        "statsBreakdown" set.
     * @param string $colour  An optional, fixed non-targeting issue colour for all items.
     */
    function formatWeekRowsTotal(&$aData, $oCaller, $colour = null)
    {
        // Format the total row - is there a set target ratio?
        if (preg_match('/(\d+\.\d*)%/', $aData['target_ratio'], $aMatches)) {
            $targetPercent = $aMatches[0];
            if ($targetPercent < 90) {
                $aData['htmlclass'] = 'reddark';
            } else if ($targetPercent > 110) {
                $aData['htmlclass'] = 'redlight';
            }
        }
    }

}

?>
