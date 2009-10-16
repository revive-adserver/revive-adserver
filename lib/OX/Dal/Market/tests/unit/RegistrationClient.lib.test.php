<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                             |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                            |
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
$Id: RegistrationClient.lib.test.php 42506 2009-09-02 09:33:27Z lukasz.wikierski $
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