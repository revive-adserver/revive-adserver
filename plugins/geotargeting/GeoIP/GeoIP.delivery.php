<?php

/*
+---------------------------------------------------------------------------+
| Max Media Manager v0.3                                                    |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2006 m3 Media Services Limited                         |
| For contact details, see: http://www.m3.net/                              |
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
$Id: GeoIP.delivery.php 5698 2006-10-12 16:16:22Z chris@m3.net $
*/

/**
 * Get the geo-information for this IP address using the GeoIP plugin
 *
 * @return array An array with all the available Geo information
 */
function MAX_Geo_GeoIP_getInfo()
{
    $conf = $GLOBALS['_MAX']['CONF'];
    if (isset($GLOBALS['_MAX']['GEO_IP'])) {
        $ip   = $GLOBALS['_MAX']['GEO_IP'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    // Use the MaxMind GeoIP Country Database
    if (empty($conf['geotargeting']['geoipCountryLocation'])) {
        // Use the free version of the database distributed with Max
        $conf['geotargeting']['geoipCountryLocation'] =
            MAX_PATH . '/plugins/geotargeting/GeoIP/data/FreeGeoIPCountry.dat';
    }
    if (!empty($conf['geotargeting']['geoipCountryLocation'])) {
        include_once MAX_PATH . '/plugins/geotargeting/GeoIP/data/geoip.inc';
        $gi = geoip_open($conf['geotargeting']['geoipCountryLocation'], GEOIP_STANDARD);
        // Optimization - geoip_country_id_by_addr() run only once
        $country_id = geoip_country_id_by_addr($gi,$ip);
		if ($country_id !== false) {
			$result['country_code'] = $gi->GEOIP_COUNTRY_CODES[$country_id];
			$result['country_name'] = $gi->GEOIP_COUNTRY_NAMES[$country_id];
		} else {
			$result['country_code'] = false;
			$result['country_name'] = false;
		}
        geoip_close($gi);
    }
    // Use the MaxMind GeoIP Region Database
    if (!empty($conf['geotargeting']['geoipRegionLocation'])) {
        include_once MAX_PATH . '/plugins/geotargeting/GeoIP/data/geoip.inc';
        $gi = geoip_open($conf['geotargeting']['geoipRegionLocation'], GEOIP_STANDARD);
        list($country, $region) = geoip_region_by_addr($gi, $ip);
        if (is_null($result['country_code']) || ($result['country_code'] == '')) {
            $result['country_code'] = $country;
        }
        $result['region'] = $region;
        geoip_close($gi);
    }
    // Use the MaxMind GeoIP City Database
    if (!empty($conf['geotargeting']['geoipCityLocation'])) {
        include_once MAX_PATH . '/plugins/geotargeting/GeoIP/data/geoipcity.inc';
        $gi = geoip_open($conf['geotargeting']['geoipCityLocation'], GEOIP_STANDARD);
        $record = geoip_record_by_addr($gi, $ip);
        if (is_null($result['country_code']) || ($result['country_code'] == '')) {
            $result['country_code'] = $record->country_code;
        }
        if (is_null($result['country_name']) || ($result['country_name'] == '')) {
            $result['country_name'] = $record->country_name;
        }
        if (is_null($result['region']) || ($result['region'] == '')) {
            $result['region'] = $record->region;
        }
        $result['city'] = $record->city;
        $result['postal_code'] = $record->postal_code;
        $result['latitude'] = (string) $record->latitude;
        $result['longitude'] = (string) $record->longitude;
        $result['dma_code'] = $record->dma_code;
        $result['area_code'] = $record->area_code;
        geoip_close($gi);
    }
    // Use the MaxMind GeoIP Area Code Database
    if (!empty($conf['geotargeting']['geoipAreaLocation'])) {
        include_once MAX_PATH . '/plugins/geotargeting/GeoIP/data/geoipcity.inc';
        $gi = geoip_open($conf['geotargeting']['geoipAreaLocation'], GEOIP_STANDARD);
        $record = geoip_record_by_addr($gi, $ip);
        if (is_null($result['country_code']) || ($result['country_code'] == '')) {
            $result['country_code'] = $record->country_code;
        }
        if (is_null($result['country_name']) || ($result['country_name'] == '')) {
            $result['country_name'] = $record->country_name;
        }
        if (is_null($result['region']) || ($result['region'] == '')) {
            $result['region'] = $record->region;
        }
        if (is_null($result['area_code']) || ($result['area_code'] == '')) {
            $result['area_code'] = $record->area_code;
        }
        geoip_close($gi);
    }
    // Use the MaxMind GeoIP DMA Code Database
    if (!empty($conf['geotargeting']['geoipDmaLocation'])) {
        include_once MAX_PATH . '/plugins/geotargeting/GeoIP/data/geoipcity.inc';
        $gi = geoip_open($conf['geotargeting']['geoipDmaLocation'], GEOIP_STANDARD);
        $record = geoip_record_by_addr($gi, $ip);
        if (is_null($result['country_code']) || ($result['country_code'] == '')) {
            $result['country_code'] = $record->country_code;
        }
        if (is_null($result['country_name']) || ($result['country_name'] == '')) {
            $result['country_name'] = $record->country_name;
        }
        if (is_null($result['region']) || ($result['region'] == '')) {
            $result['region'] = $record->region;
        }
        if (is_null($result['dma_code']) || ($result['dma_code'] == '')) {
            $result['dma_code'] = $record->dma_code;
        }
        geoip_close($gi);
    }
    // Use the MaxMind GeoIP Organization
    if (!empty($conf['geotargeting']['geoipOrgLocation'])) {
        include_once MAX_PATH . '/plugins/geotargeting/GeoIP/data/geoip.inc';
        $gi = geoip_open($conf['geotargeting']['geoipOrgLocation'], GEOIP_STANDARD);
        $result['organisation'] = geoip_org_by_addr($gi, $ip);
        geoip_close($gi);
    }
    // Use the MaxMind GeoIP ISP
    if (!empty($conf['geotargeting']['geoipIspLocation'])) {
        include_once MAX_PATH . '/plugins/geotargeting/GeoIP/data/geoip.inc';
        $gi = geoip_open($conf['geotargeting']['geoipIspLocation'], GEOIP_STANDARD);
        $result['isp'] = geoip_org_by_addr($gi, $ip);
        geoip_close($gi);
    }
    // Use the MaxMind GeoIP Netspeed
    if (!empty($conf['geotargeting']['geoipNetspeedLocation'])) {
        require_once MAX_PATH . '/plugins/geotargeting/GeoIP/data/geoip.inc';
        $gi = geoip_open($conf['geotargeting']['geoipNetspeedLocation'], GEOIP_STANDARD);
        $netspeed = geoip_country_id_by_addr($gi, $ip);
        if ($netspeed == GEOIP_UNKNOWN_SPEED) {
            $result['netspeed'] = "Unknown";
        } else if ($netspeed == GEOIP_DIALUP_SPEED) {
            $result['netspeed'] = "Dailup";
        } else if ($netspeed == GEOIP_CABLEDSL_SPEED) {
            $result['netspeed'] = "Cable/DSL";
        } else if ($netspeed == GEOIP_CORPORATE_SPEED) {
            $result['netspeed'] = "Corporate";
        }
        geoip_close($gi);
    }
    // Return the result(s)
    return $result;
}

?>