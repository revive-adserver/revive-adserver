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
 */

// Require the base class, BaseLogonService.
require_once MAX_PATH . '/www/api/v2/common/BaseServiceImpl.php';

/**
 * The LogonServiceImpl class extends the BaseServiceImp class.
 *
 */
class LogonServiceImpl extends BaseServiceImpl
{

    /**
     * The LogonServiceImpl constructor calls the base constructor for the class.
     *
     */
    function __construct()
    {
        parent::__construct();
    }

    /**
     * Login to OpenX without using the login form in the user interface and
     * receive a session ID.
     *
     * @access private
     *
     * @param string $username
     * @param string $password
     *
     * @return boolean
     */
    function _internalLogin($username, $password)
    {
        // Require the default language file.
        include_once MAX_PATH . '/lib/max/language/Loader.php';
        // Load the required language file.
        Language_Loader::load('default');

        $oPlugin = OA_Auth::staticGetAuthPlugin();

        $doUser = $oPlugin->checkPassword($username, $password);
        if ($doUser) {
            phpAds_SessionDataRegister(OA_Auth::getSessionData($doUser));
            return true;
        } else {
            return false;
        }
    }

    /**
     * Login to the system with the session ID.
     *
     * @access public
     *
     * @param string $username
     * @param string $password
     * @param string &$sessionId
     *
     * @return boolean
     */
    function logon($username, $password, &$sessionId)
    {
        global $_POST, $_COOKIE;
        global $strUsernameOrPasswordWrong;

        /**
         * @todo Please check if the following statement is in correct place because
         * it seems illogical that user can get session ID from internal login with
         * a bad username or password.
         */

        if (!$this->_verifyUsernameAndPasswordLength($username, $password)) {
            return false;
        }

        $_POST['username'] = $username;
        $_POST['password'] = $password;

        $_POST['login'] = 'Login';

        unset($_COOKIE['sessionID']);
        phpAds_SessionStart();
        $_POST['phpAds_cookiecheck'] = $_COOKIE['sessionID'];

        $this->preInitSession();
        if ($this->_internalLogin($username, $password)) {
            // Check if the user has administrator access to Openads.
            if (OA_Permission::isUserLinkedToAdmin()) {

                $this->postInitSession();

                $sessionId = $_COOKIE['sessionID'];
                return true;
            } else {

                $this->raiseError('User must be OA installation admin');
                return false;
            }
        } else {

            $this->raiseError($strUsernameOrPasswordWrong);
            return false;
        }
    }

    /**
     * Logoff from the session.
     *
     * @access public
     *
     * @param string $sessionId
     *
     * @return boolean
     */
    function logoff($sessionId)
    {
        if ($this->verifySession($sessionId)) {

            phpAds_SessionDataDestroy();
            unset($GLOBALS['session']);

            return !OA_Auth::isLoggedIn();

        } else {

            return false;
        }
    }


    /**
     * The _verifyUsernameAndPasswordLength method checks the length of the username
     * and password and returns an error message if either of them exceeds the limit of
     * 64 characters.
     *
     * @access private
     *
     * @param string $username
     * @param string $password
     *
     * @return boolean
     */
    function _verifyUsernameAndPasswordLength($username, $password)
    {
        if (strlen($username) > 64) {

            $this->raiseError('UserName greater 64 characters');
            return false;

        } elseif (strlen($password) > 64) {

            $this->raiseError('Password greater 64 characters');
            return false;

        } else {

            return true;
        }
    }

}


?>
