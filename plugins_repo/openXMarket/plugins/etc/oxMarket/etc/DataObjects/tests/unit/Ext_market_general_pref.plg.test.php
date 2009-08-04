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
class Plugins_TestOfPDataObjects_Ext_market_general_pref extends UnitTestCase
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
    
    function testFindByAccountIdAndName()
    {
        $name = 'name';
        $accountId = 123;
        $value = 'test value';
        
        // try to find not existing preference 
        $doGeneralPref = OA_Dal::factoryDO('ext_market_general_pref');
        
        $result = $doGeneralPref->findByAccountIdAndName($accountId, $name);

        $this->assertEqual($result, 0);
        $this->assertEqual($doGeneralPref->account_id, $accountId);
        $this->assertEqual($doGeneralPref->name, $name);
        $this->assertNull($doGeneralPref->value);
        
        // find existing preference
        $doGeneralPref->value = $value;
        $doGeneralPref->insert();
        
        $doGeneralPref = OA_Dal::factoryDO('ext_market_general_pref');
        $result = $doGeneralPref->findByAccountIdAndName($accountId, $name);
        $this->assertEqual($result, 1);
        $this->assertEqual($doGeneralPref->account_id, $accountId);
        $this->assertEqual($doGeneralPref->name, $name);
        $this->assertEqual($doGeneralPref->value, $value);
    }
    
    function testFindAndGetValue()
    {
        $name = 'name';
        $accountId = 123;
        $value = 'test value';
        
        // try to find not existing preference 
        $doGeneralPref = OA_Dal::factoryDO('ext_market_general_pref');
        
        $result = $doGeneralPref->findAndGetValue($accountId, $name);
        $this->assertNull($result);
        
        // add preference
        $doGeneralPref = OA_Dal::factoryDO('ext_market_general_pref');
        $doGeneralPref->account_id = $accountId;
        $doGeneralPref->name = $name;
        $doGeneralPref->value = $value;
        $doGeneralPref->insert();

        // try to find existing preference
        $doGeneralPref = OA_Dal::factoryDO('ext_market_general_pref');
        
        $result = $doGeneralPref->findAndGetValue($accountId, $name);
        $this->assertEqual($result, $value);
    }

    function testInsertOrUpdateValue()
    {
        $name = 'name';
        $accountId = 123;
        $value = 'test value';
        $value2 = 'another value';
        $intValue = 1323;
        $boolValue = true;
        
        $doGeneralPrefGet = OA_Dal::factoryDO('ext_market_general_pref');
        $this->assertNull($doGeneralPrefGet->findAndGetValue($accountId, $name));
        
        // Set value
        $doGeneralPref = OA_Dal::factoryDO('ext_market_general_pref');
        $this->assertTrue($doGeneralPref->insertOrUpdateValue($accountId, $name, $value));
        
        $this->assertEqual($doGeneralPrefGet->findAndGetValue($accountId, $name), 
                           $value);
  
        // update value to value2
        $doGeneralPref = OA_Dal::factoryDO('ext_market_general_pref');
        $this->assertTrue($doGeneralPref->insertOrUpdateValue($accountId, $name, $value2));
        
        $this->assertEqual($doGeneralPrefGet->findAndGetValue($accountId, $name), 
                           $value2);
                           
        // update value to intvalue
        $doGeneralPref = OA_Dal::factoryDO('ext_market_general_pref');
        $this->assertTrue($doGeneralPref->insertOrUpdateValue($accountId, $name, $intValue));
        
        $this->assertEqual($doGeneralPrefGet->findAndGetValue($accountId, $name), 
                           $intValue);
                           
        // update value to boolvalue
        $doGeneralPref = OA_Dal::factoryDO('ext_market_general_pref');
        $this->assertTrue($doGeneralPref->insertOrUpdateValue($accountId, $name, $boolValue));
        
        $this->assertEqual($doGeneralPrefGet->findAndGetValue($accountId, $name), 
                           $boolValue);
    }
}

?>
