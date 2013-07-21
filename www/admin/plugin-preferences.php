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
$oOptions = new OA_Admin_Option('preferences');

// Prepare an array for storing error messages
$aErrormessage = array();

$pattern = '/[^a-zA-Z0-9\._-]/';
$plugin   = preg_replace($pattern, '', $_REQUEST['parent']);
$group    = preg_replace($pattern, '', $_REQUEST['group']);
$parent   = preg_replace($pattern, '', $_REQUEST['parent']);

if ($plugin) {
    $backURL =  "plugin-index.php?action=info&package=$plugin";
}
else {
    $backURL = "plugin-index.php?selection=plugins";
}

// get the settings for this plugin
$oManager   = & new OX_Plugin_ComponentGroupManager();
$aConfig    = $oManager->_getComponentGroupConfiguration($group);

// If the settings page is a submission, deal with the form data
if (isset($_POST['submitok']) && $_POST['submitok'] == 'true')
{
    // Prepare an array of the HTML elements to process, and the
    // location to save the values in the settings configuration
    // file
    $aElements = array();
    foreach ($aConfig['preferences'] as $k => $v)
    {
        $aElements[] = $group.'_'.$v['key'];
        // Register the HTML element value
        MAX_commonRegisterGlobalsArray(array($group.'_'.$v['key']));
    }
    $aCheckboxes = array();

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

    if ($valid)
    {
        // Create a new preferences object, and save the preferences!
        $result = OA_Preferences::processPreferencesFromForm($aElements, $aCheckboxes);
        if ($result)
        {
            // Queue confirmation message
            $title = $group . ' ' . $GLOBALS['strPluginPreferences'];
            $translation = new OX_Translation ();
            $translated_message = $translation->translate($GLOBALS['strXPreferencesHaveBeenUpdated'],
            array(htmlspecialchars($title)));
            OA_Admin_UI::queueMessage($translated_message, 'local', 'confirm', 0);

            // The settings configuration file was written correctly,
            // go back to the plugins main page from here
            OX_Admin_Redirect::redirect($backURL);
        }
        // Could not write the settings configuration file, store this
        // error message and continue
        $aErrormessage[0][] = $strUnableToWritePrefs;
    }
}
// Set the correct section of the settings pages and display the drop-down menu
//$oOptions->selection('email');

// Prepare an array of HTML elements to display for the form, and
// output using the $oOption object
$aPreferences[0]['text'] = $group.' '.$strPreferences;
$count = count($aConfig['preferences']);
$i = 0;
foreach ($aConfig['preferences'] as $k => $v)
{
    $aPreferences[0]['items'][] = array(
                                         'type'    => $v['type'],
                                         'name'    => $group.'_'.$v['name'],
                                         'text'    => $v['label'],
                                         'req'     => $v['required'],
                                         'size'    => $v['size'],
                                         'value'   => $v['value'],
                                         'visible' => $v['visible'],
                                         );
    //add break after a field excluding last
    $i++;
    if ($i < $count) {
        $aPreferences[0]['items'][] = array (
                    'type'    => 'break'
                );
    }
}


$aPreferences[0]['items'][] = array(
                                     'type'    => 'hiddenfield',
                                     'name'    => 'plugin',
                                     'value'   => $plugin,
                                     );
$aPreferences[0]['items'][] = array(
                                 'type'    => 'hiddenfield',
                                 'name'    => 'group',
                                 'value'   => $group,
                                 );


$GLOBALS['_MAX']['PREF_EXTRA'] = OA_Preferences::loadPreferences(true, true);
/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PageHeader("plugin-index", new OA_Admin_UI_Model_PageHeaderModel($GLOBALS['strPluginPreferences']), '', false, true);

/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/
//display back link
$oTpl = new OA_Admin_Template('plugin-group-preferences.html');
$oTpl->assign('backURL', MAX::constructURL(MAX_URL_ADMIN, $backURL));
$oTpl->assign('plugin', $plugin);
$oTpl->assign('group', $group);
$oTpl->display();

//display options form
$oOptions->show($aPreferences, $aErrormessage);

phpAds_PageFooter();


?>