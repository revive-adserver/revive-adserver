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
$Id: oxPublisherConsoleMarketPluginClient.php 29196 2008-11-20 14:16:53Z apetlyovanyy $
*/

require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/lib/OA/XmlRpcClient.php';
require_once MAX_PATH . '/lib/OX/M2M/XmlRpcExecutor.php';
require_once MAX_PATH . '/lib/max/Dal/DataObjects/Accounts.php';
require_once MAX_PATH . '/lib/OX/M2M/ZendXmlRpcExecutor.php';
require_once MAX_PATH . '/lib/OX/M2M/M2MProtectedRpc.php';
require_once MAX_PATH . '/lib/OA/Central/M2MProtectedRpc.php';
require_once MAX_PATH . '/lib/OA.php';

require_once OX_MARKET_LIB_PATH . '/OX/oxMarket/Common/ConnectionUtils.php';
require_once OX_MARKET_LIB_PATH . '/OX/oxMarket/M2M/PearXmlRpcCustomClientExecutor.php';
require_once OX_MARKET_LIB_PATH . '/OX/oxMarket/Common/Cache.php';

require_once dirname(__FILE__) . '/oxPublisherConsoleClient.php';
require_once dirname(__FILE__) . '/oxPublisherConsoleClientException.php';

/**
 *  OpenX Market plugin - Publisher Console API client for plugin
 *
 * @package    OpenXPlugin
 * @subpackage openXMarket
 * @author     Andriy Petlyovanyy <apetlyovanyy@lohika.com>
 * @author     Lukasz Wikierski   <lukasz.wikierski@openx.net>
 */

class Plugins_admin_oxMarket_PublisherConsoleMarketPluginClient
{
    /**
     * ext_market_assoc_data statuses - same values as Publisher Console account statuses
     */
    const LINK_IS_VALID_STATUS = 0;
    
    const ACCOUNT_DISABLED_STATUS = 1;
    
    /**
     * Error codes that change link status
     */
    const XML_ERR_ACCOUNT_BLOCKED = 909;
    
    /**
     * @var Plugins_admin_oxMarket_PublisherConsoleClient
     */
    protected $pc_api_client;
    
    public function __construct()
    {
        $oPearXmlRpcClient = $this->getPearXmlRpcClient('marketPublicApiUrl');
        $oPublicApiServiceExecutor = new OX_oxMarket_M2M_PearXmlRpcCustomClientExecutor($oPearXmlRpcClient);
        // M2M service is used only to do relink to new public API
        $oPearXmlRpcClientForM2M = $this->getPearXmlRpcClient('marketXmlRpcUrl');
        $oM2MServiceExecutor = new OX_oxMarket_M2M_PearXmlRpcCustomClientExecutor($oPearXmlRpcClientForM2M);
        $oM2MXmlRpc = new OA_Central_M2MProtectedRpc($oM2MServiceExecutor);
        $this->pc_api_client = 
            new Plugins_admin_oxMarket_PublisherConsoleClient($oM2MXmlRpc, $oPublicApiServiceExecutor);    
    }
    
    /**
     * Return OA_XML_RPC_Client
     * 
     * Protocol and API url is set to fallbackPcApiHost 
     * if SSL extensions are not available 
     *
     * @param string $urlSettingName name of market setting cointaining url to build client
     * @return OA_XML_RPC_Client
     */
    protected function getPearXmlRpcClient($urlSettingName)
    {
        $aMarketConf = $GLOBALS['_MAX']['CONF']['oxMarket'];
        
        if (OX_oxMarket_Common_ConnectionUtils::isSSLAvailable()) {
            $apiHostUrl = $aMarketConf['marketPcApiHost'];
        }
        else {
            $apiHostUrl = $aMarketConf['fallbackPcApiHost'];
        }
        $apiUrl = $apiHostUrl .'/'. $aMarketConf[$urlSettingName];
        
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
     * @param array $array
     * return empty array if argument is null
     */
    protected function putEmptyArrayIfNull($array)
    {
        if (isset($array)) {
            return $array;
        }
        else {
            return array();
        }
    }
    
    protected function ensureStatusAndUpdatePcAccountId()
    {
        
        $aPcAccountData = $this->getAssociatedPcAccountData();
        $association_status = $aPcAccountData['association_status'];
        $publisher_account_id = $aPcAccountData['publisher_account_id'];
        $apiKey = $aPcAccountData['api_key'];
        if (!isset($association_status)) {
            throw new Plugins_admin_oxMarket_PublisherConsoleClientException(
                'There is no association between PC and OXP accounts');
        }
        else {
            if (self::LINK_IS_VALID_STATUS != $association_status) {
                throw 
                    new Plugins_admin_oxMarket_PublisherConsoleClientException(
                        'Association of PC account with OXP account is invalid', 
                        $association_status);
            }
            else {
                $this->pc_api_client->setPublisherAccountId(
                   $publisher_account_id);
                $this->pc_api_client->setApiKey($apiKey);
            }
        }
    }
    
    /**
     * Get basic data regarding associated PC account
     * 
     * @return array with 'publisher_account_id', 'association_status' and 'api_key' values, 
     */
    protected function getAssociatedPcAccountData()
    {
        $oAccountAssocData = OA_Dal::factoryDO('ext_market_assoc_data');
        $adminAccountId = DataObjects_Accounts::getAdminAccountId();
        if (isset($adminAccountId)) {
            $oAccountAssocData->get('account_id', $adminAccountId);
            $result = array();
            $result['publisher_account_id'] = $oAccountAssocData->publisher_account_id;
            $result['association_status']   = $oAccountAssocData->status;
            $result['api_key']              = $oAccountAssocData->api_key;
        } else {
            $result = array(
            'publisher_account_id' => null, 
            'association_status'   => null,
            'apiKey'               => null);
        }
        return $result;
    }
    
    /**
     * Check if there is already association between 
     * OXP and PC accounts
     * 
     * @return boolean
     */
    public function hasAssociationWithPc()
    {
        $aPcAccountData = $this->getAssociatedPcAccountData();
        return isset($aPcAccountData['publisher_account_id']); 
    }
    
    public function hasApiKey()
    {
        $aPcAccountData = $this->getAssociatedPcAccountData();
        return isset($aPcAccountData['api_key']);
    }
    
    /**
     * Return publisher account id for OXP admin account
     *
     * @return integer or null 
     */
    public function getPcAccountId()
    {
        $aPcAccountData = $this->getAssociatedPcAccountData();
        return $aPcAccountData['publisher_account_id'];
    }
    
    /**
     * Check status of association between OXP and PC accounts
     *
     * @return integer or null status code or null in case of no association 
     */
    public function getAssociationWithPcStatus()
    {
        $aPcAccountData = $this->getAssociatedPcAccountData();
        return $aPcAccountData['association_status'];
    }
    
    /**
     * @param string $username
     * @param string $password
     * @return boolean 
     */
    public function createAccountBySsoCred($username, $password)
    {
        $platformHash = OA_Dal_ApplicationVariables::get('platform_hash');
        $response = $this->pc_api_client->createAccountBySsoCred(
            $username, $password, $platformHash);
        return $this->setNewPublisherAccount($response['accountUuid'], $response['apiKey']);
    }
    
    
    /**
     * Create sso account and link this account to Publisher account for this Platform
     *
     * @param string $email       user email address
     * @param string $username    user name
     * @param string $password    user password (not md5)
     * @param string $captcha     captcha value
     * @param string $captcha_random captcha random parameter
     * @return string publisher account UUID
     * @throws Plugins_admin_oxMarket_PublisherConsoleClientException
     */
    public function createAccount($email, $username, $password, $captcha, $captcha_random)
    {
        $captcha_ph = OA_Dal_ApplicationVariables::get('platform_hash');
        $response = $this->pc_api_client->createAccount(
            $email, $username, md5($password), $captcha, $captcha_random, $captcha_ph);
        return $this->setNewPublisherAccount($response['accountUuid'], $response['apiKey']);
    }
    
    /**
     * Set new publisher account in ext_market_assoc_data table
     *
     * @param string $publisher_account_id publisher account UUID
     * @param string $api_key publisher API key
     * @return boolean
     * @throws Plugins_admin_oxMarket_PublisherConsoleClientException 
     */
    protected function setNewPublisherAccount($publisher_account_id, $api_key)
    {
        $doExtMarket = OA_DAL::factoryDO('ext_market_assoc_data');
        $aExtMarketRecords = $doExtMarket->getAll();
        
        if (count($aExtMarketRecords) > 0) {
            throw new Plugins_admin_oxMarket_PublisherConsoleClientException(
                'There is already publisher_account_id on the OXP');
        } 
        else {
            $account_id = DataObjects_Accounts::getAdminAccountId();
            if (!isset($account_id)) {
                throw 
                    new Plugins_admin_oxMarket_PublisherConsoleClientException(
                        'There is no admin account id in database');
            }
            $doExtMarket->account_id = $account_id;
            $doExtMarket->publisher_account_id = $publisher_account_id;
            $doExtMarket->api_key = $api_key;
            $doExtMarket->status = self::LINK_IS_VALID_STATUS;
            $doExtMarket->insert();
        }
        
        $this->pc_api_client->setPublisherAccountId($publisher_account_id);
        $this->pc_api_client->setApiKey($api_key);
        
        return true;
    }
    
    /**
     * @param integer $lastUpdate
     * @param array $aWebsitesIds websites ids
     * @return string statistics file content 
     */
    public function getStatistics($lastUpdate, $aWebsitesIds = null)
    {
        try {
            $this->ensureStatusAndUpdatePcAccountId();
            return $this->pc_api_client->getStatistics($lastUpdate, 
                                                       $this->putEmptyArrayIfNull($aWebsitesIds));
        } catch (Exception $e) {
            $this->setStatusByException($e);
        }
    }
    
    /**
     * @param string $websiteUrl
     * @return integer website id
     */
    public function newWebsite($websiteUrl)
    {
        try {
            $this->ensureStatusAndUpdatePcAccountId();
            return $this->pc_api_client->newWebsite($websiteUrl);
        } catch (Exception $e) {
            $this->setStatusByException($e);
        }
    }
    
    /**
     * @param integer $websiteId
     * @param string $websiteUrl
     * @param array $att_ex
     * @param array $cat_ex
     * @param array $typ_ex
     */
    public function updateWebsite($websiteId, $websiteUrl, $att_ex, 
        $cat_ex, $typ_ex)    
    {
        try {
            $this->ensureStatusAndUpdatePcAccountId();
            return $this->pc_api_client->updateWebsite($websiteId, $websiteUrl,
                $this->putEmptyArrayIfNull($att_ex), 
                $this->putEmptyArrayIfNull($cat_ex), 
                $this->putEmptyArrayIfNull($typ_ex));
        } catch (Exception $e) {
            $this->setStatusByException($e);
        }
    }
    
    /**
     * Get API key by SSO credentials
     *
     * @param string $username
     * @param string $password
     * @return bool true if successful
     */
    public function getApiKey($username, $password)
    {
        $apiKey = $this->pc_api_client->getApiKey($username, $password);
        return $this->saveApiKeyToDB($apiKey);
    }
    
    /**
     * Saves API key in database
     *
     * @param string $apiKey
     * @return bool true if successful
     */
    protected function saveApiKeyToDB($apiKey)
    {
        $doExtMarket = OA_Dal::factoryDO('ext_market_assoc_data');
        $adminAccountId = DataObjects_Accounts::getAdminAccountId();
        if (!isset($adminAccountId)) {
            // no admin account
            return false;
        }
        $doExtMarket->get('account_id', $adminAccountId);
        if (empty($doExtMarket->publisher_account_id)) {
            // no association data
            return false;
        }
        $doExtMarket->api_key = $apiKey;
        $result = $doExtMarket->update();;
        return true;
    }
    /**
     * Synchronize status with market and return new status
     *
     * @return int
     */
    public function updateAccountStatus()    
    {
        $publisher_account_id = null;
        $currentStatus = null;
        $apiKey = null;
        
        $doExtMarket = OA_Dal::factoryDO('ext_market_assoc_data');
        $adminAccountId = DataObjects_Accounts::getAdminAccountId();
        if (isset($adminAccountId)) {
            $doExtMarket->get('account_id', $adminAccountId);
            $publisher_account_id = $doExtMarket->publisher_account_id;
            $currentStatus        = $doExtMarket->status;
            $apiKey               = $doExtMarket->api_key;
        }
        
        $this->pc_api_client->setPublisherAccountId($publisher_account_id);
        $this->pc_api_client->setApiKey($apiKey);
        $newStatus = $this->pc_api_client->getAccountStatus();
        if ($newStatus != $currentStatus) {
            $doExtMarket->status = $newStatus;
            $doExtMarket->update();
        }
        return $newStatus;
    }
    
    
    /**
     * Check if given sso user name is available
     *
     * @param string $userName
     * @return bool
     */
    public function isSsoUserNameAvailable($userName)
    {
        return $this->pc_api_client->isSsoUserNameAvailable($userName);
    }
    
    /**
     * Set status to account disabled if exception code is one of account disabling codes
     *
     * @param Exception $exception
     * @throws Exception rethrows given exception
     */
    protected function setStatusByException(Exception $exception) 
    {
        if ($exception->getCode() == self::XML_ERR_ACCOUNT_BLOCKED) {
            $adminAccountId = DataObjects_Accounts::getAdminAccountId();
            if (isset($adminAccountId)) {
                $doExtMarket = OA_DAL::factoryDO('ext_market_assoc_data');
                $doExtMarket->get($adminAccountId);
                $doExtMarket->status = self::ACCOUNT_DISABLED_STATUS;;
                $doExtMarket->update();
            }
        }
        throw $exception;
    }
    
    /**
     * Returns default restrictions.
     * 
     * @return array default settings
     */
    public function getDefaultRestrictions()
    {
        return $this->getDictionaryData('DefaultRestrictions', 'getDefaultRestrictions');;
    }
    
    /**
     * Returns array of Ad Categories used in marketplace
     *
     * @return array array of categories names where array keys are ids
     */
    public function getAdCategories() {
        return $this->getDictionaryData('AdCategories', 'getAdCategories');;
    }
    
    /**
     * Returns array of Creative Types used in marketplace
     *
     * @return array array of types names where array keys are ids
     */
    function getCreativeTypes()
    {
        return $this->getDictionaryData('CreativeTypes', 'getCreativeTypes');
    }

    /**
     * Returns array of Creative Attributes used in marketplace
     *
     * @return array array of attributes names where array keys are ids
     */
    function getCreativeAttributes()
    {
        return $this->getDictionaryData('CreativeAttributes', 'getCreativeAttributes');
    }
    
    /**
     * Generic method to retrieve dictionary data.
     * 
     * Method to following steps:
     *  1. get data from cache if cache is valid
     *  2. (if not 1) get data from Pub Console
     *  3. (if not 2) get data from cache ignore cache validity
     *  4. (if not 3) get data from var/data/dictionary cached data
     *  5. (if not 4) return empty array 
     *
     * @param string $dictionaryName cache name
     * @param string $apiMethod name of called API method
     * @return mixed
     */
    protected function getDictionaryData($dictionaryName, $apiMethod) 
    {
        // Read data from cache if possible
        $oCache = new OX_oxMarket_Common_Cache($dictionaryName, 'oxMarket', 
            $GLOBALS['_MAX']['CONF']['oxMarket']['dictionaryCacheLifeTime']);
        $oCache->setFileNameProtection(false);
        $aData = $oCache->load(false);

        if ($aData == false) {
            // Cache doesn't exist or is expired
            try {
                // Read data from xmlrpc
                $aData = call_user_func(array(&$this->pc_api_client, $apiMethod));
                $oCache->save($aData);
            } catch (Exception $e) {
                OA::debug('openXMarket: Error during retrieving dictionary data: ['.$e->getCode().'] '.$e->getMessage());
                // Try to read cache ignoring life time
                $aData = $oCache->load(true);
                if ($aData == false) {
                    // Cache desn't exist
                    // Try to read cache from var/data/dictionary
                    $oCache = new OX_oxMarket_Common_Cache($dictionaryName, 'oxMarket', 
                                    null, OX_MARKET_VAR_DICTIONARY);
                    $oCache->setFileNameProtection(false);
                    $aData = $oCache->load(true);
                    if ($aData == false) {
                        // Empty array if there is no permament dictionary data
                        $aData = array();
                    }
                }
            }
        }
        return $aData;
    }
}