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
 * Table Definition for data_summary_zone_impression_history
 */
require_once 'DB_DataObjectCommon.php';

class DataObjects_Data_summary_zone_impression_history extends DB_DataObjectCommon
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'data_summary_zone_impression_history';    // table name
    public $data_summary_zone_impression_history_id;    // BIGINT(20) => openads_bigint => 129 
    public $operation_interval;              // INT(10) => openads_int => 129 
    public $operation_interval_id;           // INT(10) => openads_int => 129 
    public $interval_start;                  // DATETIME() => openads_datetime => 142 
    public $interval_end;                    // DATETIME() => openads_datetime => 142 
    public $zone_id;                         // INT(10) => openads_int => 129 
    public $forecast_impressions;            // INT(10) => openads_int => 1 
    public $actual_impressions;              // INT(10) => openads_int => 1 
    public $est;                             // SMALLINT(6) => openads_smallint => 1 

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGetFromClassName('DataObjects_Data_summary_zone_impression_history',$k,$v); }

    var $defaultValues = array(
                'interval_start' => '%NO_DATE_TIME%',
                'interval_end' => '%NO_DATE_TIME%',
                );

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}

?>