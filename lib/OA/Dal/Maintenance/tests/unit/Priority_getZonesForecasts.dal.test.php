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
 * A class for testing the getZonesForecasts() method of the
 * non-DB specific OA_Dal_Maintenance_Priority class.
 *
 * @package    OpenXDal
 * @subpackage TestSuite
 */
class Test_OA_Dal_Maintenance_Priority_getZonesForecasts extends UnitTestCase
{
    private $agencyId1;
    private $agencyId2;
    private $zoneId1;
    private $zoneId2;

    const DATE_TIME_FORMAT = '%Y-%m-%d %H:%M:%S';

    /**
     * The constructor method.
     */
    function __construct()
    {
        parent::__construct();
    }

    /**
     * The method to test the getZonesForecasts() method.
     */
    function testgetZonesForecasts()
    {
        $this->_createTestData();
        $operationInterval = $GLOBALS['_MAX']['CONF']['maintenance']['operationInterval'];
        $oDal = new OA_Dal_Maintenance_Priority();

        $oLowerDate = new Date('2007-09-16 12:00:00');
        $oUpperDate = new Date('2007-09-16 17:00:00');
        $lowerDateStr = $oLowerDate->format(self::DATE_TIME_FORMAT);
        $upperDateStr = $oUpperDate->format(self::DATE_TIME_FORMAT);
        $weeks = 2;

        // Test with bad input
        $badAgencyId = -1;
        $result = $oDal->getZonesForecasts($lowerDateStr,$upperDateStr);
        $expected = array();
        $this->assertEqual($result, $expected);

        // Test with data outside the range
        $oDate = new Date('2007-09-16 11:00:00');
        $operationIntervalId = OX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $aDates = OX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oDate);
        $previousOIDate = OX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($oDate);
        $startDateStr = $aDates['start']->format(self::DATE_TIME_FORMAT);
        $endDateStr = $aDates['end']->format(self::DATE_TIME_FORMAT);

        $doDIA      = OA_Dal::factoryDO('data_intermediate_ad');
        $aDIAs = DataGenerator::generate($doDIA,1);
        $doDIA = OA_Dal::staticGetDO('data_intermediate_ad', $aDIAs[0]);
        $doDIA->date_time = $startDateStr;
        $doDIA->operation_interval = $operationInterval;
        $doDIA->zone_id = $this->zoneId1;
        $doDIA->ad_id = 1;
        $doDIA->impressions = 1000;
        $doDIA->update();

        $result = $oDal->getZonesForecasts($startDateStr,$endDateStr);
        $expected = array();
        $this->assertEqual($result, $expected);

        // Test with data inside the range
        $oDate = new Date('2007-09-16 13:00:00');
        $operationIntervalId = OX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $aDates = OX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oDate);
        $previousOIDate = OX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($oDate);
        $startDateStr = $aDates['start']->format(self::DATE_TIME_FORMAT);
        $endDateStr = $aDates['end']->format(self::DATE_TIME_FORMAT);

        $aDIAs = DataGenerator::generate($doDIA,1);
        $doDIA = OA_Dal::staticGetDO('data_intermediate_ad', $aDIAs[0]);
        $doDIA->date_time = $previousOIDate['start']->format(self::DATE_TIME_FORMAT);;
        $doDIA->operation_interval = $operationInterval;
        $doDIA->zone_id = $this->zoneId1;
        $doDIA->ad_id = 1;
        $doDIA->impressions = 70;
        $doDIA->update();

        $result = $oDal->getZonesForecasts($startDateStr,$endDateStr);
        $expected = array($this->zoneId1 => 70);
        $this->assertEqual($result, $expected);

        // Test with more data from the same zone
        $oDate = new Date('2007-09-16 14:00:00');
        $operationIntervalId = OX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $aDates = OX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oDate);
        $previousOIDate = OX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($oDate);
        $startDateStr = $aDates['start']->format(self::DATE_TIME_FORMAT);
        $endDateStr = $aDates['end']->format(self::DATE_TIME_FORMAT);

        $aDIAs = DataGenerator::generate($doDIA, 3);
        $doDIA = OA_Dal::staticGetDO('data_intermediate_ad', $aDIAs[0]);
        $doDIA->date_time = $previousOIDate['start']->format(self::DATE_TIME_FORMAT);;
        $doDIA->operation_interval = $operationInterval;
        $doDIA->zone_id = $this->zoneId1;
        $doDIA->ad_id = 2;
        $doDIA->impressions = 90;
        $doDIA->update();

        $doDIA = OA_Dal::staticGetDO('data_intermediate_ad', $aDIAs[1]);
        $doDIA->date_time = $previousOIDate['start']->format(self::DATE_TIME_FORMAT);;
        $doDIA->operation_interval = $operationInterval;
        $doDIA->zone_id = $this->zoneId1;
        $doDIA->ad_id = 4;
        $doDIA->impressions = 110;
        $doDIA->update();

        $doDIA = OA_Dal::staticGetDO('data_intermediate_ad', $aDIAs[2]);
        $doDIA->date_time = $previousOIDate['start']->format(self::DATE_TIME_FORMAT);;
        $doDIA->operation_interval = $operationInterval;
        $doDIA->zone_id = $this->zoneId2;
        $doDIA->ad_id = 4;
        $doDIA->impressions = 15000;
        $doDIA->update();

        $result = $oDal->getZonesForecasts($startDateStr,$endDateStr);

        $expected = array(
            $this->zoneId1 => 200,
            $this->zoneId2 => 15000
        );
        $this->assertEqual($result, $expected);

        DataGenerator::cleanUp();
    }

    /**
     * A method to generate data for testing.
     *
     * @access private
     */
    function _createTestData()
    {
        // Add zones
        $doZones = OA_Dal::factoryDO('zones');
        $doZones->description = 'Test zone 1';
        $this->zoneId1 = $idZone1 = DataGenerator::generateOne($doZones);

        $doZones = OA_Dal::factoryDO('zones');
        $doZones->description = 'Test zone 2';
        $this->zoneId2 = $idZone2 = DataGenerator::generateOne($doZones);
    }
}

?>