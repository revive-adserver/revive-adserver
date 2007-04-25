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

require_once MAX_PATH . '/lib/OA/Dal/Maintenance/Forecasting.php';
require_once 'Date.php';

/**
 * A class for testing the non-DB specific OA_Dal_Maintenance_Forecasting class.
 *
 * @package    OpenadsDal
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew.hill@openads.org>
 * @author     Radek Maciaszek <radek@m3.net>
 */
class Test_OA_Dal_Maintenance_Forecasting extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function Test_OA_Dal_Maintenance_Forecasting()
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

        $conf = $GLOBALS['_MAX']['CONF'];
        $oDbh = &OA_DB::singleton();
        $oMaxDalMaintenance = new OA_Dal_Maintenance_Forecasting();

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
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['start_run'], '2005-06-21 15:00:01');
        $this->assertEqual($aRow['end_run'], '2005-06-21 15:01:01');
        $this->assertEqual($aRow['operation_interval'], $conf['maintenance']['operationInterval']);
        $this->assertEqual($aRow['duration'], 60);
        $this->assertEqual($aRow['updated_to'], '2005-06-21 15:59:59');

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
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['start_run'], '2005-06-21 15:00:01');
        $this->assertEqual($aRow['end_run'], '2005-06-21 15:01:01');
        $this->assertEqual($aRow['operation_interval'], $conf['maintenance']['operationInterval']);
        $this->assertEqual($aRow['duration'], 60);
        $this->assertEqual($aRow['updated_to'], '2005-06-21 15:59:59');
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
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['start_run'], '2005-06-21 16:00:01');
        $this->assertEqual($aRow['end_run'], '2005-06-21 16:01:06');
        $this->assertEqual($aRow['operation_interval'], $conf['maintenance']['operationInterval']);
        $this->assertEqual($aRow['duration'], 65);
        $this->assertEqual($aRow['updated_to'], '2005-06-21 16:59:59');

        TestEnv::restoreEnv();
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
        $conf = $GLOBALS['_MAX']['CONF'];
        $table = $conf['table']['prefix'] . $conf['table']['data_raw_ad_impression'];
        $oDbh = &OA_DB::singleton();
        $oMaxDalMaintenance = new OA_Dal_Maintenance_Forecasting();

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

        TestEnv::restoreEnv();
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
        $oDbh = &OA_DB::singleton();
        $oMaxDalMaintenance = new OA_Dal_Maintenance_Forecasting();

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
                    (?, ?, ?, ?, ?)";
        $aTypes = array(
            'timestamp',
            'integer',
            'integer',
            'integer',
            'text'
        );
        $st = $oDbh->prepare($query, $aTypes, MDB2_PREPARE_MANIP);
        $aData = array(
            '2006-10-11 10:30:00',
            1,
            2,
            7,
            'www.foo.com'
        );
        $rows = $st->execute($aData);
        $aData = array(
            '2006-10-12 10:30:00',
            1,
            2,
            1,
            'www.foo.com'
        );
        $rows = $st->execute($aData);
        $aData = array(
            '2006-10-12 10:30:00',
            1,
            2,
            7,
            'www.bar.com'
        );
        $rows = $st->execute($aData);

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
        TestEnv::restoreEnv();

        // Test 4
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
                    (?, ?, ?, ?, ?)";
        $aTypes = array(
            'timestamp',
            'integer',
            'integer',
            'integer',
            'text'
        );
        $st = $oDbh->prepare($query, $aTypes, MDB2_PREPARE_MANIP);
        $aData = array(
            '2006-10-11 10:30:00',
            1,
            2,
            7,
            'www.foo.com'
        );
        $rows = $st->execute($aData);
        $aData = array(
            '2006-10-12 10:30:00',
            1,
            2,
            1,
            'www.foo.com'
        );
        $rows = $st->execute($aData);
        $aData = array(
            '2006-10-12 10:30:00',
            1,
            2,
            7,
            'www.bar.com'
        );
        $rows = $st->execute($aData);
        $aData = array(
            '2006-10-12 10:30:00',
            1,
            2,
            7,
            'www.foo.com'
        );
        $rows = $st->execute($aData);

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
        TestEnv::restoreEnv();

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
                (?, ?, ?, ?, ?, ?, ?)";
        $aTypes = array(
            'timestamp',
            'integer',
            'integer',
            'integer',
            'text',
            'text',
            'text'
        );
        $st = $oDbh->prepare($query, $aTypes, MDB2_PREPARE_MANIP);
        $aData = array(
            '2006-10-11 10:30:00',
            1,
            2,
            7,
            '192.168.0.1',
            'www.foo.com',
            'GB'
        );
        $rows = $st->execute($aData);
        $aData = array(
            '2006-10-12 10:30:00',
            1,
            2,
            1,
            '192.168.0.1',
            'www.foo.com',
            'GB'
        );
        $rows = $st->execute($aData);
        $aData = array(
            '2006-10-12 10:30:00',
            1,
            2,
            7,
            '192.168.0.1',
            'www.bar.com',
            'GB'
        );
        $rows = $st->execute($aData);
        $aData = array(
            '2006-10-12 10:30:00',
            1,
            2,
            7,
            '192.168.0.1',
            'www.foo.com',
            'GB'
        );
        $rows = $st->execute($aData);
        $aData = array(
            '2006-10-12 10:30:00',
            1,
            2,
            7,
            '192.168.0.1',
            'www.foo.co.uk',
            'AU'
        );
        $rows = $st->execute($aData);
        $aData = array(
            '2006-10-12 10:30:00',
            1,
            2,
            7,
            '192.168.0.1',
            'www.foo.co.uk',
            'GB'
        );
        $rows = $st->execute($aData);
        $aData = array(
            '2006-10-12 10:30:00',
            1,
            2,
            9,
            '127.0.0.1',
            'www.example.com',
            'US'
        );
        $rows = $st->execute($aData);

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

        TestEnv::restoreEnv();
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
        $oDbh = &OA_DB::singleton();
        $oMaxDalMaintenance = new OA_Dal_Maintenance_Forecasting();
        $table = $conf['table']['prefix'] . $conf['table']['data_summary_channel_daily'];

        // Test 1
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
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
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
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
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
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
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
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
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
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['actual_impressions'], 0);
        TestEnv::restoreEnv();
    }

}

?>
