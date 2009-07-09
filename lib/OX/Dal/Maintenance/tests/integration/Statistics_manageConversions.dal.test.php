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
 * A class for testing the manageConversions() method of the
 * DB agnostic OX_Dal_Maintenance_Statistics class.
 *
 * @package    OpenXDal
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew.hill@openx.org>
 */
class Test_OX_Dal_Maintenance_Statistics_manageConversions extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function Test_OX_Dal_Maintenance_Statistics_manageConversions()
    {
        $this->UnitTestCase();
    }

    /**
     * The method to test the manageConversions() method.
     */
    function testManageConversions()
    {
        // Test 0: Test that there is no data in the data_intermediate_ad table
        $doData_intermediate_ad = OA_Dal::factoryDO('data_intermediate_ad');
        $doData_intermediate_ad->find();
        $rows = $doData_intermediate_ad->getRowCount();
        $this->assertEqual($rows, 0);

        // Insert a variable tracker with no special purpose
        // Hacks the DB_DataObject so that the DataGenerator will not override
        // the NULL value that should be inserted into the database with an
        // auto generated value...
        $doVariables = OA_Dal::factoryDO('variables');
        $doVariables->defaultValues['purpose'] = OX_DATAOBJECT_NULL;
        $variableId1 = DataGenerator::generateOne($doVariables);

        // Insert a basket value variable tracker
        $doVariables = OA_Dal::factoryDO('variables');
        $doVariables->purpose = 'basket_value';
        $variableId2 = DataGenerator::generateOne($doVariables);

        // Insert a number of items variable tracker
        $doVariables = OA_Dal::factoryDO('variables');
        $doVariables->purpose = 'num_items';
        $variableId3 = DataGenerator::generateOne($doVariables);

        // Test 1: Test with no data
        $aConf =& $GLOBALS['_MAX']['CONF'];
        $oDbh =& OA_DB::singleton();

        $oFactory = new OX_Dal_Maintenance_Statistics_Factory();
        $oDalMaintenanceStatistics = $oFactory->factory();

        // Test 1
        $oStart = new Date('2004-06-06 12:00:00');
        $oEnd   = new Date('2004-06-06 12:59:59');
        $oDalMaintenanceStatistics->manageConversions($oStart, $oEnd);

        $doData_intermediate_ad = OA_Dal::factoryDO('data_intermediate_ad');
        $doData_intermediate_ad->find();
        $rows = $doData_intermediate_ad->getRowCount();
        $this->assertEqual($rows, 0);

        // Test 2: Test with data that is outside the range to manage
        $doData_intermediate_ad_connection = OA_Dal::factoryDO('data_intermediate_ad_connection');
        $doData_intermediate_ad_connection->server_raw_tracker_impression_id = 1;
        $doData_intermediate_ad_connection->server_raw_ip                    = 'singleDB';
        $doData_intermediate_ad_connection->tracker_date_time                = '2004-06-06 11:10:00';
        $doData_intermediate_ad_connection->connection_date_time             = '2004-06-06 11:05:00';
        $doData_intermediate_ad_connection->tracker_id                       = 500;
        $doData_intermediate_ad_connection->ad_id                            = 600;
        $doData_intermediate_ad_connection->zone_id                          = 100;
        $doData_intermediate_ad_connection->tracker_ip_address               = '127.0.0.1';
        $doData_intermediate_ad_connection->connection_action                = MAX_CONNECTION_AD_CLICK;
        $doData_intermediate_ad_connection->connection_window                = 3600;
        $doData_intermediate_ad_connection->connection_status                = MAX_CONNECTION_STATUS_APPROVED;
        $doData_intermediate_ad_connection->inside_window                    = 1;
        $connectionId1 = DataGenerator::generateOne($doData_intermediate_ad_connection);

        $doData_intermediate_ad_variable_value = OA_Dal::factoryDO('data_intermediate_ad_variable_value');
        $doData_intermediate_ad_variable_value->data_intermediate_ad_connection_id = $connectionId1;
        $doData_intermediate_ad_variable_value->tracker_variable_id                = $variableId1;
        $doData_intermediate_ad_variable_value->value                              = '12345';
        DataGenerator::generateOne($doData_intermediate_ad_variable_value);

        $oStart = new Date('2004-06-06 12:00:00');
        $oEnd   = new Date('2004-06-06 12:59:59');
        $oDalMaintenanceStatistics->manageConversions($oStart, $oEnd);

        $doData_intermediate_ad = OA_Dal::factoryDO('data_intermediate_ad');
        $doData_intermediate_ad->find();
        $rows = $doData_intermediate_ad->getRowCount();
        $this->assertEqual($rows, 0);

        // Test 3: Test with data that is inside the range to manage,
        //         but with no corresponding data_intermediate_ad rows
        $doData_intermediate_ad_connection = OA_Dal::factoryDO('data_intermediate_ad_connection');
        $doData_intermediate_ad_connection->server_raw_tracker_impression_id = 2;
        $doData_intermediate_ad_connection->server_raw_ip                    = 'singleDB';
        $doData_intermediate_ad_connection->tracker_date_time                = '2004-06-06 12:10:00';
        $doData_intermediate_ad_connection->connection_date_time             = '2004-06-06 12:05:00';
        $doData_intermediate_ad_connection->tracker_id                       = 500;
        $doData_intermediate_ad_connection->ad_id                            = 600;
        $doData_intermediate_ad_connection->zone_id                          = 100;
        $doData_intermediate_ad_connection->tracker_ip_address               = '127.0.0.1';
        $doData_intermediate_ad_connection->connection_action                = MAX_CONNECTION_AD_CLICK;
        $doData_intermediate_ad_connection->connection_window                = 3600;
        $doData_intermediate_ad_connection->connection_status                = MAX_CONNECTION_STATUS_APPROVED;
        $doData_intermediate_ad_connection->inside_window                    = 1;
        $connectionId2 = DataGenerator::generateOne($doData_intermediate_ad_connection);

        $doData_intermediate_ad_connection = OA_Dal::factoryDO('data_intermediate_ad_connection');
        $doData_intermediate_ad_connection->server_raw_tracker_impression_id = 3;
        $doData_intermediate_ad_connection->server_raw_ip                    = 'singleDB';
        $doData_intermediate_ad_connection->tracker_date_time                = '2004-06-06 12:15:00';
        $doData_intermediate_ad_connection->connection_date_time             = '2004-06-06 12:10:00';
        $doData_intermediate_ad_connection->tracker_id                       = 500;
        $doData_intermediate_ad_connection->ad_id                            = 600;
        $doData_intermediate_ad_connection->zone_id                          = 100;
        $doData_intermediate_ad_connection->tracker_ip_address               = '127.0.0.1';
        $doData_intermediate_ad_connection->connection_action                = MAX_CONNECTION_AD_CLICK;
        $doData_intermediate_ad_connection->connection_window                = 3600;
        $doData_intermediate_ad_connection->connection_status                = MAX_CONNECTION_STATUS_APPROVED;
        $doData_intermediate_ad_connection->inside_window                    = 1;
        $connectionId3 = DataGenerator::generateOne($doData_intermediate_ad_connection);

        $doData_intermediate_ad_variable_value = OA_Dal::factoryDO('data_intermediate_ad_variable_value');
        $doData_intermediate_ad_variable_value->data_intermediate_ad_connection_id = $connectionId3;
        $doData_intermediate_ad_variable_value->tracker_variable_id                = $variableId1;
        $doData_intermediate_ad_variable_value->value                              = 'foo';
        DataGenerator::generateOne($doData_intermediate_ad_variable_value);

        $doData_intermediate_ad_connection = OA_Dal::factoryDO('data_intermediate_ad_connection');
        $doData_intermediate_ad_connection->server_raw_tracker_impression_id = 4;
        $doData_intermediate_ad_connection->server_raw_ip                    = 'singleDB';
        $doData_intermediate_ad_connection->tracker_date_time                = '2004-06-06 12:15:00';
        $doData_intermediate_ad_connection->connection_date_time             = '2004-06-06 12:10:00';
        $doData_intermediate_ad_connection->tracker_id                       = 500;
        $doData_intermediate_ad_connection->ad_id                            = 600;
        $doData_intermediate_ad_connection->zone_id                          = 100;
        $doData_intermediate_ad_connection->tracker_ip_address               = '127.0.0.1';
        $doData_intermediate_ad_connection->connection_action                = MAX_CONNECTION_AD_CLICK;
        $doData_intermediate_ad_connection->connection_window                = 3600;
        $doData_intermediate_ad_connection->connection_status                = MAX_CONNECTION_STATUS_APPROVED;
        $doData_intermediate_ad_connection->inside_window                    = 1;
        $connectionId4 = DataGenerator::generateOne($doData_intermediate_ad_connection);

        $doData_intermediate_ad_variable_value = OA_Dal::factoryDO('data_intermediate_ad_variable_value');
        $doData_intermediate_ad_variable_value->data_intermediate_ad_connection_id = $connectionId4;
        $doData_intermediate_ad_variable_value->tracker_variable_id                = $variableId2;
        $doData_intermediate_ad_variable_value->value                              = '15.67';
        DataGenerator::generateOne($doData_intermediate_ad_variable_value);

        $doData_intermediate_ad_connection = OA_Dal::factoryDO('data_intermediate_ad_connection');
        $doData_intermediate_ad_connection->server_raw_tracker_impression_id = 5;
        $doData_intermediate_ad_connection->server_raw_ip                    = 'singleDB';
        $doData_intermediate_ad_connection->tracker_date_time                = '2004-06-06 12:15:00';
        $doData_intermediate_ad_connection->connection_date_time             = '2004-06-06 12:10:00';
        $doData_intermediate_ad_connection->tracker_id                       = 501;
        $doData_intermediate_ad_connection->ad_id                            = 601;
        $doData_intermediate_ad_connection->zone_id                          = 101;
        $doData_intermediate_ad_connection->tracker_ip_address               = '127.0.0.1';
        $doData_intermediate_ad_connection->connection_action                = MAX_CONNECTION_AD_CLICK;
        $doData_intermediate_ad_connection->connection_window                = 3600;
        $doData_intermediate_ad_connection->connection_status                = MAX_CONNECTION_STATUS_APPROVED;
        $doData_intermediate_ad_connection->inside_window                    = 1;
        $connectionId5 = DataGenerator::generateOne($doData_intermediate_ad_connection);

        $doData_intermediate_ad_variable_value = OA_Dal::factoryDO('data_intermediate_ad_variable_value');
        $doData_intermediate_ad_variable_value->data_intermediate_ad_connection_id = $connectionId5;
        $doData_intermediate_ad_variable_value->tracker_variable_id                = $variableId3;
        $doData_intermediate_ad_variable_value->value                              = '37';
        DataGenerator::generateOne($doData_intermediate_ad_variable_value);

        $doData_intermediate_ad_connection = OA_Dal::factoryDO('data_intermediate_ad_connection');
        $doData_intermediate_ad_connection->server_raw_tracker_impression_id = 6;
        $doData_intermediate_ad_connection->server_raw_ip                    = 'singleDB';
        $doData_intermediate_ad_connection->tracker_date_time                = '2004-06-06 12:15:00';
        $doData_intermediate_ad_connection->connection_date_time             = '2004-06-06 12:10:00';
        $doData_intermediate_ad_connection->tracker_id                       = 500;
        $doData_intermediate_ad_connection->ad_id                            = 600;
        $doData_intermediate_ad_connection->zone_id                          = 100;
        $doData_intermediate_ad_connection->tracker_ip_address               = '127.0.0.1';
        $doData_intermediate_ad_connection->connection_action                = MAX_CONNECTION_AD_CLICK;
        $doData_intermediate_ad_connection->connection_window                = 3600;
        $doData_intermediate_ad_connection->connection_status                = MAX_CONNECTION_STATUS_APPROVED;
        $doData_intermediate_ad_connection->inside_window                    = 1;
        $connectionId6 = DataGenerator::generateOne($doData_intermediate_ad_connection);

        $doData_intermediate_ad_variable_value = OA_Dal::factoryDO('data_intermediate_ad_variable_value');
        $doData_intermediate_ad_variable_value->data_intermediate_ad_connection_id = $connectionId6;
        $doData_intermediate_ad_variable_value->tracker_variable_id                = $variableId2;
        $doData_intermediate_ad_variable_value->value                              = '20';
        DataGenerator::generateOne($doData_intermediate_ad_variable_value);

        $doData_intermediate_ad_variable_value = OA_Dal::factoryDO('data_intermediate_ad_variable_value');
        $doData_intermediate_ad_variable_value->data_intermediate_ad_connection_id = $connectionId6;
        $doData_intermediate_ad_variable_value->tracker_variable_id                = $variableId3;
        $doData_intermediate_ad_variable_value->value                              = '3';
        DataGenerator::generateOne($doData_intermediate_ad_variable_value);

        $oStart = new Date('2004-06-06 12:00:00');
        $oEnd   = new Date('2004-06-06 12:59:59');
        $oDalMaintenanceStatistics->manageConversions($oStart, $oEnd);

        $doData_intermediate_ad = OA_Dal::factoryDO('data_intermediate_ad');
        $doData_intermediate_ad->find();
        $rows = $doData_intermediate_ad->getRowCount();
        $this->assertEqual($rows, 2);

        $doData_intermediate_ad = OA_Dal::factoryDO('data_intermediate_ad');
        $doData_intermediate_ad->ad_id = 600;
        $doData_intermediate_ad->find();
        $rows = $doData_intermediate_ad->getRowCount();
        $this->assertEqual($rows, 1);
        $doData_intermediate_ad->fetch();
        $this->assertEqual($doData_intermediate_ad->date_time,             '2004-06-06 12:00:00');
        $this->assertEqual($doData_intermediate_ad->operation_interval,    60);
        $this->assertEqual($doData_intermediate_ad->operation_interval_id, 12);
        $this->assertEqual($doData_intermediate_ad->interval_start,        '2004-06-06 12:00:00');
        $this->assertEqual($doData_intermediate_ad->interval_end,          '2004-06-06 12:59:59');
        $this->assertEqual($doData_intermediate_ad->ad_id,                 600);
        $this->assertEqual($doData_intermediate_ad->zone_id,               100);
        $this->assertEqual($doData_intermediate_ad->requests,              0);
        $this->assertEqual($doData_intermediate_ad->impressions,           0);
        $this->assertEqual($doData_intermediate_ad->clicks,                0);
        $this->assertEqual($doData_intermediate_ad->conversions,           4);
        $this->assertEqual($doData_intermediate_ad->total_basket_value,    35.67);
        $this->assertEqual($doData_intermediate_ad->total_num_items,       3);

        $doData_intermediate_ad = OA_Dal::factoryDO('data_intermediate_ad');
        $doData_intermediate_ad->ad_id = 601;
        $doData_intermediate_ad->find();
        $rows = $doData_intermediate_ad->getRowCount();
        $this->assertEqual($rows, 1);
        $doData_intermediate_ad->fetch();
        $this->assertEqual($doData_intermediate_ad->date_time,             '2004-06-06 12:00:00');
        $this->assertEqual($doData_intermediate_ad->operation_interval,    60);
        $this->assertEqual($doData_intermediate_ad->operation_interval_id, 12);
        $this->assertEqual($doData_intermediate_ad->interval_start,        '2004-06-06 12:00:00');
        $this->assertEqual($doData_intermediate_ad->interval_end,          '2004-06-06 12:59:59');
        $this->assertEqual($doData_intermediate_ad->ad_id,                 601);
        $this->assertEqual($doData_intermediate_ad->zone_id,               101);
        $this->assertEqual($doData_intermediate_ad->requests,              0);
        $this->assertEqual($doData_intermediate_ad->impressions,           0);
        $this->assertEqual($doData_intermediate_ad->clicks,                0);
        $this->assertEqual($doData_intermediate_ad->conversions,           1);
        $this->assertEqual($doData_intermediate_ad->total_basket_value,    0);
        $this->assertEqual($doData_intermediate_ad->total_num_items,       37);

        // Clean Up
        DataGenerator::cleanUp();

        // Re-insert a number of items variable tracker
        $doVariables = OA_Dal::factoryDO('variables');
        $doVariables->purpose = 'num_items';
        $variableId4 = DataGenerator::generateOne($doVariables);

        // Test 4: Test with data that is inside the range to manage,
        //         with corresponding data_intermediate_ad rows

        $doData_intermediate_ad_connection = OA_Dal::factoryDO('data_intermediate_ad_connection');
        $doData_intermediate_ad_connection->server_raw_tracker_impression_id = 7;
        $doData_intermediate_ad_connection->server_raw_ip                    = 'singleDB';
        $doData_intermediate_ad_connection->tracker_date_time                = '2004-06-06 12:15:00';
        $doData_intermediate_ad_connection->connection_date_time             = '2004-06-06 12:10:00';
        $doData_intermediate_ad_connection->tracker_id                       = 501;
        $doData_intermediate_ad_connection->ad_id                            = 601;
        $doData_intermediate_ad_connection->zone_id                          = 101;
        $doData_intermediate_ad_connection->tracker_ip_address               = '127.0.0.1';
        $doData_intermediate_ad_connection->connection_action                = MAX_CONNECTION_AD_CLICK;
        $doData_intermediate_ad_connection->connection_window                = 3600;
        $doData_intermediate_ad_connection->connection_status                = MAX_CONNECTION_STATUS_APPROVED;
        $doData_intermediate_ad_connection->inside_window                    = 1;
        $connectionId7 = DataGenerator::generateOne($doData_intermediate_ad_connection);

        $doData_intermediate_ad_variable_value = OA_Dal::factoryDO('data_intermediate_ad_variable_value');
        $doData_intermediate_ad_variable_value->data_intermediate_ad_connection_id = $connectionId7;
        $doData_intermediate_ad_variable_value->tracker_variable_id                = $variableId4;
        $doData_intermediate_ad_variable_value->value                              = '3';
        DataGenerator::generateOne($doData_intermediate_ad_variable_value);

        $oStart = new Date('2004-06-06 12:00:00');
        $oEnd   = new Date('2004-06-06 12:59:59');
        $oDalMaintenanceStatistics->manageConversions($oStart, $oEnd);

        $doData_intermediate_ad = OA_Dal::factoryDO('data_intermediate_ad');
        $doData_intermediate_ad->find();
        $rows = $doData_intermediate_ad->getRowCount();
        $this->assertEqual($rows, 2);

        $doData_intermediate_ad = OA_Dal::factoryDO('data_intermediate_ad');
        $doData_intermediate_ad->ad_id = 600;
        $doData_intermediate_ad->find();
        $rows = $doData_intermediate_ad->getRowCount();
        $this->assertEqual($rows, 1);
        $doData_intermediate_ad->fetch();
        $this->assertEqual($doData_intermediate_ad->date_time,             '2004-06-06 12:00:00');
        $this->assertEqual($doData_intermediate_ad->operation_interval,    60);
        $this->assertEqual($doData_intermediate_ad->operation_interval_id, 12);
        $this->assertEqual($doData_intermediate_ad->interval_start,        '2004-06-06 12:00:00');
        $this->assertEqual($doData_intermediate_ad->interval_end,          '2004-06-06 12:59:59');
        $this->assertEqual($doData_intermediate_ad->ad_id,                 600);
        $this->assertEqual($doData_intermediate_ad->zone_id,               100);
        $this->assertEqual($doData_intermediate_ad->requests,              0);
        $this->assertEqual($doData_intermediate_ad->impressions,           0);
        $this->assertEqual($doData_intermediate_ad->clicks,                0);
        $this->assertEqual($doData_intermediate_ad->conversions,           4);
        $this->assertEqual($doData_intermediate_ad->total_basket_value,    35.67);
        $this->assertEqual($doData_intermediate_ad->total_num_items,       3);

        $doData_intermediate_ad = OA_Dal::factoryDO('data_intermediate_ad');
        $doData_intermediate_ad->ad_id = 601;
        $doData_intermediate_ad->find();
        $rows = $doData_intermediate_ad->getRowCount();
        $this->assertEqual($rows, 1);
        $doData_intermediate_ad->fetch();
        $this->assertEqual($doData_intermediate_ad->date_time,             '2004-06-06 12:00:00');
        $this->assertEqual($doData_intermediate_ad->operation_interval,    60);
        $this->assertEqual($doData_intermediate_ad->operation_interval_id, 12);
        $this->assertEqual($doData_intermediate_ad->interval_start,        '2004-06-06 12:00:00');
        $this->assertEqual($doData_intermediate_ad->interval_end,          '2004-06-06 12:59:59');
        $this->assertEqual($doData_intermediate_ad->ad_id,                 601);
        $this->assertEqual($doData_intermediate_ad->zone_id,               101);
        $this->assertEqual($doData_intermediate_ad->requests,              0);
        $this->assertEqual($doData_intermediate_ad->impressions,           0);
        $this->assertEqual($doData_intermediate_ad->clicks,                0);
        $this->assertEqual($doData_intermediate_ad->conversions,           2);
        $this->assertEqual($doData_intermediate_ad->total_basket_value,    0);
        $this->assertEqual($doData_intermediate_ad->total_num_items,       40);

        // Clean Up
        DataGenerator::cleanUp();

    }

}

?>