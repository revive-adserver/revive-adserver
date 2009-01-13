<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
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
 * @package    OpenX
 * @author     Andriy Petlyovanyy <apetlyovanyy@lohika.com>
 *
 */

// Require the base class, BaseLogonService.
require_once MAX_PATH . '/www/api/v1/common/BaseServiceImpl.php';

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
    function LogonServiceImpl()
    {
        $this->BaseServiceImpl();
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

        $_COOKIE['sessionID'] = uniqid('phpads', 1);
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
