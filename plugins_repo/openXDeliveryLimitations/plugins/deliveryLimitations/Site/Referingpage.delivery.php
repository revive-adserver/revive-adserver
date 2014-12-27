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
 * Check to see if this impression contains the valid referrer.
 *
 * @param string $limitation The referrer limitation
 * @param string $op The operator (either '==' or '!=')
 * @param array $aParams An array of additional parameters to be checked
 * @return boolean Whether this impression's referrer passes this limitation's test.
 */
function MAX_checkSite_Referingpage($limitation, $op, $aParams = array())
{
    if ($limitation == '') {
        return true;
    }
    $url = empty($aParams) ? $GLOBALS['referer'] : $aParams['referer'];
    return MAX_limitationsMatchStringValue($url, $limitation, $op);
}

?>
