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
require ("lib-size.inc.php");


// Security check
phpAds_checkAccess(phpAds_Admin);



/*********************************************************/
/* Process submitted form                                */
/*********************************************************/

if (isset($submit))
{
	if (isset($previouszone) && is_array($previouszone))
	{
		for (reset($previouszone);$key=key($previouszone);next($previouszone))
		{
			if (($previouszone[$key] == 'true' && $includezone[$key] != 'true') or
			    ($previouszone[$key] != 'true' && $includezone[$key] == 'true'))
			{
				phpAds_ToggleBannerInZone ($bannerID, $key);
			}
		}
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
		clientID = $campaignID
") or phpAds_sqlDie();

while ($row = phpAds_dbFetchArray($res))
{
	if ($bannerID == $row['bannerID'])
		$extra .= "&nbsp;&nbsp;&nbsp;<img src='images/box-1.gif'>&nbsp;";
	else
		$extra .= "&nbsp;&nbsp;&nbsp;<img src='images/box-0.gif'>&nbsp;";
	$extra .= "<a href='banner-zone.php?campaignID=$campaignID&bannerID=".$row['bannerID']."'>";
	$extra .= phpAds_buildBannerName ($row['bannerID'], $row['description'], $row['alt']);
	$extra .= "</a>";
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
$extra .= "<img src='images/break-el.gif' height='1' width='160' vspace='4'><br>";
$extra .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src='images/icon-zoom.gif' align='absmiddle'>&nbsp;<a href=stats-details.php?campaignID=$campaignID&bannerID=$bannerID>$strDetailStats</a><br>";
$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";

phpAds_PageHeader("4.1.5.4", $extra);
phpAds_ShowSections(array("4.1.5.2", "4.1.5.3", "4.1.5.4"));




/*********************************************************/
/* Main code                                             */
/*********************************************************/


echo "<table width='100%' border='0' align='center' cellspacing='0' cellpadding='0'>";
echo "<tr><td height='25'><img src='images/icon-client.gif' align='absmiddle'>&nbsp;".phpAds_getParentName($campaignID);
echo "&nbsp;<img src='images/caret-rs.gif'>&nbsp;";
echo "<img src='images/icon-campaign.gif' align='absmiddle'>&nbsp;".phpAds_getClientName($campaignID);
echo "&nbsp;<img src='images/caret-rs.gif'>&nbsp;";
if ($bannerID != '')
	echo "<img src='images/icon-banner-stored.gif' align='absmiddle'>&nbsp;<b>".phpAds_getBannerName($bannerID)."</b></td></tr>";
else
	echo "<img src='images/icon-banner-stored.gif' align='absmiddle'>&nbsp;".$strUntitled."</td></tr>";

if ($bannerID != '')
{
	echo "<tr><td height='1' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
	echo "<tr><td align='left'><br>".phpAds_getBannerCode($bannerID)."</td></tr>";
}

echo "</table>";

echo "<br><br>";
echo "<br><br>";
echo "<br><br>";



$res_zones = phpAds_dbQuery("
		SELECT 
			z.zoneid,
			z.zonename,
			z.description,
			z.width,
			z.height,
			z.what
		FROM 
			".$phpAds_config['tbl_zones']." AS z,
			".$phpAds_config['tbl_banners']." AS b
		WHERE
			b.bannerID = $bannerID AND
			(z.width = b.width OR z.width = -1) AND
			(z.height = b.height OR z.height = -1) AND
			z.zonetype = ".phpAds_ZoneBanners."
		ORDER BY
			zoneid
		") or phpAds_sqlDie();


echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";
echo "<form action='banner-zone.php' method='post'>";
echo "<input type='hidden' name='campaignID' value='".$campaignID."'>";
echo "<input type='hidden' name='bannerID' value='".$bannerID."'>";

echo "<tr height='25'>";
echo "<td height='25'><b>&nbsp;&nbsp;".$GLOBALS['strName']."</b></td>";
echo "<td height='25'><b>".$GLOBALS['strID']."</b>&nbsp;&nbsp;&nbsp;</td>";
echo "<td height='25'><b>".$GLOBALS['strSize']."</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
echo "<td height='25'>&nbsp;</td>";
echo "</tr>";

echo "<tr height='1'><td colspan='4' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";



$i=0;
while ($row_zones = phpAds_dbFetchArray($res_zones))
{
	if ($i > 0) echo "<td colspan='4' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td>";
	echo "<tr height='25' ".($i%2==0?"bgcolor='#F6F6F6'":"").">";
	
	echo "<td height='25'>";
	
	$status = phpAds_IsBannerInZone ($bannerID, $row_zones['zoneid']);
	
    if ($status)
		echo "&nbsp;&nbsp;<input name='includezone[".$row_zones['zoneid']."]' type='checkbox' value='true' checked>";
	else
		echo "&nbsp;&nbsp;<input name='includezone[".$row_zones['zoneid']."]' type='checkbox' value='true'>";
	
	echo "<input type='hidden' name='previouszone[".$row_zones['zoneid']."]' value='".($status ? 'true' : 'false')."'>";
	
	echo "&nbsp;&nbsp;<img src='images/icon-zone.gif' align='absmiddle'>&nbsp;";
	echo "<a href='zone-edit.php?zoneid=".$row_zones['zoneid']."'>".$row_zones['zonename']."</a>";
	echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
	echo "</td>";
	
	// ID
	echo "<td height='25'>".$row_zones['zoneid']."</td>";
	
	// Size
	if ($row_zones['width'] == -1) $row_zones['width'] = '*';
	if ($row_zones['height'] == -1) $row_zones['height'] = '*';
	
	echo "<td height='25'>".phpAds_getBannerSize($row_zones['width'], $row_zones['height'])."</td>";
	echo "<td>&nbsp;</td>";
	echo "</tr>";
	
	// Description
	echo "<tr height='25' ".($i%2==0?"bgcolor='#F6F6F6'":"").">";
	echo "<td>&nbsp;</td>";
	echo "<td height='25' colspan='3'>".stripslashes($row_zones['description'])."</td>";
	echo "</tr>";
	
	
	$i++;
}

if (phpAds_dbNumRows($res_zones) > 0)
{
	echo "<tr height='1'><td colspan='4' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
}
else
{
	echo "<tr height='25' bgcolor='#F6F6F6'>";
	echo "<td colspan='4'>";
	echo "&nbsp;&nbsp;".$strNoZonesToLink;
	echo "</td>";
	echo "<tr height='1'><td colspan='4' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
}

echo "</table>";

if (phpAds_dbNumRows($res_zones) > 0)
{
	echo "<br><br>";
	echo "<input type='submit' name='submit' value='$strSaveChanges'>";
}

echo "</form>";



/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

phpAds_PageFooter();

?>
