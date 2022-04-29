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

require_once MAX_PATH . '/lib/OA/Admin/Statistics/Delivery/Common.php';
require_once 'Pager.php';

/**
 * A common class that defines a common "interface" and common methods for
 * classes that display history delivery statistics.
 *
 * @package    OpenXAdmin
 * @subpackage StatisticsDelivery
 */
class OA_Admin_Statistics_Delivery_CommonHistory extends OA_Admin_Statistics_Delivery_Common
{
    /**
     * @var array
     */
    public $pagerLinks;

    /**
     * @var string|false
     */
    public $pagerSelect;

    /**
     * The starting day of the page's report span.
     *
     * @var PEAR::Date
     */
    public $oStartDate;

    /**
     * The number of days that the page's report spans.
     *
     * @var integer
     */
    public $spanDays;

    /**
     * The number of weeks that the page's report spans.
     *
     * @var integer
     */
    public $spanWeeks;

    /**
     * The number of months that the page's report spans.
     *
     * @var integer
     */
    public $spanMonths;

    /**
     * The type of statistics breakdown to display. One of:
     *  - hour
     *  - day
     *  - week
     *  - month
     *  - dow (ie. Day of Week)
     *
     * @var string
     */
    public $statsBreakdown;

    /**
     * @var string
     */
    public $statsKey;

    /**
     * @var string
     */
    public $averageDesc;

    /**
     * @var bool
     */
    public $disablePager = false;

    /**
     * PHP5-style constructor
     */
    public function __construct($aParams)
    {
        // Set the output type "history" style delivery statistcs
        $this->outputType = 'deliveryHistory';

        // Get list order and direction
        $this->listOrderField = MAX_getStoredValue('listorder', 'key');
        $this->listOrderDirection = MAX_getStoredValue('orderdirection', 'down');

        // Ensure the history class is prepared
        $this->useHistoryClass = true;

        parent::__construct($aParams);

        // Store the preferences
        $this->aPagePrefs['listorder'] = $this->listOrderField;
        $this->aPagePrefs['orderdirection'] = $this->listOrderDirection;
    }

    /**
     * The final "child" implementation of the parental abstract method,
     * to test if the appropriate data array is empty, or not.
     *
     * @see OA_Admin_Statistics_Common::_isEmptyResultArray()
     *
     * @access private
     * @return boolean True on empty, false if at least one row of data.
     */
    public function _isEmptyResultArray()
    {
        if (!is_array($this->aStatsData)) {
            return true;
        }
        foreach ($this->aStatsData as $aRecord) {
            if (
                $aRecord['sum_requests'] != '-' ||
                $aRecord['sum_views'] != '-' ||
                $aRecord['sum_clicks'] != '-'
            ) {
                return false;
            }
        }
        return true;
    }

    /**
     * Fetch and decorates the history stats using the specified parameters
     *
     * @param array  $aParams Query parameters
     * @param string $link    Optional link for the leftmost column content
     */
    public function prepare(&$aParams, $link = '')
    {
        parent::prepare($aParams);

        // Set the span requirements
        // Disable this for now, since these queries can be very slow
        // $this->oHistory->getSpan($this, $aParams);

        // Get the historical stats
        $aStats = $this->getHistory($aParams, $link);

        if ($this->noStatsAvailable) {
            $this->aStatsData = [];
            return;
        }

        if ($this->disablePager) {
            $use_pager = false;
        } elseif ($this->statsBreakdown == 'week') {
            $per_page = 4;
            $use_pager = count($aStats) > $per_page;
        } elseif ($this->aGlobalPrefs['period_preset'] == 'this_month' || $this->aGlobalPrefs['period_preset'] == 'last_month') {
            // Do not use pager when showing last or current month
            $use_pager = false;
        } elseif ($this->statsBreakdown == 'hour' || $this->statsBreakdown == 'dow') {
            $use_pager = false;
        } else {
            $per_page = 15;
            $use_pager = count($aStats) > $per_page;
        }

        if ($use_pager) {
            $params = [
                'itemData' => $aStats,
                'perPage' => (int) MAX_getStoredValue('setPerPage', $per_page),
                'delta' => 8,
                'append' => true,
                'clearIfVoid' => false,
                'urlVar' => 'page',
                'useSessions' => false,
                'mode' => 'Jumping'
            ];

            if ($params['perPage'] % $per_page || $params['perPage'] > $per_page * 4) {
                // Reset the perPage and the request parameters when not matching the available values
                $params['perPage'] = $per_page;
                $_REQUEST['setPerPage'] = $per_page;
            }

            $pager = Pager::factory($params);
            $this->aStatsData = $pager->getPageData();
            $this->pagerLinks = $pager->getLinks();
            $this->pagerLinks = $this->pagerLinks['all'];

            $this->pagerSelect = preg_replace(
                '/(<select.*?)(>)/i',
                '$1 onchange="this.form.submit()"$2',
                $pager->getPerPageSelectBox($per_page, $per_page * 4, $per_page)
            );
        } else {
            $this->aStatsData = $aStats;
            $this->pagerLinks = false;
            $this->pagerSelect = false;
        }

        $this->aPagePrefs['setPerPage'] = $params['perPage'];

        // Format the rows appropriately for output
        $this->oHistory->formatRows($this->aStatsData, $this);
    }

    public function getColspan()
    {
        return count($this->aColumns) + 1;
    }

    /**
     * Fetch the history stats using the specified parameters
     *
     * @param array  $aParams Query parameters
     * @param string $link    Optional link for the leftmost column content
     */
    public function getHistory($aParams, $link = '')
    {
        $oNow = new Date();
        $aParams['tz'] = $oNow->tz->getID();

        $method = $this->oHistory->setBreakdownInfo($this);

        // Add plugin aParams
        $pluginParams = [];
        foreach ($this->aPlugins as $oPlugin) {
            $oPlugin->addQueryParams($pluginParams);
        }

        $aStats = Admin_DA::fromCache($method, $aParams + $this->aDates + $pluginParams);

        // Merge plugin additional $oPlugin
        foreach ($this->aPlugins as $oPlugin) {
            $oPlugin->mergeData($aStats, $method, $aParams + $this->aDates, $this->aEmptyRow);
        }

        if (count($aStats) == 0) {
            $this->noStatsAvailable = true;
            return $aStats;
        }

        // Fill unused plugins columns
        foreach (array_keys($aStats) as $k) {
            $aStats[$k] += $this->aEmptyRow;
        }

        // Set some of the variables that used to be set by getSpan
        if (!empty($aStats)) {
            $dates = array_keys($aStats);

            // assumes first row has earliest date
            $firstDate = new Date($dates[0]);

            // Convert to current TZ
            $firstDate->setTZbyID('UTC');
            $firstDate->convertTZ($oNow->tz);
            $firstDate->setHour(0);
            $firstDate->setMinute(0);
            $firstDate->setSecond(0);

            if (empty($this->aDates)) {
                $this->aDates['day_begin'] = $firstDate->format('%Y-%m-%d');
                $this->aDates['day_end'] = $oNow->format('%Y-%m-%d');
            }

            $this->oStartDate = new Date($firstDate);
        }

        $aDates = $this->oHistory->getDatesArray($this->aDates, $this->statsBreakdown, $this->oStartDate);
        $this->oHistory->fillGapsAndLink($aStats, $aDates, $this, $link);

        if (!in_array($this->listOrderField, array_merge([$this->statsBreakdown], array_keys($this->aColumns)))) {
            $this->listOrderField = $this->statsBreakdown;
            $this->listOrderDirection = $this->statsBreakdown == 'hour' || $this->statsBreakdown == 'dow' ? 'up' : 'down';
        }

        // If required, re-format the data in the weekly breakdown format
        if ($this->statsBreakdown == 'week') {
            $this->oHistory->prepareWeekBreakdown($aStats, $this);
        }

        MAX_sortArray($aStats, $this->listOrderField, $this->listOrderDirection == 'up');

        // Summarise the values into a the totals array, & format
        $this->_summariseTotalsAndFormat($aStats, true);

        return $aStats;
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
    public function exportArray()
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

        $headers = array_merge([$this->statsKey], $parent['headers']);
        $formats = array_merge([$key_format], $parent['formats']);
        $data = [];

        $headers[] = $this->statsKey;

        foreach ($this->aStatsData as $h) {
            $row = [];
            $row[] = $this->statsBreakdown == 'week' ? $h['week'] : $h['date_f'];
            foreach (array_keys($this->aColumns) as $ck) {
                if ($this->showColumn($ck)) {
                    $row[] = $h[$ck];
                }
            }

            $data[] = $row;
        }

        return [
            'headers' => $headers,
            'formats' => $formats,
            'data' => $data
        ];
    }
}
