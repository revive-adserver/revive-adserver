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

require_once MAX_PATH . '/lib/OA.php';
require_once MAX_PATH . '/lib/OA/Dal/Maintenance/Statistics/Factory.php';

/**
 * A class for testing the OA_Dal_Maintenance_Statistics_AdServer_* classes.
 *
 * @package    OpenadsDal
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew.hill@openads.org>
 */
class Test_OA_Dal_Maintenance_Statistics_AdServer_Star extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function Test_OA_Dal_Maintenance_Statistics_AdServer_Star()
    {
        $this->UnitTestCase();
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

        $oMDMSF = new OA_Dal_Maintenance_Statistics_Factory();
        $dsa = $oMDMSF->factory("AdServer");

        // Test with no data
        $date = $dsa->getMaintenanceStatisticsLastRunInfo(DAL_STATISTICS_COMMON_UPDATE_OI);
        $this->assertNull($date);
        $date = $dsa->getMaintenanceStatisticsLastRunInfo(DAL_STATISTICS_COMMON_UPDATE_HOUR);
        $this->assertNull($date);
        TestEnv::startTransaction();
        // Get the data for the tests
        include_once MAX_PATH . '/lib/max/Dal/data/TestOfStatisticsAdServermysql.php';
        // Insert ad impressions
        $query = "
            INSERT INTO
                data_raw_ad_impression
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
            1,
            0,
            1,
            '2004-06-06 18:22:10'
        );
        $rows = $st->execute($aData);
        $aData = array(
            1,
            0,
            1,
            '2004-05-06 12:34:56'
        );
        $rows = $st->execute($aData);
        $aData = array(
            1,
            0,
            1,
            '2004-06-06 18:22:11'
        );
        $rows = $st->execute($aData);
        // Test
        $date = $dsa->getMaintenanceStatisticsLastRunInfo(DAL_STATISTICS_COMMON_UPDATE_OI);
        $this->assertEqual($date, new Date('2004-05-06 11:59:59'));
        $date = $dsa->getMaintenanceStatisticsLastRunInfo(DAL_STATISTICS_COMMON_UPDATE_HOUR);
        $this->assertEqual($date, new Date('2004-05-06 11:59:59'));
        // Insert an hourly (only) update
        $query = "
            INSERT INTO
                log_maintenance_statistics
                (
                    start_run,
                    end_run,
                    duration,
                    adserver_run_type,
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
        $date = $dsa->getMaintenanceStatisticsLastRunInfo(DAL_STATISTICS_COMMON_UPDATE_OI);
        $this->assertEqual($date, new Date('2004-05-06 11:59:59'));
        $date = $dsa->getMaintenanceStatisticsLastRunInfo(DAL_STATISTICS_COMMON_UPDATE_HOUR);
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
        $date = $dsa->getMaintenanceStatisticsLastRunInfo(DAL_STATISTICS_COMMON_UPDATE_OI);
        $this->assertEqual($date, new Date('2004-06-06 10:16:00'));
        $date = $dsa->getMaintenanceStatisticsLastRunInfo(DAL_STATISTICS_COMMON_UPDATE_HOUR);
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
        $date = $dsa->getMaintenanceStatisticsLastRunInfo(DAL_STATISTICS_COMMON_UPDATE_OI);
        $this->assertEqual($date, new Date('2004-06-07 01:15:00'));
        $date = $dsa->getMaintenanceStatisticsLastRunInfo(DAL_STATISTICS_COMMON_UPDATE_HOUR);
        $this->assertEqual($date, new Date('2004-06-07 01:15:00'));
        TestEnv::rollbackTransaction();
        TestEnv::restoreConfig();
    }

    /**
     * A private method to insert test requests, impressions or clicks
     * for testing the summarisation of these via the _summariseData()
     * method.
     *
     * @param string $table The table name to insert into (ie. one of
     *                      "data_raw_ad_request", "data_raw_ad_impression"
     *                      or "data_raw_ad_click".
     */
    function _insertTestSummariseData($table)
    {
        $oDbh = &OA_DB::singleton();
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
            1,
            0,
            1,
            '2004-06-06 18:22:10'
        );
        $rows = $st->execute($aData);
        $aData = array(
            1,
            0,
            1,
            '2004-05-06 12:34:56'
        );
        $rows = $st->execute($aData);
        $aData = array(
            1,
            0,
            1,
            '2004-06-06 18:22:11'
        );
        $rows = $st->execute($aData);
    }

    /**
     * Tests the _summariseData() method.
     */
    function test_summariseData()
    {
        // Types to be tested
        $aType = array(
            'request'    => 'data_raw_ad_request',
            'impression' => 'data_raw_ad_impression',
            'click'      => 'data_raw_ad_click',
        );

        $conf = &$GLOBALS['_MAX']['CONF'];
        $oDbh = &OA_DB::singleton();
        $conf['table']['split'] = false;
        $conf['maintenance']['operationInterval'] = 30;

        $oMDMSF = new OA_Dal_Maintenance_Statistics_Factory();
        $dsa = $oMDMSF->factory("AdServer");

        foreach ($aType as $type => $table) {
            $returnColumnName = $type . 's';
            // Test with no data
            $start = new Date('2004-06-06 12:00:00');
            $end = new Date('2004-06-06 12:29:59');
            $rows = $dsa->_summariseData($start, $end, $type);
            $this->assertEqual($rows, 0);
            $query = "
                SELECT
                    COUNT(*) AS number
                FROM
                    tmp_ad_{$type}";
            $aRow = $oDbh->queryRow($query);
            $this->assertEqual($aRow['number'], 0);
            //TestEnv::startTransaction();
            // Insert 3 ad requests/impressions/clicks
            $this->_insertTestSummariseData($table);
            // Summarise where requests/impressions/clicks don't exist
            $start = new Date('2004-05-06 12:00:00');
            $end = new Date('2004-05-06 12:29:59');
            $rows = $dsa->_summariseData($start, $end, $type);
            $this->assertEqual($rows, 0);
            $query = "
                SELECT
                    COUNT(*) AS number
                FROM
                    tmp_ad_{$type}";
            $aRow = $oDbh->queryRow($query);
            $this->assertEqual($aRow['number'], 0);
            // Summarise where one request/impression/click exists
            $start = new Date('2004-05-06 12:30:00');
            $end = new Date('2004-05-06 12:59:59');
            $rows = $dsa->_summariseData($start, $end, $type);
            $this->assertEqual($rows, 1);
            $query = "
                SELECT
                    COUNT(*) AS number
                FROM
                    tmp_ad_{$type}";
            $aRow = $oDbh->queryRow($query);
            $this->assertEqual($aRow['number'], 1);
            // Summarise where the other two requests/impressions/clicks exist
            $start = new Date('2004-06-06 18:00:00');
            $end = new Date('2004-06-06 18:29:59');
            $rows = $dsa->_summariseData($start, $end, $type);
            $this->assertEqual($rows, 1);
            $query = "
                SELECT
                    COUNT(*) AS number
                FROM
                    tmp_ad_{$type}
                WHERE
                    day = '2004-05-06'";
            $aRow = $oDbh->queryRow($query);
            $this->assertEqual($aRow['number'], 1);
            $query = "
                SELECT
                    COUNT(*) AS number
                FROM
                    tmp_ad_{$type}
                WHERE
                    day = '2004-06-06'";
            $aRow = $oDbh->queryRow($query);
            $this->assertEqual($aRow['number'], 1);
            $query = "
                SELECT
                    $returnColumnName AS $returnColumnName
                FROM
                    tmp_ad_{$type}
                WHERE
                    day = '2004-06-06'";
            $aRow = $oDbh->queryRow($query);
            $this->assertEqual($aRow[$returnColumnName], 2);
            TestEnv::rollbackTransaction();
        }
        TestEnv::restoreConfig();
    }

    /**
     * A method to perform testing of the _dedupConversions() method.
     *
     * Test 0:  Test with no conversions.
     *
     * Test 1:  Test with one conversion, no variable values, and ensure that
     *              the conversion status remains as "approved".
     * Test 2:  Test with two conversions, no variable values, and ensure that
     *              the conversion statuses remain as "approved".
     *
     * Test 3:  Test with one conversion, one variable value (not unique, NULL),
     *              and ensure that the conversion status remains as "approved".
     * Test 4:  Test with one conversion, one variable value (not unique, empty string),
     *              and ensure that the conversion status remains as "approved".
     * Test 5:  Test with one conversion, one variable value (not unique, real value),
     *              and ensure that the conversion status remains as "approved".
     *
     * Test 6:  Test with two conversions, one variable value (not unique, NULL, NULL),
     *              and ensure that the conversion statuses remain as "approved".
     * Test 7:  Test with two conversions, one variable value (not unique, NULL, empty string),
     *              and ensure that the conversion statuses remain as "approved".
     * Test 8:  Test with two conversions, one variable value (not unique, NULL, real value),
     *              and ensure that the conversion statuses remain as "approved".
     * Test 9:  Test with two conversions, one variable value (not unique, empty string, empty string),
     *              and ensure that the conversion statuses remain as "approved".
     * Test 10:  Test with two conversions, one variable value (not unique, empty string, real value),
     *              and ensure that the conversion statuses remain as "approved".
     * Test 11: Test with two conversions, one variable value (not unique, real value, real value),
     *              and ensure that the conversion statuses remain as "approved".
     *
     * Test 12: Test with one conversion, one variable value (unique, NULL),
     *              and ensure that the conversion status remains as "approved".
     * Test 13: Test with one conversion, one variable value (unique, empty string),
     *              and ensure that the conversion status remains as "approved".
     * Test 14: Test with one conversion, one variable value (unique, real value),
     *              and ensure that the conversion status remains as "approved".
     *
     * Test 15: Test with two conversions, one variable value (unique, NULL, NULL),
     *              and ensure that the conversion statuses remain as "approved".
     *              (NOTE: This is a special case! Although the two variable values are
     *                     the "same", we don't de-duplicate, because, well, how can you
     *                     de-dupe on nothing?)
     *
     * Test 16: Test with two conversions, one variable value (unique, NULL, empty string),
     *              and ensure that the conversion statuses remain as "approved".
     *
     * Test 17: Test with two conversions, one variable value (unique, NULL, real value),
     *              and ensure that the conversion statuses remain as "approved".
     *
     * Test 18: Test with two conversions, one variable value (unique, empty string, empty string),
     *              and ensure that the FIRST conversion has its status remain as "approved",
     *              and the SECOND conversion has its status changed to "duplicate".
     *
     * Test 19: Test with two conversions, one variable value (unique, empty string, real value),
     *              and ensure that the conversion statuses remain as "approved".
     *
     * Test 20: Test with two conversions, one variable value (unique, different real values),
     *              and ensure that the conversion statuses remain as "approved".
     *
     * Test 21: Test with two conversions, one variable value (unique, equal real values),
     *              and ensure that the FIRST conversion has its status remain as "approved",
     *              and the SECOND conversion has its status changed to "duplicate".
     *
     * Test 22: Test with duplicate conversions in different hours, both within the
     *              unique window of the original, within the unique window of a duplicate
     *              (only), and outside of the unique window.
     *
     */
    function test_dedupConversions()
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $oDbh = &OA_DB::singleton();

        // Test 0
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');
        TestEnv::startTransaction();

        $oMDMSF = new OA_Dal_Maintenance_Statistics_Factory();
        $dsa = $oMDMSF->factory("AdServer");

        $dsa->_dedupConversions($oStartDate, $oEndDate);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 0);
        TestEnv::rollbackTransaction();

        // Test 1
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');
        TestEnv::startTransaction();
        // Insert a connection at 12:10:00, from a click on ad ID 5, zone ID 6, at 12:09
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status
                )
            VALUES
                (
                    1,
                    'singleDB',
                    1,
                    'viewerid1',
                    '2005-09-05 12:10:00',
                    '2005-09-05 12:09:00',
                    1,
                    5,
                    0,
                    6,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . "
                )";
        $rows = $oDbh->exec($query);
        $dsa = $oMDMSF->factory("AdServer");
        $dsa->_dedupConversions($oStartDate, $oEndDate);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 1);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
            WHERE
                connection_status = " . MAX_CONNECTION_STATUS_APPROVED;
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 1);
        TestEnv::rollbackTransaction();

        // Test 2
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');
        TestEnv::startTransaction();
        // Insert a connection at 12:10:00, from a click on ad ID 5, zone ID 6, at 12:09
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status
                )
            VALUES
                (
                    1,
                    'singleDB',
                    1,
                    'viewerid1',
                    '2005-09-05 12:10:00',
                    '2005-09-05 12:09:00',
                    1,
                    5,
                    0,
                    6,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . "
                )";
        $rows = $oDbh->exec($query);
        // Insert a connection at 12:30:00, from a click on ad ID 5, zone ID 6, at 12:29
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status
                )
            VALUES
                (
                    2,
                    'singleDB',
                    2,
                    '357826bf941721cb697a032a3d31a969',
                    '2005-09-05 12:30:00',
                    '2005-09-05 12:29:00',
                    1,
                    5,
                    0,
                    6,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . "
                )";
        $rows = $oDbh->exec($query);
        $dsa = $oMDMSF->factory("AdServer");
        $dsa->_dedupConversions($oStartDate, $oEndDate);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 2);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
            WHERE
                connection_status = " . MAX_CONNECTION_STATUS_APPROVED;
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 2);
        TestEnv::rollbackTransaction();

        // Test 3
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');
        TestEnv::startTransaction();
        // Prepare the variable value for the tracker
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['variables']}
                (
                    variableid,
                    trackerid,
                    name,
                    is_unique,
                    unique_window
                )
            VALUES
                (
                    1,
                    1,
                    'Test Non-Unique',
                    0,
                    3600
                )";
        $rows = $oDbh->exec($query);
        // Insert a connection at 12:10:00, from a click on ad ID 5, zone ID 6, at 12:09
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status
                )
            VALUES
                (
                    1,
                    'singleDB',
                    1,
                    'viewerid1',
                    '2005-09-05 12:10:00',
                    '2005-09-05 12:09:00',
                    1,
                    5,
                    0,
                    6,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . "
                )";
        $rows = $oDbh->exec($query);
        // Insert the variable value for the connection
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    1,
                    1,
                    1,
                    NULL
                )";
        $rows = $oDbh->exec($query);
        $dsa = $oMDMSF->factory("AdServer");
        $dsa->_dedupConversions($oStartDate, $oEndDate);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 1);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
            WHERE
                connection_status = " . MAX_CONNECTION_STATUS_APPROVED;
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 1);
        TestEnv::rollbackTransaction();

        // Test 4
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');
        TestEnv::startTransaction();
        // Prepare the variable value for the tracker
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['variables']}
                (
                    variableid,
                    trackerid,
                    name,
                    is_unique,
                    unique_window
                )
            VALUES
                (
                    1,
                    1,
                    'Test Non-Unique',
                    0,
                    3600
                )";
        $rows = $oDbh->exec($query);
        // Insert a connection at 12:10:00, from a click on ad ID 5, zone ID 6, at 12:09
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status
                )
            VALUES
                (
                    1,
                    'singleDB',
                    1,
                    'viewerid1',
                    '2005-09-05 12:10:00',
                    '2005-09-05 12:09:00',
                    1,
                    5,
                    0,
                    6,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . "
                )";
        $rows = $oDbh->exec($query);
        // Insert the variable value for the connection
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    1,
                    1,
                    1,
                    ''
                )";
        $rows = $oDbh->exec($query);
        $dsa = $oMDMSF->factory("AdServer");
        $dsa->_dedupConversions($oStartDate, $oEndDate);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 1);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
            WHERE
                connection_status = " . MAX_CONNECTION_STATUS_APPROVED;
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 1);
        TestEnv::rollbackTransaction();

        // Test 5
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');
        TestEnv::startTransaction();
        // Prepare the variable value for the tracker
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['variables']}
                (
                    variableid,
                    trackerid,
                    name,
                    is_unique,
                    unique_window
                )
            VALUES
                (
                    1,
                    1,
                    'Test Non-Unique',
                    0,
                    3600
                )";
        $rows = $oDbh->exec($query);
        // Insert a connection at 12:10:00, from a click on ad ID 5, zone ID 6, at 12:09
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status
                )
            VALUES
                (
                    1,
                    'singleDB',
                    1,
                    'viewerid1',
                    '2005-09-05 12:10:00',
                    '2005-09-05 12:09:00',
                    1,
                    5,
                    0,
                    6,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . "
                )";
        $rows = $oDbh->exec($query);
        // Insert the variable value for the connection
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    1,
                    1,
                    1,
                    'value'
                )";
        $rows = $oDbh->exec($query);
        $dsa = $oMDMSF->factory("AdServer");
        $dsa->_dedupConversions($oStartDate, $oEndDate);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 1);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
            WHERE
                connection_status = " . MAX_CONNECTION_STATUS_APPROVED;
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 1);
        TestEnv::rollbackTransaction();

        // Test 6
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');
        TestEnv::startTransaction();
        // Prepare the variable value for the tracker
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['variables']}
                (
                    variableid,
                    trackerid,
                    name,
                    is_unique,
                    unique_window
                )
            VALUES
                (
                    1,
                    1,
                    'Test Non-Unique',
                    0,
                    3600
                )";
        $rows = $oDbh->exec($query);
        // Insert a connection at 12:10:00, from a click on ad ID 5, zone ID 6, at 12:09
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status
                )
            VALUES
                (
                    1,
                    'singleDB',
                    1,
                    'viewerid1',
                    '2005-09-05 12:10:00',
                    '2005-09-05 12:09:00',
                    1,
                    5,
                    0,
                    6,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . "
                )";
        $rows = $oDbh->exec($query);
        // Insert the variable value for the connection
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    1,
                    1,
                    1,
                    NULL
                )";
        $rows = $oDbh->exec($query);
        // Insert a connection at 12:30:00, from a click on ad ID 5, zone ID 6, at 12:29
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status
                )
            VALUES
                (
                    2,
                    'singleDB',
                    2,
                    '357826bf941721cb697a032a3d31a969',
                    '2005-09-05 12:30:00',
                    '2005-09-05 12:29:00',
                    1,
                    5,
                    0,
                    6,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . "
                )";
        $rows = $oDbh->exec($query);
        // Insert the variable value for the connection
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    2,
                    2,
                    1,
                    NULL
                )";
        $rows = $oDbh->exec($query);
        $dsa = $oMDMSF->factory("AdServer");
        $dsa->_dedupConversions($oStartDate, $oEndDate);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 2);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
            WHERE
                connection_status = " . MAX_CONNECTION_STATUS_APPROVED;
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 2);
        TestEnv::rollbackTransaction();

        // Test 7
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');
        TestEnv::startTransaction();
        // Prepare the variable value for the tracker
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['variables']}
                (
                    variableid,
                    trackerid,
                    name,
                    is_unique,
                    unique_window
                )
            VALUES
                (
                    1,
                    1,
                    'Test Non-Unique',
                    0,
                    3600
                )";
        $rows = $oDbh->exec($query);
        // Insert a connection at 12:10:00, from a click on ad ID 5, zone ID 6, at 12:09
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status
                )
            VALUES
                (
                    1,
                    'singleDB',
                    1,
                    'viewerid1',
                    '2005-09-05 12:10:00',
                    '2005-09-05 12:09:00',
                    1,
                    5,
                    0,
                    6,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . "
                )";
        $rows = $oDbh->exec($query);
        // Insert the variable value for the connection
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    1,
                    1,
                    1,
                    NULL
                )";
        $rows = $oDbh->exec($query);
        // Insert a connection at 12:30:00, from a click on ad ID 5, zone ID 6, at 12:29
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status
                )
            VALUES
                (
                    2,
                    'singleDB',
                    2,
                    '357826bf941721cb697a032a3d31a969',
                    '2005-09-05 12:30:00',
                    '2005-09-05 12:29:00',
                    1,
                    5,
                    0,
                    6,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . "
                )";
        $rows = $oDbh->exec($query);
        // Insert the variable value for the connection
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    2,
                    2,
                    1,
                    ''
                )";
        $rows = $oDbh->exec($query);
        $dsa = $oMDMSF->factory("AdServer");
        $dsa->_dedupConversions($oStartDate, $oEndDate);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 2);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
            WHERE
                connection_status = " . MAX_CONNECTION_STATUS_APPROVED;
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 2);
        TestEnv::rollbackTransaction();

        // Test 8
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');
        TestEnv::startTransaction();
        // Prepare the variable value for the tracker
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['variables']}
                (
                    variableid,
                    trackerid,
                    name,
                    is_unique,
                    unique_window
                )
            VALUES
                (
                    1,
                    1,
                    'Test Non-Unique',
                    0,
                    3600
                )";
        $rows = $oDbh->exec($query);
        // Insert a connection at 12:10:00, from a click on ad ID 5, zone ID 6, at 12:09
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status
                )
            VALUES
                (
                    1,
                    'singleDB',
                    1,
                    'viewerid1',
                    '2005-09-05 12:10:00',
                    '2005-09-05 12:09:00',
                    1,
                    5,
                    0,
                    6,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . "
                )";
        $rows = $oDbh->exec($query);
        // Insert the variable value for the connection
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    1,
                    1,
                    1,
                    NULL
                )";
        $rows = $oDbh->exec($query);
        // Insert a connection at 12:30:00, from a click on ad ID 5, zone ID 6, at 12:29
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status
                )
            VALUES
                (
                    2,
                    'singleDB',
                    2,
                    '357826bf941721cb697a032a3d31a969',
                    '2005-09-05 12:30:00',
                    '2005-09-05 12:29:00',
                    1,
                    5,
                    0,
                    6,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . "
                )";
        $rows = $oDbh->exec($query);
        // Insert the variable value for the connection
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    2,
                    2,
                    1,
                    'value'
                )";
        $rows = $oDbh->exec($query);
        $dsa = $oMDMSF->factory("AdServer");
        $dsa->_dedupConversions($oStartDate, $oEndDate);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 2);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
            WHERE
                connection_status = " . MAX_CONNECTION_STATUS_APPROVED;
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 2);
        TestEnv::rollbackTransaction();

        // Test 9
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');
        TestEnv::startTransaction();
        // Prepare the variable value for the tracker
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['variables']}
                (
                    variableid,
                    trackerid,
                    name,
                    is_unique,
                    unique_window
                )
            VALUES
                (
                    1,
                    1,
                    'Test Non-Unique',
                    0,
                    3600
                )";
        $rows = $oDbh->exec($query);
        // Insert a connection at 12:10:00, from a click on ad ID 5, zone ID 6, at 12:09
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status
                )
            VALUES
                (
                    1,
                    'singleDB',
                    1,
                    'viewerid1',
                    '2005-09-05 12:10:00',
                    '2005-09-05 12:09:00',
                    1,
                    5,
                    0,
                    6,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . "
                )";
        $rows = $oDbh->exec($query);
        // Insert the variable value for the connection
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    1,
                    1,
                    1,
                    ''
                )";
        $rows = $oDbh->exec($query);
        // Insert a connection at 12:30:00, from a click on ad ID 5, zone ID 6, at 12:29
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status
                )
            VALUES
                (
                    2,
                    'singleDB',
                    2,
                    '357826bf941721cb697a032a3d31a969',
                    '2005-09-05 12:30:00',
                    '2005-09-05 12:29:00',
                    1,
                    5,
                    0,
                    6,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . "
                )";
        $rows = $oDbh->exec($query);
        // Insert the variable value for the connection
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    2,
                    2,
                    1,
                    ''
                )";
        $rows = $oDbh->exec($query);
        $dsa = $oMDMSF->factory("AdServer");
        $dsa->_dedupConversions($oStartDate, $oEndDate);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 2);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
            WHERE
                connection_status = " . MAX_CONNECTION_STATUS_APPROVED;
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 2);
        TestEnv::rollbackTransaction();

        // Test 10
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');
        TestEnv::startTransaction();
        // Prepare the variable value for the tracker
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['variables']}
                (
                    variableid,
                    trackerid,
                    name,
                    is_unique,
                    unique_window
                )
            VALUES
                (
                    1,
                    1,
                    'Test Non-Unique',
                    0,
                    3600
                )";
        $rows = $oDbh->exec($query);
        // Insert a connection at 12:10:00, from a click on ad ID 5, zone ID 6, at 12:09
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status
                )
            VALUES
                (
                    1,
                    'singleDB',
                    1,
                    'viewerid1',
                    '2005-09-05 12:10:00',
                    '2005-09-05 12:09:00',
                    1,
                    5,
                    0,
                    6,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . "
                )";
        $rows = $oDbh->exec($query);
        // Insert the variable value for the connection
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    1,
                    1,
                    1,
                    ''
                )";
        $rows = $oDbh->exec($query);
        // Insert a connection at 12:30:00, from a click on ad ID 5, zone ID 6, at 12:29
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status
                )
            VALUES
                (
                    2,
                    'singleDB',
                    2,
                    '357826bf941721cb697a032a3d31a969',
                    '2005-09-05 12:30:00',
                    '2005-09-05 12:29:00',
                    1,
                    5,
                    0,
                    6,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . "
                )";
        $rows = $oDbh->exec($query);
        // Insert the variable value for the connection
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    2,
                    2,
                    1,
                    'value'
                )";
        $rows = $oDbh->exec($query);
        $dsa = $oMDMSF->factory("AdServer");
        $dsa->_dedupConversions($oStartDate, $oEndDate);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 2);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
            WHERE
                connection_status = " . MAX_CONNECTION_STATUS_APPROVED;
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 2);
        TestEnv::rollbackTransaction();

        // Test 11
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');
        TestEnv::startTransaction();
        // Prepare the variable value for the tracker
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['variables']}
                (
                    variableid,
                    trackerid,
                    name,
                    is_unique,
                    unique_window
                )
            VALUES
                (
                    1,
                    1,
                    'Test Non-Unique',
                    0,
                    3600
                )";
        $rows = $oDbh->exec($query);
        // Insert a connection at 12:10:00, from a click on ad ID 5, zone ID 6, at 12:09
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status
                )
            VALUES
                (
                    1,
                    'singleDB',
                    1,
                    'viewerid1',
                    '2005-09-05 12:10:00',
                    '2005-09-05 12:09:00',
                    1,
                    5,
                    0,
                    6,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . "
                )";
        $rows = $oDbh->exec($query);
        // Insert the variable value for the connection
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    1,
                    1,
                    1,
                    'value'
                )";
        $rows = $oDbh->exec($query);
        // Insert a connection at 12:30:00, from a click on ad ID 5, zone ID 6, at 12:29
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status
                )
            VALUES
                (
                    2,
                    'singleDB',
                    2,
                    '357826bf941721cb697a032a3d31a969',
                    '2005-09-05 12:30:00',
                    '2005-09-05 12:29:00',
                    1,
                    5,
                    0,
                    6,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . "
                )";
        $rows = $oDbh->exec($query);
        // Insert the variable value for the connection
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    2,
                    2,
                    1,
                    'value'
                )";
        $rows = $oDbh->exec($query);
        $dsa = $oMDMSF->factory("AdServer");
        $dsa->_dedupConversions($oStartDate, $oEndDate);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 2);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
            WHERE
                connection_status = " . MAX_CONNECTION_STATUS_APPROVED;
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 2);
        TestEnv::rollbackTransaction();

        // Test 12
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');
        TestEnv::startTransaction();
        // Prepare the variable value for the tracker
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['variables']}
                (
                    variableid,
                    trackerid,
                    name,
                    is_unique,
                    unique_window
                )
            VALUES
                (
                    1,
                    1,
                    'Test Unique',
                    1,
                    3600
                )";
        $rows = $oDbh->exec($query);
        // Insert a connection at 12:10:00, from a click on ad ID 5, zone ID 6, at 12:09
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status
                )
            VALUES
                (
                    1,
                    'singleDB',
                    1,
                    'viewerid1',
                    '2005-09-05 12:10:00',
                    '2005-09-05 12:09:00',
                    1,
                    5,
                    0,
                    6,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . "
                )";
        $rows = $oDbh->exec($query);
        // Insert the variable value for the connection
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    1,
                    1,
                    1,
                    NULL
                )";
        $rows = $oDbh->exec($query);
        $dsa = $oMDMSF->factory("AdServer");
        $dsa->_dedupConversions($oStartDate, $oEndDate);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 1);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
            WHERE
                connection_status = " . MAX_CONNECTION_STATUS_APPROVED;
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 1);
        TestEnv::rollbackTransaction();

        // Test 13
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');
        TestEnv::startTransaction();
        // Prepare the variable value for the tracker
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['variables']}
                (
                    variableid,
                    trackerid,
                    name,
                    is_unique,
                    unique_window
                )
            VALUES
                (
                    1,
                    1,
                    'Test Unique',
                    1,
                    3600
                )";
        $rows = $oDbh->exec($query);
        // Insert a connection at 12:10:00, from a click on ad ID 5, zone ID 6, at 12:09
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status
                )
            VALUES
                (
                    1,
                    'singleDB',
                    1,
                    'viewerid1',
                    '2005-09-05 12:10:00',
                    '2005-09-05 12:09:00',
                    1,
                    5,
                    0,
                    6,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . "
                )";
        $rows = $oDbh->exec($query);
        // Insert the variable value for the connection
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    1,
                    1,
                    1,
                    ''
                )";
        $rows = $oDbh->exec($query);
        $dsa = $oMDMSF->factory("AdServer");
        $dsa->_dedupConversions($oStartDate, $oEndDate);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 1);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
            WHERE
                connection_status = " . MAX_CONNECTION_STATUS_APPROVED;
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 1);
        TestEnv::rollbackTransaction();

        // Test 14
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');
        TestEnv::startTransaction();
        // Prepare the variable value for the tracker
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['variables']}
                (
                    variableid,
                    trackerid,
                    name,
                    is_unique,
                    unique_window
                )
            VALUES
                (
                    1,
                    1,
                    'Test Unique',
                    1,
                    3600
                )";
        $rows = $oDbh->exec($query);
        // Insert a connection at 12:10:00, from a click on ad ID 5, zone ID 6, at 12:09
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status
                )
            VALUES
                (
                    1,
                    'singleDB',
                    1,
                    'viewerid1',
                    '2005-09-05 12:10:00',
                    '2005-09-05 12:09:00',
                    1,
                    5,
                    0,
                    6,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . "
                )";
        $rows = $oDbh->exec($query);
        // Insert the variable value for the connection
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    1,
                    1,
                    1,
                    'value'
                )";
        $rows = $oDbh->exec($query);
        $dsa = $oMDMSF->factory("AdServer");
        $dsa->_dedupConversions($oStartDate, $oEndDate);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 1);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
            WHERE
                connection_status = " . MAX_CONNECTION_STATUS_APPROVED;
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 1);
        TestEnv::rollbackTransaction();

        // Test 15
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');
        TestEnv::startTransaction();
        // Prepare the variable value for the tracker
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['variables']}
                (
                    variableid,
                    trackerid,
                    name,
                    is_unique,
                    unique_window
                )
            VALUES
                (
                    1,
                    1,
                    'Test Unique',
                    1,
                    3600
                )";
        $rows = $oDbh->exec($query);
        // Insert a connection at 12:10:00, from a click on ad ID 5, zone ID 6, at 12:09
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status
                )
            VALUES
                (
                    1,
                    'singleDB',
                    1,
                    'viewerid1',
                    '2005-09-05 12:10:00',
                    '2005-09-05 12:09:00',
                    1,
                    5,
                    0,
                    6,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . "
                )";
        $rows = $oDbh->exec($query);
        // Insert the variable value for the connection
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    1,
                    1,
                    1,
                    NULL
                )";
        $rows = $oDbh->exec($query);
        // Insert a connection at 12:30:00, from a click on ad ID 5, zone ID 6, at 12:29
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status
                )
            VALUES
                (
                    2,
                    'singleDB',
                    2,
                    '357826bf941721cb697a032a3d31a969',
                    '2005-09-05 12:30:00',
                    '2005-09-05 12:29:00',
                    1,
                    5,
                    0,
                    6,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . "
                )";
        $rows = $oDbh->exec($query);
        // Insert the variable value for the connection
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    2,
                    2,
                    1,
                    NULL
                )";
        $rows = $oDbh->exec($query);
        $dsa = $oMDMSF->factory("AdServer");
        $dsa->_dedupConversions($oStartDate, $oEndDate);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 2);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
            WHERE
                connection_status = " . MAX_CONNECTION_STATUS_APPROVED;
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 2);
        TestEnv::rollbackTransaction();

        // Test 16
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');
        TestEnv::startTransaction();
        // Prepare the variable value for the tracker
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['variables']}
                (
                    variableid,
                    trackerid,
                    name,
                    is_unique,
                    unique_window
                )
            VALUES
                (
                    1,
                    1,
                    'Test Unique',
                    1,
                    3600
                )";
        $rows = $oDbh->exec($query);
        // Insert a connection at 12:10:00, from a click on ad ID 5, zone ID 6, at 12:09
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status
                )
            VALUES
                (
                    1,
                    'singleDB',
                    1,
                    'viewerid1',
                    '2005-09-05 12:10:00',
                    '2005-09-05 12:09:00',
                    1,
                    5,
                    0,
                    6,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . "
                )";
        $rows = $oDbh->exec($query);
        // Insert the variable value for the connection
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    1,
                    1,
                    1,
                    NULL
                )";
        $rows = $oDbh->exec($query);
        // Insert a connection at 12:30:00, from a click on ad ID 5, zone ID 6, at 12:29
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status
                )
            VALUES
                (
                    2,
                    'singleDB',
                    2,
                    '357826bf941721cb697a032a3d31a969',
                    '2005-09-05 12:30:00',
                    '2005-09-05 12:29:00',
                    1,
                    5,
                    0,
                    6,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . "
                )";
        $rows = $oDbh->exec($query);
        // Insert the variable value for the connection
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    2,
                    2,
                    1,
                    ''
                )";
        $rows = $oDbh->exec($query);
        $dsa = $oMDMSF->factory("AdServer");
        $dsa->_dedupConversions($oStartDate, $oEndDate);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 2);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
            WHERE
                connection_status = " . MAX_CONNECTION_STATUS_APPROVED;
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 2);
        TestEnv::rollbackTransaction();

        // Test 17
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');
        TestEnv::startTransaction();
        // Prepare the variable value for the tracker
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['variables']}
                (
                    variableid,
                    trackerid,
                    name,
                    is_unique,
                    unique_window
                )
            VALUES
                (
                    1,
                    1,
                    'Test Unique',
                    1,
                    3600
                )";
        $rows = $oDbh->exec($query);
        // Insert a connection at 12:10:00, from a click on ad ID 5, zone ID 6, at 12:09
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status
                )
            VALUES
                (
                    1,
                    'singleDB',
                    1,
                    'viewerid1',
                    '2005-09-05 12:10:00',
                    '2005-09-05 12:09:00',
                    1,
                    5,
                    0,
                    6,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . "
                )";
        $rows = $oDbh->exec($query);
        // Insert the variable value for the connection
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    1,
                    1,
                    1,
                    NULL
                )";
        $rows = $oDbh->exec($query);
        // Insert a connection at 12:30:00, from a click on ad ID 5, zone ID 6, at 12:29
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status
                )
            VALUES
                (
                    2,
                    'singleDB',
                    2,
                    '357826bf941721cb697a032a3d31a969',
                    '2005-09-05 12:30:00',
                    '2005-09-05 12:29:00',
                    1,
                    5,
                    0,
                    6,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . "
                )";
        $rows = $oDbh->exec($query);
        // Insert the variable value for the connection
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    2,
                    2,
                    1,
                    'value'
                )";
        $rows = $oDbh->exec($query);
        $dsa = $oMDMSF->factory("AdServer");
        $dsa->_dedupConversions($oStartDate, $oEndDate);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 2);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
            WHERE
                connection_status = " . MAX_CONNECTION_STATUS_APPROVED;
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 2);
        TestEnv::rollbackTransaction();

        // Test 18
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');
        TestEnv::startTransaction();
        // Prepare the variable value for the tracker
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['variables']}
                (
                    variableid,
                    trackerid,
                    name,
                    is_unique,
                    unique_window
                )
            VALUES
                (
                    1,
                    1,
                    'Test Unique',
                    1,
                    3600
                )";
        $rows = $oDbh->exec($query);
        // Insert a connection at 12:10:00, from a click on ad ID 5, zone ID 6, at 12:09
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status,
                    inside_window
                )
            VALUES
                (
                    1,
                    'singleDB',
                    1,
                    'viewerid1',
                    '2005-09-05 12:10:00',
                    '2005-09-05 12:09:00',
                    1,
                    5,
                    0,
                    6,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . ",
                    1
                )";
        $rows = $oDbh->exec($query);
        // Insert the variable value for the connection
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    1,
                    1,
                    1,
                    ''
                )";
        $rows = $oDbh->exec($query);
        // Insert a connection at 12:30:00, from a click on ad ID 5, zone ID 6, at 12:29
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status,
                    inside_window
                )
            VALUES
                (
                    2,
                    'singleDB',
                    2,
                    '357826bf941721cb697a032a3d31a969',
                    '2005-09-05 12:30:00',
                    '2005-09-05 12:29:00',
                    1,
                    5,
                    0,
                    6,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . ",
                    1
                )";
        $rows = $oDbh->exec($query);
        // Insert the variable value for the connection
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    2,
                    2,
                    1,
                    ''
                )";
        $rows = $oDbh->exec($query);
        $dsa = $oMDMSF->factory("AdServer");
        $dsa->_dedupConversions($oStartDate, $oEndDate);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 2);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
            WHERE
                connection_status = " . MAX_CONNECTION_STATUS_APPROVED;
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 1);
        $query = "
            SELECT
                connection_status,
                comments

            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
            WHERE
                data_intermediate_ad_connection_id = 1";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 2);
        $this->assertEqual($aRow['connection_status'], MAX_CONNECTION_STATUS_APPROVED);
        $this->assertEqual($aRow['comments'], '');
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
            WHERE
                connection_status = " . MAX_CONNECTION_STATUS_DUPLICATE;
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 1);
        $query = "
            SELECT
                connection_status,
                comments

            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
            WHERE
                data_intermediate_ad_connection_id = 2";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 2);
        $this->assertEqual($aRow['connection_status'], MAX_CONNECTION_STATUS_DUPLICATE);
        $this->assertEqual($aRow['comments'], 'Duplicate of connection ID 1');
        TestEnv::rollbackTransaction();

        // Test 19
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');
        TestEnv::startTransaction();
        // Prepare the variable value for the tracker
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['variables']}
                (
                    variableid,
                    trackerid,
                    name,
                    is_unique,
                    unique_window
                )
            VALUES
                (
                    1,
                    1,
                    'Test Unique',
                    1,
                    3600
                )";
        $rows = $oDbh->exec($query);
        // Insert a connection at 12:10:00, from a click on ad ID 5, zone ID 6, at 12:09
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status,
                    inside_window
                )
            VALUES
                (
                    1,
                    'singleDB',
                    1,
                    'viewerid1',
                    '2005-09-05 12:10:00',
                    '2005-09-05 12:09:00',
                    1,
                    5,
                    0,
                    6,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . ",
                    1
                )";
        $rows = $oDbh->exec($query);
        // Insert the variable value for the connection
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    1,
                    1,
                    1,
                    ''
                )";
        $rows = $oDbh->exec($query);
        // Insert a connection at 12:30:00, from a click on ad ID 5, zone ID 6, at 12:29
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status,
                    inside_window
                )
            VALUES
                (
                    2,
                    'singleDB',
                    2,
                    '357826bf941721cb697a032a3d31a969',
                    '2005-09-05 12:30:00',
                    '2005-09-05 12:29:00',
                    1,
                    5,
                    0,
                    6,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . ",
                    1
                )";
        $rows = $oDbh->exec($query);
        // Insert the variable value for the connection
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    2,
                    2,
                    1,
                    'value'
                )";
        $rows = $oDbh->exec($query);
        $dsa = $oMDMSF->factory("AdServer");
        $dsa->_dedupConversions($oStartDate, $oEndDate);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 2);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
            WHERE
                connection_status = " . MAX_CONNECTION_STATUS_APPROVED;
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 2);
        TestEnv::rollbackTransaction();

        // Test 20
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');
        TestEnv::startTransaction();
        // Prepare the variable value for the tracker
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['variables']}
                (
                    variableid,
                    trackerid,
                    name,
                    is_unique,
                    unique_window
                )
            VALUES
                (
                    1,
                    1,
                    'Test Unique',
                    1,
                    3600
                )";
        $rows = $oDbh->exec($query);
        // Insert a connection at 12:10:00, from a click on ad ID 5, zone ID 6, at 12:09
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status,
                    inside_window
                )
            VALUES
                (
                    1,
                    'singleDB',
                    1,
                    'viewerid1',
                    '2005-09-05 12:10:00',
                    '2005-09-05 12:09:00',
                    1,
                    5,
                    0,
                    6,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . ",
                    1
                )";
        $rows = $oDbh->exec($query);
        // Insert the variable value for the connection
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    1,
                    1,
                    1,
                    'value1'
                )";
        $rows = $oDbh->exec($query);
        // Insert a connection at 12:30:00, from a click on ad ID 5, zone ID 6, at 12:29
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status,
                    inside_window
                )
            VALUES
                (
                    2,
                    'singleDB',
                    2,
                    '357826bf941721cb697a032a3d31a969',
                    '2005-09-05 12:30:00',
                    '2005-09-05 12:29:00',
                    1,
                    5,
                    0,
                    6,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . ",
                    1
                )";
        $rows = $oDbh->exec($query);
        // Insert the variable value for the connection
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    2,
                    2,
                    1,
                    'value2'
                )";
        $rows = $oDbh->exec($query);
        $dsa = $oMDMSF->factory("AdServer");
        $dsa->_dedupConversions($oStartDate, $oEndDate);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 2);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
            WHERE
                connection_status = " . MAX_CONNECTION_STATUS_APPROVED;
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 2);
        TestEnv::rollbackTransaction();

        // Test 21
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');
        TestEnv::startTransaction();
        // Prepare the variable value for the tracker
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['variables']}
                (
                    variableid,
                    trackerid,
                    name,
                    is_unique,
                    unique_window
                )
            VALUES
                (
                    1,
                    1,
                    'Test Unique',
                    1,
                    3600
                )";
        $rows = $oDbh->exec($query);
        // Insert a connection at 12:10:00, from a click on ad ID 5, zone ID 6, at 12:09
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status,
                    inside_window
                )
            VALUES
                (
                    1,
                    'singleDB',
                    1,
                    'viewerid1',
                    '2005-09-05 12:10:00',
                    '2005-09-05 12:09:00',
                    1,
                    5,
                    0,
                    6,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . ",
                    1
                )";
        $rows = $oDbh->exec($query);
        // Insert the variable value for the connection
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    1,
                    1,
                    1,
                    'value'
                )";
        $rows = $oDbh->exec($query);
        // Insert a connection at 12:30:00, from a click on ad ID 5, zone ID 6, at 12:29
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status,
                    inside_window
                )
            VALUES
                (
                    2,
                    'singleDB',
                    2,
                    '357826bf941721cb697a032a3d31a969',
                    '2005-09-05 12:30:00',
                    '2005-09-05 12:29:00',
                    1,
                    5,
                    0,
                    6,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . ",
                    1
                )";
        $rows = $oDbh->exec($query);
        // Insert the variable value for the connection
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    2,
                    2,
                    1,
                    'value'
                )";
        $rows = $oDbh->exec($query);
        $dsa = $oMDMSF->factory("AdServer");
        $dsa->_dedupConversions($oStartDate, $oEndDate);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 2);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
            WHERE
                connection_status = " . MAX_CONNECTION_STATUS_APPROVED;
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 1);
        $query = "
            SELECT
                connection_status,
                comments

            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
            WHERE
                data_intermediate_ad_connection_id = 1";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 2);
        $this->assertEqual($aRow['connection_status'], MAX_CONNECTION_STATUS_APPROVED);
        $this->assertEqual($aRow['comments'], '');
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
            WHERE
                connection_status = " . MAX_CONNECTION_STATUS_DUPLICATE;
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 1);
        $query = "
            SELECT
                connection_status,
                comments

            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
            WHERE
                data_intermediate_ad_connection_id = 2";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 2);
        $this->assertEqual($aRow['connection_status'], MAX_CONNECTION_STATUS_DUPLICATE);
        $this->assertEqual($aRow['comments'], 'Duplicate of connection ID 1');
        TestEnv::rollbackTransaction();

        // Test 22
        TestEnv::startTransaction();
        // Prepare the variable values for the tracker
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['variables']}
                (
                    variableid,
                    trackerid,
                    name,
                    is_unique,
                    unique_window
                )
            VALUES
                (
                    1,
                    1,
                    'Test Non-Unique',
                    0,
                    3600
                )";
        $rows = $oDbh->exec($query);
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['variables']}
                (
                    variableid,
                    trackerid,
                    name,
                    is_unique,
                    unique_window
                )
            VALUES
                (
                    2,
                    1,
                    'Test Unique',
                    1,
                    3600
                )";
        $rows = $oDbh->exec($query);
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['variables']}
                (
                    variableid,
                    trackerid,
                    name,
                    is_unique,
                    unique_window
                )
            VALUES
                (
                    3,
                    2,
                    'Test Unique',
                    1,
                    3600
                )";
        $rows = $oDbh->exec($query);
        // Insert a connection at 12:10:00, from a click on ad ID 5, zone ID 6, at 12:09,
        // using tracker ID 1 (two variable values)
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status,
                    inside_window
                )
            VALUES
                (
                    1,
                    'singleDB',
                    1,
                    'viewerid1',
                    '2005-09-05 12:10:00',
                    '2005-09-05 12:09:00',
                    1,
                    5,
                    0,
                    6,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . ",
                    1
                )";
        $rows = $oDbh->exec($query);
        // Insert the variable values for the connection
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    1,
                    1,
                    1,
                    'test non-unique'
                )";
        $rows = $oDbh->exec($query);
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    2,
                    1,
                    2,
                    'test unique'
                )";
        $rows = $oDbh->exec($query);
        // Insert a connection at 12:15:00, from a click on ad ID 7, zone ID 8, at 12:14,
        // using tracker ID 2 (one variable value)
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status,
                    inside_window
                )
            VALUES
                (
                    2,
                    'singleDB',
                    2,
                    'viewerid2',
                    '2005-09-05 12:15:00',
                    '2005-09-05 12:14:00',
                    2,
                    7,
                    0,
                    8,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . ",
                    1
                )";
        $rows = $oDbh->exec($query);
        // Insert the variable values for the connection
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    3,
                    2,
                    3,
                    'test unique'
                )";
        $rows = $oDbh->exec($query);
        // Dedupe this hour
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');
        $dsa = $oMDMSF->factory("AdServer");
        $dsa->_dedupConversions($oStartDate, $oEndDate);
        // Ensure that both conversions have NOT been deduped
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 2);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
            WHERE
                connection_status = " . MAX_CONNECTION_STATUS_APPROVED;
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 2);
        $query = "
            SELECT
                connection_status,
                comments

            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
            WHERE
                data_intermediate_ad_connection_id = 1";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 2);
        $this->assertEqual($aRow['connection_status'], MAX_CONNECTION_STATUS_APPROVED);
        $this->assertEqual($aRow['comments'], '');
        $query = "
            SELECT
                connection_status,
                comments

            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
            WHERE
                data_intermediate_ad_connection_id = 2";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 2);
        $this->assertEqual($aRow['connection_status'], MAX_CONNECTION_STATUS_APPROVED);
        $this->assertEqual($aRow['comments'], '');
        // Insert a connection at 13:05:00, from a click on ad ID 5, zone ID 6, at 13:04,
        // using tracker ID 1 (two variable values)
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status,
                    inside_window
                )
            VALUES
                (
                    3,
                    'singleDB',
                    3,
                    'viewerid3',
                    '2005-09-05 13:05:00',
                    '2005-09-05 13:04:00',
                    1,
                    5,
                    0,
                    6,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . ",
                    1
                )";
        $rows = $oDbh->exec($query);
        // Insert the variable values for the connection
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    4,
                    3,
                    1,
                    'test non-unique'
                )";
        $rows = $oDbh->exec($query);
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    5,
                    3,
                    2,
                    'test unique different'
                )";
        $rows = $oDbh->exec($query);
        // Insert a connection at 13:06:00, from a click on ad ID 5, zone ID 6, at 13:05,
        // using tracker ID 1 (two variable values)
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status,
                    inside_window
                )
            VALUES
                (
                    4,
                    'singleDB',
                    4,
                    'viewerid3',
                    '2005-09-05 13:06:00',
                    '2005-09-05 13:05:00',
                    1,
                    5,
                    0,
                    6,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . ",
                    1
                )";
        $rows = $oDbh->exec($query);
        // Insert the variable values for the connection
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    6,
                    4,
                    1,
                    'test non-unique'
                )";
        $rows = $oDbh->exec($query);
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    7,
                    4,
                    2,
                    'test unique'
                )";
        $rows = $oDbh->exec($query);
        // Dedupe this hour
        $oStartDate = new Date('2005-09-05 13:00:00');
        $oEndDate   = new Date('2005-09-07 13:29:59');
        $dsa = $oMDMSF->factory("AdServer");
        $dsa->_dedupConversions($oStartDate, $oEndDate);
        // Ensure that both only the correct conversions has been deduped
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 4);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
            WHERE
                connection_status = " . MAX_CONNECTION_STATUS_APPROVED;
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 3);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
            WHERE
                connection_status = " . MAX_CONNECTION_STATUS_DUPLICATE;
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 1);
        $query = "
            SELECT
                connection_status,
                comments

            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
            WHERE
                data_intermediate_ad_connection_id = 1";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 2);
        $this->assertEqual($aRow['connection_status'], MAX_CONNECTION_STATUS_APPROVED);
        $this->assertEqual($aRow['comments'], '');
        $query = "
            SELECT
                connection_status,
                comments

            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
            WHERE
                data_intermediate_ad_connection_id = 2";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 2);
        $this->assertEqual($aRow['connection_status'], MAX_CONNECTION_STATUS_APPROVED);
        $this->assertEqual($aRow['comments'], '');
        $query = "
            SELECT
                connection_status,
                comments

            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
            WHERE
                data_intermediate_ad_connection_id = 3";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 2);
        $this->assertEqual($aRow['connection_status'], MAX_CONNECTION_STATUS_APPROVED);
        $this->assertEqual($aRow['comments'], '');
        $query = "
            SELECT
                connection_status,
                comments

            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
            WHERE
                data_intermediate_ad_connection_id = 4";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 2);
        $this->assertEqual($aRow['connection_status'], MAX_CONNECTION_STATUS_DUPLICATE);
        $this->assertEqual($aRow['comments'], 'Duplicate of connection ID 1');
        // Insert a connection at 14:05:00, from a click on ad ID 5, zone ID 6, at 14:04,
        // using tracker ID 1 (two variable values)
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status,
                    inside_window
                )
            VALUES
                (
                    5,
                    'singleDB',
                    5,
                    'viewerid3',
                    '2005-09-05 14:05:00',
                    '2005-09-05 14:04:00',
                    1,
                    5,
                    0,
                    6,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . ",
                    1
                )";
        $rows = $oDbh->exec($query);
        // Insert the variable values for the connection
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    8,
                    5,
                    1,
                    'test non-unique'
                )";
        $rows = $oDbh->exec($query);
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    9,
                    5,
                    2,
                    'test unique'
                )";
        $rows = $oDbh->exec($query);
        // Insert a connection at 14:15:00, from a click on ad ID 7, zone ID 8, at 14:14,
        // using tracker ID 2 (one variable value)
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status,
                    inside_window
                )
            VALUES
                (
                    6,
                    'singleDB',
                    6,
                    'viewerid2',
                    '2005-09-05 12:15:00',
                    '2005-09-05 12:14:00',
                    2,
                    7,
                    0,
                    8,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . ",
                    1
                )";
        $rows = $oDbh->exec($query);
        // Insert the variable values for the connection
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    10,
                    6,
                    3,
                    'test unique'
                )";
        $rows = $oDbh->exec($query);
        // Dedupe this hour
        $oStartDate = new Date('2005-09-05 14:00:00');
        $oEndDate   = new Date('2005-09-07 14:29:59');
        $dsa = $oMDMSF->factory("AdServer");
        $dsa->_dedupConversions($oStartDate, $oEndDate);
        // Ensure that both only the correct conversions has been deduped
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 6);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
            WHERE
                connection_status = " . MAX_CONNECTION_STATUS_APPROVED;
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 4);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
            WHERE
                connection_status = " . MAX_CONNECTION_STATUS_DUPLICATE;
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 2);
        $query = "
            SELECT
                connection_status,
                comments

            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
            WHERE
                data_intermediate_ad_connection_id = 1";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 2);
        $this->assertEqual($aRow['connection_status'], MAX_CONNECTION_STATUS_APPROVED);
        $this->assertEqual($aRow['comments'], '');
        $query = "
            SELECT
                connection_status,
                comments

            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
            WHERE
                data_intermediate_ad_connection_id = 2";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 2);
        $this->assertEqual($aRow['connection_status'], MAX_CONNECTION_STATUS_APPROVED);
        $this->assertEqual($aRow['comments'], '');
        $query = "
            SELECT
                connection_status,
                comments

            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
            WHERE
                data_intermediate_ad_connection_id = 3";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 2);
        $this->assertEqual($aRow['connection_status'], MAX_CONNECTION_STATUS_APPROVED);
        $this->assertEqual($aRow['comments'], '');
        $query = "
            SELECT
                connection_status,
                comments

            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
            WHERE
                data_intermediate_ad_connection_id = 4";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 2);
        $this->assertEqual($aRow['connection_status'], MAX_CONNECTION_STATUS_DUPLICATE);
        $this->assertEqual($aRow['comments'], 'Duplicate of connection ID 1');
        $query = "
            SELECT
                connection_status,
                comments

            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
            WHERE
                data_intermediate_ad_connection_id = 5";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 2);
        $this->assertEqual($aRow['connection_status'], MAX_CONNECTION_STATUS_DUPLICATE);
        $this->assertEqual($aRow['comments'], 'Duplicate of connection ID 4');
        $query = "
            SELECT
                connection_status,
                comments

            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
            WHERE
                data_intermediate_ad_connection_id = 6";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 2);
        $this->assertEqual($aRow['connection_status'], MAX_CONNECTION_STATUS_APPROVED);
        $this->assertEqual($aRow['comments'], '');

        TestEnv::rollbackTransaction();
    }

    /**
     * A method to perform basic testing of the _dedupConversions() method,
     * where de-duplication IS expected to occur.
     *
     * @TODO Not implemented...
     */
    function test_dedupConversionsBasicDuplciates()
    {

    }

    /**
     * Tests the summariseRequests() method.
     *
     * @TODO Not implemented...
     */
    function testSummariseRequests()
    {

    }

    /**
     * Tests the summariseImpressions() method.
     *
     * @TODO Not implemented...
     */
    function testSummariseImpressions()
    {

    }

    /**
     * Tests the summariseClicks() method.
     *
     * @TODO Not implemented...
     */
    function testSummariseClicks()
    {

    }

    /**
     * Tests the summariseConnections() method.
     */
    function testSummariseConnections()
    {
        $conf = &$GLOBALS['_MAX']['CONF'];
        $oDbh = &OA_DB::singleton();
        $conf['maintenance']['operationInterval'] = 30;
        $conf['modules']['Tracker'] = true;

        $oMDMSF = new OA_Dal_Maintenance_Statistics_Factory();
        $dsa = $oMDMSF->factory("AdServer");

        // Test with no data
        $start = new Date('2004-06-06 12:00:00');
        $end = new Date('2004-06-06 12:29:59');
        $rows = $dsa->summariseConnections($start, $end);
        $this->assertEqual($rows, 0);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                tmp_ad_connection";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 0);
        TestEnv::startTransaction();
        // Get the data for the tests
        include_once MAX_PATH . '/lib/max/Dal/data/TestOfStatisticsAdServermysql.php';
        // Insert some ads (banners), campaign trackers, ad
        // impressions, ad clicks, and tracker impressions
        $rows = $oDbh->exec(SUMMARISE_CONVERSIONS_BANNERS);
        $rows = $oDbh->exec(SUMMARISE_CONVERSIONS_CAMPAIGNS_TRACKERS);
        $rows = $oDbh->exec(SUMMARISE_CONVERSIONS_AD_IMPRESSIONS);
        $rows = $oDbh->exec(SUMMARISE_CONVERSIONS_AD_CLICKS);
        $rows = $oDbh->exec(SUMMARISE_CONVERSIONS_TRACKER_IMPRESSIONS);
        // Summarise where tracker impressions don't exist
        $start = new Date('2004-05-06 12:00:00');
        $end = new Date('2004-05-06 12:29:59');
        $rows = $dsa->summariseConnections($start, $end);
        $this->assertEqual($rows, 0);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                tmp_ad_connection";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 0);
        // Summarise where just one tracker impression exists
        $start = new Date('2004-05-06 12:30:00');
        $end = new Date('2004-05-06 12:59:59');
        $rows = $dsa->summariseConnections($start, $end);
        $this->assertEqual($rows, 2);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                tmp_ad_connection";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 2);
        $query = "
            SELECT
                *
            FROM
                tmp_ad_connection
            WHERE
                connection_action = 0";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['server_raw_tracker_impression_id'], 2);
        $this->assertEqual($aRow['connection_viewer_id'], 'aa');
        $this->assertEqual($aRow['connection_viewer_session_id'], 0);
        $this->assertEqual($aRow['connection_date_time'], '2004-05-06 12:34:56');
        $this->assertEqual($aRow['connection_ad_id'], 2);
        $this->assertEqual($aRow['connection_creative_id'], 0);
        $this->assertEqual($aRow['connection_zone_id'], 0);
        $this->assertEqual($aRow['connection_channel'], 'chan2');
        $this->assertEqual($aRow['connection_language'], 'en2');
        $this->assertEqual($aRow['connection_ip_address'], '127.0.0.2');
        $this->assertEqual($aRow['connection_host_name'], 'localhost2');
        $this->assertEqual($aRow['connection_country'], 'U2');
        $this->assertEqual($aRow['connection_https'], 0);
        $this->assertEqual($aRow['connection_domain'], 'domain2');
        $this->assertEqual($aRow['connection_page'], 'page2');
        $this->assertEqual($aRow['connection_query'], 'query2');
        $this->assertEqual($aRow['connection_referer'], 'referer2');
        $this->assertEqual($aRow['connection_search_term'], 'term2');
        $this->assertEqual($aRow['connection_user_agent'], 'agent2');
        $this->assertEqual($aRow['connection_os'], 'linux2');
        $this->assertEqual($aRow['connection_browser'], 'mozilla2');
        $this->assertEqual($aRow['connection_action'], 0);
        $this->assertEqual($aRow['connection_window'], 2592000);
        $this->assertEqual($aRow['connection_status'], 0);
        $this->assertEqual($aRow['inside_window'], 1);
        $this->assertEqual($aRow['latest'], 0);
        $query = "
            SELECT
                *
            FROM
                tmp_ad_connection
            WHERE
                connection_action = 1";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['server_raw_tracker_impression_id'], 2);
        $this->assertEqual($aRow['connection_viewer_id'], 'aa');
        $this->assertEqual($aRow['connection_viewer_session_id'], 0);
        $this->assertEqual($aRow['connection_date_time'], '2004-05-06 12:34:56');
        $this->assertEqual($aRow['connection_ad_id'], 2);
        $this->assertEqual($aRow['connection_creative_id'], 0);
        $this->assertEqual($aRow['connection_zone_id'], 0);
        $this->assertEqual($aRow['connection_channel'], 'chan2');
        $this->assertEqual($aRow['connection_language'], 'en2');
        $this->assertEqual($aRow['connection_ip_address'], '127.0.0.2');
        $this->assertEqual($aRow['connection_host_name'], 'localhost2');
        $this->assertEqual($aRow['connection_country'], 'U2');
        $this->assertEqual($aRow['connection_https'], 0);
        $this->assertEqual($aRow['connection_domain'], 'domain2');
        $this->assertEqual($aRow['connection_page'], 'page2');
        $this->assertEqual($aRow['connection_query'], 'query2');
        $this->assertEqual($aRow['connection_referer'], 'referer2');
        $this->assertEqual($aRow['connection_search_term'], 'term2');
        $this->assertEqual($aRow['connection_user_agent'], 'agent2');
        $this->assertEqual($aRow['connection_os'], 'linux2');
        $this->assertEqual($aRow['connection_browser'], 'mozilla2');
        $this->assertEqual($aRow['connection_action'], 1);
        $this->assertEqual($aRow['connection_window'], 2592000);
        $this->assertEqual($aRow['connection_status'], 0);
        $this->assertEqual($aRow['inside_window'], 1);
        $this->assertEqual($aRow['latest'], 0);
        // Drop the temporary table
        $dsa->tempTables->dropTable('tmp_ad_connection');
        // Summarise where the other connections are
        $start = new Date('2004-06-06 18:00:00');
        $end = new Date('2004-06-06 18:29:59');
        $rows = $dsa->summariseConnections($start, $end);
        $this->assertEqual($rows, 6);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                tmp_ad_connection";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 6);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                tmp_ad_connection
            WHERE
                inside_window = 1";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 4);
        $query = "
            SELECT
                *
            FROM
                tmp_ad_connection
            WHERE
                connection_action = 1
                AND connection_ad_id = 3";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['server_raw_tracker_impression_id'], 3);
        $this->assertEqual($aRow['connection_viewer_id'], 'aa');
        $this->assertEqual($aRow['connection_viewer_session_id'], 0);
        $this->assertEqual($aRow['connection_date_time'], '2004-06-06 18:22:11');
        $this->assertEqual($aRow['connection_ad_id'], 3);
        $this->assertEqual($aRow['connection_creative_id'], 0);
        $this->assertEqual($aRow['connection_zone_id'], 0);
        $this->assertEqual($aRow['connection_channel'], 'chan3');
        $this->assertEqual($aRow['connection_language'], 'en3');
        $this->assertEqual($aRow['connection_ip_address'], '127.0.0.3');
        $this->assertEqual($aRow['connection_host_name'], 'localhost3');
        $this->assertEqual($aRow['connection_country'], 'U3');
        $this->assertEqual($aRow['connection_https'], 0);
        $this->assertEqual($aRow['connection_domain'], 'domain3');
        $this->assertEqual($aRow['connection_page'], 'page3');
        $this->assertEqual($aRow['connection_query'], 'query3');
        $this->assertEqual($aRow['connection_referer'], 'referer3');
        $this->assertEqual($aRow['connection_search_term'], 'term3');
        $this->assertEqual($aRow['connection_user_agent'], 'agent3');
        $this->assertEqual($aRow['connection_os'], 'linux3');
        $this->assertEqual($aRow['connection_browser'], 'mozilla3');
        $this->assertEqual($aRow['connection_action'], 1);
        $this->assertEqual($aRow['connection_window'], 2592000);
        $this->assertEqual($aRow['connection_status'], MAX_CONNECTION_STATUS_APPROVED);
        $this->assertEqual($aRow['inside_window'], 1);
        $this->assertEqual($aRow['latest'], 0);
        $query = "
            SELECT
                *
            FROM
                tmp_ad_connection
            WHERE
                connection_action = 1
                AND connection_ad_id = 4";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['server_raw_tracker_impression_id'], 3);
        $this->assertEqual($aRow['connection_viewer_id'], 'aa');
        $this->assertEqual($aRow['connection_viewer_session_id'], 0);
        $this->assertEqual($aRow['connection_date_time'], '2004-06-06 18:22:12');
        $this->assertEqual($aRow['connection_ad_id'], 4);
        $this->assertEqual($aRow['connection_creative_id'], 0);
        $this->assertEqual($aRow['connection_zone_id'], 0);
        $this->assertEqual($aRow['connection_channel'], 'chan4');
        $this->assertEqual($aRow['connection_language'], 'en4');
        $this->assertEqual($aRow['connection_ip_address'], '127.0.0.4');
        $this->assertEqual($aRow['connection_host_name'], 'localhost4');
        $this->assertEqual($aRow['connection_country'], 'U4');
        $this->assertEqual($aRow['connection_https'], 0);
        $this->assertEqual($aRow['connection_domain'], 'domain4');
        $this->assertEqual($aRow['connection_page'], 'page4');
        $this->assertEqual($aRow['connection_query'], 'query4');
        $this->assertEqual($aRow['connection_referer'], 'referer4');
        $this->assertEqual($aRow['connection_search_term'], 'term4');
        $this->assertEqual($aRow['connection_user_agent'], 'agent4');
        $this->assertEqual($aRow['connection_os'], 'linux4');
        $this->assertEqual($aRow['connection_browser'], 'mozilla4');
        $this->assertEqual($aRow['connection_action'], 1);
        $this->assertEqual($aRow['connection_window'], 2592000);
        $this->assertEqual($aRow['connection_status'], MAX_CONNECTION_STATUS_APPROVED);
        $this->assertEqual($aRow['inside_window'], 1);
        $this->assertEqual($aRow['latest'], 0);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                tmp_ad_connection";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 6);
        $query = "
            SELECT
                *
            FROM
                tmp_ad_connection
            WHERE
                connection_action = 0
                AND connection_ad_id = 3";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['server_raw_tracker_impression_id'], 3);
        $this->assertEqual($aRow['connection_viewer_id'], 'aa');
        $this->assertEqual($aRow['connection_viewer_session_id'], 0);
        $this->assertEqual($aRow['connection_date_time'], '2004-06-06 18:22:11');
        $this->assertEqual($aRow['connection_ad_id'], 3);
        $this->assertEqual($aRow['connection_creative_id'], 0);
        $this->assertEqual($aRow['connection_zone_id'], 0);
        $this->assertEqual($aRow['connection_channel'], 'chan3');
        $this->assertEqual($aRow['connection_language'], 'en3');
        $this->assertEqual($aRow['connection_ip_address'], '127.0.0.3');
        $this->assertEqual($aRow['connection_host_name'], 'localhost3');
        $this->assertEqual($aRow['connection_country'], 'U3');
        $this->assertEqual($aRow['connection_https'], 0);
        $this->assertEqual($aRow['connection_domain'], 'domain3');
        $this->assertEqual($aRow['connection_page'], 'page3');
        $this->assertEqual($aRow['connection_query'], 'query3');
        $this->assertEqual($aRow['connection_referer'], 'referer3');
        $this->assertEqual($aRow['connection_search_term'], 'term3');
        $this->assertEqual($aRow['connection_user_agent'], 'agent3');
        $this->assertEqual($aRow['connection_os'], 'linux3');
        $this->assertEqual($aRow['connection_browser'], 'mozilla3');
        $this->assertEqual($aRow['connection_action'], 0);
        $this->assertEqual($aRow['connection_window'], 2592000);
        $this->assertEqual($aRow['connection_status'], MAX_CONNECTION_STATUS_APPROVED);
        $this->assertEqual($aRow['inside_window'], 1);
        $this->assertEqual($aRow['latest'], 0);
        $query = "
            SELECT
                *
            FROM
                tmp_ad_connection
            WHERE
                connection_action = 0
                AND connection_ad_id = 4";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['server_raw_tracker_impression_id'], 3);
        $this->assertEqual($aRow['connection_viewer_id'], 'aa');
        $this->assertEqual($aRow['connection_viewer_session_id'], 0);
        $this->assertEqual($aRow['connection_date_time'], '2004-06-06 18:22:12');
        $this->assertEqual($aRow['connection_ad_id'], 4);
        $this->assertEqual($aRow['connection_creative_id'], 0);
        $this->assertEqual($aRow['connection_zone_id'], 0);
        $this->assertEqual($aRow['connection_channel'], 'chan4');
        $this->assertEqual($aRow['connection_language'], 'en4');
        $this->assertEqual($aRow['connection_ip_address'], '127.0.0.4');
        $this->assertEqual($aRow['connection_host_name'], 'localhost4');
        $this->assertEqual($aRow['connection_country'], 'U4');
        $this->assertEqual($aRow['connection_https'], 0);
        $this->assertEqual($aRow['connection_domain'], 'domain4');
        $this->assertEqual($aRow['connection_page'], 'page4');
        $this->assertEqual($aRow['connection_query'], 'query4');
        $this->assertEqual($aRow['connection_referer'], 'referer4');
        $this->assertEqual($aRow['connection_search_term'], 'term4');
        $this->assertEqual($aRow['connection_user_agent'], 'agent4');
        $this->assertEqual($aRow['connection_os'], 'linux4');
        $this->assertEqual($aRow['connection_browser'], 'mozilla4');
        $this->assertEqual($aRow['connection_action'], 0);
        $this->assertEqual($aRow['connection_window'], 2592000);
        $this->assertEqual($aRow['connection_status'], MAX_CONNECTION_STATUS_APPROVED);
        $this->assertEqual($aRow['inside_window'], 1);
        $this->assertEqual($aRow['latest'], 0);
        // Drop the temporary table
        $dsa->tempTables->dropTable('tmp_ad_connection');
        // Test with the data present, but the tracker module uninstalled
        $conf['modules']['Tracker'] = false;
        $dsa = $oMDMSF->factory("AdServer");
        // Summarise where the other connections are
        $start = new Date('2004-06-06 18:00:00');
        $end = new Date('2004-06-06 18:29:59');
        $rows = $dsa->summariseConnections($start, $end);
        $this->assertEqual($rows, 0);

        TestEnv::restoreEnv();
    }

    /**
     * Tests the saveIntermediate() method.
     *
     * Requirements:
     * Test 1: Test with no data.
     * Test 2: Test with ad requests only.
     * Test 3: Test with ad impressions only.
     * Test 4: Test with ad clicks only.
     * Test 5: Test with ad requests, impressions and clicks.
     * Test 6: Test with tracker impressions only, where there are no
     *         associated variable values.
     * Test 7: Test with tracker impressions only, where there is an
     *         associated (non-baseket value) variable value that has NOT
     *         been collected.
     * Test 8: Test with tracker impressions only, where there is an
     *         associated (non-baseket value) variable value that HAS
     *         been collected.
     * Test 9: Test with tracker impressions only, where there is an
     *         associated (baseket value) variable value that has NOT
     *         been collected.
     * Test 10: Test with tracker impressions only, where there is an
     *          associated (baseket value) variable value that HAS
     *          been collected.
     * Test 11: Test with a combination of ad requests, impressions, clicks,
     *          and tracker impressions, with combinations of different
     *          types of variable values attached.
     */
    function testSaveIntermediate()
    {
        $conf = &$GLOBALS['_MAX']['CONF'];
        include_once MAX_PATH . '/lib/max/Dal/data/TestOfStatisticsAdServermysql.php';

        // Test 1
        $conf['maintenance']['operationInterval'] = 30;
        $conf['modules']['Tracker'] = true;
        $oDbh = &OA_DB::singleton();

        $oMDMSF = new OA_Dal_Maintenance_Statistics_Factory();
        $dsa = $oMDMSF->factory("AdServer");

        $dsa->tempTables->createTable('tmp_ad_request');
        $dsa->tempTables->createTable('tmp_ad_impression');
        $dsa->tempTables->createTable('tmp_ad_click');
        $dsa->tempTables->createTable('tmp_ad_connection');
        $start = new Date('2004-06-06 12:00:00');
        $end = new Date('2004-06-06 12:29:59');
        $aTypes = array(
            'types' => array(
                0 => 'request',
                1 => 'impression',
                2 => 'click'
            ),
            'connections' => array(
                1 => MAX_CONNECTION_AD_IMPRESSION,
                2 => MAX_CONNECTION_AD_CLICK
            )
        );
        $dsa->saveIntermediate($start, $end, $aTypes);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 0);
        $aRow = $oDbh->queryRow($query);

        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 0);
        TestEnv::restoreEnv();

        // Test 2
        $conf['maintenance']['operationInterval'] = 30;
        $conf['modules']['Tracker'] = true;
        $oDbh = &OA_DB::singleton();
        $dsa = $oMDMSF->factory("AdServer");
        $dsa->tempTables->createTable('tmp_ad_request');
        $dsa->tempTables->createTable('tmp_ad_impression');
        $dsa->tempTables->createTable('tmp_ad_click');
        $dsa->tempTables->createTable('tmp_ad_connection');
        $rows = $oDbh->exec(SAVE_INTERMEDIATE_AD_REQUESTS);
        $start = new Date('2004-06-06 18:00:00');
        $end = new Date('2004-06-06 18:29:59');
        $dsa->saveIntermediate($start, $end, $aTypes);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 2);
        $query = "
            SELECT
                *
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad']}
            WHERE
                ad_id = 1";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['day'], '2004-06-06');
        $this->assertEqual($aRow['hour'], 18);
        $this->assertEqual($aRow['operation_interval'], 30);
        $this->assertEqual($aRow['operation_interval_id'], 36);
        $this->assertEqual($aRow['interval_start'], '2004-06-06 18:00:00');
        $this->assertEqual($aRow['interval_end'], '2004-06-06 18:29:59');
        $this->assertEqual($aRow['ad_id'], 1);
        $this->assertEqual($aRow['creative_id'], 1);
        $this->assertEqual($aRow['zone_id'], 1);
        $this->assertEqual($aRow['requests'], 1);
        $this->assertEqual($aRow['impressions'], 0);
        $this->assertEqual($aRow['clicks'], 0);
        $this->assertEqual($aRow['conversions'], 0);
        $this->assertEqual($aRow['total_basket_value'], 0);
        $query = "
            SELECT
                *
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad']}
            WHERE
                ad_id = 2";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['day'], '2004-06-06');
        $this->assertEqual($aRow['hour'], 18);
        $this->assertEqual($aRow['operation_interval'], 30);
        $this->assertEqual($aRow['operation_interval_id'], 36);
        $this->assertEqual($aRow['interval_start'], '2004-06-06 18:00:00');
        $this->assertEqual($aRow['interval_end'], '2004-06-06 18:29:59');
        $this->assertEqual($aRow['ad_id'], 2);
        $this->assertEqual($aRow['creative_id'], 2);
        $this->assertEqual($aRow['zone_id'], 2);
        $this->assertEqual($aRow['requests'], 2);
        $this->assertEqual($aRow['impressions'], 0);
        $this->assertEqual($aRow['clicks'], 0);
        $this->assertEqual($aRow['conversions'], 0);
        $this->assertEqual($aRow['total_basket_value'], 0);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 0);
        TestEnv::restoreEnv();

        // Test 3
        $conf['maintenance']['operationInterval'] = 30;
        $conf['modules']['Tracker'] = true;
        $oDbh = &OA_DB::singleton();
        $dsa = $oMDMSF->factory("AdServer");
        $dsa->tempTables->createTable('tmp_ad_request');
        $dsa->tempTables->createTable('tmp_ad_impression');
        $dsa->tempTables->createTable('tmp_ad_click');
        $dsa->tempTables->createTable('tmp_ad_connection');
        $rows = $oDbh->exec(SAVE_INTERMEDIATE_AD_IMPRESSIONS);
        $start = new Date('2004-06-06 18:00:00');
        $end = new Date('2004-06-06 18:29:59');
        $dsa->saveIntermediate($start, $end, $aTypes);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 2);
        $query = "
            SELECT
                *
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad']}
            WHERE
                ad_id = 1";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['day'], '2004-06-06');
        $this->assertEqual($aRow['hour'], 18);
        $this->assertEqual($aRow['operation_interval'], 30);
        $this->assertEqual($aRow['operation_interval_id'], 36);
        $this->assertEqual($aRow['interval_start'], '2004-06-06 18:00:00');
        $this->assertEqual($aRow['interval_end'], '2004-06-06 18:29:59');
        $this->assertEqual($aRow['ad_id'], 1);
        $this->assertEqual($aRow['creative_id'], 1);
        $this->assertEqual($aRow['zone_id'], 1);
        $this->assertEqual($aRow['requests'], 0);
        $this->assertEqual($aRow['impressions'], 1);
        $this->assertEqual($aRow['clicks'], 0);
        $this->assertEqual($aRow['conversions'], 0);
        $this->assertEqual($aRow['total_basket_value'], 0);
        $query = "
            SELECT
                *
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad']}
            WHERE
                ad_id = 2";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['day'], '2004-06-06');
        $this->assertEqual($aRow['hour'], 18);
        $this->assertEqual($aRow['operation_interval'], 30);
        $this->assertEqual($aRow['operation_interval_id'], 36);
        $this->assertEqual($aRow['interval_start'], '2004-06-06 18:00:00');
        $this->assertEqual($aRow['interval_end'], '2004-06-06 18:29:59');
        $this->assertEqual($aRow['ad_id'], 2);
        $this->assertEqual($aRow['creative_id'], 2);
        $this->assertEqual($aRow['zone_id'], 2);
        $this->assertEqual($aRow['requests'], 0);
        $this->assertEqual($aRow['impressions'], 2);
        $this->assertEqual($aRow['clicks'], 0);
        $this->assertEqual($aRow['conversions'], 0);
        $this->assertEqual($aRow['total_basket_value'], 0);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 0);
        TestEnv::restoreEnv();

        // Test 4
        $conf['maintenance']['operationInterval'] = 30;
        $conf['modules']['Tracker'] = true;
        $oDbh = &OA_DB::singleton();
        $dsa = $oMDMSF->factory("AdServer");
        $dsa->tempTables->createTable('tmp_ad_request');
        $dsa->tempTables->createTable('tmp_ad_impression');
        $dsa->tempTables->createTable('tmp_ad_click');
        $dsa->tempTables->createTable('tmp_ad_connection');
        $rows = $oDbh->exec(SAVE_INTERMEDIATE_AD_CLICKS);
        $start = new Date('2004-06-06 18:00:00');
        $end = new Date('2004-06-06 18:29:59');
        $dsa->saveIntermediate($start, $end, $aTypes);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 3);
        $query = "
            SELECT
                *
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad']}
            WHERE
                ad_id = 1";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['day'], '2004-06-06');
        $this->assertEqual($aRow['hour'], 18);
        $this->assertEqual($aRow['operation_interval'], 30);
        $this->assertEqual($aRow['operation_interval_id'], 36);
        $this->assertEqual($aRow['interval_start'], '2004-06-06 18:00:00');
        $this->assertEqual($aRow['interval_end'], '2004-06-06 18:29:59');
        $this->assertEqual($aRow['ad_id'], 1);
        $this->assertEqual($aRow['creative_id'], 1);
        $this->assertEqual($aRow['zone_id'], 1);
        $this->assertEqual($aRow['requests'], 0);
        $this->assertEqual($aRow['impressions'], 0);
        $this->assertEqual($aRow['clicks'], 1);
        $this->assertEqual($aRow['conversions'], 0);
        $this->assertEqual($aRow['total_basket_value'], 0);
        $query = "
            SELECT
                *
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad']}
            WHERE
                ad_id = 2";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['day'], '2004-06-06');
        $this->assertEqual($aRow['hour'], 18);
        $this->assertEqual($aRow['operation_interval'], 30);
        $this->assertEqual($aRow['operation_interval_id'], 36);
        $this->assertEqual($aRow['interval_start'], '2004-06-06 18:00:00');
        $this->assertEqual($aRow['interval_end'], '2004-06-06 18:29:59');
        $this->assertEqual($aRow['ad_id'], 2);
        $this->assertEqual($aRow['creative_id'], 2);
        $this->assertEqual($aRow['zone_id'], 2);
        $this->assertEqual($aRow['requests'], 0);
        $this->assertEqual($aRow['impressions'], 0);
        $this->assertEqual($aRow['clicks'], 2);
        $this->assertEqual($aRow['conversions'], 0);
        $this->assertEqual($aRow['total_basket_value'], 0);
        $query = "
            SELECT
                *
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad']}
            WHERE
                ad_id = 3";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['day'], '2004-06-06');
        $this->assertEqual($aRow['hour'], 18);
        $this->assertEqual($aRow['operation_interval'], 30);
        $this->assertEqual($aRow['operation_interval_id'], 36);
        $this->assertEqual($aRow['interval_start'], '2004-06-06 18:00:00');
        $this->assertEqual($aRow['interval_end'], '2004-06-06 18:29:59');
        $this->assertEqual($aRow['ad_id'], 3);
        $this->assertEqual($aRow['creative_id'], 3);
        $this->assertEqual($aRow['zone_id'], 3);
        $this->assertEqual($aRow['requests'], 0);
        $this->assertEqual($aRow['impressions'], 0);
        $this->assertEqual($aRow['clicks'], 1);
        $this->assertEqual($aRow['conversions'], 0);
        $this->assertEqual($aRow['total_basket_value'], 0);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 0);
        TestEnv::restoreEnv();

        // Test 5
        $conf['maintenance']['operationInterval'] = 30;
        $conf['modules']['Tracker'] = true;
        $oDbh = &OA_DB::singleton();
        $dsa = $oMDMSF->factory("AdServer");
        $dsa->tempTables->createTable('tmp_ad_request');
        $dsa->tempTables->createTable('tmp_ad_impression');
        $dsa->tempTables->createTable('tmp_ad_click');
        $dsa->tempTables->createTable('tmp_ad_connection');
        $rows = $oDbh->exec(SAVE_INTERMEDIATE_AD_REQUESTS);
        $rows = $oDbh->exec(SAVE_INTERMEDIATE_AD_IMPRESSIONS);
        $rows = $oDbh->exec(SAVE_INTERMEDIATE_AD_CLICKS);
        $start = new Date('2004-06-06 18:00:00');
        $end = new Date('2004-06-06 18:29:59');
        $dsa->saveIntermediate($start, $end, $aTypes);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 3);
        $query = "
            SELECT
                *
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad']}
            WHERE
                ad_id = 1";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['day'], '2004-06-06');
        $this->assertEqual($aRow['hour'], 18);
        $this->assertEqual($aRow['operation_interval'], 30);
        $this->assertEqual($aRow['operation_interval_id'], 36);
        $this->assertEqual($aRow['interval_start'], '2004-06-06 18:00:00');
        $this->assertEqual($aRow['interval_end'], '2004-06-06 18:29:59');
        $this->assertEqual($aRow['ad_id'], 1);
        $this->assertEqual($aRow['creative_id'], 1);
        $this->assertEqual($aRow['zone_id'], 1);
        $this->assertEqual($aRow['requests'], 1);
        $this->assertEqual($aRow['impressions'], 1);
        $this->assertEqual($aRow['clicks'], 1);
        $this->assertEqual($aRow['conversions'], 0);
        $this->assertEqual($aRow['total_basket_value'], 0);
        $query = "
            SELECT
                *
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad']}
            WHERE
                ad_id = 2";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['day'], '2004-06-06');
        $this->assertEqual($aRow['hour'], 18);
        $this->assertEqual($aRow['operation_interval'], 30);
        $this->assertEqual($aRow['operation_interval_id'], 36);
        $this->assertEqual($aRow['interval_start'], '2004-06-06 18:00:00');
        $this->assertEqual($aRow['interval_end'], '2004-06-06 18:29:59');
        $this->assertEqual($aRow['ad_id'], 2);
        $this->assertEqual($aRow['creative_id'], 2);
        $this->assertEqual($aRow['zone_id'], 2);
        $this->assertEqual($aRow['requests'], 2);
        $this->assertEqual($aRow['impressions'], 2);
        $this->assertEqual($aRow['clicks'], 2);
        $this->assertEqual($aRow['conversions'], 0);
        $this->assertEqual($aRow['total_basket_value'], 0);
        $query = "
            SELECT
                *
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad']}
            WHERE
                ad_id = 3";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['day'], '2004-06-06');
        $this->assertEqual($aRow['hour'], 18);
        $this->assertEqual($aRow['operation_interval'], 30);
        $this->assertEqual($aRow['operation_interval_id'], 36);
        $this->assertEqual($aRow['interval_start'], '2004-06-06 18:00:00');
        $this->assertEqual($aRow['interval_end'], '2004-06-06 18:29:59');
        $this->assertEqual($aRow['ad_id'], 3);
        $this->assertEqual($aRow['creative_id'], 3);
        $this->assertEqual($aRow['zone_id'], 3);
        $this->assertEqual($aRow['requests'], 0);
        $this->assertEqual($aRow['impressions'], 0);
        $this->assertEqual($aRow['clicks'], 1);
        $this->assertEqual($aRow['conversions'], 0);
        $this->assertEqual($aRow['total_basket_value'], 0);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 0);
        TestEnv::restoreEnv();

        // Test 6
        $conf['maintenance']['operationInterval'] = 30;
        $conf['modules']['Tracker'] = true;
        $oDbh = &OA_DB::singleton();
        $dsa = $oMDMSF->factory("AdServer");
        $dsa->tempTables->createTable('tmp_ad_request');
        $dsa->tempTables->createTable('tmp_ad_impression');
        $dsa->tempTables->createTable('tmp_ad_click');
        $dsa->tempTables->createTable('tmp_ad_connection');
        $rows = $oDbh->exec(SAVE_INTERMEDIATE_TRACKER_IMPRESSIONS_TEST_6);
        $rows = $oDbh->exec(SAVE_INTERMEDIATE_CONNECTIONS_TEST_6);
        $start = new Date('2004-06-06 18:00:00');
        $end = new Date('2004-06-06 18:29:59');
        $dsa->saveIntermediate($start, $end, $aTypes);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                *
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
            WHERE
                server_raw_tracker_impression_id = 2
                AND server_raw_ip = '127.0.0.1'";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['server_raw_tracker_impression_id'], 2);
        $this->assertEqual($aRow['server_raw_ip'], '127.0.0.1');
        $this->assertEqual($aRow['viewer_id'], 'aa');
        $this->assertEqual($aRow['viewer_session_id'], 1);
        $this->assertEqual($aRow['tracker_date_time'], '2004-06-06 18:10:30');
        $this->assertEqual($aRow['connection_date_time'], '2004-06-06 18:00:00');
        $this->assertEqual($aRow['tracker_id'], 1);
        $this->assertEqual($aRow['ad_id'], 1);
        $this->assertEqual($aRow['creative_id'], 1);
        $this->assertEqual($aRow['zone_id'], 1);
        $this->assertEqual($aRow['tracker_channel'], 'tchan1');
        $this->assertEqual($aRow['connection_channel'], 'chan1');
        $this->assertEqual($aRow['tracker_language'], 'ten1');
        $this->assertEqual($aRow['connection_language'], 'en1');
        $this->assertEqual($aRow['tracker_ip_address'], 't127.0.0.1');
        $this->assertEqual($aRow['connection_ip_address'], '127.0.0.1');
        $this->assertEqual($aRow['tracker_host_name'], 'thost1');
        $this->assertEqual($aRow['connection_host_name'], 'host1');
        $this->assertEqual($aRow['tracker_country'], 'T1');
        $this->assertEqual($aRow['connection_country'], 'U1');
        $this->assertEqual($aRow['tracker_https'], 1);
        $this->assertEqual($aRow['connection_https'], 0);
        $this->assertEqual($aRow['tracker_domain'], 'tdomain1');
        $this->assertEqual($aRow['connection_domain'], 'domain1');
        $this->assertEqual($aRow['tracker_page'], 'tpage1');
        $this->assertEqual($aRow['connection_page'], 'page1');
        $this->assertEqual($aRow['tracker_query'], 'tquery1');
        $this->assertEqual($aRow['connection_query'], 'query1');
        $this->assertEqual($aRow['tracker_referer'], 'tref1');
        $this->assertEqual($aRow['connection_referer'], 'ref1');
        $this->assertEqual($aRow['tracker_search_term'], 'tterm1');
        $this->assertEqual($aRow['connection_search_term'], 'term1');
        $this->assertEqual($aRow['tracker_user_agent'], 'tagent1');
        $this->assertEqual($aRow['connection_user_agent'], 'agent1');
        $this->assertEqual($aRow['tracker_os'], 'tlinux1');
        $this->assertEqual($aRow['connection_os'], 'linux1');
        $this->assertEqual($aRow['tracker_browser'], 'tmozilla1');
        $this->assertEqual($aRow['connection_browser'], 'mozilla1');
        $this->assertEqual($aRow['connection_action'], 1);
        $this->assertEqual($aRow['connection_window'], 259200);
        $this->assertEqual($aRow['connection_status'], MAX_CONNECTION_STATUS_APPROVED);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                *
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad']}
            WHERE
                ad_id = 1";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['day'], '2004-06-06');
        $this->assertEqual($aRow['hour'], 18);
        $this->assertEqual($aRow['operation_interval'], 30);
        $this->assertEqual($aRow['operation_interval_id'], 36);
        $this->assertEqual($aRow['interval_start'], '2004-06-06 18:00:00');
        $this->assertEqual($aRow['interval_end'], '2004-06-06 18:29:59');
        $this->assertEqual($aRow['ad_id'], 1);
        $this->assertEqual($aRow['creative_id'], 1);
        $this->assertEqual($aRow['zone_id'], 1);
        $this->assertEqual($aRow['requests'], 0);
        $this->assertEqual($aRow['impressions'], 0);
        $this->assertEqual($aRow['clicks'], 0);
        $this->assertEqual($aRow['conversions'], 1);
        $this->assertEqual($aRow['total_basket_value'], 0);
        TestEnv::restoreEnv();

        // Test 7
        $conf['maintenance']['operationInterval'] = 30;
        $conf['modules']['Tracker'] = true;
        $oDbh = &OA_DB::singleton();
        $dsa = $oMDMSF->factory("AdServer");
        $dsa->tempTables->createTable('tmp_ad_request');
        $dsa->tempTables->createTable('tmp_ad_impression');
        $dsa->tempTables->createTable('tmp_ad_click');
        $dsa->tempTables->createTable('tmp_ad_connection');
        $rows = $oDbh->exec(SAVE_INTERMEDIATE_VARIABLES_TEST_7);
        $rows = $oDbh->exec(SAVE_INTERMEDIATE_TRACKER_IMPRESSIONS_TEST_7);
        $rows = $oDbh->exec(SAVE_INTERMEDIATE_CONNECTIONS_TEST_7);
        $start = new Date('2004-06-06 18:00:00');
        $end = new Date('2004-06-06 18:29:59');
        $dsa->saveIntermediate($start, $end, $aTypes);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                *
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
            WHERE
                server_raw_tracker_impression_id = 2
                AND server_raw_ip = '127.0.0.1'";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['server_raw_tracker_impression_id'], 2);
        $this->assertEqual($aRow['server_raw_ip'], '127.0.0.1');
        $this->assertEqual($aRow['viewer_id'], 'aa');
        $this->assertEqual($aRow['viewer_session_id'], 1);
        $this->assertEqual($aRow['tracker_date_time'], '2004-06-06 18:10:30');
        $this->assertEqual($aRow['connection_date_time'], '2004-06-06 18:00:00');
        $this->assertEqual($aRow['tracker_id'], 1);
        $this->assertEqual($aRow['ad_id'], 1);
        $this->assertEqual($aRow['creative_id'], 1);
        $this->assertEqual($aRow['zone_id'], 1);
        $this->assertEqual($aRow['tracker_channel'], 'tchan1');
        $this->assertEqual($aRow['connection_channel'], 'chan1');
        $this->assertEqual($aRow['tracker_language'], 'ten1');
        $this->assertEqual($aRow['connection_language'], 'en1');
        $this->assertEqual($aRow['tracker_ip_address'], 't127.0.0.1');
        $this->assertEqual($aRow['connection_ip_address'], '127.0.0.1');
        $this->assertEqual($aRow['tracker_host_name'], 'thost1');
        $this->assertEqual($aRow['connection_host_name'], 'host1');
        $this->assertEqual($aRow['tracker_country'], 'T1');
        $this->assertEqual($aRow['connection_country'], 'U1');
        $this->assertEqual($aRow['tracker_https'], 1);
        $this->assertEqual($aRow['connection_https'], 0);
        $this->assertEqual($aRow['tracker_domain'], 'tdomain1');
        $this->assertEqual($aRow['connection_domain'], 'domain1');
        $this->assertEqual($aRow['tracker_page'], 'tpage1');
        $this->assertEqual($aRow['connection_page'], 'page1');
        $this->assertEqual($aRow['tracker_query'], 'tquery1');
        $this->assertEqual($aRow['connection_query'], 'query1');
        $this->assertEqual($aRow['tracker_referer'], 'tref1');
        $this->assertEqual($aRow['connection_referer'], 'ref1');
        $this->assertEqual($aRow['tracker_search_term'], 'tterm1');
        $this->assertEqual($aRow['connection_search_term'], 'term1');
        $this->assertEqual($aRow['tracker_user_agent'], 'tagent1');
        $this->assertEqual($aRow['connection_user_agent'], 'agent1');
        $this->assertEqual($aRow['tracker_os'], 'tlinux1');
        $this->assertEqual($aRow['connection_os'], 'linux1');
        $this->assertEqual($aRow['tracker_browser'], 'tmozilla1');
        $this->assertEqual($aRow['connection_browser'], 'mozilla1');
        $this->assertEqual($aRow['connection_action'], 1);
        $this->assertEqual($aRow['connection_window'], 259200);
        $this->assertEqual($aRow['connection_status'], MAX_CONNECTION_STATUS_APPROVED);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                *
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad']}
            WHERE
                ad_id = 1";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['day'], '2004-06-06');
        $this->assertEqual($aRow['hour'], 18);
        $this->assertEqual($aRow['operation_interval'], 30);
        $this->assertEqual($aRow['operation_interval_id'], 36);
        $this->assertEqual($aRow['interval_start'], '2004-06-06 18:00:00');
        $this->assertEqual($aRow['interval_end'], '2004-06-06 18:29:59');
        $this->assertEqual($aRow['ad_id'], 1);
        $this->assertEqual($aRow['creative_id'], 1);
        $this->assertEqual($aRow['zone_id'], 1);
        $this->assertEqual($aRow['requests'], 0);
        $this->assertEqual($aRow['impressions'], 0);
        $this->assertEqual($aRow['clicks'], 0);
        $this->assertEqual($aRow['conversions'], 1);
        $this->assertEqual($aRow['total_basket_value'], 0);
        TestEnv::restoreEnv();

        // Test 8
        $conf['maintenance']['operationInterval'] = 30;
        $conf['modules']['Tracker'] = true;
        $oDbh = &OA_DB::singleton();
        $dsa = $oMDMSF->factory("AdServer");
        $dsa->tempTables->createTable('tmp_ad_request');
        $dsa->tempTables->createTable('tmp_ad_impression');
        $dsa->tempTables->createTable('tmp_ad_click');
        $dsa->tempTables->createTable('tmp_ad_connection');
        $rows = $oDbh->exec(SAVE_INTERMEDIATE_VARIABLES_TEST_8);
        $rows = $oDbh->exec(SAVE_INTERMEDIATE_TRACKER_IMPRESSIONS_TEST_8);
        $rows = $oDbh->exec(SAVE_INTERMEDIATE_TRACKER_VARIABLE_VALUES_TEST_8);
        $rows = $oDbh->exec(SAVE_INTERMEDIATE_CONNECTIONS_TEST_8);
        $start = new Date('2004-06-06 18:00:00');
        $end = new Date('2004-06-06 18:29:59');
        $dsa->saveIntermediate($start, $end, $aTypes);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                *
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
            WHERE
                server_raw_tracker_impression_id = 2
                AND server_raw_ip = '127.0.0.1'";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['server_raw_tracker_impression_id'], 2);
        $this->assertEqual($aRow['server_raw_ip'], '127.0.0.1');
        $this->assertEqual($aRow['viewer_id'], 'aa');
        $this->assertEqual($aRow['viewer_session_id'], 1);
        $this->assertEqual($aRow['tracker_date_time'], '2004-06-06 18:10:30');
        $this->assertEqual($aRow['connection_date_time'], '2004-06-06 18:00:00');
        $this->assertEqual($aRow['tracker_id'], 1);
        $this->assertEqual($aRow['ad_id'], 1);
        $this->assertEqual($aRow['creative_id'], 1);
        $this->assertEqual($aRow['zone_id'], 1);
        $this->assertEqual($aRow['tracker_channel'], 'tchan1');
        $this->assertEqual($aRow['connection_channel'], 'chan1');
        $this->assertEqual($aRow['tracker_language'], 'ten1');
        $this->assertEqual($aRow['connection_language'], 'en1');
        $this->assertEqual($aRow['tracker_ip_address'], 't127.0.0.1');
        $this->assertEqual($aRow['connection_ip_address'], '127.0.0.1');
        $this->assertEqual($aRow['tracker_host_name'], 'thost1');
        $this->assertEqual($aRow['connection_host_name'], 'host1');
        $this->assertEqual($aRow['tracker_country'], 'T1');
        $this->assertEqual($aRow['connection_country'], 'U1');
        $this->assertEqual($aRow['tracker_https'], 1);
        $this->assertEqual($aRow['connection_https'], 0);
        $this->assertEqual($aRow['tracker_domain'], 'tdomain1');
        $this->assertEqual($aRow['connection_domain'], 'domain1');
        $this->assertEqual($aRow['tracker_page'], 'tpage1');
        $this->assertEqual($aRow['connection_page'], 'page1');
        $this->assertEqual($aRow['tracker_query'], 'tquery1');
        $this->assertEqual($aRow['connection_query'], 'query1');
        $this->assertEqual($aRow['tracker_referer'], 'tref1');
        $this->assertEqual($aRow['connection_referer'], 'ref1');
        $this->assertEqual($aRow['tracker_search_term'], 'tterm1');
        $this->assertEqual($aRow['connection_search_term'], 'term1');
        $this->assertEqual($aRow['tracker_user_agent'], 'tagent1');
        $this->assertEqual($aRow['connection_user_agent'], 'agent1');
        $this->assertEqual($aRow['tracker_os'], 'tlinux1');
        $this->assertEqual($aRow['connection_os'], 'linux1');
        $this->assertEqual($aRow['tracker_browser'], 'tmozilla1');
        $this->assertEqual($aRow['connection_browser'], 'mozilla1');
        $this->assertEqual($aRow['connection_action'], 1);
        $this->assertEqual($aRow['connection_window'], 259200);
        $this->assertEqual($aRow['connection_status'], MAX_CONNECTION_STATUS_APPROVED);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                value
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}
            WHERE
                tracker_variable_id = 1";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['value'], 2);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                *
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad']}
            WHERE
                ad_id = 1";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['day'], '2004-06-06');
        $this->assertEqual($aRow['hour'], 18);
        $this->assertEqual($aRow['operation_interval'], 30);
        $this->assertEqual($aRow['operation_interval_id'], 36);
        $this->assertEqual($aRow['interval_start'], '2004-06-06 18:00:00');
        $this->assertEqual($aRow['interval_end'], '2004-06-06 18:29:59');
        $this->assertEqual($aRow['ad_id'], 1);
        $this->assertEqual($aRow['creative_id'], 1);
        $this->assertEqual($aRow['zone_id'], 1);
        $this->assertEqual($aRow['requests'], 0);
        $this->assertEqual($aRow['impressions'], 0);
        $this->assertEqual($aRow['clicks'], 0);
        $this->assertEqual($aRow['conversions'], 1);
        $this->assertEqual($aRow['total_basket_value'], 0);
        TestEnv::restoreEnv();

        // Test 9
        $conf['maintenance']['operationInterval'] = 30;
        $conf['modules']['Tracker'] = true;
        $oDbh = &OA_DB::singleton();
        $dsa = $oMDMSF->factory("AdServer");
        $dsa->tempTables->createTable('tmp_ad_request');
        $dsa->tempTables->createTable('tmp_ad_impression');
        $dsa->tempTables->createTable('tmp_ad_click');
        $dsa->tempTables->createTable('tmp_ad_connection');
        $rows = $oDbh->exec(SAVE_INTERMEDIATE_VARIABLES_TEST_9);
        $rows = $oDbh->exec(SAVE_INTERMEDIATE_TRACKER_IMPRESSIONS_TEST_9);
        $rows = $oDbh->exec(SAVE_INTERMEDIATE_CONNECTIONS_TEST_9);
        $start = new Date('2004-06-06 18:00:00');
        $end = new Date('2004-06-06 18:29:59');
        $dsa->saveIntermediate($start, $end, $aTypes);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                *
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
            WHERE
                server_raw_tracker_impression_id = 2
                AND server_raw_ip = '127.0.0.1'";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['server_raw_tracker_impression_id'], 2);
        $this->assertEqual($aRow['server_raw_ip'], '127.0.0.1');
        $this->assertEqual($aRow['viewer_id'], 'aa');
        $this->assertEqual($aRow['viewer_session_id'], 1);
        $this->assertEqual($aRow['tracker_date_time'], '2004-06-06 18:10:30');
        $this->assertEqual($aRow['connection_date_time'], '2004-06-06 18:00:00');
        $this->assertEqual($aRow['tracker_id'], 1);
        $this->assertEqual($aRow['ad_id'], 1);
        $this->assertEqual($aRow['creative_id'], 1);
        $this->assertEqual($aRow['zone_id'], 1);
        $this->assertEqual($aRow['tracker_channel'], 'tchan1');
        $this->assertEqual($aRow['connection_channel'], 'chan1');
        $this->assertEqual($aRow['tracker_language'], 'ten1');
        $this->assertEqual($aRow['connection_language'], 'en1');
        $this->assertEqual($aRow['tracker_ip_address'], 't127.0.0.1');
        $this->assertEqual($aRow['connection_ip_address'], '127.0.0.1');
        $this->assertEqual($aRow['tracker_host_name'], 'thost1');
        $this->assertEqual($aRow['connection_host_name'], 'host1');
        $this->assertEqual($aRow['tracker_country'], 'T1');
        $this->assertEqual($aRow['connection_country'], 'U1');
        $this->assertEqual($aRow['tracker_https'], 1);
        $this->assertEqual($aRow['connection_https'], 0);
        $this->assertEqual($aRow['tracker_domain'], 'tdomain1');
        $this->assertEqual($aRow['connection_domain'], 'domain1');
        $this->assertEqual($aRow['tracker_page'], 'tpage1');
        $this->assertEqual($aRow['connection_page'], 'page1');
        $this->assertEqual($aRow['tracker_query'], 'tquery1');
        $this->assertEqual($aRow['connection_query'], 'query1');
        $this->assertEqual($aRow['tracker_referer'], 'tref1');
        $this->assertEqual($aRow['connection_referer'], 'ref1');
        $this->assertEqual($aRow['tracker_search_term'], 'tterm1');
        $this->assertEqual($aRow['connection_search_term'], 'term1');
        $this->assertEqual($aRow['tracker_user_agent'], 'tagent1');
        $this->assertEqual($aRow['connection_user_agent'], 'agent1');
        $this->assertEqual($aRow['tracker_os'], 'tlinux1');
        $this->assertEqual($aRow['connection_os'], 'linux1');
        $this->assertEqual($aRow['tracker_browser'], 'tmozilla1');
        $this->assertEqual($aRow['connection_browser'], 'mozilla1');
        $this->assertEqual($aRow['connection_action'], 1);
        $this->assertEqual($aRow['connection_window'], 259200);
        $this->assertEqual($aRow['connection_status'], MAX_CONNECTION_STATUS_APPROVED);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 0);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                *
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad']}
            WHERE
                ad_id = 1";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['day'], '2004-06-06');
        $this->assertEqual($aRow['hour'], 18);
        $this->assertEqual($aRow['operation_interval'], 30);
        $this->assertEqual($aRow['operation_interval_id'], 36);
        $this->assertEqual($aRow['interval_start'], '2004-06-06 18:00:00');
        $this->assertEqual($aRow['interval_end'], '2004-06-06 18:29:59');
        $this->assertEqual($aRow['ad_id'], 1);
        $this->assertEqual($aRow['creative_id'], 1);
        $this->assertEqual($aRow['zone_id'], 1);
        $this->assertEqual($aRow['requests'], 0);
        $this->assertEqual($aRow['impressions'], 0);
        $this->assertEqual($aRow['clicks'], 0);
        $this->assertEqual($aRow['conversions'], 1);
        $this->assertEqual($aRow['total_basket_value'], 0);
        TestEnv::restoreEnv();

        // Test 10
        $conf['maintenance']['operationInterval'] = 30;
        $conf['modules']['Tracker'] = true;
        $oDbh = &OA_DB::singleton();
        $dsa = $oMDMSF->factory("AdServer");
        $dsa->tempTables->createTable('tmp_ad_request');
        $dsa->tempTables->createTable('tmp_ad_impression');
        $dsa->tempTables->createTable('tmp_ad_click');
        $dsa->tempTables->createTable('tmp_ad_connection');
        $rows = $oDbh->exec(SAVE_INTERMEDIATE_VARIABLES_TEST_10);
        $rows = $oDbh->exec(SAVE_INTERMEDIATE_TRACKER_IMPRESSIONS_TEST_10);
        $rows = $oDbh->exec(SAVE_INTERMEDIATE_TRACKER_VARIABLE_VALUES_TEST_10);
        $rows = $oDbh->exec(SAVE_INTERMEDIATE_CONNECTIONS_TEST_10);
        $start = new Date('2004-06-06 18:00:00');
        $end = new Date('2004-06-06 18:29:59');
        $dsa->saveIntermediate($start, $end, $aTypes);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                *
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
            WHERE
                server_raw_tracker_impression_id = 2
                AND server_raw_ip = '127.0.0.1'";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['server_raw_tracker_impression_id'], 2);
        $this->assertEqual($aRow['server_raw_ip'], '127.0.0.1');
        $this->assertEqual($aRow['viewer_id'], 'aa');
        $this->assertEqual($aRow['viewer_session_id'], 1);
        $this->assertEqual($aRow['tracker_date_time'], '2004-06-06 18:10:30');
        $this->assertEqual($aRow['connection_date_time'], '2004-06-06 18:00:00');
        $this->assertEqual($aRow['tracker_id'], 1);
        $this->assertEqual($aRow['ad_id'], 1);
        $this->assertEqual($aRow['creative_id'], 1);
        $this->assertEqual($aRow['zone_id'], 1);
        $this->assertEqual($aRow['tracker_channel'], 'tchan1');
        $this->assertEqual($aRow['connection_channel'], 'chan1');
        $this->assertEqual($aRow['tracker_language'], 'ten1');
        $this->assertEqual($aRow['connection_language'], 'en1');
        $this->assertEqual($aRow['tracker_ip_address'], 't127.0.0.1');
        $this->assertEqual($aRow['connection_ip_address'], '127.0.0.1');
        $this->assertEqual($aRow['tracker_host_name'], 'thost1');
        $this->assertEqual($aRow['connection_host_name'], 'host1');
        $this->assertEqual($aRow['tracker_country'], 'T1');
        $this->assertEqual($aRow['connection_country'], 'U1');
        $this->assertEqual($aRow['tracker_https'], 1);
        $this->assertEqual($aRow['connection_https'], 0);
        $this->assertEqual($aRow['tracker_domain'], 'tdomain1');
        $this->assertEqual($aRow['connection_domain'], 'domain1');
        $this->assertEqual($aRow['tracker_page'], 'tpage1');
        $this->assertEqual($aRow['connection_page'], 'page1');
        $this->assertEqual($aRow['tracker_query'], 'tquery1');
        $this->assertEqual($aRow['connection_query'], 'query1');
        $this->assertEqual($aRow['tracker_referer'], 'tref1');
        $this->assertEqual($aRow['connection_referer'], 'ref1');
        $this->assertEqual($aRow['tracker_search_term'], 'tterm1');
        $this->assertEqual($aRow['connection_search_term'], 'term1');
        $this->assertEqual($aRow['tracker_user_agent'], 'tagent1');
        $this->assertEqual($aRow['connection_user_agent'], 'agent1');
        $this->assertEqual($aRow['tracker_os'], 'tlinux1');
        $this->assertEqual($aRow['connection_os'], 'linux1');
        $this->assertEqual($aRow['tracker_browser'], 'tmozilla1');
        $this->assertEqual($aRow['connection_browser'], 'mozilla1');
        $this->assertEqual($aRow['connection_action'], 1);
        $this->assertEqual($aRow['connection_window'], 259200);
        $this->assertEqual($aRow['connection_status'], MAX_CONNECTION_STATUS_APPROVED);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                value
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}
            WHERE
                tracker_variable_id = 1";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['value'], 2);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                *
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad']}
            WHERE
                ad_id = 1";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['day'], '2004-06-06');
        $this->assertEqual($aRow['hour'], 18);
        $this->assertEqual($aRow['operation_interval'], 30);
        $this->assertEqual($aRow['operation_interval_id'], 36);
        $this->assertEqual($aRow['interval_start'], '2004-06-06 18:00:00');
        $this->assertEqual($aRow['interval_end'], '2004-06-06 18:29:59');
        $this->assertEqual($aRow['ad_id'], 1);
        $this->assertEqual($aRow['creative_id'], 1);
        $this->assertEqual($aRow['zone_id'], 1);
        $this->assertEqual($aRow['requests'], 0);
        $this->assertEqual($aRow['impressions'], 0);
        $this->assertEqual($aRow['clicks'], 0);
        $this->assertEqual($aRow['conversions'], 1);
        $this->assertEqual($aRow['total_basket_value'], 2);
        TestEnv::restoreEnv();

        // Test 11
        $conf['maintenance']['operationInterval'] = 30;
        $conf['modules']['Tracker'] = true;
        $oDbh = &OA_DB::singleton();
        $dsa = $oMDMSF->factory("AdServer");
        $dsa->tempTables->createTable('tmp_ad_request');
        $dsa->tempTables->createTable('tmp_ad_impression');
        $dsa->tempTables->createTable('tmp_ad_click');
        $dsa->tempTables->createTable('tmp_ad_connection');
        $rows = $oDbh->exec(SAVE_INTERMEDIATE_AD_REQUESTS);
        $rows = $oDbh->exec(SAVE_INTERMEDIATE_AD_IMPRESSIONS);
        $rows = $oDbh->exec(SAVE_INTERMEDIATE_AD_CLICKS);
        $rows = $oDbh->exec(SAVE_INTERMEDIATE_VARIABLES_TEST_11);
        $rows = $oDbh->exec(SAVE_INTERMEDIATE_TRACKER_IMPRESSIONS_TEST_11);
        $rows = $oDbh->exec(SAVE_INTERMEDIATE_TRACKER_VARIABLE_VALUES_TEST_11);
        $rows = $oDbh->exec(SAVE_INTERMEDIATE_CONNECTIONS_TEST_11);
        $start = new Date('2004-06-06 18:00:00');
        $end = new Date('2004-06-06 18:29:59');
        $dsa->saveIntermediate($start, $end, $aTypes);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 9);
        $query = "
            SELECT
                *
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
            WHERE
                server_raw_tracker_impression_id = 2
                AND server_raw_ip = '127.0.0.1'";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['server_raw_tracker_impression_id'], 2);
        $this->assertEqual($aRow['server_raw_ip'], '127.0.0.1');
        $this->assertEqual($aRow['viewer_id'], 'aa');
        $this->assertEqual($aRow['viewer_session_id'], 1);
        $this->assertEqual($aRow['tracker_date_time'], '2004-06-06 18:10:30');
        $this->assertEqual($aRow['connection_date_time'], '2004-06-06 18:00:00');
        $this->assertEqual($aRow['tracker_id'], 20);
        $this->assertEqual($aRow['ad_id'], 1);
        $this->assertEqual($aRow['creative_id'], 1);
        $this->assertEqual($aRow['zone_id'], 1);
        $this->assertEqual($aRow['tracker_channel'], 'tchan1');
        $this->assertEqual($aRow['connection_channel'], 'chan1');
        $this->assertEqual($aRow['tracker_language'], 'ten1');
        $this->assertEqual($aRow['connection_language'], 'en1');
        $this->assertEqual($aRow['tracker_ip_address'], 't127.0.0.1');
        $this->assertEqual($aRow['connection_ip_address'], '127.0.0.1');
        $this->assertEqual($aRow['tracker_host_name'], 'thost1');
        $this->assertEqual($aRow['connection_host_name'], 'host1');
        $this->assertEqual($aRow['tracker_country'], 'T1');
        $this->assertEqual($aRow['connection_country'], 'U1');
        $this->assertEqual($aRow['tracker_https'], 1);
        $this->assertEqual($aRow['connection_https'], 0);
        $this->assertEqual($aRow['tracker_domain'], 'tdomain1');
        $this->assertEqual($aRow['connection_domain'], 'domain1');
        $this->assertEqual($aRow['tracker_page'], 'tpage1');
        $this->assertEqual($aRow['connection_page'], 'page1');
        $this->assertEqual($aRow['tracker_query'], 'tquery1');
        $this->assertEqual($aRow['connection_query'], 'query1');
        $this->assertEqual($aRow['tracker_referer'], 'tref1');
        $this->assertEqual($aRow['connection_referer'], 'ref1');
        $this->assertEqual($aRow['tracker_search_term'], 'tterm1');
        $this->assertEqual($aRow['connection_search_term'], 'term1');
        $this->assertEqual($aRow['tracker_user_agent'], 'tagent1');
        $this->assertEqual($aRow['connection_user_agent'], 'agent1');
        $this->assertEqual($aRow['tracker_os'], 'tlinux1');
        $this->assertEqual($aRow['connection_os'], 'linux1');
        $this->assertEqual($aRow['tracker_browser'], 'tmozilla1');
        $this->assertEqual($aRow['connection_browser'], 'mozilla1');
        $this->assertEqual($aRow['connection_action'], 1);
        $this->assertEqual($aRow['connection_window'], 259200);
        $this->assertEqual($aRow['connection_status'], MAX_CONNECTION_STATUS_APPROVED);
        $query = "
            SELECT
                *
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
            WHERE
                server_raw_tracker_impression_id = 3
                AND server_raw_ip = '127.0.0.3'";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['server_raw_tracker_impression_id'], 3);
        $this->assertEqual($aRow['server_raw_ip'], '127.0.0.3');
        $this->assertEqual($aRow['viewer_id'], 'cc');
        $this->assertEqual($aRow['viewer_session_id'], 3);
        $this->assertEqual($aRow['tracker_date_time'], '2004-06-06 18:10:33');
        $this->assertEqual($aRow['connection_date_time'], '2004-06-06 18:00:34');
        $this->assertEqual($aRow['tracker_id'], 1);
        $this->assertEqual($aRow['ad_id'], 2);
        $this->assertEqual($aRow['creative_id'], 2);
        $this->assertEqual($aRow['zone_id'], 2);
        $this->assertEqual($aRow['tracker_channel'], 'tchan3');
        $this->assertEqual($aRow['connection_channel'], 'chan3');
        $this->assertEqual($aRow['tracker_language'], 'ten3');
        $this->assertEqual($aRow['connection_language'], 'en3');
        $this->assertEqual($aRow['tracker_ip_address'], 't127.0.0.3');
        $this->assertEqual($aRow['connection_ip_address'], '127.0.0.3');
        $this->assertEqual($aRow['tracker_host_name'], 'thost3');
        $this->assertEqual($aRow['connection_host_name'], 'host3');
        $this->assertEqual($aRow['tracker_country'], 'T3');
        $this->assertEqual($aRow['connection_country'], 'U3');
        $this->assertEqual($aRow['tracker_https'], 1);
        $this->assertEqual($aRow['connection_https'], 0);
        $this->assertEqual($aRow['tracker_domain'], 'tdomain3');
        $this->assertEqual($aRow['connection_domain'], 'domain3');
        $this->assertEqual($aRow['tracker_page'], 'tpage3');
        $this->assertEqual($aRow['connection_page'], 'page3');
        $this->assertEqual($aRow['tracker_query'], 'tquery3');
        $this->assertEqual($aRow['connection_query'], 'query3');
        $this->assertEqual($aRow['tracker_referer'], 'tref3');
        $this->assertEqual($aRow['connection_referer'], 'ref3');
        $this->assertEqual($aRow['tracker_search_term'], 'tterm3');
        $this->assertEqual($aRow['connection_search_term'], 'term3');
        $this->assertEqual($aRow['tracker_user_agent'], 'tagent3');
        $this->assertEqual($aRow['connection_user_agent'], 'agent3');
        $this->assertEqual($aRow['tracker_os'], 'tlinux3');
        $this->assertEqual($aRow['connection_os'], 'linux3');
        $this->assertEqual($aRow['tracker_browser'], 'tmozilla3');
        $this->assertEqual($aRow['connection_browser'], 'mozilla3');
        $this->assertEqual($aRow['connection_action'], 1);
        $this->assertEqual($aRow['connection_window'], 259200);
        $this->assertEqual($aRow['connection_status'], MAX_CONNECTION_STATUS_APPROVED);
        $query = "
            SELECT
                *
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
            WHERE
                server_raw_tracker_impression_id = 4
                AND server_raw_ip = '127.0.0.3'";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['server_raw_tracker_impression_id'], 4);
        $this->assertEqual($aRow['server_raw_ip'], '127.0.0.3');
        $this->assertEqual($aRow['viewer_id'], 'cc');
        $this->assertEqual($aRow['viewer_session_id'], 3);
        $this->assertEqual($aRow['tracker_date_time'], '2004-06-06 18:10:33');
        $this->assertEqual($aRow['connection_date_time'], '2004-06-06 18:00:34');
        $this->assertEqual($aRow['tracker_id'], 2);
        $this->assertEqual($aRow['ad_id'], 2);
        $this->assertEqual($aRow['creative_id'], 2);
        $this->assertEqual($aRow['zone_id'], 2);
        $this->assertEqual($aRow['tracker_channel'], 'tchan3');
        $this->assertEqual($aRow['connection_channel'], 'chan3');
        $this->assertEqual($aRow['tracker_language'], 'ten3');
        $this->assertEqual($aRow['connection_language'], 'en3');
        $this->assertEqual($aRow['tracker_ip_address'], 't127.0.0.3');
        $this->assertEqual($aRow['connection_ip_address'], '127.0.0.3');
        $this->assertEqual($aRow['tracker_host_name'], 'thost3');
        $this->assertEqual($aRow['connection_host_name'], 'host3');
        $this->assertEqual($aRow['tracker_country'], 'T3');
        $this->assertEqual($aRow['connection_country'], 'U3');
        $this->assertEqual($aRow['tracker_https'], 1);
        $this->assertEqual($aRow['connection_https'], 0);
        $this->assertEqual($aRow['tracker_domain'], 'tdomain3');
        $this->assertEqual($aRow['connection_domain'], 'domain3');
        $this->assertEqual($aRow['tracker_page'], 'tpage3');
        $this->assertEqual($aRow['connection_page'], 'page3');
        $this->assertEqual($aRow['tracker_query'], 'tquery3');
        $this->assertEqual($aRow['connection_query'], 'query3');
        $this->assertEqual($aRow['tracker_referer'], 'tref3');
        $this->assertEqual($aRow['connection_referer'], 'ref3');
        $this->assertEqual($aRow['tracker_search_term'], 'tterm3');
        $this->assertEqual($aRow['connection_search_term'], 'term3');
        $this->assertEqual($aRow['tracker_user_agent'], 'tagent3');
        $this->assertEqual($aRow['connection_user_agent'], 'agent3');
        $this->assertEqual($aRow['tracker_os'], 'tlinux3');
        $this->assertEqual($aRow['connection_os'], 'linux3');
        $this->assertEqual($aRow['tracker_browser'], 'tmozilla3');
        $this->assertEqual($aRow['connection_browser'], 'mozilla3');
        $this->assertEqual($aRow['connection_action'], 1);
        $this->assertEqual($aRow['connection_window'], 259200);
        $this->assertEqual($aRow['connection_status'], MAX_CONNECTION_STATUS_APPROVED);
        $query = "
            SELECT
                *
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
            WHERE
                server_raw_tracker_impression_id = 5
                AND server_raw_ip = '127.0.0.3'";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['server_raw_tracker_impression_id'], 5);
        $this->assertEqual($aRow['server_raw_ip'], '127.0.0.3');
        $this->assertEqual($aRow['viewer_id'], 'cc');
        $this->assertEqual($aRow['viewer_session_id'], 3);
        $this->assertEqual($aRow['tracker_date_time'], '2004-06-06 18:10:33');
        $this->assertEqual($aRow['connection_date_time'], '2004-06-06 18:00:34');
        $this->assertEqual($aRow['tracker_id'], 2);
        $this->assertEqual($aRow['ad_id'], 2);
        $this->assertEqual($aRow['creative_id'], 2);
        $this->assertEqual($aRow['zone_id'], 2);
        $this->assertEqual($aRow['tracker_channel'], 'tchan3');
        $this->assertEqual($aRow['connection_channel'], 'chan3');
        $this->assertEqual($aRow['tracker_language'], 'ten3');
        $this->assertEqual($aRow['connection_language'], 'en3');
        $this->assertEqual($aRow['tracker_ip_address'], 't127.0.0.3');
        $this->assertEqual($aRow['connection_ip_address'], '127.0.0.3');
        $this->assertEqual($aRow['tracker_host_name'], 'thost3');
        $this->assertEqual($aRow['connection_host_name'], 'host3');
        $this->assertEqual($aRow['tracker_country'], 'T3');
        $this->assertEqual($aRow['connection_country'], 'U3');
        $this->assertEqual($aRow['tracker_https'], 1);
        $this->assertEqual($aRow['connection_https'], 0);
        $this->assertEqual($aRow['tracker_domain'], 'tdomain3');
        $this->assertEqual($aRow['connection_domain'], 'domain3');
        $this->assertEqual($aRow['tracker_page'], 'tpage3');
        $this->assertEqual($aRow['connection_page'], 'page3');
        $this->assertEqual($aRow['tracker_query'], 'tquery3');
        $this->assertEqual($aRow['connection_query'], 'query3');
        $this->assertEqual($aRow['tracker_referer'], 'tref3');
        $this->assertEqual($aRow['connection_referer'], 'ref3');
        $this->assertEqual($aRow['tracker_search_term'], 'tterm3');
        $this->assertEqual($aRow['connection_search_term'], 'term3');
        $this->assertEqual($aRow['tracker_user_agent'], 'tagent3');
        $this->assertEqual($aRow['connection_user_agent'], 'agent3');
        $this->assertEqual($aRow['tracker_os'], 'tlinux3');
        $this->assertEqual($aRow['connection_os'], 'linux3');
        $this->assertEqual($aRow['tracker_browser'], 'tmozilla3');
        $this->assertEqual($aRow['connection_browser'], 'mozilla3');
        $this->assertEqual($aRow['connection_action'], 1);
        $this->assertEqual($aRow['connection_window'], 259200);
        $this->assertEqual($aRow['connection_status'], MAX_CONNECTION_STATUS_APPROVED);
        $query = "
            SELECT
                *
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
            WHERE
                server_raw_tracker_impression_id = 6
                AND server_raw_ip = '127.0.0.6'";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['server_raw_tracker_impression_id'], 6);
        $this->assertEqual($aRow['server_raw_ip'], '127.0.0.6');
        $this->assertEqual($aRow['viewer_id'], 'ff');
        $this->assertEqual($aRow['viewer_session_id'], 6);
        $this->assertEqual($aRow['tracker_date_time'], '2004-06-06 18:10:36');
        $this->assertEqual($aRow['connection_date_time'], '2004-06-06 18:00:36');
        $this->assertEqual($aRow['tracker_id'], 3);
        $this->assertEqual($aRow['ad_id'], 3);
        $this->assertEqual($aRow['creative_id'], 3);
        $this->assertEqual($aRow['zone_id'], 3);
        $this->assertEqual($aRow['tracker_channel'], 'tchan6');
        $this->assertEqual($aRow['connection_channel'], 'chan6');
        $this->assertEqual($aRow['tracker_language'], 'ten6');
        $this->assertEqual($aRow['connection_language'], 'en6');
        $this->assertEqual($aRow['tracker_ip_address'], 't127.0.0.6');
        $this->assertEqual($aRow['connection_ip_address'], '127.0.0.6');
        $this->assertEqual($aRow['tracker_host_name'], 'thost6');
        $this->assertEqual($aRow['connection_host_name'], 'host6');
        $this->assertEqual($aRow['tracker_country'], 'T6');
        $this->assertEqual($aRow['connection_country'], 'U6');
        $this->assertEqual($aRow['tracker_https'], 1);
        $this->assertEqual($aRow['connection_https'], 0);
        $this->assertEqual($aRow['tracker_domain'], 'tdomain6');
        $this->assertEqual($aRow['connection_domain'], 'domain6');
        $this->assertEqual($aRow['tracker_page'], 'tpage6');
        $this->assertEqual($aRow['connection_page'], 'page6');
        $this->assertEqual($aRow['tracker_query'], 'tquery6');
        $this->assertEqual($aRow['connection_query'], 'query6');
        $this->assertEqual($aRow['tracker_referer'], 'tref6');
        $this->assertEqual($aRow['connection_referer'], 'ref6');
        $this->assertEqual($aRow['tracker_search_term'], 'tterm6');
        $this->assertEqual($aRow['connection_search_term'], 'term6');
        $this->assertEqual($aRow['tracker_user_agent'], 'tagent6');
        $this->assertEqual($aRow['connection_user_agent'], 'agent6');
        $this->assertEqual($aRow['tracker_os'], 'tlinux6');
        $this->assertEqual($aRow['connection_os'], 'linux6');
        $this->assertEqual($aRow['tracker_browser'], 'tmozilla6');
        $this->assertEqual($aRow['connection_browser'], 'mozilla6');
        $this->assertEqual($aRow['connection_action'], 1);
        $this->assertEqual($aRow['connection_window'], 259200);
        $this->assertEqual($aRow['connection_status'], MAX_CONNECTION_STATUS_APPROVED);
        $query = "
            SELECT
                *
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
            WHERE
                server_raw_tracker_impression_id = 7
                AND server_raw_ip = '127.0.0.6'";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['server_raw_tracker_impression_id'], 7);
        $this->assertEqual($aRow['server_raw_ip'], '127.0.0.6');
        $this->assertEqual($aRow['viewer_id'], 'ff');
        $this->assertEqual($aRow['viewer_session_id'], 6);
        $this->assertEqual($aRow['tracker_date_time'], '2004-06-06 18:10:36');
        $this->assertEqual($aRow['connection_date_time'], '2004-06-06 18:00:36');
        $this->assertEqual($aRow['tracker_id'], 4);
        $this->assertEqual($aRow['ad_id'], 3);
        $this->assertEqual($aRow['creative_id'], 3);
        $this->assertEqual($aRow['zone_id'], 3);
        $this->assertEqual($aRow['tracker_channel'], 'tchan6');
        $this->assertEqual($aRow['connection_channel'], 'chan6');
        $this->assertEqual($aRow['tracker_language'], 'ten6');
        $this->assertEqual($aRow['connection_language'], 'en6');
        $this->assertEqual($aRow['tracker_ip_address'], 't127.0.0.6');
        $this->assertEqual($aRow['connection_ip_address'], '127.0.0.6');
        $this->assertEqual($aRow['tracker_host_name'], 'thost6');
        $this->assertEqual($aRow['connection_host_name'], 'host6');
        $this->assertEqual($aRow['tracker_country'], 'T6');
        $this->assertEqual($aRow['connection_country'], 'U6');
        $this->assertEqual($aRow['tracker_https'], 1);
        $this->assertEqual($aRow['connection_https'], 0);
        $this->assertEqual($aRow['tracker_domain'], 'tdomain6');
        $this->assertEqual($aRow['connection_domain'], 'domain6');
        $this->assertEqual($aRow['tracker_page'], 'tpage6');
        $this->assertEqual($aRow['connection_page'], 'page6');
        $this->assertEqual($aRow['tracker_query'], 'tquery6');
        $this->assertEqual($aRow['connection_query'], 'query6');
        $this->assertEqual($aRow['tracker_referer'], 'tref6');
        $this->assertEqual($aRow['connection_referer'], 'ref6');
        $this->assertEqual($aRow['tracker_search_term'], 'tterm6');
        $this->assertEqual($aRow['connection_search_term'], 'term6');
        $this->assertEqual($aRow['tracker_user_agent'], 'tagent6');
        $this->assertEqual($aRow['connection_user_agent'], 'agent6');
        $this->assertEqual($aRow['tracker_os'], 'tlinux6');
        $this->assertEqual($aRow['connection_os'], 'linux6');
        $this->assertEqual($aRow['tracker_browser'], 'tmozilla6');
        $this->assertEqual($aRow['connection_browser'], 'mozilla6');
        $this->assertEqual($aRow['connection_action'], 1);
        $this->assertEqual($aRow['connection_window'], 259200);
        $this->assertEqual($aRow['connection_status'], MAX_CONNECTION_STATUS_APPROVED);
        $query = "
            SELECT
                *
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
            WHERE
                server_raw_tracker_impression_id = 8
                AND server_raw_ip = '127.0.0.8'";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['server_raw_tracker_impression_id'], 8);
        $this->assertEqual($aRow['server_raw_ip'], '127.0.0.8');
        $this->assertEqual($aRow['viewer_id'], 'gg');
        $this->assertEqual($aRow['viewer_session_id'], 8);
        $this->assertEqual($aRow['tracker_date_time'], '2004-06-06 18:10:38');
        $this->assertEqual($aRow['connection_date_time'], '2004-06-06 18:00:38');
        $this->assertEqual($aRow['tracker_id'], 5);
        $this->assertEqual($aRow['ad_id'], 1);
        $this->assertEqual($aRow['creative_id'], 1);
        $this->assertEqual($aRow['zone_id'], 1);
        $this->assertEqual($aRow['tracker_channel'], 'tchan8');
        $this->assertEqual($aRow['connection_channel'], 'chan8');
        $this->assertEqual($aRow['tracker_language'], 'ten8');
        $this->assertEqual($aRow['connection_language'], 'en8');
        $this->assertEqual($aRow['tracker_ip_address'], 't127.0.0.8');
        $this->assertEqual($aRow['connection_ip_address'], '127.0.0.8');
        $this->assertEqual($aRow['tracker_host_name'], 'thost8');
        $this->assertEqual($aRow['connection_host_name'], 'host8');
        $this->assertEqual($aRow['tracker_country'], 'T8');
        $this->assertEqual($aRow['connection_country'], 'U8');
        $this->assertEqual($aRow['tracker_https'], 1);
        $this->assertEqual($aRow['connection_https'], 0);
        $this->assertEqual($aRow['tracker_domain'], 'tdomain8');
        $this->assertEqual($aRow['connection_domain'], 'domain8');
        $this->assertEqual($aRow['tracker_page'], 'tpage8');
        $this->assertEqual($aRow['connection_page'], 'page8');
        $this->assertEqual($aRow['tracker_query'], 'tquery8');
        $this->assertEqual($aRow['connection_query'], 'query8');
        $this->assertEqual($aRow['tracker_referer'], 'tref8');
        $this->assertEqual($aRow['connection_referer'], 'ref8');
        $this->assertEqual($aRow['tracker_search_term'], 'tterm8');
        $this->assertEqual($aRow['connection_search_term'], 'term8');
        $this->assertEqual($aRow['tracker_user_agent'], 'tagent8');
        $this->assertEqual($aRow['connection_user_agent'], 'agent8');
        $this->assertEqual($aRow['tracker_os'], 'tlinux8');
        $this->assertEqual($aRow['connection_os'], 'linux8');
        $this->assertEqual($aRow['tracker_browser'], 'tmozilla8');
        $this->assertEqual($aRow['connection_browser'], 'mozilla8');
        $this->assertEqual($aRow['connection_action'], 1);
        $this->assertEqual($aRow['connection_window'], 259200);
        $this->assertEqual($aRow['connection_status'], MAX_CONNECTION_STATUS_APPROVED);
        $query = "
            SELECT
                *
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
            WHERE
                server_raw_tracker_impression_id = 9
                AND server_raw_ip = '127.0.0.9'";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['server_raw_tracker_impression_id'], 9);
        $this->assertEqual($aRow['server_raw_ip'], '127.0.0.9');
        $this->assertEqual($aRow['viewer_id'], 'hh');
        $this->assertEqual($aRow['viewer_session_id'], 9);
        $this->assertEqual($aRow['tracker_date_time'], '2004-06-06 18:10:39');
        $this->assertEqual($aRow['connection_date_time'], '2004-06-06 18:00:39');
        $this->assertEqual($aRow['tracker_id'], 6);
        $this->assertEqual($aRow['ad_id'], 1);
        $this->assertEqual($aRow['creative_id'], 1);
        $this->assertEqual($aRow['zone_id'], 1);
        $this->assertEqual($aRow['tracker_channel'], 'tchan9');
        $this->assertEqual($aRow['connection_channel'], 'chan9');
        $this->assertEqual($aRow['tracker_language'], 'ten9');
        $this->assertEqual($aRow['connection_language'], 'en9');
        $this->assertEqual($aRow['tracker_ip_address'], 't127.0.0.9');
        $this->assertEqual($aRow['connection_ip_address'], '127.0.0.9');
        $this->assertEqual($aRow['tracker_host_name'], 'thost9');
        $this->assertEqual($aRow['connection_host_name'], 'host9');
        $this->assertEqual($aRow['tracker_country'], 'T9');
        $this->assertEqual($aRow['connection_country'], 'U9');
        $this->assertEqual($aRow['tracker_https'], 1);
        $this->assertEqual($aRow['connection_https'], 0);
        $this->assertEqual($aRow['tracker_domain'], 'tdomain9');
        $this->assertEqual($aRow['connection_domain'], 'domain9');
        $this->assertEqual($aRow['tracker_page'], 'tpage9');
        $this->assertEqual($aRow['connection_page'], 'page9');
        $this->assertEqual($aRow['tracker_query'], 'tquery9');
        $this->assertEqual($aRow['connection_query'], 'query9');
        $this->assertEqual($aRow['tracker_referer'], 'tref9');
        $this->assertEqual($aRow['connection_referer'], 'ref9');
        $this->assertEqual($aRow['tracker_search_term'], 'tterm9');
        $this->assertEqual($aRow['connection_search_term'], 'term9');
        $this->assertEqual($aRow['tracker_user_agent'], 'tagent9');
        $this->assertEqual($aRow['connection_user_agent'], 'agent9');
        $this->assertEqual($aRow['tracker_os'], 'tlinux9');
        $this->assertEqual($aRow['connection_os'], 'linux9');
        $this->assertEqual($aRow['tracker_browser'], 'tmozilla9');
        $this->assertEqual($aRow['connection_browser'], 'mozilla9');
        $this->assertEqual($aRow['connection_action'], 1);
        $this->assertEqual($aRow['connection_window'], 259200);
        $this->assertEqual($aRow['connection_status'], MAX_CONNECTION_STATUS_APPROVED);
        $query = "
            SELECT
                *
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_connection']}
            WHERE
                server_raw_tracker_impression_id = 10
                AND server_raw_ip = '127.0.0.10'";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['server_raw_tracker_impression_id'], 10);
        $this->assertEqual($aRow['server_raw_ip'], '127.0.0.10');
        $this->assertEqual($aRow['viewer_id'], 'ii');
        $this->assertEqual($aRow['viewer_session_id'], 10);
        $this->assertEqual($aRow['tracker_date_time'], '2004-06-06 18:10:40');
        $this->assertEqual($aRow['connection_date_time'], '2004-06-06 18:00:40');
        $this->assertEqual($aRow['tracker_id'], 7);
        $this->assertEqual($aRow['ad_id'], 1);
        $this->assertEqual($aRow['creative_id'], 1);
        $this->assertEqual($aRow['zone_id'], 1);
        $this->assertEqual($aRow['tracker_channel'], 'tchan10');
        $this->assertEqual($aRow['connection_channel'], 'chan10');
        $this->assertEqual($aRow['tracker_language'], 'ten10');
        $this->assertEqual($aRow['connection_language'], 'en10');
        $this->assertEqual($aRow['tracker_ip_address'], 't127.0.0.10');
        $this->assertEqual($aRow['connection_ip_address'], '127.0.0.10');
        $this->assertEqual($aRow['tracker_host_name'], 'thost10');
        $this->assertEqual($aRow['connection_host_name'], 'host10');
        $this->assertEqual($aRow['tracker_country'], 'T1');
        $this->assertEqual($aRow['connection_country'], 'U1');
        $this->assertEqual($aRow['tracker_https'], 1);
        $this->assertEqual($aRow['connection_https'], 0);
        $this->assertEqual($aRow['tracker_domain'], 'tdomain10');
        $this->assertEqual($aRow['connection_domain'], 'domain10');
        $this->assertEqual($aRow['tracker_page'], 'tpage10');
        $this->assertEqual($aRow['connection_page'], 'page10');
        $this->assertEqual($aRow['tracker_query'], 'tquery10');
        $this->assertEqual($aRow['connection_query'], 'query10');
        $this->assertEqual($aRow['tracker_referer'], 'tref10');
        $this->assertEqual($aRow['connection_referer'], 'ref10');
        $this->assertEqual($aRow['tracker_search_term'], 'tterm10');
        $this->assertEqual($aRow['connection_search_term'], 'term10');
        $this->assertEqual($aRow['tracker_user_agent'], 'tagent10');
        $this->assertEqual($aRow['connection_user_agent'], 'agent10');
        $this->assertEqual($aRow['tracker_os'], 'tlinux10');
        $this->assertEqual($aRow['connection_os'], 'linux10');
        $this->assertEqual($aRow['tracker_browser'], 'tmozilla10');
        $this->assertEqual($aRow['connection_browser'], 'mozilla10');
        $this->assertEqual($aRow['connection_action'], 1);
        $this->assertEqual($aRow['connection_window'], 259200);
        $this->assertEqual($aRow['connection_status'], MAX_CONNECTION_STATUS_APPROVED);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 12);
        $query = "
            SELECT
                value
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}
            WHERE
                tracker_variable_id = 1";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['value'], 37);
        $query = "
            SELECT
                value
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}
            WHERE
                tracker_variable_id = 2";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['value'], 8);
        $query = "
            SELECT
                value
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}
            WHERE
                tracker_variable_id = 3";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['value'], 10);
        $query = "
            SELECT
                value
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}
            WHERE
                tracker_variable_id = 4";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['value'], 11);
        $query = "
            SELECT
                value
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}
            WHERE
                tracker_variable_id = 5";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['value'], 10);
        $query = "
            SELECT
                value
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}
            WHERE
                tracker_variable_id = 6";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['value'], 11);
        $query = "
            SELECT
                value
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}
            WHERE
                tracker_variable_id = 7";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['value'], 1);
        $query = "
            SELECT
                value
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}
            WHERE
                tracker_variable_id = 8";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['value'], 2);
        $query = "
            SELECT
                value
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}
            WHERE
                tracker_variable_id = 9";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['value'], 10);
        $query = "
            SELECT
                value
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}
            WHERE
                tracker_variable_id = 10";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['value'], 2);
        $query = "
            SELECT
                value
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}
            WHERE
                tracker_variable_id = 11";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['value'], 5);
        $query = "
            SELECT
                value
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad_variable_value']}
            WHERE
                tracker_variable_id = 12";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['value'], 2);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 3);
        $query = "
            SELECT
                *
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad']}
            WHERE
                ad_id = 1";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['day'], '2004-06-06');
        $this->assertEqual($aRow['hour'], 18);
        $this->assertEqual($aRow['operation_interval'], 30);
        $this->assertEqual($aRow['operation_interval_id'], 36);
        $this->assertEqual($aRow['interval_start'], '2004-06-06 18:00:00');
        $this->assertEqual($aRow['interval_end'], '2004-06-06 18:29:59');
        $this->assertEqual($aRow['ad_id'], 1);
        $this->assertEqual($aRow['creative_id'], 1);
        $this->assertEqual($aRow['zone_id'], 1);
        $this->assertEqual($aRow['requests'], 1);
        $this->assertEqual($aRow['impressions'], 1);
        $this->assertEqual($aRow['clicks'], 1);
        $this->assertEqual($aRow['conversions'], 4);
        $this->assertEqual($aRow['total_basket_value'], 13);
        $this->assertEqual($aRow['total_num_items'], 9);
        $query = "
            SELECT
                *
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad']}
            WHERE
                ad_id = 2";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['day'], '2004-06-06');
        $this->assertEqual($aRow['hour'], 18);
        $this->assertEqual($aRow['operation_interval'], 30);
        $this->assertEqual($aRow['operation_interval_id'], 36);
        $this->assertEqual($aRow['interval_start'], '2004-06-06 18:00:00');
        $this->assertEqual($aRow['interval_end'], '2004-06-06 18:29:59');
        $this->assertEqual($aRow['ad_id'], 2);
        $this->assertEqual($aRow['creative_id'], 2);
        $this->assertEqual($aRow['zone_id'], 2);
        $this->assertEqual($aRow['requests'], 2);
        $this->assertEqual($aRow['impressions'], 2);
        $this->assertEqual($aRow['clicks'], 2);
        $this->assertEqual($aRow['conversions'], 3);
        $this->assertEqual($aRow['total_basket_value'], 8);
        $this->assertEqual($aRow['total_num_items'], 0);
        $query = "
            SELECT
                *
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad']}
            WHERE
                ad_id = 3";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['day'], '2004-06-06');
        $this->assertEqual($aRow['hour'], 18);
        $this->assertEqual($aRow['operation_interval'], 30);
        $this->assertEqual($aRow['operation_interval_id'], 36);
        $this->assertEqual($aRow['interval_start'], '2004-06-06 18:00:00');
        $this->assertEqual($aRow['interval_end'], '2004-06-06 18:29:59');
        $this->assertEqual($aRow['ad_id'], 3);
        $this->assertEqual($aRow['creative_id'], 3);
        $this->assertEqual($aRow['zone_id'], 3);
        $this->assertEqual($aRow['requests'], 0);
        $this->assertEqual($aRow['impressions'], 0);
        $this->assertEqual($aRow['clicks'], 1);
        $this->assertEqual($aRow['conversions'], 2);
        $this->assertEqual($aRow['total_basket_value'], 11);
        $this->assertEqual($aRow['total_num_items'], 0);
        TestEnv::restoreEnv();
    }

    /**
     * Tests the saveHistory() method.
     */
    function testSaveHistory()
    {
        $conf = &$GLOBALS['_MAX']['CONF'];
        $oDbh = &OA_DB::singleton();
        $conf['maintenance']['operationInterval'] = 30;

        $oMDMSF = new OA_Dal_Maintenance_Statistics_Factory();
        $dsa = $oMDMSF->factory("AdServer");

        // Test with no data
        $start = new Date('2004-06-06 12:00:00');
        $end   = new Date('2004-06-06 12:29:59');
        $dsa->saveHistory($start, $end);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_summary_zone_impression_history']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 0);
        TestEnv::startTransaction();
        // Get the data for the tests
        include_once MAX_PATH . '/lib/max/Dal/data/TestOfStatisticsAdServermysql.php';
        // Insert the test data
        $rows = $oDbh->exec(SAVE_HISTORY_INTERMEDIATE_AD);
        // Test
        $start = new Date('2004-06-06 18:00:00');
        $end   = new Date('2004-06-06 18:29:59');
        $dsa->saveHistory($start, $end);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_summary_zone_impression_history']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                *
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_summary_zone_impression_history']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['operation_interval'], '30');
        $this->assertEqual($aRow['operation_interval_id'], 36);
        $this->assertEqual($aRow['interval_start'], '2004-06-06 18:00:00');
        $this->assertEqual($aRow['interval_end'], '2004-06-06 18:29:59');
        $this->assertEqual($aRow['zone_id'], 1);
        $this->assertNull($aRow['forecast_impressions']); // Default value in table
        $this->assertEqual($aRow['actual_impressions'], 4);
        // Insert more test data
        $rows = $oDbh->exec(SAVE_HISTORY_INTERMEDIATE_AD_NEXT);
        // Test
        $start = new Date('2004-06-06 18:30:00');
        $end   = new Date('2004-06-06 18:59:59');
        $dsa->saveHistory($start, $end);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_summary_zone_impression_history']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 2);
        $query = "
            SELECT
                *
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_summary_zone_impression_history']}
            WHERE
                operation_interval_id = 37";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['operation_interval'], '30');
        $this->assertEqual($aRow['operation_interval_id'], 37);
        $this->assertEqual($aRow['interval_start'], '2004-06-06 18:30:00');
        $this->assertEqual($aRow['interval_end'], '2004-06-06 18:59:59');
        $this->assertEqual($aRow['zone_id'], 1);
        $this->assertNull($aRow['forecast_impressions']); // Default value in table
        $this->assertEqual($aRow['actual_impressions'], 4);
        // Insert some predicted values into the data_summary_zone_impression_history table
        $rows = $oDbh->exec(SAVE_HISTORY_INTERMEDIATE_HISTORY_DUPES);
        // Test
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_summary_zone_impression_history']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 3);
        $query = "
            SELECT
                *
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_summary_zone_impression_history']}
            WHERE
                operation_interval_id = 38";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['operation_interval'], '30');
        $this->assertEqual($aRow['operation_interval_id'], 38);
        $this->assertEqual($aRow['interval_start'], '2004-06-06 19:00:00');
        $this->assertEqual($aRow['interval_end'], '2004-06-06 19:29:59');
        $this->assertEqual($aRow['zone_id'], 1);
        $this->assertNull($aRow['forecast_impressions']); // Default value in table
        $this->assertEqual($aRow['actual_impressions'], 0);
        // Insert more test data
        $rows = $oDbh->exec(SAVE_HISTORY_INTERMEDIATE_AD_DUPES);
        // Test
        $start = new Date('2004-06-06 19:00:00');
        $end   = new Date('2004-06-06 19:29:59');
        $dsa->saveHistory($start, $end);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_summary_zone_impression_history']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 3);
        $query = "
            SELECT
                *
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_summary_zone_impression_history']}
            WHERE
                operation_interval_id = 38";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['operation_interval'], '30');
        $this->assertEqual($aRow['operation_interval_id'], 38);
        $this->assertEqual($aRow['interval_start'], '2004-06-06 19:00:00');
        $this->assertEqual($aRow['interval_end'], '2004-06-06 19:29:59');
        $this->assertEqual($aRow['zone_id'], 1);
        $this->assertNull($aRow['forecast_impressions']); // Default value in table
        $this->assertEqual($aRow['actual_impressions'], 4);
        TestEnv::rollbackTransaction();
        TestEnv::restoreConfig();
    }

    /**
     * Tests the saveSummary() method.
     *
     * Requirements:
     * Test 1: Test with no data.
     * Test 2: Test a single day summarisation.
     * Test 3: Test multi-day summarisation.
     */
    function testSaveSummary()
    {
        $conf = &$GLOBALS['_MAX']['CONF'];
        $oDbh = &OA_DB::singleton();

        $oMDMSF = new OA_Dal_Maintenance_Statistics_Factory();
        $dsa = $oMDMSF->factory("AdServer");

        // Test 1
        $start = new Date('2004-06-06 12:00:00');
        $end   = new Date('2004-06-06 12:29:59');
        $aTypes = array(
            'types' => array(
                0 => 'request',
                1 => 'impression',
                2 => 'click'
            ),
            'connections' => array(
                1 => MAX_CONNECTION_AD_IMPRESSION,
                2 => MAX_CONNECTION_AD_CLICK
            )
        );
        $dsa->saveSummary($start, $end, $aTypes, 'data_intermediate_ad', 'data_summary_ad_hourly');
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_summary_ad_hourly']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 0);

        // Get the data for the tests
        include_once MAX_PATH . '/lib/max/Dal/data/TestOfStatisticsAdServermysql.php';

        // Test 2
        TestEnv::startTransaction();
        // Insert the test data
        $rows = $oDbh->exec(SAVE_SUMMARY_PLACEMENT);
        $rows = $oDbh->exec(SAVE_SUMMARY_AD);
        $rows = $oDbh->exec(SAVE_SUMMARY_ZONE);
        $rows = $oDbh->exec(SAVE_SUMMARY_INTERMEDIATE_AD);
        // Test
        $start = new Date('2004-06-06 18:00:00');
        $end   = new Date('2004-06-06 18:29:59');
        $dsa->saveSummary($start, $end, $aTypes, 'data_intermediate_ad', 'data_summary_ad_hourly');
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_summary_ad_hourly']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 8);
        $query = "
            SELECT
                *
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_summary_ad_hourly']}
            WHERE
                ad_id = 1
                AND creative_id = 1";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['day'], '2004-06-06');
        $this->assertEqual($aRow['hour'], 18);
        $this->assertEqual($aRow['zone_id'], 1);
        $this->assertEqual($aRow['impressions'], 1);
        $this->assertEqual($aRow['clicks'], 1);
        $this->assertEqual($aRow['conversions'], 1);
        $this->assertEqual($aRow['total_basket_value'], 1);
        $this->assertEqual($aRow['total_revenue'], 5);
        $this->assertEqual($aRow['total_cost'], 0.02);
        $query = "
            SELECT
                *
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_summary_ad_hourly']}
            WHERE
                ad_id = 1
                AND creative_id = 2";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['day'], '2004-06-06');
        $this->assertEqual($aRow['hour'], 18);
        $this->assertEqual($aRow['zone_id'], 1);
        $this->assertEqual($aRow['impressions'], 2);
        $this->assertEqual($aRow['clicks'], 2);
        $this->assertEqual($aRow['conversions'], 2);
        $this->assertEqual($aRow['total_basket_value'], 2);
        $this->assertEqual($aRow['total_revenue'], 10);
        $this->assertEqual($aRow['total_cost'], 0.04);
        $query = "
            SELECT
                *
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_summary_ad_hourly']}
            WHERE
                ad_id = 2";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['day'], '2004-06-06');
        $this->assertEqual($aRow['hour'], 18);
        $this->assertEqual($aRow['creative_id'], 1);
        $this->assertEqual($aRow['zone_id'], 1);
        $this->assertEqual($aRow['impressions'], 1);
        $this->assertEqual($aRow['clicks'], 1);
        $this->assertEqual($aRow['conversions'], 0);
        $this->assertEqual($aRow['total_basket_value'], 0);
        $this->assertEqual($aRow['total_revenue'], 2);
        $this->assertEqual($aRow['total_cost'], 0.02);
        $query = "
            SELECT
                *
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_summary_ad_hourly']}
            WHERE
                ad_id = 3";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['day'], '2004-06-06');
        $this->assertEqual($aRow['hour'], 18);
        $this->assertEqual($aRow['creative_id'], 1);
        $this->assertEqual($aRow['zone_id'], 2);
        $this->assertEqual($aRow['impressions'], 1);
        $this->assertEqual($aRow['clicks'], 1);
        $this->assertEqual($aRow['conversions'], 0);
        $this->assertEqual($aRow['total_basket_value'], 0);
        $this->assertEqual($aRow['total_revenue'], 0);
        $this->assertEqual($aRow['total_cost'], 1);
        $query = "
            SELECT
                *
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_summary_ad_hourly']}
            WHERE
                ad_id = 4
            ORDER BY
                zone_id";
        $rc = $oDbh->query($query);
        $this->assertEqual($rc->numRows(), 4);

        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['day'], '2004-06-06');
        $this->assertEqual($aRow['hour'], 18);
        $this->assertEqual($aRow['creative_id'], 1);
        $this->assertEqual($aRow['zone_id'], 3);
        $this->assertEqual($aRow['impressions'], 1);
        $this->assertEqual($aRow['clicks'], 1);
        $this->assertEqual($aRow['conversions'], 5);
        $this->assertEqual($aRow['total_basket_value'], 0);
        $this->assertEqual($aRow['total_revenue'], 20);
        $this->assertEqual($aRow['total_cost'], 10);

        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['day'], '2004-06-06');
        $this->assertEqual($aRow['hour'], 18);
        $this->assertEqual($aRow['creative_id'], 1);
        $this->assertEqual($aRow['zone_id'], 4);
        $this->assertEqual($aRow['impressions'], 1);
        $this->assertEqual($aRow['clicks'], 1);
        $this->assertEqual($aRow['conversions'], 5);
        $this->assertEqual($aRow['total_basket_value'], 0);
        $this->assertEqual($aRow['total_revenue'], 20);
        $this->assertEqual($aRow['total_cost'], 10);

        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['day'], '2004-06-06');
        $this->assertEqual($aRow['hour'], 18);
        $this->assertEqual($aRow['creative_id'], 1);
        $this->assertEqual($aRow['zone_id'], 5);
        $this->assertEqual($aRow['impressions'], 1);
        $this->assertEqual($aRow['clicks'], 1);
        $this->assertEqual($aRow['conversions'], 5);
        $this->assertEqual($aRow['total_basket_value'], 100);
        $this->assertEqual($aRow['total_revenue'], 20);
        $this->assertEqual($aRow['total_cost'], 5);

        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['day'], '2004-06-06');
        $this->assertEqual($aRow['hour'], 18);
        $this->assertEqual($aRow['creative_id'], 1);
        $this->assertEqual($aRow['zone_id'], 6);
        $this->assertEqual($aRow['impressions'], 1);
        $this->assertEqual($aRow['clicks'], 1);
        $this->assertEqual($aRow['conversions'], 5);
        $this->assertEqual($aRow['total_basket_value'], 100);
        $this->assertEqual($aRow['total_revenue'], 20);
        $this->assertEqual($aRow['total_cost'], 1.5);
        TestEnv::rollbackTransaction();

        // Test 3
        TestEnv::startTransaction();
        // Insert the test data
        $rows = $oDbh->exec(SAVE_SUMMARY_PLACEMENT);
        $rows = $oDbh->exec(SAVE_SUMMARY_AD);
        $rows = $oDbh->exec(SAVE_SUMMARY_ZONE);
        $rows = $oDbh->exec(SAVE_SUMMARY_INTERMEDIATE_AD_MULTIDAY);
        // Test
        $start = new Date('2004-06-06 18:00:00');
        $end   = new Date('2004-06-08 18:29:59');
        $dsa->saveSummary($start, $end, $aTypes, 'data_intermediate_ad', 'data_summary_ad_hourly');
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_summary_ad_hourly']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 3);
        $query = "
            SELECT
                *
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_summary_ad_hourly']}
            WHERE
                ad_id = 1
                AND creative_id = 1";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['day'], '2004-06-06');
        $this->assertEqual($aRow['hour'], 18);
        $this->assertEqual($aRow['zone_id'], 1);
        $this->assertEqual($aRow['impressions'], 1);
        $this->assertEqual($aRow['clicks'], 1);
        $this->assertEqual($aRow['conversions'], 1);
        $this->assertEqual($aRow['total_basket_value'], 1);
        $this->assertEqual($aRow['total_revenue'], 5);
        $this->assertEqual($aRow['total_cost'], 0.02);
        $query = "
            SELECT
                *
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_summary_ad_hourly']}
            WHERE
                ad_id = 1
                AND creative_id = 2";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['day'], '2004-06-07');
        $this->assertEqual($aRow['hour'], 18);
        $this->assertEqual($aRow['zone_id'], 1);
        $this->assertEqual($aRow['impressions'], 2);
        $this->assertEqual($aRow['clicks'], 2);
        $this->assertEqual($aRow['conversions'], 2);
        $this->assertEqual($aRow['total_basket_value'], 2);
        $this->assertEqual($aRow['total_revenue'], 10);
        $this->assertEqual($aRow['total_cost'], 0.04);
        $query = "
            SELECT
                *
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_summary_ad_hourly']}
            WHERE
                ad_id = 2";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['day'], '2004-06-08');
        $this->assertEqual($aRow['hour'], 18);
        $this->assertEqual($aRow['creative_id'], 1);
        $this->assertEqual($aRow['zone_id'], 1);
        $this->assertEqual($aRow['impressions'], 1);
        $this->assertEqual($aRow['clicks'], 1);
        $this->assertEqual($aRow['conversions'], 0);
        $this->assertEqual($aRow['total_basket_value'], 0);
        $this->assertEqual($aRow['total_revenue'], 2);
        $this->assertEqual($aRow['total_cost'], 0.02);
        TestEnv::rollbackTransaction();
        TestEnv::restoreConfig();
    }

    /**
     * Tests the manageCampaigns() method.
     */
    function testManageCampaigns()
    {
        $conf = &$GLOBALS['_MAX']['CONF'];
        $oDbh = &OA_DB::singleton();
        $conf['maintenance']['operationInterval'] = 60;

        $oMDMSF = new OA_Dal_Maintenance_Statistics_Factory();
        $dsa = $oMDMSF->factory("AdServer");

        $oDate = new Date();
        TestEnv::startTransaction();
        // Get the data for the tests
        include_once MAX_PATH . '/lib/max/Dal/data/TestOfStatisticsAdServermysql.php';
        // Insert the base test data
        $rows = $oDbh->exec(MANAGE_CAMPAIGNS_CAMPAIGNS);
        $rows = $oDbh->exec(MANAGE_CAMPAIGNS_CLIENTS);
        $rows = $oDbh->exec(MANAGE_CAMPAIGNS_BANNERS);
        // Test with no summarised data
        $report = $dsa->manageCampaigns($oDate);
        $query = "
            SELECT
                *
            FROM
                {$conf['table']['prefix']}{$conf['table']['campaigns']}
            WHERE
                campaignid = 1";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['views'], -1);
        $this->assertEqual($aRow['clicks'], -1);
        $this->assertEqual($aRow['conversions'], -1);
        $this->assertEqual($aRow['expire'], '0000-00-00');
        $this->assertEqual($aRow['activate'], '0000-00-00');
        $this->assertEqual($aRow['active'], 't');
        $query = "
            SELECT
                *
            FROM
                {$conf['table']['prefix']}{$conf['table']['campaigns']}
            WHERE
                campaignid = 2";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['views'], 10);
        $this->assertEqual($aRow['clicks'], -1);
        $this->assertEqual($aRow['conversions'], -1);
        $this->assertEqual($aRow['expire'], '0000-00-00');
        $this->assertEqual($aRow['activate'], '0000-00-00');
        $this->assertEqual($aRow['active'], 't');
        $query = "
            SELECT
                *
            FROM
                {$conf['table']['prefix']}{$conf['table']['campaigns']}
            WHERE
                campaignid = 3";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['views'], -1);
        $this->assertEqual($aRow['clicks'], 10);
        $this->assertEqual($aRow['conversions'], -1);
        $this->assertEqual($aRow['expire'], '0000-00-00');
        $this->assertEqual($aRow['activate'], '0000-00-00');
        $this->assertEqual($aRow['active'], 't');
        $query = "
            SELECT
                *
            FROM
                {$conf['table']['prefix']}{$conf['table']['campaigns']}
            WHERE
                campaignid = 4";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['views'], -1);
        $this->assertEqual($aRow['clicks'], -1);
        $this->assertEqual($aRow['conversions'], 10);
        $this->assertEqual($aRow['expire'], '0000-00-00');
        $this->assertEqual($aRow['activate'], '0000-00-00');
        $this->assertEqual($aRow['active'], 't');
        $query = "
            SELECT
                *
            FROM
                {$conf['table']['prefix']}{$conf['table']['campaigns']}
            WHERE
                campaignid = 5";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['views'], 10);
        $this->assertEqual($aRow['clicks'], 10);
        $this->assertEqual($aRow['conversions'], 10);
        $this->assertEqual($aRow['expire'], '0000-00-00');
        $this->assertEqual($aRow['activate'], '0000-00-00');
        $this->assertEqual($aRow['active'], 't');
        $query = "
            SELECT
                *
            FROM
                {$conf['table']['prefix']}{$conf['table']['campaigns']}
            WHERE
                campaignid = 6";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['views'], -1);
        $this->assertEqual($aRow['clicks'], -1);
        $this->assertEqual($aRow['conversions'], -1);
        $this->assertEqual($aRow['expire'], '2004-06-06');
        $this->assertEqual($aRow['activate'], '0000-00-00');
        $this->assertEqual($aRow['active'], 'f');
        $query = "
            SELECT
                *
            FROM
                {$conf['table']['prefix']}{$conf['table']['campaigns']}
            WHERE
                campaignid = 7";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['views'], -1);
        $this->assertEqual($aRow['clicks'], -1);
        $this->assertEqual($aRow['conversions'], -1);
        $this->assertEqual($aRow['expire'], '0000-00-00');
        $this->assertEqual($aRow['activate'], '2004-06-06');
        $this->assertEqual($aRow['active'], 't');
        // Insert the summary test data - Part 1
        $rows = $oDbh->exec(MANAGE_CAMPAIGNS_INTERMEDIATE_AD);
        // Test with summarised data
        $report = $dsa->manageCampaigns($oDate);
        $query = "
            SELECT
                *
            FROM
                {$conf['table']['prefix']}{$conf['table']['campaigns']}
            WHERE
                campaignid = 1";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['views'], -1);
        $this->assertEqual($aRow['clicks'], -1);
        $this->assertEqual($aRow['conversions'], -1);
        $this->assertEqual($aRow['expire'], '0000-00-00');
        $this->assertEqual($aRow['activate'], '0000-00-00');
        $this->assertEqual($aRow['active'], 't');
        $query = "
            SELECT
                *
            FROM
                {$conf['table']['prefix']}{$conf['table']['campaigns']}
            WHERE
                campaignid = 2";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['views'], 10);
        $this->assertEqual($aRow['clicks'], -1);
        $this->assertEqual($aRow['conversions'], -1);
        $this->assertEqual($aRow['expire'], '0000-00-00');
        $this->assertEqual($aRow['activate'], '0000-00-00');
        $this->assertEqual($aRow['active'], 'f');
        $query = "
            SELECT
                *
            FROM
                {$conf['table']['prefix']}{$conf['table']['campaigns']}
            WHERE
                campaignid = 3";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['views'], -1);
        $this->assertEqual($aRow['clicks'], 10);
        $this->assertEqual($aRow['conversions'], -1);
        $this->assertEqual($aRow['expire'], '0000-00-00');
        $this->assertEqual($aRow['activate'], '0000-00-00');
        $this->assertEqual($aRow['active'], 't');
        $query = "
            SELECT
                *
            FROM
                {$conf['table']['prefix']}{$conf['table']['campaigns']}
            WHERE
                campaignid = 4";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['views'], -1);
        $this->assertEqual($aRow['clicks'], -1);
        $this->assertEqual($aRow['conversions'], 10);
        $this->assertEqual($aRow['expire'], '0000-00-00');
        $this->assertEqual($aRow['activate'], '0000-00-00');
        $this->assertEqual($aRow['active'], 'f');
        $query = "
            SELECT
                *
            FROM
                {$conf['table']['prefix']}{$conf['table']['campaigns']}
            WHERE
                campaignid = 5";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['views'], 10);
        $this->assertEqual($aRow['clicks'], 10);
        $this->assertEqual($aRow['conversions'], 10);
        $this->assertEqual($aRow['expire'], '0000-00-00');
        $this->assertEqual($aRow['activate'], '0000-00-00');
        $this->assertEqual($aRow['active'], 't');
        $query = "
            SELECT
                *
            FROM
                {$conf['table']['prefix']}{$conf['table']['campaigns']}
            WHERE
                campaignid = 6";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['views'], -1);
        $this->assertEqual($aRow['clicks'], -1);
        $this->assertEqual($aRow['conversions'], -1);
        $this->assertEqual($aRow['expire'], '2004-06-06');
        $this->assertEqual($aRow['activate'], '0000-00-00');
        $this->assertEqual($aRow['active'], 'f');
        $query = "
            SELECT
                *
            FROM
                {$conf['table']['prefix']}{$conf['table']['campaigns']}
            WHERE
                campaignid = 7";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['views'], -1);
        $this->assertEqual($aRow['clicks'], -1);
        $this->assertEqual($aRow['conversions'], -1);
        $this->assertEqual($aRow['expire'], '0000-00-00');
        $this->assertEqual($aRow['activate'], '2004-06-06');
        $this->assertEqual($aRow['active'], 't');
        TestEnv::rollbackTransaction();
        // Final test to ensure that placements expired as a result of limitations met are
        // not re-activated in the event that their expiration date has not yet been reached
        TestEnv::startTransaction();
        $query = "
            INSERT INTO
                campaigns
                    (
                        campaignid,
                        campaignname,
                        clientid,
                        views,
                        clicks,
                        conversions,
                        expire,
                        activate,
                        active
                    )
                VALUES
                    (
                        1,
                        'Test Campaign 1',
                        1,
                        10,
                        -1,
                        -1,
                        '2005-12-09',
                        '2005-12-07',
                        'f'
                    )";
        $rows = $oDbh->exec($query);
        $query = "
            INSERT INTO
                clients
                    (
                        clientid,
                        contact,
                        email
                    )
                VALUES
                    (
                        1,
                        'Test Contact',
                        'postmaster@localhost'
                    )";
        $rows = $oDbh->exec($query);
        $query = "
            INSERT INTO
                banners
                    (
                        bannerid,
                        campaignid
                    )
                VALUES
                    (
                        1,
                        1
                    )";
        $rows = $oDbh->exec($query);
        $query = "
            INSERT INTO
                data_intermediate_ad
                    (
                        interval_start,
                        interval_end,
                        ad_id,
                        impressions,
                        clicks,
                        conversions
                    )
                VALUES
                    (
                        '2005-12-08 00:00:00',
                        '2004-12-08 00:59:59',
                        1,
                        100,
                        1,
                        0
                     )";
        $rows = $oDbh->exec($query);
        $oDate = &new Date('2005-12-08 01:00:01');
        $report = $dsa->manageCampaigns($oDate);
        $query = "
            SELECT
                *
            FROM
                {$conf['table']['prefix']}{$conf['table']['campaigns']}
            WHERE
                campaignid = 1";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['views'], 10);
        $this->assertEqual($aRow['clicks'], -1);
        $this->assertEqual($aRow['conversions'], -1);
        $this->assertEqual($aRow['expire'], '2005-12-09');
        $this->assertEqual($aRow['activate'], '2005-12-07');
        $this->assertEqual($aRow['active'], 'f');
        TestEnv::rollbackTransaction();
        TestEnv::restoreConfig();
    }

    /**
     * Tests the deleteOldData() method.
     */
    function testDeleteOldData()
    {
        $conf = &$GLOBALS['_MAX']['CONF'];
        $oDbh = &OA_DB::singleton();
        $conf['maintenance']['compactStatsGrace'] = 0;
        // Enable the tracker
        $conf['modules']['Tracker'] = true;

        $oMDMSF = new OA_Dal_Maintenance_Statistics_Factory();
        $dsa = $oMDMSF->factory("AdServer");

        TestEnv::startTransaction();
        // Get the data for the tests
        include_once MAX_PATH . '/lib/max/Dal/data/TestOfStatisticsAdServermysql.php';
        // Insert the test data
        $rows = $oDbh->exec(DELETE_OLD_DATA_CAMPAIGNS_TRACKERS);
        $rows = $oDbh->exec(DELETE_OLD_DATA_AD_CLICKS);
        $rows = $oDbh->exec(DELETE_OLD_DATA_AD_IMPRESSIONS);
        $rows = $oDbh->exec(DELETE_OLD_DATA_AD_REQUESTS);
        // Test
        $summarisedTo = new Date('2004-06-06 17:59:59');
        $dsa->deleteOldData($summarisedTo);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_click']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 3);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_impression']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 3);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_request']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 1);
        TestEnv::rollbackTransaction();
        // Disable the tracker
        $conf['modules']['Tracker'] = false;
        $dsa = $oMDMSF->factory("AdServer");
        TestEnv::startTransaction();
        // Insert the test data
        $rows = $oDbh->exec(DELETE_OLD_DATA_AD_CLICKS);
        $rows = $oDbh->exec(DELETE_OLD_DATA_AD_IMPRESSIONS);
        $rows = $oDbh->exec(DELETE_OLD_DATA_AD_REQUESTS);
        // Test
        $summarisedTo = new Date('2004-06-06 17:59:59');
        $dsa->deleteOldData($summarisedTo);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_click']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_impression']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 1);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_request']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 1);
        TestEnv::rollbackTransaction();
        // Set a compact_stats_grace window
        $conf['maintenance']['compactStatsGrace'] = 3600;
        // Enable the tracker
        $conf['modules']['Tracker'] = true;
        $dsa = $oMDMSF->factory("AdServer");
        TestEnv::startTransaction();
        // Insert the test data
        $rows = $oDbh->exec(DELETE_OLD_DATA_CAMPAIGNS_TRACKERS);
        $rows = $oDbh->exec(DELETE_OLD_DATA_AD_CLICKS);
        $rows = $oDbh->exec(DELETE_OLD_DATA_AD_IMPRESSIONS);
        $rows = $oDbh->exec(DELETE_OLD_DATA_AD_REQUESTS);
        // Test
        $summarisedTo = new Date('2004-06-06 17:59:59');
        $dsa->deleteOldData($summarisedTo);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_click']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 5);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_impression']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 5);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_request']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 3);
        TestEnv::rollbackTransaction();
        // Disable the tracker
        $conf['modules']['Tracker'] = false;
        $dsa = $oMDMSF->factory("AdServer");
        TestEnv::startTransaction();
        // Insert the test data
        $rows = $oDbh->exec(DELETE_OLD_DATA_AD_CLICKS);
        $rows = $oDbh->exec(DELETE_OLD_DATA_AD_IMPRESSIONS);
        $rows = $oDbh->exec(DELETE_OLD_DATA_AD_REQUESTS);
        // Test
        $summarisedTo = new Date('2004-06-06 17:59:59');
        $dsa->deleteOldData($summarisedTo);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_click']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 3);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_impression']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 3);
        $query = "
            SELECT
                COUNT(*) AS number
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_raw_ad_request']}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual($aRow['number'], 3);
        TestEnv::rollbackTransaction();
        TestEnv::restoreConfig();
    }

}

?>
