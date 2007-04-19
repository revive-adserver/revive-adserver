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
require_once MAX_PATH . '/lib/max/Entity/Ad.php';
require_once MAX_PATH . '/lib/max/Maintenance/Priority/Entities.php';

require_once MAX_PATH . '/lib/OA/DB/Table/Priority.php';
require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/lib/OA/Dal/Maintenance/Priority.php';
require_once 'Date.php';
require_once 'DB/QueryTool.php';

/**
 * A class for testing the non-DB specific OA_Dal_Maintenance_Priority class.
 *
 * @package    OpenadsDal
 * @subpackage TestSuite
 * @author     James Floyd <james@m3.net>
 * @author     Andrew Hill <andrew.hill@openads.org>
 * @author     Demian Turner <demian@m3.net>
 */
class Test_OA_Dal_Maintenance_Priority extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function Test_OA_Dal_Maintenance_Priority()
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

        $conf = $GLOBALS['_MAX']['CONF'];
        $oDbh = &OA_DB::singleton();
        $oMaxDalMaintenance = new OA_Dal_Maintenance_Priority();

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
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['start_run'], '2005-06-21 15:00:01');
        $this->assertEqual($aRow['end_run'], '2005-06-21 15:01:01');
        $this->assertEqual($aRow['operation_interval'], $conf['maintenance']['operationInterval']);
        $this->assertEqual($aRow['duration'], 60);
        $this->assertEqual($aRow['run_type'], DAL_PRIORITY_UPDATE_ZIF);
        $this->assertEqual($aRow['updated_to'], '2005-06-21 15:59:59');

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
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['start_run'], '2005-06-21 15:00:01');
        $this->assertEqual($aRow['end_run'], '2005-06-21 15:01:01');
        $this->assertEqual($aRow['operation_interval'], $conf['maintenance']['operationInterval']);
        $this->assertEqual($aRow['duration'], 60);
        $this->assertEqual($aRow['run_type'], DAL_PRIORITY_UPDATE_ZIF);
        $this->assertEqual($aRow['updated_to'], '2005-06-21 15:59:59');
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
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['start_run'], '2005-06-21 16:00:01');
        $this->assertEqual($aRow['end_run'], '2005-06-21 16:01:06');
        $this->assertEqual($aRow['operation_interval'], $conf['maintenance']['operationInterval']);
        $this->assertEqual($aRow['duration'], 65);
        $this->assertEqual($aRow['run_type'], DAL_PRIORITY_UPDATE_PRIORITY_COMPENSATION);
        $this->assertEqual($aRow['updated_to'], '2005-06-21 16:59:59');

        TestEnv::restoreEnv();
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
        $conf = $GLOBALS['_MAX']['CONF'];
        $oDbh = &OA_DB::singleton();
        $oMaxDalMaintenance = new OA_Dal_Maintenance_Priority();

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

        TestEnv::restoreEnv();
    }

    /**
     * A method to test the getPlacements method.
     */
    function testGetPlacements()
    {
        $da = new OA_Dal_Maintenance_Priority();
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
        TestEnv::restoreEnv();
    }

    /**
     * A method to test the getPlacementData method.
     */
    function testGetPlacementData()
    {
        $da = new OA_Dal_Maintenance_Priority();
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
        TestEnv::restoreEnv();
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
        $conf = $GLOBALS['_MAX']['CONF'];
        $oDbh = &OA_DB::singleton();
        $oMaxDalMaintenance = new OA_Dal_Maintenance_Priority();

        $oNow = new Date();

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
                    conversions,
                    updated
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
                    300,
                    '" . $oNow->format('%Y-%m-%d %H:%M:%S') . "'
                )";
        $rows = $oDbh->exec($query);
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['banners']}
                (
                    campaignid,
                    bannerid,
                    htmltemplate,
                    htmlcache,
                    url,
                    bannertext,
                    compiledlimitation,
                    append,
                    updated,
                    acls_updated
                )
            VALUES
                (
                    1,
                    1,
                    '',
                    '',
                    '',
                    '',
                    '',
                    '',
                    '" . $oNow->format('%Y-%m-%d %H:%M:%S') . "',
                    '" . $oNow->format('%Y-%m-%d %H:%M:%S') . "'
                )";
        $rows = $oDbh->exec($query);
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad']}
                (
                    operation_interval,
                    operation_interval_id,
                    interval_start,
                    interval_end,
                    day,
                    hour,
                    ad_id,
                    creative_id,
                    zone_id,
                    requests,
                    impressions,
                    clicks,
                    conversions,
                    updated
                )
            VALUES
                (
                    60,
                    0,
                    '2005-06-24 10:00:00',
                    '2005-06-24 10:59:59',
                    '2005-06-24',
                    10,
                    1,
                    0,
                    1,
                    500,
                    475,
                    25,
                    5,
                    '" . $oNow->format('%Y-%m-%d %H:%M:%S') . "'
                )";
        $rows = $oDbh->exec($query);
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad']}
                (
                    operation_interval,
                    operation_interval_id,
                    interval_start,
                    interval_end,
                    day,
                    hour,
                    ad_id,
                    creative_id,
                    zone_id,
                    requests,
                    impressions,
                    clicks,
                    conversions,
                    updated
                )
            VALUES
                (
                    60,
                    0,
                    '2005-06-24 11:00:00',
                    '2005-06-24 11:59:59',
                    '2005-06-24',
                    11,
                    1,
                    0,
                    1,
                    500,
                    475,
                    25,
                    5,
                    '" . $oNow->format('%Y-%m-%d %H:%M:%S') . "'
                )";
        $rows = $oDbh->exec($query);
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

        TestEnv::restoreEnv();
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
        $da = new OA_Dal_Maintenance_Priority();
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
        TestEnv::restoreEnv();
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
        $oDbh = &OA_DB::singleton();
        $oMaxDalMaintenance = new OA_Dal_Maintenance_Priority();

        // Create the required temporary table for the tests
        $oTable = &OA_DB_Table_Priority::singleton();
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
                )";
        $rows = $oDbh->exec($query);
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
                    2,
                    4,
                    5
                )";
        $rows = $oDbh->exec($query);
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
                    2,
                    2,
                    6,
                    7
                )";
        $rows = $oDbh->exec($query);
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
        $oDbh = &OA_DB::singleton();
        $oMaxDalMaintenance = new OA_Dal_Maintenance_Priority();

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
        $rows = $oDbh->exec($query);
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
        $rows = $oDbh->exec($query);
        $result = &$oMaxDalMaintenance->getAllZonesImpInv();
        $this->assertEqual(count($result), 0);


        $oDate = &$oServiceLocator->get('now');
        TestEnv::restoreEnv();
        $oServiceLocator->register('now', $oDate);

        // Test 4
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
                )";
        $rows = $oDbh->exec($query);
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
                    2,
                    1,
                    2
                )";
        $rows = $oDbh->exec($query);
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
                )";
        $rows = $oDbh->exec($query);
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
                    2,
                    3,
                    4
                )";
        $rows = $oDbh->exec($query);
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
                    3,
                    5,
                    6
                )";
        $rows = $oDbh->exec($query);
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
        $rows = $oDbh->exec($query);
        $result = &$oMaxDalMaintenance->getAllZonesImpInv();
        $this->assertEqual(count($result), 2);
        $this->assertEqual($result[1]['zone_id'], 1);
        $this->assertEqual($result[1]['forecast_impressions'], 42);
        $this->assertEqual($result[1]['actual_impressions'], 11);
        $this->assertEqual($result[2]['zone_id'], 2);
        $this->assertEqual($result[2]['forecast_impressions'], 1);
        $this->assertEqual($result[2]['actual_impressions'], 4);

        $oDate = &$oServiceLocator->get('now');
        TestEnv::restoreEnv();
        $oServiceLocator->register('now', $oDate);

        // Test 5
        $oDate = &$oServiceLocator->get('now');
        $currentOpIntID = MAX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $aDates = MAX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oDate);
        $oNow = new Date();
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['zones']}
                (
                    zoneid,
                    category,
                    ad_selection,
                    chain,
                    prepend,
                    append,
                    updated
                )
            VALUES
                (?, ?, ?, ?, ?, ?, ?)";
        $aTypes = array(
            'integer',
            'text',
            'text',
            'text',
            'text',
            'text',
            'timestamp'
        );
        $st = $oDbh->prepare($query, $aTypes, MDB2_PREPARE_MANIP);
        $aData = array(
            1,
            '',
            '',
            '',
            '',
            '',
            $oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $rows = $st->execute($aData);
        $aData = array(
            2,
            '',
            '',
            '',
            '',
            '',
            $oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $rows = $st->execute($aData);
        $aData = array(
            3,
            '',
            '',
            '',
            '',
            '',
            $oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $rows = $st->execute($aData);
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
                )";
        $rows = $oDbh->exec($query);
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
                    2,
                    1,
                    2
                )";
        $rows = $oDbh->exec($query);
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
                )";
        $rows = $oDbh->exec($query);
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
                    2,
                    3,
                    4
                )";
        $rows = $oDbh->exec($query);
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
                    3,
                    5,
                    6
                )";
        $rows = $oDbh->exec($query);
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
        $rows = $oDbh->exec($query);
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
        TestEnv::restoreEnv();
    }

    /**
     * Method to test the getAllDeliveryLimitationChangedAds method.
     *
     * Requirements:
     * Test 0: Test with bad input data, and ensure the method survives.
     * Test 1: Test with no data, and ensure no data are returned.
     * Test 2: Test with an active ad that has not had any delivery limitation changes,
     *         and ensure that no data are returned: DEPRECATED TEST, PostgreSQL DOES
     *         NOT PERMIT THE acls_update FIELD TO HAVE A NULL ENTRY.
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
        $oDbh = &OA_DB::singleton();
        $oMaxDalMaintenance = new OA_Dal_Maintenance_Priority();

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

        // Test 3
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['campaigns']}
                (
                    campaignid,
                    active,
                    updated
                )
            VALUES
                (?, ?, ?)";
        $aTypes = array(
            'integer',
            'text',
            'timestamp'
        );
        $stPl = $oDbh->prepare($query, $aTypes, MDB2_PREPARE_MANIP);
        $aData = array(
            1,
            't',
            $oDateNow->format('%Y-%m-%d %H:%M:%S')
        );
        $rows = $stPl->execute($aData);
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['banners']}
                (
                    bannerid,
                    campaignid,
                    active,
                    acls_updated,
                    htmltemplate,
                    htmlcache,
                    url,
                    bannertext,
                    compiledlimitation,
                    append,
                    updated
                )
            VALUES
                (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $aTypes = array(
            'integer',
            'integer',
            'text',
            'timestamp',
            'text',
            'text',
            'text',
            'text',
            'text',
            'text',
            'timestamp'
        );
        $stAd = $oDbh->prepare($query, $aTypes, MDB2_PREPARE_MANIP);
        $aData = array(
            1,
            1,
            't',
            '2006-10-04 11:10:00',
            '',
            '',
            '',
            '',
            '',
            '',
            $oDateNow->format('%Y-%m-%d %H:%M:%S')
        );
        $rows = $stAd->execute($aData);
        $aResult = &$oMaxDalMaintenance->getAllDeliveryLimitationChangedAds($aLastRun);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 0);
        TestEnv::restoreEnv();

        // Test 4
        $aData = array(
            1,
            't',
            $oDateNow->format('%Y-%m-%d %H:%M:%S')
        );
        $rows = $stPl->execute($aData);
        $aData = array(
            1,
            1,
            't',
            '2006-10-04 11:15:00',
            '',
            '',
            '',
            '',
            '',
            '',
            $oDateNow->format('%Y-%m-%d %H:%M:%S')
        );
        $rows = $stAd->execute($aData);
        $aResult = &$oMaxDalMaintenance->getAllDeliveryLimitationChangedAds($aLastRun);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 1);
        $this->assertEqual($aResult[1], '2006-10-04 11:15:00');
        TestEnv::restoreEnv();

        // Test 5
        $aData = array(
            1,
            't',
            $oDateNow->format('%Y-%m-%d %H:%M:%S')
        );
        $rows = $stPl->execute($aData);
        $aData = array(
            1,
            1,
            't',
            '2006-10-04 12:15:00',
            '',
            '',
            '',
            '',
            '',
            '',
            $oDateNow->format('%Y-%m-%d %H:%M:%S')
        );
        $rows = $stAd->execute($aData);
        $aResult = &$oMaxDalMaintenance->getAllDeliveryLimitationChangedAds($aLastRun);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 1);
        $this->assertEqual($aResult[1], '2006-10-04 12:15:00');
        TestEnv::restoreEnv();

        // Test 6
        $aData = array(
            1,
            'f',
            $oDateNow->format('%Y-%m-%d %H:%M:%S')
        );
        $rows = $stPl->execute($aData);
        $aData = array(
            1,
            1,
            't',
            '2006-10-04 11:10:00',
            '',
            '',
            '',
            '',
            '',
            '',
            $oDateNow->format('%Y-%m-%d %H:%M:%S')
        );
        $rows = $stAd->execute($aData);
        $aResult = &$oMaxDalMaintenance->getAllDeliveryLimitationChangedAds($aLastRun);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 0);
        TestEnv::restoreEnv();

        // Test 7
        $aData = array(
            1,
            'f',
            $oDateNow->format('%Y-%m-%d %H:%M:%S')
        );
        $rows = $stPl->execute($aData);
        $aData = array(
            1,
            1,
            't',
            '2006-10-04 11:15:00',
            '',
            '',
            '',
            '',
            '',
            '',
            $oDateNow->format('%Y-%m-%d %H:%M:%S')
        );
        $rows = $stAd->execute($aData);
        $aResult = &$oMaxDalMaintenance->getAllDeliveryLimitationChangedAds($aLastRun);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 0);
        TestEnv::restoreEnv();

        // Test 8
        $aData = array(
            1,
            'f',
            $oDateNow->format('%Y-%m-%d %H:%M:%S')
        );
        $rows = $stPl->execute($aData);
        $aData = array(
            1,
            1,
            'f',
            '2006-10-04 12:15:00',
            '',
            '',
            '',
            '',
            '',
            '',
            $oDateNow->format('%Y-%m-%d %H:%M:%S')
        );
        $rows = $stAd->execute($aData);
        $aResult = &$oMaxDalMaintenance->getAllDeliveryLimitationChangedAds($aLastRun);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 0);
        TestEnv::restoreEnv();

        // Test 9
        $aData = array(
            1,
            't',
            $oDateNow->format('%Y-%m-%d %H:%M:%S')
        );
        $rows = $stPl->execute($aData);
        $aData = array(
            2,
            't',
            $oDateNow->format('%Y-%m-%d %H:%M:%S')
        );
        $rows = $stPl->execute($aData);
        $aData = array(
            3,
            'f',
            $oDateNow->format('%Y-%m-%d %H:%M:%S')
        );
        $rows = $stPl->execute($aData);
        $aData = array(
            1,
            1,
            't',
            '2006-10-04 11:30:00',
            '',
            '',
            '',
            '',
            '',
            '',
            $oDateNow->format('%Y-%m-%d %H:%M:%S')
        );
        $rows = $stAd->execute($aData);
        $aData = array(
            2,
            1,
            't',
            '2006-10-04 10:15:00',
            '',
            '',
            '',
            '',
            '',
            '',
            $oDateNow->format('%Y-%m-%d %H:%M:%S')
        );
        $rows = $stAd->execute($aData);
        $aData = array(
            3,
            2,
            'f',
            '2006-10-04 12:06:00',
            '',
            '',
            '',
            '',
            '',
            '',
            $oDateNow->format('%Y-%m-%d %H:%M:%S')
        );
        $rows = $stAd->execute($aData);
        $aData = array(
            4,
            2,
            't',
            '2006-10-04 12:15:00',
            '',
            '',
            '',
            '',
            '',
            '',
            $oDateNow->format('%Y-%m-%d %H:%M:%S')
        );
        $rows = $stAd->execute($aData);
        $aData = array(
            5,
            3,
            't',
            '2006-10-04 12:05:00',
            '',
            '',
            '',
            '',
            '',
            '',
            $oDateNow->format('%Y-%m-%d %H:%M:%S')
        );
        $rows = $stAd->execute($aData);
        $aData = array(
            6,
            3,
            't',
            '2006-10-04 12:01:00',
            '',
            '',
            '',
            '',
            '',
            '',
            $oDateNow->format('%Y-%m-%d %H:%M:%S')
        );
        $rows = $stAd->execute($aData);
        $aResult = &$oMaxDalMaintenance->getAllDeliveryLimitationChangedAds($aLastRun);
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 2);
        $this->assertEqual($aResult[1], '2006-10-04 11:30:00');
        $this->assertEqual($aResult[4], '2006-10-04 12:15:00');
        TestEnv::restoreEnv();
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
        $oDbh = &OA_DB::singleton();
        $oMaxDalMaintenance = new OA_Dal_Maintenance_Priority();

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
        $operationIntervalID = MAX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $aDates = MAX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oDate);
        $oNow = new Date();
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['data_intermediate_ad']}
                (
                    operation_interval,
                    operation_interval_id,
                    interval_start,
                    interval_end,
                    day,
                    hour,
                    ad_id,
                    creative_id,
                    zone_id,
                    impressions,
                    updated
                )
            VALUES
                (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $aTypes = array(
            'integer',
            'integer',
            'timestamp',
            'timestamp',
            'date',
            'integer',
            'integer',
            'integer',
            'integer',
            'integer',
            'timestamp'
        );
        $stDia = $oDbh->prepare($query, $aTypes, MDB2_PREPARE_MANIP);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $operationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['start']->format('%Y-%m-%d'),
            $aDates['start']->format('%H'),
            1,
            0,
            1,
            1,
            $oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $rows = $stDia->execute($aData);
        $result = &$oMaxDalMaintenance->getPreviousAdDeliveryInfo($aEmptyZoneAdArray);
        $this->assertEqual(count($result), 0);

        $oDate = &$oServiceLocator->get('now');
        TestEnv::restoreEnv();
        $oServiceLocator->register('now', $oDate);

        // Test 4
        $operationIntervalID = MAX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $previousOperationIntervalID = MAX_OperationInterval::previousOperationIntervalID($operationIntervalID);
        $aDates = MAX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($oDate);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $previousOperationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['start']->format('%Y-%m-%d'),
            $aDates['start']->format('%H'),
            1,
            0,
            1,
            1,
            $oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $rows = $stDia->execute($aData);
        $result = &$oMaxDalMaintenance->getPreviousAdDeliveryInfo($aEmptyZoneAdArray);
        $this->assertEqual(count($result), 1);
        $this->assertEqual($result[1][1]['ad_id'], 1);
        $this->assertEqual($result[1][1]['zone_id'], 1);
        $this->assertNull($result[1][1]['required_impressions']);
        $this->assertNull($result[1][1]['requested_impressions']);
        $this->assertNull($result[1][1]['priority_factor']);
        $this->assertNull($result[1][1]['past_zone_traffic_fraction']);
        $this->assertEqual($result[1][1]['impressions'], 1);

        $oDate = &$oServiceLocator->get('now');
        TestEnv::restoreEnv();
        $oServiceLocator->register('now', $oDate);

        // Test 5, 5a
        $operationIntervalID = MAX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $previousOperationIntervalID = MAX_OperationInterval::previousOperationIntervalID($operationIntervalID);
        $previousOperationIntervalID = MAX_OperationInterval::previousOperationIntervalID($previousOperationIntervalID);
        $aDates = MAX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($oDate);
        $aDates = MAX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($aDates['start']);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $previousOperationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['start']->format('%Y-%m-%d'),
            $aDates['start']->format('%H'),
            1,
            0,
            1,
            1,
            $oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $rows = $stDia->execute($aData);
        $result = &$oMaxDalMaintenance->getPreviousAdDeliveryInfo($aEmptyZoneAdArray);
        $this->assertEqual(count($result), 0);
        $result = &$oMaxDalMaintenance->getPreviousAdDeliveryInfo($aZoneAdArray);
        $this->assertEqual(count($result), 0);

        $oDate = &$oServiceLocator->get('now');
        TestEnv::restoreEnv();
        $oServiceLocator->register('now', $oDate);

        // Test 6
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
                    priority,
                    priority_factor,
                    past_zone_traffic_fraction,
                    created,
                    created_by
                )
            VALUES
                (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $aTypes = array(
            'integer',
            'integer',
            'timestamp',
            'timestamp',
            'integer',
            'integer',
            'integer',
            'integer',
            'float',
            'float',
            'float',
            'timestamp',
            'integer'
        );
        $stDsaza = $oDbh->prepare($query, $aTypes, MDB2_PREPARE_MANIP);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $operationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            1,
            1,
            1,
            1,
            0.1,
            0.5,
            0.99,
            $oNow->format('%Y-%m-%d %H:%M:%S'),
            0
        );
        $rows = $stDsaza->execute($aData);
        $result = &$oMaxDalMaintenance->getPreviousAdDeliveryInfo($aEmptyZoneAdArray);
        $this->assertEqual(count($result), 0);

        $oDate = &$oServiceLocator->get('now');
        TestEnv::restoreEnv();
        $oServiceLocator->register('now', $oDate);

        // Test 7
        $operationIntervalID = MAX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $previousOperationIntervalID = MAX_OperationInterval::previousOperationIntervalID($operationIntervalID);
        $aDates = MAX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($oDate);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $previousOperationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            1,
            1,
            1,
            1,
            0,
            0.5,
            0.99,
            $oNow->format('%Y-%m-%d %H:%M:%S'),
            0
        );
        $rows = $stDsaza->execute($aData);
        $result = &$oMaxDalMaintenance->getPreviousAdDeliveryInfo($aEmptyZoneAdArray);
        $this->assertEqual(count($result), 1);
        $this->assertEqual($result[1][1]['ad_id'], 1);
        $this->assertEqual($result[1][1]['zone_id'], 1);
        $this->assertEqual($result[1][1]['required_impressions'], 1);
        $this->assertEqual($result[1][1]['requested_impressions'], 1);
        $this->assertEqual($result[1][1]['priority_factor'], 0.5);
        $this->assertEqual($result[1][1]['past_zone_traffic_fraction'], 0.99);
        $this->assertNull($result[1][1]['impressions']);

        $oDate = &$oServiceLocator->get('now');
        TestEnv::restoreEnv();
        $oServiceLocator->register('now', $oDate);

        // Test 8, 8a
        $operationIntervalID = MAX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $previousOperationIntervalID = MAX_OperationInterval::previousOperationIntervalID($operationIntervalID);
        $previousOperationIntervalID = MAX_OperationInterval::previousOperationIntervalID($previousOperationIntervalID);
        $aDates = MAX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($oDate);
        $aDates = MAX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($aDates['start']);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $previousOperationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            1,
            1,
            1,
            1,
            0,
            0.5,
            0.99,
            $oNow->format('%Y-%m-%d %H:%M:%S'),
            0
        );
        $rows = $stDsaza->execute($aData);
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

        $oDate = &$oServiceLocator->get('now');
        TestEnv::restoreEnv();
        $oServiceLocator->register('now', $oDate);

        // Test 9
        $operationIntervalID = MAX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $aDates = MAX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oDate);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $operationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['start']->format('%Y-%m-%d'),
            $aDates['start']->format('%H'),
            1,
            0,
            1,
            1,
            $oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $rows = $stDia->execute($aData);
        $operationIntervalID = MAX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $aDates = MAX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oDate);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $operationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            1,
            1,
            1,
            1,
            0,
            0.5,
            0.99,
            $oNow->format('%Y-%m-%d %H:%M:%S'),
            0
        );
        $rows = $stDsaza->execute($aData);
        $result = &$oMaxDalMaintenance->getPreviousAdDeliveryInfo($aEmptyZoneAdArray);
        $this->assertEqual(count($result), 0);

        $oDate = &$oServiceLocator->get('now');
        TestEnv::restoreEnv();
        $oServiceLocator->register('now', $oDate);

        // Test 10
        $operationIntervalID = MAX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $aDates = MAX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oDate);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $operationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['start']->format('%Y-%m-%d'),
            $aDates['start']->format('%H'),
            1,
            0,
            1,
            1,
            $oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $rows = $stDia->execute($aData);
        $operationIntervalID = MAX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $previousOperationIntervalID = MAX_OperationInterval::previousOperationIntervalID($operationIntervalID);
        $aDates = MAX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($oDate);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $previousOperationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            1,
            1,
            1,
            1,
            0,
            0.5,
            0.99,
            $oNow->format('%Y-%m-%d %H:%M:%S'),
            0
        );
        $rows = $stDsaza->execute($aData);
        $result = &$oMaxDalMaintenance->getPreviousAdDeliveryInfo($aEmptyZoneAdArray);
        $this->assertEqual(count($result), 1);
        $this->assertEqual($result[1][1]['ad_id'], 1);
        $this->assertEqual($result[1][1]['zone_id'], 1);
        $this->assertEqual($result[1][1]['required_impressions'], 1);
        $this->assertEqual($result[1][1]['requested_impressions'], 1);
        $this->assertEqual($result[1][1]['priority_factor'], 0.5);
        $this->assertEqual($result[1][1]['past_zone_traffic_fraction'], 0.99);
        $this->assertNull($result[1][1]['impressions']);

        $oDate = &$oServiceLocator->get('now');
        TestEnv::restoreEnv();
        $oServiceLocator->register('now', $oDate);

        // Test 11, 11a
        $operationIntervalID = MAX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $aDates = MAX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oDate);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $operationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['start']->format('%Y-%m-%d'),
            $aDates['start']->format('%H'),
            1,
            0,
            1,
            1,
            $oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $rows = $stDia->execute($aData);
        $operationIntervalID = MAX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $previousOperationIntervalID = MAX_OperationInterval::previousOperationIntervalID($operationIntervalID);
        $previousOperationIntervalID = MAX_OperationInterval::previousOperationIntervalID($previousOperationIntervalID);
        $aDates = MAX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($oDate);
        $aDates = MAX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($aDates['start']);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $previousOperationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            1,
            1,
            1,
            1,
            0,
            0.5,
            0.99,
            $oNow->format('%Y-%m-%d %H:%M:%S'),
            0
        );
        $rows = $stDsaza->execute($aData);
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

        $oDate = &$oServiceLocator->get('now');
        TestEnv::restoreEnv();
        $oServiceLocator->register('now', $oDate);

        // Test 12
        $operationIntervalID = MAX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $previousOperationIntervalID = MAX_OperationInterval::previousOperationIntervalID($operationIntervalID);
        $previousOperationIntervalID = MAX_OperationInterval::previousOperationIntervalID($previousOperationIntervalID);
        $aDates = MAX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($oDate);
        $aDates = MAX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($aDates['start']);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $previousOperationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['start']->format('%Y-%m-%d'),
            $aDates['start']->format('%H'),
            1,
            0,
            1,
            1,
            $oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $rows = $stDia->execute($aData);
        $operationIntervalID = MAX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $aDates = MAX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oDate);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $operationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            1,
            1,
            1,
            1,
            0,
            0.5,
            0.99,
            $oNow->format('%Y-%m-%d %H:%M:%S'),
            0
        );
        $rows = $stDsaza->execute($aData);
        $result = &$oMaxDalMaintenance->getPreviousAdDeliveryInfo($aEmptyZoneAdArray);
        $this->assertEqual(count($result), 0);

        $oDate = &$oServiceLocator->get('now');
        TestEnv::restoreEnv();
        $oServiceLocator->register('now', $oDate);

        // Test 13
        $operationIntervalID = MAX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $previousOperationIntervalID = MAX_OperationInterval::previousOperationIntervalID($operationIntervalID);
        $previousOperationIntervalID = MAX_OperationInterval::previousOperationIntervalID($previousOperationIntervalID);
        $aDates = MAX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($oDate);
        $aDates = MAX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($aDates['start']);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $previousOperationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['start']->format('%Y-%m-%d'),
            $aDates['start']->format('%H'),
            1,
            0,
            1,
            1,
            $oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $rows = $stDia->execute($aData);
        $operationIntervalID = MAX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $previousOperationIntervalID = MAX_OperationInterval::previousOperationIntervalID($operationIntervalID);
        $aDates = MAX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($oDate);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $previousOperationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            1,
            1,
            1,
            1,
            0,
            0.5,
            0.99,
            $oNow->format('%Y-%m-%d %H:%M:%S'),
            0
        );
        $rows = $stDsaza->execute($aData);
        $result = &$oMaxDalMaintenance->getPreviousAdDeliveryInfo($aEmptyZoneAdArray);
        $this->assertEqual(count($result), 1);
        $this->assertEqual($result[1][1]['ad_id'], 1);
        $this->assertEqual($result[1][1]['zone_id'], 1);
        $this->assertEqual($result[1][1]['required_impressions'], 1);
        $this->assertEqual($result[1][1]['requested_impressions'], 1);
        $this->assertEqual($result[1][1]['priority_factor'], 0.5);
        $this->assertEqual($result[1][1]['past_zone_traffic_fraction'], 0.99);
        $this->assertNull($result[1][1]['impressions']);

        $oDate = &$oServiceLocator->get('now');
        TestEnv::restoreEnv();
        $oServiceLocator->register('now', $oDate);

        // Test 14, 14a
        $operationIntervalID = MAX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $previousOperationIntervalID = MAX_OperationInterval::previousOperationIntervalID($operationIntervalID);
        $previousOperationIntervalID = MAX_OperationInterval::previousOperationIntervalID($previousOperationIntervalID);
        $aDates = MAX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($oDate);
        $aDates = MAX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($aDates['start']);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $previousOperationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['start']->format('%Y-%m-%d'),
            $aDates['start']->format('%H'),
            1,
            0,
            1,
            1,
            $oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $rows = $stDia->execute($aData);
        $operationIntervalID = MAX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $previousOperationIntervalID = MAX_OperationInterval::previousOperationIntervalID($operationIntervalID);
        $previousOperationIntervalID = MAX_OperationInterval::previousOperationIntervalID($previousOperationIntervalID);
        $aDates = MAX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($oDate);
        $aDates = MAX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($aDates['start']);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $previousOperationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            1,
            1,
            1,
            1,
            0,
            0.5,
            0.99,
            $oNow->format('%Y-%m-%d %H:%M:%S'),
            0
        );
        $rows = $stDsaza->execute($aData);
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

        $oDate = &$oServiceLocator->get('now');
        TestEnv::restoreEnv();
        $oServiceLocator->register('now', $oDate);

        // Test 15
        $operationIntervalID = MAX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $previousOperationIntervalID = MAX_OperationInterval::previousOperationIntervalID($operationIntervalID);
        $aDates = MAX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($oDate);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $previousOperationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['start']->format('%Y-%m-%d'),
            $aDates['start']->format('%H'),
            1,
            0,
            1,
            1,
            $oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $rows = $stDia->execute($aData);
        $operationIntervalID = MAX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $aDates = MAX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oDate);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $operationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            1,
            1,
            1,
            1,
            0,
            0.5,
            0.99,
            $oNow->format('%Y-%m-%d %H:%M:%S'),
            0
        );
        $rows = $stDsaza->execute($aData);
        $result = &$oMaxDalMaintenance->getPreviousAdDeliveryInfo($aEmptyZoneAdArray);
        $this->assertEqual(count($result), 1);
        $this->assertEqual($result[1][1]['ad_id'], 1);
        $this->assertEqual($result[1][1]['zone_id'], 1);
        $this->assertNull($result[1][1]['required_impressions']);
        $this->assertNull($result[1][1]['requested_impressions']);
        $this->assertNull($result[1][1]['priority_factor']);
        $this->assertNull($result[1][1]['past_zone_traffic_fraction']);
        $this->assertEqual($result[1][1]['impressions'], 1);

        $oDate = &$oServiceLocator->get('now');
        TestEnv::restoreEnv();
        $oServiceLocator->register('now', $oDate);

        // Test 16
        $operationIntervalID = MAX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $previousOperationIntervalID = MAX_OperationInterval::previousOperationIntervalID($operationIntervalID);
        $aDates = MAX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($oDate);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $previousOperationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['start']->format('%Y-%m-%d'),
            $aDates['start']->format('%H'),
            1,
            0,
            1,
            1,
            $oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $rows = $stDia->execute($aData);
        $operationIntervalID = MAX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $previousOperationIntervalID = MAX_OperationInterval::previousOperationIntervalID($operationIntervalID);
        $aDates = MAX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($oDate);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $previousOperationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            1,
            1,
            1,
            1,
            0,
            0.5,
            0.99,
            $oNow->format('%Y-%m-%d %H:%M:%S'),
            0
        );
        $rows = $stDsaza->execute($aData);
        $result = &$oMaxDalMaintenance->getPreviousAdDeliveryInfo($aEmptyZoneAdArray);
        $this->assertEqual(count($result), 1);
        $this->assertEqual($result[1][1]['ad_id'], 1);
        $this->assertEqual($result[1][1]['zone_id'], 1);
        $this->assertEqual($result[1][1]['required_impressions'], 1);
        $this->assertEqual($result[1][1]['requested_impressions'], 1);
        $this->assertEqual($result[1][1]['priority_factor'], 0.5);
        $this->assertEqual($result[1][1]['past_zone_traffic_fraction'], 0.99);
        $this->assertEqual($result[1][1]['impressions'], 1);

        $oDate = &$oServiceLocator->get('now');
        TestEnv::restoreEnv();
        $oServiceLocator->register('now', $oDate);

        // Test 17, 17a
        $operationIntervalID = MAX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $previousOperationIntervalID = MAX_OperationInterval::previousOperationIntervalID($operationIntervalID);
        $aDates = MAX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($oDate);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $previousOperationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['start']->format('%Y-%m-%d'),
            $aDates['start']->format('%H'),
            1,
            0,
            1,
            1,
            $oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $rows = $stDia->execute($aData);
        $operationIntervalID = MAX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $previousOperationIntervalID = MAX_OperationInterval::previousOperationIntervalID($operationIntervalID);
        $previousOperationIntervalID = MAX_OperationInterval::previousOperationIntervalID($previousOperationIntervalID);
        $aDates = MAX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($oDate);
        $aDates = MAX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($aDates['start']);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $previousOperationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            1,
            1,
            1,
            1,
            0,
            0.5,
            0.99,
            $oNow->format('%Y-%m-%d %H:%M:%S'),
            0
        );
        $rows = $stDsaza->execute($aData);
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

        $oDate = &$oServiceLocator->get('now');
        TestEnv::restoreEnv();
        $oServiceLocator->register('now', $oDate);

        // Test 18
        $operationIntervalID = MAX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $previousOperationIntervalID = MAX_OperationInterval::previousOperationIntervalID($operationIntervalID);
        $aDates = MAX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($oDate);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $previousOperationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['start']->format('%Y-%m-%d'),
            $aDates['start']->format('%H'),
            1,
            0,
            1,
            1,
            $oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $rows = $stDia->execute($aData);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $previousOperationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['start']->format('%Y-%m-%d'),
            $aDates['start']->format('%H'),
            1,
            0,
            2,
            1,
            $oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $rows = $stDia->execute($aData);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $previousOperationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['start']->format('%Y-%m-%d'),
            $aDates['start']->format('%H'),
            2,
            0,
            3,
            2,
            $oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $rows = $stDia->execute($aData);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $previousOperationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['start']->format('%Y-%m-%d'),
            $aDates['start']->format('%H'),
            2,
            0,
            4,
            2,
            $oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $rows = $stDia->execute($aData);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $previousOperationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['start']->format('%Y-%m-%d'),
            $aDates['start']->format('%H'),
            3,
            0,
            5,
            5,
            $oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $rows = $stDia->execute($aData);
        $operationIntervalID = MAX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $previousOperationIntervalID = MAX_OperationInterval::previousOperationIntervalID($operationIntervalID);
        $previousOperationIntervalID = MAX_OperationInterval::previousOperationIntervalID($previousOperationIntervalID);
        $aDates = MAX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($oDate);
        $aDates = MAX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($aDates['start']);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $previousOperationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['start']->format('%Y-%m-%d'),
            $aDates['start']->format('%H'),
            1,
            0,
            1,
            100,
            $oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $rows = $stDia->execute($aData);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $previousOperationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['start']->format('%Y-%m-%d'),
            $aDates['start']->format('%H'),
            1,
            0,
            2,
            100,
            $oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $rows = $stDia->execute($aData);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $previousOperationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['start']->format('%Y-%m-%d'),
            $aDates['start']->format('%H'),
            2,
            0,
            3,
            200,
            $oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $rows = $stDia->execute($aData);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $previousOperationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['start']->format('%Y-%m-%d'),
            $aDates['start']->format('%H'),
            2,
            0,
            4,
            200,
            $oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $rows = $stDia->execute($aData);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $previousOperationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['start']->format('%Y-%m-%d'),
            $aDates['start']->format('%H'),
            3,
            0,
            5,
            500,
            $oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $rows = $stDia->execute($aData);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $previousOperationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['start']->format('%Y-%m-%d'),
            $aDates['start']->format('%H'),
            4,
            0,
            5,
            500,
            $oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $rows = $stDia->execute($aData);
        $operationIntervalID = MAX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $previousOperationIntervalID = MAX_OperationInterval::previousOperationIntervalID($operationIntervalID);
        $aDates = MAX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($oDate);
        $oSpecialDate = new Date($aDates['end']);
        $oSpecialDate->addSeconds(1);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $previousOperationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            1,
            2,
            10,
            10,
            0,
            0.5,
            0.99,
            $oNow->format('%Y-%m-%d %H:%M:%S'),
            0
        );
        $rows = $stDsaza->execute($aData);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $previousOperationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            9,
            9,
            59,
            59,
            0,
            95,
            0.995,
            $oNow->format('%Y-%m-%d %H:%M:%S'),
            0
        );
        $rows = $stDsaza->execute($aData);
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
                    priority,
                    priority_factor,
                    past_zone_traffic_fraction,
                    created,
                    created_by,
                    expired
                )
            VALUES
                (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $aTypes = array(
            'integer',
            'integer',
            'timestamp',
            'timestamp',
            'integer',
            'integer',
            'integer',
            'integer',
            'float',
            'float',
            'float',
            'timestamp',
            'integer',
            'timestamp'
        );
        $stDsazaExpired = $oDbh->prepare($query, $aTypes, MDB2_PREPARE_MANIP);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $previousOperationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            2,
            3,
            30,
            30,
            0,
            0.4,
            0.5,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            0,
            $aDates['end']->format('%Y-%m-%d %H:30:00')
        );
        $rows = $stDsazaExpired->execute($aData);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $previousOperationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            2,
            3,
            30,
            30,
            0,
            0.4,
            0.5,
            $aDates['start']->format('%Y-%m-%d %H:30:00'),
            0,
            $aDates['end']->format('%Y-%m-%d %H:%M:%S')
        );
        $rows = $stDsazaExpired->execute($aData);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $previousOperationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            2,
            4,
            10,
            10,
            0,
            0.4,
            0.5,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            0,
            $aDates['end']->format('%Y-%m-%d %H:30:00')
        );
        $rows = $stDsazaExpired->execute($aData);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $previousOperationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            2,
            4,
            20,
            20,
            0,
            0.8,
            0.5,
            $aDates['start']->format('%Y-%m-%d %H:30:00'),
            0,
            $oSpecialDate->format('%Y-%m-%d %H:%M:%S')
        );
        $rows = $stDsazaExpired->execute($aData);
        $operationIntervalID = MAX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $previousOperationIntervalID = MAX_OperationInterval::previousOperationIntervalID($operationIntervalID);
        $previousOperationIntervalID = MAX_OperationInterval::previousOperationIntervalID($previousOperationIntervalID);
        $aDates = MAX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($oDate);
        $aDates = MAX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($aDates['start']);
        $oSpecialDate = new Date($aDates['end']);
        $oSpecialDate->addSeconds(1);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $previousOperationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            3,
            5,
            200,
            200,
            0,
            0.2,
            0.95,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            0,
            $aDates['end']->format('%Y-%m-%d %H:30:00')
        );
        $rows = $stDsazaExpired->execute($aData);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $previousOperationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            3,
            5,
            100,
            100,
            0,
            0.4,
            0.95,
            $aDates['start']->format('%Y-%m-%d %H:30:00'),
            0,
            $oSpecialDate->format('%Y-%m-%d %H:%M:%S')
        );
        $rows = $stDsazaExpired->execute($aData);
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

        $oDate = &$oServiceLocator->get('now');
        TestEnv::restoreEnv();
        $oServiceLocator->register('now', $oDate);

        // Test 18a
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
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $previousOperationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['start']->format('%Y-%m-%d'),
            $aDates['start']->format('%H'),
            1,
            0,
            1,
            1,
            $oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $rows = $stDia->execute($aData);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $previousOperationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['start']->format('%Y-%m-%d'),
            $aDates['start']->format('%H'),
            1,
            0,
            2,
            1,
            $oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $rows = $stDia->execute($aData);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $previousOperationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['start']->format('%Y-%m-%d'),
            $aDates['start']->format('%H'),
            2,
            0,
            3,
            2,
            $oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $rows = $stDia->execute($aData);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $previousOperationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['start']->format('%Y-%m-%d'),
            $aDates['start']->format('%H'),
            2,
            0,
            4,
            2,
            $oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $rows = $stDia->execute($aData);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $previousOperationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['start']->format('%Y-%m-%d'),
            $aDates['start']->format('%H'),
            3,
            0,
            5,
            5,
            $oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $rows = $stDia->execute($aData);
        $operationIntervalID = MAX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $previousOperationIntervalID = MAX_OperationInterval::previousOperationIntervalID($operationIntervalID);
        $previousOperationIntervalID = MAX_OperationInterval::previousOperationIntervalID($previousOperationIntervalID);
        $aDates = MAX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($oDate);
        $aDates = MAX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($aDates['start']);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $previousOperationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['start']->format('%Y-%m-%d'),
            $aDates['start']->format('%H'),
            1,
            0,
            1,
            100,
            $oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $rows = $stDia->execute($aData);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $previousOperationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['start']->format('%Y-%m-%d'),
            $aDates['start']->format('%H'),
            1,
            0,
            2,
            100,
            $oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $rows = $stDia->execute($aData);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $previousOperationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['start']->format('%Y-%m-%d'),
            $aDates['start']->format('%H'),
            2,
            0,
            3,
            200,
            $oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $rows = $stDia->execute($aData);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $previousOperationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['start']->format('%Y-%m-%d'),
            $aDates['start']->format('%H'),
            2,
            0,
            4,
            200,
            $oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $rows = $stDia->execute($aData);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $previousOperationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['start']->format('%Y-%m-%d'),
            $aDates['start']->format('%H'),
            3,
            0,
            5,
            500,
            $oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $rows = $stDia->execute($aData);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $previousOperationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['start']->format('%Y-%m-%d'),
            $aDates['start']->format('%H'),
            4,
            0,
            5,
            500,
            $oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $rows = $stDia->execute($aData);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $previousOperationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['start']->format('%Y-%m-%d'),
            $aDates['start']->format('%H'),
            10,
            0,
            4,
            1000,
            $oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $rows = $stDia->execute($aData);
        $operationIntervalID = MAX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $previousOperationIntervalID = MAX_OperationInterval::previousOperationIntervalID($operationIntervalID);
        for ($i = 0; $i <= (MINUTES_PER_WEEK / $conf['maintenance']['operationInterval']); $i++) {
            $previousOperationIntervalID = MAX_OperationInterval::previousOperationIntervalID($previousOperationIntervalID);
        }
        $aDates = MAX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($oDate);
        for ($i = 0; $i <= (MINUTES_PER_WEEK / $conf['maintenance']['operationInterval']); $i++) {
            $aDates = MAX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($aDates['start']);
        }
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $previousOperationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['start']->format('%Y-%m-%d'),
            $aDates['start']->format('%H'),
            11,
            0,
            4,
            2000,
            $oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $rows = $stDia->execute($aData);
        $operationIntervalID = MAX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $previousOperationIntervalID = MAX_OperationInterval::previousOperationIntervalID($operationIntervalID);
        $aDates = MAX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($oDate);
        $oSpecialDate = new Date($aDates['end']);
        $oSpecialDate->addSeconds(1);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $previousOperationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            1,
            2,
            10,
            10,
            0,
            0.5,
            0.99,
            $oNow->format('%Y-%m-%d %H:%M:%S'),
            0
        );
        $rows = $stDsaza->execute($aData);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $previousOperationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            9,
            9,
            59,
            59,
            0,
            95,
            0.995,
            $oNow->format('%Y-%m-%d %H:%M:%S'),
            0
        );
        $rows = $stDsaza->execute($aData);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $previousOperationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            2,
            3,
            30,
            30,
            0,
            0.4,
            0.5,
            $aDates['start']->format('%Y-%m-%d %H:30:00'),
            0,
            $oSpecialDate->format('%Y-%m-%d %H:%M:%S')
        );
        $rows = $stDsazaExpired->execute($aData);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $previousOperationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            2,
            3,
            30,
            30,
            0,
            0.4,
            0.5,
            $aDates['start']->format('%Y-%m-%d %H:30:00'),
            0,
            $aDates['end']->format('%Y-%m-%d %H:%M:%S')
        );
        $rows = $stDsazaExpired->execute($aData);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $previousOperationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            2,
            4,
            10,
            10,
            0,
            0.4,
            0.5,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            0,
            $aDates['end']->format('%Y-%m-%d %H:30:00')
        );
        $rows = $stDsazaExpired->execute($aData);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $previousOperationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            2,
            4,
            20,
            20,
            0,
            0.8,
            0.5,
            $aDates['start']->format('%Y-%m-%d %H:30:00'),
            0,
            $oSpecialDate->format('%Y-%m-%d %H:%M:%S')
        );
        $rows = $stDsazaExpired->execute($aData);
        $operationIntervalID = MAX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $previousOperationIntervalID = MAX_OperationInterval::previousOperationIntervalID($operationIntervalID);
        $previousOperationIntervalID = MAX_OperationInterval::previousOperationIntervalID($previousOperationIntervalID);
        $aDates = MAX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($oDate);
        $aDates = MAX_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($aDates['start']);
        $oSpecialDate = new Date($aDates['end']);
        $oSpecialDate->addSeconds(1);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $previousOperationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            3,
            5,
            200,
            200,
            0,
            0.2,
            0.95,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            0,
            $aDates['end']->format('%Y-%m-%d %H:30:00')
        );
        $rows = $stDsazaExpired->execute($aData);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $previousOperationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            3,
            5,
            100,
            100,
            0,
            0.4,
            0.95,
            $aDates['start']->format('%Y-%m-%d %H:30:00'),
            0,
            $oSpecialDate->format('%Y-%m-%d %H:%M:%S')
        );
        $rows = $stDsazaExpired->execute($aData);
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $previousOperationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            10,
            4,
            1000,
            1000,
            0,
            1,
            0.9,
            $aDates['start']->format('%Y-%m-%d %H:30:00'),
            0,
            $oSpecialDate->format('%Y-%m-%d %H:%M:%S')
        );
        $rows = $stDsazaExpired->execute($aData);
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
        $aData = array(
            $conf['maintenance']['operationInterval'],
            $previousOperationIntervalID,
            $aDates['start']->format('%Y-%m-%d %H:%M:%S'),
            $aDates['end']->format('%Y-%m-%d %H:%M:%S'),
            11,
            4,
            2000,
            2000,
            0,
            1,
            0.9,
            $aDates['start']->format('%Y-%m-%d %H:30:00'),
            0,
            $oSpecialDate->format('%Y-%m-%d %H:%M:%S')
        );
        $rows = $stDsazaExpired->execute($aData);
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
        TestEnv::restoreEnv();
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
        $oDbh = &OA_DB::singleton();
        $oMaxDalMaintenance = new OA_Dal_Maintenance_Priority();
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
        $rows = $oDbh->exec($query);

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
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['ad_id'], 1);
        $this->assertEqual($aRow['zone_id'], 1);
        $this->assertEqual($aRow['priority'], 0.45);
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
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $currentOperationIntervalID = MAX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $aDates = MAX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oDate);
        $this->assertEqual($aRow['operation_interval'], $conf['maintenance']['operationInterval']);
        $this->assertEqual($aRow['operation_interval_id'], $currentOperationIntervalID);
        $this->assertEqual($aRow['interval_start'], $aDates['start']->format('%Y-%m-%d %H:%M:%S'));
        $this->assertEqual($aRow['interval_end'], $aDates['end']->format('%Y-%m-%d %H:%M:%S'));
        $this->assertEqual($aRow['ad_id'], 1);
        $this->assertEqual($aRow['zone_id'], 1);
        $this->assertEqual($aRow['required_impressions'], 1000);
        $this->assertEqual($aRow['requested_impressions'], 1000);
        $this->assertEqual($aRow['priority'], 0.45);
        $this->assertNull($aRow['priority_factor']);
        $this->assertFalse($aRow['priority_factor_limited']);
        $this->assertNull($aRow['past_zone_traffic_fraction']);
        $this->assertEqual($aRow['created'], $oDate->format('%Y-%m-%d %H:%M:%S'));
        $this->assertEqual($aRow['created_by'], 0);
        $this->assertNull($aRow['expired']);
        $this->assertNull($aRow['expired_by']);

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
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['ad_id'], 1);
        $this->assertEqual($aRow['zone_id'], 1);
        $this->assertEqual($aRow['priority'], 0.9);
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
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $currentOperationIntervalID = MAX_OperationInterval::convertDateToOperationIntervalID($oOldDate);
        $aDates = MAX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oOldDate);
        $this->assertEqual($aRow['operation_interval'], $conf['maintenance']['operationInterval']);
        $this->assertEqual($aRow['operation_interval_id'], $currentOperationIntervalID);
        $this->assertEqual($aRow['interval_start'], $aDates['start']->format('%Y-%m-%d %H:%M:%S'));
        $this->assertEqual($aRow['interval_end'], $aDates['end']->format('%Y-%m-%d %H:%M:%S'));
        $this->assertEqual($aRow['ad_id'], 1);
        $this->assertEqual($aRow['zone_id'], 1);
        $this->assertEqual($aRow['required_impressions'], 1000);
        $this->assertEqual($aRow['requested_impressions'], 1000);
        $this->assertEqual($aRow['priority'], 0.45);
        $this->assertNull($aRow['priority_factor']);
        $this->assertFalse($aRow['priority_factor_limited']);
        $this->assertNull($aRow['past_zone_traffic_fraction']);
        $this->assertEqual($aRow['created'], $oOldDate->format('%Y-%m-%d %H:%M:%S'));
        $this->assertEqual($aRow['created_by'], 0);
        $this->assertEqual($aRow['expired'], $oDate->format('%Y-%m-%d %H:%M:%S'));
        $this->assertEqual($aRow['expired_by'], 0);
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
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $currentOperationIntervalID = MAX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $aDates = MAX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oDate);
        $this->assertEqual($aRow['operation_interval'], $conf['maintenance']['operationInterval']);
        $this->assertEqual($aRow['operation_interval_id'], $currentOperationIntervalID);
        $this->assertEqual($aRow['interval_start'], $aDates['start']->format('%Y-%m-%d %H:%M:%S'));
        $this->assertEqual($aRow['interval_end'], $aDates['end']->format('%Y-%m-%d %H:%M:%S'));
        $this->assertEqual($aRow['ad_id'], 1);
        $this->assertEqual($aRow['zone_id'], 1);
        $this->assertEqual($aRow['required_impressions'], 2000);
        $this->assertEqual($aRow['requested_impressions'], 2000);
        $this->assertEqual($aRow['priority'], 0.9);
        $this->assertEqual($aRow['priority_factor'], 0.1);
        $this->assertFalse($aRow['priority_factor_limited']);
        $this->assertEqual($aRow['past_zone_traffic_fraction'], 0.99);
        $this->assertEqual($aRow['created'], $oDate->format('%Y-%m-%d %H:%M:%S'));
        $this->assertEqual($aRow['created_by'], 0);
        $this->assertNull($aRow['expired']);
        $this->assertNull($aRow['expired_by']);
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
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $currentOperationIntervalID = MAX_OperationInterval::convertDateToOperationIntervalID($oDate);
        $aDates = MAX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oDate);
        $this->assertEqual($aRow['operation_interval'], $conf['maintenance']['operationInterval']);
        $this->assertEqual($aRow['operation_interval_id'], $currentOperationIntervalID);
        $this->assertEqual($aRow['interval_start'], $aDates['start']->format('%Y-%m-%d %H:%M:%S'));
        $this->assertEqual($aRow['interval_end'], $aDates['end']->format('%Y-%m-%d %H:%M:%S'));
        $this->assertEqual($aRow['ad_id'], 2);
        $this->assertEqual($aRow['zone_id'], 2);
        $this->assertEqual($aRow['required_impressions'], 500);
        $this->assertEqual($aRow['requested_impressions'], 500);
        $this->assertEqual($aRow['priority'], 0.1);
        $this->assertEqual($aRow['priority_factor'], 0.2);
        $this->assertTrue($aRow['priority_factor_limited']);
        $this->assertEqual($aRow['past_zone_traffic_fraction'], 0.45);
        $this->assertEqual($aRow['created'], $oDate->format('%Y-%m-%d %H:%M:%S'));
        $this->assertEqual($aRow['created_by'], 0);
        $this->assertNull($aRow['expired']);
        $this->assertNull($aRow['expired_by']);

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
        $oDbh = &OA_DB::singleton();
        // Set up test test data
        $conf = $GLOBALS['_MAX']['CONF'];
        // Write two record for same interval id one week apart
        $query = "
            INSERT INTO
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
                (?, ?, ?, ?, ?, ?, ?, ?)";
        $aTypes = array(
            'integer',
            'integer',
            'integer',
            'timestamp',
            'timestamp',
            'integer',
            'integer',
            'integer'
        );
        $st = $oDbh->prepare($query, $aTypes, MDB2_PREPARE_MANIP);
        $aData = array(
            1,
            60,
            0,
            '2005-05-02 00:00:00',
            '2005-05-02 00:59:59',
            1,
            200,
            400
        );
        $rows = $st->execute($aData);
        $aData = array(
            2,
            60,
            0,
            '2005-05-09 00:00:00',
            '2005-05-09 00:59:59',
            1,
            100,
            200
        );
        $rows = $st->execute($aData);
        $aData = array(
            3,
            60,
            1,
            '2005-05-02 01:00:00',
            '2005-05-02 01:59:59',
            1,
            200,
            500
        );
        $rows = $st->execute($aData);
        $aData = array(
            4,
            60,
            1,
            '2005-05-09 01:00:00',
            '2005-05-09 01:59:59',
            1,
            100,
            700
        );
        $rows = $st->execute($aData);
        // Set up operation interval date range to query
        $oStartDate = new Date('2005-05-16 00:00:00');
        $oEndDate = new Date('2005-05-16 01:59:59');

        // Array of zone ids to resolve
        $aZones = array(1);

        // Number of weeks to get average over
        $weeks = 2;
        $oMaxDalMaintenance = new OA_Dal_Maintenance_Priority();
        $result = &$oMaxDalMaintenance->getZonesImpressionAverageByRange($aZones, $oStartDate, $oEndDate, $weeks);

        $this->assertEqual(count($result), 1);
        $this->assertEqual(count($result[1]), 2);

        $this->assertEqual($result[1][0]['zone_id'], 1);
        $this->assertEqual($result[1][0]['operation_interval_id'], 0);
        $this->assertEqual($result[1][0]['average_impressions'], 300);

        $this->assertEqual($result[1][1]['zone_id'], 1);
        $this->assertEqual($result[1][1]['operation_interval_id'], 1);
        $this->assertEqual($result[1][1]['average_impressions'], 600);

        TestEnv::restoreEnv();
    }

    /**
     * Test 1 - check values and format of return values
     *
     * @TODO Implement tests to check date range being applied correctly
     */
    function testGetZonesImpressionHistoryByRange()
    {
        $oDbh = &OA_DB::singleton();
        // set up test test data
        $conf = $GLOBALS['_MAX']['CONF'];
        // write two record for same interval id one week apart
        $query = "
            INSERT INTO
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
                (?, ?, ?, ?, ?, ?, ?, ?)";
        $aTypes = array(
            'integer',
            'integer',
            'integer',
            'timestamp',
            'timestamp',
            'integer',
            'integer',
            'integer'
        );
        $st = $oDbh->prepare($query, $aTypes, MDB2_PREPARE_MANIP);
        $aData = array(
            1,
            60,
            0,
            '2005-05-09 00:00:00',
            '2005-05-09 00:59:59',
            1,
            100,
            700
        );
        $rows = $st->execute($aData);
        $aData = array(
            2,
            60,
            1,
            '2005-05-09 01:00:00',
            '2005-05-09 01:59:59',
            1,
            200,
            300
        );
        $rows = $st->execute($aData);
        $aData = array(
            3,
            60,
            2,
            '2005-05-09 02:00:00',
            '2005-05-09 02:59:59',
            1,
            300,
            400
        );
        $rows = $st->execute($aData);
        $aData = array(
            4,
            60,
            3,
            '2005-05-09 03:00:00',
            '2005-05-09 03:59:59',
            1,
            500,
            200
        );
        $rows = $st->execute($aData);
        $aData = array(
            5,
            60,
            4,
            '2005-05-09 04:00:00',
            '2005-05-09 04:59:59',
            1,
            500,
            600
        );
        $rows = $st->execute($aData);
        $aData = array(
            6,
            60,
            5,
            '2005-05-09 05:00:00',
            '2005-05-09 05:59:59',
            1,
            600,
            700
        );
        $rows = $st->execute($aData);

        // Set up operation interval date range to query
        $oStartDate = new Date('2005-05-09 01:00:00');
        $oEndDate = new Date('2005-05-09 04:00:00');

        // Array of zone ids to resolve
        $aZones = array(1);

        // Number of weeks to get average over
        $weeks = 2;
        $oMaxDalMaintenance = new OA_Dal_Maintenance_Priority();
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

        TestEnv::restoreEnv();
    }

    /**
     * A method to test the saveZoneImpressionForecasts method.
     */
    function testSaveZoneImpressionForecasts()
    {
        $oDbh = &OA_DB::singleton();
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
        $oMaxDalMaintenance = new OA_Dal_Maintenance_Priority();
        $oMaxDalMaintenance->saveZoneImpressionForecasts($aForecasts);

        // Test keys
        $conf = $GLOBALS['_MAX']['CONF'];
        $query = 'SELECT * from ' . $conf['table']['prefix'] . $conf['table']['data_summary_zone_impression_history'];
        $rc = $oDbh->query($query);
        $aRows = $rc->fetchAll();
        $this->assertTrue(isset($aRows[0]['data_summary_zone_impression_history_id']));
        $this->assertTrue(isset($aRows[0]['operation_interval']));
        $this->assertTrue(isset($aRows[0]['operation_interval_id']));
        $this->assertTrue(isset($aRows[0]['interval_start']));
        $this->assertTrue(isset($aRows[0]['interval_end']));
        $this->assertTrue(isset($aRows[0]['zone_id']));
        $this->assertTrue(isset($aRows[0]['forecast_impressions']));

        // Test forecast values written
        foreach($aRows as $key => $aValues) {
            $this->assertTrue($aValues['forecast_impressions'] > 0);
            $this->assertTrue(!(empty($aValues['interval_start'])));
            $this->assertTrue(!(empty($aValues['interval_end'])));
            // Bit funny way to test value, done so I can test in loop
            $this->assertEqual($aValues['forecast_impressions'], (($aValues['operation_interval_id'] + 1) * ($aValues['zone_id'] * 100)));
        }
        TestEnv::restoreEnv();
    }

    /**
     * A method to test the getActiveZones method.
     */
    function testGetActiveZones()
    {
        $da = new OA_Dal_Maintenance_Priority();
        $this->_generateStatsTwo();
        $ret = $da->getActiveZones();

        $this->assertTrue(is_array($ret));
        $this->assertTrue(count($ret) == 1);
        $zone = $ret[0];
        $this->assertTrue(array_key_exists('zoneid', $zone));
        $this->assertTrue(array_key_exists('zonename', $zone));
        $this->assertTrue(array_key_exists('zonetype', $zone));
        TestEnv::restoreEnv();
    }

    /**
     * A method to test the setRequiredAdImpressions method.
     */
    function testSaveRequiredAdImpressions()
    {
        $oDal = new OA_Dal_Maintenance_Priority();
        $oTable = &OA_DB_Table_Priority::singleton();
        $oTable->createTable('tmp_ad_required_impression');
        $aData = array(
            array(
                'ad_id'                => 23,
                'required_impressions' => 140,
            )
        );
        $result = $oDal->saveRequiredAdImpressions($aData);
        $oDbh = &OA_DB::singleton();
        $query = "SELECT * FROM tmp_ad_required_impression";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchAll();
        $this->assertTrue(is_array($aRow));
        $this->assertTrue(count($aRow) == 1);
        $aItem = $aRow[0];
        $this->assertTrue(array_key_exists('ad_id', $aItem));
        $this->assertTrue(array_key_exists('required_impressions', $aItem));
        $this->assertEqual($aItem['ad_id'], 23);
        $this->assertEqual($aItem['required_impressions'], 140);
        TestEnv::restoreEnv();
    }

    /**
     * A method to test the getRequiredAdImpressions method.
     */
    function testGetRequiredAdImpressions()
    {
        $oDal = new OA_Dal_Maintenance_Priority();
        $oTable = &OA_DB_Table_Priority::singleton();
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
        $oDbh = &OA_DB::singleton();
        $oDal = new OA_Dal_Maintenance_Priority();

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
        $oNow = new Date();
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['zones']}
                (
                    zoneid,
                    affiliateid,
                    zonename,
                    category,
                    ad_selection,
                    chain,
                    prepend,
                    append,
                    updated
                )
            VALUES
                (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $aTypes = array(
            'integer',
            'integer',
            'text',
            'integer',
            'integer',
            'integer',
            'integer',
            'integer',
            'timestamp'
        );
        $st = $oDbh->prepare($query, $aTypes, MDB2_PREPARE_MANIP);
        $aData = array(
            1,
            1,
            'Test Zone 1',
            0,
            0,
            0,
            0,
            0,
            $oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $rows = $st->execute($aData);
        $aData = array(
            2,
            1,
            'Test Zone 2',
            0,
            0,
            0,
            0,
            0,
            $oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $rows = $st->execute($aData);
        $result = $oDal->getZoneImpressionForecasts();
        $this->assertTrue(is_array($result));
        $this->assertEqual(count($result), 2);
        $this->assertEqual($result[1], $conf['priority']['defaultZoneForecastImpressions']);
        $this->assertEqual($result[2], $conf['priority']['defaultZoneForecastImpressions']);

        $oDate = &$oServiceLocator->get('now');
        TestEnv::restoreEnv();
        $oServiceLocator->register('now', $oDate);

        // Test 4
        $aData = array(
            1,
            1,
            'Test Zone 1',
            0,
            0,
            0,
            0,
            0,
            $oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $rows = $st->execute($aData);
        $aData = array(
            2,
            1,
            'Test Zone 2',
            0,
            0,
            0,
            0,
            0,
            $oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $rows = $st->execute($aData);
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
                )";
        $rows = $oDbh->exec($query);
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
                    2,
                    " . ($conf['priority']['defaultZoneForecastImpressions'] + 40) . "
                )";
        $rows = $oDbh->exec($query);
        $result = $oDal->getZoneImpressionForecasts();
        $this->assertTrue(is_array($result));
        $this->assertEqual(count($result), 2);
        $this->assertEqual($result[1], $conf['priority']['defaultZoneForecastImpressions'] + 20);
        $this->assertEqual($result[2], $conf['priority']['defaultZoneForecastImpressions'] + 40);

        $oDate = &$oServiceLocator->get('now');
        TestEnv::restoreEnv();
        $oServiceLocator->register('now', $oDate);

        // Test 5
        $aData = array(
            1,
            1,
            'Test Zone 1',
            0,
            0,
            0,
            0,
            0,
            $oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $rows = $st->execute($aData);
        $aData = array(
            2,
            1,
            'Test Zone 2',
            0,
            0,
            0,
            0,
            0,
            $oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $rows = $st->execute($aData);
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
                )";
        $rows = $oDbh->exec($query);
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
                    2,
                    " . ($conf['priority']['defaultZoneForecastImpressions'] + 40) . "
                )";
        $rows = $oDbh->exec($query);
        $result = $oDal->getZoneImpressionForecasts();
        $this->assertTrue(is_array($result));
        $this->assertEqual(count($result), 2);
        $this->assertEqual($result[1], $conf['priority']['defaultZoneForecastImpressions']);
        $this->assertEqual($result[2], $conf['priority']['defaultZoneForecastImpressions'] + 40);

        $oDate = &$oServiceLocator->get('now');
        TestEnv::restoreEnv();
        $oServiceLocator->register('now', $oDate);

        // Test 6
        $aData = array(
            1,
            1,
            'Test Zone 1',
            0,
            0,
            0,
            0,
            0,
            $oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $rows = $st->execute($aData);
        $aData = array(
            2,
            1,
            'Test Zone 2',
            0,
            0,
            0,
            0,
            0,
            $oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $rows = $st->execute($aData);
        $aData = array(
            5,
            2,
            'Test Zone 5',
            0,
            0,
            0,
            0,
            0,
            $oNow->format('%Y-%m-%d %H:%M:%S')
        );
        $rows = $st->execute($aData);
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
                )";
        $rows = $oDbh->exec($query);
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
                    2,
                    " . ($conf['priority']['defaultZoneForecastImpressions'] + 40) . "
                )";
        $rows = $oDbh->exec($query);
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
                )";
        $rows = $oDbh->exec($query);
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
                    2,
                    " . ($conf['priority']['defaultZoneForecastImpressions'] + 100) . "
                )";
        $rows = $oDbh->exec($query);
        $result = $oDal->getZoneImpressionForecasts();
        $this->assertTrue(is_array($result));
        $this->assertEqual(count($result), 3);
        $this->assertEqual($result[1], $conf['priority']['defaultZoneForecastImpressions']);
        $this->assertEqual($result[2], $conf['priority']['defaultZoneForecastImpressions'] + 40);
        $this->assertEqual($result[5], $conf['priority']['defaultZoneForecastImpressions']);
        TestEnv::restoreEnv();
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
        $oDbh = &OA_DB::singleton();
        $oDal = new OA_Dal_Maintenance_Priority();

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
        $query = "
            INSERT INTO
                {$conf['table']['prefix']}{$conf['table']['ad_zone_assoc']}
                (
                    ad_id,
                    zone_id,
                    link_type
                )
            VALUES
                (?, ?, ?)";
        $aTypes = array(
            'integer',
            'integer',
            'integer'
        );
        $st = $oDbh->prepare($query, $aTypes, MDB2_PREPARE_MANIP);
        $aData = array(
            1,
            1,
            1
        );
        $rows = $st->execute($aData);
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
        TestEnv::restoreEnv();

        // Test 4
        $aData = array(
            1,
            1,
            1
        );
        $rows = $st->execute($aData);
        $aData = array(
            1,
            2,
            1
        );
        $rows = $st->execute($aData);
        $aData = array(
            1,
            7,
            1
        );
        $rows = $st->execute($aData);
        $aData = array(
            2,
            2,
            1
        );
        $rows = $st->execute($aData);
        $aData = array(
            2,
            7,
            0
        );
        $rows = $st->execute($aData);
        $aData = array(
            3,
            1,
            1
        );
        $rows = $st->execute($aData);
        $aData = array(
            3,
            9,
            1
        );
        $rows = $st->execute($aData);
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
        TestEnv::restoreEnv();
    }

    /**
     * A method to test the saveAllocatedImpressions method.
     */
    function testSaveAllocatedImpressions()
    {
        $oDbh = &OA_DB::singleton();
        $oDal = new OA_Dal_Maintenance_Priority();
        // Create the required temporary table for the tests
        $oTable = &OA_DB_Table_Priority::singleton();
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
        $rc = $oDbh->query($query);
        $result = $rc->fetchAll();
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
        $oDbh = &OA_DB::singleton();
        $oDal = new OA_Dal_Maintenance_Priority();

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
        $rows = $oDbh->exec($query);
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
        $rows = $oDbh->exec($query);
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
        $rows = $oDbh->exec($query);
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
        TestEnv::restoreEnv();
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
        $oDbh = &OA_DB::singleton();
        $oDal = new OA_Dal_Maintenance_Priority();
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
        $oDbh = &OA_DB::singleton();

        $oDate = new Date();
        $oDate->addSeconds((SECONDS_PER_DAY * 4));
        $expiryDate1 = $oDate->getYear() . "-" . $oDate->getMonth() . "-" . $oDate->getDay();

        $oDate->addSeconds((SECONDS_PER_DAY * 4));
        $expiryDate2 = $oDate->getYear() . "-" . $oDate->getMonth() . "-" . $oDate->getDay();

        $oDate->subtractSeconds((SECONDS_PER_DAY * 2));
        $expiryDateLessTwoDays = $oDate->getYear() . "-" . $oDate->getMonth() . "-" . $oDate->getDay();

        // Add 3 campaigns
        $campaignsTable = $conf['table']['prefix'] . 'campaigns';
        $sql = "
            INSERT INTO
                $campaignsTable
                (
                    campaignid,
                    campaignname,
                    clientid,
                    views,
                    clicks,
                    conversions,
                    expire,
                    activate,
                    active,
                    priority,
                    weight,
                    target_impression,
                    anonymous,
                    updated
                )
            VALUES
                (
                    1,
                    'Test Campaign',
                    1,
                    0,
                    400,
                    0,
                    '" . $expiryDate1 . "',
                    " . OA_Dal::noDateString() . ",
                    't',
                    '3',
                    1,
                    0,
                    'f',
                    '" . $oDate->format('%Y-%m-%d %H:%M:%S') . "'
                )";
        $rows = $oDbh->exec($sql);

        $sql = "
            INSERT INTO
                $campaignsTable
                (
                    campaignid,
                    campaignname,
                    clientid,
                    views,
                    clicks,
                    conversions,
                    expire,
                    activate,
                    active,
                    priority,
                    weight,
                    target_impression,
                    anonymous,
                    updated
                )
            VALUES
                (
                    2,
                    'Test Campaign',
                    1,
                    0,
                    0,
                    400,
                    " . OA_Dal::noDateString() . ",
                    " . OA_Dal::noDateString() . ",
                    't',
                    '2',
                    1,
                    0,
                    'f',
                    '" . $oDate->format('%Y-%m-%d %H:%M:%S') . "'
                )";
        $rows = $oDbh->exec($sql);

        $sql = "
            INSERT INTO
                $campaignsTable
                (
                    campaignid,
                    campaignname,
                    clientid,
                    views,
                    clicks,
                    conversions,
                    expire,
                    activate,
                    active,
                    priority,
                    weight,
                    target_impression,
                    anonymous,
                    updated
                )
            VALUES
                (
                    3,
                    'Test Campaign',
                    1,
                    500,
                    0,
                    0,
                    '" . $expiryDate2 . "',
                    " . OA_Dal::noDateString() . ",
                    't',
                    '3',
                    1,
                    0,
                    'f',
                    '" . $oDate->format('%Y-%m-%d %H:%M:%S') . "'
                )";
        $rows = $oDbh->exec($sql);

        $sql = "
            INSERT INTO
                $campaignsTable
                (
                    campaignid,
                    campaignname,
                    clientid,
                    views,
                    clicks,
                    conversions,
                    expire,
                    activate,
                    active,
                    priority,
                    weight,
                    target_impression,
                    anonymous,
                    updated
                )
            VALUES
                (
                    4,
                    'Test Campaign',
                    1,
                    500,
                    0,
                    401,
                    " . OA_Dal::noDateString() . ",
                    " . OA_Dal::noDateString() . ",
                    't',
                    '4',
                    2,
                    0,
                    'f',
                    '" . $oDate->format('%Y-%m-%d %H:%M:%S') . "'
                )";
        $rows = $oDbh->exec($sql);

        $sql = "
            INSERT INTO
                $campaignsTable
                (
                    campaignid,
                    campaignname,
                    clientid,
                    views,
                    clicks,
                    conversions,
                    expire,
                    activate,
                    active,
                    priority,
                    weight,
                    target_impression,
                    anonymous,
                    updated
                )
            VALUES
                (
                    5,
                    'Test Campaign',
                    1,
                    500,
                    0,
                    401,
                    " . OA_Dal::noDateString() . ",
                    " . OA_Dal::noDateString() . ",
                    't',
                    '3',
                    2,
                    0,
                    'f',
                    '" . $oDate->format('%Y-%m-%d %H:%M:%S') . "'
                )";
        $rows = $oDbh->exec($sql);

        // Add 1st banner to campaign 1
        $bannersTable = $conf['table']['prefix'] . 'banners';
        $sql = "INSERT INTO $bannersTable (bannerid, campaignid, active, contenttype, pluginversion, storagetype, filename, imageurl, htmltemplate, htmlcache, width, height, weight, seq, target, url, alt, status, bannerTEXT, description, autohtml, adserver, block, capping, session_capping, compiledlimitation, append, appendtype, bannertype, alt_filename, alt_imageurl, alt_contenttype, acls_updated, updated)
        VALUES (1,1,'t','gif',0,'sql','468x60_4.gif','','','',468,60,1,0,'','http://www.google.com','Campaign1 - Banner 1','','','','f','',0, 0,0,'','',0,0,'','','','" . $oDate->format('%Y-%m-%d %H:%M:%S') . "','" . $oDate->format('%Y-%m-%d %H:%M:%S') . "');";
        $rows = $oDbh->exec($sql);

        // Banner 1, Campaign 1 - acls delivery restrictions
        $aclsTable = $conf['table']['prefix'] . 'acls';
        $sql = "INSERT INTO $aclsTable (bannerid,   logical, type,        comparison, data,                        executionorder)
                                VALUES (1,          'and',   'Time:Date', '!=',       '$expiryDateLessTwoDays',    0)";
        $rows = $oDbh->exec($sql);

        $sql = "INSERT INTO $aclsTable (bannerid,   logical, type,        comparison, data,   executionorder)
                                VALUES (1,          'and',   'Time:Hour', '!=',       '1',    1)";
        $rows = $oDbh->exec($sql);

        // Add 2nd banner to campaign 1
        $bannersTable = $conf['table']['prefix'] . 'banners';
        $sql = "INSERT INTO $bannersTable (bannerid, campaignid, active, contenttype, pluginversion, storagetype, filename, imageurl, htmltemplate, htmlcache, width, height, weight, seq, target, url, alt, status, bannerTEXT, description, autohtml, adserver, block, capping, session_capping, compiledlimitation, append, appendtype, bannertype, alt_filename, alt_imageurl, alt_contenttype, acls_updated, updated)
        VALUES (2,1,'t','gif',0,'sql','468x60_4.gif','','','',468,60,1,0,'','http://www.google.com','Campaign 1 - Banner 2','','','','f','',0, 0,0,'','',0,0,'','','','" . $oDate->format('%Y-%m-%d %H:%M:%S') . "','" . $oDate->format('%Y-%m-%d %H:%M:%S') . "');";
        $rows = $oDbh->exec($sql);

        // Banner 2, Campaign 1 - acls delivery restrictions
        $aclsTable = $conf['table']['prefix'] . 'acls';
        $sql = "INSERT INTO $aclsTable (bannerid,   logical, type,        comparison, data,                        executionorder)
                                VALUES (2,          'and',   'Time:Date', '!=',       '$expiryDateLessTwoDays',    0)";
        $rows = $oDbh->exec($sql);

        $sql = "INSERT INTO $aclsTable (bannerid,   logical, type,        comparison, data,   executionorder)
                                VALUES (2,          'and',   'Time:Hour', '!=',       '1,2',    1)";
        $rows = $oDbh->exec($sql);

        // Add 1st banner to campaign 2
        $bannersTable = $conf['table']['prefix'] . 'banners';
        $sql = "INSERT INTO $bannersTable (bannerid, campaignid, active, contenttype, pluginversion, storagetype, filename, imageurl, htmltemplate, htmlcache, width, height, weight, seq, target, url, alt, status, bannerTEXT, description, autohtml, adserver, block, capping, session_capping, compiledlimitation, append, appendtype, bannertype, alt_filename, alt_imageurl, alt_contenttype, acls_updated, updated)
        VALUES (3,2,'t','gif',0,'sql','468x60_4.gif','','','',468,60,1,0,'','http://www.google.com','Campaign 2 - Banner 1','','','','f','',0, 0,0,'','',0,0,'','','','" . $oDate->format('%Y-%m-%d %H:%M:%S') . "','" . $oDate->format('%Y-%m-%d %H:%M:%S') . "');";
        $rows = $oDbh->exec($sql);

        // Banner 1, Campaign 2 - acls delivery restrictions
        $aclsTable = $conf['table']['prefix'] . 'acls';
        $sql = "INSERT INTO $aclsTable (bannerid,   logical, type,        comparison, data,                        executionorder)
                                VALUES (3,          'and',   'Time:Date', '!=',       '$expiryDateLessTwoDays',    0)";
        $rows = $oDbh->exec($sql);

        $sql = "INSERT INTO $aclsTable (bannerid,   logical, type,       comparison, data,   executionorder)
                                VALUES (3,          'and',   'Time:Day', '!=',       '5',    1)";
        $rows = $oDbh->exec($sql);

        // Add 2nd banner to campaign 2
        $bannersTable = $conf['table']['prefix'] . 'banners';
        $sql = "INSERT INTO $bannersTable (bannerid, campaignid, active, contenttype, pluginversion, storagetype, filename, imageurl, htmltemplate, htmlcache, width, height, weight, seq, target, url, alt, status, bannerTEXT, description, autohtml, adserver, block, capping, session_capping, compiledlimitation, append, appendtype, bannertype, alt_filename, alt_imageurl, alt_contenttype, acls_updated, updated)
        VALUES (4,2,'t','gif',0,'sql','468x60_4.gif','','','',468,60,1,0,'','http://www.google.com','Campaign 2 - Banner 2','','','','f','',0, 0,0,'','',0,0,'','','','" . $oDate->format('%Y-%m-%d %H:%M:%S') . "','" . $oDate->format('%Y-%m-%d %H:%M:%S') . "');";
        $rows = $oDbh->exec($sql);

        // Banner 2, Campaign 2 - acls delivery restrictions
        $aclsTable = $conf['table']['prefix'] . 'acls';
        $sql = "INSERT INTO $aclsTable (bannerid,   logical, type,       comparison, data,                        executionorder)
                                VALUES (4,          'or',   'Time:Date', '!=',       '$expiryDateLessTwoDays',    0)";
        $rows = $oDbh->exec($sql);

        $sql = "INSERT INTO $aclsTable (bannerid,   logical, type,       comparison, data,   executionorder)
                                VALUES (4,          'or',   'Time:Hour', '==',       '1,2',    1)";
        $rows = $oDbh->exec($sql);

        // Add 1st banner to campaign 3
        $bannersTable = $conf['table']['prefix'] . 'banners';
        $sql = "INSERT INTO $bannersTable (bannerid, campaignid, active, contenttype, pluginversion, storagetype, filename, imageurl, htmltemplate, htmlcache, width, height, weight, seq, target, url, alt, status, bannerTEXT, description, autohtml, adserver, block, capping, session_capping, compiledlimitation, append, appendtype, bannertype, alt_filename, alt_imageurl, alt_contenttype, acls_updated, updated)
        VALUES (5,3,'t','gif',0,'sql','468x60_4.gif','','','',468,60,1,0,'','http://www.google.com','Campaign 3 - Banner 1','','','','f','',0, 0,0,'','',0,0,'','','','" . $oDate->format('%Y-%m-%d %H:%M:%S') . "','" . $oDate->format('%Y-%m-%d %H:%M:%S') . "');";
        $rows = $oDbh->exec($sql);

        // Banner 1, Campaign 3 - acls delivery restrictions
        $aclsTable = $conf['table']['prefix'] . 'acls';
        $sql = "INSERT INTO $aclsTable (bannerid,   logical, type,        comparison, data,                        executionorder)
                                VALUES (5,          'and',   'Time:Date', '!=',       '$expiryDateLessTwoDays',    0)";
        $rows = $oDbh->exec($sql);

        $sql = "INSERT INTO $aclsTable (bannerid,   logical, type,      comparison, data,   executionorder)
                                VALUES (5,          'or',   'Time:Day', '==',       '5',    1)";
        $rows = $oDbh->exec($sql);

        // Add 2nd banner to campaign 3
        $bannersTable = $conf['table']['prefix'] . 'banners';
        $sql = "INSERT INTO $bannersTable (bannerid, campaignid, active, contenttype, pluginversion, storagetype, filename, imageurl, htmltemplate, htmlcache, width, height, weight, seq, target, url, alt, status, bannerTEXT, description, autohtml, adserver, block, capping, session_capping, compiledlimitation, append, appendtype, bannertype, alt_filename, alt_imageurl, alt_contenttype, acls_updated, updated)
        VALUES (6,3,'t','gif',0,'sql','468x60_4.gif','','','',468,60,1,0,'','http://www.google.com','Campaign 3 - Banner 2','','','','f','',0, 0,0,'','',0,0,'','','','" . $oDate->format('%Y-%m-%d %H:%M:%S') . "','" . $oDate->format('%Y-%m-%d %H:%M:%S') . "');";
        $rows = $oDbh->exec($sql);

        // Banner 2, Campaign 3 - acls delivery restrictions
        $aclsTable = $conf['table']['prefix'] . 'acls';
        $sql = "INSERT INTO $aclsTable (bannerid,   logical, type,     comparison, data,                        executionorder)
                                VALUES (6,          'or',   'Time:Date',   '!=',       '$expiryDateLessTwoDays',    0)";
        $rows = $oDbh->exec($sql);

        $sql = "INSERT INTO $aclsTable (bannerid,   logical, type,       comparison, data,   executionorder)
                                VALUES (6,          'or',   'Time:Hour', '!=',       '1,2',    1)";
        $rows = $oDbh->exec($sql);
    }

    /**
     * A method to generate data for testing.
     *
     * @access private
     */
    function _generateStatsTwo()
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $oDbh = &OA_DB::singleton();

        // Populate data_summary_ad_hourly
        $statsTable = $conf['table']['prefix'] . 'data_summary_ad_hourly';
        for ($hour = 0; $hour < 24; $hour ++) {
            $oNow = new Date();
            $sql = "
                INSERT INTO
                    $statsTable
                    (
                        day,
                        hour,
                        ad_id,
                        creative_id,
                        zone_id,
                        requests,
                        impressions,
                        clicks,
                        conversions,
                        total_basket_value,
                        updated
                    )
                VALUES
                    (
                        '" . $oNow->format('%Y-%m-%d %H:%M:%S') . "',
                        $hour,
                        1,
                        ".rand(1, 999).",
                        ".rand(1, 999).",
                        ".rand(1, 999).",
                        ".rand(1, 999).",
                        ".rand(1, 999).",
                        ".rand(1, 999).",
                        0,
                        '" . $oNow->format('%Y-%m-%d %H:%M:%S') . "'
                    )";
            $rows = $oDbh->exec($sql);
        }
        // Populate campaigns table
        $campaignsTable = $conf['table']['prefix'] . 'campaigns';
        $sql = "
            INSERT INTO
                $campaignsTable
                (
                    campaignid,
                    campaignname,
                    clientid,
                    views,
                    clicks,
                    conversions,
                    expire,
                    activate,
                    active,
                    priority,
                    weight,
                    target_impression,
                    anonymous,
                    updated
                )
            VALUES
                (
                    4,
                    'Test Campaign',
                    1,
                    500,
                    0,
                    401,
                    " . OA_Dal::noDateString() . ",
                    " . OA_Dal::noDateString() . ",
                    't',
                    '4',
                    2,
                    0,
                    'f',
                    '" . $oNow->format('%Y-%m-%d %H:%M:%S') . "'
                )";
        $rows = $oDbh->exec($sql);

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
                        alt_contenttype,
                        updated,
                        acls_updated
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
                        '',
                        '" . $oNow->format('%Y-%m-%d %H:%M:%S') . "',
                        '" . $oNow->format('%Y-%m-%d %H:%M:%S') . "'
                    )";
        $rows = $oDbh->exec($sql);

        // Add an agency record
        $agencyTable = $conf['table']['prefix'] . 'agency';
        $sql = "
            INSERT INTO
                $agencyTable
                (
                    agencyid,
                    name,
                    contact,
                    email,
                    username,
                    password,
                    permissions,
                    language,
                    logout_url,
                    active,
                    updated
                )
            VALUES
                (
                    1,
                    'Test Agency',
                    'sdfsdfsdf',
                    'demian@phpkitchen.com',
                    'Demian Turner',
                    'passwd',
                    0,
                    'en_GB',
                    'logout.php',
                    1,
                    '" . $oNow->format('%Y-%m-%d %H:%M:%S') . "'
                )";
        $rows = $oDbh->exec($sql);

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
                        reportdeactivate,
                        updated
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
                        't',
                        '" . $oNow->format('%Y-%m-%d %H:%M:%S') . "'
                    )";
        $rows = $oDbh->exec($sql);

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
                        publiczones,
                        updated
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
                        'f',
                        '" . $oNow->format('%Y-%m-%d %H:%M:%S') . "'
                    )";
        $rows = $oDbh->exec($sql);

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
                        forceappend,
                        updated
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
                        'f',
                        '" . $oNow->format('%Y-%m-%d %H:%M:%S') . "'
                    )";
        $rows = $oDbh->exec($sql);

        // Add ad_zone_assoc record
        $zonesAssocTable = $conf['table']['prefix'] . 'ad_zone_assoc';
        $sql = "INSERT INTO $zonesAssocTable VALUES (1, 1, 1, '0', 1)";
        $rows = $oDbh->exec($sql);
    }

}

?>
