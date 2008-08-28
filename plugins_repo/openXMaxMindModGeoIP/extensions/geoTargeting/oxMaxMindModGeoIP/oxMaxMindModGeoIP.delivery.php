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
$Id: ModGeoIP.delivery.php 19480 2008-04-25 16:16:50Z andrew.hill@openx.org $
*/

/**
 * The method to look up the GeoTargeting information already obtained
 * by the mod_geoip Apache / lighttpd module.
 *
 * @return array An array that will contain the results of the
 *               GeoTargeting lookup.
 */
function Plugin_geoTargeting_oxMaxMindModGeoIP_oxMaxMindModGeoIP_Delivery_getGeoInfo() {
    $result = array();
    if (isset($_SERVER['GEOIP_COUNTRY_CODE'])) {
          $result['country_code'] = $_SERVER['GEOIP_COUNTRY_CODE'];
    }
    if (isset($_SERVER['GEOIP_COUNTRY_NAME'])) {
        $result['country_name'] = $_SERVER['GEOIP_COUNTRY_NAME'];
    }
    if (isset($_SERVER['GEOIP_REGION'])) {
        $result['region'] = $_SERVER['GEOIP_REGION'];
    } else if (isset($_SERVER['GEOIP_CITY_REGION'])) {
        $result['region'] = $_SERVER['GEOIP_CITY_REGION'];
    }
    if (isset($_SERVER['GEOIP_CITY'])) {
        $result['city'] = $_SERVER['GEOIP_CITY'];
    } else if (isset($_SERVER['GEOIP_CITY_NAME'])) {
        $result['city'] = $_SERVER['GEOIP_CITY_NAME'];
    }
    if (isset($_SERVER['GEOIP_POSTAL_CODE'])) {
        $result['postal_code'] = $_SERVER['GEOIP_POSTAL_CODE'];
    } else if (isset($_SERVER['GEOIP_CITY_POSTAL_CODE'])) {
        $result['postal_code'] = $_SERVER['GEOIP_CITY_POSTAL_CODE'];
    }
    if (isset($_SERVER['GEOIP_LATITUDE'])) {
        $result['latitude'] = $_SERVER['GEOIP_LATITUDE'];
    } else if (isset($_SERVER['GEOIP_CITY_LATITUDE'])) {
        $result['latitude'] = $_SERVER['GEOIP_CITY_LATITUDE'];
    }
    if (isset($_SERVER['GEOIP_LONGITUDE'])) {
        $result['longitude'] = $_SERVER['GEOIP_LONGITUDE'];
    } else if (isset($_SERVER['GEOIP_CITY_LONG_LATITUDE'])) {
        $result['longitude'] = $_SERVER['GEOIP_CITY_LONG_LATITUDE'];
    }
    if (isset($_SERVER['GEOIP_DMA_CODE'])) {
        $result['dma_code'] = $_SERVER['GEOIP_DMA_CODE'];
    } else if (isset($_SERVER['GEOIP_CITY_DMA_CODE'])) {
        $result['dma_code'] = $_SERVER['GEOIP_CITY_DMA_CODE'];
    }
    if (isset($_SERVER['GEOIP_AREA_CODE'])) {
        $result['area_code'] = $_SERVER['GEOIP_AREA_CODE'];
    } else if (isset($_SERVER['GEOIP_CITY_AREA_CODE'])) {
        $result['area_code'] = $_SERVER['GEOIP_CITY_AREA_CODE'];
    }
    if (isset($_SERVER['GEOIP_ORGANIZATION'])) {
        $result['organisation'] = $_SERVER['GEOIP_ORGANIZATION'];
    }
    if (isset($_SERVER['GEOIP_ISP'])) {
        $result['isp'] = $_SERVER['GEOIP_ISP'];
    }
    if (isset($_SERVER['GEOIP_NETSPEED'])) {
        $result['netspeed'] = $_SERVER['GEOIP_NETSPEED'];
    }
    return $result;
}

?>
