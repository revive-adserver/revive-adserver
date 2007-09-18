<?php

/*
+---------------------------------------------------------------------------+
| Openads v${RELEASE_MAJOR_MINOR}                                                              |
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

require_once MAX_PATH . '/lib/OA.php';
require_once MAX_PATH . '/lib/OA/Dal/Maintenance/Statistics/Tracker/'.$GLOBALS['_MAX']['CONF']['database']['type'].'Split.php';

/**
 * A class for testing the OA_Dal_Maintenance_Statistics_AdServer_<dbms>Split classes.
 *
 * @package    OpenadsDal
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew.hill@openads.org>
 */
class Dal_TestOfMaxDalMaintenanceStatisticsTrackerSplit extends UnitTestCase
{
    var $dbms;

    /**
     * The constructor method.
     */
    function Dal_TestOfMaxDalMaintenanceStatisticsTrackerSplit()
    {
        $this->UnitTestCase();
        $this->dbms = $GLOBALS['_MAX']['CONF']['database']['type'];
    }

    /**
     * A private method to insert test impressions for testing the
     * deleteOldData method.
     *
     * @param PEAR::Date $oDate The date to use for the table, and the day of the impressions.
     * @access private
     */
    function _insertTestDeleteImpressions($oDate)
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        $oDbh =& OA_DB::singleton();
        $table = $oDbh->quoteIdentifier($aConf['table']['prefix'].'data_raw_tracker_impression_'.$oDate->format('%Y%m%d'),true);
        $query = "
            INSERT INTO
                {$table}
                (
                    server_raw_tracker_impression_id,
                    tracker_id,
                    date_time
                )
            VALUES
                (?, ?, ?)";
        $aTypes = array(
            'integer',
            'integer',
            'timestamp'
        );
        $st = $oDbh->prepare($query, $aTypes, MDB2_PREPARE_MANIP);
        $aData = array(
            1,
            1,
            $oDate->format('%Y-%m-%d') . ' 18:00:00'
        );
        $rows = $st->execute($aData);
        $aData = array(
            2,
            1,
            $oDate->format('%Y-%m-%d') . ' 17:59:59'
        );
        $rows = $st->execute($aData);
        $aData = array(
            3,
            1,
            $oDate->format('%Y-%m-%d') . ' 17:00:00'
        );
        $rows = $st->execute($aData);
        $aData = array(
            4,
            1,
            $oDate->format('%Y-%m-%d') . ' 16:59:59'
        );
        $rows = $st->execute($aData);
        $aData = array(
            5,
            1,
            $oDate->format('%Y-%m-%d') . ' 16:00:00'
        );
        $rows = $st->execute($aData);
        $aData = array(
            6,
            1,
            $oDate->format('%Y-%m-%d') . ' 15:59:59'
        );
        $rows = $st->execute($aData);
    }

    /**
     * A private method to insert test clicks for testing the
     * deleteOldData method.
     *
     * @param PEAR::Date $oDate The date to use for the table, and the day of the clicks.
     * @access private
     */
    function _insertTestDeleteClicks($oDate)
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        $oDbh =& OA_DB::singleton();
        $table = $oDbh->quoteIdentifier($aConf['table']['prefix'].'data_raw_tracker_click_'.$oDate->format('%Y%m%d'),true);
        $query = "
            INSERT INTO
                {$table}
                (
                    tracker_id,
                    date_time
                )
            VALUES
                (?, ?)";
        $aTypes = array(
            'integer',
            'timestamp'
        );
        $st = $oDbh->prepare($query, $aTypes, MDB2_PREPARE_MANIP);
        $aData = array(
            1,
            $oDate->format('%Y-%m-%d') . ' 18:00:00'
        );
        $rows = $st->execute($aData);
        $aData = array(
            1,
            $oDate->format('%Y-%m-%d') . ' 17:59:59'
        );
        $rows = $st->execute($aData);
        $aData = array(
            1,
            $oDate->format('%Y-%m-%d') . ' 17:00:00'
        );
        $rows = $st->execute($aData);
        $aData = array(
            1,
            $oDate->format('%Y-%m-%d') . ' 16:59:59'
        );
        $rows = $st->execute($aData);
        $aData = array(
            1,
            $oDate->format('%Y-%m-%d') . ' 16:00:00'
        );
        $rows = $st->execute($aData);
        $aData = array(
            1,
            $oDate->format('%Y-%m-%d') . ' 15:59:59'
        );
        $rows = $st->execute($aData);
    }

    /**
     * A private method to insert test impressions for testing the
     * deleteOldData method.
     *
     * @param PEAR::Date $oDate The date to use for the table, and the day of the variable values.
     * @access private
     */
    function _insertTestDeleteVariableValues($oDate)
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        $oDbh =& OA_DB::singleton();
        $table = $oDbh->quoteIdentifier($aConf['table']['prefix'].'data_raw_tracker_variable_value_'.$oDate->format('%Y%m%d'),true);
        $query = "
            INSERT INTO
                {$table}
                (
                    server_raw_tracker_impression_id,
                    tracker_variable_id,
                    date_time
                )
            VALUES
                (?, ?, ?)";
        $aTypes = array(
            'integer',
            'integer',
            'timestamp'
        );
        $st = $oDbh->prepare($query, $aTypes, MDB2_PREPARE_MANIP);
        $aData = array(
            1,
            1,
            $oDate->format('%Y-%m-%d') . ' 18:00:00'
        );
        $rows = $st->execute($aData);
        $aData = array(
            2,
            1,
            $oDate->format('%Y-%m-%d') . ' 17:59:59'
        );
        $rows = $st->execute($aData);
        $aData = array(
            3,
            1,
            $oDate->format('%Y-%m-%d') . ' 17:00:00'
        );
        $rows = $st->execute($aData);
        $aData = array(
            4,
            1,
            $oDate->format('%Y-%m-%d') . ' 16:59:59'
        );
        $rows = $st->execute($aData);
        $aData = array(
            5,
            1,
            $oDate->format('%Y-%m-%d') . ' 16:00:00'
        );
        $rows = $st->execute($aData);
        $aData = array(
            6,
            1,
            $oDate->format('%Y-%m-%d') . ' 15:59:59'
        );
        $rows = $st->execute($aData);
    }

    /**
     * Tests that the singleton() method only ever returns one class instance.
     */
    function DEPRECATED_testSingleton()
    {
        if ($this->dbms == 'mysql')
        {
            $first = new OA_Dal_Maintenance_Statistics_Tracker_mysqlSplit();
            $second = new OA_Dal_Maintenance_Statistics_Tracker_mysqlSplit();
        }
        else if ($this->dbms == 'pgsql')
        {
            $first = new OA_Dal_Maintenance_Statistics_Tracker_pgsqlSplit();
            $second = new OA_Dal_Maintenance_Statistics_Tracker_pgsqlSplit();
        }
        $this->assertIdentical($first, $second);
    }

    /**
     * Tests the getMaintenanceStatisticsLastRunInfo() method.
     */
    function DEPRECATED_testGetMaintenanceStatisticsLastRunInfo()
    {
        $aConf =& $GLOBALS['_MAX']['CONF'];
        $oDbh =& OA_DB::singleton();
        $aConf['table']['split'] = true;
        $aConf['maintenance']['operationInterval'] = 60;
        if ($this->dbms == 'mysql')
        {
            $dsa = new OA_Dal_Maintenance_Statistics_Tracker_mysqlSplit();
        }
        else if ($this->dbms == 'pgsql')
        {
            $dsa = new OA_Dal_Maintenance_Statistics_Tracker_pgsqlSplit();
        }
        // Create the required tables
        $now = new Date();
        $dsa->tables->createTable('data_raw_tracker_impression', $now);
        // Test with no data
        $date = $dsa->getMaintenanceStatisticsLastRunInfo(OA_DAL_MAINTENANCE_STATISTICS_UPDATE_OI);
        $this->assertNull($date);
        $date = $dsa->getMaintenanceStatisticsLastRunInfo(OA_DAL_MAINTENANCE_STATISTICS_UPDATE_HOUR);
        $this->assertNull($date);
        // Insert ad impressions
        $now->setHour(18);
        $now->setMinute(22);
        $now->setSecond(10);
        $table = $oDbh->quoteIdentifier($aConf['table']['prefix'].'data_raw_tracker_impression_'.$now->format('%Y%m%d'),true);
        $query = "
            INSERT INTO
                {$table}
                (
                    tracker_id,
                    date_time
                )
            VALUES
                (
                    1,
                    '" . $now->format('%Y-%m-%d %H:%M:%S') . "'
                )";
        $rows = $oDbh->exec($query);
        $now->setHour(12);
        $now->setMinute(34);
        $now->setSecond(56);
        $table = $oDbh->quoteIdentifier($aConf['table']['prefix'].'data_raw_tracker_impression_'.$now->format('%Y%m%d'),true);
        $query = "
            INSERT INTO
                {$table}
                (
                    tracker_id,
                    date_time
                )
            VALUES
                (
                    1,
                    '" . $now->format('%Y-%m-%d %H:%M:%S') . "'
                )";
        $rows = $oDbh->exec($query);
        $now->setHour(18);
        $now->setMinute(22);
        $now->setSecond(11);
        $table = $oDbh->quoteIdentifier($aConf['table']['prefix'].'data_raw_tracker_impression_'.$now->format('%Y%m%d'),true);
        $query = "
            INSERT INTO
                {$table}
                (
                    tracker_id,
                    date_time
                )
            VALUES
                (
                    1,
                    '" . $now->format('%Y-%m-%d %H:%M:%S') . "'
                )";
        $rows = $oDbh->exec($query);
        $now->setHour(11);
        $now->setMinute(59);
        $now->setSecond(59);
        // Test
        $date = $dsa->getMaintenanceStatisticsLastRunInfo(OA_DAL_MAINTENANCE_STATISTICS_UPDATE_OI);
        $this->assertEqual($date, $now);
        $date = $dsa->getMaintenanceStatisticsLastRunInfo(OA_DAL_MAINTENANCE_STATISTICS_UPDATE_HOUR);
        $this->assertEqual($date, $now);
        // Insert an hourly (only) update
        $table = $oDbh->quoteIdentifier($aConf['table']['prefix'].'log_maintenance_statistics',true);
        $query = "
            INSERT INTO
                {$table}
                (
                    start_run,
                    end_run,
                    duration,
                    tracker_run_type,
                    updated_to
                )
            VALUES
                (?, ?, ?, ?, ?)";
        $aTypes = array(
            'timestamp',
            'timestamp',
            'integer',
            'integer',
            'timestamp'
        );
        $st = $oDbh->prepare($query, $aTypes, MDB2_PREPARE_MANIP);
        $aData = array(
            '2004-05-05 12:00:00',
            '2004-05-05 12:00:05',
            5,
            1,
            '2004-05-05 12:00:00'
        );
        $rows = $st->execute($aData);
        $aData = array(
            '2004-06-06 10:15:00',
            '2004-06-06 10:16:15',
            75,
            1,
            '2004-06-06 10:15:00'
        );
        $rows = $st->execute($aData);
        // Test
        $date = $dsa->getMaintenanceStatisticsLastRunInfo(OA_DAL_MAINTENANCE_STATISTICS_UPDATE_OI);
        $this->assertEqual($date, $now);
        $date = $dsa->getMaintenanceStatisticsLastRunInfo(OA_DAL_MAINTENANCE_STATISTICS_UPDATE_HOUR);
        $this->assertEqual($date, new Date('2004-06-06 10:15:00'));
        // Insert an operation interval (only) update
        $aData = array(
            '2004-05-05 12:00:00',
            '2004-05-05 12:00:05',
            5,
            0,
            '2004-05-05 12:00:00'
        );
        $rows = $st->execute($aData);
        $aData = array(
            '2004-06-06 10:16:00',
            '2004-06-06 10:16:15',
            15,
            0,
            '2004-06-06 10:16:00'
        );
        $rows = $st->execute($aData);
        // Test
        $date = $dsa->getMaintenanceStatisticsLastRunInfo(OA_DAL_MAINTENANCE_STATISTICS_UPDATE_OI);
        $this->assertEqual($date, new Date('2004-06-06 10:16:00'));
        $date = $dsa->getMaintenanceStatisticsLastRunInfo(OA_DAL_MAINTENANCE_STATISTICS_UPDATE_HOUR);
        $this->assertEqual($date, new Date('2004-06-06 10:15:00'));
        // Insert a dual interval update
        $aData = array(
            '2004-06-07 01:15:00',
            '2004-06-07 01:16:15',
            75,
            2,
            '2004-06-07 01:15:00'
        );
        $rows = $st->execute($aData);
        // Test
        $date = $dsa->getMaintenanceStatisticsLastRunInfo(OA_DAL_MAINTENANCE_STATISTICS_UPDATE_OI);
        $this->assertEqual($date, new Date('2004-06-07 01:15:00'));
        $date = $dsa->getMaintenanceStatisticsLastRunInfo(OA_DAL_MAINTENANCE_STATISTICS_UPDATE_HOUR);
        $this->assertEqual($date, new Date('2004-06-07 01:15:00'));
        TestEnv::restoreEnv();
    }

    /**
     * Tests the deleteOldData() method.
     */
    function DEPRECATED_testDeleteOldData()
    {
        $aConf =& $GLOBALS['_MAX']['CONF'];
        $oDbh =& OA_DB::singleton();
        $aConf['table']['split'] = true;
        $aConf['maintenance']['compactStatsGrace'] = 0;
        if ($this->dbms == 'mysql')
        {
            $dsa = new OA_Dal_Maintenance_Statistics_Tracker_mysqlSplit();
        }
        else if ($this->dbms == 'pgsql')
        {
            $dsa = new OA_Dal_Maintenance_Statistics_Tracker_pgsqlSplit();
        }
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
        $oDate = new Date('20040605');
        $this->_insertTestDeleteImpressions($oDate);
        $this->_insertTestDeleteVariableValues($oDate);
        $this->_insertTestDeleteClicks($oDate);
        $oDate = new Date('20040606');
        $this->_insertTestDeleteImpressions($oDate);
        $this->_insertTestDeleteVariableValues($oDate);
        $this->_insertTestDeleteClicks($oDate);
        // Test
        $summarisedTo = new Date('2004-06-06 17:59:59');
        $dsa->deleteOldData($summarisedTo);

        $aRow = $this->_getRowCount('data_raw_tracker_click', '2004-06-05',true);
        $this->assertTrue(PEAR::isError($aRow, DB_ERROR_NOSUCHTABLE));

        $aRow = $this->_getRowCount('data_raw_tracker_click','2004-06-06');
        $this->assertEqual($aRow['number'], 6);

        $aRow = $this->_getRowCount('data_raw_tracker_impression','2004-06-05',true);
        $this->assertTrue(PEAR::isError($aRow, DB_ERROR_NOSUCHTABLE));

        $aRow = $this->_getRowCount('data_raw_tracker_impression','2004-06-06');
        $this->assertEqual($aRow['number'], 6);

        $aRow = $this->_getRowCount('data_raw_tracker_variable_value','2004-06-05',true);
        $this->assertTrue(PEAR::isError($aRow, DB_ERROR_NOSUCHTABLE));

        $aRow = $this->_getRowCount('data_raw_tracker_variable_value','2004-06-06');
        $this->assertEqual($aRow['number'], 6);

        TestEnv::restoreEnv();

        $aConf =& $GLOBALS['_MAX']['CONF'];
        $oDbh =& OA_DB::singleton();
        $aConf['table']['split'] = true;
        // Set a compact_stats_grace window
        $aConf['maintenance']['compactStatsGrace'] = 3600;
        if ($this->dbms == 'mysql')
        {
            $dsa = new OA_Dal_Maintenance_Statistics_Tracker_mysqlSplit();
        }
        else if ($this->dbms == 'pgsql')
        {
            $dsa = new OA_Dal_Maintenance_Statistics_Tracker_pgsqlSplit();
        }
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
        $oDate = new Date('20040605');
        $this->_insertTestDeleteImpressions($oDate);
        $this->_insertTestDeleteVariableValues($oDate);
        $this->_insertTestDeleteClicks($oDate);
        $oDate = new Date('20040606');
        $this->_insertTestDeleteImpressions($oDate);
        $this->_insertTestDeleteVariableValues($oDate);
        $this->_insertTestDeleteClicks($oDate);
        // Test
        $summarisedTo = new Date('2004-06-06 17:59:59');
        $dsa->deleteOldData($summarisedTo);

        $aRow = $this->_getRowCount('data_raw_tracker_click','2004-06-05',true);
        $this->assertTrue(PEAR::isError($aRow, DB_ERROR_NOSUCHTABLE));

        $aRow = $this->_getRowCount('data_raw_tracker_click','2004-06-06');
        $this->assertEqual($aRow['number'], 6);

        $aRow = $this->_getRowCount('data_raw_tracker_impression','2004-06-05',true);
        $this->assertTrue(PEAR::isError($aRow, DB_ERROR_NOSUCHTABLE));

        $aRow = $this->_getRowCount('data_raw_tracker_impression','2004-06-06');
        $this->assertEqual($aRow['number'], 6);

        $aRow = $this->_getRowCount('data_raw_tracker_impression','2004-06-05',true);
        $this->assertTrue(PEAR::isError($aRow, DB_ERROR_NOSUCHTABLE));

        $aRow = $this->_getRowCount('data_raw_tracker_variable_value','2004-06-06');
        $this->assertEqual($aRow['number'], 6);

        TestEnv::restoreEnv();
    }

    function _getRowCount($table, $date='',$error=false)
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        $table = $aConf['table']['prefix'].$aConf['table'][$table];
        if ($date)
        {
            $now = new Date($date);
            $table.='_'.$now->format('%Y%m%d');
        }
        $oDbh =& OA_DB::singleton();
        $table = $oDbh->quoteIdentifier($table,true);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$table}";
        if($error)
        {
            PEAR::pushErrorHandling(null);
        }
        $aRow = $oDbh->queryRow($query);
        if($error)
        {
            PEAR::popErrorHandling();
        }
        return $aRow;
    }

}

?>
