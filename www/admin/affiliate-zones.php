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
require_once MAX_PATH . '/www/admin/lib-statistics.inc.php';
require_once MAX_PATH . '/www/admin/lib-size.inc.php';
require_once MAX_PATH . '/www/admin/lib-zones.inc.php';
require_once MAX_PATH . '/lib/max/Delivery/cache.php';
require_once MAX_PATH . '/lib/max/other/html.php';

// Register input variables
phpAds_registerGlobal ('listorder', 'orderdirection');

/*-------------------------------------------------------*/
/* Affiliate interface security                          */
/*-------------------------------------------------------*/
OA_Permission::enforceAccount(OA_ACCOUNT_MANAGER, OA_ACCOUNT_TRAFFICKER);
if (!empty($affiliateid) && !OA_Permission::hasAccessToObject('affiliates', $affiliateid)) { //check if can see given website
    $page = basename($_SERVER['SCRIPT_NAME']);
    OX_Admin_Redirect::redirect($page);
}

/*-------------------------------------------------------*/
/* Init data                                             */
/*-------------------------------------------------------*/

//get websites and set the current one
$aWebsites = getWebsiteMap();
if (empty($affiliateid)) { //if it's empty
    if ($session['prefs']['inventory_entities'][OA_Permission::getEntityId()]['affiliateid']) {
        //try previous one from session
        $sessionWebsiteId = $session['prefs']['inventory_entities'][OA_Permission::getEntityId()]['affiliateid'];
        if (isset($aWebsites[$sessionWebsiteId])) { //check if 'id' from session was not removed
            $affiliateid = $sessionWebsiteId;
        }
    }
    if (empty($affiliateid)) { //was empty, is still empty - just pick one, no need for redirect
        $ids = array_keys($aWebsites);
        $affiliateid = !empty($ids) ? $ids[0] : -1; //if no websites set to non-existent id
    }
}
else {
    if (!isset($aWebsites[$affiliateid])) { //bad id, redirect
        $page = basename($_SERVER['SCRIPT_NAME']);
        OX_Admin_Redirect::redirect($page);
    }
}


/*-------------------------------------------------------*/
/* Get preferences                                       */
/*-------------------------------------------------------*/

if (!isset($listorder)) {
    if (isset($session['prefs']['affiliate-zones.php']['listorder'])) {
        $listorder = $session['prefs']['affiliate-zones.php']['listorder'];
    } else {
        $listorder = '';
    }
}

if (!isset($orderdirection)) {
    if (isset($session['prefs']['affiliate-zones.php']['orderdirection'])) {
        $orderdirection = $session['prefs']['affiliate-zones.php']['orderdirection'];
    } else {
        $orderdirection = '';
    }
}

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

$oHeaderModel = buildHeaderModel($affiliateid);
if (OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
    phpAds_PageHeader(null, $oHeaderModel);
}
else {
    $sections = array("2.1");
    phpAds_PageHeader(null, $oHeaderModel);
}


/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

require_once MAX_PATH . '/lib/OA/Admin/Template.php';

$oTpl = new OA_Admin_Template('zone-index.html');


// Get websites and build the tree
$doZones = OA_Dal::factoryDO('zones');
$doZones->affiliateid = $affiliateid;
$doZones->addListorderBy($listorder, $orderdirection);
$doZones->find();

$aZones = array();
while ($doZones->fetch() && $row_zones = $doZones->toArray()) {
	$aZones[$row_zones['zoneid']] = $row_zones;
	$aZones[$row_zones['zoneid']]['lowPriorityWarning'] = false;

    MAX_Dal_Delivery_Include();
    $aZoneAds = OA_Dal_Delivery_getZoneLinkedAds($row_zones['zoneid']);

    if ($aZoneAds['count_active'] > 0 && $row_zones['delivery'] == phpAds_ZoneBanner && count($aZoneAds['lAds']) == 0) {
		$aZones[$row_zones['zoneid']]['lowPriorityWarning'] = true;
	}

	$aZones[$row_zones['zoneid']]['active'] = $aZoneAds['count_active'] > 0;
}

$oTpl->assign('affiliateId', $affiliateid);
$oTpl->assign('aAdvertisers', $clients);
$oTpl->assign('aZones', $aZones);
$oTpl->assign('listorder', $listorder);
$oTpl->assign('orderdirection', $orderdirection);

$oTpl->assign('canAdd', OA_Permission::isAccount(OA_ACCOUNT_ADMIN) || OA_Permission::isAccount(OA_ACCOUNT_MANAGER) || OA_Permission::hasPermission(OA_PERM_ZONE_ADD));
$oTpl->assign('canEdit', OA_Permission::isAccount(OA_ACCOUNT_ADMIN) || OA_Permission::isAccount(OA_ACCOUNT_MANAGER) || OA_Permission::hasPermission(OA_PERM_ZONE_EDIT));
$oTpl->assign('canLink', OA_Permission::isAccount(OA_ACCOUNT_ADMIN) || OA_Permission::isAccount(OA_ACCOUNT_MANAGER) || OA_Permission::hasPermission(OA_PERM_ZONE_LINK));
$oTpl->assign('canInvocation', OA_Permission::isAccount(OA_ACCOUNT_ADMIN) || OA_Permission::isAccount(OA_ACCOUNT_MANAGER) || OA_Permission::hasPermission(OA_PERM_ZONE_INVOCATION));
$oTpl->assign('canDelete', OA_Permission::isAccount(OA_ACCOUNT_ADMIN) || OA_Permission::isAccount(OA_ACCOUNT_MANAGER) || OA_Permission::hasPermission(OA_PERM_ZONE_DELETE));


/*-------------------------------------------------------*/
/* Store preferences                                     */
/*-------------------------------------------------------*/

$session['prefs']['affiliate-zones.php']['listorder'] = $listorder;
$session['prefs']['affiliate-zones.php']['orderdirection'] = $orderdirection;
$session['prefs']['inventory_entities'][OA_Permission::getEntityId()]['affiliateid'] = $affiliateid;
phpAds_SessionDataStore();


/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

$oTpl->display();

phpAds_PageFooter();


function buildHeaderModel($websiteId)
{
    if ($websiteId) {
        $doAffiliates = OA_Dal::factoryDO('affiliates');
        if ($doAffiliates->get($websiteId)) {
            $aWebsite = $doAffiliates->toArray();
        }

        $websiteName = $aWebsite['name'];
        if (OA_Permission::isAccount(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER)) {
            $websiteEditUrl = "affiliate-edit.php?affiliateid=$websiteId";
        }
    }
    $builder = new OA_Admin_UI_Model_InventoryPageHeaderModelBuilder();
    $oHeaderModel = $builder->buildEntityHeader(array(
        array ('name' => $websiteName, 'url' => $websiteEditUrl,
               'id' => $websiteId, 'entities' => getWebsiteMap(),
               'htmlName' => 'affiliateid'
              ),
        array('name' => '')
    ), 'zones', 'list');

    return $oHeaderModel;
}


function getWebsiteMap()
{
    $doAffiliates = OA_Dal::factoryDO('affiliates');
    if (OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) { //should this constraint be added always instead of only for managers?
        $doAffiliates->agencyid = OA_Permission::getAgencyId();
    }
    if (OA_Permission::isAccount(OA_ACCOUNT_TRAFFICKER)) {
        $doAffiliates->affiliateid = OA_Permission::getEntityId();
    }
    $doAffiliates->find();

    $aWebsiteMap = array();
    while ($doAffiliates->fetch() && $row = $doAffiliates->toArray()) {
        $aWebsiteMap[$row['affiliateid']] = array('name' => $row['name'],
            'url' => "affiliate-edit.php?affiliateid=".$row['affiliateid']);
    }

    return $aWebsiteMap;
}

?>
