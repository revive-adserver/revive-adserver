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
$Id: GeoIP.plg.test.php 18872 2008-04-15 11:48:59Z chris.nutting@openx.org $
*/

require_once dirname(dirname(dirname(__FILE__))) . '/oxMaxMindGeoIP.delivery.php';

/**
 * A class for testing the OxMaxMindGeoIP delivery component.
 * Will only test all database types if the databases are available -
 * see README.txt file, and contact MaxMind LLC (http://maxmind.com/)
 * for databases.
 *
 * @package    MaxDelivery
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew@m3.net>
 * @TODO       Has not been tested with the Netspeed database,
 *             tests for this database type need to be written.
 */
class Delivery_TestOfOxMaxMindGeoIP extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function Delivery_TestOfOxMaxMindGeoIP()
    {
        $this->UnitTestCase();
    }

    function setUp()
    {
        TestEnv::restoreConfig();
    }

    function test_GeoCookie()
    {
        $string = _packGeoCookie();
        $this->assertFalse(_unpackGeoCookie($string));
        $string = "a|b|c";
        $this->assertFalse(_unpackGeoCookie($string));
        $string = 'val1|val2|val3|val4|val5|val6|val7|val8|val9|val10|val11';
        $aResult = _unpackGeoCookie($string);
        $this->assertIsA($aResult,'array');
        $i = 1;
        foreach ($aResult as $k => $v)
        {
            $this->assertEqual($v, 'val'.$i++);
        }
    }


    /**
     * Test the getGeoInfo delivery function.
     */
    function testGetGeoInfo_noDb()
    {
        // Use a reference to $GLOBALS['_MAX']['CONF'] so that the configuration
        // options can be changed while the test is running
        $conf = &$GLOBALS['_MAX']['CONF'];

        $GLOBALS['_MAX']['GEO_IP'] = '24.24.24.24';

        // Test with the default database, and no additional MaxMind GeoIP databases
        $conf['oxMaxMindGeoIP']['geoipCountryLocation'] = '';
        $conf['oxMaxMindGeoIP']['geoipRegionLocation'] = '';
        $conf['oxMaxMindGeoIP']['geoipCityLocation'] = '';
        $conf['oxMaxMindGeoIP']['geoipAreaLocation'] = '';
        $conf['oxMaxMindGeoIP']['geoipDmaLocation'] = '';
        $conf['oxMaxMindGeoIP']['geoipOrgLocation'] = '';
        $conf['oxMaxMindGeoIP']['geoipIspLocation'] = '';
        $conf['oxMaxMindGeoIP']['geoipNetspeedLocation'] = '';
        $result = Plugin_geoTargeting_oxMaxMindGeoIP_oxMaxMindGeoIP_Delivery_getGeoInfo(false);
        $this->assertEqual($result['country_code'], 'US');
        $this->assertNull($result['region']);
        $this->assertNull($result['city']);
        $this->assertNull($result['postal_code']);
        $this->assertNull($result['latitude']);
        $this->assertNull($result['longitude']);
        $this->assertNull($result['dma_code']);
        $this->assertNull($result['area_code']);
        $this->assertNull($result['organisation']);
        $this->assertNull($result['netspeed']);

        // Test with a supplied GeoIP Country database
        $conf['oxMaxMindGeoIP']['geoipCountryLocation'] = dirname(dirname(dirname(__FILE__))) . '/data/FreeGeoIPCountry.dat';
        $conf['oxMaxMindGeoIP']['geoipRegionLocation'] = '';
        $conf['oxMaxMindGeoIP']['geoipCityLocation'] = '';
        $conf['oxMaxMindGeoIP']['geoipAreaLocation'] = '';
        $conf['oxMaxMindGeoIP']['geoipDmaLocation'] = '';
        $conf['oxMaxMindGeoIP']['geoipOrgLocation'] = '';
        $conf['oxMaxMindGeoIP']['geoipIspLocation'] = '';
        $conf['oxMaxMindGeoIP']['geoipNetspeedLocation'] = '';
        $result = Plugin_geoTargeting_oxMaxMindGeoIP_oxMaxMindGeoIP_Delivery_getGeoInfo(false);
        $this->assertEqual($result['country_code'], 'US');
        $this->assertNull($result['region']);
        $this->assertNull($result['city']);
        $this->assertNull($result['postal_code']);
        $this->assertNull($result['latitude']);
        $this->assertNull($result['longitude']);
        $this->assertNull($result['dma_code']);
        $this->assertNull($result['area_code']);
        $this->assertNull($result['organisation']);
        $this->assertNull($result['netspeed']);
    }

    function testGetGeoInfo_RegionDb() {
        // Test with a supplied GeoIP Region database
        $conf = &$GLOBALS['_MAX']['CONF'];

        $regionFile = $conf['oxMaxMindGeoIP']['geoipRegionLocation'];
        if (file_exists($regionFile)) {
            $conf['oxMaxMindGeoIP']['geoipCountryLocation'] = '';
            $conf['oxMaxMindGeoIP']['geoipRegionLocation'] = $regionFile;
            $conf['oxMaxMindGeoIP']['geoipCityLocation'] = '';
            $conf['oxMaxMindGeoIP']['geoipAreaLocation'] = '';
            $conf['oxMaxMindGeoIP']['geoipDmaLocation'] = '';
            $conf['oxMaxMindGeoIP']['geoipOrgLocation'] = '';
            $conf['oxMaxMindGeoIP']['geoipIspLocation'] = '';
            $conf['oxMaxMindGeoIP']['geoipNetspeedLocation'] = '';
            $result = Plugin_geoTargeting_oxMaxMindGeoIP_oxMaxMindGeoIP_Delivery_getGeoInfo(false);
            $this->assertEqual($result['country_code'], 'US');
            $this->assertEqual($result['region'], 'NY');
            $this->assertNull($result['city']);
            $this->assertNull($result['postal_code']);
            $this->assertNull($result['latitude']);
            $this->assertNull($result['longitude']);
            $this->assertNull($result['dma_code']);
            $this->assertNull($result['area_code']);
            $this->assertNull($result['organisation']);
            $this->assertNull($result['netspeed']);
        }
    }
    function testGetGeoInfo_CityDb()
    {
        $conf = &$GLOBALS['_MAX']['CONF'];

        // Test with a supplied GeoIP City database
        $cityFile = $conf['oxMaxMindGeoIP']['geoipCityLocation'];
        if (file_exists($cityFile)) {
            $conf['oxMaxMindGeoIP']['geoipCountryLocation'] = '';
            $conf['oxMaxMindGeoIP']['geoipRegionLocation'] = '';
            $conf['oxMaxMindGeoIP']['geoipCityLocation'] = $cityFile;
            $conf['oxMaxMindGeoIP']['geoipAreaLocation'] = '';
            $conf['oxMaxMindGeoIP']['geoipDmaLocation'] = '';
            $conf['oxMaxMindGeoIP']['geoipOrgLocation'] = '';
            $conf['oxMaxMindGeoIP']['geoipIspLocation'] = '';
            $conf['oxMaxMindGeoIP']['geoipNetspeedLocation'] = '';
            $result = Plugin_geoTargeting_oxMaxMindGeoIP_oxMaxMindGeoIP_Delivery_getGeoInfo(false);
            $this->assertEqual($result['country_code'], 'US');
            $this->assertEqual($result['region'], 'NY');
            $this->assertEqual($result['city'], 'Homer');
            $this->assertEqual($result['postal_code'], '13077');
            $this->assertEqual((string)$result['latitude'], '42.7259');
            $this->assertEqual($result['longitude'], -76.1896);
            $this->assertEqual($result['dma_code'], 555);
            $this->assertEqual($result['area_code'], 607);
            $this->assertNull($result['organisation']);
            $this->assertNull($result['netspeed']);
        }
    }
    function testGetGeoInfo_AreaDb()
    {
        $conf = &$GLOBALS['_MAX']['CONF'];

        // Test with a supplied GeoIP Area Code database
        $areaCodeFile = $conf['oxMaxMindGeoIP']['geoipAreaLocation'];
        if (file_exists($areaCodeFile)) {
            $conf['oxMaxMindGeoIP']['geoipCountryLocation'] = '';
            $conf['oxMaxMindGeoIP']['geoipRegionLocation'] = '';
            $conf['oxMaxMindGeoIP']['geoipCityLocation'] = '';
            $conf['oxMaxMindGeoIP']['geoipAreaLocation'] = $areaCodeFile;
            $conf['oxMaxMindGeoIP']['geoipDmaLocation'] = '';
            $conf['oxMaxMindGeoIP']['geoipOrgLocation'] = '';
            $conf['oxMaxMindGeoIP']['geoipIspLocation'] = '';
            $conf['oxMaxMindGeoIP']['geoipNetspeedLocation'] = '';
            $result = Plugin_geoTargeting_oxMaxMindGeoIP_oxMaxMindGeoIP_Delivery_getGeoInfo(false);
            $this->assertEqual($result['country_code'], 'US');
            $this->assertEqual($result['region'], 'NY');
            $this->assertEqual($result['city'], 'Homer');
            $this->assertEqual($result['postal_code'], '13077');
            $this->assertEqual((string)$result['latitude'], '42.7259');
            $this->assertEqual($result['longitude'], -76.1896);
            $this->assertEqual($result['dma_code'], 555);
            $this->assertEqual($result['area_code'], 607);
            $this->assertNull($result['netspeed']);
        }
    }
    function testGetGeoInfo_DmaDb()
    {
        $conf = &$GLOBALS['_MAX']['CONF'];

        // Test with a supplied GeoIP DMA Code database
        $dmaCodeFile = $conf['oxMaxMindGeoIP']['geoipDmaLocation'];
        if (file_exists($dmaCodeFile)) {
            $conf['oxMaxMindGeoIP']['geoipCountryLocation'] = '';
            $conf['oxMaxMindGeoIP']['geoipRegionLocation'] = '';
            $conf['oxMaxMindGeoIP']['geoipCityLocation'] = '';
            $conf['oxMaxMindGeoIP']['geoipAreaLocation'] = '';
            $conf['oxMaxMindGeoIP']['geoipDmaLocation'] = $dmaCodeFile;
            $conf['oxMaxMindGeoIP']['geoipOrgLocation'] = '';
            $conf['oxMaxMindGeoIP']['geoipIspLocation'] = '';
            $conf['oxMaxMindGeoIP']['geoipNetspeedLocation'] = '';
            $result = Plugin_geoTargeting_oxMaxMindGeoIP_oxMaxMindGeoIP_Delivery_getGeoInfo(false);
            $this->assertEqual($result['country_code'], 'US');
            $this->assertEqual($result['region'], 'NY');
            $this->assertEqual($result['city'], 'Homer');
            $this->assertEqual($result['postal_code'], '13077');
            $this->assertEqual((string)$result['latitude'], '42.7259');
            $this->assertEqual($result['longitude'], -76.1896);
            $this->assertEqual($result['dma_code'], 555);
            $this->assertEqual($result['area_code'], 607);
            $this->assertNull($result['netspeed']);
        }
    }
    function testGetGeoInfo_OrgDb()
    {
        $conf = &$GLOBALS['_MAX']['CONF'];

        // Test with a supplied GeoIP Organisation database
        $orgFile = $conf['oxMaxMindGeoIP']['geoipOrgLocation'];
        if (file_exists($orgFile)) {
            $conf['oxMaxMindGeoIP']['geoipCountryLocation'] = '';
            $conf['oxMaxMindGeoIP']['geoipRegionLocation'] = '';
            $conf['oxMaxMindGeoIP']['geoipCityLocation'] = '';
            $conf['oxMaxMindGeoIP']['geoipAreaLocation'] = '';
            $conf['oxMaxMindGeoIP']['geoipDmaLocation'] = '';
            $conf['oxMaxMindGeoIP']['geoipOrgLocation'] = $orgFile;
            $conf['oxMaxMindGeoIP']['geoipIspLocation'] = '';
            $conf['oxMaxMindGeoIP']['geoipNetspeedLocation'] = '';
            $result = Plugin_geoTargeting_oxMaxMindGeoIP_oxMaxMindGeoIP_Delivery_getGeoInfo(false);
            $this->assertequal($result['country_code'], 'US');
            $this->assertNull($result['region']);
            $this->assertNull($result['city']);
            $this->assertNull($result['postal_code']);
            $this->assertNull($result['latitude']);
            $this->assertNull($result['longitude']);
            $this->assertNull($result['dma_code']);
            $this->assertNull($result['area_code']);
            $this->assertEqual($result['organisation'], 'Road Runner');
            $this->assertNull($result['isp']);
            $this->assertNull($result['netspeed']);
        }
    }
    // Note: ISP database populates organisation field and this is what's tested by delivery
    function testGetGeoInfo_IspDb()
    {
        $conf = &$GLOBALS['_MAX']['CONF'];

        // Test with a supplied GeoIP ISP database
        $ispFile = $conf['oxMaxMindGeoIP']['geoipIspLocation'];
        if (file_exists($ispFile)) {
            $conf['oxMaxMindGeoIP']['geoipCountryLocation'] = '';
            $conf['oxMaxMindGeoIP']['geoipRegionLocation'] = '';
            $conf['oxMaxMindGeoIP']['geoipCityLocation'] = '';
            $conf['oxMaxMindGeoIP']['geoipAreaLocation'] = '';
            $conf['oxMaxMindGeoIP']['geoipDmaLocation'] = '';
            $conf['oxMaxMindGeoIP']['geoipOrgLocation'] = '';
            $conf['oxMaxMindGeoIP']['geoipIspLocation'] = $ispFile;
            $conf['oxMaxMindGeoIP']['geoipNetspeedLocation'] = '';
            $result = Plugin_geoTargeting_oxMaxMindGeoIP_oxMaxMindGeoIP_Delivery_getGeoInfo(false);
            $this->assertequal($result['country_code'], 'US');
            $this->assertNull($result['region']);
            $this->assertNull($result['city']);
            $this->assertNull($result['postal_code']);
            $this->assertNull($result['latitude']);
            $this->assertNull($result['longitude']);
            $this->assertNull($result['dma_code']);
            $this->assertNull($result['area_code']);
            $this->assertEqual($result['organisation'], 'Road Runner');
            $this->assertNull($result['isp']);
            $this->assertNull($result['netspeed']);
        }
    }

}

?>
