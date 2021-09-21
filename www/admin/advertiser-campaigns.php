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
require_once MAX_PATH . '/lib/OX/Util/Utils.php';

// Required files
require_once MAX_PATH . '/www/admin/lib-maintenance-priority.inc.php';
require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/lib/OA/Dll.php';
require_once MAX_PATH . '/lib/max/Dal/DataObjects/Campaigns.php';
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/www/admin/lib-statistics.inc.php';
require_once MAX_PATH . '/lib/OA/Permission.php';
require_once MAX_PATH . '/lib/pear/Date.php';
require_once MAX_PATH . '/lib/max/other/html.php';
require_once MAX_PATH . '/lib/OX/Admin/UI/ViewHooks.php';

require_once RV_PATH . '/lib/RV/Admin/DateTimeFormat.php';

phpAds_registerGlobalUnslashed('hideinactive', 'listorder', 'orderdirection');

// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_MANAGER, OA_ACCOUNT_ADVERTISER);
if (!empty($clientid) && !OA_Permission::hasAccessToObject('clients', $clientid, OA_Permission::OPERATION_VIEW)) { //check if can see given advertiser
    $page = basename($_SERVER['SCRIPT_NAME']);
    OX_Admin_Redirect::redirect($page);
}


/*-------------------------------------------------------*/
/* Init data                                             */
/*-------------------------------------------------------*/
//get advertisers and set the current one
$aAdvertisers = getAdvertiserMap();
if (empty($clientid)) { //if it's empty
    if ($session['prefs']['inventory_entities'][OA_Permission::getEntityId()]['clientid']) {
        //try previous one from session
        $sessionClientId = $session['prefs']['inventory_entities'][OA_Permission::getEntityId()]['clientid'];
        if (isset($aAdvertisers[$sessionClientId])) { //check if 'id' from session was not removed
            $clientid = $sessionClientId;
        }
    }
    if (empty($clientid)) { //was empty, is still empty - just pick one, no need for redirect
        $ids = array_keys($aAdvertisers);
        $clientid = !empty($ids) ? $ids[0] : -1; //if no advertisers set to non-existent id
    }
} else {
    if (!isset($aAdvertisers[$clientid])) {
        $page = basename($_SERVER['SCRIPT_NAME']);
        OX_Admin_Redirect::redirect($page);
    }
}


/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

$oHeaderModel = buildHeaderModel($clientid, $aAdvertisers);
phpAds_PageHeader(null, $oHeaderModel);


/*-------------------------------------------------------*/
/* Get preferences                                       */
/*-------------------------------------------------------*/

if (!isset($hideinactive)) {
    if (isset($session['prefs']['advertiser-campaigns.php'][$clientid]['hideinactive'])) {
        $hideinactive = $session['prefs']['advertiser-campaigns.php'][$clientid]['hideinactive'];
    } else {
        $pref = &$GLOBALS['_MAX']['PREF'];
        $hideinactive = ($pref['ui_hide_inactive'] == true);
    }
}

if (!isset($listorder)) {
    if (isset($session['prefs']['advertiser-campaigns.php'][$clientid]['listorder'])) {
        $listorder = $session['prefs']['advertiser-campaigns.php'][$clientid]['listorder'];
    } else {
        $listorder = '';
    }
}

if (!isset($orderdirection)) {
    if (isset($session['prefs']['advertiser-campaigns.php'][$clientid]['orderdirection'])) {
        $orderdirection = $session['prefs']['advertiser-campaigns.php'][$clientid]['orderdirection'];
    } else {
        $orderdirection = '';
    }
}


/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

require_once MAX_PATH . '/lib/OA/Admin/Template.php';

$oTpl = new OA_Admin_Template('campaign-index.html');


// Get clients & campaign and build the tree
$dalCampaigns = OA_Dal::factoryDAL('campaigns');
$aCampaigns = $dalCampaigns->getClientCampaigns($clientid, $listorder, $orderdirection);
foreach ($aCampaigns as $campaignId => $aCampaign) {
    $aCampaign['impressions'] = phpAds_formatNumber($aCampaign['views']);
    $aCampaign['clicks'] = phpAds_formatNumber($aCampaign['clicks']);
    $aCampaign['conversions'] = phpAds_formatNumber($aCampaign['conversions']);

    if (!empty($aCampaign['activate_time'])) {
        $aCampaign['activate'] = RV_Admin_DateTimeFormat::formatUTCDate($aCampaign['activate_time']);
    } else {
        $aCampaign['activate'] = '-';
    }

    if (!empty($aCampaign['expire_time'])) {
        $aCampaign['expire'] = RV_Admin_DateTimeFormat::formatUTCDate($aCampaign['expire_time']);
    } else {
        $aCampaign['expire'] = '-';
    }

    if ($aCampaign['type'] == DataObjects_Campaigns::CAMPAIGN_TYPE_MARKET_CONTRACT) {
        $aCampaign['system'] = true;
        $aCampaign['type'] = OX_Util_Utils::getCampaignType($aCampaign['priority']);
    } else {
        $aCampaign['type'] = OX_Util_Utils::getCampaignType($aCampaign['priority']);
    }

    if ($aCampaign['priority'] == -1) {
        $aCampaign['priority'] = $strOverride;
    } elseif ($aCampaign['priority'] == -2) {
        $aCampaign['priority'] = $strCampaignECPM;
    } elseif ($aCampaign['priority'] == 0) {
        $aCampaign['priority'] = $strLow;
    } else {
        $aCampaign['priority'] = $strHigh . ' (' . $aCampaign['priority'] . ')';
    }

    $aCampaigns[$campaignId] = $aCampaign;
}

$aCount = [
    'campaigns' => 0,
    'campaigns_hidden' => 0,
];

$dalBanners = OA_Dal::factoryDAL('banners');
if (isset($aCampaigns) && is_array($aCampaigns) && count($aCampaigns) > 0) {
    reset($aCampaigns);
    foreach ($aCampaigns as $campaignId => $campaign) {
        $aCount['campaigns']++;
        if ($hideinactive) {
            // Inactive Campaigns should be hidden
            if ($campaign['status'] != OA_ENTITY_STATUS_RUNNING && $campaign['status'] != OA_ENTITY_STATUS_AWAITING) {
                // The Campaign is not in the Running or Awaiting state - hide it
                $aCount['campaigns_hidden']++;
                unset($aCampaigns[$campaignId]);
            }
            if (isset($aCampaigns[$campaignId])) {
                // The Campaign is in the Running or Awaiting state - check if it should be hidden due to banners
                $aBanners = [];
                $aBanners = $dalBanners->getAllBannersUnderCampaign($campaignId, $listorder, $orderdirection);
                if (empty($aBanners)) {
                    // The Campaign has no banners - hide it
                    $aCount['campaigns_hidden']++;
                    unset($aCampaigns[$campaignId]);
                } else {
                    // Does the Campaign have any Banners in the Running or Awaiting state?
                    $activeBanners = false;
                    foreach ($aBanners as $bannerId => $banner) {
                        if (OA_ENTITY_STATUS_RUNNING == $banner['status'] || OA_ENTITY_STATUS_AWAITING == $banner['status']) {
                            // This Banner is in the Running or Awaiting state - don't hide the campaign
                            $activeBanners = true;
                            // No need to test any more banners - one Running or Awaiting banner is enough
                            break;
                        }
                    }
                    if (!$activeBanners) {
                        // No Banners in the Running or Awaiting state were found - hide the campaign
                        $aCount['campaigns_hidden']++;
                        unset($aCampaigns[$campaignId]);
                    }
                }
            }
        }
    }
}

$isAdvertiser = OA_Permission::isAccount(OA_ACCOUNT_ADVERTISER);

$oTpl->assign('clientId', $clientid);
$oTpl->assign('aCampaigns', $aCampaigns);
$oTpl->assign('aCount', $aCount);
$oTpl->assign('hideinactive', $hideinactive);
$oTpl->assign('listorder', $listorder);
$oTpl->assign('orderdirection', $orderdirection);
$oTpl->assign('showconversions', $conf['logging']['trackerImpressions']);
$oTpl->assign('canAddCampaign', !$isAdvertiser);
$oTpl->assign('canAddBanner', !$isAdvertiser || OA_Permission::hasPermission(OA_PERM_BANNER_ADD));
$oTpl->assign('canEdit', !$isAdvertiser || OA_Permission::hasPermission(OA_PERM_BANNER_EDIT));
$oTpl->assign('canDelete', !$isAdvertiser && OA_Permission::hasPermission(OA_PERM_MANAGER_DELETE));


/*-------------------------------------------------------*/
/* Store preferences                                     */
/*-------------------------------------------------------*/

$session['prefs']['advertiser-campaigns.php'][$clientid]['hideinactive'] = $hideinactive;
$session['prefs']['advertiser-campaigns.php'][$clientid]['listorder'] = $listorder;
$session['prefs']['advertiser-campaigns.php'][$clientid]['orderdirection'] = $orderdirection;
$session['prefs']['inventory_entities'][OA_Permission::getEntityId()]['clientid'] = $clientid;
phpAds_SessionDataStore();


/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/
/** add view hooks **/
OX_Admin_UI_ViewHooks::registerPageView(
    $oTpl,
    'advertiser-campaigns',
    ['advertiserId' => $clientid]
);

$oTpl->display();
phpAds_PageFooter();



function buildHeaderModel($advertiserId, $aAllAdvertisers)
{
    if ($advertiserId) {
        $advertiser = phpAds_getClientDetails($advertiserId);

        $advertiserName = $advertiser ['clientname'];
        if ($advertiser['type'] != DataObjects_Clients::ADVERTISER_TYPE_MARKET) {
            $advertiserEditUrl = "advertiser-edit.php?clientid=$advertiserId";
        }
    }
    $builder = new OA_Admin_UI_Model_InventoryPageHeaderModelBuilder();
    $oHeaderModel = $builder->buildEntityHeader([
        ['name' => $advertiserName, 'url' => $advertiserEditUrl,
               'id' => $advertiserId, 'entities' => $aAllAdvertisers,
               'htmlName' => 'clientid'
              ],
        ['name' => '']
    ], 'campaigns', 'list');

    return $oHeaderModel;
}


function getAdvertiserMap()
{
    $aAdvertisers = [];
    $dalClients = OA_Dal::factoryDAL('clients');
    if (OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
        $agency_id = OA_Permission::getEntityId();
        $aAdvertisers = $dalClients->getAllAdvertisersForAgency($agency_id);
    } elseif (OA_Permission::isAccount(OA_ACCOUNT_ADVERTISER)) {
        $advertiserId = OA_Permission::getEntityId();
        $aAdvertiser = $dalClients->getAdvertiserDetails($advertiserId);
        $aAdvertisers[$advertiserId] = $aAdvertiser;
    }

    $aAdvertiserMap = [];
    foreach ($aAdvertisers as $clientid => $aClient) {
        $aAdvertiserMap[$clientid] = ['name' => $aClient['clientname'],
            'url' => "advertiser-campaigns.php?clientid=" . $clientid];
    }

    return $aAdvertiserMap;
}
