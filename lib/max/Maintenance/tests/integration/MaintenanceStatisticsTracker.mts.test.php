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
$Id: MaintenanceStatisticsTracker.mts.test.php 4388 2006-03-09 13:31:34Z andrew@m3.net $
*/

require_once MAX_PATH . '/lib/Max.php';
require_once MAX_PATH . '/lib/max/DB.php';
require_once MAX_PATH . '/lib/max/Table/Core.php';
require_once MAX_PATH . '/lib/max/Maintenance/Statistics/Tracker.php';
require_once 'Date.php';

/**
 * A class for performing integration testing the MAX_Maintenance_Statistics_Tracker class.
 *
 * @package    MaxMaintenance
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew@m3.net>
 * @TODO Update to use a mocked DAL, instead of a real database.
 */
class Maintenance_TestOfMaintenanceStatisticsTracker extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function Maintenance_TestOfMaintenanceStatisticsTracker()
    {
        $this->UnitTestCase();
    }

    /**
     * The main test method.
     */
    function testClass()
    {
        // Use a reference to $GLOBALS['_MAX']['CONF'] so that the configuration
        // options can be changed while the test is running
        $conf = &$GLOBALS['_MAX']['CONF'];
        $conf['table']['prefix'] = 'max_';
        $dbh = &MAX_DB::singleton();
        $tables = MAX_Table_Core::singleton($conf['database']['type'], true);
        // Create the required tables
        $tables->createTable('data_raw_tracker_click');
        $tables->createTable('data_raw_tracker_impression');
        $tables->createTable('data_raw_tracker_variable_value');
        $tables->createTable('log_maintenance_statistics');
        $tables->createTable('userlog');
        // Get the data for the tests
        include_once MAX_PATH . '/lib/max/Maintenance/data/TestOfMaintenanceStatisticsTracker.php';
        // Insert the test data
        $result = $dbh->query(TRACKER_FULL_TEST_TRACKER_IMPRESSIONS);
        $result = $dbh->query(TRACKER_FULL_TEST_TRACKER_VARIABLE_VALUES);
        $result = $dbh->query(TRACKER_FULL_TEST_TRACKER_CLICK);
        // Set up the config as desired for testing
        $conf['maintenance']['operationInterval'] = 60;
        $conf['maintenance']['compactStats'] = false;
        $conf['modules']['Tracker'] = true;
        $conf['table']['split'] = false;
        // Set the "current" time
        $oDateNow = new Date('2004-11-28 12:00:00');
        $oServiceLocator = &ServiceLocator::instance();
        $oServiceLocator->register('now', $oDateNow);
        // Create and run the class
        $oMaintenanceStatistics = new MAX_Maintenance_Statistics_Tracker();
        $oMaintenanceStatistics->updateStatistics();
        // Test the results
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_tracker_impression']}";
        $row = $dbh->getRow($query);
        $this->assertEqual($row['number'], 1);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_tracker_variable_value']}";
        $row = $dbh->getRow($query);
        $this->assertEqual($row['number'], 1);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_tracker_click']}";
        $row = $dbh->getRow($query);
        $this->assertEqual($row['number'], 30);
        // Reset the testing environment
        TestEnv::restoreEnv();
    }

}

?>
