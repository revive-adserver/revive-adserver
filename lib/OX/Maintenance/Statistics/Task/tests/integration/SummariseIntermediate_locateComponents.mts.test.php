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
require_once LIB_PATH . '/Maintenance/Statistics/Task/SummariseIntermediate.php';

/**
 * A class for testing the OX_Maintenance_Statistics_Task_MigrateBucketData class.
 *
 * @package    OpenXMaintenance
 * @subpackage TestSuite
 */
class Test_OX_Maintenance_Statistics_Task_MigrateBucketData_locateComponents extends UnitTestCase
{

    /**
     * The constructor method.
     */
    function __construct()
    {
        parent::__construct();
    }

    /**
     * A method to test the _locateComponents() method.
     */
    function test_locateComponents()
    {
        $aConf = $GLOBALS['_MAX']['CONF'];

        // Test 1: There are no deliveryLog group plugins installed, test that
        //         an empty array is returned
        $oSummariseIntermediate = new OX_Maintenance_Statistics_Task_MigrateBucketData();
        $aComponents = $oSummariseIntermediate->_locateComponents();
        $this->assertTrue(is_array($aComponents));
        $this->assertTrue(empty($aComponents));

        // Setup the default OpenX delivery logging plugin for the next test
        TestEnv::installPluginPackage('openXDeliveryLog', false);

        // Test 2: Test with the default OpenX delivery logging plugin installed
        $oSummariseIntermediate = new OX_Maintenance_Statistics_Task_MigrateBucketData();
        $aComponents = $oSummariseIntermediate->_locateComponents();
        $this->assertTrue(is_array($aComponents));
        $this->assertEqual(count($aComponents), 3);
        $dia = $aConf['table']['prefix'] . 'data_intermediate_ad';
        $this->assertTrue(is_array($aComponents[$dia]));
        $this->assertEqual(count($aComponents[$dia]), 3);
        $aComponentClasses = array();
        foreach ($aComponents[$dia] as $oComponent) {
            $aComponentClasses[] = get_class($oComponent);
        }
        $this->assertTrue(in_array('Plugins_DeliveryLog_OxLogRequest_LogRequest', $aComponentClasses));
        $this->assertTrue(in_array('Plugins_DeliveryLog_OxLogImpression_LogImpression', $aComponentClasses));
        $this->assertTrue(in_array('Plugins_DeliveryLog_OxLogClick_LogClick', $aComponentClasses));

        $diac = $aConf['table']['prefix'] . 'data_intermediate_ad_connection';
        $this->assertTrue(is_array($aComponents[$diac]));
        $this->assertEqual(count($aComponents[$diac]), 1);
        $aComponentClasses = array();
        foreach ($aComponents[$diac] as $oComponent) {
            $aComponentClasses[] = get_class($oComponent);
        }
        $this->assertTrue(in_array('Plugins_DeliveryLog_OxLogConversion_LogConversion', $aComponentClasses));

        $diavv = $aConf['table']['prefix'] . 'data_intermediate_ad_variable_value';
        $this->assertTrue(is_array($aComponents[$diavv]));
        $this->assertEqual(count($aComponents[$diavv]), 1);
        $aComponentClasses = array();
        foreach ($aComponents[$diavv] as $oComponent) {
            $aComponentClasses[] = get_class($oComponent);
        }
        $this->assertTrue(in_array('Plugins_DeliveryLog_OxLogConversion_LogConversionVariable', $aComponentClasses));

/*
TODO: move this test from core code to the plugin.  only bundled plugins (or the test plugin) can be used in core tests

        // Setup the default OpenX country based impression and click delivery logging plugin for the next test
        TestEnv::installPluginPackage('openXDeliveryLogCountry', false);

        // Test 3: Test with the default OpenX delivery logging plugin and the OpenX country based impression
        //         and click delivery logging plugin installed
        $aComponents = $oSummariseIntermediate->_locateComponents();
        $this->assertTrue(is_array($aComponents));
        $this->assertEqual(count($aComponents), 4);
        $dia = $aConf['table']['prefix'] . 'data_intermediate_ad';
        $this->assertTrue(is_array($aComponents[$dia]));
        $this->assertEqual(count($aComponents[$dia]), 4);
        $aComponentClasses = array();
        foreach ($aComponents[$dia] as $oComponent) {
            $aComponentClasses[] = get_class($oComponent);
        }
        $this->assertTrue(in_array('Plugins_DeliveryLog_OxLogRequest_LogRequest', $aComponentClasses));
        $this->assertTrue(in_array('Plugins_DeliveryLog_OxLogImpression_LogImpression', $aComponentClasses));
        $this->assertTrue(in_array('Plugins_DeliveryLog_OxLogClick_LogClick', $aComponentClasses));
        $this->assertTrue(in_array('Plugins_DeliveryLog_OxLogImpression_logImpressionBackup', $aComponentClasses));

        $diac = $aConf['table']['prefix'] . 'data_intermediate_ad_connection';
        $this->assertTrue(is_array($aComponents[$diac]));
        $this->assertEqual(count($aComponents[$diac]), 1);
        $aComponentClasses = array();
        foreach ($aComponents[$diac] as $oComponent) {
            $aComponentClasses[] = get_class($oComponent);
        }
        $this->assertTrue(in_array('Plugins_DeliveryLog_OxLogConversion_LogConversion', $aComponentClasses));

        $diavv = $aConf['table']['prefix'] . 'data_intermediate_ad_variable_value';
        $this->assertTrue(is_array($aComponents[$diavv]));
        $this->assertEqual(count($aComponents[$diavv]), 1);
        $aComponentClasses = array();
        foreach ($aComponents[$diavv] as $oComponent) {
            $aComponentClasses[] = get_class($oComponent);
        }
        $this->assertTrue(in_array('Plugins_DeliveryLog_OxLogConversion_LogConversionVariable', $aComponentClasses));

        $sc = $aConf['table']['prefix'] . 'stats_country';
        $this->assertTrue(is_array($aComponents[$sc]));
        $this->assertEqual(count($aComponents[$sc]), 2);
        $aComponentClasses = array();
        foreach ($aComponents[$sc] as $oComponent) {
            $aComponentClasses[] = get_class($oComponent);
        }
        $this->assertTrue(in_array('Plugins_DeliveryLog_OxLogCountry_LogImpressionCountry', $aComponentClasses));
        $this->assertTrue(in_array('Plugins_DeliveryLog_OxLogCountry_LogClickCountry', $aComponentClasses));

        // Uninstall the installed plugins
        TestEnv::uninstallPluginPackage('openXDeliveryLogCountry', false);

*/
        // Uninstall the installed plugins
        TestEnv::uninstallPluginPackage('openXDeliveryLog', false);

        // Reset the testing environment
        TestEnv::restoreEnv();
    }

}

?>