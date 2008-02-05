<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 BuraBuraLimited                                   |
| For contact details, see: http://www.openx.org/                           |
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
OA_Permission::enforceAccount(OA_ACCOUNT_MANAGER, OA_ACCOUNT_ADVERTISER);
OA_Permission::enforceAccountPermission(OA_ACCOUNT_ADVERTISER, OA_PERM_SUPER_ACCOUNT);
OA_Permission::enforceAccessToObject('clients', $clientid);

$accountId = OA_Permission::getAccountIdForEntity('clients', $clientid);


$doUsers = OA_Dal::factoryDO('users');
$userid = $doUsers->getUserIdByUserName($login);

$aAllowedPermissions = array();
if (OA_Permission::isAccount(OA_ACCOUNT_MANAGER))
{
    $aAllowedPermissions[OA_PERM_SUPER_ACCOUNT] = $strAllowCreateAccounts;
}
$aAllowedPermissions[OA_PERM_BANNER_EDIT] = $strAllowClientModifyBanner;
$aAllowedPermissions[OA_PERM_BANNER_DEACTIVATE] = $strAllowClientDisableBanner;
$aAllowedPermissions[OA_PERM_BANNER_ACTIVATE] = $strAllowClientActivateBanner;

$aErrors = array();
if (!empty($submit)) {
    if (!OA_Permission::userNameExists($login)) {
        $aErrors = OA_Admin_UI_UserAccess::validateUsersData($login, $passwd);
    }
    if (empty($aErrors)) {
        $userid = OA_Admin_UI_UserAccess::saveUser($login, $passwd, $contact_name, $email_address, $accountId);
        OA_Admin_UI_UserAccess::linkUserToAccount($userid, $accountId, $permissions, $aAllowedPermissions);
        MAX_Admin_Redirect::redirect("advertiser-access.php?clientid=".$clientid);
    }
}

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

$icon = "<img src='images/icon-advertiser.gif' align='absmiddle'>&nbsp;<b>".phpAds_getClientName($clientid)."</b><br /><br /><br />";
if (OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
    phpAds_PageHeader("4.1.5.2");
    echo $icon;
    phpAds_ShowSections(array("4.1.2", "4.1.3", "4.1.5", "4.1.5.2"));
} else {
	$sections = array();
	if (OA_Permission::hasPermission(OA_PERM_BANNER_ACTIVATE) || OA_Permission::hasPermission(OA_PERM_BANNER_EDIT)) {
    	$sections[] = '2.2';
	}
    $sections[] = '2.3';
    $sections[] = '2.3.2';
    phpAds_PageHeader('2.3.2');
    echo $icon;
	phpAds_ShowSections($sections);
}

/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

require_once MAX_PATH . '/lib/OA/Admin/Template.php';

$oTpl = new OA_Admin_Template('advertiser-user.html');
$oTpl->assign('action', 'advertiser-user.php');
$oTpl->assign('backUrl', 'advertiser-user-start.php?clientid='.$clientid);
$oTpl->assign('method', 'POST');
$oTpl->assign('aErrors', $aErrors);

// TODO: will need to know whether we're hosted or downloaded
$HOSTED = false;
$oTpl->assign('hosted', $HOSTED);

// indicates whether the user exists (otherwise, a new user will be created or invitation sent)
$oTpl->assign('existingUser', !empty($userid));

// indicates whether the form is in editing user properties mode
// (linked from the "Permissions" link in the User Access table)
$oTpl->assign('editMode', !$link);

$doUsers = OA_Dal::staticGetDO('users', $userid);
$userData = array();
if ($doUsers) {
    $userData = $doUsers->toArray();
} else {
    $userData['username'] = $login;
}

$aHiddenFields = OA_Admin_UI_UserAccess::getHiddenFields($login, $link, 'clientid', $clientid);
$oTpl->assign('hiddenFields', $aHiddenFields);

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

//var_dump($oTpl);
//die();
$oTpl->display();
?>

<script language='JavaScript'>
<!--
<?php if (OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) { ?>
    function MMM_cascadePermissionsChange()
    {
        var e = findObj('permissions_<?php echo OA_PERM_ZONE_EDIT; ?>');
        var a = findObj('permissions_<?php echo OA_PERM_ZONE_ADD; ?>');
        var d = findObj('permissions_<?php echo OA_PERM_ZONE_DELETE; ?>');

        a.disabled = d.disabled = !e.checked;
        if (!e.checked) {
            a.checked = d.checked = false;
        }
    }
    MMM_cascadePermissionsChange();
//-->
<?php } ?>
</script>

<?php
/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PageFooter();

?>
