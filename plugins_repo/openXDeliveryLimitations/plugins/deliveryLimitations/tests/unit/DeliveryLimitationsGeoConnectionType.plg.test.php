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
require_once dirname(dirname(dirname(__FILE__))) . '/Geo/ConnectionType.delivery.php';

Language_Loader::load();

/**
 * A class for testing the Plugins_DeliveryLimitations_Geo_ConnectionType class.
 *
 * @package    OpenXPlugin
 * @subpackage TestSuite
 */
class Plugins_TestOfPlugins_DeliveryLimitations_Geo_ConnectionType extends UnitTestCase
{
    function testCheckGeoConnectionType()
    {
        // =~ and !~ - Single country
        $this->assertTrue(MAX_checkGeo_ConnectionType('dialup',    '=~', array('connection_type' => 'dialup')));
        $this->assertTrue(MAX_checkGeo_ConnectionType('dialup',    '!~', array('connection_type' => 'cabledsl')));

        // =~ and !~ - Multiple country
        $this->assertTrue(MAX_checkGeo_ConnectionType('cabledsl,corporate',  '=~', array('connection_type' => 'cabledsl')));
        $this->assertTrue(MAX_checkGeo_ConnectionType('cabledsl,corporate',  '=~', array('connection_type' => 'corporate')));
        $this->assertTrue(MAX_checkGeo_ConnectionType('cabledsl,corporate',  '!~', array('connection_type' => 'unknown')));
        $this->assertFalse(MAX_checkGeo_ConnectionType('cabledsl,corporate', '!~', array('connection_type' => 'cabledsl')));
    }
}

?>
