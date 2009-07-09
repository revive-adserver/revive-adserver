<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
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

        $entities = array(
         'ad' => array (
                  'd.bannerid' => 'ad_id',
                  'd.campaignid' => 'placement_id',
                  'd.status' => 'status',
                  'd.description' => 'name',
                  'd.storagetype' => 'type',
                  'd.contenttype' => 'contenttype',
                  'd.pluginversion' => 'pluginversion',
                  'd.filename' => 'filename',
                  'd.imageurl' => 'imageurl',
                  'd.htmltemplate' => 'htmltemplate',
                  'd.htmlcache' => 'htmlcache',
                  'd.width' => 'width',
                  'd.height' => 'height',
                  'd.weight' => 'weight',
                  'd.seq' => 'seq',
                  'd.target' => 'target',
                  'd.url' => 'url',
                  'd.alt' => 'alt',
                  'd.statustext' => 'statustext',
                  'd.bannertext' => 'bannertext',
                  'd.adserver' => 'adserver',
                  'd.block' => 'block',
                  'd.capping' => 'capping',
                  'd.session_capping' => 'session_capping',
                  'd.compiledlimitation' => 'compiledlimitation',
                  'd.append' => 'append',
                  'd.appendtype' => 'appendtype',
                  'd.bannertype' => 'bannertype',
                  'd.alt_filename' => 'alt_filename',
                  'd.alt_imageurl' => 'alt_imageurl',
                  'd.alt_contenttype' => 'alt_contenttype',
                  'd.comments' => 'comments',
                  'd.transparent' => 'transparent',
                  'd.parameters' => 'parameters'
                ),
         'advertiser' => array (
                  'a.clientid' => 'advertiser_id',
                  'a.agencyid' => 'agency_id',
                  'a.clientname' => 'name',
                  'a.contact' => 'contact',
                  'a.email' => 'email',
                  'a.clientusername' => 'username',
                  'a.clientpassword' => 'password',
                  'a.permissions' => 'permissions',
                  'a.language' => 'language',
                  'a.report' => 'report',
                  'a.reportinterval' => 'report_interval',
                  'a.reportlastdate' => 'report_last_date',
                  'a.reportdeactivate' => 'report_deactivate'
                ),
         'ad_category_assoc' => array (
                  'ac.ad_category_assoc_id' => 'ad_category_assoc_id',
                  'ac.ad_id' => 'ad_id',
                  'ac.category_id' => 'category_id'
                ),
         'ad_zone_assoc' => array (
                  'az.ad_zone_assoc_id' => 'ad_zone_assoc_id',
                  'az.ad_id' => 'ad_id',
                  'az.zone_id' => 'zone_id',
                  'az.priority' => 'priority'
                ),
         'agency' => array (
                  'g.agencyid' => 'agency_id',
                  'g.name' => 'name',
                  'g.contact' => 'contact',
                  'g.email' => 'email',
                  'g.username' => 'username',
                  'g.password' => 'password',
                  'g.permissions' => 'permissions',
                  'g.language' => 'language',
                  'g.logout_url' => 'logout_url',
                  'g.active' => 'active'
                ),
         'category' => array (
                  'cat.category_id' => 'category_id',
                  'cat.name' => 'name'
                ),
         'image' => array (
                  'i.filename' => 'file_name',
                  'i.t_stamp' => 't_stamp',
                  'i.contents' => 'contents'
                ),
         'limitation' => array (
                  'l.bannerid' => 'ad_id',
                  'l.logical' => 'logical',
                  'l.type' => 'type',
                  'l.comparison' => 'comparison',
                  'l.data' => 'data',
                  'l.executionorder' => 'executionorder'
                ),
         'placement' => array (
                  'm.clientid' => 'advertiser_id',
                  'm.campaignid' => 'placement_id',
                  'm.campaignname' => 'name',
                  'm.status' => 'status',
                  'm.views' => 'views',
                  'm.clicks' => 'clicks',
                  'm.conversions' => 'conversions',
                  'm.expire_time' => 'expire_time',
                  'm.activate_time' => 'activate_time',
                  'm.priority' => 'priority',
                  'm.weight' => 'weight',
                  'm.target_impression' => 'target_impression',
                  'm.target_click' => 'target_click',
                  'm.target_conversion' => 'target_conversion',
                  'm.anonymous' => 'anonymous'
                ),
         'placement_tracker' => array (
                  'mt.campaign_trackerid' => 'placement_tracker_id',
                  'mt.campaignid' => 'placement_id',
                  'mt.trackerid' => 'tracker_id',
                  'mt.status' => 'status',
                  'mt.viewwindow' => 'view_window',
                  'mt.clickwindow' => 'click_window'
                ),
         'placement_zone_assoc' => array (
                  'pz.placement_zone_assoc_id' => 'placement_zone_assoc_id',
                  'pz.placement_id' => 'placement_id',
                  'pz.zone_id' => 'zone_id'
                ),
         'publisher' => array (
                  'p.affiliateid' => 'publisher_id',
                  'p.agencyid' => 'agency_id',
                  'p.name' => 'name',
                  'p.mnemonic' => 'mnemonic',
                  'p.contact' => 'contact',
                  'p.email' => 'email',
                  'p.website' => 'website',
                  'p.username' => 'username',
                  'p.password' => 'password',
                  'p.permissions' => 'permissions',
                  'p.language' => 'language',
                  'p.publiczones' => 'publiczones'
                ),
         'stats' => array (
                  's.day' => 'day',
                  's.hour' => 'hour',
                  'SUM(s.requests)' => 'sum_requests',
                  'SUM(s.impressions)' => 'sum_views',
                  'SUM(s.clicks)' => 'sum_clicks',
                  'SUM(s.conversions)' => 'sum_conversions'
                ),
         'tracker' => array (
                  't.clientid' => 'advertiser_id',
                  't.trackerid' => 'tracker_id',
                  't.trackername' => 'name',
                  't.description' => 'description',
                  't.viewwindow' => 'viewwindow',
                  't.clickwindow' => 'clickwindow',
                  't.blockwindow' => 'blockwindow',
                  't.variablemethod' => 'variablemethod',
                  't.appendcode' => 'appendcode'
                ),
         'variable' => array (
                  'v.variableid' => 'variable_id',
                  'v.trackerid' => 'tracker_id',
                  'v.name' => 'name',
                  'v.datatype' => 'type',
                  'v.description' => 'description',
                  'v.variablecode' => 'variablecode'
                ),
         'zone' => array (
                  'z.zoneid' => 'zone_id',
                  'z.affiliateid' => 'publisher_id',
                  'z.zonename' => 'name',
                  'z.delivery' => 'type',
                  'z.description' => 'description',
                  'z.width' => 'width',
                  'z.height' => 'height',
                  'z.chain' => 'chain',
                  'z.prepend' => 'prepend',
                  'z.append' => 'append',
                  'z.appendtype' => 'appendtype',
                  'z.forceappend' => 'forceappend',
                  'z.inventory_forecast_type' => 'inventory_forecast_type',
                  'z.comments' => 'comments',
                  'z.cost' => 'cost',
                  'z.cost_type' => 'cost_type',
                  'z.cost_variable_id' => 'cost_variable_id',
                  'z.technology_cost' => 'technology_cost',
                  'z.technology_cost_type' => 'technology_cost_type',
                  'z.block' => 'block',
                  'z.capping' => 'capping',
                  'z.session_capping' => 'session_capping',
                  'z.category' => 'category',
                  'z.ad_selection' => 'ad_selection'
                )
         );

?>