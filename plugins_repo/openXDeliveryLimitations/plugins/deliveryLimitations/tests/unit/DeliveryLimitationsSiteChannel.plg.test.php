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

require_once LIB_PATH . '/Plugin/Component.php';
// Using multi-dirname so that the tests can run from either plugins or plugins_repo
require_once dirname(dirname(dirname(__FILE__))) . '/Site/Channel.delivery.php';

/**
 * A class for testing the Plugins_DeliveryLimitations_Geo_City class.
 *
 * @package    OpenXPlugin
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew@m3.net>
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

    function Plugins_TestOfPlugins_DeliveryLimitations_Site_Channel()
 	    {
 	        $this->UnitTestCase();
 	        //TestEnv::restoreEnv();
 	        $this->aIds = TestEnv::loadData('delivery_001','mdb2schema');
 	    }

    function testCompile()
    {
        $current_quotes_runtime = get_magic_quotes_runtime();
        set_magic_quotes_runtime(1);

        $oPlugin = &OX_Component::factory('deliveryLimitations', 'Site', 'Channel');
        $oPlugin->init(array('data' => '21', 'comparison' => '=='));
        $this->assertEqual("(MAX_checkSite_Channel('21', '=='))", $oPlugin->compile());

        $oPlugin->init(array('data' => '21,43', 'comparison' => '=='));
        $this->assertEqual("(MAX_checkSite_Channel('21', '==') && MAX_checkSite_Channel('43', '=='))", $oPlugin->compile());

        $oPlugin->init(array('data' => '21,43', 'comparison' => '=~'));
        $this->assertEqual("(MAX_checkSite_Channel('21', '=~') || MAX_checkSite_Channel('43', '=~'))", $oPlugin->compile());

        $oPlugin->init(array('data' => '21,43', 'comparison' => '!~'));
        $this->assertEqual("!(MAX_checkSite_Channel('21', '!~') || MAX_checkSite_Channel('43', '!~'))", $oPlugin->compile());

        set_magic_quotes_runtime($current_quotes_runtime);
    }

    function testMAX_checkSite_Channel()
    {
        $current_quotes_runtime = get_magic_quotes_runtime();
        set_magic_quotes_runtime(0);
        $channelid  = $this->aIds['channel'][10];
        $GLOBALS['loc'] = 'localhost2';
        $this->assertTrue(MAX_checkSite_Channel($channelid, '=='));
        $GLOBALS['loc'] = 'blah.com';
        $this->assertFalse(MAX_checkSite_Channel($channelid, '=='));

        set_magic_quotes_runtime($current_quotes_runtime);
    }
}

?>
