<?php
/**
 * Table Definition for ad_category_assoc
 */
require_once 'DB_DataObjectCommon.php';

class DataObjects_Ad_category_assoc extends DB_DataObjectCommon 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'ad_category_assoc';               // table name
    public $ad_category_assoc_id;            // int(10)  not_null primary_key unsigned auto_increment
    public $category_id;                     // int(10)  not_null unsigned
    public $ad_id;                           // int(10)  not_null unsigned

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Ad_category_assoc',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
