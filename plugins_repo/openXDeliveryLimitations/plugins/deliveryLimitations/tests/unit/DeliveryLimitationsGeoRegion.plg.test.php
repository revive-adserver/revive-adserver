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

require_once LIB_PATH . '/Plugin/Component.php';
// Using multi-dirname so that the tests can run from either plugins or plugins_repo
require_once dirname(dirname(dirname(__FILE__))) . '/Geo/Region.delivery.php';

/**
 * A class for testing the Plugins_DeliveryLimitations_Geo_Region class.
 *
 * @package    OpenXPlugin
 * @subpackage TestSuite
 */
class Plugins_TestOfPlugins_DeliveryLimitations_Geo_Region extends UnitTestCase
{
    function setUp()
    {
        $aConf = & $GLOBALS['_MAX']['CONF'];
        $aConf['pluginGroupComponents']['Geo'] = 1;
        $aConf['pluginPaths']['plugins'] = '/plugins_repo/openXDeliveryLimitations/plugins/';
    }

    function tearDown()
    {
        TestEnv::restoreConfig();
    }

    function testInit()
    {
        $oPlugin = &OX_Component::factory('deliveryLimitations', 'Geo', 'Region');
        $oPlugin->init(array('data' => 'FR|C1,97,98,99,A1,A2,A3,A4,A5,A6,A7,A8,A9,B1,B2,B3,B4,B5,B6,B7,B8,B9', 'comparison' => '=='));
    }

    function testCompile()
    {
        $oPlugin = &OX_Component::factory('deliveryLimitations', 'Geo', 'Region');
        $rawData = 'GB|T5,T7';
        $oPlugin->init(array('data' => $rawData, 'comparison' => '=='));
        $this->assertEqual('MAX_checkGeo_Region(\'gb|t5,t7\', \'==\')', $oPlugin->compile());
        $this->assertEqual($rawData, $oPlugin->getData());
        $oPlugin->init(array('data' => array('GB', 'T5', 'T7'), 'comparison' => '=='));
        $this->assertEqual('MAX_checkGeo_Region(\'gb|t5,t7\', \'==\')', $oPlugin->compile());
    }

    function testMAX_checkGeo_Region()
    {
        $this->assertTrue(MAX_checkGeo_Region('gb|t7,t8,t9',
            'bla', array('country_code' => 'GB', 'region' => 'T8')));
        $this->assertFalse(MAX_checkGeo_Region('gb|t7,t9',
            'bla', array('country_code' => 'GB', 'region' => 'T8')));
        $this->assertFalse(MAX_checkGeo_Region(
            'gb|t7,t9', 'bla', array('region' => 'T9')));
    }

}

?>
