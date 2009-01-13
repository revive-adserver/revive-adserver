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
 * A class for testing the deduplicateConversions() method of the
 * MySQL / PgSQL OX_Dal_Maintenance_Statistics classes.
 *
 * @package    OpenXDal
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew.hill@openx.org>
 */
class Test_OX_Dal_Maintenance_Statistics_deduplicateConversions extends UnitTestCase
{

    /**
     * Local copy of the OX_Dal_Maintenance_Statistics MSE DAL class for
     * use in the tests.
     *
     * @var OX_Dal_Maintenance_Statistics
     */
    var $oDal;

    /**
     * The constructor method.
     */
    function Test_OX_Dal_Maintenance_Statistics_deduplicateConversions()
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
     * A method to test the deduplicateConversions() method:
     *
     * - With no conversions in the system.
     */
    function testDeduplicateConversions_1()
    {
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');

        // De-duplicate
        $this->oDal->deduplicateConversions($oStartDate, $oEndDate);

        // Test the results
        $rows = $this->_countDataIntermediateAdConnections();
        $this->assertEqual($rows, 0);
    }

    /**
     * A method to test the deduplicateConversions() method:
     *
     * - With a conversion in the system, but no tracked variable
     *   value(s) attached (or logged).
     *
     * Tests to ensure the status remains as "approved".
     */
    function testDeduplicateConversions_2()
    {
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');

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
        $this->oDal->deduplicateConversions($oStartDate, $oEndDate);

        // Test the results
        $rows = $this->_countDataIntermediateAdConnections();
        $this->assertEqual($rows, 1);

        $rows = $this->_countDataIntermediateAdConnectionsApproved();
        $this->assertEqual($rows, 1);

        // Clean up
        DataGenerator::cleanUp();
    }

    /**
     * A method to test the deduplicateConversions() method:
     *
     * - With two conversions in the system, but no tracked variable
     *   value(s) attached (or logged).
     *
     * Tests to ensure the statuses remain as "approved".
     */
    function testDeduplicateConversions_3()
    {
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');

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

        // Insert a connection at 12:30:00, from a click on ad ID 5, zone ID 6, at 12:29
        $aData = array(
            'server_raw_tracker_impression_id' => 2,
            'server_raw_ip'                    => 'singleDB',
            'tracker_id'                       => 1,
            'tracker_date_time'                => '2005-09-05 12:30:00',
            'connection_date_time'             => '2005-09-05 12:29:00',
            'ad_id'                            => 5,
            'zone_id'                          => 6,
            'connection_action'                => MAX_CONNECTION_AD_CLICK,
            'connection_window'                => 1209600,
            'connection_status'                => MAX_CONNECTION_STATUS_APPROVED
        );
        $this->_insertDataIntermediateAdConnection($aData);

        // De-duplicate
        $this->oDal->deduplicateConversions($oStartDate, $oEndDate);

        // Test the results
        $rows = $this->_countDataIntermediateAdConnections();
        $this->assertEqual($rows, 2);

        $rows = $this->_countDataIntermediateAdConnectionsApproved();
        $this->assertEqual($rows, 2);

        // Clean up
        DataGenerator::cleanUp();
    }

    /**********************************************************************/
    /* TESTS WHERE THERE IS A NON-UNIQUE VARIABLE VALUE BEING TRACKED     */
    /**********************************************************************/

    /**
     * A method to test the deduplicateConversions() method:
     *
     * - With a conversion in the system, a tracked, non-unique
     *   variable value attached, but not logged.
     *
     * Tests to ensure the status remains as "approved".
     */
    function testDeduplicateConversions_4()
    {
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');

        // Prepare the non-unique variable value that should
        // be tracked with Tracker ID 1
        $aData = array(
            'trackerid'     => 1,
            'name'          => 'Test, Non-Unique Variable',
            'is_unique'     => 0,
            'unique_window' => 3600
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
        $this->_insertDataIntermediateAdConnection($aData);

        // Do NOT insert any logged variable value - it has not been
        // tracked correctly in this test, for some reason

        // De-duplicate
        $this->oDal->deduplicateConversions($oStartDate, $oEndDate);

        // Test the results
        $rows = $this->_countDataIntermediateAdConnections();
        $this->assertEqual($rows, 1);

        $rows = $this->_countDataIntermediateAdConnectionsApproved();
        $this->assertEqual($rows, 1);

        // Clean up
        DataGenerator::cleanUp();
    }

    /**
     * A method to test the deduplicateConversions() method:
     *
     * - With a conversion in the system, a tracked, non-unique
     *   variable value attached, and with a NULL value logged.
     *
     * Tests to ensure the status remains as "approved".
     */
    function testDeduplicateConversions_5()
    {
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');

        // Prepare the non-unique variable value that should
        // be tracked with Tracker ID 1
        $aData = array(
            'trackerid'     => 1,
            'name'          => 'Test, Non-Unique Variable',
            'is_unique'     => 0,
            'unique_window' => 3600
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
        $this->oDal->deduplicateConversions($oStartDate, $oEndDate);

        // Test the results
        $rows = $this->_countDataIntermediateAdConnections();
        $this->assertEqual($rows, 1);

        $rows = $this->_countDataIntermediateAdConnectionsApproved();
        $this->assertEqual($rows, 1);

        // Clean up
        DataGenerator::cleanUp();
    }

    /**
     * A method to test the deduplicateConversions() method:
     *
     * - With a conversion in the system, a tracked, non-unique
     *   variable value attached, and with an empty string value
     *   logged.
     *
     * Tests to ensure the status remains as "approved".
     */
    function testDeduplicateConversions_6()
    {
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');

        // Prepare the non-unique variable value that should
        // be tracked with Tracker ID 1
        $aData = array(
            'trackerid'     => 1,
            'name'          => 'Test, Non-Unique Variable',
            'is_unique'     => 0,
            'unique_window' => 3600
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
        $this->oDal->deduplicateConversions($oStartDate, $oEndDate);

        // Test the results
        $rows = $this->_countDataIntermediateAdConnections();
        $this->assertEqual($rows, 1);

        $rows = $this->_countDataIntermediateAdConnectionsApproved();
        $this->assertEqual($rows, 1);

        // Clean up
        DataGenerator::cleanUp();
    }

    /**
     * A method to test the deduplicateConversions() method:
     *
     * - With a conversion in the system, a tracked, non-unique
     *   variable value attached, and with a "real" value logged.
     *
     * Tests to ensure the status remains as "approved".
     */
    function testDeduplicateConversions_7()
    {
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');

        // Prepare the non-unique variable value that should
        // be tracked with Tracker ID 1
        $aData = array(
            'trackerid'     => 1,
            'name'          => 'Test, Non-Unique Variable',
            'is_unique'     => 0,
            'unique_window' => 3600
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
        $this->oDal->deduplicateConversions($oStartDate, $oEndDate);

        // Test the results
        $rows = $this->_countDataIntermediateAdConnections();
        $this->assertEqual($rows, 1);

        $rows = $this->_countDataIntermediateAdConnectionsApproved();
        $this->assertEqual($rows, 1);

        // Clean up
        DataGenerator::cleanUp();
    }

    /**
     * A method to test the deduplicateConversions() method:
     *
     * - With a two conversions in the system, a tracked, non-unique
     *   variable value attached, with values "not logged" and
     *   "not logged" for the two conversions.
     *
     * Tests to ensure the statuses remain as "approved".
     */
    function testDeduplicateConversions_8()
    {
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');

        // Prepare the non-unique variable value that should
        // be tracked with Tracker ID 1
        $aData = array(
            'trackerid'     => 1,
            'name'          => 'Test, Non-Unique Variable',
            'is_unique'     => 0,
            'unique_window' => 3600
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

        // Insert a connection at 12:30:00, from a click on ad ID 5, zone ID 6, at 12:29
        $aData = array(
            'server_raw_tracker_impression_id' => 2,
            'server_raw_ip'                    => 'singleDB',
            'tracker_id'                       => 1,
            'tracker_date_time'                => '2005-09-05 12:30:00',
            'connection_date_time'             => '2005-09-05 12:29:00',
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
        $this->oDal->deduplicateConversions($oStartDate, $oEndDate);

        // Test the results
        $rows = $this->_countDataIntermediateAdConnections();
        $this->assertEqual($rows, 2);

        $rows = $this->_countDataIntermediateAdConnectionsApproved();
        $this->assertEqual($rows, 2);

        // Clean up
        DataGenerator::cleanUp();
    }

    /**
     * A method to test the deduplicateConversions() method:
     *
     * - With a two conversions in the system, a tracked, non-unique
     *   variable value attached, with values "not logged" and
     *   a NULL value for the two conversions.
     *
     * Tests to ensure the statuses remain as "approved".
     */
    function testDeduplicateConversions_9()
    {
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');

        // Prepare the non-unique variable value that should
        // be tracked with Tracker ID 1
        $aData = array(
            'trackerid'     => 1,
            'name'          => 'Test, Non-Unique Variable',
            'is_unique'     => 0,
            'unique_window' => 3600
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

        // Insert a connection at 12:30:00, from a click on ad ID 5, zone ID 6, at 12:29
        $aData = array(
            'server_raw_tracker_impression_id' => 2,
            'server_raw_ip'                    => 'singleDB',
            'tracker_id'                       => 1,
            'tracker_date_time'                => '2005-09-05 12:30:00',
            'connection_date_time'             => '2005-09-05 12:29:00',
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
        $this->oDal->deduplicateConversions($oStartDate, $oEndDate);

        // Test the results
        $rows = $this->_countDataIntermediateAdConnections();
        $this->assertEqual($rows, 2);

        $rows = $this->_countDataIntermediateAdConnectionsApproved();
        $this->assertEqual($rows, 2);

        // Clean up
        DataGenerator::cleanUp();
    }

    /**
     * A method to test the deduplicateConversions() method:
     *
     * - With a two conversions in the system, a tracked, non-unique
     *   variable value attached, with values "not logged" and
     *   an empty string value for the two conversions.
     *
     * Tests to ensure the statuses remain as "approved".
     */
    function testDeduplicateConversions_10()
    {
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');

        // Prepare the non-unique variable value that should
        // be tracked with Tracker ID 1
        $aData = array(
            'trackerid'     => 1,
            'name'          => 'Test, Non-Unique Variable',
            'is_unique'     => 0,
            'unique_window' => 3600
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

        // Insert a connection at 12:30:00, from a click on ad ID 5, zone ID 6, at 12:29
        $aData = array(
            'server_raw_tracker_impression_id' => 2,
            'server_raw_ip'                    => 'singleDB',
            'tracker_id'                       => 1,
            'tracker_date_time'                => '2005-09-05 12:30:00',
            'connection_date_time'             => '2005-09-05 12:29:00',
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
        $this->oDal->deduplicateConversions($oStartDate, $oEndDate);

        // Test the results
        $rows = $this->_countDataIntermediateAdConnections();
        $this->assertEqual($rows, 2);

        $rows = $this->_countDataIntermediateAdConnectionsApproved();
        $this->assertEqual($rows, 2);

        // Clean up
        DataGenerator::cleanUp();
    }

    /**
     * A method to test the deduplicateConversions() method:
     *
     * - With a two conversions in the system, a tracked, non-unique
     *   variable value attached, with values "not logged" and
     *   a "real" value for the two conversions.
     *
     * Tests to ensure the statuses remain as "approved".
     */
    function testDeduplicateConversions_11()
    {
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');

        // Prepare the non-unique variable value that should
        // be tracked with Tracker ID 1
        $aData = array(
            'trackerid'     => 1,
            'name'          => 'Test, Non-Unique Variable',
            'is_unique'     => 0,
            'unique_window' => 3600
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

        // Insert a connection at 12:30:00, from a click on ad ID 5, zone ID 6, at 12:29
        $aData = array(
            'server_raw_tracker_impression_id' => 2,
            'server_raw_ip'                    => 'singleDB',
            'tracker_id'                       => 1,
            'tracker_date_time'                => '2005-09-05 12:30:00',
            'connection_date_time'             => '2005-09-05 12:29:00',
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
        $this->oDal->deduplicateConversions($oStartDate, $oEndDate);

        // Test the results
        $rows = $this->_countDataIntermediateAdConnections();
        $this->assertEqual($rows, 2);

        $rows = $this->_countDataIntermediateAdConnectionsApproved();
        $this->assertEqual($rows, 2);

        // Clean up
        DataGenerator::cleanUp();
    }

    /**
     * A method to test the deduplicateConversions() method:
     *
     * - With a two conversions in the system, a tracked, non-unique
     *   variable value attached, with a NULL value and a NULL value
     *   for the two conversions.
     *
     * Tests to ensure the statuses remain as "approved".
     */
    function testDeduplicateConversions_12()
    {
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');

        // Prepare the non-unique variable value that should
        // be tracked with Tracker ID 1
        $aData = array(
            'trackerid'     => 1,
            'name'          => 'Test, Non-Unique Variable',
            'is_unique'     => 0,
            'unique_window' => 3600
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

        // Insert a connection at 12:30:00, from a click on ad ID 5, zone ID 6, at 12:29
        $aData = array(
            'server_raw_tracker_impression_id' => 2,
            'server_raw_ip'                    => 'singleDB',
            'tracker_id'                       => 1,
            'tracker_date_time'                => '2005-09-05 12:30:00',
            'connection_date_time'             => '2005-09-05 12:29:00',
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
        $this->oDal->deduplicateConversions($oStartDate, $oEndDate);

        // Test the results
        $rows = $this->_countDataIntermediateAdConnections();
        $this->assertEqual($rows, 2);

        $rows = $this->_countDataIntermediateAdConnectionsApproved();
        $this->assertEqual($rows, 2);

        // Clean up
        DataGenerator::cleanUp();
    }

    /**
     * A method to test the deduplicateConversions() method:
     *
     * - With a two conversions in the system, a tracked, non-unique
     *   variable value attached, with a NULL value and an empty
     *   string value for the two conversions.
     *
     * Tests to ensure the statuses remain as "approved".
     */
    function testDeduplicateConversions_13()
    {
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');

        // Prepare the non-unique variable value that should
        // be tracked with Tracker ID 1
        $aData = array(
            'trackerid'     => 1,
            'name'          => 'Test, Non-Unique Variable',
            'is_unique'     => 0,
            'unique_window' => 3600
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

        // Insert a connection at 12:30:00, from a click on ad ID 5, zone ID 6, at 12:29
        $aData = array(
            'server_raw_tracker_impression_id' => 2,
            'server_raw_ip'                    => 'singleDB',
            'tracker_id'                       => 1,
            'tracker_date_time'                => '2005-09-05 12:30:00',
            'connection_date_time'             => '2005-09-05 12:29:00',
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
        $this->oDal->deduplicateConversions($oStartDate, $oEndDate);

        // Test the results
        $rows = $this->_countDataIntermediateAdConnections();
        $this->assertEqual($rows, 2);

        $rows = $this->_countDataIntermediateAdConnectionsApproved();
        $this->assertEqual($rows, 2);

        // Clean up
        DataGenerator::cleanUp();
    }

    /**
     * A method to test the deduplicateConversions() method:
     *
     * - With a two conversions in the system, a tracked, non-unique
     *   variable value attached, with a NULL value and a "real"
     *   value for the two conversions.
     *
     * Tests to ensure the statuses remain as "approved".
     */
    function testDeduplicateConversions_14()
    {
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');

        // Prepare the non-unique variable value that should
        // be tracked with Tracker ID 1
        $aData = array(
            'trackerid'     => 1,
            'name'          => 'Test, Non-Unique Variable',
            'is_unique'     => 0,
            'unique_window' => 3600
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

        // Insert a connection at 12:30:00, from a click on ad ID 5, zone ID 6, at 12:29
        $aData = array(
            'server_raw_tracker_impression_id' => 2,
            'server_raw_ip'                    => 'singleDB',
            'tracker_id'                       => 1,
            'tracker_date_time'                => '2005-09-05 12:30:00',
            'connection_date_time'             => '2005-09-05 12:29:00',
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
        $this->oDal->deduplicateConversions($oStartDate, $oEndDate);

        // Test the results
        $rows = $this->_countDataIntermediateAdConnections();
        $this->assertEqual($rows, 2);

        $rows = $this->_countDataIntermediateAdConnectionsApproved();
        $this->assertEqual($rows, 2);

        // Clean up
        DataGenerator::cleanUp();
    }

    /**
     * A method to test the deduplicateConversions() method:
     *
     * - With a two conversions in the system, a tracked, non-unique
     *   variable value attached, with an empty string value and an
     *   empty string value for the two conversions.
     *
     * Tests to ensure the statuses remain as "approved".
     */
    function testDeduplicateConversions_15()
    {
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');

        // Prepare the non-unique variable value that should
        // be tracked with Tracker ID 1
        $aData = array(
            'trackerid'     => 1,
            'name'          => 'Test, Non-Unique Variable',
            'is_unique'     => 0,
            'unique_window' => 3600
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

        // Insert a connection at 12:30:00, from a click on ad ID 5, zone ID 6, at 12:29
        $aData = array(
            'server_raw_tracker_impression_id' => 2,
            'server_raw_ip'                    => 'singleDB',
            'tracker_id'                       => 1,
            'tracker_date_time'                => '2005-09-05 12:30:00',
            'connection_date_time'             => '2005-09-05 12:29:00',
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
        $this->oDal->deduplicateConversions($oStartDate, $oEndDate);

        // Test the results
        $rows = $this->_countDataIntermediateAdConnections();
        $this->assertEqual($rows, 2);

        $rows = $this->_countDataIntermediateAdConnectionsApproved();
        $this->assertEqual($rows, 2);

        // Clean up
        DataGenerator::cleanUp();
    }

    /**
     * A method to test the deduplicateConversions() method:
     *
     * - With a two conversions in the system, a tracked, non-unique
     *   variable value attached, with an empty string value and a
     *   "real" value for the two conversions.
     *
     * Tests to ensure the statuses remain as "approved".
     */
    function testDeduplicateConversions_16()
    {
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');

        // Prepare the non-unique variable value that should
        // be tracked with Tracker ID 1
        $aData = array(
            'trackerid'     => 1,
            'name'          => 'Test, Non-Unique Variable',
            'is_unique'     => 0,
            'unique_window' => 3600
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

        // Insert a connection at 12:30:00, from a click on ad ID 5, zone ID 6, at 12:29
        $aData = array(
            'server_raw_tracker_impression_id' => 2,
            'server_raw_ip'                    => 'singleDB',
            'tracker_id'                       => 1,
            'tracker_date_time'                => '2005-09-05 12:30:00',
            'connection_date_time'             => '2005-09-05 12:29:00',
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
        $this->oDal->deduplicateConversions($oStartDate, $oEndDate);

        // Test the results
        $rows = $this->_countDataIntermediateAdConnections();
        $this->assertEqual($rows, 2);

        $rows = $this->_countDataIntermediateAdConnectionsApproved();
        $this->assertEqual($rows, 2);

        // Clean up
        DataGenerator::cleanUp();
    }

    /**
     * A method to test the deduplicateConversions() method:
     *
     * - With a two conversions in the system, a tracked, non-unique
     *   variable value attached, with a "real" value and another
     *   "real" value for the two conversions.
     *
     * Tests to ensure the statuses remain as "approved".
     */
    function testDeduplicateConversions_17()
    {
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');

        // Prepare the non-unique variable value that should
        // be tracked with Tracker ID 1
        $aData = array(
            'trackerid'     => 1,
            'name'          => 'Test, Non-Unique Variable',
            'is_unique'     => 0,
            'unique_window' => 3600
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

        // Insert a connection at 12:30:00, from a click on ad ID 5, zone ID 6, at 12:29
        $aData = array(
            'server_raw_tracker_impression_id' => 2,
            'server_raw_ip'                    => 'singleDB',
            'tracker_id'                       => 1,
            'tracker_date_time'                => '2005-09-05 12:30:00',
            'connection_date_time'             => '2005-09-05 12:29:00',
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
        $this->oDal->deduplicateConversions($oStartDate, $oEndDate);

        // Test the results
        $rows = $this->_countDataIntermediateAdConnections();
        $this->assertEqual($rows, 2);

        $rows = $this->_countDataIntermediateAdConnectionsApproved();
        $this->assertEqual($rows, 2);

        // Clean up
        DataGenerator::cleanUp();
    }

    /**********************************************************************/
    /* TESTS WHERE THERE IS A UNIQUE VARIABLE VALUE BEING TRACKED         */
    /**********************************************************************/

    /**
     * A method to test the deduplicateConversions() method:
     *
     * - With a conversion in the system, a tracked, unique
     *   variable value attached, but not logged.
     *
     * Tests to ensure the status remains as "approved".
     */
    function testDeduplicateConversions_18()
    {
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');

        // Prepare the unique variable value that should
        // be tracked with Tracker ID 1
        $aData = array(
            'trackerid'     => 1,
            'name'          => 'Test, Unique Variable',
            'is_unique'     => 1,
            'unique_window' => 3600
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
        $this->_insertDataIntermediateAdConnection($aData);

        // Do NOT insert any logged variable value - it has not been
        // tracked correctly in this test, for some reason

        // De-duplicate
        $this->oDal->deduplicateConversions($oStartDate, $oEndDate);

        // Test the results
        $rows = $this->_countDataIntermediateAdConnections();
        $this->assertEqual($rows, 1);

        $rows = $this->_countDataIntermediateAdConnectionsApproved();
        $this->assertEqual($rows, 1);

        // Clean up
        DataGenerator::cleanUp();
    }

    /**
     * A method to test the deduplicateConversions() method:
     *
     * - With a conversion in the system, a tracked, unique
     *   variable value attached, and with a NULL value logged.
     *
     * Tests to ensure the status remains as "approved".
     */
    function testDeduplicateConversions_19()
    {
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');

        // Prepare the unique variable value that should
        // be tracked with Tracker ID 1
        $aData = array(
            'trackerid'     => 1,
            'name'          => 'Test, Unique Variable',
            'is_unique'     => 1,
            'unique_window' => 3600
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
        $this->oDal->deduplicateConversions($oStartDate, $oEndDate);

        // Test the results
        $rows = $this->_countDataIntermediateAdConnections();
        $this->assertEqual($rows, 1);

        $rows = $this->_countDataIntermediateAdConnectionsApproved();
        $this->assertEqual($rows, 1);

        // Clean up
        DataGenerator::cleanUp();
    }

    /**
     * A method to test the deduplicateConversions() method:
     *
     * - With a conversion in the system, a tracked, unique
     *   variable value attached, and with an empty string value
     *   logged.
     *
     * Tests to ensure the status remains as "approved".
     */
    function testDeduplicateConversions_20()
    {
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');

        // Prepare the unique variable value that should
        // be tracked with Tracker ID 1
        $aData = array(
            'trackerid'     => 1,
            'name'          => 'Test, Unique Variable',
            'is_unique'     => 1,
            'unique_window' => 3600
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
        $this->oDal->deduplicateConversions($oStartDate, $oEndDate);

        // Test the results
        $rows = $this->_countDataIntermediateAdConnections();
        $this->assertEqual($rows, 1);

        $rows = $this->_countDataIntermediateAdConnectionsApproved();
        $this->assertEqual($rows, 1);

        // Clean up
        DataGenerator::cleanUp();
    }

    /**
     * A method to test the deduplicateConversions() method:
     *
     * - With a conversion in the system, a tracked, unique
     *   variable value attached, and with a "real" value logged.
     *
     * Tests to ensure the status remains as "approved".
     */
    function testDeduplicateConversions_21()
    {
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');

        // Prepare the unique variable value that should
        // be tracked with Tracker ID 1
        $aData = array(
            'trackerid'     => 1,
            'name'          => 'Test, Unique Variable',
            'is_unique'     => 1,
            'unique_window' => 3600
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
        $this->oDal->deduplicateConversions($oStartDate, $oEndDate);

        // Test the results
        $rows = $this->_countDataIntermediateAdConnections();
        $this->assertEqual($rows, 1);

        $rows = $this->_countDataIntermediateAdConnectionsApproved();
        $this->assertEqual($rows, 1);

        // Clean up
        DataGenerator::cleanUp();
    }

    /**
     * A method to test the deduplicateConversions() method:
     *
     * - With a two conversions in the system, a tracked, unique
     *   variable value attached, with values "not logged" and
     *   "not logged" for the two conversions.
     *
     * Tests to ensure the statuses remain as "approved".
     *
     * This is a special case - becase there are no variable values
     * tracked, it is not possible to de-duplicate the conversions,
     * because the values are absent.
     */
    function testDeduplicateConversions_22()
    {
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');

        // Prepare the unique variable value that should
        // be tracked with Tracker ID 1
        $aData = array(
            'trackerid'     => 1,
            'name'          => 'Test, Unique Variable',
            'is_unique'     => 1,
            'unique_window' => 3600
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

        // Insert a connection at 12:30:00, from a click on ad ID 5, zone ID 6, at 12:29
        $aData = array(
            'server_raw_tracker_impression_id' => 2,
            'server_raw_ip'                    => 'singleDB',
            'tracker_id'                       => 1,
            'tracker_date_time'                => '2005-09-05 12:30:00',
            'connection_date_time'             => '2005-09-05 12:29:00',
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
        $this->oDal->deduplicateConversions($oStartDate, $oEndDate);

        // Test the results
        $rows = $this->_countDataIntermediateAdConnections();
        $this->assertEqual($rows, 2);

        $rows = $this->_countDataIntermediateAdConnectionsApproved();
        $this->assertEqual($rows, 2);

        // Clean up
        DataGenerator::cleanUp();
    }

    /**
     * A method to test the deduplicateConversions() method:
     *
     * - With a two conversions in the system, a tracked, unique
     *   variable value attached, with values "not logged" and
     *   a NULL value for the two conversions.
     *
     * Tests to ensure the statuses remain as "approved".
     */
    function testDeduplicateConversions_23()
    {
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');

        // Prepare the unique variable value that should
        // be tracked with Tracker ID 1
        $aData = array(
            'trackerid'     => 1,
            'name'          => 'Test, Unique Variable',
            'is_unique'     => 1,
            'unique_window' => 3600
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

        // Insert a connection at 12:30:00, from a click on ad ID 5, zone ID 6, at 12:29
        $aData = array(
            'server_raw_tracker_impression_id' => 2,
            'server_raw_ip'                    => 'singleDB',
            'tracker_id'                       => 1,
            'tracker_date_time'                => '2005-09-05 12:30:00',
            'connection_date_time'             => '2005-09-05 12:29:00',
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
        $this->oDal->deduplicateConversions($oStartDate, $oEndDate);

        // Test the results
        $rows = $this->_countDataIntermediateAdConnections();
        $this->assertEqual($rows, 2);

        $rows = $this->_countDataIntermediateAdConnectionsApproved();
        $this->assertEqual($rows, 2);

        // Clean up
        DataGenerator::cleanUp();
    }

    /**
     * A method to test the deduplicateConversions() method:
     *
     * - With a two conversions in the system, a tracked, unique
     *   variable value attached, with values "not logged" and
     *   an empty string value for the two conversions.
     *
     * Tests to ensure the statuses remain as "approved".
     */
    function testDeduplicateConversions_24()
    {
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');

        // Prepare the unique variable value that should
        // be tracked with Tracker ID 1
        $aData = array(
            'trackerid'     => 1,
            'name'          => 'Test, Unique Variable',
            'is_unique'     => 1,
            'unique_window' => 3600
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

        // Insert a connection at 12:30:00, from a click on ad ID 5, zone ID 6, at 12:29
        $aData = array(
            'server_raw_tracker_impression_id' => 2,
            'server_raw_ip'                    => 'singleDB',
            'tracker_id'                       => 1,
            'tracker_date_time'                => '2005-09-05 12:30:00',
            'connection_date_time'             => '2005-09-05 12:29:00',
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
        $this->oDal->deduplicateConversions($oStartDate, $oEndDate);

        // Test the results
        $rows = $this->_countDataIntermediateAdConnections();
        $this->assertEqual($rows, 2);

        $rows = $this->_countDataIntermediateAdConnectionsApproved();
        $this->assertEqual($rows, 2);

        // Clean up
        DataGenerator::cleanUp();
    }

    /**
     * A method to test the deduplicateConversions() method:
     *
     * - With a two conversions in the system, a tracked, unique
     *   variable value attached, with values "not logged" and
     *   a "real" value for the two conversions.
     *
     * Tests to ensure the statuses remain as "approved".
     */
    function testDeduplicateConversions_25()
    {
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');

        // Prepare the unique variable value that should
        // be tracked with Tracker ID 1
        $aData = array(
            'trackerid'     => 1,
            'name'          => 'Test, Unique Variable',
            'is_unique'     => 1,
            'unique_window' => 3600
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

        // Insert a connection at 12:30:00, from a click on ad ID 5, zone ID 6, at 12:29
        $aData = array(
            'server_raw_tracker_impression_id' => 2,
            'server_raw_ip'                    => 'singleDB',
            'tracker_id'                       => 1,
            'tracker_date_time'                => '2005-09-05 12:30:00',
            'connection_date_time'             => '2005-09-05 12:29:00',
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
        $this->oDal->deduplicateConversions($oStartDate, $oEndDate);

        // Test the results
        $rows = $this->_countDataIntermediateAdConnections();
        $this->assertEqual($rows, 2);

        $rows = $this->_countDataIntermediateAdConnectionsApproved();
        $this->assertEqual($rows, 2);

        // Clean up
        DataGenerator::cleanUp();
    }

    /**
     * A method to test the deduplicateConversions() method:
     *
     * - With a two conversions in the system, a tracked, unique
     *   variable value attached, with a NULL value and a NULL value
     *   for the two conversions.
     *
     * Tests to ensure the statuses remain as "approved".
     *
     * This is a special case - becase there are no variable values
     * tracked, it is not possible to de-duplicate the conversions,
     * because the values are absent.
     */
    function testDeduplicateConversions_26()
    {
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');

        // Prepare the unique variable value that should
        // be tracked with Tracker ID 1
        $aData = array(
            'trackerid'     => 1,
            'name'          => 'Test, Unique Variable',
            'is_unique'     => 1,
            'unique_window' => 3600
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

        // Insert a connection at 12:30:00, from a click on ad ID 5, zone ID 6, at 12:29
        $aData = array(
            'server_raw_tracker_impression_id' => 2,
            'server_raw_ip'                    => 'singleDB',
            'tracker_id'                       => 1,
            'tracker_date_time'                => '2005-09-05 12:30:00',
            'connection_date_time'             => '2005-09-05 12:29:00',
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
        $this->oDal->deduplicateConversions($oStartDate, $oEndDate);

        // Test the results
        $rows = $this->_countDataIntermediateAdConnections();
        $this->assertEqual($rows, 2);

        $rows = $this->_countDataIntermediateAdConnectionsApproved();
        $this->assertEqual($rows, 2);

        // Clean up
        DataGenerator::cleanUp();
    }

    /**
     * A method to test the deduplicateConversions() method:
     *
     * - With a two conversions in the system, a tracked, unique
     *   variable value attached, with a NULL value and an empty
     *   string value for the two conversions.
     *
     * Tests to ensure the statuses remain as "approved".
     */
    function testDeduplicateConversions_27()
    {
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');

        // Prepare the unique variable value that should
        // be tracked with Tracker ID 1
        $aData = array(
            'trackerid'     => 1,
            'name'          => 'Test, Unique Variable',
            'is_unique'     => 1,
            'unique_window' => 3600
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

        // Insert a connection at 12:30:00, from a click on ad ID 5, zone ID 6, at 12:29
        $aData = array(
            'server_raw_tracker_impression_id' => 2,
            'server_raw_ip'                    => 'singleDB',
            'tracker_id'                       => 1,
            'tracker_date_time'                => '2005-09-05 12:30:00',
            'connection_date_time'             => '2005-09-05 12:29:00',
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
        $this->oDal->deduplicateConversions($oStartDate, $oEndDate);

        // Test the results
        $rows = $this->_countDataIntermediateAdConnections();
        $this->assertEqual($rows, 2);

        $rows = $this->_countDataIntermediateAdConnectionsApproved();
        $this->assertEqual($rows, 2);

        // Clean up
        DataGenerator::cleanUp();
    }

    /**
     * A method to test the deduplicateConversions() method:
     *
     * - With a two conversions in the system, a tracked, unique
     *   variable value attached, with a NULL value and a "real"
     *   value for the two conversions.
     *
     * Tests to ensure the statuses remain as "approved".
     */
    function testDeduplicateConversions_28()
    {
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');

        // Prepare the unique variable value that should
        // be tracked with Tracker ID 1
        $aData = array(
            'trackerid'     => 1,
            'name'          => 'Test, Unique Variable',
            'is_unique'     => 1,
            'unique_window' => 3600
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

        // Insert a connection at 12:30:00, from a click on ad ID 5, zone ID 6, at 12:29
        $aData = array(
            'server_raw_tracker_impression_id' => 2,
            'server_raw_ip'                    => 'singleDB',
            'tracker_id'                       => 1,
            'tracker_date_time'                => '2005-09-05 12:30:00',
            'connection_date_time'             => '2005-09-05 12:29:00',
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
        $this->oDal->deduplicateConversions($oStartDate, $oEndDate);

        // Test the results
        $rows = $this->_countDataIntermediateAdConnections();
        $this->assertEqual($rows, 2);

        $rows = $this->_countDataIntermediateAdConnectionsApproved();
        $this->assertEqual($rows, 2);

        // Clean up
        DataGenerator::cleanUp();
    }

    /**
     * A method to test the deduplicateConversions() method:
     *
     * - With a two conversions in the system, a tracked, unique
     *   variable value attached, with an empty string value and an
     *   empty string value for the two conversions.
     *
     * Tests to ensure the first conversion remains as "approved",
     * while the second has been changed to "duplicate".
     */
    function testDeduplicateConversions_29()
    {
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');

        // Prepare the unique variable value that should
        // be tracked with Tracker ID 1
        $aData = array(
            'trackerid'     => 1,
            'name'          => 'Test, Unique Variable',
            'is_unique'     => 1,
            'unique_window' => 3600
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
        $conversionId1 = $this->_insertDataIntermediateAdConnection($aData);

        // Insert the variable value for the conversion
        $aData = array(
            'data_intermediate_ad_connection_id' => $conversionId1,
            'tracker_variable_id'                => 1,
            'value'                              => ''
        );
        $this->_insertDataIntermediateAdVariableValue($aData);

        // Insert a connection at 12:30:00, from a click on ad ID 5, zone ID 6, at 12:29
        $aData = array(
            'server_raw_tracker_impression_id' => 2,
            'server_raw_ip'                    => 'singleDB',
            'tracker_id'                       => 1,
            'tracker_date_time'                => '2005-09-05 12:30:00',
            'connection_date_time'             => '2005-09-05 12:29:00',
            'ad_id'                            => 5,
            'zone_id'                          => 6,
            'connection_action'                => MAX_CONNECTION_AD_CLICK,
            'connection_window'                => 1209600,
            'connection_status'                => MAX_CONNECTION_STATUS_APPROVED
        );
        $conversionId2 = $this->_insertDataIntermediateAdConnection($aData);

        // Insert the variable value for the conversion
        $aData = array(
            'data_intermediate_ad_connection_id' => $conversionId2,
            'tracker_variable_id'                => 1,
            'value'                              => ''
        );
        $this->_insertDataIntermediateAdVariableValue($aData);

        // De-duplicate
        $this->oDal->deduplicateConversions($oStartDate, $oEndDate);

        // Test the results
        $rows = $this->_countDataIntermediateAdConnections();
        $this->assertEqual($rows, 2);

        $rows = $this->_countDataIntermediateAdConnectionsApproved();
        $this->assertEqual($rows, 1);

        $doData_intermediate_ad_connection = OA_Dal::factoryDO('data_intermediate_ad_connection');
        $doData_intermediate_ad_connection->data_intermediate_ad_connection_id = $conversionId1;
        $doData_intermediate_ad_connection->find();
        $doData_intermediate_ad_connection->fetch();
        $this->assertEqual($doData_intermediate_ad_connection->connection_status, MAX_CONNECTION_STATUS_APPROVED);

        $rows = $this->_countDataIntermediateAdConnectionsDuplicate();
        $this->assertEqual($rows, 1);

        $doData_intermediate_ad_connection = OA_Dal::factoryDO('data_intermediate_ad_connection');
        $doData_intermediate_ad_connection->data_intermediate_ad_connection_id = $conversionId2;
        $doData_intermediate_ad_connection->find();
        $doData_intermediate_ad_connection->fetch();
        $this->assertEqual($doData_intermediate_ad_connection->connection_status, MAX_CONNECTION_STATUS_DUPLICATE);

        // Clean up
        DataGenerator::cleanUp();
    }

    /**
     * A method to test the deduplicateConversions() method:
     *
     * - With a two conversions in the system, a tracked, unique
     *   variable value attached, with an empty string value and a
     *   "real" value for the two conversions.
     *
     * Tests to ensure the statuses remain as "approved".
     */
    function testDeduplicateConversions_30()
    {
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');

        // Prepare the unique variable value that should
        // be tracked with Tracker ID 1
        $aData = array(
            'trackerid'     => 1,
            'name'          => 'Test, Unique Variable',
            'is_unique'     => 1,
            'unique_window' => 3600
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

        // Insert a connection at 12:30:00, from a click on ad ID 5, zone ID 6, at 12:29
        $aData = array(
            'server_raw_tracker_impression_id' => 2,
            'server_raw_ip'                    => 'singleDB',
            'tracker_id'                       => 1,
            'tracker_date_time'                => '2005-09-05 12:30:00',
            'connection_date_time'             => '2005-09-05 12:29:00',
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
        $this->oDal->deduplicateConversions($oStartDate, $oEndDate);

        // Test the results
        $rows = $this->_countDataIntermediateAdConnections();
        $this->assertEqual($rows, 2);

        $rows = $this->_countDataIntermediateAdConnectionsApproved();
        $this->assertEqual($rows, 2);

        // Clean up
        DataGenerator::cleanUp();
    }

    /**
     * A method to test the deduplicateConversions() method:
     *
     * - With a two conversions in the system, a tracked, unique
     *   variable value attached, with a "real" value and another
     *   "real" value for the two conversions, where the two values
     *   are different.
     *
     * Tests to ensure the statuses remain as "approved".
     */
    function testDeduplicateConversions_31()
    {
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');

        // Prepare the unique variable value that should
        // be tracked with Tracker ID 1
        $aData = array(
            'trackerid'     => 1,
            'name'          => 'Test, Unique Variable',
            'is_unique'     => 1,
            'unique_window' => 3600
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
            'value'                              => 'value1'
        );
        $this->_insertDataIntermediateAdVariableValue($aData);

        // Insert a connection at 12:30:00, from a click on ad ID 5, zone ID 6, at 12:29
        $aData = array(
            'server_raw_tracker_impression_id' => 2,
            'server_raw_ip'                    => 'singleDB',
            'tracker_id'                       => 1,
            'tracker_date_time'                => '2005-09-05 12:30:00',
            'connection_date_time'             => '2005-09-05 12:29:00',
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
            'value'                              => 'value2'
        );
        $this->_insertDataIntermediateAdVariableValue($aData);

        // De-duplicate
        $this->oDal->deduplicateConversions($oStartDate, $oEndDate);

        // Test the results
        $rows = $this->_countDataIntermediateAdConnections();
        $this->assertEqual($rows, 2);

        $rows = $this->_countDataIntermediateAdConnectionsApproved();
        $this->assertEqual($rows, 2);

        // Clean up
        DataGenerator::cleanUp();
    }

    /**
     * A method to test the deduplicateConversions() method:
     *
     * - With a two conversions in the system, a tracked, unique
     *   variable value attached, with a "real" value and another
     *   "real" value for the two conversions, where the two values
     *   are the same.
     *
     * Tests to ensure the first conversion remains as "approved",
     * while the second has been changed to "duplicate".
     */
    function testDeduplicateConversions_32()
    {
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:29:59');

        // Prepare the unique variable value that should
        // be tracked with Tracker ID 1
        $aData = array(
            'trackerid'     => 1,
            'name'          => 'Test, Unique Variable',
            'is_unique'     => 1,
            'unique_window' => 3600
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
        $conversionId1 = $this->_insertDataIntermediateAdConnection($aData);

        // Insert the variable value for the conversion
        $aData = array(
            'data_intermediate_ad_connection_id' => $conversionId1,
            'tracker_variable_id'                => 1,
            'value'                              => 'value'
        );
        $this->_insertDataIntermediateAdVariableValue($aData);

        // Insert a connection at 12:30:00, from a click on ad ID 5, zone ID 6, at 12:29
        $aData = array(
            'server_raw_tracker_impression_id' => 2,
            'server_raw_ip'                    => 'singleDB',
            'tracker_id'                       => 1,
            'tracker_date_time'                => '2005-09-05 12:30:00',
            'connection_date_time'             => '2005-09-05 12:29:00',
            'ad_id'                            => 5,
            'zone_id'                          => 6,
            'connection_action'                => MAX_CONNECTION_AD_CLICK,
            'connection_window'                => 1209600,
            'connection_status'                => MAX_CONNECTION_STATUS_APPROVED
        );
        $conversionId2 = $this->_insertDataIntermediateAdConnection($aData);

        // Insert the variable value for the conversion
        $aData = array(
            'data_intermediate_ad_connection_id' => $conversionId2,
            'tracker_variable_id'                => 1,
            'value'                              => 'value'
        );
        $this->_insertDataIntermediateAdVariableValue($aData);

        // De-duplicate
        $this->oDal->deduplicateConversions($oStartDate, $oEndDate);

        // Test the results
        $rows = $this->_countDataIntermediateAdConnections();
        $this->assertEqual($rows, 2);

        $rows = $this->_countDataIntermediateAdConnectionsApproved();
        $this->assertEqual($rows, 1);

        $doData_intermediate_ad_connection = OA_Dal::factoryDO('data_intermediate_ad_connection');
        $doData_intermediate_ad_connection->data_intermediate_ad_connection_id = $conversionId1;
        $doData_intermediate_ad_connection->find();
        $doData_intermediate_ad_connection->fetch();
        $this->assertEqual($doData_intermediate_ad_connection->connection_status, MAX_CONNECTION_STATUS_APPROVED);

        $rows = $this->_countDataIntermediateAdConnectionsDuplicate();
        $this->assertEqual($rows, 1);

        $doData_intermediate_ad_connection = OA_Dal::factoryDO('data_intermediate_ad_connection');
        $doData_intermediate_ad_connection->data_intermediate_ad_connection_id = $conversionId2;
        $doData_intermediate_ad_connection->find();
        $doData_intermediate_ad_connection->fetch();
        $this->assertEqual($doData_intermediate_ad_connection->connection_status, MAX_CONNECTION_STATUS_DUPLICATE);

        // Clean up
        DataGenerator::cleanUp();
    }

    /**********************************************************************/
    /* "REAL-LIFE" TESTS                                                  */
    /**********************************************************************/

    /**
     * A "real-life" test of the deduplicateConversions() method.
     *
     * - Tracker ID 1 tracks two variables, on non-unique, and one unique.
     * - Tracker ID 2 tracks one variable, which is unique.
     *
     * Between 12:00 and 13:00:
     * - One conversion for Tracker ID 1.
     * - One conversion for Tracker ID 2.
     * - Obviously, de-duplication is tested to ensure that both conversions
     *   remain as "approved".
     *
     * Between 13:00 and 14:00
     * - One conversion for Tracker ID 1, where the conversion is within
     *   the de-duplication window, but the variable value is not the
     *   same as for the conversion in the previous hour.
     * - Another conversion for Tracker ID 1, where the conversion is
     *   again within the de-duplication window, but this time, the
     *   variable value is the same as the conversion in the previous
     *   hour.
     * - De-duplication is tested to ensure that the first of the above
     *   conversions remains as "approved", while the second is changed
     *   to "duplicate".
     *
     * Between 14:00 and 15:00
     * - One conversion for Tracker ID 1, with a non-unique logged variable
     *   value, where the conversion is not within the de-duplication
     *   window of the original "approved" conversion, but is within the
     *   conversion window of a previously marked "duplicate" conversion.
     * - One conversion for Tracker ID 2, with a non-unique logged variable
     *   value, where the conversion is not within the de-duplication window.
     * - De-duplication is tested to ensure that the conversion where a
     *   duplicate conversion was located is also marked as "duplicate",
     *   while the other conversion with no matching conversions in the
     *   required de-duplication window does not have its "approved" status
     *   changed.
     */
    function testDeduplicateConversions_33()
    {
        // Prepare the non-unique variable value that should
        // be tracked with Tracker ID 1
        $aData = array(
            'trackerid'     => 1,
            'name'          => 'Tracker ID 1 Non-Unique Variable',
            'is_unique'     => 0,
            'unique_window' => 3600
        );
        $trackerVariableId1 = $this->_insertVariable($aData);

        // Prepare the unique variable value that should
        // be tracked with Tracker ID 1
        $aData = array(
            'trackerid'     => 1,
            'name'          => 'Tracker ID 1 Unique Variable',
            'is_unique'     => 1,
            'unique_window' => 3600
        );
        $trackerVariableId2 = $this->_insertVariable($aData);

        // Prepare the unique variable value that should
        // be tracked with tracker ID 2
        $aData = array(
            'trackerid'     => 2,
            'name'          => 'Trackers ID 2 Unique Variable',
            'is_unique'     => 1,
            'unique_window' => 3600
        );
        $trackerVariableId3 = $this->_insertVariable($aData);

        /******************************************************************/

        // Insert a connection at 12:10:00, from a click on ad ID 5, zone ID 6, at 12:09,
        // using Tracker ID 1
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
        $conversionId1 = $this->_insertDataIntermediateAdConnection($aData);

        // Insert the variable values for the conversion
        $aData = array(
            'data_intermediate_ad_connection_id' => $conversionId1,
            'tracker_variable_id'                => $trackerVariableId1,
            'value'                              => 'non-unique tracked value'
        );
        $this->_insertDataIntermediateAdVariableValue($aData);
        $aData = array(
            'data_intermediate_ad_connection_id' => $conversionId1,
            'tracker_variable_id'                => $trackerVariableId2,
            'value'                              => 'unique tracked value'
        );
        $this->_insertDataIntermediateAdVariableValue($aData);

        // Insert a connection at 12:15:00, from a click on ad ID 7, zone ID 8, at 12:14,
        // using Tracker ID 2
        $aData = array(
            'server_raw_tracker_impression_id' => 2,
            'server_raw_ip'                    => 'singleDB',
            'tracker_id'                       => 2,
            'tracker_date_time'                => '2005-09-05 12:15:00',
            'connection_date_time'             => '2005-09-05 12:14:00',
            'ad_id'                            => 7,
            'zone_id'                          => 8,
            'connection_action'                => MAX_CONNECTION_AD_CLICK,
            'connection_window'                => 1209600,
            'connection_status'                => MAX_CONNECTION_STATUS_APPROVED
        );
        $conversionId2 = $this->_insertDataIntermediateAdConnection($aData);

        // Insert the variable value for the conversion
        $aData = array(
            'data_intermediate_ad_connection_id' => $conversionId2,
            'tracker_variable_id'                => $trackerVariableId3,
            'value'                              => 'unique tracked value'
        );
        $this->_insertDataIntermediateAdVariableValue($aData);

        // De-duplicate the 12:00 - 13:00 hour
        $oStartDate = new Date('2005-09-05 12:00:00');
        $oEndDate   = new Date('2005-09-07 12:59:59');
        $this->oDal->deduplicateConversions($oStartDate, $oEndDate);

        // Test the results
        $rows = $this->_countDataIntermediateAdConnections();
        $this->assertEqual($rows, 2);

        $rows = $this->_countDataIntermediateAdConnectionsApproved();
        $this->assertEqual($rows, 2);

        /******************************************************************/

        // Insert a connection at 13:05:00, from a click on ad ID 5, zone ID 6, at 13:04,
        // using Tracker ID 1
        $aData = array(
            'server_raw_tracker_impression_id' => 3,
            'server_raw_ip'                    => 'singleDB',
            'tracker_id'                       => 1,
            'tracker_date_time'                => '2005-09-05 13:05:00',
            'connection_date_time'             => '2005-09-05 13:04:00',
            'ad_id'                            => 5,
            'zone_id'                          => 6,
            'connection_action'                => MAX_CONNECTION_AD_CLICK,
            'connection_window'                => 1209600,
            'connection_status'                => MAX_CONNECTION_STATUS_APPROVED
        );
        $conversionId3 = $this->_insertDataIntermediateAdConnection($aData);

        // Insert the variable values for the conversion
        $aData = array(
            'data_intermediate_ad_connection_id' => $conversionId3,
            'tracker_variable_id'                => $trackerVariableId1,
            'value'                              => 'non-unique tracked value'
        );
        $this->_insertDataIntermediateAdVariableValue($aData);
        $aData = array(
            'data_intermediate_ad_connection_id' => $conversionId3,
            'tracker_variable_id'                => $trackerVariableId2,
            'value'                              => 'unique tracked value, but a different one :-)'
        );
        $this->_insertDataIntermediateAdVariableValue($aData);

        // Insert a connection at 13:06:00, from a click on ad ID 5, zone ID 6, at 13:05,
        // using Tracker ID 1
        $aData = array(
            'server_raw_tracker_impression_id' => 4,
            'server_raw_ip'                    => 'singleDB',
            'tracker_id'                       => 1,
            'tracker_date_time'                => '2005-09-05 13:06:00',
            'connection_date_time'             => '2005-09-05 13:05:00',
            'ad_id'                            => 5,
            'zone_id'                          => 6,
            'connection_action'                => MAX_CONNECTION_AD_CLICK,
            'connection_window'                => 1209600,
            'connection_status'                => MAX_CONNECTION_STATUS_APPROVED
        );
        $conversionId4 = $this->_insertDataIntermediateAdConnection($aData);

        // Insert the variable values for the conversion
        $aData = array(
            'data_intermediate_ad_connection_id' => $conversionId4,
            'tracker_variable_id'                => $trackerVariableId1,
            'value'                              => 'non-unique tracked value'
        );
        $this->_insertDataIntermediateAdVariableValue($aData);
        $aData = array(
            'data_intermediate_ad_connection_id' => $conversionId4,
            'tracker_variable_id'                => $trackerVariableId2,
            'value'                              => 'unique tracked value'
        );
        $this->_insertDataIntermediateAdVariableValue($aData);

        // De-duplicate the 13:00 - 14:00 hour
        $oStartDate = new Date('2005-09-05 13:00:00');
        $oEndDate   = new Date('2005-09-07 13:59:59');
        $this->oDal->deduplicateConversions($oStartDate, $oEndDate);

        // Test the results
        $rows = $this->_countDataIntermediateAdConnections();
        $this->assertEqual($rows, 4);

        $rows = $this->_countDataIntermediateAdConnectionsApproved();
        $this->assertEqual($rows, 3);

        $doData_intermediate_ad_connection = OA_Dal::factoryDO('data_intermediate_ad_connection');
        $doData_intermediate_ad_connection->data_intermediate_ad_connection_id = $conversionId1;
        $doData_intermediate_ad_connection->find();
        $doData_intermediate_ad_connection->fetch();
        $this->assertEqual($doData_intermediate_ad_connection->connection_status, MAX_CONNECTION_STATUS_APPROVED);

        $doData_intermediate_ad_connection = OA_Dal::factoryDO('data_intermediate_ad_connection');
        $doData_intermediate_ad_connection->data_intermediate_ad_connection_id = $conversionId2;
        $doData_intermediate_ad_connection->find();
        $doData_intermediate_ad_connection->fetch();
        $this->assertEqual($doData_intermediate_ad_connection->connection_status, MAX_CONNECTION_STATUS_APPROVED);

        $doData_intermediate_ad_connection = OA_Dal::factoryDO('data_intermediate_ad_connection');
        $doData_intermediate_ad_connection->data_intermediate_ad_connection_id = $conversionId3;
        $doData_intermediate_ad_connection->find();
        $doData_intermediate_ad_connection->fetch();
        $this->assertEqual($doData_intermediate_ad_connection->connection_status, MAX_CONNECTION_STATUS_APPROVED);

        $rows = $this->_countDataIntermediateAdConnectionsDuplicate();
        $this->assertEqual($rows, 1);

        $doData_intermediate_ad_connection = OA_Dal::factoryDO('data_intermediate_ad_connection');
        $doData_intermediate_ad_connection->data_intermediate_ad_connection_id = $conversionId4;
        $doData_intermediate_ad_connection->find();
        $doData_intermediate_ad_connection->fetch();
        $this->assertEqual($doData_intermediate_ad_connection->connection_status, MAX_CONNECTION_STATUS_DUPLICATE);

        /******************************************************************/

        // Insert a connection at 14:02:00, from a click on ad ID 5, zone ID 6, at 14:01,
        // using Tracker ID 1
        $aData = array(
            'server_raw_tracker_impression_id' => 5,
            'server_raw_ip'                    => 'singleDB',
            'tracker_id'                       => 1,
            'tracker_date_time'                => '2005-09-05 14:02:00',
            'connection_date_time'             => '2005-09-05 14:01:00',
            'ad_id'                            => 5,
            'zone_id'                          => 6,
            'connection_action'                => MAX_CONNECTION_AD_CLICK,
            'connection_window'                => 1209600,
            'connection_status'                => MAX_CONNECTION_STATUS_APPROVED
        );
        $conversionId5 = $this->_insertDataIntermediateAdConnection($aData);

        // Insert the variable values for the conversion
        $aData = array(
            'data_intermediate_ad_connection_id' => $conversionId5,
            'tracker_variable_id'                => $trackerVariableId1,
            'value'                              => 'non-unique tracked value'
        );
        $this->_insertDataIntermediateAdVariableValue($aData);
        $aData = array(
            'data_intermediate_ad_connection_id' => $conversionId5,
            'tracker_variable_id'                => $trackerVariableId2,
            'value'                              => 'unique tracked value'
        );
        $this->_insertDataIntermediateAdVariableValue($aData);

        // Insert a connection at 14:15:00, from a click on ad ID 7, zone ID 8, at 14:14,
        // using Tracker ID 2
        $aData = array(
            'server_raw_tracker_impression_id' => 6,
            'server_raw_ip'                    => 'singleDB',
            'tracker_id'                       => 2,
            'tracker_date_time'                => '2005-09-05 14:15:00',
            'connection_date_time'             => '2005-09-05 14:14:00',
            'ad_id'                            => 7,
            'zone_id'                          => 8,
            'connection_action'                => MAX_CONNECTION_AD_CLICK,
            'connection_window'                => 1209600,
            'connection_status'                => MAX_CONNECTION_STATUS_APPROVED
        );
        $conversionId6 = $this->_insertDataIntermediateAdConnection($aData);

        // Insert the variable value for the conversion
        $aData = array(
            'data_intermediate_ad_connection_id' => $conversionId6,
            'tracker_variable_id'                => $trackerVariableId3,
            'value'                              => 'unique tracked value'
        );
        $this->_insertDataIntermediateAdVariableValue($aData);

        // De-duplicate the 14:00 - 15:00 hour
        $oStartDate = new Date('2005-09-05 14:00:00');
        $oEndDate   = new Date('2005-09-07 14:59:59');
        $this->oDal->deduplicateConversions($oStartDate, $oEndDate);

        // Test the results
        $rows = $this->_countDataIntermediateAdConnections();
        $this->assertEqual($rows, 6);

        $rows = $this->_countDataIntermediateAdConnectionsApproved();
        $this->assertEqual($rows, 4);

        $doData_intermediate_ad_connection = OA_Dal::factoryDO('data_intermediate_ad_connection');
        $doData_intermediate_ad_connection->data_intermediate_ad_connection_id = $conversionId1;
        $doData_intermediate_ad_connection->find();
        $doData_intermediate_ad_connection->fetch();
        $this->assertEqual($doData_intermediate_ad_connection->connection_status, MAX_CONNECTION_STATUS_APPROVED);

        $doData_intermediate_ad_connection = OA_Dal::factoryDO('data_intermediate_ad_connection');
        $doData_intermediate_ad_connection->data_intermediate_ad_connection_id = $conversionId2;
        $doData_intermediate_ad_connection->find();
        $doData_intermediate_ad_connection->fetch();
        $this->assertEqual($doData_intermediate_ad_connection->connection_status, MAX_CONNECTION_STATUS_APPROVED);

        $doData_intermediate_ad_connection = OA_Dal::factoryDO('data_intermediate_ad_connection');
        $doData_intermediate_ad_connection->data_intermediate_ad_connection_id = $conversionId3;
        $doData_intermediate_ad_connection->find();
        $doData_intermediate_ad_connection->fetch();
        $this->assertEqual($doData_intermediate_ad_connection->connection_status, MAX_CONNECTION_STATUS_APPROVED);

        $doData_intermediate_ad_connection = OA_Dal::factoryDO('data_intermediate_ad_connection');
        $doData_intermediate_ad_connection->data_intermediate_ad_connection_id = $conversionId6;
        $doData_intermediate_ad_connection->find();
        $doData_intermediate_ad_connection->fetch();
        $this->assertEqual($doData_intermediate_ad_connection->connection_status, MAX_CONNECTION_STATUS_APPROVED);

        $rows = $this->_countDataIntermediateAdConnectionsDuplicate();
        $this->assertEqual($rows, 2);

        $doData_intermediate_ad_connection = OA_Dal::factoryDO('data_intermediate_ad_connection');
        $doData_intermediate_ad_connection->data_intermediate_ad_connection_id = $conversionId4;
        $doData_intermediate_ad_connection->find();
        $doData_intermediate_ad_connection->fetch();
        $this->assertEqual($doData_intermediate_ad_connection->connection_status, MAX_CONNECTION_STATUS_DUPLICATE);

        $doData_intermediate_ad_connection = OA_Dal::factoryDO('data_intermediate_ad_connection');
        $doData_intermediate_ad_connection->data_intermediate_ad_connection_id = $conversionId5;
        $doData_intermediate_ad_connection->find();
        $doData_intermediate_ad_connection->fetch();
        $this->assertEqual($doData_intermediate_ad_connection->connection_status, MAX_CONNECTION_STATUS_DUPLICATE);

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
     *                 "duplicate".
     */
    private function _countDataIntermediateAdConnectionsDuplicate()
    {
        $doData_intermediate_ad_connection = OA_Dal::factoryDO('data_intermediate_ad_connection');
        $doData_intermediate_ad_connection->connection_status = MAX_CONNECTION_STATUS_DUPLICATE;
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
        $doVariables->is_unique       = $aData['is_unique'];
        $doVariables->unique_window   = $aData['unique_window'];

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