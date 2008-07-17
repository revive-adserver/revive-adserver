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

require_once MAX_PATH . '/lib/max/Plugin.php';

/**
 * A class for testing the Plugins_Geotargeting_ModGeoIP_ModGeoIP class.
 *
 * @package    MaxDelivery
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew@m3.net>
 */
class Delivery_TestOfPlugins_Geotargeting_ModGeoIP_ModGeoIP extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function Delivery_TestOfPlugins_Geotargeting_ModGeoIP_ModGeoIPP()
    {
        $this->UnitTestCase();
    }

    /**
     * Test the getModuleInfo method.
     */
    function testGetModuleInfo()
    {
        $this->assertEqual(
            MAX_Plugin::callStaticMethod('geotargeting', 'ModGeoIP', 'ModGeoIP', 'getModuleInfo'),
            'MaxMind mod_apache GeoIP'
        );
    }

    /**
     * Test the getInfo method.
     */
    function testGetInfo()
    {
        // Test the old style database codes
        $_SERVER['GEOIP_COUNTRY_CODE']  = 'Test Country';
        $_SERVER['GEOIP_COUNTRY_NAME']  = 'Test Name';
        $_SERVER['GEOIP_REGION']        = 'Test Region';
        $_SERVER['GEOIP_CITY']          = 'Test City';
        $_SERVER['GEOIP_POSTAL_CODE']   = 'Test PC';
        $_SERVER['GEOIP_LATITUDE']      = 'Test Lat';
        $_SERVER['GEOIP_LONGITUDE']     = 'Test Long';
        $_SERVER['GEOIP_DMA_CODE']      = 'Test Code';
        $_SERVER['GEOIP_AREA_CODE']     = 'Test Area';
        $_SERVER['GEOIP_ORGANIZATION']  = 'Test Org';
        $_SERVER['GEOIP_NETSPEED']      = 'Test Speed';

        $result = MAX_Plugin::callStaticMethod('geotargeting', 'ModGeoIP', 'ModGeoIP', 'getInfo');

        $this->assertEqual($result['country_code'], 'Test Country');
        $this->assertEqual($result['country_name'], 'Test Name');
        $this->assertEqual($result['region'],       'Test Region');
        $this->assertEqual($result['city'],         'Test City');
        $this->assertEqual($result['postal_code'],  'Test PC');
        $this->assertEqual($result['latitude'],     'Test Lat');
        $this->assertEqual($result['longitude'],    'Test Long');
        $this->assertEqual($result['dma_code'],     'Test Code');
        $this->assertEqual($result['area_code'],    'Test Area');
        $this->assertEqual($result['organisation'], 'Test Org');
        $this->assertEqual($result['netspeed'],     'Test Speed');

        unset($_SERVER['GEOIP_COUNTRY_CODE']);
        unset($_SERVER['GEOIP_COUNTRY_NAME']);
        unset($_SERVER['GEOIP_REGION']);
        unset($_SERVER['GEOIP_CITY']);
        unset($_SERVER['GEOIP_POSTAL_CODE']);
        unset($_SERVER['GEOIP_LATITUDE']);
        unset($_SERVER['GEOIP_LONGITUDE']);
        unset($_SERVER['GEOIP_DMA_CODE']);
        unset($_SERVER['GEOIP_AREA_CODE']);
        unset($_SERVER['GEOIP_ORGANIZATION']);
        unset($_SERVER['GEOIP_NETSPEED']);

        // Test the new style database codes
        $_SERVER['GEOIP_COUNTRY_CODE']       = 'Test Country';
        $_SERVER['GEOIP_COUNTRY_NAME']       = 'Test Name';
        $_SERVER['GEOIP_CITY_REGION']        = 'Test Region';
        $_SERVER['GEOIP_CITY_NAME']          = 'Test City';
        $_SERVER['GEOIP_CITY_POSTAL_CODE']   = 'Test PC';
        $_SERVER['GEOIP_CITY_LATITUDE']      = 'Test Lat';
        $_SERVER['GEOIP_CITY_LONG_LATITUDE'] = 'Test Long';
        $_SERVER['GEOIP_CITY_DMA_CODE']      = 'Test Code';
        $_SERVER['GEOIP_CITY_AREA_CODE']     = 'Test Area';
        $_SERVER['GEOIP_ORGANIZATION']       = 'Test Org';
        $_SERVER['GEOIP_NETSPEED']           = 'Test Speed';

        $result = MAX_Plugin::callStaticMethod('geotargeting', 'ModGeoIP', 'ModGeoIP', 'getInfo');

        $this->assertEqual($result['country_code'], 'Test Country');
        $this->assertEqual($result['country_name'], 'Test Name');
        $this->assertEqual($result['region'],       'Test Region');
        $this->assertEqual($result['city'],         'Test City');
        $this->assertEqual($result['postal_code'],  'Test PC');
        $this->assertEqual($result['latitude'],     'Test Lat');
        $this->assertEqual($result['longitude'],    'Test Long');
        $this->assertEqual($result['dma_code'],     'Test Code');
        $this->assertEqual($result['area_code'],    'Test Area');
        $this->assertEqual($result['organisation'], 'Test Org');
        $this->assertEqual($result['netspeed'],     'Test Speed');

        unset($_SERVER['GEOIP_COUNTRY_CODE']);
        unset($_SERVER['GEOIP_COUNTRY_NAME']);
        unset($_SERVER['GEOIP_CITY_REGION']);
        unset($_SERVER['GEOIP_CITY_NAME']);
        unset($_SERVER['GEOIP_CITY_POSTAL_CODE']);
        unset($_SERVER['GEOIP_CITY_LATITUDE']);
        unset($_SERVER['GEOIP_CITY_LONG_LATITUDE']);
        unset($_SERVER['GEOIP_CITY_DMA_CODE']);
        unset($_SERVER['GEOIP_CITY_AREA_CODE']);
        unset($_SERVER['GEOIP_ORGANIZATION']);
        unset($_SERVER['GEOIP_NETSPEED']);
    }

}

?>