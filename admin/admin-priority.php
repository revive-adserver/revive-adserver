<?php // $Revision$

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2001 by the phpAdsNew developers                       */
/* http://sourceforge.net/projects/phpadsnew                            */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/



// Include required files
require ("config.php");
require ("lib-statistics.inc.php");
require ("lib-zones.inc.php");
require ("../lib-priority.inc.php");


// Security check
phpAds_checkAccess(phpAds_Admin);



/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

phpAds_PageHeader("4.4");
phpAds_ShowSections(array("4.1", "4.2", "4.3", "4.4"));



/*********************************************************/
/* Main code                                             */
/*********************************************************/

function phpAds_showBanners ()
{
	global $phpAds_config;
	global $strUntitled, $strName, $strID, $strWeight;
	global $strProbability, $strPriority, $strRecalculatePriority;
	global $phpAds_TextDirection;
	
	
	$res = phpAds_dbQuery("
		SELECT
			*
		FROM
			".$phpAds_config['tbl_banners']."
		ORDER BY
			priority
	");
	
	$rows = array();
	$prioritysum = 0;
	
	while ($tmprow = phpAds_dbFetchArray($res))
	{
		if ($tmprow['priority'])
		{
			$prioritysum += $tmprow['priority'];
			$rows[$tmprow['bannerid']] = $tmprow; 
		}
	}
	
	if (is_array($rows))
	{
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
		for (reset($rows);$key=key($rows);next($rows))
		{
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
			echo "<td height='25'>".number_format($rows[$key]['priority'] / $prioritysum * 100, $phpAds_config['percentage_decimals'])."%</td>";
			
			echo "</tr>";
			$i++;
		}
		
		// Footer
		echo "<tr height='1'><td colspan='5' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
		echo "</table>";
	}
}





/*********************************************************/
/* Main code                                             */
/*********************************************************/

echo "<br>";



// Extra campaign info
$res = phpAds_dbQuery("SELECT COUNT(*) AS count, SUM(target) AS sum_target FROM ".$phpAds_config['tbl_clients']." WHERE parent > 0 AND target > 0");
$campaigns_count = phpAds_dbResult($res, 0, 'count');
$campaigns_target = phpAds_dbResult($res, 0, 'sum_target');

$res = phpAds_dbQuery("SELECT COUNT(*) AS campaigns FROM ".$phpAds_config['tbl_clients']." WHERE parent > 0 AND weight > 0");
$campaigns_weight = phpAds_dbResult($res, 0, 'campaigns');


// Get the number of days running
if ($phpAds_config['compact_stats'])
{
	$res = phpAds_dbQuery("SELECT UNIX_TIMESTAMP(MIN(day)) AS days_running FROM ".$phpAds_config['tbl_adstats']." WHERE day > 0 AND hour > 0");
	$days_running = phpAds_dbResult($res, 0, 'days_running');
}
else
{
	$res = phpAds_dbQuery("SELECT UNIX_TIMESTAMP(MIN(t_stamp)) AS days_running FROM ".$phpAds_config['tbl_adviews']);
	$days_running = phpAds_dbResult($res, 0, 'days_running');
}

if ($days_running > 0)
{
	$days_running = mktime (0, 0, 0, date('m'), date('d'), date('Y')) - $days_running;
	$days_running = round ($days_running / (60 * 60 * 24)) - 1;
}
else
	$days_running = 0;
	
	
if ($days_running >= 2)
{
	echo str_replace ("{days}", $days_running, $strPriorityDaysRunning);
	
	if ($days_running >= 8)
		echo $strPriorityBasedLastWeek;
	
	if ($days_running >= 2 && $days_running < 8)
		echo $strPriorityBasedLastDays;
	
	if ($days_running == 1)
		echo $strPriorityBasedYesterday;
}
else
	echo $strPriorityNoData;


$banners   = phpAds_PriorityPrepareBanners();
$campaigns = phpAds_PriorityPrepareCampaigns();
$profile   = array();

list($profile, $profile_correction_executed) = phpAds_PriorityPredictProfile($campaigns, $banners, $profile);

$estimated_hits = 0;
for ($p=0; $p<24; $p++)
{
	$estimated_hits += $profile[$p];
}

if ($campaigns_target)
{
	if ($estimated_hits > $campaigns_target)
		echo $strPriorityEnoughAdViews;
	else
		echo $strPriorityNotEnoughAdViews;
}


// Show recalculate button
echo "<br><br>";
phpAds_ShowBreak();
echo "<img src='images/".$phpAds_TextDirection."/icon-undo.gif' border='0' align='absmiddle'>&nbsp;<a href='admin-priority-calculate.php'>$strRecalculatePriority</a>&nbsp;&nbsp;";
phpAds_ShowBreak();


// Show banners
echo "<br><br>";
phpAds_showBanners();
echo "<br><br>";


echo "<br><br>";
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
	
echo "<tr height='1'><td colspan='2' bgcolor='#888888'><img src='images/break-l.gif' height='1' width='100%'></td></tr>";
	echo "<tr height='25'>";
	echo "<td height='25'>&nbsp;&nbsp;".$strPredictedAdViews.": <b>".$estimated_hits."</b></td>";
	echo "<td height='25'>&nbsp;</td>";
	echo "</tr>";
	
echo "<tr height='1'><td colspan='2' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
echo "</table>";
echo "<br><br>";



/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

phpAds_PageFooter();

?>
