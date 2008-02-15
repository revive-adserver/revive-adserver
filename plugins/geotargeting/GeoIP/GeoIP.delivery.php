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
$Id$
*/


/**
 * Get the geo-information for this IP address using the GeoIP plugin
 *
 * @param boolean $useCookie Reading geo-information from the cookie enabled
 * @return array An array with all the available Geo information
 */
function OA_Geo_GeoIP_getInfo($useCookie = true)
{
    $conf = $GLOBALS['_MAX']['CONF'];

    // Try and read the data from the geo cookie...
    if ($useCookie && isset($_COOKIE[$conf['var']['viewerGeo']])) {
        $ret = OA_Geo_GeoIP_unpackCookie($_COOKIE[$conf['var']['viewerGeo']]);
        if ($ret !== false) {
            return $ret;
        }
    }

    if (!is_callable('OA_Geo_GeoIP_getGeo')) {
        require MAX_PATH . '/plugins/geotargeting/GeoIP/data/geo-geoip.inc.php';
    }

    if (isset($GLOBALS['_MAX']['GEO_IP'])) {
        $ip   = $GLOBALS['_MAX']['GEO_IP'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }

    $aGeoConf = $conf['geotargeting'];

    if (!empty($aGeoConf['useBundledCountryDatabase'])) {
        $aGeoConf['geoipCountryLocation'] = MAX_PATH . '/plugins/geotargeting/GeoIP/data/FreeGeoIPCountry.dat';
    }

    $ret = array();
    foreach ($aGeoConf as $key => $db) {
        if ((substr($key, 0, 5) == 'geoip') && !empty($db) && is_readable($db)) {
            $geo = OA_Geo_GeoIP_getGeo($ip, $db);
            foreach ($geo as $feature => $value) {
                if (!empty($value)) {
                    $ret[$feature] = $geo[$feature];
                }
            }
        }
    }

    // Store this information in the cookie for later use
    if ($useCookie) {
        MAX_cookieSet($conf['var']['viewerGeo'], OA_Geo_GeoIP_packCookie($ret));
    }

    return $ret;
}

function OA_Geo_GeoIP_packCookie($data = array())
{
    $aGeoInfo = array (
            'country_code'  => '',
            'region'        => '',
            'city'          => '',
            'postal_code'   => '',
            'latitude'      => '',
            'longitude'     => '',
            'dma_code'      => '',
            'area_code'     => '',
            'organisation'  => '',
            'isp'           => '',
            'netspeed'      => ''
    );

    return join('|', array_merge($aGeoInfo, $data));
}

function OA_Geo_GeoIP_unpackCookie($string = '')
{
    $aGeoInfo = array (
            'country_code'  => '',
            'region'        => '',
            'city'          => '',
            'postal_code'   => '',
            'latitude'      => '',
            'longitude'     => '',
            'dma_code'      => '',
            'area_code'     => '',
            'organisation'  => '',
            'isp'           => '',
            'netspeed'      => ''
    );

    $aPieces = explode('|', $string);
    if (count($aPieces) == count($aGeoInfo)) {
        $i = 0;
        foreach (array_keys($aGeoInfo) as $key) {
            if (!empty($aPieces[$i])) {
                $aGeoInfo[$key] = $aPieces[$i++];
            } else {
                unset($aGeoInfo[$key]);
            }
        }
    } else {
        return false;
    }

    return $aGeoInfo;
}

?>
