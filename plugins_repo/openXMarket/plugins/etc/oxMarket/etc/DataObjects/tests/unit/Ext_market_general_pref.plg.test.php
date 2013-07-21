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
