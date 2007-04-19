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
$Id$
*/

require_once MAX_PATH . '/lib/max/Dal/Statistics.php';
require_once 'Date.php';

/**
 * A class for testing the non-DB specific MAX_Dal_Statistics DAL class.
 *
 * @package    MaxDal
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew@m3.net>
 */
class Dal_TestOfMAX_Dal_Statistics extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function Dal_TestOfMAX_Dal_Statistics()
    {
        $this->UnitTestCase();
    }

    /**
     * A method to test the getPlacementFirstStatsDate() method.
     *
     * Requirements:
     * Test 1: Test with an invalid placement ID, and ensure null is returned.
     * Test 2: Test with no data in the database, and ensure current date is returned.
     * Test 3: Test with single row in the database, and ensure correct date is
     *         returned.
     * Test 4: Test with multi rows in the database, and ensure correct date is
     *         returned.
     */
    function testGetPlacementFirstStatsDate()
    {
        $conf = &$GLOBALS['_MAX']['CONF'];
        $oDbh = &OA_DB::singleton();

        $adTable = $conf['table']['prefix'] . $conf['table']['banners'];
        $dsahTable = $conf['table']['prefix'] . $conf['table']['data_summary_ad_hourly'];

        $oDalStatistics = new MAX_Dal_Statistics();

        // Test 1
        $placementId = 'foo';
        $oResult = $oDalStatistics->getPlacementFirstStatsDate($placementId);
        $this->assertNull($oResult);

        // Test 2
        $placementId = 1;
        $oBeforeDate = new Date();
        sleep(1);
        $oResult = $oDalStatistics->getPlacementFirstStatsDate($placementId);
        sleep(1);
        $oAfterDate = new Date();
        $this->assertTrue(is_a($oResult, 'Date'));
        $this->assertTrue($oBeforeDate->before($oResult));
        $this->assertTrue($oAfterDate->after($oResult));

        // Test 3
        $oNow = new Date();
        $query = "
            INSERT INTO
                $adTable
                (
                    bannerid,
                    campaignid,
                    active,
                    storagetype,
                    htmltemplate,
                    htmlcache,
                    weight,
                    url,
                    bannertext,
                    compiledlimitation,
                    append,
                    updated,
                    acls_updated
                )
            VALUES
                (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $aTypes = array(
            'integer',
            'integer',
            'text',
            'text',
            'text',
            'text',
            'integer',
            'text',
            'text',
            'text',
            'text',
            'timestamp',
            'timestamp'
        );
        $stAd = $oDbh->prepare($query, $aTypes, MDB2_PREPARE_MANIP);
        $aData = array(
            2,
            1,
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            $oNow->format('%Y-%m-%d %H:%M:%S'),
            $oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $rows = $stAd->execute($aData);
        $query = "
            INSERT INTO
                $dsahTable
                (
                    day,
                    hour,
                    ad_id,
                    creative_id,
                    zone_id,
                    updated
                )
            VALUES
                (?, ?, ?, ?, ?, ?)";
        $aTypes = array(
            'date',
            'integer',
            'integer',
            'integer',
            'integer',
            'timestamp'
        );
        $stDsah = $oDbh->prepare($query, $aTypes, MDB2_PREPARE_MANIP);
        $aData = array(
            '2006-10-30',
            12,
            2,
            '',
            '',
            $oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $rows = $stDsah->execute($aData);
        $oResult = $oDalStatistics->getPlacementFirstStatsDate($placementId);
        $oExpectedDate = new Date('2006-10-30 12:00:00');
        $this->assertEqual($oResult, $oExpectedDate);

        // Test 4
        $aData = array(
            3,
            1,
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            $oNow->format('%Y-%m-%d %H:%M:%S'),
            $oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $rows = $stAd->execute($aData);
        $aData = array(
            1,
            2,
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            $oNow->format('%Y-%m-%d %H:%M:%S'),
            $oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $rows = $stAd->execute($aData);
        $aData = array(
            '2006-10-29',
            12,
            2,
            '',
            '',
            $oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $rows = $stDsah->execute($aData);
        $aData = array(
            '2006-10-28',
            12,
            2,
            '',
            '',
            $oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $rows = $stDsah->execute($aData);
        $aData = array(
            '2006-10-27',
            12,
            3,
            '',
            '',
            $oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $rows = $stDsah->execute($aData);
        $aData = array(
            '2006-10-26',
            12,
            4,
            '',
            '',
            $oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $rows = $stDsah->execute($aData);
        $oResult = $oDalStatistics->getPlacementFirstStatsDate($placementId);
        $oExpectedDate = new Date('2006-10-27 12:00:00');
        $this->assertEqual($oResult, $oExpectedDate);

        TestEnv::restoreEnv();
    }

    /**
     * A method to test the getChannelDailyInventoryForecastByChannelZoneIds() method.
     *
     * Requirements:
     * Test 1: Test with an invalid channel ID, and ensure null is returned.
     * Test 2: Test with invalid zone IDs arrays, and ensure null is returned.
     * Test 3: Test with invalid period array, and ensure null is returned.
     * Test 4: Test with channel forecasting in config not set, and ensure null is returned.
     * Test 5: Test with channel forecasting in config disabled, and ensure null is returned.
     * Test 6: Test with no data in the database, and ensure null values for forecasts are returned.
     * Test 7: Test a single day where some forecasts exist, and ensure the correct data is returned.
     * Test 8: Test a single day where some forecasts exist, as well as some previous forecasts
     *         not of the same day of the week, and ensure the correct data is returned.
     * Test 9: Test a single day where some forecasts exist, as well as some previous forecasts
     *         of the same day of the week, and ensure the correct data is returned.
     * Test 10: Multi-day test.
     */
    function testGetChannelDailyInventoryForecastByChannelZoneIds()
    {
        $conf = &$GLOBALS['_MAX']['CONF'];
        $oDbh = &OA_DB::singleton();
        $oDalStatistics = new MAX_Dal_Statistics();

        // Test 1
        $channelId = 'foo';
        $aZoneIds = array(1, 2, 3);
        $aPeriod = array(
            'start' => new Date('2006-10-16'),
            'end'   => new Date('2006-10-20')
        );
        $aResult = $oDalStatistics->getChannelDailyInventoryForecastByChannelZoneIds($channelId, $aZoneIds, $aPeriod);
        $this->assertNull($aResult);

        // Test 2
        $channelId = 1;
        $aZoneIds = 'foo';
        $aPeriod = array(
            'start' => new Date('2006-10-16'),
            'end'   => new Date('2006-10-20')
        );
        $aResult = $oDalStatistics->getChannelDailyInventoryForecastByChannelZoneIds($channelId, $aZoneIds, $aPeriod);
        $this->assertNull($aResult);

        $channelId = 1;
        $aZoneIds = array(1, 'foo', 3);
        $aPeriod = array(
            'start' => new Date('2006-10-16'),
            'end'   => new Date('2006-10-20')
        );
        $aResult = $oDalStatistics->getChannelDailyInventoryForecastByChannelZoneIds($channelId, $aZoneIds, $aPeriod);
        $this->assertNull($aResult);

        // Test 3
        $channelId = 1;
        $aZoneIds = array(1, 2, 3);
        $aPeriod = array(
            'foo'   => new Date('2006-10-16'),
            'end'   => new Date('2006-10-20')
        );
        $aResult = $oDalStatistics->getChannelDailyInventoryForecastByChannelZoneIds($channelId, $aZoneIds, $aPeriod);
        $this->assertNull($aResult);

        $channelId = 1;
        $aZoneIds = array(1, 2, 3);
        $aPeriod = array(
            'start' => new Date('2006-10-16'),
            'foo'   => new Date('2006-10-20')
        );
        $aResult = $oDalStatistics->getChannelDailyInventoryForecastByChannelZoneIds($channelId, $aZoneIds, $aPeriod);
        $this->assertNull($aResult);

        $channelId = 1;
        $aZoneIds = array(1, 2, 3);
        $aPeriod = array(
            'start' => 'foo',
            'end'   => new Date('2006-10-20')
        );
        $aResult = $oDalStatistics->getChannelDailyInventoryForecastByChannelZoneIds($channelId, $aZoneIds, $aPeriod);
        $this->assertNull($aResult);

        $channelId = 1;
        $aZoneIds = array(1, 2, 3);
        $aPeriod = array(
            'start' => new Date('2006-10-16'),
            'end'   => 'foo'
        );
        $aResult = $oDalStatistics->getChannelDailyInventoryForecastByChannelZoneIds($channelId, $aZoneIds, $aPeriod);
        $this->assertNull($aResult);

        // Test 4
        $conf['maintenance']['channelForecasting'] = '';
        $channelId = 1;
        $aZoneIds = array(1, 2, 3);
        $aPeriod = array(
            'start' => new Date('2006-10-16'),
            'end'   => new Date('2006-10-20')
        );
        $aResult = $oDalStatistics->getChannelDailyInventoryForecastByChannelZoneIds($channelId, $aZoneIds, $aPeriod);
        $this->assertNull($aResult);

        // Test 5
        $conf['maintenance']['channelForecasting'] = false;
        $channelId = 1;
        $aZoneIds = array(1, 2, 3);
        $aPeriod = array(
            'start' => new Date('2006-10-16'),
            'end'   => new Date('2006-10-20')
        );
        $aResult = $oDalStatistics->getChannelDailyInventoryForecastByChannelZoneIds($channelId, $aZoneIds, $aPeriod);
        $this->assertNull($aResult);

        // Test 6
        $conf['maintenance']['channelForecasting'] = 'true';
        $channelId = 1;
        $aZoneIds = array(1, 2, 3);
        $aPeriod = array(
            'start' => new Date('2006-10-16'),
            'end'   => new Date('2006-10-20')
        );
        $aResult = $oDalStatistics->getChannelDailyInventoryForecastByChannelZoneIds($channelId, $aZoneIds, $aPeriod);
        $aResultShouldBe = array(
            1 => array(
                    '2006-10-16' => null,
                    '2006-10-17' => null,
                    '2006-10-18' => null,
                    '2006-10-19' => null,
                    '2006-10-20' => null
            ),
            2 => array(
                    '2006-10-16' => null,
                    '2006-10-17' => null,
                    '2006-10-18' => null,
                    '2006-10-19' => null,
                    '2006-10-20' => null
            ),
            3 => array(
                    '2006-10-16' => null,
                    '2006-10-17' => null,
                    '2006-10-18' => null,
                    '2006-10-19' => null,
                    '2006-10-20' => null
            )
        );
        $this->assertEqual($aResult, $aResultShouldBe);

        // Test 7:
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_summary_channel_daily']}
                (
                    day,
                    channel_id,
                    zone_id,
                    forecast_impressions
                )
            VALUES
                (?, ?, ?, ?)";
        $aTypes = array(
            'date',
            'integer',
            'integer',
            'integer'
        );
        $st = $oDbh->prepare($query, $aTypes, MDB2_PREPARE_MANIP);
        $aData = array(
            '2006-10-20',
            1,
            1,
            9
        );
        $rows = $st->execute($aData);
        $conf['maintenance']['channelForecasting'] = 'true';
        $channelId = 1;
        $aZoneIds = array(1, 2);
        $aPeriod = array(
            'start' => new Date('2006-10-20'),
            'end'   => new Date('2006-10-20')
        );
        $aResult = $oDalStatistics->getChannelDailyInventoryForecastByChannelZoneIds($channelId, $aZoneIds, $aPeriod);
        $aResultShouldBe = array(
            1 => array(
                    '2006-10-20' => 9
            ),
            2 => array(
                    '2006-10-20' => null
            )
        );
        $this->assertEqual($aResult, $aResultShouldBe);

        // Test 8
        $aData = array(
            '2006-10-14',
            1,
            2,
            999
        );
        $rows = $st->execute($aData);
        $conf['maintenance']['channelForecasting'] = 'true';
        $channelId = 1;
        $aZoneIds = array(1, 2);
        $aPeriod = array(
            'start' => new Date('2006-10-20'),
            'end'   => new Date('2006-10-20')
        );
        $aResult = $oDalStatistics->getChannelDailyInventoryForecastByChannelZoneIds($channelId, $aZoneIds, $aPeriod);
        $aResultShouldBe = array(
            1 => array(
                    '2006-10-20' => 9
            ),
            2 => array(
                    '2006-10-20' => null
            )
        );
        $this->assertEqual($aResult, $aResultShouldBe);

        // Test 9
        $aData = array(
            '2006-10-13',
            1,
            1,
            4999
        );
        $rows = $st->execute($aData);
        $aData = array(
            '2006-10-13',
            1,
            2,
            5999
        );
        $rows = $st->execute($aData);
        $conf['maintenance']['channelForecasting'] = 'true';
        $channelId = 1;
        $aZoneIds = array(1, 2);
        $aPeriod = array(
            'start' => new Date('2006-10-20'),
            'end'   => new Date('2006-10-20')
        );
        $aResult = $oDalStatistics->getChannelDailyInventoryForecastByChannelZoneIds($channelId, $aZoneIds, $aPeriod);
        $aResultShouldBe = array(
            1 => array(
                    '2006-10-20' => 9
            ),
            2 => array(
                    '2006-10-20' => 5999
            )
        );
        $this->assertEqual($aResult, $aResultShouldBe);

        // Test 10
        $aData = array(
            '2006-10-05',
            1,
            1,
            13
        );
        $rows = $st->execute($aData);
        $conf['maintenance']['channelForecasting'] = 'true';
        $channelId = 1;
        $aZoneIds = array(1, 2);
        $aPeriod = array(
            'start' => new Date('2006-10-19'),
            'end'   => new Date('2006-10-21')
        );
        $aResult = $oDalStatistics->getChannelDailyInventoryForecastByChannelZoneIds($channelId, $aZoneIds, $aPeriod);
        $aResultShouldBe = array(
            1 => array(
                    '2006-10-19' => 13,
                    '2006-10-20' => 9,
                    '2006-10-21' => null
            ),
            2 => array(
                    '2006-10-19' => null,
                    '2006-10-20' => 5999,
                    '2006-10-21' => 999
            )
        );
        $this->assertEqual($aResult, $aResultShouldBe);

        TestEnv::restoreEnv();
        TestEnv::restoreConfig();
    }

    /**
     * A method to test the getRecentAverageZoneForecastByZoneIds() method.
     *
     * Requirements:
     * Test 1: Test with invalid zone IDs arrays, and ensure null is returned.
     * Test 2: Test with no channel forecasting types set, and ensure null is returned.
     * Test 3: Test with no data in the database, and ensure null is returned.
     * Test 4: Test with a single value in the database, and ensure the correct average
     *         is returned.
     * Test 5: Test with multiple values in the database, and ensure the correct averages
     *         are returned.
     */
    function testGetRecentAverageZoneForecastByZoneIds()
    {
        $conf = &$GLOBALS['_MAX']['CONF'];
        $oDbh = &OA_DB::singleton();
        $oDalStatistics = new MAX_Dal_Statistics();

        // Test 1
        $aZoneIds = 'foo';
        $aResult = $oDalStatistics->getRecentAverageZoneForecastByZoneIds($aZoneIds);
        $this->assertNull($aResult);

        $aZoneIds = array(1, 'foo', 3);
        $aResult = $oDalStatistics->getRecentAverageZoneForecastByZoneIds($aZoneIds);
        $this->assertNull($aResult);

        // Test 2
        $conf['maintenance']['channelForecasting'] = '';
        $aZoneIds = array(1, 2, 3);
        $aResult = $oDalStatistics->getRecentAverageZoneForecastByZoneIds($aZoneIds);
        $this->assertNull($aResult);

        $conf['maintenance']['channelForecasting'] = 'foo,bar';
        $aZoneIds = array(1, 2, 3);
        $aResult = $oDalStatistics->getRecentAverageZoneForecastByZoneIds($aZoneIds);
        $this->assertNull($aResult);

        TestEnv::restoreConfig();

        // Test 3
        $conf['maintenance']['channelForecasting'] = true;
        $aZoneIds = array(1, 2, 3);
        $aResult = $oDalStatistics->getRecentAverageZoneForecastByZoneIds($aZoneIds);
        $this->assertNull($aResult);

        // Test 4
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_summary_zone_impression_history']}
                (
                    operation_interval,
                    operation_interval_id,
                    interval_start,
                    interval_end,
                    zone_id,
                    forecast_impressions
                )
            VALUES
                (?, ?, ?, ?, ?, ?)";
        $aTypes = array(
            'integer',
            'integer',
            'date',
            'date',
            'integer',
            'integer'
        );
        $st = $oDbh->prepare($query, $aTypes, MDB2_PREPARE_MANIP);
        $aData = array(
            60,
            '',
            '2006-10-24 12:00:00',
            '2006-10-24 12:59:59',
            1,
            500
        );
        $rows = $st->execute($aData);
        $aZoneIds = array(1, 2, 3);
        $aResult = $oDalStatistics->getRecentAverageZoneForecastByZoneIds($aZoneIds);
        $aExpectedResult = array(
            1 => 500
        );
        $this->assertEqual($aResult, $aExpectedResult);
        TestEnv::restoreEnv();

        // Test 5
        $aData = array(
            60,
            '',
            '2006-10-24 12:00:00',
            '2006-10-24 12:59:59',
            1,
            500
        );
        $rows = $st->execute($aData);
        $aData = array(
            60,
            '',
            '2006-10-24 11:00:00',
            '2006-10-24 11:59:59',
            1,
            300
        );
        $rows = $st->execute($aData);
        $aData = array(
            60,
            '',
            '2006-10-24 12:00:00',
            '2006-10-24 12:59:59',
            2,
            500
        );
        $rows = $st->execute($aData);
        $aZoneIds = array(1, 2, 3);
        $aResult = $oDalStatistics->getRecentAverageZoneForecastByZoneIds($aZoneIds);
        $aExpectedResult = array(
            1 => 400,
            2 => 500
        );
        $this->assertEqual($aResult, $aExpectedResult);
        TestEnv::restoreEnv();

        TestEnv::restoreConfig();
    }

}

?>
