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

require_once LIB_PATH . '/Maintenance/Statistics.php';
require_once MAX_PATH . '/lib/OA/Dal/DataGenerator.php';

/**
 * A class for performing a full end-to-end integration test on the maintenace
 * statistics engine, with the standard OpenX delivery logging plugins.
 *
 * @package    OpenXMaintenance
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew.hill@openx.org>
 */
class Test_OX_Maintenance_Statistics extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function Test_OX_Maintenance_Statistics()
    {
        $this->UnitTestCase();
    }

    /**
     * The complete end-to-end integration test for 60 minute operation intervals.
     */
    function testHourly()
    {
        $aConf =& $GLOBALS['_MAX']['CONF'];
        $aConf['maintenance']['operationInterval'] = 60;
        $aConf['log']['priority'] = 'PEAR_LOG_DEBUG';

        // Setup the default OpenX delivery logging plugin for the next test
        TestEnv::installPluginPackage('openXDeliveryLog', false);

        /**********************************************************************/

        // Test to ensure there are no entries in any of the system tables yet

        $doUserlog = OA_Dal::factoryDO('userlog');
        $doUserlog->find();
        $this->assertEqual($doUserlog->getRowCount(), 0);

        $doLog_maintenance_statistics = OA_Dal::factoryDO('log_maintenance_statistics');
        $doLog_maintenance_statistics->find();
        $this->assertEqual($doLog_maintenance_statistics->getRowCount(), 0);

        $doData_intermediate_ad_connection = OA_Dal::factoryDO('data_intermediate_ad_connection');
        $doData_intermediate_ad_connection->find();
        $this->assertEqual($doData_intermediate_ad_connection->getRowCount(), 0);

        $doData_intermediate_ad_variable_value = OA_Dal::factoryDO('data_intermediate_ad_variable_value');
        $doData_intermediate_ad_variable_value->find();
        $this->assertEqual($doData_intermediate_ad_variable_value->getRowCount(), 0);

        $doData_intermediate_ad = OA_Dal::factoryDO('data_intermediate_ad');
        $doData_intermediate_ad->find();
        $this->assertEqual($doData_intermediate_ad->getRowCount(), 0);

        $doData_summary_ad_hourly = OA_Dal::factoryDO('data_summary_ad_hourly');
        $doData_summary_ad_hourly->find();
        $this->assertEqual($doData_summary_ad_hourly->getRowCount(), 0);

        $doData_summary_zone_impression_history = OA_Dal::factoryDO('data_summary_zone_impression_history');
        $doData_summary_zone_impression_history->find();
        $this->assertEqual($doData_summary_zone_impression_history->getRowCount(), 0);

        $doData_bkt_r = OA_Dal::factoryDO('data_bkt_r');
        $doData_bkt_r->find();
        $this->assertEqual($doData_bkt_r->getRowCount(), 0);

        $doData_bkt_r = OA_Dal::factoryDO('data_bkt_m');
        $doData_bkt_r->find();
        $this->assertEqual($doData_bkt_r->getRowCount(), 0);

        $doData_bkt_r = OA_Dal::factoryDO('data_bkt_c');
        $doData_bkt_r->find();
        $this->assertEqual($doData_bkt_r->getRowCount(), 0);

        $doData_bkt_r = OA_Dal::factoryDO('data_bkt_a');
        $doData_bkt_r->find();
        $this->assertEqual($doData_bkt_r->getRowCount(), 0);

        $doData_bkt_r = OA_Dal::factoryDO('data_bkt_a_var');
        $doData_bkt_r->find();
        $this->assertEqual($doData_bkt_r->getRowCount(), 0);

        /**********************************************************************/

        // Prepare the current date/time for testing
        $oNowDate = new Date('2008-08-28 15:01:00');
        $oServiceLocator =& OA_ServiceLocator::instance();
        $oServiceLocator->register('now', $oNowDate);

        // Test 1: Run the MSE process with NO DATA
        $oMaintenanceStatisitcs = new OX_Maintenance_Statistics();
        $oMaintenanceStatisitcs->run();

        /**********************************************************************/

        // Test to ensure there are STILL no entries in any of the system tables

        $doUserlog = OA_Dal::factoryDO('userlog');
        $doUserlog->find();
        $this->assertEqual($doUserlog->getRowCount(), 0);

        $doLog_maintenance_statistics = OA_Dal::factoryDO('log_maintenance_statistics');
        $doLog_maintenance_statistics->find();
        $this->assertEqual($doLog_maintenance_statistics->getRowCount(), 0);

        $doData_intermediate_ad_connection = OA_Dal::factoryDO('data_intermediate_ad_connection');
        $doData_intermediate_ad_connection->find();
        $this->assertEqual($doData_intermediate_ad_connection->getRowCount(), 0);

        $doData_intermediate_ad_variable_value = OA_Dal::factoryDO('data_intermediate_ad_variable_value');
        $doData_intermediate_ad_variable_value->find();
        $this->assertEqual($doData_intermediate_ad_variable_value->getRowCount(), 0);

        $doData_intermediate_ad = OA_Dal::factoryDO('data_intermediate_ad');
        $doData_intermediate_ad->find();
        $this->assertEqual($doData_intermediate_ad->getRowCount(), 0);

        $doData_summary_ad_hourly = OA_Dal::factoryDO('data_summary_ad_hourly');
        $doData_summary_ad_hourly->find();
        $this->assertEqual($doData_summary_ad_hourly->getRowCount(), 0);

        $doData_summary_zone_impression_history = OA_Dal::factoryDO('data_summary_zone_impression_history');
        $doData_summary_zone_impression_history->find();
        $this->assertEqual($doData_summary_zone_impression_history->getRowCount(), 0);

        $doData_bkt_r = OA_Dal::factoryDO('data_bkt_r');
        $doData_bkt_r->find();
        $this->assertEqual($doData_bkt_r->getRowCount(), 0);

        $doData_bkt_r = OA_Dal::factoryDO('data_bkt_m');
        $doData_bkt_r->find();
        $this->assertEqual($doData_bkt_r->getRowCount(), 0);

        $doData_bkt_r = OA_Dal::factoryDO('data_bkt_c');
        $doData_bkt_r->find();
        $this->assertEqual($doData_bkt_r->getRowCount(), 0);

        $doData_bkt_r = OA_Dal::factoryDO('data_bkt_a');
        $doData_bkt_r->find();
        $this->assertEqual($doData_bkt_r->getRowCount(), 0);

        $doData_bkt_r = OA_Dal::factoryDO('data_bkt_a_var');
        $doData_bkt_r->find();
        $this->assertEqual($doData_bkt_r->getRowCount(), 0);

        /**********************************************************************/

        // Generate some tracker variables:
        //
        // - Tracker ID 1: Tracks no variables
        // - Tracker ID 2: Tracks a standard variable value
        // - Tracker ID 3: Tracks a de-duplicating variable value
        // - Tracker ID 4: Tracks a reject if empty variable value
        // - Tracker ID 5: Tracks a basket variable value and a number of
        //                 items variable value

        $doVariables = OA_Dal::factoryDO('variables');
        $doVariables->trackerid       = 2;
        $doVariables->name            = 'Normal Variable';
        $doVariables->insert();

        $doVariables = OA_Dal::factoryDO('variables');
        $doVariables->trackerid       = 3;
        $doVariables->name            = 'De-Duplicate Variable';
        $doVariables->is_unique       = 1;
        $doVariables->unique_window   = 86400; // One day
        $doVariables->insert();

        $doVariables = OA_Dal::factoryDO('variables');
        $doVariables->trackerid       = 4;
        $doVariables->name            = 'Reject if Empty Variable';
        $doVariables->reject_if_empty = 1;
        $doVariables->insert();

        $doVariables = OA_Dal::factoryDO('variables');
        $doVariables->trackerid       = 5;
        $doVariables->name            = 'Basket Value Variable';
        $doVariables->purpose         = 'basket_value';
        $doVariables->insert();

        $doVariables = OA_Dal::factoryDO('variables');
        $doVariables->trackerid       = 5;
        $doVariables->name            = 'Number of Items Variable';
        $doVariables->purpose         = 'num_items';
        $doVariables->insert();

        /**********************************************************************/

        // Generate some resonably standard request, impression, click and
        // conversion data:
        //
        // - For Creative ID 1, Zone ID 1:
        //     - 1000 R,  999 M, 5 C in the 14:00:00 - 15:00:00 interval
        //     - 1100 R, 1099 M, 8 C in the 15:00:00 - 16:00:00 interval
        //     - 7 Conversions in the 15:00 - 16:00 interval:
        //       - One normal, regular conversion, no variables
        //       - One normal, regular conversion, normal tracked variable
        //       - Two conversions duplicated on an "Order ID" variable
        //       - One conversion with a non-empty blocking variable
        //       - One conversion with an empty blocking variable
        //       - Two conversions with a basket value variable and a
        //         number of items variable

        $doData_bkt_r = OA_Dal::factoryDO('data_bkt_r');
        $doData_bkt_r->interval_start = '2008-08-28 14:00:00';
        $doData_bkt_r->creative_id    = 1;
        $doData_bkt_r->zone_id        = 1;
        $doData_bkt_r->count          = 1000;
        $doData_bkt_r->insert();

        $doData_bkt_m = OA_Dal::factoryDO('data_bkt_m');
        $doData_bkt_m->interval_start = '2008-08-28 14:00:00';
        $doData_bkt_m->creative_id    = 1;
        $doData_bkt_m->zone_id        = 1;
        $doData_bkt_m->count          = 999;
        $doData_bkt_m->insert();

        $doData_bkt_c = OA_Dal::factoryDO('data_bkt_c');
        $doData_bkt_c->interval_start = '2008-08-28 14:00:00';
        $doData_bkt_c->creative_id    = 1;
        $doData_bkt_c->zone_id        = 1;
        $doData_bkt_c->count          = 5;
        $doData_bkt_c->insert();

        $doData_bkt_r = OA_Dal::factoryDO('data_bkt_r');
        $doData_bkt_r->interval_start = '2008-08-28 15:00:00';
        $doData_bkt_r->creative_id    = 1;
        $doData_bkt_r->zone_id        = 1;
        $doData_bkt_r->count          = 1100;
        $doData_bkt_r->insert();

        $doData_bkt_m = OA_Dal::factoryDO('data_bkt_m');
        $doData_bkt_m->interval_start = '2008-08-28 15:00:00';
        $doData_bkt_m->creative_id    = 1;
        $doData_bkt_m->zone_id        = 1;
        $doData_bkt_m->count          = 1099;
        $doData_bkt_m->insert();

        $doData_bkt_c = OA_Dal::factoryDO('data_bkt_c');
        $doData_bkt_c->interval_start = '2008-08-28 15:00:00';
        $doData_bkt_c->creative_id    = 1;
        $doData_bkt_c->zone_id        = 1;
        $doData_bkt_c->count          = 8;
        $doData_bkt_c->insert();

        // The "normal" conversion, no variables
        $doData_bkt_a = OA_Dal::factoryDO('data_bkt_a');
        $doData_bkt_a->server_conv_id   = 1;
        $doData_bkt_a->server_ip        = 'localhost';
        $doData_bkt_a->tracker_id       = 1;
        $doData_bkt_a->date_time        = '2008-08-28 15:37:28';
        $doData_bkt_a->action_date_time = '2008-08-28 14:37:28';
        $doData_bkt_a->creative_id      = 1;
        $doData_bkt_a->zone_id          = 1;
        $doData_bkt_a->ip_address       = '127.0.0.1';
        $doData_bkt_a->action           = MAX_CONNECTION_AD_CLICK;
        $doData_bkt_a->window           = 3600;
        $doData_bkt_a->status           = MAX_CONNECTION_STATUS_APPROVED;
        $doData_bkt_a->insert();

        // The "normal" conversion, normal variable
        $doData_bkt_a = OA_Dal::factoryDO('data_bkt_a');
        $doData_bkt_a->server_conv_id   = 2;
        $doData_bkt_a->server_ip        = 'localhost';
        $doData_bkt_a->tracker_id       = 2;
        $doData_bkt_a->date_time        = '2008-08-28 15:37:28';
        $doData_bkt_a->action_date_time = '2008-08-28 14:37:28';
        $doData_bkt_a->creative_id      = 1;
        $doData_bkt_a->zone_id          = 1;
        $doData_bkt_a->ip_address       = '127.0.0.1';
        $doData_bkt_a->action           = MAX_CONNECTION_AD_CLICK;
        $doData_bkt_a->window           = 3600;
        $doData_bkt_a->status           = MAX_CONNECTION_STATUS_APPROVED;
        $doData_bkt_a->insert();

        $doData_bkt_a_var = OA_Dal::factoryDO('data_bkt_a_var');
        $doData_bkt_a_var->server_conv_id      = 2;
        $doData_bkt_a_var->server_ip           = 'localhost';
        $doData_bkt_a_var->tracker_variable_id = 1;
        $doData_bkt_a_var->value               = 'foo';
        $doData_bkt_a_var->date_time           = '2008-08-28 15:37:28';
        $doData_bkt_a_var->insert();

        // The duplicated conversions
        $doData_bkt_a = OA_Dal::factoryDO('data_bkt_a');
        $doData_bkt_a->server_conv_id   = 3;
        $doData_bkt_a->server_ip        = 'localhost';
        $doData_bkt_a->tracker_id       = 3;
        $doData_bkt_a->date_time        = '2008-08-28 15:47:11';
        $doData_bkt_a->action_date_time = '2008-08-28 14:47:11';
        $doData_bkt_a->creative_id      = 1;
        $doData_bkt_a->zone_id          = 1;
        $doData_bkt_a->ip_address       = '127.0.0.1';
        $doData_bkt_a->action           = MAX_CONNECTION_AD_CLICK;
        $doData_bkt_a->window           = 3600;
        $doData_bkt_a->status           = MAX_CONNECTION_STATUS_APPROVED;
        $doData_bkt_a->insert();

        $doData_bkt_a_var = OA_Dal::factoryDO('data_bkt_a_var');
        $doData_bkt_a_var->server_conv_id      = 3;
        $doData_bkt_a_var->server_ip           = 'localhost';
        $doData_bkt_a_var->tracker_variable_id = 2;
        $doData_bkt_a_var->value               = '12345';
        $doData_bkt_a_var->date_time           = '2008-08-28 15:47:11';
        $doData_bkt_a_var->insert();

        $doData_bkt_a = OA_Dal::factoryDO('data_bkt_a');
        $doData_bkt_a->server_conv_id   = 4;
        $doData_bkt_a->server_ip        = 'localhost';
        $doData_bkt_a->tracker_id       = 3;
        $doData_bkt_a->date_time        = '2008-08-28 15:47:21';
        $doData_bkt_a->action_date_time = '2008-08-28 14:47:21';
        $doData_bkt_a->creative_id      = 1;
        $doData_bkt_a->zone_id          = 1;
        $doData_bkt_a->ip_address       = '127.0.0.1';
        $doData_bkt_a->action           = MAX_CONNECTION_AD_CLICK;
        $doData_bkt_a->window           = 3600;
        $doData_bkt_a->status           = MAX_CONNECTION_STATUS_APPROVED;
        $doData_bkt_a->insert();

        $doData_bkt_a_var = OA_Dal::factoryDO('data_bkt_a_var');
        $doData_bkt_a_var->server_conv_id      = 4;
        $doData_bkt_a_var->server_ip           = 'localhost';
        $doData_bkt_a_var->tracker_variable_id = 2;
        $doData_bkt_a_var->value               = '12345';
        $doData_bkt_a_var->date_time           = '2008-08-28 15:47:21';
        $doData_bkt_a_var->insert();

        // The conversion with a non-empty logged value
        $doData_bkt_a = OA_Dal::factoryDO('data_bkt_a');
        $doData_bkt_a->server_conv_id   = 5;
        $doData_bkt_a->server_ip        = 'localhost';
        $doData_bkt_a->tracker_id       = 4;
        $doData_bkt_a->date_time        = '2008-08-28 15:50:00';
        $doData_bkt_a->action_date_time = '2008-08-28 14:50:00';
        $doData_bkt_a->creative_id      = 1;
        $doData_bkt_a->zone_id          = 1;
        $doData_bkt_a->ip_address       = '127.0.0.1';
        $doData_bkt_a->action           = MAX_CONNECTION_AD_CLICK;
        $doData_bkt_a->window           = 3600;
        $doData_bkt_a->status           = MAX_CONNECTION_STATUS_APPROVED;
        $doData_bkt_a->insert();

        $doData_bkt_a_var = OA_Dal::factoryDO('data_bkt_a_var');
        $doData_bkt_a_var->server_conv_id      = 5;
        $doData_bkt_a_var->server_ip           = 'localhost';
        $doData_bkt_a_var->tracker_variable_id = 3;
        $doData_bkt_a_var->value               = '12345';
        $doData_bkt_a_var->date_time           = '2008-08-28 15:50:00';
        $doData_bkt_a_var->insert();

        // The conversion with a empty logged value
        $doData_bkt_a = OA_Dal::factoryDO('data_bkt_a');
        $doData_bkt_a->server_conv_id   = 6;
        $doData_bkt_a->server_ip        = 'localhost';
        $doData_bkt_a->tracker_id       = 4;
        $doData_bkt_a->date_time        = '2008-08-28 15:50:00';
        $doData_bkt_a->action_date_time = '2008-08-28 14:50:00';
        $doData_bkt_a->creative_id      = 1;
        $doData_bkt_a->zone_id          = 1;
        $doData_bkt_a->ip_address       = '127.0.0.1';
        $doData_bkt_a->action           = MAX_CONNECTION_AD_CLICK;
        $doData_bkt_a->window           = 3600;
        $doData_bkt_a->status           = MAX_CONNECTION_STATUS_APPROVED;
        $doData_bkt_a->insert();

        $doData_bkt_a_var = OA_Dal::factoryDO('data_bkt_a_var');
        $doData_bkt_a_var->server_conv_id      = 6;
        $doData_bkt_a_var->server_ip           = 'localhost';
        $doData_bkt_a_var->tracker_variable_id = 3;
        $doData_bkt_a_var->value               = '';
        $doData_bkt_a_var->date_time           = '2008-08-28 15:50:00';
        $doData_bkt_a_var->insert();

        // The two conversions with basket values and numbers of items
        $doData_bkt_a = OA_Dal::factoryDO('data_bkt_a');
        $doData_bkt_a->server_conv_id   = 7;
        $doData_bkt_a->server_ip        = 'localhost';
        $doData_bkt_a->tracker_id       = 5;
        $doData_bkt_a->date_time        = '2008-08-28 15:50:00';
        $doData_bkt_a->action_date_time = '2008-08-28 14:50:00';
        $doData_bkt_a->creative_id      = 1;
        $doData_bkt_a->zone_id          = 1;
        $doData_bkt_a->ip_address       = '127.0.0.1';
        $doData_bkt_a->action           = MAX_CONNECTION_AD_CLICK;
        $doData_bkt_a->window           = 3600;
        $doData_bkt_a->status           = MAX_CONNECTION_STATUS_APPROVED;
        $doData_bkt_a->insert();

        $doData_bkt_a_var = OA_Dal::factoryDO('data_bkt_a_var');
        $doData_bkt_a_var->server_conv_id      = 7;
        $doData_bkt_a_var->server_ip           = 'localhost';
        $doData_bkt_a_var->tracker_variable_id = 4;
        $doData_bkt_a_var->value               = '129.99';
        $doData_bkt_a_var->date_time           = '2008-08-28 15:50:00';
        $doData_bkt_a_var->insert();

        $doData_bkt_a_var = OA_Dal::factoryDO('data_bkt_a_var');
        $doData_bkt_a_var->server_conv_id      = 7;
        $doData_bkt_a_var->server_ip           = 'localhost';
        $doData_bkt_a_var->tracker_variable_id = 5;
        $doData_bkt_a_var->value               = '1';
        $doData_bkt_a_var->date_time           = '2008-08-28 15:50:00';
        $doData_bkt_a_var->insert();

        $doData_bkt_a = OA_Dal::factoryDO('data_bkt_a');
        $doData_bkt_a->server_conv_id   = 8;
        $doData_bkt_a->server_ip        = 'localhost';
        $doData_bkt_a->tracker_id       = 5;
        $doData_bkt_a->date_time        = '2008-08-28 15:50:00';
        $doData_bkt_a->action_date_time = '2008-08-28 14:50:00';
        $doData_bkt_a->creative_id      = 1;
        $doData_bkt_a->zone_id          = 1;
        $doData_bkt_a->ip_address       = '127.0.0.1';
        $doData_bkt_a->action           = MAX_CONNECTION_AD_CLICK;
        $doData_bkt_a->window           = 3600;
        $doData_bkt_a->status           = MAX_CONNECTION_STATUS_APPROVED;
        $doData_bkt_a->insert();

        $doData_bkt_a_var = OA_Dal::factoryDO('data_bkt_a_var');
        $doData_bkt_a_var->server_conv_id      = 8;
        $doData_bkt_a_var->server_ip           = 'localhost';
        $doData_bkt_a_var->tracker_variable_id = 4;
        $doData_bkt_a_var->value               = '0.99';
        $doData_bkt_a_var->date_time           = '2008-08-28 15:50:00';
        $doData_bkt_a_var->insert();

        $doData_bkt_a_var = OA_Dal::factoryDO('data_bkt_a_var');
        $doData_bkt_a_var->server_conv_id      = 8;
        $doData_bkt_a_var->server_ip           = 'localhost';
        $doData_bkt_a_var->tracker_variable_id = 5;
        $doData_bkt_a_var->value               = '99';
        $doData_bkt_a_var->date_time           = '2008-08-28 15:50:00';
        $doData_bkt_a_var->insert();

        /**********************************************************************/

        // Prepare the current date/time for testing
        $oNowDate = new Date('2008-08-28 16:01:00');
        $oServiceLocator =& OA_ServiceLocator::instance();
        $oServiceLocator->register('now', $oNowDate);

        // Test 2: Run the MSE process WITH data
        $oMaintenanceStatisitcs = new OX_Maintenance_Statistics();
        $oMaintenanceStatisitcs->run();

        /**********************************************************************/

        // Test to ensure the data has been migrated correctly, and
        // that the MSE has logged all required info correctly

        $doUserlog = OA_Dal::factoryDO('userlog');
        $doUserlog->find();
        $this->assertEqual($doUserlog->getRowCount(), 1);

        $doLog_maintenance_statistics = OA_Dal::factoryDO('log_maintenance_statistics');
        $doLog_maintenance_statistics->find();
        $this->assertEqual($doLog_maintenance_statistics->getRowCount(), 1);

        $doData_intermediate_ad_connection = OA_Dal::factoryDO('data_intermediate_ad_connection');
        $doData_intermediate_ad_connection->find();
        $this->assertEqual($doData_intermediate_ad_connection->getRowCount(), 8);

        $doData_intermediate_ad_variable_value = OA_Dal::factoryDO('data_intermediate_ad_variable_value');
        $doData_intermediate_ad_variable_value->find();
        $this->assertEqual($doData_intermediate_ad_variable_value->getRowCount(), 9);

        $doData_intermediate_ad = OA_Dal::factoryDO('data_intermediate_ad');
        $doData_intermediate_ad->find();
        $this->assertEqual($doData_intermediate_ad->getRowCount(), 2);

        $doData_summary_ad_hourly = OA_Dal::factoryDO('data_summary_ad_hourly');
        $doData_summary_ad_hourly->find();
        $this->assertEqual($doData_summary_ad_hourly->getRowCount(), 2);

        $doData_summary_zone_impression_history = OA_Dal::factoryDO('data_summary_zone_impression_history');
        $doData_summary_zone_impression_history->find();
        $this->assertEqual($doData_summary_zone_impression_history->getRowCount(), 2);

        $doData_bkt_r = OA_Dal::factoryDO('data_bkt_r');
        $doData_bkt_r->find();
        $this->assertEqual($doData_bkt_r->getRowCount(), 0);

        $doData_bkt_r = OA_Dal::factoryDO('data_bkt_m');
        $doData_bkt_r->find();
        $this->assertEqual($doData_bkt_r->getRowCount(), 0);

        $doData_bkt_r = OA_Dal::factoryDO('data_bkt_c');
        $doData_bkt_r->find();
        $this->assertEqual($doData_bkt_r->getRowCount(), 0);

        $doData_bkt_r = OA_Dal::factoryDO('data_bkt_a');
        $doData_bkt_r->find();
        $this->assertEqual($doData_bkt_r->getRowCount(), 0);

        $doData_bkt_r = OA_Dal::factoryDO('data_bkt_a_var');
        $doData_bkt_r->find();
        $this->assertEqual($doData_bkt_r->getRowCount(), 0);

        // Test all of the details of the migrated data

        $log = "Maintenance Statistics Report
=====================================

- Maintenance start run time is 2008-08-28 16:01:00 UTC
- Maintenance statistics last updated intermediate table statistics to 2008-08-28 13:59:59 UTC.
- Current time must be after 2008-08-28 14:59:59 UTC for the next intermediate table update to happen
- Maintenance statistics last updated final table statistics to 2008-08-28 13:59:59 UTC.
- Current time must be after 2008-08-28 14:59:59 UTC for the next intermediate table update to happen
- Maintenance statistics will be run.
- The intermediate table statistics will be updated.
- The final table statistics will be updated.

- Migrating bucket-based logged data to the statistics tables.
- Saving request, impression, click and conversion data into the final tables.
- Updating the data_summary_zone_impression_history table for data after 2008-08-28 14:00:00 UTC.
- Updating the data_summary_ad_hourly table for data after 2008-08-28 14:00:00 UTC.
- Managing (activating/deactivating) campaigns.
- Logging the completion of the maintenance statistics run.";

        $doUserlog = OA_Dal::factoryDO('userlog');
        $doUserlog->find();
        $this->assertEqual($doUserlog->getRowCount(), 1);
        $doUserlog->fetch();
        $this->assertEqual($doUserlog->usertype, phpAds_userMaintenance);
        $this->assertEqual($doUserlog->userid,   0);
        $this->assertEqual($doUserlog->action,   phpAds_actionBatchStatistics);
        $this->assertEqual($doUserlog->object,   0);

        $this->assertEqual($doUserlog->details,  $log);

        $doLog_maintenance_statistics = OA_Dal::factoryDO('log_maintenance_statistics');
        $doLog_maintenance_statistics->start_run = $oNowDate->format('%Y-%m-%d %H:%M:%S');
        $doLog_maintenance_statistics->find();
        $this->assertEqual($doLog_maintenance_statistics->getRowCount(), 1);
        $doLog_maintenance_statistics->fetch();
        $this->assertEqual($doLog_maintenance_statistics->adserver_run_type, OX_DAL_MAINTENANCE_STATISTICS_UPDATE_BOTH);
        $this->assertNull($doLog_maintenance_statistics->search_run_type);
        $this->assertNull($doLog_maintenance_statistics->tracker_run_type);
        $this->assertEqual($doLog_maintenance_statistics->updated_to,        '2008-08-28 15:59:59');

        $doData_intermediate_ad_connection = OA_Dal::factoryDO('data_intermediate_ad_connection');
        $doData_intermediate_ad_connection->server_raw_ip                    = 'localhost';
        $doData_intermediate_ad_connection->server_raw_tracker_impression_id = 1;
        $doData_intermediate_ad_connection->find();
        $this->assertEqual($doData_intermediate_ad_connection->getRowCount(), 1);
        $doData_intermediate_ad_connection->fetch();
        $this->assertNull($doData_intermediate_ad_connection->veiwer_id);
        $this->assertNull($doData_intermediate_ad_connection->veiwer_session_id);
        $this->assertEqual($doData_intermediate_ad_connection->tracker_date_time,    '2008-08-28 15:37:28');
        $this->assertEqual($doData_intermediate_ad_connection->connection_date_time, '2008-08-28 14:37:28');
        $this->assertEqual($doData_intermediate_ad_connection->tracker_id,           1);
        $this->assertEqual($doData_intermediate_ad_connection->ad_id,                1);
        $this->assertEqual($doData_intermediate_ad_connection->creative_id,          0);
        $this->assertEqual($doData_intermediate_ad_connection->zone_id,              1);
        $this->assertNull($doData_intermediate_ad_connection->tracker_channel);
        $this->assertNull($doData_intermediate_ad_connection->connection_channel);
        $this->assertNull($doData_intermediate_ad_connection->tracker_channel_ids);
        $this->assertNull($doData_intermediate_ad_connection->connection_channel_ids);
        $this->assertNull($doData_intermediate_ad_connection->tracker_language);
        $this->assertNull($doData_intermediate_ad_connection->connection_language);
        $this->assertEqual($doData_intermediate_ad_connection->tracker_ip_address,   '127.0.0.1');
        $this->assertNull($doData_intermediate_ad_connection->connection_ip_address);
        $this->assertNull($doData_intermediate_ad_connection->tracker_host_name);
        $this->assertNull($doData_intermediate_ad_connection->connection_host_name);
        $this->assertNull($doData_intermediate_ad_connection->tracker_country);
        $this->assertNull($doData_intermediate_ad_connection->connection_country);
        $this->assertNull($doData_intermediate_ad_connection->tracker_https);
        $this->assertNull($doData_intermediate_ad_connection->connection_https);
        $this->assertNull($doData_intermediate_ad_connection->tracker_domain);
        $this->assertNull($doData_intermediate_ad_connection->connection_domain);
        $this->assertNull($doData_intermediate_ad_connection->tracker_page);
        $this->assertNull($doData_intermediate_ad_connection->connection_page);
        $this->assertNull($doData_intermediate_ad_connection->tracker_query);
        $this->assertNull($doData_intermediate_ad_connection->connection_query);
        $this->assertNull($doData_intermediate_ad_connection->tracker_referer);
        $this->assertNull($doData_intermediate_ad_connection->connection_referer);
        $this->assertNull($doData_intermediate_ad_connection->tracker_search_term);
        $this->assertNull($doData_intermediate_ad_connection->connection_search_term);
        $this->assertNull($doData_intermediate_ad_connection->tracker_user_agent);
        $this->assertNull($doData_intermediate_ad_connection->connection_user_agent);
        $this->assertNull($doData_intermediate_ad_connection->tracker_os);
        $this->assertNull($doData_intermediate_ad_connection->connection_os);
        $this->assertNull($doData_intermediate_ad_connection->tracker_browser);
        $this->assertNull($doData_intermediate_ad_connection->connection_browser);
        $this->assertEqual($doData_intermediate_ad_connection->connection_action,    MAX_CONNECTION_AD_CLICK);
        $this->assertEqual($doData_intermediate_ad_connection->connection_window,    3600);
        $this->assertEqual($doData_intermediate_ad_connection->connection_status,    MAX_CONNECTION_STATUS_APPROVED);
        $this->assertEqual($doData_intermediate_ad_connection->inside_window,        1);
        $this->assertNull($doData_intermediate_ad_connection->comments);

        $doData_intermediate_ad_connection = OA_Dal::factoryDO('data_intermediate_ad_connection');
        $doData_intermediate_ad_connection->server_raw_ip                    = 'localhost';
        $doData_intermediate_ad_connection->server_raw_tracker_impression_id = 2;
        $doData_intermediate_ad_connection->find();
        $this->assertEqual($doData_intermediate_ad_connection->getRowCount(), 1);
        $doData_intermediate_ad_connection->fetch();
        $this->assertNull($doData_intermediate_ad_connection->veiwer_id);
        $this->assertNull($doData_intermediate_ad_connection->veiwer_session_id);
        $this->assertEqual($doData_intermediate_ad_connection->tracker_date_time,    '2008-08-28 15:37:28');
        $this->assertEqual($doData_intermediate_ad_connection->connection_date_time, '2008-08-28 14:37:28');
        $this->assertEqual($doData_intermediate_ad_connection->tracker_id,           2);
        $this->assertEqual($doData_intermediate_ad_connection->ad_id,                1);
        $this->assertEqual($doData_intermediate_ad_connection->creative_id,          0);
        $this->assertEqual($doData_intermediate_ad_connection->zone_id,              1);
        $this->assertNull($doData_intermediate_ad_connection->tracker_channel);
        $this->assertNull($doData_intermediate_ad_connection->connection_channel);
        $this->assertNull($doData_intermediate_ad_connection->tracker_channel_ids);
        $this->assertNull($doData_intermediate_ad_connection->connection_channel_ids);
        $this->assertNull($doData_intermediate_ad_connection->tracker_language);
        $this->assertNull($doData_intermediate_ad_connection->connection_language);
        $this->assertEqual($doData_intermediate_ad_connection->tracker_ip_address,   '127.0.0.1');
        $this->assertNull($doData_intermediate_ad_connection->connection_ip_address);
        $this->assertNull($doData_intermediate_ad_connection->tracker_host_name);
        $this->assertNull($doData_intermediate_ad_connection->connection_host_name);
        $this->assertNull($doData_intermediate_ad_connection->tracker_country);
        $this->assertNull($doData_intermediate_ad_connection->connection_country);
        $this->assertNull($doData_intermediate_ad_connection->tracker_https);
        $this->assertNull($doData_intermediate_ad_connection->connection_https);
        $this->assertNull($doData_intermediate_ad_connection->tracker_domain);
        $this->assertNull($doData_intermediate_ad_connection->connection_domain);
        $this->assertNull($doData_intermediate_ad_connection->tracker_page);
        $this->assertNull($doData_intermediate_ad_connection->connection_page);
        $this->assertNull($doData_intermediate_ad_connection->tracker_query);
        $this->assertNull($doData_intermediate_ad_connection->connection_query);
        $this->assertNull($doData_intermediate_ad_connection->tracker_referer);
        $this->assertNull($doData_intermediate_ad_connection->connection_referer);
        $this->assertNull($doData_intermediate_ad_connection->tracker_search_term);
        $this->assertNull($doData_intermediate_ad_connection->connection_search_term);
        $this->assertNull($doData_intermediate_ad_connection->tracker_user_agent);
        $this->assertNull($doData_intermediate_ad_connection->connection_user_agent);
        $this->assertNull($doData_intermediate_ad_connection->tracker_os);
        $this->assertNull($doData_intermediate_ad_connection->connection_os);
        $this->assertNull($doData_intermediate_ad_connection->tracker_browser);
        $this->assertNull($doData_intermediate_ad_connection->connection_browser);
        $this->assertEqual($doData_intermediate_ad_connection->connection_action,    MAX_CONNECTION_AD_CLICK);
        $this->assertEqual($doData_intermediate_ad_connection->connection_window,    3600);
        $this->assertEqual($doData_intermediate_ad_connection->connection_status,    MAX_CONNECTION_STATUS_APPROVED);
        $this->assertEqual($doData_intermediate_ad_connection->inside_window,        1);
        $this->assertNull($doData_intermediate_ad_connection->comments);

        $doData_intermediate_ad_connection = OA_Dal::factoryDO('data_intermediate_ad_connection');
        $doData_intermediate_ad_connection->server_raw_ip                    = 'localhost';
        $doData_intermediate_ad_connection->server_raw_tracker_impression_id = 3;
        $doData_intermediate_ad_connection->find();
        $this->assertEqual($doData_intermediate_ad_connection->getRowCount(), 1);
        $doData_intermediate_ad_connection->fetch();
        $this->assertNull($doData_intermediate_ad_connection->veiwer_id);
        $this->assertNull($doData_intermediate_ad_connection->veiwer_session_id);
        $this->assertEqual($doData_intermediate_ad_connection->tracker_date_time,    '2008-08-28 15:47:11');
        $this->assertEqual($doData_intermediate_ad_connection->connection_date_time, '2008-08-28 14:47:11');
        $this->assertEqual($doData_intermediate_ad_connection->tracker_id,           3);
        $this->assertEqual($doData_intermediate_ad_connection->ad_id,                1);
        $this->assertEqual($doData_intermediate_ad_connection->creative_id,          0);
        $this->assertEqual($doData_intermediate_ad_connection->zone_id,              1);
        $this->assertNull($doData_intermediate_ad_connection->tracker_channel);
        $this->assertNull($doData_intermediate_ad_connection->connection_channel);
        $this->assertNull($doData_intermediate_ad_connection->tracker_channel_ids);
        $this->assertNull($doData_intermediate_ad_connection->connection_channel_ids);
        $this->assertNull($doData_intermediate_ad_connection->tracker_language);
        $this->assertNull($doData_intermediate_ad_connection->connection_language);
        $this->assertEqual($doData_intermediate_ad_connection->tracker_ip_address,   '127.0.0.1');
        $this->assertNull($doData_intermediate_ad_connection->connection_ip_address);
        $this->assertNull($doData_intermediate_ad_connection->tracker_host_name);
        $this->assertNull($doData_intermediate_ad_connection->connection_host_name);
        $this->assertNull($doData_intermediate_ad_connection->tracker_country);
        $this->assertNull($doData_intermediate_ad_connection->connection_country);
        $this->assertNull($doData_intermediate_ad_connection->tracker_https);
        $this->assertNull($doData_intermediate_ad_connection->connection_https);
        $this->assertNull($doData_intermediate_ad_connection->tracker_domain);
        $this->assertNull($doData_intermediate_ad_connection->connection_domain);
        $this->assertNull($doData_intermediate_ad_connection->tracker_page);
        $this->assertNull($doData_intermediate_ad_connection->connection_page);
        $this->assertNull($doData_intermediate_ad_connection->tracker_query);
        $this->assertNull($doData_intermediate_ad_connection->connection_query);
        $this->assertNull($doData_intermediate_ad_connection->tracker_referer);
        $this->assertNull($doData_intermediate_ad_connection->connection_referer);
        $this->assertNull($doData_intermediate_ad_connection->tracker_search_term);
        $this->assertNull($doData_intermediate_ad_connection->connection_search_term);
        $this->assertNull($doData_intermediate_ad_connection->tracker_user_agent);
        $this->assertNull($doData_intermediate_ad_connection->connection_user_agent);
        $this->assertNull($doData_intermediate_ad_connection->tracker_os);
        $this->assertNull($doData_intermediate_ad_connection->connection_os);
        $this->assertNull($doData_intermediate_ad_connection->tracker_browser);
        $this->assertNull($doData_intermediate_ad_connection->connection_browser);
        $this->assertEqual($doData_intermediate_ad_connection->connection_action,    MAX_CONNECTION_AD_CLICK);
        $this->assertEqual($doData_intermediate_ad_connection->connection_window,    3600);
        $this->assertEqual($doData_intermediate_ad_connection->connection_status,    MAX_CONNECTION_STATUS_APPROVED);
        $this->assertEqual($doData_intermediate_ad_connection->inside_window,        1);
        $this->assertNull($doData_intermediate_ad_connection->comments);

        $doData_intermediate_ad_connection = OA_Dal::factoryDO('data_intermediate_ad_connection');
        $doData_intermediate_ad_connection->server_raw_ip                    = 'localhost';
        $doData_intermediate_ad_connection->server_raw_tracker_impression_id = 4;
        $doData_intermediate_ad_connection->find();
        $this->assertEqual($doData_intermediate_ad_connection->getRowCount(), 1);
        $doData_intermediate_ad_connection->fetch();
        $this->assertNull($doData_intermediate_ad_connection->veiwer_id);
        $this->assertNull($doData_intermediate_ad_connection->veiwer_session_id);
        $this->assertEqual($doData_intermediate_ad_connection->tracker_date_time,    '2008-08-28 15:47:21');
        $this->assertEqual($doData_intermediate_ad_connection->connection_date_time, '2008-08-28 14:47:21');
        $this->assertEqual($doData_intermediate_ad_connection->tracker_id,           3);
        $this->assertEqual($doData_intermediate_ad_connection->ad_id,                1);
        $this->assertEqual($doData_intermediate_ad_connection->creative_id,          0);
        $this->assertEqual($doData_intermediate_ad_connection->zone_id,              1);
        $this->assertNull($doData_intermediate_ad_connection->tracker_channel);
        $this->assertNull($doData_intermediate_ad_connection->connection_channel);
        $this->assertNull($doData_intermediate_ad_connection->tracker_channel_ids);
        $this->assertNull($doData_intermediate_ad_connection->connection_channel_ids);
        $this->assertNull($doData_intermediate_ad_connection->tracker_language);
        $this->assertNull($doData_intermediate_ad_connection->connection_language);
        $this->assertEqual($doData_intermediate_ad_connection->tracker_ip_address,   '127.0.0.1');
        $this->assertNull($doData_intermediate_ad_connection->connection_ip_address);
        $this->assertNull($doData_intermediate_ad_connection->tracker_host_name);
        $this->assertNull($doData_intermediate_ad_connection->connection_host_name);
        $this->assertNull($doData_intermediate_ad_connection->tracker_country);
        $this->assertNull($doData_intermediate_ad_connection->connection_country);
        $this->assertNull($doData_intermediate_ad_connection->tracker_https);
        $this->assertNull($doData_intermediate_ad_connection->connection_https);
        $this->assertNull($doData_intermediate_ad_connection->tracker_domain);
        $this->assertNull($doData_intermediate_ad_connection->connection_domain);
        $this->assertNull($doData_intermediate_ad_connection->tracker_page);
        $this->assertNull($doData_intermediate_ad_connection->connection_page);
        $this->assertNull($doData_intermediate_ad_connection->tracker_query);
        $this->assertNull($doData_intermediate_ad_connection->connection_query);
        $this->assertNull($doData_intermediate_ad_connection->tracker_referer);
        $this->assertNull($doData_intermediate_ad_connection->connection_referer);
        $this->assertNull($doData_intermediate_ad_connection->tracker_search_term);
        $this->assertNull($doData_intermediate_ad_connection->connection_search_term);
        $this->assertNull($doData_intermediate_ad_connection->tracker_user_agent);
        $this->assertNull($doData_intermediate_ad_connection->connection_user_agent);
        $this->assertNull($doData_intermediate_ad_connection->tracker_os);
        $this->assertNull($doData_intermediate_ad_connection->connection_os);
        $this->assertNull($doData_intermediate_ad_connection->tracker_browser);
        $this->assertNull($doData_intermediate_ad_connection->connection_browser);
        $this->assertEqual($doData_intermediate_ad_connection->connection_action,    MAX_CONNECTION_AD_CLICK);
        $this->assertEqual($doData_intermediate_ad_connection->connection_window,    3600);
        $this->assertEqual($doData_intermediate_ad_connection->connection_status,    MAX_CONNECTION_STATUS_DUPLICATE);
        $this->assertEqual($doData_intermediate_ad_connection->inside_window,        1);
        $this->assertEqual($doData_intermediate_ad_connection->comments,             'Duplicate of conversion ID 3');

        $doData_intermediate_ad_connection = OA_Dal::factoryDO('data_intermediate_ad_connection');
        $doData_intermediate_ad_connection->server_raw_ip                    = 'localhost';
        $doData_intermediate_ad_connection->server_raw_tracker_impression_id = 5;
        $doData_intermediate_ad_connection->find();
        $this->assertEqual($doData_intermediate_ad_connection->getRowCount(), 1);
        $doData_intermediate_ad_connection->fetch();
        $this->assertNull($doData_intermediate_ad_connection->veiwer_id);
        $this->assertNull($doData_intermediate_ad_connection->veiwer_session_id);
        $this->assertEqual($doData_intermediate_ad_connection->tracker_date_time,    '2008-08-28 15:50:00');
        $this->assertEqual($doData_intermediate_ad_connection->connection_date_time, '2008-08-28 14:50:00');
        $this->assertEqual($doData_intermediate_ad_connection->tracker_id,           4);
        $this->assertEqual($doData_intermediate_ad_connection->ad_id,                1);
        $this->assertEqual($doData_intermediate_ad_connection->creative_id,          0);
        $this->assertEqual($doData_intermediate_ad_connection->zone_id,              1);
        $this->assertNull($doData_intermediate_ad_connection->tracker_channel);
        $this->assertNull($doData_intermediate_ad_connection->connection_channel);
        $this->assertNull($doData_intermediate_ad_connection->tracker_channel_ids);
        $this->assertNull($doData_intermediate_ad_connection->connection_channel_ids);
        $this->assertNull($doData_intermediate_ad_connection->tracker_language);
        $this->assertNull($doData_intermediate_ad_connection->connection_language);
        $this->assertEqual($doData_intermediate_ad_connection->tracker_ip_address,   '127.0.0.1');
        $this->assertNull($doData_intermediate_ad_connection->connection_ip_address);
        $this->assertNull($doData_intermediate_ad_connection->tracker_host_name);
        $this->assertNull($doData_intermediate_ad_connection->connection_host_name);
        $this->assertNull($doData_intermediate_ad_connection->tracker_country);
        $this->assertNull($doData_intermediate_ad_connection->connection_country);
        $this->assertNull($doData_intermediate_ad_connection->tracker_https);
        $this->assertNull($doData_intermediate_ad_connection->connection_https);
        $this->assertNull($doData_intermediate_ad_connection->tracker_domain);
        $this->assertNull($doData_intermediate_ad_connection->connection_domain);
        $this->assertNull($doData_intermediate_ad_connection->tracker_page);
        $this->assertNull($doData_intermediate_ad_connection->connection_page);
        $this->assertNull($doData_intermediate_ad_connection->tracker_query);
        $this->assertNull($doData_intermediate_ad_connection->connection_query);
        $this->assertNull($doData_intermediate_ad_connection->tracker_referer);
        $this->assertNull($doData_intermediate_ad_connection->connection_referer);
        $this->assertNull($doData_intermediate_ad_connection->tracker_search_term);
        $this->assertNull($doData_intermediate_ad_connection->connection_search_term);
        $this->assertNull($doData_intermediate_ad_connection->tracker_user_agent);
        $this->assertNull($doData_intermediate_ad_connection->connection_user_agent);
        $this->assertNull($doData_intermediate_ad_connection->tracker_os);
        $this->assertNull($doData_intermediate_ad_connection->connection_os);
        $this->assertNull($doData_intermediate_ad_connection->tracker_browser);
        $this->assertNull($doData_intermediate_ad_connection->connection_browser);
        $this->assertEqual($doData_intermediate_ad_connection->connection_action,    MAX_CONNECTION_AD_CLICK);
        $this->assertEqual($doData_intermediate_ad_connection->connection_window,    3600);
        $this->assertEqual($doData_intermediate_ad_connection->connection_status,    MAX_CONNECTION_STATUS_APPROVED);
        $this->assertEqual($doData_intermediate_ad_connection->inside_window,        1);
        $this->assertNull($doData_intermediate_ad_connection->comments);

        $doData_intermediate_ad_connection = OA_Dal::factoryDO('data_intermediate_ad_connection');
        $doData_intermediate_ad_connection->server_raw_ip                    = 'localhost';
        $doData_intermediate_ad_connection->server_raw_tracker_impression_id = 6;
        $doData_intermediate_ad_connection->find();
        $this->assertEqual($doData_intermediate_ad_connection->getRowCount(), 1);
        $doData_intermediate_ad_connection->fetch();
        $this->assertNull($doData_intermediate_ad_connection->veiwer_id);
        $this->assertNull($doData_intermediate_ad_connection->veiwer_session_id);
        $this->assertEqual($doData_intermediate_ad_connection->tracker_date_time,    '2008-08-28 15:50:00');
        $this->assertEqual($doData_intermediate_ad_connection->connection_date_time, '2008-08-28 14:50:00');
        $this->assertEqual($doData_intermediate_ad_connection->tracker_id,           4);
        $this->assertEqual($doData_intermediate_ad_connection->ad_id,                1);
        $this->assertEqual($doData_intermediate_ad_connection->creative_id,          0);
        $this->assertEqual($doData_intermediate_ad_connection->zone_id,              1);
        $this->assertNull($doData_intermediate_ad_connection->tracker_channel);
        $this->assertNull($doData_intermediate_ad_connection->connection_channel);
        $this->assertNull($doData_intermediate_ad_connection->tracker_channel_ids);
        $this->assertNull($doData_intermediate_ad_connection->connection_channel_ids);
        $this->assertNull($doData_intermediate_ad_connection->tracker_language);
        $this->assertNull($doData_intermediate_ad_connection->connection_language);
        $this->assertEqual($doData_intermediate_ad_connection->tracker_ip_address,   '127.0.0.1');
        $this->assertNull($doData_intermediate_ad_connection->connection_ip_address);
        $this->assertNull($doData_intermediate_ad_connection->tracker_host_name);
        $this->assertNull($doData_intermediate_ad_connection->connection_host_name);
        $this->assertNull($doData_intermediate_ad_connection->tracker_country);
        $this->assertNull($doData_intermediate_ad_connection->connection_country);
        $this->assertNull($doData_intermediate_ad_connection->tracker_https);
        $this->assertNull($doData_intermediate_ad_connection->connection_https);
        $this->assertNull($doData_intermediate_ad_connection->tracker_domain);
        $this->assertNull($doData_intermediate_ad_connection->connection_domain);
        $this->assertNull($doData_intermediate_ad_connection->tracker_page);
        $this->assertNull($doData_intermediate_ad_connection->connection_page);
        $this->assertNull($doData_intermediate_ad_connection->tracker_query);
        $this->assertNull($doData_intermediate_ad_connection->connection_query);
        $this->assertNull($doData_intermediate_ad_connection->tracker_referer);
        $this->assertNull($doData_intermediate_ad_connection->connection_referer);
        $this->assertNull($doData_intermediate_ad_connection->tracker_search_term);
        $this->assertNull($doData_intermediate_ad_connection->connection_search_term);
        $this->assertNull($doData_intermediate_ad_connection->tracker_user_agent);
        $this->assertNull($doData_intermediate_ad_connection->connection_user_agent);
        $this->assertNull($doData_intermediate_ad_connection->tracker_os);
        $this->assertNull($doData_intermediate_ad_connection->connection_os);
        $this->assertNull($doData_intermediate_ad_connection->tracker_browser);
        $this->assertNull($doData_intermediate_ad_connection->connection_browser);
        $this->assertEqual($doData_intermediate_ad_connection->connection_action,    MAX_CONNECTION_AD_CLICK);
        $this->assertEqual($doData_intermediate_ad_connection->connection_window,    3600);
        $this->assertEqual($doData_intermediate_ad_connection->connection_status,    MAX_CONNECTION_STATUS_DISAPPROVED);
        $this->assertEqual($doData_intermediate_ad_connection->inside_window,        1);
        $this->assertEqual($doData_intermediate_ad_connection->comments,             'Rejected because Reject if Empty Variable is empty');

        $doData_intermediate_ad_connection = OA_Dal::factoryDO('data_intermediate_ad_connection');
        $doData_intermediate_ad_connection->server_raw_ip                    = 'localhost';
        $doData_intermediate_ad_connection->server_raw_tracker_impression_id = 7;
        $doData_intermediate_ad_connection->find();
        $this->assertEqual($doData_intermediate_ad_connection->getRowCount(), 1);
        $doData_intermediate_ad_connection->fetch();
        $this->assertNull($doData_intermediate_ad_connection->veiwer_id);
        $this->assertNull($doData_intermediate_ad_connection->veiwer_session_id);
        $this->assertEqual($doData_intermediate_ad_connection->tracker_date_time,    '2008-08-28 15:50:00');
        $this->assertEqual($doData_intermediate_ad_connection->connection_date_time, '2008-08-28 14:50:00');
        $this->assertEqual($doData_intermediate_ad_connection->tracker_id,           5);
        $this->assertEqual($doData_intermediate_ad_connection->ad_id,                1);
        $this->assertEqual($doData_intermediate_ad_connection->creative_id,          0);
        $this->assertEqual($doData_intermediate_ad_connection->zone_id,              1);
        $this->assertNull($doData_intermediate_ad_connection->tracker_channel);
        $this->assertNull($doData_intermediate_ad_connection->connection_channel);
        $this->assertNull($doData_intermediate_ad_connection->tracker_channel_ids);
        $this->assertNull($doData_intermediate_ad_connection->connection_channel_ids);
        $this->assertNull($doData_intermediate_ad_connection->tracker_language);
        $this->assertNull($doData_intermediate_ad_connection->connection_language);
        $this->assertEqual($doData_intermediate_ad_connection->tracker_ip_address,   '127.0.0.1');
        $this->assertNull($doData_intermediate_ad_connection->connection_ip_address);
        $this->assertNull($doData_intermediate_ad_connection->tracker_host_name);
        $this->assertNull($doData_intermediate_ad_connection->connection_host_name);
        $this->assertNull($doData_intermediate_ad_connection->tracker_country);
        $this->assertNull($doData_intermediate_ad_connection->connection_country);
        $this->assertNull($doData_intermediate_ad_connection->tracker_https);
        $this->assertNull($doData_intermediate_ad_connection->connection_https);
        $this->assertNull($doData_intermediate_ad_connection->tracker_domain);
        $this->assertNull($doData_intermediate_ad_connection->connection_domain);
        $this->assertNull($doData_intermediate_ad_connection->tracker_page);
        $this->assertNull($doData_intermediate_ad_connection->connection_page);
        $this->assertNull($doData_intermediate_ad_connection->tracker_query);
        $this->assertNull($doData_intermediate_ad_connection->connection_query);
        $this->assertNull($doData_intermediate_ad_connection->tracker_referer);
        $this->assertNull($doData_intermediate_ad_connection->connection_referer);
        $this->assertNull($doData_intermediate_ad_connection->tracker_search_term);
        $this->assertNull($doData_intermediate_ad_connection->connection_search_term);
        $this->assertNull($doData_intermediate_ad_connection->tracker_user_agent);
        $this->assertNull($doData_intermediate_ad_connection->connection_user_agent);
        $this->assertNull($doData_intermediate_ad_connection->tracker_os);
        $this->assertNull($doData_intermediate_ad_connection->connection_os);
        $this->assertNull($doData_intermediate_ad_connection->tracker_browser);
        $this->assertNull($doData_intermediate_ad_connection->connection_browser);
        $this->assertEqual($doData_intermediate_ad_connection->connection_action,    MAX_CONNECTION_AD_CLICK);
        $this->assertEqual($doData_intermediate_ad_connection->connection_window,    3600);
        $this->assertEqual($doData_intermediate_ad_connection->connection_status,    MAX_CONNECTION_STATUS_APPROVED);
        $this->assertEqual($doData_intermediate_ad_connection->inside_window,        1);
        $this->assertNull($doData_intermediate_ad_connection->comments);

        $doData_intermediate_ad_connection = OA_Dal::factoryDO('data_intermediate_ad_connection');
        $doData_intermediate_ad_connection->server_raw_ip                    = 'localhost';
        $doData_intermediate_ad_connection->server_raw_tracker_impression_id = 8;
        $doData_intermediate_ad_connection->find();
        $this->assertEqual($doData_intermediate_ad_connection->getRowCount(), 1);
        $doData_intermediate_ad_connection->fetch();
        $this->assertNull($doData_intermediate_ad_connection->veiwer_id);
        $this->assertNull($doData_intermediate_ad_connection->veiwer_session_id);
        $this->assertEqual($doData_intermediate_ad_connection->tracker_date_time,    '2008-08-28 15:50:00');
        $this->assertEqual($doData_intermediate_ad_connection->connection_date_time, '2008-08-28 14:50:00');
        $this->assertEqual($doData_intermediate_ad_connection->tracker_id,           5);
        $this->assertEqual($doData_intermediate_ad_connection->ad_id,                1);
        $this->assertEqual($doData_intermediate_ad_connection->creative_id,          0);
        $this->assertEqual($doData_intermediate_ad_connection->zone_id,              1);
        $this->assertNull($doData_intermediate_ad_connection->tracker_channel);
        $this->assertNull($doData_intermediate_ad_connection->connection_channel);
        $this->assertNull($doData_intermediate_ad_connection->tracker_channel_ids);
        $this->assertNull($doData_intermediate_ad_connection->connection_channel_ids);
        $this->assertNull($doData_intermediate_ad_connection->tracker_language);
        $this->assertNull($doData_intermediate_ad_connection->connection_language);
        $this->assertEqual($doData_intermediate_ad_connection->tracker_ip_address,   '127.0.0.1');
        $this->assertNull($doData_intermediate_ad_connection->connection_ip_address);
        $this->assertNull($doData_intermediate_ad_connection->tracker_host_name);
        $this->assertNull($doData_intermediate_ad_connection->connection_host_name);
        $this->assertNull($doData_intermediate_ad_connection->tracker_country);
        $this->assertNull($doData_intermediate_ad_connection->connection_country);
        $this->assertNull($doData_intermediate_ad_connection->tracker_https);
        $this->assertNull($doData_intermediate_ad_connection->connection_https);
        $this->assertNull($doData_intermediate_ad_connection->tracker_domain);
        $this->assertNull($doData_intermediate_ad_connection->connection_domain);
        $this->assertNull($doData_intermediate_ad_connection->tracker_page);
        $this->assertNull($doData_intermediate_ad_connection->connection_page);
        $this->assertNull($doData_intermediate_ad_connection->tracker_query);
        $this->assertNull($doData_intermediate_ad_connection->connection_query);
        $this->assertNull($doData_intermediate_ad_connection->tracker_referer);
        $this->assertNull($doData_intermediate_ad_connection->connection_referer);
        $this->assertNull($doData_intermediate_ad_connection->tracker_search_term);
        $this->assertNull($doData_intermediate_ad_connection->connection_search_term);
        $this->assertNull($doData_intermediate_ad_connection->tracker_user_agent);
        $this->assertNull($doData_intermediate_ad_connection->connection_user_agent);
        $this->assertNull($doData_intermediate_ad_connection->tracker_os);
        $this->assertNull($doData_intermediate_ad_connection->connection_os);
        $this->assertNull($doData_intermediate_ad_connection->tracker_browser);
        $this->assertNull($doData_intermediate_ad_connection->connection_browser);
        $this->assertEqual($doData_intermediate_ad_connection->connection_action,    MAX_CONNECTION_AD_CLICK);
        $this->assertEqual($doData_intermediate_ad_connection->connection_window,    3600);
        $this->assertEqual($doData_intermediate_ad_connection->connection_status,    MAX_CONNECTION_STATUS_APPROVED);
        $this->assertEqual($doData_intermediate_ad_connection->inside_window,        1);
        $this->assertNull($doData_intermediate_ad_connection->comments);

        $doData_intermediate_ad_connection = OA_Dal::factoryDO('data_intermediate_ad_connection');
        $doData_intermediate_ad_connection->server_raw_ip                    = 'localhost';
        $doData_intermediate_ad_connection->server_raw_tracker_impression_id = 1;
        $doData_intermediate_ad_connection->find();
        $this->assertEqual($doData_intermediate_ad_connection->getRowCount(), 1);
        $doData_intermediate_ad_connection->fetch();

        $doData_intermediate_ad_variable_value = OA_Dal::factoryDO('data_intermediate_ad_variable_value');
        $doData_intermediate_ad_variable_value->data_intermediate_ad_connection_id = $doData_intermediate_ad_connection->data_intermediate_ad_connection_id;
        $doData_intermediate_ad_variable_value->find();
        $this->assertEqual($doData_intermediate_ad_variable_value->getRowCount(), 0);

        $doData_intermediate_ad_connection = OA_Dal::factoryDO('data_intermediate_ad_connection');
        $doData_intermediate_ad_connection->server_raw_ip                    = 'localhost';
        $doData_intermediate_ad_connection->server_raw_tracker_impression_id = 2;
        $doData_intermediate_ad_connection->find();
        $this->assertEqual($doData_intermediate_ad_connection->getRowCount(), 1);
        $doData_intermediate_ad_connection->fetch();

        $doData_intermediate_ad_variable_value = OA_Dal::factoryDO('data_intermediate_ad_variable_value');
        $doData_intermediate_ad_variable_value->data_intermediate_ad_connection_id = $doData_intermediate_ad_connection->data_intermediate_ad_connection_id;
        $doData_intermediate_ad_variable_value->find();
        $this->assertEqual($doData_intermediate_ad_variable_value->getRowCount(), 1);
        $doData_intermediate_ad_variable_value->fetch();
        $this->assertEqual($doData_intermediate_ad_variable_value->tracker_variable_id, 1);
        $this->assertEqual($doData_intermediate_ad_variable_value->value,               'foo');

        $doData_intermediate_ad_connection = OA_Dal::factoryDO('data_intermediate_ad_connection');
        $doData_intermediate_ad_connection->server_raw_ip                    = 'localhost';
        $doData_intermediate_ad_connection->server_raw_tracker_impression_id = 3;
        $doData_intermediate_ad_connection->find();
        $this->assertEqual($doData_intermediate_ad_connection->getRowCount(), 1);
        $doData_intermediate_ad_connection->fetch();

        $doData_intermediate_ad_variable_value = OA_Dal::factoryDO('data_intermediate_ad_variable_value');
        $doData_intermediate_ad_variable_value->data_intermediate_ad_connection_id = $doData_intermediate_ad_connection->data_intermediate_ad_connection_id;
        $doData_intermediate_ad_variable_value->find();
        $this->assertEqual($doData_intermediate_ad_variable_value->getRowCount(), 1);
        $doData_intermediate_ad_variable_value->fetch();
        $this->assertEqual($doData_intermediate_ad_variable_value->tracker_variable_id, 2);
        $this->assertEqual($doData_intermediate_ad_variable_value->value,               '12345');

        $doData_intermediate_ad_connection = OA_Dal::factoryDO('data_intermediate_ad_connection');
        $doData_intermediate_ad_connection->server_raw_ip                    = 'localhost';
        $doData_intermediate_ad_connection->server_raw_tracker_impression_id = 4;
        $doData_intermediate_ad_connection->find();
        $this->assertEqual($doData_intermediate_ad_connection->getRowCount(), 1);
        $doData_intermediate_ad_connection->fetch();

        $doData_intermediate_ad_variable_value = OA_Dal::factoryDO('data_intermediate_ad_variable_value');
        $doData_intermediate_ad_variable_value->data_intermediate_ad_connection_id = $doData_intermediate_ad_connection->data_intermediate_ad_connection_id;
        $doData_intermediate_ad_variable_value->find();
        $this->assertEqual($doData_intermediate_ad_variable_value->getRowCount(), 1);
        $doData_intermediate_ad_variable_value->fetch();
        $this->assertEqual($doData_intermediate_ad_variable_value->tracker_variable_id, 2);
        $this->assertEqual($doData_intermediate_ad_variable_value->value,               '12345');

        $doData_intermediate_ad_connection = OA_Dal::factoryDO('data_intermediate_ad_connection');
        $doData_intermediate_ad_connection->server_raw_ip                    = 'localhost';
        $doData_intermediate_ad_connection->server_raw_tracker_impression_id = 5;
        $doData_intermediate_ad_connection->find();
        $this->assertEqual($doData_intermediate_ad_connection->getRowCount(), 1);
        $doData_intermediate_ad_connection->fetch();

        $doData_intermediate_ad_variable_value = OA_Dal::factoryDO('data_intermediate_ad_variable_value');
        $doData_intermediate_ad_variable_value->data_intermediate_ad_connection_id = $doData_intermediate_ad_connection->data_intermediate_ad_connection_id;
        $doData_intermediate_ad_variable_value->find();
        $this->assertEqual($doData_intermediate_ad_variable_value->getRowCount(), 1);
        $doData_intermediate_ad_variable_value->fetch();
        $this->assertEqual($doData_intermediate_ad_variable_value->tracker_variable_id, 3);
        $this->assertEqual($doData_intermediate_ad_variable_value->value,               '12345');

        $doData_intermediate_ad_connection = OA_Dal::factoryDO('data_intermediate_ad_connection');
        $doData_intermediate_ad_connection->server_raw_ip                    = 'localhost';
        $doData_intermediate_ad_connection->server_raw_tracker_impression_id = 6;
        $doData_intermediate_ad_connection->find();
        $this->assertEqual($doData_intermediate_ad_connection->getRowCount(), 1);
        $doData_intermediate_ad_connection->fetch();

        $doData_intermediate_ad_variable_value = OA_Dal::factoryDO('data_intermediate_ad_variable_value');
        $doData_intermediate_ad_variable_value->data_intermediate_ad_connection_id = $doData_intermediate_ad_connection->data_intermediate_ad_connection_id;
        $doData_intermediate_ad_variable_value->find();
        $this->assertEqual($doData_intermediate_ad_variable_value->getRowCount(), 1);
        $doData_intermediate_ad_variable_value->fetch();
        $this->assertEqual($doData_intermediate_ad_variable_value->tracker_variable_id, 3);
        $this->assertEqual($doData_intermediate_ad_variable_value->value,               '');

        $doData_intermediate_ad_connection = OA_Dal::factoryDO('data_intermediate_ad_connection');
        $doData_intermediate_ad_connection->server_raw_ip                    = 'localhost';
        $doData_intermediate_ad_connection->server_raw_tracker_impression_id = 7;
        $doData_intermediate_ad_connection->find();
        $this->assertEqual($doData_intermediate_ad_connection->getRowCount(), 1);
        $doData_intermediate_ad_connection->fetch();

        $doData_intermediate_ad_variable_value = OA_Dal::factoryDO('data_intermediate_ad_variable_value');
        $doData_intermediate_ad_variable_value->data_intermediate_ad_connection_id = $doData_intermediate_ad_connection->data_intermediate_ad_connection_id;
        $doData_intermediate_ad_variable_value->find();
        $this->assertEqual($doData_intermediate_ad_variable_value->getRowCount(), 2);

        $doData_intermediate_ad_variable_value = OA_Dal::factoryDO('data_intermediate_ad_variable_value');
        $doData_intermediate_ad_variable_value->data_intermediate_ad_connection_id = $doData_intermediate_ad_connection->data_intermediate_ad_connection_id;
        $doData_intermediate_ad_variable_value->tracker_variable_id = 4;
        $doData_intermediate_ad_variable_value->find();
        $this->assertEqual($doData_intermediate_ad_variable_value->getRowCount(), 1);
        $doData_intermediate_ad_variable_value->fetch();
        $this->assertEqual($doData_intermediate_ad_variable_value->value,               '129.99');

        $doData_intermediate_ad_variable_value = OA_Dal::factoryDO('data_intermediate_ad_variable_value');
        $doData_intermediate_ad_variable_value->data_intermediate_ad_connection_id = $doData_intermediate_ad_connection->data_intermediate_ad_connection_id;
        $doData_intermediate_ad_variable_value->tracker_variable_id = 5;
        $doData_intermediate_ad_variable_value->find();
        $this->assertEqual($doData_intermediate_ad_variable_value->getRowCount(), 1);
        $doData_intermediate_ad_variable_value->fetch();
        $this->assertEqual($doData_intermediate_ad_variable_value->value,               '1');

        $doData_intermediate_ad_connection = OA_Dal::factoryDO('data_intermediate_ad_connection');
        $doData_intermediate_ad_connection->server_raw_ip                    = 'localhost';
        $doData_intermediate_ad_connection->server_raw_tracker_impression_id = 8;
        $doData_intermediate_ad_connection->find();
        $this->assertEqual($doData_intermediate_ad_connection->getRowCount(), 1);
        $doData_intermediate_ad_connection->fetch();

        $doData_intermediate_ad_variable_value = OA_Dal::factoryDO('data_intermediate_ad_variable_value');
        $doData_intermediate_ad_variable_value->data_intermediate_ad_connection_id = $doData_intermediate_ad_connection->data_intermediate_ad_connection_id;
        $doData_intermediate_ad_variable_value->find();
        $this->assertEqual($doData_intermediate_ad_variable_value->getRowCount(), 2);

        $doData_intermediate_ad_variable_value = OA_Dal::factoryDO('data_intermediate_ad_variable_value');
        $doData_intermediate_ad_variable_value->data_intermediate_ad_connection_id = $doData_intermediate_ad_connection->data_intermediate_ad_connection_id;
        $doData_intermediate_ad_variable_value->tracker_variable_id = 4;
        $doData_intermediate_ad_variable_value->find();
        $this->assertEqual($doData_intermediate_ad_variable_value->getRowCount(), 1);
        $doData_intermediate_ad_variable_value->fetch();
        $this->assertEqual($doData_intermediate_ad_variable_value->value,               '0.99');

        $doData_intermediate_ad_variable_value = OA_Dal::factoryDO('data_intermediate_ad_variable_value');
        $doData_intermediate_ad_variable_value->data_intermediate_ad_connection_id = $doData_intermediate_ad_connection->data_intermediate_ad_connection_id;
        $doData_intermediate_ad_variable_value->tracker_variable_id = 5;
        $doData_intermediate_ad_variable_value->find();
        $this->assertEqual($doData_intermediate_ad_variable_value->getRowCount(), 1);
        $doData_intermediate_ad_variable_value->fetch();
        $this->assertEqual($doData_intermediate_ad_variable_value->value,               '99');

        $doData_intermediate_ad = OA_Dal::factoryDO('data_intermediate_ad');
        $doData_intermediate_ad->date_time = '2008-08-28 14:00:00';
        $doData_intermediate_ad->ad_id     = 1;
        $doData_intermediate_ad->zone_id   = 1;
        $doData_intermediate_ad->find();
        $this->assertEqual($doData_intermediate_ad->getRowCount(), 1);
        $doData_intermediate_ad->fetch();
        $this->assertEqual($doData_intermediate_ad->operation_interval,    60);
        $this->assertEqual($doData_intermediate_ad->operation_interval_id, 110);
        $this->assertEqual($doData_intermediate_ad->interval_start,        '2008-08-28 14:00:00');
        $this->assertEqual($doData_intermediate_ad->interval_end,          '2008-08-28 14:59:59');
        $this->assertEqual($doData_intermediate_ad->creative_id,           0);
        $this->assertEqual($doData_intermediate_ad->requests,              1000);
        $this->assertEqual($doData_intermediate_ad->impressions,           999);
        $this->assertEqual($doData_intermediate_ad->clicks,                5);
        $this->assertEqual($doData_intermediate_ad->conversions,           0);
        $this->assertEqual($doData_intermediate_ad->total_basket_value,    0.0);
        $this->assertEqual($doData_intermediate_ad->total_num_items,       0);

        $doData_intermediate_ad = OA_Dal::factoryDO('data_intermediate_ad');
        $doData_intermediate_ad->date_time = '2008-08-28 15:00:00';
        $doData_intermediate_ad->ad_id     = 1;
        $doData_intermediate_ad->zone_id   = 1;
        $doData_intermediate_ad->find();
        $this->assertEqual($doData_intermediate_ad->getRowCount(), 1);
        $doData_intermediate_ad->fetch();
        $this->assertEqual($doData_intermediate_ad->operation_interval,    60);
        $this->assertEqual($doData_intermediate_ad->operation_interval_id, 111);
        $this->assertEqual($doData_intermediate_ad->interval_start,        '2008-08-28 15:00:00');
        $this->assertEqual($doData_intermediate_ad->interval_end,          '2008-08-28 15:59:59');
        $this->assertEqual($doData_intermediate_ad->creative_id,           0);
        $this->assertEqual($doData_intermediate_ad->requests,              1100);
        $this->assertEqual($doData_intermediate_ad->impressions,           1099);
        $this->assertEqual($doData_intermediate_ad->clicks,                8);
        $this->assertEqual($doData_intermediate_ad->conversions,           6);
        $this->assertEqual($doData_intermediate_ad->total_basket_value,    130.98);
        $this->assertEqual($doData_intermediate_ad->total_num_items,       100);

        $doData_summary_ad_hourly = OA_Dal::factoryDO('data_summary_ad_hourly');
        $doData_summary_ad_hourly->date_time = '2008-08-28 14:00:00';
        $doData_summary_ad_hourly->ad_id     = 1;
        $doData_summary_ad_hourly->zone_id   = 1;
        $doData_summary_ad_hourly->find();
        $this->assertEqual($doData_summary_ad_hourly->getRowCount(), 1);
        $doData_summary_ad_hourly->fetch();
        $this->assertEqual($doData_summary_ad_hourly->creative_id,        0);
        $this->assertEqual($doData_summary_ad_hourly->requests,           1000);
        $this->assertEqual($doData_summary_ad_hourly->impressions,        999);
        $this->assertEqual($doData_summary_ad_hourly->clicks,             5);
        $this->assertEqual($doData_summary_ad_hourly->conversions,        0);
        $this->assertEqual($doData_summary_ad_hourly->total_basket_value, 0.0);
        $this->assertEqual($doData_summary_ad_hourly->total_num_items,    0);
        $this->assertNull($doData_summary_ad_hourly->total_revenue);
        $this->assertNull($doData_summary_ad_hourly->total_cost);
        $this->assertNull($doData_summary_ad_hourly->total_techcost);

        $doData_summary_ad_hourly = OA_Dal::factoryDO('data_summary_ad_hourly');
        $doData_summary_ad_hourly->date_time = '2008-08-28 15:00:00';
        $doData_summary_ad_hourly->ad_id     = 1;
        $doData_summary_ad_hourly->zone_id   = 1;
        $doData_summary_ad_hourly->find();
        $this->assertEqual($doData_summary_ad_hourly->getRowCount(), 1);
        $doData_summary_ad_hourly->fetch();
        $this->assertEqual($doData_summary_ad_hourly->creative_id,        0);
        $this->assertEqual($doData_summary_ad_hourly->requests,           1100);
        $this->assertEqual($doData_summary_ad_hourly->impressions,        1099);
        $this->assertEqual($doData_summary_ad_hourly->clicks,             8);
        $this->assertEqual($doData_summary_ad_hourly->conversions,        6);
        $this->assertEqual($doData_summary_ad_hourly->total_basket_value, 130.98);
        $this->assertEqual($doData_summary_ad_hourly->total_num_items,    100);
        $this->assertNull($doData_summary_ad_hourly->total_revenue);
        $this->assertNull($doData_summary_ad_hourly->total_cost);
        $this->assertNull($doData_summary_ad_hourly->total_techcost);

        $doData_summary_zone_impression_history = OA_Dal::factoryDO('data_summary_zone_impression_history');
        $doData_summary_zone_impression_history->find();
        $this->assertEqual($doData_summary_zone_impression_history->getRowCount(), 2);

        $doData_summary_zone_impression_history = OA_Dal::factoryDO('data_summary_zone_impression_history');
        $doData_summary_zone_impression_history->interval_start = '2008-08-28 14:00:00';
        $doData_summary_zone_impression_history->find();
        $this->assertEqual($doData_summary_zone_impression_history->getRowCount(), 1);
        $doData_summary_zone_impression_history->fetch();
        $this->assertEqual($doData_summary_zone_impression_history->operation_interval,    60);
        $this->assertEqual($doData_summary_zone_impression_history->operation_interval_id, 110);
        $this->assertEqual($doData_summary_zone_impression_history->interval_start,        '2008-08-28 14:00:00');
        $this->assertEqual($doData_summary_zone_impression_history->interval_end,          '2008-08-28 14:59:59');
        $this->assertEqual($doData_summary_zone_impression_history->zone_id,               1);
        $this->assertNull($doData_summary_zone_impression_history->forecast_impressions);
        $this->assertEqual($doData_summary_zone_impression_history->actual_impressions,    999);
        $this->assertEqual($doData_summary_zone_impression_history->est,                   0);

        $doData_summary_zone_impression_history = OA_Dal::factoryDO('data_summary_zone_impression_history');
        $doData_summary_zone_impression_history->interval_start = '2008-08-28 15:00:00';
        $doData_summary_zone_impression_history->find();
        $this->assertEqual($doData_summary_zone_impression_history->getRowCount(), 1);
        $doData_summary_zone_impression_history->fetch();
        $this->assertEqual($doData_summary_zone_impression_history->operation_interval,    60);
        $this->assertEqual($doData_summary_zone_impression_history->operation_interval_id, 111);
        $this->assertEqual($doData_summary_zone_impression_history->interval_start,        '2008-08-28 15:00:00');
        $this->assertEqual($doData_summary_zone_impression_history->interval_end,          '2008-08-28 15:59:59');
        $this->assertEqual($doData_summary_zone_impression_history->zone_id,               1);
        $this->assertNull($doData_summary_zone_impression_history->forecast_impressions);
        $this->assertEqual($doData_summary_zone_impression_history->actual_impressions,    1099);
        $this->assertEqual($doData_summary_zone_impression_history->est,                   0);

        /**********************************************************************/

        // Remove the installed plugin
        TestEnv::uninstallPluginPackage('openXDeliveryLog', false);
    }

}

?>