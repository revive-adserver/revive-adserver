<?php
/**
 * Table Definition for variable_publisher
 */
require_once 'DB_DataObjectCommon.php';

class DataObjects_Variable_publisher extends DB_DataObjectCommon 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'variable_publisher';              // table name
    var $variable_id;                     // int(11)  not_null primary_key
    var $publisher_id;                    // int(11)  not_null primary_key
    var $visible;                         // int(1)  not_null

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Variable_publisher',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
    
    /**
     * Table has no autoincrement/sequence so we override sequenceKey().
     *
     * @return array
     */
    function sequenceKey() {
        return array(false, false, false);
    }
}
