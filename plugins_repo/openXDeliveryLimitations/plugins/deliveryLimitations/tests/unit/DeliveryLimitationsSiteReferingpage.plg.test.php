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
require_once dirname(dirname(dirname(__FILE__))) . '/Site/Referingpage.delivery.php';

/**
 * A class for testing the Plugins_DeliveryLimitations_Site_Referingpage class.
 *
 * @package    OpenXPlugin
 * @subpackage TestSuite
 */
class Plugins_TestOfPlugins_DeliveryLimitations_Site_Referingpage extends UnitTestCase
{
    function testCheckSiteReferingpage()
    {
        // == and !=
        $this->assertTrue(MAX_checkSite_Referingpage('http://www.openx.org/',  '==', array('referer' => 'http://www.openx.org/')));
        $this->assertFalse(MAX_checkSite_Referingpage('http://www.openx.org/', '!=', array('referer' => 'http://www.openx.org/')));
        $this->assertFalse(MAX_checkSite_Referingpage('http://www.openx.org/', '==', array('referer' => 'http://www.example.com/')));
        $this->assertTrue(MAX_checkSite_Referingpage('http://www.openx.org/',  '!=', array('referer' => 'http://www.example.com/')));

        // =~ and !~
        $this->assertTrue(MAX_checkSite_Referingpage('openx.org', '=~', array('referer' => 'http://www.openx.org/')));
        $this->assertFalse(MAX_checkSite_Referingpage('openx.org', '!~', array('referer' => 'http://www.openx.org/')));
        $this->assertFalse(MAX_checkSite_Referingpage('openx.org', '=~', array('referer' => 'http://www.example.com/')));
        $this->assertTrue(MAX_checkSite_Referingpage('openx.org', '!~', array('referer' => 'http://www.example.com/')));

        // =x and !x
        $this->assertTrue(MAX_checkSite_Referingpage('.*(openx|example)\.(org|com).*', '=x', array('referer' => 'http://www.openx.org/')));
        $this->assertFalse(MAX_checkSite_Referingpage('.*(openx|example)\.(org|com).*', '!x', array('referer' => 'http://www.openx.org/')));
        $this->assertFalse(MAX_checkSite_Referingpage('.*(openx|example)\.(org|com).*', '=x', array('referer' => 'http://www.openx.net/')));
        $this->assertTrue(MAX_checkSite_Referingpage('.*(openx|example)\.(org|com).*', '!x', array('referer' => 'http://www.openx.net/')));
    }
}

?>
