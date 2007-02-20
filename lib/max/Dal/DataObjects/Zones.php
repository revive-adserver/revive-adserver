<?php
/**
 * Table Definition for zones
 */
require_once 'DB_DataObjectCommon.php';

class DataObjects_Zones extends DB_DataObjectCommon 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'zones';                           // table name
    var $zoneid;                          // int(9)  not_null primary_key auto_increment
    var $affiliateid;                     // int(9)  multiple_key
    var $zonename;                        // string(245)  not_null multiple_key
    var $description;                     // string(255)  not_null
    var $delivery;                        // int(6)  not_null
    var $zonetype;                        // int(6)  not_null
    var $category;                        // blob(65535)  not_null blob
    var $width;                           // int(6)  not_null
    var $height;                          // int(6)  not_null
    var $ad_selection;                    // blob(65535)  not_null blob
    var $chain;                           // blob(65535)  not_null blob
    var $prepend;                         // blob(65535)  not_null blob
    var $append;                          // blob(65535)  not_null blob
    var $appendtype;                      // int(4)  not_null
    var $forceappend;                     // string(1)  enum
    var $inventory_forecast_type;         // int(6)  not_null
    var $comments;                        // blob(65535)  blob
    var $cost;                            // unknown(12)  
    var $cost_type;                       // int(6)  
    var $cost_variable_id;                // string(255)  
    var $technology_cost;                 // unknown(12)  
    var $technology_cost_type;            // int(6)  
    var $updated;                         // datetime(19)  not_null binary
    var $block;                           // int(11)  not_null
    var $capping;                         // int(11)  not_null
    var $session_capping;                 // int(11)  not_null

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Zones',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
