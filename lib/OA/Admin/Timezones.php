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
$Id: Timezone.php 6032 2007-04-25 16:12:07Z aj@seagullproject.org $
*/

/**
 * A class for retrieving a list of avaiable timezones, and for dealing with
 * preparing the timezone configuration value.
 *
 * @package    OpenXAdmin
 * @author     Alexander J. Tarachanowicz II <aj@seagullproject.org>
 * @author     Andrew Hill <andrew.hill@openx.org>
 */
 class OA_Admin_Timezones
 {

    /**
     * Returns an array of available timezones.
     *
     * @static
     * @param boolean $addBlank If set to true an empty entry will be added
     *                          to the beginning of the array.
     * @return array An array containing all the available timezones.
     */
    function availableTimezones($addBlank = false)
    {
        global $_DATE_TIMEZONE_DATA;

        $_aTimezoneBcData = array(
            'Brazil/Acre', 'Brazil/DeNoronha', 'Brazil/East', 'Brazil/West', 'Canada/Atlantic',
            'Canada/Central', 'Canada/East-Saskatchewan', 'Canada/Eastern', 'Canada/Mountain',
            'Canada/Newfoundland', 'Canada/Pacific', 'Canada/Saskatchewan', 'Canada/Yukon',
            'CET', 'Chile/Continental', 'Chile/EasterIsland', 'CST6CDT', 'Cuba', 'EET',
            'Egypt', 'Eire', 'EST', 'EST5EDT', 'Etc/GMT', 'Etc/GMT+0', 'Etc/GMT+1', 'Etc/GMT+10',
            'Etc/GMT+11', 'Etc/GMT+12', 'Etc/GMT+2', 'Etc/GMT+3', 'Etc/GMT+4', 'Etc/GMT+5',
            'Etc/GMT+6', 'Etc/GMT+7', 'Etc/GMT+8', 'Etc/GMT+9', 'Etc/GMT-0', 'Etc/GMT-1',
            'Etc/GMT-10', 'Etc/GMT-11', 'Etc/GMT-12', 'Etc/GMT-13', 'Etc/GMT-14', 'Etc/GMT-2',
            'Etc/GMT-3', 'Etc/GMT-4', 'Etc/GMT-5', 'Etc/GMT-6', 'Etc/GMT-7', 'Etc/GMT-8',
            'Etc/GMT-9', 'Etc/GMT0', 'Etc/Greenwich', 'Etc/UCT', 'Etc/Universal', 'Etc/UTC',
            'Etc/Zulu', 'Factory GB', 'GB-Eire', 'GMT', 'GMT+0', 'GMT-0', 'GMT0', 'Greenwich',
            'Hongkong', 'HST', 'Iceland', 'Iran', 'Israel', 'Jamaica', 'Japan', 'Kwajalein',
            'Libya', 'MET', 'Mexico/BajaNorte', 'Mexico/BajaSur', 'Mexico/General',
            'MST', 'MST7MDT', 'Navajo', 'NZ', 'NZ-CHAT', 'Poland', 'Portugal', 'PRC',
            'PST8PDT', 'ROC', 'ROK', 'Singapore', 'Turkey', 'UCT', 'Universal', 'US/Alaska',
            'US/Aleutian', 'US/Arizona', 'US/Central', 'US/East-Indiana', 'US/Eastern',
            'US/Hawaii', 'US/Indiana-Starke', 'US/Michigan', 'US/Mountain', 'US/Pacific',
            'US/Pacific-New', 'US/Samoa', 'UTC', 'W-SU', 'WET', 'Zulu');

        // Load translations
        require_once MAX_PATH .'/lib/max/language/Loader.php';
        Language_Loader::load('timezone');

        // Load global array of timezones
        require_once MAX_PATH .'/lib/pear/Date/TimeZone.php';
        $aTimezoneKey = Date_TimeZone::getAvailableIDs();

        if (!defined('MAX_PATH')) {
            $aSysTimezone = OA_Admin_Timezones::getTimezone();
            $tz = $aSysTimezone['tz'];
        } else {
            $tz = $GLOBALS['_MAX']['PREF']['timezone'];
        }

        foreach ($aTimezoneKey as $key) {
            if ((in_array($tz, $_aTimezoneBcData) && $key == $tz)
                 || !in_array($key, $_aTimezoneBcData)) {
                //  calculate timezone offset
                $offset = OA_Admin_Timezones::_convertOffset($_DATE_TIMEZONE_DATA[$key]['offset']);
                //  build arrays used for sorting time zones
                $origOffset = $_DATE_TIMEZONE_DATA[$key]['offset'];
                $key = (!empty($GLOBALS['strTimezoneList'][$key])) ? $GLOBALS['strTimezoneList'][$key] : $key;
                if ($origOffset >= 0) {
                    $aTimezone[$offset][$key] = "(GMT+$offset) $key";
                } else {
                    $aNegTimezone[$key] = "(GMT-$offset) $key";
                }
            }
        }

        //  sort timezones with positive offset desc and negative offests asc
        // Add empty key/value pair
        if ($addBlank) {
            $aResult[] = '';
        }

        //  sort time zones
        asort($aNegTimezone);

        //  reverse array element order while preserving alphabetical order
        $hasRun       = false;
        foreach ($aTimezone as $offset => $aValue) {
            if ($hasRun == false) {
                $aRevTimezone[] = $aValue;
                $hasRun = true;
            } else {
                array_unshift($aRevTimezone, $aValue);
            }
        }

        //  build result array
        foreach($aRevTimezone as $aValue) {
            foreach ($aValue as $k => $v) {
                $aResult[$k] = $v;
            }
        }
        foreach ($aNegTimezone as $key => $value) {
            $aResult[$key] = $value;
        }

        return $aResult;
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
            if ($tz === false || $tz === '') {
                // Even worse! The user doesn't have a TZ
                // variable, so we have to try and calcuate
                // the timezone for the user
                $calculated = true;
                unset($tz);
                $diff = date('O');
                $diffSign = substr($diff, 0, 1);
                if ($diffSign == "+") {
                    $diffHour = (int) substr($diff, 1, 2) - date('I'); // minus 1 hour if date in DST
                } else {
                    $diffHour = (int) substr($diff, 1, 2) + date('I'); // add 1 hour if date in DST
                }
                $diffMin  = (int) substr($diff, 3, 2);
                $offset = (($diffHour * 60) + ($diffMin)) * 60 * 1000; // Milliseconds
                $offset = $diffSign . $offset;

                // Deliberately require via direct path, not using MAX_PATH,
                // as this method should be called before the ini scripts!
                global $_DATE_TIMEZONE_DATA;
                if (!isset($_DATE_TIMEZONE_DATA)) {
                    include(dirname(__FILE__).'/../../pear/Date/TimeZone.php');
                }
                reset($_DATE_TIMEZONE_DATA);
                foreach (array_keys($_DATE_TIMEZONE_DATA) as $key) {
                    if ($_DATE_TIMEZONE_DATA[$key]['offset'] == $offset) {
                        $tz = $key;
                        break;
                    }
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
     * A method to calculate the timezone value to write out
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
        } else if (($tz === $aTimezone['tz']) && ($aTimezone['calculated'] === true)) {
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

    /**
     * Convert an offset in milliseconds into human readable form (hours and minutes)
     *
     * @access private
     *
     * @param float $offset A float in hours of the time zone offset (i.e. 9.5, 10.75)
     * @return string       Human read able timezone offset
     */
    function _convertOffset($offset)
    {
        $offset = ((($offset / 1000 ) / 60 ) / 60);

        //  calculate offset hours
        $offsetHours = str_pad((int) abs($offset), 2, 0, STR_PAD_LEFT);

        // retrieve percentage and if only one character add ending 0
        $offsetMinutes = strstr($offset, '.');
        $offsetMinutes = (strlen($offsetMinutes) >= 2) ? $offsetMinutes : str_pad($offsetMinutes, 2, 0);

        //  caculate minutes
        $offsetMinutes = round((60 * $offsetMinutes), 0);

        //  if minutes < 2 characters add leading zero
        $offsetMinutes = str_pad(((int) $offsetMinutes), 2, 0, STR_PAD_LEFT);

        //  build offset
        $offset = $offsetHours . $offsetMinutes;

        return $offset;
    }
}

?>
