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

require_once MAX_PATH . '/lib/Max.php';
require_once MAX_PATH . '/lib/max/DB.php';
require_once MAX_PATH . '/lib/max/Dal/Maintenance/Statistics/Tracker/mysql.php';

/**
 * A class for testing the OA_Dal_Maintenance_Statistics_Tracker_mysql_MySql class.
 *
 * @package    MaxDal
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew@m3.net>
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
        $date = $dsa->getMaintenanceStatisticsLastRunInfo(DAL_STATISTICS_COMMON_UPDATE_OI);
        $this->assertNull($date);
        $date = $dsa->getMaintenanceStatisticsLastRunInfo(DAL_STATISTICS_COMMON_UPDATE_HOUR);
        $this->assertNull($date);
        TestEnv::startTransaction();
        // Get the data for the tests
        include_once MAX_PATH. '/lib/max/Dal/data/TestOfStatisticsTrackermysql.php';
        // Insert tracker impressions
        $aRow = $oDbh->exec(TOT_DATA_RAW_TRACKER_IMPRESSIONS);
        // Test
        $date = $dsa->getMaintenanceStatisticsLastRunInfo(DAL_STATISTICS_COMMON_UPDATE_OI);
        $this->assertEqual($date, new Date('2004-05-06 11:59:59'));
        $date = $dsa->getMaintenanceStatisticsLastRunInfo(DAL_STATISTICS_COMMON_UPDATE_HOUR);
        $this->assertEqual($date, new Date('2004-05-06 11:59:59'));
        // Insert an hourly (only) update
        $aRow = $oDbh->exec(TOT_LMS_HOUR);
        // Test
        $date = $dsa->getMaintenanceStatisticsLastRunInfo(DAL_STATISTICS_COMMON_UPDATE_OI);
        $this->assertEqual($date, new Date('2004-05-06 11:59:59'));
        $date = $dsa->getMaintenanceStatisticsLastRunInfo(DAL_STATISTICS_COMMON_UPDATE_HOUR);
        $this->assertEqual($date, new Date('2004-06-06 10:15:00'));
        // Insert an operation interval (only) update
        $aRow = $oDbh->exec(TOT_LMS_OI);
        // Test
        $date = $dsa->getMaintenanceStatisticsLastRunInfo(DAL_STATISTICS_COMMON_UPDATE_OI);
        $this->assertEqual($date, new Date('2004-06-06 10:16:00'));
        $date = $dsa->getMaintenanceStatisticsLastRunInfo(DAL_STATISTICS_COMMON_UPDATE_HOUR);
        $this->assertEqual($date, new Date('2004-06-06 10:15:00'));
        // Insert a dual interval update
        $aRow = $oDbh->exec(TOT_LMS_DUAL);
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
        $conf['maintenance']['compactStatsGrace'] = 0;
        $dsa = new OA_Dal_Maintenance_Statistics_Tracker_mysql();
        TestEnv::startTransaction();
        // Get the data for the tests
        include_once MAX_PATH . '/lib/max/Dal/data/TestOfStatisticsTrackermysql.php';
        // Insert the test data
        $aRow = $oDbh->exec(TOT_DELETE_OLD_DATA_TRACKER_CLICKS);
        $aRow = $oDbh->exec(TOT_DELETE_OLD_DATA_TRACKER_IMPRESSIONS);
        $aRow = $oDbh->exec(TOT_DELETE_OLD_DATA_TRACKER_VARIABLE_VALUES);
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
        TestEnv::rollbackTransaction();
        // Set a compact_stats_grace window
        $conf['maintenance']['compactStatsGrace'] = 3600;
        $dsa = new OA_Dal_Maintenance_Statistics_Tracker_mysql();
        TestEnv::startTransaction();
        // Insert the test data
        $aRow = $oDbh->exec(TOT_DELETE_OLD_DATA_TRACKER_CLICKS);
        $aRow = $oDbh->exec(TOT_DELETE_OLD_DATA_TRACKER_IMPRESSIONS);
        $aRow = $oDbh->exec(TOT_DELETE_OLD_DATA_TRACKER_VARIABLE_VALUES);
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
        TestEnv::rollbackTransaction();
    }

}

?>
