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
$Id: Acls.dal.test.php 5552 2007-04-03 19:52:40Z andrew.hill@openads.org $
*/

require_once(MAX_PATH.'/lib/OA/Upgrade/Migration.php');
require_once MAX_PATH . '/etc/changes/StatMigration.php';

class Migration_110 extends Migration
{

    function Migration_110()
    {
        //$this->__construct();

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
		return $this->afterAddTable('data_summary_ad_hourly');
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
	    $migration = new StatMigration();
	    $migration->init($this->oDBH);

		return $migration->migrateData() && $this->afterAddTable('data_summary_zone_source_monthly');
	}

}

?>