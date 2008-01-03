<?php

/*
+---------------------------------------------------------------------------+
| Openads v${RELEASE_MAJOR_MINOR}                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
| For contact details, see: http://www.openads.org/                         |
|                                                                           |
| Copyright (c) 2000-2003 the phpAdsNew developers                          |
| For contact details, see: http://www.phpadsnew.com/                       |
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
phpAds_registerGlobalUnslashed ('login', 'passwd', 'link', 'contact_name', 'email_address', 'permissions', 'submit');

// Security check
// TODOPERM - should we add here some additional check or every super user should have access to all accounts?
OA_Permission::enforceAccount(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER);
$entityName = 'agency';
$entityId = $agencyid;
OA_Permission::enforceTrue(!empty($entityId));
OA_Permission::enforceAccessToObject($entityName, $entityId);
$accountId = OA_Permission::getAccountIdForEntity($entityName, $entityId);
$doUsers = OA_Dal::factoryDO('users');
$userid = $doUsers->getUserIdByUserName($login);

if (!empty($submit)) {
    $userid = OA_Admin_UI_UserAccess::saveUser($login, $passwd, $contact_name, $email_address);
    OA_Admin_UI_UserAccess::linkUserToAccount($userid, $accountId, $permissions);
    MAX_Admin_Redirect::redirect("agency-access.php?agencyid=".$entityId);
}

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PageHeader("4.1.3.2");
echo "<img src='images/icon-advertiser.gif' align='absmiddle'>&nbsp;<b>".phpAds_getClientName($agencyid)."</b><br /><br /><br />";
phpAds_ShowSections(array("4.1.2", "4.1.3", "4.1.3.2"));

/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

require_once MAX_PATH . '/lib/OA/Admin/Template.php';

$oTpl = new OA_Admin_Template('agency-user.html');
$oTpl->assign('action', 'agency-user.php');
$oTpl->assign('backUrl', 'agency-user-start.php?agencyid='.$entityId);
$oTpl->assign('method', 'POST');

// TODO: will need to know whether we're hosted or downloaded
$HOSTED = false;
$oTpl->assign('hosted', $HOSTED);

// indicates whether the user exists (otherwise, a new user will be created or invitation sent)
$existingUser = !empty($userid);
$oTpl->assign('existingUser', !empty($userid));
$oTpl->assign('editMode', !$link);
$doUsers = OA_Dal::staticGetDO('users', $userid);
$userData = array();
if ($doUsers) {
    $userData = $doUsers->toArray();
} else {
    $userData['username'] = $login;
}

$aPermissions = array();
if (OA_Permission::isAccount(OA_ACCOUNT_ADMIN)
    || OA_Permission::hasPermission(OA_PERM_SUPER_ACCOUNT, $accountId))
{
    $aPermissions[OA_PERM_SUPER_ACCOUNT] = $strAllowCreateAccounts;
}

$aPermissionsFields = array();
foreach ($aPermissions as $permissionId => $permissionName) {
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


$oTpl->assign('fields', array(
    array(
        'title'     => $strUserDetails,
        'fields'    => OA_Admin_UI_UserAccess::getUserDetailsFields($userData)
    ),
    array(
        'title'     => $strPermissions,
        'fields'    => $aPermissionsFields
    )
 )
);


$oTpl->assign('hiddenFields', array(
    array(
        'name' => 'submit',
        'value' => true
    ),
    array(
        'name' => 'agencyid',
        'value' => $agencyid
    ),
    array(
        'name' => 'login',
        'value' => $login
    ),

));

$oTpl->display();

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PageFooter();

?>
