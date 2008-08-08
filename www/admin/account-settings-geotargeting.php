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

require_once MAX_PATH . '/lib/max/Admin/Geotargeting.php';
require_once MAX_PATH . '/lib/max/Plugin/Translation.php';
require_once MAX_PATH . '/www/admin/config.php';

require_once LIB_PATH . '/Admin/Redirect.php';

// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_ADMIN);

// Create a new option object for displaying the setting's page's HTML form
$oOptions = new OA_Admin_Option('settings');

// Prepare an array for storing error messages
$aErrormessage = array();

// If the settings page is a submission, deal with the form data
if (isset($_POST['submitok']) && $_POST['submitok'] == 'true') {
    // Prepare an array of the HTML elements to process, and the
    // location to save the values in the settings configuration
    // file
    $aElements = array();
    // Geotargeting Settings
    $aElements += array(
        'geotargeting_type' => array('geotargeting' => 'type'),
        'geotargeting_saveStats' => array(
            'geotargeting' => 'saveStats',
            'bool'         => true
        ),
        'geotargeting_showUnavailable' => array(
            'geotargeting' => 'showUnavailable',
            'bool'         => true
        )
    );
    // Create a new settings object, and save the settings!
    $oSettings = new OA_Admin_Settings();
    $result = $oSettings->processSettingsFromForm($aElements);
    if ($result) {
        // Write out the plugin settings configuration file(s)
        phpAds_registerGlobal(
            'geotargeting_type'
        );
        if ($geotargeting_type != 'none') {
            $oSettings = new OA_Admin_Settings();
            phpAds_registerGlobal(
                'geotargeting_geoipCountryLocation',
                'geotargeting_geoipRegionLocation',
                'geotargeting_geoipCityLocation',
                'geotargeting_geoipAreaLocation',
                'geotargeting_geoipDmaLocation',
                'geotargeting_geoipOrgLocation',
                'geotargeting_geoipIspLocation',
                'geotargeting_geoipNetspeedLocation'
            );
            if (isset($geotargeting_geoipCountryLocation) && ($geotargeting_geoipCountryLocation != '')) {
                if (is_readable($geotargeting_geoipCountryLocation)) {
                    $oSettings->settingChange('geotargeting', 'geoipCountryLocation', $geotargeting_geoipCountryLocation);
                } else {
                    $aErrormessage[0][] = $strGeotrackingGeoipCountryLocationError;
                }
            } else {
                $oSettings->settingChange('geotargeting', 'geoipCountryLocation', '');
            }
            if (isset($geotargeting_geoipRegionLocation) && ($geotargeting_geoipRegionLocation != '')) {
                if (is_readable($geotargeting_geoipRegionLocation)) {
                    $oSettings->settingChange('geotargeting', 'geoipRegionLocation', $geotargeting_geoipRegionLocation);
                } else {
                    $aErrormessage[0][] = $strGeotrackingGeoipRegionLocationError;
                }
            } else {
                $oSettings->settingChange('geotargeting', 'geoipRegionLocation', '');
            }
            if (isset($geotargeting_geoipCityLocation) && ($geotargeting_geoipCityLocation != '')) {
                if (is_readable($geotargeting_geoipCityLocation)) {
                    $oSettings->settingChange('geotargeting', 'geoipCityLocation', $geotargeting_geoipCityLocation);
                } else {
                    $aErrormessage[0][] = $strGeotrackingGeoipCityLocationError;
                }
            } else {
                $oSettings->settingChange('geotargeting', 'geoipCityLocation', '');
            }
            if (isset($geotargeting_geoipAreaLocation) && ($geotargeting_geoipAreaLocation != '')) {
                if (is_readable($geotargeting_geoipAreaLocation)) {
                    $oSettings->settingChange('geotargeting', 'geoipAreaLocation', $geotargeting_geoipAreaLocation);
                } else {
                    $aErrormessage[0][] = $strGeotrackingGeoipAreaLocationError;
                }
            } else {
                $oSettings->settingChange('geotargeting', 'geoipAreaLocation', '');
            }
            if (isset($geotargeting_geoipDmaLocation) && ($geotargeting_geoipDmaLocation != '')) {
                if (is_readable($geotargeting_geoipDmaLocation)) {
                    $oSettings->settingChange('geotargeting', 'geoipDmaLocation', $geotargeting_geoipDmaLocation);
                } else {
                    $aErrormessage[0][] = $strGeotrackingGeoipDmaLocationError;
                }
            } else {
                $oSettings->settingChange('geotargeting', 'geoipDmaLocation', '');
            }
            if (isset($geotargeting_geoipOrgLocation) && ($geotargeting_geoipOrgLocation != '')) {
                if (is_readable($geotargeting_geoipOrgLocation)) {
                    $oSettings->settingChange('geotargeting', 'geoipOrgLocation', $geotargeting_geoipOrgLocation);
                } else {
                    $aErrormessage[0][] = $strGeotrackingGeoipOrgLocationError;
                }
            } else {
                $oSettings->settingChange('geotargeting', 'geoipOrgLocation', '');
            }
            if (isset($geotargeting_geoipIspLocation) && ($geotargeting_geoipIspLocation != '')) {
                if (is_readable($geotargeting_geoipIspLocation)) {
                    $oSettings->settingChange('geotargeting', 'geoipIspLocation', $geotargeting_geoipIspLocation);
                } else {
                    $aErrormessage[0][] = $strGeotrackingGeoipIspLocationError;
                }
            } else {
                $oSettings->settingChange('geotargeting', 'geoipIspLocation', '');
            }
            if (isset($geotargeting_geoipNetspeedLocation) && ($geotargeting_geoipNetspeedLocation != '')) {
                if (is_readable($geotargeting_geoipNetspeedLocation)) {
                    $oSettings->settingChange('geotargeting', 'geoipNetspeedLocation', $geotargeting_geoipNetspeedLocation);
                } else {
                    $aErrormessage[0][] = $strGeotrackingGeoipNetspeedLocationError;
                }
            } else {
                $oSettings->settingChange('geotargeting', 'geoipNetspeedLocation', '');
            }

        }
        if (!count($aErrormessage)) {
            $oConfigFileName = MAX_Plugin::getConfigFileName('geotargeting', $geotargeting_type);
            if (!file_exists($oConfigFileName)) {
                MAX_Plugin::copyDefaultConfig('geotargeting', $geotargeting_type);
            }
            if ($geotargeting_type != 'none' && !$oSettings->writeConfigChange()) {
                // Unable to write the config file out
                $aErrormessage[0][] = $strUnableToWriteConfig;
            } else {
                // The settings configuration files were written correctly,
                // go to the "next" settings page from here
                OX_Admin_Redirect::redirect('account-settings-maintenance.php');
            }
        }
    } else {
        // Could not write the settings configuration file, store this
        // error message and continue
        $aErrormessage[0][] = $strUnableToWriteConfig;
    }
}

// Display the settings page's header and sections
phpAds_PageHeader('account-settings-index');

// Set the correct section of the settings pages and display the drop-down menu
$oOptions->selection("geotargeting");

// Prepare an array of HTML elements to display for the form, and
// output using the $oOption object
$aSettings = array (
    array (
        'text'  => $strGeotargeting,
        'items' => array (
            array (
                'type'    => 'select',
                'name'    => 'geotargeting_type',
                'text'    => $strGeotargetingType,
                'items'   => MAX_Admin_Geotargeting::AvailableGeotargetingModes()
            ),
            array (
                'type'    => 'break'
            ),
            array (
                'type'    => 'text',
                'name'    => 'geotargeting_geoipCountryLocation',
                'text'    => $strGeotargetingGeoipCountryLocation,
                'size'    => 35,
                'depends' => 'geotargeting_type==1'
            ),
            array (
                'type'    => 'break'
            ),
            array (
                'type'    => 'text',
                'name'    => 'geotargeting_geoipRegionLocation',
                'text'    => $strGeotargetingGeoipRegionLocation,
                'size'    => 35,
                'depends' => 'geotargeting_type==1'
            ),
            array (
                'type'    => 'break'
            ),
            array (
                'type'    => 'text',
                'name'    => 'geotargeting_geoipCityLocation',
                'text'    => $strGeotargetingGeoipCityLocation,
                'size'    => 35,
                'depends' => 'geotargeting_type==1'
            ),
            array (
                'type'    => 'break'
            ),
            array (
                'type'    => 'text',
                'name'    => 'geotargeting_geoipAreaLocation',
                'text'    => $strGeotargetingGeoipAreaLocation,
                'size'    => 35,
                'depends' => 'geotargeting_type==1'
            ),
            array (
                'type'    => 'break'
            ),
            array (
                'type'    => 'text',
                'name'    => 'geotargeting_geoipDmaLocation',
                'text'    => $strGeotargetingGeoipDmaLocation,
                'size'    => 35,
                'depends' => 'geotargeting_type==1'
            ),
            array (
                'type'    => 'break'
            ),
            array (
                'type'    => 'text',
                'name'    => 'geotargeting_geoipOrgLocation',
                'text'    => $strGeotargetingGeoipOrgLocation,
                'size'    => 35,
                'depends' => 'geotargeting_type==1'
            ),
            array (
                'type'    => 'break'
            ),
            array (
                'type'    => 'text',
                'name'    => 'geotargeting_geoipIspLocation',
                'text'    => $strGeotargetingGeoipIspLocation,
                'size'    => 35,
                'depends' => 'geotargeting_type==1'
            ),
            array (
                'type'    => 'break'
            ),
            array (
                'type'    => 'text',
                'name'    => 'geotargeting_geoipNetspeedLocation',
                'text'    => $strGeotargetingGeoipNetspeedLocation,
                'size'    => 35,
                'depends' => 'geotargeting_type==1'
            ),
            array (
                'type'    => 'break'
            ),
            array (
                'type'    => 'checkbox',
                'name'    => 'geotargeting_saveStats',
                'text'    => $strGeoSaveStats,
                'depends' => 'geotargeting_type==1 || geotargeting_type==2'
            ),
            array (
                'type'    => 'break'
            ),
            array (
                'type'    => 'checkbox',
                'name'    => 'geotargeting_showUnavailable',
                'text'    => $strGeoShowUnavailable,
                'depends' => 'geotargeting_type==1 || geotargeting_type==2'
            )
        )
    )
);
$oOptions->show($aSettings, $aErrormessage);

// Display the page footer
phpAds_PageFooter();

?>