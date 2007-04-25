<?php
/**
 * Table Definition for ad_zone_assoc
 */
require_once 'DB_DataObjectCommon.php';

class DataObjects_Ad_zone_assoc extends DB_DataObjectCommon 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'ad_zone_assoc';                   // table name
    var $ad_zone_assoc_id;                // int(9)  not_null primary_key auto_increment
    var $zone_id;                         // int(9)  multiple_key
    var $ad_id;                           // int(9)  multiple_key
    var $priority;                        // real(22)  
    var $link_type;                       // int(6)  not_null
    var $priority_factor;                 // real(22)  
    var $to_be_delivered;                 // int(1)  not_null

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Ad_zone_assoc',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
