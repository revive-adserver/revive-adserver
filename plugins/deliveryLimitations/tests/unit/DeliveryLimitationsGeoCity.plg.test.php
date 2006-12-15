<?php

/*
+---------------------------------------------------------------------------+
| Max Media Manager v0.3                                                    |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2006 m3 Media Services Limited                         |
| For contact details, see: http://www.m3.net/                              |
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
$Id: GeoIP.plg.test.php 4405 2006-03-10 10:25:58Z andrew@m3.net $
*/

require_once MAX_PATH . '/lib/max/Plugin.php';
require_once MAX_PATH . '/plugins/deliveryLimitations/tests/unit/DeliveryLimitationsTestCase.plg.php';
require_once MAX_PATH . '/plugins/deliveryLimitations/Geo/City.delivery.php';

/**
 * A class for testing the Plugins_DeliveryLimitations_Geo_City class.
 *
 * @package    MaxPlugin
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew@m3.net>
 */
class Plugins_TestOfPlugins_DeliveryLimitations_Geo_City extends Plugins_DeliveryLimitations_TestCase
{

    /**
     * The constructor method.
     */
    function Plugins_TestOfPlugins_DeliveryLimitations_Geo_City()
    {
        $this->UnitTestCase();
    }

    /**
     * A method to test the _getSqlLimitation() method.
     */
    function test_getSqlLimitation()
    {
        $oPlugin = &MAX_Plugin::factory('deliveryLimitations', 'Geo', 'City');
        $result = $oPlugin->_getSqlLimitation('=~', 'GB|London');
        $this->assertEqual($result, "(LOWER(country) = ('gb') AND LOWER(geo_city) IN ('london'))");
        $result = $oPlugin->_getSqlLimitation('=~', 'GB|London,Manchester');
        $this->assertEqual($result, "(LOWER(country) = ('gb') AND LOWER(geo_city) IN ('london','manchester'))");
    }

    function testCompile()
    {
        set_magic_quotes_runtime(1);
        $oPlugin = &MAX_Plugin::factory('deliveryLimitations', 'Geo', 'City');

        $rawData = 'GB|London, Manchester';
        $oPlugin->init(array('data' => $rawData, 'comparison' => '=='));
        $this->assertEqual('MAX_checkGeo_City(\'gb|london,manchester\', \'==\')', $oPlugin->compile());
        $this->assertEqual($rawData, $oPlugin->getData());

        $oPlugin->init(array('data' => array('GB', 'London, Manchester'), 'comparison' => '=='));
        $this->assertEqual('MAX_checkGeo_City(\'gb|london,manchester\', \'==\')', $oPlugin->compile());
    }

    function testOverlap()
    {
        $oPlugin = &MAX_Plugin::factory('deliveryLimitations', 'Geo', 'City');
        $oPlugin->init(array()); // Assume it is called in the production after talking to Andrew

        $this->checkOverlapFalse($oPlugin, '=~', 'GB|London', '==', 'PL|London');
        $this->checkOverlapFalse($oPlugin, '=~', 'GB|London', '==', 'GB|Manchester, Newcastle');
        $this->checkOverlapTrue($oPlugin, '=~', 'GB|London, Dover', '==', 'GB|Manchester, London');
        $this->checkOverlapTrue($oPlugin, '=~', 'GB|  London, Dover', '==', 'GB|Manchester, London  ');
        $this->checkOverlapTrue($oPlugin, '=~', 'GB|  London, Dover', '==', 'GB|Manchester, loNdon  ');
    }

    function testMAX_checkGeo_City()
    {
        $this->assertTrue(MAX_checkGeo_City('PL|Poznan,Wroclaw',
            'bla', array('country_code' => 'PL', 'city' => 'Poznan')));
        $this->assertTrue(MAX_checkGeo_City('pl|poznan,wroclaw',
            'bla', array('country_code' => 'PL', 'city' => 'Poznan')));
        $this->assertFalse(MAX_checkGeo_City('pl|poznan,wroclaw',
            'bla', array('country_code' => 'PL', 'city' => 'Warszawa')));
        $this->assertFalse(MAX_checkGeo_City('pl|poznan,wroclaw,szczecinek',
            'bla', array('country_code' => 'PL', 'city' => 'Szczecin')));
        $this->assertFalse(MAX_checkGeo_City('pl|',
            'bla', array('country_code' => 'PL', 'city' => 'Szczecin')));
    }
    
    
    function testGetName()
    {
        $oPlugin = &MAX_Plugin::factory('deliveryLimitations', 'Geo', 'City');
        $oPlugin->init(array()); // Assume it is called in the production after talking to Andrew
        $this->assertEqual('Country / City', $oPlugin->displayName);
    }
}

?>
