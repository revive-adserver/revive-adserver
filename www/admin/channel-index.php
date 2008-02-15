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
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/www/admin/lib-statistics.inc.php';
require_once MAX_PATH . '/lib/max/other/html.php';

// Register input variables
phpAds_registerGlobal ('acl', 'action', 'submit');

// Security check
OA_Permission::enforceAccount(OA_ACCOUNT_MANAGER);


// Initialise some parameters
$pageName = basename($_SERVER['PHP_SELF']);
$agencyId = OA_Permission::getEntityId();
$tabindex = 1;

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PageHeader("5.7");
// Show the "Preferences", "User Log" and "Channel Management" sections of the "My Account" sections
phpAds_ShowSections(array("5.1", "5.3", "5.7"));



/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

echo "<img src='images/icon-channel-add.gif' border='0' align='absmiddle'>&nbsp;";
echo "<a href='channel-edit.php?agencyid={$agencyId}' accesskey='".$keyAddNew."'>{$GLOBALS['strAddNewChannel_Key']}</a>&nbsp;&nbsp;";
phpAds_ShowBreak();

$channels = Admin_DA::getChannels(array('agency_id' => $agencyId), true);

MAX_displayChannels($channels, array('agencyid' => $agencyId));

phpAds_PageFooter();

?>
