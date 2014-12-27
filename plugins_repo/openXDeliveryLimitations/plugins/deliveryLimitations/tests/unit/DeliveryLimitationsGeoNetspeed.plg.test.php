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
require_once dirname(dirname(dirname(__FILE__))) . '/Geo/Netspeed.delivery.php';

/**
 * A class for testing the Plugins_DeliveryLimitations_Geo_Netspeed class.
 *
 * @package    OpenXPlugin
 * @subpackage TestSuite
 */
class Plugins_TestOfPlugins_DeliveryLimitations_Geo_Netspeed extends UnitTestCase
{
    function testCheckGeoNetspeed()
    {
        // =~ and !~ - Single country
        $this->assertTrue(MAX_checkGeo_Netspeed('dialup',    '=~', array('netspeed' => 'dialup')));
        $this->assertTrue(MAX_checkGeo_Netspeed('dialup',    '!~', array('netspeed' => 'cabledsl')));

        // =~ and !~ - Multiple country
        $this->assertTrue(MAX_checkGeo_Netspeed('cabledsl,corporate',  '=~', array('netspeed' => 'cabledsl')));
        $this->assertTrue(MAX_checkGeo_Netspeed('cabledsl,corporate',  '=~', array('netspeed' => 'corporate')));
        $this->assertTrue(MAX_checkGeo_Netspeed('cabledsl,corporate',  '!~', array('netspeed' => 'unknown')));
        $this->assertFalse(MAX_checkGeo_Netspeed('cabledsl,corporate', '!~', array('netspeed' => 'cabledsl')));
    }
}

?>
