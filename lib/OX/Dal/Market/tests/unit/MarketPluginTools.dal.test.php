<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                             |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                            |
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
$Id: MarketPluginTools.dal.test.php 43253 2009-09-16 09:37:45Z lukasz.wikierski $
*/
require_once MAX_PATH . '/lib/OX/Dal/Market/MarketPluginTools.php';
require_once MAX_PATH . '/lib/OA/Dal/DataGenerator.php';

/**
 * A class for testing the Market Plugin Tools
 *
 * @package    OpenX
 * @subpackage TestSuite
 * @author     Lukasz Wikierski <lukasz.wikierski@openx.org>
 */
class OX_Dal_Market_MarketPluginToolsTest extends UnitTestCase
{

    function tearDown()
    {
        DataGenerator::cleanUp();
    }
    
    
    function testGetMarketPlugin()
    {
        // market plugin is not installed
        $this->assertFalse(OX_Dal_Market_MarketPluginTools::getMarketPlugin());
        
        // install market plugin
        TestEnv::uninstallPluginPackage('openXMarket', false);
        TestEnv::installPluginPackage('openXMarket', false);
        
        $result = OX_Dal_Market_MarketPluginTools::getMarketPlugin();
        $this->assertIsA($result, 'Plugins_admin_oxMarket_oxMarket');
        
        //disable plugin
        $oPkgMgr = new OX_PluginManager();
        $oPkgMgr->disablePackage('openXMarket');
        
        // should ignore disable status
        $result = OX_Dal_Market_MarketPluginTools::getMarketPlugin();
        $this->assertIsA($result, 'Plugins_admin_oxMarket_oxMarket');
        
        // unistall market plugin
        TestEnv::uninstallPluginPackage('openXMarket', false);
    }
    
    
    function testIsRegistrationRequired()
    {
        // market plugin is not installed
        $this->assertTrue(OX_Dal_Market_MarketPluginTools::isRegistrationRequired());
        
        // install market plugin
        TestEnv::uninstallPluginPackage('openXMarket', false);
        TestEnv::installPluginPackage('openXMarket', false);
        
        // still registration required, no associated accounts
        $this->assertTrue(OX_Dal_Market_MarketPluginTools::isRegistrationRequired());
        
        // Create admin account
        $doAccounts = OA_Dal::factoryDO('accounts');
        $doAccounts->account_type = OA_ACCOUNT_ADMIN;
        $adminAccountId = DataGenerator::generateOne($doAccounts);
        // Add association for admin account
        $oAccountAssocData = OA_Dal::factoryDO('ext_market_assoc_data');
        $doExtMarket = OA_DAL::factoryDO('ext_market_assoc_data');
        $doExtMarket->account_id = $adminAccountId;
        $doExtMarket->publisher_account_id = 'publisher_account_id';
        $doExtMarket->api_key = 'api_key';
        $doExtMarket->status = 
            Plugins_admin_oxMarket_PublisherConsoleMarketPluginClient::LINK_IS_VALID_STATUS;
        $doExtMarket->insert();
        
        // registration not required
        $this->assertFalse(OX_Dal_Market_MarketPluginTools::isRegistrationRequired());

        //disable plugin
        $oPkgMgr = new OX_PluginManager();
        $oPkgMgr->disablePackage('openXMarket');
        
        // should ignore disable status
        $this->assertFalse(OX_Dal_Market_MarketPluginTools::isRegistrationRequired());
                
        // unistall market plugin
        TestEnv::uninstallPluginPackage('openXMarket', false);
        $this->assertTrue(OX_Dal_Market_MarketPluginTools::isRegistrationRequired());
        
        // Add association data to application variables (shouldn't require registration) 
        OX_Dal_Market_MarketPluginTools::storeMarketAccountAssocData('publisher_account_id', 'api_key');
        $this->assertFalse(OX_Dal_Market_MarketPluginTools::isRegistrationRequired());
        
        // cleanup
        OA_Dal_ApplicationVariables::delete('oxMarket_publisher_account_id');
        OA_Dal_ApplicationVariables::delete('oxMarket_api_key');
        OA_Dal_ApplicationVariables::_getAll(false); //refresh cache
    }
    
    
    function testStoreMarketAccountAssocData()
    {
        $publisherAccountId = 'test_publ_isher_accountid';
        $apiKey = 'apikey';
        
        $result = OX_Dal_Market_MarketPluginTools::storeMarketAccountAssocData($publisherAccountId, $apiKey);
        $this->assertTrue($result);

        $result = OA_Dal_ApplicationVariables::_getAll();
        $result['oxMarket_publisher_account_id'] = $apiKey;
        $result['oxMarket_api_key'] = $publisherAccountId;
        
        // cleanup
        OA_Dal_ApplicationVariables::delete('oxMarket_publisher_account_id');
        OA_Dal_ApplicationVariables::delete('oxMarket_api_key');
    }
    
    
    function testGetMarketAccountAssocData()
    {
        $publisherAccountId = 'test2_publ_isher_accountid';
        $apiKey = 'apikey2';
        
        // Test only one data avaliable
        OA_Dal_ApplicationVariables::set('oxMarket_publisher_account_id', $publisherAccountId);
        
        $result = OX_Dal_Market_MarketPluginTools::getMarketAccountAssocData();
        $this->assertNull($result);
        
        // both data
        OA_Dal_ApplicationVariables::set('oxMarket_api_key', $apiKey);
        
        $result = OX_Dal_Market_MarketPluginTools::getMarketAccountAssocData();
        $this->assertEqual($result, array('apiKey' => $apiKey, 'accountUuid' => $publisherAccountId));
        
        // delete acountuuid
        OA_Dal_ApplicationVariables::delete('oxMarket_publisher_account_id');
        
        $result = OX_Dal_Market_MarketPluginTools::getMarketAccountAssocData();
        $this->assertNull($result);
        
        // cleanup
        OA_Dal_ApplicationVariables::delete('oxMarket_api_key');
    }
}

?>