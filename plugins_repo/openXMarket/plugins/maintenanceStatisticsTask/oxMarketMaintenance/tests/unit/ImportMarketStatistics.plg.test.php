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
        DataGenerator::cleanUp();
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
            array('getStatistics', 'setWorkAsAccountId', 'getAdvertiserInfos')
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
        
        //////////////////////////////////////////////
        // Test for multiple manager accounts
        // Prepare managers and websites
        $aIds = $this->prepareManagersAndWebsites();
        $accountId1 = (int)$aIds['accountId'][1];
        $accountId2 = (int)$aIds['accountId'][2];
        $affiliateId = $aIds['affiliateId'];
        $campaignId = $aIds['campaignId'];
        $bannerId = $aIds['bannerId'];
        
        // Register managers to market
        $doMarketAssoc = OA_Dal::factoryDO('ext_market_assoc_data');
        $doMarketAssoc->account_id = $adminAccountId;
        $doMarketAssoc->find();
        $doMarketAssoc->status = Plugins_admin_oxMarket_PublisherConsoleMarketPluginClient::ACCOUNT_DISABLED_STATUS;
        $doMarketAssoc->update();
        
        // Register managers to market
        $doMarketAssoc = OA_Dal::factoryDO('ext_market_assoc_data');
        $doMarketAssoc->account_id = $accountId1;
        $doMarketAssoc->status = Plugins_admin_oxMarket_PublisherConsoleMarketPluginClient::LINK_IS_VALID_STATUS;
        DataGenerator::generateOne($doMarketAssoc);
        
        $doMarketAssoc = OA_Dal::factoryDO('ext_market_assoc_data');
        $doMarketAssoc->account_id = $accountId2;
         $doMarketAssoc->status = Plugins_admin_oxMarket_PublisherConsoleMarketPluginClient::LINK_IS_VALID_STATUS;
        DataGenerator::generateOne($doMarketAssoc);
        
        $websites = array(
            'website-manager1-uuidid1' => 1,
            'website-manager2-uuidid2' => 2,
            'website-manager1-uuidid3' => 3,
        );
        
        foreach($websites as $uuid => $websiteId) {
            $doWebsite = OA_Dal::factoryDO('ext_market_website_pref');
            $doWebsite->affiliateid = $websiteId;
            $doWebsite->website_id = $uuid;
            DataGenerator::generateOne($doWebsite);
        }
        
        // 1) 
        // expect lastUpdate = 0
        // check with empty channel IDs, they are registered to zone_id = 0
        // normal valid data without advertiser IDs
        // increase lastUpdate
        
        $response1 = "1\t1\n".
                    "website-manager1-uuidid1\t120\t100\t2009-12-02T01:00:00\t100\t11.11\t1000\t10\t\t\t\n";
        $response2 = "223746234762347623\t1\n".
                    "website-manager2-uuidid2\t120\t100\t2009-12-02T02:00:00\t100\t11.11\t1000\t10\t\t\t\n";
        $websiteUuids1 = array('website-manager1-uuidid1');
        $websiteUuids2 = array('website-manager2-uuidid2');
        $oPubConsoleMarketPluginClient = new MockPublisherConsoleMarketPluginClient($this);
        $oPubConsoleMarketPluginClient->expectAt(0, 'getStatistics', array('0', $websiteUuids1));
        $oPubConsoleMarketPluginClient->expectAt(1, 'getStatistics', array('0', $websiteUuids2));
        $oPubConsoleMarketPluginClient->setReturnValueAt(0, 'getStatistics',$response1);
        $oPubConsoleMarketPluginClient->setReturnValueAt(1, 'getStatistics',$response2);
        $oPubConsoleMarketPluginClient->expectCallCount('getStatistics', 2);
        
        $oPubConsoleMarketPluginClient->expectCallCount('getAdvertiserInfos', 0);

        $oPubConsoleMarketPluginClient->expectAt(0, 'setWorkAsAccountId', array($accountId1));
        $oPubConsoleMarketPluginClient->expectAt(1, 'setWorkAsAccountId', array($accountId2));
        $oPubConsoleMarketPluginClient->expectAt(2, 'setWorkAsAccountId', array(null));
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
        
        $lastUpdate = OA_Dal::factoryDO('ext_market_general_pref')
                            ->findAndGetValue($accountId1,
            Plugins_MaintenaceStatisticsTask_oxMarketMaintenance_ImportMarketStatistics::LAST_STATISTICS_VERSION_VARIABLE);
        $this->assertEqual('1',$lastUpdate);
        $lastUpdate = OA_Dal::factoryDO('ext_market_general_pref')
                            ->findAndGetValue($accountId2,
            Plugins_MaintenaceStatisticsTask_oxMarketMaintenance_ImportMarketStatistics::LAST_STATISTICS_VERSION_VARIABLE);
        $this->assertEqual('223746234762347623',$lastUpdate);

        // 2) 
        $response1 = "2\t1\n".
                    // now records with a non empty channel ID
                    "website-manager1-uuidid1\t120\t100\t2009-12-02T02:00:00\t100\t11.11\t1000\t10\toxpv1:1-1-1-1-111\tmarket-advertiser-id-1\t\n";
        $response2 = "2237462347623476231\t1\n".
                    // test with a website_id belonging to a different manager
                    "website-manager2-uuidid2\t120\t100\t2009-12-02T03:00:00\t100\t11.11\t1000\t10\toxpv1:1-1-1-1-1\tmarket-advertiser-id-1\t\n".
                    // normal valid data with a couple of advertiser IDs
                    "website-manager2-uuidid2\t120\t100\t2009-12-02T03:00:00\t100\t11.11\t1000\t10\toxpv1:1-1-1-2-5\tmarket-advertiser-id-1\t\n".
                    "website-manager2-uuidid2\t120\t100\t2009-12-02T03:00:00\t100\t11.11\t1000\t10\toxpv1:1-1-1-2-6\tmarket-advertiser-id-2\t\n";
        $oPubConsoleMarketPluginClient = new MockPublisherConsoleMarketPluginClient($this);
        $oPubConsoleMarketPluginClient->expectAt(0, 'getStatistics', array('1', $websiteUuids1));
        $oPubConsoleMarketPluginClient->expectAt(1, 'getStatistics', array('223746234762347623', $websiteUuids2));
        $oPubConsoleMarketPluginClient->setReturnValueAt(0, 'getStatistics',$response1);
        $oPubConsoleMarketPluginClient->setReturnValueAt(1, 'getStatistics',$response2);
        $oPubConsoleMarketPluginClient->expectCallCount('getStatistics', 2);

        $oPubConsoleMarketPluginClient->expectAt(0, 'getAdvertiserInfos', array(array('market-advertiser-id-1', 'market-advertiser-id-2')));
        $oPubConsoleMarketPluginClient->setReturnValueAt(0, 'getAdvertiserInfos', array());
        $oPubConsoleMarketPluginClient->expectCallCount('getAdvertiserInfos', 1);

        $oPubConsoleMarketPluginClient->expectAt(0, 'setWorkAsAccountId', array($accountId1));
        $oPubConsoleMarketPluginClient->expectAt(1, 'setWorkAsAccountId', array($accountId2));
        $oPubConsoleMarketPluginClient->expectAt(2, 'setWorkAsAccountId', array(null));
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
        
        
        // 3)
        $response1 = "3\t1\n".
                    // republish data
                    "website-manager1-uuidid1\t120\t100\t2009-12-02T02:00:00\t10000\t1100.11\t100000\t1000\toxpv1:1-1-1-1-111\tmarket-advertiser-id-1\t\n";
        $response2 = "22374623476234762310\t0\n".
                    // invalid (channel says website id 1 but website id 2 expected for this UUID)
                    "website-manager2-uuidid2\t120\t100\t2009-12-02T02:00:00\t10000\t1100.11\t100000\t1000\toxpv1:1-1-1-1-1\tmarket-advertiser-id-1\t\n";
        $response3 = "223746234762347623100\t1\n".
                    // new advertiser ID market-advertiser-id-3
                    "website-manager2-uuidid2\t120\t100\t2009-12-02T04:00:00\t100\t11.11\t1000\t10\toxpv1:1-1-1-2-1\tmarket-advertiser-id-3\t\n".
                    // known advertiser ID market-advertiser-id-2
                    "website-manager2-uuidid2\t120\t100\t2009-12-02T04:00:00\t100\t11.11\t1000\t10\toxpv1:1-1-1-2-10\tmarket-advertiser-id-2\t\n";
        $oPubConsoleMarketPluginClient = new MockPublisherConsoleMarketPluginClient($this);
        $oPubConsoleMarketPluginClient->expectAt(0, 'getStatistics', array('2', $websiteUuids1));
        $oPubConsoleMarketPluginClient->expectAt(1, 'getStatistics', array('2237462347623476231', $websiteUuids2));
        $oPubConsoleMarketPluginClient->expectAt(2, 'getStatistics', array('22374623476234762310', $websiteUuids2));
        $oPubConsoleMarketPluginClient->setReturnValueAt(0, 'getStatistics',$response1);
        $oPubConsoleMarketPluginClient->setReturnValueAt(1, 'getStatistics',$response2);
        $oPubConsoleMarketPluginClient->setReturnValueAt(2, 'getStatistics',$response3);
        $oPubConsoleMarketPluginClient->expectCallCount('getStatistics', 3);

        $oPubConsoleMarketPluginClient->expectAt(0, 'getAdvertiserInfos', array(array('market-advertiser-id-1','market-advertiser-id-2','market-advertiser-id-3')));
        $oPubConsoleMarketPluginClient->setReturnValueAt(0, 'getAdvertiserInfos', array());
        $oPubConsoleMarketPluginClient->expectCallCount('getAdvertiserInfos', 1);

        $oPubConsoleMarketPluginClient->expectAt(0, 'setWorkAsAccountId', array($accountId1));
        $oPubConsoleMarketPluginClient->expectAt(1, 'setWorkAsAccountId', array($accountId2));
        $oPubConsoleMarketPluginClient->expectAt(2, 'setWorkAsAccountId', array(null));
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
        
        //TODO test the getgzip
        // Test stats are correctly inserted and republished
        $oWebsiteStat = OA_Dal::factoryDO('ext_market_stats');
        $aWebsiteStat = $oWebsiteStat->getAll();
        
        $expectedStats = array(
            array(
                'date_time' => '2009-12-02 01:00:00',
                'website_id' => '1',
                'zone_id' => '0',
                'ad_id' => $bannerId[1],
                'market_advertiser_id' => '',
                'ad_width' => '100',
                'ad_height' => '120',
                'requests' => '1000',
                'impressions' => '100',
                'clicks' => '10',
                'revenue' => '11.11',
            ),
            array(
                'date_time' => '2009-12-02 02:00:00',
                'website_id' => '2',
                'zone_id' => '0',
                'ad_id' => $bannerId[2],
                'market_advertiser_id' => '',
                'ad_width' => '100',
                'ad_height' => '120',
                'requests' => '1000',
                'impressions' => '100',
                'clicks' => '10',
                'revenue' => '11.11',
            ), 
            //republished
            array(
                'date_time' => '2009-12-02 02:00:00',
                'website_id' => '1',
                'zone_id' => '111',
                'ad_id' => $bannerId[1],
                'market_advertiser_id' => 'market-advertiser-id-1',
                'ad_width' => '100',
                'ad_height' => '120',
                'requests' => '100000',
                'impressions' => '10000',
                'clicks' => '1000',
                'revenue' => '1100.11',
            ), 
            array(
                'date_time' => '2009-12-02 03:00:00',
                'website_id' => '2',
                'zone_id' => '5',
                'ad_id' => $bannerId[2],
                'market_advertiser_id' => 'market-advertiser-id-1',
                'ad_width' => '100',
                'ad_height' => '120',
                'requests' => '1000',
                'impressions' => '100',
                'clicks' => '10',
                'revenue' => '11.11',
            ), 
            array(
                'date_time' => '2009-12-02 03:00:00',
                'website_id' => '2',
                'zone_id' => '6',
                'ad_id' => $bannerId[2],
                'market_advertiser_id' => 'market-advertiser-id-2',
                'ad_width' => '100',
                'ad_height' => '120',
                'requests' => '1000',
                'impressions' => '100',
                'clicks' => '10',
                'revenue' => '11.11',
            ), 
            array(
                'date_time' => '2009-12-02 04:00:00',
                'website_id' => '2',
                'zone_id' => '1',
                'ad_id' => $bannerId[2],
                'market_advertiser_id' => 'market-advertiser-id-3',
                'ad_width' => '100',
                'ad_height' => '120',
                'requests' => '1000',
                'impressions' => '100',
                'clicks' => '10',
                'revenue' => '11.11',
            ), 
            array(
                'date_time' => '2009-12-02 04:00:00',
                'website_id' => '2',
                'zone_id' => '10',
                'ad_id' => $bannerId[2],
                'market_advertiser_id' => 'market-advertiser-id-2',
                'ad_width' => '100',
                'ad_height' => '120',
                'requests' => '1000',
                'impressions' => '100',
                'clicks' => '10',
                'revenue' => '11.11',
            ), 
        );
        function array_recursive_sort(&$a) {
            foreach($a as &$row) {
                ksort($row);
            }
        }
        array_recursive_sort($aWebsiteStat);
        array_recursive_sort($expectedStats);
        $this->assertEqual($aWebsiteStat, $expectedStats);
        var_dump($aWebsiteStat);
        var_dump($expectedStats);
        
        // Clear statistics
        $oWebsiteStat = OA_Dal::factoryDO('ext_market_stats');
        $oWebsiteStat->whereAdd('1=1');
        $oWebsiteStat->delete(DB_DATAOBJECT_WHEREADD_ONLY);
        // clear market associations
        $oWebsiteStat = OA_Dal::factoryDO('ext_market_assoc_data');
        $oWebsiteStat->whereAdd('1=1');
        $oWebsiteStat->delete(DB_DATAOBJECT_WHEREADD_ONLY);
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
        $campaignId = $aIds['campaignId'];
        $bannerId = $aIds['bannerId'];
        
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
    
    
    function testShouldSkipAccount()
    {
        // We can mockup classes after plugin is installed 
        require_once dirname(dirname(__FILE__)) . '/util/ImportMarketStatisticsTestTask.php';
        
        $oImportMarketStatistics = new ImportMarketStatisticsTestTask();
        // Prepare test data
        $GLOBALS['_MAX']['CONF']['oxMarket']['multipleAccountsMode'] = true;
        $GLOBALS['_MAX']['CONF']['oxMarket']['allowSkipAccountsInImportStats'] = true;
        $GLOBALS['_MAX']['CONF']['oxMarket']['maxSkippingPeriodInDays'] = 7;
        $accountId = 4;
        $oImportMarketStatistics->setActiveAccounts(array());
        
        // didn't update recently this account, skipping not allowed
        $this->assertFalse($oImportMarketStatistics->shouldSkipAccount($accountId));
        
        // set import stats date to 4 days ago
        $oDate = new Date();
        $oDate->subtractSpan(new Date_Span(4 * 86400));
        $oPluginSettings = OA_Dal::factoryDO('ext_market_general_pref');
        $oPluginSettings->insertOrUpdateValue($accountId, 
                            ImportMarketStatisticsTestTask::LAST_IMPORT_STATS_DATE, $oDate->getDate());
                            
        // now we can skipp account
        $this->assertTrue($oImportMarketStatistics->shouldSkipAccount($accountId));
        
        $GLOBALS['_MAX']['CONF']['oxMarket']['maxSkippingPeriodInDays'] = 3;
        // allowed period is shorten than last update 
        $this->assertFalse($oImportMarketStatistics->shouldSkipAccount($accountId));
        // restore period
        $GLOBALS['_MAX']['CONF']['oxMarket']['maxSkippingPeriodInDays'] = 7;
        
        // account is active
        $oImportMarketStatistics->setActiveAccounts(array($accountId => $accountId));
        $this->assertFalse($oImportMarketStatistics->shouldSkipAccount($accountId));
        // unset active account
        $oImportMarketStatistics->setActiveAccounts(array());
        
        // skipping is not allowed
        $GLOBALS['_MAX']['CONF']['oxMarket']['allowSkipAccountsInImportStats'] = false; 
        $this->assertFalse($oImportMarketStatistics->shouldSkipAccount($accountId));
        // restore setting
        $GLOBALS['_MAX']['CONF']['oxMarket']['allowSkipAccountsInImportStats'] = true;
        
        // this is not MultipleAccountsMode
        $GLOBALS['_MAX']['CONF']['oxMarket']['multipleAccountsMode'] = false;
        $this->assertFalse($oImportMarketStatistics->shouldSkipAccount($accountId));
    }
    
    
    function testGetActiveAccounts()
    {
        // We can mockup classes after plugin is installed 
        require_once dirname(dirname(__FILE__)) . '/util/ImportMarketStatisticsTestTask.php';
        
        // Should get empty list        
        $oImportMarketStatistics = new ImportMarketStatisticsTestTask();
        $aResult = $oImportMarketStatistics->getActiveAccounts();
        $this->assertEqual($aResult, array());
        
        // Should use stored value
        $aTestAccounts = array( 1=>1, 2=>2);
        $oImportMarketStatistics->setActiveAccounts($aTestAccounts );
        $aResult = $oImportMarketStatistics->getActiveAccounts();
        $this->assertEqual($aResult, $aTestAccounts);

        // create test data
        // create managers, campaigns, banners
        for ($i=1; $i<=2; $i++) {
            $doAgency = OA_Dal::factoryDO('agency');
            $agencyId[$i] = DataGenerator::generateOne($doAgency);
            $doAgency->get($agencyId[$i]);
            $accountId[$i] = $doAgency->account_id;
            $doClients = OA_Dal::factoryDO('clients');
            $doClients->agencyid = $agencyId[$i];
            $clientsId[$i] = DataGenerator::generateOne($doClients);
            $doCampaigns = OA_Dal::factoryDO('campaigns');
            $doCampaigns->clientid = $clientsId[$i];
            $campaignsId[$i] = DataGenerator::generateOne($doCampaigns);
            $doBanners = OA_Dal::factoryDO('banners');
            $doBanners->campaignid = $campaignsId[$i];
            $bannersId[$i] = DataGenerator::generateOne($doBanners);
        }
        
        $oOldDate = new Date();
        $oOldDate->subtractSpan(new Date_Span(8 * 86400));
        $oRecentDate = new Date();
        $oRecentDate->subtractSpan(new Date_Span(3 * 86400));
            
        // add stats
        $doStats = OA_Dal::factoryDO('data_summary_ad_hourly');
        $doStats->date_time = $oOldDate->format('%Y-%m-%d %H:%M:%S');
        $doStats->ad_id = $bannersId[1];
        DataGenerator::generateOne($doStats);
        $doStats = OA_Dal::factoryDO('data_summary_ad_hourly');
        $doStats->date_time = $oRecentDate->format('%Y-%m-%d %H:%M:%S');
        $doStats->ad_id = $bannersId[2];
        DataGenerator::generateOne($doStats);
        
        $oImportMarketStatistics = new ImportMarketStatisticsTestTask();
        $aResult = $oImportMarketStatistics->getActiveAccounts();
        $aExpected = array( $accountId[2] => $accountId[2] );
        $this->assertEqual($aResult, $aExpected);
    }
    
    
    function testSetLastUpdateDate()
    {
         // We can mockup classes after plugin is installed 
        require_once dirname(dirname(__FILE__)) . '/util/ImportMarketStatisticsTestTask.php';
        
        $oImportMarketStatistics = new ImportMarketStatisticsTestTask();
        $oImportMarketStatistics->setLastUpdateDate(1);
                    
        $value = OA_Dal::factoryDO('ext_market_general_pref')
                 ->findAndGetValue($accountId, ImportMarketStatisticsTestTask::LAST_IMPORT_STATS_DATE);
        $oDate = new Date($value);
        $oSpan = new Date_Span();
        $oSpan->setFromDateDiff(new Date(), $oDate);
        $this->assertTrue($oSpan->toSeconds()<5);
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
            'accountId' => $accountId,
            // one market advertiser per manager
            'advertiserId' => array(1 => '1', 2=> '2'),
            // we are interested by the market optin campaign (even though 2 market campaigns are created on plugin install)
            'campaignId' => array(1 => '1', 2=> '3'),
            // the banner Ids of this market optin campaign
            'bannerId' => array(1 => '1', 2 => '3'),
        );
        return $result;
    }
}