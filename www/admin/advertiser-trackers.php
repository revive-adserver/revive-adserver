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
require_once MAX_PATH . '/lib/max/other/html.php';

// Register input variables
phpAds_registerGlobal('listorder', 'orderdirection');


/*-------------------------------------------------------*/
/* Advertiser interface security                          */
/*-------------------------------------------------------*/

OA_Permission::enforceAccount(OA_ACCOUNT_MANAGER);
OA_Permission::enforceAccessToObject('clients', $clientid);


/*-------------------------------------------------------*/
/* Store preferences									 */
/*-------------------------------------------------------*/
$session['prefs']['inventory_entities'][OA_Permission::getEntityId()]['clientid'] = $clientid;
phpAds_SessionDataStore();

/*-------------------------------------------------------*/
/* Get preferences                                       */
/*-------------------------------------------------------*/

if (!isset($listorder)) {
    if (isset($session['prefs']['advertiser-trackers.php']['listorder'])) {
        $listorder = $session['prefs']['advertiser-trackers.php']['listorder'];
    } else {
        $listorder = '';
    }
}

if (!isset($orderdirection)) {
    if (isset($session['prefs']['advertiser-trackers.php']['orderdirection'])) {
        $orderdirection = $session['prefs']['advertiser-trackers.php']['orderdirection'];
    } else {
        $orderdirection = '';
    }
}



/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

if (OA_Permission::isAccount(OA_ACCOUNT_ADMIN) || OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
    addAdvertiserPageToolsAndShortcuts($clientid);
    $oHeaderModel = buildAdvertiserHeaderModel($clientid);
    phpAds_PageHeader(null, $oHeaderModel);
}

/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

require_once MAX_PATH . '/lib/OA/Admin/Template.php';

$oTpl = new OA_Admin_Template('advertiser-trackers.html');

$doTrackers = OA_Dal::factoryDO('trackers');
$doTrackers->clientid = $clientid;
$doTrackers->addListOrderBy($listorder, $orderdirection);
$doTrackers->find();

$aTrackers = [];
while ($doTrackers->fetch() && $row_trackers = $doTrackers->toArray()) {
    $aTrackers[$row_trackers['trackerid']] = $row_trackers;
}

$oTpl->assign('clientId', $clientid);
$oTpl->assign('aTrackers', $aTrackers);
$oTpl->assign('listorder', $listorder);
$oTpl->assign('orderdirection', $orderdirection);
$oTpl->assign('url', 'advertiser-trackers.php?clientid=' . $clientid);

$oTpl->assign('canAdd', true);
$oTpl->assign('canEdit', true);
$oTpl->assign('canLink', true);
$oTpl->assign('canDelete', OA_Permission::hasPermission(OA_PERM_MANAGER_DELETE));


/*-------------------------------------------------------*/
/* Store preferences                                     */
/*-------------------------------------------------------*/

$session['prefs']['advertiser-trackers.php']['listorder'] = $listorder;
$session['prefs']['advertiser-trackers.php']['orderdirection'] = $orderdirection;

phpAds_SessionDataStore();



/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

$oTpl->display();

phpAds_PageFooter();
