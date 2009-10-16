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
$Id: SimpleClient.lib.test.php 42506 2009-09-02 09:33:27Z lukasz.wikierski $
*/
require_once MAX_PATH . '/lib/OX/M2M/PearXmlRpcCustomClientExecutor.php';
require_once MAX_PATH . '/lib/OX/PC/API/SimpleClient.php';

/**
 * A class for testing the Simple Publisher Console Client
 *
 * @package    OpenX
 * @subpackage TestSuite
 * @author     Lukasz Wikierski <lukasz.wikierski@openx.org>
 */
class OX_PC_API_SimpleClientTest extends UnitTestCase
{
    
    function __construct()
    {
        parent::__construct();
        Mock::generatePartial(
            'OX_M2M_PearXmlRpcCustomClientExecutor',
            'PartialMock_PearXmlRpcCustomClientExecutor',
            array('call')
        );
    }

    function testCreateAccountBySsoCred()
    {
        $username = 'testUsername';
        $password = 'test';
        $md5password = md5($password);
        $ph = 'platform_hash';
        
        $oXmlRpcClient = new PartialMock_PearXmlRpcCustomClientExecutor($this);
        
        $call = array('createAccountBySsoCred', array($username, $md5password, $ph));
        $response = array('accountUuid' => 'pub-acc-id', 'apiKey' => 'api-key');

        $oXmlRpcClient->expectOnce('call', $call);
        $oXmlRpcClient->setReturnValue('call', $response);
        
        $oPCClient =  new OX_PC_API_SimpleClient($oXmlRpcClient);
            
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

        $call = array('createAccount', array($email, $username, $md5password, $captcha, $captcha_random, $captcha_ph));
    
        $response = array('accountUuid' => 'pub-acc-id', 'apiKey' => 'api-key');
        
        $oXmlRpcClient->expectOnce('call', $call);
        $oXmlRpcClient->setReturnValue('call', $response);
        
        $oPCClient = new OX_PC_API_SimpleClient($oXmlRpcClient);
            
        $result = $oPCClient->createAccount($email, $username, $md5password, $captcha, $captcha_random, $captcha_ph);
        
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
        
        $oPCClient = new OX_PC_API_SimpleClient($oXmlRpcClient);
        
        $result = $oPCClient->isSsoUserNameAvailable($userName1);
        $this->assertFalse($result);
        $result = $oPCClient->isSsoUserNameAvailable($userName2);
        $this->assertTrue($result);
    }
}