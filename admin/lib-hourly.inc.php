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




/*********************************************************/
/* Show hourly statistics                                */
/*********************************************************/

if ($phpAds_config['compact_stats'])
{
	$result = phpAds_dbQuery("
		SELECT
			hour,
			SUM(views) AS views,
			SUM(clicks) AS clicks
		FROM
			".$phpAds_config['tbl_adstats']."
		WHERE
			day = ".$day."
			".(isset($lib_hourly_where) ? 'AND '.$lib_hourly_where : '')."
		GROUP BY 
			hour
	") or phpAds_sqlDie();
	
	
	while ($row = phpAds_dbFetchArray($result))
	{
		$views[$row['hour']] = $row['views'];
		$clicks[$row['hour']] = $row['clicks'];
	}
}
else
{
	$begin = date('YmdHis', mktime(0, 0, 0, substr($day, 4, 2), substr($day, 6, 2), substr($day, 0, 4)));
	$end   = date('YmdHis', mktime(0, 0, 0, substr($day, 4, 2), substr($day, 6, 2) + 1, substr($day, 0, 4)));
	
	$result = phpAds_dbQuery("
		SELECT
			HOUR(t_stamp) AS hour,
			COUNT(*) AS qnt
		FROM
			".$phpAds_config['tbl_adviews']."
		WHERE
			t_stamp >= $begin AND t_stamp < $end
			".(isset($lib_hourly_where) ? 'AND '.$lib_hourly_where : '')."
		GROUP BY 
			hour
	") or phpAds_sqlDie();
	
	
	while ($row = phpAds_dbFetchArray($result))
	{
		$views[$row['hour']] = $row['qnt'];
	}
	
	
	$result = phpAds_dbQuery("
		SELECT
			HOUR(t_stamp) AS hour,
			COUNT(*) AS qnt
		FROM
			".$phpAds_config['tbl_adclicks']."
		WHERE
			t_stamp >= $begin AND t_stamp < $end
			".(isset($lib_hourly_where) ? 'AND '.$lib_hourly_where : '')."
		GROUP BY 
			hour
	") or phpAds_sqlDie();
	
	
	while ($row = phpAds_dbFetchArray($result))
	{
		$clicks[$row['hour']] = $row['qnt'];
	}
}

echo "<br><br>";

echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";
echo "<tr bgcolor='#FFFFFF' height='25'>";
echo "<td align='".$phpAds_TextAlignLeft."' nowrap height='25'><b>$strHour</b></td>";
echo "<td align='".$phpAds_TextAlignLeft."' nowrap height='25'><b>$strViews</b></td>";
echo "<td align='".$phpAds_TextAlignLeft."' nowrap height='25'><b>$strClicks</b></td>";
echo "<td align='".$phpAds_TextAlignLeft."' nowrap height='25'><b>$strCTRShort</b>&nbsp;&nbsp;</td>";
echo "</tr>";

echo "<tr><td height='1' colspan='4' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";

$totalviews = 0;
$totalclicks = 0;

for ($i=0; $i<24; $i++)
{
	$bgcolor = ($i % 2 ? "#FFFFFF": "#F6F6F6");
	
	if (isset($views[$i]) && isset($clicks[$i]))
	{
		$ctr = phpAds_buildCTR($views[$i], $clicks[$i]);
		$totalviews += $views[$i];
	}
	else
	{
		$ctr = '-';
		$views[$i] = '-';
	}
	
	if (isset($clicks[$i]))
		$totalclicks += $clicks[$i];
	else
		$clicks[$i] = '-';
	
	echo "<tr>";
	echo "<td height='25' bgcolor='$bgcolor'>&nbsp;".$i.":00 - ".$i.":59</td>";
	echo "<td height='25' bgcolor='$bgcolor'>".$views[$i]."</td>";
	echo "<td height='25' bgcolor='$bgcolor'>".$clicks[$i]."</td>";
	echo "<td height='25' bgcolor='$bgcolor'>".$ctr."</td>";
	echo "</tr>";
	
	echo "<tr><td height='1' colspan='4' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
}

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
	echo "<td height='25'>".number_format (($totalviews / 24), $phpAds_config['percentage_decimals'])."</td>";
	echo "<td height='25'>".number_format (($totalclicks / 24), $phpAds_config['percentage_decimals'])."</td>";
	echo "<td height='25'>&nbsp;</td>";
	echo "</tr>";
	
	echo "<tr><td height='1' colspan='4' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
}

echo "</table>";
echo "<br><br>";


?>