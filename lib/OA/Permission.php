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

// Following files were included by lib-permissions
require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/www/admin/lib-gui.inc.php';
require_once MAX_PATH . '/www/admin/lib-sessions.inc.php';
require_once MAX_PATH . '/lib/max/other/common.php';
require_once MAX_PATH . '/lib/OA/Upgrade/EnvironmentManager.php';
require_once MAX_PATH . '/lib/OA/Permission/SystemUser.php';


/**
 * Account types
 */
define('OA_ACCOUNT_ADMIN',      'ADMIN');
define('OA_ACCOUNT_MANAGER',    'MANAGER');
define('OA_ACCOUNT_ADVERTISER', 'ADVERTISER');
define('OA_ACCOUNT_TRAFFICKER', 'TRAFFICKER');

/**
 * Account types constants defined as integers
 * so they could be saved in preferences
 */
define ("OA_ACCOUNT_ADMIN_ID", 1);
define ("OA_ACCOUNT_ADVERTISER_ID", 2);
define ("OA_ACCOUNT_TRAFFICKER_ID", 4);
define ("OA_ACCOUNT_MANAGER_ID", 8);

/**
 * Per-account permissions
 *
 * Warning: Do not change the values of following rights - they are used
 * as a IDs in database and should be the same as in "rights" table.
 */
define('OA_PERM_BANNER_ACTIVATE',   1);
define('OA_PERM_BANNER_DEACTIVATE', 2);
define('OA_PERM_BANNER_ADD',        3);
define('OA_PERM_BANNER_EDIT',       4);

define('OA_PERM_ZONE_ADD',          5);
define('OA_PERM_ZONE_DELETE',       6);
define('OA_PERM_ZONE_EDIT',         7);
define('OA_PERM_ZONE_INVOCATION',   8);
define('OA_PERM_ZONE_LINK',         9);

define('OA_PERM_SUPER_ACCOUNT',    10);

define('OA_PERM_USER_LOG_ACCESS',    11);



/**
 * A generic class which provides permissions related methods.
 *
 * @static
 * @package    OpenadsPermission
 */
class OA_Permission
{
    /**
     * Operation permissions.
     * Can be used when trying to access particular entity.
     */
    const OPERATION_ADD = 1;
    const OPERATION_EDIT = 2;
    const OPERATION_VIEW = 4;
    const OPERATION_DELETE = 8;
    const OPERATION_DUPLICATE = 16;
    const OPERATION_MOVE = 32;
    const OPERATION_ADD_CHILD = 64;
    const OPERATION_VIEW_CHILDREN = 128;
    const OPERATION_ALL = 255;//1+2+4+8+16+  32+64+128

    /**
     * CVE-2013-5954
     *
     * Helper method which checks if the correct session token is present
     * when CRUD actions (generally deletes) are performed using a GET instead
     * of a POST (for historical reasons). Allows the CSRF vulnerabilities
     * reported in CVE-2013-5954 to be closed off without the required (and
     * eventually needed) refactoring of the enture UI to a proper MVC
     * framework.
     */
    public static function checkSessionToken($tokenName = 'token')
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $token = isset($_POST[$tokenName]) ? $_POST[$tokenName] : false;
        } else {
            $token = isset($_GET[$tokenName]) ? $_GET[$tokenName] : false;
        }

        OA_Permission::enforceTrue(
            phpAds_SessionValidateToken($token, $tokenName)
        );
    }

    /**
     * Helper method which checks whether $condition is true, if it is not true
     * it prints to the end user error message
     *
     * @static
     * @param boolean $condition  Condition to check
     */
    public static function enforceTrue($condition)
    {
        if (!$condition) {
            // Queue confirmation message
            $translation = new OX_Translation();
            $translated_message = $translation->translate($GLOBALS['strYouDontHaveAccess']);
            OA_Admin_UI::queueMessage($translated_message, 'global', 'error');
            // Redirect
            OX_Admin_Redirect::redirect(null, null, true);
        }
    }


    /**
     * A method to show an error if the currently active account of an user
     * doesn't match
     *
     * This function takes either an array as the first parameter or
     * a variable number of parameters
     *
     * @static
     * @param string $accountType user type
     */
    public static function enforceAccount($accountType)
    {
        $aArgs = is_array($accountType) ? $accountType : func_get_args();
        $isAccount = self::isAccount($aArgs);
        if (!$isAccount) {
            self::redirectIfManualAccountSwitch();
            $isAccount = self::attemptToSwitchToAccount($aArgs);
        }
        self::enforceTrue($isAccount);
    }


    /**
     * Redirect to the parent page (if exists) or to the start page if account
     * has been switched manually
     *
     */
    public static function redirectIfManualAccountSwitch()
    {
        if (self::isManualAccountSwitch()) {
            require_once LIB_PATH . '/Admin/Redirect.php';
            OX_Admin_Redirect::redirect(null, true);
        }
    }


    /**
     * Returns true if user land on the current page as a result of account switch
     * (If user manually switched account he is redirected to referer url and
     * a accountSwitch parameter is set in session)
     */
    public static function isManualAccountSwitch()
    {
        if (isset($GLOBALS['_OX']['accountSwtich'])) {
            return true;
        }
        return false;
    }


    /**
     * A method to show an error if the user doesn't have access to a specific
     * account
     *
     * @static
     * @param int $accountId
     * @param int $userId  Get current user if null
     */
    public static function enforceAccess($accountId, $userId = null)
    {
        self::enforceTrue(self::hasAccess($accountId, $userId));
    }


    /**
     * A method to show an error if the user doesn't have specific permissions to
     * perform an action on an account
     *
     * @static
     * @param string $permission  See OA_PERM_* constants
     * @param int $accountId Defaults to the current active account
     */
    public static function enforceAllowed($permission, $accountId = null)
    {
        self::enforceTrue(self::hasPermission($permission, $accountId));
    }


    /**
     * A method to show an error if the user doesn't have specific permissions to
     * perform an action on his account. This method only performs a permission check
     * if user is working as an accountType
     *
     * @static
     * @param string $permission  See OA_PERM_* constants
     * @param int $accountId Defaults to the current active account
     */
    public static function enforceAccountPermission($accountType, $permission)
    {
        if (self::isAccount($accountType)) {
            self::enforceTrue(self::hasPermission($permission));
        }
        return true;
    }


    /**
     * A method to show an error if the current user/account doesn't have access
     * to the specified DB_DataObject (defined by table name and entity ID).
     *
     * Optional operation type can be used to indicate more granular object access
     * eg. edit, delete.
     *
     * @static
     * @param string  $entityTable    The name of the table.
     * @param integer $entityId       Optional entity ID -- when set, tests if the current
     *                                account has access to the enity, when not set,  tests
     *                                if the current account can create a new entity in the
     *                                table.
     * @param boolean $allowNewEntity Allow creation of a new entity, defaults to false.
     * @param int $operationAccessType Indicate the operation we need access for
     */
    public static function enforceAccessToObject($entityTable, $entityId = null,
        $allowNewEntity = false, $operationAccessType = self::OPERATION_ALL)
    {
        if (!$allowNewEntity) {
            self::enforceTrue(!empty($entityId));
        }
        // Verify that the ID is numeric
        self::enforceTrue(preg_match('/^\d*$/D', $entityId));
        $entityId = (int)$entityId;
        $hasAccess = self::hasAccessToObject($entityTable, $entityId, $operationAccessType);

        if (!$hasAccess) {
            if(!self::isManualAccountSwitch()) {
                if (self::isUserLinkedToAdmin()) {
                    // Check object existence
                    self::enforceTrue(self::getAccountIdForEntity($entityTable, $entityId));
                }
            }
        }
        if (!$hasAccess) {
            self::redirectIfManualAccountSwitch();
            $hasAccess = self::attemptToSwitchForAccess($entityTable, $entityId, $operationAccessType);
        }
        self::enforceTrue($hasAccess);
    }


    /**
     * A method to switch to the manager account that owns an specific entity
     *
     *@param string  $entityTable    The name of the table.
     *@param integer $entityId       The entity ID.
     */
    public static function switchToManagerAccount($entityTable, $entityId)
    {
        if (empty($entityId)) {
            return false;
        }
        $do = OA_Dal::factoryDO($entityTable);
        if (!$do) {
            return false;
        }
        $key = $do->getFirstPrimaryKey();
        if (!$key) {
            return false;
        }
        $do->$key = $entityId;
        $do->find();
        if ($do->getRowCount() > 0) {
            $do->fetch();
            $aDo = $do->toArray();
        }
        $owningAccounts = $do->_getOwningAccountIdsByAccountId($aDo['account_id']);
        self::switchAccount($owningAccounts['MANAGER'], true);
        return true;
    }


    /**
     * Check if logged user has access to DataObject (defined by it's table name)
     *
     * @static
     * @param string $entityTable  Table name
     * @param int $entityId  Id (or empty if new is created)
     * @param int $operationAccessType Indicate the operation being accessed see OA_Permission HAS_ACCESS consts.
     * @param int $accountId  Account Id (if null account from session is taken)
     * @param string $accountType either OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER, OA_ACCOUNT_ADVERTISER, OA_ACCOUNT_TRAFFICKER
     * @return boolean  True if has access
     */
    public static function hasAccessToObject($entityTable, $entityId, $operationAccessType = self::OPERATION_ALL,
        $accountId = null, $accountType = null)
    {
        $hasAccess = self::_hasAccessToObject($entityTable, $entityId, $accountId, $accountType);

        /**
         * $operationAccessType is currently ignored by core, but can be implemented
         * in plugins eg. to block certain operations on certain entities.
         *
         * We invoke plugins only if core said object can be accessed.
         * If core says object cannot be accessed, plugins cannot change it.
         */
        if ($hasAccess) { //call registered access listeners in plugins
            $hasAccess = self::callAccessHook($entityTable, $entityId,
                $operationAccessType, $accountId, $accountType);
        }

        return $hasAccess;
    }


    private static function _hasAccessToObject($entityTable, $entityId, $accountId = null, $accountType = null)
    {
        if (empty($entityId)) {
            // when a new object is created
            return true;
        }
        // Verify that the ID is numeric
        if (!preg_match('/^\d*$/D', $entityId)) {
            return false;
        }
        $do = OA_Dal::factoryDO($entityTable);
        if (!$do) {
            return false;
        }
        $key = $do->getFirstPrimaryKey();
        if (!$key) {
            return false;
        }
        $do->$key = $entityId;
        $accountTable = self::getAccountTable($accountType);
        if (!$accountTable) {
            return false;
        }
        if ($entityTable == $accountTable) {
            // user has access to itself
            if ($accountId === null) {
                return ($entityId == self::getEntityId());
            } else {
                $do->account_id = self::getAccountId();
                return (bool)$do->count();
            }
        }
        if ($accountId === null) {
            $accountId = self::getAccountId();
        }
        return $do->belongsToAccount($accountId);
    }


    /**
     * A method to switch the active account to a different one
     *
     * @static
     * @param int $accountId
     * @param boolean $hasAccess  Can be used for optimization - if we know that user
     *                            has access to the account he is switching to there is
     *                            no need to check it again
     */
    public static function switchAccount($accountId, $hasAccess = false)
    {
        if ($hasAccess || self::hasAccess($accountId)) {
            $oUser = &self::getCurrentUser();
            $oUser->loadAccountData($accountId);
        }

        // Force session save
        phpAds_SessionDataRegister('user', $oUser);

        // If exists previous message related to switchAccount remove it
        OA_Admin_UI::removeOneMessage('switchAccount');

        // Queue confirmation message
        $translation = new OX_Translation ();
        $translated_message = $translation->translate ( $GLOBALS['strYouAreNowWorkingAsX'], array( htmlspecialchars($oUser->aAccount['account_name']) ));
        OA_Admin_UI::queueMessage($translated_message, 'global', 'info', null, 'switchAccount');
    }


    /**
     * A method to check if the currently active account of an user
     * matches
     *
     * This function takes either an array as the first parameter or
     * a variable number of parameters
     *
     * @todo Better docblock
     *
     * @static
     * @param mixed $accountType
     * @return bool
     */
    public static function isAccount($accountType)
    {
        if ($oUser = self::getCurrentUser()) {
            $aArgs = is_array($accountType) ? $accountType : func_get_args();
            return in_array($oUser->aAccount['account_type'], $aArgs);
        }
        return false;
    }


    public static function attemptToSwitchToAccount($accountType)
    {
        $oUser = self::getCurrentUser();
        if (!$oUser) {
            return false;
        }
        $aAccountTypes = is_array($accountType) ? $accountType : func_get_args();
        $aAccountIds = self::getLinkedAccounts(true);
        $defaultUserAccountId = $oUser->aUser['default_account_id'];
        foreach ($aAccountTypes as $accountType) {
            if (isset($aAccountIds[$accountType])) {
                if (isset($aAccountIds[$accountType][$defaultUserAccountId])) {
                    $accountId = $defaultUserAccountId;
                } else {
                    $accountId = array_shift(array_keys($aAccountIds[$accountType]));
                }
                self::switchAccount($accountId, $hasAccess = true);
                return true;
            }
        }
        return false;
    }


    /**
     * Attempts to find an account which has access to given entity and switch to
     * it if user is linked to that account.
     *
     * Plugins hook for access checks is invoked when checking accounts access to
     * the entity. Optional operation type can be used to indicate more granular
     * object access eg. edit, delete being requested.
     *
     * @static
     * @param string  $entityTable    The name of the table.
     * @param integer $entityId       entity ID
     * @param int $operationAccessType Indicate the operation we need access for
     */
    public static function attemptToSwitchForAccess($entityTable, $entityId,
        $operationAccessType = self::OPERATION_ALL)
    {
        if (!($userId = self::getUserId())) {
            return false;
        }
        $doEntity = OA_Dal::staticGetDO($entityTable, $entityId);
        if ($doEntity) {
           $aAccountIds = $doEntity->getOwningAccountIds();

            foreach ($aAccountIds as $accountType => $accountId) {
                if (self::hasAccess($accountId)) {
                    $hasAccess = self::callAccessHook($entityTable, $entityId,
                        $operationAccessType, $accountId, $accountType);
                    if ($hasAccess) {
                        self::switchAccount($accountId, $hasAccess = true);
                        return true;
                    }
                }
            }

            if (self::isUserLinkedToAdmin()) {
                $accountId = $doEntity->getRootAccountId();
                $hasAccess = self::callAccessHook($entityTable, $entityId,
                    $operationAccessType, $accountId, null);
                if ($hasAccess) {
                    self::switchAccount($accountId, $hasAccess = true);
                    return true;
                }
            }
        }

        return false;
    }


    /**
     * some system processes such as Installer and Maintenance
     * require auditing using there own name
     *
     * This method can switch the username of an existing user (and back again)
     * or can setup a new *fake* user for the process
     *
     * @param string $newUsername If not set, the method will restore the current user
     * @return string $oldUsername
     */
    public static function switchToSystemProcessUser($newUsername = null)
    {
        static $oldUser = null;
        global $session;

        if (!empty($newUsername)) {
            if (empty($oldUser) && isset($session['user'])) {
                $oldUser = $session['user'];
            }
            $session['user'] = new OA_Permission_SystemUser($newUsername);
        } elseif (!empty($oldUser)) {
            $session['user'] = $oldUser;
            $oldUser = null;
            if (!empty($session['user']->aAccount['account_id'])) {
                // Reload from the database to make sure the data is up to date
                $session['user']->loadAccountData($session['user']->aAccount['account_id']);
            }
        } else {
            unset($session['user']);
        }
    }


    /**
     * A (backward compatibility) method to check if the currently active account
     * of an user matches. The difference between this method and isAccount()
     * is that this method gets integers as ACCOUNT TYPES
     *
     * This function takes either an array as the first parameter or
     * a variable number of parameters
     *
     * @todo Better docblock
     *
     * @static
     * @param mixed $accountType
     * @return bool
     */
    public static function isAccountTypeId($accountTypeId)
    {
        if ($oUser = self::getCurrentUser()) {
            $userAccountTypeId = self::convertAccountTypeToId($oUser->aAccount['account_type']);
            return $userAccountTypeId & $accountTypeId;
        }
        return false;
    }


    /**
     * Returns integer equivalent (ID) of account type
     *
     * @static
     * @param unknown_type $acountType
     * @return unknown
     */
    public static function convertAccountTypeToId($accountType)
    {
        $accountTypeIdConstant = 'OA_ACCOUNT_' . $accountType . '_ID';
        if (!defined($accountTypeIdConstant)) {
            MAX::raiseError('No such account type ID: ' . $accountType);
            return false;
        }
        return constant($accountTypeIdConstant);
    }


    /**
     * A method to check if the user has access to a specific account
     *
     * User cuold either has direct access to account or indirect.
     * Indirect access could be in case if user has access to one of the parent
     * entities.
     *
     * @static
     * @param int $accountId
     * @return boolean
     */
    public static function hasAccess($accountId, $userId = null)
    {
        if (empty($userId)) {
            $userId = self::getUserId();
        }
        return self::isUserLinkedToAccount($accountId, $userId)
            || self::isUserLinkedToAdmin($userId);
    }


    /**
     * Returns account type for specific accountId
     *
     * @param integer $accountId
     * @return string  Account type
     */
    public static function getAccountTypeByAccountId($accountId)
    {
        $doAccounts = OA_Dal::factoryDO('accounts');
        $doAccounts->account_id = $accountId;
        if ($doAccounts->find(true)) {
            return $doAccounts->account_type;
        }
        return false;
    }


    /**
     * A method to check if the user is linked to an account
     *
     * @static
     * @param int $accountId
     * @param int $userId
     * @return boolean
     */
    public static function isUserLinkedToAccount($accountId, $userId)
    {
        $doAccount_user_Assoc = OA_Dal::factoryDO('account_user_assoc');
        $doAccount_user_Assoc->user_id = $userId;
        $doAccount_user_Assoc->account_id = $accountId;
        return $doAccount_user_Assoc->count();
    }


    /**
     * Set user access to account
     *
     * @param integer $accountId  account ID
     * @param integer $userId  User ID (if null a logged user id is used)
     * @param boolean $setAccess  defines whether user should or shouldn't have an access to account
     * @return boolean  True on success else false
     */
    public static function setAccountAccess($accountId, $userId, $setAccess = true)
    {
        $doAccount_user_Assoc = OA_Dal::factoryDO('account_user_assoc');
        $doAccount_user_Assoc->account_id = $accountId;
        $doAccount_user_Assoc->user_id = $userId;
        $isExists = (bool) $doAccount_user_Assoc->count();
        if ($isExists && !$setAccess) {
            return $doAccount_user_Assoc->delete();
        }
        if (!$isExists) {
            return $doAccount_user_Assoc->insert();
        }
        return true;
    }


    /**
     * A method to check if the user has specific permissions to perform
     * an action on an account
     *
     * TODOPERM - consider caching permissions in user session so they could
     *            be reused across many user requests
     *
     * @static
     * @param integer $permissionId
     * @param int $accountId
     * @return boolean
     */
    public static function hasPermission($permissionId, $accountId = null, $userId = null)
    {
        if (empty($userId)) {
            $userId = self::getUserId();
        }
        if (self::isUserLinkedToAdmin($userId)) {
            return true;
        }
        static $aCache = array();
        if (empty($accountId)) {
            $accountId   = self::getAccountId();
            $accountType = self::getAccountType();
        } else {
            $oAccounts   = OA_Dal::staticGetDO('accounts', $accountId);
            if ($oAccounts) {
                $accountType = $oAccounts->accountType;
            } else {
                // Account does not exist
                Max::raiseError('No such account ID: '.$accountId);
                return false;
            }
        }
        if (self::isPermissionRelatedToAccountType($accountType, $permissionId)) {
            $aCache[$userId][$accountId] =
                self::getAccountUsersPermissions($userId, $accountId);
        } else {
            $aCache[$userId][$accountId][$permissionId] = true;
        }
        return isset($aCache[$userId][$accountId][$permissionId]) ?
            $aCache[$userId][$accountId][$permissionId] : false;
    }


    public static function getAccountUsersPermissions($userId, $accountId)
    {
        $aPermissions = array();
        $doAccount_user_permission_assoc =
            OA_Dal::factoryDO('account_user_permission_assoc');
        $doAccount_user_permission_assoc->user_id = $userId;
        $doAccount_user_permission_assoc->account_id = $accountId;
        $doAccount_user_permission_assoc->find();
        while ($doAccount_user_permission_assoc->fetch()) {
            $aPermissions[$doAccount_user_permission_assoc->permission_id] =
                    $doAccount_user_permission_assoc->is_allowed;
        }
        return $aPermissions;
    }


    /**
     * Check if a user is linked to the ADMIN account
     *
     * @static
     * @param int $userId
     * @return boolean True if the user is linked to the ADMIN account, false otherwise.
     */
    public static function isUserLinkedToAdmin($userId = null)
    {
        if (!isset($userId) || $userId == self::getUserId()) {
            $oUser = self::getCurrentUser();
        } else {
            $doUsers = OA_Dal::staticGetDO('users', $userId);
            if ($doUsers) {
                $oUser = new OA_Permission_User($doUsers);
            }
        }

        if (!empty($oUser)) {
            return $oUser->aUser['is_admin'];
        }

        return false;
    }


    /**
     * A method which returns all the accounts linked to the user
     *
     * Returns array of:
     *   accountId => 'account name'
     *
     * If $groupByType is equal true returns:
     *   accountType => accountId => 'account name'
     *
     * where accountType is one of: OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER, etc.
     *
     * @param boolean $groupByType
     * @param boolean $sort         An optional parameter, when true, sorts
     *                              the returned values alphabetically by account
     *                              name. Ignored when $groupByType is false.
     * @return array
     */
    public static function getLinkedAccounts($groupByType = false, $sort = false)
    {
        $doAccount_user_Assoc = OA_Dal::factoryDO('account_user_assoc');
        $doAccount_user_Assoc->user_id = self::getUserId();
        $doAccounts = OA_Dal::factoryDO('accounts');
        $doAccounts->orderBy('account_name');
        $doAccount_user_Assoc->joinAdd($doAccounts);
        $doAccount_user_Assoc->find();

        $aAccountsByType = array();
        while($doAccount_user_Assoc->fetch()) {
            $aAccountsByType[$doAccount_user_Assoc->account_type][$doAccount_user_Assoc->account_id] =
                $doAccount_user_Assoc->account_name;
        }
        uksort($aAccountsByType, array('OA_Permission', '_accountTypeSort'));
        if (isset($aAccountsByType[OA_ACCOUNT_ADMIN])) {
            $aAccountsByType = self::mergeAdminAccounts($aAccountsByType);
        }
        if (!$groupByType) {
            $aAccounts = array();
            foreach ($aAccountsByType as $accountType => $aAccount) {
                foreach ($aAccount as $id => $name) {
                    $aAccounts[$id] = $name;
                }
            }
            return $aAccounts;
        }
        if ($sort) {
            foreach ($aAccountsByType as $accountType => $aAccount) {
                natcasesort($aAccountsByType[$accountType]);
            }
        }
        return $aAccountsByType;
    }


    /**
     * A private callback to sort account types
     *
     * @param string $a
     * @param string $b
     * @return int
     */
    public static function _accountTypeSort($a, $b)
    {
        $aTypes = array(OA_ACCOUNT_ADMIN => 0, OA_ACCOUNT_MANAGER => 1, OA_ACCOUNT_ADVERTISER => 2, OA_ACCOUNT_TRAFFICKER => 3);
        $a = isset($aTypes[$a]) ? $aTypes[$a] : 1000;
        $b = isset($aTypes[$b]) ? $aTypes[$b] : 1000;

        return $a - $b;
    }


    static function mergeAdminAccounts($aAccountsByType)
    {
        $doAccounts = OA_Dal::factoryDO('accounts');
        $doAccounts->account_type = OA_ACCOUNT_MANAGER;
        $doAccounts->find();
        while ($doAccounts->fetch()) {
            $aAccountsByType[$doAccounts->account_type][$doAccounts->account_id] =
                $doAccounts->account_name;
        }
        return $aAccountsByType;
    }


    /**
     * A method to retrieve the current user object from a session
     *
     * @static
     * @return OA_Permission_User on success or false otherwise
     */
    public static function &getCurrentUser()
    {
        global $session;
        if (isset($session['user'])) {
            return $session['user'];
        }
        $false = false;
        return $false;
    }


    /**
     * A method to retrieve the user ID of the currently logged in user
     *
     * @static
     * @return int
     */
    public static function getUserId()
    {
        if ($oUser = self::getCurrentUser()) {
            return $oUser->aUser['user_id'];
        }
    }


    /**
     * A method to retrieve the username of the currently logged in user
     *
     * @static
     * @return string
     */
    public static function getUsername()
    {
        if ($oUser = self::getCurrentUser()) {
            return $oUser->aUser['username'];
        }
    }


    /**
     * A method to retrieve the agency ID
     *
     * @static
     * @return int
     */
    public static function getAgencyId()
    {
        if ($oUser = self::getCurrentUser()) {
            return (int) $oUser->aAccount['agency_id'];
        }
        return 0;
    }


    /**
     * A method to get the currently selected account user type
     *
     * @static
     * @param boolean $returnAsString
     * @return string
     */
    static function getAccountTable($type = null)
    {
        if (!$type) {
            if (!($oUser = self::getCurrentUser())) {
                return false;
            }
            $type = $oUser->aAccount['account_type'];
        }
        $aTypes = array(
           OA_ACCOUNT_ADMIN      => 'users',
           OA_ACCOUNT_ADVERTISER => 'clients',
           OA_ACCOUNT_TRAFFICKER => 'affiliates',
           OA_ACCOUNT_MANAGER    => 'agency'
        );

        return isset($aTypes[$type]) ? $aTypes[$type] : false;
    }


    /**
     * A method to get the currently selected account user type
     *
     * @static
     * @param boolean $returnAsString Return the account type as a string
     *                                conversion of the account type, rather
     *                                than the defined string. Optional,
     *                                default is "false".
     *
     * @return mixed If the a user is logged in, returns one of the constants:
     *                  - OA_ACCOUNT_ADMIN;
     *                  - OA_ACCOUNT_MANAGER;
     *                  - OA_ACCOUNT_ADVERTISER;
     *                  - OA_ACCOUNT_TRAFFICKER,
     *               or, if $returnAsString was true, the value of the constants
     *               converted to "String" format,
     *               of, if no user is logged in, null, or the empty string.
     */
    public static function getAccountType($returnAsString = false)
    {
        if ($oUser = self::getCurrentUser()) {
            $type = $oUser->aAccount['account_type'];
            if ($returnAsString) {
                return ucfirst(strtolower($type));
            }
            return $type;
        }
        return $returnAsString ? '' : null;
    }


    /**
     * A method to return the entity id associated with the account
     *
     * @static
     * @return int
     */
    public static function getEntityId()
    {
        if ($oUser = self::getCurrentUser()) {
            return (int) $oUser->aAccount['entity_id'];
        }

        return 0;
    }


    /**
     * A method to get the currently selected account ID
     *
     * @static
     * @return integer
     */
    public static function getAccountId()
    {
        if ($oUser = self::getCurrentUser()) {
            return $oUser->aAccount['account_id'];
        }
        return 0;
    }


    /**
     * A method to get the currently selected account name
     *
     * @static
     * @return String
     */
    public static function getAccountName()
    {
        if ($oUser = self::getCurrentUser()) {
            return $oUser->aAccount['account_name'];
        }
        return 0;
    }


    /**
     * Returns accountId for entity
     *
     * @param string $entity  Entity name (clients, advertiser, agency etc)
     * @param integer $entityId  Entity ID (client id, advertiser id, etc)
     * @return integer  Account ID or false on error
     */
    public static function getAccountIdForEntity($entity, $entityId)
    {
        $doEntity = OA_Dal::staticGetDO($entity, $entityId);
        if (!$doEntity) {
            return false;
        }
        return $doEntity->account_id;
    }


    /**
     * Checks if username is still available and if
     * it is allowed to use.
     *
     * @static
     * @param string $newName  User name to check
     * @param string $oldName  When the method check if user name is available it
     *                         could takes into account existing user name. So
     *                         the same username as existing username is allowed
     * @return boolean  True if allowed
     */
    public static function isUsernameAllowed($newName, $oldName = null)
    {
        if (!empty($oldName) && !strcasecmp($oldName, $newName)) {
            return true;
        }
        return !self::userNameExists($newName);
    }


    /**
     * Checks whether such a username already exists
     *
     * @param string $userName
     * @return boolean  True if such username exists else false
     */
    public static function userNameExists($userName)
    {
        $doUser = OA_Dal::factoryDO('users');
        if (!PEAR::isError($doUser) && $doUser->userExists($userName)) {
            return true;
        }
        return false;
    }


    /**
     * Gets a list of unique usernames.
     *
     * @static
     * @param unknown_type $removeName
     * @return array
     *
     * @TODO Remove this method once its use will be removed from UI
     */
    public static function getUniqueUserNames($removeName = null)
    {
        $uniqueUsers = array();
        $doUser = OA_Dal::factoryDO('users');
        if (PEAR::isError($doUser)) {
            return false;
        }
        $newUniqueNames = $doUser->getUniqueUsers();
        $uniqueUsers = array_merge($uniqueUsers, $newUniqueNames);

        ArrayUtils::unsetIfKeyNumeric($uniqueUsers, $removeName);
        return $uniqueUsers;
    }


	/**
	 * Store user rights per account
	 *
	 * @param array $aPermissions  Array of permission IDs
	 * @param integer $accountId  account ID
	 * @param integer $userId  user ID
	 * @param array $aAllowedPermissions  Array of allowed permissions - keys of array are permissions IDs
	 * @return true on success else false
	 */
	static function storeUserAccountsPermissions($aPermissions, $accountId = null, $userId = null,
	   $aAllowedPermissions = null)
	{
	    if (empty($userId)) {
	        $userId = self::getUserId();
	    }
	    if (empty($accountId)) {
	        $accountId = self::getAccountId();
	    }
	    self::deleteExistingPermissions($accountId, $userId, $aAllowedPermissions);

	    // add new permissions
	    foreach ($aPermissions as $permissionId) {
	        if (!is_null($aAllowedPermissions) && !isset($aAllowedPermissions[$permissionId])) {
	            // check if permission is on the list of allowed permissions
	            continue;
	        }
    	    $doAccount_user_permission_assoc = OA_Dal::factoryDO('account_user_permission_assoc');
    	    $doAccount_user_permission_assoc->account_id = $accountId;
    	    $doAccount_user_permission_assoc->user_id = $userId;
    	    $doAccount_user_permission_assoc->permission_id = $permissionId;
    	    $doAccount_user_permission_assoc->is_allowed = 1;
    	    if (!$doAccount_user_permission_assoc->insert()) {
    	        return false;
    	    }
	    }
	    return true;
	}


	/**
	 * Deletes existing users permissions. If list of permissions is provided it
	 * only clean up permissions from that list
	 *
	 * @param int $accountId
	 * @param int $userId
	 * @param array $allowedPermissions
	 */
	public static function deleteExistingPermissions($accountId, $userId, $allowedPermissions)
	{
	    if (is_array($allowedPermissions)) {
	        foreach ($allowedPermissions as $permissionId => $perm) {
        	    $doAccount_user_permission_assoc = OA_Dal::factoryDO('account_user_permission_assoc');
        	    $doAccount_user_permission_assoc->permission_id = $permissionId;
        	    $doAccount_user_permission_assoc->account_id = $accountId;
        	    $doAccount_user_permission_assoc->user_id = $userId;
        	    $doAccount_user_permission_assoc->delete();
	        }

	    } else {
    	    $doAccount_user_permission_assoc = OA_Dal::factoryDO('account_user_permission_assoc');
    	    $doAccount_user_permission_assoc->account_id = $accountId;
    	    $doAccount_user_permission_assoc->user_id = $userId;
    	    $doAccount_user_permission_assoc->delete();
	    }
	}


	/**
	 * A private static method to return wether an account type is constrained by a
	 * certain permission
	 *
	 * @static
	 *
	 * @param string $accountType
	 * @param int    $permissionId
	 * @return bool
	 */
	public static function isPermissionRelatedToAccountType($accountType, $permissionId)
	{
	    static $aMap = array(
            OA_PERM_BANNER_ACTIVATE     => array(OA_ACCOUNT_ADVERTISER),
            OA_PERM_BANNER_DEACTIVATE   => array(OA_ACCOUNT_ADVERTISER),
            OA_PERM_BANNER_ADD          => array(OA_ACCOUNT_ADVERTISER),
            OA_PERM_BANNER_EDIT         => array(OA_ACCOUNT_ADVERTISER),

            OA_PERM_ZONE_ADD            => array(OA_ACCOUNT_TRAFFICKER),
            OA_PERM_ZONE_DELETE         => array(OA_ACCOUNT_TRAFFICKER),
            OA_PERM_ZONE_EDIT           => array(OA_ACCOUNT_TRAFFICKER),
            OA_PERM_ZONE_INVOCATION     => array(OA_ACCOUNT_TRAFFICKER),
            OA_PERM_ZONE_LINK           => array(OA_ACCOUNT_TRAFFICKER),

            OA_PERM_USER_LOG_ACCESS     => array(OA_ACCOUNT_ADVERTISER, OA_ACCOUNT_TRAFFICKER),

            OA_PERM_SUPER_ACCOUNT       => array(OA_ACCOUNT_MANAGER, OA_ACCOUNT_ADVERTISER, OA_ACCOUNT_TRAFFICKER),
	    );

	    static $aCache;

	    $key = $accountType.','.$permission;

	    if (isset($aCache[$key])) {
	        return $aCache[$key];
	    } elseif (isset($aMap[$permission])) {
	        $aCache[$key] = in_array($accountType, $aMap[$permission]);
	    } else {
	        // Unexpected permission, we suppose it's related to all the account types
	        $aCache[$key] = true;
	    }

	    return $aCache[$key];
	}


    /**
     * Returns all of the account IDs for those accounts "owned"
     * by the given account ID.
     *
     * @param int $accountId The desired "parent" account account to test
     *                       for all "owned" account IDs.
     * @return array An array of account IDs, including the account itself.
     */
    public static function getOwnedAccounts($accountId) {
        $aAccountIds = array();
        $accoutType = self::getAccountTypeByAccountId($accountId);
        switch ($accoutType) {
            case OA_ACCOUNT_MANAGER:
                $aAccountIds[] = $accountId;
                // Retrive the agency ID that corresponds with the manager account
                $doAgency = OA_Dal::factoryDO('agency');
                $doAgency->selectAdd();
                $doAgency->selectAdd('agencyid');
                $doAgency->account_id = $accountId;
                $doAgency->find();
                if ($doAgency->getRowCount() == 1)
                {
                    $doAgency->fetch();
                    $agencyId = $doAgency->agencyid;
                    // Retrieve all advertiser account IDs that the manager
                    // account "owns" (from the affiliates table)
                    $doAffiliates = OA_Dal::factoryDO('affiliates');
                    $doAffiliates->selectAdd();
                    $doAffiliates->selectAdd('account_id');
                    $doAffiliates->agencyid = $agencyId;
                    $doAffiliates->find();
                    if ($doAffiliates->getRowCount() > 0)
                    {
                        $doAffiliates->fetch();
                        $aAccountIds[] = $doAffiliates->account_id;
                    }
                    // Retrieve all website account IDs that the manager
                    // account "owns" (from the clients table)
                    $doClients = OA_Dal::factoryDO('clients');
                    $doClients->selectAdd();
                    $doClients->selectAdd('account_id');
                    $doClients->agencyid = $agencyId;
                    $doClients->find();
                    if ($doClients->getRowCount() > 0)
                    {
                        while ($doClients->fetch())
                        {
                            $aAccountIds[] = $doClients->account_id;
                        }
                    }
                }
                break;
            case OA_ACCOUNT_ADMIN:
                // Select all account IDs
                $doAccounts = OA_Dal::factoryDO('accounts');
                $doAccounts->selectAdd();
                $doAccounts->selectAdd('account_id');
                $doAccounts->find();
                if ($doAccounts->getRowCount() > 0)
                {
                    while ($doAccounts->fetch())
                    {
                         $aAccountIds[] = $doAccounts->account_id;
                    }
                }
                break;
            default:
                $aAccountIds[] = $accountId;
        }
        return $aAccountIds;
    }


    private static function callAccessHook($entityTable, $entityId, $operationAccessType = self::OPERATION_ALL,
        $accountId = null, $accountType = null)
    {
        static $componentCache;

        /*
         * Normally we would expect plugins to return true or false here.
         * Problem arises if plugins create own entities which they protect
         * and what should happen when such plugin is disabled and entities remain.
         *
         * Solution used here is that plugin should return true/false only for entities
         * it's interested in and NULL for entities that it is ignoring.
         *
         * If, after asking all plugins, result is NULL, that means there's no plugin
         * active for such entity and if it's type is different from DEFAULT_SYSTEM it should
         * be protected.
         */
        $hasAccess = NULL; //ignore by default
        $aPlugins = OX_Component::getListOfRegisteredComponentsForHook('objectAccess');
        foreach ($aPlugins as $i => $id){
            $obj = $componentCache[$id];
            if (!isset($obj)) {
                $obj = OX_Component::factoryByComponentIdentifier($id);
                $componentCache[$id] = $obj;
            }

            if ($obj) {
                $pluginResult = $obj->hasAccessToObject($entityTable, $entityId,
                    $operationAccessType, $accountId, $accountType);
                /*
                 * Ignore NULL responses from plugins and update has access only
                 * if plugin was interested in the entity
                 */
                $hasAccess =  $pluginResult === NULL ? $hasAccess : $pluginResult;

                if ($hasAccess === false) { //break on first plugin denying access
                    break;
                }
            }
        }
        //securing non-system entities if no plugin responsible found
        if ($hasAccess === NULL && !empty($entityId)
            && ('clients' == $entityTable || 'campaigns' == $entityTable
                || 'banners' == $entityTable)) {
            $do = OA_Dal::factoryDO($entityTable);
            $aEntity = null;
            if ($do->get($entityId)) {
                $aEntity = $do->toArray();
            }

            switch ($entityTable) {
                case 'clients': {
                    $hasAccess = $aEntity['type'] == DataObjects_Clients::ADVERTISER_TYPE_DEFAULT;
                    break;
                }

                case 'campaigns': {
                    $hasAccess = $aEntity['type'] == DataObjects_Campaigns::CAMPAIGN_TYPE_DEFAULT;
                    break;
                }

                case 'banners' : {
                    $hasAccess = $aEntity['ext_bannertype'] != DataObjects_Banners::BANNER_TYPE_MARKET;
                    break;
                }
            }
        }


        return $hasAccess === NULL ? true : $hasAccess;
    }

}

?>
