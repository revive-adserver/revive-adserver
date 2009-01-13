<?php

/*
+---------------------------------------------------------------------------+
| OpenX  v${RELEASE_MAJOR_MINOR}                                                              |
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

require_once MAX_PATH . '/lib/OA/Admin/Statistics/Delivery/CommonHistory.php';

/**
 * A common class that defines a common "interface" and common methods for
 * classes that display cross-history delivery statistics.
 *
 * @package    OpenXAdmin
 * @subpackage StatisticsDelivery
 * @author     Matteo Beccati <matteo@beccati.com>
 * @author     Andrew Hill <andrew.hill@openx.org>
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

            if (isset($pluginParams['custom_table'])) {
                $pluginParams = array('custom_table' => $pluginParams['custom_table']);
            } else {
                $pluginParams = array();
            }

            $aStatsPublishers += Admin_DA::fromCache('getEntitiesStats', $aParams + $pluginParams + $this->aDates);

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

            if (isset($pluginParams['custom_table'])) {
                $pluginParams = array('custom_table' => $pluginParams['custom_table']);
            } else {
                $pluginParams = array();
            }

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

            if (isset($pluginParams['custom_table'])) {
                $pluginParams = array('custom_table' => $pluginParams['custom_table']);
            } else {
                $pluginParams = array();
            }

            $aStatsPublishers += Admin_DA::fromCache('getEntitiesStats', $aParams + $pluginParams + $this->aDates);

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

            if (isset($pluginParams['custom_table'])) {
                $pluginParams = array('custom_table' => $pluginParams['custom_table']);
            } else {
                $pluginParams = array();
            }

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

            if (isset($pluginParams['custom_table'])) {
                $pluginParams = array('custom_table' => $pluginParams['custom_table']);
            } else {
                $pluginParams = array();
            }

            $aStatsPublishers += Admin_DA::fromCache('getEntitiesStats', $aParams + $pluginParams + $this->aDates);

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

            if (isset($pluginParams['custom_table'])) {
                $pluginParams = array('custom_table' => $pluginParams['custom_table']);
            } else {
                $pluginParams = array();
            }

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

            if (isset($pluginParams['custom_table'])) {
                $pluginParams = array('custom_table' => $pluginParams['custom_table']);
            } else {
                $pluginParams = array();
            }

            $aStatsPlacements += Admin_DA::fromCache('getEntitiesStats', $aParams + $pluginParams + $this->aDates);
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

            if (isset($pluginParams['custom_table'])) {
                $pluginParams = array('custom_table' => $pluginParams['custom_table']);
            } else {
                $pluginParams = array();
            }

            $aStatsAds += Admin_DA::fromCache('getEntitiesStats', $aParams + $pluginParams + $this->aDates);
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

            if (isset($pluginParams['custom_table'])) {
                $pluginParams = array('custom_table' => $pluginParams['custom_table']);
            } else {
                $pluginParams = array();
            }

            $aStatsPlacements += Admin_DA::fromCache('getEntitiesStats', $aParams + $pluginParams + $this->aDates);
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

            if (isset($pluginParams['custom_table'])) {
                $pluginParams = array('custom_table' => $pluginParams['custom_table']);
            } else {
                $pluginParams = array();
            }

            $aStatsAds += Admin_DA::fromCache('getEntitiesStats', $aParams + $pluginParams + $this->aDates);
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
                $this->_addBreadcrumb('', MAX_getEntityIcon('placement'));
            } else {
                $this->_addBreadcrumb(MAX_buildName($entityId, MAX_getPlacementName($cache[$entityId])), MAX_getEntityIcon('placement'));
            }

            break;

        case 'banner':
            if ($this->noStatsAvailable) {
                $this->_addBreadcrumb('', MAX_getEntityIcon('ad'));
            } else {
                $this->_addBreadcrumb(MAX_buildName($entityId, MAX_getAdName($cache[$entityId]['name'], null, null, $cache[$entityId]['anonymous'], $entityId)), MAX_getEntityIcon('ad'));
            }

            break;

        case 'publisher':
            if ($this->noStatsAvailable) {
                $this->_addBreadcrumb('', MAX_getEntityIcon('publisher'));
            } else {
                $this->_addBreadcrumb(MAX_buildName($entityId, MAX_getPublisherName($cache[$entityId]['name'], null, $cache[$entityId]['anonymous'], $entityId)), MAX_getEntityIcon('publisher'));
            }

            break;

        case 'zone':
            if ($this->noStatsAvailable) {
                $this->_addBreadcrumb('', MAX_getEntityIcon('zone'));
            } else {
                $this->_addBreadcrumb(MAX_buildName($entityId, MAX_getZoneName($cache[$entityId]['name'], null, $cache[$entityId]['anonymous'], $entityId)), MAX_getEntityIcon('zone'));
            }

            break;
        }
    }

}

?>