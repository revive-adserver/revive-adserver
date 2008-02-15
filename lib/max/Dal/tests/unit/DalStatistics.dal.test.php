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

require_once MAX_PATH . '/lib/max/Dal/Statistics.php';
require_once MAX_PATH . '/lib/max/Dal/tests/util/DalUnitTestCase.php';
require_once MAX_PATH . '/lib/pear/Date.php';


/**
 * A class for testing the non-DB specific MAX_Dal_Statistics DAL class.
 *
 * @package    MaxDal
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew@m3.net>
 */
class Dal_TestOfMAX_Dal_Statistics extends UnitTestCase
{
    var $doBanners = null;
    var $doDSAH = null;
    var $doDSZIH = null;
    //var $doDSCD = null;

    /**
     * The constructor method.
     */
    /**
     * The constructor method.
     */
    function Dal_TestOfMAX_Dal_Statistics()
    {
        $this->UnitTestCase();
        $this->doBanners   = OA_Dal::factoryDO('banners');
        $this->doDSAH = OA_Dal::factoryDO('data_summary_ad_hourly');
        $this->doDSZIH = OA_Dal::factoryDO('data_summary_zone_impression_history');
        //$this->doDSCD = OA_Dal::factoryDO('data_summary_channel_daily');
    }

    function _insertBanner($aData)
    {
        $this->doBanners->storagetype = 'sql';
        foreach ($aData AS $key => $val)
        {
            $this->doBanners->$key = $val;
        }
        return DataGenerator::generateOne($this->doBanners);
    }

    function _insertDataSummaryAdHourly($aData)
    {
        $aData['date_time'] = sprintf('%s %02d:00:00', $aData['day'], $aData['hour']);
        unset($aData['day']);
        unset($aData['hour']);

        foreach ($aData AS $key => $val)
        {
            $this->doDSAH->$key = $val;
        }
        return DataGenerator::generateOne($this->doDSAH);
    }

// THIS DOES NOT HAVE A DATAOBJECT AND MAY BE DEPRECATED
//    function _insertDataSummaryChannelDaily($aData)
//    {
//        foreach ($aData AS $key => $val)
//        {
//            $this->doDSCD->$key = $val;
//        }
//        return DataGenerator::generateOne($this->doDSCD);
//    }

    function _insertDataSummaryZoneImpressionHistory($aData)
    {
        foreach ($aData AS $key => $val)
        {
            $this->doDSZIH->$key = $val;
        }
        return DataGenerator::generateOne($this->doDSZIH);
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
        $conf =& $GLOBALS['_MAX']['CONF'];
        $oDbh =& OA_DB::singleton();
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

        $aData = array(
            'campaignid'=>$placementId,
            'active'=>'t',
            'updated'=>$oNow->format('%Y-%m-%d %H:%M:%S'),
            'acls_updated'=>$oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idBanner1 = $this->_insertBanner($aData);
        $aData = array(
            'day'=>'2006-10-30',
            'hour'=>12,
            'ad_id'=>$idBanner1,
            'updated'=>$oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idDSAH1 = $this->_insertDataSummaryAdHourly($aData);

        $oResult = $oDalStatistics->getPlacementFirstStatsDate($placementId);
        $oExpectedDate = new Date('2006-10-30 12:00:00');
        $this->assertEqual($oResult, $oExpectedDate);

        // Test 4
        $aData = array(
            'campaignid'=>$placementId,
            'active'=>'t',
            'updated'=>$oNow->format('%Y-%m-%d %H:%M:%S'),
            'acls_updated'=>$oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idBanner2 = $this->_insertBanner($aData);
        $aData = array(
            'campaignid'=>999,
            'active'=>'t',
            'updated'=>$oNow->format('%Y-%m-%d %H:%M:%S'),
            'acls_updated'=>$oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idBanner3 = $this->_insertBanner($aData);
        $aData = array(
            'day'=>'2006-10-29',
            'hour'=>12,
            'ad_id'=>$idBanner2,
            'updated'=>$oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idDSAH1 = $this->_insertDataSummaryAdHourly($aData);
        $aData = array(
            'day'=>'2006-10-28',
            'hour'=>12,
            'ad_id'=>$idBanner2,
            'updated'=>$oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idDSAH2 = $this->_insertDataSummaryAdHourly($aData);
        $aData = array(
            'day'=>'2006-10-27',
            'hour'=>12,
            'ad_id'=>$idBanner2,
            'updated'=>$oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idDSAH3 = $this->_insertDataSummaryAdHourly($aData);
        $aData = array(
            'day'=>'2006-10-26',
            'hour'=>12,
            'ad_id'=>999,
            'updated'=>$oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $idDSAH4 = $this->_insertDataSummaryAdHourly($aData);

        $oResult = $oDalStatistics->getPlacementFirstStatsDate($placementId);
        $oExpectedDate = new Date('2006-10-27 12:00:00');
        $this->assertEqual($oResult, $oExpectedDate);

        DataGenerator::cleanUp();
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
        $conf =& $GLOBALS['_MAX']['CONF'];
        $oDbh =& OA_DB::singleton();
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
        $aData = array(
            'operation_interval'=>60,
            'operation_interval_id'=>'',
            'interval_start'=>'2006-10-24 12:00:00',
            'interval_end'=>'2006-10-24 12:59:59',
            'zone_id'=>1,
            'forecast_impressions'=>500
        );
        $idDSZIH1 = $this->_insertDataSummaryZoneImpressionHistory($aData);
        $aZoneIds = array(1, 2, 3);
        $aResult = $oDalStatistics->getRecentAverageZoneForecastByZoneIds($aZoneIds);
        $aExpectedResult = array(
            1 => 500
        );
        $this->assertEqual($aResult, $aExpectedResult);
        DataGenerator::cleanUp();

        // Test 5
        $aData = array(
            'operation_interval'=>60,
            'operation_interval_id'=>'',
            'interval_start'=>'2006-10-24 12:00:00',
            'interval_end'=>'2006-10-24 12:59:59',
            'zone_id'=>1,
            'forecast_impressions'=>500
        );
        $idDSZIH2 = $this->_insertDataSummaryZoneImpressionHistory($aData);
        $aData = array(
            'operation_interval'=>60,
            'operation_interval_id'=>'',
            'interval_start'=>'2006-10-24 11:00:00',
            'interval_end'=>'2006-10-24 11:59:59',
            'zone_id'=>1,
            'forecast_impressions'=>300
        );
        $idDSZIH3 = $this->_insertDataSummaryZoneImpressionHistory($aData);
        $aData = array(
            'operation_interval'=>60,
            'operation_interval_id'=>'',
            'interval_start'=>'2006-10-24 12:00:00',
            'interval_end'=>'2006-10-24 12:59:59',
            'zone_id'=>2,
            'forecast_impressions'=>500
        );
        $idDSZIH4 = $this->_insertDataSummaryZoneImpressionHistory($aData);
        $aZoneIds = array(1, 2, 3);
        $aResult = $oDalStatistics->getRecentAverageZoneForecastByZoneIds($aZoneIds);
        $aExpectedResult = array(
            1 => 400,
            2 => 500
        );
        $this->assertEqual($aResult, $aExpectedResult);
        DataGenerator::cleanUp();

        TestEnv::restoreConfig();
    }

// THIS DOES NOT HAVE A DATAOBJECT AND MAY BE DEPRECATED
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
/*    function testGetChannelDailyInventoryForecastByChannelZoneIds()
    {
        $conf =& $GLOBALS['_MAX']['CONF'];
        $oDbh =& OA_DB::singleton();
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
        $aData = array(
            'day'=>'2006-10-20',
            'channel_id'=>1,
            'zone_id'=>1,
            'forecast_impressions'=>9
        );
        $idDACD1 = $this->_insertDataSummaryChannelDaily($aData);
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
            'day'=>'2006-10-14',
            'channel_id'=>1,
            'zone_id'=>2,
            'forecast_impressions'=>999
        );
        $idDACD2 = $this->_insertDataSummaryChannelDaily($aData);
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
            'day'=>'2006-10-13',
            'channel_id'=>1,
            'zone_id'=>1,
            'forecast_impressions'=>4999
        );
        $idDACD1 = $this->_insertDataSummaryChannelDaily($aData);
        $aData = array(
            'day'=>'2006-10-13',
            'channel_id'=>1,
            'zone_id'=>2,
            'forecast_impressions'=>5999
        );
        $rows = $st->execute($aData);
        $idDACD2 = $this->_insertDataSummaryChannelDaily($aData);
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
            'day'=>'2006-10-05',
            'channel_id'=>1,
            'zone_id'=>1,
            'forecast_impressions'=>13
        );
        $idDACD1 = $this->_insertDataSummaryChannelDaily($aData);
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
        DataGenerator::cleanUp();
        TestEnv::restoreConfig();
    }
*/

}

?>
