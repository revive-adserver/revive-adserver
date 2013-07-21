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
 */

/**
 * Check to see if this impression contains the valid date.
 *
 * @param string $limitation The date limitation
 * @param string $op The operator (either '==' or '!=')
 * @param array $aParams An array of additional parameters to be checked
 * @return boolean Whether this impression's date passes this limitation's test.
 */
function MAX_checkTime_Date($limitation, $op, $aParams = array())
{
    if ($limitation == '' && $limitation == '00000000') {
        return true;
    }
    OA_setTimeZoneLocal();
    $date = empty($aParams) ? date('Ymd') : $aParams['date'];
    OA_setTimeZoneUTC();
    switch ($op) {
        case '==': return ($date == $limitation); break;
        case '!=': return ($date != $limitation); break;
        case '<=': return ($date <= $limitation); break;
        case '>=': return ($date >= $limitation); break;
        case '<':  return ($date <  $limitation);  break;
        case '>':  return ($date >  $limitation);  break;
    }
    return true;
}

?>
