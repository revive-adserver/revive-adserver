<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
| For contact details, see: http://www.openx.org/                           |
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

/**
 * @package    OpenXDll
 * @author     Matteo Beccati <matteo.beccati@openx.org>
 *
 */

// Require the following classes:
require_once MAX_PATH . '/lib/OA/Dll.php';
require_once MAX_PATH . '/lib/OA/Dll/UserInfo.php';


/**
 * The OA_Dll_User class extends the base OA_Dll class.
 *
 */

class OA_Dll_User extends OA_Dll
{
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
                $this->raiseError('Username must be unique');
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
            $this->raiseError('The specified default account is not linked to the user');
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

            if (!$this->checkStructureNotRequiredStringField($oUser, 'contactName', 255)) {
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
                        $this->raiseError('Could not link the user to the default account');
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
            $this->raiseError('Unknown userId Error');
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
            $this->raiseError('Wrong Parameters');
            return false;
        }

        $doUsers = OA_Dal::factoryDO('users');
        $doUsers->whereAdd('sso_user_id = '.$doUsers->quote($oldSsoUserId));
        $doUsers->sso_user_id = $newSsoUserId;

        if (!$doUsers->update(DB_DATAOBJECT_WHEREADD_ONLY)) {
            $this->raiseError('Unknown ssoUserId Error');
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
            $this->raiseError('Wrong Parameters');
            return false;
        }

        $doUsers = OA_Dal::factoryDO('users');
        $doUsers->whereAdd('sso_user_id = '.$doUsers->quote($ssoUserId));
        $doUsers->email_address = $email;

        if (!$doUsers->update(DB_DATAOBJECT_WHEREADD_ONLY)) {
            // this will be quite common message
            // maybe we shouln't consider different handling in this case?
            $this->raiseError('Unknown ssoUserId Error while updating user email');
            return false;
        }

        return true;
    }
}

?>
