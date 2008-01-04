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
require_once MAX_PATH . '/lib/OA/Admin/Option.php';
require_once MAX_PATH . '/lib/OA/Admin/Preferences.php';

require_once MAX_PATH . '/lib/max/Admin/Redirect.php';
require_once MAX_PATH . '/lib/max/Plugin/Translation.php';
require_once MAX_PATH . '/www/admin/config.php';

// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER, OA_ACCOUNT_ADVERTISER, OA_ACCOUNT_TRAFFICKER);

// Create a new option object for displaying the setting's page's HTML form
$oOptions = new OA_Admin_Option('preferences');

// Prepare an array for storing error messages
$aErrormessage = array();

// If the settings page is a submission, deal with the form data










// Required files
require_once MAX_PATH . '/lib/max/Admin/Languages.php';


if (isset($_POST['submitok']) && $_POST['submitok'] == 'true') {
    // Register input variables
    phpAds_registerGlobalUnslashed('admin', 'pwold', 'pw', 'pw2', 'admin_fullname', 'admin_email',
                                   'company_name');

    // Set up the preferences object
    $oPreferences = new OA_Admin_Preferences();
    if (isset($admin)) {
        if (!strlen($admin)) {
            $aErrormessage[0][] = $strInvalidUsername;
        } elseif (!OA_Permission::isUsernameAllowed($pref['admin'], $admin)) {
            $aErrormessage[0][] = $strDuplicateClientName;
        } else {
            $oPreferences->setPrefChange('admin', $admin);
        }
    }
    if (isset($pwold) && strlen($pwold) || isset($pw) && strlen($pw) || isset($pw2) && strlen($pw2)) {
        $pref = $GLOBALS['_MAX']['PREF'];
        if (md5($pwold) != $pref['admin_pw']) {
            $aErrormessage[0][] = $strPasswordWrong;
        } elseif (!strlen($pw)  || strstr("\\", $pw)) {
            $aErrormessage[0][] = $strInvalidPassword;
        } elseif (strcmp($pw, $pw2)) {
            $aErrormessage[0][] = $strNotSamePasswords;
        } else {
            $admin_pw = $pw;
            $oPreferences->setPrefChange('admin_pw', md5($admin_pw));
        }
    }
    if (isset($admin_fullname)) {
        $oPreferences->setPrefChange('admin_fullname', $admin_fullname);
    }
    if (isset($admin_email)) {
        $oPreferences->setPrefChange('admin_email', $admin_email);
    }
    if (isset($company_name)) {
        $oPreferences->setPrefChange('company_name', $company_name);
    }

    if (!count($aErrormessage)) {
        if (!$oPreferences->writePrefChange()) {
            // Unable to update the preferences
            $aErrormessage[0][] = $strUnableToWritePrefs;
        } else {
            MAX_Admin_Redirect::redirect('account-preferences-banner.php');
        }
    }

}

// Display the settings page's header and sections
phpAds_PageHeader("5.1");
if (OA_Permission::isAccount(OA_ACCOUNT_ADMIN)) {
    // Show all "My Account" sections
    phpAds_ShowSections(array("5.1", "5.2", "5.4", "5.5", "5.3"));
} else if (OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
    // Show the "Preferences", "User Log" and "Channel Management" sections of the "My Account" sections
    phpAds_ShowSections(array("5.1", "5.3", "5.7"));
} else if (OA_Permission::isAccount(OA_ACCOUNT_TRAFFICKER)) {
    // Show the "Preferences" section of the "My Account" sections
    phpAds_ShowSections(array("5.1"));
} else if (OA_Permission::isAccount(OA_ACCOUNT_ADVERTISER)) {
    // Show the "Preferences" section of the "My Account" sections
    phpAds_ShowSections(array("5.1"));
}



$oOptions->selection("account");


$aSettings = array (
    array (
        'text'  => $strLoginCredentials,
        'items' => array (
            array (
                'type'    => 'text',
                'name'    => 'admin',
                'text'    => $strUsername,
                'check'   => 'unique',
                'unique'  => $unique_users
            ),
            array (
                'type'    => 'break'
            ),
            array (
                'type'    => 'password',
                'name'    => 'pwold',
                'text'    => $strOldPassword
            ),
            array (
                'type'    => 'break'
            ),
            array (
                'type'    => 'password',
                'name'    => 'pw',
                'text'    => $strNewPassword,
                'depends' => 'pwold!=""'
            ),
            array (
                'type'    => 'break'
            ),
            array (
                'type'    => 'password',
                'name'    => 'pw2',
                'text'    => $strRepeatPassword,
                'depends' => 'pwold!=""',
                'check'   => 'compare:pw'
            )
        )
    ),
    array (
        'text'  => $strUserDetails,
        'items' => array (
            array (
                'type'    => 'text',
                'name'    => 'admin_fullname',
                'text'    => $strFullName,
                'size'    => 35
            ),
            array (
                'type'    => 'break'
            ),
            array (
                'type'    => 'text',
                'name'    => 'admin_email',
                'text'    => $strEmailAddress,
                'size'    => 35,
                'check'   => 'email'
            ),
            array (
                'type'    => 'break'
            ),
            array (
                'type'    => 'text',
                'name'    => 'company_name',
                'text'    => $strCompanyName,
                'size'    => 35
            )
        )
    )
);
$oOptions->show($aSettings, $aErrormessage);

// Display the page footer
phpAds_PageFooter();

?>