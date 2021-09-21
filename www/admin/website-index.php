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
require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/www/admin/config.php';

require_once RV_PATH . '/lib/RV/Admin/DateTimeFormat.php';

// Register input variables
phpAds_registerGlobalUnslashed(
    'hideinactive',
    'listorder',
    'orderdirection',
    'pubid',
    'url',
    'formId'
);

// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_MANAGER);


/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PageHeader(null, buildHeaderModel());


/*-------------------------------------------------------*/
/* Get preferences                                       */
/*-------------------------------------------------------*/

if (!isset($listorder)) {
    if (isset($session['prefs']['website-index.php']['listorder'])) {
        $listorder = $session['prefs']['website-index.php']['listorder'];
    } else {
        $listorder = '';
    }
}

if (!isset($orderdirection)) {
    if (isset($session['prefs']['website-index.php']['orderdirection'])) {
        $orderdirection = $session['prefs']['website-index.php']['orderdirection'];
    } else {
        $orderdirection = '';
    }
}


/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

require_once MAX_PATH . '/lib/OA/Admin/Template.php';

$oTpl = new OA_Admin_Template('website-index.html');

$dalAffiliates = OA_Dal::factoryDAL('affiliates');
$aWebsitesZones = $dalAffiliates->getWebsitesAndZonesByAgencyId();

$itemsPerPage = 250;
$oPager = OX_buildPager($aWebsitesZones, $itemsPerPage);
$oTopPager = OX_buildPager($aWebsitesZones, $itemsPerPage, false);
list($itemsFrom, $itemsTo) = $oPager->getOffsetByPageId();
$aWebsitesZones = array_slice($aWebsitesZones, $itemsFrom - 1, $itemsPerPage, true);

$oTpl->assign('pager', $oPager);
$oTpl->assign('topPager', $oTopPager);

$oTpl->assign('affiliates', $aWebsitesZones);
$oTpl->assign('listorder', $listorder);
$oTpl->assign('orderdirection', $orderdirection);
$oTpl->assign('phpAds_ZoneBanner', phpAds_ZoneBanner);
$oTpl->assign('phpAds_ZoneInterstitial', phpAds_ZoneInterstitial);
$oTpl->assign('phpAds_ZonePopup', phpAds_ZonePopup);
$oTpl->assign('phpAds_ZoneText' . phpAds_ZoneText);
$oTpl->assign('showAdDirect', (defined('OA_AD_DIRECT_ENABLED') && OA_AD_DIRECT_ENABLED === true) ? true : false);

$oTpl->assign('canDelete', OA_Permission::hasPermission(OA_PERM_MANAGER_DELETE));

/*-------------------------------------------------------*/
/* Store preferences                                     */
/*-------------------------------------------------------*/

$session['prefs']['website-index.php']['listorder'] = $listorder;
$session['prefs']['website-index.php']['orderdirection'] = $orderdirection;
phpAds_SessionDataStore();


/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

$oTpl->display();

phpAds_PageFooter();


function buildHeaderModel()
{
    $builder = new OA_Admin_UI_Model_InventoryPageHeaderModelBuilder();
    return $builder->buildEntityHeader([], 'websites', 'list');
}
