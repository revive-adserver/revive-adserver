<?php

/*
+---------------------------------------------------------------------------+
| OpenX  v${RELEASE_MAJOR_MINOR}                                                              |
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

require_once MAX_PATH . '/lib/OA.php';
require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/lib/OA/Dal/Maintenance/Statistics/Factory.php';
require_once MAX_PATH . '/lib/max/Dal/tests/util/DalUnitTestCase.php';

// pgsql execution time before refactor: 526.11s
// pgsql execution time after refactor: 2.2941s

/**
 * A class for testing the OA_Dal_Maintenance_Statistics_AdServer_* classes.
 *
 * @package    OpenXDal
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew.hill@openx.org>
 */
class Test_OA_Dal_Maintenance_Statistics_AdServer_IntermediateDeduplicateConversions extends UnitTestCase
{
    var $oDbh;
    var $oMDMSF;
    var $doVariables = null;
    var $doDIAC = null;
    var $doDIAVV = null;
    var $tblDIAC = '';

    /**
     * The constructor method.
     */
    function Test_OA_Dal_Maintenance_Statistics_AdServer_IntermediateDeduplicateConversions()
    {
        $this->UnitTestCase();
        $this->oDbh =& OA_DB::singleton();
        $aConf = $GLOBALS['_MAX']['CONF'];
        $this->tblDIAC = $this->oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_connection'],true);
        $this->oMDMSF = new OA_Dal_Maintenance_Statistics_Factory();
    }

    function _insertDataIntermediateAdConnection($aData)
    {
        if (is_null($this->doDIAC))
        {
            $this->doDIAC = OA_Dal::factoryDO('data_intermediate_ad_connection');
        }
        //$this->doDIAC->data_intermediate_ad_connection_id   = $aData[0];
        $this->doDIAC->server_raw_ip                        = $aData[1];
        $this->doDIAC->server_raw_tracker_impression_id     = $aData[2];
        $this->doDIAC->viewer_id                            = $aData[3];
        $this->doDIAC->tracker_date_time                    = $aData[4];
        $this->doDIAC->connection_date_time                 = $aData[5];
        $this->doDIAC->tracker_id                           = $aData[6];
        $this->doDIAC->ad_id                                = $aData[7];
        $this->doDIAC->creative_id                          = $aData[8];
        $this->doDIAC->zone_id                              = $aData[9];
        $this->doDIAC->connection_action                    = $aData[10];
        $this->doDIAC->connection_window                    = $aData[11];
        $this->doDIAC->connection_status                    = $aData[12];
        $this->doDIAC->inside_window                        = 0;
        if (isset($aData[13]))
        {
            $this->doDIAC->inside_window                    = $aData[13];
        }
        $this->doDIAC->comments                             = '';
        return DataGenerator::generateOne($this->doDIAC);
    }

    function _insertVariables($aData)
    {
        if (is_null($this->doVariables))
        {
            $this->doVariables = OA_Dal::factoryDO('variables');
        }
        //$this->doVariables->variableid      = $aData[0];
        $this->doVariables->trackerid       = $aData[1];
        $this->doVariables->name            = $aData[2];
        $this->doVariables->is_unique       = $aData[3];
        $this->doVariables->unique_window   = $aData[4];
        return DataGenerator::generateOne($this->doVariables);
    }

    function _insertDataIntermediateAdVariableValue($aData)
    {
        if (is_null($this->doDIAVV))
        {
            $this->doDIAVV = OA_Dal::factoryDO('data_intermediate_ad_variable_value');
        }
        //$this->doDIAVV->data_intermediate_ad_variable_value_id  = $aData[0];
        $this->doDIAVV->data_intermediate_ad_connection_id      = $aData[1];
        $this->doDIAVV->tracker_variable_id                     = $aData[2];
        $this->doDIAVV->value                                   = $aData[3];
        return DataGenerator::generateOne($this->doDIAVV);
    }

    function _queryDataIntermediateAdConnectionsById($id)
    {
        $query = "
            SELECT
                connection_status,
                comments

            FROM
                {$this->tblDIAC}
            WHERE
                data_intermediate_ad_connection_id = $id";
        return $this->oDbh->queryRow($query);
    }

    function _countDataIntermediateAdConnections()
    {
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$this->tblDIAC}";
        return $this->oDbh->queryRow($query);
    }

    function _countDataIntermediateAdConnectionsApproved()
    {
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$this->tblDIAC}
            WHERE
                connection_status = " . MAX_CONNECTION_STATUS_APPROVED;
        return $this->oDbh->queryRow($query);
    }

    function _countDataIntermediateAdConnectionsDuplicate()
    {
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$this->tblDIAC}
            WHERE
                connection_status = " . MAX_CONNECTION_STATUS_DUPLICATE;
        return $this->oDbh->queryRow($query);
    }

    /**
     * A method to perform testing of the _saveIntermediateDeduplicateConversions() method.
     *
     * Test 0:  Test with no conversions.
     *
     * Test 1:  Test with one conversion, no variable values, and ensure that
     *              the conversion status remains as "approved".
     * Test 2:  Test with two conversions, no variable values, and ensure that
     *              the conversion statuses remain as "approved".
     *
     * Test 3:  Test with one conversion, one variable value (not unique, NULL),
     *              and ensure that the conversion status remains as "approved".
     * Test 4:  Test with one conversion, one variable value (not unique, empty string),
     *              and ensure that the conversion status remains as "approved".
     * Test 5:  Test with one conversion, one variable value (not unique, real value),
     *              and ensure that the conversion status remains as "approved".
     *
     * Test 6:  Test with two conversions, one variable value (not unique, NULL, NULL),
     *              and ensure that the conversion statuses remain as "approved".
     * Test 7:  Test with two conversions, one variable value (not unique, NULL, empty string),
     *              and ensure that the conversion statuses remain as "approved".
     * Test 8:  Test with two conversions, one variable value (not unique, NULL, real value),
     *              and ensure that the conversion statuses remain as "approved".
     * Test 9:  Test with two conversions, one variable value (not unique, empty string, empty string),
     *              and ensure that the conversion statuses remain as "approved".
     * Test 10:  Test with two conversions, one variable value (not unique, empty string, real value),
     *              and ensure that the conversion statuses remain as "approved".
     * Test 11: Test with two conversions, one variable value (not unique, real value, real value),
     *              and ensure that the conversion statuses remain as "approved".
     *
     * Test 12: Test with one conversion, one variable value (unique, NULL),
     *              and ensure that the conversion status remains as "approved".
     * Test 13: Test with one conversion, one variable value (unique, empty string),
     *              and ensure that the conversion status remains as "approved".
     * Test 14: Test with one conversion, one variable value (unique, real value),
     *              and ensure that the conversion status remains as "approved".
     *
     * Test 15: Test with two conversions, one variable value (unique, NULL, NULL),
     *              and ensure that the conversion statuses remain as "approved".
     *              (NOTE: This is a special case! Although the two variable values are
     *                     the "same", we don't de-duplicate, because, well, how can you
     *                     de-dupe on nothing?)
     *
     * Test 16: Test with two conversions, one variable value (unique, NULL, empty string),
     *              and ensure that the conversion statuses remain as "approved".
     *
     * Test 17: Test with two conversions, one variable value (unique, NULL, real value),
     *              and ensure that the conversion statuses remain as "approved".
     *
     * Test 18: Test with two conversions, one variable value (unique, empty string, empty string),
     *              and ensure that the FIRST conversion has its status remain as "approved",
     *              and the SECOND conversion has its status changed to "duplicate".
     *
     * Test 19: Test with two conversions, one variable value (unique, empty string, real value),
     *              and ensure that the conversion statuses remain as "approved".
     *
     * Test 20: Test with two conversions, one variable value (unique, different real values),
     *              and ensure that the conversion statuses remain as "approved".
     *
     * Test 21: Test with two conversions, one variable value (unique, equal real values),
     *              and ensure that the FIRST conversion has its status remain as "approved",
     *              and the SECOND conversion has its status changed to "duplicate".
     *
     * Test 22: Test with duplicate conversions in different hours, both within the
     *              unique window of the original, within the unique window of a duplicate
     *              (only), and outside of the unique window.
     *
     */
    function test_saveIntermediateDeduplicateConversions_0()
    {
        // Test 0
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');

        $dsa = $this->oMDMSF->factory("AdServer");

        $dsa->_saveIntermediateDeduplicateConversions($oStartDate, $oEndDate);
        $aRow = $this->_countDataIntermediateAdConnections();
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 0);
    }

    function test_saveIntermediateDeduplicateConversions_1()
    {
        // Test 1
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');
        // Insert a connection at 12:10:00, from a click on ad ID 5, zone ID 6, at 12:09
        $aData = array(
                        1,
                        'singleDB',
                        1,
                        'viewerid1',
                        '2005-09-05 12:10:00',
                        '2005-09-05 12:09:00',
                        1,
                        5,
                        0,
                        6,
                        MAX_CONNECTION_AD_CLICK,
                        1209600,
                        MAX_CONNECTION_STATUS_APPROVED
                    );
        $this->_insertDataIntermediateAdConnection($aData);
        $dsa = $this->oMDMSF->factory("AdServer");
        $dsa->_saveIntermediateDeduplicateConversions($oStartDate, $oEndDate);
        $aRow = $this->_countDataIntermediateAdConnections();
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 1);
        $aRow = $this->_countDataIntermediateAdConnectionsApproved();
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 1);
        DataGenerator::cleanUp();

    }

    function test_saveIntermediateDeduplicateConversions_2()
    {
        // Test 2
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');
        // Insert a connection at 12:10:00, from a click on ad ID 5, zone ID 6, at 12:09
        $aData = array(
                    1,
                    'singleDB',
                    1,
                    'viewerid1',
                    '2005-09-05 12:10:00',
                    '2005-09-05 12:09:00',
                    1,
                    5,
                    0,
                    6,
                    MAX_CONNECTION_AD_CLICK,
                    1209600,
                    MAX_CONNECTION_STATUS_APPROVED
                );
        $this->_insertDataIntermediateAdConnection($aData);
        // Insert a connection at 12:30:00, from a click on ad ID 5, zone ID 6, at 12:29
        $aData = array(
                    2,
                    'singleDB',
                    2,
                    '357826bf941721cb697a032a3d31a969',
                    '2005-09-05 12:30:00',
                    '2005-09-05 12:29:00',
                    1,
                    5,
                    0,
                    6,
                    MAX_CONNECTION_AD_CLICK,
                    1209600,
                    MAX_CONNECTION_STATUS_APPROVED
                );
        $this->_insertDataIntermediateAdConnection($aData);
        $dsa = $this->oMDMSF->factory("AdServer");
        $dsa->_saveIntermediateDeduplicateConversions($oStartDate, $oEndDate);
        $aRow = $this->_countDataIntermediateAdConnections();
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 2);
        $aRow = $this->_countDataIntermediateAdConnectionsApproved();
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 2);
        DataGenerator::cleanUp();
    }

    function test_saveIntermediateDeduplicateConversions_3()
    {
        // Test 3
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');
        // Prepare the variable value for the tracker
        $aData = array(
                    1,
                    1,
                    'Test Non-Unique',
                    0,
                    3600
                );
        $this->_insertVariables($aData);
        // Insert a connection at 12:10:00, from a click on ad ID 5, zone ID 6, at 12:09
        $aData = array(
                    1,
                    'singleDB',
                    1,
                    'viewerid1',
                    '2005-09-05 12:10:00',
                    '2005-09-05 12:09:00',
                    1,
                    5,
                    0,
                    6,
                    MAX_CONNECTION_AD_CLICK,
                    1209600,
                    MAX_CONNECTION_STATUS_APPROVED
                );
        $this->_insertDataIntermediateAdConnection($aData);
        // Insert the variable value for the connection
        $aData = array(
                    1,
                    1,
                    1,
                    NULL
                );
        $this->_insertDataIntermediateAdVariableValue($aData);
        $dsa = $this->oMDMSF->factory("AdServer");
        $dsa->_saveIntermediateDeduplicateConversions($oStartDate, $oEndDate);
        $aRow = $this->_countDataIntermediateAdConnections();
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 1);
        $aRow = $this->_countDataIntermediateAdConnectionsApproved();
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 1);
        DataGenerator::cleanUp();
    }

    function test_saveIntermediateDeduplicateConversions_4()
    {
        // Test 4
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');
        // Prepare the variable value for the tracker
        $aData = array(
                    1,
                    1,
                    'Test Non-Unique',
                    0,
                    3600
                );
        $this->_insertVariables($aData);
        // Insert a connection at 12:10:00, from a click on ad ID 5, zone ID 6, at 12:09
        $aData = array(
                    1,
                    'singleDB',
                    1,
                    'viewerid1',
                    '2005-09-05 12:10:00',
                    '2005-09-05 12:09:00',
                    1,
                    5,
                    0,
                    6,
                    MAX_CONNECTION_AD_CLICK,
                    1209600,
                    MAX_CONNECTION_STATUS_APPROVED
                );
        $this->_insertDataIntermediateAdConnection($aData);
        // Insert the variable value for the connection
        $aData = array(
                    1,
                    1,
                    1,
                    ''
                );
        $this->_insertDataIntermediateAdVariableValue($aData);
        $dsa = $this->oMDMSF->factory("AdServer");
        $dsa->_saveIntermediateDeduplicateConversions($oStartDate, $oEndDate);
        $aRow = $this->_countDataIntermediateAdConnections();
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 1);
        $aRow = $this->_countDataIntermediateAdConnectionsApproved();
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 1);
        DataGenerator::cleanUp();
    }

    function test_saveIntermediateDeduplicateConversions_5()
    {
        // Test 5
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');
        // Prepare the variable value for the tracker
        $aData = array(
                    1,
                    1,
                    'Test Non-Unique',
                    0,
                    3600
                );
        $this->_insertVariables($aData);
        // Insert a connection at 12:10:00, from a click on ad ID 5, zone ID 6, at 12:09
        $aData = array(
                    1,
                    'singleDB',
                    1,
                    'viewerid1',
                    '2005-09-05 12:10:00',
                    '2005-09-05 12:09:00',
                    1,
                    5,
                    0,
                    6,
                    MAX_CONNECTION_AD_CLICK,
                    1209600,
                    MAX_CONNECTION_STATUS_APPROVED
                );
        $this->_insertDataIntermediateAdConnection($aData);
        // Insert the variable value for the connection
        $aData = array(
                    1,
                    1,
                    1,
                    'value'
                );
        $this->_insertDataIntermediateAdVariableValue($aData);
        $dsa = $this->oMDMSF->factory("AdServer");
        $dsa->_saveIntermediateDeduplicateConversions($oStartDate, $oEndDate);
        $aRow = $this->_countDataIntermediateAdConnections();
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 1);
        $aRow = $this->_countDataIntermediateAdConnectionsApproved();
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 1);
        DataGenerator::cleanUp();
    }

    function test_saveIntermediateDeduplicateConversions_6()
    {
        // Test 6
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');
        // Prepare the variable value for the tracker
        $aData = array(
                    1,
                    1,
                    'Test Non-Unique',
                    0,
                    3600
                );
        $this->_insertVariables($aData);
        // Insert a connection at 12:10:00, from a click on ad ID 5, zone ID 6, at 12:09
        $aData = array(
                    1,
                    'singleDB',
                    1,
                    'viewerid1',
                    '2005-09-05 12:10:00',
                    '2005-09-05 12:09:00',
                    1,
                    5,
                    0,
                    6,
                    MAX_CONNECTION_AD_CLICK,
                    1209600,
                    MAX_CONNECTION_STATUS_APPROVED
                );
        $this->_insertDataIntermediateAdConnection($aData);
        // Insert the variable value for the connection
        $aData = array(
                    1,
                    1,
                    1,
                    NULL
                );
        $this->_insertDataIntermediateAdVariableValue($aData);
        // Insert a connection at 12:30:00, from a click on ad ID 5, zone ID 6, at 12:29
        $aData = array(
                    2,
                    'singleDB',
                    2,
                    '357826bf941721cb697a032a3d31a969',
                    '2005-09-05 12:30:00',
                    '2005-09-05 12:29:00',
                    1,
                    5,
                    0,
                    6,
                    MAX_CONNECTION_AD_CLICK,
                    1209600,
                    MAX_CONNECTION_STATUS_APPROVED
                );
        $this->_insertDataIntermediateAdConnection($aData);
        // Insert the variable value for the connection
        $aData = array(
                    2,
                    2,
                    1,
                    NULL
                );
        $this->_insertDataIntermediateAdVariableValue($aData);
        $dsa = $this->oMDMSF->factory("AdServer");
        $dsa->_saveIntermediateDeduplicateConversions($oStartDate, $oEndDate);
        $aRow = $this->_countDataIntermediateAdConnections();
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 2);
        $aRow = $this->_countDataIntermediateAdConnectionsApproved();
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 2);
        DataGenerator::cleanUp();
    }

    function test_saveIntermediateDeduplicateConversions_7()
    {
        // Test 7
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');
        // Prepare the variable value for the tracker
        $aData = array(
                    1,
                    1,
                    'Test Non-Unique',
                    0,
                    3600
                );
        $this->_insertVariables($aData);
        // Insert a connection at 12:10:00, from a click on ad ID 5, zone ID 6, at 12:09
        $aData = array(
                    1,
                    'singleDB',
                    1,
                    'viewerid1',
                    '2005-09-05 12:10:00',
                    '2005-09-05 12:09:00',
                    1,
                    5,
                    0,
                    6,
                    MAX_CONNECTION_AD_CLICK,
                    1209600,
                    MAX_CONNECTION_STATUS_APPROVED
                );
        $this->_insertDataIntermediateAdConnection($aData);
        // Insert the variable value for the connection
        $aData = array(
                    1,
                    1,
                    1,
                    NULL
                );
        $this->_insertDataIntermediateAdVariableValue($aData);
        // Insert a connection at 12:30:00, from a click on ad ID 5, zone ID 6, at 12:29
        $aData= array(
                    2,
                    'singleDB',
                    2,
                    '357826bf941721cb697a032a3d31a969',
                    '2005-09-05 12:30:00',
                    '2005-09-05 12:29:00',
                    1,
                    5,
                    0,
                    6,
                    MAX_CONNECTION_AD_CLICK,
                    1209600,
                    MAX_CONNECTION_STATUS_APPROVED
                );
        $this->_insertDataIntermediateAdConnection($aData);
        // Insert the variable value for the connection
        $aData = array(
                    2,
                    2,
                    1,
                    ''
                );
        $this->_insertDataIntermediateAdVariableValue($aData);
        $dsa = $this->oMDMSF->factory("AdServer");
        $dsa->_saveIntermediateDeduplicateConversions($oStartDate, $oEndDate);
        $aRow = $this->_countDataIntermediateAdConnections();
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 2);
        $aRow = $this->_countDataIntermediateAdConnectionsApproved();
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 2);
        DataGenerator::cleanUp();
    }

    function test_saveIntermediateDeduplicateConversions_8()
    {
        // Test 8
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');
        // Prepare the variable value for the tracker
        $aData = array(
                    1,
                    1,
                    'Test Non-Unique',
                    0,
                    3600
                );
        $this->_insertVariables($aData);
        // Insert a connection at 12:10:00, from a click on ad ID 5, zone ID 6, at 12:09
        $aData = array(
                    1,
                    'singleDB',
                    1,
                    'viewerid1',
                    '2005-09-05 12:10:00',
                    '2005-09-05 12:09:00',
                    1,
                    5,
                    0,
                    6,
                    MAX_CONNECTION_AD_CLICK,
                    1209600,
                    MAX_CONNECTION_STATUS_APPROVED
                );
        $this->_insertDataIntermediateAdConnection($aData);

        // Insert the variable value for the connection
        $aData = array(
                    1,
                    1,
                    1,
                    NULL
                );
        $this->_insertDataIntermediateAdVariableValue($aData);
        // Insert a connection at 12:30:00, from a click on ad ID 5, zone ID 6, at 12:29
        $aData = array(
                    2,
                    'singleDB',
                    2,
                    '357826bf941721cb697a032a3d31a969',
                    '2005-09-05 12:30:00',
                    '2005-09-05 12:29:00',
                    1,
                    5,
                    0,
                    6,
                    MAX_CONNECTION_AD_CLICK,
                    1209600,
                    MAX_CONNECTION_STATUS_APPROVED
                );
        $this->_insertDataIntermediateAdConnection($aData);
        // Insert the variable value for the connection
        $aData = array(
                    2,
                    2,
                    1,
                    'value'
                );
        $this->_insertDataIntermediateAdVariableValue($aData);
        $dsa = $this->oMDMSF->factory("AdServer");
        $dsa->_saveIntermediateDeduplicateConversions($oStartDate, $oEndDate);
        $aRow = $this->_countDataIntermediateAdConnections();
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 2);
        $aRow = $this->_countDataIntermediateAdConnectionsApproved();
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 2);
        DataGenerator::cleanUp();
    }

    function test_saveIntermediateDeduplicateConversions_9()
    {
        // Test 9
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');
        // Prepare the variable value for the tracker
        $aData = array(
                    1,
                    1,
                    'Test Non-Unique',
                    0,
                    3600
                );
        $this->_insertVariables($aData);
        // Insert a connection at 12:10:00, from a click on ad ID 5, zone ID 6, at 12:09
        $aData = array(
                    1,
                    'singleDB',
                    1,
                    'viewerid1',
                    '2005-09-05 12:10:00',
                    '2005-09-05 12:09:00',
                    1,
                    5,
                    0,
                    6,
                    MAX_CONNECTION_AD_CLICK,
                    1209600,
                    MAX_CONNECTION_STATUS_APPROVED
                );
        $this->_insertDataIntermediateAdConnection($aData);
        // Insert the variable value for the connection
        $aData = array(
                    1,
                    1,
                    1,
                    ''
                );
        $this->_insertDataIntermediateAdVariableValue($aData);
        // Insert a connection at 12:30:00, from a click on ad ID 5, zone ID 6, at 12:29
        $aData = array(
                    2,
                    'singleDB',
                    2,
                    '357826bf941721cb697a032a3d31a969',
                    '2005-09-05 12:30:00',
                    '2005-09-05 12:29:00',
                    1,
                    5,
                    0,
                    6,
                    MAX_CONNECTION_AD_CLICK,
                    1209600,
                    MAX_CONNECTION_STATUS_APPROVED
                );
        $this->_insertDataIntermediateAdConnection($aData);
        // Insert the variable value for the connection
        $aData = array(
                    2,
                    2,
                    1,
                    ''
                );
        $this->_insertDataIntermediateAdVariableValue($aData);
        $dsa = $this->oMDMSF->factory("AdServer");
        $dsa->_saveIntermediateDeduplicateConversions($oStartDate, $oEndDate);
        $aRow = $this->_countDataIntermediateAdConnections();
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 2);
        $aRow = $this->_countDataIntermediateAdConnectionsApproved();
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 2);
        DataGenerator::cleanUp();
    }

    function test_saveIntermediateDeduplicateConversions_10()
    {
        // Test 10
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');
        // Prepare the variable value for the tracker
        $aData = array(
                    1,
                    1,
                    'Test Non-Unique',
                    0,
                    3600
                );
        $this->_insertVariables($aData);
        // Insert a connection at 12:10:00, from a click on ad ID 5, zone ID 6, at 12:09
        $aData = array(
                    1,
                    'singleDB',
                    1,
                    'viewerid1',
                    '2005-09-05 12:10:00',
                    '2005-09-05 12:09:00',
                    1,
                    5,
                    0,
                    6,
                    MAX_CONNECTION_AD_CLICK,
                    1209600,
                    MAX_CONNECTION_STATUS_APPROVED
                );
        $this->_insertDataIntermediateAdConnection($aData);
        // Insert the variable value for the connection
        $aData = array(
                    1,
                    1,
                    1,
                    ''
                );
        $this->_insertDataIntermediateAdVariableValue($aData);
        // Insert a connection at 12:30:00, from a click on ad ID 5, zone ID 6, at 12:29
        $aData = array(
                    2,
                    'singleDB',
                    2,
                    '357826bf941721cb697a032a3d31a969',
                    '2005-09-05 12:30:00',
                    '2005-09-05 12:29:00',
                    1,
                    5,
                    0,
                    6,
                    MAX_CONNECTION_AD_CLICK,
                    1209600,
                    MAX_CONNECTION_STATUS_APPROVED
                );
        $this->_insertDataIntermediateAdConnection($aData);
        // Insert the variable value for the connection
        $aData = array(
                    2,
                    2,
                    1,
                    'value'
                );
        $this->_insertDataIntermediateAdVariableValue($aData);
        $dsa = $this->oMDMSF->factory("AdServer");
        $dsa->_saveIntermediateDeduplicateConversions($oStartDate, $oEndDate);
        $aRow = $this->_countDataIntermediateAdConnections();
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 2);
        $aRow = $this->_countDataIntermediateAdConnectionsApproved();
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 2);
        DataGenerator::cleanUp();
    }

    function test_saveIntermediateDeduplicateConversions_11()
    {
        // Test 11
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');
        // Prepare the variable value for the tracker
        $aData = array(
                    1,
                    1,
                    'Test Non-Unique',
                    0,
                    3600
                );
        $this->_insertVariables($aData);
        // Insert a connection at 12:10:00, from a click on ad ID 5, zone ID 6, at 12:09
        $aData = array(
                    1,
                    'singleDB',
                    1,
                    'viewerid1',
                    '2005-09-05 12:10:00',
                    '2005-09-05 12:09:00',
                    1,
                    5,
                    0,
                    6,
                    MAX_CONNECTION_AD_CLICK,
                    1209600,
                    MAX_CONNECTION_STATUS_APPROVED
                );
        $this->_insertDataIntermediateAdConnection($aData);
        // Insert the variable value for the connection
        $aData = array(
                    1,
                    1,
                    1,
                    'value'
                );
        $this->_insertDataIntermediateAdVariableValue($aData);
        // Insert a connection at 12:30:00, from a click on ad ID 5, zone ID 6, at 12:29
        $aData = array(
                    2,
                    'singleDB',
                    2,
                    '357826bf941721cb697a032a3d31a969',
                    '2005-09-05 12:30:00',
                    '2005-09-05 12:29:00',
                    1,
                    5,
                    0,
                    6,
                    MAX_CONNECTION_AD_CLICK,
                    1209600,
                    MAX_CONNECTION_STATUS_APPROVED
                );
        $this->_insertDataIntermediateAdConnection($aData);
        // Insert the variable value for the connection
        $aData = array(
                    2,
                    2,
                    1,
                    'value'
                );
        $this->_insertDataIntermediateAdVariableValue($aData);
        $dsa = $this->oMDMSF->factory("AdServer");
        $dsa->_saveIntermediateDeduplicateConversions($oStartDate, $oEndDate);
        $aRow = $this->_countDataIntermediateAdConnections();
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 2);
        $aRow = $this->_countDataIntermediateAdConnectionsApproved();
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 2);
        DataGenerator::cleanUp();
    }

    function test_saveIntermediateDeduplicateConversions_12()
    {
        // Test 12
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');
        // Prepare the variable value for the tracker
        $aData = array(
                    1,
                    1,
                    'Test Unique',
                    1,
                    3600
                );
        $this->_insertVariables($aData);
        // Insert a connection at 12:10:00, from a click on ad ID 5, zone ID 6, at 12:09
        $aData = array(
                    1,
                    'singleDB',
                    1,
                    'viewerid1',
                    '2005-09-05 12:10:00',
                    '2005-09-05 12:09:00',
                    1,
                    5,
                    0,
                    6,
                    MAX_CONNECTION_AD_CLICK,
                    1209600,
                    MAX_CONNECTION_STATUS_APPROVED
                );
        $this->_insertDataIntermediateAdConnection($aData);
        // Insert the variable value for the connection
        $aData = array(
                    1,
                    1,
                    1,
                    NULL
                );
        $this->_insertDataIntermediateAdVariableValue($aData);
        $dsa = $this->oMDMSF->factory("AdServer");
        $dsa->_saveIntermediateDeduplicateConversions($oStartDate, $oEndDate);
        $aRow = $this->_countDataIntermediateAdConnections();
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 1);
        $aRow = $this->_countDataIntermediateAdConnectionsApproved();
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 1);
        DataGenerator::cleanUp();
    }

    function test_saveIntermediateDeduplicateConversions_13()
    {
        // Test 13
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');
        // Prepare the variable value for the tracker
        $aData = array(
                    1,
                    1,
                    'Test Unique',
                    1,
                    3600
                );
        $this->_insertVariables($aData);
        // Insert a connection at 12:10:00, from a click on ad ID 5, zone ID 6, at 12:09
        $aData = array(
                    1,
                    'singleDB',
                    1,
                    'viewerid1',
                    '2005-09-05 12:10:00',
                    '2005-09-05 12:09:00',
                    1,
                    5,
                    0,
                    6,
                    MAX_CONNECTION_AD_CLICK,
                    1209600,
                    MAX_CONNECTION_STATUS_APPROVED
                );
        $this->_insertDataIntermediateAdConnection($aData);
        // Insert the variable value for the connection
        $aData = array(
                    1,
                    1,
                    1,
                    ''
                );
        $this->_insertDataIntermediateAdVariableValue($aData);
        $dsa = $this->oMDMSF->factory("AdServer");
        $dsa->_saveIntermediateDeduplicateConversions($oStartDate, $oEndDate);
        $aRow = $this->_countDataIntermediateAdConnections();
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 1);
        $aRow = $this->_countDataIntermediateAdConnectionsApproved();
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 1);
        DataGenerator::cleanUp();
    }

    function test_saveIntermediateDeduplicateConversions_14()
    {
        // Test 14
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');
        // Prepare the variable value for the tracker
        $aData = array(
                    1,
                    1,
                    'Test Unique',
                    1,
                    3600
                );
        $this->_insertVariables($aData);
        // Insert a connection at 12:10:00, from a click on ad ID 5, zone ID 6, at 12:09
        $aData = array(
                    1,
                    'singleDB',
                    1,
                    'viewerid1',
                    '2005-09-05 12:10:00',
                    '2005-09-05 12:09:00',
                    1,
                    5,
                    0,
                    6,
                    MAX_CONNECTION_AD_CLICK,
                    1209600,
                    MAX_CONNECTION_STATUS_APPROVED
                );
        $this->_insertDataIntermediateAdConnection($aData);
        // Insert the variable value for the connection
        $aData = array(
                    1,
                    1,
                    1,
                    'value'
                );
        $this->_insertDataIntermediateAdVariableValue($aData);
        $dsa = $this->oMDMSF->factory("AdServer");
        $dsa->_saveIntermediateDeduplicateConversions($oStartDate, $oEndDate);
        $aRow = $this->_countDataIntermediateAdConnections();
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 1);
        $aRow = $this->_countDataIntermediateAdConnectionsApproved();
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 1);
        DataGenerator::cleanUp();
    }

    function test_saveIntermediateDeduplicateConversions_15()
    {
        // Test 15
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');
        // Prepare the variable value for the tracker
        $aData = array(
                    1,
                    1,
                    'Test Unique',
                    1,
                    3600
                );
        $this->_insertVariables($aData);
        // Insert a connection at 12:10:00, from a click on ad ID 5, zone ID 6, at 12:09
        $aData = array(
                    1,
                    'singleDB',
                    1,
                    'viewerid1',
                    '2005-09-05 12:10:00',
                    '2005-09-05 12:09:00',
                    1,
                    5,
                    0,
                    6,
                    MAX_CONNECTION_AD_CLICK,
                    1209600,
                    MAX_CONNECTION_STATUS_APPROVED
                );
        $this->_insertDataIntermediateAdConnection($aData);
        // Insert the variable value for the connection
        $aData = array(
                    1,
                    1,
                    1,
                    NULL
                );
        $this->_insertDataIntermediateAdVariableValue($aData);
        // Insert a connection at 12:30:00, from a click on ad ID 5, zone ID 6, at 12:29
        $aData = array(
                    2,
                    'singleDB',
                    2,
                    '357826bf941721cb697a032a3d31a969',
                    '2005-09-05 12:30:00',
                    '2005-09-05 12:29:00',
                    1,
                    5,
                    0,
                    6,
                    MAX_CONNECTION_AD_CLICK,
                    1209600,
                    MAX_CONNECTION_STATUS_APPROVED
                );
        $this->_insertDataIntermediateAdConnection($aData);
        // Insert the variable value for the connection
        $aData = array(
                    2,
                    2,
                    1,
                    NULL
                );
        $this->_insertDataIntermediateAdVariableValue($aData);
        $dsa = $this->oMDMSF->factory("AdServer");
        $dsa->_saveIntermediateDeduplicateConversions($oStartDate, $oEndDate);
        $aRow = $this->_countDataIntermediateAdConnections();
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 2);
        $aRow = $this->_countDataIntermediateAdConnectionsApproved();
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 2);
        DataGenerator::cleanUp();
    }

    function test_saveIntermediateDeduplicateConversions_16()
    {
        // Test 16
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');
        // Prepare the variable value for the tracker
        $aData = array(
                    1,
                    1,
                    'Test Unique',
                    1,
                    3600
                );
        $this->_insertVariables($aData);
        // Insert a connection at 12:10:00, from a click on ad ID 5, zone ID 6, at 12:09
        $aData = array(
                    1,
                    'singleDB',
                    1,
                    'viewerid1',
                    '2005-09-05 12:10:00',
                    '2005-09-05 12:09:00',
                    1,
                    5,
                    0,
                    6,
                    MAX_CONNECTION_AD_CLICK,
                    1209600,
                    MAX_CONNECTION_STATUS_APPROVED
                );
        $this->_insertDataIntermediateAdConnection($aData);
        // Insert the variable value for the connection
        $aData = array(
                    1,
                    1,
                    1,
                    NULL
                );
        $this->_insertDataIntermediateAdVariableValue($aData);
        // Insert a connection at 12:30:00, from a click on ad ID 5, zone ID 6, at 12:29
        $aData = array(
                    2,
                    'singleDB',
                    2,
                    '357826bf941721cb697a032a3d31a969',
                    '2005-09-05 12:30:00',
                    '2005-09-05 12:29:00',
                    1,
                    5,
                    0,
                    6,
                    MAX_CONNECTION_AD_CLICK,
                    1209600,
                    MAX_CONNECTION_STATUS_APPROVED
                );
        $this->_insertDataIntermediateAdConnection($aData);
        // Insert the variable value for the connection
        $aData = array(
                    2,
                    2,
                    1,
                    ''
                );
        $this->_insertDataIntermediateAdVariableValue($aData);
        $dsa = $this->oMDMSF->factory("AdServer");
        $dsa->_saveIntermediateDeduplicateConversions($oStartDate, $oEndDate);
        $aRow = $this->_countDataIntermediateAdConnections();
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 2);
        $aRow = $this->_countDataIntermediateAdConnectionsApproved();
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 2);
        DataGenerator::cleanUp();
    }

    function test_saveIntermediateDeduplicateConversions_17()
    {
        // Test 17
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');
        // Prepare the variable value for the tracker
        $aData = array(
                    1,
                    1,
                    'Test Unique',
                    1,
                    3600
                );
        $this->_insertVariables($aData);
        // Insert a connection at 12:10:00, from a click on ad ID 5, zone ID 6, at 12:09
        $aData = array(
                    1,
                    'singleDB',
                    1,
                    'viewerid1',
                    '2005-09-05 12:10:00',
                    '2005-09-05 12:09:00',
                    1,
                    5,
                    0,
                    6,
                    MAX_CONNECTION_AD_CLICK,
                    1209600,
                    MAX_CONNECTION_STATUS_APPROVED
                );
        $this->_insertDataIntermediateAdConnection($aData);
        // Insert the variable value for the connection
        $aData = array(
                    1,
                    1,
                    1,
                    NULL
                );
        $this->_insertDataIntermediateAdVariableValue($aData);
        // Insert a connection at 12:30:00, from a click on ad ID 5, zone ID 6, at 12:29
        $aData = array(
                    2,
                    'singleDB',
                    2,
                    '357826bf941721cb697a032a3d31a969',
                    '2005-09-05 12:30:00',
                    '2005-09-05 12:29:00',
                    1,
                    5,
                    0,
                    6,
                    MAX_CONNECTION_AD_CLICK,
                    1209600,
                    MAX_CONNECTION_STATUS_APPROVED
                );
        $this->_insertDataIntermediateAdConnection($aData);
        // Insert the variable value for the connection
        $aData = array(
                    2,
                    2,
                    1,
                    'value'
                );
        $this->_insertDataIntermediateAdVariableValue($aData);
        $dsa = $this->oMDMSF->factory("AdServer");
        $dsa->_saveIntermediateDeduplicateConversions($oStartDate, $oEndDate);
        $aRow = $this->_countDataIntermediateAdConnections();
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 2);
        $aRow = $this->_countDataIntermediateAdConnectionsApproved();
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 2);
        DataGenerator::cleanUp();
    }

    function test_saveIntermediateDeduplicateConversions_18()
    {
        // Test 18
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');
        // Prepare the variable value for the tracker
        $aData = array(
                    1,
                    1,
                    'Test Unique',
                    1,
                    3600
                );
        $idVARS1 = $this->_insertVariables($aData);
        // Insert a connection at 12:10:00, from a click on ad ID 5, zone ID 6, at 12:09
        $aData = array(
                    1,
                    'singleDB',
                    1,
                    'viewerid1',
                    '2005-09-05 12:10:00',
                    '2005-09-05 12:09:00',
                    1,
                    5,
                    0,
                    6,
                    MAX_CONNECTION_AD_CLICK,
                    1209600,
                    MAX_CONNECTION_STATUS_APPROVED,
                    1
                );
        $idDIAC1 = $this->_insertDataIntermediateAdConnection($aData);
        // Insert the variable value for the connection
        $aData = array(
                    1,
                    $idDIAC1,
                    $idVARS1,
                    ''
                );
        $idDIAVV1 = $this->_insertDataIntermediateAdVariableValue($aData);
        // Insert a connection at 12:30:00, from a click on ad ID 5, zone ID 6, at 12:29
        $aData = array(
                    2,
                    'singleDB',
                    2,
                    '357826bf941721cb697a032a3d31a969',
                    '2005-09-05 12:30:00',
                    '2005-09-05 12:29:00',
                    1,
                    5,
                    0,
                    6,
                    MAX_CONNECTION_AD_CLICK,
                    1209600,
                    MAX_CONNECTION_STATUS_APPROVED,
                    1
                );
        $idDIAC2 = $this->_insertDataIntermediateAdConnection($aData);
        // Insert the variable value for the connection
        $aData = array(
                    2,
                    $idDIAC2,
                    $idVARS1,
                    ''
                );
        $idDIAVV2 = $this->_insertDataIntermediateAdVariableValue($aData);
        $dsa = $this->oMDMSF->factory("AdServer");
        $dsa->_saveIntermediateDeduplicateConversions($oStartDate, $oEndDate);
        $aRow = $this->_countDataIntermediateAdConnections();
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 2);
        $aRow = $this->_countDataIntermediateAdConnectionsApproved();
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 1);
        $aRow = $this->_queryDataIntermediateAdConnectionsById($idDIAC1);
        $this->assertEqual(count($aRow), 2);
        $this->assertEqual($aRow['connection_status'], MAX_CONNECTION_STATUS_APPROVED);
        $this->assertEqual($aRow['comments'], '');
        $aRow = $this->_countDataIntermediateAdConnectionsDuplicate();
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 1);
        $aRow = $this->_queryDataIntermediateAdConnectionsById($idDIAC2);
        $this->assertEqual(count($aRow), 2);
        $this->assertEqual($aRow['connection_status'], MAX_CONNECTION_STATUS_DUPLICATE);
        $this->assertEqual($aRow['comments'], 'Duplicate of connection ID '.$idDIAC1);
        DataGenerator::cleanUp();
    }

    function test_saveIntermediateDeduplicateConversions_19()
    {
        // Test 19
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');
        // Prepare the variable value for the tracker
        $aData = array(
                    1,
                    1,
                    'Test Unique',
                    1,
                    3600
                );
        $this->_insertVariables($aData);
        // Insert a connection at 12:10:00, from a click on ad ID 5, zone ID 6, at 12:09
        $aData = array(
                    1,
                    'singleDB',
                    1,
                    'viewerid1',
                    '2005-09-05 12:10:00',
                    '2005-09-05 12:09:00',
                    1,
                    5,
                    0,
                    6,
                    MAX_CONNECTION_AD_CLICK,
                    1209600,
                    MAX_CONNECTION_STATUS_APPROVED,
                    1
                );
        $idDIAC1 = $this->_insertDataIntermediateAdConnection($aData);
        // Insert the variable value for the connection
        $aData = array(
                    1,
                    $idDIAC1,
                    1,
                    ''
                );
        $this->_insertDataIntermediateAdVariableValue($aData);
        // Insert a connection at 12:30:00, from a click on ad ID 5, zone ID 6, at 12:29
        $aData = array(
                    2,
                    'singleDB',
                    2,
                    '357826bf941721cb697a032a3d31a969',
                    '2005-09-05 12:30:00',
                    '2005-09-05 12:29:00',
                    1,
                    5,
                    0,
                    6,
                    MAX_CONNECTION_AD_CLICK,
                    1209600,
                    MAX_CONNECTION_STATUS_APPROVED,
                    1
                );
        $idDIAC2 = $this->_insertDataIntermediateAdConnection($aData);
        // Insert the variable value for the connection
        $aData = array(
                    2,
                    $idDIAC2,
                    1,
                    'value'
                );
        $this->_insertDataIntermediateAdVariableValue($aData);
        $dsa = $this->oMDMSF->factory("AdServer");
        $dsa->_saveIntermediateDeduplicateConversions($oStartDate, $oEndDate);
        $aRow = $this->_countDataIntermediateAdConnections();
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 2);
        $aRow = $this->_countDataIntermediateAdConnectionsApproved();
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 2);
        DataGenerator::cleanUp();
    }

    function test_saveIntermediateDeduplicateConversions_20()
    {
        // Test 20
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');
        // Prepare the variable value for the tracker
        $aData = array(
                    1,
                    1,
                    'Test Unique',
                    1,
                    3600
                );
        $this->_insertVariables($aData);
        // Insert a connection at 12:10:00, from a click on ad ID 5, zone ID 6, at 12:09
        $aData = array(
                    1,
                    'singleDB',
                    1,
                    'viewerid1',
                    '2005-09-05 12:10:00',
                    '2005-09-05 12:09:00',
                    1,
                    5,
                    0,
                    6,
                    MAX_CONNECTION_AD_CLICK,
                    1209600,
                    MAX_CONNECTION_STATUS_APPROVED,
                    1
                );
        $idDIAC1 = $this->_insertDataIntermediateAdConnection($aData);
        // Insert the variable value for the connection
        $aData = array(
                    1,
                    $idDIAC1,
                    1,
                    'value1'
                );
        $this->_insertDataIntermediateAdVariableValue($aData);
        // Insert a connection at 12:30:00, from a click on ad ID 5, zone ID 6, at 12:29
        $aData = array(
                    2,
                    'singleDB',
                    2,
                    '357826bf941721cb697a032a3d31a969',
                    '2005-09-05 12:30:00',
                    '2005-09-05 12:29:00',
                    1,
                    5,
                    0,
                    6,
                    MAX_CONNECTION_AD_CLICK,
                    1209600,
                    MAX_CONNECTION_STATUS_APPROVED,
                    1
                );
        $idDIAC2 = $this->_insertDataIntermediateAdConnection($aData);
        // Insert the variable value for the connection
        $aData = array(
                    2,
                    $idDIAC2,
                    1,
                    'value2'
                );
        $this->_insertDataIntermediateAdVariableValue($aData);
        $dsa = $this->oMDMSF->factory("AdServer");
        $dsa->_saveIntermediateDeduplicateConversions($oStartDate, $oEndDate);
        $aRow = $this->_countDataIntermediateAdConnections();
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 2);
        $aRow = $this->_countDataIntermediateAdConnectionsApproved();
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 2);
        DataGenerator::cleanUp();
    }

    function test_saveIntermediateDeduplicateConversions_21()
    {
        // Test 21
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');
        // Prepare the variable value for the tracker
        $aData = array(
                    1,
                    1,
                    'Test Unique',
                    1,
                    3600
                );
        $idTrackerVar1 = $this->_insertVariables($aData);
        // Insert a connection at 12:10:00, from a click on ad ID 5, zone ID 6, at 12:09
        $aData = array(
                    1,
                    'singleDB',
                    1,
                    'viewerid1',
                    '2005-09-05 12:10:00',
                    '2005-09-05 12:09:00',
                    1,
                    5,
                    0,
                    6,
                    MAX_CONNECTION_AD_CLICK,
                    1209600,
                    MAX_CONNECTION_STATUS_APPROVED,
                    1
                );
        $idDIAC1 = $this->_insertDataIntermediateAdConnection($aData);
        // Insert the variable value for the connection
        $aData = array(
                    1,
                    $idDIAC1,
                    $idTrackerVar1,
                    'value'
                );
        $this->_insertDataIntermediateAdVariableValue($aData);
        // Insert a connection at 12:30:00, from a click on ad ID 5, zone ID 6, at 12:29
        $aData = array(
                    2,
                    'singleDB',
                    2,
                    '357826bf941721cb697a032a3d31a969',
                    '2005-09-05 12:30:00',
                    '2005-09-05 12:29:00',
                    1,
                    5,
                    0,
                    6,
                    MAX_CONNECTION_AD_CLICK,
                    1209600,
                    MAX_CONNECTION_STATUS_APPROVED,
                    1
                );
        $idDIAC2 = $this->_insertDataIntermediateAdConnection($aData);
        // Insert the variable value for the connection
        $aData = array(
                    2,
                    $idDIAC2,
                    $idTrackerVar1,
                    'value'
                );
        $this->_insertDataIntermediateAdVariableValue($aData);
        $dsa = $this->oMDMSF->factory("AdServer");
        $dsa->_saveIntermediateDeduplicateConversions($oStartDate, $oEndDate);
        $aRow = $this->_countDataIntermediateAdConnections();
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 2);
        $aRow = $this->_countDataIntermediateAdConnectionsApproved();
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 1);
        $aRow = $this->_queryDataIntermediateAdConnectionsById($idDIAC1);
        $this->assertEqual(count($aRow), 2);
        $this->assertEqual($aRow['connection_status'], MAX_CONNECTION_STATUS_APPROVED);
        $this->assertEqual($aRow['comments'], '');
        $aRow = $this->_countDataIntermediateAdConnectionsDuplicate();
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 1);
        $aRow = $this->_queryDataIntermediateAdConnectionsById($idDIAC2);
        $this->assertEqual(count($aRow), 2);
        $this->assertEqual($aRow['connection_status'], MAX_CONNECTION_STATUS_DUPLICATE);
        $this->assertEqual($aRow['comments'], 'Duplicate of connection ID '.$idDIAC1);
        DataGenerator::cleanUp();
    }

    function test_saveIntermediateDeduplicateConversions_22()
    {
        // Test 22
        // Prepare the variable values for the tracker
        $aData = array(
                    1,
                    1,
                    'Test Non-Unique',
                    0,
                    3600
                );
        $idTrackerVar1 = $this->_insertVariables($aData);
        $aData = array(
                    2,
                    1,
                    'Test Unique',
                    1,
                    3600
                );
        $idTrackerVar2 = $this->_insertVariables($aData);
        $aData = array(
                    3,
                    2,
                    'Test Unique',
                    1,
                    3600
                );
        $idTrackerVar3 = $this->_insertVariables($aData);
        // Insert a connection at 12:10:00, from a click on ad ID 5, zone ID 6, at 12:09,
        // using tracker ID 1 (two variable values)
        $aData = array(
                    1,
                    'singleDB',
                    1,
                    'viewerid1',
                    '2005-09-05 12:10:00',
                    '2005-09-05 12:09:00',
                    1,
                    5,
                    0,
                    6,
                    MAX_CONNECTION_AD_CLICK,
                    1209600,
                    MAX_CONNECTION_STATUS_APPROVED,
                    1
                );
        $idDIAC1 = $this->_insertDataIntermediateAdConnection($aData);
        // Insert the variable values for the connection
        $aData = array(
                    1,
                    $idDIAC1,
                    $idTrackerVar1,
                    'test non-unique'
                );
        $this->_insertDataIntermediateAdVariableValue($aData);
        $aData = array(
                    2,
                    $idDIAC1,
                    $idTrackerVar2,
                    'test unique'
                );
        $this->_insertDataIntermediateAdVariableValue($aData);
        // Insert a connection at 12:15:00, from a click on ad ID 7, zone ID 8, at 12:14,
        // using tracker ID 2 (one variable value)
        $aData = array(
                    2,
                    'singleDB',
                    2,
                    'viewerid2',
                    '2005-09-05 12:15:00',
                    '2005-09-05 12:14:00',
                    2,
                    7,
                    0,
                    8,
                    MAX_CONNECTION_AD_CLICK,
                    1209600,
                    MAX_CONNECTION_STATUS_APPROVED,
                    1
                );
        $idDIAC2 = $this->_insertDataIntermediateAdConnection($aData);
        // Insert the variable values for the connection
        $aData = array(
                    3,
                    $idDIAC2,
                    $idTrackerVar3,
                    'test unique'
                );
        $this->_insertDataIntermediateAdVariableValue($aData);
        // Dedupe this hour
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');
        $dsa = $this->oMDMSF->factory("AdServer");
        $dsa->_saveIntermediateDeduplicateConversions($oStartDate, $oEndDate);
        // Ensure that both conversions have NOT been deduped
        $aRow = $this->_countDataIntermediateAdConnections();
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 2);
        $aRow = $this->_countDataIntermediateAdConnectionsApproved();
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 2);
        $aRow = $this->_queryDataIntermediateAdConnectionsById($idDIAC1);
        $this->assertEqual(count($aRow), 2);
        $this->assertEqual($aRow['connection_status'], MAX_CONNECTION_STATUS_APPROVED);
        $this->assertEqual($aRow['comments'], '');
        $aRow = $this->_queryDataIntermediateAdConnectionsById($idDIAC2);
        $this->assertEqual(count($aRow), 2);
        $this->assertEqual($aRow['connection_status'], MAX_CONNECTION_STATUS_APPROVED);
        $this->assertEqual($aRow['comments'], '');
        // Insert a connection at 13:05:00, from a click on ad ID 5, zone ID 6, at 13:04,
        // using tracker ID 1 (two variable values)
        $aData = array(
                    3,
                    'singleDB',
                    3,
                    'viewerid3',
                    '2005-09-05 13:05:00',
                    '2005-09-05 13:04:00',
                    1,
                    5,
                    0,
                    6,
                    MAX_CONNECTION_AD_CLICK,
                    1209600,
                    MAX_CONNECTION_STATUS_APPROVED,
                    1
                );
        $idDIAC3 = $this->_insertDataIntermediateAdConnection($aData);
        // Insert the variable values for the connection
        $aData = array(
                    4,
                    $idDIAC3,
                    $idTrackerVar1,
                    'test non-unique'
                );
        $this->_insertDataIntermediateAdVariableValue($aData);
        $aData = array(
                    5,
                    $idDIAC3,
                    $idTrackerVar2,
                    'test unique different'
                );
        $this->_insertDataIntermediateAdVariableValue($aData);
        // Insert a connection at 13:06:00, from a click on ad ID 5, zone ID 6, at 13:05,
        // using tracker ID 1 (two variable values)
        $aData = array(
                    4,
                    'singleDB',
                    4,
                    'viewerid3',
                    '2005-09-05 13:06:00',
                    '2005-09-05 13:05:00',
                    1,
                    5,
                    0,
                    6,
                    MAX_CONNECTION_AD_CLICK,
                    1209600,
                    MAX_CONNECTION_STATUS_APPROVED,
                    1
                );
        $idDIAC4 = $this->_insertDataIntermediateAdConnection($aData);
        // Insert the variable values for the connection
        $aData = array(
                    6,
                    $idDIAC4,
                    $idTrackerVar1,
                    'test non-unique'
                );
        $this->_insertDataIntermediateAdVariableValue($aData);
        $aData = array(
                    7,
                    $idDIAC4,
                    $idTrackerVar2,
                    'test unique'
                );
        $this->_insertDataIntermediateAdVariableValue($aData);
        // Dedupe this hour
        $oStartDate = new Date('2005-09-05 13:00:00');
        $oEndDate   = new Date('2005-09-07 13:29:59');
        $dsa = $this->oMDMSF->factory("AdServer");
        $dsa->_saveIntermediateDeduplicateConversions($oStartDate, $oEndDate);
        // Ensure that both only the correct conversions has been deduped
        $aRow = $this->_countDataIntermediateAdConnections();
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 4);
        $aRow = $this->_countDataIntermediateAdConnectionsApproved();
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 3);
        $aRow = $this->_countDataIntermediateAdConnectionsDuplicate();
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 1);
        $aRow = $this->_queryDataIntermediateAdConnectionsById($idDIAC1);
        $this->assertEqual(count($aRow), 2);
        $this->assertEqual($aRow['connection_status'], MAX_CONNECTION_STATUS_APPROVED);
        $this->assertEqual($aRow['comments'], '');
        $aRow = $this->_queryDataIntermediateAdConnectionsById($idDIAC2);
        $this->assertEqual(count($aRow), 2);
        $this->assertEqual($aRow['connection_status'], MAX_CONNECTION_STATUS_APPROVED);
        $this->assertEqual($aRow['comments'], '');
        $aRow = $this->_queryDataIntermediateAdConnectionsById($idDIAC3);
        $this->assertEqual(count($aRow), 2);
        $this->assertEqual($aRow['connection_status'], MAX_CONNECTION_STATUS_APPROVED);
        $this->assertEqual($aRow['comments'], '');
        $aRow = $this->_queryDataIntermediateAdConnectionsById($idDIAC4);
        $this->assertEqual(count($aRow), 2);
        $this->assertEqual($aRow['connection_status'], MAX_CONNECTION_STATUS_DUPLICATE);
        $this->assertEqual($aRow['comments'], 'Duplicate of connection ID '.$idDIAC1);
        // Insert a connection at 14:05:00, from a click on ad ID 5, zone ID 6, at 14:04,
        // using tracker ID 1 (two variable values)
        $aData = array(
                    5,
                    'singleDB',
                    5,
                    'viewerid3',
                    '2005-09-05 14:05:00',
                    '2005-09-05 14:04:00',
                    1,
                    5,
                    0,
                    6,
                    MAX_CONNECTION_AD_CLICK,
                    1209600,
                    MAX_CONNECTION_STATUS_APPROVED,
                    1
                );
        $idDIAC5 = $this->_insertDataIntermediateAdConnection($aData);
        // Insert the variable values for the connection
        $aData = array(
                    8,
                    $idDIAC5,
                    $idTrackerVar1,
                    'test non-unique'
                );
        $this->_insertDataIntermediateAdVariableValue($aData);
        $aData = array(
                    9,
                    $idDIAC5,
                    $idTrackerVar2,
                    'test unique'
                );
        $this->_insertDataIntermediateAdVariableValue($aData);
        // Insert a connection at 14:15:00, from a click on ad ID 7, zone ID 8, at 14:14,
        // using tracker ID 2 (one variable value)
        $aData = array(
                    6,
                    'singleDB',
                    6,
                    'viewerid2',
                    '2005-09-05 12:15:00',
                    '2005-09-05 12:14:00',
                    2,
                    7,
                    0,
                    8,
                    MAX_CONNECTION_AD_CLICK,
                    1209600,
                    MAX_CONNECTION_STATUS_APPROVED,
                    1
                );
        $idDIAC6 = $this->_insertDataIntermediateAdConnection($aData);
        // Insert the variable values for the connection
        $aData = array(
                    10,
                    $idDIAC6,
                    $idTrackerVar3,
                    'test unique'
                );
        $this->_insertDataIntermediateAdVariableValue($aData);
        // Dedupe this hour
        $oStartDate = new Date('2005-09-05 14:00:00');
        $oEndDate   = new Date('2005-09-07 14:29:59');
        $dsa = $this->oMDMSF->factory("AdServer");
        $dsa->_saveIntermediateDeduplicateConversions($oStartDate, $oEndDate);
        // Ensure that both only the correct conversions has been deduped
        $aRow = $this->_countDataIntermediateAdConnections();
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 6);
        $aRow = $this->_countDataIntermediateAdConnectionsApproved();
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 4);
        $aRow = $this->_countDataIntermediateAdConnectionsDuplicate();
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 2);
        $aRow = $this->_queryDataIntermediateAdConnectionsById($idDIAC1);
        $this->assertEqual(count($aRow), 2);
        $this->assertEqual($aRow['connection_status'], MAX_CONNECTION_STATUS_APPROVED);
        $this->assertEqual($aRow['comments'], '');
        $aRow = $this->_queryDataIntermediateAdConnectionsById($idDIAC2);
        $this->assertEqual(count($aRow), 2);
        $this->assertEqual($aRow['connection_status'], MAX_CONNECTION_STATUS_APPROVED);
        $this->assertEqual($aRow['comments'], '');
        $aRow = $this->_queryDataIntermediateAdConnectionsById($idDIAC3);
        $this->assertEqual(count($aRow), 2);
        $this->assertEqual($aRow['connection_status'], MAX_CONNECTION_STATUS_APPROVED);
        $this->assertEqual($aRow['comments'], '');
        $aRow = $this->_queryDataIntermediateAdConnectionsById($idDIAC4);
        $this->assertEqual(count($aRow), 2);
        $this->assertEqual($aRow['connection_status'], MAX_CONNECTION_STATUS_DUPLICATE);
        $this->assertEqual($aRow['comments'], 'Duplicate of connection ID '.$idDIAC1);
        $aRow = $this->_queryDataIntermediateAdConnectionsById($idDIAC5);
        $this->assertEqual(count($aRow), 2);
        $this->assertEqual($aRow['connection_status'], MAX_CONNECTION_STATUS_DUPLICATE);
        $this->assertEqual($aRow['comments'], 'Duplicate of connection ID '.$idDIAC4);
        $aRow = $this->_queryDataIntermediateAdConnectionsById($idDIAC6);
        $this->assertEqual(count($aRow), 2);
        $this->assertEqual($aRow['connection_status'], MAX_CONNECTION_STATUS_APPROVED);
        $this->assertEqual($aRow['comments'], '');

        DataGenerator::cleanUp();
    }

    /**
     * A method to perform testing of the _saveIntermediateDeduplicateConversions() method.
     *
     * Test 0:  Test with no conversions.
     *
     * Test 1:  Test with one conversion, no variable values, and ensure that
     *              the conversion status remains as "approved".
     * Test 2:  Test with two conversions, no variable values, and ensure that
     *              the conversion statuses remain as "approved".
     *
     * Test 3:  Test with one conversion, one variable value (not unique, NULL),
     *              and ensure that the conversion status remains as "approved".
     * Test 4:  Test with one conversion, one variable value (not unique, empty string),
     *              and ensure that the conversion status remains as "approved".
     * Test 5:  Test with one conversion, one variable value (not unique, real value),
     *              and ensure that the conversion status remains as "approved".
     *
     * Test 6:  Test with two conversions, one variable value (not unique, NULL, NULL),
     *              and ensure that the conversion statuses remain as "approved".
     * Test 7:  Test with two conversions, one variable value (not unique, NULL, empty string),
     *              and ensure that the conversion statuses remain as "approved".
     * Test 8:  Test with two conversions, one variable value (not unique, NULL, real value),
     *              and ensure that the conversion statuses remain as "approved".
     * Test 9:  Test with two conversions, one variable value (not unique, empty string, empty string),
     *              and ensure that the conversion statuses remain as "approved".
     * Test 10:  Test with two conversions, one variable value (not unique, empty string, real value),
     *              and ensure that the conversion statuses remain as "approved".
     * Test 11: Test with two conversions, one variable value (not unique, real value, real value),
     *              and ensure that the conversion statuses remain as "approved".
     *
     * Test 12: Test with one conversion, one variable value (unique, NULL),
     *              and ensure that the conversion status remains as "approved".
     * Test 13: Test with one conversion, one variable value (unique, empty string),
     *              and ensure that the conversion status remains as "approved".
     * Test 14: Test with one conversion, one variable value (unique, real value),
     *              and ensure that the conversion status remains as "approved".
     *
     * Test 15: Test with two conversions, one variable value (unique, NULL, NULL),
     *              and ensure that the conversion statuses remain as "approved".
     *              (NOTE: This is a special case! Although the two variable values are
     *                     the "same", we don't de-duplicate, because, well, how can you
     *                     de-dupe on nothing?)
     *
     * Test 16: Test with two conversions, one variable value (unique, NULL, empty string),
     *              and ensure that the conversion statuses remain as "approved".
     *
     * Test 17: Test with two conversions, one variable value (unique, NULL, real value),
     *              and ensure that the conversion statuses remain as "approved".
     *
     * Test 18: Test with two conversions, one variable value (unique, empty string, empty string),
     *              and ensure that the FIRST conversion has its status remain as "approved",
     *              and the SECOND conversion has its status changed to "duplicate".
     *
     * Test 19: Test with two conversions, one variable value (unique, empty string, real value),
     *              and ensure that the conversion statuses remain as "approved".
     *
     * Test 20: Test with two conversions, one variable value (unique, different real values),
     *              and ensure that the conversion statuses remain as "approved".
     *
     * Test 21: Test with two conversions, one variable value (unique, equal real values),
     *              and ensure that the FIRST conversion has its status remain as "approved",
     *              and the SECOND conversion has its status changed to "duplicate".
     *
     * Test 22: Test with duplicate conversions in different hours, both within the
     *              unique window of the original, within the unique window of a duplicate
     *              (only), and outside of the unique window.
     *
     */
    function OLD_test_saveIntermediateDeduplicateConversions()
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        $oDbh =& OA_DB::singleton();

        // Test 0
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');

        $oMDMSF = new OA_Dal_Maintenance_Statistics_Factory();
        $dsa = $oMDMSF->factory("AdServer");

        $dsa->_saveIntermediateDeduplicateConversions($oStartDate, $oEndDate);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_connection'],true);
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 0);
        TestEnv::restoreEnv();

        // Test 1
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');
        // Insert a connection at 12:10:00, from a click on ad ID 5, zone ID 6, at 12:09
        $tblDIAC = $oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_connection'],true);
        $query = "
            INSERT INTO
                {$tblDIAC}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status
                )
            VALUES
                (
                    1,
                    'singleDB',
                    1,
                    'viewerid1',
                    '2005-09-05 12:10:00',
                    '2005-09-05 12:09:00',
                    1,
                    5,
                    0,
                    6,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . "
                )";
        $rows = $oDbh->exec($query);
        $dsa = $oMDMSF->factory("AdServer");
        $dsa->_saveIntermediateDeduplicateConversions($oStartDate, $oEndDate);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$tblDIAC}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 1);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$tblDIAC}
            WHERE
                connection_status = " . MAX_CONNECTION_STATUS_APPROVED;
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 1);
        TestEnv::restoreEnv();

        // Test 2
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');
        // Insert a connection at 12:10:00, from a click on ad ID 5, zone ID 6, at 12:09
        $query = "
            INSERT INTO
                {$tblDIAC}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status
                )
            VALUES
                (
                    1,
                    'singleDB',
                    1,
                    'viewerid1',
                    '2005-09-05 12:10:00',
                    '2005-09-05 12:09:00',
                    1,
                    5,
                    0,
                    6,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . "
                )";
        $rows = $oDbh->exec($query);
        // Insert a connection at 12:30:00, from a click on ad ID 5, zone ID 6, at 12:29
        $query = "
            INSERT INTO
                {$tblDIAC}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status
                )
            VALUES
                (
                    2,
                    'singleDB',
                    2,
                    '357826bf941721cb697a032a3d31a969',
                    '2005-09-05 12:30:00',
                    '2005-09-05 12:29:00',
                    1,
                    5,
                    0,
                    6,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . "
                )";
        $rows = $oDbh->exec($query);
        $dsa = $oMDMSF->factory("AdServer");
        $dsa->_saveIntermediateDeduplicateConversions($oStartDate, $oEndDate);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$tblDIAC}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 2);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$tblDIAC}
            WHERE
                connection_status = " . MAX_CONNECTION_STATUS_APPROVED;
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 2);
        TestEnv::restoreEnv();

        // Test 3
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');
        // Prepare the variable value for the tracker
        $query = "
            INSERT INTO
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['variables'],true)."
                (
                    variableid,
                    trackerid,
                    name,
                    is_unique,
                    unique_window
                )
            VALUES
                (
                    1,
                    1,
                    'Test Non-Unique',
                    0,
                    3600
                )";
        $rows = $oDbh->exec($query);
        // Insert a connection at 12:10:00, from a click on ad ID 5, zone ID 6, at 12:09
        $query = "
            INSERT INTO
                {$tblDIAC}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status
                )
            VALUES
                (
                    1,
                    'singleDB',
                    1,
                    'viewerid1',
                    '2005-09-05 12:10:00',
                    '2005-09-05 12:09:00',
                    1,
                    5,
                    0,
                    6,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . "
                )";
        $rows = $oDbh->exec($query);
        // Insert the variable value for the connection
        $query = "
            INSERT INTO
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_variable_value'],true)."
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    1,
                    1,
                    1,
                    NULL
                )";
        $rows = $oDbh->exec($query);
        $dsa = $oMDMSF->factory("AdServer");
        $dsa->_saveIntermediateDeduplicateConversions($oStartDate, $oEndDate);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$tblDIAC}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 1);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$tblDIAC}
            WHERE
                connection_status = " . MAX_CONNECTION_STATUS_APPROVED;
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 1);
        TestEnv::restoreEnv();

        // Test 4
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');
        // Prepare the variable value for the tracker
        $query = "
            INSERT INTO
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['variables'],true)."
                (
                    variableid,
                    trackerid,
                    name,
                    is_unique,
                    unique_window
                )
            VALUES
                (
                    1,
                    1,
                    'Test Non-Unique',
                    0,
                    3600
                )";
        $rows = $oDbh->exec($query);
        // Insert a connection at 12:10:00, from a click on ad ID 5, zone ID 6, at 12:09
        $query = "
            INSERT INTO
                {$tblDIAC}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status
                )
            VALUES
                (
                    1,
                    'singleDB',
                    1,
                    'viewerid1',
                    '2005-09-05 12:10:00',
                    '2005-09-05 12:09:00',
                    1,
                    5,
                    0,
                    6,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . "
                )";
        $rows = $oDbh->exec($query);
        // Insert the variable value for the connection
        $query = "
            INSERT INTO
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_variable_value'],true)."
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    1,
                    1,
                    1,
                    ''
                )";
        $rows = $oDbh->exec($query);
        $dsa = $oMDMSF->factory("AdServer");
        $dsa->_saveIntermediateDeduplicateConversions($oStartDate, $oEndDate);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$tblDIAC}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 1);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$tblDIAC}
            WHERE
                connection_status = " . MAX_CONNECTION_STATUS_APPROVED;
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 1);
        TestEnv::restoreEnv();

        // Test 5
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');
        // Prepare the variable value for the tracker
        $query = "
            INSERT INTO
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['variables'],true)."
                (
                    variableid,
                    trackerid,
                    name,
                    is_unique,
                    unique_window
                )
            VALUES
                (
                    1,
                    1,
                    'Test Non-Unique',
                    0,
                    3600
                )";
        $rows = $oDbh->exec($query);
        // Insert a connection at 12:10:00, from a click on ad ID 5, zone ID 6, at 12:09
        $query = "
            INSERT INTO
                {$tblDIAC}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status
                )
            VALUES
                (
                    1,
                    'singleDB',
                    1,
                    'viewerid1',
                    '2005-09-05 12:10:00',
                    '2005-09-05 12:09:00',
                    1,
                    5,
                    0,
                    6,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . "
                )";
        $rows = $oDbh->exec($query);
        // Insert the variable value for the connection
        $query = "
            INSERT INTO
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_variable_value'],true)."
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    1,
                    1,
                    1,
                    'value'
                )";
        $rows = $oDbh->exec($query);
        $dsa = $oMDMSF->factory("AdServer");
        $dsa->_saveIntermediateDeduplicateConversions($oStartDate, $oEndDate);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$tblDIAC}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 1);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$tblDIAC}
            WHERE
                connection_status = " . MAX_CONNECTION_STATUS_APPROVED;
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 1);
        TestEnv::restoreEnv();

        // Test 6
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');
        // Prepare the variable value for the tracker
        $query = "
            INSERT INTO
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['variables'],true)."
                (
                    variableid,
                    trackerid,
                    name,
                    is_unique,
                    unique_window
                )
            VALUES
                (
                    1,
                    1,
                    'Test Non-Unique',
                    0,
                    3600
                )";
        $rows = $oDbh->exec($query);
        // Insert a connection at 12:10:00, from a click on ad ID 5, zone ID 6, at 12:09
        $query = "
            INSERT INTO
                {$tblDIAC}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status
                )
            VALUES
                (
                    1,
                    'singleDB',
                    1,
                    'viewerid1',
                    '2005-09-05 12:10:00',
                    '2005-09-05 12:09:00',
                    1,
                    5,
                    0,
                    6,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . "
                )";
        $rows = $oDbh->exec($query);
        // Insert the variable value for the connection
        $query = "
            INSERT INTO
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_variable_value'],true)."
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    1,
                    1,
                    1,
                    NULL
                )";
        $rows = $oDbh->exec($query);
        // Insert a connection at 12:30:00, from a click on ad ID 5, zone ID 6, at 12:29
        $query = "
            INSERT INTO
                {$tblDIAC}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status
                )
            VALUES
                (
                    2,
                    'singleDB',
                    2,
                    '357826bf941721cb697a032a3d31a969',
                    '2005-09-05 12:30:00',
                    '2005-09-05 12:29:00',
                    1,
                    5,
                    0,
                    6,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . "
                )";
        $rows = $oDbh->exec($query);
        // Insert the variable value for the connection
        $query = "
            INSERT INTO
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_variable_value'],true)."
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    2,
                    2,
                    1,
                    NULL
                )";
        $rows = $oDbh->exec($query);
        $dsa = $oMDMSF->factory("AdServer");
        $dsa->_saveIntermediateDeduplicateConversions($oStartDate, $oEndDate);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$tblDIAC}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 2);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$tblDIAC}
            WHERE
                connection_status = " . MAX_CONNECTION_STATUS_APPROVED;
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 2);
        TestEnv::restoreEnv();

        // Test 7
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');
        // Prepare the variable value for the tracker
        $query = "
            INSERT INTO
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['variables'],true)."
                (
                    variableid,
                    trackerid,
                    name,
                    is_unique,
                    unique_window
                )
            VALUES
                (
                    1,
                    1,
                    'Test Non-Unique',
                    0,
                    3600
                )";
        $rows = $oDbh->exec($query);
        // Insert a connection at 12:10:00, from a click on ad ID 5, zone ID 6, at 12:09
        $query = "
            INSERT INTO
                {$tblDIAC}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status
                )
            VALUES
                (
                    1,
                    'singleDB',
                    1,
                    'viewerid1',
                    '2005-09-05 12:10:00',
                    '2005-09-05 12:09:00',
                    1,
                    5,
                    0,
                    6,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . "
                )";
        $rows = $oDbh->exec($query);
        // Insert the variable value for the connection
        $query = "
            INSERT INTO
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_variable_value'],true)."
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    1,
                    1,
                    1,
                    NULL
                )";
        $rows = $oDbh->exec($query);
        // Insert a connection at 12:30:00, from a click on ad ID 5, zone ID 6, at 12:29
        $query = "
            INSERT INTO
                {$tblDIAC}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status
                )
            VALUES
                (
                    2,
                    'singleDB',
                    2,
                    '357826bf941721cb697a032a3d31a969',
                    '2005-09-05 12:30:00',
                    '2005-09-05 12:29:00',
                    1,
                    5,
                    0,
                    6,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . "
                )";
        $rows = $oDbh->exec($query);
        // Insert the variable value for the connection
        $query = "
            INSERT INTO
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_variable_value'],true)."
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    2,
                    2,
                    1,
                    ''
                )";
        $rows = $oDbh->exec($query);
        $dsa = $oMDMSF->factory("AdServer");
        $dsa->_saveIntermediateDeduplicateConversions($oStartDate, $oEndDate);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$tblDIAC}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 2);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$tblDIAC}
            WHERE
                connection_status = " . MAX_CONNECTION_STATUS_APPROVED;
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 2);
        TestEnv::restoreEnv();

        // Test 8
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');
        // Prepare the variable value for the tracker
        $query = "
            INSERT INTO
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['variables'],true)."
                (
                    variableid,
                    trackerid,
                    name,
                    is_unique,
                    unique_window
                )
            VALUES
                (
                    1,
                    1,
                    'Test Non-Unique',
                    0,
                    3600
                )";
        $rows = $oDbh->exec($query);
        // Insert a connection at 12:10:00, from a click on ad ID 5, zone ID 6, at 12:09
        $query = "
            INSERT INTO
                {$tblDIAC}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status
                )
            VALUES
                (
                    1,
                    'singleDB',
                    1,
                    'viewerid1',
                    '2005-09-05 12:10:00',
                    '2005-09-05 12:09:00',
                    1,
                    5,
                    0,
                    6,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . "
                )";
        $rows = $oDbh->exec($query);
        // Insert the variable value for the connection
        $query = "
            INSERT INTO
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_variable_value'],true)."
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    1,
                    1,
                    1,
                    NULL
                )";
        $rows = $oDbh->exec($query);
        // Insert a connection at 12:30:00, from a click on ad ID 5, zone ID 6, at 12:29
        $query = "
            INSERT INTO
                {$tblDIAC}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status
                )
            VALUES
                (
                    2,
                    'singleDB',
                    2,
                    '357826bf941721cb697a032a3d31a969',
                    '2005-09-05 12:30:00',
                    '2005-09-05 12:29:00',
                    1,
                    5,
                    0,
                    6,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . "
                )";
        $rows = $oDbh->exec($query);
        // Insert the variable value for the connection
        $query = "
            INSERT INTO
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_variable_value'],true)."
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    2,
                    2,
                    1,
                    'value'
                )";
        $rows = $oDbh->exec($query);
        $dsa = $oMDMSF->factory("AdServer");
        $dsa->_saveIntermediateDeduplicateConversions($oStartDate, $oEndDate);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$tblDIAC}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 2);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$tblDIAC}
            WHERE
                connection_status = " . MAX_CONNECTION_STATUS_APPROVED;
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 2);
        TestEnv::restoreEnv();

        // Test 9
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');
        // Prepare the variable value for the tracker
        $query = "
            INSERT INTO
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['variables'],true)."
                (
                    variableid,
                    trackerid,
                    name,
                    is_unique,
                    unique_window
                )
            VALUES
                (
                    1,
                    1,
                    'Test Non-Unique',
                    0,
                    3600
                )";
        $rows = $oDbh->exec($query);
        // Insert a connection at 12:10:00, from a click on ad ID 5, zone ID 6, at 12:09
        $query = "
            INSERT INTO
                {$tblDIAC}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status
                )
            VALUES
                (
                    1,
                    'singleDB',
                    1,
                    'viewerid1',
                    '2005-09-05 12:10:00',
                    '2005-09-05 12:09:00',
                    1,
                    5,
                    0,
                    6,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . "
                )";
        $rows = $oDbh->exec($query);
        // Insert the variable value for the connection
        $query = "
            INSERT INTO
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_variable_value'],true)."
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    1,
                    1,
                    1,
                    ''
                )";
        $rows = $oDbh->exec($query);
        // Insert a connection at 12:30:00, from a click on ad ID 5, zone ID 6, at 12:29
        $query = "
            INSERT INTO
                {$tblDIAC}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status
                )
            VALUES
                (
                    2,
                    'singleDB',
                    2,
                    '357826bf941721cb697a032a3d31a969',
                    '2005-09-05 12:30:00',
                    '2005-09-05 12:29:00',
                    1,
                    5,
                    0,
                    6,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . "
                )";
        $rows = $oDbh->exec($query);
        // Insert the variable value for the connection
        $query = "
            INSERT INTO
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_variable_value'],true)."
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    2,
                    2,
                    1,
                    ''
                )";
        $rows = $oDbh->exec($query);
        $dsa = $oMDMSF->factory("AdServer");
        $dsa->_saveIntermediateDeduplicateConversions($oStartDate, $oEndDate);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$tblDIAC}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 2);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$tblDIAC}
            WHERE
                connection_status = " . MAX_CONNECTION_STATUS_APPROVED;
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 2);
        TestEnv::restoreEnv();

        // Test 10
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');
        // Prepare the variable value for the tracker
        $query = "
            INSERT INTO
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['variables'],true)."
                (
                    variableid,
                    trackerid,
                    name,
                    is_unique,
                    unique_window
                )
            VALUES
                (
                    1,
                    1,
                    'Test Non-Unique',
                    0,
                    3600
                )";
        $rows = $oDbh->exec($query);
        // Insert a connection at 12:10:00, from a click on ad ID 5, zone ID 6, at 12:09
        $query = "
            INSERT INTO
                {$tblDIAC}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status
                )
            VALUES
                (
                    1,
                    'singleDB',
                    1,
                    'viewerid1',
                    '2005-09-05 12:10:00',
                    '2005-09-05 12:09:00',
                    1,
                    5,
                    0,
                    6,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . "
                )";
        $rows = $oDbh->exec($query);
        // Insert the variable value for the connection
        $query = "
            INSERT INTO
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_variable_value'],true)."
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    1,
                    1,
                    1,
                    ''
                )";
        $rows = $oDbh->exec($query);
        // Insert a connection at 12:30:00, from a click on ad ID 5, zone ID 6, at 12:29
        $query = "
            INSERT INTO
                {$tblDIAC}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status
                )
            VALUES
                (
                    2,
                    'singleDB',
                    2,
                    '357826bf941721cb697a032a3d31a969',
                    '2005-09-05 12:30:00',
                    '2005-09-05 12:29:00',
                    1,
                    5,
                    0,
                    6,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . "
                )";
        $rows = $oDbh->exec($query);
        // Insert the variable value for the connection
        $query = "
            INSERT INTO
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_variable_value'],true)."
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    2,
                    2,
                    1,
                    'value'
                )";
        $rows = $oDbh->exec($query);
        $dsa = $oMDMSF->factory("AdServer");
        $dsa->_saveIntermediateDeduplicateConversions($oStartDate, $oEndDate);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$tblDIAC}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 2);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$tblDIAC}
            WHERE
                connection_status = " . MAX_CONNECTION_STATUS_APPROVED;
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 2);
        TestEnv::restoreEnv();

        // Test 11
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');
        // Prepare the variable value for the tracker
        $query = "
            INSERT INTO
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['variables'],true)."
                (
                    variableid,
                    trackerid,
                    name,
                    is_unique,
                    unique_window
                )
            VALUES
                (
                    1,
                    1,
                    'Test Non-Unique',
                    0,
                    3600
                )";
        $rows = $oDbh->exec($query);
        // Insert a connection at 12:10:00, from a click on ad ID 5, zone ID 6, at 12:09
        $query = "
            INSERT INTO
                {$tblDIAC}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status
                )
            VALUES
                (
                    1,
                    'singleDB',
                    1,
                    'viewerid1',
                    '2005-09-05 12:10:00',
                    '2005-09-05 12:09:00',
                    1,
                    5,
                    0,
                    6,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . "
                )";
        $rows = $oDbh->exec($query);
        // Insert the variable value for the connection
        $query = "
            INSERT INTO
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_variable_value'],true)."
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    1,
                    1,
                    1,
                    'value'
                )";
        $rows = $oDbh->exec($query);
        // Insert a connection at 12:30:00, from a click on ad ID 5, zone ID 6, at 12:29
        $query = "
            INSERT INTO
                {$tblDIAC}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status
                )
            VALUES
                (
                    2,
                    'singleDB',
                    2,
                    '357826bf941721cb697a032a3d31a969',
                    '2005-09-05 12:30:00',
                    '2005-09-05 12:29:00',
                    1,
                    5,
                    0,
                    6,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . "
                )";
        $rows = $oDbh->exec($query);
        // Insert the variable value for the connection
        $query = "
            INSERT INTO
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_variable_value'],true)."
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    2,
                    2,
                    1,
                    'value'
                )";
        $rows = $oDbh->exec($query);
        $dsa = $oMDMSF->factory("AdServer");
        $dsa->_saveIntermediateDeduplicateConversions($oStartDate, $oEndDate);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$tblDIAC}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 2);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$tblDIAC}
            WHERE
                connection_status = " . MAX_CONNECTION_STATUS_APPROVED;
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 2);
        TestEnv::restoreEnv();

        // Test 12
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');
        // Prepare the variable value for the tracker
        $query = "
            INSERT INTO
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['variables'],true)."
                (
                    variableid,
                    trackerid,
                    name,
                    is_unique,
                    unique_window
                )
            VALUES
                (
                    1,
                    1,
                    'Test Unique',
                    1,
                    3600
                )";
        $rows = $oDbh->exec($query);
        // Insert a connection at 12:10:00, from a click on ad ID 5, zone ID 6, at 12:09
        $query = "
            INSERT INTO
                {$tblDIAC}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status
                )
            VALUES
                (
                    1,
                    'singleDB',
                    1,
                    'viewerid1',
                    '2005-09-05 12:10:00',
                    '2005-09-05 12:09:00',
                    1,
                    5,
                    0,
                    6,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . "
                )";
        $rows = $oDbh->exec($query);
        // Insert the variable value for the connection
        $query = "
            INSERT INTO
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_variable_value'],true)."
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    1,
                    1,
                    1,
                    NULL
                )";
        $rows = $oDbh->exec($query);
        $dsa = $oMDMSF->factory("AdServer");
        $dsa->_saveIntermediateDeduplicateConversions($oStartDate, $oEndDate);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$tblDIAC}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 1);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$tblDIAC}
            WHERE
                connection_status = " . MAX_CONNECTION_STATUS_APPROVED;
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 1);
        TestEnv::restoreEnv();

        // Test 13
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');
        // Prepare the variable value for the tracker
        $query = "
            INSERT INTO
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['variables'],true)."
                (
                    variableid,
                    trackerid,
                    name,
                    is_unique,
                    unique_window
                )
            VALUES
                (
                    1,
                    1,
                    'Test Unique',
                    1,
                    3600
                )";
        $rows = $oDbh->exec($query);
        // Insert a connection at 12:10:00, from a click on ad ID 5, zone ID 6, at 12:09
        $query = "
            INSERT INTO
                {$tblDIAC}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status
                )
            VALUES
                (
                    1,
                    'singleDB',
                    1,
                    'viewerid1',
                    '2005-09-05 12:10:00',
                    '2005-09-05 12:09:00',
                    1,
                    5,
                    0,
                    6,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . "
                )";
        $rows = $oDbh->exec($query);
        // Insert the variable value for the connection
        $query = "
            INSERT INTO
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_variable_value'],true)."
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    1,
                    1,
                    1,
                    ''
                )";
        $rows = $oDbh->exec($query);
        $dsa = $oMDMSF->factory("AdServer");
        $dsa->_saveIntermediateDeduplicateConversions($oStartDate, $oEndDate);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$tblDIAC}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 1);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$tblDIAC}
            WHERE
                connection_status = " . MAX_CONNECTION_STATUS_APPROVED;
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 1);
        TestEnv::restoreEnv();

        // Test 14
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');
        // Prepare the variable value for the tracker
        $query = "
            INSERT INTO
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['variables'],true)."
                (
                    variableid,
                    trackerid,
                    name,
                    is_unique,
                    unique_window
                )
            VALUES
                (
                    1,
                    1,
                    'Test Unique',
                    1,
                    3600
                )";
        $rows = $oDbh->exec($query);
        // Insert a connection at 12:10:00, from a click on ad ID 5, zone ID 6, at 12:09
        $query = "
            INSERT INTO
                {$tblDIAC}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status
                )
            VALUES
                (
                    1,
                    'singleDB',
                    1,
                    'viewerid1',
                    '2005-09-05 12:10:00',
                    '2005-09-05 12:09:00',
                    1,
                    5,
                    0,
                    6,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . "
                )";
        $rows = $oDbh->exec($query);
        // Insert the variable value for the connection
        $query = "
            INSERT INTO
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_variable_value'],true)."
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    1,
                    1,
                    1,
                    'value'
                )";
        $rows = $oDbh->exec($query);
        $dsa = $oMDMSF->factory("AdServer");
        $dsa->_saveIntermediateDeduplicateConversions($oStartDate, $oEndDate);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$tblDIAC}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 1);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$tblDIAC}
            WHERE
                connection_status = " . MAX_CONNECTION_STATUS_APPROVED;
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 1);
        TestEnv::restoreEnv();

        // Test 15
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');
        // Prepare the variable value for the tracker
        $query = "
            INSERT INTO
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['variables'],true)."
                (
                    variableid,
                    trackerid,
                    name,
                    is_unique,
                    unique_window
                )
            VALUES
                (
                    1,
                    1,
                    'Test Unique',
                    1,
                    3600
                )";
        $rows = $oDbh->exec($query);
        // Insert a connection at 12:10:00, from a click on ad ID 5, zone ID 6, at 12:09
        $query = "
            INSERT INTO
                {$tblDIAC}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status
                )
            VALUES
                (
                    1,
                    'singleDB',
                    1,
                    'viewerid1',
                    '2005-09-05 12:10:00',
                    '2005-09-05 12:09:00',
                    1,
                    5,
                    0,
                    6,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . "
                )";
        $rows = $oDbh->exec($query);
        // Insert the variable value for the connection
        $query = "
            INSERT INTO
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_variable_value'],true)."
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    1,
                    1,
                    1,
                    NULL
                )";
        $rows = $oDbh->exec($query);
        // Insert a connection at 12:30:00, from a click on ad ID 5, zone ID 6, at 12:29
        $query = "
            INSERT INTO
                {$tblDIAC}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status
                )
            VALUES
                (
                    2,
                    'singleDB',
                    2,
                    '357826bf941721cb697a032a3d31a969',
                    '2005-09-05 12:30:00',
                    '2005-09-05 12:29:00',
                    1,
                    5,
                    0,
                    6,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . "
                )";
        $rows = $oDbh->exec($query);
        // Insert the variable value for the connection
        $query = "
            INSERT INTO
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_variable_value'],true)."
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    2,
                    2,
                    1,
                    NULL
                )";
        $rows = $oDbh->exec($query);
        $dsa = $oMDMSF->factory("AdServer");
        $dsa->_saveIntermediateDeduplicateConversions($oStartDate, $oEndDate);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$tblDIAC}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 2);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$tblDIAC}
            WHERE
                connection_status = " . MAX_CONNECTION_STATUS_APPROVED;
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 2);
        TestEnv::restoreEnv();

        // Test 16
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');
        // Prepare the variable value for the tracker
        $query = "
            INSERT INTO
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['variables'],true)."
                (
                    variableid,
                    trackerid,
                    name,
                    is_unique,
                    unique_window
                )
            VALUES
                (
                    1,
                    1,
                    'Test Unique',
                    1,
                    3600
                )";
        $rows = $oDbh->exec($query);
        // Insert a connection at 12:10:00, from a click on ad ID 5, zone ID 6, at 12:09
        $query = "
            INSERT INTO
                {$tblDIAC}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status
                )
            VALUES
                (
                    1,
                    'singleDB',
                    1,
                    'viewerid1',
                    '2005-09-05 12:10:00',
                    '2005-09-05 12:09:00',
                    1,
                    5,
                    0,
                    6,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . "
                )";
        $rows = $oDbh->exec($query);
        // Insert the variable value for the connection
        $query = "
            INSERT INTO
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_variable_value'],true)."
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    1,
                    1,
                    1,
                    NULL
                )";
        $rows = $oDbh->exec($query);
        // Insert a connection at 12:30:00, from a click on ad ID 5, zone ID 6, at 12:29
        $query = "
            INSERT INTO
                {$tblDIAC}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status
                )
            VALUES
                (
                    2,
                    'singleDB',
                    2,
                    '357826bf941721cb697a032a3d31a969',
                    '2005-09-05 12:30:00',
                    '2005-09-05 12:29:00',
                    1,
                    5,
                    0,
                    6,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . "
                )";
        $rows = $oDbh->exec($query);
        // Insert the variable value for the connection
        $query = "
            INSERT INTO
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_variable_value'],true)."
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    2,
                    2,
                    1,
                    ''
                )";
        $rows = $oDbh->exec($query);
        $dsa = $oMDMSF->factory("AdServer");
        $dsa->_saveIntermediateDeduplicateConversions($oStartDate, $oEndDate);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$tblDIAC}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 2);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$tblDIAC}
            WHERE
                connection_status = " . MAX_CONNECTION_STATUS_APPROVED;
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 2);
        TestEnv::restoreEnv();

        // Test 17
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');
        // Prepare the variable value for the tracker
        $query = "
            INSERT INTO
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['variables'],true)."
                (
                    variableid,
                    trackerid,
                    name,
                    is_unique,
                    unique_window
                )
            VALUES
                (
                    1,
                    1,
                    'Test Unique',
                    1,
                    3600
                )";
        $rows = $oDbh->exec($query);
        // Insert a connection at 12:10:00, from a click on ad ID 5, zone ID 6, at 12:09
        $query = "
            INSERT INTO
                {$tblDIAC}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status
                )
            VALUES
                (
                    1,
                    'singleDB',
                    1,
                    'viewerid1',
                    '2005-09-05 12:10:00',
                    '2005-09-05 12:09:00',
                    1,
                    5,
                    0,
                    6,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . "
                )";
        $rows = $oDbh->exec($query);
        // Insert the variable value for the connection
        $query = "
            INSERT INTO
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_variable_value'],true)."
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    1,
                    1,
                    1,
                    NULL
                )";
        $rows = $oDbh->exec($query);
        // Insert a connection at 12:30:00, from a click on ad ID 5, zone ID 6, at 12:29
        $query = "
            INSERT INTO
                {$tblDIAC}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status
                )
            VALUES
                (
                    2,
                    'singleDB',
                    2,
                    '357826bf941721cb697a032a3d31a969',
                    '2005-09-05 12:30:00',
                    '2005-09-05 12:29:00',
                    1,
                    5,
                    0,
                    6,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . "
                )";
        $rows = $oDbh->exec($query);
        // Insert the variable value for the connection
        $query = "
            INSERT INTO
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_variable_value'],true)."
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    2,
                    2,
                    1,
                    'value'
                )";
        $rows = $oDbh->exec($query);
        $dsa = $oMDMSF->factory("AdServer");
        $dsa->_saveIntermediateDeduplicateConversions($oStartDate, $oEndDate);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$tblDIAC}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 2);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$tblDIAC}
            WHERE
                connection_status = " . MAX_CONNECTION_STATUS_APPROVED;
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 2);
        TestEnv::restoreEnv();

        // Test 18
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');
        // Prepare the variable value for the tracker
        $query = "
            INSERT INTO
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['variables'],true)."
                (
                    variableid,
                    trackerid,
                    name,
                    is_unique,
                    unique_window
                )
            VALUES
                (
                    1,
                    1,
                    'Test Unique',
                    1,
                    3600
                )";
        $rows = $oDbh->exec($query);
        // Insert a connection at 12:10:00, from a click on ad ID 5, zone ID 6, at 12:09
        $query = "
            INSERT INTO
                {$tblDIAC}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status,
                    inside_window
                )
            VALUES
                (
                    1,
                    'singleDB',
                    1,
                    'viewerid1',
                    '2005-09-05 12:10:00',
                    '2005-09-05 12:09:00',
                    1,
                    5,
                    0,
                    6,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . ",
                    1
                )";
        $rows = $oDbh->exec($query);
        // Insert the variable value for the connection
        $query = "
            INSERT INTO
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_variable_value'],true)."
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    1,
                    1,
                    1,
                    ''
                )";
        $rows = $oDbh->exec($query);
        // Insert a connection at 12:30:00, from a click on ad ID 5, zone ID 6, at 12:29
        $query = "
            INSERT INTO
                {$tblDIAC}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status,
                    inside_window
                )
            VALUES
                (
                    2,
                    'singleDB',
                    2,
                    '357826bf941721cb697a032a3d31a969',
                    '2005-09-05 12:30:00',
                    '2005-09-05 12:29:00',
                    1,
                    5,
                    0,
                    6,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . ",
                    1
                )";
        $rows = $oDbh->exec($query);
        // Insert the variable value for the connection
        $query = "
            INSERT INTO
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_variable_value'],true)."
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    2,
                    2,
                    1,
                    ''
                )";
        $rows = $oDbh->exec($query);
        $dsa = $oMDMSF->factory("AdServer");
        $dsa->_saveIntermediateDeduplicateConversions($oStartDate, $oEndDate);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$tblDIAC}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 2);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$tblDIAC}
            WHERE
                connection_status = " . MAX_CONNECTION_STATUS_APPROVED;
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 1);
        $query = "
            SELECT
                connection_status,
                comments

            FROM
                {$tblDIAC}
            WHERE
                data_intermediate_ad_connection_id = 1";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 2);
        $this->assertEqual($aRow['connection_status'], MAX_CONNECTION_STATUS_APPROVED);
        $this->assertEqual($aRow['comments'], '');
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$tblDIAC}
            WHERE
                connection_status = " . MAX_CONNECTION_STATUS_DUPLICATE;
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 1);
        $query = "
            SELECT
                connection_status,
                comments

            FROM
                {$tblDIAC}
            WHERE
                data_intermediate_ad_connection_id = 2";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 2);
        $this->assertEqual($aRow['connection_status'], MAX_CONNECTION_STATUS_DUPLICATE);
        $this->assertEqual($aRow['comments'], 'Duplicate of connection ID 1');
        TestEnv::restoreEnv();

        // Test 19
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');
        // Prepare the variable value for the tracker
        $query = "
            INSERT INTO
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['variables'],true)."
                (
                    variableid,
                    trackerid,
                    name,
                    is_unique,
                    unique_window
                )
            VALUES
                (
                    1,
                    1,
                    'Test Unique',
                    1,
                    3600
                )";
        $rows = $oDbh->exec($query);
        // Insert a connection at 12:10:00, from a click on ad ID 5, zone ID 6, at 12:09
        $query = "
            INSERT INTO
                {$tblDIAC}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status,
                    inside_window
                )
            VALUES
                (
                    1,
                    'singleDB',
                    1,
                    'viewerid1',
                    '2005-09-05 12:10:00',
                    '2005-09-05 12:09:00',
                    1,
                    5,
                    0,
                    6,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . ",
                    1
                )";
        $rows = $oDbh->exec($query);
        // Insert the variable value for the connection
        $query = "
            INSERT INTO
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_variable_value'],true)."
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    1,
                    1,
                    1,
                    ''
                )";
        $rows = $oDbh->exec($query);
        // Insert a connection at 12:30:00, from a click on ad ID 5, zone ID 6, at 12:29
        $query = "
            INSERT INTO
                {$tblDIAC}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status,
                    inside_window
                )
            VALUES
                (
                    2,
                    'singleDB',
                    2,
                    '357826bf941721cb697a032a3d31a969',
                    '2005-09-05 12:30:00',
                    '2005-09-05 12:29:00',
                    1,
                    5,
                    0,
                    6,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . ",
                    1
                )";
        $rows = $oDbh->exec($query);
        // Insert the variable value for the connection
        $query = "
            INSERT INTO
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_variable_value'],true)."
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    2,
                    2,
                    1,
                    'value'
                )";
        $rows = $oDbh->exec($query);
        $dsa = $oMDMSF->factory("AdServer");
        $dsa->_saveIntermediateDeduplicateConversions($oStartDate, $oEndDate);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$tblDIAC}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 2);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$tblDIAC}
            WHERE
                connection_status = " . MAX_CONNECTION_STATUS_APPROVED;
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 2);
        TestEnv::restoreEnv();

        // Test 20
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');
        // Prepare the variable value for the tracker
        $query = "
            INSERT INTO
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['variables'],true)."
                (
                    variableid,
                    trackerid,
                    name,
                    is_unique,
                    unique_window
                )
            VALUES
                (
                    1,
                    1,
                    'Test Unique',
                    1,
                    3600
                )";
        $rows = $oDbh->exec($query);
        // Insert a connection at 12:10:00, from a click on ad ID 5, zone ID 6, at 12:09
        $query = "
            INSERT INTO
                {$tblDIAC}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status,
                    inside_window
                )
            VALUES
                (
                    1,
                    'singleDB',
                    1,
                    'viewerid1',
                    '2005-09-05 12:10:00',
                    '2005-09-05 12:09:00',
                    1,
                    5,
                    0,
                    6,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . ",
                    1
                )";
        $rows = $oDbh->exec($query);
        // Insert the variable value for the connection
        $query = "
            INSERT INTO
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_variable_value'],true)."
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    1,
                    1,
                    1,
                    'value1'
                )";
        $rows = $oDbh->exec($query);
        // Insert a connection at 12:30:00, from a click on ad ID 5, zone ID 6, at 12:29
        $query = "
            INSERT INTO
                {$tblDIAC}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status,
                    inside_window
                )
            VALUES
                (
                    2,
                    'singleDB',
                    2,
                    '357826bf941721cb697a032a3d31a969',
                    '2005-09-05 12:30:00',
                    '2005-09-05 12:29:00',
                    1,
                    5,
                    0,
                    6,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . ",
                    1
                )";
        $rows = $oDbh->exec($query);
        // Insert the variable value for the connection
        $query = "
            INSERT INTO
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_variable_value'],true)."
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    2,
                    2,
                    1,
                    'value2'
                )";
        $rows = $oDbh->exec($query);
        $dsa = $oMDMSF->factory("AdServer");
        $dsa->_saveIntermediateDeduplicateConversions($oStartDate, $oEndDate);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$tblDIAC}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 2);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$tblDIAC}
            WHERE
                connection_status = " . MAX_CONNECTION_STATUS_APPROVED;
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 2);
        TestEnv::restoreEnv();

        // Test 21
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');
        // Prepare the variable value for the tracker
        $query = "
            INSERT INTO
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['variables'],true)."
                (
                    variableid,
                    trackerid,
                    name,
                    is_unique,
                    unique_window
                )
            VALUES
                (
                    1,
                    1,
                    'Test Unique',
                    1,
                    3600
                )";
        $rows = $oDbh->exec($query);
        // Insert a connection at 12:10:00, from a click on ad ID 5, zone ID 6, at 12:09
        $query = "
            INSERT INTO
                {$tblDIAC}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status,
                    inside_window
                )
            VALUES
                (
                    1,
                    'singleDB',
                    1,
                    'viewerid1',
                    '2005-09-05 12:10:00',
                    '2005-09-05 12:09:00',
                    1,
                    5,
                    0,
                    6,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . ",
                    1
                )";
        $rows = $oDbh->exec($query);
        // Insert the variable value for the connection
        $query = "
            INSERT INTO
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_variable_value'],true)."
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    1,
                    1,
                    1,
                    'value'
                )";
        $rows = $oDbh->exec($query);
        // Insert a connection at 12:30:00, from a click on ad ID 5, zone ID 6, at 12:29
        $query = "
            INSERT INTO
                {$tblDIAC}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status,
                    inside_window
                )
            VALUES
                (
                    2,
                    'singleDB',
                    2,
                    '357826bf941721cb697a032a3d31a969',
                    '2005-09-05 12:30:00',
                    '2005-09-05 12:29:00',
                    1,
                    5,
                    0,
                    6,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . ",
                    1
                )";
        $rows = $oDbh->exec($query);
        // Insert the variable value for the connection
        $query = "
            INSERT INTO
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_variable_value'],true)."
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    2,
                    2,
                    1,
                    'value'
                )";
        $rows = $oDbh->exec($query);
        $dsa = $oMDMSF->factory("AdServer");
        $dsa->_saveIntermediateDeduplicateConversions($oStartDate, $oEndDate);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$tblDIAC}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 2);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$tblDIAC}
            WHERE
                connection_status = " . MAX_CONNECTION_STATUS_APPROVED;
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 1);
        $query = "
            SELECT
                connection_status,
                comments

            FROM
                {$tblDIAC}
            WHERE
                data_intermediate_ad_connection_id = 1";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 2);
        $this->assertEqual($aRow['connection_status'], MAX_CONNECTION_STATUS_APPROVED);
        $this->assertEqual($aRow['comments'], '');
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$tblDIAC}
            WHERE
                connection_status = " . MAX_CONNECTION_STATUS_DUPLICATE;
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 1);
        $query = "
            SELECT
                connection_status,
                comments

            FROM
                {$tblDIAC}
            WHERE
                data_intermediate_ad_connection_id = 2";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 2);
        $this->assertEqual($aRow['connection_status'], MAX_CONNECTION_STATUS_DUPLICATE);
        $this->assertEqual($aRow['comments'], 'Duplicate of connection ID 1');
        TestEnv::restoreEnv();

        // Test 22
        // Prepare the variable values for the tracker
        $query = "
            INSERT INTO
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['variables'],true)."
                (
                    variableid,
                    trackerid,
                    name,
                    is_unique,
                    unique_window
                )
            VALUES
                (
                    1,
                    1,
                    'Test Non-Unique',
                    0,
                    3600
                )";
        $rows = $oDbh->exec($query);
        $query = "
            INSERT INTO
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['variables'],true)."
                (
                    variableid,
                    trackerid,
                    name,
                    is_unique,
                    unique_window
                )
            VALUES
                (
                    2,
                    1,
                    'Test Unique',
                    1,
                    3600
                )";
        $rows = $oDbh->exec($query);
        $query = "
            INSERT INTO
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['variables'],true)."
                (
                    variableid,
                    trackerid,
                    name,
                    is_unique,
                    unique_window
                )
            VALUES
                (
                    3,
                    2,
                    'Test Unique',
                    1,
                    3600
                )";
        $rows = $oDbh->exec($query);
        // Insert a connection at 12:10:00, from a click on ad ID 5, zone ID 6, at 12:09,
        // using tracker ID 1 (two variable values)
        $query = "
            INSERT INTO
                {$tblDIAC}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status,
                    inside_window
                )
            VALUES
                (
                    1,
                    'singleDB',
                    1,
                    'viewerid1',
                    '2005-09-05 12:10:00',
                    '2005-09-05 12:09:00',
                    1,
                    5,
                    0,
                    6,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . ",
                    1
                )";
        $rows = $oDbh->exec($query);
        // Insert the variable values for the connection
        $query = "
            INSERT INTO
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_variable_value'],true)."
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    1,
                    1,
                    1,
                    'test non-unique'
                )";
        $rows = $oDbh->exec($query);
        $query = "
            INSERT INTO
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_variable_value'],true)."
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    2,
                    1,
                    2,
                    'test unique'
                )";
        $rows = $oDbh->exec($query);
        // Insert a connection at 12:15:00, from a click on ad ID 7, zone ID 8, at 12:14,
        // using tracker ID 2 (one variable value)
        $query = "
            INSERT INTO
                {$tblDIAC}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status,
                    inside_window
                )
            VALUES
                (
                    2,
                    'singleDB',
                    2,
                    'viewerid2',
                    '2005-09-05 12:15:00',
                    '2005-09-05 12:14:00',
                    2,
                    7,
                    0,
                    8,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . ",
                    1
                )";
        $rows = $oDbh->exec($query);
        // Insert the variable values for the connection
        $query = "
            INSERT INTO
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_variable_value'],true)."
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    3,
                    2,
                    3,
                    'test unique'
                )";
        $rows = $oDbh->exec($query);
        // Dedupe this hour
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');
        $dsa = $oMDMSF->factory("AdServer");
        $dsa->_saveIntermediateDeduplicateConversions($oStartDate, $oEndDate);
        // Ensure that both conversions have NOT been deduped
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$tblDIAC}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 2);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$tblDIAC}
            WHERE
                connection_status = " . MAX_CONNECTION_STATUS_APPROVED;
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 2);
        $query = "
            SELECT
                connection_status,
                comments

            FROM
                {$tblDIAC}
            WHERE
                data_intermediate_ad_connection_id = 1";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 2);
        $this->assertEqual($aRow['connection_status'], MAX_CONNECTION_STATUS_APPROVED);
        $this->assertEqual($aRow['comments'], '');
        $query = "
            SELECT
                connection_status,
                comments

            FROM
                {$tblDIAC}
            WHERE
                data_intermediate_ad_connection_id = 2";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 2);
        $this->assertEqual($aRow['connection_status'], MAX_CONNECTION_STATUS_APPROVED);
        $this->assertEqual($aRow['comments'], '');
        // Insert a connection at 13:05:00, from a click on ad ID 5, zone ID 6, at 13:04,
        // using tracker ID 1 (two variable values)
        $query = "
            INSERT INTO
                {$tblDIAC}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status,
                    inside_window
                )
            VALUES
                (
                    3,
                    'singleDB',
                    3,
                    'viewerid3',
                    '2005-09-05 13:05:00',
                    '2005-09-05 13:04:00',
                    1,
                    5,
                    0,
                    6,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . ",
                    1
                )";
        $rows = $oDbh->exec($query);
        // Insert the variable values for the connection
        $query = "
            INSERT INTO
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_variable_value'],true)."
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    4,
                    3,
                    1,
                    'test non-unique'
                )";
        $rows = $oDbh->exec($query);
        $query = "
            INSERT INTO
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_variable_value'],true)."
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    5,
                    3,
                    2,
                    'test unique different'
                )";
        $rows = $oDbh->exec($query);
        // Insert a connection at 13:06:00, from a click on ad ID 5, zone ID 6, at 13:05,
        // using tracker ID 1 (two variable values)
        $query = "
            INSERT INTO
                {$tblDIAC}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status,
                    inside_window
                )
            VALUES
                (
                    4,
                    'singleDB',
                    4,
                    'viewerid3',
                    '2005-09-05 13:06:00',
                    '2005-09-05 13:05:00',
                    1,
                    5,
                    0,
                    6,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . ",
                    1
                )";
        $rows = $oDbh->exec($query);
        // Insert the variable values for the connection
        $query = "
            INSERT INTO
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_variable_value'],true)."
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    6,
                    4,
                    1,
                    'test non-unique'
                )";
        $rows = $oDbh->exec($query);
        $query = "
            INSERT INTO
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_variable_value'],true)."
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    7,
                    4,
                    2,
                    'test unique'
                )";
        $rows = $oDbh->exec($query);
        // Dedupe this hour
        $oStartDate = new Date('2005-09-05 13:00:00');
        $oEndDate   = new Date('2005-09-07 13:29:59');
        $dsa = $oMDMSF->factory("AdServer");
        $dsa->_saveIntermediateDeduplicateConversions($oStartDate, $oEndDate);
        // Ensure that both only the correct conversions has been deduped
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$tblDIAC}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 4);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$tblDIAC}
            WHERE
                connection_status = " . MAX_CONNECTION_STATUS_APPROVED;
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 3);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$tblDIAC}
            WHERE
                connection_status = " . MAX_CONNECTION_STATUS_DUPLICATE;
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 1);
        $query = "
            SELECT
                connection_status,
                comments

            FROM
                {$tblDIAC}
            WHERE
                data_intermediate_ad_connection_id = 1";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 2);
        $this->assertEqual($aRow['connection_status'], MAX_CONNECTION_STATUS_APPROVED);
        $this->assertEqual($aRow['comments'], '');
        $query = "
            SELECT
                connection_status,
                comments

            FROM
                {$tblDIAC}
            WHERE
                data_intermediate_ad_connection_id = 2";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 2);
        $this->assertEqual($aRow['connection_status'], MAX_CONNECTION_STATUS_APPROVED);
        $this->assertEqual($aRow['comments'], '');
        $query = "
            SELECT
                connection_status,
                comments

            FROM
                {$tblDIAC}
            WHERE
                data_intermediate_ad_connection_id = 3";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 2);
        $this->assertEqual($aRow['connection_status'], MAX_CONNECTION_STATUS_APPROVED);
        $this->assertEqual($aRow['comments'], '');
        $query = "
            SELECT
                connection_status,
                comments

            FROM
                {$tblDIAC}
            WHERE
                data_intermediate_ad_connection_id = 4";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 2);
        $this->assertEqual($aRow['connection_status'], MAX_CONNECTION_STATUS_DUPLICATE);
        $this->assertEqual($aRow['comments'], 'Duplicate of connection ID 1');
        // Insert a connection at 14:05:00, from a click on ad ID 5, zone ID 6, at 14:04,
        // using tracker ID 1 (two variable values)
        $query = "
            INSERT INTO
                {$tblDIAC}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status,
                    inside_window
                )
            VALUES
                (
                    5,
                    'singleDB',
                    5,
                    'viewerid3',
                    '2005-09-05 14:05:00',
                    '2005-09-05 14:04:00',
                    1,
                    5,
                    0,
                    6,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . ",
                    1
                )";
        $rows = $oDbh->exec($query);
        // Insert the variable values for the connection
        $query = "
            INSERT INTO
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_variable_value'],true)."
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    8,
                    5,
                    1,
                    'test non-unique'
                )";
        $rows = $oDbh->exec($query);
        $query = "
            INSERT INTO
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_variable_value'],true)."
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    9,
                    5,
                    2,
                    'test unique'
                )";
        $rows = $oDbh->exec($query);
        // Insert a connection at 14:15:00, from a click on ad ID 7, zone ID 8, at 14:14,
        // using tracker ID 2 (one variable value)
        $query = "
            INSERT INTO
                {$tblDIAC}
                (
                    data_intermediate_ad_connection_id,
                    server_raw_ip,
                    server_raw_tracker_impression_id,
                    viewer_id,
                    tracker_date_time,
                    connection_date_time,
                    tracker_id,
                    ad_id,
                    creative_id,
                    zone_id,
                    connection_action,
                    connection_window,
                    connection_status,
                    inside_window
                )
            VALUES
                (
                    6,
                    'singleDB',
                    6,
                    'viewerid2',
                    '2005-09-05 12:15:00',
                    '2005-09-05 12:14:00',
                    2,
                    7,
                    0,
                    8,
                    " . MAX_CONNECTION_AD_CLICK . ",
                    1209600,
                    " . MAX_CONNECTION_STATUS_APPROVED . ",
                    1
                )";
        $rows = $oDbh->exec($query);
        // Insert the variable values for the connection
        $query = "
            INSERT INTO
                ".$oDbh->quoteIdentifier($aConf['table']['prefix'].$aConf['table']['data_intermediate_ad_variable_value'],true)."
                (
                    data_intermediate_ad_variable_value_id,
                    data_intermediate_ad_connection_id,
                    tracker_variable_id,
                    value
                )
            VALUES
                (
                    10,
                    6,
                    3,
                    'test unique'
                )";
        $rows = $oDbh->exec($query);
        // Dedupe this hour
        $oStartDate = new Date('2005-09-05 14:00:00');
        $oEndDate   = new Date('2005-09-07 14:29:59');
        $dsa = $oMDMSF->factory("AdServer");
        $dsa->_saveIntermediateDeduplicateConversions($oStartDate, $oEndDate);
        // Ensure that both only the correct conversions has been deduped
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$tblDIAC}";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 6);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$tblDIAC}
            WHERE
                connection_status = " . MAX_CONNECTION_STATUS_APPROVED;
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 4);
        $query = "
            SELECT
                COUNT(*) AS rows
            FROM
                {$tblDIAC}
            WHERE
                connection_status = " . MAX_CONNECTION_STATUS_DUPLICATE;
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 1);
        $this->assertEqual($aRow['rows'], 2);
        $query = "
            SELECT
                connection_status,
                comments

            FROM
                {$tblDIAC}
            WHERE
                data_intermediate_ad_connection_id = 1";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 2);
        $this->assertEqual($aRow['connection_status'], MAX_CONNECTION_STATUS_APPROVED);
        $this->assertEqual($aRow['comments'], '');
        $query = "
            SELECT
                connection_status,
                comments

            FROM
                {$tblDIAC}
            WHERE
                data_intermediate_ad_connection_id = 2";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 2);
        $this->assertEqual($aRow['connection_status'], MAX_CONNECTION_STATUS_APPROVED);
        $this->assertEqual($aRow['comments'], '');
        $query = "
            SELECT
                connection_status,
                comments

            FROM
                {$tblDIAC}
            WHERE
                data_intermediate_ad_connection_id = 3";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 2);
        $this->assertEqual($aRow['connection_status'], MAX_CONNECTION_STATUS_APPROVED);
        $this->assertEqual($aRow['comments'], '');
        $query = "
            SELECT
                connection_status,
                comments

            FROM
                {$tblDIAC}
            WHERE
                data_intermediate_ad_connection_id = 4";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 2);
        $this->assertEqual($aRow['connection_status'], MAX_CONNECTION_STATUS_DUPLICATE);
        $this->assertEqual($aRow['comments'], 'Duplicate of connection ID 1');
        $query = "
            SELECT
                connection_status,
                comments

            FROM
                {$tblDIAC}
            WHERE
                data_intermediate_ad_connection_id = 5";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 2);
        $this->assertEqual($aRow['connection_status'], MAX_CONNECTION_STATUS_DUPLICATE);
        $this->assertEqual($aRow['comments'], 'Duplicate of connection ID 4');
        $query = "
            SELECT
                connection_status,
                comments

            FROM
                {$tblDIAC}
            WHERE
                data_intermediate_ad_connection_id = 6";
        $aRow = $oDbh->queryRow($query);
        $this->assertEqual(count($aRow), 2);
        $this->assertEqual($aRow['connection_status'], MAX_CONNECTION_STATUS_APPROVED);
        $this->assertEqual($aRow['comments'], '');

        TestEnv::restoreEnv();
    }

}

?>
