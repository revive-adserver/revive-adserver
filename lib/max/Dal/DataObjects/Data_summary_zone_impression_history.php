<?php
/**
 * Table Definition for data_summary_zone_impression_history
 */
require_once 'DB_DataObjectCommon.php';

class DataObjects_Data_summary_zone_impression_history extends DB_DataObjectCommon 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'data_summary_zone_impression_history';    // table name
    var $data_summary_zone_impression_history_id;    // int(20)  not_null primary_key auto_increment
    var $operation_interval;              // int(10)  not_null unsigned
    var $operation_interval_id;           // int(10)  not_null multiple_key unsigned
    var $interval_start;                  // datetime(19)  not_null binary
    var $interval_end;                    // datetime(19)  not_null binary
    var $zone_id;                         // int(10)  not_null multiple_key unsigned
    var $forecast_impressions;            // int(10)  unsigned
    var $actual_impressions;              // int(10)  unsigned

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Data_summary_zone_impression_history',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
