<?php

/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
*/

require_once MAX_PATH . '/lib/OA/Admin/UI/model/PageHeaderModel.php';
require_once MAX_PATH . '/lib/OA/Admin/UI/model/EntityBreadcrumbSegment.php';

/**
 * A builder for inventory headers
 */
class OA_Admin_UI_Model_InventoryPageHeaderModelBuilder
{
    public function buildAdvertiserHeader($advertiserId)    
    {
        if ($advertiserId) {
           $aAdvertiser = phpAds_getClientDetails($advertiserId);
        }
        return $this->buildEntityHeader(array(
            array("name" => $aAdvertiser['clientname'])),
            "advertiser", $advertiserId == '', "edit");
    }
    
    
    /**
     * Builds entity header, with breadcrumbs, links proper classes etc.
     *
     * @param unknown_type $aEntityNamesUrls
     * @param unknown_type $entityClass
     * @param unknown_type $pageType
     * @return OA_Admin_UI_Model_PageHeaderModel
     */
    public function buildEntityHeader($aEntityNamesUrls, $entityClass, $pageType = "default")
    {
        
        $headerMeta = $this->getEntityHeaderMeta($entityClass);
        $oHeader = new OA_Admin_UI_Model_PageHeaderModel();
        $entityCount = count($aEntityNamesUrls);
        if ($pageType == "edit-new" || $pageType == "list") {
            if ($pageType == "edit-new") {
                $oHeader->setTitle($headerMeta['newLabel']);
                if (!empty($headerMeta['newHeaderClass'])) {
                    $oHeader->setIconClass($headerMeta['newHeaderClass']);
                }
                else {
                    $oHeader->setIconClass($headerMeta['headerClass']);
                }
            }
            else {
                $oHeader->setTitle($headerMeta['label']);
                $oHeader->setIconClass($headerMeta['headerClass']);
                
            }
            if ($entityCount - 2 >= 0) {
                $oHeader->setNewTargetTitle($headerMeta['newTarget']);
                $oHeader->setNewTargetName($aEntityNamesUrls[$entityCount - 2]['name']);
                if ($pageType == "list") {                
                    $oHeader->setNewTargetLink($aEntityNamesUrls[$entityCount - 2]['url']);
                }
            }
        }
        else {
            $oHeader->setTitle($headerMeta['label']);
            $oHeader->setEntityName($aEntityNamesUrls[$entityCount - 1]['name']);
            $oHeader->setIconClass($headerMeta['headerClass']);
        }
        $oHeader->setPageType($pageType);
        
        $breadcrumbPath = $this->getEntityBreadcrumbPath($entityClass);
        // Breadcrumbs above the main title
        for ($i = 0; $i < $entityCount - 1; $i++) {
            if(empty($aEntityNamesUrls[$i]["name"])) {
                continue;                            
            }
            $headerMeta = $this->getEntityHeaderMeta($breadcrumbPath[$i]);
            $oSegment = new OA_Admin_UI_Model_EntityBreadcrumbSegment();
            $oSegment->setEntityName($aEntityNamesUrls[$i]["name"]);
            $oSegment->setEntityLabel($headerMeta['label']);
            $oSegment->setCssClass($headerMeta['class']);
            $oSegment->setUrl($aEntityNamesUrls[$i]["url"]);
            
            //for list segments
            $oSegment->setEntityId($aEntityNamesUrls[$i]['id']);
            $oSegment->setHtmlName($aEntityNamesUrls[$i]['htmlName']);
            $oSegment->setEntityMap($aEntityNamesUrls[$i]['entities']);
                
            $oHeader->addSegment($oSegment);                
        }

        return $oHeader;
    }
    
    
    function getEntityHeaderMeta($entityClass)
    {
        switch ($entityClass)
        {
            case 'advertiser':
               return array('label' => $GLOBALS['strClient'], 'newLabel' => $GLOBALS['strAddClient'], 
                'class' => 'iconAdvertiser', 'headerClass' => 'iconAdvertiserLarge', 
                'newHeaderClass' => 'iconAdvertiserAddLarge');
    
            case 'campaign':
               return array('label' => $GLOBALS['strCampaign'], 'newLabel' => $GLOBALS['strAddCampaign'], 
                'newTarget' => $GLOBALS['strCampaignForAdvertiser'], 'class' => 'iconCampaign', 
                'headerClass' => 'iconCampaignLarge', 'newHeaderClass' => 'iconCampaignAddLarge');
    
            case 'tracker':
               return array('label' => $GLOBALS['strTracker'], 'newLabel' => $GLOBALS['strAddTracker'], 
                'newTarget' => $GLOBALS['strTrackerForAdvertiser'], 'class' => 'track', 
                'headerClass' => 'iconTrackerLarge', 'newHeaderClass' => 'iconTrackerAddLarge');
    
            case 'banner':
               return array('label' => $GLOBALS['strBanner'], 'newLabel' => $GLOBALS['strAddBanner'], 
                'newTarget' => $GLOBALS['strBannerToCampaign'], 'class' => 'ban',
                'headerClass' => 'iconBannerLarge', 'newHeaderClass' => 'iconBannerAddLarge');
    
            case 'website':
               return array('label' => $GLOBALS['strAffiliate'], 'newLabel' => $GLOBALS['strAddNewAffiliate'], 
                'class' => 'webs', 'headerClass' => 'iconWebsiteLarge', 
                'newHeaderClass' => 'iconWebsiteAddLarge');
    
            case 'zone':
               return array('label' => $GLOBALS['strZone'], 'newLabel' => $GLOBALS['strAddNewZone'], 
                'newTarget' => $GLOBALS['strZoneToWebsite'], 'class' => 'zone',
                'headerClass' => 'iconZoneLarge', 'newHeaderClass' => 'iconZoneAddLarge');
    
            case 'channel':
               return array('label' => $GLOBALS['strChannel'], 'newLabel' => $GLOBALS['strAddNewChannel'], 
                'newTarget' => $GLOBALS['strChannelToWebsite'], 'class' => 'chan', 
                'headerClass' => 'iconTargetingChannelLarge', 'newheaderClass' => 'iconTargetingChannelAddLarge');
               
            case 'global-channel':
               return array('label' => $GLOBALS['strChannel'], 'newLabel' => $GLOBALS['strAddNewChannel'], 
                'class' => 'chan', 'headerClass' => 'iconTargetingChannelLarge', 
                'newheaderClass' => 'iconTargetingChannelAddLarge');
    
            case 'agency':
               return array('label' => $GLOBALS['strAgency'], 'newLabel' => $GLOBALS['strAddAgency'], 
               'class' => 'agen', 'headerClass' => 'iconManagerLarge', 
                'newheaderClass' => 'iconManagerAddLarge');
    
            case 'day':
               return array('label' => $GLOBALS['strDay'], 'newLabel' => '', 'class' => 'day');

            case 'advertisers':
               return array('label' => $GLOBALS['strClients'], 'headerClass' => 'iconAdvertisersLarge');
               
            case 'campaigns':
               return array('label' => $GLOBALS['strCampaigns'], 'headerClass' => 'iconCampaignsLarge', 
                'newTarget' => $GLOBALS['strCampaignsOfAdvertiser']);
               
            case 'banners':
               return array('label' => $GLOBALS['strBanners'], 'headerClass' => 'iconBannersLarge', 
                'newTarget' => $GLOBALS['strBannersOfCampaign']);

            case 'websites':
               return array('label' => $GLOBALS['strAffiliates'], 'headerClass' => 'iconWebsitesLarge');
               
            case 'zones':
               return array('label' => $GLOBALS['strZones'], 'headerClass' => 'iconZonesLarge', 
                'newTarget' => $GLOBALS['strZonesOfWebsite']);
               
            case 'channels':
               return array('label' => $GLOBALS['strChannels'], 'headerClass' => 'iconTargetingChannelsLarge', 
                'newTarget' => $GLOBALS['strChannelsOfWebsite']);
        }
    
        return null;
    }
    
    
    function getEntityBreadcrumbPath($entityClass)
    {
        switch ($entityClass)
        {
            case 'banner':
                return array('advertiser', 'campaign', 'banner');
                
            case 'campaign':
                return array('advertiser', 'campaign');
                
            case 'advertiser':
                return array('advertiser');
    
            case 'tracker':
                return array('advertiser', 'tracker');
    
            case 'website':
            case 'zone':
                return array('website', 'zone');
    
            case 'trafficker-zone':
                return array('zone');
    
            case 'channel':
                return array('website', 'channel');
    
            case 'global-channel':
                return array('channel');
    
            case 'agency':
                return array('agency');

            case 'advertisers':    
                return array();
                
            case 'campaigns':
                return array('advertiser');
                
            case 'banners':
                return array('advertiser', 'campaign');
                
            case 'websites':    
                return array();
                
            case 'zones':
            case 'channels':
                return array('website');
        }
    
        return null;
    }    
}
?>