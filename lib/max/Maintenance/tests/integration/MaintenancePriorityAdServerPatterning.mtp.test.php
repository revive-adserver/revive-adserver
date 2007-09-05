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
 *
 * @TODO This test needs to be completed - merged down from the #810 branch before
 *       being fully completed, to help with PostgreSQL support testing.
 */
class Maintenance_TestOfMaintenancePriorityAdServerPatterning extends Maintenance_TestOfMaintenancePriorityAdServer
{

    /**
     * The constructor method.
     */
    function Maintenance_TestOfMaintenancePriorityAdServer()
    {
        $this->UnitTestCase();
    }

    /**
     * A method to perform end-to-end integration testing of the Maintenance
     * Priority Engine classes for the Ad Server, looking specifically at the
     * zone patterning-based distribution of ad impressions.
     *
     * Test 0: Test that no zone forecast or priority data exists to begin with.
     * Test 1: Run the MPE without any stats, and without the stats engine ever
     *         having been run before. Test that zone forecasts are updated
     *         with the appropriate values, and that the correct priorities are
     *         generated.
     * Test 2: Run the MPE over the course of one week, with the following
     */
    function XXXtestAdServer()
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
        $oBeforeUpdateDate = new Date();
        sleep(1); // Ensure that next date is at least 1 second after above...
        // Test 1: Run the MPE
        $oMaintenancePriority->updatePriorities();
        // Test 1: Store the date after the MPE runs
        sleep(1); // Ensure that next date is at least 1 second after above...
        $oAfterUpdateDate = new Date();
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
            $oBeforeUpdateDate,
            $oAfterUpdateDate,
            60,
            DAL_PRIORITY_UPDATE_ZIF,
            '2005-06-15 13:59:59'
        );
        $this->_assertLogMaintenance(
            2,
            $oBeforeUpdateDate,
            $oAfterUpdateDate,
            60,
            DAL_PRIORITY_UPDATE_PRIORITY_COMPENSATION
        );
    }

}

?>