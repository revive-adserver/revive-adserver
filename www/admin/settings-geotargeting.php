<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| =============                                                             |
|                                                                           |
| Copyright (c) 2003-2007 Openads Ltd                                       |
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
require_once MAX_PATH . '/www/admin/lib-settings.inc.php';

require_once 'Config.php';

// Security check
phpAds_checkAccess(phpAds_Admin);

$errormessage = array();
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
    // Set up the main configuration .ini file
    $config = new MAX_Admin_Config($newConfig = true);
    $config->setConfigChange('geotargeting', 'type', $geotargeting_type);
    $config->setConfigChange('geotargeting', 'saveStats', $geotargeting_saveStats);
    $config->setConfigChange('geotargeting', 'showUnavailable', $geotargeting_showUnavailable);
    // geotargeting type has to be saved to the main config file
    //$c = new Config();
    //$c->parseConfig($config->conf, 'phpArray');
    //$c->writeConfig(MAX_Plugin::getConfigFileName('geotargeting'), 'inifile')
    if (!MAX_Plugin::writePluginConfig($config->conf, 'geotargeting')) {
        // Unable to write the config file out
        $errormessage[0][] = $strUnableToWriteConfig;
    }
    // Set up the configuration .ini file
    $config = new MAX_Admin_Config($newConfig = true);
    $config->setConfigChange('geotargeting', 'type', $geotargeting_type);
    if ($geotargeting_type != 'none') {
        // Test the supplied files
        if (isset($geotargeting_geoipCountryLocation) && ($geotargeting_geoipCountryLocation != '')) {
            if (is_readable($geotargeting_geoipCountryLocation)) {
                $config->setConfigChange('geotargeting', 'geoipCountryLocation', $geotargeting_geoipCountryLocation);
            } else {
                $errormessage[0][] = $strGeotrackingGeoipCountryLocationError;
            }
        } else {
            $config->setConfigChange('geotargeting', 'geoipCountryLocation', '');
        }
        if (isset($geotargeting_geoipRegionLocation) && ($geotargeting_geoipRegionLocation != '')) {
            if (is_readable($geotargeting_geoipRegionLocation)) {
                $config->setConfigChange('geotargeting', 'geoipRegionLocation', $geotargeting_geoipRegionLocation);
            } else {
                $errormessage[0][] = $strGeotrackingGeoipRegionLocationError;
            }
        } else {
            $config->setConfigChange('geotargeting', 'geoipRegionLocation', '');
        }
        if (isset($geotargeting_geoipCityLocation) && ($geotargeting_geoipCityLocation != '')) {
            if (is_readable($geotargeting_geoipCityLocation)) {
                $config->setConfigChange('geotargeting', 'geoipCityLocation', $geotargeting_geoipCityLocation);
            } else {
                $errormessage[0][] = $strGeotrackingGeoipCityLocationError;
            }
        } else {
            $config->setConfigChange('geotargeting', 'geoipCityLocation', '');
        }
        if (isset($geotargeting_geoipAreaLocation) && ($geotargeting_geoipAreaLocation != '')) {
            if (is_readable($geotargeting_geoipAreaLocation)) {
                $config->setConfigChange('geotargeting', 'geoipAreaLocation', $geotargeting_geoipAreaLocation);
            } else {
                $errormessage[0][] = $strGeotrackingGeoipAreaLocationError;
            }
        } else {
            $config->setConfigChange('geotargeting', 'geoipAreaLocation', '');
        }
        if (isset($geotargeting_geoipDmaLocation) && ($geotargeting_geoipDmaLocation != '')) {
            if (is_readable($geotargeting_geoipDmaLocation)) {
                $config->setConfigChange('geotargeting', 'geoipDmaLocation', $geotargeting_geoipDmaLocation);
            } else {
                $errormessage[0][] = $strGeotrackingGeoipDmaLocationError;
            }
        } else {
            $config->setConfigChange('geotargeting', 'geoipDmaLocation', '');
        }
        if (isset($geotargeting_geoipOrgLocation) && ($geotargeting_geoipOrgLocation != '')) {
            if (is_readable($geotargeting_geoipOrgLocation)) {
                $config->setConfigChange('geotargeting', 'geoipOrgLocation', $geotargeting_geoipOrgLocation);
            } else {
                $errormessage[0][] = $strGeotrackingGeoipOrgLocationError;
            }
        } else {
            $config->setConfigChange('geotargeting', 'geoipOrgLocation', '');
        }
        if (isset($geotargeting_geoipIspLocation) && ($geotargeting_geoipIspLocation != '')) {
            if (is_readable($geotargeting_geoipIspLocation)) {
                $config->setConfigChange('geotargeting', 'geoipIspLocation', $geotargeting_geoipIspLocation);
            } else {
                $errormessage[0][] = $strGeotrackingGeoipIspLocationError;
            }
        } else {
            $config->setConfigChange('geotargeting', 'geoipIspLocation', '');
        }
        if (isset($geotargeting_geoipNetspeedLocation) && ($geotargeting_geoipNetspeedLocation != '')) {
            if (is_readable($geotargeting_geoipNetspeedLocation)) {
                $config->setConfigChange('geotargeting', 'geoipNetspeedLocation', $geotargeting_geoipNetspeedLocation);
            } else {
                $errormessage[0][] = $strGeotrackingGeoipNetspeedLocationError;
            }
        } else {
            $config->setConfigChange('geotargeting', 'geoipNetspeedLocation', '');
        }
    }
    if (!count($errormessage)) {
        $configFileName = MAX_Plugin::getConfigFileName('geotargeting', $geotargeting_type);
        if(!file_exists($configFileName)) {
            MAX_Plugin::copyDefaultConfig('geotargeting', $geotargeting_type);
        }
        //$c = new Config();
        //$c->parseConfig($config->conf, 'phpArray');
        //$c->writeConfig($configFileName, 'inifile')
        if ($geotargeting_type != 'none' &&
            !MAX_Plugin::writePluginConfig($config->conf, 'geotargeting', $geotargeting_type)) {
            // Unable to write the config file out
            $errormessage[0][] = $strUnableToWriteConfig;
        } else {
            MAX_Admin_Redirect::redirect('settings-defaults.php');
        }
    }
}

phpAds_PrepareHelp();
phpAds_PageHeader("5.1");
phpAds_ShowSections(array("5.1", "5.3", "5.4", "5.2", "5.5", "5.6"));
phpAds_SettingsSelection("geotargeting");

// read plugin config
$GLOBALS['_MAX']['CONF']['geotargeting'] = MAX_Plugin::getConfig('geotargeting');
$geo = MAX_Plugin::factoryPluginByModuleConfig('geotargeting');
if($geo) {
    $pluginConfig = $geo->getConfig();
    if(!empty($pluginConfig)) {
        // overwrite
        foreach($pluginConfig as $key => $value) {
            $GLOBALS['_MAX']['CONF']['geotargeting'][$key] = $value;
        }
    }
}

$settings = array (
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

phpAds_ShowSettings($settings, $errormessage);
phpAds_PageFooter();

?>
