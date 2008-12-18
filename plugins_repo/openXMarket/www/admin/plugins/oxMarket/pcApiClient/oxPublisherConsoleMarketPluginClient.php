<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                             |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                            |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
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
require_once MAX_PATH . '/lib/OX/M2M/XmlRpcExecutor.php';
require_once MAX_PATH . '/lib/OX/M2M/ZendXmlRpcExecutor.php';
require_once MAX_PATH . '/lib/OX/M2M/M2MProtectedRpc.php';
require_once MAX_PATH . '/lib/OA/Central/M2MProtectedRpc.php';

require_once dirname(__FILE__) . '/oxPublisherConsoleClient.php';
require_once dirname(__FILE__) . '/oxPublisherConsoleClientException.php';

/**
 *  OpenX Market plugin - Publisher Console API client for plugin
 *
 * @package    OpenXPlugin
 * @subpackage openXMarket
 * @author     Andriy Petlyovanyy <apetlyovanyy@lohika.com>
 */

class Plugins_admin_oxMarket_PublisherConsoleMarketPluginClient
{
    /**
     * ext_market_assoc_data statuses
     */
    const LINK_IS_VALID_STATUS = 0;
    
    /**
     * @var Plugins_admin_oxMarket_PublisherConsoleClient
     */
    private $pc_api_client;
    
    private function ensureStatusAndUpdatePcAccountId()
    {
        $publisher_account_id = null;
        $account_status = null;
        $this->getAssociatedPcAccountIdAndStatus($publisher_account_id,
            $account_status);
        if (!isset($account_status)) {
            throw new Plugins_admin_oxMarket_PublisherConsoleClientException(
                'There is no association between PC and OXP accounts');
        }
        else {
            if (self::LINK_IS_VALID_STATUS != $account_status) {
                //TODO: Add more specific errors when such list would be created
                throw 
                    new Plugins_admin_oxMarket_PublisherConsoleClientException(
                        'Association of PC account with OXP account is invalid', 
                        $account_status);
            }
            else {
            	$this->pc_api_client->setPublisherAccountId(
            	   $publisher_account_id);
            }
        }
    }
    
    /**
     * @param integer $publisher_account_id
     * @param integer $association_status
     */
    private function getAssociatedPcAccountIdAndStatus(&$publisher_account_id, 
        &$association_status)
    {
        $doExtMarket = OA_Dal::factoryDO('ext_market_assoc_data');
        $aRecords = $doExtMarket->getAll();
        if (count($aRecords) > 0) {
            $publisher_account_id = $aRecords[0]['publisher_account_id'];
            $association_status   = $aRecords[0]['status'];                    
        }
        else {
            $publisher_account_id = null;
            $association_status   = null;
        }
    }
    
    public function __construct()
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        $oServiceExecutor = new OX_M2M_ZendXmlRpcExecutor(
            $aConf['oxMarket']['marketPcApiUrl']);
        $oM2MXmlRpc = new OA_Central_M2MProtectedRpc($oServiceExecutor);
        $this->pc_api_client = 
            new Plugins_admin_oxMarket_PublisherConsoleClient($oM2MXmlRpc);    
    }
    
    /**
     * Check if there is already association between 
     * OXP and PC accounts
     * 
     * @return boolean
     */
    public function hasAssociationWithPc()
    {
        $publisher_account_id = null;
        $account_status = null;
        $this->getAssociatedPcAccountIdAndStatus($publisher_account_id,
            $account_status);
        return isset($publisher_account_id); 
    }
    
    /**
     * Check status of association between OXP and PC accounts
     *
     * @return integer or null status code or null in case of no association 
     */
    public function getAssociationWithPcStatus()
    {
        $publisher_account_id = null;
        $account_status = null;
        $this->getAssociatedPcAccountIdAndStatus($publisher_account_id,
            $account_status);
        return $account_status; 
    }
    
    /**
     * @param string $username
     * @param string $password
     * @return boolean 
     */
    public function linkOxp($username, $password)
    {
        $publisher_account_id = $this->pc_api_client->linkOxp(
            $username, $password);
            
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
            $doExtMarket->status = self::LINK_IS_VALID_STATUS;
            $doExtMarket->insert();
        }
        
        $this->pc_api_client->setPublisherAccountId($publisher_account_id);
        
        return true;
    }
    
    /**
     * @param integer $lastUpdate
     * @return string statistics file content 
     */
    public function oxmStatistics($lastUpdate)
    {
        $this->ensureStatusAndUpdatePcAccountId();
        return $this->pc_api_client->oxmStatistics($lastUpdate);
    }
    
    /**
     * @param string $websiteUrl
     * @return integer website id
     */
    public function newWebsite($websiteUrl)
    {
        $this->ensureStatusAndUpdatePcAccountId();
        return $this->pc_api_client->newWebsite($websiteUrl);
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
        $this->ensureStatusAndUpdatePcAccountId();
        return $this->pc_api_client->updateWebsite($websiteId, $websiteUrl, 
            $att_ex, $cat_ex, $typ_ex);
    }
}