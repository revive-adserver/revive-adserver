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
            $doClients = OA_Dal::factoryDO('clients');
            if ($doClients->get($data)) {
                $aAdvertiser = $doClients->toArray();
            }
        }
        else {
            $aAdvertiser = $data;
        }
        
        return $aAdvertiser['type'] == DataObjects_Clients::ADVERTISER_TYPE_MARKET;
    }    
    

    /**
     * Checks if given campaign is market campaign
     *
     * @param array|string|int $id
     */
    public function isMarketCampaign($data)
    {
        if (!isset($data)) {
            return false;
        }
                
        if (!is_array($data)) {
            $aCampaign = array();
            $doCampaigns = OA_Dal::factoryDO('campaigns');
            if ($doCampaigns->get($data)) { //should be an id
                $aCampaign = $doCampaigns->toArray ();
            }            
        }
        else {
            $aCampaign = $data;
        }
        
        return $aCampaign['system'] == true;
    }
    
    
    /**
     * Checks if given campaign is market campaign
     *
     * @param array|string|int $id
     */
    public function isMarketDefaultCampaign($data)
    {
        if (!isset($data)) {
            return false;
        }
        
        if (!is_array($data)) {
            // Get the campaign data from the campaign table, and store in $campaign
            $doCampaigns = OA_Dal::factoryDO('campaigns');
            $doCampaigns->get($data); //should be an id
            $aCampaign = $doCampaigns->toArray ();            
        }
        else {
            $aCampaign = $data;
        }

        return $aCampaign['system'] == true 
            && $aCampaign['systemtype'] == self::$MARKET_CAMPAIGN_REMNANT;
    }
    
    
    /**
     * Checks if given campaign is market contract campaign (created by user)
     *
     * @param array|string|int $id
     */
    public function isMarketContractCampaign($data)
    {
        if (!isset($data)) {
            return false;
        }
        
        if (!is_array($data)) {
            // Get the campaign data from the campaign table, and store in $campaign
            $doCampaigns = OA_Dal::factoryDO('campaigns');
            $doCampaigns->get($data); //should be an id
            $aCampaign = $doCampaigns->toArray ();            
        }
        else {
            $aCampaign = $data;
        }

        return $aCampaign['system'] == true 
            && $aCampaign['systemtype'] == self::$MARKET_CAMPAIGN_CONTRACT;
    }    
    
    
    
    /**
     * Enter description here...
     *
     * @param array $aCampaign
     */
    public function getCampaignTypeName($aCampaign)
    {
        $type = 'Unknown';
        
        if ($aCampaign['system']) {
            if ($aCampaign['systemtype'] == self::$MARKET_CAMPAIGN_REMNANT) {
                $type = 'OpenX Market Remnant';                
            }
            else if($aCampaign['systemtype'] == self::$MARKET_CAMPAIGN_CONTRACT) {
                $type = 'OpenX Market Contract';
            }
        }
        
        
        return $type;
    }
    
}