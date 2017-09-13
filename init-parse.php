<?php

/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
*/

/**
 * @package    ReviveAdserver
 */

/**
 * The general (non-delivery engine) function to parse the configuration .ini file
 *
 * @param string $configPath The directory to load the config file from.
 *                           Default is Revive Adserver's /var directory.
 * @param string $configFile The configuration file name (eg. "geotargeting").
 *                           Default is no name (ie. the main Revive Adserver
 *                           configuration file).
 * @param boolean $sections  Process sections, as per parse_ini_file().
 * @param string  $type      The config file type value (eg. ".php"). Allows
 *                           for backwards-compatibility for old ".ini" files.
 *
 * @return mixed The array resulting from the call to parse_ini_file(), with
 *               the appropriate .php file for the installation.
 */
function parseIniFile($configPath = null, $configFile = null, $sections = true, $type = '.php')
{
    $fixMysqli = function($conf) {
        if ('mysql' === $conf['database']['type'] && !extension_loaded('mysql') && extension_loaded('mysqli')) {
            $conf['database']['type'] = 'mysqli';
        } elseif ('mysqli' === $conf['database']['type']) {
            if (empty($conf['table']['type'])) {
                $conf['table']['type'] = 'InnoDB';
            }
            if (!extension_loaded('mysqli') && extension_loaded('mysql')) {
                $conf['database']['type'] = 'mysql';
            }
        }

        return $conf;
    };

    // Set up the configuration .ini file path location
    if (is_null($configPath)) {
        $configPath = MAX_PATH . '/var';
    }
    // Set up the configuration .ini file type name
    if (!is_null($configFile)) {
        $configFile = '.' . $configFile;
    }
    // Is this a command line call (i.e. to run maintenance?)
    if (is_null($configFile) && !isset($_SERVER['SERVER_NAME'])) {
        // Yes; set the $_SERVER['HTTP_HOST'] variable to fake the command line
        // call to act like a web client call, so that the host name processing
        // works the same both ways
        if (defined('TEST_ENVIRONMENT_RUNNING')) {
            $_SERVER['HTTP_HOST'] = 'test';
        } else {
            if (!isset($GLOBALS['argv'][1])) {
                echo PRODUCT_NAME . " was called via the command line, but had no host as a parameter.\n";
                exit(1);
            }
            $_SERVER['HTTP_HOST'] = trim($GLOBALS['argv'][1]);
        }
    }
    // Get the host name that Revive Adserver is being accessed via, so that
    // this can be correlated with the appropriate configuration file
    $host = OX_getHostName();

    // Is the system running the test environment?
    if (is_null($configFile) && defined('TEST_ENVIRONMENT_RUNNING') && empty($GLOBALS['override_TEST_ENVIRONMENT_RUNNING'])) {
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
            return $fixMysqli($conf);
        }
        // Parse and return the real configuration .ini file
        if (file_exists($configPath . '/' . $conf['realConfig'] . $configFile . '.conf' . $type)) {
            $realConfig = @parse_ini_file(MAX_PATH . '/var/' . $conf['realConfig'] . '.conf' . $type, true);
            $mergedConf = mergeConfigFiles($realConfig, $conf);
            // if not multiple levels of configs
            if (!isset($mergedConf['realConfig'])) {
                return $fixMysqli($mergedConf);
            }
        }
    } elseif ($configFile === '.plugin') {
        // For plugins, if no configuration file is found, return the sane default values
        $pluginType = basename($configPath);
        $defaultConfig = MAX_PATH . '/plugins/' . $pluginType . '/default.plugin.conf' . $type;
        if (file_exists($defaultConfig)) {
            return parse_ini_file($defaultConfig, $sections);
        } else {
            echo PRODUCT_NAME . " could not read the default configuration file for the {$pluginType} plugin";
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
            return $fixMysqli($conf);
        }
        // Parse and return the real configuration .ini file
        if (file_exists($configPath . '/' . $conf['realConfig'] . $configFile . '.conf' . $type)) {
            $realConfig = @parse_ini_file(MAX_PATH . '/var/' . $conf['realConfig'] . '.conf' . $type, true);
            $mergedConf = mergeConfigFiles($realConfig, $conf);
            // if not multiple levels of configs
            if (!isset($mergedConf['realConfig'])) {
                return $fixMysqli($mergedConf);
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
            // Revive Adserver hasn't been installed, so use the distribution
            // .ini file; this deals with letting a PAN install get into the
            // ugprader
            return @parse_ini_file(MAX_PATH . '/etc/dist.conf.php', $sections);
        }
        //return parseIniFile($configPath, $configFile, $sections, '.ini');

    }
    // Check to ensure Revive Adserver hasn't been installed
    if (file_exists(MAX_PATH . '/var/INSTALLED'))
    {
        // ah but MMM might be installed, check for the ini file
        if (file_exists($configPath . '/' . $host . $configFile . '.conf.ini'))
        {
            return parseIniFile($configPath, $configFile, $sections, '.ini');
        }
        echo PRODUCT_NAME . " has been installed, but no configuration file ".$configPath . '/' . $host . $configFile . '.conf.php'." was found.\n";
        exit(1);
    }
    // Revive Adserver hasn't been installed, so use the distribution .ini file
    return @parse_ini_file(MAX_PATH . '/etc/dist.conf.php', $sections);
}

?>
