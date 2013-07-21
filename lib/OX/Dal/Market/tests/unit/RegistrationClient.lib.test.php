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

require_once MAX_PATH . '/lib/OX/PC/API/SimpleClient.php';
require_once dirname(dirname(__FILE__)) . '/util/RegistrationTestClient.php';

/**
 * A class for testing the Registration Client
 *
 * @package    OpenX
 * @subpackage TestSuite
 * @author     Lukasz Wikierski <lukasz.wikierski@openx.org>
 */
class OX_Dal_Market_RegistrationClientTest extends UnitTestCase
{
    private $aMarketConfig;
    private $platformHash;
    
    
    public function __construct()
    {
        parent::__construct();
        Mock::generatePartial(
            'OX_M2M_PearXmlRpcCustomClientExecutor',
            'PartialMock_PearXmlRpcCustomClientExecutor',
            array('call')
        );
        
        $this->aMarketConfig = array(
            'marketPcApiHost' => 'https://pc.host',
            'fallbackPcApiHost' => 'http://pc.fallback',
            'marketPublicApiUrl' => 'url/api/xml-rpc',
        );
        $this->platformHash = 'ph';
    }
    
    
    public function test__construct()
    {
        $regClient = new RegistrationTestClient($this->aMarketConfig, $this->platformHash);
        $pcApiClient = $regClient->getPcApiClient();
        
        $this->assertIsA($regClient, 'OX_Dal_Market_RegistrationClient');
        $this->assertIsA($pcApiClient, 'OX_PC_API_SimpleClient');
    }
    
    
    public function testCreateAccountBySsoCred()
    {
        $username = 'testUser';
        $password = 'testPass';
        $md5password = md5($password);
        $call = array('createAccountBySsoCred', array($username, $md5password, $this->platformHash));
        $response = array('accountUuid' => 'pub-acc-id', 'apiKey' => 'api-key');
        
        $regClient = $this->_prepareRegistrationClient(array(array('arguments' => $call, 'response' => $response)));
        
        $result = $regClient->createAccountBySsoCred($username, $password);
        $this->assertEqual($result, $response);
    }
    
    
    public function testCreateAccount()
    {
        $email    = 'test@email.com';
        $username = 'testUser';
        $password = 'testPass';
        $md5password = md5($password);
        $captcha  = 'captcha';
        $captcha_random = '21343451'; 
        $call = array('createAccount', array($email, $username, $md5password, $captcha, $captcha_random, $this->platformHash));
        $response = array('accountUuid' => 'pub-acc-id', 'apiKey' => 'api-key');
        
        $regClient = $this->_prepareRegistrationClient(array(array('arguments' => $call, 'response' => $response)));
        
        $result = $regClient->createAccount($email, $username, $password, $captcha, $captcha_random);
        $this->assertEqual($result, $response);
    }
    
    
    public function testIsSsoUserNameAvailable()
    {

        $userName1 = 'ada';
        $userName2 = 'adam';
        $calls = array( 
                    array('arguments' => array('isSsoUserNameAvailable', array($userName1)),
                          'response' => true),
                    array('arguments' => array('isSsoUserNameAvailable', array($userName2)),
                          'response' => false));
        
        $regClient = $this->_prepareRegistrationClient($calls);
        
        $this->assertTrue($regClient->isSsoUserNameAvailable($userName1));
        $this->assertFalse($regClient->isSsoUserNameAvailable($userName2));
    }
    
    
    /**
     * Method to prepare RegistrationClient with mocked xmlrpc executor
     *
     * @param array $calls array of calls to xmlrpc executor (each call is array with 'argumetns' and 'response')
     * @return RegistrationTestClient
     */
    private function _prepareRegistrationClient($calls)
    {
        $oClientExecutor = new PartialMock_PearXmlRpcCustomClientExecutor($this);
        $callNo = 0;
        foreach ($calls as $call) {
            $oClientExecutor->expectArgumentsAt($callNo, 'call', $call['arguments']);
            $oClientExecutor->setReturnValueAt($callNo, 'call', $call['response']);
            $callNo++;
        }
        $oClientExecutor->expectCallCount('call', $callNo); 

        $regClient = new RegistrationTestClient($this->aMarketConfig, $this->platformHash);
        $pcApiClient = new OX_PC_API_SimpleClient($oClientExecutor);
        $regClient->setPcApiClient($pcApiClient);
        return $regClient;
    }
}

?>