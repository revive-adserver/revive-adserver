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
$Id: Timezone.php 6032 2007-04-25 16:12:07Z aj@seagullproject.org $
*/

/**
 * A class for retrieving a list of avaiable timezone for the proper locale.
 *
 * @package    Openads
 * @author     Alexander J. Tarachanowicz II <aj@seagullproject.org>
 */
 class MAX_Admin_Timezones
 {

    /**
     * Returns an array of available timezones.
     *
     * @param boolean $addBlank If set to true an empty entry will be added
     *                          to the beginning of the array.
     * @return array An array containing all the available timezones.
     */
    function AvailableTimezones($addBlank = false)
    {
        //  load global array of timezones
        require_once MAX_PATH .'/lib/pear/Date/TimeZone.php';

        $aTimezoneKey = Date_TimeZone::getAvailableIDs();

        //  add empty key/value pair
        if ($addBlank) {
            $aTimezone[] = '';
        }

        foreach ($aTimezoneKey as $key) {
            $aTimezone[$key] = $key;
        }

        asort($aTimezone);

        return $aTimezone;
    }

    /**
     * A method to calculate the user's timezone from their
     * server environment.
     *
     * @static
     * @return array An array of two items:
     *      'tz'         => The timezone string; and
     *      'calculated' => A boolean; true if the timezone
     *                      value needed to be calculated
     *                      when PHP < 5.1.0.
     */
    function getTimezone()
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
            if ($tz === false) {
                // Even worse! The user doesn't have a TZ
                // variable, so we have to try and calcuate
                // the timezone for the user
                $diff = date('O') / 100;
                $tz = 'TZ=Etc/GMT'.($diff > 0 ? '-' : '+').abs($diff);
                $calculated = true;
            }
        }
        $aReturn = array(
            'tz'         => $tz,
            'calculated' => $calculated
        );
        return $aReturn;
    }
}