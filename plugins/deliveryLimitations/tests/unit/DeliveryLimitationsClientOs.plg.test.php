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
require_once MAX_PATH . '/plugins/deliveryLimitations/Client/Os.delivery.php';

/**
 * A class for testing the Plugins_DeliveryLimitations_Client_Os class.
 *
 * @package    OpenXPlugin
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew@m3.net>
 */
class Plugins_TestOfPlugins_DeliveryLimitations_Client_Os extends Plugins_DeliveryLimitations_TestCase
{

    /**
     * The constructor method.
     */
    function Plugins_TestOfPlugins_DeliveryLimitations_Client_Os()
    {
        $this->Plugins_DeliveryLimitations_TestCase();
    }

    /**
     * A method to test the _getSqlLimitation() method.
     */
    function test_getSqlLimitation()
    {
        $oPlugin = &MAX_Plugin::factory('deliveryLimitations', 'Client', 'Os');
        $result = $oPlugin->_getSqlLimitation('==', 'xp');
        $this->assertEqual($result, "LOWER(os) IN ('xp')");
        $result = $oPlugin->_getSqlLimitation('!=', 'xp,LINUX');
        $this->assertEqual($result, "LOWER(os) NOT IN ('xp','linux')");
    }

    function testOverlap()
    {
        $oPlugin = &MAX_Plugin::factory('deliveryLimitations', 'Client', 'Os');
        $oPlugin->init(array()); // Assume it is called in the production after talking to Andrew

        $this->checkOverlapFalse($oPlugin, '==', 'xp', '==', '2k');
        $this->checkOverlapTrue($oPlugin, '==', 'xp,2k', '==', 'xp,2k');
        $this->checkOverlapFalse($oPlugin, '==', 'xp,2k', '==', '98,95');
        $this->checkOverlapFalse($oPlugin, '!=', 'xp', '==', 'xp');
        $this->checkOverlapFalse($oPlugin, '!=', 'xp,2k', '==', 'xp,2k');
        $this->checkOverlapTrue($oPlugin, '!=', 'xp,2k', '==', 'xp,98,95');
        $this->checkOverlapTrue($oPlugin, '!=', 'xp,2k', '!=', 'xp,98,95');
    }

    function testMAX_checkClient_Os()
    {
        $this->assertTrue(MAX_checkClient_Os('xp,2k', '=~', array('os' => 'xp')));
    }
}

?>
