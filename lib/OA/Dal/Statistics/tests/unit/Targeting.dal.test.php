<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
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

require_once MAX_PATH . '/lib/OA/Dal/DataGenerator.php';

require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/lib/OA/Dal/Statistics/Targeting.php';
require_once MAX_PATH . '/lib/pear/Date.php';

/**
 * A class for testing the non-DB specific OA_Dal_Statistics_Targeting class.
 *
 * @package    OpenXDal
 * @subpackage Statistics
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew.hill@openx.org>
 */
class Test_OA_Dal_Statistics_Targeting extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function Test_OA_Dal_Statistics_Targeting()
    {
        $this->UnitTestCase();

        // Prepare a partial mock of the OA_Dal_Statistics_Targeting class with
        // the _getTargetingStatisticsSpan() method knocked out
        Mock::generatePartial(
            'OA_Dal_Statistics_Targeting',
            'PartialMockOA_Dal_Statistics_Targeting',
            array('_getTargetingStatisticsSpan')
        );

        // Prepare some common testing parameters
        $this->id         = 123;
        $this->type       = "ad";
        $this->oStartDate = new Date('2007-05-05');
        $this->oEndDate   = new Date('2007-05-11');
        $this->aExpectedParameters = array(
            0 => $this->id,
            1 => $this->type,
            2 => $this->oStartDate,
            3 => $this->oEndDate
        );
    }

    /**
     * A private method to test methods that wrap the
     * _getTargetingStatisticsSpan() method.
     *
     * @param string     $method     The name of the wrapper method to test.
     * @param integer    $id         The $id parameter to pass to $method.
     * @param string     $type       The $type parameter to pass to $method.
     * @param PEAR::Date $oStartDate The $oStartDate parameter to pass to $method.
     * @param PEAR::Date $oEndDate   The $oEndDate parameter to pass to $method.
     * @param array      $aExpParam  An array of expected parameters that the
     *                               _getTargetingStatisticsSpan() method should
     *                               get.
     */
    function _testMockedClass($method, $id, $type, $oStartDate, $oEndDate, $aExpParam)
    {
        $oDal = new PartialMockOA_Dal_Statistics_Targeting($this);
        $oDal->expectOnce('_getTargetingStatisticsSpan', $aExpParam);
        $oDal->$method($id, $type, $oStartDate, $oEndDate);
        $oDal->tally();
    }

    /**
     * A private method to test the result array of a call to the
     * getAdTargetingStatistics() method.
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
    function _testGetAdTargetingStatistics(
        $aResult, $id, $required = 0, $requested = 0,
        $priority = 0, $priority_f = 0, $priority_l = 0, $past_frac = 0,
        $actual = 0, $z_forecast = 0, $z_actual = 0
    )
    {
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 1);
        $this->assertTrue(is_array($aResult[$id]));
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
        $this->assertEqual($aResult[$id]['zone_actual_impressions'], $z_actual);
    }

    /**
     * A method to test the getTargetingStatisticsSpanByDay()
     * wrapper method.
     */
    function testGetTargetingStatisticsSpanByDay()
    {
        // Call the getTargetingStatisticsSpanByDay() method on a
        // mocked version of the class, and ensure that the correct
        // parameters are passed to the _getTargetingStatisticsSpan()
        // method.
        $this->aExpectedParameters[4] = 'day';
        $this->_testMockedClass(
            'getTargetingStatisticsSpanByDay',
            $this->id,
            $this->type,
            $this->oStartDate,
            $this->oEndDate,
            $this->aExpectedParameters
        );
    }

    /**
     * A method to test the getTargetingStatisticsSpanByWeek()
     * wrapper method.
     */
    function testGetTargetingStatisticsSpanByWeek()
    {
        // Call the getTargetingStatisticsSpanByWeek() method on a
        // mocked version of the class, and ensure that the correct
        // parameters are passed to the _getTargetingStatisticsSpan()
        // method.
        $this->aExpectedParameters[4] = 'week';
        $this->_testMockedClass(
            'getTargetingStatisticsSpanByWeek',
            $this->id,
            $this->type,
            $this->oStartDate,
            $this->oEndDate,
            $this->aExpectedParameters
        );
    }

    /**
     * A method to test the getTargetingStatisticsSpanByMonth()
     * wrapper method.
     */
    function testGetTargetingStatisticsSpanByMonth()
    {
        // Call the getTargetingStatisticsSpanByMonth() method on a
        // mocked version of the class, and ensure that the correct
        // parameters are passed to the _getTargetingStatisticsSpan()
        // method.
        $this->aExpectedParameters[4] = 'month';
        $this->_testMockedClass(
            'getTargetingStatisticsSpanByMonth',
            $this->id,
            $this->type,
            $this->oStartDate,
            $this->oEndDate,
            $this->aExpectedParameters
        );
    }

    /**
     * A method to test the getTargetingStatisticsSpanByDow()
     * wrapper method.
     */
    function testGetTargetingStatisticsSpanByDow()
    {
        // Call the getTargetingStatisticsSpanByDow() method on a
        // mocked version of the class, and ensure that the correct
        // parameters are passed to the _getTargetingStatisticsSpan()
        // method.
        $this->aExpectedParameters[4] = 'dow';
        $this->_testMockedClass(
            'getTargetingStatisticsSpanByDow',
            $this->id,
            $this->type,
            $this->oStartDate,
            $this->oEndDate,
            $this->aExpectedParameters
        );
    }

    /**
     * A method to test the getTargetingStatisticsSpanByHour()
     * wrapper method.
     */
    function testGetTargetingStatisticsSpanByHour()
    {
        // Call the getTargetingStatisticsSpanByHour() method on a
        // mocked version of the class, and ensure that the correct
        // parameters are passed to the _getTargetingStatisticsSpan()
        // method.
        $this->aExpectedParameters[4] = 'hour';
        $this->_testMockedClass(
            'getTargetingStatisticsSpanByHour',
            $this->id,
            $this->type,
            $this->oStartDate,
            $this->oEndDate,
            $this->aExpectedParameters
        );
    }

    /**
     * A method to test the _getTargetingStatisticsSpan() method.
     *
     * @TODO Not implemented...
     */
    function test_getTargetingStatisticsSpan()
    {

    }

    /**
     * A method to test the getDailyTargetingStatistics() method.
     *
     * @TODO Not implemented...
     */
    function getDailyTargetingStatistics()
    {

    }

    /**
     * A method to test the getOperationIntervalTargetingStatistics() method.
     *
     * @TODO Not implemented...
     */
    function testGetOperationIntervalTargetingStatistics()
    {

    }

    /**
     * A method to test the getAdTargetingStatistics() method.
     */
    function testGetAdTargetingStatistics()
    {
        $aConf =& $GLOBALS['_MAX']['CONF'];
        $aConf['maintenance']['operationInterval'] = 60;

        $oDal = new OA_Dal_Statistics_Targeting();

        $dg = new DataGenerator();

        // Test 1: Test the method correctly identifies bad input
        $validAdId = 1;
        $oValidStartDate = new Date('2007-04-20 12:00:00');
        $oValidEndDate   = new Date('2007-04-20 12:59:59');
        $oInvalidEndDate = new Date('2007-04-20 12:59:58');

        $aResult = $oDal->getAdTargetingStatistics(null, $oValidStartDate, $oValidEndDate);
        $this->assertFalse($aResult);

        $aResult = $oDal->getAdTargetingStatistics($validAdId, null, $oValidEndDate);
        $this->assertFalse($aResult);

        $aResult = $oDal->getAdTargetingStatistics($validAdId, $oValidStartDate, null);
        $this->assertFalse($aResult);

        $aResult = $oDal->getAdTargetingStatistics($validAdId, $oValidStartDate, $oInvalidEndDate);
        $this->assertFalse($aResult);

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
        $this->_testGetAdTargetingStatistics($aResult, 1, 5432, 5432, 0.1, 1, 0, 0.1);

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
        $this->_testGetAdTargetingStatistics($aResult, 1, 2932, 2932, 0.2, 2, 1, 0.4);

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
        $this->_testGetAdTargetingStatistics($aResult, 1, 2932, 2932, 0.2, 2, 1, 0.4);

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
        $this->_testGetAdTargetingStatistics($aResult, 1, 2932, 2932, 0.2, 2, 1, 0.4, 150);

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
        $this->_testGetAdTargetingStatistics($aResult, 1, 2932, 2932, 0.2, 2, 1, 0.4, 150);

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
        $this->_testGetAdTargetingStatistics($aResult, 1, 2932, 2932, 0.2, 2, 1, 0.4, 150, 444, 555);

        TestEnv::restoreEnv();
    }

    /**
     * A method to test the _mergeSpan() method.
     */
    function test_mergeSpan()
    {
        // Define valid input values
        $aResult        = array();
        $adType         = 'ad';
        $placementType  = 'placement';
        $aAdData        = array(
            0 => array(
                'interval_start'             => new Date('2007-05-13 00:00:00'),
                'ad_required_impressions'    => 1000,
                'ad_requested_impressions'   => 900,
                'ad_actual_impressions'      => 800,
                'zones_forecast_impressions' => 700,
                'zones_actual_impressions'   => 800,
                'average'                    => false
            ),
            1 => array(
                'interval_start'             => new Date('2007-05-14 00:00:00'),
                'ad_required_impressions'    => 2000,
                'ad_requested_impressions'   => 1900,
                'ad_actual_impressions'      => 1800,
                'zones_forecast_impressions' => 1700,
                'zones_actual_impressions'   => 1800,
                'average'                    => false
            )
        );
        $aPlacementData = array(
            0 => array(
                'interval_start'                  => new Date('2007-05-13 00:00:00'),
                'placement_required_impressions'  => 1000,
                'placement_requested_impressions' => 900,
                'placement_actual_impressions'    => 800,
                'zones_forecast_impressions'      => 700,
                'zones_actual_impressions'        => 800,
                'average'                         => false
            ),
            1 => array(
                'interval_start'                  => new Date('2007-05-14 00:00:00'),
                'placement_required_impressions'  => 2000,
                'placement_requested_impressions' => 1900,
                'placement_actual_impressions'    => 1800,
                'zones_forecast_impressions'      => 1700,
                'zones_actual_impressions'        => 1800,
                'average'                         => false
            )
        );

        $oDal = new OA_Dal_Statistics_Targeting();

        // Test with a bad result array
        $aFoo = null;
        $oDal->_mergeSpan($aFoo, $aAdData, $adType, 'day');
        $this->assertNull($aFoo);
        $aFoo = 'bar';
        $oDal->_mergeSpan($aFoo, $aAdData, $adType, 'day');
        $this->assertEqual($aFoo, 'bar');

        // Test with bad data
        $oDal->_mergeSpan($aResult, null, $adType, 'day');
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 0);
        $oDal->_mergeSpan($aResult, 123, $adType, 'day');
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 0);
        $oDal->_mergeSpan($aResult, 'foo', $adType, 'day');
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 0);

        // Test with a bad type
        $oDal->_mergeSpan($aResult, $aAdData, null, 'day');
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 0);
        $oDal->_mergeSpan($aResult, $aAdData, 123, 'day');
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 0);
        $oDal->_mergeSpan($aResult, $aAdData, 'foo', 'day');
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 0);

        // Test with a breakdown
        $oDal->_mergeSpan($aResult, $aAdData, $adType, null);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 0);
        $oDal->_mergeSpan($aResult, $aAdData, $adType, 123);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 0);
        $oDal->_mergeSpan($aResult, $aAdData, $adType, 'foo');
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 0);

        // Test the "day" breakdown
        $aResult = array();
        $oDal->_mergeSpan($aResult, $aAdData, $adType, 'day');
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 2);
        $this->assertTrue(is_array($aResult['2007-05-13']));
        $this->assertEqual(count($aResult['2007-05-13']), 7);
        $this->assertEqual($aResult['2007-05-13']['ad_required_impressions'],    1000);
        $this->assertEqual($aResult['2007-05-13']['ad_requested_impressions'],   900);
        $this->assertEqual($aResult['2007-05-13']['ad_actual_impressions'],      800);
        $this->assertEqual($aResult['2007-05-13']['zones_forecast_impressions'], 700);
        $this->assertEqual($aResult['2007-05-13']['zones_actual_impressions'],   800);
        $this->assertEqual($aResult['2007-05-13']['target_ratio'],               800 / 1000);
        $this->assertEqual($aResult['2007-05-13']['average'],                    false);
        $this->assertTrue(is_array($aResult['2007-05-14']));
        $this->assertEqual($aResult['2007-05-14']['ad_required_impressions'],    2000);
        $this->assertEqual($aResult['2007-05-14']['ad_requested_impressions'],   1900);
        $this->assertEqual($aResult['2007-05-14']['ad_actual_impressions'],      1800);
        $this->assertEqual($aResult['2007-05-14']['zones_forecast_impressions'], 1700);
        $this->assertEqual($aResult['2007-05-14']['zones_actual_impressions'],   1800);
        $this->assertEqual($aResult['2007-05-14']['target_ratio'],               1800 / 2000);
        $this->assertEqual($aResult['2007-05-14']['average'],                    false);
        $this->assertEqual(count($aResult['2007-05-14']), 7);

        $aResult = array();
        $oDal->_mergeSpan($aResult, $aPlacementData, $placementType, 'day');
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 2);
        $this->assertTrue(is_array($aResult['2007-05-13']));
        $this->assertEqual(count($aResult['2007-05-13']), 7);
        $this->assertEqual($aResult['2007-05-13']['placement_required_impressions'],  1000);
        $this->assertEqual($aResult['2007-05-13']['placement_requested_impressions'], 900);
        $this->assertEqual($aResult['2007-05-13']['placement_actual_impressions'],    800);
        $this->assertEqual($aResult['2007-05-13']['zones_forecast_impressions'],      700);
        $this->assertEqual($aResult['2007-05-13']['zones_actual_impressions'],        800);
        $this->assertEqual($aResult['2007-05-13']['target_ratio'],                    800 / 1000);
        $this->assertEqual($aResult['2007-05-13']['average'],                         false);
        $this->assertTrue(is_array($aResult['2007-05-14']));
        $this->assertEqual(count($aResult['2007-05-14']), 7);
        $this->assertEqual($aResult['2007-05-14']['placement_required_impressions'],  2000);
        $this->assertEqual($aResult['2007-05-14']['placement_requested_impressions'], 1900);
        $this->assertEqual($aResult['2007-05-14']['placement_actual_impressions'],    1800);
        $this->assertEqual($aResult['2007-05-14']['zones_forecast_impressions'],      1700);
        $this->assertEqual($aResult['2007-05-14']['zones_actual_impressions'],        1800);
        $this->assertEqual($aResult['2007-05-14']['target_ratio'],                    1800 / 2000);
        $this->assertEqual($aResult['2007-05-14']['average'],                         false);

        // Test the "week" breakdown
        $aResult = array();
        $oDal->_mergeSpan($aResult, $aAdData, $adType, 'week');
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 2);
        $this->assertTrue(is_array($aResult['2007-05-13']));
        $this->assertEqual(count($aResult['2007-05-13']), 7);
        $this->assertEqual($aResult['2007-05-13']['ad_required_impressions'],    1000);
        $this->assertEqual($aResult['2007-05-13']['ad_requested_impressions'],   900);
        $this->assertEqual($aResult['2007-05-13']['ad_actual_impressions'],      800);
        $this->assertEqual($aResult['2007-05-13']['zones_forecast_impressions'], 700);
        $this->assertEqual($aResult['2007-05-13']['zones_actual_impressions'],   800);
        $this->assertEqual($aResult['2007-05-13']['target_ratio'],               800 / 1000);
        $this->assertEqual($aResult['2007-05-13']['average'],                    false);
        $this->assertTrue(is_array($aResult['2007-05-14']));
        $this->assertEqual($aResult['2007-05-14']['ad_required_impressions'],    2000);
        $this->assertEqual($aResult['2007-05-14']['ad_requested_impressions'],   1900);
        $this->assertEqual($aResult['2007-05-14']['ad_actual_impressions'],      1800);
        $this->assertEqual($aResult['2007-05-14']['zones_forecast_impressions'], 1700);
        $this->assertEqual($aResult['2007-05-14']['zones_actual_impressions'],   1800);
        $this->assertEqual($aResult['2007-05-14']['target_ratio'],               1800 / 2000);
        $this->assertEqual($aResult['2007-05-14']['average'],                    false);
        $this->assertEqual(count($aResult['2007-05-14']), 7);

        $aResult = array();
        $oDal->_mergeSpan($aResult, $aPlacementData, $placementType, 'week');
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 2);
        $this->assertTrue(is_array($aResult['2007-05-13']));
        $this->assertEqual(count($aResult['2007-05-13']), 7);
        $this->assertEqual($aResult['2007-05-13']['placement_required_impressions'],  1000);
        $this->assertEqual($aResult['2007-05-13']['placement_requested_impressions'], 900);
        $this->assertEqual($aResult['2007-05-13']['placement_actual_impressions'],    800);
        $this->assertEqual($aResult['2007-05-13']['zones_forecast_impressions'],      700);
        $this->assertEqual($aResult['2007-05-13']['zones_actual_impressions'],        800);
        $this->assertEqual($aResult['2007-05-13']['target_ratio'],                    800 / 1000);
        $this->assertEqual($aResult['2007-05-13']['average'],                         false);
        $this->assertTrue(is_array($aResult['2007-05-14']));
        $this->assertEqual(count($aResult['2007-05-14']), 7);
        $this->assertEqual($aResult['2007-05-14']['placement_required_impressions'],  2000);
        $this->assertEqual($aResult['2007-05-14']['placement_requested_impressions'], 1900);
        $this->assertEqual($aResult['2007-05-14']['placement_actual_impressions'],    1800);
        $this->assertEqual($aResult['2007-05-14']['zones_forecast_impressions'],      1700);
        $this->assertEqual($aResult['2007-05-14']['zones_actual_impressions'],        1800);
        $this->assertEqual($aResult['2007-05-14']['target_ratio'],                    1800 / 2000);
        $this->assertEqual($aResult['2007-05-14']['average'],                         false);

        // Test the "month" breakdown
        $aResult = array();
        $oDal->_mergeSpan($aResult, $aAdData, $adType, 'month');
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 1);
        $this->assertTrue(is_array($aResult['2007-05']));
        $this->assertEqual(count($aResult['2007-05']), 7);
        $this->assertEqual($aResult['2007-05']['ad_required_impressions'],    1000 + 2000);
        $this->assertEqual($aResult['2007-05']['ad_requested_impressions'],   900 + 1900);
        $this->assertEqual($aResult['2007-05']['ad_actual_impressions'],      800 + 1800);
        $this->assertEqual($aResult['2007-05']['zones_forecast_impressions'], 700 + 1700);
        $this->assertEqual($aResult['2007-05']['zones_actual_impressions'],   800 + 1800);
        $this->assertEqual($aResult['2007-05']['target_ratio'],               (800 + 1800) / (1000 + 2000));
        $this->assertEqual($aResult['2007-05']['average'],                    false);

        $aResult = array();
        $oDal->_mergeSpan($aResult, $aPlacementData, $placementType, 'month');
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 1);
        $this->assertTrue(is_array($aResult['2007-05']));
        $this->assertEqual(count($aResult['2007-05']), 7);
        $this->assertEqual($aResult['2007-05']['placement_required_impressions'],  1000 + 2000);
        $this->assertEqual($aResult['2007-05']['placement_requested_impressions'], 900 + 1900);
        $this->assertEqual($aResult['2007-05']['placement_actual_impressions'],    800 + 1800);
        $this->assertEqual($aResult['2007-05']['zones_forecast_impressions'],      700 + 1700);
        $this->assertEqual($aResult['2007-05']['zones_actual_impressions'],        800 + 1800);
        $this->assertEqual($aResult['2007-05']['target_ratio'],                    (800 + 1800) / (1000 + 2000));
        $this->assertEqual($aResult['2007-05']['average'],                         false);

        // Test the "dow" breakdown
        $aResult = array();
        $oDal->_mergeSpan($aResult, $aAdData, $adType, 'dow');
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 2);
        $this->assertTrue(is_array($aResult[0]));
        $this->assertEqual(count($aResult[0]), 7);
        $this->assertEqual($aResult[0]['ad_required_impressions'],    1000);
        $this->assertEqual($aResult[0]['ad_requested_impressions'],   900);
        $this->assertEqual($aResult[0]['ad_actual_impressions'],      800);
        $this->assertEqual($aResult[0]['zones_forecast_impressions'], 700);
        $this->assertEqual($aResult[0]['zones_actual_impressions'],   800);
        $this->assertEqual($aResult[0]['target_ratio'],               800 / 1000);
        $this->assertEqual($aResult[0]['average'],                    false);
        $this->assertTrue(is_array($aResult[1]));
        $this->assertEqual($aResult[1]['ad_required_impressions'],    2000);
        $this->assertEqual($aResult[1]['ad_requested_impressions'],   1900);
        $this->assertEqual($aResult[1]['ad_actual_impressions'],      1800);
        $this->assertEqual($aResult[1]['zones_forecast_impressions'], 1700);
        $this->assertEqual($aResult[1]['zones_actual_impressions'],   1800);
        $this->assertEqual($aResult[1]['target_ratio'],               1800 / 2000);
        $this->assertEqual($aResult[1]['average'],                    false);
        $this->assertEqual(count($aResult[1]), 7);

        $aResult = array();
        $oDal->_mergeSpan($aResult, $aPlacementData, $placementType, 'dow');
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 2);
        $this->assertTrue(is_array($aResult[0]));
        $this->assertEqual(count($aResult[0]), 7);
        $this->assertEqual($aResult[0]['placement_required_impressions'],  1000);
        $this->assertEqual($aResult[0]['placement_requested_impressions'], 900);
        $this->assertEqual($aResult[0]['placement_actual_impressions'],    800);
        $this->assertEqual($aResult[0]['zones_forecast_impressions'],      700);
        $this->assertEqual($aResult[0]['zones_actual_impressions'],        800);
        $this->assertEqual($aResult[0]['target_ratio'],                    800 / 1000);
        $this->assertEqual($aResult[0]['average'],                         false);
        $this->assertTrue(is_array($aResult[1]));
        $this->assertEqual(count($aResult[1]), 7);
        $this->assertEqual($aResult[1]['placement_required_impressions'],  2000);
        $this->assertEqual($aResult[1]['placement_requested_impressions'], 1900);
        $this->assertEqual($aResult[1]['placement_actual_impressions'],    1800);
        $this->assertEqual($aResult[1]['zones_forecast_impressions'],      1700);
        $this->assertEqual($aResult[1]['zones_actual_impressions'],        1800);
        $this->assertEqual($aResult[1]['target_ratio'],                    1800 / 2000);
        $this->assertEqual($aResult[1]['average'],                         false);

        // Test the "hour" breakdown
        $aResult = array();
        $oDal->_mergeSpan($aResult, $aAdData, $adType, 'hour');
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 1);
        $this->assertTrue(is_array($aResult[0]));
        $this->assertEqual(count($aResult[0]), 7);
        $this->assertEqual($aResult[0]['ad_required_impressions'],    1000 + 2000);
        $this->assertEqual($aResult[0]['ad_requested_impressions'],   900 + 1900);
        $this->assertEqual($aResult[0]['ad_actual_impressions'],      800 + 1800);
        $this->assertEqual($aResult[0]['zones_forecast_impressions'], 700 + 1700);
        $this->assertEqual($aResult[0]['zones_actual_impressions'],   800 + 1800);
        $this->assertEqual($aResult[0]['target_ratio'],               (800 + 1800) / (1000 + 2000));
        $this->assertEqual($aResult[0]['average'],                    false);

        $aResult = array();
        $oDal->_mergeSpan($aResult, $aPlacementData, $placementType, 'hour');
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 1);
        $this->assertTrue(is_array($aResult[0]));
        $this->assertEqual(count($aResult[0]), 7);
        $this->assertEqual($aResult[0]['placement_required_impressions'],  1000 + 2000);
        $this->assertEqual($aResult[0]['placement_requested_impressions'], 900 + 1900);
        $this->assertEqual($aResult[0]['placement_actual_impressions'],    800 + 1800);
        $this->assertEqual($aResult[0]['zones_forecast_impressions'],      700 + 1700);
        $this->assertEqual($aResult[0]['zones_actual_impressions'],        800 + 1800);
        $this->assertEqual($aResult[0]['target_ratio'],                    (800 + 1800) / (1000 + 2000));
        $this->assertEqual($aResult[0]['average'],                         false);
    }

    /**
     * A method to test the _testGetTargetingStatisticsSpanParameters() method.
     */
    function test_testGetTargetingStatisticsSpanParameters()
    {
        // Define valid input values
        $idInt         = 123;
        $adType        = 'ad';
        $placementType = 'placement';
        $oStartDate    = new Date('2007-05-05');
        $oEndDate      = new Date('2007-05-11');

        $oDal = new OA_Dal_Statistics_Targeting();

        // Test with a bad ID
        $result = $oDal->_testGetTargetingStatisticsSpanParameters(null, $adType, $oStartDate, $oEndDate);
        $this->assertFalse($result);
        $result = $oDal->_testGetTargetingStatisticsSpanParameters('foo', $adType, $oStartDate, $oEndDate);
        $this->assertFalse($result);
        $result = $oDal->_testGetTargetingStatisticsSpanParameters('123', $adType, $oStartDate, $oEndDate);
        $this->assertFalse($result);

        // Test with a bad type
        $result = $oDal->_testGetTargetingStatisticsSpanParameters($idInt, null, $oStartDate, $oEndDate);
        $this->assertFalse($result);
        $result = $oDal->_testGetTargetingStatisticsSpanParameters($idInt, 123, $oStartDate, $oEndDate);
        $this->assertFalse($result);
        $result = $oDal->_testGetTargetingStatisticsSpanParameters($idInt, 'foo', $oStartDate, $oEndDate);
        $this->assertFalse($result);

        // Test with a bad start date
        $result = $oDal->_testGetTargetingStatisticsSpanParameters($idInt, $adType, null, $oEndDate);
        $this->assertFalse($result);
        $result = $oDal->_testGetTargetingStatisticsSpanParameters($idInt, $adType, 123, $oEndDate);
        $this->assertFalse($result);
        $result = $oDal->_testGetTargetingStatisticsSpanParameters($idInt, $adType, 'foo', $oEndDate);
        $this->assertFalse($result);

        // Test with a bad end date
        $result = $oDal->_testGetTargetingStatisticsSpanParameters($idInt, $adType, $oStartDate, null);
        $this->assertFalse($result);
        $result = $oDal->_testGetTargetingStatisticsSpanParameters($idInt, $adType, $oStartDate, 123);
        $this->assertFalse($result);
        $result = $oDal->_testGetTargetingStatisticsSpanParameters($idInt, $adType, $oStartDate, 'foo');
        $this->assertFalse($result);

        // Test with valid input
        $result = $oDal->_testGetTargetingStatisticsSpanParameters($idInt, $adType, $oStartDate, $oEndDate);
        $this->assertTrue($result);
        $result = $oDal->_testGetTargetingStatisticsSpanParameters($idInt, $placementType, $oStartDate, $oEndDate);
        $this->assertTrue($result);
    }

    /**
     * A method to test the _testGetTargetingStatisticsSpanPlacement() method.
     */
    function test_testGetTargetingStatisticsSpanPlacement()
    {
        $oDal = new OA_Dal_Statistics_Targeting();

        // Test with type "ad"
        $id   = 5;
        $type = 'ad';
        $aResult = $oDal->_testGetTargetingStatisticsSpanPlacement($id, $type);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 1);
        $this->assertEqual($aResult[0], 5);

        // Test with type "placement", placement has no ads

    }

    /**
     * A method to test the _testParameters() method.
     *
     */
    function test_testParameters()
    {
        // Define valid input values
        $idInt         = 123;
        $oStartDate    = new Date('2007-05-05 12:00:00');
        $oEndDate      = new Date('2007-05-05 12:59:59');

        $oDal = new OA_Dal_Statistics_Targeting();

        // Set the operation interval to 60
        $aConf =& $GLOBALS['_MAX']['CONF'];
        $aConf['maintenance']['operationInterval'] = 60;

        // Test with a bad ID
        $result = $oDal->_testParameters(null, $oStartDate, $oEndDate);
        $this->assertFalse($result);
        $result = $oDal->_testParameters('foo', $oStartDate, $oEndDate);
        $this->assertFalse($result);
        $result = $oDal->_testParameters('123', $oStartDate, $oEndDate);
        $this->assertFalse($result);

        // Test with a bad start date
        $result = $oDal->_testParameters($idInt, null, $oEndDate);
        $this->assertFalse($result);
        $result = $oDal->_testParameters($idInt, 123, $oEndDate);
        $this->assertFalse($result);
        $result = $oDal->_testParameters($idInt, 'foo', $oEndDate);
        $this->assertFalse($result);

        // Test with a bad end date
        $result = $oDal->_testParameters($idInt, $oStartDate, null);
        $this->assertFalse($result);
        $result = $oDal->_testParameters($idInt, $oStartDate, 123);
        $this->assertFalse($result);
        $result = $oDal->_testParameters($idInt, $oStartDate, 'foo');
        $this->assertFalse($result);

        // Test with a non-operation interval
        $oStartDate    = new Date('2007-05-05 12:00:00');
        $oEndDate      = new Date('2007-05-05 12:59:58');
        $result = $oDal->_testParameters($idInt, $oStartDate, $oEndDate);
        $this->assertFalse($result);

        // Test with valid input
        $oStartDate    = new Date('2007-05-05 12:00:00');
        $oEndDate      = new Date('2007-05-05 12:59:59');
        $result = $oDal->_testParameters($idInt, $oStartDate, $oEndDate);
        $this->assertTrue($result);

        TestEnv::restoreConfig();
    }

    /**
     * A method to test the _calculateAverages() method.
     */
    function test_calculateAverages()
    {
        $oDal = new OA_Dal_Statistics_Targeting();

        // Test with bad input
        $oDate = new Date();

        $aResult = $oDal->_calculateAverages('foo', $oDate);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 0);

        $aTest = array();
        $aResult = $oDal->_calculateAverages($aTest, $oDate);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 0);

        $aTest = array(
            0 => 'foo'
        );
        $aResult = $oDal->_calculateAverages($aTest, $oDate);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 0);

        $aTest = array(
            0 => array()
        );
        $aResult = $oDal->_calculateAverages($aTest, $oDate);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 0);

        // Test the average calculations with identical values
        $oIntervalStartDate = new Date('2007-05-15 12:00:00');
        $oIntervalEndDate   = new Date('2007-05-15 12:59:59');
        $oDate = new Date('2007-05-15 12:59:59');
        $aTest = array(
            0 => array(
                interval_start                => $oIntervalStartDate,
                interval_end                  => $oIntervalEndDate,
                ad_required_impressions       => 1000,
                ad_requested_impressions      => 900,
                ad_priority                   => 0.9,
                ad_priority_factor            => 1,
                ad_priority_factor_limited    => 0,
                ad_past_zone_traffic_fraction => null,
                created                       => new Date('2007-05-15 12:00:00'),
                expired                       => new Date('2007-05-15 12:29:59')
            ),
            1 => array(
                interval_start                => $oIntervalStartDate,
                interval_end                  => $oIntervalEndDate,
                ad_required_impressions       => 1000,
                ad_requested_impressions      => 900,
                ad_priority                   => 0.9,
                ad_priority_factor            => 1,
                ad_priority_factor_limited    => 0,
                ad_past_zone_traffic_fraction => null,
                created                       => new Date('2007-05-15 12:30:00'),
                expired                       => null
            )
        );
        $aResult = $oDal->_calculateAverages($aTest, $oDate);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 9);
        $this->assertEqual($aResult['interval_start'],                $oIntervalStartDate);
        $this->assertEqual($aResult['interval_end'],                  $oIntervalEndDate);
        $this->assertEqual($aResult['ad_required_impressions'],       1000);
        $this->assertEqual($aResult['ad_requested_impressions'],      900);
        $this->assertEqual($aResult['ad_priority'],                   0.9);
        $this->assertEqual($aResult['ad_priority_factor'],            1);
        $this->assertEqual($aResult['ad_past_zone_traffic_fraction'], null);
        $this->assertEqual($aResult['ad_priority_factor_limited'],    0);
        $this->assertTrue($aResult['average']);

        // Test the average calculations with different values
        $oIntervalStartDate = new Date('2007-05-15 12:00:00');
        $oIntervalEndDate   = new Date('2007-05-15 12:59:59');
        $oDate = new Date('2007-05-15 12:59:59');
        $aTest = array(
            0 => array(
                interval_start                => $oIntervalStartDate,
                interval_end                  => $oIntervalEndDate,
                ad_required_impressions       => 3000,
                ad_requested_impressions      => 2700,
                ad_priority                   => 0.8,
                ad_priority_factor            => 1,
                ad_priority_factor_limited    => 0,
                ad_past_zone_traffic_fraction => null,
                created                       => new Date('2007-05-15 12:00:00'),
                expired                       => new Date('2007-05-15 12:29:59')
            ),
            1 => array(
                interval_start                => $oIntervalStartDate,
                interval_end                  => $oIntervalEndDate,
                ad_required_impressions       => 1000,
                ad_requested_impressions      => 900,
                ad_priority                   => 0.2,
                ad_priority_factor            => 0.5,
                ad_priority_factor_limited    => 1,
                ad_past_zone_traffic_fraction => 0.5,
                created                       => new Date('2007-05-15 12:30:00'),
                expired                       => null
            )
        );
        $aResult = $oDal->_calculateAverages($aTest, $oDate);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 9);
        $this->assertEqual($aResult['interval_start'],                $oIntervalStartDate);
        $this->assertEqual($aResult['interval_end'],                  $oIntervalEndDate);
        $this->assertEqual($aResult['ad_required_impressions'],       2000);
        $this->assertEqual($aResult['ad_requested_impressions'],      1800);
        $this->assertEqual($aResult['ad_priority'],                   0.5);
        $this->assertEqual($aResult['ad_priority_factor'],            0.75);
        $this->assertEqual($aResult['ad_past_zone_traffic_fraction'], 0.25);
        $this->assertEqual($aResult['ad_priority_factor_limited'],    1);
        $this->assertTrue($aResult['average']);
    }

}

?>