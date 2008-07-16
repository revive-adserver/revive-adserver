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
 *
 * A file to set up the environment for the OpenX administration interface.
 */

require_once 'init-parse.php';
require_once 'constants.php';
require_once 'variables.php';

/**
 * The environment initialisation function for the OpenX administration interface.
 *
 * @TODO Should move the user authentication, loading of preferences into this
 *       file, and out of the /www/admin/config.php file.
 */
function init()
{
    // Prevent _MAX from being read from the request string (if register globals is on)
    unset($GLOBALS['_MAX']);


    // Set up server variables
    setupServerVariables();
    // Set up the UI constants
    setupConstants();

    // Quick PHP Check, as use of PHP 4 will result in parse errors
    if (!function_exists('version_compare')) {
        include MAX_PATH . '/php_error.html';
        exit;
    }
    $result = version_compare(phpversion(), '5.0.0', '<');
    if ($result) {
        include MAX_PATH . '/php_error.html';
        exit;
    }

    // Set up the common configuration variables
    setupConfigVariables();
    // Disable all notices and warnings, as some PAN code still
    // generates PHP warnings in places
    error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
    // If not being called from the installation script...
    if ( (!isset($GLOBALS['_MAX']['CONF']['openads']['installed'])) || (!$GLOBALS['_MAX']['CONF']['openads']['installed']) )
    {
        define('OA_INSTALLATION_STATUS',    OA_INSTALLATION_STATUS_NOTINSTALLED);
    }
    else if ($GLOBALS['_MAX']['CONF']['openads']['installed'] && file_exists(MAX_PATH.'/var/UPGRADE'))
    {
        define('OA_INSTALLATION_STATUS',    OA_INSTALLATION_STATUS_UPGRADING);
    }
    else if ($GLOBALS['_MAX']['CONF']['openads']['installed'] && file_exists(MAX_PATH.'/var/INSTALLED'))
    {
        define('OA_INSTALLATION_STATUS',    OA_INSTALLATION_STATUS_INSTALLED);
    }

    global $installing;
    if ((!$installing) && (PHP_SAPI != 'cli')) {
        $scriptName = basename($_SERVER['PHP_SELF']);
        if ($scriptName != 'install.php' && PHP_SAPI != 'cli')
        {
            // Direct the user to the installation script if not installed
            //if (!$GLOBALS['_MAX']['CONF']['openads']['installed'])
            if (OA_INSTALLATION_STATUS !== OA_INSTALLATION_STATUS_INSTALLED)
            {
                // Do not redirect for maintenance scripts
                if ($scriptName == 'maintenance.php' || $scriptName == 'maintenance-distributed.php') {
                    exit;
                }

                $path = dirname($_SERVER['PHP_SELF']);
                if ($path == DIRECTORY_SEPARATOR)
                {
                    $path = '';
                }
                if (defined('ROOT_INDEX'))
                {
                    // The root index.php page was called to get here
                    $location = 'Location: ' . $GLOBALS['_MAX']['HTTP'] .
                           getHostNameWithPort() . $path . '/www/admin/install.php';
                    header($location);
                } elseif (defined('WWW_INDEX'))
                {
                    // The index.php page in /www was called to get here
                    $location = 'Location: ' . $GLOBALS['_MAX']['HTTP'] .
                           getHostNameWithPort() . $path . '/admin/install.php';
                    header($location);
                } else
                {
                    // The index.php page in /www/admin was called to get here
                    $location = 'Location: ' . $GLOBALS['_MAX']['HTTP'] .
                           getHostNameWithPort() . $path . '/install.php';
                    header($location);
                }
                exit();
            }
        }
    }
    // Start PHP error handler
    $conf = $GLOBALS['_MAX']['CONF'];
    include_once MAX_PATH . '/lib/max/ErrorHandler.php';
    $eh = new MAX_ErrorHandler();
    $eh->startHandler();

    define('OX_EXTENSIONS_PATH', MAX_PATH . rtrim($conf['pluginPaths']['extensions'], '/'));

    // increase amount of required memory if necessery
    increaseMemoryLimit(getMinimumRequiredMemory());
}

// Run the init() function
init();

require_once 'PEAR.php';

// Set $conf
$conf = $GLOBALS['_MAX']['CONF'];

?>
