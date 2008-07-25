<?php
/**
 * Table Definition for testplugin_table
 */
require_once MAX_PATH.'/lib/max/Dal/DataObjects/DB_DataObjectCommon.php';

class DataObjects_Testplugin_table extends DB_DataObjectCommon
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'testplugin_table';                // table name
    public $testplugin_id;                   // INT(10) => openads_int => 129 
    public $testplugin_desc;                 // VARCHAR(128) => openads_varchar => 2 
    public $updated;                         // DATETIME() => openads_datetime => 14 

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Testplugin_table',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE

    /**
     * A private method to return the account ID of the
     * account that should "own" audit trail entries for
     * this entity type; NOT related to the account ID
     * of the currently active account performing an
     * action.
     *
     * @return integer The account ID to insert into the
     *                 "account_id" column of the audit trail
     *                 database table.
     */
    function getOwningAccountId()
    {
        return OA_ACCOUNT_ADMIN_ID;
    }

    function _auditEnabled()
    {
        return true;
    }

    function _getContextId()
    {
        return $this->testplugin_id;
    }

    function _getContext()
    {
        return 'testPlugin String';
    }

    /**
     * build a myplugin_table specific audit array
     *
     * @param integer $actionid
     * @param array $aAuditFields
     */
    function _buildAuditArray($actionid, &$aAuditFields)
    {
        $aAuditFields['key_desc']   = $this->testplugin_desc;
    }

}
