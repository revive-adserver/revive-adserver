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
require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/lib/max/Admin/Languages.php';
require_once MAX_PATH . '/lib/max/Admin/Redirect.php';
require_once MAX_PATH . '/lib/OA/Central/AdNetworks.php';
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/www/admin/lib-statistics.inc.php';
require_once MAX_PATH . '/www/admin/lib-zones.inc.php';
require_once MAX_PATH . '/lib/OA/Dll/Publisher.php';

// Register input variables
phpAds_registerGlobalUnslashed ('move', 'name', 'website', 'contact', 'email', 'language', 'adnetworks', 'advsignup',
                               'errormessage', 'affiliateusername', 'affiliatepassword', 'affiliatepermissions', 'submit',
                               'publiczones_old', 'pwold', 'pw', 'pw2', 'formId', 'category', 'country', 'language');

// Security check
MAX_Permission::checkAccess(phpAds_Admin + phpAds_Agency + phpAds_Affiliate);
MAX_Permission::checkIsAllowed(phpAds_ModifyInfo);
MAX_Permission::checkAccessToObject('affiliates', $affiliateid);

// Initialise Ad  Networks
$oAdNetworks = new OA_Central_AdNetworks();

/*-------------------------------------------------------*/
/* Affiliate interface security                          */
/*-------------------------------------------------------*/

if (phpAds_isUser(phpAds_Affiliate)) {
    $doAffiliates = OA_Dal::factoryDO('affiliates');
    $affiliateid = phpAds_getUserID();
    $doAffiliates->get($affiliateid);
    $agencyid = $doAffiliates->agencyid;
} elseif (phpAds_isUser(phpAds_Agency)) {
    $agencyid = phpAds_getUserID();
} else {
    $agencyid = 0;
}


/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PageHeader("4.2.7.2");
echo "<img src='images/icon-affiliate.gif' align='absmiddle'>&nbsp;<b>".phpAds_getAffiliateName($affiliateid)."</b><br /><br /><br />";
phpAds_ShowSections(array("4.2.7.2"));

/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

require_once MAX_PATH . '/lib/OA/Admin/Template.php';

$oTpl = new OA_Admin_Template('affiliate-user.html');

// TODO: will need to know whether we're hosted or downloaded
$HOSTED = false; 
$oTpl->assign('hosted', $HOSTED);

// TODO: indicates whether the user exists (otherwise, a new user will be created or invitation sent)
$existingUser = false;
$oTpl->assign('existingUser', $existingUser); 

// TODO: indicates whether the form is in editing user properties mode
// (linked from the "Permissions" link in the User Access table)
// Alternatively, we may want to have two separate templates/php files for these
// with common parts included from another template
$oTpl->assign('editMode', false); 

$oTpl->assign('error', $oPublisherDll->_errorMessage);

$oTpl->assign('affiliateid', $affiliateid);

$userDetailsFields = array();

if ($HOSTED) {
   $userDetailsFields[] = array(
                  'name'      => 'email',
                  'label'     => $strEMail,
                  'value'     => 'test@test.com', // TODO: put e-mail here
                  'freezed'   => true
              );

   if ($existingUser) {
      $userDetailsFields[] = array(
                   'type'      => 'custom',
                   'template'  => 'link',
                   'label'     => $strPwdRecReset,
                   'href'      => 'user-password-reset.php', // TODO: put the actual password resetting script here
                   'text'      => $strPwdRecResetPwdThisUser
               );
   }
   else {
      $userDetailsFields[] = array(
                   'name'      => 'contact',
                   'label'     => $strContactName,
                   'value'     => $affiliate['contact']
               );
   }
}
else {
   $userDetailsFields[] = array(
                   'name'      => 'username',
                   'label'     => $strUsername,
                   'value'     => 'username', // TODO: put user name here
                   'freezed'   => true
               );
   $userDetailsFields[] = array(
                   'name'      => 'contact',
                   'label'     => $strContactName,
                   'value'     => $affiliate['contact']
               );
   $userDetailsFields[] = array(
                   'name'      => 'email',
                   'label'     => $strEMail,
                   'value'     => $affiliate['email']
               );

   if ($existingUser) {
      $userDetailsFields[] = array(
                   'type'      => 'custom',
                   'template'  => 'link',
                   'label'     => $strPwdRecReset,
                   'href'      => 'user-password-reset.php', // TODO: put the actual password resetting script here
                   'text'      => $strPwdRecResetPwdThisUser
               );
   }
}

$oTpl->assign('fields', array(
    array(
        'title'     => $strUserDetails,
        'fields'    => $userDetailsFields
    ),
    array(
        'title'     => $strPermissions,
        'fields'    => array(
            array(
                'name'      => 'affiliatepermissions[]',
                'label'     => $strAllowAffiliateModifyInfo,
                'type'      => 'checkbox',
                'value'     => phpAds_ModifyInfo,
                'checked'   => $affiliate['permissions'] & phpAds_ModifyInfo,
                'hidden'    => phpAds_isUser(phpAds_Affiliate)
            ),
            array(
                'name'      => 'affiliatepermissions[]',
                'label'     => $strAllowAffiliateModifyZones,
                'type'      => 'checkbox',
                'value'     => phpAds_EditZone,
                'checked'   => $affiliate['permissions'] & phpAds_EditZone,
                'hidden'    => phpAds_isUser(phpAds_Affiliate),
                'break'     => false,
                'id'        => 'affiliatepermissions_'.phpAds_EditZone,
                'onclick'   => 'MMM_cascadePermissionsChange()'
            ),
            array(
                'name'      => 'affiliatepermissions[]',
                'label'     => $strAllowAffiliateAddZone,
                'type'      => 'checkbox',
                'value'     => phpAds_AddZone,
                'checked'   => $affiliate['permissions'] & phpAds_AddZone,
                'hidden'    => phpAds_isUser(phpAds_Affiliate),
                'break'     => false,
                'id'        => 'affiliatepermissions_'.phpAds_AddZone,
                'indent'    => true
            ),
            array(
                'name'      => 'affiliatepermissions[]',
                'label'     => $strAllowAffiliateDeleteZone,
                'type'      => 'checkbox',
                'value'     => phpAds_DeleteZone,
                'checked'   => $affiliate['permissions'] & phpAds_DeleteZone,
                'hidden'    => phpAds_isUser(phpAds_Affiliate),
                'break'     => false,
                'id'        => 'affiliatepermissions_'.phpAds_DeleteZone,
                'indent'    => true
            ),
            array(
                'name'      => 'affiliatepermissions[]',
                'label'     => $strAllowAffiliateLinkBanners,
                'type'      => 'checkbox',
                'value'     => phpAds_LinkBanners,
                'checked'   => $affiliate['permissions'] & phpAds_LinkBanners,
                'hidden'    => phpAds_isUser(phpAds_Affiliate),
                'break'     => false,
                'id'        => 'affiliatepermissions_'.phpAds_LinkBanners
            ),
            array(
                'name'      => 'affiliatepermissions[]',
                'label'     => $strAllowAffiliateGenerateCode,
                'type'      => 'checkbox',
                'value'     => MAX_AffiliateGenerateCode,
                'checked'   => $affiliate['permissions'] & MAX_AffiliateGenerateCode,
                'hidden'    => phpAds_isUser(phpAds_Affiliate),
                'break'     => false,
                'id'        => 'affiliatepermissions_'.MAX_AffiliateGenerateCode
            ),
            array(
                'name'      => 'affiliatepermissions[]',
                'label'     => $strAllowAffiliateZoneStats,
                'type'      => 'checkbox',
                'value'     => MAX_AffiliateViewZoneStats,
                'checked'   => $affiliate['permissions'] & MAX_AffiliateViewZoneStats,
                'hidden'    => phpAds_isUser(phpAds_Affiliate),
                'break'     => false,
                'id'        => 'affiliatepermissions_'.MAX_AffiliateViewZoneStats
            ),
            array(
                'name'      => 'affiliatepermissions[]',
                'label'     => $strAllowAffiliateApprPendConv,
                'type'      => 'checkbox',
                'value'     => MAX_AffiliateViewOnlyApprPendConv,
                'checked'   => $affiliate['permissions'] & MAX_AffiliateViewOnlyApprPendConv,
                'hidden'    => phpAds_isUser(phpAds_Affiliate),
                'id'        => 'affiliatepermissions_'.MAX_AffiliateViewOnlyApprPendConv
            )
        )
    )
));

//var_dump($oTpl);
//die();
$oTpl->display();
?>

<script language='JavaScript'>
<!--
<?php if (phpAds_isUser(phpAds_Admin) || phpAds_isUser(phpAds_Agency)) { ?>
    function MMM_cascadePermissionsChange()
    {
        var e = findObj('affiliatepermissions_<?php echo phpAds_EditZone; ?>');
        var a = findObj('affiliatepermissions_<?php echo phpAds_AddZone; ?>');
        var d = findObj('affiliatepermissions_<?php echo phpAds_DeleteZone; ?>');

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
