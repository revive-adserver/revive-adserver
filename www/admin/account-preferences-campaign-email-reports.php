<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
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
require_once MAX_PATH . '/lib/OA/Preferences.php';

require_once MAX_PATH . '/lib/max/Admin/Redirect.php';
require_once MAX_PATH . '/lib/max/Plugin/Translation.php';
require_once MAX_PATH . '/www/admin/config.php';

// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER, OA_ACCOUNT_TRAFFICKER, OA_ACCOUNT_ADVERTISER);

// Load the account's preferences, with additional information, into a specially named array
$GLOBALS['_MAX']['PREF_EXTRA'] = OA_Preferences::loadPreferences(true, true);

// Create a new option object for displaying the setting's page's HTML form
$oOptions = new OA_Admin_Option('preferences');

// Prepare an array for storing error messages
$aErrormessage = array();

// If the settings page is a submission, deal with the form data
if (isset($_POST['submitok']) && $_POST['submitok'] == 'true') {
    // Prepare an array of the HTML elements to process, and which
    // of the preferences are checkboxes
    $aElements   = array();
    $aCheckboxes = array();
    // Administrator email Warnings
    $aElements[] = 'warn_email_admin';
    $aCheckboxes['warn_email_admin'] = true;
    $aElements[] = 'warn_email_admin_impression_limit';
    $aElements[] = 'warn_email_admin_day_limit';
    // Manager email Warnings
    $aElements[] = 'warn_email_manager';
    $aCheckboxes['warn_email_manager'] = true;
    $aElements[] = 'warn_email_manager_impression_limit';
    $aElements[] = 'warn_email_manager_day_limit';
    // Advertiser email Warnings
    $aElements[] = 'warn_email_advertiser';
    $aCheckboxes['warn_email_advertiser'] = true;
    $aElements[] = 'warn_email_advertiser_impression_limit';
    $aElements[] = 'warn_email_advertiser_day_limit';
    // Save the preferences
    $result = OA_Preferences::processPreferencesFromForm($aElements, $aCheckboxes);
    if ($result) {
        // The preferences were written correctly saved to the database,
        // go to the "next" preferences page from here
        MAX_Admin_Redirect::redirect('account-preferences-language-timezone.php');
    }
    // Could not write the preferences to the database, store this
    // error message and continue
    $aErrormessage[0][] = $strUnableToWritePrefs;
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
$oOptions->selection("campaign-email-reports");

// Prepare an array of HTML elements to display for the form, and
// output using the $oOption object
$aSettings = array (
    array (
        'text'  => $strAdminEmailWarnings,
        'items' => array (
            array (
                'type'    => 'checkbox',
                'name'    => 'warn_email_admin',
                'text'    => $strWarnAdmin
            ),
            array (
                'type'    => 'break'
            ),
            array (
                'type'    => 'text',
                'name'    => 'warn_email_admin_impression_limit',
                'text'    => $strWarnLimit,
                'size'    => 12,
                'depends' => 'warn_email_admin==true',
                'req'     => true,
                'check'   => 'number+'
            ),
            array (
                'type'    => 'break'
            ),
            array (
                'type'    => 'text',
                'name'    => 'warn_email_admin_day_limit',
                'text'    => $strWarnLimitDays,
                'size'    => 12,
                'depends' => 'warn_email_admin==true',
                'req'     => true,
                'check'   => 'number+'
            ),
        )
     ),
     array (
        'text'  => $strAgencyEmailWarnings,
        'items' => array (
            array (
                'type'    => 'checkbox',
                'name'    => 'warn_email_manager',
                'text'    => $strWarnAgency
            ),
            array (
                'type'    => 'break'
            ),
            array (
                'type'    => 'text',
                'name'    => 'warn_email_manager_impression_limit',
                'text'    => $strWarnLimit,
                'size'    => 12,
                'depends' => 'warn_email_manager==true',
                'req'     => true,
                'check'   => 'number+'
            ),
            array (
                'type'    => 'break'
            ),
            array (
                'type'    => 'text',
                'name'    => 'warn_email_manager_day_limit',
                'text'    => $strWarnLimitDays,
                'size'    => 12,
                'depends' => 'warn_email_manager==true',
                'req'     => true,
                'check'   => 'number+'
            ),
        )
     ),
     array (
        'text'  => $strAdveEmailWarnings,
        'items' => array (
            array (
                'type'    => 'checkbox',
                'name'    => 'warn_email_advertiser',
                'text'    => $strWarnClient
            ),
            array (
                'type'    => 'break'
            ),
            array (
                'type'    => 'text',
                'name'    => 'warn_email_advertiser_impression_limit',
                'text'    => $strWarnLimit,
                'size'    => 12,
                'depends' => 'warn_email_advertiser==true',
                'req'     => true,
                'check'   => 'number+'
            ),
            array (
                'type'    => 'break'
            ),
            array (
                'type'    => 'text',
                'name'    => 'warn_email_advertiser_day_limit',
                'text'    => $strWarnLimitDays,
                'size'    => 12,
                'depends' => 'warn_email_advertiser==true',
                'req'     => true,
                'check'   => 'number+'
            )
        )
    )
);
$oOptions->show($aSettings, $aErrormessage);

// Display the page footer
phpAds_PageFooter();

?>