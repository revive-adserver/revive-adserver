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
 * @package    MaxDelivery
 * @author     Chris Nutting <chris.nutting@openads.org>
 * @author     Andrew Hill <andrew.hill@openads.org>
 * @author     Radek Maciaszek <radek.maciaszek@openads.org>
 *
 * A file to set up the environment for the Openads delivery engine.
 * 
 * Both opcode and php by itself slow things down when we require many
 * files. Therefore we gave up a little bit of maintainability in 
 * order to speed up a delivery:
 * * We are not using classes (if possible) in delivery
 * * We have to use as few as possible includes and add new code into
 *   existing files
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
                && $_SERVER['SERVER_PORT'] == $maxGlobals['CONF']['openads']['sslPort']) 
            {
                $GLOBALS['_MAX']['HTTP'] = 'https://';
            } else {
                $GLOBALS['_MAX']['HTTP'] = 'http://';
            }
        }
    }
    
    // Maximum random number
    $GLOBALS['_MAX']['MAX_RAND'] = $GLOBALS['_MAX']['CONF']['priority']['randmax'];
    
    // set time zone, for more info @see setTimeZoneLocation()
    if (!empty($GLOBALS['_MAX']['CONF']['timezone']['location'])) {
        setTimeZoneLocation($GLOBALS['_MAX']['CONF']['timezone']['location']);
    }
}

/**
 * Set a timezone location using a proper method per php version
 *
 * Ensure that the TZ environment variable is set for PHP < 5.1.0, so
 * that PEAR::Date class knows which timezone we are in, and doesn't
 * screw up the dates after using the PEAR::compare() method -  also,
 * ensure that an appropriate timezone is set, if required, to allow
 * the time zone to be other than the time zone of the server
 * 
 * @param string $location  Time zone location
 */
function setTimeZoneLocation($location)
{
    if (version_compare(phpversion(), '5.1.0', '>=')) {
        // Set new time zone
        date_default_timezone_set($location);
    } else {
        // Set new time zone
        putenv("TZ={$location}");
    }
}

?>