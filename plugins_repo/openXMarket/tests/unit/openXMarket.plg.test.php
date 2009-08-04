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
 * A class for testing the openXMarket class
 *
 * @package    OpenXPlugin
 * @subpackage TestSuite
 * @author     Lukasz Wikierski <lukasz.wikierski@openx.org>
 */
class Plugins_admin_oxMarket_oxMarketTest extends UnitTestCase
{
    function setUp()
    {
        $oPkgMgr = new OX_PluginManager();
        TestEnv::uninstallPluginPackage('openXMarket',false);
        TestEnv::installPluginPackage('openXMarket',false);
        // We can mockup classes after plugin is installed 
        if (!class_exists('PartialMockPublisherConsoleMarketPluginClient'))
        {
            Mock::generatePartial(
                'Plugins_admin_oxMarket_PublisherConsoleMarketPluginClient',
                'PartialMockPublisherConsoleMarketPluginClient',
                array('getAccountId', 'newWebsite', 'updateWebsite',
                      'getDefaultRestrictions', 'linkHostedAccount')
            );
        }
    }

    function tearDown()
    {
        TestEnv::uninstallPluginPackage('openXMarket',false);
    }

    function testUpdateAllWebsites()
    {
        $oMarketPlugin = OX_Component::factory('admin', 'oxMarket');
        
        // Create admin account
        $doAccounts = OA_Dal::factoryDO('accounts');
        $doAccounts->account_type = OA_ACCOUNT_ADMIN;
        $adminAccountId = DataGenerator::generateOne($doAccounts);
        
        // Create managers accounts
        $doAgency = OA_Dal::factoryDO('agency');
        $agencyId[1] = DataGenerator::generateOne($doAgency);
        $doAgency = OA_Dal::factoryDO('agency');
        $agencyId[2] = DataGenerator::generateOne($doAgency);
        $doAgency = OA_Dal::factoryDO('agency');
        $doAgency->get($agencyId[1]);
        $accountId[1] = $doAgency->account_id;
        $doAgency = OA_Dal::factoryDO('agency');
        $doAgency->get($agencyId[2]);
        $accountId[2] = $doAgency->account_id;

        // Create websites
        $doAffiliate = OA_Dal::factoryDO('affiliates');
        $doAffiliate->website = 'url1';
        $doAffiliate->agencyid = $agencyId[1];
        $affiliateId[1] = DataGenerator::generateOne($doAffiliate);
        $doAffiliate = OA_Dal::factoryDO('affiliates');
        $doAffiliate->website = 'url2';
        $doAffiliate->agencyid = $agencyId[2];
        $affiliateId[2] = DataGenerator::generateOne($doAffiliate);
        $doAffiliate = OA_Dal::factoryDO('affiliates');
        $doAffiliate->agencyid = $agencyId[1];
        $doAffiliate->website = 'url3';
        $affiliateId[3] = DataGenerator::generateOne($doAffiliate);
        
        // Crate admin market association
        $doMarketAssoc = OA_Dal::factoryDO('ext_market_assoc_data');
        $doMarketAssoc->account_id = $adminAccountId;
        $doMarketAssoc->status = 
            Plugins_admin_oxMarket_PublisherConsoleMarketPluginClient::LINK_IS_VALID_STATUS;
        DataGenerator::generateOne($doMarketAssoc);
        
        // Test add 3 websites to market
        $oPubConsoleClient = new PartialMockPublisherConsoleMarketPluginClient($this);
        $oPubConsoleClient->setReturnValue('getAccountId',$adminAccountId);
        $oPubConsoleClient->setReturnValueAt(0, 'newWebsite', 'uuid1');
        $oPubConsoleClient->setReturnValueAt(1, 'newWebsite', 'uuid2');
        $oPubConsoleClient->setReturnValueAt(2, 'newWebsite', 'uuid3');
        $oPubConsoleClient->expectCallCount('newWebsite', 3);
        $oPubConsoleClient->setReturnValueAt(0, 'updateWebsite', 'uuid1');
        $oPubConsoleClient->setReturnValueAt(1, 'updateWebsite', 'uuid2');
        $oPubConsoleClient->setReturnValueAt(2, 'updateWebsite', 'uuid3');
        $oPubConsoleClient->expectCallCount('updateWebsite', 3);
        $oPubConsoleClient->setReturnValue('getDefaultRestrictions',array());
        $oPubConsoleClient->expectCallCount('getDefaultRestrictions', 1);
        
        $oMarketPlugin->oMarketPublisherClient = $oPubConsoleClient;
        $oMarketPlugin->updateAllWebsites();

        $oWebsitePref = OA_Dal::factoryDO('ext_market_website_pref');
        $aWebsitePref = $oWebsitePref->getAll();
        $expected = array ( 
            array( 'affiliateid'=> $affiliateId[1],
                   'website_id' => 'uuid1',
                   'is_url_synchronized' => 't'),
            array( 'affiliateid'=> $affiliateId[2],
                   'website_id' => 'uuid2',
                   'is_url_synchronized' => 't'),
            array( 'affiliateid'=> $affiliateId[3],
                   'website_id' => 'uuid3',
                   'is_url_synchronized' => 't'),
            );
        $this->assertEqual($aWebsitePref, $expected);
        
        // Update one website
        $oWebsitePref = OA_Dal::factoryDO('ext_market_website_pref');
        $oWebsitePref->get($affiliateId[1]);
        $oWebsitePref->is_url_synchronized = 'f';
        $oWebsitePref->update();
        
        $oPubConsoleClient = new PartialMockPublisherConsoleMarketPluginClient($this);
        $oPubConsoleClient->setReturnValue('getAccountId',$adminAccountId);
        $oPubConsoleClient->expectCallCount('newWebsite', 0);
        $oPubConsoleClient->setReturnValueAt(0, 'updateWebsite', 'uuid1');
        $oPubConsoleClient->expectCallCount('updateWebsite', 1);
        $oPubConsoleClient->expectCallCount('getDefaultRestrictions', 0);
        
        $oMarketPlugin->oMarketPublisherClient = $oPubConsoleClient;
        $oMarketPlugin->updateAllWebsites(true);
        
        $oWebsitePref = OA_Dal::factoryDO('ext_market_website_pref');
        $oWebsitePref->get($affiliateId[1]);
        $this->assertEqual($oWebsitePref->is_url_synchronized, 't');
        
        // Update 2 websites (test limitUpdatedWebsites)
        $oPubConsoleClient = new PartialMockPublisherConsoleMarketPluginClient($this);
        $oPubConsoleClient->setReturnValue('getAccountId',$adminAccountId);
        $oPubConsoleClient->expectCallCount('newWebsite', 0);
        $oPubConsoleClient->setReturnValueAt(0, 'updateWebsite', 'uuid1');
        $oPubConsoleClient->setReturnValueAt(1, 'updateWebsite', 'uuid2');
        $oPubConsoleClient->expectCallCount('updateWebsite', 2);
        $oPubConsoleClient->expectCallCount('getDefaultRestrictions', 0);
        
        $oMarketPlugin->oMarketPublisherClient = $oPubConsoleClient;
        $oMarketPlugin->updateAllWebsites(false, 2);

        // update websites of one manager
        $doMarketAssoc = OA_Dal::factoryDO('ext_market_assoc_data');
        $doMarketAssoc->account_id = $accountId[1];
        $doMarketAssoc->status = 
            Plugins_admin_oxMarket_PublisherConsoleMarketPluginClient::LINK_IS_VALID_STATUS;
        DataGenerator::generateOne($doMarketAssoc);

        $oPubConsoleClient = new PartialMockPublisherConsoleMarketPluginClient($this);
        $oPubConsoleClient->setReturnValue('getAccountId',$accountId[1]);
        $oPubConsoleClient->expectCallCount('newWebsite', 0);
        $oPubConsoleClient->setReturnValueAt(0, 'updateWebsite', 'uuid1');
        $oPubConsoleClient->setReturnValueAt(1, 'updateWebsite', 'uuid3');
        $oPubConsoleClient->expectCallCount('updateWebsite', 2);
        $oPubConsoleClient->expectCallCount('getDefaultRestrictions', 0);
        
        $oMarketPlugin->oMarketPublisherClient = $oPubConsoleClient;
        $oMarketPlugin->updateAllWebsites();
        
        // try to update websites of unregistered manager
        $oPubConsoleClient = new PartialMockPublisherConsoleMarketPluginClient($this);
        $oPubConsoleClient->setReturnValue('getAccountId',$accountId[2]);
        $oPubConsoleClient->expectCallCount('newWebsite', 0);
        $oPubConsoleClient->expectCallCount('updateWebsite', 0);
        $oPubConsoleClient->expectCallCount('getDefaultRestrictions', 0);
        
        $oMarketPlugin->oMarketPublisherClient = $oPubConsoleClient;
        $oMarketPlugin->updateAllWebsites();
    }
    
    function testLinkHostedAccounts()
    {
        $oMarketPlugin = OX_Component::factory('admin', 'oxMarket');
        
        $defaultMultipleAccountsMode = $GLOBALS['_MAX']['CONF']['oxMarket']['multipleAccountsMode'];
        
        
        // Prepare test data
        $accountName1 = 'manager1';
        $user_sso_id1 = null;
        $userName1    = 'user1';
        $email1       = 'test1@email.com';
        $accountName2 = 'manager2';
        $user_sso_id2 = 143;
        $userName2    = 'user2';
        $email2       = 'test1@email.com';
        $admin_sso_id = 15;
        // Create admin account
        $doAccounts = OA_Dal::factoryDO('accounts');
        $doAccounts->account_type = OA_ACCOUNT_ADMIN;
        $adminAccountId = DataGenerator::generateOne($doAccounts);
        // 2 manager accounts
        $doAgency  = OA_DAL::factoryDO('agency');
        $agencyId1  = DataGenerator::generateOne($doAgency);
        $doAgency  = OA_Dal::staticGetDO('agency', $agencyId1);
        $managerAccountId1 = (int)$doAgency->account_id;
        $doAccount = OA_Dal::staticGetDO('accounts', $managerAccountId1);
        $doAccount->account_name = $accountName1;
        $doAccount->update();
        
        $doAgency  = OA_DAL::factoryDO('agency');
        $agencyId2  = DataGenerator::generateOne($doAgency);
        $doAgency  = OA_Dal::staticGetDO('agency', $agencyId2);
        $managerAccountId2 = (int)$doAgency->account_id;
        $doAccount = OA_Dal::staticGetDO('accounts', $managerAccountId2);
        $doAccount->account_name = $accountName2;
        $doAccount->update();
        // publisher account
        $doAffiliates = OA_DAL::factoryDo('affiliates');
        $affiliateId = DataGenerator::generateOne($doAffiliates);
        $doAffiliates = OA_Dal::staticGetDO('affiliates', $affiliateId);
        $publisherAccountId = $doAffiliates->account_id;
        
        // users
        $doUsers  = OA_Dal::factoryDO('users');
        $doUsers->default_account_id = $managerAccountId;
        $doUsers->sso_user_id = $user_sso_id1;
        $doUsers->username = $userName1;
        $doUsers->email_address = $email1;
        $userId1 = DataGenerator::generateOne($doUsers);
        $doUsers  = OA_Dal::factoryDO('users');
        $doUsers->default_account_id = $managerAccountId;
        $doUsers->sso_user_id = $user_sso_id2;
        $doUsers->username = $userName2;
        $doUsers->email_address = $email2;
        $userId2 = DataGenerator::generateOne($doUsers);
        $doUsers  = OA_Dal::factoryDO('users');
        $doUsers->default_account_id = $adminAccountId;
        $doUsers->sso_user_id = $admin_sso_id;
        $doUsers->username = 'admin';
        $doUsers->email_address = 'admin@emial.com';
        $adminUserId = DataGenerator::generateOne($doUsers);
        
        // link user1 to publisher and 1st manager accounts
        $doAccountUserAssoc = OA_Dal::factoryDO('account_user_assoc');
        $doAccountUserAssoc->user_id = $userId1;
        $doAccountUserAssoc->account_id = $publisherAccountId;
        $doAccountUserAssoc->linked = date('Y-m-d H:i:s', time()-5);
        $doAccountUserAssoc->insert();
        $doAccountUserAssoc = OA_Dal::factoryDO('account_user_assoc');
        $doAccountUserAssoc->user_id = $userId1;
        $doAccountUserAssoc->account_id = $managerAccountId1;
        $doAccountUserAssoc->linked = date('Y-m-d H:i:s', time()-3);
        $doAccountUserAssoc->insert();
        // Link user2 to both manager accounts (as 2nd user on 1st manager account)
        $doAccountUserAssoc = OA_Dal::factoryDO('account_user_assoc');
        $doAccountUserAssoc->user_id = $userId2;
        $doAccountUserAssoc->account_id = $managerAccountId1;
        $doAccountUserAssoc->linked = date('Y-m-d H:i:s', time()-2);
        $doAccountUserAssoc->insert();
        $doAccountUserAssoc = OA_Dal::factoryDO('account_user_assoc');
        $doAccountUserAssoc->user_id = $userId2;
        $doAccountUserAssoc->account_id = $managerAccountId2;
        $doAccountUserAssoc->linked = date('Y-m-d H:i:s', time()-4);
        $doAccountUserAssoc->insert();
        
        // Test one - multiple account mode is false 
        // Set multiple account mode to false
        $GLOBALS['_MAX']['CONF']['oxMarket']['multipleAccountsMode'] = false;
        
        $oPubConsoleClient = new PartialMockPublisherConsoleMarketPluginClient($this);
        $oPubConsoleClient->expectCallCount('linkHostedAccount',0);
        
        $oMarketPlugin->oMarketPublisherClient = $oPubConsoleClient;
        $this->assertFalse($oMarketPlugin->linkHostedAccounts($adminUserId));
        $this->assertFalse($oMarketPlugin->linkHostedAccounts($userId1));
        $this->assertFalse($oMarketPlugin->linkHostedAccounts($userId2));
        
        // Test - admin is not allowed
        $GLOBALS['_MAX']['CONF']['oxMarket']['multipleAccountsMode'] = true;
        $this->assertFalse($oMarketPlugin->linkHostedAccounts($adminUserId));
        
        // Test - user without sso id
        $this->assertFalse($oMarketPlugin->linkHostedAccounts($userId1));
        $this->assertFalse($oMarketPlugin->linkHostedAccounts($userId1, $managerAccountId1));
        $this->assertFalse($oMarketPlugin->linkHostedAccounts($userId1, $managerAccountId2));
        
        // Test - user is not first linked manager
        $this->assertFalse($oMarketPlugin->linkHostedAccounts($userId2, $managerAccountId1));
        
        // Test - link userId2 to manager account 2
        $oPubConsoleClient = new PartialMockPublisherConsoleMarketPluginClient($this);
        $oPubConsoleClient->expectCallCount('linkHostedAccount',2);
        $oPubConsoleClient->expectAt(0, 'linkHostedAccount', array($user_sso_id2, $managerAccountId2, false));
        $oPubConsoleClient->expectAt(1, 'linkHostedAccount', array($user_sso_id2, $managerAccountId2, false));
        $oPubConsoleClient->setReturnValueAt(0, 'linkHostedAccount', true);
        $oPubConsoleClient->setReturnValueAt(1, 'linkHostedAccount', true);
        
        $oMarketPlugin->oMarketPublisherClient = $oPubConsoleClient;
        
        $this->assertTrue($oMarketPlugin->linkHostedAccounts($userId2));
        $this->assertTrue($oMarketPlugin->linkHostedAccounts($userId2, $managerAccountId2));
        $this->assertFalse($oMarketPlugin->linkHostedAccounts($userId2, $managerAccountId1));
        
        // Test - manager account 2 is linked
        // Crate $managerAccountId2 market association
        $doMarketAssoc = OA_Dal::factoryDO('ext_market_assoc_data');
        $doMarketAssoc->account_id = $managerAccountId2;
        $doMarketAssoc->status = 
            Plugins_admin_oxMarket_PublisherConsoleMarketPluginClient::LINK_IS_VALID_STATUS;
        DataGenerator::generateOne($doMarketAssoc);
        
        $oPubConsoleClient = new PartialMockPublisherConsoleMarketPluginClient($this);
        $oPubConsoleClient->expectCallCount('linkHostedAccount',0);
        
        $oMarketPlugin->oMarketPublisherClient = $oPubConsoleClient;
        
        $this->assertFalse($oMarketPlugin->linkHostedAccounts($userId2));
        $this->assertFalse($oMarketPlugin->linkHostedAccounts($userId2, $managerAccountId2));
        $this->assertFalse($oMarketPlugin->linkHostedAccounts($userId2, $managerAccountId1));
        
        // Test add 3 websites to market
        /*
        $oPubConsoleClient = new PartialMockPublisherConsoleMarketPluginClient($this);
        $oPubConsoleClient->setReturnValue('getAccountId',$adminAccountId);
        $oPubConsoleClient->setReturnValueAt(0, 'newWebsite', 'uuid1');
        $oPubConsoleClient->setReturnValueAt(1, 'newWebsite', 'uuid2');
        $oPubConsoleClient->setReturnValueAt(2, 'newWebsite', 'uuid3');
        $oPubConsoleClient->expectCallCount('newWebsite', 3);
        $oPubConsoleClient->setReturnValueAt(0, 'updateWebsite', 'uuid1');
        $oPubConsoleClient->setReturnValueAt(1, 'updateWebsite', 'uuid2');
        $oPubConsoleClient->setReturnValueAt(2, 'updateWebsite', 'uuid3');
        $oPubConsoleClient->expectCallCount('updateWebsite', 3);
        $oPubConsoleClient->setReturnValue('getDefaultRestrictions',array());
        $oPubConsoleClient->expectCallCount('getDefaultRestrictions', 1);
        
        $oMarketPlugin->oMarketPublisherClient = $oPubConsoleClient;
        $oMarketPlugin->updateAllWebsites();
        */
        
        // Restore multiple account mode
        $GLOBALS['_MAX']['CONF']['oxMarket']['multipleAccountsMode'] = $defaultMultipleAccountsMode;
    }
}

?>
