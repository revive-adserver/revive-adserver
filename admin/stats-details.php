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
	$extra .= "<img src='images/icon-client.gif' align='absmiddle'>&nbsp;<a href=client-edit.php?clientid=".phpAds_getParentID ($campaignid).">$strModifyClient</a><br>";
	$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
	$extra .= "<img src='images/icon-edit.gif' align='absmiddle'>&nbsp;<a href=campaign-edit.php?campaignid=$campaignid>$strModifyCampaign</a><br>";
	$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
	$extra .= "<img src='images/icon-campaign.gif' align='absmiddle'>&nbsp;<a href=campaign-index.php?campaignid=$campaignid>$strBanners</a><br>";
	$extra .= "<img src='images/break-el.gif' height='1' width='160' vspace='4'><br>";
	$extra .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src='images/icon-banner-stored.gif' align='absmiddle'>&nbsp;<a href=banner-edit.php?campaignid=$campaignid&bannerid=$bannerid>$strModifyBanner</a><br>";
		
	if ($phpAds_config['acl'])
	{
		$extra .= "<img src='images/break-el.gif' height='1' width='160' vspace='4'><br>";
		$extra .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src='images/icon-acl.gif' align='absmiddle'>&nbsp;<a href=banner-acl.php?campaignid=$campaignid&bannerid=$bannerid>$strModifyBannerAcl</a><br>";
	}
	$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
	
	phpAds_PageHeader("2.1.2.1", $extra);
	phpAds_ShowSections(array("2.1.2.1"));
}

if (phpAds_isUser(phpAds_Client))
{
	phpAds_PageHeader("1.1.1.1", $extra);
	phpAds_ShowSections(array("1.1.1.1"));
}



/*********************************************************/
/* Main code                                             */
/*********************************************************/


echo "<table width='100%' border='0' align='center' cellspacing='0' cellpadding='0'>";
echo "<tr><td height='25' colspan='4'>";

if (phpAds_isUser(phpAds_Admin))
{
	echo "<img src='images/icon-client.gif' align='absmiddle'>&nbsp;".phpAds_getParentName($campaignid);
	echo "&nbsp;<img src='images/caret-rs.gif'>&nbsp;";
}
echo "<img src='images/icon-campaign.gif' align='absmiddle'>&nbsp;".phpAds_getClientName($campaignid);
echo "&nbsp;<img src='images/caret-rs.gif'>&nbsp;";
echo "<img src='images/icon-banner-stored.gif' align='absmiddle'>&nbsp;<b>".phpAds_getBannerName($bannerid);

echo "</b></td></tr>";
echo "<tr><td height='1' colspan='4' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
echo "<tr><td colspan='4' align='left'><br>".phpAds_getBannerCode($bannerid)."</td></tr>";
echo "</table>";

echo "<br><br>";
echo "<br><br>";
echo "<br><br>";



if (!isset($limit) || $limit=='') $limit = '7';

if ($phpAds_config['compact_stats']) 
{
	$result = phpAds_dbQuery(" SELECT
							*,
							views,
							clicks,
							DATE_FORMAT(day, '$date_format') as t_stamp_f
				 		 FROM
							".$phpAds_config['tbl_adstats']."
						 WHERE
							bannerid = $bannerid
						 ORDER BY
							day DESC
						 LIMIT $limit 
			  ");
	
	while ($row = phpAds_dbFetchArray($result))
	{
		$stats[$row['day']] = $row;
	}
}
else
{
	$result = phpAds_dbQuery(" SELECT
							count(*) as views,
							DATE_FORMAT(t_stamp, '$date_format') as t_stamp_f,
							DATE_FORMAT(t_stamp, '%Y-%m-%d') as day
				 		 FROM
							".$phpAds_config['tbl_adviews']."
						 WHERE
							bannerid = $bannerid
						 GROUP BY
						    day
						 ORDER BY
							day DESC
						 LIMIT $limit 
			  ");
	
	while ($row = phpAds_dbFetchArray($result))
	{
		$stats[$row['day']]['views'] = $row['views'];
		$stats[$row['day']]['clicks'] = '0';
		$stats[$row['day']]['t_stamp_f'] = $row['t_stamp_f'];
	}
	
	
	$result = phpAds_dbQuery(" SELECT
							count(*) as clicks,
							DATE_FORMAT(t_stamp, '$date_format') as t_stamp_f,
							DATE_FORMAT(t_stamp, '%Y-%m-%d') as day
				 		 FROM
							".$phpAds_config['tbl_adclicks']."
						 WHERE
							bannerid = $bannerid
						 GROUP BY
						    day
						 ORDER BY
							day DESC
						 LIMIT $limit 
			  ");
	
	while ($row = phpAds_dbFetchArray($result))
	{
		$stats[$row['day']]['clicks'] = $row['clicks'];
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

// for (reset($stats);$key=key($stats);next($stats))	{

$today = time();

for ($d=0;$d<$limit;$d++)
{
	$key = date ("Y-m-d", $today - ((60 * 60 * 24) * $d));
	$text = date (str_replace ("%", "", $date_format), $today - ((60 * 60 * 24) * $d));
	
	if (isset($stats[$key]))
	{
		$views  = $stats[$key]['views'];
		$clicks = $stats[$key]['clicks'];
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
	
	if (!$phpAds_config['compact_stats'] && $available) 
	{
		echo "<td height='25' bgcolor='$bgcolor'>&nbsp;";
		echo "<a href='stats-daily.php?day=".urlencode($text)."&campaignid=".$campaignid."&bannerid=".$bannerid."'>";
		echo $text."</a></td>";
	}
	else
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
	echo "<td height='25'>".number_format (($totalviews / $d), $phpAds_config['percentage_decimals'])."</td>";
	echo "<td height='25'>".number_format (($totalclicks / $d), $phpAds_config['percentage_decimals'])."</td>";
	echo "<td height='25'>&nbsp;</td>";
	echo "</tr>";
	
	echo "<tr><td height='1' colspan='4' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
}

echo "<tr>";
echo "<form action='stats-details.php'>";
echo "<td height='35' colspan='4' align='right'>";
	echo $strHistory.":&nbsp;&nbsp;";
	echo "<input type='hidden' name='bannerid' value='$bannerid'>";
	echo "<input type='hidden' name='campaignid' value='$campaignid'>";
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

if ($totalviews > 0 || $totalclicks > 0)
{
	if (phpAds_GDImageFormat() != "none") 
	{
		echo "<tr><td colspan='4' align='left' bgcolor='#FFFFFF'>";
		echo "<br><br><img src='graph-details.php?bannerid=$bannerid&campaignid=$campaignid&limit=$limit'><br><br><br>";
		echo "</td></tr>";
	}
	
	echo "<tr><td height='1' colspan='4' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
}

echo "</table>";




/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

phpAds_PageFooter();

?>
