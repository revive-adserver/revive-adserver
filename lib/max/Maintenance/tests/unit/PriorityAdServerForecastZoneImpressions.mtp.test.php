<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
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

require_once MAX_PATH . '/lib/max/core/ServiceLocator.php';
require_once MAX_PATH . '/lib/max/Maintenance/Priority/AdServer/Task/ForecastZoneImpressions.php';
require_once MAX_PATH . '/lib/max/Maintenance/Priority/Entities.php';
require_once MAX_PATH . '/lib/max/OperationInterval.php';

require_once MAX_PATH . '/lib/OA/Dal/Maintenance/Priority.php';

/**
 * A class for testing the Maintenance_Priority_DeliveryLimitation class.
 *
 * @package    MaxMaintenance
 * @subpackage TestSuite
 * @author     Andrew Hill   <andrew@m3.net>
 * @author     Demian Turner <demian@m3.net>
 */
class TestOfPriorityAdserverForecastZoneImpressions extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function TestOfPriorityAdserverForecastZoneImpressions()
    {
        $this->UnitTestCase();
        Mock::generate('OA_Dal_Maintenance_Priority');
    }

    /**
     * A method to register a mock of the OA_Dal_Maintenance_Priority
     * class in the service locator at the start of every test.
     */
    function setUp()
    {
        $oServiceLocator = &ServiceLocator::instance();
        $oDalMaintenancePriority = &$oServiceLocator->get('OA_Dal_Maintenance_Priority');
        if (!is_a($oDalMaintenancePriority, 'MockOA_Dal_Maintenance_Priority')) {
            $oDalMaintenancePriority = new MockOA_Dal_Maintenance_Priority($this);
            $oServiceLocator->register('OA_Dal_Maintenance_Priority', $oDalMaintenancePriority);
        }
    }

    /**
     * A method to de-register the mock of the OA_Dal_Maintenance_Priority
     * class in the service locator at the end of every test.
     */
    function tearDown()
    {
        $oServiceLocator = &ServiceLocator::instance();
        $oDalMaintenancePriority = &$oServiceLocator->remove('OA_Dal_Maintenance_Priority');
    }

    /**
     * A method to test the getUpdateTypeRequired() method.
     *
     * Requirements:
     * Test 1: Test when mtceStatsLastRun date is null, mtcePriorityLastRun is null
     * Test 2: Test when mtceStatsLastRun date is not null, mtcePriorityLastRun is null
     * Test 3: Test when mtceStatsLastRun date is null, mtcePriorityLastRun is not null
     * Test 4: Test when mtceStatsLastRun, mtcePriorityLastRun is not null, but current
     *         and past operation intervals differ
     * Test 5: Test that when stats last updated before priority last updated, false
     *         is returned
     * Test 6: Test that when stats last updated 7 or more days after priority last
     *         updated, true is returned
     * Test 7: Test that when stats last updated after priority last update, but
     *         less than 7 days after, the correct array(s) are returned
     */
    function testGetUpdateTypeRequired()
    {
        $conf = $GLOBALS['_MAX']['CONF'];

        // Test 1
        $oTask = new ForecastZoneImpressions();
        $oTask->mtceStatsLastRun->oUpdatedToDate    = null;
        $oTask->mtcePriorityLastRun->oUpdatedToDate = null;
        $result = $oTask->getUpdateTypeRequired();
        $this->assertIdentical($result, true);
        unset($oTask);

        // Test 2
        $oTask = new ForecastZoneImpressions();
        $oTask->mtceStatsLastRun->oUpdatedToDate    = new Date();
        $oTask->mtcePriorityLastRun->oUpdatedToDate = null;
        $result = $oTask->getUpdateTypeRequired();
        $this->assertIdentical($result, true);
        unset($oTask);

        // Test 3
        $oTask = new ForecastZoneImpressions();
        $oTask->mtceStatsLastRun->oUpdatedToDate    = null;
        $oTask->mtcePriorityLastRun->oUpdatedToDate = new Date();
        $result = $oTask->getUpdateTypeRequired();
        $this->assertIdentical($result, true);
        unset($oTask);

        // Test 4
        $oTask = new ForecastZoneImpressions();
        $oTask->mtceStatsLastRun->oUpdatedToDate    = new Date();
        $oTask->mtcePriorityLastRun->oUpdatedToDate = new Date();
        $testOperationInterval = $conf['maintenance']['operationInterval'] + 1;
        $oTask->mtcePriorityLastRun->operationInt = $testOperationInterval;
        $result = $oTask->getUpdateTypeRequired();
        $this->assertIdentical($result, true);
        unset($oTask);

        // Test 5
        $oTask = new ForecastZoneImpressions();
        $oDate = new Date();
        $oTask->oDateNow = new Date();$oDate;
        $oTask->oDateNow->copy($oDate);
        $oTask->mtceStatsLastRun->oUpdatedToDate = new Date();
        $oTask->mtceStatsLastRun->oUpdatedToDate->copy($oDate);
        $oDate->addSeconds(1);
        $oTask->mtcePriorityLastRun->oUpdatedToDate = new Date();
        $oTask->mtcePriorityLastRun->oUpdatedToDate->copy($oDate);
        $oTask->mtcePriorityLastRun->operationInt = $conf['maintenance']['operationInterval'];
        $result = $oTask->getUpdateTypeRequired();
        $this->assertIdentical($result, false);
        unset($oTask);

        // Test 6
        $oTask = new ForecastZoneImpressions();
        $oDate = new Date();
        $oTask->oDateNow = new Date();$oDate;
        $oTask->oDateNow->copy($oDate);
        $oTask->mtceStatsLastRun->oUpdatedToDate = new Date();
        $oTask->mtceStatsLastRun->oUpdatedToDate->copy($oDate);
        $oDate->subtractSeconds(SECONDS_PER_WEEK);
        $oTask->mtcePriorityLastRun->oUpdatedToDate = new Date();
        $oTask->mtcePriorityLastRun->oUpdatedToDate->copy($oDate);
        $oTask->mtcePriorityLastRun->operationInt = $conf['maintenance']['operationInterval'];
        $result = $oTask->getUpdateTypeRequired();
        $this->assertIdentical($result, true);
        unset($oTask);

        $oTask = new ForecastZoneImpressions();
        $oDate = new Date();
        $oTask->oDateNow = new Date();$oDate;
        $oTask->oDateNow->copy($oDate);
        $oTask->mtceStatsLastRun->oUpdatedToDate = new Date();
        $oTask->mtceStatsLastRun->oUpdatedToDate->copy($oDate);
        $oDate->subtractSeconds(SECONDS_PER_WEEK + 1);
        $oTask->mtcePriorityLastRun->oUpdatedToDate = new Date();
        $oTask->mtcePriorityLastRun->oUpdatedToDate->copy($oDate);
        $oTask->mtcePriorityLastRun->operationInt = $conf['maintenance']['operationInterval'];
        $result = $oTask->getUpdateTypeRequired();
        $this->assertIdentical($result, true);
        unset($oTask);

        // Test 7
        $oTask = new ForecastZoneImpressions();
        $oDate = new Date('2006-10-10 12:59:59');
        $oTask->oDateNow = $oDate;
        $oTask->mtceStatsLastRun->oUpdatedToDate    = $oDate;
        $oDate = new Date('2006-10-09 12:59:59');
        $oTask->mtcePriorityLastRun->oUpdatedToDate = $oDate;
        $oTask->mtcePriorityLastRun->operationInt = $conf['maintenance']['operationInterval'];
        $result = $oTask->getUpdateTypeRequired();
        $this->assertTrue(is_array($result));
        $this->assertEqual($result[0], 36);
        $this->assertEqual($result[1], 61);
        unset($oTask);

        $oTask = new ForecastZoneImpressions();
        $oDate = new Date('2006-10-08 12:59:59');
        $oTask->oDateNow = $oDate;
        $oTask->mtceStatsLastRun->oUpdatedToDate    = $oDate;
        $oDate = new Date('2006-10-07 12:59:59');
        $oTask->mtcePriorityLastRun->oUpdatedToDate = $oDate;
        $oTask->mtcePriorityLastRun->operationInt = $conf['maintenance']['operationInterval'];
        $result = $oTask->getUpdateTypeRequired();
        $this->assertTrue(is_array($result));
        $this->assertEqual($result[0], 156);
        $this->assertEqual($result[1], 13);
        unset($oTask);
    }

    /**
     * A method to test the getOperationIntRangeByType() method.
     *
     * Requirements:
     * Test 1: Test when updating all operation intervals
     * Test 2: Test when updating a single continuous range
     * Test 3: Test when updating a non-continuous range
     */
    function testGetOperationIntRangeByType()
    {
        $conf = &$GLOBALS['_MAX']['CONF'];
        $conf['maintenance']['operationInterval'] = 60;
        $oServiceLocator = &ServiceLocator::instance();
        $intervals = MAX_OperationInterval::operationIntervalsPerWeek();

        // Test 1
        $oDate = new Date('2006-10-07 23:07:01');
        $oServiceLocator->register('now', $oDate);
        $oTask = new ForecastZoneImpressions();
        $type = true;
        $result = $oTask->getOperationIntRangeByType($type);
        $this->assertTrue(is_array($result));
        $this->assertEqual(count($result), 1);
        $this->assertTrue(is_array($result[0]));
        $this->assertEqual(count($result[0]), $intervals);
        $oStartDate = new Date('2006-10-01 00:00:00');
        $oEndDate   = new Date('2006-10-01 00:59:59');
        for ($count = 0; $count < $intervals; $count++) {
            $this->assertEqual($result[0][$count]['start'], $oStartDate->format('%Y-%m-%d %H:%M:%S'));
            $this->assertEqual($result[0][$count]['end'], $oEndDate->format('%Y-%m-%d %H:%M:%S'));
            $oStartDate->addSeconds(SECONDS_PER_HOUR);
            $oEndDate->addSeconds(SECONDS_PER_HOUR);
        }
        unset($oTask);

        $oDate = new Date('2006-10-08 23:07:01');
        $oServiceLocator->register('now', $oDate);
        $oTask = new ForecastZoneImpressions();
        $type = true;
        $result = $oTask->getOperationIntRangeByType($type);
        $this->assertTrue(is_array($result));
        $this->assertEqual(count($result), 2);
        $this->assertTrue(is_array($result[0]));
        $this->assertTrue(is_array($result[1]));
        $this->assertEqual(count($result[0]) + count($result[1]), $intervals);
        $oStartDate = new Date('2006-10-02 00:00:00');
        $oEndDate   = new Date('2006-10-02 00:59:59');
        for ($count = 24; $count < $intervals; $count++) {
            $this->assertEqual($result[0][$count]['start'], $oStartDate->format('%Y-%m-%d %H:%M:%S'));
            $this->assertEqual($result[0][$count]['end'], $oEndDate->format('%Y-%m-%d %H:%M:%S'));
            $oStartDate->addSeconds(SECONDS_PER_HOUR);
            $oEndDate->addSeconds(SECONDS_PER_HOUR);
        }
        for ($count = 0; $count < count($result[1]); $count++) {
            $this->assertEqual($result[1][$count]['start'], $oStartDate->format('%Y-%m-%d %H:%M:%S'));
            $this->assertEqual($result[1][$count]['end'], $oEndDate->format('%Y-%m-%d %H:%M:%S'));
            $oStartDate->addSeconds(SECONDS_PER_HOUR);
            $oEndDate->addSeconds(SECONDS_PER_HOUR);
        }
        unset($oTask);

        // Test 2
        $oDate = new Date('2006-10-07 23:07:01');
        $oServiceLocator->register('now', $oDate);
        $oTask = new ForecastZoneImpressions();
        $oTask->mtcePriorityLastRun->oUpdatedToDate = new Date('2006-10-08 00:59:59');
        $oTask->mtcePriorityLastRun->oUpdatedToDate->addSeconds(23 * MAX_OperationInterval::secondsPerOperationInterval());
        $type = array(23, 56);
        $result = $oTask->getOperationIntRangeByType($type);
        $this->assertTrue(is_array($result));
        $this->assertEqual(count($result), 1);
        $this->assertTrue(is_array($result[0]));
        $this->assertEqual(count($result[0]), 33);
        $oStartDate = new Date('2006-10-09 00:00:00');
        $oEndDate   = new Date('2006-10-09 00:59:59');
        for ($count = 24; $count < 57; $count++) {
            $this->assertEqual($result[0][$count]['start'], $oStartDate->format('%Y-%m-%d %H:%M:%S'));
            $this->assertEqual($result[0][$count]['end'], $oEndDate->format('%Y-%m-%d %H:%M:%S'));
            $oStartDate->addSeconds(SECONDS_PER_HOUR);
            $oEndDate->addSeconds(SECONDS_PER_HOUR);
        }
        unset($oTask);

        // Test 3
        $oDate = new Date('2006-10-08 23:07:01');
        $oServiceLocator->register('now', $oDate);
        $oTask = new ForecastZoneImpressions();
        $oTask->mtcePriorityLastRun->oUpdatedToDate = new Date('2006-10-01 00:59:59');
        $oTask->mtcePriorityLastRun->oUpdatedToDate->addSeconds(112 * MAX_OperationInterval::secondsPerOperationInterval());
        $type = array(112, 23);
        $result = $oTask->getOperationIntRangeByType($type);
        $this->assertTrue(is_array($result));
        $this->assertEqual(count($result), 2);
        $this->assertTrue(is_array($result[0]));
        $this->assertEqual(count($result[0]), 55);
        $this->assertTrue(is_array($result[1]));
        $this->assertEqual(count($result[1]), 24);
        $oStartDate = new Date('2006-10-05 17:00:00');
        $oEndDate   = new Date('2006-10-05 17:59:59');
        for ($count = 113; $count < 168; $count++) {
            $this->assertEqual($result[0][$count]['start'], $oStartDate->format('%Y-%m-%d %H:%M:%S'));
            $this->assertEqual($result[0][$count]['end'], $oEndDate->format('%Y-%m-%d %H:%M:%S'));
            $oStartDate->addSeconds(SECONDS_PER_HOUR);
            $oEndDate->addSeconds(SECONDS_PER_HOUR);
        }
        for ($count = 0; $count < 24; $count++) {
            $this->assertEqual($result[1][$count]['start'], $oStartDate->format('%Y-%m-%d %H:%M:%S'));
            $this->assertEqual($result[1][$count]['end'], $oEndDate->format('%Y-%m-%d %H:%M:%S'));
            $oStartDate->addSeconds(SECONDS_PER_HOUR);
            $oEndDate->addSeconds(SECONDS_PER_HOUR);
        }
        unset($oTask);

        TestEnv::restoreConfig();
    }

    /**
     * A method for testing the calculateForecast() method.
     *
     * Requirements:
     * Test 1: Test with no values in the zone
     * Test 2: Test with past actual impressions only, less than or equal to zero
     * Test 3: Test with past actual impressions only, greater than zero
     * Test 4: Test with past actual impressions and set past average impressions
     * Test 5: Test as 4, but also with forecastImpressions, but no actualImpressions
     * Test 6: Test as 4, but also with actualImpressions, but no forecastImpressions
     * Test 7: Test as 4, but also with forecastImpressions and actualImpressions
     */
    function testCalculateForecast()
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $oTask = new ForecastZoneImpressions();

        // Test 1
        $oZone = new Zone();
        $result = $oTask->calculateForecast($oZone, 0);
        $this->assertEqual($result, $conf['priority'][defaultZoneForecastImpressions]);
        unset($oZone);

        // Test 2
        $oZone = new Zone();
        $oZone->pastActualImpressions = -1;
        $result = $oTask->calculateForecast($oZone, 0);
        $this->assertEqual($result, $conf['priority'][defaultZoneForecastImpressions]);
        unset($oZone);

        $oZone = new Zone();
        $oZone->pastActualImpressions = 0;
        $result = $oTask->calculateForecast($oZone, 0);
        $this->assertEqual($result, $conf['priority'][defaultZoneForecastImpressions]);
        unset($oZone);

        // Test 3
        $oZone = new Zone();
        $oZone->pastActualImpressions = 1;
        $result = $oTask->calculateForecast($oZone, 0);
        $this->assertEqual($result, 1);
        unset($oZone);

        // Test 4
        $oZone = new Zone();
        $oZone->pastActualImpressions = 1;
        $oZone->aOperationIntId[1]['averageImpressions'] = 5;
        $result = $oTask->calculateForecast($oZone, 0);
        $this->assertEqual($result, 1);
        unset($oZone);

        $oZone = new Zone();
        $oZone->pastActualImpressions = 1;
        $oZone->aOperationIntId[1]['averageImpressions'] = 5;
        $result = $oTask->calculateForecast($oZone, 1);
        $this->assertEqual($result, 5);
        unset($oZone);

        // Test 5
        $oZone = new Zone();
        $oZone->pastActualImpressions = 1;
        $oZone->aOperationIntId[1]['averageImpressions'] = 5;
        $oZone->aOperationIntId[1]['forecastImpressions'] = 50;
        $result = $oTask->calculateForecast($oZone, 0);
        $this->assertEqual($result, 1);
        unset($oZone);

        $oZone = new Zone();
        $oZone->pastActualImpressions = 1;
        $oZone->aOperationIntId[1]['averageImpressions'] = 5;
        $oZone->aOperationIntId[1]['forecastImpressions'] = 50;
        $result = $oTask->calculateForecast($oZone, 1);
        $this->assertEqual($result, 5);
        unset($oZone);

        // Test 6
        $oZone = new Zone();
        $oZone->pastActualImpressions = 1;
        $oZone->aOperationIntId[1]['averageImpressions'] = 5;
        $oZone->aOperationIntId[1]['actualImpressions'] = 150;
        $result = $oTask->calculateForecast($oZone, 0);
        $this->assertEqual($result, 1);
        unset($oZone);

        $oZone = new Zone();
        $oZone->pastActualImpressions = 1;
        $oZone->aOperationIntId[1]['averageImpressions'] = 5;
        $oZone->aOperationIntId[1]['actualImpressions'] = 150;
        $result = $oTask->calculateForecast($oZone, 1);
        $this->assertEqual($result, 5);
        unset($oZone);

        // Test 7
        $oZone = new Zone();
        $oZone->pastActualImpressions = 1;
        $oZone->aOperationIntId[1]['averageImpressions'] = 5;
        $oZone->aOperationIntId[1]['actualImpressions'] = 150;
        $oZone->aOperationIntId[1]['forecastImpressions'] = 50;
        $result = $oTask->calculateForecast($oZone, 0);
        $this->assertEqual($result, 1);
        unset($oZone);

        $oZone = new Zone();
        $oZone->pastActualImpressions = 1;
        $oZone->aOperationIntId[1]['averageImpressions'] = 5;
        $oZone->aOperationIntId[1]['actualImpressions'] = 150;
        $oZone->aOperationIntId[1]['forecastImpressions'] = 50;
        $result = $oTask->calculateForecast($oZone, 1);
        $this->assertEqual($result, 15);
        unset($oZone);
    }

    /**
     * A method for testing the getActiveZones() method.
     *
     * Reqirements: Test that the class correctly converts DAL data into classes
     */
    function testGetActiveZones()
    {
        // Prepare a set of zone information to turn into classes
        $aTestZones = array(
            array('zoneid' => 1),
            array('zoneid' => 2),
            array('zoneid' => 3),
            array('zoneid' => 4),
        );

        // Mock the OA_Dal_Maintenance_Priority class
        $oDalMaintenancePriority = new MockOA_Dal_Maintenance_Priority($this);

        // Set the return values for the mocked OA_Dal_Maintenance_Priority
        $oDalMaintenancePriority->setReturnValue('getActiveZones', $aTestZones);

        // Register the mocked OA_Dal_Maintenance_Priority in the service locator
        $oServiceLocator = &ServiceLocator::instance();
        $oServiceLocator->register('OA_Dal_Maintenance_Priority', $oDalMaintenancePriority);

        // Get the task, and test
        $oTask = new ForecastZoneImpressions();
        $aResult = $oTask->getActiveZones();
        foreach ($aResult as $key => $oZone) {
            $this->assertIsA($oZone, 'Zone');
            $this->assertEqual($oZone->id, ($key + 1));
        }
    }

    /**
     * A method for testing the setZonesImpressionAverage() method.
     *
     * Requirements: Ensure that the method sets average impression values in zone objects.
     */
    function testSetZonesImpressionAverage()
    {
        // Prepare an array of Zones
        $aZone[] = new Zone(array('zoneid' => 1));
        $aZone[] = new Zone(array('zoneid' => 2));

        // Prepare return data for the OA_Dal_Maintenance_Priority's
        // getZonesImpressionAverageByRange() method.
        $aGetZonesImpressionAverageByRange = array(
            1 => array(
                0 => array('average_impressions' => 100),
                1 => array('average_impressions' => 200),
                2 => array('average_impressions' => 300),
            ),
            2 => array(
                0 => array('average_impressions' => 200),
                1 => array('average_impressions' => 400),
                2 => array('average_impressions' => 600),
            )
        );

        // Mock the OA_Dal_Maintenance_Priority class
        $oDalMaintenancePriority = new MockOA_Dal_Maintenance_Priority($this);

        // Set the return values for the mocked OA_Dal_Maintenance_Priority
        $oDalMaintenancePriority->setReturnValue(
            'getZonesImpressionAverageByRange',
            $aGetZonesImpressionAverageByRange
        );

        // Register the mocked OA_Dal_Maintenance_Priority in the service locator
        $oServiceLocator = &ServiceLocator::instance();
        $oServiceLocator->register('OA_Dal_Maintenance_Priority', $oDalMaintenancePriority);

        // Prepare start and end dates
        $oStart = new Date('2005-01-01 00:00:00');
        $oEnd   = new Date('2005-01-01 02:00:00');

        // Get the task, and test
        $oTask = new ForecastZoneImpressions();
        $oTask->setZonesImpressionAverage($aZone, $oStart, $oEnd);
        foreach ($aZone as $key => $oZone) {
            $this->assertEqual($oZone->aOperationIntId[0]['averageImpressions'], (($key + 1) * 100));
            $this->assertEqual($oZone->aOperationIntId[1]['averageImpressions'], (($key + 1) * 200));
            $this->assertEqual($oZone->aOperationIntId[2]['averageImpressions'], (($key + 1) * 300));
        }
    }

    /**
     * A method to test the getTrendOperationIntervalStartOffset() method.
     *
     * Requirements: Test that the value returned is both not zero, and correct.
     */
    function testGetTrendOperationIntervalStartOffset()
    {
        $oTask = new ForecastZoneImpressions();
        $offsetStart = (ZONE_FORECAST_TREND_OFFSET + ZONE_FORECAST_TREND_OPERATION_INTERVALS - 1);
        $result = $oTask->getTrendOperationIntervalStartOffset();
        $this->assertEqual($result, $offsetStart);
        $this->assertNotEqual($result, 0);
    }

    /**
     * A method to test the getTrendStartDate() method.
     *
     * @TODO Not implemented.
     */
    function testGetTrendStartDate() {}

    /**
     * A method to test the getTrendEndDate() method.
     *
     * @TODO Not implemented.
     */
    function testGetTrendEndDate() {}

}

?>
