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
require ("lib-size.inc.php");


// Security check
phpAds_checkAccess(phpAds_Admin);



/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

phpAds_PageHeader("4.2");
phpAds_ShowSections(array("4.1", "4.2", "4.3"));

if (isset($message))
{
	phpAds_ShowMessage($message);
}



/*********************************************************/
/* Main code                                             */
/*********************************************************/

// Get clients & campaign and build the tree

$res_zones = db_query("
		SELECT 
			*
		FROM 
			".$phpAds_tbl_zones."
		".phpAds_getZoneListOrder ($listorder, $orderdirection)."
		") or mysql_die();


echo "<br><br>";
echo "<br><br>";
echo "<br><br>";
echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";	


if (@mysql_num_rows($res_zones) > 0)
{
	echo "<tr height='25'>";
	echo '<td height="25"><b>&nbsp;&nbsp;<a href="'.$PHP_SELF.'?listorder=name">'.$GLOBALS['strName'].'</a>';
	if (($listorder == "name") || ($listorder == ""))
	{
		if  (($orderdirection == "") || ($orderdirection == "down"))
		{
			echo ' <a href="'.$PHP_SELF.'?listorder=name&orderdirection=up">';
			echo '<img src="images/caret-ds.gif" border="0" alt="" title="">';
		}
		else
		{
			echo ' <a href="'.$PHP_SELF.'?listorder=name&orderdirection=down">';
			echo '<img src="images/caret-u.gif" border="0" alt="" title="">';
		}
		echo '</a>';
	}
	echo '</b></td>';
	echo '<td height="25"><b><a href="'.$PHP_SELF.'?listorder=id">'.$GLOBALS['strID'].'</a>';
	if ($listorder == "id")
	{
		if  (($orderdirection == "") || ($orderdirection == "down"))
		{
			echo ' <a href="'.$PHP_SELF.'?listorder=id&orderdirection=up">';
			echo '<img src="images/caret-ds.gif" border="0" alt="" title="">';
		}
		else
		{
			echo ' <a href="'.$PHP_SELF.'?listorder=id&orderdirection=down">';
			echo '<img src="images/caret-u.gif" border="0" alt="" title="">';
		}
		echo '</a>';
	}
	echo '</b>&nbsp;&nbsp;&nbsp;</td>';
	echo "<td height='25'><b>".$GLOBALS['strSize']."</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
	echo "<td height='25'>&nbsp;</td>";
	echo "</tr>";
	
	echo "<tr height='1'><td colspan='4' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
}

$stats['cachesize'] = 0;
$stats['cachedzones'] = 0;
$stats['cachetimestamp'] = 0;

$i=0;
while ($row_zones = mysql_fetch_array($res_zones))
{
	if ($i > 0) echo "<td colspan='4' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td>";
	echo "<tr height='25' ".($i%2==0?"bgcolor='#F6F6F6'":"").">";
	
	echo "<td height='25'>";
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
	
	echo "<tr height='1'>";
	echo "<td ".($i%2==0?"bgcolor='#F6F6F6'":"")."><img src='images/spacer.gif' width='1' height='1'></td>";
	echo "<td colspan='3' bgcolor='#888888'><img src='images/break-l.gif' height='1' width='100%'></td>";
	echo "</tr>";
	echo "<tr height='25' ".($i%2==0?"bgcolor='#F6F6F6'":"").">";
	
	// Empty
	echo "<td>&nbsp;</td>";
	
	// Button 1, 2 & 3
	echo "<td height='25' colspan='3'>";
	echo "<a href='zone-include.php?zoneid=".$row_zones['zoneid']."'><img src='images/icon-zone-linked.gif' border='0' align='absmiddle' alt='$strIncludedBanners'>&nbsp;$strIncludedBanners</a>&nbsp;&nbsp;&nbsp;&nbsp;";
	echo "<a href='zone-probability.php?zoneid=".$row_zones['zoneid']."'><img src='images/icon-zone-probability.gif' border='0' align='absmiddle' alt='$strProbability'>&nbsp;$strProbability</a>&nbsp;&nbsp;&nbsp;&nbsp;";
	echo "<a href='zone-invocation.php?zoneid=".$row_zones['zoneid']."'><img src='images/icon-generatecode.gif' border='0' align='absmiddle' alt='$strInvocationcode'>&nbsp;$strInvocationcode</a>&nbsp;&nbsp;&nbsp;&nbsp;";
	echo "<a href='zone-delete.php?zoneid=".$row_zones['zoneid']."'><img src='images/icon-recycle.gif' border='0' align='absmiddle' alt='$strDelete'>&nbsp;$strDelete</a>&nbsp;&nbsp;&nbsp;&nbsp;";
	echo "</td></tr>";
	
	$stats['cachetimestamp'] += $row_zones['cachetimestamp'];
	$stats['cachesize'] += strlen($row_zones['cachecontents']);
	if ($row_zones['cachecontents'] != '')
		$stats['cachedzones']++;
	
	$i++;
}

if (@mysql_num_rows($res_zones) > 0)
{
	echo "<tr height='1'><td colspan='4' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
}

echo "<tr height='25'><td colspan='4' height='25'>";
echo "<img src='images/icon-zone.gif' border='0' align='absmiddle'>&nbsp;<a href='zone-edit.php'>$strAddNewZone</a>&nbsp;&nbsp;";
echo "</td></tr>";

echo "</table>";



$stats['cachesize'] = round ($stats['cachesize'] / 1024);

if ($stats['cachedzones'] == 0)
	$stats['cachetimestamp'] = $strExpired;
else
{
	$stats['cachetimestamp'] = time() - round ($stats['cachetimestamp'] / $stats['cachedzones']);
	
	if ($stats['cachetimestamp'] > $phpAds_zone_cache_limit)
		$stats['cachetimestamp'] = $strExpired;
	else
		$stats['cachetimestamp'] .= ' '.$strSeconds;
}

echo "<br><br><br><br>";
echo "<table width='100%' border='0' align='center' cellspacing='0' cellpadding='0'>";
echo "<tr><td height='25' colspan='3'><b>".$strOverall."</b></td></tr>";
echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";

if (!$phpAds_zone_cache)
	echo "<tr><td height='25'>".$strZoneCacheOff."</b></td></tr>";
else
{
	echo "<tr><td height='25'>".$strZoneCacheOn."</b></td></tr>";
	
	echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break-el.gif' height='1' width='100%'></td></tr>";
	
	echo "<tr><td height='25'>".$strCachedZones.": <b>".$stats['cachedzones']."</b></td>";
	echo "<td height='25'>".$strAverageAge.": <b>".$stats['cachetimestamp']."</b></td>";
	echo "<td height='25'>".$strSizeOfCache.": <b>".$stats['cachesize']." ".$strKiloByte."</b></td></tr>";
}

echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";

if ($phpAds_zone_cache)
{
	echo "<tr height='25'><td colspan='3' height='25'>";
	echo "<img src='images/icon-undo.gif' border='0' align='absmiddle'>&nbsp;<a href='zone-rebuildcache.php'>$strRebuildZoneCache</a>&nbsp;&nbsp;";
	echo "</td></tr>";
}

echo "</table>";
echo "<br><br>";



/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

phpAds_PageFooter();

?>
