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
require_once MAX_PATH . '/lib/OX/M2M/XmlRpcExecutor.php';
require_once MAX_PATH . '/lib/Zend/Http/Exception.php';
require_once MAX_PATH . '/lib/max/Dal/DataObjects/Accounts.php';
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
    
    /**
     * @param array $array
     * return empty array if argument is null
     */
    private function putEmptyArrayIfNull($array)
    {
        if (isset($array)) {
            return $array;
        }
        else {
            return array();
        }
    }
    
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
        $oAccountAssocData = OA_Dal::factoryDO('ext_market_assoc_data');
        $adminAccountId = DataObjects_Accounts::getAdminAccountId();
        if (isset($adminAccountId)) {
            $oAccountAssocData->get('account_id', $adminAccountId);
            $publisher_account_id = $oAccountAssocData->publisher_account_id;
            $association_status   = $oAccountAssocData->status; 
        }
    }
    
    public function __construct()
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        
        $apiUrl = $aConf['oxMarket']['marketPcApiUrl'];
        $oServiceExecutor = new OX_M2M_ZendXmlRpcExecutor($apiUrl);
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
     * Return publisher account id for OXP admin account
     *
     * @return integer or null 
     */
    public function getPcAccountId()
    {
        $publisher_account_id = null;
        $account_status = null;
        $this->getAssociatedPcAccountIdAndStatus($publisher_account_id,
            $account_status);
        return $publisher_account_id; 
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
            $this->putEmptyArrayIfNull($att_ex), 
            $this->putEmptyArrayIfNull($cat_ex), 
            $this->putEmptyArrayIfNull($typ_ex));
    }
    
    /**
     * Returns default restrictions.
     * 
     * XXX hardcoded for now
     * @return array default settings
     */
    public function getDefaultRestrictions()
    {
        return array(
            'attribute' => array(),
            'category'  => array(1, 10, 26),
            'type'      => array()
        );
    }
    
    /**
     * Returns array of Ad Categories used in marketplace
     *
     * XXX hardcoded for now
     * @return array array of categories names where array keys are ids
     */
    public function getAdCategories() {
        return array(
                '1' => 'Adult Entertainment',
                '2' => 'Arts and Entertainment',
                '3' => 'Automotive',
                '4' => 'Business',
                '5' => 'Careers and Jobs',
                '6' => 'Clothing and Apparel',
                '7' => 'Consumer Electronics',
                '8' => 'Dating and Relationships',
                '9' => 'Family and Parenting',
               '10' => 'Firearms and Weapons',
               '11' => 'Food and Drink',
               '12' => 'Gambling',
               '13' => 'Government',
               '14' => 'Health',
               '15' => 'Hobbies and Interests',
               '16' => 'Holidays',
               '17' => 'Home and Garden',
               '18' => 'Humanities and Social Sciences',
               '19' => 'Internet',
               '20' => 'Pets',
               '30' => 'Personal Finance',
               '21' => 'Property and Real Estate',
               '22' => 'Religion and Spirituality',
               '23' => 'Research and Education',
               '24' => 'Science and Engineering',
               '25' => 'Sports and Recreation',
               '26' => 'Tobacco and Smoking',
               '27' => 'Toys and Games',
               '28' => 'Travel and Tourism',
               '29' => 'Weather'
            );
    }
    
    /**
     * Returns array of Creative Types used in marketplace
     *
     * XXX hardcoded for now
     * @return array array of types names where array keys are ids
     */
    function getCreativeTypes()
    {
        return array(
            '1' => 'Image',
            '2' => 'Flash',
            '3' => 'Text',
            '4' => 'Video',
            '5' => 'DHTML',
            '6' => 'Expandable',
            '7' => 'Audio'
        );
    }

    /**
     * Returns array of Creative Attributes used in marketplace
     *
     * XXX hardcoded for now
     * @return array array of attributes names where array keys are ids
     */
    function getCreativeAttributes()
    {
        return array(
           '1' => 'Alcohol',
           '2' => 'Audio/Video',
           '3' => 'Dating/Romance',
           '4' => 'Download',
           '5' => 'English',
           '6' => 'Error Box',
           '7' => 'Excessive Animation',
           '8' => 'Gambling',
           '9' => 'Holiday',
           '10' => 'Incentivized',
           '11' => 'Male Health',
           '12' => 'Membership Club',
           '13' => 'Political',
           '14' => 'Suggestive',
           '15' => 'Tobacco'
        );
    }
}