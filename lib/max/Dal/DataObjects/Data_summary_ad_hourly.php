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
 * Table Definition for data_summary_ad_hourly
 */
require_once 'DB_DataObjectCommon.php';

class DataObjects_Data_summary_ad_hourly extends DB_DataObjectCommon
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'data_summary_ad_hourly';          // table name
    public $data_summary_ad_hourly_id;       // BIGINT(20) => openads_bigint => 129 
    public $date_time;                       // DATETIME() => openads_datetime => 142 
    public $ad_id;                           // INT(10) => openads_int => 129 
    public $creative_id;                     // INT(10) => openads_int => 129 
    public $zone_id;                         // INT(10) => openads_int => 129 
    public $requests;                        // INT(10) => openads_int => 129 
    public $impressions;                     // INT(10) => openads_int => 129 
    public $clicks;                          // INT(10) => openads_int => 129 
    public $conversions;                     // INT(10) => openads_int => 129 
    public $total_basket_value;              // DECIMAL(10,4) => openads_decimal => 1 
    public $total_num_items;                 // INT(11) => openads_int => 1 
    public $total_revenue;                   // DECIMAL(10,4) => openads_decimal => 1 
    public $total_cost;                      // DECIMAL(10,4) => openads_decimal => 1 
    public $total_techcost;                  // DECIMAL(10,4) => openads_decimal => 1 
    public $updated;                         // DATETIME() => openads_datetime => 142 

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGetFromClassName('DataObjects_Data_summary_ad_hourly',$k,$v); }

    var $defaultValues = array(
                'date_time' => '%NO_DATE_TIME%',
                'requests' => 0,
                'impressions' => 0,
                'clicks' => 0,
                'conversions' => 0,
                'updated' => '%DATE_TIME%',
                );

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}

?>