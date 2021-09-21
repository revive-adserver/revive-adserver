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
require_once dirname(dirname(dirname(__FILE__))) . '/Geo/Country.delivery.php';

Language_Loader::load();

/**
 * A class for testing the Plugins_DeliveryLimitations_Geo_Country class.
 *
 * @package    OpenXPlugin
 * @subpackage TestSuite
 */
class Plugins_TestOfPlugins_DeliveryLimitations_Geo_Country extends UnitTestCase
{
    public function test_checkGeoCountry()
    {
        // =~ and !~ - Single country
        $this->assertTrue(MAX_checkGeo_Country('GB', '=~', ['country' => 'GB']));
        $this->assertTrue(MAX_checkGeo_Country('GB', '!~', ['country' => 'US']));

        // =~ and !~ - Multiple country
        $this->assertTrue(MAX_checkGeo_Country('GB,US', '=~', ['country' => 'GB']));
        $this->assertTrue(MAX_checkGeo_Country('GB,US', '=~', ['country' => 'US']));
        $this->assertTrue(MAX_checkGeo_Country('GB,US', '!~', ['country' => 'FR']));
        $this->assertFalse(MAX_checkGeo_Country('GB,US', '!~', ['country' => 'US']));
    }
}
