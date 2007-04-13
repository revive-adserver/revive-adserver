<?php
/**
 * Table Definition for category
 */
require_once 'DB_DataObjectCommon.php';

class DataObjects_Category extends DB_DataObjectCommon 
{
    var $onDeleteCascade = true;
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'category';                        // table name
    public $category_id;                     // int(10)  not_null primary_key unsigned auto_increment
    public $name;                            // string(255)  

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Category',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
