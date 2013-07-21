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
require_once MAX_PATH . '/lib/OA/Admin/Settings.php';

require_once MAX_PATH . '/lib/max/Plugin/Translation.php';
require_once MAX_PATH . '/www/admin/config.php';


// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_ADMIN);

// Create a new option object for displaying the setting's page's HTML form
$oOptions = new OA_Admin_Option('settings');
$prefSection = "email";

// Prepare an array for storing error messages
$aErrormessage = array();

// If the settings page is a submission, deal with the form data
if (isset($_POST['submitok']) && $_POST['submitok'] == 'true') {
    // Prepare an array of the HTML elements to process, and the
    // location to save the values in the settings configuration
    // file
    $aElements = array();
    // E-mail Addresses
    $aElements += array(
        'email_fromAddress'       => array('email' => 'fromAddress'),
        'email_fromName'          => array('email' => 'fromName'),
        'email_fromCompany'       => array('email' => 'fromCompany'),
        'email_useManagerDetails' => array('email' => 'useManagerDetails',
                                           'bool'  => true
                                          )
    );
    // E-mail Log
    $aElements += array(
        'email_logOutgoing' => array(
            'email' => 'logOutgoing',
            'bool'  => true
        )
    );
    // E-mail Headers
    $aElements += array(
        'email_headers' => array(
            'email'        => 'headers',
            'preg_match'   => "/\r?\n/",
            'preg_replace' => '\\r\\n'
        )
    );
    // qmail Patch
    $aElements += array(
        'email_qmailPatch' => array(
            'email' => 'qmailPatch',
            'bool'  => true
        )
    );
    // Create a new settings object, and save the settings!
    $oSettings = new OA_Admin_Settings();
    $result = $oSettings->processSettingsFromForm($aElements);
    if ($result) {
            // Queue confirmation message
            $setPref = $oOptions->getSettingsPreferences($prefSection);
            $title = $setPref[$prefSection]['name'];
            $translation = new OX_Translation ();
            $translated_message = $translation->translate($GLOBALS['strXSettingsHaveBeenUpdated'],
                array(htmlspecialchars($title)));
            OA_Admin_UI::queueMessage($translated_message, 'local', 'confirm', 0);
             // The settings configuration file was written correctly,
            OX_Admin_Redirect::redirect(basename($_SERVER['SCRIPT_NAME']));
            }
    // Could not write the settings configuration file, store this
    // error message and continue
    $aErrormessage[0][] = $strUnableToWriteConfig;
}

// Set the correct section of the settings pages and display the drop-down menu
$setPref = $oOptions->getSettingsPreferences($prefSection);
$title = $setPref[$prefSection]['name'];

// Display the settings page's header and sections
$oHeaderModel = new OA_Admin_UI_Model_PageHeaderModel($title);
phpAds_PageHeader('account-settings-index', $oHeaderModel);


// Prepare an array of HTML elements to display for the form, and
// output using the $oOption object
$aSettings = array (
    array (
       'text'  => $strEmailAddresses,
       'items' => array (
            array (
                'type'    => 'text',
                'name'    => 'email_fromAddress',
                'text'    => $strEmailFromAddress,
                'req'     => true,
                'size'    => 35,
                'check'   => 'email'
            ),
            array (
                'type'    => 'break'
            ),
            array (
                'type'    => 'text',
                'name'    => 'email_fromName',
                'text'    => $strEmailFromName,
                'req'     => false,
                'size'    => 35
            ),
            array (
                'type'    => 'break'
            ),
            array (
                'type'    => 'text',
                'name'    => 'email_fromCompany',
                'text'    => $strEmailFromCompany,
                'req'     => false,
                'size'    => 35,
            ),
            array (
                'type'    => 'break'
            ),
            array (
                'type'    => 'checkbox',
                'name'    => 'email_useManagerDetails',
                'text'    => $strUseManagerDetails,
            )
        )
    ),
    array (
       'text'  => $strEmailLog,
       'items' => array (
            array (
                'type'    => 'checkbox',
                'name'    => 'email_logOutgoing',
                'text'    => $strUserlogEmail
            )
        )
    ),
    array (
       'text'  => $strEmailHeader,
       'items' => array (
            array (
               'type'     => 'textarea',
               'name'     => 'email_headers',
               'text'     => $strAdminEmailHeaders
            )
        )
    ),
        array (
        'text'  => $strQmailPatch,
        'items' => array (
            array (
                'type'    => 'checkbox',
                'name'    => 'email_qmailPatch',
                'text'    => $strEnableQmailPatch
            )
        )
    )
);
$oOptions->show($aSettings, $aErrormessage);

// Display the page footer
phpAds_PageFooter();

?>