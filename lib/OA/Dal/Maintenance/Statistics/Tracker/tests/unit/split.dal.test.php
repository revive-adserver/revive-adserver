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

require_once MAX_PATH . '/lib/OA.php';
require_once MAX_PATH . '/lib/OA/Dal/Maintenance/Statistics/Tracker/mysqlSplit.php';

/**
 * A class for testing the OA_Dal_Maintenance_Statistics_AdServer_mysqlSplit class.
 *
 * @package    OpenadsDal
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew.hill@openads.org>
 */
class Dal_TestOfMaxDalMaintenanceStatisticsTrackermysqlSplit extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function Dal_TestOfMaxDalMaintenanceStatisticsTrackermysqlSplit()
    {
        $this->UnitTestCase();
    }

    /**
     * Tests that the singleton() method only ever returns one class instance.
     */
    function testSingleton()
    {
        $first = new OA_Dal_Maintenance_Statistics_Tracker_mysqlSplit();
        $second = new OA_Dal_Maintenance_Statistics_Tracker_mysqlSplit();
        $this->assertIdentical($first, $second);
    }

    /**
     * Tests the getMaintenanceStatisticsLastRunInfo() method.
     */
    function testGetMaintenanceStatisticsLastRunInfo()
    {
        $conf = &$GLOBALS['_MAX']['CONF'];
        $oDbh = &OA_DB::singleton();
        $conf['table']['split'] = true;
        $conf['maintenance']['operationInterval'] = 60;
        $dsa = new OA_Dal_Maintenance_Statistics_Tracker_mysqlSplit();
        // Create the required tables
        $now = new Date();
        $dsa->tables->createTable('data_raw_tracker_impression', $now);
        // Test with no data
        $date = $dsa->getMaintenanceStatisticsLastRunInfo(DAL_STATISTICS_COMMON_UPDATE_OI);
        $this->assertNull($date);
        $date = $dsa->getMaintenanceStatisticsLastRunInfo(DAL_STATISTICS_COMMON_UPDATE_HOUR);
        $this->assertNull($date);
        TestEnv::startTransaction();
        // Insert ad impressions
        $now->setHour(18);
        $now->setMinute(22);
        $now->setSecond(10);
        $query = "
            INSERT INTO
                data_raw_tracker_impression_". $now->format('%Y%m%d') ."
                (
                    date_time
                )
            VALUES
                (
                    '" . $now->format('%Y-%m-%d %H:%M:%S') . "'
                )";
        $rows = $oDbh->exec($query);
        $now->setHour(12);
        $now->setMinute(34);
        $now->setSecond(56);
        $query = "
            INSERT INTO
                data_raw_tracker_impression_". $now->format('%Y%m%d') ."
                (
                    date_time
                )
            VALUES
                (
                    '" . $now->format('%Y-%m-%d %H:%M:%S') . "'
                )";
        $rows = $oDbh->exec($query);
        $now->setHour(18);
        $now->setMinute(22);
        $now->setSecond(11);
        $query = "
            INSERT INTO
                data_raw_tracker_impression_". $now->format('%Y%m%d') ."
                (
                    date_time
                )
            VALUES
                (
                    '" . $now->format('%Y-%m-%d %H:%M:%S') . "'
                )";
        $rows = $oDbh->exec($query);
        $now->setHour(11);
        $now->setMinute(59);
        $now->setSecond(59);
        // Test
        $date = $dsa->getMaintenanceStatisticsLastRunInfo(DAL_STATISTICS_COMMON_UPDATE_OI);
        $this->assertEqual($date, $now);
        $date = $dsa->getMaintenanceStatisticsLastRunInfo(DAL_STATISTICS_COMMON_UPDATE_HOUR);
        $this->assertEqual($date, $now);
        // Get the data for the tests
        include_once MAX_PATH . '/lib/max/Dal/data/TestOfStatisticsTrackermysqlSplit.php';
        // Insert an hourly (only) update
        $rows = $oDbh->exec(TOT_SPLIT_LMS_HOUR);
        // Test
        $date = $dsa->getMaintenanceStatisticsLastRunInfo(DAL_STATISTICS_COMMON_UPDATE_OI);
        $this->assertEqual($date, $now);
        $date = $dsa->getMaintenanceStatisticsLastRunInfo(DAL_STATISTICS_COMMON_UPDATE_HOUR);
        $this->assertEqual($date, new Date('2004-06-06 10:15:00'));
        // Insert an operation interval (only) update
        $rows = $oDbh->exec(TOT_SPLIT_LMS_OI);
        // Test
        $date = $dsa->getMaintenanceStatisticsLastRunInfo(DAL_STATISTICS_COMMON_UPDATE_OI);
        $this->assertEqual($date, new Date('2004-06-06 10:16:00'));
        $date = $dsa->getMaintenanceStatisticsLastRunInfo(DAL_STATISTICS_COMMON_UPDATE_HOUR);
        $this->assertEqual($date, new Date('2004-06-06 10:15:00'));
        // Insert a dual interval update
        $rows = $oDbh->exec(TOT_SPLIT_LMS_DUAL);
        // Test
        $date = $dsa->getMaintenanceStatisticsLastRunInfo(DAL_STATISTICS_COMMON_UPDATE_OI);
        $this->assertEqual($date, new Date('2004-06-07 01:15:00'));
        $date = $dsa->getMaintenanceStatisticsLastRunInfo(DAL_STATISTICS_COMMON_UPDATE_HOUR);
        $this->assertEqual($date, new Date('2004-06-07 01:15:00'));
        TestEnv::rollbackTransaction();
    }

    /**
     * Tests the deleteOldData() method.
     */
    function testDeleteOldData()
    {
        $conf = &$GLOBALS['_MAX']['CONF'];
        $oDbh = &OA_DB::singleton();
        $conf['table']['split'] = true;
        $conf['maintenance']['compactStatsGrace'] = 0;
        $dsa = new OA_Dal_Maintenance_Statistics_Tracker_mysqlSplit();
        // Create the required tables
        $now = new Date('2004-06-05');
        $dsa->tables->createTable('data_raw_tracker_click', $now);
        $dsa->tables->createTable('data_raw_tracker_impression', $now);
        $dsa->tables->createTable('data_raw_tracker_variable_value', $now);
        $now = new Date('2004-06-06');
        $dsa->tables->createTable('data_raw_tracker_click', $now);
        $dsa->tables->createTable('data_raw_tracker_impression', $now);
        $dsa->tables->createTable('data_raw_tracker_variable_value', $now);
        // Get the data for the tests
        include_once MAX_PATH . '/lib/max/Dal/data/TestOfStatisticsTrackermysqlSplit.php';
        // Insert the test data
        $rows = $oDbh->exec(TOT_SPLIT_DELETE_OLD_DATA_TRACKER_CLICKS_ONE);
        $rows = $oDbh->exec(TOT_SPLIT_DELETE_OLD_DATA_TRACKER_CLICKS_TWO);
        $rows = $oDbh->exec(TOT_SPLIT_DELETE_OLD_DATA_TRACKER_IMPRESSIONS_ONE);
        $rows = $oDbh->exec(TOT_SPLIT_DELETE_OLD_DATA_TRACKER_IMPRESSIONS_TWO);
        $rows = $oDbh->exec(TOT_SPLIT_DELETE_OLD_DATA_TRACKER_REQUESTS_ONE);
        $rows = $oDbh->exec(TOT_SPLIT_DELETE_OLD_DATA_TRACKER_REQUESTS_TWO);
        // Test
        $summarisedTo = new Date('2004-06-06 17:59:59');
        $dsa->deleteOldData($summarisedTo);
        $now = new Date('2004-06-05');
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_tracker_click']}_" . $now->format('%Y%m%d');
        PEAR::pushErrorHandling(null);
        $aRow = $oDbh->queryRow($query);
        PEAR::popErrorHandling();
        $this->assertTrue(PEAR::isError($aRow, DB_ERROR_NOSUCHTABLE));
        $now = new Date('2004-06-06');
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_tracker_click']}_" . $now->format('%Y%m%d');
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 6);
        $now = new Date('2004-06-05');
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_tracker_impression']}_" . $now->format('%Y%m%d');
        PEAR::pushErrorHandling(null);
        $aRow = $oDbh->queryRow($query);
        PEAR::popErrorHandling();
        $this->assertTrue(PEAR::isError($aRow, DB_ERROR_NOSUCHTABLE));
        $now = new Date('2004-06-06');
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_tracker_impression']}_" . $now->format('%Y%m%d');
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 6);
        $now = new Date('2004-06-05');
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_tracker_variable_value']}_" . $now->format('%Y%m%d');
        PEAR::pushErrorHandling(null);
        $aRow = $oDbh->queryRow($query);
        PEAR::popErrorHandling();
        $this->assertTrue(PEAR::isError($aRow, DB_ERROR_NOSUCHTABLE));
        $now = new Date('2004-06-06');
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_tracker_variable_value']}_" . $now->format('%Y%m%d');
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 6);
        // Restore the testing environment
        TestEnv::restoreEnv();
        $conf = &$GLOBALS['_MAX']['CONF'];
        $oDbh = &OA_DB::singleton();
        $conf['table']['split'] = true;
        // Set a compact_stats_grace window
        $conf['maintenance']['compactStatsGrace'] = 3600;
        $dsa = new OA_Dal_Maintenance_Statistics_Tracker_mysqlSplit();
        // Create the required tables
        $now = new Date('2004-06-05');
        $dsa->tables->createTable('data_raw_tracker_click', $now);
        $dsa->tables->createTable('data_raw_tracker_impression', $now);
        $dsa->tables->createTable('data_raw_tracker_variable_value', $now);
        $now = new Date('2004-06-06');
        $dsa->tables->createTable('data_raw_tracker_click', $now);
        $dsa->tables->createTable('data_raw_tracker_impression', $now);
        $dsa->tables->createTable('data_raw_tracker_variable_value', $now);
        // Insert the test data
        $rows = $oDbh->exec(TOT_SPLIT_DELETE_OLD_DATA_TRACKER_CLICKS_ONE);
        $rows = $oDbh->exec(TOT_SPLIT_DELETE_OLD_DATA_TRACKER_CLICKS_TWO);
        $rows = $oDbh->exec(TOT_SPLIT_DELETE_OLD_DATA_TRACKER_IMPRESSIONS_ONE);
        $rows = $oDbh->exec(TOT_SPLIT_DELETE_OLD_DATA_TRACKER_IMPRESSIONS_TWO);
        $rows = $oDbh->exec(TOT_SPLIT_DELETE_OLD_DATA_TRACKER_REQUESTS_ONE);
        $rows = $oDbh->exec(TOT_SPLIT_DELETE_OLD_DATA_TRACKER_REQUESTS_TWO);
        // Test
        $summarisedTo = new Date('2004-06-06 17:59:59');
        $dsa->deleteOldData($summarisedTo);
        $now = new Date('2004-06-05');
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_tracker_click']}_" . $now->format('%Y%m%d');
        PEAR::pushErrorHandling(null);
        $aRow = $oDbh->queryRow($query);
        PEAR::popErrorHandling();
        $this->assertTrue(PEAR::isError($aRow, DB_ERROR_NOSUCHTABLE));
        $now = new Date('2004-06-06');
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_tracker_click']}_" . $now->format('%Y%m%d');
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 6);
        $now = new Date('2004-06-05');
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_tracker_impression']}_" . $now->format('%Y%m%d');
        PEAR::pushErrorHandling(null);
        $aRow = $oDbh->queryRow($query);
        PEAR::popErrorHandling();
        $this->assertTrue(PEAR::isError($aRow, DB_ERROR_NOSUCHTABLE));
        $now = new Date('2004-06-06');
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_tracker_impression']}_" . $now->format('%Y%m%d');
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 6);
        $now = new Date('2004-06-05');
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_tracker_variable_value']}_" . $now->format('%Y%m%d');
        PEAR::pushErrorHandling(null);
        $aRow = $oDbh->queryRow($query);
        PEAR::popErrorHandling();
        $this->assertTrue(PEAR::isError($aRow, DB_ERROR_NOSUCHTABLE));
        $now = new Date('2004-06-06');
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_tracker_variable_value']}_" . $now->format('%Y%m%d');
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 6);
        TestEnv::restoreEnv();
    }

}

?>
