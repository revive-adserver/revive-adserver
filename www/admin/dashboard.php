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

// Require the initialisation file
require_once '../../init.php';

// Required files
require_once MAX_PATH . '/lib/OA/Dal.php';
require_once MAX_PATH . '/lib/OA/Admin/Template.php';
require_once MAX_PATH . '/www/admin/lib-statistics.inc.php';
require_once MAX_PATH . '/lib/OA/Permission.php';
require_once LIB_PATH . '/Admin/Redirect.php';

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

require_once MAX_PATH . '/www/admin/config.php';
OA_Permission::enforceAccount(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER);

// If the user is a manager and the dashboard can't be showed to him
// clear the menu cache and redirect this user to advertiser-index.php
if (OA_Permission::isAccount(OA_ACCOUNT_ADMIN) && !$GLOBALS['_MAX']['CONF']['ui']['dashboardEnabled']) {
    OA_Admin_Menu::_clearCache(OA_ACCOUNT_ADMIN);
    OX_Admin_Redirect::redirect('agency-index.php');
}
if (OA_Permission::isAccount(OA_ACCOUNT_MANAGER) && !$GLOBALS['_MAX']['CONF']['ui']['dashboardEnabled']) {
    OA_Admin_Menu::_clearCache(OA_ACCOUNT_MANAGER);
    OX_Admin_Redirect::redirect('advertiser-index.php');
}
if (OA_Permission::isAccount(OA_ACCOUNT_MANAGER) && !$GLOBALS['_MAX']['CONF']['sync']['checkForUpdates']) {
    OA_Admin_Menu::_clearCache(OA_ACCOUNT_MANAGER);
    OX_Admin_Redirect::redirect('advertiser-index.php');
}

$widget = !empty($_REQUEST['widget']) ? $_REQUEST['widget'] : 'Index';

if (preg_match('/^[a-z0-9]+$/i', $widget) && file_exists(MAX_PATH . '/lib/OA/Dashboard/Widgets/' . $widget . '.php')) {
    // Load widget
    require(MAX_PATH . '/lib/OA/Dashboard/Widgets/' . $widget . '.php');
    $widget = 'OA_Dashboard_Widget_' . $widget;
} else {
    // Show empty widget
    require(MAX_PATH . '/lib/OA/Dashboard/Widget.php');
    $widget = 'OA_Dashboard_Widget';
}

$oDashboard = new $widget($_REQUEST);
$oDashboard->display();
