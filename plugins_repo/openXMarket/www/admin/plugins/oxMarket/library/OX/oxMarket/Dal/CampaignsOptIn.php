<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
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
$Id: CampaignsOptIn.php$
*/

class OX_oxMarket_Dal_CampaignsOptIn
{

    
    function performOptIn($minCpms, $optInType, $toOptIn, $minCpm, $campaignType)
    {
        //global $optInType, $toOptIn, $minCpm, $campaignType;
    
        // Opt-in campaigns based on the submitted values
        if ($optInType == 'remnant') {
    
            $oDate = new Date();
            $oDate->setTZbyID('UTC');
            $strToday = $oDate->format("%Y-%m-%d");
    
            $doCampaigns = OA_Dal::factoryDO('campaigns');
            $doClients = OA_Dal::factoryDO('clients');
    
            // Get campaigns that belong to advertiser of the current agency
            $doClients->agencyid = OA_Permission::getAgencyId();
            $doCampaigns->joinAdd($doClients, 'LEFT');
    
            // Ignore already ended campaigns
            $doCampaigns->whereAdd(" expire >= '" . $strToday . "' OR expire " . $this->getNullDate());
    
            $doCampaigns->whereAdd('priority = ' . DataObjects_Campaigns::PRIORITY_REMNANT . ' OR priority = ' . DataObjects_Campaigns::PRIORITY_ECPM);
    
            $doCampaigns->find();
            $campaignsOptedIn = $doCampaigns->getRowCount();
            while ($doCampaigns->fetch()) {
                $campaignId = $doCampaigns->campaignid;
                $doMarketCampaignPref = OA_Dal::factoryDO('ext_market_campaign_pref');
                $doMarketCampaignPref->campaignid = $campaignId;
                $doMarketCampaignPref->find();
                if ($doMarketCampaignPref->fetch()) {
                    $doMarketCampaignPref = OA_Dal::factoryDO('ext_market_campaign_pref');
                    $doMarketCampaignPref->campaignid = $campaignId;
                    $doMarketCampaignPref->is_enabled = true;
                    $doMarketCampaignPref->floor_price = $minCpm;
                    $doMarketCampaignPref->update();
                } else {
                    $doMarketCampaignPref = OA_Dal::factoryDO('ext_market_campaign_pref');
                    $doMarketCampaignPref->campaignid = $campaignId;
                    $doMarketCampaignPref->is_enabled = true;
                    $doMarketCampaignPref->floor_price = $minCpm;
                    $doMarketCampaignPref->insert();
                }
            }
        } else {
            foreach ($toOptIn as $campaignId) {
                $doMarketCampaignPref = OA_Dal::factoryDO('ext_market_campaign_pref');
                $doMarketCampaignPref->campaignid = $campaignId;
                $doMarketCampaignPref->find();
                if ($doMarketCampaignPref->fetch()) {
                    $doMarketCampaignPref = OA_Dal::factoryDO('ext_market_campaign_pref');
                    $doMarketCampaignPref->campaignid = $campaignId;
                    $doMarketCampaignPref->is_enabled = true;
                    $doMarketCampaignPref->floor_price = $minCpms[$campaignId];
                    $doMarketCampaignPref->update();
                } else {
                    $doMarketCampaignPref = OA_Dal::factoryDO('ext_market_campaign_pref');
                    $doMarketCampaignPref->campaignid = $campaignId;
                    $doMarketCampaignPref->is_enabled = true;
                    $doMarketCampaignPref->floor_price = $minCpms[$campaignId];
                    $doMarketCampaignPref->insert();
                }
            }
    
            $campaignsOptedIn = count($toOptIn);
        }
        
        return $campaignsOptedIn;
    }


    // NOTICE: formatCpm function must be defined    
    function getCampaigns($campaignType = null, $minCpms=array())
    {
        $campaigns = array();
    
        $oDate = new Date();
        $oDate->setTZbyID('UTC');
        $strToday = $oDate->format("%Y-%m-%d");
    
        // Get campaigns based on the criteria
        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doClients = OA_Dal::factoryDO('clients');
        $doMarketCampaignPref = OA_Dal::factoryDO('ext_market_campaign_pref');
    
        // Get campaigns that belong to advertiser of the current agency
        $doClients->agencyid = OA_Permission::getAgencyId();
        $doCampaigns->joinAdd($doClients, 'LEFT');
        $doCampaigns->selectAs(array('campaignid'), 'campaign_id');
    
        // Ignore already ended campaigns
        $doCampaigns->whereAdd(" expire >= '" . $strToday . "' OR expire " . $this->getNullDate());
    
        // If not all campaigns selected set the selected campaign type
        if ($campaignType == 'remnant') {
            $doCampaigns->whereAdd('priority = ' . DataObjects_Campaigns::PRIORITY_REMNANT . ' OR priority = ' . DataObjects_Campaigns::PRIORITY_ECPM);
        } elseif ($campaignType == 'contract') {
            $doCampaigns->whereAdd('priority > 0');
        } elseif ($campaignType == 'all') {
            $doCampaigns->whereAdd('priority != -1');
        }
    
        // Do we have data in ext_market_campaign_pref?
        if ($doMarketCampaignPref->count() > 0) {
            $doCampaigns->joinAdd($doMarketCampaignPref, 'LEFT');
            // Ignore campaigns that are already Opt in
            $doCampaigns->whereAdd(OA_Dal::getTablePrefix() .'ext_market_campaign_pref.is_enabled IS NULL OR '
                                  .OA_Dal::getTablePrefix().'ext_market_campaign_pref.is_enabled = 0');
        }
    
        $doCampaigns->find();
        while ($doCampaigns->fetch() && $row_campaigns = $doCampaigns->toArray()) {
            $row_campaigns['campaignid'] = $row_campaigns['campaign_id'];
            $campaignId = $row_campaigns['campaignid'];
            $campaigns[$row_campaigns['campaignid']]['campaignid']   = $campaignId;
            $campaign_details = Admin_DA::getPlacement($row_campaigns['campaignid']);
            $campaigns[$campaignId]['campaignname'] = MAX_getPlacementName($campaign_details);
            $campaignTypeAux = OX_Util_Utils::getCampaignType($row_campaigns['priority']);
            // Take ECPM campaigns as remnant campaigns
            $campaigns[$campaignId]['type'] = ($campaignTypeAux == 4) ? OX_CAMPAIGN_TYPE_REMNANT : $campaignTypeAux;
            $campaignMinCpm = (isset($minCpms[$campaignId]) ? $minCpms[$campaignId] :
            formatCpm(!empty($row_campaigns['ecpm']) ? $row_campaigns['ecpm'] : DEFAULT_OPT_IN_CPM));
            $campaigns[$campaignId]['minCpm'] = $campaignMinCpm;
            $campaigns[$campaignId]['minCpmCalculated'] = !empty($row_campaigns['ecpm']);
        }
    
        return $campaigns;
    }

    function numberOfOptedCampaigns($campaignType = null, $minCpms=null)
    {
        $campaigns = array();
    
        $oDate = new Date();
        $oDate->setTZbyID('UTC');
        $strToday = $oDate->format("%Y-%m-%d");
    
        // Get campaigns based on the criteria
        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doClients = OA_Dal::factoryDO('clients');
        $doMarketCampaignPref = OA_Dal::factoryDO('ext_market_campaign_pref');
    
        // Get campaigns that belong to advertiser of the current agency
        $doClients->agencyid = OA_Permission::getAgencyId();
        $doCampaigns->joinAdd($doClients, 'LEFT');
        $doCampaigns->joinAdd($doMarketCampaignPref, 'LEFT');
    
        // Ignore already ended campaigns
        $doCampaigns->whereAdd(" expire >= '" . $strToday . "' OR expire " . $this->getNullDate());
    
        // If not all campaigns selected set the selected campaign type
        if ($campaignType == 'remnant') {
            $doCampaigns->whereAdd('priority = ' . DataObjects_Campaigns::PRIORITY_REMNANT . ' OR priority = ' . DataObjects_Campaigns::PRIORITY_ECPM);
        } elseif ($campaignType == 'contract') {
            $doCampaigns->whereAdd('priority > 0');
        } elseif ($campaignType == 'all') {
            $doCampaigns->whereAdd('priority != -1');
        }
    
        // Ignore campaigns that are already Opt in
        $doCampaigns->whereAdd(OA_Dal::getTablePrefix().'ext_market_campaign_pref.is_enabled = 1');
    
        $doCampaigns->find();
        $numberOfOptedCampaigns = $doCampaigns->getRowCount();
    
        return $numberOfOptedCampaigns;
    }


    function  numberOfRemnantCampaignsToOptIn()
    {
        $campaigns = array();
    
        $oDate = new Date();
        $oDate->setTZbyID('UTC');
        $strToday = $oDate->format("%Y-%m-%d");
    
        // Get campaigns based on the criteria
        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doClients = OA_Dal::factoryDO('clients');
    
        // Get campaigns that belong to advertiser of the current agency
        $doClients->agencyid = OA_Permission::getAgencyId();
        $doCampaigns->joinAdd($doClients, 'LEFT');
    
        // Ignore already ended campaigns
        $doCampaigns->whereAdd(" expire >= '" . $strToday . "' OR expire " . $this->getNullDate());
    
        $doCampaigns->whereAdd('priority = ' . DataObjects_Campaigns::PRIORITY_REMNANT . ' OR priority = ' . DataObjects_Campaigns::PRIORITY_ECPM);
        $doCampaigns->find();
        $numberOfRemnantCampaignsToOptIn = $doCampaigns->getRowCount();
    
        return $numberOfRemnantCampaignsToOptIn;
    }


    function getNullDate()
    {
        $nullDate = OA_Dal::noDateValue();
        if (empty($nullDate)) {
            $nullDate = "is NULL";
        } else {
            $nullDate = "= '" . $nullDate . "'";
        }
    
        return $nullDate;
    }
    
}
