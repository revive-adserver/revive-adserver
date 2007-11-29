<?php

/*
+---------------------------------------------------------------------------+
| Openads v${RELEASE_MAJOR_MINOR}                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
| For contact details, see: http://www.openads.org/                         |
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
require_once MAX_PATH . '/lib/max/Plugin.php';
require_once MAX_PATH . '/lib/max/Admin/Geotargeting.php';
require_once MAX_PATH . '/lib/max/Admin/Redirect.php';
require_once MAX_PATH . '/lib/OA/Admin/Option.php';

require_once 'Config.php';

$oOptions = new OA_Admin_Option('settings');

// Security check
phpAds_checkAccess(phpAds_Admin);

$aErrormessage = array();
if (isset($_POST['submitok']) && $_POST['submitok'] == 'true') {
    phpAds_registerGlobal('geotargeting_type',
                          'geotargeting_geoipCountryLocation',
                          'geotargeting_geoipRegionLocation',
                          'geotargeting_geoipCityLocation',
                          'geotargeting_geoipAreaLocation',
                          'geotargeting_geoipDmaLocation',
                          'geotargeting_geoipOrgLocation',
                          'geotargeting_geoipIspLocation',
                          'geotargeting_geoipNetspeedLocation',
                          'geotargeting_saveStats',
                          'geotargeting_showUnavailable');
    // Set up the top level geotargeting configuration file
    $oConfig = new OA_Admin_Settings();
    $oConfig->setConfigChange('geotargeting', 'type', $geotargeting_type);
    $oConfig->setConfigChange('geotargeting', 'saveStats', $geotargeting_saveStats);
    $oConfig->setConfigChange('geotargeting', 'showUnavailable', $geotargeting_showUnavailable);
    if (!$oConfig->writeConfigChange()) { //MAX_Plugin::writePluginConfig($oConfig->conf, 'geotargeting')) {
        // Unable to write the config file out
        $aErrormessage[0][] = $strUnableToWriteConfig;
    }

    // Set up the geotargting type configuration file, if required
    $oConfig = new OA_Admin_Settings();
    $oConfig->setConfigChange('geotargeting', 'type', $geotargeting_type);
    if ($geotargeting_type != 'none') {
        // Test the supplied files
        if (isset($geotargeting_geoipCountryLocation) && ($geotargeting_geoipCountryLocation != '')) {
            if (is_readable($geotargeting_geoipCountryLocation)) {
                $oConfig->setConfigChange('geotargeting', 'geoipCountryLocation', $geotargeting_geoipCountryLocation);
            } else {
                $aErrormessage[0][] = $strGeotrackingGeoipCountryLocationError;
            }
        } else {
            $oConfig->setConfigChange('geotargeting', 'geoipCountryLocation', '');
        }
        if (isset($geotargeting_geoipRegionLocation) && ($geotargeting_geoipRegionLocation != '')) {
            if (is_readable($geotargeting_geoipRegionLocation)) {
                $oConfig->setConfigChange('geotargeting', 'geoipRegionLocation', $geotargeting_geoipRegionLocation);
            } else {
                $aErrormessage[0][] = $strGeotrackingGeoipRegionLocationError;
            }
        } else {
            $oConfig->setConfigChange('geotargeting', 'geoipRegionLocation', '');
        }
        if (isset($geotargeting_geoipCityLocation) && ($geotargeting_geoipCityLocation != '')) {
            if (is_readable($geotargeting_geoipCityLocation)) {
                $oConfig->setConfigChange('geotargeting', 'geoipCityLocation', $geotargeting_geoipCityLocation);
            } else {
                $aErrormessage[0][] = $strGeotrackingGeoipCityLocationError;
            }
        } else {
            $oConfig->setConfigChange('geotargeting', 'geoipCityLocation', '');
        }
        if (isset($geotargeting_geoipAreaLocation) && ($geotargeting_geoipAreaLocation != '')) {
            if (is_readable($geotargeting_geoipAreaLocation)) {
                $oConfig->setConfigChange('geotargeting', 'geoipAreaLocation', $geotargeting_geoipAreaLocation);
            } else {
                $aErrormessage[0][] = $strGeotrackingGeoipAreaLocationError;
            }
        } else {
            $oConfig->setConfigChange('geotargeting', 'geoipAreaLocation', '');
        }
        if (isset($geotargeting_geoipDmaLocation) && ($geotargeting_geoipDmaLocation != '')) {
            if (is_readable($geotargeting_geoipDmaLocation)) {
                $oConfig->setConfigChange('geotargeting', 'geoipDmaLocation', $geotargeting_geoipDmaLocation);
            } else {
                $aErrormessage[0][] = $strGeotrackingGeoipDmaLocationError;
            }
        } else {
            $oConfig->setConfigChange('geotargeting', 'geoipDmaLocation', '');
        }
        if (isset($geotargeting_geoipOrgLocation) && ($geotargeting_geoipOrgLocation != '')) {
            if (is_readable($geotargeting_geoipOrgLocation)) {
                $oConfig->setConfigChange('geotargeting', 'geoipOrgLocation', $geotargeting_geoipOrgLocation);
            } else {
                $aErrormessage[0][] = $strGeotrackingGeoipOrgLocationError;
            }
        } else {
            $oConfig->setConfigChange('geotargeting', 'geoipOrgLocation', '');
        }
        if (isset($geotargeting_geoipIspLocation) && ($geotargeting_geoipIspLocation != '')) {
            if (is_readable($geotargeting_geoipIspLocation)) {
                $oConfig->setConfigChange('geotargeting', 'geoipIspLocation', $geotargeting_geoipIspLocation);
            } else {
                $aErrormessage[0][] = $strGeotrackingGeoipIspLocationError;
            }
        } else {
            $oConfig->setConfigChange('geotargeting', 'geoipIspLocation', '');
        }
        if (isset($geotargeting_geoipNetspeedLocation) && ($geotargeting_geoipNetspeedLocation != '')) {
            if (is_readable($geotargeting_geoipNetspeedLocation)) {
                $oConfig->setConfigChange('geotargeting', 'geoipNetspeedLocation', $geotargeting_geoipNetspeedLocation);
            } else {
                $aErrormessage[0][] = $strGeotrackingGeoipNetspeedLocationError;
            }
        } else {
            $oConfig->setConfigChange('geotargeting', 'geoipNetspeedLocation', '');
        }
    }
    if (!count($aErrormessage)) {
        $oConfigFileName = MAX_Plugin::getConfigFileName('geotargeting', $geotargeting_type);
        if (!file_exists($oConfigFileName)) {
            MAX_Plugin::copyDefaultConfig('geotargeting', $geotargeting_type);
        }
        if ($geotargeting_type != 'none' &&
            !$oConfig->writeConfigChange()) { //!MAX_Plugin::writePluginConfig($oConfig->conf, 'geotargeting', $geotargeting_type)) {
            // Unable to write the config file out
            $aErrormessage[0][] = $strUnableToWriteConfig;
        } else {
            MAX_Admin_Redirect::redirect('account-settings-maintenance.php');
        }
    }
}

phpAds_PageHeader("5.2");
phpAds_ShowSections(array("5.1", "5.2", "5.4", "5.5", "5.3", "5.6", "5.7"));
$oOptions->selection("geotargeting");

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
                'depends' => 'geotargeting_type>0'
            ),
            array (
                'type'    => 'break'
            ),
            array (
                'type'    => 'checkbox',
                'name'    => 'geotargeting_showUnavailable',
                'text'    => $strGeoShowUnavailable,
                'depends' => 'geotargeting_type>0'
            )
        )
    )
);

$oOptions->show($aSettings, $aErrormessage);
phpAds_PageFooter();

?>
