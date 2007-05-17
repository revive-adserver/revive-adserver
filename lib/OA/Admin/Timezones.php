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
 * A class for retrieving a list of avaiable timezones, and for dealing with
 * preparing the timezone configuration value.
 *
 * @package    OpenadsAdmin
 * @author     Alexander J. Tarachanowicz II <aj@seagullproject.org>
 * @author     Andrew Hill <andrew@openads.org>
 */
 class OA_Admin_Timezones
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
        // Load global array of timezones
        require_once MAX_PATH .'/lib/pear/Date/TimeZone.php';
        $aTimezoneKey = Date_TimeZone::getAvailableIDs();
        // Add empty key/value pair
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
     * This method will ONLY work when there have been no
     * previous calls to date_default_timezone_set() or
     * putenv("TZ=...") to set the timezone manually.
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
                $calculated = true;
                unset($tz);
                $diff = date('O');
                $diffSign = substr($diff, 0, 1);
                $diffHour = (int) substr($diff, 1, 2);
                $diffMin  = (int) substr($diff, 3, 2);
                if ($diffMin != 0) {
                    // Dang. Half-hour offsets can't be done
                    // via a GMT offset. Guess!
                    $offset = (($diffHour * 60) + ($diffMin)) * 60 * 1000; // Milliseconds
                    // Deliberately require via direct path, not using MAX_PATH,
                    // as this method should be called before the ini scripts!
                    require_once '../../lib/pear/Date/TimeZone.php';
                    global $_DATE_TIMEZONE_DATA;
                    reset($_DATE_TIMEZONE_DATA);
                    foreach (array_keys($_DATE_TIMEZONE_DATA) as $key) {
                        if ($_DATE_TIMEZONE_DATA[$key]['offset'] == $offset) {
                            $tz = $key;
                            break;
                        }
                    }
                }
                if (!isset($tz)) {
                    // Just set the time zone as an offset from GMT
                    $tz = 'Etc/GMT'. $diffSign . $diffHour;
                }
            }
        }
        $aReturn = array(
            'tz'         => $tz,
            'calculated' => $calculated
        );
        return $aReturn;
    }

    /**
     * A method to calculate the timezon value to write out
     * to the configuration file, based on a user selected
     * timezone value.
     *
     * @static
     * @param string $tz        The user selected timezone value.
     * @param array  $aTimezone The result of a call to the
     *                          {@link OA_Admin_Timezones::getTimezone()}
     *                          method.
     * @return string The timezone value to write to the
     *                configuration file.
     */
    function getConfigTimezoneValue($tz, $aTimezone)
    {
        if ($tz != $aTimezone['tz']) {
            // The user selected timezone is not equal to the
            // environment timezone, so, must write the user
            // selected value to the config file
            $return = $tz;
        } else if (($tz === $aTimezone['tz']) && ($aTimezone['generated'] === true)) {
            // The user selected timezone is the same as the
            // environment timezone, however, the environment
            // timezone has been generated, so must write the
            // user selected value to the config file to avoid
            // the getenv/putenv call every time we init
            $return = $tz;
        } else {
            // The user selected timezone is the same as the
            // environment timezone, and the enviroment timezone
            // is not generated, so we don't have to write the
            // timezone to the config file - it will be set
            // automatically by PHP.
            $return = '';
        }
        return $return;
    }

}