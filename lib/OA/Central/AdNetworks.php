<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.5                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
| For contact details, see: http://www.openads.org/                         |
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

require_once MAX_PATH . '/lib/OA/Central/Common.php';
require_once MAX_PATH . '/lib/OA/Dal/Central/AdNetworks.php';

require_once MAX_PATH . '/lib/max/Admin_DA.php';


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
        $result = $this->oMapper->getCategories($aPref['language']);

        if (PEAR::isError($result)) {
            return false;
        }

        return $result;
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
        $result = $this->oMapper->getCountries($aPref['language']);

        if (PEAR::isError($result)) {
            return false;
        }

        return $result;
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
        $result = $this->oMapper->getLanguages($aPref['language']);

        if (PEAR::isError($result)) {
            return false;
        }

        return $result;
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
     * @return boolean True on success
     */
    function subscribeWebsites($aWebsites)
    {
        $aPref = $GLOBALS['_MAX']['PREF'];
        $oDbh = OA_DB::singleton();

        $aSubscriptions = $this->oMapper->subscribeWebsites($aWebsites);

        if (PEAR::isError($result)) {
            return false;
        }

        if (!$this->oDal->beginTransaction()) {
            return false;
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
            // Create advertiser
            $advertiserName = $this->oDal->getUniqueAdvertiserName($aAdvertiser['name']);
            $advertiser = array(
                'clientname' => $advertiserName,
                'contact'    => $aPref['admin_name'],
                'email'      => $aPref['admin_email']
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

        for (reset($aSubscriptions['websites']); $ok && ($aWebsite = current($aSubscriptions['websites'])); next($aSubscriptions['websites'])) {
            // Create publisher
            $publisherName = $this->oDal->getUniquePublisherName($aWebsite['url']);
            $publisher = array(
                'name'           => $publisherName,
                'mnemonic'       => '',
                'contact'        => $aPref['admin_name'],
                'email'          => $aPref['admin_email'],
                'website'        => $aWebsite['url'],
                'oac_website_id' => $aWebsite['website_id']
            );

            $doPublishers = OA_Dal::factoryDO('affiliates');
            $doPublishers->setFrom($publisher);
            $publisherId = $doPublishers->insert();

            if (!empty($publisherId)) {
                $aCreated['publishers'][] = $publisherId;
                $aZones = array();
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

                $campaignName = $this->oDal->getUniqueCampaignName("{$advertiserName} - {$aCampaign['name']}");
                $campaign = array(
                    'campaignname'    => $campaignName,
                    'clientid'        => $advertiserId,
                    'weight'          => $aCampaign['weight'],
                    'capping'         => $aCampaign['capping'],
                    'oac_campaign_id' => $aCampaign['campaign_id']
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
                    $bannerName = $this->oDal->getUniqueBannerName("{$campaignName} - {$aBanner['name']}");
                    $banner = array(
                        'description'   => $bannerName,
                        'campaignid'    => $campaignId,
                        'width'         => $aBanner['width'],
                        'height'        => $aBanner['height'],
                        'capping'       => $aBanner['capping'],
                        'htmltemplate'  => $aBanner['html'],
                        'adserver'      => $aBanner['adserver'],
                        'oac_banner_id' => $aBanner['banner_id']
                    );

                    $doBanners = OA_Dal::factoryDO('banners');
                    $doBanners->setFrom($banner);
                    $bannerId = $doBanners->insert();

                    if (!empty($bannerId)) {
                        $aCreated['banners'][] = $bannerId;

                        $zoneSize = "{$aBanner['width']}x{$aBanner['height']}";
                        if (isset($aZones[$zoneSize])) {
                            $zoneId = $aZones[$zoneSize];
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
                        }

                        if (!empty($zoneId)) {
                            // Link banner to zone
                            $aVariables = array(
                                'ad_id'   => $bannerId,
                                'zone_id' => $zoneId
                            );

                            $result = Admin_DA::addAdZone($aVariables);

                            if (PEAR::isError($result)) {
                                $ok = false;
                            }
                        } else {
                            $ok = false;
                        }
                    } else {
                        $ok = false;
                    }
                }
            }
        }

        if (!$ok) {
            if (!$this->oDal->rollback()) {
                $this->oDal->undoEntities($aCreated);
            }

            return false;
        }

        return $this->oDal->commit();
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
