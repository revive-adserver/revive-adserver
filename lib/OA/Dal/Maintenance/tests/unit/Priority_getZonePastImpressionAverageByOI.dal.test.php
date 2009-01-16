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
 * A class for testing the getZonePastImpressionAverageByOI() method of the
 * non-DB specific OA_Dal_Maintenance_Priority class.
 *
 * @package    OpenXDal
 * @subpackage TestSuite
 * @author     Monique Szpak <monique.szpak@openx.org>
 * @author     Andrew Hill <andrew.hill@openx.org>
 */
class Test_OA_Dal_Maintenance_Priority_getZonePastImpressionAverageByOI extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function Test_OA_Dal_Maintenance_Priority_getZonePastImpressionAverageByOI()
    {
        $this->UnitTestCase();
    }

    /**
     * The method to test the getZonePastImpressionAverageByOI() method.
     */
    function testGetZonePastImpressionAverageByOI()
    {
        $oDal = new OA_Dal_Maintenance_Priority();

        $zoneId = 1;
        $oLowerDate = new Date('2007-09-16 12:00:00');
        $oUpperDate = new Date('2007-09-16 17:00:00');
        $weeks = 2;

        // Test with bad input
        $badZoneId = 'foo';
        $aResult = $oDal->getZonePastImpressionAverageByOI($badZoneId, $oLowerDate, $oUpperDate, $weeks);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 0);

        $badZoneId = -1;
        $aResult = $oDal->getZonePastImpressionAverageByOI($badZoneId, $oLowerDate, $oUpperDate, $weeks);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 0);

        $badDate = 'foo';
        $aResult = $oDal->getZonePastImpressionAverageByOI($zoneId, $badDate, $oUpperDate, $weeks);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 0);
        $aResult = $oDal->getZonePastImpressionAverageByOI($zoneId, $oLowerDate, $badDate, $weeks);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 0);

        $badWeeks = 'foo';
        $aResult = $oDal->getZonePastImpressionAverageByOI($zoneId, $oLowerDate, $oUpperDate, $badWeeks);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 0);

        $badWeeks = 0;
        $aResult = $oDal->getZonePastImpressionAverageByOI($zoneId, $oLowerDate, $oUpperDate, $badWeeks);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 0);

        // Test with no data in the data_summary_zone_impression_history table
        $aResult = $oDal->getZonePastImpressionAverageByOI($zoneId, $oLowerDate, $oUpperDate, $weeks);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 0);

        // Test with two weeks worth of data that is too old to be used
        $oDate = new Date('2007-08-19 12:00:00');
        $operationIntervalId = OX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $aDates = OX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oDate);

        $doData_summary_zone_impression_history = OA_Dal::factoryDO('data_summary_zone_impression_history');
        $doData_summary_zone_impression_history->operation_interval = 60;
        $doData_summary_zone_impression_history->operation_interval_id = $operationIntervalId;
        $doData_summary_zone_impression_history->interval_start = $aDates['start']->format('%Y-%m-%d %H:%M:%S');
        $doData_summary_zone_impression_history->interval_end = $aDates['end']->format('%Y-%m-%d %H:%M:%S');
        $doData_summary_zone_impression_history->zone_id = 1;
        $doData_summary_zone_impression_history->actual_impressions = 50;
        $id = DataGenerator::generateOne($doData_summary_zone_impression_history);

        $oDate = new Date('2007-08-26 12:00:00');
        $operationIntervalId = OX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $aDates = OX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oDate);

        $doData_summary_zone_impression_history = OA_Dal::factoryDO('data_summary_zone_impression_history');
        $doData_summary_zone_impression_history->operation_interval = 60;
        $doData_summary_zone_impression_history->operation_interval_id = $operationIntervalId;
        $doData_summary_zone_impression_history->interval_start = $aDates['start']->format('%Y-%m-%d %H:%M:%S');
        $doData_summary_zone_impression_history->interval_end = $aDates['end']->format('%Y-%m-%d %H:%M:%S');
        $doData_summary_zone_impression_history->zone_id = 1;
        $doData_summary_zone_impression_history->actual_impressions = 100;
        $id = DataGenerator::generateOne($doData_summary_zone_impression_history);

        $aResult = $oDal->getZonePastImpressionAverageByOI($zoneId, $oLowerDate, $oUpperDate, $weeks);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 0);

        // Test with one weeks worth of data that is in the range
        $oDate = new Date('2007-09-02 12:00:00');
        $operationIntervalId = OX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $aDates = OX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oDate);

        $doData_summary_zone_impression_history = OA_Dal::factoryDO('data_summary_zone_impression_history');
        $doData_summary_zone_impression_history->operation_interval = 60;
        $doData_summary_zone_impression_history->operation_interval_id = $operationIntervalId;
        $doData_summary_zone_impression_history->interval_start = $aDates['start']->format('%Y-%m-%d %H:%M:%S');
        $doData_summary_zone_impression_history->interval_end = $aDates['end']->format('%Y-%m-%d %H:%M:%S');
        $doData_summary_zone_impression_history->zone_id = 1;
        $doData_summary_zone_impression_history->actual_impressions = 200;
        $id = DataGenerator::generateOne($doData_summary_zone_impression_history);

        $aResult = $oDal->getZonePastImpressionAverageByOI($zoneId, $oLowerDate, $oUpperDate, $weeks);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 0);

        // Test with a second weeks worth of data that is in the range
        $oDate = new Date('2007-09-09 12:00:00');
        $operationIntervalId = OX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $aDates = OX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oDate);

        $doData_summary_zone_impression_history = OA_Dal::factoryDO('data_summary_zone_impression_history');
        $doData_summary_zone_impression_history->operation_interval = 60;
        $doData_summary_zone_impression_history->operation_interval_id = $operationIntervalId;
        $doData_summary_zone_impression_history->interval_start = $aDates['start']->format('%Y-%m-%d %H:%M:%S');
        $doData_summary_zone_impression_history->interval_end = $aDates['end']->format('%Y-%m-%d %H:%M:%S');
        $doData_summary_zone_impression_history->zone_id = 1;
        $doData_summary_zone_impression_history->actual_impressions = 300;
        $id = DataGenerator::generateOne($doData_summary_zone_impression_history);

        $aResult = $oDal->getZonePastImpressionAverageByOI($zoneId, $oLowerDate, $oUpperDate, $weeks);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 1);
        $this->assertEqual($aResult[12], 250);

        // Test with another valid set of dates
        $oDate = new Date('2007-09-02 15:00:00');
        $operationIntervalId = OX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $aDates = OX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oDate);

        $doData_summary_zone_impression_history = OA_Dal::factoryDO('data_summary_zone_impression_history');
        $doData_summary_zone_impression_history->operation_interval = 60;
        $doData_summary_zone_impression_history->operation_interval_id = $operationIntervalId;
        $doData_summary_zone_impression_history->interval_start = $aDates['start']->format('%Y-%m-%d %H:%M:%S');
        $doData_summary_zone_impression_history->interval_end = $aDates['end']->format('%Y-%m-%d %H:%M:%S');
        $doData_summary_zone_impression_history->zone_id = 1;
        $doData_summary_zone_impression_history->actual_impressions = 1000;
        $id = DataGenerator::generateOne($doData_summary_zone_impression_history);

        $oDate = new Date('2007-09-09 15:00:00');
        $operationIntervalId = OX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $aDates = OX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oDate);

        $doData_summary_zone_impression_history = OA_Dal::factoryDO('data_summary_zone_impression_history');
        $doData_summary_zone_impression_history->operation_interval = 60;
        $doData_summary_zone_impression_history->operation_interval_id = $operationIntervalId;
        $doData_summary_zone_impression_history->interval_start = $aDates['start']->format('%Y-%m-%d %H:%M:%S');
        $doData_summary_zone_impression_history->interval_end = $aDates['end']->format('%Y-%m-%d %H:%M:%S');
        $doData_summary_zone_impression_history->zone_id = 1;
        $doData_summary_zone_impression_history->actual_impressions = 2000;
        $id = DataGenerator::generateOne($doData_summary_zone_impression_history);

        $aResult = $oDal->getZonePastImpressionAverageByOI($zoneId, $oLowerDate, $oUpperDate, $weeks);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 2);
        $this->assertEqual($aResult[12], 250);
        $this->assertEqual($aResult[15], 1500);

        DataGenerator::cleanUp();

    }
}

?>