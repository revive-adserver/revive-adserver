<?php
/**
 * Table Definition for variables
 */
require_once 'DB_DataObjectCommon.php';

class DataObjects_Variables extends DB_DataObjectCommon 
{
    var $onDeleteCascade = true;
    var $refreshUpdatedFieldIfExists = true;
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'variables';                       // table name
    public $variableid;                      // int(9)  not_null primary_key unsigned auto_increment
    public $trackerid;                       // int(9)  not_null multiple_key
    public $name;                            // string(250)  not_null
    public $description;                     // string(250)  
    public $datatype;                        // string(7)  not_null enum
    public $purpose;                         // string(12)  enum
    public $reject_if_empty;                 // int(1)  not_null unsigned
    public $is_unique;                       // int(11)  not_null multiple_key
    public $unique_window;                   // int(11)  not_null
    public $variablecode;                    // string(255)  not_null
    public $hidden;                          // string(1)  not_null enum
    public $updated;                         // datetime(19)  not_null binary

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Variables',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
