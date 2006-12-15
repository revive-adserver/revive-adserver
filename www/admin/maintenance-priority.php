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
$Id: maintenance-priority.php 4349 2006-03-06 17:51:10Z matteo@beccati.com $
*/

// Require the initialisation file
require_once '../../init.php';

// Required files
require_once MAX_PATH . '/www/admin/config.php';
require_once MAX_PATH . '/www/admin/lib-maintenance.inc.php';
require_once MAX_PATH . '/www/admin/lib-statistics.inc.php';
require_once MAX_PATH . '/www/admin/lib-zones.inc.php';

// Security check
phpAds_checkAccess(phpAds_Admin);

/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PageHeader("5.3");
phpAds_ShowSections(array("5.1", "5.3", "5.4", "5.2", "5.5", "5.6"));
phpAds_MaintenanceSelection("priority");

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
		foreach (array_keys($rows) as $key) {
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


/*
// Extra campaign info
$res = phpAds_dbQuery(
	"SELECT COUNT(*) AS count".
	",SUM(target) AS sum_target".
	" FROM ".$conf['table']['prefix'].$conf['table']['campaigns'].
	" WHERE target>0"
);

$campaigns_count = phpAds_dbResult($res, 0, 'count');
$campaigns_target = phpAds_dbResult($res, 0, 'sum_target');

$res = phpAds_dbQuery(
	"SELECT COUNT(*) AS campaigns".
	" FROM ".$conf['table']['prefix'].$conf['table']['campaigns'].
	" WHERE weight > 0"
);

$campaigns_weight = phpAds_dbResult($res, 0, 'campaigns');


// Get the number of days running
$query = "SELECT UNIX_TIMESTAMP(MIN(day)) AS days_running FROM ".$conf['table']['prefix'].$conf['table']['data_summary_ad_hourly']." WHERE day > 0 AND hour > 0 ORDER BY day LIMIT 1";
$res = phpAds_dbQuery($query);
$days_running = phpAds_dbResult($res, 0, 'days_running');

if ($days_running > 0) {
	$days_running = mktime (0, 0, 0, date('m'), date('d'), date('Y')) - $days_running;
	$days_running = round ($days_running / (60 * 60 * 24)) - 1;
} else {
	$days_running = 0;
}

if ($days_running >= 2){
	echo str_replace ("{days}", $days_running, $strPriorityDaysRunning);
	if ($days_running >= 8) {
		echo $strPriorityBasedLastWeek;
	}
	if ($days_running >= 2 && $days_running < 8) {
		echo $strPriorityBasedLastDays;
	}
	if ($days_running == 1) {
		echo $strPriorityBasedYesterday;
	}
} else {
	echo $strPriorityNoData;
}

define('phpAds_CurrentTimestamp', phpAds_dbResult(phpAds_dbQuery("SELECT UNIX_TIMESTAMP(NOW()) as now"),0,'now'));
define('phpAds_CurrentHour', date('H',phpAds_CurrentTimestamp));
define('phpAds_CurrentDay', mktime(0,0,0,date('m',phpAds_CurrentTimestamp),date('d',phpAds_CurrentTimestamp),date('Y',phpAds_CurrentTimestamp)));

$banners   = phpAds_PriorityPrepareBanners();
$campaigns = phpAds_PriorityPrepareCampaigns();
$profile   = array();

list($profile, $profile_correction_executed) = phpAds_PriorityPredictProfile($campaigns, $banners);

$estimated_hits = 0;
for ($p=0; $p<24; $p++){
	$estimated_hits += $profile[$p];
}

if ($campaigns_target) {
	if ($estimated_hits > $campaigns_target) {
		echo $strPriorityEnoughAdViews;
	} else {
		echo $strPriorityNotEnoughAdViews;
	}
} else {
	$campaigns_target = 0;
}
*/

// Show recalculate button
//echo "<br /><br />";
//phpAds_ShowBreak();
echo "<img src='images/".$phpAds_TextDirection."/icon-undo.gif' border='0' align='absmiddle'>&nbsp;<a href='maintenance-priority-calculate.php'>$strRecalculatePriority</a>&nbsp;&nbsp;";
echo "<br /><br />";
phpAds_ShowBreak();


// Show banners
//echo "<br /><br />";
//phpAds_showBanners();

echo "<br /><br />";
echo 'This page needs to be re-written to show an agency-based list of ad/zone priority data...';
echo "<br /><br />";


/*
echo "<br /><br />";
echo "<table width='100%' border='0' align='center' cellspacing='0' cellpadding='0'>";
	echo "<tr height='25'>";
	echo "<td height='25'>&nbsp;&nbsp;<b>".$strOverall."</b></td>";
	echo "<td height='25'>&nbsp;</td>";
	echo "</tr>";

echo "<tr height='1'><td colspan='2' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
	echo "<tr height='25'>";
	echo "<td height='25'>&nbsp;&nbsp;".$strHighPriorityCampaigns.": <b>".$campaigns_count."</b></td>";
	echo "<td height='25'>".$strAdViewsAssigned.": <b>".$campaigns_target."</b></td>";
	echo "</tr>";

echo "<tr height='1'><td colspan='2' bgcolor='#888888'><img src='images/break-l.gif' height='1' width='100%'></td></tr>";
	echo "<tr height='25'>";
	echo "<td height='25'>&nbsp;&nbsp;".$strLowPriorityCampaigns.": <b>".$campaigns_weight."</b></td>";
	echo "<td height='25'>&nbsp;</td>";
	echo "</tr>";

if ($campaigns_target > 0) {
	echo "<tr height='1'><td colspan='2' bgcolor='#888888'><img src='images/break-l.gif' height='1' width='100%'></td></tr>";
		echo "<tr height='25'>";
		echo "<td height='25'>&nbsp;&nbsp;".$strPredictedAdViews.": <b>".$estimated_hits."</b></td>";
		echo "<td height='25'>&nbsp;</td>";
		echo "</tr>";
}
*/

echo "<tr height='1'><td colspan='2' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
echo "</table>";
echo "<br /><br />";


/*-------------------------------------------------------*/
/* HTML framework                                        */
/*-------------------------------------------------------*/

phpAds_PageFooter();

?>
