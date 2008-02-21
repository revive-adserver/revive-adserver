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

require_once MAX_PATH . '/lib/max/Admin/Redirect.php';
require_once MAX_PATH . '/lib/max/Plugin/Translation.php';
require_once MAX_PATH . '/www/admin/config.php';

// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_ADMIN);

// Create a new option object for displaying the setting's page's HTML form
$oOptions = new OA_Admin_Option('settings');

// Prepare an array for storing error messages
$aErrormessage = array();

// If the settings page is a submission, deal with the form data
if (isset($_POST['submitok']) && $_POST['submitok'] == 'true') {
    // Store the current status of conversion tracking
    $logging_trackerImpressionsCurrent = $GLOBALS['_MAX']['CONF']['logging']['trackerImpressions'];
    // Prepare an array of the HTML elements to process, and the
    // location to save the values in the settings configuration
    // file
    $aElements = array();
    // Conversion Tracking Settings
    $aElements += array(
        'logging_trackerImpressions' => array(
            'logging' => 'trackerImpressions',
            'bool'    => true
        ),
        'logging_defaultImpressionConnectionWindow' => array('logging' => 'defaultImpressionConnectionWindow'),
        'logging_defaultClickConnectionWindow'      => array('logging' => 'defaultClickConnectionWindow'),
    );
    // Create a new settings object, and save the settings!
    $oSettings = new OA_Admin_Settings();
    $result = $oSettings->processSettingsFromForm($aElements);
    if ($result) {
        // Test to see if conversion tracking has been turned on or off
        global $logging_trackerImpressions;
        if ($logging_trackerImpressions && !$logging_trackerImpressionsCurrent) {
            // Conversion tracking has been turned on, need to update
            // account preferences to display the "Conversions" column
            // in statisitics screens
            $aStatisticsFieldsDeliveryPlugins = &MAX_Plugin::getPlugins('statisticsFieldsDelivery');
            foreach ($aStatisticsFieldsDeliveryPlugins as $oPlugin) {
                // Get the column preference name for "Sum Conversions"
                $columnName = $oPlugin->getSumConversionsColumnPreferenceName();
                if (!is_null($columnName)) {
                    break;
                }
            }
            if (!is_null($columnName)) {
                // Obtain the preference ID value for the column
                $doPreferences = OA_Dal::factoryDO('preferences');
                $doPreferences->preference_name = $columnName;
                $doPreferences->find();
                if ($doPreferences->getRowCount() == 1) {
                    $doPreferences->fetch();
                    $aColumnPreference = $doPreferences->toArray();
                    $columnPreferenceId = $aColumnPreference['preference_id'];
                    // Update any instances of this preference ID so that
                    // the column is enabled, but without making any other
                    // changes to custom rank values or column names
                    $doAccount_preference_assoc = OA_Dal::factoryDO('account_preference_assoc');
                    $doAccount_preference_assoc->preference_id = $columnPreferenceId;
                    $doAccount_preference_assoc->find();
                    while ($doAccount_preference_assoc->fetch()) {
                        $doAccount_preference_assoc->value = 1;
                        $doAccount_preference_assoc->update();
                    }
                }
            }
        } else if (!$logging_trackerImpressions && $logging_trackerImpressionsCurrent) {
            // Conversion tracking has been turned off, need to update
            // account preferences to not display any of the conversion
            // tracking columns in statistics screens
            $aStatisticsFieldsDeliveryPlugins = &MAX_Plugin::getPlugins('statisticsFieldsDelivery');
            foreach ($aStatisticsFieldsDeliveryPlugins as $oPlugin) {
                // Get all of the column preference names that relate to
                // conversion tracking
                $aPrefs = $oPlugin->getConversionColumnPreferenceNames();
                // Disable these preferences
                OA_Preferences::disableStatisticsColumns($aPrefs);
            }
        }
        // The settings configuration file was written correctly,
        // go to the "next" settings page from here
        MAX_Admin_Redirect::redirect('account-settings-database.php');
    }
    // Could not write the settings configuration file, store this
    // error message and continue
    $aErrormessage[0][] = $strUnableToWriteConfig;
}

// Display the settings page's header and sections
phpAds_PageHeader("5.2");
phpAds_ShowSections(array("5.1", "5.2", "5.4", "5.5", "5.3"));

// Set the correct section of the settings pages and display the drop-down menu
$oOptions->selection("tracking");

// Prepare an array of HTML elements to display for the form, and
// output using the $oOption object
$aSettings = array (
    array (
        'text'  => $strConversionTracking,
        'items' => array (
            array (
                'type'    => 'hiddencheckbox',
                'name'    => 'logging_adImpressions'
            ),
            array (
                'type'    => 'hiddencheckbox',
                'name'    => 'logging_adClicks'
            ),
            array (
                'type'    => 'checkbox',
                'name'    => 'logging_trackerImpressions',
                'text'    => $strEnableConversionTracking
            ),
            array (
                'type'    => 'break'
            ),
            array (
                'type'    => 'text',
                'name'    => 'logging_defaultImpressionConnectionWindow',
                'text'    => $strDefaultImpConWindow,
                'size'    => 12,
                'depends' => 'logging_trackerImpressions==1 && logging_adImpressions==1',
                'check'   => 'number+'
            ),
            array (
                'type'    => 'break'
            ),
            array (
                'type'    => 'text',
                'name'    => 'logging_defaultClickConnectionWindow',
                'text'    => $strDefaultCliConWindow,
                'size'    => 12,
                'depends' => 'logging_trackerImpressions==1 && logging_adClicks==1',
                'check'   => 'number+'
            )
        )
    )
);
$oOptions->show($aSettings, $aErrormessage);

// Display the page footer
phpAds_PageFooter();

?>