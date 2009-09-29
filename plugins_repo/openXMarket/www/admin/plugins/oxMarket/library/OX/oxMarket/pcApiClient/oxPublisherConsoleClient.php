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
$Id: oxPublisherConsoleClient.php 29196 2008-11-20 14:16:53Z apetlyovanyy $
*/
require_once MAX_PATH . '/lib/OA.php';
require_once MAX_PATH . '/lib/OX/M2M/M2MProtectedRpc.php';
require_once MAX_PATH . '/lib/OX/M2M/XmlRpcExecutor.php';
require_once dirname(__FILE__) . '/oxPublisherConsoleClientException.php';

/**
 *  OpenX Market plugin - Publisher Console API client
 *
 * @package    OpenXPlugin
 * @subpackage openXMarket
 * @author     Andriy Petlyovanyy <apetlyovanyy@lohika.com>
 * @author     Lukasz Wikierski   <lukasz.wikierski@openx.net>
 */

class Plugins_admin_oxMarket_PublisherConsoleClient
{
    /**
     * @var OX_M2M_M2MProtectedRpc
     */
    protected $m2mprotected_xml_rpc_client;
    
    /**
     * @var OX_M2M_XmlRpcExecutor
     */
    protected $xml_rpc_client;
    
    /**
     * @var integer
     */
    protected $publisher_account_id;

    /**
     * @var string
     */
    protected $apiKey;
    
    /**
     * @param OX_M2M_M2MProtectedRpc $m2mprotected_xml_rpc_client Client for old M2M protected API
     * @param OX_M2M_XmlRpcExecutor $xml_rpc_client Client for Public API
     * @param integer $publisher_account_id
     */
    public function __construct(OX_M2M_M2MProtectedRpc $m2mprotected_xml_rpc_client, 
        OX_M2M_XmlRpcExecutor $xml_rpc_client,
        $publisher_account_id = null)
    {
        $this->publisher_account_id = $publisher_account_id;
        $this->apiKey = null;
        $this->m2mprotected_xml_rpc_client = $m2mprotected_xml_rpc_client;
        $this->xml_rpc_client = $xml_rpc_client;
    }
    
    protected function ensurePublisherAccountIdIsSet()
    {
        if (!isset($this->publisher_account_id)) {
            throw new Plugins_admin_oxMarket_PublisherConsoleClientException(
                'publisher_account_id can not be null');
        }
    }
    
    /**
     * Method checks if API Key is set for this client
     * 
     * @throws Plugins_admin_oxMarket_PublisherConsoleClientException if API Key is not set
     */
    protected function ensureApiKeyIsSet()
    {
        if (!isset($this->apiKey)) {
            throw new Plugins_admin_oxMarket_PublisherConsoleClientException(
                'apiKey can not be null');
        }
    }

    protected function callXmlRpcClient($function, $params) {
        return $this->xml_rpc_client->call($function, $params);
    }

    /**
     * Call XML RPC client adding API Key for authorization
     *
     * @param string $function
     * @param array $params
     * @return mixed
     */
    protected function callApiKeyAuthXmlRpcFunction($function, $params) {
        $this->ensureApiKeyIsSet();
        $paramsWithApiKey = array_merge(
            array($this->apiKey), $params);
        return $this->xml_rpc_client->call($function, $paramsWithApiKey);
    }
    
    /**
     * Call M2M protected XML-RPC method
     *
     * @param unknown_type $function
     * @param unknown_type $params
     * @return unknown
     */
    protected function callM2mprotectedXmlRpcClient($function, $params) {
        return $this->m2mprotected_xml_rpc_client->call($function, $params);
    }
    
    /**
     * Call M2M protected XML-RPC method, add Publisher Account as first parameter
     *
     * @param string $function
     * @param array $params
     * @return mixed
     */
    protected function callXmlRpcFunctionWithPCAccount($function, $params = array())
    {
        $this->ensurePublisherAccountIdIsSet();
        $paramsWithPCAccount = array_merge(
            array($this->publisher_account_id), $params);
        return $this->callM2mprotectedXmlRpcClient($function, $paramsWithPCAccount); 
    }
    
    /**
     * @param integer $publisher_account_id
     */
    public function setPublisherAccountId($publisher_account_id)
    {
        $this->publisher_account_id = $publisher_account_id;
        $this->ensurePublisherAccountIdIsSet();
    }
    
    /**
     * Set API Key used to authorize client calls 
     * 
     * @param string $apiKey Api Key used to authorize client in public API
     */
    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;
        $this->ensureApiKeyIsSet();
    }
    
    /**
     * Create Publisher account
     * 
     * @param string $username
     * @param string $password
     * @param string $ph - platform hash
     * @return array 'ApiKey' and 'accountUuid' publisher account id
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
     * @return array 'ApiKey' and 'accountUuid' publisher account id
     */
    public function createAccount($email, $username, $md5password, $captcha, $captcha_random, $captcha_ph)
    {
        return $this->callXmlRpcClient('createAccount', 
            array($email, $username, $md5password, $captcha, $captcha_random, $captcha_ph));
    }

    /**
     * @param int $sso_id SSO account ID
     * @param string $username 
     * @param string $email
     * @return integer publisher_account_id
     */
    public function linkHostedAccount($sso_id, $username, $email)
    {
        return $this->callM2mprotectedXmlRpcClient('linkHostedAccount', 
            array($sso_id, $username, $email));
    }
    
    /**
     * @param integer $lastUpdate
     * @param array $aWebsitesIds websites ids
     * @return string statistics file content
     */
    public function getStatistics($lastUpdate, $aWebsitesIds)
    {
        return $this->callApiKeyAuthXmlRpcFunction('getStatistics', 
            array($lastUpdate, $aWebsitesIds));
    }
    
    /**
     * @param string $websiteUrl
     * @param string $websiteName
     * @return string thorium website id
     */
    public function newWebsite($websiteUrl, $websiteName)
    {
        return $this->callApiKeyAuthXmlRpcFunction('registerWebsite', array(
            $websiteUrl, $websiteName));
    }
    
    /**
     * @param integer $websiteId
     * @param string $websiteUrl
     * @param array $att_ex
     * @param array $cat_ex
     * @param array $typ_ex
     * @param string $websiteName (optional)
     * @return string thorium website id
     */
    public function updateWebsite($websiteId, $websiteUrl, $att_ex, 
        $cat_ex, $typ_ex, $websiteName = null)    
    {
        $aParams = array($websiteId, $websiteUrl, $att_ex, $cat_ex, $typ_ex);
        if (isset($websiteName)) {
            $aParams[] = $websiteName;
        }
        return $this->callApiKeyAuthXmlRpcFunction('updateWebsite', $aParams);
    }
    
    /**
     * Get Publisher Console account status
     *
     * @return integer account status
     */
    public function getAccountStatus()
    {
        return $this->callApiKeyAuthXmlRpcFunction('getAccountStatus', 
            array());
    }

    /**
     * Get API key by SSO credentials
     * 
     * @param string $username
     * @param string $password
     * @return string apiKey
     */
    public function getApiKey($username, $password)
    {
        return $this->callXmlRpcClient('getApiKey', 
            array($username, md5($password)));
    }
    
    
    /**
     * Generate new API key by SSO credentials
     * 
     * @param string $username
     * @param string $password
     * @return string apiKey
     */
    public function generateApiKey($username, $password)
    {
        return $this->callXmlRpcClient('generateApiKey', 
            array($username, md5($password)));
    }
    
    
    /**
     * Get API key by M2M credentials
     *
     * @return string apiKey
     */
    public function getApiKeyByM2MCred()
    {
        return $this->callXmlRpcFunctionWithPCAccount(
            'getApiKeyByM2MCred', array());
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
    
    /**
     * Returns array of Creative Attributes used in marketplace
     *
     * @return array array of attributes names where array keys are ids
     */
    public function getCreativeAttributes()
    {
        return $this->callXmlRpcClient('dictionary.getCreativeAttributes', array());
    }
    
    /**
     * Returns array of Creative Types used in marketplace
     *
     * @return array array of types names where array keys are ids
     */
    public function getCreativeTypes()
    {
        return $this->callXmlRpcClient('dictionary.getCreativeTypes', array());
    }
    
    /**
     * Returns array of Ad Categories used in marketplace
     *
     * @return array array of categories names where array keys are ids
     */
    public function getAdCategories()
    {
        return $this->callXmlRpcClient('dictionary.getAdCategories', array());
    }
    
    /**
     * Returns default restrictions.
     * 
     * @return array default settings
     */
    public function getDefaultRestrictions()
    {
        return $this->callXmlRpcClient('dictionary.getDefaultRestrictions', array());
    }
}