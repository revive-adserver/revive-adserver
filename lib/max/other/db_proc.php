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

function MAX_addEntity($entity, $aVariables)
{
    $aTable = _getPrimaryTable($entity);
    return _insert($aTable, $aVariables);
}

function MAX_getEntity($entity, $id)
{
    $entityIdName = "{$entity}_id";
    $aParams = array($entityIdName => $id);
    $aRows = MAX_getEntities($entity, $aParams, true, $entityIdName);

    if (!empty($aRows[$id])) {
        $aRow = $aRows[$id];
    } elseif (!($aRows === false)) {
        $aRow = false;
    } else {
        $aRow = array();
    }

    return $aRow;
}

function MAX_getEntities($entity, $aParams, $allFields = false, $key=null)
{
    if (empty($key)) {
        $key = "{$entity}_id";
    }
    $aColumns = _getColumns($entity, $aParams, $allFields);
    $aTables = _getTables($entity, $aParams);
    $aLimitations = array_merge(_getLimitations($entity, $aParams), _getTableLimitations($aTables));
    return _select($aColumns, $aTables, $aLimitations, null, $key);
}

function MAX_setEntity($entity, $id, $aVariables)
{
    $aParams = array("{$entity}_id" => $id);
    return MAX_setEntities($entity, $aParams, $aVariables);
}

function MAX_setEntities($entity, $aParams, $aVariables)
{
    $aTable = _getPrimaryTable($entity);
    $aLimitations = _getLimitations($entity, $aParams);
    _update($aTable, $aVariables, $aLimitations);
}

function MAX_removeEntity($entity, $id)
{
    $aParams = array("{$entity}_id" => $id);
        return MAX_removeEntities($entity, $aParams);
}

function MAX_removeEntities($entity, $aParams)
{
    $aTable = _getPrimaryTable($entity);
    $aOtherTables = _getTables($entity, $aParams);
    $aLimitations = array_merge(_getLimitations($entity, $aParams), _getTableLimitations($aOtherTables));
    return _delete($aTable, $aLimitations, $aOtherTables);
}

function MAX_getCachedEntity($entity, $id, $timeout=-1)
{
    $conf = $GLOBALS['_MAX']['CONF'];
    include_once 'Cache/Lite/Function.php';
    $options = array('cacheDir' => MAX_CACHE, 'lifeTime' => ($timeout > -1 ? $timeout : $conf['delivery']['cacheExpire']));
    $cache = new Cache_Lite_Function($options);
    return $cache->call('MAX_getEntity', $entity, $id);
}

function MAX_getCachedEntities($entity, $aParams, $allFields=false, $key=null, $timeout=-1)
{
    $conf = $GLOBALS['_MAX']['CONF'];

    include_once 'Cache/Lite/Function.php';
    $options = array('cacheDir' => MAX_CACHE, 'lifeTime' => ($timeout > -1 ? $timeout : $conf['delivery']['cacheExpire']));
    $cache = new Cache_Lite_Function($options);
    return $cache->call('MAX_getEntities', $entity, $aParams, $allFields, $key);
}

function MAX_getEntitiesStats($entity, $aParams, $allFields=false, $key=null)
{
    if (empty($key)) {
        $key = "{$entity}_id";
    }
    $aColumns = _getStatsColumns($entity);
    $aTables = _getTables($entity, $aParams, true);
    $aLimitations = array_merge(_getStatsLimitations($entity, $aParams), _getTableLimitations($aTables));
    $aGroups = array("{$entity}_id");
    return _select($aColumns, $aTables, $aLimitations, $aGroups, $key);
}
function MAX_getCachedEntitiesStats($entity, $aParams, $allFields=false, $key=null, $timeout=-1)
{
    $conf = $GLOBALS['_MAX']['CONF'];

    include_once 'Cache/Lite/Function.php';
    $options = array('cacheDir' => MAX_CACHE, 'lifeTime' => ($timeout > -1 ? $timeout : $conf['delivery']['cacheExpire']));
    $cache = new Cache_Lite_Function($options);
    return $cache->call('MAX_getEntitiesStats', $entity, $aParams, $allFields, $key);
}

function MAX_getEntitiesChildren($entity, $aParams, $allFields=false, $key=null)
{
    $conf = $GLOBALS['_MAX']['CONF'];

    if (empty($key)) {
        $key = "{$entity}_id";
    }
    $aColumns = _getColumns($entity, $aParams, $allFields);
    $aTables = _getTables($entity, $aParams);
    switch($entity) {
        case 'agency' : $aTables[$conf['table']['prefix'].$conf['table']['clients']] = 'a';
        $aGroupBy = $aColumns;
        $aColumns['COUNT(a.clientid)'] = 'num_children';
        break;
        case 'advertiser' : $aTables[$conf['table']['prefix'].$conf['table']['campaigns']] = 'm';
        $aGroupBy = $aColumns;
        $aColumns['COUNT(m.campaignid)'] = 'num_children';
        break;
        case 'placement' : $aTables[$conf['table']['prefix'].$conf['table']['banners']] = 'd';
        $aGroupBy = $aColumns;
        $aColumns['COUNT(d.bannerid)'] = 'num_children';
        break;
        case 'publisher' : $aTables[$conf['table']['prefix'].$conf['table']['zones']] = 'z';
        $aGroupBy = $aColumns;
        $aColumns['COUNT(z.zoneid)'] = 'num_children';
        break;
        default :       $aGroupBy = null;
    }
    $aLimitations = array_merge(_getLimitations($entity, $aParams), _getTableLimitations($aTables));
    return _select($aColumns, $aTables, $aLimitations, $aGroupBy, $key);
    /*

    $conf = $GLOBALS['_MAX']['CONF'];

    if (empty($key)) {
    $key = "{$entity}_id";
    }
    $aWhere = array();
    if (!empty($aParams['agency_id'])) $aWhere[] = "agencyid={$aParams['agency_id']}";
    if (!empty($aParams['advertiser_id'])) $aWhere[] = "clientid={$aParams['advertiser_id']}";
    $where = !empty($aWhere) ? ' WHERE ' . implode(' AND ', $aWhere) : '';
    switch ($entity) {
    case 'advertiser' : $query = "SELECT c.agencyid AS agency_id, c.clientid AS advertiser_id, c.clientname AS name, COUNT(m.campaignid) AS num_children FROM {$conf['table']['prefix']}{$conf['table']['clients']} AS c LEFT JOIN {$conf['table']['prefix']}{$conf['table']['campaigns']} AS m ON m.clientid=c.clientid {$where} GROUP BY agency_id, advertiser_id, name"; break;
    case 'placement' : $query = "SELECT m.clientid AS advertiser_id, m.campaignid AS placement_id, m.campaignname AS name, m.active AS active, COUNT(d.bannerid) AS num_children FROM {$conf['table']['prefix']}{$conf['table']['campaigns']} AS m LEFT JOIN {$conf['table']['prefix']}{$conf['table']['banners']} AS d ON d.campaignid=m.campaignid {$where} GROUP BY advertiser_id, placement_id, name"; break;
    }
    $aRows = _query($query, $key);

    return $aRows;
    */
}

function _addZeroStats(&$aRow, $id)
{
    if (empty($aRow['sum_requests'])) $aRow['sum_requests'] = 0;
    if (empty($aRow['sum_views'])) $aRow['sum_views'] = 0;
    if (empty($aRow['sum_clicks'])) $aRow['sum_clicks'] = 0;
    if (empty($aRow['sum_conversions'])) $aRow['sum_conversions'] = 0;
}

function _getPrimaryTable($entity)
{
    $conf = $GLOBALS['_MAX']['CONF'];

    $aTable = '';
    switch ($entity) {
        case 'ad' : $aTable = array($conf['table']['prefix'].$conf['table']['banners'] => 'd'); break;
        case 'advertiser' : $aTable = array($conf['table']['prefix'].$conf['table']['clients'] => 'a'); break;
        case 'ad_category_assoc' : $aTable = array($conf['table']['prefix'].$conf['table']['ad_category_assoc'] => 'ac'); break;
        case 'ad_zone_assoc' : $aTable = array($conf['table']['prefix'].$conf['table']['ad_zone_assoc'] => 'az'); break;
        case 'agency' : $aTable = array($conf['table']['prefix'].$conf['table']['agency'] => 'g'); break;
        case 'category' : $aTable = array($conf['table']['prefix'].$conf['table']['category'] => 'cat'); break;
        case 'image' : $aTable = array($conf['table']['prefix'].$conf['table']['images'] => 'i'); break;
        case 'limitation' : $aTable = array($conf['table']['prefix'].$conf['table']['acls'] => 'l'); break;
        case 'placement' : $aTable = array($conf['table']['prefix'].$conf['table']['campaigns'] => 'm'); break;
        case 'placement_tracker' : $aTable = array($conf['table']['prefix'].$conf['table']['campaigns_trackers'] => 'mt'); break;
        case 'placement_zone_assoc' : $aTable = array($conf['table']['prefix'].$conf['table']['placement_zone_assoc'] => 'pz'); break;
        case 'publisher' : $aTable = array($conf['table']['prefix'].$conf['table']['affiliates'] => 'p'); break;
        case 'stats' : $aTable = array($conf['table']['prefix'].$conf['table']['data_summary_ad_hourly'] => 's'); break;
        case 'tracker' : $aTable = array($conf['table']['prefix'].$conf['table']['trackers'] => 't'); break;
        case 'variable' : $aTable = array($conf['table']['prefix'].$conf['table']['variables'] => 'v'); break;
        case 'zone' : $aTable = array($conf['table']['prefix'].$conf['table']['zones'] => 'z'); break;
    }
    return $aTable;
}

function _getColumns($entity, $aParams, $allFields)
{
    $aColumns = array();
    switch ($entity) {
        case 'ad' :
        $aColumns += array('d.bannerid' => 'ad_id', 'd.campaignid' => 'placement_id', 'd.active' => 'active', 'd.description' => 'name', 'd.storagetype' => 'type');
        if ($allFields) $aColumns += array('d.contenttype' => 'contenttype', 'd.pluginversion' => 'pluginversion', 'd.filename' => 'filename', 'd.imageurl' => 'imageurl', 'd.htmltemplate' => 'htmltemplate', 'd.htmlcache' => 'htmlcache', 'd.width' => 'width', 'd.height' => 'height', 'd.weight' => 'weight', 'd.seq' => 'seq', 'd.target' => 'target', 'd.url' => 'url', 'd.alt' => 'alt', 'd.status' => 'status', 'd.bannertext' => 'bannertext', 'd.autohtml' => 'autohtml', 'd.adserver' => 'adserver', 'd.block' => 'block', 'd.capping' => 'capping', 'd.session_capping' => 'session_capping', 'd.compiledlimitation' => 'compiledlimitation', 'd.append' => 'append', 'd.appendtype' => 'appendtype', 'd.bannertype' => 'bannertype', 'd.alt_filename' => 'alt_filename', 'd.alt_imageurl' => 'alt_imageurl', 'd.alt_contenttype' => 'alt_contenttype');
        break;
        case 'advertiser' :
        $aColumns += array('a.clientid' => 'advertiser_id', 'a.agencyid' => 'agency_id', 'a.clientname' => 'name');
        if ($allFields) $aColumns += array('a.contact' => 'contact', 'a.email' => 'email', 'a.clientusername' => 'username', 'a.clientpassword' => 'password', 'a.permissions' => 'permissions', 'a.language' => 'language', 'a.report' => 'report', 'a.reportinterval' => 'report_interval', 'a.reportlastdate' => 'report_last_date', 'a.reportdeactivate' => 'report_deactivate');
        break;
        case 'ad_category_assoc' :
        $aColumns += array('ac.ad_category_assoc_id' => 'ad_category_assoc_id', 'ac.ad_id' => 'ad_id', 'ac.category_id' => 'category_id');
        break;
        case 'ad_zone_assoc' :
        $aColumns += array('az.ad_zone_assoc_id' => 'ad_zone_assoc_id', 'az.ad_id' => 'ad_id', 'az.zone_id' => 'zone_id', 'az.priority' => 'priority');
        break;
        case 'agency' :
        $aColumns += array('g.agencyid' => 'agency_id', 'g.name' => 'name');
        if ($allFields) $aColumns += array('g.contact' => 'contact', 'g.email' => 'email', 'g.username' => 'username', 'g.password' => 'password', 'g.permissions' => 'permissions', 'g.language' => 'language');
        break;
        case 'category' :
        $aColumns += array('cat.category_id' => 'category_id', 'cat.name' => 'name');
        break;
        case 'image' :
        $aColumns += array('i.filename' => 'file_name');
        if ($allFields) $aColumns += array('i.t_stamp' => 't_stamp', 'i.contents' => 'contents');
        break;
        case 'limitation' :
        $aColumns += array('l.bannerid' => 'ad_id', 'l.logical' => 'logical', 'l.type' => 'type', 'l.comparison' => 'comparison', 'l.data' => 'data', 'l.executionorder' => 'executionorder');
        break;
        case 'placement' :
        $aColumns += array('m.clientid' => 'advertiser_id', 'm.campaignid' => 'placement_id', 'm.campaignname' => 'name', 'm.active' => 'active');
        if ($allFields) $aColumns += array('m.views' => 'views', 'm.clicks' => 'clicks', 'm.conversions' => 'conversions', 'm.expire' => 'expire', 'm.activate' => 'activate', 'm.priority' => 'priority', 'm.weight' => 'weight', 'm.target' => 'target', 'm.anonymous' => 'anonymous');
        break;
        case 'placement_tracker' :
        $aColumns += array('mt.campaign_trackerid' => 'placement_tracker_id', 'mt.campaignid' => 'placement_id', 'mt.trackerid' => 'tracker_id');
        if ($allFields) $aColumns += array('mt.status' => 'status', 'mt.viewwindow' => 'view_window', 'mt.clickwindow' => 'click_window');
        break;
        case 'publisher' :
        $aColumns += array('p.affiliateid' => 'publisher_id', 'p.agencyid' => 'agency_id', 'p.name' => 'name');
        if ($allFields) $aColumns += array('p.mnemonic' => 'mnemonic', 'p.contact' => 'contact', 'p.email' => 'email', 'p.website' => 'website', 'p.username' => 'username', 'p.password' => 'password', 'p.permissions' => 'permissions', 'p.language' => 'language', 'p.publiczones' => 'publiczones');
        break;
        case 'stats' :
        $aColumns += array('s.day' => 'day', 's.hour' => 'hour', 'SUM(s.requests)' => 'sum_requests', 'SUM(s.impressions)' => 'sum_views', 'SUM(s.clicks)' => 'sum_clicks', 'SUM(s.conversions)' => 'sum_conversions');
        break;
        case 'tracker' :
        $aColumns += array('t.clientid' => 'advertiser_id', 't.trackerid' => 'tracker_id', 't.trackername' => 'name', 't.variablemethod' => 'variablemethod');
        if ($allFields) $aColumns += array('t.description' => 'description', 't.viewwindow' => 'viewwindow', 't.clickwindow' => 'clickwindow', 't.blockwindow' => 'blockwindow', 't.appendcode' => 'appendcode');
        break;
        case 'variable' :
        $aColumns += array('v.variableid' => 'variable_id', 'v.trackerid' => 'tracker_id', 'v.name' => 'name', 'v.datatype' => 'type', 'v.variablecode' => 'variablecode');
        if ($allFields) $aColumns += array('v.description' => 'description', 'v.purpose' => 'purpose');
        break;
        case 'zone' :
        $aColumns += array('z.zoneid' => 'zone_id', 'z.affiliateid' => 'publisher_id', 'z.zonename' => 'name', 'z.delivery' => 'type');
        if ($allFields) $aColumns += array('z.description' => 'description', 'z.width' => 'width', 'z.height' => 'height', 'z.chain' => 'chain', 'z.prepend' => 'prepend', 'z.append' => 'append', 'z.appendtype' => 'appendtype', 'z.forceappend' => 'forceappend', 'z.inventory_forecast_type' => 'inventory_forecast_type');
        break;
        case 'placement_zone_assoc' :
        $aColumns += array('pz.placement_zone_assoc_id' => 'placement_zone_assoc_id', 'pz.placement_id' => 'placement_id', 'pz.zone_id' => 'zone_id');
        break;
    }
    return $aColumns;
}

function _getStatsColumns($entity)
{
    $aColumns = array('SUM(s.requests)' => 'sum_requests', 'SUM(s.impressions)' => 'sum_views', 'SUM(s.clicks)' => 'sum_clicks', 'SUM(s.conversions)' => 'sum_conversions');
    switch ($entity) {
        case 'ad' : $aColumns += array('d.bannerid' => 'ad_id'); break;
        case 'advertiser' : $aColumns += array('a.clientid' => 'advertiser_id'); break;
        case 'agency' : $aColumns += array('g.agencyid' => 'agency_id'); break;
        case 'placement' : $aColumns += array('m.campaignid' => 'placement_id'); break;
        case 'publisher' : $aColumns += array('p.affiliateid' => 'publisher_id'); break;
        case 'zone' : $aColumns += array('z.zoneid' => 'zone_id'); break;
    }

    return $aColumns;
}

function _getTables($entity, $aParams, $includeStats = false)
{
    $conf = $GLOBALS['_MAX']['CONF'];

    $aTables = array();
    switch ($entity) {
        case 'ad' :
        $aTables += array($conf['table']['prefix'].$conf['table']['banners'] => 'd');
        if (!empty($aParams['agency_id'])) $aTables += array($conf['table']['prefix'].$conf['table']['clients'] => 'a', $conf['table']['prefix'].$conf['table']['campaigns'] => 'm');
        if (!empty($aParams['advertiser_id'])) $aTables += array($conf['table']['prefix'].$conf['table']['campaigns'] => 'm');
        if ($includeStats) $aTables += array($conf['table']['prefix'].$conf['table']['data_summary_ad_hourly'] => 's');
        break;
        case 'advertiser' :
        $aTables += array($conf['table']['prefix'].$conf['table']['clients'] => 'a');
        if (!empty($aParams['placement_id'])) $aTables += array($conf['table']['prefix'].$conf['table']['campaigns'] => 'm');
        if (!empty($aParams['placement_active'])) $aTables += array($conf['table']['prefix'].$conf['table']['campaigns'] => 'm');
        if (!empty($aParams['ad_id'])) $aTables += array($conf['table']['prefix'].$conf['table']['campaigns'] => 'm', $conf['table']['prefix'].$conf['table']['banners'] => 'd');
        if (!empty($aParams['ad_active'])) $aTables += array($conf['table']['prefix'].$conf['table']['campaigns'] => 'm', $conf['table']['prefix'].$conf['table']['banners'] => 'd');
        if (!empty($aParams['ad_width'])) $aTables += array($conf['table']['prefix'].$conf['table']['campaigns'] => 'm', $conf['table']['prefix'].$conf['table']['banners'] => 'd');
        if (!empty($aParams['ad_height'])) $aTables += array($conf['table']['prefix'].$conf['table']['campaigns'] => 'm', $conf['table']['prefix'].$conf['table']['banners'] => 'd');
        if (!empty($aParams['ad_type'])) $aTables += array($conf['table']['prefix'].$conf['table']['campaigns'] => 'm', $conf['table']['prefix'].$conf['table']['banners'] => 'd');
        if ($includeStats) $aTables += array($conf['table']['prefix'].$conf['table']['data_summary_ad_hourly'] => 's', $conf['table']['prefix'].$conf['table']['banners'] => 'd', $conf['table']['prefix'].$conf['table']['campaigns'] => 'm');
        break;
        case 'ad_category_assoc' :
        $aTables += array($conf['table']['prefix'].$conf['table']['ad_category_assoc'] => 'ac');
        if (!empty($aParams['agency_id'])) $aTables += array($conf['table']['prefix'].$conf['table']['banners'] => 'd', $conf['table']['campaigns'] => 'm', $conf['table']['prefix'].$conf['table']['clients'] = 'a');
        if (!empty($aParams['advertiser_id'])) $aTables += array($conf['table']['prefix'].$conf['table']['banners'] => 'd', $conf['table']['prefix'].$conf['table']['campaigns'] => 'm');
        if (!empty($aParams['placement_id'])) $aTables += array($conf['table']['prefix'].$conf['table']['banners'] => 'd');
        if (!empty($aParams['placement_active'])) $aTables += array($conf['table']['prefix'].$conf['table']['banners'] => 'd', $conf['table']['prefix'].$conf['table']['campaigns'] => 'm');
        if (!empty($aParams['ad_width'])) $aTables += array($conf['table']['prefix'].$conf['table']['banners'] => 'd');
        if (!empty($aParams['ad_height'])) $aTables += array($conf['table']['prefix'].$conf['table']['banners'] => 'd');
        if (!empty($aParams['ad_type'])) $aTables += array($conf['table']['prefix'].$conf['table']['banners'] => 'd');
        if (!empty($aParams['ad_active'])) $aTables += array($conf['table']['prefix'].$conf['table']['banners'] => 'd');
        break;
        case 'ad_zone_assoc' :
        $aTables += array($conf['table']['prefix'].$conf['table']['ad_zone_assoc'] => 'az');
        if (!empty($aParams['agency_id'])) $aTables += array($conf['table']['prefix'].$conf['table']['zones'] => 'z', $conf['table']['prefix'].$conf['table']['banners'] => 'd', $conf['table']['prefix'].$conf['table']['campaigns'] => 'm', $conf['table']['prefix'].$conf['table']['clients'] = 'a', $conf['table']['prefix'].$conf['table']['affiliates'] => 'p');
        if (!empty($aParams['publisher_id'])) $aTables += array($conf['table']['prefix'].$conf['table']['zones'] => 'z');
        if (!empty($aParams['advertiser_id'])) $aTables += array($conf['table']['prefix'].$conf['table']['banners'] => 'd', $conf['table']['prefix'].$conf['table']['campaigns'] => 'm');
        if (!empty($aParams['placement_id'])) $aTables += array($conf['table']['prefix'].$conf['table']['banners'] => 'd');
        if (!empty($aParams['placement_active'])) $aTables += array($conf['table']['prefix'].$conf['table']['banners'] => 'd', $conf['table']['prefix'].$conf['table']['campaigns'] => 'm');
        if (!empty($aParams['ad_width'])) $aTables += array($conf['table']['prefix'].$conf['table']['banners'] => 'd');
        if (!empty($aParams['ad_height'])) $aTables += array($conf['table']['prefix'].$conf['table']['banners'] => 'd');
        if (!empty($aParams['ad_type'])) $aTables += array($conf['table']['prefix'].$conf['table']['banners'] => 'd');
        if (!empty($aParams['ad_active'])) $aTables += array($conf['table']['prefix'].$conf['table']['banners'] => 'd');
        break;
        case 'agency' :
        $aTables += array($conf['table']['prefix'].$conf['table']['agency'] => 'g');
        if (!empty($aParams['advertiser_id'])) $aTables += array($conf['table']['prefix'].$conf['table']['clients'] => 'a');
        if (!empty($aParams['placement_id'])) $aTables += array($conf['table']['prefix'].$conf['table']['clients'] => 'a', $conf['table']['prefix'].$conf['table']['campaigns'] => 'm');
        if (!empty($aParams['ad_id'])) $aTables += array($conf['table']['prefix'].$conf['table']['clients'] => 'a', $conf['table']['prefix'].$conf['table']['campaigns'] => 'm', $conf['table']['prefix'].$conf['table']['banners'] => 'd');
        if (!empty($aParams['ad_width'])) $aTables += array($conf['table']['prefix'].$conf['table']['clients'] => 'a', $conf['table']['prefix'].$conf['table']['campaigns'] => 'm', $conf['table']['prefix'].$conf['table']['banners'] => 'd');
        if (!empty($aParams['ad_height'])) $aTables += array($conf['table']['prefix'].$conf['table']['clients'] => 'a', $conf['table']['prefix'].$conf['table']['campaigns'] => 'm', $conf['table']['prefix'].$conf['table']['banners'] => 'd');
        if (!empty($aParams['ad_type'])) $aTables += array($conf['table']['prefix'].$conf['table']['clients'] => 'a', $conf['table']['prefix'].$conf['table']['campaigns'] => 'm', $conf['table']['prefix'].$conf['table']['banners'] => 'd');
        if (!empty($aParams['publisher_id'])) $aTables += array($conf['table']['prefix'].$conf['table']['affiliates'] => 'p');
        if (!empty($aParams['zone_id'])) $aTables += array($conf['table']['prefix'].$conf['table']['affiliates'] => 'p', $conf['table']['prefix'].$conf['table']['zones'] => 'z');
        if ($includeStats) $aTables += array($conf['table']['prefix'].$conf['table']['data_summary_ad_hourly'] => 's', $conf['table']['prefix'].$conf['table']['banners'] => 'd', $conf['table']['prefix'].$conf['table']['campaigns'] => 'm', $conf['table']['prefix'].$conf['table']['clients'] => 'a', $conf['table']['prefix'].$conf['table']['affiliates'] => 'p', $conf['table']['prefix'].$conf['table']['zones'] => 'z');
        break;
        case 'category' :
        $aTables += array($conf['table']['prefix'].$conf['table']['category'] => 'cat');
        break;
        case 'image' :
        $aTables += array($conf['table']['prefix'].$conf['table']['images'] => 'i');
        break;
        case 'limitation' :
        $aTables += array($conf['table']['prefix'].$conf['table']['acls'] => 'l');
        if (!empty($aParams['agency_id'])) $aTables += array($conf['table']['prefix'].$conf['table']['banners'] => 'd', $conf['table']['prefix'].$conf['table']['campaigns'] => 'm', $conf['table']['prefix'].$conf['table']['clients'] = 'a');
        if (!empty($aParams['advertiser_id'])) $aTables += array($conf['table']['prefix'].$conf['table']['banners'] => 'd', $conf['table']['prefix'].$conf['table']['campaigns'] => 'm');
        if (!empty($aParams['placement_id'])) $aTables += array($conf['table']['prefix'].$conf['table']['banners'] => 'd');
        break;
        case 'placement' :
        $aTables += array($conf['table']['prefix'].$conf['table']['campaigns'] => 'm');
        if (!empty($aParams['agency_id'])) $aTables += array($conf['table']['prefix'].$conf['table']['clients'] => 'a');
        if (!empty($aParams['ad_id'])) $aTables += array($conf['table']['prefix'].$conf['table']['banners'] => 'd');
        if (!empty($aParams['ad_active'])) $aTables += array($conf['table']['prefix'].$conf['table']['banners'] => 'd');
        if (!empty($aParams['ad_width'])) $aTables += array($conf['table']['prefix'].$conf['table']['banners'] => 'd');
        if (!empty($aParams['ad_height'])) $aTables += array($conf['table']['prefix'].$conf['table']['banners'] => 'd');
        if (!empty($aParams['ad_type'])) $aTables += array($conf['table']['prefix'].$conf['table']['banners'] => 'd');
        if ($includeStats) $aTables += array($conf['table']['prefix'].$conf['table']['data_summary_ad_hourly'] => 's', $conf['table']['prefix'].$conf['table']['banners'] => 'd');
        break;
        case 'placement_tracker' :
        $aTables += array($conf['table']['prefix'].$conf['table']['campaigns_trackers'] => 'mt');
        if (!empty($aParams['agency_id'])) $aTables += array($conf['table']['prefix'].$conf['table']['campaigns'] => 'm', $conf['table']['prefix'].$conf['table']['clients'] => 'a', $conf['table']['prefix'].$conf['table']['trackers'] => 't');
        if (!empty($aParams['advertiser_id'])) $aTables += array($conf['table']['prefix'].$conf['table']['campaigns'] => 'm', $conf['table']['prefix'].$conf['table']['trackers'] => 't');
        break;
        case 'placement_zone_assoc' :
        $aTables += array($conf['table']['prefix'].$conf['table']['placement_zone_assoc'] => 'pz');
        if (!empty($aParams['agency_id'])) $aTables += array($conf['table']['prefix'].$conf['table']['zones'] => 'z', $conf['table']['prefix'].$conf['table']['campaigns'] => 'm', $conf['table']['prefix'].$conf['table']['clients'] => 'a', $conf['table']['prefix'].$conf['table']['affiliates'] => 'p');
        if (!empty($aParams['publisher_id'])) $aTables += array($conf['table']['prefix'].$conf['table']['zones'] => 'z');
        if (!empty($aParams['advertiser_id'])) $aTables += array($conf['table']['prefix'].$conf['table']['campaigns'] => 'm');
        if (!empty($aParams['ad_id'])) $aTables += array($conf['table']['prefix'].$conf['table']['banners'] => 'd');
        break;
        case 'publisher' :
        $aTables += array($conf['table']['prefix'].$conf['table']['affiliates'] => 'p');
        if (!empty($aParams['zone_id'])) $aTables += array($conf['table']['prefix'].$conf['table']['zones'] => 'z');
        if ($includeStats) {
            $aTables += array($conf['table']['prefix'].$conf['table']['data_summary_ad_hourly'] => 's', $conf['table']['prefix'].$conf['table']['zones'] => 'z');
            if (!empty($aParams['placement_id'])) $aTables += array($conf['table']['prefix'].$conf['table']['banners'] => 'd');
        }
        break;
        case 'stats' :
        $aTables += array($conf['table']['prefix'].$conf['table']['data_summary_ad_hourly'] => 's');
        if (!empty($aParams['agency_id'])) $aTables += array($conf['table']['prefix'].$conf['table']['clients'] => 'a', $conf['table']['prefix'].$conf['table']['campaigns'] => 'm', $conf['table']['prefix'].$conf['table']['banners'] => 'd', $conf['table']['prefix'].$conf['table']['affiliates'] => 'p', $conf['table']['prefix'].$conf['table']['zones'] => 'z');
        if (!empty($aParams['advertiser_id'])) $aTables += array($conf['table']['prefix'].$conf['table']['campaigns'] => 'm', $conf['table']['prefix'].$conf['table']['banners'] => 'd');
        if (!empty($aParams['placement_id'])) $aTables += array($conf['table']['prefix'].$conf['table']['banners'] => 'd');
        if (!empty($aParams['publisher_id'])) $aTables += array($conf['table']['prefix'].$conf['table']['zones'] => 'z');
        break;
        case 'tracker' :
        $aTables += array($conf['table']['prefix'].$conf['table']['trackers'] => 't');
        if (!empty($aParams['agency_id'])) $aTables += array($conf['table']['prefix'].$conf['table']['clients'] => 'a');
        break;
        case 'variable' :
        $aTables += array($conf['table']['prefix'].$conf['table']['variables'] => 'v');
        if (!empty($aParams['agency_id'])) $aTables += array($conf['table']['prefix'].$conf['table']['clients'] => 'a', $conf['table']['prefix'].$conf['table']['trackers'] => 't');
        if (!empty($aParams['advertiser_id'])) $aTables += array($conf['table']['prefix'].$conf['table']['trackers'] => 't');
        break;
        case 'zone' :
        $aTables += array($conf['table']['prefix'].$conf['table']['zones'] => 'z');
        if (!empty($aParams['agency_id'])) $aTables += array($conf['table']['prefix'].$conf['table']['affiliates'] => 'p');
        if ($includeStats) $aTables += array($conf['table']['prefix'].$conf['table']['data_summary_ad_hourly'] => 's');
        if ($includeStats) {
            $aTables += array($conf['table']['prefix'].$conf['table']['data_summary_ad_hourly'] => 's');
            if (!empty($aParams['placement_id'])) $aTables += array($conf['table']['prefix'].$conf['table']['banners'] => 'd');
        }
        break;
    }
    return $aTables;
}

function _getLimitations($entity, $aParams)
{
    $aLimitations = array();

    if (!empty($aParams['ad_width'])) _addLimitation($aLimitations, 'ad_width', 'd.width', $aParams['ad_width']);
    if (!empty($aParams['ad_height'])) _addLimitation($aLimitations, 'ad_height', 'd.height', $aParams['ad_height']);
    if (!empty($aParams['ad_type'])) _addLimitation($aLimitations, 'ad_type', 'd.storagetype', $aParams['ad_type']);
    if (!empty($aParams['ad_active'])) _addLimitation($aLimitations, 'ad_active', 'd.active', $aParams['ad_active']);
    if (!empty($aParams['placement_active'])) _addLimitation($aLimitations, 'placement_active', 'm.active', $aParams['placement_active']);

    switch ($entity) {
        case 'ad' :
        if (!empty($aParams['agency_id'])) _addLimitation($aLimitations, 'agency_id', 'a.agencyid', $aParams['agency_id']);
        if (!empty($aParams['advertiser_id'])) _addLimitation($aLimitations, 'advertiser_id', 'm.clientid', $aParams['advertiser_id']);
        if (!empty($aParams['placement_id'])) _addLimitation($aLimitations, 'placement_id', 'd.campaignid', $aParams['placement_id']);
        if (!empty($aParams['ad_id'])) _addLimitation($aLimitations, 'ad_id', 'd.bannerid', $aParams['ad_id']);
        break;
        case 'advertiser' :
        if (!empty($aParams['agency_id'])) _addLimitation($aLimitations, 'agency_id', 'a.agencyid', $aParams['agency_id']);
        if (!empty($aParams['advertiser_id'])) _addLimitation($aLimitations, 'advertiser_id', 'a.clientid', $aParams['advertiser_id']);
        if (!empty($aParams['placement_id'])) _addLimitation($aLimitations, 'placement_id', 'm.campaignid', $aParams['placement_id']);
        if (!empty($aParams['ad_id'])) _addLimitation($aLimitations, 'ad_id', 'd.bannerid', $aParams['ad_id']);
        break;
        case 'ad_category_assoc' :
        if (!empty($aParams['agency_id'])) _addLimitation($aLimitations, 'agency_id', 'c.agencyid', $aParams['agency_id']);
        if (!empty($aParams['advertiser_id'])) _addLimitation($aLimitations, 'advertiser_id', 'm.clientid', $aParams['advertiser_id']);
        if (!empty($aParams['placement_id'])) _addLimitation($aLimitations, 'placement_id', 'd.campaignid', $aParams['placement_id']);
        if (!empty($aParams['ad_id'])) _addLimitation($aLimitations, 'ad_id', 'ac.ad_id', $aParams['ad_id']);
        if (!empty($aParams['ad_category_assoc_id'])) _addLimitation($aLimitations, 'ad_category_assoc_id', 'ac.ad_category_assoc_id', $aParams['ad_category_assoc_id']);
        break;
        case 'ad_zone_assoc' :
        if (!empty($aParams['agency_id'])) {
            _addLimitation($aLimitations, 'agency_id', 'p.agencyid', $aParams['agency_id']);
            _addLimitation($aLimitations, 'agency_id', 'c.agencyid', $aParams['agency_id']);
        }
        if (!empty($aParams['publisher_id'])) _addLimitation($aLimitations, 'publisher_id', 'z.affiliateid', $aParams['publisher_id']);
        if (!empty($aParams['advertiser_id'])) _addLimitation($aLimitations, 'advertiser_id', 'm.clientid', $aParams['advertiser_id']);
        if (!empty($aParams['zone_id'])) _addLimitation($aLimitations, 'zone_id', 'az.zone_id', $aParams['zone_id']);
        if (!empty($aParams['placement_id'])) _addLimitation($aLimitations, 'placement_id', 'd.campaignid', $aParams['placement_id']);
        if (!empty($aParams['ad_id'])) _addLimitation($aLimitations, 'ad_id', 'az.ad_id', $aParams['ad_id']);
        if (!empty($aParams['ad_zone_assoc_id'])) _addLimitation($aLimitations, 'ad_zone_assoc_id', 'az.ad_zone_assoc_id', $aParams['ad_zone_assoc_id']);
        break;
        case 'agency' :
        if (!empty($aParams['agency_id'])) _addLimitation($aLimitations, 'agency_id', 'g.agencyid', $aParams['agency_id']);
        if (!empty($aParams['advertiser_id'])) _addLimitation($aLimitations, 'advertiser_id', 'a.clientid', $aParams['advertiser_id']);
        if (!empty($aParams['placement_id'])) _addLimitation($aLimitations, 'placement_id', 'm.campaignid', $aParams['placement_id']);
        if (!empty($aParams['ad_id'])) _addLimitation($aLimitations, 'ad_id', 'd.bannerid', $aParams['ad_id']);
        if (!empty($aParams['publisher_id'])) _addLimitation($aLimitations, 'publisher_id', 'p.affiliateid', $aParams['publisher_id']);
        if (!empty($aParams['zone_id'])) _addLimitation($aLimitations, 'zone_id', 'z.zoneid', $aParams['zone_id']);
        break;
        case 'category' :
        if (!empty($aParams['name'])) _addLimitation($aLimitations, 'name', 'cat.name', $aParams['name']);
        break;
        case 'image' :
        if (!empty($aParams['file_name'])) _addLimitation($aLimitations, 'file_name', 'i.filename', $aParams['file_name']);
        break;
        case 'limitation' :
        if (!empty($aParams['agency_id'])) _addLimitation($aLimitations, 'agency_id', 'c.agencyid', $aParams['agency_id']);
        if (!empty($aParams['advertiser_id'])) _addLimitation($aLimitations, 'advertiser_id', 'm.clientid', $aParams['advertiser_id']);
        if (!empty($aParams['placement_id'])) _addLimitation($aLimitations, 'placement_id', 'd.campaignid', $aParams['placement_id']);
        if (!empty($aParams['ad_id'])) _addLimitation($aLimitations, 'ad_id', 'l.bannerid', $aParams['ad_id']);
        break;
        case 'placement' :
        if (!empty($aParams['agency_id'])) _addLimitation($aLimitations, 'agency_id', 'a.agencyid', $aParams['agency_id']);
        if (!empty($aParams['advertiser_id'])) _addLimitation($aLimitations, 'advertiser_id', 'm.clientid', $aParams['advertiser_id']);
        if (!empty($aParams['placement_id'])) _addLimitation($aLimitations, 'placement_id', 'm.campaignid', $aParams['placement_id']);
        if (!empty($aParams['ad_id'])) _addLimitation($aLimitations, 'ad_id', 'd.bannerid', $aParams['ad_id']);
        break;
        case 'placement_tracker' :
        if (!empty($aParams['agency_id'])) _addLimitation($aLimitations, 'agency_id', 'c.agencyid', $aParams['agency_id']);
        if (!empty($aParams['advertiser_id'])) {
            _addLimitation($aLimitations, 'advertiser_id', 'm.clientid', $aParams['advertiser_id']);
            _addLimitation($aLimitations, 'advertiser_id', 't.clientid', $aParams['advertiser_id']);
        }
        if (!empty($aParams['tracker_id'])) _addLimitation($aLimitations, 'tracker_id', 'mt.trackerid', $aParams['tracker_id']);
        if (!empty($aParams['placement_id'])) _addLimitation($aLimitations, 'placement_id', 'mt.campaignid', $aParams['placement_id']);
        break;
        case 'placement_zone_assoc' :
        if (!empty($aParams['agency_id'])) {
            _addLimitation($aLimitations, 'agency_id', 'p.agencyid', $aParams['agency_id']);
            _addLimitation($aLimitations, 'agency_id', 'c.agencyid', $aParams['agency_id']);
        }
        if (!empty($aParams['publisher_id'])) _addLimitation($aLimitations, 'publisher_id', 'z.affiliateid', $aParams['publisher_id']);
        if (!empty($aParams['advertiser_id'])) _addLimitation($aLimitations, 'advertiser_id', 'm.clientid', $aParams['advertiser_id']);
        if (!empty($aParams['zone_id'])) _addLimitation($aLimitations, 'zone_id', 'pz.zone_id', $aParams['zone_id']);
        if (!empty($aParams['placement_id'])) _addLimitation($aLimitations, 'placement_id', 'pz.placement_id', $aParams['placement_id']);
        if (!empty($aParams['ad_id'])) _addLimitation($aLimitations, 'ad_id', 'd.bannerid', $aParams['ad_id']);
        if (!empty($aParams['placement_zone_assoc_id'])) _addLimitation($aLimitations, 'placement_zone_assoc_id', 'pz.placement_zone_assoc_id', $aParams['placement_zone_assoc_id']);
        break;
        case 'publisher' :
        if (!empty($aParams['agency_id'])) _addLimitation($aLimitations, 'agency_id', 'p.agencyid', $aParams['agency_id']);
        if (!empty($aParams['publisher_id'])) _addLimitation($aLimitations, 'publisher_id', 'p.affiliateid', $aParams['publisher_id']);
        if (!empty($aParams['zone_id'])) _addLimitation($aLimitations, 'zone_id', 'z.zoneid', $aParams['zone_id']);
        break;
        case 'stats' :
        if (!empty($aParams['agency_id'])) {
            _addLimitation($aLimitations, 'agency_id', 'p.agencyid', $aParams['agency_id']);
            _addLimitation($aLimitations, 'agency_id', 'c.agencyid', $aParams['agency_id']);
        }
        if (!empty($aParams['publisher_id'])) _addLimitation($aLimitations, 'publisher_id', 'z.affiliateid', $aParams['publisher_id']);
        if (!empty($aParams['advertiser_id'])) _addLimitation($aLimitations, 'advertiser_id', 'm.clientid', $aParams['advertiser_id']);
        if (!empty($aParams['zone_id'])) _addLimitation($aLimitations, 'zone_id', 's.zone_id', $aParams['zone_id']);
        if (!empty($aParams['placement_id'])) _addLimitation($aLimitations, 'placement_id', 'd.campaignid', $aParams['placement_id']);
        if (!empty($aParams['ad_id'])) _addLimitation($aLimitations, 'ad_id', 's.ad_id', $aParams['ad_id']);
        if (!empty($aParams['day_begin'])) $aLimitations[]="s.day>='{$aParams['day_begin']}'";
        if (!empty($aParams['day_end'])) $aLimitations[]="s.day<='{$aParams['day_end']}'";
        break;
        case 'tracker' :
        if (!empty($aParams['agency_id'])) _addLimitation($aLimitations, 'agency_id', 'a.agencyid', $aParams['agency_id']);
        if (!empty($aParams['advertiser_id'])) _addLimitation($aLimitations, 'advertiser_id', 't.clientid', $aParams['advertiser_id']);
        if (!empty($aParams['tracker_id'])) _addLimitation($aLimitations, 'tracker_id', 't.trackerid', $aParams['tracker_id']);
        break;
        case 'variable' :
        if (!empty($aParams['agency_id'])) _addLimitation($aLimitations, 'agency_id', 'a.agencyid', $aParams['agency_id']);
        if (!empty($aParams['advertiser_id'])) _addLimitation($aLimitations, 'advertiser_id', 't.clientid', $aParams['advertiser_id']);
        if (!empty($aParams['tracker_id'])) _addLimitation($aLimitations, 'tracker_id', 'v.trackerid', $aParams['tracker_id']);
        if (!empty($aParams['variable_id'])) _addLimitation($aLimitations, 'variable_id', 'v.variableid', $aParams['variable_id']);
        break;
        case 'zone' :
        if (!empty($aParams['agency_id'])) _addLimitation($aLimitations, 'agency_id', 'p.agencyid', $aParams['agency_id']);
        if (!empty($aParams['publisher_id'])) _addLimitation($aLimitations, 'publisher_id', 'z.affiliateid', $aParams['publisher_id']);
        if (!empty($aParams['zone_id'])) _addLimitation($aLimitations, 'zone_id', 'z.zoneid', $aParams['zone_id']);
        if (!empty($aParams['zone_type'])) _addLimitation($aLimitations, 'zone_type', 'z.delivery', $aParams['zone_type']);
        if (!empty($aParams['zone_width'])) _addLimitation($aLimitations, 'zone_width', 'z.width', $aParams['zone_width']);
        if (!empty($aParams['zone_height'])) _addLimitation($aLimitations, 'zone_height', 'z.height', $aParams['zone_height']);
        break;
    }
    return $aLimitations;
}

function _getStatsLimitations($entity, $aParams)
{
    $aLimitations = array();

    if (!empty($aParams['agency_id'])) {
        switch ($entity) {
            case 'advertiser' :
            case 'placement' :
            case 'ad' :
            $aLimitations[] = "a.agencyid={$aParams['agency_id']}";
            break;
            case 'publisher' :
            case 'zone' :
            $aLimitations[] = "p.agencyid={$aParams['agency_id']}";
            break;
            default :
            $aLimitations[] = "p.agencyid={$aParams['agency_id']}";
            $aLimitations[] = "a.agencyid={$aParams['agency_id']}";
        }
    }

    if (!empty($aParams['publisher_id'])) _addLimitation($aLimitations, 'publisher_id', 'z.affiliateid', $aParams['publisher_id']);
    if (!empty($aParams['advertiser_id'])) _addLimitation($aLimitations, 'advertiser_id', 'm.clientid', $aParams['advertiser_id']);
    if (!empty($aParams['zone_id'])) _addLimitation($aLimitations, 'zone_id', 's.zone_id', $aParams['zone_id']);
    if (!empty($aParams['placement_id'])) _addLimitation($aLimitations, 'placement_id', 'd.campaignid', $aParams['placement_id']);
    if (!empty($aParams['ad_id'])) _addLimitation($aLimitations, 'ad_id', 's.ad_id', $aParams['ad_id']);
    if (!empty($aParams['day_begin'])) $aLimitations[]="s.day>='{$aParams['day_begin']}'";
    if (!empty($aParams['day_end'])) $aLimitations[]="s.day<='{$aParams['day_end']}'";

    return $aLimitations;
}

function _addLimitation(&$aLimitations, $entityIdName, $columnName, $value)
{
    // Add single quotes around non-integer columns
    if ( ($entityIdName == 'ad_type') ||
    ($entityIdName == 'ad_active') ||
    ($entityIdName == 'placement_active') )
    $value = "'" . str_replace(',', "','", $value) . "'";

    // If there are multiple values, use IN instead of =
    if (strpos($value, ',') !== false) {
        $aLimitations[] = "$columnName IN ($value)";
    } else {
        $aLimitations[] = "$columnName=$value";
    }
}

function _getTableLimitations($aTables)
{
    $conf = $GLOBALS['_MAX']['CONF'];
    $aTableLimitations = array();
    if (!empty($aTables[$conf['table']['prefix'].$conf['table']['agency']]) && (!empty($aTables[$conf['table']['prefix'].$conf['table']['clients']]))) $aTableLimitations[]='g.agencyid=a.agencyid';
    if (!empty($aTables[$conf['table']['prefix'].$conf['table']['agency']]) && (!empty($aTables[$conf['table']['prefix'].$conf['table']['affiliates']]))) $aTableLimitations[]='g.agencyid=p.agencyid';
    if (!empty($aTables[$conf['table']['prefix'].$conf['table']['affiliates']]) && (!empty($aTables[$conf['table']['prefix'].$conf['table']['zones']]))) $aTableLimitations[]='p.affiliateid=z.affiliateid';
    if (!empty($aTables[$conf['table']['prefix'].$conf['table']['clients']]) && (!empty($aTables[$conf['table']['prefix'].$conf['table']['campaigns']]))) $aTableLimitations[]='a.clientid=m.clientid';
    if (!empty($aTables[$conf['table']['prefix'].$conf['table']['campaigns']]) && (!empty($aTables[$conf['table']['prefix'].$conf['table']['banners']]))) $aTableLimitations[]='m.campaignid=d.campaignid';
    if (!empty($aTables[$conf['table']['prefix'].$conf['table']['campaigns']]) && (!empty($aTables[$conf['table']['prefix'].$conf['table']['placement_zone_assoc']]))) $aTableLimitations[]='m.campaignid=pz.placement_id';
    if (!empty($aTables[$conf['table']['prefix'].$conf['table']['campaigns']]) && (!empty($aTables[$conf['table']['prefix'].$conf['table']['campaigns_trackers']]))) $aTableLimitations[]='m.campaignid=mt.campaignid';
    if (!empty($aTables[$conf['table']['prefix'].$conf['table']['trackers']]) && (!empty($aTables[$conf['table']['prefix'].$conf['table']['campaigns_trackers']]))) $aTableLimitations[]='t.trackerid=mt.trackerid';
    if (!empty($aTables[$conf['table']['prefix'].$conf['table']['banners']]) && (!empty($aTables[$conf['table']['prefix'].$conf['table']['data_summary_ad_hourly']]))) $aTableLimitations[]='d.bannerid=s.ad_id';
    if (!empty($aTables[$conf['table']['prefix'].$conf['table']['banners']]) && (!empty($aTables[$conf['table']['prefix'].$conf['table']['ad_category_assoc']]))) $aTableLimitations[]='d.bannerid=ac.ad_id';
    if (!empty($aTables[$conf['table']['prefix'].$conf['table']['banners']]) && (!empty($aTables[$conf['table']['prefix'].$conf['table']['ad_zone_assoc']]))) $aTableLimitations[]='d.bannerid=az.ad_id';
    if (!empty($aTables[$conf['table']['prefix'].$conf['table']['banners']]) && (!empty($aTables[$conf['table']['prefix'].$conf['table']['acls']]))) $aTableLimitations[]='d.bannerid=l.bannerid';
    if (!empty($aTables[$conf['table']['prefix'].$conf['table']['zones']]) && (!empty($aTables[$conf['table']['prefix'].$conf['table']['data_summary_ad_hourly']]))) $aTableLimitations[]='z.zoneid=s.zone_id';
    return $aTableLimitations;
}

function _switch(&$aParams, $name, $originalName)
{
    if (isset($aParams[$name])) {
        $aParams[$originalName]=$aParams[$name];
        unset($aParams[$name]);
    }
}

function _delete($aTable, $aLimitations, $aOtherTables = null)
{
    $table = '';
    if (is_array($aTable)) {
        foreach ($aTable as $tableName => $alias) {
            $table = $tableName;
        }
    }

    $otherTables = '';
    if (is_array($aOtherTables)) {
        foreach ($aOtherTables as $otherTable => $alias) {
            $otherTables .= ($otherTables == '') ? " USING $otherTable AS $alias" : ",$otherTable AS $alias";
        }
    }

    $where = '';
    if (is_array($aLimitations)) {
        foreach ($aLimitations as $limitation) {
            $where .= ($where == '') ? " WHERE $limitation" : " AND $limitation";
        }
    }

    $query = "DELETE FROM $table" . $otherTables . $where;
    $queryValid = true;
    // Doublecheck that there is something in the where clause
    //  - to ensure that a bug does not delete the entire contents of a table!
    if (strlen($where) > 0) {
        MAX_connectDB();
        $res = phpAds_dbQuery($query)
        or $queryValid = false;
    } else {
        $queryValid = false;
    }

    if ($queryValid) {
        return phpAds_dbAffectedRows();
    } else {
        print_r($query . "\n\n" .mysql_error());
        return false;
    }
}

function _insert($aTable, $aVariables)
{
    $table = '';
    if (is_array($aTable)) {
        foreach ($aTable as $tableName => $alias) {
            $table = $tableName;
        }
    }

    $names = '';
    $values = '';
    foreach ($aVariables as $name => $value) {
        $names .= ($names == '') ? " ($name" : ",$name";
        $values .= ($values == '') ? " VALUES ('$value'" : ",'$value'";
    }
    if (!empty($names)) $names .= ')';
    if (!empty($values)) $values .= ')';

    $query = "INSERT INTO $table" . $names . $values;
    $queryValid = true;
    MAX_connectDB();
    $res = phpAds_dbQuery($query)
    or $queryValid = false;

    if ($queryValid) {
        return phpAds_dbInsertID();
    } else {
        print_r($query . "\n\n" .mysql_error());
        return false;
    }
}

function _select($aColumns, $aTables, $aLimitations, $aGroupColumns, $primaryKey)
{
    $columns = '';
    if (is_array($aColumns)) {
        foreach ($aColumns as $column => $alias) {
            $columns .= ($columns == '') ? "SELECT $column AS $alias" : ",$column AS $alias";
        }
    } else {
        $columns = "SELECT $aColumns";
    }

    $tables = '';
    if (is_array($aTables)) {
        foreach ($aTables as $table => $alias) {
            $tables .= ($tables == '') ? " FROM $table AS $alias" : ",$table AS $alias";
        }
    } else {
        $tables = "FROM $aTables";
    }

    $where = '';
    if (is_array($aLimitations)) {
        foreach ($aLimitations as $limitation) {
            $where .= ($where == '') ? " WHERE $limitation" : " AND $limitation";
        }
    } else {
        $where = " WHERE $aLimitations";
    }

    $group = '';
    if (is_array($aGroupColumns) && count($aGroupColumns) > 0) {
        $group = ' GROUP BY ' . implode(',', $aGroupColumns);
    }

    $query = $columns . $tables . $where . $group;
    return _query($query, $primaryKey);
}

function _query($query, $primaryKey)
{
    $queryValid = true;

    MAX_connectDB();
    $res = phpAds_dbQuery($query)
    or $queryValid = false;

    if ($queryValid) {
        $aRows = array();
        if (!empty($primaryKey)) {
            while ($row = phpAds_dbFetchArray($res)) {
                $aRows[$row[$primaryKey]] = $row;
            }
        } else {
            while ($row = phpAds_dbFetchArray($res)) {
                $aRows[] = $row;
            }
        }
    } else {
        print_r($query . "\n\n" .mysql_error());
    }

    return $queryValid ? $aRows : false;
}

function _update($aTable, $aVariables, $aLimitations)
{
    $table = '';
    if (is_array($aTable)) {
        foreach ($aTable as $tableName => $alias) {
            $table = "$tableName AS $alias";
        }
    }

    $set = '';
    foreach ($aVariables as $name => $value) {
        $set .= ($set == '') ? " SET $name='$value'" : ",$name='$value'";
    }

    $where = '';
    if (is_array($aLimitations)) {
        foreach ($aLimitations as $limitation) {
            $where .= ($where == '') ? " WHERE $limitation" : " AND $limitation";
        }
    }

    $query = "UPDATE $table" . $set . $where;
    $queryValid = true;
    // Connect to the DB
    MAX_connectDB();
    $res = phpAds_dbQuery($query)
    or $queryValid = false;
    if ($queryValid) {
        return phpAds_dbAffectedRows();
    } else {
        print_r($query . "\n\n" .mysql_error());
        return false;
    }
}

function MAX_connectDB()
{
    if (empty($GLOBALS['_MAX']['ADMIN_DB_LINK'])) {
        require_once 'lib-db.inc.php';
        phpAds_dbConnect();
    }
}

?>
