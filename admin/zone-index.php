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
			$phpAds_tbl_zones
		ORDER BY
			zoneid
		") or mysql_die();


echo "<br><br>";
echo "<br><br>";
echo "<br><br>";
echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";	


if (@mysql_num_rows($res_zones) > 0)
{
	echo "<tr height='25'>";
	echo "<td height='25'><b>&nbsp;&nbsp;".$GLOBALS['strName']."</b></td>";
	echo "<td height='25'><b>".$GLOBALS['strID']."</b></td>";
	echo "<td height='25'><b>".$GLOBALS['strSize']."</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
	echo "<td height='25'>&nbsp;</td>";
	echo "<td height='25'>&nbsp;</td>";
	echo "</tr>";
	
	echo "<tr height='1'><td colspan='5' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
}

$i=0;
while ($row_zones = mysql_fetch_array($res_zones))
{
	if ($i > 0) echo "<td colspan='5' bgcolor='#888888'><img src='images/break-l.gif' height='1' width='100%'></td>";
	echo "<tr height='25' ".($i%2==0?"bgcolor='#F6F6F6'":"").">";
	
	echo "<td height='25'>";
	echo "&nbsp;&nbsp;<img src='images/icon-zone.gif' align='absmiddle'>&nbsp;";
	echo "<a href='zone-edit.php?zoneid=".$row_zones['zoneid']."'>".$row_zones['zonename']."</a>";
	echo "</td>";
	
	// ID
	echo "<td height='25'>".$row_zones['zoneid']."</td>";
	
	// Empty
	echo "<td height='25'>".$row_zones['width']."x".$row_zones['height']."</td>";
	
	// Empty
	echo "<td>&nbsp;</td>";
	
	// Button 1
	echo "<td height='25'>";
	echo "<a href='zone-delete.php?zoneid=".$row_zones['zoneid']."'><img src='images/icon-recycle.gif' border='0' align='absmiddle' alt='$strDelete'>&nbsp;$strDelete</a>&nbsp;&nbsp;&nbsp;&nbsp;";
	echo "</td></tr>";
	
	$i++;
}

if (@mysql_num_rows($res_zones) > 0)
{
	echo "<tr height='1'><td colspan='5' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
}

echo "<tr height='25'><td colspan='5' height='25'>";
echo "<img src='images/icon-zone.gif' border='0' align='absmiddle'>&nbsp;<a href='zone-edit.php'>$strAddNewZone</a>&nbsp;&nbsp;";
echo "</td></tr>";

echo "</table>";




/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

phpAds_PageFooter();

?>
