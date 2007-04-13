<?php
/**
 * Table Definition for placement_zone_assoc
 */
require_once 'DB_DataObjectCommon.php';

class DataObjects_Placement_zone_assoc extends DB_DataObjectCommon 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'placement_zone_assoc';            // table name
    public $placement_zone_assoc_id;         // int(9)  not_null primary_key auto_increment
    public $zone_id;                         // int(9)  multiple_key
    public $placement_id;                    // int(9)  multiple_key

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Placement_zone_assoc',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
