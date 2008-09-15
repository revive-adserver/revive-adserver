<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
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
 * A class for testing the summariseBucketsRaw() method of the
 * DB agnostic OA_Dal_Maintenance_Statistics class.
 *
 * @package    OpenXDal
 * @subpackage TestSuite
 * @author     James Floyd <james@m3.net>
 * @author     Andrew Hill <andrew.hill@openx.org>
 * @author     Demian Turner <demian@m3.net>
 */
class Test_OA_Dal_Maintenance_Statistics_summariseBucketsRaw extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function Test_OA_Dal_Maintenance_Statistics_summariseBucketsRaw()
    {
        $this->UnitTestCase();
    }

    /**
     * A method to test the summariseBucketsRaw() method.
     */
    function testSummariseBucketsRaw()
    {
        $aConf =& $GLOBALS['_MAX']['CONF'];
        $aConf['maintenance']['operationInterval'] = 60;

        // Prepare standard test parameters
        $statisticsTableName = $aConf['table']['prefix'] . 'data_intermediate_ad_connection';
        $aMigrationDetails = array(
            'method'            => 'raw',
            'bucketTable'       => $aConf['table']['prefix'] . 'data_bkt_a',
            'dateTimeColumn'    => 'date_time',
            'source'            => array(
                0  => 'server_conv_id',
                1  => 'server_ip',
                2  => 'tracker_id',
                3  => 'date_time',
                4  => 'action_date_time',
                5  => 'creative_id',
                6  => 'zone_id',
                7  => 'ip_address',
                8  => 'action',
                9  => 'window',
                10 => 'status'
            ),
            'destination'       => array(
                0  => 'server_raw_tracker_impression_id',
                1  => 'server_raw_ip',
                2  => 'tracker_id',
                3  => 'tracker_date_time',
                4  => 'connection_date_time',
                5  => 'ad_id',
                6  => 'zone_id',
                7  => 'tracker_ip_address',
                8  => 'connection_action',
                9  => 'connection_window',
                10 => 'connection_status'
            ),
            'extrasDestination' => array(
                11 => 'inside_window'
            ),
            'extrasValue'       => array(
                11 => 1
            )
        );
        $aDates = array(
            'start' => new Date('2008-08-21 09:00:00'),
            'end'   => new Date('2008-08-21 09:59:59')
        );

        // Prepare the DAL object
        $oFactory = new OX_Dal_Maintenance_Statistics_Factory();
        $oDalMaintenanceStatistics = $oFactory->factory();

        // Test 1: Test with an incorrect method name in the mapping array
        $savedValue = $aMigrationDetails['method'];
        $aMigrationDetails['method'] = 'foo';
        $result = $oDalMaintenanceStatistics->summariseBucketsRaw($statisticsTableName, $aMigrationDetails, $aDates);
        $this->assertTrue(is_a($result, 'PEAR_Error'));
        $this->assertEqual($result->code, MAX_ERROR_INVALIDARGS);
        $this->assertEqual($result->message, "OX_Dal_Maintenance_Statistics::summariseBucketsRaw() called with migration map method 'foo' != 'raw'.");
        $aMigrationDetails['method'] = $savedValue;

        // Test 2: Test with a different number of source and destination columns
        $savedValue = $aMigrationDetails['destination'][1];
        unset($aMigrationDetails['destination'][1]);
        $result = $oDalMaintenanceStatistics->summariseBucketsRaw($statisticsTableName, $aMigrationDetails, $aDates);
        $this->assertTrue(is_a($result, 'PEAR_Error'));
        $this->assertEqual($result->code, MAX_ERROR_INVALIDARGS);
        $this->assertEqual($result->message, "OX_Dal_Maintenance_Statistics::summariseBucketsRaw() called with different number of 'source' and 'destination' columns.");
        $aMigrationDetails['destination'][1] = $savedValue;

        // Test 3: Test with a different number of extrasDestination and extrasValue columns
        $savedValue = $aMigrationDetails['extrasDestination'][11];
        unset($aMigrationDetails['extrasDestination'][11]);
        $result = $oDalMaintenanceStatistics->summariseBucketsRaw($statisticsTableName, $aMigrationDetails, $aDates);
        $this->assertTrue(is_a($result, 'PEAR_Error'));
        $this->assertEqual($result->code, MAX_ERROR_INVALIDARGS);
        $this->assertEqual($result->message, "OX_Dal_Maintenance_Statistics::summariseBucketsRaw() called with different number of 'extrasDestination' and 'extrasValue' columns.");
        $aMigrationDetails['extrasDestination'][11] = $savedValue;

        // Test 4: Test with date parameters that are not really dates
        $savedValue = $aDates['start'];
        $aDates['start'] = 'foo';
        $result = $oDalMaintenanceStatistics->summariseBucketsRaw($statisticsTableName, $aMigrationDetails, $aDates);
        $this->assertTrue(is_a($result, 'PEAR_Error'));
        $this->assertEqual($result->code, MAX_ERROR_INVALIDARGS);
        $this->assertEqual($result->message, "OX_Dal_Maintenance_Statistics::summariseBucketsRaw() called with invalid start/end date parameters -- not Date objects.");
        $aDates['start'] = $savedValue;

        $savedValue = $aDates['end'];
        $aDates['end'] = 'foo';
        $result = $oDalMaintenanceStatistics->summariseBucketsRaw($statisticsTableName, $aMigrationDetails, $aDates);
        $this->assertTrue(is_a($result, 'PEAR_Error'));
        $this->assertEqual($result->code, MAX_ERROR_INVALIDARGS);
        $this->assertEqual($result->message, "OX_Dal_Maintenance_Statistics::summariseBucketsRaw() called with invalid start/end date parameters -- not Date objects.");
        $aDates['end'] = $savedValue;

        // Test 5: Test with invalid start/end dates
        $savedValue = $aDates['start'];
        $aDates['start'] = new Date('2008-08-21 08:00:00');
        $result = $oDalMaintenanceStatistics->summariseBucketsRaw($statisticsTableName, $aMigrationDetails, $aDates);
        $this->assertTrue(is_a($result, 'PEAR_Error'));
        $this->assertEqual($result->code, MAX_ERROR_INVALIDARGS);
        $this->assertEqual($result->message, "OX_Dal_Maintenance_Statistics::summariseBucketsRaw() called with invalid start/end date parameters -- not operation interval bounds.");
        $aDates['start'] = $savedValue;

        $savedValue = $aDates['end'];
        $aDates['end'] = new Date('2008-08-22 09:59:59');
        $result = $oDalMaintenanceStatistics->summariseBucketsRaw($statisticsTableName, $aMigrationDetails, $aDates);
        $this->assertTrue(is_a($result, 'PEAR_Error'));
        $this->assertEqual($result->code, MAX_ERROR_INVALIDARGS);
        $this->assertEqual($result->message, "OX_Dal_Maintenance_Statistics::summariseBucketsRaw() called with invalid start/end date parameters -- not operation interval bounds.");
        $aDates['end'] = $savedValue;

        // Test 6: Test with an invalid statistics table name
        $savedValue = $statisticsTableName;
        $statisticsTableName = 'foo';
        $result = $oDalMaintenanceStatistics->summariseBucketsRaw($statisticsTableName, $aMigrationDetails, $aDates);
        $this->assertTrue(is_a($result, 'PEAR_Error'));
        $this->assertEqual($result->code, MAX_ERROR_INVALIDREQUEST);
        $this->assertEqual($result->message, "OX_Dal_Maintenance_Statistics::summariseBucketsRaw() called with invalid statistics table 'foo'.");
        $statisticsTableName = $savedValue;

        // Test 7: Test with no data_bkt_a table in the database
        $result = $oDalMaintenanceStatistics->summariseBucketsRaw($statisticsTableName, $aMigrationDetails, $aDates);
        $this->assertTrue(is_a($result, 'PEAR_Error'));
        $this->assertEqual($result->code, MAX_ERROR_INVALIDREQUEST);
        $this->assertEqual($result->message, "OX_Dal_Maintenance_Statistics::summariseBucketsRaw() called with invalid bucket table '{$aConf['table']['prefix']}data_bkt_a'.");

        // Install the openXDeliveryLog plugin, which will create the
        // data_bkt_a table required for testing
        TestEnv::installPluginPackage('openXDeliveryLog', false);

        // Test 8: Test with all tables present, but no data
        $result = $oDalMaintenanceStatistics->summariseBucketsRaw($statisticsTableName, $aMigrationDetails, $aDates);
        $this->assertEqual($result, 0);

        if (PEAR::isError($result)) {
            echo $result->message;
        }

        // Insert some data into the data_bkt_a table in the incorrect
        // operation interval
        $oData_bkt_a = OA_Dal::factoryDO('data_bkt_a');
        $oData_bkt_a->server_conv_id   = 1;
        $oData_bkt_a->server_ip        = 'localhost';
        $oData_bkt_a->tracker_id       = 2;
        $oData_bkt_a->date_time        = '2008-08-21 08:15:00';
        $oData_bkt_a->action_date_time = '2008-08-21 07:15:00';
        $oData_bkt_a->creative_id      = 3;
        $oData_bkt_a->zone_id          = 4;
        $oData_bkt_a->ip_address       = '127.0.0.1';
        $oData_bkt_a->action           = MAX_CONNECTION_AD_CLICK;
        $oData_bkt_a->window           = 3600;
        $oData_bkt_a->status           = MAX_CONNECTION_STATUS_APPROVED;
        $conversionId = DataGenerator::generateOne($oData_bkt_a);

        // Test 9: Test with data in the incorrect operation interval
        $result = $oDalMaintenanceStatistics->summariseBucketsRaw($statisticsTableName, $aMigrationDetails, $aDates);
        $this->assertEqual($result, 0);

        // Insert some data into the data_bkt_a table in the correct
        // operation interval
        $oData_bkt_a = OA_Dal::factoryDO('data_bkt_a');
        $oData_bkt_a->server_conv_id   = 2;
        $oData_bkt_a->server_ip        = 'localhost';
        $oData_bkt_a->tracker_id       = 2;
        $oData_bkt_a->date_time        = '2008-08-21 09:15:00';
        $oData_bkt_a->action_date_time = '2008-08-21 08:15:00';
        $oData_bkt_a->creative_id      = 3;
        $oData_bkt_a->zone_id          = 4;
        $oData_bkt_a->ip_address       = '127.0.0.1';
        $oData_bkt_a->action           = MAX_CONNECTION_AD_CLICK;
        $oData_bkt_a->window           = 3600;
        $oData_bkt_a->status           = MAX_CONNECTION_STATUS_APPROVED;
        $conversionId = DataGenerator::generateOne($oData_bkt_a);

        // Test 10: Test with data in the correct operation interval
        $result = $oDalMaintenanceStatistics->summariseBucketsRaw($statisticsTableName, $aMigrationDetails, $aDates);
        $this->assertEqual($result, 1);

        $oData_intermediate_ad_connection = OA_Dal::factoryDO('data_intermediate_ad_connection');
        $oData_intermediate_ad_connection->find();
        $rows = $oData_intermediate_ad_connection->getRowCount();
        $this->assertEqual($rows, 1);

        $oData_intermediate_ad_connection = OA_Dal::factoryDO('data_intermediate_ad_connection');
        $oData_intermediate_ad_connection->server_raw_tracker_impression_id = 2;
        $oData_intermediate_ad_connection->server_raw_ip                    = 'localhost';
        $oData_intermediate_ad_connection->find();
        $rows = $oData_intermediate_ad_connection->getRowCount();
        $this->assertEqual($rows, 1);
        $oData_intermediate_ad_connection->fetch();
        $this->assertEqual($oData_intermediate_ad_connection->data_intermediate_ad_connection_id, 1);
        $this->assertEqual($oData_intermediate_ad_connection->server_raw_tracker_impression_id,   2);
        $this->assertEqual($oData_intermediate_ad_connection->server_raw_ip,                      'localhost');
        $this->assertEqual($oData_intermediate_ad_connection->tracker_id,                         2);
        $this->assertEqual($oData_intermediate_ad_connection->tracker_date_time,                  '2008-08-21 09:15:00');
        $this->assertEqual($oData_intermediate_ad_connection->connection_date_time,               '2008-08-21 08:15:00');
        $this->assertEqual($oData_intermediate_ad_connection->ad_id,                              3);
        $this->assertEqual($oData_intermediate_ad_connection->zone_id,                            4);
        $this->assertEqual($oData_intermediate_ad_connection->tracker_ip_address,                 '127.0.0.1');
        $this->assertEqual($oData_intermediate_ad_connection->connection_action,                  MAX_CONNECTION_AD_CLICK);
        $this->assertEqual($oData_intermediate_ad_connection->connection_window,                  3600);
        $this->assertEqual($oData_intermediate_ad_connection->connection_status,                  MAX_CONNECTION_STATUS_APPROVED);
        $this->assertEqual($oData_intermediate_ad_connection->inside_window,                      1);

        // Clean up generated data
        DataGenerator::cleanUp();

        // Insert some (new) data into the data_bkt_a table in the
        // correct operation interval
        $oData_bkt_a = OA_Dal::factoryDO('data_bkt_a');
        $oData_bkt_a->server_conv_id   = 3;
        $oData_bkt_a->server_ip        = 'localhost';
        $oData_bkt_a->tracker_id       = 5;
        $oData_bkt_a->date_time        = '2008-08-21 09:30:00';
        $oData_bkt_a->action_date_time = '2008-08-21 08:59:00';
        $oData_bkt_a->creative_id      = 8;
        $oData_bkt_a->zone_id          = 9;
        $oData_bkt_a->ip_address       = '127.0.0.1';
        $oData_bkt_a->action           = MAX_CONNECTION_AD_IMPRESSION;
        $oData_bkt_a->window           = 1920;
        $oData_bkt_a->status           = MAX_CONNECTION_STATUS_PENDING;
        $conversionId = DataGenerator::generateOne($oData_bkt_a);

        // Test 11: Test again with data in the correct operation interval
        $result = $oDalMaintenanceStatistics->summariseBucketsRaw($statisticsTableName, $aMigrationDetails, $aDates);
        $this->assertEqual($result, 1);

        $oData_intermediate_ad_connection = OA_Dal::factoryDO('data_intermediate_ad_connection');
        $oData_intermediate_ad_connection->find();
        $rows = $oData_intermediate_ad_connection->getRowCount();
        $this->assertEqual($rows, 2);

        $oData_intermediate_ad_connection = OA_Dal::factoryDO('data_intermediate_ad_connection');
        $oData_intermediate_ad_connection->server_raw_tracker_impression_id = 2;
        $oData_intermediate_ad_connection->server_raw_ip                    = 'localhost';
        $oData_intermediate_ad_connection->find();
        $rows = $oData_intermediate_ad_connection->getRowCount();
        $this->assertEqual($rows, 1);
        $oData_intermediate_ad_connection->fetch();
        $this->assertEqual($oData_intermediate_ad_connection->data_intermediate_ad_connection_id, 1);
        $this->assertEqual($oData_intermediate_ad_connection->server_raw_tracker_impression_id,   2);
        $this->assertEqual($oData_intermediate_ad_connection->server_raw_ip,                      'localhost');
        $this->assertEqual($oData_intermediate_ad_connection->tracker_id,                         2);
        $this->assertEqual($oData_intermediate_ad_connection->tracker_date_time,                  '2008-08-21 09:15:00');
        $this->assertEqual($oData_intermediate_ad_connection->connection_date_time,               '2008-08-21 08:15:00');
        $this->assertEqual($oData_intermediate_ad_connection->ad_id,                              3);
        $this->assertEqual($oData_intermediate_ad_connection->zone_id,                            4);
        $this->assertEqual($oData_intermediate_ad_connection->tracker_ip_address,                 '127.0.0.1');
        $this->assertEqual($oData_intermediate_ad_connection->connection_action,                  MAX_CONNECTION_AD_CLICK);
        $this->assertEqual($oData_intermediate_ad_connection->connection_window,                  3600);
        $this->assertEqual($oData_intermediate_ad_connection->connection_status,                  MAX_CONNECTION_STATUS_APPROVED);
        $this->assertEqual($oData_intermediate_ad_connection->inside_window,                      1);

        $oData_intermediate_ad_connection = OA_Dal::factoryDO('data_intermediate_ad_connection');
        $oData_intermediate_ad_connection->server_raw_tracker_impression_id = 3;
        $oData_intermediate_ad_connection->server_raw_ip                    = 'localhost';
        $oData_intermediate_ad_connection->find();
        $rows = $oData_intermediate_ad_connection->getRowCount();
        $this->assertEqual($rows, 1);
        $oData_intermediate_ad_connection->fetch();
        $this->assertEqual($oData_intermediate_ad_connection->data_intermediate_ad_connection_id, 2);
        $this->assertEqual($oData_intermediate_ad_connection->server_raw_tracker_impression_id,   3);
        $this->assertEqual($oData_intermediate_ad_connection->server_raw_ip,                      'localhost');
        $this->assertEqual($oData_intermediate_ad_connection->tracker_id,                         5);
        $this->assertEqual($oData_intermediate_ad_connection->tracker_date_time,                  '2008-08-21 09:30:00');
        $this->assertEqual($oData_intermediate_ad_connection->connection_date_time,               '2008-08-21 08:59:00');
        $this->assertEqual($oData_intermediate_ad_connection->ad_id,                              8);
        $this->assertEqual($oData_intermediate_ad_connection->zone_id,                            9);
        $this->assertEqual($oData_intermediate_ad_connection->tracker_ip_address,                 '127.0.0.1');
        $this->assertEqual($oData_intermediate_ad_connection->connection_action,                  MAX_CONNECTION_AD_IMPRESSION);
        $this->assertEqual($oData_intermediate_ad_connection->connection_window,                  1920);
        $this->assertEqual($oData_intermediate_ad_connection->connection_status,                  MAX_CONNECTION_STATUS_PENDING);
        $this->assertEqual($oData_intermediate_ad_connection->inside_window,                      1);

        // Clean up generated data
        DataGenerator::cleanUp();

        // Also clean up the data migrated into the statistics table
        $oData_intermediate_ad_connection = OA_Dal::factoryDO('data_intermediate_ad_connection');
        $oData_intermediate_ad_connection->server_raw_tracker_impression_id = 2;
        $oData_intermediate_ad_connection->find();
        $oData_intermediate_ad_connection->delete();

        $oData_intermediate_ad_connection = OA_Dal::factoryDO('data_intermediate_ad_connection');
        $oData_intermediate_ad_connection->server_raw_tracker_impression_id = 3;
        $oData_intermediate_ad_connection->find();
        $oData_intermediate_ad_connection->delete();

        // Uninstall the installed plugin
        TestEnv::uninstallPluginPackage('openXDeliveryLog', false);

        // Restore the test environment configuration
        TestEnv::restoreConfig();
    }

}

?>