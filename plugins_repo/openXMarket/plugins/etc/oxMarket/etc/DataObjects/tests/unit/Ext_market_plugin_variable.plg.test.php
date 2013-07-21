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
