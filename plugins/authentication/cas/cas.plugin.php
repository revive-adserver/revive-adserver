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
require_once MAX_PATH . '/plugins/authentication/cas/CAS/CAS.php';
require_once MAX_PATH . '/plugins/authentication/cas/CAS/client.php';
require_once MAX_PATH . '/plugins/authentication/cas/OaCasClient.php';
require_once MAX_PATH . '/www/admin/lib-sessions.inc.php';

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

    var $aErrorCodes = array(
        701 => 'User do not exists, please try again with different account',
        702 => 'Wrong password, please try again',
        703 => 'Such email already exists, please try again using different e-mail address',
        704 => 'Invalid verification hash, please recheck you confirmation mail',
        800 => 'Connection error, please send your data again',
        801 => 'User not authenticated, please correct your credentials',
        803 => 'Error in request to server - wrong parameters, please try to resend your data',
        804 => 'User name do not match platform hash',
        805 => 'Platform hash doesn\'t exist, please execute sync process',
        806 => 'Server error',
        807 => 'User not authorized',
        808 => 'XML-RPC version not supported',
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
    function authenticateUser()
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
            $this->displayRegistrationRequiredInfo($username);
        }
        return null;
    }

    /**
     * Returns user which matches id returned by cas client
     *
     * @return mixed A DataObjects_Users instance, or false if no matching user was found
     */
    function getUser()
    {
        return $this->getUserById(phpCAS::getUserId());
    }

    /**
     * Returns user by Id or null if no such user exists
     *
     * @param integer $userId
     * @return mixed A DataObjects_Users instance, or null if no matching user was found
     */
    function getUserById($userId)
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
    function displayRegistrationRequiredInfo($userName = '')
    {
        phpAds_PageHeader("1");
        $msg = MAX_Plugin_Translation::translate('strRegistrationRequiredInfo', $this->module, $this->package);
        $replacements = array(
            '{userName}'   => phpCAS::getUser(),
        );
        $msg = str_replace(array_keys($replacements), array_values($replacements), $msg);
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
        $this->authenticateUser();
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
            if (!$oUser->checkStructureRequiredStringField($oUserInfo, 'emailAddress', 64)) {
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

    /**
     * TODO - move templates related method to separate class
     *
     * @param unknown_type $userData
     * @return unknown
     */
    function getUserDetailsFields($userData)
    {
        $userExists = !empty($userData['user_id']);
        $userDetailsFields[] = array(
                       'name'      => 'email_address',
                       'label'     => $GLOBALS['strEMail'],
                       'value'     => $userData['email_address'],
                       'freezed'   => $userExists
                 );
        $userDetailsFields[] = array(
                     'name'      => 'contact_name',
                     'label'     => $GLOBALS['strContactName'],
                     'value'     => $userData['contact_name'],
                     'freezed'   => $userExists
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
    function validateUsersData($login, $password, $email)
    {
        return $this->validateUsersEmail($email);
    }

    function saveUser($login, $password, $contactName, $emailAddress, $accountId)
    {
        $this->getCentralCas();
        $ssoUserId = $this->getAccountId($emailAddress);
        if (PEAR::isError($ssoUserId)) {
            return false;
        }
        if (!$ssoUserId) {
            $superUserName = OA_Permission::getAccountName();
            $ssoUserId = $this->createPartialAccount($receipientEmailAddress, $superUserName, $contactName);
            if (PEAR::isError($ssoUserId)) {
                return false;
            }
        }

        $doUsers = OA_Dal::factoryDO('users');
        $doUsers->sso_user_id = $ssoUserId;
        return parent::saveUser($doUsers, $login, $password, $contactName, $contactName, $accountId);
    }

    function createPartialAccount($receipientEmailAddress, $superUserName, $contactName)
    {
        $aConf = $GLOBALS['_MAX']['CONF'];
        $emailFrom = $aConf['email']['fromName'] . '" <' . $aConf['email']['fromAddress'] . '>';
        $this->getCentralCas();

        $subject = $this->getEmailSubject($superUserName);
        $content = $this->getEmailBody($superUserName, $contactName);
        $ssoUserId = $this->oCentral->createPartialAccount($receipientEmailAddress, $emailFrom, $subject, $content);
        if (PEAR::isError($ssoUserId)) {
            $this->addSignupError($ssoUserId);
            return false;
        }
        return $ssoUserId;
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
        $ssoUserId = $this->oCentral->getAccountId($emailAddress);
        if (PEAR::isError($ssoUserId)) {
            $this->addSignupError($ssoUserId);
        }
        return $ssoUserId;
    }

    /**
     * Returns subject of activation email
     *
     * @param
     * @return string
     */
    function getEmailSubject($superUserName)
    {
        $subject = MAX_Plugin_Translation::translate('strEmailSsoConfirmationSubject', $this->module, $this->package);
        return str_replace('{superUserName}', $superUserName, $subject);
    }

    /**
     * Returns body of activation email
     *
     * @param $superUserName
     * @param $contactName
     * @return string
     */
    function getEmailBody($superUserName, $contactName)
    {
        $subject = MAX_Plugin_Translation::translate('strEmailSsoConfirmationBody', $this->module, $this->package);
        $replacements = array(
            '{contactName}'   => $contactName,
            '{superUserName}' => $superUserName,
        );
        return str_replace(array_keys($replacements), array_values($replacements), $subject);
    }

    /**
     * Adds an error message to signup errors array
     *
     * @param string|PEAR_Error $errorMessage
     */
    function addSignupError($error)
    {
        if (PEAR::isError($error) && isset($this->aErrorCodes[$error->getCode()])) {
            $msg = MAX_Plugin_Translation::translate(
                $this->aErrorCodes[$error->getCode()], $this->module, $this->package);
            parent::addSignupError($msg);
        } elseif(PEAR::isError($error)) {
            $errorMsg = $error->getMessage();
            if (empty($msg)) {
                $msg = MAX_Plugin_Translation::translate(
                    'Error while communicating with server, error code %d', $this->module, $this->package);
                $errorMsg = sprintf($msg, $error->getCode());
                parent::addSignupError($errorMsg);
            }
        } else {
            parent::addSignupError($error);
        }
    }
}

?>