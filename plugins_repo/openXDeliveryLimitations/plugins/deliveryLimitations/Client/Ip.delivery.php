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
function MAX_checkClient_Ip($limitation, $op, $aParams = [])
{
    if ($limitation == '') {
        return true;
    }
    if (empty($aParams)) {
        $aParams = $_SERVER;
    }
    $ip = $aParams['REMOTE_ADDR'];

    if ($limitation == '') {
        return (true);
    }

    if (!strpos($limitation, '/')) {
        $net = explode('.', $limitation);

        for ($i = 0;$i < sizeof($net);$i++) {
            if ($net[$i] == '*') {
                $net[$i] = 0;
                $mask[$i] = 0;
            } else {
                $mask[$i] = 255;
            }
        }
        $pnet = pack('C4', $net[0], $net[1], $net[2], $net[3]);
        $pmask = pack('C4', $mask[0], $mask[1], $mask[2], $mask[3]);
    } else {
        list($net, $mask) = explode('/', $limitation);
        $net = explode('.', $net);
        $pnet = pack('C4', $net[0], $net[1], $net[2], $net[3]);
        $mask = explode('.', $mask);
        $pmask = pack('C4', $mask[0], $mask[1], $mask[2], $mask[3]);
    }

    $ip = explode('.', $ip);
    $phost = pack('C4', $ip[0], $ip[1], $ip[2], $ip[3]);

    $expression = ($limitation == "*" || ($phost & $pmask) == $pnet);
    $op = $op == '==';
    return ($expression == $op);
}
