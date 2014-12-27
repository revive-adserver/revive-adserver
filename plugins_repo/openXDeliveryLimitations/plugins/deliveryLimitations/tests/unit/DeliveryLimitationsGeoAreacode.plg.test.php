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
require_once dirname(dirname(dirname(__FILE__))) . '/Geo/Areacode.delivery.php';

/**
 * A class for testing the Plugins_DeliveryLimitations_Geo_Areacode class.
 *
 * @package    OpenXPlugin
 * @subpackage TestSuite
 */
class Plugins_TestOfPlugins_DeliveryLimitations_Geo_Areacode extends UnitTestCase
{
    /**
     * This test tests the checkGeo areacode function, see here for the codes:
     * @link http://www.maxmind.com/app/metro_code
     *
     */
    function testMAX_checkGeoAreacode()
    {
        // == and !=
        $this->assertTrue(MAX_checkGeo_Areacode('502', '==', array('area_code' => '502')));
        $this->assertFalse(MAX_checkGeo_Areacode('502', '!=', array('area_code' => '502')));
        $this->assertFalse(MAX_checkGeo_Areacode('502', '==', array('area_code' => '501')));
        $this->assertTrue(MAX_checkGeo_Areacode('502', '!=', array('area_code' => '501')));

        // =~ and !~
        $this->assertTrue(MAX_checkGeo_Areacode('02', '=~', array('area_code' => '502')));
        $this->assertFalse(MAX_checkGeo_Areacode('02', '!~', array('area_code' => '502')));
        $this->assertFalse(MAX_checkGeo_Areacode('02', '=~', array('area_code' => '501')));
        $this->assertTrue(MAX_checkGeo_Areacode('02', '!~', array('area_code' => '501')));

        // =x and !x
        $this->assertTrue(MAX_checkGeo_Areacode('5[0-9]2', '=x', array('area_code' => '502')));
        $this->assertFalse(MAX_checkGeo_Areacode('5[0-9]2', '!x', array('area_code' => '502')));
        $this->assertFalse(MAX_checkGeo_Areacode('5[1-9]2', '=x', array('area_code' => '501')));
        $this->assertTrue(MAX_checkGeo_Areacode('5[1-9]2', '!x', array('area_code' => '501')));
    }
}

?>
