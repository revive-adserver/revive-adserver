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
 * A class for retrieving a list of avaiable timezones, and for dealing with
 * preparing the timezone configuration value.
 *
 * @package    OpenXAdmin
 */
 class OX_Admin_Timezones
 {

    /**
     * Returns an array of available timezones.
     *
     * @static
     * @param boolean $addBlank If set to true an empty entry will be added
     *                          to the beginning of the array.
     * @return array An array containing all the available timezones.
     */
    static function availableTimezones($addBlank = false)
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
            'Etc/Zulu', 'Factory GB', 'GB', 'GB-Eire', 'GMT', 'GMT+0', 'GMT-0', 'GMT0', 'Greenwich',
            'Hongkong', 'HST', 'Iceland', 'Iran', 'Israel', 'Jamaica', 'Japan', 'Kwajalein',
            'Libya', 'MET', 'Mexico/BajaNorte', 'Mexico/BajaSur', 'Mexico/General',
            'MST', 'MST7MDT', 'Navajo', 'NZ', 'NZ-CHAT', 'Poland', 'Portugal', 'PRC',
            'PST8PDT', 'ROC', 'ROK', 'Singapore', 'Turkey', 'UCT', 'Universal', 'US/Alaska',
            'US/Aleutian', 'US/Arizona', 'US/Central', 'US/East-Indiana', 'US/Eastern',
            'US/Hawaii', 'US/Indiana-Starke', 'US/Michigan', 'US/Mountain', 'US/Pacific',
            'US/Pacific-New', 'US/Samoa', 'W-SU', 'WET', 'Zulu');

        // Load global array of timezones
        require_once MAX_PATH .'/lib/pear/Date/TimeZone.php';
        $aTimezoneKey = Date_TimeZone::getAvailableIDs();

        if (!defined('MAX_PATH')) {
            $tz = self::getTimezone();
        } else {
            $tz = $GLOBALS['_MAX']['PREF']['timezone'];
            if (is_null($tz)) {
                $tz = self::getTimezone();
            }
        }

        $tzSave = date_default_timezone_get();
        foreach ($aTimezoneKey as $key) {
            if (!@date_default_timezone_set($key)) continue;
            if ((in_array($tz, $_aTimezoneBcData) && $key == $tz) || !in_array($key, $_aTimezoneBcData)) {
                // Calculate the timezone offset
                $offset = self::_convertOffset($_DATE_TIMEZONE_DATA[$key]['offset']);
                // Build the arrays used for sorting time zones
                $origOffset = $_DATE_TIMEZONE_DATA[$key]['offset'];
                if ($origOffset >= 0) {
                    $aTimezone[$offset][$key] = "(GMT+$offset) $key";
                } else {
                    $aNegTimezone[$key] = "(GMT-$offset) $key";
                }
            }
        }
        date_default_timezone_set($tzSave);

        // Sort timezones with positive offsets descending, and negative
        // offests ascending.

        // Add initial empty key/value pair
        if ($addBlank) {
            $aResult[] = '';
        }

        // Sort time zones
        asort($aNegTimezone);

        // Reverse array element order while preserving alphabetical order
        $hasRun       = false;
        foreach ($aTimezone as $offset => $aValue) {
            if ($hasRun == false) {
                $aRevTimezone[] = $aValue;
                $hasRun = true;
            } else {
                array_unshift($aRevTimezone, $aValue);
            }
        }

        // Build the result array
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
    static function getTimezone()
    {
        return date_default_timezone_get();
    }

    /**
     * A method to calculate the timezone value to write out
     * to the configuration file, based on a user selected
     * timezone value.
     *
     * @static
     * @param string $tz        The user selected timezone value.
     * @param array  $aTimezone The result of a call to the
     *                          {@link OX_Admin_Timezones::getTimezone()}
     *                          method.
     * @return string The timezone value to write to the
     *                configuration file.
     */
    static function getConfigTimezoneValue($tz, $timezone)
    {
        if ($tz != $timezone) {
            // The user selected timezone is not equal to the
            // environment timezone, so, must write the user
            // selected value to the config file
            $return = $tz;
        } else {
            // The user selected timezone is the same as the
            // environment timezone, so we don't have to write the
            // timezone to the config file - it will be set
            // automatically by PHP.
            $return = '';
        }
        return $return;
    }

    /**
     * Convert an offset in milliseconds into human readable form (hours and minutes).
     *
     * @access private
     * @param float $offset A float in hours of the time zone offset (i.e. 9.5, 10.75)
     * @return string Human read able timezone offset
     */
    static function _convertOffset($offset)
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