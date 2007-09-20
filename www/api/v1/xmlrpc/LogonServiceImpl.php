<?php

/*
+---------------------------------------------------------------------------+
| Openads v${RELEASE_MAJOR_MINOR}                                           |
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
$Id:$
*/

/**
 * @package    Openads
 * @author     Andriy Petlyovanyy <apetlyovanyy@lohika.com>
 *
 * A file to description Logon Service Implementation class.
 *
 */

// Base class BaseLogonService
require_once MAX_PATH . '/www/api/v1/common/BaseServiceImpl.php';

class LogonServiceImpl extends BaseServiceImpl
{

    /**
     * Constructor LogonServiceImpl.
     *
     */
    function LogonServiceImpl()
    {
        $this->BaseServiceImpl();
    }

    /**
     * Login to system.
     *
     * @access private
     *
     * @param string $username
     * @param string $password
     * @return boolean
     */
    function _internalLogin($username, $password)
    {
        // Required files
        include_once MAX_PATH . '/lib/max/language/Default.php';
        // Load the required language files
        Language_Default::load();
        // ???
        if (!defined('MAX_SKIP_LOGIN')) {

            $md5digest = md5($password);

            MAX_Permission_Session::restartIfUsernameOrPasswordEmpty($md5digest, $username);

            MAX_Permission_Session::restartIfCookiesDisabled();

            if (phpAds_isAdmin($username, $md5digest)) {
                phpAds_SessionDataRegister(MAX_Permission_User::getAAdminData($username));

            } else {
                $doUser = MAX_Permission_User::findAndGetDoUser($username, $md5digest);
                if ($doUser) {
                    phpAds_SessionDataRegister($doUser->getAUserData());
                } else {
                    // Password is not correct or user is not known
                    // Set the session ID now, some server do not support setting a cookie during a redirect
                    return false;
                }
            }

        } else {
            phpAds_SessionDataRegister(array(
            "usertype" => phpAds_Agency,
            "loggedin" => 'f',
            "agencyid" => 0,
            "username" => 'fake-session'
            ));
        }
        return true;
    }

    /**
     * Login to system.
     *
     * @param string $username
     * @param string $password
     * @param string &$sessionId
     * @return boolean
     */
    function logon($username, $password, &$sessionId)
    {
        global $_POST, $_COOKIE;
        global $strUsernameOrPasswordWrong;

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

            // Check if user is OA installation admin.
            if (MAX_Permission::hasAccess(phpAds_Admin)) {

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
     * Logoff from system.
     *
     * @param string $sessionId
     * @return boolean
     */
    function logoff($sessionId)
    {
        if ($this->verifySession($sessionId)) {

            phpAds_SessionDataDestroy();
            unset($GLOBALS['session']);

            return !phpAds_IsLoggedIn();

        } else {

            return false;
        }
    }


    /**
     * Verify Username And Password Length.
     *
     * @access private
     *
     * @param string $username
     * @param string $password
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