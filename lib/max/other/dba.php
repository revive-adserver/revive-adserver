<?php

/*
+---------------------------------------------------------------------------+
| Max Media Manager v0.3                                                    |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2006 m3 Media Services Limited                         |
| For contact details, see: http://www.m3.net/                              |
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

require_once MAX_PATH . '/lib/max/other/db_proc.php';

// not used anywhere
function MAX_addAd($aVariables)
{
    _switch($aVariables, 'placement_id', 'campaignid');
    _switch($aVariables, 'type', 'storagetype');
    _switch($aVariables, 'name', 'description');
    return MAX_addEntity('ad', $aVariables);
}

// not used anywhere
function MAX_addAdvertiser($aVariables)
{
    _switch($aVariables, 'agency_id', 'agencyid');
    _switch($aVariables, 'name', 'clientname');
    return MAX_addEntity('advertiser', $aVariables);
}

function MAX_addCategory($aVariables)
{
    return MAX_addEntity('category', $aVariables);
}

// not used anywhere
function MAX_addLimitation($aVariables)
{
    _switch($aVariables, 'ad_id', 'bannerid');
    return MAX_addEntity('limitation', $aVariables);
}

// not used anywhere
function MAX_addPlacement($aVariables)
{
    _switch($aVariables, 'advertiser_id', 'clientid');
    _switch($aVariables, 'name', 'campaignname');
    return MAX_addEntity('placement', $aVariables);
}

// not used anywhere
function MAX_addPlacementTracker($aVariables)
{
    _switch($aVariables, 'placement_id', 'campaignid');
    _switch($aVariables, 'tracker_id', 'trackerid');
    return MAX_addEntity('placement_tracker', $aVariables);
}

// not used anywhere
function MAX_addPublisher($aVariables)
{
    _switch($aVariables, 'agency_id', 'agencyid');
    return MAX_addEntity('publisher', $aVariables);
}

// not used anywhere
function MAX_addTracker($aVariables)
{
    _switch($aVariables, 'advertiser_id', 'clientid');
    return MAX_addEntity('tracker', $aVariables);
}

// not used anywhere
function MAX_addZone($aVariables)
{
    _switch($aVariables, 'publisher_id', 'affiliateid');
    _switch($aVariables, 'name', 'zonename');
    _switch($aVariables, 'type', 'delivery');
    return MAX_addEntity('zone', $aVariables);
}

//  upgrade
function MAX_addAdCategory($aVariables)
{
    return MAX_addEntity('ad_category_assoc', $aVariables);
}

//  upgrade, banner-zone
function MAX_addAdZone($aVariables)
{
    return MAX_addEntity('ad_zone_assoc', $aVariables);
}

//  upgrade
function MAX_addPlacementZone($aVariables)
{
    return MAX_addEntity('placement_zone_assoc', $aVariables);
}


// Remove functions

// not used anywhere
function MAX_removeAd($adId)
{
    return MAX_removeEntity('ad', $adId);
}

// not used anywhere
function MAX_removeAds($aParams)
{
    return MAX_removeEntities('ad', $aParams);
}

// not used anywhere
function MAX_removeAdvertiser($advertiserId)
{
    return MAX_removeEntity('advertiser', $advertiserId);
}

// not used anywhere
function MAX_removeAdvertisers($aParams)
{
    return MAX_removeEntities('advertiser', $aParams);
}

// not used anywhere
function MAX_removeAgency($advertiserId)
{
    return MAX_removeEntity('agency', $advertiserId);
}

// not used anywhere
function MAX_removeAgencies($aParams)
{
    return MAX_removeEntities('agency', $aParams);
}

// not used anywhere
function MAX_removeCategory($categoryId)
{
    return MAX_removeEntity('category', $categoryId);
}

// not used anywhere
function MAX_removeCategories($aParams)
{
    return MAX_removeEntities('category', $aParams);
}

// not used anywhere
function MAX_removeImage($imageName)
{
    return MAX_removeEntity('image', $imageName);
}

// not used anywhere
function MAX_removeLimitations($aParams)
{
    return MAX_removeEntities('limitation', $aParams);
}

// not used anywhere
function MAX_removePlacement($placementId)
{
    return MAX_removeEntity('placement', $placementId);
}

// not used anywhere
function MAX_removePlacements($aParams)
{
    return MAX_removeEntities('placement', $aParams);
}

// not used anywhere
function MAX_removePlacementTracker($placementTrackerId)
{
    return MAX_removeEntity('placement_tracker', $placementTrackerId);
}

// not used anywhere
function MAX_removePlacementTrackers($aParams)
{
    return MAX_removeEntities('placement_tracker', $aParams);
}

// not used anywhere
function MAX_removeAdCategories($aParams)
{
    return MAX_removeEntities('ad_category_assoc', $aParams);
}

// not used anywhere
function MAX_removeAdZones($aParams)
{
    return MAX_removeEntities('ad_zone_assoc', $aParams);
}

// not used anywhere
function MAX_removePlacementZones($aParams)
{
    return MAX_removeEntities('placement_zone_assoc', $aParams);
}

// not used anywhere
function MAX_removePublisher($publisherId)
{
    return MAX_removeEntity('publisher', $publisherId);
}

// not used anywhere
function MAX_removePublishers($aParams)
{
    return MAX_removeEntities('publisher', $aParams);
}

// not used anywhere
function MAX_removeTracker($trackerId)
{
    return MAX_removeEntity('tracker', $trackerId);
}

// not used anywhere
function MAX_removeTrackers($aParams)
{
    return MAX_removeEntities('tracker', $aParams);
}

// not used anywhere
function MAX_addVariable($aVariables)
{
    return MAX_addEntity('variable', $aVariables);
}

// not used anywhere
function MAX_removeVariable($variableId)
{
    return MAX_removeEntity('variable', $variableId);
}

// not used anywhere
function MAX_removeVariables($aParams)
{
    return MAX_removeEntities('variable', $aParams);
}

// not used anywhere
function MAX_removeZone($zoneId)
{
    return MAX_removeEntity('zone', $zoneId);
}

// not used anywhere
function MAX_removeZones($aParams)
{
    return MAX_removeEntities('zone', $aParams);
}


// Set

// not used anywhere
function MAX_setAd($adId, $aVariables)
{
    return MAX_setEntity('ad', $adId, $aVariables);
}

// not used anywhere
function MAX_setAds($aParams, $aVariables)
{
    return MAX_setEntities('ad', $aParams, $aVariables);
}


function MAX_getCachedAdvertisersStats($aParams, $allFields=false, $timeout=-1)
{
    $conf = $GLOBALS['_MAX']['CONF'];

    include_once 'Cache/Lite/Function.php';
    $options = array('cacheDir' => MAX_CACHE, 'lifeTime' => ($timeout > -1 ? $timeout : $conf['delivery']['cacheExpire']));
    $cache = new Cache_Lite_Function($options);
    return $cache->call('MAX_getAdvertisersStats', $aParams, $allFields);
}

function MAX_getAdvertisersStats($aParams, $allFields=false)
{
    $aAdvertisers = MAX_getEntitiesChildren('advertiser', $aParams);
    $aAdvertisersStats = MAX_getEntitiesStats('advertiser', $aParams);
    $aActiveParams = array('placement_active' => 't', 'ad_active' => 't');
    $aActiveAdvertisers = MAX_getEntities('advertiser', $aParams + $aActiveParams);
    foreach ($aAdvertisers as $advertiserId => $aAdvertiser) {
        foreach (array('sum_requests', 'sum_views', 'sum_clicks', 'sum_conversions') as $item) {
            $aAdvertisers[$advertiserId][$item] = !empty($aAdvertisersStats[$advertiserId][$item]) ? $aAdvertisersStats[$advertiserId][$item] : 0;
        }
        $aAdvertisers[$advertiserId]['active'] = isset($aActiveAdvertisers[$advertiserId]);
    }

    return $aAdvertisers;
}

function MAX_getCachedPlacementsStats($aParams, $allFields=false, $timeout=-1)
{
    $conf = $GLOBALS['_MAX']['CONF'];

    include_once 'Cache/Lite/Function.php';
    $options = array('cacheDir' => MAX_CACHE, 'lifeTime' => ($timeout > -1 ? $timeout : $conf['delivery']['cacheExpire']));
    $cache = new Cache_Lite_Function($options);
    return $cache->call('MAX_getPlacementsStats', $aParams, $allFields);
}

function MAX_getPlacementsStats($aParams, $allFields=false)
{
    $aPlacements = MAX_getEntitiesChildren('placement', $aParams);
    $aPlacementsStats = MAX_getEntitiesStats('placement', $aParams);
    foreach ($aPlacements as $placementId => $aPlacement) {
        foreach (array('sum_requests', 'sum_views', 'sum_clicks', 'sum_conversions') as $item) {
            $aPlacements[$placementId][$item] = !empty($aPlacementsStats[$placementId][$item]) ? $aPlacementsStats[$placementId][$item] : 0;
        }
    }

    return $aPlacements;
}

function MAX_getCachedPublishersStats($aParams, $allFields=false, $timeout=-1)
{
    $conf = $GLOBALS['_MAX']['CONF'];

    include_once 'Cache/Lite/Function.php';
    $options = array('cacheDir' => MAX_CACHE, 'lifeTime' => ($timeout > -1 ? $timeout : $conf['delivery']['cacheExpire']));
    $cache = new Cache_Lite_Function($options);
    return $cache->call('MAX_getPublishersStats', $aParams, $allFields);
}

function MAX_getPublishersStats($aParams, $allFields=false)
{
    $aPublishers = MAX_getEntitiesChildren('publisher', $aParams);
    $aPublishersStats = MAX_getEntitiesStats('publisher', $aParams);
    foreach ($aPublishers as $publisherId => $aPublisher) {
        foreach (array('sum_requests', 'sum_views', 'sum_clicks', 'sum_conversions') as $item) {
            $aPublishers[$publisherId][$item] = !empty($aPublishersStats[$publisherId][$item]) ? $aPublishersStats[$publisherId][$item] : 0;
        }
    }

    return $aPublishers;
}

function MAX_getCachedZonesStats($aParams, $allFields=false, $timeout=-1)
{
    $conf = $GLOBALS['_MAX']['CONF'];

    include_once 'Cache/Lite/Function.php';
    $options = array('cacheDir' => MAX_CACHE, 'lifeTime' => ($timeout > -1 ? $timeout : $conf['delivery']['cacheExpire']));
    $cache = new Cache_Lite_Function($options);
    return $cache->call('MAX_getZonesStats', $aParams, $allFields);
}

function MAX_getZonesStats($aParams, $allFields=false)
{
    $aZones = MAX_getEntitiesChildren('zone', $aParams);
    $aZonesStats = MAX_getEntitiesStats('zone', $aParams);
    foreach ($aZones as $zoneId => $aZone) {
        foreach (array('sum_requests', 'sum_views', 'sum_clicks', 'sum_conversions') as $item) {
            $aZones[$zoneId][$item] = !empty($aZonesStats[$zoneId][$item]) ? $aZonesStats[$zoneId][$item] : 0;
        }
    }

    return $aZones;
}

function MAX_getCachedAdsStats($aParams, $allFields=false, $timeout=-1)
{
    $conf = $GLOBALS['_MAX']['CONF'];

    include_once 'Cache/Lite/Function.php';
    $options = array('cacheDir' => MAX_CACHE, 'lifeTime' => ($timeout > -1 ? $timeout : $conf['delivery']['cacheExpire']));
    $cache = new Cache_Lite_Function($options);
    return $cache->call('MAX_getAdsStats', $aParams, $allFields);
}

function MAX_getAdsStats($aParams, $allFields=false)
{
    $aAds = MAX_getEntities('ad', $aParams);
    $aAdsStats = MAX_getEntitiesStats('ad', $aParams);
    foreach ($aAds as $adId => $aAd) {
        foreach (array('sum_requests', 'sum_views', 'sum_clicks', 'sum_conversions') as $item) {
            $aAds[$adId][$item] = !empty($aAdsStats[$adId][$item]) ? $aAdsStats[$adId][$item] : 0;
        }
    }

    return $aAds;
}

?>