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
 * Check to see if this impression contains the valid browser.
 *
 * @param string $limitation The browser (or comma list of browsers) limitation
 * @param string $op The operator ('==', '!=', '=~', '!~')
 * @param array $aParams An array of additional parameters to be checked
 * @return boolean Whether this impression's browser passes this limitation's test.
 */
function MAX_checkClient_Browser($limitation, $op, $aParams = array())
{
    if (empty($aParams)) {
        $aParams = $GLOBALS['_MAX']['CLIENT'];
    }
    return MAX_limitationsMatchArray('browser', $limitation, $op, $aParams);
}

?>
