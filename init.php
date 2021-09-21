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
 * @package    Max
 *
 * A file to set up the environment for the administration interface.
 */

require_once 'pre-check.php';
require_once 'init-parse.php';
require_once 'variables.php';
require_once 'constants.php';

/**
 * The environment initialisation function for the administration interface.
 *
 * @TODO Should move the user authentication, loading of preferences into this
 *       file, and out of the /www/admin/config.php file.
 */
function init()
{
    // Prevent _MAX from being read from the request string (if register globals is on)
    unset($GLOBALS['_MAX']);
    unset($GLOBALS['_OX']);

    // Set up server variables
    setupServerVariables();

    // Set up the UI constants
    setupConstants();

    // Set up the common configuration variables
    setupConfigVariables();

    // Bootstrap PSR Autoloader and DI container
    require MAX_PATH . '/lib/vendor/autoload.php';
    $GLOBALS['_MAX']['DI'] = new \RV\Container($GLOBALS['_MAX']['CONF']);

    // Disable all notices and warnings, as lots of code still
    // generates PHP warnings - especially E_STRICT notices from PEAR
    // libraries
    error_reporting(E_ALL & ~(E_NOTICE | E_WARNING | E_DEPRECATED | E_STRICT));

    // If not being called from the installation script...
    if ((!isset($GLOBALS['_MAX']['CONF']['openads']['installed'])) || (!$GLOBALS['_MAX']['CONF']['openads']['installed'])) {
        define('OA_INSTALLATION_STATUS', OA_INSTALLATION_STATUS_NOTINSTALLED);
    } elseif ($GLOBALS['_MAX']['CONF']['openads']['installed'] && file_exists(MAX_PATH . '/var/UPGRADE')) {
        define('OA_INSTALLATION_STATUS', OA_INSTALLATION_STATUS_UPGRADING);
    } elseif ($GLOBALS['_MAX']['CONF']['openads']['installed'] && file_exists(MAX_PATH . '/var/INSTALLED')) {
        define('OA_INSTALLATION_STATUS', OA_INSTALLATION_STATUS_INSTALLED);
    }

    global $installing;
    if ((!$installing) && (PHP_SAPI != 'cli')) {
        $scriptName = basename($_SERVER['SCRIPT_NAME']);
        // Direct the user to the installation script if not installed
        //if (!$GLOBALS['_MAX']['CONF']['openads']['installed'])
        if ($scriptName != 'install.php' && PHP_SAPI != 'cli' && OA_INSTALLATION_STATUS !== OA_INSTALLATION_STATUS_INSTALLED) {
            // Do not redirect for maintenance scripts
            if ($scriptName == 'maintenance.php' || $scriptName == 'maintenance-distributed.php') {
                exit;
            }
            $path = dirname($_SERVER['SCRIPT_NAME']);
            if ($path == DIRECTORY_SEPARATOR) {
                $path = '';
            }
            if (defined('ROOT_INDEX')) {
                // The root index.php page was called to get here
                $location = 'Location: ' . $GLOBALS['_MAX']['HTTP'] .
                       OX_getHostNameWithPort() . $path . '/www/admin/install.php';
                header($location);
            } elseif (defined('WWW_INDEX')) {
                // The index.php page in /www was called to get here
                $location = 'Location: ' . $GLOBALS['_MAX']['HTTP'] .
                       OX_getHostNameWithPort() . $path . '/admin/install.php';
                header($location);
            } else {
                // The index.php page in /www/admin was called to get here
                $location = 'Location: ' . $GLOBALS['_MAX']['HTTP'] .
                       OX_getHostNameWithPort() . $path . '/install.php';
                header($location);
            }
            exit();
        }
    }

    // Start PHP error handler
    $conf = $GLOBALS['_MAX']['CONF'];
    include_once MAX_PATH . '/lib/max/ErrorHandler.php';
    $eh = new MAX_ErrorHandler();
    $eh->startHandler();

    // Store the original memory limit before changing it
    $GLOBALS['_OX']['ORIGINAL_MEMORY_LIMIT'] = OX_getMemoryLimitSizeInBytes();

    // Increase the PHP memory_limit value to the minimum required value, if necessary
    OX_increaseMemoryLimit(OX_getMinimumRequiredMemory());
}

// Run the init() function
init();

require_once 'PEAR.php';

// Set $conf
$conf = $GLOBALS['_MAX']['CONF'];
