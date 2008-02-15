<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
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

require_once MAX_PATH . '/plugins/statisticsFieldsDelivery/statisticsFieldsDelivery.php';
require_once MAX_PATH . '/lib/max/Plugin/Translation.php';

/**
 * The affiliates delivery statistics fields plugin.
 *
 * @abstract
 * @package    OpenXPlugin
 * @subpackage StatisticsFields
 * @author     Matteo Beccati <matteo@beccati.com>
 */
class Plugins_statisticsFieldsDelivery_affiliates_affiliates extends Plugins_statisticsFieldsDelivery_statisticsFieldsDelivery
{
    /**
     * Constructor
     */
    function Plugins_statisticsFieldsDelivery_affiliates_affiliates()
    {
        // Set ordering to a high value to move columns to the right
        $this->displayOrder = 10;

        // Set module and package because they aren't set when running the constructor method
        $this->module  = 'statisticsFieldsDelivery';
        $this->package = 'affiliates';

        $this->_aFields = array(
            'sum_revenue'               => array('name'  => MAX_Plugin_Translation::translate('_Revenue', $this->module, $this->package),
                                                'short'  => MAX_Plugin_Translation::translate('Revenue', $this->module, $this->package),
                                                'rank'   => 4,
                                                'pref'   => 'ui_column_revenue',
                                                'format' => 'currency'),
            'sum_cost'                  => array('name'  => MAX_Plugin_Translation::translate('_Cost', $this->module, $this->package),
                                                'short'  => MAX_Plugin_Translation::translate('Cost', $this->module, $this->package),
                                                'pref'   => 'ui_column_cost',
                                                'format' => 'currency'),
            /*
            'sum_bv'                    => array('name'  => MAX_Plugin_Translation::translate('_Basket value', $this->module, $this->package),
                                                'short'  => MAX_Plugin_Translation::translate('Basket value', $this->module, $this->package),
                                                'pref'   => 'ui_column_bv',
                                                'format' => 'currency'),
            'sum_num_items'             => array('name'  => MAX_Plugin_Translation::translate('_Number of items', $this->module, $this->package),
                                                'short'  => MAX_Plugin_Translation::translate('Number of items', $this->module, $this->package),
                                                'pref'   => 'ui_column_num_items',
                                                'format' => 'default'),
            */
            'sum_revcpc'                => array('name'  => MAX_Plugin_Translation::translate('_Revenue CPC', $this->module, $this->package),
                                                'short'  => MAX_Plugin_Translation::translate('Revenue CPC', $this->module, $this->package),
                                                'pref'   => 'ui_column_revcpc',
                                                'format' => 'currency'),
            'sum_costcpc'               => array('name'  => MAX_Plugin_Translation::translate('_Cost CPC', $this->module, $this->package),
                                                'short'  => MAX_Plugin_Translation::translate('Cost CPC', $this->module, $this->package),
                                                'pref'   => 'ui_column_costcpc',
                                                'format' => 'currency'),

            'sum_technology_cost'       => array('name'  => MAX_Plugin_Translation::translate('_Technology Cost', $this->module, $this->package),
                                                'short'  => MAX_Plugin_Translation::translate('Technology Cost', $this->module, $this->package),
                                                'pref'   => 'ui_column_technology_cost',
                                                'format' => 'currency'),
            'sum_income'                => array('name'  => MAX_Plugin_Translation::translate('_Income', $this->module, $this->package),
                                                'short'  => MAX_Plugin_Translation::translate('Income', $this->module, $this->package),
                                                'pref'   => 'ui_column_income',
                                                'format' => 'currency'),
            'sum_income_margin'         => array('name'  => MAX_Plugin_Translation::translate('_Income Margin', $this->module, $this->package),
                                                'short'  => MAX_Plugin_Translation::translate('Income Margin', $this->module, $this->package),
                                                'pref'   => 'ui_column_income_margin',
                                                'format' => 'currency'),
            'sum_profit'                => array('name'  => MAX_Plugin_Translation::translate('_Profit', $this->module, $this->package),
                                                'short'  => MAX_Plugin_Translation::translate('Profit', $this->module, $this->package),
                                                'pref'   => 'ui_column_profit',
                                                'format' => 'currency'),
            'sum_margin'                => array('name'  => MAX_Plugin_Translation::translate('_Margin', $this->module, $this->package),
                                                'short'  => MAX_Plugin_Translation::translate('Margin', $this->module, $this->package),
                                                'pref'   => 'ui_column_margin',
                                                'format' => 'currency'),
            'sum_erpm'                  => array('name'  => MAX_Plugin_Translation::translate('_ERPM', $this->module, $this->package),
                                                'short'  => MAX_Plugin_Translation::translate('ERPM', $this->module, $this->package),
                                                'pref'   => 'ui_column_erpm',
                                                'format' => 'currency'),
            'sum_erpc'                  => array('name'  => MAX_Plugin_Translation::translate('_ERPC', $this->module, $this->package),
                                                'short'  => MAX_Plugin_Translation::translate('ERPC', $this->module, $this->package),
                                                'pref'   => 'ui_column_erpc',
                                                'format' => 'currency'),
            /*
            'sum_erps'                  => array('name'   => MAX_Plugin_Translation::translate('_ERPS', $this->module, $this->package),
                                                'short'  => MAX_Plugin_Translation::translate('ERPS', $this->module, $this->package),
                                                'pref'   => 'ui_column_erps',
                                                'format' => 'currency'),
            */
            'sum_eipm'                  => array('name'  => MAX_Plugin_Translation::translate('_EIPM', $this->module, $this->package),
                                                'short'  => MAX_Plugin_Translation::translate('EIPM', $this->module, $this->package),
                                                'pref'   => 'ui_column_eipm',
                                                'format' => 'currency'),
            'sum_eipc'                  => array('name'  => MAX_Plugin_Translation::translate('_EIPC', $this->module, $this->package),
                                                'short'  => MAX_Plugin_Translation::translate('EIPC', $this->module, $this->package),
                                                'pref'   => 'ui_column_eipc',
                                                'format' => 'currency'),
            /*
            'sum_eips'                  => array('name'   => MAX_Plugin_Translation::translate('_EIPS', $this->module, $this->package),
                                                'short'  => MAX_Plugin_Translation::translate('EIPS', $this->module, $this->package),
                                                'pref'   => 'ui_column_eips',
                                                'format' => 'currency'),
            */
            'sum_ecpm'                  => array('name'  => MAX_Plugin_Translation::translate('_ECPM', $this->module, $this->package),
                                                'short'  => MAX_Plugin_Translation::translate('ECPM', $this->module, $this->package),
                                                'rank'   => 5,
                                                'pref'   => 'ui_column_ecpm',
                                                'format' => 'currency'),
            'sum_ecpc'                  => array('name'  => MAX_Plugin_Translation::translate('_ECPC', $this->module, $this->package),
                                                'short'  => MAX_Plugin_Translation::translate('ECPC', $this->module, $this->package),
                                                'pref'   => 'ui_column_ecpc',
                                                'format' => 'currency'),
            /*
            'sum_ecps'                  => array('name'  => MAX_Plugin_Translation::translate('_ECPS', $this->module, $this->package),
                                                'short'  => MAX_Plugin_Translation::translate('ECPS', $this->module, $this->package),
                                                'pref'   => 'ui_column_ecps',
                                                'format' => 'currency')
            */
        );
    }

    /**
     * A method to return the name of the plugin.
     *
     * @return string A string describing the plugin class.
     */
    function getName()
    {
        return 'Affiliate delivery statistics columns plugin.';
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
