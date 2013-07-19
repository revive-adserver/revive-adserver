<?php

/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
*/

// Require the initialisation file
require_once '../../init.php';

// Required files
require_once MAX_PATH . '/lib/OA/Admin/Option.php';
require_once MAX_PATH . '/lib/OA/Preferences.php';

require_once MAX_PATH . '/lib/max/Plugin/Translation.php';
require_once MAX_PATH . '/www/admin/config.php';


// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER, OA_ACCOUNT_TRAFFICKER, OA_ACCOUNT_ADVERTISER);

// Load the account's preferences, with additional information, into a specially named array
$GLOBALS['_MAX']['PREF_EXTRA'] = OA_Preferences::loadPreferences(true, true);

// Create a new option object for displaying the setting's page's HTML form
$oOptions = new OA_Admin_Option('preferences');
$prefSection = "campaign-email-reports";

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
        // Queue confirmation message
        $setPref = $oOptions->getSettingsPreferences($prefSection);
        $title = $setPref[$prefSection]['name'];
        $translation = new OX_Translation ();
        $translated_message = $translation->translate($GLOBALS['strXPreferencesHaveBeenUpdated'],
            array(htmlspecialchars($title)));
        OA_Admin_UI::queueMessage($translated_message, 'local', 'confirm', 0);

        OX_Admin_Redirect::redirect(basename($_SERVER['SCRIPT_NAME']));
    }
    // Could not write the preferences to the database, store this
    // error message and continue
    $aErrormessage[0][] = $strUnableToWritePrefs;
}

// Set the correct section of the preference pages and display the drop-down menu
$setPref = $oOptions->getSettingsPreferences($prefSection);
$title = $setPref[$prefSection]['name'];

// Display the settings page's header and sections
$oHeaderModel = new OA_Admin_UI_Model_PageHeaderModel($title);
phpAds_PageHeader('account-preferences-index', $oHeaderModel);


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
                'check'   => 'wholeNumber'
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
                'check'   => 'wholeNumber'
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
                'check'   => 'wholeNumber'
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
                'check'   => 'wholeNumber'
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
                'check'   => 'wholeNumber'
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
                'check'   => 'wholeNumber'
            )
        )
    )
);
$oOptions->show($aSettings, $aErrormessage);

// Display the page footer
phpAds_PageFooter();

?>