<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
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
// |          Pierre-Alain Joye <pajoye@php.net>                          |
// +----------------------------------------------------------------------+
//
// $Id$

/**@#+
 * Include supporting classes
 */
require_once 'Date/TimeZone.php';
require_once 'Date/Calc.php';
require_once 'Date/Span.php';
/**@#-*/

/**@#+
 * Output formats.  Pass this to getDate().
 */
/**
 * "YYYY-MM-DD HH:MM:SS"
 */
define('DATE_FORMAT_ISO', 1);
/**
 * "YYYYMMSSTHHMMSS(Z|(+/-)HHMM)?"
 */
define('DATE_FORMAT_ISO_BASIC', 2);
/**
 * "YYYY-MM-SSTHH:MM:SS(Z|(+/-)HH:MM)?"
 */
define('DATE_FORMAT_ISO_EXTENDED', 3);
/**
 * "YYYY-MM-SSTHH:MM:SS(.S*)?(Z|(+/-)HH:MM)?"
 */
define('DATE_FORMAT_ISO_EXTENDED_MICROTIME', 6);
/**
 * "YYYYMMDDHHMMSS"
 */
define('DATE_FORMAT_TIMESTAMP', 4);
/**
 * long int, seconds since the unix epoch
 */
define('DATE_FORMAT_UNIXTIME', 5);
/**@#-*/

/**
 * Generic date handling class for PEAR.
 *
 * Generic date handling class for PEAR.  Attempts to be time zone aware
 * through the Date::TimeZone class.  Supports several operations from
 * Date::Calc on Date objects.
 *
 * @author Baba Buehler <baba@babaz.com>
 * @package Date
 * @access public
 */
class Date
{
    /**
     * the year
     * @var int
     */
    var $year;
    /**
     * the month
     * @var int
     */
    var $month;
    /**
     * the day
     * @var int
     */
    var $day;
    /**
     * the hour
     * @var int
     */
    var $hour;
    /**
     * the minute
     * @var int
     */
    var $minute;
    /**
     * the second
     * @var int
     */
    var $second;
    /**
     * the parts of a second
     * @var float
     */
    var $partsecond;
    /**
     * timezone for this date
     * @var object Date_TimeZone
     */
    var $tz;


    /**
     * Constructor
     *
     * Creates a new Date Object initialized to the current date/time in the
     * system-default timezone by default.  A date optionally
     * passed in may be in the ISO 8601, TIMESTAMP or UNIXTIME format,
     * or another Date object.  If no date is passed, the current date/time
     * is used.
     *
     * @access public
     * @see setDate()
     * @param mixed $date optional - date/time to initialize
     * @return object Date the new Date object
     */
    function Date($date = null)
    {
        $this->tz = Date_TimeZone::getDefault();
        if (is_null($date)) {
            $this->setDate(date("Y-m-d H:i:s"));
        } elseif (is_a($date, 'Date')) {
            $this->copy($date);
        } else {
            $this->setDate($date);
        }
    }

    /**
     * Set the fields of a Date object based on the input date and format
     *
     * Set the fields of a Date object based on the input date and format,
     * which is specified by the DATE_FORMAT_* constants.
     *
     * @access public
     * @param string $date input date
     * @param int $format Optional format constant (DATE_FORMAT_*) of the input date.
     *                    This parameter isn't really needed anymore, but you could
     *                    use it to force DATE_FORMAT_UNIXTIME.
     */
    function setDate($date, $format = DATE_FORMAT_ISO)
    {

        if (
            preg_match('/^(\d{4})-?(\d{2})-?(\d{2})([T\s]?(\d{2}):?(\d{2}):?(\d{2})(\.\d+)?(Z|[\+\-]\d{2}:?\d{2})?)?$/i', $date, $regs)
            && $format != DATE_FORMAT_UNIXTIME) {
            // DATE_FORMAT_ISO, ISO_BASIC, ISO_EXTENDED, and TIMESTAMP
            // These formats are extremely close to each other.  This regex
            // is very loose and accepts almost any butchered format you could
            // throw at it.  e.g. 2003-10-07 19:45:15 and 2003-10071945:15
            // are the same thing in the eyes of this regex, even though the
            // latter is not a valid ISO 8601 date.
            $this->year       = $regs[1];
            $this->month      = $regs[2];
            $this->day        = $regs[3];
            $this->hour       = isset($regs[5])?$regs[5]:0;
            $this->minute     = isset($regs[6])?$regs[6]:0;
            $this->second     = isset($regs[7])?$regs[7]:0;
            $this->partsecond = isset($regs[8])?(float)$regs[8]:(float)0;

            // if an offset is defined, convert time to UTC
            // Date currently can't set a timezone only by offset,
            // so it has to store it as UTC
            if (isset($regs[9])) {
                $this->toUTCbyOffset($regs[9]);
            }
        } elseif (is_numeric($date)) {
            // UNIXTIME
            $this->setDate(date("Y-m-d H:i:s", $date));
        } else {
            // unknown format
            $this->year       = 0;
            $this->month      = 1;
            $this->day        = 1;
            $this->hour       = 0;
            $this->minute     = 0;
            $this->second     = 0;
            $this->partsecond = (float)0;
        }
    }

    /**
     * Get a string (or other) representation of this date
     *
     * Get a string (or other) representation of this date in the
     * format specified by the DATE_FORMAT_* constants.
     *
     * @access public
     * @param int $format format constant (DATE_FORMAT_*) of the output date
     * @return string the date in the requested format
     */
    function getDate($format = DATE_FORMAT_ISO)
    {
        switch ($format) {
        case DATE_FORMAT_ISO:
            return $this->format("%Y-%m-%d %T");
            break;
        case DATE_FORMAT_ISO_BASIC:
            $format = "%Y%m%dT%H%M%S";
            if ($this->tz->getID() == 'UTC') {
                $format .= "Z";
            }
            return $this->format($format);
            break;
        case DATE_FORMAT_ISO_EXTENDED:
            $format = "%Y-%m-%dT%H:%M:%S";
            if ($this->tz->getID() == 'UTC') {
                $format .= "Z";
            }
            return $this->format($format);
            break;
        case DATE_FORMAT_ISO_EXTENDED_MICROTIME:
            $format = "%Y-%m-%dT%H:%M:%s";
            if ($this->tz->getID() == 'UTC') {
                $format .= "Z";
            }
            return $this->format($format);
            break;
        case DATE_FORMAT_TIMESTAMP:
            return $this->format("%Y%m%d%H%M%S");
            break;
        case DATE_FORMAT_UNIXTIME:
            return mktime($this->hour, $this->minute, $this->second, $this->month, $this->day, $this->year);
            break;
        }
    }

    /**
     * Copy values from another Date object
     *
     * Makes this Date a copy of another Date object.
     *
     * @access public
     * @param object Date $date Date to copy from
     */
    function copy($date)
    {
        $this->year = $date->year;
        $this->month = $date->month;
        $this->day = $date->day;
        $this->hour = $date->hour;
        $this->minute = $date->minute;
        $this->second = $date->second;
        $this->tz = $date->tz;
    }

    /**
     *  Date pretty printing, similar to strftime()
     *
     *  Formats the date in the given format, much like
     *  strftime().  Most strftime() options are supported.<br><br>
     *
     *  formatting options:<br><br>
     *
     *  <code>%a  </code>  abbreviated weekday name (Sun, Mon, Tue) <br>
     *  <code>%A  </code>  full weekday name (Sunday, Monday, Tuesday) <br>
     *  <code>%b  </code>  abbreviated month name (Jan, Feb, Mar) <br>
     *  <code>%B  </code>  full month name (January, February, March) <br>
     *  <code>%C  </code>  century number (the year divided by 100 and truncated to an integer, range 00 to 99) <br>
     *  <code>%d  </code>  day of month (range 00 to 31) <br>
     *  <code>%D  </code>  same as "%m/%d/%y" <br>
     *  <code>%e  </code>  day of month, single digit (range 0 to 31) <br>
     *  <code>%E  </code>  number of days since unspecified epoch (integer, Date_Calc::dateToDays()) <br>
     *  <code>%H  </code>  hour as decimal number (00 to 23) <br>
     *  <code>%I  </code>  hour as decimal number on 12-hour clock (01 to 12) <br>
     *  <code>%j  </code>  day of year (range 001 to 366) <br>
     *  <code>%m  </code>  month as decimal number (range 01 to 12) <br>
     *  <code>%M  </code>  minute as a decimal number (00 to 59) <br>
     *  <code>%n  </code>  newline character (\n) <br>
     *  <code>%O  </code>  dst-corrected timezone offset expressed as "+/-HH:MM" <br>
     *  <code>%o  </code>  raw timezone offset expressed as "+/-HH:MM" <br>
     *  <code>%p  </code>  either 'am' or 'pm' depending on the time <br>
     *  <code>%P  </code>  either 'AM' or 'PM' depending on the time <br>
     *  <code>%r  </code>  time in am/pm notation, same as "%I:%M:%S %p" <br>
     *  <code>%R  </code>  time in 24-hour notation, same as "%H:%M" <br>
     *  <code>%s  </code>  seconds including the decimal representation smaller than one second <br>
     *  <code>%S  </code>  seconds as a decimal number (00 to 59) <br>
     *  <code>%t  </code>  tab character (\t) <br>
     *  <code>%T  </code>  current time, same as "%H:%M:%S" <br>
     *  <code>%w  </code>  weekday as decimal (0 = Sunday) <br>
     *  <code>%U  </code>  week number of current year, first sunday as first week <br>
     *  <code>%y  </code>  year as decimal (range 00 to 99) <br>
     *  <code>%Y  </code>  year as decimal including century (range 0000 to 9999) <br>
     *  <code>%%  </code>  literal '%' <br>
     * <br>
     *
     * @access public
     * @param string format the format string for returned date/time
     * @return string date/time in given format
     */
    function format($format)
    {
        $output = "";

        for($strpos = 0; $strpos < strlen($format); $strpos++) {
            $char = substr($format,$strpos,1);
            if ($char == "%") {
                $nextchar = substr($format,$strpos + 1,1);
                switch ($nextchar) {
                case "a":
                    $output .= Date_Calc::getWeekdayAbbrname($this->day,$this->month,$this->year);
                    break;
                case "A":
                    $output .= Date_Calc::getWeekdayFullname($this->day,$this->month,$this->year);
                    break;
                case "b":
                    $output .= Date_Calc::getMonthAbbrname($this->month);
                    break;
                case "B":
                    $output .= Date_Calc::getMonthFullname($this->month);
                    break;
                case "C":
                    $output .= sprintf("%02d",intval($this->year/100));
                    break;
                case "d":
                    $output .= sprintf("%02d",$this->day);
                    break;
                case "D":
                    $output .= sprintf("%02d/%02d/%02d",$this->month,$this->day,$this->year);
                    break;
                case "e":
                    $output .= $this->day * 1; // get rid of leading zero
                    break;
                case "E":
                    $output .= Date_Calc::dateToDays($this->day,$this->month,$this->year);
                    break;
                case "H":
                    $output .= sprintf("%02d", $this->hour);
                    break;
                case "I":
                    $hour = ($this->hour + 1) > 12 ? $this->hour - 12 : $this->hour;
                    $output .= sprintf("%02d", $hour==0 ? 12 : $hour);
                    break;
                case "j":
                    $output .= Date_Calc::julianDate($this->day,$this->month,$this->year);
                    break;
                case "m":
                    $output .= sprintf("%02d",$this->month);
                    break;
                case "M":
                    $output .= sprintf("%02d",$this->minute);
                    break;
                case "n":
                    $output .= "\n";
                    break;
                case "O":
                    $offms = $this->tz->getOffset($this);
                    $direction = $offms >= 0 ? "+" : "-";
                    $offmins = abs($offms) / 1000 / 60;
                    $hours = $offmins / 60;
                    $minutes = $offmins % 60;
                    $output .= sprintf("%s%02d:%02d", $direction, $hours, $minutes);
                    break;
                case "o":
                    $offms = $this->tz->getRawOffset($this);
                    $direction = $offms >= 0 ? "+" : "-";
                    $offmins = abs($offms) / 1000 / 60;
                    $hours = $offmins / 60;
                    $minutes = $offmins % 60;
                    $output .= sprintf("%s%02d:%02d", $direction, $hours, $minutes);
                    break;
                case "p":
                    $output .= $this->hour >= 12 ? "pm" : "am";
                    break;
                case "P":
                    $output .= $this->hour >= 12 ? "PM" : "AM";
                    break;
                case "r":
                    $hour = ($this->hour + 1) > 12 ? $this->hour - 12 : $this->hour;
                    $output .= sprintf("%02d:%02d:%02d %s", $hour==0 ?  12 : $hour, $this->minute, $this->second, $this->hour >= 12 ? "PM" : "AM");
                    break;
                case "R":
                    $output .= sprintf("%02d:%02d", $this->hour, $this->minute);
                    break;
                case "s":
                    $output .= sprintf("%02f", (float)((float)$this->second + $this->partsecond));
                    break;
                case "S":
                    $output .= sprintf("%02d", $this->second);
                    break;
                case "t":
                    $output .= "\t";
                    break;
                case "T":
                    $output .= sprintf("%02d:%02d:%02d", $this->hour, $this->minute, $this->second);
                    break;
                case "w":
                    $output .= Date_Calc::dayOfWeek($this->day,$this->month,$this->year);
                    break;
                case "U":
                    $output .= Date_Calc::weekOfYear($this->day,$this->month,$this->year);
                    break;
                case "y":
                    $output .= substr($this->year,2,2);
                    break;
                case "Y":
                    $output .= $this->year;
                    break;
                case "Z":
                    $output .= $this->tz->inDaylightTime($this) ? $this->tz->getDSTShortName() : $this->tz->getShortName();
                    break;
                case "%":
                    $output .= "%";
                    break;
                default:
                    $output .= $char.$nextchar;
                }
                $strpos++;
            } else {
                $output .= $char;
            }
        }
        return $output;

    }

    /**
     * Get this date/time in Unix time() format
     *
     * Get a representation of this date in Unix time() format.  This may only be
     * valid for dates from 1970 to ~2038.
     *
     * @access public
     * @return int number of seconds since the unix epoch
     */
    function getTime()
    {
        return $this->getDate(DATE_FORMAT_UNIXTIME);
    }

    /**
     * Sets the time zone of this Date
     *
     * Sets the time zone of this date with the given
     * Date_TimeZone object.  Does not alter the date/time,
     * only assigns a new time zone.  For conversion, use
     * convertTZ().
     *
     * @access public
     * @param object Date_TimeZone $tz the Date_TimeZone object to use, if called
     * with a paramater that is not a Date_TimeZone object, will fall through to
     * setTZbyID().
     */
    function setTZ($tz)
    {
    	if(is_a($tz, 'Date_Timezone')) {
        	$this->tz = $tz;
    	} else {
    		$this->setTZbyID($tz);
    	}
    }

    /**
     * Sets the time zone of this date with the given time zone id
     *
     * Sets the time zone of this date with the given
     * time zone id, or to the system default if the
     * given id is invalid. Does not alter the date/time,
     * only assigns a new time zone.  For conversion, use
     * convertTZ().
     *
     * @access public
     * @param string id a time zone id
     */
    function setTZbyID($id)
    {
        if (Date_TimeZone::isValidID($id)) {
            $this->tz = new Date_TimeZone($id);
        } else {
            $this->tz = Date_TimeZone::getDefault();
        }
    }

    /**
     * Tests if this date/time is in DST
     *
     * Returns true if daylight savings time is in effect for
     * this date in this date's time zone.  See Date_TimeZone::inDaylightTime()
     * for compatability information.
     *
     * @access public
     * @return boolean true if DST is in effect for this date
     */
    function inDaylightTime()
    {
        return $this->tz->inDaylightTime($this);
    }

    /**
     * Converts this date to UTC and sets this date's timezone to UTC
     *
     * Converts this date to UTC and sets this date's timezone to UTC
     *
     * @access public
     */
    function toUTC()
    {
        if ($this->tz->getOffset($this) > 0) {
            $this->subtractSeconds(intval($this->tz->getOffset($this) / 1000));
        } else {
            $this->addSeconds(intval(abs($this->tz->getOffset($this)) / 1000));
        }
        $this->tz = new Date_TimeZone('UTC');
    }

    /**
     * Converts this date to a new time zone
     *
     * Converts this date to a new time zone.
     * WARNING: This may not work correctly if your system does not allow
     * putenv() or if localtime() does not work in your environment.  See
     * Date::TimeZone::inDaylightTime() for more information.
     *
     * @access public
     * @param object Date_TimeZone $tz the Date::TimeZone object for the conversion time zone
     */
    function convertTZ($tz)
    {
        // convert to UTC
        if ($this->tz->getOffset($this) > 0) {
            $this->subtractSeconds(intval(abs($this->tz->getOffset($this)) / 1000));
        } else {
            $this->addSeconds(intval(abs($this->tz->getOffset($this)) / 1000));
        }
        // convert UTC to new timezone
        if ($tz->getOffset($this) > 0) {
            $this->addSeconds(intval(abs($tz->getOffset($this)) / 1000));
        } else {
            $this->subtractSeconds(intval(abs($tz->getOffset($this)) / 1000));
        }
        $this->tz = $tz;
    }

    /**
     * Converts this date to a new time zone, given a valid time zone ID
     *
     * Converts this date to a new time zone, given a valid time zone ID
     * WARNING: This may not work correctly if your system does not allow
     * putenv() or if localtime() does not work in your environment.  See
     * Date::TimeZone::inDaylightTime() for more information.
     *
     * @access public
     * @param string id a time zone id
     */
    function convertTZbyID($id)
    {
       if (Date_TimeZone::isValidID($id)) {
          $tz = new Date_TimeZone($id);
       } else {
          $tz = Date_TimeZone::getDefault();
       }
       $this->convertTZ($tz);
    }

    function toUTCbyOffset($offset)
    {
        if ($offset == "Z" || $offset == "+00:00" || $offset == "+0000") {
            $this->toUTC();
            return true;
        }

        if (preg_match('/([\+\-])(\d{2}):?(\d{2})/', $offset, $regs)) {
            // convert offset to seconds
            $hours  = (int) isset($regs[2])?$regs[2]:0;
            $mins   = (int) isset($regs[3])?$regs[3]:0;
            $offset = ($hours * 3600) + ($mins * 60);

            if (isset($regs[1]) && $regs[1] == "-") {
                $offset *= -1;
            }

            if ($offset > 0) {
                $this->subtractSeconds(intval($offset));
            } else {
                $this->addSeconds(intval(abs($offset)));
            }

            $this->tz = new Date_TimeZone('UTC');
            return true;
        }

        return false;
    }

    /**
     * Adds a given number of seconds to the date
     *
     * Adds a given number of seconds to the date
     *
     * @access public
     * @param int $sec the number of seconds to add
     */
    function addSeconds($sec)
    {
        $this->addSpan(new Date_Span((integer)$sec));
    }

    /**
     * Adds a time span to the date
     *
     * Adds a time span to the date
     *
     * @access public
     * @param object Date_Span $span the time span to add
     */
    function addSpan($span)
    {
        if (!is_a($span, 'Date_Span')) {
            return;
        }

        $this->second += $span->second;
        if ($this->second >= 60) {
            $this->minute++;
            $this->second -= 60;
        }

        $this->minute += $span->minute;
        if ($this->minute >= 60) {
            $this->hour++;
            if ($this->hour >= 24) {
                list($this->year, $this->month, $this->day) =
                    sscanf(Date_Calc::nextDay($this->day, $this->month, $this->year), "%04s%02s%02s");
                $this->hour -= 24;
            }
            $this->minute -= 60;
        }

        $this->hour += $span->hour;
        if ($this->hour >= 24) {
            list($this->year, $this->month, $this->day) =
                sscanf(Date_Calc::nextDay($this->day, $this->month, $this->year), "%04s%02s%02s");
            $this->hour -= 24;
        }

        $d = Date_Calc::dateToDays($this->day, $this->month, $this->year);
        $d += $span->day;

        list($this->year, $this->month, $this->day) =
            sscanf(Date_Calc::daysToDate($d), "%04s%02s%02s");
        $this->year  = intval($this->year);
        $this->month = intval($this->month);
        $this->day   = intval($this->day);
    }

    /**
     * Subtracts a given number of seconds from the date
     *
     * Subtracts a given number of seconds from the date
     *
     * @access public
     * @param int $sec the number of seconds to subtract
     */
    function subtractSeconds($sec)
    {
        $this->subtractSpan(new Date_Span($sec));
    }

    /**
     * Subtracts a time span to the date
     *
     * Subtracts a time span to the date
     *
     * @access public
     * @param object Date_Span $span the time span to subtract
     */
    function subtractSpan($span)
    {
        if (!is_a($span, 'Date_Span')) {
            return;
        }
        if ($span->isEmpty()) {
            return;
        }

        $this->second -= $span->second;
        if ($this->second < 0) {
            $this->minute--;
            $this->second += 60;
        }

        $this->minute -= $span->minute;
        if ($this->minute < 0) {
            $this->hour--;
            if ($this->hour < 0) {
                list($this->year, $this->month, $this->day) =
                    sscanf(Date_Calc::prevDay($this->day, $this->month, $this->year), "%04s%02s%02s");
                $this->hour += 24;
            }
            $this->minute += 60;
        }

        $this->hour -= $span->hour;
        if ($this->hour < 0) {
            list($this->year, $this->month, $this->day) =
                sscanf(Date_Calc::prevDay($this->day, $this->month, $this->year), "%04s%02s%02s");
            $this->hour += 24;
        }

        $d = Date_Calc::dateToDays($this->day, $this->month, $this->year);
        $d -= $span->day;

        list($this->year, $this->month, $this->day) =
            sscanf(Date_Calc::daysToDate($d), "%04s%02s%02s");
        $this->year  = intval($this->year);
        $this->month = intval($this->month);
        $this->day   = intval($this->day);
    }

    /**
     * Compares two dates
     *
     * Compares two dates.  Suitable for use
     * in sorting functions.
     *
     * @access public
     * @param object Date $xd1 the first date
     * @param object Date $xd2 the second date
     * @return int 0 if the dates are equal, -1 if d1 is before d2, 1 if d1 is after d2
     */
    function compare($xd1, $xd2)
    {
        $d1 = new Date();
        $d1->copy($xd1);
        $d2 = new Date();
        $d2->copy($xd2);
        $d1->convertTZ(new Date_TimeZone('UTC'));
        $d2->convertTZ(new Date_TimeZone('UTC'));
        $days1 = Date_Calc::dateToDays($d1->day, $d1->month, $d1->year);
        $days2 = Date_Calc::dateToDays($d2->day, $d2->month, $d2->year);
        if ($days1 < $days2) return -1;
        if ($days1 > $days2) return 1;
        if ($d1->hour < $d2->hour) return -1;
        if ($d1->hour > $d2->hour) return 1;
        if ($d1->minute < $d2->minute) return -1;
        if ($d1->minute > $d2->minute) return 1;
        if ($d1->second < $d2->second) return -1;
        if ($d1->second > $d2->second) return 1;
        return 0;
    }

    /**
     * Test if this date/time is before a certain date/time
     *
     * Test if this date/time is before a certain date/time
     *
     * @access public
     * @param object Date $when the date to test against
     * @return boolean true if this date is before $when
     */
    function before($when)
    {
        if (Date::compare($this,$when) == -1) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Test if this date/time is after a certian date/time
     *
     * Test if this date/time is after a certian date/time
     *
     * @access public
     * @param object Date $when the date to test against
     * @return boolean true if this date is after $when
     */
    function after($when)
    {
        if (Date::compare($this,$when) == 1) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Test if this date/time is exactly equal to a certian date/time
     *
     * Test if this date/time is exactly equal to a certian date/time
     *
     * @access public
     * @param object Date $when the date to test against
     * @return boolean true if this date is exactly equal to $when
     */
    function equals($when)
    {
        if (Date::compare($this,$when) == 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Determine if this date is in the future
     *
     * Determine if this date is in the future
     *
     * @access public
     * @return boolean true if this date is in the future
     */
    function isFuture()
    {
        $now = new Date();
        if ($this->after($now)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Determine if this date is in the past
     *
     * Determine if this date is in the past
     *
     * @access public
     * @return boolean true if this date is in the past
     */
    function isPast()
    {
        $now = new Date();
        if ($this->before($now)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Determine if the year in this date is a leap year
     *
     * Determine if the year in this date is a leap year
     *
     * @access public
     * @return boolean true if this year is a leap year
     */
    function isLeapYear()
    {
        return Date_Calc::isLeapYear($this->year);
    }

    /**
     * Get the Julian date for this date
     *
     * Get the Julian date for this date
     *
     * @access public
     * @return int the Julian date
     */
    function getJulianDate()
    {
        return Date_Calc::julianDate($this->day, $this->month, $this->year);
    }

    /**
     * Gets the day of the week for this date
     *
     * Gets the day of the week for this date (0=Sunday)
     *
     * @access public
     * @return int the day of the week (0=Sunday)
     */
    function getDayOfWeek()
    {
        return Date_Calc::dayOfWeek($this->day, $this->month, $this->year);
    }

    /**
     * Gets the week of the year for this date
     *
     * Gets the week of the year for this date
     *
     * @access public
     * @return int the week of the year
     */
    function getWeekOfYear()
    {
        return Date_Calc::weekOfYear($this->day, $this->month, $this->year);
    }

    /**
     * Gets the quarter of the year for this date
     *
     * Gets the quarter of the year for this date
     *
     * @access public
     * @return int the quarter of the year (1-4)
     */
    function getQuarterOfYear()
    {
        return Date_Calc::quarterOfYear($this->day, $this->month, $this->year);
    }

    /**
     * Gets number of days in the month for this date
     *
     * Gets number of days in the month for this date
     *
     * @access public
     * @return int number of days in this month
     */
    function getDaysInMonth()
    {
        return Date_Calc::daysInMonth($this->month, $this->year);
    }

    /**
     * Gets the number of weeks in the month for this date
     *
     * Gets the number of weeks in the month for this date
     *
     * @access public
     * @return int number of weeks in this month
     */
    function getWeeksInMonth()
    {
        return Date_Calc::weeksInMonth($this->month, $this->year);
    }

    /**
     * Gets the full name or abbriviated name of this weekday
     *
     * Gets the full name or abbriviated name of this weekday
     *
     * @access public
     * @param boolean $abbr abbrivate the name
     * @return string name of this day
     */
    function getDayName($abbr = false, $length = 3)
    {
        if ($abbr) {
            return Date_Calc::getWeekdayAbbrname($this->day, $this->month, $this->year, $length);
        } else {
            return Date_Calc::getWeekdayFullname($this->day, $this->month, $this->year);
        }
    }

    /**
     * Gets the full name or abbriviated name of this month
     *
     * Gets the full name or abbriviated name of this month
     *
     * @access public
     * @param boolean $abbr abbrivate the name
     * @return string name of this month
     */
    function getMonthName($abbr = false)
    {
        if ($abbr) {
            return Date_Calc::getMonthAbbrname($this->month);
        } else {
            return Date_Calc::getMonthFullname($this->month);
        }
    }

    /**
     * Get a Date object for the day after this one
     *
     * Get a Date object for the day after this one.
     * The time of the returned Date object is the same as this time.
     *
     * @access public
     * @return object Date Date representing the next day
     */
    function getNextDay()
    {
        $day = Date_Calc::nextDay($this->day, $this->month, $this->year, "%Y-%m-%d");
        $date = sprintf("%s %02d:%02d:%02d", $day, $this->hour, $this->minute, $this->second);
        $newDate = new Date();
        $newDate->setDate($date);
        return $newDate;
    }

    /**
     * Get a Date object for the day before this one
     *
     * Get a Date object for the day before this one.
     * The time of the returned Date object is the same as this time.
     *
     * @access public
     * @return object Date Date representing the previous day
     */
    function getPrevDay()
    {
        $day = Date_Calc::prevDay($this->day, $this->month, $this->year, "%Y-%m-%d");
        $date = sprintf("%s %02d:%02d:%02d", $day, $this->hour, $this->minute, $this->second);
        $newDate = new Date();
        $newDate->setDate($date);
        return $newDate;
    }

    /**
     * Get a Date object for the weekday after this one
     *
     * Get a Date object for the weekday after this one.
     * The time of the returned Date object is the same as this time.
     *
     * @access public
     * @return object Date Date representing the next weekday
     */
    function getNextWeekday()
    {
        $day = Date_Calc::nextWeekday($this->day, $this->month, $this->year, "%Y-%m-%d");
        $date = sprintf("%s %02d:%02d:%02d", $day, $this->hour, $this->minute, $this->second);
        $newDate = new Date();
        $newDate->setDate($date);
        return $newDate;
    }

    /**
     * Get a Date object for the weekday before this one
     *
     * Get a Date object for the weekday before this one.
     * The time of the returned Date object is the same as this time.
     *
     * @access public
     * @return object Date Date representing the previous weekday
     */
    function getPrevWeekday()
    {
        $day = Date_Calc::prevWeekday($this->day, $this->month, $this->year, "%Y-%m-%d");
        $date = sprintf("%s %02d:%02d:%02d", $day, $this->hour, $this->minute, $this->second);
        $newDate = new Date();
        $newDate->setDate($date);
        return $newDate;
    }


    /**
     * Returns the year field of the date object
     *
     * Returns the year field of the date object
     *
     * @access public
     * @return int the year
     */
    function getYear()
    {
        return $this->year;
    }

    /**
     * Returns the month field of the date object
     *
     * Returns the month field of the date object
     *
     * @access public
     * @return int the month
     */
    function getMonth()
    {
        return $this->month;
    }

    /**
     * Returns the day field of the date object
     *
     * Returns the day field of the date object
     *
     * @access public
     * @return int the day
     */
    function getDay()
    {
        return (int)$this->day;
    }

    /**
     * Returns the hour field of the date object
     *
     * Returns the hour field of the date object
     *
     * @access public
     * @return int the hour
     */
    function getHour()
    {
        return $this->hour;
    }

    /**
     * Returns the minute field of the date object
     *
     * Returns the minute field of the date object
     *
     * @access public
     * @return int the minute
     */
    function getMinute()
    {
        return $this->minute;
    }

    /**
     * Returns the second field of the date object
     *
     * Returns the second field of the date object
     *
     * @access public
     * @return int the second
     */
    function getSecond()
    {
         return $this->second;
    }

    /**
     * Set the year field of the date object
     *
     * Set the year field of the date object, invalid years (not 0-9999) are set to 0.
     *
     * @access public
     * @param int $y the year
     */
    function setYear($y)
    {
        if ($y < 0 || $y > 9999) {
            $this->year = 0;
        } else {
            $this->year = $y;
        }
    }

    /**
     * Set the month field of the date object
     *
     * Set the month field of the date object, invalid months (not 1-12) are set to 1.
     *
     * @access public
     * @param int $m the month
     */
    function setMonth($m)
    {
        if ($m < 1 || $m > 12) {
            $this->month = 1;
        } else {
            $this->month = $m;
        }
    }

    /**
     * Set the day field of the date object
     *
     * Set the day field of the date object, invalid days (not 1-31) are set to 1.
     *
     * @access public
     * @param int $d the day
     */
    function setDay($d)
    {
        if ($d > 31 || $d < 1) {
            $this->day = 1;
        } else {
            $this->day = $d;
        }
    }

    /**
     * Set the hour field of the date object
     *
     * Set the hour field of the date object in 24-hour format.
     * Invalid hours (not 0-23) are set to 0.
     *
     * @access public
     * @param int $h the hour
     */
    function setHour($h)
    {
        if ($h > 23 || $h < 0) {
            $this->hour = 0;
        } else {
            $this->hour = $h;
        }
    }

    /**
     * Set the minute field of the date object
     *
     * Set the minute field of the date object, invalid minutes (not 0-59) are set to 0.
     *
     * @access public
     * @param int $m the minute
     */
    function setMinute($m)
    {
        if ($m > 59 || $m < 0) {
            $this->minute = 0;
        } else {
            $this->minute = $m;
        }
    }

    /**
     * Set the second field of the date object
     *
     * Set the second field of the date object, invalid seconds (not 0-59) are set to 0.
     *
     * @access public
     * @param int $s the second
     */
    function setSecond($s) {
        if ($s > 59 || $s < 0) {
            $this->second = 0;
        } else {
            $this->second = $s;
        }
    }

} // Date


//
// END
?>
