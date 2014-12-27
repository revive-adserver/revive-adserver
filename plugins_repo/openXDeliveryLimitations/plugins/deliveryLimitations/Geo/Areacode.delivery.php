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
 * @package    OpenXPlugin
 * @subpackage DeliveryLimitations
 */

/**
 * Check to see if this impression contains the valid area code.
 *
 * @param string $limitation The area code limitation
 * @param string $op The operator (either '==' or '!=')
 * @param array $aParams An array of additional parameters to be checked
 * @return boolean Whether this impression's area code passes this limitation's test.
 */
function MAX_checkGeo_Areacode($limitation, $op, $aParams = array())
{
    return MAX_limitationsMatchStringClientGeo(
        'area_code', $limitation, $op, $aParams);
}

?>
