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
    if ($limitation == '') {
        return true;
    }
    OA_setTimeZoneLocal();
    if (!empty($GLOBALS['is_simulation'])) {
        $oServiceLocator =& OA_ServiceLocator::instance();
        $oNow = $oServiceLocator->get('now');
        $time = (int)$oNow->getHour();
    } else {
        $time = empty($aParams) ? date('G') : $aParams['hour'];
    }
    OA_setTimeZoneUTC();
    return MAX_limitationsMatchArrayValue($time, $limitation, $op, $aParams);
}

?>
