<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2007 Openads Ltd                                       |
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
require_once MAX_PATH . '/lib/max/language/Userlog.php';
require_once MAX_PATH . '/www/admin/config.php';

// Security check
MAX_Permission::checkAccess(phpAds_Admin);

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PageHeader("5.2.1");
phpAds_ShowSections(array("5.2.1"));

// Load the required language files
Language_Userlog::load();

/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

$doUserLog = OA_Dal::factoryDO('userlog');

if ($doUserLog->get($userlogid))
{
    $row = $doUserLog->toArray();
	echo "<br />";
	echo "<table cellpadding='0' cellspacing='0' border='0'>";

	echo "<tr height='20'><td><b>".$strDate."</b>:&nbsp;&nbsp;</td>";
	echo "<td>".strftime($date_format, $row['timestamp']).", ".strftime($minute_format, $row['timestamp'])."</td></tr>";

	echo "<tr height='20'><td><b>".$strUser."</b>:&nbsp;&nbsp;</td><td>";
	switch ($row['usertype'])
	{
		case phpAds_userDeliveryEngine:	echo "<img src='images/icon-generatecode.gif' align='absmiddle'>&nbsp;".$strDeliveryEngine; break;
		case phpAds_userMaintenance:	echo "<img src='images/icon-time.gif' align='absmiddle'>&nbsp;".$strMaintenance; break;
		case phpAds_userAdministrator:	echo "<img src='images/icon-advertiser.gif' align='absmiddle'>&nbsp;".$strAdministrator; break;
	}
	echo "</td></tr>";

	$action = $strUserlog[$row['action']];
	$action = str_replace ('{id}', $row['object'], $action);
	echo "<tr height='20'><td><b>".$strAction."</b>:&nbsp;&nbsp;</td><td>".$action."</td></tr>";
	echo "</table>";

	phpAds_ShowBreak();

	echo "<br /><br />";
	echo "<pre>".$row['details']."</pre>";
	echo "<br /><br />";
}



/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PageFooter();

?>