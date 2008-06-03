<?php
/**
 * Table Definition for accounts
 */
require_once 'DB_DataObjectCommon.php';
require_once MAX_PATH . '/lib/OA/Dal/ApplicationVariables.php';

class DataObjects_Accounts extends DB_DataObjectCommon
{
    var $onDeleteCascade = true;
    var $onDeleteCascadeSkip = array(
        'audit'
    );
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'accounts';                        // table name
    public $account_id;                      // int(9)  not_null primary_key auto_increment
    public $account_type;                    // string(16)  not_null multiple_key
    public $account_name;                    // string(255)  
    public $m2m_password;                    // string(32)  
    public $m2m_ticket;                      // string(32)  

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
        // Do not log the M2M password and ticket in the audit record
        unset($aAuditFields['m2m_password']);
        unset($aAuditFields['m2m_ticket']);

        if (count($aAuditFields)) {
            $aAuditFields['key_desc']     = $this->account_name;
        } else {
            // No need to log if nothing was changed, apart from M2M fields
        }
    }
}
