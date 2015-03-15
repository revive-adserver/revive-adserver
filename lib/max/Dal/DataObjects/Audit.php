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
 * Table Definition for audit
 */

define('OA_AUDIT_ACTION_INSERT',1);
define('OA_AUDIT_ACTION_UPDATE',2);
define('OA_AUDIT_ACTION_DELETE',3);

require_once 'DB_DataObjectCommon.php';

class DataObjects_Audit extends DB_DataObjectCommon
{
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'audit';                           // table name
    public $auditid;                         // MEDIUMINT(9) => openads_mediumint => 129 
    public $actionid;                        // MEDIUMINT(9) => openads_mediumint => 129 
    public $context;                         // VARCHAR(255) => openads_varchar => 130 
    public $contextid;                       // MEDIUMINT(9) => openads_mediumint => 1 
    public $parentid;                        // MEDIUMINT(9) => openads_mediumint => 1 
    public $details;                         // TEXT() => openads_text => 162 
    public $userid;                          // MEDIUMINT(9) => openads_mediumint => 129 
    public $username;                        // VARCHAR(64) => openads_varchar => 2 
    public $usertype;                        // TINYINT(4) => openads_tinyint => 129 
    public $updated;                         // DATETIME() => openads_datetime => 14 
    public $account_id;                      // MEDIUMINT(9) => openads_mediumint => 129 
    public $advertiser_account_id;           // MEDIUMINT(9) => openads_mediumint => 1 
    public $website_account_id;              // MEDIUMINT(9) => openads_mediumint => 1 

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGetFromClassName('DataObjects_Audit',$k,$v); }

    var $defaultValues = array(
                'context' => '',
                'details' => '',
                'userid' => 0,
                'usertype' => 0,
                'advertiser_account_id' => OX_DATAOBJECT_NULL,
                'website_account_id' => OX_DATAOBJECT_NULL,
                );

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE

    /**
     * The belongsToAccount() method behaves in a different way when looking
     * at entries in the "audit" table. To check if an account has access
     * to view specific audit data, we only need to check if the account's
     * ID is set in the appropriate column in the record.
     *
     * @param string $accountId The account ID to test if this DB_DataObject is
     *                          owned by.
     * @return boolean|null     Returns true if the entity belongs to the specified
     *                          account, false if doesn't, or null if it was not
     *                          possible to find the required object references.
     */
    function belongsToAccount($accountId = null)
    {
        // Set the account ID, if not passed in
        if (empty($accountId)) {
            $accountId = OA_Permission::getAccountId();
        }
        // Prepare $this with the required info of the "entity" to be tested
        if (!$this->N) {
            $key = $this->getFirstPrimaryKey();
            if (empty($this->$key)) {
                MAX::raiseError('Key on object is not set, table: '.$this->getTableWithoutPrefix());
                return null;
            }
            if (!$this->find($autoFetch = true)) {
                return null;
            }
        }
        // Test the account ID type, and then test for access
        $accountType = OA_Permission::getAccountTypeByAccountId($accountId);
        // Test the access to the audit trail entry
        if ($accountType == OA_ACCOUNT_ADMIN) {
            // Admin always has access
            return true;
        } else if ($accountType == OA_ACCOUNT_MANAGER) {
            // Test if the account ID is equal to the account_id field
            if (is_null($this->account_id)) {
                return null;
            }
            if ($this->account_id == $accountId) {
                return true;
            }
        } else if ($accountType == OA_ACCOUNT_ADVERTISER) {
            // Test if the account ID is equal to the advertiser_account_id field
            if (is_null($this->advertiser_account_id)) {
                return null;
            }
            if ($this->advertiser_account_id == $accountId) {
                return true;
            }
        } else if ($accountType == OA_ACCOUNT_TRAFFICKER) {
            // Test if the account ID is equal to the website_account_id field
            if (is_null($this->website_account_id)) {
                return null;
            }
            if ($this->website_account_id == $accountId) {
                return true;
            }
        }
        return false;
    }

}

?>