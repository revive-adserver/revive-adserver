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

/**
 * @package    Max
 * @author     Andrew Hill <andrew@m3.net>
 */

/**
 * The general (non-delivery engine) function to parse the configuration .ini file
 *
 * @param string $configPath The directory to load the config file from.
 *                           Default is Max's /var directory.
 * @param string $configFile The configuration file name (eg. "geotargeting").
 *                           Default is no name (ie. the main Max
 *                           configuration file).
 * @param boolean $sections  Process sections, as per parse_ini_file().
 * @param string  $type      The config file type value (eg. ".php"). Allows BC
 *                           support for old ".ini" files.
 *
 * @return mixed The array resulting from the call to parse_ini_file(), with
 *               the appropriate .php file for the installation.
 */
function parseIniFile($configPath = null, $configFile = null, $sections = true, $type = '.php')
{
    // Set up the configuration .ini file path location
    if (is_null($configPath)) {
        $configPath = MAX_PATH . '/var';
    }
    // Set up the configuration .ini file type name
    if (!is_null($configFile)) {
        $configFile = '.' . $configFile;
    }
    // Is this a web, or a cli call?
    if (is_null($configFile) && !isset($_SERVER['SERVER_NAME'])) {
        if (!isset($GLOBALS['argv'][1]) && !file_exists($configPath . '/default' . $configFile . '.conf' . $type)) {
            echo MAX_PRODUCT_NAME . " was called via the command line, but had no host as a parameter.\n";
            exit(1);
        }
        $host = trim($GLOBALS['argv'][1]);
    } else {
        $host = getHostName();
    }
    // Is the system running the test environment?
    if (is_null($configFile) && defined('TEST_ENVIRONMENT_RUNNING')) {
        if (isset($_SERVER['SERVER_NAME'])) {
            // If test runs from web-client first check if host test config exists
            // This could be used to have different tests for different configurations
            $testFilePath = $configPath . '/'.$host.'.test.conf' . $type;
            if (file_exists($testFilePath)) {
                return @parse_ini_file($testFilePath, $sections);
            }
        }
        // Does the test environment config exist?
        $testFilePath = $configPath . '/test.conf' . $type;
        if (file_exists($testFilePath)) {
            return @parse_ini_file($testFilePath, $sections);
        } else {
            // Define a value so that we know the testing environment is not
            // configured, so that the TestRenner class knows not to run any
            // tests, and return an empty config
            define('TEST_ENVIRONMENT_NO_CONFIG', true);
            return array();
        }
    }
    // Is the .ini file for the hostname being used directly accessible?
    if (file_exists($configPath . '/' . $host . $configFile . '.conf' . $type)) {
        // Parse the configuration file
        $conf = @parse_ini_file($configPath . '/' . $host . $configFile . '.conf' . $type, $sections);
        // Is this a real config file?
        if (!isset($conf['realConfig'])) {
            // Yes, return the parsed configuration file
            return $conf;
        }
        // Parse and return the real configuration .ini file
        if (file_exists($configPath . '/' . $conf['realConfig'] . $configFile . '.conf' . $type)) {
            $realConfig = @parse_ini_file(MAX_PATH . '/var/' . $conf['realConfig'] . '.conf' . $type, true);
            $mergedConf = mergeConfigFiles($realConfig, $conf);
            // if not multiple levels of configs
            if (!isset($mergedConf['realConfig'])) {
                return $mergedConf;
            }
        }
    } elseif ($configFile === '.plugin') {
        // For plugins, if no configuration file is found, return the sane default values
        $pluginType = basename($configPath);
        $defaultConfig = MAX_PATH . '/plugins/' . $pluginType . '/default.plugin.conf' . $type;
        if (file_exists($defaultConfig)) {
            return parse_ini_file($defaultConfig, $sections);
        } else {
            echo MAX_PRODUCT_NAME . " could not read the default configuration file for the {$pluginType} plugin";
            exit(1);
        }
    }
    // Check for a default.conf.php file...
    if (file_exists($configPath . '/default' . $configFile . '.conf' . $type)) {
        // Parse the configuration file
        $conf = @parse_ini_file($configPath . '/default' . $configFile . '.conf' . $type, $sections);
        // Is this a real config file?
        if (!isset($conf['realConfig'])) {
            // Yes, return the parsed configuration file
            return $conf;
        }
        // Parse and return the real configuration .ini file
        if (file_exists($configPath . '/' . $conf['realConfig'] . $configFile . '.conf' . $type)) {
            $realConfig = @parse_ini_file(MAX_PATH . '/var/' . $conf['realConfig'] . '.conf' . $type, true);
            $mergedConf = mergeConfigFiles($realConfig, $conf);
            // if not multiple levels of configs
            if (!isset($mergedConf['realConfig'])) {
                return $mergedConf;
            }
        }
    }
    // Got all this way, and no configuration file yet found - maybe
    // the user is upgrading from an old version where the config
    // files have a .ini prefix instead of .php...
    global $installing;
    if ($installing)
    {
        // ah but MMM might be installed, check for the ini file
        if (file_exists($configPath . '/' . $host . $configFile . '.conf.ini'))
        {
            return parseIniFile($configPath, $configFile, $sections, '.ini');
        }
        if (!$configFile)
        {
            // OpenX hasn't been installed, so use the distribution .ini file
            // this deals with letting a PAN install get into the ugprader
            return @parse_ini_file(MAX_PATH . '/etc/dist.conf.php', $sections);
        }
        //return parseIniFile($configPath, $configFile, $sections, '.ini');

    }
    // Check to ensure OpenX hasn't been installed
    if (file_exists(MAX_PATH . '/var/INSTALLED'))
    {
        // ah but MMM might be installed, check for the ini file
        if (file_exists($configPath . '/' . $host . $configFile . '.conf.ini'))
        {
            return parseIniFile($configPath, $configFile, $sections, '.ini');
        }
        echo MAX_PRODUCT_NAME . " has been installed, but no configuration file ".$configPath . '/' . $host . $configFile . '.conf.php'." was found.\n";
        exit(1);
    }
    // OpenX hasn't been installed, so use the distribution .ini file
    return @parse_ini_file(MAX_PATH . '/etc/dist.conf.php', $sections);
}

?>
