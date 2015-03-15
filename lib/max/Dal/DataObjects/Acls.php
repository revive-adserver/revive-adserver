<?php

/*
+---------------------------------------------------------------------------+
| Revive Adserver                                                           |
| http://www.revive-adserver.com                                            |
|                                                                           |
| Copyright: See the COPYRIGHT.txt file.                                    |
| License: GPLv2 or later, see the LICENSE.txt file.                        |
+---------------------------------------------------------------------------+
*/

/**
 * Table Definition for acls
 */
require_once 'DB_DataObjectCommon.php';

class DataObjects_Acls extends DB_DataObjectCommon
{
    var $onDeleteCascade = true;
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'acls';                            // table name
    public $bannerid;                        // MEDIUMINT(9) => openads_mediumint => 129
    public $logical;                         // VARCHAR(3) => openads_varchar => 130
    public $type;                            // VARCHAR(255) => openads_varchar => 130
    public $comparison;                      // CHAR(2) => openads_char => 130
    public $data;                            // TEXT() => openads_text => 162
    public $executionorder;                  // INT(10) => openads_int => 129

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGetFromClassName('DataObjects_Acls',$k,$v); }

    var $defaultValues = array(
                'bannerid' => 0,
                'logical' => 'and',
                'type' => '',
                'comparison' => '==',
                'data' => '',
                'executionorder' => 0,
                );

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

    function _auditEnabled()
    {
        return true;
    }

    function _getContextId()
    {
        return $this->bannerid;
    }

    function _getContext()
    {
        return 'Delivery Limitation';
    }

    /**
     * A method to return an array of account IDs of the account(s) that
     * should "own" any audit trail entries for this entity type; these
     * are NOT related to the account ID of the currently active account
     * (which is performing some kind of action on the entity), but is
     * instead related to the type of entity, and where in the account
     * heirrachy the entity is located.
     *
     * @return array An array containing up to three indexes:
     *                  - "OA_ACCOUNT_ADMIN" or "OA_ACCOUNT_MANAGER":
     *                      Contains the account ID of the manager account
     *                      that needs to be able to see the audit trail
     *                      entry, or, the admin account, if the entity
     *                      is a special case where only the admin account
     *                      should see the entry.
     *                  - "OA_ACCOUNT_ADVERTISER":
     *                      Contains the account ID of the advertiser account
     *                      that needs to be able to see the audit trail
     *                      entry, if such an account exists.
     *                  - "OA_ACCOUNT_TRAFFICKER":
     *                      Contains the account ID of the trafficker account
     *                      that needs to be able to see the audit trail
     *                      entry, if such an account exists.
     */
    public function getOwningAccountIds($resetCache = false)
    {
        // Delivery limitations don't have an account_id, get it from
        // the parent banner (stored in the "banners" table) using
        // the "bannerid" key
        return $this->_getOwningAccountIds('banners', 'bannerid', $resetCache);
    }

    /**
     * build an acls specific audit array
     *
     * @param integer $actionid
     * @param array $aAuditFields
     */
    function _buildAuditArray($actionid, &$aAuditFields)
    {
        $aAuditFields['key_desc']     = $this->type;
        switch ($actionid)
        {
            case OA_AUDIT_ACTION_UPDATE:
                        $aAuditFields['bannerid'] = $this->bannerid;
                        break;
        }
    }

}

?>