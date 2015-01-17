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

require_once(MAX_PATH.'/lib/OA/Upgrade/Migration.php');

class Migration_505 extends Migration
{

    function __construct()
    {
        //$this->__construct();

		$this->aTaskList_constructive[] = 'beforeAlterField__acls_channel__logical';
		$this->aTaskList_constructive[] = 'afterAlterField__acls_channel__logical';
		$this->aTaskList_constructive[] = 'beforeAddIndex__ad_zone_assoc__ad_zone_assoc_zone_id';
		$this->aTaskList_constructive[] = 'afterAddIndex__ad_zone_assoc__ad_zone_assoc_zone_id';
		$this->aTaskList_constructive[] = 'beforeRemoveIndex__ad_zone_assoc__zone_id';
		$this->aTaskList_constructive[] = 'afterRemoveIndex__ad_zone_assoc__zone_id';
		$this->aTaskList_constructive[] = 'beforeAddIndex__affiliates__affiliates_agencyid';
		$this->aTaskList_constructive[] = 'afterAddIndex__affiliates__affiliates_agencyid';
		$this->aTaskList_constructive[] = 'beforeRemoveIndex__affiliates__agencyid';
		$this->aTaskList_constructive[] = 'afterRemoveIndex__affiliates__agencyid';
		$this->aTaskList_constructive[] = 'beforeAddIndex__banners__banners_campaignid';
		$this->aTaskList_constructive[] = 'afterAddIndex__banners__banners_campaignid';
		$this->aTaskList_constructive[] = 'beforeRemoveIndex__banners__campaignid';
		$this->aTaskList_constructive[] = 'afterRemoveIndex__banners__campaignid';
		$this->aTaskList_constructive[] = 'beforeAddField__campaigns__block';
		$this->aTaskList_constructive[] = 'afterAddField__campaigns__block';
		$this->aTaskList_constructive[] = 'beforeAddField__campaigns__capping';
		$this->aTaskList_constructive[] = 'afterAddField__campaigns__capping';
		$this->aTaskList_constructive[] = 'beforeAddField__campaigns__session_capping';
		$this->aTaskList_constructive[] = 'afterAddField__campaigns__session_capping';
		$this->aTaskList_constructive[] = 'beforeAddIndex__campaigns__campaigns_clientid';
		$this->aTaskList_constructive[] = 'afterAddIndex__campaigns__campaigns_clientid';
		$this->aTaskList_constructive[] = 'beforeRemoveIndex__campaigns__clientid';
		$this->aTaskList_constructive[] = 'afterRemoveIndex__campaigns__clientid';
		$this->aTaskList_constructive[] = 'beforeAddIndex__campaigns_trackers__campaigns_trackers_campaignid';
		$this->aTaskList_constructive[] = 'afterAddIndex__campaigns_trackers__campaigns_trackers_campaignid';
		$this->aTaskList_constructive[] = 'beforeAddIndex__campaigns_trackers__campaigns_trackers_trackerid';
		$this->aTaskList_constructive[] = 'afterAddIndex__campaigns_trackers__campaigns_trackers_trackerid';
		$this->aTaskList_constructive[] = 'beforeRemoveIndex__campaigns_trackers__campaignid';
		$this->aTaskList_constructive[] = 'afterRemoveIndex__campaigns_trackers__campaignid';
		$this->aTaskList_constructive[] = 'beforeRemoveIndex__campaigns_trackers__trackerid';
		$this->aTaskList_constructive[] = 'afterRemoveIndex__campaigns_trackers__trackerid';
		$this->aTaskList_constructive[] = 'beforeAddIndex__clients__clients_agencyid';
		$this->aTaskList_constructive[] = 'afterAddIndex__clients__clients_agencyid';
		$this->aTaskList_constructive[] = 'beforeRemoveIndex__clients__agencyid';
		$this->aTaskList_constructive[] = 'afterRemoveIndex__clients__agencyid';
		$this->aTaskList_constructive[] = 'beforeAlterField__data_intermediate_ad__total_num_items';
		$this->aTaskList_constructive[] = 'afterAlterField__data_intermediate_ad__total_num_items';
		$this->aTaskList_constructive[] = 'beforeAddField__data_intermediate_ad_connection__tracker_channel_ids';
		$this->aTaskList_constructive[] = 'afterAddField__data_intermediate_ad_connection__tracker_channel_ids';
		$this->aTaskList_constructive[] = 'beforeAddField__data_intermediate_ad_connection__connection_channel_ids';
		$this->aTaskList_constructive[] = 'afterAddField__data_intermediate_ad_connection__connection_channel_ids';
		$this->aTaskList_constructive[] = 'beforeAddField__data_raw_ad_click__channel_ids';
		$this->aTaskList_constructive[] = 'afterAddField__data_raw_ad_click__channel_ids';
		$this->aTaskList_constructive[] = 'beforeAddField__data_raw_ad_impression__channel_ids';
		$this->aTaskList_constructive[] = 'afterAddField__data_raw_ad_impression__channel_ids';
		$this->aTaskList_constructive[] = 'beforeAddField__data_raw_ad_request__channel_ids';
		$this->aTaskList_constructive[] = 'afterAddField__data_raw_ad_request__channel_ids';
		$this->aTaskList_constructive[] = 'beforeAddField__data_raw_tracker_click__channel_ids';
		$this->aTaskList_constructive[] = 'afterAddField__data_raw_tracker_click__channel_ids';
		$this->aTaskList_constructive[] = 'beforeAddField__data_raw_tracker_impression__channel_ids';
		$this->aTaskList_constructive[] = 'afterAddField__data_raw_tracker_impression__channel_ids';
		$this->aTaskList_constructive[] = 'beforeAlterField__data_summary_ad_hourly__total_num_items';
		$this->aTaskList_constructive[] = 'afterAlterField__data_summary_ad_hourly__total_num_items';
		$this->aTaskList_constructive[] = 'beforeAddIndex__data_summary_zone_country_daily__data_summary_zone_country_daily_day';
		$this->aTaskList_constructive[] = 'afterAddIndex__data_summary_zone_country_daily__data_summary_zone_country_daily_day';
		$this->aTaskList_constructive[] = 'beforeAddIndex__data_summary_zone_country_daily__data_summary_zone_country_daily_zone_id';
		$this->aTaskList_constructive[] = 'afterAddIndex__data_summary_zone_country_daily__data_summary_zone_country_daily_zone_id';
		$this->aTaskList_constructive[] = 'beforeRemoveIndex__data_summary_zone_country_daily__day';
		$this->aTaskList_constructive[] = 'afterRemoveIndex__data_summary_zone_country_daily__day';
		$this->aTaskList_constructive[] = 'beforeRemoveIndex__data_summary_zone_country_daily__zone_id';
		$this->aTaskList_constructive[] = 'afterRemoveIndex__data_summary_zone_country_daily__zone_id';
		$this->aTaskList_constructive[] = 'beforeAddIndex__data_summary_zone_country_forecast__data_summary_zone_country_forecast_day_of_week';
		$this->aTaskList_constructive[] = 'afterAddIndex__data_summary_zone_country_forecast__data_summary_zone_country_forecast_day_of_week';
		$this->aTaskList_constructive[] = 'beforeAddIndex__data_summary_zone_country_forecast__data_summary_zone_country_forecast_zone_id';
		$this->aTaskList_constructive[] = 'afterAddIndex__data_summary_zone_country_forecast__data_summary_zone_country_forecast_zone_id';
		$this->aTaskList_constructive[] = 'beforeRemoveIndex__data_summary_zone_country_forecast__day_of_week';
		$this->aTaskList_constructive[] = 'afterRemoveIndex__data_summary_zone_country_forecast__day_of_week';
		$this->aTaskList_constructive[] = 'beforeRemoveIndex__data_summary_zone_country_forecast__zone_id';
		$this->aTaskList_constructive[] = 'afterRemoveIndex__data_summary_zone_country_forecast__zone_id';
		$this->aTaskList_constructive[] = 'beforeAddIndex__data_summary_zone_country_monthly__data_summary_zone_country_monthly_yearmonth';
		$this->aTaskList_constructive[] = 'afterAddIndex__data_summary_zone_country_monthly__data_summary_zone_country_monthly_yearmonth';
		$this->aTaskList_constructive[] = 'beforeAddIndex__data_summary_zone_country_monthly__data_summary_zone_country_monthly_zone_id';
		$this->aTaskList_constructive[] = 'afterAddIndex__data_summary_zone_country_monthly__data_summary_zone_country_monthly_zone_id';
		$this->aTaskList_constructive[] = 'beforeRemoveIndex__data_summary_zone_country_monthly__yearmonth';
		$this->aTaskList_constructive[] = 'afterRemoveIndex__data_summary_zone_country_monthly__yearmonth';
		$this->aTaskList_constructive[] = 'beforeRemoveIndex__data_summary_zone_country_monthly__zone_id';
		$this->aTaskList_constructive[] = 'afterRemoveIndex__data_summary_zone_country_monthly__zone_id';
		$this->aTaskList_constructive[] = 'beforeAddIndex__data_summary_zone_domain_page_daily__data_summary_zone_domain_page_daily_day';
		$this->aTaskList_constructive[] = 'afterAddIndex__data_summary_zone_domain_page_daily__data_summary_zone_domain_page_daily_day';
		$this->aTaskList_constructive[] = 'beforeAddIndex__data_summary_zone_domain_page_daily__data_summary_zone_domain_page_daily_zone_id';
		$this->aTaskList_constructive[] = 'afterAddIndex__data_summary_zone_domain_page_daily__data_summary_zone_domain_page_daily_zone_id';
		$this->aTaskList_constructive[] = 'beforeRemoveIndex__data_summary_zone_domain_page_daily__day';
		$this->aTaskList_constructive[] = 'afterRemoveIndex__data_summary_zone_domain_page_daily__day';
		$this->aTaskList_constructive[] = 'beforeRemoveIndex__data_summary_zone_domain_page_daily__zone_id';
		$this->aTaskList_constructive[] = 'afterRemoveIndex__data_summary_zone_domain_page_daily__zone_id';
		$this->aTaskList_constructive[] = 'beforeAddIndex__data_summary_zone_domain_page_forecast__data_summary_zone_domain_page_forecast_day_of_week';
		$this->aTaskList_constructive[] = 'afterAddIndex__data_summary_zone_domain_page_forecast__data_summary_zone_domain_page_forecast_day_of_week';
		$this->aTaskList_constructive[] = 'beforeAddIndex__data_summary_zone_domain_page_forecast__data_summary_zone_domain_page_forecast_zone_id';
		$this->aTaskList_constructive[] = 'afterAddIndex__data_summary_zone_domain_page_forecast__data_summary_zone_domain_page_forecast_zone_id';
		$this->aTaskList_constructive[] = 'beforeRemoveIndex__data_summary_zone_domain_page_forecast__day_of_week';
		$this->aTaskList_constructive[] = 'afterRemoveIndex__data_summary_zone_domain_page_forecast__day_of_week';
		$this->aTaskList_constructive[] = 'beforeRemoveIndex__data_summary_zone_domain_page_forecast__zone_id';
		$this->aTaskList_constructive[] = 'afterRemoveIndex__data_summary_zone_domain_page_forecast__zone_id';
		$this->aTaskList_constructive[] = 'beforeAddIndex__data_summary_zone_domain_page_monthly__data_summary_zone_domain_page_monthly_yearmonth';
		$this->aTaskList_constructive[] = 'afterAddIndex__data_summary_zone_domain_page_monthly__data_summary_zone_domain_page_monthly_yearmonth';
		$this->aTaskList_constructive[] = 'beforeAddIndex__data_summary_zone_domain_page_monthly__data_summary_zone_domain_page_monthly_zone_id';
		$this->aTaskList_constructive[] = 'afterAddIndex__data_summary_zone_domain_page_monthly__data_summary_zone_domain_page_monthly_zone_id';
		$this->aTaskList_constructive[] = 'beforeRemoveIndex__data_summary_zone_domain_page_monthly__yearmonth';
		$this->aTaskList_constructive[] = 'afterRemoveIndex__data_summary_zone_domain_page_monthly__yearmonth';
		$this->aTaskList_constructive[] = 'beforeRemoveIndex__data_summary_zone_domain_page_monthly__zone_id';
		$this->aTaskList_constructive[] = 'afterRemoveIndex__data_summary_zone_domain_page_monthly__zone_id';
		$this->aTaskList_constructive[] = 'beforeAddIndex__data_summary_zone_impression_history__data_summary_zone_impression_history_zone_id';
		$this->aTaskList_constructive[] = 'afterAddIndex__data_summary_zone_impression_history__data_summary_zone_impression_history_zone_id';
		$this->aTaskList_constructive[] = 'beforeAddIndex__data_summary_zone_site_keyword_daily__data_summary_zone_site_keyword_daily_day';
		$this->aTaskList_constructive[] = 'afterAddIndex__data_summary_zone_site_keyword_daily__data_summary_zone_site_keyword_daily_day';
		$this->aTaskList_constructive[] = 'beforeAddIndex__data_summary_zone_site_keyword_daily__data_summary_zone_site_keyword_daily_zone_id';
		$this->aTaskList_constructive[] = 'afterAddIndex__data_summary_zone_site_keyword_daily__data_summary_zone_site_keyword_daily_zone_id';
		$this->aTaskList_constructive[] = 'beforeRemoveIndex__data_summary_zone_site_keyword_daily__day';
		$this->aTaskList_constructive[] = 'afterRemoveIndex__data_summary_zone_site_keyword_daily__day';
		$this->aTaskList_constructive[] = 'beforeRemoveIndex__data_summary_zone_site_keyword_daily__zone_id';
		$this->aTaskList_constructive[] = 'afterRemoveIndex__data_summary_zone_site_keyword_daily__zone_id';
		$this->aTaskList_constructive[] = 'beforeAddIndex__data_summary_zone_site_keyword_forecast__data_summary_zone_site_keyword_forecast_day_of_week';
		$this->aTaskList_constructive[] = 'afterAddIndex__data_summary_zone_site_keyword_forecast__data_summary_zone_site_keyword_forecast_day_of_week';
		$this->aTaskList_constructive[] = 'beforeAddIndex__data_summary_zone_site_keyword_forecast__data_summary_zone_site_keyword_forecast_zone_id';
		$this->aTaskList_constructive[] = 'afterAddIndex__data_summary_zone_site_keyword_forecast__data_summary_zone_site_keyword_forecast_zone_id';
		$this->aTaskList_constructive[] = 'beforeRemoveIndex__data_summary_zone_site_keyword_forecast__day_of_week';
		$this->aTaskList_constructive[] = 'afterRemoveIndex__data_summary_zone_site_keyword_forecast__day_of_week';
		$this->aTaskList_constructive[] = 'beforeRemoveIndex__data_summary_zone_site_keyword_forecast__zone_id';
		$this->aTaskList_constructive[] = 'afterRemoveIndex__data_summary_zone_site_keyword_forecast__zone_id';
		$this->aTaskList_constructive[] = 'beforeAddIndex__data_summary_zone_site_keyword_monthly__data_summary_zone_site_keyword_monthly_yearmonth';
		$this->aTaskList_constructive[] = 'afterAddIndex__data_summary_zone_site_keyword_monthly__data_summary_zone_site_keyword_monthly_yearmonth';
		$this->aTaskList_constructive[] = 'beforeAddIndex__data_summary_zone_site_keyword_monthly__data_summary_zone_site_keyword_monthly_zone_id';
		$this->aTaskList_constructive[] = 'afterAddIndex__data_summary_zone_site_keyword_monthly__data_summary_zone_site_keyword_monthly_zone_id';
		$this->aTaskList_constructive[] = 'beforeRemoveIndex__data_summary_zone_site_keyword_monthly__yearmonth';
		$this->aTaskList_constructive[] = 'afterRemoveIndex__data_summary_zone_site_keyword_monthly__yearmonth';
		$this->aTaskList_constructive[] = 'beforeRemoveIndex__data_summary_zone_site_keyword_monthly__zone_id';
		$this->aTaskList_constructive[] = 'afterRemoveIndex__data_summary_zone_site_keyword_monthly__zone_id';
		$this->aTaskList_constructive[] = 'beforeAddIndex__data_summary_zone_source_daily__data_summary_zone_source_daily_day';
		$this->aTaskList_constructive[] = 'afterAddIndex__data_summary_zone_source_daily__data_summary_zone_source_daily_day';
		$this->aTaskList_constructive[] = 'beforeAddIndex__data_summary_zone_source_daily__data_summary_zone_source_daily_zone_id';
		$this->aTaskList_constructive[] = 'afterAddIndex__data_summary_zone_source_daily__data_summary_zone_source_daily_zone_id';
		$this->aTaskList_constructive[] = 'beforeRemoveIndex__data_summary_zone_source_daily__day';
		$this->aTaskList_constructive[] = 'afterRemoveIndex__data_summary_zone_source_daily__day';
		$this->aTaskList_constructive[] = 'beforeRemoveIndex__data_summary_zone_source_daily__zone_id';
		$this->aTaskList_constructive[] = 'afterRemoveIndex__data_summary_zone_source_daily__zone_id';
		$this->aTaskList_constructive[] = 'beforeAddIndex__data_summary_zone_source_forecast__data_summary_zone_source_forecast_day_of_week';
		$this->aTaskList_constructive[] = 'afterAddIndex__data_summary_zone_source_forecast__data_summary_zone_source_forecast_day_of_week';
		$this->aTaskList_constructive[] = 'beforeAddIndex__data_summary_zone_source_forecast__data_summary_zone_source_forecast_zone_id';
		$this->aTaskList_constructive[] = 'afterAddIndex__data_summary_zone_source_forecast__data_summary_zone_source_forecast_zone_id';
		$this->aTaskList_constructive[] = 'beforeRemoveIndex__data_summary_zone_source_forecast__day_of_week';
		$this->aTaskList_constructive[] = 'afterRemoveIndex__data_summary_zone_source_forecast__day_of_week';
		$this->aTaskList_constructive[] = 'beforeRemoveIndex__data_summary_zone_source_forecast__zone_id';
		$this->aTaskList_constructive[] = 'afterRemoveIndex__data_summary_zone_source_forecast__zone_id';
		$this->aTaskList_constructive[] = 'beforeAddIndex__data_summary_zone_source_monthly__data_summary_zone_source_monthly_yearmonth';
		$this->aTaskList_constructive[] = 'afterAddIndex__data_summary_zone_source_monthly__data_summary_zone_source_monthly_yearmonth';
		$this->aTaskList_constructive[] = 'beforeAddIndex__data_summary_zone_source_monthly__data_summary_zone_source_monthly_zone_id';
		$this->aTaskList_constructive[] = 'afterAddIndex__data_summary_zone_source_monthly__data_summary_zone_source_monthly_zone_id';
		$this->aTaskList_constructive[] = 'beforeRemoveIndex__data_summary_zone_source_monthly__yearmonth';
		$this->aTaskList_constructive[] = 'afterRemoveIndex__data_summary_zone_source_monthly__yearmonth';
		$this->aTaskList_constructive[] = 'beforeRemoveIndex__data_summary_zone_source_monthly__zone_id';
		$this->aTaskList_constructive[] = 'afterRemoveIndex__data_summary_zone_source_monthly__zone_id';
		$this->aTaskList_constructive[] = 'beforeAddIndex__placement_zone_assoc__placement_zone_assoc_zone_id';
		$this->aTaskList_constructive[] = 'afterAddIndex__placement_zone_assoc__placement_zone_assoc_zone_id';
		$this->aTaskList_constructive[] = 'beforeRemoveIndex__placement_zone_assoc__zone_id';
		$this->aTaskList_constructive[] = 'afterRemoveIndex__placement_zone_assoc__zone_id';
		$this->aTaskList_constructive[] = 'beforeAddIndex__trackers__trackers_clientid';
		$this->aTaskList_constructive[] = 'afterAddIndex__trackers__trackers_clientid';
		$this->aTaskList_constructive[] = 'beforeRemoveIndex__trackers__clientid';
		$this->aTaskList_constructive[] = 'afterRemoveIndex__trackers__clientid';
		$this->aTaskList_constructive[] = 'beforeAddIndex__variables__variables_trackerid';
		$this->aTaskList_constructive[] = 'afterAddIndex__variables__variables_trackerid';
		$this->aTaskList_constructive[] = 'beforeRemoveIndex__variables__trackerid';
		$this->aTaskList_constructive[] = 'afterRemoveIndex__variables__trackerid';


		$this->aObjectMap['campaigns']['block'] = array('fromTable'=>'campaigns', 'fromField'=>'block');
		$this->aObjectMap['campaigns']['capping'] = array('fromTable'=>'campaigns', 'fromField'=>'capping');
		$this->aObjectMap['campaigns']['session_capping'] = array('fromTable'=>'campaigns', 'fromField'=>'session_capping');
		$this->aObjectMap['data_intermediate_ad_connection']['tracker_channel_ids'] = array('fromTable'=>'data_intermediate_ad_connection', 'fromField'=>'tracker_channel_ids');
		$this->aObjectMap['data_intermediate_ad_connection']['connection_channel_ids'] = array('fromTable'=>'data_intermediate_ad_connection', 'fromField'=>'connection_channel_ids');
		$this->aObjectMap['data_raw_ad_click']['channel_ids'] = array('fromTable'=>'data_raw_ad_click', 'fromField'=>'channel_ids');
		$this->aObjectMap['data_raw_ad_impression']['channel_ids'] = array('fromTable'=>'data_raw_ad_impression', 'fromField'=>'channel_ids');
		$this->aObjectMap['data_raw_ad_request']['channel_ids'] = array('fromTable'=>'data_raw_ad_request', 'fromField'=>'channel_ids');
		$this->aObjectMap['data_raw_tracker_click']['channel_ids'] = array('fromTable'=>'data_raw_tracker_click', 'fromField'=>'channel_ids');
		$this->aObjectMap['data_raw_tracker_impression']['channel_ids'] = array('fromTable'=>'data_raw_tracker_impression', 'fromField'=>'channel_ids');
    }



	function beforeAlterField__acls_channel__logical()
	{
		return $this->beforeAlterField('acls_channel', 'logical');
	}

	function afterAlterField__acls_channel__logical()
	{
		return $this->afterAlterField('acls_channel', 'logical');
	}

	function beforeAddIndex__ad_zone_assoc__ad_zone_assoc_zone_id()
	{
		return $this->beforeAddIndex('ad_zone_assoc', 'ad_zone_assoc_zone_id');
	}

	function afterAddIndex__ad_zone_assoc__ad_zone_assoc_zone_id()
	{
		return $this->afterAddIndex('ad_zone_assoc', 'ad_zone_assoc_zone_id');
	}

	function beforeRemoveIndex__ad_zone_assoc__zone_id()
	{
		return $this->beforeRemoveIndex('ad_zone_assoc', 'zone_id');
	}

	function afterRemoveIndex__ad_zone_assoc__zone_id()
	{
		return $this->afterRemoveIndex('ad_zone_assoc', 'zone_id');
	}

	function beforeAddIndex__affiliates__affiliates_agencyid()
	{
		return $this->beforeAddIndex('affiliates', 'affiliates_agencyid');
	}

	function afterAddIndex__affiliates__affiliates_agencyid()
	{
		return $this->afterAddIndex('affiliates', 'affiliates_agencyid');
	}

	function beforeRemoveIndex__affiliates__agencyid()
	{
		return $this->beforeRemoveIndex('affiliates', 'agencyid');
	}

	function afterRemoveIndex__affiliates__agencyid()
	{
		return $this->afterRemoveIndex('affiliates', 'agencyid');
	}

	function beforeAddIndex__banners__banners_campaignid()
	{
		return $this->beforeAddIndex('banners', 'banners_campaignid');
	}

	function afterAddIndex__banners__banners_campaignid()
	{
		return $this->afterAddIndex('banners', 'banners_campaignid');
	}

	function beforeRemoveIndex__banners__campaignid()
	{
		return $this->beforeRemoveIndex('banners', 'campaignid');
	}

	function afterRemoveIndex__banners__campaignid()
	{
		return $this->afterRemoveIndex('banners', 'campaignid');
	}

	function beforeAddField__campaigns__block()
	{
		return $this->beforeAddField('campaigns', 'block');
	}

	function afterAddField__campaigns__block()
	{
		return $this->afterAddField('campaigns', 'block');
	}

	function beforeAddField__campaigns__capping()
	{
		return $this->beforeAddField('campaigns', 'capping');
	}

	function afterAddField__campaigns__capping()
	{
		return $this->afterAddField('campaigns', 'capping');
	}

	function beforeAddField__campaigns__session_capping()
	{
		return $this->beforeAddField('campaigns', 'session_capping');
	}

	function afterAddField__campaigns__session_capping()
	{
		return $this->afterAddField('campaigns', 'session_capping');
	}

	function beforeAddIndex__campaigns__campaigns_clientid()
	{
		return $this->beforeAddIndex('campaigns', 'campaigns_clientid');
	}

	function afterAddIndex__campaigns__campaigns_clientid()
	{
		return $this->afterAddIndex('campaigns', 'campaigns_clientid');
	}

	function beforeRemoveIndex__campaigns__clientid()
	{
		return $this->beforeRemoveIndex('campaigns', 'clientid');
	}

	function afterRemoveIndex__campaigns__clientid()
	{
		return $this->afterRemoveIndex('campaigns', 'clientid');
	}

	function beforeAddIndex__campaigns_trackers__campaigns_trackers_campaignid()
	{
		return $this->beforeAddIndex('campaigns_trackers', 'campaigns_trackers_campaignid');
	}

	function afterAddIndex__campaigns_trackers__campaigns_trackers_campaignid()
	{
		return $this->afterAddIndex('campaigns_trackers', 'campaigns_trackers_campaignid');
	}

	function beforeAddIndex__campaigns_trackers__campaigns_trackers_trackerid()
	{
		return $this->beforeAddIndex('campaigns_trackers', 'campaigns_trackers_trackerid');
	}

	function afterAddIndex__campaigns_trackers__campaigns_trackers_trackerid()
	{
		return $this->afterAddIndex('campaigns_trackers', 'campaigns_trackers_trackerid');
	}

	function beforeRemoveIndex__campaigns_trackers__campaignid()
	{
		return $this->beforeRemoveIndex('campaigns_trackers', 'campaignid');
	}

	function afterRemoveIndex__campaigns_trackers__campaignid()
	{
		return $this->afterRemoveIndex('campaigns_trackers', 'campaignid');
	}

	function beforeRemoveIndex__campaigns_trackers__trackerid()
	{
		return $this->beforeRemoveIndex('campaigns_trackers', 'trackerid');
	}

	function afterRemoveIndex__campaigns_trackers__trackerid()
	{
		return $this->afterRemoveIndex('campaigns_trackers', 'trackerid');
	}

	function beforeAddIndex__clients__clients_agencyid()
	{
		return $this->beforeAddIndex('clients', 'clients_agencyid');
	}

	function afterAddIndex__clients__clients_agencyid()
	{
		return $this->afterAddIndex('clients', 'clients_agencyid');
	}

	function beforeRemoveIndex__clients__agencyid()
	{
		return $this->beforeRemoveIndex('clients', 'agencyid');
	}

	function afterRemoveIndex__clients__agencyid()
	{
		return $this->afterRemoveIndex('clients', 'agencyid');
	}

	function beforeAlterField__data_intermediate_ad__total_num_items()
	{
		return $this->beforeAlterField('data_intermediate_ad', 'total_num_items');
	}

	function afterAlterField__data_intermediate_ad__total_num_items()
	{
		return $this->afterAlterField('data_intermediate_ad', 'total_num_items');
	}

	function beforeAddField__data_intermediate_ad_connection__tracker_channel_ids()
	{
		return $this->beforeAddField('data_intermediate_ad_connection', 'tracker_channel_ids');
	}

	function afterAddField__data_intermediate_ad_connection__tracker_channel_ids()
	{
		return $this->afterAddField('data_intermediate_ad_connection', 'tracker_channel_ids');
	}

	function beforeAddField__data_intermediate_ad_connection__connection_channel_ids()
	{
		return $this->beforeAddField('data_intermediate_ad_connection', 'connection_channel_ids');
	}

	function afterAddField__data_intermediate_ad_connection__connection_channel_ids()
	{
		return $this->afterAddField('data_intermediate_ad_connection', 'connection_channel_ids');
	}

	function beforeAddField__data_raw_ad_click__channel_ids()
	{
		return $this->beforeAddField('data_raw_ad_click', 'channel_ids');
	}

	function afterAddField__data_raw_ad_click__channel_ids()
	{
		return $this->afterAddField('data_raw_ad_click', 'channel_ids');
	}

	function beforeAddField__data_raw_ad_impression__channel_ids()
	{
		return $this->beforeAddField('data_raw_ad_impression', 'channel_ids');
	}

	function afterAddField__data_raw_ad_impression__channel_ids()
	{
		return $this->afterAddField('data_raw_ad_impression', 'channel_ids');
	}

	function beforeAddField__data_raw_ad_request__channel_ids()
	{
		return $this->beforeAddField('data_raw_ad_request', 'channel_ids');
	}

	function afterAddField__data_raw_ad_request__channel_ids()
	{
		return $this->afterAddField('data_raw_ad_request', 'channel_ids');
	}

	function beforeAddField__data_raw_tracker_click__channel_ids()
	{
		return $this->beforeAddField('data_raw_tracker_click', 'channel_ids');
	}

	function afterAddField__data_raw_tracker_click__channel_ids()
	{
		return $this->afterAddField('data_raw_tracker_click', 'channel_ids');
	}

	function beforeAddField__data_raw_tracker_impression__channel_ids()
	{
		return $this->beforeAddField('data_raw_tracker_impression', 'channel_ids');
	}

	function afterAddField__data_raw_tracker_impression__channel_ids()
	{
		return $this->afterAddField('data_raw_tracker_impression', 'channel_ids');
	}

	function beforeAlterField__data_summary_ad_hourly__total_num_items()
	{
		return $this->beforeAlterField('data_summary_ad_hourly', 'total_num_items');
	}

	function afterAlterField__data_summary_ad_hourly__total_num_items()
	{
		return $this->afterAlterField('data_summary_ad_hourly', 'total_num_items');
	}

	function beforeAddIndex__data_summary_zone_country_daily__data_summary_zone_country_daily_day()
	{
		return $this->beforeAddIndex('data_summary_zone_country_daily', 'data_summary_zone_country_daily_day');
	}

	function afterAddIndex__data_summary_zone_country_daily__data_summary_zone_country_daily_day()
	{
		return $this->afterAddIndex('data_summary_zone_country_daily', 'data_summary_zone_country_daily_day');
	}

	function beforeAddIndex__data_summary_zone_country_daily__data_summary_zone_country_daily_zone_id()
	{
		return $this->beforeAddIndex('data_summary_zone_country_daily', 'data_summary_zone_country_daily_zone_id');
	}

	function afterAddIndex__data_summary_zone_country_daily__data_summary_zone_country_daily_zone_id()
	{
		return $this->afterAddIndex('data_summary_zone_country_daily', 'data_summary_zone_country_daily_zone_id');
	}

	function beforeRemoveIndex__data_summary_zone_country_daily__day()
	{
		return $this->beforeRemoveIndex('data_summary_zone_country_daily', 'day');
	}

	function afterRemoveIndex__data_summary_zone_country_daily__day()
	{
		return $this->afterRemoveIndex('data_summary_zone_country_daily', 'day');
	}

	function beforeRemoveIndex__data_summary_zone_country_daily__zone_id()
	{
		return $this->beforeRemoveIndex('data_summary_zone_country_daily', 'zone_id');
	}

	function afterRemoveIndex__data_summary_zone_country_daily__zone_id()
	{
		return $this->afterRemoveIndex('data_summary_zone_country_daily', 'zone_id');
	}

	function beforeAddIndex__data_summary_zone_country_forecast__data_summary_zone_country_forecast_day_of_week()
	{
		return $this->beforeAddIndex('data_summary_zone_country_forecast', 'data_summary_zone_country_forecast_day_of_week');
	}

	function afterAddIndex__data_summary_zone_country_forecast__data_summary_zone_country_forecast_day_of_week()
	{
		return $this->afterAddIndex('data_summary_zone_country_forecast', 'data_summary_zone_country_forecast_day_of_week');
	}

	function beforeAddIndex__data_summary_zone_country_forecast__data_summary_zone_country_forecast_zone_id()
	{
		return $this->beforeAddIndex('data_summary_zone_country_forecast', 'data_summary_zone_country_forecast_zone_id');
	}

	function afterAddIndex__data_summary_zone_country_forecast__data_summary_zone_country_forecast_zone_id()
	{
		return $this->afterAddIndex('data_summary_zone_country_forecast', 'data_summary_zone_country_forecast_zone_id');
	}

	function beforeRemoveIndex__data_summary_zone_country_forecast__day_of_week()
	{
		return $this->beforeRemoveIndex('data_summary_zone_country_forecast', 'day_of_week');
	}

	function afterRemoveIndex__data_summary_zone_country_forecast__day_of_week()
	{
		return $this->afterRemoveIndex('data_summary_zone_country_forecast', 'day_of_week');
	}

	function beforeRemoveIndex__data_summary_zone_country_forecast__zone_id()
	{
		return $this->beforeRemoveIndex('data_summary_zone_country_forecast', 'zone_id');
	}

	function afterRemoveIndex__data_summary_zone_country_forecast__zone_id()
	{
		return $this->afterRemoveIndex('data_summary_zone_country_forecast', 'zone_id');
	}

	function beforeAddIndex__data_summary_zone_country_monthly__data_summary_zone_country_monthly_yearmonth()
	{
		return $this->beforeAddIndex('data_summary_zone_country_monthly', 'data_summary_zone_country_monthly_yearmonth');
	}

	function afterAddIndex__data_summary_zone_country_monthly__data_summary_zone_country_monthly_yearmonth()
	{
		return $this->afterAddIndex('data_summary_zone_country_monthly', 'data_summary_zone_country_monthly_yearmonth');
	}

	function beforeAddIndex__data_summary_zone_country_monthly__data_summary_zone_country_monthly_zone_id()
	{
		return $this->beforeAddIndex('data_summary_zone_country_monthly', 'data_summary_zone_country_monthly_zone_id');
	}

	function afterAddIndex__data_summary_zone_country_monthly__data_summary_zone_country_monthly_zone_id()
	{
		return $this->afterAddIndex('data_summary_zone_country_monthly', 'data_summary_zone_country_monthly_zone_id');
	}

	function beforeRemoveIndex__data_summary_zone_country_monthly__yearmonth()
	{
		return $this->beforeRemoveIndex('data_summary_zone_country_monthly', 'yearmonth');
	}

	function afterRemoveIndex__data_summary_zone_country_monthly__yearmonth()
	{
		return $this->afterRemoveIndex('data_summary_zone_country_monthly', 'yearmonth');
	}

	function beforeRemoveIndex__data_summary_zone_country_monthly__zone_id()
	{
		return $this->beforeRemoveIndex('data_summary_zone_country_monthly', 'zone_id');
	}

	function afterRemoveIndex__data_summary_zone_country_monthly__zone_id()
	{
		return $this->afterRemoveIndex('data_summary_zone_country_monthly', 'zone_id');
	}

	function beforeAddIndex__data_summary_zone_domain_page_daily__data_summary_zone_domain_page_daily_day()
	{
		return $this->beforeAddIndex('data_summary_zone_domain_page_daily', 'data_summary_zone_domain_page_daily_day');
	}

	function afterAddIndex__data_summary_zone_domain_page_daily__data_summary_zone_domain_page_daily_day()
	{
		return $this->afterAddIndex('data_summary_zone_domain_page_daily', 'data_summary_zone_domain_page_daily_day');
	}

	function beforeAddIndex__data_summary_zone_domain_page_daily__data_summary_zone_domain_page_daily_zone_id()
	{
		return $this->beforeAddIndex('data_summary_zone_domain_page_daily', 'data_summary_zone_domain_page_daily_zone_id');
	}

	function afterAddIndex__data_summary_zone_domain_page_daily__data_summary_zone_domain_page_daily_zone_id()
	{
		return $this->afterAddIndex('data_summary_zone_domain_page_daily', 'data_summary_zone_domain_page_daily_zone_id');
	}

	function beforeRemoveIndex__data_summary_zone_domain_page_daily__day()
	{
		return $this->beforeRemoveIndex('data_summary_zone_domain_page_daily', 'day');
	}

	function afterRemoveIndex__data_summary_zone_domain_page_daily__day()
	{
		return $this->afterRemoveIndex('data_summary_zone_domain_page_daily', 'day');
	}

	function beforeRemoveIndex__data_summary_zone_domain_page_daily__zone_id()
	{
		return $this->beforeRemoveIndex('data_summary_zone_domain_page_daily', 'zone_id');
	}

	function afterRemoveIndex__data_summary_zone_domain_page_daily__zone_id()
	{
		return $this->afterRemoveIndex('data_summary_zone_domain_page_daily', 'zone_id');
	}

	function beforeAddIndex__data_summary_zone_domain_page_forecast__data_summary_zone_domain_page_forecast_day_of_week()
	{
		return $this->beforeAddIndex('data_summary_zone_domain_page_forecast', 'data_summary_zone_domain_page_forecast_day_of_week');
	}

	function afterAddIndex__data_summary_zone_domain_page_forecast__data_summary_zone_domain_page_forecast_day_of_week()
	{
		return $this->afterAddIndex('data_summary_zone_domain_page_forecast', 'data_summary_zone_domain_page_forecast_day_of_week');
	}

	function beforeAddIndex__data_summary_zone_domain_page_forecast__data_summary_zone_domain_page_forecast_zone_id()
	{
		return $this->beforeAddIndex('data_summary_zone_domain_page_forecast', 'data_summary_zone_domain_page_forecast_zone_id');
	}

	function afterAddIndex__data_summary_zone_domain_page_forecast__data_summary_zone_domain_page_forecast_zone_id()
	{
		return $this->afterAddIndex('data_summary_zone_domain_page_forecast', 'data_summary_zone_domain_page_forecast_zone_id');
	}

	function beforeRemoveIndex__data_summary_zone_domain_page_forecast__day_of_week()
	{
		return $this->beforeRemoveIndex('data_summary_zone_domain_page_forecast', 'day_of_week');
	}

	function afterRemoveIndex__data_summary_zone_domain_page_forecast__day_of_week()
	{
		return $this->afterRemoveIndex('data_summary_zone_domain_page_forecast', 'day_of_week');
	}

	function beforeRemoveIndex__data_summary_zone_domain_page_forecast__zone_id()
	{
		return $this->beforeRemoveIndex('data_summary_zone_domain_page_forecast', 'zone_id');
	}

	function afterRemoveIndex__data_summary_zone_domain_page_forecast__zone_id()
	{
		return $this->afterRemoveIndex('data_summary_zone_domain_page_forecast', 'zone_id');
	}

	function beforeAddIndex__data_summary_zone_domain_page_monthly__data_summary_zone_domain_page_monthly_yearmonth()
	{
		return $this->beforeAddIndex('data_summary_zone_domain_page_monthly', 'data_summary_zone_domain_page_monthly_yearmonth');
	}

	function afterAddIndex__data_summary_zone_domain_page_monthly__data_summary_zone_domain_page_monthly_yearmonth()
	{
		return $this->afterAddIndex('data_summary_zone_domain_page_monthly', 'data_summary_zone_domain_page_monthly_yearmonth');
	}

	function beforeAddIndex__data_summary_zone_domain_page_monthly__data_summary_zone_domain_page_monthly_zone_id()
	{
		return $this->beforeAddIndex('data_summary_zone_domain_page_monthly', 'data_summary_zone_domain_page_monthly_zone_id');
	}

	function afterAddIndex__data_summary_zone_domain_page_monthly__data_summary_zone_domain_page_monthly_zone_id()
	{
		return $this->afterAddIndex('data_summary_zone_domain_page_monthly', 'data_summary_zone_domain_page_monthly_zone_id');
	}

	function beforeRemoveIndex__data_summary_zone_domain_page_monthly__yearmonth()
	{
		return $this->beforeRemoveIndex('data_summary_zone_domain_page_monthly', 'yearmonth');
	}

	function afterRemoveIndex__data_summary_zone_domain_page_monthly__yearmonth()
	{
		return $this->afterRemoveIndex('data_summary_zone_domain_page_monthly', 'yearmonth');
	}

	function beforeRemoveIndex__data_summary_zone_domain_page_monthly__zone_id()
	{
		return $this->beforeRemoveIndex('data_summary_zone_domain_page_monthly', 'zone_id');
	}

	function afterRemoveIndex__data_summary_zone_domain_page_monthly__zone_id()
	{
		return $this->afterRemoveIndex('data_summary_zone_domain_page_monthly', 'zone_id');
	}

	function beforeAddIndex__data_summary_zone_impression_history__data_summary_zone_impression_history_zone_id()
	{
		return $this->beforeAddIndex('data_summary_zone_impression_history', 'data_summary_zone_impression_history_zone_id');
	}

	function afterAddIndex__data_summary_zone_impression_history__data_summary_zone_impression_history_zone_id()
	{
		return $this->afterAddIndex('data_summary_zone_impression_history', 'data_summary_zone_impression_history_zone_id');
	}

	function beforeAddIndex__data_summary_zone_site_keyword_daily__data_summary_zone_site_keyword_daily_day()
	{
		return $this->beforeAddIndex('data_summary_zone_site_keyword_daily', 'data_summary_zone_site_keyword_daily_day');
	}

	function afterAddIndex__data_summary_zone_site_keyword_daily__data_summary_zone_site_keyword_daily_day()
	{
		return $this->afterAddIndex('data_summary_zone_site_keyword_daily', 'data_summary_zone_site_keyword_daily_day');
	}

	function beforeAddIndex__data_summary_zone_site_keyword_daily__data_summary_zone_site_keyword_daily_zone_id()
	{
		return $this->beforeAddIndex('data_summary_zone_site_keyword_daily', 'data_summary_zone_site_keyword_daily_zone_id');
	}

	function afterAddIndex__data_summary_zone_site_keyword_daily__data_summary_zone_site_keyword_daily_zone_id()
	{
		return $this->afterAddIndex('data_summary_zone_site_keyword_daily', 'data_summary_zone_site_keyword_daily_zone_id');
	}

	function beforeRemoveIndex__data_summary_zone_site_keyword_daily__day()
	{
		return $this->beforeRemoveIndex('data_summary_zone_site_keyword_daily', 'day');
	}

	function afterRemoveIndex__data_summary_zone_site_keyword_daily__day()
	{
		return $this->afterRemoveIndex('data_summary_zone_site_keyword_daily', 'day');
	}

	function beforeRemoveIndex__data_summary_zone_site_keyword_daily__zone_id()
	{
		return $this->beforeRemoveIndex('data_summary_zone_site_keyword_daily', 'zone_id');
	}

	function afterRemoveIndex__data_summary_zone_site_keyword_daily__zone_id()
	{
		return $this->afterRemoveIndex('data_summary_zone_site_keyword_daily', 'zone_id');
	}

	function beforeAddIndex__data_summary_zone_site_keyword_forecast__data_summary_zone_site_keyword_forecast_day_of_week()
	{
		return $this->beforeAddIndex('data_summary_zone_site_keyword_forecast', 'data_summary_zone_site_keyword_forecast_day_of_week');
	}

	function afterAddIndex__data_summary_zone_site_keyword_forecast__data_summary_zone_site_keyword_forecast_day_of_week()
	{
		return $this->afterAddIndex('data_summary_zone_site_keyword_forecast', 'data_summary_zone_site_keyword_forecast_day_of_week');
	}

	function beforeAddIndex__data_summary_zone_site_keyword_forecast__data_summary_zone_site_keyword_forecast_zone_id()
	{
		return $this->beforeAddIndex('data_summary_zone_site_keyword_forecast', 'data_summary_zone_site_keyword_forecast_zone_id');
	}

	function afterAddIndex__data_summary_zone_site_keyword_forecast__data_summary_zone_site_keyword_forecast_zone_id()
	{
		return $this->afterAddIndex('data_summary_zone_site_keyword_forecast', 'data_summary_zone_site_keyword_forecast_zone_id');
	}

	function beforeRemoveIndex__data_summary_zone_site_keyword_forecast__day_of_week()
	{
		return $this->beforeRemoveIndex('data_summary_zone_site_keyword_forecast', 'day_of_week');
	}

	function afterRemoveIndex__data_summary_zone_site_keyword_forecast__day_of_week()
	{
		return $this->afterRemoveIndex('data_summary_zone_site_keyword_forecast', 'day_of_week');
	}

	function beforeRemoveIndex__data_summary_zone_site_keyword_forecast__zone_id()
	{
		return $this->beforeRemoveIndex('data_summary_zone_site_keyword_forecast', 'zone_id');
	}

	function afterRemoveIndex__data_summary_zone_site_keyword_forecast__zone_id()
	{
		return $this->afterRemoveIndex('data_summary_zone_site_keyword_forecast', 'zone_id');
	}

	function beforeAddIndex__data_summary_zone_site_keyword_monthly__data_summary_zone_site_keyword_monthly_yearmonth()
	{
		return $this->beforeAddIndex('data_summary_zone_site_keyword_monthly', 'data_summary_zone_site_keyword_monthly_yearmonth');
	}

	function afterAddIndex__data_summary_zone_site_keyword_monthly__data_summary_zone_site_keyword_monthly_yearmonth()
	{
		return $this->afterAddIndex('data_summary_zone_site_keyword_monthly', 'data_summary_zone_site_keyword_monthly_yearmonth');
	}

	function beforeAddIndex__data_summary_zone_site_keyword_monthly__data_summary_zone_site_keyword_monthly_zone_id()
	{
		return $this->beforeAddIndex('data_summary_zone_site_keyword_monthly', 'data_summary_zone_site_keyword_monthly_zone_id');
	}

	function afterAddIndex__data_summary_zone_site_keyword_monthly__data_summary_zone_site_keyword_monthly_zone_id()
	{
		return $this->afterAddIndex('data_summary_zone_site_keyword_monthly', 'data_summary_zone_site_keyword_monthly_zone_id');
	}

	function beforeRemoveIndex__data_summary_zone_site_keyword_monthly__yearmonth()
	{
		return $this->beforeRemoveIndex('data_summary_zone_site_keyword_monthly', 'yearmonth');
	}

	function afterRemoveIndex__data_summary_zone_site_keyword_monthly__yearmonth()
	{
		return $this->afterRemoveIndex('data_summary_zone_site_keyword_monthly', 'yearmonth');
	}

	function beforeRemoveIndex__data_summary_zone_site_keyword_monthly__zone_id()
	{
		return $this->beforeRemoveIndex('data_summary_zone_site_keyword_monthly', 'zone_id');
	}

	function afterRemoveIndex__data_summary_zone_site_keyword_monthly__zone_id()
	{
		return $this->afterRemoveIndex('data_summary_zone_site_keyword_monthly', 'zone_id');
	}

	function beforeAddIndex__data_summary_zone_source_daily__data_summary_zone_source_daily_day()
	{
		return $this->beforeAddIndex('data_summary_zone_source_daily', 'data_summary_zone_source_daily_day');
	}

	function afterAddIndex__data_summary_zone_source_daily__data_summary_zone_source_daily_day()
	{
		return $this->afterAddIndex('data_summary_zone_source_daily', 'data_summary_zone_source_daily_day');
	}

	function beforeAddIndex__data_summary_zone_source_daily__data_summary_zone_source_daily_zone_id()
	{
		return $this->beforeAddIndex('data_summary_zone_source_daily', 'data_summary_zone_source_daily_zone_id');
	}

	function afterAddIndex__data_summary_zone_source_daily__data_summary_zone_source_daily_zone_id()
	{
		return $this->afterAddIndex('data_summary_zone_source_daily', 'data_summary_zone_source_daily_zone_id');
	}

	function beforeRemoveIndex__data_summary_zone_source_daily__day()
	{
		return $this->beforeRemoveIndex('data_summary_zone_source_daily', 'day');
	}

	function afterRemoveIndex__data_summary_zone_source_daily__day()
	{
		return $this->afterRemoveIndex('data_summary_zone_source_daily', 'day');
	}

	function beforeRemoveIndex__data_summary_zone_source_daily__zone_id()
	{
		return $this->beforeRemoveIndex('data_summary_zone_source_daily', 'zone_id');
	}

	function afterRemoveIndex__data_summary_zone_source_daily__zone_id()
	{
		return $this->afterRemoveIndex('data_summary_zone_source_daily', 'zone_id');
	}

	function beforeAddIndex__data_summary_zone_source_forecast__data_summary_zone_source_forecast_day_of_week()
	{
		return $this->beforeAddIndex('data_summary_zone_source_forecast', 'data_summary_zone_source_forecast_day_of_week');
	}

	function afterAddIndex__data_summary_zone_source_forecast__data_summary_zone_source_forecast_day_of_week()
	{
		return $this->afterAddIndex('data_summary_zone_source_forecast', 'data_summary_zone_source_forecast_day_of_week');
	}

	function beforeAddIndex__data_summary_zone_source_forecast__data_summary_zone_source_forecast_zone_id()
	{
		return $this->beforeAddIndex('data_summary_zone_source_forecast', 'data_summary_zone_source_forecast_zone_id');
	}

	function afterAddIndex__data_summary_zone_source_forecast__data_summary_zone_source_forecast_zone_id()
	{
		return $this->afterAddIndex('data_summary_zone_source_forecast', 'data_summary_zone_source_forecast_zone_id');
	}

	function beforeRemoveIndex__data_summary_zone_source_forecast__day_of_week()
	{
		return $this->beforeRemoveIndex('data_summary_zone_source_forecast', 'day_of_week');
	}

	function afterRemoveIndex__data_summary_zone_source_forecast__day_of_week()
	{
		return $this->afterRemoveIndex('data_summary_zone_source_forecast', 'day_of_week');
	}

	function beforeRemoveIndex__data_summary_zone_source_forecast__zone_id()
	{
		return $this->beforeRemoveIndex('data_summary_zone_source_forecast', 'zone_id');
	}

	function afterRemoveIndex__data_summary_zone_source_forecast__zone_id()
	{
		return $this->afterRemoveIndex('data_summary_zone_source_forecast', 'zone_id');
	}

	function beforeAddIndex__data_summary_zone_source_monthly__data_summary_zone_source_monthly_yearmonth()
	{
		return $this->beforeAddIndex('data_summary_zone_source_monthly', 'data_summary_zone_source_monthly_yearmonth');
	}

	function afterAddIndex__data_summary_zone_source_monthly__data_summary_zone_source_monthly_yearmonth()
	{
		return $this->afterAddIndex('data_summary_zone_source_monthly', 'data_summary_zone_source_monthly_yearmonth');
	}

	function beforeAddIndex__data_summary_zone_source_monthly__data_summary_zone_source_monthly_zone_id()
	{
		return $this->beforeAddIndex('data_summary_zone_source_monthly', 'data_summary_zone_source_monthly_zone_id');
	}

	function afterAddIndex__data_summary_zone_source_monthly__data_summary_zone_source_monthly_zone_id()
	{
		return $this->afterAddIndex('data_summary_zone_source_monthly', 'data_summary_zone_source_monthly_zone_id');
	}

	function beforeRemoveIndex__data_summary_zone_source_monthly__yearmonth()
	{
		return $this->beforeRemoveIndex('data_summary_zone_source_monthly', 'yearmonth');
	}

	function afterRemoveIndex__data_summary_zone_source_monthly__yearmonth()
	{
		return $this->afterRemoveIndex('data_summary_zone_source_monthly', 'yearmonth');
	}

	function beforeRemoveIndex__data_summary_zone_source_monthly__zone_id()
	{
		return $this->beforeRemoveIndex('data_summary_zone_source_monthly', 'zone_id');
	}

	function afterRemoveIndex__data_summary_zone_source_monthly__zone_id()
	{
		return $this->afterRemoveIndex('data_summary_zone_source_monthly', 'zone_id');
	}

	function beforeAddIndex__placement_zone_assoc__placement_zone_assoc_zone_id()
	{
		return $this->beforeAddIndex('placement_zone_assoc', 'placement_zone_assoc_zone_id');
	}

	function afterAddIndex__placement_zone_assoc__placement_zone_assoc_zone_id()
	{
		return $this->afterAddIndex('placement_zone_assoc', 'placement_zone_assoc_zone_id');
	}

	function beforeRemoveIndex__placement_zone_assoc__zone_id()
	{
		return $this->beforeRemoveIndex('placement_zone_assoc', 'zone_id');
	}

	function afterRemoveIndex__placement_zone_assoc__zone_id()
	{
		return $this->afterRemoveIndex('placement_zone_assoc', 'zone_id');
	}

	function beforeAddIndex__trackers__trackers_clientid()
	{
		return $this->beforeAddIndex('trackers', 'trackers_clientid');
	}

	function afterAddIndex__trackers__trackers_clientid()
	{
		return $this->afterAddIndex('trackers', 'trackers_clientid');
	}

	function beforeRemoveIndex__trackers__clientid()
	{
		return $this->beforeRemoveIndex('trackers', 'clientid');
	}

	function afterRemoveIndex__trackers__clientid()
	{
		return $this->afterRemoveIndex('trackers', 'clientid');
	}

	function beforeAddIndex__variables__variables_trackerid()
	{
		return $this->beforeAddIndex('variables', 'variables_trackerid');
	}

	function afterAddIndex__variables__variables_trackerid()
	{
		return $this->afterAddIndex('variables', 'variables_trackerid');
	}

	function beforeRemoveIndex__variables__trackerid()
	{
		return $this->beforeRemoveIndex('variables', 'trackerid');
	}

	function afterRemoveIndex__variables__trackerid()
	{
		return $this->afterRemoveIndex('variables', 'trackerid');
	}

}

?>