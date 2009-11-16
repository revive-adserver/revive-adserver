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
require_once MAX_PATH . '/lib/OX/M2M/M2MProtectedRpc.php';
require_once MAX_PATH . '/lib/OX/M2M/XmlRpcExecutor.php';
require_once MAX_PATH . '/lib/OA/Central/M2MProtectedRpc.php';

require_once dirname(__FILE__) . '/../../../../../../var/config.php';
require_once OX_MARKET_LIB_PATH . '/OX/oxMarket/M2M/PearXmlRpcCustomClientExecutor.php';

/**
 * A class for testing the Publisher Console Client
 *
 * @package    OpenXPlugin
 * @subpackage TestSuite
 * @author     Lukasz Wikierski <lukasz.wikierski@openx.org>
 */
class Plugins_admin_oxMarket_PublisherConsoleClientTest extends UnitTestCase
{

    
    function __construct()
    {
        parent::__construct();
        Mock::generatePartial(
            'OX_oxMarket_M2M_PearXmlRpcCustomClientExecutor',
            'PartialMock_PearXmlRpcCustomClientExecutor',
            array('call')
        );
        Mock::generatePartial(
            'OA_Central_M2MProtectedRpc',
            'PartialMockOA_Central_M2MProtectedRpc',
            array('call')
        );       
        $oPkgMgr = new OX_PluginManager();
        TestEnv::uninstallPluginPackage('openXMarket',false);
        TestEnv::installPluginPackage('openXMarket',false);
    }
    
    function __destruct()
    {
        TestEnv::uninstallPluginPackage('openXMarket',false);
    }
    
    function setUp()
    {

    }

    function tearDown()
    {
        
    }

    function testCreateAccountBySsoCred()
    {
        $username = 'testUsername';
        $password = 'test';
        $md5password = md5($password);
        $ph = 'platform_hash';
        
        $oXmlRpcClient = new PartialMock_PearXmlRpcCustomClientExecutor($this);
        $oM2MXmlRpc = new PartialMockOA_Central_M2MProtectedRpc($this);
        
        $call = array('createAccountBySsoCred', array($username, $md5password, $ph));
        $response = array('accountUuid' => 'pub-acc-id', 'apiKey' => 'api-key');

        $oXmlRpcClient->expectOnce('call', $call);
        $oXmlRpcClient->setReturnValue('call', $response);
        
        $oPCClient = 
            new Plugins_admin_oxMarket_PublisherConsoleClient($oM2MXmlRpc, $oXmlRpcClient);
            
        $result = $oPCClient->createAccountBySsoCred($username, $password, $ph);
        
        $this->assertEqual($result, $response);
    }
    

    function testCreateAccount()
    {
        $email = 'email@test.org';
        $username = 'testUsername';
        $md5password = md5('test');
        $captcha = 'captcha';
        $captcha_random = 'captcha_random';
        $captcha_ph = 'captcha_ph';
        
        $oXmlRpcClient = new PartialMock_PearXmlRpcCustomClientExecutor($this);
        $oM2MXmlRpc = new PartialMockOA_Central_M2MProtectedRpc($this);

        // plugin 1.0.0
        $call = array('createAccount', array($email, $username, $md5password, $captcha, $captcha_random, $captcha_ph));
    
        $response = array('accountUuid' => 'pub-acc-id', 'apiKey' => 'api-key');
        
        $oXmlRpcClient->expectOnce('call', $call);
        $oXmlRpcClient->setReturnValue('call', $response);
        
        $oPCClient = 
            new Plugins_admin_oxMarket_PublisherConsoleClient($oM2MXmlRpc, $oXmlRpcClient);
            
        $result = $oPCClient->createAccount($email, $username, $md5password, $captcha, $captcha_random, $captcha_ph);
        
        $this->assertEqual($result, $response);
    }
    
    
    function testLinkHostedAccount()
    {
        $oXmlRpcClient = new PartialMock_PearXmlRpcCustomClientExecutor($this);
        $oM2MXmlRpc = new PartialMockOA_Central_M2MProtectedRpc($this);
        $sso_id = 123;
        $username = 'testuser';
        $email = 'test@email.com';
        
        $call = array('linkHostedAccount', array($sso_id, $username, $email));
        $response = array('accountUuid' => 'pub-acc-id', 'apiKey' => 'api-key');

        $oM2MXmlRpc->expectOnce('call', $call);
        $oM2MXmlRpc->setReturnValue('call', $response);
        
        $oPCClient = 
            new Plugins_admin_oxMarket_PublisherConsoleClient($oM2MXmlRpc, $oXmlRpcClient);
        
        $result = $oPCClient->linkHostedAccount($sso_id, $username, $email);
        
        $this->assertEqual($result, $response);
    }
    
    
    function testGetStatistics()
    {    
        $apiKey = 'testApiKey';
        $lastUpdate = '1234';
        $aWebsitesIds = array ('website_id1', 'website_id2');
    
        $oXmlRpcClient = new PartialMock_PearXmlRpcCustomClientExecutor($this);
        $oM2MXmlRpc = new PartialMockOA_Central_M2MProtectedRpc($this);
    
        $call = array('getStatistics', array($apiKey, $lastUpdate, $aWebsitesIds));
        $response = '1234\t0\n';

        $oXmlRpcClient->expectOnce('call', $call);
        $oXmlRpcClient->setReturnValue('call', $response);
        
        $oPCClient = 
            new Plugins_admin_oxMarket_PublisherConsoleClient($oM2MXmlRpc, $oXmlRpcClient);
        $oPCClient->setApiKey($apiKey);
        
        $result = $oPCClient->getStatistics($lastUpdate, $aWebsitesIds);
        
        $this->assertEqual($result, $response);
    }
    
    function testNewWebsite()
    {    
        $websiteUrl = 'http:\\test.url';
        $websiteName = 'test website';
        $website_id = 'thorium_website_id';
        $apiKey = 'testApiKey';
    
        $oXmlRpcClient = new PartialMock_PearXmlRpcCustomClientExecutor($this);
        $oM2MXmlRpc = new PartialMockOA_Central_M2MProtectedRpc($this);
    
        $call = array('registerWebsite', array($apiKey, $websiteUrl, $websiteName));
        $response = $website_id;

        $oXmlRpcClient->expectOnce('call', $call);
        $oXmlRpcClient->setReturnValue('call', $response);
        
        $oPCClient = 
            new Plugins_admin_oxMarket_PublisherConsoleClient($oM2MXmlRpc, $oXmlRpcClient);
            
        try {
            $result = $oPCClient->newWebsite($websiteUrl, $websiteName);
            $this->fail('should have thrown exception');
        } catch (Plugins_admin_oxMarket_PublisherConsoleClientException $e) {
            $this->assertEqual($e->getMessage(),
                               'apiKey can not be null');
        }
        
        $oPCClient->setApiKey($apiKey);
        $result = $oPCClient->newWebsite($websiteUrl, $websiteName);
        
        $this->assertEqual($result, $response);
    }
    
    function testUpdateWebsite()
    {    
        $websiteUrl = 'http:\\test.url';
        $website_id = 'thorium_website_id';
        $websiteName = 'web name';
        $apiKey = 'testApiKey';
        $att_ex = array(); 
        $cat_ex = array(1,2);
        $typ_ex = array(3);
    
        $oXmlRpcClient = new PartialMock_PearXmlRpcCustomClientExecutor($this);
        $oM2MXmlRpc = new PartialMockOA_Central_M2MProtectedRpc($this);
    
        $call1 = array('updateWebsite', array($apiKey, $website_id, $websiteUrl, $att_ex, $cat_ex, $typ_ex));
        $call2 = array('updateWebsite', array($apiKey, $website_id, $websiteUrl, $att_ex, $cat_ex, $typ_ex, $websiteName));
        $response = $website_id;

        $oXmlRpcClient->expectAt(0, 'call', $call1);
        $oXmlRpcClient->expectAt(1, 'call', $call2);
        $oXmlRpcClient->setReturnValue('call', $response);
        $oXmlRpcClient->expectCallCount('call', 2);
        
        $oPCClient = 
            new Plugins_admin_oxMarket_PublisherConsoleClient($oM2MXmlRpc, $oXmlRpcClient);
            
        try {
            $result = $oPCClient->updateWebsite($website_id, $websiteUrl, $att_ex, $cat_ex, $typ_ex);
            $this->fail('should have thrown exception');
        } catch (Plugins_admin_oxMarket_PublisherConsoleClientException $e) {
            $this->assertEqual($e->getMessage(),
                               'apiKey can not be null');
        }
        
        $oPCClient->setApiKey($apiKey);
        $result = $oPCClient->updateWebsite($website_id, $websiteUrl, $att_ex, $cat_ex, $typ_ex);
        $this->assertEqual($result, $response);
        
        $result = $oPCClient->updateWebsite($website_id, $websiteUrl, $att_ex, $cat_ex, $typ_ex, $websiteName);
        $this->assertEqual($result, $response);
        
    }
    
    function testGetApiKey()
    {
        $username = 'testUsername';
        $password = 'test';
        $md5password = md5($password);
        
        $oXmlRpcClient = new PartialMock_PearXmlRpcCustomClientExecutor($this);
        $oM2MXmlRpc = new PartialMockOA_Central_M2MProtectedRpc($this);
        
        $call = array('getApiKey', array($username, $md5password));
        $response = 'api-key';

        $oXmlRpcClient->expectOnce('call', $call);
        $oXmlRpcClient->setReturnValue('call', $response);
        
        $oPCClient = 
            new Plugins_admin_oxMarket_PublisherConsoleClient($oM2MXmlRpc, $oXmlRpcClient);
            
        $result = $oPCClient->getApiKey($username, $password);
        
        $this->assertEqual($result, $response);
    }
    
    
    function testGetApiKeyByM2MCred()
    {
        $oXmlRpcClient = new PartialMock_PearXmlRpcCustomClientExecutor($this);
        $oM2MXmlRpc = new PartialMockOA_Central_M2MProtectedRpc($this);
        $pubAccountId = 'pubAccountId';
        
        $call = array('getApiKeyByM2MCred', array($pubAccountId));
        $response = 'api-key';

        $oM2MXmlRpc->expectOnce('call', $call);
        $oM2MXmlRpc->setReturnValue('call', $response);
        
        $oPCClient = 
            new Plugins_admin_oxMarket_PublisherConsoleClient($oM2MXmlRpc, $oXmlRpcClient);
        $oPCClient->setPublisherAccountId($pubAccountId);
        
        $result = $oPCClient->getApiKeyByM2MCred();
        
        $this->assertEqual($result, $response);
    }
    
    
    function testGenerateApiKey()
    {
        $username = 'testUsername';
        $password = 'test';
        $md5password = md5($password);
        
        $oXmlRpcClient = new PartialMock_PearXmlRpcCustomClientExecutor($this);
        $oM2MXmlRpc = new PartialMockOA_Central_M2MProtectedRpc($this);
        
        $call = array('generateApiKey', array($username, $md5password));
        $response = 'api-key';

        $oXmlRpcClient->expectOnce('call', $call);
        $oXmlRpcClient->setReturnValue('call', $response);
        
        $oPCClient = 
            new Plugins_admin_oxMarket_PublisherConsoleClient($oM2MXmlRpc, $oXmlRpcClient);
            
        $result = $oPCClient->generateApiKey($username, $password);
        
        $this->assertEqual($result, $response);
    }
    
    function testGetAccountStatus()
    {    
        $apiKey = 'testApiKey';
        
        $oXmlRpcClient = new PartialMock_PearXmlRpcCustomClientExecutor($this);
        $oM2MXmlRpc = new PartialMockOA_Central_M2MProtectedRpc($this);
    
        $call = array('getAccountStatus', array($apiKey));
        $response = 0;

        $oXmlRpcClient->expectOnce('call', $call);
        $oXmlRpcClient->setReturnValue('call', $response);
        
        $oPCClient = 
            new Plugins_admin_oxMarket_PublisherConsoleClient($oM2MXmlRpc, $oXmlRpcClient);
            
        try {
            $result = $oPCClient->getAccountStatus($websiteUrl);
            $this->fail('should have thrown exception');
        } catch (Plugins_admin_oxMarket_PublisherConsoleClientException $e) {
            $this->assertEqual($e->getMessage(),
                               'apiKey can not be null');
        }
        
        $oPCClient->setApiKey($apiKey);
        $result = $oPCClient->getAccountStatus($websiteUrl);
        
        $this->assertEqual($result, $response);
    }

    
    function testIsSsoUserNameAvailable()
    {
        $userName1 = 'ada';
        $userName2 = 'adam';
        $call1 = array('isSsoUserNameAvailable', array($userName1));
        $call2 = array('isSsoUserNameAvailable', array($userName2));
        
        $oXmlRpcClient = new PartialMock_PearXmlRpcCustomClientExecutor($this);
        $oXmlRpcClient->expectArgumentsAt(0, 'call', $call1);
        $oXmlRpcClient->setReturnValueAt(0, 'call', false);
        $oXmlRpcClient->expectArgumentsAt(1, 'call', $call2);
        $oXmlRpcClient->setReturnValueAt(1, 'call', true);
        $oM2MXmlRpc = new PartialMockOA_Central_M2MProtectedRpc($this);
        
        $oPCClient = 
            new Plugins_admin_oxMarket_PublisherConsoleClient($oM2MXmlRpc, $oXmlRpcClient);
        
        $result = $oPCClient->isSsoUserNameAvailable($userName1);
        $this->assertFalse($result);
        $result = $oPCClient->isSsoUserNameAvailable($userName2);
        $this->assertTrue($result);
    }
    
    
    function testGetAdvertiserInfos()
    {
        // Prepare XmlRpc client mockup and test response
        $response = array( 
           '5f7d1600-d2aa-11de-8a39-0800200c9a66' => 'Advertiser 1',
           '02d2db84-572d-42a1-be8b-77daab4d8f32' => 'Advertiser 2');
        $apiKey = 'testApiKey';
        $advUuids = array_keys($response);
        $oXmlRpcClient = new PartialMock_PearXmlRpcCustomClientExecutor($this);
        $oXmlRpcClient->expectArgumentsAt(0, 'call', array('getAdvertiserInfos', array($apiKey, $advUuids)));
        $oXmlRpcClient->setReturnValueAt(0, 'call', $response);
        $oM2MXmlRpc = new PartialMockOA_Central_M2MProtectedRpc($this);
        
        // Create PubConsole API client 
        $oPCClient = 
            new Plugins_admin_oxMarket_PublisherConsoleClient($oM2MXmlRpc, $oXmlRpcClient);
        $oPCClient->setApiKey($apiKey);
            
        // Test call
        $result = $oPCClient->getAdvertiserInfos($advUuids);
        $this->assertEqual($result, $response);
    }
  
    
    function testGetCreativeAttributes()
    {
        // Prepare XmlRpc client mockup and test response
        $response = array( 
           '1' => 'Alcohol',
           '2' => 'Audio/Video',
           '3' => 'Dating/Romance');
        $oXmlRpcClient = new PartialMock_PearXmlRpcCustomClientExecutor($this);
        $oXmlRpcClient->expectArgumentsAt(0, 'call', array('dictionary.getCreativeAttributes', array()));
        $oXmlRpcClient->setReturnValueAt(0, 'call', $response);
        $oM2MXmlRpc = new PartialMockOA_Central_M2MProtectedRpc($this);
        
        // Create PubConsole API client 
        $oPCClient = 
            new Plugins_admin_oxMarket_PublisherConsoleClient($oM2MXmlRpc, $oXmlRpcClient);
            
        // Test normal case
        $result = $oPCClient->getCreativeAttributes();
        $this->assertEqual($result, $response);
    }
    
    function testGetCreativeTypes()
    {
        // Prepare XmlRpc client mockup and test response
        $response = array( 
            '1' => 'Image',
            '2' => 'Flash',
            '3' => 'Text');
        $oXmlRpcClient = new PartialMock_PearXmlRpcCustomClientExecutor($this);
        $oXmlRpcClient->expectArgumentsAt(0, 'call', array('dictionary.getCreativeTypes', array()));
        $oXmlRpcClient->setReturnValueAt(0, 'call', $response);
        $oM2MXmlRpc = new PartialMockOA_Central_M2MProtectedRpc($this);
        
        // Create PubConsole API client 
        $oPCClient = 
            new Plugins_admin_oxMarket_PublisherConsoleClient($oM2MXmlRpc, $oXmlRpcClient);
            
        // Test normal case
        $result = $oPCClient->getCreativeTypes();        
        $this->assertEqual($result, $response);
    }
    
    function testGetAdCategories()
    {
        // Prepare XmlRpc client mockup and test response
        $response = array( 
            '1' => 'Adult Entertainment',
            '2' => 'Arts and Entertainment',
            '3' => 'Automotive');
        $oXmlRpcClient = new PartialMock_PearXmlRpcCustomClientExecutor($this);
        $oXmlRpcClient->expectArgumentsAt(0, 'call', array('dictionary.getAdCategories', array()));
        $oXmlRpcClient->setReturnValueAt(0, 'call', $response);
        $oM2MXmlRpc = new PartialMockOA_Central_M2MProtectedRpc($this);
        
        // Create PubConsole API client 
        $oPCClient = 
            new Plugins_admin_oxMarket_PublisherConsoleClient($oM2MXmlRpc, $oXmlRpcClient);
            
        // Test normal case
        $result = $oPCClient->getAdCategories();        
        $this->assertEqual($result, $response);
    }
    
    function testGetDefaultRestrictions()
    {
        // Prepare XmlRpc client mockup and test response
        $response = array(
            'attribute' => array(),
            'category'  => array(1, 10, 26),
            'type'      => array()
        );
        $oXmlRpcClient = new PartialMock_PearXmlRpcCustomClientExecutor($this);
        $oXmlRpcClient->expectArgumentsAt(0, 'call', array('dictionary.getDefaultRestrictions', array()));
        $oXmlRpcClient->setReturnValueAt(0, 'call', $response);
        $oM2MXmlRpc = new PartialMockOA_Central_M2MProtectedRpc($this);
        
        // Create PubConsole API client 
        $oPCClient = 
            new Plugins_admin_oxMarket_PublisherConsoleClient($oM2MXmlRpc, $oXmlRpcClient);
            
        // Test normal case
        $result = $oPCClient->getDefaultRestrictions();        
        $this->assertEqual($result, $response);
    }

    
    function testGetCreativeSizes()
    {
        // Prepare XmlRpc client mockup and test response
        $response = array(
            '468x60' => array(
                            'size_id' => 1,
                            'name' => 'IAB Full Banner',
                            'width' => 468,
                            'height' => 60));
        $oXmlRpcClient = new PartialMock_PearXmlRpcCustomClientExecutor($this);
        $oXmlRpcClient->expectArgumentsAt(0, 'call', array('dictionary.getCreativeSizes', array()));
        $oXmlRpcClient->setReturnValueAt(0, 'call', $response);
        $oM2MXmlRpc = new PartialMockOA_Central_M2MProtectedRpc($this);
        
        // Create PubConsole API client 
        $oPCClient = 
            new Plugins_admin_oxMarket_PublisherConsoleClient($oM2MXmlRpc, $oXmlRpcClient);
            
        // Test normal case
        $result = $oPCClient->getCreativeSizes();        
        $this->assertEqual($result, $response);
    }

}