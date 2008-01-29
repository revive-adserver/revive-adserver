<?php
/**
 * Table Definition for account_user_assoc
 */
require_once 'DB_DataObjectCommon.php';

class DataObjects_Account_user_assoc extends DB_DataObjectCommon
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'account_user_assoc';              // table name
    var $account_id;                      // int(9)  not_null primary_key
    var $user_id;                         // int(9)  not_null primary_key multiple_key
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

    function delete($useWhere = false, $cascadeDelete = true, $parentid = null)
    {
        // delete also all permissions linked to this account/user
        $doAccount_user_permission_assoc = OA_Dal::factoryDO('account_user_permission_assoc');
        $doAccount_user_permission_assoc->user_id = $this->user_id;
        $doAccount_user_permission_assoc->account_id = $this->account_id;
        if ($useWhere)
        {
            $doAccount_user_permission_assoc->_query['condition'] = $this->_query['condition'];
        }
        $doAccount_user_permission_assoc->delete($useWhere, false, $parentid);

        return parent::delete($useWhere, $cascadeDelete, $parentid);
    }

    function _auditEnabled()
    {
        return true;
    }

    function _getContextId()
    {
        return 0;
    }

    function _getContext()
    {
        return 'Account User Association';
    }

    /**
     * A private method to return the account ID of the
     * account that should "own" audit trail entries for
     * this entity type; NOT related to the account ID
     * of the currently active account performing an
     * action.
     *
     * @todo AUPP-AUDIT Make sure that the account_id returned is ok
     *
     * @return integer The account ID to insert into the
     *                 "account_id" column of the audit trail
     *                 database table.
     */
    function getOwningAccountId()
    {
        return $this->account_id;
    }

    /**
     * build an accounts specific audit array
     *
     * @param integer $actionid
     * @param array $aAuditFields
     */
    function _buildAuditArray($actionid, &$aAuditFields)
    {
        $aAuditFields['key_desc']     = 'Account #'.$this->account_id.' -> User #'.$this->user_id;

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
