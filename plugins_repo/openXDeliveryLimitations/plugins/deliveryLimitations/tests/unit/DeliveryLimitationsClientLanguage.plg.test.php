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
require_once dirname(dirname(dirname(__FILE__))) . '/Client/Language.delivery.php';

/**
 * A class for testing the Plugins_DeliveryLimitations_Client_Language class.
 *
 * @package    OpenXPlugin
 * @subpackage TestSuite
 */
class Plugins_TestOfPlugins_DeliveryLimitations_Client_Language extends UnitTestCase
{
    function setUp()
    {
        $this->langSave = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
    }

    function tearDown()
    {
        $_SERVER['HTTP_ACCEPT_LANGUAGE'] = $this->langSave;
    }

    function testMAX_checkClient_Language()
    {
        $this->assertTrue(MAX_checkClient_Language('en', '=~', array('language' => 'en')));
        $this->assertFalse(MAX_checkClient_Language('en', '!~', array('language' => 'en')));
        $this->assertTrue(MAX_checkClient_Language('en,pl,fr,de', '=~', array('language' => 'en')));
        $this->assertTrue(MAX_checkClient_Language('en,pl,fr,de', '=~', array('language' => 'jp,en')));
        $this->assertFalse(MAX_checkClient_Language('en,pl,fr,de', '=~', array('language' => 'jp,en-us')));
        $this->assertTrue(MAX_checkClient_Language('en', '=~', array('language' => 'jp,en')));

        $_SERVER['HTTP_ACCEPT_LANGUAGE'] = 'en-us,en,pl';
        $this->assertFalse(MAX_checkClient_Language('af', '=~'));
        $this->assertTrue(MAX_checkClient_Language('af,pl', '=~'));
    }
}

?>
