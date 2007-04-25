<?php
/**
 * Table Definition for data_summary_ad_zone_assoc
 */
require_once 'DB_DataObjectCommon.php';

class DataObjects_Data_summary_ad_zone_assoc extends DB_DataObjectCommon 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'data_summary_ad_zone_assoc';      // table name
    public $data_summary_ad_zone_assoc_id;    // int(20)  not_null primary_key auto_increment
    public $operation_interval;              // int(10)  not_null unsigned
    public $operation_interval_id;           // int(10)  not_null unsigned
    public $interval_start;                  // datetime(19)  not_null multiple_key binary
    public $interval_end;                    // datetime(19)  not_null multiple_key binary
    public $ad_id;                           // int(10)  not_null multiple_key unsigned
    public $zone_id;                         // int(10)  not_null multiple_key unsigned
    public $required_impressions;            // int(10)  not_null unsigned
    public $requested_impressions;           // int(10)  not_null unsigned
    public $priority;                        // real(22)  not_null
    public $priority_factor;                 // real(22)  
    public $priority_factor_limited;         // int(6)  not_null
    public $past_zone_traffic_fraction;      // real(22)  
    public $created;                         // datetime(19)  not_null binary
    public $created_by;                      // int(10)  not_null unsigned
    public $expired;                         // datetime(19)  multiple_key binary
    public $expired_by;                      // int(10)  unsigned
    public $to_be_delivered;                 // int(1)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Data_summary_ad_zone_assoc',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
