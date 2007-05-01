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

require_once MAX_PATH . '/lib/max/Plugin/Common.php';
require_once MAX_PATH . '/lib/max/Plugin/Translation.php';

/**
 * Plugins_statisticsFieldsDelivery_statisticsFieldsDelivery is an abstract
 * class for every delivery statistics fields plugin.
 *
 * @abstract
 * @package    OpenadsPlugin
 * @subpackage StatisticsFields
 * @author     Matteo Beccati <matteo@beccati.com>
 */
class Plugins_statisticsFieldsDelivery_statisticsFieldsDelivery extends MAX_Plugin_Common
{

    /**
     * @var array
     */
    var $_fields;

    /**
     * @var int
     */
    var $displayOrder = 0;

    /**
     * Return name of plugin
     *
     * @abstract
     * @return string A string describing the class.
     */
    function getName()
    {
        Max::debug('Cannot run abstract method');
        exit();
    }

    function getFields(&$controller)
    {
        // Get the preferences
        $pref = $GLOBALS['_MAX']['PREF'];

        $fields = array();
        foreach ($this->_fields as $k => $v) {
            if (isset($v['ctrl']) && !is_a($controller, $v['ctrl'])) {
                continue;
            }

            if (isset($v['pref'])) {
                $var = $v['pref'];
                $fields[$k] = !empty($pref[$var.'_label']) ? $pref[$var.'_label'] : '';
            }

            if (empty($fields[$k])) {
                $fields[$k] = isset($v['short']) ? $v['short'] : $v['name'];
            }
        }

        return $fields;
    }

    function getEmptyRow()
    {
        $names = array();
        foreach (array_keys($this->_fields) as $k) {
            $names[$k] = 0;
        }

        return $names;
    }

    function getColumnLinks()
    {
        $links = array();
        foreach ($this->_fields as $k => $v) {
            if (!empty($v['link'])) {
                $links[$k] = $v['link'];
            }
        }

        return $links;
    }

    function getSumFieldNames()
    {
        $fields = array();
        foreach ($this->_fields as $k => $v) {
            if ($v['format'] != 'percent') {
                $fields[] = $k;
            }
        }

        return $fields;
    }

    function getPreferenceNames()
    {
        // Get the preferences
        $pref = $GLOBALS['_MAX']['PREF'];

        $prefs = array();
        foreach ($this->_fields as $k => $v) {
            if (isset($v['pref'])) {
                $prefs[$k] = $v['pref'];
            }
        }

        return $prefs;
    }

    function getVisibleColumns()
    {
        // Get the preferences
        $pref = $GLOBALS['_MAX']['PREF'];

        $columns = array();
        foreach ($this->_fields as $k => $v) {
            if (isset($v['pref'])) {
                $var = $v['pref'];
                $columns[$k] = isset($pref[$var]) && phpAds_isUser($pref[$var]);
            } else {
                $columns[$k] = false;
            }
        }

        return $columns;
    }

    function getVisibilitySettings()
    {
        $prefs = array();
        foreach ($this->_fields as $v) {
            if (isset($v['pref'])) {
                $var = $v['pref'];
                $prefs[$var] = $v['name'];
            }
        }

        return $prefs;
    }

    /**
     * Return the active status of a row
     *
     * @param array Row of stats
     * @return boolean True if the row is active
     */
    function isRowActive($row)
    {
        foreach ($this->_fields as $k => $v) {
            if (!empty($v['active']) && $row[$k] > 0) {
                return true;
            }
        }

        return false;
    }

    function addQueryParams(&$aParams)
    {
    }

    /**
     * A method that returns an array of parameters representing custom columns
     * to use to determine the span of history when displaying delivery statistics.
     *
     * That is, either an empty array if the delivery statistics plugin does not
     * need to alter the stanard span of delivery statistics, or, an array of two
     * elements:
     *
     *      'custom_table'   => The name of the table to look for data in to
     *                          determine if the span of the data to be shown needs
     *                          to be extended beyond the default; and
     *      'custom_columns' => An array of one element, "start_date", which is
     *                          indexed by SQL code that can be run to determine the
     *                          starting date in the span.
     *
     * For example, if you have a custom data table "foo", and the earliest date
     * in this table can be found by using the SQL "SELECT DATE_FORMAT(MIN(bar), '%Y-%m-%d')",
     * then the array to return would be:
     *
     * array(
     *      'custom_table'   => 'foo',
     *      'custom_columns' => array("DATE_FORMAT(MIN(bar), '%Y-%m-%d')" => 'start_date')
     * );
     *
     * @return array As described above.
     */
    function getHistorySpanParams()
    {
        return array();
    }

    function mergeData(&$aRows, $method, $aParams)
    {
    }

    /**
     * Add the fields which require calculations
     *
     * @param array Row of stats
     */
    function summarizeStats(&$row)
    {
        Max::debug('Cannot run abstract method');
        exit();
    }

    /**
     * Calculate averages
     *
     * @param array Total stats
     * @param array Number of entries
     * @return array Averages array
     */
    function summarizeAverage($total, $count)
    {
        $average = array();
        foreach ($this->_fields as $k => $v) {
            $average[$k] = $count ? $total[$k] / $count : 0;
        }

        return $average;
    }

    /**
     * Format a row of stats according to the user preferences
     *
     * @param array Row of stats
     */
    function _formatStats(&$row, $is_total = false)
    {
        foreach ($this->_fields as $k => $v) {
            if (array_key_exists($k, $row)) {
                if ($v['format'] == 'id') {
                    $row[$k] = $is_total ? '-' : $row[$k];
                } elseif ($row[$k] == 0) {
                    $row[$k] = '-';
                } elseif ($v['format'] == 'percent') {
                    $row[$k] = phpAds_formatPercentage($row[$k]);
                } elseif ($v['format'] == 'currency') {
                    $row[$k] = phpAds_formatNumber($row[$k], 2);
                } else {
                    $row[$k] = phpAds_formatNumber($row[$k]);
                }
            }
        }
    }

    /**
     * Return plugin column formats
     *
     * @param array Formats
     */
    function getFormats()
    {
        $ret[] = array();

        foreach ($this->_fields as $k => $v) {
            $ret[$k] = $v['format'];
        }

        return $ret;
    }

    /**
     * Add the fields needed for conversions stats
     *
     * @param array Row of stats
     * @param array Empty row
     * @param string Invocated method
     * @param array Parameter array
     */
    function mergeConversions(&$aRows, $emptyRow, $method, $aParams)
    {
        $conf = $GLOBALS['_MAX']['CONF'];

        $aParams['include'] = isset($aParams['include']) ? array_flip($aParams['include']) : array();
        $aParams['exclude'] = isset($aParams['exclude']) ? array_flip($aParams['exclude']) : array();

        // Primary key
        if ($method == 'getEntitiesStats') {
            if (!isset($aParams['exclude']['ad_id']) && !isset($aParams['exclude']['zone_id'])) {
                $aFields[] = "CONCAT(diac.ad_id, '_', diac.zone_id) AS pkey";
            } elseif (!isset($aParams['exclude']['ad_id'])) {
                $aFields[] = "diac.ad_id AS pkey";
            } else {
                $aFields[] = "diac.zone_id AS pkey";
            }
        } else {
            $aParams['exclude']['ad_id']   = true;
            $aParams['exclude']['zone_id'] = true;

            if ($method == 'getDayHistory') {
                $aFields[] = "DATE_FORMAT(diac.tracker_date_time, '%Y-%m-%d') AS pkey";
            } elseif ($method == 'getMonthHistory') {
                $aFields[] = "DATE_FORMAT(diac.tracker_date_time, '%Y-%m') AS pkey";
            } elseif ($method == 'getDayOfWeekHistory') {
                $aFields[] = "DAYOFWEEK(diac.tracker_date_time) - 1 AS pkey";
            } elseif ($method == 'getHourHistory') {
                $aFields[] = "HOUR(diac.tracker_date_time) AS pkey";
            }
        }

        if (!count($aFields)) {
            return;
        }

        $aFrom   = array(
            "{$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']} diac"
        );
        $aWhere   = array("diac.inside_window = 1");
        $aGroupBy = array('pkey');

        $aFields[] = "SUM(IF(diac.connection_status = ".MAX_CONNECTION_STATUS_APPROVED.
                        " AND diac.connection_action = ".MAX_CONNECTION_AD_IMPRESSION.",1,0)) AS sum_conversions_".MAX_CONNECTION_AD_IMPRESSION;
        $aFields[] = "SUM(IF(diac.connection_status = ".MAX_CONNECTION_STATUS_APPROVED.
                        " AND diac.connection_action = ".MAX_CONNECTION_AD_CLICK.",1,0)) AS sum_conversions_".MAX_CONNECTION_AD_CLICK;
        $aFields[] = "SUM(IF(diac.connection_status = ".MAX_CONNECTION_STATUS_APPROVED.
                        " AND diac.connection_action = ".MAX_CONNECTION_AD_ARRIVAL.",1,0)) AS sum_conversions_".MAX_CONNECTION_AD_ARRIVAL;
        $aFields[] = "SUM(IF(diac.connection_status = ".MAX_CONNECTION_STATUS_APPROVED.
                        " AND diac.connection_action = ".MAX_CONNECTION_MANUAL.",1,0)) AS sum_conversions_".MAX_CONNECTION_MANUAL;
        $aFields[] = "SUM(IF(diac.connection_status = ".MAX_CONNECTION_STATUS_APPROVED.",1,0)) AS sum_conversions";
        $aFields[] = "SUM(IF(diac.connection_status = ".MAX_CONNECTION_STATUS_PENDING.",1,0)) AS sum_conversions_pending";

        if (!empty($aParams['day_begin']) && !empty($aParams['day_end'])) {
            $oStartDate = & new Date("{$aParams['day_begin']} 00:00:00");
            $oEndDate   = & new Date("{$aParams['day_end']} 23:59:59");
            $aWhere[] = "diac.tracker_date_time BETWEEN '".$oStartDate->format('%Y-%m-%d %H:%M:%S')."'".
                        " AND '".$oEndDate->format('%Y-%m-%d %H:%M:%S')."'";
        }

        if (!empty($aParams['agency_id'])) {
            $aFrom['b'] = "JOIN {$conf['table']['prefix']}{$conf['table']['banners']} b ON (b.bannerid = diac.ad_id)";
            $aFrom['m'] = "JOIN {$conf['table']['prefix']}{$conf['table']['campaigns']} m ON (m.campaignid = b.campaignid)";
            $aFrom['c'] = "JOIN {$conf['table']['prefix']}{$conf['table']['clients']} c ON (c.clientid = m.clientid)";
            $aFrom['z'] = "LEFT JOIN {$conf['table']['prefix']}{$conf['table']['zones']} z ON (z.zoneid = diac.zone_id)";
            $aFrom['p'] = "LEFT JOIN {$conf['table']['prefix']}{$conf['table']['affiliates']} p ON (p.affiliateid = z.affiliateid AND p.agencyid = '{$aParams['agency_id']}')";

            $aWhere[] = "c.agencyid = '{$aParams['agency_id']}'";
        }
        if (!empty($aParams['advertiser_id']) || isset($aParams['include']['advertiser_id'])) {
            $aFrom['b'] = "JOIN {$conf['table']['prefix']}{$conf['table']['banners']} b ON (b.bannerid = diac.ad_id)";
            $aFrom['m'] = "JOIN {$conf['table']['prefix']}{$conf['table']['campaigns']} m ON (m.campaignid = b.campaignid)";

            if (!empty($aParams['advertiser_id'])) {
                $aWhere[] = "m.clientid = '{$aParams['advertiser_id']}'";
            }
            if (isset($aParams['include']['advertiser_id']) && !isset($aParams['exclude']['advertiser_id'])) {
                $aFields[]  = "m.clientid AS advertiser_id";
                $aGroupBy[] = "advertiser_id";
            }
        }
        if (!empty($aParams['placement_id']) || isset($aParams['include']['placement_id'])) {
            $aFrom['b'] = "JOIN {$conf['table']['prefix']}{$conf['table']['banners']} b ON (b.bannerid = diac.ad_id)";

            if (!empty($aParams['placement_id'])) {
                $aWhere[] = "b.campaignid = '{$aParams['placement_id']}'";
            }
            if (isset($aParams['include']['placement_id']) && !isset($aParams['exclude']['placement_id'])) {
                $aFields[]  = "b.campaignid AS placement_id";
                $aGroupBy[] = "placement_id";
            }
        }
        if (!empty($aParams['publisher_id']) || isset($aParams['include']['publisher_id'])) {
            $aFrom['z'] = "JOIN {$conf['table']['prefix']}{$conf['table']['zones']} z ON (z.zoneid = diac.zone_id)";

            if (!empty($aParams['publisher_id'])) {
                $aWhere[] = "z.affiliateid = '{$aParams['publisher_id']}'";
            }
            if (isset($aParams['include']['publisher_id']) && !isset($aParams['exclude']['publisher_id'])) {
                $aFields[]  = "z.affiliateid AS publisher_id";
                $aGroupBy[] = "publisher_id";
            }
        }
        if (!empty($aParams['ad_id'])) {
            $aWhere[] = "diac.ad_id = '{$aParams['ad_id']}'";
        }
        if (!isset($aParams['exclude']['ad_id'])) {
            $aFields[]  = "diac.ad_id AS ad_id";
            $aGroupBy[] = "ad_id";
        }
        // Using isset: zone_id could be 0 in case of direct selection
        if (isset($aParams['zone_id'])) {
            $aWhere[] = "diac.zone_id = '{$aParams['zone_id']}'";
        }
        if (!isset($aParams['exclude']['zone_id'])) {
            $aFields[]  = "diac.zone_id AS zone_id";
            $aGroupBy[] = "zone_id";
        }

        $sFields   = count($aFields)  ? join(', ', $aFields)  : '';
        $sFrom     = count($aFrom)    ? join(' ', $aFrom)   : '';
        $sWhere    = count($aWhere)   ? 'WHERE '.join(' AND ', $aWhere)   : '';
        $sGroupBy  = count($aGroupBy) ? 'GROUP BY '.join(', ', $aGroupBy) : '';

        $query = "SELECT ".$sFields." FROM ".$sFrom." ".$sWhere." ".$sGroupBy;

        $res = phpAds_dbQuery($query);

        while ($row = phpAds_dbFetchArray($res)) {
            $pkey = $row['pkey'];
            unset ($row['pkey']);

            if (!isset($aRows[$pkey])) {
                $aRows[$pkey] = $emptyRow;
            }

            $aRows[$pkey] = $row + $aRows[$pkey];
        }
    }

}

?>