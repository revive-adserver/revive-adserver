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

require_once __DIR__ . '/../../lib/MaxMindGeoIP2.php';

use RV_Plugins\geoTargeting\rvMaxMindGeoIP2\MaxMindGeoIP2;

/**
 * A class for testing the RvMaxMindGeoIP2 delivery component.
 *
 * @package    MaxDelivery
 * @subpackage TestSuite
 * @TODO       Has not been tested with the Netspeed database,
 *             tests for this database type need to be written.
 */
class Delivery_TestOfRvMaxMindGeoIP2 extends UnitTestCase
{
    function setUp()
    {
        TestEnv::restoreConfig();
    }

    function test_packUnpackCookie()
    {
        $variables = 27;

        $string = MaxMindGeoIP2::packCookie();
        $aResult = MaxMindGeoIP2::unpackCookie($string);
        $this->assertIsA($aResult, 'array');
        $this->assertEqual(count($aResult), $variables);

        $string = "a|b|c";
        $geoinfo = MaxMindGeoIP2::unpackCookie($string);
        $this->assertFalse($geoinfo);

        $geodata = [
            'country' => 'IT',
            'user_type' => 'foo',
        ];

        $string = MaxMindGeoIP2::packCookie($geodata);
        $aResult = MaxMindGeoIP2::unpackCookie($string);
        $this->assertIsA($aResult, 'array');

        array_walk($geodata, function ($v, $k) use ($aResult) {
            $this->assertEqual($v, $aResult[$k]);
        });
    }

    function testAnonymous()
    {
        $data = [
            "1.2.0.0" => [
                    "is_anonymous" => true,
                    "is_anonymous_vpn" => true
            ],
            "81.2.69.0" => [
                    "is_anonymous" => true,
                    "is_anonymous_vpn" => true,
                    "is_hosting_provider" => true,
                    "is_public_proxy" => true,
                    "is_tor_exit_node" => true

            ],
        ];

        $GLOBALS['_MAX']['CONF']['rvMaxMindGeoIP2']['mmdb_paths'] = realpath(__DIR__.'/../data/GeoIP2-Anonymous-IP-Test.mmdb');

        foreach ($data as $ip => $aExpected) {
            $GLOBALS['_MAX']['GEO_IP'] = $ip;
            $aResult = MaxMindGeoIP2::getGeoInfo(false);

            $this->assertEqual($aResult, $aExpected);
        }
    }

    function testCity()
    {
        $data = [
            "2.125.160.216" => [
                'continent' => 'EU',
                'country' => 'GB',
                'is_in_eu' => true,
                'city' => 'Boxford',
                'postal_code' => 'OX1',
                'latitude' => 51.75,
                'longitude' => -1.25,
                'accuracy_radius' => 100,
                'time_zone' => 'Europe/London',
                'subdivision_1' => 'ENG',
                'subdivision_2' => 'WBK',
            ],
            "216.160.83.56" => [
                'continent' => 'NA',
                'country' => 'US',
                'city' => 'Milton',
                'postal_code' => '98354',
                'latitude' => 47.2513,
                'longitude' => -122.3149,
                'accuracy_radius' => 22,
                'time_zone' => 'America/Los_Angeles',
                'metro_code' => 819,
                'subdivision_1' => 'WA',
            ],
            "175.16.199.0" => [
                'continent' => 'AS',
                'country' => 'CN',
                'city' => 'Changchun',
                'latitude' => 43.88,
                'longitude' => 125.3228,
                'accuracy_radius' => 100,
                'time_zone' => 'Asia/Harbin',
                'subdivision_1' => '22',
            ],
        ];

        $GLOBALS['_MAX']['CONF']['rvMaxMindGeoIP2']['mmdb_paths'] = realpath(__DIR__.'/../data/GeoIP2-City-Test.mmdb');

        foreach ($data as $ip => $aExpected) {
            $GLOBALS['_MAX']['GEO_IP'] = $ip;
            $aResult = MaxMindGeoIP2::getGeoInfo(false);

            $this->assertEqual($aResult, $aExpected);
        }
    }

    function testConnectionType()
    {
        $data = [
            "175.16.199.0" => [
                'connection_type' => 'Dialup',
            ],
            "187.156.138.0" => [
                'connection_type' => 'Cable/DSL',
            ],
            "201.243.200.0" => [
                'connection_type' => 'Corporate',
            ],
            "207.179.48.0" => [
                'connection_type' => 'Cellular',
            ],
        ];

        $GLOBALS['_MAX']['CONF']['rvMaxMindGeoIP2']['mmdb_paths'] = realpath(__DIR__.'/../data/GeoIP2-Connection-Type-Test.mmdb');

        foreach ($data as $ip => $aExpected) {
            $GLOBALS['_MAX']['GEO_IP'] = $ip;
            $aResult = MaxMindGeoIP2::getGeoInfo(false);

            $this->assertEqual($aResult, $aExpected);
        }
    }

    function testCountry()
    {
        $data = [
            "2.125.160.216" => [
                'continent' => 'EU',
                'country' => 'GB',
                'is_in_eu' => true,
                'postal_code' => 'OX1',
            ],
            "216.160.83.56" => [
                'continent' => 'NA',
                'country' => 'US',
                'postal_code' => '98354',
            ],
            "111.235.160.0" => [
                'continent' => 'AS',
                'country' => 'CN',
            ],
        ];

        $GLOBALS['_MAX']['CONF']['rvMaxMindGeoIP2']['mmdb_paths'] = realpath(__DIR__.'/../data/GeoIP2-Country-Test.mmdb');

        foreach ($data as $ip => $aExpected) {
            $GLOBALS['_MAX']['GEO_IP'] = $ip;
            $aResult = MaxMindGeoIP2::getGeoInfo(false);

            $this->assertEqual($aResult, $aExpected);
        }
    }

    function testDensityIncome()
    {
        $data = [
            "5.83.124.0" => [
                'average_income' => 32323,
                'population_density' => 1232,
            ],
            "216.160.83.0" => [
                'average_income' => 24626,
                'population_density' => 1341,
            ],
        ];

        $GLOBALS['_MAX']['CONF']['rvMaxMindGeoIP2']['mmdb_paths'] = realpath(__DIR__.'/../data/GeoIP2-DensityIncome-Test.mmdb');

        foreach ($data as $ip => $aExpected) {
            $GLOBALS['_MAX']['GEO_IP'] = $ip;
            $aResult = MaxMindGeoIP2::getGeoInfo(false);

            $this->assertEqual($aResult, $aExpected);
        }
    }

    function testDomain()
    {
        $data = [
            "1.2.0.0" => [
                'domain' => 'maxmind.com',
            ],
            "71.160.223.0" => [
                'domain' => 'verizon.net',
            ],
        ];

        $GLOBALS['_MAX']['CONF']['rvMaxMindGeoIP2']['mmdb_paths'] = realpath(__DIR__.'/../data/GeoIP2-Domain-Test.mmdb');

        foreach ($data as $ip => $aExpected) {
            $GLOBALS['_MAX']['GEO_IP'] = $ip;
            $aResult = MaxMindGeoIP2::getGeoInfo(false);

            $this->assertEqual($aResult, $aExpected);
        }
    }

    function testISP()
    {
        $data = [
            "1.0.128.0" => [
                'isp' => 'TOT Public Company Limited',
                'organization' => 'TOT Public Company Limited',
            ],
            "1.128.0.0" => [
                'autonomous_system_number' => 1221,
                'autonomous_system_organization' => 'Telstra Pty Ltd',
                'isp' => 'Telstra Internet',
                'organization' => 'Telstra Internet',
            ],
        ];

        $GLOBALS['_MAX']['CONF']['rvMaxMindGeoIP2']['mmdb_paths'] = realpath(__DIR__.'/../data/GeoIP2-ISP-Test.mmdb');

        foreach ($data as $ip => $aExpected) {
            $GLOBALS['_MAX']['GEO_IP'] = $ip;
            $aResult = MaxMindGeoIP2::getGeoInfo(false);

            $this->assertEqual($aResult, $aExpected);
        }
    }

    function testASN()
    {
        $data = [
            "1.128.0.0" => [
                'autonomous_system_number' => 1221,
                'autonomous_system_organization' => 'Telstra Pty Ltd',
            ],
        ];

        $GLOBALS['_MAX']['CONF']['rvMaxMindGeoIP2']['mmdb_paths'] = realpath(__DIR__.'/../data/GeoLite2-ASN-Test.mmdb');

        foreach ($data as $ip => $aExpected) {
            $GLOBALS['_MAX']['GEO_IP'] = $ip;
            $aResult = MaxMindGeoIP2::getGeoInfo(false);

            $this->assertEqual($aResult, $aExpected);
        }
    }

    function testEnterprise()
    {
        $data = [
            "216.160.83.56" => [
                'continent' => 'NA',
                'country' => 'US',
                'city' => 'Milton',
                'postal_code' => '98354',
                'latitude' => 47.2513,
                'longitude' => -122.3149,
                'accuracy_radius' => 22,
                'time_zone' => 'America/Los_Angeles',
                'metro_code' => 819,
                'subdivision_1' => 'WA',
                'connection_type' => 'Cable/DSL',
                'isp' => 'Century Link',
                'organization' => 'Lariat Software',
                'user_type' => 'government',
                'autonomous_system_number' => 209,
            ],
        ];

        $GLOBALS['_MAX']['CONF']['rvMaxMindGeoIP2']['mmdb_paths'] = realpath(__DIR__.'/../data/GeoIP2-Enterprise-Test.mmdb');

        foreach ($data as $ip => $aExpected) {
            $GLOBALS['_MAX']['GEO_IP'] = $ip;
            $aResult = MaxMindGeoIP2::getGeoInfo(false);

            $this->assertEqual($aResult, $aExpected);
        }
    }
}