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

// Require the initialisation file
require_once '../../init.php';

// Required files
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/www/admin/lib-statistics.inc.php';

require_once MAX_PATH . '/lib/max/other/common.php';
require_once MAX_PATH . '/lib/max/Admin_DA.php';
require_once MAX_PATH . '/lib/max/other/stats.php';

require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/lib/OA/ServiceLocator.php';

require_once LIB_PATH . '/Dal/Maintenance/Statistics/Factory.php';
require_once LIB_PATH . '/OperationInterval.php';
require_once OX_PATH . '/lib/pear/Date.php';

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
$pageID        = MAX_getValue('pageID');
$setPerPage    = MAX_getValue('setPerPage');

$aParams = array();

$aParams['clientid']   = $clientId;
$aParams['campaignid'] = $campaignId;
$aParams['bannerid']   = $bannerId;

// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_MANAGER);

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

// Restrict to the current manager ID
$aParams['agency_id'] = OA_Permission::getAgencyId();

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
            $doData_intermediate_ad_connection = OA_Dal::factoryDO('data_intermediate_ad_connection');
            $doData_intermediate_ad_connection->get($conversionId);
            $doData_intermediate_ad_connection->connection_status = $statusId;
            $doData_intermediate_ad_connection->update();

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
                $oConnectionDate = new Date($dateTime);
                $oConnectionDate->toUTC();

                $optIntID = OX_OperationInterval::convertDateToOperationIntervalID($oConnectionDate);
                $opDay = $oConnectionDate->format('%Y-%m-%d');
                $opHour = $oConnectionDate->format('%H');

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
                $dalData_intermediate_ad = OA_Dal::factoryDAL('data_intermediate_ad');
                $dalData_intermediate_ad->addConversion($operation,
                    $basketValue, $numItems, $ad_id,
                    $creative_id, $zone_id, $opDay, $opHour);

                // Update "$data_summary_table" table
                $dalData_intermediate_ad->addConversion($operation,
                    $basketValue, $numItems, $ad_id,
                    $creative_id, $zone_id, $opDay, $opHour, $data_summary_table);

                // Update finance info
                $oServiceLocator =& OA_ServiceLocator::instance();
                $oDal = &$oServiceLocator->get('OX_Dal_Maintenance_Statistics');
                if (!$oDal) {
                    $oFactory = new OX_Dal_Maintenance_Statistics_Factory();
                    $oDal = $oFactory->factory();
                }
                $oStartDate = new Date($oConnectionDate->format('%Y-%m-%d %H:00:00'));
                $oEndDate   = new Date($oConnectionDate->format('%Y-%m-%d %H:00:00'));
                $oDal->_saveSummaryUpdateWithFinanceInfo($oStartDate, $oEndDate, $data_summary_table);

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
        $cache->clean(OX_getHostName().'stats');
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
if (!empty($pageID)) {
    $addUrl .= "&pageID={$pageID}";
}
if (!empty($setPerPage)) {
    $addUrl .= "&setPerPage={$setPerPage}";
}

Header ("Location: ".$returnurl."?".$addUrl);

?>
