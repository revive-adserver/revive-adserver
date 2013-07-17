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

require_once MAX_PATH . '/lib/OA/Admin/Statistics/Fields/Delivery.php';

/**
 * The default delivery statistics fields plugin.
 *
 * @abstract
 * @package    OpenXPlugin
 * @subpackage StatisticsFields
 * @author     Matteo Beccati <matteo@beccati.com>
 */
class OA_StatisticsFieldsDelivery_Default extends OA_StatisticsFieldsDelivery
{
    /**
     * Constructor
     */
    function OA_StatisticsFieldsDelivery_Default()
    {

        $aConf = $GLOBALS['_MAX']['CONF'];

        // Set ordering to a low value to move columns to the left
        $this->displayOrder = -10;

        // Set module and package because they aren't set when running the constructor method
        /*$this->module  = 'statisticsFieldsDelivery';
        $this->package = 'default';*/

        $this->_aFields = array();

        $this->_aFields['id'] =
            array(
                'name'   => $GLOBALS['strID'],
                'short'  => $GLOBALS['strID_short'],
                'pref'   => 'ui_column_id',
                'ctrl'   => 'OA_Admin_Statistics_Delivery_CommonEntity',
                'format' => 'id'
            );
        $this->_aFields['sum_requests'] =
            array(
                'name'   => $GLOBALS['strRequests'],
                'short'  => $GLOBALS['strRequests_short'],
                'pref'   => 'ui_column_requests',
                'active' => true,
                'format' => 'default'
            );

        $this->_aFields['sum_views'] =
            array(
                'name'   => $GLOBALS['strImpressions'],
                'short'  => $GLOBALS['strImpressions_short'],
                'pref'   => 'ui_column_impressions',
                'rank'   => 1,
                'active' => true,
                'format' => 'default'
            );

        $this->_aFields['sum_clicks'] =
            array(
                'name'   => $GLOBALS['strClicks'],
                'short'  => $GLOBALS['strClicks_short'],
                'pref'   => 'ui_column_clicks',
                'rank'   => 2,
                'active' => true,
                'format' => 'default'
            );

        $this->_aFields['sum_ctr'] =
            array(
                'name'   => $GLOBALS['strCTR'],
                'short'  => $GLOBALS['strCTR_short'],
                'pref'   => 'ui_column_ctr',
                'rank'   => 3,
                'format' => 'percent'
            );

        $this->_aFields['sum_conversions'] =
            array(
                'name'    => $GLOBALS['strConversions'],
                'short'   => $GLOBALS['strConversions_short'],
                'pref'    => 'ui_column_conversions',
                'link'    => 'stats.php?entity=conversions&',
                'active'  => true,
                'format'  => 'default',
                'ctf'     => true
            );

        $this->_aFields['sum_conversions_pending'] =
            array(
                'name'    => $GLOBALS['strPendingConversions'],
                'short'   => $GLOBALS['strPendingConversions_short'],
                'pref'    => 'ui_column_conversions_pending',
                'link'    => 'stats.php?entity=conversions&',
                'active'  => true,
                'format'  => 'default',
                'ctf'     => true
            );

        $this->_aFields['sum_sr_views'] =
            array(
                'name'    => $GLOBALS['strImpressionSR'],
                'short'   => $GLOBALS['strImpressionSR_short'],
                'pref'    => 'ui_column_sr_views',
                'format'  => 'percent',
                'ctf'     => true
            );

        $this->_aFields['sum_sr_clicks'] =
            array(
                'name'    => $GLOBALS['strClickSR'],
                'short'   => $GLOBALS['strClickSR_short'],
                'pref'    => 'ui_column_sr_clicks',
                'format'  => 'percent',
                'ctf'     => true
            );

    }

    function mergeData(&$aRows, $emptyRow, $method, $aParams)
    {
        $this->mergeConversions($aRows, $emptyRow, $method, $aParams);
    }

    /**
     * Generate CTR and SR ratios
     *
     * @static
     *
     * @param array Row of stats
     */
    function summarizeStats(&$row)
    {
        $row['sum_ctr']       = $row['sum_views']  ? $row['sum_clicks'] / $row['sum_views'] : 0;
        $row['sum_sr_views']  = $row['sum_views'] && isset($row['sum_conversions_'.MAX_CONNECTION_AD_IMPRESSION]) ?
                                    $row['sum_conversions_'.MAX_CONNECTION_AD_IMPRESSION] / $row['sum_views'] : 0;
        $row['sum_sr_clicks'] = $row['sum_clicks'] && isset($row['sum_conversions_'.MAX_CONNECTION_AD_CLICK]) ?
                                    $row['sum_conversions_'.MAX_CONNECTION_AD_CLICK] / $row['sum_clicks'] : 0;
    }
}

?>
