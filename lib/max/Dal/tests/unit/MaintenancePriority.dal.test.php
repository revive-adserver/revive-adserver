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
require_once MAX_PATH . '/lib/max/Dal/Maintenance/Priority.php';
require_once MAX_PATH . '/lib/max/Entity/Ad.php';
require_once MAX_PATH . '/lib/max/Maintenance/Priority/Entities.php';
require_once MAX_PATH . '/lib/openads/Table/Priority.php';
require_once 'Date.php';
require_once 'DB/QueryTool.php';

/**
 * A class for testing the MAX_Dal_Maintenance_Priority class.
 *
 * @package    MaxDal
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew@m3.net>
 * @author     Demian Turner <demian@m3.net>
 * @author     James Floyd <james@m3.net>
 */
class Dal_TestOfMAX_Dal_Maintenance_Priority extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function Dal_TestOfMAX_Dal_Maintenance_Priority()
    {
        $this->UnitTestCase();
    }

    /**
     * Method to test the setMaintenancePriorityLastRunInfo method.
     *
     * Requirements:
     * Test 1: Test with no data in the database, ensure data is correctly stored.
     * Test 2: Test with previous test data in the database, ensure data is correctly stored.
     */
    function testSetMaintenancePriorityLastRunInfo()
    {
        // Test relies on transaction numbers, so ensure fresh database used
        TestEnv::restoreEnv();

        TestEnv::startTransaction();
        $conf = $GLOBALS['_MAX']['CONF'];
        $dbh = &MAX_DB::singleton();
        $oMaxDalMaintenance = new MAX_Dal_Maintenance_Priority();

        // Test 1
        $oStartDate = new Date('2005-06-21 15:00:01');
        $oEndDate   = new Date('2005-06-21 15:01:01');
        $oUpdatedTo = new Date('2005-06-21 15:59:59');
        $result = $oMaxDalMaintenance->setMaintenancePriorityLastRunInfo($oStartDate, $oEndDate, $oUpdatedTo, DAL_PRIORITY_UPDATE_ZIF);
        $this->assertEqual($result, 1);
        $query = "
            SELECT
                start_run,
                end_run,
                operation_interval,
                duration,
                run_type,
                updated_to
            FROM
                {$conf['table']['prefix']}{$conf['table']['log_maintenance_priority']}
            WHERE
                log_maintenance_priority_id = 1";
        $row = $dbh->getRow($query);
        $this->assertEqual($row['start_run'], '2005-06-21 15:00:01');
        $this->assertEqual($row['end_run'], '2005-06-21 15:01:01');
        $this->assertEqual($row['operation_interval'], $conf['maintenance']['operationInterval']);
        $this->assertEqual($row['duration'], 60);
        $this->assertEqual($row['run_type'], DAL_PRIORITY_UPDATE_ZIF);
        $this->assertEqual($row['updated_to'], '2005-06-21 15:59:59');

        // Test 2
        $oStartDate = new Date('2005-06-21 16:00:01');
        $oEndDate   = new Date('2005-06-21 16:01:06');
        $oUpdatedTo = new Date('2005-06-21 16:59:59');
        $result = $oMaxDalMaintenance->setMaintenancePriorityLastRunInfo($oStartDate, $oEndDate, $oUpdatedTo, DAL_PRIORITY_UPDATE_PRIORITY_COMPENSATION);
        $this->assertEqual($result, 1);
        $query = "
            SELECT
                start_run,
                end_run,
                operation_interval,
                duration,
                run_type,
                updated_to
            FROM
                {$conf['table']['prefix']}{$conf['table']['log_maintenance_priority']}
            WHERE
                log_maintenance_priority_id = 1";
        $row = $dbh->getRow($query);
        $this->assertEqual($row['start_run'], '2005-06-21 15:00:01');
        $this->assertEqual($row['end_run'], '2005-06-21 15:01:01');
        $this->assertEqual($row['operation_interval'], $conf['maintenance']['operationInterval']);
        $this->assertEqual($row['duration'], 60);
        $this->assertEqual($row['run_type'], DAL_PRIORITY_UPDATE_ZIF);
        $this->assertEqual($row['updated_to'], '2005-06-21 15:59:59');
        $query = "
            SELECT
                start_run,
                end_run,
                operation_interval,
                duration,
                run_type,
                updated_to
            FROM
                {$conf['table']['prefix']}{$conf['table']['log_maintenance_priority']}
            WHERE
                log_maintenance_priority_id = 2";
        $row = $dbh->getRow($query);
        $this->assertEqual($row['start_run'], '2005-06-21 16:00:01');
        $this->assertEqual($row['end_run'], '2005-06-21 16:01:06');
        $this->assertEqual($row['operation_interval'], $conf['maintenance']['operationInterval']);
        $this->assertEqual($row['duration'], 65);
        $this->assertEqual($row['run_type'], DAL_PRIORITY_UPDATE_PRIORITY_COMPENSATION);
        $this->assertEqual($row['updated_to'], '2005-06-21 16:59:59');

        TestEnv::rollbackTransaction();
    }

    /**
     * Method to test the getMaintenancePriorityLastRunInfo method.
     *
     * Requirements:
     * Test 1: Test correct results are returned with no data.
     * Test 2: Test correct results are returned with single data entry.
     * Test 3: Test correct results are returned with multiple data entries.
     * Test 4: Test correct results are returned with multiple run types.
     */
    function testGetMaintenancePriorityLastRunInfo()
    {
        TestEnv::startTransaction();
        $conf = $GLOBALS['_MAX']['CONF'];
        $dbh = &MAX_DB::singleton();
        $oMaxDalMaintenance = new MAX_Dal_Maintenance_Priority();

        // Test 1
        $result = $oMaxDalMaintenance->getMaintenancePriorityLastRunInfo(DAL_PRIORITY_UPDATE_ZIF);
        $this->assertFalse($result);

        // Test 2
        $oStartDate = new Date('2005-06-21 15:00:01');
        $oEndDate   = new Date('2005-06-21 15:01:01');
        $oUpdatedTo = new Date('2005-06-21 15:59:59');
        $oMaxDalMaintenance->setMaintenancePriorityLastRunInfo($oStartDate, $oEndDate, $oUpdatedTo, DAL_PRIORITY_UPDATE_ZIF);
        $result = $oMaxDalMaintenance->getMaintenancePriorityLastRunInfo(DAL_PRIORITY_UPDATE_ZIF);
        $this->assertTrue(is_array($result));
        $this->assertEqual($result['updated_to'], '2005-06-21 15:59:59');
        $this->assertEqual($result['operation_interval'], $conf['maintenance']['operationInterval']);

        // Test 3
        $oStartDate = new Date('2005-06-21 14:00:01');
        $oEndDate   = new Date('2005-06-21 14:01:01');
        $oUpdatedTo = new Date('2005-06-21 14:59:59');
        $oMaxDalMaintenance->setMaintenancePriorityLastRunInfo($oStartDate, $oEndDate, $oUpdatedTo, DAL_PRIORITY_UPDATE_ZIF);
        $result = $oMaxDalMaintenance->getMaintenancePriorityLastRunInfo(DAL_PRIORITY_UPDATE_ZIF);
        $this->assertTrue(is_array($result));
        $this->assertEqual($result['updated_to'], '2005-06-21 15:59:59');
        $this->assertEqual($result['operation_interval'], $conf['maintenance']['operationInterval']);
        $oStartDate = new Date('2005-06-21 16:00:01');
        $oEndDate   = new Date('2005-06-21 16:01:01');
        $oUpdatedTo = new Date('2005-06-21 16:59:59');
        $oMaxDalMaintenance->setMaintenancePriorityLastRunInfo($oStartDate, $oEndDate, $oUpdatedTo, DAL_PRIORITY_UPDATE_ZIF);
        $result = $oMaxDalMaintenance->getMaintenancePriorityLastRunInfo(DAL_PRIORITY_UPDATE_ZIF);
        $this->assertTrue(is_array($result));
        $this->assertEqual($result['updated_to'], '2005-06-21 16:59:59');
        $this->assertEqual($result['operation_interval'], $conf['maintenance']['operationInterval']);

        // Test 4
        $result = $oMaxDalMaintenance->getMaintenancePriorityLastRunInfo(DAL_PRIORITY_UPDATE_PRIORITY_COMPENSATION);
        $this->assertFalse($result);

        TestEnv::rollbackTransaction();
    }

    /**
     * A method to test the getPlacements method.
     */
    function testGetPlacements()
    {
        $da = new MAX_Dal_Maintenance_Priority();
        TestEnv::startTransaction();
        $this->_generateStatsOne();
        $ret = $da->getPlacements();

        $this->assertTrue(is_array($ret));
        $this->assertTrue(count($ret) == 5);
        $campaign = $ret[0];
        $this->assertTrue(array_key_exists('campaignid', $campaign));
        $this->assertTrue(array_key_exists('views', $campaign));
        $this->assertTrue(array_key_exists('clicks', $campaign));
        $this->assertTrue(array_key_exists('conversions', $campaign));
        $this->assertTrue(array_key_exists('activate', $campaign));
        $this->assertTrue(array_key_exists('expire', $campaign));
        $this->assertTrue(array_key_exists('target_impression', $campaign));
        $this->assertTrue(array_key_exists('target_click', $campaign));
        $this->assertTrue(array_key_exists('target_conversion', $campaign));
        $this->assertTrue(array_key_exists('priority', $campaign));
        TestEnv::rollbackTransaction();
    }

    /**
     * A method to test the getPlacementData method.
     */
    function testGetPlacementData()
    {
        $da = new MAX_Dal_Maintenance_Priority();
        TestEnv::startTransaction();
        $this->_generateStatsOne();
        $ret = $da->getPlacementData(1);
        $this->assertTrue(is_array($ret));
        $this->assertTrue(count($ret) == 1);
        $campaign = $ret[0];
        $this->assertTrue(array_key_exists('advertiser_id', $campaign));
        $this->assertTrue(array_key_exists('placement_id', $campaign));
        $this->assertTrue(array_key_exists('name', $campaign));
        $this->assertTrue(array_key_exists('active', $campaign));
        $this->assertTrue(array_key_exists('num_children', $campaign));
        TestEnv::rollbackTransaction();
    }

    /**
     * Method to test the getPlacementDeliveryToDate method.
     *
     * Requirements:
     * Test 1: Test correct results are returned with no data.
     * Test 2: Test correct results are returned with single data entry.
     * Test 3: Test correct results are returned with multiple data entries.
     *
     * @TODO Incomplete test!
     */
    function testGetPlacementDeliveryToDate()
    {
        TestEnv::startTransaction();
        $conf = $GLOBALS['_MAX']['CONF'];
        $dbh = &MAX_DB::singleton();
        $oMaxDalMaintenance = new MAX_Dal_Maintenance_Priority();

        // Test 1
        $result = $oMaxDalMaintenance->getPlacementDeliveryToDate(1);
        $this->assertTrue(is_array($result));
        $this->assertEqual(count($result), 0);

        // Test 2
        $today = '2005-06-24';
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['campaigns']}
                (
                    campaignid,
                    activate,
                    expire,
                    priority,
                    active,
                    views,
                    clicks,
                    conversions
                )
            VALUES
                (
                    1,
                    '2005-06-23',
                    '2005-06-25',
                    1,
                    't',
                    100,
                    200,
                    300
                )";
        $result = $dbh->query($query);
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['banners']}
                (
                    campaignid,
                    bannerid
                )
            VALUES
                (
                    1,
                    1
                )";
        $result = $dbh->query($query);
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad']}
                (
                    day,
                    hour,
                    ad_id,
                    requests,
                    impressions,
                    clicks,
                    conversions
                )
            VALUES
                (
                    '2005-06-24',
                    10,
                    1,
                    500,
                    475,
                    25,
                    5
                ),
                (
                    '2005-06-24',
                    11,
                    1,
                    500,
                    475,
                    25,
                    5
                )";
        $result = $dbh->query($query);
        $result = $oMaxDalMaintenance->getPlacementDeliveryToDate(1);
        $this->assertTrue(is_array($result));
        $this->assertEqual(count($result), 1);
        $this->assertEqual($result[0]['placement_id'], 1);
        $this->assertEqual($result[0]['sum_requests'], 1000);
        $this->assertEqual($result[0]['sum_views'], 950);
        $this->assertEqual($result[0]['sum_clicks'], 50);
        $this->assertEqual($result[0]['sum_conversions'], 10);
        /*

        // Test 3
        $oStartDate = new Date('2005-06-21 14:00:01');
        $oEndDate   = new Date('2005-06-21 14:01:01');
        $oUpdatedTo = new Date('2005-06-21 14:59:59');
        $oMaxDalMaintenance->setMaintenancePriorityLastRunInfo($oStartDate, $oEndDate, $oUpdatedTo);
        $result = $oMaxDalMaintenance->getMaintenancePriorityLastRunInfo(DAL_PRIORITY_UPDATE_ZIF);
        $this->assertTrue(is_array($result));
        $this->assertEqual($result['updated_to'], '2005-06-21 15:59:59');
        $this->assertEqual($result['operation_interval'], $conf['maintenance']['operationInterval']);
        $oStartDate = new Date('2005-06-21 16:00:01');
        $oEndDate   = new Date('2005-06-21 16:01:01');
        $oUpdatedTo = new Date('2005-06-21 16:59:59');
        $oMaxDalMaintenance->setMaintenancePriorityLastRunInfo($oStartDate, $oEndDate, $oUpdatedTo);
        $result = $oMaxDalMaintenance->getMaintenancePriorityLastRunInfo(DAL_PRIORITY_UPDATE_ZIF);
        $this->assertTrue(is_array($result));
        $this->assertEqual($result['updated_to'], '2005-06-21 16:59:59');
        $this->assertEqual($result['operation_interval'], $conf['maintenance']['operationInterval']);
        */

        TestEnv::rollbackTransaction();
    }

    /**
     * A method to test the getPlacementDeliveryToday method.
     *
     * @TODO Not implemented.
     */
    function testGetPlacementDeliveryToday()
    {
    }

    /**
     * A method to test the getPlacementStats method.
     */
    function testGetPlacementStats()
    {
        $da = new MAX_Dal_Maintenance_Priority();
        TestEnv::startTransaction();
        $this->_generateStatsOne();
        $ret = $da->getPlacementStats(1);

        $this->assertTrue(is_array($ret));
        $this->assertTrue(count($ret) == 9);

        $this->assertTrue(array_key_exists('advertiser_id', $ret));
        $this->assertTrue(array_key_exists('placement_id', $ret));
        $this->assertTrue(array_key_exists('name', $ret));
        $this->assertTrue(array_key_exists('active', $ret));
        $this->assertTrue(array_key_exists('num_children', $ret));
        $this->assertTrue(array_key_exists('sum_requests', $ret));
        $this->assertTrue(array_key_exists('sum_views', $ret));
        $this->assertTrue(array_key_exists('sum_clicks', $ret));
        $this->assertTrue(array_key_exists('sum_conversions', $ret));
        TestEnv::rollbackTransaction();
    }

    /**
     * Method to test the getAllZonesWithAllocInv method.
     *
     * Requirements:
     * Test 1: Test with no data, and ensure no data returned.
     * Test 2: Test with sample data, and ensure the correct data is returned.
     */
    function testGetAllZonesWithAllocInv()
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $dbh = &MAX_DB::singleton();
        $oMaxDalMaintenance = new MAX_Dal_Maintenance_Priority();

        // Create the required temporary table for the tests
        $oTable = &Openads_Table_Priority::singleton();
        $oTable->createTable('tmp_ad_zone_impression');

        // Test 1
        $result = &$oMaxDalMaintenance->getAllZonesWithAllocInv();
        $this->assertEqual(count($result), 0);

        // Test 2
        $query = "
            INSERT INTO
                tmp_ad_zone_impression
                (
                    ad_id,
                    zone_id,
                    required_impressions,
                    requested_impressions
                )
            VALUES
                (
                    1,
                    1,
                    2,
                    3
                ),
                (
                    1,
                    2,
                    4,
                    5
                ),
                (
                    2,
                    2,
                    6,
                    7
                )";
    	TestEnv::startTransaction();
        $dbh->query($query);
        $result = &$oMaxDalMaintenance->getAllZonesWithAllocInv();
        $this->assertEqual(count($result), 3);
        $this->assertEqual($result[0]['zone_id'], 1);
        $this->assertEqual($result[0]['ad_id'], 1);
        $this->assertEqual($result[0]['required_impressions'], 2);
        $this->assertEqual($result[0]['requested_impressions'], 3);
        $this->assertEqual($result[1]['zone_id'], 2);
        $this->assertEqual($result[1]['ad_id'], 1);
        $this->assertEqual($result[1]['required_impressions'], 4);
        $this->assertEqual($result[1]['requested_impressions'], 5);
        $this->assertEqual($result[2]['zone_id'], 2);
        $this->assertEqual($result[2]['ad_id'], 2);
        $this->assertEqual($result[2]['required_impressions'], 6);
        $this->assertEqual($result[2]['requested_impressions'], 7);
        TestEnv::restoreEnv();
    }

    /**
     * Method to test the getAllZonesImpInv method.
     *
     * Requirements:
     * Test 1: Test with no Date registered in the service locator, ensure false returned.
     * Test 2: Test with a Date registered in the service locator, no data in the database,
     *         and ensure no data is returned.
     * Test 3: Test with data NOT in the current OI, and ensure no data is returned.
     * Test 4: Test with data both in, and not in, the current OI, and ensure the correct
     *         data is returned.
     * Test 5: Repeat Test 4, but with additional zones (that don't have data) in the zones
     *         table.
     */
    function testGetAllZonesImpInv()
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $dbh = &MAX_DB::singleton();
        $oMaxDalMaintenance = new MAX_Dal_Maintenance_Priority();

        // Test 1
        $oServiceLocator = &ServiceLocator::instance();
        $oServiceLocator->remove('now');
        $result = &$oMaxDalMaintenance->getAllZonesImpInv();
        $this->assertFalse($result);

        // Test 2
        $oDate = new Date();
        $oServiceLocator->register('now', $oDate);
        $result = &$oMaxDalMaintenance->getAllZonesImpInv();
        $this->assertEqual(count($result), 0);

        // Test 3
        TestEnv::startTransaction();
        $oDate = &$oServiceLocator->get('now');
        $oNewDate = new Date();
        $oNewDate->copy($oDate);
        $oNewDate->subtractSeconds(($conf['maintenance']['operationInterval'] * 60) + 1);
        $previousOptIntID = MAX_OperationInterval::convertDateToOperationIntervalID($oNewDate);
        $aDates = MAX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oNewDate);
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_summary_zone_impression_history']}
                (
                    operation_interval,
                    operation_interval_id,
                    interval_start,
                    interval_end,
                    zone_id,
                    forecast_impressions
                )
            VALUES
                (
                    {$conf['maintenance']['operationInterval']},
                    $previousOptIntID,
                    '" . $aDates['start']->format('%Y-%m-%d %H:%M:%S') . "',
                    '" . $aDates['end']->format('%Y-%m-%d %H:%M:%S') . "',
                    1,
                    42
                )";
        $dbh->query($query);
        $oNewDate = new Date();
        $oNewDate->copy($aDates['start']);
        $oNewDate->subtractSeconds(1);
        $previousPreviousOpIntID = MAX_OperationInterval::convertDateToOperationIntervalID($oNewDate);
        $aDates = MAX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oNewDate);
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_summary_zone_impression_history']}
                (
                    operation_interval,
                    operation_interval_id,
                    interval_start,
                    interval_end,
                    zone_id,
                    actual_impressions
                )
            VALUES
                (
                    {$conf['maintenance']['operationInterval']},
                    $previousPreviousOpIntID,
                    '" . $aDates['start']->format('%Y-%m-%d %H:%M:%S') . "',
                    '" . $aDates['end']->format('%Y-%m-%d %H:%M:%S') . "',
                    1,
                    37
                )";
        $dbh->query($query);
        $result = &$oMaxDalMaintenance->getAllZonesImpInv();
        $this->assertEqual(count($result), 0);
        TestEnv::rollbackTransaction();

        // Test 4
        TestEnv::startTransaction();
        $oDate = &$oServiceLocator->get('now');
        $currentOpIntID = MAX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $aDates = MAX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oDate);
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_summary_zone_impression_history']}
                (
                    operation_interval,
                    operation_interval_id,
                    interval_start,
                    interval_end,
                    zone_id,
                    forecast_impressions,
                    actual_impressions
                )
            VALUES
                (
                    {$conf['maintenance']['operationInterval']},
                    $currentOpIntID,
                    '" . $aDates['start']->format('%Y-%m-%d %H:%M:%S') . "',
                    '" . $aDates['end']->format('%Y-%m-%d %H:%M:%S') . "',
                    1,
                    42,
                    NULL
                ),
                (
                    {$conf['maintenance']['operationInterval']},
                    $currentOpIntID,
                    '" . $aDates['start']->format('%Y-%m-%d %H:%M:%S') . "',
                    '" . $aDates['end']->format('%Y-%m-%d %H:%M:%S') . "',
                    2,
                    1,
                    2
                )";
        $dbh->query($query);
        $oNewDate = new Date();
        $oNewDate->copy($oDate);
        $oNewDate->subtractSeconds(($conf['maintenance']['operationInterval'] * 60) + 1);
        $previousOptIntID = MAX_OperationInterval::convertDateToOperationIntervalID($oNewDate);
        $aDates = MAX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oNewDate);
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_summary_zone_impression_history']}
                (
                    operation_interval,
                    operation_interval_id,
                    interval_start,
                    interval_end,
                    zone_id,
                    forecast_impressions,
                    actual_impressions
                )
            VALUES
                (
                    {$conf['maintenance']['operationInterval']},
                    $previousOptIntID,
                    '" . $aDates['start']->format('%Y-%m-%d %H:%M:%S') . "',
                    '" . $aDates['end']->format('%Y-%m-%d %H:%M:%S') . "',
                    1,
                    37,
                    11
                ),
                (
                    {$conf['maintenance']['operationInterval']},
                    $previousOptIntID,
                    '" . $aDates['start']->format('%Y-%m-%d %H:%M:%S') . "',
                    '" . $aDates['end']->format('%Y-%m-%d %H:%M:%S') . "',
                    2,
                    3,
                    4
                ),
                (
                    {$conf['maintenance']['operationInterval']},
                    $previousOptIntID,
                    '" . $aDates['start']->format('%Y-%m-%d %H:%M:%S') . "',
                    '" . $aDates['end']->format('%Y-%m-%d %H:%M:%S') . "',
                    3,
                    5,
                    6
                )";
        $dbh->query($query);
        $oNewDate = new Date();
        $oNewDate->copy($aDates['start']);
        $oNewDate->subtractSeconds(1);
        $previousPreviousOpIntID = MAX_OperationInterval::convertDateToOperationIntervalID($oNewDate);
        $aDates = MAX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oNewDate);
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_summary_zone_impression_history']}
                (
                    operation_interval,
                    operation_interval_id,
                    interval_start,
                    interval_end,
                    zone_id,
                    forecast_impressions,
                    actual_impressions
                )
            VALUES
                (
                    {$conf['maintenance']['operationInterval']},
                    $previousPreviousOpIntID,
                    '" . $aDates['start']->format('%Y-%m-%d %H:%M:%S') . "',
                    '" . $aDates['end']->format('%Y-%m-%d %H:%M:%S') . "',
                    1,
                    10,
                    9
                )";
        $dbh->query($query);
        $result = &$oMaxDalMaintenance->getAllZonesImpInv();
        $this->assertEqual(count($result), 2);
        $this->assertEqual($result[1]['zone_id'], 1);
        $this->assertEqual($result[1]['forecast_impressions'], 42);
        $this->assertEqual($result[1]['actual_impressions'], 11);
        $this->assertEqual($result[2]['zone_id'], 2);
        $this->assertEqual($result[2]['forecast_impressions'], 1);
        $this->assertEqual($result[2]['actual_impressions'], 4);
        TestEnv::rollbackTransaction();

        // Test 5
        TestEnv::startTransaction();
        $oDate = &$oServiceLocator->get('now');
        $currentOpIntID = MAX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $aDates = MAX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oDate);
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['zones']}
                (
                    zoneid
                )
            VALUES
                (
                    1
                ),
                (
                    2
                ),
                (
                    3
                )";
        $dbh->query($query);
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_summary_zone_impression_history']}
                (
                    operation_interval,
                    operation_interval_id,
                    interval_start,
                    interval_end,
                    zone_id,
                    forecast_impressions,
                    actual_impressions
                )
            VALUES
                (
                    {$conf['maintenance']['operationInterval']},
                    $currentOpIntID,
                    '" . $aDates['start']->format('%Y-%m-%d %H:%M:%S') . "',
                    '" . $aDates['end']->format('%Y-%m-%d %H:%M:%S') . "',
                    1,
                    42,
                    NULL
                ),
                (
                    {$conf['maintenance']['operationInterval']},
                    $currentOpIntID,
                    '" . $aDates['start']->format('%Y-%m-%d %H:%M:%S') . "',
                    '" . $aDates['end']->format('%Y-%m-%d %H:%M:%S') . "',
                    2,
                    1,
                    2
                )";
        $dbh->query($query);
        $oNewDate = new Date();
        $oNewDate->copy($oDate);
        $oNewDate->subtractSeconds(($conf['maintenance']['operationInterval'] * 60) + 1);
        $previousOptIntID = MAX_OperationInterval::convertDateToOperationIntervalID($oNewDate);
        $aDates = MAX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oNewDate);
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_summary_zone_impression_history']}
                (
                    operation_interval,
                    operation_interval_id,
                    interval_start,
                    interval_end,
                    zone_id,
                    forecast_impressions,
                    actual_impressions
                )
            VALUES
                (
                    {$conf['maintenance']['operationInterval']},
                    $previousOptIntID,
                    '" . $aDates['start']->format('%Y-%m-%d %H:%M:%S') . "',
                    '" . $aDates['end']->format('%Y-%m-%d %H:%M:%S') . "',
                    1,
                    37,
                    11
                ),
                (
                    {$conf['maintenance']['operationInterval']},
                    $previousOptIntID,
                    '" . $aDates['start']->format('%Y-%m-%d %H:%M:%S') . "',
                    '" . $aDates['end']->format('%Y-%m-%d %H:%M:%S') . "',
                    2,
                    3,
                    4
                ),
                (
                    {$conf['maintenance']['operationInterval']},
                    $previousOptIntID,
                    '" . $aDates['start']->format('%Y-%m-%d %H:%M:%S') . "',
                    '" . $aDates['end']->format('%Y-%m-%d %H:%M:%S') . "',
                    3,
                    5,
                    6
                )";
        $dbh->query($query);
        $oNewDate = new Date();
        $oNewDate->copy($aDates['start']);
        $oNewDate->subtractSeconds(1);
        $previousPreviousOpIntID = MAX_OperationInterval::convertDateToOperationIntervalID($oNewDate);
        $aDates = MAX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oNewDate);
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_summary_zone_impression_history']}
                (
                    operation_interval,
                    operation_interval_id,
                    interval_start,
                    interval_end,
                    zone_id,
                    forecast_impressions,
                    actual_impressions
                )
            VALUES
                (
                    {$conf['maintenance']['operationInterval']},
                    $previousPreviousOpIntID,
                    '" . $aDates['start']->format('%Y-%m-%d %H:%M:%S') . "',
                    '" . $aDates['end']->format('%Y-%m-%d %H:%M:%S') . "',
                    1,
                    10,
                    9
                )";
        $dbh->query($query);
        $result = &$oMaxDalMaintenance->getAllZonesImpInv();
        $this->assertEqual(count($result), 3);
        $this->assertEqual($result[1]['zone_id'], 1);
        $this->assertEqual($result[1]['forecast_impressions'], 42);
        $this->assertEqual($result[1]['actual_impressions'], 11);
        $this->assertEqual($result[2]['zone_id'], 2);
        $this->assertEqual($result[2]['forecast_impressions'], 1);
        $this->assertEqual($result[2]['actual_impressions'], 4);
        $this->assertEqual($result[3]['zone_id'], 3);
        $this->assertEqual($result[3]['forecast_impressions'], $conf['priority']['defaultZoneForecastImpressions']);
        $this->assertEqual($result[3]['actual_impressions'], 0);
        TestEnv::rollbackTransaction();
    }

    /**
     * Method to test the getAllDeliveryLimitationChangedAds method.
     *
     * Requirements:
     * Test 0: Test with bad input data, and ensure the method survives.
     * Test 1: Test with no data, and ensure no data are returned.
     * Test 2: Test with an active ad that has not had any delivery limitation changes,
     *         and ensure that no data are returned.
     * Test 3: Test with an active ad that has had a delivery limitation change in the
     *         last OI, before the last Priority Compensation run, and ensure that no
     *         data are returned.
     * Test 4: Test with an active ad that has had a delivery limitation change in the
     *         last OI, after the last Priority Compensation run, and ensure that the
     *         correct data are returned.
     * Test 5: Test with an active ad that has had a delivery limitation change in the
     *         current OI, and ensure that the correct data are returned.
     * Test 6: Repeat test 3, but with an inactive ad.
     * Test 7: Repeat test 4, but with an inactive ad.
     * Test 8: Repeat test 5, but with an inactive ad.
     * Test 9: Test with a mixture of ads, and ensure the correct data are returned.
     */
    function testGetAllDeliveryLimitationChangedAds()
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $dbh = &MAX_DB::singleton();
        $oMaxDalMaintenance = new MAX_Dal_Maintenance_Priority();

        $oDateNow = new Date('2006-10-04 12:07:01');
        $oDateLastPC = new Date('2006-10-04 11:14:53');
        $aLastRun = array(
            'start_run' => $oDateLastPC,
            'now'       => $oDateNow
        );

        // Test 0
        $aResult = &$oMaxDalMaintenance->getAllDeliveryLimitationChangedAds(array());
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 0);

        // Test 1
        $aResult = &$oMaxDalMaintenance->getAllDeliveryLimitationChangedAds($aLastRun);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 0);

        // Test 2
        TestEnv::startTransaction();
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['campaigns']}
                (
                    campaignid,
                    active
                )
            VALUES
                (
                    1,
                    't'
                )";
        $dbh->query($query);
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['banners']}
                (
                    bannerid,
                    campaignid,
                    active,
                    acls_updated

                )
            VALUES
                (
                    1,
                    1,
                    't',
                    ''
                )";
        $dbh->query($query);
        $aResult = &$oMaxDalMaintenance->getAllDeliveryLimitationChangedAds($aLastRun);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 0);
        TestEnv::rollbackTransaction();

        // Test 3
        TestEnv::startTransaction();
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['campaigns']}
                (
                    campaignid,
                    active
                )
            VALUES
                (
                    1,
                    't'
                )";
        $dbh->query($query);
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['banners']}
                (
                    bannerid,
                    campaignid,
                    active,
                    acls_updated

                )
            VALUES
                (
                    1,
                    1,
                    't',
                    '2006-10-04 11:10:00'
                )";
        $dbh->query($query);
        $aResult = &$oMaxDalMaintenance->getAllDeliveryLimitationChangedAds($aLastRun);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 0);
        TestEnv::rollbackTransaction();

        // Test 4
        TestEnv::startTransaction();
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['campaigns']}
                (
                    campaignid,
                    active
                )
            VALUES
                (
                    1,
                    't'
                )";
        $dbh->query($query);
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['banners']}
                (
                    bannerid,
                    campaignid,
                    active,
                    acls_updated

                )
            VALUES
                (
                    1,
                    1,
                    't',
                    '2006-10-04 11:15:00'
                )";
        $dbh->query($query);
        $aResult = &$oMaxDalMaintenance->getAllDeliveryLimitationChangedAds($aLastRun);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 1);
        $this->assertEqual($aResult[1], '2006-10-04 11:15:00');
        TestEnv::rollbackTransaction();

        // Test 5
        TestEnv::startTransaction();
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['campaigns']}
                (
                    campaignid,
                    active
                )
            VALUES
                (
                    1,
                    't'
                )";
        $dbh->query($query);
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['banners']}
                (
                    bannerid,
                    campaignid,
                    active,
                    acls_updated

                )
            VALUES
                (
                    1,
                    1,
                    't',
                    '2006-10-04 12:15:00'
                )";
        $dbh->query($query);
        $aResult = &$oMaxDalMaintenance->getAllDeliveryLimitationChangedAds($aLastRun);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 1);
        $this->assertEqual($aResult[1], '2006-10-04 12:15:00');
        TestEnv::rollbackTransaction();

        // Test 6
        TestEnv::startTransaction();
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['campaigns']}
                (
                    campaignid,
                    active
                )
            VALUES
                (
                    1,
                    'f'
                )";
        $dbh->query($query);
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['banners']}
                (
                    bannerid,
                    campaignid,
                    active,
                    acls_updated

                )
            VALUES
                (
                    1,
                    1,
                    't',
                    '2006-10-04 11:10:00'
                )";
        $dbh->query($query);
        $aResult = &$oMaxDalMaintenance->getAllDeliveryLimitationChangedAds($aLastRun);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 0);
        TestEnv::rollbackTransaction();

        // Test 7
        TestEnv::startTransaction();
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['campaigns']}
                (
                    campaignid,
                    active
                )
            VALUES
                (
                    1,
                    'f'
                )";
        $dbh->query($query);
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['banners']}
                (
                    bannerid,
                    campaignid,
                    active,
                    acls_updated

                )
            VALUES
                (
                    1,
                    1,
                    't',
                    '2006-10-04 11:15:00'
                )";
        $dbh->query($query);
        $aResult = &$oMaxDalMaintenance->getAllDeliveryLimitationChangedAds($aLastRun);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 0);
        TestEnv::rollbackTransaction();

        // Test 8
        TestEnv::startTransaction();
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['campaigns']}
                (
                    campaignid,
                    active
                )
            VALUES
                (
                    1,
                    't'
                )";
        $dbh->query($query);
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['banners']}
                (
                    bannerid,
                    campaignid,
                    active,
                    acls_updated

                )
            VALUES
                (
                    1,
                    1,
                    'f',
                    '2006-10-04 12:15:00'
                )";
        $dbh->query($query);
        $aResult = &$oMaxDalMaintenance->getAllDeliveryLimitationChangedAds($aLastRun);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 0);
        TestEnv::rollbackTransaction();

        // Test 9
        TestEnv::startTransaction();
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['campaigns']}
                (
                    campaignid,
                    active
                )
            VALUES
                (
                    1,
                    't'
                ),
                (
                    2,
                    't'
                ),
                (
                    3,
                    'f'
                )";
        $dbh->query($query);
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['banners']}
                (
                    bannerid,
                    campaignid,
                    active,
                    acls_updated

                )
            VALUES
                (
                    1,
                    1,
                    't',
                    '2006-10-04 11:30:00'
                ),
                (
                    2,
                    1,
                    't',
                    '2006-10-04 10:15:00'
                ),
                (
                    3,
                    2,
                    'f',
                    '2006-10-04 12:06:00'
                ),
                (
                    4,
                    2,
                    't',
                    '2006-10-04 12:15:00'
                ),
                (
                    5,
                    3,
                    't',
                    '2006-10-04 12:05:00'
                ),
                (
                    6,
                    3,
                    't',
                    '2006-10-04 12:01:00'
                )";
        $dbh->query($query);
        $aResult = &$oMaxDalMaintenance->getAllDeliveryLimitationChangedAds($aLastRun);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 2);
        $this->assertEqual($aResult[1], '2006-10-04 11:30:00');
        $this->assertEqual($aResult[4], '2006-10-04 12:15:00');
        TestEnv::rollbackTransaction();
    }

    /**
     * Method to test the getPreviousAdDeliveryInfo method.
     *
     * Requirements:
     * Test 1:   Test with no Date registered in the service locator, ensure false returned.
     * Test 2:   Test with a Date registered in the service locator, no data in the database,
     *           and ensure no data is returned.
     *
     * Test 3:   Test with ONLY impression data, but NOT in the previous OI, and ensure no
     *           data is returned.
     * Test 4:   Test with ONLY impression data, in the previous OI, and ensure that ONLY
     *           data relating to the impressions is returned.
     * Test 5:   Test with ONLY impression data, in the 2nd previous OI, and ensure that
     *           no data is returned.
     * Test 5a:  Re-test with ONLY impression data, in the 2nd previous OI, but pass in the
     *           ad/zone pair, and ensure that no data is returned.
     *
     * Test 6:   Test with ONLY prioritisation data, but NOT in the previous OI, and
     *           ensure no data is returned.
     * Test 7:   Test with ONLY prioritisation data, in the previous OI, and ensure that
     *           ONLY data relating to the prioritisation is returned.
     * Test 8:   Test with ONLY prioritisation data, in the 2nd previous OI, and ensure no
     *           data is returned.
     * Test 8a:  Re-test with ONLY prioritisation data, in the 2nd previous OI, but pass in
     *           the ad/zone pair, and ensure that ONLY data relating to the prioritisation
     *           is returned.
     *
     * Test 9:   Test with BOTH impressions data NOT in the previous OI, and prioritisation
     *           data NOT in the previous OI, and ensure no data is returned.
     * Test 10:  Test with BOTH impressions data NOT in the previous OI, and prioritisation
     *           data in the previous OI, and ensure ONLY data relating to the prioritisation
     *           is returned.
     * Test 11:  Test with BOTH impressions data NOT in the previous OI, and prioritisation
     *           data in the 2nd previous OI, and ensure no data is returned.
     * Test 11a: Re-test with BOTH impressions data NOT in the previous OI, and prioritisation
     *           data in the 2nd previous OI, but pass in the ad/zone pair, and ensure that
     *           ONLY data relating to the prioritisation is returned.
     *
     * Test 12:  Test with BOTH impressions data in the 2nd previous OI, and prioritisation
     *           data NOT in the previous OI, and ensure no data is returned.
     * Test 13:  Test with BOTH impressions data in the 2nd previous OI, and prioritisation
     *           data in the previous OI, and ensure ONLY data relating to the prioritisation
     *           is returned.
     * Test 14:  Test with BOTH impressions data in the 2nd previous OI, and prioritisation
     *           data in the 2nd previous OI, and ensure no data is returned.
     * Test 14a: Re-test with BOTH impressions data in the 2nd previous OI, and prioritisation
     *           data in the 2nd previous OI, but pass in the ad/zone pair, and ensure that
     *           all data is returned.
     *
     * Test 15:  Test with BOTH impressions data in the previous OI, and prioritisation
     *           data NOT in the previous OI, and ensure that ONLY data relating to the
     *           impressions is returned.
     * Test 16:  Test with BOTH impressions data in the previous OI, and prioritisation
     *           data in the previous OI, and ensure that all data is returned.
     * Test 17:  Test with BOTH impressions data in the previous OI, and prioritisation
     *           data in the 2nd previous OI, and ensure that all data is returned.
     * Test 17a: Re-test with BOTH impressions data in the previous OI, and prioritisation
     *           data in the 2nd previous OI, but pass in the ad/zone pair, and ensure that
     *           all data is returned.
     *
     * Test 18:  Perform a more realistic test, with data for the ads/zones in various
     *           past OIs, and including some ads with multiple prioritisation data
     *           per OI, as well as ads with no prioritisation data in some OIs, and
     *           ensure that the correct values are returned for each one. Test that:
     *           - Only ad/zones that delivered in the previous operation interval,
     *             or were requested to deliver in the previous operation interval,
     *             but didn't (i.e. not in other intervals) are returned in the
     *             results.
     *           - That prioritisation information where just ONE set of data exists
     *             is returned correctly.
     *           - That prioritisation information where multiple sets of INDENTICAL
     *             data exists is returned correctly.
     *           - That prioritisation information where multiple sets of DIFFERENT
     *             data exists is returned correctly.
     *           - That prioritisation information from older sets of data is
     *             returned correctly.
     * Test 18a: Re-test, but also include ad/zone pairs that are in/not in the above
     *           set of data, and ensure that these ad/zone pairs are also included
     *           in the results.
     */
    function testGetPreviousAdDeliveryInfo()
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $dbh = &MAX_DB::singleton();
        $oMaxDalMaintenance = new MAX_Dal_Maintenance_Priority();

        $aEmptyZoneAdArray = array();

        $aAdParams = array(
            'ad_id'  => 1,
            'active' => 't',
            'type'   => 'sql',
            'weight' => 1
        );
        $oAd = new MAX_Entity_Ad($aAdParams);
        $oZone = new Zone(array('zoneid' => 1));
        $oZone->addAdvert($oAd);
        $aZoneAdArray = array($oZone->id => $oZone);

        // Test 1
        $oServiceLocator = &ServiceLocator::instance();
        $oServiceLocator->remove('now');
        $result = &$oMaxDalMaintenance->getPreviousAdDeliveryInfo($aEmptyZoneAdArray);
        $this->assertFalse($result);

        // Test 2
        $oDate = new Date();
        $oServiceLocator->register('now', $oDate);
        $result = &$oMaxDalMaintenance->getPreviousAdDeliveryInfo($aEmptyZoneAdArray);
        $this->assertEqual(count($result), 0);

        // Test 3
        TestEnv::startTransaction();
        $operationIntervalID = MAX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $aDates = MAX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oDate);
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad']}
                (
                    operation_interval,
                    operation_interval_id,
                    interval_start,
                    interval_end,
                    ad_id,
                    zone_id,
                    impressions
                )
            VALUES
                (
                    {$conf['maintenance']['operationInterval']},
                    $operationIntervalID,
                    '" . $aDates['start']->format('%Y-%m-%d %H:%M:%S') . "',
                    '" . $aDates['end']->format('%Y-%m-%d %H:%M:%S') . "',
                    1,
                    1,
                    1
                )";
        $dbh->query($query);
        $result = &$oMaxDalMaintenance->getPreviousAdDeliveryInfo($aEmptyZoneAdArray);
        $this->assertEqual(count($result), 0);
        TestEnv::rollbackTransaction();

        // Test 4
        TestEnv::startTransaction();
        $operationIntervalID = MAX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $previousOperationIntervalID = MAX_OperationInterval::previousOperationIntervalID($operationIntervalID);
        $aDates = MAX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($oDate);
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad']}
                (
                    operation_interval,
                    operation_interval_id,
                    interval_start,
                    interval_end,
                    ad_id,
                    zone_id,
                    impressions
                )
            VALUES
                (
                    {$conf['maintenance']['operationInterval']},
                    $previousOperationIntervalID,
                    '" . $aDates['start']->format('%Y-%m-%d %H:%M:%S') . "',
                    '" . $aDates['end']->format('%Y-%m-%d %H:%M:%S') . "',
                    1,
                    1,
                    1
                )";
        $dbh->query($query);
        $result = &$oMaxDalMaintenance->getPreviousAdDeliveryInfo($aEmptyZoneAdArray);
        $this->assertEqual(count($result), 1);
        $this->assertEqual($result[1][1]['ad_id'], 1);
        $this->assertEqual($result[1][1]['zone_id'], 1);
        $this->assertNull($result[1][1]['required_impressions']);
        $this->assertNull($result[1][1]['requested_impressions']);
        $this->assertNull($result[1][1]['priority_factor']);
        $this->assertNull($result[1][1]['past_zone_traffic_fraction']);
        $this->assertEqual($result[1][1]['impressions'], 1);
        TestEnv::rollbackTransaction();

        // Test 5, 5a
        TestEnv::startTransaction();
        $operationIntervalID = MAX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $previousOperationIntervalID = MAX_OperationInterval::previousOperationIntervalID($operationIntervalID);
        $previousOperationIntervalID = MAX_OperationInterval::previousOperationIntervalID($previousOperationIntervalID);
        $aDates = MAX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($oDate);
        $aDates = MAX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($aDates['start']);
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad']}
                (
                    operation_interval,
                    operation_interval_id,
                    interval_start,
                    interval_end,
                    ad_id,
                    zone_id,
                    impressions
                )
            VALUES
                (
                    {$conf['maintenance']['operationInterval']},
                    $previousOperationIntervalID,
                    '" . $aDates['start']->format('%Y-%m-%d %H:%M:%S') . "',
                    '" . $aDates['end']->format('%Y-%m-%d %H:%M:%S') . "',
                    1,
                    1,
                    1
                )";
        $dbh->query($query);
        $result = &$oMaxDalMaintenance->getPreviousAdDeliveryInfo($aEmptyZoneAdArray);
        $this->assertEqual(count($result), 0);
        $result = &$oMaxDalMaintenance->getPreviousAdDeliveryInfo($aZoneAdArray);
        $this->assertEqual(count($result), 0);
        TestEnv::rollbackTransaction();

        // Test 6
        TestEnv::startTransaction();
        $operationIntervalID = MAX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $aDates = MAX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oDate);
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_summary_ad_zone_assoc']}
                (
                    operation_interval,
                    operation_interval_id,
                    interval_start,
                    interval_end,
                    ad_id,
                    zone_id,
                    required_impressions,
                    requested_impressions,
                    priority_factor,
                    past_zone_traffic_fraction
                )
            VALUES
                (
                    {$conf['maintenance']['operationInterval']},
                    $operationIntervalID,
                    '" . $aDates['start']->format('%Y-%m-%d %H:%M:%S') . "',
                    '" . $aDates['end']->format('%Y-%m-%d %H:%M:%S') . "',
                    1,
                    1,
                    1,
                    1,
                    0.5,
                    0.99
                )";
        $dbh->query($query);
        $result = &$oMaxDalMaintenance->getPreviousAdDeliveryInfo($aEmptyZoneAdArray);
        $this->assertEqual(count($result), 0);
        TestEnv::rollbackTransaction();

        // Test 7
        TestEnv::startTransaction();
        $operationIntervalID = MAX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $previousOperationIntervalID = MAX_OperationInterval::previousOperationIntervalID($operationIntervalID);
        $aDates = MAX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($oDate);
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_summary_ad_zone_assoc']}
                (
                    operation_interval,
                    operation_interval_id,
                    interval_start,
                    interval_end,
                    ad_id,
                    zone_id,
                    required_impressions,
                    requested_impressions,
                    priority_factor,
                    past_zone_traffic_fraction
                )
            VALUES
                (
                    {$conf['maintenance']['operationInterval']},
                    $previousOperationIntervalID,
                    '" . $aDates['start']->format('%Y-%m-%d %H:%M:%S') . "',
                    '" . $aDates['end']->format('%Y-%m-%d %H:%M:%S') . "',
                    1,
                    1,
                    1,
                    1,
                    0.5,
                    0.99
                )";
        $dbh->query($query);
        $result = &$oMaxDalMaintenance->getPreviousAdDeliveryInfo($aEmptyZoneAdArray);
        $this->assertEqual(count($result), 1);
        $this->assertEqual($result[1][1]['ad_id'], 1);
        $this->assertEqual($result[1][1]['zone_id'], 1);
        $this->assertEqual($result[1][1]['required_impressions'], 1);
        $this->assertEqual($result[1][1]['requested_impressions'], 1);
        $this->assertEqual($result[1][1]['priority_factor'], 0.5);
        $this->assertEqual($result[1][1]['past_zone_traffic_fraction'], 0.99);
        $this->assertNull($result[1][1]['impressions']);
        TestEnv::rollbackTransaction();

        // Test 8, 8a
        TestEnv::startTransaction();
        $operationIntervalID = MAX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $previousOperationIntervalID = MAX_OperationInterval::previousOperationIntervalID($operationIntervalID);
        $previousOperationIntervalID = MAX_OperationInterval::previousOperationIntervalID($previousOperationIntervalID);
        $aDates = MAX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($oDate);
        $aDates = MAX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($aDates['start']);
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_summary_ad_zone_assoc']}
                (
                    operation_interval,
                    operation_interval_id,
                    interval_start,
                    interval_end,
                    ad_id,
                    zone_id,
                    required_impressions,
                    requested_impressions,
                    priority_factor,
                    past_zone_traffic_fraction
                )
            VALUES
                (
                    {$conf['maintenance']['operationInterval']},
                    $previousOperationIntervalID,
                    '" . $aDates['start']->format('%Y-%m-%d %H:%M:%S') . "',
                    '" . $aDates['end']->format('%Y-%m-%d %H:%M:%S') . "',
                    1,
                    1,
                    1,
                    1,
                    0.5,
                    0.99
                )";
        $dbh->query($query);
        $result = &$oMaxDalMaintenance->getPreviousAdDeliveryInfo($aEmptyZoneAdArray);
        $this->assertEqual(count($result), 0);
        $result = &$oMaxDalMaintenance->getPreviousAdDeliveryInfo($aZoneAdArray);
        $this->assertEqual(count($result), 1);
        $this->assertEqual($result[1][1]['ad_id'], 1);
        $this->assertEqual($result[1][1]['zone_id'], 1);
        $this->assertEqual($result[1][1]['required_impressions'], 1);
        $this->assertEqual($result[1][1]['requested_impressions'], 1);
        $this->assertEqual($result[1][1]['priority_factor'], 0.5);
        $this->assertEqual($result[1][1]['past_zone_traffic_fraction'], 0.99);
        $this->assertNull($result[1][1]['impressions']);
        TestEnv::rollbackTransaction();

        // Test 9
        TestEnv::startTransaction();
        $operationIntervalID = MAX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $aDates = MAX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oDate);
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad']}
                (
                    operation_interval,
                    operation_interval_id,
                    interval_start,
                    interval_end,
                    ad_id,
                    zone_id,
                    impressions
                )
            VALUES
                (
                    {$conf['maintenance']['operationInterval']},
                    $operationIntervalID,
                    '" . $aDates['start']->format('%Y-%m-%d %H:%M:%S') . "',
                    '" . $aDates['end']->format('%Y-%m-%d %H:%M:%S') . "',
                    1,
                    1,
                    1
                )";
        $dbh->query($query);
        $operationIntervalID = MAX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $aDates = MAX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oDate);
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_summary_ad_zone_assoc']}
                (
                    operation_interval,
                    operation_interval_id,
                    interval_start,
                    interval_end,
                    ad_id,
                    zone_id,
                    required_impressions,
                    requested_impressions,
                    priority_factor,
                    past_zone_traffic_fraction
                )
            VALUES
                (
                    {$conf['maintenance']['operationInterval']},
                    $operationIntervalID,
                    '" . $aDates['start']->format('%Y-%m-%d %H:%M:%S') . "',
                    '" . $aDates['end']->format('%Y-%m-%d %H:%M:%S') . "',
                    1,
                    1,
                    1,
                    1,
                    0.5,
                    0.99
                )";
        $dbh->query($query);
        $result = &$oMaxDalMaintenance->getPreviousAdDeliveryInfo($aEmptyZoneAdArray);
        $this->assertEqual(count($result), 0);
        TestEnv::rollbackTransaction();

        // Test 10
        TestEnv::startTransaction();
        $operationIntervalID = MAX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $aDates = MAX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oDate);
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad']}
                (
                    operation_interval,
                    operation_interval_id,
                    interval_start,
                    interval_end,
                    ad_id,
                    zone_id,
                    impressions
                )
            VALUES
                (
                    {$conf['maintenance']['operationInterval']},
                    $operationIntervalID,
                    '" . $aDates['start']->format('%Y-%m-%d %H:%M:%S') . "',
                    '" . $aDates['end']->format('%Y-%m-%d %H:%M:%S') . "',
                    1,
                    1,
                    1
                )";
        $dbh->query($query);
        $operationIntervalID = MAX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $previousOperationIntervalID = MAX_OperationInterval::previousOperationIntervalID($operationIntervalID);
        $aDates = MAX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($oDate);
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_summary_ad_zone_assoc']}
                (
                    operation_interval,
                    operation_interval_id,
                    interval_start,
                    interval_end,
                    ad_id,
                    zone_id,
                    required_impressions,
                    requested_impressions,
                    priority_factor,
                    past_zone_traffic_fraction
                )
            VALUES
                (
                    {$conf['maintenance']['operationInterval']},
                    $previousOperationIntervalID,
                    '" . $aDates['start']->format('%Y-%m-%d %H:%M:%S') . "',
                    '" . $aDates['end']->format('%Y-%m-%d %H:%M:%S') . "',
                    1,
                    1,
                    1,
                    1,
                    0.5,
                    0.99
                )";
        $dbh->query($query);
        $result = &$oMaxDalMaintenance->getPreviousAdDeliveryInfo($aEmptyZoneAdArray);
        $this->assertEqual(count($result), 1);
        $this->assertEqual($result[1][1]['ad_id'], 1);
        $this->assertEqual($result[1][1]['zone_id'], 1);
        $this->assertEqual($result[1][1]['required_impressions'], 1);
        $this->assertEqual($result[1][1]['requested_impressions'], 1);
        $this->assertEqual($result[1][1]['priority_factor'], 0.5);
        $this->assertEqual($result[1][1]['past_zone_traffic_fraction'], 0.99);
        $this->assertNull($result[1][1]['impressions']);
        TestEnv::rollbackTransaction();

        // Test 11, 11a
        TestEnv::startTransaction();
        $operationIntervalID = MAX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $aDates = MAX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oDate);
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad']}
                (
                    operation_interval,
                    operation_interval_id,
                    interval_start,
                    interval_end,
                    ad_id,
                    zone_id,
                    impressions
                )
            VALUES
                (
                    {$conf['maintenance']['operationInterval']},
                    $operationIntervalID,
                    '" . $aDates['start']->format('%Y-%m-%d %H:%M:%S') . "',
                    '" . $aDates['end']->format('%Y-%m-%d %H:%M:%S') . "',
                    1,
                    1,
                    1
                )";
        $dbh->query($query);
        $operationIntervalID = MAX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $previousOperationIntervalID = MAX_OperationInterval::previousOperationIntervalID($operationIntervalID);
        $previousOperationIntervalID = MAX_OperationInterval::previousOperationIntervalID($previousOperationIntervalID);
        $aDates = MAX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($oDate);
        $aDates = MAX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($aDates['start']);
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_summary_ad_zone_assoc']}
                (
                    operation_interval,
                    operation_interval_id,
                    interval_start,
                    interval_end,
                    ad_id,
                    zone_id,
                    required_impressions,
                    requested_impressions,
                    priority_factor,
                    past_zone_traffic_fraction
                )
            VALUES
                (
                    {$conf['maintenance']['operationInterval']},
                    $previousOperationIntervalID,
                    '" . $aDates['start']->format('%Y-%m-%d %H:%M:%S') . "',
                    '" . $aDates['end']->format('%Y-%m-%d %H:%M:%S') . "',
                    1,
                    1,
                    1,
                    1,
                    0.5,
                    0.99
                )";
        $dbh->query($query);
        $result = &$oMaxDalMaintenance->getPreviousAdDeliveryInfo($aEmptyZoneAdArray);
        $this->assertEqual(count($result), 0);
        $result = &$oMaxDalMaintenance->getPreviousAdDeliveryInfo($aZoneAdArray);
        $this->assertEqual(count($result), 1);
        $this->assertEqual($result[1][1]['ad_id'], 1);
        $this->assertEqual($result[1][1]['zone_id'], 1);
        $this->assertEqual($result[1][1]['required_impressions'], 1);
        $this->assertEqual($result[1][1]['requested_impressions'], 1);
        $this->assertEqual($result[1][1]['priority_factor'], 0.5);
        $this->assertEqual($result[1][1]['past_zone_traffic_fraction'], 0.99);
        $this->assertNull($result[1][1]['impressions']);
        TestEnv::rollbackTransaction();

        // Test 12
        TestEnv::startTransaction();
        $operationIntervalID = MAX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $previousOperationIntervalID = MAX_OperationInterval::previousOperationIntervalID($operationIntervalID);
        $previousOperationIntervalID = MAX_OperationInterval::previousOperationIntervalID($previousOperationIntervalID);
        $aDates = MAX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($oDate);
        $aDates = MAX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($aDates['start']);
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad']}
                (
                    operation_interval,
                    operation_interval_id,
                    interval_start,
                    interval_end,
                    ad_id,
                    zone_id,
                    impressions
                )
            VALUES
                (
                    {$conf['maintenance']['operationInterval']},
                    $previousOperationIntervalID,
                    '" . $aDates['start']->format('%Y-%m-%d %H:%M:%S') . "',
                    '" . $aDates['end']->format('%Y-%m-%d %H:%M:%S') . "',
                    1,
                    1,
                    1
                )";
        $dbh->query($query);
        $operationIntervalID = MAX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $aDates = MAX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oDate);
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_summary_ad_zone_assoc']}
                (
                    operation_interval,
                    operation_interval_id,
                    interval_start,
                    interval_end,
                    ad_id,
                    zone_id,
                    required_impressions,
                    requested_impressions,
                    priority_factor,
                    past_zone_traffic_fraction
                )
            VALUES
                (
                    {$conf['maintenance']['operationInterval']},
                    $operationIntervalID,
                    '" . $aDates['start']->format('%Y-%m-%d %H:%M:%S') . "',
                    '" . $aDates['end']->format('%Y-%m-%d %H:%M:%S') . "',
                    1,
                    1,
                    1,
                    1,
                    0.5,
                    0.99
                )";
        $dbh->query($query);
        $result = &$oMaxDalMaintenance->getPreviousAdDeliveryInfo($aEmptyZoneAdArray);
        $this->assertEqual(count($result), 0);
        TestEnv::rollbackTransaction();

        // Test 13
        TestEnv::startTransaction();
        $operationIntervalID = MAX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $previousOperationIntervalID = MAX_OperationInterval::previousOperationIntervalID($operationIntervalID);
        $previousOperationIntervalID = MAX_OperationInterval::previousOperationIntervalID($previousOperationIntervalID);
        $aDates = MAX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($oDate);
        $aDates = MAX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($aDates['start']);
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad']}
                (
                    operation_interval,
                    operation_interval_id,
                    interval_start,
                    interval_end,
                    ad_id,
                    zone_id,
                    impressions
                )
            VALUES
                (
                    {$conf['maintenance']['operationInterval']},
                    $previousOperationIntervalID,
                    '" . $aDates['start']->format('%Y-%m-%d %H:%M:%S') . "',
                    '" . $aDates['end']->format('%Y-%m-%d %H:%M:%S') . "',
                    1,
                    1,
                    1
                )";
        $dbh->query($query);
        $operationIntervalID = MAX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $previousOperationIntervalID = MAX_OperationInterval::previousOperationIntervalID($operationIntervalID);
        $aDates = MAX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($oDate);
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_summary_ad_zone_assoc']}
                (
                    operation_interval,
                    operation_interval_id,
                    interval_start,
                    interval_end,
                    ad_id,
                    zone_id,
                    required_impressions,
                    requested_impressions,
                    priority_factor,
                    past_zone_traffic_fraction
                )
            VALUES
                (
                    {$conf['maintenance']['operationInterval']},
                    $previousOperationIntervalID,
                    '" . $aDates['start']->format('%Y-%m-%d %H:%M:%S') . "',
                    '" . $aDates['end']->format('%Y-%m-%d %H:%M:%S') . "',
                    1,
                    1,
                    1,
                    1,
                    0.5,
                    0.99
                )";
        $dbh->query($query);
        $result = &$oMaxDalMaintenance->getPreviousAdDeliveryInfo($aEmptyZoneAdArray);
        $this->assertEqual(count($result), 1);
        $this->assertEqual($result[1][1]['ad_id'], 1);
        $this->assertEqual($result[1][1]['zone_id'], 1);
        $this->assertEqual($result[1][1]['required_impressions'], 1);
        $this->assertEqual($result[1][1]['requested_impressions'], 1);
        $this->assertEqual($result[1][1]['priority_factor'], 0.5);
        $this->assertEqual($result[1][1]['past_zone_traffic_fraction'], 0.99);
        $this->assertNull($result[1][1]['impressions']);
        TestEnv::rollbackTransaction();

        // Test 14, 14a
        TestEnv::startTransaction();
        $operationIntervalID = MAX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $previousOperationIntervalID = MAX_OperationInterval::previousOperationIntervalID($operationIntervalID);
        $previousOperationIntervalID = MAX_OperationInterval::previousOperationIntervalID($previousOperationIntervalID);
        $aDates = MAX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($oDate);
        $aDates = MAX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($aDates['start']);
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad']}
                (
                    operation_interval,
                    operation_interval_id,
                    interval_start,
                    interval_end,
                    ad_id,
                    zone_id,
                    impressions
                )
            VALUES
                (
                    {$conf['maintenance']['operationInterval']},
                    $previousOperationIntervalID,
                    '" . $aDates['start']->format('%Y-%m-%d %H:%M:%S') . "',
                    '" . $aDates['end']->format('%Y-%m-%d %H:%M:%S') . "',
                    1,
                    1,
                    1
                )";
        $dbh->query($query);
        $operationIntervalID = MAX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $previousOperationIntervalID = MAX_OperationInterval::previousOperationIntervalID($operationIntervalID);
        $previousOperationIntervalID = MAX_OperationInterval::previousOperationIntervalID($previousOperationIntervalID);
        $aDates = MAX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($oDate);
        $aDates = MAX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($aDates['start']);
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_summary_ad_zone_assoc']}
                (
                    operation_interval,
                    operation_interval_id,
                    interval_start,
                    interval_end,
                    ad_id,
                    zone_id,
                    required_impressions,
                    requested_impressions,
                    priority_factor,
                    past_zone_traffic_fraction
                )
            VALUES
                (
                    {$conf['maintenance']['operationInterval']},
                    $previousOperationIntervalID,
                    '" . $aDates['start']->format('%Y-%m-%d %H:%M:%S') . "',
                    '" . $aDates['end']->format('%Y-%m-%d %H:%M:%S') . "',
                    1,
                    1,
                    1,
                    1,
                    0.5,
                    0.99
                )";
        $dbh->query($query);
        $result = &$oMaxDalMaintenance->getPreviousAdDeliveryInfo($aEmptyZoneAdArray);
        $this->assertEqual(count($result), 0);
        $result = &$oMaxDalMaintenance->getPreviousAdDeliveryInfo($aZoneAdArray);
        $this->assertEqual(count($result), 1);
        $this->assertEqual($result[1][1]['ad_id'], 1);
        $this->assertEqual($result[1][1]['zone_id'], 1);
        $this->assertEqual($result[1][1]['required_impressions'], 1);
        $this->assertEqual($result[1][1]['requested_impressions'], 1);
        $this->assertEqual($result[1][1]['priority_factor'], 0.5);
        $this->assertEqual($result[1][1]['past_zone_traffic_fraction'], 0.99);
        $this->assertEqual($result[1][1]['impressions'], 1);
        TestEnv::rollbackTransaction();

        // Test 15
        TestEnv::startTransaction();
        $operationIntervalID = MAX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $previousOperationIntervalID = MAX_OperationInterval::previousOperationIntervalID($operationIntervalID);
        $aDates = MAX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($oDate);
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad']}
                (
                    operation_interval,
                    operation_interval_id,
                    interval_start,
                    interval_end,
                    ad_id,
                    zone_id,
                    impressions
                )
            VALUES
                (
                    {$conf['maintenance']['operationInterval']},
                    $previousOperationIntervalID,
                    '" . $aDates['start']->format('%Y-%m-%d %H:%M:%S') . "',
                    '" . $aDates['end']->format('%Y-%m-%d %H:%M:%S') . "',
                    1,
                    1,
                    1
                )";
        $dbh->query($query);
        $operationIntervalID = MAX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $aDates = MAX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oDate);
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_summary_ad_zone_assoc']}
                (
                    operation_interval,
                    operation_interval_id,
                    interval_start,
                    interval_end,
                    ad_id,
                    zone_id,
                    required_impressions,
                    requested_impressions,
                    priority_factor,
                    past_zone_traffic_fraction
                )
            VALUES
                (
                    {$conf['maintenance']['operationInterval']},
                    $operationIntervalID,
                    '" . $aDates['start']->format('%Y-%m-%d %H:%M:%S') . "',
                    '" . $aDates['end']->format('%Y-%m-%d %H:%M:%S') . "',
                    1,
                    1,
                    1,
                    1,
                    0.5,
                    0.99
                )";
        $dbh->query($query);
        $result = &$oMaxDalMaintenance->getPreviousAdDeliveryInfo($aEmptyZoneAdArray);
        $this->assertEqual(count($result), 1);
        $this->assertEqual($result[1][1]['ad_id'], 1);
        $this->assertEqual($result[1][1]['zone_id'], 1);
        $this->assertNull($result[1][1]['required_impressions']);
        $this->assertNull($result[1][1]['requested_impressions']);
        $this->assertNull($result[1][1]['priority_factor']);
        $this->assertNull($result[1][1]['past_zone_traffic_fraction']);
        $this->assertEqual($result[1][1]['impressions'], 1);
        TestEnv::rollbackTransaction();

        // Test 16
        TestEnv::startTransaction();
        $operationIntervalID = MAX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $previousOperationIntervalID = MAX_OperationInterval::previousOperationIntervalID($operationIntervalID);
        $aDates = MAX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($oDate);
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad']}
                (
                    operation_interval,
                    operation_interval_id,
                    interval_start,
                    interval_end,
                    ad_id,
                    zone_id,
                    impressions
                )
            VALUES
                (
                    {$conf['maintenance']['operationInterval']},
                    $previousOperationIntervalID,
                    '" . $aDates['start']->format('%Y-%m-%d %H:%M:%S') . "',
                    '" . $aDates['end']->format('%Y-%m-%d %H:%M:%S') . "',
                    1,
                    1,
                    1
                )";
        $dbh->query($query);
        $operationIntervalID = MAX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $previousOperationIntervalID = MAX_OperationInterval::previousOperationIntervalID($operationIntervalID);
        $aDates = MAX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($oDate);
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_summary_ad_zone_assoc']}
                (
                    operation_interval,
                    operation_interval_id,
                    interval_start,
                    interval_end,
                    ad_id,
                    zone_id,
                    required_impressions,
                    requested_impressions,
                    priority_factor,
                    past_zone_traffic_fraction
                )
            VALUES
                (
                    {$conf['maintenance']['operationInterval']},
                    $previousOperationIntervalID,
                    '" . $aDates['start']->format('%Y-%m-%d %H:%M:%S') . "',
                    '" . $aDates['end']->format('%Y-%m-%d %H:%M:%S') . "',
                    1,
                    1,
                    1,
                    1,
                    0.5,
                    0.99
                )";
        $dbh->query($query);
        $result = &$oMaxDalMaintenance->getPreviousAdDeliveryInfo($aEmptyZoneAdArray);
        $this->assertEqual(count($result), 1);
        $this->assertEqual($result[1][1]['ad_id'], 1);
        $this->assertEqual($result[1][1]['zone_id'], 1);
        $this->assertEqual($result[1][1]['required_impressions'], 1);
        $this->assertEqual($result[1][1]['requested_impressions'], 1);
        $this->assertEqual($result[1][1]['priority_factor'], 0.5);
        $this->assertEqual($result[1][1]['past_zone_traffic_fraction'], 0.99);
        $this->assertEqual($result[1][1]['impressions'], 1);
        TestEnv::rollbackTransaction();

        // Test 17, 17a
        TestEnv::startTransaction();
        $operationIntervalID = MAX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $previousOperationIntervalID = MAX_OperationInterval::previousOperationIntervalID($operationIntervalID);
        $aDates = MAX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($oDate);
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad']}
                (
                    operation_interval,
                    operation_interval_id,
                    interval_start,
                    interval_end,
                    ad_id,
                    zone_id,
                    impressions
                )
            VALUES
                (
                    {$conf['maintenance']['operationInterval']},
                    $previousOperationIntervalID,
                    '" . $aDates['start']->format('%Y-%m-%d %H:%M:%S') . "',
                    '" . $aDates['end']->format('%Y-%m-%d %H:%M:%S') . "',
                    1,
                    1,
                    1
                )";
        $dbh->query($query);
        $operationIntervalID = MAX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $previousOperationIntervalID = MAX_OperationInterval::previousOperationIntervalID($operationIntervalID);
        $previousOperationIntervalID = MAX_OperationInterval::previousOperationIntervalID($previousOperationIntervalID);
        $aDates = MAX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($oDate);
        $aDates = MAX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($aDates['start']);
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_summary_ad_zone_assoc']}
                (
                    operation_interval,
                    operation_interval_id,
                    interval_start,
                    interval_end,
                    ad_id,
                    zone_id,
                    required_impressions,
                    requested_impressions,
                    priority_factor,
                    past_zone_traffic_fraction
                )
            VALUES
                (
                    {$conf['maintenance']['operationInterval']},
                    $previousOperationIntervalID,
                    '" . $aDates['start']->format('%Y-%m-%d %H:%M:%S') . "',
                    '" . $aDates['end']->format('%Y-%m-%d %H:%M:%S') . "',
                    1,
                    1,
                    1,
                    1,
                    0.5,
                    0.99
                )";
        $dbh->query($query);
        $result = &$oMaxDalMaintenance->getPreviousAdDeliveryInfo($aEmptyZoneAdArray);
        $this->assertEqual(count($result), 1);
        $this->assertEqual($result[1][1]['ad_id'], 1);
        $this->assertEqual($result[1][1]['zone_id'], 1);
        $this->assertEqual($result[1][1]['required_impressions'], 1);
        $this->assertEqual($result[1][1]['requested_impressions'], 1);
        $this->assertEqual($result[1][1]['priority_factor'], 0.5);
        $this->assertEqual($result[1][1]['past_zone_traffic_fraction'], 0.99);
        $this->assertEqual($result[1][1]['impressions'], 1);
        $result = &$oMaxDalMaintenance->getPreviousAdDeliveryInfo($aZoneAdArray);
        $this->assertEqual(count($result), 1);
        $this->assertEqual($result[1][1]['ad_id'], 1);
        $this->assertEqual($result[1][1]['zone_id'], 1);
        $this->assertEqual($result[1][1]['required_impressions'], 1);
        $this->assertEqual($result[1][1]['requested_impressions'], 1);
        $this->assertEqual($result[1][1]['priority_factor'], 0.5);
        $this->assertEqual($result[1][1]['past_zone_traffic_fraction'], 0.99);
        $this->assertEqual($result[1][1]['impressions'], 1);
        TestEnv::rollbackTransaction();

        // Test 18
        TestEnv::startTransaction();
        $operationIntervalID = MAX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $previousOperationIntervalID = MAX_OperationInterval::previousOperationIntervalID($operationIntervalID);
        $aDates = MAX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($oDate);
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad']}
                (
                    operation_interval,
                    operation_interval_id,
                    interval_start,
                    interval_end,
                    ad_id,
                    zone_id,
                    impressions
                )
            VALUES
                (
                    {$conf['maintenance']['operationInterval']},
                    $previousOperationIntervalID,
                    '" . $aDates['start']->format('%Y-%m-%d %H:%M:%S') . "',
                    '" . $aDates['end']->format('%Y-%m-%d %H:%M:%S') . "',
                    1,
                    1,
                    1
                ),
                (
                    {$conf['maintenance']['operationInterval']},
                    $previousOperationIntervalID,
                    '" . $aDates['start']->format('%Y-%m-%d %H:%M:%S') . "',
                    '" . $aDates['end']->format('%Y-%m-%d %H:%M:%S') . "',
                    1,
                    2,
                    1
                ),
                (
                    {$conf['maintenance']['operationInterval']},
                    $previousOperationIntervalID,
                    '" . $aDates['start']->format('%Y-%m-%d %H:%M:%S') . "',
                    '" . $aDates['end']->format('%Y-%m-%d %H:%M:%S') . "',
                    2,
                    3,
                    2
                ),
                (
                    {$conf['maintenance']['operationInterval']},
                    $previousOperationIntervalID,
                    '" . $aDates['start']->format('%Y-%m-%d %H:%M:%S') . "',
                    '" . $aDates['end']->format('%Y-%m-%d %H:%M:%S') . "',
                    2,
                    4,
                    2
                ),
                (
                    {$conf['maintenance']['operationInterval']},
                    $previousOperationIntervalID,
                    '" . $aDates['start']->format('%Y-%m-%d %H:%M:%S') . "',
                    '" . $aDates['end']->format('%Y-%m-%d %H:%M:%S') . "',
                    3,
                    5,
                    5
                )";
        $dbh->query($query);
        $operationIntervalID = MAX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $previousOperationIntervalID = MAX_OperationInterval::previousOperationIntervalID($operationIntervalID);
        $previousOperationIntervalID = MAX_OperationInterval::previousOperationIntervalID($previousOperationIntervalID);
        $aDates = MAX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($oDate);
        $aDates = MAX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($aDates['start']);
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad']}
                (
                    operation_interval,
                    operation_interval_id,
                    interval_start,
                    interval_end,
                    ad_id,
                    zone_id,
                    impressions
                )
            VALUES
                (
                    {$conf['maintenance']['operationInterval']},
                    $previousOperationIntervalID,
                    '" . $aDates['start']->format('%Y-%m-%d %H:%M:%S') . "',
                    '" . $aDates['end']->format('%Y-%m-%d %H:%M:%S') . "',
                    1,
                    1,
                    100
                ),
                (
                    {$conf['maintenance']['operationInterval']},
                    $previousOperationIntervalID,
                    '" . $aDates['start']->format('%Y-%m-%d %H:%M:%S') . "',
                    '" . $aDates['end']->format('%Y-%m-%d %H:%M:%S') . "',
                    1,
                    2,
                    100
                ),
                (
                    {$conf['maintenance']['operationInterval']},
                    $previousOperationIntervalID,
                    '" . $aDates['start']->format('%Y-%m-%d %H:%M:%S') . "',
                    '" . $aDates['end']->format('%Y-%m-%d %H:%M:%S') . "',
                    2,
                    3,
                    200
                ),
                (
                    {$conf['maintenance']['operationInterval']},
                    $previousOperationIntervalID,
                    '" . $aDates['start']->format('%Y-%m-%d %H:%M:%S') . "',
                    '" . $aDates['end']->format('%Y-%m-%d %H:%M:%S') . "',
                    2,
                    4,
                    200
                ),
                (
                    {$conf['maintenance']['operationInterval']},
                    $previousOperationIntervalID,
                    '" . $aDates['start']->format('%Y-%m-%d %H:%M:%S') . "',
                    '" . $aDates['end']->format('%Y-%m-%d %H:%M:%S') . "',
                    3,
                    5,
                    500
                ),
                (
                    {$conf['maintenance']['operationInterval']},
                    $previousOperationIntervalID,
                    '" . $aDates['start']->format('%Y-%m-%d %H:%M:%S') . "',
                    '" . $aDates['end']->format('%Y-%m-%d %H:%M:%S') . "',
                    4,
                    5,
                    500
                )";
        $dbh->query($query);
        $operationIntervalID = MAX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $previousOperationIntervalID = MAX_OperationInterval::previousOperationIntervalID($operationIntervalID);
        $aDates = MAX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($oDate);
        $oSpecialDate = new Date($aDates['end']);
        $oSpecialDate->addSeconds(1);
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_summary_ad_zone_assoc']}
                (
                    operation_interval,
                    operation_interval_id,
                    interval_start,
                    interval_end,
                    ad_id,
                    zone_id,
                    required_impressions,
                    requested_impressions,
                    priority_factor,
                    past_zone_traffic_fraction
                )
            VALUES
                (
                    {$conf['maintenance']['operationInterval']},
                    $previousOperationIntervalID,
                    '" . $aDates['start']->format('%Y-%m-%d %H:%M:%S') . "',
                    '" . $aDates['end']->format('%Y-%m-%d %H:%M:%S') . "',
                    1,
                    2,
                    10,
                    10,
                    0.5,
                    0.99
                ),
                (
                    {$conf['maintenance']['operationInterval']},
                    $previousOperationIntervalID,
                    '" . $aDates['start']->format('%Y-%m-%d %H:%M:%S') . "',
                    '" . $aDates['end']->format('%Y-%m-%d %H:%M:%S') . "',
                    9,
                    9,
                    59,
                    59,
                    95,
                    0.995
                )";
        $dbh->query($query);
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_summary_ad_zone_assoc']}
                (
                    operation_interval,
                    operation_interval_id,
                    interval_start,
                    interval_end,
                    ad_id,
                    zone_id,
                    required_impressions,
                    requested_impressions,
                    priority_factor,
                    past_zone_traffic_fraction,
                    created,
                    expired
                )
            VALUES
                (
                    {$conf['maintenance']['operationInterval']},
                    $previousOperationIntervalID,
                    '" . $aDates['start']->format('%Y-%m-%d %H:%M:%S') . "',
                    '" . $aDates['end']->format('%Y-%m-%d %H:%M:%S') . "',
                    2,
                    3,
                    30,
                    30,
                    0.4,
                    0.5,
                    '" . $aDates['start']->format('%Y-%m-%d %H:%M:%S') . "',
                    '" . $aDates['end']->format('%Y-%m-%d %H:30:00') . "'
                ),
                (
                    {$conf['maintenance']['operationInterval']},
                    $previousOperationIntervalID,
                    '" . $aDates['start']->format('%Y-%m-%d %H:%M:%S') . "',
                    '" . $aDates['end']->format('%Y-%m-%d %H:%M:%S') . "',
                    2,
                    3,
                    30,
                    30,
                    0.4,
                    0.5,
                    '" . $aDates['start']->format('%Y-%m-%d %H:30:00') . "',
                    '" . $aDates['end']->format('%Y-%m-%d %H:%M:%S') . "'
                ),
                (
                    {$conf['maintenance']['operationInterval']},
                    $previousOperationIntervalID,
                    '" . $aDates['start']->format('%Y-%m-%d %H:%M:%S') . "',
                    '" . $aDates['end']->format('%Y-%m-%d %H:%M:%S') . "',
                    2,
                    4,
                    10,
                    10,
                    0.4,
                    0.5,
                    '" . $aDates['start']->format('%Y-%m-%d %H:%M:%S') . "',
                    '" . $aDates['end']->format('%Y-%m-%d %H:30:00') . "'
                ),
                (
                    {$conf['maintenance']['operationInterval']},
                    $previousOperationIntervalID,
                    '" . $aDates['start']->format('%Y-%m-%d %H:%M:%S') . "',
                    '" . $aDates['end']->format('%Y-%m-%d %H:%M:%S') . "',
                    2,
                    4,
                    20,
                    20,
                    0.8,
                    0.5,
                    '" . $aDates['start']->format('%Y-%m-%d %H:30:00') . "',
                    '" . $oSpecialDate->format('%Y-%m-%d %H:%M:%S') . "'
                )";
        $dbh->query($query);
        $operationIntervalID = MAX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $previousOperationIntervalID = MAX_OperationInterval::previousOperationIntervalID($operationIntervalID);
        $previousOperationIntervalID = MAX_OperationInterval::previousOperationIntervalID($previousOperationIntervalID);
        $aDates = MAX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($oDate);
        $aDates = MAX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($aDates['start']);
        $oSpecialDate = new Date($aDates['end']);
        $oSpecialDate->addSeconds(1);
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_summary_ad_zone_assoc']}
                (
                    operation_interval,
                    operation_interval_id,
                    interval_start,
                    interval_end,
                    ad_id,
                    zone_id,
                    required_impressions,
                    requested_impressions,
                    priority_factor,
                    past_zone_traffic_fraction,
                    created,
                    expired
                )
            VALUES
                (
                    {$conf['maintenance']['operationInterval']},
                    $previousOperationIntervalID,
                    '" . $aDates['start']->format('%Y-%m-%d %H:%M:%S') . "',
                    '" . $aDates['end']->format('%Y-%m-%d %H:%M:%S') . "',
                    3,
                    5,
                    200,
                    200,
                    0.2,
                    0.95,
                    '" . $aDates['start']->format('%Y-%m-%d %H:%M:%S') . "',
                    '" . $aDates['end']->format('%Y-%m-%d %H:30:00') . "'
                ),
                (
                    {$conf['maintenance']['operationInterval']},
                    $previousOperationIntervalID,
                    '" . $aDates['start']->format('%Y-%m-%d %H:%M:%S') . "',
                    '" . $aDates['end']->format('%Y-%m-%d %H:%M:%S') . "',
                    3,
                    5,
                    100,
                    100,
                    0.4,
                    0.95,
                    '" . $aDates['start']->format('%Y-%m-%d %H:30:00') . "',
                    '" . $oSpecialDate->format('%Y-%m-%d %H:%M:%S') . "'
                )";
        $dbh->query($query);
        $result = &$oMaxDalMaintenance->getPreviousAdDeliveryInfo($aEmptyZoneAdArray);
        $this->assertEqual(count($result), 4);
        $this->assertEqual(count($result[1]), 2);
        $this->assertEqual($result[1][1]['ad_id'], 1);
        $this->assertEqual($result[1][1]['zone_id'], 1);
        $this->assertNull($result[1][1]['required_impressions']);
        $this->assertNull($result[1][1]['requested_impressions']);
        $this->assertNull($result[1][1]['priority_factor']);
        $this->assertNull($result[1][1]['past_zone_traffic_fraction']);
        $this->assertEqual($result[1][1]['impressions'], 1);
        $this->assertEqual($result[1][2]['ad_id'], 1);
        $this->assertEqual($result[1][2]['zone_id'], 2);
        $this->assertEqual($result[1][2]['required_impressions'], 10);
        $this->assertEqual($result[1][2]['requested_impressions'], 10);
        $this->assertEqual($result[1][2]['priority_factor'], 0.5);
        $this->assertEqual($result[1][2]['past_zone_traffic_fraction'], 0.99);
        $this->assertEqual($result[1][2]['impressions'], 1);
        $this->assertEqual(count($result[2]), 2);
        $this->assertEqual($result[2][3]['ad_id'], 2);
        $this->assertEqual($result[2][3]['zone_id'], 3);
        $this->assertEqual($result[2][3]['required_impressions'], 30);
        $this->assertEqual($result[2][3]['requested_impressions'], 30);
        $this->assertEqual($result[2][3]['priority_factor'], 0.4);
        $this->assertEqual($result[2][3]['past_zone_traffic_fraction'], 0.5);
        $this->assertEqual($result[2][3]['impressions'], 2);
        $this->assertEqual($result[2][4]['ad_id'], 2);
        $this->assertEqual($result[2][4]['zone_id'], 4);
        $this->assertEqual($result[2][4]['required_impressions'], 15);
        $this->assertEqual($result[2][4]['requested_impressions'], 15);
        $this->assertEqual($result[2][4]['priority_factor'], 0.6);
        $this->assertEqual($result[2][4]['past_zone_traffic_fraction'], 0.5);
        $this->assertEqual($result[2][4]['impressions'], 2);
        $this->assertEqual(count($result[3]), 1);
        $this->assertEqual($result[3][5]['ad_id'], 3);
        $this->assertEqual($result[3][5]['zone_id'], 5);
        $this->assertEqual($result[3][5]['required_impressions'], 150);
        $this->assertEqual($result[3][5]['requested_impressions'], 150);
        $this->assertEqual($result[3][5]['priority_factor'], 0.3);
        $this->assertEqual($result[3][5]['past_zone_traffic_fraction'], 0.95);
        $this->assertEqual($result[3][5]['impressions'], 5);
        $this->assertEqual(count($result[9]), 1);
        $this->assertEqual($result[9][9]['ad_id'], 9);
        $this->assertEqual($result[9][9]['zone_id'], 9);
        $this->assertEqual($result[9][9]['required_impressions'], 59);
        $this->assertEqual($result[9][9]['requested_impressions'], 59);
        $this->assertEqual($result[9][9]['priority_factor'], 95);
        $this->assertEqual($result[9][9]['past_zone_traffic_fraction'], 0.995);
        $this->assertNull($result[9][9]['impressions']);
        TestEnv::rollbackTransaction();

        // Test 18a
        TestEnv::startTransaction();
        $oZone = new Zone(array('zoneid' => 4));
        $aAdParams = array(
            'ad_id'  => 10,
            'active' => 't',
            'type'   => 'sql',
            'weight' => 1
        );
        $oAd = new MAX_Entity_Ad($aAdParams);
        $oZone->addAdvert($oAd);
        $aAdParams = array(
            'ad_id'  => 11,
            'active' => 't',
            'type'   => 'sql',
            'weight' => 1
        );
        $oAd = new MAX_Entity_Ad($aAdParams);
        $oZone->addAdvert($oAd);
        $aZoneAdArray = array($oZone->id => $oZone);
        $operationIntervalID = MAX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $previousOperationIntervalID = MAX_OperationInterval::previousOperationIntervalID($operationIntervalID);
        $aDates = MAX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($oDate);
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad']}
                (
                    operation_interval,
                    operation_interval_id,
                    interval_start,
                    interval_end,
                    ad_id,
                    zone_id,
                    impressions
                )
            VALUES
                (
                    {$conf['maintenance']['operationInterval']},
                    $previousOperationIntervalID,
                    '" . $aDates['start']->format('%Y-%m-%d %H:%M:%S') . "',
                    '" . $aDates['end']->format('%Y-%m-%d %H:%M:%S') . "',
                    1,
                    1,
                    1
                ),
                (
                    {$conf['maintenance']['operationInterval']},
                    $previousOperationIntervalID,
                    '" . $aDates['start']->format('%Y-%m-%d %H:%M:%S') . "',
                    '" . $aDates['end']->format('%Y-%m-%d %H:%M:%S') . "',
                    1,
                    2,
                    1
                ),
                (
                    {$conf['maintenance']['operationInterval']},
                    $previousOperationIntervalID,
                    '" . $aDates['start']->format('%Y-%m-%d %H:%M:%S') . "',
                    '" . $aDates['end']->format('%Y-%m-%d %H:%M:%S') . "',
                    2,
                    3,
                    2
                ),
                (
                    {$conf['maintenance']['operationInterval']},
                    $previousOperationIntervalID,
                    '" . $aDates['start']->format('%Y-%m-%d %H:%M:%S') . "',
                    '" . $aDates['end']->format('%Y-%m-%d %H:%M:%S') . "',
                    2,
                    4,
                    2
                ),
                (
                    {$conf['maintenance']['operationInterval']},
                    $previousOperationIntervalID,
                    '" . $aDates['start']->format('%Y-%m-%d %H:%M:%S') . "',
                    '" . $aDates['end']->format('%Y-%m-%d %H:%M:%S') . "',
                    3,
                    5,
                    5
                )";
        $dbh->query($query);
        $operationIntervalID = MAX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $previousOperationIntervalID = MAX_OperationInterval::previousOperationIntervalID($operationIntervalID);
        $previousOperationIntervalID = MAX_OperationInterval::previousOperationIntervalID($previousOperationIntervalID);
        $aDates = MAX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($oDate);
        $aDates = MAX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($aDates['start']);
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad']}
                (
                    operation_interval,
                    operation_interval_id,
                    interval_start,
                    interval_end,
                    ad_id,
                    zone_id,
                    impressions
                )
            VALUES
                (
                    {$conf['maintenance']['operationInterval']},
                    $previousOperationIntervalID,
                    '" . $aDates['start']->format('%Y-%m-%d %H:%M:%S') . "',
                    '" . $aDates['end']->format('%Y-%m-%d %H:%M:%S') . "',
                    1,
                    1,
                    100
                ),
                (
                    {$conf['maintenance']['operationInterval']},
                    $previousOperationIntervalID,
                    '" . $aDates['start']->format('%Y-%m-%d %H:%M:%S') . "',
                    '" . $aDates['end']->format('%Y-%m-%d %H:%M:%S') . "',
                    1,
                    2,
                    100
                ),
                (
                    {$conf['maintenance']['operationInterval']},
                    $previousOperationIntervalID,
                    '" . $aDates['start']->format('%Y-%m-%d %H:%M:%S') . "',
                    '" . $aDates['end']->format('%Y-%m-%d %H:%M:%S') . "',
                    2,
                    3,
                    200
                ),
                (
                    {$conf['maintenance']['operationInterval']},
                    $previousOperationIntervalID,
                    '" . $aDates['start']->format('%Y-%m-%d %H:%M:%S') . "',
                    '" . $aDates['end']->format('%Y-%m-%d %H:%M:%S') . "',
                    2,
                    4,
                    200
                ),
                (
                    {$conf['maintenance']['operationInterval']},
                    $previousOperationIntervalID,
                    '" . $aDates['start']->format('%Y-%m-%d %H:%M:%S') . "',
                    '" . $aDates['end']->format('%Y-%m-%d %H:%M:%S') . "',
                    3,
                    5,
                    500
                ),
                (
                    {$conf['maintenance']['operationInterval']},
                    $previousOperationIntervalID,
                    '" . $aDates['start']->format('%Y-%m-%d %H:%M:%S') . "',
                    '" . $aDates['end']->format('%Y-%m-%d %H:%M:%S') . "',
                    4,
                    5,
                    500
                ),
                (
                    {$conf['maintenance']['operationInterval']},
                    $previousOperationIntervalID,
                    '" . $aDates['start']->format('%Y-%m-%d %H:%M:%S') . "',
                    '" . $aDates['end']->format('%Y-%m-%d %H:%M:%S') . "',
                    10,
                    4,
                    1000
                )";
        $dbh->query($query);
        $operationIntervalID = MAX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $previousOperationIntervalID = MAX_OperationInterval::previousOperationIntervalID($operationIntervalID);
        for ($i = 0; $i <= (MINUTES_PER_WEEK / $conf['maintenance']['operationInterval']); $i++) {
            $previousOperationIntervalID = MAX_OperationInterval::previousOperationIntervalID($previousOperationIntervalID);
        }
        $aDates = MAX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($oDate);
        for ($i = 0; $i <= (MINUTES_PER_WEEK / $conf['maintenance']['operationInterval']); $i++) {
            $aDates = MAX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($aDates['start']);
        }
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad']}
                (
                    operation_interval,
                    operation_interval_id,
                    interval_start,
                    interval_end,
                    ad_id,
                    zone_id,
                    impressions
                )
            VALUES
                (
                    {$conf['maintenance']['operationInterval']},
                    $previousOperationIntervalID,
                    '" . $aDates['start']->format('%Y-%m-%d %H:%M:%S') . "',
                    '" . $aDates['end']->format('%Y-%m-%d %H:%M:%S') . "',
                    11,
                    4,
                    2000
                )";
        $dbh->query($query);
        $operationIntervalID = MAX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $previousOperationIntervalID = MAX_OperationInterval::previousOperationIntervalID($operationIntervalID);
        $aDates = MAX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($oDate);
        $oSpecialDate = new Date($aDates['end']);
        $oSpecialDate->addSeconds(1);
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_summary_ad_zone_assoc']}
                (
                    operation_interval,
                    operation_interval_id,
                    interval_start,
                    interval_end,
                    ad_id,
                    zone_id,
                    required_impressions,
                    requested_impressions,
                    priority_factor,
                    past_zone_traffic_fraction
                )
            VALUES
                (
                    {$conf['maintenance']['operationInterval']},
                    $previousOperationIntervalID,
                    '" . $aDates['start']->format('%Y-%m-%d %H:%M:%S') . "',
                    '" . $aDates['end']->format('%Y-%m-%d %H:%M:%S') . "',
                    1,
                    2,
                    10,
                    10,
                    0.5,
                    0.99
                ),
                (
                    {$conf['maintenance']['operationInterval']},
                    $previousOperationIntervalID,
                    '" . $aDates['start']->format('%Y-%m-%d %H:%M:%S') . "',
                    '" . $aDates['end']->format('%Y-%m-%d %H:%M:%S') . "',
                    9,
                    9,
                    59,
                    59,
                    95,
                    0.995
                )";
        $dbh->query($query);
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_summary_ad_zone_assoc']}
                (
                    operation_interval,
                    operation_interval_id,
                    interval_start,
                    interval_end,
                    ad_id,
                    zone_id,
                    required_impressions,
                    requested_impressions,
                    priority_factor,
                    past_zone_traffic_fraction,
                    created,
                    expired
                )
            VALUES
                (
                    {$conf['maintenance']['operationInterval']},
                    $previousOperationIntervalID,
                    '" . $aDates['start']->format('%Y-%m-%d %H:%M:%S') . "',
                    '" . $aDates['end']->format('%Y-%m-%d %H:%M:%S') . "',
                    2,
                    3,
                    30,
                    30,
                    0.4,
                    0.5,
                    '" . $aDates['start']->format('%Y-%m-%d %H:%M:%S') . "',
                    '" . $aDates['end']->format('%Y-%m-%d %H:30:00') . "'
                ),
                (
                    {$conf['maintenance']['operationInterval']},
                    $previousOperationIntervalID,
                    '" . $aDates['start']->format('%Y-%m-%d %H:%M:%S') . "',
                    '" . $aDates['end']->format('%Y-%m-%d %H:%M:%S') . "',
                    2,
                    3,
                    30,
                    30,
                    0.4,
                    0.5,
                    '" . $aDates['start']->format('%Y-%m-%d %H:30:00') . "',
                    '" . $aDates['end']->format('%Y-%m-%d %H:%M:%S') . "'
                ),
                (
                    {$conf['maintenance']['operationInterval']},
                    $previousOperationIntervalID,
                    '" . $aDates['start']->format('%Y-%m-%d %H:%M:%S') . "',
                    '" . $aDates['end']->format('%Y-%m-%d %H:%M:%S') . "',
                    2,
                    4,
                    10,
                    10,
                    0.4,
                    0.5,
                    '" . $aDates['start']->format('%Y-%m-%d %H:%M:%S') . "',
                    '" . $aDates['end']->format('%Y-%m-%d %H:30:00') . "'
                ),
                (
                    {$conf['maintenance']['operationInterval']},
                    $previousOperationIntervalID,
                    '" . $aDates['start']->format('%Y-%m-%d %H:%M:%S') . "',
                    '" . $aDates['end']->format('%Y-%m-%d %H:%M:%S') . "',
                    2,
                    4,
                    20,
                    20,
                    0.8,
                    0.5,
                    '" . $aDates['start']->format('%Y-%m-%d %H:30:00') . "',
                    '" . $oSpecialDate->format('%Y-%m-%d %H:%M:%S') . "'
                )";
        $dbh->query($query);
        $operationIntervalID = MAX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $previousOperationIntervalID = MAX_OperationInterval::previousOperationIntervalID($operationIntervalID);
        $previousOperationIntervalID = MAX_OperationInterval::previousOperationIntervalID($previousOperationIntervalID);
        $aDates = MAX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($oDate);
        $aDates = MAX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($aDates['start']);
        $oSpecialDate = new Date($aDates['end']);
        $oSpecialDate->addSeconds(1);
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_summary_ad_zone_assoc']}
                (
                    operation_interval,
                    operation_interval_id,
                    interval_start,
                    interval_end,
                    ad_id,
                    zone_id,
                    required_impressions,
                    requested_impressions,
                    priority_factor,
                    past_zone_traffic_fraction,
                    created,
                    expired
                )
            VALUES
                (
                    {$conf['maintenance']['operationInterval']},
                    $previousOperationIntervalID,
                    '" . $aDates['start']->format('%Y-%m-%d %H:%M:%S') . "',
                    '" . $aDates['end']->format('%Y-%m-%d %H:%M:%S') . "',
                    3,
                    5,
                    200,
                    200,
                    0.2,
                    0.95,
                    '" . $aDates['start']->format('%Y-%m-%d %H:%M:%S') . "',
                    '" . $aDates['end']->format('%Y-%m-%d %H:30:00') . "'
                ),
                (
                    {$conf['maintenance']['operationInterval']},
                    $previousOperationIntervalID,
                    '" . $aDates['start']->format('%Y-%m-%d %H:%M:%S') . "',
                    '" . $aDates['end']->format('%Y-%m-%d %H:%M:%S') . "',
                    3,
                    5,
                    100,
                    100,
                    0.4,
                    0.95,
                    '" . $aDates['start']->format('%Y-%m-%d %H:30:00') . "',
                    '" . $oSpecialDate->format('%Y-%m-%d %H:%M:%S') . "'
                ),
                (
                    {$conf['maintenance']['operationInterval']},
                    $previousOperationIntervalID,
                    '" . $aDates['start']->format('%Y-%m-%d %H:%M:%S') . "',
                    '" . $aDates['end']->format('%Y-%m-%d %H:%M:%S') . "',
                    10,
                    4,
                    1000,
                    1000,
                    1,
                    0.9,
                    '" . $aDates['start']->format('%Y-%m-%d %H:30:00') . "',
                    '" . $oSpecialDate->format('%Y-%m-%d %H:%M:%S') . "'
                )";
        $dbh->query($query);
        $operationIntervalID = MAX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $previousOperationIntervalID = MAX_OperationInterval::previousOperationIntervalID($operationIntervalID);
        for ($i = 0; $i <= (MINUTES_PER_WEEK / $conf['maintenance']['operationInterval']); $i++) {
            $previousOperationIntervalID = MAX_OperationInterval::previousOperationIntervalID($previousOperationIntervalID);
        }
        $aDates = MAX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($oDate);
        for ($i = 0; $i <= (MINUTES_PER_WEEK / $conf['maintenance']['operationInterval']); $i++) {
            $aDates = MAX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($aDates['start']);
        }
        $oSpecialDate = new Date($aDates['end']);
        $oSpecialDate->addSeconds(1);
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_summary_ad_zone_assoc']}
                (
                    operation_interval,
                    operation_interval_id,
                    interval_start,
                    interval_end,
                    ad_id,
                    zone_id,
                    required_impressions,
                    requested_impressions,
                    priority_factor,
                    past_zone_traffic_fraction,
                    created,
                    expired
                )
            VALUES
                (
                    {$conf['maintenance']['operationInterval']},
                    $previousOperationIntervalID,
                    '" . $aDates['start']->format('%Y-%m-%d %H:%M:%S') . "',
                    '" . $aDates['end']->format('%Y-%m-%d %H:%M:%S') . "',
                    11,
                    4,
                    2000,
                    2000,
                    1,
                    0.9,
                    '" . $aDates['start']->format('%Y-%m-%d %H:30:00') . "',
                    '" . $oSpecialDate->format('%Y-%m-%d %H:%M:%S') . "'
                )";
        $dbh->query($query);
        $result = &$oMaxDalMaintenance->getPreviousAdDeliveryInfo($aZoneAdArray);
        $this->assertEqual(count($result), 5);
        $this->assertEqual(count($result[1]), 2);
        $this->assertEqual($result[1][1]['ad_id'], 1);
        $this->assertEqual($result[1][1]['zone_id'], 1);
        $this->assertNull($result[1][1]['required_impressions']);
        $this->assertNull($result[1][1]['requested_impressions']);
        $this->assertNull($result[1][1]['priority_factor']);
        $this->assertNull($result[1][1]['past_zone_traffic_fraction']);
        $this->assertEqual($result[1][1]['impressions'], 1);
        $this->assertEqual($result[1][2]['ad_id'], 1);
        $this->assertEqual($result[1][2]['zone_id'], 2);
        $this->assertEqual($result[1][2]['required_impressions'], 10);
        $this->assertEqual($result[1][2]['requested_impressions'], 10);
        $this->assertEqual($result[1][2]['priority_factor'], 0.5);
        $this->assertEqual($result[1][2]['past_zone_traffic_fraction'], 0.99);
        $this->assertEqual($result[1][2]['impressions'], 1);
        $this->assertEqual(count($result[2]), 2);
        $this->assertEqual($result[2][3]['ad_id'], 2);
        $this->assertEqual($result[2][3]['zone_id'], 3);
        $this->assertEqual($result[2][3]['required_impressions'], 30);
        $this->assertEqual($result[2][3]['requested_impressions'], 30);
        $this->assertEqual($result[2][3]['priority_factor'], 0.4);
        $this->assertEqual($result[2][3]['past_zone_traffic_fraction'], 0.5);
        $this->assertEqual($result[2][3]['impressions'], 2);
        $this->assertEqual($result[2][4]['ad_id'], 2);
        $this->assertEqual($result[2][4]['zone_id'], 4);
        $this->assertEqual($result[2][4]['required_impressions'], 15);
        $this->assertEqual($result[2][4]['requested_impressions'], 15);
        $this->assertEqual($result[2][4]['priority_factor'], 0.6);
        $this->assertEqual($result[2][4]['past_zone_traffic_fraction'], 0.5);
        $this->assertEqual($result[2][4]['impressions'], 2);
        $this->assertEqual(count($result[3]), 1);
        $this->assertEqual($result[3][5]['ad_id'], 3);
        $this->assertEqual($result[3][5]['zone_id'], 5);
        $this->assertEqual($result[3][5]['required_impressions'], 150);
        $this->assertEqual($result[3][5]['requested_impressions'], 150);
        $this->assertEqual($result[3][5]['priority_factor'], 0.3);
        $this->assertEqual($result[3][5]['past_zone_traffic_fraction'], 0.95);
        $this->assertEqual($result[3][5]['impressions'], 5);
        $this->assertEqual(count($result[9]), 1);
        $this->assertEqual($result[9][9]['ad_id'], 9);
        $this->assertEqual($result[9][9]['zone_id'], 9);
        $this->assertEqual($result[9][9]['required_impressions'], 59);
        $this->assertEqual($result[9][9]['requested_impressions'], 59);
        $this->assertEqual($result[9][9]['priority_factor'], 95);
        $this->assertEqual($result[9][9]['past_zone_traffic_fraction'], 0.995);
        $this->assertNull($result[9][9]['impressions']);
        $this->assertEqual(count($result[10]), 1);
        $this->assertEqual($result[10][4]['ad_id'], 10);
        $this->assertEqual($result[10][4]['zone_id'], 4);
        $this->assertEqual($result[10][4]['required_impressions'], 1000);
        $this->assertEqual($result[10][4]['requested_impressions'], 1000);
        $this->assertEqual($result[10][4]['priority_factor'], 1);
        $this->assertEqual($result[10][4]['past_zone_traffic_fraction'], 0.9);
        $this->assertEqual($result[10][4]['impressions'], 1000);
        TestEnv::rollbackTransaction();
    }

    /**
     * Method to test the updatePriorities method.
     *
     * Test 1: Test with no Date registered in the service locator, ensure false returned.
     * Test 2: Test with no data in the database, ensure data is correctly stored.
     * Test 3: Test with previous test data in the database, ensure data is correctly stored.
     * Test 4: Test with an obscene number of items, and ensure that the packet size is
     *         not exceeded (no asserts, test suite will simply fail if unable to work).
     */
    function testUpdatePriorities()
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $dbh = &MAX_DB::singleton();
        $oMaxDalMaintenance = new MAX_Dal_Maintenance_Priority();
        // Insert the data into the ad_zone_assoc table, as an ad is linked to a zone
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['ad_zone_assoc']}
                (
                    ad_id,
                    zone_id,
                    priority
                )
            VALUES
                (
                    1,
                    1,
                    0
                )";
        $dbh->query($query);

        // Test 1
        $oServiceLocator = &ServiceLocator::instance();
        $oServiceLocator->remove('now');
        $aData =
            array(
                array(
                    'ads' => array(
                        array(
                            'ad_id'                      => '1',
                            'zone_id'                    => '1',
                            'required_impressions'       => '1000',
                            'requested_impressions'      => '1000',
                            'priority'                   => '0.45',
                            'priority_factor'            => null,
                            'priority_factor_limited'    => false,
                            'past_zone_traffic_fraction' => null
                        )
                    )
                )
            );
        $result = $oMaxDalMaintenance->updatePriorities($aData);
        $this->assertFalse($result);

        // Test 2
        $oDate = new Date();
        $oServiceLocator->register('now', $oDate);
        $result = $oMaxDalMaintenance->updatePriorities($aData);
        $this->assertTrue($result);
        $query = "
            SELECT
                ad_id,
                zone_id,
                priority
            FROM
                {$conf['table']['prefix']}{$conf['table']['ad_zone_assoc']}
            WHERE
                ad_id = 1";
        $row = $dbh->getRow($query);
        $this->assertEqual($row['ad_id'], 1);
        $this->assertEqual($row['zone_id'], 1);
        $this->assertEqual($row['priority'], 0.45);
        $query = "
            SELECT
                operation_interval,
                operation_interval_id,
                interval_start,
                interval_end,
                ad_id,
                zone_id,
                required_impressions,
                requested_impressions,
                priority,
                priority_factor,
                priority_factor_limited,
                past_zone_traffic_fraction,
                created,
                created_by,
                expired,
                expired_by
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_summary_ad_zone_assoc']}
            WHERE
                ad_id = 1";
        $row = $dbh->getRow($query);
        $currentOperationIntervalID = MAX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $aDates = MAX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oDate);
        $this->assertEqual($row['operation_interval'], $conf['maintenance']['operationInterval']);
        $this->assertEqual($row['operation_interval_id'], $currentOperationIntervalID);
        $this->assertEqual($row['interval_start'], $aDates['start']->format('%Y-%m-%d %H:%M:%S'));
        $this->assertEqual($row['interval_end'], $aDates['end']->format('%Y-%m-%d %H:%M:%S'));
        $this->assertEqual($row['ad_id'], 1);
        $this->assertEqual($row['zone_id'], 1);
        $this->assertEqual($row['required_impressions'], 1000);
        $this->assertEqual($row['requested_impressions'], 1000);
        $this->assertEqual($row['priority'], 0.45);
        $this->assertNull($row['priority_factor']);
        $this->assertFalse($row['priority_factor_limited']);
        $this->assertNull($row['past_zone_traffic_fraction']);
        $this->assertEqual($row['created'], $oDate->format('%Y-%m-%d %H:%M:%S'));
        $this->assertEqual($row['created_by'], 0);
        $this->assertNull($row['expired']);
        $this->assertNull($row['expired_by']);

        // Test 3
        $aData =
            array(
                array(
                    'ads' => array(
                        array(
                            'ad_id'                      => 1,
                            'zone_id'                    => 1,
                            'required_impressions'       => 2000,
                            'requested_impressions'      => 2000,
                            'priority'                   => 0.9,
                            'priority_factor'            => 0.1,
                            'priority_factor_limited'    => false,
                            'past_zone_traffic_fraction' => 0.99
                        ),
                        array(
                            'ad_id'                      => 2,
                            'zone_id'                    => 2,
                            'required_impressions'       => 500,
                            'requested_impressions'      => 500,
                            'priority'                   => 0.1,
                            'priority_factor'            => 0.2,
                            'priority_factor_limited'    => true,
                            'past_zone_traffic_fraction' => 0.45
                        )
                    )
                )
            );
        $oOldDate = new Date();
        $oOldDate->copy($oDate);
        $oDate = new Date();
        $oServiceLocator->register('now', $oDate);
        $result = $oMaxDalMaintenance->updatePriorities($aData);
        $this->assertTrue($result);
        $query = "
            SELECT
                ad_id,
                zone_id,
                priority
            FROM
                {$conf['table']['prefix']}{$conf['table']['ad_zone_assoc']}
            WHERE
                ad_id = 1";
        $row = $dbh->getRow($query);
        $this->assertEqual($row['ad_id'], 1);
        $this->assertEqual($row['zone_id'], 1);
        $this->assertEqual($row['priority'], 0.9);
        $query = "
            SELECT
                operation_interval,
                operation_interval_id,
                interval_start,
                interval_end,
                ad_id,
                zone_id,
                required_impressions,
                requested_impressions,
                priority,
                priority_factor,
                priority_factor_limited,
                past_zone_traffic_fraction,
                created,
                created_by,
                expired,
                expired_by
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_summary_ad_zone_assoc']}
            WHERE
                ad_id = 1
                AND expired IS NOT NULL";
        $row = $dbh->getRow($query);
        $currentOperationIntervalID = MAX_OperationInterval::convertDateToOperationIntervalID($oOldDate);
        $aDates = MAX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oOldDate);
        $this->assertEqual($row['operation_interval'], $conf['maintenance']['operationInterval']);
        $this->assertEqual($row['operation_interval_id'], $currentOperationIntervalID);
        $this->assertEqual($row['interval_start'], $aDates['start']->format('%Y-%m-%d %H:%M:%S'));
        $this->assertEqual($row['interval_end'], $aDates['end']->format('%Y-%m-%d %H:%M:%S'));
        $this->assertEqual($row['ad_id'], 1);
        $this->assertEqual($row['zone_id'], 1);
        $this->assertEqual($row['required_impressions'], 1000);
        $this->assertEqual($row['requested_impressions'], 1000);
        $this->assertEqual($row['priority'], 0.45);
        $this->assertNull($row['priority_factor']);
        $this->assertFalse($row['priority_factor_limited']);
        $this->assertNull($row['past_zone_traffic_fraction']);
        $this->assertEqual($row['created'], $oOldDate->format('%Y-%m-%d %H:%M:%S'));
        $this->assertEqual($row['created_by'], 0);
        $this->assertEqual($row['expired'], $oDate->format('%Y-%m-%d %H:%M:%S'));
        $this->assertEqual($row['expired_by'], 0);
        $query = "
            SELECT
                operation_interval,
                operation_interval_id,
                interval_start,
                interval_end,
                ad_id,
                zone_id,
                required_impressions,
                requested_impressions,
                priority,
                priority_factor,
                priority_factor_limited,
                past_zone_traffic_fraction,
                created,
                created_by,
                expired,
                expired_by
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_summary_ad_zone_assoc']}
            WHERE
                ad_id = 1
                AND expired IS NULL";
        $row = $dbh->getRow($query);
        $currentOperationIntervalID = MAX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $aDates = MAX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oDate);
        $this->assertEqual($row['operation_interval'], $conf['maintenance']['operationInterval']);
        $this->assertEqual($row['operation_interval_id'], $currentOperationIntervalID);
        $this->assertEqual($row['interval_start'], $aDates['start']->format('%Y-%m-%d %H:%M:%S'));
        $this->assertEqual($row['interval_end'], $aDates['end']->format('%Y-%m-%d %H:%M:%S'));
        $this->assertEqual($row['ad_id'], 1);
        $this->assertEqual($row['zone_id'], 1);
        $this->assertEqual($row['required_impressions'], 2000);
        $this->assertEqual($row['requested_impressions'], 2000);
        $this->assertEqual($row['priority'], 0.9);
        $this->assertEqual($row['priority_factor'], 0.1);
        $this->assertFalse($row['priority_factor_limited']);
        $this->assertEqual($row['past_zone_traffic_fraction'], 0.99);
        $this->assertEqual($row['created'], $oDate->format('%Y-%m-%d %H:%M:%S'));
        $this->assertEqual($row['created_by'], 0);
        $this->assertNull($row['expired']);
        $this->assertNull($row['expired_by']);
        $query = "
            SELECT
                operation_interval,
                operation_interval_id,
                interval_start,
                interval_end,
                ad_id,
                zone_id,
                required_impressions,
                requested_impressions,
                priority,
                priority_factor,
                priority_factor_limited,
                past_zone_traffic_fraction,
                created,
                created_by,
                expired,
                expired_by
            FROM
                {$conf['table']['prefix']}{$conf['table']['data_summary_ad_zone_assoc']}
            WHERE
                ad_id = 2";
        $row = $dbh->getRow($query);
        $currentOperationIntervalID = MAX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $aDates = MAX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oDate);
        $this->assertEqual($row['operation_interval'], $conf['maintenance']['operationInterval']);
        $this->assertEqual($row['operation_interval_id'], $currentOperationIntervalID);
        $this->assertEqual($row['interval_start'], $aDates['start']->format('%Y-%m-%d %H:%M:%S'));
        $this->assertEqual($row['interval_end'], $aDates['end']->format('%Y-%m-%d %H:%M:%S'));
        $this->assertEqual($row['ad_id'], 2);
        $this->assertEqual($row['zone_id'], 2);
        $this->assertEqual($row['required_impressions'], 500);
        $this->assertEqual($row['requested_impressions'], 500);
        $this->assertEqual($row['priority'], 0.1);
        $this->assertEqual($row['priority_factor'], 0.2);
        $this->assertTrue($row['priority_factor_limited']);
        $this->assertEqual($row['past_zone_traffic_fraction'], 0.45);
        $this->assertEqual($row['created'], $oDate->format('%Y-%m-%d %H:%M:%S'));
        $this->assertEqual($row['created_by'], 0);
        $this->assertNull($row['expired']);
        $this->assertNull($row['expired_by']);

        // Test 4
        $aData = array();
        for ($i = 1; $i < 5000; $i++) {
            $aData[$i] =
                array(
                    'ads' => array(
                        array(
                            'ad_id'                      => $i,
                            'zone_id'                    => $i,
                            'required_impressions'       => 2000,
                            'requested_impressions'      => 2000,
                            'priority'                   => 0.9,
                            'priority_factor'            => 0.1,
                            'priority_factor_limited'    => false,
                            'past_zone_traffic_fraction' => 0.99
                        )
                    )
                );
        }
        $oOldDate = new Date();
        $oOldDate->copy($oDate);
        $oDate = new Date();
        $oServiceLocator->register('now', $oDate);
        $result = $oMaxDalMaintenance->updatePriorities($aData);
        TestEnv::restoreEnv();
    }

    /**
     * Test 1 - check values and format of return values
     *
     * @TODO Implement tests to check date range being applied correctly
     */
    function testGetZonesImpressionAverageByRange()
    {
        TestEnv::startTransaction();
        $dbh = &MAX_DB::singleton();
        // Set up test test data
        $conf = $GLOBALS['_MAX']['CONF'];
        // Write two record for same interval id one week apart
        $query = "INSERT INTO
                    {$conf['table']['prefix']}{$conf['table']['data_summary_zone_impression_history']}
                    (
                        data_summary_zone_impression_history_id,
                        operation_interval,
                        operation_interval_id,
                        interval_start,
                        interval_end,
                        zone_id,
                        forecast_impressions,
                        actual_impressions
                    )
                    VALUES
                    (1, 60, 0, '2005-05-02 00:00:00',  '2005-05-02 00:59:59',  1,  200,    400),
                    (2, 60, 0, '2005-05-09 00:00:00',  '2005-05-09 00:59:59',  1,  100,    200),
                    (3, 60, 1, '2005-05-02 01:00:00',  '2005-05-02 01:59:59',  1,  200,    500),
                    (4, 60, 1, '2005-05-09 01:00:00',  '2005-05-09 01:59:59',  1,  100,    700)";
        $conf = $GLOBALS['_MAX']['CONF'];
        $dbh->query($query);

        // Set up operation interval date range to query
        $oStartDate = new Date('2005-05-16 00:00:00');
        $oEndDate = new Date('2005-05-16 01:59:59');

        // Array of zone ids to resolve
        $aZones = array(1);

        // Number of weeks to get average over
        $weeks = 2;
        $oMaxDalMaintenance = new MAX_Dal_Maintenance_Priority();
        $result = &$oMaxDalMaintenance->getZonesImpressionAverageByRange($aZones, $oStartDate, $oEndDate, $weeks);

        $this->assertEqual(count($result), 1);
        $this->assertEqual(count($result[1]), 2);

        $this->assertEqual($result[1][0]['zone_id'], 1);
        $this->assertEqual($result[1][0]['operation_interval_id'], 0);
        $this->assertEqual($result[1][0]['average_impressions'], 300);

        $this->assertEqual($result[1][1]['zone_id'], 1);
        $this->assertEqual($result[1][1]['operation_interval_id'], 1);
        $this->assertEqual($result[1][1]['average_impressions'], 600);

        TestEnv::rollbackTransaction();
    }

    /**
     * Test 1 - check values and format of return values
     *
     * @TODO Implement tests to check date range being applied correctly
     */
    function testGetZonesImpressionHistoryByRange()
    {
        TestEnv::startTransaction();
        $dbh = &MAX_DB::singleton();
        // set up test test data
        $conf = $GLOBALS['_MAX']['CONF'];
        // write two record for same interval id one week apart
        $query = "INSERT INTO
                    {$conf['table']['prefix']}{$conf['table']['data_summary_zone_impression_history']}
                    (
                        data_summary_zone_impression_history_id,
                        operation_interval,
                        operation_interval_id,
                        interval_start,
                        interval_end,
                        zone_id,
                        forecast_impressions,
                        actual_impressions
                    )
                    VALUES
                    (1,  60, 0,  '2005-05-09 00:00:00',  '2005-05-09 00:59:59',  1,  100,   700),
                    (2,  60, 1,  '2005-05-09 01:00:00',  '2005-05-09 01:59:59',  1,  200,   300),
                    (3,  60, 2,  '2005-05-09 02:00:00',  '2005-05-09 02:59:59',  1,  300,   400),
                    (4,  60, 3,  '2005-05-09 03:00:00',  '2005-05-09 03:59:59',  1,  500,   200),
                    (5,  60, 4,  '2005-05-09 04:00:00',  '2005-05-09 04:59:59',  1,  500,   600),
                    (6,  60, 5,  '2005-05-09 05:00:00',  '2005-05-09 05:59:59',  1,  600,   700)";
        $conf = $GLOBALS['_MAX']['CONF'];
        $dbh->query($query);

        // Set up operation interval date range to query
        $oStartDate = new Date('2005-05-09 01:00:00');
        $oEndDate = new Date('2005-05-09 04:00:00');

        // Array of zone ids to resolve
        $aZones = array(1);

        // Number of weeks to get average over
        $weeks = 2;
        $oMaxDalMaintenance = new MAX_Dal_Maintenance_Priority();
        $result = &$oMaxDalMaintenance->getZonesImpressionHistoryByRange($aZones, $oStartDate, $oEndDate);

        $this->assertEqual(count($result), 1);
        $this->assertEqual(count($result[1]), 4);
        $this->assertEqual($result[1][1]['zone_id'], 1);
        $this->assertEqual($result[1][1]['operation_interval_id'], 1);
        $this->assertEqual($result[1][1]['forecast_impressions'], 200);

        $this->assertEqual($result[1][1]['actual_impressions'], 300);
        $this->assertEqual($result[1][2]['zone_id'], 1);
        $this->assertEqual($result[1][2]['operation_interval_id'], 2);
        $this->assertEqual($result[1][2]['forecast_impressions'], 300);
        $this->assertEqual($result[1][2]['actual_impressions'], 400);

        $this->assertEqual($result[1][3]['zone_id'], 1);
        $this->assertEqual($result[1][3]['operation_interval_id'], 3);
        $this->assertEqual($result[1][3]['forecast_impressions'], 500);
        $this->assertEqual($result[1][3]['actual_impressions'], 200);

        $this->assertEqual($result[1][4]['zone_id'], 1);
        $this->assertEqual($result[1][4]['operation_interval_id'], 4);
        $this->assertEqual($result[1][4]['forecast_impressions'], 500);
        $this->assertEqual($result[1][4]['actual_impressions'], 600);

        TestEnv::rollbackTransaction();
    }

    /**
     * A method to test the saveZoneImpressionForecasts method.
     */
    function testSaveZoneImpressionForecasts()
    {
        TestEnv::startTransaction();
        $dbh = &MAX_DB::singleton();
        // Test data
        $aForecasts = array(
            1 => array(
                0 => array('forecast_impressions' => 100, 'interval_start' => '2005-05-20 00:00:00', 'interval_end' => '2005-05-20 00:59:59'),
                1 => array('forecast_impressions' => 200, 'interval_start' => '2005-05-20 01:00:00', 'interval_end' => '2005-05-20 01:59:59'),
                2 => array('forecast_impressions' => 300, 'interval_start' => '2005-05-20 02:00:00', 'interval_end' => '2005-05-20 02:59:59'),
            ),
            2 => array(
                0 => array('forecast_impressions' => 200, 'interval_start' => '2005-05-20 00:00:00', 'interval_end' => '2005-05-20 00:59:59'),
                1 => array('forecast_impressions' => 400, 'interval_start' => '2005-05-20 01:00:00', 'interval_end' => '2005-05-20 01:59:59'),
                2 => array('forecast_impressions' => 600, 'interval_start' => '2005-05-20 02:00:00', 'interval_end' => '2005-05-20 02:59:59'),
            )
        );

        // Run write method
        $oMaxDalMaintenance = new MAX_Dal_Maintenance_Priority();
        $oMaxDalMaintenance->saveZoneImpressionForecasts($aForecasts);

        // Test keys
        $conf = $GLOBALS['_MAX']['CONF'];
        $query = 'SELECT * from ' . $conf['table']['prefix'] . $conf['table']['data_summary_zone_impression_history'];
        $dbh->query($query);
        $row = $dbh->getAll($query);
        $this->assertTrue(isset($row[0]['data_summary_zone_impression_history_id']));
        $this->assertTrue(isset($row[0]['operation_interval']));
        $this->assertTrue(isset($row[0]['operation_interval_id']));
        $this->assertTrue(isset($row[0]['interval_start']));
        $this->assertTrue(isset($row[0]['interval_end']));
        $this->assertTrue(isset($row[0]['zone_id']));
        $this->assertTrue(isset($row[0]['forecast_impressions']));

        // Test forecast values written
        foreach($row as $key => $aValues) {
            $this->assertTrue($aValues['forecast_impressions'] > 0);
            $this->assertTrue(!(empty($aValues['interval_start'])));
            $this->assertTrue(!(empty($aValues['interval_end'])));
            // Bit funny way to test value, done so I can test in loop
            $this->assertEqual($aValues['forecast_impressions'], (($aValues['operation_interval_id'] + 1) * ($aValues['zone_id'] * 100)));
        }
        TestEnv::rollbackTransaction();
    }

    /**
     * A method to test the getActiveZones method.
     */
    function testGetActiveZones()
    {
        $da = new MAX_Dal_Maintenance_Priority();
        TestEnv::startTransaction();
        $this->_generateStatsTwo();
        $ret = $da->getActiveZones();

        $this->assertTrue(is_array($ret));
        $this->assertTrue(count($ret) == 1);
        $zone = $ret[0];
        $this->assertTrue(array_key_exists('zoneid', $zone));
        $this->assertTrue(array_key_exists('zonename', $zone));
        $this->assertTrue(array_key_exists('zonetype', $zone));
        TestEnv::rollbackTransaction();
    }

    /**
     * A method to test the setRequiredAdImpressions method.
     */
    function testSaveRequiredAdImpressions()
    {
        $oDal = new MAX_Dal_Maintenance_Priority();
        $oTable = &Openads_Table_Priority::singleton();
        $oTable->createTable('tmp_ad_required_impression');
        $aData = array(
            array(
                'ad_id'                => 23,
                'required_impressions' => 140,
            )
        );
        $result = $oDal->saveRequiredAdImpressions($aData);
        $dbh = &MAX_DB::singleton();
        $query = "SELECT * FROM tmp_ad_required_impression";
        $result = $dbh->getAll($query);
        $this->assertTrue(is_array($result));
        $this->assertTrue(count($result) == 1);
        $item = $result[0];
        $this->assertTrue(array_key_exists('ad_id', $item));
        $this->assertTrue(array_key_exists('required_impressions', $item));
        $this->assertEqual($item['ad_id'], 23);
        $this->assertEqual($item['required_impressions'], 140);
        TestEnv::restoreEnv();
    }

    /**
     * A method to test the getRequiredAdImpressions method.
     */
    function testGetRequiredAdImpressions()
    {
        $oDal = new MAX_Dal_Maintenance_Priority();
        $oTable = &Openads_Table_Priority::singleton();
        $oTable->createTable('tmp_ad_required_impression');
        $aData = array(
            array(
                'ad_id'                => 23,
                'required_impressions' => 140,
            ),
            array(
                'ad_id'                => 29,
                'required_impressions' => 120,
            )
        );
        $result = $oDal->saveRequiredAdImpressions($aData);
        $aAdvertID = array(
            1,
            2,
            29
        );
        $aData = $oDal->getRequiredAdImpressions($aAdvertID);
        $this->assertEqual(count($aData), 1);
        $this->assertTrue(array_key_exists(29, $aData));
        $this->assertEqual($aData[29], 120);
        TestEnv::restoreEnv();
    }

    /**
     * A method to test the getZoneImpressionForecasts() method.
     *
     * Test 1: Test with no date registered in the ServiceLocator, and ensure that
     *         false is returned.
     * Test 2: Test with a date registered in the ServiceLocator, but no data in
     *         the database, and ensure that an empty array is returned.
     * Test 3: Test with zones in the system, but no forecasts, and ensure that
     *         the default forecast value is returned for all the zones.
     * Test 4: Test with the same zones, but with forecasts > the default forecast
     *         value, and ensure that the correct forecasts are returned for all
     *         the zones.
     * Test 5: Test with the same zones, but with forecasts > and < the default
     *         forecast value, and ensure that the correct forecasts are returned
     *         for all the zones.
     * Test 6: Re-test, but also include a new zone, and older zone forecasts.
     */
    function testGetZoneImpressionForecasts()
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $dbh = &MAX_DB::singleton();
        $oDal = new MAX_Dal_Maintenance_Priority();

        // Test 1
        $oServiceLocator = &ServiceLocator::instance();
        $oServiceLocator->remove('now');
        $result = $oDal->getZoneImpressionForecasts();
        $this->assertFalse($result);

        // Test 2
        $oDate = new Date();
        $oServiceLocator->register('now', $oDate);
        $result = $oDal->getZoneImpressionForecasts();
        $this->assertTrue(is_array($result));
        $this->assertEqual(count($result), 0);

        // Test 3
        TestEnv::startTransaction();
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['zones']}
                (
                    zoneid,
                    affiliateid,
                    zonename
                )
            VALUES
                (
                    1,
                    1,
                    'Test Zone 1'
                ),
                (
                    2,
                    1,
                    'Test Zone 2'
                )";
        $dbh->query($query);
        $result = $oDal->getZoneImpressionForecasts();
        $this->assertTrue(is_array($result));
        $this->assertEqual(count($result), 2);
        $this->assertEqual($result[1], $conf['priority']['defaultZoneForecastImpressions']);
        $this->assertEqual($result[2], $conf['priority']['defaultZoneForecastImpressions']);
        TestEnv::rollbackTransaction();

        // Test 4
        TestEnv::startTransaction();
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['zones']}
                (
                    zoneid,
                    affiliateid,
                    zonename
                )
            VALUES
                (
                    1,
                    1,
                    'Test Zone 1'
                ),
                (
                    2,
                    1,
                    'Test Zone 2'
                )";
        $dbh->query($query);
        $aDates = MAX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oDate);
        $operationIntervalID = MAX_OperationInterval::convertDateToOperationIntervalID($aDates['start']);
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_summary_zone_impression_history']}
                (
                    operation_interval,
                    operation_interval_id,
                    interval_start,
                    interval_end,
                    zone_id,
                    forecast_impressions
                )
            VALUES
                (
                    {$conf['maintenance']['operationInterval']},
                    $operationIntervalID,
                    '" . $aDates['start']->format('%Y-%m-%d %H:%M:%S') . "',
                    '" . $aDates['end']->format('%Y-%m-%d %H:%M:%S') . "',
                    1,
                    " . ($conf['priority']['defaultZoneForecastImpressions'] + 20) . "
                ),
                (
                    {$conf['maintenance']['operationInterval']},
                    $operationIntervalID,
                    '" . $aDates['start']->format('%Y-%m-%d %H:%M:%S') . "',
                    '" . $aDates['end']->format('%Y-%m-%d %H:%M:%S') . "',
                    2,
                    " . ($conf['priority']['defaultZoneForecastImpressions'] + 40) . "
                )";
        $dbh->query($query);
        $result = $oDal->getZoneImpressionForecasts();
        $this->assertTrue(is_array($result));
        $this->assertEqual(count($result), 2);
        $this->assertEqual($result[1], $conf['priority']['defaultZoneForecastImpressions'] + 20);
        $this->assertEqual($result[2], $conf['priority']['defaultZoneForecastImpressions'] + 40);
        TestEnv::rollbackTransaction();

        // Test 5
        TestEnv::startTransaction();
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['zones']}
                (
                    zoneid,
                    affiliateid,
                    zonename
                )
            VALUES
                (
                    1,
                    1,
                    'Test Zone 1'
                ),
                (
                    2,
                    1,
                    'Test Zone 2'
                )";
        $dbh->query($query);
        $aDates = MAX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oDate);
        $operationIntervalID = MAX_OperationInterval::convertDateToOperationIntervalID($aDates['start']);
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_summary_zone_impression_history']}
                (
                    operation_interval,
                    operation_interval_id,
                    interval_start,
                    interval_end,
                    zone_id,
                    forecast_impressions
                )
            VALUES
                (
                    {$conf['maintenance']['operationInterval']},
                    $operationIntervalID,
                    '" . $aDates['start']->format('%Y-%m-%d %H:%M:%S') . "',
                    '" . $aDates['end']->format('%Y-%m-%d %H:%M:%S') . "',
                    1,
                    " . ($conf['priority']['defaultZoneForecastImpressions'] - 1) . "
                ),
                (
                    {$conf['maintenance']['operationInterval']},
                    $operationIntervalID,
                    '" . $aDates['start']->format('%Y-%m-%d %H:%M:%S') . "',
                    '" . $aDates['end']->format('%Y-%m-%d %H:%M:%S') . "',
                    2,
                    " . ($conf['priority']['defaultZoneForecastImpressions'] + 40) . "
                )";
        $dbh->query($query);
        $result = $oDal->getZoneImpressionForecasts();
        $this->assertTrue(is_array($result));
        $this->assertEqual(count($result), 2);
        $this->assertEqual($result[1], $conf['priority']['defaultZoneForecastImpressions']);
        $this->assertEqual($result[2], $conf['priority']['defaultZoneForecastImpressions'] + 40);
        TestEnv::rollbackTransaction();

        // Test 6
        TestEnv::startTransaction();
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['zones']}
                (
                    zoneid,
                    affiliateid,
                    zonename
                )
            VALUES
                (
                    1,
                    1,
                    'Test Zone 1'
                ),
                (
                    2,
                    1,
                    'Test Zone 2'
                ),
                (
                    5,
                    2,
                    'Test Zone 5'
                )";
        $dbh->query($query);
        $aDates = MAX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oDate);
        $operationIntervalID = MAX_OperationInterval::convertDateToOperationIntervalID($aDates['start']);
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_summary_zone_impression_history']}
                (
                    operation_interval,
                    operation_interval_id,
                    interval_start,
                    interval_end,
                    zone_id,
                    forecast_impressions
                )
            VALUES
                (
                    {$conf['maintenance']['operationInterval']},
                    $operationIntervalID,
                    '" . $aDates['start']->format('%Y-%m-%d %H:%M:%S') . "',
                    '" . $aDates['end']->format('%Y-%m-%d %H:%M:%S') . "',
                    1,
                    " . ($conf['priority']['defaultZoneForecastImpressions'] - 1) . "
                ),
                (
                    {$conf['maintenance']['operationInterval']},
                    $operationIntervalID,
                    '" . $aDates['start']->format('%Y-%m-%d %H:%M:%S') . "',
                    '" . $aDates['end']->format('%Y-%m-%d %H:%M:%S') . "',
                    2,
                    " . ($conf['priority']['defaultZoneForecastImpressions'] + 40) . "
                )";
        $dbh->query($query);
        $aDates = MAX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($oDate);
        $operationIntervalID = MAX_OperationInterval::convertDateToOperationIntervalID($aDates['start']);
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_summary_zone_impression_history']}
                (
                    operation_interval,
                    operation_interval_id,
                    interval_start,
                    interval_end,
                    zone_id,
                    forecast_impressions
                )
            VALUES
                (
                    {$conf['maintenance']['operationInterval']},
                    $operationIntervalID,
                    '" . $aDates['start']->format('%Y-%m-%d %H:%M:%S') . "',
                    '" . $aDates['end']->format('%Y-%m-%d %H:%M:%S') . "',
                    1,
                    " . ($conf['priority']['defaultZoneForecastImpressions'] + 100) . "
                ),
                (
                    {$conf['maintenance']['operationInterval']},
                    $operationIntervalID,
                    '" . $aDates['start']->format('%Y-%m-%d %H:%M:%S') . "',
                    '" . $aDates['end']->format('%Y-%m-%d %H:%M:%S') . "',
                    2,
                    " . ($conf['priority']['defaultZoneForecastImpressions'] + 100) . "
                )";
        $dbh->query($query);
        $result = $oDal->getZoneImpressionForecasts();
        $this->assertTrue(is_array($result));
        $this->assertEqual(count($result), 3);
        $this->assertEqual($result[1], $conf['priority']['defaultZoneForecastImpressions']);
        $this->assertEqual($result[2], $conf['priority']['defaultZoneForecastImpressions'] + 40);
        $this->assertEqual($result[5], $conf['priority']['defaultZoneForecastImpressions']);
        TestEnv::rollbackTransaction();
    }

    /**
     * A method to test the getAdZoneAssociationsByAds method.
     *
     * Test 1: Test with bad input, and ensure that an empty array is retuend.
     * Test 2: Test with no data, and ensure that an empty array is returned.
     * Test 3: Test with one ad/zone link, and ensure the correct data is returned.
     * Test 4: Test with a more complex set of data.
     */
    function testGetAdZoneAssociationsByAds()
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $dbh = &MAX_DB::singleton();
        $oDal = new MAX_Dal_Maintenance_Priority();

        // Test 1
        $result = $oDal->getAdZoneAssociationsByAds(1);
        $this->assertTrue(is_array($result));
        $this->assertEqual(count($result), 0);

        // Test 2
        $aAdIds = array(1);
        $result = $oDal->getAdZoneAssociationsByAds($aAdIds);
        $this->assertTrue(is_array($result));
        $this->assertEqual(count($result), 0);

        // Test 3
        TestEnv::startTransaction();
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['ad_zone_assoc']}
                (
                    ad_id,
                    zone_id,
                    link_type
                )
            VALUES
                (
                    1,
                    1,
                    1
                )";
        $dbh->query($query);
        $aAdIds = array(1);
        $result = $oDal->getAdZoneAssociationsByAds($aAdIds);
        $this->assertTrue(is_array($result));
        $this->assertEqual(count($result), 1);
        $this->assertTrue(is_array($result[1]));
        $this->assertEqual(count($result[1]), 1);
        $this->assertTrue(is_array($result[1][0]));
        $this->assertEqual(count($result[1][0]), 1);
        $this->assertTrue(isset($result[1][0]['zone_id']));
        $this->assertEqual($result[1][0]['zone_id'], 1);
        TestEnv::rollbackTransaction();

        // Test 4
        TestEnv::startTransaction();
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['ad_zone_assoc']}
                (
                    ad_id,
                    zone_id,
                    link_type
                )
            VALUES
                (
                    1,
                    1,
                    1
                ),
                (
                    1,
                    2,
                    1
                ),
                (
                    1,
                    7,
                    1
                ),
                (
                    2,
                    2,
                    1
                ),
                (
                    2,
                    7,
                    0
                ),
                (
                    3,
                    1,
                    1
                ),
                (
                    3,
                    9,
                    1
                )";
        $dbh->query($query);
        $aAdIds = array(1, 2, 3);
        $result = $oDal->getAdZoneAssociationsByAds($aAdIds);
        $this->assertTrue(is_array($result));
        $this->assertEqual(count($result), 3);
        $this->assertTrue(is_array($result[1]));
        $this->assertEqual(count($result[1]), 3);
        $this->assertTrue(is_array($result[1][0]));
        $this->assertEqual(count($result[1][0]), 1);
        $this->assertTrue(isset($result[1][0]['zone_id']));
        $this->assertEqual($result[1][0]['zone_id'], 1);
        $this->assertTrue(is_array($result[1][1]));
        $this->assertEqual(count($result[1][1]), 1);
        $this->assertTrue(isset($result[1][1]['zone_id']));
        $this->assertEqual($result[1][1]['zone_id'], 2);
        $this->assertTrue(is_array($result[1][2]));
        $this->assertEqual(count($result[1][2]), 1);
        $this->assertTrue(isset($result[1][2]['zone_id']));
        $this->assertEqual($result[1][2]['zone_id'], 7);
        $this->assertTrue(is_array($result[2]));
        $this->assertEqual(count($result[2]), 1);
        $this->assertTrue(is_array($result[2][0]));
        $this->assertEqual(count($result[2][0]), 1);
        $this->assertTrue(isset($result[2][0]['zone_id']));
        $this->assertEqual($result[2][0]['zone_id'], 2);
        $this->assertTrue(is_array($result[3]));
        $this->assertEqual(count($result[3]), 2);
        $this->assertTrue(is_array($result[3][0]));
        $this->assertEqual(count($result[3][0]), 1);
        $this->assertTrue(isset($result[3][0]['zone_id']));
        $this->assertEqual($result[3][0]['zone_id'], 1);
        $this->assertTrue(is_array($result[3][1]));
        $this->assertEqual(count($result[3][1]), 1);
        $this->assertTrue(isset($result[3][1]['zone_id']));
        $this->assertEqual($result[3][1]['zone_id'], 9);
        TestEnv::rollbackTransaction();
    }

    /**
     * A method to test the saveAllocatedImpressions method.
     */
    function testSaveAllocatedImpressions()
    {
        $dbh = &MAX_DB::singleton();
        $oDal = new MAX_Dal_Maintenance_Priority();
        // Create the required temporary table for the tests
        $oTable = &Openads_Table_Priority::singleton();
        $oTable->createTable('tmp_ad_zone_impression');
        // Prepare the test data
        $aData = array(
            array(
                'ad_id'       => 56,
                'zone_id'     => 11,
                'required_impressions' => 9997,
                'requested_impressions' => 9000
            ),
            array(
                'ad_id'       => 56,
                'zone_id'     => 12,
                'required_impressions' => 24,
                'requested_impressions' => 24
            )
        );
        $result = $oDal->saveAllocatedImpressions($aData);
        $query = "SELECT * FROM tmp_ad_zone_impression ORDER BY ad_id, zone_id";
        $result = $dbh->getAll($query);
        $this->assertTrue(is_array($result));
        $this->assertTrue(count($result) == 2);
        $tmp = $result[0];
        $this->assertTrue(array_key_exists('ad_id', $tmp));
        $this->assertEqual($tmp['ad_id'], 56);
        $this->assertTrue(array_key_exists('zone_id', $tmp));
        $this->assertEqual($tmp['zone_id'], 11);
        $this->assertTrue(array_key_exists('required_impressions', $tmp));
        $this->assertEqual($tmp['required_impressions'], 9997);
        $this->assertTrue(array_key_exists('requested_impressions', $tmp));
        $this->assertEqual($tmp['requested_impressions'], 9000);
        $tmp = $result[1];
        $this->assertTrue(array_key_exists('ad_id', $tmp));
        $this->assertEqual($tmp['ad_id'], 56);
        $this->assertTrue(array_key_exists('zone_id', $tmp));
        $this->assertEqual($tmp['zone_id'], 12);
        $this->assertTrue(array_key_exists('required_impressions', $tmp));
        $this->assertEqual($tmp['required_impressions'], 24);
        $this->assertTrue(array_key_exists('requested_impressions', $tmp));
        $this->assertEqual($tmp['requested_impressions'], 24);
        TestEnv::restoreEnv();
    }

    /**
     * A method to test the getPreviousWeekZoneForcastImpressions() method.
     *
     * Test 1: Test with bad input, and ensure false is returned.
     * Test 2: Test with no date in the service locator, and ensure that
     *         false is returned.
     * Test 3: Test with no data, and ensure that an array with the default
     *         forecast for each zone is returned.
     * Test 4: Test with data, and ensure that an array with the correct
     *         forecasts is returned.
     */
    function testGetPreviousWeekZoneForcastImpressions()
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $dbh = &MAX_DB::singleton();
        $oDal = new MAX_Dal_Maintenance_Priority();

        // Test 1
        $result = $oDal->getPreviousWeekZoneForcastImpressions('foo');
        $this->assertFalse($result);

        // Test 2
        $oServiceLocator = &ServiceLocator::instance();
        $oServiceLocator->remove('now');
        $result = $oDal->getPreviousWeekZoneForcastImpressions(1);
        $this->assertFalse($result);

        // Test 3
        $oDate = new Date();
        $oServiceLocator->register('now', $oDate);
        $result = $oDal->getPreviousWeekZoneForcastImpressions(1);
        $this->assertTrue(is_array($result));
        $this->assertEqual(count($result), (MINUTES_PER_WEEK / $conf['maintenance']['operationInterval']));
        for ($i = 0; $i < (MINUTES_PER_WEEK / $conf['maintenance']['operationInterval']); $i++) {
            $this->assertTrue(is_array($result[$i]));
            $this->assertEqual(count($result[$i]), 3);
            $this->assertEqual($result[$i]['zone_id'], 1);
            $this->assertEqual($result[$i]['forecast_impressions'], $conf['priority']['defaultZoneForecastImpressions']);
            $this->assertEqual($result[$i]['operation_interval_id'], $i);
        }

        // Test 4
        TestEnv::startTransaction();
        // Insert forcast for this operation interval
        $aDates = MAX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oDate);
        $firstIntervalID = MAX_OperationInterval::convertDateToOperationIntervalID($aDates['start']);
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_summary_zone_impression_history']}
                (
                    zone_id,
                    forecast_impressions,
                    operation_interval,
                    operation_interval_id,
                    interval_start,
                    interval_end
                )
            VALUES
                (
                    1,
                    4000,
                    {$conf['maintenance']['operationInterval']},
                    $firstIntervalID,
                    '" . $aDates['start']->format('%Y-%m-%d %H:%M:%S') . "',
                    '" . $aDates['end']->format('%Y-%m-%d %H:%M:%S') . "'
                )";
        $dbh->query($query);
        // Insert forcast for the previous operation interval
        $aDates = MAX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($aDates['start']);
        $secondIntervalID = MAX_OperationInterval::convertDateToOperationIntervalID($aDates['start']);
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_summary_zone_impression_history']}
                (
                    zone_id,
                    forecast_impressions,
                    operation_interval,
                    operation_interval_id,
                    interval_start,
                    interval_end
                )
            VALUES
                (
                    1,
                    5000,
                    {$conf['maintenance']['operationInterval']},
                    $secondIntervalID,
                    '" . $aDates['start']->format('%Y-%m-%d %H:%M:%S') . "',
                    '" . $aDates['end']->format('%Y-%m-%d %H:%M:%S') . "'
                )";
        $dbh->query($query);
        // Insert forcast for the second previous operation interval, but
        // one week ago (so it should not be in the result set)
        $oNewDate = new Date();
        $oNewDate->copy($aDates['start']);
        $oNewDate->subtractSeconds(SECONDS_PER_WEEK);
        $aDates = MAX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($oNewDate);
        $intervalID = MAX_OperationInterval::convertDateToOperationIntervalID($aDates['start']);
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_summary_zone_impression_history']}
                (
                    zone_id,
                    forecast_impressions,
                    operation_interval,
                    operation_interval_id,
                    interval_start,
                    interval_end
                )
            VALUES
                (
                    1,
                    10000,
                    {$conf['maintenance']['operationInterval']},
                    $intervalID,
                    '" . $aDates['start']->format('%Y-%m-%d %H:%M:%S') . "',
                    '" . $aDates['end']->format('%Y-%m-%d %H:%M:%S') . "'
                )";
        $dbh->query($query);
        $result = $oDal->getPreviousWeekZoneForcastImpressions(1);
        $this->assertTrue(is_array($result));
        $this->assertEqual(count($result), (MINUTES_PER_WEEK / $conf['maintenance']['operationInterval']));
        for ($i = 0; $i < (MINUTES_PER_WEEK / $conf['maintenance']['operationInterval']); $i++) {
            $this->assertTrue(is_array($result[$i]));
            $this->assertEqual(count($result[$i]), 3);
            $this->assertEqual($result[$i]['zone_id'], 1);
            if ($i == $firstIntervalID) {
                $this->assertEqual($result[$i]['forecast_impressions'], 4000);
            } elseif ($i == $secondIntervalID) {
                $this->assertEqual($result[$i]['forecast_impressions'], 5000);
            } else {
                $this->assertEqual($result[$i]['forecast_impressions'], $conf['priority']['defaultZoneForecastImpressions']);
            }
            $this->assertEqual($result[$i]['operation_interval_id'], $i);
        }
        TestEnv::rollbackTransaction();
    }

    /**
     * A method for testing the obtainPriorityLock and
     * releasePriorityLock methods.
     *
     * @TODO Complete testing using a separate client connection to
     *       ensure locking works.
     */
    function testLocking()
    {
        $dbh = &MAX_DB::singleton();
        $oDal = new MAX_Dal_Maintenance_Priority();
        // Try to get the lock
        $result = $oDal->obtainPriorityLock();
        $this->assertTrue($result);
        // Try to get the lock again, with a brand new connection,
        // and ensure that the lock is NOT obtained

        // Release the lock
        $result = $oDal->releasePriorityLock();
        $this->assertTrue($result);
        // Try to get the lock again with the new connection, and
        // ensure the lock IS obtained

        // Release the lock from the new connection

    }

    /**
     * A method to generate data for testing.
     *
     * @access private
     */
    function _generateStatsOne()
    {
        $conf = &$GLOBALS['_MAX']['CONF'];
        $dbh = &MAX_DB::singleton();

        $date = new Date();
        $date->addSeconds((SECONDS_PER_DAY * 4));
        $expiryDate1 = $date->getYear() . "-" . $date->getMonth() . "-" . $date->getDay();

        $date->addSeconds((SECONDS_PER_DAY * 4));
        $expiryDate2 = $date->getYear() . "-" . $date->getMonth() . "-" . $date->getDay();

        $date->subtractSeconds((SECONDS_PER_DAY * 2));
        $expiryDateLessTwoDays = $date->getYear() . "-" . $date->getMonth() . "-" . $date->getDay();

        //  Add 3 campaigns
        $campaignsTable = $conf['table']['prefix'] . 'campaigns';
        $sql = "INSERT INTO $campaignsTable
        (campaignid, campaignname,      clientid,   views,  clicks, conversions,    expire,             activate,       active,     priority,   weight, target_impression, anonymous)
        VALUES (1,   'test  campaign',  1,          0,      400,      0,          '" . $expiryDate1 . "',  '0000-00-00',   't',        '3',        1,      0,        'f')";
        $result = $dbh->query($sql);

        $sql = "INSERT INTO $campaignsTable
        (campaignid, campaignname,      clientid,   views,  clicks, conversions,    expire,             activate,       active,     priority,   weight, target_impression, anonymous)
        VALUES (2,   'test  campaign',  1,          0,      0,        400,          '0000-00-00',         '0000-00-00',   't',         '2',        1,      0,        'f')";
        $result = $dbh->query($sql);

        $sql = "INSERT INTO $campaignsTable
        (campaignid, campaignname,      clientid,   views,  clicks, conversions,    expire,             activate,       active,     priority,   weight, target_impression, anonymous)
        VALUES (3,   'test  campaign',  1,          500,      0,      0,            '" . $expiryDate2 . "', '0000-00-00',   't',       '3',        1,      0,        'f')";
        $result = $dbh->query($sql);

        $sql = "INSERT INTO $campaignsTable
        (campaignid, campaignname,      clientid,   views,  clicks, conversions,    expire,             activate,       active,     priority,   weight, target_impression, anonymous)
        VALUES (4,   'test  campaign',  1,          500,      0,      401,          '0000-00-00',  '0000-00-00',   't',                '4',        2,      0,        'f')";
        $result = $dbh->query($sql);

        $sql = "INSERT INTO $campaignsTable
        (campaignid, campaignname,      clientid,   views,  clicks, conversions,    expire,             activate,       active,     priority,   weight, target_impression, anonymous)
        VALUES (5,   'test  campaign',  1,          500,      0,      401,          '0000-00-00',  '0000-00-00',   't',                '3',        2,      0,        'f')";
        $result = $dbh->query($sql);




        //  add a banner to campaign 1
        $bannersTable = $conf['table']['prefix'] . 'banners';
        $sql = "INSERT INTO $bannersTable (bannerid, campaignid, active, contenttype, pluginversion, storagetype, filename, imageurl, htmltemplate, htmlcache, width, height, weight, seq, target, url, alt, status, bannerTEXT, description, autohtml, adserver, block, capping, session_capping, compiledlimitation, append, appendtype, bannertype, alt_filename, alt_imageurl, alt_contenttype)
        VALUES (1,1,'t','gif',0,'sql','468x60_4.gif','','','',468,60,1,0,'','http://www.google.com','Campaign1 - Banner 1','','','','f','',0, 0,0,'','',0,0,'','','');";
        $result = $dbh->query($sql);

        // add Campaign 1 - banner 1 - acls delivery restrictions
        $aclsTable = $conf['table']['prefix'] . 'acls';
        $sql = "INSERT INTO $aclsTable (bannerid,   logical, type,     comparison, data,                        executionorder)
                                VALUES (1,          'and',   'date',   '!=',       '$expiryDateLessTwoDays',    0)";
        $result = $dbh->query($sql);

        $sql = "INSERT INTO $aclsTable (bannerid,   logical, type,     comparison, data,   executionorder)
                                VALUES (1,          'and',   'time',   '!=',       '1',    1)";
        $result = $dbh->query($sql);

        // add 2nd banner to campaign 1
        $bannersTable = $conf['table']['prefix'] . 'banners';
        $sql = "INSERT INTO $bannersTable (bannerid, campaignid, active, contenttype, pluginversion, storagetype, filename, imageurl, htmltemplate, htmlcache, width, height, weight, seq, target, url, alt, status, bannerTEXT, description, autohtml, adserver, block, capping, session_capping, compiledlimitation, append, appendtype, bannertype, alt_filename, alt_imageurl, alt_contenttype)
        VALUES (2,1,'t','gif',0,'sql','468x60_4.gif','','','',468,60,1,0,'','http://www.google.com','Campaign 1 - Banner 2','','','','f','',0, 0,0,'','',0,0,'','','');";
        $result = $dbh->query($sql);

        // add Campaign 1 - banner 2 - acls delivery restrictions
        $aclsTable = $conf['table']['prefix'] . 'acls';
        $sql = "INSERT INTO $aclsTable (bannerid,   logical, type,     comparison, data,                        executionorder)
                                VALUES (2,          'and',   'date',   '!=',       '$expiryDateLessTwoDays',    0)";
        $result = $dbh->query($sql);

        $sql = "INSERT INTO $aclsTable (bannerid,   logical, type,     comparison, data,   executionorder)
                                VALUES (2,          'and',   'time',   '!=',       '1,2',    1)";
        $result = $dbh->query($sql);



        //  add 1st banner to campaign 2
        $bannersTable = $conf['table']['prefix'] . 'banners';
        $sql = "INSERT INTO $bannersTable (bannerid, campaignid, active, contenttype, pluginversion, storagetype, filename, imageurl, htmltemplate, htmlcache, width, height, weight, seq, target, url, alt, status, bannerTEXT, description, autohtml, adserver, block, capping, session_capping, compiledlimitation, append, appendtype, bannertype, alt_filename, alt_imageurl, alt_contenttype)
        VALUES (3,2,'t','gif',0,'sql','468x60_4.gif','','','',468,60,1,0,'','http://www.google.com','Campaign 2 - Banner 1','','','','f','',0, 0,0,'','',0,0,'','','');";
        $result = $dbh->query($sql);

        // add 1st banner - Campaign 2 - acls delivery restrictions
        $aclsTable = $conf['table']['prefix'] . 'acls';
        $sql = "INSERT INTO $aclsTable (bannerid,   logical, type,     comparison, data,                        executionorder)
                                VALUES (3,          'and',   'date',   '!=',       '$expiryDateLessTwoDays',    0)";
        $result = $dbh->query($sql);

        $sql = "INSERT INTO $aclsTable (bannerid,   logical, type,     comparison, data,   executionorder)
                                VALUES (3,          'and',   'weekday',   '!=',       '5',    1)";
        $result = $dbh->query($sql);


        // add 2nd banner to campaign 2
        $bannersTable = $conf['table']['prefix'] . 'banners';
        $sql = "INSERT INTO $bannersTable (bannerid, campaignid, active, contenttype, pluginversion, storagetype, filename, imageurl, htmltemplate, htmlcache, width, height, weight, seq, target, url, alt, status, bannerTEXT, description, autohtml, adserver, block, capping, session_capping, compiledlimitation, append, appendtype, bannertype, alt_filename, alt_imageurl, alt_contenttype)
        VALUES (4,2,'t','gif',0,'sql','468x60_4.gif','','','',468,60,1,0,'','http://www.google.com','Campaign 2 - Banner 2','','','','f','',0, 0,0,'','',0,0,'','','');";
        $result = $dbh->query($sql);

        // add banner 2 - Campaign 1 - acls delivery restrictions
        $aclsTable = $conf['table']['prefix'] . 'acls';
        $sql = "INSERT INTO $aclsTable (bannerid,   logical, type,     comparison, data,                        executionorder)
                                VALUES (4,          'or',   'date',   '!=',       '$expiryDateLessTwoDays',    0)";
        $result = $dbh->query($sql);

        $sql = "INSERT INTO $aclsTable (bannerid,   logical, type,     comparison, data,   executionorder)
                                VALUES (4,          'or',   'time',   '==',       '1,2',    1)";
        $result = $dbh->query($sql);


        //  add 1st banner to campaign 3
        $bannersTable = $conf['table']['prefix'] . 'banners';
        $sql = "INSERT INTO $bannersTable (bannerid, campaignid, active, contenttype, pluginversion, storagetype, filename, imageurl, htmltemplate, htmlcache, width, height, weight, seq, target, url, alt, status, bannerTEXT, description, autohtml, adserver, block, capping, session_capping, compiledlimitation, append, appendtype, bannertype, alt_filename, alt_imageurl, alt_contenttype)
        VALUES (5,3,'t','gif',0,'sql','468x60_4.gif','','','',468,60,1,0,'','http://www.google.com','Campaign 3 - Banner 1','','','','f','',0, 0,0,'','',0,0,'','','');";
        $result = $dbh->query($sql);

        // add 1st banner - Campaign 2 - acls delivery restrictions
        $aclsTable = $conf['table']['prefix'] . 'acls';
        $sql = "INSERT INTO $aclsTable (bannerid,   logical, type,     comparison, data,                        executionorder)
                                VALUES (5,          'and',   'date',   '!=',       '$expiryDateLessTwoDays',    0)";
        $result = $dbh->query($sql);

        $sql = "INSERT INTO $aclsTable (bannerid,   logical, type,     comparison, data,   executionorder)
                                VALUES (5,          'or',   'weekday',   '==',       '5',    1)";
        $result = $dbh->query($sql);



        // add 2nd banner to campaign 2
        $bannersTable = $conf['table']['prefix'] . 'banners';
        $sql = "INSERT INTO $bannersTable (bannerid, campaignid, active, contenttype, pluginversion, storagetype, filename, imageurl, htmltemplate, htmlcache, width, height, weight, seq, target, url, alt, status, bannerTEXT, description, autohtml, adserver, block, capping, session_capping, compiledlimitation, append, appendtype, bannertype, alt_filename, alt_imageurl, alt_contenttype)
        VALUES (6,3,'t','gif',0,'sql','468x60_4.gif','','','',468,60,1,0,'','http://www.google.com','Campaign 3 - Banner 2','','','','f','',0, 0,0,'','',0,0,'','','');";
        $result = $dbh->query($sql);

        // add banner 2 - Campaign 1 - acls delivery restrictions
        $aclsTable = $conf['table']['prefix'] . 'acls';
        $sql = "INSERT INTO $aclsTable (bannerid,   logical, type,     comparison, data,                        executionorder)
                                VALUES (6,          'or',   'date',   '!=',       '$expiryDateLessTwoDays',    0)";
        $result = $dbh->query($sql);

        $sql = "INSERT INTO $aclsTable (bannerid,   logical, type,     comparison, data,   executionorder)
                                VALUES (6,          'or',   'time',   '!=',       '1,2',    1)";
        $result = $dbh->query($sql);
    }

    /**
     * A method to generate data for testing.
     *
     * @access private
     */
    function _generateStatsTwo()
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $dbh = &MAX_DB::singleton();

        // Populate data_summary_ad_hourly
        $statsTable = $conf['table']['prefix'] . 'data_summary_ad_hourly';
        for ($hour = 0; $hour < 24; $hour ++) {
            $sql = "INSERT INTO $statsTable
                 ( data_summary_ad_hourly_id,
                      day,
                      hour,
                      ad_id,
                      creative_id,
                      zone_id,
                      requests,
                      impressions,
                      clicks,
                      conversions,
                      total_basket_value
                )
                  VALUES(
                '',
                NOW(),
                $hour,
                1, -- banner id
                ".rand(1, 999).",
                ".rand(1, 999).",
                ".rand(1, 999).",
                ".rand(1, 999).",
                ".rand(1, 999).",
                ".rand(1, 999).",
                0
                )";
            $result = $dbh->query($sql);
        }
        // Populate campaigns table
        $campaignsTable = $conf['table']['prefix'] . 'campaigns';
        $sql = "INSERT INTO $campaignsTable
        (campaignid, campaignname,      clientid,   views,  clicks, conversions,    expire,             activate,       active,     priority,   weight, target_impression, anonymous)
        VALUES (4,   'test  campaign',  1,          500,      0,      401,          '0000-00-00',  '0000-00-00',   't',                '4',        2,      0,        'f')";
        $result = $dbh->query($sql);

        // Add a banner
        $bannersTable = $conf['table']['prefix'] . 'banners';
        $sql = "
            INSERT INTO
                $bannersTable
                    (
                        bannerid,
                        campaignid,
                        active,
                        contenttype,
                        pluginversion,
                        storagetype,
                        filename,
                        imageurl,
                        htmltemplate,
                        htmlcache,
                        width,
                        height,
                        weight,
                        seq,
                        target,
                        url,
                        alt,
                        status,
                        bannertext,
                        description,
                        autohtml,
                        adserver,
                        block,
                        capping,
                        session_capping,
                        compiledlimitation,
                        append,
                        appendtype,
                        bannertype,
                        alt_filename,
                        alt_imageurl,
                        alt_contenttype
                    )
                VALUES
                    (
                        1,
                        1,
                        't',
                        'txt',
                        0,
                        'txt',
                        '',
                        '',
                        '',
                        '',
                        0,
                        0,
                        1,
                        0,
                        '',
                        'http://exapmle.com',
                        '',
                        'asdf',
                        'tyerterty',
                        '',
                        'f',
                        '',
                        0,
                        0,
                        0,
                        'phpAds_aclCheckDate(\'20050502\', \'!=\') and phpAds_aclCheckClientIP(\'2.22.22.2\', \'!=\') and phpAds_aclCheckLanguage(\'(sq)|(eu)|(fo)|(fi)\', \'!=\')',
                        '',
                        0,
                        0,
                        '',
                        '',
                        ''
                    )";
        $result = $dbh->query($sql);

        // Add an agency record
        $agencyTable = $conf['table']['prefix'] . 'agency';
        $sql = "INSERT INTO $agencyTable ( `agencyid` , `name` , `contact` , `email` , `username` , `password` , `permissions` , `language` , `logout_url` , `active`) VALUES (1, 'test agency', 'sdfsdfsdf', 'demian@phpkitchen.com', 'Demian Turner', 'passwd', 0, 'en_GB', 'logout.php', 1)";
        $result = $dbh->query($sql);

        // Add a client record (advertiser)
        $clientsTable = $conf['table']['prefix'] . 'clients';
        $sql = "
            INSERT INTO
                $clientsTable
                    (
                        clientid,
                        agencyid,
                        clientname,
                        contact,
                        email,
                        clientusername,
                        clientpassword,
                        permissions,
                        language,
                        report,
                        reportinterval,
                        reportlastdate,
                        reportdeactivate
                    )
                VALUES
                    (
                        1,
                        1,
                        'test client',
                        'yes',
                        'demian@phpkitchen.com',
                        'Demian Turner',
                        '',
                        59,
                        '',
                        't',
                        7,
                        '2005-03-21',
                        't'
                    )";
        $result = $dbh->query($sql);

        // Add an affiliate (publisher) record
        $publisherTable = $conf['table']['prefix'] . 'affiliates';
        $sql = "
            INSERT INTO
                $publisherTable
                    (
                        affiliateid,
                        agencyid,
                        name,
                        mnemonic,
                        contact,
                        email,
                        website,
                        username,
                        password,
                        permissions,
                        language,
                        publiczones
                    )
                VALUES
                    (
                        1,
                        1,
                        'test publisher',
                        'ABC',
                        'foo bar',
                        'foo@example.com',
                        'www.example.com',
                        'foo',
                        'bar',
                        NULL,
                        NULL,
                        'f'
                    )";
        $result = $dbh->query($sql);

        // Add zone record
        $zonesTable = $conf['table']['prefix'] . 'zones';
        $sql = "
            INSERT INTO
                $zonesTable
                    (
                        zoneid,
                        affiliateid,
                        zonename,
                        description,
                        delivery,
                        zonetype,
                        category,
                        width,
                        height,
                        ad_selection,
                        chain,
                        prepend,
                        append,
                        appendtype,
                        forceappend
                    )
                VALUES
                    (
                        1,
                        1,
                        'Demian Turner - Default',
                        '',
                        0,
                        3,
                        '',
                        728,
                        90,
                        '',
                        '',
                        '',
                        '',
                        0,
                        'f'
                    )";
        $result = $dbh->query($sql);

        // Add ad_zone_assoc record
        $zonesAssocTable = $conf['table']['prefix'] . 'ad_zone_assoc';
        $sql = "INSERT INTO $zonesAssocTable VALUES (1, 1, 1, '0', 1)";
        $result = $dbh->query($sql);
    }

}

?>
