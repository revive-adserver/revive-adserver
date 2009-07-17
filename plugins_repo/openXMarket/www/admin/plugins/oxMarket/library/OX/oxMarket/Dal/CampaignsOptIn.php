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

/**
 * CampaignsOptIn DAL Library
 *
 * @package    openXMarket
 * @author     Miguel Correa  <miguel.correa@openx.org>
 * @author     Lukasz Wikierski  <lukasz.wikierski@openx.org>
 */
class OX_oxMarket_Dal_CampaignsOptIn
{


    /**
     * Perform Opt In works in two ways:
     * - $optInType == 'remnant' => set $minCpm to all remnant campaigns
     * - $optInType == 'selected' => set default CPM or $minCpms if available for $toOptIn campaigns
     *
     * @param string $optInType Type of Opt In method (expected values: 'remnant', 'selected')
     * @param array $minCpms Array of min cpms for campaigns (indexed by campaigns ids) (for optInType=='selected')
     * @param array $toOptIn array of campaigns ids (for optInType=='selected')
     * @param float $minCpm Value of cpm for all campaigns if optInType=='remnant'
     * @return int campains opted in
     */
    public function performOptIn($optInType, $minCpms, $toOptIn, $minCpm)
    {
        // For non remnant mode toOptIn have to be non empty array
        if(($optInType != 'remnant') &&
           (!is_array($toOptIn) || count($toOptIn)==0)) {
            return 0;
        }

        // Opt-in campaigns based on the submitted values
        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doClients = OA_Dal::factoryDO('clients');

        // Get campaigns that belong to advertiser of the current agency
        $doClients->agencyid = OA_Permission::getAgencyId();
        $doCampaigns->joinAdd($doClients, 'LEFT');

        // Ignore already ended campaigns
        $doCampaigns->whereAdd(" expire_time >= '" . $this->getTodayDate() .
                               "' OR expire_time IS NULL");

        if ($optInType == 'remnant') {
            $doCampaigns->whereAdd('priority = ' . DataObjects_Campaigns::PRIORITY_REMNANT .
                                   ' OR priority = ' . DataObjects_Campaigns::PRIORITY_ECPM);
        } else {
            $oDbh = OA_DB::singleton();
            foreach ($toOptIn as $k => $campaignId) {
                $toOptIn[$k] = $oDbh->quote($campaignId, 'integer');
            }
            $doCampaigns->whereAdd(' campaignid IN (' . implode(",", $toOptIn) . ')');
        }

        $doCampaigns->find();
        $campaignsOptedIn = $doCampaigns->getRowCount();
        while ($doCampaigns->fetch()) {
            $campaignId = $doCampaigns->campaignid;
            $cpm = ($optInType == 'remnant') ? $minCpm : $minCpms[$campaignId];
            $this->insertOrUpdateMarketCampaignPref($campaignId, $cpm);
        }

        return $campaignsOptedIn;
    }


    /**
     * Insert or update MarketCampaignPref entry for given campaingId and cpm
     *
     * @param int $campaignId
     * @param float $minCpm
     */
    public function insertOrUpdateMarketCampaignPref($campaignId, $minCpm)
    {
        $doQueryMarketCampaignPref = OA_Dal::factoryDO('ext_market_campaign_pref');
        $doQueryMarketCampaignPref->campaignid = $campaignId;
        $doQueryMarketCampaignPref->find();
        // prepare object to insert or update
        $doMarketCampaignPref = OA_Dal::factoryDO('ext_market_campaign_pref');
        $doMarketCampaignPref->campaignid = $campaignId;
        $doMarketCampaignPref->is_enabled = true;
        $doMarketCampaignPref->floor_price = $minCpm;
        if ($doQueryMarketCampaignPref->fetch()) {
            $doMarketCampaignPref->update();
        } else {
            $doMarketCampaignPref->insert();
        }
    }

    /**
     * Get campaigns of given type, default CPM have to be provided,
     * min CPMs for campaigns are optional
     * NOTICE: formatCpm function must be defined to format minCpm
     *
     * @param float $defaultMinCpm default min CPM
     * @param string $campaignType select campaigns of given type: 'remnant', 'contract', 'all'
     * @param array $minCpms array of campaigns min CPM indexed by campaigns ids
     * @return array of campaigns info: campaignid, campaignname, type, minCpm, minCpmCalculated
     */
    public function getCampaigns($defaultMinCpm, $campaignType = null, $minCpms=array())
    {
        $campaigns = array();

        $doCampaigns = $this->prepareCommonCampaingQuery($campaignType);
        $doMarketCampaignPref = OA_Dal::factoryDO('ext_market_campaign_pref');

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
            $campaigns[$campaignId]['type'] = ($campaignTypeAux == OX_CAMPAIGN_TYPE_ECPM) 
                ? OX_CAMPAIGN_TYPE_REMNANT : $campaignTypeAux;
            $campaigns[$campaignId]['priority'] = $row_campaigns['priority'];
            $campaigns[$campaignId]['revenue'] = $row_campaigns['revenue'];
            $campaigns[$campaignId]['ecpm'] = $row_campaigns['ecpm'];
            $campaigns[$campaignId]['ecpm_enabled'] = $row_campaigns['ecpm_enabled'];
            
            $minCpmCalculated = false;
            $minCpmSpecified = false;                
                
            if (isset($minCpms[$campaignId])) {
                $campaignMinCpm = $minCpms[$campaignId];
                
                //if user has specified same floor as current eCPM/CPM or have not 
                //touched the proposed eCPM/CPM at all and submitted, we should preserve the ecpm marker
                if (self::isECPMEnabledCampaign($row_campaigns) 
                    && $minCpms[$campaignId] == $row_campaigns['ecpm']) {
                    $minCpmCalculated = true;     
                }
                else if ($row_campaigns['revenue_type'] == MAX_FINANCE_CPM 
                    && $minCpms[$campaignId] == $row_campaigns['revenue']) {
                    $minCpmSpecified = true;
                }
            }
            else if (self::isECPMEnabledCampaign($row_campaigns) && is_numeric($row_campaigns['ecpm'])) {
                $campaignMinCpm = formatCpm($row_campaigns['ecpm']);
                $minCpmCalculated = true;
            }
            else if ($row_campaigns['revenue_type'] == MAX_FINANCE_CPM 
                && is_numeric($row_campaigns['revenue'])) {
                $campaignMinCpm = formatCpm($row_campaigns['revenue']);
                $minCpmSpecified = true;
            }
            else {
                $campaignMinCpm = formatCpm($defaultMinCpm);
            }
            
            $campaigns[$campaignId]['minCpm'] = $campaignMinCpm;
            $campaigns[$campaignId]['minCpmCalculated'] = $minCpmCalculated;
            $campaigns[$campaignId]['minCpmSpecified'] = $minCpmSpecified;
        }

        return $campaigns;
    }


    /**
     * Get number of opted campaigns
     *
     * @param string $campaignType count campaigns of given type: 'remnant', 'contract', 'all'
     * @return int
     */
    public function numberOfOptedCampaigns($campaignType = null)
    {
        // Get campaigns based on the criteria
        $doCampaigns = $this->prepareCommonCampaingQuery($campaignType);
        $doMarketCampaignPref = OA_Dal::factoryDO('ext_market_campaign_pref');

        $doCampaigns->joinAdd($doMarketCampaignPref, 'LEFT');

        // Ignore campaigns that are already Opt in
        $doCampaigns->whereAdd(OA_Dal::getTablePrefix().'ext_market_campaign_pref.is_enabled = 1');

        $doCampaigns->find();
        $numberOfOptedCampaigns = $doCampaigns->getRowCount();

        return $numberOfOptedCampaigns;
    }


    /**
     * Get number of remrant campaigns
     *
     * @return int
     */
    public function  numberOfRemnantCampaignsToOptIn()
    {
        // Get campaigns based on the criteria
        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doClients = OA_Dal::factoryDO('clients');

        // Get campaigns that belong to advertiser of the current agency
        $doClients->agencyid = OA_Permission::getAgencyId();
        $doCampaigns->joinAdd($doClients, 'LEFT');

        // Ignore already ended campaigns
        $doCampaigns->whereAdd("expire_time >= '" . $this->getTodayDate() . "' OR expire_time IS NULL");

        $doCampaigns->whereAdd('priority = ' . DataObjects_Campaigns::PRIORITY_REMNANT .
                               ' OR priority = ' . DataObjects_Campaigns::PRIORITY_ECPM);
        $doCampaigns->find();
        $numberOfRemnantCampaignsToOptIn = $doCampaigns->getRowCount();

        return $numberOfRemnantCampaignsToOptIn;
    }


    /**
     * Get today as string formated YYYY-MM-DD
     *
     * @return string
     */
    private function getTodayDate()
    {
        $oDate = new Date();
        $oDate->setTZbyID('UTC');
        return $oDate->format("%Y-%m-%d");
    }


    /**
     * Prepares common query for searching not ended campaigns of given type
     *
     * @param string $campaignType
     * @return DataObjects_Campaigns
     */
    private function prepareCommonCampaingQuery($campaignType)
    {
        // Get campaigns based on the criteria
        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doClients = OA_Dal::factoryDO('clients');

        // Get campaigns that belong to advertiser of the current agency
        $doClients->agencyid = OA_Permission::getAgencyId();
        $doCampaigns->joinAdd($doClients, 'LEFT');
        $doCampaigns->selectAs(array('campaignid'), 'campaign_id');

        // Ignore already ended campaigns
        $doCampaigns->whereAdd(" expire_time >= '" . $this->getTodayDate() . "' OR expire_time IS NULL");

        // If not all campaigns selected set the selected campaign type
        if ($campaignType == 'remnant') {
            $doCampaigns->whereAdd('priority = ' . DataObjects_Campaigns::PRIORITY_REMNANT .
                                   ' OR priority = ' . DataObjects_Campaigns::PRIORITY_ECPM);
        } elseif ($campaignType == 'contract') {
            $doCampaigns->whereAdd('priority > 0');
        } elseif ($campaignType == 'all') {
            $doCampaigns->whereAdd('priority != -1');
        }

        return $doCampaigns;
    }
    
    
    /**
     * Returns true if campaign is remnant eCPM enabled campaign, or if it is
     * contract campaign with ecpm_enabled
     *
     * @param unknown_type $aCampaign
     * @return unknown
     */    
    public static function isECPMEnabledCampaign($aCampaign)
    {
        $campaignTypeAux = OX_Util_Utils::getCampaignType($aCampaign['priority']);
        return $campaignTypeAux == OX_CAMPAIGN_TYPE_ECPM || $aCampaign['ecpm_enabled'];
    }
}
