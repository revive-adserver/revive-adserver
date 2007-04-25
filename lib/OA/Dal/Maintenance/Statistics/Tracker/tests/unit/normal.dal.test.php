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

require_once MAX_PATH . '/lib/OA.php';
require_once MAX_PATH . '/lib/OA/Dal/Maintenance/Statistics/Tracker/mysql.php';

/**
 * A class for testing the OA_Dal_Maintenance_Statistics_Tracker_mysql_MySql class.
 *
 * @package    OpenadsDal
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew.hill@openads.org>
 */
class Dal_TestOfMaxDalMaintenanceStatisticsTrackermysql extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function Dal_TestOfMaxDalMaintenanceStatisticsTrackermysql()
    {
        $this->UnitTestCase();
    }

    /**
     * A private method to insert test impressions for testing the
     * deleteOldData method.
     *
     * @access private
     */
    function _insertTestDeleteImpressions()
    {
        $oDbh = &OA_DB::singleton();
        $query = "
            INSERT INTO
                data_raw_tracker_impression
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
            '2004-06-06 18:00:00'
        );
        $rows = $st->execute($aData);
        $aData = array(
            2,
            1,
            '2004-06-06 17:59:59'
        );
        $rows = $st->execute($aData);
        $aData = array(
            3,
            1,
            '2004-06-06 17:00:00'
        );
        $rows = $st->execute($aData);
        $aData = array(
            4,
            1,
            '2004-06-06 16:59:59'
        );
        $rows = $st->execute($aData);
        $aData = array(
            5,
            1,
            '2004-06-06 16:00:00'
        );
        $rows = $st->execute($aData);
        $aData = array(
            6,
            1,
            '2004-06-06 15:59:59'
        );
        $rows = $st->execute($aData);
    }

    /**
     * A private method to insert test clicks for testing the
     * deleteOldData method.
     *
     * @access private
     */
    function _insertTestDeleteClicks()
    {
        $oDbh = &OA_DB::singleton();
        $query = "
            INSERT INTO
                data_raw_tracker_click
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
            '2004-06-06 18:00:00'
        );
        $rows = $st->execute($aData);
        $aData = array(
            1,
            '2004-06-06 17:59:59'
        );
        $rows = $st->execute($aData);
        $aData = array(
            1,
            '2004-06-06 17:00:00'
        );
        $rows = $st->execute($aData);
        $aData = array(
            1,
            '2004-06-06 16:59:59'
        );
        $rows = $st->execute($aData);
        $aData = array(
            1,
            '2004-06-06 16:00:00'
        );
        $rows = $st->execute($aData);
        $aData = array(
            1,
            '2004-06-06 15:59:59'
        );
        $rows = $st->execute($aData);
    }

    /**
     * A private method to insert test impressions for testing the
     * deleteOldData method.
     *
     * @access private
     */
    function _insertTestDeleteVariableValues()
    {
        $oDbh = &OA_DB::singleton();
        $query = "
            INSERT INTO
                data_raw_tracker_variable_value
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
            '2004-06-06 18:00:00'
        );
        $rows = $st->execute($aData);
        $aData = array(
            2,
            1,
            '2004-06-06 17:59:59'
        );
        $rows = $st->execute($aData);
        $aData = array(
            3,
            1,
            '2004-06-06 17:00:00'
        );
        $rows = $st->execute($aData);
        $aData = array(
            4,
            1,
            '2004-06-06 16:59:59'
        );
        $rows = $st->execute($aData);
        $aData = array(
            5,
            1,
            '2004-06-06 16:00:00'
        );
        $rows = $st->execute($aData);
        $aData = array(
            6,
            1,
            '2004-06-06 15:59:59'
        );
        $rows = $st->execute($aData);
    }

    /**
     * Tests that the singleton() method only ever returns one class instance.
     */
    function testSingleton()
    {
        $first = new OA_Dal_Maintenance_Statistics_Tracker_mysql();
        $second = new OA_Dal_Maintenance_Statistics_Tracker_mysql();
        $this->assertIdentical($first, $second);
    }

    /**
     * Tests the getMaintenanceStatisticsLastRunInfo() method.
     */
    function testGetMaintenanceStatisticsLastRunInfo()
    {
        $conf = &$GLOBALS['_MAX']['CONF'];
        $oDbh = &OA_DB::singleton();
        $conf['maintenance']['operationInterval'] = 60;
        $conf['table']['split'] = false;
        $dsa = new OA_Dal_Maintenance_Statistics_Tracker_mysql();
        // Test with no data
        $date = $dsa->getMaintenanceStatisticsLastRunInfo(OA_DAL_MAINTENANCE_STATISTICS_UPDATE_OI);
        $this->assertNull($date);
        $date = $dsa->getMaintenanceStatisticsLastRunInfo(OA_DAL_MAINTENANCE_STATISTICS_UPDATE_HOUR);
        $this->assertNull($date);
        // Insert tracker impressions
        $query = "
            INSERT INTO
                data_raw_tracker_impression
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
            '2004-06-06 18:22:10'
        );
        $rows = $st->execute($aData);
        $aData = array(
            1,
            '2004-05-06 12:34:56'
        );
        $rows = $st->execute($aData);
        $aData = array(
            1,
            '2004-06-06 18:22:11'
        );
        $rows = $st->execute($aData);
        // Test
        $date = $dsa->getMaintenanceStatisticsLastRunInfo(OA_DAL_MAINTENANCE_STATISTICS_UPDATE_OI);
        $this->assertEqual($date, new Date('2004-05-06 11:59:59'));
        $date = $dsa->getMaintenanceStatisticsLastRunInfo(OA_DAL_MAINTENANCE_STATISTICS_UPDATE_HOUR);
        $this->assertEqual($date, new Date('2004-05-06 11:59:59'));
        // Insert an hourly (only) update
        $query = "
            INSERT INTO
                log_maintenance_statistics
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
        $this->assertEqual($date, new Date('2004-05-06 11:59:59'));
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
    function testDeleteOldData()
    {
        $conf = &$GLOBALS['_MAX']['CONF'];
        $oDbh = &OA_DB::singleton();
        $conf['maintenance']['compactStatsGrace'] = 0;
        $dsa = new OA_Dal_Maintenance_Statistics_Tracker_mysql();
        // Insert the test data
        $this->_insertTestDeleteImpressions();
        $this->_insertTestDeleteVariableValues();
        $this->_insertTestDeleteClicks();
        // Test
        $summarisedTo = new Date('2004-06-06 17:59:59');
        $dsa->deleteOldData($summarisedTo);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_tracker_click']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_tracker_impression']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_tracker_variable_value']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 1);
        TestEnv::restoreEnv();
        // Set a compact_stats_grace window
        $conf['maintenance']['compactStatsGrace'] = 3600;
        $dsa = new OA_Dal_Maintenance_Statistics_Tracker_mysql();
        // Insert the test data
        $this->_insertTestDeleteImpressions();
        $this->_insertTestDeleteVariableValues();
        $this->_insertTestDeleteClicks();
        // Test
        $summarisedTo = new Date('2004-06-06 17:59:59');
        $dsa->deleteOldData($summarisedTo);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_tracker_click']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 3);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_tracker_impression']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 3);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_tracker_variable_value']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 3);
        TestEnv::restoreConfig();
    }

}

?>
