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


// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_MANAGER, OA_ACCOUNT_TRAFFICKER);
OA_Permission::enforceAccountPermission(OA_ACCOUNT_TRAFFICKER, OA_PERM_SUPER_ACCOUNT);
OA_Permission::enforceAccessToObject('affiliates', $affiliateid);

/*-------------------------------------------------------*/
/* Store preferences									 */
/*-------------------------------------------------------*/
$session['prefs']['inventory_entities'][OA_Permission::getEntityId()]['affiliateid'] = $affiliateid;
phpAds_SessionDataStore();


$userAccess = new OA_Admin_UI_UserAccess();
$userAccess->init();

function OA_headerNavigation()
{
    global $affiliateid;
    phpAds_PageHeader("affiliate-access");
    MAX_displayWebsiteBreadcrumbs($affiliateid);
}
$userAccess->setNavigationHeaderCallback('OA_headerNavigation');

function OA_footerNavigation()
{
    echo "
    <script language='JavaScript'>
    <!--
    ";
    if (OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
        echo "function MMM_cascadePermissionsChange()
        {
            var e = findObj('permissions_" . OA_PERM_ZONE_EDIT . "');
            var a = findObj('permissions_" . OA_PERM_ZONE_ADD . "');
            var d = findObj('permissions_" . OA_PERM_ZONE_DELETE . "');

            a.disabled = d.disabled = !e.checked;
            if (!e.checked) {
                a.checked = d.checked = false;
            }
        }
        MMM_cascadePermissionsChange();
        //-->";
    }
    echo "</script>";
}
$userAccess->setNavigationFooterCallback('OA_footerNavigation');

$accountId = OA_Permission::getAccountIdForEntity('affiliates', $affiliateid);
$userAccess->setAccountId($accountId);

$userAccess->setPagePrefix('affiliate');


$aAllowedPermissions = [];
if (OA_Permission::isAccount(OA_ACCOUNT_MANAGER) ||
        OA_Permission::hasPermission(OA_PERM_SUPER_ACCOUNT, $accountId)) {
    $aAllowedPermissions[OA_PERM_SUPER_ACCOUNT] = [$strAllowCreateAccounts, false];
}
$aAllowedPermissions[OA_PERM_ZONE_EDIT] = [$strAllowAffiliateModifyZones,  false,
                                                      'MMM_cascadePermissionsChange()'];
$aAllowedPermissions[OA_PERM_ZONE_ADD] = [$strAllowAffiliateAddZone,      true, false];

if (OA_Permission::hasPermission(OA_PERM_MANAGER_DELETE) ||
    OA_Permission::hasPermission(OA_PERM_ZONE_DELETE)) {
    $aAllowedPermissions[OA_PERM_ZONE_DELETE] = [$strAllowAffiliateDeleteZone,   true, false];
}

$aAllowedPermissions[OA_PERM_ZONE_LINK] = [$strAllowAffiliateLinkBanners,  false, false];
$aAllowedPermissions[OA_PERM_ZONE_INVOCATION] = [$strAllowAffiliateGenerateCode, false, false];
$aAllowedPermissions[OA_PERM_USER_LOG_ACCESS] = [$strAllowAuditTrailAccess, false, false];
$userAccess->setAllowedPermissions($aAllowedPermissions);


$userAccess->setHiddenFields(['affiliateid' => $affiliateid]);
$userAccess->setRedirectUrl('affiliate-access.php?affiliateid=' . $affiliateid);
$userAccess->setBackUrl('affiliate-user-start.php?affiliateid=' . $affiliateid);

$userAccess->process();
