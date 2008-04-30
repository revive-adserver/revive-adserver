<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
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

require_once MAX_PATH . '/www/admin/config.php';
OA_Permission::enforceAccount(OA_ACCOUNT_ADMIN, OA_ACCOUNT_MANAGER);
//OA_Permission::enforceTrue(isset($GLOBALS['OA_Navigation'][OA_ACCOUNT_MANAGER]['1']));


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
