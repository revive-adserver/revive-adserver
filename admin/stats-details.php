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
require ("lib-gd.inc.php");


// Security check
phpAds_checkAccess(phpAds_Admin+phpAds_Client);



/*********************************************************/
/* Client interface security                             */
/*********************************************************/

if (phpAds_isUser(phpAds_Client))
{
	$result = phpAds_dbQuery("
		SELECT
			clientid
		FROM
			".$phpAds_config['tbl_banners']."
		WHERE
			bannerid = $bannerid
		") or phpAds_sqlDie();
	$row = phpAds_dbFetchArray($result);
	
	if ($row["clientid"] == '' || phpAds_getUserID() != phpAds_getParentID ($row["clientid"]))
	{
		phpAds_PageHeader("1");
		phpAds_Die ($strAccessDenied, $strNotAdmin);
	}
	else
	{
		$campaignid = $row["clientid"];
	}
}



/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

$extra = '';

$res = phpAds_dbQuery("
	SELECT
		*
	FROM
		".$phpAds_config['tbl_banners']."
	WHERE
		clientid = $campaignid
") or phpAds_sqlDie();

while ($row = phpAds_dbFetchArray($res))
{
	if ($bannerid == $row['bannerid'])
		$extra .= "&nbsp;&nbsp;&nbsp;<img src='images/box-1.gif'>&nbsp;";
	else
		$extra .= "&nbsp;&nbsp;&nbsp;<img src='images/box-0.gif'>&nbsp;";
	
	$extra .= "<a href='stats-details.php?campaignid=$campaignid&bannerid=".$row['bannerid']."'>";
	$extra .= phpAds_buildBannerName ($row['bannerid'], $row['description'], $row['alt']);
	$extra .= "</a>";
	$extra .= "<br>"; 
}
$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";


if (phpAds_isUser(phpAds_Admin))
{
	$extra .= "<br><br><br><br><br>";
	$extra .= "<b>$strShortcuts</b><br>";
	$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
	$extra .= "<img src='images/icon-client.gif' align='absmiddle'>&nbsp;<a href=client-edit.php?clientid=".phpAds_getParentID ($campaignid).">$strClientProperties</a><br>";
	$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
	$extra .= "<img src='images/icon-edit.gif' align='absmiddle'>&nbsp;<a href=campaign-edit.php?campaignid=$campaignid>$strCampaignProperties</a><br>";
	$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
	$extra .= "<img src='images/icon-campaign.gif' align='absmiddle'>&nbsp;<a href=campaign-index.php?campaignid=$campaignid>$strBannerOverview</a><br>";
	$extra .= "<img src='images/break-el.gif' height='1' width='160' vspace='4'><br>";
	$extra .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src='images/icon-banner-stored.gif' align='absmiddle'>&nbsp;<a href=banner-edit.php?campaignid=$campaignid&bannerid=$bannerid>$strBannerProperties</a><br>";
		
	if ($phpAds_config['acl'])
	{
		$extra .= "<img src='images/break-el.gif' height='1' width='160' vspace='4'><br>";
		$extra .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src='images/icon-acl.gif' align='absmiddle'>&nbsp;<a href=banner-acl.php?campaignid=$campaignid&bannerid=$bannerid>$strModifyBannerAcl</a><br>";
	}
	$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
	
	phpAds_PageHeader("2.1.2.1", $extra);
		echo "<img src='images/icon-client.gif' align='absmiddle'>&nbsp;".phpAds_getParentName($campaignid);
		echo "&nbsp;<img src='images/caret-rs.gif'>&nbsp;";
		echo "<img src='images/icon-campaign.gif' align='absmiddle'>&nbsp;".phpAds_getClientName($campaignid);
		echo "&nbsp;<img src='images/caret-rs.gif'>&nbsp;";
		echo "<img src='images/icon-banner-stored.gif' align='absmiddle'>&nbsp;<b>".phpAds_getBannerName($bannerid)."</b><br><br>";
		echo phpAds_getBannerCode($bannerid)."<br><br><br><br>";
		phpAds_ShowSections(array("2.1.2.1", "2.1.2.2"));
}

if (phpAds_isUser(phpAds_Client))
{
	phpAds_PageHeader("1.1.1.1", $extra);
		echo "<img src='images/icon-campaign.gif' align='absmiddle'>&nbsp;".phpAds_getClientName($campaignid);
		echo "&nbsp;<img src='images/caret-rs.gif'>&nbsp;";
		echo "<img src='images/icon-banner-stored.gif' align='absmiddle'>&nbsp;<b>".phpAds_getBannerName($bannerid)."</b><br><br>";
		echo phpAds_getBannerCode($bannerid)."<br><br><br><br>";
		phpAds_ShowSections(array("1.1.1.1"));
}

echo "<br><br>";



/*********************************************************/
/* Main code                                             */
/*********************************************************/

if (!isset($limit) || $limit=='') $limit = '7';
if (!isset($start) || $start=='') $start = '0';


if ($phpAds_config['compact_stats']) 
{
	// Determine first and last day of stats
	$result = phpAds_dbQuery("
		SELECT
			TO_DAYS(NOW()) - TO_DAYS(MIN(day)) + 1 AS span
		FROM
			".$phpAds_config['tbl_adstats']."
		WHERE
			bannerid = ".$bannerid."
	");
	
	if ($row = phpAds_dbFetchArray($result))
	{
		$span = $row['span'];
	}
	
	
	// Get total statistics
	$result = phpAds_dbQuery("
		SELECT
			SUM(views) AS sum_views,
			SUM(clicks) AS sum_clicks
		FROM
			".$phpAds_config['tbl_adstats']."
		WHERE
			bannerid = ".$bannerid."
	");
	
	if ($row = phpAds_dbFetchArray($result))
	{
		$totals['views'] = $row['sum_views'];
		$totals['clicks'] = $row['sum_clicks'];
	}
	
	
	// Get stats for selected period
	$begin = date('Ymd', mktime(0, 0, 0, date('m'), date('d') - $limit + 1 - $start, date('Y')));
	$end   = date('Ymd', mktime(0, 0, 0, date('m'), date('d') + 1 - $start, date('Y')));
	
	$result = phpAds_dbQuery("
		SELECT
			SUM(views) AS sum_views,
			SUM(clicks) AS sum_clicks,
			DATE_FORMAT(day, '$date_format') AS date_formatted,
			DATE_FORMAT(day, '%Y%m%d') AS date
		FROM
			".$phpAds_config['tbl_adstats']."
		WHERE
			bannerid = $bannerid AND
			day >= $begin AND day < $end
		GROUP BY
			day
		LIMIT 
			$limit
	");
	
	while ($row = phpAds_dbFetchArray($result))
	{
		$stats[$row['date']] = $row;
	}
}
else
{
	// Determine first and last day of stats
	$result = phpAds_dbQuery("
		SELECT
			TO_DAYS(NOW()) - TO_DAYS(MIN(t_stamp)) + 1 AS span
		FROM
			".$phpAds_config['tbl_adviews']."
		WHERE
			bannerid = ".$bannerid."
	");
	
	if ($row = phpAds_dbFetchArray($result))
	{
		$span = $row['span'];
	}
	
	
	// Get total statistics
	$result = phpAds_dbQuery("
		SELECT
			COUNT(*) AS sum_views
		FROM
			".$phpAds_config['tbl_adviews']."
		WHERE
			bannerid = ".$bannerid."
	");
	
	if ($row = phpAds_dbFetchArray($result))
	{
		$totals['views'] = $row['sum_views'];
	}
	
	
	$result = phpAds_dbQuery("
		SELECT
			COUNT(*) AS sum_clicks
		FROM
			".$phpAds_config['tbl_adclicks']."
		WHERE
			bannerid = ".$bannerid."
	");
	
	if ($row = phpAds_dbFetchArray($result))
	{
		$totals['clicks'] = $row['sum_clicks'];
	}
	
	
	// Get stats for selected period
	$begin = date('YmdHis', mktime(0, 0, 0, date('m'), date('d') - $limit + 1 - $start, date('Y')));
	$end   = date('YmdHis', mktime(0, 0, 0, date('m'), date('d') + 1 - $start, date('Y')));
	
	$result = phpAds_dbQuery("
		SELECT
			COUNT(*) AS sum_views,
			DATE_FORMAT(t_stamp, '$date_format') AS date_formatted,
			DATE_FORMAT(t_stamp, '%Y%m%d') AS date
		FROM
			".$phpAds_config['tbl_adviews']."
		WHERE
			bannerid = $bannerid AND
			t_stamp >= $begin AND t_stamp < $end
		GROUP BY
			date
		LIMIT 
			$limit
	");
	
	while ($row = phpAds_dbFetchArray($result))
	{
		$stats[$row['date']]['sum_views'] = $row['sum_views'];
		$stats[$row['date']]['sum_clicks'] = '0';
		$stats[$row['date']]['date_formatted'] = $row['date_formatted'];
	}
	
	
	$result = phpAds_dbQuery("
		SELECT
			COUNT(*) AS sum_clicks,
			DATE_FORMAT(t_stamp, '$date_format') AS date_formatted,
			DATE_FORMAT(t_stamp, '%Y%m%d') AS date
		FROM
			".$phpAds_config['tbl_adclicks']."
		WHERE
			bannerid = $bannerid AND
			t_stamp >= $begin AND t_stamp < $end
		GROUP BY
			date
		LIMIT 
			$limit
	");
	
	while ($row = phpAds_dbFetchArray($result))
	{
		$stats[$row['date']]['sum_clicks'] = $row['sum_clicks'];
		$stats[$row['date']]['date_formatted'] = $row['date_formatted'];
	}
}

echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";

echo "<tr bgcolor='#FFFFFF' height='25'>";
echo "<td align='left' nowrap height='25'><b>$strDays</b></td>";
echo "<td align='left' nowrap height='25'><b>$strViews</b></td>";
echo "<td align='left' nowrap height='25'><b>$strClicks</b></td>";
echo "<td align='left' nowrap height='25'><b>$strCTRShort</b>&nbsp;&nbsp;</td>";
echo "</tr>";

echo "<tr><td height='1' colspan='4' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";


$totalviews  = 0;
$totalclicks = 0;
$today = time();

for ($d=0;$d<$limit;$d++)
{
	$key = date ("Ymd", $today - ((60 * 60 * 24) * ($d + $start)));
	$text = date (str_replace ("%", "", $date_format), $today - ((60 * 60 * 24) * ($d + $start)));
	
	if (isset($stats[$key]))
	{
		$views  = $stats[$key]['sum_views'];
		$clicks = $stats[$key]['sum_clicks'];
		$text   = $stats[$key]['date_formatted'];
		$ctr	= phpAds_buildCTR($views, $clicks);
		
		$totalviews  += $views;
		$totalclicks += $clicks;
		
		$available = true;
	}
	else
	{
		if ($d + $start < $span)
		{
			$views  = 0;
			$clicks = 0;
			$ctr	= phpAds_buildCTR($views, $clicks);
			$available = true;
		}
		else
		{
			$views  = '-';
			$clicks = '-';
			$ctr	= '-';
			$available = false;
		}
	}
	
	$bgcolor="#FFFFFF";
	$d % 2 ? 0: $bgcolor= "#F6F6F6";
	
	echo "<tr>";
	
	echo "<td height='25' bgcolor='$bgcolor'>&nbsp;";
	echo "<img src='images/icon-time.gif' align='absmiddle'>&nbsp;";
	
	if ($available)
		echo "<a href='stats-daily.php?day=".$key."&campaignid=".$campaignid."&bannerid=".$bannerid."'>".$text."</a></td>";
	else
		echo $text."</td>";
	
	echo "<td height='25' bgcolor='$bgcolor'>".$views."</td>";
	echo "<td height='25' bgcolor='$bgcolor'>".$clicks."</td>";
	echo "<td height='25' bgcolor='$bgcolor'>".$ctr."</td>";
	echo "</tr>";
	
	echo "<tr><td height='1' colspan='4' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
}


$previous = $start < $limit ? 0 : $start - $limit;
$next = $start + $limit;

echo "<tr>";
echo "<td height='35' colspan='1' align='left'>";
	echo "&nbsp;".$strDays.":&nbsp;";
	echo "<a href='stats-details.php?campaignid=".$campaignid."&bannerid=".$bannerid."&start=".$start."&limit=7'>7</a>&nbsp;|&nbsp;";
	echo "<a href='stats-details.php?campaignid=".$campaignid."&bannerid=".$bannerid."&start=".$start."&limit=14'>14</a>&nbsp;|&nbsp;";
	echo "<a href='stats-details.php?campaignid=".$campaignid."&bannerid=".$bannerid."&start=".$start."&limit=21'>21</a>&nbsp;|&nbsp;";
	echo "<a href='stats-details.php?campaignid=".$campaignid."&bannerid=".$bannerid."&start=".$start."&limit=28'>28</a>";
echo "</td>";
echo "<td height='35' colspan='3' align='right'>";
	if ($start > 0)
	{
		echo "<a href='stats-details.php?campaignid=$campaignid&bannerid=$bannerid&limit=$limit&start=$previous'>";
		echo "<img src='images/arrow-l.gif' border='0' align='absmiddle'>".$strPrevious."</a>";
	}
	if ($span > ($start + $limit))
	{
		if ($start > 0) echo "&nbsp;|&nbsp;";
		
		echo "<a href='stats-details.php?campaignid=$campaignid&bannerid=$bannerid&limit=$limit&start=$next'>";
		echo $strNext."<img src='images/arrow-r.gif' border='0' align='absmiddle'></a>";
	}
echo "</td>";
echo "</tr>";


echo "<tr>";
echo "<td height='25'>&nbsp;</td>";
echo "<td height='25'>&nbsp;</td>";
echo "<td height='25'>&nbsp;</td>";
echo "<td height='25'>&nbsp;</td>";
echo "</tr>";

echo "<tr>";
echo "<td height='25'>&nbsp;<b>$strTotalThisPeriod</b></td>";
echo "<td height='25'>".(int)$totalviews."&nbsp(".number_format(($totals['views'] ? $totalviews / $totals['views'] * 100 : 0), $phpAds_config['percentage_decimals'])."%)</td>";
echo "<td height='25'>".(int)$totalclicks."&nbsp(".number_format(($totals['clicks'] ? $totalclicks / $totals['clicks'] * 100 : 0), $phpAds_config['percentage_decimals'])."%)</td>";
echo "<td height='25'>".phpAds_buildCTR($totalviews, $totalclicks)."</td>";
echo "</tr>";

echo "<tr><td height='1' colspan='4' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";

echo "<tr>";
echo "<td height='25'>&nbsp;$strAverageThisPeriod</td>";
echo "<td height='25'>".number_format (($totalviews / $d), $phpAds_config['percentage_decimals'])."</td>";
echo "<td height='25'>".number_format (($totalclicks / $d), $phpAds_config['percentage_decimals'])."</td>";
echo "<td height='25'>&nbsp;</td>";
echo "</tr>";

echo "<tr><td height='1' colspan='4' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";

echo "<tr>";
echo "<td height='25'>&nbsp;<b>$strTotal</b></td>";
echo "<td height='25'>".(int)$totals['views']."</td>";
echo "<td height='25'>".(int)$totals['clicks']."</td>";
echo "<td height='25'>".phpAds_buildCTR($totals['views'], $totals['clicks'])."</td>";
echo "</tr>";

echo "<tr><td height='1' colspan='4' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";

echo "<tr>";
echo "<td height='25'>&nbsp;$strAverage</td>";
echo "<td height='25'>".number_format (($span ? $totals['views'] / $span : 0), $phpAds_config['percentage_decimals'])."</td>";
echo "<td height='25'>".number_format (($span ? $totals['clicks'] / $span : 0), $phpAds_config['percentage_decimals'])."</td>";
echo "<td height='25'>&nbsp;</td>";
echo "</tr>";

echo "<tr><td height='1' colspan='4' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";



if (($totalviews > 0 || $totalclicks > 0) && $start == 0)
{
	if (phpAds_GDImageFormat() != "none") 
	{
		echo "<tr><td colspan='4' align='left' bgcolor='#FFFFFF'>";
		echo "<br><br><br><br><img src='graph-details.php?bannerid=$bannerid&campaignid=$campaignid&limit=$limit'><br><br>";
		echo "</td></tr>";
		echo "<tr><td height='1' colspan='4' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
	}
}

echo "</table>";
echo "<br><br>";



/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

phpAds_PageFooter();

?>
