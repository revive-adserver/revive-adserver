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
require_once MAX_PATH . '/lib/max/Maintenance/Statistics/Common/Task/DeleteOldData.php';

/**
 * A class for testing the MAX_Maintenance_Statistics_Common_Task_DeleteOldData class.
 *
 * @package    MaxMaintenance
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew@m3.net>
 */
class Maintenance_TestOfMAX_Maintenance_Statistics_Common_Task_DeleteOldData extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function Maintenance_TestOfMAX_Maintenance_Statistics_Common_Task_DeleteOldData()
    {
        $this->UnitTestCase();
    }

    /**
     * Test the creation of the class.
     */
    function testCreate()
    {
        $oDeleteOldData = new MAX_Maintenance_Statistics_Common_Task_DeleteOldData();
        $this->assertTrue(is_a($oDeleteOldData, 'MAX_Maintenance_Statistics_Common_Task_DeleteOldData'));
    }

    /**
     * A method to test the run() method.
     */
    function testRun()
    {
        $conf = &$GLOBALS['_MAX']['CONF'];
        $conf['maintenance']['operationInterval'] = 60;
        $conf['table']['prefix'] = 'max_';
        $conf['table']['split'] = false;
        $tables = &Openads_Table_Core::singleton();
        $dbh = &MAX_DB::singleton();
        $oServiceLocator = &ServiceLocator::instance();
        // Create the required tables
        $tables->createTable('campaigns_trackers');
        $tables->createTable('data_raw_ad_click');
        $tables->createTable('data_raw_ad_impression');
        $tables->createTable('data_raw_ad_request');
        $tables->createTable('log_maintenance_statistics');
        // Get the data for the tests
        include_once MAX_PATH . '/lib/max/Maintenance/data/TestOfMaintenanceStatisticsCommon.php';
        // Insert the test data
        $result = $dbh->query(COMMON_DELETE_OLD_DATA_CAMPAIGNS_TRACKERS);
        $result = $dbh->query(COMMON_DELETE_OLD_DATA_AD_CLICKS);
        $result = $dbh->query(COMMON_DELETE_OLD_DATA_AD_IMPRESSIONS);
        $result = $dbh->query(COMMON_DELETE_OLD_DATA_AD_REQUESTS);
        // Set compact_stats to false
        $conf['maintenance']['compactStats'] = false;
        // Create and register a new MAX_Maintenance_Statistics_AdServer object
        $oMaintenanceStatistics = &new MAX_Maintenance_Statistics_AdServer();
        $oServiceLocator->register('Maintenance_Statistics_Controller', $oMaintenanceStatistics);
        // Create a new MAX_Maintenance_Statistics_Common_Task_DeleteOldData object
        $oDeleteOldData = new MAX_Maintenance_Statistics_Common_Task_DeleteOldData();
        // Test
        $oDeleteOldData->run();
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_click']}";
        $row = $dbh->getRow($query);
        $this->assertEqual($row['number'], 6);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_impression']}";
        $row = $dbh->getRow($query);
        $this->assertEqual($row['number'], 6);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_request']}";
        $row = $dbh->getRow($query);
        $this->assertEqual($row['number'], 6);
        // Set compact_stats to true
        $conf['maintenance']['compactStats'] = true;
        // Set compact_stats grace to one hour
        $conf['maintenance']['compactStatsGrace'] = 3600;
        // Disable the tracker
        $conf['modules']['Tracker'] = false;
        // Create and register a new MAX_Maintenance_Statistics_AdServer object
        $oMaintenanceStatistics = &new MAX_Maintenance_Statistics_AdServer();
        $oMaintenanceStatistics->updateFinal = false;
        $oMaintenanceStatistics->updateIntermediate = false;
        $oMaintenanceStatistics->updateUsingOI = false;
        $oServiceLocator->register('Maintenance_Statistics_Controller', $oMaintenanceStatistics);
        // Create a new MAX_Maintenance_Statistics_Common_Task_DeleteOldData object
        $oDeleteOldData = new MAX_Maintenance_Statistics_Common_Task_DeleteOldData();
        // Test
        $oDeleteOldData->run();
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_click']}";
        $row = $dbh->getRow($query);
        $this->assertEqual($row['number'], 6);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_impression']}";
        $row = $dbh->getRow($query);
        $this->assertEqual($row['number'], 6);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_request']}";
        $row = $dbh->getRow($query);
        $this->assertEqual($row['number'], 6);
        // Create and register a new MAX_Maintenance_Statistics_AdServer object
        $oMaintenanceStatistics = &new MAX_Maintenance_Statistics_AdServer();
        $oMaintenanceStatistics->updateFinal = true;
        $oMaintenanceStatistics->updateIntermediate = false;
        $oMaintenanceStatistics->updateUsingOI = false;
        $oServiceLocator->register('Maintenance_Statistics_Controller', $oMaintenanceStatistics);
        // Create a new MAX_Maintenance_Statistics_Common_Task_DeleteOldData object
        $oDeleteOldData = new MAX_Maintenance_Statistics_Common_Task_DeleteOldData();
        // Test
        $oDeleteOldData->run();
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_click']}";
        $row = $dbh->getRow($query);
        $this->assertEqual($row['number'], 6);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_impression']}";
        $row = $dbh->getRow($query);
        $this->assertEqual($row['number'], 6);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_request']}";
        $row = $dbh->getRow($query);
        $this->assertEqual($row['number'], 6);
        // Create and register a new MAX_Maintenance_Statistics_AdServer object
        $oMaintenanceStatistics = &new MAX_Maintenance_Statistics_AdServer();
        $oMaintenanceStatistics->updateFinal = false;
        $oMaintenanceStatistics->updateIntermediate = true;
        $oMaintenanceStatistics->updateUsingOI = true;
        $oServiceLocator->register('Maintenance_Statistics_Controller', $oMaintenanceStatistics);
        // Create a new MAX_Maintenance_Statistics_Common_Task_DeleteOldData object
        $oDeleteOldData = new MAX_Maintenance_Statistics_Common_Task_DeleteOldData();
        // Test
        $oDeleteOldData->run();
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_click']}";
        $row = $dbh->getRow($query);
        $this->assertEqual($row['number'], 6);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_impression']}";
        $row = $dbh->getRow($query);
        $this->assertEqual($row['number'], 6);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_request']}";
        $row = $dbh->getRow($query);
        $this->assertEqual($row['number'], 6);
        // Create and register a new MAX_Maintenance_Statistics_AdServer object
        $oMaintenanceStatistics = &new MAX_Maintenance_Statistics_AdServer();
        $oMaintenanceStatistics->updateFinal = true;
        $oMaintenanceStatistics->updateIntermediate = false;
        $oMaintenanceStatistics->updateUsingOI = true;
        $oMaintenanceStatistics->updateFinalToDate = new Date('2004-06-06 17:59:59');
        $oServiceLocator->register('Maintenance_Statistics_Controller', $oMaintenanceStatistics);
        // Create a new MAX_Maintenance_Statistics_Common_Task_DeleteOldData object
        $oDeleteOldData = new MAX_Maintenance_Statistics_Common_Task_DeleteOldData();
        // Test
        $oDeleteOldData->run();
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_click']}";
        $row = $dbh->getRow($query);
        $this->assertEqual($row['number'], 3);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_impression']}";
        $row = $dbh->getRow($query);
        $this->assertEqual($row['number'], 3);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_request']}";
        $row = $dbh->getRow($query);
        $this->assertEqual($row['number'], 3);
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
        $result = $dbh->query(COMMON_DELETE_OLD_DATA_AD_CLICKS);
        $result = $dbh->query(COMMON_DELETE_OLD_DATA_AD_IMPRESSIONS);
        $result = $dbh->query(COMMON_DELETE_OLD_DATA_AD_REQUESTS);
        // Create and register a new MAX_Maintenance_Statistics_AdServer object
        $oMaintenanceStatistics = &new MAX_Maintenance_Statistics_AdServer();
        $oMaintenanceStatistics->updateFinal = false;
        $oMaintenanceStatistics->updateIntermediate = true;
        $oMaintenanceStatistics->updateUsingOI = false;
        $oMaintenanceStatistics->updateIntermediateToDate = new Date('2004-06-06 17:59:59');
        $oServiceLocator->register('Maintenance_Statistics_Controller', $oMaintenanceStatistics);
        // Create a new MAX_Maintenance_Statistics_Common_Task_DeleteOldData object
        $oDeleteOldData = new MAX_Maintenance_Statistics_Common_Task_DeleteOldData();
        // Test
        $oDeleteOldData->run();
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_click']}";
        $row = $dbh->getRow($query);
        $this->assertEqual($row['number'], 3);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_impression']}";
        $row = $dbh->getRow($query);
        $this->assertEqual($row['number'], 3);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_request']}";
        $row = $dbh->getRow($query);
        $this->assertEqual($row['number'], 3);
        // Reset the testing environment
        TestEnv::restoreEnv();
    }

}

?>
