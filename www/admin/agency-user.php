<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                               |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 m3 Media Services Ltd                             |
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
require_once MAX_PATH . '/lib/max/Admin/Redirect.php';
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/www/admin/lib-statistics.inc.php';
require_once MAX_PATH . '/lib/OA/Session.php';
require_once MAX_PATH . '/lib/OA/Admin/UI/UserAccess.php';

// Register input variables
phpAds_registerGlobalUnslashed ('login', 'passwd', 'link', 'contact_name',
    'email_address', 'permissions', 'submit', 'new_user');

// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER);
OA_Permission::enforceAccountPermission(OA_ACCOUNT_MANAGER, OA_PERM_SUPER_ACCOUNT);
OA_Permission::enforceAccessToObject('agency', $agencyid);

$accountId = OA_Permission::getAccountIdForEntity('agency', $agencyid);

$doUsers = OA_Dal::factoryDO('users');
$userid = $doUsers->getUserIdByUserName($login);

$aAllowedPermissions = array();
if (OA_Permission::isAccount(OA_ACCOUNT_ADMIN))
{
    $aAllowedPermissions[OA_PERM_SUPER_ACCOUNT] = $strAllowCreateAccounts;
}

$aErrors = array();
if (!empty($submit)) {
    if ($new_user) {
        $aErrors = OA_Admin_UI_UserAccess::validateUsersData($login, $passwd);
    }
    if (empty($aErrors)) {
        $userid = OA_Admin_UI_UserAccess::saveUser($login, $passwd, $contact_name, $email_address, $accountId);
        OA_Admin_UI_UserAccess::linkUserToAccount($userid, $accountId, $permissions, $aAllowedPermissions);
        MAX_Admin_Redirect::redirect("agency-access.php?agencyid=".$agencyid);
    }
}

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

if (OA_Permission::isAccount(OA_ACCOUNT_ADMIN)) {
    phpAds_PageHeader("4.1.3.2");
    echo "<img src='images/icon-advertiser.gif' align='absmiddle'>&nbsp;<b>".phpAds_getClientName($agencyid)."</b><br /><br /><br />";
    phpAds_ShowSections(array("4.1.2", "4.1.3", "4.1.3.2"));
} else {
    phpAds_PageHeader('4.4.2');
    phpAds_ShowSections(array("4.1", "4.2", "4.3", "4.4", "4.4.2"));
}

/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

require_once MAX_PATH . '/lib/OA/Admin/Template.php';

$oTpl = new OA_Admin_Template('agency-user.html');
$oTpl->assign('action', 'agency-user.php');
$oTpl->assign('backUrl', 'agency-user-start.php?agencyid='.$agencyid);
$oTpl->assign('method', 'POST');
$oTpl->assign('aErrors', $aErrors);


// TODO: will need to know whether we're hosted or downloaded
$HOSTED = false;
$oTpl->assign('hosted', $HOSTED);

// indicates whether the user exists (otherwise, a new user will be created or invitation sent)
$oTpl->assign('existingUser', !empty($userid));
$oTpl->assign('editMode', !$link);
$doUsers = OA_Dal::staticGetDO('users', $userid);
$userData = array();
if ($doUsers) {
    $userData = $doUsers->toArray();
} else {
    $userData['username'] = $login;
}

$aPermissionsFields = array();
foreach ($aAllowedPermissions as $permissionId => $permissionName) {
    $aPermissionsFields[] = array(
                'name'      => 'permissions[]',
                'label'     => $permissionName,
                'type'      => 'checkbox',
                'value'     => $permissionId,
                'checked'   => OA_Permission::hasPermission($permissionId, $accountId, $userid),
                'break'     => false,
                'id'        => 'permissions_'.$permissionId,
            );
}
$aTplFields = array(
    array(
        'title'     => $strUserDetails,
        'fields'    => OA_Admin_UI_UserAccess::getUserDetailsFields($userData)
    )
);
if (!empty($aPermissionsFields)) {
    $aTplFields[] = array(
        'title'     => $strPermissions,
        'fields'    => $aPermissionsFields
    );
}
$oTpl->assign('fields', $aTplFields);

$aHiddenFields = OA_Admin_UI_UserAccess::getHiddenFields($login, $link, 'agencyid', $agencyid);
$oTpl->assign('hiddenFields', $aHiddenFields);

$oTpl->display();

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PageFooter();

?>
