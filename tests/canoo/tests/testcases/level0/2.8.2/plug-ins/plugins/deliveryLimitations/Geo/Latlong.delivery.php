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
require_once MAX_PATH . '/lib/max/other/lib-geo.inc.php';

/**
 * Check to see if this impression contains the valid latitude/longitude.
 *
 * @param string $limitation The latitude/longitude limitation
 * @param string $op The operator (either '==' or '!=')
 * @param array $aParams An array of additional parameters to be checked
 * @return boolean Whether this impression's latitude/longitude passes this limitation's test.
 */
function MAX_checkGeo_Latlong($limitation, $op, $aParams = array())
{
    if (empty($aParams)) {
        $aParams = $GLOBALS['_MAX']['CLIENT_GEO'];
    }
    if ($aParams && isset($aParams['latitude']) && isset($aParams['longitude'])) {
        $aRegion = MAX_geoReplaceEmptyWithZero(MAX_limitationsGetAFromS($limitation));
        $result = MAX_geoIsPlaceInRegion(
            $aParams['latitude'], $aParams['longitude'], $aRegion);
        if ($op == '==') {
            return $result;
        } else {
            return !$result;
        }
    } else {
        return ($op != '==');
    }
}

?>
