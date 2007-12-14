<?php

/*
+---------------------------------------------------------------------------+
| Openads v${RELEASE_MAJOR_MINOR}                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
| For contact details, see: http://www.openads.org/                         |
|                                                                           |
| Copyright (c) 2000-2003 the phpAdsNew developers                          |
| For contact details, see: http://www.phpadsnew.com/                       |
|                                                                           |
| This program is free software; you can redistribute it and/or modify      |
| it under the terms of the GNU General Public License as published by      |
| the Free Software Foundation; either version 2 of the License, or         |
| (at your option) any later version.                                       |
|                                                                           |
| This program is distributed in the hope that it will be useful,           |
| but WITHOUT ANY WARRANTY; without even the implied warranty of            |
| MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
| GNU General Public License for more details.                              |
|                                                                           |
| You should have received a copy of the GNU General Public License         |
| along with this program; if not, write to the Free Software               |
| Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA |
+---------------------------------------------------------------------------+
$Id$
*/

require_once MAX_PATH . '/lib/OA/Permission/Gacl.php';

// Following files were included by lib-permissions
require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/www/admin/lib-gui.inc.php';
require_once MAX_PATH . '/www/admin/lib-sessions.inc.php';
require_once MAX_PATH . '/lib/max/other/common.php';
require_once MAX_PATH . '/lib/OA/Upgrade/EnvironmentManager.php';

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

// @TODO: Following constants should be replaced with new permissions (or removed)
// in order to do that the UI pages should be first refactored

// Define client permissions bitwise, so 1, 2, 4, 8, 16, etc.
define ("phpAds_ModifyInfo", 1);
define ("phpAds_ModifyBanner", 2);
//define ("phpAds_AddBanner", 4); // not in use?
define ("phpAds_DisableBanner", 8);
define ("phpAds_ActivateBanner", 16);
//define ("phpAds_ViewTargetingStats", 32); - removed
//define ("phpAds_EditConversions", 64); - removed
//define ("phpAds_CsvImport", 128); - removed

// Define affiliate permissions bitwise, so 1, 2, 4, 8, 16, etc.
define ("phpAds_LinkBanners", 2);
define ("phpAds_AddZone", 4);
define ("phpAds_DeleteZone", 8);
define ("phpAds_EditZone", 16);
define ("MAX_AffiliateGenerateCode", 32);
//define ("MAX_AffiliateViewZoneStats", 64); - removed
//define ("MAX_AffiliateIsReallyAffiliate", 128); - removed
//define ("MAX_AffiliateViewOnlyApprPendConv", 256); - removed

/**
 * Per-account permissions
 */
define('OA_PERM_ACCOUNT_ACCESS',    'ACCOUNT/ACCESS');

define('OA_PERM_BANNER_ACTIVATE',   'BANNER/ACTIVATE');
define('OA_PERM_BANNER_DEACTIVATE', 'BANNER/DEACTIVATE');
define('OA_PERM_BANNER_ADD',        'BANNER/ADD');
define('OA_PERM_BANNER_EDIT',       'BANNER/EDIT');

define('OA_PERM_ZONE_ADD',          'ZONE/ADD');
define('OA_PERM_ZONE_DELETE',       'ZONE/DELETE');
define('OA_PERM_ZONE_EDIT',         'ZONE/EDIT');
define('OA_PERM_ZONE_INVOCATION',   'ZONE/INVOCATION');
define('OA_PERM_ZONE_LINK',         'ZONE/LINK');


/**
 * A generic class which provides permissions related methods.
 *
 * @static
 * @package    OpenadsPermission
 */
class OA_Permission
{

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
    function enforceAccount($accountType)
    {
        $aArgs = is_array($accountType) ? $accountType : func_get_args();
        if (!OA_Permission::isAccount($aArgs)) {
            phpAds_PageHeader(0);
            phpAds_Die($GLOBALS['strAccessDenied'], $GLOBALS['strNotAdmin']);
        }
    }

    /**
     * A method to show an error if the user doesn't have access to a specific
     * account
     *
     * @static
     * @param int $accountId
     */
    function enforceAccess($accountId)
    {
        OA_Permission::enforceAllowed(OA_PERM_ACCOUNT_ACCESS, $accountId);
    }

    /**
     * A method to show an error if the user doesn't have specific permissions to
     * perform an action on an account
     *
     * @static
     * @param string $permission  See OA_PERM_* constants
     * @param int $accountId Defaults to the current active account
     */
    function enforceAllowed($permission, $accountId = null)
    {
        // FIXME - always allow, temporal hack before it will be possible
        //         to assign permissions to users in UI
        return true;

        if (OA_Permission::isAllowed($permission, $accountId)) {
            return true;
        }

        phpAds_PageHeader('2');
        phpAds_Die($GLOBALS['strAccessDenied'], $GLOBALS['strNotAdmin']);
    }

    /**
     * A method to show an error is the current user/account doesn't have access
     * to DataObject (defined by it's table name)
     *
     * @static
     * @param string $objectTable  Table name
     * @param int $objectId  Id (or empty if new is created)
     * @return boolean  True if has access
     */
    function enforceAccessToObject($objectTable, $objectId, $accountId = null)
    {
        if (OA_Permission::hasAccessToObject($objectTable, $objectId, $accountId)) {
            return true;
        }

        phpAds_PageHeader('2');
        phpAds_Die($GLOBALS['strAccessDenied'], $GLOBALS['strNotAdmin']);
    }

    /**
     * Check if logged user has access to DataObject (defined by it's table name)
     *
     * @static
     * @param string $objectTable  Table name
     * @param int $objectId  Id (or empty if new is created)
     * @param int $accountId  Account Id (if null account from session is taken)
     * @return boolean  True if has access
     */
    function hasAccessToObject($objectTable, $objectId, $accountId = null, $accountType = null)
    {
        if (empty($objectId)) {
            // when a new object is created
            return true;
        }
        $do = OA_Dal::factoryDO($objectTable);
        if (!$do) {
            return false;
        }
        $key = $do->getFirstPrimaryKey();
        if (!$key) {
            return false;
        }
        $do->$key = $objectId;
        $accountTable = OA_Permission::getAccountTable($accountType);
        if (!$accountTable) {
            return false;
        }
        if ($objectTable == $accountTable) {
            // user has access to itself
            if ($accountId === null) {
                return ($objectId == OA_Permission::getEntityId());
            } else {
                $do->account_id = OA_Permission::getAccountId();
                return (bool)$do->count();
            }
        }
        if ($accountId === null) {
            $accountId = OA_Permission::getAccountId();
        }
        return $do->belongsToAccount($accountTable, $accountId);
    }

    /**
     * A method to switch the active account to a different one
     *
     * @static
     * @param int $accountId
     */
    function switchAccount($accountId)
    {
        if (OA_Permission::hasAccess($accountId)) {
            $oUser = OA_Permission::getCurrentUser();
            $oUser->switchAccount($accountId);
        }

        // Force session save
        phpAds_SessionDataRegister('user', $oUser);
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
    function isAccount($accountType)
    {
        if ($oUser = OA_Permission::getCurrentUser()) {
            $aArgs = is_array($accountType) ? $accountType : func_get_args();
            return in_array($oUser->aAccount['account_type'], $aArgs);
        }
        return false;
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
    function isAccountTypeId($accountTypeId)
    {
        if ($oUser = OA_Permission::getCurrentUser()) {
            $userAccountTypeId = OA_Permission::convertAccountTypeToId($oUser->aAccount['account_type']);
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
    function convertAccountTypeToId($accountType)
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
     * @static
     * @param int $accountId
     * @return boolean
     */
    function hasAccess($accountId = null)
    {
        return OA_Permission::isAllowed(OA_PERM_ACCOUNT_ACCESS, $accountId);
    }

    /**
     * A method to check if the user has specific permissions to perform
     * an action on an account
     *
     * @static
     * @param string $section
     * @param string $action
     * @param int $accountId
     * @return boolean
     */
    function isAllowed($aAllowed, $accountId = null)
    {
        if (!is_array($aAllowed)) {
            $aAllowed = explode('/', $aAllowed);
        }
        $section = $aAllowed[0];
        $action  = $aAllowed[1];

        if (empty($accountId)) {
            $accountId = OA_Permission::getAccountId();
        }

        $userId = OA_Permission::getUserId();
        $oGacl = OA_Permission_Gacl::factory();

        if ($userId && $oGacl && $oGacl->acl_check(
                $section,    // $aco_section_value
                $action,     // $aco_value
                'USERS',     // $aro_section_value
                $userId,     // $aro_value
                'ACCOUNTS',  // $axo_section_value
                $accountId)) // $axo_value
        {
            return true;
        }

        return false;
    }

    /**
     * Check if a user is linked to the ADMIN account
     *
     * @static
     * @return boolean True if the currently logged in user is linked to the ADMIN account, false otherwise.
     */
    function isUserLinkedToAdmin()
    {
        if (OA_Permission::getCurrentUser()) {
            $doAccount = OA_Dal::factoryDO('accounts');
            $doAccount->account_type = OA_ACCOUNT_ADMIN;
            $doAccount->find();

            $hasAdminAccess = false;
            while (!$hasAdminAccess && $doAccount->fetch()) {
                $hasAdminAccess = OA_Permission::hasAccess($doAccount->account_id);
            }
            return $hasAdminAccess;
        }

        return false;
    }

    /**
     * A method which returns all the accounts linked to the user
     *
     * @param boolean $groupByType
     * @return array
     */
    function getLinkedAccounts($groupByType = false)
    {
        $oGacl = OA_Permission_Gacl::factory();

        $aAxos = $oGacl->get_object('ACCOUNTS', 1, 'AXO');

        $userId = OA_Permission::getUserId();

        $aAccounts = array();
        foreach ($aAxos as $id) {
            $aAxo = $oGacl->get_object_data($id, 'AXO');
            if ($oGacl->acl_check('ACCOUNT', 'ACCESS', 'USERS', $userId, 'ACCOUNTS', $aAxo[0][1])) {
                $aAccounts[$aAxo[0][1]] = $aAxo[0][3];
            }
        }

        if ($groupByType) {
            $doAccounts = OA_Dal::factoryDO('accounts');
            $aAccountTypes = $doAccounts->getAll(array('account_type'), true, false);

            $aAccountsByType = array();
            foreach ($aAccounts as $id => $name) {
                if (isset($aAccountTypes[$id]['account_type'])) {
                    $aAccountsByType[$aAccountTypes[$id]['account_type']][$id] = $name;
                }
            }

            uksort($aAccountsByType, array('OA_Permission', '_sortByAccountType'));

            return $aAccountsByType;
        }

        return $aAccounts;
    }

    /**
     * A method to retrieve the current user object from a session
     *
     * @static
     * @return OA_Permission_User on success or false otherwise
     */
    function &getCurrentUser()
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
    function getUserId()
    {
        if ($oUser = OA_Permission::getCurrentUser()) {
            return $oUser->aUser['user_id'];
        }
    }

    /**
     * A method to retrieve the username of the currently logged in user
     *
     * @static
     * @return string
     */
    function getUsername()
    {
        if ($oUser = OA_Permission::getCurrentUser()) {
            return $oUser->aUser['username'];
        }
    }

    /**
     * A method to retrieve the agency ID
     *
     * @static
     * @return int
     */
    function getAgencyId()
    {
        if ($oUser = OA_Permission::getCurrentUser()) {
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
    function getAccountTable($type = null)
    {
        if (!$type) {
            if (!($oUser = OA_Permission::getCurrentUser())) {
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
    function getAccountType($returnAsString = false)
    {
        if ($oUser = OA_Permission::getCurrentUser()) {
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
    function getEntityId()
    {
        if ($oUser = OA_Permission::getCurrentUser()) {
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
    function getAccountId()
    {
        if ($oUser = OA_Permission::getCurrentUser()) {
            return $oUser->aAccount['account_id'];
        }
        return 0;
    }

    /**
     * Checks if username is still available and if
     * it is allowed to use.
     *
     * @static
     * @param string $oldName  Old username which we want to change
     * @param string $newName  New user name to change to
     * @return boolean  True if allowed
     */
    function isUsernameAllowed($oldName, $newName)
    {
        if (!empty($oldName) && $oldName == $newName) {
            return true;
        }
        $doUser = OA_Dal::factoryDO('users');
        if (!PEAR::isError($doUser) && $doUser->userExists($newName)) {
            return false;
        }
        return true;
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
    function getUniqueUserNames($removeName = null)
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
	 * Checks the user is allowed to access the requested object.
	 *
     * @static
	 * @param string $objectTable  the DB table of object
	 * @param int $id  the primary key of object
	 */
	function checkAccessToObject($objectTable, $id)
	{
		if (!OA_Permission::hasAccessToObject($objectTable, $id)) {
			global $strNotAdmin, $strAccessDenied;
			phpAds_PageHeader("2");
			phpAds_Die($strAccessDenied, $strNotAdmin);
		}
	}

	/**
	 * Privete method to sort account types
	 *
	 * @param string $a
	 * @param string $b
	 * @return int
	 */
	function _sortByAccountType($a, $b) {
	    $aTypes = array(
	       OA_ACCOUNT_ADMIN      => 0,
	       OA_ACCOUNT_MANAGER    => 1,
	       OA_ACCOUNT_ADVERTISER => 2,
	       OA_ACCOUNT_TRAFFICKER => 3,
       );

       return $aTypes[$a] - $aTypes[$b];
	}

}

?>