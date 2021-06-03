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
require_once dirname(dirname(dirname(__FILE__))) . '/Geo/Organisation.delivery.php';

Language_Loader::load();

/**
 * A class for testing the Plugins_DeliveryLimitations_Geo_Organisation class.
 *
 * @package    OpenXPlugin
 * @subpackage TestSuite
 */
class Plugins_TestOfPlugins_DeliveryLimitations_Geo_Organisation extends UnitTestCase
{
    function testCheckGeoOrganisation()
    {
        // == and !=
        $this->assertTrue(MAX_checkGeo_Organisation('BT',  '==', array('organisation' => 'BT')));
        $this->assertFalse(MAX_checkGeo_Organisation('BT', '!=', array('organisation' => 'BT')));
        $this->assertFalse(MAX_checkGeo_Organisation('BT', '==', array('organisation' => 'TB')));
        $this->assertTrue(MAX_checkGeo_Organisation('BT',  '!=', array('organisation' => 'TB')));

        // =~ and !~
        $this->assertTrue(MAX_checkGeo_Organisation('BT', '=~', array('organisation' => 'aaaBTbbb')));
        $this->assertFalse(MAX_checkGeo_Organisation('BT', '!~', array('organisation' => 'aaaBTbbb')));
        $this->assertFalse(MAX_checkGeo_Organisation('BT', '=~', array('organisation' => 'zzzTBxxx')));
        $this->assertTrue(MAX_checkGeo_Organisation('BT', '!~', array('organisation' => 'zzzTBxxx')));

        // =x and !x
        $this->assertTrue(MAX_checkGeo_Organisation('5[0-9]2', '=x', array('organisation' => '502')));
        $this->assertFalse(MAX_checkGeo_Organisation('5[0-9]2', '!x', array('organisation' => '502')));
        $this->assertFalse(MAX_checkGeo_Organisation('5[1-9]2', '=x', array('organisation' => '501')));
        $this->assertTrue(MAX_checkGeo_Organisation('5[1-9]2', '!x', array('organisation' => '501')));
    }
}

?>
