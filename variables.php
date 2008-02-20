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
 * @package    MaxDelivery
 * @author     Chris Nutting <chris.nutting@openx.org>
 * @author     Andrew Hill <andrew.hill@openx.org>
 * @author     Radek Maciaszek <radek.maciaszek@openx.org>
 *
 * A file to set up the environment for the OpenX delivery engine.
 *
 * Both opcode and PHP by itself slow things down when we require many
 * files. Therefore maintainability has been sacrificed in order to
 * speed up a delivery:
 * - We are not using classes (if possible) in delivery;
 * - We have as few as possible includes and add new code into
 *   existing files.
 */


/**
 * Setup common variables - used by both delivery and admin part as well
 *
 * This function should be executed after the config file is read in.
 *
 * The reason behind using GLOBAL variables is that
 * there are faster than constants
 */
function setupConfigVariables()
{
    $GLOBALS['_MAX']['MAX_DELIVERY_MULTIPLE_DELIMITER'] = '|';
    $GLOBALS['_MAX']['MAX_COOKIELESS_PREFIX'] = '__';
    // Set the URL access mechanism
    if (!empty($GLOBALS['_MAX']['CONF']['openads']['requireSSL'])) {
        $GLOBALS['_MAX']['HTTP'] = 'https://';
    } else {
        if (isset($_SERVER['SERVER_PORT'])) {
            if (isset($GLOBALS['_MAX']['CONF']['openads']['sslPort'])
                && $_SERVER['SERVER_PORT'] == $GLOBALS['_MAX']['CONF']['openads']['sslPort'])
            {
                $GLOBALS['_MAX']['HTTP'] = 'https://';
            } else {
                $GLOBALS['_MAX']['HTTP'] = 'http://';
            }
        }
    }

    // Maximum random number (use default if doesn't exist - eg the case when application is upgraded)
    $GLOBALS['_MAX']['MAX_RAND'] = isset($GLOBALS['_MAX']['CONF']['priority']['randmax']) ?
        $GLOBALS['_MAX']['CONF']['priority']['randmax'] : 2147483647;

    // Always use UTC when outside the installer
    if (substr($_SERVER['SCRIPT_NAME'], -11) != 'install.php') {
        OA_setTimeZoneUTC();
    }
}

/**
 * A function to initialize $_SERVER variables which could be missing
 * on some environments
 *
 */
function setupServerVariables()
{
    // PHP-CGI/IIS combination does not set REQUEST_URI
    if (empty($_SERVER['REQUEST_URI'])) {
        $_SERVER['REQUEST_URI'] = $_SERVER['SCRIPT_NAME'];
        if (!empty($_SERVER['QUERY_STRING'])) {
            $_SERVER['REQUEST_URI'] .= '?' . $_SERVER['QUERY_STRING'];
        }
    }
}

/**
 * A function to initialize the environmental constants and global
 * variables required by delivery.
 */
function setupDeliveryConfigVariables()
{
    if (!defined('MAX_PATH')) {
        define('MAX_PATH', dirname(__FILE__));
    }
    // Ensure that the initialisation has not been run before
    if ( !(isset($GLOBALS['_MAX']['CONF']))) {
        // Parse the Max configuration file
        $GLOBALS['_MAX']['CONF'] = parseDeliveryIniFile();
    }

    // Set up the common configuration variables
    setupConfigVariables();
}

/**
 * Set a timezone location using the proper method for the user's PHP
 * version.
 *
 * Ensure that the TZ environment variable is set for PHP < 5.1.0, so
 * that PEAR::Date class knows which timezone we are in, and doesn't
 * screw up the dates after using the PEAR::compare() method; also,
 * ensure that an appropriate timezone is set, if required, to allow
 * the time zone to be other than the time zone of the server.
 *
 * @param string $timezone
 */
function OA_setTimeZone($timezone)
{
    if (version_compare(phpversion(), '5.1.0', '>=')) {
        // Set new time zone
        date_default_timezone_set($timezone);
    } else {
        // Set new time zone
        putenv("TZ={$timezone}");
    }

    // Set PEAR::Date_TimeZone default as well
    //
    // Ideally this should be a Date_TimeZone::setDefault() call, but for optimization
    // purposes, we just override the global variable
    $GLOBALS['_DATE_TIMEZONE_DEFAULT'] = $timezone;
}

/**
 * Set the current default timezone to UTC
 *
 * @see OA_setTimeZone()
 */
function OA_setTimeZoneUTC()
{
    OA_setTimeZone('UTC');
}

/**
 * Set the current default timezone to local
 *
 * @see OA_setTimeZone()
 */
function OA_setTimeZoneLocal()
{
    $tz = !empty($GLOBALS['_MAX']['PREF']['timezone']) ? $GLOBALS['_MAX']['PREF']['timezone'] : 'GMT';
    OA_setTimeZone($tz);
}

/**
 * Returns the hostname the script is running under.
 *
 * @return string containing the hostname (with port number stripped).
 */
function getHostName()
{
    if (!empty($_SERVER['HTTP_HOST'])) {
        $host = explode(':', $_SERVER['HTTP_HOST']);
        $host = $host[0];
    } else if (!empty($_SERVER['SERVER_NAME'])) {
        $host = explode(':', $_SERVER['SERVER_NAME']);
    	$host = $host[0];
    }
    return $host;
}

/**
 * Returns the hostname (with port) the script is running under.
 *
 * @return string containing the hostname with port
 */
function getHostNameWithPort()
{
    if (!empty($_SERVER['HTTP_HOST'])) {
        $host = $_SERVER['HTTP_HOST'];
    } else if (!empty($_SERVER['SERVER_NAME'])) {
    	$host = $_SERVER['SERVER_NAME'];
    }
    return $host;
}

/**
 * A function to define the PEAR include path in a separate method,
 * as it is required by delivery only in exceptional circumstances.
 */
function setupIncludePath()
{
    static $checkIfAlreadySet;
    if (isset($checkIfAlreadySet)) {
        return;
    }
    $checkIfAlreadySet = true;

    // Define the PEAR installation path
    $existingPearPath = ini_get('include_path');
    $newPearPath = MAX_PATH . DIRECTORY_SEPARATOR.'lib' . DIRECTORY_SEPARATOR . 'pear';
    if (!empty($existingPearPath)) {
        $newPearPath .= PATH_SEPARATOR . $existingPearPath;
    }
    if (!ereg("\.", $newPearPath)) {
        $newPearPath = '.'.PATH_SEPARATOR . $newPearPath;
    }
    ini_set('include_path', $newPearPath);
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
        if (@ini_set('memory_limit', $setMemory) === false) {
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
    if (empty($phpMemory) || $phpMemory == -1) {
        // unlimited
        return -1;
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

?>