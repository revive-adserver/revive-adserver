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

require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/lib/OA/Permission.php';
require_once MAX_PATH . '/lib/OA/Permission/User.php';
require_once MAX_PATH . '/lib/OA/Admin/Template.php';
require_once LIB_PATH . '/Extension/authentication/authentication.php';

/**
 * A class to deal with user authentication
 *
 */
class OA_Auth
{
    public const DEFAULT_MIN_PASSWORD_LENGTH = 12;

    /**
     * Returns authentication plugin
     *
     * @static
     * @param string $authType
     * @return Plugins_Authentication
     */
    public static function staticGetAuthPlugin()
    {
        static $authPlugin;
        static $authPluginType;

        if (!isset($authPlugin) || null === $authPluginType) {
            $aConf = $GLOBALS['_MAX']['CONF'];
            if (!empty($aConf['authentication']['type'])) {
                $authType = $aConf['authentication']['type'];
                $authPlugin = OX_Component::factoryByComponentIdentifier($authType);
            }
            if (!$authPlugin) {
                // Fall back to internal
                $authType = 'none';
                $authPlugin = new Plugins_Authentication();
            }
            if (!$authPlugin) {
                OA::debug('Error while including authentication plugin and unable to fallback', PEAR_LOG_ERR);
            }
            $authPluginType = $authType;
        }
        return $authPlugin;
    }

    /**
     * Logs in an user
     *
     * @static
     *
     * @param callable $redirectCallback
     * @return mixed Array on success
     */
    public static function login($redirectCallback = null)
    {
        $aConf = $GLOBALS['_MAX']['CONF'];

        if (!is_callable($redirectCallback)) {
            // Set the default callback
            $redirectCallback = ['OA_Auth', 'checkRedirect'];
        }

        if (call_user_func($redirectCallback)) {
            header('location: http://' . $aConf['webpath']['admin']);
            exit();
        }

        if (defined('OA_SKIP_LOGIN')) {
            return OA_Auth::getFakeSessionData();
        }

        if (OA_Auth::suppliedCredentials()) {
            $doUser = OA_Auth::authenticateUser();

            if (!$doUser) {
                OA_Auth::restart($GLOBALS['strUsernameOrPasswordWrong']);
            }

            // Regenerate session ID now
            phpAds_SessionRegenerateId();

            if ($doUser->isResetRequired()) {
                self::sendResetEmailAndDisplayMessage($doUser);

                exit;
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
    public static function logout()
    {
        $authPlugin = OA_Auth::staticGetAuthPlugin();
        $authPlugin->logout();
    }

    /**
     * A method to check if the login credential were supplied as POST parameters
     *
     * @static
     *
     * @return bool
     */
    public static function suppliedCredentials()
    {
        $authPlugin = OA_Auth::staticGetAuthPlugin();
        return $authPlugin->suppliedCredentials();
    }

    public static function checkAndQueueUnsafePasswordWarning()
    {
        $oUser = OA_Permission::getCurrentUser();

        if (false === $oUser || !$oUser->aUser['unsafe_password']) {
            return;
        }

        OA_Admin_UI::queueMessage(
            sprintf($GLOBALS['strPasswordUnsafeWarning'], MAX::constructURL(MAX_URL_ADMIN, 'account-user-password.php')),
            'global',
            'warning',
            10000
        );
    }

    /**
     * A method to authenticate user
     *
     * @static
     *
     * @return DataObjects_Users
     */
    private static function authenticateUser()
    {
        $authPlugin = OA_Auth::staticGetAuthPlugin();
        $doUsers = $authPlugin->authenticateUser();
        if ($doUsers) {
            $doUsers->logDateLastLogIn();
        }
        return $doUsers;
    }

    /**
     * A method to test if the user is logged in
     *
     * @return boolean
     */
    public static function isLoggedIn()
    {
        return is_a(OA_Permission::getCurrentUser(), 'OA_Permission_User');
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
    public static function getSessionData($doUser, $skipDatabaseAccess = false)
    {
        return [
            'user' => new OA_Permission_User($doUser, $skipDatabaseAccess)
        ];
    }

    /**
     * A static method to return fake data to be stored in the session variable
     *
     * @static
     *
     * @return array
     */
    public static function getFakeSessionData()
    {
        return [
            'user' => false
        ];
    }

    /**
     * A static method to restart with a login screen, eventually displaying a custom message
     *
     * @static
     *
     * @param string $sMessage Optional message
     */
    public static function restart($sMessage = '')
    {
        $_COOKIE['sessionID'] = phpAds_SessionRegenerateId();
        OA_Auth::displayLogin($sMessage, $_COOKIE['sessionID']);
    }

    /**
     * A static method to restart with a login screen, displaying an error message
     *
     * @static
     *
     * @param PEAR_Error $oError
     */
    public static function displayError($oError)
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
    public static function displayLogin($sMessage = '', $sessionID = 0, $inLineLogin = false)
    {
        if (empty($GLOBALS['_MAX']['CONF']['ui']['enabled'])) {
            OA_Admin_UI::showUIDisabledScreen();

            exit;
        }

        $authLogin = OA_Auth::staticGetAuthPlugin();
        $authLogin->displayLogin($sMessage, $sessionID, $inLineLogin);
    }

    /**
     * Check if application is running from appropriate dir
     *
     * @static
     *
     * @param string $location
     * @return boolean True if a redirect is needed
     */
    public static function checkRedirect($location = 'admin')
    {
        $aConf = $GLOBALS['_MAX']['CONF'];

        $redirect = false;
        // Is it possible to detect that we are NOT in the admin directory
        // via the URL the user is accessing OpenXwith?
        if (!preg_match('#/' . $location . '/?$#', $_SERVER['REQUEST_URI'])) {
            $dirName = dirname($_SERVER['REQUEST_URI']);
            // This check now allows for files in plugin folders
            $pluginDirName = basename($aConf['pluginPaths'][$location]);
            // The user is not in the "admin" folder directly. Are they
            // in the admin folder as a result of a "full" virtual host
            // configuration?
            if (!preg_match("#/{$location}(/{$pluginDirName}/.*?)?/?$#", $dirName) && $aConf['webpath']['admin'] != OX_getHostName()) {
                // Not a "full" virtual host setup, so re-direct
                $redirect = true;
            }
        }

        return $redirect;
    }

    private static function sendResetEmailAndDisplayMessage(DataObjects_Users $doUser): void
    {
        require_once MAX_PATH . '/lib/OA/Admin/PasswordRecovery.php';

        $oPasswordRecovery = new OA_Admin_PasswordRecovery();

        $oPasswordRecovery->sendPasswordUpdateEmail([$doUser->user_id]);

        $oPasswordRecovery->displayResetRequiredUponLogin();
    }
}
