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
$Id: RegistrationClient.php 43023 2009-09-11 12:38:50Z bernard.lange $
*/
require_once MAX_PATH . '/lib/OA/XmlRpcClient.php';
require_once MAX_PATH . '/lib/OX/PC/API/SimpleClient.php';
require_once MAX_PATH . '/lib/OX/M2M/PearXmlRpcCustomClientExecutor.php';
require_once MAX_PATH . '/lib/OX/Util/ConnectionUtils.php';


/**
 * Client to call register to the market methods 
 *
 * @package    OpenX
 * @subpackage Market
 * @author     Lukasz Wikierski (lukasz.wikierski@openx.org)
 */
class OX_Dal_Market_RegistrationClient
{
    
    
    /**
     * @var OX_PC_API_SimpleClient
     */
    protected $pcApiClient;

    
    /**
     * @var string
     */
    protected $platformHash;
    
    
    /**
     * Constructor
     *
     * @param array $aMarketConfig market config section
     * @param string $platformHash platformhash used in calls
     */
    public function __construct($aMarketConfig, $platformHash)
    {
        $this->platformHash = $platformHash;
        $oPearXmlRpcClient = $this->getPearXmlRpcClient($aMarketConfig);
        $oPublicApiServiceExecutor = new OX_M2M_PearXmlRpcCustomClientExecutor($oPearXmlRpcClient);
        $this->pcApiClient = new OX_PC_API_SimpleClient($oPublicApiServiceExecutor);    
    }
    
    
    /**
     * Return OA_XML_RPC_Client
     * 
     * Protocol and API url is set to fallbackPcApiHost 
     * if SSL extensions are not available 
     *
     * @param array $aMarketConfig market config section
     * @return OA_XML_RPC_Client
     */
    protected function getPearXmlRpcClient($aMarketConfig)
    {
        if (OX_Util_ConnectionUtils::isSSLAvailable()) {
            $apiHostUrl = $aMarketConfig['marketPcApiHost'];
        }
        else {
            $apiHostUrl = $aMarketConfig['fallbackPcApiHost'];
        }
        $apiUrl = $apiHostUrl .'/'. $aMarketConfig['marketPublicApiUrl'];
        
        $aUrl = parse_url($apiUrl);
        // If port is unknow set it to 0 (XML_RPC_Client will use standard ports for given protocol)
        $port = (isset($aUrl['port'])) ? $aUrl['port'] : 0; 

        return new OA_XML_RPC_Client(
            $aUrl['path'],
            "{$aUrl['scheme']}://{$aUrl['host']}",
            $port
        );
    }
    
    
    /**
     * @param string $username
     * @param string $password
     * @return array 'apiKey' and 'accountUuid' publisher account id
     */
    public function createAccountBySsoCred($username, $password)
    {
        return $this->pcApiClient->createAccountBySsoCred(
                    $username, $password, $this->platformHash);
    }
    
    
    /**
     * Create sso account and link this account to Publisher account for this Platform
     *
     * @param string $email       user email address
     * @param string $username    user name
     * @param string $password    user password (not md5)
     * @param string $captcha     captcha value
     * @param string $captcha_random captcha random parameter
     * @return array 'apiKey' and 'accountUuid' publisher account id
     */
    public function createAccount($email, $username, $password, $captcha, $captcha_random)
    {
        return $this->pcApiClient->createAccount(
            $email, $username, md5($password), $captcha, $captcha_random, $this->platformHash);
         
    }
    
    
    /**
     * Check if given sso user name is available
     *
     * @param string $userName
     * @return bool
     */
    public function isSsoUserNameAvailable($userName)
    {
        return $this->pcApiClient->isSsoUserNameAvailable($userName);
    }
}

?>