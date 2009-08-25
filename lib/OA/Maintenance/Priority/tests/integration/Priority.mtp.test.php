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

require_once MAX_PATH . '/variables.php';
require_once MAX_PATH . '/lib/OA/Maintenance/Priority/AdServer/Task.php';
require_once MAX_PATH . '/lib/OA/Maintenance/Priority/AdServer.php';
require_once MAX_PATH . '/lib/OA/ServiceLocator.php';
require_once MAX_PATH . '/lib/OA/Dal/DataGenerator.php';
require_once MAX_PATH . '/lib/pear/Date.php';
require_once MAX_PATH . '/lib/pear/Date/Span.php';
require_once LIB_PATH . '/Maintenance/Statistics.php';

/**
 * A class for performing an integration test of the Maintenance
 * Prioritisation Engine via a test of the AdServer class.
 *
 * @package    OpenXMaintenance
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew.hill@openx.org>
 */
class Test_Priority extends UnitTestCase
{
    /**
     * A local instance of the database handler object.
     *
     * @var MDB2_Driver_Common
     */
    var $oDbh;

    /**
     * A local instance of the service locator.
     *
     * @var OA_ServiceLocator
     */
    var $oServiceLocator;

    /**
     * The number of operation intervals per week.
     *
     * @var integer
     */
    var $intervalsPerWeek;

    /**
     * The constructor method.
     */
    function Test_Priority()
    {
        $this->UnitTestCase();
    }

    /**
     * A method to be run before all tests.
     */
    function setUp()
    {
        // Set up the configuration array to have an operation interval
        // of 60 minutes, and set the timezone to GMT
        $aConf =& $GLOBALS['_MAX']['CONF'];
        $aConf['maintenance']['operationInteval'] = 60;
        OA_setTimeZone('GMT');
        //setTimeZoneLocation($aConf['timezone']['location']);

        // Set up the database handler object
        $this->oDbh =& OA_DB::singleton();

        // Set up the service locator object
        $this->oServiceLocator =& OA_ServiceLocator::instance();

        // Discover the number of operation intervals per week
        $this->intervalsPerWeek = OX_OperationInterval::operationIntervalsPerWeek();
        
        // This test was written with a ZONE_FORECAST_DEFAULT_ZONE_IMPRESSIONS value of 10 in mind.
        OA_Dal_Maintenance_Priority::$ZONE_FORECAST_DEFAULT_ZONE_IMPRESSIONS = 10;
    }

    /**
     * A method to be run after all tests.
     */
    function tearDown()
    {
        // Clean up the testing environment
        TestEnv::restoreEnv();
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
        $oMaintenancePriority = new OA_Maintenance_Priority_AdServer();
        // Test 1: Store the date before the MPE runs
        $oTest1BeforeUpdateDate = new Date();
        sleep(1); // Ensure that next date is at least 1 second after above...
        // Test 1: Run the MPE
        $oMaintenancePriority->updatePriorities();
        // Test 1: Store the date after the MPE runs
        sleep(1); // Ensure that next date is at least 1 second after above...
        $oTest1AfterUpdateDate = new Date();
        // Test 1: Ensure correct number of links in the ad_zone_assoc table
        $this->assertEqual($this->_azaRows(), 7); // 4 proper associations + 3 default with zone 0
        // Test 1: Ensure correct number of links in the ad_zone_assoc table with priority > 0
        $this->assertEqual($this->_azaRows(true), 7);
        // Test 1: Ensure correct number of links in the data_summary_ad_zone_assoc table with priority >
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
            2,
            $oTest1BeforeUpdateDate,
            $oTest1AfterUpdateDate,
            60,
            DAL_PRIORITY_UPDATE_ECPM
        );

        // Insert data that indicates that the Maintenance Statistics Engine
        // has recently updated the available stats, but don't insert any
        // stats into the tables
        $this->oServiceLocator =& OA_ServiceLocator::instance();
        $startDate = new Date('2005-06-15 14:00:01');
        $this->oServiceLocator->register('now', $startDate);
        $oMaintenanceStatistics = new OX_Maintenance_Statistics();
        $oMaintenanceStatistics->updateIntermediate = true;
        $oMaintenanceStatistics->updateFinal = true;
        $aOiDates = OX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($startDate);
        $oMaintenanceStatistics->oUpdateIntermediateToDate = $aOiDates['end'];
        $oMaintenanceStatistics->oUpdateFinalToDate = $aOiDates['end'];
        $this->oServiceLocator->register('Maintenance_Statistics_Controller', $oMaintenanceStatistics);
        $oLogCompletion = new OX_Maintenance_Statistics_Task_LogCompletion();
        $oLogCompletion->run();

        // Test 2: Set "previous" date for the MPE run
        $oPreviousDate = new Date('2005-06-15 13:01:01');
        $previousOperationIntervalID = $currentOperationIntervalID;
        // Test 2: Set "current" date for the MPE run
        $oDate = new Date('2005-06-15 14:01:01');
        $this->oServiceLocator->register('now', $oDate);
        // Test 2: Prepare the MPE object
        $oMaintenancePriority = new OA_Maintenance_Priority_AdServer();
        // Test 2: Store the date before the MPE runs
        $oTest2BeforeUpdateDate = new Date();
        sleep(1); // Ensure that next date is at least 1 second after above...
        // Test 2: Run the MPE
        $oMaintenancePriority->updatePriorities();
        // Test 2: Store the date after the MPE runs
        sleep(1); // Ensure that next date is at least 1 second after above...
        $oTest2AfterUpdateDate = new Date();
        // Test 2: Ensure correct number of links in the ad_zone_assoc table
        $this->assertEqual($this->_azaRows(), 7); // 4 proper associations + 3 default with zone 0
        // Test 2: Ensure correct number of links in the ad_zone_assoc table with priority > 0
        $this->assertEqual($this->_azaRows(true), 7);
        // Test 2: Ensure correct number of links in the data_summary_ad_zone_assoc table with priority > 0
        $this->assertEqual($this->_dsazaRows(true), 14);
        // Test 2: Ensure that the priorities in the ad_zone_assoc and data_summary_ad_zone_assoc
        // tables are set correctly
        $aTestOneZero['priority']        = 12 / 30;
        $aTestOneZero['priority_factor'] = 1;          // Remains at 1, no priority compensation in Zone ID 0
        $aTestOneZero['history'][1]      = array(
            'operation_interval'         => 60,
            'operation_interval_id'      => 86,
            'interval_start'             => '2005-06-15 14:00:00',
            'interval_end'               => '2005-06-15 14:59:59',
            'required_impressions'       => 12,
            'requested_impressions'      => 12,
            'priority'                   => 12 / 30,
            'priority_factor'            => 1,         // Remains at 1, no priority compensation in Zone ID 0
            'past_zone_traffic_fraction' => 0
        );
        $this->_assertPriority($aTestOneZero);
        $aTestTwoZero['priority']        = 12 / 30;
        $aTestTwoZero['priority_factor'] = 1;          // Remains at 1, no priority compensation in Zone ID 0
        $aTestTwoZero['history'][1]      = array(
            'operation_interval'         => 60,
            'operation_interval_id'      => 86,
            'interval_start'             => '2005-06-15 14:00:00',
            'interval_end'               => '2005-06-15 14:59:59',
            'required_impressions'       => 12,
            'requested_impressions'      => 12,
            'priority'                   => 12 / 30,
            'priority_factor'            => 1,         // Remains at 1, no priority compensation in Zone ID 0
            'past_zone_traffic_fraction' => 0
        );
        $this->_assertPriority($aTestTwoZero);
        $aTestThreeZero['priority']        = 6 / 30;
        $aTestThreeZero['priority_factor'] = 1;        // Remains at 1, no priority compensation in Zone ID 0
        $aTestThreeZero['history'][1]      = array(
            'operation_interval'         => 60,
            'operation_interval_id'      => 86,
            'interval_start'             => '2005-06-15 14:00:00',
            'interval_end'               => '2005-06-15 14:59:59',
            'required_impressions'       => 6,
            'requested_impressions'      => 6,
            'priority'                   => 6 / 30,
            'priority_factor'            => 1,         // Remains at 1, no priority compensation in Zone ID 0
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
            2,
            $oTest1BeforeUpdateDate,
            $oTest1AfterUpdateDate,
            60,
            DAL_PRIORITY_UPDATE_ECPM
        );

        $this->_assertLogMaintenance(
            6,
            $oTest2BeforeUpdateDate,
            $oTest2AfterUpdateDate,
            60,
            DAL_PRIORITY_UPDATE_ECPM
        );

        // Insert data that indicates that the Maintenance Statistics Engine
        // has recently updated the available stats, but don't insert any
        // stats into the tables
        $this->oServiceLocator =& OA_ServiceLocator::instance();
        $startDate = new Date('2005-06-19 00:00:01');
        $this->oServiceLocator->register('now', $startDate);
        $oMaintenanceStatistics = new OX_Maintenance_Statistics();
        $oMaintenanceStatistics->updateIntermediate = true;
        $oMaintenanceStatistics->updateFinal = true;
        $aOiDates = OX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($startDate);
        $oMaintenanceStatistics->oUpdateIntermediateToDate = $aOiDates['end'];
        $oMaintenanceStatistics->oUpdateFinalToDate = $aOiDates['end'];
        $this->oServiceLocator->register('Maintenance_Statistics_Controller', $oMaintenanceStatistics);
        $oLogCompletion = new OX_Maintenance_Statistics_Task_LogCompletion();
        $oLogCompletion->run();

        // Test 3: Set "current" date for the MPE run
        $oDate = new Date('2005-06-19 00:01:01');
        $this->oServiceLocator->register('now', $oDate);
        // Test 3: Prepare the MPE object
        $oMaintenancePriority = new OA_Maintenance_Priority_AdServer();
        // Test 3: Store the date before the MPE runs
        $oTest3BeforeUpdateDate = new Date();
        sleep(1); // Ensure that next date is at least 1 second after above...
        // Test 3: Run the MPE
        $oMaintenancePriority->updatePriorities();
        // Test 3: Store the date after the MPE runs
        sleep(1); // Ensure that next date is at least 1 second after above...
        $oTest3AfterUpdateDate = new Date();
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
        // Test 3: Ensure correct number of links in the ad_zone_assoc table
        $this->assertEqual($this->_azaRows(), 7); // 4 proper associations + 3 default with zone 0
        // Test 3: Ensure correct number of links in the ad_zone_assoc table with priority > 0
        $this->assertEqual($this->_azaRows(true), 7);
        // Test 3: Ensure correct number of links in the data_summary_ad_zone_assoc table with priority > 0
        $this->assertEqual($this->_dsazaRows(true), 21);
        // Test 3: Ensure that the priorities in the ad_zone_assoc and data_summary_ad_zone_assoc
        // tables are set correctly
        $aTestOneZero['priority']        = 5 / 23;
        $aTestOneZero['priority_factor'] = 1;          // Remains at 1, no priority compensation in Zone ID 0
        $aTestOneZero['history'][1]      = array(
            'operation_interval'         => 60,
            'operation_interval_id'      => 0,
            'interval_start'             => '2005-06-19 00:00:00',
            'interval_end'               => '2005-06-19 00:59:59',
            'required_impressions'       => 5,
            'requested_impressions'      => 5,
            'priority'                   => 5 / 23,
            'priority_factor'            => 1,         // Remains at 1, no priority compensation in Zone ID 0
            'past_zone_traffic_fraction' => 0
        );
        $this->_assertPriority($aTestOneZero);
        $aTestTwoZero['priority']        = 12 / 23;
        $aTestTwoZero['priority_factor'] = 1;          // Remains at 1, no priority compensation in Zone ID 0
        $aTestTwoZero['history'][1]      = array(
            'operation_interval'         => 60,
            'operation_interval_id'      => 0,
            'interval_start'             => '2005-06-19 00:00:00',
            'interval_end'               => '2005-06-19 00:59:59',
            'required_impressions'       => 12,
            'requested_impressions'      => 12,
            'priority'                   => 12 / 23,
            'priority_factor'            => 1,         // Remains at 1, no priority compensation in Zone ID 0
            'past_zone_traffic_fraction' => 0
        );
        $this->_assertPriority($aTestTwoZero);
        $aTestThreeZero['priority']        = 6 / 23;
        $aTestThreeZero['priority_factor'] = 1;        // Remains at 1, no priority compensation in Zone ID 0
        $aTestThreeZero['history'][1]      = array(
            'operation_interval'         => 60,
            'operation_interval_id'      => 0,
            'interval_start'             => '2005-06-19 00:00:00',
            'interval_end'               => '2005-06-19 00:59:59',
            'required_impressions'       => 6,
            'requested_impressions'      => 6,
            'priority'                   => 6 / 23,
            'priority_factor'            => 1,         // Remains at 1, no priority compensation in Zone ID 0
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
            2,
            $oTest1BeforeUpdateDate,
            $oTest1AfterUpdateDate,
            60,
            DAL_PRIORITY_UPDATE_ECPM
        );
        $this->_assertLogMaintenance(
            6,
            $oTest2BeforeUpdateDate,
            $oTest2AfterUpdateDate,
            60,
            DAL_PRIORITY_UPDATE_ECPM
        );
    }

    /**
     * A private method to get the number of rows currently in the
     * ad_zone_assoc table.
     *
     * @access private
     * @param boolean $limit Limit the rows counted to those where
     *                       the priority value is > 0? Default is false.
     * @return integer The number of rows in the table.
     */
    function _azaRows($limit = false)
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        $tableName = $aConf['table']['prefix'] . 'ad_zone_assoc';
        return $this->_getRows($tableName, $limit);
    }

    /**
     * A private method to get the number of rows currently in the
     * data_summary_ad_zone_assoc table.
     *
     * @access private
     * @param boolean $limit Limit the rows counted to those where
     *                       the priority value is > 0? Default is false.
     * @return integer The number of rows in the table.
     */
    function _dsazaRows($limit = false)
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        $tableName = $aConf['table']['prefix'] . 'data_summary_ad_zone_assoc';
        return $this->_getRows($tableName, $limit);
    }

    /**
     * A private function to get the number of rows from a
     * specified table.
     *
     * @access private
     * @param string $tableName The name of the table to get the
     *                          number of rows of, including the table
     *                          prefix, if required.
     * @param boolean $limit Limit the rows counted to those where
     *                       the priority value is > 0?
     * @return integer The number of rows in the table.
     */
    function _getRows($tableName, $limit)
    {
        $table = $this->oDbh->quoteIdentifier($tableName, true);
        $query = "
            SELECT
                count(*) AS number
            FROM
                $table";
        if ($limit) {
            $query .= "
            WHERE
                priority > 0";
        }
        $rc = $this->oDbh->query($query);
        $aRow = $rc->fetchRow();
        return $aRow['number'];
    }

    /**
     * A private method for performing assertions on priority values
     * that should be set in the ad_zone_assoc and
     * data_summary_ad_zone_assoc tables.
     *
     * @access private
     * @param array $aParams An array of values to test, specifically:
     *
     * array(
     *     'ad_id'           => The ad ID to test.
     *     'zone_id'         => The zone ID to test.
     *     'priority'        => The ad/zone priority that should be set.
     *     'priority_factor' => The ad/zone priority factor that should be set.
     *     'history'         => An array of arrays of values to assert in the
     *                          data_summary_ad_zone_assoc table.
     * )
     *
     * The "history" arrays should be of in the following format:
     *
     * array(
     *     'operation_interval'         => The operation interval to test.
     *     'operation_interval_id'      => The operation interval ID to test.
     *     'interval_start'             => The operation interval start to test.
     *     'interval_end'               => The operation interval end to test.
     *     'required_impressions'       => The ad/zone required impressions that should be set.
     *     'requested_impressions'      => The ad/zone requested impressions that should be set.
     *     'priority'                   => The ad/zone priority that should be set.
     *     'priority_factor'            => The ad/zone priority factor that should be set.
     *     'past_zone_traffic_fraction' => The ad/zone past zone traffic fraction that should be set.
     * )
     */
    function _assertPriority($aParams)
    {
        $aConf =& $GLOBALS['_MAX']['CONF'];
        $oDbh =& OA_DB::singleton();

        $tableAza   = $oDbh->quoteIdentifier($aConf['table']['prefix'].'ad_zone_assoc', true);
        $tableDsaza = $oDbh->quoteIdentifier($aConf['table']['prefix'].'data_summary_ad_zone_assoc', true);

        // Assert the values in the ad_zone_assoc table are correct
        $query = "
            SELECT
                priority,
                priority_factor
            FROM
                {$tableAza}
            WHERE
                ad_id = {$aParams['ad_id']}
                AND zone_id = {$aParams['zone_id']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual((string) $aRow['priority'], (string) $aParams['priority']);
        $this->assertEqual($aRow['priority_factor'], $aParams['priority_factor']);
        // Assert the values in the data_summary_ad_zone_assoc table are correct
        if (is_array($aParams['history']) && !empty($aParams['history'])) {
            foreach ($aParams['history'] as $aTestData) {
                $query = "
                    SELECT
                        required_impressions,
                        requested_impressions,
                        priority,
                        priority_factor,
                        past_zone_traffic_fraction
                    FROM
                        {$tableDsaza}
                    WHERE
                        operation_interval = {$aTestData['operation_interval']}
                        AND operation_interval_id = {$aTestData['operation_interval_id']}
                        AND interval_start = '{$aTestData['interval_start']}'
                        AND interval_end = '{$aTestData['interval_end']}'
                        AND ad_id = {$aParams['ad_id']}
                        AND zone_id = {$aParams['zone_id']}";
                $rc = $oDbh->query($query);
                $aRow = $rc->fetchRow();
                $this->assertEqual($aRow['required_impressions'], $aTestData['required_impressions']);
                $this->assertEqual($aRow['requested_impressions'], $aTestData['requested_impressions']);
                $this->assertEqual((string) $aRow['priority'], (string) $aTestData['priority']);
                $this->assertEqual($aRow['priority_factor'], $aTestData['priority_factor']);
                $this->assertEqual($aRow['past_zone_traffic_fraction'], $aTestData['past_zone_traffic_fraction']);
            }
        }
    }

    /**
     * A private method to perform assertions on the contents of the
     * log_maintenance_priority table.
     *
     * @access private
     * @param integer    $id Optional row ID to test on, if not set, tests
     *                       that table is empty.
     * @param PEAR::Date $oBeforeUpdateDate The before date to test the row with.
     * @param PEAR::Date $oAfterUpdateDate The after date to test the row with.
     * @param integer    $oi The operation interval to test the row with.
     * @param integer    $runType The run type value to test the row with.
     * @param string     $updatedTo The updated to date to test the row with, if any.
     */
    function _assertLogMaintenance($id = null, $oBeforeUpdateDate = null, $oAfterUpdateDate = null, $oi = null, $runType = null, $updatedTo = null)
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        $tableName = $aConf['table']['prefix'] . 'log_maintenance_priority';
        $table = $this->oDbh->quoteIdentifier($tableName, true);
        $query = "
            SELECT
                start_run,
                end_run,
                operation_interval,
                run_type,
                updated_to
            FROM
                $table";
        if (!is_null($id)) {
            $query .= "
            WHERE
                log_maintenance_priority_id = $id";
        }
        $rc = $this->oDbh->query($query);
        $aRow = $rc->fetchRow();
        if (is_null($id)) {
            // Check there are no rows returned
            $this->assertNull($aRow);
        } else {
            // Check the returned row's values
            $oStartRunDate = new Date($aRow['start_run']);
            $oEndRunDate = new Date($aRow['end_run']);
            $result = $oBeforeUpdateDate->before($oStartRunDate);
            $this->assertTrue($result);
            $result = $oBeforeUpdateDate->before($oEndRunDate);
            $this->assertTrue($result);
            $result = $oAfterUpdateDate->after($oStartRunDate);
            $this->assertTrue($result);
            $result = $oAfterUpdateDate->after($oEndRunDate);
            $this->assertTrue($result);
            $result = $oStartRunDate->after($oEndRunDate);
            $this->assertFalse($result);
            $this->assertEqual($aRow['operation_interval'], $oi);
            $this->assertEqual($aRow['run_type'], $runType);
            if (!is_null($updatedTo)) {
                $this->assertEqual($aRow['updated_to'], $updatedTo);
            } else {
                $this->assertNull($aRow['updated_to']);
            }
        }
    }

}

?>
