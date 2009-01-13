<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
| For contact details, see: http://www.openx.org/                           |
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

require_once MAX_PATH . '/lib/OA/Admin/Statistics/Fields/Delivery.php';

/**
 * The affiliates delivery statistics fields plugin.
 *
 * @abstract
 * @package    OpenXPlugin
 * @subpackage StatisticsFields
 * @author     Matteo Beccati <matteo@beccati.com>
 */
class OA_StatisticsFieldsDelivery_Affiliates extends OA_StatisticsFieldsDelivery
{
    /**
     * Constructor
     */
    function OA_StatisticsFieldsDelivery_Affiliates()
    {

        $aConf = $GLOBALS['_MAX']['CONF'];

        // Set ordering to a high value to move columns to the right
        $this->displayOrder = 10;

        // Set module and package because they aren't set when running the constructor method
        /*$this->module  = 'statisticsFieldsDelivery';
        $this->package = 'affiliates';*/

        $this->_aFields = array();

        $this->_aFields['sum_revenue'] =
            array(
                'name'   => $GLOBALS['strRevenue'],
                'short'  => $GLOBALS['strRevenue_short'],
                'rank'   => 4,
                'pref'   => 'ui_column_revenue',
                'format' => 'currency'
            );

        $this->_aFields['sum_cost'] =
            array(
                'name'   => $GLOBALS['strCost'],
                'short'  => $GLOBALS['strCost_short'],
                'pref'   => 'ui_column_cost',
                'format' => 'currency'
            );

        $this->_aFields['sum_bv'] =
            array(
                'name'   => $GLOBALS['strBasketValue'],
                'short'  => $GLOBALS['strBasketValue_short'],
                'pref'   => 'ui_column_bv',
                'format' => 'currency',
                'ctf'    => true
            );

        $this->_aFields['sum_num_items'] =
            array(
                'name'   => $GLOBALS['strNumberOfItems'],
                'short'  => $GLOBALS['strNumberOfItems_short'],
                'pref'   => 'ui_column_num_items',
                'format' => 'default',
                'ctf'    => true
            );

        $this->_aFields['sum_revcpc'] =
            array(
                'name'   => $GLOBALS['strRevenueCPC'],
                'short'  => $GLOBALS['strRevenueCPC_short'],
                'pref'   => 'ui_column_revcpc',
                'format' => 'currency'
            );

        $this->_aFields['sum_costcpc'] =
            array(
                'name'   => $GLOBALS['strCostCPC'],
                'short'  => $GLOBALS['strCostCPC_short'],
                'pref'   => 'ui_column_costcpc',
                'format' => 'currency'
            );

        $this->_aFields['sum_technology_cost'] =
            array(
                'name'   => $GLOBALS['strTechnologyCost'],
                'short'  => $GLOBALS['strTechnologyCost_short'],
                'pref'   => 'ui_column_technology_cost',
                'format' => 'currency'
            );

        $this->_aFields['sum_income'] =
            array(
                'name'   => $GLOBALS['strIncome'],
                'short'  => $GLOBALS['strIncome_short'],
                'pref'   => 'ui_column_income',
                'format' => 'currency'
            );

        $this->_aFields['sum_income_margin'] =
            array(
                'name'   => $GLOBALS['strIncomeMargin'],
                'short'  => $GLOBALS['strIncomeMargin_short'],
                'pref'   => 'ui_column_income_margin',
                'format' => 'currency'
            );

        $this->_aFields['sum_profit'] =
            array(
                'name'   => $GLOBALS['strProfit'],
                'short'  => $GLOBALS['strProfit_short'],
                'pref'   => 'ui_column_profit',
                'format' => 'currency'
            );

        $this->_aFields['sum_margin'] =
            array(
                'name'   => $GLOBALS['strMargin'],
                'short'  => $GLOBALS['strMargin_short'],
                'pref'   => 'ui_column_margin',
                'format' => 'currency'
            );

        $this->_aFields['sum_erpm'] =
            array(
                'name'   => $GLOBALS['strERPM'],
                'short'  => $GLOBALS['strERPM_short'],
                'pref'   => 'ui_column_erpm',
                'format' => 'currency'
            );

        $this->_aFields['sum_erpc'] =
            array(
                'name'   => $GLOBALS['strERPC'],
                'short'  => $GLOBALS['strERPC_short'],
                'pref'   => 'ui_column_erpc',
                'format' => 'currency'
            );

        $this->_aFields['sum_erps'] =
            array(
                'name'   => $GLOBALS['strERPS'],
                'short'  => $GLOBALS['strERPS_short'],
                'pref'   => 'ui_column_erps',
                'format' => 'currency',
                'ctf'    => true
            );

        $this->_aFields['sum_eipm'] =
            array(
                'name'   => $GLOBALS['strEIPM'],
                'short'  => $GLOBALS['strEIPM_short'],
                'pref'   => 'ui_column_eipm',
                'format' => 'currency'
            );

        $this->_aFields['sum_eipc'] =
            array(
                'name'   => $GLOBALS['strEIPC'],
                'short'  => $GLOBALS['strEIPC_short'],
                'pref'   => 'ui_column_eipc',
                'format' => 'currency'
            );

        $this->_aFields['sum_eips'] =
            array(
                'name'   => $GLOBALS['strEIPS'],
                'short'  => $GLOBALS['strEIPS_short'],
                'pref'   => 'ui_column_eips',
                'format' => 'currency',
                'ctf'    => true
            );

        $this->_aFields['sum_ecpm'] =
            array(
                'name'   => $GLOBALS['strECPM'],
                'short'  => $GLOBALS['strECPM_short'],
                'rank'   => 5,
                'pref'   => 'ui_column_ecpm',
                'format' => 'currency'
            );

        $this->_aFields['sum_ecpc'] =
            array(
                'name'   => $GLOBALS['strECPC'],
                'short'  => $GLOBALS['strECPC_short'],
                'pref'   => 'ui_column_ecpc',
                'format' => 'currency'
            );

        $this->_aFields['sum_ecps'] =
            array(
                'name'   => $GLOBALS['strECPS'],
                'short'  => $GLOBALS['strECPS_short'],
                'pref'   => 'ui_column_ecps',
                'format' => 'currency',
                'ctf'    => true
            );

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
        $aParams = array();
        $aParams['custom_table']   = 'data_intermediate_ad_connection';
        $aParams['custom_columns'] = array("DATE_FORMAT(MIN(tracker_date_time), '%Y-%m-%d')" => 'start_date');
        return $aParams;
    }

    function addQueryParams(&$aParams)
    {
        $aParams['add_columns']['SUM(s.total_revenue)']      = 'sum_revenue';
        $aParams['add_columns']['SUM(s.total_cost)']         = 'sum_cost';
        $aParams['add_columns']['SUM(s.total_techcost)']     = 'sum_technology_cost';
        $aParams['add_columns']['SUM(s.total_basket_value)'] = 'sum_bv';
        $aParams['add_columns']['SUM(s.total_num_items)']    = 'sum_num_items';
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
        $row['sum_revcpc']          = $row['sum_clicks'] ? $row['sum_revenue'] / $row['sum_clicks'] : 0;
        $row['sum_costcpc']         = $row['sum_clicks'] ? $row['sum_cost'] / $row['sum_clicks'] : 0;
        $row['sum_income']          = $row['sum_revenue'] - $row['sum_technology_cost'];
        $row['sum_income_margin']   = $row['sum_revenue'] ? $row['sum_income'] / $row['sum_revenue'] : 0;
        $row['sum_profit']          = $row['sum_revenue'] - $row['sum_technology_cost'] - $row['sum_cost'];
        $row['sum_margin']          = $row['sum_revenue'] ? $row['sum_profit'] / $row['sum_revenue'] : 0;
        $row['sum_erpm']            = $row['sum_views'] ? $row['sum_revenue'] / $row['sum_views'] * 1000 : 0;
        $row['sum_erpc']            = $row['sum_clicks'] ? $row['sum_revenue'] / $row['sum_clicks'] : 0;
        $row['sum_erps']            = $row['sum_conversions'] ? $row['sum_revenue'] / $row['sum_conversions'] : 0;
        $row['sum_eipm']            = $row['sum_views'] ? $row['sum_income'] / $row['sum_views'] * 1000 : 0;
        $row['sum_eipc']            = $row['sum_conversions'] ? $row['sum_income'] / $row['sum_clicks']: 0;
        $row['sum_eips']            = $row['sum_conversions'] ? $row['sum_income'] / $row['sum_conversions']: 0;
        $row['sum_ecpm']            = $row['sum_views'] ? $row['sum_revenue'] / $row['sum_views'] * 1000 : 0;
        $row['sum_ecpc']            = $row['sum_clicks'] ? $row['sum_revenue'] / $row['sum_clicks']: 0;
        $row['sum_ecps']            = $row['sum_conversions'] ? $row['sum_revenue'] / $row['sum_conversions']: 0;
    }
}

?>
