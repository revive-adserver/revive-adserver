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
$Id: Priority_getZonesForecasts.dal.test.php 30999 2009-01-16 09:59:42Z andrew.hill $
*/

require_once MAX_PATH . '/lib/OA/Dal/DataGenerator.php';
require_once MAX_PATH . '/lib/OA/Dal/Maintenance/Priority.php';

/**
 * A class for testing the getZonesForecasts() method of the
 * non-DB specific OA_Dal_Maintenance_Priority class.
 *
 * @package    OpenXDal
 * @subpackage TestSuite
 * @author     Radek Maciaszek <radek@urbantrip.com>
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
    function Test_OA_Dal_Maintenance_Priority_getZonesForecasts()
    {
        $this->UnitTestCase();
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