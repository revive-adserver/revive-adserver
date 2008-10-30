<?php

/*
+---------------------------------------------------------------------------+
| OpenX  v${RELEASE_MAJOR_MINOR}                                                              |
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
$Id: init-delivery-parse.php 6120 2007-04-30 01:55:40Z aj@seagullproject.org $
*/

/**
 * @package    Max
 * @author     Andrew Hill <andrew.hill@openx.org>
 * @author     Radek Maciaszek <radek.maciaszek@openx.org>
 */

/**
 * The delivery engine's function to parse the configuration .ini file
 *
 * @param $configPath The path to the config file
 * @param $configFile Optional - The suffix of the config file
 * @param $sections Optional - process sections to get a multidimensional array
 *
 * @return mixed The array resulting from the call to parse_ini_file(), with
 *               the appropriate .ini file for the installation.
 */
function parseDeliveryIniFile($configPath = null, $configFile = null, $sections = true)
{
    // Set up the configuration .ini file path location
    if (!$configPath) {
        $configPath = MAX_PATH . '/var';
    }
    if ($configFile) {
        $configFile = '.' . $configFile;
    }
    $host = getHostName();
    $configFileName = $configPath . '/' . $host . $configFile . '.conf.php';
    $conf = @parse_ini_file($configFileName, $sections);
    if (isset($conf['realConfig'])) {
        // added for backward compatibility - realConfig points to different config
        $realconf = @parse_ini_file(MAX_PATH . '/var/' . $conf['realConfig'] . '.conf.php', $sections);
        $conf = mergeConfigFiles($realconf, $conf);
    }
    if (!empty($conf)) {
        return $conf;
    } elseif ($configFile === '.plugin') {
        // For plugins, if no configuration file is found, return the sane default values
        $pluginType = basename($configPath);
        $defaultConfig = MAX_PATH . '/plugins/' . $pluginType . '/default.plugin.conf.php';
        $conf = @parse_ini_file($defaultConfig, $sections);
        if ($conf !== false) {
            // check for false here - it's possible file doesn't exist
            return $conf;
        }
        echo "OpenX could not read the default configuration file for the {$pluginType} plugin";
        exit(1);
    }
    // Check for a 'default.conf.php' file
    $configFileName = $configPath . '/default' . $configFile . '.conf.php';
    $conf = @parse_ini_file($configFileName, $sections);
    if (isset($conf['realConfig'])) {
        // added for backward compatibility - realConfig points to different config
        $conf = @parse_ini_file(MAX_PATH . '/var/' . $conf['realConfig'] . '.conf.php', $sections);
    }
    if (!empty($conf)) {
        return $conf;
    }
    // Check to ensure Max hasn't been installed
    if (file_exists(MAX_PATH . '/var/INSTALLED')) {
        echo "OpenX has been installed, but no configuration file was found.\n";
        exit(1);
    }
    // Max hasn't been installed, so delivery engine can't run
    echo "OpenX has not been installed yet -- please read the INSTALL.txt file.\n";
    exit(1);
}

if (!function_exists('mergeConfigFiles'))
{
    function mergeConfigFiles($realConfig, $fakeConfig)
    {
        foreach ($fakeConfig as $key => $value) {
            if (is_array($value)) {
                if (!isset($realConfig[$key])) {
                    $realConfig[$key] = array();
                }
                $realConfig[$key] = mergeConfigFiles($realConfig[$key], $value);
            } else {
                if (isset($realConfig[$key]) && is_array($realConfig[$key])) {
                    $realConfig[$key][0] = $value;
                } else {
                    if (isset($realConfig) && !is_array($realConfig)) {
                        $temp = $realConfig;
                        $realConfig = array();
                        $realConfig[0] = $temp;
                    }
                    $realConfig[$key] = $value;
                }
            }
        }
        unset($realConfig['realConfig']);
        return $realConfig;
    }
}


?>