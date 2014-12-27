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
require_once dirname(dirname(dirname(__FILE__))) . '/Client/Browser.delivery.php';
require_once dirname(dirname(dirname(dirname(__FILE__)))).'/etc/Client/etc/postscript_install_Client.php';

/**
 * A class for testing the Plugins_DeliveryLimitations_Client_Browser class.
 *
 * @package    OpenXPlugin
 * @subpackage TestSuite
 */
class Plugins_TestOfPlugins_DeliveryLimitations_Client_Browser extends UnitTestCase
{

    function test_postscript_install_Client()
    {
        $oSettings  = new OA_Admin_Settings();
        $oSettings->settingChange('logging','sniff','1');
        $oSettings->writeConfigChange();
        $this->assertTrue($GLOBALS['_MAX']['CONF']['logging']['sniff']);
        $oPostInstall = new postscript_install_Client();
        $oPostInstall->execute();
        $this->assertNull($GLOBALS['_MAX']['CONF']['logging']['sniff']);
        $this->assertTrue($GLOBALS['_MAX']['CONF']['Client']['sniff']);
    }

    function testMAX_checkClient_Browser()
    {
        $GLOBALS['_MAX']['CLIENT']['browser'] = 'FF';
        $this->assertFalse(MAX_checkClient_Browser('LX,LI', '=~'));
        $this->assertTrue(MAX_checkClient_Browser('LX,FF', '=~'));
    }
}
?>
