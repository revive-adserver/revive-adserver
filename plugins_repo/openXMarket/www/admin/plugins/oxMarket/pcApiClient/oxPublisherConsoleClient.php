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
     * @param OX_M2M_M2MProtectedRpc $m2mprotected_xml_rpc_client
     * @param OX_M2M_XmlRpcExecutor $xml_rpc_client
     * @param integer $publisher_account_id
     */
    public function __construct(OX_M2M_M2MProtectedRpc $m2mprotected_xml_rpc_client, 
        OX_M2M_XmlRpcExecutor $xml_rpc_client,
        $publisher_account_id = null)
    {
        $this->publisher_account_id = $publisher_account_id;
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

    protected function callXmlRpcClient($function, $params) {
        return $this->xml_rpc_client->call($function, $params);
    }
    
    protected function callM2mprotectedXmlRpcClient($function, $params) {
        return $this->m2mprotected_xml_rpc_client->call($function, $params);
    }
    
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
     * @param string $username
     * @param string $password
     * @return integer publisher_account_id
     */
    public function linkOxp($username, $password)
    {
        return $this->callM2mprotectedXmlRpcClient('linkOxp', 
            array($username, md5($password)));
    }
    
    /**
     * @param integer $lastUpdate
     * @return string statistics file content 
     */
    public function oxmStatistics($lastUpdate)
    {
        return $this->callXmlRpcFunctionWithPCAccount('oxmStatistics', 
            array($lastUpdate));
    }
    
    /**
     * @param integer $lastUpdate
     * @return string statistics file content 
     */
    public function oxmStatisticsLimited($lastUpdate)
    {
        return $this->callXmlRpcFunctionWithPCAccount('oxmStatisticsLimited', 
            array($lastUpdate));
    }
    
    /**
     * @param string $websiteUrl
     * @return integer website id
     */
    public function newWebsite($websiteUrl)
    {
        return $this->callXmlRpcFunctionWithPCAccount('newWebsite', array(
            $websiteUrl));
    }
    
    /**
     * @param integer $websiteId
     * @param string $websiteUrl
     * @param array $att_ex
     * @param array $cat_ex
     * @param array $typ_ex
     * @return integer website id
     */
    public function updateWebsite($websiteId, $websiteUrl, $att_ex, 
        $cat_ex, $typ_ex)    
    {
        return $this->callXmlRpcFunctionWithPCAccount('updateWebsite', 
            array($websiteId, $websiteUrl, $att_ex, $cat_ex, $typ_ex));
    }
    
    /**
     * Get Publisher Console account status
     *
     * @return integer account status
     */
    public function getAccountStatus()
    {
        return $this->callXmlRpcFunctionWithPCAccount('getAccountStatus', 
            array());
    }
    
    /**
     * Create sso account and link this account to Publisher account for this Platform
     *
     * @param string $email       user email address
     * @param string $username    user name
     * @param string $md5password md5 hash of user password
     * @param string $captcha     captcha value
     * @param string $captcha_random captcha random parameter
     * @return string publisher account UUID
     */
    public function createAccount($email, $username, $md5password, $captcha, $captcha_random)
    {
        return $this->callM2mprotectedXmlRpcClient('createAccount', 
            array($email, $username, $md5password, $captcha, $captcha_random));
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