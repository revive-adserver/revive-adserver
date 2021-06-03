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
require_once dirname(dirname(dirname(__FILE__))) . '/Client/Domain.delivery.php';

Language_Loader::load();

/**
 * A class for testing the Plugins_DeliveryLimitations_Client_Domain class.
 *
 * @package    OpenXPlugin
 * @subpackage TestSuite
 */
class Plugins_TestOfPlugins_DeliveryLimitations_Client_Domain extends UnitTestCase
{
    /**
     * Tests the delivery part of this plugin.
     *
     * The test works only if the testing machine has a proper setup!
     */
    function test_checkClientDomain()
    {
        $_SERVER['REMOTE_HOST'] = 'localhost.localdomain';
        $this->assertTrue(MAX_checkClient_Domain('localdomain', '==', array('ip' => '127.0.0.1')));
        $_SERVER['REMOTE_HOST'] = 'web.unanimis.co.uk';
        $this->assertTrue(MAX_checkClient_Domain('unanimis.co.uk', '==', array('ip' => '10.0.0.8')));
        $this->assertFalse(MAX_checkClient_Domain('unanimis.co.uk', '!=', array('ip' => '10.0.0.8')));
        $this->assertTrue(MAX_checkClient_Domain('.*unani.*', '=x', array('ip' => '10.0.0.8')));
    }
}

?>
