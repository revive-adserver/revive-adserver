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

/**
 * A class for testing the RV_Sync class.
 *
 * @package    Revive Adserver
 * @subpackage TestSuite
 */
class Test_RV_Upgrade_GeoIp2Migration extends UnitTestCase
{
    function __construct()
    {
        parent::__construct();
    }

    function testMigrateError()
    {
        try {
            \RV\Upgrade\GeoIp2Migration::migrate([
                'foo' => 'bar',
            ]);
        } catch (\InvalidArgumentException $e) {
            $this->assertTrue(true);
            return;
        }

        $this->fail('exception expected');
    }

    function testMigrateAreacode()
    {
        try {
            \RV\Upgrade\GeoIp2Migration::migrate([
                'type' => 'deliveryLimitations:Geo:Areacode',
            ]);
        } catch (\RV\Upgrade\Exception\DeliveryRuleDeletedException $e) {
            $this->assertTrue(true);
            return;
        }

        $this->fail('exception expected');
    }

    function testMigrateDma()
    {
        $this->assertEqual(
            \RV\Upgrade\GeoIp2Migration::migrate([
                'type' => 'deliveryLimitations:Geo:Dma',
                'op' => 'x',
            ]),
            [
                'type' => 'deliveryLimitations:Geo:UsMetro',
                'op' => 'x',
            ]
        );
    }

    function testMigrateNetspeed()
    {
        $this->assertEqual(
            \RV\Upgrade\GeoIp2Migration::migrate([
                'type' => 'deliveryLimitations:Geo:Netspeed',
                'op' => 'x',
            ]),
            [
                'type' => 'deliveryLimitations:Geo:ConnectionType',
                'op' => 'x',
            ]
        );
    }

    function testMigrateRegion()
    {
        // No change for US
        $this->assertEqual(
            \RV\Upgrade\GeoIp2Migration::migrate([
                'type' => 'deliveryLimitations:Geo:Region',
                'op' => 'x',
                'data' => 'US|CA,NY',
            ]),
            [
                'type' => 'deliveryLimitations:Geo:Subdivision1',
                'op' => 'x',
                'data' => 'US|CA,NY',
            ]
        );

        $this->assertEqual(
            \RV\Upgrade\GeoIp2Migration::migrate([
                'type' => 'deliveryLimitations:Geo:Region',
                'op' => 'x',
                'data' => 'IT|02,06',
            ]),
            [
                'type' => 'deliveryLimitations:Geo:Subdivision1',
                'op' => 'x',
                'data' => 'IT|36,77',
            ]
        );

        $this->assertEqual(
            \RV\Upgrade\GeoIp2Migration::migrate([
                'type' => 'deliveryLimitations:Geo:Region',
                'op' => 'x',
                'data' => 'BE|02,01',
            ]),
            [
                'type' => 'deliveryLimitations:Geo:Subdivision2',
                'op' => 'x',
                'data' => 'BE|VAN,VBR',
            ]
        );

        $this->assertEqual(
            \RV\Upgrade\GeoIp2Migration::migrate([
                'type' => 'deliveryLimitations:Geo:Region',
                'op' => 'x',
                'data' => 'TW|02',
            ]),
            [
                'type' => 'deliveryLimitations:Geo:Subdivision1',
                'op' => 'x',
                'data' => 'TW|KHH'
            ]
        );

        $this->assertEqual(
            \RV\Upgrade\GeoIp2Migration::migrate([
                'type' => 'deliveryLimitations:Geo:Region',
                'op' => 'x',
                'data' => 'TW|01',
            ]),
            [
                'type' => 'deliveryLimitations:Geo:Subdivision1',
                'op' => 'x',
                'data' => 'CN|FJ'
            ]
        );

        // Lose the region that has been moved to another country
        $this->assertEqual(
            \RV\Upgrade\GeoIp2Migration::migrate([
                'type' => 'deliveryLimitations:Geo:Region',
                'op' => 'x',
                'data' => 'TW|01,02',
            ]),
            [
                'type' => 'deliveryLimitations:Geo:Subdivision1',
                'op' => 'x',
                'data' => 'TW|KHH'
            ]
        );

    }
}
