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

require_once MAX_PATH . '/lib/max/Delivery/limitations.delivery.php';

/**
 * Check to see if this impression contains the valid IP Address.
 *
 * @param string $limitation The IP address limitation
 * @param string $op The operator (either '==' or '!=')
 * @param array $aParams An array of additional parameters to be checked
 * @return boolean Whether this impression's IP address passes this limitation's test.
 */
function MAX_checkDemoDeliveryLimitation_DemoLimitation($limitation, $op, $aParams = array())
{
    if ($limitation == '') {
        return true;
    }
    if (empty($aParams)) {
        $aParams = $_SERVER;
    }
    $ip = $aParams['REMOTE_ADDR'];

    if (MAX_ipContainsStar($limitation)) {
        $ip = MAX_ipWithLastComponentReplacedByStar($ip);
    }

    if ($op == '==') {
        return $limitation == $ip;
    } else {
        return $limitation != $ip;
    }
}
?>
