<?php

/*
+---------------------------------------------------------------------------+
| Max Media Manager v0.3                                                    |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2006 m3 Media Services Limited                         |
| For contact details, see: http://www.m3.net/                              |
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

/**
 * @package    Max
 * @author     Andrew Hill <andrew@m3.net>
 */

/**
 * The delivery engine's function to parse the configuration .ini file
 *
 * @param $configPath The path to the config file
 * @param $configSuffix Optional - The suffix of the config files
 * 
 * @return mixed The array resulting from the call to parse_ini_file(), with
 *               the appropriate .ini file for the installation.
 */
function parseIniFile($configPath = null, $configFile = null, $sections = true)
{
    // Set up the configuration .ini file path location
    if (is_null($configPath)) {
        $configPath = MAX_PATH . '/var';
    }
    // Set up the configuration .ini file type name
    if (!is_null($configFile)) {
        $configFile = '.' . $configFile;
    }
    // Is the .ini file for the hostname being used directly accessible?
    if (!empty($_SERVER['HTTP_HOST'])) {
        $host = $_SERVER['HTTP_HOST'];
    } else {
        $host = $_SERVER['SERVER_NAME'];
    }
    
    // Is the .ini file for the hostname being used directly accessible?
    if (file_exists($configPath . '/' . $host . $configFile . '.conf.ini')) {
        // Parse the configuration file
        $conf = @parse_ini_file($configPath . '/' . $host . $configFile . '.conf.ini', true);
        // Is this a real config file?
        if (!isset($conf['realConfig'])) {
            // Yes, return the parsed configuration file
            return $conf;
        }
        // Parse and return the real configuration .ini file
        if (file_exists($configPath . '/' . $conf['realConfig'] . $configFile . '.conf.ini')) {
            $realConfig = @parse_ini_file($configPath . '/' . $conf['realConfig'] . $configFile . '.conf.ini', true);
            return mergeConfigFiles($realConfig, $conf);
        }
    } elseif ($configFile === '.plugin') {
        // For plugins, if no configuration file is found, return the sane default values
        $pluginType = basename($configPath);
        $defaultConfig = MAX_PATH . '/plugins/' . $pluginType . '/default.plugin.conf.ini';
        if (file_exists($defaultConfig)) {
            return parse_ini_file($defaultConfig, $sections);
        } else {
            exit(MAX_PRODUCT_NAME . " could not read the default configuration file for the {$pluginType} plugin");
        }
    }
    
    // Check to ensure Max hasn't been installed
    if (file_exists(MAX_PATH . '/var/INSTALLED')) {
        exit(MAX_PRODUCT_NAME . " has been installed, but no configuration file was found.\n");
    }
    // Max hasn't been installed, so delivery engine can't run
    exit(MAX_PRODUCT_NAME . " has not been installed yet -- please read the INSTALL.txt file.\n");
}

?>
