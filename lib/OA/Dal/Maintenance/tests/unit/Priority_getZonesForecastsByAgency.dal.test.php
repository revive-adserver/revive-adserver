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
$Id: Priority_getZonesForecastsByAgency.dal.test.php 30999 2009-01-16 09:59:42Z andrew.hill $
*/

require_once MAX_PATH . '/lib/OA/Dal/DataGenerator.php';
require_once MAX_PATH . '/lib/OA/Dal/Maintenance/Priority.php';

/**
 * A class for testing the getZonesForecastsByAgency() method of the
 * non-DB specific OA_Dal_Maintenance_Priority class.
 *
 * @package    OpenXDal
 * @subpackage TestSuite
 * @author     Radek Maciaszek <radek@urbantrip.com>
 */
class Test_OA_Dal_Maintenance_Priority_getZonesForecastsByAgency extends UnitTestCase
{
    private $agencyId1;
    private $agencyId2;
    private $zoneId1;
    private $zoneId2;

    const DATE_TIME_FORMAT = '%Y-%m-%d %H:%M:%S';

    /**
     * The constructor method.
     */
    function Test_OA_Dal_Maintenance_Priority_getZonesForecastsByAgency()
    {
        $this->UnitTestCase();
    }

    /**
     * The method to test the getZonesForecastsByAgency() method.
     */
    function testGetZonesForecastsByAgency()
    {
        $this->_createTestData();
        
        $oDal = new OA_Dal_Maintenance_Priority();

        $agencyId = $this->agencyId1;
        $oLowerDate = new Date('2007-09-16 12:00:00');
        $oUpperDate = new Date('2007-09-16 17:00:00');
        $lowerDateStr = $oLowerDate->format(self::DATE_TIME_FORMAT);
        $upperDateStr = $oUpperDate->format(self::DATE_TIME_FORMAT);
        $weeks = 2;

        // Test with bad input
        $badAgencyId = -1;
        $aResult = $oDal->getZonesForecastsByAgency($badAgencyId,
            $lowerDateStr,
            $upperDateStr
        );
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 0);

        // Test with data outside the range
        $oDate = new Date('2007-09-16 11:00:00');
        $operationIntervalId = OX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $aDates = OX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oDate);
        $startDateStr = $aDates['start']->format(self::DATE_TIME_FORMAT);
        $endDateStr = $aDates['end']->format(self::DATE_TIME_FORMAT);

        $doData_summary_zone_impression_history = OA_Dal::factoryDO('data_summary_zone_impression_history');
        $doData_summary_zone_impression_history->operation_interval = 60;
        $doData_summary_zone_impression_history->operation_interval_id = $operationIntervalId;
        $doData_summary_zone_impression_history->interval_start = $startDateStr;
        $doData_summary_zone_impression_history->interval_end = $endDateStr;
        $doData_summary_zone_impression_history->zone_id = $this->zoneId1;
        $doData_summary_zone_impression_history->forecast_impressions = 50;
        $doData_summary_zone_impression_history->actual_impressions = 60;
        $id = DataGenerator::generateOne($doData_summary_zone_impression_history);

        $aResult = $oDal->getZonesForecastsByAgency($agencyId,
            $lowerDateStr,
            $upperDateStr
        );
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 0);

        // Test with data inside the range but for the wrong zone
        $oDate = new Date('2007-09-16 12:00:00');
        $operationIntervalId = OX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $aDates = OX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oDate);
        $startDateStr = $aDates['start']->format(self::DATE_TIME_FORMAT);
        $endDateStr = $aDates['end']->format(self::DATE_TIME_FORMAT);

        $doData_summary_zone_impression_history = OA_Dal::factoryDO('data_summary_zone_impression_history');
        $doData_summary_zone_impression_history->operation_interval = 60;
        $doData_summary_zone_impression_history->operation_interval_id = $operationIntervalId;
        $doData_summary_zone_impression_history->interval_start = $startDateStr;
        $doData_summary_zone_impression_history->interval_end = $endDateStr;
        $doData_summary_zone_impression_history->zone_id = $this->zoneId2;
        $doData_summary_zone_impression_history->forecast_impressions = 70;
        $doData_summary_zone_impression_history->actual_impressions = 80;
        $id = DataGenerator::generateOne($doData_summary_zone_impression_history);

        $aResult = $oDal->getZonesForecastsByAgency($agencyId,
            $startDateStr,
            $endDateStr
        );
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 0);

        // Test with data inside the range
        $oDate = new Date('2007-09-16 12:00:00');
        $operationIntervalId = OX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $aDates = OX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oDate);
        $startDateStr = $aDates['start']->format(self::DATE_TIME_FORMAT);
        $endDateStr = $aDates['end']->format(self::DATE_TIME_FORMAT);

        $doData_summary_zone_impression_history = OA_Dal::factoryDO('data_summary_zone_impression_history');
        $doData_summary_zone_impression_history->operation_interval = 60;
        $doData_summary_zone_impression_history->operation_interval_id = $operationIntervalId;
        $doData_summary_zone_impression_history->interval_start = $startDateStr;
        $doData_summary_zone_impression_history->interval_end = $endDateStr;
        $doData_summary_zone_impression_history->zone_id = $this->zoneId1;
        $doData_summary_zone_impression_history->forecast_impressions = 70;
        $doData_summary_zone_impression_history->actual_impressions = 80;
        $id = DataGenerator::generateOne($doData_summary_zone_impression_history);

        $aResult = $oDal->getZonesForecastsByAgency($agencyId, 
            $startDateStr,
            $endDateStr
        );

        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 1);
        $this->assertEqual($aResult[$this->zoneId1], 70);

        // Test with more data from the same zone
        $oDate = new Date('2007-09-16 14:00:00');
        $operationIntervalId = OX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $aDates = OX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oDate);
        $startDateStr = $aDates['start']->format(self::DATE_TIME_FORMAT);
        $endDateStr = $aDates['end']->format(self::DATE_TIME_FORMAT);

        $doData_summary_zone_impression_history = OA_Dal::factoryDO('data_summary_zone_impression_history');
        $doData_summary_zone_impression_history->operation_interval = 60;
        $doData_summary_zone_impression_history->operation_interval_id = $operationIntervalId;
        $doData_summary_zone_impression_history->interval_start = $startDateStr;
        $doData_summary_zone_impression_history->interval_end = $endDateStr;
        $doData_summary_zone_impression_history->zone_id = $this->zoneId1;
        $doData_summary_zone_impression_history->forecast_impressions = 90;
        $doData_summary_zone_impression_history->actual_impressions = 10;
        $id = DataGenerator::generateOne($doData_summary_zone_impression_history);

        $aResult = $oDal->getZonesForecastsByAgency($agencyId,
            $startDateStr,
            $endDateStr
        );
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 1);
        $this->assertEqual($aResult[$this->zoneId1], 90);

        DataGenerator::cleanUp();
    }

    /**
     * A method to generate data for testing.
     *
     * @access private
     */
    function _createTestData()
    {
        // Add agencies
        $this->agencyId1 = $agencyId1 = DataGenerator::generateOne('agency', true);
        $this->agencyId2 = $agencyId2 = DataGenerator::generateOne('agency', true);

        // Add affiliates (websites)
        $doAffiliates = OA_Dal::factoryDO('affiliates');
        $doAffiliates->agencyid = $agencyId1;
        $affiliateId1 = DataGenerator::generateOne($doAffiliates);

        $doAffiliates = OA_Dal::factoryDO('affiliates');
        $doAffiliates->agencyid = $agencyId2;
        $affiliateId2 = DataGenerator::generateOne($doAffiliates);

        // Add zones
        $doZones = OA_Dal::factoryDO('zones');
        $doZones->description = 'Test zone';
        $doZones->affiliateid = $affiliateId1;
        $this->zoneId1 = $idZone1 = DataGenerator::generateOne($doZones);

        $doZones = OA_Dal::factoryDO('zones');
        $doZones->description = 'Test zone';
        $doZones->affiliateid = $affiliateId2;
        $this->zoneId2 = $idZone2 = DataGenerator::generateOne($doZones);
    }
}

?>