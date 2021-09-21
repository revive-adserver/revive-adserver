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
 * Check to see if this impression contains the operating system.
 *
 * @param string $limitation The operating system (or comma list of operating systems) limitation
 * @param string $op The operator (either '==' or '!=')
 * @param array $aParams An array of additional parameters to be checked
 * @return boolean Whether this impression's operating system passes this limitation's test.
 */
function MAX_checkClient_Os($limitation, $op, $aParams = [])
{
    if (empty($aParams)) {
        $aParams = $GLOBALS['_MAX']['CLIENT'];

        if (!isset($aParams['os'])) {
            $aParams['os'] = $aParams['wrapper']->getLegacyOs();
        }
    }

    return MAX_limitationsMatchArray('os', $limitation, $op, $aParams);
}
