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

// Require the initialisation file
require_once '../../init.php';

// Required files
require_once MAX_PATH . '/lib/max/Admin/Redirect.php';
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/lib/max/Plugin.php';
require_once MAX_PATH . '/lib/max/Admin/UI/Field/DaySpanField.php';

require_once MAX_PATH . '/lib/OA/Dal/Maintenance/Statistics/AdServer/mysql.php';

// Security check
//OA_Permission::enforceAccount(OA_ACCOUNT_ADMIN, OA_ACCOUNT_ADVERTISER);

// Switched off
OA_Permission::enforceAccount(0);


phpAds_registerGlobal('zoneid', 'cost', 'cost_type', 'cost_variable_id', 'cost_variable_id_mult', 'technology_cost', 'technology_cost_type', 'action');

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

//phpAds_PageHeader("5.4");
//phpAds_ShowSections(array("5.1", "5.2", "5.4", "5.5", "5.3", "5.6", "5.7"));

/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

$oServiceLocator =& OA_ServiceLocator::instance();
$oDal = &$oServiceLocator->get('OA_Dal_Maintenance_Statistics_AdServer_mysql');
if (!$oDal) {
    $oDal = & new OA_Dal_Maintenance_Statistics_AdServer_mysql;
}

$oDaySpan =& new Admin_UI_DaySpanField('period');
$oDaySpan->setValueFromArray($_POST);

if (!empty($oDaySpan->_value)) {
    $aPeriod = $oDaySpan->getDaySpanArray();

    $oStartDate =& new Date($aPeriod['day_begin'].' 00:00:00');
    $oEndDate   =& new Date($aPeriod['day_end'].' 23:59:59');
} else {
    $oStartDate =& new Date('2000-01-01 00:00:00');
    $oEndDate   =& new Date(date('Y-m-d').' 23:59:59');
}

// If using multiple variable values with MAX_FINANCE_VARSUM, then combine these variable_ids into a list
if ($cost_type == MAX_FINANCE_VARSUM && is_array($cost_variable_id_mult)) {
    $cost_variable_id = 0;
    foreach ($cost_variable_id_mult as $val) {
        if ($cost_variable_id) {
            $cost_variable_id .= "," . $val;
        } else {
            $cost_variable_id = $val;
        }
    }
}

$aZoneFinanceInfo = array(array(
    'zone_id'               => $zoneid,
    'cost'                  => $cost,
    'cost_type'             => $cost_type,
    'cost_variable_id'      => $cost_variable_id,
    'technology_cost'       => $technology_cost,
    'technology_cost_type'  => $technology_cost_type
));

$oDal->_updateZonesWithFinanceInfo($aZoneFinanceInfo, $oStartDate, $oEndDate, 'data_summary_ad_hourly');

$plugins = &MAX_Plugin::getPlugins('Maintenance');
foreach($plugins as $plugin) {
    if ($plugin->getHook() == MSE_PLUGIN_HOOK_AdServer_saveSummary) {
        $plugin->serviceLocatorRegister();

        $data_summary_table = $oServiceLocator->get('financeSummaryTable');

        if (empty($data_summary_table)) {
            $data_summary_table = 'data_summary_ad_hourly';
        }

        $oDal->_updateZonesWithFinanceInfo($aZoneFinanceInfo, $oStartDate, $oEndDate, $data_summary_table);

        $plugin->serviceLocatorRemove();
    }
}

MAX_Admin_Redirect::redirect('maintenance-finance.php');

?>
