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

/**
 * Campaign DAL Library. 
 * Handles PC API calls and operations on DataObjects for various operation on campaigns 
 *
 * @package    openXMarket
 * @author     Lukasz Wikierski <lukasz.wikierski@openx.org>
 */
class OX_oxMarket_Dal_Campaign
{

    
    public function saveCampaign($aCampaign)
    {
        //TODO do some processing
        return array();
        
        
        //before save
        
        if (empty($aFields['campaignid'])) {
            // The form is submitting a new campaign, so, the ID is not set;
            // set the ID to the string "null" so that the table auto_increment
            // or sequence will be used when the campaign is created
            $aFields['campaignid'] = "null";
        } 
        else {
            // The form is submitting a campaign modification; need to test
            // if any of the banners in the campaign are linked to an email zone,
            // and if so, if the link(s) would still be valid if the change(s)
            // to the campaign were made...
            $dalCampaigns = OA_Dal::factoryDAL('campaigns');
            $aCurrentLinkedEmalZoneIds = $dalCampaigns->getLinkedEmailZoneIds($aFields['campaignid']);
            if (PEAR::isError($aCurrentLinkedEmalZoneIds)) {
                OX::disableErrorHandling();
                $errors[] = PEAR::raiseError($GLOBALS['strErrorDBPlain']);
                OX::enableErrorHandling();
            }
            $errors = array();
            foreach ($aCurrentLinkedEmalZoneIds as $zoneId) {
                $thisLink = Admin_DA::_checkEmailZoneAdAssoc($zoneId, $aFields['campaignid'], $activate, $expire);
                if (PEAR::isError($thisLink)) {
                    $errors[] = $thisLink;
                    break;
                }
            }
        }        

        //before save
        if (!empty($aFields['campaignid']) && $aFields['campaignid'] != "null") {
            $doCampaigns->campaignid = $aFields['campaignid'];
            $doCampaigns->setEcpmEnabled();
            $doCampaigns->update();
        } 
        else {
            $doCampaigns->setEcpmEnabled();
            $aFields['campaignid'] = $doCampaigns->insert();
        }
        
        
        //after save
        

        // Recalculate priority only when editing a campaign
        // or moving banners into a newly created, and when:
        //
        // - campaign changes status (activated or deactivated) or
        // - the campaign is active and target/weight are changed
        //
        if (!$newCampaign) {
            $doCampaigns = OA_Dal::staticGetDO('campaigns', $aFields['campaignid']);
            $status = $doCampaigns->status;
            switch (true) {
                case ((bool) $status != (bool) $aFields['status_old']) :
                    // Run the Maintenance Priority Engine process
                    OA_Maintenance_Priority::scheduleRun();
                    break;
                
                case ($status == OA_ENTITY_STATUS_RUNNING) :
                    if ((!empty($aFields['target_type']) && ${$aFields['target_type']} != $aFields['target_old']) || (!empty($aFields['target_type']) && $aFields['target_type_old'] != $aFields['target_type']) || $aFields['weight'] != $aFields['weight_old'] || $aFields['clicks'] != $aFields['previousclicks'] || $aFields['conversions'] != $aFields['previousconversions'] || $aFields['impressions'] != $aFields['previousimpressions']) {
                        // Run the Maintenance Priority Engine process
                        OA_Maintenance_Priority::scheduleRun();
                    }
                    break;
            }
        }
        
        // Rebuild cache
        // include_once MAX_PATH . '/lib/max/deliverycache/cache-'.$conf['delivery']['cache'].'.inc.php';
        // phpAds_cacheDelete();
        
    
        // Delete channel forecasting cache
        include_once 'Cache/Lite.php';
        $options = array ('cacheDir' => MAX_CACHE);
        $cache = new Cache_Lite($options);
        $group = 'campaign_' . $aFields['campaignid'];
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