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
$Id: MaintenanceStatistics.dal.test.php 5631 2006-10-09 18:21:43Z andrew@m3.net $
*/

require_once MAX_PATH . '/lib/max/core/ServiceLocator.php';
require_once MAX_PATH . '/lib/max/Dal/Maintenance/Statistics.php';
require_once 'Date.php';
require_once 'DB/QueryTool.php';

/**
 * A class for testing the MAX_Dal_Maintenance_Statistics class.
 *
 * @package    MaxDal
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew@m3.net>
 * @author     Demian Turner <demian@m3.net>
 * @author     James Floyd <james@m3.net>
 */
class Dal_TestOfMAX_Dal_Maintenance_Statistics extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function Dal_TestOfMAX_Dal_Maintenance_Statistics()
    {
        $this->UnitTestCase();
    }

    /**
     * Method to test the testSetMaintenanceStatisticsRunReport method.
     *
     * Requirements:
     * Test 1: Test two writes to reports.
     */
    function testSetMaintenanceStatisticsRunReport()
    {
        TestEnv::startTransaction();
        require_once MAX_PATH . '/lib/max/other/lib-userlog.inc.php';

        $conf = $GLOBALS['_MAX']['CONF'];
        $dbh = &MAX_DB::singleton();
        $oMaxDalMaintenance = new MAX_Dal_Maintenance_Statistics();

        // Test 1
        $report = 'Maintenance run has finished :: Maintenance will run again at XYZ.';
        $oMaxDalMaintenance->setMaintenanceStatisticsRunReport($report);

        $query = "
            SELECT
                timestamp,
                usertype,
                userid,
                action,
                object,
                details
            FROM
                {$conf['table']['prefix']}{$conf['table']['userlog']}
            WHERE
                userlogid = 1";

        $row = $dbh->getRow($query);
        $this->assertEqual($row['usertype'], phpAds_userMaintenance);
        $this->assertEqual($row['userid'], '0');
        $this->assertEqual($row['action'], phpAds_actionBatchStatistics);
        $this->assertEqual($row['object'], '0');
        $this->assertEqual($row['details'], $report);

        $report = '2nd Maintenance run has finished :: Maintenance will run again at XYZ.';
        $oMaxDalMaintenance->setMaintenanceStatisticsRunReport($report);

        $query = "
            SELECT
                timestamp,
                usertype,
                userid,
                action,
                object,
                details
            FROM
                {$conf['table']['prefix']}{$conf['table']['userlog']}
            WHERE
                userlogid = 2";

           $row = $dbh->getRow($query);
           $this->assertEqual($row['usertype'], phpAds_userMaintenance);
           $this->assertEqual($row['userid'], '0');
           $this->assertEqual($row['action'], phpAds_actionBatchStatistics);
           $this->assertEqual($row['object'], '0');
           $this->assertEqual($row['details'], $report);
           TestEnv::rollbackTransaction();
    }

    /**
     * Method to test the setMaintenanceStatisticsLastRunInfo method.
     *
     * Requirements:
     * Test 1: Test with no data in the database, ensure data is correctly stored.
     * Test 2: Test with previous test data in the database, ensure data is correctly stored.
     * Test 3: Test with previous test data in the database, for type tracker_ad_type
     */
    function testSetMaintenanceStatisticsLastRunInfo()
    {
        TestEnv::startTransaction();
        $conf = $GLOBALS['_MAX']['CONF'];
        $dbh = &MAX_DB::singleton();
        $oMaxDalMaintenance = new MAX_Dal_Maintenance_Statistics();

        // Test 1
        $oStartDate = new Date('2005-06-21 15:00:01');
        $oEndDate   = new Date('2005-06-21 15:01:01');
        $oUpdatedTo = new Date('2005-06-21 15:59:59');
        $runTypeField = 'adserver_run_type';
        $type = 2;
        $oMaxDalMaintenance->setMaintenanceStatisticsLastRunInfo($oStartDate, $oEndDate, $oUpdatedTo, $runTypeField, $type);
        $query = "
            SELECT
                start_run,
                end_run,
                duration,
                {$runTypeField},
                updated_to
            FROM
                {$conf['table']['prefix']}{$conf['table']['log_maintenance_statistics']}
            WHERE
                log_maintenance_statistics_id = 1";
        $row = $dbh->getRow($query);
        $this->assertEqual($row['start_run'], '2005-06-21 15:00:01');
        $this->assertEqual($row['end_run'], '2005-06-21 15:01:01');
        $this->assertEqual($row[$runTypeField], $type);
        $this->assertEqual($row['duration'], 60);
        $this->assertEqual($row['updated_to'], '2005-06-21 15:59:59');

        // Test 2
        $oStartDate = new Date('2005-06-21 16:00:01');
        $oEndDate   = new Date('2005-06-21 16:01:06');
        $oUpdatedTo = new Date('2005-06-21 16:59:59');
        $runTypeField = 'adserver_run_type';
        $type = 2;
        $oMaxDalMaintenance->setMaintenanceStatisticsLastRunInfo($oStartDate, $oEndDate, $oUpdatedTo, $runTypeField, $type);
        $query = "
            SELECT
                start_run,
                end_run,
                duration,
                {$runTypeField},
                updated_to
            FROM
                {$conf['table']['prefix']}{$conf['table']['log_maintenance_statistics']}
            WHERE
                log_maintenance_statistics_id = 1";
        $row = $dbh->getRow($query);
        $this->assertEqual($row['start_run'], '2005-06-21 15:00:01');
        $this->assertEqual($row['end_run'], '2005-06-21 15:01:01');
        $this->assertEqual($row[$runTypeField], $type);
        $this->assertEqual($row['duration'], 60);
        $this->assertEqual($row['updated_to'], '2005-06-21 15:59:59');
        $query = "
            SELECT
                start_run,
                end_run,
                duration,
                {$runTypeField},
                updated_to
            FROM
                {$conf['table']['prefix']}{$conf['table']['log_maintenance_statistics']}
            WHERE
                log_maintenance_statistics_id = 2";
        $row = $dbh->getRow($query);
        $this->assertEqual($row['start_run'], '2005-06-21 16:00:01');
        $this->assertEqual($row['end_run'], '2005-06-21 16:01:06');
        $this->assertEqual($row[$runTypeField], $type);
        $this->assertEqual($row['duration'], 65);
        $this->assertEqual($row['updated_to'], '2005-06-21 16:59:59');

        // Test 3:
        $oStartDate = new Date('2005-06-21 16:00:01');
        $oEndDate   = new Date('2005-06-21 16:02:07');
        $oUpdatedTo = new Date('2005-06-21 16:59:59');
        $runTypeField = 'tracker_run_type';
        $type = 2;
        $oMaxDalMaintenance->setMaintenanceStatisticsLastRunInfo($oStartDate, $oEndDate, $oUpdatedTo, $runTypeField, $type);
        $query = "
            SELECT
                start_run,
                end_run,
                duration,
                {$runTypeField},
                updated_to
            FROM
                {$conf['table']['prefix']}{$conf['table']['log_maintenance_statistics']}
            WHERE
                log_maintenance_statistics_id = 3";
        $row = $dbh->getRow($query);
        $this->assertEqual($row['start_run'], '2005-06-21 16:00:01');
        $this->assertEqual($row['end_run'], '2005-06-21 16:02:07');
        $this->assertEqual($row[$runTypeField], $type);
        $this->assertEqual($row['duration'], 126);
        $this->assertEqual($row['updated_to'], '2005-06-21 16:59:59');
        TestEnv::rollbackTransaction();
    }

}

?>
