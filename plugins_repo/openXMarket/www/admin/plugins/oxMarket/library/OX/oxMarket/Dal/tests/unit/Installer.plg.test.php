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
$Id: mergeCopyTarget55201.tmp 43647 2009-09-23 09:22:48Z lukasz.wikierski $
*/
require_once MAX_PATH . '/lib/OA/Dal/DataGenerator.php';
require_once MAX_PATH . '/lib/OX/Dal/Market/MarketPluginTools.php';

/**
 * A class for testing the Installer DAL library
 *
 * @package    OpenXPlugin
 * @subpackage TestSuite
 * @author     Lukasz Wikierski <lukasz.wikierski@openx.org>
 */
class OX_oxMarket_Dal_InstallerTest extends UnitTestCase
{
    public function setUp()
    {
        $oPkgMgr = new OX_PluginManager();
        TestEnv::uninstallPluginPackage('openXMarket', false);
        TestEnv::installPluginPackage('openXMarket', false);
        // include only if class isn't present after installation
        if (!class_exists('OX_oxMarket_Dal_Installer')) {
            require_once dirname(__FILE__).'/../../Installer.php';
        }
    }

    public function tearDown()
    {
        DataGenerator::cleanUp();
        TestEnv::uninstallPluginPackage('openXMarket', false);
        OA_Dal_ApplicationVariables::delete('oxMarket_publisher_account_id');
        OA_Dal_ApplicationVariables::delete('oxMarket_api_key');
    }

    public function testIsRegistrationRequired()
    {
        $this->assertTrue(OX_oxMarket_Dal_Installer::isRegistrationRequired());
        
        // Create account and set publisher account association data
        $doAccounts = OA_Dal::factoryDO('accounts');
        $doAccounts->account_type = OA_ACCOUNT_ADMIN;
        $adminAccountId = DataGenerator::generateOne($doAccounts);
        $doExtMarket = OA_DAL::factoryDO('ext_market_assoc_data');
        $doExtMarket->account_id = $adminAccountId;
        $doExtMarket->publisher_account_id = 'publisher_account_id';
        $doExtMarket->api_key = 'api_key';
        $doExtMarket->status = 
            Plugins_admin_oxMarket_PublisherConsoleMarketPluginClient::LINK_IS_VALID_STATUS;
        $doExtMarket->insert();
        
        $this->assertFalse(OX_oxMarket_Dal_Installer::isRegistrationRequired());
        
        // Clear account association
        $doExtMarket->delete();
        OA_Dal_ApplicationVariables::delete('admin_account_id');
    }
    
    
    public function testAutoRegisterMarketPlugin()
    {
        // initalize market plugin in single accounts mode
        $GLOBALS['_MAX']['CONF']['oxMarket']['multipleAccountsMode'] = 0;
        $oMarketPlugin = OX_Component::factory('admin', 'oxMarket');
        $marketClient = &$oMarketPlugin->getPublisherConsoleApiClient();
        
        // TEST: no registration data
        $this->assertFalse(OX_oxMarket_Dal_Installer::autoRegisterMarketPlugin($marketClient));
        
        $accountUuid = 'd2758200-a767-11de-8a39-0800200c9a66';
        $apiKey = '63d0cea9d550e495fde1b81310951bd77b0627e7674129c5f74d8028a117d063';
        OX_Dal_Market_MarketPluginTools::storeMarketAccountAssocData($accountUuid, $apiKey);

        // TEST: lack of admin account
        try {
            OX_oxMarket_Dal_Installer::autoRegisterMarketPlugin($marketClient);
            $this->fail('Should have throw exception');
        } catch (Plugins_admin_oxMarket_PublisherConsoleClientException $e) {
            $this->assertEqual($e->getMessage(), 'There is no admin account id in database');
        }
        
        // Create admin account
        $doAccounts = OA_Dal::factoryDO('accounts');
        $doAccounts->account_type = OA_ACCOUNT_ADMIN;
        $adminAccountId = DataGenerator::generateOne($doAccounts);
        
        // TEST: create association to the admin account
        $this->assertTrue(OX_oxMarket_Dal_Installer::autoRegisterMarketPlugin($marketClient));
        
        // check if association was added
        $doMarketAssoc = OA_DAL::factoryDO('ext_market_assoc_data');
        $doMarketAssoc->find();
        $this->assertTrue($doMarketAssoc->fetch());
        $this->assertEqual($adminAccountId, $doMarketAssoc->account_id);
        $this->assertEqual($accountUuid, $doMarketAssoc->publisher_account_id);
        $this->assertEqual($apiKey, $doMarketAssoc->api_key);
        $this->assertEqual(Plugins_admin_oxMarket_PublisherConsoleMarketPluginClient::LINK_IS_VALID_STATUS,
            $doMarketAssoc->status);
        $this->assertFalse($doMarketAssoc->fetch()); // only one entry
                           
        // TEST: association already exist 
        $this->assertFalse(OX_oxMarket_Dal_Installer::autoRegisterMarketPlugin($marketClient));
                
        // clear associations
        $doMarketAssoc = OA_DAL::factoryDO('ext_market_assoc_data');
        $doMarketAssoc->whereAdd('1=1');
        $doMarketAssoc->delete(DB_DATAOBJECT_WHEREADD_ONLY);
        
        // initalize market plugin in multiple accounts mode
        $GLOBALS['_MAX']['CONF']['oxMarket']['multipleAccountsMode'] = 1;
        $oMarketPlugin = OX_Component::factory('admin', 'oxMarket');
        $marketClient = &$oMarketPlugin->getPublisherConsoleApiClient();
        
        // Shouldn't use admin account
        $this->assertFalse(OX_oxMarket_Dal_Installer::autoRegisterMarketPlugin($marketClient));
        
        // create agency
        $doAgency = OA_Dal::factoryDO('agency');
        $agencyId = DataGenerator::generateOne($doAgency);
        $doAgency = OA_Dal::factoryDO('agency');
        $doAgency->get($agencyId);
        
        // Create user and associate this account with admin and manager accounts 
        $doUser = OA_Dal::factoryDO('users');
        $doUser->default_account_id = $doAgency->account_id;
        $userId = DataGenerator::generateOne($doUser);
        
        $doAccount_user_Assoc = OA_Dal::factoryDO('account_user_assoc');
        $doAccount_user_Assoc->account_id = $doAgency->account_id;
        $doAccount_user_Assoc->user_id = $userId;
        $doAccount_user_Assoc->insert();
        $doAccount_user_Assoc = OA_Dal::factoryDO('account_user_assoc');
        $doAccount_user_Assoc->account_id = $adminAccountId;
        $doAccount_user_Assoc->user_id = $userId;
        $doAccount_user_Assoc->insert();
        
        // Test Default agency isn't named 'Default manager'
        $this->assertFalse(OX_oxMarket_Dal_Installer::autoRegisterMarketPlugin($marketClient));
        
        $doAgency = OA_Dal::factoryDO('agency');
        $doAgency->get($agencyId);
        $doAgency->name = 'Default manager';
        $doAgency->update();
        
        // Merge to agency
        $this->assertTrue(OX_oxMarket_Dal_Installer::autoRegisterMarketPlugin($marketClient));
        
        // check if association was added
        $doMarketAssoc = OA_DAL::factoryDO('ext_market_assoc_data');
        $doMarketAssoc->find();
        $this->assertTrue($doMarketAssoc->fetch());
        $this->assertEqual($doAgency->account_id, $doMarketAssoc->account_id);
        $this->assertEqual($accountUuid, $doMarketAssoc->publisher_account_id);
        $this->assertEqual($apiKey, $doMarketAssoc->api_key);
        $this->assertEqual(Plugins_admin_oxMarket_PublisherConsoleMarketPluginClient::LINK_IS_VALID_STATUS,
            $doMarketAssoc->status);
        $this->assertFalse($doMarketAssoc->fetch()); // only one entry
        
        // clear associations
        $doMarketAssoc = OA_DAL::factoryDO('ext_market_assoc_data');
        $doMarketAssoc->whereAdd('1=1');
        $doMarketAssoc->delete(DB_DATAOBJECT_WHEREADD_ONLY);
        // clear user assoc
        $doMarketAssoc = OA_DAL::factoryDO('account_user_assoc');
        $doMarketAssoc->whereAdd('1=1');
        $doMarketAssoc->delete(DB_DATAOBJECT_WHEREADD_ONLY);
    }
    
}
