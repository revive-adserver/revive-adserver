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

class Migration_001 extends Migration
{

    function Migration_001()
    {
        //$this->__construct();

		$this->aTaskList_constructive[] = 'beforeAddTable__ext_market_assoc_data';
		$this->aTaskList_constructive[] = 'afterAddTable__ext_market_assoc_data';
		$this->aTaskList_constructive[] = 'beforeAddTable__ext_market_campaign_pref';
		$this->aTaskList_constructive[] = 'afterAddTable__ext_market_campaign_pref';
		$this->aTaskList_constructive[] = 'beforeAddTable__ext_market_setting';
		$this->aTaskList_constructive[] = 'afterAddTable__ext_market_setting';
		$this->aTaskList_constructive[] = 'beforeAddTable__ext_market_web_stats';
		$this->aTaskList_constructive[] = 'afterAddTable__ext_market_web_stats';
		$this->aTaskList_constructive[] = 'beforeAddTable__ext_market_website_pref';
		$this->aTaskList_constructive[] = 'afterAddTable__ext_market_website_pref';


    }



	function beforeAddTable__ext_market_assoc_data()
	{
		return $this->beforeAddTable('ext_market_assoc_data');
	}

	function afterAddTable__ext_market_assoc_data()
	{
		return $this->afterAddTable('ext_market_assoc_data');
	}

	function beforeAddTable__ext_market_campaign_pref()
	{
		return $this->beforeAddTable('ext_market_campaign_pref');
	}

	function afterAddTable__ext_market_campaign_pref()
	{
		return $this->afterAddTable('ext_market_campaign_pref');
	}

	function beforeAddTable__ext_market_setting()
	{
		return $this->beforeAddTable('ext_market_setting');
	}

	function afterAddTable__ext_market_setting()
	{
		return $this->afterAddTable('ext_market_setting');
	}

	function beforeAddTable__ext_market_web_stats()
	{
		return $this->beforeAddTable('ext_market_web_stats');
	}

	function afterAddTable__ext_market_web_stats()
	{
		return $this->afterAddTable('ext_market_web_stats');
	}

	function beforeAddTable__ext_market_website_pref()
	{
		return $this->beforeAddTable('ext_market_website_pref');
	}

	function afterAddTable__ext_market_website_pref()
	{
		return $this->afterAddTable('ext_market_website_pref');
	}

}

?>