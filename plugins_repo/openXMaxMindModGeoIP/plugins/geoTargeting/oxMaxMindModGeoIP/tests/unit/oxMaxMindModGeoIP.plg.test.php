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

require_once dirname(dirname(dirname(__FILE__))) . '/oxMaxMindModGeoIP.delivery.php';

/**
 * A class for testing the Plugins_Geotargeting_ModGeoIP_ModGeoIP class.
 *
 * @package    MaxDelivery
 * @subpackage TestSuite
 */
class Delivery_TestOfPlugins_Geotargeting_ModGeoIP_ModGeoIP extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function Delivery_TestOfPlugins_Geotargeting_ModGeoIP_ModGeoIPP()
    {
        parent::__construct();
    }

    /**
     * Test the getGeoInfo method.
     */
    function testGetGeoInfo()
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

        $result = Plugin_geoTargeting_oxMaxMindModGeoIP_oxMaxMindModGeoIP_Delivery_getGeoInfo();

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

        $result = Plugin_geoTargeting_oxMaxMindModGeoIP_oxMaxMindModGeoIP_Delivery_getGeoInfo();

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