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
$Id: affiliate-edit.php 12839 2007-11-27 16:32:39Z bernard.lange@openads.org $
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
// TODOPERM - should we add here some additional or every super user should have access to all accounts?
OA_Permission::enforceAccount(OA_ACCOUNT_MANAGER, OA_ACCOUNT_TRAFFICKER);

$entityName = 'affiliates';
$entityId = $affiliateid;
OA_Permission::enforceAccessToObject($entityName, $entityId);
OA_Permission::enforceTrue(!empty($entityId));
$accountId = OA_Permission::getAccountIdForEntity($entityName, $entityId);
$doUsers = OA_Dal::factoryDO('users');
$userid = $doUsers->getUserIdByUserName($login);


if (!empty($submit)) {
    $userid = OA_Admin_UI_UserAccess::saveUser($login, $passwd, $contact_name, $email_address);
    OA_Admin_UI_UserAccess::linkUserToAccount($userid, $accountId, $permissions);
    MAX_Admin_Redirect::redirect('affiliate-access.php?affiliateid='.$affiliateid);
}


/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PageHeader("4.2.7.2");
echo "<img src='images/icon-affiliate.gif' align='absmiddle'>&nbsp;<b>".phpAds_getAffiliateName($affiliateid)."</b><br /><br /><br />";
phpAds_ShowSections(array("4.2.2", "4.2.3","4.2.4","4.2.5","4.2.6","4.2.7", "4.2.7.2"));

/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

require_once MAX_PATH . '/lib/OA/Admin/Template.php';

$oTpl = new OA_Admin_Template('affiliate-user.html');
$oTpl->assign('action', 'affiliate-user.php');
$oTpl->assign('backUrl', 'affiliate-user-start.php?affiliate='.$entityId);
$oTpl->assign('method', 'POST');

// TODO: will need to know whether we're hosted or downloaded
$HOSTED = false;
$oTpl->assign('hosted', $HOSTED);

// indicates whether the user exists (otherwise, a new user will be created or invitation sent)
$existingUser = !empty($userid);
$oTpl->assign('existingUser', !empty($userid));

// indicates whether the form is in editing user properties mode
// (linked from the "Permissions" link in the User Access table)
// Alternatively, we may want to have two separate templates/php files for these
// with common parts included from another template
$oTpl->assign('editMode', !$link);
$oTpl->assign('affiliateid', $affiliateid);

$doUsers = OA_Dal::staticGetDO('users', $userid);
$userData = array();
if ($doUsers) {
    $userData = $doUsers->toArray();
} else {
    $userData['username'] = $login;
}

$oTpl->assign('hiddenFields', array(
    array(
        'name' => 'submit',
        'value' => true
    ),
    array(
        'name' => 'affiliateid',
        'value' => $affiliateid
    ),
    array(
        'name' => 'login',
        'value' => $login
    ),

));

$oTpl->assign('fields', array(
    array(
        'title'     => $strUserDetails,
        'fields'    => OA_Admin_UI_UserAccess::getUserDetailsFields($userData)
    ),
    array(
        'title'     => $strPermissions,
        'fields'    => array(
            array(
                'name'      => 'permissions[]',
                'label'     => $strAllowAffiliateModifyZones,
                'type'      => 'checkbox',
                'value'     => OA_PERM_ZONE_EDIT,
                'checked'   => OA_Permission::hasPermission(OA_PERM_ZONE_EDIT, $accountId, $userid),
                'hidden'    => OA_Permission::isAccount(OA_ACCOUNT_TRAFFICKER),
                'break'     => false,
                'id'        => 'permissions_'.OA_PERM_ZONE_EDIT,
                'onclick'   => 'MMM_cascadePermissionsChange()'
            ),
            array(
                'name'      => 'permissions[]',
                'label'     => $strAllowAffiliateAddZone,
                'type'      => 'checkbox',
                'value'     => OA_PERM_ZONE_ADD,
                'checked'   => OA_Permission::hasPermission(OA_PERM_ZONE_ADD, $accountId, $userid),
                'hidden'    => OA_Permission::isAccount(OA_ACCOUNT_TRAFFICKER),
                'break'     => false,
                'id'        => 'permissions_'.OA_PERM_ZONE_ADD,
                'indent'    => true
            ),
            array(
                'name'      => 'permissions[]',
                'label'     => $strAllowAffiliateDeleteZone,
                'type'      => 'checkbox',
                'value'     => OA_PERM_ZONE_DELETE,
                'checked'   => OA_Permission::hasPermission(OA_PERM_ZONE_DELETE, $accountId, $userid),
                'hidden'    => OA_Permission::isAccount(OA_ACCOUNT_TRAFFICKER),
                'break'     => false,
                'id'        => 'permissions_'.OA_PERM_ZONE_DELETE,
                'indent'    => true
            ),
            array(
                'name'      => 'permissions[]',
                'label'     => $strAllowAffiliateLinkBanners,
                'type'      => 'checkbox',
                'value'     => OA_PERM_ZONE_LINK,
                'checked'   => OA_Permission::hasPermission(OA_PERM_ZONE_LINK, $accountId, $userid),
                'hidden'    => OA_Permission::isAccount(OA_ACCOUNT_TRAFFICKER),
                'break'     => false,
                'id'        => 'permissions_'.OA_PERM_ZONE_LINK
            ),
            array(
                'name'      => 'permissions[]',
                'label'     => $strAllowAffiliateGenerateCode,
                'type'      => 'checkbox',
                'value'     => OA_PERM_ZONE_INVOCATION,
                'checked'   => OA_Permission::hasPermission(OA_PERM_ZONE_INVOCATION, $accountId, $userid),
                'hidden'    => OA_Permission::isAccount(OA_ACCOUNT_TRAFFICKER),
                'break'     => false,
                'id'        => 'permissions_'.OA_PERM_ZONE_INVOCATION
            ),
        )
    )
));

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
