<?php
/**
 * Table Definition for users
 */
require_once 'DB_DataObjectCommon.php';

class DataObjects_Users extends DB_DataObjectCommon
{
    var $onDeleteCascade = true;
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table = 'users';                           // table name
    var $user_id;                         // int(9)  not_null primary_key auto_increment
    var $contact_name;                    // string(255)  not_null
    var $email_address;                   // string(64)  not_null
    var $username;                        // string(64)  multiple_key
    var $password;                        // string(64)
    var $default_account_id;              // int(9)
    var $comments;                        // blob(65535)  blob
    var $active;                          // int(1)  not_null

    /* ZE2 compatibility trick*/
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Users',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE

    /**
     * Checks is a username already exists in the database
     *
     * @param string $username
     * @return boolean
     */
    function userExists($username)
    {
        $this->whereAddLower('username', $username);
        return (bool)$this->count();
    }

    /**
     * Returns array of unique users
     *
     * @return array
     * @access public
     */
    function getUniqueUsers()
    {
        return $this->getUniqueValuesFromColumn('username');
    }

    /**
     * Check whether user is linked only to one account
     *
     * @return boolean  True if linked only to one account, else false
     */
    function countLinkedAccounts()
    {
        $doAccount_user_assoc = OA_Dal::factoryDO('account_user_assoc');
        $doAccount_user_assoc->user_id = $this->user_id;
        return $doAccount_user_assoc->count();
    }

    /**
     * Returns user ID for specific username
     *
     * @param string $userName  Username
     * @return integer  User ID or false if user do not exists
     */
    function getUserIdByUserName($userName)
    {
        $this->username = $userName;
        if ($this->find()) {
            $this->fetch();
            return $this->user_id;
        }
        return false;
    }

    /**
     * Fetch user by it's username
     *
     * @param string $userName
     * @return boolean True on success else false
     */
    function fetchUserByUserName($userName)
    {
        $this->username = $userName;
        if (!$this->find()) {
            return false;
        }
        return $this->fetch();
    }

    /**
     * Returns array of users linked to entity
     *
     * @param string $entityName  Inventory entity name (affiliates, clients, etc)
     * @param integer $entityId  Inventory entity ID
     * @return array
     */
    function getAccountUsersByEntity($entityName, $entityId)
    {
        $doUsers = OA_Dal::factoryDO('users');
        $doAccount_user_assoc = OA_Dal::factoryDO('account_user_assoc');
        $doAccount_user_assoc->account_id =
            OA_Permission::getAccountIdForEntity($entityName, $entityId);
        $doUsers->joinAdd($doAccount_user_assoc);
        $doUsers->find();
        return $this->_buildUsersTable($doUsers);
    }


    /**
     * Returns array of admin users (@see _buildUsersTable)
     *
     * @return array
     */
    function getAdminUsers()
    {
        $doUsers = OA_Dal::factoryDO('users');
        $doAccounts = OA_Dal::factoryDO('accounts');
        $doAccounts->account_type = OA_ACCOUNT_ADMIN;
        $doAccount_user_assoc = OA_Dal::factoryDO('account_user_assoc');
        $doAccount_user_assoc->joinAdd($doAccounts);
        $doUsers->joinAdd($doAccount_user_assoc);
        $doUsers->find();
        return $this->_buildUsersTable($doUsers);
    }

    /**
     * Reads users data from database and returns them as array when
     * key is user id and value is array of user values
     *
     * @param DataObjects_Users $doUsers
     * @return array
     */
    function _buildUsersTable(&$doUsers)
    {
        $aUsers = array();
        while($doUsers->fetch()) {
            $aUsers[$doUsers->user_id] = $doUsers->toArray();
            // is user linked to his last account
            $aUsers[$doUsers->user_id]['toDelete'] = ($doUsers->countLinkedAccounts() == 1);
        }
        return $aUsers;
    }

    function _auditEnabled()
    {
        return true;
    }

    function _getContextId()
    {
        return $this->user_id;
    }

    function _getContext()
    {
        return 'User';
    }

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
        return OA_Dal_ApplicationVariables::get('admin_account_id');
    }

    /**
     * build an accounts specific audit array
     *
     * @param integer $actionid
     * @param array $aAuditFields
     */
    function _buildAuditArray($actionid, &$aAuditFields)
    {
        $aAuditFields['key_desc']     = $this->username;

        // Do not log the password hash in the audit record, just the fact that it was changed
        if (isset($aAuditFields['password'])) { $aAuditFields['password'] = '******'; }
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

?>
