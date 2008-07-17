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
 * A class for testing the Plugins_Geotargeting_GeoIP_GeoIP class.
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
class Delivery_TestOfPlugins_Geotargeting_GeoIP_GeoIP extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function Delivery_TestOfPlugins_Geotargeting_GeoIP_GeoIP()
    {
        $this->UnitTestCase();
    }

    /**
     * Test the getModuleInfo method.
     */
    function testGetModuleInfo()
    {
        $this->assertEqual(
            MAX_Plugin::callStaticMethod('geotargeting', 'GeoIP', 'GeoIP', 'getModuleInfo'),
            'MaxMind GeoIP'
        );
    }

    function setUp()
    {
        // Save the conf variable so it can be modified during the test
        TestEnv::restoreConfig();
    }

    /**
     * Test the getInfo function.
     */
    function testGetInfo_noDb()
    {
        // Use a reference to $GLOBALS['_MAX']['CONF'] so that the configuration
        // options can be changed while the test is running
        $conf = &$GLOBALS['_MAX']['CONF'];

        $GLOBALS['_MAX']['GEO_IP'] = '24.24.24.24';

        // Test with the default database, and no additional MaxMind GeoIP databases
        $conf['geotargeting']['geoipCountryLocation'] = '';
        $conf['geotargeting']['geoipRegionLocation'] = '';
        $conf['geotargeting']['geoipCityLocation'] = '';
        $conf['geotargeting']['geoipAreaLocation'] = '';
        $conf['geotargeting']['geoipDmaLocation'] = '';
        $conf['geotargeting']['geoipOrgLocation'] = '';
        $conf['geotargeting']['geoipIspLocation'] = '';
        $conf['geotargeting']['geoipNetspeedLocation'] = '';
        $result = MAX_Plugin::callStaticMethod('geotargeting', 'GeoIP', 'GeoIP', 'getInfo');
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
        $conf['geotargeting']['geoipCountryLocation'] =
            MAX_PATH . '/plugins/geotargeting/GeoIP/data/FreeGeoIPCountry.dat';
        $conf['geotargeting']['geoipRegionLocation'] = '';
        $conf['geotargeting']['geoipCityLocation'] = '';
        $conf['geotargeting']['geoipAreaLocation'] = '';
        $conf['geotargeting']['geoipDmaLocation'] = '';
        $conf['geotargeting']['geoipOrgLocation'] = '';
        $conf['geotargeting']['geoipIspLocation'] = '';
        $conf['geotargeting']['geoipNetspeedLocation'] = '';
        $result = MAX_Plugin::callStaticMethod('geotargeting', 'GeoIP', 'GeoIP', 'getInfo');
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

    function testGetInfo_RegionDb() {
        // Test with a supplied GeoIP Region database
        $conf = &$GLOBALS['_MAX']['CONF'];

        $regionFile = $conf['geotargeting']['geoipRegionLocation'];
        if (file_exists($regionFile)) {
            $conf['geotargeting']['geoipCountryLocation'] = '';
            $conf['geotargeting']['geoipRegionLocation'] = $regionFile;
            $conf['geotargeting']['geoipCityLocation'] = '';
            $conf['geotargeting']['geoipAreaLocation'] = '';
            $conf['geotargeting']['geoipDmaLocation'] = '';
            $conf['geotargeting']['geoipOrgLocation'] = '';
            $conf['geotargeting']['geoipIspLocation'] = '';
            $conf['geotargeting']['geoipNetspeedLocation'] = '';
            $result = MAX_Plugin::callStaticMethod('geotargeting', 'GeoIP', 'GeoIP', 'getInfo');
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
    function testGetInfo_CityDb()
    {
        $conf = &$GLOBALS['_MAX']['CONF'];

        // Test with a supplied GeoIP City database
        $cityFile = $conf['geotargeting']['geoipCityLocation'];
        if (file_exists($cityFile)) {
            $conf['geotargeting']['geoipCountryLocation'] = '';
            $conf['geotargeting']['geoipRegionLocation'] = '';
            $conf['geotargeting']['geoipCityLocation'] = $cityFile;
            $conf['geotargeting']['geoipAreaLocation'] = '';
            $conf['geotargeting']['geoipDmaLocation'] = '';
            $conf['geotargeting']['geoipOrgLocation'] = '';
            $conf['geotargeting']['geoipIspLocation'] = '';
            $conf['geotargeting']['geoipNetspeedLocation'] = '';
            $result = MAX_Plugin::callStaticMethod('geotargeting', 'GeoIP', 'GeoIP', 'getInfo');
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
    function testGetInfo_AreaDb()
    {
        $conf = &$GLOBALS['_MAX']['CONF'];

        // Test with a supplied GeoIP Area Code database
        $areaCodeFile = $conf['geotargeting']['geoipAreaLocation'];
        if (file_exists($areaCodeFile)) {
            $conf['geotargeting']['geoipCountryLocation'] = '';
            $conf['geotargeting']['geoipRegionLocation'] = '';
            $conf['geotargeting']['geoipCityLocation'] = '';
            $conf['geotargeting']['geoipAreaLocation'] = $areaCodeFile;
            $conf['geotargeting']['geoipDmaLocation'] = '';
            $conf['geotargeting']['geoipOrgLocation'] = '';
            $conf['geotargeting']['geoipIspLocation'] = '';
            $conf['geotargeting']['geoipNetspeedLocation'] = '';
            $result = MAX_Plugin::callStaticMethod('geotargeting', 'GeoIP', 'GeoIP', 'getInfo');
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
    function testGetInfo_DmaDb()
    {
        $conf = &$GLOBALS['_MAX']['CONF'];

        // Test with a supplied GeoIP DMA Code database
        $dmaCodeFile = $conf['geotargeting']['geoipDmaLocation'];
        if (file_exists($dmaCodeFile)) {
            $conf['geotargeting']['geoipCountryLocation'] = '';
            $conf['geotargeting']['geoipRegionLocation'] = '';
            $conf['geotargeting']['geoipCityLocation'] = '';
            $conf['geotargeting']['geoipAreaLocation'] = '';
            $conf['geotargeting']['geoipDmaLocation'] = $dmaCodeFile;
            $conf['geotargeting']['geoipOrgLocation'] = '';
            $conf['geotargeting']['geoipIspLocation'] = '';
            $conf['geotargeting']['geoipNetspeedLocation'] = '';
            $result = MAX_Plugin::callStaticMethod('geotargeting', 'GeoIP', 'GeoIP', 'getInfo');
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
    function testGetInfo_OrgDb()
    {
        $conf = &$GLOBALS['_MAX']['CONF'];

        // Test with a supplied GeoIP Organisation database
        $orgFile = $conf['geotargeting']['geoipOrgLocation'];
        if (file_exists($orgFile)) {
            $conf['geotargeting']['geoipCountryLocation'] = '';
            $conf['geotargeting']['geoipRegionLocation'] = '';
            $conf['geotargeting']['geoipCityLocation'] = '';
            $conf['geotargeting']['geoipAreaLocation'] = '';
            $conf['geotargeting']['geoipDmaLocation'] = '';
            $conf['geotargeting']['geoipOrgLocation'] = $orgFile;
            $conf['geotargeting']['geoipIspLocation'] = '';
            $conf['geotargeting']['geoipNetspeedLocation'] = '';
            $result = MAX_Plugin::callStaticMethod('geotargeting', 'GeoIP', 'GeoIP', 'getInfo');
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
    function testGetInfo_IspDb()
    {
        $conf = &$GLOBALS['_MAX']['CONF'];

        // Test with a supplied GeoIP ISP database
        $ispFile = $conf['geotargeting']['geoipIspLocation'];
        if (file_exists($ispFile)) {
            $conf['geotargeting']['geoipCountryLocation'] = '';
            $conf['geotargeting']['geoipRegionLocation'] = '';
            $conf['geotargeting']['geoipCityLocation'] = '';
            $conf['geotargeting']['geoipAreaLocation'] = '';
            $conf['geotargeting']['geoipDmaLocation'] = '';
            $conf['geotargeting']['geoipOrgLocation'] = '';
            $conf['geotargeting']['geoipIspLocation'] = $ispFile;
            $conf['geotargeting']['geoipNetspeedLocation'] = '';
            $result = MAX_Plugin::callStaticMethod('geotargeting', 'GeoIP', 'GeoIP', 'getInfo');
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
