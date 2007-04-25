<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| =============                                                             |
|                                                                           |
| Copyright (c) 2003-2007 Openads Ltd                                       |
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

require_once MAX_PATH . '/lib/max/core/ServiceLocator.php';
require_once MAX_PATH . '/lib/max/Maintenance/Forecasting/AdServer.php';
require_once MAX_PATH . '/lib/max/Maintenance/Forecasting/AdServer/Task/SetUpdateRequirements.php';

/**
 * A class for testing the MAX_Maintenance_Forecasting_AdServer_Task_SetUpdateRequirements class.
 *
 * @package    MaxMaintenance
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew@m3.net>
 */
class Maintenance_TestOfMAX_Maintenance_Forecasting_AdServer_Task_SetUpdateRequirements extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function Maintenance_TestOfMAX_Maintenance_Forecasting_AdServer_Task_SetUpdateRequirements()
    {
        $this->UnitTestCase();
    }

    /**
     * Test the creation of the class.
     */
    function testCreate()
    {
        $oSetUpdateRequirements = new MAX_Maintenance_Forecasting_AdServer_Task_SetUpdateRequirements();
        $this->assertTrue(is_a($oSetUpdateRequirements, 'MAX_Maintenance_Forecasting_AdServer_Task_SetUpdateRequirements'));
    }

    /**
     * A method to test the run() method.
     *
     * Requirements:
     * Test 1:  Test with no data in tables, and ensure that no update is scheduled
     * Test 2:  Test with previous run in the future, and ensure no update is scheduled
     * Test 3:  Test with raw data in the future, and ensure no update is scheduled
     * Test 4:  Test with previous run in the past, but not a day ago, and ensure no
     *          update is scheduled
     * Test 5:  Test with raw data in the past, but not a day ago, and ensure no update
     *          is scheduled
     * Test 6:  Test with previous run in the past, one day ago, and ensure update
     *          is scheduled
     * Test 7:  As for Test 6, but multi-day update
     * Test 8:  Test with raw data in the past, one day ago, and ensure update is
     *          scheduled
     * Test 9:  Test with raw data in the past, in old split table, and ensure no
     *          update is scheduled
     * Test 10: Test with raw data in the past, in a split table, and ensure update
     *          is scheduled
     * Test 11: Test with raw data in the past, in the current split table, and ensure
     *          update is scheduled
     */
    function testRun()
    {
        // Reset the testing environment
        TestEnv::restoreEnv();

        // Use a reference to $GLOBALS['_MAX']['CONF'] so that the configuration
        // options can be changed while the test is running
        $conf = &$GLOBALS['_MAX']['CONF'];

        // Use non-split tables
        $conf['table']['split'] = false;

        // Create a connection to the database
        $oDbh = &OA_DB::singleton();

        // Create a ServiceLocator instance
        $oServiceLocator = &ServiceLocator::instance();

        // Create the required tables
        $oTables = &OA_DB_Table_Core::singleton();
        $oTables->createTable('data_raw_ad_impression');
        $oTables->createTable('log_maintenance_forecasting');

        // Create and register a new MAX_Maintenance_Forecasting_AdServer object
        $oMaintenanceForecasting = new MAX_Maintenance_Forecasting_AdServer();
        $oServiceLocator->register('Maintenance_Forecasting_Controller', $oMaintenanceForecasting);

        // Test 1
        $oSetUpdateRequirements = new MAX_Maintenance_Forecasting_AdServer_Task_SetUpdateRequirements();
        $oSetUpdateRequirements->run();
        $this->assertNull($oSetUpdateRequirements->oController->oLastUpdateDate);
        $this->assertFalse($oSetUpdateRequirements->oController->update);
        $this->assertNull($oSetUpdateRequirements->oController->oUpdateToDate);

        // Test 2
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['log_maintenance_forecasting']}
                (
                    start_run,
                    end_run,
                    operation_interval,
                    duration,
                    updated_to
                )
            VALUES
                (
                    '2006-10-12 00:15:00',
                    '2006-10-12 00:16:00',
                    60,
                    60,
                    '2006-10-11 23:59:59'
                )";
        $oDbh->query($query);
        $oNowDate = new Date('2006-10-11 01:00:00');
        $oServiceLocator->register('now', $oNowDate);
        $oSetUpdateRequirements = new MAX_Maintenance_Forecasting_AdServer_Task_SetUpdateRequirements();
        $oSetUpdateRequirements->run();
        $this->assertEqual($oSetUpdateRequirements->oController->oLastUpdateDate, new Date('2006-10-11 23:59:59'));
        $this->assertFalse($oSetUpdateRequirements->oController->update);
        $this->assertNull($oSetUpdateRequirements->oController->oUpdateToDate);

        TestEnv::restoreEnv();
        // Use non-split tables
        $conf['table']['split'] = false;

        // Test 3
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_impression']}
                (
                    date_time,
                    ad_id,
                    creative_id,
                    zone_id
                )
            VALUES
                (
                    '2006-10-12 12:53:42',
                    1,
                    1,
                    1
                )";
        $oDbh->query($query);
        $oNowDate = new Date('2006-10-11 01:00:00');
        $oServiceLocator->register('now', $oNowDate);
        $oSetUpdateRequirements = new MAX_Maintenance_Forecasting_AdServer_Task_SetUpdateRequirements();
        $oSetUpdateRequirements->run();
        $this->assertEqual($oSetUpdateRequirements->oController->oLastUpdateDate, new Date('2006-10-12 11:59:59'));
        $this->assertFalse($oSetUpdateRequirements->oController->update);
        $this->assertNull($oSetUpdateRequirements->oController->oUpdateToDate);

        TestEnv::restoreEnv();
        // Use non-split tables
        $conf['table']['split'] = false;

        // Test 4
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['log_maintenance_forecasting']}
                (
                    start_run,
                    end_run,
                    operation_interval,
                    duration,
                    updated_to
                )
            VALUES
                (
                    '2006-10-10 01:00:00',
                    '2006-10-10 01:01:00',
                    60,
                    60,
                    '2006-10-11 10:59:59'
                )";
        $oDbh->query($query);
        $oNowDate = new Date('2006-10-11 01:00:00');
        $oServiceLocator->register('now', $oNowDate);
        $oSetUpdateRequirements = new MAX_Maintenance_Forecasting_AdServer_Task_SetUpdateRequirements();
        $oSetUpdateRequirements->run();
        $this->assertEqual($oSetUpdateRequirements->oController->oLastUpdateDate, new Date('2006-10-11 10:59:59'));
        $this->assertFalse($oSetUpdateRequirements->oController->update);
        $this->assertNull($oSetUpdateRequirements->oController->oUpdateToDate);

        TestEnv::restoreEnv();
        // Use non-split tables
        $conf['table']['split'] = false;

        // Test 5
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_impression']}
                (
                    date_time,
                    ad_id,
                    creative_id,
                    zone_id
                )
            VALUES
                (
                    '2006-10-11 00:53:42',
                    1,
                    1,
                    1
                )";
        $oDbh->query($query);
        $oNowDate = new Date('2006-10-11 01:00:00');
        $oServiceLocator->register('now', $oNowDate);
        $oSetUpdateRequirements = new MAX_Maintenance_Forecasting_AdServer_Task_SetUpdateRequirements();
        $oSetUpdateRequirements->run();
        $this->assertEqual($oSetUpdateRequirements->oController->oLastUpdateDate, new Date('2006-10-10 23:59:59'));
        $this->assertFalse($oSetUpdateRequirements->oController->update);
        $this->assertNull($oSetUpdateRequirements->oController->oUpdateToDate);

        TestEnv::restoreEnv();
        // Use non-split tables
        $conf['table']['split'] = false;

        // Test 6
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['log_maintenance_forecasting']}
                (
                    start_run,
                    end_run,
                    operation_interval,
                    duration,
                    updated_to
                )
            VALUES
                (
                    '2006-10-10 01:00:00',
                    '2006-10-10 01:01:00',
                    60,
                    60,
                    '2006-10-09 23:59:59'
                )";
        $oDbh->query($query);
        $oNowDate = new Date('2006-10-11 01:00:00');
        $oServiceLocator->register('now', $oNowDate);
        $oSetUpdateRequirements = new MAX_Maintenance_Forecasting_AdServer_Task_SetUpdateRequirements();
        $oSetUpdateRequirements->run();
        $this->assertEqual($oSetUpdateRequirements->oController->oLastUpdateDate, new Date('2006-10-09 23:59:59'));
        $this->assertTrue($oSetUpdateRequirements->oController->update);
        $this->assertEqual($oSetUpdateRequirements->oController->oUpdateToDate, new Date('2006-10-10 23:59:59'));

        TestEnv::restoreEnv();
        // Use non-split tables
        $conf['table']['split'] = false;

        // Test 7
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['log_maintenance_forecasting']}
                (
                    start_run,
                    end_run,
                    operation_interval,
                    duration,
                    updated_to
                )
            VALUES
                (
                    '2006-10-09 01:00:00',
                    '2006-10-09 01:01:00',
                    60,
                    60,
                    '2006-10-08 23:59:59'
                )";
        $oDbh->query($query);
        $oNowDate = new Date('2006-10-11 01:00:00');
        $oServiceLocator->register('now', $oNowDate);
        $oSetUpdateRequirements = new MAX_Maintenance_Forecasting_AdServer_Task_SetUpdateRequirements();
        $oSetUpdateRequirements->run();
        $this->assertEqual($oSetUpdateRequirements->oController->oLastUpdateDate, new Date('2006-10-08 23:59:59'));
        $this->assertTrue($oSetUpdateRequirements->oController->update);
        $this->assertEqual($oSetUpdateRequirements->oController->oUpdateToDate, new Date('2006-10-10 23:59:59'));

        TestEnv::restoreEnv();
        // Use non-split tables
        $conf['table']['split'] = false;

        // Test 8
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_impression']}
                (
                    date_time,
                    ad_id,
                    creative_id,
                    zone_id
                )
            VALUES
                (
                    '2006-10-10 23:53:42',
                    1,
                    1,
                    1
                )";
        $oDbh->query($query);
        $oNowDate = new Date('2006-10-11 01:00:00');
        $oServiceLocator->register('now', $oNowDate);
        $oSetUpdateRequirements = new MAX_Maintenance_Forecasting_AdServer_Task_SetUpdateRequirements();
        $oSetUpdateRequirements->run();
        $this->assertEqual($oSetUpdateRequirements->oController->oLastUpdateDate, new Date('2006-10-09 23:59:59'));
        $this->assertTrue($oSetUpdateRequirements->oController->update);
        $this->assertEqual($oSetUpdateRequirements->oController->oUpdateToDate, new Date('2006-10-10 23:59:59'));

        TestEnv::restoreEnv();
        // Use non-split tables
        $conf['table']['split'] = true;

        // Create a connection to the database
        $oDbh = &OA_DB::singleton();

        // Create a ServiceLocator instance
        $oServiceLocator = &ServiceLocator::instance();

        // Create the required tables
        $oTables = &OA_DB_Table_Core::singleton();
        $oTables->createTable('data_raw_ad_impression', new Date('2006-10-31 00:00:00'));
        $oTables->createTable('data_raw_ad_impression', new Date('2006-11-01 00:00:00'));
        $oTables->createTable('data_raw_ad_impression', new Date('2006-11-02 00:00:00'));
        $oTables->createTable('log_maintenance_forecasting');

        // Test 9
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_impression']}_20061031
                (
                    date_time,
                    ad_id,
                    creative_id,
                    zone_id
                )
            VALUES
                (
                    '2006-10-31 00:00:00',
                    1,
                    1,
                    1
                )";
        $oDbh->query($query);
        $oNowDate = new Date('2006-11-02 01:00:00');
        $oServiceLocator->register('now', $oNowDate);
        $oSetUpdateRequirements = new MAX_Maintenance_Forecasting_AdServer_Task_SetUpdateRequirements();
        $oSetUpdateRequirements->run();
        $this->assertNull($oSetUpdateRequirements->oController->oLastUpdateDate);
        $this->assertFalse($oSetUpdateRequirements->oController->update);
        $this->assertNull($oSetUpdateRequirements->oController->oUpdateToDate);

        TestEnv::restoreEnv();
        // Use non-split tables
        $conf['table']['split'] = true;

        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_impression']}_20061031
                (
                    date_time,
                    ad_id,
                    creative_id,
                    zone_id
                )
            VALUES
                (
                    '2006-10-31 23:53:42',
                    1,
                    1,
                    1
                )";
        $oDbh->query($query);
        $oNowDate = new Date('2006-11-02 01:00:00');
        $oServiceLocator->register('now', $oNowDate);
        $oSetUpdateRequirements = new MAX_Maintenance_Forecasting_AdServer_Task_SetUpdateRequirements();
        $oSetUpdateRequirements->run();
        $this->assertNull($oSetUpdateRequirements->oController->oLastUpdateDate);
        $this->assertFalse($oSetUpdateRequirements->oController->update);
        $this->assertNull($oSetUpdateRequirements->oController->oUpdateToDate);

        TestEnv::restoreEnv();
        // Use non-split tables
        $conf['table']['split'] = true;

        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_impression']}_20061031
                (
                    date_time,
                    ad_id,
                    creative_id,
                    zone_id
                )
            VALUES
                (
                    '2006-10-31 23:59:59',
                    1,
                    1,
                    1
                )";
        $oDbh->query($query);
        $oNowDate = new Date('2006-11-02 01:00:00');
        $oServiceLocator->register('now', $oNowDate);
        $oSetUpdateRequirements = new MAX_Maintenance_Forecasting_AdServer_Task_SetUpdateRequirements();
        $oSetUpdateRequirements->run();
        $this->assertNull($oSetUpdateRequirements->oController->oLastUpdateDate);
        $this->assertFalse($oSetUpdateRequirements->oController->update);
        $this->assertNull($oSetUpdateRequirements->oController->oUpdateToDate);

        TestEnv::restoreEnv();
        // Use non-split tables
        $conf['table']['split'] = true;

        // Test 10
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_impression']}_20061101
                (
                    date_time,
                    ad_id,
                    creative_id,
                    zone_id
                )
            VALUES
                (
                    '2006-11-01 00:00:00',
                    1,
                    1,
                    1
                )";
        $oDbh->query($query);
        $oNowDate = new Date('2006-11-02 01:00:00');
        $oServiceLocator->register('now', $oNowDate);
        $oSetUpdateRequirements = new MAX_Maintenance_Forecasting_AdServer_Task_SetUpdateRequirements();
        $oSetUpdateRequirements->run();
        $this->assertEqual($oSetUpdateRequirements->oController->oLastUpdateDate, new Date('2006-10-31 23:59:59'));
        $this->assertTrue($oSetUpdateRequirements->oController->update);
        $this->assertEqual($oSetUpdateRequirements->oController->oUpdateToDate, new Date('2006-11-01 23:59:59'));

        TestEnv::restoreEnv();
        // Use non-split tables
        $conf['table']['split'] = true;

        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_impression']}_20061101
                (
                    date_time,
                    ad_id,
                    creative_id,
                    zone_id
                )
            VALUES
                (
                    '2006-11-01 23:53:42',
                    1,
                    1,
                    1
                )";
        $oDbh->query($query);
        $oNowDate = new Date('2006-11-02 01:00:00');
        $oServiceLocator->register('now', $oNowDate);
        $oSetUpdateRequirements = new MAX_Maintenance_Forecasting_AdServer_Task_SetUpdateRequirements();
        $oSetUpdateRequirements->run();
        $this->assertEqual($oSetUpdateRequirements->oController->oLastUpdateDate, new Date('2006-10-31 23:59:59'));
        $this->assertTrue($oSetUpdateRequirements->oController->update);
        $this->assertEqual($oSetUpdateRequirements->oController->oUpdateToDate, new Date('2006-11-01 23:59:59'));

        TestEnv::restoreEnv();
        // Use non-split tables
        $conf['table']['split'] = true;

        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_impression']}_20061101
                (
                    date_time,
                    ad_id,
                    creative_id,
                    zone_id
                )
            VALUES
                (
                    '2006-11-01 23:59:59',
                    1,
                    1,
                    1
                )";
        $oDbh->query($query);
        $oNowDate = new Date('2006-11-02 01:00:00');
        $oServiceLocator->register('now', $oNowDate);
        $oSetUpdateRequirements = new MAX_Maintenance_Forecasting_AdServer_Task_SetUpdateRequirements();
        $oSetUpdateRequirements->run();
        $this->assertEqual($oSetUpdateRequirements->oController->oLastUpdateDate, new Date('2006-10-31 23:59:59'));
        $this->assertTrue($oSetUpdateRequirements->oController->update);
        $this->assertEqual($oSetUpdateRequirements->oController->oUpdateToDate, new Date('2006-11-01 23:59:59'));

        TestEnv::restoreEnv();
        // Use non-split tables
        $conf['table']['split'] = true;

        // Test 11
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_impression']}_20061102
                (
                    date_time,
                    ad_id,
                    creative_id,
                    zone_id
                )
            VALUES
                (
                    '2006-11-02 00:00:00',
                    1,
                    1,
                    1
                )";
        $oDbh->query($query);
        $oNowDate = new Date('2006-11-02 01:00:00');
        $oServiceLocator->register('now', $oNowDate);
        $oSetUpdateRequirements = new MAX_Maintenance_Forecasting_AdServer_Task_SetUpdateRequirements();
        $oSetUpdateRequirements->run();
        $this->assertNull($oSetUpdateRequirements->oController->oLastUpdateDate);
        $this->assertFalse($oSetUpdateRequirements->oController->update);
        $this->assertNull($oSetUpdateRequirements->oController->oUpdateToDate);

        TestEnv::restoreEnv();
        // Use non-split tables
        $conf['table']['split'] = true;

        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_impression']}_20061102
                (
                    date_time,
                    ad_id,
                    creative_id,
                    zone_id
                )
            VALUES
                (
                    '2006-10-11 23:53:42',
                    1,
                    1,
                    1
                )";
        $oDbh->query($query);
        $oNowDate = new Date('2006-11-02 01:00:00');
        $oServiceLocator->register('now', $oNowDate);
        $oSetUpdateRequirements = new MAX_Maintenance_Forecasting_AdServer_Task_SetUpdateRequirements();
        $oSetUpdateRequirements->run();
        $this->assertNull($oSetUpdateRequirements->oController->oLastUpdateDate);
        $this->assertFalse($oSetUpdateRequirements->oController->update);
        $this->assertNull($oSetUpdateRequirements->oController->oUpdateToDate);

        TestEnv::restoreEnv();
        // Use non-split tables
        $conf['table']['split'] = true;

        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_impression']}_20061102
                (
                    date_time,
                    ad_id,
                    creative_id,
                    zone_id
                )
            VALUES
                (
                    '2006-11-02 23:59:59',
                    1,
                    1,
                    1
                )";
        $oDbh->query($query);
        $oNowDate = new Date('2006-11-02 01:00:00');
        $oServiceLocator->register('now', $oNowDate);
        $oSetUpdateRequirements = new MAX_Maintenance_Forecasting_AdServer_Task_SetUpdateRequirements();
        $oSetUpdateRequirements->run();
        $this->assertNull($oSetUpdateRequirements->oController->oLastUpdateDate);
        $this->assertFalse($oSetUpdateRequirements->oController->update);
        $this->assertNull($oSetUpdateRequirements->oController->oUpdateToDate);

        TestEnv::restoreEnv();
    }

}

?>
