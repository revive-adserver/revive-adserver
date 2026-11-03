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

require_once RV_PATH . '/lib/RV/Admin/DateTimeFormat.php';

// Register input variables
phpAds_registerGlobal('hideinactive', 'listorder', 'orderdirection');

// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_MANAGER);


/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PageHeader(null, buildAdvertiserIndexHeaderModel());


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

$aActiveAdvertiserIds = [];

if (OA_Permission::isAccount(OA_ACCOUNT_ADMIN)) {
    $clients = $dalClients->getAllAdvertisers($listorder, $orderdirection);
    if ($hideinactive) {
        $aActiveAdvertiserIds = $dalClients->getActiveAdvertiserIds();
    }
} elseif (OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
    $agency_id = OA_Permission::getEntityId();
    $clients = $dalClients->getAllAdvertisersForAgency($agency_id, $listorder, $orderdirection);
    if ($hideinactive) {
        $aActiveAdvertiserIds = $dalClients->getActiveAdvertiserIds($agency_id);
    }
}

if (!empty($clients)) {
    foreach ($clients as $ckey => $client) {
        if (!empty($client['updated'])) {
            $client['updated'] = RV_Admin_DateTimeFormat::formatUTCDateTime($client['updated']);
        }
    }
}

$aCount = [
    'advertisers' => count($clients),
    'advertisers_hidden' => 0,
];


if ($hideinactive && !empty($clients)) {
    // Inactive Advertisers, i.e. without a Running or Awaiting Campaign that has
    // at least one Running or Awaiting Banner, should be hidden
    $aActiveAdvertiserIds = array_flip($aActiveAdvertiserIds);
    foreach (array_keys($clients) as $clientid) {
        if (!isset($aActiveAdvertiserIds[$clientid])) {
            unset($clients[$clientid]);
            $aCount['advertisers_hidden']++;
        }
    }
}

$itemsPerPage = 100;
$oPager = OX_buildPager($clients, $itemsPerPage);
$oTopPager = OX_buildPager($clients, $itemsPerPage, false);
[$itemsFrom, $itemsTo] = $oPager->getOffsetByPageId();
$clients = array_slice($clients, $itemsFrom - 1, $itemsPerPage, true);

$oTpl->assign('pager', $oPager);
$oTpl->assign('topPager', $oTopPager);

$oTpl->assign('aAdvertisers', $clients);
$oTpl->assign('aCount', $aCount);
$oTpl->assign('hideinactive', $hideinactive);
$oTpl->assign('listorder', $listorder);
$oTpl->assign('orderdirection', $orderdirection);

$oTpl->assign('canDelete', OA_Permission::hasPermission(OA_PERM_MANAGER_DELETE));


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


function buildAdvertiserIndexHeaderModel()
{
    $builder = new OA_Admin_UI_Model_InventoryPageHeaderModelBuilder();
    return $builder->buildEntityHeader([], 'advertisers', 'list');
}
