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
require_once MAX_PATH . '/lib/OA/Admin/UI/UserAccess.php';
require_once MAX_PATH . '/lib/max/other/html.php';

// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_MANAGER, OA_ACCOUNT_ADVERTISER);
OA_Permission::enforceAccountPermission(OA_ACCOUNT_ADVERTISER, OA_PERM_SUPER_ACCOUNT);
OA_Permission::enforceAccessToObject('clients', $clientid);


/*-------------------------------------------------------*/
/* Store preferences									 */
/*-------------------------------------------------------*/
$session['prefs']['inventory_entities'][OA_Permission::getEntityId()]['clientid'] = $clientid;
phpAds_SessionDataStore();

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

$oHeaderModel = buildAdvertiserHeaderModel($clientid);
if (OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
    phpAds_PageHeader('advertiser-access', $oHeaderModel);
    phpAds_ShowSections(array("4.1.2", "4.1.3", "4.1.5", "4.1.5.1"));
}
else {
	$sections = array();
	if (OA_Permission::hasPermission(OA_PERM_BANNER_ACTIVATE) || OA_Permission::hasPermission(OA_PERM_BANNER_EDIT)) {
    	$sections[] = '2.2';
	}
    $sections[] = '2.3';
    $sections[] = '2.3.1';
    phpAds_PageHeader('advertiser-access', $oHeaderModel);
	phpAds_ShowSections($sections);
}

/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

require_once MAX_PATH . '/lib/OA/Admin/Template.php';

$oTpl = new OA_Admin_Template('advertiser-user-start.html');
OA_Admin_UI_UserAccess::assignUserStartTemplateVariables($oTpl);
$oTpl->assign('action', 'advertiser-user.php');
$oTpl->assign('entityIdName', 'clientid');
$oTpl->assign('entityIdValue', $clientid);
$oTpl->display();

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PageFooter();

?>
