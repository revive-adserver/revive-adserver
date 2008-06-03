<?php
/**
 * Table Definition for account_preference_assoc
 */
require_once 'DB_DataObjectCommon.php';

class DataObjects_Account_preference_assoc extends DB_DataObjectCommon
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'account_preference_assoc';        // table name
    public $account_id;                      // int(9)  not_null primary_key
    public $preference_id;                   // int(9)  not_null primary_key
    public $value;                           // blob(65535)  not_null blob

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Account_preference_assoc',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE

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
        return 'Account Preference Association';
    }

    /**
     * build an accounts specific audit array
     *
     * @param integer $actionid
     * @param array $aAuditFields
     */
    function _buildAuditArray($actionid, &$aAuditFields)
    {
        $aAuditFields['key_desc']     = 'Account #'.$this->account_id.' -> Preference #' . $this->preference_id;
    }
}
