<?php
/**
 * Table Definition for application_variable
 */
require_once 'DB_DataObjectCommon.php';

class DataObjects_Application_variable extends DB_DataObjectCommon 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'application_variable';            // table name
    var $name;                            // string(255)  not_null
    var $value;                           // string(255)  not_null

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Application_variable',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
