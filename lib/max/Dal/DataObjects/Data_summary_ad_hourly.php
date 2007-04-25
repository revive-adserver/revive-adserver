<?php
/**
 * Table Definition for data_summary_ad_hourly
 */
require_once 'DB_DataObjectCommon.php';

class DataObjects_Data_summary_ad_hourly extends DB_DataObjectCommon 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'data_summary_ad_hourly';          // table name
    var $data_summary_ad_hourly_id;       // int(20)  not_null primary_key auto_increment
    var $day;                             // date(10)  not_null multiple_key binary
    var $hour;                            // int(10)  not_null multiple_key unsigned
    var $ad_id;                           // int(10)  not_null multiple_key unsigned
    var $creative_id;                     // int(10)  not_null unsigned
    var $zone_id;                         // int(10)  not_null multiple_key unsigned
    var $requests;                        // int(10)  not_null unsigned
    var $impressions;                     // int(10)  not_null unsigned
    var $clicks;                          // int(10)  not_null unsigned
    var $conversions;                     // int(10)  not_null unsigned
    var $total_basket_value;              // real(12)  
    var $total_num_items;                 // int(11)  
    var $total_revenue;                   // real(12)  
    var $total_cost;                      // real(12)  
    var $total_techcost;                  // real(12)  
    var $updated;                         // datetime(19)  not_null binary

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Data_summary_ad_hourly',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
