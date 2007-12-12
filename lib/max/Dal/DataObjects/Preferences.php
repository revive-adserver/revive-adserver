<?php
/**
 * Table Definition for preferences
 */
require_once 'DB_DataObjectCommon.php';

class DataObjects_Preferences extends DB_DataObjectCommon 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'preferences';                     // table name
    var $preference_id;                   // int(9)  not_null primary_key auto_increment
    var $preference_name;                 // string(64)  not_null unique_key
    var $account_type;                    // string(16)  not_null multiple_key

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Preferences',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
