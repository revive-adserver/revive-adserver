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
 * Table Definition for preferences
 */
require_once 'DB_DataObjectCommon.php';

class DataObjects_Preferences extends DB_DataObjectCommon
{
    var $onDeleteCascade = true;
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'preferences';                     // table name
    public $preference_id;                   // MEDIUMINT(9) => openads_mediumint => 129
    public $preference_name;                 // VARCHAR(64) => openads_varchar => 130
    public $account_type;                    // VARCHAR(16) => openads_varchar => 130

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGetFromClassName('DataObjects_Preferences',$k,$v); }

    var $defaultValues = array(
                'preference_name' => '',
                'account_type' => '',
                );

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE

    function _auditEnabled()
    {
        return true;
    }

    function _getContextId()
    {
        return $this->preference_id;
    }

    function _getContext()
    {
        return 'Preference';
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
        // Special case - return the admin account ID only,
        // as changes to the types of preferences in the
        // system need only be viewed by the admin
        $aAccountIds = array(
            OA_ACCOUNT_ADMIN => OA_Dal_ApplicationVariables::get('admin_account_id')
        );
        return $aAccountIds;
    }

    /**
     * build an accounts specific audit array
     *
     * @param integer $actionid
     * @param array $aAuditFields
     */
    function _buildAuditArray($actionid, &$aAuditFields)
    {
        $aAuditFields['key_desc']     = $this->preference_name;
    }
}
