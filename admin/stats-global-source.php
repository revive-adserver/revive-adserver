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


// Security check
phpAds_checkAccess(phpAds_Admin+phpAds_Client);



/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

if (phpAds_isUser(phpAds_Admin))
{
	phpAds_PageHeader("2.3");
	phpAds_ShowSections(array("2.1", "2.4", "2.3", "2.2"));
}
else
{
	phpAds_PageHeader("1");
}

/*********************************************************/
/* Main code                                             */
/*********************************************************/

$res_source=phpAds_dbQuery("
	SELECT
		DISTINCT(source)
	FROM
		".$phpAds_config['tbl_adviews']."
	ORDER BY
		source ".phpAds_getOrderDirection($orderdirection)."
	") or phpAds_sqlDie();

?>
<script language="JavaScript">
<!--
function goto_source()
{
	s = document.source_selection.source.selectedIndex;
	s = document.source_selection.source.options[s].value;
	document.location='stats-global-source.php?source=' + s;
}
// -->
</script>

<?
echo "<form name='source_selection'>";

echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";
echo "<tr><td height='25' colspan='3'><b>".$strSelectSource."</b></td></tr>";
echo "<tr><td height='25'>";

echo "<select name='source' onChange='goto_source();'>\n";
while ($row_source = phpAds_dbFetchArray($res_source))
{
	if (!isset($source))
    	$source=$row_source['source'];
	echo "<OPTION value='".$row_source['source']."'";
	if ($source == $row_source['source'])
		echo " SELECTED";
    echo ">";
	if ($row_source['source'] == '')
		echo $strNone;
	else
		echo $row_source['source'];
	echo "</option>";
}
echo "</select>&nbsp;";
echo "<a href='javascript:void(0)' onClick='goto_source();'><img src='images/$phpAds_TextDirection/go_blue.gif' border='0'></a><br><br>\n";

echo "</td></tr>";
echo "</table>";
phpAds_ShowBreak();
echo "</form>";
echo "<br>";


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
			sum(views) AS sum_views,
			sum(clicks) AS sum_clicks,
			DATE_FORMAT(day, '$date_format') AS date_formatted,
			DATE_FORMAT(day, '%Y%m%d') AS date
		FROM
			".$phpAds_config['tbl_adstats']."
		WHERE
			day >= $begin AND day < $end
			AND
			source = '$source'
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
			t_stamp >= $begin AND t_stamp < $end
			AND
			source = '$source'
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
			t_stamp >= $begin AND t_stamp < $end
			AND
			source = '$source'
		GROUP BY
			date
		ORDER BY
			date DESC
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
echo "<td align='".$phpAds_TextAlignLeft."' nowrap height='25'><b>$strDays</b></td>";
echo "<td align='".$phpAds_TextAlignLeft."' nowrap height='25'><b>$strViews</b></td>";
echo "<td align='".$phpAds_TextAlignLeft."' nowrap height='25'><b>$strClicks</b></td>";
echo "<td align='".$phpAds_TextAlignLeft."' nowrap height='25'><b>$strCTRShort</b>&nbsp;&nbsp;</td>";
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
echo "<td height='35' colspan='1' align='".$phpAds_TextAlignLeft."'>";
	echo "&nbsp;".$strDays.":&nbsp;";
	echo "<a href='stats-global-source.php?source=".$source."&start=".$start."&limit=7'>7</a>&nbsp;|&nbsp;";
	echo "<a href='stats-global-source.php?source=".$source."&start=".$start."&limit=14'>14</a>&nbsp;|&nbsp;";
	echo "<a href='stats-global-source.php?source=".$source."&start=".$start."&limit=21'>21</a>&nbsp;|&nbsp;";
	echo "<a href='stats-global-source.php?source=".$source."&start=".$start."&limit=28'>28</a>";
echo "</td>";
echo "<td height='35' colspan='3' align='".$phpAds_TextAlignRight."'>";
	if ($start > 0)
	{
		echo "<a href='stats-global-source.php?source=".$source."&limit=$limit&start=$previous'>";
		echo "<img src='images/arrow-l.gif' border='0' align='absmiddle'>".$strPrevious."</a>";
	}
	if ($span > ($start + $limit))
	{
		if ($start > 0) echo "&nbsp;|&nbsp;";
		
		echo "<a href='stats-global-source.php?source=".$source."&limit=$limit&start=$next'>";
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
echo "<br><br>";



/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

phpAds_PageFooter();

?>
