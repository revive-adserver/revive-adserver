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
/* Main code                                             */
/*********************************************************/


echo "<img src='images/icon-client.gif' align='absmiddle'>&nbsp;".phpAds_getParentName($campaignID);
echo "&nbsp;<img src='images/caret-rs.gif'>&nbsp;";
echo "<img src='images/icon-campaign.gif' align='absmiddle'>&nbsp;<b>".phpAds_getClientName($campaignID)."</b>";

echo "<br><br>";
echo "<br><br>";
echo "<br><br>";



if (!isset($limit) || $limit=='') $limit = '7';


// Get bannerID's for this client
$idresult = db_query (" SELECT
						bannerID
					  FROM
					  	$phpAds_tbl_banners
					  WHERE
						clientID = $campaignID
					");

while ($row = mysql_fetch_array($idresult))
{
	$bannerIDs[] = "bannerID = ".$row['bannerID'];
}


if ($phpAds_compact_stats) 
{
	$result = db_query(" SELECT
							*,
							sum(views) as sum_views,
							sum(clicks) as sum_clicks,
							DATE_FORMAT(day, '$date_format') as t_stamp_f
				 		 FROM
							$phpAds_tbl_adstats
						 WHERE
							(".implode(' OR ', $bannerIDs).")
						 GROUP BY
						 	day
						 ORDER BY
							day DESC
						 LIMIT $limit 
			  ") or mysql_die();
	
	//mysql_die();
	while ($row = mysql_fetch_array($result))
	{
		$stats[$row['day']] = $row;
	}
}
else
{
	$result = db_query(" SELECT
							count(*) as views,
							DATE_FORMAT(t_stamp, '$date_format') as t_stamp_f,
							DATE_FORMAT(t_stamp, '%Y-%m-%d') as day
				 		 FROM
							$phpAds_tbl_adviews
						 WHERE
							(".implode(' OR ', $bannerIDs).")
						 GROUP BY
						    day
						 ORDER BY
							day DESC
						 LIMIT $limit 
			  ");
	
	while ($row = mysql_fetch_array($result))
	{
		$stats[$row['day']]['sum_views'] = $row['views'];
		$stats[$row['day']]['sum_clicks'] = '0';
		$stats[$row['day']]['t_stamp_f'] = $row['t_stamp_f'];
	}
	
	
	$result = db_query(" SELECT
							count(*) as clicks,
							DATE_FORMAT(t_stamp, '$date_format') as t_stamp_f,
							DATE_FORMAT(t_stamp, '%Y-%m-%d') as day
				 		 FROM
							$phpAds_tbl_adclicks
						 WHERE
							(".implode(' OR ', $bannerIDs).")
						 GROUP BY
						    day
						 ORDER BY
							day DESC
						 LIMIT $limit 
			  ");
	
	while ($row = mysql_fetch_array($result))
	{
		$stats[$row['day']]['sum_clicks'] = $row['clicks'];
		$stats[$row['day']]['t_stamp_f'] = $row['t_stamp_f'];
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
	$key = date ("Y-m-d", $today - ((60 * 60 * 24) * $d));
	$text = date (str_replace ("%", "", $date_format), $today - ((60 * 60 * 24) * $d));
	
	if (isset($stats[$key]))
	{
		$views  = $stats[$key]['sum_views'];
		$clicks = $stats[$key]['sum_clicks'];
		$text   = $stats[$key]['t_stamp_f'];
		$ctr	= phpAds_buildCTR($views, $clicks);
		
		$totalviews  += $views;
		$totalclicks += $clicks;
		
		$available = true;
	}
	else
	{
		$views  = '-';
		$clicks = '-';
		$ctr	= '-';
		$available = false;
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
	echo "<td height='25'>".number_format (($totalviews / $d), $phpAds_percentage_decimals)."</td>";
	echo "<td height='25'>".number_format (($totalclicks / $d), $phpAds_percentage_decimals)."</td>";
	echo "<td height='25'>&nbsp;</td>";
	echo "</tr>";
	
	echo "<tr><td height='1' colspan='4' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
}

echo "<tr>";
echo "<form action='".$GLOBALS['PHP_SELF']."'>";
echo "<td height='35' colspan='4' align='right'>";
	echo $strHistory.":&nbsp;&nbsp;";
	echo "<input type='hidden' name='campaignID' value='$campaignID'>";
	echo "<input type='hidden' name='section' value='$section'>";
	echo "<select name='limit' onChange=\"this.form.submit();\">";
	echo "<option value='7' ".($limit==7?'selected':'').">7 ".$strDays."</option>";
	echo "<option value='14' ".($limit==14?'selected':'').">14 ".$strDays."</option>";
	echo "<option value='21' ".($limit==21?'selected':'').">21 ".$strDays."</option>";
	echo "<option value='28' ".($limit==28?'selected':'').">28 ".$strDays."</option>";
	echo "</select>&nbsp;";
	echo "<input type='image' src='images/go_blue.gif' border='0' name='submit'>";
echo "</td>";
echo "</form>";
echo "</tr>";
echo "</table>";

if (phpAds_isUser(phpAds_Admin))
{
	echo "<br><br>";

	echo "<table width='100%' border='0' align='center' cellspacing='0' cellpadding='0'>";
	echo "<tr><td height='25'><b>$strMaintenance</b></td></tr>";
  	echo "<tr><td height='1' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
	
	// Reset statistics
	echo "<tr><td height='25'>";
	echo "<a href='stats-reset.php?campaignID=$campaignID'".phpAds_DelConfirm($strConfirmResetCampaignStats).">";
	echo "<img src='images/icon-undo.gif' align='absmiddle' border='0'>&nbsp;$strResetStats</a>";
	echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
	echo "</td></tr>";
	
	echo "</table>";
}