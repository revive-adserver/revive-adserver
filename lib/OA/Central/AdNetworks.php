<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
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
$Id: AdNetworks.php 9095 2007-08-17 15:27:03Z matteo.beccati@openads.org $
*/

require_once MAX_PATH . '/lib/OA/Dll.php';
require_once MAX_PATH . '/lib/OA/Central/Common.php';
require_once MAX_PATH . '/lib/OA/Dal/Central/AdNetworks.php';

require_once MAX_PATH . '/lib/max/Admin_DA.php';

require_once MAX_PATH . '/lib/max/Admin/Invocation.php';

/**
 * OAP binding to the ad networks OAC API
 *
 */
class OA_Central_AdNetworks extends OA_Central_Common
{
    /**
     * Class constructor
     *
     * @return OA_Central_AdNetworks
     */
    function OA_Central_AdNetworks()
    {
        parent::OA_Central_Common();
        $this->oDal = new OA_Dal_Central_AdNetworks();
    }

    /**
     * A method to connect username with platform id or change user password.
     *
     * @see Refs R-AN-1: Connecting OpenX Platform with SSO
     *
     * @param String $username  Username
     * @param String $passwordHash Md5 of password
     */
    function connectOAPToOAC($username, $passwordHash)
    {
        return $this->oMapper->connectOAPToOAC($username, $passwordHash);
    }

    /**
     * A method to retrieve the localised list of categories and subcategories
     *
     * @see OA_Dal_Central_AdNetworks::getCategories

     * @see R-AN-3: Gathering the data of Websites during Installation
     * @see R-AN-16: Gathering the Websites after the Installation
     *
     * @return mixed The categories and subcategories array or false on error
     */
    function getCategories()
    {
        $aPref = $GLOBALS['_MAX']['PREF'];
        $result = $this->oCache->call(array(&$this->oMapper, 'getCategories'), $aPref['language']);

        if (!$result) {
            $result = $this->retrievePermanentCache('AdNetworks::getCategories');
        }

        return $result;
    }

    /**
     * A method to retrieve the list of categories as for HTML select options 
     *
     * Output can be limited to given categories IDs and it's parents
     * 
     * @param mixed $aCategoriesIds Array of categories ID, if this is null all categories will be returned
     * @param string $firstOption Name of first select's option. If false - there will be no first option in returned select. Otherwise first option is set to '- pick a category -' 
     * @return array
     */
    function getCategoriesSelect($aCategoriesIds = null, $firstOption = null)
    {
        $aCategories = $this->getCategoriesByIds($aCategoriesIds);
        
        if (is_string($firstOption)) {
            $aSelectCategories = array('' => $firstOption);
        } else if ($firstOption===false) {
            $aSelectCategories = array();
        } else {
            $aSelectCategories = array('' => '- pick a category -');            
        }
        if ($aCategories) {
            ksort($aCategories);
            foreach ($aCategories as $k => $v) {
                $aSelectCategories[$k] = $v['name'];
                $subcategories = $v['subcategories'];
                asort($subcategories);
                foreach ($subcategories as $kk => $vv) {
                    $aSelectCategories[$kk] = "&nbsp;&nbsp;&nbsp;".$vv;
                }
            }
        }

        return $aSelectCategories;
    }

    /**
     * A method to retrieve a list of categories in a flattened array
     *
     * @return array
     */
    function getCategoriesFlat()
    {
        $aCategories = $this->getCategories();

        $aFlatCategories = array();
        if ($aCategories) {
            foreach ($aCategories as $k => $v) {
                $aFlatCategories[$k] = $v['name'];
                foreach ($v['subcategories'] as $kk => $vv) {
                    $aFlatCategories[$kk] = $vv;
                }
            }
        }

        return $aFlatCategories;
    }
    
    /**
     * A method to retrieve a list of categories with parent category key in a flattened array  
     *
     * @return mixed The categories and subcategories flat array or false on error
     */
    function getCategoriesFlatWithParentInfo()
    {
        $aCategories = $this->getCategories();

        $aFlatCategories = false;
        if ($aCategories) {
            $aFlatCategories = array();
            foreach ($aCategories as $k => $v) {
                $aFlatCategories[$k]['name'] = $v['name'];
                $aFlatCategories[$k]['parent'] = null;
                foreach ($v['subcategories'] as $kk => $vv) {
                    $aFlatCategories[$kk]['name'] = $vv;
                    $aFlatCategories[$kk]['parent'] = $k;
                }
            }
        }

        return $aFlatCategories;
    }
    
    /**
     * Method returns selected categories and parent categories for given categories IDs 
     *
     * @param mixed $aCategoriesIds array of categories ID, if this is null all categories will be returned
     * @return array The categories and subcategories array or false on error
     */
    function getCategoriesByIds($aCategoriesIds = null) 
    {
        // Detect fast exits
        if (is_null($aCategoriesIds)) {
            return $this->getCategories();
        } else {
            if (!is_array($aCategoriesIds)) {
                return false;
            }
            if (count($aCategoriesIds) == 0) {
                return array();
            }
        }
        
        $aCategories = $this->getCategoriesFlatWithParentInfo();
        if ($aCategories == false) {
            return false;
        }
        
        $aReturnCategories = array();
        foreach ($aCategoriesIds as $categoryId) {
            //detect if given category is on list
            if (is_null($aCategories[$categoryId])) {
                continue;
            }
            // detect if this is category or subcategory
            if (is_null($aCategories[$categoryId]['parent'])) {
                $aReturnCategories[$categoryId]['name'] = $aCategories[$categoryId]['name'];  
            } else {
                // If subcategory, get this subcategory and parent category
                $parentId = $aCategories[$categoryId]['parent'];
                $aReturnCategories[$parentId]['name']                       = $aCategories[$parentId]['name'];
                $aReturnCategories[$parentId]['subcategories'][$categoryId] = $aCategories[$categoryId]['name'];
                
            }
        }
        return $aReturnCategories;
    }
    
    /**
     * Returns IDs of subcategories for given category ID 
     *
     * @param int $categoryId CategoryID
     * @return array Array of ID of subcategories, if given ID was subcategory function returns empty array, false on errors 
     */
    function getSubCategoriesIds($categoryId) 
    {
        if (!is_numeric($categoryId)) {
            return false;
        }

        $aResult = array();
        
        $aCategories = $this->getCategories();
        if ($aCategories == false) {
            return false;
        }
        if (array_key_exists($categoryId, $aCategories)) {
            foreach ($aCategories[$categoryId]['subcategories'] as $subCategoryId => $aSubCategory ) {
                $aResult[] = $subCategoryId; 
            }
        }
        
        return $aResult;
    }

    /**
     * A method to retrieve the localised list of countries
     *
     * @see R-AN-3: Gathering the data of Websites during Installation
     * @see R-AN-16: Gathering the Websites after the Installation
     * @see C-AN-1: Displaying Ad Networks on Advertisers & Campaigns Screen
     *
     * @return mixed The array of countries, with country identifiers as keys, or
     *               false on error
     */
    function getCountries()
    {
        $aPref = $GLOBALS['_MAX']['PREF'];
        $result = $this->oCache->call(array(&$this->oMapper, 'getCountries'), $aPref['language']);

        if (!$result) {
            $result = $this->retrievePermanentCache('AdNetworks::getCountries');
        }

        return $result;
    }

    /**
     * A method to retrieve the list of countries as for HTML select options
     *
     * @return array
     */
    function getCountriesSelect()
    {
        if ($aCountries = $this->getCountries()) {
            asort($aCountries);
        }

        $aSelectCountries = array('' => '- pick a country -');
        if ($aCountries && is_array($aCountries)) {
            $aSelectCountries += $aCountries;
        }

        return $aSelectCountries;
    }

    /**
     * A method to retrieve the localised list of languages
     *
     * @see R-AN-3: Gathering the data of Websites during Installation
     * @see R-AN-16: Gathering the Websites after the Installation
     * @see C-AN-1: Displaying Ad Networks on Advertisers & Campaigns Screen
     *
     * @return mixed The array of languages, with language identifiers as keys, or
     *               false on error
     */
    function getLanguages()
    {
        $aPref = $GLOBALS['_MAX']['PREF'];
        $result = $this->oCache->call(array(&$this->oMapper, 'getLanguages'), $aPref['language']);

        if (!$result) {
            $result = $this->retrievePermanentCache('AdNetworks::getLanguages');
        }

        return $result;
    }

    /**
     * A method to retrieve the list of languages as for HTML select options
     *
     * @return array
     */
    function getLanguagesSelect()
    {
        if ($aLanguages = $this->getLanguages()) {
            asort($aLanguages);
        }

        $aSelectLanguages = array('' => '- pick a language -');
        if ($aLanguages && is_array($aSelectLanguages)) {
            $aSelectLanguages += $aLanguages;
        }

        return $aSelectLanguages;
    }

    /**
     * A method to subscribe one or more websites to the Ad Networks program
     *
     * @see R-AN-3: Gathering the data of Websites during Installation
     * @see R-AN-4: Creation of the Ad Networks Entities
     * @see R-AN-5: Generation of Campaigns and Banners
     *
     * @todo Implement rollback
     *
     * @param array $aWebsites
     * @return mixed True on success, PEAR_Error otherwise
     */
    function subscribeWebsites(&$aWebsites)
    {
        $aPref = $GLOBALS['_MAX']['PREF'];
        $oDbh = OA_DB::singleton();
        $aSubscriptions = $this->oMapper->subscribeWebsites($aWebsites);

        if (PEAR::isError($aSubscriptions)) {
            return $aSubscriptions;
        }

        if (!$this->oDal->beginTransaction()) {
            return new PEAR_Error('Cannot start transaction');
        }

        // Simulate transactions
        $aCreated = array(
            'publishers'  => array(),
            'advertisers' => array(),
            'campaigns'   => array(),
            'banners'     => array(),
            'zones'       => array()
        );

        $aAdNetworks = array();

        $ok = true;
        foreach ($aSubscriptions['adnetworks'] as $aAdvertiser) {
            $doAdvertisers = OA_Dal::factoryDO('clients');
            $doAdvertisers->an_adnetwork_id = $aAdvertiser['adnetwork_id'];
            $doAdvertisers->find();

            if ($doAdvertisers->fetch()) {
                // Advertiser for this adnetwork already exists
                $aAdNetworks[$aAdvertiser['adnetwork_id']] = $doAdvertisers->toArray();
            } else {
                // Create advertiser
                $advertiserName = $this->oDal->getUniqueAdvertiserName($aAdvertiser['name']);
                $advertiser = array(
                    'clientname'       => $advertiserName,
                    'contact'          => $aPref['admin_name'],
                    'email'            => $aPref['admin_email'],
                    'an_adnetwork_id'  => $aAdvertiser['adnetwork_id']
                );

                $doAdvertisers = OA_Dal::factoryDO('clients');
                $doAdvertisers->setFrom($advertiser);
                $advertiserId = $doAdvertisers->insert();

                if (!empty($advertiserId)) {
                    $aCreated['advertisers'][] = $advertiserId;
                    $aAdNetworks[$aAdvertiser['adnetwork_id']] = $advertiser + array(
                        'clientid' => $advertiserId
                    );
                } else {
                    $ok = false;
                }
            }
        }

        $isAlexaDataFailed = false;
        for (reset($aSubscriptions['websites']); $ok && ($aWebsite = current($aSubscriptions['websites'])); next($aSubscriptions['websites'])) {
            
            $isAlexaDataFailed = ($aWebsite['isAlexaDataFailed']) ? 
                                 $aWebsite['isAlexaDataFailed'] : $isAlexaDataFailed;
                                 
            // Create new or use existing publisher
            $websiteIdx = key($aWebsites);
            foreach ($aWebsites as $key => $value) {
                if ($value['url'] == $aWebsite['url']) {
                    $websiteIdx = $key;
                }
            }

            $existingPublisher = !empty($aWebsites[$websiteIdx]['id']);

            $doPublishers = OA_Dal::factoryDO('affiliates');

            if ($existingPublisher) {
                $doPublishers->get($aWebsites[$websiteIdx]['id']);
                $publisher = array();
                $publisherName = $doPublishers->name;
            } else {
                $publisherName = $this->oDal->getUniquePublisherName($aWebsite['url']);
                $publisher = array(
                    'name'             => $publisherName,
                    'website'          => 'http://'.$aWebsite['url'],
                    'mnemonic'         => '',
                    'contact'          => $aPref['admin_name'],
                    'email'            => $aPref['admin_email'],
                    'oac_country_code' => $aWebsites[$websiteIdx]['country'],
                    'oac_language_id'  => $aWebsites[$websiteIdx]['language'],
                    'oac_category_id'  => $aWebsites[$websiteIdx]['category'],
//                    'as_website_id'    => $aWebsites[$websiteIdx]['advsignup']
                );
            }

            
            // an_website_id equal as_website_id
//            if ($aWebsites[$websiteIdx]['adnetworks']) {
//                $publisher += array(
//                    'an_website_id'   => $aWebsite['website_id'],
//                );
//            }
            
            if ($aWebsites[$websiteIdx]['advsignup']) {
	            $publisher += array(
	                'as_website_id'   => $aWebsite['website_id'],
	            );
            }
            
            $doPublishers->setFrom($publisher);

            if ($existingPublisher) {
                $publisherId = $doPublishers->update() ? $aWebsites[$websiteIdx]['id'] : '';
            } else {
                $publisherId = $doPublishers->insert();
                $aWebsites[$websiteIdx]['id'] = $publisherId;
            }

            if (!empty($publisherId)) {
                if (!$existingPublisher) {
                    $aCreated['publishers'][] = $publisherId;
                }
                // Lookup the existing zone sizes for this publisher
                $aZones = array();
                $doZones = OA_Dal::factoryDO('zones');
                $doZones->affiliateid = $publisherId;
                $doZones->find();
                while ($doZones->fetch()) {
                    $zoneSize = $doZones->width . 'x' . $doZones->height;
                    $aZones[$zoneSize][] = $doZones->zoneid;
                }
            } else {
                $ok = false;
            }

            for (reset($aWebsite['campaigns']); $ok && ($aCampaign = current($aWebsite['campaigns'])); next($aWebsite['campaigns'])) {
                // Create campaign
                if (!isset($aAdNetworks[$aCampaign['adnetwork_id']])) {
                    $ok = false;
                    break;
                }

                $advertiserId   = $aAdNetworks[$aCampaign['adnetwork_id']]['clientid'];
                $advertiserName = $aAdNetworks[$aCampaign['adnetwork_id']]['clientname'];

                $campaignName = $this->oDal->getUniqueCampaignName("{$advertiserName} - {$aCampaign['name']} - {$publisherName}");
                $campaignStatus = !empty($aCampaign['status']) ? OA_ENTITY_STATUS_PENDING : OA_ENTITY_STATUS_RUNNING;
                $campaign = array(
                    'campaignname'    => $campaignName,
                    'clientid'        => $advertiserId,
                    'weight'          => $aCampaign['weight'],
                    'block'           => $aCampaign['block'],
                    'capping'         => $aCampaign['capping'],
                    'session_capping' => $aCampaign['session_capping'],
                    'an_campaign_id'  => $aCampaign['campaign_id'],
                    'status'          => $campaignStatus,
                    'an_status'       => empty($aCampaign['status']) ? OA_ENTITY_ADNETWORKS_STATUS_RUNNING : $aCampaign['status']
                );

                $doCampaigns = OA_Dal::factoryDO('campaigns');
                $doCampaigns->setFrom($campaign);
                $campaignId = $doCampaigns->insert();

                if (!empty($campaignId)) {
                    $aCreated['campaigns'][] = $campaignId;
                } else {
                    $ok = false;
                }

                for (reset($aCampaign['banners']); $ok && ($aBanner = current($aCampaign['banners'])); next($aCampaign['banners'])) {
                    // Create banner
                    $bannerName = $this->oDal->getUniqueBannerName("{$advertiserName} - {$aBanner['name']}");
                    $banner = array(
                        'description'     => $bannerName,
                        'campaignid'      => $campaignId,
                        'width'           => $aBanner['width'],
                        'height'          => $aBanner['height'],
                        'block'           => $aBanner['block'],
                        'capping'         => $aBanner['capping'],
                        'session_capping' => $aBanner['session_capping'],
                        'storagetype'     => 'html',
                        'contenttype'     => 'html',
                        'htmltemplate'    => $aBanner['html'],
                        'adserver'        => $aBanner['adserver'],
                        'an_banner_id'    => $aBanner['banner_id']
                    );
                    if (!empty($banner['adserver'])) {
                        $banner['autohtml'] = 't';
                    }

                    $doBanners = OA_Dal::factoryDO('banners');
                    $doBanners->setFrom($banner);
                    $bannerId = $doBanners->insert();

                    if (!empty($bannerId)) {
                        $aCreated['banners'][] = $bannerId;

                        $zoneSize = "{$aBanner['width']}x{$aBanner['height']}";
                        if (!empty($aZones[$zoneSize])) {
                            $zoneIds = $aZones[$zoneSize];
                        } else {
                            // Create zone
                            $zoneName = $this->oDal->getUniqueZoneName("{$publisherName} - {$zoneSize}");
                            $zone = array(
                                'zonename'    => $zoneName,
                                'affiliateid' => $publisherId,
                                'width'       => $aBanner['width'],
                                'height'      => $aBanner['height'],
                            );

                            $doZones = OA_Dal::factoryDO('zones');
                            $doZones->setFrom($zone);
                            $zoneId = $doZones->insert();

                            $aZones[$zoneSize][] = $zoneId;
                        }

                        foreach ($aZones[$zoneSize] as $idx => $zoneId) {
                            // Link banner to zone
                            $aVariables = array(
                                'ad_id'   => $bannerId,
                                'zone_id' => $zoneId
                            );

                            $result = Admin_DA::addAdZone($aVariables);

                            if (PEAR::isError($result)) {
                                $ok = false;
                            }
                        }
                    } else {
                        $ok = false;
                    }
                }
            }
            // Add zones to central.
            $this->updateZones($publisherId);
        }

        if (!$ok) {
            if (!$this->oDal->rollback()) {
                $this->oDal->undoEntities($aCreated);
            }

            return new PEAR_Error('There was an error storing the data on the database');
        }

        $return = array('commit' => $this->oDal->commit(), 'isAlexaDataFailed' => $isAlexaDataFailed);
        return $return;
    }

    /**
     * A method to "unsubscribe" one or more websites from the Ad Networks program
     * The method currently just unlinks any ad network banners from this publisher's zones
     *
     * @param array $aWebsites
     * @return mixed true on success, PEAR_Error otherwise
     */
    function unsubscribeWebsites($aWebsites)
    {
        $aPref = $GLOBALS['_MAX']['PREF'];
        $oDbh = OA_DB::singleton();
        if (!$this->oDal->beginTransaction()) {
            return new PEAR_Error('Cannot start transaction');
        }

       $error = false;
        foreach ($aWebsites as $idx => $aWebsite) {
            $publisherId = $aWebsite['id'];
            if (empty($publisherId)) {
                // No publisher ID found, skip
                continue;
            }
            if (!empty($aWebsite['an_website_id'])) {
                $aWebsiteIds[] = (int)$aWebsite['an_website_id'];
            }
            // Unlink any Ad Network banners linked to this publisher's zones
            $doZones = OA_Dal::factoryDO('zones');
            $doAdZoneAssoc = OA_Dal::factoryDO('ad_zone_assoc');
            $doBanner = OA_Dal::factoryDO('banners');

            $doZones->affiliateid = $publisherId;
            $doBanner->whereAdd('an_banner_id IS NOT NULL');
            $doAdZoneAssoc->joinAdd($doBanner);
            $doAdZoneAssoc->joinAdd($doZones);
            $doAdZoneAssoc->find();
            while ($doAdZoneAssoc->fetch()) {
                $doAdZoneAssoc2 = OA_Dal::factoryDO('ad_zone_assoc');
                $doAdZoneAssoc2->ad_zone_assoc_id = $doAdZoneAssoc->ad_zone_assoc_id;
                if (!$doAdZoneAssoc2->delete()) {
                    $error = true;
                    break;
                }
            }
            
            // Unsubscribe zones from central.
            $this->deleteZones($publisherId);
        }
        if ($error) {
            $this->oDal->rollback();
            return new PEAR_Error('Unable to unlink all ad network banners');
        } else {
            $this->oMapper->unsubscribeWebsites($aWebsiteIds);

            return $this->oDal->commit();
        }
    }

    /**
     * A method to call method updateZone for "subscribe" zone on Ad Networks program
     * All zones where belonging publihser.
     *
     * @param int $publisherId
     */
    function updateZones($publisherId)
    {
        $aPref = $GLOBALS['_MAX']['PREF'];
        $oDbh = OA_DB::singleton();
    	        
        $doPublishers = OA_Dal::factoryDO('affiliates');
        $doPublishers->get($publisherId);
        
        $doZones = OA_Dal::factoryDO('zones');
        $doZones->affiliateid = $doPublishers->affiliateid;
        $doZones->find();
        $anWebsiteId = $doPublishers->as_website_id;
        while ($doZones->fetch()) {
        	$this->updateZone($doZones, $anWebsiteId);
        }
        
    }
    
    /**
     * A method to "subscribe" zone on Ad Networks program
     *
     * @param DB_DataObjectCommon $doZone
     * @param int $anWebsiteId  website id into Ad Networks program
     */
    function updateZone(&$doZone, $anWebsiteId)
    {
        $aRpcZone = array(
          	    		  'websiteId'  	=> $anWebsiteId,
            			  'name' 		=> $doZone->zonename,
                		  'description' => $doZone->description,
                		  'width' 		=> $doZone->width,
            	    	  'height' 		=> $doZone->height,
                         );
                         
        if ($doZone->as_zone_id) {
            $aRpcZone += array('id' => $doZone->as_zone_id);
        }
        
        $result = $this->oMapper->updateZone($aRpcZone);
        
        if (is_object($result)) {
            $as_zone_id = 0;
        } else {
            $as_zone_id = (int)$result;
        }
        
        $doZonesUpdate             = OA_Dal::factoryDO('zones');
        $doZonesUpdate->as_zone_id = $as_zone_id;
        $doZonesUpdate->zoneid     = $doZone->zoneid;
        $doZonesUpdate->update();
	}
    
    /**
     * A method to call method deleteZone for "subscribe" zone on Ad Networks program
     * All zones where belonging publihser.
     *
     * @param int $affiliateid
     */
    function deleteZones($affiliateid)
    {
        $doZones = OA_Dal::factoryDO('zones');
        $doZones->affiliateid = $affiliateid;
        $doZones->find();
        while ($doZones->fetch()) {
        	$this->deleteZone($doZones->as_zone_id);
        }
    }
    
    /**
     * A method to delete zone from Ad Networks program
     *
     * @param int $zoneId  into Ad Networks
     */
    function deleteZone($zoneId)
    {
        $doZones = OA_Dal::factoryDO('zones');
        $doZones->get('as_zone_id', $zoneId);
        
        $r = $doZones->setFrom(
                                  array('as_zone_id' => 0)
                              );
        $doZones->update();
        
        $result = $this->oMapper->deleteZone((int)$zoneId);
        
    }

    /**
     * A get all Advertiser, Campaign and Banners from oac
     *  and added this to the database.
     *
     */
    function getWebsitesAdvertisers()
    {
        $doAdvertisers = OA_Dal::factoryDO('clients');
        $doAdvertisers->find();
        $requstIds = array();
        while ($doAdvertisers->fetch()) {
            if ($doAdvertisers->as_advertiser_id) {
                $campaigns = array();
                
                $doCampaigns = OA_Dal::factoryDO('campaigns');
                $doCampaigns->clientid = $doAdvertisers->clientid;
                $doCampaigns->find();
                while ($doCampaigns->fetch()) {
                    if ($doCampaigns->as_campaign_id) {
                        $campaigns[] = (int)$doCampaigns->as_campaign_id;
                    }
                }
                $requstIds[$doAdvertisers->as_advertiser_id] = $campaigns;
            }
        }
        
        $requstIds = (count($requstIds)) ? $requstIds : array(null => null);
        
        $aRespAdvetisers = $this->oMapper->getWebsitesAdvertisers($requstIds);
        
        if (is_object($aRespAdvetisers)) {
            return 0;            
        }

        foreach ($aRespAdvetisers['websitesAdvertisers'] as $aAdvertiser) {
            // Update or insert advertiser to db
            $doAdvertiser = OA_Dal::factoryDO('clients');
            $doAdvertiser->as_advertiser_id = $aAdvertiser['id'];
            $doAdvertiser->find();

            $advertiserName    = $this->oDal->getUniqueAdvertiserName($aAdvertiser['first_name'] . "-" .
                                                                      $aAdvertiser['last_name']
                                                                     );

            if ($doAdvertiser->fetch()) {
                $advertiserId = $doAdvertiser->clientid;
                
                // Update Advertiser
//                $doAdvertiser->clientname = $advertiserName;
//                $doAdvertiser->contact    = $advertiserContact;
//                $doAdvertiser->update();
                
            } else {
                // Make Advertiser data from response
                $advertiserContact = $aAdvertiser['country_name'] . " " .
                                     $aAdvertiser['country_code'] . ", " . 
                                     $aAdvertiser['city'] . ", " . 
                                     $aAdvertiser['address'] . ", " .
                                     $aAdvertiser['post_code'] ;
                                     
                // Create Advertiser
                $advertiser = array(
                    'clientname'       => $advertiserName,
                    'as_advertiser_id' => $aAdvertiser['id'],
                    'contact'          => $advertiserContact
                );

                $doAdvertiser = OA_Dal::factoryDO('clients');
                $doAdvertiser->setFrom($advertiser);
                $advertiserId = $doAdvertiser->insert();
            }
            // Campaigns
            foreach ($aAdvertiser['campaigns'] as $aCampaign) {
                $campaignClientId = $advertiserId;
                
                $doCampaign = OA_Dal::factoryDO('campaigns');
                $doCampaign->as_campaign_id = $aCampaign['id'];
                $doCampaign->find();

                if ($doCampaign->fetch()) {
                    // Update Campaign
//                    $doCampaign->campaignname = $campaignName;
//                    $doCampaign->activate     = $campaignActivate;
//                    $doCampaign->expire       = $campaignExpire;
//                    $doCampaign->status       = $campaignStatus;
//                    $doCampaign->an_status    = $campaignAnStatus;
//                    $doCampaign->revenue      = $campaignRevenue;
//                    $doCampaign->revenue_type = $campaignRevenueType;
//                    $doCampaign->weight       = $campaignWeight;
//                    $doCampaign->clientid     = $campaignClientId;
//                    $doCampaign->update();
                    $campaignId = $doCampaign->campaignid;
                } else {
                    // Make Campaign data from response
                    $campaignName        = $this->oDal->getUniqueCampaignName($aCampaign['id'] . 
                                                                              "-" . $advertiserName);
                    $campaignActivate    = date('Y-m-d',$aCampaign['start_date']/1000);
                    $campaignExpire      = date('Y-m-d',$aCampaign['end_date']/1000);
                    $campaignStatus      = $this->transformationStatus($aCampaign['status']);
                    $campaignAnStatus    = $aCampaign['status'];
                    $campaignRevenue     = $aCampaign['rate'];
                    $campaignRevenueType = $aCampaign['pricing'];
                    $campaignWeight      = $aCampaign['weight'];
                
                    // Create campaign
                    $campaign = array(
                        'clientid'       => $campaignClientId,
                        'campaignname'   => $campaignName,
                        'activate'       => $campaignActivate,
                        'expire'         => $campaignExpire,
                        'status'         => $campaignStatus,
                        'an_status'      => $campaignAnStatus,
                        'revenue'        => $campaignRevenue,
                        'revenue_type'   => $campaignRevenueType,
                        'weight'         => $campaignWeight,
                        'as_campaign_id' => $aCampaign['id']
                    );
                    $doCampaign = OA_Dal::factoryDO('campaigns');
                    $doCampaign -> setFrom($campaign);
                    $campaignId = $doCampaign->insert();
                }
                
                // get OAP zone by zone_id
                $doZone             = OA_Dal::factoryDO('zones');
                $doZone->as_zone_id = $aCampaign['zone_id'];
                $doZone->find();
                $doZone->fetch();
                $zoneId = (int)$doZone->zoneid;
                
                // Banners
                $bannerCampaignId = $campaignId;
                foreach ($aCampaign['banners'] as $aBanner) {
                    // Make Banner data from response
                    $bannerUrl = $aBanner['url'];
                    
                    $doBanner = OA_Dal::factoryDO('banners');
                    $doBanner->as_banner_id = $aBanner['id'];
                    $doBanner->find();
    
                    if ($doBanner->fetch()) {
                        // Update Banner
//                        $doBanner->url        = $bannerUrl;
//                        $doBanner->campaignid = $bannerCampaignId;
                        $bannerId = $doBanner->bannerid;
                    } else {
                        // Create banner
                        $banner = array(
                            'campaignid'   => $bannerCampaignId,
                            'url'          => $bannerUrl,
                            'as_banner_id' => $aBanner['id']
                        );
                        $doBanner = OA_Dal::factoryDO('banners');
                        $doBanner -> setFrom($banner);
                        $bannerId = $doBanner->insert();
                    }
                    
                    // Add banner zone assoc
                    $doAdZone = OA_Dal::factoryDO('ad_zone_assoc');
                    $doAdZone->ad_id = $bannerId;
                    $doAdZone->find();
                    
                    if ($doAdZone->fetch()) {
                        $doAdZone->zone_id = $zoneId;
                        $id = $doAdZone->update();
                    }
                }
            }
        }
    }
    
    /**
     * Set properties campaign to oac
     *   call XMLRPC method
     *
     */
    function setCampaignsProperties()
    {
        $doCampaigns = OA_Dal::factoryDO('campaigns');
        $doCampaigns->find();
        $aCampaigns = array();
        while ($doCampaigns->fetch()) {
            if ($doCampaigns->as_campaign_id) {
                
                // Get Invocation Code
                $invocationCode = '';
                $doBanner = OA_Dal::factoryDO('banners');
                $doBanner->campaignid = $doCampaigns->campaignid;
                $doBanner->find();
                if ($doBanner->fetch()) {
                    $doAdZone = OA_Dal::factoryDO('ad_zone_assoc');
                    $doAdZone->ad_id = $doBanner->bannerid;
                    $doAdZone->find();
                    if ($doAdZone->fetch()) {
                        $doZone         = OA_Dal::factoryDO('zones');
                        $doZone->zoneid = $doAdZone->zone_id;
                        $doZone->find();
                        $invocationCode = '';
                        if ($doZone->fetch()) {
                            $affiliateid = $doZone->affiliateid;
                            $zoneid      = $doZone->zoneid;
                            $codetype = 'adview';
                            $invocationTag = MAX_Plugin::factory('invocationTags', $codetype);
                            $maxInvocation = new MAX_Admin_Invocation();
                            
                            $invocationCode = $maxInvocation->generateInvocationCode($invocationTag);
                        }
                    }
                }
                
                $aCampaigns[(int)$doCampaigns->as_campaign_id] = 
                    array (
                              'id'             => (int)$doCampaigns->campaignid,
                              'invocationCode' => (string)$invocationCode,
                              'deliveredCount' => (int)$doCampaigns->capping,
                              'status'         => 
                                    (string)$this->transformationStatusToOac($doCampaigns->status)
                          );
            }
        }
        
        $aCampaigns = (count($aCampaigns)) ? $aCampaigns : array(null => null);
      
        // Call XMLRPC method
        $result = $this->oMapper->setCampaignsProperties($aCampaigns);
    }
    
    /**
     * Method to transformation oac status to oap status.
     *
     * @param string $oacStatus  status in oac
     * @return int  status in oap
     */
    function transformationStatus($oacStatus)
    {
        switch ($oacStatus) {
            case 'AWAITING_APPROVAL' :
                return OA_ENTITY_STATUS_APPROVAL;
                break;
            case 'APPROVED' :
                return OA_ENTITY_STATUS_APPROVAL;
                break;
            case 'RUNNING' :
                return OA_ENTITY_STATUS_RUNNING;
                break;
            case 'PAUSED' :
                return OA_ENTITY_STATUS_PAUSED;
                break;
            case 'FINISHED' :
                return OA_ENTITY_STATUS_EXPIRED;
                break;
            case 'REJECTED' :
                return OA_ENTITY_STATUS_REJECTED;
                break;
        }
    }
    
    /**
     * Method to transformation oap status to oac status.
     *
     * @param int $oapStatus  status in oap
     * @return string  status in oac
     */
    function transformationStatusToOac($oapStatus)
    {
        switch ($oapStatus) {
            case OA_ENTITY_STATUS_APPROVAL :
                return 'AWAITING_APPROVAL';
                break;
            case OA_ENTITY_STATUS_APPROVAL :
                return 'APPROVED';
                break;
            case OA_ENTITY_STATUS_RUNNING :
                return 'RUNNING';
                break;
            case OA_ENTITY_STATUS_PAUSED :
                return 'PAUSED';
                break;
            case OA_ENTITY_STATUS_EXPIRED :
                return 'FINISHED';
                break;
            case OA_ENTITY_STATUS_REJECTED :
                return 'REJECTED';
                break;
        }
    }
    
    
    /**
     * A method to get updates about subscribed websites
     *
     * @see C-AN-2 Website application status
     *
     * @return mixed True on success, PEAR_Error otherwise
     */
    function getCampaignStatuses()
    {
        $result = $this->oMapper->getCampaignStatuses();

        if (!PEAR::isError($result)) {
            foreach ($result as $campaignId => $status) {
                $doCampaign = OA_Dal::factoryDO('campaigns');
                $doCampaign->whereAdd('an_campaign_id = '.$campaignId);
                $doCampaign->find();

                if ($doCampaign->fetch()) {
                    if ($status != OA_ENTITY_ADNETWORKS_STATUS_RUNNING && $doCampaign->status == OA_ENTITY_STATUS_RUNNING) {
                        $doCampaign->status = OA_ENTITY_STATUS_PENDING;
                    } elseif ($status == OA_ENTITY_ADNETWORKS_STATUS_RUNNING && $doCampaign->status == OA_ENTITY_STATUS_PENDING) {
                        $doCampaign->status = OA_ENTITY_STATUS_RUNNING;
                    }
                    $doCampaign->an_status = $status;
                    $doCampaign->update();
                }
            }

            return true;
        }

        return $result;
    }

    /**
     * A method to get the list of other networks currently available
     *
     * @see C-AN-1: Displaying Ad Networks on Advertisers & Campaigns Screen
     * @see R-AN-17: Refreshing the Other Ad Networks List
     *
     * @return mixed The other networs array on success, PEAR_Error otherwise
     */
    function getOtherNetworks()
    {
        $result = $this->oCache->call(array(&$this->oMapper, 'getOtherNetworks'));

        return $result;
    }

    /**
     * A method to get the list of matching other networks
     *
     * @param string $country
     * @param string $language
     * @return array The other networks array. The array will be empty on failure
     */
    function getOtherNetworksForDisplay($country = '', $language = '')
    {
        $aOtherNetworks = $this->getOtherNetworks();

        if ($aOtherNetworks) {
            // If a country was selected, filter on country
            if (!empty($country) && ($country != 'undefined')) {
                foreach ($aOtherNetworks as $networkName => $networkDetails) {
                    // If this network is not global
                    if (!$networkDetails['is_global']) {
                        if (!isset($networkDetails['countries'][strtolower($country)])) {
                            // No country specific URL for this non-global network so remove it from the list
                            unset($aOtherNetworks[$networkName]);
                        } else {
                            // There is a specific URL for this country, so set this for use in the templated
                            $aOtherNetworks[$networkName]['url'] = $networkDetails['countries'][strtolower($country)];
                        }
                    }
                }
            }

            // If a language was selected, filter on language
            if (!empty($language) && ($language != 'undefined')) {
                foreach ($aOtherNetworks as $networkName => $networkDetails) {
                    // If this network is not global
                    if (!$networkDetails['is_global']) {
                        if (!isset($networkDetails['languages'][$language])) {
                            // No language entry for the selected non-global network
                            unset($aOtherNetworks[$networkName]);
                        }
                    }
                }
            }
        } else {
            $aOtherNetworks = array();
        }

        return $aOtherNetworks;
    }

    /**
     * A method to suggest a new network
     *
     * @see C-AN-1: Displaying Ad Networks on Advertisers & Campaigns Screen
     *
     * @todo Decide if it's better to implement this using an XML-RPC call and
     *       having OAC to send an email to the operator, or have OAP directly
     *       send the email
     *
     * @param string $name
     * @param string $url
     * @param string $country
     * @param int $language
     * @return mixed A boolean True on success, PEAR_Error otherwise
     */
    function suggestNetwork($name, $url, $country, $language)
    {
        $result = $this->oMapper->suggestNetwork($name, $url, $country, $language);

        if (PEAR::isError($result)) {
            return false;
        }

        return $result;
    }

    /**
     * A method to retrieve the revenue information until last GMT midnight
     *
     * @see R-AN-7: Synchronizing the revenue information
     *
     * @todo Implement rollback
     *
     * @return boolean True on success
     */
    function getRevenue()
    {
        $batchSequence = OA_Dal_ApplicationVariables::get('batch_sequence');
        $batchSequence = is_null($batchSequence) ? 1 : $batchSequence + 1;

        $aRevenues = $this->oMapper->getRevenue($batchSequence);

        if (PEAR::isError($aRevenues)) {
            return false;
        }

        if (!$this->oDal->beginTransaction()) {
            return false;
        }

        $aBannerIds = $this->oDal->getBannerIdsFromOacIds(array_keys($aRevenues));

        foreach ($aRevenues as $bannerId => $aData) {
            foreach ($aData as $aRevenue) {
                if (!isset($aBannerIds[$bannerId])) {
                    continue;
                }

                if (!$this->oDal->revenueClearStats($aBannerIds[$bannerId], $aRevenue)) {
                    return $this->oDal->rollbackAndReturnFalse();
                }

                if (!$this->oDal->revenuePerformUpdate($aBannerIds[$bannerId], $aRevenue)) {
                    return $this->oDal->rollbackAndReturnFalse();
                }
            }
        }

        if (!OA_Dal_ApplicationVariables::set('batch_sequence', $batchSequence)) {
            return $this->oDal->rollbackAndReturnFalse();
        }

        return $this->oDal->commit();
    }

}

?>
