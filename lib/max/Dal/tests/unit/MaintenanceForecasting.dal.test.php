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
$Id: MaintenanceForecasting.dal.test.php 6266 2006-12-12 12:19:48Z andrew@m3.net $
*/

require_once MAX_PATH . '/lib/max/Dal/Maintenance/Forecasting.php';
require_once 'Date.php';

/**
 * A class for testing the non-DB specific MAX_Dal_Maintenance_Forecasting class.
 *
 * @package    MaxDal
 * @subpackage TestSuite
 * @author     Radek Maciaszek <radek@m3.net>
 */
class Dal_TestOfMAX_Dal_Maintenance_Forecasting extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function Dal_TestOfMAX_Dal_Maintenance_Forecasting()
    {
        $this->UnitTestCase();
    }

    /**
     * Method to test the setMaintenanceForecastingLastRunInfo method.
     *
     * Requirements:
     * Test 1: Test with no data in the database, ensure data is correctly stored.
     * Test 2: Test with previous test data in the database, ensure data is correctly stored.
     */
    function testSetMaintenanceForecastingLastRunInfo()
    {
        // Test relies on transaction numbers, so ensure fresh database used
        TestEnv::restoreEnv();

        TestEnv::startTransaction();
        $conf = $GLOBALS['_MAX']['CONF'];
        $dbh = &MAX_DB::singleton();
        $oMaxDalMaintenance = new MAX_Dal_Maintenance_Forecasting();

        // Test 1
        $oStartDate = new Date('2005-06-21 15:00:01');
        $oEndDate   = new Date('2005-06-21 15:01:01');
        $oUpdatedTo = new Date('2005-06-21 15:59:59');
        $result = $oMaxDalMaintenance->setMaintenanceForecastingLastRunInfo($oStartDate, $oEndDate, $oUpdatedTo);
        $this->assertEqual($result, 1);
        $query = "
            SELECT
                start_run,
                end_run,
                operation_interval,
                duration,
                updated_to
            FROM
                {$conf['table']['prefix']}{$conf['table']['log_maintenance_forecasting']}
            WHERE
                log_maintenance_forecasting_id = 1";
        $row = $dbh->getRow($query);
        $this->assertEqual($row['start_run'], '2005-06-21 15:00:01');
        $this->assertEqual($row['end_run'], '2005-06-21 15:01:01');
        $this->assertEqual($row['operation_interval'], $conf['maintenance']['operationInterval']);
        $this->assertEqual($row['duration'], 60);
        $this->assertEqual($row['updated_to'], '2005-06-21 15:59:59');

        // Test 2
        $oStartDate = new Date('2005-06-21 16:00:01');
        $oEndDate   = new Date('2005-06-21 16:01:06');
        $oUpdatedTo = new Date('2005-06-21 16:59:59');
        $result = $oMaxDalMaintenance->setMaintenanceForecastingLastRunInfo($oStartDate, $oEndDate, $oUpdatedTo);
        $this->assertEqual($result, 1);
        $query = "
            SELECT
                start_run,
                end_run,
                operation_interval,
                duration,
                updated_to
            FROM
                {$conf['table']['prefix']}{$conf['table']['log_maintenance_forecasting']}
            WHERE
                log_maintenance_forecasting_id = 1";
        $row = $dbh->getRow($query);
        $this->assertEqual($row['start_run'], '2005-06-21 15:00:01');
        $this->assertEqual($row['end_run'], '2005-06-21 15:01:01');
        $this->assertEqual($row['operation_interval'], $conf['maintenance']['operationInterval']);
        $this->assertEqual($row['duration'], 60);
        $this->assertEqual($row['updated_to'], '2005-06-21 15:59:59');
        $query = "
            SELECT
                start_run,
                end_run,
                operation_interval,
                duration,
                updated_to
            FROM
                {$conf['table']['prefix']}{$conf['table']['log_maintenance_forecasting']}
            WHERE
                log_maintenance_forecasting_id = 2";
        $row = $dbh->getRow($query);
        $this->assertEqual($row['start_run'], '2005-06-21 16:00:01');
        $this->assertEqual($row['end_run'], '2005-06-21 16:01:06');
        $this->assertEqual($row['operation_interval'], $conf['maintenance']['operationInterval']);
        $this->assertEqual($row['duration'], 65);
        $this->assertEqual($row['updated_to'], '2005-06-21 16:59:59');

        TestEnv::rollbackTransaction();
    }

    /**
     * Method to test the getMaintenanceForecastingLastRunInfo method.
     *
     * Requirements:
     * Test 1: Test correct results are returned with no data.
     * Test 2: Test correct results are returned with single data entry.
     * Test 3: Test correct results are returned with multiple data entries.
     */
    function testGetMaintenanceForecastingLastRunInfo()
    {
        TestEnv::startTransaction();
        $conf = $GLOBALS['_MAX']['CONF'];
        $table = $conf['table']['prefix'] . $conf['table']['data_raw_ad_impression'];
        $dbh = &MAX_DB::singleton();
        $oMaxDalMaintenance = new MAX_Dal_Maintenance_Forecasting();

        // Test 1
        $result = $oMaxDalMaintenance->getMaintenanceForecastingLastRunInfo($table);
        $this->assertFalse($result);

        // Test 2
        $oStartDate = new Date('2005-06-21 15:00:01');
        $oEndDate   = new Date('2005-06-21 15:01:01');
        $oUpdatedTo = new Date('2005-06-21 15:59:59');
        $oMaxDalMaintenance->setMaintenanceForecastingLastRunInfo($oStartDate, $oEndDate, $oUpdatedTo);
        $result = $oMaxDalMaintenance->getMaintenanceForecastingLastRunInfo($table);
        $this->assertTrue(is_array($result));
        $this->assertEqual($result['updated_to'], '2005-06-21 15:59:59');
        $this->assertEqual($result['operation_interval'], $conf['maintenance']['operationInterval']);

        // Test 3
        $oStartDate = new Date('2005-06-21 14:00:01');
        $oEndDate   = new Date('2005-06-21 14:01:01');
        $oUpdatedTo = new Date('2005-06-21 14:59:59');
        $oMaxDalMaintenance->setMaintenanceForecastingLastRunInfo($oStartDate, $oEndDate, $oUpdatedTo);
        $result = $oMaxDalMaintenance->getMaintenanceForecastingLastRunInfo($table);
        $this->assertTrue(is_array($result));
        $this->assertEqual($result['updated_to'], '2005-06-21 15:59:59');
        $this->assertEqual($result['operation_interval'], $conf['maintenance']['operationInterval']);
        $oStartDate = new Date('2005-06-21 16:00:01');
        $oEndDate   = new Date('2005-06-21 16:01:01');
        $oUpdatedTo = new Date('2005-06-21 16:59:59');
        $oMaxDalMaintenance->setMaintenanceForecastingLastRunInfo($oStartDate, $oEndDate, $oUpdatedTo);
        $result = $oMaxDalMaintenance->getMaintenanceForecastingLastRunInfo($table);
        $this->assertTrue(is_array($result));
        $this->assertEqual($result['updated_to'], '2005-06-21 16:59:59');
        $this->assertEqual($result['operation_interval'], $conf['maintenance']['operationInterval']);

        TestEnv::rollbackTransaction();
    }

    /**
     * A method to test the summariseRecordsInZonesBySqlLimitations() method.
     *
     * Requirements:
     * Test 1: Test with invalid parameters, and ensure an empty array is returned.
     * Test 2: Test with valid parameters, empty database, and ensure an empty
     *         array is returned.
     * Test 3: Test with valid parameters, data in the database that does NOT match
     *         the requirements, and ensure an empty array is returned.
     * Test 4: Test with valid parameters, data in the database that DOES match
     *         the requirements, and ensure a valid array is returned.
     * Test 5: Test with multi valid items.
     * Test 6: Repeat Test 5, but with one of the AND groups containing a "false"
     *         limitation.
     * Test 7: Repeat Test 5, but with both of the AND groups containing a "false"
     *         limitation.
     */
    function testSummariseRecordsInZonesBySqlLimitations()
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $dbh = &MAX_DB::singleton();
        $oMaxDalMaintenance = new MAX_Dal_Maintenance_Forecasting();

        // Test 1
        $aSqlLimitations = 'This is not an array';
        $oStartDate = new Date('2006-10-12 00:00:00');
        $oEndDate = new Date('2006-10-12 23:59:59');
        $aZoneIds = array(
            0 => 7
        );
        $tableName = $conf['table']['prefix'] . $conf['table']['data_raw_ad_impression'];
        $aResult = $oMaxDalMaintenance->summariseRecordsInZonesBySqlLimitations(
            $aSqlLimitations,
            $oStartDate,
            $oEndDate,
            $aZoneIds,
            $tableName
        );
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 0);

        $aSqlLimitations = array();
        $oStartDate = new Date('2006-10-12 00:00:00');
        $oEndDate = new Date('2006-10-12 23:59:59');
        $aZoneIds = array(
            0 => 7
        );
        $tableName = $conf['table']['prefix'] . $conf['table']['data_raw_ad_impression'];
        $aResult = $oMaxDalMaintenance->summariseRecordsInZonesBySqlLimitations(
            $aSqlLimitations,
            $oStartDate,
            $oEndDate,
            $aZoneIds,
            $tableName
        );
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 0);

        $aSqlLimitations = array(
            0 => 'This is not an array'
        );
        $oStartDate = new Date('2006-10-12 00:00:00');
        $oEndDate = new Date('2006-10-12 23:59:59');
        $aZoneIds = array(
            0 => 7
        );
        $tableName = $conf['table']['prefix'] . $conf['table']['data_raw_ad_impression'];
        $aResult = $oMaxDalMaintenance->summariseRecordsInZonesBySqlLimitations(
            $aSqlLimitations,
            $oStartDate,
            $oEndDate,
            $aZoneIds,
            $tableName
        );
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 0);

        $aSqlLimitations = array(
            0 => array()
        );
        $oStartDate = new Date('2006-10-12 00:00:00');
        $oEndDate = new Date('2006-10-12 23:59:59');
        $aZoneIds = array(
            0 => 7
        );
        $tableName = $conf['table']['prefix'] . $conf['table']['data_raw_ad_impression'];
        $aResult = $oMaxDalMaintenance->summariseRecordsInZonesBySqlLimitations(
            $aSqlLimitations,
            $oStartDate,
            $oEndDate,
            $aZoneIds,
            $tableName
        );
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 0);

        $aSqlLimitations = array(
            0 => array(
                0 => 45
            )
        );
        $oStartDate = new Date('2006-10-12 00:00:00');
        $oEndDate = new Date('2006-10-12 23:59:59');
        $aZoneIds = array(
            0 => 7
        );
        $tableName = $conf['table']['prefix'] . $conf['table']['data_raw_ad_impression'];
        $aResult = $oMaxDalMaintenance->summariseRecordsInZonesBySqlLimitations(
            $aSqlLimitations,
            $oStartDate,
            $oEndDate,
            $aZoneIds,
            $tableName
        );
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 0);

        $aSqlLimitations = array(
            0 => array(
                0 => "host_name LIKE 'www.foo.%'"
             )
        );
        $oStartDate = '';
        $oEndDate = new Date('2006-10-12 23:59:59');
        $aZoneIds = array(
            0 => 7
        );
        $tableName = $conf['table']['prefix'] . $conf['table']['data_raw_ad_impression'];
        $aResult = $oMaxDalMaintenance->summariseRecordsInZonesBySqlLimitations(
            $aSqlLimitations,
            $oStartDate,
            $oEndDate,
            $aZoneIds,
            $tableName
        );
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 0);

        $aSqlLimitations = array(
            0 => array(
                0 => "host_name LIKE 'www.foo.%'"
             )
        );
        $oStartDate = new Date('2006-10-12 00:00:00');
        $oEndDate = '';
        $aZoneIds = array(
            0 => 7
        );
        $tableName = $conf['table']['prefix'] . $conf['table']['data_raw_ad_impression'];
        $aResult = $oMaxDalMaintenance->summariseRecordsInZonesBySqlLimitations(
            $aSqlLimitations,
            $oStartDate,
            $oEndDate,
            $aZoneIds,
            $tableName
        );
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 0);

        $aSqlLimitations = array(
            0 => array(
                0 => "host_name LIKE 'www.foo.%'"
             )
        );
        $oStartDate = new Date('2006-10-12 00:00:00');
        $oEndDate = new Date('2006-10-12 23:59:59');
        $aZoneIds = '';
        $tableName = $conf['table']['prefix'] . $conf['table']['data_raw_ad_impression'];
        $aResult = $oMaxDalMaintenance->summariseRecordsInZonesBySqlLimitations(
            $aSqlLimitations,
            $oStartDate,
            $oEndDate,
            $aZoneIds,
            $tableName
        );
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 0);

        $aSqlLimitations = array(
            0 => array(
                0 => "host_name LIKE 'www.foo.%'"
             )
        );
        $oStartDate = new Date('2006-10-12 00:00:00');
        $oEndDate = new Date('2006-10-12 23:59:59');
        $aZoneIds = array(
            0 => 7
        );
        $tableName = '';
        $aResult = $oMaxDalMaintenance->summariseRecordsInZonesBySqlLimitations(
            $aSqlLimitations,
            $oStartDate,
            $oEndDate,
            $aZoneIds,
            $tableName
        );
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 0);

        // Test 2
        $aSqlLimitations = array(
            0 => array(
                0 => "host_name LIKE 'www.foo.%'"
             )
        );
        $oStartDate = new Date('2006-10-12 00:00:00');
        $oEndDate = new Date('2006-10-12 23:59:59');
        $aZoneIds = array(
            0 => 7
        );
        $tableName = $conf['table']['prefix'] . $conf['table']['data_raw_ad_impression'];
        $aResult = $oMaxDalMaintenance->summariseRecordsInZonesBySqlLimitations(
            $aSqlLimitations,
            $oStartDate,
            $oEndDate,
            $aZoneIds,
            $tableName
        );
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 0);

        // Test 3
        TestEnv::startTransaction();
        $tableName = $conf['table']['prefix'] . $conf['table']['data_raw_ad_impression'];
        $query = "
            INSERT INTO
                $tableName
                (
                    date_time,
                    ad_id,
                    creative_id,
                    zone_id,
                    host_name
                )
                VALUES
                (
                    '2006-10-11 10:30:00',
                    1,
                    2,
                    7,
                    'www.foo.com'
                ),
                (
                    '2006-10-12 10:30:00',
                    1,
                    2,
                    1,
                    'www.foo.com'
                ),
                (
                    '2006-10-12 10:30:00',
                    1,
                    2,
                    7,
                    'www.bar.com'
                )";
        $dbh->query($query);

        $aSqlLimitations = array(
            0 => array(
                0 => "host_name LIKE 'www.foo.%'"
             )
        );
        $oStartDate = new Date('2006-10-12 00:00:00');
        $oEndDate = new Date('2006-10-12 23:59:59');
        $aZoneIds = array(
            0 => 7
        );
        $tableName = $conf['table']['prefix'] . $conf['table']['data_raw_ad_impression'];
        $aResult = $oMaxDalMaintenance->summariseRecordsInZonesBySqlLimitations(
            $aSqlLimitations,
            $oStartDate,
            $oEndDate,
            $aZoneIds,
            $tableName
        );
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 0);
        TestEnv::rollbackTransaction();

        // Test 4
        TestEnv::startTransaction();
        $tableName = $conf['table']['prefix'] . $conf['table']['data_raw_ad_impression'];
        $query = "
            INSERT INTO
                $tableName
                (
                    date_time,
                    ad_id,
                    creative_id,
                    zone_id,
                    host_name
                )
                VALUES
                (
                    '2006-10-11 10:30:00',
                    1,
                    2,
                    7,
                    'www.foo.com'
                ),
                (
                    '2006-10-12 10:30:00',
                    1,
                    2,
                    1,
                    'www.foo.com'
                ),
                (
                    '2006-10-12 10:30:00',
                    1,
                    2,
                    7,
                    'www.bar.com'
                ),
                (
                    '2006-10-12 10:30:00',
                    1,
                    2,
                    7,
                    'www.foo.com'
                )";
        $dbh->query($query);

        $aSqlLimitations = array(
            0 => array(
                0 => "host_name LIKE 'www.foo.%'"
             )
        );
        $oStartDate = new Date('2006-10-12 00:00:00');
        $oEndDate = new Date('2006-10-12 23:59:59');
        $aZoneIds = array(
            0 => 7
        );
        $tableName = $conf['table']['prefix'] . $conf['table']['data_raw_ad_impression'];
        $aResult = $oMaxDalMaintenance->summariseRecordsInZonesBySqlLimitations(
            $aSqlLimitations,
            $oStartDate,
            $oEndDate,
            $aZoneIds,
            $tableName
        );
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 1);
        $this->assertEqual($aResult[7], 1);
        TestEnv::rollbackTransaction();

        TestEnv::startTransaction();
        $tableName = $conf['table']['prefix'] . $conf['table']['data_raw_ad_impression'];
        $query = "
            INSERT INTO
                $tableName
                (
                    date_time,
                    ad_id,
                    creative_id,
                    zone_id,
                    ip_address,
                    host_name,
                    country
                )
                VALUES
                (
                    '2006-10-11 10:30:00',
                    1,
                    2,
                    7,
                    '192.168.0.1',
                    'www.foo.com',
                    'GB'
                ),
                (
                    '2006-10-12 10:30:00',
                    1,
                    2,
                    1,
                    '192.168.0.1',
                    'www.foo.com',
                    'GB'
                ),
                (
                    '2006-10-12 10:30:00',
                    1,
                    2,
                    7,
                    '192.168.0.1',
                    'www.bar.com',
                    'GB'
                ),
                (
                    '2006-10-12 10:30:00',
                    1,
                    2,
                    7,
                    '192.168.0.1',
                    'www.foo.com',
                    'GB'
                ),
                (
                    '2006-10-12 10:30:00',
                    1,
                    2,
                    7,
                    '192.168.0.1',
                    'www.foo.co.uk',
                    'AU'
                ),
                (
                    '2006-10-12 10:30:00',
                    1,
                    2,
                    7,
                    '192.168.0.1',
                    'www.foo.co.uk',
                    'GB'
                ),
                (
                    '2006-10-12 10:30:00',
                    1,
                    2,
                    9,
                    '127.0.0.1',
                    'www.example.com',
                    'US'
                )";
        $dbh->query($query);

        // Test 5
        $aSqlLimitations = array(
            0 => array(
                0 => "host_name LIKE 'www.foo.%'",
                1 => "country = 'GB'"
             ),
            1 => array(
                0 => "ip_address = '127.0.0.1'"
            )
        );
        $oStartDate = new Date('2006-10-12 00:00:00');
        $oEndDate = new Date('2006-10-12 23:59:59');
        $aZoneIds = array(
            0 => 7,
            1 => 9
        );
        $tableName = $conf['table']['prefix'] . $conf['table']['data_raw_ad_impression'];
        $aResult = $oMaxDalMaintenance->summariseRecordsInZonesBySqlLimitations(
            $aSqlLimitations,
            $oStartDate,
            $oEndDate,
            $aZoneIds,
            $tableName
        );
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 2);
        $this->assertEqual($aResult[7], 2);
        $this->assertEqual($aResult[9], 1);

        // Test 6
        $aSqlLimitations = array(
            0 => array(
                0 => "host_name LIKE 'www.foo.%'",
                1 => false
             ),
            1 => array(
                0 => "ip_address = '127.0.0.1'"
            )
        );
        $oStartDate = new Date('2006-10-12 00:00:00');
        $oEndDate = new Date('2006-10-12 23:59:59');
        $aZoneIds = array(
            0 => 7,
            1 => 9
        );
        $tableName = $conf['table']['prefix'] . $conf['table']['data_raw_ad_impression'];
        $aResult = $oMaxDalMaintenance->summariseRecordsInZonesBySqlLimitations(
            $aSqlLimitations,
            $oStartDate,
            $oEndDate,
            $aZoneIds,
            $tableName
        );
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 1);
        $this->assertEqual($aResult[9], 1);

        // Test 7
        $aSqlLimitations = array(
            0 => array(
                0 => "host_name LIKE 'www.foo.%'",
                1 => false
             ),
            1 => array(
                0 => "ip_address = '127.0.0.1'",
                1 => false
            )
        );
        $oStartDate = new Date('2006-10-12 00:00:00');
        $oEndDate = new Date('2006-10-12 23:59:59');
        $aZoneIds = array(
            0 => 7,
            1 => 9
        );
        $tableName = $conf['table']['prefix'] . $conf['table']['data_raw_ad_impression'];
        $aResult = $oMaxDalMaintenance->summariseRecordsInZonesBySqlLimitations(
            $aSqlLimitations,
            $oStartDate,
            $oEndDate,
            $aZoneIds,
            $tableName
        );
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 0);

        TestEnv::rollbackTransaction();
    }

    /**
     * A method to test the saveChannelSummaryForZones() method.
     *
     * Requirements:
     * Test 1: Test with no data in the database, and ensure data is saved.
     * Test 2: Test with existing data in the database, and ensure data is
     *         updated/saved as required.
     */
    function testSaveChannelSummaryForZones()
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $dbh = &MAX_DB::singleton();
        $oMaxDalMaintenance = new MAX_Dal_Maintenance_Forecasting();
        $table = $conf['table']['prefix'] . $conf['table']['data_summary_channel_daily'];

        // Test 1
        TestEnv::startTransaction();
        $oDate = new Date('2006-10-12 12:00:00');
        $channelId = 7;
        $aCount = array(
            1 => 48,
            2 => 40
        );
        $oMaxDalMaintenance->saveChannelSummaryForZones($oDate, $channelId, $aCount);
        $query = "
            SELECT
                actual_impressions
            FROM
                $table
            WHERE
                day = '2006-10-12'
                AND channel_id = 7
                AND zone_id = 1";
        $rResult = $dbh->query($query);
        $aRow = $rResult->fetchRow();
        $this->assertEqual($aRow['actual_impressions'], 48);
        $query = "
            SELECT
                actual_impressions
            FROM
                $table
            WHERE
                day = '2006-10-12'
                AND channel_id = 7
                AND zone_id = 2";
        $rResult = $dbh->query($query);
        $aRow = $rResult->fetchRow();
        $this->assertEqual($aRow['actual_impressions'], 40);

        // Test 2
        $oDate = new Date('2006-10-12 12:00:00');
        $channelId = 7;
        $aCount = array(
            1 => 58,
            2 => 40
        );
        $oMaxDalMaintenance->saveChannelSummaryForZones($oDate, $channelId, $aCount);
        $query = "
            SELECT
                actual_impressions
            FROM
                $table
            WHERE
                day = '2006-10-12'
                AND channel_id = 7
                AND zone_id = 1";
        $rResult = $dbh->query($query);
        $aRow = $rResult->fetchRow();
        $this->assertEqual($aRow['actual_impressions'], 58);
        $query = "
            SELECT
                actual_impressions
            FROM
                $table
            WHERE
                day = '2006-10-12'
                AND channel_id = 7
                AND zone_id = 2";
        $rResult = $dbh->query($query);
        $aRow = $rResult->fetchRow();
        $this->assertEqual($aRow['actual_impressions'], 40);
        $query = "
            SELECT
                actual_impressions
            FROM
                $table
            WHERE
                day = '2006-10-12'
                AND channel_id = 7
                AND zone_id = 3";
        $rResult = $dbh->query($query);
        $aRow = $rResult->fetchRow();
        $this->assertEqual($aRow['actual_impressions'], 0);
        TestEnv::rollbackTransaction();
    }

}

?>
