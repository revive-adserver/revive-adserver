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
 * Check to see if this impression contains the valid US Metro Code.
 *
 * @param string $limitation The US Metro Code (or comma list of Metro codes) limitation
 * @param string $op The operator (either '==' or '!=')
 * @param array $aParams An array of additional parameters to be checked
 * @return boolean Whether this impression's Metro code passes this limitation's test.
 */
function MAX_checkGeo_UsMetro($limitation, $op, $aParams = [])
{
    return MAX_limitationsMatchArrayClientGeo('metro_code', $limitation, $op, $aParams);
}
