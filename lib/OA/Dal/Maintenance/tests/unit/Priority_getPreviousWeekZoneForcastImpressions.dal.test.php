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

require_once MAX_PATH . '/lib/OA/Dal/DataGenerator.php';
require_once MAX_PATH . '/lib/OA/Dal/Maintenance/Priority.php';

/**
 * A class for testing the getPreviousWeekZoneForcastImpressions() method of
 * the non-DB specific OA_Dal_Maintenance_Priority class.
 *
 * @package    OpenXDal
 * @subpackage TestSuite
 */
class Test_OA_Dal_Maintenance_Priority_getPreviousWeekZoneForcastImpressions extends UnitTestCase
{
    /**
     * The constructor method.
     */
    function __construct()
    {
        parent::__construct();
    }

    /**
     * A method to test the getPreviousWeekZoneForcastImpressions() method.
     *
     * Test 1: Test with bad input, and ensure false is returned.
     * Test 2: Test with no date in the service locator, and ensure that
     *         false is returned.
     * Test 3: Test with no data, and ensure that an array with the default
     *         forecast for each zone is returned.
     * Test 4: Test with data, and ensure that an array with the correct
     *         forecasts is returned.
     */
    function testGetPreviousWeekZoneForcastImpressions()
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        $oDbh = OA_DB::singleton();
        $oDal = new OA_Dal_Maintenance_Priority();

        // Test 1
        $aResult = $oDal->getPreviousWeekZoneForcastImpressions('foo');
        $this->assertFalse($aResult);

        // Test 2
        $oServiceLocator = OA_ServiceLocator::instance();
        $oServiceLocator->remove('now');
        $aResult = $oDal->getPreviousWeekZoneForcastImpressions(1);
        $this->assertFalse($aResult);

        // Test 3
        $oDate = new Date();
        $oServiceLocator->register('now', $oDate);
        $aResult = $oDal->getPreviousWeekZoneForcastImpressions(1);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), OX_OperationInterval::operationIntervalsPerWeek());
        for ($operationIntervalID = 0; $operationIntervalID < OX_OperationInterval::operationIntervalsPerWeek(); $operationIntervalID++) {
            $expected =  array(
                        'zone_id' => 1,
                        'forecast_impressions' => $oDal->getZoneForecastDefaultZoneImpressions(),
                        'operation_interval_id' => $operationIntervalID
            );
            $this->assertEqual($aResult[$operationIntervalID], $expected);
        }

        // Test 4

        // Insert impressions for the previous operation interval
        $aDates = OX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oDate);
        $aDates = OX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($aDates['start']);
        $firstIntervalID = OX_OperationInterval::convertDateToOperationIntervalID($aDates['start']);

        $startDate = $aDates['start']->format('%Y-%m-%d %H:%M:%S');
        $endDate = $aDates['start']->format('%Y-%m-%d %H:%M:%S');

        $doDIA      = OA_Dal::factoryDO('data_intermediate_ad');
        $aDIAs = DataGenerator::generate($doDIA, 4);
        $doDIA = OA_Dal::staticGetDO('data_intermediate_ad', $aDIAs[0]);

        $startDate = $aDates['start']->format('%Y-%m-%d %H:%M:%S');
        $endDate = $aDates['start']->format('%Y-%m-%d %H:%M:%S');
        $doDIA->date_time = $startDate;
        $doDIA->interval_start = $startDate;
        $doDIA->interval_end = $endDate;
        $doDIA->operation_interval = $aConf['maintenance']['operationInterval'];
        $doDIA->operation_interval_id = $firstIntervalID;
        $doDIA->zone_id = 1;
        $doDIA->ad_id = 1;
        $doDIA->impressions = 4000;
        $doDIA->update();

        // Insert forcast for the (N - 2) OI
        // for two different ads in this OI
        $aDates = OX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($aDates['start']);
        $secondIntervalID = OX_OperationInterval::convertDateToOperationIntervalID($aDates['start']);

        $startDate = $aDates['start']->format('%Y-%m-%d %H:%M:%S');
        $endDate = $aDates['start']->format('%Y-%m-%d %H:%M:%S');
        $doDIA = OA_Dal::staticGetDO('data_intermediate_ad', $aDIAs[1]);
        $doDIA->date_time = $startDate;
        $doDIA->interval_start = $startDate;
        $doDIA->interval_end = $endDate;
        $doDIA->operation_interval = $aConf['maintenance']['operationInterval'];
        $doDIA->operation_interval_id = $secondIntervalID;
        $doDIA->zone_id = 1;
        $doDIA->ad_id = 1;
        $doDIA->impressions = 4990;
        $doDIA->update();

        $doDIA = OA_Dal::staticGetDO('data_intermediate_ad', $aDIAs[2]);
        $doDIA->date_time = $startDate;
        $doDIA->interval_start = $startDate;
        $doDIA->interval_end = $endDate;
        $doDIA->operation_interval = $aConf['maintenance']['operationInterval'];
        $doDIA->operation_interval_id = $secondIntervalID;
        $doDIA->zone_id = 1;
        $doDIA->ad_id = 2;
        $doDIA->impressions = 10;
        $doDIA->update();

        // Insert forcast for the second previous operation interval, but
        // one week ago (so it should not be in the result set)
        $oNewDate = new Date();
        $oNewDate->copy($aDates['start']);
        $oNewDate->subtractSeconds(SECONDS_PER_WEEK);
        $aDates = OX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($oNewDate);
        $intervalID = OX_OperationInterval::convertDateToOperationIntervalID($aDates['start']);

        $startDate = $aDates['start']->format('%Y-%m-%d %H:%M:%S');
        $endDate = $aDates['start']->format('%Y-%m-%d %H:%M:%S');
        $doDIA = OA_Dal::staticGetDO('data_intermediate_ad', $aDIAs[3]);
        $doDIA->date_time = $startDate;
        $doDIA->interval_start = $startDate;
        $doDIA->interval_end = $endDate;
        $doDIA->operation_interval = $aConf['maintenance']['operationInterval'];
        $doDIA->operation_interval_id = $intervalID;
        $doDIA->zone_id = 1;
        $doDIA->ad_id = 1;
        $doDIA->impressions = 1000;
        $doDIA->update();

        // What's the current OI?
        $currentIntervalID = OX_OperationInterval::convertDateToOperationIntervalID($oServiceLocator->get('now'));

        $aResult = $oDal->getPreviousWeekZoneForcastImpressions(1);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), OX_OperationInterval::operationIntervalsPerWeek());
        for ($operationIntervalID = 0; $operationIntervalID < OX_OperationInterval::operationIntervalsPerWeek(); $operationIntervalID++) {
            $this->assertTrue(is_array($aResult[$operationIntervalID]));
            $this->assertEqual(count($aResult[$operationIntervalID]), 3);
            $this->assertEqual($aResult[$operationIntervalID]['zone_id'], 1);
            if ($operationIntervalID == $firstIntervalID || $operationIntervalID == $currentIntervalID) {
                // Current and previous OI forecasts should be the same
                $this->assertEqual($aResult[$operationIntervalID]['forecast_impressions'], 4000);
            } elseif ($operationIntervalID == $secondIntervalID) {
                $this->assertEqual($aResult[$operationIntervalID]['forecast_impressions'], 5000);
            } else {
                $this->assertEqual($aResult[$operationIntervalID]['forecast_impressions'], 4500); // average between both known forecast
            }
            $this->assertEqual($aResult[$operationIntervalID]['operation_interval_id'], $operationIntervalID);
        }

        DataGenerator::cleanUp();
    }
}

?>