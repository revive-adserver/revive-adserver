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
require_once MAX_PATH . '/lib/OA/Central.php';
require_once MAX_PATH . '/plugins/authentication/Authentication.php';
require_once MAX_PATH . '/plugins/authentication/cas/CAS/CAS.php';
require_once MAX_PATH . '/plugins/authentication/cas/CAS/client.php';
require_once MAX_PATH . '/plugins/authentication/cas/OaCasClient.php';
require_once MAX_PATH . '/www/admin/lib-sessions.inc.php';
require_once MAX_PATH . '/lib/max/Admin/Languages.php';

/**
 * String which CAS client uses to store data in session
 *
 */
define('OA_CAS_PLUGIN_PHP_CAS', 'phpCAS');

/**
 * Authentication CAS plugin which authenticates users against cas-server
 *
 * This plugin uses information stored in "oacSSO" section in configuration file.
 * It is required to install php_curl extension in order to use this plugin.
 * Users are still added to local "users" table. The main difference between this and
 * internal plugin is that in "internal" plugin a username is taken from database
 * by matching username and password and in cas plugin the username is returned by cas client
 * library.
 *
 * @package    OpenXPlugin
 * @subpackage Authentication
 * @author     Radek Maciaszek <radek.maciaszek@openx.org>
 */
class Plugins_Authentication_Cas_Cas extends Plugins_Authentication
{
    /**
     * @var OA_Central_Cas
     */
    var $oCentral;

    var $defaultErrorUnkownMsg = 'Error while connecting with server (%s), please try to resend your data again.';
    var $defaultErrorUnknownCode = 'Error while communicating with server, error code %d';
    
    var $msgErrorUserAlreadyLinked = 'Server error: One of the users already is connected with this SSO User ID';

    var $aErrorCodes = array(
        OA_CENTRAL_ERROR_SSO_USER_NOT_EXISTS
            => 'User do not exists, please try again with different account',
        OA_CENTRAL_ERROR_SSO_INVALID_PASSWORD
            => 'Wrong password, please try again',
        OA_CENTRAL_ERROR_SSO_EMAIL_EXISTS
            => 'Such email already exists, please try again using different e-mail address',
        OA_CENTRAL_ERROR_SSO_INVALID_VER_HASH
            => 'Invalid verification hash, please recheck you confirmation mail',
        OA_CENTRAL_ERROR_XML_RPC_CONNECTION_ERROR
            => 'Connection error, please send your data again',
        OA_CENTRAL_ERROR_ERROR_NOT_AUTHENTICATED
            => 'User not authenticated, please correct your credentials',
        OA_CENTRAL_ERROR_WRONG_PARAMETERS
            => 'Error in request to server - wrong parameters, please try to resend your data',
        OA_CENTRAL_ERROR_USERNAME_DOES_NOT_MATCH_PLATFORM
            => 'User name do not match platform hash',
        OA_CENTRAL_ERROR_PLATFORM_DOES_NOT_EXIST
            => 'Platform hash doesn\'t exist, please execute sync process',
        OA_CENTRAL_ERROR_SERVER_ERROR
            => 'Server error',
        OA_CENTRAL_ERROR_ERROR_NOT_AUTHORIZED
            => 'User not authorized',
        OA_CENTRAL_ERROR_XML_RPC_VERSION_NOT_SUPPORTED
            => 'XML-RPC version not supported',
        OA_CENTRAL_ERROR_M2M_PASSWORD_INVALID
            => 'M2M authentication error - invalid password',
    );

    /**
     * Checks if credentials are passed and whether the plugin should carry on the authentication
     *
     * @return boolean  True if credentials were passed, else false
     */
    function suppliedCredentials()
    {
        return isset($_GET['ticket']);
    }

    /**
     * Initialize CAS client. Only one copy of CAS client is allowed
     *
     */
    function initCasClient()
    {
        static $initialized;
        $aOpenSsoConfig = $GLOBALS['_MAX']['CONF']['oacSSO'];
        if (is_null($initialized)) {
            $this->casClientInitialization(CAS_VERSION_2_0,
                $aOpenSsoConfig['host'],
                intval($aOpenSsoConfig['port']),
                $aOpenSsoConfig['clientPath']
            );
            $initialized = true;
        }
    }

    function storePhpCasSession()
    {
        $sessionPhpCas = isset($_SESSION[OA_CAS_PLUGIN_PHP_CAS])
            ? $_SESSION[OA_CAS_PLUGIN_PHP_CAS] : null;
        global $session;
        $session[OA_CAS_PLUGIN_PHP_CAS] = $sessionPhpCas;
        phpAds_SessionDataStore();
    }

    function restorePhpCasSession()
    {
        global $session;
        $_SESSION[OA_CAS_PLUGIN_PHP_CAS] =
            isset($session[OA_CAS_PLUGIN_PHP_CAS]) ? $session[OA_CAS_PLUGIN_PHP_CAS] : null;
    }

    /**
     * Authenticate user. If user not connected to any account displays information
     * that he needs first to register in OAH.
     *
     * @return DataObjects_Users  returns users dataobject on success authentication
     *                            or null if user wasn't succesfully authenticated
     */
    function &authenticateUser()
    {
        $this->restorePhpCasSession();

        $this->initCasClient();
        $auth = phpCAS::forceAuthentication();
        $this->storePhpCasSession();

        if ($auth) {
            $doUser = $this->getUser();
            if ($doUser) {
                return $doUser;
            }
            $this->displayRegistrationRequiredInfo();
        }
        return null;
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
        // Preload the Central object
        $this->getCentralCas();
        $result = $this->oCentral->checkUsernameMd5Password($username, md5($password));
        if (PEAR::isError($result)) {
            return false;
        }
        return (bool) $result;
    }

    /**
     * Returns user which matches id returned by cas client
     *
     * @return mixed A DataObjects_Users instance, or false if no matching user was found
     */
    function getUser()
    {
        $doUsers = &$this->getUserBySsoUserId(phpCAS::getUserId());
        if ($doUsers) {
            if (empty($doUsers->username)) {
                $doUsers->username = phpCAS::getUser();
            }
            $doUsers->email_address = phpCAS::getUserEmail();
        }
        return $doUsers;
    }

    /**
     * Returns user by Id or null if no such user exists
     *
     * @param integer $userId  Sso account id
     * @return mixed A DataObjects_Users instance, or null if no matching user was found
     */
    function &getUserBySsoUserId($userId)
    {
        $doUser = OA_Dal::factoryDO('users');
        $doUser->sso_user_id = $userId;
        $doUser->find();
        if ($doUser->fetch()) {
            return $doUser;
        }
        return null;
    }

    function logout()
	{
	    $this->restorePhpCasSession();
	    // unset phpCas session
	    if (isset($_SESSION[OA_CAS_PLUGIN_PHP_CAS])) {
	       unset($_SESSION[OA_CAS_PLUGIN_PHP_CAS]);
	    }
	    phpAds_SessionDataDestroy();
	    // logout from CAS
        $dalAgency = OA_Dal::factoryDAL('agency');
        $this->initCasClient();
        phpCAS::logout($dalAgency->getLogoutUrl(OA_Permission::getAgencyId()));
        exit;
	}

    /**
     * A method to display a registration invitation for a user who
     * logged in to OAH but is not linked to any account
     *
     * @param string $userName
     */
    function displayRegistrationRequiredInfo()
    {
        phpAds_PageHeader("1");
        $msg = MAX_Plugin_Translation::translate('strRegistrationRequiredInfo', $this->module, $this->package);
        $replacements = array(
            '{userName}'   => phpCAS::getUser(),
        );
        $msg = str_replace(array_keys($replacements), array_values($replacements), $msg);
        echo $msg;
        phpAds_PageFooter();
        exit();
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
        if (isset($GLOBALS['session'][OA_CAS_PLUGIN_PHP_CAS])) {
            unset($GLOBALS['session'][OA_CAS_PLUGIN_PHP_CAS]);
        }
        if (isset($_SESSION['phpCAS'])) {
            unset($_SESSION['phpCAS']);
        }
        $result = $this->authenticateUser();
        if ($result) {
            phpAds_SessionDataRegister(OA_Auth::getSessionData($result));
            phpAds_SessionDataStore();

            return;
        }
        exit;
    }

  /**
   * phpCAS client initializer (slightly modified version of method from phpCas::client),
   * returns OaCasClient object instead of CasClient
   *
   * @note Only one of the phpCAS::client() and phpCAS::proxy functions should be
   * called, only once, and before all other methods (except phpCAS::getVersion()
   * and phpCAS::setDebug()).
   *
   * @param $server_version the version of the CAS server
   * @param $server_hostname the hostname of the CAS server
   * @param $server_port the port the CAS server is running on
   * @param $server_uri the URI the CAS server is responding on
   * @param $start_session Have phpCAS start PHP sessions (default true)
   *
   * @return a newly created OaCasClient object
   */
  function casClientInitialization($server_version,
          $server_hostname,
          $server_port,
          $server_uri,
          $start_session = true)
  {
      global $PHPCAS_CLIENT, $PHPCAS_INIT_CALL;

      phpCAS::traceBegin();
      if ( is_object($PHPCAS_CLIENT) ) {
    phpCAS::error($PHPCAS_INIT_CALL['method'].'() has already been called '.
          '(at '.$PHPCAS_INIT_CALL['file'].':'.$PHPCAS_INIT_CALL['line'].')');
      }
      if ( gettype($server_version) != 'string' ) {
            phpCAS::error('type mismatched for parameter $server_version (should be `string\')');
      }
      if ( gettype($server_hostname) != 'string' ) {
          phpCAS::error('type mismatched for parameter $server_hostname (should be `string\')');
      }
      if ( gettype($server_port) != 'integer' ) {
          phpCAS::error('type mismatched for parameter $server_port (should be `integer\')');
      }
      if ( gettype($server_uri) != 'string' ) {
          phpCAS::error('type mismatched for parameter $server_uri (should be `string\')');
      }

      // store where the initialzer is called from
      $dbg = phpCAS::backtrace();
      $PHPCAS_INIT_CALL = array('done' => TRUE,
                'file' => $dbg[0]['file'],
                'line' => $dbg[0]['line'],
                'method' => __CLASS__.'::'.__FUNCTION__);

      // initialize the global object $PHPCAS_CLIENT
      $PHPCAS_CLIENT = new OaCasClient($server_version,FALSE/*proxy*/,
          $server_hostname,$server_port,$server_uri,$start_session);
      phpCAS::traceEnd();
    }

    /**
     * A method to get a reference to the XML-RPC client
     *
     * @return OA_Central_Cas
     */
    function &getCentralCas()
    {
        if (empty($this->oCentral)) {
            require_once MAX_PATH . '/plugins/authentication/cas/Central/Cas.php';
            $this->oCentral = &new OA_Central_Cas();
        }

        return $this->oCentral;
    }

    /**
     * A method to perform DLL level validation
     *
     * @todo Check user existence on SSO and get the username
     * @todo Errors strings localisation
     *
     * @param OA_Dll_User $oUser
     * @param OA_Dll_UserInfo $oUserInfo
     * @return boolean
     */
    function dllValidation(&$oUser, &$oUserInfo)
    {
        if (isset($oUserInfo->username) || isset($oUserInfo->password)) {
            $oUser->raiseError('Username and password cannot be set when using the SSO authentication plugin');
            return false;
        }

        if (!isset($oUserInfo->userId)) {
            if (!$oUser->checkStructureRequiredStringField($oUserInfo,
                    'emailAddress', 64)) {
                return false;
            }

            // Get username from SSO and store it
            $oUserInfo->username = 'user-'.md5(uniqid('', true));
        }

        return parent::dllValidation($oUser, $oUserInfo);
    }

    /**
     * A method to set the required template variables, if any
     *
     * TODO - move templates related method to separate class
     *
     * @param OA_Admin_Template $oTpl
     */
    function setTemplateVariables(&$oTpl)
    {
        if (preg_match('/-user-start\.html$/', $oTpl->templateName)) {
            $oTpl->assign('sso', true);
            $oTpl->assign('returnEmail', true);
            $oTpl->assign('fields', array(
               array(
                   'fields'    => array(
                       array(
                           'name'      => 'email_address',
                           'label'     => $GLOBALS['strEmailToLink'],
                           'value'     => '',
                           'id'        => 'user-key'
                       )
                   )
               )
            ));
        }
    }

    function isEmailHidded($userExists, $userData, $link)
    {
        $valid = true;
        if (!empty($userData['email_address'])) {
            $valid = $this->isValidEmail($userData['email_address']);
        }
        return $userExists || ($valid && $link);
    }
    
    /**
     * Build an array required by template
     *
     * @param unknown_type $userData
     * @return unknown
     */
    function getUserDetailsFields($userData, $link)
    {
        $userExists = !empty($userData['user_id']);
        $oLanguages = new MAX_Admin_Languages();
        $aLanguages = $oLanguages->AvailableLanguages();
        $hideEmail = $this->isEmailHidded($userExists, $userData, $link);

        $userDetailsFields[] = array(
                       'name'      => 'email_address',
                       'label'     => $GLOBALS['strEMail'],
                       'value'     => $userData['email_address'],
                       'freezed'   => $hideEmail
                 );
        $userDetailsFields[] = array(
                     'name'      => 'contact_name',
                     'label'     => $GLOBALS['strContactName'],
                     'value'     => $userData['contact_name'],
                     'freezed'   => $userExists
                 );
         $userDetailsFields[] = array(
                    'type'      => 'select',
                    'name'      => 'language',
                    'label'     => $GLOBALS['strLanguage'],
                    'options'   => $aLanguages,
                    'value'     => (!empty($userData['language'])) ? $userData['language'] : $GLOBALS['_MAX']['PREF']['language'],
                    'disabled'   => $userExists
                );

        return $userDetailsFields;
    }

    function getMatchingUserId($email, $login)
    {
        $doUsers = OA_Dal::factoryDO('users');
        return $doUsers->getUserIdByProperty('email_address', $email);
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
        $this->validateUsersEmail($data['email_address']);
        return $this->getValidationErrors();
    }

    function saveUser($userid, $login, $password,
        $contactName, $emailAddress, $language, $accountId)
    {
        if (!empty($userid)) {
            $doUsers = OA_Dal::factoryDO('users');
            if ($doUsers->loadByProperty('user_id', $userid)) {
                return parent::saveUser($doUsers, null, null, $contactName,
                    $emailAddress, $language, $accountId);
            }
            return false;
        } else {
            return $this->createUser($contactName, $emailAddress, $accountId);
        }
    }

    function createUser($contactName, $emailAddress, $accountId)
    {
        $this->getCentralCas();
        $ssoUserId = $this->getAccountId($emailAddress);
        if (PEAR::isError($ssoUserId)) {
            $this->addSignupError($ssoUserId);
            return false;
        }
        if (!$ssoUserId) {
            $superUserName = OA_Permission::getAccountName();
            $ssoUserId = $this->createPartialAccount($emailAddress,
                $superUserName, $contactName);
            if (PEAR::isError($ssoUserId)) {
                $this->addSignupError($ssoUserId);
                return false;
            }
        }

        $doUsers = OA_Dal::factoryDO('users');
        if ($doUsers->loadByProperty('sso_user_id', $ssoUserId)) {
            $this->addSignupError($this->msgErrorUserAlreadyLinked);
            return false;
        }
        
        $doUsers = OA_Dal::factoryDO('users');
        $doUsers->loadByProperty('email_address', $emailAddress);
        $doUsers->sso_user_id = $ssoUserId;
        return parent::saveUser($doUsers, null, null, $contactName,
            $emailAddress, $accountId);
    }
    
    function createPartialAccount($receipientEmail, $superUserName, $contactName)
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        $emailFrom = $aConf['email']['fromName'] . ' <' .
            $aConf['email']['fromAddress'] . '>';
        $this->getCentralCas();

        $subject = $this->getEmailSubject($superUserName);
        $content = $this->getEmailBody($superUserName, $contactName,
            $receipientEmail);
        $ret = $this->oCentral->createPartialAccount($receipientEmail,
            $emailFrom, $subject, $content);
        if (PEAR::isError($ret)) {
            $this->addSignupError($ret);
        }
        return $ret;
    }

    /**
     * Returns SSO user Id with matching email address
     *
     * @param string $emailAddress
     * @return integer|PEAR_Error Sso user Id if there is a matching user or null if user do not exist
     */
    function getAccountId($emailAddress)
    {
        $this->getCentralCas();
        $ret = $this->oCentral->getAccountId($emailAddress);
        if (PEAR::isError($ret)) {
            if ($ret->getCode() == OA_CENTRAL_ERROR_SSO_USER_NOT_EXISTS) {
                return null;
            }
            $this->addSignupError($ret);
        }
        return $ret;
    }

    /**
     * Returns subject of activation email
     *
     * @param
     * @return string
     */
    function getEmailSubject($superUserName)
    {
        $subject = MAX_Plugin_Translation::translate('strEmailSsoConfirmationSubject',
            $this->module, $this->package);
        return str_replace('{superUserName}', $superUserName, $subject);
    }

    /**
     * Returns body of activation email
     *
     * @param $superUserName
     * @param $contactName
     * @param $receipientEmail
     * @return string
     */
    function getEmailBody($superUserName, $contactName, $receipientEmail)
    {
        $subject = MAX_Plugin_Translation::translate('strEmailSsoConfirmationBody',
            $this->module, $this->package);
        $url = MAX::constructURL(MAX_URL_ADMIN, 'sso-accounts.php');
        $replacements = array(
            '{contactName}'   => $contactName,
            '{superUserName}' => $superUserName,
            '{url}' => $url . '?email='.$receipientEmail.'&vh=${verificationHash}',
        );

        return str_replace(array_keys($replacements),
            array_values($replacements), $subject);
    }

    /**
     * Adds an error message to signup errors array
     *
     * @param string|PEAR_Error $error
     */
    function addSignupError($error)
    {
        if (PEAR::isError($error) && isset($this->aErrorCodes[$error->getCode()])) {
            $msg = MAX_Plugin_Translation::translate(
                $this->aErrorCodes[$error->getCode()], $this->module, $this->package);
            parent::addSignupError($msg);
        } elseif(PEAR::isError($error)) {
            $errorMsg = $error->getMessage();
            if (empty($errorMsg)) {
                $msg = MAX_Plugin_Translation::translate(
                    $this->defaultErrorUnknownCode, $this->module, $this->package);
                $errorMsg = sprintf($msg, $error->getCode());
            }
            $errorMsg = sprintf($this->defaultErrorUnkownMsg, $errorMsg);
            parent::addSignupError($errorMsg);
        } else {
            parent::addSignupError($error);
        }
    }

    /**
     * A method to change a user password
     *
     * @param DataObjects_Users $doUsers
     * @param string $newPassword
     * @param string $oldPassword
     * @return bool
     */
    function changePassword(&$doUsers, $newPassword, $oldPassword)
    {
        $this->getCentralCas();

        $doUsers = OA_Dal::staticGetDO('users', $doUsers->user_id);
        $result = $this->oCentral->changePassword($doUsers->sso_user_id, md5($newPassword), md5($oldPassword));
        if (PEAR::isError($result)) {
            $errorCode = $result->getCode();
            if (isset($this->aErrorCodes[$errorCode])) {
                return new PEAR_Error($this->aErrorCodes[$errorCode], $errorCode);
            } else {
                return $result;
            }
        }
        unset($doUser->password);
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
        $this->getCentralCas();

        $doUsers = OA_Dal::staticGetDO('users', $doUsers->user_id);
        $result = $this->oCentral->changeEmail($doUsers->sso_user_id, $emailAddress, md5($password));
        if (PEAR::isError($result)) {
            $errorCode = $result->getCode();
            if (isset($this->aErrorCodes[$errorCode])) {
                return new PEAR_Error($this->aErrorCodes[$errorCode], $errorCode);
            } else {
                return $result;
            }
        }

        $doUsers->email_address = $emailAddress;
        return true;
    }
    
    /**
     * Sets a new password on a user
     *
     * @param integer $userId
     * @param string $newPassword
     * @return boolean
     */
    function setNewPassword($userId, $newPassword)
    {
        $this->getCentralCas();
        $doUsers = OA_Dal::staticGetDO('users', $userId);
        if (!$doUsers) {
            return false;
        }
        $result = $this->oCentral->setPassword($doUsers->sso_user_id,
            md5($newPassword));
        if (PEAR::isError($result)) {
            $errorCode = $result->getCode();
            if (isset($this->aErrorCodes[$errorCode])) {
                return new PEAR_Error($this->aErrorCodes[$errorCode], $errorCode);
            } else {
                return $result;
            }
        }
        if (!empty($doUsers->password)) {
            // update the password only if it was stored before
            return parent::setNewPassword($userId, $newPassword);
        }
        return true;
    }
    
    /**
     * Delete unverified accounts. By default deletes accounts
     * which are older than 28 days, noone ever logged into
     * and are not connected to any sso user id
     * (their sso_user_id is null)
     *
     * @param OA_Maintenance $oMaintenance
     * @return boolean  True on success, otherwise false
     */
    function deleteUnverifiedUsers(&$oMaintenance)
    {
        $processName = 'delete unverified accounts';
        $oMaintenance->_startProcessDebugMessage($processName);
            
        $doUsers = OA_Dal::factoryDO('users');
        $result = $doUsers->deleteUnverifiedUsers();
        
        $oMaintenance->_debugIfError($processName, $result);
        $oMaintenance->_stopProcessDebugMessage($processName);
        
        return PEAR::isError($result) ? false : true;
    }
}

?>
