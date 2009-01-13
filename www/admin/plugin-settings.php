<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
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
require_once MAX_PATH . '/lib/OA/Admin/TemplatePlugin.php';

require_once LIB_PATH . '/Plugin/ComponentGroupManager.php';

// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_ADMIN);

// Create a new option object for displaying the setting's page's HTML form
$oOptions = new OA_Admin_Option('settings');

// Prepare an array for storing error messages
$aErrormessage = array();

$group   = $_REQUEST['group'];
$plugin = $_REQUEST['plugin'];

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
    foreach ($aConfig['settings'] as $k => $v)
    {
        if (0 == strcmp($v['type'], 'checkbox'))
        {
            $aItemSettings = array($group => $v['key'], 'bool' => 'true');
        }
        else
        {
            $aItemSettings = array($group => $v['key']);
        }
        
        $aElements += array($group.'_'.$v['key'] => $aItemSettings);

        // Register the HTML element value
        MAX_commonRegisterGlobalsArray(array($group.'_'.$v['key']));
    }

    $valid = true;
    $validationFile = MAX_PATH.$GLOBALS['_MAX']['CONF']['pluginPaths']['packages'].$group.'/processSettings.php';
    if (file_exists($validationFile))
    {
        $className = $group.'_processSettings';
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
        $aErrormessage = null;
        // Create a new settings object, and save the settings!
        $oSettings = new OA_Admin_Settings();
        $result = $oSettings->processSettingsFromForm($aElements);
        if ($result)
        {
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
$aSettings[0]['text'] = $group.' '.$strConfigurationSettings;

$count = count($aConfig['settings']);
$i = 0;
foreach ($aConfig['settings'] as $k => $v)
{
    $aSettings[0]['items'][] = array(
                                     'type'    => $v['type'],
                                     'name'    => $group.'_'.$v['key'],
                                     'text'    => $v['label'],
                                     'req'     => $v['required'],
                                     'size'    => $v['size'],
                                     'value'   => $v['value'],
                                     'visible' => $v['visible'],
                                     );
    //add break after a field excluding last
    $i++;
    if ($i < $count) {
        $aSettings[0]['items'][] = array (
                    'type'    => 'break'
                );
    }
}


$aSettings[0]['items'][] = array(
                                 'type'    => 'hiddenfield',
                                 'name'    => 'group',
                                 'value'   => $group,
                                 );
$aSettings[0]['items'][] = array(
                                 'type'    => 'hiddenfield',
                                 'name'    => 'plugin',
                                 'value'   => $plugin,
                                 );


/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PageHeader("plugin-index");

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


?>