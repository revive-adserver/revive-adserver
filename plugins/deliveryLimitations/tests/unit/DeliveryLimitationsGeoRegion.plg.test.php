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
require_once MAX_PATH . '/plugins/deliveryLimitations/Geo/Region.delivery.php';

/**
 * A class for testing the Plugins_DeliveryLimitations_Geo_Region class.
 *
 * @package    OpenXPlugin
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew@m3.net>
 */
class Plugins_TestOfPlugins_DeliveryLimitations_Geo_Region extends Plugins_DeliveryLimitations_TestCase
{

    /**
     * The constructor method.
     */
    function Plugins_TestOfPlugins_DeliveryLimitations_Geo_Region()
    {
        $this->UnitTestCase();
    }

    /**
     * A method to test the _getSqlLimitation() method.
     */
    function test_getSqlLimitation()
    {
        $oPlugin = &MAX_Plugin::factory('deliveryLimitations', 'Geo', 'Region');
        $result = $oPlugin->_getSqlLimitation('=', 'GB|T5');
        $this->assertEqual($result, "(LOWER(country) = ('gb') AND LOWER(geo_region) IN ('t5'))");
        $result = $oPlugin->_getSqlLimitation('!=', 'GB|T5,T6');
        $this->assertEqual($result, "(LOWER(country) = ('gb') AND LOWER(geo_region) IN ('t5','t6'))");
    }

    function testInit()
    {
        $oPlugin = &MAX_Plugin::factory('deliveryLimitations', 'Geo', 'Region');
        $oPlugin->init(array('data' => 'FR|C1,97,98,99,A1,A2,A3,A4,A5,A6,A7,A8,A9,B1,B2,B3,B4,B5,B6,B7,B8,B9', 'comparison' => '=='));
    }

    function testCompile()
    {
        $current_quotes_runtime = get_magic_quotes_runtime();
        set_magic_quotes_runtime(1);

        $oPlugin = &MAX_Plugin::factory('deliveryLimitations', 'Geo', 'Region');
        $rawData = 'GB|T5,T7';
        $oPlugin->init(array('data' => $rawData, 'comparison' => '=='));
        $this->assertEqual('MAX_checkGeo_Region(\'gb|t5,t7\', \'==\')', $oPlugin->compile());
        $this->assertEqual($rawData, $oPlugin->getData());
        $oPlugin->init(array('data' => array('GB', 'T5', 'T7'), 'comparison' => '=='));
        $this->assertEqual('MAX_checkGeo_Region(\'gb|t5,t7\', \'==\')', $oPlugin->compile());

        set_magic_quotes_runtime($current_quotes_runtime);
    }

    function testOverlap()
    {
        $oPlugin = &MAX_Plugin::factory('deliveryLimitations', 'Geo', 'Region');
        $oPlugin->init(array()); // Assume it is called in the production after talking to Andrew

        $this->checkOverlapFalse($oPlugin, '=~', 'GB|T1', '==', 'PL|T1');
        $this->checkOverlapFalse($oPlugin, '=~', 'GB|T8', '==', 'GB|T9,T10');
        $this->checkOverlapTrue($oPlugin, '=~', 'GB|T1,T2', '==', 'GB|T1');
        $this->checkOverlapTrue($oPlugin, '=~', 'GB| T1,   t2', '==', 'GB|t5, t1  ');
        $this->checkOverlapFalse($oPlugin, '=~', 'GB|', '==', 'GB|t12  ');
    }

    function testMAX_checkGeo_Region()
    {
        $this->assertTrue(MAX_checkGeo_Region('gb|t7,t8,t9',
            'bla', array('country_code' => 'GB', 'region' => 'T8')));
        $this->assertFalse(MAX_checkGeo_Region('gb|t7,t9',
            'bla', array('country_code' => 'GB', 'region' => 'T8')));
        $this->assertFalse(MAX_checkGeo_Region(
            'gb|t7,t9', 'bla', array('region' => 'T9')));
    }

}

?>
