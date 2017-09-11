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

require_once MAX_PATH . '/lib/pear/Date.php';

/**
 * A static helper class to deal with date/time conversions and formatting.
 *
 * @package    RV_Admin
 * @subpackage DateTimeFormat
 */
class RV_Admin_DateTimeFormat
{

    /**
     * A method that takes a UTC date/time string (e.g. as stored in the
     * database) and formats it using the user's locale information - both in
     * terms of the user's local timezone, and using the appropriate date/time
     * representation.
     *
     * @param string dateTime The date/time to be formatted, in a string format
     * @return string The date/time in the user's timezone/locale format
     */
    public static function formatUTCDateTime($sDateTime)
    {
        // Convert the date/time string to a PEAR Date object in the user
        // locale's timezone
        $oDateTime = RV_Admin_DateTimeFormat::_convertUTCtoUserTZ($sDateTime);
        // Obtain the globally set $date_format and $time_format values
        // from the user's locale which defines how the date/time output
        // string should be formatted
        global $date_format, $time_format;
        // Return the converted PEAR Date object in the appropriate locale
        // format for date/time values
        return $oDateTime->format("$date_format $time_format");
    }

    /**
     * A method that takes a UTC date/time string (e.g. as stored in the
     * database) and formats it using the user's locale information - both in
     * terms of the user's local timezone, and using the appropriate date
     * representation.
     *
     * @param string dateTime The date/time to be formatted, in a string format
     * @return string The date/time formatted as a date only, in the user's
     *                timezone/locale format
     */
    public static function formatUTCDate($sDateTime)
    {
        // Convert the date string to a PEAR Date object in the user
        // locale's timezone
        $oDate = RV_Admin_DateTimeFormat::_convertUTCtoUserTZ($sDateTime);
        // Obtain the globally set $date_format value from the user's locale
        // which defines how the date output string should be formatted
        global $date_format;
        // Return the converted PEAR Date object in the appropriate locale
        // format for date values
        return $oDate->format("$date_format");
    }

    /**
     * A method that takes a UTC date/time string (e.g. as stored in the
     * database) and formats it using the user's locale information - both in
     * terms of the user's local timezone, and using the appropriate time
     * representation.
     *
     * @param string dateTime The date/time to be formatted, in a string format
     * @return string The date/time formatted as a time only, in the user's
     *                timezone/locale format
     */
    public static function formatUTCTime($sDateTime)
    {
        // Convert the time string to a PEAR Date object in the user
        // locale's timezone
        $oTime = RV_Admin_DateTimeFormat::_convertUTCtoUserTZ($sDateTime);
        // Obtain the globally set $time_format value from the user's locale
        // which defines how the time output string should be formatted
        global $time_format;
        // Return the converted PEAR Date object in the appropriate locale
        // format for time values
        return $oTime->format("$time_format");
    }

    /**
     * A private method that takes a UTC date, time or date/time string
     * and converts it into a PEAR Date object, converting the date, time or
     * date/time into the user locale's timezone.
     *
     * @param type $sDateTime The date, time or date/time , in a string format
     * @return PEAR::Date The date, time or date/time as a PEAR Date object,
     *                    in the user locale's timezone
     */
    private static function _convertUTCtoUserTZ($sDateTime)
    {
        // Create a PEAR Date object from the supplied date/time string
        $oDateTime = new Date($sDateTime);
        // New PEAR Date object will be automatically created in the user's
        // current timezone - store what that timezone is
        $oTz = $oDateTime->tz;
        // Update the PEAR Date object to set it to have the UTC timezone,
        // without actually changing the date & time values
        $oDateTime->setTZbyID('UTC');
        // Convert the PEAR Date object into the original timezone, but with
        // the required changeing of the date & time values
        $oDateTime->convertTZ($oTz);
        // Return the PEAR Date object
        return $oDateTime;
    }

}

?>