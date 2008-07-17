<?php
// vim: set expandtab tabstop=4 softtabstop=4 shiftwidth=4:
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
// | Author: Leandro Lucarella <llucax@php.net>                           |
// +----------------------------------------------------------------------+
//
// $Id$
//

require_once 'Date.php';
require_once 'Date/Calc.php';

/**
 * Non Numeric Separated Values (NNSV) Input Format.
 *
 * Input format guessed from something like this:
 * days<sep>hours<sep>minutes<sep>seconds
 * Where <sep> is any quantity of non numeric chars. If no values are
 * given, time span is set to zero, if one value is given, it's used for
 * hours, if two values are given it's used for hours and minutes and if
 * three values are given, it's used for hours, minutes and seconds.<br>
 * Examples:<br>
 * ''                   -> 0, 0, 0, 0 (days, hours, minutes, seconds)<br>
 * '12'                 -> 0, 12, 0, 0
 * '12.30'              -> 0, 12, 30, 0<br>
 * '12:30:18'           -> 0, 12, 30, 18<br>
 * '3-12-30-18'         -> 3, 12, 30, 18<br>
 * '3 days, 12-30-18'   -> 3, 12, 30, 18<br>
 * '12:30 with 18 secs' -> 0, 12, 30, 18<br>
 *
 * @const int
 */
define('DATE_SPAN_INPUT_FORMAT_NNSV', 1);

/**
 * Default time format when converting to a string.
 *
 * @global string
 */
$_DATE_SPAN_FORMAT  = '%C';

/**
 * Default time format when converting from a string.
 *
 * @global mixed
 */
$_DATE_SPAN_INPUT_FORMAT = DATE_SPAN_INPUT_FORMAT_NNSV;

/**
 * Generic time span handling class for PEAR.
 *
 * @package Date
 * @author  Leandro Lucarella <llucax@php.net>
 * @version $Revision: 1.4 $
 * @since   1.4
 * @todo    Get and set default local input and output formats?
 * @access  public
 */
class Date_Span {

    /**
     * @var int
     */
    var $day;

    /**
     * @var int
     */
    var $hour;

    /**
     * @var int
     */
    var $minute;

    /**
     * @var int
     */
    var $second;

    /**
     * Constructor.
     *
     * Creates the time span object calling the set() method.
     *
     * @param  mixed $time   Time span expression.
     * @param  mixed $format Format string to set it from a string or the
     *                       second date set it from a date diff.
     *
     * @see    set()
     * @access public
     */
    function Date_Span($time = 0, $format = null)
    {
        $this->set($time, $format);
    }

    /**
     * Set the time span to a new value in a 'smart' way.
     *
     * Sets the time span depending on the argument types, calling
     * to the appropriate setFromXxx() method.
     *
     * @param  mixed $time   Time span expression.
     * @param  mixed $format Format string to set it from a string or the
     *                       second date set it from a date diff.
     *
     * @return bool  true on success.
     *
     * @see    setFromObject()
     * @see    setFromArray()
     * @see    setFromString()
     * @see    setFromSeconds()
     * @see    setFromDateDiff()
     * @access public
     */
    function set($time = 0, $format = null)
    {
        if (is_a($time, 'date_span')) {
            return $this->copy($time);
        } elseif (is_a($time, 'date') and is_a($format, 'date')) {
            return $this->setFromDateDiff($time, $format);
        } elseif (is_array($time)) {
            return $this->setFromArray($time);
        } elseif (is_string($time)) {
            return $this->setFromString($time, $format);
        } elseif (is_int($time)) {
            return $this->setFromSeconds($time);
        } else {
            return $this->setFromSeconds(0);
        }
    }

    /**
     * Set the time span from an array.
     *
     * Set the time span from an array. Any value can be a float (but it
     * has no sense in seconds), for example array(23.5, 20, 0) is
     * interpreted as 23 hours, .5*60 + 20 = 50 minutes and 0 seconds.
     *
     * @param  array $time Items are counted from right to left. First
     *                     item is for seconds, second for minutes, third
     *                     for hours and fourth for days. If there are
     *                     less items than 4, zero (0) is assumed for the
     *                     absent values.
     *
     * @return bool  True on success.
     *
     * @access public
     */
    function setFromArray($time)
    {
        if (!is_array($time)) {
            return false;
        }
        $tmp1 = new Date_Span;
        if (!$tmp1->setFromSeconds(@array_pop($time))) {
            return false;
        }
        $tmp2 = new Date_Span;
        if (!$tmp2->setFromMinutes(@array_pop($time))) {
            return false;
        }
        $tmp1->add($tmp2);
        if (!$tmp2->setFromHours(@array_pop($time))) {
            return false;
        }
        $tmp1->add($tmp2);
        if (!$tmp2->setFromDays(@array_pop($time))) {
            return false;
        }
        $tmp1->add($tmp2);
        return $this->copy($tmp1);
    }

    /**
     * Set the time span from a string based on an input format.
     *
     * Set the time span from a string based on an input format. This is
     * some like a mix of format() method and sscanf() PHP function. The
     * error checking and validation of this function is very primitive,
     * so you should be carefull when using it with unknown $time strings.
     * With this method you are assigning day, hour, minute and second
     * values, and the last values are used. This means that if you use
     * something like setFromString('10, 20', '%H, %h') your time span
     * would be 20 hours long. Allways remember that this method set
     * <b>all</b> the values, so if you had a $time span 30 minutes long
     * and you make $time->setFromString('20 hours', '%H hours'), $time
     * span would be 20 hours long (and not 20 hours and 30 minutes).
     * Input format options:<br>
     *  <code>%C</code> Days with time, same as "%D, %H:%M:%S".<br>
     *  <code>%d</code> Total days as a float number
     *                  (2 days, 12 hours = 2.5 days).<br>
     *  <code>%D</code> Days as a decimal number.<br>
     *  <code>%e</code> Total hours as a float number
     *                  (1 day, 2 hours, 30 minutes = 26.5 hours).<br>
     *  <code>%f</code> Total minutes as a float number
     *                  (2 minutes, 30 seconds = 2.5 minutes).<br>
     *  <code>%g</code> Total seconds as a decimal number
     *                  (2 minutes, 30 seconds = 90 seconds).<br>
     *  <code>%h</code> Hours as decimal number.<br>
     *  <code>%H</code> Hours as decimal number limited to 2 digits.<br>
     *  <code>%m</code> Minutes as a decimal number.<br>
     *  <code>%M</code> Minutes as a decimal number limited to 2 digits.<br>
     *  <code>%n</code> Newline character (\n).<br>
     *  <code>%p</code> Either 'am' or 'pm' depending on the time. If 'pm'
     *                  is detected it adds 12 hours to the resulting time
     *                  span (without any checks). This is case
     *                  insensitive.<br>
     *  <code>%r</code> Time in am/pm notation, same as "%H:%M:%S %p".<br>
     *  <code>%R</code> Time in 24-hour notation, same as "%H:%M".<br>
     *  <code>%s</code> Seconds as a decimal number.<br>
     *  <code>%S</code> Seconds as a decimal number limited to 2 digits.<br>
     *  <code>%t</code> Tab character (\t).<br>
     *  <code>%T</code> Current time equivalent, same as "%H:%M:%S".<br>
     *  <code>%%</code> Literal '%'.<br>
     *
     * @param  string $time   String from where to get the time span
     *                        information.
     * @param  string $format Format string.
     *
     * @return bool   True on success.
     *
     * @access public
     */
    function setFromString($time, $format = null)
    {
        if (is_null($format)) {
            $format = $GLOBALS['_DATE_SPAN_INPUT_FORMAT'];
        }
        // If format is a string, it parses the string format.
        if (is_string($format)) {
            $str = '';
            $vars = array();
            $pm = 'am';
            $day = $hour = $minute = $second = 0;
            for ($i = 0; $i < strlen($format); $i++) {
                $char = $format{$i};
                if ($char == '%') {
                    $nextchar = $format{++$i};
                    switch ($nextchar) {
                        case 'c':
                            $str .= '%d, %d:%d:%d';
                            array_push(
                                $vars, 'day', 'hour', 'minute', 'second');
                            break;
                        case 'C':
                            $str .= '%d, %2d:%2d:%2d';
                            array_push(
                                $vars, 'day', 'hour', 'minute', 'second');
                            break;
                        case 'd':
                            $str .= '%f';
                            array_push($vars, 'day');
                            break;
                        case 'D':
                            $str .= '%d';
                            array_push($vars, 'day');
                            break;
                        case 'e':
                            $str .= '%f';
                            array_push($vars, 'hour');
                            break;
                        case 'f':
                            $str .= '%f';
                            array_push($vars, 'minute');
                            break;
                        case 'g':
                            $str .= '%f';
                            array_push($vars, 'second');
                            break;
                        case 'h':
                            $str .= '%d';
                            array_push($vars, 'hour');
                            break;
                        case 'H':
                            $str .= '%2d';
                            array_push($vars, 'hour');
                            break;
                        case 'm':
                            $str .= '%d';
                            array_push($vars, 'minute');
                            break;
                        case 'M':
                            $str .= '%2d';
                            array_push($vars, 'minute');
                            break;
                        case 'n':
                            $str .= "\n";
                            break;
                        case 'p':
                            $str .= '%2s';
                            array_push($vars, 'pm');
                            break;
                        case 'r':
                            $str .= '%2d:%2d:%2d %2s';
                            array_push(
                                $vars, 'hour', 'minute', 'second', 'pm');
                            break;
                        case 'R':
                            $str .= '%2d:%2d';
                            array_push($vars, 'hour', 'minute');
                            break;
                        case 's':
                            $str .= '%d';
                            array_push($vars, 'second');
                            break;
                        case 'S':
                            $str .= '%2d';
                            array_push($vars, 'second');
                            break;
                        case 't':
                            $str .= "\t";
                            break;
                        case 'T':
                            $str .= '%2d:%2d:%2d';
                            array_push($vars, 'hour', 'minute', 'second');
                            break;
                        case '%':
                            $str .= "%";
                            break;
                        default:
                            $str .= $char . $nextchar;
                    }
                } else {
                    $str .= $char;
                }
            }
            $vals = sscanf($time, $str);
            foreach ($vals as $i => $val) {
                if (is_null($val)) {
                    return false;
                }
                $$vars[$i] = $val;
            }
            if (strcasecmp($pm, 'pm') == 0) {
                $hour += 12;
            } elseif (strcasecmp($pm, 'am') != 0) {
                return false;
            }
            $this->setFromArray(array($day, $hour, $minute, $second));
        // If format is a integer, it uses a predefined format
        // detection method.
        } elseif (is_integer($format)) {
            switch ($format) {
                case DATE_SPAN_INPUT_FORMAT_NNSV:
                    $time = preg_split('/\D+/', $time);
                    switch (count($time)) {
                        case 0:
                            return $this->setFromArray(
                                array(0, 0, 0, 0));
                        case 1:
                            return $this->setFromArray(
                                array(0, $time[0], 0, 0));
                        case 2:
                            return $this->setFromArray(
                                array(0, $time[0], $time[1], 0));
                        case 3:
                            return $this->setFromArray(
                                array(0, $time[0], $time[1], $time[2]));
                        default:
                            return $this->setFromArray($time);
                    }
                    break;
            }
        }
        return false;
    }

    /**
     * Set the time span from a total number of seconds.
     *
     * @param  int  $seconds Total number of seconds.
     *
     * @return bool True on success.
     *
     * @access public
     */
    function setFromSeconds($seconds)
    {
        if ($seconds < 0) {
            return false;
        }
        $sec  = intval($seconds);
        $min  = floor($sec / 60);
        $hour = floor($min / 60);
        $day  = intval(floor($hour / 24));
        $this->second = $sec % 60;
        $this->minute = $min % 60;
        $this->hour   = $hour % 24;
        $this->day    = $day;
        return true;
    }

    /**
     * Set the time span from a total number of minutes.
     *
     * @param  float $minutes Total number of minutes.
     *
     * @return bool  True on success.
     *
     * @access public
     */
    function setFromMinutes($minutes)
    {
        return $this->setFromSeconds(round($minutes * 60));
    }

    /**
     * Set the time span from a total number of hours.
     *
     * @param  float $hours Total number of hours.
     *
     * @return bool  True on success.
     *
     * @access public
     */
    function setFromHours($hours)
    {
        return $this->setFromSeconds(round($hours * 3600));
    }

    /**
     * Set the time span from a total number of days.
     *
     * @param  float $days Total number of days.
     *
     * @return bool  True on success.
     *
     * @access public
     */
    function setFromDays($days)
    {
        return $this->setFromSeconds(round($days * 86400));
    }

    /**
     * Set the span from the elapsed time between two dates.
     *
     * Set the span from the elapsed time between two dates. The time span
     * is allways positive, so the date's order is not important.
     *
     * @param  object Date $date1 First Date.
     * @param  object Date $date2 Second Date.
     *
     * @return bool  True on success.
     *
     * @access public
     */
    function setFromDateDiff($date1, $date2)
    {
        if (!is_a($date1, 'date') or !is_a($date2, 'date')) {
            return false;
        }
        $date1->toUTC();
        $date2->toUTC();
        if ($date1->after($date2)) {
            list($date1, $date2) = array($date2, $date1);
        }
        $days = Date_Calc::dateDiff(
            $date1->getDay(), $date1->getMonth(), $date1->getYear(),
            $date2->getDay(), $date2->getMonth(), $date2->getYear()
        );
        $hours = $date2->getHour() - $date1->getHour();
        $mins  = $date2->getMinute() - $date1->getMinute();
        $secs  = $date2->getSecond() - $date1->getSecond();
        $this->setFromSeconds(
            $days * 86400 + $hours * 3600 + $mins * 60 + $secs
        );
        return true;
    }

    /**
     * Set the time span from another time object.
     *
     * @param  object Date_Span $time Source time span object.
     *
     * @return bool   True on success.
     *
     * @access public
     */
    function copy($time)
    {
        if (is_a($time, 'date_span')) {
            $this->second = $time->second;
            $this->minute = $time->minute;
            $this->hour   = $time->hour;
            $this->day    = $time->day;
            return true;
        } else {
            return false;
        }
    }

    /**
     * Time span pretty printing (similar to Date::format()).
     *
     * Formats the time span in the given format, similar to
     * strftime() and Date::format().<br>
     * <br>
     * Formatting options:<br>
     *  <code>%C</code> Days with time, same as "%D, %H:%M:%S".<br>
     *  <code>%d</code> Total days as a float number
     *                  (2 days, 12 hours = 2.5 days).<br>
     *  <code>%D</code> Days as a decimal number.<br>
     *  <code>%e</code> Total hours as a float number
     *                  (1 day, 2 hours, 30 minutes = 26.5 hours).<br>
     *  <code>%E</code> Total hours as a decimal number
     *                  (1 day, 2 hours, 40 minutes = 26 hours).<br>
     *  <code>%f</code> Total minutes as a float number
     *                  (2 minutes, 30 seconds = 2.5 minutes).<br>
     *  <code>%F</code> Total minutes as a decimal number
     *                  (1 hour, 2 minutes, 40 seconds = 62 minutes).<br>
     *  <code>%g</code> Total seconds as a decimal number
     *                  (2 minutes, 30 seconds = 90 seconds).<br>
     *  <code>%h</code> Hours as decimal number (0 to 23).<br>
     *  <code>%H</code> Hours as decimal number (00 to 23).<br>
     *  <code>%i</code> Hours as decimal number on 12-hour clock
     *                  (1 to 12).<br>
     *  <code>%I</code> Hours as decimal number on 12-hour clock
     *                  (01 to 12).<br>
     *  <code>%m</code> Minutes as a decimal number (0 to 59).<br>
     *  <code>%M</code> Minutes as a decimal number (00 to 59).<br>
     *  <code>%n</code> Newline character (\n).<br>
     *  <code>%p</code> Either 'am' or 'pm' depending on the time.<br>
     *  <code>%P</code> Either 'AM' or 'PM' depending on the time.<br>
     *  <code>%r</code> Time in am/pm notation, same as "%I:%M:%S %p".<br>
     *  <code>%R</code> Time in 24-hour notation, same as "%H:%M".<br>
     *  <code>%s</code> Seconds as a decimal number (0 to 59).<br>
     *  <code>%S</code> Seconds as a decimal number (00 to 59).<br>
     *  <code>%t</code> Tab character (\t).<br>
     *  <code>%T</code> Current time equivalent, same as "%H:%M:%S".<br>
     *  <code>%%</code> Literal '%'.<br>
     *
     * @param  string $format The format string for returned time span.
     *
     * @return string The time span in specified format.
     *
     * @access public
     */
    function format($format = null)
    {
        if (is_null($format)) {
            $format = $GLOBALS['_DATE_SPAN_FORMAT'];
        }
        $output = '';
        for ($i = 0; $i < strlen($format); $i++) {
            $char = $format{$i};
            if ($char == '%') {
                $nextchar = $format{++$i};
                switch ($nextchar) {
                    case 'C':
                        $output .= sprintf(
                            '%d, %02d:%02d:%02d',
                            $this->day,
                            $this->hour,
                            $this->minute,
                            $this->second
                        );
                        break;
                    case 'd':
                        $output .= $this->toDays();
                        break;
                    case 'D':
                        $output .= $this->day;
                        break;
                    case 'e':
                        $output .= $this->toHours();
                        break;
                    case 'E':
                        $output .= floor($this->toHours());
                        break;
                    case 'f':
                        $output .= $this->toMinutes();
                        break;
                    case 'F':
                        $output .= floor($this->toMinutes());
                        break;
                    case 'g':
                        $output .= $this->toSeconds();
                        break;
                    case 'h':
                        $output .= $this->hour;
                        break;
                    case 'H':
                        $output .= sprintf('%02d', $this->hour);
                        break;
                    case 'i':
                        $hour =
                            ($this->hour + 1) > 12 ?
                            $this->hour - 12 :
                            $this->hour;
                        $output .= ($hour == 0) ? 12 : $hour;
                        break;
                    case 'I':
                        $hour =
                            ($this->hour + 1) > 12 ?
                            $this->hour - 12 :
                            $this->hour;
                        $output .= sprintf('%02d', $hour==0 ? 12 : $hour);
                        break;
                    case 'm':
                        $output .= $this->minute;
                        break;
                    case 'M':
                        $output .= sprintf('%02d',$this->minute);
                        break;
                    case 'n':
                        $output .= "\n";
                        break;
                    case 'p':
                        $output .= $this->hour >= 12 ? 'pm' : 'am';
                        break;
                    case 'P':
                        $output .= $this->hour >= 12 ? 'PM' : 'AM';
                        break;
                    case 'r':
                        $hour =
                            ($this->hour + 1) > 12 ?
                            $this->hour - 12 :
                            $this->hour;
                        $output .= sprintf(
                            '%02d:%02d:%02d %s',
                            $hour==0 ?  12 : $hour,
                            $this->minute,
                            $this->second,
                            $this->hour >= 12 ? 'pm' : 'am'
                        );
                        break;
                    case 'R':
                        $output .= sprintf(
                            '%02d:%02d', $this->hour, $this->minute
                        );
                        break;
                    case 's':
                        $output .= $this->second;
                        break;
                    case 'S':
                        $output .= sprintf('%02d', $this->second);
                        break;
                    case 't':
                        $output .= "\t";
                        break;
                    case 'T':
                        $output .= sprintf(
                            '%02d:%02d:%02d',
                            $this->hour, $this->minute, $this->second
                        );
                        break;
                    case '%':
                        $output .= "%";
                        break;
                    default:
                        $output .= $char . $nextchar;
                }
            } else {
                $output .= $char;
            }
        }
        return $output;
    }

    /**
     * Convert time span to seconds.
     *
     * @return int Time span as an integer number of seconds.
     *
     * @access public
     */
    function toSeconds()
    {
        return $this->day * 86400 + $this->hour * 3600 +
            $this->minute * 60 + $this->second;
    }

    /**
     * Convert time span to minutes.
     *
     * @return float Time span as a decimal number of minutes.
     *
     * @access public
     */
    function toMinutes()
    {
        return $this->day * 1440 + $this->hour * 60 + $this->minute +
            $this->second / 60;
    }

    /**
     * Convert time span to hours.
     *
     * @return float Time span as a decimal number of hours.
     *
     * @access public
     */
    function toHours()
    {
        return $this->day * 24 + $this->hour + $this->minute / 60 +
            $this->second / 3600;
    }

    /**
     * Convert time span to days.
     *
     * @return float Time span as a decimal number of days.
     *
     * @access public
     */
    function toDays()
    {
        return $this->day + $this->hour / 24 + $this->minute / 1440 +
            $this->second / 86400;
    }

    /**
     * Adds a time span.
     *
     * @param  object Date_Span $time Time span to add.
     *
     * @access public
     */
    function add($time)
    {
        return $this->setFromSeconds(
            $this->toSeconds() + $time->toSeconds()
        );
    }

    /**
     * Subtracts a time span.
     *
     * Subtracts a time span. If the time span to subtract is larger
     * than the original, the result is zero (there's no sense in
     * negative time spans).
     *
     * @param  object Date_Span $time Time span to subtract.
     *
     * @access public
     */
    function subtract($time)
    {
        $sub = $this->toSeconds() - $time->toSeconds();
        if ($sub < 0) {
            $this->setFromSeconds(0);
        } else {
            $this->setFromSeconds($sub);
        }
    }

    /**
     * Tells if time span is equal to $time.
     *
     * @param  object Date_Span $time Time span to compare to.
     *
     * @return bool   True if the time spans are equal.
     *
     * @access public
     */
    function equal($time)
    {
        return $this->toSeconds() == $time->toSeconds();
    }

    /**
     * Tells if this time span is greater or equal than $time.
     *
     * @param  object Date_Span $time Time span to compare to.
     *
     * @return bool   True if this time span is greater or equal than $time.
     *
     * @access public
     */
    function greaterEqual($time)
    {
        return $this->toSeconds() >= $time->toSeconds();
    }

    /**
     * Tells if this time span is lower or equal than $time.
     *
     * @param  object Date_Span $time Time span to compare to.
     *
     * @return bool   True if this time span is lower or equal than $time.
     *
     * @access public
     */
    function lowerEqual($time)
    {
        return $this->toSeconds() <= $time->toSeconds();
    }

    /**
     * Tells if this time span is greater than $time.
     *
     * @param  object Date_Span $time Time span to compare to.
     *
     * @return bool   True if this time span is greater than $time.
     *
     * @access public
     */
    function greater($time)
    {
        return $this->toSeconds() > $time->toSeconds();
    }

    /**
     * Tells if this time span is lower than $time.
     *
     * @param  object Date_Span $time Time span to compare to.
     *
     * @return bool   True if this time span is lower than $time.
     *
     * @access public
     */
    function lower($time)
    {
        return $this->toSeconds() < $time->toSeconds();
    }

    /**
     * Compares two time spans.
     *
     * Compares two time spans. Suitable for use in sorting functions.
     *
     * @param  object Date_Span $time1 The first time span.
     * @param  object Date_Span $time2 The second time span.
     *
     * @return int    0 if the time spans are equal, -1 if time1 is lower
     *                than time2, 1 if time1 is greater than time2.
     *
     * @static
     * @access public
     */
    function compare($time1, $time2)
    {
        if ($time1->equal($time2)) {
            return 0;
        } elseif ($time1->lower($time2)) {
            return -1;
        } else {
            return 1;
        }
    }

    /**
     * Tells if the time span is empty (zero length).
     *
     * @return bool True is it's empty.
     */
    function isEmpty()
    {
        return !$this->day && !$this->hour && !$this->minute && !$this->second;
    }

    /**
     * Set the default input format.
     *
     * @param  mixed $format New default input format.
     *
     * @return mixed Previous default input format.
     *
     * @static
     */
    function setDefaultInputFormat($format)
    {
        $old = $GLOBALS['_DATE_SPAN_INPUT_FORMAT'];
        $GLOBALS['_DATE_SPAN_INPUT_FORMAT'] = $format;
        return $old;
    }

    /**
     * Get the default input format.
     *
     * @return mixed Default input format.
     *
     * @static
     */
    function getDefaultInputFormat()
    {
        return $GLOBALS['_DATE_SPAN_INPUT_FORMAT'];
    }

    /**
     * Set the default format.
     *
     * @param  mixed $format New default format.
     *
     * @return mixed Previous default format.
     *
     * @static
     */
    function setDefaultFormat($format)
    {
        $old = $GLOBALS['_DATE_SPAN_FORMAT'];
        $GLOBALS['_DATE_SPAN_FORMAT'] = $format;
        return $old;
    }

    /**
     * Get the default format.
     *
     * @return mixed Default format.
     *
     * @static
     */
    function getDefaultFormat()
    {
        return $GLOBALS['_DATE_SPAN_FORMAT'];
    }

    /**
     * Returns a copy of the object (workarround for PHP5 forward compatibility).
     *
     * @return object Date_Span Copy of the object.
     */
    function __clone() {
        $c = get_class($this);
        $s = new $c;
        $s->day    = $this->day;
        $s->hour   = $this->hour;
        $s->minute = $this->minute;
        $s->second = $this->second;
        return $s;
    }
}

?>
