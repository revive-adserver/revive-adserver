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

require_once MAX_PATH . '/lib/OA/Dal/DataGenerator.php';

/**
 * A class for testing the update website openXMarket's maintenace process 
 *
 * @package    OpenXPlugin
 * @subpackage TestSuite
 * @author     Lukasz Wikierski <lukasz.wikierski@openx.org>
 */
class Plugins_MaintenaceStatisticsTask_oxMarketMaintenance_UpdateWebsitesTest extends UnitTestCase
{
    
    function setUp()
    {
        $oPkgMgr = new OX_PluginManager();
        TestEnv::uninstallPluginPackage('openXMarket',false);
        TestEnv::installPluginPackage('openXMarket',false);
    }

    function tearDown()
    {
        TestEnv::uninstallPluginPackage('openXMarket',false);
    }
    
    function test_implements()
    {
        $oUpdateWebsites = new Plugins_MaintenaceStatisticsTask_oxMarketMaintenance_UpdateWebsites();
        $this->assertIsA($oUpdateWebsites, 'OX_Maintenance_Statistics_Task');  
    }
    
    function testRun() 
    {
        Mock::generatePartial(
            'Plugins_admin_oxMarket_oxMarket',
            'MockOxMarket',
            array('updateAccountStatus', 'isActive', 'isRegistered',
                  'updateAllWebsites', 'setWorkAsAccountId')
        );
        Mock::generatePartial(
            'Plugins_MaintenaceStatisticsTask_oxMarketMaintenance_UpdateWebsites',
            'MockUpdateWebsites',
            array('getMarketPlugin')
        );

        // Create admin account
        $doAccounts = OA_Dal::factoryDO('accounts');
        $doAccounts->account_type = OA_ACCOUNT_ADMIN;
        $adminAccountId = DataGenerator::generateOne($doAccounts);
        
        // Crate admin market association
        $doMarketAssoc = OA_Dal::factoryDO('ext_market_assoc_data');
        $doMarketAssoc->account_id = $adminAccountId;
        $doMarketAssoc->status = 
            Plugins_admin_oxMarket_PublisherConsoleMarketPluginClient::LINK_IS_VALID_STATUS;
        DataGenerator::generateOne($doMarketAssoc);
        
        // Test single call for admin account, market is inactive (blocked) but registered
        $oMarketPlugin = new MockOxMarket($this);
        $oMarketPlugin->expectAt(0, 'setWorkAsAccountId', array($adminAccountId));
        $oMarketPlugin->expectAt(1, 'setWorkAsAccountId', array(null));
        $oMarketPlugin->setReturnValueAt(0, 'isRegistered', true);
        $oMarketPlugin->setReturnValueAt(0, 'isActive', false);
        $oMarketPlugin->expectCallCount('setWorkAsAccountId', 2);
        $oMarketPlugin->expectCallCount('isRegistered', 1);
        $oMarketPlugin->expectCallCount('isActive', 1);
        $oMarketPlugin->expectCallCount('updateAccountStatus', 1);
        $oMarketPlugin->expectCallCount('updateAllWebsites', 0);
        
        $oUpdateWebsites = new MockUpdateWebsites($this);
        $oUpdateWebsites->setReturnValue('getMarketPlugin', $oMarketPlugin);
        $oUpdateWebsites->expectCallCount('getMarketPlugin', 1);
        $oUpdateWebsites->run();
        
        // Test single call for admin account, market is active
        $oMarketPlugin = new MockOxMarket($this);
        $oMarketPlugin->expectAt(0, 'setWorkAsAccountId', array($adminAccountId));
        $oMarketPlugin->expectAt(1, 'setWorkAsAccountId', array(null));
        $oMarketPlugin->setReturnValueAt(0, 'isRegistered', true);
        $oMarketPlugin->setReturnValueAt(0, 'isActive', true);
        $oMarketPlugin->expectAt(0, 'updateAllWebsites', array(true));
        $oMarketPlugin->expectCallCount('setWorkAsAccountId', 2);
        $oMarketPlugin->expectCallCount('isRegistered', 1);
        $oMarketPlugin->expectCallCount('isActive', 1);
        $oMarketPlugin->expectCallCount('updateAccountStatus', 1);
        $oMarketPlugin->expectCallCount('updateAllWebsites', 1);
        
        $oUpdateWebsites = new MockUpdateWebsites($this);
        $oUpdateWebsites->setReturnValue('getMarketPlugin', $oMarketPlugin);
        $oUpdateWebsites->expectCallCount('getMarketPlugin', 1);
        $oUpdateWebsites->run();
        
        // clear market association
        $oWebsiteStat = OA_Dal::factoryDO('ext_market_assoc_data');
        $oWebsiteStat->whereAdd('1=1');
        $oWebsiteStat->delete(DB_DATAOBJECT_WHEREADD_ONLY);
        
        // Test for multiple manager accounts
        // Prepare managers
        $doAgency = OA_Dal::factoryDO('agency');
        $agencyId[1] = DataGenerator::generateOne($doAgency);
        $doAgency = OA_Dal::factoryDO('agency');
        $agencyId[2] = DataGenerator::generateOne($doAgency);
        $doAgency = OA_Dal::factoryDO('agency');
        $doAgency->get($agencyId[1]);
        $accountId1 = (int)$doAgency->account_id;
        $doAgency = OA_Dal::factoryDO('agency');
        $doAgency->get($agencyId[2]);
        $accountId2 = (int)$doAgency->account_id;
        
        // Register managers to market
        $doMarketAssoc = OA_Dal::factoryDO('ext_market_assoc_data');
        $doMarketAssoc->account_id = $accountId1;
        $doMarketAssoc->status = 
            Plugins_admin_oxMarket_PublisherConsoleMarketPluginClient::LINK_IS_VALID_STATUS;
        DataGenerator::generateOne($doMarketAssoc);
        $doMarketAssoc = OA_Dal::factoryDO('ext_market_assoc_data');
        $doMarketAssoc->account_id = $accountId2;
        $doMarketAssoc->status = 
            Plugins_admin_oxMarket_PublisherConsoleMarketPluginClient::LINK_IS_VALID_STATUS;
        DataGenerator::generateOne($doMarketAssoc);
        
        // Test multiple calls for managers accounts
        $oMarketPlugin = new MockOxMarket($this);
        $oMarketPlugin->expectAt(0, 'setWorkAsAccountId', array($accountId1));
        $oMarketPlugin->expectAt(1, 'setWorkAsAccountId', array($accountId2));
        $oMarketPlugin->expectAt(2, 'setWorkAsAccountId', array(null));
        $oMarketPlugin->setReturnValue('isRegistered', true);
        $oMarketPlugin->setReturnValue('isActive', true);
        $oMarketPlugin->expect('updateAllWebsites', array(true));
        $oMarketPlugin->expectCallCount('setWorkAsAccountId', 3);
        $oMarketPlugin->expectCallCount('isRegistered', 2);
        $oMarketPlugin->expectCallCount('isActive', 2);
        $oMarketPlugin->expectCallCount('updateAccountStatus', 2);
        $oMarketPlugin->expectCallCount('updateAllWebsites', 2);
        
        $oUpdateWebsites = new MockUpdateWebsites($this);
        $oUpdateWebsites->setReturnValue('getMarketPlugin', $oMarketPlugin);
        $oUpdateWebsites->expectCallCount('getMarketPlugin', 1);
        $oUpdateWebsites->run();
        
        // clear market associations
        $oWebsiteStat = OA_Dal::factoryDO('ext_market_assoc_data');
        $oWebsiteStat->whereAdd('1=1');
        $oWebsiteStat->delete(DB_DATAOBJECT_WHEREADD_ONLY);
    }
}