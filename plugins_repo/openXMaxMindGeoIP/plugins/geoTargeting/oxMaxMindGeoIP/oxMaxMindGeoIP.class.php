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

require_once dirname(__FILE__) . '/oxMaxMindGeoIP.delivery.php';

/**
 * Class to get GeoTargeting information directly from the MaxMind LLC
 * database file, without having it accessed via the C/mod_apache
 * interface.
 *
 * @package    OpenXPlugin
 * @subpackage GeoTargeting
 * @author     Chris Nutting <chris.nutting@openx.org>
 */
class Plugins_GeoTargeting_oxMaxMindGeoIP_OxMaxMindGeoIP extends OX_Component
{

    /**
     * Return plugin name
     *
     * @return string A string describing the class.
     */
    function getName()
    {
        return $this->translate("MaxMind GeoIP (Flat file)");
    }

    /**
     * The method calls to the delivery half of the plugin to get the
     * geo information
     *
     * @return array An array that will contain the results of the
     *               GeoTargeting lookup.
     */
    function getGeoInfo($useCookie = false)
    {
        return Plugin_geoTargeting_oxMaxMindGeoIP_oxMaxMindGeoIP_Delivery_getGeoInfo($useCookie);
    }
}

?>