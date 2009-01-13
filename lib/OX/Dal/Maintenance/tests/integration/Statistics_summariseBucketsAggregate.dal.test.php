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

require_once LIB_PATH . '/Dal/Maintenance/Statistics/Factory.php';
require_once MAX_PATH . '/lib/OA/Dal/DataGenerator.php';

/**
 * A class for testing the summariseBucketsAggregate() method of the
 * DB agnostic OX_Dal_Maintenance_Statistics class.
 *
 * @package    OpenXDal
 * @subpackage TestSuite
 * @author     James Floyd <james@m3.net>
 * @author     Andrew Hill <andrew.hill@openx.org>
 * @author     Demian Turner <demian@m3.net>
 */
class Test_OX_Dal_Maintenance_Statistics_summariseBucketsAggregate extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function Test_OX_Dal_Maintenance_Statistics_summariseBucketsAggregate()
    {
        $this->UnitTestCase();
    }

    /**
     * A method to test the summariseBucketsAggregate() method.
     */
    function testSummariseBucketsAggregate()
    {
        $aConf =& $GLOBALS['_MAX']['CONF'];
        $aConf['maintenance']['operationInterval'] = 60;

        // Prepare standard test parameters
        $statisticsTableName = $aConf['table']['prefix'] . 'data_intermediate_ad';
        $aMigrationMaps = array(
            0 => array(
                'method'           => 'aggregate',
                'bucketTable'      => $aConf['table']['prefix'] . 'data_bkt_r',
                'dateTimeColumn'   => 'interval_start',
                'groupSource'      => array(
                    0 => 'interval_start',
                    1 => 'creative_id',
                    2 => 'zone_id'
                ),
                'groupDestination' => array(
                    0 => 'date_time',
                    1 => 'ad_id',
                    2 => 'zone_id'
                ),
                'sumSource'        => array(
                    0 => 'count'
                ),
                'sumDestination'   => array(
                    0 => 'requests'
                ),
                'sumDefault'       => array(
                    0 => 0
                )
            ),
            1 => array(
                'method'           => 'aggregate',
                'bucketTable'      => $aConf['table']['prefix'] . 'data_bkt_m',
                'dateTimeColumn'   => 'interval_start',
                'groupSource'      => array(
                    0 => 'interval_start',
                    1 => 'creative_id',
                    2 => 'zone_id'
                ),
                'groupDestination' => array(
                    0 => 'date_time',
                    1 => 'ad_id',
                    2 => 'zone_id'
                ),
                'sumSource'        => array(
                    0 => 'count'
                ),
                'sumDestination'   => array(
                    0 => 'impressions'
                ),
                'sumDefault'       => array(
                    0 => 0
                )
            ),
            2 => array(
                'method'           => 'aggregate',
                'bucketTable'      => $aConf['table']['prefix'] . 'data_bkt_c',
                'dateTimeColumn'   => 'interval_start',
                'groupSource'      => array(
                    0 => 'interval_start',
                    1 => 'creative_id',
                    2 => 'zone_id'
                ),
                'groupDestination' => array(
                    0 => 'date_time',
                    1 => 'ad_id',
                    2 => 'zone_id'
                ),
                'sumSource'        => array(
                    0 => 'count'
                ),
                'sumDestination'   => array(
                    0 => 'clicks'
                ),
                'sumDefault'       => array(
                    0 => 0
                )
            )
        );
        $aDates = array(
            'start' => new Date('2008-08-21 09:00:00'),
            'end'   => new Date('2008-08-21 09:59:59')
        );

        // Prepare the DAL object
        $oFactory = new OX_Dal_Maintenance_Statistics_Factory();
        $oDalMaintenanceStatistics = $oFactory->factory();

        $oNowDate = new Date();
        $aExtras = array(
            'operation_interval'    => $aConf['maintenance']['operationInterval'],
            'operation_interval_id' => OA_OperationInterval::convertDateToOperationIntervalID($aDates['start']),
            'interval_start'        => $oDalMaintenanceStatistics->oDbh->quote($aDates['start']->format('%Y-%m-%d %H:%M:%S'), 'timestamp') . $oDalMaintenanceStatistics->timestampCastString,
            'interval_end'          => $oDalMaintenanceStatistics->oDbh->quote($aDates['end']->format('%Y-%m-%d %H:%M:%S'), 'timestamp') . $oDalMaintenanceStatistics->timestampCastString,
            'creative_id'           => 0,
            'updated'               => $oDalMaintenanceStatistics->oDbh->quote($oNowDate->format('%Y-%m-%d %H:%M:%S'), 'timestamp') . $oDalMaintenanceStatistics->timestampCastString,
        );

        // Test 1: Test with an incorrect method name in the mapping array
        $savedValue = $aMigrationMaps[0]['method'];
        $aMigrationMaps[0]['method'] = 'foo';
        $result = $oDalMaintenanceStatistics->summariseBucketsAggregate($statisticsTableName, $aMigrationMaps, $aDates, $aExtras);
        $this->assertTrue(is_a($result, 'PEAR_Error'));
        $this->assertEqual($result->code, MAX_ERROR_INVALIDARGS);
        $this->assertEqual($result->message, "OX_Dal_Maintenance_Statistics::summariseBucketsAggregate() called with migration map index '0' having method 'foo' != 'aggregate'.");
        $aMigrationMaps[0]['method'] = $savedValue;

        // Test 2: Test with a different number of groupSource and groupDestination columns
        $savedValue = $aMigrationMaps[0]['groupSource'][1];
        unset($aMigrationMaps[0]['groupSource'][1]);
        $result = $oDalMaintenanceStatistics->summariseBucketsAggregate($statisticsTableName, $aMigrationMaps, $aDates, $aExtras);
        $this->assertTrue(is_a($result, 'PEAR_Error'));
        $this->assertEqual($result->code, MAX_ERROR_INVALIDARGS);
        $this->assertEqual($result->message, "OX_Dal_Maintenance_Statistics::summariseBucketsAggregate() called with migration map index '0' having different number of 'groupSource' and 'groupDestination' columns.");
        $aMigrationMaps[0]['groupSource'][1] = $savedValue;

        // Test 3: Test with a different number of sumSource and sumDestination columns
        $savedValue = $aMigrationMaps[1]['sumSource'][0];
        unset($aMigrationMaps[1]['sumSource'][0]);
        $result = $oDalMaintenanceStatistics->summariseBucketsAggregate($statisticsTableName, $aMigrationMaps, $aDates, $aExtras);
        $this->assertTrue(is_a($result, 'PEAR_Error'));
        $this->assertEqual($result->code, MAX_ERROR_INVALIDARGS);
        $this->assertEqual($result->message, "OX_Dal_Maintenance_Statistics::summariseBucketsAggregate() called with migration map index '1' having different number of 'sumSource' and 'sumDestination' columns.");
        $aMigrationMaps[1]['sumSource'][0] = $savedValue;

        // Test 4: Test with a different number of sumSource and sumDefault columns
        $savedValue = $aMigrationMaps[2]['sumDefault'][0];
        unset($aMigrationMaps[2]['sumDefault'][0]);
        $result = $oDalMaintenanceStatistics->summariseBucketsAggregate($statisticsTableName, $aMigrationMaps, $aDates, $aExtras);
        $this->assertTrue(is_a($result, 'PEAR_Error'));
        $this->assertEqual($result->code, MAX_ERROR_INVALIDARGS);
        $this->assertEqual($result->message, "OX_Dal_Maintenance_Statistics::summariseBucketsAggregate() called with migration map index '2' having different number of 'sumSource' and 'sumDefault' columns.");
        $aMigrationMaps[2]['sumDefault'][0] = $savedValue;

        // Test 5: Test with a different groupDestination sets
        $savedValue = $aMigrationMaps[2]['groupDestination'][0];
        $aMigrationMaps[2]['groupDestination'][0] = 'foo';
        $result = $oDalMaintenanceStatistics->summariseBucketsAggregate($statisticsTableName, $aMigrationMaps, $aDates, $aExtras);
        $this->assertTrue(is_a($result, 'PEAR_Error'));
        $this->assertEqual($result->code, MAX_ERROR_INVALIDARGS);
        $this->assertEqual($result->message, "OX_Dal_Maintenance_Statistics::summariseBucketsAggregate() called with migration map indexes '0' and '2' having different 'groupDestination' arrays.");
        $aMigrationMaps[2]['groupDestination'][0] = $savedValue;

        // Test 6: Test with date parameters that are not really dates
        $savedValue = $aDates['start'];
        $aDates['start'] = 'foo';
        $result = $oDalMaintenanceStatistics->summariseBucketsAggregate($statisticsTableName, $aMigrationMaps, $aDates, $aExtras);
        $this->assertTrue(is_a($result, 'PEAR_Error'));
        $this->assertEqual($result->code, MAX_ERROR_INVALIDARGS);
        $this->assertEqual($result->message, "OX_Dal_Maintenance_Statistics::summariseBucketsAggregate() called with invalid start/end date parameters -- not Date objects.");
        $aDates['start'] = $savedValue;

        $savedValue = $aDates['end'];
        $aDates['end'] = 'foo';
        $result = $oDalMaintenanceStatistics->summariseBucketsAggregate($statisticsTableName, $aMigrationMaps, $aDates, $aExtras);
        $this->assertTrue(is_a($result, 'PEAR_Error'));
        $this->assertEqual($result->code, MAX_ERROR_INVALIDARGS);
        $this->assertEqual($result->message, "OX_Dal_Maintenance_Statistics::summariseBucketsAggregate() called with invalid start/end date parameters -- not Date objects.");
        $aDates['end'] = $savedValue;

        // Test 7: Test with invalid start/end dates
        $savedValue = $aDates['start'];
        $aDates['start'] = new Date('2008-08-21 08:00:00');
        $result = $oDalMaintenanceStatistics->summariseBucketsAggregate($statisticsTableName, $aMigrationMaps, $aDates, $aExtras);
        $this->assertTrue(is_a($result, 'PEAR_Error'));
        $this->assertEqual($result->code, MAX_ERROR_INVALIDARGS);
        $this->assertEqual($result->message, "OX_Dal_Maintenance_Statistics::summariseBucketsAggregate() called with invalid start/end date parameters -- not operation interval bounds.");
        $aDates['start'] = $savedValue;

        $savedValue = $aDates['end'];
        $aDates['end'] = new Date('2008-08-22 09:59:59');
        $result = $oDalMaintenanceStatistics->summariseBucketsAggregate($statisticsTableName, $aMigrationMaps, $aDates, $aExtras);
        $this->assertTrue(is_a($result, 'PEAR_Error'));
        $this->assertEqual($result->code, MAX_ERROR_INVALIDARGS);
        $this->assertEqual($result->message, "OX_Dal_Maintenance_Statistics::summariseBucketsAggregate() called with invalid start/end date parameters -- not operation interval bounds.");
        $aDates['end'] = $savedValue;

        // Test 8: Test with an invalid statistics table name
        $savedValue = $statisticsTableName;
        $statisticsTableName = 'foo';
        $result = $oDalMaintenanceStatistics->summariseBucketsAggregate($statisticsTableName, $aMigrationMaps, $aDates, $aExtras);
        $this->assertTrue(is_a($result, 'PEAR_Error'));
        $this->assertEqual($result->code, MAX_ERROR_INVALIDREQUEST);
        $this->assertEqual($result->message, "OX_Dal_Maintenance_Statistics::summariseBucketsAggregate() called with invalid statistics table 'foo'.");
        $statisticsTableName = $savedValue;

        // Test 9: Test with no data_bkt_r table in the database
        $result = $oDalMaintenanceStatistics->summariseBucketsAggregate($statisticsTableName, $aMigrationMaps, $aDates, $aExtras);
        $this->assertTrue(is_a($result, 'PEAR_Error'));
        $this->assertEqual($result->code, MAX_ERROR_INVALIDREQUEST);
        $this->assertEqual($result->message, "OX_Dal_Maintenance_Statistics::summariseBucketsAggregate() called with migration map index '0' having invalid bucket table '{$aConf['table']['prefix']}data_bkt_r'.");

        // Install the openXDeliveryLog plugin, which will create the
        // data_bkt_r, data_bkt_m and data_bkt_c tables required for testing
        TestEnv::installPluginPackage('openXDeliveryLog', false);

        // Test 10: Test with all tables present, but no data
        $result = $oDalMaintenanceStatistics->summariseBucketsAggregate($statisticsTableName, $aMigrationMaps, $aDates, $aExtras);
        $this->assertEqual($result, 0);

        // Insert some data into the data_bkt_r, data_bkt_m and
        // data_bkt_c tables in the incorrect operation interval
        $oData_bkt_r = OA_Dal::factoryDO('data_bkt_r');
        $oData_bkt_r->interval_start = '2008-08-21 08:00:00';
        $oData_bkt_r->creative_id    = 1;
        $oData_bkt_r->zone_id        = 2;
        $oData_bkt_r->count          = 10;
        DataGenerator::generateOne($oData_bkt_r);

        $oData_bkt_m = OA_Dal::factoryDO('data_bkt_m');
        $oData_bkt_m->interval_start = '2008-08-21 08:00:00';
        $oData_bkt_m->creative_id    = 1;
        $oData_bkt_m->zone_id        = 2;
        $oData_bkt_m->count          = 9;
        DataGenerator::generateOne($oData_bkt_m);

        $oData_bkt_c = OA_Dal::factoryDO('data_bkt_c');
        $oData_bkt_c->interval_start = '2008-08-21 08:00:00';
        $oData_bkt_c->creative_id    = 1;
        $oData_bkt_c->zone_id        = 2;
        $oData_bkt_c->count          = 1;
        DataGenerator::generateOne($oData_bkt_c);

        // Test 11: Test with data in the incorrect operation interval
        $result = $oDalMaintenanceStatistics->summariseBucketsAggregate($statisticsTableName, $aMigrationMaps, $aDates, $aExtras);
        $this->assertEqual($result, 0);

        // Insert some data into the data_bkt_r, data_bkt_m and
        // data_bkt_c tables in the incorrect operation interval
        $oData_bkt_r = OA_Dal::factoryDO('data_bkt_r');
        $oData_bkt_r->interval_start = '2008-08-21 09:00:00';
        $oData_bkt_r->creative_id    = 1;
        $oData_bkt_r->zone_id        = 2;
        $oData_bkt_r->count          = 10;
        DataGenerator::generateOne($oData_bkt_r);

        $oData_bkt_m = OA_Dal::factoryDO('data_bkt_m');
        $oData_bkt_m->interval_start = '2008-08-21 09:00:00';
        $oData_bkt_m->creative_id    = 1;
        $oData_bkt_m->zone_id        = 2;
        $oData_bkt_m->count          = 9;
        DataGenerator::generateOne($oData_bkt_m);

        $oData_bkt_c = OA_Dal::factoryDO('data_bkt_c');
        $oData_bkt_c->interval_start = '2008-08-21 09:00:00';
        $oData_bkt_c->creative_id    = 1;
        $oData_bkt_c->zone_id        = 2;
        $oData_bkt_c->count          = 1;
        DataGenerator::generateOne($oData_bkt_c);

        // Test 12: Test with data in the correct operation interval
        $result = $oDalMaintenanceStatistics->summariseBucketsAggregate($statisticsTableName, $aMigrationMaps, $aDates, $aExtras);
        $this->assertEqual($result, 1);

        $oData_intermediate_ad = OA_Dal::factoryDO('data_intermediate_ad');
        $oData_intermediate_ad->find();
        $rows = $oData_intermediate_ad->getRowCount();
        $this->assertEqual($rows, 1);

        $oData_intermediate_ad = OA_Dal::factoryDO('data_intermediate_ad');
        $oData_intermediate_ad->ad_id = 1;
        $oData_intermediate_ad->find();
        $rows = $oData_intermediate_ad->getRowCount();
        $this->assertEqual($rows, 1);
        $oData_intermediate_ad->fetch();
        $this->assertEqual($oData_intermediate_ad->date_time,             '2008-08-21 09:00:00');
        $this->assertEqual($oData_intermediate_ad->operation_interval,    $aConf['maintenance']['operationInterval']);
        $this->assertEqual($oData_intermediate_ad->operation_interval_id, OA_OperationInterval::convertDateToOperationIntervalID($aDates['start']));
        $this->assertEqual($oData_intermediate_ad->interval_start,        '2008-08-21 09:00:00');
        $this->assertEqual($oData_intermediate_ad->interval_end,          '2008-08-21 09:59:59');
        $this->assertEqual($oData_intermediate_ad->ad_id,                 1);
        $this->assertEqual($oData_intermediate_ad->creative_id,           0);
        $this->assertEqual($oData_intermediate_ad->zone_id,               2);
        $this->assertEqual($oData_intermediate_ad->requests,              10);
        $this->assertEqual($oData_intermediate_ad->impressions,           9);
        $this->assertEqual($oData_intermediate_ad->clicks,                1);

        // Clean up generated data
        DataGenerator::cleanUp();

        // Insert some new data into the data_bkt_r, data_bkt_m and
        // data_bkt_c tables in the incorrect operation interval
        $oData_bkt_r = OA_Dal::factoryDO('data_bkt_r');
        $oData_bkt_r->interval_start = '2008-08-21 09:00:00';
        $oData_bkt_r->creative_id    = 2;
        $oData_bkt_r->zone_id        = 2;
        $oData_bkt_r->count          = 10;
        DataGenerator::generateOne($oData_bkt_r);

        $oData_bkt_m = OA_Dal::factoryDO('data_bkt_m');
        $oData_bkt_m->interval_start = '2008-08-21 09:00:00';
        $oData_bkt_m->creative_id    = 2;
        $oData_bkt_m->zone_id        = 2;
        $oData_bkt_m->count          = 9;
        DataGenerator::generateOne($oData_bkt_m);

        $oData_bkt_c = OA_Dal::factoryDO('data_bkt_c');
        $oData_bkt_c->interval_start = '2008-08-21 09:00:00';
        $oData_bkt_c->creative_id    = 2;
        $oData_bkt_c->zone_id        = 2;
        $oData_bkt_c->count          = 1;
        DataGenerator::generateOne($oData_bkt_c);

        $oData_bkt_r = OA_Dal::factoryDO('data_bkt_r');
        $oData_bkt_r->interval_start = '2008-08-21 09:00:00';
        $oData_bkt_r->creative_id    = 11;
        $oData_bkt_r->zone_id        = 12;
        $oData_bkt_r->count          = 10000;
        DataGenerator::generateOne($oData_bkt_r);

        $oData_bkt_m = OA_Dal::factoryDO('data_bkt_m');
        $oData_bkt_m->interval_start = '2008-08-21 09:00:00';
        $oData_bkt_m->creative_id    = 11;
        $oData_bkt_m->zone_id        = 12;
        $oData_bkt_m->count          = 9960;
        DataGenerator::generateOne($oData_bkt_m);

        $oData_bkt_c = OA_Dal::factoryDO('data_bkt_c');
        $oData_bkt_c->interval_start = '2008-08-21 09:00:00';
        $oData_bkt_c->creative_id    = 11;
        $oData_bkt_c->zone_id        = 12;
        $oData_bkt_c->count          = 500;
        DataGenerator::generateOne($oData_bkt_c);

        // Test 13: Test with new data in the correct operation interval
        $result = $oDalMaintenanceStatistics->summariseBucketsAggregate($statisticsTableName, $aMigrationMaps, $aDates, $aExtras);
        $this->assertEqual($result, 2);

        $oData_intermediate_ad = OA_Dal::factoryDO('data_intermediate_ad');
        $oData_intermediate_ad->find();
        $rows = $oData_intermediate_ad->getRowCount();
        $this->assertEqual($rows, 3);

        $oData_intermediate_ad = OA_Dal::factoryDO('data_intermediate_ad');
        $oData_intermediate_ad->ad_id = 1;
        $oData_intermediate_ad->find();
        $rows = $oData_intermediate_ad->getRowCount();
        $this->assertEqual($rows, 1);
        $oData_intermediate_ad->fetch();
        $this->assertEqual($oData_intermediate_ad->date_time,             '2008-08-21 09:00:00');
        $this->assertEqual($oData_intermediate_ad->operation_interval,    $aConf['maintenance']['operationInterval']);
        $this->assertEqual($oData_intermediate_ad->operation_interval_id, OA_OperationInterval::convertDateToOperationIntervalID($aDates['start']));
        $this->assertEqual($oData_intermediate_ad->interval_start,        '2008-08-21 09:00:00');
        $this->assertEqual($oData_intermediate_ad->interval_end,          '2008-08-21 09:59:59');
        $this->assertEqual($oData_intermediate_ad->ad_id,                 1);
        $this->assertEqual($oData_intermediate_ad->creative_id,           0);
        $this->assertEqual($oData_intermediate_ad->zone_id,               2);
        $this->assertEqual($oData_intermediate_ad->requests,              10);
        $this->assertEqual($oData_intermediate_ad->impressions,           9);
        $this->assertEqual($oData_intermediate_ad->clicks,                1);

        $oData_intermediate_ad = OA_Dal::factoryDO('data_intermediate_ad');
        $oData_intermediate_ad->ad_id = 2;
        $oData_intermediate_ad->find();
        $rows = $oData_intermediate_ad->getRowCount();
        $this->assertEqual($rows, 1);
        $oData_intermediate_ad->fetch();
        $this->assertEqual($oData_intermediate_ad->date_time,             '2008-08-21 09:00:00');
        $this->assertEqual($oData_intermediate_ad->operation_interval,    $aConf['maintenance']['operationInterval']);
        $this->assertEqual($oData_intermediate_ad->operation_interval_id, OA_OperationInterval::convertDateToOperationIntervalID($aDates['start']));
        $this->assertEqual($oData_intermediate_ad->interval_start,        '2008-08-21 09:00:00');
        $this->assertEqual($oData_intermediate_ad->interval_end,          '2008-08-21 09:59:59');
        $this->assertEqual($oData_intermediate_ad->ad_id,                 2);
        $this->assertEqual($oData_intermediate_ad->creative_id,           0);
        $this->assertEqual($oData_intermediate_ad->zone_id,               2);
        $this->assertEqual($oData_intermediate_ad->requests,              10);
        $this->assertEqual($oData_intermediate_ad->impressions,           9);
        $this->assertEqual($oData_intermediate_ad->clicks,                1);

        $oData_intermediate_ad = OA_Dal::factoryDO('data_intermediate_ad');
        $oData_intermediate_ad->ad_id = 11;
        $oData_intermediate_ad->find();
        $rows = $oData_intermediate_ad->getRowCount();
        $this->assertEqual($rows, 1);
        $oData_intermediate_ad->fetch();
        $this->assertEqual($oData_intermediate_ad->date_time,             '2008-08-21 09:00:00');
        $this->assertEqual($oData_intermediate_ad->operation_interval,    $aConf['maintenance']['operationInterval']);
        $this->assertEqual($oData_intermediate_ad->operation_interval_id, OA_OperationInterval::convertDateToOperationIntervalID($aDates['start']));
        $this->assertEqual($oData_intermediate_ad->interval_start,        '2008-08-21 09:00:00');
        $this->assertEqual($oData_intermediate_ad->interval_end,          '2008-08-21 09:59:59');
        $this->assertEqual($oData_intermediate_ad->ad_id,                 11);
        $this->assertEqual($oData_intermediate_ad->creative_id,           0);
        $this->assertEqual($oData_intermediate_ad->zone_id,               12);
        $this->assertEqual($oData_intermediate_ad->requests,              10000);
        $this->assertEqual($oData_intermediate_ad->impressions,           9960);
        $this->assertEqual($oData_intermediate_ad->clicks,                500);

        // Clean up generated data
        DataGenerator::cleanUp();

        // Also clean up the data migrated into the statistics table
        $oData_intermediate_ad= OA_Dal::factoryDO('data_intermediate_ad');
        $oData_intermediate_ad->data_intermediate_ad_id = 1;
        $oData_intermediate_ad->find();
        $oData_intermediate_ad->delete();

        $oData_intermediate_ad = OA_Dal::factoryDO('data_intermediate_ad');
        $oData_intermediate_ad->data_intermediate_ad_id = 2;
        $oData_intermediate_ad->find();
        $oData_intermediate_ad->delete();

        $oData_intermediate_ad = OA_Dal::factoryDO('data_intermediate_ad');
        $oData_intermediate_ad->data_intermediate_ad_id = 3;
        $oData_intermediate_ad->find();
        $oData_intermediate_ad->delete();

        // Uninstall the installed plugin
        TestEnv::uninstallPluginPackage('openXDeliveryLog', false);

        // Restore the test environment configuration
        TestEnv::restoreConfig();
    }

}

?>