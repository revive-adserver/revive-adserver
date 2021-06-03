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
require_once dirname(dirname(dirname(__FILE__))) . '/Geo/Postalcode.delivery.php';

Language_Loader::load();

/**
 * A class for testing the Plugins_DeliveryLimitations_Geo_Postalcode class.
 *
 * @package    OpenXPlugin
 * @subpackage TestSuite
 */
class Plugins_TestOfPlugins_DeliveryLimitations_Geo_Postalcode extends UnitTestCase
{
    function testCheckGeoPostalcode()
    {
        // == and !=
        $this->assertTrue(MAX_checkGeo_Postalcode('502', '==', array('postal_code' => '502')));
        $this->assertFalse(MAX_checkGeo_Postalcode('502', '!=', array('postal_code' => '502')));
        $this->assertFalse(MAX_checkGeo_Postalcode('502', '==', array('postal_code' => '501')));
        $this->assertTrue(MAX_checkGeo_Postalcode('502', '!=', array('postal_code' => '501')));

        // =~ and !~
        $this->assertTrue(MAX_checkGeo_Postalcode('02', '=~', array('postal_code' => '502')));
        $this->assertFalse(MAX_checkGeo_Postalcode('02', '!~', array('postal_code' => '502')));
        $this->assertFalse(MAX_checkGeo_Postalcode('02', '=~', array('postal_code' => '501')));
        $this->assertTrue(MAX_checkGeo_Postalcode('02', '!~', array('postal_code' => '501')));

        // =x and !x
        $this->assertTrue(MAX_checkGeo_Postalcode('5[0-9]2', '=x', array('postal_code' => '502')));
        $this->assertFalse(MAX_checkGeo_Postalcode('5[0-9]2', '!x', array('postal_code' => '502')));
        $this->assertFalse(MAX_checkGeo_Postalcode('5[1-9]2', '=x', array('postal_code' => '501')));
        $this->assertTrue(MAX_checkGeo_Postalcode('5[1-9]2', '!x', array('postal_code' => '501')));
    }
}

?>
