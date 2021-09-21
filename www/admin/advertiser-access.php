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
require_once RV_PATH . '/lib/OA/Dal.php';
require_once RV_PATH . '/lib/RV/Admin/Languages.php';
require_once RV_PATH . '/lib/RV/Admin/DateTimeFormat.php';
require_once RV_PATH . '/www/admin/config.php';
require_once RV_PATH . '/www/admin/lib-statistics.inc.php';
require_once RV_PATH . '/lib/OA/Session.php';
require_once RV_PATH . '/lib/OA/Admin/Menu.php';
require_once RV_PATH . '/lib/max/other/html.php';
require_once RV_PATH . '/lib/OA/Auth.php';
require_once RV_PATH . '/lib/OA/Admin/UI/UserAccess.php';

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
addPageTools($clientid);
addAdvertiserPageToolsAndShortcuts($clientid);
if (!empty($clientid)) {
    $oHeaderModel = buildAdvertiserHeaderModel($clientid);

    if (OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
        OA_Admin_Menu::setAdvertiserPageContext($clientid, 'advertiser-access.php');
        phpAds_PageHeader("4.1.5", $oHeaderModel);
    } else {
        phpAds_PageHeader('2.3', $oHeaderModel);
    }
}
$tabindex = 1;


/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

require_once MAX_PATH . '/lib/OA/Admin/Template.php';

$oTpl = new OA_Admin_Template('advertiser-access.html');

// Ensure that any template variables for the authentication plugin are set
$oPlugin = OA_Auth::staticGetAuthPlugin();
$oPlugin->setTemplateVariables($oTpl);

$oTpl->assign('infomessage', OA_Session::getMessage());

$oTpl->assign('entityIdName', 'clientid');
$oTpl->assign('entityIdValue', $clientid);
$oTpl->assign('editPage', 'advertiser-user.php');
$oTpl->assign('unlinkPage', 'advertiser-user-unlink.php');

$doUsers = OA_Dal::factoryDO('users');
$aUsers = $doUsers->getAccountUsersByEntity('clients', $clientid);
foreach ($aUsers as $key => $aValue) {
    // Date of last login is stored in UTC, so needs to be converted into the current user's
    // local timezone, and then converted into the user's desired date/time format
    $aUsers[$key]['date_last_login'] = RV_Admin_DateTimeFormat::formatUTCDateTime($aValue['date_last_login']);
    // Date created/linked is stored in UTC, so needs to be converted into the current user's
    // local timezone, and then converted into the user's desired date/time format
    $aUsers[$key]['date_created'] = RV_Admin_DateTimeFormat::formatUTCDateTime($aValue['date_created']);
}
$oTpl->assign('users', ['aUsers' => $aUsers]);
$oTpl->display();

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PageFooter();

function addPageTools($clientid)
{
    addPageLinkTool($GLOBALS["strLinkUser_Key"], "advertiser-user-start.php?clientid=$clientid", "iconAdvertiserAdd", $GLOBALS["keyLinkUser"]);
}
