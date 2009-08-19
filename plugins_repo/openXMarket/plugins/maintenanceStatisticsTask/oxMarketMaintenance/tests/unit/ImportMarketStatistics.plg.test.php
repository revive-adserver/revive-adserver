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

// False Pub Console client to test handling exception 'method does not exist'
class MockExceptionPublisherConsoleMarketPluginClient {
    function oxmStatisticsLimited()
    {
        throw new Exception('Method "oxmStatisticsLimited" does not exist',620);
    }
    
    function oxmStatistics()
    {
        return "1\n".
               "website-uuidid3\t120\t100\t2009-12-02T01:00:00\t1234\t123.56\n";
    }
}

/**
 * A class for testing the openXMarket
 *
 * @package    OpenXPlugin
 * @subpackage TestSuite
 * @author     Lukasz Wikierski <lukasz.wikierski@openx.org>
 */
class Plugins_MaintenaceStatisticsTask_oxMarketMaintenance_ImportMarketStatisticsTest extends UnitTestCase
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
        Mock::generatePartial(
            'Plugins_MaintenaceStatisticsTask_oxMarketMaintenance_ImportMarketStatistics',
            'Mock2ImportMarketStatistics',
            array('getPublisherConsoleApiClient')
        );
        $oImportMarketStatistics = new Mock2ImportMarketStatistics($this);
        $this->assertIsA($oImportMarketStatistics, 'OX_Maintenance_Statistics_Task');  
    }
    
    function testRun() 
    {
        Mock::generatePartial(
            'MockExceptionPublisherConsoleMarketPluginClient',
            'MockPublisherConsoleMarketPluginClient',
            array('getStatistics', 'setWorkAsAccountId')
        );
        Mock::generatePartial(
            'Plugins_MaintenaceStatisticsTask_oxMarketMaintenance_ImportMarketStatistics',
            'MockImportMarketStatistics',
            array('getPublisherConsoleApiClient', 'isPluginActive', 'getRegisteredWebsitesIds')
        );

        // Create admin account
        $doAccounts = OA_Dal::factoryDO('accounts');
        $doAccounts->account_type = OA_ACCOUNT_ADMIN;
        $adminAccountId = DataGenerator::generateOne($doAccounts);
        
        // get plugin version
        $oPluginManager = new OX_PluginManager();
        $aInfo =  $oPluginManager->getPackageInfo('openXMarket', false);    
        $pluginVersion = strtolower($aInfo['version']);

        if (version_compare($pluginVersion, '1.1.0-rc6', '<')) 
        {
            // TODO: delete this old tests after release of 1.1.0-rc6 
            
            // Crate admin market association
            $doMarketAssoc = OA_Dal::factoryDO('ext_market_assoc_data');
            $doMarketAssoc->account_id = $adminAccountId;
            $doMarketAssoc->status = 
                Plugins_admin_oxMarket_PublisherConsoleMarketPluginClient::LINK_IS_VALID_STATUS;
            DataGenerator::generateOne($doMarketAssoc);
            
            // Test when plugin is inactive (for admin account)
            $oPubConsoleMarketPluginClient = new MockPublisherConsoleMarketPluginClient($this);
            $oPubConsoleMarketPluginClient->expectAt(0, 'setWorkAsAccountId', array($adminAccountId));
            $oPubConsoleMarketPluginClient->expectAt(1, 'setWorkAsAccountId', array(null));
            $oPubConsoleMarketPluginClient->expectCallCount('getStatistics', 0);
            $oPubConsoleMarketPluginClient->expectCallCount('setWorkAsAccountId', 2);
            
            $oImportMarketStatistics = new MockImportMarketStatistics($this);
            $oImportMarketStatistics->setReturnValue('isPluginActive', false);
            $oImportMarketStatistics->setReturnValue('getPublisherConsoleApiClient',$oPubConsoleMarketPluginClient);
            $oImportMarketStatistics->expectCallCount('isPluginActive', 1);
            $oImportMarketStatistics->expectCallCount('getRegisteredWebsitesIds', 0);
            $oImportMarketStatistics->expectCallCount('getPublisherConsoleApiClient', 1);
            $oImportMarketStatistics->run();
            
            // Test when plugin is active but there is no registered websites
            $oPubConsoleMarketPluginClient = new MockPublisherConsoleMarketPluginClient($this);
            $oPubConsoleMarketPluginClient->expectAt(0, 'setWorkAsAccountId', array($adminAccountId));
            $oPubConsoleMarketPluginClient->expectAt(1, 'setWorkAsAccountId', array(null));
            $oPubConsoleMarketPluginClient->expectCallCount('getStatistics', 0);
            $oPubConsoleMarketPluginClient->expectCallCount('setWorkAsAccountId', 2);
            
            $oImportMarketStatistics = new MockImportMarketStatistics($this);
            $oImportMarketStatistics->setReturnValue('isPluginActive', true);
            $oImportMarketStatistics->expectCallCount('isPluginActive', 1);
            $oImportMarketStatistics->expect('getRegisteredWebsitesIds', array($adminAccountId));
            $oImportMarketStatistics->setReturnValue('getRegisteredWebsitesIds', array());
            $oImportMarketStatistics->expectCallCount('getRegisteredWebsitesIds', 1);
            $oImportMarketStatistics->setReturnValue('getPublisherConsoleApiClient',$oPubConsoleMarketPluginClient);
            $oImportMarketStatistics->expectCallCount('getPublisherConsoleApiClient', 1);
            $oImportMarketStatistics->run();
            
            // Test get statistics in two steps
            $oPubConsoleMarketPluginClient = new MockPublisherConsoleMarketPluginClient($this);
            $response1 = "1\t0\n".
                        "website-uuidid1\t120\t100\t2009-12-02T01:00:00\t1234\t123.56\t\n";
            $response2 = "223746234762347623\t1\n".
                        "website-uuidid2\t120\t100\t2009-12-02T02:00:00\t4321\t233.44\t\n";
            $websiteUuids = array('website-uuidid1', 'website-uuidid2');
            $oPubConsoleMarketPluginClient->expectAt(0, 'getStatistics', array('0', $websiteUuids));
            $oPubConsoleMarketPluginClient->expectAt(1, 'getStatistics', array('1', $websiteUuids));
            $oPubConsoleMarketPluginClient->setReturnValueAt(0, 'getStatistics',$response1);
            $oPubConsoleMarketPluginClient->setReturnValueAt(1, 'getStatistics',$response2);
            $oPubConsoleMarketPluginClient->expectAt(0, 'setWorkAsAccountId', array($adminAccountId));
            $oPubConsoleMarketPluginClient->expectAt(1, 'setWorkAsAccountId', array(null));
            $oPubConsoleMarketPluginClient->expectCallCount('getStatistics', 2);
            $oPubConsoleMarketPluginClient->expectCallCount('setWorkAsAccountId', 2);
            
            $oImportMarketStatistics = new MockImportMarketStatistics($this);
            $oImportMarketStatistics->setReturnValue('isPluginActive', true);
            $oImportMarketStatistics->expectCallCount('isPluginActive', 1);
            $oImportMarketStatistics->expect('getRegisteredWebsitesIds', array($adminAccountId));
            $oImportMarketStatistics->setReturnValue('getRegisteredWebsitesIds', $websiteUuids);
            $oImportMarketStatistics->expectCallCount('getRegisteredWebsitesIds', 1);
            $oImportMarketStatistics->setReturnValue('getPublisherConsoleApiClient',$oPubConsoleMarketPluginClient);
            $oImportMarketStatistics->expectCallCount('getPublisherConsoleApiClient', 1);
            $oImportMarketStatistics->run();
            
            $oWebsiteStat = OA_Dal::factoryDO('ext_market_web_stats');
            $aWebsiteStat = $oWebsiteStat->getAll();
            $this->assertEqual(2, count ($aWebsiteStat));
            $this->assertEqual('website-uuidid1', $aWebsiteStat[0]['p_website_id']);
            $this->assertEqual('website-uuidid2', $aWebsiteStat[1]['p_website_id']);
            
            $lastUpdate = OA_Dal::factoryDO('ext_market_general_pref')
                            ->findAndGetValue($adminAccountId,
                Plugins_MaintenaceStatisticsTask_oxMarketMaintenance_ImportMarketStatistics::LAST_STATISTICS_VERSION_VARIABLE);
            $this->assertEqual('223746234762347623',$lastUpdate);
            
            // Clear statistics
            $oWebsiteStat = OA_Dal::factoryDO('ext_market_web_stats');
            $oWebsiteStat->whereAdd('1=1');
            $oWebsiteStat->delete(DB_DATAOBJECT_WHEREADD_ONLY);
            // clear market association
            $oWebsiteStat = OA_Dal::factoryDO('ext_market_assoc_data');
            $oWebsiteStat->whereAdd('1=1');
            $oWebsiteStat->delete(DB_DATAOBJECT_WHEREADD_ONLY);
            
            // Test for multiple manager accounts
            // Prepare managers and websites
            $aIds = $this->prepareManagersAndWebsites();
            $accountId1 = (int)$aIds['accountId'][0];
            $accountId2 = (int)$aIds['accountId'][1];
            $affiliateId = $aIds['affiliateId'];
            
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
            
            // Test get statistics
            $oPubConsoleMarketPluginClient = new MockPublisherConsoleMarketPluginClient($this);
            $response1 = "2\t1\n".
                        "website-manager1-uuidid1\t120\t100\t2009-12-02T01:00:00\t1234\t123.56\t\n";
            $response2 = "1\t1\n".
                        "website-manager2-uuidid2\t120\t100\t2009-12-02T02:00:00\t4321\t233.44\t\n";
            $websiteUuids1 = array('website-manager1-uuidid1');
            $websiteUuids2 = array('website-manager2-uuidid2');
            $oPubConsoleMarketPluginClient->expectAt(0, 'getStatistics', array('0', $websiteUuids1));
            $oPubConsoleMarketPluginClient->expectAt(1, 'getStatistics', array('0', $websiteUuids2));
            $oPubConsoleMarketPluginClient->setReturnValueAt(0, 'getStatistics',$response1);
            $oPubConsoleMarketPluginClient->setReturnValueAt(1, 'getStatistics',$response2);
            $oPubConsoleMarketPluginClient->expectAt(0, 'setWorkAsAccountId', array($accountId1));
            $oPubConsoleMarketPluginClient->expectAt(1, 'setWorkAsAccountId', array($accountId2));
            $oPubConsoleMarketPluginClient->expectAt(2, 'setWorkAsAccountId', array(null));
            $oPubConsoleMarketPluginClient->expectCallCount('getStatistics', 2);
            $oPubConsoleMarketPluginClient->expectCallCount('setWorkAsAccountId', 3);
            
            $oImportMarketStatistics = new MockImportMarketStatistics($this);
            $oImportMarketStatistics->setReturnValue('isPluginActive', true);
            $oImportMarketStatistics->expectCallCount('isPluginActive', 2);
            $oImportMarketStatistics->expectAt(0, 'getRegisteredWebsitesIds', array($accountId1));
            $oImportMarketStatistics->expectAt(1, 'getRegisteredWebsitesIds', array($accountId2));
            $oImportMarketStatistics->setReturnValueAt(0, 'getRegisteredWebsitesIds', $websiteUuids1);
            $oImportMarketStatistics->setReturnValueAt(1, 'getRegisteredWebsitesIds', $websiteUuids2);
            $oImportMarketStatistics->expectCallCount('getRegisteredWebsitesIds', 2);
            $oImportMarketStatistics->setReturnValue('getPublisherConsoleApiClient',$oPubConsoleMarketPluginClient);
            $oImportMarketStatistics->expectCallCount('getPublisherConsoleApiClient', 1);
            $oImportMarketStatistics->run();
            
            $oWebsiteStat = OA_Dal::factoryDO('ext_market_web_stats');
            $aWebsiteStat = $oWebsiteStat->getAll();
            $this->assertEqual(2, count ($aWebsiteStat));
            $this->assertEqual('website-manager1-uuidid1', $aWebsiteStat[0]['p_website_id']);
            $this->assertEqual('website-manager2-uuidid2', $aWebsiteStat[1]['p_website_id']);
            
            $lastUpdate = OA_Dal::factoryDO('ext_market_general_pref')
                                ->findAndGetValue($accountId1,
                Plugins_MaintenaceStatisticsTask_oxMarketMaintenance_ImportMarketStatistics::LAST_STATISTICS_VERSION_VARIABLE);
            $this->assertEqual('2',$lastUpdate);
            $lastUpdate = OA_Dal::factoryDO('ext_market_general_pref')
                                ->findAndGetValue($accountId2,
                Plugins_MaintenaceStatisticsTask_oxMarketMaintenance_ImportMarketStatistics::LAST_STATISTICS_VERSION_VARIABLE);
            $this->assertEqual('1',$lastUpdate);
            
            // Clear statistics
            $oWebsiteStat = OA_Dal::factoryDO('ext_market_web_stats');
            $oWebsiteStat->whereAdd('1=1');
            $oWebsiteStat->delete(DB_DATAOBJECT_WHEREADD_ONLY);
            // clear market associations
            $oWebsiteStat = OA_Dal::factoryDO('ext_market_assoc_data');
            $oWebsiteStat->whereAdd('1=1');
            $oWebsiteStat->delete(DB_DATAOBJECT_WHEREADD_ONLY);
        } else {
            // for version 1.1.0-rc6
            
            // Crate admin market association (status disabled)
            $doMarketAssoc = OA_Dal::factoryDO('ext_market_assoc_data');
            $doMarketAssoc->account_id = $adminAccountId;
            $doMarketAssoc->status = 
                Plugins_admin_oxMarket_PublisherConsoleMarketPluginClient::ACCOUNT_DISABLED_STATUS;
            DataGenerator::generateOne($doMarketAssoc);
            
            // Test when plugin is inactive (for admin account)
            $oPubConsoleMarketPluginClient = new MockPublisherConsoleMarketPluginClient($this);
            //$oPubConsoleMarketPluginClient->expectAt(0, 'setWorkAsAccountId', array($adminAccountId));
            $oPubConsoleMarketPluginClient->expectAt(0, 'setWorkAsAccountId', array(null));
            $oPubConsoleMarketPluginClient->expectCallCount('getStatistics', 0);
            $oPubConsoleMarketPluginClient->expectCallCount('setWorkAsAccountId', 1);
            
            $oImportMarketStatistics = new MockImportMarketStatistics($this);
            $oImportMarketStatistics->setReturnValue('getPublisherConsoleApiClient',$oPubConsoleMarketPluginClient);
            $oImportMarketStatistics->expectCallCount('isPluginActive', 0);
            $oImportMarketStatistics->expectCallCount('getRegisteredWebsitesIds', 0);
            $oImportMarketStatistics->expectCallCount('getPublisherConsoleApiClient', 1);
            $oImportMarketStatistics->run();
            
            // activate admin account
            $doMarketAssoc = OA_Dal::factoryDO('ext_market_assoc_data');
            $doMarketAssoc->account_id = $adminAccountId;
            $doMarketAssoc->find();
            $doMarketAssoc->status =
                Plugins_admin_oxMarket_PublisherConsoleMarketPluginClient::LINK_IS_VALID_STATUS;
            $doMarketAssoc->update();
            
            // Test when plugin is active but there is no registered websites
            $oPubConsoleMarketPluginClient = new MockPublisherConsoleMarketPluginClient($this);
            $oPubConsoleMarketPluginClient->expectAt(0, 'setWorkAsAccountId', array($adminAccountId));
            $oPubConsoleMarketPluginClient->expectAt(1, 'setWorkAsAccountId', array(null));
            $oPubConsoleMarketPluginClient->expectCallCount('getStatistics', 0);
            $oPubConsoleMarketPluginClient->expectCallCount('setWorkAsAccountId', 2);
            
            $oImportMarketStatistics = new MockImportMarketStatistics($this);
            $oImportMarketStatistics->expect('getRegisteredWebsitesIds', array($adminAccountId));
            $oImportMarketStatistics->setReturnValue('getRegisteredWebsitesIds', array());
            $oImportMarketStatistics->expectCallCount('getRegisteredWebsitesIds', 1);
            $oImportMarketStatistics->setReturnValue('getPublisherConsoleApiClient',$oPubConsoleMarketPluginClient);
            $oImportMarketStatistics->expectCallCount('getPublisherConsoleApiClient', 1);
            $oImportMarketStatistics->run();
            
            // Test get statistics in two steps
            $oPubConsoleMarketPluginClient = new MockPublisherConsoleMarketPluginClient($this);
            $response1 = "1\t0\n".
                        "website-uuidid1\t120\t100\t2009-12-02T01:00:00\t1234\t123.56\t\n";
            $response2 = "223746234762347623\t1\n".
                        "website-uuidid2\t120\t100\t2009-12-02T02:00:00\t4321\t233.44\t\n";
            $websiteUuids = array('website-uuidid1', 'website-uuidid2');
            $oPubConsoleMarketPluginClient->expectAt(0, 'getStatistics', array('0', $websiteUuids));
            $oPubConsoleMarketPluginClient->expectAt(1, 'getStatistics', array('1', $websiteUuids));
            $oPubConsoleMarketPluginClient->setReturnValueAt(0, 'getStatistics',$response1);
            $oPubConsoleMarketPluginClient->setReturnValueAt(1, 'getStatistics',$response2);
            $oPubConsoleMarketPluginClient->expectAt(0, 'setWorkAsAccountId', array($adminAccountId));
            $oPubConsoleMarketPluginClient->expectAt(1, 'setWorkAsAccountId', array(null));
            $oPubConsoleMarketPluginClient->expectCallCount('getStatistics', 2);
            $oPubConsoleMarketPluginClient->expectCallCount('setWorkAsAccountId', 2);
            
            $oImportMarketStatistics = new MockImportMarketStatistics($this);
            $oImportMarketStatistics->expect('getRegisteredWebsitesIds', array($adminAccountId));
            $oImportMarketStatistics->setReturnValue('getRegisteredWebsitesIds', $websiteUuids);
            $oImportMarketStatistics->expectCallCount('getRegisteredWebsitesIds', 1);
            $oImportMarketStatistics->setReturnValue('getPublisherConsoleApiClient',$oPubConsoleMarketPluginClient);
            $oImportMarketStatistics->expectCallCount('getPublisherConsoleApiClient', 1);
            $oImportMarketStatistics->run();
            
            
            $oWebsiteStat = OA_Dal::factoryDO('ext_market_web_stats');
            $aWebsiteStat = $oWebsiteStat->getAll();
            $this->assertEqual(2, count ($aWebsiteStat));
            $this->assertEqual('website-uuidid1', $aWebsiteStat[0]['p_website_id']);
            $this->assertEqual('website-uuidid2', $aWebsiteStat[1]['p_website_id']);
            
            $lastUpdate = OA_Dal::factoryDO('ext_market_general_pref')
                            ->findAndGetValue($adminAccountId,
                Plugins_MaintenaceStatisticsTask_oxMarketMaintenance_ImportMarketStatistics::LAST_STATISTICS_VERSION_VARIABLE);
            $this->assertEqual('223746234762347623',$lastUpdate);
            
            // Clear statistics
            $oWebsiteStat = OA_Dal::factoryDO('ext_market_web_stats');
            $oWebsiteStat->whereAdd('1=1');
            $oWebsiteStat->delete(DB_DATAOBJECT_WHEREADD_ONLY);
            // clear market association
            $oWebsiteStat = OA_Dal::factoryDO('ext_market_assoc_data');
            $oWebsiteStat->whereAdd('1=1');
            $oWebsiteStat->delete(DB_DATAOBJECT_WHEREADD_ONLY);
            
            // Test for multiple manager accounts
            // Prepare managers and websites
            $aIds = $this->prepareManagersAndWebsites();
            $accountId1 = (int)$aIds['accountId'][0];
            $accountId2 = (int)$aIds['accountId'][1];
            $affiliateId = $aIds['affiliateId'];
            
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
            
            // Test get statistics
            $oPubConsoleMarketPluginClient = new MockPublisherConsoleMarketPluginClient($this);
            $response1 = "2\t1\n".
                        "website-manager1-uuidid1\t120\t100\t2009-12-02T01:00:00\t1234\t123.56\t\n";
            $response2 = "1\t1\n".
                        "website-manager2-uuidid2\t120\t100\t2009-12-02T02:00:00\t4321\t233.44\t\n";
            $websiteUuids1 = array('website-manager1-uuidid1');
            $websiteUuids2 = array('website-manager2-uuidid2');
            $oPubConsoleMarketPluginClient->expectAt(0, 'getStatistics', array('0', $websiteUuids1));
            $oPubConsoleMarketPluginClient->expectAt(1, 'getStatistics', array('0', $websiteUuids2));
            $oPubConsoleMarketPluginClient->setReturnValueAt(0, 'getStatistics',$response1);
            $oPubConsoleMarketPluginClient->setReturnValueAt(1, 'getStatistics',$response2);
            $oPubConsoleMarketPluginClient->expectAt(0, 'setWorkAsAccountId', array($accountId1));
            $oPubConsoleMarketPluginClient->expectAt(1, 'setWorkAsAccountId', array($accountId2));
            $oPubConsoleMarketPluginClient->expectAt(2, 'setWorkAsAccountId', array(null));
            $oPubConsoleMarketPluginClient->expectCallCount('getStatistics', 2);
            $oPubConsoleMarketPluginClient->expectCallCount('setWorkAsAccountId', 3);
            
            $oImportMarketStatistics = new MockImportMarketStatistics($this);
            $oImportMarketStatistics->expectAt(0, 'getRegisteredWebsitesIds', array($accountId1));
            $oImportMarketStatistics->expectAt(1, 'getRegisteredWebsitesIds', array($accountId2));
            $oImportMarketStatistics->setReturnValueAt(0, 'getRegisteredWebsitesIds', $websiteUuids1);
            $oImportMarketStatistics->setReturnValueAt(1, 'getRegisteredWebsitesIds', $websiteUuids2);
            $oImportMarketStatistics->expectCallCount('getRegisteredWebsitesIds', 2);
            $oImportMarketStatistics->setReturnValue('getPublisherConsoleApiClient',$oPubConsoleMarketPluginClient);
            $oImportMarketStatistics->expectCallCount('getPublisherConsoleApiClient', 1);
            $oImportMarketStatistics->run();
            
            $oWebsiteStat = OA_Dal::factoryDO('ext_market_web_stats');
            $aWebsiteStat = $oWebsiteStat->getAll();
            $this->assertEqual(2, count ($aWebsiteStat));
            $this->assertEqual('website-manager1-uuidid1', $aWebsiteStat[0]['p_website_id']);
            $this->assertEqual('website-manager2-uuidid2', $aWebsiteStat[1]['p_website_id']);
            
            $lastUpdate = OA_Dal::factoryDO('ext_market_general_pref')
                                ->findAndGetValue($accountId1,
                Plugins_MaintenaceStatisticsTask_oxMarketMaintenance_ImportMarketStatistics::LAST_STATISTICS_VERSION_VARIABLE);
            $this->assertEqual('2',$lastUpdate);
            $lastUpdate = OA_Dal::factoryDO('ext_market_general_pref')
                                ->findAndGetValue($accountId2,
                Plugins_MaintenaceStatisticsTask_oxMarketMaintenance_ImportMarketStatistics::LAST_STATISTICS_VERSION_VARIABLE);
            $this->assertEqual('1',$lastUpdate);
            
            // Clear statistics
            $oWebsiteStat = OA_Dal::factoryDO('ext_market_web_stats');
            $oWebsiteStat->whereAdd('1=1');
            $oWebsiteStat->delete(DB_DATAOBJECT_WHEREADD_ONLY);
            // clear market associations
            $oWebsiteStat = OA_Dal::factoryDO('ext_market_assoc_data');
            $oWebsiteStat->whereAdd('1=1');
            $oWebsiteStat->delete(DB_DATAOBJECT_WHEREADD_ONLY);
        }
    }
    
    function testGetLastUpdateVersionNumber()
    {
        $plgManager = new OX_PluginManager();
        $info = $plgManager->getPackageInfo('openXMarket');
        
        $accountId = 3;
        
        $oImportMarketStatistics = new Plugins_MaintenaceStatisticsTask_oxMarketMaintenance_ImportMarketStatistics();
        $result = $oImportMarketStatistics->getLastUpdateVersionNumber($accountId);
        $this->assertEqual($result, '0');
        
        $last_update = '3434534674722352567';
        
        $oPluginSettings = OA_Dal::factoryDO('ext_market_general_pref');
        $oPluginSettings->account_id = $accountId;
        $oPluginSettings->name = 
            Plugins_MaintenaceStatisticsTask_oxMarketMaintenance_ImportMarketStatistics::LAST_STATISTICS_VERSION_VARIABLE;
        $oPluginSettings->value = $last_update;
        $oPluginSettings->insert();
        
        $result = $oImportMarketStatistics->getLastUpdateVersionNumber($accountId);
        $this->assertEqual($result, $last_update);
    }
    
    function testGetRegisteredWebsitesIds()
    {
        $plgManager = new OX_PluginManager();
        $info = $plgManager->getPackageInfo('openXMarket');

        // Prepare managers and websites
        $aIds = $this->prepareManagersAndWebsites();
        $accountId1 = $aIds['accountId'][0];
        $accountId2 = $aIds['accountId'][1];
        $affiliateId = $aIds['affiliateId'];
        
        $oImportMarketStatistics = new Plugins_MaintenaceStatisticsTask_oxMarketMaintenance_ImportMarketStatistics();
        $aResult = $oImportMarketStatistics->getRegisteredWebsitesIds(null);
        $expected = array();
        $this->assertEqual($expected, $aResult);
        
        $oImportMarketStatistics = new Plugins_MaintenaceStatisticsTask_oxMarketMaintenance_ImportMarketStatistics();
        $aResult = $oImportMarketStatistics->getRegisteredWebsitesIds($accountId1);
        $expected = array();
        $this->assertEqual($expected, $aResult);
        
        $oImportMarketStatistics = new Plugins_MaintenaceStatisticsTask_oxMarketMaintenance_ImportMarketStatistics();
        $aResult = $oImportMarketStatistics->getRegisteredWebsitesIds($accountId2);
        $expected = array();
        $this->assertEqual($expected, $aResult);
        
        // Prepare data
        $doWebsite = OA_Dal::factoryDO('ext_market_website_pref');
        $doWebsite->affiliateid = $affiliateId[1];
        $doWebsite->website_id = 'my-uuid1';
        DataGenerator::generateOne($doWebsite);
        $doWebsite = OA_Dal::factoryDO('ext_market_website_pref');
        $doWebsite->affiliateid = $affiliateId[2];
        $doWebsite->website_id = 'my-uuid2';
        DataGenerator::generateOne($doWebsite);
        $doWebsite = OA_Dal::factoryDO('ext_market_website_pref');
        $doWebsite->affiliateid = $affiliateId[3];
        $doWebsite->website_id = 'my-uuid3';
        DataGenerator::generateOne($doWebsite);

        $aResult = $oImportMarketStatistics->getRegisteredWebsitesIds(null);
        $expected = array('my-uuid1', 'my-uuid2', 'my-uuid3');
        $this->assertEqual($expected, sort($aResult));
        
        $aResult = $oImportMarketStatistics->getRegisteredWebsitesIds(null);
        $expected = array('my-uuid1', 'my-uuid3');
        $this->assertEqual($expected, sort($aResult));
        
        $aResult = $oImportMarketStatistics->getRegisteredWebsitesIds(null);
        $expected = array('my-uuid2');
        $this->assertEqual($expected, sort($aResult));
    }
    
    private function prepareManagersAndWebsites()
    {
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

        $doAffiliate = OA_Dal::factoryDO('affiliates');
        $doAffiliate->agencyid = $agencyId[1];
        $affiliateId[1] = DataGenerator::generateOne($doAffiliate);
        $doAffiliate = OA_Dal::factoryDO('affiliates');
        $doAffiliate->agencyid = $agencyId[2];
        $affiliateId[2] = DataGenerator::generateOne($doAffiliate);
        $doAffiliate = OA_Dal::factoryDO('affiliates');
        $doAffiliate->agencyid = $agencyId[1];
        $affiliateId[3] = DataGenerator::generateOne($doAffiliate);
        
        $result = array(
            'agencyId' => $agencyId,
            'affiliateId' => $affiliateId,
            'accountId' => $accountId);
        return $result;
    }
}