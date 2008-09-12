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
 * A class for testing the rejectEmptyVarConversions() method of the
 * MySQL / PgSQL OX_Dal_Maintenance_Statistics classes.
 *
 * @package    OpenXDal
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew.hill@openx.org>
 */
class Test_OX_Dal_Maintenance_Statistics_rejectEmptyVarConversions extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function Test_OX_Dal_Maintenance_Statistics_rejectEmptyVarConversions()
    {
        $this->UnitTestCase();

        // Prepare the MSE DAL for use in the tests
        $oFactory = new OX_Dal_Maintenance_Statistics_Factory();
        $this->oDal = $oFactory->factory();
    }

    /**********************************************************************/
    /* TESTS WHERE THERE ARE NO VARIABLE VALUES BEING TRACKED             */
    /**********************************************************************/

    /**
     * A method to test the rejectEmptyVarConversions() method:
     *
     * - With no conversions in the system.
     */
    function testRejectEmptyVarConversions_1()
    {
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-05 12:59:59');

        // De-duplicate
        $this->oDal->rejectEmptyVarConversions($oStartDate, $oEndDate);

        // Test the results
        $rows = $this->_countDataIntermediateAdConnections();
        $this->assertEqual($rows, 0);
    }

    /**
     * A method to test the rejectEmptyVarConversions() method:
     *
     * - With a conversion in the system, but no tracked variable
     *   value(s) attached (or logged).
     *
     * Tests to ensure the status remains as "approved".
     */
    function testRejectEmptyVarConversions_2()
    {
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-05 12:59:59');

        // Insert a connection at 12:10:00, from a click on ad ID 5, zone ID 6, at 12:09
        $aData = array(
            'server_raw_tracker_impression_id' => 1,
            'server_raw_ip'                    => 'singleDB',
            'tracker_id'                       => 1,
            'tracker_date_time'                => '2005-09-05 12:10:00',
            'connection_date_time'             => '2005-09-05 12:09:00',
            'ad_id'                            => 5,
            'zone_id'                          => 6,
            'connection_action'                => MAX_CONNECTION_AD_CLICK,
            'connection_window'                => 1209600,
            'connection_status'                => MAX_CONNECTION_STATUS_APPROVED
        );
        $this->_insertDataIntermediateAdConnection($aData);

        // De-duplicate
        $this->oDal->rejectEmptyVarConversions($oStartDate, $oEndDate);

        // Test the results
        $rows = $this->_countDataIntermediateAdConnections();
        $this->assertEqual($rows, 1);

        $rows = $this->_countDataIntermediateAdConnectionsApproved();
        $this->assertEqual($rows, 1);

        // Clean up
        DataGenerator::cleanUp();
    }

    /**********************************************************************/
    /* TESTS WHERE THERE IS A VARIABLE VALUE BEING TRACKED THAT IS        */
    /* PERMITTED TO BE EMPTY                                              */
    /**********************************************************************/

    /**
     * A method to test the rejectEmptyVarConversions() method:
     *
     * - With a conversion in the system, a tracked variable value
     *   attached that may be empty, and where the value has not been
     *   logged.
     *
     * Tests to ensure the status remains as "approved".
     */
    function testRejectEmptyVarConversions_3()
    {
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-05 12:59:59');

        // Prepare the variable value, which may be empty, that should
        // be tracked with Tracker ID 1
        $aData = array(
            'trackerid'       => 1,
            'name'            => 'Empty Permitted Variable',
            'reject_if_empty' => 0
        );
        $this->_insertVariable($aData);

        // Insert a connection at 12:10:00, from a click on ad ID 5, zone ID 6, at 12:09
        $aData = array(
            'server_raw_tracker_impression_id' => 1,
            'server_raw_ip'                    => 'singleDB',
            'tracker_id'                       => 1,
            'tracker_date_time'                => '2005-09-05 12:10:00',
            'connection_date_time'             => '2005-09-05 12:09:00',
            'ad_id'                            => 5,
            'zone_id'                          => 6,
            'connection_action'                => MAX_CONNECTION_AD_CLICK,
            'connection_window'                => 1209600,
            'connection_status'                => MAX_CONNECTION_STATUS_APPROVED
        );
        $conversionId = $this->_insertDataIntermediateAdConnection($aData);

        // Do NOT insert any logged variable value - it has not been
        // tracked correctly in this test, for some reason

        // De-duplicate
        $this->oDal->rejectEmptyVarConversions($oStartDate, $oEndDate);

        // Test the results
        $rows = $this->_countDataIntermediateAdConnections();
        $this->assertEqual($rows, 1);

        $rows = $this->_countDataIntermediateAdConnectionsApproved();
        $this->assertEqual($rows, 1);

        // Clean up
        DataGenerator::cleanUp();
    }

    /**
     * A method to test the rejectEmptyVarConversions() method:
     *
     * - With a conversion in the system, a tracked variable value
     *   attached that may be empty, and where the value logged is
     *   the NULL value.
     *
     * Tests to ensure the status remains as "approved".
     */
    function testRejectEmptyVarConversions_4()
    {
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-05 12:59:59');

        // Prepare the variable value, which may be empty, that should
        // be tracked with Tracker ID 1
        $aData = array(
            'trackerid'       => 1,
            'name'            => 'Empty Permitted Variable',
            'reject_if_empty' => 0
        );
        $this->_insertVariable($aData);

        // Insert a connection at 12:10:00, from a click on ad ID 5, zone ID 6, at 12:09
        $aData = array(
            'server_raw_tracker_impression_id' => 1,
            'server_raw_ip'                    => 'singleDB',
            'tracker_id'                       => 1,
            'tracker_date_time'                => '2005-09-05 12:10:00',
            'connection_date_time'             => '2005-09-05 12:09:00',
            'ad_id'                            => 5,
            'zone_id'                          => 6,
            'connection_action'                => MAX_CONNECTION_AD_CLICK,
            'connection_window'                => 1209600,
            'connection_status'                => MAX_CONNECTION_STATUS_APPROVED
        );
        $conversionId = $this->_insertDataIntermediateAdConnection($aData);

        // Insert the variable value for the conversion
        $aData = array(
            'data_intermediate_ad_connection_id' => $conversionId,
            'tracker_variable_id'                => 1,
            'value'                              => NULL
        );
        $this->_insertDataIntermediateAdVariableValue($aData);

        // De-duplicate
        $this->oDal->rejectEmptyVarConversions($oStartDate, $oEndDate);

        // Test the results
        $rows = $this->_countDataIntermediateAdConnections();
        $this->assertEqual($rows, 1);

        $rows = $this->_countDataIntermediateAdConnectionsApproved();
        $this->assertEqual($rows, 1);

        // Clean up
        DataGenerator::cleanUp();
    }

    /**
     * A method to test the rejectEmptyVarConversions() method:
     *
     * - With a conversion in the system, a tracked variable value
     *   attached that may be empty, and where the value logged is
     *   the empty string value.
     *
     * Tests to ensure the status remains as "approved".
     */
    function testRejectEmptyVarConversions_5()
    {
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-05 12:59:59');

        // Prepare the variable value, which may be empty, that should
        // be tracked with Tracker ID 1
        $aData = array(
            'trackerid'       => 1,
            'name'            => 'Empty Permitted Variable',
            'reject_if_empty' => 0
        );
        $this->_insertVariable($aData);

        // Insert a connection at 12:10:00, from a click on ad ID 5, zone ID 6, at 12:09
        $aData = array(
            'server_raw_tracker_impression_id' => 1,
            'server_raw_ip'                    => 'singleDB',
            'tracker_id'                       => 1,
            'tracker_date_time'                => '2005-09-05 12:10:00',
            'connection_date_time'             => '2005-09-05 12:09:00',
            'ad_id'                            => 5,
            'zone_id'                          => 6,
            'connection_action'                => MAX_CONNECTION_AD_CLICK,
            'connection_window'                => 1209600,
            'connection_status'                => MAX_CONNECTION_STATUS_APPROVED
        );
        $conversionId = $this->_insertDataIntermediateAdConnection($aData);

        // Insert the variable value for the conversion
        $aData = array(
            'data_intermediate_ad_connection_id' => $conversionId,
            'tracker_variable_id'                => 1,
            'value'                              => ''
        );
        $this->_insertDataIntermediateAdVariableValue($aData);

        // De-duplicate
        $this->oDal->rejectEmptyVarConversions($oStartDate, $oEndDate);

        // Test the results
        $rows = $this->_countDataIntermediateAdConnections();
        $this->assertEqual($rows, 1);

        $rows = $this->_countDataIntermediateAdConnectionsApproved();
        $this->assertEqual($rows, 1);

        // Clean up
        DataGenerator::cleanUp();
    }

    /**
     * A method to test the rejectEmptyVarConversions() method:
     *
     * - With a conversion in the system, a tracked variable value
     *   attached that may be empty, and where the value logged is
     *   the a non-empty value.
     *
     * Tests to ensure the status remains as "approved".
     */
    function testRejectEmptyVarConversions_6()
    {
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-05 12:59:59');

        // Prepare the variable value, which may be empty, that should
        // be tracked with Tracker ID 1
        $aData = array(
            'trackerid'       => 1,
            'name'            => 'Empty Permitted Variable',
            'reject_if_empty' => 0
        );
        $this->_insertVariable($aData);

        // Insert a connection at 12:10:00, from a click on ad ID 5, zone ID 6, at 12:09
        $aData = array(
            'server_raw_tracker_impression_id' => 1,
            'server_raw_ip'                    => 'singleDB',
            'tracker_id'                       => 1,
            'tracker_date_time'                => '2005-09-05 12:10:00',
            'connection_date_time'             => '2005-09-05 12:09:00',
            'ad_id'                            => 5,
            'zone_id'                          => 6,
            'connection_action'                => MAX_CONNECTION_AD_CLICK,
            'connection_window'                => 1209600,
            'connection_status'                => MAX_CONNECTION_STATUS_APPROVED
        );
        $conversionId = $this->_insertDataIntermediateAdConnection($aData);

        // Insert the variable value for the conversion
        $aData = array(
            'data_intermediate_ad_connection_id' => $conversionId,
            'tracker_variable_id'                => 1,
            'value'                              => 'value'
        );
        $this->_insertDataIntermediateAdVariableValue($aData);

        // De-duplicate
        $this->oDal->rejectEmptyVarConversions($oStartDate, $oEndDate);

        // Test the results
        $rows = $this->_countDataIntermediateAdConnections();
        $this->assertEqual($rows, 1);

        $rows = $this->_countDataIntermediateAdConnectionsApproved();
        $this->assertEqual($rows, 1);

        // Clean up
        DataGenerator::cleanUp();
    }

    /**********************************************************************/
    /* TESTS WHERE THERE IS A VARIABLE VALUE BEING TRACKED THAT IS        */
    /* NOT PERMITTED TO BE EMPTY                                          */
    /**********************************************************************/

    /**
     * A method to test the rejectEmptyVarConversions() method:
     *
     * - With a conversion in the system, a tracked variable value
     *   attached that may not be empty, and where the value has not
     *   been logged.
     *
     * Tests to ensure the status remains as "approved".
     */
    function testRejectEmptyVarConversions_7()
    {
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-05 12:59:59');

        // Prepare the variable value, which may not be empty, that
        // should be tracked with Tracker ID 1
        $aData = array(
            'trackerid'       => 1,
            'name'            => 'Empty Not Permitted Variable',
            'reject_if_empty' => 1
        );
        $this->_insertVariable($aData);

        // Insert a connection at 12:10:00, from a click on ad ID 5, zone ID 6, at 12:09
        $aData = array(
            'server_raw_tracker_impression_id' => 1,
            'server_raw_ip'                    => 'singleDB',
            'tracker_id'                       => 1,
            'tracker_date_time'                => '2005-09-05 12:10:00',
            'connection_date_time'             => '2005-09-05 12:09:00',
            'ad_id'                            => 5,
            'zone_id'                          => 6,
            'connection_action'                => MAX_CONNECTION_AD_CLICK,
            'connection_window'                => 1209600,
            'connection_status'                => MAX_CONNECTION_STATUS_APPROVED
        );
        $conversionId = $this->_insertDataIntermediateAdConnection($aData);

        // Do NOT insert any logged variable value - it has not been
        // tracked correctly in this test, for some reason

        // De-duplicate
        $this->oDal->rejectEmptyVarConversions($oStartDate, $oEndDate);

        // Test the results
        $rows = $this->_countDataIntermediateAdConnections();
        $this->assertEqual($rows, 1);

        $rows = $this->_countDataIntermediateAdConnectionsApproved();
        $this->assertEqual($rows, 0);

        $rows = $this->_countDataIntermediateAdConnectionsRejected();
        $this->assertEqual($rows, 1);

        // Clean up
        DataGenerator::cleanUp();
    }

    /**
     * A method to test the rejectEmptyVarConversions() method:
     *
     * - With a conversion in the system, a tracked variable value
     *   attached that may not be empty, and where the value logged
     *   is the NULL value.
     *
     * Tests to ensure the status remains as "approved".
     */
    function testRejectEmptyVarConversions_8()
    {
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-05 12:59:59');

        // Prepare the variable value, which may not be empty, that
        // should be tracked with Tracker ID 1
        $aData = array(
            'trackerid'       => 1,
            'name'            => 'Empty Not Permitted Variable',
            'reject_if_empty' => 1
        );
        $this->_insertVariable($aData);

        // Insert a connection at 12:10:00, from a click on ad ID 5, zone ID 6, at 12:09
        $aData = array(
            'server_raw_tracker_impression_id' => 1,
            'server_raw_ip'                    => 'singleDB',
            'tracker_id'                       => 1,
            'tracker_date_time'                => '2005-09-05 12:10:00',
            'connection_date_time'             => '2005-09-05 12:09:00',
            'ad_id'                            => 5,
            'zone_id'                          => 6,
            'connection_action'                => MAX_CONNECTION_AD_CLICK,
            'connection_window'                => 1209600,
            'connection_status'                => MAX_CONNECTION_STATUS_APPROVED
        );
        $conversionId = $this->_insertDataIntermediateAdConnection($aData);

        // Insert the variable value for the conversion
        $aData = array(
            'data_intermediate_ad_connection_id' => $conversionId,
            'tracker_variable_id'                => 1,
            'value'                              => NULL
        );
        $this->_insertDataIntermediateAdVariableValue($aData);

        // De-duplicate
        $this->oDal->rejectEmptyVarConversions($oStartDate, $oEndDate);

        // Test the results
        $rows = $this->_countDataIntermediateAdConnections();
        $this->assertEqual($rows, 1);

        $rows = $this->_countDataIntermediateAdConnectionsApproved();
        $this->assertEqual($rows, 0);

        $rows = $this->_countDataIntermediateAdConnectionsRejected();
        $this->assertEqual($rows, 1);

        // Clean up
        DataGenerator::cleanUp();
    }

    /**
     * A method to test the rejectEmptyVarConversions() method:
     *
     * - With a conversion in the system, a tracked variable value
     *   attached that may not be empty, and where the value logged
     *   is the empty string value.
     *
     * Tests to ensure the status remains as "approved".
     */
    function testRejectEmptyVarConversions_9()
    {
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-05 12:59:59');

        // Prepare the variable value, which may not be empty, that
        // should be tracked with Tracker ID 1
        $aData = array(
            'trackerid'       => 1,
            'name'            => 'Empty Not Permitted Variable',
            'reject_if_empty' => 1
        );
        $this->_insertVariable($aData);

        // Insert a connection at 12:10:00, from a click on ad ID 5, zone ID 6, at 12:09
        $aData = array(
            'server_raw_tracker_impression_id' => 1,
            'server_raw_ip'                    => 'singleDB',
            'tracker_id'                       => 1,
            'tracker_date_time'                => '2005-09-05 12:10:00',
            'connection_date_time'             => '2005-09-05 12:09:00',
            'ad_id'                            => 5,
            'zone_id'                          => 6,
            'connection_action'                => MAX_CONNECTION_AD_CLICK,
            'connection_window'                => 1209600,
            'connection_status'                => MAX_CONNECTION_STATUS_APPROVED
        );
        $conversionId = $this->_insertDataIntermediateAdConnection($aData);

        // Insert the variable value for the conversion
        $aData = array(
            'data_intermediate_ad_connection_id' => $conversionId,
            'tracker_variable_id'                => 1,
            'value'                              => ''
        );
        $this->_insertDataIntermediateAdVariableValue($aData);

        // De-duplicate
        $this->oDal->rejectEmptyVarConversions($oStartDate, $oEndDate);

        // Test the results
        $rows = $this->_countDataIntermediateAdConnections();
        $this->assertEqual($rows, 1);

        $rows = $this->_countDataIntermediateAdConnectionsApproved();
        $this->assertEqual($rows, 0);

        $rows = $this->_countDataIntermediateAdConnectionsRejected();
        $this->assertEqual($rows, 1);

        // Clean up
        DataGenerator::cleanUp();
    }

    /**
     * A method to test the rejectEmptyVarConversions() method:
     *
     * - With a conversion in the system, a tracked variable value
     *   attached that may not be empty, and where the value logged
     *   is the a non-empty value.
     *
     * Tests to ensure the status remains as "approved".
     */
    function testRejectEmptyVarConversions_10()
    {
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-05 12:59:59');

        // Prepare the variable value, which may not be empty, that
        // should be tracked with Tracker ID 1
        $aData = array(
            'trackerid'       => 1,
            'name'            => 'Empty Not Permitted Variable',
            'reject_if_empty' => 1
        );
        $this->_insertVariable($aData);

        // Insert a connection at 12:10:00, from a click on ad ID 5, zone ID 6, at 12:09
        $aData = array(
            'server_raw_tracker_impression_id' => 1,
            'server_raw_ip'                    => 'singleDB',
            'tracker_id'                       => 1,
            'tracker_date_time'                => '2005-09-05 12:10:00',
            'connection_date_time'             => '2005-09-05 12:09:00',
            'ad_id'                            => 5,
            'zone_id'                          => 6,
            'connection_action'                => MAX_CONNECTION_AD_CLICK,
            'connection_window'                => 1209600,
            'connection_status'                => MAX_CONNECTION_STATUS_APPROVED
        );
        $conversionId = $this->_insertDataIntermediateAdConnection($aData);

        // Insert the variable value for the conversion
        $aData = array(
            'data_intermediate_ad_connection_id' => $conversionId,
            'tracker_variable_id'                => 1,
            'value'                              => 'value'
        );
        $this->_insertDataIntermediateAdVariableValue($aData);

        // De-duplicate
        $this->oDal->rejectEmptyVarConversions($oStartDate, $oEndDate);

        // Test the results
        $rows = $this->_countDataIntermediateAdConnections();
        $this->assertEqual($rows, 1);

        $rows = $this->_countDataIntermediateAdConnectionsApproved();
        $this->assertEqual($rows, 1);

        // Clean up
        DataGenerator::cleanUp();
    }

    /**********************************************************************/
    /* HELPER METHODS                                                     */
    /**********************************************************************/

    /**
     * A private method for the test class to count the number of
     * conversions in the data_intermediate_ad_connection table.
     *
     * @access private
     * @return integer The number of rows (in total) in the
     *                 data_intermediate_ad_connection table.
     */
    private function _countDataIntermediateAdConnections()
    {
        $doData_intermediate_ad_connection = OA_Dal::factoryDO('data_intermediate_ad_connection');
        $doData_intermediate_ad_connection->find();
        $rows = $doData_intermediate_ad_connection->getRowCount();
        return $rows;
    }

    /**
     * A private method for the test class to count the number of
     * "approved" conversions in the data_intermediate_ad_connection
     * table.
     *
     * @access private
     * @return integer The number of rows (in total) in the
     *                 data_intermediate_ad_connection table
     *                 where the status of the conversions are
     *                 "approved".
     */
    private function _countDataIntermediateAdConnectionsApproved()
    {
        $doData_intermediate_ad_connection = OA_Dal::factoryDO('data_intermediate_ad_connection');
        $doData_intermediate_ad_connection->connection_status = MAX_CONNECTION_STATUS_APPROVED;
        $doData_intermediate_ad_connection->find();
        $rows = $doData_intermediate_ad_connection->getRowCount();
        return $rows;
    }

    /**
     * A private method for the test class to count the number of
     * "duplicate" conversions in the data_intermediate_ad_connection
     * table.
     *
     * @access private
     * @return integer The number of rows (in total) in the
     *                 data_intermediate_ad_connection table
     *                 where the status of the conversions are
     *                 "disapproved".
     */
    private function _countDataIntermediateAdConnectionsRejected()
    {
        $doData_intermediate_ad_connection = OA_Dal::factoryDO('data_intermediate_ad_connection');
        $doData_intermediate_ad_connection->connection_status = MAX_CONNECTION_STATUS_DISAPPROVED;
        $doData_intermediate_ad_connection->find();
        $rows = $doData_intermediate_ad_connection->getRowCount();
        return $rows;
    }

    /**
     * A private method to insert a variable into the variables table,
     * so that the de-duplication process can determine what variables
     * should be associated with conversions, and how to handles them
     * with regards to de-duplication.
     *
     * @access private
     * @param array $aData An array continaing the values of the columns to insert,
     *                     indexed by column name.
     * @return integer The ID of the variable inserted.
     */
    private function _insertVariable($aData)
    {
        $doVariables = OA_Dal::factoryDO('variables');

        $doVariables->trackerid       = $aData['trackerid'];
        $doVariables->name            = $aData['name'];
        $doVariables->reject_if_empty = $aData['reject_if_empty'];

        return DataGenerator::generateOne($doVariables);
    }

    /**
     * A private method to insert conversions into the data_intermediate_ad_connection
     * table (via the DataGenerator) for testing.
     *
     * @access private
     * @param array $aData An array continaing the values of the columns to insert,
     *                     indexed by column name.
     * @return integer The ID of the conversion inserted.
     */
    private function _insertDataIntermediateAdConnection($aData)
    {
        $doData_intermediate_ad_connection = OA_Dal::factoryDO('data_intermediate_ad_connection');

        $doData_intermediate_ad_connection->server_raw_tracker_impression_id = $aData['server_raw_tracker_impression_id'];
        $doData_intermediate_ad_connection->server_raw_ip                    = $aData['server_raw_ip'];
        $doData_intermediate_ad_connection->tracker_id                       = $aData['tracker_id'];
        $doData_intermediate_ad_connection->tracker_date_time                = $aData['tracker_date_time'];
        $doData_intermediate_ad_connection->connection_date_time             = $aData['connection_date_time'];
        $doData_intermediate_ad_connection->ad_id                            = $aData['ad_id'];
        $doData_intermediate_ad_connection->zone_id                          = $aData['zone_id'];
        $doData_intermediate_ad_connection->connection_action                = $aData['connection_action'];
        $doData_intermediate_ad_connection->connection_window                = $aData['connection_window'];
        $doData_intermediate_ad_connection->connection_status                = $aData['connection_status'];

        // The "inside_window" column is historically from raw, SQL-based
        // conversion tracking, and is always set to "1" with the new
        // cookie-based, bucket-logged conversion system
        $doData_intermediate_ad_connection->inside_window                    = 1;

        return DataGenerator::generateOne($doData_intermediate_ad_connection);
    }

    /**
     * A private method to insert recorded variable values for conversions into
     * the data_intermediate_ad_variable_value table (via the DataGenerator) for
     * testing.
     *
     * @access private
     * @param array $aData An array continaing the values of the columns to insert,
     *                     indexed by column name.
     * @return integer The ID of the conversion inserted.
     */
    function _insertDataIntermediateAdVariableValue($aData)
    {
        $doData_intermediate_ad_variable_value = OA_Dal::factoryDO('data_intermediate_ad_variable_value');

        $doData_intermediate_ad_variable_value->data_intermediate_ad_connection_id = $aData['data_intermediate_ad_connection_id'];
        $doData_intermediate_ad_variable_value->tracker_variable_id                = $aData['tracker_variable_id'];
        $doData_intermediate_ad_variable_value->value                              = $aData['value'];

        if (is_null($aData['value'])) {
            // Hack the DB_DataObject so that the DataGenerator will not override
            // the NULL value that should be inserted into the database with an
            // auto generated value...
            $doData_intermediate_ad_variable_value->defaultValues['value'] = OA_DATAOBJECT_DEFAULT_NULL;
        }

        return DataGenerator::generateOne($doData_intermediate_ad_variable_value);
    }
}

?>