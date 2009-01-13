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

require_once(MAX_PATH.'/lib/OA/Upgrade/Migration.php');

class Migration_516 extends Migration
{

    function Migration_516()
    {
        //$this->__construct();

		$this->aTaskList_destructive[] = 'beforeRemoveTable__data_summary_zone_country_daily';
		$this->aTaskList_destructive[] = 'afterRemoveTable__data_summary_zone_country_daily';
		$this->aTaskList_destructive[] = 'beforeRemoveTable__data_summary_zone_country_forecast';
		$this->aTaskList_destructive[] = 'afterRemoveTable__data_summary_zone_country_forecast';
		$this->aTaskList_destructive[] = 'beforeRemoveTable__data_summary_zone_country_monthly';
		$this->aTaskList_destructive[] = 'afterRemoveTable__data_summary_zone_country_monthly';
		$this->aTaskList_destructive[] = 'beforeRemoveTable__data_summary_zone_domain_page_daily';
		$this->aTaskList_destructive[] = 'afterRemoveTable__data_summary_zone_domain_page_daily';
		$this->aTaskList_destructive[] = 'beforeRemoveTable__data_summary_zone_domain_page_forecast';
		$this->aTaskList_destructive[] = 'afterRemoveTable__data_summary_zone_domain_page_forecast';
		$this->aTaskList_destructive[] = 'beforeRemoveTable__data_summary_zone_domain_page_monthly';
		$this->aTaskList_destructive[] = 'afterRemoveTable__data_summary_zone_domain_page_monthly';
		$this->aTaskList_destructive[] = 'beforeRemoveTable__data_summary_zone_site_keyword_daily';
		$this->aTaskList_destructive[] = 'afterRemoveTable__data_summary_zone_site_keyword_daily';
		$this->aTaskList_destructive[] = 'beforeRemoveTable__data_summary_zone_site_keyword_forecast';
		$this->aTaskList_destructive[] = 'afterRemoveTable__data_summary_zone_site_keyword_forecast';
		$this->aTaskList_destructive[] = 'beforeRemoveTable__data_summary_zone_site_keyword_monthly';
		$this->aTaskList_destructive[] = 'afterRemoveTable__data_summary_zone_site_keyword_monthly';
		$this->aTaskList_destructive[] = 'beforeRemoveTable__data_summary_zone_source_daily';
		$this->aTaskList_destructive[] = 'afterRemoveTable__data_summary_zone_source_daily';
		$this->aTaskList_destructive[] = 'beforeRemoveTable__data_summary_zone_source_forecast';
		$this->aTaskList_destructive[] = 'afterRemoveTable__data_summary_zone_source_forecast';
		$this->aTaskList_destructive[] = 'beforeRemoveTable__data_summary_zone_source_monthly';
		$this->aTaskList_destructive[] = 'afterRemoveTable__data_summary_zone_source_monthly';


    }



	function beforeRemoveTable__data_summary_zone_country_daily()
	{
		return $this->beforeRemoveTable('data_summary_zone_country_daily');
	}

	function afterRemoveTable__data_summary_zone_country_daily()
	{
		return $this->afterRemoveTable('data_summary_zone_country_daily');
	}

	function beforeRemoveTable__data_summary_zone_country_forecast()
	{
		return $this->beforeRemoveTable('data_summary_zone_country_forecast');
	}

	function afterRemoveTable__data_summary_zone_country_forecast()
	{
		return $this->afterRemoveTable('data_summary_zone_country_forecast');
	}

	function beforeRemoveTable__data_summary_zone_country_monthly()
	{
		return $this->beforeRemoveTable('data_summary_zone_country_monthly');
	}

	function afterRemoveTable__data_summary_zone_country_monthly()
	{
		return $this->afterRemoveTable('data_summary_zone_country_monthly');
	}

	function beforeRemoveTable__data_summary_zone_domain_page_daily()
	{
		return $this->beforeRemoveTable('data_summary_zone_domain_page_daily');
	}

	function afterRemoveTable__data_summary_zone_domain_page_daily()
	{
		return $this->afterRemoveTable('data_summary_zone_domain_page_daily');
	}

	function beforeRemoveTable__data_summary_zone_domain_page_forecast()
	{
		return $this->beforeRemoveTable('data_summary_zone_domain_page_forecast');
	}

	function afterRemoveTable__data_summary_zone_domain_page_forecast()
	{
		return $this->afterRemoveTable('data_summary_zone_domain_page_forecast');
	}

	function beforeRemoveTable__data_summary_zone_domain_page_monthly()
	{
		return $this->beforeRemoveTable('data_summary_zone_domain_page_monthly');
	}

	function afterRemoveTable__data_summary_zone_domain_page_monthly()
	{
		return $this->afterRemoveTable('data_summary_zone_domain_page_monthly');
	}

	function beforeRemoveTable__data_summary_zone_site_keyword_daily()
	{
		return $this->beforeRemoveTable('data_summary_zone_site_keyword_daily');
	}

	function afterRemoveTable__data_summary_zone_site_keyword_daily()
	{
		return $this->afterRemoveTable('data_summary_zone_site_keyword_daily');
	}

	function beforeRemoveTable__data_summary_zone_site_keyword_forecast()
	{
		return $this->beforeRemoveTable('data_summary_zone_site_keyword_forecast');
	}

	function afterRemoveTable__data_summary_zone_site_keyword_forecast()
	{
		return $this->afterRemoveTable('data_summary_zone_site_keyword_forecast');
	}

	function beforeRemoveTable__data_summary_zone_site_keyword_monthly()
	{
		return $this->beforeRemoveTable('data_summary_zone_site_keyword_monthly');
	}

	function afterRemoveTable__data_summary_zone_site_keyword_monthly()
	{
		return $this->afterRemoveTable('data_summary_zone_site_keyword_monthly');
	}

	function beforeRemoveTable__data_summary_zone_source_daily()
	{
		return $this->beforeRemoveTable('data_summary_zone_source_daily');
	}

	function afterRemoveTable__data_summary_zone_source_daily()
	{
		return $this->afterRemoveTable('data_summary_zone_source_daily');
	}

	function beforeRemoveTable__data_summary_zone_source_forecast()
	{
		return $this->beforeRemoveTable('data_summary_zone_source_forecast');
	}

	function afterRemoveTable__data_summary_zone_source_forecast()
	{
		return $this->afterRemoveTable('data_summary_zone_source_forecast');
	}

	function beforeRemoveTable__data_summary_zone_source_monthly()
	{
		return $this->beforeRemoveTable('data_summary_zone_source_monthly');
	}

	function afterRemoveTable__data_summary_zone_source_monthly()
	{
		return $this->afterRemoveTable('data_summary_zone_source_monthly');
	}

}

?>