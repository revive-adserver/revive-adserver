<?php
/**
 * Table Definition for placement_zone_assoc
 */
require_once 'DB_DataObjectCommon.php';

class DataObjects_Placement_zone_assoc extends DB_DataObjectCommon 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'placement_zone_assoc';            // table name
    var $placement_zone_assoc_id;         // int(9)  not_null primary_key auto_increment
    var $zone_id;                         // int(9)  multiple_key
    var $placement_id;                    // int(9)  multiple_key

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Placement_zone_assoc',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
