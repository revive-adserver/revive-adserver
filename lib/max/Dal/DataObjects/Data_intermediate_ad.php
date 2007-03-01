<?php
/**
 * Table Definition for data_intermediate_ad
 */
require_once 'DB_DataObjectCommon.php';

class DataObjects_Data_intermediate_ad extends DB_DataObjectCommon 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'data_intermediate_ad';            // table name
    var $data_intermediate_ad_id;         // int(20)  not_null primary_key auto_increment
    var $day;                             // date(10)  not_null multiple_key binary
    var $hour;                            // int(10)  not_null unsigned
    var $operation_interval;              // int(10)  not_null unsigned
    var $operation_interval_id;           // int(10)  not_null multiple_key unsigned
    var $interval_start;                  // datetime(19)  not_null binary
    var $interval_end;                    // datetime(19)  not_null binary
    var $ad_id;                           // int(10)  not_null multiple_key unsigned
    var $creative_id;                     // int(10)  not_null unsigned
    var $zone_id;                         // int(10)  not_null multiple_key unsigned
    var $requests;                        // int(10)  not_null unsigned
    var $impressions;                     // int(10)  not_null unsigned
    var $clicks;                          // int(10)  not_null unsigned
    var $conversions;                     // int(10)  not_null unsigned
    var $total_basket_value;              // unknown(12)  not_null
    var $total_num_items;                 // int(11)  not_null
    var $updated;                         // datetime(19)  not_null binary

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Data_intermediate_ad',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
