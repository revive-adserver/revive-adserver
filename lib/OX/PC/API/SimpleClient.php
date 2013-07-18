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

require_once MAX_PATH . '/lib/OA.php';
require_once MAX_PATH . '/lib/OX/M2M/XmlRpcExecutor.php';
require_once MAX_PATH . '/lib/OX/PC/API/SimpleClient.php';


/**
 * Publisher Console API simple client
 * Implements methods to register account to PubConsole
 *
 * @package    OpenX
 * @subpackage PublisherConsoleAPI
 * @author     Lukasz Wikierski   <lukasz.wikierski@openx.net>
 */
class OX_PC_API_SimpleClient
{

    
    /**
     * @var OX_M2M_XmlRpcExecutor
     */
    protected $xml_rpc_client;

    
    /**
     * constructor
     * 
     * @param OX_M2M_XmlRpcExecutor $xml_rpc_client Client for Public API
     */
    public function __construct(OX_M2M_XmlRpcExecutor $xml_rpc_client)
    {
        $this->xml_rpc_client = $xml_rpc_client;
    }
    
    
    protected function callXmlRpcClient($function, $params) {
        return $this->xml_rpc_client->call($function, $params);
    }

    
    /**
     * Create Publisher account
     * 
     * @param string $username
     * @param string $password
     * @param string $ph - platform hash
     * @return array 'apiKey' and 'accountUuid' publisher account id
     */
    public function createAccountBySsoCred($username, $password, $ph)
    {
        return $this->callXmlRpcClient('createAccountBySsoCred', 
            array($username, md5($password), $ph));
    }
    
    
    /**
     * Create sso account and link this account to Publisher account for this Platform
     *
     * @param string $email       user email address
     * @param string $username    user name
     * @param string $md5password md5 hash of user password
     * @param string $captcha     captcha value
     * @param string $captcha_random captcha random parameter
     * @param string $$captcha_ph captcha ph parameter (platform hash)
     * @return array 'apiKey' and 'accountUuid' publisher account id
     */
    public function createAccount($email, $username, $md5password, $captcha, $captcha_random, $captcha_ph)
    {
        return $this->callXmlRpcClient('createAccount', 
            array($email, $username, $md5password, $captcha, $captcha_random, $captcha_ph));
    }

       
    /**
     * Check if given sso user name is available
     *
     * @param string $userName
     * @return bool
     */
    public function isSsoUserNameAvailable($userName)
    {
        return $this->callXmlRpcClient('isSsoUserNameAvailable', array($userName));
    }
}
?>