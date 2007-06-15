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
$Id$
*/

/**
 * @package    Max
 * @author     Andrew Hill <andrew@m3.net>
 *
 * A file to set up the environment for the Openads administration interface.
 */

require_once 'init-parse.php';
require_once 'constants.php';
require_once 'variables.php';

/**
 * The environment initialisation function for the Openads administration interface.
 *
 * @TODO Should move the user authentication, loading of preferences into this
 *       file, and out of the /www/admin/config.php file.
 */
function init()
{
    // Set up the UI constants
    setupConstants();
    // Set up the common configuration variables
    setupConfigVariables();
    // Disable all notices and warnings, as some PAN code still
    // generates PHP warnings in places
    error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
    // If not being called from the installation script...

    if (!$GLOBALS['_MAX']['CONF']['openads']['installed'])
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
        if (basename($_SERVER['PHP_SELF']) != 'install.php' && PHP_SAPI != 'cli')
        {
            // Direct the user to the installation script if not installed
            //if (!$GLOBALS['_MAX']['CONF']['openads']['installed'])
            if (OA_INSTALLATION_STATUS !== OA_INSTALLATION_STATUS_INSTALLED)
            {
                $path = dirname($_SERVER['PHP_SELF']);
                if ($path == DIRECTORY_SEPARATOR)
                {
                    $path = '';
                }
                if ($GLOBALS['_MAX']['ROOT_INDEX'])
                {
                    // The root index.php page was called to get here
                    $location = 'Location: ' . $GLOBALS['_MAX']['HTTP'] .
                           getHostNameWithPort() . $path . '/www/admin/install.php';
                    header($location);
                } elseif ($GLOBALS['_MAX']['WWW_INDEX'])
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
    
    // increase amount of required memory if necessery
    increaseMemoryLimit(getMinimumRequiredMemory());
}

/**
 * Returns minimum required amount of memory for used PHP version
 *
 * @return integer  Required minimum amount of memory (in bytes)
 */
function getMinimumRequiredMemory()
{
    if (version_compare(phpversion(), '5.2.0', '>=')) {
        return $GLOBALS['_MAX']['REQUIRED_MEMORY']['PHP5'];
    }
    return $GLOBALS['_MAX']['REQUIRED_MEMORY']['PHP4'];
}

/**
 * Set a minimum amount of memory required by Openads
 *
 * @param integer $setMemory  A new memory limit (in bytes)
 * @return boolean  true if memory is already bigger or when an attempt to
 *                  set a memory was succesfull, else false
 */
function increaseMemoryLimit($setMemory) {

    $memory = getMemorySizeInBytes();
    if ($memory == -1) {
        // unlimited
        return true;
    }

    if ($setMemory > $memory) {
        if (ini_set('memory_limit', $setMemory) === false) {
            return false;
        }
    }
    return true;
}

/**
 * Check how much memory is available for php, converts it into bytes and returns.
 *
 * @param mixed $size The size to be converted
 * @return mixed
 */
function getMemorySizeInBytes() {
    $phpMemory = ini_get('memory_limit');
    if (empty($phpMemory)) {
        $phpMemory = get_cfg_var('memory_limit');
    }
    if (empty($phpMemory)) {
        // php is compiled without --enable-memory-limits
        return 0;
    }
    if ($phpMemory == -1) {
        // unlimited
        return $phpMemory;
    }
        
    $aSize = array(
        'G' => 1073741824,
        'M' => 1048576,
        'K' => 1024
    );
    $size = $phpMemory;
    foreach($aSize as $type => $multiplier) {
        $pos = strpos($phpMemory, $type);
        if (!$pos) {
            $pos = strpos($phpMemory, strtolower($type));
        }
        if ($pos) {
            $size = substr($phpMemory, 0, $pos) * $multiplier;
        }
    }
    return $size;
}

// Run the init() function
init();

require_once 'PEAR.php';

// Set $conf
$conf = $GLOBALS['_MAX']['CONF'];

?>
