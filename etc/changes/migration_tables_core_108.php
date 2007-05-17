<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
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

require_once(MAX_PATH.'/lib/OA/Upgrade/Migration.php');
require_once MAX_PATH . '/etc/changes/StatMigration.php';
require_once MAX_PATH . '/etc/changes/migration_tables_core_119.php';

class Migration_108 extends Migration
{

    function Migration_108()
    {
        //$this->__construct();

		$this->aTaskList_constructive[] = 'beforeAddTable__application_variable';
		$this->aTaskList_constructive[] = 'afterAddTable__application_variable';
		$this->aTaskList_constructive[] = 'beforeAddTable__data_intermediate_ad';
		$this->aTaskList_constructive[] = 'afterAddTable__data_intermediate_ad';
		$this->aTaskList_constructive[] = 'beforeAddTable__data_intermediate_ad_connection';
		$this->aTaskList_constructive[] = 'afterAddTable__data_intermediate_ad_connection';
		$this->aTaskList_constructive[] = 'beforeAddTable__data_intermediate_ad_variable_value';
		$this->aTaskList_constructive[] = 'afterAddTable__data_intermediate_ad_variable_value';
		$this->aTaskList_constructive[] = 'beforeAddTable__data_raw_ad_click';
		$this->aTaskList_constructive[] = 'afterAddTable__data_raw_ad_click';
		$this->aTaskList_constructive[] = 'beforeAddTable__data_raw_ad_impression';
		$this->aTaskList_constructive[] = 'afterAddTable__data_raw_ad_impression';
		$this->aTaskList_constructive[] = 'beforeAddTable__data_raw_ad_request';
		$this->aTaskList_constructive[] = 'afterAddTable__data_raw_ad_request';
		$this->aTaskList_constructive[] = 'beforeAddTable__data_raw_tracker_click';
		$this->aTaskList_constructive[] = 'afterAddTable__data_raw_tracker_click';
		$this->aTaskList_constructive[] = 'beforeAddTable__data_raw_tracker_impression';
		$this->aTaskList_constructive[] = 'afterAddTable__data_raw_tracker_impression';
		$this->aTaskList_constructive[] = 'beforeAddTable__data_raw_tracker_variable_value';
		$this->aTaskList_constructive[] = 'afterAddTable__data_raw_tracker_variable_value';
		$this->aTaskList_constructive[] = 'beforeAddTable__data_summary_ad_hourly';
		$this->aTaskList_constructive[] = 'afterAddTable__data_summary_ad_hourly';
		$this->aTaskList_constructive[] = 'beforeAddTable__data_summary_ad_zone_assoc';
		$this->aTaskList_constructive[] = 'afterAddTable__data_summary_ad_zone_assoc';
		$this->aTaskList_constructive[] = 'beforeAddTable__data_summary_channel_daily';
		$this->aTaskList_constructive[] = 'afterAddTable__data_summary_channel_daily';
		$this->aTaskList_constructive[] = 'beforeAddTable__data_summary_zone_country_daily';
		$this->aTaskList_constructive[] = 'afterAddTable__data_summary_zone_country_daily';
		$this->aTaskList_constructive[] = 'beforeAddTable__data_summary_zone_country_forecast';
		$this->aTaskList_constructive[] = 'afterAddTable__data_summary_zone_country_forecast';
		$this->aTaskList_constructive[] = 'beforeAddTable__data_summary_zone_country_monthly';
		$this->aTaskList_constructive[] = 'afterAddTable__data_summary_zone_country_monthly';
		$this->aTaskList_constructive[] = 'beforeAddTable__data_summary_zone_domain_page_daily';
		$this->aTaskList_constructive[] = 'afterAddTable__data_summary_zone_domain_page_daily';
		$this->aTaskList_constructive[] = 'beforeAddTable__data_summary_zone_domain_page_forecast';
		$this->aTaskList_constructive[] = 'afterAddTable__data_summary_zone_domain_page_forecast';
		$this->aTaskList_constructive[] = 'beforeAddTable__data_summary_zone_domain_page_monthly';
		$this->aTaskList_constructive[] = 'afterAddTable__data_summary_zone_domain_page_monthly';
		$this->aTaskList_constructive[] = 'beforeAddTable__data_summary_zone_impression_history';
		$this->aTaskList_constructive[] = 'afterAddTable__data_summary_zone_impression_history';
		$this->aTaskList_constructive[] = 'beforeAddTable__data_summary_zone_site_keyword_daily';
		$this->aTaskList_constructive[] = 'afterAddTable__data_summary_zone_site_keyword_daily';
		$this->aTaskList_constructive[] = 'beforeAddTable__data_summary_zone_site_keyword_forecast';
		$this->aTaskList_constructive[] = 'afterAddTable__data_summary_zone_site_keyword_forecast';
		$this->aTaskList_constructive[] = 'beforeAddTable__data_summary_zone_site_keyword_monthly';
		$this->aTaskList_constructive[] = 'afterAddTable__data_summary_zone_site_keyword_monthly';
		$this->aTaskList_constructive[] = 'beforeAddTable__data_summary_zone_source_daily';
		$this->aTaskList_constructive[] = 'afterAddTable__data_summary_zone_source_daily';
		$this->aTaskList_constructive[] = 'beforeAddTable__data_summary_zone_source_forecast';
		$this->aTaskList_constructive[] = 'afterAddTable__data_summary_zone_source_forecast';
		$this->aTaskList_constructive[] = 'beforeAddTable__data_summary_zone_source_monthly';
		$this->aTaskList_constructive[] = 'afterAddTable__data_summary_zone_source_monthly';
		$this->aTaskList_constructive[] = 'beforeAddTable__log_maintenance_forecasting';
		$this->aTaskList_constructive[] = 'afterAddTable__log_maintenance_forecasting';
		$this->aTaskList_constructive[] = 'beforeAddTable__log_maintenance_priority';
		$this->aTaskList_constructive[] = 'afterAddTable__log_maintenance_priority';
		$this->aTaskList_constructive[] = 'beforeAddTable__log_maintenance_statistics';
		$this->aTaskList_constructive[] = 'afterAddTable__log_maintenance_statistics';
		$this->aTaskList_constructive[] = 'beforeAddTable__plugins_channel_delivery_assoc';
		$this->aTaskList_constructive[] = 'afterAddTable__plugins_channel_delivery_assoc';
		$this->aTaskList_constructive[] = 'beforeAddTable__plugins_channel_delivery_domains';
		$this->aTaskList_constructive[] = 'afterAddTable__plugins_channel_delivery_domains';
		$this->aTaskList_constructive[] = 'beforeAddTable__plugins_channel_delivery_rules';
		$this->aTaskList_constructive[] = 'afterAddTable__plugins_channel_delivery_rules';
		$this->aTaskList_constructive[] = 'beforeAddTable__agency';
		$this->aTaskList_constructive[] = 'afterAddTable__agency';
		$this->aTaskList_constructive[] = 'beforeAddTable__campaigns';
		$this->aTaskList_constructive[] = 'afterAddTable__campaigns';
		$this->aTaskList_constructive[] = 'beforeAddTable__acls_channel';
		$this->aTaskList_constructive[] = 'afterAddTable__acls_channel';
		$this->aTaskList_constructive[] = 'beforeAddTable__channel';
		$this->aTaskList_constructive[] = 'afterAddTable__channel';
		$this->aTaskList_constructive[] = 'beforeAddTable__ad_category_assoc';
		$this->aTaskList_constructive[] = 'afterAddTable__ad_category_assoc';
		$this->aTaskList_constructive[] = 'beforeAddTable__category';
		$this->aTaskList_constructive[] = 'afterAddTable__category';
		$this->aTaskList_constructive[] = 'beforeAddTable__ad_zone_assoc';
		$this->aTaskList_constructive[] = 'afterAddTable__ad_zone_assoc';
		$this->aTaskList_constructive[] = 'beforeAddTable__placement_zone_assoc';
		$this->aTaskList_constructive[] = 'afterAddTable__placement_zone_assoc';
		$this->aTaskList_constructive[] = 'beforeAddTable__campaigns_trackers';
		$this->aTaskList_constructive[] = 'afterAddTable__campaigns_trackers';
		$this->aTaskList_constructive[] = 'beforeAddTable__tracker_append';
		$this->aTaskList_constructive[] = 'afterAddTable__tracker_append';
		$this->aTaskList_constructive[] = 'beforeAddTable__trackers';
		$this->aTaskList_constructive[] = 'afterAddTable__trackers';
		$this->aTaskList_constructive[] = 'beforeAddTable__variable_publisher';
		$this->aTaskList_constructive[] = 'afterAddTable__variable_publisher';
		$this->aTaskList_constructive[] = 'beforeAddTable__variables';
		$this->aTaskList_constructive[] = 'afterAddTable__variables';
		$this->aTaskList_constructive[] = 'beforeAddTable__preference';
		$this->aTaskList_constructive[] = 'afterAddTable__preference';
		$this->aTaskList_constructive[] = 'beforeAddTable__preference_advertiser';
		$this->aTaskList_constructive[] = 'afterAddTable__preference_advertiser';
		$this->aTaskList_constructive[] = 'beforeAddTable__preference_publisher';
		$this->aTaskList_constructive[] = 'afterAddTable__preference_publisher';
		$this->aTaskList_constructive[] = 'beforeAddTable__affiliates_extra';
		$this->aTaskList_constructive[] = 'afterAddTable__affiliates_extra';
		$this->aTaskList_constructive[] = 'beforeAddTable__password_recovery';
		$this->aTaskList_constructive[] = 'afterAddTable__password_recovery';
    }



	function beforeAddTable__application_variable()
	{
		return $this->beforeAddTable('application_variable');
	}

	function afterAddTable__application_variable()
	{
		return $this->afterAddTable('application_variable');
	}

	function beforeAddTable__data_intermediate_ad()
	{
		return $this->beforeAddTable('data_intermediate_ad');
	}

	function afterAddTable__data_intermediate_ad()
	{
		return $this->afterAddTable('data_intermediate_ad');
	}

	function beforeAddTable__data_intermediate_ad_connection()
	{
		return $this->beforeAddTable('data_intermediate_ad_connection');
	}

	function afterAddTable__data_intermediate_ad_connection()
	{
		return $this->afterAddTable('data_intermediate_ad_connection');
	}

	function beforeAddTable__data_intermediate_ad_variable_value()
	{
		return $this->beforeAddTable('data_intermediate_ad_variable_value');
	}

	function afterAddTable__data_intermediate_ad_variable_value()
	{
		return $this->afterAddTable('data_intermediate_ad_variable_value');
	}

	function beforeAddTable__data_raw_ad_click()
	{
		return $this->beforeAddTable('data_raw_ad_click');
	}

	function afterAddTable__data_raw_ad_click()
	{
		return $this->afterAddTable('data_raw_ad_click');
	}

	function beforeAddTable__data_raw_ad_impression()
	{
		return $this->beforeAddTable('data_raw_ad_impression');
	}

	function afterAddTable__data_raw_ad_impression()
	{
		return $this->afterAddTable('data_raw_ad_impression');
	}

	function beforeAddTable__data_raw_ad_request()
	{
		return $this->beforeAddTable('data_raw_ad_request');
	}

	function afterAddTable__data_raw_ad_request()
	{
		return $this->afterAddTable('data_raw_ad_request');
	}

	function beforeAddTable__data_raw_tracker_click()
	{
		return $this->beforeAddTable('data_raw_tracker_click');
	}

	function afterAddTable__data_raw_tracker_click()
	{
		return $this->afterAddTable('data_raw_tracker_click');
	}

	function beforeAddTable__data_raw_tracker_impression()
	{
		return $this->beforeAddTable('data_raw_tracker_impression');
	}

	function afterAddTable__data_raw_tracker_impression()
	{
		return $this->afterAddTable('data_raw_tracker_impression');
	}

	function beforeAddTable__data_raw_tracker_variable_value()
	{
		return $this->beforeAddTable('data_raw_tracker_variable_value');
	}

	function afterAddTable__data_raw_tracker_variable_value()
	{
		return $this->afterAddTable('data_raw_tracker_variable_value');
	}

	function beforeAddTable__data_summary_ad_hourly()
	{
		return $this->beforeAddTable('data_summary_ad_hourly');
	}

	function afterAddTable__data_summary_ad_hourly()
	{
	    $migration = new StatMigration();
	    $migration->init($this->oDBH);

		return $migration->migrateData() && $this->afterAddTable('data_summary_ad_hourly');
	}

	function beforeAddTable__data_summary_ad_zone_assoc()
	{
		return $this->beforeAddTable('data_summary_ad_zone_assoc');
	}

	function afterAddTable__data_summary_ad_zone_assoc()
	{
		return $this->afterAddTable('data_summary_ad_zone_assoc');
	}

	function beforeAddTable__data_summary_channel_daily()
	{
		return $this->beforeAddTable('data_summary_channel_daily');
	}

	function afterAddTable__data_summary_channel_daily()
	{
		return $this->afterAddTable('data_summary_channel_daily');
	}

	function beforeAddTable__data_summary_zone_country_daily()
	{
		return $this->beforeAddTable('data_summary_zone_country_daily');
	}

	function afterAddTable__data_summary_zone_country_daily()
	{
		return $this->afterAddTable('data_summary_zone_country_daily');
	}

	function beforeAddTable__data_summary_zone_country_forecast()
	{
		return $this->beforeAddTable('data_summary_zone_country_forecast');
	}

	function afterAddTable__data_summary_zone_country_forecast()
	{
		return $this->afterAddTable('data_summary_zone_country_forecast');
	}

	function beforeAddTable__data_summary_zone_country_monthly()
	{
		return $this->beforeAddTable('data_summary_zone_country_monthly');
	}

	function afterAddTable__data_summary_zone_country_monthly()
	{
		return $this->afterAddTable('data_summary_zone_country_monthly');
	}

	function beforeAddTable__data_summary_zone_domain_page_daily()
	{
		return $this->beforeAddTable('data_summary_zone_domain_page_daily');
	}

	function afterAddTable__data_summary_zone_domain_page_daily()
	{
		return $this->afterAddTable('data_summary_zone_domain_page_daily');
	}

	function beforeAddTable__data_summary_zone_domain_page_forecast()
	{
		return $this->beforeAddTable('data_summary_zone_domain_page_forecast');
	}

	function afterAddTable__data_summary_zone_domain_page_forecast()
	{
		return $this->afterAddTable('data_summary_zone_domain_page_forecast');
	}

	function beforeAddTable__data_summary_zone_domain_page_monthly()
	{
		return $this->beforeAddTable('data_summary_zone_domain_page_monthly');
	}

	function afterAddTable__data_summary_zone_domain_page_monthly()
	{
		return $this->afterAddTable('data_summary_zone_domain_page_monthly');
	}

	function beforeAddTable__data_summary_zone_impression_history()
	{
		return $this->beforeAddTable('data_summary_zone_impression_history');
	}

	function afterAddTable__data_summary_zone_impression_history()
	{
		return $this->afterAddTable('data_summary_zone_impression_history');
	}

	function beforeAddTable__data_summary_zone_site_keyword_daily()
	{
		return $this->beforeAddTable('data_summary_zone_site_keyword_daily');
	}

	function afterAddTable__data_summary_zone_site_keyword_daily()
	{
		return $this->afterAddTable('data_summary_zone_site_keyword_daily');
	}

	function beforeAddTable__data_summary_zone_site_keyword_forecast()
	{
		return $this->beforeAddTable('data_summary_zone_site_keyword_forecast');
	}

	function afterAddTable__data_summary_zone_site_keyword_forecast()
	{
		return $this->afterAddTable('data_summary_zone_site_keyword_forecast');
	}

	function beforeAddTable__data_summary_zone_site_keyword_monthly()
	{
		return $this->beforeAddTable('data_summary_zone_site_keyword_monthly');
	}

	function afterAddTable__data_summary_zone_site_keyword_monthly()
	{
		return $this->afterAddTable('data_summary_zone_site_keyword_monthly');
	}

	function beforeAddTable__data_summary_zone_source_daily()
	{
		return $this->beforeAddTable('data_summary_zone_source_daily');
	}

	function afterAddTable__data_summary_zone_source_daily()
	{
		return $this->afterAddTable('data_summary_zone_source_daily');
	}

	function beforeAddTable__data_summary_zone_source_forecast()
	{
		return $this->beforeAddTable('data_summary_zone_source_forecast');
	}

	function afterAddTable__data_summary_zone_source_forecast()
	{
		return $this->afterAddTable('data_summary_zone_source_forecast');
	}

	function beforeAddTable__data_summary_zone_source_monthly()
	{
		return $this->beforeAddTable('data_summary_zone_source_monthly');
	}

	function afterAddTable__data_summary_zone_source_monthly()
	{
		return $this->afterAddTable('data_summary_zone_source_monthly');
	}

	function beforeAddTable__log_maintenance_forecasting()
	{
		return $this->beforeAddTable('log_maintenance_forecasting');
	}

	function afterAddTable__log_maintenance_forecasting()
	{
		return $this->afterAddTable('log_maintenance_forecasting');
	}

	function beforeAddTable__log_maintenance_priority()
	{
		return $this->beforeAddTable('log_maintenance_priority');
	}

	function afterAddTable__log_maintenance_priority()
	{
		return $this->afterAddTable('log_maintenance_priority');
	}

	function beforeAddTable__log_maintenance_statistics()
	{
		return $this->beforeAddTable('log_maintenance_statistics');
	}

	function afterAddTable__log_maintenance_statistics()
	{
		return $this->afterAddTable('log_maintenance_statistics');
	}

	function beforeAddTable__plugins_channel_delivery_assoc()
	{
		return $this->beforeAddTable('plugins_channel_delivery_assoc');
	}

	function afterAddTable__plugins_channel_delivery_assoc()
	{
		return $this->afterAddTable('plugins_channel_delivery_assoc');
	}

	function beforeAddTable__plugins_channel_delivery_domains()
	{
		return $this->beforeAddTable('plugins_channel_delivery_domains');
	}

	function afterAddTable__plugins_channel_delivery_domains()
	{
		return $this->afterAddTable('plugins_channel_delivery_domains');
	}

	function beforeAddTable__plugins_channel_delivery_rules()
	{
		return $this->beforeAddTable('plugins_channel_delivery_rules');
	}

	function afterAddTable__plugins_channel_delivery_rules()
	{
		return $this->afterAddTable('plugins_channel_delivery_rules');
	}

	function beforeAddTable__agency()
	{
		return $this->beforeAddTable('agency');
	}

	function afterAddTable__agency()
	{
		return $this->afterAddTable('agency');
	}

	function beforeAddTable__campaigns()
	{
		return $this->beforeAddTable('campaigns');
	}

	function afterAddTable__campaigns()
	{
		return $this->afterAddTable('campaigns');
	}

	function beforeAddTable__acls_channel()
	{
		return $this->beforeAddTable('acls_channel');
	}

	function afterAddTable__acls_channel()
	{
		return $this->afterAddTable('acls_channel');
	}

	function beforeAddTable__channel()
	{
		return $this->beforeAddTable('channel');
	}

	function afterAddTable__channel()
	{
		return $this->afterAddTable('channel');
	}

	function beforeAddTable__ad_category_assoc()
	{
		return $this->beforeAddTable('ad_category_assoc');
	}

	function afterAddTable__ad_category_assoc()
	{
		return $this->afterAddTable('ad_category_assoc');
	}

	function beforeAddTable__category()
	{
		return $this->beforeAddTable('category');
	}

	function afterAddTable__category()
	{
		return $this->afterAddTable('category');
	}

	function beforeAddTable__ad_zone_assoc()
	{
		return $this->beforeAddTable('ad_zone_assoc');
	}

	function afterAddTable__ad_zone_assoc()
	{
		return $this->afterAddTable('ad_zone_assoc');
	}

	function beforeAddTable__placement_zone_assoc()
	{
		return $this->beforeAddTable('placement_zone_assoc');
	}

	function afterAddTable__placement_zone_assoc()
	{
		return $this->afterAddTable('placement_zone_assoc');
	}

	function beforeAddTable__campaigns_trackers()
	{
		return $this->beforeAddTable('campaigns_trackers');
	}

	function afterAddTable__campaigns_trackers()
	{
		return $this->afterAddTable('campaigns_trackers');
	}

	function beforeAddTable__tracker_append()
	{
		return $this->beforeAddTable('tracker_append');
	}

	function afterAddTable__tracker_append()
	{
		return $this->afterAddTable('tracker_append');
	}

	function beforeAddTable__trackers()
	{
		return $this->beforeAddTable('trackers');
	}

	function afterAddTable__trackers()
	{
		return $this->afterAddTable('trackers');
	}

	function beforeAddTable__variable_publisher()
	{
		return $this->beforeAddTable('variable_publisher');
	}

	function afterAddTable__variable_publisher()
	{
		return $this->afterAddTable('variable_publisher');
	}

	function beforeAddTable__variables()
	{
		return $this->beforeAddTable('variables');
	}

	function afterAddTable__variables()
	{
		return $this->afterAddTable('variables');
	}

	function beforeAddTable__preference()
	{
		return $this->beforeAddTable('preference');
	}

	function afterAddTable__preference()
	{
	    $migration = new Migration_119();
	    $migration->init($this->oDBH);

		return $migration->migrateData() && $this->afterAddTable('preference');
	}

	function beforeAddTable__preference_advertiser()
	{
		return $this->beforeAddTable('preference_advertiser');
	}

	function afterAddTable__preference_advertiser()
	{
		return $this->afterAddTable('preference_advertiser');
	}

	function beforeAddTable__preference_publisher()
	{
		return $this->beforeAddTable('preference_publisher');
	}

	function afterAddTable__preference_publisher()
	{
		return $this->afterAddTable('preference_publisher');
	}

	function beforeAddTable__affiliates_extra()
	{
		return $this->beforeAddTable('affiliates_extra');
	}

	function afterAddTable__affiliates_extra()
	{
		return $this->afterAddTable('affiliates_extra');
	}

	function beforeAddTable__password_recovery()
	{
		return $this->beforeAddTable('password_recovery');
	}

	function afterAddTable__password_recovery()
	{
		return $this->afterAddTable('password_recovery');
	}

}

?>