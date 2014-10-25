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
require_once LIB_PATH . '/Plugin/ComponentGroupManager.php';


// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER, OA_ACCOUNT_ADVERTISER, OA_ACCOUNT_TRAFFICKER);

phpAds_registerGlobal('group');

// Load the account's preferences, with additional information, into a specially named array
$GLOBALS['_MAX']['PREF_EXTRA'] = OA_Preferences::loadPreferences(true, true);

// Create a new option object for displaying the setting's page's HTML form
$oOptions = new OA_Admin_Option('preferences');

// Prepare an array for storing error messages
$aErrormessage = array();

$oComponentGroupManager  = new OX_Plugin_ComponentGroupManager();
$aGroup     = $oComponentGroupManager->_getComponentGroupConfiguration($group);
$enabled    = $GLOBALS['_MAX']['CONF']['pluginGroupComponents'][$group];
$disabled   = ((!$enabled) && (OA_Permission::getAccountType()!=OA_ACCOUNT_ADMIN));

// If the settings page is a submission, deal with the form data
if (isset($_POST['submitok']) && $_POST['submitok'] == 'true') {
    // Prepare an array of the HTML elements to process, and which
    // of the preferences are checkboxes
    $aElements = array();
    foreach ($aGroup['preferences'] as $k => $v)
    {
        $aElements[] = $group.'_'.$v['name'];

        // Register the HTML element value
        MAX_commonRegisterGlobalsArray(array($group.'_'.$v['name']));
    }
    $aCheckboxes = array();

    // Validation
    $valid = true;
    $validationFile = MAX_PATH.$GLOBALS['_MAX']['CONF']['pluginPaths']['packages'].$group.'/processPreferences.php';
    if (file_exists($validationFile))
    {
        $className = $group.'_processPreferences';
        include($validationFile);
        if (class_exists($className))
        {
            $oPlugin = new $className;
            if (method_exists($oPlugin, 'validate'))
            {
                $aErrormessage = array();
                $valid = $oPlugin->validate($aErrormessage);
            }
        }
    }

    if ($valid) {
        // Create a new settings object, and save the settings!
        $result = OA_Preferences::processPreferencesFromForm($aElements, $aCheckboxes);
        if ($result)
        {
            // Queue confirmation message
            $title = $group . ' ' . $GLOBALS['strPluginPreferences'];
            $translation = new OX_Translation ();
            $translated_message = $translation->translate($GLOBALS['strXPreferencesHaveBeenUpdated'],
            array(htmlspecialchars($title)));
            OA_Admin_UI::queueMessage($translated_message, 'local', 'confirm', 0);

            OX_Admin_Redirect::redirect('account-preferences-plugin.php?group='.$group);
        }
        // Could not write the settings configuration file, store this
        // error message and continue
        $aErrormessage[0][] = $strUnableToWritePrefs;
    }
}

// Display the preference page's header and sections
phpAds_PageHeader("account-preferences-index");

// Set the correct section of the preference pages and display the drop-down menu
$oOptions->selection($group);

// Prepare an array of HTML elements to display for the form, and
// output using the $oOption object
foreach ($aGroup['preferences'] as $k => $v)
{
    $aPreferences[0]['text'] = $group.($disabled ? ' - the Administrator has disabled this plugin, you may only change preferences when it is enabled.' : '');
    $aPreferences[0]['items'][] = array(
                                         'type'    => $v['type'],
                                         'name'    => $group.'_'.$v['name'],
                                         'text'    => $v['label'],
                                         'req'     => $v['required'],
                                         'size'    => $v['size'],
                                         'value'   => $v['value'],
                                         'visible' => $v['visible'],
                                         'disabled'=> $disabled,
                                         );
}
$aPreferences[0]['items'][] = array(
                                     'type'    => 'hiddenfield',
                                     'name'    => 'group',
                                     'value'   => $group,
                                     );

$oOptions->show($aPreferences, $aErrormessage);

// Display the page footer
phpAds_PageFooter();

?>