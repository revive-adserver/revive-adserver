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

require_once MAX_PATH . '/lib/max/Plugin.php';
// Using multi-dirname so that the tests can run from either plugins or plugins_repo
require_once dirname(dirname(dirname(__FILE__))) . '/Client/Ip.delivery.php';

/**
 * A class for testing the Plugins_DeliveryLimitations_Client_Ip class.
 *
 * @package    OpenXPlugin
 * @subpackage TestSuite
 */
class Plugins_TestOfPlugins_DeliveryLimitations_Client_Ip extends UnitTestCase
{
    function testMAX_checkClient_Ip()
    {
        $_SERVER['REMOTE_ADDR'] = '150.254.149.189';

        // Test sta
        $this->assertTrue(MAX_checkClient_Ip('150.254.149.189', '=='));
        $this->assertFalse(MAX_checkClient_Ip('150.254.149.190', '=='));
        $this->assertTrue(MAX_checkClient_Ip('150.254.149.189', '=='));
        $this->assertTrue(MAX_checkClient_Ip('150.254.149.190', '!='));
        $this->assertTrue(MAX_checkClient_Ip('150.254.149.*', '=='));
        $this->assertFalse(MAX_checkClient_Ip('150.254.148.*', '=='));
        $this->assertFalse(MAX_checkClient_Ip('150.254.149.*', '!='));
        $this->assertTrue(MAX_checkClient_Ip('150.254.148.*', '!='));

        // Test netmasks
        $this->assertTrue(MAX_checkClient_Ip('150.254.149.189/255.255.255.255', '=='));
        $this->assertFalse(MAX_checkClient_Ip('150.254.149.190/255.255.255.255', '=='));
        $this->assertTrue(MAX_checkClient_Ip('150.254.149.0/255.255.255.0', '=='));
        $this->assertFalse(MAX_checkClient_Ip('150.254.149.0/255.255.255.0', '!='));
        $this->assertTrue(MAX_checkClient_Ip('150.254.0.0/255.255.0.0', '=='));
        $this->assertFalse(MAX_checkClient_Ip('150.253.0.0/255.255.0.0', '=='));
        $this->assertFalse(MAX_checkClient_Ip('150.254.0.0/255.255.0.0', '!='));
        $this->assertTrue(MAX_checkClient_Ip('150.253.0.0/255.255.0.0', '!='));
    }
}

?>
