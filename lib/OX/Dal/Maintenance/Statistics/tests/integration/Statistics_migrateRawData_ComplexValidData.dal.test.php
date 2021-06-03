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

require_once LIB_PATH . '/Dal/Maintenance/Statistics/Factory.php';

Language_Loader::load();

/**
 * A class for testing the migrateRawRequests(), migrateRawImpressions()
 * and migrateRawClicks() methods of the MySQL / PgSQL
 * OX_Dal_Maintenance_Statistics classes.
 *
 * @package    OpenXDal
 * @subpackage TestSuite
 */
class Test_OX_Dal_Maintenance_Statistics_migrateRawData_Complex extends UnitTestCase
{

    /**
     * Local copy of the database connection for use in the tests;
     *
     * @var MDB2_Driver_Common
     */
    var $oDbh;

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
    function __construct()
    {
        parent::__construct();

        // Prepare the database connection for use in the tests
        $this->oDbh = OA_DB::singleton();

        // Prepare the MSE DAL for use in the tests
        $oFactory = new OX_Dal_Maintenance_Statistics_Factory();
        $this->oDal = $oFactory->factory();
    }

    /**
     * A method to test when there are old format raw requests,
     * impressions and clicks, in the operation interval being
     * migrated.
     */
    function testComplexValidData()
    {
        $aConf =& $GLOBALS['_MAX']['CONF'];
        $aConf['maintenance']['operationInterval'] = 60;

        // Prepare an array of the required tables used in testing
        $aTables = array(
            $aConf['table']['prefix'] . $aConf['table']['data_raw_ad_request']    => $aConf['table']['prefix'] . 'data_bkt_r',
            $aConf['table']['prefix'] . $aConf['table']['data_raw_ad_impression'] => $aConf['table']['prefix'] . 'data_bkt_m',
            $aConf['table']['prefix'] . $aConf['table']['data_raw_ad_click']      => $aConf['table']['prefix'] . 'data_bkt_c'
        );

        // Install the openXDeliveryLog plugin, which will create the
        // data bucket tables required for testing
        TestEnv::installPluginPackage('openXDeliveryLog', false);

        // Ensure that there are no old format raw data
        foreach ($aTables as $rawTable => $bucketTable) {
            $query = "
                SELECT
                    COUNT(*) AS count
                FROM
                    " . $this->oDbh->quoteIdentifier($rawTable, true);
            $rsResult = $this->oDbh->query($query);
            $this->assertNotA($rsResult, 'PEAR_Error');
            $rows = $rsResult->numRows();
            $this->assertEqual($rows, 1);
            $aRow = $rsResult->fetchRow();
            $this->assertEqual($aRow['count'], 0);
        }

        // Ensure that there are no new format bucket data
        foreach ($aTables as $rawTable => $bucketTable) {
            $query = "
                SELECT
                    COUNT(*) AS count
                FROM
                    " . $this->oDbh->quoteIdentifier($bucketTable, true);
            $rsResult = $this->oDbh->query($query);
            $this->assertNotA($rsResult, 'PEAR_Error');
            $rows = $rsResult->numRows();
            $this->assertEqual($rows, 1);
            $aRow = $rsResult->fetchRow();
            $this->assertEqual($aRow['count'], 0);
        }

        // Insert some old style raw data in an operation interval
        // that will not be migrated
        foreach ($aTables as $rawTable => $bucketTable) {
            $query = "
                INSERT INTO
                    " . $this->oDbh->quoteIdentifier($rawTable, true) . "
                    (
                        date_time,
                        ad_id,
                        creative_id,
                        zone_id
                    )
                VALUES
                    (
                        '2009-01-09 11:30:00',
                        1,
                        0,
                        1
                    )";
            $this->oDbh->exec($query);
        }

        // Ensure that the old format raw data was inserted correctly
        foreach ($aTables as $rawTable => $bucketTable) {
            $query = "
                SELECT
                    COUNT(*) AS count
                FROM
                    " . $this->oDbh->quoteIdentifier($rawTable, true);
            $rsResult = $this->oDbh->query($query);
            $this->assertNotA($rsResult, 'PEAR_Error');
            $rows = $rsResult->numRows();
            $this->assertEqual($rows, 1);
            $aRow = $rsResult->fetchRow();
            $this->assertEqual($aRow['count'], 1);
        }

        // Insert some old style raw data in an operation interval
        // that will be migrated
        foreach ($aTables as $rawTable => $bucketTable) {
            $query = "
                INSERT INTO
                    " . $this->oDbh->quoteIdentifier($rawTable, true) . "
                    (
                        date_time,
                        ad_id,
                        creative_id,
                        zone_id
                    )
                VALUES
                    (
                        '2009-01-09 12:30:00',
                        1,
                        0,
                        1
                    )";
            $this->oDbh->exec($query);
            $query = "
                INSERT INTO
                    " . $this->oDbh->quoteIdentifier($rawTable, true) . "
                    (
                        date_time,
                        ad_id,
                        creative_id,
                        zone_id
                    )
                VALUES
                    (
                        '2009-01-09 12:31:00',
                        1,
                        0,
                        1
                    )";
            $this->oDbh->exec($query);
            $query = "
                INSERT INTO
                    " . $this->oDbh->quoteIdentifier($rawTable, true) . "
                    (
                        date_time,
                        ad_id,
                        creative_id,
                        zone_id
                    )
                VALUES
                    (
                        '2009-01-09 12:32:00',
                        2,
                        0,
                        3
                    )";
            $this->oDbh->exec($query);
        }

        // Ensure that the old format raw data was inserted correctly
        foreach ($aTables as $rawTable => $bucketTable) {
            $query = "
                SELECT
                    COUNT(*) AS count
                FROM
                    " . $this->oDbh->quoteIdentifier($rawTable, true);
            $rsResult = $this->oDbh->query($query);
            $this->assertNotA($rsResult, 'PEAR_Error');
            $rows = $rsResult->numRows();
            $this->assertEqual($rows, 1);
            $aRow = $rsResult->fetchRow();
            $this->assertEqual($aRow['count'], 4);
        }

        // Run the migration of raw data DAL code for a given OI
        $oStart = new Date('2009-01-09 12:00:00');
        $oEnd   = new Date('2009-01-09 12:59:59');

        $this->oDal->migrateRawRequests($oStart, $oEnd);
        $this->oDal->migrateRawImpressions($oStart, $oEnd);
        $this->oDal->migrateRawClicks($oStart, $oEnd);

        // Test that the data was migrated correctly
        foreach ($aTables as $rawTable => $bucketTable) {
            $query = "
                SELECT
                    COUNT(*) AS count
                FROM
                    " . $this->oDbh->quoteIdentifier($bucketTable, true);
            $rsResult = $this->oDbh->query($query);
            $this->assertNotA($rsResult, 'PEAR_Error');
            $rows = $rsResult->numRows();
            $this->assertEqual($rows, 1);
            $aRow = $rsResult->fetchRow();
            $this->assertEqual($aRow['count'], 2);

            $query = "
                SELECT
                    *
                FROM
                    " . $this->oDbh->quoteIdentifier($bucketTable, true);
            $rsResult = $this->oDbh->query($query);
            $this->assertNotA($rsResult, 'PEAR_Error');
            $rows = $rsResult->numRows();
            $this->assertEqual($rows, 2);

            $query = "
                SELECT
                    *
                FROM
                    " . $this->oDbh->quoteIdentifier($bucketTable, true) . "
                WHERE
                    creative_id = 1";
            $rsResult = $this->oDbh->query($query);
            $this->assertNotA($rsResult, 'PEAR_Error');
            $rows = $rsResult->numRows();
            $this->assertEqual($rows, 1);
            $aRow = $rsResult->fetchRow();
            $this->assertEqual($aRow['interval_start'], '2009-01-09 12:00:00');
            $this->assertEqual($aRow['creative_id'], 1);
            $this->assertEqual($aRow['zone_id'], 1);
            $this->assertEqual($aRow['count'], 2);

            $query = "
                SELECT
                    *
                FROM
                    " . $this->oDbh->quoteIdentifier($bucketTable, true) . "
                WHERE
                    creative_id = 2";
            $rsResult = $this->oDbh->query($query);
            $this->assertNotA($rsResult, 'PEAR_Error');
            $rows = $rsResult->numRows();
            $this->assertEqual($rows, 1);
            $aRow = $rsResult->fetchRow();
            $this->assertEqual($aRow['interval_start'], '2009-01-09 12:00:00');
            $this->assertEqual($aRow['creative_id'], 2);
            $this->assertEqual($aRow['zone_id'], 3);
            $this->assertEqual($aRow['count'], 1);
        }

        // Uninstall the installed plugin
        TestEnv::uninstallPluginPackage('openXDeliveryLog', false);

        // Restore the test environment configuration
        TestEnv::restoreConfig();
    }

}

?>