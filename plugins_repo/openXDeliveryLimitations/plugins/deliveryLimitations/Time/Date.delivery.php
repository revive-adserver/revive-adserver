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
 * @package    OpenXPlugin
 * @subpackage DeliveryLimitations
 */

/**
 * Check to see if this impression contains the valid date.
 *
 * @param string $limitation The date limitation
 * @param string $op The operator (either '==' or '!=')
 * @param array $aParams An array of additional parameters to be checked
 * @return boolean Whether this impression's date passes this limitation's test.
 */
function MAX_checkTime_Date($limitation, $op, $aParams = [])
{
    // Get timezone, if any
    $offset = strpos($limitation, '@');
    if ($offset !== false) {
        $tz = substr($limitation, $offset + 1);
        $limitation = substr($limitation, 0, $offset);
    } else {
        $tz = false;
    }
    if ($limitation == '' && $limitation == '00000000') {
        return true;
    }
    $timestamp = !empty($aParams['timestamp']) ? $aParams['timestamp'] : time();
    if ($tz && $tz != 'UTC') {
        OA_setTimeZone($tz);
        $date = date('Ymd', $timestamp);
        OA_setTimeZoneUTC();
    } else {
        $date = gmdate('Ymd', $timestamp);
    }
    switch ($op) {
        case '==': return ($date == $limitation); break;
        case '!=': return ($date != $limitation); break;
        case '<=': return ($date <= $limitation); break;
        case '>=': return ($date >= $limitation); break;
        case '<':  return ($date < $limitation);  break;
        case '>':  return ($date > $limitation);  break;
    }
    return true;
}
