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

require_once(MAX_PATH . '/lib/OA/Upgrade/Migration.php');

class Migration_538 extends Migration
{
    public function __construct()
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


        $this->aObjectMap['data_intermediate_ad']['date_time'] = ['fromTable' => 'data_intermediate_ad', 'fromField' => 'date_time'];
        $this->aObjectMap['data_summary_ad_hourly']['date_time'] = ['fromTable' => 'data_summary_ad_hourly', 'fromField' => 'date_time'];
    }



    public function beforeAddField__data_intermediate_ad__date_time()
    {
        return $this->beforeAddField('data_intermediate_ad', 'date_time');
    }

    public function afterAddField__data_intermediate_ad__date_time()
    {
        return $this->migrateDayHour('data_intermediate_ad') && $this->afterAddField('data_intermediate_ad', 'date_time');
    }

    public function beforeAddIndex__data_intermediate_ad__ad_id_date_time()
    {
        return $this->beforeAddIndex('data_intermediate_ad', 'ad_id_date_time');
    }

    public function afterAddIndex__data_intermediate_ad__ad_id_date_time()
    {
        return $this->afterAddIndex('data_intermediate_ad', 'ad_id_date_time');
    }

    public function beforeAddIndex__data_intermediate_ad__zone_id_date_time()
    {
        return $this->beforeAddIndex('data_intermediate_ad', 'zone_id_date_time');
    }

    public function afterAddIndex__data_intermediate_ad__zone_id_date_time()
    {
        return $this->afterAddIndex('data_intermediate_ad', 'zone_id_date_time');
    }

    public function beforeAddIndex__data_intermediate_ad__date_time()
    {
        return $this->beforeAddIndex('data_intermediate_ad', 'date_time');
    }

    public function afterAddIndex__data_intermediate_ad__date_time()
    {
        return $this->afterAddIndex('data_intermediate_ad', 'date_time');
    }

    public function beforeAddIndex__data_intermediate_ad__interval_start()
    {
        return $this->beforeAddIndex('data_intermediate_ad', 'interval_start');
    }

    public function afterAddIndex__data_intermediate_ad__interval_start()
    {
        return $this->afterAddIndex('data_intermediate_ad', 'interval_start');
    }

    public function beforeRemoveIndex__data_intermediate_ad__data_intermediate_ad_day()
    {
        return $this->beforeRemoveIndex('data_intermediate_ad', 'data_intermediate_ad_day');
    }

    public function afterRemoveIndex__data_intermediate_ad__data_intermediate_ad_day()
    {
        return $this->afterRemoveIndex('data_intermediate_ad', 'data_intermediate_ad_day');
    }

    public function beforeRemoveIndex__data_intermediate_ad__data_intermediate_ad_operation_interval_id()
    {
        return $this->beforeRemoveIndex('data_intermediate_ad', 'data_intermediate_ad_operation_interval_id');
    }

    public function afterRemoveIndex__data_intermediate_ad__data_intermediate_ad_operation_interval_id()
    {
        return $this->afterRemoveIndex('data_intermediate_ad', 'data_intermediate_ad_operation_interval_id');
    }

    public function beforeRemoveIndex__data_intermediate_ad__data_intermediate_ad_ad_id()
    {
        return $this->beforeRemoveIndex('data_intermediate_ad', 'data_intermediate_ad_ad_id');
    }

    public function afterRemoveIndex__data_intermediate_ad__data_intermediate_ad_ad_id()
    {
        return $this->afterRemoveIndex('data_intermediate_ad', 'data_intermediate_ad_ad_id');
    }

    public function beforeRemoveIndex__data_intermediate_ad__data_intermediate_ad_zone_id()
    {
        return $this->beforeRemoveIndex('data_intermediate_ad', 'data_intermediate_ad_zone_id');
    }

    public function afterRemoveIndex__data_intermediate_ad__data_intermediate_ad_zone_id()
    {
        return $this->afterRemoveIndex('data_intermediate_ad', 'data_intermediate_ad_zone_id');
    }

    public function beforeAddField__data_summary_ad_hourly__date_time()
    {
        return $this->beforeAddField('data_summary_ad_hourly', 'date_time');
    }

    public function afterAddField__data_summary_ad_hourly__date_time()
    {
        return $this->migrateDayHour('data_summary_ad_hourly') && $this->afterAddField('data_summary_ad_hourly', 'date_time');
    }

    public function beforeAddIndex__data_summary_ad_hourly__date_time()
    {
        return $this->beforeAddIndex('data_summary_ad_hourly', 'date_time');
    }

    public function afterAddIndex__data_summary_ad_hourly__date_time()
    {
        return $this->afterAddIndex('data_summary_ad_hourly', 'date_time');
    }

    public function beforeAddIndex__data_summary_ad_hourly__ad_id_date_time()
    {
        return $this->beforeAddIndex('data_summary_ad_hourly', 'ad_id_date_time');
    }

    public function afterAddIndex__data_summary_ad_hourly__ad_id_date_time()
    {
        return $this->afterAddIndex('data_summary_ad_hourly', 'ad_id_date_time');
    }

    public function beforeAddIndex__data_summary_ad_hourly__zone_id_date_time()
    {
        return $this->beforeAddIndex('data_summary_ad_hourly', 'zone_id_date_time');
    }

    public function afterAddIndex__data_summary_ad_hourly__zone_id_date_time()
    {
        return $this->afterAddIndex('data_summary_ad_hourly', 'zone_id_date_time');
    }

    public function beforeRemoveIndex__data_summary_ad_hourly__data_summary_ad_hourly_day()
    {
        return $this->beforeRemoveIndex('data_summary_ad_hourly', 'data_summary_ad_hourly_day');
    }

    public function afterRemoveIndex__data_summary_ad_hourly__data_summary_ad_hourly_day()
    {
        return $this->afterRemoveIndex('data_summary_ad_hourly', 'data_summary_ad_hourly_day');
    }

    public function beforeRemoveIndex__data_summary_ad_hourly__data_summary_ad_hourly_hour()
    {
        return $this->beforeRemoveIndex('data_summary_ad_hourly', 'data_summary_ad_hourly_hour');
    }

    public function afterRemoveIndex__data_summary_ad_hourly__data_summary_ad_hourly_hour()
    {
        return $this->afterRemoveIndex('data_summary_ad_hourly', 'data_summary_ad_hourly_hour');
    }

    public function beforeRemoveIndex__data_summary_ad_hourly__data_summary_ad_hourly_ad_id()
    {
        return $this->beforeRemoveIndex('data_summary_ad_hourly', 'data_summary_ad_hourly_ad_id');
    }

    public function afterRemoveIndex__data_summary_ad_hourly__data_summary_ad_hourly_ad_id()
    {
        return $this->afterRemoveIndex('data_summary_ad_hourly', 'data_summary_ad_hourly_ad_id');
    }

    public function beforeRemoveIndex__data_summary_ad_hourly__data_summary_ad_hourly_zone_id()
    {
        return $this->beforeRemoveIndex('data_summary_ad_hourly', 'data_summary_ad_hourly_zone_id');
    }

    public function afterRemoveIndex__data_summary_ad_hourly__data_summary_ad_hourly_zone_id()
    {
        return $this->afterRemoveIndex('data_summary_ad_hourly', 'data_summary_ad_hourly_zone_id');
    }

    public function beforeRemoveField__data_intermediate_ad__day()
    {
        return $this->beforeRemoveField('data_intermediate_ad', 'day');
    }

    public function afterRemoveField__data_intermediate_ad__day()
    {
        return $this->afterRemoveField('data_intermediate_ad', 'day');
    }

    public function beforeRemoveField__data_intermediate_ad__hour()
    {
        return $this->beforeRemoveField('data_intermediate_ad', 'hour');
    }

    public function afterRemoveField__data_intermediate_ad__hour()
    {
        return $this->afterRemoveField('data_intermediate_ad', 'hour');
    }

    public function beforeRemoveField__data_summary_ad_hourly__day()
    {
        return $this->beforeRemoveField('data_summary_ad_hourly', 'day');
    }

    public function afterRemoveField__data_summary_ad_hourly__day()
    {
        return $this->afterRemoveField('data_summary_ad_hourly', 'day');
    }

    public function beforeRemoveField__data_summary_ad_hourly__hour()
    {
        return $this->beforeRemoveField('data_summary_ad_hourly', 'hour');
    }

    public function afterRemoveField__data_summary_ad_hourly__hour()
    {
        return $this->afterRemoveField('data_summary_ad_hourly', 'hour');
    }

    public function migrateDayHour($table)
    {
        $prefix = $GLOBALS['_MAX']['CONF']['table']['prefix'];
        $tableName = $this->oDBH->quoteIdentifier($prefix . $table, true);

        if ($this->oDBH->dbsyntax == 'pgsql') {
            $query = "UPDATE {$tableName} SET date_time = {$tableName}.day::timestamp + ({$tableName}.hour || ' hours')::interval";
        } else {
            $query = "UPDATE {$tableName} SET date_time = DATE_ADD({$tableName}.day, interval {$tableName}.hour hour)";
        }

        $result = $this->oDBH->exec($query);
        if (PEAR::isError($result)) {
            return $this->_logErrorAndReturnFalse('Cannot migrate ' . $table);
        }

        return true;
    }
}
