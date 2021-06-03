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
 * A class for testing the getZonesForecastsForAllZones() method of the non-DB specific
 * OA_Dal_Maintenance_Priority class.
 *
 * @package    OpenXDal
 * @subpackage TestSuite
 */
class Test_OA_Dal_Maintenance_Priority_getZonesForecastsForAllZones extends UnitTestCase
{
    var $doZones = null;

    private $dia;

    /**
     * A method to generate data for testing.
     *
     * @access private
     */
    function _generateTestHistory($idZone, $aDates, $forecast, $actual)
    {
        $conf = $GLOBALS['_MAX']['CONF'];

        if (null === $this->dia) {
            $this->dia = OA_Dal::factoryDO('data_intermediate_ad');
        }

        if(!empty($actual)) {
            // actual
            $this->dia->operation_interval = $conf['maintenance']['operationInterval'];
            $this->dia->operation_interval_id = OX_OperationInterval::convertDateToOperationIntervalID($aDates['start']);
            $this->dia->interval_start = $aDates['start']->format('%Y-%m-%d %H:%M:%S');
            $this->dia->date_time = $aDates['start']->format('%Y-%m-%d %H:%M:%S');
            $this->dia->interval_end   = $aDates['end']->format('%Y-%m-%d %H:%M:%S');
            $this->dia->zone_id = $idZone;
            $this->dia->ad_id = 1;
            $this->dia->impressions = $actual;
            $dia = DataGenerator::generateOne($this->dia);
        }

        if(!empty($forecast)) {
            $MINIMUM_FORECAST_FOR_TEST = 3;
            if($forecast <= $MINIMUM_FORECAST_FOR_TEST) {
                $this->fail('Forecast parameter must be > '. $MINIMUM_FORECAST_FOR_TEST);
            }
            // forecast
            $aDates = OX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($aDates['start']);
            $this->dia->operation_interval = $conf['maintenance']['operationInterval'];
            $this->dia->operation_interval_id = OX_OperationInterval::convertDateToOperationIntervalID($aDates['start']);
            $this->dia->interval_start = $aDates['start']->format('%Y-%m-%d %H:%M:%S');
            $this->dia->date_time = $aDates['start']->format('%Y-%m-%d %H:%M:%S');
            $this->dia->interval_end   = $aDates['end']->format('%Y-%m-%d %H:%M:%S');
            $this->dia->zone_id = $idZone;
            $this->dia->ad_id = 1;
            $this->dia->impressions = $forecast - $MINIMUM_FORECAST_FOR_TEST;
            $dia = DataGenerator::generateOne($this->dia);

            // we split the forecast in two rows, one for each Ad
            $this->dia->operation_interval = $conf['maintenance']['operationInterval'];
            $this->dia->operation_interval_id = OX_OperationInterval::convertDateToOperationIntervalID($aDates['start']);
            $this->dia->interval_start = $aDates['start']->format('%Y-%m-%d %H:%M:%S');
            $this->dia->date_time = $aDates['start']->format('%Y-%m-%d %H:%M:%S');
            $this->dia->interval_end   = $aDates['end']->format('%Y-%m-%d %H:%M:%S');
            $this->dia->zone_id = $idZone;
            $this->dia->ad_id = 2;
            $this->dia->impressions = $MINIMUM_FORECAST_FOR_TEST;
            $dia = DataGenerator::generateOne($this->dia);
        }
    }

    /**
     * A method to generate data for testing.
     *
     * @access private
     */
    function _generateTestZones($numZones)
    {
        if (null === $this->doZones) {
            $this->doZones = OA_Dal::factoryDO('zones');
        }

        return DataGenerator::generate($this->doZones,$numZones);
    }

    /**
     * Method to test the getZonesForecastsForAllZones method.
     *
     * Requirements:
     * Test 1: Test with no Date registered in the service locator, ensure false returned.
     * Test 2: Test with a Date registered in the service locator, no data in the database,
     *         and ensure no data is returned.
     * Test 3: Test with forecast data but no actual impressions
     * Test 3.5: Test with actual data but no forecast impressions
     * Test 4: Test with data both in, and not in, the current OI, and ensure the correct
     *         data is returned.
     * Test 5: Repeat Test 4, but with additional zones (that don't have data) in the zones
     *         table.
     */
    function testGetAllZonesImpInv()
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $oDbh = OA_DB::singleton();
        $oMaxDalMaintenance = new OA_Dal_Maintenance_Priority();
        $zoneForecastDefaultZoneImpressions = 0; // $oMaxDalMaintenance->getZoneForecastDefaultZoneImpressions();

        // Test 1
        $oServiceLocator = OA_ServiceLocator::instance();
        $oServiceLocator->remove('now');
        $result =& $oMaxDalMaintenance->getZonesForecastsForAllZones();
        $this->assertFalse($result);

        // Test 2
        $oDate = new Date();
        $oServiceLocator->register('now', $oDate);
        $result = $oMaxDalMaintenance->getZonesForecastsForAllZones();
        $this->assertEqual($result, array(0 => $zoneForecastDefaultZoneImpressions)); // Zone 0

        // Test 3
        // generate the first zone
        $aZones = $this->_generateTestZones(1);
        //         only generate previous OI delivered impressions, should return zone 0 only
        $oDate = $oServiceLocator->get('now');
        $oNewDate = new Date();
        $oNewDate->copy($oDate);
        $oNewDate->subtractSeconds(($conf['maintenance']['operationInterval'] * 60) + 1);
        $aDates = OX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oNewDate);
        $this->_generateTestHistory(1, $aDates, 42, 0);
        $result =& $oMaxDalMaintenance->getZonesForecastsForAllZones();
        $expected = array(
            0 => $zoneForecastDefaultZoneImpressions,
            1 => $zoneForecastDefaultZoneImpressions,
        );
        $this->assertEqual($result, $expected);

        // Test 3.5
        // generate the second zone
        $aZones = $this->_generateTestZones(1);
        //     only generate previous OI forecasted impressions, should return zone 0 only
        $oNewDate = new Date();
        $oNewDate->copy($aDates['start']);
        $oNewDate->subtractSeconds(1);
        $aDates = OX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oNewDate);
        $this->_generateTestHistory(2, $aDates, 0, 37);

        $result = $oMaxDalMaintenance->getZonesForecastsForAllZones();
        $expected = array(
            0 => $zoneForecastDefaultZoneImpressions,
            1 => $zoneForecastDefaultZoneImpressions,
            2 => $zoneForecastDefaultZoneImpressions,
        );
        $this->assertEqual($result, $expected);

        $oDate = $oServiceLocator->get('now');
        DataGenerator::cleanUp();
        $oServiceLocator->register('now', $oDate);

        // Test 4
        $oDate = $oServiceLocator->get('now');
        // generate three zone
        $this->_generateTestZones(3);

        // set forecast and impressions for OI - 1
        $aDates = OX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oDate);
        $this->_generateTestHistory(1, $aDates, 42, 100);
        $this->_generateTestHistory(2, $aDates, 5, 2);
        $this->_generateTestHistory(3, $aDates, 9999, 9999);

        $result = $oMaxDalMaintenance->getZonesForecastsForAllZones();
        $expected = array(
            0 => $zoneForecastDefaultZoneImpressions,
            1 => 42,
            2 => 5,
            3 => 9999,
        );
        $this->assertEqual($result, $expected);

        // Test 5

        // New zone must appear in the array with default forecast
        $aZones = $this->_generateTestZones(1);
        $result = $oMaxDalMaintenance->getZonesForecastsForAllZones();
        $expected = array(
            0 => $zoneForecastDefaultZoneImpressions,
            1 => 42,
            2 => 5,
            3 => 9999,
            4 => $zoneForecastDefaultZoneImpressions
        );
        $result =& $oMaxDalMaintenance->getZonesForecastsForAllZones();
        $this->assertEqual($result, $expected);

        // register forecast for the OI before, this should not affect current OI forecast
        $oDate = $oServiceLocator->get('now');
        $aDates = OX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($oDate);
        $currentOpIntID = OX_OperationInterval::convertDateToOperationIntervalID($aDates['start']);
        $this->_generateTestHistory(1, $aDates, 3700, 0);
        $this->_generateTestHistory(2, $aDates, 300, 0);
        $this->_generateTestHistory(3, $aDates, 500, 0);

        $result = $oMaxDalMaintenance->getZonesForecastsForAllZones();
        $this->assertEqual($result, $expected);
        DataGenerator::cleanUp();
    }

}

?>