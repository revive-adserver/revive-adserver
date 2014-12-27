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
require_once dirname(dirname(dirname(__FILE__))) . '/Geo/Latlong.delivery.php';


/**
 * A class for testing the Plugins_DeliveryLimitations_Geo_Latlong class.
 *
 * @package    OpenXPlugin
 * @subpackage TestSuite
 */
class Plugins_TestOfPlugins_DeliveryLimitations_Geo_Latlong extends UnitTestCase
{
    function testMAX_checkGeo_Latlong()
    {
         $this->assertTrue(MAX_checkGeo_Latlong(',10.0000,,10.0000', '==', array('latitude' => 5.000, 'longitude' => 5.0000)));
         $this->assertFalse(MAX_checkGeo_Latlong(',10.0000,,10.0000', '!=', array('latitude' => 5.000, 'longitude' => 5.0000)));
    }
}

?>
