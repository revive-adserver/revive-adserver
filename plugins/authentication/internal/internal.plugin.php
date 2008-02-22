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

require_once MAX_PATH . '/lib/max/other/common.php';
require_once MAX_PATH . '/plugins/authentication/Authentication.php';
require_once MAX_PATH . '/lib/max/Admin/Languages.php';

/**
 * Authentication internal plugin which authenticates user using internal
 * database method.
 *
 * @package    OpenXPlugin
 * @subpackage Authentication
 * @author     Radek Maciaszek <radek.maciaszek@openx.org>
 */
class Plugins_Authentication_Internal_Internal extends Plugins_Authentication
{
    /**
     * Checks if credentials are passed and whether the plugin should carry on the authentication
     *
     * @return boolean  True if credentials were passed, else false
     */
    function suppliedCredentials()
    {
        return isset($_POST['username']) || isset($_POST['password']);
    }

    /**
     * Authenticate user
     *
     * @return DataObjects_Users  returns users dataobject on success authentication
     *                            or null if user wasn't succesfully authenticated
     */
    function authenticateUser()
    {
        $aCredentials = $this->getCredentials();
        if (PEAR::isError($aCredentials)) {
            OA_Auth::displayError($aCredentials);
        }
        return $this->checkPassword($aCredentials['username'],
            $aCredentials['password']);
    }

    /**
     * A to get the login credential supplied as POST parameters
     *
     * Additional checks are also performed and error eventually returned
     *
     * @param bool $performCookieCheck
     * @return mixed Array on success, PEAR_Error otherwise
     */
    function getCredentials($performCookieCheck = true)
    {
        if (empty($_POST['username']) || empty($_POST['password'])) {
            return new PEAR_Error($GLOBALS['strEnterBoth']);
        }

        if ($performCookieCheck && $_COOKIE['sessionID'] != $_POST['oa_cookiecheck']) {
            return new PEAR_Error($GLOBALS['strEnableCookies']);
        }

        return array(
            'username' => MAX_commonGetPostValueUnslashed('username'),
            'password' => MAX_commonGetPostValueUnslashed('password')
        );
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
        $doUser = OA_Dal::factoryDO('users');
        $doUser->username = strtolower($username);
        $doUser->password = md5($password);
        $doUser->find();

        if ($doUser->fetch()) {
            return $doUser;
        }
        return null;
    }

    /**
     * Cleans up the session and carry on any additional tasks required to logout the user
     * Redirects to CAS-server logout url
     *
     */
    function logout()
    {
        phpAds_SessionDataDestroy();
        $dalAgency = OA_Dal::factoryDAL('agency');
        header ("Location: " . $dalAgency->getLogoutUrl(OA_Permission::getAgencyId()));
        exit;
    }

    /**
     * A method to display a login screen
     *
     * @param string $sMessage
     * @param string $sessionID
     * @param bool $inlineLogin
     */
    function displayLogin($sMessage = '', $sessionID = 0, $inLineLogin = false)
    {
        global $strUsername, $strPassword, $strLogin, $strWelcomeTo, $strEnterUsername,
               $strNoAdminInteface, $strForgotPassword;

        $aConf = $GLOBALS['_MAX']['CONF'];
        $aPref = $GLOBALS['_MAX']['PREF'];

        if (!$inLineLogin) {
            phpAds_PageHeader(phpAds_Login);
        }

        // Check environment settings
        $oSystemMgr = new OA_Environment_Manager();
        $aSysInfo = $oSystemMgr->checkSystem();

        foreach ($aSysInfo as $env => $vals) {
            $errDetails = '';
            if (is_array($vals['error'])) {
                $errDetails = '<ul>';
                foreach ($vals['actual'] as $key => $val) {
                    $errDetails .= '<li>' . $key . ' &nbsp; => &nbsp; ' . $val . '</li>';
                }
                $errDetails .= '</ul>';
                foreach ($vals['error'] as $key => $err) {
                    phpAds_Die( ' Error: ' . $err, $errDetails );
                }
            }
        }

        $oTpl = new OA_Admin_Template('login.html');

        $formAction = basename($_SERVER['PHP_SELF']);
        if (!empty($_SERVER['QUERY_STRING'])) {
            $formAction .= '?'.$_SERVER['QUERY_STRING'];
        }

        $appName = !empty($aPref['name']) ? $aPref['name'] : MAX_PRODUCT_NAME;

        $oTpl->assign('uiEnabled', $aConf['ui']['enabled']);
        $oTpl->assign('formAction', $formAction);
        $oTpl->assign('sessionID', $sessionID);
        $oTpl->assign('appName', $appName);
        $oTpl->assign('message', $sMessage);

        $oTpl->display();

        phpAds_PageFooter();
        exit;
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
        if (!isset($oUserInfo->userId)) {
            if (!$oUser->checkStructureRequiredStringField($oUserInfo, 'username', 64) ||
                !$oUser->checkStructureRequiredStringField($oUserInfo, 'password', 32)) {
                return false;
            }
        }

        if (isset($oUserInfo->password)) {
            // Save MD5 hash of the password
            $oUserInfo->password = md5($oUserInfo->password);
        }

        return parent::dllValidation($oUser, $oUserInfo);
    }

    /**
     * A method to set the required template variables, if any
     *
     * @param OA_Admin_Template $oTpl
     */
    function setTemplateVariables(&$oTpl)
    {
        if (preg_match('/-user-start\.html$/', $oTpl->templateName)) {
            $oTpl->assign('fields', array(
               array(
                   'fields'    => array(
                       array(
                           'name'      => 'login',
                           'label'     => $GLOBALS['strUsernameToLink'],
                           'value'     => '',
                           'id'        => 'user-key'
                       ),
                   )
               ),
            ));
        }
    }

    function getUserDetailsFields($userData)
    {
        $userExists = !empty($userData['user_id']);
        $userDetailsFields = array();
        $oLanguages = new MAX_Admin_Languages();
        $aLanguages = $oLanguages->AvailableLanguages();

        $userDetailsFields[] = array(
                'name'      => 'login',
                'label'     => $GLOBALS['strUsername'],
                'value'     => $userData['username'],
                'freezed'   => !empty($userData['user_id'])
            );
        $userDetailsFields[] = array(
                'name'      => 'passwd',
                'label'     => $GLOBALS['strPassword'],
                'type'      => 'password',
                'value'     => '',
                'hidden'   => !empty($userData['user_id'])
            );
        $userDetailsFields[] = array(
                'name'      => 'passwd2',
                'label'     => $GLOBALS['strPasswordRepaet'],
                'type'      => 'password',
                'value'     => '',
                'hidden'   => !empty($userData['user_id'])
            );
        $userDetailsFields[] = array(
                'name'      => 'contact_name',
                'label'     => $GLOBALS['strContactName'],
                'value'     => $userData['contact_name'],
                'freezed'   => $userExists
            );
        $userDetailsFields[] = array(
                'name'      => 'email_address',
                'label'     => $GLOBALS['strEMail'],
                'value'     => $userData['email_address'],
                'freezed'   => $userExists
            );
        $userDetailsFields[] = array(
                'type'      => 'select',
                'name'      => 'language',
                'label'     => $GLOBALS['strLanguage'],
                'options'   => $aLanguages,
                'value'     => (!empty($userData['language'])) ? $userData['language'] : $GLOBALS['_MAX']['PREF']['language'],
                'freezed'   => $userExists
            );

        return $userDetailsFields;
    }

    function getMatchingUserId($email, $login)
    {
        $doUsers = OA_Dal::factoryDO('users');
        return $doUsers->getUserIdByProperty('username', $login);
    }

    /**
     * Method used in user access pages. Either creates new user if necessary or update existing one.
     *
     * @param string $login  User name
     * @param string $password  Password
     * @param string $contactName  Contact name
     * @param string $emailAddress  Email address
     * @param integer $accountId  account Id
     * @return integer  User ID or false on error
     */
    function saveUser($userid, $login, $password,
        $contactName, $emailAddress, $language, $accountId)
    {
        $doUsers = OA_Dal::factoryDO('users');
        $doUsers->loadByProperty('user_id', $userid);
        return parent::saveUser($doUsers, $login, $password, $contactName, $emailAddress, $language, $accountId);
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
        $doUser->password = md5($newPassword);
        return true;
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
        $doUsers->email_address = $emailAddress;
        return true;
    }

    /**
     * Validates user login - required for linking new users
     *
     * @param string $login
     */
    function validateUsersLogin($login)
    {
        if (empty($login)) {
            $this->addValidationError($GLOBALS['strInvalidUsername']);
        } elseif (OA_Permission::userNameExists($login)) {
            $this->addValidationError($GLOBALS['strDuplicateClientName']);
        }
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
            $this->addValidationError($GLOBALS['strInvalidPassword']);
        }
    }

    function validateUsersPasswords($password1, $password2)
    {
        if ($password1 != $password2) {
            $this->addValidationError($GLOBALS['strNotSamePasswords']);
        }
    }

    /**
     * Validates user data - required for linking new users
     *
     * @param string $login
     * @param string $password
     * @return array  Array containing error strings or empty
     *                array if no validation errors were found
     */
    function validateUsersData($data)
    {
        if (empty($data['userid'])) {
            $this->validateUsersLogin($data['login']);
            $this->validateUsersPasswords($data['passwd'], $data['passwd2']);
            $this->validateUsersPassword($data['passwd']);
        }
        $this->validateUsersEmail($data['email_address']);

        return $this->getValidationErrors();
    }
}

?>
