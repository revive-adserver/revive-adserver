<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.5                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
| For contact details, see: http://www.openads.org/                         |
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

// Require the initialisation file
require_once '../../init.php';

// Required files
require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/lib/OA/Dal/ApplicationVariables.php';
require_once MAX_PATH . '/lib/OA/Admin/Template.php';
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/www/admin/lib-statistics.inc.php';

// Security check
MAX_Permission::checkAccess(phpAds_Admin);

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

$iframe = !empty($_GET['iframe']);

if (!$iframe) {
    phpAds_PageHeader("1.0");
}

$oTpl = new OA_Admin_Template($iframe ? 'dashboard-iframe.html' : 'dashboard-index.html');
$oTpl->assign('dashboardURL', MAX::constructURL(MAX_URL_ADMIN, 'dashboard.php?iframe=1'));

if ($iframe) {
    $oTpl->assign('ssoAdmin',     OA_Dal_ApplicationVariables::get('sso_admin'));
    $oTpl->assign('ssoPasswd',    OA_Dal_ApplicationVariables::get('sso_password'));
    $oTpl->assign('casLoginURL',  'https://login.openads.org:8443/cas-server/login');
    $oTpl->assign('serviceURL',   'http://forum.openads.org/index.php?act=module&module=cas');
}

$oTpl->display();

if (!$iframe) {
    phpAds_PageFooter();
}

?>