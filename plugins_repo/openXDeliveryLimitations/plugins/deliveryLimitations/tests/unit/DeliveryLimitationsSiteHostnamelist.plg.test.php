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
// Use relative path so tests can run from either plugins or plugins_repo
require_once __DIR__ . '/../../Site/Hostnamelist.delivery.php';

Language_Loader::load();

/**
 * A class for testing the Plugins_DeliveryLimitations_Site_Hostnamelist class.
 *
 * @package    OpenXPlugin
 * @subpackage TestSuite
 */
class Plugins_TestOfPlugins_DeliveryLimitations_Site_Hostnamelist extends UnitTestCase
{
    /**
     * Tests the delivery part of this plugin.
     *
     * The test works only if the testing machine has a proper setup!
     */
    public function test_checkSite_Hostnamelist()
    {
        $limitation = serialize(['foo.com' => true]);

        $loc = 'gibberish';
        $this->assertFalse(MAX_checkSite_Hostnamelist($limitation, '=~', ['loc' => $loc]));
        $this->assertFalse(MAX_checkSite_Hostnamelist($limitation, '!~', ['loc' => $loc]));

        $loc = 'https://foo.com/';
        $this->assertTrue(MAX_checkSite_Hostnamelist($limitation, '=~', ['loc' => $loc]));
        $this->assertFalse(MAX_checkSite_Hostnamelist($limitation, '!~', ['loc' => $loc]));

        $limitation = serialize(['example.co.uk' => true]);

        $loc = 'https://www.example.co.uk/';
        $this->assertFalse(MAX_checkSite_Hostnamelist($limitation, '=~', ['loc' => $loc]));

        $loc = 'https://example.co.uk/';
        $this->assertTrue(MAX_checkSite_Hostnamelist($limitation, '=~', ['loc' => $loc]));
    }
}
