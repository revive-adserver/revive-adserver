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


OA_Permission::enforceAccount(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER);
OA_Permission::enforceAccountPermission(OA_ACCOUNT_MANAGER, OA_PERM_SUPER_ACCOUNT);
OA_Permission::enforceAccessToObject('agency', $agencyid);

$userAccess = new OA_Admin_UI_UserAccess();
$userAccess->init();

function OA_HeaderNavigation()
{
    global $agencyid;

    if (OA_Permission::isAccount(OA_ACCOUNT_ADMIN)) {
        phpAds_PageHeader("agency-access");
        $doAgency = OA_Dal::staticGetDO('agency', $agencyid);
        MAX_displayInventoryBreadcrumbs([["name" => $doAgency->name]], "agency");
    } else {
        phpAds_PageHeader("agency-user");
    }
}
$userAccess->setNavigationHeaderCallback('OA_HeaderNavigation');

$accountId = OA_Permission::getAccountIdForEntity('agency', $agencyid);
$userAccess->setAccountId($accountId);

$userAccess->setPagePrefix('agency');

$aAllowedPermissions = [];

if (OA_Permission::hasPermission(OA_PERM_SUPER_ACCOUNT, $accountId)) {
    $aAllowedPermissions[OA_PERM_SUPER_ACCOUNT] = [$strAllowCreateAccounts, false];
}

if (OA_Permission::isUserLinkedToAdmin()) {
    $aAllowedPermissions[OA_PERM_MANAGER_DELETE] = [$strAllowDeleteItems, false];
}

$userAccess->setAllowedPermissions($aAllowedPermissions);

$userAccess->setHiddenFields(['agencyid' => $agencyid]);
$userAccess->setRedirectUrl('agency-access.php?agencyid=' . $agencyid);
$userAccess->setBackUrl('agency-user-start.php?agencyid=' . $agencyid);

$userAccess->process();
