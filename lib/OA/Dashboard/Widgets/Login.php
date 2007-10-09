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

require_once MAX_PATH . '/lib/OA/Dashboard/Widget.php';
require_once MAX_PATH . '/lib/max/Admin/Redirect.php';
require_once MAX_PATH . '/lib/OA/Central/AdNetworks.php';
require_once MAX_PATH . '/lib/OA/Central/Dashboard.php';

define('OA_SSO_USERNAME', 'sso_username');
define('OA_SSO_PASSWORD', 'sso_password');

define('OA_SSO_ERROR_WRONG_CREDENTIALS', 1);
define('OA_SSO_ERROR_WRONG_PARAMETERS', 2);
define('OA_SSO_ERROR_PLATFORM_TAKEN', 3);

/**
 * A class to display the dashboard iframe content
 *
 */
class OA_Dashboard_Widget_Login extends OA_Dashboard_Widget
{
    var $errorCode = null;

    var $lastUsedUserName;

    function OA_Dashboard_Widget_Login($aParams)
    {
        parent::OA_Dashboard_Widget($aParams);

        $this->wrongCredentials = isset($aParams['error']) && $aParams['error'] == 'error.authentication.credentials.bad';

        $this->getCredentials();

        $this->wrongParameters = false;
        
        if (!empty($aParams['login'])) {
            if ((empty($aParams[OA_SSO_USERNAME]) && !$this->ssoAdmin) || empty($aParams[OA_SSO_PASSWORD])) {
                $this->errorCode = OA_SSO_ERROR_WRONG_PARAMETERS;
                return;
            }
        
            if (!$this->ssoAdmin) {
                // user didn't connect platform yet
                $this->lastUsedUserName = $aParams[OA_SSO_USERNAME];
                $passwordHash = md5($aParams[OA_SSO_PASSWORD]);

                $oAdNetworks = new OA_Central_AdNetworks();
                $result = $oAdNetworks->connectOAPToOAC($aParams[OA_SSO_USERNAME], $passwordHash);

                if (!PEAR::isError($result)) {
                    OA_Dal_ApplicationVariables::set('sso_admin', $aParams[OA_SSO_USERNAME]);
                    OA_Dal_ApplicationVariables::set('sso_password', $passwordHash);
                } else {
                    $this->errorCode = $result->getCode();
                }
            } else {
                // user already connected - just changing password
                OA_Dal_ApplicationVariables::set('sso_password', md5($aParams['sso_password']));
            }

            if (!$this->errorCode) {
                $url = $this->buildUrl($GLOBALS['_MAX']['CONF']['oacDashboard']);
                MAX_Admin_Redirect::redirect('ssoProxy.php?url='.urlencode($url));
                exit;
            }
        }
    }

    /**
     * A method to launch and display the widget
     *
     */
    function display()
    {
        $aConf = $GLOBALS['_MAX']['CONF'];

        $oTpl = new OA_Admin_Template('dashboard/login.html');

        $oTpl->assign('signupUrl', $this->buildUrl($aConf['oacSSO'], 'signup'));
        $oTpl->assign('forgotUrl', $this->buildUrl($aConf['oacSSO'], 'forgot'));
        if (!empty($this->lastUsedUserName)) {
            $oTpl->assign('ssoAdmin', $this->lastUsedUserName);
        } else if (!empty($this->ssoAdmin)) {
            $oTpl->assign('ssoAdmin', $this->ssoAdmin);
            $oTpl->assign('disabledUsername', true);
        }
        $oTpl->assign('errorMessage', $this->getErrorMessage());

        $oTpl->display();
    }
    
    /**
     * Build error message from error code
     *
     * @return string
     */
    function getErrorMessage()
    {
        if (!empty($_GET['error'])) {
            $this->errorCode = OA_CENTRAL_ERROR_ERROR_NOT_AUTHORIZED;
        }
        if (empty($this->errorCode)) {
            return null;
        }
        switch($this->errorCode) {
            case OA_CENTRAL_ERROR_USERNAME_DOES_NOT_MATCH_PLATFORM:
                $msg = 'Sorry, this platform is already connected to a different user.';
                break;
            case OA_SSO_ERROR_WRONG_PARAMETERS:
                $msg = 'You must enter both username and passwsord.';
                break;
            case OA_CENTRAL_ERROR_ERROR_NOT_AUTHORIZED:
                $msg = 'Check credentials, wrong username or password.';
                break;
            default:
                $msg = 'Error while authenticating user';
        }
        return $msg;
    }
}

?>