<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
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

class Migration_536 extends Migration
{

    function Migration_536()
    {
        //$this->__construct();

		$this->aTaskList_destructive[] = 'beforeRemoveField__data_raw_ad_request__country';
		$this->aTaskList_destructive[] = 'afterRemoveField__data_raw_ad_request__country';
		$this->aTaskList_destructive[] = 'beforeRemoveField__data_raw_ad_request__geo_region';
		$this->aTaskList_destructive[] = 'afterRemoveField__data_raw_ad_request__geo_region';
		$this->aTaskList_destructive[] = 'beforeRemoveField__data_raw_ad_request__geo_city';
		$this->aTaskList_destructive[] = 'afterRemoveField__data_raw_ad_request__geo_city';
		$this->aTaskList_destructive[] = 'beforeRemoveField__data_raw_ad_request__geo_postal_code';
		$this->aTaskList_destructive[] = 'afterRemoveField__data_raw_ad_request__geo_postal_code';
		$this->aTaskList_destructive[] = 'beforeRemoveField__data_raw_ad_request__geo_latitude';
		$this->aTaskList_destructive[] = 'afterRemoveField__data_raw_ad_request__geo_latitude';
		$this->aTaskList_destructive[] = 'beforeRemoveField__data_raw_ad_request__geo_longitude';
		$this->aTaskList_destructive[] = 'afterRemoveField__data_raw_ad_request__geo_longitude';
		$this->aTaskList_destructive[] = 'beforeRemoveField__data_raw_ad_request__geo_dma_code';
		$this->aTaskList_destructive[] = 'afterRemoveField__data_raw_ad_request__geo_dma_code';
		$this->aTaskList_destructive[] = 'beforeRemoveField__data_raw_ad_request__geo_area_code';
		$this->aTaskList_destructive[] = 'afterRemoveField__data_raw_ad_request__geo_area_code';
		$this->aTaskList_destructive[] = 'beforeRemoveField__data_raw_ad_request__geo_organisation';
		$this->aTaskList_destructive[] = 'afterRemoveField__data_raw_ad_request__geo_organisation';
		$this->aTaskList_destructive[] = 'beforeRemoveField__data_raw_ad_request__geo_netspeed';
		$this->aTaskList_destructive[] = 'afterRemoveField__data_raw_ad_request__geo_netspeed';
		$this->aTaskList_destructive[] = 'beforeRemoveField__data_raw_ad_request__geo_continent';
		$this->aTaskList_destructive[] = 'afterRemoveField__data_raw_ad_request__geo_continent';


    }



	function beforeRemoveField__data_raw_ad_request__country()
	{
		return $this->beforeRemoveField('data_raw_ad_request', 'country');
	}

	function afterRemoveField__data_raw_ad_request__country()
	{
		return $this->afterRemoveField('data_raw_ad_request', 'country');
	}

	function beforeRemoveField__data_raw_ad_request__geo_region()
	{
		return $this->beforeRemoveField('data_raw_ad_request', 'geo_region');
	}

	function afterRemoveField__data_raw_ad_request__geo_region()
	{
		return $this->afterRemoveField('data_raw_ad_request', 'geo_region');
	}

	function beforeRemoveField__data_raw_ad_request__geo_city()
	{
		return $this->beforeRemoveField('data_raw_ad_request', 'geo_city');
	}

	function afterRemoveField__data_raw_ad_request__geo_city()
	{
		return $this->afterRemoveField('data_raw_ad_request', 'geo_city');
	}

	function beforeRemoveField__data_raw_ad_request__geo_postal_code()
	{
		return $this->beforeRemoveField('data_raw_ad_request', 'geo_postal_code');
	}

	function afterRemoveField__data_raw_ad_request__geo_postal_code()
	{
		return $this->afterRemoveField('data_raw_ad_request', 'geo_postal_code');
	}

	function beforeRemoveField__data_raw_ad_request__geo_latitude()
	{
		return $this->beforeRemoveField('data_raw_ad_request', 'geo_latitude');
	}

	function afterRemoveField__data_raw_ad_request__geo_latitude()
	{
		return $this->afterRemoveField('data_raw_ad_request', 'geo_latitude');
	}

	function beforeRemoveField__data_raw_ad_request__geo_longitude()
	{
		return $this->beforeRemoveField('data_raw_ad_request', 'geo_longitude');
	}

	function afterRemoveField__data_raw_ad_request__geo_longitude()
	{
		return $this->afterRemoveField('data_raw_ad_request', 'geo_longitude');
	}

	function beforeRemoveField__data_raw_ad_request__geo_dma_code()
	{
		return $this->beforeRemoveField('data_raw_ad_request', 'geo_dma_code');
	}

	function afterRemoveField__data_raw_ad_request__geo_dma_code()
	{
		return $this->afterRemoveField('data_raw_ad_request', 'geo_dma_code');
	}

	function beforeRemoveField__data_raw_ad_request__geo_area_code()
	{
		return $this->beforeRemoveField('data_raw_ad_request', 'geo_area_code');
	}

	function afterRemoveField__data_raw_ad_request__geo_area_code()
	{
		return $this->afterRemoveField('data_raw_ad_request', 'geo_area_code');
	}

	function beforeRemoveField__data_raw_ad_request__geo_organisation()
	{
		return $this->beforeRemoveField('data_raw_ad_request', 'geo_organisation');
	}

	function afterRemoveField__data_raw_ad_request__geo_organisation()
	{
		return $this->afterRemoveField('data_raw_ad_request', 'geo_organisation');
	}

	function beforeRemoveField__data_raw_ad_request__geo_netspeed()
	{
		return $this->beforeRemoveField('data_raw_ad_request', 'geo_netspeed');
	}

	function afterRemoveField__data_raw_ad_request__geo_netspeed()
	{
		return $this->afterRemoveField('data_raw_ad_request', 'geo_netspeed');
	}

	function beforeRemoveField__data_raw_ad_request__geo_continent()
	{
		return $this->beforeRemoveField('data_raw_ad_request', 'geo_continent');
	}

	function afterRemoveField__data_raw_ad_request__geo_continent()
	{
		return $this->afterRemoveField('data_raw_ad_request', 'geo_continent');
	}

}

?>