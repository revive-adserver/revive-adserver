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

require_once MAX_PATH . '/lib/max/Admin/Statistics/StatsController.php';
require_once 'Pager/Pager.php';



/**
 * Controller class for displaying history type statistics screens
 *
 * Always use the factory method to instantiate fields -- it will create
 * the right subclass for you.
 *
 * @package    Max
 * @subpackage Admin_Statistics
 * @author     Matteo Beccati <matteo@beccati.com>
 *
 * @see StatsControllerFactory
 */
class StatsHistoryController extends StatsController
{
    var $history;

    var $startDate;
    var $spanDays;
    var $spanWeeks;
    var $spanMonths;

    var $statsBreakdown;
    var $statsKey;
    var $statsIcon;

    var $grandTotal;
    var $grandAverage;
    var $grandAverageSpan;

    var $averageDesc;

    /**
     * PHP5-style constructor
     */
    function __construct($params)
    {
        // Get list order and direction
        $this->listOrderField     = MAX_getStoredValue('listorder', 'key');
        $this->listOrderDirection = MAX_getStoredValue('orderdirection', 'down');
        $this->statsBreakdown     = MAX_getStoredValue('statsBreakdown', 'day');

        parent::__construct($params);

        // Store the preferences
        $this->pagePrefs['listorder']      = $this->listOrderField;
        $this->pagePrefs['orderdirection'] = $this->listOrderDirection;
        $this->pagePrefs['breakdown']      = $this->statsBreakdown;
    }

    /**
     * PHP4-style constructor
     */
    function StatsHistoryController($params)
    {
        $this->__construct($params);
    }

    function getColspan()
    {
        return count($this->columns) + 1;
    }

    /**
     * Output the controller object using the breakdown_by_date template
     *
     * @param boolean Show the breakdown selector
     */
    function output($show_breakdown = true, $graph_mode = false)
    {
        if ($this->statsBreakdown == 'week') {
            $this->template = 'breakdown_by_week.html';

            // Fix htmlclass to match the weekly template
            if (count($this->history)) {
                $rows = array('date');
                foreach (array_keys($this->columns) as $v) {
                    if ($this->showColumn($v)) {
                        $rows[] = $v;
                    }
                }
                $rows = array_reverse($rows);
                foreach(array_keys($this->history) as $k) {
                    $htmlclass = $this->history[$k]['htmlclass'];
                    $tmpclass  = array();
                    foreach ($rows as $r => $v) {
                        $tmpclass[$v] = ($r ? 'nb' : '').$htmlclass;
                    }
                    $this->history[$k]['htmlclass'] = $tmpclass;
                }
            }
        } else {
            $this->template = 'breakdown_by_date.html';
        }

        $elements = array();
        if ($show_breakdown) {
            $elements['statsBreakdown'] = new HTML_Template_Flexy_Element;
            $elements['statsBreakdown']->setOptions( array(
              'day'   => $GLOBALS['strBreakdownByDay'],
              'week'  => $GLOBALS['strBreakdownByWeek'],
              'month' => $GLOBALS['strBreakdownByMonth'],
              'dow'   => $GLOBALS['strBreakdownByDow'],
              'hour'  => $GLOBALS['strBreakdownByHour']
            ));
            $elements['statsBreakdown']->setValue($this->statsBreakdown);
            $elements['statsBreakdown']->setAttributes(array('onchange' => 'this.form.submit()'));
        }

        if($graph_mode) {
             parent::outputGraph($elements);        
        } else {
             parent::output($elements);
        }

    }


    /**
     * Fetch the available span for the stats using the specified parameters
     *
     * @param array Query parameters
     */
    function getHistorySpan($aParams)
    {
        global $conf;

        $start_date = & new Date(date('Y-m-d'));

        // Check span using all plugins
        foreach ($this->plugins as $plugin) {
            $pluginParams = $plugin->getHistorySpanParams();

            $span = Admin_DA::fromCache('getHistorySpan', $aParams + $pluginParams);

            if (!empty($span['start_date'])) {
                $oDate = & new Date($span['start_date']);
                if ($oDate->before($start_date)) {
                    $start_date = & new Date($oDate);
                }
            }
        }

        $now  = & new Date();
        $span = & new Date_Span($start_date, new Date(date('Y-m-d')));

        $this->startDate  = $start_date;
        $this->spanDays   = (int)ceil($span->toDays());
        $this->spanWeeks  = (int)ceil($span_days / 7) + ($span_days % 7 ? 1 : 0);
        $this->spanMonths = (($now->getYear() - $start_date->getYear()) * 12) + ($now->getMonth() - $start_date->getMonth()) + 1;
    }

    /**
     * Fetch and decorates the history stats using the specified parameters
     *
     * @param array Query parameters
     * @param string Optional link for the leftmost column content
     */
    function prepareHistory($aParams, $link = '')
    {
        $this->getHistorySpan($aParams);

        $stats = $this->getHistory($aParams, $link);

        if ($this->noStatsAvailable) {
            $this->history = array();
            return;
        }

        if ($this->statsBreakdown == 'hour') {
            $this->statsIcon = 'images/icon-time.gif';
        } else {
            $this->statsIcon = 'images/icon-date.gif';
        }
        
        if ($this->disablePager) {
            $use_pager = false;
        } elseif ($this->statsBreakdown == 'week') {
            $per_page  = 4;
            $use_pager = count($stats) > $per_page;
        } elseif ($this->globalPrefs['period_preset'] == 'this_month' || $this->globalPrefs['period_preset'] == 'last_month') {
            // Do not use pager when showing last or current month
            $use_pager = false;
        } elseif ($this->statsBreakdown == 'hour' || $this->statsBreakdown == 'dow') {
            $use_pager = false;
        } else {
            $per_page  = 15;
            $use_pager = count($stats) > $per_page;
        }

        if ($use_pager) {
            $params = array(
                'itemData' => $stats,
                'perPage' => MAX_getStoredValue('setPerPage', $per_page),
                'delta' => 8,
                'append' => true,
                'clearIfVoid' => false,
                'urlVar' => 'page',
                'useSessions' => false,
                'mode'  => 'Jumping'
            );

            if ($params['perPage'] % $per_page || $params['perPage'] > $per_page * 4) {
                // Reset the perPage and the request parameters when not matching the available values
                $params['perPage']      = $per_page;
                $_REQUEST['setPerPage'] = $per_page;
            }

            $pager = & Pager::factory($params);
            $this->history = $pager->getPageData();
            $this->pagerLinks = $pager->getLinks();
            $this->pagerLinks = $this->pagerLinks['all'];

            $this->pagerSelect = preg_replace('/(<select.*?)(>)/i', '$1 onchange="this.form.submit()"$2',
                $pager->getPerPageSelectBox($per_page, $per_page * 4, $per_page));
        } else {
            $this->history = $stats;
            $this->pagerLinks = false;
            $this->pagerSelect = false;
        }

        $this->pagePrefs['setPerPage'] = $params['perPage'];

        if (count($this->history)) {
            $i = 0;
            foreach(array_keys($this->history) as $k) {
                $this->history[$k]['htmlclass'] = ($i++ % 2 == 0) ? 'dark' : 'light';

                if ($i == count($this->history)) {
                    $this->history[$k]['htmlclass'] .= ' last';
                }
            }
        }
    }

    /**
     * Fetch the history stats using the specified parameters
     *
     * @param array Query parameters
     * @param string Optional link for the leftmost column content
     */
    function getHistory($aParams, $link = '')
    {
        switch ($this->statsBreakdown) {
        case 'week':
            $this->weekDays = array();
            $oDaySpan = & new DaySpan('this_week');
            $oDate    = $oDaySpan->getStartDate();
            for ($i = 0; $i < 7; $i++) {
                $this->weekDays[$oDate->getDayOfWeek()] = $GLOBALS['strDayShortCuts'][$oDate->getDayOfWeek()];
                $oDate->addSpan(new Date_Span('1, 0, 0, 0'));
            }

            $this->statsKey    = $GLOBALS['strWeek'];
            $this->averageDesc = $GLOBALS['strWeeks'];
            $method = 'getDayHistory';
            break;

        case 'month':
            $this->statsKey    = $GLOBALS['strSingleMonth'];
            $this->averageDesc = $GLOBALS['strMonths'];
            $method = 'getMonthHistory';
            break;

        case 'dow'  :
            $this->statsKey    = $GLOBALS['strDayOfWeek'];
            $this->averageDesc = $GLOBALS['strWeekDays'];
            $method = 'getDayOfWeekHistory';
            break;

        case 'hour' :
            $this->statsKey    = $GLOBALS['strHour'];
            $this->averageDesc = $GLOBALS['strHours'];
            $method = 'getHourHistory';
            break;

        default     :
            $this->statsBreakdown = 'day';
            $this->statsKey    = $GLOBALS['strDay'];
            $this->averageDesc = $GLOBALS['strDays'];
            $method = 'getDayHistory';
            break;
        }

        // Add plugin aParams
        $pluginParams = array();
        foreach ($this->plugins as $plugin) {
                $plugin->addQueryParams($pluginParams);
        }

        $stats = Admin_DA::fromCache($method, $aParams + $this->aDates + $pluginParams);

        // Merge plugin additional data
        foreach ($this->plugins as $plugin) {
            $plugin->mergeData($stats, $this->emptyRow, $method, $aParams + $this->aDates);
        }

        if (count($stats)) {
            // Fill unused plugins columns
            foreach (array_keys($stats) as $k) {
                $stats[$k] += $this->emptyRow;
            }

            $this->fillGaps($stats, $link);

            if (!in_array($this->listOrderField, array_merge(array($this->statsBreakdown), array_keys($this->columns)))) {
                $this->listOrderField = $this->statsBreakdown;
                $this->listOrderDirection = $this->statsBreakdown == 'hour' || $this->statsBreakdown == 'dow' ? 'up' : 'down';
            }

            if ($this->statsBreakdown == 'week') {
                $this->prepareWeek($stats);
            }

            MAX_sortArray($stats, $this->listOrderField, $this->listOrderDirection == 'up');

            $this->summarizeTotals($stats, true);
        } else {
            $this->noStatsAvailable = true;
        }

        return $stats;
    }

    /**
     * Modify the history array to match the breakdown by week if necessary
     *
     * @param array History data array
     */
    function prepareWeek(&$stats)
    {
        if ($this->statsBreakdown == 'week') {
            $beginOfWeek = DaySpan::getBeginOfWeek();

            $weekstats = array();
            foreach ($stats as $k => $v) {
                $oDate    = & new Date($k);
                $v['day'] = $oDate->format('%d-%m');

                // Workaround to calculate the correct week of year: Date::getWeekOfYear() seems to always
                // use monday as start of week
                if ($beginOfWeek > 1) {
                    $oDate->substractSpan(new Date_Span(($beginOfWeek - 1).', 0, 0, 0'));
                } elseif ($beginOfWeek == 0) {
                    $oDate->addSpan(new Date_Span('1, 0, 0, 0'));
                }
                $week = sprintf('%04d-%02d', $oDate->getYear(), $oDate->getWeekOfYear());

                if (!isset($weekstats[$week])) {
                    $weekstats[$week] = array(
                        'week'            => $week, //$oDate->format($GLOBALS['week_format']),
                        'data'            => array(),
                        'avg'             => array()
                    ) + $this->emptyRow;
                }

                foreach (array_keys($this->columns) as $ck) {
                    $weekstats[$week][$ck] += $v[$ck];
                }

                $this->formatStats($v);
                $weekstats[$week]['data'][$k] = $v;
            }

            ksort($weekstats);
            $i = 0;
            foreach (array_keys($weekstats) as $week) {
                $days_count = count($weekstats[$week]['data']);
                $weekstats[$week]['avg'] = $this->summarizeAverage($weekstats[$week], $days_count, 0);

                ksort($weekstats[$week]['data']);
                $this->summarizeStats($weekstats[$week]);

                if ($days_count < 7) {
                    $hypenRow = array();
                    foreach (array_keys($this->columns) as $k) {
                        $hypenRow[$k] = '-';
                    }

                    // Fill days missing at the start
                    $oDate = & new Date(key($weekstats[$week]['data']));
                    $oDate->subtractSpan(new Date_Span('1, 0, 0, 0'));
                    while($oDate->getDayOfWeek() >= $beginOfWeek) {
                        $weekstats[$week]['data'][$oDate->format('%Y-%m-%d')] = array(
                            'day' => $oDate->format('%d-%m')
                        ) + $hypenRow;

                        $oDate->subtractSpan(new Date_Span('1, 0, 0, 0'));
                    }

                    // Sort data
                    ksort($weekstats[$week]['data']);

                    if (count($weekstats[$week]['data']) < 7) {
                        // Go to the end of the array
                        end($weekstats[$week]['data']);

                        // Fill days missing at the end
                        $oDate = & new Date(key($weekstats[$week]['data']));
                        $oDate->addSpan(new Date_Span('1, 0, 0, 0'));
                        while(count($weekstats[$week]['data']) < 7) {
                            $weekstats[$week]['data'][$oDate->format('%Y-%m-%d')] = array(
                                'day' => $oDate->format('%d-%m')
                            ) + $hypenRow;

                            $oDate->addSpan(new Date_Span('1, 0, 0, 0'));
                        }
                    }

                }

                $i++;
            }

            $stats = $weekstats;
        }
    }

    /**
     * Return an array which contains all the interval days, months, etc
     *
     * The key is uses the internal format for the date, and the value is its
     * formatted counterpart
     *
     * @return array Dates array
     */
    function getDatesArray()
    {
        return $this->_getDatesArray($this->statsBreakdown, $this->aDates, $this->startDate);
    }

    /**
     * Internal static function which returns an array which contains all the interval days, months, etc
     *
     * The key is uses the internal format for the date, and the value is its
     * formatted counterpart
     *
     * @param string Breakdown type
     * @param array Dates array
     * @param object Date object representing the first day of statistics available
     *
     * @return array Dates array
     */
    function _getDatesArray($breakdown, $aDates, $startDate)
    {
        // Get start and end dates
        if ($aDates['day_begin'] && $aDates['day_end']) {
            $start_date = & new Date($aDates['day_begin']);
            $end_date   = & new Date($aDates['day_end']);

            // Adjust start date if no stats are available
            if ($start_date->before($startDate)) {
                $aDates['day_begin'] = $startDate->format('%Y-%m-%d');
                $start_date = & new Date($aDates['day_begin']);
            }

            // Adjust end date if is future
            if ($end_date->isFuture()) {
                $aDates['day_end'] = date('Y-m-d');
                $end_date = & new Date($aDates['day_end']);
            }
        } else {
            // Use all available stats
            $start_date = $startDate;
            $end_date   = & new Date(date('Y-m-d'));
        }

        $dates = array();
        switch ($breakdown) {

        case 'week' :
        case 'day' :
            $one_day = &new Date_Span('1', '%d');
            $end_date->addSpan($one_day);
            $date = &new Date($start_date);
            while ($date->before($end_date)) {
                $dates[$date->format('%Y-%m-%d')] = $date->format($GLOBALS['date_format']);
                $date->addSpan($one_day);
            }
            break;

        case 'month' :
            $one_month = &new Date_Span((string)($end_date->getDaysInMonth() - $end_date->getDay() + 1), '%d');
            $end_date->addSpan($one_month);
            $date = &new Date($start_date);
            while ($date->before($end_date)) {
                $dates[$date->format('%Y-%m')] = $date->format($GLOBALS['month_format']);
                $one_month = &new Date_Span((string)($date->getDaysInMonth() - $date->getDay() + 1), '%d');
                $date->addSpan($one_month);
            }
            break;

        case 'dow' :
            for ($dow = 0; $dow < 7; $dow++) {
                $dates[$dow] = $GLOBALS['strDayFullNames'][$dow];
            }
            break;

        case 'hour' :
            for ($hour = 0; $hour < 24; $hour++) {
                $dates[$hour] = sprintf('%02d:00 - %02d:59', $hour, $hour);
            }
            break;

        }

        return $dates;
    }

    /**
     * Fills the gaps in the history stats and adds required links
     *
     * @param array Stats array
     */
    function fillGaps(&$stats, $link)
    {
        foreach ($this->getDatesArray() as $key  => $date_f) {
            if (!isset($stats[$key])) {
                $stats[$key] = array($this->statsBreakdown => $key) + $this->emptyRow;
            }
            $stats[$key]['date_f'] = $date_f;
            $this->summarizeStats($stats[$key]);

            switch ($this->statsBreakdown) {

            case 'week' :
            case 'day' :
                $stats[$key]['day']  = $key;
                $stats[$key]['link'] = $this->uriAddParams($link).'day='.str_replace('-', '', $key);
                $params = $this->removeDuplicateParams($link);             
                $stats[$key]['linkparams'] = substr($this->uriAddParams('', $params).
                    'day='.str_replace('-', '', $key), 1);     
                $stats[$key]['convlinkparams'] = substr($this->uriAddParams('', $params).
                    'day='.str_replace('-', '', $key), 1);
                break;

            case 'month' :
                $month_start = & new Date(sprintf('%s-%02d', $key, 1));
                $month_end = & new Date($month_start);
                $month_end->setDay($month_end->getDaysInMonth());
                $stats[$key]['month']      = $key;
                $params = $this->removeDuplicateParams($link);   
                $stats[$key]['linkparams'] = substr($this->uriAddParams('', $params).
                    'period_preset=specific&'.
                    'period_start='.$month_start->format('%Y-%m-%d').'&'.
                    'period_end='.$month_end->format('%Y-%m-%d'), 1);
                $stats[$key]['convlinkparams'] = substr($this->uriAddParams('', $params).
                    'period_preset=specific&'.
                    'period_start='.$month_start->format('%Y-%m-%d').'&'.
                    'period_end='.$month_end->format('%Y-%m-%d'), 1);
                break;

            case 'dow' :
                $stats[$key]['dow'] = $key;
                break;

            case 'hour' :
                $stats[$key]['hour'] = $key;
                if (!empty($this->aDates['day_begin']) && $this->aDates['day_begin'] == $this->aDates['day_end']) {
                    $params = $this->removeDuplicateParams($link);
                    $stats[$key]['linkparams'] = substr($this->uriAddParams('', $params).
                        'day='.str_replace('-', '', $this->aDates['day_begin']).'&'.
                        'hour='.sprintf('%02d', $key), 1);
                    $stats[$key]['convlinkparams'] = substr($this->uriAddParams('', $params).
                        'day='.str_replace('-', '', $this->aDates['day_begin']).'&'.
                        'hour='.sprintf('%02d', $key), 1);
                }
                break;
            }
        }
    }

    /**
     * Return bool - checks if there are any non empty impresions in object
     *
     * @return bool
     */
    function isEmptyResultArray()
    {
        foreach($this->history as $record) {

            if($record['sum_requests'] != '-' || $record['sum_views'] != '-' || $record['sum_clicks'] != '-') {
                return false;
            }
        }

        return true;
    }
    
    /**
     * Exports stats data to an array
     *
     * The array will look like:
     *
     * Array (
     *     'headers' => Array ( 0 => 'Col1', 1 => 'Col2', ... )
     *     'formats' => Array ( 0 => 'date', 1 => 'default', ... )
     *     'data'    => Array (
     *         0 => Array ( 0 => '2006-08-03', 1 => '5', ...),
     *         ...
     *     )
     * )
     *
     * @param array Stats array
     */
    function exportArray()
    {
        $parent = parent::exportArray();
                
        switch ($this->statsBreakdown) {
            case 'day':
                $key_format = 'date';
                break;
            case 'hour':
                $key_format = 'time';
                break;
            default:
                $key_format = 'text';
                break;
        }
        
        $headers = array_merge(array($this->statsKey), $parent['headers']);
        $formats = array_merge(array($key_format), $parent['formats']);
        $data    = array();
        
        $headers[] = $this->statsKey;
        
        foreach ($this->history as $h) {
            $row = array();
            $row[] = $h['date_f'];
            foreach (array_keys($this->columns) as $ck) {
                if ($this->showColumn($ck)) {
                    $row[] = $h[$ck];
                }
            }
            
            $data[] = $row;
        }
        
        return array(
            'headers' => $headers,
            'formats' => $formats,
            'data'    => $data
        );
    }
}

?>
