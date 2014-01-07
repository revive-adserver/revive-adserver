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
require_once MAX_PATH . '/www/admin/lib-maintenance-priority.inc.php';
require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/lib/OA/Dll.php';
require_once MAX_PATH . '/lib/OX/Util/Utils.php';
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/www/admin/lib-statistics.inc.php';
require_once MAX_PATH . '/lib/OX/Admin/UI/ViewHooks.php';

function _isBannerAssignedToCampaign($aBannerData)
{
    return $aBannerData['campaignid'] > 0;
}

// Register input variables
phpAds_registerGlobal('hideinactive', 'listorder', 'orderdirection');

// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_MANAGER);


/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PageHeader(null, buildHeaderModel());


/*-------------------------------------------------------*/
/* Get preferences                                       */
/*-------------------------------------------------------*/

if (!isset($hideinactive)) {
    if (isset($session['prefs']['advertiser-index.php']['hideinactive'])) {
        $hideinactive = $session['prefs']['advertiser-index.php']['hideinactive'];
    } else {
        $pref = &$GLOBALS['_MAX']['PREF'];
        $hideinactive = ($pref['ui_hide_inactive'] == true);
    }
}

if (!isset($listorder)) {
    if (isset($session['prefs']['advertiser-index.php']['listorder'])) {
        $listorder = $session['prefs']['advertiser-index.php']['listorder'];
    } else {
        $listorder = '';
    }
}

if (!isset($orderdirection)) {
    if (isset($session['prefs']['advertiser-index.php']['orderdirection'])) {
        $orderdirection = $session['prefs']['advertiser-index.php']['orderdirection'];
    } else {
        $orderdirection = '';
    }
}


/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

require_once MAX_PATH . '/lib/OA/Admin/Template.php';

$oTpl = new OA_Admin_Template('advertiser-index.html');

// Get clients & campaigns and build the tree
// XXX: Now that the two are next to each other, some silliness
//      is quite visible -- retrieving all items /then/ retrieving a count.
// TODO: This looks like a perfect candidate for object "polymorphism"
$dalClients = OA_Dal::factoryDAL('clients');
$dalCampaigns = OA_Dal::factoryDAL('campaigns');
$dalBanners = OA_Dal::factoryDAL('banners');

$campaigns = array();
$banners = array();

if (OA_Permission::isAccount(OA_ACCOUNT_ADMIN)) {
    $clients = $dalClients->getAllAdvertisers($listorder, $orderdirection);
    if ($hideinactive) {
        $campaigns = $dalCampaigns->getAllCampaigns($listorder, $orderdirection);
        $banners = $dalBanners->getAllBanners($listorder, $orderdirection);
    }
}
elseif (OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
    $agency_id = OA_Permission::getEntityId();
    $clients = $dalClients->getAllAdvertisersForAgency($agency_id, $listorder, $orderdirection);
    if ($hideinactive) {
        $campaigns = $dalCampaigns->getAllCampaignsUnderAgency($agency_id, $listorder, $orderdirection);
        $banners = $dalBanners->getAllBannersUnderAgency($agency_id, $listorder, $orderdirection);
        foreach ($banners as &$banner) {
            $banner['status'] = $banner['active'];
        }
        unset($banner);
    }
}

$aCount = array(
    'advertisers'        => count($clients),
    'advertisers_hidden' => 0
);


if ($hideinactive && !empty($clients) && !empty($campaigns) &&
    !empty($banners)) {

    // Build Tree
    foreach ($banners as $bkey => $banner) {
        if (_isBannerAssignedToCampaign($banner) &&
            (OA_ENTITY_STATUS_RUNNING == $banner['status'])) {

            $campaigns[$banner['campaignid']]['has_active_banners'] = true;
        }
    }

    foreach ($campaigns as $ckey => $campaign) {
        if ((OA_ENTITY_STATUS_RUNNING == $campaign['status']) &&
            array_key_exists('has_active_banners', $campaign)) {

            $clients[$campaign['clientid']]['has_active_campaigns'] =
                true;
        }
    }

    foreach (array_keys($clients) as $clientid) {
        $client = &$clients[$clientid];

        if (!array_key_exists('has_active_campaigns', $client)
            // we do not hide the Market advertiser
            && $client['type'] != DataObjects_Clients::ADVERTISER_TYPE_MARKET) {
            unset($clients[$clientid]);
            $aCount['advertisers_hidden']++;
        }
    }
}

$itemsPerPage = 250;
$oPager = OX_buildPager($clients, $itemsPerPage);
$oTopPager = OX_buildPager($clients, $itemsPerPage, false);
list($itemsFrom, $itemsTo) = $oPager->getOffsetByPageId();
$clients =  array_slice($clients, $itemsFrom - 1, $itemsPerPage, true);

$oTpl->assign('pager', $oPager);
$oTpl->assign('topPager', $oTopPager);

$oTpl->assign('aAdvertisers', $clients);
$oTpl->assign('aCount', $aCount);
$oTpl->assign('hideinactive', $hideinactive);
$oTpl->assign('listorder', $listorder);
$oTpl->assign('orderdirection', $orderdirection);
$oTpl->assign('MARKET_TYPE', DataObjects_Clients::ADVERTISER_TYPE_MARKET);



/*-------------------------------------------------------*/
/* Store preferences                                     */
/*-------------------------------------------------------*/

$session['prefs']['advertiser-index.php']['hideinactive'] = $hideinactive;
$session['prefs']['advertiser-index.php']['listorder'] = $listorder;
$session['prefs']['advertiser-index.php']['orderdirection'] = $orderdirection;
phpAds_SessionDataStore();


/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/
OX_Admin_UI_ViewHooks::registerPageView($oTpl, 'advertiser-index');

$oTpl->display();
phpAds_PageFooter();


function buildHeaderModel()
{
    $builder = new OA_Admin_UI_Model_InventoryPageHeaderModelBuilder();
    return $builder->buildEntityHeader(array(), 'advertisers', 'list');
}

?>
