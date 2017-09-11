<?php

/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
*/

require_once MAX_PATH . '/lib/max/Delivery/log.php';
require_once MAX_PATH . '/lib/max/Delivery/cache.php';
require_once LIB_PATH . '/OperationInterval.php';

/**
 * A class for performing end-to-end integration testing of the delivery logging
 * functions MAX_Delivery_log_logAdRequest(), MAX_Delivery_log_logAdImpression()
 * and MAX_Delivery_log_logAdClick().
 *
 * @package    MaxDelivery
 * @subpackage TestSuite
 */
class Test_Max_Delivery_Log_RMC extends UnitTestCase
{
    /**
     * The constructor method.
     */
    function __construct()
    {
        parent::__construct();
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

            if ($table == 'data_bkt_r') {
                // Request logging is disabled by default. Nothing should have been logged by now
                $this->assertEqual($rows, 0);

                // Enable it
                $GLOBALS['_MAX']['CONF']['logging']['adRequests'] = true;
                unset($GLOBALS['_MAX']['deliveryData']['Plugin_deliveryDataPrepare_oxDeliveryDataPrepare_dataCommon']);
                call_user_func_array($function, array(1, 1));

                // Now ensure that the data was logged correctly
                $doData_bkt->find();
                $rows = $doData_bkt->getRowCount();
            }

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