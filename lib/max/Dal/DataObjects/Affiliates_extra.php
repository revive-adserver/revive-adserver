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
 * Table Definition for affiliates_extra
 */
require_once 'DB_DataObjectCommon.php';

class DataObjects_Affiliates_extra extends DB_DataObjectCommon
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'affiliates_extra';                // table name
    public $affiliateid;                     // MEDIUMINT(9) => openads_mediumint => 129
    public $address;                         // TEXT() => openads_text => 34
    public $city;                            // VARCHAR(255) => openads_varchar => 2
    public $postcode;                        // VARCHAR(64) => openads_varchar => 2
    public $country;                         // VARCHAR(255) => openads_varchar => 2
    public $phone;                           // VARCHAR(64) => openads_varchar => 2
    public $fax;                             // VARCHAR(64) => openads_varchar => 2
    public $account_contact;                 // VARCHAR(255) => openads_varchar => 2
    public $payee_name;                      // VARCHAR(255) => openads_varchar => 2
    public $tax_id;                          // VARCHAR(64) => openads_varchar => 2
    public $mode_of_payment;                 // VARCHAR(64) => openads_varchar => 2
    public $currency;                        // VARCHAR(64) => openads_varchar => 2
    public $unique_users;                    // INT(11) => openads_int => 1
    public $unique_views;                    // INT(11) => openads_int => 1
    public $page_rank;                       // INT(11) => openads_int => 1
    public $category;                        // VARCHAR(255) => openads_varchar => 2
    public $help_file;                       // VARCHAR(255) => openads_varchar => 2

    /* Static get */
    public static function staticGet($k, $v = null)
    {
        return DB_DataObject::staticGetFromClassName('DataObjects_Affiliates_extra', $k, $v);
    }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE


    /**
     * Table has no autoincrement/sequence so we override sequenceKey().
     *
     * @return array
     */
    public function sequenceKey()
    {
        return [false, false, false];
    }

    public function _auditEnabled()
    {
        return true;
    }

    public function _getContextId()
    {
        return $this->affiliateid;
    }

    public function _getContext()
    {
        return 'Affiliate Extra';
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
        // Extra "affiliate" info doesn't have an account_id, get it
        // from the parent advertiser account (stored in the "affiliates"
        // table) using the "affiliateid" key
        return $this->_getOwningAccountIds('affiliates', 'affiliateid');
    }

    /**
     * build an affiliates specific audit array
     *
     * @param integer $actionid
     * @param array $aAuditFields
     */
    public function _buildAuditArray($actionid, &$aAuditFields)
    {
        $aAuditFields['key_desc'] = '';
    }
}
