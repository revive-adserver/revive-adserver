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
     * Test 4: Test with one ad in the placement, partial data in the wrong day
     * Test 5: Test with one ad in the placement, partial data in the right day
     * Test 6: Test with one ad in the placement, dual partial data in the right day
     * Test 7: Test as for Test 6, but now with ad impressions in the wrong day
     * Test 8: Test as for Test 6, but now with ad impressions in the wrong OI
     * Test 9: Test as for Test 6, but now with ad impressions in the right OI
     * Test 10: Test as for Test 9, but now with zone data in the wrong day
     * Test 11: Test as for Test 9, but now with zone data in the wrong OI
     * Test 12: Test as for Test 9, but now with zone data in the right OI
     * Test 13: Test with multiple OIs, multiple ads
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
        $this->_testGetPlacementDailyTargetingStatistics($aResult);

        // Test 4: Test with one ad in the placement, partial data in the wrong day
        $doDataSummaryAdZoneAssoc = OA_Dal::factoryDO('data_summary_ad_zone_assoc');
        $doDataSummaryAdZoneAssoc->operation_interval         = 60;
        $doDataSummaryAdZoneAssoc->interval_start             = '2007-04-19 12:00:00';
        $doDataSummaryAdZoneAssoc->interval_end               = '2007-04-19 12:59:59';
        $doDataSummaryAdZoneAssoc->ad_id                      = 1;
        $doDataSummaryAdZoneAssoc->zone_id                    = 1;
        $doDataSummaryAdZoneAssoc->required_impressions       = 5432;
        $doDataSummaryAdZoneAssoc->requested_impressions      = 5432;
        $doDataSummaryAdZoneAssoc->priority                   = 0.1;
        $doDataSummaryAdZoneAssoc->priority_factor            = 1;
        $doDataSummaryAdZoneAssoc->priority_factor_limited    = 0;
        $doDataSummaryAdZoneAssoc->past_zone_traffic_fraction = 0.1;
        $doDataSummaryAdZoneAssoc->created                    = '2007-04-19 12:00:00';
        $doDataSummaryAdZoneAssoc->expired                    = '2007-04-19 12:29:59';
        $aRowIds = $dg->generate($doDataSummaryAdZoneAssoc, 1);

        $aResult = $oDal->getPlacementDailyTargetingStatistics($validPlacementId, $oValidDate);
        $this->_testGetPlacementDailyTargetingStatistics($aResult);

        // Test 5: Test with one ad in the placement, partial data in the right day
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

        $aResult = $oDal->getPlacementDailyTargetingStatistics($validPlacementId, $oValidDate);
        $this->_testGetPlacementDailyTargetingStatistics($aResult, 5432, 5432);

        // Test 6: Test with one ad in the placement, dual partial data in the right day
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

        $aResult = $oDal->getPlacementDailyTargetingStatistics($validPlacementId, $oValidDate);
        $this->_testGetPlacementDailyTargetingStatistics($aResult, 2932, 2932);

        // Test 7: Test as for Test 6, but now with ad impressions in the wrong day
        $doDataIntermediateAd = OA_Dal::factoryDO('data_intermediate_ad');
        $doDataIntermediateAd->day                = '2006-04-19';
        $doDataIntermediateAd->hour               = 11;
        $doDataIntermediateAd->operation_interval = 60;
        $doDataIntermediateAd->interval_start     = '2007-04-19 12:00:00';
        $doDataIntermediateAd->interval_end       = '2007-04-19 12:59:59';
        $doDataIntermediateAd->ad_id              = 1;
        $doDataIntermediateAd->creative_id        = 0;
        $doDataIntermediateAd->zone_id            = 1;
        $doDataIntermediateAd->impressions        = 100;
        $aRowIds = $dg->generate($doDataIntermediateAd, 1);

        $aResult = $oDal->getPlacementDailyTargetingStatistics($validPlacementId, $oValidDate);
        $this->_testGetPlacementDailyTargetingStatistics($aResult, 2932, 2932);

        // Test 8: Test as for Test 6, but now with ad impressions in the wrong OI
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

        $aResult = $oDal->getPlacementDailyTargetingStatistics($validPlacementId, $oValidDate);
        $this->_testGetPlacementDailyTargetingStatistics($aResult, 2932, 2932);

        // Test 9: Test as for Test 6, but now with ad impressions in the right OI
        $doDataIntermediateAd = OA_Dal::factoryDO('data_intermediate_ad');
        $doDataIntermediateAd->day                = '2006-04-20';
        $doDataIntermediateAd->hour               = 11;
        $doDataIntermediateAd->operation_interval = 60;
        $doDataIntermediateAd->interval_start     = '2007-04-20 12:00:00';
        $doDataIntermediateAd->interval_end       = '2007-04-20 12:59:59';
        $doDataIntermediateAd->ad_id              = 1;
        $doDataIntermediateAd->creative_id        = 0;
        $doDataIntermediateAd->zone_id            = 1;
        $doDataIntermediateAd->impressions        = 100;
        $aRowIds = $dg->generate($doDataIntermediateAd, 1);

        $aResult = $oDal->getPlacementDailyTargetingStatistics($validPlacementId, $oValidDate);
        $this->_testGetPlacementDailyTargetingStatistics($aResult, 2932, 2932, 100);

        // Test 10: Test as for Test 9, but now with zone data in the wrong day
        $doDataSummaryZoneImpressionHistory = OA_Dal::factoryDO('data_summary_zone_impression_history');
        $doDataSummaryZoneImpressionHistory->operation_interval   = 60;
        $doDataSummaryZoneImpressionHistory->interval_start       = '2007-04-19 12:00:00';
        $doDataSummaryZoneImpressionHistory->interval_end         = '2007-04-19 12:59:59';
        $doDataSummaryZoneImpressionHistory->zone_id              = 1;
        $doDataSummaryZoneImpressionHistory->forecast_impressions = 222;
        $doDataSummaryZoneImpressionHistory->actual_impressions   = 333;
        $aRowIds = $dg->generate($doDataSummaryZoneImpressionHistory, 1);

        $aResult = $oDal->getPlacementDailyTargetingStatistics($validPlacementId, $oValidDate);
        $this->_testGetPlacementDailyTargetingStatistics($aResult, 2932, 2932, 100);

        // Test 11: Test as for Test 9, but now with zone data in the wrong OI
        $doDataSummaryZoneImpressionHistory = OA_Dal::factoryDO('data_summary_zone_impression_history');
        $doDataSummaryZoneImpressionHistory->operation_interval   = 60;
        $doDataSummaryZoneImpressionHistory->interval_start       = '2007-04-20 11:00:00';
        $doDataSummaryZoneImpressionHistory->interval_end         = '2007-04-20 11:59:59';
        $doDataSummaryZoneImpressionHistory->zone_id              = 1;
        $doDataSummaryZoneImpressionHistory->forecast_impressions = 444;
        $doDataSummaryZoneImpressionHistory->actual_impressions   = 555;
        $aRowIds = $dg->generate($doDataSummaryZoneImpressionHistory, 1);

        $aResult = $oDal->getPlacementDailyTargetingStatistics($validPlacementId, $oValidDate);
        $this->_testGetPlacementDailyTargetingStatistics($aResult, 2932, 2932, 100);

        // Test 12: Test as for Test 9, but now with zone data in the right OI
        $doDataSummaryZoneImpressionHistory = OA_Dal::factoryDO('data_summary_zone_impression_history');
        $doDataSummaryZoneImpressionHistory->operation_interval   = 60;
        $doDataSummaryZoneImpressionHistory->interval_start       = '2007-04-20 12:00:00';
        $doDataSummaryZoneImpressionHistory->interval_end         = '2007-04-20 12:59:59';
        $doDataSummaryZoneImpressionHistory->zone_id              = 1;
        $doDataSummaryZoneImpressionHistory->forecast_impressions = 666;
        $doDataSummaryZoneImpressionHistory->actual_impressions   = 777;
        $aRowIds = $dg->generate($doDataSummaryZoneImpressionHistory, 1);

        $aResult = $oDal->getPlacementDailyTargetingStatistics($validPlacementId, $oValidDate);
        $this->_testGetPlacementDailyTargetingStatistics($aResult, 2932, 2932, 100, 666, 777);

        // Test 13: Test with multiple OIs, multiple ads
        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->bannerid = 2;
        $doBanners->campaignid = 1;
        $aRows = $dg->generate($doBanners, 1);

        $doDataSummaryAdZoneAssoc = OA_Dal::factoryDO('data_summary_ad_zone_assoc');
        $doDataSummaryAdZoneAssoc->operation_interval         = 60;
        $doDataSummaryAdZoneAssoc->interval_start             = '2007-04-20 11:00:00';
        $doDataSummaryAdZoneAssoc->interval_end               = '2007-04-20 11:59:59';
        $doDataSummaryAdZoneAssoc->ad_id                      = 2;
        $doDataSummaryAdZoneAssoc->zone_id                    = 1;
        $doDataSummaryAdZoneAssoc->required_impressions       = 20;
        $doDataSummaryAdZoneAssoc->requested_impressions      = 15;
        $doDataSummaryAdZoneAssoc->priority                   = 0.1;
        $doDataSummaryAdZoneAssoc->priority_factor            = 1;
        $doDataSummaryAdZoneAssoc->priority_factor_limited    = 0;
        $doDataSummaryAdZoneAssoc->past_zone_traffic_fraction = 0.1;
        $doDataSummaryAdZoneAssoc->created                    = '2007-04-20 11:00:00';
        $doDataSummaryAdZoneAssoc->expired                    = '2007-04-20 11:59:59';
        $aRowIds = $dg->generate($doDataSummaryAdZoneAssoc, 1);

        $doDataIntermediateAd = OA_Dal::factoryDO('data_intermediate_ad');
        $doDataIntermediateAd->day                = '2006-04-20';
        $doDataIntermediateAd->hour               = 11;
        $doDataIntermediateAd->operation_interval = 60;
        $doDataIntermediateAd->interval_start     = '2007-04-20 11:00:00';
        $doDataIntermediateAd->interval_end       = '2007-04-20 11:59:59';
        $doDataIntermediateAd->ad_id              = 2;
        $doDataIntermediateAd->creative_id        = 0;
        $doDataIntermediateAd->zone_id            = 1;
        $doDataIntermediateAd->impressions        = 15;
        $aRowIds = $dg->generate($doDataIntermediateAd, 1);

        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->bannerid = 3;
        $doBanners->campaignid = 1;
        $aRows = $dg->generate($doBanners, 1);

        $doDataSummaryAdZoneAssoc = OA_Dal::factoryDO('data_summary_ad_zone_assoc');
        $doDataSummaryAdZoneAssoc->operation_interval         = 60;
        $doDataSummaryAdZoneAssoc->interval_start             = '2007-04-20 11:00:00';
        $doDataSummaryAdZoneAssoc->interval_end               = '2007-04-20 11:59:59';
        $doDataSummaryAdZoneAssoc->ad_id                      = 3;
        $doDataSummaryAdZoneAssoc->zone_id                    = 2;
        $doDataSummaryAdZoneAssoc->required_impressions       = 50;
        $doDataSummaryAdZoneAssoc->requested_impressions      = 40;
        $doDataSummaryAdZoneAssoc->priority                   = 0.1;
        $doDataSummaryAdZoneAssoc->priority_factor            = 1;
        $doDataSummaryAdZoneAssoc->priority_factor_limited    = 0;
        $doDataSummaryAdZoneAssoc->past_zone_traffic_fraction = 0.1;
        $doDataSummaryAdZoneAssoc->created                    = '2007-04-20 11:00:00';
        $doDataSummaryAdZoneAssoc->expired                    = '2007-04-20 11:59:59';
        $aRowIds = $dg->generate($doDataSummaryAdZoneAssoc, 1);

        $doDataIntermediateAd = OA_Dal::factoryDO('data_intermediate_ad');
        $doDataIntermediateAd->day                = '2006-04-20';
        $doDataIntermediateAd->hour               = 11;
        $doDataIntermediateAd->operation_interval = 60;
        $doDataIntermediateAd->interval_start     = '2007-04-20 11:00:00';
        $doDataIntermediateAd->interval_end       = '2007-04-20 11:59:59';
        $doDataIntermediateAd->ad_id              = 3;
        $doDataIntermediateAd->creative_id        = 0;
        $doDataIntermediateAd->zone_id            = 2;
        $doDataIntermediateAd->impressions        = 45;
        $aRowIds = $dg->generate($doDataIntermediateAd, 1);

        $doDataSummaryZoneImpressionHistory = OA_Dal::factoryDO('data_summary_zone_impression_history');
        $doDataSummaryZoneImpressionHistory->operation_interval   = 60;
        $doDataSummaryZoneImpressionHistory->interval_start       = '2007-04-20 11:00:00';
        $doDataSummaryZoneImpressionHistory->interval_end         = '2007-04-20 11:59:59';
        $doDataSummaryZoneImpressionHistory->zone_id              = 2;
        $doDataSummaryZoneImpressionHistory->forecast_impressions = 15;
        $doDataSummaryZoneImpressionHistory->actual_impressions   = 20;
        $aRowIds = $dg->generate($doDataSummaryZoneImpressionHistory, 1);

        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->bannerid = 4;
        $doBanners->campaignid = 1;
        $aRows = $dg->generate($doBanners, 1);

        $doDataSummaryAdZoneAssoc = OA_Dal::factoryDO('data_summary_ad_zone_assoc');
        $doDataSummaryAdZoneAssoc->operation_interval         = 60;
        $doDataSummaryAdZoneAssoc->interval_start             = '2007-04-20 11:00:00';
        $doDataSummaryAdZoneAssoc->interval_end               = '2007-04-20 11:59:59';
        $doDataSummaryAdZoneAssoc->ad_id                      = 4;
        $doDataSummaryAdZoneAssoc->zone_id                    = 1;
        $doDataSummaryAdZoneAssoc->required_impressions       = 10;
        $doDataSummaryAdZoneAssoc->requested_impressions      = 10;
        $doDataSummaryAdZoneAssoc->priority                   = 0.1;
        $doDataSummaryAdZoneAssoc->priority_factor            = 1;
        $doDataSummaryAdZoneAssoc->priority_factor_limited    = 0;
        $doDataSummaryAdZoneAssoc->past_zone_traffic_fraction = 0.1;
        $doDataSummaryAdZoneAssoc->created                    = '2007-04-20 11:00:00';
        $doDataSummaryAdZoneAssoc->expired                    = '2007-04-20 11:59:59';
        $aRowIds = $dg->generate($doDataSummaryAdZoneAssoc, 1);

        $doDataIntermediateAd = OA_Dal::factoryDO('data_intermediate_ad');
        $doDataIntermediateAd->day                = '2006-04-20';
        $doDataIntermediateAd->hour               = 11;
        $doDataIntermediateAd->operation_interval = 60;
        $doDataIntermediateAd->interval_start     = '2007-04-20 11:00:00';
        $doDataIntermediateAd->interval_end       = '2007-04-20 11:59:59';
        $doDataIntermediateAd->ad_id              = 4;
        $doDataIntermediateAd->creative_id        = 0;
        $doDataIntermediateAd->zone_id            = 1;
        $doDataIntermediateAd->impressions        = 9;
        $aRowIds = $dg->generate($doDataIntermediateAd, 1);

        $aResult = $oDal->getPlacementDailyTargetingStatistics($validPlacementId, $oValidDate);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 24);
        for ($intervalId = 120; $intervalId < 144; $intervalId++) {
            $oDate = new Date('2007-04-20');
            $oDate->setHour($intervalId - 120);
            $oDate->setMinute(0);
            $oDate->setSecond(0);
            $this->assertEqual($aResult[$intervalId]['interval_start'], $oDate);
            $oDate = new Date('2007-04-20');
            $oDate->setHour($intervalId - 120);
            $oDate->setMinute(59);
            $oDate->setSecond(59);
            $this->assertEqual($aResult[$intervalId]['interval_end'], $oDate);
            if ($intervalId == 131) {
                $this->assertEqual($aResult[$intervalId]['placement_required_impressions'], 20 + 50 + 10);
                $this->assertEqual($aResult[$intervalId]['placement_requested_impressions'], 15 + 40 + 10);
                $this->assertEqual($aResult[$intervalId]['placement_actual_impressions'], 15 + 45 + 9);
                $this->assertEqual($aResult[$intervalId]['zones_forecast_impressions'], 444 + 15);
                $this->assertEqual($aResult[$intervalId]['zones_actual_impression'], 555 + 20);
            } else if ($intervalId == 132) {
                $this->assertEqual($aResult[$intervalId]['placement_required_impressions'], 2932);
                $this->assertEqual($aResult[$intervalId]['placement_requested_impressions'], 2932);
                $this->assertEqual($aResult[$intervalId]['placement_actual_impressions'], 100);
                $this->assertEqual($aResult[$intervalId]['zones_forecast_impressions'], 666);
                $this->assertEqual($aResult[$intervalId]['zones_actual_impression'], 777);
            } else {
                $this->assertEqual($aResult[$intervalId]['placement_required_impressions'], 0);
                $this->assertEqual($aResult[$intervalId]['placement_requested_impressions'], 0);
                $this->assertEqual($aResult[$intervalId]['placement_actual_impressions'], 0);
                $this->assertEqual($aResult[$intervalId]['zones_forecast_impressions'], 0);
                $this->assertEqual($aResult[$intervalId]['zones_actual_impression'], 0);
            }
        }

        TestEnv::restoreEnv();
    }

    /**
     * A private method to test the result array of a call to the
     * testGetPlacementDailyTargetingStatistics() method.
     *
     * @access private
     * @param array $aResult      The result array returned from a call to the
     *                            testGetPlacementDailyTargetingStatistics() method.
     * @param integer $required   The required number of ad impressions expected for the OI of
     *                            2007-04-20 12:00:00 to 2007-04-20 12:59:59.
     * @param integer $requested  The requested number of ad impressions expected for the OI of
     *                            2007-04-20 12:00:00 to 2007-04-20 12:59:59.
     * @param integer $actual     The actual number of ad impressions expected for the OI of
     *                            2007-04-20 12:00:00 to 2007-04-20 12:59:59.
     * @param integer $z_forecast The forecast number of zone impressions expected for the OI of
     *                            2007-04-20 12:00:00 to 2007-04-20 12:59:59.
     * @param integer $z_actual   The actual number of zone impressions expected for the OI of
     *                            2007-04-20 12:00:00 to 2007-04-20 12:59:59.
     */
    function _testGetPlacementDailyTargetingStatistics(
        $aResult, $required = 0, $requested = 0,
        $actual = 0, $z_forecast = 0, $z_actual = 0
    )
    {
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 24);
        for ($intervalId = 120; $intervalId < 144; $intervalId++) {
            $oDate = new Date('2007-04-20');
            $oDate->setHour($intervalId - 120);
            $oDate->setMinute(0);
            $oDate->setSecond(0);
            $this->assertEqual($aResult[$intervalId]['interval_start'], $oDate);
            $oDate = new Date('2007-04-20');
            $oDate->setHour($intervalId - 120);
            $oDate->setMinute(59);
            $oDate->setSecond(59);
            $this->assertEqual($aResult[$intervalId]['interval_end'], $oDate);
            if ($intervalId == 132) {
                $this->assertEqual($aResult[$intervalId]['placement_required_impressions'], $required);
                $this->assertEqual($aResult[$intervalId]['placement_requested_impressions'], $requested);
                $this->assertEqual($aResult[$intervalId]['placement_actual_impressions'], $actual);
                $this->assertEqual($aResult[$intervalId]['zones_forecast_impressions'], $z_forecast);
                $this->assertEqual($aResult[$intervalId]['zones_actual_impression'], $z_actual);
            } else {
                $this->assertEqual($aResult[$intervalId]['placement_required_impressions'], 0);
                $this->assertEqual($aResult[$intervalId]['placement_requested_impressions'], 0);
                $this->assertEqual($aResult[$intervalId]['placement_actual_impressions'], 0);
                $this->assertEqual($aResult[$intervalId]['zones_forecast_impressions'], 0);
                $this->assertEqual($aResult[$intervalId]['zones_actual_impression'], 0);
            }
        }
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
        $doDataSummaryAdZoneAssoc->created                    = '2007-04-20 11:00:00';
        $doDataSummaryAdZoneAssoc->expired                    = '2007-04-20 11:29:59';
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
        $doDataSummaryAdZoneAssoc->created                    = '2007-04-20 12:00:00';
        $doDataSummaryAdZoneAssoc->expired                    = '2007-04-20 12:29:59';
        $aRowIds = $dg->generate($doDataSummaryAdZoneAssoc, 1);

        $aResult = $oDal->getAdTargetingStatistics($validAdId, $oValidStartDate, $oValidEndDate);
        $this->_testGetAdOrZoneTargetingStatistics($aResult, 1, 5432, 5432, 0.1, 1, 0, 0.1);

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
        $this->_testGetAdOrZoneTargetingStatistics($aResult, 1, 2932, 2932, 0.2, 2, 1, 0.4);

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
        $this->_testGetAdOrZoneTargetingStatistics($aResult, 1, 2932, 2932, 0.2, 2, 1, 0.4);

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
        $this->_testGetAdOrZoneTargetingStatistics($aResult, 1, 2932, 2932, 0.2, 2, 1, 0.4, 150);

        // Test 8: Test as for Test 7, but now with zone data in the wrong OI
        $doDataSummaryZoneImpressionHistory = OA_Dal::factoryDO('data_summary_zone_impression_history');
        $doDataSummaryZoneImpressionHistory->operation_interval   = 60;
        $doDataSummaryZoneImpressionHistory->interval_start       = '2007-04-20 11:00:00';
        $doDataSummaryZoneImpressionHistory->interval_end         = '2007-04-20 11:59:59';
        $doDataSummaryZoneImpressionHistory->zone_id              = 1;
        $doDataSummaryZoneImpressionHistory->forecast_impressions = 222;
        $doDataSummaryZoneImpressionHistory->actual_impressions   = 333;
        $aRowIds = $dg->generate($doDataSummaryZoneImpressionHistory, 1);

        $aResult = $oDal->getAdTargetingStatistics($validAdId, $oValidStartDate, $oValidEndDate);
        $this->_testGetAdOrZoneTargetingStatistics($aResult, 1, 2932, 2932, 0.2, 2, 1, 0.4, 150);

        // Test 9: Test as for Test 7, but now with zone data in the right OI
        $doDataSummaryZoneImpressionHistory = OA_Dal::factoryDO('data_summary_zone_impression_history');
        $doDataSummaryZoneImpressionHistory->operation_interval   = 60;
        $doDataSummaryZoneImpressionHistory->interval_start       = '2007-04-20 12:00:00';
        $doDataSummaryZoneImpressionHistory->interval_end         = '2007-04-20 12:59:59';
        $doDataSummaryZoneImpressionHistory->zone_id              = 1;
        $doDataSummaryZoneImpressionHistory->forecast_impressions = 444;
        $doDataSummaryZoneImpressionHistory->actual_impressions   = 555;
        $aRowIds = $dg->generate($doDataSummaryZoneImpressionHistory, 1);

        $aResult = $oDal->getAdTargetingStatistics($validAdId, $oValidStartDate, $oValidEndDate);
        $this->_testGetAdOrZoneTargetingStatistics($aResult, 1, 2932, 2932, 0.2, 2, 1, 0.4, 150, 444, 555);

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
        $this->_testGetAdOrZoneTargetingStatistics($aResult, 1, 5432, 5432, 0.1, 1, 0, 0.1);

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
        $this->_testGetAdOrZoneTargetingStatistics($aResult, 1, 2932, 2932, 0.2, 2, 1, 0.4);

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
        $this->_testGetAdOrZoneTargetingStatistics($aResult, 1, 2932, 2932, 0.2, 2, 1, 0.4);

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
        $this->_testGetAdOrZoneTargetingStatistics($aResult, 1, 2932, 2932, 0.2, 2, 1, 0.4, 150);

        // Test 8: Test as for Test 7, but now with zone data in the wrong OI
        $doDataSummaryZoneImpressionHistory = OA_Dal::factoryDO('data_summary_zone_impression_history');
        $doDataSummaryZoneImpressionHistory->operation_interval   = 60;
        $doDataSummaryZoneImpressionHistory->interval_start       = '2007-04-20 11:00:00';
        $doDataSummaryZoneImpressionHistory->interval_end         = '2007-04-20 11:59:59';
        $doDataSummaryZoneImpressionHistory->zone_id              = 1;
        $doDataSummaryZoneImpressionHistory->forecast_impressions = 222;
        $doDataSummaryZoneImpressionHistory->actual_impressions   = 333;
        $aRowIds = $dg->generate($doDataSummaryZoneImpressionHistory, 1);

        $aResult = $oDal->getZoneTargetingStatistics($validZoneId, $oValidStartDate, $oValidEndDate);
        $this->_testGetAdOrZoneTargetingStatistics($aResult, 1, 2932, 2932, 0.2, 2, 1, 0.4, 150);

        // Test 9: Test as for Test 7, but now with zone data in the right OI
        $doDataSummaryZoneImpressionHistory = OA_Dal::factoryDO('data_summary_zone_impression_history');
        $doDataSummaryZoneImpressionHistory->operation_interval   = 60;
        $doDataSummaryZoneImpressionHistory->interval_start       = '2007-04-20 12:00:00';
        $doDataSummaryZoneImpressionHistory->interval_end         = '2007-04-20 12:59:59';
        $doDataSummaryZoneImpressionHistory->zone_id              = 1;
        $doDataSummaryZoneImpressionHistory->forecast_impressions = 444;
        $doDataSummaryZoneImpressionHistory->actual_impressions   = 555;
        $aRowIds = $dg->generate($doDataSummaryZoneImpressionHistory, 1);

        $aResult = $oDal->getZoneTargetingStatistics($validZoneId, $oValidStartDate, $oValidEndDate);
        $this->_testGetAdOrZoneTargetingStatistics($aResult, 1, 2932, 2932, 0.2, 2, 1, 0.4, 150, 444, 555);

        TestEnv::restoreEnv();
    }

    /**
     * A private method to test the result array of a call to the
     * getAdTargetingStatistics() or getZoneTargetingStatistics() methods.
     *
     * @access private
     * @param array   $aResult    The result array returned from a call to the
     *                            testGetPlacementDailyTargetingStatistics() method.
     * @param integer $id         The ID of the ad, or zone, expected.
     * @param integer $required   The required number of ad impressions expected for the OI of
     *                            2007-04-20 12:00:00 to 2007-04-20 12:59:59.
     * @param integer $requested  The requested number of ad impressions expected for the OI of
     *                            2007-04-20 12:00:00 to 2007-04-20 12:59:59.
     * @param integer $priority   The ad priority expected for the OI of
     *                            2007-04-20 12:00:00 to 2007-04-20 12:59:59.
     * @param integer $priority_f The ad priority factor expected for the OI of
     *                            2007-04-20 12:00:00 to 2007-04-20 12:59:59.
     * @param integer $priority_l The ad priority factor limited expected for the OI of
     *                            2007-04-20 12:00:00 to 2007-04-20 12:59:59.
     * @param integer $past_frac  The ad zone past fraction expected for the OI of
     *                            2007-04-20 12:00:00 to 2007-04-20 12:59:59.
     * @param integer $actual     The actual number of ad impressions expected for the OI of
     *                            2007-04-20 12:00:00 to 2007-04-20 12:59:59.
     * @param integer $z_forecast The forecast number of zone impressions expected for the OI of
     *                            2007-04-20 12:00:00 to 2007-04-20 12:59:59.
     * @param integer $z_actual   The actual number of zone impressions expected for the OI of
     *                            2007-04-20 12:00:00 to 2007-04-20 12:59:59.
     */
    function _testGetAdOrZoneTargetingStatistics(
        $aResult, $id, $required = 0, $requested = 0,
        $priority = 0, $priority_f = 0, $priority_l = 0, $past_frac = 0,
        $actual = 0, $z_forecast = 0, $z_actual = 0
    )
    {
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 1);
        $this->assertTrue(is_array($aResult[$id]));
        $this->assertEqual(count($aResult[$id]), 11);
        $oDate = new Date('2007-04-20 12:00:00');
        $this->assertEqual($aResult[$id]['interval_start'], $oDate);
        $oDate = new Date('2007-04-20 12:59:59');
        $this->assertEqual($aResult[$id]['interval_end'], $oDate);
        $this->assertEqual($aResult[$id]['ad_required_impressions'], $required);
        $this->assertEqual($aResult[$id]['ad_requested_impressions'], $requested);
        $this->assertEqual((string) $aResult[$id]['ad_priority'], (string) $priority);
        $this->assertEqual($aResult[$id]['ad_priority_factor'], $priority_f);
        $this->assertEqual($aResult[$id]['ad_priority_factor_limited'], $priority_l);
        $this->assertEqual((string) $aResult[$id]['ad_past_zone_traffic_fraction'], (string) $past_frac);
        $this->assertEqual($aResult[$id]['ad_actual_impressions'], $actual);
        $this->assertEqual($aResult[$id]['zone_forecast_impressions'], $z_forecast);
        $this->assertEqual($aResult[$id]['zone_actual_impression'], $z_actual);
    }

}

?>