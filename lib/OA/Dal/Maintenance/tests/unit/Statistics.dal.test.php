<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
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

require_once MAX_PATH . '/lib/OA/Dal/Maintenance/Statistics.php';
require_once MAX_PATH . '/lib/OA/ServiceLocator.php';
require_once MAX_PATH . '/lib/pear/Date.php';
require_once 'DB/QueryTool.php';

/**
 * A class for testing the non-DB specific OA_Dal_Maintenance_Statistics class.
 *
 * @package    OpenXDal
 * @subpackage TestSuite
 * @author     James Floyd <james@m3.net>
 * @author     Andrew Hill <andrew.hill@openx.org>
 * @author     Demian Turner <demian@m3.net>
 */
class Test_OA_Dal_Maintenance_Statistics extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function Test_OA_Dal_Maintenance_Statistics()
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
        require_once MAX_PATH . '/lib/max/other/lib-userlog.inc.php';

        $conf = $GLOBALS['_MAX']['CONF'];
        $oDbh =& OA_DB::singleton();
        $oMaxDalMaintenance = new OA_Dal_Maintenance_Statistics();

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
                ".$oDbh->quoteIdentifier($conf['table']['prefix'].$conf['table']['userlog'],true)."
            WHERE
                userlogid = 1";

        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['usertype'], phpAds_userMaintenance);
        $this->assertEqual($aRow['userid'], '0');
        $this->assertEqual($aRow['action'], phpAds_actionBatchStatistics);
        $this->assertEqual($aRow['object'], '0');
        $this->assertEqual($aRow['details'], $report);

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
                ".$oDbh->quoteIdentifier($conf['table']['prefix'].$conf['table']['userlog'],true)."
            WHERE
                userlogid = 2";

        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['usertype'], phpAds_userMaintenance);
        $this->assertEqual($aRow['userid'], '0');
        $this->assertEqual($aRow['action'], phpAds_actionBatchStatistics);
        $this->assertEqual($aRow['object'], '0');
        $this->assertEqual($aRow['details'], $report);

        TestEnv::restoreEnv();
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
        $conf = $GLOBALS['_MAX']['CONF'];
        $oDbh =& OA_DB::singleton();
        $oMaxDalMaintenance = new OA_Dal_Maintenance_Statistics();

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
                ".$oDbh->quoteIdentifier($conf['table']['prefix'].$conf['table']['log_maintenance_statistics'],true)."
            WHERE
                log_maintenance_statistics_id = 1";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['start_run'], '2005-06-21 15:00:01');
        $this->assertEqual($aRow['end_run'], '2005-06-21 15:01:01');
        $this->assertEqual($aRow[$runTypeField], $type);
        $this->assertEqual($aRow['duration'], 60);
        $this->assertEqual($aRow['updated_to'], '2005-06-21 15:59:59');

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
                ".$oDbh->quoteIdentifier($conf['table']['prefix'].$conf['table']['log_maintenance_statistics'],true)."
            WHERE
                log_maintenance_statistics_id = 1";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['start_run'], '2005-06-21 15:00:01');
        $this->assertEqual($aRow['end_run'], '2005-06-21 15:01:01');
        $this->assertEqual($aRow[$runTypeField], $type);
        $this->assertEqual($aRow['duration'], 60);
        $this->assertEqual($aRow['updated_to'], '2005-06-21 15:59:59');
        $query = "
            SELECT
                start_run,
                end_run,
                duration,
                {$runTypeField},
                updated_to
            FROM
                ".$oDbh->quoteIdentifier($conf['table']['prefix'].$conf['table']['log_maintenance_statistics'],true)."
            WHERE
                log_maintenance_statistics_id = 2";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['start_run'], '2005-06-21 16:00:01');
        $this->assertEqual($aRow['end_run'], '2005-06-21 16:01:06');
        $this->assertEqual($aRow[$runTypeField], $type);
        $this->assertEqual($aRow['duration'], 65);
        $this->assertEqual($aRow['updated_to'], '2005-06-21 16:59:59');

        // Test 3
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
                ".$oDbh->quoteIdentifier($conf['table']['prefix'].$conf['table']['log_maintenance_statistics'],true)."
            WHERE
                log_maintenance_statistics_id = 3";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['start_run'], '2005-06-21 16:00:01');
        $this->assertEqual($aRow['end_run'], '2005-06-21 16:02:07');
        $this->assertEqual($aRow[$runTypeField], $type);
        $this->assertEqual($aRow['duration'], 126);
        $this->assertEqual($aRow['updated_to'], '2005-06-21 16:59:59');

        TestEnv::restoreEnv();
    }

}

?>
