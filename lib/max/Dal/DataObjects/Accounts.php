<?php
/**
 * Table Definition for accounts
 */
require_once 'DB_DataObjectCommon.php';
require_once MAX_PATH . '/lib/OA/Dal/ApplicationVariables.php';

class DataObjects_Accounts extends DB_DataObjectCommon
{
    var $onDeleteCascade = true;
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'accounts';                        // table name
    var $account_id;                      // int(9)  not_null primary_key auto_increment
    var $account_type;                    // string(16)  not_null multiple_key
    var $account_name;                    // string(255)  
    var $m2m_password;                    // string(32)  
    var $m2m_ticket;                      // string(32)  

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Accounts',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE

    /**
     * Handle all necessary operations when a new account is created
     *
     * @see DB_DataObject::insert()
     */
    function insert()
    {
        $result = parent::insert();

        if ($this->account_type == OA_ACCOUNT_ADMIN && $result) {
            OA_Dal_ApplicationVariables::set('admin_account_id', $result);
        }

        return $result;
    }

    /**
     * Returns ADMIN account ID
     *
     */
    function getAdminAccountId()
    {
        return OA_Dal_ApplicationVariables::get('admin_account_id');
    }

    function _auditEnabled()
    {
        return true;
    }

    function _getContextId()
    {
        return $this->account_id;
    }

    function _getContext()
    {
        return 'Account';
    }

    /**
     * build an accounts specific audit array
     *
     * @param integer $actionid
     * @param array $aAuditFields
     */
    function _buildAuditArray($actionid, &$aAuditFields)
    {
        $aAuditFields['key_desc']     = $this->account_name;
        switch ($actionid)
        {
            case OA_AUDIT_ACTION_INSERT:
                        break;
            case OA_AUDIT_ACTION_UPDATE:
                        break;
            case OA_AUDIT_ACTION_DELETE:
                        break;
        }
    }
}
