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

require_once MAX_PATH . '/lib/max/Delivery/limitations.delivery.php';

/**
 * Check if a value passed into the ad request (through $_REQUEST (so GET/POST/COOKIE)
 * via a name=value pair matches the limitation configured
 *
 * @param string $limitation The variable limitation
 * @param string $op The operator
 * @param array $aParams An array of additional parameters to be checked
 * @return boolean Whether this impression's channel passes this limitation's test.
 */
function MAX_checkSite_Variable($limitation, $op, $aParams = array())
{
    if (empty($aParams)) {
        $aParams = $_REQUEST;
    }
    $key   = substr($limitation, 0, strpos($limitation, '|'));
    $value = substr($limitation, strpos($limitation, '|')+1);
    if (!isset($limitation) || !isset($aParams[$key])) {
        // To be safe, unless the paramters passed in, and configured are avaiable,
        // return depending on if the $op is considered a 'positive' test
        return !MAX_limitationsIsOperatorPositive($op);
    } else if (MAX_limitationsIsOperatorNumeric($op)) {
        return MAX_limitationMatchNumeric($key, $value, $op, $aParams);
    } else {
        return MAX_limitationsMatchString($key, $value, $op, $aParams);
    }
}

?>
