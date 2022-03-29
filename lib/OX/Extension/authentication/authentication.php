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

require_once MAX_PATH . '/lib/max/Plugin/Translation.php';
require_once LIB_PATH . '/Plugin/Component.php';
require_once 'Date.php';
require_once MAX_PATH . '/lib/max/language/Loader.php';
require_once MAX_PATH . '/lib/pear/HTML/QuickForm/Rule/Email.php';
require_once MAX_PATH . '/lib/OA/DB/AdvisoryLock.php';

Language_Loader::load('settings');

/**
 * Plugins_Authentication is a parent class for Authentication plugins
 *
 * @package    OpenXPlugin
 * @subpackage Authentication
 */
class Plugins_Authentication extends OX_Component
{
    /**
     * Array to keep a reference to signup errors (if any)
     *
     * @var array
     */
    public $aSignupErrors = [];

    public $aValidationErrors = [];

    /**
     * Checks if credentials are passed and whether the plugin should carry on the authentication
     *
     * @return boolean  True if credentials were passed, else false
     */
    public function suppliedCredentials()
    {
        return isset($_POST['username']) || isset($_POST['password']);
    }

    /**
     * Authenticate user
     *
     * @return DataObjects_Users  returns users dataobject on success authentication
     *                            or null if user wasn't succesfully authenticated
     */
    public function authenticateUser()
    {
        $aCredentials = $this->_getCredentials();
        if (PEAR::isError($aCredentials)) {
            OA_Auth::displayError($aCredentials);
        }


        return $this->checkPassword(
            $aCredentials['username'],
            $aCredentials['password']
        );
    }

    /**
     * A to get the login credential supplied as POST parameters
     *
     * Additional checks are also performed and error eventually returned
     *
     * @param bool $performCookieCheck
     * @return mixed Array on success, PEAR_Error otherwise
     */
    public function _getCredentials($performCookieCheck = true)
    {
        if (empty($_POST['username']) || empty($_POST['password'])) {
            return new PEAR_Error($GLOBALS['strEnterBoth']);
        }

        if ($performCookieCheck && !isset($_COOKIE['sessionID'])) {
            return new PEAR_Error($GLOBALS['strEnableCookies']);
        }

        if ($performCookieCheck && $_COOKIE['sessionID'] != $_POST['oa_cookiecheck']) {
            return new PEAR_Error($GLOBALS['strSessionIDNotMatch']);
        }

        return [
            'username' => MAX_commonGetPostValueUnslashed('username'),
            'password' => MAX_commonGetPostValueUnslashed('password')
        ];
    }

    /**
     * A method to check a username and password
     *
     * @return DataObjects_Users|false A DataObjects_Users instance, or false if authentication was unsuccessful
     */
    public function checkPassword(string $username, string $password, bool $allowMd5 = true)
    {
        // Introduce a random delay in case of failures, as recommended by:
        // https://www.owasp.org/index.php/Blocking_Brute_Force_Attacks
        //
        // The base delay is 1-5 seconds.
        $waitMs = mt_rand(1000, 5000);

        $oLock = OA_DB_AdvisoryLock::factory();

        // Username check is case insensitive
        $username = strtolower($username);

        // Try to acquire an excusive advisory lock for the username
        $lock = $oLock->get('auth.' . md5($username));

        if (!$lock) {
            // We couldn't acquire the lock immediately, which means that
            // another authentication process for the same username is underway.
            //
            // This might mean that the account is being targeted by a
            // multi-threaded brute force attack, so we try to discourage such
            // behaviour by increasing the delay time by 4x.
            //
            // However, if the actual user tries to log in while their account
            // is being attacked, we will allow them in, they'd just have to
            // be patient (max 20 seconds).
            usleep($waitMs * 4000);
        }

        /** @var DataObjects_Users $doUser */
        $doUser = OA_Dal::factoryDO('users');
        $doUser->username = $username ?: '';

        if ($doUser->find()) {
            $doUser->fetch();

            if ($this->performPasswordCheck($doUser, $password, $allowMd5)) {
                $oLock->release();

                return $doUser;
            }
        }

        if ($lock) {
            // The password was wrong, but no other login attempt was in place
            // so we apply just the base delay time.
            usleep($waitMs * 1000);
        }

        $oLock->release();

        return false;
    }

    /**
     * Cleans up the session and carry on any additional tasks required to logout the user
     *
     */
    public function logout()
    {
        phpAds_SessionDataDestroy();
        $dalAgency = OA_Dal::factoryDAL('agency');
        header("Location: " . $dalAgency->getLogoutUrl(OA_Permission::getAgencyId()));
        exit;
    }

    /**
     * A static method to display a login screen
     *
     * @static
     *
     * @param string $sMessage
     * @param string $sessionID
     * @param bool $inlineLogin
     */
    public function displayLogin($sMessage = '', $sessionID = 0, $inLineLogin = false)
    {
        $aConf = $GLOBALS['_MAX']['CONF'];

        @header('Cache-Control: max-age=0, no-cache, proxy-revalidate, must-revalidate');

        if (!$inLineLogin) {
            phpAds_PageHeader(phpAds_Login);
        }

        // Check environment settings
        $oSystemMgr = new OA_Environment_Manager();
        $aSysInfo = $oSystemMgr->checkSystem();

        foreach ($aSysInfo as $env => $vals) {
            $errDetails = '';
            if (is_array($vals['error']) && !empty($vals['error'])) {
                if ($env == 'PERMS') {
                    // Just note that some file/folders are unwritable and that more information can be found in the debug.log
                    OA_Admin_UI::queueMessage('Error: File permission errors detected.<br />These <em>may</em> impact the accurate delivery of your ads,<br />See the debug.log file for the list of unwritable files', 'global', 'error', 0);
                } else {
                    foreach ($vals['error'] as $key => $val) {
                        $errDetails .= '<li>' . htmlspecialchars($key) . ' &nbsp; => &nbsp; ' . htmlspecialchars($val) . '</li>';
                    }
                    phpAds_Die('Error:', $errDetails);
                }
            }
        }

        $oTpl = new OA_Admin_Template('login.html');

        $appName = !empty($aConf['ui']['applicationName']) ? $aConf['ui']['applicationName'] : PRODUCT_NAME;

        $oTpl->assign('uiEnabled', $aConf['ui']['enabled']);
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
    public function dllValidation(&$oUser, &$oUserInfo)
    {
        if (!isset($oUserInfo->userId)) {
            if (!$oUser->checkStructureRequiredStringField($oUserInfo, 'username', 64)) {
                return false;
            }
        }

        if (!isset($oUserInfo->password)) {
            return true;
        }

        if (!self::validatePassword($oUserInfo->password)) {
            $oUser->raiseError(OA_Dll_User::ERROR_PASSWORD_TOO_SHORT);

            return false;
        }

        // Save the hash of the password
        $oUserInfo->password = $this->getPasswordHash($oUserInfo->password);

        return true;
    }

    /**
     * A method to set the required template variables, if any
     *
     * @param OA_Admin_Template $oTpl
     */
    public function setTemplateVariables(&$oTpl)
    {
        if (preg_match('/-user-start\.html$/', $oTpl->templateName)) {
            $oTpl->assign('fields', [
               [
                   'fields' => [
                       [
                           'name' => 'login',
                           'label' => $GLOBALS['strUsernameToLink'],
                           'value' => '',
                           'id' => 'user-key'
                       ],
                   ]
               ],
            ]);
        }
    }

    /**
     * Build user details array fields required by user access (edit) pages
     *
     * @param array $userData  Array containing users data (see users table)
     * @return array  Array formatted for use in template object as in user access pages
     */
    public function getUserDetailsFields($userData)
    {
        $userExists = !empty($userData['user_id']);
        $userDetailsFields = [];
        $aLanguages = RV_Admin_Languages::getAvailableLanguages();

        $userDetailsFields[] = [
                'name' => 'login',
                'label' => $GLOBALS['strUsername'],
                'value' => $userData['username'],
                'freezed' => !empty($userData['user_id'])
            ];
        $userDetailsFields[] = [
                'name' => 'contact_name',
                'label' => $GLOBALS['strContactName'],
                'value' => $userData['contact_name'],
                'freezed' => $userExists
            ];
        $userDetailsFields[] = [
                'name' => 'email_address',
                'label' => $GLOBALS['strEMail'],
                'value' => $userData['email_address'],
                'freezed' => $userExists
            ];
        $userDetailsFields[] = [
                'type' => 'select',
                'name' => 'language',
                'label' => $GLOBALS['strLanguage'],
                'options' => $aLanguages,
                'value' => (!empty($userData['language'])) ? $userData['language'] : $GLOBALS['_MAX']['PREF']['language'],
                'disabled' => $userExists
            ];

        return $userDetailsFields;
    }

    public function getMatchingUserId($email, $login)
    {
        $doUsers = OA_Dal::factoryDO('users');
        return $doUsers->getUserIdByProperty('username', $login);
    }

    /**
     * Validates user's email address
     *
     * @param string $email
     * @return array  Array containing error strings or empty
     *                array if no validation errors were found
     */
    public function validateUsersEmail($email)
    {
        if (!$this->isValidEmail($email)) {
            $this->addValidationError($GLOBALS['strInvalidEmail']);
        }
    }

    /**
     * Returns true if email address is valid else false
     *
     * @param string $email
     * @return boolean
     */
    public function isValidEmail($email)
    {
        $rule = new HTML_QuickForm_Rule_Email();
        return $rule->validate($email);
    }

    public function saveUser(
        $userid,
        $login,
        $password,
        $contactName,
        $emailAddress,
        $language,
        $accountId
    ) {
        /** @var DataObjects_Users $doUsers */
        $doUsers = OA_Dal::factoryDO('users');
        $doUsers->loadByProperty('user_id', $userid);

        return $this->saveUserDo(
            $doUsers,
            $login,
            $password,
            $contactName,
            $emailAddress,
            $language,
            $accountId
        );
    }

    /**
     * Method used in user access pages. Either creates new user if
     * necessary or update existing one.
     *
     * @param DataObjects_Users $doUsers  Users dataobject with any preset variables
     * @param string $login  User name
     * @param string|null $password  Password
     * @param string $contactName  Contact name
     * @param string $emailAddress  Email address
     * @param integer $accountId  a
     * @return integer  User ID or false on error
     */
    public function saveUserDo(
        $doUsers,
        $login,
        $password,
        $contactName,
        $emailAddress,
        $language,
        $accountId
    ) {
        $doUsers->contact_name = $contactName;
        $doUsers->email_address = $emailAddress;
        $doUsers->language = $language;
        if ($doUsers->user_id) {
            $doUsers->update();
            return $doUsers->user_id;
        } else {
            $doUsers->default_account_id = $accountId;
            $doUsers->username = $login;
            $doUsers->password = null === $password ? '' : $this->getPasswordHash($password);
            return $doUsers->insert();
        }
    }

    /**
     * Returns array of errors which happened during sigup
     *
     * @return array
     */
    public function getSignupErrors()
    {
        return $this->aSignupErrors;
    }

    /**
     * Adds an error message to signup errors array
     *
     * @param string $errorMessage
     */
    public function addSignupError($error)
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
    public function getValidationErrors()
    {
        return $this->aValidationErrors;
    }

    /**
     * Adds an error message to validation errors array
     *
     * @param string $aValidationErrors
     */
    public function addValidationError($error)
    {
        $this->aValidationErrors[] = $error;
    }

    /**
     * A method to get a hash of a password.
     */
    public function getPasswordHash(string $password): string
    {
        return \RV\Manager\PasswordManager::getPasswordHash($password);
    }

    /**
     * A method to set a new user password
     *
     * @param string $userId
     * @param string $newPassword
     * @return mixed True on success, PEAR_Error otherwise
     */
    public function setNewPassword($userId, $newPassword)
    {
        $doUsers = OA_Dal::staticGetDO('users', $userId);
        if (!$doUsers) {
            return false;
        }
        $doUsers->password = $this->getPasswordHash($newPassword);
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
    public function changeEmail(&$doUsers, $emailAddress, $password)
    {
        $doUsers->email_address = $emailAddress;
        $doUsers->email_updated = gmdate(OA_DATETIME_FORMAT);
        return true;
    }

    // These were pulled straight from the internal class...
    /**
     * Validates user login - required for linking new users
     *
     * @param string $login
     */
    public function validateUsersLogin($login)
    {
        if (empty($login)) {
            $this->addValidationError($GLOBALS['strInvalidUsername']);
        } elseif (OA_Permission::userNameExists($login)) {
            $this->addValidationError($GLOBALS['strDuplicateClientName']);
        }
    }

    /**
     * Validates user password, also comparing
     *
     * @param string $password
     */
    public function validateUsersPassword($password, $passwordConfirm)
    {
        $aConf = $GLOBALS['_MAX']['CONF'];

        if ('' === $password) {
            $this->addValidationError($GLOBALS['strInvalidPassword']);

            return;
        }

        if (!empty($aConf['security']['passwordMinLength'])) {
            if (!self::validatePassword($password)) {
                $this->addValidationError($GLOBALS['strPasswordTooShort']);

                return;
            }
        }

        if ($password === $passwordConfirm) {
            return;
        }

        $this->addValidationError($GLOBALS['strNotSamePasswords']);
    }

    /**
     * Validates user data - required for linking new users
     *
     * @param string $login
     * @param string $password
     * @return array  Array containing error strings or empty
     *                array if no validation errors were found
     */
    public function validateUsersData($data)
    {
        if (empty($data['userid'])) {
            $this->validateUsersLogin($data['login']);
        }
        $this->validateUsersEmail($data['email_address']);

        if (!phpAds_SessionValidateToken($data['token'])) {
            $this->addValidationError('Invalid request token');
        }

        return $this->getValidationErrors();
    }

    private function performPasswordCheck(DataObjects_Users $doUser, string $password, bool $allowMd5): bool
    {
        $doUser->setUnsafePassword(!self::validatePassword($password));

        if ($allowMd5 && $doUser->password === md5($password)) {
            $doUser->setResetRequired();

            return true;
        }

        if (!\RV\Manager\PasswordManager::verifyPassword($password, $doUser->password)) {
            return false;
        }

        if (\RV\Manager\PasswordManager::needsRehash($doUser)) {
            \RV\Manager\PasswordManager::updateHash($doUser, $password);
        }

        return true;
    }

    private static function validatePassword(string $password): bool
    {
        $passwordMinLength = $GLOBALS['_MAX']['CONF']['security']['passwordMinLength'] ?? OA_Auth::DEFAULT_MIN_PASSWORD_LENGTH;

        return RV::strlen($password) >= $passwordMinLength;
    }
}


class Plugins_Authentication_Exception extends Exception
{
}
