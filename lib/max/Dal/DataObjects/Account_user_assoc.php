<?php
/**
 * Table Definition for account_user_assoc
 */
require_once 'DB_DataObjectCommon.php';

class DataObjects_Account_user_assoc extends DB_DataObjectCommon 
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'account_user_assoc';        // table name
    var $account_id;                      // int(9)  not_null primary_key
    var $user_id;                         // int(9)  not_null primary_key
    var $linked;                          // datetime(19)  not_null binary

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Account_user_assoc',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
    
    function insert()
    {
        $this->linked = date('Y-m-d H:i:s');
        return parent::insert();
    }
}
