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
require_once MAX_PATH . '/lib/OA/Admin/Settings.php';

require_once MAX_PATH . '/lib/max/Plugin/Translation.php';
require_once MAX_PATH . '/www/admin/config.php';


// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_ADMIN);

// Create a new option object for displaying the setting's page's HTML form
$oOptions = new OA_Admin_Option('settings');
$prefSection = "upgrade-privacy";

// Prepare an array for storing error messages
$aErrormessage = array();

// If the settings page is a submission, deal with the form data
if (isset($_POST['submitok']) && $_POST['submitok'] == 'true') {
    // Prepare an array of the HTML elements to process, and the
    // location to save the values in the settings configuration
    // file
    $aElements = array();
    // Synchronisation Settings
    $aElements += array(
        'sync_checkForUpdates' => array(
            'sync' => 'checkForUpdates',
            'bool'    => true
        ),
        'sync_shareStack' => array(
            'sync' => 'shareStack',
            'bool' => true
        ),
        'sync_shareData' => array(
            'sync' => 'shareData',
            'bool' => true
        )
    );
    // Create a new settings object, and save the settings!
    $oSettings = new OA_Admin_Settings();
    $result = $oSettings->processSettingsFromForm($aElements);
    if ($result) {
        // Rebuild the menu because if the Check for Updates setting has been changed
        // the Dashboard has to be disable for managers
    	OA_Admin_Menu::_clearCache(OA_ACCOUNT_MANAGER);
        // Queue confirmation message
        $setPref = $oOptions->getSettingsPreferences($prefSection);
        $title = $setPref[$prefSection]['name'];
        $translation = new OX_Translation ();
        $translated_message = $translation->translate($GLOBALS['strXSettingsHaveBeenUpdated'],
            array(htmlspecialchars($title)));
        OA_Admin_UI::queueMessage($translated_message, 'local', 'confirm', 0);
         // The settings configuration file was written correctly,
        OX_Admin_Redirect::redirect(basename($_SERVER['PHP_SELF']));
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
        'text'    => $strSyncSettings,
        'items'   => array (
            array (
                'type'    => 'checkbox',
                'name'    => 'sync_checkForUpdates',
                'text'    => $strAdminCheckUpdates
            )
        )
    ),
    array (
        'text'    => $strPrivacySettings,
        'items'   => array (
            array (
                'type'    => 'checkbox',
                'name'    => 'sync_shareStack',
                'text'    => $strAdminShareStack,
                'depends' => 'sync_checkForUpdates==1',
                'desc'    => $strAdminShareStackDesc
            ),
            array (
                'type'    => 'checkbox',
                'name'    => 'sync_shareData',
                'text'    => $strAdminShareData,
                'depends' => 'sync_checkForUpdates==1',
                'desc'    => $strAdminShareDataDesc
            )
        )
    )
);
$oOptions->show($aSettings, $aErrormessage);

// Display the page footer
phpAds_PageFooter();

?>
