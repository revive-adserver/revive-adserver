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
        // Return the date/time using the user's locale information
        return RV_Admin_DateTimeFormat::_formatLocalDateTime($oDateTime);
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
        // Convert the date/time string to a PEAR Date object in the user
        // locale's timezone
        $oDateTime = RV_Admin_DateTimeFormat::_convertUTCtoUserTZ($sDateTime);
        // Return the date only using the user's locale information
        return RV_Admin_DateTimeFormat::_formatLocalDate($oDateTime);
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
        // Convert the date/time string to a PEAR Date object in the user
        // locale's timezone
        $oDateTime = RV_Admin_DateTimeFormat::_convertUTCtoUserTZ($sDateTime);
        // Return the time only using the user's locale information
        return RV_Admin_DateTimeFormat::_formatLocalTime($oDateTime);
    }

    /**
     * A method that takes a local timezone date/time string and formats it
     * using the user's locale information - i.e. using the appropriate
     * date/time representation.
     *
     * @param string dateTime The date/time to be formatted, in a string format
     * @return string The date/time in the user's locale format
     */
    public static function formatLocalDateTime($sDateTime)
    {
        // Convert the date/time string to a PEAR Date object
        $oDateTime = new Date($sDateTime);
        // Return the date/time using the user's locale information
        return RV_Admin_DateTimeFormat::_formatLocalDateTime($oDateTime);
    }

    /**
     * A method that takes a local timezone date/time string and formats it
     * using the user's locale information - i.e. using the appropriate
     * date representation.
     *
     * @param string dateTime The date/time to be formatted, in a string format
     * @return string The date/time formatted as a date only, in the user's
     *                locale format
     */
    public static function formatLocalDate($sDateTime)
    {
        // Convert the date/time string to a PEAR Date object
        $oDateTime = new Date($sDateTime);
        // Return the date only using the user's locale information
        return RV_Admin_DateTimeFormat::_formatLocalDate($oDateTime);
    }

    /**
     * A method that takes a local timezone date/time string and formats it
     * using the user's locale information - i.e. using the appropriate
     * time representation.
     *
     * @param string dateTime The date/time to be formatted, in a string format
     * @return string The date/time formatted as a time only, in the user's
     *                locale format
     */
    public static function formatLocalTime($sDateTime)
    {
        // Convert the date/time string to a PEAR Date object
        $oDateTime = new Date($sDateTime);
        // Return the time only using the user's locale information
        return RV_Admin_DateTimeFormat::_formatLocalTime($oDateTime);
    }

    /**
     * A private method that takes a UTC date, time or date/time string
     * and converts it into a PEAR Date object, converting the date, time or
     * date/time into the user's local timezone.
     *
     * @param string $sDateTime The date, time or date/time , in a string format
     * @return PEAR::Date The date, time or date/time as a PEAR Date object,
     *                    in the user's local timezone
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
        // the required changing of the date & time values
        $oDateTime->convertTZ($oTz);
        // Return the PEAR Date object
        return $oDateTime;
    }

    /**
     * A private method that takes a PEAR Date object in the user's local
     * timezone, and returns a date/time string, formatted according to the
     * user's locale format.
     *
     * @param PEAR::Date $oDateTime The date/time to format.
     * @return string The date and time, formatted according to the user's
     *                locale format.
     */
    private static function _formatLocalDateTime($oDateTime)
    {
        return $oDateTime->format("{$GLOBALS['date_format']} {$GLOBALS['time_format']}");
    }

    /**
     * A private method that takes a PEAR Date object in the user's local
     * timezone, and returns a date string, formatted according to the
     * user's locale format.
     *
     * @param PEAR::Date $oDateTime The date/time to format.
     * @return string The date only, formatted according to the user's
     *                locale format.
     */
    private static function _formatLocalDate($oDateTime)
    {
        return $oDateTime->format("{$GLOBALS['date_format']}");
    }

    /**
     * A private method that takes a PEAR Date object in the user's local
     * timezone, and returns a time string, formatted according to the
     * user's locale format.
     *
     * @param PEAR::Date $oDateTime The date/time to format.
     * @return string The time only, formatted according to the user's
     *                locale format.
     */
    private static function _formatLocalTime($oDateTime)
    {
        return $oDateTime->format("{$GLOBALS['time_format']}");
    }
}
