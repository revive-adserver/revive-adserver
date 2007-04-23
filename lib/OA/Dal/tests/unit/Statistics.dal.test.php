<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2007 Openads Ltd                                       |
| For contact details, see: http://www.openads.org/                         |
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

require_once MAX_PATH . '/lib/max/tests/util/DataGenerator.php';

require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/lib/OA/Dal/Statistics.php';
require_once 'Date.php';

/**
 * A class for testing the non-DB specific OA_Dal_Statistics class.
 *
 * @package    OpenadsDal
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew.hill@openads.org>
 */
class Test_OA_Dal_Statistics extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function Test_OA_Dal_Statistics()
    {
        $this->UnitTestCase();
    }

    /**
     * Test for the getPlacementOverviewTargetingStatistics() method.
     */
    function testGetPlacementOverviewTargetingStatistics()
    {
        TestEnv::restoreEnv();
    }

    /**
     * Test for the getPlacementDailyTargetingStatistics() method.
     *
     * Requirements:
     * Test 1: Test the method correctly identifies bad input
     * Test 2: Test with no ads in the placement
     * Test 3: Test with one ad in the placement, no data
     */
    function testGetPlacementDailyTargetingStatistics()
    {
        $aConf =& $GLOBALS['_MAX']['CONF'];
        $aConf['maintenance']['operationInterval'] = 60;

        $oDal = new OA_Dal_Statistics();

        $dg = new DataGenerator();

        // Test 1: Test the method correctly identifies bad input
        $validPlacementId = 1;
        $oValidDate = new Date('2007-04-20 12:00:00');

        $result = $oDal->getPlacementDailyTargetingStatistics(null, $oValidDate);
        $this->assertFalse($result);

        $result = $oDal->getPlacementDailyTargetingStatistics($validPlacementId, null);
        $this->assertFalse($result);

        // Test 2: Test with no ads in the placement
        $result = $oDal->getPlacementDailyTargetingStatistics($validPlacementId, $oValidDate);
        $this->assertFalse($result);

        // Test 3: Test with one ad in the placement, no data
        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->bannerid = 1;
        $doBanners->campaignid = 1;
        $aRows = $dg->generate($doBanners, 1);

        $aResult = $oDal->getPlacementDailyTargetingStatistics($validPlacementId, $oValidDate);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 24);
        $counter = 0;
        for ($intervalId = 120; $intervalId < 144; $intervalId++) {
            $oDate = new Date('2007-04-20');
            $oDate->setHour($counter);
            $oDate->setMinute(0);
            $oDate->setSecond(0);
            $this->assertEqual($aResult[$intervalId]['interval_start'], $oDate);
            $oDate = new Date('2007-04-20');
            $oDate->setHour($counter);
            $oDate->setMinute(59);
            $oDate->setSecond(59);
            $this->assertEqual($aResult[$intervalId]['interval_end'], $oDate);
            $this->assertEqual($aResult[$intervalId]['placement_required_impressions'], 0);
            $this->assertEqual($aResult[$intervalId]['placement_requested_impressions'], 0);
            $this->assertEqual($aResult[$intervalId]['placement_actual_impressions'], 0);
            $this->assertEqual($aResult[$intervalId]['zones_forecast_impressions'], 0);
            $this->assertEqual($aResult[$intervalId]['zones_actual_impression'], 0);
            $counter++;
        }

//        More tests!

        TestEnv::restoreEnv();
    }

    /**
     * Test for the getAdTargetingStatistics() method.
     *
     * Requirements:
     * Test 1: Test the method correctly identifies bad input
     * Test 2: Test with no data in the database
     * Test 3: Test with partial data in the wrong OI
     * Test 4: Test with partial data in the right OI
     * Test 5: Test with dual partial data in the right OI, check average values
     * Test 6: Test as for Test 5, but now with ad impressions in the wrong OI
     * Test 7: Test as for Test 5, but now with ad impressions in the right OI
     * Test 8: Test as for Test 7, but now with zone data in the wrong OI
     * Test 9: Test as for Test 7, but now with zone data in the right OI
     */
    function testGetAdTargetingStatistics()
    {
        $aConf =& $GLOBALS['_MAX']['CONF'];
        $aConf['maintenance']['operationInterval'] = 60;

        $oDal = new OA_Dal_Statistics();

        $dg = new DataGenerator();

        // Test 1: Test the method correctly identifies bad input
        $validAdId = 1;
        $oValidStartDate = new Date('2007-04-20 12:00:00');
        $oValidEndDate   = new Date('2007-04-20 12:59:59');
        $oInvalidEndDate = new Date('2007-04-20 12:59:58');

        $result = $oDal->getAdTargetingStatistics(null, $oValidStartDate, $oValidEndDate);
        $this->assertFalse($result);

        $result = $oDal->getAdTargetingStatistics($validAdId, null, $oValidEndDate);
        $this->assertFalse($result);

        $result = $oDal->getAdTargetingStatistics($validAdId, $oValidStartDate, null);
        $this->assertFalse($result);

        $result = $oDal->getAdTargetingStatistics($validAdId, $oValidStartDate, $oInvalidEndDate);
        $this->assertFalse($result);

        // Test 2: Test with no data in the database
        $aResult = $oDal->getAdTargetingStatistics($validAdId, $oValidStartDate, $oValidEndDate);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 0);

        // Test 3: Test with partial data in the wrong OI
        $doDataSummaryAdZoneAssoc = OA_Dal::factoryDO('data_summary_ad_zone_assoc');
        $doDataSummaryAdZoneAssoc->operation_interval         = 60;
        $doDataSummaryAdZoneAssoc->interval_start             = '2007-04-20 11:00:00';
        $doDataSummaryAdZoneAssoc->interval_end               = '2007-04-20 11:59:59';
        $doDataSummaryAdZoneAssoc->ad_id                      = 1;
        $doDataSummaryAdZoneAssoc->zone_id                    = 1;
        $doDataSummaryAdZoneAssoc->required_impressions       = 5432;
        $doDataSummaryAdZoneAssoc->requested_impressions      = 5432;
        $doDataSummaryAdZoneAssoc->priority                   = 0.1;
        $doDataSummaryAdZoneAssoc->priority_factor            = 1;
        $doDataSummaryAdZoneAssoc->priority_factor_limited    = 0;
        $doDataSummaryAdZoneAssoc->past_zone_traffic_fraction = 0.1;
        $aRowIds = $dg->generate($doDataSummaryAdZoneAssoc, 1);

        $aResult = $oDal->getAdTargetingStatistics($validAdId, $oValidStartDate, $oValidEndDate);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 0);

        // Test 4: Test with partial data in the right OI
        $doDataSummaryAdZoneAssoc = OA_Dal::factoryDO('data_summary_ad_zone_assoc');
        $doDataSummaryAdZoneAssoc->operation_interval         = 60;
        $doDataSummaryAdZoneAssoc->interval_start             = '2007-04-20 12:00:00';
        $doDataSummaryAdZoneAssoc->interval_end               = '2007-04-20 12:59:59';
        $doDataSummaryAdZoneAssoc->ad_id                      = 1;
        $doDataSummaryAdZoneAssoc->zone_id                    = 1;
        $doDataSummaryAdZoneAssoc->required_impressions       = 5432;
        $doDataSummaryAdZoneAssoc->requested_impressions      = 5432;
        $doDataSummaryAdZoneAssoc->priority                   = 0.1;
        $doDataSummaryAdZoneAssoc->priority_factor            = 1;
        $doDataSummaryAdZoneAssoc->priority_factor_limited    = 0;
        $doDataSummaryAdZoneAssoc->past_zone_traffic_fraction = 0.1;
        $aRowIds = $dg->generate($doDataSummaryAdZoneAssoc, 1);

        $aResult = $oDal->getAdTargetingStatistics($validAdId, $oValidStartDate, $oValidEndDate);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 1);
        $this->assertTrue(is_array($aResult[1]));
        $this->assertEqual(count($aResult[1]), 11);
        $oDate = new Date('2007-04-20 12:00:00');
        $this->assertEqual($aResult[1]['interval_start'], $oDate);
        $oDate = new Date('2007-04-20 12:59:59');
        $this->assertEqual($aResult[1]['interval_end'], $oDate);
        $this->assertEqual($aResult[1]['ad_required_impressions'], 5432);
        $this->assertEqual($aResult[1]['ad_requested_impressions'], 5432);
        $this->assertEqual((string) $aResult[1]['ad_priority'], (string) 0.1);
        $this->assertEqual($aResult[1]['ad_priority_factor'], 1);
        $this->assertEqual($aResult[1]['ad_priority_factor_limited'], 0);
        $this->assertEqual((string) $aResult[1]['ad_past_zone_traffic_fraction'], (string) 0.1);
        $this->assertNull($aResult[1]['ad_actual_impressions']);
        $this->assertNull($aResult[1]['zone_forecast_impressions']);
        $this->assertNull($aResult[1]['zone_actual_impression']);

        TestEnv::restoreEnv();

        // Test 5: Test with dual partial data in the right OI, check average values
        $doDataSummaryAdZoneAssoc = OA_Dal::factoryDO('data_summary_ad_zone_assoc');
        $doDataSummaryAdZoneAssoc->operation_interval         = 60;
        $doDataSummaryAdZoneAssoc->interval_start             = '2007-04-20 12:00:00';
        $doDataSummaryAdZoneAssoc->interval_end               = '2007-04-20 12:59:59';
        $doDataSummaryAdZoneAssoc->ad_id                      = 1;
        $doDataSummaryAdZoneAssoc->zone_id                    = 1;
        $doDataSummaryAdZoneAssoc->required_impressions       = 5432;
        $doDataSummaryAdZoneAssoc->requested_impressions      = 5432;
        $doDataSummaryAdZoneAssoc->priority                   = 0.1;
        $doDataSummaryAdZoneAssoc->priority_factor            = 1;
        $doDataSummaryAdZoneAssoc->priority_factor_limited    = 0;
        $doDataSummaryAdZoneAssoc->past_zone_traffic_fraction = 0.1;
        $doDataSummaryAdZoneAssoc->created                    = '2007-04-20 12:00:00';
        $doDataSummaryAdZoneAssoc->expired                    = '2007-04-20 12:29:59';
        $aRowIds = $dg->generate($doDataSummaryAdZoneAssoc, 1);

        $doDataSummaryAdZoneAssoc = OA_Dal::factoryDO('data_summary_ad_zone_assoc');
        $doDataSummaryAdZoneAssoc->operation_interval         = 60;
        $doDataSummaryAdZoneAssoc->interval_start             = '2007-04-20 12:00:00';
        $doDataSummaryAdZoneAssoc->interval_end               = '2007-04-20 12:59:59';
        $doDataSummaryAdZoneAssoc->ad_id                      = 1;
        $doDataSummaryAdZoneAssoc->zone_id                    = 1;
        $doDataSummaryAdZoneAssoc->required_impressions       = 432;
        $doDataSummaryAdZoneAssoc->requested_impressions      = 432;
        $doDataSummaryAdZoneAssoc->priority                   = 0.3;
        $doDataSummaryAdZoneAssoc->priority_factor            = 3;
        $doDataSummaryAdZoneAssoc->priority_factor_limited    = 1;
        $doDataSummaryAdZoneAssoc->past_zone_traffic_fraction = 0.7;
        $doDataSummaryAdZoneAssoc->created                    = '2007-04-20 12:30:00';
        $doDataSummaryAdZoneAssoc->expired                    = '2007-04-20 12:59:59';
        $aRowIds = $dg->generate($doDataSummaryAdZoneAssoc, 1);

        $aResult = $oDal->getAdTargetingStatistics($validAdId, $oValidStartDate, $oValidEndDate);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 1);
        $this->assertTrue(is_array($aResult[1]));
        $this->assertEqual(count($aResult[1]), 11);
        $oDate = new Date('2007-04-20 12:00:00');
        $this->assertEqual($aResult[1]['interval_start'], $oDate);
        $oDate = new Date('2007-04-20 12:59:59');
        $this->assertEqual($aResult[1]['interval_end'], $oDate);
        $this->assertEqual($aResult[1]['ad_required_impressions'], 2932);
        $this->assertEqual($aResult[1]['ad_requested_impressions'], 2932);
        $this->assertEqual((string) $aResult[1]['ad_priority'], (string) 0.2);
        $this->assertEqual($aResult[1]['ad_priority_factor'], 2);
        $this->assertEqual($aResult[1]['ad_priority_factor_limited'], 1);
        $this->assertEqual((string) $aResult[1]['ad_past_zone_traffic_fraction'], (string) 0.4);
        $this->assertNull($aResult[1]['ad_actual_impressions']);
        $this->assertNull($aResult[1]['zone_forecast_impressions']);
        $this->assertNull($aResult[1]['zone_actual_impression']);

        // Test 6: Test as for Test 5, but now with ad impressions in the wrong OI
        $doDataIntermediateAd = OA_Dal::factoryDO('data_intermediate_ad');
        $doDataIntermediateAd->day                = '2006-04-20';
        $doDataIntermediateAd->hour               = 11;
        $doDataIntermediateAd->operation_interval = 60;
        $doDataIntermediateAd->interval_start     = '2007-04-20 11:00:00';
        $doDataIntermediateAd->interval_end       = '2007-04-20 11:59:59';
        $doDataIntermediateAd->ad_id              = 1;
        $doDataIntermediateAd->creative_id        = 0;
        $doDataIntermediateAd->zone_id            = 1;
        $doDataIntermediateAd->impressions        = 100;
        $aRowIds = $dg->generate($doDataIntermediateAd, 1);

        $aResult = $oDal->getAdTargetingStatistics($validAdId, $oValidStartDate, $oValidEndDate);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 1);
        $this->assertTrue(is_array($aResult[1]));
        $this->assertEqual(count($aResult[1]), 11);
        $oDate = new Date('2007-04-20 12:00:00');
        $this->assertEqual($aResult[1]['interval_start'], $oDate);
        $oDate = new Date('2007-04-20 12:59:59');
        $this->assertEqual($aResult[1]['interval_end'], $oDate);
        $this->assertEqual($aResult[1]['ad_required_impressions'], 2932);
        $this->assertEqual($aResult[1]['ad_requested_impressions'], 2932);
        $this->assertEqual((string) $aResult[1]['ad_priority'], (string) 0.2);
        $this->assertEqual($aResult[1]['ad_priority_factor'], 2);
        $this->assertEqual($aResult[1]['ad_priority_factor_limited'], 1);
        $this->assertEqual((string) $aResult[1]['ad_past_zone_traffic_fraction'], (string) 0.4);
        $this->assertNull($aResult[1]['ad_actual_impressions']);
        $this->assertNull($aResult[1]['zone_forecast_impressions']);
        $this->assertNull($aResult[1]['zone_actual_impression']);

        // Test 7: Test as for Test 5, but now with ad impressions in the right OI
        $doDataIntermediateAd = OA_Dal::factoryDO('data_intermediate_ad');
        $doDataIntermediateAd->day                = '2006-04-20';
        $doDataIntermediateAd->hour               = 11;
        $doDataIntermediateAd->operation_interval = 60;
        $doDataIntermediateAd->interval_start     = '2007-04-20 12:00:00';
        $doDataIntermediateAd->interval_end       = '2007-04-20 12:59:59';
        $doDataIntermediateAd->ad_id              = 1;
        $doDataIntermediateAd->creative_id        = 0;
        $doDataIntermediateAd->zone_id            = 1;
        $doDataIntermediateAd->impressions        = 150;
        $aRowIds = $dg->generate($doDataIntermediateAd, 1);

        $aResult = $oDal->getAdTargetingStatistics($validAdId, $oValidStartDate, $oValidEndDate);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 1);
        $this->assertTrue(is_array($aResult[1]));
        $this->assertEqual(count($aResult[1]), 11);
        $oDate = new Date('2007-04-20 12:00:00');
        $this->assertEqual($aResult[1]['interval_start'], $oDate);
        $oDate = new Date('2007-04-20 12:59:59');
        $this->assertEqual($aResult[1]['interval_end'], $oDate);
        $this->assertEqual($aResult[1]['ad_required_impressions'], 2932);
        $this->assertEqual($aResult[1]['ad_requested_impressions'], 2932);
        $this->assertEqual((string) $aResult[1]['ad_priority'], (string) 0.2);
        $this->assertEqual($aResult[1]['ad_priority_factor'], 2);
        $this->assertEqual($aResult[1]['ad_priority_factor_limited'], 1);
        $this->assertEqual((string) $aResult[1]['ad_past_zone_traffic_fraction'], (string) 0.4);
        $this->assertEqual($aResult[1]['ad_actual_impressions'], 150);
        $this->assertNull($aResult[1]['zone_forecast_impressions']);
        $this->assertNull($aResult[1]['zone_actual_impression']);

        // Test 8: Test as for Test 7, but now with zone data in the wrong OI
//        $doDataSummaryZoneImpressionHistory = OA_Dal::factoryDO('data_summary_zone_impression_history');
//        $doDataSummaryZoneImpressionHistory->operation_interval   = 60;
//        $doDataSummaryZoneImpressionHistory->interval_start       = '2007-04-20 11:00:00';
//        $doDataSummaryZoneImpressionHistory->interval_end         = '2007-04-20 11:59:59';
//        $doDataSummaryZoneImpressionHistory->zone_id              = 1;
//        $doDataSummaryZoneImpressionHistory->forecast_impressions = 222;
//        $doDataSummaryZoneImpressionHistory->actual_impressions   = 333;
//        $aRowIds = $dg->generate($doDataSummaryZoneImpressionHistory, 1);
//
//        $aResult = $oDal->getAdTargetingStatistics($validAdId, $oValidStartDate, $oValidEndDate);
//        $this->assertTrue(is_array($aResult));
//        $this->assertEqual(count($aResult), 1);
//        $this->assertTrue(is_array($aResult[1]));
//        $this->assertEqual(count($aResult[1]), 11);
//        $oDate = new Date('2007-04-20 12:00:00');
//        $this->assertEqual($aResult[1]['interval_start'], $oDate);
//        $oDate = new Date('2007-04-20 12:59:59');
//        $this->assertEqual($aResult[1]['interval_end'], $oDate);
//        $this->assertEqual($aResult[1]['ad_required_impressions'], 2932);
//        $this->assertEqual($aResult[1]['ad_requested_impressions'], 2932);
//        $this->assertEqual((string) $aResult[1]['ad_priority'], (string) 0.2);
//        $this->assertEqual($aResult[1]['ad_priority_factor'], 2);
//        $this->assertEqual($aResult[1]['ad_priority_factor_limited'], 1);
//        $this->assertEqual((string) $aResult[1]['ad_past_zone_traffic_fraction'], (string) 0.4);
//        $this->assertEqual($aResult[1]['ad_actual_impressions'], 150);
//        $this->assertNull($aResult[1]['zone_forecast_impressions']);
//        $this->assertNull($aResult[1]['zone_actual_impression']);

        // Test 9: Test as for Test 7, but now with zone data in the wrong OI
//        $doDataSummaryZoneImpressionHistory = OA_Dal::factoryDO('data_summary_zone_impression_history');
//        $doDataSummaryZoneImpressionHistory->operation_interval   = 60;
//        $doDataSummaryZoneImpressionHistory->interval_start       = '2007-04-20 12:00:00';
//        $doDataSummaryZoneImpressionHistory->interval_end         = '2007-04-20 12:59:59';
//        $doDataSummaryZoneImpressionHistory->zone_id              = 1;
//        $doDataSummaryZoneImpressionHistory->forecast_impressions = 444;
//        $doDataSummaryZoneImpressionHistory->actual_impressions   = 555;
//        $aRowIds = $dg->generate($doDataSummaryZoneImpressionHistory, 1);
//
//        $aResult = $oDal->getAdTargetingStatistics($validAdId, $oValidStartDate, $oValidEndDate);
//        $this->assertTrue(is_array($aResult));
//        $this->assertEqual(count($aResult), 1);
//        $this->assertTrue(is_array($aResult[1]));
//        $this->assertEqual(count($aResult[1]), 11);
//        $oDate = new Date('2007-04-20 12:00:00');
//        $this->assertEqual($aResult[1]['interval_start'], $oDate);
//        $oDate = new Date('2007-04-20 12:59:59');
//        $this->assertEqual($aResult[1]['interval_end'], $oDate);
//        $this->assertEqual($aResult[1]['ad_required_impressions'], 2932);
//        $this->assertEqual($aResult[1]['ad_requested_impressions'], 2932);
//        $this->assertEqual((string) $aResult[1]['ad_priority'], (string) 0.2);
//        $this->assertEqual($aResult[1]['ad_priority_factor'], 2);
//        $this->assertEqual($aResult[1]['ad_priority_factor_limited'], 1);
//        $this->assertEqual((string) $aResult[1]['ad_past_zone_traffic_fraction'], (string) 0.4);
//        $this->assertEqual($aResult[1]['ad_actual_impressions'], 150);
//        $this->assertEqual($aResult[1]['zone_forecast_impressions'], 444);
//        $this->assertEqual($aResult[1]['zone_actual_impression'], 555);

        TestEnv::restoreEnv();
    }

    /**
     * Test for the getZoneTargetingStatistics() method.
     *
     * Requirements:
     * Test 1: Test the method correctly identifies bad input
     * Test 2: Test with no data in the database
     * Test 3: Test with partial data in the wrong OI
     * Test 4: Test with partial data in the right OI
     * Test 5: Test with dual partial data in the right OI, check average values
     * Test 6: Test as for Test 5, but now with ad impressions in the wrong OI
     * Test 7: Test as for Test 5, but now with ad impressions in the right OI
     * Test 8: Test as for Test 7, but now with zone data in the wrong OI
     * Test 9: Test as for Test 7, but now with zone data in the right OI
     */
    function testGetZoneTargetingStatistics()
    {
        $aConf =& $GLOBALS['_MAX']['CONF'];
        $aConf['maintenance']['operationInterval'] = 60;

        $oDal = new OA_Dal_Statistics();

        $dg = new DataGenerator();

        // Test 1: Test the method correctly identifies bad input
        $validZoneId = 1;
        $oValidStartDate = new Date('2007-04-20 12:00:00');
        $oValidEndDate   = new Date('2007-04-20 12:59:59');
        $oInvalidEndDate = new Date('2007-04-20 12:59:58');

        $result = $oDal->getZoneTargetingStatistics(null, $oValidStartDate, $oValidEndDate);
        $this->assertFalse($result);

        $result = $oDal->getZoneTargetingStatistics($validZoneId, null, $oValidEndDate);
        $this->assertFalse($result);

        $result = $oDal->getZoneTargetingStatistics($validZoneId, $oValidStartDate, null);
        $this->assertFalse($result);

        $result = $oDal->getZoneTargetingStatistics($validZoneId, $oValidStartDate, $oInvalidEndDate);
        $this->assertFalse($result);

        // Test 2: Test with no data in the database
        $aResult = $oDal->getZoneTargetingStatistics($validZoneId, $oValidStartDate, $oValidEndDate);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 0);

        // Test 3: Test with partial data in the wrong OI
        $doDataSummaryAdZoneAssoc = OA_Dal::factoryDO('data_summary_ad_zone_assoc');
        $doDataSummaryAdZoneAssoc->operation_interval         = 60;
        $doDataSummaryAdZoneAssoc->interval_start             = '2007-04-20 11:00:00';
        $doDataSummaryAdZoneAssoc->interval_end               = '2007-04-20 11:59:59';
        $doDataSummaryAdZoneAssoc->ad_id                      = 1;
        $doDataSummaryAdZoneAssoc->zone_id                    = 1;
        $doDataSummaryAdZoneAssoc->required_impressions       = 5432;
        $doDataSummaryAdZoneAssoc->requested_impressions      = 5432;
        $doDataSummaryAdZoneAssoc->priority                   = 0.1;
        $doDataSummaryAdZoneAssoc->priority_factor            = 1;
        $doDataSummaryAdZoneAssoc->priority_factor_limited    = 0;
        $doDataSummaryAdZoneAssoc->past_zone_traffic_fraction = 0.1;
        $aRowIds = $dg->generate($doDataSummaryAdZoneAssoc, 1);

        $aResult = $oDal->getZoneTargetingStatistics($validZoneId, $oValidStartDate, $oValidEndDate);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 0);

        // Test 4: Test with partial data in the right OI
        $doDataSummaryAdZoneAssoc = OA_Dal::factoryDO('data_summary_ad_zone_assoc');
        $doDataSummaryAdZoneAssoc->operation_interval         = 60;
        $doDataSummaryAdZoneAssoc->interval_start             = '2007-04-20 12:00:00';
        $doDataSummaryAdZoneAssoc->interval_end               = '2007-04-20 12:59:59';
        $doDataSummaryAdZoneAssoc->ad_id                      = 1;
        $doDataSummaryAdZoneAssoc->zone_id                    = 1;
        $doDataSummaryAdZoneAssoc->required_impressions       = 5432;
        $doDataSummaryAdZoneAssoc->requested_impressions      = 5432;
        $doDataSummaryAdZoneAssoc->priority                   = 0.1;
        $doDataSummaryAdZoneAssoc->priority_factor            = 1;
        $doDataSummaryAdZoneAssoc->priority_factor_limited    = 0;
        $doDataSummaryAdZoneAssoc->past_zone_traffic_fraction = 0.1;
        $aRowIds = $dg->generate($doDataSummaryAdZoneAssoc, 1);

        $aResult = $oDal->getZoneTargetingStatistics($validZoneId, $oValidStartDate, $oValidEndDate);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 1);
        $this->assertTrue(is_array($aResult[1]));
        $this->assertEqual(count($aResult[1]), 11);
        $oDate = new Date('2007-04-20 12:00:00');
        $this->assertEqual($aResult[1]['interval_start'], $oDate);
        $oDate = new Date('2007-04-20 12:59:59');
        $this->assertEqual($aResult[1]['interval_end'], $oDate);
        $this->assertEqual($aResult[1]['ad_required_impressions'], 5432);
        $this->assertEqual($aResult[1]['ad_requested_impressions'], 5432);
        $this->assertEqual((string) $aResult[1]['ad_priority'], (string) 0.1);
        $this->assertEqual($aResult[1]['ad_priority_factor'], 1);
        $this->assertEqual($aResult[1]['ad_priority_factor_limited'], 0);
        $this->assertEqual((string) $aResult[1]['ad_past_zone_traffic_fraction'], (string) 0.1);
        $this->assertNull($aResult[1]['ad_actual_impressions']);
        $this->assertNull($aResult[1]['zone_forecast_impressions']);
        $this->assertNull($aResult[1]['zone_actual_impression']);

        TestEnv::restoreEnv();

        // Test 5: Test with dual partial data in the right OI, check average values
        $doDataSummaryAdZoneAssoc = OA_Dal::factoryDO('data_summary_ad_zone_assoc');
        $doDataSummaryAdZoneAssoc->operation_interval         = 60;
        $doDataSummaryAdZoneAssoc->interval_start             = '2007-04-20 12:00:00';
        $doDataSummaryAdZoneAssoc->interval_end               = '2007-04-20 12:59:59';
        $doDataSummaryAdZoneAssoc->ad_id                      = 1;
        $doDataSummaryAdZoneAssoc->zone_id                    = 1;
        $doDataSummaryAdZoneAssoc->required_impressions       = 5432;
        $doDataSummaryAdZoneAssoc->requested_impressions      = 5432;
        $doDataSummaryAdZoneAssoc->priority                   = 0.1;
        $doDataSummaryAdZoneAssoc->priority_factor            = 1;
        $doDataSummaryAdZoneAssoc->priority_factor_limited    = 0;
        $doDataSummaryAdZoneAssoc->past_zone_traffic_fraction = 0.1;
        $doDataSummaryAdZoneAssoc->created                    = '2007-04-20 12:00:00';
        $doDataSummaryAdZoneAssoc->expired                    = '2007-04-20 12:29:59';
        $aRowIds = $dg->generate($doDataSummaryAdZoneAssoc, 1);

        $doDataSummaryAdZoneAssoc = OA_Dal::factoryDO('data_summary_ad_zone_assoc');
        $doDataSummaryAdZoneAssoc->operation_interval         = 60;
        $doDataSummaryAdZoneAssoc->interval_start             = '2007-04-20 12:00:00';
        $doDataSummaryAdZoneAssoc->interval_end               = '2007-04-20 12:59:59';
        $doDataSummaryAdZoneAssoc->ad_id                      = 1;
        $doDataSummaryAdZoneAssoc->zone_id                    = 1;
        $doDataSummaryAdZoneAssoc->required_impressions       = 432;
        $doDataSummaryAdZoneAssoc->requested_impressions      = 432;
        $doDataSummaryAdZoneAssoc->priority                   = 0.3;
        $doDataSummaryAdZoneAssoc->priority_factor            = 3;
        $doDataSummaryAdZoneAssoc->priority_factor_limited    = 1;
        $doDataSummaryAdZoneAssoc->past_zone_traffic_fraction = 0.7;
        $doDataSummaryAdZoneAssoc->created                    = '2007-04-20 12:30:00';
        $doDataSummaryAdZoneAssoc->expired                    = '2007-04-20 12:59:59';
        $aRowIds = $dg->generate($doDataSummaryAdZoneAssoc, 1);

        $aResult = $oDal->getZoneTargetingStatistics($validZoneId, $oValidStartDate, $oValidEndDate);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 1);
        $this->assertTrue(is_array($aResult[1]));
        $this->assertEqual(count($aResult[1]), 11);
        $oDate = new Date('2007-04-20 12:00:00');
        $this->assertEqual($aResult[1]['interval_start'], $oDate);
        $oDate = new Date('2007-04-20 12:59:59');
        $this->assertEqual($aResult[1]['interval_end'], $oDate);
        $this->assertEqual($aResult[1]['ad_required_impressions'], 2932);
        $this->assertEqual($aResult[1]['ad_requested_impressions'], 2932);
        $this->assertEqual((string) $aResult[1]['ad_priority'], (string) 0.2);
        $this->assertEqual($aResult[1]['ad_priority_factor'], 2);
        $this->assertEqual($aResult[1]['ad_priority_factor_limited'], 1);
        $this->assertEqual((string) $aResult[1]['ad_past_zone_traffic_fraction'], (string) 0.4);
        $this->assertNull($aResult[1]['ad_actual_impressions']);
        $this->assertNull($aResult[1]['zone_forecast_impressions']);
        $this->assertNull($aResult[1]['zone_actual_impression']);

        // Test 6: Test as for Test 5, but now with ad impressions in the wrong OI
        $doDataIntermediateAd = OA_Dal::factoryDO('data_intermediate_ad');
        $doDataIntermediateAd->day                = '2006-04-20';
        $doDataIntermediateAd->hour               = 11;
        $doDataIntermediateAd->operation_interval = 60;
        $doDataIntermediateAd->interval_start     = '2007-04-20 11:00:00';
        $doDataIntermediateAd->interval_end       = '2007-04-20 11:59:59';
        $doDataIntermediateAd->ad_id              = 1;
        $doDataIntermediateAd->creative_id        = 0;
        $doDataIntermediateAd->zone_id            = 1;
        $doDataIntermediateAd->impressions        = 100;
        $aRowIds = $dg->generate($doDataIntermediateAd, 1);

        $aResult = $oDal->getZoneTargetingStatistics($validZoneId, $oValidStartDate, $oValidEndDate);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 1);
        $this->assertTrue(is_array($aResult[1]));
        $this->assertEqual(count($aResult[1]), 11);
        $oDate = new Date('2007-04-20 12:00:00');
        $this->assertEqual($aResult[1]['interval_start'], $oDate);
        $oDate = new Date('2007-04-20 12:59:59');
        $this->assertEqual($aResult[1]['interval_end'], $oDate);
        $this->assertEqual($aResult[1]['ad_required_impressions'], 2932);
        $this->assertEqual($aResult[1]['ad_requested_impressions'], 2932);
        $this->assertEqual((string) $aResult[1]['ad_priority'], (string) 0.2);
        $this->assertEqual($aResult[1]['ad_priority_factor'], 2);
        $this->assertEqual($aResult[1]['ad_priority_factor_limited'], 1);
        $this->assertEqual((string) $aResult[1]['ad_past_zone_traffic_fraction'], (string) 0.4);
        $this->assertNull($aResult[1]['ad_actual_impressions']);
        $this->assertNull($aResult[1]['zone_forecast_impressions']);
        $this->assertNull($aResult[1]['zone_actual_impression']);

        // Test 7: Test as for Test 5, but now with ad impressions in the right OI
        $doDataIntermediateAd = OA_Dal::factoryDO('data_intermediate_ad');
        $doDataIntermediateAd->day                = '2006-04-20';
        $doDataIntermediateAd->hour               = 11;
        $doDataIntermediateAd->operation_interval = 60;
        $doDataIntermediateAd->interval_start     = '2007-04-20 12:00:00';
        $doDataIntermediateAd->interval_end       = '2007-04-20 12:59:59';
        $doDataIntermediateAd->ad_id              = 1;
        $doDataIntermediateAd->creative_id        = 0;
        $doDataIntermediateAd->zone_id            = 1;
        $doDataIntermediateAd->impressions        = 150;
        $aRowIds = $dg->generate($doDataIntermediateAd, 1);

        $aResult = $oDal->getZoneTargetingStatistics($validZoneId, $oValidStartDate, $oValidEndDate);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 1);
        $this->assertTrue(is_array($aResult[1]));
        $this->assertEqual(count($aResult[1]), 11);
        $oDate = new Date('2007-04-20 12:00:00');
        $this->assertEqual($aResult[1]['interval_start'], $oDate);
        $oDate = new Date('2007-04-20 12:59:59');
        $this->assertEqual($aResult[1]['interval_end'], $oDate);
        $this->assertEqual($aResult[1]['ad_required_impressions'], 2932);
        $this->assertEqual($aResult[1]['ad_requested_impressions'], 2932);
        $this->assertEqual((string) $aResult[1]['ad_priority'], (string) 0.2);
        $this->assertEqual($aResult[1]['ad_priority_factor'], 2);
        $this->assertEqual($aResult[1]['ad_priority_factor_limited'], 1);
        $this->assertEqual((string) $aResult[1]['ad_past_zone_traffic_fraction'], (string) 0.4);
        $this->assertEqual($aResult[1]['ad_actual_impressions'], 150);
        $this->assertNull($aResult[1]['zone_forecast_impressions']);
        $this->assertNull($aResult[1]['zone_actual_impression']);

        // Test 8: Test as for Test 7, but now with zone data in the wrong OI
//        $doDataSummaryZoneImpressionHistory = OA_Dal::factoryDO('data_summary_zone_impression_history');
//        $doDataSummaryZoneImpressionHistory->operation_interval   = 60;
//        $doDataSummaryZoneImpressionHistory->interval_start       = '2007-04-20 11:00:00';
//        $doDataSummaryZoneImpressionHistory->interval_end         = '2007-04-20 11:59:59';
//        $doDataSummaryZoneImpressionHistory->zone_id              = 1;
//        $doDataSummaryZoneImpressionHistory->forecast_impressions = 222;
//        $doDataSummaryZoneImpressionHistory->actual_impressions   = 333;
//        $aRowIds = $dg->generate($doDataSummaryZoneImpressionHistory, 1);
//
//        $aResult = $oDal->getZoneTargetingStatistics($validZoneId, $oValidStartDate, $oValidEndDate);
//        $this->assertTrue(is_array($aResult));
//        $this->assertEqual(count($aResult), 1);
//        $this->assertTrue(is_array($aResult[1]));
//        $this->assertEqual(count($aResult[1]), 11);
//        $oDate = new Date('2007-04-20 12:00:00');
//        $this->assertEqual($aResult[1]['interval_start'], $oDate);
//        $oDate = new Date('2007-04-20 12:59:59');
//        $this->assertEqual($aResult[1]['interval_end'], $oDate);
//        $this->assertEqual($aResult[1]['ad_required_impressions'], 2932);
//        $this->assertEqual($aResult[1]['ad_requested_impressions'], 2932);
//        $this->assertEqual((string) $aResult[1]['ad_priority'], (string) 0.2);
//        $this->assertEqual($aResult[1]['ad_priority_factor'], 2);
//        $this->assertEqual($aResult[1]['ad_priority_factor_limited'], 1);
//        $this->assertEqual((string) $aResult[1]['ad_past_zone_traffic_fraction'], (string) 0.4);
//        $this->assertEqual($aResult[1]['ad_actual_impressions'], 150);
//        $this->assertNull($aResult[1]['zone_forecast_impressions']);
//        $this->assertNull($aResult[1]['zone_actual_impression']);

        // Test 9: Test as for Test 7, but now with zone data in the wrong OI
//        $doDataSummaryZoneImpressionHistory = OA_Dal::factoryDO('data_summary_zone_impression_history');
//        $doDataSummaryZoneImpressionHistory->operation_interval   = 60;
//        $doDataSummaryZoneImpressionHistory->interval_start       = '2007-04-20 12:00:00';
//        $doDataSummaryZoneImpressionHistory->interval_end         = '2007-04-20 12:59:59';
//        $doDataSummaryZoneImpressionHistory->zone_id              = 1;
//        $doDataSummaryZoneImpressionHistory->forecast_impressions = 444;
//        $doDataSummaryZoneImpressionHistory->actual_impressions   = 555;
//        $aRowIds = $dg->generate($doDataSummaryZoneImpressionHistory, 1);
//
//        $aResult = $oDal->getZoneTargetingStatistics($validZoneId, $oValidStartDate, $oValidEndDate);
//        $this->assertTrue(is_array($aResult));
//        $this->assertEqual(count($aResult), 1);
//        $this->assertTrue(is_array($aResult[1]));
//        $this->assertEqual(count($aResult[1]), 11);
//        $oDate = new Date('2007-04-20 12:00:00');
//        $this->assertEqual($aResult[1]['interval_start'], $oDate);
//        $oDate = new Date('2007-04-20 12:59:59');
//        $this->assertEqual($aResult[1]['interval_end'], $oDate);
//        $this->assertEqual($aResult[1]['ad_required_impressions'], 2932);
//        $this->assertEqual($aResult[1]['ad_requested_impressions'], 2932);
//        $this->assertEqual((string) $aResult[1]['ad_priority'], (string) 0.2);
//        $this->assertEqual($aResult[1]['ad_priority_factor'], 2);
//        $this->assertEqual($aResult[1]['ad_priority_factor_limited'], 1);
//        $this->assertEqual((string) $aResult[1]['ad_past_zone_traffic_fraction'], (string) 0.4);
//        $this->assertEqual($aResult[1]['ad_actual_impressions'], 150);
//        $this->assertEqual($aResult[1]['zone_forecast_impressions'], 444);
//        $this->assertEqual($aResult[1]['zone_actual_impression'], 555);

        TestEnv::restoreEnv();
    }

}

?>