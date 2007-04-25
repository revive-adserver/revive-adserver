<?php
/**
 * Table Definition for data_summary_zone_impression_history
 */
require_once 'DB_DataObjectCommon.php';

class DataObjects_Data_summary_zone_impression_history extends DB_DataObjectCommon 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'data_summary_zone_impression_history';    // table name
    public $data_summary_zone_impression_history_id;    // int(20)  not_null primary_key auto_increment
    public $operation_interval;              // int(10)  not_null unsigned
    public $operation_interval_id;           // int(10)  not_null multiple_key unsigned
    public $interval_start;                  // datetime(19)  not_null binary
    public $interval_end;                    // datetime(19)  not_null binary
    public $zone_id;                         // int(10)  not_null multiple_key unsigned
    public $forecast_impressions;            // int(10)  unsigned
    public $actual_impressions;              // int(10)  unsigned

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Data_summary_zone_impression_history',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
