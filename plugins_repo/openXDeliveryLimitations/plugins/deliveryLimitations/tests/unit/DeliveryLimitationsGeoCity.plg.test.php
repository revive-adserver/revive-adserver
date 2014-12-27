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
require_once dirname(dirname(dirname(__FILE__))) . '/Geo/City.delivery.php';

/**
 * A class for testing the Plugins_DeliveryLimitations_Geo_City class.
 *
 * @package    OpenXPlugin
 * @subpackage TestSuite
 */
class Plugins_TestOfPlugins_DeliveryLimitations_Geo_City extends UnitTestCase
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

    function testCompile()
    {
        $oPlugin = &OX_Component::factory('deliveryLimitations', 'Geo', 'City');
        $rawData = 'GB|London, Manchester';
        $oPlugin->init(array('data' => $rawData, 'comparison' => '=='));
        $this->assertEqual('MAX_checkGeo_City(\'gb|london,manchester\', \'==\')', $oPlugin->compile());
        $this->assertEqual($rawData, $oPlugin->getData());
        $oPlugin->init(array('data' => array('GB', 'London, Manchester'), 'comparison' => '=='));
        $this->assertEqual('MAX_checkGeo_City(\'gb|london,manchester\', \'==\')', $oPlugin->compile());
    }

    function testMAX_checkGeo_City()
    {
        $this->assertTrue(MAX_checkGeo_City('PL|Poznan,Wroclaw', '=~', array('country_code' => 'PL', 'city' => 'Poznan')));
        $this->assertTrue(MAX_checkGeo_City('pl|poznan,wroclaw', '=~', array('country_code' => 'PL', 'city' => 'Poznan')));
        $this->assertFalse(MAX_checkGeo_City('pl|poznan,wroclaw', '=~', array('country_code' => 'PL', 'city' => 'Warszawa')));
        $this->assertFalse(MAX_checkGeo_City('pl|poznan,wroclaw,szczecinek', '=~', array('country_code' => 'PL', 'city' => 'Szczecin')));
        $this->assertFalse(MAX_checkGeo_City('pl|', '=~', array('country_code' => 'PL', 'city' => 'Szczecin')));

        // Since we now support !city matching, these need testing, trying inverting the tests
        $this->assertFalse(MAX_checkGeo_City('PL|Poznan,Wroclaw', '!~', array('country_code' => 'PL', 'city' => 'Poznan')));
        $this->assertFalse(MAX_checkGeo_City('pl|poznan,wroclaw', '!~', array('country_code' => 'PL', 'city' => 'Poznan')));
        $this->assertTrue(MAX_checkGeo_City('pl|poznan,wroclaw', '!~', array('country_code' => 'PL', 'city' => 'Warszawa')));
        $this->assertTrue(MAX_checkGeo_City('pl|poznan,wroclaw,szczecinek', '!~', array('country_code' => 'PL', 'city' => 'Szczecin')));
        $this->assertTrue(MAX_checkGeo_City('pl|', '!~', array('country_code' => 'PL', 'city' => 'Szczecin')));
}

    function testGetName()
    {
        $oPlugin = &OX_Component::factory('deliveryLimitations', 'Geo', 'City');
        $oPlugin->init(array()); // Assume it is called in the production after talking to Andrew
        $this->assertEqual('Geo - Country / City', $oPlugin->displayName);
    }
}

?>
