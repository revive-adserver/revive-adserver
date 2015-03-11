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
require_once LIB_PATH . '/OperationInterval.php';

/**
 * A class for performing end-to-end integration testing of the delivery logging
 * function MAX_Delivery_log_logVariableValues().
 *
 * @package    MaxDelivery
 * @subpackage TestSuite
 */
class Test_Max_Delivery_Log_A_Var extends UnitTestCase
{
    /**
     * The constructor method.
     */
    function __construct()
    {
        parent::__construct();
    }

    /**
     * A method to test the MAX_Delivery_log_logVariableValues() function.
     */
    function test_MAX_Delivery_log_logVariableValues()
    {
        $aConf =& $GLOBALS['_MAX']['CONF'];
        $aConf['maintenance']['operationInterval'] = 60;

        $GLOBALS['_MAX']['NOW'] = time();
        $oNowDate = new Date($GLOBALS['_MAX']['NOW']);

        // Test to ensure that the openXDeliveryLog plugin's data bucket
        // table does not exist
        $oTable = new OA_DB_Table();
        $tableExists = $oTable->extistsTable($aConf['table']['prefix'] . 'data_bkt_a_var');
        $this->assertFalse($tableExists);

        // Test calling the main logging function without any plugins installed,
        // to ensure that this does not result in any kind of error
        $aVariables = array(
            55 => array(
                'variable_id'  => 55,
                'tracker_id'   => 1,
                'name'         => 'fooVar',
                'type'         => 'string',
                'variablecode' => ''
            ),
            66 => array(
                'variable_id'  => 66,
                'tracker_id'   => 1,
                'name'         => 'barVar',
                'type'         => 'string',
                'variablecode' => ''
            ),
        );
        $_GET['fooVar'] = 'foo';
        $_GET['barVar'] = 'bar';
        MAX_Delivery_log_logVariableValues($aVariables, 1, 1, 'singleDB');

        // Install the openXDeliveryLog plugin
        TestEnv::installPluginPackage('openXDeliveryLog', false);

        // Test to ensure that the openXDeliveryLog plugin's data bucket
        // table now does exist
        $tableExists = $oTable->extistsTable($aConf['table']['prefix'] . 'data_bkt_a_var');
        $this->assertTrue($tableExists);

        // Ensure that there are is nothing logged in the data bucket table
        $doData_bkt_a_var = OA_Dal::factoryDO('data_bkt_a_var');
        $doData_bkt_a_var->find();
        $rows = $doData_bkt_a_var->getRowCount();
        $this->assertEqual($rows, 0);

        // Call the variable value logging function
        MAX_Delivery_log_logVariableValues($aVariables, 1, 1, 'singleDB');

        // Ensure that the data was logged correctly
        $doData_bkt_a_var = OA_Dal::factoryDO('data_bkt_a_var');
        $doData_bkt_a_var->find();
        $rows = $doData_bkt_a_var->getRowCount();
        $this->assertEqual($rows, 2);

        $doData_bkt_a_var = OA_Dal::factoryDO('data_bkt_a_var');
        $doData_bkt_a_var->server_conv_id      = 1;
        $doData_bkt_a_var->server_raw_ip       = 'singleDB';
        $doData_bkt_a_var->tracker_variable_id = 55;
        $doData_bkt_a_var->find();
        $rows = $doData_bkt_a_var->getRowCount();
        $this->assertEqual($rows, 1);
        $doData_bkt_a_var->fetch();
        $this->assertEqual($doData_bkt_a_var->value,     'foo');
        $this->assertEqual($doData_bkt_a_var->date_time, $oNowDate->format('%Y-%m-%d %H:%M:%S'));


        // Uninstall the openXDeliveryLog plugin
        TestEnv::uninstallPluginPackage('openXDeliveryLog', false);

        // Restore the test configuration file
        TestEnv::restoreConfig();

    }

}

?>