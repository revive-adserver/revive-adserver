<?php

/*
+---------------------------------------------------------------------------+
| Max Media Manager v0.3                                                    |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2006 m3 Media Services Limited                         |
| For contact details, see: http://www.m3.net/                              |
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
require_once MAX_PATH . '/lib/max/Maintenance/Statistics/AdServer.php';
require_once MAX_PATH . '/lib/max/Maintenance/Statistics/Tracker/Task/LogCompletion.php';
require_once 'Date.php';

/**
 * A class for testing the MAX_Maintenance_Statistics_Tracker_Task_LogCompletion class.
 *
 * @package    MaxMaintenance
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew@m3.net>
 */
class Maintenance_TestOfMAX_Maintenance_Statistics_Tracker_Task_LogCompletion extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function Maintenance_TestOfMAX_Maintenance_Statistics_Tracker_Task_LogCompletion()
    {
        $this->UnitTestCase();
    }

    /**
     * Test the creation of the class.
     */
    function testCreate()
    {
        $oLogCompletion = new MAX_Maintenance_Statistics_Tracker_Task_LogCompletion();
        $this->assertTrue(is_a($oLogCompletion, 'MAX_Maintenance_Statistics_Tracker_Task_LogCompletion'));
    }

    /**
     * A method to test the run() method.
     */
    function testRun()
    {
        $conf = &$GLOBALS['_MAX']['CONF'];
        $tables = &Openads_Table_Core::singleton();
        $dbh = &MAX_DB::singleton();
        $oServiceLocator = &ServiceLocator::instance();
        // Create the required table
        $tables->createTable('data_raw_tracker_impression');
        $tables->createTable('log_maintenance_statistics');
        $tables->createTable('userlog');

        $now = new Date('2004-06-06 18:10:00');
        $oServiceLocator->register('now', $now);
        // Create and register a new MAX_Maintenance_Statistics_AdServer object
        $oMaintenanceStatistics = &new MAX_Maintenance_Statistics_AdServer();
        $oServiceLocator->register('Maintenance_Statistics_Controller', $oMaintenanceStatistics);
        // Create a new MAX_Maintenance_Statistics_Tracker_Task_LogCompletion object
        $oLogCompletion = new MAX_Maintenance_Statistics_Tracker_Task_LogCompletion();

        // Set some of the object's variables, and log
        $oLogCompletion->oController->updateIntermediate = true;
        $oLogCompletion->oController->updateIntermediateToDate = new Date('2004-06-06 17:59:59');
        $oLogCompletion->oController->updateFinal = false;
        $oLogCompletion->oController->updateFinalToDate = null;
        $end = new Date('2004-06-06 18:12:00');
        $oLogCompletion->run($end);
        // Test
        $query = "
            SELECT
                *
            FROM
                {$conf['table']['prefix']}{$conf['table']['log_maintenance_statistics']}
            WHERE
                tracker_run_type = 0";
        $row = $dbh->getRow($query);
        $this->assertEqual($row['start_run'], '2004-06-06 18:10:00');
        $this->assertEqual($row['end_run'], '2004-06-06 18:12:00');
        $this->assertEqual($row['duration'], 120);
        $this->assertEqual($row['updated_to'], '2004-06-06 17:59:59');
        // Set some of the object's variables, and log
        $oLogCompletion->oController->updateIntermediate = false;
        $oLogCompletion->oController->updateIntermediateToDate = null;
        $oLogCompletion->oController->updateFinal = true;
        $oLogCompletion->oController->updateFinalToDate = new Date('2004-06-06 17:59:59');
        $end = new Date('2004-06-06 18:13:00');
        $oLogCompletion->run($end);
        // Test
        $query = "
            SELECT
                *
            FROM
                {$conf['table']['prefix']}{$conf['table']['log_maintenance_statistics']}
            WHERE
                tracker_run_type = 1";
        $row = $dbh->getRow($query);
        $this->assertEqual($row['start_run'], '2004-06-06 18:10:00');
        $this->assertEqual($row['end_run'], '2004-06-06 18:13:00');
        $this->assertEqual($row['duration'], 180);
        $this->assertEqual($row['updated_to'], '2004-06-06 17:59:59');
        // Set some of the object's variables, and log
        $oLogCompletion->oController->updateIntermediate = true;
        $oLogCompletion->oController->updateIntermediateToDate = new Date('2004-06-06 17:59:59');
        $oLogCompletion->oController->updateFinal = true;
        $oLogCompletion->oController->updateFinalToDate = new Date('2004-06-06 17:59:59');
        $end = new Date('2004-06-06 18:14:00');
        $oLogCompletion->run($end);
        // Test
        $query = "
            SELECT
                *
            FROM
                {$conf['table']['prefix']}{$conf['table']['log_maintenance_statistics']}
            WHERE
                tracker_run_type = 2";
        $row = $dbh->getRow($query);
        $this->assertEqual($row['start_run'], '2004-06-06 18:10:00');
        $this->assertEqual($row['end_run'], '2004-06-06 18:14:00');
        $this->assertEqual($row['duration'], 240);
        $this->assertEqual($row['updated_to'], '2004-06-06 17:59:59');
        // Reset the testing environment
        TestEnv::restoreEnv();
    }

}

?>
