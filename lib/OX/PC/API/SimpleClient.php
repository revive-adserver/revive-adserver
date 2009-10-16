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
$Id: SimpleClient.php 42760 2009-09-07 14:04:01Z lukasz.wikierski $
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