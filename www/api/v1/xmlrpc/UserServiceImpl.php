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
 * @package    OpenX
 * @author     Matteo Beccati <matteo.beccati@openx.org>
 *
 */

// Require the base class, BaseLogonService
require_once MAX_PATH . '/www/api/v1/common/BaseServiceImpl.php';

// Require the user Dll class.
require_once MAX_PATH . '/lib/OA/Dll/User.php';

/**
 * The UserServiceImpl class extends the BaseServiceImpl class to enable
 * you to add, modify, delete and search the user object.
 *
 */
class UserServiceImpl extends BaseServiceImpl
{
    /**
     *
     * @var OA_Dll_User $_dllUser
     */
    var $_dllUser;

    /**
     *
     * The UserServiceImpl method is the constructor for the
     * UserServiceImpl class.
     */
    function UserServiceImpl()
    {
        $this->BaseServiceImpl();
        $this->_dllUser = new OA_Dll_User();
    }

    /**
     * This method checks if an action is valid and either returns a result
     * or an error, as appropriate.
     *
     * @access private
     *
     * @param boolean $result
     *
     * @return boolean
     */
    function _validateResult($result)
    {
        if ($result) {
            return true;
        } else {
            $this->raiseError($this->_dllUser->getLastError());
            return false;
        }
    }

    /**
     * The addUser method creates an user and updates the
     * user object with the user ID.
     *
     * @access public
     *
     * @param string $sessionId
     * @param OA_Dll_UserInfo &$oUser <br />
     *          <b>Required properties:</b> userName<br />
     *          <b>Optional properties:</b> agencyId, contactName, emailAddress, username, password<br />
     *
     * @return boolean
     */
    function addUser($sessionId, &$oUser)
    {
        if ($this->verifySession($sessionId)) {

            return $this->_validateResult($this->_dllUser->modify($oUser));

        } else {

            return false;
        }

    }
    /**
     * The modifyUser method checks if an user ID exists and
     * modifies the details for the user if it exists or returns an error
     * message, as appropriate.
     *
     * @access public
     *
     * @param string $sessionId
     * @param OA_Dll_UserInfo &$oUser <br />
     *          <b>Required properties:</b> userId<br />
     *          <b>Optional properties:</b> agencyId, userName, contactName, emailAddress, username, password<br />
     *
     * @return boolean
     */
    function modifyUser($sessionId, &$oUser)
    {
        if ($this->verifySession($sessionId)) {

            if (isset($oUser->userId)) {

                return $this->_validateResult($this->_dllUser->modify($oUser));

            } else {

                $this->raiseError("Field 'userId' in structure does not exists");
                return false;
            }

        } else {

            return false;
        }

    }

    /**
     * The deleteUser method checks if an user exists and deletes
     * the user or returns an error message, as appropriate.
     *
     * @access public
     *
     * @param string $sessionId
     * @param integer $userId
     *
     * @return boolean
     */
    function deleteUser($sessionId, $userId)
    {
        if ($this->verifySession($sessionId)) {

            return $this->_validateResult($this->_dllUser->delete($userId));

        } else {

            return false;
        }
    }

    /**
     * The getUser method returns the user details for a specified user.
     *
     * @access public
     *
     * @param string $sessionId
     * @param integer $userId
     * @param OA_Dll_UserInfo &$oUser
     *
     * @return boolean
     */
    function getUser($sessionId, $userId, &$oUser)
    {
        if ($this->verifySession($sessionId)) {

            return $this->_validateResult(
                $this->_dllUser->getUser($userId, $oUser));
        } else {

            return false;
        }
    }

    /**
     * The getUserListByAccountId method returns a list of users
     * for a specified account.
     *
     * @access public
     *
     * @param string $sessionId
     * @param integer $accountId
     * @param array &$aUserList  Array of OA_Dll_UserInfo classes
     *
     * @return boolean
     */
    function getUserListByAccountId($sessionId, $accountId, &$aUserList)
    {
        if ($this->verifySession($sessionId)) {

            return $this->_validateResult(
                $this->_dllUser->getUserListByAccountId($accountId,
                                                    $aUserList));
        } else {

            return false;
        }
    }

    /**
     * This method updates users SSO User Id
     *
     * @access public
     *
     * @param string $sessionId
     * @param int $oldSsoUserId
     * @param int $newSsoUserId
     * @return bool
     */
    function updateSsoUserId($sessionId, $oldSsoUserId, $newSsoUserId)
    {
        if ($this->verifySession($sessionId)) {

            return $this->_validateResult(
                $this->_dllUser->updateSsoUserId($oldSsoUserId, $newSsoUserId));
        } else {

            return false;
        }
    }

    /**
     * This method updates users email for the user who is matching SSO user Id
     *
     * @access public
     *
     * @param string $sessionId
     * @param int $ssoUserId
     * @param string $email
     * @return bool
     */
    function updateUserEmailBySsoId($sessionId, $ssoUserId, $email)
    {
        if ($this->verifySession($sessionId)) {

            return $this->_validateResult(
                $this->_dllUser->updateUserEmailBySsoId($ssoUserId, $email));
        } else {

            return false;
        }
    }

}


?>