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
$Id: Website.php 41993 2009-08-24 15:18:37Z lukasz.wikierski $
*/
require_once OX_MARKET_LIB_PATH . '/OX/oxMarket/Dal/CampaignsOptIn.php';
require_once MAX_PATH . '/lib/OA/Maintenance/Priority.php';

/**
 * Campaign DAL Library. 
 * Handles PC API calls and operations on DataObjects for various operation on campaigns 
 *
 * @package    openXMarket
 * @author     Lukasz Wikierski <lukasz.wikierski@openx.org>
 */
class OX_oxMarket_Dal_Campaign
{

    
    /**
     * Save market contract campaign
     *
     * @param array $aCampaign
     */
    public function saveCampaign($aCampaign)
    {

        if (empty($aCampaign['campaignid'])) {
            // The form is submitting a new campaign, so, the ID is not set;
            // set the ID to the string "null" so that the table auto_increment
            // or sequence will be used when the campaign is created
            $aCampaign['campaignid'] = "null";
        } 
        else {
            // The form is submitting a campaign modification; need to test
            // if any of the banners in the campaign are linked to an email zone,
            // and if so, if the link(s) would still be valid if the change(s)
            // to the campaign were made...
            // TODO: remove if market banner can't be linked to email zone
            $dalCampaigns = OA_Dal::factoryDAL('campaigns');
            $aCurrentLinkedEmalZoneIds = $dalCampaigns->getLinkedEmailZoneIds($aCampaign['campaignid']);
            if (PEAR::isError($aCurrentLinkedEmalZoneIds)) {
                OX::disableErrorHandling();
                $errors[] = PEAR::raiseError($GLOBALS['strErrorDBPlain']);
                OX::enableErrorHandling();
            }
            $errors = array();
            foreach ($aCurrentLinkedEmalZoneIds as $zoneId) {
                $thisLink = Admin_DA::_checkEmailZoneAdAssoc($zoneId, $aCampaign['campaignid'], $activate, $expire);
                if (PEAR::isError($thisLink)) {
                    $errors[] = $thisLink;
                    break;
                }
            }
        }        

        // insert/edit campaign
        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->campaignname = $aCampaign['campaignname'];
        $doCampaigns->clientid = $aCampaign['clientid'];
        $doCampaigns->views = $aCampaign['impressions'];
        $doCampaigns->priority = $aCampaign['priority'];
        $doCampaigns->weight = $aCampaign['weight'];
        $doCampaigns->target_impression = $target_impression;
        $doCampaigns->min_impressions = $aCampaign['min_impressions'];
        $doCampaigns->type = DataObjects_Campaigns::CAMPAIGN_TYPE_MARKET_CONTRACT;
        //$doCampaigns->comments = $aCampaign['comments'];
        //$doCampaigns->revenue = $aCampaign['revenue'];
        //$doCampaigns->revenue_type = $aCampaign['revenue_type'];
        $activate = $aCampaign['activate_time'];
        $expire = $aCampaign['expire_time'];
        $doCampaigns->activate_time = isset($activate) ? $activate : OX_DATAOBJECT_NULL;
        $doCampaigns->expire_time = isset($expire) ? $expire : OX_DATAOBJECT_NULL;
        // Activation and expiration
                
        if (!empty($aCampaign['campaignid']) && $aCampaign['campaignid'] != "null") {
            $doCampaigns->campaignid = $aCampaign['campaignid'];
            $doCampaigns->setEcpmEnabled();
            $doCampaigns->update();
        } else {
            $doCampaigns->setEcpmEnabled();
            $aCampaign['campaignid'] = $doCampaigns->insert();
            // create banner
            $this->addMarketBanner($aCampaign['campaignid'],'OpenX Market contract campaign ads');
        }
        
        // optin to the market
        $oCampaignsOptIn = new OX_oxMarket_Dal_CampaignsOptIn();
        $oCampaignsOptIn->insertOrUpdateMarketCampaignPref($aCampaign['campaignid'], 0.0);
       
        // Recalculate priority only when editing a campaign
        // or moving banners into a newly created, and when:
        //
        // - campaign changes status (activated or deactivated) or
        // - the campaign is active and target/weight are changed
        //
        if (!$newCampaign) {
            $doCampaigns = OA_Dal::staticGetDO('campaigns', $aCampaign['campaignid']);
            $status = $doCampaigns->status;
            switch (true) {
                case ((bool) $status != (bool) $aCampaign['status_old']) :
                    // Run the Maintenance Priority Engine process
                    OA_Maintenance_Priority::scheduleRun();
                    break;
                
                case ($status == OA_ENTITY_STATUS_RUNNING) :
                    if ((!empty($aCampaign['target_type']) && ${$aCampaign['target_type']} != $aCampaign['target_old']) || (!empty($aCampaign['target_type']) && $aCampaign['target_type_old'] != $aCampaign['target_type']) || $aCampaign['weight'] != $aCampaign['weight_old'] || $aCampaign['clicks'] != $aCampaign['previousclicks'] || $aCampaign['conversions'] != $aCampaign['previousconversions'] || $aCampaign['impressions'] != $aCampaign['previousimpressions']) {
                        // Run the Maintenance Priority Engine process
                        OA_Maintenance_Priority::scheduleRun();
                    }
                    break;
            }
        }

        // Delete channel forecasting cache
        include_once 'Cache/Lite.php';
        $options = array ('cacheDir' => MAX_CACHE);
        $cache = new Cache_Lite($options);
        $group = 'campaign_' . $aCampaign['campaignid'];
        $cache->clean($group);        
        
    }
   
    
    /**
     * Add market Campaign
     *
     * @param int $clientid
     * @param int $type
     * @param string $campaignname
     * @param string $bannerdesc
     * @return int campaign id
     */
    public function addMarketCampaign($clientid, $type, $campaignname, $bannerdesc = null)
    {
        $doCampaign = OA_DAl::factoryDO('campaigns');
        $doCampaign->clientid = $clientid;
        $doCampaign->type = $type;
        $doCampaign->campaignname = $campaignname;
        $doCampaign->ecpm_enabled = 0;
        $doCampaign->revenue_type = OX_DATAOBJECT_NULL;
        $doCampaign->priority = DataObjects_Campaigns::PRIORITY_MARKET_REMNANT;
        $campaignId = $doCampaign->insert();
        // add banner
        $bannerdesc = isset($bannerdesc) ? $bannerdesc : $campaignname;    
        $this->addMarketBanner($campaignId, $bannerdesc);
        return $campaignId; 
    }
    
    
    /**
     * create market banner
     *
     * @param int $campaignid
     * @param string $description
     * @return int banner id
     */
    protected function addMarketBanner($campaignid, $description)
    {
        $doBanner = OA_Dal::factoryDO('banners');
        $doBanner->campaignid = $campaignid;
        $doBanner->width = -1;
        $doBanner->height = -1;
        $doBanner->contenttype = 'html';
        $doBanner->storagetype = 'html';
        $doBanner->ext_bannertype = DataObjects_Banners::BANNER_TYPE_MARKET;
        $doBanner->status = OA_ENTITY_STATUS_RUNNING;
        $doBanner->description = $description;
        return $doBanner->insert();
    }
}