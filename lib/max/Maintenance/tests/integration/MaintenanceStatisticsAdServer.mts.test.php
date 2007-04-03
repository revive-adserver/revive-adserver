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
require_once MAX_PATH . '/lib/Max.php';
require_once MAX_PATH . '/lib/max/Maintenance/Statistics/AdServer.php';
require_once 'Date.php';

/**
 * A class for performing integration testing the MAX_Maintenance_Statistics_AdServer class.
 *
 * @package    MaxMaintenance
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew@m3.net>
 * @TODO Update to use a mocked DAL, instead of a real database.
 */
class Maintenance_TestOfMaintenanceStatisticsAdServer extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function Maintenance_TestOfMaintenanceStatisticsAdServer()
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
        $oDbh = &OA_DB::singleton();
        $oTable = &OA_DB_Table_Core::singleton();
        // Create the required tables
        $oTable->createTable('banners');
        $oTable->createTable('campaigns');
        $oTable->createTable('campaigns_trackers');
        $oTable->createTable('clients');
        $oTable->createTable('data_intermediate_ad');
        $oTable->createTable('data_intermediate_ad_connection');
        $oTable->createTable('data_intermediate_ad_variable_value');
        $oTable->createTable('data_raw_ad_click');
        $oTable->createTable('data_raw_ad_impression');
        $oTable->createTable('data_raw_ad_request');
        $oTable->createTable('data_raw_tracker_impression');
        $oTable->createTable('data_raw_tracker_variable_value');
        $oTable->createTable('data_summary_ad_hourly');
        $oTable->createTable('data_summary_zone_impression_history');
        $oTable->createTable('log_maintenance_statistics');
        $oTable->createTable('trackers');
        $oTable->createTable('userlog');
        $oTable->createTable('variables');
        $oTable->createTable('zones');
        $oTable->createTable('channel');
        $oTable->createTable('acls');
        $oTable->createTable('acls_channel');
/*
currently plugins such as arrivals are not tested at all
this test will fail if arrivals are installed
as stats will need arrival tables along with changes to core tables
it is possible to create the arrivals tables
but it is not possible to update the core tables yet
the solution at the moment is to remove the plugins/maintenance/arrivals folder and ignore the testing of arrivals
        $tables->init(MAX_PATH . '/etc/tables_core_arrivals.' . $conf['database']['type'] . '.sql');
        $tables->createTable('data_raw_ad_arrival'); // in case arrivals is installed
*/

        // Get the data for the tests
        include_once MAX_PATH . '/lib/max/Maintenance/data/TestOfMaintenanceStatisticsAdServer.php';
        // Insert the test data
        $rows = $oDbh->exec(ADSERVER_FULL_TEST_BANNERS);
        $rows = $oDbh->exec(ADSERVER_FULL_TEST_CAMPAIGNS);
        $rows = $oDbh->exec(ADSERVER_FULL_TEST_CAMPAIGNS_TRACKERS);
        $rows = $oDbh->exec(ADSERVER_FULL_TEST_CLIENTS);
        $rows = $oDbh->exec(ADSERVER_FULL_TEST_AD_IMPRESSIONS);
        $rows = $oDbh->exec(ADSERVER_FULL_TEST_AD_REQUESTS);
        $rows = $oDbh->exec(ADSERVER_FULL_TEST_TRACKER_IMPRESSIONS);
        $rows = $oDbh->exec(ADSERVER_FULL_TEST_TRACKERS);
        $rows = $oDbh->exec(ADSERVER_FULL_TEST_ZONES);
        $rows = $oDbh->exec(ADSERVER_FULL_TEST_CHANNELS);
        $rows = $oDbh->exec(ADSERVER_FULL_TEST_CHANNELS_ACLS);
        $rows = $oDbh->exec(ADSERVER_FULL_TEST_CHANNELS_ACLS_CHANNEL);
        $rows = $oDbh->exec(ADSERVER_FULL_TEST_CHANNELS_BANNER);
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
        $oMaintenanceStatistics = new MAX_Maintenance_Statistics_AdServer();
        $oMaintenanceStatistics->updateStatistics();
        // Test the results
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 6);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_summary_ad_hourly']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 6);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_summary_zone_impression_history']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 2);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_click']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_impression']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 30);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_request']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 30);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_tracker_impression']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_tracker_variable_value']}";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['number'], 0);
        // Reset the testing environment
        TestEnv::restoreEnv();
    }

}

?>
