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
require_once MAX_PATH . '/lib/OA/Dal/DataGenerator.php';

/**
 * A class for testing the openXMarket DataObjects
 *
 * @package    OpenXPlugin
 * @subpackage TestSuite
 * @author     Lukasz Wikierski <lukasz.wikierski@openx.org>
 */
class Plugins_TestOfPDataObjects_Ext_market_zone_pref extends UnitTestCase
{
    function setUp()
    {
        $oPkgMgr = new OX_PluginManager();
        TestEnv::uninstallPluginPackage('openXMarket', false);
        TestEnv::installPluginPackage('openXMarket', false);
    }

    function tearDown()
    {
        DataGenerator::cleanUp();
        TestEnv::uninstallPluginPackage('openXMarket', false);
    }

    
    function testUpdateZoneStatus()
    {
        $doZones = OA_Dal::factoryDO('zones');        
        $zoneId = DataGenerator::generateOne($doZones);
        $doZones = OA_Dal::factoryDO('zones');
        $doZones->get($zoneId);
        $doZones->chain = "zoneid:23";
        $doZones->update();
        
        // optin zone
        $optedIn = true;
        $oExt_market_zone_pref = OA_Dal::factoryDO('ext_market_zone_pref');
        $result = $oExt_market_zone_pref->updateZoneStatus($zoneId, $optedIn);
        $this->assertisA($result, 'DataObjects_Ext_market_zone_pref');
        $this->assertEqual($result->is_enabled, 1);
        $this->assertEqual($result->original_chain, 'zoneid:23');
        
        // zone preferences should be created
        $oExt_market_zone_pref = OA_Dal::factoryDO('ext_market_zone_pref'); 
        $oExt_market_zone_pref->get($zoneId);
        $this->assertEqual($oExt_market_zone_pref->is_enabled, 1);
        $this->assertEqual($oExt_market_zone_pref->original_chain, 'zoneid:23');
        
        // zone chaining is cleared 
        $doZones = OA_Dal::factoryDO('zones');
        $doZones->get($zoneId);
        $this->assertEqual($doZones->chain, '');

        // optout zone
        $optedIn = false;
        $oExt_market_zone_pref = OA_Dal::factoryDO('ext_market_zone_pref');
        $result = $oExt_market_zone_pref->updateZoneStatus($zoneId, $optedIn);
        $this->assertisA($result, 'DataObjects_Ext_market_zone_pref');
        $this->assertEqual($result->is_enabled, 0);
        $this->assertEqual($result->original_chain, 'zoneid:23');
        
        // zone preferences should be changed
        $oExt_market_zone_pref = OA_Dal::factoryDO('ext_market_zone_pref'); 
        $oExt_market_zone_pref->get($zoneId);
        $this->assertEqual($oExt_market_zone_pref->is_enabled, 0);
        $this->assertEqual($oExt_market_zone_pref->original_chain, 'zoneid:23');
        
        // zone chaining is restored
        $doZones = OA_Dal::factoryDO('zones');
        $doZones->get($zoneId);
        $this->assertEqual($doZones->chain, 'zoneid:23');
        
        // Test not existing zone
        $optedIn = true;
        $oExt_market_zone_pref = OA_Dal::factoryDO('ext_market_zone_pref');
        $result = $oExt_market_zone_pref->updateZoneStatus($zoneId+2, $optedIn);
        $this->assertFalse($result);
        
        // zone preferences should be created
        $oExt_market_zone_pref = OA_Dal::factoryDO('ext_market_zone_pref'); 
        $this->assertEqual($oExt_market_zone_pref->get($zoneId+2), 0);

        // delete zone pref entry
        $oExt_market_zone_pref = OA_Dal::factoryDO('ext_market_zone_pref'); 
        $oExt_market_zone_pref->get($zoneId);
        $oExt_market_zone_pref->delete();
        
        // try to opt out zone where there was no optin
        $optedIn = false;
        $oExt_market_zone_pref = OA_Dal::factoryDO('ext_market_zone_pref');
        $result = $oExt_market_zone_pref->updateZoneStatus($zoneId, $optedIn);
        $this->assertisA($result, 'DataObjects_Ext_market_zone_pref');
        $this->assertEqual($result->is_enabled, 0);
        $this->assertEqual($result->original_chain, '');
        
        // zone preferences should stored
        $oExt_market_zone_pref = OA_Dal::factoryDO('ext_market_zone_pref'); 
        $oExt_market_zone_pref->get($zoneId);
        $this->assertEqual($oExt_market_zone_pref->is_enabled, 0);
        $this->assertEqual($oExt_market_zone_pref->original_chain, '');
        
        // zone chaining shouldn't be changed
        $doZones = OA_Dal::factoryDO('zones');
        $doZones->get($zoneId);
        $this->assertEqual($doZones->chain, 'zoneid:23');
    }

}

?>
