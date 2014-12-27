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
 * @param string $limitation The limitation
 * @param string $op The operator (either '==' or '!=')
 * @param array $aParams An array of additional parameters to be checked
 * @return boolean Whether this impression passes this limitation's test.
 */
function MAX_checkDummy_Dummy($limitation, $op, $aParams = array())
{
    return true;
}

?>
