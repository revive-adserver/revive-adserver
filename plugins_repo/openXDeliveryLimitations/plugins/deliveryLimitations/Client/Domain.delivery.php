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
 * Check to see if this impression contains the valid domain.
 *
 * @param string $limitation The domain limitation.
 * @param string $op The string operator.
 * @param array $aParams An array of additional parameters to be checked.
 * @return boolean Whether this impression's domain passes this limitation's test.
 */
function MAX_checkClient_Domain($limitation, $op, $aParams = [])
{
    if (empty($aParams)) {
        $aParams = $GLOBALS['_MAX']['CLIENT'];
    }
    if ($limitation == '') {
        return true;
    }
    $host = $_SERVER['REMOTE_HOST'];
    if (MAX_limitationsIsOperatorRegexp($op)) {
        $domain = $host;
    } else {
        $domain = substr($host, -(strlen($limitation)));
    }

    return MAX_limitationsMatchStringValue($domain, $limitation, $op);
}
