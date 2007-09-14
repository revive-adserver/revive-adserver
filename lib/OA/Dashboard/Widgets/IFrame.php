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
require_once MAX_PATH . '/lib/OA/Dal/ApplicationVariables.php';

/**
 * A class to display the dashboard iframe content
 *
 */
class OA_Dashboard_Widget_Iframe extends OA_Dashboard_Widget
{
    /**
     * A method to launch and display the widget
     *
     */
    function display()
    {
        $oTpl = new OA_Admin_Template('dashboard-iframe.html');

        $ssoAdmin = OA_Dal_ApplicationVariables::get('sso_admin');
        $ssoPasswd = OA_Dal_ApplicationVariables::get('sso_password');

        $oTpl->assign('dashboardURL', MAX::constructURL(MAX_URL_ADMIN, 'dashboard.php?widget=IFrame'));
        $oTpl->assign('errorURL',     MAX::constructURL(MAX_URL_ADMIN, 'dashboard.php?widget=SsoDetails&error='));
        $oTpl->assign('ssoAdmin',     $ssoAdmin ? $ssoAdmin : 'foo');
        // md5 doesn't work yet - we will have to either reconfigure cas-server or create different url for
        // logging in using hashed password
        $oTpl->assign('ssoPasswd',    $ssoPasswd); // ? md5($ssoPasswd) : 'bar');
        $oTpl->assign('casLoginURL',  'https://login.openads.org/sso/login');
        $oTpl->assign('serviceURL',   'https://login.openads.org/account/account.auth');

        $oTpl->display();
    }
}

?>