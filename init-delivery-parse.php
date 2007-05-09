<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
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
$Id: init-delivery-parse.php 6120 2007-04-30 01:55:40Z aj@seagullproject.org $
*/

/**
 * @package    Max
 * @author     Andrew Hill <andrew.hill@openads.org>
 * @author     Radek Maciaszek <radek.maciaszek@openads.org>
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
    
    // Is the .ini file for the hostname being used directly accessible?
    if (isset($_SERVER['HTTP_HOST'])) {
        $host = $_SERVER['HTTP_HOST'];
    } else {
        $host = $_SERVER['SERVER_NAME'];
    }
    
    // Check if ini file is cached
    $configFileName = $configPath . '/' . $host . $configFile . '.conf.php';
    
    // Parse the configuration file
    $conf = @parse_ini_file($configFileName, true);
    if ($conf !== false) {
        return $conf;
    } elseif ($configFile === '.plugin') {
        // For plugins, if no configuration file is found, return the sane default values
        $pluginType = basename($configPath);
        $defaultConfig = MAX_PATH . '/plugins/' . $pluginType . '/default.plugin.conf.php';
        $conf = parse_ini_file($defaultConfig, $sections);
        if ($conf !== false) {
            return $conf;
        }
        exit(MAX_PRODUCT_NAME . " could not read the default configuration file for the {$pluginType} plugin");
    }
    
    // Check to ensure Max hasn't been installed
    if (file_exists(MAX_PATH . '/var/INSTALLED')) {
        exit(MAX_PRODUCT_NAME . " has been installed, but no configuration file was found.\n");
    }
    // Max hasn't been installed, so delivery engine can't run
    exit(MAX_PRODUCT_NAME . " has not been installed yet -- please read the INSTALL.txt file.\n");
}

?>