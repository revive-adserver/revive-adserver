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

require_once dirname(__FILE__) . '/../../../var/config.php';
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
    }
    
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

    function testCreateAccount()
    {
        $email = 'email@test.org';
        $username = 'testUsername';
        $md5password = md5('test');
        $captcha = 'captcha';
        $captcha_random = 'captcha_random';
        
        $sso_id = 1234;

        $call = array('createAccount', array($email, $username, $md5password, $captcha, $captcha_random));
    
        $oXmlRpcClient = new PartialMock_PearXmlRpcCustomClientExecutor($this);
        $oM2MXmlRpc = new PartialMockOA_Central_M2MProtectedRpc($this);
        $oM2MXmlRpc->expectOnce('call', $call);
        $oM2MXmlRpc->setReturnValue('call', $sso_id);
        
        $oPCClient = 
            new Plugins_admin_oxMarket_PublisherConsoleClient($oM2MXmlRpc, $oXmlRpcClient);
            
        $result = $oPCClient->createAccount($email, $username, $md5password, $captcha, $captcha_random);
        
        $this->assertEqual($result, $sso_id);
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
}