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


// Security check
phpAds_checkAccess(phpAds_Admin);



/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

if (phpAds_isUser(phpAds_Admin))
{
	$extra = '';
	
	$res = db_query("
		SELECT
			*
		FROM
			$phpAds_tbl_zones
		") or mysql_die();
	
	$extra = "";
	while ($row = mysql_fetch_array($res))
	{
		if ($zoneid == $row['zoneid'])
			$extra .= "&nbsp;&nbsp;&nbsp;<img src='images/box-1.gif'>&nbsp;";
		else
			$extra .= "&nbsp;&nbsp;&nbsp;<img src='images/box-0.gif'>&nbsp;";
		
		$extra .= "<a href='zone-probability.php?zoneid=". $row['zoneid']."'>".phpAds_buildZoneName ($row['zoneid'], $row['zonename'])."</a>";
		$extra .= "<br>"; 
	}
	$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
	
	phpAds_PageHeader("4.2.4", $extra);
	phpAds_ShowSections(array("4.2.2", "4.2.3", "4.2.4", "4.2.5"));
}




/*********************************************************/
/* Main code                                             */
/*********************************************************/

function phpAds_showZoneBanners ($zoneid)
{
	global $strUntitled, $phpAds_tbl_zones, $strName, $strID, $phpAds_percentage_decimals, $strWeight;
	global $strCampaignWeight, $strBannerWeight;
	
	// Get zone
	$zoneres = @db_query("SELECT * FROM $phpAds_tbl_zones WHERE zoneid='$zoneid' ");
	
	if (@mysql_num_rows($zoneres) > 0)
	{
		$zone = mysql_fetch_array($zoneres);
		
		// Set what parameter to zone settings
		if (isset($zone['what']) && $zone['what'] != '')
			$what = $zone['what'];
		else
			$what = '';
	}
	else
		$what = '';
	
	$select = phpAds_buildQuery ($what, 1, '');
	$res    = @db_query($select);
	
	$rows = array();
	$weightsum = 0;
	while ($tmprow = @mysql_fetch_array($res))
	{
		// weight of 0 disables the banner
		if ($tmprow['weight'])
		{
			if ($tmprow['format'] == 'gif' ||
				$tmprow['format'] == 'jpeg' ||
				$tmprow['format'] == 'png' ||
				$tmprow['format'] == 'swf')
			{
				$tmprow['banner'] = '';
			}
			
			$weightsum += ($tmprow['weight'] * $tmprow['clientweight']);
			$rows[$tmprow['bannerID']] = $tmprow; 
		}
	}
	
	if (is_array($rows))
	{
		$i=0;
		
		// Header
		echo "<table width='100%' border='0' align='center' cellspacing='0' cellpadding='0'>";
		echo "<tr height='25'>";
		echo "<td height='25'><b>&nbsp;&nbsp;$strName</b></td>";
		echo "<td height='25'><b>$strID&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></td>";
		echo "<td height='25'><b>$strCampaignWeight</b></td>";
		echo "<td height='25'><b>$strBannerWeight</b></td>";
		echo "<td height='25'><b>Probability</b></td>";
		echo "</tr>";
		
		echo "<tr height='1'><td colspan='5' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
		
		// Banners
		
		for (reset($rows);$key=key($rows);next($rows))
		//for ($key=0;$key<sizeof($rows);$key++)
		{
			$name = phpAds_getBannerName ($rows[$key]['bannerID'], 60, false);
			
			if ($i > 0) echo "<tr height='1'><td colspan='5' bgcolor='#888888'><img src='images/break-l.gif' height='1' width='100%'></td></tr>";
			
	    	echo "<tr height='25' ".($i%2==0?"bgcolor='#F6F6F6'":"").">";
			
			echo "<td height='25'>";
			echo "&nbsp;&nbsp;";
			
			// Banner icon
			if ($rows[$key]['format'] == 'html')
				echo "<img src='images/icon-banner-html.gif' align='absmiddle'>&nbsp;";
			elseif ($rows[$key]['format'] == 'url')
				echo "<img src='images/icon-banner-url.gif' align='absmiddle'>&nbsp;";
			else
				echo "<img src='images/icon-banner-stored.gif' align='absmiddle'>&nbsp;";
			
			// Name
			echo $name;
			echo "</td>";
			
			echo "<td height='25'>".$rows[$key]['bannerID']."</td>";
			echo "<td height='25'>".$rows[$key]['clientweight']."</td>";
			echo "<td height='25'>".$rows[$key]['weight']."</td>";
			echo "<td height='25'>".number_format($rows[$key]['weight'] * $rows[$key]['clientweight'] / $weightsum * 100, $phpAds_percentage_decimals)."%</td>";
			
			echo "</tr>";
			$i++;
		}
		
		// Footer
		echo "<tr height='1'><td colspan='5' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
		echo "</table>";
	}
}





/*********************************************************/
/* Main code                                             */
/*********************************************************/

if (isset($zoneid) && $zoneid != '')
{
	$res = @db_query("
		SELECT
			*
		FROM
			$phpAds_tbl_zones
		WHERE
			zoneid = $zoneid
		") or mysql_die();
	
	if (@mysql_num_rows($res))
	{
		$zone = @mysql_fetch_array($res);
	}
}



echo "<img src='images/icon-zone.gif' align='absmiddle'>&nbsp;<b>".phpAds_getZoneName($zoneid)."</b><br>";

echo "<br><br>";
echo "<br><br>";
echo "<br><br>";

phpAds_showZoneBanners($zoneid);

echo "<br><br>";



/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

phpAds_PageFooter();

?>
