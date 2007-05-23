<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
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
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/www/admin/lib-statistics.inc.php';
require_once MAX_PATH . '/lib/max/other/html.php';

// Register input variables
phpAds_registerGlobal ('acl', 'action', 'submit');


// Initialise some parameters
$pageName = basename($_SERVER['PHP_SELF']);
$tabindex = 1;

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

if (phpAds_isUser(phpAds_Admin)) {
	$agencyId = isset($agencyid) ? $agencyid : 0;

	if (!$agencyId) {
		// Admin channels
		phpAds_PageHeader("5.6");
		phpAds_ShowSections(array("5.1", "5.3", "5.4", "5.2", "5.5", "5.6"));
	} else {
		// Agency channels
		phpAds_PageHeader("5.5.3");
		phpAds_ShowSections(array("5.5.2", "5.5.3"));
	}
} else {
	$agencyId = phpAds_getAgencyID();

	if (!MAX_checkAgency($agencyId)) {
		phpAds_Die($strAccessDenied, $strNotAdmin);
	}

	phpAds_PageHeader("5.2");
	phpAds_ShowSections(array("5.1", "5.2"));
}

/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

if (phpAds_isUser(phpAds_Admin) || phpAds_isUser(phpAds_Agency)) {
	echo "<img src='images/icon-channel-add.gif' border='0' align='absmiddle'>&nbsp;";
	echo "<a href='channel-edit.php".($agencyId ? "?agencyid={$agencyId}" : '')."' accesskey='".$keyAddNew."'>{$GLOBALS['strAddNewChannel_Key']}</a>&nbsp;&nbsp;";
	phpAds_ShowBreak();
}

if (phpAds_isUser(phpAds_Admin)) {
    if (isset($agencyId) && $agencyId != 0) {
        // Looking at a specific agency's channels as admin
        $channels = Admin_DA::getChannels(array('agency_id' => $agencyId, 'channel_type' => 'agency'), true);
    } else {
        // Looking at all channels as admin
        $channels = Admin_DA::getChannels(array('channel_type' => 'admin'), true);
    }
} elseif (phpAds_isUser(phpAds_Agency)) {
    $channels = Admin_DA::getChannels(array('agency_id' => $agencyId), true);
}

MAX_displayChannels($channels, array('agencyid' => $agencyId));

phpAds_PageFooter();

?>
