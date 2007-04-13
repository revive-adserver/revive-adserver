<?php
/**
 * Table Definition for ad_zone_assoc
 */
require_once 'DB_DataObjectCommon.php';

class DataObjects_Ad_zone_assoc extends DB_DataObjectCommon 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'ad_zone_assoc';                   // table name
    public $ad_zone_assoc_id;                // int(9)  not_null primary_key auto_increment
    public $zone_id;                         // int(9)  multiple_key
    public $ad_id;                           // int(9)  multiple_key
    public $priority;                        // real(22)  
    public $link_type;                       // int(6)  not_null

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Ad_zone_assoc',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
