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
require ("lib-expiration.inc.php");
require ("lib-gd.inc.php");


// Security check
phpAds_checkAccess(phpAds_Admin+phpAds_Affiliate);



/*********************************************************/
/* Affiliate interface security                          */
/*********************************************************/

if (phpAds_isUser(phpAds_Affiliate))
{
	if (isset($zoneid) && $zoneid > 0)
	{
		$result = phpAds_dbQuery("
			SELECT
				affiliateid
			FROM
				".$phpAds_config['tbl_zones']."
			WHERE
				zoneid = '$zoneid'
			") or phpAds_sqlDie();
		$row = phpAds_dbFetchArray($result);
		
		if ($row["affiliateid"] == '' || phpAds_getUserID() != $row["affiliateid"])
		{
			phpAds_PageHeader("1");
			phpAds_Die ($strAccessDenied, $strNotAdmin);
		}
		else
		{
			$affiliateid = phpAds_getUserID();
		}
	}
	else
	{
		phpAds_PageHeader("1");
		phpAds_Die ($strAccessDenied, $strNotAdmin);
	}
}



/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

if (phpAds_isUser(phpAds_Admin))
{
	$extra = '';
	
	if ($phpAds_config['compact_stats'])
	{
		$res = phpAds_dbQuery("
			SELECT
				DISTINCT bannerid
			FROM
				".$phpAds_config['tbl_adstats']."
			WHERE
				zoneid = ".$zoneid."
		") or phpAds_sqlDie();
	}
	else
	{
		$res = phpAds_dbQuery("
			SELECT
				DISTINCT bannerid
			FROM
				".$phpAds_config['tbl_adviews']."
			WHERE
				zoneid = ".$zoneid."
		") or phpAds_sqlDie();
	}
	
	while ($row = phpAds_dbFetchArray($res))
	{
		if ($bannerid == $row['bannerid'])
			$extra .= "&nbsp;&nbsp;&nbsp;<img src='images/box-1.gif'>&nbsp;";
		else
			$extra .= "&nbsp;&nbsp;&nbsp;<img src='images/box-0.gif'>&nbsp;";
		
		$extra .= "<a href=stats-linkedbanner-history.php?affiliateid=".$affiliateid."&zoneid=".$zoneid."&bannerid=".$row['bannerid'].">".phpAds_getBannerName ($row['bannerid'])."</a>";
		$extra .= "<br>"; 
	}
	$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
	
	
	phpAds_PageHeader("2.4.2.2.1", $extra);
		echo "<img src='images/icon-affiliate.gif' align='absmiddle'>&nbsp;".phpAds_getAffiliateName($affiliateid);
		echo "&nbsp;<img src='images/caret-rs.gif'>&nbsp;";
		echo "<img src='images/icon-zone.gif' align='absmiddle'>&nbsp;".phpAds_getZoneName($zoneid);
		echo "&nbsp;<img src='images/caret-rs.gif'>&nbsp;";
		echo "<img src='images/icon-zone-linked.gif' align='absmiddle'>&nbsp;<b>".phpAds_getBannerName($bannerid)."</b><br><br><br>";
		phpAds_ShowSections(array("2.4.2.2.1"));
}
else
{
	phpAds_PageHeader("1.1.2.1");
		echo "<img src='images/icon-affiliate.gif' align='absmiddle'>&nbsp;".phpAds_getAffiliateName($affiliateid);
		echo "&nbsp;<img src='images/caret-rs.gif'>&nbsp;";
		echo "<img src='images/icon-zone.gif' align='absmiddle'>&nbsp;".phpAds_getZoneName($zoneid);
		echo "&nbsp;<img src='images/caret-rs.gif'>&nbsp;";
		echo "<img src='images/icon-zone-linked.gif' align='absmiddle'>&nbsp;<b>".phpAds_getBannerName($bannerid)."</b><br><br><br>";
		phpAds_ShowSections(array("1.1.2.1"));
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
			zoneid = ".$zoneid." AND
			bannerid = ".$bannerid."
	");
	
	if ($row = phpAds_dbFetchArray($result))
	{
		$span = $row['span'];
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
			zoneid = ".$zoneid." AND
			bannerid = ".$bannerid." AND
			day >= $begin AND day < $end
		GROUP BY
			day
		LIMIT
			$limit
	") or phpAds_sqlDie();
	
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
			zoneid = ".$zoneid." AND
			bannerid = ".$bannerid."
	");
	
	if ($row = phpAds_dbFetchArray($result))
	{
		$span = $row['span'];
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
			zoneid = ".$zoneid." AND
			bannerid = ".$bannerid." AND
			t_stamp >= $begin AND t_stamp < $end
		GROUP BY
			day
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
			zoneid = ".$zoneid." AND
			bannerid = ".$bannerid." AND
			t_stamp >= $begin AND t_stamp < $end
		GROUP BY
			day
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
	
	echo "<td height='25' bgcolor='$bgcolor'>&nbsp;".$text."</td>";
	
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
	echo "<a href='stats-linkedbanner-history.php?affiliateid=".$affiliateid."&zoneid=".$zoneid."&bannerid=".$bannerid."&start=".$start."&limit=7'>7</a>&nbsp;|&nbsp;";
	echo "<a href='stats-linkedbanner-history.php?affiliateid=".$affiliateid."&zoneid=".$zoneid."&bannerid=".$bannerid."&start=".$start."&limit=14'>14</a>&nbsp;|&nbsp;";
	echo "<a href='stats-linkedbanner-history.php?affiliateid=".$affiliateid."&zoneid=".$zoneid."&bannerid=".$bannerid."&start=".$start."&limit=21'>21</a>&nbsp;|&nbsp;";
	echo "<a href='stats-linkedbanner-history.php?affiliateid=".$affiliateid."&zoneid=".$zoneid."&bannerid=".$bannerid."&start=".$start."&limit=28'>28</a>";
echo "</td>";
echo "<td height='35' colspan='3' align='right'>";
	if ($start > 0)
	{
		echo "<a href='stats-linkedbanner-history.php?affiliateid=".$affiliateid."&zoneid=".$zoneid."&bannerid=".$bannerid."&limit=".$limit."&start=".$previous."'>";
		echo "<img src='images/arrow-l.gif' border='0' align='absmiddle'>".$strPrevious."</a>";
	}
	if ($span > ($start + $limit))
	{
		if ($start > 0) echo "&nbsp;|&nbsp;";
		
		echo "<a href='stats-linkedbanner-history.php?affiliateid=".$affiliateid."&zoneid=".$zoneid."&bannerid=".$bannerid."&limit=".$limit."&start=".$next."'>";
		echo $strNext."<img src='images/arrow-r.gif' border='0' align='absmiddle'></a>";
	}
echo "</td>";
echo "</tr>";


if ($totalviews > 0 || $totalclicks > 0)
{
	echo "<tr>";
	echo "<td height='25'>&nbsp;</td>";
	echo "<td height='25'>&nbsp;</td>";
	echo "<td height='25'>&nbsp;</td>";
	echo "<td height='25'>&nbsp;</td>";
	echo "</tr>";
	
	echo "<tr>";
	echo "<td height='25'>&nbsp;<b>$strTotal</b></td>";
	echo "<td height='25'>".$totalviews."</td>";
	echo "<td height='25'>".$totalclicks."</td>";
	echo "<td height='25'>".phpAds_buildCTR($totalviews, $totalclicks)."</td>";
	echo "</tr>";
	
	echo "<tr><td height='1' colspan='4' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
	
	echo "<tr>";
	echo "<td height='25'>&nbsp;<b>$strAverage</b></td>";
	echo "<td height='25'>".number_format (($totalviews / $d), $phpAds_config['percentage_decimals'])."</td>";
	echo "<td height='25'>".number_format (($totalclicks / $d), $phpAds_config['percentage_decimals'])."</td>";
	echo "<td height='25'>&nbsp;</td>";
	echo "</tr>";
	
	echo "<tr><td height='1' colspan='4' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
}

echo "</table>";



/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

phpAds_PageFooter();

?>