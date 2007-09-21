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

// Register input variables
phpAds_registerGlobalUnslashed ('move', 'name', 'website', 'contact', 'email', 'language', 'publiczones',
                               'errormessage', 'affiliateusername', 'affiliatepassword', 'affiliatepermissions', 'submit',
                               'publiczones_old', 'pwold', 'pw', 'pw2', 'mnemonic', 'comments',
                               'address', 'city', 'postcode', 'country', 'phone', 'fax', 'account_contact',
                               'payee_name', 'tax_id_present', 'tax_id', 'mode_of_payment', 'currency',
                               'unique_users', 'unique_views', 'page_rank', 'category', 'help_file',
                               'terms_and_conditions', 'account_type');

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

if (isset($submit)) {
    $errormessage = array();
    $affiliate = array();
    $affiliate_extra = array();

    // Get previous values
    if (isset($affiliateid)) {
        $doAffiliates = OA_Dal::factoryDO('affiliates');
        if ($doAffiliates->get($affiliateid)) {
            $affiliate = $doAffiliates->toArray();
        }

        $doAffiliatesExtra = OA_Dal::factoryDO('affiliates_extra');
        if ($doAffiliatesExtra->get($affiliateid)) {
            $affiliate_extra = $doAffiliatesExtra->toArray();
        }

    }
    // Name
    if (phpAds_isUser(phpAds_Admin) || phpAds_isUser(phpAds_Agency)) {
        $affiliate['name'] = trim($name);
    }

    // Website
    if (isset($website) && $website == 'http://') {
        $affiliate['website'] = '';
    } else {
        $affiliate['website'] = trim($website);
    }
    // Default fields
    $affiliate['agencyid']    = $agencyid;
    $affiliate['contact']     = trim($contact);
    $affiliate['email']       = trim($email);

    // Non-affiliate fields
    if (!MAX_Permission::isAllowed(MAX_AffiliateIsReallyAffiliate)) {
        $affiliate['language']    = trim($language);
    }

    if (phpAds_isUser(phpAds_Admin) || phpAds_isUser(phpAds_Agency)) {
        // Mnemonic
        $affiliate['mnemonic'] = trim($mnemonic);

        // Public
        $affiliate['publiczones'] = isset($publiczones) ? 't' : 'f';

        // Password
        if (isset($affiliatepassword)) {
            if ($affiliatepassword == '') {
                $affiliate['password'] = '';
            } elseif ($affiliatepassword != '********') {
                $affiliate['password'] = md5($affiliatepassword);
            }
        }
        // Username
        if (!empty($affiliateusername)) {
            $oldUserName = (isset($affiliate['username'])) ? $affiliate['username'] : '';
            if (!MAX_Permission::isUsernameAllowed($oldUserName, $affiliateusername)) {
                $errormessage[] = $strDuplicateAgencyName;
            }
            $affiliate['username'] = $affiliateusername;
    	}
        // Permissions
        $affiliate['permissions'] = 0;
        if (isset($account_type) && $account_type == 'affiliate') {
            $affiliate['permissions'] = MAX_AffiliateIsReallyAffiliate +
                                        MAX_AffiliateGenerateCode +
                                        phpAds_ModifyInfo;
        }
        if (isset($affiliatepermissions) && is_array($affiliatepermissions)) {
            for ($i=0;$i<sizeof($affiliatepermissions);$i++) {
                $affiliate['permissions'] += $affiliatepermissions[$i];
            }
        }
    } else {
        // Password
        if (isset($pwold) && strlen($pwold) ||
            isset($pw) && strlen($pw) ||
            isset($pw2) && strlen($pw2)) {
            if (md5($pwold) != $affiliate['password']) {
                $errormessage[] = $strPasswordWrong;
            } elseif (!strlen($pw) || strstr("\\", $pw)) {
                $errormessage[] = $strInvalidPassword;
            } elseif (strcmp($pw, $pw2)) {
                $errormessage[] = $strNotSamePasswords;
            } else {
                $affiliate['password'] = md5($pw);
            }
        }
    }

    // Extra fields
    $affiliate_extra['address']         = trim($address);
    $affiliate_extra['city']            = trim($city);
    $affiliate_extra['postcode']        = trim($postcode);
    $affiliate_extra['country']         = trim($country);
    $affiliate_extra['phone']           = trim($phone);
    $affiliate_extra['fax']             = trim($fax);
    $affiliate_extra['account_contact'] = trim($account_contact);
    $affiliate_extra['payee_name']      = trim($payee_name);
    $affiliate_extra['tax_id']          = isset($tax_id_present) && $tax_id_present == 't' && isset($tax_id) ? trim($tax_id) : '';
    $affiliate_extra['mode_of_payment'] = trim($mode_of_payment);
    $affiliate_extra['currency']        = trim($currency);
    $affiliate_extra['unique_users']    = trim($unique_users);
    $affiliate_extra['unique_views']    = trim($unique_views);
    $affiliate_extra['page_rank']       = trim($page_rank);
    if (!empty($category)) {
        $affiliate_extra['category']    = trim($category);
    }

    if (phpAds_isUser(phpAds_Admin) || phpAds_isUser(phpAds_Agency)) {
        // Extra fields
        $affiliate['comments']    = trim($comments);
        if (!empty($help_file)) {
            $affiliate_extra['help_file'] = trim($help_file);
        }
    }

    if (count($errormessage) == 0) {
        if ($affiliateid && $publiczones != 't' && $publiczones_old == 't') {
            // Reset append codes which called this affiliate's zones
            $doZones = OA_Dal::factoryDO('zones');
            $doZones->affiliateid = $affiliateid;
            $zones = $doZones->getAll(array('zoneid'));

            if (count($zones)) {
                $doZones = OA_Dal::factoryDO('zones');
                $doZones->appendtype = phpAds_ZoneAppendZone;
                $doZones->whereAdd("affiliateid <> '$affiliateid'");
                $doZones->find();
                while ($doZones->fetch() && $currentrow = $doZones->toArray()) {
                    $append = phpAds_ZoneParseAppendCode($currentrow['append']);
                    if (in_array($append[0]['zoneid'], $zones)) {
                        $doZones->appendtype = phpAds_ZoneAppendRaw;
                        $doZones->append = '';
                        $doZones->update();
                    }
                }
            }
        }
        if (empty($affiliateid)) {
            $doAffiliates = OA_Dal::factoryDO('affiliates');
            $doAffiliates->setFrom($affiliate);
            $doAffiliates->updated = OA::getNow();
            $affiliateid = $doAffiliates->insert();

            // Go to next page
            if (isset($move) && $move == 't') {
                // Move loose zones to this affiliate
                $doZones = OA_Dal::factoryDO('zones');
                $doZones->affiliateid = $affiliateid;
                $doZones->whereAdd('affiliateid = NULL');
                $doZones->whereAdd('affiliateid = 0', 'OR');
                $doZones->update();

                $redirect_url = "affiliate-zones.php?affiliateid=$affiliateid";
            } else {
                $redirect_url = "zone-edit.php?affiliateid=$affiliateid";
            }
        } else {
            $doAffiliates = OA_Dal::factoryDO('affiliates');
            $doAffiliates->get($affiliateid);
            $doAffiliates->setFrom($affiliate);

            // Update
            $doAffiliates->update();

            // Go to next page
            if (phpAds_isUser(phpAds_Affiliate)) {
                // Set current session to new language
                $session['language'] = $language;
                phpAds_SessionDataStore();
            }
            if (phpAds_isUser(phpAds_Affiliate)) {
                $redirect_url = "affiliate-edit.php?affiliateid=$affiliateid";
            } else {
                $redirect_url = "affiliate-zones.php?affiliateid=$affiliateid";
            }
        }

        if (phpAds_isUser(phpAds_Admin) || phpAds_isUser(phpAds_Agency)) {

            // Delete publisher preferences when switching to affiliate
            if (isset($account_type) && $account_type == 'affiliate') {
                $doPreference_publisher = OA_Dal::factoryDO('preference_publisher');
                $doPreference_publisher->publisher_id = $affiliateid;
                $doPreference_publisher->delete();
            }
        }

        // Update extra fields
        if (isset($affiliate_extra['affiliateid'])) {
            $doAffiliatesExtra = OA_Dal::factoryDO('affiliates_extra');
            $doAffiliatesExtra->get($affiliateid);
            $doAffiliatesExtra->setFrom($affiliate_extra);

            // Update
            $doAffiliatesExtra->update();
        } else {
            $doAffiliatesExtra = OA_Dal::factoryDO('affiliates_extra');
            $doAffiliatesExtra->setFrom($affiliate_extra);
            $doAffiliatesExtra->affiliateid = $affiliateid;

            // Insert
            $doAffiliatesExtra->insert();
        }

        MAX_Admin_Redirect::redirect($redirect_url);
        exit;
    } else {
        // If an error occured set the password back to its previous value
        $affiliate['password'] = $affiliatepassword;
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
        $doAffiliatesExtra = OA_Dal::factoryDO('affiliates_extra');
        if ($doAffiliatesExtra->get($affiliateid)) {
            $affiliate_extra = $doAffiliatesExtra->toArray();
        }
    }
} else {
    phpAds_PageHeader("4.2.1");
    echo "<img src='images/icon-affiliate.gif' align='absmiddle'>&nbsp;<b>".phpAds_getAffiliateName($affiliateid)."</b><br /><br /><br />";
    phpAds_ShowSections(array("4.2.1"));
    // Do not set this information if the page
    // is the result of an error message
    if (!isset($affiliate)) {
        $affiliate['name']        = $strUntitled;
        $affiliate['mnemonic']    = '';
        $affiliate['website']     = 'http://';
        $affiliate['contact']     = '';
        $affiliate['email']       = '';
        $affiliate['publiczones'] = 'f';
        $affiliate['username']    = '';
        $affiliate['password']    = '';
        $affiliate['permissions'] = 0;
        $affiliate['comments']    = '';

        $affiliate['tax_id_present']                 = $pref['publisher_default_tax_id'];
        $affiliate['last_accepted_agency_agreement'] = $pref['publisher_default_approved'];

        $affiliate_extra = array();
        $affiliate_extra['address'] = '';
        $affiliate_extra['city'] = '';
        $affiliate_extra['postcode'] = '';
        $affiliate_extra['country'] = '';
        $affiliate_extra['phone'] = '';
        $affiliate_extra['fax'] = '';
        $affiliate_extra['account_contact'] = '';
        $affiliate_extra['payee_name'] = '';
        $affiliate_extra['tax_id'] = '';
        $affiliate_extra['mode_of_payment'] = '';
        $affiliate_extra['currency'] = '';
        $affiliate_extra['unique_users'] = '';
        $affiliate_extra['unique_views'] = '';
        $affiliate_extra['page_rank'] = '';
    }
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
                                'checked' => !empty($affiliate['oac_website_id'])
                               )
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
                'style'     => 'width: 15em'
            ),
            array(
                'type'      => 'custom',
                'template'  => 'country-language',
                'vars'      => array(
                                'aCountries'  => $oAdNetworks->getCountriesSelect(),
                                'aLanguages' => $oAdNetworks->getLanguagesSelect(),
                                'country'  => $affiliate['oac_country_code'],
                                'language' => $affiliate['oac_language_id']
                               )
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




?>

<script language='JavaScript'>
<!--
    max_formSetRequirements('contact', '<?php echo addslashes($strContact); ?>', true);
    max_formSetRequirements('website', '<?php echo addslashes($strWebsite); ?>', true, 'url');
    max_formSetRequirements('email', '<?php echo addslashes($strEMail); ?>', true, 'email');

<?php if (phpAds_isUser(phpAds_Admin) || phpAds_isUser(phpAds_Agency)) { ?>
    max_formSetRequirements('name', '<?php echo addslashes($strName); ?>', true, 'unique');
    max_formSetRequirements('affiliateusername', '<?php echo addslashes($strUsername); ?>', false, 'unique');

    max_formSetUnique('name', '|<?php echo addslashes(implode('|', $unique_names)); ?>|');
    max_formSetUnique('affiliateusername', '|<?php echo addslashes(implode('|', $unique_users)); ?>|');

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

$oTpl->display();

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PageFooter();

?>
