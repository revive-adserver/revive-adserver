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

    var $crossEntitiesCache;

    function getAdvertiserPublishers($advertiserId)
    {
        $aParams = array(
            'advertiser_id' => $advertiserId,
            'include' => array('publisher_id'),
            'exclude' => array('ad_id', 'zone_id'),
            'custom_columns' => array()
        );

        if (OA_Permission::isAccount(OA_ACCOUNT_ADVERTISER)) {
            // Get anonymous campaigns
            $aAnonPlacements = Admin_DA::fromCache('getPlacements', array('advertiser_id' => $advertiserId, 'placement_anonymous' => 't'));
        } else {
            $aAnonPlacements = array();
        }

        // Get stats publisher list
        $aStatsPublishers = array();
        foreach ($this->aPlugins as $oPlugin) {
            $pluginParams = $oPlugin->getHistorySpanParams();
            foreach (Admin_DA::fromCache('getEntitiesStats', $aParams + $pluginParams + $this->aDates) as $k => $v) {
                $aStatsPublishers[$v['publisher_id']] = true;
            }
        }

        // Get all publishers
        $aPublishers = Admin_DA::fromCache('getPublishers', array(), true);

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

    function getAdvertiserZones($advertiserId)
    {
        $aParams = array(
            'advertiser_id' => $advertiserId,
            'include' => array('publisher_id'),
            'custom_columns' => array()
        );

        if (OA_Permission::isAccount(OA_ACCOUNT_ADVERTISER)) {
            // Get anonymous campaigns
            $aAnonPlacements = Admin_DA::fromCache('getPlacements', array('advertiser_id' => $advertiserId, 'placement_anonymous' => 't'));
        } else {
            $aAnonPlacements = array();
        }

        // Get stats zone list
        $aStatsZones = array();
        foreach ($this->aPlugins as $oPlugin) {
            $pluginParams = $oPlugin->getHistorySpanParams();
            foreach (Admin_DA::fromCache('getEntitiesStats', $aParams + $pluginParams + $this->aDates) as $k => $v) {
                $aStatsZones[$v['zone_id']] = true;
            }
        }

        // Get all zones
        $aZones = Admin_DA::fromCache('getZones', array(), true);

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

    function getCampaignPublishers($placementId)
    {
        $aParams = array(
            'placement_id' => $placementId,
            'include' => array('publisher_id'),
            'exclude' => array('ad_id', 'zone_id'),
            'custom_columns' => array()
        );

        if (OA_Permission::isAccount(OA_ACCOUNT_ADVERTISER)) {
            // Get anonymous campaigns
            $aAnonPlacements = Admin_DA::fromCache('getPlacements', array('placement_id' => $placementId, 'placement_anonymous' => 't'));
        } else {
            $aAnonPlacements = array();
        }

        // Get stats publisher list
        $aStatsPublishers = array();
        foreach ($this->aPlugins as $oPlugin) {
            $pluginParams = $oPlugin->getHistorySpanParams();
            foreach (Admin_DA::fromCache('getEntitiesStats', $aParams + $pluginParams + $this->aDates) as $k => $v) {
                $aStatsPublishers[$v['publisher_id']] = true;
            }
        }

        // Get all publishers
        $aPublishers = Admin_DA::fromCache('getPublishers', array(), true);

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

    function getCampaignZones($placementId)
    {
        $aParams = array(
            'placement_id' => $placementId,
            'exclude' => array('ad_id'),
            'custom_columns' => array()
        );

        if (OA_Permission::isAccount(OA_ACCOUNT_ADVERTISER)) {
            // Get anonymous campaigns
            $aAnonPlacements = Admin_DA::fromCache('getPlacements', array('placement_id' => $placementId, 'placement_anonymous' => 't'));
        } else {
            $aAnonPlacements = array();
        }

        // Get stats zone list
        $aStatsZones = array();
        foreach ($this->aPlugins as $oPlugin) {
            $pluginParams = $oPlugin->getHistorySpanParams();
            foreach (Admin_DA::fromCache('getEntitiesStats', $aParams + $pluginParams + $this->aDates) as $k => $v) {
                $aStatsZones[$v['zone_id']] = true;
            }
        }

        // Get all zones
        $aZones = Admin_DA::fromCache('getZones', array(), true);

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

    function getBannerPublishers($adId, $placementId)
    {
        $aParams = array(
            'ad_id' => $adId,
            'include' => array('publisher_id'),
            'exclude' => array('ad_id', 'zone_id'),
            'custom_columns' => array()
        );

        if (OA_Permission::isAccount(OA_ACCOUNT_ADVERTISER)) {
            // Get anonymous campaigns
            $aAnonPlacements = Admin_DA::fromCache('getPlacements', array('placement_id' => $placementId, 'placement_anonymous' => 't'));
        } else {
            $aAnonPlacements = array();
        }

        // Get stats publisher list
        $aStatsPublishers = array();
        foreach ($this->aPlugins as $oPlugin) {
            $pluginParams = $oPlugin->getHistorySpanParams();
            foreach (Admin_DA::fromCache('getEntitiesStats', $aParams + $pluginParams + $this->aDates) as $k => $v) {
                $aStatsPublishers[$v['publisher_id']] = true;
            }
        }
        
        // Get all publishers
        $aPublishers = Admin_DA::fromCache('getPublishers', array(), true);

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

    function getBannerZones($adId, $placementId)
    {
        $aParams = array(
            'ad_id' => $adId,
            'exclude' => array('ad_id'),
            'custom_columns' => array()
        );

        if (OA_Permission::isAccount(OA_ACCOUNT_ADVERTISER)) {
            // Get anonymous campaigns
            $aAnonPlacements = Admin_DA::fromCache('getPlacements', array('placement_id' => $placementId, 'placement_anonymous' => 't'));
        } else {
            $aAnonPlacements = array();
        }

        // Get stats zone list
        $aStatsZones = array();
        foreach ($this->aPlugins as $oPlugin) {
            $pluginParams = $oPlugin->getHistorySpanParams();
            foreach (Admin_DA::fromCache('getEntitiesStats', $aParams + $pluginParams + $this->aDates) as $k => $v) {
                $aStatsZones[$v['zone_id']] = true;
            }
        }

        // Get all zones
        $aZones = Admin_DA::fromCache('getZones', array(), true);

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

    function getPublisherCampaigns($publisherId)
    {
        $aParams = array(
            'publisher_id' => $publisherId,
            'include' => array('placement_id'),
            'exclude' => array('ad_id', 'zone_id'),
            'custom_columns' => array()
        );

        // Get stats campaign list
        $aStatsPlacements = array();
        foreach ($this->aPlugins as $oPlugin) {
            $pluginParams = $oPlugin->getHistorySpanParams();
            foreach (Admin_DA::fromCache('getEntitiesStats', $aParams + $pluginParams + $this->aDates) as $k => $v) {
                $aStatsPlacements[$v['placement_id']] = true;
            }                       
        }

        // Get all campaigns
        $aPlacements = Admin_DA::fromCache('getPlacements', array(), true);

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

    function getPublisherBanners($publisherId)
    {
        $aParams = array(
            'publisher_id' => $publisherId,
            'exclude' => array('zone_id'),
            'custom_columns' => array()
        );

        // Get stats banner list
        $aStatsAds = array();
        foreach ($this->aPlugins as $oPlugin) {
            $pluginParams = $oPlugin->getHistorySpanParams();
            foreach (Admin_DA::fromCache('getEntitiesStats', $aParams + $pluginParams + $this->aDates) as $k => $v) {
                $aStatsAds[$v['ad_id']] = true;
            }  
        }

        // Get all banners
        $aAds = Admin_DA::fromCache('getAds', array());

        // Get anonymous campaigns
        $aAnonPlacements = Admin_DA::fromCache('getPlacements', array('placement_anonymous' => 't'));

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

    function getZoneCampaigns($zoneId)
    {
        $aParams = array(
            'zone_id' => $zoneId,
            'include' => array('placement_id'),
            'exclude' => array('ad_id', 'zone_id'),
            'custom_columns' => array()
        );

        // Get stats campaign list
        $aStatsPlacements = array();
        foreach ($this->aPlugins as $oPlugin) {
            $pluginParams = $oPlugin->getHistorySpanParams();
            foreach (Admin_DA::fromCache('getEntitiesStats', $aParams + $pluginParams + $this->aDates) as $k => $v) {
                $aStatsPlacements[$v['placement_id']] = true;
            }              
        }

        // Get all campaigns
        $aPlacements = Admin_DA::fromCache('getPlacements', array(), true);

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

    function getZoneBanners($zoneId)
    {
        $aParams = array(
            'zone_id' => $zoneId,
            'exclude' => array('zone_id'),
            'custom_columns' => array()
        );

        // Get stats banner list
        $aStatsAds = array();
        foreach ($this->aPlugins as $oPlugin) {
            $pluginParams = $oPlugin->getHistorySpanParams();
            foreach (Admin_DA::fromCache('getEntitiesStats', $aParams + $pluginParams + $this->aDates) as $k => $v) {
                $aStatsAds[$v['ad_id']] = true;
            }
        }

        // Get all banners
        $aAds = Admin_DA::fromCache('getAds', array());

        // Get anonymous campaigns
        $aAnonPlacements = Admin_DA::fromCache('getPlacements', array('placement_anonymous' => 't'));

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

    function addCrossBreadCrumbs($type, $entityId, $level = 0)
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

?>