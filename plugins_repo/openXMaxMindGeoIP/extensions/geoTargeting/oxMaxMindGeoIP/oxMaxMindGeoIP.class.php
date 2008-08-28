<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
| For contact details, see: http://www.openx.org/                           |
|                                                                           |
| This program is free software; you can redistribute it and/or modify      |
| it under the terms of the GNU General Public License as published by      |
| the Free Software Foundation; either version 2 of the License, or         |
| (at your option) any later version.                                       |
|                                                                           |
| This program is distributed in the hope that it will be useful,           |
| but WITHOUT ANY WARRANTY; without even the implied warranty of            |
| MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
| GNU General Public License for more details.                              |
|                                                                           |
| You should have received a copy of the GNU General Public License         |
| along with this program; if not, write to the Free Software               |
| Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA |
+---------------------------------------------------------------------------+
$Id: GeoIP.plugin.php 16124 2008-02-11 18:16:06Z andrew.hill@openads.org $
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
        return 'OpenX MaxMind (Flat file)';
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