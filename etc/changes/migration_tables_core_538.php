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

class Migration_538 extends Migration
{

    function Migration_538()
    {
        //$this->__construct();

		$this->aTaskList_constructive[] = 'beforeAddField__data_intermediate_ad__date_time';
		$this->aTaskList_constructive[] = 'afterAddField__data_intermediate_ad__date_time';
		$this->aTaskList_constructive[] = 'beforeAddIndex__data_intermediate_ad__ad_id_date_time';
		$this->aTaskList_constructive[] = 'afterAddIndex__data_intermediate_ad__ad_id_date_time';
		$this->aTaskList_constructive[] = 'beforeAddIndex__data_intermediate_ad__zone_id_date_time';
		$this->aTaskList_constructive[] = 'afterAddIndex__data_intermediate_ad__zone_id_date_time';
		$this->aTaskList_constructive[] = 'beforeAddIndex__data_intermediate_ad__date_time';
		$this->aTaskList_constructive[] = 'afterAddIndex__data_intermediate_ad__date_time';
		$this->aTaskList_constructive[] = 'beforeAddIndex__data_intermediate_ad__interval_start';
		$this->aTaskList_constructive[] = 'afterAddIndex__data_intermediate_ad__interval_start';
		$this->aTaskList_constructive[] = 'beforeRemoveIndex__data_intermediate_ad__data_intermediate_ad_day';
		$this->aTaskList_constructive[] = 'afterRemoveIndex__data_intermediate_ad__data_intermediate_ad_day';
		$this->aTaskList_constructive[] = 'beforeRemoveIndex__data_intermediate_ad__data_intermediate_ad_operation_interval_id';
		$this->aTaskList_constructive[] = 'afterRemoveIndex__data_intermediate_ad__data_intermediate_ad_operation_interval_id';
		$this->aTaskList_constructive[] = 'beforeRemoveIndex__data_intermediate_ad__data_intermediate_ad_ad_id';
		$this->aTaskList_constructive[] = 'afterRemoveIndex__data_intermediate_ad__data_intermediate_ad_ad_id';
		$this->aTaskList_constructive[] = 'beforeRemoveIndex__data_intermediate_ad__data_intermediate_ad_zone_id';
		$this->aTaskList_constructive[] = 'afterRemoveIndex__data_intermediate_ad__data_intermediate_ad_zone_id';
		$this->aTaskList_constructive[] = 'beforeAddField__data_summary_ad_hourly__date_time';
		$this->aTaskList_constructive[] = 'afterAddField__data_summary_ad_hourly__date_time';
		$this->aTaskList_constructive[] = 'beforeAddIndex__data_summary_ad_hourly__date_time';
		$this->aTaskList_constructive[] = 'afterAddIndex__data_summary_ad_hourly__date_time';
		$this->aTaskList_constructive[] = 'beforeAddIndex__data_summary_ad_hourly__ad_id_date_time';
		$this->aTaskList_constructive[] = 'afterAddIndex__data_summary_ad_hourly__ad_id_date_time';
		$this->aTaskList_constructive[] = 'beforeAddIndex__data_summary_ad_hourly__zone_id_date_time';
		$this->aTaskList_constructive[] = 'afterAddIndex__data_summary_ad_hourly__zone_id_date_time';
		$this->aTaskList_constructive[] = 'beforeRemoveIndex__data_summary_ad_hourly__data_summary_ad_hourly_day';
		$this->aTaskList_constructive[] = 'afterRemoveIndex__data_summary_ad_hourly__data_summary_ad_hourly_day';
		$this->aTaskList_constructive[] = 'beforeRemoveIndex__data_summary_ad_hourly__data_summary_ad_hourly_hour';
		$this->aTaskList_constructive[] = 'afterRemoveIndex__data_summary_ad_hourly__data_summary_ad_hourly_hour';
		$this->aTaskList_constructive[] = 'beforeRemoveIndex__data_summary_ad_hourly__data_summary_ad_hourly_ad_id';
		$this->aTaskList_constructive[] = 'afterRemoveIndex__data_summary_ad_hourly__data_summary_ad_hourly_ad_id';
		$this->aTaskList_constructive[] = 'beforeRemoveIndex__data_summary_ad_hourly__data_summary_ad_hourly_zone_id';
		$this->aTaskList_constructive[] = 'afterRemoveIndex__data_summary_ad_hourly__data_summary_ad_hourly_zone_id';
		$this->aTaskList_destructive[] = 'beforeRemoveField__data_intermediate_ad__day';
		$this->aTaskList_destructive[] = 'afterRemoveField__data_intermediate_ad__day';
		$this->aTaskList_destructive[] = 'beforeRemoveField__data_intermediate_ad__hour';
		$this->aTaskList_destructive[] = 'afterRemoveField__data_intermediate_ad__hour';
		$this->aTaskList_destructive[] = 'beforeRemoveField__data_summary_ad_hourly__day';
		$this->aTaskList_destructive[] = 'afterRemoveField__data_summary_ad_hourly__day';
		$this->aTaskList_destructive[] = 'beforeRemoveField__data_summary_ad_hourly__hour';
		$this->aTaskList_destructive[] = 'afterRemoveField__data_summary_ad_hourly__hour';


		$this->aObjectMap['data_intermediate_ad']['date_time'] = array('fromTable'=>'data_intermediate_ad', 'fromField'=>'date_time');
		$this->aObjectMap['data_summary_ad_hourly']['date_time'] = array('fromTable'=>'data_summary_ad_hourly', 'fromField'=>'date_time');
    }



	function beforeAddField__data_intermediate_ad__date_time()
	{
		return $this->beforeAddField('data_intermediate_ad', 'date_time');
	}

	function afterAddField__data_intermediate_ad__date_time()
	{
		return $this->migrateDayHour('data_intermediate_ad') && $this->afterAddField('data_intermediate_ad', 'date_time');
	}

	function beforeAddIndex__data_intermediate_ad__ad_id_date_time()
	{
		return $this->beforeAddIndex('data_intermediate_ad', 'ad_id_date_time');
	}

	function afterAddIndex__data_intermediate_ad__ad_id_date_time()
	{
		return $this->afterAddIndex('data_intermediate_ad', 'ad_id_date_time');
	}

	function beforeAddIndex__data_intermediate_ad__zone_id_date_time()
	{
		return $this->beforeAddIndex('data_intermediate_ad', 'zone_id_date_time');
	}

	function afterAddIndex__data_intermediate_ad__zone_id_date_time()
	{
		return $this->afterAddIndex('data_intermediate_ad', 'zone_id_date_time');
	}

	function beforeAddIndex__data_intermediate_ad__date_time()
	{
		return $this->beforeAddIndex('data_intermediate_ad', 'date_time');
	}

	function afterAddIndex__data_intermediate_ad__date_time()
	{
		return $this->afterAddIndex('data_intermediate_ad', 'date_time');
	}

	function beforeAddIndex__data_intermediate_ad__interval_start()
	{
		return $this->beforeAddIndex('data_intermediate_ad', 'interval_start');
	}

	function afterAddIndex__data_intermediate_ad__interval_start()
	{
		return $this->afterAddIndex('data_intermediate_ad', 'interval_start');
	}

	function beforeRemoveIndex__data_intermediate_ad__data_intermediate_ad_day()
	{
		return $this->beforeRemoveIndex('data_intermediate_ad', 'data_intermediate_ad_day');
	}

	function afterRemoveIndex__data_intermediate_ad__data_intermediate_ad_day()
	{
		return $this->afterRemoveIndex('data_intermediate_ad', 'data_intermediate_ad_day');
	}

	function beforeRemoveIndex__data_intermediate_ad__data_intermediate_ad_operation_interval_id()
	{
		return $this->beforeRemoveIndex('data_intermediate_ad', 'data_intermediate_ad_operation_interval_id');
	}

	function afterRemoveIndex__data_intermediate_ad__data_intermediate_ad_operation_interval_id()
	{
		return $this->afterRemoveIndex('data_intermediate_ad', 'data_intermediate_ad_operation_interval_id');
	}

	function beforeRemoveIndex__data_intermediate_ad__data_intermediate_ad_ad_id()
	{
		return $this->beforeRemoveIndex('data_intermediate_ad', 'data_intermediate_ad_ad_id');
	}

	function afterRemoveIndex__data_intermediate_ad__data_intermediate_ad_ad_id()
	{
		return $this->afterRemoveIndex('data_intermediate_ad', 'data_intermediate_ad_ad_id');
	}

	function beforeRemoveIndex__data_intermediate_ad__data_intermediate_ad_zone_id()
	{
		return $this->beforeRemoveIndex('data_intermediate_ad', 'data_intermediate_ad_zone_id');
	}

	function afterRemoveIndex__data_intermediate_ad__data_intermediate_ad_zone_id()
	{
		return $this->afterRemoveIndex('data_intermediate_ad', 'data_intermediate_ad_zone_id');
	}

	function beforeAddField__data_summary_ad_hourly__date_time()
	{
		return $this->beforeAddField('data_summary_ad_hourly', 'date_time');
	}

	function afterAddField__data_summary_ad_hourly__date_time()
	{
		return $this->migrateDayHour('data_summary_ad_hourly') && $this->afterAddField('data_summary_ad_hourly', 'date_time');
	}

	function beforeAddIndex__data_summary_ad_hourly__date_time()
	{
		return $this->beforeAddIndex('data_summary_ad_hourly', 'date_time');
	}

	function afterAddIndex__data_summary_ad_hourly__date_time()
	{
		return $this->afterAddIndex('data_summary_ad_hourly', 'date_time');
	}

	function beforeAddIndex__data_summary_ad_hourly__ad_id_date_time()
	{
		return $this->beforeAddIndex('data_summary_ad_hourly', 'ad_id_date_time');
	}

	function afterAddIndex__data_summary_ad_hourly__ad_id_date_time()
	{
		return $this->afterAddIndex('data_summary_ad_hourly', 'ad_id_date_time');
	}

	function beforeAddIndex__data_summary_ad_hourly__zone_id_date_time()
	{
		return $this->beforeAddIndex('data_summary_ad_hourly', 'zone_id_date_time');
	}

	function afterAddIndex__data_summary_ad_hourly__zone_id_date_time()
	{
		return $this->afterAddIndex('data_summary_ad_hourly', 'zone_id_date_time');
	}

	function beforeRemoveIndex__data_summary_ad_hourly__data_summary_ad_hourly_day()
	{
		return $this->beforeRemoveIndex('data_summary_ad_hourly', 'data_summary_ad_hourly_day');
	}

	function afterRemoveIndex__data_summary_ad_hourly__data_summary_ad_hourly_day()
	{
		return $this->afterRemoveIndex('data_summary_ad_hourly', 'data_summary_ad_hourly_day');
	}

	function beforeRemoveIndex__data_summary_ad_hourly__data_summary_ad_hourly_hour()
	{
		return $this->beforeRemoveIndex('data_summary_ad_hourly', 'data_summary_ad_hourly_hour');
	}

	function afterRemoveIndex__data_summary_ad_hourly__data_summary_ad_hourly_hour()
	{
		return $this->afterRemoveIndex('data_summary_ad_hourly', 'data_summary_ad_hourly_hour');
	}

	function beforeRemoveIndex__data_summary_ad_hourly__data_summary_ad_hourly_ad_id()
	{
		return $this->beforeRemoveIndex('data_summary_ad_hourly', 'data_summary_ad_hourly_ad_id');
	}

	function afterRemoveIndex__data_summary_ad_hourly__data_summary_ad_hourly_ad_id()
	{
		return $this->afterRemoveIndex('data_summary_ad_hourly', 'data_summary_ad_hourly_ad_id');
	}

	function beforeRemoveIndex__data_summary_ad_hourly__data_summary_ad_hourly_zone_id()
	{
		return $this->beforeRemoveIndex('data_summary_ad_hourly', 'data_summary_ad_hourly_zone_id');
	}

	function afterRemoveIndex__data_summary_ad_hourly__data_summary_ad_hourly_zone_id()
	{
		return $this->afterRemoveIndex('data_summary_ad_hourly', 'data_summary_ad_hourly_zone_id');
	}

	function beforeRemoveField__data_intermediate_ad__day()
	{
		return $this->beforeRemoveField('data_intermediate_ad', 'day');
	}

	function afterRemoveField__data_intermediate_ad__day()
	{
		return $this->afterRemoveField('data_intermediate_ad', 'day');
	}

	function beforeRemoveField__data_intermediate_ad__hour()
	{
		return $this->beforeRemoveField('data_intermediate_ad', 'hour');
	}

	function afterRemoveField__data_intermediate_ad__hour()
	{
		return $this->afterRemoveField('data_intermediate_ad', 'hour');
	}

	function beforeRemoveField__data_summary_ad_hourly__day()
	{
		return $this->beforeRemoveField('data_summary_ad_hourly', 'day');
	}

	function afterRemoveField__data_summary_ad_hourly__day()
	{
		return $this->afterRemoveField('data_summary_ad_hourly', 'day');
	}

	function beforeRemoveField__data_summary_ad_hourly__hour()
	{
		return $this->beforeRemoveField('data_summary_ad_hourly', 'hour');
	}

	function afterRemoveField__data_summary_ad_hourly__hour()
	{
		return $this->afterRemoveField('data_summary_ad_hourly', 'hour');
	}

	function migrateDayHour($table)
	{
	    $prefix = $GLOBALS['_MAX']['CONF']['table']['prefix'];
	    $tableName = $this->oDBH->quoteIdentifier($prefix.$table, true);

	    if ($this->oDBH->dbsyntax == 'pgsql') {
    	    $query = "UPDATE {$tableName} SET date_time = {$tableName}.day::timestamp + ({$tableName}.hour || ' hours')::interval";
	    } else {
    	    $query = "UPDATE {$tableName} SET date_time = DATE_ADD({$tableName}.day, interval {$tableName}.hour hour)";
	    }

	    $result = $this->oDBH->exec($query);
	    if (PEAR::isError($result)) {
	        return $this->_logErrorAndReturnFalse('Cannot migrate '.$table);
	    }

	    return true;
	}

}

?>