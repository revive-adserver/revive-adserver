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
require_once MAX_PATH . '/lib/OA/Session.php';
require_once MAX_PATH . '/lib/OA/Admin/UI/UserAccess.php';
require_once MAX_PATH . '/lib/max/other/html.php';


// Register input variables
phpAds_registerGlobalUnslashed('login', 'passwd', 'link', 'contact_name', 'email_address', 'permissions', 'submit');

// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_MANAGER, OA_ACCOUNT_ADVERTISER);
OA_Permission::enforceAccountPermission(OA_ACCOUNT_ADVERTISER, OA_PERM_SUPER_ACCOUNT);
OA_Permission::enforceAccessToObject('clients', $clientid);

/*-------------------------------------------------------*/
/* Store preferences									 */
/*-------------------------------------------------------*/
$session['prefs']['inventory_entities'][OA_Permission::getEntityId()]['clientid'] = $clientid;
phpAds_SessionDataStore();


$userAccess = new OA_Admin_UI_UserAccess();
$userAccess->init();

function OA_headerNavigation()
{
    $oHeaderModel = buildAdvertiserHeaderModel($GLOBALS['clientid']);

    if (OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
        phpAds_PageHeader("advertiser-access", $oHeaderModel);
        phpAds_ShowSections(["4.1.2", "4.1.3", "4.1.5", "4.1.5.2"]);
    } else {
        $sections = [];
        if (OA_Permission::hasPermission(OA_PERM_BANNER_ACTIVATE) || OA_Permission::hasPermission(OA_PERM_BANNER_EDIT)) {
            $sections[] = '2.2';
        }
        $sections[] = '2.3';
        $sections[] = '2.3.2';
        phpAds_PageHeader('advertiser-access', $oHeaderModel);
        phpAds_ShowSections($sections);
    }
}
$userAccess->setNavigationHeaderCallback('OA_headerNavigation');

$accountId = OA_Permission::getAccountIdForEntity('clients', $clientid);
$userAccess->setAccountId($accountId);

$userAccess->setPagePrefix('advertiser');

$aAllowedPermissions = [];
if (OA_Permission::isAccount(OA_ACCOUNT_MANAGER) ||
        OA_Permission::hasPermission(OA_PERM_SUPER_ACCOUNT, $accountId)) {
    $aAllowedPermissions[OA_PERM_SUPER_ACCOUNT] = [$strAllowCreateAccounts, false];
}
$aAllowedPermissions[OA_PERM_BANNER_EDIT] = $strAllowClientModifyBanner;
$aAllowedPermissions[OA_PERM_BANNER_DEACTIVATE] = $strAllowClientDisableBanner;
$aAllowedPermissions[OA_PERM_BANNER_ACTIVATE] = $strAllowClientActivateBanner;
$aAllowedPermissions[OA_PERM_USER_LOG_ACCESS] = $strAllowAuditTrailAccess;
$userAccess->setAllowedPermissions($aAllowedPermissions);


$userAccess->setHiddenFields(['clientid' => $clientid]);
$userAccess->setRedirectUrl('advertiser-access.php?clientid=' . $clientid);
$userAccess->setBackUrl('advertiser-user-start.php?clientid=' . $clientid);

$userAccess->process();
