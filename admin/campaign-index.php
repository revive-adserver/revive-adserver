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
phpAds_checkAccess(phpAds_Admin);



/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

if($campaignID == "") $campaignID = 0;

$res = db_query("
	SELECT
		*
	FROM
		$phpAds_tbl_clients
	WHERE
		parent > 0
	") or mysql_die();

$extra = '';

while ($row = mysql_fetch_array($res))
{
	if ($campaignID == $row['clientID'])
		$extra .= "&nbsp;&nbsp;&nbsp;<img src='images/box-1.gif'>&nbsp;";
	else
		$extra .= "&nbsp;&nbsp;&nbsp;<img src='images/box-0.gif'>&nbsp;";
	
	$extra .= "<a href=campaign-index.php?campaignID=".$row['clientID'].">".phpAds_buildClientName ($row['clientID'], $row['clientname'])."</a>";
	$extra .= "<br>"; 
}
$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";

$extra .= "<br><br><br><br><br>";
$extra .= "<b>$strShortcuts</b><br>";
$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
$extra .= "<img src='images/icon-client.gif' align='absmiddle'>&nbsp;<a href=client-edit.php?clientID=".phpAds_getParentID ($campaignID).">$strModifyClient</a><br>";
$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
$extra .= "<img src='images/icon-edit.gif' align='absmiddle'>&nbsp;<a href=campaign-edit.php?campaignID=$campaignID>$strModifyCampaign</a><br>";
$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
$extra .= "<img src='images/icon-statistics.gif' align='absmiddle'>&nbsp;<a href=stats-campaign.php?campaignID=$campaignID>$strStats</a><br>";
$extra .= "<img src='images/break-el.gif' height='1' width='160' vspace='4'><br>";
$extra .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src='images/icon-weekly.gif' align='absmiddle'>&nbsp;<a href=stats-weekly.php?campaignID=$campaignID>$strWeeklyStats</a><br>";
$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";

phpAds_PageHeader("4.1", $extra);

if (isset($message))
	phpAds_ShowMessage($message);



/*********************************************************/
/* Main code                                             */
/*********************************************************/



?>

<table border='0' width='100%' cellpadding='0' cellspacing='0'>
	<tr><td height='25' colspan='2'><img src='images/icon-client.gif' align='absmiddle'>&nbsp;<?php echo phpAds_getParentName($campaignID);?>
									&nbsp;<img src='images/caret-rs.gif'>&nbsp;
									<img src='images/icon-campaign.gif' align='absmiddle'>&nbsp;<b><?php echo phpAds_getClientName($campaignID);?></b></td></tr>
	<tr><td height='1' colspan='2' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>
	<tr><td height='25' colspan='2'>
		<img src='images/icon-banner-stored.gif' align='absmiddle'>&nbsp;<a href='banner-edit.php?campaignID=<?php echo $campaignID; ?>'><?php echo $strAddBanner;?></a>&nbsp;&nbsp;&nbsp;&nbsp;
	</td></tr>
</table>


<br><br>



<?php

$res = db_query("
	SELECT
		*
	FROM
		$phpAds_tbl_banners  
	WHERE
		clientID = $campaignID
	") or mysql_die();

if (mysql_num_rows($res) == 0)
{
	echo "$strNoBanners<br>";
}
else
{
	echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";
	
	while ($row = mysql_fetch_array($res))
	{
	
		echo "<tr>";
		echo "<td height='25' colspan='5'>";
		
		if ($row['active'] == 'true')
		{
			if ($row['format'] == 'html')
			{
				echo "<img src='images/icon-banner-html.gif' align='absmiddle'>";
			}
			elseif ($row['format'] == 'url')
			{
				echo "<img src='images/icon-banner-url.gif' align='absmiddle'>";
			}
			else
			{
				echo "<img src='images/icon-banner-stored.gif' align='absmiddle'>";
			}
		}
		else
		{
			if ($row['format'] == 'html')
			{
				echo "<img src='images/icon-banner-html-d.gif' align='absmiddle'>";
			}
			elseif ($row['format'] == 'url')
			{
				echo "<img src='images/icon-banner-url-d.gif' align='absmiddle'>";
			}
			else
			{
				echo "<img src='images/icon-banner-stored-d.gif' align='absmiddle'>";
			}
		}
		
		echo "&nbsp;<b>".phpAds_buildBannerName ($row['bannerID'], $row['description'], $row['alt'])."</b>";
		
		echo "</td></tr>";
		
		echo "<tr><td height='1' colspan='5' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
		
		echo "<tr><td height='10' colspan='5' bgcolor='#F6F6F6'>&nbsp;</td></tr>";
		echo "<tr>";
		echo "<td bgcolor='#F6F6F6'>&nbsp;&nbsp;&nbsp;&nbsp;</td>";
	   	echo "<td bgcolor='#F6F6F6' colspan='4' align='left'>";
	   	echo phpAds_buildBannerCode ($row['bannerID'], $row['banner'], $row['active'], $row['format'], $row['width'], $row['height'], $row['bannertext']);
	    echo "</td>";
		echo "</tr>";
		
		echo "<tr><td height='10' colspan='5' bgcolor='#F6F6F6'>&nbsp;</td></tr>";
		echo "<tr><td bgcolor='#F6F6F6'>&nbsp;&nbsp;&nbsp;&nbsp;</td>";
		echo "<td height='25' bgcolor='#F6F6F6' align='left'>";
		echo "&nbsp;$strSize: <b>".$row['width']."x".$row['height']."</b></td>";
		echo "<td height='25' bgcolor='#F6F6F6' align='left'>";
		echo "$strWeight: <b>".$row['weight']."</b></td>";
		echo "<td height='25' bgcolor='#F6F6F6' align='left'>";
		echo "$strKeyword: <b>".$row['keyword']."</b></td>";
		echo "<td height='25' bgcolor='#F6F6F6' align='left'>";
		echo $row['url']."&nbsp;</td></tr>";
		
		echo "<tr><td height='1' colspan='5' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
		
		echo "<tr>";
		echo "<td height='25' colspan='5' align='right'>";
		
		if ($row["active"] == "true")
		{
			echo "<img src='images/icon-deactivate.gif' align='absmiddle'>&nbsp;<a href='banner-activate.php?campaignID=$campaignID&bannerID=".$row["bannerID"]."&value=".$row["active"]."'>";
			echo $strDeActivate;
		}
		else
		{
			echo "<img src='images/icon-activate.gif' align='absmiddle'>&nbsp;<a href='banner-activate.php?campaignID=$campaignID&bannerID=".$row["bannerID"]."&value=".$row["active"]."'>";
			echo $strActivate;
		}
		
		echo "</a>&nbsp;&nbsp;&nbsp;&nbsp;";
		
		echo "<img src='images/icon-edit.gif' align='absmiddle'>&nbsp;<a href='banner-edit.php?campaignID=$campaignID&bannerID=".$row["bannerID"]."'>$strModifyBanner</a>&nbsp;&nbsp;&nbsp;&nbsp;";
		
		if ($phpAds_acl == '1')
			echo "<img src='images/icon-acl.gif' align='absmiddle'>&nbsp;<a href='banner-acl.php?campaignID=$campaignID&bannerID=".$row["bannerID"]."'>$strModifyBannerAcl</a>&nbsp;&nbsp;&nbsp;&nbsp;";
		echo "<img src='images/icon-recycle.gif' align='absmiddle'>&nbsp;<a href='banner-delete.php?campaignID=$campaignID&bannerID=".$row["bannerID"]."'".phpAds_DelConfirm($strConfirmDeleteBanner).">$strDelete</a>";
		
		echo "</td></tr>";
		
		echo "<tr><td height='35' colspan='5' bgcolor='#FFFFFF'>&nbsp;</td></tr>";
	}
	
	echo "</table>";
	echo "<br>";
}



echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";
echo "<tr><td height='25' colspan='2'><b>$strCreditStats</b></td></tr>";
echo "<tr><td height='1' colspan='2' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";

list($desc,$enddate,$daysleft)=days_left($campaignID);
$adclicksleft = adclicks_left($campaignID);
$adviewsleft  = adviews_left($campaignID);

echo "<tr><td height='25'>$strViewCredits: <b>$adviewsleft</b></td>";
echo "<td height='25'>$strClickCredits: <b>$adclicksleft</b></td></tr>";
echo "<tr><td height='1' colspan='2' bgcolor='#888888'><img src='images/break-el.gif' height='1' width='100%'></td></tr>";
echo "<tr><td height='25' colspan='2'>$desc</td></tr>";

echo "<tr><td height='1' colspan='2' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
echo "</table>";



/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

phpAds_PageFooter();

?>
