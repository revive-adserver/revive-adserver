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
        return $this->buildEntityHeader(
            [
            ["name" => $aAdvertiser['clientname']]],
            "advertiser",
            $advertiserId == ''
        );
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
                } else {
                    $oHeader->setIconClass($headerMeta['headerClass']);
                }
            } else {
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
        } else {
            $oHeader->setTitle($headerMeta['label']);
            $oHeader->setEntityName($aEntityNamesUrls[$entityCount - 1]['name']);
            $oHeader->setIconClass($headerMeta['headerClass']);
        }
        $oHeader->setPageType($pageType);
        
        $breadcrumbPath = $this->getEntityBreadcrumbPath($entityClass);
        // Breadcrumbs above the main title
        for ($i = 0; $i < $entityCount - 1; $i++) {
            if (empty($aEntityNamesUrls[$i]["name"])) {
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
    
    
    public function getEntityHeaderMeta($entityClass)
    {
        switch ($entityClass) {
            case 'advertiser':
               return ['label' => $GLOBALS['strClient'], 'newLabel' => $GLOBALS['strAddClient'],
                'class' => 'iconAdvertiser', 'headerClass' => 'iconAdvertiserLarge',
                'newHeaderClass' => 'iconAdvertiserAddLarge'];
    
            case 'campaign':
               return ['label' => $GLOBALS['strCampaign'], 'newLabel' => $GLOBALS['strAddCampaign'],
                'newTarget' => $GLOBALS['strCampaignForAdvertiser'], 'class' => 'iconCampaign',
                'headerClass' => 'iconCampaignLarge', 'newHeaderClass' => 'iconCampaignAddLarge'];
    
            case 'tracker':
               return ['label' => $GLOBALS['strTracker'], 'newLabel' => $GLOBALS['strAddTracker'],
                'newTarget' => $GLOBALS['strTrackerForAdvertiser'], 'class' => 'track',
                'headerClass' => 'iconTrackerLarge', 'newHeaderClass' => 'iconTrackerAddLarge'];
    
            case 'banner':
               return ['label' => $GLOBALS['strBanner'], 'newLabel' => $GLOBALS['strAddBanner'],
                'newTarget' => $GLOBALS['strBannerToCampaign'], 'class' => 'ban',
                'headerClass' => 'iconBannerLarge', 'newHeaderClass' => 'iconBannerAddLarge'];
    
            case 'website':
               return ['label' => $GLOBALS['strAffiliate'], 'newLabel' => $GLOBALS['strAddNewAffiliate'],
                'class' => 'webs', 'headerClass' => 'iconWebsiteLarge',
                'newHeaderClass' => 'iconWebsiteAddLarge'];
    
            case 'zone':
               return ['label' => $GLOBALS['strZone'], 'newLabel' => $GLOBALS['strAddNewZone'],
                'newTarget' => $GLOBALS['strZoneToWebsite'], 'class' => 'zone',
                'headerClass' => 'iconZoneLarge', 'newHeaderClass' => 'iconZoneAddLarge'];
    
            case 'channel':
               return ['label' => $GLOBALS['strChannel'], 'newLabel' => $GLOBALS['strAddNewChannel'],
                'newTarget' => $GLOBALS['strChannelToWebsite'], 'class' => 'chan',
                'headerClass' => 'iconTargetingChannelLarge', 'newheaderClass' => 'iconTargetingChannelAddLarge'];
               
            case 'global-channel':
               return ['label' => $GLOBALS['strChannel'], 'newLabel' => $GLOBALS['strAddNewChannel'],
                'class' => 'chan', 'headerClass' => 'iconTargetingChannelLarge',
                'newheaderClass' => 'iconTargetingChannelAddLarge'];
    
            case 'agency':
               return ['label' => $GLOBALS['strAgency'], 'newLabel' => $GLOBALS['strAddAgency'],
               'class' => 'agen', 'headerClass' => 'iconManagerLarge',
                'newheaderClass' => 'iconManagerAddLarge'];
    
            case 'day':
               return ['label' => $GLOBALS['strDay'], 'newLabel' => '', 'class' => 'day'];

            case 'advertisers':
               return ['label' => $GLOBALS['strClients'], 'headerClass' => 'iconAdvertisersLarge'];
               
            case 'campaigns':
               return ['label' => $GLOBALS['strCampaigns'], 'headerClass' => 'iconCampaignsLarge',
                'newTarget' => $GLOBALS['strCampaignsOfAdvertiser']];
               
            case 'banners':
               return ['label' => $GLOBALS['strBanners'], 'headerClass' => 'iconBannersLarge',
                'newTarget' => $GLOBALS['strBannersOfCampaign']];

            case 'websites':
               return ['label' => $GLOBALS['strAffiliates'], 'headerClass' => 'iconWebsitesLarge'];
               
            case 'zones':
               return ['label' => $GLOBALS['strZones'], 'headerClass' => 'iconZonesLarge',
                'newTarget' => $GLOBALS['strZonesOfWebsite']];
               
            case 'channels':
               return ['label' => $GLOBALS['strChannels'], 'headerClass' => 'iconTargetingChannelsLarge',
                'newTarget' => $GLOBALS['strChannelsOfWebsite']];
        }
    
        return null;
    }
    
    
    public function getEntityBreadcrumbPath($entityClass)
    {
        switch ($entityClass) {
            case 'banner':
                return ['advertiser', 'campaign', 'banner'];
                
            case 'campaign':
                return ['advertiser', 'campaign'];
                
            case 'advertiser':
                return ['advertiser'];
    
            case 'tracker':
                return ['advertiser', 'tracker'];
    
            case 'website':
            case 'zone':
                return ['website', 'zone'];
    
            case 'trafficker-zone':
                return ['zone'];
    
            case 'channel':
                return ['website', 'channel'];
    
            case 'global-channel':
                return ['channel'];
    
            case 'agency':
                return ['agency'];

            case 'advertisers':
                return [];
                
            case 'campaigns':
                return ['advertiser'];
                
            case 'banners':
                return ['advertiser', 'campaign'];
                
            case 'websites':
                return [];
                
            case 'zones':
            case 'channels':
                return ['website'];
        }
    
        return null;
    }
}
