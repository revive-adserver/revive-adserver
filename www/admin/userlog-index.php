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
$Id$
*/

// Require the initialisation file
require_once '../../init.php';

// Required files
require_once MAX_PATH . '/lib/max/language/Userlog.php';
require_once MAX_PATH . '/www/admin/config.php';

// Register input variables
phpAds_registerGlobal ('start');

// Security check
MAX_Permission::checkAccess(phpAds_Admin);

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PageHeader("5.2");
phpAds_ShowSections(array("5.1", "5.3", "5.4", "5.2", "5.5", "5.6"));

// Load the required language files
Language_Userlog::load();

/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

$doUserLog = MAX_DB::factoryDO('userlog');
if (!$count = $doUserLog->count()) {
    $count = 0;
}

$limit = 15;
$start = isset($start) ? (int) $start : 0;

$doUserLog = MAX_DB::factoryDO('userlog');
$doUserLog->orderBy('timestamp DESC');
$doUserLog->limit($start * $limit, $limit);
$doUserLog->find();

echo "<br /><br />";
echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";	
echo "<tr><td height='25'>&nbsp;&nbsp;<b>".$strDate."</b></td>";
echo "<td height='25'><b>".$strAction."</b></td></tr>";
echo "<td colspan='4' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td>";


if ($doUserLog->getRowCount() == 0)
{
	echo "<tr height='25' bgcolor='#F6F6F6'><td height='25' colspan='4'>";
	echo "&nbsp;&nbsp;".$strNoActionsLogged."</td></tr>";
	echo "<td colspan='4' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td>";
}

$i=0;

while ($doUserLog->fetch() && $row = $doUserLog->toArray())
{
	if ($i > 0) echo "<td colspan='4' bgcolor='#888888'><img src='images/break-l.gif' height='1' width='100%'></td>";
	echo "<tr height='25' ".($i%2==0?"bgcolor='#F6F6F6'":"").">";
	
	// Timestamp
	echo "<td height='25'>&nbsp;&nbsp;".strftime($date_format, $row['timestamp']).", ";
	echo strftime($minute_format, $row['timestamp'])."</td>";
	
	// User
	echo "<td height='25'>";
	switch ($row['usertype'])
	{
		case phpAds_userDeliveryEngine:	echo "<img src='images/icon-generatecode.gif' align='absmiddle'>&nbsp;".$strDeliveryEngine; break;
		case phpAds_userMaintenance:	echo "<img src='images/icon-time.gif' align='absmiddle'>&nbsp;".$strMaintenance; break;
		case phpAds_userAdministrator:	echo "<img src='images/icon-advertiser.gif' align='absmiddle'>&nbsp;".$strAdministrator; break;
	}
	echo "</td>";
	
	// Details
	echo "<td height='25' align='".$phpAds_TextAlignRight."'>";
	if ($row['details'] != '')
	{
		echo "<a href='userlog-details.php?userlogid=".$row['userlogid']."'>";
		echo "<img src='images/icon-zoom.gif' align='absmiddle' border='0'>&nbsp;".$strDetails."</a>";
	}
	else
		echo "&nbsp;";
	echo "&nbsp;&nbsp;</td>";
	echo "</tr>";
	
	// Space
	echo "<tr height='20' valign='top' ".($i%2==0?"bgcolor='#F6F6F6'":"").">";
	echo "<td>&nbsp;</td>";
	
	// Action
	$action = $strUserlog[$row['action']];
	$action = str_replace ('{id}', $row['object'], $action);
	echo "<td height='20' colspan='2'><img src='images/spacer.gif' height='16' width='16' align='absmiddle'>&nbsp;".$action."</td>";
	echo "</tr>";
	
	$i++;
}

if ($doUserLog->getRowCount() > 0)
{
	echo "<tr height='1'><td colspan='4' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
	echo "<tr><td height='25' colspan='2'>";
		echo "<a href='userlog-delete.php'><img src='images/icon-recycle.gif' border='0' align='absmiddle'>&nbsp;".$strDeleteLog."</a>";
	echo "</td><td height='25' colspan='2' align='".$phpAds_TextAlignRight."'>";
		if ($start > 0)
		{
			echo "<a href='userlog-index.php?start=".($start - 1)."'>";
			echo "<img src='images/arrow-l.gif' border='0' align='absmiddle'>".$strPrevious."</a>";
		}
		if ($count > ($start + 1) * $limit)
		{
			if ($start > 0) echo "&nbsp;|&nbsp;";
			
			echo "<a href='userlog-index.php?start=".($start + 1)."'>";
			echo $strNext."<img src='images/arrow-r.gif' border='0' align='absmiddle'></a>";
		}
	echo "</td></tr>";
}

echo "</table>";
echo "<br /><br />";



/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PageFooter();

?>
