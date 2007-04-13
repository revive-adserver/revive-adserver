<?php
/**
 * Table Definition for data_summary_ad_hourly
 */
require_once 'DB_DataObjectCommon.php';

class DataObjects_Data_summary_ad_hourly extends DB_DataObjectCommon 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'data_summary_ad_hourly';          // table name
    public $data_summary_ad_hourly_id;       // int(20)  not_null primary_key auto_increment
    public $day;                             // date(10)  not_null multiple_key binary
    public $hour;                            // int(10)  not_null multiple_key unsigned
    public $ad_id;                           // int(10)  not_null multiple_key unsigned
    public $creative_id;                     // int(10)  not_null unsigned
    public $zone_id;                         // int(10)  not_null multiple_key unsigned
    public $requests;                        // int(10)  not_null unsigned
    public $impressions;                     // int(10)  not_null unsigned
    public $clicks;                          // int(10)  not_null unsigned
    public $conversions;                     // int(10)  not_null unsigned
    public $total_basket_value;              // real(12)  
    public $total_num_items;                 // int(11)  
    public $total_revenue;                   // real(12)  
    public $total_cost;                      // real(12)  
    public $total_techcost;                  // real(12)  
    public $updated;                         // datetime(19)  not_null binary

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Data_summary_ad_hourly',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
