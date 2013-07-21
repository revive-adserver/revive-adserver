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
 * @author     Chris Nutting <chris@m3.net>
 * @author     Andrzej Swedrzynski <andrzej.swedrzynski@m3.net>
 */

require_once MAX_PATH . '/lib/max/Delivery/limitations.delivery.php';

/**
 * Check to see if this impression contains the valid hour.
 *
 * @param string $limitation The hour limitation
 * @param string $op The operator (either '==' or '!=')
 * @param array $aParams An array of additional parameters to be checked
 * @return boolean Whether this impression's hour passes this limitation's test.
 */
function MAX_checkTime_Hour($limitation, $op, $aParams = array())
{
    // Get timezone, if any
    $offset = strpos($limitation, '@');
    if ($offset !== false) {
        $tz = substr($limitation, $offset + 1);
        $limitation = substr($limitation, 0, $offset);
    } else {
        $tz = false;
    }
    if ($limitation == '') {
        return true;
    }
    $timestamp = !empty($aParams['timestamp']) ? $aParams['timestamp'] : time();
    if ($tz && $tz != 'UTC') {
        OA_setTimeZone($tz);
        $time = date('G', $timestamp);
        OA_setTimeZoneUTC();
    } else {
        $time = gmdate('G', $timestamp);
    }
    return MAX_limitationsMatchArrayValue($time, $limitation, $op, $aParams);
}

?>