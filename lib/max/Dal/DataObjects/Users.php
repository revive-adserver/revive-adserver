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
 * Table Definition for users
 */
require_once 'DB_DataObjectCommon.php';
require_once MAX_PATH . '/lib/OA/Permission.php';
require_once 'Date.php';

class DataObjects_Users extends DB_DataObjectCommon
{
    var $onDeleteCascade = true;
    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    public $__table = 'users';                           // table name
    public $user_id;                         // MEDIUMINT(9) => openads_mediumint => 129
    public $contact_name;                    // VARCHAR(255) => openads_varchar => 130
    public $email_address;                   // VARCHAR(64) => openads_varchar => 130
    public $username;                        // VARCHAR(64) => openads_varchar => 2
    public $password;                        // VARCHAR(64) => openads_varchar => 2
    public $language;                        // VARCHAR(5) => openads_varchar => 2
    public $default_account_id;              // MEDIUMINT(9) => openads_mediumint => 1
    public $comments;                        // TEXT() => openads_text => 34
    public $active;                          // TINYINT(1) => openads_tinyint => 145
    public $sso_user_id;                     // INT(11) => openads_int => 1
    public $date_created;                    // DATETIME() => openads_datetime => 14
    public $date_last_login;                 // DATETIME() => openads_datetime => 14
    public $email_updated;                   // DATETIME() => openads_datetime => 14

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGetFromClassName('DataObjects_Users',$k,$v); }

    var $defaultValues = array(
                'contact_name' => '',
                'email_address' => '',
                'active' => 1,
                'sso_user_id' => OX_DATAOBJECT_NULL,
                'date_last_login' => OX_DATAOBJECT_NULL,
                'email_updated' => OX_DATAOBJECT_NULL,
                );

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE

    /**
     * Handle all necessary operations when a user is inserted
     *
     * @see DB_DataObject::insert()
     */
    function insert()
    {
        if (isset($this->username)) {
            $this->username = strtolower($this->username);
        }
        if (empty($this->date_created)) {
            $this->date_created = $this->formatDate(new Date());
        }
        if (empty($this->email_updated)) {
            $this->email_updated = $this->formatDate(new Date());
        }
        return parent::insert();
    }


    /**
     * Handle all necessary operations when a user is updated
     *
     * @see DB_DataObject::update()
     */
    function update($dataObject = false)
    {
        if (isset($this->username)) {
            $this->username = strtolower($this->username);
        }

        return parent::update($dataObject);
    }

    /**
     * Checks is a username already exists in the database
     *
     * @param string $username
     * @return boolean
     */
    function userExists($username)
    {
        $this->username = strtolower($username);
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
        return $this->getUserIdByProperty('username', $userName);
    }

    /**
     * Returns user ID for specific username
     *
     * @param string $userName  Username
     * @return integer  User ID or false if user do not exists
     */
    function getUserIdByProperty($propertyName, $propertyValue)
    {
        $this->whereAdd($propertyName.' = '.$this->quote($propertyValue));
        if ($this->find()) {
            $this->fetch();
            return $this->user_id;
        }
        return false;
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
        $doAccounts->account_id = OA_Dal_ApplicationVariables::get('admin_account_id');
        $doAccount_user_assoc = OA_Dal::factoryDO('account_user_assoc');
        $doAccount_user_assoc->joinAdd($doAccounts);
        $doUsers->joinAdd($doAccount_user_assoc);
        $doUsers->find();
        return $this->_buildUsersTable($doUsers);
    }

    /**
     * Updates the date_last_log_in time of user.
     *
     * @return date
     */
    function logDateLastLogIn($date = null)
    {
        if (!$date) {
            $date = new Date();
        }
        $this->date_last_login = $this->formatDate($date);
        return $this->update();
    }

    /**
     * This method should be called when a user claims existing sso account
     * and it turns out that the sso account he wants to use is already linked
     * to existing user. In such case all accounts and permissions
     * from his partial account should be relinked to his existing account.
     *
     * @param integer $fromUserId
     * @param integer $toUserId
     * @return boolean
     */
    function relinkAccounts($existingUserId, $partialUserId)
    {
        $existingAccountIds = $this->getLinkedAccountsIds($existingUserId);
        $partialAccountIds = $this->getLinkedAccountsIds($partialUserId);
        $newAccounts = array_diff($partialAccountIds, $existingAccountIds);
        foreach ($newAccounts as $newAccountId) {
            if (!OA_Permission::setAccountAccess($newAccountId, $existingUserId)) {
                return false;
            }
        }
        return $this->addUserPermissions($existingUserId,
            $this->getUsersPermissions($partialUserId));
    }

    /**
     * Sets on the user account accounts/permissions.
     *
     * @param integer $userId
     * @param array $aAccountPermissions
     */
    function addUserPermissions($userId, $aAccountPermissions)
    {
        foreach ($aAccountPermissions as $accountId => $aPermissions) {
            foreach ($aPermissions as $permissionId => $isAllowed) {
                $doAccount_user_permission_assoc =
                    OA_Dal::factoryDO('account_user_permission_assoc');
                $doAccount_user_permission_assoc->account_id = $accountId;
                $doAccount_user_permission_assoc->user_id = $userId;
                $doAccount_user_permission_assoc->permission_id = $permissionId;
                $doAccount_user_permission_assoc->is_allowed = 1;
                if (!$doAccount_user_permission_assoc->find()) {
                    if (!$doAccount_user_permission_assoc->insert()) {
                        return false;
                    }
                }
            }
        }
        return true;
    }

    /**
     * Returns an array of users permissions. Format of array:
     * array(
     *   accountId => array(
     *       permissions_id => is_allowed
     *     )
     * )
     *
     * @param integer $userId
     * @return array
     */
    function getUsersPermissions($userId)
    {
        $aPermissions = array();
        $doAccount_user_permission_assoc =
            OA_Dal::factoryDO('account_user_permission_assoc');
        $doAccount_user_permission_assoc->user_id = $userId;
        $doAccount_user_permission_assoc->find();
        while ($doAccount_user_permission_assoc->fetch()) {
            $aPermissions[$doAccount_user_permission_assoc->account_id]
                [$doAccount_user_permission_assoc->permission_id] =
                    $doAccount_user_permission_assoc->is_allowed;
        }
        return $aPermissions;
    }

    /**
     * Returns array of account Ids which user is linked to
     *
     * @return array
     */
    function getLinkedAccountsIds($userId = null)
    {
        if (empty($userId)) {
            $userId = $this->user_id;
        }
        $doAccount_user_assoc = OA_Dal::factoryDO('account_user_assoc');
        $doAccount_user_assoc->user_id = $userId;
        return $doAccount_user_assoc->getAll('account_id');
    }

    /**
     * Deletes users who are not linked with any sso account, never logged
     * in and their account was created before deleteUnverifiedUsersAfter days.
     * Where deleteUnverifiedUsersAfter is defined in config in
     * "authentication" section.
     *
     * @return boolean
     */
    function deleteUnverifiedUsers($deleteOlderThanSeconds = null)
    {
        if (empty($deleteOlderThanSeconds)) {
            // by default 28 days
            $deleteOlderThanSeconds = OA::getConfigOption('authentication',
                'deleteUnverifiedUsersAfter', 2419200);
        }
        $monthAgo = new Date();
        $monthAgo->subtractSeconds($deleteOlderThanSeconds);

        $this->whereAdd('date_created < \'' . $this->formatDate($monthAgo).'\'');
        $this->whereAdd('sso_user_id IS NULL');
        $this->whereAdd('date_last_login IS NULL');
        return $this->delete(DB_DATAOBJECT_WHEREADD_ONLY);
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
        // Special case - return the admin account ID only.
        // This is because we can only store one account ID for each
        // type of account, however, it's possible for a user to be
        // linked to (for example) multiple accounts, which are in turn
        // owned by multiple manager accounts, so it's simply not possible
        // to record all possible manager account IDs; so, we restrict
        // auditing of user entities to be only visible to the admin
        // account
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
        $aAuditFields['key_desc']     = $this->username;

        // Do not log the password hash in the audit record, just the fact that it was changed
        if (isset($aAuditFields['password'])) { $aAuditFields['password'] = '******'; }
    }
}

?>
