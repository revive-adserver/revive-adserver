<?php
/**
 * Table Definition for accounts
 */
require_once 'DB_DataObjectCommon.php';

class DataObjects_Accounts extends DB_DataObjectCommon
{
    var $__accountName;
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'accounts';                        // table name
    var $account_id;                      // int(9)  not_null primary_key auto_increment
    var $account_type;                    // string(16)  not_null multiple_key
    var $account_name;                    // string(255)  not_null

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Accounts',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE

    /**
     * Handle all necessary operations when new account is created
     *
     * @see DB_DataObject::insert()
     */
    function insert()
    {
        $accountId = parent::insert();

        if (!empty($accountId)) {
            if (empty($this->__accountName)) {
                // TODOPERM - is this variable necessary anymore?
                $this->__accountName = 'Unnamed account';
            }
        }

        return $accountId;
    }

    /**
     * Handle all necessary operations when an account is deleted
     *
     * @see DB_DataObject::delete()
     */
    function delete($useWhere = false, $cascade = true, $parentid = null)
    {
        $ret = parent::delete($useWhere, $cascade, $parentid);

        if ($ret) {
            // TODOPERM - remove any referenced objects
        }

        return $ret;
    }

}
