<?php

/*
+---------------------------------------------------------------------------+
| Openads v${RELEASE_MAJOR_MINOR}                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2008 m3 Media Services Ltd                             |
| For contact details, see: http://www.openx.org/                           |
|                                                                           |
| Copyright (c) 2000-2003 the phpAdsNew developers                          |
| For contact details, see: http://www.phpadsnew.com/                       |
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


require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/lib/OA/Permission.php';
require_once MAX_PATH . '/lib/OA/Permission/User.php';
require_once MAX_PATH . '/lib/OA/Admin/Template.php';

/**
 * A class to deal with user authentication
 *
 */
class OA_Auth
{
    /**
     * A method to log in the user
     *
     * @static
     *
     * @param callback $redirectCallback
     * @return mixed Array on success
     */
    function login($redirectCallback = null)
    {
        $aConf = $GLOBALS['_MAX']['CONF'];

        if (!is_callable($redirectCallback)) {
            // Set the default callback
            $redirectCallback = array('OA_Auth', 'checkRedirect');
        }

        if (call_user_func($redirectCallback)) {
            header('location: http://'.$aConf['webpath']['admin']);
            exit();
        }

        if (defined('OA_SKIP_LOGIN')) {
            return OA_Auth::getFakeSessionData();
        }

        if (OA_Auth::suppliedCredentials()) {
            $aCredentials = OA_Auth::getCredentials();

            if (PEAR::isError($aCredentials)) {
                OA_Auth::displayError($aCredentials);
            }

            $doUser = OA_Auth::checkPassword($aCredentials['username'], $aCredentials['password']);

            if (!$doUser) {
                OA_Auth::restart($GLOBALS['strUsernameOrPasswordWrong']);
            }

            return OA_Auth::getSessionData($doUser);
        }

        OA_Auth::restart();
    }

    /**
     * A method to logout and redirect to the correct URL
     *
     * @static
     *
     * @todo Fix when preferences are ready and logout url is stored into the
     * preferences table
     */
    function logout()
    {
        phpAds_SessionDataDestroy();
        $dalAgency = OA_Dal::factoryDAL('agency');
        header ("Location: " . $dalAgency->getLogoutUrl($GLOBALS['agencyid']));
        exit;
    }

    /**
     * A method to check if the login credential were supplied as POST parameters
     *
     * @static
     *
     * @return bool
     */
    function suppliedCredentials()
    {
        return isset($_POST['username']) || isset($_POST['password']);
    }

    /**
     * A method to test if the user is logged in
     *
     * @return boolean
     */
    function isLoggedIn()
    {
        return is_a(OA_Permission::getCurrentUser(), 'OA_Permission_User');
    }

    /**
     * A method to get the login credential supplied as POST parameters
     *
     * Additional checks are also performed and error eventually returned
     *
     * @static
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
     * A static method to return the data to be stored in the session variable
     *
     * @static
     *
     * @param DataObjects_Users $doUser
     * @param bool $skipDatabaseAccess True if the OA_Permission_User constructor should
     *                                 avoid performing some checks accessing the database
     * @return array
     */
    function getSessionData($doUser, $skipDatabaseAccess = false)
    {
        return array(
            'user' => new OA_Permission_User($doUser, $skipDatabaseAccess)
        );
    }

    /**
     * A static method to return fake data to be stored in the session variable
     *
     * @static
     *
     * @return array
     */
    function getFakeSessionData()
    {
        return array(
            'user' => false
        );
    }

    /**
     * A static method to check a username and password
     *
     * @static
     *
     * @param string $username
     * @param string $md5Password
     * @return mixed A DataObjects_Users instance, or false if no matching user was found
     */
    function checkPassword($username, $password)
    {
        $doUser = OA_Dal::factoryDO('users');
        $doUser->whereAdd('LOWER(username) = '.DBC::makeLiteral(strtolower($username)));
        $doUser->whereAdd('password = '.DBC::makeLiteral(md5($password)));
        $doUser->find();

        if ($doUser->fetch()) {
            return $doUser;
        }
        return false;
    }

    /**
     * A static method to restart with a login screen, eventually displaying a custom message
     *
     * @static
     *
     * @param string $sMessage Optional message
     */
    function restart($sMessage = '')
    {
        $_COOKIE['sessionID'] = phpAds_SessionStart();
        OA_Auth::displayLogin($sMessage, $_COOKIE['sessionID']);
    }

    /**
     * A static method to restart with a login screen, displaying an error message
     *
     * @static
     *
     * @param PEAR_Error $oError
     */
    function displayError($oError)
    {
        OA_Auth::restart($oError->getMessage());
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
    function displayLogin($sMessage = '', $sessionID = 0, $inLineLogin = false)
    {
        global $strUsername, $strPassword, $strLogin, $strWelcomeTo, $strEnterUsername, $strNoAdminInteface, $strForgotPassword;

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
     * Check if application is running from appropriate dir
     *
     * @static
     *
     * @param string $location
     * @return boolean True if a redirect is needed
     */
    function checkRedirect($location = 'admin')
    {
        $redirect = false;
        // Is it possible to detect that we are NOT in the admin directory
        // via the URL the user is accessing Openads with?
        if (!preg_match('#/'. $location .'/?$#', $_SERVER['REQUEST_URI'])) {
            $dirName = dirname($_SERVER['REQUEST_URI']);
            if (!preg_match('#/'. $location .'$#', $dirName)) {
                // The user is not in the "admin" folder directly. Are they
                // in the admin folder as a result of a "full" virtual host
                // configuration?
                if ($GLOBALS['_MAX']['CONF']['webpath']['admin'] != getHostName()) {
                    // Not a "full" virtual host setup, so re-direct
                    $redirect = true;
                }
            }
        }

        return $redirect;
    }

}

?>
