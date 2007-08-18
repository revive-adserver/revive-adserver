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
$Id$
*/

require_once MAX_PATH . '/lib/OA.php';
require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/lib/OA/Dal/Central/AdNetworks.php';

require_once MAX_PATH . '/lib/max/Admin_DA.php';


/**
 * OAP binding to the OAC ad networks API
 *
 */
class OA_Central_AdNetworks
{
    /**
     * @var OA_Dal_Central_AdNetworks
     */
    var $oDal;

    /**
     * Class constructor
     *
     * @return OA_Central_AdNetworks
     */
    function OA_Central_AdNetworks()
    {
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
        $result = $this->oDal->getCategories($aPref['language']);

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
        $result = $this->oDal->getCountries($aPref['language']);

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
        $result = $this->oDal->getLanguages($aPref['language']);

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
     * @param array $aWebsites
     * @return boolean True on success
     */
    function subscribeWebsites($aWebsites)
    {
        $aPref = $GLOBALS['_MAX']['PREF'];

        $aWebsites = $this->oDal->subscribeWebsites($aWebsites);

        if (PEAR::isError($result)) {
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

        $ok = true;
        for (reset($aWebsites); $ok && ($aWebsite = current($aWebsites)); next($aWebsites)) {
            // Create publisher
            $publisherName = $this->getUniquePublisherName($aWebsite['url']);
            $publisher = array(
                'name'     => $publisherName,
                'mnemonic' => '',
                'contact'  => $aPref['admin_name'],
                'email'    => $aPref['admin_email'],
                'website'  => $aWebsite['url']
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

            for (reset($aWebsite['advertisers']); $ok && ($aAdvertiser = current($aWebsite['advertisers'])); next($aWebsite['advertisers'])) {
                // Create advertiser
                $advertiserName = $this->getUniqueAdvertiserName($aAdvertiser['name']);
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
                } else {
                    $ok = false;
                }

                for (reset($aAdvertiser['campaigns']); $ok && ($aCampaign = current($aAdvertiser['campaigns'])); next($aAdvertiser['campaigns'])) {
                    // Create campaign
                    $campaignName = $this->getUniqueCampaignName("{$advertiserName} - {$aCampaign['name']}");
                    $campaign = array(
                        'campaignname' => $campaignName,
                        'clientid'     => $advertiserId,
                        'weight'       => $aCampaign['weight'],
                        'capping'      => $aCampaign['capping']
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
                        $bannerName = $this->getUniqueBannerName("{$campaignName} - {$aBanner['name']}");
                        $banner = array(
                            'description'  => $bannerName,
                            'campaignid'   => $campaignId,
                            'width'        => $aBanner['width'],
                            'height'       => $aBanner['height'],
                            'capping'      => $aBanner['capping'],
                            'htmltemplate' => $aBanner['html'],
                            'adserver'     => $aBanner['adserver']
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
                                $zoneName = $this->getUniqueZoneName("{$publisherName} - {$zoneSize}");
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
        }

        if (!$ok) {
            // Rollback
            return false;
        }

        return true;
    }

    function _getUniqueName($name, $entityTable, $entityName)
    {
        $doEntities = OA_Dal::factoryDO($entityTable);
        $doEntities->find();

        $aNames = array();
        while ($doEntities->fetch()) {
            $aNames[] = $doEntities->$entityName;
        }

        if (!in_array($name, $aNames)) {
            return $name;
        }

        $aNumbers = array();
        foreach ($aNames as $value) {
            if (preg_match('/^'.preg_quote($name, '/').' \((\d+)\)$/', $value, $m)) {
                $aNumbers[] = intval($m[1]);
            }
        }

        if (count($aNumbers)) {
            rsort($aNumbers, SORT_NUMERIC);

            $number = current($aNumbers) + 1;
        } else {
            $number = 2;
        }

        return "{$name} ({$number})";
    }

    function getUniqueAdvertiserName($name)
    {
        return $this->_getUniqueName($name, 'clients', 'clientname');
    }

    function getUniqueCampaignName($name)
    {
        return $this->_getUniqueName($name, 'campaigns', 'campaignname');
    }

    function getUniqueBannerName($name)
    {
        return $this->_getUniqueName($name, 'banners', 'description');
    }

    function getUniquePublisherName($name)
    {
        return $this->_getUniqueName($name, 'affiliates', 'name');
    }

    function getUniqueZoneName($name)
    {
        return $this->_getUniqueName($name, 'zones', 'zonename');
    }
}

?>