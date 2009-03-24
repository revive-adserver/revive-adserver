<?php

/*
+---------------------------------------------------------------------------+
| OpenX  v${RELEASE_MAJOR_MINOR}                                                              |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
| For contact details, see: http://www.openx.org/                           |
|                                                                           |
| This program is free software; you can redistribute it and/or modify      |
| it under the terms of the GNU General Public License as published by      |
| the Free Software Foundation; either version 2 of the License, or         |
| (at your option) any later version.                                       |
|                                                                           |
| This program is distributed in the hope that it will be useful,           |
| but WITHOUT ANY WARRANTY; without even the implied warranty of            |
| MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
| GNU General Public License for more details.                              |
|                                                                           |
| You should have received a copy of the GNU General Public License         |
| along with this program; if not, write to the Free Software               |
| Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA |
+---------------------------------------------------------------------------+
$Id$
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
        MAX_displayInventoryBreadcrumbs(array(array("name" => $doAgency->name)), "agency");
    } else {
        phpAds_PageHeader("agency-user");
    }
}
$userAccess->setNavigationHeaderCallback('OA_HeaderNavigation');

$accountId = OA_Permission::getAccountIdForEntity('agency', $agencyid);
$userAccess->setAccountId($accountId);

$userAccess->setPagePrefix('agency');

$aAllowedPermissions = array();
if (OA_Permission::hasPermission(OA_PERM_SUPER_ACCOUNT, $accountId)) {
    $aAllowedPermissions[OA_PERM_SUPER_ACCOUNT] = array($strAllowCreateAccounts, false);
}
$userAccess->setAllowedPermissions($aAllowedPermissions);

$userAccess->setHiddenFields(array('agencyid' => $agencyid));
$userAccess->setRedirectUrl('agency-access.php?agencyid='.$agencyid);
$userAccess->setBackUrl('agency-user-start.php?agencyid='.$agencyid);

$userAccess->process();

?>
