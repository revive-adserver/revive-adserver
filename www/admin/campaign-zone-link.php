<?php

/*
+---------------------------------------------------------------------------+
| OpenX  v${RELEASE_MAJOR_MINOR}                                                              |
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
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/lib/max/other/proto.php';


/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/
require_once MAX_PATH . '/lib/OA/Admin/Template.php';

$action = $_GET["action"];

$oTpl = new OA_Admin_Template('campaign-zone-zones.html');

// Available zones go here
echo "<tbody>";
$linkedWebsites = getWebsites($_GET["clientid"], $_GET["campaignid"], $_GET["text"], $action == 'link' ? 'linked' : 'available', $_GET["category-available"]);
$oTpl->assign('websites', $linkedWebsites);
$oTpl->assign('checkboxPrefix', "a");
$oTpl->display();
echo "</tbody>";

// Linked zones go here
echo "<tbody>";
$availableWebsites = getWebsites($_GET["clientid"], $_GET["campaignid"], $_GET["text"], $action != 'link' ? 'linked' : 'available', $_GET["category-linked"]);
$oTpl->assign('websites', $availableWebsites);
$oTpl->assign('checkboxPrefix', "l");
$oTpl->display();
echo "</tbody>";

?>

