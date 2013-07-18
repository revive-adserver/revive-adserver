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
 * Check to see if this impression contains the valid city.
 *
 * @param string $limitation The city (or comma list of cities) limitation
 * @param string $op The operator (either '==' or '!=')
 * @param array $aParams An array of additional parameters to be checked
 * @return boolean Whether this impression's city passes this limitation's test.
 */
function MAX_checkGeo_City($limitation, $op, $aParams = array())
{
    if (empty($aParams)) {
        $aParams = $GLOBALS['_MAX']['CLIENT_GEO'];
    }
    if ($aParams && $aParams['city'] && $aParams['country_code']) {
        $aLimitation = array ( substr($limitation, 0, strpos($limitation, '|')),
                               substr($limitation, strpos($limitation, '|')+1)
                              );                               
        $sCities = $aLimitation[1];
        if (!empty($aLimitation[0])) {
            return MAX_limitationsMatchStringValue($aParams['country_code'], $aLimitation[0], '==')
                   && MAX_limitationsMatchArrayValue($aParams['city'], $sCities, $op);
        } else {
            return MAX_limitationsMatchArrayValue($aParams['city'], $sCities, $op);
        }
    } else {
        return false; // If client has no data about city, do not show the ad
    }
}

?>
