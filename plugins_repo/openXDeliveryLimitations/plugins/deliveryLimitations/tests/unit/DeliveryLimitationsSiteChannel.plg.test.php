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
require_once dirname(dirname(dirname(__FILE__))) . '/Site/Channel.delivery.php';

/**
 * A class for testing the Plugins_DeliveryLimitations_Geo_City class.
 *
 * @package    OpenXPlugin
 * @subpackage TestSuite
 */
class Plugins_TestOfPlugins_DeliveryLimitations_Site_Channel extends UnitTestCase
{
    function setUp()
    {
        $aConf = & $GLOBALS['_MAX']['CONF'];
        $aConf['pluginGroupComponents']['Site'] = 1;
        $aConf['pluginPaths']['plugins'] = '/plugins_repo/openXDeliveryLimitations/plugins/';
    }

    function tearDown()
    {
        TestEnv::restoreConfig();
    }

    function __construct()
 	    {
 	        parent::__construct();
 	        //TestEnv::restoreEnv();
 	        $this->aIds = TestEnv::loadData('delivery_001','mdb2schema');
 	    }

    function testCompile()
    {
        $oPlugin = &OX_Component::factory('deliveryLimitations', 'Site', 'Channel');
        $oPlugin->init(array('data' => '21', 'comparison' => '=='));
        $this->assertEqual("(MAX_checkSite_Channel('21', '=='))", $oPlugin->compile());

        $oPlugin->init(array('data' => '21,43', 'comparison' => '=='));
        $this->assertEqual("(MAX_checkSite_Channel('21', '==') && MAX_checkSite_Channel('43', '=='))", $oPlugin->compile());

        $oPlugin->init(array('data' => '21,43', 'comparison' => '=~'));
        $this->assertEqual("(MAX_checkSite_Channel('21', '=~') || MAX_checkSite_Channel('43', '=~'))", $oPlugin->compile());

        $oPlugin->init(array('data' => '21,43', 'comparison' => '!~'));
        $this->assertEqual("!(MAX_checkSite_Channel('21', '!~') || MAX_checkSite_Channel('43', '!~'))", $oPlugin->compile());
    }

    function testMAX_checkSite_Channel()
    {
        $channelid  = $this->aIds['channel'][10];
        $GLOBALS['loc'] = 'localhost2';
        $this->assertTrue(MAX_checkSite_Channel($channelid, '=='));

        // The previous result is cached in memory
        $GLOBALS['loc'] = 'blah.com';
        $this->assertTrue(MAX_checkSite_Channel($channelid, '=='));

        // Clear cache
        $GLOBALS['_MAX']['channel_results'] = array();
        $this->assertFalse(MAX_checkSite_Channel($channelid, '=='));
    }
}

?>
