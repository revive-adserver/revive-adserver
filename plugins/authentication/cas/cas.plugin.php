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
 * @package    OpenadsPlugin
 * @subpackage Authentication
 * @author     Radek Maciaszek <radek@openads.org>
 */
class Plugins_Authentication_Cas_Cas extends Plugins_Authentication
{
    /**
     * @var OA_Central_Cas
     */
    var $oCentral;

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
            $this->clientInitialization(CAS_VERSION_2_0,
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
     * A method to display a login screen
     *
     * @TODO - localize these messages once product team will deliver messages which needs
     * to be translated.
     *
     * @param string $sMessage
     * @param string $sessionID
     * @param bool $inlineLogin
     */
    function displayRegistrationRequiredInfo($userName = '')
    {
        phpAds_PageHeader("1");
        echo "<br><br>";
        echo 'Welcome <b>'.phpCAS::getUser().'</b><br/><hr />';
        echo "<br /><br />You do not currently have an account on the hosted version of Openads.<br /> ";
        echo "If you want to create one please sign up <a href='http://www.openads.org/hosted'>here</a>.<br /><br />";
        echo "To login as a different user click <a href='logout.php'>here</a>.<br />";
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
  function clientInitialization($server_version,
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
}

?>