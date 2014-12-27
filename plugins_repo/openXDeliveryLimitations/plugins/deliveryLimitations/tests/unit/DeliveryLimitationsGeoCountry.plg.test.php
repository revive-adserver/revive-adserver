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

/**
 * A class for testing the Plugins_DeliveryLimitations_Geo_Country class.
 *
 * @package    OpenXPlugin
 * @subpackage TestSuite
 */
class Plugins_TestOfPlugins_DeliveryLimitations_Geo_Country extends UnitTestCase
{
    function test_checkGeoCountry()
    {
        // =~ and !~ - Single country
        $this->assertTrue(MAX_checkGeo_Country('GB',    '=~', array('country_code' => 'GB')));
        $this->assertTrue(MAX_checkGeo_Country('GB',   '!~', array('country_code' => 'US')));

        // =~ and !~ - Multiple country
        $this->assertTrue(MAX_checkGeo_Country('GB,US', '=~', array('country_code' => 'GB')));
        $this->assertTrue(MAX_checkGeo_Country('GB,US', '=~', array('country_code' => 'US')));
        $this->assertTrue(MAX_checkGeo_Country('GB,US', '!~', array('country_code' => 'FR')));
        $this->assertFalse(MAX_checkGeo_Country('GB,US', '!~', array('country_code' => 'US')));
    }
}

?>
