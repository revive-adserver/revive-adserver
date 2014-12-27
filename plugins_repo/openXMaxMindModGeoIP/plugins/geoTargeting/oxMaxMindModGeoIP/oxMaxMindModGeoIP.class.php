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

require_once dirname(__FILE__) . '/oxMaxMindModGeoIP.delivery.php';

/**
 * Class to get GeoTargeting information from the MaxMind LLC database file,
 * after the lookup has been performed via the C/mod_apache interface.
 *
 * @static
 * @package    OpenXPlugin
 * @subpackage Geotargeting
 */
class Plugins_Geotargeting_oxMaxMindModGeoIP_oxMaxMindModGeoIP extends OX_Component
{

    /**
     * A method to return information about the class.
     *
     * @return string A string describing the class.
     */
    function getName()
    {
        return $this->translate("MaxMind GeoIP (Apache mod_geoip)");
    }

    /**
     * The method calls to the delivery half of the plugin to get the
     * geo information
     *
     * @return array An array that will contain the results of the
     *               GeoTargeting lookup.
     */
    function getGeoInfo()
    {
        return Plugin_geoTargeting_oxMaxMindModGeoIP_oxMaxMindModGeoIP_Delivery_getGeoInfo();
    }
}

?>