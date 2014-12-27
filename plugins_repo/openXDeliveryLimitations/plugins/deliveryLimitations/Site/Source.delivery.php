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
 * Check to see if this impression contains the valid source.
 *
 * @param string $limitation The source limitation
 * @param string $op The operator (either '==' or '!=')
 * @param array $aParams An array of additional parameters to be checked
 * @return boolean Whether this impression's source passes this limitation's test.
 */
function MAX_checkSite_Source($limitation, $op, $aParams = array())
{
    if (empty($aParams['source'])) {
        $aParams['source'] = $GLOBALS['source'];
    }
    return MAX_limitationsMatchString('source', $limitation, $op, $aParams);
}

?>
