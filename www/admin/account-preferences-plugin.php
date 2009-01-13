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

$oComponentGroupManager  = & new OX_Plugin_ComponentGroupManager();
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
    }
    $aCheckboxes = array();

    // Create a new settings object, and save the settings!
    $result = OA_Preferences::processPreferencesFromForm($aElements, $aCheckboxes);
    if ($result)
    {
        OX_Admin_Redirect::redirect('account-preferences-plugin.php?group='.$group);
    }
    // Could not write the settings configuration file, store this
    // error message and continue
    $aErrormessage[0][] = $strUnableToWritePrefs;
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