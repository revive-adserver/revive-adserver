<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
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
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/www/admin/lib-statistics.inc.php';
require_once MAX_PATH . '/www/admin/lib-zones.inc.php';

// Register input variables
phpAds_registerGlobal ('move', 'name', 'website', 'contact', 'email', 'language', 'publiczones',
                       'errormessage', 'username', 'password', 'affiliatepermissions', 'submit',
                       'publiczones_old', 'pwold', 'pw', 'pw2', 'mnemonic', 'comments',
                       'address', 'city', 'postcode', 'country', 'phone', 'fax', 'account_contact',
                       'payee_name', 'tax_id_present', 'tax_id', 'mode_of_payment', 'currency',
                       'unique_users', 'unique_views', 'page_rank', 'category', 'help_file',
                       'terms_and_conditions', 'account_type');

// Security check
MAX_Permission::checkAccess(phpAds_Admin + phpAds_Agency + phpAds_Affiliate);
MAX_Permission::checkIsAllowed(phpAds_ModifyInfo);
MAX_Permission::checkAccessToObject('affiliates', $affiliateid);

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
        if (isset($password)) {
            if ($password == '') {
                $affiliate['password'] = '';
            } elseif ($password != '********') {
                $affiliate['password'] = md5($password);
            }
        }
        // Username
        if (!empty($username)) {
            $oldUserName = (isset($affiliate['username'])) ? $affiliate['username'] : '';
            if (!MAX_Permission::isUsernameAllowed($oldUserName, $username)) {
                $errormessage[] = $strDuplicateAgencyName;
            }
            $affiliate['username'] = $username;
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
        $affiliate['password'] = $password;
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
$tabindex = 1;

/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

echo "<br /><br />";
echo "<form name='affiliateform' method='post' action='affiliate-edit.php' onSubmit='return max_formValidate(this);'>";
echo "<input type='hidden' name='affiliateid' value='".(isset($affiliateid) && $affiliateid != '' ? $affiliateid : '')."'>";
echo "<input type='hidden' name='move' value='".(isset($move) && $move != '' ? $move : '')."'>";

echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";
echo "<tr><td height='25' colspan='3'><b>".$strBasicInformation."</b></td></tr>";
echo "<tr height='1'><td width='30'><img src='images/break.gif' height='1' width='30'></td>";
echo "<td width='200'><img src='images/break.gif' height='1' width='200'></td>";
echo "<td width='100%'><img src='images/break.gif' height='1' width='100%'></td></tr>";
echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";

// Name
echo "<tr><td width='30'>&nbsp;</td><td width='200'>".$strName."</td>";

if (phpAds_isUser(phpAds_Admin) || phpAds_isUser(phpAds_Agency)) {
    echo "<td width='100%'><input onBlur='max_formValidateElement(this);' class='flat' type='text' name='name' size='35' style='width:350px;' value='".phpAds_htmlQuotes($affiliate['name'])."' tabindex='".($tabindex++)."'></td>";
} else {
    echo "<td width='100%'>".(isset($affiliate['name']) ? $affiliate['name'] : '');
}

echo "</td></tr><tr><td><img src='images/spacer.gif' height='1' width='30'></td>";
echo "<td colspan='1'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td><td><img src='images/spacer.gif' height='1' width='100%'></tr>";

// Mnemonic
echo "<tr><td width='30'>&nbsp;</td><td width='200'>".$strMnemonic."</td><td>";
if (phpAds_isUser(phpAds_Admin) || phpAds_isUser(phpAds_Agency)) {
    echo "<input onBlur='max_formValidateElement(this);' class='flat' type='text' name='mnemonic' size='35' style='width:350px;' dir='ltr' value='".phpAds_htmlQuotes($affiliate['mnemonic'])."' tabindex='".($tabindex++)."' maxlength='5'>";
} else {
    echo (isset($affiliate['mnemonic']) ? $affiliate['mnemonic'] : '');
}
echo "</td></tr><tr><td><img src='images/spacer.gif' height='1' width='30'></td>";
echo "<td colspan='1'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td><td><img src='images/spacer.gif' height='1' width='100%'></tr>";

// Website
echo "<tr><td width='30'>&nbsp;</td><td width='200'>".$strWebsite."</td><td>";
echo "<input onBlur='max_formValidateElement(this);' class='flat' type='text' name='website' size='35' style='width:350px;' dir='ltr' value='".phpAds_htmlQuotes($affiliate['website'])."' tabindex='".($tabindex++)."'>";
echo "</td></tr><tr><td><img src='images/spacer.gif' height='1' width='30'></td>";
echo "<td colspan='1'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td><td><img src='images/spacer.gif' height='1' width='100%'></tr>";

// Contact
echo "<tr><td width='30'>&nbsp;</td><td width='200'>".$strContact."</td><td>";
echo "<input onBlur='max_formValidateElement(this);' class='flat' type='text' name='contact' size='35' style='width:350px;' value='".phpAds_htmlQuotes($affiliate['contact'])."' tabindex='".($tabindex++)."'>";
echo "</td></tr><tr><td><img src='images/spacer.gif' height='1' width='30'></td>";
echo "<td colspan='1'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td><td><img src='images/spacer.gif' height='1' width='100%'></tr>";

// Email
echo "<tr><td width='30'>&nbsp;</td><td width='200'>".$strEMail."</td><td>";
echo "<input onBlur='max_formValidateElement(this);' class='flat' type='text' name='email' size='35' style='width:350px;' value='".phpAds_htmlQuotes($affiliate['email'])."' tabindex='".($tabindex++)."'>";
echo "</td></tr><tr><td><img src='images/spacer.gif' height='1' width='30'></td>";

if (!MAX_Permission::isAllowed(MAX_AffiliateIsReallyAffiliate)) {
    // Language
    echo "<td colspan='1'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td><td><img src='images/spacer.gif' height='1' width='100%'></tr>";
    echo "<tr><td width='30'>&nbsp;</td><td width='200'>".$strLanguage."</td><td>";
    echo "<select name='language' tabindex='".($tabindex++)."'>";
    echo "<option value='' SELECTED>".$strDefault."</option>\n";

    $languages = MAX_Admin_Languages::AvailableLanguages();
    while (list($k, $v) = each($languages)) {
        if (isset($affiliate['language']) && $affiliate['language'] == $k) {
            echo "<option value='$k' selected>$v</option>\n";
        } else {
            echo "<option value='$k'>$v</option>\n";
        }
    }

    echo "</select></td></tr><tr><td><img src='images/spacer.gif' height='1' width='30'></td>";
}

// Public?
if (phpAds_isUser(phpAds_Admin) || phpAds_isUser(phpAds_Agency)) {
    echo "<td colspan='1'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td><td><img src='images/spacer.gif' height='1' width='100%'></tr>";
    echo "<tr><td width='30'>&nbsp;</td><td colspan='2'>";
    echo "<input type='hidden' name='publiczones_old' value='".$affiliate['publiczones']."'>";
    echo "<input type='checkbox' name='publiczones' value='t'".($affiliate['publiczones'] == 't' ? ' CHECKED' : '')." tabindex='".($tabindex++)."'>&nbsp;";
    echo $strMakePublisherPublic;
    echo "</td></tr>";
}

echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";
echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
echo "</table>";

echo "<br /><br />";
echo "<br /><br />";

echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";
echo "<tr><td height='25' colspan='3'><b>".$strLoginInformation."</b></td></tr>";
echo "<tr height='1'><td width='30'><img src='images/break.gif' height='1' width='30'></td>";
echo "<td width='200'><img src='images/break.gif' height='1' width='200'></td>";
echo "<td width='100%'><img src='images/break.gif' height='1' width='100%'></td></tr>";
echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";

// Error message?
if (isset($errormessage) && count($errormessage)) {
    echo "<tr><td>&nbsp;</td><td height='10' colspan='2'>";
    echo "<table cellpadding='0' cellspacing='0' border='0'><tr><td>";
    echo "<img src='images/error.gif' align='absmiddle'>&nbsp;";

    while (list($k,$v) = each($errormessage)) {
        echo "<font color='#AA0000'><b>".$v."</b></font><br />";
    }

    echo "</td></tr></table></td></tr><tr><td height='10' colspan='3'>&nbsp;</td></tr>";
    echo "<tr><td><img src='images/spacer.gif' height='1' width='100%'></td>";
    echo "<td colspan='2'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td></tr>";
}

// Username
echo "<tr><td width='30'>&nbsp;</td><td width='200'>".$strUsername."</td>";

if (phpAds_isUser(phpAds_Admin) || phpAds_isUser(phpAds_Agency)) {
    echo "<td width='370'><input onBlur='max_formValidateElement(this);' class='flat' type='text' name='username' size='25' value='".phpAds_htmlQuotes($affiliate['username'])."' tabindex='".($tabindex++)."'></td>";
} else {
    echo "<td width='370'>".(isset($affiliate['username']) ? $affiliate['username'] : '');
}

echo "</tr><tr><td><img src='images/spacer.gif' height='1' width='30'></td>";
echo "<td colspan='1'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td><td><img src='images/spacer.gif' height='1' width='100%'></tr>";

// Password
if (phpAds_isUser(phpAds_Admin) || phpAds_isUser(phpAds_Agency)) {
    echo "<tr><td width='30'>&nbsp;</td><td width='200'>".$strPassword."</td>";
    echo "<td width='370'><input class='flat' type='password' name='password' size='25' value='".$affiliate['password']."' tabindex='".($tabindex++)."'>";
    echo "</td></tr>";
} else {
    echo "<tr><td width='30'>&nbsp;</td><td width='200'>".$strOldPassword."</td><td width='100%'>";
    echo "<input onBlur='max_formValidateElement(this);' class='flat' type='password' name='pwold' size='25' value='' tabindex='".($tabindex++)."'>";
    echo "</td></tr><tr><td><img src='images/spacer.gif' height='1' width='30'></td>";
    echo "<td colspan='1'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td><td><img src='images/spacer.gif' height='1' width='100%'></tr>";

    echo "<tr><td width='30'>&nbsp;</td><td width='200'>".$strNewPassword."</td><td width='100%'>";
    echo "<input onBlur='max_formValidateElement(this);' class='flat' type='password' name='pw' size='25' value='' tabindex='".($tabindex++)."'>";
    echo "</td></tr><tr><td><img src='images/spacer.gif' height='1' width='30'></td>";
    echo "<td colspan='1'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td><td><img src='images/spacer.gif' height='1' width='100%'></tr>";

    echo "<tr><td width='30'>&nbsp;</td><td width='200'>".$strRepeatPassword."</td><td width='100%'>";
    echo "<input onBlur='max_formValidateElement(this);' class='flat' type='password' name='pw2' size='25' value='' tabindex='".($tabindex++)."'>";
    echo "</td></tr>";
}

// Permissions
if (phpAds_isUser(phpAds_Admin) || phpAds_isUser(phpAds_Agency)) {
    echo "<tr><td><img src='images/spacer.gif' height='1' width='30'></td>";
    echo "<td colspan='1'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td><td><img src='images/spacer.gif' height='1' width='100%'></tr>";

    echo "<tr><td width='30'>&nbsp;</td><td width='200'>". 'Account type' ."</td>";
    echo "<td width='370'><select onchange='MMM_accountTypeChange()' name='account_type' tabindex='".($tabindex++)."'>";
    echo "<option value='publisher'".(MAX_AffiliateIsReallyAffiliate & $affiliate['permissions'] ? ' selected="selected"' : '').">". 'Publisher' ."</option>";
    echo "<option value='affiliate'".(MAX_AffiliateIsReallyAffiliate & $affiliate['permissions'] ? ' selected="selected"' : '').">". 'Affiliate' ."</option>";
    echo "</select>";
    echo "</td></tr>";
    echo "<tr><td><img src='images/spacer.gif' height='1' width='30'></td>";
    echo "<td colspan='1'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td><td><img src='images/spacer.gif' height='1' width='100%'></tr>";

    echo "<tr><td width='30'>&nbsp;</td><td colspan='2'>";
    echo "<input type='checkbox' name='affiliatepermissions[]' value='".phpAds_ModifyInfo."'".(phpAds_ModifyInfo & $affiliate['permissions'] ? ' CHECKED' : '')." tabindex='".($tabindex++)."'>&nbsp;";
    echo $strAllowAffiliateModifyInfo;
    echo "</td></tr>";

    echo "<tr><td width='30'>&nbsp;</td><td colspan='2'>";
    echo "<input onclick='MMM_cascadePermissionsChange()' id='affiliatepermissions_".phpAds_EditZone."' type='checkbox' name='affiliatepermissions[]' value='".phpAds_EditZone."'".(phpAds_EditZone & $affiliate['permissions'] ? ' CHECKED' : '')." tabindex='".($tabindex++)."'>&nbsp;";
    echo $strAllowAffiliateModifyZones;
    echo "</td></tr>";

    echo "<tr><td width='30'>&nbsp;</td><td colspan='2'>";
    echo "<img src='images/indent.gif'><input type='checkbox' id='affiliatepermissions_".phpAds_AddZone."' name='affiliatepermissions[]' value='".phpAds_AddZone."'".(phpAds_AddZone & $affiliate['permissions'] ? ' CHECKED' : '')." tabindex='".($tabindex++)."'>&nbsp;";
    echo $strAllowAffiliateAddZone;
    echo "</td></tr>";

    echo "<tr><td width='30'>&nbsp;</td><td colspan='2'>";
    echo "<img src='images/indent.gif'><input type='checkbox' id='affiliatepermissions_".phpAds_DeleteZone."' name='affiliatepermissions[]' value='".phpAds_DeleteZone."'".(phpAds_DeleteZone & $affiliate['permissions'] ? ' CHECKED' : '')." tabindex='".($tabindex++)."'>&nbsp;";
    echo $strAllowAffiliateDeleteZone;
    echo "</td></tr>";

    echo "<tr><td width='30'>&nbsp;</td><td colspan='2'>";
    echo "<input type='checkbox' name='affiliatepermissions[]' value='".phpAds_LinkBanners."'".(phpAds_LinkBanners & $affiliate['permissions'] ? ' CHECKED' : '')." tabindex='".($tabindex++)."'>&nbsp;";
    echo $strAllowAffiliateLinkBanners;
    echo "</td></tr>";

    echo "<tr><td width='30'>&nbsp;</td><td colspan='2'>";
    echo "<input type='checkbox' name='affiliatepermissions[]' value='".MAX_AffiliateGenerateCode."'".(MAX_AffiliateGenerateCode & $affiliate['permissions'] ? ' checked="checked"' : '')." tabindex='".($tabindex++)."'>&nbsp;";
    echo $strAllowAffiliateGenerateCode;
    echo "</td></tr>";

    echo "<tr><td width='30'>&nbsp;</td><td colspan='2'>";
    echo "<input type='checkbox' name='affiliatepermissions[]' value='".MAX_AffiliateViewZoneStats."'".(MAX_AffiliateViewZoneStats & $affiliate['permissions'] ? ' checked="checked"' : '')." tabindex='".($tabindex++)."'>&nbsp;";
    echo $strAllowAffiliateZoneStats;
    echo "</td></tr>";

    echo "<tr><td><img src='images/spacer.gif' height='1' width='30'></td>";
    echo "<td colspan='1'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td><td><img src='images/spacer.gif' height='1' width='100%'></tr>";

    echo "<tr><td width='30'>&nbsp;</td><td colspan='2'>";
    echo "<input type='checkbox' name='affiliatepermissions[]' value='".MAX_AffiliateViewOnlyApprPendConv."'".(MAX_AffiliateViewOnlyApprPendConv & $affiliate['permissions'] ? ' checked="checked"' : '')." tabindex='".($tabindex++)."'>&nbsp;";
    echo $strAllowAffiliateApprPendConv;
    echo "</td></tr>";
}

echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";
echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";
echo "</table>";

echo "<br><br>";

echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";
echo "<tr><td height='25' colspan='3'><b>".$strPaymentInformation."</b></td></tr>";
echo "<tr height='1'><td width='30'><img src='images/break.gif' height='1' width='30'></td>";
echo "<td width='200'><img src='images/break.gif' height='1' width='200'></td>";
echo "<td width='100%'><img src='images/break.gif' height='1' width='100%'></td></tr>";
echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";

// Address
echo "<tr><td width='30'>&nbsp;</td><td width='200'>".$strAddress."</td><td>";
echo "<textarea class='code' cols='45' rows='3' name='address' wrap='off' dir='ltr' style='width:350px;";
echo "' tabindex='".($tabindex++)."'>".phpAds_htmlQuotes($affiliate_extra['address'])."</textarea>";
echo "</td></tr><tr><td><img src='images/spacer.gif' height='1' width='30'></td>";
echo "<td colspan='1'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td><td><img src='images/spacer.gif' height='1' width='100%'></tr>";

// City
echo "<tr><td width='30'>&nbsp;</td><td width='200'>".$strCity."</td><td>";
echo "<input class='flat' type='text' name='city' size='35' style='width:350px;' dir='ltr' value='".phpAds_htmlQuotes($affiliate_extra['city'])."' tabindex='".($tabindex++)."'>";
echo "</td></tr><tr><td><img src='images/spacer.gif' height='1' width='30'></td>";
echo "<td colspan='1'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td><td><img src='images/spacer.gif' height='1' width='100%'></tr>";

// Postcode
echo "<tr><td width='30'>&nbsp;</td><td width='200'>".$strPostcode."</td><td>";
echo "<input class='flat' type='text' name='postcode' size='35' style='width:350px;' dir='ltr' value='".phpAds_htmlQuotes($affiliate_extra['postcode'])."' tabindex='".($tabindex++)."'>";
echo "</td></tr><tr><td><img src='images/spacer.gif' height='1' width='30'></td>";
echo "<td colspan='1'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td><td><img src='images/spacer.gif' height='1' width='100%'></tr>";

// Country
echo "<tr><td width='30'>&nbsp;</td><td width='200'>".$strCountry."</td><td>";
echo "<input class='flat' type='text' name='country' size='35' style='width:350px;' dir='ltr' value='".phpAds_htmlQuotes($affiliate_extra['country'])."' tabindex='".($tabindex++)."'>";
echo "</td></tr><tr><td><img src='images/spacer.gif' height='1' width='30'></td>";
echo "<td colspan='1'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td><td><img src='images/spacer.gif' height='1' width='100%'></tr>";

// Phone
echo "<tr><td width='30'>&nbsp;</td><td width='200'>".$strPhone."</td><td>";
echo "<input class='flat' type='text' name='phone' size='35' style='width:350px;' dir='ltr' value='".phpAds_htmlQuotes($affiliate_extra['phone'])."' tabindex='".($tabindex++)."'>";
echo "</td></tr><tr><td><img src='images/spacer.gif' height='1' width='30'></td>";
echo "<td colspan='1'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td><td><img src='images/spacer.gif' height='1' width='100%'></tr>";

// Fax
echo "<tr><td width='30'>&nbsp;</td><td width='200'>".$strFax."</td><td>";
echo "<input class='flat' type='text' name='fax' size='35' style='width:350px;' dir='ltr' value='".phpAds_htmlQuotes($affiliate_extra['fax'])."' tabindex='".($tabindex++)."'>";
echo "</td></tr><tr><td><img src='images/spacer.gif' height='1' width='30'></td>";
echo "<td colspan='1'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td><td><img src='images/spacer.gif' height='1' width='100%'></tr>";

// Account contact
echo "<tr><td width='30'>&nbsp;</td><td width='200'>".$strAccountContact."</td><td>";
echo "<input class='flat' type='text' name='account_contact' size='35' style='width:350px;' dir='ltr' value='".phpAds_htmlQuotes($affiliate_extra['account_contact'])."' tabindex='".($tabindex++)."'>";
echo "</td></tr><tr><td><img src='images/spacer.gif' height='1' width='30'></td>";
echo "<td colspan='1'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td><td><img src='images/spacer.gif' height='1' width='100%'></tr>";

// Payee name
echo "<tr><td width='30'>&nbsp;</td><td width='200'>".$strPayeeName."</td><td>";
echo "<input class='flat' type='text' name='payee_name' size='35' style='width:350px;' dir='ltr' value='".phpAds_htmlQuotes($affiliate_extra['payee_name'])."' tabindex='".($tabindex++)."'>";
echo "</td></tr><tr><td><img src='images/spacer.gif' height='1' width='30'></td>";
echo "<td colspan='1'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td><td><img src='images/spacer.gif' height='1' width='100%'></tr>";

// Tax ID
echo "<tr><td width='30'>&nbsp;</td><td width='200'>".$strTaxID."</td><td>";
echo "<input onClick='MMM_taxIdChange(this)' class='flat' type='radio' name='tax_id_present' id='tax_id_present_f' value='f' tabindex='".($tabindex++)."'".(empty($affiliate_extra['tax_id']) || (isset($affiliate['tax_id_present']) && $affiliate['tax_id_present'] != 't') ? ' checked' : '').">".$strNo."<br>";
echo "<input onClick='MMM_taxIdChange(this)' class='flat' type='radio' name='tax_id_present' id='tax_id_present_t' value='t' tabindex='".($tabindex++)."'".(!empty($affiliate_extra['tax_id']) || (isset($affiliate['tax_id_present']) && $affiliate['tax_id_present'] == 't') ? ' checked' : '').">".$strYes."&nbsp;&nbsp;";
echo "<input onBlur='max_formValidateElement(this);' class='flat' type='text' name='tax_id' size='25' dir='ltr' value='".phpAds_htmlQuotes($affiliate_extra['tax_id'])."' tabindex='".($tabindex++)."'>";
echo "</td></tr><tr><td><img src='images/spacer.gif' height='1' width='30'></td>";
echo "<td colspan='1'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td><td><img src='images/spacer.gif' height='1' width='100%'></tr>";

// Mode of payment
echo "<tr><td width='30'>&nbsp;</td><td width='200'>".$strModeOfPayment."</td><td>";
echo "<select type='text' name='mode_of_payment' dir='ltr' tabindex='".($tabindex++)."'>";
if (empty($pref['publisher_payment_modes'])) {
    $payment_modes = array($strPaymentChequeByPost);
} else {
    $payment_modes = explode(',', $pref['publisher_payment_modes']);
}
foreach ($payment_modes as $v) {
    echo "<option value='".htmlentities($v)."'".($affiliate_extra['mode_of_payment'] == $v ? ' selected' : '').">".htmlentities($v)."</option>";
}
echo "</select>";
echo "</td></tr><tr><td><img src='images/spacer.gif' height='1' width='30'></td>";
echo "<td colspan='1'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td><td><img src='images/spacer.gif' height='1' width='100%'></tr>";

// Currency
echo "<tr><td width='30'>&nbsp;</td><td width='200'>".$strCurrency."</td><td>";
echo "<select type='text' name='currency' dir='ltr' tabindex='".($tabindex++)."'>";
if (empty($pref['publisher_currencies'])) {
    $currencies = array($strCurrencyGBP);
} else {
    $currencies = explode(',', $pref['publisher_currencies']);
}
foreach ($currencies as $v) {
    echo "<option value='".htmlentities($v)."'".($affiliate_extra['currency'] == $v ? ' selected' : '').">".htmlentities($v)."</option>";
}
echo "</select>";
echo "</td></tr><tr><td><img src='images/spacer.gif' height='1' width='30'></td>";
echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";

echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
echo "</table>";

echo "<br><br>";

echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";
echo "<tr><td height='25' colspan='3'><b>".$strOtherInformation."</b></td></tr>";
echo "<tr height='1'><td width='30'><img src='images/break.gif' height='1' width='30'></td>";
echo "<td width='200'><img src='images/break.gif' height='1' width='200'></td>";
echo "<td width='100%'><img src='images/break.gif' height='1' width='100%'></td></tr>";

echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";

// Unique users
echo "<tr><td width='30'>&nbsp;</td><td width='200'>".$strUniqueUsersMonth."</td><td>";
echo "<input onBlur='max_formValidateElement(this);' class='flat' type='text' name='unique_users' size='25' dir='ltr' value='".phpAds_htmlQuotes($affiliate_extra['unique_users'])."' tabindex='".($tabindex++)."'>";
echo "</td></tr><tr><td><img src='images/spacer.gif' height='1' width='30'></td>";
echo "<td colspan='1'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td><td><img src='images/spacer.gif' height='1' width='100%'></tr>";

// Unique views
echo "<tr><td width='30'>&nbsp;</td><td width='200'>".$strUniqueViewsMonth."</td><td>";
echo "<input onBlur='max_formValidateElement(this);' class='flat' type='text' name='unique_views' size='25' dir='ltr' value='".phpAds_htmlQuotes($affiliate_extra['unique_views'])."' tabindex='".($tabindex++)."'>";
echo "</td></tr><tr><td><img src='images/spacer.gif' height='1' width='30'></td>";
echo "<td colspan='1'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td><td><img src='images/spacer.gif' height='1' width='100%'></tr>";

// Page rank
echo "<tr><td width='30'>&nbsp;</td><td width='200'>".$strPageRank."</td><td>";
echo "<input onBlur='max_formValidateElement(this);' class='flat' type='text' name='page_rank' size='25' dir='ltr' value='".phpAds_htmlQuotes($affiliate_extra['page_rank'])."' tabindex='".($tabindex++)."'>";
echo "</td></tr><tr><td><img src='images/spacer.gif' height='1' width='30'></td>";
echo "<td colspan='1'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td><td><img src='images/spacer.gif' height='1' width='100%'></tr>";

// Category
echo "<tr><td width='30'>&nbsp;</td><td width='200'>".$strCategory."</td><td>";
echo "<select type='text' name='category' style='width:350px;' dir='ltr' tabindex='".($tabindex++)."'>";
if (empty($pref['publisher_categories'])) {
    $categories = array();
} else {
    $categories = explode(',', $pref['publisher_categories']);
}
foreach ($categories as $v) {
    echo "<option value='".htmlentities($v)."'".($affiliate_extra['category'] == $v ? ' selected' : '').">".htmlentities($v)."</option>";
}
echo "</select>";
echo "</td></tr><tr><td><img src='images/spacer.gif' height='1' width='30'></td>";

if (phpAds_isUser(phpAds_Admin) || phpAds_isUser(phpAds_Agency)) {
    echo "<td colspan='1'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td><td><img src='images/spacer.gif' height='1' width='100%'></tr>";

    // Comments
    echo "<tr><td width='30'>&nbsp;</td>";
    echo "<td width='200'>".$strComments."</td>";

    echo "<td><textarea class='code' cols='45' rows='6' name='comments' wrap='off' dir='ltr' style='width:350px;";
    echo "' tabindex='".($tabindex++)."'>".htmlentities($affiliate['comments'])."</textarea>";
    echo "</td></tr><tr><td><img src='images/spacer.gif' height='1' width='30'></td>";
    echo "<td colspan='1'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td><td><img src='images/spacer.gif' height='1' width='100%'></tr>";

    // Help file
    echo "<tr><td width='30'>&nbsp;</td><td width='200'>".$strHelpFile."</td><td>";
    echo "<select type='text' name='help_file' style='width:350px;' dir='ltr' tabindex='".($tabindex++)."'>";
    if (empty($pref['publisher_help_files'])) {
        $help_files = array();
    } else {
        $help_files = explode(',', $pref['publisher_help_files']);
    }
    foreach ($help_files as $v) {
        echo "<option value='".htmlentities($v)."'".($affiliate_extra['help_file'] == $v ? ' selected' : '').">".htmlentities($v)."</option>";
    }
    echo "</select>";
    echo "</td></tr><tr><td><img src='images/spacer.gif' height='1' width='30'></td>";
    echo "<td colspan='1'><img src='images/break-l.gif' height='1' width='200' vspace='6'></td><td><img src='images/spacer.gif' height='1' width='100%'></tr>";

}

echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";
echo "<tr height='1'><td width='30'><img src='images/break.gif' height='1' width='30'></td>";
echo "<td width='200'><img src='images/break.gif' height='1' width='200'></td>";
echo "<td width='100%'><img src='images/break.gif' height='1' width='100%'></td></tr>";


echo "<tr><td height='10' colspan='3'>&nbsp;</td></tr>";
echo "</table>";

echo "<br /><br />";
echo "<input type='submit' name='submit' value='".(isset($affiliateid) && $affiliateid != '' ? $strSaveChanges : $strNext.' >')."' tabindex='".($tabindex++)."'>";
echo "</form>";

/*-------------------------------------------------------*/
/* Form requirements                                     */
/*-------------------------------------------------------*/

// Get unique affiliate
// XXX: Although the JS suggests otherwise, this unique_name constraint isn't enforced.
$doAffiliates = OA_Dal::factoryDO('affiliates');
$unique_names = $doAffiliates->getUniqueValuesFromColumn('name', $affiliate['name']);
$unique_users = MAX_Permission::getUniqueUserNames($affiliate['username']);

?>

<script language='JavaScript'>
<!--
    max_formSetRequirements('contact', '<?php echo addslashes($strContact); ?>', true);
    max_formSetRequirements('website', '<?php echo addslashes($strWebsite); ?>', true, 'url');
    max_formSetRequirements('email', '<?php echo addslashes($strEMail); ?>', true, 'email');

    max_formSetRequirements('tax_id', '<?php echo addslashes('Tax ID'); ?>', true);
    max_formSetRequirements('unique_users', '<?php echo addslashes('Unique users/month'); ?>', false, 'number*');
    max_formSetRequirements('unique_views', '<?php echo addslashes('Unique views/month'); ?>', false, 'number*');
    max_formSetRequirements('page_rank', '<?php echo addslashes('Page rank'); ?>', false, 'number*');

<?php if (phpAds_isUser(phpAds_Admin) || phpAds_isUser(phpAds_Agency)) { ?>
    max_formSetRequirements('name', '<?php echo addslashes($strName); ?>', true, 'unique');
    max_formSetRequirements('username', '<?php echo addslashes($strUsername); ?>', false, 'unique');

    max_formSetUnique('name', '|<?php echo addslashes(implode('|', $unique_names)); ?>|');
    max_formSetUnique('username', '|<?php echo addslashes(implode('|', $unique_users)); ?>|');

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

    function MMM_accountTypeChange()
    {
        var o = findObj('account_type');
        var e = document.getElementsByTagName('INPUT');
        var i;

        for (i = 0; i < e.length; i++) {
            if (e[i].name.match(/^affiliatepermissions/)) {
                if (e[i].value != <?php echo MAX_AffiliateViewOnlyApprPendConv; ?>) {
                    e[i].disabled = o.selectedIndex;
                }
            }
        }

        if (!o.selectedIndex) {
            MMM_cascadePermissionsChange();
        }
    }

    MMM_accountTypeChange();

<?php } ?>

    function MMM_taxIdChange(o)
    {
        var t = findObj('tax_id');

        if (t) {
            t.disabled = o.form.tax_id_present[0].checked;

            if (t.disabled) {
                max_formValidateElement(t);
            }
        }
    }

    MMM_taxIdChange(findObj('tax_id_present_f'));

//-->
</script>

<?php

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PageFooter();

?>
