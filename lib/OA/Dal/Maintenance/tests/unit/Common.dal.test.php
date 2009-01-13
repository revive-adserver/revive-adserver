<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
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

require_once MAX_PATH . '/lib/max/Dal/tests/util/DalUnitTestCase.php';

require_once MAX_PATH . '/lib/OA.php';
require_once MAX_PATH . '/lib/OA/Dal/Maintenance/Common.php';
require_once MAX_PATH . '/lib/pear/Date.php';

/**
 * A class for testing the non-DB specific OA_Dal_Maintenance_Common class.
 *
 * @package    OpenXDal
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew.hill@openx.org>
 */
class Test_OA_Dal_Maintenance_Common extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function Test_OA_Dal_Maintenance_Common()
    {
        $this->UnitTestCase();
    }

    /**
     * A method to test the setProcessLastRunInfo() method.
     *
     * Requirements:
     * Test 1: Test with invalid data, and ensure false is returned.
     * Test 2: Test that basic information is logged correctly (use log_maintenance_forecasting
     *              table, as run_type info not needed).
     * Test 3: Test that bad table and column names return false.
     * Test 4: Test that run type information is logged correctly.
     */
    function testSetProcessLastRunInfo()
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        $oDbh =& OA_DB::singleton();

        $oStartDate    = new Date('2006-10-05 12:07:01');
        $oEndDate      = new Date('2006-10-05 12:15:00');
        $oUpdateToDate = new Date('2006-10-05 11:59:59');

        $oDalMaintenanceCommon = new OA_Dal_Maintenance_Common();

        // Test 1
        $result = $oDalMaintenanceCommon->setProcessLastRunInfo(
            null,
            $oEndDate,
            $oUpdateToDate,
            $aConf['table']['log_maintenance_priority'],
            true
        );
        $this->assertFalse($result);
        $result = $oDalMaintenanceCommon->setProcessLastRunInfo(
            $oStartDate,
            null,
            $oUpdateToDate,
            $tableName,
            true
        );
        $this->assertFalse($result);
        $result = $oDalMaintenanceCommon->setProcessLastRunInfo(
            $oStartDate,
            $oEndDate,
            'foo',
            $aConf['table']['log_maintenance_priority'],
            true
        );
        $this->assertFalse($result);
        $this->assertFalse($result);
        $result = $oDalMaintenanceCommon->setProcessLastRunInfo(
            $oStartDate,
            $oEndDate,
            $oUpdateToDate,
            $aConf['table']['log_maintenance_priority'],
            17
        );
        $this->assertFalse($result);

        // Test 2
        $result = $oDalMaintenanceCommon->setProcessLastRunInfo(
            $oStartDate,
            $oEndDate,
            $oUpdateToDate,
            $aConf['table']['log_maintenance_forecasting'],
            true
        );
        $this->assertTrue($result);
        $query = "
            SELECT
                log_maintenance_forecasting_id,
                start_run,
                end_run,
                operation_interval,
                duration,
                updated_to
            FROM
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['log_maintenance_forecasting'],true);
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['log_maintenance_forecasting_id'], 1);
        $this->assertEqual($aRow['start_run'], '2006-10-05 12:07:01');
        $this->assertEqual($aRow['end_run'], '2006-10-05 12:15:00');
        $this->assertEqual($aRow['operation_interval'], $aConf['maintenance']['operationInterval']);
        $this->assertEqual($aRow['duration'], (7 * 60) + 59);
        $this->assertEqual($aRow['updated_to'], '2006-10-05 11:59:59');

        // Test 3
        OA::disableErrorHandling();
        $oDbh =& OA_DB::singleton();
        $oDalMaintenanceCommon = new OA_Dal_Maintenance_Common();
        $result = $oDalMaintenanceCommon->setProcessLastRunInfo(
            $oStartDate,
            $oEndDate,
            $oUpdateToDate,
            'foo',
            true
        );
        $this->assertFalse($result);
        $result = $oDalMaintenanceCommon->setProcessLastRunInfo(
            $oStartDate,
            $oEndDate,
            $oUpdateToDate,
            $aConf['table']['log_maintenance_priority'],
            true,
            'foo',
            1
        );
        $this->assertFalse($result);
        OA::enableErrorHandling();

        // Test 4
        $result = $oDalMaintenanceCommon->setProcessLastRunInfo(
            $oStartDate,
            $oEndDate,
            $oUpdateToDate,
            $aConf['table']['log_maintenance_priority'],
            true,
            'run_type',
            0
        );
        $result = $oDalMaintenanceCommon->setProcessLastRunInfo(
            $oStartDate,
            $oEndDate,
            $oUpdateToDate,
            $aConf['table']['log_maintenance_priority'],
            true,
            'run_type',
            1
        );
        $this->assertTrue($result);
        $query = "
            SELECT
                log_maintenance_priority_id,
                start_run,
                end_run,
                operation_interval,
                duration,
                updated_to,
                run_type
            FROM
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['log_maintenance_priority'],true)."
            WHERE
                log_maintenance_priority_id = 1";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['log_maintenance_priority_id'], 1);
        $this->assertEqual($aRow['start_run'], '2006-10-05 12:07:01');
        $this->assertEqual($aRow['end_run'], '2006-10-05 12:15:00');
        $this->assertEqual($aRow['operation_interval'], $aConf['maintenance']['operationInterval']);
        $this->assertEqual($aRow['duration'], (7 * 60) + 59);
        $this->assertEqual($aRow['updated_to'], '2006-10-05 11:59:59');
        $this->assertEqual($aRow['run_type'], 0);
        $query = "
            SELECT
                log_maintenance_priority_id,
                start_run,
                end_run,
                operation_interval,
                duration,
                updated_to,
                run_type
            FROM
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['log_maintenance_priority'],true)."
            WHERE
                log_maintenance_priority_id = 2";
        $rc = $oDbh->query($query);
        $aRow = $rc->fetchRow();
        $this->assertEqual($aRow['log_maintenance_priority_id'], 2);
        $this->assertEqual($aRow['start_run'], '2006-10-05 12:07:01');
        $this->assertEqual($aRow['end_run'], '2006-10-05 12:15:00');
        $this->assertEqual($aRow['operation_interval'], $aConf['maintenance']['operationInterval']);
        $this->assertEqual($aRow['duration'], (7 * 60) + 59);
        $this->assertEqual($aRow['updated_to'], '2006-10-05 11:59:59');
        $this->assertEqual($aRow['run_type'], 1);
        $aCleanupTables = array($aConf['table']['log_maintenance_priority'],$aConf['table']['log_maintenance_forecasting'],$aConf['table']['log_maintenance_forecasting']);
        DataGenerator::cleanUp($aCleanupTables);
    }

    /**
     * A method to test the getProcessLastRunInfo() method.
     *
     * Requirements:
     * Test 1: Test with invalid data, and ensure false is returned.
     * Test 2: Test with no data in the database and ensure null is returned.
     * Test 3: Test with bad table and column names, and ensure false is returned.
     * Test 4: Test that the correct values are returned from data_ tables.
     * Test 5: Test that the correct values are returned from log_ tables.
     */
    function testGetProcessLastRunInfo()
    {
        $aConf =& $GLOBALS['_MAX']['CONF'];
        $oDbh =& OA_DB::singleton();

        $log_maintenance_priority = $aConf['table']['prefix'] . $aConf['table']['log_maintenance_priority'];
        $data_raw_ad_impression = $aConf['table']['prefix'] . $aConf['table']['data_raw_ad_impression'];

        $oDalMaintenanceCommon = new OA_Dal_Maintenance_Common();

        // Test 1
        $result = $oDalMaintenanceCommon->getProcessLastRunInfo(
            $aConf['table']['log_maintenance_priority'],
            'foo',
            null,
            'start_run',
            array()
        );
        $this->assertFalse($result);
        $result = $oDalMaintenanceCommon->getProcessLastRunInfo(
            $aConf['table']['log_maintenance_priority'],
            array(),
            null,
            'start_run',
            'foo'
        );
        $this->assertFalse($result);

        // Test 2
        $result = $oDalMaintenanceCommon->getProcessLastRunInfo(
            $aConf['table']['log_maintenance_priority']
        );
        $this->assertNull($result);
        $result = $oDalMaintenanceCommon->getProcessLastRunInfo(
            $aConf['table']['log_maintenance_priority'],
            array(),
            null,
            'start_run',
            array(
                'tableName' => $aConf['table']['data_raw_ad_impression'],
                'type'      => 'hour'
            )
        );
        $this->assertNull($result);

        // Test 3
        OA::disableErrorHandling();
        $result = $oDalMaintenanceCommon->getProcessLastRunInfo(
            'foo',
            array(),
            null,
            'start_run',
            array()
        );
        $this->assertFalse($result);
        $result = $oDalMaintenanceCommon->getProcessLastRunInfo(
            $aConf['table']['log_maintenance_priority'],
            array('foo'),
            null,
            'start_run',
            array()
        );
        $this->assertFalse($result);
        $result = $oDalMaintenanceCommon->getProcessLastRunInfo(
            $aConf['table']['log_maintenance_priority'],
            array(),
            null,
            'start_run',
            array(
                'tableName' => 'foo',
                'type'      => 'hour'
            )
        );
        $this->assertFalse($result);
        OA::enableErrorHandling();

        // Test 4
        $query = "
            INSERT INTO
                ".$oDbh->quoteIdentifier($data_raw_ad_impression,true)."
                (
                    date_time,
                    ad_id,
                    creative_id,
                    zone_id
                )
            VALUES
                (
                    '2006-10-06 08:53:42',
                    1,
                    1,
                    1
                )";
        $rows = $oDbh->exec($query);
        $aResult = $oDalMaintenanceCommon->getProcessLastRunInfo(
            $aConf['table']['log_maintenance_priority'],
            array('operation_interval'),
            null,
            'start_run',
            array(
                'tableName' => $aConf['table']['data_raw_ad_impression'],
                'type'      => 'hour'
            )
        );
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 1);
        $this->assertEqual($aResult['updated_to'], '2006-10-06 07:59:59');
        $query = "
            INSERT INTO
                ".$oDbh->quoteIdentifier($data_raw_ad_impression,true)."
                (
                    date_time,
                    ad_id,
                    creative_id,
                    zone_id
                )
            VALUES
                (
                    '2006-10-06 09:53:42',
                    1,
                    1,
                    1
                )";
        $rows = $oDbh->exec($query);
        $aResult = $oDalMaintenanceCommon->getProcessLastRunInfo(
            $aConf['table']['log_maintenance_priority'],
            array('operation_interval'),
            null,
            'start_run',
            array(
                'tableName' => $aConf['table']['data_raw_ad_impression'],
                'type'      => 'hour'
            )
        );
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 1);
        $this->assertEqual($aResult['updated_to'], '2006-10-06 07:59:59');

        $aConf['maintenance']['operationInterval'] = 60;
        $aResult = $oDalMaintenanceCommon->getProcessLastRunInfo(
            $aConf['table']['log_maintenance_priority'],
            array('operation_interval'),
            null,
            'start_run',
            array(
                'tableName' => $aConf['table']['data_raw_ad_impression'],
                'type'      => 'hour'
            )
        );
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 1);
        $this->assertEqual($aResult['updated_to'], '2006-10-06 07:59:59');
        $aResult = $oDalMaintenanceCommon->getProcessLastRunInfo(
            $aConf['table']['log_maintenance_priority'],
            array('operation_interval'),
            null,
            'start_run',
            array(
                'tableName' => $aConf['table']['data_raw_ad_impression'],
                'type'      => 'oi'
            )
        );
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 1);
        $this->assertEqual($aResult['updated_to'], '2006-10-06 07:59:59');

        $aConf['maintenance']['operationInterval'] = 30;
        $aResult = $oDalMaintenanceCommon->getProcessLastRunInfo(
            $aConf['table']['log_maintenance_priority'],
            array('operation_interval'),
            null,
            'start_run',
            array(
                'tableName' => $aConf['table']['data_raw_ad_impression'],
                'type'      => 'hour'
            )
        );
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 1);
        $this->assertEqual($aResult['updated_to'], '2006-10-06 07:59:59');
        $aResult = $oDalMaintenanceCommon->getProcessLastRunInfo(
            $aConf['table']['log_maintenance_priority'],
            array('operation_interval'),
            null,
            'start_run',
            array(
                'tableName' => $aConf['table']['data_raw_ad_impression'],
                'type'      => 'oi'
            )
        );
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 1);
        $this->assertEqual($aResult['updated_to'], '2006-10-06 08:29:59');
        TestEnv::restoreConfig();
        TestEnv::restoreEnv();

        // Test 5
        $query = "
            INSERT INTO
                ".$oDbh->quoteIdentifier($log_maintenance_priority,true)."
                (
                    start_run,
                    end_run,
                    operation_interval,
                    duration,
                    run_type,
                    updated_to
                )
            VALUES
                (
                    '2006-10-06 12:07:01',
                    '2006-10-06 12:10:01',
                    60,
                    180,
                    1,
                    '2006-10-06 11:59:59'
                )";
        $rows = $oDbh->exec($query);
        $aResult = $oDalMaintenanceCommon->getProcessLastRunInfo(
            $aConf['table']['log_maintenance_priority'],
            array('operation_interval', 'run_type'),
            null,
            'start_run',
            array(
                'tableName' => $aConf['table']['data_raw_ad_impression'],
                'type'      => 'hour'
            )
        );
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 3);
        $this->assertEqual($aResult['updated_to'], '2006-10-06 11:59:59');
        $this->assertEqual($aResult['operation_interval'], 60);
        $this->assertEqual($aResult['run_type'], 1);
        $query = "
            INSERT INTO
                ".$oDbh->quoteIdentifier($log_maintenance_priority,true)."
                (
                    start_run,
                    end_run,
                    operation_interval,
                    duration,
                    run_type,
                    updated_to
                )
            VALUES
                (
                    '2006-10-06 11:07:01',
                    '2006-10-06 11:10:01',
                    60,
                    180,
                    0,
                    '2006-10-06 20:59:59'
                )";
        $rows = $oDbh->exec($query);
        $aResult = $oDalMaintenanceCommon->getProcessLastRunInfo(
            $aConf['table']['log_maintenance_priority'],
            array('operation_interval', 'run_type'),
            null,
            'start_run',
            array(
                'tableName' => $aConf['table']['data_raw_ad_impression'],
                'type'      => 'hour'
            )
        );
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 3);
        $this->assertEqual($aResult['updated_to'], '2006-10-06 11:59:59');
        $this->assertEqual($aResult['operation_interval'], 60);
        $this->assertEqual($aResult['run_type'], 1);
        $aResult = $oDalMaintenanceCommon->getProcessLastRunInfo(
            $aConf['table']['log_maintenance_priority'],
            array('operation_interval', 'run_type'),
            null,
            'updated_to',
            array(
                'tableName' => $aConf['table']['data_raw_ad_impression'],
                'type'      => 'hour'
            )
        );
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 3);
        $this->assertEqual($aResult['updated_to'], '2006-10-06 20:59:59');
        $this->assertEqual($aResult['operation_interval'], 60);
        $this->assertEqual($aResult['run_type'], 0);
        $aResult = $oDalMaintenanceCommon->getProcessLastRunInfo(
            $aConf['table']['log_maintenance_priority'],
            array('operation_interval', 'run_type'),
            'WHERE run_type = 0',
            'start_run',
            array(
                'tableName' => $aConf['table']['data_raw_ad_impression'],
                'type'      => 'hour'
            )
        );
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 3);
        $this->assertEqual($aResult['updated_to'], '2006-10-06 20:59:59');
        $this->assertEqual($aResult['operation_interval'], 60);
        $this->assertEqual($aResult['run_type'], 0);
        TestEnv::restoreEnv();
    }

    /**
     * A method to test the getAllDeliveryLimitationsByTypeId() method.
     *
     * Requirements:
     * Test 1:  Test for ad limitations with no data, and ensure null returned
     * Test 2:  Test for channel limitations with no data, and ensure null returned
     * Test 3:  Test with an ad limitation for an ad, but with a different ad id, and
     *          ensure null returned
     * Test 4:  Test with an ad limitation, but with a channel id, and ensure null
     *          returned
     * Test 5:  Test with an ad limitation, but with a bad $type, and ensure null
     *          returned
     * Test 6:  Test with an ad limitation, and ensure values returned
     * Test 7:  Test with a channel limitation, but with an ad id, and ensure null
     *          returned
     * Test 8:  Test with a channel limitation, but with a different channel id, and
     *          ensure null returned
     * Test 9:  Test with a channel limitation, but with a bad $type, and ensure null
     *          returned
     * Test 10: Test with a channel limitation, and ensure values returned
     */
    function testGetAllDeliveryLimitationsByTypeId()
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        $oDbh =& OA_DB::singleton();

        $oDalMaintenanceCommon = new OA_Dal_Maintenance_Common();

        // Test 1
        $aResult = $oDalMaintenanceCommon->getAllDeliveryLimitationsByTypeId(1, 'ad');
        $this->assertNull($aResult);

        // Test 2
        $aResult = $oDalMaintenanceCommon->getAllDeliveryLimitationsByTypeId(1, 'channel');
        $this->assertNull($aResult);

        $table = $aConf['table']['prefix'] . $aConf['table']['acls'];
        $query = "
            INSERT INTO
                ".$oDbh->quoteIdentifier($table,true)."
                (
                    bannerid,
                    logical,
                    type,
                    comparison,
                    data,
                    executionorder
                )
            VALUES
                (?, ?, ?, ?, ?, ?)";
        $aTypes = array(
            'integer',
            'text',
            'text',
            'text',
            'text',
            'integer'
        );
        $st = $oDbh->prepare($query, $aTypes, MDB2_PREPARE_MANIP);
        $aData = array(
            3,
            'and',
            'Time:Date',
            '!=',
            '2005-05-25',
            0
        );
        $rows = $st->execute($aData);
        $aData = array(
            3,
            'and',
            'Geo:Country',
            '==',
            'GB',
            1
        );
        $rows = $st->execute($aData);

        // Test 3
        $aResult = $oDalMaintenanceCommon->getAllDeliveryLimitationsByTypeId(1, 'ad');
        $this->assertNull($aResult);

        // Test 4
        $aResult = $oDalMaintenanceCommon->getAllDeliveryLimitationsByTypeId(1, 'channel');
        $this->assertNull($aResult);

        // Test 5
        $aResult = $oDalMaintenanceCommon->getAllDeliveryLimitationsByTypeId(3, 'foo');
        $this->assertNull($aResult);

        // Test 6
        $aResult = $oDalMaintenanceCommon->getAllDeliveryLimitationsByTypeId(3, 'ad');
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 2);
        $this->assertEqual(count($aResult[0]), 6);
        $this->assertEqual($aResult[0]['ad_id'], 3);
        $this->assertEqual($aResult[0]['logical'], 'and');
        $this->assertEqual($aResult[0]['type'], 'Time:Date');
        $this->assertEqual($aResult[0]['comparison'], '!=');
        $this->assertEqual($aResult[0]['data'], '2005-05-25');
        $this->assertEqual($aResult[0]['executionorder'], 0);
        $this->assertEqual(count($aResult[1]), 6);
        $this->assertEqual($aResult[1]['ad_id'], 3);
        $this->assertEqual($aResult[1]['logical'], 'and');
        $this->assertEqual($aResult[1]['type'], 'Geo:Country');
        $this->assertEqual($aResult[1]['comparison'], '==');
        $this->assertEqual($aResult[1]['data'], 'GB');
        $this->assertEqual($aResult[1]['executionorder'], 1);

        $aCleanupTables = array($aConf['table']['acls']);
        foreach ($aCleanupTables as $table) {
            $query = "DELETE FROM {$aConf['table']['prefix']}$table";
            $oDbh->exec($query);
        }
        DataGenerator::resetSequence($aCleanupTables);

        TestEnv::restoreEnv();

        $table = $aConf['table']['prefix'] . $aConf['table']['acls_channel'];
        $query = "
            INSERT INTO
                ".$oDbh->quoteIdentifier($table,true)."
                (
                    channelid,
                    logical,
                    type,
                    comparison,
                    data,
                    executionorder
                )
            VALUES
                (?, ?, ?, ?, ?, ?)";
        $aTypes = array(
            'integer',
            'text',
            'text',
            'text',
            'text',
            'integer'
        );
        $st = $oDbh->prepare($query, $aTypes, MDB2_PREPARE_MANIP);
        $aData = array(
            3,
            'and',
            'Time:Date',
            '!=',
            '2005-05-25',
            0
        );
        $rows = $st->execute($aData);
        $aData = array(
            3,
            'and',
            'Geo:Country',
            '==',
            'GB',
            1
        );
        $rows = $st->execute($aData);

        // Test 7
        $aResult = $oDalMaintenanceCommon->getAllDeliveryLimitationsByTypeId(1, 'ad');
        $this->assertNull($aResult);

        // Test 8
        $aResult = $oDalMaintenanceCommon->getAllDeliveryLimitationsByTypeId(1, 'channel');
        $this->assertNull($aResult);

        // Test 9
        $aResult = $oDalMaintenanceCommon->getAllDeliveryLimitationsByTypeId(3, 'foo');
        $this->assertNull($aResult);

        // Test 10
        $aResult = $oDalMaintenanceCommon->getAllDeliveryLimitationsByTypeId(3, 'channel');
        $this->assertTrue(is_array($aResult));
        $this->assertEqual(count($aResult), 2);
        $this->assertEqual(count($aResult[0]), 6);
        $this->assertEqual($aResult[0]['ad_id'], 3);
        $this->assertEqual($aResult[0]['logical'], 'and');
        $this->assertEqual($aResult[0]['type'], 'Time:Date');
        $this->assertEqual($aResult[0]['comparison'], '!=');
        $this->assertEqual($aResult[0]['data'], '2005-05-25');
        $this->assertEqual($aResult[0]['executionorder'], 0);
        $this->assertEqual(count($aResult[1]), 6);
        $this->assertEqual($aResult[1]['ad_id'], 3);
        $this->assertEqual($aResult[1]['logical'], 'and');
        $this->assertEqual($aResult[1]['type'], 'Geo:Country');
        $this->assertEqual($aResult[1]['comparison'], '==');
        $this->assertEqual($aResult[1]['data'], 'GB');
        $this->assertEqual($aResult[1]['executionorder'], 1);

        $aCleanupTables = array($aConf['table']['acls_channel']);
        foreach ($aCleanupTables as $table) {
            $query = "DELETE FROM {$aConf['table']['prefix']}$table";
            $oDbh->exec($query);
        }
        DataGenerator::resetSequence($aCleanupTables);
    }

}

?>
