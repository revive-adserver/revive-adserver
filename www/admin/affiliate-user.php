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
OA_Permission::enforceAccount(OA_ACCOUNT_MANAGER, OA_ACCOUNT_TRAFFICKER);
OA_Permission::enforceAccountPermission(OA_ACCOUNT_TRAFFICKER, OA_PERM_SUPER_ACCOUNT);
OA_Permission::enforceAccessToObject('affiliates', $affiliateid);

$accountId = OA_Permission::getAccountIdForEntity('affiliates', $affiliateid);

$doUsers = OA_Dal::factoryDO('users');
$userid = $doUsers->getUserIdByUserName($login);

// Permissions
$aAllowedPermissions = array();
if (OA_Permission::isAccount(OA_ACCOUNT_MANAGER))
{
    $aAllowedPermissions[OA_PERM_SUPER_ACCOUNT] = array($strAllowCreateAccounts, false);
}
$aAllowedPermissions[OA_PERM_ZONE_EDIT]       = array($strAllowAffiliateModifyZones,  false, true);
$aAllowedPermissions[OA_PERM_ZONE_ADD]        = array($strAllowAffiliateAddZone,      true, false);
$aAllowedPermissions[OA_PERM_ZONE_DELETE]     = array($strAllowAffiliateDeleteZone,   true, false);
$aAllowedPermissions[OA_PERM_ZONE_LINK]       = array($strAllowAffiliateLinkBanners,  false, false);
$aAllowedPermissions[OA_PERM_ZONE_INVOCATION] = array($strAllowAffiliateGenerateCode, false, false);

$aErrors = array();
if (!empty($submit)) {
    if (!OA_Permission::userNameExists($login)) {
        $aErrors = OA_Admin_UI_UserAccess::validateUsersData($login, $passwd);
    }
    if (empty($aErrors)) {
        $userid = OA_Admin_UI_UserAccess::saveUser($login, $passwd, $contact_name, $email_address, $accountId);
        OA_Admin_UI_UserAccess::linkUserToAccount($userid, $accountId, $permissions, $aAllowedPermissions);
        MAX_Admin_Redirect::redirect('affiliate-access.php?affiliateid='.$affiliateid);
    }
}


/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

if (OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
    phpAds_PageHeader("4.2.7.2");
    echo "<img src='images/icon-affiliate.gif' align='absmiddle'>&nbsp;<b>".phpAds_getAffiliateName($affiliateid)."</b><br /><br /><br />";
    phpAds_ShowSections(array("4.2.2", "4.2.3","4.2.4","4.2.5","4.2.6","4.2.7", "4.2.7.2"));
} else {
    phpAds_PageHeader('2.3.2');
    $sections = array('2.1');
    if (OA_Permission::hasPermission(OA_PERM_ZONE_INVOCATION)) {
        $sections[] = '2.2';
    }
    $sections[] = '2.3';
    $sections[] = '2.3.2';
    phpAds_ShowSections($sections);
}

/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

require_once MAX_PATH . '/lib/OA/Admin/Template.php';

$oTpl = new OA_Admin_Template('affiliate-user.html');
$oTpl->assign('action', 'affiliate-user.php');
$oTpl->assign('backUrl', 'affiliate-user-start.php?affiliate='.$affiliateid);
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
$oTpl->assign('affiliateid', $affiliateid);

$doUsers = OA_Dal::staticGetDO('users', $userid);
$userData = array();
if ($doUsers) {
    $userData = $doUsers->toArray();
} else {
    $userData['username'] = $login;
}

$aHiddenFields = OA_Admin_UI_UserAccess::getHiddenFields($login, $link, 'affiliateid', $affiliateid);
$oTpl->assign('hiddenFields', $aHiddenFields);

$aPermissionsFields = array();
$isTrafficker = OA_Permission::isAccount(OA_ACCOUNT_TRAFFICKER);
$c = 0;
foreach ($aAllowedPermissions as $permissionId => $aPermission) {
    list($permissionName, $ident, $cascade) = $aPermission;
    $aPermissionsFields[$c] = array(
                'name'      => 'permissions[]',
                'label'     => $permissionName,
                'type'      => 'checkbox',
                'value'     => $permissionId,
                'checked'   => OA_Permission::hasPermission($permissionId, $accountId, $userid),
                'hidden'    => $isTrafficker,
                'break'     => false,
                'id'        => 'permissions_'.$permissionId,
                'ident'     => $ident,
            );
    if ($cascade) {
        $aPermissionsFields[$c]['onclick'] = 'MMM_cascadePermissionsChange()';
    }
    $c++;
}

$tplFields = array(
    array(
        'title'     => $strUserDetails,
        'fields'    => OA_Admin_UI_UserAccess::getUserDetailsFields($userData)
    )
);
if (OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
    $tplFields[] = array(
        'title'     => $strPermissions,
        'fields'    => $aPermissionsFields
    );
}
$oTpl->assign('fields', $tplFields);
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
