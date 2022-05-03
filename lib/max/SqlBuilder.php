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

if (!isset($GLOBALS['_MAX']['FILES']['/lib/max/Delivery/common.php'])) {
    // Required by PHP5.1.2
    require_once MAX_PATH . '/lib/max/Delivery/common.php';
}

/**
 * @package    MaxDal
 */
class SqlBuilder
{
    // +---------------------------------------+
    // | Relational/constraint methods         |
    // |                                       |
    // | for entity builders                   |
    // +---------------------------------------+

    /**
     * Returns the fields given the particular entity.
     *
     * @param string $entity
     * @param array $aParams
     * @param boolean $allFields
     * @return array
     */
    public static function _getColumns($entity, $aParams, $allFields)
    {
        $aColumns = [];
        switch ($entity) {

        case 'ad':
            $aColumns += ['d.bannerid' => 'ad_id', 'd.campaignid' => 'placement_id', 'd.status' => 'status', 'd.description' => 'name', 'd.storagetype' => 'type', 'd.ext_bannertype' => 'ext_bannertype'];
            if ($allFields) {
                $aColumns += ['d.contenttype' => 'contenttype', 'd.pluginversion' => 'pluginversion', 'd.filename' => 'filename', 'd.imageurl' => 'imageurl', 'd.htmltemplate' => 'htmltemplate', 'd.htmlcache' => 'htmlcache', 'd.width' => 'width', 'd.height' => 'height', 'd.weight' => 'weight', 'd.seq' => 'seq', 'd.target' => 'target', 'd.url' => 'url', 'd.alt' => 'alt', 'd.statustext' => 'statustext', 'd.bannertext' => 'bannertext', 'd.adserver' => 'adserver', 'd.block' => 'block', 'd.capping' => 'capping', 'd.session_capping' => 'session_capping', 'd.compiledlimitation' => 'compiledlimitation', 'd.prepend' => 'prepend', 'd.append' => 'append', 'd.bannertype' => 'bannertype', 'd.alt_filename' => 'alt_filename', 'd.alt_imageurl' => 'alt_imageurl', 'd.alt_contenttype' => 'alt_contenttype', 'd.comments' => 'comments', 'd.parameters' => 'parameters', 'd.transparent' => 'transparent'];
            }
            break;

        case 'advertiser':
            $aColumns += ['a.clientid' => 'advertiser_id', 'a.agencyid' => 'agency_id', 'a.clientname' => 'name', 'a.type' => 'type'];
            if ($allFields) {
                $aColumns += ['a.contact' => 'contact', 'a.email' => 'email', 'a.report' => 'report', 'a.reportinterval' => 'report_interval', 'a.reportlastdate' => 'report_last_date', 'a.reportdeactivate' => 'report_deactivate'];
            }
            break;

        case 'ad_category_assoc':
            $aColumns += ['ac.ad_category_assoc_id' => 'ad_category_assoc_id', 'ac.ad_id' => 'ad_id', 'ac.category_id' => 'category_id'];
            break;

        case 'ad_zone_assoc':
            $aColumns += ['az.ad_zone_assoc_id' => 'ad_zone_assoc_id', 'az.ad_id' => 'ad_id', 'az.zone_id' => 'zone_id', 'az.priority' => 'priority'];
            break;

        case 'agency':
            $aColumns += ['g.agencyid' => 'agency_id', 'g.name' => 'name', 'g.status' => 'status'];
            if ($allFields) {
                $aColumns += [
                'g.contact' => 'contact',
                'g.email' => 'email',
                'g.logout_url' => 'logout_url'
                ];
            }
            break;

        case 'campaign':
            $aColumns += ['cam.campaignid' => 'campaign_id', 'cam.campaignname' => 'campaignname', 'cam.clientid' => 'client_id', 'cam.anonymous' => 'anonymous', 'cam.type' => 'type'];
            if ($allFields) {
                $aColumns += ['cam.campaignid' => 'campaign_id', 'cam.campaignname' => 'campaignname', 'cam.clientid' => 'client_id', 'cam.views' => 'views', 'cam.clicks' => 'clicks', 'cam.conversions' => 'conversions', 'cam.priority' => 'priority', 'cam.weight' => 'weight', 'cam.target_impression' => 'target_impression', 'cam.target_click' => 'target_click', 'cam.target_conversion' => 'target_conversion', 'cam.anonymous' => 'anonymous', 'cam.companion' => 'companion', 'cam.comments' => 'comments', 'cam.revenue' => 'revenue', 'cam.revenue_type' => 'revenue_type', 'cam.updated' => 'updated', 'cam.block' => 'block', 'cam.capping' => 'capping', 'cam.session_capping' => 'session_capping', 'cam.activate_time' => 'activate_time', 'cam.expire_time' => 'expire_time', 'cam.show_capped_no_cookie' => 'show_capped_no_cookie'];
            }
            break;
            
        case 'category':
            $aColumns += ['cat.category_id' => 'category_id', 'cat.name' => 'name'];
            break;

        case 'channel':
            $aColumns += ['ch.channelid' => 'channel_id', 'ch.agencyid' => 'agency_id', 'ch.affiliateid' => 'publisher_id', 'ch.name' => 'name'];
            if ($allFields) {
                $aColumns += ['ch.description' => 'description', 'ch.compiledlimitation' => 'compiledlimitation', 'ch.active' => 'active', 'ch.comments' => 'comments'];
            }
            break;

        case 'channel_limitation':
            $aColumns += ['chl.logical' => 'logical', 'chl.type' => 'type', 'chl.comparison' => 'comparison', 'chl.data' => 'data', 'chl.executionorder' => 'executionorder'];
            break;
        
        case 'image':
            $aColumns += ['i.filename' => 'file_name'];
            if ($allFields) {
                $aColumns += ['i.t_stamp' => 't_stamp', 'i.contents' => 'contents'];
            }
            break;

        case 'limitation':
            $aColumns += ['l.bannerid' => 'ad_id', 'l.logical' => 'logical', 'l.type' => 'type', 'l.comparison' => 'comparison', 'l.data' => 'data', 'l.executionorder' => 'executionorder'];
            break;

        case 'placement':
            $aColumns += ['m.clientid' => 'advertiser_id', 'm.campaignid' => 'placement_id', 'm.campaignname' => 'name', 'm.status' => 'status', 'm.anonymous' => 'anonymous', 'm.priority' => 'priority',  'm.type' => 'mtype'];
            if ($allFields) {
                $aColumns += ['m.views' => 'views', 'm.clicks' => 'clicks', 'm.conversions' => 'conversions', 'm.activate_time' => 'activate_time', 'm.expire_time' => 'expire_time', 'm.weight' => 'weight', 'm.target_impression' => 'target_impression', 'm.target_click' => 'target_click', 'm.target_conversion' => 'target_conversion', 'm.anonymous' => 'anonymous'];
            }
            break;

        case 'placement_tracker':
            $aColumns += ['mt.campaign_trackerid' => 'placement_tracker_id', 'mt.campaignid' => 'placement_id', 'mt.trackerid' => 'tracker_id'];
            if ($allFields) {
                $aColumns += ['mt.status' => 'status', 'mt.viewwindow' => 'view_window', 'mt.clickwindow' => 'click_window'];
            }
            break;

        case 'publisher':
            $aColumns += ['p.affiliateid' => 'publisher_id', 'p.agencyid' => 'agency_id', 'p.name' => 'name'];
            if ($allFields) {
                $aColumns += ['p.mnemonic' => 'mnemonic', 'p.contact' => 'contact', 'p.email' => 'email', 'p.website' => 'website'];
            }
            break;

        case 'stats':
            $aColumns += ["DATE_FORMAT(date_time, '%Y-%m-%d')" => 'day', 'HOUR(date_time)' => 'hour', 'SUM(s.requests)' => 'sum_requests', 'SUM(s.impressions)' => 'sum_views', 'SUM(s.clicks)' => 'sum_clicks', 'SUM(s.conversions)' => 'sum_conversions'];
            break;

        case 'stats_by_entity':
            if (isset($aParams['include']) && is_array($aParams['include'])) {
                if (array_search('advertiser_id', $aParams['include']) !== false) {
                    $aColumns += ['m.clientid' => 'advertiser_id'];
                }
                if (array_search('placement_id', $aParams['include']) !== false) {
                    $aColumns += ['d.campaignid' => 'placement_id'];
                }
                if (array_search('publisher_id', $aParams['include']) !== false) {
                    $aColumns += ['z.affiliateid' => 'publisher_id'];
                }
            }

            $compositeKey = self::sqlKeyConcat(["s.ad_id", "s.zone_id"]);

            $aColumns += [
                $compositeKey => 'pkey',
                's.ad_id' => 'ad_id',
                's.zone_id' => 'zone_id'
            ] + SqlBuilder::_getColumns('stats_common', $aParams, $allFields);

            if (isset($aParams['add_columns']) && is_array($aParams['add_columns'])) {
                $aColumns += $aParams['add_columns'];
            }

            // Remove unused columns to avoid implicit group by
            if (isset($aParams['exclude']) && is_array($aParams['exclude'])) {
                if (array_search('ad_id', $aParams['exclude']) !== false) {
                    unset($aColumns[$compositeKey]);
                    unset($aColumns['s.ad_id']);
                    if (array_search('zone_id', $aParams['exclude']) !== false) {
                        unset($aColumns['s.zone_id']);
                        if (count($aParams['include'])) {
                            $tr = [
                                'placement_id' => 'd.campaignid',
                                'advertiser_id' => 'm.clientid',
                                'publisher_id' => 'z.affiliateid'
                            ];
                            $aColumns[strtr(self::sqlKeyConcat($aParams['include']), $tr)] = 'pkey';
                        } else {
                            $aColumns["(0)"] = 'pkey';
                        }
                    } else {
                        $aColumns["(s.zone_id)"] = 'pkey';
                    }
                } elseif (array_search('zone_id', $aParams['exclude']) !== false) {
                    unset($aColumns[$compositeKey]);
                    unset($aColumns['s.zone_id']);
                    $aColumns["(s.ad_id)"] = 'pkey';
                }
            }
            break;

        case 'history_span':
            if (isset($aParams['custom_columns']) && is_array($aParams['custom_columns'])) {
                $aColumns += $aParams['custom_columns'];
            } else {
                $aColumns += ['MIN(s.date_time)' => 'start_date'];
            }
            break;

        case 'targeting_span':
            if (isset($aParams['custom_columns']) && is_array($aParams['custom_columns'])) {
                $aColumns += $aParams['custom_columns'];
            } else {
                $aColumns += ['MIN(s.interval_start)' => 'start_date'];
            }
            break;

        case 'history_day_hour':
            $aColumns += ['s.date_time' => 'date_time'] + SqlBuilder::_getColumns('stats_common', $aParams, $allFields);
            break;

        case 'history_day':
            $aColumns += ["DATE_FORMAT(s.date_time, , '%Y-%m-%d')" => 'day', "DATE_FORMAT(s.date_time, '{$GLOBALS['date_format']}')" => 'date_f'] + SqlBuilder::_getColumns('stats_common', $aParams, $allFields);
            break;

        case 'history_month':
            $aColumns += ["DATE_FORMAT(s.date_time, '%Y-%m')" => 'month', "DATE_FORMAT(s.date_time, '{$GLOBALS['month_format']}')" => 'date_f'] + SqlBuilder::_getColumns('stats_common', $aParams, $allFields);
            break;

        case 'history_dow':
            $aColumns += ["(DAYOFWEEK(s.date_time) - 1)" => 'dow'] + SqlBuilder::_getColumns('stats_common', $aParams, $allFields);
            break;

        case 'history_hour':
            $aColumns += ["HOUR(s.date_time)" => 'hour'] + SqlBuilder::_getColumns('stats_common', $aParams, $allFields);
            break;

        case 'stats_common':
            if (isset($aParams['custom_columns']) && is_array($aParams['custom_columns'])) {
                $aColumns += $aParams['custom_columns'];
            } else {
                $aColumns += ['SUM(s.requests)' => 'sum_requests', 'SUM(s.impressions)' => 'sum_views', 'SUM(s.clicks)' => 'sum_clicks', 'SUM(s.conversions)' => 'sum_conversions'];
            }

            if (isset($aParams['add_columns']) && is_array($aParams['add_columns'])) {
                $aColumns += $aParams['add_columns'];
            }
            break;

        case 'tracker':
            $aColumns += ['t.clientid' => 'advertiser_id', 't.trackerid' => 'tracker_id', 't.trackername' => 'name'];
            if ($allFields) {
                $aColumns += ['t.description' => 'description', 't.viewwindow' => 'viewwindow', 't.clickwindow' => 'clickwindow', 't.blockwindow' => 'blockwindow', 't.variablemethod' => 'variablemethod', 't.appendcode' => 'appendcode'];
            }
            break;

        case 'variable':
            $aColumns += ['v.variableid' => 'variable_id', 'v.trackerid' => 'tracker_id', 'v.name' => 'name', 'v.datatype' => 'type'];
            if ($allFields) {
                $aColumns += ['v.description' => 'description', 'v.variablecode' => 'variablecode'];
            }
            break;

        case 'zone':
            $aColumns += ['z.zoneid' => 'zone_id', 'z.affiliateid' => 'publisher_id', 'z.zonename' => 'name', 'z.delivery' => 'type'];
            if ($allFields) {
                $aColumns += ['z.description' => 'description', 'z.width' => 'width', 'z.height' => 'height', 'z.chain' => 'chain', 'z.prepend' => 'prepend', 'z.append' => 'append', 'z.appendtype' => 'appendtype', 'z.forceappend' => 'forceappend', 'z.inventory_forecast_type' => 'inventory_forecast_type', 'z.comments' => 'comments', 'z.block' => 'block', 'z.capping' => 'capping', 'z.session_capping' => 'session_capping', 'z.category' => 'category', 'z.ad_selection' => 'ad_selection', 'z.rate' => 'rate', 'z.pricing' => 'pricing', 'z.show_capped_no_cookie' => 'show_capped_no_cookie'];
            }
            break;

        case 'placement_zone_assoc':
            $aColumns += ['pz.placement_zone_assoc_id' => 'placement_zone_assoc_id', 'pz.placement_id' => 'placement_id', 'pz.zone_id' => 'zone_id'];
            break;
        }

        $matchingEntitiesToFix = 'history_';
        if (substr($entity, 0, strlen($matchingEntitiesToFix)) == $matchingEntitiesToFix) {
            // postgresql throws an error: column "m.campaignid" must appear in the GROUP BY clause or be used in an aggregate function
            // we therefore remove the column ad_id built on a concatenation of various other fields, as this particular field
            // is not in use in the Global Statistics stats screen (when entity == history_*)
            if (false !== ($found = array_search('ad_id', $aColumns))) {
                unset($aColumns[$found]);
            }
        }
        return $aColumns;
    }

    /**
     * Returns the fields required by a stats query for a given entity.
     *
     * @param string $entity
     * @return array
     */
    public static function _getStatsColumns($entity)
    {
        $aColumns = ['SUM(s.requests)' => 'sum_requests', 'SUM(s.impressions)' => 'sum_views', 'SUM(s.clicks)' => 'sum_clicks', 'SUM(s.conversions)' => 'sum_conversions'];
        switch ($entity) {

        case 'ad':         $aColumns += ['d.bannerid' => 'ad_id']; break;
        case 'advertiser': $aColumns += ['a.clientid' => 'advertiser_id']; break;
        case 'agency':     $aColumns += ['g.agencyid' => 'agency_id']; break;
        case 'placement':  $aColumns += ['m.campaignid' => 'placement_id']; break;
        case 'publisher':  $aColumns += ['p.affiliateid' => 'publisher_id']; break;
        case 'zone':       $aColumns += ['z.zoneid' => 'zone_id']; break;
        }

        return $aColumns;
    }

    /**
     * Returns as array of table names and their aliases.
     *
     * @param string $entity
     * @param array $aParams
     * @param boolean $includeStats
     * @return array
     */
    public static function _getTables($entity, $aParams, $includeStats = false)
    {
        $conf = $GLOBALS['_MAX']['CONF'];

        $aTables = [];
        switch ($entity) {

        case 'ad':
            $aTables += [$conf['table']['prefix'] . $conf['table']['banners'] => 'd'];
            if (!empty($aParams['agency_id'])) {
                $aTables += [$conf['table']['prefix'] . $conf['table']['clients'] => 'a', $conf['table']['prefix'] . $conf['table']['campaigns'] => 'm'];
            }
            if (!empty($aParams['advertiser_id'])) {
                $aTables += [$conf['table']['prefix'] . $conf['table']['campaigns'] => 'm'];
            }
            if (!empty($aParams['placement_active'])) {
                $aTables += [$conf['table']['prefix'] . $conf['table']['campaigns'] => 'm'];
            }
            if (!empty($aParams['placement_anonymous'])) {
                $aTables += [$conf['table']['prefix'] . $conf['table']['campaigns'] => 'm'];
            }
            if ($includeStats) {
                if (!empty($aParams['publisher_id'])) {
                    $aTables += [$conf['table']['prefix'] . $conf['table']['zones'] => 'z'];
                }
                $aTables += [$conf['table']['prefix'] . $conf['table']['data_summary_ad_hourly'] => 's'];
            }
            break;

        case 'advertiser':
            $aTables += [$conf['table']['prefix'] . $conf['table']['clients'] => 'a'];
            if (!empty($aParams['placement_id'])) {
                $aTables += [$conf['table']['prefix'] . $conf['table']['campaigns'] => 'm'];
            }
            if (!empty($aParams['placement_active'])) {
                $aTables += [$conf['table']['prefix'] . $conf['table']['campaigns'] => 'm'];
            }
            if (!empty($aParams['placement_anonymous'])) {
                $aTables += [$conf['table']['prefix'] . $conf['table']['campaigns'] => 'm'];
            }
            if (!empty($aParams['ad_id'])) {
                $aTables += [$conf['table']['prefix'] . $conf['table']['campaigns'] => 'm', $conf['table']['prefix'] . $conf['table']['banners'] => 'd'];
            }
            if (!empty($aParams['ad_active'])) {
                $aTables += [$conf['table']['prefix'] . $conf['table']['campaigns'] => 'm', $conf['table']['prefix'] . $conf['table']['banners'] => 'd'];
            }
            if (isset($aParams['ad_width'])) {
                $aTables += [$conf['table']['prefix'] . $conf['table']['campaigns'] => 'm', $conf['table']['prefix'] . $conf['table']['banners'] => 'd'];
            }
            if (isset($aParams['ad_height'])) {
                $aTables += [$conf['table']['prefix'] . $conf['table']['campaigns'] => 'm', $conf['table']['prefix'] . $conf['table']['banners'] => 'd'];
            }
            if (!empty($aParams['ad_type'])) {
                $aTables += [$conf['table']['prefix'] . $conf['table']['campaigns'] => 'm', $conf['table']['prefix'] . $conf['table']['banners'] => 'd'];
            }
            if (isset($aParams['campaign_type'])) {
                $aTables += [$conf['table']['prefix'] . $conf['table']['campaigns'] => 'm'];
            }
            if ($includeStats) {
                $aTables += [$conf['table']['prefix'] . $conf['table']['data_summary_ad_hourly'] => 's', $conf['table']['prefix'] . $conf['table']['banners'] => 'd', $conf['table']['prefix'] . $conf['table']['campaigns'] => 'm'];
            }
            break;

        case 'ad_category_assoc':
            $aTables += [$conf['table']['prefix'] . $conf['table']['ad_category_assoc'] => 'ac'];
            if (!empty($aParams['agency_id'])) {
                $aTables += [$conf['table']['prefix'] . $conf['table']['banners'] => 'd', $conf['table']['campaigns'] => 'm', $conf['table']['prefix'] . $conf['table']['clients'] = 'a'];
            }
            if (!empty($aParams['advertiser_id'])) {
                $aTables += [$conf['table']['prefix'] . $conf['table']['banners'] => 'd', $conf['table']['prefix'] . $conf['table']['campaigns'] => 'm'];
            }
            if (!empty($aParams['placement_id'])) {
                $aTables += [$conf['table']['prefix'] . $conf['table']['banners'] => 'd'];
            }
            if (!empty($aParams['placement_active'])) {
                $aTables += [$conf['table']['prefix'] . $conf['table']['banners'] => 'd', $conf['table']['prefix'] . $conf['table']['campaigns'] => 'm'];
            }
            if (!empty($aParams['placement_anonymous'])) {
                $aTables += [$conf['table']['prefix'] . $conf['table']['banners'] => 'd', $conf['table']['prefix'] . $conf['table']['campaigns'] => 'm'];
            }
            if (isset($aParams['ad_width'])) {
                $aTables += [$conf['table']['prefix'] . $conf['table']['banners'] => 'd'];
            }
            if (isset($aParams['ad_height'])) {
                $aTables += [$conf['table']['prefix'] . $conf['table']['banners'] => 'd'];
            }
            if (!empty($aParams['ad_type'])) {
                $aTables += [$conf['table']['prefix'] . $conf['table']['banners'] => 'd'];
            }
            if (!empty($aParams['ad_active'])) {
                $aTables += [$conf['table']['prefix'] . $conf['table']['banners'] => 'd'];
            }
            break;

        case 'ad_zone_assoc':
            $aTables += [$conf['table']['prefix'] . $conf['table']['ad_zone_assoc'] => 'az'];
            if (!empty($aParams['agency_id'])) {
                $aTables += [$conf['table']['prefix'] . $conf['table']['zones'] => 'z', $conf['table']['prefix'] . $conf['table']['banners'] => 'd', $conf['table']['prefix'] . $conf['table']['campaigns'] => 'm', $conf['table']['prefix'] . $conf['table']['clients'] => 'a', $conf['table']['prefix'] . $conf['table']['affiliates'] => 'p'];
            }
            if (!empty($aParams['publisher_id'])) {
                $aTables += [$conf['table']['prefix'] . $conf['table']['zones'] => 'z'];
            }
            if (!empty($aParams['advertiser_id'])) {
                $aTables += [$conf['table']['prefix'] . $conf['table']['banners'] => 'd', $conf['table']['prefix'] . $conf['table']['campaigns'] => 'm'];
            }
            if (!empty($aParams['placement_id'])) {
                $aTables += [$conf['table']['prefix'] . $conf['table']['banners'] => 'd'];
            }
            if (!empty($aParams['placement_active'])) {
                $aTables += [$conf['table']['prefix'] . $conf['table']['banners'] => 'd', $conf['table']['prefix'] . $conf['table']['campaigns'] => 'm'];
            }
            if (!empty($aParams['placement_anonymous'])) {
                $aTables += [$conf['table']['prefix'] . $conf['table']['banners'] => 'd', $conf['table']['prefix'] . $conf['table']['campaigns'] => 'm'];
            }
            if (!empty($aParams['zone_inventory_forecast_type'])) {
                $aTables += [$conf['table']['prefix'] . $conf['table']['zones'] => 'z'];
            }
            if (isset($aParams['ad_width'])) {
                $aTables += [$conf['table']['prefix'] . $conf['table']['banners'] => 'd'];
            }
            if (isset($aParams['ad_height'])) {
                $aTables += [$conf['table']['prefix'] . $conf['table']['banners'] => 'd'];
            }
            if (!empty($aParams['ad_type'])) {
                $aTables += [$conf['table']['prefix'] . $conf['table']['banners'] => 'd'];
            }
            if (!empty($aParams['ad_active'])) {
                $aTables += [$conf['table']['prefix'] . $conf['table']['banners'] => 'd'];
            }
            break;

        case 'agency':
            $aTables += [$conf['table']['prefix'] . $conf['table']['agency'] => 'g'];
            if (!empty($aParams['advertiser_id'])) {
                $aTables += [$conf['table']['prefix'] . $conf['table']['clients'] => 'a'];
            }
            if (!empty($aParams['placement_id'])) {
                $aTables += [$conf['table']['prefix'] . $conf['table']['clients'] => 'a', $conf['table']['prefix'] . $conf['table']['campaigns'] => 'm'];
            }
            if (!empty($aParams['placement_active'])) {
                $aTables += [$conf['table']['prefix'] . $conf['table']['clients'] => 'a', $conf['table']['prefix'] . $conf['table']['campaigns'] => 'm'];
            }
            if (!empty($aParams['placement_anonymous'])) {
                $aTables += [$conf['table']['prefix'] . $conf['table']['clients'] => 'a', $conf['table']['prefix'] . $conf['table']['campaigns'] => 'm'];
            }
            if (!empty($aParams['ad_id'])) {
                $aTables += [$conf['table']['prefix'] . $conf['table']['clients'] => 'a', $conf['table']['prefix'] . $conf['table']['campaigns'] => 'm', $conf['table']['prefix'] . $conf['table']['banners'] => 'd'];
            }
            if (isset($aParams['ad_width'])) {
                $aTables += [$conf['table']['prefix'] . $conf['table']['clients'] => 'a', $conf['table']['prefix'] . $conf['table']['campaigns'] => 'm', $conf['table']['prefix'] . $conf['table']['banners'] => 'd'];
            }
            if (isset($aParams['ad_height'])) {
                $aTables += [$conf['table']['prefix'] . $conf['table']['clients'] => 'a', $conf['table']['prefix'] . $conf['table']['campaigns'] => 'm', $conf['table']['prefix'] . $conf['table']['banners'] => 'd'];
            }
            if (!empty($aParams['ad_type'])) {
                $aTables += [$conf['table']['prefix'] . $conf['table']['clients'] => 'a', $conf['table']['prefix'] . $conf['table']['campaigns'] => 'm', $conf['table']['prefix'] . $conf['table']['banners'] => 'd'];
            }
            if (!empty($aParams['publisher_id'])) {
                $aTables += [$conf['table']['prefix'] . $conf['table']['affiliates'] => 'p'];
            }
            if (!empty($aParams['zone_id'])) {
                $aTables += [$conf['table']['prefix'] . $conf['table']['affiliates'] => 'p', $conf['table']['prefix'] . $conf['table']['zones'] => 'z'];
            }
            if (!empty($aParams['zone_inventory_forecast_type'])) {
                $aTables += [$conf['table']['prefix'] . $conf['table']['affiliates'] => 'p', $conf['table']['prefix'] . $conf['table']['zones'] => 'z'];
            }
            if ($includeStats) {
                $aTables += [$conf['table']['prefix'] . $conf['table']['data_summary_ad_hourly'] => 's', $conf['table']['prefix'] . $conf['table']['banners'] => 'd', $conf['table']['prefix'] . $conf['table']['campaigns'] => 'm', $conf['table']['prefix'] . $conf['table']['clients'] => 'a', $conf['table']['prefix'] . $conf['table']['affiliates'] => 'p', $conf['table']['prefix'] . $conf['table']['zones'] => 'z'];
            }
            break;

        case 'campaign':
            $aTables += [$conf['table']['prefix'] . $conf['table']['campaigns'] => 'cam'];

            // no break
        case 'category':
            $aTables += [$conf['table']['prefix'] . $conf['table']['category'] => 'cat'];
            break;

        case 'channel':
            $aTables += [$conf['table']['prefix'] . $conf['table']['channel'] => 'ch'];
            break;

        case 'channel_limitation':
            $aTables += [$conf['table']['prefix'] . $conf['table']['acls_channel'] => 'chl'];
            break;

        case 'image':
            $aTables += [$conf['table']['prefix'] . $conf['table']['images'] => 'i'];
            break;

        case 'limitation':
            $aTables += [$conf['table']['prefix'] . $conf['table']['acls'] => 'l'];
            if (!empty($aParams['agency_id'])) {
                $aTables += [$conf['table']['prefix'] . $conf['table']['banners'] => 'd', $conf['table']['prefix'] . $conf['table']['campaigns'] => 'm', $conf['table']['prefix'] . $conf['table']['clients'] = 'a'];
            }
            if (!empty($aParams['advertiser_id'])) {
                $aTables += [$conf['table']['prefix'] . $conf['table']['banners'] => 'd', $conf['table']['prefix'] . $conf['table']['campaigns'] => 'm'];
            }
            if (!empty($aParams['placement_id'])) {
                $aTables += [$conf['table']['prefix'] . $conf['table']['banners'] => 'd'];
            }
            break;

        case 'placement':
            $aTables += [$conf['table']['prefix'] . $conf['table']['campaigns'] => 'm'];
            if (!empty($aParams['agency_id'])) {
                $aTables += [$conf['table']['prefix'] . $conf['table']['clients'] => 'a'];
            }
            if (!empty($aParams['ad_id'])) {
                $aTables += [$conf['table']['prefix'] . $conf['table']['banners'] => 'd'];
            }
            if (!empty($aParams['ad_active'])) {
                $aTables += [$conf['table']['prefix'] . $conf['table']['banners'] => 'd'];
            }
            if (isset($aParams['ad_width'])) {
                $aTables += [$conf['table']['prefix'] . $conf['table']['banners'] => 'd'];
            }
            if (isset($aParams['ad_height'])) {
                $aTables += [$conf['table']['prefix'] . $conf['table']['banners'] => 'd'];
            }
            if (!empty($aParams['ad_type'])) {
                $aTables += [$conf['table']['prefix'] . $conf['table']['banners'] => 'd'];
            }
            if ($includeStats) {
                if (!empty($aParams['publisher_id'])) {
                    $aTables += [$conf['table']['prefix'] . $conf['table']['zones'] => 'z'];
                }
                $aTables += [$conf['table']['prefix'] . $conf['table']['data_summary_ad_hourly'] => 's', $conf['table']['prefix'] . $conf['table']['banners'] => 'd'];
            }
            break;

        case 'placement_tracker':
            $aTables += [$conf['table']['prefix'] . $conf['table']['campaigns_trackers'] => 'mt'];
            if (!empty($aParams['agency_id'])) {
                $aTables += [$conf['table']['prefix'] . $conf['table']['campaigns'] => 'm', $conf['table']['prefix'] . $conf['table']['clients'] => 'a', $conf['table']['prefix'] . $conf['table']['trackers'] => 't'];
            }
            if (!empty($aParams['advertiser_id'])) {
                $aTables += [$conf['table']['prefix'] . $conf['table']['campaigns'] => 'm', $conf['table']['prefix'] . $conf['table']['trackers'] => 't'];
            }
            break;

        case 'placement_zone_assoc':
            $aTables += [$conf['table']['prefix'] . $conf['table']['placement_zone_assoc'] => 'pz'];
            if (!empty($aParams['ad_id'])) {
                $aTables += [$conf['table']['prefix'] . $conf['table']['banners'] => 'd'];
            }
            if (!empty($aParams['advertiser_id'])) {
                $aTables += [$conf['table']['prefix'] . $conf['table']['campaigns'] => 'm'];
            }
            if (!empty($aParams['agency_id'])) {
                $aTables += [$conf['table']['prefix'] . $conf['table']['zones'] => 'z', $conf['table']['prefix'] . $conf['table']['campaigns'] => 'm', $conf['table']['prefix'] . $conf['table']['clients'] => 'a', $conf['table']['prefix'] . $conf['table']['affiliates'] => 'p'];
            }
            if (!empty($aParams['placement_active'])) {
                $aTables += [$conf['table']['prefix'] . $conf['table']['campaigns'] => 'm'];
            }
            if (!empty($aParams['placement_anonymous'])) {
                $aTables += [$conf['table']['prefix'] . $conf['table']['campaigns'] => 'm'];
            }
            if (!empty($aParams['publisher_id'])) {
                $aTables += [$conf['table']['prefix'] . $conf['table']['zones'] => 'z'];
            }
            if (!empty($aParams['zone_inventory_forecast_type'])) {
                $aTables += [$conf['table']['prefix'] . $conf['table']['zones'] => 'z'];
            }
            break;

        case 'publisher':
            $aTables += [$conf['table']['prefix'] . $conf['table']['affiliates'] => 'p'];
            if (!empty($aParams['zone_id'])) {
                $aTables += [$conf['table']['prefix'] . $conf['table']['zones'] => 'z'];
            }
            if (!empty($aParams['zone_inventory_forecast_type'])) {
                $aTables += [$conf['table']['prefix'] . $conf['table']['zones'] => 'z'];
            }
            if ($includeStats) {
                $aTables += [$conf['table']['prefix'] . $conf['table']['data_summary_ad_hourly'] => 's', $conf['table']['prefix'] . $conf['table']['zones'] => 'z'];
                if (!empty($aParams['placement_id'])) {
                    $aTables += [$conf['table']['prefix'] . $conf['table']['banners'] => 'd'];
                }
            }
            break;

        case 'history_span':
        case 'history_day_hour':
        case 'history_day':
        case 'history_month':
        case 'history_dow':
        case 'history_hour':
        case 'stats':
            if (isset($aParams['custom_table'])) {
                $aTables += [$conf['table']['prefix'] . $aParams['custom_table'] => 's'];
            } else {
                $aTables += [$conf['table']['prefix'] . $conf['table']['data_summary_ad_hourly'] => 's'];
            }

            if (!empty($aParams['agency_id'])) {
                $aTables += [
                    $conf['table']['prefix'] . $conf['table']['clients'] => 'a',
                    $conf['table']['prefix'] . $conf['table']['campaigns'] => 'm',
                    $conf['table']['prefix'] . $conf['table']['banners'] => 'd',
                    $conf['table']['prefix'] . $conf['table']['affiliates'] => 'p',
                    $conf['table']['prefix'] . $conf['table']['zones'] => 'z'
                ];
            }

            if (!empty($aParams['advertiser_id'])) {
                $aTables += [
                    $conf['table']['prefix'] . $conf['table']['campaigns'] => 'm',
                    $conf['table']['prefix'] . $conf['table']['banners'] => 'd'
                ];
            }
            if (!empty($aParams['placement_id'])) {
                $aTables += [
                    $conf['table']['prefix'] . $conf['table']['banners'] => 'd'
                ];
            }
            if (!empty($aParams['publisher_id'])) {
                $aTables += [
                    $conf['table']['prefix'] . $conf['table']['zones'] => 'z'
                ];
            }
            break;

        case 'stats_by_entity':

            if (isset($aParams['include']) && is_array($aParams['include'])) {
                // Fake needed parameters
                if (array_search('advertiser_id', $aParams['include']) !== false) {
                    $aParams['advertiser_id'] = 1;
                }
                if (array_search('placement_id', $aParams['include']) !== false) {
                    $aParams['placement_id'] = 1;
                }
                if (array_search('publisher_id', $aParams['include']) !== false) {
                    $aParams['publisher_id'] = 1;
                }
            }
            $aTables += SqlBuilder::_getTables('stats', $aParams);
            break;

        case 'tracker':
            $aTables += [$conf['table']['prefix'] . $conf['table']['trackers'] => 't'];
            if (!empty($aParams['agency_id'])) {
                $aTables += [$conf['table']['prefix'] . $conf['table']['clients'] => 'a'];
            }
            if (!empty($aParams['ad_id'])) {
                $aTables += [$conf['table']['prefix'] . $conf['table']['banners'] => 'd', $conf['table']['prefix'] . $conf['table']['campaigns'] => 'm', $conf['table']['prefix'] . $conf['table']['campaigns_trackers'] => 'mt'];
            }
            if (!empty($aParams['placement_id'])) {
                $aTables += [$conf['table']['prefix'] . $conf['table']['campaigns_trackers'] => 'mt'];
            }
            break;

        case 'variable':
            $aTables += [$conf['table']['prefix'] . $conf['table']['variables'] => 'v'];
            if (!empty($aParams['agency_id'])) {
                $aTables += [$conf['table']['prefix'] . $conf['table']['clients'] => 'a', $conf['table']['prefix'] . $conf['table']['trackers'] => 't'];
            }
            if (!empty($aParams['advertiser_id'])) {
                $aTables += [$conf['table']['prefix'] . $conf['table']['trackers'] => 't'];
            }
            break;

        case 'zone':
            $aTables += [$conf['table']['prefix'] . $conf['table']['zones'] => 'z'];
            if (!empty($aParams['agency_id'])) {
                $aTables += [$conf['table']['prefix'] . $conf['table']['affiliates'] => 'p'];
            }
            if ($includeStats) {
                $aTables += [$conf['table']['prefix'] . $conf['table']['data_summary_ad_hourly'] => 's'];
            }
            if ($includeStats) {
                $aTables += [$conf['table']['prefix'] . $conf['table']['data_summary_ad_hourly'] => 's'];
                if (!empty($aParams['placement_id'])) {
                    $aTables += [$conf['table']['prefix'] . $conf['table']['banners'] => 'd'];
                }
            }
            break;
        }
        return $aTables;
    }

    /**
     * Returns an array of constraints given an entity with params.
     *
     * @param string $entity
     * @param array $aParams
     * @return array
     */
    public static function _getLimitations($entity, $aParams)
    {
        if (!empty($aParams) && is_array($aParams)) {
            $aParams = MAX_commonSlashArray($aParams);
        }

        $aLimitations = [];

        // size limitation e.g. ((width = -1 AND height = -1) OR (width = 468 AND height = 60));
        $aSizeLimitations = [];
        $aZoneSize = [];
        if (isset($aParams['ad_width'])) {
            SqlBuilder::_addLimitation($aZoneSize, 'ad_width', 'd.width', $aParams['ad_width']);
        }
        if (isset($aParams['ad_height'])) {
            SqlBuilder::_addLimitation($aZoneSize, 'ad_height', 'd.height', $aParams['ad_height']);
        }
        $zoneSize = implode(' AND ', $aZoneSize);
        if (!empty($zoneSize)) {
            if (!empty($aParams['ad_nosize'])) {
                $aNoSize = [];
                SqlBuilder::_addLimitation($aNoSize, 'ad_width', 'd.width', -1);
                SqlBuilder::_addLimitation($aNoSize, 'ad_height', 'd.height', -1);
                $aSizeLimitations[] = '(' . implode(' AND ', $aNoSize) . ')';
            }
            $aSizeLimitations[] = '(' . $zoneSize . ')';
            $sizeLimitation = implode(' OR ', $aSizeLimitations);
            if (!empty($sizeLimitation)) {
                $aLimitations[] = '(' . $sizeLimitation . ')';
            }
        }

        if (!empty($aParams['ad_type'])) {
            if ($aParams['ad_type'] == "!txt") {
                SqlBuilder::_addLimitation($aLimitations, 'ad_type', 'd.storagetype', 'txt', MAX_LIMITATION_NOT_EQUAL);
            } elseif ($aParams['ad_type'] == "!htmltxt") {
                SqlBuilder::_addLimitation($aLimitations, 'ad_type', 'd.storagetype', 'txt', MAX_LIMITATION_NOT_EQUAL);
                SqlBuilder::_addLimitation($aLimitations, 'ad_type', 'd.storagetype', 'html', MAX_LIMITATION_NOT_EQUAL);
            } else {
                SqlBuilder::_addLimitation($aLimitations, 'ad_type', 'd.storagetype', $aParams['ad_type']);
            }
        }
        if (!empty($aParams['ad_active'])) {
            SqlBuilder::_addLimitation(
                $aLimitations,
                'ad_active',
                'd.status',
                OA_ENTITY_STATUS_RUNNING,
                $aParams['ad_active'] == 't' ? MAX_LIMITATION_EQUAL : MAX_LIMITATION_NOT_EQUAL
            );
        }
        if (!empty($aParams['placement_active'])) {
            SqlBuilder::_addLimitation(
                $aLimitations,
                'placement_active',
                'm.status',
                OA_ENTITY_STATUS_RUNNING,
                $aParams['placement_active'] == 't' ? MAX_LIMITATION_EQUAL : MAX_LIMITATION_NOT_EQUAL
            );
        }
        if (!empty($aParams['placement_anonymous'])) {
            SqlBuilder::_addLimitation($aLimitations, 'placement_anonymous', 'm.anonymous', $aParams['placement_anonymous']);
        }
        if (!empty($aParams['zone_inventory_forecast_type'])) {
            SqlBuilder::_addLimitation($aLimitations, 'zone_inventory_forecast_type', 'z.inventory_forecast_type', $aParams['zone_inventory_forecast_type'], MAX_LIMITATION_BITWISE);
        }

        switch ($entity) {

        case 'ad':
            if (!empty($aParams['agency_id'])) {
                SqlBuilder::_addLimitation($aLimitations, 'agency_id', 'a.agencyid', $aParams['agency_id']);
            }
            if (!empty($aParams['advertiser_id'])) {
                SqlBuilder::_addLimitation($aLimitations, 'advertiser_id', 'm.clientid', $aParams['advertiser_id']);
            }
            if (!empty($aParams['placement_id'])) {
                SqlBuilder::_addLimitation($aLimitations, 'placement_id', 'd.campaignid', $aParams['placement_id']);
            }
            if (!empty($aParams['ad_id'])) {
                SqlBuilder::_addLimitation($aLimitations, 'ad_id', 'd.bannerid', $aParams['ad_id']);
            }
            break;

        case 'advertiser':
            if (!empty($aParams['agency_id'])) {
                SqlBuilder::_addLimitation($aLimitations, 'agency_id', 'a.agencyid', $aParams['agency_id']);
            }
            if (!empty($aParams['advertiser_id'])) {
                SqlBuilder::_addLimitation($aLimitations, 'advertiser_id', 'a.clientid', $aParams['advertiser_id']);
            }
            if (!empty($aParams['placement_id'])) {
                SqlBuilder::_addLimitation($aLimitations, 'placement_id', 'm.campaignid', $aParams['placement_id']);
            }
            if (!empty($aParams['ad_id'])) {
                SqlBuilder::_addLimitation($aLimitations, 'ad_id', 'd.bannerid', $aParams['ad_id']);
            }
            break;

        case 'ad_category_assoc':
            if (!empty($aParams['agency_id'])) {
                SqlBuilder::_addLimitation($aLimitations, 'agency_id', 'c.agencyid', $aParams['agency_id']);
            }
            if (!empty($aParams['advertiser_id'])) {
                SqlBuilder::_addLimitation($aLimitations, 'advertiser_id', 'm.clientid', $aParams['advertiser_id']);
            }
            if (!empty($aParams['placement_id'])) {
                SqlBuilder::_addLimitation($aLimitations, 'placement_id', 'd.campaignid', $aParams['placement_id']);
            }
            if (!empty($aParams['ad_id'])) {
                SqlBuilder::_addLimitation($aLimitations, 'ad_id', 'ac.ad_id', $aParams['ad_id']);
            }
            if (!empty($aParams['ad_category_assoc_id'])) {
                SqlBuilder::_addLimitation($aLimitations, 'ad_category_assoc_id', 'ac.ad_category_assoc_id', $aParams['ad_category_assoc_id']);
            }
            break;

        case 'ad_zone_assoc':
            if (!empty($aParams['agency_id'])) {
                SqlBuilder::_addLimitation($aLimitations, 'agency_id', 'p.agencyid', $aParams['agency_id']);
                SqlBuilder::_addLimitation($aLimitations, 'agency_id', 'a.agencyid', $aParams['agency_id']);
            }
            if (!empty($aParams['publisher_id'])) {
                SqlBuilder::_addLimitation($aLimitations, 'publisher_id', 'z.affiliateid', $aParams['publisher_id']);
            }
            if (!empty($aParams['advertiser_id'])) {
                SqlBuilder::_addLimitation($aLimitations, 'advertiser_id', 'm.clientid', $aParams['advertiser_id']);
            }
            if (!empty($aParams['zone_id'])) {
                SqlBuilder::_addLimitation($aLimitations, 'zone_id', 'az.zone_id', $aParams['zone_id']);
            }
            if (!empty($aParams['placement_id'])) {
                SqlBuilder::_addLimitation($aLimitations, 'placement_id', 'd.campaignid', $aParams['placement_id']);
            }
            if (!empty($aParams['ad_id'])) {
                SqlBuilder::_addLimitation($aLimitations, 'ad_id', 'az.ad_id', $aParams['ad_id']);
            }
            if (!empty($aParams['ad_zone_assoc_id'])) {
                SqlBuilder::_addLimitation($aLimitations, 'ad_zone_assoc_id', 'az.ad_zone_assoc_id', $aParams['ad_zone_assoc_id']);
            }
            break;

        case 'agency':
            if (!empty($aParams['agency_id'])) {
                SqlBuilder::_addLimitation($aLimitations, 'agency_id', 'g.agencyid', $aParams['agency_id']);
            }
            if (!empty($aParams['advertiser_id'])) {
                SqlBuilder::_addLimitation($aLimitations, 'advertiser_id', 'a.clientid', $aParams['advertiser_id']);
            }
            if (!empty($aParams['placement_id'])) {
                SqlBuilder::_addLimitation($aLimitations, 'placement_id', 'm.campaignid', $aParams['placement_id']);
            }
            if (!empty($aParams['ad_id'])) {
                SqlBuilder::_addLimitation($aLimitations, 'ad_id', 'd.bannerid', $aParams['ad_id']);
            }
            if (!empty($aParams['publisher_id'])) {
                SqlBuilder::_addLimitation($aLimitations, 'publisher_id', 'p.affiliateid', $aParams['publisher_id']);
            }
            if (!empty($aParams['zone_id'])) {
                SqlBuilder::_addLimitation($aLimitations, 'zone_id', 'z.zoneid', $aParams['zone_id']);
            }
            break;

        case 'campaign':
            if (!empty($aParams['client_id'])) {
                SqlBuilder::_addLimitation($aLimitations, 'client_id', 'cam.clientid', $aParams['client_id']);
            }
            break;

        case 'category':
            if (!empty($aParams['name'])) {
                SqlBuilder::_addLimitation($aLimitations, 'name', 'cat.name', $aParams['name']);
            }
            break;

        case 'channel':
            if (isset($aParams['publisher_id'])) {
                SqlBuilder::_addLimitation($aLimitations, 'publisher_id', 'ch.affiliateid', $aParams['publisher_id']);
            } elseif (isset($aParams['channel_type']) && $aParams['channel_type'] == 'publisher') {
                SqlBuilder::_addLimitation($aLimitations, 'publisher_id', 'ch.affiliateid', 0, MAX_LIMITATION_NOT_EQUAL);
            }
            if (!empty($aParams['channel_id'])) {
                SqlBuilder::_addLimitation($aLimitations, 'channel_id', 'ch.channelid', $aParams['channel_id']);
            }
            if (isset($aParams['agency_id'])) {
                SqlBuilder::_addLimitation($aLimitations, 'agency_id', 'agencyid', $aParams['agency_id']);
                SqlBuilder::_addLimitation($aLimitations, 'publisher_id', 'ch.affiliateid', 0);
            }
            break;

        case 'channel_limitation':
            if (!empty($aParams['channel_id'])) {
                SqlBuilder::_addLimitation($aLimitations, 'channel_id', 'chl.channelid', $aParams['channel_id']);
            }
            break;

        case 'image':
            if (!empty($aParams['file_name'])) {
                SqlBuilder::_addLimitation($aLimitations, 'file_name', 'i.filename', $aParams['file_name']);
            }
            break;

        case 'limitation':
            if (!empty($aParams['agency_id'])) {
                SqlBuilder::_addLimitation($aLimitations, 'agency_id', 'c.agencyid', $aParams['agency_id']);
            }
            if (!empty($aParams['advertiser_id'])) {
                SqlBuilder::_addLimitation($aLimitations, 'advertiser_id', 'm.clientid', $aParams['advertiser_id']);
            }
            if (!empty($aParams['placement_id'])) {
                SqlBuilder::_addLimitation($aLimitations, 'placement_id', 'd.campaignid', $aParams['placement_id']);
            }
            if (!empty($aParams['ad_id'])) {
                SqlBuilder::_addLimitation($aLimitations, 'ad_id', 'l.bannerid', $aParams['ad_id']);
            }
            break;

        case 'placement':
            if (!empty($aParams['agency_id'])) {
                SqlBuilder::_addLimitation($aLimitations, 'agency_id', 'a.agencyid', $aParams['agency_id']);
            }
            if (!empty($aParams['advertiser_id'])) {
                SqlBuilder::_addLimitation($aLimitations, 'advertiser_id', 'm.clientid', $aParams['advertiser_id']);
            }
            if (!empty($aParams['placement_id'])) {
                SqlBuilder::_addLimitation($aLimitations, 'placement_id', 'm.campaignid', $aParams['placement_id']);
            }
            if (!empty($aParams['ad_id'])) {
                SqlBuilder::_addLimitation($aLimitations, 'ad_id', 'd.bannerid', $aParams['ad_id']);
            }
            break;

        case 'placement_tracker':
            if (!empty($aParams['agency_id'])) {
                SqlBuilder::_addLimitation($aLimitations, 'agency_id', 'c.agencyid', $aParams['agency_id']);
            }
            if (!empty($aParams['advertiser_id'])) {
                SqlBuilder::_addLimitation($aLimitations, 'advertiser_id', 'm.clientid', $aParams['advertiser_id']);
                SqlBuilder::_addLimitation($aLimitations, 'advertiser_id', 't.clientid', $aParams['advertiser_id']);
            }
            if (!empty($aParams['tracker_id'])) {
                SqlBuilder::_addLimitation($aLimitations, 'tracker_id', 'mt.trackerid', $aParams['tracker_id']);
            }
            if (!empty($aParams['placement_id'])) {
                SqlBuilder::_addLimitation($aLimitations, 'placement_id', 'mt.campaignid', $aParams['placement_id']);
            }
            break;

        case 'placement_zone_assoc':
            if (!empty($aParams['agency_id'])) {
                SqlBuilder::_addLimitation($aLimitations, 'agency_id', 'p.agencyid', $aParams['agency_id']);
                SqlBuilder::_addLimitation($aLimitations, 'agency_id', 'c.agencyid', $aParams['agency_id']);
            }
            if (!empty($aParams['publisher_id'])) {
                SqlBuilder::_addLimitation($aLimitations, 'publisher_id', 'z.affiliateid', $aParams['publisher_id']);
            }
            if (!empty($aParams['advertiser_id'])) {
                SqlBuilder::_addLimitation($aLimitations, 'advertiser_id', 'm.clientid', $aParams['advertiser_id']);
            }
            if (!empty($aParams['zone_id'])) {
                SqlBuilder::_addLimitation($aLimitations, 'zone_id', 'pz.zone_id', $aParams['zone_id']);
            }
            if (!empty($aParams['placement_id'])) {
                SqlBuilder::_addLimitation($aLimitations, 'placement_id', 'pz.placement_id', $aParams['placement_id']);
            }
            if (!empty($aParams['ad_id'])) {
                SqlBuilder::_addLimitation($aLimitations, 'ad_id', 'd.bannerid', $aParams['ad_id']);
            }
            if (!empty($aParams['placement_zone_assoc_id'])) {
                SqlBuilder::_addLimitation($aLimitations, 'placement_zone_assoc_id', 'pz.placement_zone_assoc_id', $aParams['placement_zone_assoc_id']);
            }
            break;

        case 'publisher':
            if (!empty($aParams['agency_id'])) {
                SqlBuilder::_addLimitation($aLimitations, 'agency_id', 'p.agencyid', $aParams['agency_id']);
            }
            if (!empty($aParams['publisher_id'])) {
                SqlBuilder::_addLimitation($aLimitations, 'publisher_id', 'p.affiliateid', $aParams['publisher_id']);
            }
            if (!empty($aParams['zone_id'])) {
                SqlBuilder::_addLimitation($aLimitations, 'zone_id', 'z.zoneid', $aParams['zone_id']);
            }
            break;

        case 'history_span':
        case 'history_day_hour':
        case 'history_day':
        case 'history_month':
        case 'history_dow':
        case 'history_hour':
        case 'stats':
            if (!empty($aParams['agency_id'])) {
                $aLimitations[] = "(a.agencyid = {$aParams['agency_id']} OR p.agencyid = {$aParams['agency_id']})";
            }

            if (!empty($aParams['publisher_id'])) {
                SqlBuilder::_addLimitation($aLimitations, 'publisher_id', 'z.affiliateid', $aParams['publisher_id']);
            }
            if (!empty($aParams['advertiser_id'])) {
                SqlBuilder::_addLimitation($aLimitations, 'advertiser_id', 'm.clientid', $aParams['advertiser_id']);
            }
            if (isset($aParams['zone_id'])) {
                SqlBuilder::_addLimitation($aLimitations, 'zone_id', 's.zone_id', $aParams['zone_id']);
            }
            if (!empty($aParams['placement_id'])) {
                SqlBuilder::_addLimitation($aLimitations, 'placement_id', 'd.campaignid', $aParams['placement_id']);
            }
            if (isset($aParams['ad_id'])) {
                SqlBuilder::_addLimitation($aLimitations, 'ad_id', 's.ad_id', $aParams['ad_id']);
            }

            if (!empty($aParams['custom_table']) && $aParams['custom_table'] == 'data_intermediate_ad_connection') {
                $dateTimeCol = "s.tracker_date_time";
            } else {
                $dateTimeCol = "s.date_time";
            }
            if (!empty($aParams['day_begin'])) {
                $aLimitations[] = "{$dateTimeCol}>='" . SqlBuilder::_dayToDateTime($aParams['day_begin'], true) . "'";
            }
            if (!empty($aParams['day_end'])) {
                $aLimitations[] = "{$dateTimeCol}<='" . SqlBuilder::_dayToDateTime($aParams['day_end'], false) . "'";
            }

            break;

        case 'stats_by_entity':
            $aLimitations += SqlBuilder::_getLimitations('stats', $aParams);
            if (isset($aParams['zone_id']) && $aParams['zone_id'] == 0) {
                SqlBuilder::_addLimitation($aLimitations, 'zone_id', 's.zone_id', 0);
            }
            break;

        case 'tracker':
            if (!empty($aParams['agency_id'])) {
                SqlBuilder::_addLimitation($aLimitations, 'agency_id', 'a.agencyid', $aParams['agency_id']);
            }
            if (!empty($aParams['advertiser_id'])) {
                SqlBuilder::_addLimitation($aLimitations, 'advertiser_id', 't.clientid', $aParams['advertiser_id']);
            }
            if (!empty($aParams['tracker_id'])) {
                SqlBuilder::_addLimitation($aLimitations, 'tracker_id', 't.trackerid', $aParams['tracker_id']);
            }
            if (!empty($aParams['placement_id'])) {
                SqlBuilder::_addLimitation($aLimitations, 'placement_id', 'mt.campaignid', $aParams['placement_id']);
            }
            if (!empty($aParams['ad_id'])) {
                SqlBuilder::_addLimitation($aLimitations, 'ad_id', 'd.bannerid', $aParams['ad_id']);
            }
            break;

        case 'variable':
            if (!empty($aParams['agency_id'])) {
                SqlBuilder::_addLimitation($aLimitations, 'agency_id', 'a.agencyid', $aParams['agency_id']);
            }
            if (!empty($aParams['advertiser_id'])) {
                SqlBuilder::_addLimitation($aLimitations, 'advertiser_id', 't.clientid', $aParams['advertiser_id']);
            }
            if (!empty($aParams['tracker_id'])) {
                SqlBuilder::_addLimitation($aLimitations, 'tracker_id', 'v.trackerid', $aParams['tracker_id']);
            }
            if (!empty($aParams['variable_id'])) {
                SqlBuilder::_addLimitation($aLimitations, 'variable_id', 'v.variableid', $aParams['variable_id']);
            }
            break;

        case 'zone':
            if (!empty($aParams['agency_id'])) {
                SqlBuilder::_addLimitation($aLimitations, 'agency_id', 'p.agencyid', $aParams['agency_id']);
            }
            if (!empty($aParams['publisher_id'])) {
                SqlBuilder::_addLimitation($aLimitations, 'publisher_id', 'z.affiliateid', $aParams['publisher_id']);
            }
            if (isset($aParams['zone_id'])) {
                SqlBuilder::_addLimitation($aLimitations, 'zone_id', 'z.zoneid', $aParams['zone_id']);
            }
            if (isset($aParams['zone_type'])) {
                SqlBuilder::_addLimitation($aLimitations, 'zone_type', 'z.delivery', $aParams['zone_type']);
            }
            if (isset($aParams['zone_width'])) {
                SqlBuilder::_addLimitation($aLimitations, 'zone_width', 'z.width', $aParams['zone_width']);
            }
            if (isset($aParams['zone_height'])) {
                SqlBuilder::_addLimitation($aLimitations, 'zone_height', 'z.height', $aParams['zone_height']);
            }
            break;
        }
        return $aLimitations;
    }

    public static function _dayToDateTime($day, $begin = true)
    {
        $oDate = new Date($day);
        if (!$begin) {
            $oDate->setHour(23);
            $oDate->setMinute(59);
            $oDate->setSecond(59);
        }
        $oDate->toUTC();

        return $oDate->format('%Y-%m-%d %H:%M:%S');
    }

    /**
     * Builds the limitations array.
     *
     * @param array $aLimitations
     * @param string $entityIdName
     * @param string $columnName
     * @param string $value
     * @param string $comparison_type (optional)
     */
    public static function _addLimitation(&$aLimitations, $entityIdName, $columnName, $value, $comparison_type = MAX_LIMITATION_EQUAL)
    {
        // Add single quotes around non-integer columns
        if (($entityIdName == 'ad_type')
         || ($entityIdName == 'ad_active')
         || ($entityIdName == 'placement_active')
         || ($entityIdName == 'placement_anonymous')
        ) {
            $value = "'" . str_replace(',', "','", $value) . "'";
        }

        // If there are multiple values, use IN instead of =
        if (strpos($value, ',') !== false) {
            $aLimitations[] = "$columnName IN ($value)";
        } else {
            switch ($comparison_type) {
            case MAX_LIMITATION_NOT_EQUAL:
                $aLimitations[] = "$columnName != $value";
                break;
            case MAX_LIMITATION_BITWISE:
                $aLimitations[] = "($columnName & $value > 0)";
                break;
            default:
                $aLimitations[] = "$columnName = $value";
                break;
            }
        }
    }

    /**
     * Returns an array of constraints given an entity with params.
     *
     * @param string $entity
     * @param array $aParams
     * @return array
     */
    public static function _getStatsLimitations($entity, $aParams)
    {
        $aLimitations = [];

        if (!empty($aParams['agency_id'])) {
            switch ($entity) {
                case 'advertiser':
                case 'placement':
                case 'ad':
                    $aLimitations[] = "a.agencyid={$aParams['agency_id']}";
                    break;
                case 'publisher':
                case 'zone':
                    $aLimitations[] = "p.agencyid={$aParams['agency_id']}";
                    break;
                default:
                    $aLimitations[] = "(a.agencyid={$aParams['agency_id']} OR p.agencyid={$aParams['agency_id']})";
            }
        }

        if (!empty($aParams['publisher_id'])) {
            SqlBuilder::_addLimitation($aLimitations, 'publisher_id', 'z.affiliateid', $aParams['publisher_id']);
        }
        if (!empty($aParams['advertiser_id'])) {
            SqlBuilder::_addLimitation($aLimitations, 'advertiser_id', 'm.clientid', $aParams['advertiser_id']);
        }
        if (!empty($aParams['zone_id'])) {
            SqlBuilder::_addLimitation($aLimitations, 'zone_id', 's.zone_id', $aParams['zone_id']);
        }
        if (!empty($aParams['placement_id'])) {
            SqlBuilder::_addLimitation($aLimitations, 'placement_id', 'd.campaignid', $aParams['placement_id']);
        }
        if (!empty($aParams['ad_id'])) {
            SqlBuilder::_addLimitation($aLimitations, 'ad_id', 's.ad_id', $aParams['ad_id']);
        }
        if (!empty($aParams['day_begin'])) {
            $aLimitations[] = "s.date_time>='{$aParams['day_begin']}'";
        }
        if (!empty($aParams['day_end'])) {
            $aLimitations[] = "s.date_time<='{$aParams['day_end']}'";
        }

        return $aLimitations;
    }

    /**
     * Builds an array of contraints given a list of tables.
     *
     * @todo Added some code specific for data_summary_ad_arrival_hourly table
     *
     * @param array $aTables
     * @param array $aParams
     * @return array
     */
    public static function _getTableLimitations($aTables, $aParams = [])
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $aTableLimitations = [];
        if (!empty($aTables[$conf['table']['prefix'] . $conf['table']['agency']]) && (!empty($aTables[$conf['table']['prefix'] . $conf['table']['clients']]))) {
            $aTableLimitations[] = 'g.agencyid=a.agencyid';
        }
        if (!empty($aTables[$conf['table']['prefix'] . $conf['table']['agency']]) && (!empty($aTables[$conf['table']['prefix'] . $conf['table']['affiliates']]))) {
            $aTableLimitations[] = 'g.agencyid=p.agencyid';
        }
        if (!empty($aTables[$conf['table']['prefix'] . $conf['table']['affiliates']]) && (!empty($aTables[$conf['table']['prefix'] . $conf['table']['zones']]))) {
            $aTableLimitations[] = 'p.affiliateid=z.affiliateid';
        }
        if (!empty($aTables[$conf['table']['prefix'] . $conf['table']['clients']]) && (!empty($aTables[$conf['table']['prefix'] . $conf['table']['campaigns']]))) {
            $aTableLimitations[] = 'a.clientid=m.clientid';
        }
        if (!empty($aTables[$conf['table']['prefix'] . $conf['table']['clients']]) && (!empty($aTables[$conf['table']['prefix'] . $conf['table']['trackers']]))) {
            $aTableLimitations[] = 'a.clientid=t.clientid';
        }
        if (!empty($aTables[$conf['table']['prefix'] . $conf['table']['campaigns']]) && (!empty($aTables[$conf['table']['prefix'] . $conf['table']['banners']]))) {
            $aTableLimitations[] = 'm.campaignid=d.campaignid';
        }
        if (!empty($aTables[$conf['table']['prefix'] . $conf['table']['campaigns']]) && (!empty($aTables[$conf['table']['prefix'] . $conf['table']['placement_zone_assoc']]))) {
            $aTableLimitations[] = 'm.campaignid=pz.placement_id';
        }
        if (!empty($aTables[$conf['table']['prefix'] . $conf['table']['campaigns']]) && (!empty($aTables[$conf['table']['prefix'] . $conf['table']['campaigns_trackers']]))) {
            $aTableLimitations[] = 'm.campaignid=mt.campaignid';
        }
        if (!empty($aTables[$conf['table']['prefix'] . $conf['table']['trackers']]) && (!empty($aTables[$conf['table']['prefix'] . $conf['table']['campaigns_trackers']]))) {
            $aTableLimitations[] = 't.trackerid=mt.trackerid';
        }
        if (!empty($aTables[$conf['table']['prefix'] . $conf['table']['banners']]) && (!empty($aTables[$conf['table']['prefix'] . $conf['table']['data_summary_ad_hourly']]))) {
            $aTableLimitations[] = 'd.bannerid=s.ad_id';
        }
        if (!empty($aTables[$conf['table']['prefix'] . $conf['table']['banners']]) && (!empty($aTables[$conf['table']['prefix'] . $conf['table']['data_intermediate_ad_connection']]))) {
            $aTableLimitations[] = 'd.bannerid=s.ad_id';
        }
        if (!empty($aTables[$conf['table']['prefix'] . $conf['table']['banners']]) && (!empty($aTables[$conf['table']['prefix'] . $conf['table']['ad_category_assoc']]))) {
            $aTableLimitations[] = 'd.bannerid=ac.ad_id';
        }
        if (!empty($aTables[$conf['table']['prefix'] . $conf['table']['banners']]) && (!empty($aTables[$conf['table']['prefix'] . $conf['table']['ad_zone_assoc']]))) {
            $aTableLimitations[] = 'd.bannerid=az.ad_id';
        }
        if (!empty($aTables[$conf['table']['prefix'] . $conf['table']['banners']]) && (!empty($aTables[$conf['table']['prefix'] . $conf['table']['acls']]))) {
            $aTableLimitations[] = 'd.bannerid=l.bannerid';
        }
        if (!empty($aTables[$conf['table']['prefix'] . $conf['table']['zones']]) && (!empty($aTables[$conf['table']['prefix'] . $conf['table']['data_summary_ad_hourly']]))) {
            $aTableLimitations[] = 'z.zoneid=s.zone_id';
        }
        if (!empty($aTables[$conf['table']['prefix'] . $conf['table']['zones']]) && (!empty($aTables[$conf['table']['prefix'] . $conf['table']['data_intermediate_ad_connection']]))) {
            $aTableLimitations[] = 'z.zoneid=s.zone_id';
        }
        if (!empty($aTables[$conf['table']['prefix'] . $conf['table']['zones']]) && (!empty($aTables[$conf['table']['prefix'] . $conf['table']['ad_zone_assoc']]))) {
            $aTableLimitations[] = 'z.zoneid=az.zone_id';
        }
        if (!empty($aTables[$conf['table']['prefix'] . $conf['table']['zones']]) && (!empty($aTables[$conf['table']['prefix'] . $conf['table']['placement_zone_assoc']]))) {
            $aTableLimitations[] = 'z.zoneid=pz.zone_id';
        }
        if (!empty($aTables[$conf['table']['prefix'] . $conf['table']['channel']]) && (!empty($aTables[$conf['table']['prefix'] . $conf['table']['affiliates']]))) {
            $aTableLimitations[] = 'p.affiliateid=ch.affiliateid';
        }
        return $aTableLimitations;
    }

    /**
     * Returns the grouping given the particular entity.
     *
     * @param string $entity
     * @param array $aParams
     * @return array
     */
    public static function _getGroupColumns($entity, $aParams)
    {
        $aGroupColumns = [];
        switch ($entity) {
            case 'history_day_hour': $aGroupColumns[] = 'date_time'; break;
            case 'history_day':      $aGroupColumns[] = 'day'; break;
            case 'history_month':    $aGroupColumns[] = 'month'; break;
            case 'history_dow':      $aGroupColumns[] = 'dow'; break;
            case 'history_hour':     $aGroupColumns[] = 'hour'; break;

            case 'stats_by_entity':
                $aGroupColumns = ['ad_id', 'zone_id'];
                if (isset($aParams['include'])) {
                    $aGroupColumns = array_merge($aGroupColumns, $aParams['include']);
                }
                if (isset($aParams['exclude'])) {
                    $aGroupColumns = array_diff($aGroupColumns, $aParams['exclude']);
                }
                break;
        }
        return count($aGroupColumns) ? $aGroupColumns : null;
    }

    /**
     * Returns the tables which need a LEFT JOIN given the particular entity.
     *
     * @param string $entity
     * @param array $aParams
     * @return array
     */
    public static function _getLeftJoinedTables($entity, $aParams, $aTables = null)
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $aLeftJoinedTables = [];
        switch ($entity) {

        case 'stats_by_entity':
            if (isset($aParams['exclude']) && !empty($aParams['agency_id'])) {
                if (array_search('ad_id', $aParams['exclude']) !== false) {
                    // include blanks and deleted entities in the stats
                    $aLeftJoinedTables[$conf['table']['prefix'] . $conf['table']['clients']] = 'a';
                    $aLeftJoinedTables[$conf['table']['prefix'] . $conf['table']['campaigns']] = 'm';
                    $aLeftJoinedTables[$conf['table']['prefix'] . $conf['table']['banners']] = 'd';
                }
                if (array_search('zone_id', $aParams['exclude']) !== false) {
                    // include direct selection and deleted entities in the stats
                    $aLeftJoinedTables[$conf['table']['prefix'] . $conf['table']['zones']] = 'z';
                    $aLeftJoinedTables[$conf['table']['prefix'] . $conf['table']['affiliates']] = 'p';
                }
            }
            break;
        case 'history_span':
        case 'history_day_hour':
        case 'history_day':
        case 'history_month':
        case 'history_dow':
        case 'history_hour':
            // include blanks, direct selection and deleted entities in history stats
            $aLeftJoinedTables[$conf['table']['prefix'] . $conf['table']['clients']] = 'a';
            $aLeftJoinedTables[$conf['table']['prefix'] . $conf['table']['campaigns']] = 'm';
            $aLeftJoinedTables[$conf['table']['prefix'] . $conf['table']['banners']] = 'd';
            $aLeftJoinedTables[$conf['table']['prefix'] . $conf['table']['zones']] = 'z';
            $aLeftJoinedTables[$conf['table']['prefix'] . $conf['table']['affiliates']] = 'p';
            break;
        }

        return count($aLeftJoinedTables) ? $aLeftJoinedTables : null;
    }

    // +---------------------------------------+
    // | SQL operations methods                |
    // |                                       |
    // | for entity builders                   |
    // +---------------------------------------+

    public static function _doDelete($table, $aParams)
    {
        $do = OA_Dal::factoryDO($table);
        if ($do === false) {
            return false;
        }
        $success = $do->setFrom($aParams);
        if (!$success === true) {
            return false;
        }
        return $do->delete();
    }


    /**
     * Performs an SQL insert.
     *
     * @param string $table Table name.
     * @param array $aVariables Map of column to value for the created row.
     * @return integer The newly inserted row id if the table has any
     * autoincrement field defined. Otherwise, true on success and false
     * on failure.
     */
    public static function _insert($table, $aVariables)
    {
        $do = OA_Dal::factoryDO($table);
        if ($do === false) {
            return false;
        }
        $success = $do->setFrom($aVariables);
        if (!$success === true) {
            return false;
        }
        return $do->insert();
    }


    public static function _getFieldIdName($table)
    {
        $dbh = OA_DB::singleton();
        $schema = MDB2_Schema::factory($dbh);
        $definition = $schema->getDefinitionFromDatabase([$table]);
        foreach ($definition['tables'][$table]['fields'] as $fieldname => $dataField) {
            if (isset($dataField['autoincrement']) && 1 == $dataField['autoincrement']) {
                return $fieldname;
            }
        }
        return null;
    }

    /**
     * Wraps an SQL query.
     *
     * @param array $aColumns
     * @param array $aTables
     * @param array $aLimitations
     * @param array $aGroupColumns
     * @param string $primaryKey
     * @param array $aLeftJoinedTables
     * @return integer  The number of rows affected by the query
     */
    public static function _select($aColumns, $aTables, $aLimitations, $aGroupColumns, $primaryKey, $aLeftJoinedTables = null)
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $oDbh = OA_DB::singleton();
        $columns = '';
        if (is_array($aColumns)) {
            foreach ($aColumns as $column => $alias) {
                $columns .= ($columns == '') ? "SELECT $column AS $alias" : ",$column AS $alias";
            }
        } else {
            $columns = "SELECT $aColumns";
        }

        $prev_aliases = [];
        $tables = '';
        if (is_array($aTables)) {
            $x = 0;
            if (!is_null($aLeftJoinedTables)) {
                $aTables = array_diff($aTables, $aLeftJoinedTables);
            }
            $joinType = 'INNER';
            while (count($aTables) && $x < 50) {
                $x++;
                foreach ($aTables as $tableKey => $alias) {
                    $table = $tableKey;

                    //  check for prefix
                    if (!empty($conf['table']['prefix']) && strpos($table, $conf['table']['prefix']) != 0) {
                        $table = $conf['table']['prefix'] . $table;
                    }

                    $qTable = $oDbh->quoteIdentifier($table, true);

                    $joinLimitation = '';

                    if (count($prev_aliases)) {
                        if (is_array($aLimitations)) {
                            foreach ($aLimitations as $limitationKey => $limitation) {
                                if (preg_match("/({$alias}\.[a-z0-9_]+ *= *(" . join('|', $prev_aliases) . ")\..+|(" . join('|', $prev_aliases) . ")\.[a-z0-9_]+ *= *{$alias}\..+)/", $limitation)) {
                                    $joinLimitation = $limitation;
                                    unset($aLimitations[$limitationKey]);
                                    break;
                                }
                            }
                        }
                    } else {
                        $tables .= " FROM $qTable AS $alias";
                    }

                    if ($joinLimitation) {
                        $tables .= " $joinType JOIN $qTable AS $alias ON ($joinLimitation)";
                    } elseif (count($prev_aliases)) {
                        continue;
                    }

                    $prev_aliases[] = $alias;
                    unset($aTables[$tableKey]);
                }

                if (!is_null($aLeftJoinedTables) && !count($aTables)) {
                    $aTables = $aLeftJoinedTables;
                    $aLeftJoinedTables = null;
                    $joinType = 'LEFT';
                }
            }
        } else {
            $tables = "FROM " . $oDbh->quoteIdentifier($aTables, true);
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
        // var_dump($query);
        return  SqlBuilder::_query($query, $primaryKey);
    }

    /**
     * Performs an SQL query.
     *
     * @param string $query
     * @param string $primaryKey
     * @return array|false    An array of entity records
     */
    private static function _query($query, $primaryKey)
    {
        // var_dump($query);
        $oDbh = OA_DB::singleton();
        $aResult = $oDbh->queryAll($query);
        $aDataEntities = [];
        if (PEAR::isError($aResult)) {
            return false;
        }

        foreach ($aResult as $k => $dataEntity) {
            $aDataEntities[$dataEntity[$primaryKey]] = $dataEntity;
        }
        return $aDataEntities;
    }

    /**
     * Retieves a list of banner ids linked to the given agency
     *
     * @param string $agencyId
     * @return string A comma delimited list of banner ids
     */
    public static function _getBannerIdsForAgency($agencyId)
    {
        $conf = $GLOBALS['_MAX']['CONF'];
        $query = 'select d.bannerid as ad_id from ' .
            $conf['table']['prefix'] . $conf['table']['banners'] . ' AS d ' .
            'INNER JOIN ' .
            $conf['table']['prefix'] . $conf['table']['campaigns'] . ' AS m ' .
            'ON (m.campaignid=d.campaignid) ' .
            'INNER JOIN ' .
            $conf['table']['prefix'] . $conf['table']['clients'] . ' AS a ' .
            'ON (a.clientid=m.clientid) ' .
            'WHERE a.agencyid = ' . $agencyId . ' order by bannerid;';

        $oDbh = OA_DB::singleton();
        $aResult = $oDbh->queryAll($query);
        $aDataEntities = [];
        if (PEAR::isError($aResult)) {
            return false;
        }

        foreach ($aResult as $k => $dataEntity) {
            $aDataEntities[] = $dataEntity['ad_id'];
        }
        return implode(',', $aDataEntities);
    }

    private static function sqlKeyConcat($aArgs)
    {
        $oDbh = OA_DB::singleton();
        $isPgsql = $oDbh->dbsyntax == 'pgsql';

        $aData = [];
        foreach ($aArgs as $arg) {
            $aData[] = $arg;
            $aData[] = "'_'";
        }

        array_pop($aData);

        $sql = join($isPgsql ? '||' : ', ', $aData);

        return $isPgsql ? "({$sql})" : "CONCAT({$sql})";
    }
}
