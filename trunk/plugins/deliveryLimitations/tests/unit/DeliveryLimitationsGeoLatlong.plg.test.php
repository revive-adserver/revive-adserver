<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
| For contact details, see: http://www.openx.org/                           |
|                                                                           |
| This program is free software; you can redistribute it and/or modify      |
| it under the terms of the GNU General Public License as published by      |
| the Free Software Foundation; either version 2 of the License, or         |
| (at your option) any later version.                                       |
|                                                                           |
| This program is distributed in the hope that it will be useful,           |
| but WITHOUT ANY WARRANTY; without even the implied warranty of            |
| MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
| GNU General Public License for more details.                              |
|                                                                           |
| You should have received a copy of the GNU General Public License         |
| along with this program; if not, write to the Free Software               |
| Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA |
+---------------------------------------------------------------------------+
$Id$
*/

require_once MAX_PATH . '/lib/max/Plugin.php';
require_once MAX_PATH . '/plugins/deliveryLimitations/tests/unit/DeliveryLimitationsTestCase.plg.php';
require_once MAX_PATH . '/plugins/deliveryLimitations/Geo/Latlong.delivery.php';


/**
 * A class for testing the Plugins_DeliveryLimitations_Geo_Latlong class.
 *
 * @package    OpenXPlugin
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew@m3.net>
 */
class Plugins_TestOfPlugins_DeliveryLimitations_Geo_Latlong extends Plugins_DeliveryLimitations_TestCase
{

    /**
     * The constructor method.
     */
    function Plugins_TestOfPlugins_DeliveryLimitations_Geo_Latlong()
    {
        $this->Plugins_DeliveryLimitations_TestCase();
    }

    /**
     * A method to test the _getSqlLimitation() method.
     */
    function test_getSqlLimitation()
    {
        $oPlugin = &MAX_Plugin::factory('deliveryLimitations', 'Geo', 'Latlong');
        $result = $oPlugin->_getSqlLimitation('==', '50.000,51.000,20.000,22.000');
        $this->assertEqual($result, "(geo_latitude >= 50.000 AND geo_latitude <= 51.000 AND geo_longitude >= 20.000 AND geo_longitude <= 22.000)");
        $result = $oPlugin->_getSqlLimitation('!=', '50.000,51.000,20.000,22.000');
        $this->assertEqual($result, "(geo_latitude < 50.000 OR geo_latitude > 51.000 OR geo_longitude < 20.000 OR geo_longitude > 22.000)");
    }

    function testOverlap()
    {
        $oPlugin = &MAX_Plugin::factory('deliveryLimitations', 'Geo', 'Latlong');
        $oPlugin->init(array()); // Assume it is called in the production after talking to Andrew

        $this->checkOverlapFalse($oPlugin,
            '==', '-20.0000,-10.0000,-40.000,-30.0000',
            '==', '10.0000,20.0000,30.0000,40.0000');
        $this->checkOverlapTrue($oPlugin,
            '==', '-20.0000,-10.0000,-40.000,40.0000',
            '==', '-15.0000,-5.0000,30.0000,40.0000');
        $this->checkOverlapFalse($oPlugin,
            '!=', '-20.0000,,-40.000,40.0000',
            '==', '-15.0000,-5.0000,30.0000,40.0000');
        $this->checkOverlapTrue($oPlugin,
            '!=', '-20.0000,,-40.000,',
            '==', ',5.0000,-0.0050,0.0050');
        $this->checkOverlapTrue($oPlugin,
            '==', ',5.0000,-0.0050,0.0050',
            '!=', '-20.0000,,-40.000,');
        $this->checkOverlapTrue($oPlugin,
            '!=', ',5.0000,-0.0050,0.0050',
            '!=', '-20.0000,,-40.000,');
        $this->checkOverlapTrue($oPlugin,
            '!=', '-20.0000,-10.0000,-40.000,-30.0000',
            '!=', '10.0000,20.0000,30.0000,40.0000');
        $this->checkOverlapFalse($oPlugin,
            '!=', '-89.9999,89.9999,-179.9999,179.9999',
            '!=', '10.0000,20.0000,30.0000,40.0000');
        $this->checkOverlapFalse($oPlugin,
            '!=', '-89.9999,89.9999,-179.9999,39.4550',
            '!=', '-89.9999,89.9999,39.4551,179.9999');
        $this->checkOverlapFalse($oPlugin,
            '!=', '-89.9999,89.9999,-179.9999,43.4567',
            '!=', '-89.9999,89.9999,39.4551,179.9999');
        $this->checkOverlapFalse($oPlugin,
            '!=', '-89.9999,9.9998,-179.9999,179.9999',
            '!=', '9.9999,89.9999,-179.9999,179.9999');
    }

    function testMAX_checkGeo_Latlong()
    {
         $this->assertTrue(MAX_checkGeo_Latlong(',10.0000,,10.0000', '==', array('latitude' => 5.000, 'longitude' => 5.0000)));
         $this->assertFalse(MAX_checkGeo_Latlong(',10.0000,,10.0000', '!=', array('latitude' => 5.000, 'longitude' => 5.0000)));
    }

}

?>
