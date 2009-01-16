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
 * function MAX_Delivery_log_logVariableValues().
 *
 * @package    MaxDelivery
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew.hill@openx.org>
 * @author     Monique Szpak <monique.szpak@openx.org>
 */
class Test_Max_Delivery_Log_A_Var extends UnitTestCase
{
    /**
     * The constructor method.
     */
    function Test_Max_Delivery_Log_A_Var()
    {
        $this->UnitTestCase();
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