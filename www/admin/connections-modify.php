<?php

/*
+---------------------------------------------------------------------------+
| Max Media Manager v0.3                                                    |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2005 Awarez Ltd.                                       |
| For contact details, see: http://www.awarez.net/                          |
|                                                                           |
| Copyright (c) 2000-2003 the phpAdsNew developers                          |
| For contact details, see: http://www.phpadsnew.com/                       |
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
$Id: connections-modify.php 6234 2006-12-11 10:07:57Z andrew@m3.net $
*/

// Require the initialisation file
require_once '../../init.php';

// Required files
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/www/admin/lib-statistics.inc.php';
require_once MAX_PATH . '/lib/max/other/common.php';
require_once MAX_PATH . '/lib/max/Admin_DA.php';
require_once MAX_PATH . '/lib/max/other/stats.php';
require_once MAX_PATH . '/lib/max/OperationInterval.php';
require_once MAX_PATH . '/lib/max/core/ServiceLocator.php';
require_once MAX_PATH . '/lib/max/Dal/Maintenance/Statistics/AdServer/mysql.php';

require_once 'Date.php';

$clientId      = MAX_getValue('clientid');
$campaignId    = MAX_getValue('campaignid');
$bannerId      = MAX_getValue('bannerid');
$affiliateId   = MAX_getValue('affiliteid');
$zoneId        = MAX_getValue('zoneid');
$period_preset = MAX_getValue('period_preset');
$period_start  = MAX_getValue('period_start');
$period_end    = MAX_getValue('period_end');
$day           = MAX_getValue('day');
$howLong       = MAX_getValue('howLong');
$hour          = MAX_getValue('hour');
$returnurl     = MAX_getValue('returnurl');
$statusIds     = MAX_getValue('statusIds');

$aParams = array();

$aParams['clientid']   = $clientId;
$aParams['campaignid'] = $campaignId;
$aParams['bannerid']   = $bannerId;

// Security check
phpAds_checkAccess(phpAds_Admin + phpAds_Agency);

if (phpAds_isUser(phpAds_Agency) && !phpAds_isAllowed(phpAds_EditConversions)) {
    // editing statuses is allowed only if an agency have a proper right
    phpAds_PageHeader(0);
    phpAds_Die($strAccessDenied, $strNotAdmin);
}

if (!empty($day)) {
    // Reset period
    $period_preset = '';
    // Always refresh howLong and hour
    $howLong = MAX_getValue('howLong', 'd');
    $hour    = MAX_getValue('hour');
} else {
    $period_preset  = MAX_getStoredValue('period_preset', 'today');
    $period_start   = MAX_getStoredValue('period_start', date('Y-m-d'));
    $period_end     = MAX_getStoredValue('period_end', date('Y-m-d'));
}

if(!empty($period_preset)) {
    $aDates = MAX_getDatesByPeriod($period_preset, $period_start, $period_end);
} else {
    $aDates = array();
    $oDayDate = new Date();
    $oDayDate->setDate($day, DATE_FORMAT_TIMESTAMP);
    if(!empty($hour)) {
        // If hour is set build day date including hour
        $aDates['day_hour'] = $oDayDate->format('%Y-%m-%d').' '.$hour;
    } else {
        // Build month, day, day_begin and day_end dependends on $howLong
        switch($howLong) {
            case 'm':
                $aDates['month'] = $oDayDate->format('%Y-%m');
                break;
            case 'w':
                $aDates['day_begin'] = $oDayDate->format('%Y-%m-%d');
                $oDayDate->addSeconds(60*60*24*7); // Add 7 days
                $aDates['day_end'] = $oDayDate->format('%Y-%m-%d');
                break;
            case 'd':
            default:
                $aDates['day'] = $oDayDate->format('%Y-%m-%d');
                break;
        }
    }
}

if (!phpAds_isUser(phpAds_Admin)) {
    $aParams['agency_id'] = phpAds_getAgencyID();
}

/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

// Get conversions - additional security check which allow to edit only those conversions visible to user
$aConversions = Admin_DA::getConversions($aParams + $aDates);
if (!empty($aConversions))
{
    $conf = $GLOBALS['_MAX']['CONF'];

    $modified = false;

    // Modify conversions
    foreach($statusIds as $conversionId => $statusId) {
        if(isset($aConversions[$conversionId]) && $aConversions[$conversionId]['connection_status'] != $statusId) {

            $modified = true;

            // Edit conversion
            $query = 'UPDATE '.$conf['table']['prefix'].$conf['table']['data_intermediate_ad_connection']
                    .' SET connection_status = '.$statusId
                    .', updated = "'.date('Y-m-d H:i:s').'"'
                    .' WHERE data_intermediate_ad_connection_id='.$conversionId;

            $res = phpAds_dbQuery($query) or phpAds_sqlDie();

            if($aConversions[$conversionId]['connection_status'] == MAX_CONNECTION_STATUS_APPROVED || $statusId == MAX_CONNECTION_STATUS_APPROVED) {
                // Connection was changed to conversion (or conversion was changed to connection)
                $aConVariables = Admin_DA::fromCache('getConnectionVariables', $conversionId);
                // Sum up basket values
                $basketValue = 0;
                $numItems    = 0;
                foreach($aConVariables as $conVariable) {
                    if($conVariable['purpose'] == 'basket_value') {
                        $basketValue += $conVariable['value'];
                    } elseif ($conVariable['purpose'] == 'num_items') {
                        $numItems    += $conVariable['value'];
                    }
                }

                // Get day, $hour and operation interval
                $dateTime = $aConversions[$conversionId]['date_time'];
                $oConnectionDate = &new Date($dateTime);

                $optIntID = MAX_OperationInterval::convertDateToOperationIntervalID($oConnectionDate);
                $day = $oConnectionDate->format('%Y-%m-%d');
                $hour = $oConnectionDate->format('%H');

                // Get ad_id, creative_id and zone_id
                $ad_id = $aConversions[$conversionId]['ad_id'];
                $creative_id = $aConversions[$conversionId]['creative_id'];
                $zone_id = $aConversions[$conversionId]['zone_id'];

                $operation = null;
                // If conversion was changed to connection
                if($aConversions[$conversionId]['connection_status'] == MAX_CONNECTION_STATUS_APPROVED) {
                    // Substract conversion from "data_intermediate_ad" and from "data_summary_ad_hourly"
                    // and remove $connectionBasketValue from total_basket_value
                    $operation = '-';
                }

                // If connection was changed to conversion
                if($statusId == MAX_CONNECTION_STATUS_APPROVED) {
                    // Add new conversion to "data_intermediate_ad" and from "data_summary_ad_hourly"
                    // and add $connectionBasketValue to total_basket_value
                    $operation = '+';
                }

                // Pick the right table
                if ($aConversions[$conversionId]['connection_action'] == MAX_CONNECTION_AD_ARRIVAL) {
                    $data_summary_table = 'data_summary_ad_arrival_hourly';

                    // Run serviceLocator register functions
                    $plugins = &MAX_Plugin::getPlugins('Maintenance');
                    foreach($plugins as $plugin) {
                        if ($plugin->getHook() == MSE_PLUGIN_HOOK_AdServer_saveSummary) {
                            $plugin->serviceLocatorRegister();

                            // Make sure it is the arrival plugin
                            if ($oServiceLocator->get('financeSummaryTable') == $data_summary_table) {
                                break;
                            } else {
                                $plugin->serviceLocatorRemove();
                            }
                        }
                    }

                } else {
                    $plugin = null;
                    $data_summary_table = 'data_summary_ad_hourly';
                }

                // Update "data_intermediate_ad" table
                $query = 'UPDATE '.$conf['table']['prefix'].$conf['table']['data_intermediate_ad']
                    .' SET conversions=conversions'.$operation.'1, '
                    .' total_basket_value=total_basket_value'.$operation.$basketValue
                    .', total_num_items=total_num_items'.$operation.$numItems
                    .', updated = "'.date('Y-m-d H:i:s').'"'
                    ." WHERE
                           ad_id=$ad_id
                       AND creative_id=$creative_id
                       AND zone_id=$zone_id
                       AND day='$day'
                       AND operation_interval_id=$optIntID";
                $res = phpAds_dbQuery($query) or phpAds_sqlDie();

                // Update "data_summary_ad_hourly" table
                $query = 'UPDATE '.$conf['table']['prefix'].$conf['table'][$data_summary_table]
                    .' SET conversions=conversions'.$operation.'1, '
                    .' total_basket_value=total_basket_value'.$operation.$basketValue
                    .', total_num_items=total_num_items'.$operation.$numItems
                    .', updated = "'.date('Y-m-d H:i:s').'"'
                    ." WHERE
                           ad_id=$ad_id
                       AND creative_id=$creative_id
                       AND zone_id=$zone_id
                       AND day='$day'
                       AND hour=$hour";
                $res = phpAds_dbQuery($query) or phpAds_sqlDie();

                // Update finance info
                $oServiceLocator = &ServiceLocator::instance();
                $oDal = &$oServiceLocator->get('MAX_Dal_Maintenance_Statistics_AdServer_mysql');
                if (!$oDal) {
                    $oDal = new MAX_Dal_Maintenance_Statistics_AdServer_mysql;
                }
                $oStartDate = new Date($oConnectionDate->format('%Y-%m-%d %H:00:00'));
                $oEndDate   = new Date($oConnectionDate->format('%Y-%m-%d %H:00:00'));
                $oDal->_updateWithFinanceInfo($oStartDate, $oEndDate, $data_summary_table);

                if (!is_null($plugin)) {
                    $plugin->serviceLocatorRemove();
                }
            }
        }
    }
    if($modified) {
        // Clear cache
        include_once 'Cache/Lite.php';
        $options = array(
                'cacheDir' => MAX_CACHE,
        );
        $cache = new Cache_Lite($options);
        $cache->clean('stats');
    }
}

$addUrl = "entity=conversions&clientid=$clientId&campaignid=$campaignId&bannerid=$bannerId&affiliateid=$affiliateId&zoneid=$zoneId";

if (!empty($period_preset)) {
    $addUrl .= "&period_preset={$period_preset}&period_start={$period_start}&period_end={$period_end}";
}
if (!empty($day)) {
    $addUrl .= "&day={$day}";
}
if (!empty($howLong)) {
    $addUrl .= "&howLong={$howLong}";
}
if (!empty($hour)) {
    $addUrl .= "&hour={$hour}";
}

Header ("Location: ".$returnurl."?".$addUrl);

?>
