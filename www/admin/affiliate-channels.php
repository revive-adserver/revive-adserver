<?php

/*
+---------------------------------------------------------------------------+
| Max Media Manager v0.3                                                    |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2006 m3 Media Services Limited                         |
| For contact details, see: http://www.m3.net/                              |
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
$Id: affiliate-channels.php 3848 2005-11-03 09:39:41Z chris@m3.net $
*/

// Require the initialisation file
require_once '../../init.php';

// Required files
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/www/admin/lib-statistics.inc.php';
require_once MAX_PATH . '/lib/max/other/html.php';

// Register input variables
phpAds_registerGlobal ('acl', 'action', 'submit');


// Initialise some parameters
$pageName = basename($_SERVER['PHP_SELF']);
$tabindex = 1;
$agencyId = phpAds_getAgencyID();
$aEntities = array('affiliateid' => $affiliateid);

if (!MAX_checkPublisher($affiliateid)) {
    phpAds_Die($strAccessDenied, $strNotAdmin);
}

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

// Display navigation
$aOtherPublishers = Admin_DA::getPublishers(array('agency_id' => $agencyId));
MAX_displayNavigationPublisher($pageName, $aOtherPublishers, $aEntities);

/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

if (phpAds_isUser(phpAds_Admin) || phpAds_isUser(phpAds_Agency) || phpAds_isAllowed(phpAds_AddZone))
{
	echo "<img src='images/icon-channel-add.gif' border='0' align='absmiddle'>&nbsp;";
	echo "<a href='channel-edit.php?affiliateid=".$affiliateid."' accesskey='".$keyAddNew."'>{$GLOBALS['strAddNewChannel_Key']}</a>&nbsp;&nbsp;";
	phpAds_ShowBreak();
}

$channels = Admin_DA::getChannels(array('publisher_id' => $affiliateid), true);

MAX_displayChannels($channels, array('affiliateid' => $affiliateid));

phpAds_PageFooter();

?>
