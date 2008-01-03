<?php
/**
 * Table Definition for accounts
 */
require_once 'DB_DataObjectCommon.php';

class DataObjects_Accounts extends DB_DataObjectCommon
{
    var $onDeleteCascade = true;
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'accounts';                        // table name
    var $account_id;                      // int(9)  not_null primary_key auto_increment
    var $account_type;                    // string(16)  not_null multiple_key
    var $account_name;                    // string(255)  

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Accounts',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
    
    /**
     * Returns ADMIN account ID
     *
     */
    function getAdminAccountId()
    {
        $this->account_type = OA_ACCOUNT_ADMIN;
        $this->find(true);
        return $this->account_id;
    }

}
