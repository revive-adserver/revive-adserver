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
require_once MAX_PATH . '/lib/OA/Admin/TemplatePlugin.php';

require_once LIB_PATH . '/Plugin/ComponentGroupManager.php';

// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_ADMIN);

// Create a new option object for displaying the setting's page's HTML form
$oOptions = new OA_Admin_Option('settings');

// Prepare an array for storing error messages
$aErrormessage = [];

$pattern = '/[^a-zA-Z0-9\._-]/';
$group = preg_replace($pattern, '', $_REQUEST['group']);
$plugin = preg_replace($pattern, '', $_REQUEST['plugin']);

if ($plugin) {
    $backURL = "plugin-index.php?action=info&package=$plugin";
} else {
    $backURL = "plugin-index.php?selection=plugins";
}

// get the settings for this plugin
$oManager = new OX_Plugin_ComponentGroupManager();
$aComponentSettings = $oManager->getComponentGroupSettings($group, true);

// If the settings page is a submission, deal with the form data
if (isset($_POST['submitok']) && $_POST['submitok'] == 'true') {
    // Prepare an array of the HTML elements to process, and the
    // location to save the values in the settings configuration
    // file
    $aElements = [];
    foreach ($aComponentSettings as $k => $v) {
        if (0 == strcmp($v['type'], 'checkbox')) {
            $aItemSettings = [$group => $v['key'], 'bool' => 'true'];
        } else {
            $aItemSettings = [$group => $v['key']];
        }

        $aElements += [$group . '_' . $v['key'] => $aItemSettings];

        // Register the HTML element value
        MAX_commonRegisterGlobalsArray([$group . '_' . $v['key']]);
    }

    $valid = true;
    $validationFile = MAX_PATH . $GLOBALS['_MAX']['CONF']['pluginPaths']['packages'] . $group . '/processSettings.php';
    if (file_exists($validationFile)) {
        $className = $group . '_processSettings';
        include($validationFile);
        if (class_exists($className)) {
            $oPlugin = new $className();
            if (method_exists($oPlugin, 'validate')) {
                $aErrormessage = [];
                $valid = $oPlugin->validate($aErrormessage);
            }
        }
    }

    if ($valid) {
        $aErrormessage = null;
        // Create a new settings object, and save the settings!
        $oSettings = new OA_Admin_Settings();
        $result = $oSettings->processSettingsFromForm($aElements);
        if ($result) {
            // Queue confirmation message
            $title = $group . ' ' . $GLOBALS['strPluginSettings'];
            $translation = new OX_Translation();
            $translated_message = $translation->translate(
                $GLOBALS['strXPreferencesHaveBeenUpdated'],
                [htmlspecialchars($title)]
            );
            OA_Admin_UI::queueMessage($translated_message, 'local', 'confirm', 0);

            // The settings configuration file was written correctly,
            // go back to the plugins main page from here
            require_once LIB_PATH . '/Admin/Redirect.php';
            OX_Admin_Redirect::redirect($backURL);
        }
        // Could not write the settings configuration file, store this
        // error message and continue
        $aErrormessage[0][] = $strUnableToWriteConfig;
    }
}
// Set the correct section of the settings pages and display the drop-down menu
//$oOptions->selection('email');

// Prepare an array of HTML elements to display for the form, and
// output using the $oOption object
$aSettings[0]['text'] = $group . ' ' . $strConfigurationSettings;

$oTrans = new OX_Translation($GLOBALS['_MAX']['CONF']['pluginPaths']['packages'] . $group . '/_lang');

$count = count($aComponentSettings);
$i = 0;
foreach ($aComponentSettings as $k => $v) {
    $aSettings[0]['items'][] = [
                                     'type' => $v['type'],
                                     'name' => $group . '_' . $v['key'],
                                     'text' => $oTrans->translate($v['label']),
                                     'req' => $v['required'],
                                     'size' => $v['size'],
                                     'value' => $v['value'],
                                     'visible' => $v['visible'],
                                     ];
    //add break after a field excluding last
    $i++;
    if ($i < $count) {
        $aSettings[0]['items'][] = [
                    'type' => 'break'
                ];
    }
}


$aSettings[0]['items'][] = [
                                 'type' => 'hiddenfield',
                                 'name' => 'group',
                                 'value' => $group,
                                 ];
$aSettings[0]['items'][] = [
                                 'type' => 'hiddenfield',
                                 'name' => 'plugin',
                                 'value' => $plugin,
                                 ];


/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PageHeader("plugin-index", new OA_Admin_UI_Model_PageHeaderModel($GLOBALS['strPluginSettings']), '', false, true);

/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/
//display back link
$oTpl = new OA_Admin_Template('plugin-group-settings.html');
$oTpl->assign('backURL', MAX::constructURL(MAX_URL_ADMIN, $backURL));
$oTpl->assign('plugin', $plugin);
$oTpl->assign('group', $group);
$oTpl->display();

//display options form
$oOptions->show($aSettings, $aErrormessage);

phpAds_PageFooter();
