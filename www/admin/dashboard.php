<?php

/*
+---------------------------------------------------------------------------+
| Openads v${RELEASE_MAJOR_MINOR}                                                              |
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
require_once MAX_PATH . '/lib/OA/Admin/Template.php';
require_once MAX_PATH . '/www/admin/lib-statistics.inc.php';
require_once MAX_PATH . '/lib/OA/Permission.php';

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_SessionDataFetch();
if (!OA_Auth::isLoggedIn() && empty($_REQUEST['reload'])) {
    require(MAX_PATH.'/lib/OA/Dashboard/Widgets/Reload.php');
    $oReload = new OA_Dashboard_Widget_Reload($_REQUEST);
    $url = 'dashboard.php';
    if (empty($_REQUEST['widget'])) {
        $url .= '?reload=1';
    }
    $oReload->setUrl(MAX::constructURL(MAX_URL_ADMIN, $url));
    $oReload->display();
    exit();
}

require_once MAX_PATH . '/www/admin/config.php';
OA_Permission::enforceAccount(OA_ACCOUNT_ADMIN);

$widget = !empty($_REQUEST['widget']) ? $_REQUEST['widget'] : 'Index';

if (preg_match('/[a-z0-9]+/i', $widget) && file_exists(MAX_PATH.'/lib/OA/Dashboard/Widgets/'.$widget.'.php')) {
    // Load widget
    require(MAX_PATH.'/lib/OA/Dashboard/Widgets/'.$widget.'.php');
    $widget = 'OA_Dashboard_Widget_'.$widget;
} else {
    // Show empty widget
    require(MAX_PATH.'/lib/OA/Dashboard/Widget.php');
    $widget = 'OA_Dashboard_Widget';
}

$oDashboard = new $widget($_REQUEST);
$oDashboard->display();

?>
