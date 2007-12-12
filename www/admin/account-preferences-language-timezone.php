<?php

/*
+---------------------------------------------------------------------------+
| Openads v${RELEASE_MAJOR_MINOR}                                                              |
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

// Obtain the server timezone information *before* the init script is
// called, to ensure that the timezone information from the server is
// not affected by any calls to date_default_timezone_set() or
// putenv("TZ=...") to set the timezone manually
require_once '../../lib/OA/Admin/Timezones.php';
$aTimezone = OA_Admin_Timezones::getTimezone();

// Require the initialisation file
require_once '../../init.php';

// Required files
require_once MAX_PATH . '/lib/OA/Admin/Option.php';
require_once MAX_PATH . '/lib/OA/Admin/Preferences.php';

require_once MAX_PATH . '/lib/max/Admin/Redirect.php';
require_once MAX_PATH . '/lib/max/Plugin/Translation.php';
require_once MAX_PATH . '/www/admin/config.php';

// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER, OA_ACCOUNT_TRAFFICKER, OA_ACCOUNT_ADVERTISER);

// Create a new option object for displaying the setting's page's HTML form
$oOptions = new OA_Admin_Option('preferences');

// Prepare an array for storing error messages
$aErrormessage = array();

// If the settings page is a submission, deal with the form data























// Required files
require_once MAX_PATH . '/lib/max/Admin/Languages.php';

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

// Display the settings page's header and sections
phpAds_PageHeader("5.1");
if (OA_Permission::isAccount(OA_ACCOUNT_ADMIN)) {
    // Show all "My Account" sections
    phpAds_ShowSections(array("5.1", "5.2", "5.4", "5.5", "5.3"));
} else if (OA_Permission::isAccount(OA_ACCOUNT_MANAGER)) {
    // Show the "Preferences", "User Log" and "Channel Management" sections of the "My Account" sections
    phpAds_ShowSections(array("5.1", "5.3", "5.7"));
} else if (OA_Permission::isAccount(OA_ACCOUNT_TRAFFICKER)) {
    // Show the "Preferences" section of the "My Account" sections
    phpAds_ShowSections(array("5.1"));
} else if (OA_Permission::isAccount(OA_ACCOUNT_ADVERTISER)) {
    // Show the "Preferences" section of the "My Account" sections
    phpAds_ShowSections(array("5.1"));
}

$oOptions->selection("language-timezone");

$aUnique_users   = OA_Permission::getUniqueUserNames($pref['admin']);

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

// Display the page footer
phpAds_PageFooter();

?>