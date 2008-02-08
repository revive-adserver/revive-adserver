<?php
/*
+---------------------------------------------------------------------------+
| Openads v${RELEASE_MAJOR_MINOR}                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
| For contact details, see: http://www.openads.org/                         |
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
 * Plugins_Authentication is an abstract class for Authentication plugins
 *
 * @package    OpenadsPlugin
 * @subpackage Authentication
 * @author     Radek Maciaszek <radek.maciaszek@openads.org>
 */
class Plugins_Authentication
{
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
    function authenticateUser()
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
     * Validates user data - required for linking new users
     *
     * @param string $login
     * @param string $password
     * @return array  Array containing error strings or empty
     *                array if no validation errors were found
     */
    function validateUsersData($login, $password, $email)
    {
        $aErrors = $this->validateUsersLogin($login);
        $aErrors = array_merge($aErrors, $this->validateUsersPassword($password));
        return array_merge($aErrors, $this->validateUsersEmail($email));
    }

    /**
     * Validates user login - required for linking new users
     *
     * @param string $login
     * @return array  Array containing error strings or empty
     *                array if no validation errors were found
     */
    function validateUsersLogin($login)
    {
        if (empty($login)) {
            return $GLOBALS['strInvalidUsername'];
        } elseif (OA_Permission::userNameExists($login)) {
            return $GLOBALS['strDuplicateClientName'];
        }
        return array();
    }

    /**
     * Validates user password - required for linking new users
     *
     * @param string $password
     * @return array  Array containing error strings or empty
     *                array if no validation errors were found
     */
    function validateUsersPassword($password)
    {
        if (!strlen($password) || strstr("\\", $password)) {
            return $GLOBALS['strInvalidPassword'];
        }
        return array();
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
        if (!eregi("^[a-zA-Z0-9]+[_a-zA-Z0-9-]*(\.[_a-z0-9-]+)*@[a-z??????0-9]+(-[a-z??????0-9]+)*(\.[a-z??????0-9-]+)*(\.[a-z]{2,4})$", $email)) {
            return $GLOBALS['strInvalidEmail'];
        }
        return array();
    }
    
    /**
     * Method used in user access pages. Either creates new user if necessary or update existing one.
     *
     * @param string $login  User name
     * @param string $password  Password
     * @param string $contactName  Contact name
     * @param string $emailAddress  Email address
     * @param integer $accountId  a
     * @return integer  User ID or false on error
     */
    function saveUser($login, $password, $contactName, $emailAddress, $accountId)
    {
        OA::debug('Cannot run abstract method');
        exit();
    }
}

?>