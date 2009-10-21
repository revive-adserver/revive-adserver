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
$Id: Website.php 41993 2009-08-24 15:18:37Z lukasz.wikierski $
*/
require_once MAX_PATH .'/lib/max/Dal/DataObjects/Campaigns.php';

/**
 * Website DAL Library. 
 * Handles PC API calls and operations on DataObjects for various operation on websites 
 *
 * @package    openXMarket
 * @author     Bernard Lange <bernard.lange@openx.org>
 */
class OX_oxMarket_UI_EntityHelper
{
    public static $MARKET_CAMPAIGN_REMNANT = 'remnant';
    public static $MARKET_CAMPAIGN_CONTRACT = 'contract';
    
    
    public function __construct(Plugins_admin_oxMarket_oxMarket $marketComponent = null)
    {
    }

    
    /**
     * Checks if given advertiser is market advertiser
     *
     * @param array|string|int $id
     */
    public function isMarketAdvertiser($data)
    {
        if (!isset($data)) {
            return false;
        }
        
        $aAdvertiser = array();
        if (!is_array($data)) {
            $aAdvertiser = $this->getEntity('clients', $data); //should be an id
        }
        else {
            $aAdvertiser = $data;
        }
        
        return $aAdvertiser['type'] == DataObjects_Clients::ADVERTISER_TYPE_MARKET;
    }
    
    
    /**
     * Checks if given campaign is any of market campaign types
     *
     * @param array|string|int $data
     * @return boolean
     */
    public function isMarketCampaign($data)
    {
        return $this->isMarketContractCampaign($data) 
            || $this->isMarketCampaignOptInCampaign($data) 
            || $this->isMarketZoneOptInCampaign($data);    
    }    
        
    
    /**
     * Checks if given campaign is Market Campaign Opt-in campaign
     *
     * @param array|string|int $data
     * @return boolean
     */
    public function isMarketCampaignOptInCampaign($data)
    {
        return $this->isMarketCampaignOfType($data, 
            DataObjects_Campaigns::CAMPAIGN_TYPE_MARKET_CAMPAIGN_OPTIN);    
    }
    
    
    /**
     * Checks if given campaign is Market Zone Opt-in campaign
     *
     * @param array|string|int $data
     * @return boolean
     */
    public function isMarketZoneOptInCampaign($data)
    {
        return $this->isMarketCampaignOfType($data, 
            DataObjects_Campaigns::CAMPAIGN_TYPE_MARKET_ZONE_OPTIN);    
    }
    
    
    /**
     * Checks if given campaign is market contract campaign (created by user)
     *
     * @param array|string|int $id
     */
    public function isMarketContractCampaign($data)
    {
        return $this->isMarketCampaignOfType($data, 
            DataObjects_Campaigns::CAMPAIGN_TYPE_MARKET_CONTRACT);    
    }    
    
    
    /**
     * Checks if given banner is hidden market banner.
     *
     * @param unknown_type $data
     * @return unknown
     */
    public function isMarketBanner($data)
    {
        if (!is_array($data)) {
            // Get the campaign data from the campaign table, and store in $campaign
            $aBanner = $this->getEntity('banners', $data); //should be an id            
        }
        else {
            $aBanner = $data;
        }
        
        return $aBanner['ext_bannertype'] == DataObjects_Banners::BANNER_TYPE_MARKET;        
    }
    
    
    protected function isMarketCampaignOfType($data, $type)
    {
        if (!isset($data)) {
            return false;
        }
        
        //prevent mulitple DB calls
        static $aResults;
        if (is_array($data)) {
            $key = $data['campaignid']; 
        }
        else {
            $key = $data;
        }
        if (isset($aResults[$key.':'.$type])) {
            return $aResults[$key.':'.$type];
        }
        
        
        if (!is_array($data)) {
            // Get the campaign data from the campaign table, and store in $campaign
            $aCampaign = $this->getEntity('campaigns', $data); //should be an id            
        }
        else {
            $aCampaign = $data;
        }

        $isMarketType = $aCampaign['type'] == $type;
        $aResults[$aCampaign['campaignid'].':'.$type] = $isMarketType;
        
        return $isMarketType;
    }
    
    
    /**
     * Enter description here...
     *
     * @param array $aCampaign
     */
    public function getCampaignTypeName($aCampaign)
    {
        $type = 'Unknown';
        
        if ($aCampaign['type'] == DataObjects_Campaigns::CAMPAIGN_TYPE_MARKET_CONTRACT) {
            $type = 'OpenX Market Contract';
        }
        
        return $type;
    }
    
    
    /**
     * Helper method used as Core Permission hook to prevent access to 
     * market entities from within core pages like advertiser-edit, campaign-modify.
     *
     * @param string $entityTable
     * @param int $entityId
     * @param int $operationAccessType (see OA_Permission)
     * @param int $accountId
     * @param string $accountType (see OA_Permission)
     * 
     * @return true/false/null true or false when entity is market plugin and 
     *   can/cannot be accessed, null if plugin is not interested in entity 
     */
    public function hasAccessToObject($entityTable, $entityId, 
                        $operationAccessType, $accountId, $accountType)
    {
        $hasAccess = null;    
        switch ($entityTable) {
            case 'clients': {
                /*
                 * Ignore non market advertisers.
                 * Market advertiser cannot be edited, deleted, moved etc.
                 * Can only be viewed.
                 */
                if (!$this->isMarketAdvertiser($entityId)) {
                    break;
                }
                
                switch ($operationAccessType) {
                    case OA_Permission::OPERATION_VIEW : {
                        $hasAccess = true;
                        break;
                    }
                    default: {
                        $hasAccess = false;     
                    }
                }
                break;
            }
            
            case 'campaigns': {
                /*
                 * Ignore non market campaigns. Prevent any operations on campaign
                 * opt in and zone opt in campaigns.
                 */ 
                if (!$this->isMarketCampaign($entityId)) {
                    break;
                }
                
                if (!$this->isMarketContractCampaign($entityId)) { 
                    $hasAccess = false;
                    break;
                }
                
                switch ($operationAccessType) {
                    case OA_Permission::OPERATION_MOVE : {
                        $hasAccess = false;
                        break;
                    }
                    
                    default: {
                        $hasAccess = true;
                    }
                }
                break;
            }
            
            case 'banners' : {
                if (!$this->isMarketBanner($entityId)) {
                    break;
                }
                $hasAccess = false;
                break;
            }            
        }
        
        /*OA::debug("Access check: ". $entityTable . ":" . $entityId 
            . "@" .  $operationAccessType . " AC:" . $accountId . "/" 
            . $accountType.' = '.($hasAccess === null ? 'null' : $hasAccess));*/
        
        return $hasAccess;
    }
    
    
    protected function getEntity($entityTable, $entityId)
    {
        $do = OA_Dal::factoryDO($entityTable);
        $aEntity = null;
                
        if ($do->get($entityId)) {
            $aEntity = $do->toArray();
        }
        
        return $aEntity;
    }
    
    
}