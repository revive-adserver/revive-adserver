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

if (phpAds_isUser(phpAds_Client))
{
	$result = phpAds_dbQuery("
		SELECT
			clientID
		FROM
			$phpAds_tbl_banners
		WHERE
			bannerID = $bannerID
		") or phpAds_sqlDie();
	$row = phpAds_dbFetchArray($result);
	
	if ($row["clientID"] == '' || phpAds_clientID() != phpAds_getParentID ($row["clientID"]))
	{
		phpAds_PageHeader("1");
		phpAds_Die ($strAccessDenied, $strNotAdmin);
	}
	else
	{
		$campaignID = $row["clientID"];
	}
}



/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

$extra = '';

$res = phpAds_dbQuery("
	 SELECT
		*,
		count(*) as qnt,
		DATE_FORMAT(t_stamp, '$date_format') as t_stamp_f
	 FROM
		$phpAds_tbl_adviews
	 WHERE
		bannerID = $bannerID
	 GROUP BY
		t_stamp_f
	 ORDER BY
		t_stamp DESC
	 LIMIT 7
") or phpAds_sqlDie();

while ($row = phpAds_dbFetchArray($res))
{
	if ($day == $row['t_stamp_f'])
		$extra .= "&nbsp;&nbsp;&nbsp;<img src='images/box-1.gif'>&nbsp;";
	else
		$extra .= "&nbsp;&nbsp;&nbsp;<img src='images/box-0.gif'>&nbsp;";
	
	$extra .= "<a href='stats-daily.php?day=".urlencode($row["t_stamp_f"])."&campaignID=$campaignID&bannerID=$bannerID'>".$row['t_stamp_f']."</a>";
	$extra .= "<br>"; 
}
$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";


if (phpAds_isUser(phpAds_Admin))
{
	$extra .= "<br><br><br><br><br>";
	$extra .= "<b>$strShortcuts</b><br>";
	$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
	$extra .= "<img src='images/icon-client.gif' align='absmiddle'>&nbsp;<a href=client-edit.php?clientID=".phpAds_getParentID ($campaignID).">$strModifyClient</a><br>";
	$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
	$extra .= "<img src='images/icon-edit.gif' align='absmiddle'>&nbsp;<a href=campaign-edit.php?campaignID=$campaignID>$strModifyCampaign</a><br>";
	$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
	$extra .= "<img src='images/icon-campaign.gif' align='absmiddle'>&nbsp;<a href=campaign-index.php?campaignID=$campaignID>$strBanners</a><br>";
	$extra .= "<img src='images/break-el.gif' height='1' width='160' vspace='4'><br>";
	$extra .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src='images/icon-banner-stored.gif' align='absmiddle'>&nbsp;<a href=banner-edit.php?campaignID=$campaignID&bannerID=$bannerID>$strModifyBanner</a><br>";
		
	if ($phpAds_acl == '1')
	{
		$extra .= "<img src='images/break-el.gif' height='1' width='160' vspace='4'><br>";
		$extra .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src='images/icon-acl.gif' align='absmiddle'>&nbsp;<a href=banner-acl.php?campaignID=$campaignID&bannerID=$bannerID>$strModifyBannerAcl</a><br>";
	}
	$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
	
	phpAds_PageHeader("2.1.2.1.1", $extra);
	phpAds_ShowSections(array("2.1.2.1.1"));
}

if (phpAds_isUser(phpAds_Client))
{
	phpAds_PageHeader("1.1.1.1.1", $extra);
	phpAds_ShowSections(array("1.1.1.1.1"));
}



/*********************************************************/
/* Show hourly statistics                                */
/*********************************************************/

function showHourlyStats($what)
{
	global $phpAds_db, $phpAds_url_prefix;
	$result = phpAds_dbQuery("
		SELECT
			*,
			DATE_FORMAT(t_stamp, '".$GLOBALS['time_format']."') as t_stamp_f,
			DATE_FORMAT(t_stamp, '%H') as hour,
			count(*) as qnt
		FROM
			$what
		WHERE
			bannerID = $GLOBALS[bannerID]
			AND DATE_FORMAT(t_stamp, '".$GLOBALS['date_format']."') = '".$GLOBALS['day']."'
		GROUP BY 
			hour
		") or phpAds_sqlDie();
	$max = 0;
	$total = 0;
	while ($row = phpAds_dbFetchArray($result))
	{
		if ($row["qnt"] > $max)
			$max = $row["qnt"];
		$total += $row["qnt"];
	}
	phpAds_dbSeekRow($result, 0);

	$i = 0;
	while ($row = phpAds_dbFetchArray($result))
	{
		$bgcolor="#FFFFFF";
		$i % 2 ? 0: $bgcolor= "#F6F6F6";
		$i++;       
		?>
		<tr>
			<td height='25' bgcolor="<?php print $bgcolor;?>">
				&nbsp;<?php print $row["hour"];?>:00
			</td>
			<td height='25' bgcolor="<?php print $bgcolor;?>" align='right'>
			    <b><?php print $row["qnt"];?></b>&nbsp;&nbsp;&nbsp;
			</td>
			<td height='25' bgcolor="<?php print $bgcolor;?>" align='left'>
				<img src="images/bar.gif" width="<?php print ($row["qnt"]*300)/$max;?>" height="11"><img src="images/bar_off.gif" width="<?php print 300-(($row["qnt"]*300)/$max);?>" height="11">
			</td>
		</tr>
		<tr><td height='1' colspan='4' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>
		<?php
	}
}



/*********************************************************/
/* Main code                                             */
/*********************************************************/

echo "<table width='100%' border='0' align='center' cellspacing='0' cellpadding='0'>";
echo "<tr><td height='25' colspan='4'>";

if (phpAds_isUser(phpAds_Admin))
{
	echo "<img src='images/icon-client.gif' align='absmiddle'>&nbsp;".phpAds_getParentName($campaignID);
	echo "&nbsp;<img src='images/caret-rs.gif'>&nbsp;";
}
echo "<img src='images/icon-campaign.gif' align='absmiddle'>&nbsp;".phpAds_getClientName($campaignID);
echo "&nbsp;<img src='images/caret-rs.gif'>&nbsp;";
echo "<img src='images/icon-banner-stored.gif' align='absmiddle'>&nbsp;<b>".phpAds_getBannerName($bannerID);

echo "</b></td></tr>";
echo "<tr><td height='1' colspan='4' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
echo "<tr><td colspan='4' align='left'><br>".phpAds_getBannerCode($bannerID)."</td></tr>";
echo "</table>";

echo "<br><br>";
echo "<br><br>";
echo "<br><br>";

?>

<table width='100%' border="0" align="center" cellspacing="0" cellpadding="0">
  <tr><td height='25' colspan='3'><b><?php print $strViews;?></b></td></tr>
  <tr><td height='1' colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>
  <?php showHourlyStats("$phpAds_tbl_adviews");; ?>
</table>

<br><br>

<table width='100%' border="0" align="center" cellspacing="0" cellpadding="0">
  <tr><td height='25' colspan='3'><b><?php print $strClicks;?></b></td></tr>
  <tr><td height='1' colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>
  <?php showHourlyStats("$phpAds_tbl_adclicks"); ?>
</table>

<br><br>

<?php if (!$phpAds_compact_stats) { ?>
<table width='100%' border="0" align="center" cellspacing="0" cellpadding="0">
  <tr><td height='25' colspan='2'><b><?php print $strTopTenHosts;?></b></td></tr>
  <tr><td height='1' colspan='2' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>
  <?php
    	$result = phpAds_dbQuery("
        		SELECT
        			*,
        			count(*) as qnt
        		FROM
        			$phpAds_tbl_adviews
        		WHERE
        			bannerID = $bannerID
        			AND DATE_FORMAT(t_stamp, '$date_format') = '$day'
        		GROUP BY
        			host
        		ORDER BY
        			qnt DESC
        		LIMIT 10
        		") or phpAds_sqlDie();
        
        	$i = 0;
        	while ($row = phpAds_dbFetchArray($result))
        	{
        		$bgcolor="#FFFFFF";
        		$i % 2 ? 0: $bgcolor= "#F6F6F6";
        		$i++;
        		?>
        		<tr>
        			<td height='25' bgcolor="<?php print $bgcolor;?>">
        			&nbsp;<?php print $row["host"];?>
        			</td>
        			<td height='25' bgcolor="<?php print $bgcolor;?>">
        			<b><?php print $row["qnt"];?></b>
        			</td>
        		</tr>
				<tr><td height='1' colspan='2' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>
        		<?php
        	}
        }
    ?>
</table>



<?php

/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

phpAds_PageFooter();

?>

