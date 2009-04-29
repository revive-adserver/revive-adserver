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
        
        $plgManager = new OX_PluginManager();
        $info = $plgManager->getPackageInfo('openXMarket');
        if (version_compare($info['version'],'1.0.0-dev','<'))
        {
            // test it for plugin version 0.3.0
            Mock::generatePartial(
                'MockExceptionPublisherConsoleMarketPluginClient',
                'MockPublisherConsoleMarketPluginClient',
                array('oxmStatistics','oxmStatisticsLimited')
            );
            Mock::generatePartial(
                'Plugins_MaintenaceStatisticsTask_oxMarketMaintenance_ImportMarketStatistics',
                'MockImportMarketStatistics',
                array('getPublisherConsoleApiClient')
            );
            
            $oPubConsoleMarketPluginClient = new MockPublisherConsoleMarketPluginClient($this);
            $response1 = "1\t0\n".
                        "website-uuidid1\t120\t100\t2009-12-02T01:00:00\t1234\t123.56\n";
            $response2 = "2\t1\n".
                        "website-uuidid2\t120\t100\t2009-12-02T02:00:00\t4321\t233.44\n";
            $oPubConsoleMarketPluginClient->setReturnValueAt(0, 'oxmStatisticsLimited',$response1);
            $oPubConsoleMarketPluginClient->setReturnValueAt(1, 'oxmStatisticsLimited',$response2);
            $oPubConsoleMarketPluginClient->expectCallCount('oxmStatisticsLimited', 2);
            $oImportMarketStatistics = new MockImportMarketStatistics($this);
            $oImportMarketStatistics->setReturnValue('getPublisherConsoleApiClient',$oPubConsoleMarketPluginClient);
            $oImportMarketStatistics->expectCallCount('getPublisherConsoleApiClient', 1);
            $oImportMarketStatistics->run();
            
            $oWebsiteStat = OA_Dal::factoryDO('ext_market_web_stats');
            $aWebsiteStat = $oWebsiteStat->getAll();
            $this->assertEqual(2, count ($aWebsiteStat));
            $this->assertEqual('website-uuidid1', $aWebsiteStat[0]['p_website_id']);
            $this->assertEqual('website-uuidid2', $aWebsiteStat[1]['p_website_id']);
            
            $oPluginSettings = OA_Dal::factoryDO('ext_market_general_pref');
            $oPluginSettings->get('name', 
                Plugins_MaintenaceStatisticsTask_oxMarketMaintenance_ImportMarketStatistics::LAST_STATISTICS_VERSION_VARIABLE);
            $this->assertEqual(2,$oPluginSettings->value);
            
            // Clear statistics
            $oWebsiteStat = OA_Dal::factoryDO('ext_market_web_stats');
            $oWebsiteStat->whereAdd('1=1');
            $oWebsiteStat->delete(DB_DATAOBJECT_WHEREADD_ONLY);
            
            $oPubConsoleMarketPluginClient = new MockExceptionPublisherConsoleMarketPluginClient();
            $oImportMarketStatistics = new MockImportMarketStatistics($this);
            $oImportMarketStatistics->setReturnValue('getPublisherConsoleApiClient',$oPubConsoleMarketPluginClient);
            $oImportMarketStatistics->expectCallCount('getPublisherConsoleApiClient', 1);
            $oImportMarketStatistics->run();
            
            $oWebsiteStat = OA_Dal::factoryDO('ext_market_web_stats');
            $aWebsiteStat = $oWebsiteStat->getAll();
            $this->assertEqual(1, count ($aWebsiteStat));
            $this->assertEqual('website-uuidid3', $aWebsiteStat[0]['p_website_id']);
            
            $oPluginSettings = OA_Dal::factoryDO('ext_market_general_pref');
            $oPluginSettings->get('name', 
                Plugins_MaintenaceStatisticsTask_oxMarketMaintenance_ImportMarketStatistics::LAST_STATISTICS_VERSION_VARIABLE);
            $this->assertEqual(1,$oPluginSettings->value);
        } else {
            // test it for plugin version 1.0.0
            Mock::generatePartial(
                'MockExceptionPublisherConsoleMarketPluginClient',
                'MockPublisherConsoleMarketPluginClient',
                array('getStatistics')
            );
            Mock::generatePartial(
                'Plugins_MaintenaceStatisticsTask_oxMarketMaintenance_ImportMarketStatistics',
                'MockImportMarketStatistics',
                array('getPublisherConsoleApiClient', 'isPluginActive', 'getRegisteredWebsitesIds')
            );
                        
            // Test when plugin is inactive
            $oImportMarketStatistics = new MockImportMarketStatistics($this);
            $oImportMarketStatistics->setReturnValue('isPluginActive', false);
            $oImportMarketStatistics->expectCallCount('isPluginActive', 1);
            $oImportMarketStatistics->expectCallCount('getRegisteredWebsitesIds', 0);
            $oImportMarketStatistics->expectCallCount('getPublisherConsoleApiClient', 0);
            $oImportMarketStatistics->run();
            
            // Test when plugin is active but there is no registered websites
            $oPubConsoleMarketPluginClient = new MockPublisherConsoleMarketPluginClient($this);
            $oPubConsoleMarketPluginClient->expectCallCount('getStatistics', 0);
            
            $oImportMarketStatistics = new MockImportMarketStatistics($this);
            $oImportMarketStatistics->setReturnValue('isPluginActive', true);
            $oImportMarketStatistics->expectCallCount('isPluginActive', 1);
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
            $oPubConsoleMarketPluginClient->setReturnValueAt(0, 'getStatistics',$response1);
            $oPubConsoleMarketPluginClient->setReturnValueAt(1, 'getStatistics',$response2);
            $oPubConsoleMarketPluginClient->expectCallCount('getStatistics', 2);
            
            $oImportMarketStatistics = new MockImportMarketStatistics($this);
            $oImportMarketStatistics->setReturnValue('isPluginActive', true);
            $oImportMarketStatistics->expectCallCount('isPluginActive', 1);
            $oImportMarketStatistics->setReturnValue('getRegisteredWebsitesIds', array('website-uuidid1', 'website-uuidid2'));
            $oImportMarketStatistics->expectCallCount('getRegisteredWebsitesIds', 1);
            $oImportMarketStatistics->setReturnValue('getPublisherConsoleApiClient',$oPubConsoleMarketPluginClient);
            $oImportMarketStatistics->expectCallCount('getPublisherConsoleApiClient', 1);
            $oImportMarketStatistics->run();
            
            $oWebsiteStat = OA_Dal::factoryDO('ext_market_web_stats');
            $aWebsiteStat = $oWebsiteStat->getAll();
            $this->assertEqual(2, count ($aWebsiteStat));
            $this->assertEqual('website-uuidid1', $aWebsiteStat[0]['p_website_id']);
            $this->assertEqual('website-uuidid2', $aWebsiteStat[1]['p_website_id']);
            
            $oPluginSettings = OA_Dal::factoryDO('ext_market_general_pref');
            $oPluginSettings->get('name', 
                Plugins_MaintenaceStatisticsTask_oxMarketMaintenance_ImportMarketStatistics::LAST_STATISTICS_VERSION_VARIABLE);
            $this->assertEqual('223746234762347623',$oPluginSettings->value);
        }
        
        // Clear statistics
        $oWebsiteStat = OA_Dal::factoryDO('ext_market_web_stats');
        $oWebsiteStat->whereAdd('1=1');
        $oWebsiteStat->delete(DB_DATAOBJECT_WHEREADD_ONLY);
    }
    
    function testGetLastUpdateVersionNumber()
    {
        $plgManager = new OX_PluginManager();
        $info = $plgManager->getPackageInfo('openXMarket');
        if (version_compare($info['version'],'1.0.0-dev','>'))
        {
            $oImportMarketStatistics = new Plugins_MaintenaceStatisticsTask_oxMarketMaintenance_ImportMarketStatistics();
            $result = $oImportMarketStatistics->getLastUpdateVersionNumber();
            $this->assertEqual($result, '0');
            
            $last_update = '3434534674722352567';
            
            $oPluginSettings = OA_Dal::factoryDO('ext_market_general_pref');
            $oPluginSettings->name = 
                Plugins_MaintenaceStatisticsTask_oxMarketMaintenance_ImportMarketStatistics::LAST_STATISTICS_VERSION_VARIABLE;
            $oPluginSettings->value = $last_update;
            $oPluginSettings->insert();
            
            $result = $oImportMarketStatistics->getLastUpdateVersionNumber();
            $this->assertEqual($result, $last_update);
        }
    }
    
    function testGetRegisteredWebsitesIds()
    {
        $plgManager = new OX_PluginManager();
        $info = $plgManager->getPackageInfo('openXMarket');
        if (version_compare($info['version'],'1.0.0-dev','>'))
        {
            $oImportMarketStatistics = new Plugins_MaintenaceStatisticsTask_oxMarketMaintenance_ImportMarketStatistics();
            $aResult = $oImportMarketStatistics->getRegisteredWebsitesIds();
            $expected = array();
            $this->assertEqual($expected, $aResult);
            
            // Prepare data
            $doWebsite = OA_Dal::factoryDO('ext_market_website_pref');
            $doWebsite->affiliateid = 1;
            $doWebsite->website_id = 'my-uuid1';
            DataGenerator::generateOne($doWebsite);
            $doWebsite = OA_Dal::factoryDO('ext_market_website_pref');
            $doWebsite->affiliateid = 2;
            $doWebsite->website_id = 'my-uuid2';
            DataGenerator::generateOne($doWebsite);
            $doWebsite = OA_Dal::factoryDO('ext_market_website_pref');
            $doWebsite->affiliateid = 3;
            $doWebsite->website_id = 'my-uuid3';
            DataGenerator::generateOne($doWebsite);
    
            $aResult = $oImportMarketStatistics->getRegisteredWebsitesIds();
            $expected = array('my-uuid1', 'my-uuid2', 'my-uuid3');
            $this->assertEqual($expected, sort($aResult));
        }
    }
}