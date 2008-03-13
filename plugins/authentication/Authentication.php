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

require_once MAX_PATH . '/lib/max/Plugin/Translation.php';
require_once MAX_PATH . '/lib/max/Plugin/Common.php';

/**
 * Plugins_Authentication is an abstract class for Authentication plugins
 *
 * @package    OpenXPlugin
 * @subpackage Authentication
 * @author     Radek Maciaszek <radek.maciaszek@openx.org>
 */
class Plugins_Authentication extends MAX_Plugin_Common 
{
    /**
     * Array to keep a reference to signup errors (if any)
     *
     * @var array
     */
    var $aSignupErrors = array();

    var $aValidationErrors = array();

    /**
     * Checks if credentials are passed and whether the plugin should carry on the authentication
     *
     * @abstract
     *
     * @return boolean  True if credentials were passed, else false
     */
    function suppliedCredentials()
    {
        OA::debug('Cannot run abstract method');
        exit();
    }

    /**
     * Authenticate user
     *
     * @abstract
     *
     * @return DataObjects_Users  returns users dataobject on success authentication
     *                            or null if user wasn't succesfully authenticated
     */
    function &authenticateUser()
    {
        OA::debug('Cannot run abstract method');
        exit();
    }

    /**
     * A method to check a username and password
     *
     * @param string $username
     * @param string $password
     * @return mixed A DataObjects_Users instance, or false if no matching user was found
     */
    function checkPassword($username, $password)
    {
        OA::debug('Cannot run abstract method');
        exit();
    }

    /**
     * Cleans up the session and carry on any additional tasks required to logout the user
     *
     * @abstract
     *
     */
    function logout()
    {
        OA::debug('Cannot run abstract method');
        exit();
    }

    /**
     * A static method to display a login screen
     *
     * @abstract
     * @static
     *
     * @param string $sMessage
     * @param string $sessionID
     * @param bool $inlineLogin
     */
    function displayLogin($sMessage = '', $sessionID = 0, $inLineLogin = false)
    {
        OA::debug('Cannot run abstract method');
        exit();
    }

    /**
     * A method to perform DLL level validation
     *
     * @param OA_Dll_User $oUser
     * @param OA_Dll_UserInfo $oUserInfo
     * @return boolean
     */
    function dllValidation(&$oUser, &$oUserInfo)
    {
        if (!$oUser->checkStructureNotRequiredStringField($oUserInfo, 'username', 64)
            || !$oUser->checkStructureNotRequiredStringField($oUserInfo, 'password', 32)) {
            return false;
        }

        return true;
    }

    /**
     * A method to set the required template variables, if any
     *
     * @abstract
     *
     * @param OA_Admin_Template $oTpl
     */
    function setTemplateVariables(&$oTpl)
    {
        OA::debug('Cannot run abstract method');
        exit();
    }

    /**
     * Build user details array fields required by user access (edit) pages
     *
     * @param array $userData  Array containing users data (see users table)
     * @return array  Array formatted for use in template object as in user access pages
     */
    function getUserDetailsFields($userData)
    {
        OA::debug('Cannot run abstract method');
        exit();
    }

    function getMatchingUserId($email, $login)
    {
        OA::debug('Cannot run abstract method');
        exit();
    }

    /**
     * Validates user's email address
     *
     * @param string $email
     * @return array  Array containing error strings or empty
     *                array if no validation errors were found
     */
    function validateUsersEmail($email)
    {
        if (!$this->isValidaEmail($email)) {
            $this->addValidationError($GLOBALS['strInvalidEmail']);
        }
    }
    
    /**
     * Returns true if email address is valid else false
     *
     * @param string $email
     * @return boolean
     */
    function isValidaEmail($email)
    {
        return eregi("^[a-zA-Z0-9]+[_a-zA-Z0-9-]*(\.[_a-z0-9-]+)*@[a-z??????0-9]+"
                ."(-[a-z??????0-9]+)*(\.[a-z??????0-9-]+)*(\.[a-z]{2,4})$", $email);
    }

    /**
     * Method used in user access pages. Either creates new user if
     * necessary or update existing one.
     *
     * @param DB_DataObject_Users $doUsers  Users dataobject with any preset variables
     * @param string $login  User name
     * @param string $password  Password
     * @param string $contactName  Contact name
     * @param string $emailAddress  Email address
     * @param integer $accountId  a
     * @return integer  User ID or false on error
     */
    function saveUser(&$doUsers, $login, $password, $contactName,
        $emailAddress, $language, $accountId)
    {
        $doUsers->contact_name = $contactName;
        $doUsers->email_address = $emailAddress;
        $doUsers->language = $language;
        if ($doUsers->user_id) {
            $doUsers->update();
            return $doUsers->user_id;
        } else {
            $doUsers->default_account_id = $accountId;
            $doUsers->username = $login;
            $doUsers->password = md5($password);
            return $doUsers->insert();
        }
    }

    /**
     * Returns array of errors which happened during sigup
     *
     * @return array
     */
    function getSignupErrors()
    {
        return $this->aSignupErrors;
    }

    /**
     * Adds an error message to signup errors array
     *
     * @param string $errorMessage
     */
    function addSignupError($error)
    {
        if (PEAR::isError($error)) {
            $errorMessage = $error->getMessage();
        } else {
            $errorMessage = $error;
        }
        if (!in_array($errorMessage, $this->aSignupErrors)) {
            $this->aSignupErrors[] = $errorMessage;
        }
    }

    /**
     * Returns array of errors which happened during sigup
     *
     * @return array
     */
    function getValidationErrors()
    {
        return $this->aValidationErrors;
    }

    /**
     * Adds an error message to validation errors array
     *
     * @param string $aValidationErrors
     */
    function addValidationError($error)
    {
        $this->aValidationErrors[] = $error;
    }

    /**
     * A method to change a user password
     *
     * @param DataObjects_Users $doUsers
     * @param string $newPassword
     * @param string $oldPassword
     * @return mixed True on success, PEAR_Error otherwise
     */
    function changePassword(&$doUsers, $newPassword, $oldPassword)
    {
        OA::debug('Cannot run abstract method');
        exit();
    }

    /**
     * A method to set a new user password
     *
     * @param string $userId
     * @param string $newPassword
     * @return mixed True on success, PEAR_Error otherwise
     */
    function setNewPassword($userId, $newPassword)
    {
        $doUsers = OA_Dal::staticGetDO('users', $userId);
        if (!$doUsers) {
            return false;
        }
        $doUsers->password = md5($newPassword);
        return $doUsers->update();
    }

    /**
     * A method to change a user email
     *
     * @param DataObjects_Users $doUsers
     * @param string $emailAddress
     * @param string $password
     * @return bool
     */
    function changeEmail(&$doUsers, $emailAddress, $password)
    {
        OA::debug('Cannot run abstract method');
        exit();
    }
    
    /**
     * Delete unverified accounts. Used by cas
     *
     * @param OA_Maintenance $oMaintenance
     * @return boolean
     */
    function deleteUnverifiedUsers(&$oMaintenance)
    {
        return true;
    }
}

?>