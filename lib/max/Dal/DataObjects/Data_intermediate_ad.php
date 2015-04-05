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

/**
 * Table Definition for data_intermediate_ad
 */
require_once 'DB_DataObjectCommon.php';

class DataObjects_Data_intermediate_ad extends DB_DataObjectCommon
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'data_intermediate_ad';            // table name
    public $data_intermediate_ad_id;         // BIGINT(20) => openads_bigint => 129 
    public $date_time;                       // DATETIME() => openads_datetime => 142 
    public $operation_interval;              // INT(10) => openads_int => 129 
    public $operation_interval_id;           // INT(10) => openads_int => 129 
    public $interval_start;                  // DATETIME() => openads_datetime => 142 
    public $interval_end;                    // DATETIME() => openads_datetime => 142 
    public $ad_id;                           // INT(10) => openads_int => 129 
    public $creative_id;                     // INT(10) => openads_int => 129 
    public $zone_id;                         // INT(10) => openads_int => 129 
    public $requests;                        // INT(10) => openads_int => 129 
    public $impressions;                     // INT(10) => openads_int => 129 
    public $clicks;                          // INT(10) => openads_int => 129 
    public $conversions;                     // INT(10) => openads_int => 129 
    public $total_basket_value;              // DECIMAL(10,4) => openads_decimal => 129 
    public $total_num_items;                 // INT(11) => openads_int => 129 
    public $updated;                         // DATETIME() => openads_datetime => 142 

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGetFromClassName('DataObjects_Data_intermediate_ad',$k,$v); }

    var $defaultValues = array(
                'date_time' => '%NO_DATE_TIME%',
                'interval_start' => '%NO_DATE_TIME%',
                'interval_end' => '%NO_DATE_TIME%',
                'requests' => 0,
                'impressions' => 0,
                'clicks' => 0,
                'conversions' => 0,
                'total_basket_value' => 0.0000,
                'total_num_items' => 0,
                'updated' => '%DATE_TIME%',
                );

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}

?>