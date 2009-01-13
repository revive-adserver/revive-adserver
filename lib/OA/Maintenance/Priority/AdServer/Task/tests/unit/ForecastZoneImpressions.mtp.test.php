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

require_once MAX_PATH . '/lib/OA/Dal/Maintenance/Priority.php';
require_once MAX_PATH . '/lib/OA/Maintenance/Priority/AdServer/Task/ForecastZoneImpressions.php';
require_once MAX_PATH . '/lib/OA/OperationInterval.php';
require_once MAX_PATH . '/lib/OA/ServiceLocator.php';

/**
 * A class for testing the OA_Maintenance_Priority_AdServer_Task_ForecastZoneImpressions class.
 *
 * @package    OpenXMaintenance
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew.hill@openx.org>
 */
class Test_OA_Maintenance_Priority_AdServer_Task_ForecastZoneImpressions extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function Test_OA_Maintenance_Priority_AdServer_Task_ForecastZoneImpressions()
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
        $oServiceLocator =& OA_ServiceLocator::instance();
        $oDalMaintenancePriority =& $oServiceLocator->get('OA_Dal_Maintenance_Priority');
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
        $oServiceLocator =& OA_ServiceLocator::instance();
        $oDalMaintenancePriority =& $oServiceLocator->remove('OA_Dal_Maintenance_Priority');
    }

    /**
     * A method to test the _getUpdateTypeRequired() method.
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
    function test_getUpdateTypeRequired()
    {
        $aConf = $GLOBALS['_MAX']['CONF'];

        // Test 1
        $oTask = new OA_Maintenance_Priority_AdServer_Task_ForecastZoneImpressions();
        $oTask->oStatisticsUpdatedToDate = null;
        $oTask->oPriorityUpdatedToDate   = null;
        $result = $oTask->_getUpdateTypeRequired();
        $this->assertIdentical($result, true);
        unset($oTask);

        // Test 2
        $oTask = new OA_Maintenance_Priority_AdServer_Task_ForecastZoneImpressions();
        $oTask->oStatisticsUpdatedToDate = new Date();
        $oTask->oPriorityUpdatedToDate   = null;
        $result = $oTask->_getUpdateTypeRequired();
        $this->assertIdentical($result, true);
        unset($oTask);

        // Test 3
        $oTask = new OA_Maintenance_Priority_AdServer_Task_ForecastZoneImpressions();
        $oTask->oStatisticsUpdatedToDate = null;
        $oTask->oPriorityUpdatedToDate   = new Date();
        $result = $oTask->_getUpdateTypeRequired();
        $this->assertIdentical($result, true);
        unset($oTask);

        // Test 4
        $oTask = new OA_Maintenance_Priority_AdServer_Task_ForecastZoneImpressions();
        $oTask->oStatisticsUpdatedToDate = new Date();
        $oTask->oPriorityUpdatedToDate   = new Date();
        $testOperationInterval = $aConf['maintenance']['operationInterval'] + 1;
        $oTask->priorityOperationInterval = $testOperationInterval;
        $result = $oTask->_getUpdateTypeRequired();
        $this->assertIdentical($result, true);
        unset($oTask);

        // Test 5
        $oTask = new OA_Maintenance_Priority_AdServer_Task_ForecastZoneImpressions();
        $oDate = new Date();
        $oTask->oDateNow = new Date();$oDate;
        $oTask->oDateNow->copy($oDate);
        $oTask->oStatisticsUpdatedToDate = new Date();
        $oTask->oStatisticsUpdatedToDate->copy($oDate);
        $oDate->addSeconds(1);
        $oTask->oPriorityUpdatedToDate = new Date();
        $oTask->oPriorityUpdatedToDate->copy($oDate);
        $oTask->priorityOperationInterval = $aConf['maintenance']['operationInterval'];
        $result = $oTask->_getUpdateTypeRequired();
        $this->assertIdentical($result, false);
        unset($oTask);

        // Test 6
        $oTask = new OA_Maintenance_Priority_AdServer_Task_ForecastZoneImpressions();
        $oDate = new Date();
        $oTask->oDateNow = new Date();$oDate;
        $oTask->oDateNow->copy($oDate);
        $oTask->oStatisticsUpdatedToDate = new Date();
        $oTask->oStatisticsUpdatedToDate->copy($oDate);
        $oDate->subtractSeconds(SECONDS_PER_WEEK);
        $oTask->oPriorityUpdatedToDate = new Date();
        $oTask->oPriorityUpdatedToDate->copy($oDate);
        $oTask->priorityOperationInterval = $aConf['maintenance']['operationInterval'];
        $result = $oTask->_getUpdateTypeRequired();
        $this->assertIdentical($result, true);
        unset($oTask);

        $oTask = new OA_Maintenance_Priority_AdServer_Task_ForecastZoneImpressions();
        $oDate = new Date();
        $oTask->oDateNow = new Date();$oDate;
        $oTask->oDateNow->copy($oDate);
        $oTask->oStatisticsUpdatedToDate = new Date();
        $oTask->oStatisticsUpdatedToDate->copy($oDate);
        $oDate->subtractSeconds(SECONDS_PER_WEEK + 1);
        $oTask->oPriorityUpdatedToDate = new Date();
        $oTask->oPriorityUpdatedToDate->copy($oDate);
        $oTask->priorityOperationInterval = $aConf['maintenance']['operationInterval'];
        $result = $oTask->_getUpdateTypeRequired();
        $this->assertIdentical($result, true);
        unset($oTask);

        // Test 7
        $oTask = new OA_Maintenance_Priority_AdServer_Task_ForecastZoneImpressions();
        $oDate = new Date('2006-10-10 12:59:59');
        $oTask->oDateNow = $oDate;
        $oTask->oStatisticsUpdatedToDate    = $oDate;
        $oDate = new Date('2006-10-09 12:59:59');
        $oTask->oPriorityUpdatedToDate = $oDate;
        $oTask->priorityOperationInterval = $aConf['maintenance']['operationInterval'];
        $result = $oTask->_getUpdateTypeRequired();
        $this->assertTrue(is_array($result));
        $this->assertEqual($result[0], 36);
        $this->assertEqual($result[1], 61);
        unset($oTask);

        $oTask = new OA_Maintenance_Priority_AdServer_Task_ForecastZoneImpressions();
        $oDate = new Date('2006-10-08 12:59:59');
        $oTask->oDateNow = $oDate;
        $oTask->oStatisticsUpdatedToDate    = $oDate;
        $oDate = new Date('2006-10-07 12:59:59');
        $oTask->oPriorityUpdatedToDate = $oDate;
        $oTask->priorityOperationInterval = $aConf['maintenance']['operationInterval'];
        $result = $oTask->_getUpdateTypeRequired();
        $this->assertTrue(is_array($result));
        $this->assertEqual($result[0], 156);
        $this->assertEqual($result[1], 13);
        unset($oTask);
    }

    /**
     * A method to test the _getOperationIntervalRanges() method.
     *
     * Requirements:
     * Test 1: Test when updating all operation intervals
     * Test 2: Test when updating all operation intervals
     * Test 3: Test when updating a single continuous range
     * Test 4: Test when updating a non-continuous range
     */
    function test_getOperationIntervalRanges()
    {
        $aConf =& $GLOBALS['_MAX']['CONF'];
        $aConf['maintenance']['operationInterval'] = 60;
        $oServiceLocator =& OA_ServiceLocator::instance();
        $intervals = OA_OperationInterval::operationIntervalsPerWeek();

        // Test 1
        $oDate = new Date('2006-10-07 23:07:01');
        $oServiceLocator->register('now', $oDate);
        $oTask = new OA_Maintenance_Priority_AdServer_Task_ForecastZoneImpressions();
        $type = true;
        $result = $oTask->_getOperationIntervalRanges($type);
        $this->assertTrue(is_array($result));
        $this->assertEqual(count($result), 1);
        $this->assertTrue(is_array($result[0]));
        $this->assertEqual(count($result[0]), $intervals);
        $oStartDate = new Date('2006-10-01 00:00:00');
        $oEndDate   = new Date('2006-10-01 00:59:59');
        for ($count = 0; $count < $intervals; $count++) {
            $this->assertEqual($result[0][$count]['start'], $oStartDate);
            $this->assertEqual($result[0][$count]['end'], $oEndDate);
            $oStartDate->addSeconds(SECONDS_PER_HOUR);
            $oEndDate->addSeconds(SECONDS_PER_HOUR);
        }
        unset($oTask);

        $oDate = new Date('2006-10-08 23:07:01');
        $oServiceLocator->register('now', $oDate);
        $oTask = new OA_Maintenance_Priority_AdServer_Task_ForecastZoneImpressions();
        $type = true;
        $result = $oTask->_getOperationIntervalRanges($type);
        $this->assertTrue(is_array($result));
        $this->assertEqual(count($result), 2);
        $this->assertTrue(is_array($result[0]));
        $this->assertTrue(is_array($result[1]));
        $this->assertEqual(count($result[0]) + count($result[1]), $intervals);
        $oStartDate = new Date('2006-10-02 00:00:00');
        $oEndDate   = new Date('2006-10-02 00:59:59');
        for ($count = 24; $count < $intervals; $count++) {
            $this->assertEqual($result[0][$count]['start'], $oStartDate);
            $this->assertEqual($result[0][$count]['end'], $oEndDate);
            $oStartDate->addSeconds(SECONDS_PER_HOUR);
            $oEndDate->addSeconds(SECONDS_PER_HOUR);
        }
        for ($count = 0; $count < count($result[1]); $count++) {
            $this->assertEqual($result[1][$count]['start'], $oStartDate);
            $this->assertEqual($result[1][$count]['end'], $oEndDate);
            $oStartDate->addSeconds(SECONDS_PER_HOUR);
            $oEndDate->addSeconds(SECONDS_PER_HOUR);
        }
        unset($oTask);

        // Test 2
        $oDate = new Date('2006-10-07 23:07:01');
        $oServiceLocator->register('now', $oDate);
        $oTask = new OA_Maintenance_Priority_AdServer_Task_ForecastZoneImpressions();
        $type = false;
        $result = $oTask->_getOperationIntervalRanges($type);
        $this->assertTrue(is_array($result));
        $this->assertEqual(count($result), 0);
        unset($oTask);

        $oDate = new Date('2006-10-08 23:07:01');
        $oServiceLocator->register('now', $oDate);
        $oTask = new OA_Maintenance_Priority_AdServer_Task_ForecastZoneImpressions();
        $type = false;
        $result = $oTask->_getOperationIntervalRanges($type);
        $this->assertTrue(is_array($result));
        $this->assertEqual(count($result), 0);
        unset($oTask);

        // Test 3
        $oDate = new Date('2006-10-07 23:07:01');
        $oServiceLocator->register('now', $oDate);
        $oTask = new OA_Maintenance_Priority_AdServer_Task_ForecastZoneImpressions();
        $oTask->oPriorityUpdatedToDate = new Date('2006-10-08 00:59:59');
        $oTask->oPriorityUpdatedToDate->addSeconds(23 * OA_OperationInterval::secondsPerOperationInterval());
        $type = array(23, 56);
        $result = $oTask->_getOperationIntervalRanges($type);
        $this->assertTrue(is_array($result));
        $this->assertEqual(count($result), 1);
        $this->assertTrue(is_array($result[0]));
        $this->assertEqual(count($result[0]), 33);
        $oStartDate = new Date('2006-10-09 00:00:00');
        $oEndDate   = new Date('2006-10-09 00:59:59');
        for ($count = 24; $count < 57; $count++) {
            $this->assertEqual($result[0][$count]['start'], $oStartDate);
            $this->assertEqual($result[0][$count]['end'], $oEndDate);
            $oStartDate->addSeconds(SECONDS_PER_HOUR);
            $oEndDate->addSeconds(SECONDS_PER_HOUR);
        }
        unset($oTask);

        // Test 4
        $oDate = new Date('2006-10-08 23:07:01');
        $oServiceLocator->register('now', $oDate);
        $oTask = new OA_Maintenance_Priority_AdServer_Task_ForecastZoneImpressions();
        $oTask->oPriorityUpdatedToDate = new Date('2006-10-01 00:59:59');
        $oTask->oPriorityUpdatedToDate->addSeconds(112 * OA_OperationInterval::secondsPerOperationInterval());
        $type = array(112, 23);
        $result = $oTask->_getOperationIntervalRanges($type);
        $this->assertTrue(is_array($result));
        $this->assertEqual(count($result), 2);
        $this->assertTrue(is_array($result[0]));
        $this->assertEqual(count($result[0]), 55);
        $this->assertTrue(is_array($result[1]));
        $this->assertEqual(count($result[1]), 24);
        $oStartDate = new Date('2006-10-05 17:00:00');
        $oEndDate   = new Date('2006-10-05 17:59:59');
        for ($count = 113; $count < 168; $count++) {
            $this->assertEqual($result[0][$count]['start'], $oStartDate);
            $this->assertEqual($result[0][$count]['end'], $oEndDate);
            $oStartDate->addSeconds(SECONDS_PER_HOUR);
            $oEndDate->addSeconds(SECONDS_PER_HOUR);
        }
        for ($count = 0; $count < 24; $count++) {
            $this->assertEqual($result[1][$count]['start'], $oStartDate);
            $this->assertEqual($result[1][$count]['end'], $oEndDate);
            $oStartDate->addSeconds(SECONDS_PER_HOUR);
            $oEndDate->addSeconds(SECONDS_PER_HOUR);
        }
        unset($oTask);

        TestEnv::restoreConfig();
    }

}

?>