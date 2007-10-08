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
require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/lib/max/Admin/Languages.php';
require_once MAX_PATH . '/lib/max/Admin/Redirect.php';
require_once MAX_PATH . '/lib/OA/Central/AdNetworks.php';
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/www/admin/lib-statistics.inc.php';
require_once MAX_PATH . '/www/admin/lib-zones.inc.php';
require_once MAX_PATH . '/lib/OA/Dll/Publisher.php';

// Register input variables
phpAds_registerGlobalUnslashed ('move', 'name', 'website', 'contact', 'email', 'language', 'adnetworks',
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
/* Process submitted form                                */
/*-------------------------------------------------------*/

if (isset($formId)) {
    // Setup a new publisher object and set the fields passed in from the form:
    $oPublisher = new OA_Dll_PublisherInfo();
    $oPublisher->agencyId       = $agencyid;
    $oPublisher->contactName    = $contact;
    $oPublisher->emailAddress   = $email;
    $oPublisher->password       = $affiliatepassword;
    $oPublisher->publisherId    = $affiliateid;
    $oPublisher->publisherName  = $name;
    $oPublisher->username       = $affiliateusername;
    $oPublisher->oacCategoryId  = $category;
    $oPublisher->oacCountryCode = $country;
    $oPublisher->oacLanguageId  = $language;
    $oPublisher->website        = $website;
    $oPublisher->permissions    = $affiliatepermissions;

    // Do I need to handle this?
    $oPublisher->adNetworks =   ($adnetworks == 't') ? true : false;

    $oPublisherDll = new OA_Dll_Publisher();
    if ($oPublisherDll->modify($oPublisher)) {
        if (phpAds_isUser(phpAds_Affiliate)) {
            $redirect_url = "affiliate-edit.php?affiliateid={$oPublisher->publisherId}";
        } else {
            $redirect_url = "affiliate-zones.php?affiliateid={$oPublisher->publisherId}";
        }
        MAX_Admin_Redirect::redirect($redirect_url);
        exit;
    }
}

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

if ($affiliateid != "") {
    if (phpAds_isUser(phpAds_Admin) || phpAds_isUser(phpAds_Agency)) {
        if (isset($session['prefs']['affiliate-index.php']['listorder'])) {
            $navorder = $session['prefs']['affiliate-index.php']['listorder'];
        } else {
            $navorder = '';
        }
        if (isset($session['prefs']['affiliate-index.php']['orderdirection'])) {
            $navdirection = $session['prefs']['affiliate-index.php']['orderdirection'];
        } else {
            $navdirection = '';
        }
        // Get other affiliates

        $doAffiliates = OA_Dal::factoryDO('affiliates');
        if (phpAds_isUser(phpAds_Agency)) {
            $doAffiliates->agencyid = $agencyid;
        } elseif (phpAds_isUser(phpAds_Affiliate)) {
            $doAffiliates->affiliateid = $affiliateid;
        }
        $doAffiliates->addListOrderBy($navorder, $navdirection);
        $doAffiliates->find();
        while ($doAffiliates->fetch() && $row = $doAffiliates->toArray()) {
            phpAds_PageContext(
                phpAds_buildAffiliateName ($row['affiliateid'], $row['name']),
                "affiliate-edit.php?affiliateid=".$row['affiliateid'],
                $affiliateid == $row['affiliateid']
            );
        }
        phpAds_PageShortcut($strAffiliateHistory, 'stats.php?entity=affiliate&breakdown=history&affiliateid='.$affiliateid, 'images/icon-statistics.gif');
        phpAds_PageHeader("4.2.2");
        echo "<img src='images/icon-affiliate.gif' align='absmiddle'>&nbsp;<b>".phpAds_getAffiliateName($affiliateid)."</b><br /><br /><br />";
        phpAds_ShowSections(array("4.2.2", "4.2.3","4.2.4","4.2.5"));
    } else {
        if (MAX_Permission::isAllowed(MAX_AffiliateIsReallyAffiliate)) {
            phpAds_PageHeader('4');
        } else {
            $sections = array();
            $sections[] = "4.1";
            if (MAX_Permission::isAllowed(phpAds_ModifyInfo)) {
                $sections[] = "4.2";
            }
            phpAds_PageHeader('4.2');
            phpAds_ShowSections($sections);
        }
    }
    // Do not get this information if the page
    // is the result of an error message
    if (!isset($affiliate)) {
        $doAffiliates = OA_Dal::factoryDO('affiliates');
        if ($doAffiliates->get($affiliateid)) {
            $affiliate = $doAffiliates->toArray();
        }

        // Set password to default value
        if ($affiliate['password'] != '') {
            $affiliate['password'] = '********';
        }
    }
} else {
    phpAds_PageHeader("4.2.1");
    echo "<img src='images/icon-affiliate.gif' align='absmiddle'>&nbsp;<b>".phpAds_getAffiliateName($affiliateid)."</b><br /><br /><br />";
    phpAds_ShowSections(array("4.2.1"));
}

/*-------------------------------------------------------*/
/* Form requirements                                     */
/*-------------------------------------------------------*/

// Get unique affiliate
// XXX: Although the JS suggests otherwise, this unique_name constraint isn't enforced.
$doAffiliates = OA_Dal::factoryDO('affiliates');
$aUniqueNames = $doAffiliates->getUniqueValuesFromColumn('name', $affiliate['name']);
$aUniqueUsers = MAX_Permission::getUniqueUserNames($affiliate['username']);


/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

require_once MAX_PATH . '/lib/OA/Admin/Template.php';

$oTpl = new OA_Admin_Template('affiliate-edit.html');

$oTpl->assign('error', $oPublisherDll->_errorMessage);

$oTpl->assign('affiliateid', $affiliateid);
$oTpl->assign('move', $move);

$oTpl->assign('fieldsTop', array(
    array(
        'title'     => $strBasicInformation,
        'fields'    => array(
            array(
                'name'      => 'website',
                'label'     => $strWebsite,
                'value'     => $affiliate['website']
            ),
            array(
                'type'      => 'custom',
                'template'  => 'adnetworks',
                'label'     => 'Ad Networks',
                'vars'      => array(
                                'checked' => !empty($affiliate['oac_website_id']),
                                'disabled'  => ($GLOBALS['_MAX']['PREF']['updates_enabled'] != 't')
                               ),
            ),
            array(
                'name'      => 'name',
                'label'     => $strName,
                'value'     => $affiliate['name'],
                'freezed'   => phpAds_isUser(phpAds_Affiliate)
            ),
            array(
                'name'      => 'category',
                'label'     => 'Category',
                'type'      => 'select',
                'options'   => $oAdNetworks->getCategoriesSelect(),
                'value'     => $affiliate['oac_category_id'],
                'style'     => 'width: 15em',
                //'disabled'  => !empty($affiliate['oac_website_id'])
            ),
            array(
                'type'      => 'custom',
                'template'  => 'country-language',
                'vars'      => array(
                                'aCountries'  => $oAdNetworks->getCountriesSelect(),
                                'aLanguages' => $oAdNetworks->getLanguagesSelect(),
                                'country'  => $affiliate['oac_country_code'],
                                'language' => $affiliate['oac_language_id']
                               ),
               // 'disabled'  => !empty($affiliate['oac_website_id'])
            ),
            array(
                'name'      => 'contact',
                'label'     => $strContact,
                'value'     => $affiliate['contact']
            ),
            array(
                'name'      => 'email',
                'label'     => $strEMail,
                'value'     => $affiliate['email']
            )
        )
    )
));

$oTpl->assign('fieldsBottom', array(
    array(
        'title'     => $strLoginInformation,
        'errors'    => count($errormessage) ? $error_message : false,
        'fields'    => array(
            array(
                'name'      => 'affiliateusername',
                'style'     => 'small',
                'label'     => $strUsername,
                'value'     => $affiliate['username'],
                'freezed'   => phpAds_isUser(phpAds_Affiliate)
            ),
            array(
                'name'      => 'affiliatepassword',
                'style'     => 'small',
                'label'     => $strPassword,
                'type'      => 'password',
                'value'     => $affiliate['password'],
                'hidden'    => phpAds_isUser(phpAds_Affiliate)
            ),
            array(
                'name'      => 'pwold',
                'style'     => 'small',
                'label'     => $strOldPassword,
                'type'      => 'password',
                'hidden'    => !phpAds_isUser(phpAds_Affiliate)
            ),
            array(
                'name'      => 'pw',
                'style'     => 'small',
                'label'     => $strNewPassword,
                'type'      => 'password',
                'hidden'    => !phpAds_isUser(phpAds_Affiliate)
            ),
            array(
                'name'      => 'pw2',
                'style'     => 'small',
                'label'     => $strRepeatPassword,
                'type'      => 'password',
                'hidden'    => !phpAds_isUser(phpAds_Affiliate)
            ),
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


$oTpl->display();

?>

<script language='JavaScript'>
<!--
    max_formSetRequirements('contact', '<?php echo addslashes($strContact); ?>', true);
    max_formSetRequirements('website', '<?php echo addslashes($strWebsite); ?>', true, 'url');
    max_formSetRequirements('email', '<?php echo addslashes($strEMail); ?>', true, 'email');

<?php if (phpAds_isUser(phpAds_Admin) || phpAds_isUser(phpAds_Agency)) { ?>
    max_formSetRequirements('name', '<?php echo addslashes($strName); ?>', true, 'unique');
    max_formSetRequirements('affiliateusername', '<?php echo addslashes($strUsername); ?>', false, 'unique');

    max_formSetUnique('name', '|<?php echo addslashes(implode('|', $aUniqueNames)); ?>|');
    max_formSetUnique('affiliateusername', '|<?php echo addslashes(implode('|', $aUniqueUsers)); ?>|');

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
<?php } ?>
//-->
</script>

<?php

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PageFooter();

?>
