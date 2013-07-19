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
 * @author     Chris Nutting <chris@m3.net>
 * @author     Andrzej Swedrzynski <andrzej.swedrzynski@m3.net>
 */

require_once MAX_PATH . '/lib/max/Delivery/limitations.delivery.php';

/**
 * Check to see if this impression contains the valid page url.
 *
 * @param string $limitation The page url limitation
 * @param string $op The operator (either '==' or '!=')
 * @param array $aParams An array of additional parameters to be checked
 * @return boolean Whether this impression's page url passes this limitation's test.
 */
function MAX_checkSite_Pageurl($limitation, $op, $aParams = array())
{
    if ($limitation == '') {
        return true;
    }
    $url = empty($aParams) ? $GLOBALS['loc'] : $aParams['loc'];
    return MAX_limitationsMatchStringValue($url, $limitation, $op);
}

?>
