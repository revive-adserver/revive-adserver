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
require_once MAX_PATH . '/lib/OA/Dal/Maintenance/Priority.php';

/**
 * A class for testing the getZonePastForecastAndImpressionHistory() method of the
 * non-DB specific OA_Dal_Maintenance_Priority class.
 *
 * @package    OpenXDal
 * @subpackage TestSuite
 * @author     Monique Szpak <monique.szpak@openx.org>
 * @author     Andrew Hill <andrew.hill@openx.org>
 */
class Test_OA_Dal_Maintenance_Priority_getZonePastForecastAndImpressionHistory extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function Test_OA_Dal_Maintenance_Priority_getZonePastForecastAndImpressionHistory()
    {
        $this->UnitTestCase();
    }

    /**
     * The method to test the getZonePastForecastAndImpressionHistory() method.
     */
    function testGetZonePastForecastAndImpressionHistory()
    {
        $oDal = new OA_Dal_Maintenance_Priority();

        $zoneId = 1;
        $oLowerDate = new Date('2007-09-16 12:00:00');
        $oUpperDate = new Date('2007-09-16 17:00:00');
        $weeks = 2;

        // Test with bad input
        $badZoneId = 'foo';
        $aResult = $oDal->getZonePastForecastAndImpressionHistory($badZoneId, $oLowerDate, $oUpperDate);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 0);

        $badZoneId = -1;
        $aResult = $oDal->getZonePastForecastAndImpressionHistory($badZoneId, $oLowerDate, $oUpperDate);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 0);

        $badDate = 'foo';
        $aResult = $oDal->getZonePastForecastAndImpressionHistory($zoneId, $badDate, $oUpperDate);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 0);
        $aResult = $oDal->getZonePastForecastAndImpressionHistory($zoneId, $oLowerDate, $badDate);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 0);

        // Test with no data in the data_summary_zone_impression_history table
        $aResult = $oDal->getZonePastForecastAndImpressionHistory($zoneId, $oLowerDate, $oUpperDate);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 0);

        // Test with data outside the range
        $oDate = new Date('2007-09-16 11:00:00');
        $operationIntervalId = OX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $aDates = OX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oDate);

        $doData_summary_zone_impression_history = OA_Dal::factoryDO('data_summary_zone_impression_history');
        $doData_summary_zone_impression_history->operation_interval = 60;
        $doData_summary_zone_impression_history->operation_interval_id = $operationIntervalId;
        $doData_summary_zone_impression_history->interval_start = $aDates['start']->format('%Y-%m-%d %H:%M:%S');
        $doData_summary_zone_impression_history->interval_end = $aDates['end']->format('%Y-%m-%d %H:%M:%S');
        $doData_summary_zone_impression_history->zone_id = 1;
        $doData_summary_zone_impression_history->forecast_impressions = 50;
        $doData_summary_zone_impression_history->actual_impressions = 60;
        $id = DataGenerator::generateOne($doData_summary_zone_impression_history);

        $aResult = $oDal->getZonePastForecastAndImpressionHistory($zoneId, $oLowerDate, $oUpperDate);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 0);

        // Test with data inside the range but for the wrong zone
        $oDate = new Date('2007-09-16 12:00:00');
        $operationIntervalId = OX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $aDates = OX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oDate);

        $doData_summary_zone_impression_history = OA_Dal::factoryDO('data_summary_zone_impression_history');
        $doData_summary_zone_impression_history->operation_interval = 60;
        $doData_summary_zone_impression_history->operation_interval_id = $operationIntervalId;
        $doData_summary_zone_impression_history->interval_start = $aDates['start']->format('%Y-%m-%d %H:%M:%S');
        $doData_summary_zone_impression_history->interval_end = $aDates['end']->format('%Y-%m-%d %H:%M:%S');
        $doData_summary_zone_impression_history->zone_id = 2;
        $doData_summary_zone_impression_history->forecast_impressions = 70;
        $doData_summary_zone_impression_history->actual_impressions = 80;
        $id = DataGenerator::generateOne($doData_summary_zone_impression_history);

        $aResult = $oDal->getZonePastForecastAndImpressionHistory($zoneId, $oLowerDate, $oUpperDate);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 0);

        // Test with data inside the range
        $oDate = new Date('2007-09-16 12:00:00');
        $operationIntervalId = OX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $aDates = OX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oDate);

        $doData_summary_zone_impression_history = OA_Dal::factoryDO('data_summary_zone_impression_history');
        $doData_summary_zone_impression_history->operation_interval = 60;
        $doData_summary_zone_impression_history->operation_interval_id = $operationIntervalId;
        $doData_summary_zone_impression_history->interval_start = $aDates['start']->format('%Y-%m-%d %H:%M:%S');
        $doData_summary_zone_impression_history->interval_end = $aDates['end']->format('%Y-%m-%d %H:%M:%S');
        $doData_summary_zone_impression_history->zone_id = 1;
        $doData_summary_zone_impression_history->forecast_impressions = 70;
        $doData_summary_zone_impression_history->actual_impressions = 80;
        $id = DataGenerator::generateOne($doData_summary_zone_impression_history);

        $aResult = $oDal->getZonePastForecastAndImpressionHistory($zoneId, $oLowerDate, $oUpperDate);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 1);
        $this->assertTrue(is_array($aResult[12]));
        $this->assertEqual(count($aResult[12]), 2);
        $this->assertEqual($aResult[12]['forecast_impressions'], 70);
        $this->assertEqual($aResult[12]['actual_impressions'], 80);

        // Test with more data inside the range
        $oDate = new Date('2007-09-16 14:00:00');
        $operationIntervalId = OX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $aDates = OX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oDate);

        $doData_summary_zone_impression_history = OA_Dal::factoryDO('data_summary_zone_impression_history');
        $doData_summary_zone_impression_history->operation_interval = 60;
        $doData_summary_zone_impression_history->operation_interval_id = $operationIntervalId;
        $doData_summary_zone_impression_history->interval_start = $aDates['start']->format('%Y-%m-%d %H:%M:%S');
        $doData_summary_zone_impression_history->interval_end = $aDates['end']->format('%Y-%m-%d %H:%M:%S');
        $doData_summary_zone_impression_history->zone_id = 1;
        $doData_summary_zone_impression_history->forecast_impressions = 90;
        $doData_summary_zone_impression_history->actual_impressions = 10;
        $id = DataGenerator::generateOne($doData_summary_zone_impression_history);

        $aResult = $oDal->getZonePastForecastAndImpressionHistory($zoneId, $oLowerDate, $oUpperDate);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 2);
        $this->assertTrue(is_array($aResult[12]));
        $this->assertEqual(count($aResult[12]), 2);
        $this->assertEqual($aResult[12]['forecast_impressions'], 70);
        $this->assertEqual($aResult[12]['actual_impressions'], 80);
        $this->assertTrue(is_array($aResult[14]));
        $this->assertEqual(count($aResult[14]), 2);
        $this->assertEqual($aResult[14]['forecast_impressions'], 90);
        $this->assertEqual($aResult[14]['actual_impressions'], 10);

        DataGenerator::cleanUp();
    }

}

?>