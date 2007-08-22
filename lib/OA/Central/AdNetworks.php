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

require_once MAX_PATH . '/lib/OA.php';
require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/lib/OA/Dal/ApplicationVariables.php';
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
     * @todo Implement rollback
     *
     * @param array $aWebsites
     * @return boolean True on success
     */
    function subscribeWebsites($aWebsites)
    {
        $aPref = $GLOBALS['_MAX']['PREF'];
        $oDbh = OA_DB::singleton();

        $aSubscriptions = $this->oDal->subscribeWebsites($aWebsites);

        if (PEAR::isError($result)) {
            return false;
        }

        if ($oDbh->supports('transactions')) {
            $oDbh->beginTransaction();
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
                $aAdNetworks[$aAdvertiser['adnetwork_id']] = $advertiser + array(
                    'clientid' => $advertiserId
                );
            } else {
                $ok = false;
            }
        }

        for (reset($aSubscriptions['websites']); $ok && ($aWebsite = current($aSubscriptions['websites'])); next($aSubscriptions['websites'])) {
            // Create publisher
            $publisherName = $this->getUniquePublisherName($aWebsite['url']);
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

                $campaignName = $this->getUniqueCampaignName("{$advertiserName} - {$aCampaign['name']}");
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
                    $bannerName = $this->getUniqueBannerName("{$campaignName} - {$aBanner['name']}");
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

        if (!$ok) {
            if ($oDbh->supports('transactions')) {
                $oDbh->rollback();
            } else {
                // Simulate rollback
                $aEntities = array(
                    'publishers'  => array('affiliates', 'affiliateid'),
                    'advertisers' => array('clients', 'clientid'),
                    'campaigns'   => array('campaigns', 'campaignid'),
                    'banners'     => array('banners', 'bannerid'),
                    'zones'       => array('zones', 'zoneid')
                );

                foreach (array_keys($aCreated) as $entity) {
                    if (count($aCreated[$entity])) {
                        $doEntity = OA_Dal::factoryDO($aEntities[$entity][0]);
                        $doEntity->whereInAdd($aEntities[$entity][1], $aCreated[$entity]);
                        $doEntity->delete(true);
                    }
                }
            }

            return false;
        }

        if ($oDbh->supports('transactions')) {
            $result = $oDbh->commit();

            if (PEAR::isError($result)) {
                return false;
            }
        }

        return true;
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
        $oDbh = OA_DB::singleton();
        $tableZones      = $oDbh->quoteIdentifier($GLOBALS['_MAX']['CONF']['table']['prefix'].'zones');
        $tableAffiliates = $oDbh->quoteIdentifier($GLOBALS['_MAX']['CONF']['table']['prefix'].'affiliates');
        $tableAza        = $oDbh->quoteIdentifier($GLOBALS['_MAX']['CONF']['table']['prefix'].'ad_zone_assoc');
        $tableDsah       = $oDbh->quoteIdentifier($GLOBALS['_MAX']['CONF']['table']['prefix'].'data_summary_ad_hourly');

        $batchSequence = OA_Dal_ApplicationVariables::get('batch_sequence');
        $batchSequence = is_null($batchSequence) ? 1 : $batchSequence + 1;

        $aRevenues = $this->oDal->getRevenue($batchSequence);

        if (PEAR::isError($aRevenues)) {
            return false;
        }

        if ($oDbh->supports('transactions')) {
            $oDbh->beginTransaction();
        }

        $doBanners = OA_Dal::factoryDO('banners');
        $doBanners->whereInAdd('oac_banner_id', array_keys($aRevenues));
        $doBanners->orderBy('bannerid');
        $doBanners->find();

        $aOacBannerIds = array();
        while ($doBanners->fetch()) {
            $aOacBannerIds[$doBanners->oac_banner_id] = $doBanners->bannerid;
        }

        foreach ($aRevenues as $bannerId => $aData) {
            foreach ($aData as $aRevenue) {
                if (!isset($aOacBannerIds[$bannerId])) {
                    continue;
                }

                $bannerId = $aOacBannerIds[$bannerId];

                $startDay  = $aRevenue['start']->format('%Y-%m-%d');
                $startHour = (int)$aRevenue['start']->format('%H');
                $endDay    = $aRevenue['end']->format('%Y-%m-%d');
                $endHour   = (int)$aRevenue['end']->format('%H');

                $where = "
                    (
                        (day = '{$startDay}' AND hour >= {$startHour}) OR
                        (day > '{$startDay}' AND day < '{$endDay}') OR
                        (day = '{$endDay}' AND hour <= {$endHour})
                    )
                ";

                $actionType = $aRevenue['type'] = 'CPC' ? 'clicks' : 'impressions';

                $i = 0;
                while (++$i <= 2) {
                    $doDsah = OA_Dal::factoryDO('data_summary_ad_hourly');
                    $doDsah->ad_id = $bannerId;
                    $doDsah->whereAdd($where);
                    $doDsah->orderBy('day, hour');

                    $aStats = $doDsah->getAll(array(), true, false);

                    unset($doDsah);

                    $cntTotal  = count($aStats);
                    $cntActive = 0;
                    $sumActive = 0;
                    $aActive = array();
                    foreach ($aStats as $key => $row) {
                        $row['total_revenue'] = 0;
                        if ($row[$actionType] > 0) {
                            $cntActive++;
                            $sumActive += $row[$actionType];
                            $aActive[$key] = $row;
                        }
                    }

                    // Reset revenue
                    $result = $oDbh->exec("
                        UPDATE
                            {$tableDsah}
                        SET
                            total_revenue = 0,
                            updated = '".OA::getNow()."'
                        WHERE
                            ad_id = {$bannerId} AND
                            (total_revenue <> 0 OR total_revenue IS NULL) AND
                            {$where}
                        ");
                    if (PEAR::isError($result)) {
                        if ($oDbh->supports('transactions')) {
                            $oDbh->rollback();
                        }
                        return false;
                    }

                    $assignedRevenue = 0;
                    if ($sumActive) {
                        $lastHour = array_pop($aActive);

                        foreach ($aActive as $key => $row) {
                            $aActive[$key]['total_revenue'] = $row[$actionType] / $sumActive * $aRevenue['revenue'];
                            $aActive[$key]['total_revenue'] = floor(100 * $aActive[$key]['total_revenue']) / 100;
                            $assignedRevenue += $aActive[$key]['total_revenue'];
                        }

                        $lastHour['total_revenue'] = $aRevenue['revenue'] - $assignedRevenue;
                        array_push($aActive, $lastHour);

                        foreach ($aActive as $key => $row) {
                            $doDsah = OA_Dal::factoryDO('data_summary_ad_hourly');
                            $doDsah->data_summary_ad_hourly_id = $key;
                            $row['updated'] = OA::getNow();
                            $doDsah->setFrom($row);
                            $result = $doDsah->update();
                            if (!$result) {
                                if ($oDbh->supports('transactions')) {
                                    $oDbh->rollback();
                                }
                                return false;
                            }
                        }

                        // Complete
                        break;
                    } else {
                        $aZoneIds = array();
                        $doAza = OA_Dal::factoryDO('ad_zone_assoc');
                        $doAza->ad_id = $bannerId;
                        $doAza->find();
                        while ($doAza->fetch()) {
                            $aZoneIds[] = $doAza->zone_id;
                        }

                        for ($day = $startDay; $day <= $endDay; ) {
                            for ($hour = 0; $hour < 24; $hour++) {
                                if ($day == $startDay && $hour < $startHour) {
                                    continue;
                                }
                                if ($day == $endDay && $hour > $endHour) {
                                    break;
                                }
                                foreach ($aZoneIds as $zoneId) {
                                    $doDsah = OA_Dal::factoryDO('data_summary_ad_hourly');
                                    $doDsah->day     = $day;
                                    $doDsah->hour    = $hour;
                                    $doDsah->ad_id   = $bannerId;
                                    $doDsah->zone_id = $zoneId;

                                    $doDsahClone = clone($doDsah);
                                    if (!$doDsahClone->count()) {
                                        $doDsah->$actionType = 1;
                                        $doDsah->updated = OA::getNow();
                                        $doDsah->insert();
                                    }
                                }
                            }

                            $oDay = new Date($day);
                            $oDay->addSpan(new Date_Span('1-0-0-0'));
                            $day = $oDay->format('%Y-%m-%d');
                        }
                    }
                }
            }
        }

        if (!OA_Dal_ApplicationVariables::set('batch_sequence', $batchSequence)) {
            if ($oDbh->supports('transactions')) {
                $oDbh->rollback();
            }
            return false;
        }

        if ($oDbh->supports('transactions')) {
            $result = $oDbh->commit();

            if (PEAR::isError($result)) {
                return false;
            }
        }

        return true;
    }

    /**
     * A method to generate a unique advertiser name
     *
     * @param string $name
     * @return string The unique name
     */
    function getUniqueAdvertiserName($name)
    {
        return $this->_getUniqueName($name, 'clients', 'clientname');
    }

    /**
     * A method to generate a unique campaign name
     *
     * @param string $name
     * @return string The unique name
     */
    function getUniqueCampaignName($name)
    {
        return $this->_getUniqueName($name, 'campaigns', 'campaignname');
    }

    /**
     * A method to generate a unique banner name
     *
     * @param string $name
     * @return string The unique name
     */
    function getUniqueBannerName($name)
    {
        return $this->_getUniqueName($name, 'banners', 'description');
    }

    /**
     * A method to generate a unique publisher name
     *
     * @param string $name
     * @return string The unique name
     */
    function getUniquePublisherName($name)
    {
        return $this->_getUniqueName($name, 'affiliates', 'name');
    }

    /**
     * A method to generate an unique zone name
     *
     * @param string $name
     * @return string The unique name
     */
    function getUniqueZoneName($name)
    {
        return $this->_getUniqueName($name, 'zones', 'zonename');
    }

    /**
     * A generic internal method to generate unique names for entities
     *
     * @param string $name The original name
     * @param string $entityTable The table to look for duplicate names
     * @param string $entityName The field to look for duplicate names
     * @return string The unique name
     */
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

}

?>
