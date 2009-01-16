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

require_once MAX_PATH . '/lib/max/Delivery/log.php';
require_once LIB_PATH . '/OperationInterval.php';

/**
 * A class for performing end-to-end integration testing of the delivery logging
 * functions MAX_Delivery_log_logAdRequest(), MAX_Delivery_log_logAdImpression()
 * and MAX_Delivery_log_logAdClick().
 *
 * @package    MaxDelivery
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew.hill@openx.org>
 */
class Test_Max_Delivery_Log_RMC extends UnitTestCase
{
    /**
     * The constructor method.
     */
    function Test_Max_Delivery_Log_RMC()
    {
        $this->UnitTestCase();
    }

    /**
     * A method to test the MAX_Delivery_log_logAdRequest(),
     * MAX_Delivery_log_logAdImpression() and MAX_Delivery_log_logAdClick()
     * functions.
     */
    function testRequestImpressionClickFunction()
    {
        $aConf =& $GLOBALS['_MAX']['CONF'];
        $aConf['maintenance']['operationInterval'] = 60;

        $GLOBALS['_MAX']['NOW'] = time();
        $oNowDate = new Date($GLOBALS['_MAX']['NOW']);
        $aDates = OX_OperationInterval::convertDateToOperationIntervalStartAndEndDates($oNowDate);
        $intervalStart = $aDates['start']->format('%Y-%m-%d %H:%M:%S');

        $aTables = array(
            'MAX_Delivery_log_logAdRequest'    => 'data_bkt_r',
            'MAX_Delivery_log_logAdImpression' => 'data_bkt_m',
            'MAX_Delivery_log_logAdClick'      => 'data_bkt_c'
        );

        foreach ($aTables as $function => $table) {

            // Test to ensure that the openXDeliveryLog plugin's data bucket
            // table does not exist
            $oTable = new OA_DB_Table();
            $tableExists = $oTable->extistsTable($aConf['table']['prefix'] . $table);
            $this->assertFalse($tableExists);

            // Test calling the main logging function without any plugins installed,
            // to ensure that this does not result in any kind of error
            unset($GLOBALS['_MAX']['deliveryData']['Plugin_deliveryDataPrepare_oxDeliveryDataPrepare_dataCommon']);
            call_user_func_array($function, array(1, 1));

        }

        // Install the openXDeliveryLog plugin
        TestEnv::installPluginPackage('openXDeliveryLog', false);

        foreach ($aTables as $function => $table) {

            // Test to ensure that the openXDeliveryLog plugin's data bucket
            // table now does exist
            $tableExists = $oTable->extistsTable($aConf['table']['prefix'] . $table);
            $this->assertTrue($tableExists);

            // Ensure that there are is nothing logged in the data bucket table
            $doData_bkt = OA_Dal::factoryDO($table);
            $doData_bkt->find();
            $rows = $doData_bkt->getRowCount();
            $this->assertEqual($rows, 0);

            // Call the main logging function
            unset($GLOBALS['_MAX']['deliveryData']['Plugin_deliveryDataPrepare_oxDeliveryDataPrepare_dataCommon']);
            call_user_func_array($function, array(1, 1));

            // Ensure that the data was logged correctly
            $doData_bkt = OA_Dal::factoryDO($table);
            $doData_bkt->find();
            $rows = $doData_bkt->getRowCount();
            $this->assertEqual($rows, 1);

            $doData_bkt = OA_Dal::factoryDO($table);
            $doData_bkt->creative_id = 1;
            $doData_bkt->zone_id     = 1;
            $doData_bkt->find();
            $rows = $doData_bkt->getRowCount();
            $this->assertEqual($rows, 1);
            $doData_bkt->fetch();
            $this->assertEqual($doData_bkt->count,          1);
            $this->assertEqual($doData_bkt->interval_start, $intervalStart);

            // Call the main logging function again
            unset($GLOBALS['_MAX']['deliveryData']['Plugin_deliveryDataPrepare_oxDeliveryDataPrepare_dataCommon']);
            call_user_func_array($function, array(1, 1));

            // Ensure that the data was logged correctly
            $doData_bkt = OA_Dal::factoryDO($table);
            $doData_bkt->find();
            $rows = $doData_bkt->getRowCount();
            $this->assertEqual($rows, 1);

            $doData_bkt = OA_Dal::factoryDO($table);
            $doData_bkt->creative_id = 1;
            $doData_bkt->zone_id     = 1;
            $doData_bkt->find();
            $rows = $doData_bkt->getRowCount();
            $this->assertEqual($rows, 1);
            $doData_bkt->fetch();
            $this->assertEqual($doData_bkt->count,          2);
            $this->assertEqual($doData_bkt->interval_start, $intervalStart);

            // Call the main logging function again, but with a differen
            // creative/zone pair
            unset($GLOBALS['_MAX']['deliveryData']['Plugin_deliveryDataPrepare_oxDeliveryDataPrepare_dataCommon']);
            call_user_func_array($function, array(2, 1));

            // Ensure that the data was logged correctly
            $doData_bkt = OA_Dal::factoryDO($table);
            $doData_bkt->find();
            $rows = $doData_bkt->getRowCount();
            $this->assertEqual($rows, 2);

            $doData_bkt = OA_Dal::factoryDO($table);
            $doData_bkt->creative_id = 1;
            $doData_bkt->zone_id     = 1;
            $doData_bkt->find();
            $rows = $doData_bkt->getRowCount();
            $this->assertEqual($rows, 1);
            $doData_bkt->fetch();
            $this->assertEqual($doData_bkt->count,          2);
            $this->assertEqual($doData_bkt->interval_start, $intervalStart);

            $doData_bkt = OA_Dal::factoryDO($table);
            $doData_bkt->creative_id = 2;
            $doData_bkt->zone_id     = 1;
            $doData_bkt->find();
            $rows = $doData_bkt->getRowCount();
            $this->assertEqual($rows, 1);
            $doData_bkt->fetch();
            $this->assertEqual($doData_bkt->count,          1);
            $this->assertEqual($doData_bkt->interval_start, $intervalStart);

        }

        // Uninstall the openXDeliveryLog plugin
        TestEnv::uninstallPluginPackage('openXDeliveryLog', false);

        // Restore the test configuration file
        TestEnv::restoreConfig();
    }

}

?>