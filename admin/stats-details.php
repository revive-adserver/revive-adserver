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
/* Client interface security                             */
/*********************************************************/

if (phpAds_isUser(phpAds_Admin))
{
	phpAds_PageHeader($strDetailStats);
}

if (phpAds_isUser(phpAds_Client))
{
	phpAds_PageHeader($strDetailStats);
	
	$result = db_query("
		SELECT
			clientID
		FROM
			$phpAds_tbl_banners
		WHERE
			bannerID = $GLOBALS[bannerID]
		") or mysql_die();
	$row = mysql_fetch_array($result);
	
	if($row["clientID"] != phpAds_clientID())
	{
		phpAds_ShowNav("2.1");
		php_die ($strAccessDenied, $strNotAdmin);
	}
	else
	{
		$clientID = phpAds_clientID();
	}
}



/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

$res = db_query("
SELECT
	*
FROM
	$phpAds_tbl_banners
WHERE
	clientID = $GLOBALS[clientID]
") or mysql_die();

while ($row = mysql_fetch_array($res))
{
	if ($bannerID == $row[bannerID])
		$extra .= "&nbsp;&nbsp;&nbsp;<img src='images/box-1.gif'>&nbsp;";
	else
		$extra .= "&nbsp;&nbsp;&nbsp;<img src='images/box-0.gif'>&nbsp;";
	
	$extra .= "<a href='stats-details.php?clientID=$clientID&bannerID=$row[bannerID]'>";
	$extra .= phpAds_buildBannerName ($row[bannerID], $row[description], $row[alt]);
	$extra .= "</a>";
	$extra .= "<br>"; 
}
$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";


if (phpAds_isUser(phpAds_Admin))
{
	$extra .= "<br><br><br><br><br>";
	$extra .= "<b>$strShortcuts</b><br>";
	$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
	$extra .= "<img src='images/caret-rs.gif'>&nbsp;<a href=banner-client.php?clientID=$clientID>$strBannerAdmin</a><br>";
	$extra .= "&nbsp;&nbsp;&nbsp;<img src='images/caret-rs.gif'>&nbsp;<a href=banner-edit.php?clientID=$clientID&bannerID=$bannerID>$strModifyBanner</a><br>";
	$extra .= "&nbsp;&nbsp;&nbsp;<img src='images/caret-rs.gif'>&nbsp;<a href=banner-acl.php?clientID=$clientID&bannerID=$bannerID>$strModifyBannerAcl</a><br>";
	$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
	$extra .= "<img src='images/caret-rs.gif'>&nbsp;<a href=client-edit.php?clientID=$clientID>$strModifyClient</a><br>";
	$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
	
	phpAds_ShowNav("1.4.1", $extra);
}

if (phpAds_isUser(phpAds_Client))
{
	phpAds_ShowNav("2.1", $extra);
}



/*********************************************************/
/* Show detailed statistics                              */
/*********************************************************/

function showDetailedStats($what, $totalTitle, $avgTitle)
{
	global $phpAds_db, $date_format, $phpAds_url_prefix, $pageid, $fncpageid;
	global $phpAds_compact_stats, $phpAds_tbl_adviews, $phpAds_tbl_adclicks, $phpAds_tbl_adstats;

	if (!$phpAds_compact_stats)
	{
		if ($what == "views")
			$table = $phpAds_tbl_adviews;
		else
			$table = $phpAds_tbl_adclicks;
		
		$stats_query = " SELECT
							*,
							count(*) as qnt,
							DATE_FORMAT(t_stamp, '$date_format') as t_stamp_f
				 		 FROM
							$table
						 WHERE
							bannerID = $GLOBALS[bannerID]
						 GROUP BY
							t_stamp_f  
						 ORDER BY
							t_stamp DESC
						 LIMIT 7          
		";
	}
	else
		$stats_query = " SELECT
							*,
							$what as qnt,
							DATE_FORMAT(day, '$date_format') as t_stamp_f
				 		 FROM
							$phpAds_tbl_adstats
						 WHERE
							bannerID = $GLOBALS[bannerID]
						 ORDER BY
							day DESC
						 LIMIT 7          
		";

	$result = db_query($stats_query) or mysql_die();

	$max = 0;
	$total = 0;
	while ($row = mysql_fetch_array($result))
	{
		if ($row["qnt"] > $max) 
			$max = $row["qnt"];
		$total += $row["qnt"];
	}
	@mysql_data_seek($result, 0);
	$i = 0;
	while ($row = mysql_fetch_array($result))
	{
		$bgcolor="#FFFFFF";
		$i % 2 ? 0: $bgcolor= "#F6F6F6";
		$i++;
		?>
		<tr>
			<td height='25' bgcolor="<?echo $bgcolor;?>">
				&nbsp;<?echo "$row[t_stamp_f]";?>
			</td>
			<td height='25' bgcolor="<?echo $bgcolor;?>" align='right'>
				<b><?echo $row["qnt"];?></b>&nbsp;&nbsp;&nbsp;
			</td>
			<td height='25' bgcolor="<?echo $bgcolor;?>">
				<img src="images/bar.gif" width="<?echo ($row["qnt"]*300)/$max;?>" height="11"><img src="images/bar_off.gif" width="<?echo 300-(($row["qnt"]*300)/$max);?>" height="11">
			</td>
			<td height='25' bgcolor="<?echo $bgcolor;?>" align='right'>
				<?	if (!$phpAds_compact_stats) { ?>
				<a href="stats-daily.php?day=<?echo urlencode($row["t_stamp_f"]);?>&clientID=<?echo $GLOBALS["clientID"];?>&bannerID=<?echo $GLOBALS["bannerID"];?>">[ <?echo $GLOBALS["strDailyStats"];?> ]</a>&nbsp;
				<? } ?>				
			</td>
		</tr>
  	    <tr><td height='1' colspan='4' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>
		<?
	}
	?>
	<tr>
		<td height='60' bgcolor="#FFFFFF" colspan=4>
			<br>
			<?echo $totalTitle;?>: <b><?echo $total;?></b><br>
			<?echo $avgTitle;?>: <b><? printf("%.2f", $total/7);?></b>
		</td>
	</tr>
	<tr><td height='1' colspan='4' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>
	<?
}



/*********************************************************/
/* Main code                                             */
/*********************************************************/

?>

<table width='100%' border="0" align="center" cellspacing="0" cellpadding="0">
  <tr><td height='25' colspan='4'>
  	<b><?echo $strBanner.': '.phpAds_getBannerName($bannerID);?></b>
	<img src='images/caret-rs.gif'>
	<?echo $strClientName.': '.phpAds_getClientName($clientID);?>
  </td></tr>
  <tr><td height='1' colspan='4' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>
  <tr><td colspan='4' align='left'><br><?echo phpAds_getBannerCode($bannerID);?><br><br></td></tr>
</table>

<br><br>

<table width='100%' border="0" align="center" cellspacing="0" cellpadding="0">
  <tr><td height='25' colspan='4'><b><?print $strViews;?></b></td></tr>
  <tr><td height='1' colspan='4' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>
  <? showDetailedStats("views", $strTotalViews7Days, $strAvgViews7Days); ?>
</table>

<br><br>

<table width='100%' border="0" align="center" cellspacing="0" cellpadding="0">
  <tr><td height='25' colspan='4'><b><?print $strClicks;?></b></td></tr>
  <tr><td height='1' colspan='4' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>
  <? showDetailedStats("clicks", $strTotalClicks7Days, $strAvgClicks7Days); ?>
</table>



<?

/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

phpAds_PageFooter();

?>
