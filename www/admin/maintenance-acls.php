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
$Id: maintenance-priority.php 3428 2005-07-04 15:58:31Z andrew $
*/

// Require the initialisation file
require_once '../../init.php';

// Required files
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/www/admin/lib-maintenance.inc.php';

// Security check
phpAds_checkAccess(phpAds_Admin);

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PageHeader("5.3");
phpAds_ShowSections(array("5.1", "5.3", "5.4", "5.2", "5.5", "5.6"));
phpAds_MaintenanceSelection("acls");

/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

function phpAds_showBanners ()
{
	$conf = $GLOBALS['_MAX']['CONF'];
	global $strUntitled, $strName, $strID, $strWeight;
	global $strProbability, $strPriority, $strRecalculatePriority;
	global $phpAds_TextDirection;

	$res = phpAds_dbQuery("SELECT ad_id AS bannerid,priority FROM {$conf['table']['prefix']}{$conf['table']['ad_zone_assoc']} WHERE zone_id=0 ORDER BY priority desc");
	$rows = array();
	$prioritysum = 0;

	while ($tmprow = phpAds_dbFetchArray($res)) {
		if ($tmprow['priority']) {
			$prioritysum += $tmprow['priority'];
			$rows[$tmprow['bannerid']] = $tmprow;
		}
	}

	if (is_array($rows)) {
		$i=0;

		// Header
		echo "<table width='100%' border='0' align='center' cellspacing='0' cellpadding='0'>";
		echo "<tr height='25'>";
		echo "<td height='25'><b>&nbsp;&nbsp;".$strName."</b></td>";
		echo "<td height='25'><b>".$strID."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></td>";
		echo "<td height='25'><b>".$strPriority."</b></td>";
		echo "<td height='25'><b>".$strProbability."</b></td>";
		echo "</tr>";

		echo "<tr height='1'><td colspan='5' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";

		// Banners
		for (reset($rows);$key=key($rows);next($rows)) {
			$name = phpAds_getBannerName ($rows[$key]['bannerid'], 60, false);

			if ($i > 0) echo "<tr height='1'><td colspan='5' bgcolor='#888888'><img src='images/break-l.gif' height='1' width='100%'></td></tr>";

	    	echo "<tr height='25' ".($i%2==0?"bgcolor='#F6F6F6'":"").">";

			echo "<td height='25'>";
			echo "&nbsp;&nbsp;";

			// Banner icon
			if ($rows[$key]['storagetype'] == 'html')
				echo "<img src='images/icon-banner-html.gif' align='absmiddle'>&nbsp;";
			elseif ($rows[$key]['storagetype'] == 'url')
				echo "<img src='images/icon-banner-url.gif' align='absmiddle'>&nbsp;";
			else
				echo "<img src='images/icon-banner-stored.gif' align='absmiddle'>&nbsp;";

			// Name
			echo $name;
			echo "</td>";

			echo "<td height='25'>".$rows[$key]['bannerid']."</td>";
			echo "<td height='25'>".$rows[$key]['priority']."</td>";
			echo "<td height='25'>".number_format($rows[$key]['priority'] / $prioritysum * 100, $pref['percentage_decimals'])."%</td>";

			echo "</tr>";
			$i++;
		}

		// Footer
		echo "<tr height='1'><td colspan='5' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
		echo "</table>";
	}
}





/*-------------------------------------------------------*/
/* Main code                                             */
/*-------------------------------------------------------*/

echo "<br />";

echo "<img src='images/".$phpAds_TextDirection."/icon-undo.gif' border='0' align='absmiddle'>Under some circumstances the delivery engine can disagree with the stored ACLs for banners and channels, use the folowing link to validate the ACLs in the database<br /><br />";
echo "&nbsp;<a href='maintenance-acl-check.php'>Check ACLs</a>&nbsp;&nbsp;";
echo "<br /><br />";
phpAds_ShowBreak();

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PageFooter();

?>
