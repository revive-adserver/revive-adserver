<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
//
// +----------------------------------------------------------------------+
// | PHP Version 4                                                        |
// +----------------------------------------------------------------------+
// | Copyright (c) 1997-2003 The PHP Group                                |
// +----------------------------------------------------------------------+
// | This source file is subject to version 2.02 of the PHP license,      |
// | that is bundled with this package in the file LICENSE, and is        |
// | available at through the world-wide-web at                           |
// | http://www.php.net/license/2_02.txt.                                 |
// | If you did not receive a copy of the PHP license and are unable to   |
// | obtain it through the world-wide-web, please send a note to          |
// | license@php.net so we can mail you a copy immediately.               |
// +----------------------------------------------------------------------+
// | Authors: Baba Buehler <baba@babaz.com>                               |
// |                                                                      |
// +----------------------------------------------------------------------+
//
// $Id$
//
// Date_TimeZone Class
//

/**
 * TimeZone representation class, along with time zone information data.
 *
 * TimeZone representation class, along with time zone information data.
 * The default timezone is set from the first valid timezone id found
 * in one of the following places, in this order: <br>
 * 1) global $_DATE_TIMEZONE_DEFAULT<br>
 * 2) system environment variable PHP_TZ<br>
 * 3) system environment variable TZ<br>
 * 4) the result of date('T')<br>
 * If no valid timezone id is found, the default timezone is set to 'UTC'.
 * You may also manually set the default timezone by passing a valid id to
 * Date_TimeZone::setDefault().<br>
 *
 * This class includes time zone data (from zoneinfo) in the form of a global array, $_DATE_TIMEZONE_DATA.
 *
 *
 * @author Baba Buehler <baba@babaz.com>
 * @package Date
 * @access public
 * @version 1.0
 */
class Date_TimeZone
{
    /**
     * Time Zone ID of this time zone
     * @var string
     */
    var $id;
    /**
     * Long Name of this time zone (ie Central Standard Time)
     * @var string
     */
    var $longname;
    /**
     * Short Name of this time zone (ie CST)
     * @var string
     */
    var $shortname;
    /**
     * true if this time zone observes daylight savings time
     * @var boolean
     */
    var $hasdst;
    /**
     * DST Long Name of this time zone
     * @var string
     */
    var $dstlongname;
    /**
     * DST Short Name of this timezone
     * @var string
     */
    var $dstshortname;
    /**
     * offset, in milliseconds, of this timezone
     * @var int
     */
    var $offset;

    /**
     * System Default Time Zone
     * @var object Date_TimeZone
     */
    var $default;


    /**
     * Constructor
     *
     * Creates a new Date::TimeZone object, representing the time zone
     * specified in $id.  If the supplied ID is invalid, the created
     * time zone is UTC.
     *
     * @access public
     * @param string $id the time zone id
     * @return object Date_TimeZone the new Date_TimeZone object
     */
    function Date_TimeZone($id)
    {
        global $_DATE_TIMEZONE_DATA;
        if(Date_TimeZone::isValidID($id)) {
            $this->id = $id;
            $this->longname = $_DATE_TIMEZONE_DATA[$id]['longname'];
            $this->shortname = $_DATE_TIMEZONE_DATA[$id]['shortname'];
            $this->offset = $_DATE_TIMEZONE_DATA[$id]['offset'];
            if($_DATE_TIMEZONE_DATA[$id]['hasdst']) {
                $this->hasdst = true;
                $this->dstlongname = $_DATE_TIMEZONE_DATA[$id]['dstlongname'];
                $this->dstshortname = $_DATE_TIMEZONE_DATA[$id]['dstshortname'];
            } else {
                $this->hasdst = false;
                $this->dstlongname = $this->longname;
                $this->dstshortname = $this->shortname;
            }
        } else {
            $this->id = 'UTC';
            $this->longname = $_DATE_TIMEZONE_DATA[$this->id]['longname'];
            $this->shortname = $_DATE_TIMEZONE_DATA[$this->id]['shortname'];
            $this->hasdst = $_DATE_TIMEZONE_DATA[$this->id]['hasdst'];
            $this->offset = $_DATE_TIMEZONE_DATA[$this->id]['offset'];
        }
    }

    /**
     * Return a TimeZone object representing the system default time zone
     *
     * Return a TimeZone object representing the system default time zone,
     * which is initialized during the loading of TimeZone.php.
     *
     * @access public
     * @return object Date_TimeZone the default time zone
     */
    function getDefault()
    {
        global $_DATE_TIMEZONE_DEFAULT;
        return new Date_TimeZone($_DATE_TIMEZONE_DEFAULT);
    }

    /**
     * Sets the system default time zone to the time zone in $id
     *
     * Sets the system default time zone to the time zone in $id
     *
     * @access public
     * @param string $id the time zone id to use
     */
    function setDefault($id)
    {
        global $_DATE_TIMEZONE_DEFAULT;
        if(Date_TimeZone::isValidID($id)) {
            $_DATE_TIMEZONE_DEFAULT = $id;
        }
    }

    /**
     * Tests if given id is represented in the $_DATE_TIMEZONE_DATA time zone data
     *
     * Tests if given id is represented in the $_DATE_TIMEZONE_DATA time zone data
     *
     * @access public
     * @param string $id the id to test
     * @return boolean true if the supplied ID is valid
     */
    function isValidID($id)
    {
        global $_DATE_TIMEZONE_DATA;
        if(isset($_DATE_TIMEZONE_DATA[$id])) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Is this time zone equal to another
     *
     * Tests to see if this time zone is equal (ids match)
     * to a given Date_TimeZone object.
     *
     * @access public
     * @param object Date_TimeZone $tz the timezone to test
     * @return boolean true if this time zone is equal to the supplied time zone
     */
    function isEqual($tz)
    {
        if(strcasecmp($this->id, $tz->id) == 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Is this time zone equivalent to another
     *
     * Tests to see if this time zone is equivalent to
     * a given time zone object.  Equivalence in this context
     * is defined by the two time zones having an equal raw
     * offset and an equal setting of "hasdst".  This is not true
     * equivalence, as the two time zones may have different rules
     * for the observance of DST, but this implementation does not
     * know DST rules.
     *
     * @access public
     * @param object Date_TimeZone $tz the timezone object to test
     * @return boolean true if this time zone is equivalent to the supplied time zone
     */
    function isEquivalent($tz)
    {
        if($this->offset == $tz->offset && $this->hasdst == $tz->hasdst) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Returns true if this zone observes daylight savings time
     *
     * Returns true if this zone observes daylight savings time
     *
     * @access public
     * @return boolean true if this time zone has DST
     */
    function hasDaylightTime()
    {
        return $this->hasdst;
    }

    /**
     * Is the given date/time in DST for this time zone
     *
     * Attempts to determine if a given Date object represents a date/time
     * that is in DST for this time zone.  WARNINGS: this basically attempts to
     * "trick" the system into telling us if we're in DST for a given time zone.
     * This uses putenv() which may not work in safe mode, and relies on unix time
     * which is only valid for dates from 1970 to ~2038.  This relies on the
     * underlying OS calls, so it may not work on Windows or on a system where
     * zoneinfo is not installed or configured properly.
     *
     * @access public
     * @param object Date $date the date/time to test
     * @return boolean true if this date is in DST for this time zone
     */
    function inDaylightTime($date)
    {
        if (is_callable('date_default_timezone_set')) {
            $env_tz = date_default_timezone_get();
            date_default_timezone_set($this->id);
            $ltime = localtime($date->getTime(), true);
            date_default_timezone_set($env_tz);
        } else {
            $env_tz = "";
            if(getenv("TZ")) {
                $env_tz = getenv("TZ");
            }
            putenv("TZ=".$this->id);
            $ltime = localtime($date->getTime(), true);
            putenv("TZ=".$env_tz);
        }
        return $ltime['tm_isdst'];
    }

    /**
     * Get the DST offset for this time zone
     *
     * Returns the DST offset of this time zone, in milliseconds,
     * if the zone observes DST, zero otherwise.  Currently the
     * DST offset is hard-coded to one hour.
     *
     * @access public
     * @return int the DST offset, in milliseconds or zero if the zone does not observe DST
     */
    function getDSTSavings()
    {
        if($this->hasdst) {
            return 3600000;
        } else {
            return 0;
        }
    }

    /**
     * Get the DST-corrected offset to UTC for the given date
     *
     * Attempts to get the offset to UTC for a given date/time, taking into
     * account daylight savings time, if the time zone observes it and if
     * it is in effect.  Please see the WARNINGS on Date::TimeZone::inDaylightTime().
     *
     *
     * @access public
     * @param object Date $date the Date to test
     * @return int the corrected offset to UTC in milliseconds
     */
    function getOffset($date)
    {
        if($this->inDaylightTime($date)) {
            return $this->offset + $this->getDSTSavings();
        } else {
            return $this->offset;
        }
    }

    /**
     * Returns the list of valid time zone id strings
     *
     * Returns the list of valid time zone id strings
     *
     * @access public
     * @return mixed an array of strings with the valid time zone IDs
     */
    function getAvailableIDs()
    {
        global $_DATE_TIMEZONE_DATA;
        return array_keys($_DATE_TIMEZONE_DATA);
    }

    /**
     * Returns the id for this time zone
     *
     * Returns the time zone id  for this time zone, i.e. "America/Chicago"
     *
     * @access public
     * @return string the id
     */
    function getID()
    {
        return $this->id;
    }

    /**
     * Returns the long name for this time zone
     *
     * Returns the long name for this time zone,
     * i.e. "Central Standard Time"
     *
     * @access public
     * @return string the long name
     */
    function getLongName()
    {
        return $this->longname;
    }

    /**
     * Returns the short name for this time zone
     *
     * Returns the short name for this time zone, i.e. "CST"
     *
     * @access public
     * @return string the short name
     */
    function getShortName()
    {
        return $this->shortname;
    }

    /**
     * Returns the DST long name for this time zone
     *
     * Returns the DST long name for this time zone, i.e. "Central Daylight Time"
     *
     * @access public
     * @return string the daylight savings time long name
     */
    function getDSTLongName()
    {
        return $this->dstlongname;
    }

    /**
     * Returns the DST short name for this time zone
     *
     * Returns the DST short name for this time zone, i.e. "CDT"
     *
     * @access public
     * @return string the daylight savings time short name
     */
    function getDSTShortName()
    {
        return $this->dstshortname;
    }

    /**
     * Returns the raw (non-DST-corrected) offset from UTC/GMT for this time zone
     *
     * Returns the raw (non-DST-corrected) offset from UTC/GMT for this time zone
     *
     * @access public
     * @return int the offset, in milliseconds
     */
    function getRawOffset()
    {
        return $this->offset;
    }

} // Date_TimeZone


//
// Time Zone Data
//  offset is in miliseconds
//
$GLOBALS['_DATE_TIMEZONE_DATA'] = array(
    'Etc/GMT+12' => array(
        'offset' => -43200000,
        'longname' => "GMT-12:00",
        'shortname' => 'GMT-12:00',
        'hasdst' => false ),
    'Etc/GMT+11' => array(
        'offset' => -39600000,
        'longname' => "GMT-11:00",
        'shortname' => 'GMT-11:00',
        'hasdst' => false ),
    'MIT' => array(
        'offset' => -39600000,
        'longname' => "West Samoa Time",
        'shortname' => 'WST',
        'hasdst' => false ),
    'Pacific/Apia' => array(
        'offset' => -39600000,
        'longname' => "West Samoa Time",
        'shortname' => 'WST',
        'hasdst' => false ),
    'Pacific/Midway' => array(
        'offset' => -39600000,
        'longname' => "Samoa Standard Time",
        'shortname' => 'SST',
        'hasdst' => false ),
    'Pacific/Niue' => array(
        'offset' => -39600000,
        'longname' => "Niue Time",
        'shortname' => 'NUT',
        'hasdst' => false ),
    'Pacific/Pago_Pago' => array(
        'offset' => -39600000,
        'longname' => "Samoa Standard Time",
        'shortname' => 'SST',
        'hasdst' => false ),
    'Pacific/Samoa' => array(
        'offset' => -39600000,
        'longname' => "Samoa Standard Time",
        'shortname' => 'SST',
        'hasdst' => false ),
    'US/Samoa' => array(
        'offset' => -39600000,
        'longname' => "Samoa Standard Time",
        'shortname' => 'SST',
        'hasdst' => false ),
    'America/Adak' => array(
        'offset' => -36000000,
        'longname' => "Hawaii-Aleutian Standard Time",
        'shortname' => 'HAST',
        'hasdst' => true,
        'dstlongname' => "Hawaii-Aleutian Daylight Time",
        'dstshortname' => 'HADT' ),
    'America/Atka' => array(
        'offset' => -36000000,
        'longname' => "Hawaii-Aleutian Standard Time",
        'shortname' => 'HAST',
        'hasdst' => true,
        'dstlongname' => "Hawaii-Aleutian Daylight Time",
        'dstshortname' => 'HADT' ),
    'Etc/GMT+10' => array(
        'offset' => -36000000,
        'longname' => "GMT-10:00",
        'shortname' => 'GMT-10:00',
        'hasdst' => false ),
    'HST' => array(
        'offset' => -36000000,
        'longname' => "Hawaii Standard Time",
        'shortname' => 'HST',
        'hasdst' => false ),
    'Pacific/Fakaofo' => array(
        'offset' => -36000000,
        'longname' => "Tokelau Time",
        'shortname' => 'TKT',
        'hasdst' => false ),
    'Pacific/Honolulu' => array(
        'offset' => -36000000,
        'longname' => "Hawaii Standard Time",
        'shortname' => 'HST',
        'hasdst' => false ),
    'Pacific/Johnston' => array(
        'offset' => -36000000,
        'longname' => "Hawaii Standard Time",
        'shortname' => 'HST',
        'hasdst' => false ),
    'Pacific/Rarotonga' => array(
        'offset' => -36000000,
        'longname' => "Cook Is. Time",
        'shortname' => 'CKT',
        'hasdst' => false ),
    'Pacific/Tahiti' => array(
        'offset' => -36000000,
        'longname' => "Tahiti Time",
        'shortname' => 'TAHT',
        'hasdst' => false ),
    'SystemV/HST10' => array(
        'offset' => -36000000,
        'longname' => "Hawaii Standard Time",
        'shortname' => 'HST',
        'hasdst' => false ),
    'US/Aleutian' => array(
        'offset' => -36000000,
        'longname' => "Hawaii-Aleutian Standard Time",
        'shortname' => 'HAST',
        'hasdst' => true,
        'dstlongname' => "Hawaii-Aleutian Daylight Time",
        'dstshortname' => 'HADT' ),
    'US/Hawaii' => array(
        'offset' => -36000000,
        'longname' => "Hawaii Standard Time",
        'shortname' => 'HST',
        'hasdst' => false ),
    'Pacific/Marquesas' => array(
        'offset' => -34200000,
        'longname' => "Marquesas Time",
        'shortname' => 'MART',
        'hasdst' => false ),
    'AST' => array(
        'offset' => -32400000,
        'longname' => "Alaska Standard Time",
        'shortname' => 'AKST',
        'hasdst' => true,
        'dstlongname' => "Alaska Daylight Time",
        'dstshortname' => 'AKDT' ),
    'America/Anchorage' => array(
        'offset' => -32400000,
        'longname' => "Alaska Standard Time",
        'shortname' => 'AKST',
        'hasdst' => true,
        'dstlongname' => "Alaska Daylight Time",
        'dstshortname' => 'AKDT' ),
    'America/Juneau' => array(
        'offset' => -32400000,
        'longname' => "Alaska Standard Time",
        'shortname' => 'AKST',
        'hasdst' => true,
        'dstlongname' => "Alaska Daylight Time",
        'dstshortname' => 'AKDT' ),
    'America/Nome' => array(
        'offset' => -32400000,
        'longname' => "Alaska Standard Time",
        'shortname' => 'AKST',
        'hasdst' => true,
        'dstlongname' => "Alaska Daylight Time",
        'dstshortname' => 'AKDT' ),
    'America/Yakutat' => array(
        'offset' => -32400000,
        'longname' => "Alaska Standard Time",
        'shortname' => 'AKST',
        'hasdst' => true,
        'dstlongname' => "Alaska Daylight Time",
        'dstshortname' => 'AKDT' ),
    'Etc/GMT+9' => array(
        'offset' => -32400000,
        'longname' => "GMT-09:00",
        'shortname' => 'GMT-09:00',
        'hasdst' => false ),
    'Pacific/Gambier' => array(
        'offset' => -32400000,
        'longname' => "Gambier Time",
        'shortname' => 'GAMT',
        'hasdst' => false ),
    'SystemV/YST9' => array(
        'offset' => -32400000,
        'longname' => "Gambier Time",
        'shortname' => 'GAMT',
        'hasdst' => false ),
    'SystemV/YST9YDT' => array(
        'offset' => -32400000,
        'longname' => "Alaska Standard Time",
        'shortname' => 'AKST',
        'hasdst' => true,
        'dstlongname' => "Alaska Daylight Time",
        'dstshortname' => 'AKDT' ),
    'US/Alaska' => array(
        'offset' => -32400000,
        'longname' => "Alaska Standard Time",
        'shortname' => 'AKST',
        'hasdst' => true,
        'dstlongname' => "Alaska Daylight Time",
        'dstshortname' => 'AKDT' ),
    'America/Dawson' => array(
        'offset' => -28800000,
        'longname' => "Pacific Standard Time",
        'shortname' => 'PST',
        'hasdst' => true,
        'dstlongname' => "Pacific Daylight Time",
        'dstshortname' => 'PDT' ),
    'America/Ensenada' => array(
        'offset' => -28800000,
        'longname' => "Pacific Standard Time",
        'shortname' => 'PST',
        'hasdst' => true,
        'dstlongname' => "Pacific Daylight Time",
        'dstshortname' => 'PDT' ),
    'America/Los_Angeles' => array(
        'offset' => -28800000,
        'longname' => "Pacific Standard Time",
        'shortname' => 'PST',
        'hasdst' => true,
        'dstlongname' => "Pacific Daylight Time",
        'dstshortname' => 'PDT' ),
    'America/Tijuana' => array(
        'offset' => -28800000,
        'longname' => "Pacific Standard Time",
        'shortname' => 'PST',
        'hasdst' => true,
        'dstlongname' => "Pacific Daylight Time",
        'dstshortname' => 'PDT' ),
    'America/Vancouver' => array(
        'offset' => -28800000,
        'longname' => "Pacific Standard Time",
        'shortname' => 'PST',
        'hasdst' => true,
        'dstlongname' => "Pacific Daylight Time",
        'dstshortname' => 'PDT' ),
    'America/Whitehorse' => array(
        'offset' => -28800000,
        'longname' => "Pacific Standard Time",
        'shortname' => 'PST',
        'hasdst' => true,
        'dstlongname' => "Pacific Daylight Time",
        'dstshortname' => 'PDT' ),
    'Canada/Pacific' => array(
        'offset' => -28800000,
        'longname' => "Pacific Standard Time",
        'shortname' => 'PST',
        'hasdst' => true,
        'dstlongname' => "Pacific Daylight Time",
        'dstshortname' => 'PDT' ),
    'Canada/Yukon' => array(
        'offset' => -28800000,
        'longname' => "Pacific Standard Time",
        'shortname' => 'PST',
        'hasdst' => true,
        'dstlongname' => "Pacific Daylight Time",
        'dstshortname' => 'PDT' ),
    'Etc/GMT+8' => array(
        'offset' => -28800000,
        'longname' => "GMT-08:00",
        'shortname' => 'GMT-08:00',
        'hasdst' => false ),
    'Mexico/BajaNorte' => array(
        'offset' => -28800000,
        'longname' => "Pacific Standard Time",
        'shortname' => 'PST',
        'hasdst' => true,
        'dstlongname' => "Pacific Daylight Time",
        'dstshortname' => 'PDT' ),
    'PST' => array(
        'offset' => -28800000,
        'longname' => "Pacific Standard Time",
        'shortname' => 'PST',
        'hasdst' => true,
        'dstlongname' => "Pacific Daylight Time",
        'dstshortname' => 'PDT' ),
    'PST8PDT' => array(
        'offset' => -28800000,
        'longname' => "Pacific Standard Time",
        'shortname' => 'PST',
        'hasdst' => true,
        'dstlongname' => "Pacific Daylight Time",
        'dstshortname' => 'PDT' ),
    'Pacific/Pitcairn' => array(
        'offset' => -28800000,
        'longname' => "Pitcairn Standard Time",
        'shortname' => 'PST',
        'hasdst' => false ),
    'SystemV/PST8' => array(
        'offset' => -28800000,
        'longname' => "Pitcairn Standard Time",
        'shortname' => 'PST',
        'hasdst' => false ),
    'SystemV/PST8PDT' => array(
        'offset' => -28800000,
        'longname' => "Pacific Standard Time",
        'shortname' => 'PST',
        'hasdst' => true,
        'dstlongname' => "Pacific Daylight Time",
        'dstshortname' => 'PDT' ),
    'US/Pacific' => array(
        'offset' => -28800000,
        'longname' => "Pacific Standard Time",
        'shortname' => 'PST',
        'hasdst' => true,
        'dstlongname' => "Pacific Daylight Time",
        'dstshortname' => 'PDT' ),
    'US/Pacific-New' => array(
        'offset' => -28800000,
        'longname' => "Pacific Standard Time",
        'shortname' => 'PST',
        'hasdst' => true,
        'dstlongname' => "Pacific Daylight Time",
        'dstshortname' => 'PDT' ),
    'America/Boise' => array(
        'offset' => -25200000,
        'longname' => "Mountain Standard Time",
        'shortname' => 'MST',
        'hasdst' => true,
        'dstlongname' => "Mountain Daylight Time",
        'dstshortname' => 'MDT' ),
    'America/Cambridge_Bay' => array(
        'offset' => -25200000,
        'longname' => "Mountain Standard Time",
        'shortname' => 'MST',
        'hasdst' => true,
        'dstlongname' => "Mountain Daylight Time",
        'dstshortname' => 'MDT' ),
    'America/Chihuahua' => array(
        'offset' => -25200000,
        'longname' => "Mountain Standard Time",
        'shortname' => 'MST',
        'hasdst' => true,
        'dstlongname' => "Mountain Daylight Time",
        'dstshortname' => 'MDT' ),
    'America/Dawson_Creek' => array(
        'offset' => -25200000,
        'longname' => "Mountain Standard Time",
        'shortname' => 'MST',
        'hasdst' => false ),
    'America/Denver' => array(
        'offset' => -25200000,
        'longname' => "Mountain Standard Time",
        'shortname' => 'MST',
        'hasdst' => true,
        'dstlongname' => "Mountain Daylight Time",
        'dstshortname' => 'MDT' ),
    'America/Edmonton' => array(
        'offset' => -25200000,
        'longname' => "Mountain Standard Time",
        'shortname' => 'MST',
        'hasdst' => true,
        'dstlongname' => "Mountain Daylight Time",
        'dstshortname' => 'MDT' ),
    'America/Hermosillo' => array(
        'offset' => -25200000,
        'longname' => "Mountain Standard Time",
        'shortname' => 'MST',
        'hasdst' => false ),
    'America/Inuvik' => array(
        'offset' => -25200000,
        'longname' => "Mountain Standard Time",
        'shortname' => 'MST',
        'hasdst' => true,
        'dstlongname' => "Mountain Daylight Time",
        'dstshortname' => 'MDT' ),
    'America/Mazatlan' => array(
        'offset' => -25200000,
        'longname' => "Mountain Standard Time",
        'shortname' => 'MST',
        'hasdst' => true,
        'dstlongname' => "Mountain Daylight Time",
        'dstshortname' => 'MDT' ),
    'America/Phoenix' => array(
        'offset' => -25200000,
        'longname' => "Mountain Standard Time",
        'shortname' => 'MST',
        'hasdst' => false ),
    'America/Shiprock' => array(
        'offset' => -25200000,
        'longname' => "Mountain Standard Time",
        'shortname' => 'MST',
        'hasdst' => true,
        'dstlongname' => "Mountain Daylight Time",
        'dstshortname' => 'MDT' ),
    'America/Yellowknife' => array(
        'offset' => -25200000,
        'longname' => "Mountain Standard Time",
        'shortname' => 'MST',
        'hasdst' => true,
        'dstlongname' => "Mountain Daylight Time",
        'dstshortname' => 'MDT' ),
    'Canada/Mountain' => array(
        'offset' => -25200000,
        'longname' => "Mountain Standard Time",
        'shortname' => 'MST',
        'hasdst' => true,
        'dstlongname' => "Mountain Daylight Time",
        'dstshortname' => 'MDT' ),
    'Etc/GMT+7' => array(
        'offset' => -25200000,
        'longname' => "GMT-07:00",
        'shortname' => 'GMT-07:00',
        'hasdst' => false ),
    'MST' => array(
        'offset' => -25200000,
        'longname' => "Mountain Standard Time",
        'shortname' => 'MST',
        'hasdst' => true,
        'dstlongname' => "Mountain Daylight Time",
        'dstshortname' => 'MDT' ),
    'MST7MDT' => array(
        'offset' => -25200000,
        'longname' => "Mountain Standard Time",
        'shortname' => 'MST',
        'hasdst' => true,
        'dstlongname' => "Mountain Daylight Time",
        'dstshortname' => 'MDT' ),
    'Mexico/BajaSur' => array(
        'offset' => -25200000,
        'longname' => "Mountain Standard Time",
        'shortname' => 'MST',
        'hasdst' => true,
        'dstlongname' => "Mountain Daylight Time",
        'dstshortname' => 'MDT' ),
    'Navajo' => array(
        'offset' => -25200000,
        'longname' => "Mountain Standard Time",
        'shortname' => 'MST',
        'hasdst' => true,
        'dstlongname' => "Mountain Daylight Time",
        'dstshortname' => 'MDT' ),
    'PNT' => array(
        'offset' => -25200000,
        'longname' => "Mountain Standard Time",
        'shortname' => 'MST',
        'hasdst' => false ),
    'SystemV/MST7' => array(
        'offset' => -25200000,
        'longname' => "Mountain Standard Time",
        'shortname' => 'MST',
        'hasdst' => false ),
    'SystemV/MST7MDT' => array(
        'offset' => -25200000,
        'longname' => "Mountain Standard Time",
        'shortname' => 'MST',
        'hasdst' => true,
        'dstlongname' => "Mountain Daylight Time",
        'dstshortname' => 'MDT' ),
    'US/Arizona' => array(
        'offset' => -25200000,
        'longname' => "Mountain Standard Time",
        'shortname' => 'MST',
        'hasdst' => false ),
    'US/Mountain' => array(
        'offset' => -25200000,
        'longname' => "Mountain Standard Time",
        'shortname' => 'MST',
        'hasdst' => true,
        'dstlongname' => "Mountain Daylight Time",
        'dstshortname' => 'MDT' ),
    'America/Belize' => array(
        'offset' => -21600000,
        'longname' => "Central Standard Time",
        'shortname' => 'CST',
        'hasdst' => false ),
    'America/Cancun' => array(
        'offset' => -21600000,
        'longname' => "Central Standard Time",
        'shortname' => 'CST',
        'hasdst' => true,
        'dstlongname' => "Central Daylight Time",
        'dstshortname' => 'CDT' ),
    'America/Chicago' => array(
        'offset' => -21600000,
        'longname' => "Central Standard Time",
        'shortname' => 'CST',
        'hasdst' => true,
        'dstlongname' => "Central Daylight Time",
        'dstshortname' => 'CDT' ),
    'America/Costa_Rica' => array(
        'offset' => -21600000,
        'longname' => "Central Standard Time",
        'shortname' => 'CST',
        'hasdst' => false ),
    'America/El_Salvador' => array(
        'offset' => -21600000,
        'longname' => "Central Standard Time",
        'shortname' => 'CST',
        'hasdst' => false ),
    'America/Guatemala' => array(
        'offset' => -21600000,
        'longname' => "Central Standard Time",
        'shortname' => 'CST',
        'hasdst' => false ),
    'America/Managua' => array(
        'offset' => -21600000,
        'longname' => "Central Standard Time",
        'shortname' => 'CST',
        'hasdst' => false ),
    'America/Menominee' => array(
        'offset' => -21600000,
        'longname' => "Central Standard Time",
        'shortname' => 'CST',
        'hasdst' => true,
        'dstlongname' => "Central Daylight Time",
        'dstshortname' => 'CDT' ),
    'America/Merida' => array(
        'offset' => -21600000,
        'longname' => "Central Standard Time",
        'shortname' => 'CST',
        'hasdst' => true,
        'dstlongname' => "Central Daylight Time",
        'dstshortname' => 'CDT' ),
    'America/Mexico_City' => array(
        'offset' => -21600000,
        'longname' => "Central Standard Time",
        'shortname' => 'CST',
        'hasdst' => false ),
    'America/Monterrey' => array(
        'offset' => -21600000,
        'longname' => "Central Standard Time",
        'shortname' => 'CST',
        'hasdst' => true,
        'dstlongname' => "Central Daylight Time",
        'dstshortname' => 'CDT' ),
    'America/North_Dakota/Center' => array(
        'offset' => -21600000,
        'longname' => "Central Standard Time",
        'shortname' => 'CST',
        'hasdst' => true,
        'dstlongname' => "Central Daylight Time",
        'dstshortname' => 'CDT' ),
    'America/Rainy_River' => array(
        'offset' => -21600000,
        'longname' => "Central Standard Time",
        'shortname' => 'CST',
        'hasdst' => true,
        'dstlongname' => "Central Daylight Time",
        'dstshortname' => 'CDT' ),
    'America/Rankin_Inlet' => array(
        'offset' => -21600000,
        'longname' => "Eastern Standard Time",
        'shortname' => 'EST',
        'hasdst' => true,
        'dstlongname' => "Eastern Daylight Time",
        'dstshortname' => 'EDT' ),
    'America/Regina' => array(
        'offset' => -21600000,
        'longname' => "Central Standard Time",
        'shortname' => 'CST',
        'hasdst' => false ),
    'America/Swift_Current' => array(
        'offset' => -21600000,
        'longname' => "Central Standard Time",
        'shortname' => 'CST',
        'hasdst' => false ),
    'America/Tegucigalpa' => array(
        'offset' => -21600000,
        'longname' => "Central Standard Time",
        'shortname' => 'CST',
        'hasdst' => false ),
    'America/Winnipeg' => array(
        'offset' => -21600000,
        'longname' => "Central Standard Time",
        'shortname' => 'CST',
        'hasdst' => true,
        'dstlongname' => "Central Daylight Time",
        'dstshortname' => 'CDT' ),
    'CST' => array(
        'offset' => -21600000,
        'longname' => "Central Standard Time",
        'shortname' => 'CST',
        'hasdst' => true,
        'dstlongname' => "Central Daylight Time",
        'dstshortname' => 'CDT' ),
    'CST6CDT' => array(
        'offset' => -21600000,
        'longname' => "Central Standard Time",
        'shortname' => 'CST',
        'hasdst' => true,
        'dstlongname' => "Central Daylight Time",
        'dstshortname' => 'CDT' ),
    'Canada/Central' => array(
        'offset' => -21600000,
        'longname' => "Central Standard Time",
        'shortname' => 'CST',
        'hasdst' => true,
        'dstlongname' => "Central Daylight Time",
        'dstshortname' => 'CDT' ),
    'Canada/East-Saskatchewan' => array(
        'offset' => -21600000,
        'longname' => "Central Standard Time",
        'shortname' => 'CST',
        'hasdst' => false ),
    'Canada/Saskatchewan' => array(
        'offset' => -21600000,
        'longname' => "Central Standard Time",
        'shortname' => 'CST',
        'hasdst' => false ),
    'Chile/EasterIsland' => array(
        'offset' => -21600000,
        'longname' => "Easter Is. Time",
        'shortname' => 'EAST',
        'hasdst' => true,
        'dstlongname' => "Easter Is. Summer Time",
        'dstshortname' => 'EASST' ),
    'Etc/GMT+6' => array(
        'offset' => -21600000,
        'longname' => "GMT-06:00",
        'shortname' => 'GMT-06:00',
        'hasdst' => false ),
    'Mexico/General' => array(
        'offset' => -21600000,
        'longname' => "Central Standard Time",
        'shortname' => 'CST',
        'hasdst' => false ),
    'Pacific/Easter' => array(
        'offset' => -21600000,
        'longname' => "Easter Is. Time",
        'shortname' => 'EAST',
        'hasdst' => true,
        'dstlongname' => "Easter Is. Summer Time",
        'dstshortname' => 'EASST' ),
    'Pacific/Galapagos' => array(
        'offset' => -21600000,
        'longname' => "Galapagos Time",
        'shortname' => 'GALT',
        'hasdst' => false ),
    'SystemV/CST6' => array(
        'offset' => -21600000,
        'longname' => "Central Standard Time",
        'shortname' => 'CST',
        'hasdst' => false ),
    'SystemV/CST6CDT' => array(
        'offset' => -21600000,
        'longname' => "Central Standard Time",
        'shortname' => 'CST',
        'hasdst' => true,
        'dstlongname' => "Central Daylight Time",
        'dstshortname' => 'CDT' ),
    'US/Central' => array(
        'offset' => -21600000,
        'longname' => "Central Standard Time",
        'shortname' => 'CST',
        'hasdst' => true,
        'dstlongname' => "Central Daylight Time",
        'dstshortname' => 'CDT' ),
    'America/Bogota' => array(
        'offset' => -18000000,
        'longname' => "Colombia Time",
        'shortname' => 'COT',
        'hasdst' => false ),
    'America/Cayman' => array(
        'offset' => -18000000,
        'longname' => "Eastern Standard Time",
        'shortname' => 'EST',
        'hasdst' => false ),
    'America/Detroit' => array(
        'offset' => -18000000,
        'longname' => "Eastern Standard Time",
        'shortname' => 'EST',
        'hasdst' => true,
        'dstlongname' => "Eastern Daylight Time",
        'dstshortname' => 'EDT' ),
    'America/Eirunepe' => array(
        'offset' => -18000000,
        'longname' => "Acre Time",
        'shortname' => 'ACT',
        'hasdst' => false ),
    'America/Fort_Wayne' => array(
        'offset' => -18000000,
        'longname' => "Eastern Standard Time",
        'shortname' => 'EST',
        'hasdst' => false ),
    'America/Grand_Turk' => array(
        'offset' => -18000000,
        'longname' => "Eastern Standard Time",
        'shortname' => 'EST',
        'hasdst' => true,
        'dstlongname' => "Eastern Daylight Time",
        'dstshortname' => 'EDT' ),
    'America/Guayaquil' => array(
        'offset' => -18000000,
        'longname' => "Ecuador Time",
        'shortname' => 'ECT',
        'hasdst' => false ),
    'America/Havana' => array(
        'offset' => -18000000,
        'longname' => "Central Standard Time",
        'shortname' => 'CST',
        'hasdst' => true,
        'dstlongname' => "Central Daylight Time",
        'dstshortname' => 'CDT' ),
    'America/Indiana/Indianapolis' => array(
        'offset' => -18000000,
        'longname' => "Eastern Standard Time",
        'shortname' => 'EST',
        'hasdst' => false ),
    'America/Indiana/Knox' => array(
        'offset' => -18000000,
        'longname' => "Eastern Standard Time",
        'shortname' => 'EST',
        'hasdst' => false ),
    'America/Indiana/Marengo' => array(
        'offset' => -18000000,
        'longname' => "Eastern Standard Time",
        'shortname' => 'EST',
        'hasdst' => false ),
    'America/Indiana/Vevay' => array(
        'offset' => -18000000,
        'longname' => "Eastern Standard Time",
        'shortname' => 'EST',
        'hasdst' => false ),
    'America/Indianapolis' => array(
        'offset' => -18000000,
        'longname' => "Eastern Standard Time",
        'shortname' => 'EST',
        'hasdst' => false ),
    'America/Iqaluit' => array(
        'offset' => -18000000,
        'longname' => "Eastern Standard Time",
        'shortname' => 'EST',
        'hasdst' => true,
        'dstlongname' => "Eastern Daylight Time",
        'dstshortname' => 'EDT' ),
    'America/Jamaica' => array(
        'offset' => -18000000,
        'longname' => "Eastern Standard Time",
        'shortname' => 'EST',
        'hasdst' => false ),
    'America/Kentucky/Louisville' => array(
        'offset' => -18000000,
        'longname' => "Eastern Standard Time",
        'shortname' => 'EST',
        'hasdst' => true,
        'dstlongname' => "Eastern Daylight Time",
        'dstshortname' => 'EDT' ),
    'America/Kentucky/Monticello' => array(
        'offset' => -18000000,
        'longname' => "Eastern Standard Time",
        'shortname' => 'EST',
        'hasdst' => true,
        'dstlongname' => "Eastern Daylight Time",
        'dstshortname' => 'EDT' ),
    'America/Knox_IN' => array(
        'offset' => -18000000,
        'longname' => "Eastern Standard Time",
        'shortname' => 'EST',
        'hasdst' => false ),
    'America/Lima' => array(
        'offset' => -18000000,
        'longname' => "Peru Time",
        'shortname' => 'PET',
        'hasdst' => false ),
    'America/Louisville' => array(
        'offset' => -18000000,
        'longname' => "Eastern Standard Time",
        'shortname' => 'EST',
        'hasdst' => true,
        'dstlongname' => "Eastern Daylight Time",
        'dstshortname' => 'EDT' ),
    'America/Montreal' => array(
        'offset' => -18000000,
        'longname' => "Eastern Standard Time",
        'shortname' => 'EST',
        'hasdst' => true,
        'dstlongname' => "Eastern Daylight Time",
        'dstshortname' => 'EDT' ),
    'America/Nassau' => array(
        'offset' => -18000000,
        'longname' => "Eastern Standard Time",
        'shortname' => 'EST',
        'hasdst' => true,
        'dstlongname' => "Eastern Daylight Time",
        'dstshortname' => 'EDT' ),
    'America/New_York' => array(
        'offset' => -18000000,
        'longname' => "Eastern Standard Time",
        'shortname' => 'EST',
        'hasdst' => true,
        'dstlongname' => "Eastern Daylight Time",
        'dstshortname' => 'EDT' ),
    'America/Nipigon' => array(
        'offset' => -18000000,
        'longname' => "Eastern Standard Time",
        'shortname' => 'EST',
        'hasdst' => true,
        'dstlongname' => "Eastern Daylight Time",
        'dstshortname' => 'EDT' ),
    'America/Panama' => array(
        'offset' => -18000000,
        'longname' => "Eastern Standard Time",
        'shortname' => 'EST',
        'hasdst' => false ),
    'America/Pangnirtung' => array(
        'offset' => -18000000,
        'longname' => "Eastern Standard Time",
        'shortname' => 'EST',
        'hasdst' => true,
        'dstlongname' => "Eastern Daylight Time",
        'dstshortname' => 'EDT' ),
    'America/Port-au-Prince' => array(
        'offset' => -18000000,
        'longname' => "Eastern Standard Time",
        'shortname' => 'EST',
        'hasdst' => false ),
    'America/Porto_Acre' => array(
        'offset' => -18000000,
        'longname' => "Acre Time",
        'shortname' => 'ACT',
        'hasdst' => false ),
    'America/Rio_Branco' => array(
        'offset' => -18000000,
        'longname' => "Acre Time",
        'shortname' => 'ACT',
        'hasdst' => false ),
    'America/Thunder_Bay' => array(
        'offset' => -18000000,
        'longname' => "Eastern Standard Time",
        'shortname' => 'EST',
        'hasdst' => true,
        'dstlongname' => "Eastern Daylight Time",
        'dstshortname' => 'EDT' ),
    'Brazil/Acre' => array(
        'offset' => -18000000,
        'longname' => "Acre Time",
        'shortname' => 'ACT',
        'hasdst' => false ),
    'Canada/Eastern' => array(
        'offset' => -18000000,
        'longname' => "Eastern Standard Time",
        'shortname' => 'EST',
        'hasdst' => true,
        'dstlongname' => "Eastern Daylight Time",
        'dstshortname' => 'EDT' ),
    'Cuba' => array(
        'offset' => -18000000,
        'longname' => "Central Standard Time",
        'shortname' => 'CST',
        'hasdst' => true,
        'dstlongname' => "Central Daylight Time",
        'dstshortname' => 'CDT' ),
    'EST' => array(
        'offset' => -18000000,
        'longname' => "Eastern Standard Time",
        'shortname' => 'EST',
        'hasdst' => true,
        'dstlongname' => "Eastern Daylight Time",
        'dstshortname' => 'EDT' ),
    'EST5EDT' => array(
        'offset' => -18000000,
        'longname' => "Eastern Standard Time",
        'shortname' => 'EST',
        'hasdst' => true,
        'dstlongname' => "Eastern Daylight Time",
        'dstshortname' => 'EDT' ),
    'Etc/GMT+5' => array(
        'offset' => -18000000,
        'longname' => "GMT-05:00",
        'shortname' => 'GMT-05:00',
        'hasdst' => false ),
    'IET' => array(
        'offset' => -18000000,
        'longname' => "Eastern Standard Time",
        'shortname' => 'EST',
        'hasdst' => false ),
    'Jamaica' => array(
        'offset' => -18000000,
        'longname' => "Eastern Standard Time",
        'shortname' => 'EST',
        'hasdst' => false ),
    'SystemV/EST5' => array(
        'offset' => -18000000,
        'longname' => "Eastern Standard Time",
        'shortname' => 'EST',
        'hasdst' => false ),
    'SystemV/EST5EDT' => array(
        'offset' => -18000000,
        'longname' => "Eastern Standard Time",
        'shortname' => 'EST',
        'hasdst' => true,
        'dstlongname' => "Eastern Daylight Time",
        'dstshortname' => 'EDT' ),
    'US/East-Indiana' => array(
        'offset' => -18000000,
        'longname' => "Eastern Standard Time",
        'shortname' => 'EST',
        'hasdst' => false ),
    'US/Eastern' => array(
        'offset' => -18000000,
        'longname' => "Eastern Standard Time",
        'shortname' => 'EST',
        'hasdst' => true,
        'dstlongname' => "Eastern Daylight Time",
        'dstshortname' => 'EDT' ),
    'US/Indiana-Starke' => array(
        'offset' => -18000000,
        'longname' => "Eastern Standard Time",
        'shortname' => 'EST',
        'hasdst' => false ),
    'US/Michigan' => array(
        'offset' => -18000000,
        'longname' => "Eastern Standard Time",
        'shortname' => 'EST',
        'hasdst' => true,
        'dstlongname' => "Eastern Daylight Time",
        'dstshortname' => 'EDT' ),
    'America/Anguilla' => array(
        'offset' => -14400000,
        'longname' => "Atlantic Standard Time",
        'shortname' => 'AST',
        'hasdst' => false ),
    'America/Antigua' => array(
        'offset' => -14400000,
        'longname' => "Atlantic Standard Time",
        'shortname' => 'AST',
        'hasdst' => false ),
    'America/Aruba' => array(
        'offset' => -14400000,
        'longname' => "Atlantic Standard Time",
        'shortname' => 'AST',
        'hasdst' => false ),
    'America/Asuncion' => array(
        'offset' => -14400000,
        'longname' => "Paraguay Time",
        'shortname' => 'PYT',
        'hasdst' => true,
        'dstlongname' => "Paraguay Summer Time",
        'dstshortname' => 'PYST' ),
    'America/Barbados' => array(
        'offset' => -14400000,
        'longname' => "Atlantic Standard Time",
        'shortname' => 'AST',
        'hasdst' => false ),
    'America/Boa_Vista' => array(
        'offset' => -14400000,
        'longname' => "Amazon Standard Time",
        'shortname' => 'AMT',
        'hasdst' => false ),
    'America/Caracas' => array(
        'offset' => -14400000,
        'longname' => "Venezuela Time",
        'shortname' => 'VET',
        'hasdst' => false ),
    'America/Cuiaba' => array(
        'offset' => -14400000,
        'longname' => "Amazon Standard Time",
        'shortname' => 'AMT',
        'hasdst' => true,
        'dstlongname' => "Amazon Summer Time",
        'dstshortname' => 'AMST' ),
    'America/Curacao' => array(
        'offset' => -14400000,
        'longname' => "Atlantic Standard Time",
        'shortname' => 'AST',
        'hasdst' => false ),
    'America/Dominica' => array(
        'offset' => -14400000,
        'longname' => "Atlantic Standard Time",
        'shortname' => 'AST',
        'hasdst' => false ),
    'America/Glace_Bay' => array(
        'offset' => -14400000,
        'longname' => "Atlantic Standard Time",
        'shortname' => 'AST',
        'hasdst' => true,
        'dstlongname' => "Atlantic Daylight Time",
        'dstshortname' => 'ADT' ),
    'America/Goose_Bay' => array(
        'offset' => -14400000,
        'longname' => "Atlantic Standard Time",
        'shortname' => 'AST',
        'hasdst' => true,
        'dstlongname' => "Atlantic Daylight Time",
        'dstshortname' => 'ADT' ),
    'America/Grenada' => array(
        'offset' => -14400000,
        'longname' => "Atlantic Standard Time",
        'shortname' => 'AST',
        'hasdst' => false ),
    'America/Guadeloupe' => array(
        'offset' => -14400000,
        'longname' => "Atlantic Standard Time",
        'shortname' => 'AST',
        'hasdst' => false ),
    'America/Guyana' => array(
        'offset' => -14400000,
        'longname' => "Guyana Time",
        'shortname' => 'GYT',
        'hasdst' => false ),
    'America/Halifax' => array(
        'offset' => -14400000,
        'longname' => "Atlantic Standard Time",
        'shortname' => 'AST',
        'hasdst' => true,
        'dstlongname' => "Atlantic Daylight Time",
        'dstshortname' => 'ADT' ),
    'America/La_Paz' => array(
        'offset' => -14400000,
        'longname' => "Bolivia Time",
        'shortname' => 'BOT',
        'hasdst' => false ),
    'America/Manaus' => array(
        'offset' => -14400000,
        'longname' => "Amazon Standard Time",
        'shortname' => 'AMT',
        'hasdst' => false ),
    'America/Martinique' => array(
        'offset' => -14400000,
        'longname' => "Atlantic Standard Time",
        'shortname' => 'AST',
        'hasdst' => false ),
    'America/Montserrat' => array(
        'offset' => -14400000,
        'longname' => "Atlantic Standard Time",
        'shortname' => 'AST',
        'hasdst' => false ),
    'America/Port_of_Spain' => array(
        'offset' => -14400000,
        'longname' => "Atlantic Standard Time",
        'shortname' => 'AST',
        'hasdst' => false ),
    'America/Porto_Velho' => array(
        'offset' => -14400000,
        'longname' => "Amazon Standard Time",
        'shortname' => 'AMT',
        'hasdst' => false ),
    'America/Puerto_Rico' => array(
        'offset' => -14400000,
        'longname' => "Atlantic Standard Time",
        'shortname' => 'AST',
        'hasdst' => false ),
    'America/Santiago' => array(
        'offset' => -14400000,
        'longname' => "Chile Time",
        'shortname' => 'CLT',
        'hasdst' => true,
        'dstlongname' => "Chile Summer Time",
        'dstshortname' => 'CLST' ),
    'America/Santo_Domingo' => array(
        'offset' => -14400000,
        'longname' => "Atlantic Standard Time",
        'shortname' => 'AST',
        'hasdst' => false ),
    'America/St_Kitts' => array(
        'offset' => -14400000,
        'longname' => "Atlantic Standard Time",
        'shortname' => 'AST',
        'hasdst' => false ),
    'America/St_Lucia' => array(
        'offset' => -14400000,
        'longname' => "Atlantic Standard Time",
        'shortname' => 'AST',
        'hasdst' => false ),
    'America/St_Thomas' => array(
        'offset' => -14400000,
        'longname' => "Atlantic Standard Time",
        'shortname' => 'AST',
        'hasdst' => false ),
    'America/St_Vincent' => array(
        'offset' => -14400000,
        'longname' => "Atlantic Standard Time",
        'shortname' => 'AST',
        'hasdst' => false ),
    'America/Thule' => array(
        'offset' => -14400000,
        'longname' => "Atlantic Standard Time",
        'shortname' => 'AST',
        'hasdst' => false ),
    'America/Tortola' => array(
        'offset' => -14400000,
        'longname' => "Atlantic Standard Time",
        'shortname' => 'AST',
        'hasdst' => false ),
    'America/Virgin' => array(
        'offset' => -14400000,
        'longname' => "Atlantic Standard Time",
        'shortname' => 'AST',
        'hasdst' => false ),
    'Antarctica/Palmer' => array(
        'offset' => -14400000,
        'longname' => "Chile Time",
        'shortname' => 'CLT',
        'hasdst' => true,
        'dstlongname' => "Chile Summer Time",
        'dstshortname' => 'CLST' ),
    'Atlantic/Bermuda' => array(
        'offset' => -14400000,
        'longname' => "Atlantic Standard Time",
        'shortname' => 'AST',
        'hasdst' => true,
        'dstlongname' => "Atlantic Daylight Time",
        'dstshortname' => 'ADT' ),
    'Atlantic/Stanley' => array(
        'offset' => -14400000,
        'longname' => "Falkland Is. Time",
        'shortname' => 'FKT',
        'hasdst' => true,
        'dstlongname' => "Falkland Is. Summer Time",
        'dstshortname' => 'FKST' ),
    'Brazil/West' => array(
        'offset' => -14400000,
        'longname' => "Amazon Standard Time",
        'shortname' => 'AMT',
        'hasdst' => false ),
    'Canada/Atlantic' => array(
        'offset' => -14400000,
        'longname' => "Atlantic Standard Time",
        'shortname' => 'AST',
        'hasdst' => true,
        'dstlongname' => "Atlantic Daylight Time",
        'dstshortname' => 'ADT' ),
    'Chile/Continental' => array(
        'offset' => -14400000,
        'longname' => "Chile Time",
        'shortname' => 'CLT',
        'hasdst' => true,
        'dstlongname' => "Chile Summer Time",
        'dstshortname' => 'CLST' ),
    'Etc/GMT+4' => array(
        'offset' => -14400000,
        'longname' => "GMT-04:00",
        'shortname' => 'GMT-04:00',
        'hasdst' => false ),
    'PRT' => array(
        'offset' => -14400000,
        'longname' => "Atlantic Standard Time",
        'shortname' => 'AST',
        'hasdst' => false ),
    'SystemV/AST4' => array(
        'offset' => -14400000,
        'longname' => "Atlantic Standard Time",
        'shortname' => 'AST',
        'hasdst' => false ),
    'SystemV/AST4ADT' => array(
        'offset' => -14400000,
        'longname' => "Atlantic Standard Time",
        'shortname' => 'AST',
        'hasdst' => true,
        'dstlongname' => "Atlantic Daylight Time",
        'dstshortname' => 'ADT' ),
    'America/St_Johns' => array(
        'offset' => -12600000,
        'longname' => "Newfoundland Standard Time",
        'shortname' => 'NST',
        'hasdst' => true,
        'dstlongname' => "Newfoundland Daylight Time",
        'dstshortname' => 'NDT' ),
    'CNT' => array(
        'offset' => -12600000,
        'longname' => "Newfoundland Standard Time",
        'shortname' => 'NST',
        'hasdst' => true,
        'dstlongname' => "Newfoundland Daylight Time",
        'dstshortname' => 'NDT' ),
    'Canada/Newfoundland' => array(
        'offset' => -12600000,
        'longname' => "Newfoundland Standard Time",
        'shortname' => 'NST',
        'hasdst' => true,
        'dstlongname' => "Newfoundland Daylight Time",
        'dstshortname' => 'NDT' ),
    'AGT' => array(
        'offset' => -10800000,
        'longname' => "Argentine Time",
        'shortname' => 'ART',
        'hasdst' => false ),
    'America/Araguaina' => array(
        'offset' => -10800000,
        'longname' => "Brazil Time",
        'shortname' => 'BRT',
        'hasdst' => true,
        'dstlongname' => "Brazil Summer Time",
        'dstshortname' => 'BRST' ),
    'America/Belem' => array(
        'offset' => -10800000,
        'longname' => "Brazil Time",
        'shortname' => 'BRT',
        'hasdst' => false ),
    'America/Buenos_Aires' => array(
        'offset' => -10800000,
        'longname' => "Argentine Time",
        'shortname' => 'ART',
        'hasdst' => false ),
    'America/Catamarca' => array(
        'offset' => -10800000,
        'longname' => "Argentine Time",
        'shortname' => 'ART',
        'hasdst' => false ),
    'America/Cayenne' => array(
        'offset' => -10800000,
        'longname' => "French Guiana Time",
        'shortname' => 'GFT',
        'hasdst' => false ),
    'America/Cordoba' => array(
        'offset' => -10800000,
        'longname' => "Argentine Time",
        'shortname' => 'ART',
        'hasdst' => false ),
    'America/Fortaleza' => array(
        'offset' => -10800000,
        'longname' => "Brazil Time",
        'shortname' => 'BRT',
        'hasdst' => true,
        'dstlongname' => "Brazil Summer Time",
        'dstshortname' => 'BRST' ),
    'America/Godthab' => array(
        'offset' => -10800000,
        'longname' => "Western Greenland Time",
        'shortname' => 'WGT',
        'hasdst' => true,
        'dstlongname' => "Western Greenland Summer Time",
        'dstshortname' => 'WGST' ),
    'America/Jujuy' => array(
        'offset' => -10800000,
        'longname' => "Argentine Time",
        'shortname' => 'ART',
        'hasdst' => false ),
    'America/Maceio' => array(
        'offset' => -10800000,
        'longname' => "Brazil Time",
        'shortname' => 'BRT',
        'hasdst' => true,
        'dstlongname' => "Brazil Summer Time",
        'dstshortname' => 'BRST' ),
    'America/Mendoza' => array(
        'offset' => -10800000,
        'longname' => "Argentine Time",
        'shortname' => 'ART',
        'hasdst' => false ),
    'America/Miquelon' => array(
        'offset' => -10800000,
        'longname' => "Pierre & Miquelon Standard Time",
        'shortname' => 'PMST',
        'hasdst' => true,
        'dstlongname' => "Pierre & Miquelon Daylight Time",
        'dstshortname' => 'PMDT' ),
    'America/Montevideo' => array(
        'offset' => -10800000,
        'longname' => "Uruguay Time",
        'shortname' => 'UYT',
        'hasdst' => false ),
    'America/Paramaribo' => array(
        'offset' => -10800000,
        'longname' => "Suriname Time",
        'shortname' => 'SRT',
        'hasdst' => false ),
    'America/Recife' => array(
        'offset' => -10800000,
        'longname' => "Brazil Time",
        'shortname' => 'BRT',
        'hasdst' => true,
        'dstlongname' => "Brazil Summer Time",
        'dstshortname' => 'BRST' ),
    'America/Rosario' => array(
        'offset' => -10800000,
        'longname' => "Argentine Time",
        'shortname' => 'ART',
        'hasdst' => false ),
    'America/Sao_Paulo' => array(
        'offset' => -10800000,
        'longname' => "Brazil Time",
        'shortname' => 'BRT',
        'hasdst' => true,
        'dstlongname' => "Brazil Summer Time",
        'dstshortname' => 'BRST' ),
    'BET' => array(
        'offset' => -10800000,
        'longname' => "Brazil Time",
        'shortname' => 'BRT',
        'hasdst' => true,
        'dstlongname' => "Brazil Summer Time",
        'dstshortname' => 'BRST' ),
    'Brazil/East' => array(
        'offset' => -10800000,
        'longname' => "Brazil Time",
        'shortname' => 'BRT',
        'hasdst' => true,
        'dstlongname' => "Brazil Summer Time",
        'dstshortname' => 'BRST' ),
    'Etc/GMT+3' => array(
        'offset' => -10800000,
        'longname' => "GMT-03:00",
        'shortname' => 'GMT-03:00',
        'hasdst' => false ),
    'America/Noronha' => array(
        'offset' => -7200000,
        'longname' => "Fernando de Noronha Time",
        'shortname' => 'FNT',
        'hasdst' => false ),
    'Atlantic/South_Georgia' => array(
        'offset' => -7200000,
        'longname' => "South Georgia Standard Time",
        'shortname' => 'GST',
        'hasdst' => false ),
    'Brazil/DeNoronha' => array(
        'offset' => -7200000,
        'longname' => "Fernando de Noronha Time",
        'shortname' => 'FNT',
        'hasdst' => false ),
    'Etc/GMT+2' => array(
        'offset' => -7200000,
        'longname' => "GMT-02:00",
        'shortname' => 'GMT-02:00',
        'hasdst' => false ),
    'America/Scoresbysund' => array(
        'offset' => -3600000,
        'longname' => "Eastern Greenland Time",
        'shortname' => 'EGT',
        'hasdst' => true,
        'dstlongname' => "Eastern Greenland Summer Time",
        'dstshortname' => 'EGST' ),
    'Atlantic/Azores' => array(
        'offset' => -3600000,
        'longname' => "Azores Time",
        'shortname' => 'AZOT',
        'hasdst' => true,
        'dstlongname' => "Azores Summer Time",
        'dstshortname' => 'AZOST' ),
    'Atlantic/Cape_Verde' => array(
        'offset' => -3600000,
        'longname' => "Cape Verde Time",
        'shortname' => 'CVT',
        'hasdst' => false ),
    'Etc/GMT+1' => array(
        'offset' => -3600000,
        'longname' => "GMT-01:00",
        'shortname' => 'GMT-01:00',
        'hasdst' => false ),
    'Africa/Abidjan' => array(
        'offset' => 0,
        'longname' => "Greenwich Mean Time",
        'shortname' => 'GMT',
        'hasdst' => false ),
    'Africa/Accra' => array(
        'offset' => 0,
        'longname' => "Greenwich Mean Time",
        'shortname' => 'GMT',
        'hasdst' => false ),
    'Africa/Bamako' => array(
        'offset' => 0,
        'longname' => "Greenwich Mean Time",
        'shortname' => 'GMT',
        'hasdst' => false ),
    'Africa/Banjul' => array(
        'offset' => 0,
        'longname' => "Greenwich Mean Time",
        'shortname' => 'GMT',
        'hasdst' => false ),
    'Africa/Bissau' => array(
        'offset' => 0,
        'longname' => "Greenwich Mean Time",
        'shortname' => 'GMT',
        'hasdst' => false ),
    'Africa/Casablanca' => array(
        'offset' => 0,
        'longname' => "Western European Time",
        'shortname' => 'WET',
        'hasdst' => false ),
    'Africa/Conakry' => array(
        'offset' => 0,
        'longname' => "Greenwich Mean Time",
        'shortname' => 'GMT',
        'hasdst' => false ),
    'Africa/Dakar' => array(
        'offset' => 0,
        'longname' => "Greenwich Mean Time",
        'shortname' => 'GMT',
        'hasdst' => false ),
    'Africa/El_Aaiun' => array(
        'offset' => 0,
        'longname' => "Western European Time",
        'shortname' => 'WET',
        'hasdst' => false ),
    'Africa/Freetown' => array(
        'offset' => 0,
        'longname' => "Greenwich Mean Time",
        'shortname' => 'GMT',
        'hasdst' => false ),
    'Africa/Lome' => array(
        'offset' => 0,
        'longname' => "Greenwich Mean Time",
        'shortname' => 'GMT',
        'hasdst' => false ),
    'Africa/Monrovia' => array(
        'offset' => 0,
        'longname' => "Greenwich Mean Time",
        'shortname' => 'GMT',
        'hasdst' => false ),
    'Africa/Nouakchott' => array(
        'offset' => 0,
        'longname' => "Greenwich Mean Time",
        'shortname' => 'GMT',
        'hasdst' => false ),
    'Africa/Ouagadougou' => array(
        'offset' => 0,
        'longname' => "Greenwich Mean Time",
        'shortname' => 'GMT',
        'hasdst' => false ),
    'Africa/Sao_Tome' => array(
        'offset' => 0,
        'longname' => "Greenwich Mean Time",
        'shortname' => 'GMT',
        'hasdst' => false ),
    'Africa/Timbuktu' => array(
        'offset' => 0,
        'longname' => "Greenwich Mean Time",
        'shortname' => 'GMT',
        'hasdst' => false ),
    'America/Danmarkshavn' => array(
        'offset' => 0,
        'longname' => "Greenwich Mean Time",
        'shortname' => 'GMT',
        'hasdst' => false ),
    'Atlantic/Canary' => array(
        'offset' => 0,
        'longname' => "Western European Time",
        'shortname' => 'WET',
        'hasdst' => true,
        'dstlongname' => "Western European Summer Time",
        'dstshortname' => 'WEST' ),
    'Atlantic/Faeroe' => array(
        'offset' => 0,
        'longname' => "Western European Time",
        'shortname' => 'WET',
        'hasdst' => true,
        'dstlongname' => "Western European Summer Time",
        'dstshortname' => 'WEST' ),
    'Atlantic/Madeira' => array(
        'offset' => 0,
        'longname' => "Western European Time",
        'shortname' => 'WET',
        'hasdst' => true,
        'dstlongname' => "Western European Summer Time",
        'dstshortname' => 'WEST' ),
    'Atlantic/Reykjavik' => array(
        'offset' => 0,
        'longname' => "Greenwich Mean Time",
        'shortname' => 'GMT',
        'hasdst' => false ),
    'Atlantic/St_Helena' => array(
        'offset' => 0,
        'longname' => "Greenwich Mean Time",
        'shortname' => 'GMT',
        'hasdst' => false ),
    'Eire' => array(
        'offset' => 0,
        'longname' => "Greenwich Mean Time",
        'shortname' => 'GMT',
        'hasdst' => true,
        'dstlongname' => "Irish Summer Time",
        'dstshortname' => 'IST' ),
    'Etc/GMT' => array(
        'offset' => 0,
        'longname' => "GMT+00:00",
        'shortname' => 'GMT+00:00',
        'hasdst' => false ),
    'Etc/GMT+0' => array(
        'offset' => 0,
        'longname' => "GMT+00:00",
        'shortname' => 'GMT+00:00',
        'hasdst' => false ),
    'Etc/GMT-0' => array(
        'offset' => 0,
        'longname' => "GMT+00:00",
        'shortname' => 'GMT+00:00',
        'hasdst' => false ),
    'Etc/GMT0' => array(
        'offset' => 0,
        'longname' => "GMT+00:00",
        'shortname' => 'GMT+00:00',
        'hasdst' => false ),
    'Etc/Greenwich' => array(
        'offset' => 0,
        'longname' => "Greenwich Mean Time",
        'shortname' => 'GMT',
        'hasdst' => false ),
    'Etc/UCT' => array(
        'offset' => 0,
        'longname' => "Coordinated Universal Time",
        'shortname' => 'UTC',
        'hasdst' => false ),
    'Etc/UTC' => array(
        'offset' => 0,
        'longname' => "Coordinated Universal Time",
        'shortname' => 'UTC',
        'hasdst' => false ),
    'Etc/Universal' => array(
        'offset' => 0,
        'longname' => "Coordinated Universal Time",
        'shortname' => 'UTC',
        'hasdst' => false ),
    'Etc/Zulu' => array(
        'offset' => 0,
        'longname' => "Coordinated Universal Time",
        'shortname' => 'UTC',
        'hasdst' => false ),
    'Europe/Belfast' => array(
        'offset' => 0,
        'longname' => "Greenwich Mean Time",
        'shortname' => 'GMT',
        'hasdst' => true,
        'dstlongname' => "British Summer Time",
        'dstshortname' => 'BST' ),
    'Europe/Dublin' => array(
        'offset' => 0,
        'longname' => "Greenwich Mean Time",
        'shortname' => 'GMT',
        'hasdst' => true,
        'dstlongname' => "Irish Summer Time",
        'dstshortname' => 'IST' ),
    'Europe/Lisbon' => array(
        'offset' => 0,
        'longname' => "Western European Time",
        'shortname' => 'WET',
        'hasdst' => true,
        'dstlongname' => "Western European Summer Time",
        'dstshortname' => 'WEST' ),
    'Europe/London' => array(
        'offset' => 0,
        'longname' => "Greenwich Mean Time",
        'shortname' => 'GMT',
        'hasdst' => true,
        'dstlongname' => "British Summer Time",
        'dstshortname' => 'BST' ),
    'GB' => array(
        'offset' => 0,
        'longname' => "Greenwich Mean Time",
        'shortname' => 'GMT',
        'hasdst' => true,
        'dstlongname' => "British Summer Time",
        'dstshortname' => 'BST' ),
    'GB-Eire' => array(
        'offset' => 0,
        'longname' => "Greenwich Mean Time",
        'shortname' => 'GMT',
        'hasdst' => true,
        'dstlongname' => "British Summer Time",
        'dstshortname' => 'BST' ),
    'GMT' => array(
        'offset' => 0,
        'longname' => "Greenwich Mean Time",
        'shortname' => 'GMT',
        'hasdst' => false ),
    'GMT0' => array(
        'offset' => 0,
        'longname' => "GMT+00:00",
        'shortname' => 'GMT+00:00',
        'hasdst' => false ),
    'Greenwich' => array(
        'offset' => 0,
        'longname' => "Greenwich Mean Time",
        'shortname' => 'GMT',
        'hasdst' => false ),
    'Iceland' => array(
        'offset' => 0,
        'longname' => "Greenwich Mean Time",
        'shortname' => 'GMT',
        'hasdst' => false ),
    'Portugal' => array(
        'offset' => 0,
        'longname' => "Western European Time",
        'shortname' => 'WET',
        'hasdst' => true,
        'dstlongname' => "Western European Summer Time",
        'dstshortname' => 'WEST' ),
    'UCT' => array(
        'offset' => 0,
        'longname' => "Coordinated Universal Time",
        'shortname' => 'UTC',
        'hasdst' => false ),
    'UTC' => array(
        'offset' => 0,
        'longname' => "Coordinated Universal Time",
        'shortname' => 'UTC',
        'hasdst' => false ),
    'Universal' => array(
        'offset' => 0,
        'longname' => "Coordinated Universal Time",
        'shortname' => 'UTC',
        'hasdst' => false ),
    'WET' => array(
        'offset' => 0,
        'longname' => "Western European Time",
        'shortname' => 'WET',
        'hasdst' => true,
        'dstlongname' => "Western European Summer Time",
        'dstshortname' => 'WEST' ),
    'Zulu' => array(
        'offset' => 0,
        'longname' => "Coordinated Universal Time",
        'shortname' => 'UTC',
        'hasdst' => false ),
    'Africa/Algiers' => array(
        'offset' => 3600000,
        'longname' => "Central European Time",
        'shortname' => 'CET',
        'hasdst' => false ),
    'Africa/Bangui' => array(
        'offset' => 3600000,
        'longname' => "Western African Time",
        'shortname' => 'WAT',
        'hasdst' => false ),
    'Africa/Brazzaville' => array(
        'offset' => 3600000,
        'longname' => "Western African Time",
        'shortname' => 'WAT',
        'hasdst' => false ),
    'Africa/Ceuta' => array(
        'offset' => 3600000,
        'longname' => "Central European Time",
        'shortname' => 'CET',
        'hasdst' => true,
        'dstlongname' => "Central European Summer Time",
        'dstshortname' => 'CEST' ),
    'Africa/Douala' => array(
        'offset' => 3600000,
        'longname' => "Western African Time",
        'shortname' => 'WAT',
        'hasdst' => false ),
    'Africa/Kinshasa' => array(
        'offset' => 3600000,
        'longname' => "Western African Time",
        'shortname' => 'WAT',
        'hasdst' => false ),
    'Africa/Lagos' => array(
        'offset' => 3600000,
        'longname' => "Western African Time",
        'shortname' => 'WAT',
        'hasdst' => false ),
    'Africa/Libreville' => array(
        'offset' => 3600000,
        'longname' => "Western African Time",
        'shortname' => 'WAT',
        'hasdst' => false ),
    'Africa/Luanda' => array(
        'offset' => 3600000,
        'longname' => "Western African Time",
        'shortname' => 'WAT',
        'hasdst' => false ),
    'Africa/Malabo' => array(
        'offset' => 3600000,
        'longname' => "Western African Time",
        'shortname' => 'WAT',
        'hasdst' => false ),
    'Africa/Ndjamena' => array(
        'offset' => 3600000,
        'longname' => "Western African Time",
        'shortname' => 'WAT',
        'hasdst' => false ),
    'Africa/Niamey' => array(
        'offset' => 3600000,
        'longname' => "Western African Time",
        'shortname' => 'WAT',
        'hasdst' => false ),
    'Africa/Porto-Novo' => array(
        'offset' => 3600000,
        'longname' => "Western African Time",
        'shortname' => 'WAT',
        'hasdst' => false ),
    'Africa/Tunis' => array(
        'offset' => 3600000,
        'longname' => "Central European Time",
        'shortname' => 'CET',
        'hasdst' => false ),
    'Africa/Windhoek' => array(
        'offset' => 3600000,
        'longname' => "Western African Time",
        'shortname' => 'WAT',
        'hasdst' => true,
        'dstlongname' => "Western African Summer Time",
        'dstshortname' => 'WAST' ),
    'Arctic/Longyearbyen' => array(
        'offset' => 3600000,
        'longname' => "Central European Time",
        'shortname' => 'CET',
        'hasdst' => true,
        'dstlongname' => "Central European Summer Time",
        'dstshortname' => 'CEST' ),
    'Atlantic/Jan_Mayen' => array(
        'offset' => 3600000,
        'longname' => "Eastern Greenland Time",
        'shortname' => 'EGT',
        'hasdst' => true,
        'dstlongname' => "Eastern Greenland Summer Time",
        'dstshortname' => 'EGST' ),
    'CET' => array(
        'offset' => 3600000,
        'longname' => "Central European Time",
        'shortname' => 'CET',
        'hasdst' => true,
        'dstlongname' => "Central European Summer Time",
        'dstshortname' => 'CEST' ),
    'ECT' => array(
        'offset' => 3600000,
        'longname' => "Central European Time",
        'shortname' => 'CET',
        'hasdst' => true,
        'dstlongname' => "Central European Summer Time",
        'dstshortname' => 'CEST' ),
    'Etc/GMT-1' => array(
        'offset' => 3600000,
        'longname' => "GMT+01:00",
        'shortname' => 'GMT+01:00',
        'hasdst' => false ),
    'Europe/Amsterdam' => array(
        'offset' => 3600000,
        'longname' => "Central European Time",
        'shortname' => 'CET',
        'hasdst' => true,
        'dstlongname' => "Central European Summer Time",
        'dstshortname' => 'CEST' ),
    'Europe/Andorra' => array(
        'offset' => 3600000,
        'longname' => "Central European Time",
        'shortname' => 'CET',
        'hasdst' => true,
        'dstlongname' => "Central European Summer Time",
        'dstshortname' => 'CEST' ),
    'Europe/Belgrade' => array(
        'offset' => 3600000,
        'longname' => "Central European Time",
        'shortname' => 'CET',
        'hasdst' => true,
        'dstlongname' => "Central European Summer Time",
        'dstshortname' => 'CEST' ),
    'Europe/Berlin' => array(
        'offset' => 3600000,
        'longname' => "Central European Time",
        'shortname' => 'CET',
        'hasdst' => true,
        'dstlongname' => "Central European Summer Time",
        'dstshortname' => 'CEST' ),
    'Europe/Bratislava' => array(
        'offset' => 3600000,
        'longname' => "Central European Time",
        'shortname' => 'CET',
        'hasdst' => true,
        'dstlongname' => "Central European Summer Time",
        'dstshortname' => 'CEST' ),
    'Europe/Brussels' => array(
        'offset' => 3600000,
        'longname' => "Central European Time",
        'shortname' => 'CET',
        'hasdst' => true,
        'dstlongname' => "Central European Summer Time",
        'dstshortname' => 'CEST' ),
    'Europe/Budapest' => array(
        'offset' => 3600000,
        'longname' => "Central European Time",
        'shortname' => 'CET',
        'hasdst' => true,
        'dstlongname' => "Central European Summer Time",
        'dstshortname' => 'CEST' ),
    'Europe/Copenhagen' => array(
        'offset' => 3600000,
        'longname' => "Central European Time",
        'shortname' => 'CET',
        'hasdst' => true,
        'dstlongname' => "Central European Summer Time",
        'dstshortname' => 'CEST' ),
    'Europe/Gibraltar' => array(
        'offset' => 3600000,
        'longname' => "Central European Time",
        'shortname' => 'CET',
        'hasdst' => true,
        'dstlongname' => "Central European Summer Time",
        'dstshortname' => 'CEST' ),
    'Europe/Ljubljana' => array(
        'offset' => 3600000,
        'longname' => "Central European Time",
        'shortname' => 'CET',
        'hasdst' => true,
        'dstlongname' => "Central European Summer Time",
        'dstshortname' => 'CEST' ),
    'Europe/Luxembourg' => array(
        'offset' => 3600000,
        'longname' => "Central European Time",
        'shortname' => 'CET',
        'hasdst' => true,
        'dstlongname' => "Central European Summer Time",
        'dstshortname' => 'CEST' ),
    'Europe/Madrid' => array(
        'offset' => 3600000,
        'longname' => "Central European Time",
        'shortname' => 'CET',
        'hasdst' => true,
        'dstlongname' => "Central European Summer Time",
        'dstshortname' => 'CEST' ),
    'Europe/Malta' => array(
        'offset' => 3600000,
        'longname' => "Central European Time",
        'shortname' => 'CET',
        'hasdst' => true,
        'dstlongname' => "Central European Summer Time",
        'dstshortname' => 'CEST' ),
    'Europe/Monaco' => array(
        'offset' => 3600000,
        'longname' => "Central European Time",
        'shortname' => 'CET',
        'hasdst' => true,
        'dstlongname' => "Central European Summer Time",
        'dstshortname' => 'CEST' ),
    'Europe/Oslo' => array(
        'offset' => 3600000,
        'longname' => "Central European Time",
        'shortname' => 'CET',
        'hasdst' => true,
        'dstlongname' => "Central European Summer Time",
        'dstshortname' => 'CEST' ),
    'Europe/Paris' => array(
        'offset' => 3600000,
        'longname' => "Central European Time",
        'shortname' => 'CET',
        'hasdst' => true,
        'dstlongname' => "Central European Summer Time",
        'dstshortname' => 'CEST' ),
    'Europe/Prague' => array(
        'offset' => 3600000,
        'longname' => "Central European Time",
        'shortname' => 'CET',
        'hasdst' => true,
        'dstlongname' => "Central European Summer Time",
        'dstshortname' => 'CEST' ),
    'Europe/Rome' => array(
        'offset' => 3600000,
        'longname' => "Central European Time",
        'shortname' => 'CET',
        'hasdst' => true,
        'dstlongname' => "Central European Summer Time",
        'dstshortname' => 'CEST' ),
    'Europe/San_Marino' => array(
        'offset' => 3600000,
        'longname' => "Central European Time",
        'shortname' => 'CET',
        'hasdst' => true,
        'dstlongname' => "Central European Summer Time",
        'dstshortname' => 'CEST' ),
    'Europe/Sarajevo' => array(
        'offset' => 3600000,
        'longname' => "Central European Time",
        'shortname' => 'CET',
        'hasdst' => true,
        'dstlongname' => "Central European Summer Time",
        'dstshortname' => 'CEST' ),
    'Europe/Skopje' => array(
        'offset' => 3600000,
        'longname' => "Central European Time",
        'shortname' => 'CET',
        'hasdst' => true,
        'dstlongname' => "Central European Summer Time",
        'dstshortname' => 'CEST' ),
    'Europe/Stockholm' => array(
        'offset' => 3600000,
        'longname' => "Central European Time",
        'shortname' => 'CET',
        'hasdst' => true,
        'dstlongname' => "Central European Summer Time",
        'dstshortname' => 'CEST' ),
    'Europe/Tirane' => array(
        'offset' => 3600000,
        'longname' => "Central European Time",
        'shortname' => 'CET',
        'hasdst' => true,
        'dstlongname' => "Central European Summer Time",
        'dstshortname' => 'CEST' ),
    'Europe/Vaduz' => array(
        'offset' => 3600000,
        'longname' => "Central European Time",
        'shortname' => 'CET',
        'hasdst' => true,
        'dstlongname' => "Central European Summer Time",
        'dstshortname' => 'CEST' ),
    'Europe/Vatican' => array(
        'offset' => 3600000,
        'longname' => "Central European Time",
        'shortname' => 'CET',
        'hasdst' => true,
        'dstlongname' => "Central European Summer Time",
        'dstshortname' => 'CEST' ),
    'Europe/Vienna' => array(
        'offset' => 3600000,
        'longname' => "Central European Time",
        'shortname' => 'CET',
        'hasdst' => true,
        'dstlongname' => "Central European Summer Time",
        'dstshortname' => 'CEST' ),
    'Europe/Warsaw' => array(
        'offset' => 3600000,
        'longname' => "Central European Time",
        'shortname' => 'CET',
        'hasdst' => true,
        'dstlongname' => "Central European Summer Time",
        'dstshortname' => 'CEST' ),
    'Europe/Zagreb' => array(
        'offset' => 3600000,
        'longname' => "Central European Time",
        'shortname' => 'CET',
        'hasdst' => true,
        'dstlongname' => "Central European Summer Time",
        'dstshortname' => 'CEST' ),
    'Europe/Zurich' => array(
        'offset' => 3600000,
        'longname' => "Central European Time",
        'shortname' => 'CET',
        'hasdst' => true,
        'dstlongname' => "Central European Summer Time",
        'dstshortname' => 'CEST' ),
    'MET' => array(
        'offset' => 3600000,
        'longname' => "Middle Europe Time",
        'shortname' => 'MET',
        'hasdst' => true,
        'dstlongname' => "Middle Europe Summer Time",
        'dstshortname' => 'MEST' ),
    'Poland' => array(
        'offset' => 3600000,
        'longname' => "Central European Time",
        'shortname' => 'CET',
        'hasdst' => true,
        'dstlongname' => "Central European Summer Time",
        'dstshortname' => 'CEST' ),
    'ART' => array(
        'offset' => 7200000,
        'longname' => "Eastern European Time",
        'shortname' => 'EET',
        'hasdst' => true,
        'dstlongname' => "Eastern European Summer Time",
        'dstshortname' => 'EEST' ),
    'Africa/Blantyre' => array(
        'offset' => 7200000,
        'longname' => "Central African Time",
        'shortname' => 'CAT',
        'hasdst' => false ),
    'Africa/Bujumbura' => array(
        'offset' => 7200000,
        'longname' => "Central African Time",
        'shortname' => 'CAT',
        'hasdst' => false ),
    'Africa/Cairo' => array(
        'offset' => 7200000,
        'longname' => "Eastern European Time",
        'shortname' => 'EET',
        'hasdst' => true,
        'dstlongname' => "Eastern European Summer Time",
        'dstshortname' => 'EEST' ),
    'Africa/Gaborone' => array(
        'offset' => 7200000,
        'longname' => "Central African Time",
        'shortname' => 'CAT',
        'hasdst' => false ),
    'Africa/Harare' => array(
        'offset' => 7200000,
        'longname' => "Central African Time",
        'shortname' => 'CAT',
        'hasdst' => false ),
    'Africa/Johannesburg' => array(
        'offset' => 7200000,
        'longname' => "South Africa Standard Time",
        'shortname' => 'SAST',
        'hasdst' => false ),
    'Africa/Kigali' => array(
        'offset' => 7200000,
        'longname' => "Central African Time",
        'shortname' => 'CAT',
        'hasdst' => false ),
    'Africa/Lubumbashi' => array(
        'offset' => 7200000,
        'longname' => "Central African Time",
        'shortname' => 'CAT',
        'hasdst' => false ),
    'Africa/Lusaka' => array(
        'offset' => 7200000,
        'longname' => "Central African Time",
        'shortname' => 'CAT',
        'hasdst' => false ),
    'Africa/Maputo' => array(
        'offset' => 7200000,
        'longname' => "Central African Time",
        'shortname' => 'CAT',
        'hasdst' => false ),
    'Africa/Maseru' => array(
        'offset' => 7200000,
        'longname' => "South Africa Standard Time",
        'shortname' => 'SAST',
        'hasdst' => false ),
    'Africa/Mbabane' => array(
        'offset' => 7200000,
        'longname' => "South Africa Standard Time",
        'shortname' => 'SAST',
        'hasdst' => false ),
    'Africa/Tripoli' => array(
        'offset' => 7200000,
        'longname' => "Eastern European Time",
        'shortname' => 'EET',
        'hasdst' => false ),
    'Asia/Amman' => array(
        'offset' => 7200000,
        'longname' => "Eastern European Time",
        'shortname' => 'EET',
        'hasdst' => true,
        'dstlongname' => "Eastern European Summer Time",
        'dstshortname' => 'EEST' ),
    'Asia/Beirut' => array(
        'offset' => 7200000,
        'longname' => "Eastern European Time",
        'shortname' => 'EET',
        'hasdst' => true,
        'dstlongname' => "Eastern European Summer Time",
        'dstshortname' => 'EEST' ),
    'Asia/Damascus' => array(
        'offset' => 7200000,
        'longname' => "Eastern European Time",
        'shortname' => 'EET',
        'hasdst' => true,
        'dstlongname' => "Eastern European Summer Time",
        'dstshortname' => 'EEST' ),
    'Asia/Gaza' => array(
        'offset' => 7200000,
        'longname' => "Eastern European Time",
        'shortname' => 'EET',
        'hasdst' => true,
        'dstlongname' => "Eastern European Summer Time",
        'dstshortname' => 'EEST' ),
    'Asia/Istanbul' => array(
        'offset' => 7200000,
        'longname' => "Eastern European Time",
        'shortname' => 'EET',
        'hasdst' => true,
        'dstlongname' => "Eastern European Summer Time",
        'dstshortname' => 'EEST' ),
    'Asia/Jerusalem' => array(
        'offset' => 7200000,
        'longname' => "Israel Standard Time",
        'shortname' => 'IST',
        'hasdst' => true,
        'dstlongname' => "Israel Daylight Time",
        'dstshortname' => 'IDT' ),
    'Asia/Nicosia' => array(
        'offset' => 7200000,
        'longname' => "Eastern European Time",
        'shortname' => 'EET',
        'hasdst' => true,
        'dstlongname' => "Eastern European Summer Time",
        'dstshortname' => 'EEST' ),
    'Asia/Tel_Aviv' => array(
        'offset' => 7200000,
        'longname' => "Israel Standard Time",
        'shortname' => 'IST',
        'hasdst' => true,
        'dstlongname' => "Israel Daylight Time",
        'dstshortname' => 'IDT' ),
    'CAT' => array(
        'offset' => 7200000,
        'longname' => "Central African Time",
        'shortname' => 'CAT',
        'hasdst' => false ),
    'EET' => array(
        'offset' => 7200000,
        'longname' => "Eastern European Time",
        'shortname' => 'EET',
        'hasdst' => true,
        'dstlongname' => "Eastern European Summer Time",
        'dstshortname' => 'EEST' ),
    'Egypt' => array(
        'offset' => 7200000,
        'longname' => "Eastern European Time",
        'shortname' => 'EET',
        'hasdst' => true,
        'dstlongname' => "Eastern European Summer Time",
        'dstshortname' => 'EEST' ),
    'Etc/GMT-2' => array(
        'offset' => 7200000,
        'longname' => "GMT+02:00",
        'shortname' => 'GMT+02:00',
        'hasdst' => false ),
    'Europe/Athens' => array(
        'offset' => 7200000,
        'longname' => "Eastern European Time",
        'shortname' => 'EET',
        'hasdst' => true,
        'dstlongname' => "Eastern European Summer Time",
        'dstshortname' => 'EEST' ),
    'Europe/Bucharest' => array(
        'offset' => 7200000,
        'longname' => "Eastern European Time",
        'shortname' => 'EET',
        'hasdst' => true,
        'dstlongname' => "Eastern European Summer Time",
        'dstshortname' => 'EEST' ),
    'Europe/Chisinau' => array(
        'offset' => 7200000,
        'longname' => "Eastern European Time",
        'shortname' => 'EET',
        'hasdst' => true,
        'dstlongname' => "Eastern European Summer Time",
        'dstshortname' => 'EEST' ),
    'Europe/Helsinki' => array(
        'offset' => 7200000,
        'longname' => "Eastern European Time",
        'shortname' => 'EET',
        'hasdst' => true,
        'dstlongname' => "Eastern European Summer Time",
        'dstshortname' => 'EEST' ),
    'Europe/Istanbul' => array(
        'offset' => 7200000,
        'longname' => "Eastern European Time",
        'shortname' => 'EET',
        'hasdst' => true,
        'dstlongname' => "Eastern European Summer Time",
        'dstshortname' => 'EEST' ),
    'Europe/Kaliningrad' => array(
        'offset' => 7200000,
        'longname' => "Eastern European Time",
        'shortname' => 'EET',
        'hasdst' => true,
        'dstlongname' => "Eastern European Summer Time",
        'dstshortname' => 'EEST' ),
    'Europe/Kiev' => array(
        'offset' => 7200000,
        'longname' => "Eastern European Time",
        'shortname' => 'EET',
        'hasdst' => true,
        'dstlongname' => "Eastern European Summer Time",
        'dstshortname' => 'EEST' ),
    'Europe/Minsk' => array(
        'offset' => 7200000,
        'longname' => "Eastern European Time",
        'shortname' => 'EET',
        'hasdst' => true,
        'dstlongname' => "Eastern European Summer Time",
        'dstshortname' => 'EEST' ),
    'Europe/Nicosia' => array(
        'offset' => 7200000,
        'longname' => "Eastern European Time",
        'shortname' => 'EET',
        'hasdst' => true,
        'dstlongname' => "Eastern European Summer Time",
        'dstshortname' => 'EEST' ),
    'Europe/Riga' => array(
        'offset' => 7200000,
        'longname' => "Eastern European Time",
        'shortname' => 'EET',
        'hasdst' => true,
        'dstlongname' => "Eastern European Summer Time",
        'dstshortname' => 'EEST' ),
    'Europe/Simferopol' => array(
        'offset' => 7200000,
        'longname' => "Eastern European Time",
        'shortname' => 'EET',
        'hasdst' => true,
        'dstlongname' => "Eastern European Summer Time",
        'dstshortname' => 'EEST' ),
    'Europe/Sofia' => array(
        'offset' => 7200000,
        'longname' => "Eastern European Time",
        'shortname' => 'EET',
        'hasdst' => true,
        'dstlongname' => "Eastern European Summer Time",
        'dstshortname' => 'EEST' ),
    'Europe/Tallinn' => array(
        'offset' => 7200000,
        'longname' => "Eastern European Time",
        'shortname' => 'EET',
        'hasdst' => false ),
    'Europe/Tiraspol' => array(
        'offset' => 7200000,
        'longname' => "Eastern European Time",
        'shortname' => 'EET',
        'hasdst' => true,
        'dstlongname' => "Eastern European Summer Time",
        'dstshortname' => 'EEST' ),
    'Europe/Uzhgorod' => array(
        'offset' => 7200000,
        'longname' => "Eastern European Time",
        'shortname' => 'EET',
        'hasdst' => true,
        'dstlongname' => "Eastern European Summer Time",
        'dstshortname' => 'EEST' ),
    'Europe/Vilnius' => array(
        'offset' => 7200000,
        'longname' => "Eastern European Time",
        'shortname' => 'EET',
        'hasdst' => false ),
    'Europe/Zaporozhye' => array(
        'offset' => 7200000,
        'longname' => "Eastern European Time",
        'shortname' => 'EET',
        'hasdst' => true,
        'dstlongname' => "Eastern European Summer Time",
        'dstshortname' => 'EEST' ),
    'Israel' => array(
        'offset' => 7200000,
        'longname' => "Israel Standard Time",
        'shortname' => 'IST',
        'hasdst' => true,
        'dstlongname' => "Israel Daylight Time",
        'dstshortname' => 'IDT' ),
    'Libya' => array(
        'offset' => 7200000,
        'longname' => "Eastern European Time",
        'shortname' => 'EET',
        'hasdst' => false ),
    'Turkey' => array(
        'offset' => 7200000,
        'longname' => "Eastern European Time",
        'shortname' => 'EET',
        'hasdst' => true,
        'dstlongname' => "Eastern European Summer Time",
        'dstshortname' => 'EEST' ),
    'Africa/Addis_Ababa' => array(
        'offset' => 10800000,
        'longname' => "Eastern African Time",
        'shortname' => 'EAT',
        'hasdst' => false ),
    'Africa/Asmera' => array(
        'offset' => 10800000,
        'longname' => "Eastern African Time",
        'shortname' => 'EAT',
        'hasdst' => false ),
    'Africa/Dar_es_Salaam' => array(
        'offset' => 10800000,
        'longname' => "Eastern African Time",
        'shortname' => 'EAT',
        'hasdst' => false ),
    'Africa/Djibouti' => array(
        'offset' => 10800000,
        'longname' => "Eastern African Time",
        'shortname' => 'EAT',
        'hasdst' => false ),
    'Africa/Kampala' => array(
        'offset' => 10800000,
        'longname' => "Eastern African Time",
        'shortname' => 'EAT',
        'hasdst' => false ),
    'Africa/Khartoum' => array(
        'offset' => 10800000,
        'longname' => "Eastern African Time",
        'shortname' => 'EAT',
        'hasdst' => false ),
    'Africa/Mogadishu' => array(
        'offset' => 10800000,
        'longname' => "Eastern African Time",
        'shortname' => 'EAT',
        'hasdst' => false ),
    'Africa/Nairobi' => array(
        'offset' => 10800000,
        'longname' => "Eastern African Time",
        'shortname' => 'EAT',
        'hasdst' => false ),
    'Antarctica/Syowa' => array(
        'offset' => 10800000,
        'longname' => "Syowa Time",
        'shortname' => 'SYOT',
        'hasdst' => false ),
    'Asia/Aden' => array(
        'offset' => 10800000,
        'longname' => "Arabia Standard Time",
        'shortname' => 'AST',
        'hasdst' => false ),
    'Asia/Baghdad' => array(
        'offset' => 10800000,
        'longname' => "Arabia Standard Time",
        'shortname' => 'AST',
        'hasdst' => true,
        'dstlongname' => "Arabia Daylight Time",
        'dstshortname' => 'ADT' ),
    'Asia/Bahrain' => array(
        'offset' => 10800000,
        'longname' => "Arabia Standard Time",
        'shortname' => 'AST',
        'hasdst' => false ),
    'Asia/Kuwait' => array(
        'offset' => 10800000,
        'longname' => "Arabia Standard Time",
        'shortname' => 'AST',
        'hasdst' => false ),
    'Asia/Qatar' => array(
        'offset' => 10800000,
        'longname' => "Arabia Standard Time",
        'shortname' => 'AST',
        'hasdst' => false ),
    'Asia/Riyadh' => array(
        'offset' => 10800000,
        'longname' => "Arabia Standard Time",
        'shortname' => 'AST',
        'hasdst' => false ),
    'EAT' => array(
        'offset' => 10800000,
        'longname' => "Eastern African Time",
        'shortname' => 'EAT',
        'hasdst' => false ),
    'Etc/GMT-3' => array(
        'offset' => 10800000,
        'longname' => "GMT+03:00",
        'shortname' => 'GMT+03:00',
        'hasdst' => false ),
    'Europe/Moscow' => array(
        'offset' => 10800000,
        'longname' => "Moscow Standard Time",
        'shortname' => 'MSK',
        'hasdst' => true,
        'dstlongname' => "Moscow Daylight Time",
        'dstshortname' => 'MSD' ),
    'Indian/Antananarivo' => array(
        'offset' => 10800000,
        'longname' => "Eastern African Time",
        'shortname' => 'EAT',
        'hasdst' => false ),
    'Indian/Comoro' => array(
        'offset' => 10800000,
        'longname' => "Eastern African Time",
        'shortname' => 'EAT',
        'hasdst' => false ),
    'Indian/Mayotte' => array(
        'offset' => 10800000,
        'longname' => "Eastern African Time",
        'shortname' => 'EAT',
        'hasdst' => false ),
    'W-SU' => array(
        'offset' => 10800000,
        'longname' => "Moscow Standard Time",
        'shortname' => 'MSK',
        'hasdst' => true,
        'dstlongname' => "Moscow Daylight Time",
        'dstshortname' => 'MSD' ),
    'Asia/Riyadh87' => array(
        'offset' => 11224000,
        'longname' => "GMT+03:07",
        'shortname' => 'GMT+03:07',
        'hasdst' => false ),
    'Asia/Riyadh88' => array(
        'offset' => 11224000,
        'longname' => "GMT+03:07",
        'shortname' => 'GMT+03:07',
        'hasdst' => false ),
    'Asia/Riyadh89' => array(
        'offset' => 11224000,
        'longname' => "GMT+03:07",
        'shortname' => 'GMT+03:07',
        'hasdst' => false ),
    'Mideast/Riyadh87' => array(
        'offset' => 11224000,
        'longname' => "GMT+03:07",
        'shortname' => 'GMT+03:07',
        'hasdst' => false ),
    'Mideast/Riyadh88' => array(
        'offset' => 11224000,
        'longname' => "GMT+03:07",
        'shortname' => 'GMT+03:07',
        'hasdst' => false ),
    'Mideast/Riyadh89' => array(
        'offset' => 11224000,
        'longname' => "GMT+03:07",
        'shortname' => 'GMT+03:07',
        'hasdst' => false ),
    'Asia/Tehran' => array(
        'offset' => 12600000,
        'longname' => "Iran Time",
        'shortname' => 'IRT',
        'hasdst' => true,
        'dstlongname' => "Iran Sumer Time",
        'dstshortname' => 'IRST' ),
    'Iran' => array(
        'offset' => 12600000,
        'longname' => "Iran Time",
        'shortname' => 'IRT',
        'hasdst' => true,
        'dstlongname' => "Iran Sumer Time",
        'dstshortname' => 'IRST' ),
    'Asia/Aqtau' => array(
        'offset' => 14400000,
        'longname' => "Aqtau Time",
        'shortname' => 'AQTT',
        'hasdst' => true,
        'dstlongname' => "Aqtau Summer Time",
        'dstshortname' => 'AQTST' ),
    'Asia/Baku' => array(
        'offset' => 14400000,
        'longname' => "Azerbaijan Time",
        'shortname' => 'AZT',
        'hasdst' => true,
        'dstlongname' => "Azerbaijan Summer Time",
        'dstshortname' => 'AZST' ),
    'Asia/Dubai' => array(
        'offset' => 14400000,
        'longname' => "Gulf Standard Time",
        'shortname' => 'GST',
        'hasdst' => false ),
    'Asia/Muscat' => array(
        'offset' => 14400000,
        'longname' => "Gulf Standard Time",
        'shortname' => 'GST',
        'hasdst' => false ),
    'Asia/Tbilisi' => array(
        'offset' => 14400000,
        'longname' => "Georgia Time",
        'shortname' => 'GET',
        'hasdst' => true,
        'dstlongname' => "Georgia Summer Time",
        'dstshortname' => 'GEST' ),
    'Asia/Yerevan' => array(
        'offset' => 14400000,
        'longname' => "Armenia Time",
        'shortname' => 'AMT',
        'hasdst' => true,
        'dstlongname' => "Armenia Summer Time",
        'dstshortname' => 'AMST' ),
    'Etc/GMT-4' => array(
        'offset' => 14400000,
        'longname' => "GMT+04:00",
        'shortname' => 'GMT+04:00',
        'hasdst' => false ),
    'Europe/Samara' => array(
        'offset' => 14400000,
        'longname' => "Samara Time",
        'shortname' => 'SAMT',
        'hasdst' => true,
        'dstlongname' => "Samara Summer Time",
        'dstshortname' => 'SAMST' ),
    'Indian/Mahe' => array(
        'offset' => 14400000,
        'longname' => "Seychelles Time",
        'shortname' => 'SCT',
        'hasdst' => false ),
    'Indian/Mauritius' => array(
        'offset' => 14400000,
        'longname' => "Mauritius Time",
        'shortname' => 'MUT',
        'hasdst' => false ),
    'Indian/Reunion' => array(
        'offset' => 14400000,
        'longname' => "Reunion Time",
        'shortname' => 'RET',
        'hasdst' => false ),
    'NET' => array(
        'offset' => 14400000,
        'longname' => "Armenia Time",
        'shortname' => 'AMT',
        'hasdst' => true,
        'dstlongname' => "Armenia Summer Time",
        'dstshortname' => 'AMST' ),
    'Asia/Kabul' => array(
        'offset' => 16200000,
        'longname' => "Afghanistan Time",
        'shortname' => 'AFT',
        'hasdst' => false ),
    'Asia/Aqtobe' => array(
        'offset' => 18000000,
        'longname' => "Aqtobe Time",
        'shortname' => 'AQTT',
        'hasdst' => true,
        'dstlongname' => "Aqtobe Summer Time",
        'dstshortname' => 'AQTST' ),
    'Asia/Ashgabat' => array(
        'offset' => 18000000,
        'longname' => "Turkmenistan Time",
        'shortname' => 'TMT',
        'hasdst' => false ),
    'Asia/Ashkhabad' => array(
        'offset' => 18000000,
        'longname' => "Turkmenistan Time",
        'shortname' => 'TMT',
        'hasdst' => false ),
    'Asia/Bishkek' => array(
        'offset' => 18000000,
        'longname' => "Kirgizstan Time",
        'shortname' => 'KGT',
        'hasdst' => true,
        'dstlongname' => "Kirgizstan Summer Time",
        'dstshortname' => 'KGST' ),
    'Asia/Dushanbe' => array(
        'offset' => 18000000,
        'longname' => "Tajikistan Time",
        'shortname' => 'TJT',
        'hasdst' => false ),
    'Asia/Karachi' => array(
        'offset' => 18000000,
        'longname' => "Pakistan Time",
        'shortname' => 'PKT',
        'hasdst' => false ),
    'Asia/Samarkand' => array(
        'offset' => 18000000,
        'longname' => "Turkmenistan Time",
        'shortname' => 'TMT',
        'hasdst' => false ),
    'Asia/Tashkent' => array(
        'offset' => 18000000,
        'longname' => "Uzbekistan Time",
        'shortname' => 'UZT',
        'hasdst' => false ),
    'Asia/Yekaterinburg' => array(
        'offset' => 18000000,
        'longname' => "Yekaterinburg Time",
        'shortname' => 'YEKT',
        'hasdst' => true,
        'dstlongname' => "Yekaterinburg Summer Time",
        'dstshortname' => 'YEKST' ),
    'Etc/GMT-5' => array(
        'offset' => 18000000,
        'longname' => "GMT+05:00",
        'shortname' => 'GMT+05:00',
        'hasdst' => false ),
    'Indian/Kerguelen' => array(
        'offset' => 18000000,
        'longname' => "French Southern & Antarctic Lands Time",
        'shortname' => 'TFT',
        'hasdst' => false ),
    'Indian/Maldives' => array(
        'offset' => 18000000,
        'longname' => "Maldives Time",
        'shortname' => 'MVT',
        'hasdst' => false ),
    'PLT' => array(
        'offset' => 18000000,
        'longname' => "Pakistan Time",
        'shortname' => 'PKT',
        'hasdst' => false ),
    'Asia/Calcutta' => array(
        'offset' => 19800000,
        'longname' => "India Standard Time",
        'shortname' => 'IST',
        'hasdst' => false ),
    'IST' => array(
        'offset' => 19800000,
        'longname' => "India Standard Time",
        'shortname' => 'IST',
        'hasdst' => false ),
    'Asia/Katmandu' => array(
        'offset' => 20700000,
        'longname' => "Nepal Time",
        'shortname' => 'NPT',
        'hasdst' => false ),
    'Antarctica/Mawson' => array(
        'offset' => 21600000,
        'longname' => "Mawson Time",
        'shortname' => 'MAWT',
        'hasdst' => false ),
    'Antarctica/Vostok' => array(
        'offset' => 21600000,
        'longname' => "Vostok time",
        'shortname' => 'VOST',
        'hasdst' => false ),
    'Asia/Almaty' => array(
        'offset' => 21600000,
        'longname' => "Alma-Ata Time",
        'shortname' => 'ALMT',
        'hasdst' => true,
        'dstlongname' => "Alma-Ata Summer Time",
        'dstshortname' => 'ALMST' ),
    'Asia/Colombo' => array(
        'offset' => 21600000,
        'longname' => "Sri Lanka Time",
        'shortname' => 'LKT',
        'hasdst' => false ),
    'Asia/Dacca' => array(
        'offset' => 21600000,
        'longname' => "Bangladesh Time",
        'shortname' => 'BDT',
        'hasdst' => false ),
    'Asia/Dhaka' => array(
        'offset' => 21600000,
        'longname' => "Bangladesh Time",
        'shortname' => 'BDT',
        'hasdst' => false ),
    'Asia/Novosibirsk' => array(
        'offset' => 21600000,
        'longname' => "Novosibirsk Time",
        'shortname' => 'NOVT',
        'hasdst' => true,
        'dstlongname' => "Novosibirsk Summer Time",
        'dstshortname' => 'NOVST' ),
    'Asia/Omsk' => array(
        'offset' => 21600000,
        'longname' => "Omsk Time",
        'shortname' => 'OMST',
        'hasdst' => true,
        'dstlongname' => "Omsk Summer Time",
        'dstshortname' => 'OMSST' ),
    'Asia/Thimbu' => array(
        'offset' => 21600000,
        'longname' => "Bhutan Time",
        'shortname' => 'BTT',
        'hasdst' => false ),
    'Asia/Thimphu' => array(
        'offset' => 21600000,
        'longname' => "Bhutan Time",
        'shortname' => 'BTT',
        'hasdst' => false ),
    'BDT' => array(
        'offset' => 21600000,
        'longname' => "Bangladesh Time",
        'shortname' => 'BDT',
        'hasdst' => true ),
    'Etc/GMT-6' => array(
        'offset' => 21600000,
        'longname' => "GMT+06:00",
        'shortname' => 'GMT+06:00',
        'hasdst' => false ),
    'Indian/Chagos' => array(
        'offset' => 21600000,
        'longname' => "Indian Ocean Territory Time",
        'shortname' => 'IOT',
        'hasdst' => false ),
    'Asia/Rangoon' => array(
        'offset' => 23400000,
        'longname' => "Myanmar Time",
        'shortname' => 'MMT',
        'hasdst' => false ),
    'Indian/Cocos' => array(
        'offset' => 23400000,
        'longname' => "Cocos Islands Time",
        'shortname' => 'CCT',
        'hasdst' => false ),
    'Antarctica/Davis' => array(
        'offset' => 25200000,
        'longname' => "Davis Time",
        'shortname' => 'DAVT',
        'hasdst' => false ),
    'Asia/Bangkok' => array(
        'offset' => 25200000,
        'longname' => "Indochina Time",
        'shortname' => 'ICT',
        'hasdst' => false ),
    'Asia/Hovd' => array(
        'offset' => 25200000,
        'longname' => "Hovd Time",
        'shortname' => 'HOVT',
        'hasdst' => false ),
    'Asia/Jakarta' => array(
        'offset' => 25200000,
        'longname' => "West Indonesia Time",
        'shortname' => 'WIT',
        'hasdst' => false ),
    'Asia/Krasnoyarsk' => array(
        'offset' => 25200000,
        'longname' => "Krasnoyarsk Time",
        'shortname' => 'KRAT',
        'hasdst' => true,
        'dstlongname' => "Krasnoyarsk Summer Time",
        'dstshortname' => 'KRAST' ),
    'Asia/Phnom_Penh' => array(
        'offset' => 25200000,
        'longname' => "Indochina Time",
        'shortname' => 'ICT',
        'hasdst' => false ),
    'Asia/Pontianak' => array(
        'offset' => 25200000,
        'longname' => "West Indonesia Time",
        'shortname' => 'WIT',
        'hasdst' => false ),
    'Asia/Saigon' => array(
        'offset' => 25200000,
        'longname' => "Indochina Time",
        'shortname' => 'ICT',
        'hasdst' => false ),
    'Asia/Vientiane' => array(
        'offset' => 25200000,
        'longname' => "Indochina Time",
        'shortname' => 'ICT',
        'hasdst' => false ),
    'Etc/GMT-7' => array(
        'offset' => 25200000,
        'longname' => "GMT+07:00",
        'shortname' => 'GMT+07:00',
        'hasdst' => false ),
    'Indian/Christmas' => array(
        'offset' => 25200000,
        'longname' => "Christmas Island Time",
        'shortname' => 'CXT',
        'hasdst' => false ),
    'VST' => array(
        'offset' => 25200000,
        'longname' => "Indochina Time",
        'shortname' => 'ICT',
        'hasdst' => false ),
    'Antarctica/Casey' => array(
        'offset' => 28800000,
        'longname' => "Western Standard Time (Australia)",
        'shortname' => 'WST',
        'hasdst' => false ),
    'Asia/Brunei' => array(
        'offset' => 28800000,
        'longname' => "Brunei Time",
        'shortname' => 'BNT',
        'hasdst' => false ),
    'Asia/Chongqing' => array(
        'offset' => 28800000,
        'longname' => "China Standard Time",
        'shortname' => 'CST',
        'hasdst' => false ),
    'Asia/Chungking' => array(
        'offset' => 28800000,
        'longname' => "China Standard Time",
        'shortname' => 'CST',
        'hasdst' => false ),
    'Asia/Harbin' => array(
        'offset' => 28800000,
        'longname' => "China Standard Time",
        'shortname' => 'CST',
        'hasdst' => false ),
    'Asia/Hong_Kong' => array(
        'offset' => 28800000,
        'longname' => "Hong Kong Time",
        'shortname' => 'HKT',
        'hasdst' => false ),
    'Asia/Irkutsk' => array(
        'offset' => 28800000,
        'longname' => "Irkutsk Time",
        'shortname' => 'IRKT',
        'hasdst' => true,
        'dstlongname' => "Irkutsk Summer Time",
        'dstshortname' => 'IRKST' ),
    'Asia/Kashgar' => array(
        'offset' => 28800000,
        'longname' => "China Standard Time",
        'shortname' => 'CST',
        'hasdst' => false ),
    'Asia/Kuala_Lumpur' => array(
        'offset' => 28800000,
        'longname' => "Malaysia Time",
        'shortname' => 'MYT',
        'hasdst' => false ),
    'Asia/Kuching' => array(
        'offset' => 28800000,
        'longname' => "Malaysia Time",
        'shortname' => 'MYT',
        'hasdst' => false ),
    'Asia/Macao' => array(
        'offset' => 28800000,
        'longname' => "China Standard Time",
        'shortname' => 'CST',
        'hasdst' => false ),
    'Asia/Manila' => array(
        'offset' => 28800000,
        'longname' => "Philippines Time",
        'shortname' => 'PHT',
        'hasdst' => false ),
    'Asia/Shanghai' => array(
        'offset' => 28800000,
        'longname' => "China Standard Time",
        'shortname' => 'CST',
        'hasdst' => false ),
    'Asia/Singapore' => array(
        'offset' => 28800000,
        'longname' => "Singapore Time",
        'shortname' => 'SGT',
        'hasdst' => false ),
    'Asia/Taipei' => array(
        'offset' => 28800000,
        'longname' => "China Standard Time",
        'shortname' => 'CST',
        'hasdst' => false ),
    'Asia/Ujung_Pandang' => array(
        'offset' => 28800000,
        'longname' => "Central Indonesia Time",
        'shortname' => 'CIT',
        'hasdst' => false ),
    'Asia/Ulaanbaatar' => array(
        'offset' => 28800000,
        'longname' => "Ulaanbaatar Time",
        'shortname' => 'ULAT',
        'hasdst' => false ),
    'Asia/Ulan_Bator' => array(
        'offset' => 28800000,
        'longname' => "Ulaanbaatar Time",
        'shortname' => 'ULAT',
        'hasdst' => false ),
    'Asia/Urumqi' => array(
        'offset' => 28800000,
        'longname' => "China Standard Time",
        'shortname' => 'CST',
        'hasdst' => false ),
    'Australia/Perth' => array(
        'offset' => 28800000,
        'longname' => "Western Standard Time (Australia)",
        'shortname' => 'WST',
        'hasdst' => false ),
    'Australia/West' => array(
        'offset' => 28800000,
        'longname' => "Western Standard Time (Australia)",
        'shortname' => 'WST',
        'hasdst' => false ),
    'CTT' => array(
        'offset' => 28800000,
        'longname' => "China Standard Time",
        'shortname' => 'CST',
        'hasdst' => false ),
    'Etc/GMT-8' => array(
        'offset' => 28800000,
        'longname' => "GMT+08:00",
        'shortname' => 'GMT+08:00',
        'hasdst' => false ),
    'Hongkong' => array(
        'offset' => 28800000,
        'longname' => "Hong Kong Time",
        'shortname' => 'HKT',
        'hasdst' => false ),
    'PRC' => array(
        'offset' => 28800000,
        'longname' => "China Standard Time",
        'shortname' => 'CST',
        'hasdst' => false ),
    'Singapore' => array(
        'offset' => 28800000,
        'longname' => "Singapore Time",
        'shortname' => 'SGT',
        'hasdst' => false ),
    'Asia/Choibalsan' => array(
        'offset' => 32400000,
        'longname' => "Choibalsan Time",
        'shortname' => 'CHOT',
        'hasdst' => false ),
    'Asia/Dili' => array(
        'offset' => 32400000,
        'longname' => "East Timor Time",
        'shortname' => 'TPT',
        'hasdst' => false ),
    'Asia/Jayapura' => array(
        'offset' => 32400000,
        'longname' => "East Indonesia Time",
        'shortname' => 'EIT',
        'hasdst' => false ),
    'Asia/Pyongyang' => array(
        'offset' => 32400000,
        'longname' => "Korea Standard Time",
        'shortname' => 'KST',
        'hasdst' => false ),
    'Asia/Seoul' => array(
        'offset' => 32400000,
        'longname' => "Korea Standard Time",
        'shortname' => 'KST',
        'hasdst' => false ),
    'Asia/Tokyo' => array(
        'offset' => 32400000,
        'longname' => "Japan Standard Time",
        'shortname' => 'JST',
        'hasdst' => false ),
    'Asia/Yakutsk' => array(
        'offset' => 32400000,
        'longname' => "Yakutsk Time",
        'shortname' => 'YAKT',
        'hasdst' => true,
        'dstlongname' => "Yaktsk Summer Time",
        'dstshortname' => 'YAKST' ),
    'Etc/GMT-9' => array(
        'offset' => 32400000,
        'longname' => "GMT+09:00",
        'shortname' => 'GMT+09:00',
        'hasdst' => false ),
    'JST' => array(
        'offset' => 32400000,
        'longname' => "Japan Standard Time",
        'shortname' => 'JST',
        'hasdst' => false ),
    'Japan' => array(
        'offset' => 32400000,
        'longname' => "Japan Standard Time",
        'shortname' => 'JST',
        'hasdst' => false ),
    'Pacific/Palau' => array(
        'offset' => 32400000,
        'longname' => "Palau Time",
        'shortname' => 'PWT',
        'hasdst' => false ),
    'ROK' => array(
        'offset' => 32400000,
        'longname' => "Korea Standard Time",
        'shortname' => 'KST',
        'hasdst' => false ),
    'ACT' => array(
        'offset' => 34200000,
        'longname' => "Central Standard Time (Northern Territory)",
        'shortname' => 'CST',
        'hasdst' => false ),
    'Australia/Adelaide' => array(
        'offset' => 34200000,
        'longname' => "Central Standard Time (South Australia)",
        'shortname' => 'CST',
        'hasdst' => true,
        'dstlongname' => "Central Summer Time (South Australia)",
        'dstshortname' => 'CST' ),
    'Australia/Broken_Hill' => array(
        'offset' => 34200000,
        'longname' => "Central Standard Time (South Australia/New South Wales)",
        'shortname' => 'CST',
        'hasdst' => true,
        'dstlongname' => "Central Summer Time (South Australia/New South Wales)",
        'dstshortname' => 'CST' ),
    'Australia/Darwin' => array(
        'offset' => 34200000,
        'longname' => "Central Standard Time (Northern Territory)",
        'shortname' => 'CST',
        'hasdst' => false ),
    'Australia/North' => array(
        'offset' => 34200000,
        'longname' => "Central Standard Time (Northern Territory)",
        'shortname' => 'CST',
        'hasdst' => false ),
    'Australia/South' => array(
        'offset' => 34200000,
        'longname' => "Central Standard Time (South Australia)",
        'shortname' => 'CST',
        'hasdst' => true,
        'dstlongname' => "Central Summer Time (South Australia)",
        'dstshortname' => 'CST' ),
    'Australia/Yancowinna' => array(
        'offset' => 34200000,
        'longname' => "Central Standard Time (South Australia/New South Wales)",
        'shortname' => 'CST',
        'hasdst' => true,
        'dstlongname' => "Central Summer Time (South Australia/New South Wales)",
        'dstshortname' => 'CST' ),
    'AET' => array(
        'offset' => 36000000,
        'longname' => "Eastern Standard Time (New South Wales)",
        'shortname' => 'EST',
        'hasdst' => true,
        'dstlongname' => "Eastern Summer Time (New South Wales)",
        'dstshortname' => 'EST' ),
    'Antarctica/DumontDUrville' => array(
        'offset' => 36000000,
        'longname' => "Dumont-d'Urville Time",
        'shortname' => 'DDUT',
        'hasdst' => false ),
    'Asia/Sakhalin' => array(
        'offset' => 36000000,
        'longname' => "Sakhalin Time",
        'shortname' => 'SAKT',
        'hasdst' => true,
        'dstlongname' => "Sakhalin Summer Time",
        'dstshortname' => 'SAKST' ),
    'Asia/Vladivostok' => array(
        'offset' => 36000000,
        'longname' => "Vladivostok Time",
        'shortname' => 'VLAT',
        'hasdst' => true,
        'dstlongname' => "Vladivostok Summer Time",
        'dstshortname' => 'VLAST' ),
    'Australia/ACT' => array(
        'offset' => 36000000,
        'longname' => "Eastern Standard Time (New South Wales)",
        'shortname' => 'EST',
        'hasdst' => true,
        'dstlongname' => "Eastern Summer Time (New South Wales)",
        'dstshortname' => 'EST' ),
    'Australia/Brisbane' => array(
        'offset' => 36000000,
        'longname' => "Eastern Standard Time (Queensland)",
        'shortname' => 'EST',
        'hasdst' => false ),
    'Australia/Canberra' => array(
        'offset' => 36000000,
        'longname' => "Eastern Standard Time (New South Wales)",
        'shortname' => 'EST',
        'hasdst' => true,
        'dstlongname' => "Eastern Summer Time (New South Wales)",
        'dstshortname' => 'EST' ),
    'Australia/Hobart' => array(
        'offset' => 36000000,
        'longname' => "Eastern Standard Time (Tasmania)",
        'shortname' => 'EST',
        'hasdst' => true,
        'dstlongname' => "Eastern Summer Time (Tasmania)",
        'dstshortname' => 'EST' ),
    'Australia/Lindeman' => array(
        'offset' => 36000000,
        'longname' => "Eastern Standard Time (Queensland)",
        'shortname' => 'EST',
        'hasdst' => false ),
    'Australia/Melbourne' => array(
        'offset' => 36000000,
        'longname' => "Eastern Standard Time (Victoria)",
        'shortname' => 'EST',
        'hasdst' => true,
        'dstlongname' => "Eastern Summer Time (Victoria)",
        'dstshortname' => 'EST' ),
    'Australia/NSW' => array(
        'offset' => 36000000,
        'longname' => "Eastern Standard Time (New South Wales)",
        'shortname' => 'EST',
        'hasdst' => true,
        'dstlongname' => "Eastern Summer Time (New South Wales)",
        'dstshortname' => 'EST' ),
    'Australia/Queensland' => array(
        'offset' => 36000000,
        'longname' => "Eastern Standard Time (Queensland)",
        'shortname' => 'EST',
        'hasdst' => false ),
    'Australia/Sydney' => array(
        'offset' => 36000000,
        'longname' => "Eastern Standard Time (New South Wales)",
        'shortname' => 'EST',
        'hasdst' => true,
        'dstlongname' => "Eastern Summer Time (New South Wales)",
        'dstshortname' => 'EST' ),
    'Australia/Tasmania' => array(
        'offset' => 36000000,
        'longname' => "Eastern Standard Time (Tasmania)",
        'shortname' => 'EST',
        'hasdst' => true,
        'dstlongname' => "Eastern Summer Time (Tasmania)",
        'dstshortname' => 'EST' ),
    'Australia/Victoria' => array(
        'offset' => 36000000,
        'longname' => "Eastern Standard Time (Victoria)",
        'shortname' => 'EST',
        'hasdst' => true,
        'dstlongname' => "Eastern Summer Time (Victoria)",
        'dstshortname' => 'EST' ),
    'Etc/GMT-10' => array(
        'offset' => 36000000,
        'longname' => "GMT+10:00",
        'shortname' => 'GMT+10:00',
        'hasdst' => false ),
    'Pacific/Guam' => array(
        'offset' => 36000000,
        'longname' => "Chamorro Standard Time",
        'shortname' => 'ChST',
        'hasdst' => false ),
    'Pacific/Port_Moresby' => array(
        'offset' => 36000000,
        'longname' => "Papua New Guinea Time",
        'shortname' => 'PGT',
        'hasdst' => false ),
    'Pacific/Saipan' => array(
        'offset' => 36000000,
        'longname' => "Chamorro Standard Time",
        'shortname' => 'ChST',
        'hasdst' => false ),
    'Pacific/Truk' => array(
        'offset' => 36000000,
        'longname' => "Truk Time",
        'shortname' => 'TRUT',
        'hasdst' => false ),
    'Pacific/Yap' => array(
        'offset' => 36000000,
        'longname' => "Yap Time",
        'shortname' => 'YAPT',
        'hasdst' => false ),
    'Australia/LHI' => array(
        'offset' => 37800000,
        'longname' => "Load Howe Standard Time",
        'shortname' => 'LHST',
        'hasdst' => true,
        'dstlongname' => "Load Howe Summer Time",
        'dstshortname' => 'LHST' ),
    'Australia/Lord_Howe' => array(
        'offset' => 37800000,
        'longname' => "Load Howe Standard Time",
        'shortname' => 'LHST',
        'hasdst' => true,
        'dstlongname' => "Load Howe Summer Time",
        'dstshortname' => 'LHST' ),
    'Asia/Magadan' => array(
        'offset' => 39600000,
        'longname' => "Magadan Time",
        'shortname' => 'MAGT',
        'hasdst' => true,
        'dstlongname' => "Magadan Summer Time",
        'dstshortname' => 'MAGST' ),
    'Etc/GMT-11' => array(
        'offset' => 39600000,
        'longname' => "GMT+11:00",
        'shortname' => 'GMT+11:00',
        'hasdst' => false ),
    'Pacific/Efate' => array(
        'offset' => 39600000,
        'longname' => "Vanuatu Time",
        'shortname' => 'VUT',
        'hasdst' => false ),
    'Pacific/Guadalcanal' => array(
        'offset' => 39600000,
        'longname' => "Solomon Is. Time",
        'shortname' => 'SBT',
        'hasdst' => false ),
    'Pacific/Kosrae' => array(
        'offset' => 39600000,
        'longname' => "Kosrae Time",
        'shortname' => 'KOST',
        'hasdst' => false ),
    'Pacific/Noumea' => array(
        'offset' => 39600000,
        'longname' => "New Caledonia Time",
        'shortname' => 'NCT',
        'hasdst' => false ),
    'Pacific/Ponape' => array(
        'offset' => 39600000,
        'longname' => "Ponape Time",
        'shortname' => 'PONT',
        'hasdst' => false ),
    'SST' => array(
        'offset' => 39600000,
        'longname' => "Solomon Is. Time",
        'shortname' => 'SBT',
        'hasdst' => false ),
    'Pacific/Norfolk' => array(
        'offset' => 41400000,
        'longname' => "Norfolk Time",
        'shortname' => 'NFT',
        'hasdst' => false ),
    'Antarctica/McMurdo' => array(
        'offset' => 43200000,
        'longname' => "New Zealand Standard Time",
        'shortname' => 'NZST',
        'hasdst' => true,
        'dstlongname' => "New Zealand Daylight Time",
        'dstshortname' => 'NZDT' ),
    'Antarctica/South_Pole' => array(
        'offset' => 43200000,
        'longname' => "New Zealand Standard Time",
        'shortname' => 'NZST',
        'hasdst' => true,
        'dstlongname' => "New Zealand Daylight Time",
        'dstshortname' => 'NZDT' ),
    'Asia/Anadyr' => array(
        'offset' => 43200000,
        'longname' => "Anadyr Time",
        'shortname' => 'ANAT',
        'hasdst' => true,
        'dstlongname' => "Anadyr Summer Time",
        'dstshortname' => 'ANAST' ),
    'Asia/Kamchatka' => array(
        'offset' => 43200000,
        'longname' => "Petropavlovsk-Kamchatski Time",
        'shortname' => 'PETT',
        'hasdst' => true,
        'dstlongname' => "Petropavlovsk-Kamchatski Summer Time",
        'dstshortname' => 'PETST' ),
    'Etc/GMT-12' => array(
        'offset' => 43200000,
        'longname' => "GMT+12:00",
        'shortname' => 'GMT+12:00',
        'hasdst' => false ),
    'Kwajalein' => array(
        'offset' => 43200000,
        'longname' => "Marshall Islands Time",
        'shortname' => 'MHT',
        'hasdst' => false ),
    'NST' => array(
        'offset' => 43200000,
        'longname' => "New Zealand Standard Time",
        'shortname' => 'NZST',
        'hasdst' => true,
        'dstlongname' => "New Zealand Daylight Time",
        'dstshortname' => 'NZDT' ),
    'NZ' => array(
        'offset' => 43200000,
        'longname' => "New Zealand Standard Time",
        'shortname' => 'NZST',
        'hasdst' => true,
        'dstlongname' => "New Zealand Daylight Time",
        'dstshortname' => 'NZDT' ),
    'Pacific/Auckland' => array(
        'offset' => 43200000,
        'longname' => "New Zealand Standard Time",
        'shortname' => 'NZST',
        'hasdst' => true,
        'dstlongname' => "New Zealand Daylight Time",
        'dstshortname' => 'NZDT' ),
    'Pacific/Fiji' => array(
        'offset' => 43200000,
        'longname' => "Fiji Time",
        'shortname' => 'FJT',
        'hasdst' => false ),
    'Pacific/Funafuti' => array(
        'offset' => 43200000,
        'longname' => "Tuvalu Time",
        'shortname' => 'TVT',
        'hasdst' => false ),
    'Pacific/Kwajalein' => array(
        'offset' => 43200000,
        'longname' => "Marshall Islands Time",
        'shortname' => 'MHT',
        'hasdst' => false ),
    'Pacific/Majuro' => array(
        'offset' => 43200000,
        'longname' => "Marshall Islands Time",
        'shortname' => 'MHT',
        'hasdst' => false ),
    'Pacific/Nauru' => array(
        'offset' => 43200000,
        'longname' => "Nauru Time",
        'shortname' => 'NRT',
        'hasdst' => false ),
    'Pacific/Tarawa' => array(
        'offset' => 43200000,
        'longname' => "Gilbert Is. Time",
        'shortname' => 'GILT',
        'hasdst' => false ),
    'Pacific/Wake' => array(
        'offset' => 43200000,
        'longname' => "Wake Time",
        'shortname' => 'WAKT',
        'hasdst' => false ),
    'Pacific/Wallis' => array(
        'offset' => 43200000,
        'longname' => "Wallis & Futuna Time",
        'shortname' => 'WFT',
        'hasdst' => false ),
    'NZ-CHAT' => array(
        'offset' => 45900000,
        'longname' => "Chatham Standard Time",
        'shortname' => 'CHAST',
        'hasdst' => true,
        'dstlongname' => "Chatham Daylight Time",
        'dstshortname' => 'CHADT' ),
    'Pacific/Chatham' => array(
        'offset' => 45900000,
        'longname' => "Chatham Standard Time",
        'shortname' => 'CHAST',
        'hasdst' => true,
        'dstlongname' => "Chatham Daylight Time",
        'dstshortname' => 'CHADT' ),
    'Etc/GMT-13' => array(
        'offset' => 46800000,
        'longname' => "GMT+13:00",
        'shortname' => 'GMT+13:00',
        'hasdst' => false ),
    'Pacific/Enderbury' => array(
        'offset' => 46800000,
        'longname' => "Phoenix Is. Time",
        'shortname' => 'PHOT',
        'hasdst' => false ),
    'Pacific/Tongatapu' => array(
        'offset' => 46800000,
        'longname' => "Tonga Time",
        'shortname' => 'TOT',
        'hasdst' => false ),
    'Etc/GMT-14' => array(
        'offset' => 50400000,
        'longname' => "GMT+14:00",
        'shortname' => 'GMT+14:00',
        'hasdst' => false ),
    'Pacific/Kiritimati' => array(
        'offset' => 50400000,
        'longname' => "Line Is. Time",
        'shortname' => 'LINT',
        'hasdst' => false )
);

//
// Initialize default timezone
//  First try _DATE_TIMEZONE_DEFAULT global,
//  then PHP_TZ environment var, then TZ environment var
//
if(isset($_DATE_TIMEZONE_DEFAULT)
    && Date_TimeZone::isValidID($_DATE_TIMEZONE_DEFAULT)
) {
    Date_TimeZone::setDefault($_DATE_TIMEZONE_DEFAULT);
} elseif (getenv('PHP_TZ') && Date_TimeZone::isValidID(getenv('PHP_TZ'))) {
    Date_TimeZone::setDefault(getenv('PHP_TZ'));
} elseif (getenv('TZ') && Date_TimeZone::isValidID(getenv('TZ'))) {
    Date_TimeZone::setDefault(getenv('TZ'));
} elseif (Date_TimeZone::isValidID(date('T'))) {
    Date_TimeZone::setDefault(date('T'));
} else {
    Date_TimeZone::setDefault('UTC');
}
//
// END
?>
