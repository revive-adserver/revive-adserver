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

require_once MAX_PATH . '/lib/max/Plugin.php';
require_once MAX_PATH . '/plugins/deliveryLimitations/tests/unit/DeliveryLimitationsTestCase.plg.php';
require_once MAX_PATH . '/plugins/deliveryLimitations/Site/Channel.delivery.php';

/**
 * A class for testing the Plugins_DeliveryLimitations_Geo_City class.
 *
 * @package    OpenXPlugin
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew@m3.net>
 */
class Plugins_TestOfPlugins_DeliveryLimitations_Site_Channel extends Plugins_DeliveryLimitations_TestCase
{
    /**
     * The constructor method.
     */
    function Plugins_TestOfPlugins_DeliveryLimitations_Site_Channel()
    {
        $this->UnitTestCase();
        TestEnv::restoreEnv();
        $error = TestEnv::loadData('2.5.50_delivery');
    }

    function testCompile()
    {
        $current_quotes_runtime = get_magic_quotes_runtime();
        set_magic_quotes_runtime(1);

        $oPlugin = &MAX_Plugin::factory('deliveryLimitations', 'Site', 'Channel');
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

        $GLOBALS['loc'] = 'localhost2';
        $this->assertTrue(MAX_checkSite_Channel('10', '=='));
        $GLOBALS['loc'] = 'blah.com';
        $this->assertFalse(MAX_checkSite_Channel('10', '=='));

        set_magic_quotes_runtime($current_quotes_runtime);
    }

    function testOverlap()
    {
        $oPlugin = &MAX_Plugin::factory('deliveryLimitations', 'Site', 'Channel');
        $oPlugin->init(array()); // Assume it is called in the production after talking to Andrew

        $this->checkOverlapFalse($oPlugin, '==', '1', '==', '2');
        $this->checkOverlapFalse($oPlugin, '==', '1,2', '==', '2,3');
        $this->checkOverlapFalse($oPlugin, '=~', '1', '=~', '2');
        $this->checkOverlapFalse($oPlugin, '=~', '1,2', '=~', '3,4');
        $this->checkOverlapFalse($oPlugin, '!~', '1', '==', '1');
        $this->checkOverlapTrue($oPlugin, '==', '1', '==', '1');
        $this->checkOverlapTrue($oPlugin, '==', '1', '=~', '1');
        $this->checkOverlapTrue($oPlugin, '==', '1,4,5', '=~', '2,1,3');
        $this->checkOverlapTrue($oPlugin, '==', '2,1', '==', '1,2');
        $this->checkOverlapTrue($oPlugin, '=~', '1', '=~', '1');
        $this->checkOverlapTrue($oPlugin, '=~', '1,2', '=~', '3,4,5,1');
        $this->checkOverlapTrue($oPlugin, '!~', '1,2', '!~', '1,2');
        $this->checkOverlapFalse($oPlugin, '!~', '1,2', '=~', '1,2');
        $this->checkOverlapFalse($oPlugin, '!~', '1', '=~', '1,2,3');
    }
}

?>
