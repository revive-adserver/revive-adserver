<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.5                                                              |
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

require_once MAX_PATH . '/lib/max/Maintenance/tests/integration/MaintenancePriorityAdServer.php';

/**
 * A class for performing an integration test of the Prioritisation Engine
 * via a test of the AdServer class.
 *
 * @package    MaxMaintenance
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew.hill@openads.org>
 */
class Maintenance_TestOfMaintenancePriorityAdServerBasic extends Maintenance_TestOfMaintenancePriorityAdServer
{

    /**
     * The constructor method.
     */
    function Maintenance_TestOfMaintenancePriorityAdServer()
    {
        $this->UnitTestCase();
    }

    /**
     * A method to perform basic end-to-end integration testing of the Maintenance
     * Priority Engine classes for the Ad Server.
     *
     * Test 0: Test that no zone forecast or priority data exists to begin with.
     * Test 1: Run the MPE without any stats, and without the stats engine ever
     *         having been run before. Test that zone forecasts are updated
     *         with the appropriate values, and that the correct priorities are
     *         generated.
     * Test 2: Run the MPE without any stats, but with the stats engine having
     *         reported that it has run. Test that zone forecasts are updated
     *         with the appropriate values, and that the correct priorities are
     *         generated.
     * Test 3: Run the MPE again, as for Test 2, but with a later date used as
     *         for when the stats engine reported having run.
     */
    function testAdServer()
    {
        // Test 0: Ensure no data in the data_summary_zone_impression_history table
        $this->assertEqual($this->_dszihRows(), 0);
        // Test 0: Ensure correct number of links in the ad_zone_assoc table
        $this->assertEqual($this->_azaRows(), 7); // 4 proper associations + 3 default with zone 0
        // Test 0: Ensure no links in the ad_zone_assoc table have priority > 0
        $this->assertEqual($this->_azaRows(true), 0);
        // Test 0: Ensure no links in the data_summary_ad_zone_assoc table have priority > 0
        $this->assertEqual($this->_dsazaRows(true), 0);
        // Test 0: Ensure no data in the log_maintenance_priority table
        $this->_assertLogMaintenance();

        // Test 1: Set "current" date for the MPE run
        $oDate = new Date('2005-06-15 13:01:01');
        $this->oServiceLocator->register('now', $oDate);
        // Test 1: Prepare the MPE object
        $oMaintenancePriority = new MAX_Maintenance_Priority_AdServer();
        // Test 1: Store the date before the MPE runs
        $oTest1BeforeUpdateDate = new Date();
        sleep(1); // Ensure that next date is at least 1 second after above...
        // Test 1: Run the MPE
        $oMaintenancePriority->updatePriorities();
        // Test 1: Store the date after the MPE runs
        sleep(1); // Ensure that next date is at least 1 second after above...
        $oTest1AfterUpdateDate = new Date();
        // Test 1: Ensure one row in the data_summary_zone_impression_history table per zone
        //         and operation interval covered so far by the MPE
        $this->assertEqual($this->_dszihRows(), $this->intervalsPerWeek * 4);
        // Test 1: Ensure that the rows in the data_summary_zone_impression_history table
        //         are corect
        $oStartDate = new Date('2005-06-08 14:00:00');
        $oEndDate   = new Date('2005-06-11 23:00:00');
        $this->_validateDszihRowsRange($oStartDate, $oEndDate);
        $oStartDate = new Date('2005-06-12 00:00:00');
        $oEndDate   = new Date('2005-06-15 13:00:00');
        $this->_validateDszihRowsRange($oStartDate, $oEndDate);
        // Test 1: Ensure correct number of links in the ad_zone_assoc table
        $this->assertEqual($this->_azaRows(), 7); // 4 proper associations + 3 default with zone 0
        // Test 1: Ensure correct number if links in the ad_zone_assoc table with priority > 0
        $this->assertEqual($this->_azaRows(true), 7);
        // Test 1: Ensure correct number if links in the data_summary_ad_zone_assoc table with priority > 0
        $this->assertEqual($this->_dsazaRows(true), 7);
        // Test 1: Ensure that the priorities in the ad_zone_assoc and data_summary_ad_zone_assoc
        // tables are set correctly
        $aTestOneZero = array();
        $aTestOneZero['ad_id']           = 1;
        $aTestOneZero['zone_id']         = 0;
        $aTestOneZero['priority']        = 11 / 29;
        $aTestOneZero['priority_factor'] = 1;          // Initial priority run, factor starts at 1
        $aTestOneZero['history'][0]      = array(
            'operation_interval'         => 60,
            'operation_interval_id'      => 85,
            'interval_start'             => '2005-06-15 13:00:00',
            'interval_end'               => '2005-06-15 13:59:59',
            'required_impressions'       => 11,
            'requested_impressions'      => 11,
            'priority'                   => 11 / 29,
            'priority_factor'            => 1,         // Initial priority run, factor starts at 1
            'past_zone_traffic_fraction' => null
        );
        $this->_assertPriority($aTestOneZero);
        $aTestTwoZero = array();
        $aTestTwoZero['ad_id']           = 2;
        $aTestTwoZero['zone_id']         = 0;
        $aTestTwoZero['priority']        = 12 / 29;
        $aTestTwoZero['priority_factor'] = 1;          // Initial priority run, factor starts at 1
        $aTestTwoZero['history'][0]      = array(
            'operation_interval'         => 60,
            'operation_interval_id'      => 85,
            'interval_start'             => '2005-06-15 13:00:00',
            'interval_end'               => '2005-06-15 13:59:59',
            'required_impressions'       => 12,
            'requested_impressions'      => 12,
            'priority'                   => 12 / 29,
            'priority_factor'            => 1,         // Initial priority run, factor starts at 1
            'past_zone_traffic_fraction' => null
        );
        $this->_assertPriority($aTestTwoZero);
        $aTestThreeZero = array();
        $aTestThreeZero['ad_id']           = 3;
        $aTestThreeZero['zone_id']         = 0;
        $aTestThreeZero['priority']        = 6 / 29;
        $aTestThreeZero['priority_factor'] = 1;        // Initial priority run, factor starts at 1
        $aTestThreeZero['history'][0]      = array(
            'operation_interval'         => 60,
            'operation_interval_id'      => 85,
            'interval_start'             => '2005-06-15 13:00:00',
            'interval_end'               => '2005-06-15 13:59:59',
            'required_impressions'       => 6,
            'requested_impressions'      => 6,
            'priority'                   => 6 / 29,
            'priority_factor'            => 1,         // Initial priority run, factor starts at 1
            'past_zone_traffic_fraction' => null
        );
        $this->_assertPriority($aTestThreeZero);
        $aTestOneOne = array();
        $aTestOneOne['ad_id']           = 1;
        $aTestOneOne['zone_id']         = 1;
        $aTestOneOne['priority']        = 0.9;         // Constant, only priority_factor increases
        $aTestOneOne['priority_factor'] = 1;           // Initial priority run, factor starts at 1
        $aTestOneOne['history'][0]      = array(
            'operation_interval'         => 60,
            'operation_interval_id'      => 85,
            'interval_start'             => '2005-06-15 13:00:00',
            'interval_end'               => '2005-06-15 13:59:59',
            'required_impressions'       => 11,
            'requested_impressions'      => 9,
            'priority'                   => 0.9,       // Constant, only priority_factor increases
            'priority_factor'            => 1,         // Initial priority run, factor starts at 1
            'past_zone_traffic_fraction' => null
        );
        $this->_assertPriority($aTestOneOne);
        $aTestTwoThree = array();
        $aTestTwoThree['ad_id']           = 2;
        $aTestTwoThree['zone_id']         = 3;
        $aTestTwoThree['priority']        = 0.7;       // Constant, only priority_factor increases
        $aTestTwoThree['priority_factor'] = 1;         // Initial priority run, factor starts at 1
        $aTestTwoThree['history'][0]      = array(
            'operation_interval'         => 60,
            'operation_interval_id'      => 85,
            'interval_start'             => '2005-06-15 13:00:00',
            'interval_end'               => '2005-06-15 13:59:59',
            'required_impressions'       => 12,
            'requested_impressions'      => 7,
            'priority'                   => 0.7,       // Constant, only priority_factor increases
            'priority_factor'            => 1,         // Initial priority run, factor starts at 1
            'past_zone_traffic_fraction' => null
        );
        $this->_assertPriority($aTestTwoThree);
        $aTestThreeThree = array();
        $aTestThreeThree['ad_id']           = 3;
        $aTestThreeThree['zone_id']         = 3;
        $aTestThreeThree['priority']        = 0.2;     // Constant, only priority_factor increases
        $aTestThreeThree['priority_factor'] = 1;       // Initial priority run, factor starts at 1
        $aTestThreeThree['history'][0]      = array(
            'operation_interval'         => 60,
            'operation_interval_id'      => 85,
            'interval_start'             => '2005-06-15 13:00:00',
            'interval_end'               => '2005-06-15 13:59:59',
            'required_impressions'       => 3,
            'requested_impressions'      => 2,
            'priority'                   => 0.2,       // Constant, only priority_factor increases
            'priority_factor'            => 1,         // Initial priority run, factor starts at 1
            'past_zone_traffic_fraction' => null
        );
        $this->_assertPriority($aTestThreeThree);
        $aTestThreeFour = array();
        $aTestThreeFour['ad_id']           = 3;
        $aTestThreeFour['zone_id']         = 4;
        $aTestThreeFour['priority']        = 0.3;      // Constant, only priority_factor increases
        $aTestThreeFour['priority_factor'] = 1;        // Initial priority run, factor starts at 1
        $aTestThreeFour['history'][0]      = array(
            'operation_interval'         => 60,
            'operation_interval_id'      => 85,
            'interval_start'             => '2005-06-15 13:00:00',
            'interval_end'               => '2005-06-15 13:59:59',
            'required_impressions'       => 3,
            'requested_impressions'      => 3,
            'priority'                   => 0.3,       // Constant, only priority_factor increases
            'priority_factor'            => 1,         // Initial priority run, factor starts at 1
            'past_zone_traffic_fraction' => null
        );
        $this->_assertPriority($aTestThreeFour);
        // Test 1: Ensure that the values in the log_maintenance_priority table are correct
        $this->_assertLogMaintenance(
            1,
            $oTest1BeforeUpdateDate,
            $oTest1AfterUpdateDate,
            60,
            DAL_PRIORITY_UPDATE_ZIF,
            '2005-06-15 13:59:59'
        );
        $this->_assertLogMaintenance(
            2,
            $oTest1BeforeUpdateDate,
            $oTest1AfterUpdateDate,
            60,
            DAL_PRIORITY_UPDATE_PRIORITY_COMPENSATION
        );

        // Insert data that indicates that the Maintenance Statistics Engine
        // has recently updated the available stats, but don't insert any
        // stats into the tables
        $this->oServiceLocator = &ServiceLocator::instance();
        $startDate = new Date('2005-06-15 14:00:01');
        $this->oServiceLocator->register('now', $startDate);
        $oMaintenanceStatistics = new MAX_Maintenance_Statistics_AdServer();
        $oMaintenanceStatistics->updateIntermediate = true;
        $oMaintenanceStatistics->updateFinal = true;
        $aOiDates = OA_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($startDate);
        $oMaintenanceStatistics->oUpdateIntermediateToDate = $aOiDates['end'];
        $oMaintenanceStatistics->oUpdateFinalToDate = $aOiDates['end'];
        $this->oServiceLocator->register('Maintenance_Statistics_Controller', $oMaintenanceStatistics);
        $oLogCompletion = new MAX_Maintenance_Statistics_AdServer_Task_LogCompletion();
        $oLogCompletion->run();

        // Test 2: Set "previous" date for the MPE run
        $oPreviousDate = new Date('2005-06-15 13:01:01');
        $previousOperationIntervalID = $currentOperationIntervalID;
        // Test 2: Set "current" date for the MPE run
        $oDate = new Date('2005-06-15 14:01:01');
        $this->oServiceLocator->register('now', $oDate);
        // Test 2: Prepare the MPE object
        $oMaintenancePriority = new MAX_Maintenance_Priority_AdServer();
        // Test 2: Store the date before the MPE runs
        $oTest2BeforeUpdateDate = new Date();
        sleep(1); // Ensure that next date is at least 1 second after above...
        // Test 2: Run the MPE
        $oMaintenancePriority->updatePriorities();
        // Test 2: Store the date after the MPE runs
        sleep(1); // Ensure that next date is at least 1 second after above...
        $oTest2AfterUpdateDate = new Date();
        // Test 2: Ensure one row in the data_summary_zone_impression_history table per zone
        //         and operation interval covered so far by the MPE
        $oLastUpdatedTo = new Date('2005-06-15 14:00:00');
        $oNowUpdatedTo  = new Date('2005-06-15 15:00:00');
        $oSpan = new Date_Span();
        $oLastUpdatedToCopy = new Date();
        $oLastUpdatedToCopy->copy($oLastUpdatedTo);
        $oNowUpdatedToCopy = new Date();
        $oNowUpdatedToCopy->copy($oNowUpdatedTo);
        $oSpan->setFromDateDiff($oLastUpdatedToCopy, $oNowUpdatedToCopy);
        $hours = $oSpan->toHours();
        $this->assertEqual($this->_dszihRows(), ($this->intervalsPerWeek + $hours) * 4);
        // Test 2: Ensure that the rows in the data_summary_zone_impression_history table
        //         are corect
        $oStartDate = new Date('2005-06-08 14:00:00');
        $oEndDate   = new Date('2005-06-11 23:00:00');
        $this->_validateDszihRowsRange($oStartDate, $oEndDate);
        $oStartDate = new Date('2005-06-12 00:00:00');
        $oEndDate   = new Date('2005-06-15 13:00:00');
        $this->_validateDszihRowsRange($oStartDate, $oEndDate);
        $oDate = new Date('2005-06-15 14:00:00');
        $this->_validateDszihRowsSpecific($oDate);
        // Test 2: Ensure correct number of links in the ad_zone_assoc table
        $this->assertEqual($this->_azaRows(), 7); // 4 proper associations + 3 default with zone 0
        // Test 2: Ensure correct number if links in the ad_zone_assoc table with priority > 0
        $this->assertEqual($this->_azaRows(true), 7);
        // Test 2: Ensure correct number if links in the data_summary_ad_zone_assoc table with priority > 0
        $this->assertEqual($this->_dsazaRows(true), 14);
        // Test 2: Ensure that the priorities in the ad_zone_assoc and data_summary_ad_zone_assoc
        // tables are set correctly
        $aTestOneZero['priority']        = 12 / 30;
        $aTestOneZero['priority_factor'] = 10;         // Increased from 1 to 10, as no impressions
        $aTestOneZero['history'][1]      = array(
            'operation_interval'         => 60,
            'operation_interval_id'      => 86,
            'interval_start'             => '2005-06-15 14:00:00',
            'interval_end'               => '2005-06-15 14:59:59',
            'required_impressions'       => 12,
            'requested_impressions'      => 12,
            'priority'                   => 12 / 30,
            'priority_factor'            => 10,        // Increased from 1 to 10, as no impressions
            'past_zone_traffic_fraction' => 0
        );
        $this->_assertPriority($aTestOneZero);
        $aTestTwoZero['priority']        = 12 / 30;
        $aTestTwoZero['priority_factor'] = 10;         // Increased from 1 to 10, as no impressions
        $aTestTwoZero['history'][1]      = array(
            'operation_interval'         => 60,
            'operation_interval_id'      => 86,
            'interval_start'             => '2005-06-15 14:00:00',
            'interval_end'               => '2005-06-15 14:59:59',
            'required_impressions'       => 12,
            'requested_impressions'      => 12,
            'priority'                   => 12 / 30,
            'priority_factor'            => 10,        // Increased from 1 to 10, as no impressions
            'past_zone_traffic_fraction' => 0
        );
        $this->_assertPriority($aTestTwoZero);
        $aTestThreeZero['priority']        = 6 / 30;
        $aTestThreeZero['priority_factor'] = 10;       // Increased from 1 to 10, as no impressions
        $aTestThreeZero['history'][1]      = array(
            'operation_interval'         => 60,
            'operation_interval_id'      => 86,
            'interval_start'             => '2005-06-15 14:00:00',
            'interval_end'               => '2005-06-15 14:59:59',
            'required_impressions'       => 6,
            'requested_impressions'      => 6,
            'priority'                   => 6 / 30,
            'priority_factor'            => 10,        // Increased from 1 to 10, as no impressions
            'past_zone_traffic_fraction' => 0
        );
        $this->_assertPriority($aTestThreeZero);
        $aTestOneOne['priority_factor'] = 10;          // Increased from 1 to 10, as no impressions
        $aTestOneOne['history'][1]      = array(
            'operation_interval'         => 60,
            'operation_interval_id'      => 86,
            'interval_start'             => '2005-06-15 14:00:00',
            'interval_end'               => '2005-06-15 14:59:59',
            'required_impressions'       => 12,
            'requested_impressions'      => 9,
            'priority'                   => 0.9,       // Constant, only priority_factor increases
            'priority_factor'            => 10,        // Increased from 1 to 10, as no impressions
            'past_zone_traffic_fraction' => 0
        );
        $this->_assertPriority($aTestOneOne);
        $aTestTwoThree['priority_factor'] = 10;        // Increased from 1 to 10, as no impressions
        $aTestTwoThree['history'][1]      = array(
            'operation_interval'         => 60,
            'operation_interval_id'      => 86,
            'interval_start'             => '2005-06-15 14:00:00',
            'interval_end'               => '2005-06-15 14:59:59',
            'required_impressions'       => 12,
            'requested_impressions'      => 7,
            'priority'                   => 0.7,       // Constant, only priority_factor increases
            'priority_factor'            => 10,        // Increased from 1 to 10, as no impressions
            'past_zone_traffic_fraction' => 0
        );
        $this->_assertPriority($aTestTwoThree);
        $aTestThreeThree['priority_factor'] = 10;      // Increased from 1 to 10, as no impressions
        $aTestThreeThree['history'][1]      = array(
            'operation_interval'         => 60,
            'operation_interval_id'      => 86,
            'interval_start'             => '2005-06-15 14:00:00',
            'interval_end'               => '2005-06-15 14:59:59',
            'required_impressions'       => 3,
            'requested_impressions'      => 2,
            'priority'                   => 0.2,       // Constant, only priority_factor increases
            'priority_factor'            => 10,        // Increased from 1 to 10, as no impressions
            'past_zone_traffic_fraction' => 0
        );
        $this->_assertPriority($aTestThreeThree);
        $aTestThreeFour['priority_factor'] = 10;       // Increased from 1 to 10, as no impressions
        $aTestThreeFour['history'][1]      = array(
            'operation_interval'         => 60,
            'operation_interval_id'      => 86,
            'interval_start'             => '2005-06-15 14:00:00',
            'interval_end'               => '2005-06-15 14:59:59',
            'required_impressions'       => 3,
            'requested_impressions'      => 3,
            'priority'                   => 0.3,       // Constant, only priority_factor increases
            'priority_factor'            => 10,        // Increased from 1 to 10, as no impressions
            'past_zone_traffic_fraction' => 0
        );
        $this->_assertPriority($aTestThreeFour);

        // Test 2: Ensure that the values in the log_maintenance_priority table are correct
        $this->_assertLogMaintenance(
            1,
            $oTest1BeforeUpdateDate,
            $oTest1AfterUpdateDate,
            60,
            DAL_PRIORITY_UPDATE_ZIF,
            '2005-06-15 13:59:59'
        );
        $this->_assertLogMaintenance(
            2,
            $oTest1BeforeUpdateDate,
            $oTest1AfterUpdateDate,
            60,
            DAL_PRIORITY_UPDATE_PRIORITY_COMPENSATION
        );

        $this->_assertLogMaintenance(
            3,
            $oTest2BeforeUpdateDate,
            $oTest2AfterUpdateDate,
            60,
            DAL_PRIORITY_UPDATE_ZIF,
            '2005-06-15 14:59:59'
        );
        $this->_assertLogMaintenance(
            4,
            $oTest2BeforeUpdateDate,
            $oTest2AfterUpdateDate,
            60,
            DAL_PRIORITY_UPDATE_PRIORITY_COMPENSATION
        );

        // Insert data that indicates that the Maintenance Statistics Engine
        // has recently updated the available stats, but don't insert any
        // stats into the tables
        $this->oServiceLocator = &ServiceLocator::instance();
        $startDate = new Date('2005-06-19 00:00:01');
        $this->oServiceLocator->register('now', $startDate);
        $oMaintenanceStatistics = new MAX_Maintenance_Statistics_AdServer();
        $oMaintenanceStatistics->updateIntermediate = true;
        $oMaintenanceStatistics->updateFinal = true;
        $aOiDates = OA_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($startDate);
        $oMaintenanceStatistics->oUpdateIntermediateToDate = $aOiDates['end'];
        $oMaintenanceStatistics->oUpdateFinalToDate = $aOiDates['end'];
        $this->oServiceLocator->register('Maintenance_Statistics_Controller', $oMaintenanceStatistics);
        $oLogCompletion = new MAX_Maintenance_Statistics_AdServer_Task_LogCompletion();
        $oLogCompletion->run();

        // Test 3: Set "current" date for the MPE run
        $oDate = new Date('2005-06-19 00:01:01');
        $this->oServiceLocator->register('now', $oDate);
        // Test 3: Prepare the MPE object
        $oMaintenancePriority = new MAX_Maintenance_Priority_AdServer();
        // Test 3: Store the date before the MPE runs
        $oTest3BeforeUpdateDate = new Date();
        sleep(1); // Ensure that next date is at least 1 second after above...
        // Test 3: Run the MPE
        $oMaintenancePriority->updatePriorities();
        // Test 3: Store the date after the MPE runs
        sleep(1); // Ensure that next date is at least 1 second after above...
        $oTest3AfterUpdateDate = new Date();
        // Test 3: Ensure one row in the data_summary_zone_impression_history table per zone
        //         and operation interval covered so far by the MPE
        $oLastUpdatedTo1 = new Date('2005-06-15 14:00:00');
        $oNowUpdatedTo1  = new Date('2005-06-15 15:00:00');
        $oSpan = new Date_Span();
        $oLastUpdatedTo1Copy = new Date();
        $oLastUpdatedTo1Copy->copy($oLastUpdatedTo1);
        $oNowUpdatedTo1Copy = new Date();
        $oNowUpdatedTo1Copy->copy($oNowUpdatedTo1);
        $oSpan->setFromDateDiff($oLastUpdatedTo1Copy, $oNowUpdatedTo1Copy);
        $hours1 = $oSpan->toHours();
        $oLastUpdatedTo2 = new Date('2005-06-15 15:00:00');
        $oNowUpdatedTo2  = new Date('2005-06-19 01:00:00');
        $oSpan = new Date_Span();
        $oLastUpdatedTo2Copy = new Date();
        $oLastUpdatedTo2Copy->copy($oLastUpdatedTo2);
        $oNowUpdatedTo2Copy = new Date();
        $oNowUpdatedTo2Copy->copy($oNowUpdatedTo2);
        $oSpan->setFromDateDiff($oLastUpdatedTo2Copy, $oNowUpdatedTo2Copy);
        $hours2 = $oSpan->toHours();
        $this->assertEqual($this->_dszihRows(), ($this->intervalsPerWeek + $hours1 + $hours2) * 4);
        // Test 3: Ensure that the rows in the data_summary_zone_impression_history table
        //         are corect
        $oStartDate = new Date('2005-06-08 14:00:00');
        $oEndDate   = new Date('2005-06-11 23:00:00');
        $this->_validateDszihRowsRange($oStartDate, $oEndDate);
        $oStartDate = new Date('2005-06-12 00:00:00');
        $oEndDate   = new Date('2005-06-15 13:00:00');
        $this->_validateDszihRowsRange($oStartDate, $oEndDate);
        $oDate = new Date('2005-06-15 14:00:00');
        $this->_validateDszihRowsSpecific($oDate);
        $oStartDate = new Date('2005-06-15 15:00:00');
        $oEndDate   = new Date('2005-06-18 23:00:00');
        $this->_validateDszihRowsRange($oStartDate, $oEndDate);
        $oDate = new Date('2005-06-19 00:00:00');
        $this->_validateDszihRowsSpecific($oDate);
        // Test 3: Ensure correct number of links in the ad_zone_assoc table
        $this->assertEqual($this->_azaRows(), 7); // 4 proper associations + 3 default with zone 0
        // Test 3: Ensure correct number if links in the ad_zone_assoc table with priority > 0
        $this->assertEqual($this->_azaRows(true), 7);
        // Test 3: Ensure correct number if links in the data_summary_ad_zone_assoc table with priority > 0
        $this->assertEqual($this->_dsazaRows(true), 21);
        // Test 3: Ensure that the priorities in the ad_zone_assoc and data_summary_ad_zone_assoc
        // tables are set correctly
        $aTestOneZero['priority']        = 5 / 23;
        $aTestOneZero['priority_factor'] = 100;        // Increased from 10 to 100, as no impressions
        $aTestOneZero['history'][1]      = array(
            'operation_interval'         => 60,
            'operation_interval_id'      => 0,
            'interval_start'             => '2005-06-19 00:00:00',
            'interval_end'               => '2005-06-19 00:59:59',
            'required_impressions'       => 5,
            'requested_impressions'      => 5,
            'priority'                   => 5 / 23,
            'priority_factor'            => 100,       // Increased from 10 to 100, as no impressions
            'past_zone_traffic_fraction' => 0
        );
        $this->_assertPriority($aTestOneZero);
        $aTestTwoZero['priority']        = 12 / 23;
        $aTestTwoZero['priority_factor'] = 100;        // Increased from 10 to 100, as no impressions
        $aTestTwoZero['history'][1]      = array(
            'operation_interval'         => 60,
            'operation_interval_id'      => 0,
            'interval_start'             => '2005-06-19 00:00:00',
            'interval_end'               => '2005-06-19 00:59:59',
            'required_impressions'       => 12,
            'requested_impressions'      => 12,
            'priority'                   => 12 / 23,
            'priority_factor'            => 100,       // Increased from 10 to 100, as no impressions
            'past_zone_traffic_fraction' => 0
        );
        $this->_assertPriority($aTestTwoZero);
        $aTestThreeZero['priority']        = 6 / 23;
        $aTestThreeZero['priority_factor'] = 100;      // Increased from 10 to 100, as no impressions
        $aTestThreeZero['history'][1]      = array(
            'operation_interval'         => 60,
            'operation_interval_id'      => 0,
            'interval_start'             => '2005-06-19 00:00:00',
            'interval_end'               => '2005-06-19 00:59:59',
            'required_impressions'       => 6,
            'requested_impressions'      => 6,
            'priority'                   => 6 / 23,
            'priority_factor'            => 100,       // Increased from 10 to 100, as no impressions
            'past_zone_traffic_fraction' => 0
        );
        $this->_assertPriority($aTestThreeZero);
        $aTestOneOne['priority']        = 0.5;         // Changed, skipped OIs
        $aTestOneOne['priority_factor'] = 100;         // Increased from 10 to 100, as no impressions
        $aTestOneOne['history'][1]      = array(
            'operation_interval'         => 60,
            'operation_interval_id'      => 0,
            'interval_start'             => '2005-06-19 00:00:00',
            'interval_end'               => '2005-06-19 00:59:59',
            'required_impressions'       => 5,
            'requested_impressions'      => 5,
            'priority'                   => 0.5,       // Changed, skipped OIs
            'priority_factor'            => 100,       // Increased from 10 to 100, as no impressions
            'past_zone_traffic_fraction' => 0
        );
        $this->_assertPriority($aTestOneOne);
        $aTestTwoThree['priority_factor'] = 100;       // Increased from 10 to 100, as no impressions
        $aTestTwoThree['history'][1]      = array(
            'operation_interval'         => 60,
            'operation_interval_id'      => 0,
            'interval_start'             => '2005-06-19 00:00:00',
            'interval_end'               => '2005-06-19 00:59:59',
            'required_impressions'       => 12,
            'requested_impressions'      => 7,
            'priority'                   => 0.7,       // Constant, only priority_factor increases
            'priority_factor'            => 100,       // Increased from 10 to 100, as no impressions
            'past_zone_traffic_fraction' => 0
        );
        $this->_assertPriority($aTestTwoThree);
        $aTestThreeThree['priority_factor'] = 100;     // Increased from 10 to 100, as no impressions
        $aTestThreeThree['history'][1]      = array(
            'operation_interval'         => 60,
            'operation_interval_id'      => 0,
            'interval_start'             => '2005-06-19 00:00:00',
            'interval_end'               => '2005-06-19 00:59:59',
            'required_impressions'       => 3,
            'requested_impressions'      => 2,
            'priority'                   => 0.2,       // Constant, only priority_factor increases
            'priority_factor'            => 100,       // Increased from 10 to 100, as no impressions
            'past_zone_traffic_fraction' => 0
        );
        $this->_assertPriority($aTestThreeThree);
        $aTestThreeFour['priority_factor'] = 100;      // Increased from 10 to 100, as no impressions
        $aTestThreeFour['history'][1]      = array(
            'operation_interval'         => 60,
            'operation_interval_id'      => 0,
            'interval_start'             => '2005-06-19 00:00:00',
            'interval_end'               => '2005-06-19 00:59:59',
            'required_impressions'       => 3,
            'requested_impressions'      => 3,
            'priority'                   => 0.3,       // Constant, only priority_factor increases
            'priority_factor'            => 100,       // Increased from 10 to 100, as no impressions
            'past_zone_traffic_fraction' => 0
        );
        $this->_assertPriority($aTestThreeFour);
        // Test 3: Ensure that the values in the log_maintenance_priority table are correct
        $this->_assertLogMaintenance(
            1,
            $oTest1BeforeUpdateDate,
            $oTest1AfterUpdateDate,
            60,
            DAL_PRIORITY_UPDATE_ZIF,
            '2005-06-15 13:59:59'
        );
        $this->_assertLogMaintenance(
            2,
            $oTest1BeforeUpdateDate,
            $oTest1AfterUpdateDate,
            60,
            DAL_PRIORITY_UPDATE_PRIORITY_COMPENSATION
        );
        $this->_assertLogMaintenance(
            3,
            $oTest2BeforeUpdateDate,
            $oTest2AfterUpdateDate,
            60,
            DAL_PRIORITY_UPDATE_ZIF,
            '2005-06-15 14:59:59'
        );
        $this->_assertLogMaintenance(
            4,
            $oTest2BeforeUpdateDate,
            $oTest2AfterUpdateDate,
            60,
            DAL_PRIORITY_UPDATE_PRIORITY_COMPENSATION
        );
        $this->_assertLogMaintenance(
            5,
            $oTest3BeforeUpdateDate,
            $oTest3AfterUpdateDate,
            60,
            DAL_PRIORITY_UPDATE_ZIF,
            '2005-06-19 00:59:59'
        );
        $this->_assertLogMaintenance(
            6,
            $oTest3BeforeUpdateDate,
            $oTest3AfterUpdateDate,
            60,
            DAL_PRIORITY_UPDATE_PRIORITY_COMPENSATION
        );
    }

}

?>