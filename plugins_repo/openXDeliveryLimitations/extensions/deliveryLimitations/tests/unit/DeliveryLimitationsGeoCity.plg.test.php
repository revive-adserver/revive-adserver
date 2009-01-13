<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
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

require_once LIB_PATH . '/Plugin/Component.php';
// Using multi-dirname so that the tests can run from either plugins or plugins_repo
require_once dirname(dirname(dirname(__FILE__))) . '/Geo/City.delivery.php';

/**
 * A class for testing the Plugins_DeliveryLimitations_Geo_City class.
 *
 * @package    OpenXPlugin
 * @subpackage TestSuite
 * @author     Andrew Hill <andrew@m3.net>
 */
class Plugins_TestOfPlugins_DeliveryLimitations_Geo_City extends UnitTestCase
{
    function setUp()
    {
        $aConf = & $GLOBALS['_MAX']['CONF'];
        $aConf['pluginGroupComponents']['Geo'] = 1;
        $aConf['pluginPaths']['extensions'] = '/plugins_repo/openXDeliveryLimitations/extensions/';
    }

    function tearDown()
    {
        TestEnv::restoreConfig();
    }

    function testCompile()
    {
        $current_quotes_runtime = get_magic_quotes_runtime();
        set_magic_quotes_runtime(1);

        $oPlugin = &OX_Component::factory('deliveryLimitations', 'Geo', 'City');
        $rawData = 'GB|London, Manchester';
        $oPlugin->init(array('data' => $rawData, 'comparison' => '=='));
        $this->assertEqual('MAX_checkGeo_City(\'gb|london,manchester\', \'==\')', $oPlugin->compile());
        $this->assertEqual($rawData, $oPlugin->getData());
        $oPlugin->init(array('data' => array('GB', 'London, Manchester'), 'comparison' => '=='));
        $this->assertEqual('MAX_checkGeo_City(\'gb|london,manchester\', \'==\')', $oPlugin->compile());

        set_magic_quotes_runtime($current_quotes_runtime);
    }

    function testMAX_checkGeo_City()
    {
        $this->assertTrue(MAX_checkGeo_City('PL|Poznan,Wroclaw', '=~', array('country_code' => 'PL', 'city' => 'Poznan')));
        $this->assertTrue(MAX_checkGeo_City('pl|poznan,wroclaw', '=~', array('country_code' => 'PL', 'city' => 'Poznan')));
        $this->assertFalse(MAX_checkGeo_City('pl|poznan,wroclaw', '=~', array('country_code' => 'PL', 'city' => 'Warszawa')));
        $this->assertFalse(MAX_checkGeo_City('pl|poznan,wroclaw,szczecinek', '=~', array('country_code' => 'PL', 'city' => 'Szczecin')));
        $this->assertFalse(MAX_checkGeo_City('pl|', '=~', array('country_code' => 'PL', 'city' => 'Szczecin')));

        // Since we now support !city matching, these need testing, trying inverting the tests
        $this->assertFalse(MAX_checkGeo_City('PL|Poznan,Wroclaw', '!~', array('country_code' => 'PL', 'city' => 'Poznan')));
        $this->assertFalse(MAX_checkGeo_City('pl|poznan,wroclaw', '!~', array('country_code' => 'PL', 'city' => 'Poznan')));
        $this->assertTrue(MAX_checkGeo_City('pl|poznan,wroclaw', '!~', array('country_code' => 'PL', 'city' => 'Warszawa')));
        $this->assertTrue(MAX_checkGeo_City('pl|poznan,wroclaw,szczecinek', '!~', array('country_code' => 'PL', 'city' => 'Szczecin')));
        $this->assertTrue(MAX_checkGeo_City('pl|', '!~', array('country_code' => 'PL', 'city' => 'Szczecin')));
}

    function testGetName()
    {
        $oPlugin = &OX_Component::factory('deliveryLimitations', 'Geo', 'City');
        $oPlugin->init(array()); // Assume it is called in the production after talking to Andrew
        $this->assertEqual('Country / City', $oPlugin->displayName);
    }
}

?>
