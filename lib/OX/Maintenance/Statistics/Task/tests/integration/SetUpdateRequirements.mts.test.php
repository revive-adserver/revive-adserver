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

require_once MAX_PATH . '/lib/OA/ServiceLocator.php';

require_once LIB_PATH . '/Maintenance/Statistics.php';
require_once LIB_PATH . '/Maintenance/Statistics/Task/SetUpdateRequirements.php';

Language_Loader::load();

/**
 * A class for testing the OX_Maintenance_Statistics_Task_SetUpdateRequirements class.
 *
 * @package    OpenXMaintenance
 * @subpackage TestSuite
 */
class Test_OX_Maintenance_Statistics_Task_SetUpdateRequirements extends UnitTestCase
{
    /**
     * Tests the _getMaintenanceStatisticsLastRunInfo() method.
     */
    public function test_getMaintenanceStatisticsLastRunInfo()
    {
        // Create a reference to the OpenX configuration, and set it to
        // 15 minutes
        $aConf = &$GLOBALS['_MAX']['CONF'];
        $aConf['maintenance']['operationInterval'] = 15;

        // Create the database connection
        $oDbh = OA_DB::singleton();
        $oServiceLocator = OA_ServiceLocator::instance();

        // Prepare the OX_Maintenance_Statistics_Task_SetUpdateRequirements class to test with
        $oSetUpdateRequirements = new OX_Maintenance_Statistics_Task_SetUpdateRequirements();

        // Test with no data, and assert that the result is null
        $oDate = $oSetUpdateRequirements->_getMaintenanceStatisticsLastRunInfo(OX_DAL_MAINTENANCE_STATISTICS_UPDATE_OI);
        $this->assertNull($oDate);
        $oDate = $oSetUpdateRequirements->_getMaintenanceStatisticsLastRunInfo(OX_DAL_MAINTENANCE_STATISTICS_UPDATE_HOUR);
        $this->assertNull($oDate);

        // Prepare a query to insert entries into the "log_maintenance_statistics" table
        $query = "
            INSERT INTO
                " . $oDbh->quoteIdentifier($aConf['table']['prefix'] . 'log_maintenance_statistics', true) . "
                (
                    start_run,
                    end_run,
                    duration,
                    adserver_run_type,
                    updated_to
                )
            VALUES
                (?, ?, ?, ?, ?)";
        $aTypes = [
            'timestamp',
            'timestamp',
            'integer',
            'integer',
            'timestamp',
        ];
        $stLogMaintenanceStatistics = $oDbh->prepare($query, $aTypes, MDB2_PREPARE_MANIP);

        // Insert an operation interval (only) update
        $aData = [
            '2004-06-06 10:15:00',
            '2004-06-06 10:16:15',
            75,
            OX_DAL_MAINTENANCE_STATISTICS_UPDATE_OI,
            '2004-06-06 10:14:59',
        ];
        $rows = $stLogMaintenanceStatistics->execute($aData);

        // Test that the operation interval value is returned correctly, while
        // the hourly value is still null
        $oDate = $oSetUpdateRequirements->_getMaintenanceStatisticsLastRunInfo(OX_DAL_MAINTENANCE_STATISTICS_UPDATE_OI);
        $this->assertEqual($oDate, new Date('2004-06-06 10:14:59'));
        $oDate = $oSetUpdateRequirements->_getMaintenanceStatisticsLastRunInfo(OX_DAL_MAINTENANCE_STATISTICS_UPDATE_HOUR);
        $this->assertNull($oDate);

        // Insert a more recent operation interval (only) update
        $aData = [
            '2004-06-06 10:45:00',
            '2004-06-06 10:46:15',
            75,
            OX_DAL_MAINTENANCE_STATISTICS_UPDATE_OI,
            '2004-06-06 10:44:59',
        ];
        $rows = $stLogMaintenanceStatistics->execute($aData);

        // Test that the operation interval value is returned correctly, while
        // the hourly value is still null
        $oDate = $oSetUpdateRequirements->_getMaintenanceStatisticsLastRunInfo(OX_DAL_MAINTENANCE_STATISTICS_UPDATE_OI);
        $this->assertEqual($oDate, new Date('2004-06-06 10:44:59'));
        $oDate = $oSetUpdateRequirements->_getMaintenanceStatisticsLastRunInfo(OX_DAL_MAINTENANCE_STATISTICS_UPDATE_HOUR);
        $this->assertNull($oDate);

        // Insert an hourly (only) update
        $aData = [
            '2004-06-06 11:05:00',
            '2004-06-06 11:06:15',
            75,
            OX_DAL_MAINTENANCE_STATISTICS_UPDATE_HOUR,
            '2004-06-06 10:59:59',
        ];
        $rows = $stLogMaintenanceStatistics->execute($aData);

        // Test that the operation interval value is returned correctly,
        // (that is, the value from before), while the new hourly value
        // is returned correctly for the hourly test
        $oDate = $oSetUpdateRequirements->_getMaintenanceStatisticsLastRunInfo(OX_DAL_MAINTENANCE_STATISTICS_UPDATE_OI);
        $this->assertEqual($oDate, new Date('2004-06-06 10:44:59'));
        $oDate = $oSetUpdateRequirements->_getMaintenanceStatisticsLastRunInfo(OX_DAL_MAINTENANCE_STATISTICS_UPDATE_HOUR);
        $this->assertEqual($oDate, new Date('2004-06-06 10:59:59'));

        // Insert an old dual operation interval/hour udpate
        $aData = [
            '2004-06-05 12:05:00',
            '2004-06-05 12:06:15',
            75,
            OX_DAL_MAINTENANCE_STATISTICS_UPDATE_BOTH,
            '2004-06-05 11:59:59',
        ];
        $rows = $stLogMaintenanceStatistics->execute($aData);

        // Test the results are unchanged from before
        $oDate = $oSetUpdateRequirements->_getMaintenanceStatisticsLastRunInfo(OX_DAL_MAINTENANCE_STATISTICS_UPDATE_OI);
        $this->assertEqual($oDate, new Date('2004-06-06 10:44:59'));
        $oDate = $oSetUpdateRequirements->_getMaintenanceStatisticsLastRunInfo(OX_DAL_MAINTENANCE_STATISTICS_UPDATE_HOUR);
        $this->assertEqual($oDate, new Date('2004-06-06 10:59:59'));

        // Insert a newer dual operation interval/hour udpate
        $aData = [
            '2004-06-06 12:05:00',
            '2004-06-06 12:06:15',
            75,
            OX_DAL_MAINTENANCE_STATISTICS_UPDATE_BOTH,
            '2004-06-06 11:59:59',
        ];
        $rows = $stLogMaintenanceStatistics->execute($aData);

        // Test the results are now updated, and the same
        $oDate = $oSetUpdateRequirements->_getMaintenanceStatisticsLastRunInfo(OX_DAL_MAINTENANCE_STATISTICS_UPDATE_OI);
        $this->assertEqual($oDate, new Date('2004-06-06 11:59:59'));
        $oDate = $oSetUpdateRequirements->_getMaintenanceStatisticsLastRunInfo(OX_DAL_MAINTENANCE_STATISTICS_UPDATE_HOUR);
        $this->assertEqual($oDate, new Date('2004-06-06 11:59:59'));

        // Reset the testing environment
        TestEnv::restoreEnv();
    }

    /**
     * Tests the _getEarliestLoggedDeliveryData() method.
     */
    public function test_getEarliestLoggedDeliveryData()
    {
        // Create a reference to the OpenX configuration, and set it to
        // 15 minutes
        $aConf = &$GLOBALS['_MAX']['CONF'];
        $aConf['maintenance']['operationInterval'] = 15;

        // Prepare the OX_Maintenance_Statistics_Task_SetUpdateRequirements class to test with
        $oSetUpdateRequirements = new OX_Maintenance_Statistics_Task_SetUpdateRequirements();

        // Test 1: There are no deliveryLog group plugins installed, test that null is returned
        $oDate = $oSetUpdateRequirements->_getEarliestLoggedDeliveryData(OX_DAL_MAINTENANCE_STATISTICS_UPDATE_OI);
        $this->assertNull($oDate);

        // Create the "application_variable" table required for installing the plugin
        $oTables = &OA_DB_Table_Core::singleton();
        $oTables->createTable('application_variable');

        // Setup the default OpenX delivery logging plugin for the test
        TestEnv::installPluginPackage('openXDeliveryLog', false);

        // Test 2: There is no delivery data logged, test that null is returned
        $oDate = $oSetUpdateRequirements->_getEarliestLoggedDeliveryData(OX_DAL_MAINTENANCE_STATISTICS_UPDATE_OI);
        $this->assertNull($oDate);

        // Ask the appropriate default OpenX delivery logging plugin component
        // to log a click
        require_once MAX_PATH . $aConf['pluginPaths']['plugins'] . '/deliveryLog/oxLogClick/logClick.delivery.php';
        $GLOBALS['_MAX']['deliveryData'] = [
            'interval_start' => '2008-08-12 14:15:00',
            'creative_id' => 1,
            'zone_id' => 1,
        ];
        Plugin_deliveryLog_oxLogClick_logClick_Delivery_logClick();

        // Test 3: Test with just the one click logged, and ensure that the correct
        //         date/time is returned
        $oDate = $oSetUpdateRequirements->_getEarliestLoggedDeliveryData(OX_DAL_MAINTENANCE_STATISTICS_UPDATE_OI);
        $this->assertEqual($oDate, new Date('2008-08-12 14:14:59'));

        // Ask the appropriate default OpenX delivery logging plugin component
        // to log a later click
        $GLOBALS['_MAX']['deliveryData'] = [
            'interval_start' => '2008-08-12 14:30:00',
            'creative_id' => 1,
            'zone_id' => 1,
        ];
        Plugin_deliveryLog_oxLogClick_logClick_Delivery_logClick();

        // Test 4: Test with just the two clicks logged, and ensure that the correct
        //         date/time is returned (i.e. unchanged from the last test)
        $oDate = $oSetUpdateRequirements->_getEarliestLoggedDeliveryData(OX_DAL_MAINTENANCE_STATISTICS_UPDATE_OI);
        $this->assertEqual($oDate, new Date('2008-08-12 14:14:59'));

        // Ask the appropriate default OpenX delivery logging plugin component
        // to log an earlier click
        $GLOBALS['_MAX']['deliveryData'] = [
            'interval_start' => '2008-08-12 14:00:00',
            'creative_id' => 1,
            'zone_id' => 1,
        ];
        Plugin_deliveryLog_oxLogClick_logClick_Delivery_logClick();

        // Test 5: Test with just the three clicks logged, and ensure that the correct
        //         date/time is returned (i.e. earlier than the last tests)
        $oDate = $oSetUpdateRequirements->_getEarliestLoggedDeliveryData(OX_DAL_MAINTENANCE_STATISTICS_UPDATE_OI);
        $this->assertEqual($oDate, new Date('2008-08-12 13:59:59'));

        // Ask the appropriate default OpenX delivery logging plugin component
        // to log an earlier impression
        require_once MAX_PATH . $aConf['pluginPaths']['plugins'] . '/deliveryLog/oxLogImpression/logImpression.delivery.php';
        $GLOBALS['_MAX']['deliveryData'] = [
            'interval_start' => '2008-08-12 13:45:00',
            'creative_id' => 1,
            'zone_id' => 1,
        ];
        Plugin_deliveryLog_oxLogImpression_logImpression_Delivery_logImpression();

        // Test 6: Test with just the three clicks and one impression logged, and
        //         ensure that the correct date/time is returned (i.e. based on
        //         the earliest data, which is the impression).
        $oDate = $oSetUpdateRequirements->_getEarliestLoggedDeliveryData(OX_DAL_MAINTENANCE_STATISTICS_UPDATE_OI);
        $this->assertEqual($oDate, new Date('2008-08-12 13:44:59'));

        // Test 7: Re-test, but calling for the date/time returned to be based
        //         on the hour boundary, not the operation interval boundary
        $oDate = $oSetUpdateRequirements->_getEarliestLoggedDeliveryData(OX_DAL_MAINTENANCE_STATISTICS_UPDATE_HOUR);
        $this->assertEqual($oDate, new Date('2008-08-12 12:59:59'));

        // Uninstall the installed plugin
        TestEnv::uninstallPluginPackage('openXDeliveryLog', false);

        // Reset the testing environment
        TestEnv::restoreEnv();
    }
}
