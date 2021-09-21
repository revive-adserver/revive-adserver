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

require_once __DIR__ . '/lib/MaxMindGeoIP2.php';

use RV_Plugins\geoTargeting\rvMaxMindGeoIP2\lib\MaxMindGeoIP2;

/**
 * Get the geo-information for this IP address using the GeoIP plugin
 *
 * @param boolean $useCookie Reading geo-information from the cookie enabled
 * @return array
 */
function Plugin_geoTargeting_rvMaxMindGeoIP2_rvMaxMindGeoIP2_Delivery_getGeoInfo($useCookie = true)
{
    return MaxMindGeoIP2::getGeoInfo($useCookie);
}
