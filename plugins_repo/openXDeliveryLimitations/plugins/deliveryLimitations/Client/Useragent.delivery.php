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
 * Check to see if this impression contains the valid user agent.
 *
 * @param string $limitation The user agent limitation
 * @param string $op The operator (all string operators apply)
 * @param array $aParams An array of additional parameters to be checked
 * @return boolean Whether this impression's user agent passes this limitation's test.
 */
function MAX_checkClient_Useragent($limitation, $op, $aParams = [])
{
    return MAX_limitationsMatchString('ua', $limitation, $op, $aParams);
}
