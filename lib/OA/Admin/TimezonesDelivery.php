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
 * @package    OpenXDelivery
 * @author     Alexander J. Tarachanowicz II <aj@seagullproject.org>
 */

/**
 * A function to calculate the user's timezone from their
 * server environment, presuming that they have correctly
 * setup the timezone in their php.ini file, or with a
 * TZ environment variable.
 *
 * Designed for use ONLY within the delivery engine, as the
 * function is not as complete as the
 * OA_Admin_Timezones::getTimezone() method, which also
 * attempts to guess the timezone of the server when the
 * server's PHP environment has not been set up correctly.
 *
 * However, in the delivery engine, performace is more
 * important, and so this function is used instead.
 *
 * This method will ONLY work when there have been no
 * previous calls to date_default_timezone_set() or
 * putenv("TZ=...") to set the timezone manually.
 *
 * @return array An array of two items:
 *      'tz'         => The timezone string; and
 *      'calculated' => A boolean; true if the timezone
 *                      value needed to be calculated
 *                      when PHP < 5.1.0.
 */
function OA_Admin_TimezonesDelivery_getTimezone()
{
    $calculated = false;
    if (version_compare(phpversion(), '5.1.0', '>=')) {
        // Great! The PHP version is >= 5.1.0, so simply
        // use the built in date_default_timezone_get()
        // function, and know it's all good
        $tz = date_default_timezone_get();
    } else {
        // Boo, we have to rely on the dodgy old TZ
        // environment variable stuff
        $tz = getenv('TZ');
    }
    if ($tz === false || $tz === '') {
        // Could not calculate, return an empty array
        $aReturn = array();
        return $aReturn;

    }
    // Return the found timezone information
    $aReturn = array(
        'tz'         => $tz,
        'calculated' => $calculated
    );
    return $aReturn;
}

?>