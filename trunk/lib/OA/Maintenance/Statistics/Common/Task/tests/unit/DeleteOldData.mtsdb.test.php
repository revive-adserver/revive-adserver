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

require_once MAX_PATH . '/lib/OA/Maintenance/Statistics/AdServer.php';
require_once MAX_PATH . '/lib/OA/Maintenance/Statistics/Common/Task/DeleteOldData.php';
require_once MAX_PATH . '/lib/OA/ServiceLocator.php';

/**
 * A class for testing the OA_Maintenance_Statistics_Common_Task_DeleteOldData class.
 *
 * @package    OpenXMaintenance
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew.hill@openx.org>
 */
class Test_OA_Maintenance_Statistics_Common_Task_DeleteOldData extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function Test_OA_Maintenance_Statistics_Common_Task_DeleteOldData()
    {
        $this->UnitTestCase();
    }

    /**
     * Test the creation of the class.
     */
    function testCreate()
    {
        $oDeleteOldData = new OA_Maintenance_Statistics_Common_Task_DeleteOldData();
        $this->assertTrue(is_a($oDeleteOldData, 'OA_Maintenance_Statistics_Common_Task_DeleteOldData'));
    }

    /**
     * A private method to insert test run data.
     *
     * @access private
     */
    function _insertTestRunData()
    {
        $oDbh =& OA_DB::singleton();
        $aTables = array(
            'max_data_raw_ad_request',
            'max_data_raw_ad_impression',
            'max_data_raw_ad_click'

        );
        foreach ($aTables as $table) {
            $query = "
                INSERT INTO
                    $table
                    (
                        ad_id,
                        creative_id,
                        zone_id,
                        date_time
                    )
                VALUES
                    (?, ?, ?, ?)";
            $aTypes = array(
                'integer',
                'integer',
                'integer',
                'timestamp'
            );
            $st = $oDbh->prepare($query, $aTypes, MDB2_PREPARE_MANIP);
            $aData = array(
                0,
                0,
                0,
                '2004-06-06 18:00:00'
            );
            $rows = $st->execute($aData);
            $aData = array(
                0,
                0,
                0,
                '2004-06-06 17:59:59'
            );
            $rows = $st->execute($aData);
            $aData = array(
                0,
                0,
                0,
                '2004-06-06 17:00:00'
            );
            $rows = $st->execute($aData);
            $aData = array(
                0,
                0,
                0,
                '2004-06-06 16:59:59'
            );
            $rows = $st->execute($aData);
            $aData = array(
                0,
                0,
                0,
                '2004-06-06 16:00:00'
            );
            $rows = $st->execute($aData);
            $aData = array(
                0,
                0,
                0,
                '2004-06-06 15:59:59'
            );
            $rows = $st->execute($aData);
        }
    }

    /**
     * A method to test the run() method.
     */
    function testRun()
    {
        $conf =& $GLOBALS['_MAX']['CONF'];
        $conf['maintenance']['operationInterval'] = 60;
        $conf['table']['prefix'] = 'max_';
        $tables =& OA_DB_Table_Core::singleton();
        $oDbh =& OA_DB::singleton();
        $oServiceLocator =& OA_ServiceLocator::instance();

        // Create the required tables
        $tables->createTable('campaigns_trackers');
        $tables->createTable('data_raw_ad_click');
        $tables->createTable('data_raw_ad_impression');
        $tables->createTable('data_raw_ad_request');
        $tables->createTable('log_maintenance_statistics');

        // Insert the test data
        $this->_insertTestRunData();

        // Set no compact_stats grace period
        $conf['maintenance']['compactStatsGrace'] = 0;

        // Set compact_stats to false
        $conf['maintenance']['compactStats'] = false;

        // Create and register a new OA_Maintenance_Statistics_AdServer object
        $oMaintenanceStatistics = new OA_Maintenance_Statistics_AdServer();
        $oServiceLocator->register('Maintenance_Statistics_Controller', $oMaintenanceStatistics);

        // Create a new OA_Maintenance_Statistics_Common_Task_DeleteOldData object
        $oDeleteOldData = new OA_Maintenance_Statistics_Common_Task_DeleteOldData();

        // Test - compact stats set to false, so expect all 6 requests, impressions
        // and clicks to remain in the raw data tables
        $oDeleteOldData->run();
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_click']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 6);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_impression']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 6);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_request']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 6);

        // Set compact_stats to true
        $conf['maintenance']['compactStats'] = true;

        // Create and register a new OA_Maintenance_Statistics_AdServer object
        $oMaintenanceStatistics = new OA_Maintenance_Statistics_AdServer();
        $oMaintenanceStatistics->updateFinal = false;
        $oMaintenanceStatistics->updateIntermediate = false;
        $oMaintenanceStatistics->updateUsingOI = false;
        $oServiceLocator->register('Maintenance_Statistics_Controller', $oMaintenanceStatistics);

        // Create a new OA_Maintenance_Statistics_Common_Task_DeleteOldData object
        $oDeleteOldData = new OA_Maintenance_Statistics_Common_Task_DeleteOldData();

        // Test - compact stats set to true, MSE update values not valid for deleting old stats
        // data, so expect all 6 requests, impressions and clicks to remain in the raw data tables
        $oDeleteOldData->run();
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_click']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 6);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_impression']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 6);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_request']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 6);

        // Create and register a new OA_Maintenance_Statistics_AdServer object
        $oMaintenanceStatistics = new OA_Maintenance_Statistics_AdServer();
        $oMaintenanceStatistics->updateFinal = true;
        $oMaintenanceStatistics->updateIntermediate = false;
        $oMaintenanceStatistics->updateUsingOI = false;
        $oServiceLocator->register('Maintenance_Statistics_Controller', $oMaintenanceStatistics);

        // Create a new OA_Maintenance_Statistics_Common_Task_DeleteOldData object
        $oDeleteOldData = new OA_Maintenance_Statistics_Common_Task_DeleteOldData();

        // Test - compact stats set to true, MSE update values not valid for deleting old stats
        // data, so expect all 6 requests, impressions and clicks to remain in the raw data tables
        $oDeleteOldData->run();
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_click']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 6);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_impression']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 6);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_request']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 6);

        // Create and register a new OA_Maintenance_Statistics_AdServer object
        $oMaintenanceStatistics = new OA_Maintenance_Statistics_AdServer();
        $oMaintenanceStatistics->updateFinal = false;
        $oMaintenanceStatistics->updateIntermediate = true;
        $oMaintenanceStatistics->updateUsingOI = true;
        $oServiceLocator->register('Maintenance_Statistics_Controller', $oMaintenanceStatistics);

        // Create a new OA_Maintenance_Statistics_Common_Task_DeleteOldData object
        $oDeleteOldData = new OA_Maintenance_Statistics_Common_Task_DeleteOldData();

        // Test - compact stats set to true, MSE update values not valid for deleting old stats
        // data, so expect all 6 requests, impressions and clicks to remain in the raw data tables
        $oDeleteOldData->run();
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_click']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 6);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_impression']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 6);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_request']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 6);

        // Create and register a new OA_Maintenance_Statistics_AdServer object
        $oMaintenanceStatistics = new OA_Maintenance_Statistics_AdServer();
        $oMaintenanceStatistics->updateFinal = true;
        $oMaintenanceStatistics->updateIntermediate = false;
        $oMaintenanceStatistics->updateUsingOI = true;
        $oMaintenanceStatistics->oUpdateFinalToDate = new Date('2004-06-06 17:59:59');
        $oServiceLocator->register('Maintenance_Statistics_Controller', $oMaintenanceStatistics);

        // Create a new OA_Maintenance_Statistics_Common_Task_DeleteOldData object
        $oDeleteOldData = new OA_Maintenance_Statistics_Common_Task_DeleteOldData();

        // Test - compact stats set to true, MSE update values valid for deleting old stats
        // data, so expect all requests, impressions and clicks older than '2004-06-06 17:59:59'
        // (i.e. 5 of the 6) to have been deleted
        $oDeleteOldData->run();
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_click']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_impression']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_request']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 1);

        // Drop and re-create the tables
        $tables->dropTable($conf['table']['prefix'].$conf['table']['data_raw_ad_click']);
        $tables->dropTable($conf['table']['prefix'].$conf['table']['data_raw_ad_impression']);
        $tables->dropTable($conf['table']['prefix'].$conf['table']['data_raw_ad_request']);
        $tables->dropTable($conf['table']['prefix'].$conf['table']['log_maintenance_statistics']);
        $tables->createTable('data_raw_ad_click');
        $tables->createTable('data_raw_ad_impression');
        $tables->createTable('data_raw_ad_request');
        $tables->createTable('log_maintenance_statistics');

        // Re-insert the test data
        $this->_insertTestRunData();

        // Set compact_stats grace period to one hour
        $conf['maintenance']['compactStatsGrace'] = 3600;

        // Create and register a new OA_Maintenance_Statistics_AdServer object
        $oMaintenanceStatistics = new OA_Maintenance_Statistics_AdServer();
        $oMaintenanceStatistics->updateFinal = false;
        $oMaintenanceStatistics->updateIntermediate = true;
        $oMaintenanceStatistics->updateUsingOI = false;
        $oMaintenanceStatistics->oUpdateIntermediateToDate = new Date('2004-06-06 17:59:59');
        $oServiceLocator->register('Maintenance_Statistics_Controller', $oMaintenanceStatistics);

        // Create a new OA_Maintenance_Statistics_Common_Task_DeleteOldData object
        $oDeleteOldData = new OA_Maintenance_Statistics_Common_Task_DeleteOldData();

        // Test - compact stats set to true, MSE update values valid for deleting old stats
        // data, so expect all requests, impressions and clicks older than '2004-06-06 17:59:59'
        // but also older than the grace period (i.e. 3 of the 6) to have been deleted
        $oDeleteOldData->run();
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_click']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 3);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_impression']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 3);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_request']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 3);

        // Drop and re-create the tables
        $tables->dropTable($conf['table']['prefix'].$conf['table']['data_raw_ad_click']);
        $tables->dropTable($conf['table']['prefix'].$conf['table']['data_raw_ad_impression']);
        $tables->dropTable($conf['table']['prefix'].$conf['table']['data_raw_ad_request']);
        $tables->dropTable($conf['table']['prefix'].$conf['table']['log_maintenance_statistics']);
        $tables->createTable('data_raw_ad_click');
        $tables->createTable('data_raw_ad_impression');
        $tables->createTable('data_raw_ad_request');
        $tables->createTable('log_maintenance_statistics');

        // Re-insert the test data
        $this->_insertTestRunData();

        // Set no compact_stats grace period
        $conf['maintenance']['compactStatsGrace'] = 0;

        // Insert some converson tracking windows, the largets being on hour
        $query = "
            INSERT INTO
                max_campaigns_trackers
                (
                    viewwindow,
                    clickwindow
                )
            VALUES
                (?, ?)";
        $aTypes = array(
            'integer',
            'integer'
        );
        $st = $oDbh->prepare($query, $aTypes, MDB2_PREPARE_MANIP);
        $aData = array(
            0,
            60
        );
        $rows = $st->execute($aData);
        $aData = array(
            0,
            3600
        );
        $rows = $st->execute($aData);

        // Create and register a new OA_Maintenance_Statistics_AdServer object
        $oMaintenanceStatistics = new OA_Maintenance_Statistics_AdServer();
        $oMaintenanceStatistics->updateFinal = false;
        $oMaintenanceStatistics->updateIntermediate = true;
        $oMaintenanceStatistics->updateUsingOI = false;
        $oMaintenanceStatistics->oUpdateIntermediateToDate = new Date('2004-06-06 17:59:59');
        $oServiceLocator->register('Maintenance_Statistics_Controller', $oMaintenanceStatistics);

        // Create a new OA_Maintenance_Statistics_Common_Task_DeleteOldData object
        $oDeleteOldData = new OA_Maintenance_Statistics_Common_Task_DeleteOldData();

        // Test - compact stats set to true, MSE update values valid for deleting old stats
        // data, so expect all requests, impressions and clicks older than '2004-06-06 17:59:59'
        // but also older than the largest conversion tracking window (i.e. 3 of the 6) wrt. the
        // impressions and clicks to have been deleted
        $oDeleteOldData->run();
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_click']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 3);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_impression']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 3);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_request']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 1);

        // Drop and re-create the tables
        $tables->dropTable($conf['table']['prefix'].$conf['table']['data_raw_ad_click']);
        $tables->dropTable($conf['table']['prefix'].$conf['table']['data_raw_ad_impression']);
        $tables->dropTable($conf['table']['prefix'].$conf['table']['data_raw_ad_request']);
        $tables->dropTable($conf['table']['prefix'].$conf['table']['log_maintenance_statistics']);
        $tables->createTable('data_raw_ad_click');
        $tables->createTable('data_raw_ad_impression');
        $tables->createTable('data_raw_ad_request');
        $tables->createTable('log_maintenance_statistics');

        // Re-insert the test data
        $this->_insertTestRunData();

        // Set compact_stats grace period to one hour
        $conf['maintenance']['compactStatsGrace'] = 3600;

        // Insert some converson tracking windows, the largets being on hour
        $query = "
            INSERT INTO
                max_campaigns_trackers
                (
                    viewwindow,
                    clickwindow
                )
            VALUES
                (?, ?)";
        $aTypes = array(
            'integer',
            'integer'
        );
        $st = $oDbh->prepare($query, $aTypes, MDB2_PREPARE_MANIP);
        $aData = array(
            0,
            60
        );
        $rows = $st->execute($aData);
        $aData = array(
            0,
            3600
        );
        $rows = $st->execute($aData);

        // Create and register a new OA_Maintenance_Statistics_AdServer object
        $oMaintenanceStatistics = new OA_Maintenance_Statistics_AdServer();
        $oMaintenanceStatistics->updateFinal = false;
        $oMaintenanceStatistics->updateIntermediate = true;
        $oMaintenanceStatistics->updateUsingOI = false;
        $oMaintenanceStatistics->oUpdateIntermediateToDate = new Date('2004-06-06 17:59:59');
        $oServiceLocator->register('Maintenance_Statistics_Controller', $oMaintenanceStatistics);

        // Create a new OA_Maintenance_Statistics_Common_Task_DeleteOldData object
        $oDeleteOldData = new OA_Maintenance_Statistics_Common_Task_DeleteOldData();

        // Test - compact stats set to true, MSE update values valid for deleting old stats
        // data, so expect all requests, impressions and clicks older than '2004-06-06 17:59:59'
        // but also older than the grace period and largest conversion tracking window
        // (i.e. 1 of the 6) wrt. the impressions and clicks to have been deleted
        $oDeleteOldData->run();
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_click']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 5);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_impression']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 5);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_request']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 3);

        // Reset the testing environment
        TestEnv::restoreEnv();
    }

}

?>