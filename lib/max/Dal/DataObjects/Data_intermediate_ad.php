<?php
/**
 * Table Definition for data_intermediate_ad
 */
require_once 'DB_DataObjectCommon.php';

class DataObjects_Data_intermediate_ad extends DB_DataObjectCommon 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'data_intermediate_ad';            // table name
    public $data_intermediate_ad_id;         // int(20)  not_null primary_key auto_increment
    public $day;                             // date(10)  not_null multiple_key binary
    public $hour;                            // int(10)  not_null unsigned
    public $operation_interval;              // int(10)  not_null unsigned
    public $operation_interval_id;           // int(10)  not_null multiple_key unsigned
    public $interval_start;                  // datetime(19)  not_null binary
    public $interval_end;                    // datetime(19)  not_null binary
    public $ad_id;                           // int(10)  not_null multiple_key unsigned
    public $creative_id;                     // int(10)  not_null unsigned
    public $zone_id;                         // int(10)  not_null multiple_key unsigned
    public $requests;                        // int(10)  not_null unsigned
    public $impressions;                     // int(10)  not_null unsigned
    public $clicks;                          // int(10)  not_null unsigned
    public $conversions;                     // int(10)  not_null unsigned
    public $total_basket_value;              // real(12)  not_null
    public $total_num_items;                 // int(11)  not_null
    public $updated;                         // datetime(19)  not_null binary

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Data_intermediate_ad',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
    
    function table()
    {
        $fields = parent::table();
        if (isset($fields['total_basket_value'])) {
            // decimal() somehow is interpreted by DataObjects as DB_DATAOBJECT_MYSQLTIMESTAMP
            // @fixme
            $fields['total_basket_value'] = 1;
        }
        return $fields;
    }
}
