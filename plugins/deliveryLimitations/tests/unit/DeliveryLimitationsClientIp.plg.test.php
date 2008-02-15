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
require_once MAX_PATH . '/plugins/deliveryLimitations/Client/Ip.delivery.php';

/**
 * A class for testing the Plugins_DeliveryLimitations_Client_Ip class.
 *
 * @package    OpenXPlugin
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew@m3.net>
 * @author     Andrzej Swedrzynski <andrzej.swedrzynski@m3.net>
 */
class Plugins_TestOfPlugins_DeliveryLimitations_Client_Ip
    extends Plugins_DeliveryLimitations_TestCase
{

    /**
     * The constructor method.
     */
    function Plugins_TestOfPlugins_DeliveryLimitations_Client_Ip()
    {
        $this->Plugins_DeliveryLimitations_TestCase();
    }

    /**
     * A method to test the _getSqlLimitation() method.
     */
    function test_getSqlLimitation()
    {
        $oPlugin = &MAX_Plugin::factory('deliveryLimitations', 'Client', 'Ip');
        $result = $oPlugin->_getSqlLimitation('==', '150.254.149.189');
        $this->assertEqual($result, "ip_address = '150.254.149.189'");
        $result = $oPlugin->_getSqlLimitation('==', '150.254.149.*');
        $this->assertEqual($result, "ip_address LIKE '150.254.149.%'");
        $result = $oPlugin->_getSqlLimitation('!=', '150.254.149.189');
        $this->assertEqual($result, "ip_address != '150.254.149.189'");
        $result = $oPlugin->_getSqlLimitation('!=', '150.254.149.*');
        $this->assertEqual($result, "ip_address NOT LIKE '150.254.149.%'");
    }

    function testOverlap()
    {
        $oPlugin = &MAX_Plugin::factory('deliveryLimitations', 'Client', 'Ip');
        $oPlugin->init(array()); // Assume it is called in the production after talking to Andrew

        $this->checkOverlapFalse($oPlugin, '==', '150.254.149.189', '==', '150.254.147.189');
        $this->checkOverlapFalse($oPlugin, '==', '150.254.149.189', '==', '150.254.149.198');
        $this->checkOverlapFalse($oPlugin, '==', '150.254.149.189', '==', '151.254.149.189');
        $this->checkOverlapFalse($oPlugin, '==', '150.254.149.189', '==', '150.250.149.189');
        $this->checkOverlapTrue($oPlugin, '==', '150.254.149.189', '==', '150.254.149.189');
        $this->checkOverlapFalse($oPlugin, '==', '150.254.149.189', '!=', '150.254.149.189');
        $this->checkOverlapTrue($oPlugin, '==', '150.254.149.189', '!=', '150.254.149.190');
        $this->checkOverlapFalse($oPlugin, '==', '150.254.149.189', '==', '150.254.147.*');
        $this->checkOverlapTrue($oPlugin, '==', '150.254.149.189', '==', '150.254.149.*');
        $this->checkOverlapTrue($oPlugin, '==', '150.254.149.*', '==', '150.254.149.*');
        $this->checkOverlapFalse($oPlugin, '==', '150.254.148.*', '==', '150.254.149.*');
        $this->checkOverlapFalse($oPlugin, '==', '150.254.149.189', '!=', '150.254.149.*');
        $this->checkOverlapTrue($oPlugin, '==', '150.254.148.189', '!=', '150.254.149.*');
        $this->checkOverlapTrue($oPlugin, '==', '150.254.148.*', '!=', '150.254.149.*');
        $this->checkOverlapFalse($oPlugin, '==', '150.254.149.*', '!=', '150.254.149.*');
        $this->checkOverlapTrue($oPlugin, '!=', '150.254.149.189', '!=', '150.254.149.189');
        $this->checkOverlapTrue($oPlugin, '!=', '150.254.149.*', '!=', '150.254.149.189');
        $this->checkOverlapTrue($oPlugin, '!=', '150.254.148.*', '!=', '150.254.149.189');
        $this->checkOverlapTrue($oPlugin, '!=', '150.254.148.*', '!=', '150.254.148.*');
        $this->checkOverlapTrue($oPlugin, '!=', '150.254.148.*', '!=', '150.254.149.*');
    }

    function testMAX_checkClient_Ip()
    {
        $_SERVER['REMOTE_ADDR'] = '150.254.149.189';
        $this->assertTrue(MAX_checkClient_Ip('150.254.149.189', '=='));
        $this->assertFalse(MAX_checkClient_Ip('150.254.149.190', '=='));
        $this->assertTrue(MAX_checkClient_Ip('150.254.149.189', '=='));
        $this->assertTrue(MAX_checkClient_Ip('150.254.149.190', '!='));
        $this->assertTrue(MAX_checkClient_Ip('150.254.149.*', '=='));
        $this->assertFalse(MAX_checkClient_Ip('150.254.148.*', '=='));
        $this->assertFalse(MAX_checkClient_Ip('150.254.149.*', '!='));
        $this->assertTrue(MAX_checkClient_Ip('150.254.148.*', '!='));
    }
}

?>
