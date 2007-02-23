<?php
/**
 * Table Definition for password_recovery
 */
require_once 'DB_DataObjectCommon.php';

class DataObjects_Password_recovery extends DB_DataObjectCommon 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'password_recovery';               // table name
    var $user_type;                       // string(64)  not_null primary_key
    var $user_id;                         // int(10)  not_null primary_key
    var $recovery_id;                     // string(64)  not_null unique_key
    var $updated;                         // datetime(19)  not_null binary

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Password_recovery',$k,$v); }

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
