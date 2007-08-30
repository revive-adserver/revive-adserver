<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
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
require_once MAX_PATH . '/lib/max/Entity/Ad.php';
require_once MAX_PATH . '/lib/max/Maintenance/Priority/Entities.php';

require_once MAX_PATH . '/lib/OA/DB/Table/Priority.php';
require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/lib/OA/Dal/Maintenance/Priority.php';
require_once 'Date.php';
require_once 'DB/QueryTool.php';
require_once MAX_PATH . '/lib/max/Dal/tests/util/DalUnitTestCase.php';

// pgsql execution time before refactor: 162.20s
// pgsql execution time after refactor: 29.425s

/**
 * A class for testing the non-DB specific OA_Dal_Maintenance_Priority class.
 *
 * @package    OpenadsDal
 * @subpackage TestSuite
 * @author     Monique Szpak <monique.szpak@openads.org>
 * @author     James Floyd <james@m3.net>
 * @author     Andrew Hill <andrew.hill@openads.org>
 * @author     Demian Turner <demian@m3.net>
 */
class Test_OA_Dal_Maintenance_Priority_ZoneImpressionForecasts extends UnitTestCase
{
    var $doZones = null;
    var $doHist = null;

    /**
     * The constructor method.
     */
    function Test_OA_Dal_Maintenance_Priority_ZoneImpressionForecasts()
    {
        $this->UnitTestCase();
    }

    /**
     * A method to generate data for testing.
     *
     * @access private
     */
    function _generateTestZones($numZones)
    {
        $oNow = new Date();
        if (is_null($this->doZones))
        {
            $this->doZones = OA_Dal::factoryDO('zones');
        }
        $doZones->updated = $oNow->format('%Y-%m-%d %H:%M:%S');
        return DataGenerator::generate($this->doZones,$numZones);
    }

    /**
     * A method to generate data for testing.
     *
     * @access private
     */
    function _generateTestHistory($idZone, $aDates, $adjustment)
    {
        if (is_null($this->doHist))
        {
            $this->doHist = OA_Dal::factoryDO('data_summary_zone_impression_history');
        }
        $conf = $GLOBALS['_MAX']['CONF'];
        $this->doHist->operation_interval = $conf['maintenance']['operationInterval'];
        $this->doHist->operation_interval_id = OA_OperationInterval::convertDateToOperationIntervalID($aDates['start']);
        $this->doHist->interval_start = $aDates['start']->format('%Y-%m-%d %H:%M:%S');
        $this->doHist->interval_end   = $aDates['end']->format('%Y-%m-%d %H:%M:%S');
        $this->doHist->zone_id = $idZone;
        $this->doHist->forecast_impressions = $conf['priority']['defaultZoneForecastImpressions'] + $adjustment;
        $idHist = DataGenerator::generateOne($this->doHist);
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
        $query = 'SELECT * from ' . $oDbh->quoteIdentifier($conf['table']['prefix'] . 'data_summary_zone_impression_history',true);
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
        DataGenerator::cleanUp(array('data_summary_zone_impression_history'));
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
        $aZoneIds = $this->_generateTestZones(2);
        $result = $oDal->getZoneImpressionForecasts();
        $this->assertTrue(is_array($result));
        $this->assertEqual(count($result), 2);
        $this->assertEqual($result[$aZoneIds[0]], $conf['priority']['defaultZoneForecastImpressions']);
        $this->assertEqual($result[$aZoneIds[1]], $conf['priority']['defaultZoneForecastImpressions']);

        $oDate = &$oServiceLocator->get('now');
        DataGenerator::cleanUp();
        $oServiceLocator->register('now', $oDate);

        // Test 4
        $aZoneIds = $this->_generateTestZones(2);
        $aDates = OA_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oDate);
        $this->_generateTestHistory($aZoneIds[0], $aDates, 20);
        $this->_generateTestHistory($aZoneIds[1], $aDates, 40);

        $result = $oDal->getZoneImpressionForecasts();
        $this->assertTrue(is_array($result));
        $this->assertEqual(count($result), 2);
        $this->assertEqual($result[$aZoneIds[0]], $conf['priority']['defaultZoneForecastImpressions'] + 20);
        $this->assertEqual($result[$aZoneIds[1]], $conf['priority']['defaultZoneForecastImpressions'] + 40);

        $oDate = &$oServiceLocator->get('now');
        DataGenerator::cleanUp();
        $oServiceLocator->register('now', $oDate);

        // Test 5
        $aZoneIds = $this->_generateTestZones(2);
        $aDates = OA_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oDate);
        $this->_generateTestHistory($aZoneIds[0], $aDates, -1);
        $this->_generateTestHistory($aZoneIds[1], $aDates, 40);

        $result = $oDal->getZoneImpressionForecasts();
        $this->assertTrue(is_array($result));
        $this->assertEqual(count($result), 2);
        $this->assertEqual($result[$aZoneIds[0]], $conf['priority']['defaultZoneForecastImpressions']);
        $this->assertEqual($result[$aZoneIds[1]], $conf['priority']['defaultZoneForecastImpressions'] + 40);

        $oDate = &$oServiceLocator->get('now');
        DataGenerator::cleanUp();
        $oServiceLocator->register('now', $oDate);

        // Test 6
        $aZoneIds = $this->_generateTestZones(3);
        $aDates = OA_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oDate);
        $this->_generateTestHistory($aZoneIds[0], $aDates, -1);
        $this->_generateTestHistory($aZoneIds[1], $aDates, 40);
        $aDates = OA_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($oDate);
        $this->_generateTestHistory($aZoneIds[0], $aDates, 100);
        $this->_generateTestHistory($aZoneIds[1], $aDates, 100);

        $result = $oDal->getZoneImpressionForecasts();
        $this->assertTrue(is_array($result));
        $this->assertEqual(count($result), 3);
        $this->assertEqual($result[$aZoneIds[0]], $conf['priority']['defaultZoneForecastImpressions']);
        $this->assertEqual($result[$aZoneIds[1]], $conf['priority']['defaultZoneForecastImpressions'] + 40);
        $this->assertEqual($result[$aZoneIds[2]], $conf['priority']['defaultZoneForecastImpressions']);
        DataGenerator::cleanUp();
    }

    /**
     * A method to test the saveZoneImpressionForecasts method.
     */
    function OLD_testSaveZoneImpressionForecasts()
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
        $query = 'SELECT * from ' . $oDbh->quoteIdentifier($conf['table']['prefix'] . 'data_summary_zone_impression_history',true);
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
        TestEnv::restoreEnv('dropTmpTables');
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
    function OLD_testGetZoneImpressionForecasts()
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
                {$oDbh->quoteIdentifier($conf['table']['prefix'].$conf['table']['zones'],true)}
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
        TestEnv::restoreEnv('dropTmpTables');
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
        $aDates = OA_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oDate);
        $operationIntervalID = OA_OperationInterval::convertDateToOperationIntervalID($aDates['start']);
        $query = "
            INSERT INTO
                {$oDbh->quoteIdentifier($conf['table']['prefix'].'data_summary_zone_impression_history',true)}
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
                {$oDbh->quoteIdentifier($conf['table']['prefix'].'data_summary_zone_impression_history',true)}
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
        TestEnv::restoreEnv('dropTmpTables');
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
        $aDates = OA_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oDate);
        $operationIntervalID = OA_OperationInterval::convertDateToOperationIntervalID($aDates['start']);
        $query = "
            INSERT INTO
                {$oDbh->quoteIdentifier($conf['table']['prefix'].'data_summary_zone_impression_history',true)}
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
                {$oDbh->quoteIdentifier($conf['table']['prefix'].'data_summary_zone_impression_history',true)}
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
        TestEnv::restoreEnv('dropTmpTables');
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
        $aDates = OA_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oDate);
        $operationIntervalID = OA_OperationInterval::convertDateToOperationIntervalID($aDates['start']);
        $query = "
            INSERT INTO
                {$oDbh->quoteIdentifier($conf['table']['prefix'].'data_summary_zone_impression_history',true)}
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
                {$oDbh->quoteIdentifier($conf['table']['prefix'].'data_summary_zone_impression_history',true)}
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
        $aDates = OA_OperationInterval::convertDateToPreviousOperationIntervalStartAndEndDates($oDate);
        $operationIntervalID = OA_OperationInterval::convertDateToOperationIntervalID($aDates['start']);
        $query = "
            INSERT INTO
                {$oDbh->quoteIdentifier($conf['table']['prefix'].'data_summary_zone_impression_history',true)}
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
                {$oDbh->quoteIdentifier($conf['table']['prefix'].'data_summary_zone_impression_history',true)}
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
        TestEnv::restoreEnv('dropTmpTables');
    }

}

?>
