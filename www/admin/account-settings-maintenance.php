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

require_once LIB_PATH . '/OperationInterval.php';

// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_ADMIN);

// Create a new option object for displaying the setting's page's HTML form
$oOptions = new OA_Admin_Option('settings');
$prefSection = "maintenance";

// Prepare an array for storing error messages
$aErrormessage = array();

// If the settings page is a submission, deal with the form data
if (isset($_POST['submitok']) && $_POST['submitok'] == 'true') {
    // Prepare an array of the HTML elements to process, and the
    // location to save the values in the settings configuration
    // file
    $aElements = array();
    // Maintenance Settings
    $aElements += array(
        'maintenance_autoMaintenance' => array(
            'maintenance' => 'autoMaintenance',
            'bool'        => true
        ),
        'maintenance_operationInterval' => array('maintenance' => 'operationInterval')
    );
    // Priority Settings
    $aElements += array(
        'priority_instantUpdate' => array(
            'priority' => 'instantUpdate',
            'bool'     => true
        ),
        'priority_intentionalOverdelivery' => array('priority' => 'intentionalOverdelivery')
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
        'text'  => $strMaintenanceSettings,
        'items' => array (
            array (
                'type'    => 'checkbox',
                'name'    => 'maintenance_autoMaintenance',
                'text'	  => $strEnableAutoMaintenance
            ),
            array (
                'type'    => 'break'
            ),
            array (
                'type'    => 'select',
                'name'    => 'maintenance_operationInterval',
                'text'    => $strMaintenanceOI,
                'size'    => 12,
                'items'   =>  array(
                    60 => 60,
                    30 => 30,
                    20 => 20,
                    15 => 15,
                    10 => 10,
                    5 => 5
                )
            )
        )
    ),
    array (
        'text'  => $strPrioritySettings,
        'items' => array (
            array (
                'type'    => 'checkbox',
                'name'    => 'priority_instantUpdate',
                'text'    => $strPriorityInstantUpdate
            ),
            array (
                'type'    => 'break'
            ),
            array (
                'type'    => 'text',
                'name'    => 'priority_intentionalOverdelivery',
                'text'    => $strPriorityIntentionalOverdelivery,
                'check'   => 'wholeNumber'
            ),
        )
    )
);
$oOptions->show($aSettings, $aErrormessage);

// Display the page footer
phpAds_PageFooter();

?>
