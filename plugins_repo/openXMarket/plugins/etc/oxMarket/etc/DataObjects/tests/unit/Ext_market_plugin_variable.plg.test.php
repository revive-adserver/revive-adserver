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
class Plugins_TestOfPDataObjects_Ext_market_plugin_variable extends UnitTestCase
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

    
    function testFindByUserIdAndName()
    {
        $name = 'name';
        $userId = 123;
        $value = 'test value';
        
        // try to find not existing preference 
        $oPlugVar = OA_Dal::factoryDO('ext_market_plugin_variable');
        
        $result = $oPlugVar->findByUserIdAndName($userId, $name);

        $this->assertEqual($result, 0);
        $this->assertEqual($oPlugVar->user_id, $userId);
        $this->assertEqual($oPlugVar->name, $name);
        $this->assertNull($oPlugVar->value);
        
        // find existing preference
        $oPlugVar->value = $value;
        $oPlugVar->insert();
        
        $oPlugVar = OA_Dal::factoryDO('ext_market_plugin_variable');
        $result = $oPlugVar->findByUserIdAndName($userId, $name);
        $this->assertEqual($result, 1);
        $this->assertEqual($oPlugVar->user_id, $userId);
        $this->assertEqual($oPlugVar->name, $name);
        $this->assertEqual($oPlugVar->value, $value);
    }
    
    function testFindAndGetValue()
    {
        $name = 'name';
        $userId = 123;
        $value = 'test value';
        
        // try to find not existing preference 
        $oPlugVar = OA_Dal::factoryDO('ext_market_plugin_variable');
        
        $result = $oPlugVar->findAndGetValue($userId, $name);
        $this->assertNull($result);
        
        // add preference
        $oPlugVar = OA_Dal::factoryDO('ext_market_plugin_variable');
        $oPlugVar->user_id = $userId;
        $oPlugVar->name = $name;
        $oPlugVar->value = $value;
        $oPlugVar->insert();

        // try to find existing preference
        $oPlugVar = OA_Dal::factoryDO('ext_market_plugin_variable');
        
        $result = $oPlugVar->findAndGetValue($userId, $name);
        $this->assertEqual($result, $value);
    }

    function testInsertOrUpdateValue()
    {
        $name = 'name';
        $userId = 123;
        $value = 'test value';
        $value2 = 'another value';
        $intValue = 1323;
        $boolValue = true;
        
        $oPlugVar = OA_Dal::factoryDO('ext_market_plugin_variable');
        $this->assertNull($oPlugVar->findAndGetValue($userId, $name));
        
        // Set value
        $oPlugVar = OA_Dal::factoryDO('ext_market_plugin_variable');
        $this->assertTrue($oPlugVar->insertOrUpdateValue($userId, $name, $value));
        
        $this->assertEqual($oPlugVar->findAndGetValue($userId, $name), 
                           $value);
  
        // update value to value2
        $oPlugVar = OA_Dal::factoryDO('ext_market_plugin_variable');
        $this->assertTrue($oPlugVar->insertOrUpdateValue($userId, $name, $value2));
        
        $this->assertEqual($oPlugVar->findAndGetValue($userId, $name), 
                           $value2);
                           
        // update value to intvalue
        $oPlugVar = OA_Dal::factoryDO('ext_market_plugin_variable');
        $this->assertTrue($oPlugVar->insertOrUpdateValue($userId, $name, $intValue));
        
        $this->assertEqual($oPlugVar->findAndGetValue($userId, $name), 
                           $intValue);
                           
        // update value to boolvalue
        $oPlugVar = OA_Dal::factoryDO('ext_market_plugin_variable');
        $this->assertTrue($oPlugVar->insertOrUpdateValue($userId, $name, $boolValue));
        
        $this->assertEqual($oPlugVar->findAndGetValue($userId, $name), 
                           $boolValue);
    }

}

?>
