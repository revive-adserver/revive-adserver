<?php

/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
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