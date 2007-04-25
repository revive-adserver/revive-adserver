<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
| For contact details, see: http://www.openads.org/                         |
|                                                                           |
| Copyright (c) 2000-2003 the phpAdsNew developers                          |
| For contact details, see: http://www.phpadsnew.com/                       |
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
require_once MAX_PATH . '/lib/max/Admin/Redirect.php';
require_once MAX_PATH . '/www/admin/lib-settings.inc.php';

require_once MAX_PATH . '/lib/max/Plugin.php';
$invocationTags = MAX_Plugin::getPlugins('invocationTags');
$invocationSettings = MAX_Plugin::callOnPlugins($invocationTags, 'getPreferenceCode');
foreach($invocationSettings as $invocationSettingKey => $invocationSettingVal) {
    if(empty($invocationSettingVal)) {
        unset($invocationSettings[$invocationSettingKey]);
    }
}

// Security check
phpAds_checkAccess(phpAds_Admin + phpAds_Agency);

$errormessage = array();
if (isset($_POST['submitok']) && $_POST['submitok'] == 'true') {

    // Set up the preferences object
    $preferences = new MAX_Admin_Preferences();
    foreach($invocationSettings as $invocationCode) {
    	$preferences->setPrefChange($invocationCode, isset($_POST[$invocationCode]));
    }
    $preferences->setPrefChange('gui_invocation_3rdparty_default', $_POST['gui_invocation_3rdparty_default']);

    if (!$preferences->writePrefChange()) {
        // Unable to update the preferences
        $errormessage[0][] = $strUnableToWritePrefs;
    } else {
        if (phpAds_isUser(phpAds_Admin)) {
            MAX_Admin_Redirect::redirect('settings-stats.php');
        } else {
            MAX_Admin_Redirect::redirect('settings-interface.php');
        }
    }
}

phpAds_PrepareHelp();
phpAds_PageHeader("5.1");
if (phpAds_isUser(phpAds_Admin)) {
	phpAds_ShowSections(array("5.1", "5.3", "5.4", "5.2", "5.5", "5.6"));
} elseif (phpAds_isUser(phpAds_Agency)) {
    phpAds_ShowSections(array("5.1", "5.3", "5.2"));
}
phpAds_SettingsSelection("invocation");

include_once MAX_PATH . '/lib/max/Plugin/Translation.php';

$settings = array(
    array(
        'text'  => $GLOBALS['strAllowedInvocationTypes'],
        'items' => array(),
    ),
);

foreach($invocationSettings as $pluginKey => $invocationCode) {
    if ($invocationTags[$pluginKey] === false) {
        continue;
    }
    $settings[0]['items'][] = array(
        'type' => 'checkbox',
        'name' => $invocationCode,
        'text' => $invocationTags[$pluginKey]->getAllowInvocationTypeForSettings(),
    );
}

// sort invocationSettings by settings text
function MAX_sortSetting($a, $b)
{
   return strcmp($a['text'], $b['text']);
}
usort($settings[0]['items'], 'MAX_sortSetting');

$settings[1]['text'] = $GLOBALS['strIncovationDefaults'];

$outputAdServers = &MAX_Plugin::getPlugins('3rdPartyServers');
foreach ($outputAdServers as $pluginKey => $outputAdServer) {
    if ($outputAdServer->hasOutputMacros) {
        $availableOutputAdServers[$pluginKey] = $outputAdServer;
        $availableOutputAdServerNames[$pluginKey] = $outputAdServer->getName();
    }
}
asort($availableOutputAdServerNames);
$availableOutputAdServerNames = $availableOutputAdServerNames = array(
    0 => $GLOBALS['strNo'],
    'generic' => $GLOBALS['strGenericOutputAdServer']
) + $availableOutputAdServerNames;

$settings[1]['items'][] = array(
    'type'  => 'select',
    'name'  => 'gui_invocation_3rdparty_default',
    'text'  => $GLOBALS['strEnable3rdPartyTrackingByDefault'],
    'items' => $availableOutputAdServerNames,
);

phpAds_ShowSettings($settings, $errormessage);
phpAds_PageFooter();

?>
