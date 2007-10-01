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


/**
 * A class to display the dashboard iframe content
 *
 */
class OA_Dashboard_Widget_Login extends OA_Dashboard_Widget
{
    var $wrongCredentials;
    var $wrongParameters;

    function OA_Dashboard_Widget_Login($aParams)
    {
        parent::OA_Dashboard_Widget($aParams);

        $this->wrongCredentials = isset($aParams['error']) && $aParams['error'] == 'error.authentication.credentials.bad';

        $this->getCredentials();

        $this->wrongParameters = false;
        if (!empty($aParams['sso_password'])) {
            if (!$this->ssoAdmin) {
                $this->wrongParameters = true;
                if (!empty($aParams['sso_username'])) {
                    $passwordHash = md5($aParams['sso_password']);
                    
                    $oAdNetworks = new OA_Central_AdNetworks();
                    $result = $oAdNetworks->connectOAPToOAC($aParams['sso_username'], $passwordHash);

                    if (!PEAR::isError($result)) {
                        OA_Dal_ApplicationVariables::set('sso_admin', $aParams['sso_username']);
                        OA_Dal_ApplicationVariables::set('sso_password', $passwordHash);
                        $this->wrongParameters = false;
                    }
                }
            } else {
                OA_Dal_ApplicationVariables::set('sso_password', md5($aParams['sso_password']));
            }

            if (!$this->wrongParameters) {
                $url = OA_Dashboard::buildUrl($GLOBALS['_MAX']['CONF']['oacDashboard']);
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
        $oTpl->assign('ssoAdmin',  $this->ssoAdmin);

        if ($this->wrongCredentials || $this->wrongParameters)
        {
            $oTpl->assign('displayError', true);

            if ($this->ssoAdmin) {
                $errorMessage = "Sorry, this platform is already connected to a different user.";
            } elseif ($this->wrongParameters) {
                $errorMessage = "You must enter both username and passwsord.";
            } else {
                $errorMessage = "Check credentials, wrong username or password.";
            }

            $oTpl->assign('errorMessage', $errorMessage);
        }

        $oTpl->display();
    }
}

?>