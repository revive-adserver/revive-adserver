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
 * @package    OpenXDll
 *
 */

// Require the following classes:
require_once MAX_PATH . '/lib/OA/Dll.php';
require_once MAX_PATH . '/lib/OA/Dll/UserInfo.php';
require_once MAX_PATH . '/lib/OA/Permission.php';


/**
 * The OA_Dll_User class extends the base OA_Dll class.
 *
 */

class OA_Dll_User extends OA_Dll
{
    const ERROR_USERNAME_NOT_UNIQUE = 'Username must be unique';
    const ERROR_DEFAULT_ACC_NOT_LINKED = 'The specified default account is not linked to the user';
    const ERROR_COULD_NOT_LINK_USER_TO_DEFAULT_ACC = 'Could not link the user to the default account';
    const ERROR_UNKNOWN_USER_ID = 'Unknown userId Error';
    const ERROR_UNKNOWN_ACC_ID = 'Unknown accountId Error';
    const ERROR_WRONG_PARAMS = 'Wrong Parameters';
    const ERROR_UNKNOWN_SSO_ID = 'Unknown ssoUserId Error';
    const ERROR_UNKNOWN_SSO_ID_EMAIL = 'Unknown ssoUserId Error while updating user email';
    const ERROR_ACCOUNT_TYPE_MISMATCH = 'Account type mismatch';

    /**
     * This method sets UserInfo from a data array.
     *
     * @access private
     *
     * @param OA_Dll_UserInfo &$oUser
     * @param array $userData
     *
     * @return boolean
     */
    function _setUserDataFromArray(&$oUser, $userData)
    {
        $userData['userId']             = $userData['user_id'];
        $userData['contactName']        = $userData['contact_name'];
        $userData['emailAddress']       = $userData['email_address'];
        $userData['defaultAccountId']   = $userData['default_account_id'];

        $oUser->readDataFromArray($userData);
        return  true;
    }

    /**
     * This method performs data validation for the username and password fields
     * depending on the authentication plugin in use on the system
     *
     * @param OA_Dll_UserInfo $oUser
     * @return boolean
     */
    function _validateAuthentication(&$oUser)
    {
        $oPlugin = OA_Auth::staticGetAuthPlugin();

        return $oPlugin->dllValidation($this, $oUser);
    }

    /**
     * This method performs data validation for the username uniqueness
     *
     * @param OA_Dll_UserInfo $oUser
     * @param OA_Dll_UserInfo $oOldUser
     * @return boolean
     */
    function _validateUsername(&$oUser, $oOldUser = null)
    {
        if (isset($oUser->username)) {
            $oldUsername = empty($oOldUser) ? '' : $oOldUser->username;

            if (!OA_Permission::isUsernameAllowed($oUser->username, $oldUsername)) {
                $this->raiseError(self::ERROR_USERNAME_NOT_UNIQUE);
                return false;
            }
        }

        return true;
    }

    /**
     * This method performs data validation for the default account ID
     *
     * @param OA_Dll_UserInfo $oUser
     * @return boolean
     */
    function _validateDefaultAccount($oUser)
    {
        if (!OA_Permission::isUserLinkedToAccount($oUser->defaultAccountId, $oUser->userId)) {
            $this->raiseError(self::ERROR_DEFAULT_ACC_NOT_LINKED);
            return false;
        }

        return true;
    }

    /**
     * This method performs data validation for a user, for example to check
     * that an email address is an email address. Where necessary, the method connects
     * to the OA_Dal to obtain information for other business validations.
     *
     * @access private
     *
     * @param OA_Dll_UserInfo $oUser
     *
     * @return boolean
     *
     */
    function _validate(&$oUser)
    {
        $oOldUser = null;

        if (isset($oUser->userId)) {
            // When modifying a user, check correct field types are used and the userID exists.
            if (!$this->checkStructureRequiredIntegerField($oUser, 'userId') ||
                !$this->checkStructureNotRequiredIntegerField($oUser, 'defaultAccountId') ||
                !$this->checkIdExistence('users', $oUser->userId)) {
                return false;
            }

            if (!$this->checkStructureNotRequiredStringField($oUser, 'contactName', 255) ||
                !$this->checkStructureNotRequiredStringField($oUser, 'emailAddress', 64)) {
                return false;
            }

            if (!empty($oUser->defaultAccountId) && !$this->_validateDefaultAccount($oUser)) {
                return false;
            }

            // Get the old data
            $doUser = OA_Dal::factoryDO('users');
            $doUser->get($oUser->userId);
            $oOldUser = new OA_Dll_UserInfo();
            $this->_setUserDataFromArray($oOldUser, $doUser->toArray());
        } else {
            // When adding a user, check that the required field 'publisherId' is correct.
            if (!$this->checkStructureRequiredStringField($oUser, 'contactName', 255) ||
                !$this->checkStructureRequiredStringField($oUser, 'emailAddress', 64) ||
                !$this->checkStructureRequiredIntegerField($oUser, 'defaultAccountId')) {
                return false;
            }
        }

        if (!$this->_validateAuthentication($oUser) ||
            !$this->_validateUsername($oUser, $oOldUser)) {
            return false;
        }

        return true;
    }

    /**
     * This method modifies an existing user. Undefined fields do not change
     * and defined fields with a NULL value also remain unchanged.
     *
     * @access public
     *
     * @param OA_Dll_UserInfo $oUser
     *          <b>For adding</b><br />
     *          <b>Required properties:</b> contactName, emailAddress, defaultAccountId<br />
     *          <b>Optional properties:</b> username, password (both depending on the authentication type)<br />
     *
     *          <b>For modify</b><br />
     *          <b>Required properties:</b> userId<br />
     *          <b>Optional properties:</b> contactName, emailAddress, defaultAccountId, password (depending on the authentication type)<br />
     *
     * @return success boolean True if the operation was successful
     *
     */
    function modify(&$oUser)
    {
        if (!isset($oUser->userId)) {
            // Add
            $oUser->setDefaultForAdd();
        }

        if (!$this->checkPermissions(OA_ACCOUNT_ADMIN)) {
            return false;
        }

        $userData = (array) $oUser;

        // Name
        $userData['contact_name']       = $oUser->contactName;
        $userData['email_address']      = $oUser->emailAddress;
        $userData['default_account_id'] = $oUser->defaultAccountId;

        // Add a reference for username and password, they might be modified during validation
        $userData['username'] = &$oUser->username;
        $userData['password'] = &$oUser->password;

        if ($this->_validate($oUser)) {
            $doUser = OA_Dal::factoryDO('users');
            if (!isset($userData['userId'])) {
                $doUser->setFrom($userData);
                $oUser->userId = $doUser->insert();
                if ($oUser->userId) {
                    if (!OA_Permission::setAccountAccess($oUser->defaultAccountId, $oUser->userId)) {
                        $this->raiseError(self::ERROR_COULD_NOT_LINK_USER_TO_DEFAULT_ACC);
                        return false;
                    }
                }
            } else {
                $doUser->get($userData['userId']);
                $doUser->setFrom($userData);
                $doUser->update();
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * This method deletes an existing user.
     *
     * @access public
     *
     * @param integer $userId The ID of the user to delete
     *
     * @return boolean True if the operation was successful
     *
     */
    function delete($userId)
    {
        if (!$this->checkPermissions(OA_ACCOUNT_ADMIN) ||
            !$this->checkIdExistence('users', $userId)) {
            return false;
        } else {
            $doUser = OA_Dal::factoryDO('users');
            $doUser->user_id = $userId;
            $result = $doUser->delete();
        }

        if (!$result) {
            $this->raiseError(self::ERROR_UNKNOWN_USER_ID);
            return false;
        }

        return true;
    }

    /**
     * This method returns UserInfo for a specified user.
     *
     * @access public
     *
     * @param int $userId
     * @param OA_Dll_UserInfo &$oUser
     *
     * @return boolean
     */
    function getUser($userId, &$oUser)
    {
        if (!$this->checkPermissions(OA_ACCOUNT_ADMIN) ||
            !$this->checkIdExistence('users', $userId)) {
            return false;
        }

        $doUser = OA_Dal::factoryDO('users');
        $doUser->get($userId);
        $userData = $doUser->toArray();

        // Remove password
        unset($userData['password']);

        $oUser = new OA_Dll_UserInfo();

        $this->_setUserDataFromArray($oUser, $userData);
        return true;
    }

    /**
     * This method returns a list of users.
     *
     * @access public
     *
     * @param array &$aUserList
     *
     * @return boolean
     */
    function getUserList(&$aUserList)
    {
        if (!$this->checkPermissions(OA_ACCOUNT_ADMIN)) {
            return false;
        }

	$aUserList = array();

        $doUser = OA_Dal::factoryDO('users');
        $doUser->find();

        while ($doUser->fetch()) {
            $userData = $doUser->toArray();

            // Remove password
            unset($userData['password']);

            $oUser = new OA_Dll_UserInfo();
            $this->_setUserDataFromArray($oUser, $userData);

            $aUserList[] = $oUser;
        }
        return true;
    }

    /**
     * This method returns a list of users for a publisher.
     *
     * @access public
     *
     * @param int $publisherId
     * @param array &$aUserList
     *
     * @return boolean
     */
    function getUserListByAccountId($accountId, &$aUserList)
    {
        $aUserList = array();

        if (!$this->checkIdExistence('accounts', $accountId) ||
            !$this->checkPermissions(null, 'accounts', $accountId)) {
            return false;
        }

        $doAUA = OA_Dal::factoryDO('account_user_assoc');
        $doAUA->account_id = $accountId;
        $doUser = OA_Dal::factoryDO('users');
        $doUser->joinAdd($doAUA);
        $doUser->find();

        while ($doUser->fetch()) {
            $userData = $doUser->toArray();

            // Remove password
            unset($userData['password']);

            $oUser = new OA_Dll_UserInfo();
            $this->_setUserDataFromArray($oUser, $userData);

            $aUserList[] = $oUser;
        }
        return true;
    }

    /**
     * This method updates users SSO User Id
     *
     * @param int $oldSsoUserId
     * @param int $newSsoUserId
     * @return bool
     */
    function updateSsoUserId($oldSsoUserId, $newSsoUserId)
    {
        if (!$this->checkPermissions(OA_ACCOUNT_ADMIN)) {
            return false;
        }

        if (empty($oldSsoUserId) || empty($newSsoUserId)) {
            $this->raiseError(self::ERROR_WRONG_PARAMS);
            return false;
        }

        $doUsers = OA_Dal::factoryDO('users');
        $doUsers->whereAdd('sso_user_id = '.$doUsers->quote($oldSsoUserId));
        $doUsers->sso_user_id = $newSsoUserId;

        if (!$doUsers->update(DB_DATAOBJECT_WHEREADD_ONLY)) {
            $this->raiseError(self::ERROR_UNKNOWN_SSO_ID);
            return false;
        }

        return true;
    }

    /**
     * This method updates users email for SSO User Id
     *
     * @param int $ssoUserId
     * @param string $email
     * @return bool
     */
    function updateUserEmailBySsoId($ssoUserId, $email)
    {
        if (!$this->checkPermissions(OA_ACCOUNT_ADMIN)) {
            return false;
        }

        if (empty($ssoUserId) || empty($email)) {
            $this->raiseError(self::ERROR_WRONG_PARAMS);
            return false;
        }

        $doUsers = OA_Dal::factoryDO('users');
        $doUsers->whereAdd('sso_user_id = '.$doUsers->quote($ssoUserId));
        $doUsers->email_address = $email;

        if (!$doUsers->update(DB_DATAOBJECT_WHEREADD_ONLY)) {
            // this will be quite common message
            // maybe we shouln't consider different handling in this case?
            $this->raiseError(self::ERROR_UNKNOWN_SSO_ID_EMAIL);
            return false;
        }

        return true;
    }

    /**
     * Links a user to an account.
     *
     * @param int $userId
     * @param int $accountId
     * @param array $aPermissions array of permissions to set (see OA_Permission.) eg:
     *                            array(OA_PERM_SUPER_ACCOUNT, OA_PERM_BANNER_EDIT)
     * @param array $aAllowedPermissions array of permissions that are allowed to be set.
     *                                   Confusingly, the array format is different from
     *                                   $aPermissions in that the permission is set in the
     *                                   array key. The array value is not used and should be set to true. eg:
     *                                   array(OA_PERM_SUPER_ACCOUNT => true, OA_PERM_BANNER_EDIT => true)
     * @return boolean true on successful linking, false otherwise.
     */
    private function linkUserToAccount($userId, $accountId, $aPermissions = null, $aAllowedPermissions = null)
    {
        if (!$this->checkPermissions(OA_ACCOUNT_ADMIN)) {
            return false;
        }

        if (!$this->checkIdExistence('users', $userId)) {
            $this->raiseError(self::ERROR_UNKNOWN_USER_ID);
            return false;
        }

        $result = OA_Permission::setAccountAccess($accountId, $userId);
        if (PEAR::isError($result)) {
            $this->raiseError($result->getMessage());
            return false;
        }

        if (!empty($aPermissions)) {
            $result = OA_Permission::storeUserAccountsPermissions($aPermissions, $accountId,
                $userId, $aAllowedPermissions);
            if (PEAR::isError($result)) {
                $this->raiseError($result->getMessage());
                return false;
            }
        }

        return true;
    }

    /**
     * Links a user to an advertiser account.
     *
     * @param int $userId
     * @param int $accountId
     * @param array $aPermissions array of permissions to set (see OA_Permission.) eg:
     *                            array(OA_PERM_SUPER_ACCOUNT, OA_PERM_BANNER_EDIT)
     * @return boolean true on successful linking, false otherwise.
     */
    function linkUserToAdvertiserAccount($userId, $advertiserAccountId, $aPermissions = null)
    {
        if (!$this->checkIdExistence('accounts', $advertiserAccountId)) {
            $this->raiseError(self::ERROR_UNKNOWN_ACC_ID);
            return false;
        }

        if (!$this->checkAccountType($advertiserAccountId, OA_ACCOUNT_ADVERTISER)) {
            $this->raiseError(self::ERROR_ACCOUNT_TYPE_MISMATCH);
            return false;
        }

        $aAllowedPermissions = array();
        $aAllowedPermissions[OA_PERM_SUPER_ACCOUNT] = true;
        $aAllowedPermissions[OA_PERM_BANNER_EDIT] = true;
        $aAllowedPermissions[OA_PERM_BANNER_DEACTIVATE] = true;
        $aAllowedPermissions[OA_PERM_BANNER_ACTIVATE] = true;
        $aAllowedPermissions[OA_PERM_USER_LOG_ACCESS] = true;

        return $this->linkUserToAccount(
            $userId, $advertiserAccountId, $aPermissions, $aAllowedPermissions);
    }

    /**
     * Links a user to a trafficker account.
     *
     * @param int $userId
     * @param int $accountId
     * @param array $aPermissions array of permissions to set (see OA_Permission.) eg:
     *                            array(OA_PERM_SUPER_ACCOUNT, OA_PERM_ZONE_EDIT)
     * @return boolean true on successful linking, false otherwise.
     */
    function linkUserToTraffickerAccount($userId, $traffickerAccountId, $aPermissions = null)
    {
        if (!$this->checkIdExistence('accounts', $traffickerAccountId)) {
            $this->raiseError(self::ERROR_UNKNOWN_ACC_ID);
            return false;
        }

        if (!$this->checkAccountType($traffickerAccountId, OA_ACCOUNT_TRAFFICKER)) {
            $this->raiseError(self::ERROR_ACCOUNT_TYPE_MISMATCH);
            return false;
        }

        $aAllowedPermissions = array();
        $aAllowedPermissions[OA_PERM_SUPER_ACCOUNT] = true;
        $aAllowedPermissions[OA_PERM_ZONE_EDIT] = true;
        $aAllowedPermissions[OA_PERM_ZONE_ADD] = true;
        $aAllowedPermissions[OA_PERM_ZONE_DELETE] = true;
        $aAllowedPermissions[OA_PERM_ZONE_LINK] = true;
        $aAllowedPermissions[OA_PERM_ZONE_INVOCATION] = true;
        $aAllowedPermissions[OA_PERM_USER_LOG_ACCESS] = true;

        return $this->linkUserToAccount(
            $userId, $traffickerAccountId, $aPermissions, $aAllowedPermissions);
    }

    /**
     * Links a user to a manager account.
     *
     * @param int $userId
     * @param int $accountId
     * @param array $aPermissions array of permissions to set (see OA_Permission.) eg:
     *                            array(OA_PERM_SUPER_ACCOUNT)
     * @return boolean true on successful linking, false otherwise.
     */
    function linkUserToManagerAccount($userId, $managerAccountId, $aPermissions = null)
    {
        if (!$this->checkIdExistence('accounts', $managerAccountId)) {
            $this->raiseError(self::ERROR_UNKNOWN_ACC_ID);
            return false;
        }

        if (!$this->checkAccountType($managerAccountId, OA_ACCOUNT_MANAGER)) {
            $this->raiseError(self::ERROR_ACCOUNT_TYPE_MISMATCH);
            return false;
        }

        $aAllowedPermissions = array();
        $aAllowedPermissions[OA_PERM_SUPER_ACCOUNT] = true;

        return $this->linkUserToAccount(
            $userId, $managerAccountId, $aPermissions, $aAllowedPermissions);
    }

    private function checkAccountType($accountId, $accountType)
    {
        $doAccount = OA_Dal::staticGetDO('accounts', $accountId);
        return $doAccount->account_type == $accountType;
    }
}

?>
