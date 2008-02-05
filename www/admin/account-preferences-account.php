<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                              |
| ============                                                              |
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
require_once MAX_PATH . '/lib/OA/Admin/Option.php';
require_once MAX_PATH . '/lib/OA/Admin/UI/UserAccess.php';

require_once MAX_PATH . '/lib/max/Admin/Languages.php';
require_once MAX_PATH . '/lib/max/Admin/Redirect.php';
require_once MAX_PATH . '/lib/max/Plugin/Translation.php';
require_once MAX_PATH . '/www/admin/config.php';

// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER, OA_ACCOUNT_ADVERTISER, OA_ACCOUNT_TRAFFICKER);

// Get the DB_DataObject for the current user
$doUsers = OA_Dal::factoryDO('users');
$doUsers->get(OA_Permission::getUserId());

// Create a new option object for displaying the setting's page's HTML form
$oOptions = new OA_Admin_Option('preferences');

// Prepare an array for storing error messages
$aErrormessage = array();

// If the settings page is a submission, deal with the form data
if (isset($_POST['submitok']) && $_POST['submitok'] == 'true') {
    // Register input variables
    phpAds_registerGlobalUnslashed(
        'login',
        'pwold',
        'pw',
        'pw2',
        'contact_name',
        'email_address',
        'company_name'
    );
    if (isset($login)) {
        if (!strlen($login)) {
            $aErrormessage[0][] = $strInvalidUsername;
        } elseif (!OA_Permission::isUsernameAllowed($login, $doUsers->username)) {
            $aErrormessage[0][] = $strDuplicateClientName;
        } else {
            $doUsers->username = $login;
        }
    }
    if (isset($pwold) && strlen($pwold) || isset($pw) && strlen($pw) || isset($pw2) && strlen($pw2)) {
        if (md5($pwold) != $doUsers->password) {
            $aErrormessage[0][] = $strPasswordWrong;
        } elseif (!strlen($pw)  || strstr("\\", $pw)) {
            $aErrormessage[0][] = $strInvalidPassword;
        } elseif (strcmp($pw, $pw2)) {
            $aErrormessage[0][] = $strNotSamePasswords;
        } else {
            $doUsers->password = md5($pw);
        }
    }
    if (isset($contact_name)) {
        $doUsers->contact_name = $contact_name;
    }
    if (isset($email_address)) {
        $doUsers->email_address = $email_address;
    }
    if (!count($aErrormessage)) {
        if ($doUsers->update() === false) {
            // Unable to update the preferences
            $aErrormessage[0][] = $strUnableToWritePrefs;
        } else {
            // Add the current username to the session, in case it
            // has changed
            $oUser = &OA_Permission::getCurrentUser();
            $oUser->aUser['username'] = $login;
            phpAds_SessionDataStore();
            // The "preferences" were written correctly saved to the database,
            // go to the "next" preferences page from here
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

// Set the correct section of the preference pages and display the drop-down menu
$oOptions->selection("account");

// Prepare an array of HTML elements to display for the form, and
// output using the $oOption object
$aSettings = array (
    array (
        'text'  => $strLoginCredentials,
        'items' => array (
            array (
                'type'    => 'text',
                'name'    => 'login',
                'value'   => $doUsers->username,
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
                'name'    => 'contact_name',
                'value'   => $doUsers->contact_name,
                'text'    => $strFullName,
                'size'    => 35
            ),
            array (
                'type'    => 'break'
            ),
            array (
                'type'    => 'text',
                'name'    => 'email_address',
                'value'   => $doUsers->email_address,
                'text'    => $strEmailAddress,
                'size'    => 35,
                'check'   => 'email'
            )
        )
    )
);
$oOptions->show($aSettings, $aErrormessage);

// Display the page footer
phpAds_PageFooter();

?>
