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

require_once MAX_PATH . '/lib/OA/Admin/Statistics/Delivery/CommonHistory.php';

/**
 * A common class that defines a common "interface" and common methods for
 * classes that display cross-history delivery statistics.
 *
 * @package    OpenXAdmin
 * @subpackage StatisticsDelivery
 */
class OA_Admin_Statistics_Delivery_CommonCrossHistory extends OA_Admin_Statistics_Delivery_CommonHistory
{
    public $crossEntitiesCache;

    public function getAdvertiserPublishers($advertiserId)
    {
        $aParams = [
            'advertiser_id' => $advertiserId,
            'include' => ['publisher_id'],
            'exclude' => ['ad_id', 'zone_id'],
        ];

        if (OA_Permission::isAccount(OA_ACCOUNT_ADVERTISER)) {
            // Get anonymous campaigns
            $aAnonPlacements = Admin_DA::fromCache('getPlacements', ['advertiser_id' => $advertiserId, 'placement_anonymous' => 't']);
        } else {
            $aAnonPlacements = [];
        }

        // Get stats publisher list
        $aStatsPublishers = [];
        foreach ($this->aPlugins as $oPlugin) {
            $pluginParams = $oPlugin->getHistorySpanParams();
            foreach (Admin_DA::fromCache('getEntitiesStats', $aParams + $pluginParams + $this->aDates) as $k => $v) {
                $aStatsPublishers[$v['publisher_id']] = true;
            }
        }

        // Get all publishers
        $aPublishers = Admin_DA::fromCache('getPublishers', [], true);

        // Intersect
        foreach ($aPublishers as $k => $v) {
            if (!isset($aStatsPublishers[$k])) {
                unset($aPublishers[$k]);
            } elseif (count($aAnonPlacements)) {
                // Add anonymous flas
                $aPublishers[$k]['anonymous'] = true;
            }
        }

        // Cache results
        $this->crossEntitiesCache = $aPublishers;

        return $aPublishers;
    }

    public function getAdvertiserZones($advertiserId)
    {
        $aParams = [
            'advertiser_id' => $advertiserId,
            'include' => ['publisher_id'],
        ];

        if (OA_Permission::isAccount(OA_ACCOUNT_ADVERTISER)) {
            // Get anonymous campaigns
            $aAnonPlacements = Admin_DA::fromCache('getPlacements', ['advertiser_id' => $advertiserId, 'placement_anonymous' => 't']);
        } else {
            $aAnonPlacements = [];
        }

        // Get stats zone list
        $aStatsZones = [];
        foreach ($this->aPlugins as $oPlugin) {
            $pluginParams = $oPlugin->getHistorySpanParams();
            foreach (Admin_DA::fromCache('getEntitiesStats', $aParams + $pluginParams + $this->aDates) as $k => $v) {
                $aStatsZones[$v['zone_id']] = true;
            }
        }

        // Get all zones
        $aZones = Admin_DA::fromCache('getZones', [], true);

        // Intersect
        foreach ($aZones as $k => $v) {
            if (!isset($aStatsZones[$k])) {
                unset($aZones[$k]);
            } elseif (count($aAnonPlacements)) {
                // Add anonymous flas
                $aZones[$k]['anonymous'] = true;
            }
        }

        // Cache results
        $this->crossEntitiesCache = $aZones;

        return $aZones;
    }

    public function getCampaignPublishers($placementId)
    {
        $aParams = [
            'placement_id' => $placementId,
            'include' => ['publisher_id'],
            'exclude' => ['ad_id', 'zone_id'],
        ];

        if (OA_Permission::isAccount(OA_ACCOUNT_ADVERTISER)) {
            // Get anonymous campaigns
            $aAnonPlacements = Admin_DA::fromCache('getPlacements', ['placement_id' => $placementId, 'placement_anonymous' => 't']);
        } else {
            $aAnonPlacements = [];
        }

        // Get stats publisher list
        $aStatsPublishers = [];
        foreach ($this->aPlugins as $oPlugin) {
            $pluginParams = $oPlugin->getHistorySpanParams();
            foreach (Admin_DA::fromCache('getEntitiesStats', $aParams + $pluginParams + $this->aDates) as $k => $v) {
                $aStatsPublishers[$v['publisher_id']] = true;
            }
        }

        // Get all publishers
        $aPublishers = Admin_DA::fromCache('getPublishers', [], true);

        // Intersect
        foreach ($aPublishers as $k => $v) {
            if (!isset($aStatsPublishers[$k])) {
                unset($aPublishers[$k]);
            } elseif (count($aAnonPlacements)) {
                // Add anonymous flas
                $aPublishers[$k]['anonymous'] = true;
            }
        }

        // Cache results
        $this->crossEntitiesCache = $aPublishers;

        return $aPublishers;
    }

    public function getCampaignZones($placementId)
    {
        $aParams = [
            'placement_id' => $placementId,
            'exclude' => ['ad_id'],
        ];

        if (OA_Permission::isAccount(OA_ACCOUNT_ADVERTISER)) {
            // Get anonymous campaigns
            $aAnonPlacements = Admin_DA::fromCache('getPlacements', ['placement_id' => $placementId, 'placement_anonymous' => 't']);
        } else {
            $aAnonPlacements = [];
        }

        // Get stats zone list
        $aStatsZones = [];
        foreach ($this->aPlugins as $oPlugin) {
            $pluginParams = $oPlugin->getHistorySpanParams();
            foreach (Admin_DA::fromCache('getEntitiesStats', $aParams + $pluginParams + $this->aDates) as $k => $v) {
                $aStatsZones[$v['zone_id']] = true;
            }
        }

        // Get all zones
        $aZones = Admin_DA::fromCache('getZones', [], true);

        // Intersect
        foreach ($aZones as $k => $v) {
            if (!isset($aStatsZones[$k])) {
                unset($aZones[$k]);
            } elseif (count($aAnonPlacements)) {
                // Add anonymous flas
                $aZones[$k]['anonymous'] = true;
            }
        }

        // Cache results
        $this->crossEntitiesCache = $aZones;

        return $aZones;
    }

    public function getBannerPublishers($adId, $placementId)
    {
        $aParams = [
            'ad_id' => $adId,
            'include' => ['publisher_id'],
            'exclude' => ['ad_id', 'zone_id'],
        ];

        if (OA_Permission::isAccount(OA_ACCOUNT_ADVERTISER)) {
            // Get anonymous campaigns
            $aAnonPlacements = Admin_DA::fromCache('getPlacements', ['placement_id' => $placementId, 'placement_anonymous' => 't']);
        } else {
            $aAnonPlacements = [];
        }

        // Get stats publisher list
        $aStatsPublishers = [];
        foreach ($this->aPlugins as $oPlugin) {
            $pluginParams = $oPlugin->getHistorySpanParams();
            foreach (Admin_DA::fromCache('getEntitiesStats', $aParams + $pluginParams + $this->aDates) as $k => $v) {
                $aStatsPublishers[$v['publisher_id']] = true;
            }
        }
        
        // Get all publishers
        $aPublishers = Admin_DA::fromCache('getPublishers', [], true);

        // Intersect
        foreach ($aPublishers as $k => $v) {
            if (!isset($aStatsPublishers[$k])) {
                unset($aPublishers[$k]);
            } elseif (count($aAnonPlacements)) {
                // Add anonymous flas
                $aPublishers[$k]['anonymous'] = true;
            }
        }

        // Cache results
        $this->crossEntitiesCache = $aPublishers;

        return $aPublishers;
    }

    public function getBannerZones($adId, $placementId)
    {
        $aParams = [
            'ad_id' => $adId,
            'exclude' => ['ad_id'],
        ];

        if (OA_Permission::isAccount(OA_ACCOUNT_ADVERTISER)) {
            // Get anonymous campaigns
            $aAnonPlacements = Admin_DA::fromCache('getPlacements', ['placement_id' => $placementId, 'placement_anonymous' => 't']);
        } else {
            $aAnonPlacements = [];
        }

        // Get stats zone list
        $aStatsZones = [];
        foreach ($this->aPlugins as $oPlugin) {
            $pluginParams = $oPlugin->getHistorySpanParams();
            foreach (Admin_DA::fromCache('getEntitiesStats', $aParams + $pluginParams + $this->aDates) as $k => $v) {
                $aStatsZones[$v['zone_id']] = true;
            }
        }

        // Get all zones
        $aZones = Admin_DA::fromCache('getZones', [], true);

        // Intersect
        foreach ($aZones as $k => $v) {
            if (!isset($aStatsZones[$k])) {
                unset($aZones[$k]);
            } elseif (count($aAnonPlacements)) {
                // Add anonymous flas
                $aZones[$k]['anonymous'] = true;
            }
        }

        // Cache results
        $this->crossEntitiesCache = $aZones;

        return $aZones;
    }

    public function getPublisherCampaigns($publisherId)
    {
        $aParams = [
            'publisher_id' => $publisherId,
            'include' => ['placement_id'],
            'exclude' => ['ad_id', 'zone_id'],
        ];

        // Get stats campaign list
        $aStatsPlacements = [];
        foreach ($this->aPlugins as $oPlugin) {
            $pluginParams = $oPlugin->getHistorySpanParams();
            foreach (Admin_DA::fromCache('getEntitiesStats', $aParams + $pluginParams + $this->aDates) as $k => $v) {
                $aStatsPlacements[$v['placement_id']] = true;
            }
        }

        // Get all campaigns
        $aPlacements = Admin_DA::fromCache('getPlacements', [], true);

        // Intersect
        foreach ($aPlacements as $k => $v) {
            if (!isset($aStatsPlacements[$k])) {
                unset($aPlacements[$k]);
            }
        }

        // Cache results
        $this->crossEntitiesCache = $aPlacements;

        return $aPlacements;
    }

    public function getPublisherBanners($publisherId)
    {
        $aParams = [
            'publisher_id' => $publisherId,
            'exclude' => ['zone_id'],
        ];

        // Get stats banner list
        $aStatsAds = [];
        foreach ($this->aPlugins as $oPlugin) {
            $pluginParams = $oPlugin->getHistorySpanParams();
            foreach (Admin_DA::fromCache('getEntitiesStats', $aParams + $pluginParams + $this->aDates) as $k => $v) {
                $aStatsAds[$v['ad_id']] = true;
            }
        }

        // Get all banners
        $aAds = Admin_DA::fromCache('getAds', []);

        // Get anonymous campaigns
        $aAnonPlacements = Admin_DA::fromCache('getPlacements', ['placement_anonymous' => 't']);

        // Intersect
        foreach ($aAds as $k => $v) {
            if (!isset($aStatsAds[$k])) {
                unset($aAds[$k]);
            } else {
                $aAds[$k]['anonymous'] = isset($aAnonPlacements[$v['placement_id']]);
            }
        }

        // Cache results
        $this->crossEntitiesCache = $aAds;

        return $aAds;
    }

    public function getZoneCampaigns($zoneId)
    {
        $aParams = [
            'zone_id' => $zoneId,
            'include' => ['placement_id'],
            'exclude' => ['ad_id', 'zone_id'],
        ];

        // Get stats campaign list
        $aStatsPlacements = [];
        foreach ($this->aPlugins as $oPlugin) {
            $pluginParams = $oPlugin->getHistorySpanParams();
            foreach (Admin_DA::fromCache('getEntitiesStats', $aParams + $pluginParams + $this->aDates) as $k => $v) {
                $aStatsPlacements[$v['placement_id']] = true;
            }
        }

        // Get all campaigns
        $aPlacements = Admin_DA::fromCache('getPlacements', [], true);

        // Intersect
        foreach ($aPlacements as $k => $v) {
            if (!isset($aStatsPlacements[$k])) {
                unset($aPlacements[$k]);
            }
        }

        // Cache results
        $this->crossEntitiesCache = $aPlacements;

        return $aPlacements;
    }

    public function getZoneBanners($zoneId)
    {
        $aParams = [
            'zone_id' => $zoneId,
            'exclude' => ['zone_id'],
        ];

        // Get stats banner list
        $aStatsAds = [];
        foreach ($this->aPlugins as $oPlugin) {
            $pluginParams = $oPlugin->getHistorySpanParams();
            foreach (Admin_DA::fromCache('getEntitiesStats', $aParams + $pluginParams + $this->aDates) as $k => $v) {
                $aStatsAds[$v['ad_id']] = true;
            }
        }

        // Get all banners
        $aAds = Admin_DA::fromCache('getAds', []);

        // Get anonymous campaigns
        $aAnonPlacements = Admin_DA::fromCache('getPlacements', ['placement_anonymous' => 't']);

        // Intersect
        foreach ($aAds as $k => $v) {
            if (!isset($aStatsAds[$k])) {
                unset($aAds[$k]);
            } else {
                $aAds[$k]['anonymous'] = isset($aAnonPlacements[$v['placement_id']]);
            }
        }

        // Cache results
        $this->crossEntitiesCache = $aAds;

        return $aAds;
    }

    public function addCrossBreadCrumbs($type, $entityId, $level = 0)
    {
        $cache = $this->crossEntitiesCache;
        switch ($type) {

        case 'campaign':
            if ($this->noStatsAvailable) {
                $this->_addBreadcrumb('', MAX_getEntityIcon('placement'), $type);
            } else {
                $this->_addBreadcrumb(MAX_buildName($entityId, MAX_getPlacementName($cache[$entityId])), MAX_getEntityIcon('placement'), $type);
            }

            break;

        case 'banner':
            if ($this->noStatsAvailable) {
                $this->_addBreadcrumb('', MAX_getEntityIcon('ad'), $type);
            } else {
                $this->_addBreadcrumb(MAX_buildName($entityId, MAX_getAdName($cache[$entityId]['name'], null, null, $cache[$entityId]['anonymous'], $entityId)), MAX_getEntityIcon('ad'), $type);
            }

            break;

        case 'publisher':
            if ($this->noStatsAvailable) {
                $this->_addBreadcrumb('', MAX_getEntityIcon('publisher'), '');
            } else {
                $this->_addBreadcrumb(MAX_buildName($entityId, MAX_getPublisherName($cache[$entityId]['name'], null, $cache[$entityId]['anonymous'], $entityId)), MAX_getEntityIcon('publisher'), 'website');
            }

            break;

        case 'zone':
            if ($this->noStatsAvailable) {
                $this->_addBreadcrumb('', MAX_getEntityIcon('zone'), $type);
            } else {
                $this->_addBreadcrumb(MAX_buildName($entityId, MAX_getZoneName($cache[$entityId]['name'], null, $cache[$entityId]['anonymous'], $entityId)), MAX_getEntityIcon('zone'), $type);
            }

            break;
        }
    }
}
