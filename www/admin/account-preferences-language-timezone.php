<?php

/*
+---------------------------------------------------------------------------+
| Openads v${RELEASE_MAJOR_MINOR}                                           |
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
$Id: settings-admin.php 12637 2007-11-20 19:02:36Z miguel.correa@openads.org $
*/

/**
 * Obtain the server timezone information *before* the init script is
 * called, to ensure that the timezone information from the server is
 * not affected by any calls to date_default_timezone_set() or
 * putenv("TZ=...") to set the timezone manually.
 */
require_once '../../lib/OA/Admin/Timezones.php';
$aTimezone = OA_Admin_Timezones::getTimezone();

// Require the initialisation file
require_once '../../init.php';

// Required files
require_once MAX_PATH . '/lib/max/Admin/Languages.php';
require_once MAX_PATH . '/lib/OA/Admin/Preferences.php';
require_once MAX_PATH . '/lib/max/Admin/Redirect.php';
require_once MAX_PATH . '/lib/OA/Admin/Option.php';

$oOptions = new OA_Admin_Option('preferences');

// Security check
MAX_Permission::checkAccess(phpAds_Admin);

$aErrormessage = array();
if (isset($_POST['submitok']) && $_POST['submitok'] == 'true') {
    // Register input variables
    phpAds_registerGlobalUnslashed('language', 'timezone_location');

    // Set up the config object
    $oConfig = new OA_Admin_Settings();

    //  Update config with timezone changes
    if (isset($timezone_location)) {
        $timezone_location = OA_Admin_Timezones::getConfigTimezoneValue($timezone_location, $aTimezone);
        $oConfig->settingChange('timezone', 'location', $timezone_location);
    }

    if (!$oConfig->writeConfigChange()) {
        // Unable to write the config file out
        $aErrormessage[0][] = $strUnableToWriteConfig;
    }

    // Set up the preferences object
    $oPreferences = new OA_Admin_Preferences();
    if (isset($language)) {
        $oPreferences->setPrefChange('language', $language);
    }

    if (!count($aErrormessage)) {
        if (!$oPreferences->writePrefChange()) {
            // Unable to update the preferences
            $aErrormessage[0][] = $strUnableToWritePrefs;
        } else {
            MAX_Admin_Redirect::redirect('account-preferences-tracker.php');
        }
    }

}

if (isset($message)) {
    phpAds_ShowMessage($message);
}
phpAds_PageHeader("5.1");
phpAds_ShowSections(array("5.1", "5.2", "5.4", "5.5", "5.3", "5.6", "5.7"));
$oOptions->selection("language-timezone");

$aUnique_users   = MAX_Permission::getUniqueUserNames($pref['admin']);

$aTimezones = OA_Admin_Timezones::availableTimezones(true);
$oConfigTimezone = trim($GLOBALS['_MAX']['CONF']['timezone']['location']);
if (empty($oConfigTimezone)) {
    // There is no value stored in the configuration file, as it
    // is not required (ie. the TZ comes from the environment) -
    // so set that environment value in the config file now
    $GLOBALS['_MAX']['CONF']['timezone']['location'] = $aTimezone['tz'];
}
// What display string do we need to show for the timezone?
if (empty($oConfigTimezone) && $aTimezone['calculated']) {
    $strTimezoneToDisplay = $strTimezoneEstimated . '<br />' . $strTimezoneGuessedValue;
} else {
    $strTimezoneToDisplay = $strTimezone;
}

$aSettings = array (
    array (
        'text'  => $strLanguageTimezone,
        'items' => array (
            array (
                'type'    => 'select',
                'name'    => 'language',
                'text'    => $strLanguage,
                'items'   => MAX_Admin_Languages::AvailableLanguages()
            ),
            array (
                'type'    => 'break'
            ),
            array (
                'type'    => 'select',
                'name'    => 'timezone_location',
                'text'    => $strTimezoneToDisplay,
                'items'   => $aTimezones
            ),
            array (
                'type'    => 'break'
            ),
        )
    )
);

$oOptions->show($aSettings, $aErrormessage);
phpAds_PageFooter();

?>