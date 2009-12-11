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
$Id$
*/

/**
 * Website DAL Library. 
 * Handles PC API calls and operations on DataObjects for various operation on websites 
 *
 * @package    openXMarket
 * @author     Lukasz Wikierski <lukasz.wikierski@openx.org>
 */
class OX_oxMarket_Dal_Website
{
    protected $aDefaultRestrictions;
        
    /**
     * @var Plugins_admin_oxMarket_oxMarket
     */
    protected $oMarketPlugin;
    
    
    public function __construct(Plugins_admin_oxMarket_oxMarket $oMarketPlugin)
    {
        $this->oMarketPlugin = $oMarketPlugin;
    }
    
    /**
     * Set default restriction to given website
     *
     * @param int $affiliateId
     * @return boolean
     */
    public function insertDefaultRestrictions($affiliateId)
    {
        if (!isset($this->aDefaultRestrictions)) {
            $aDefRestr = $this->oMarketPlugin->getPublisherConsoleApiClient()
                         ->getDefaultRestrictions();
            $this->aDefaultRestrictions[SETTING_TYPE_CREATIVE_ATTRIB] = $aDefRestr['attribute'];
            $this->aDefaultRestrictions[SETTING_TYPE_CREATIVE_CATEGORY] = $aDefRestr['category'];
            $this->aDefaultRestrictions[SETTING_TYPE_CREATIVE_TYPE] = $aDefRestr['type'];
        }
        return $this->updateWebsiteRestrictions($affiliateId,
                $this->aDefaultRestrictions[SETTING_TYPE_CREATIVE_TYPE],
                $this->aDefaultRestrictions[SETTING_TYPE_CREATIVE_ATTRIB],
                $this->aDefaultRestrictions[SETTING_TYPE_CREATIVE_CATEGORY])
            && $this->storeWebsiteRestrictions($affiliateId,
                $this->aDefaultRestrictions[SETTING_TYPE_CREATIVE_TYPE],
                $this->aDefaultRestrictions[SETTING_TYPE_CREATIVE_ATTRIB],
                $this->aDefaultRestrictions[SETTING_TYPE_CREATIVE_CATEGORY]);
    }
    
    
    protected function getWebsiteData($affiliateId, $autoGenerate = true, &$websiteId,
        &$websiteUrl, &$websiteName)
    {
        $oWebsitePref = & OA_Dal::factoryDO('ext_market_website_pref');
        $oWebsitePref->get($affiliateId);

        $oWebsite = & OA_Dal::factoryDO('affiliates');
        $oWebsite->get($affiliateId);

        if (empty($oWebsitePref->website_id) && $autoGenerate) {
            try {
                $websiteId = $this->generateWebsiteId($oWebsite->website, $oWebsite->name);
                if (!empty($websiteId)) {
                    $this->setWebsiteId($affiliateId, $websiteId);
                }
            } catch (Exception $e) {
                OA::debug('openXMarket: Error during register website in OpenX Market : '.$e->getMessage());
            }
        } else {
            $websiteId = $oWebsitePref->website_id;
        }
        $websiteUrl  = $oWebsite->website;
        $websiteName = $oWebsite->name;
    }
    
    
    public function getWebsiteId($affiliateId, $autoGenerate = true)
    {
        $oWebsitePref = & OA_Dal::factoryDO('ext_market_website_pref');
        $oWebsitePref->get($affiliateId);

        if (empty($oWebsitePref->website_id) && $autoGenerate) {
            $oWebsite = & OA_Dal::factoryDO('affiliates');
            $oWebsite->get($affiliateId);

            try {
                $websiteId = $this->generateWebsiteId($oWebsite->website);
            } catch (Exception $e) {
                OA::debug('openXMarket: Error during register website in OpenX Market : '.$e->getMessage());
            }
            if (!empty($websiteId)) {
                $this->setWebsiteId($affiliateId, $websiteId);
            } else {
                return false;
            }
        } else {
            $websiteId = $oWebsitePref->website_id;
        }

        return $websiteId;
    }
    
    
    /**
     * generate website_id (singup website to market)
     *
     * @param string $websiteUrl
     * @param string $websiteName
     * @return string website_id
     * @throws Plugins_admin_oxMarket_PublisherConsoleClientException
     * @throws Zend_Http_Client_FaultException
     */
    public function generateWebsiteId($websiteUrl, $websiteName)
    {
        return $this->oMarketPlugin->getPublisherConsoleApiClient()
               ->newWebsite($websiteUrl, $websiteName);
    }
    
    
    public function setWebsiteId($affiliateId, $websiteId)
    {
        $oWebsitePref = & OA_Dal::factoryDO('ext_market_website_pref');
        $oWebsitePref->get($affiliateId);
        $oWebsitePref->website_id = $websiteId;
        $oWebsitePref->save();
    }
    
    
    public function storeWebsiteRestrictions($affiliateId, $aType, $aAttribute, $aCategory)
    {
        //  first remove all existing settings for $affiliateId
        $this->removeWebsiteRestrictions($affiliateId);
        $aData = array(
            SETTING_TYPE_CREATIVE_ATTRIB => $aAttribute,
            SETTING_TYPE_CREATIVE_CATEGORY => $aCategory,
            SETTING_TYPE_CREATIVE_TYPE => $aType
        );

        foreach($aData as $settingTypeId => $aValue) {
            if (empty($aValue)) {
                continue;
            }
            foreach ($aValue as $id) {
                $oMarketSetting = &OA_Dal::factoryDO('ext_market_setting');
                $oMarketSetting->market_setting_id = $id;
                $oMarketSetting->market_setting_type_id = $settingTypeId;
                $oMarketSetting->owner_type_id = OWNER_TYPE_AFFILIATE;
                $oMarketSetting->owner_id = $affiliateId;
                $oMarketSetting->insert();
            }
        }
        return true;
    }
    
    
    protected function removeWebsiteRestrictions($affiliateId)
    {
        $oMarketSetting = &OA_Dal::factoryDO('ext_market_setting');
        $oMarketSetting->owner_type_id = OWNER_TYPE_AFFILIATE;
        $oMarketSetting->owner_id = $affiliateId;
        $oMarketSetting->delete();
    }
    
    
    /**
     * update website restrictions in OpenX Market
     *
     * @param int $affiliateId
     * @param array $aType
     * @param array $aAttribute
     * @param array $aCategory
     * @return boolean
     */
    public function updateWebsiteRestrictions($affiliateId, $aType, $aAttribute, $aCategory)
    {
        $aType       = (is_array($aType)) ? array_values($aType) : array();
        $aAttribute  = (is_array($aAttribute)) ? array_values($aAttribute) : array();
        $aCategory   = (is_array($aCategory)) ? array_values($aCategory) : array();
        $websiteId   = null;
        $websiteUrl  = null;
        $websiteName = null;
        $this->getWebsiteData($affiliateId, true, $websiteId, $websiteUrl, $websiteName);
        try {
            $result = $this->oMarketPlugin->getPublisherConsoleApiClient()
                      ->updateWebsite($websiteId,
                $websiteUrl, array_values($aAttribute), array_values($aCategory),
                array_values($aType), $websiteName);
        } catch (Exception $e) {
            OA::debug('openXMarket: Error during updating website restriction in OpenX Market : '.$e->getMessage());
            return false;
        }
        return (bool) $result;
    }
    
    
    public function getWebsiteRestrictions($affiliateId)
    {
        $oMarketSetting = &OA_Dal::factoryDO('ext_market_setting');
        $oMarketSetting->owner_type_id = OWNER_TYPE_AFFILIATE;
        $oMarketSetting->owner_id = $affiliateId;
        $aMarketSetting = $oMarketSetting->getAll();
        $aData = array(
                    SETTING_TYPE_CREATIVE_TYPE=>array(),
                    SETTING_TYPE_CREATIVE_ATTRIB=>array(),
                    SETTING_TYPE_CREATIVE_CATEGORY=>array()
                 );

        foreach ($aMarketSetting as $aValue) {
            $aData[$aValue['market_setting_type_id']][$aValue['market_setting_id']] = $aValue['market_setting_id'];
        }

        return $aData;
    }
    
    
    /**
     * Update or register all websites
     * Silent skip problems (will try again in maintenance)
     *
     * @param boolean $skip_synchronized In maintenace skip updating websites marked as url synchronized with marketplace
     *                                  other cases (e.g. reinstalling plugin and re-linking to market) should updates all websites
     * @param int $limitUpdatedWebsites Limit updated websites to this number, 0 - no limit
     */
    public function updateAllWebsites($skip_synchronized = false, $limitUpdatedWebsites = 0)
    {
        // get accountId can be null, if logged user isn't manager in multiple accounts mode
        $accountId = $this->oMarketPlugin->getPublisherConsoleApiClient()
                     ->getAccountId();
        if (!isset($accountId)) {
            return;
        }
        
        $updatedWebsites = 0;
        // get all websites if account id is admin account
        // get manager websites if account is menager account
        $oWebsite = & OA_Dal::factoryDO('affiliates');
        if ($accountId !== DataObjects_Accounts::getAdminAccountId())
        {
            $oManager = OA_Dal::factoryDO('agency');
            $oManager->account_id = $accountId;            
            $oWebsite->joinAdd($oManager);
        }
        $oWebsite->find();
        while($oWebsite->fetch() &&
              ($limitUpdatedWebsites==0 || $updatedWebsites<$limitUpdatedWebsites))
        {
            try {
                $affiliateId = $oWebsite->affiliateid;
                $websiteId = $this->getWebsiteId($affiliateId, false);
                $websiteUrl = $oWebsite->website;
                $websiteName = $oWebsite->name;
                if (empty($websiteId)) {
                    if ($websiteId = $this->generateWebsiteId($websiteUrl, $websiteName)) {
                        $this->setWebsiteId($affiliateId, $websiteId);
                        $this->insertDefaultRestrictions($affiliateId);
                        $updatedWebsites++;
                    }
                } else {
                    $result = $this->updateWebsiteUrlAndName($affiliateId, $websiteUrl, 
                                    $websiteName, $skip_synchronized, $updatedWebsites);
                    if ($result!==true) {
                        throw new Exception($result);
                    }
                }
            } catch (Exception $e) {
                OA::debug('openXMarket: Error during updating website #'.$affiliateId.' : '.$e->getMessage());
            }
        }
    }
    
    
    /**
     * Updates website url and website name on PubConsole
     *
     * @param int $affiliateId Affiliate Id
     * @param string $url New website url
     * @param string $name New website name
     * @param boolean $skip_synchronized Skip updating if url is synchronized
     * @param int $updatedWebsites increase counter if website was updated
     * @return boolean|string true or error message
     */
    public function updateWebsiteUrlAndName($affiliateId, $url, $name, $skip_synchronized = false, &$updatedWebsites = null) {
        $doWebsitePref = & OA_Dal::factoryDO('ext_market_website_pref');
        $doWebsitePref->get($affiliateId);

        if (empty($doWebsitePref->website_id)) {
            $error = 'website not registered';
        } else {
            if (!$skip_synchronized || $doWebsitePref->is_url_synchronized !== 't') {
                try {
                        $aRestrictions = $this->getWebsiteRestrictions($affiliateId);
                        $this->oMarketPlugin->getPublisherConsoleApiClient()->updateWebsite(
                            $doWebsitePref->website_id, $url,
                            array_values($aRestrictions[SETTING_TYPE_CREATIVE_ATTRIB]),
                            array_values(
                                $aRestrictions[SETTING_TYPE_CREATIVE_CATEGORY]),
                            array_values($aRestrictions[SETTING_TYPE_CREATIVE_TYPE]),
                            $name);
                } catch (Exception $e) {
                    $error = $e->getCode().':'.$e->getMessage();
                }
                $doWebsitePref->is_url_synchronized = (!isset($error)) ? 't' : 'f';
                $doWebsitePref->update();
                // Increase counter of updated websites
                if (isset($updatedWebsites)) {
                    $updatedWebsites++;
                }
            }
        }
        return (!isset($error)) ? true : $error;
    }
    
    
    /**
     * This method is called after install or enable
     * to update 10 websites (rest will be updated during maintenance)
     *
     */
    public function initialUpdateWebsites()
    {
        // send 10 not updated websites
        $this->updateAllWebsites(true, 10);
    }

}