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
require ("lib-maintenance.inc.php");
require ("lib-statistics.inc.php");
require ("lib-zones.inc.php");


// Security check
phpAds_checkAccess(phpAds_Admin);



/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

phpAds_PageHeader("5.3");
phpAds_ShowSections(array("5.1", "5.3", "5.2"));
phpAds_MaintenanceSelection("zones");



/*********************************************************/
/* Main code                                             */
/*********************************************************/

function phpAds_showZones ()
{
	global $phpAds_config;
	global $strUntitled, $strName, $strID, $strAge, $strSize, $strKiloByte;
	global $strSeconds, $strExpired;
	global $phpAds_TextDirection;
	
	
	$res = phpAds_dbQuery("
		SELECT 
			*
		FROM 
			".$phpAds_config['tbl_zones']."
		ORDER BY
			zoneid
	");
	
	$rows = array();
	
	while ($tmprow = phpAds_dbFetchArray($res))
	{
		$rows[$tmprow['zoneid']] = $tmprow; 
	}
	
	if (is_array($rows))
	{
		$i=0;
		
		// Header
		echo "<table width='100%' border='0' align='center' cellspacing='0' cellpadding='0'>";
		echo "<tr height='25'>";
		echo "<td height='25'><b>&nbsp;&nbsp;".$strName."</b></td>";
		echo "<td height='25'><b>".$strID."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></td>";
		echo "<td height='25'><b>".$strAge."</b></td>";
		echo "<td height='25'><b>".$strSize."</b></td>";
		echo "</tr>";
		
		echo "<tr height='1'><td colspan='5' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
		
		// Banners
		for (reset($rows);$key=key($rows);next($rows))
		{
			if ($i > 0) echo "<tr height='1'><td colspan='5' bgcolor='#888888'><img src='images/break-l.gif' height='1' width='100%'></td></tr>";
			
	    	echo "<tr height='25' ".($i%2==0?"bgcolor='#F6F6F6'":"").">";
			
			echo "<td height='25'>";
			echo "&nbsp;&nbsp;";
			
			// Zone icon
			echo "<img src='images/icon-zone.gif' align='absmiddle'>&nbsp;";
			
			// Name
			echo $rows[$key]['zonename'];
			echo "</td>";
			
			echo "<td height='25'>".$rows[$key]['zoneid']."</td>";
			
			echo "<td height='25'>";
			echo (time() - $rows[$key]['cachetimestamp'] > $phpAds_config['zone_cache_limit']) ? $strExpired : (time() - $rows[$key]['cachetimestamp']).' '.$strSeconds;
			echo "</td>";
			
			echo "<td height='25'>".round (strlen($rows[$key]['cachecontents']) / 1024)." ".$strKiloByte."</td>";
			
			echo "</tr>";
			$i++;
		}
		
		// Footer
		echo "<tr height='1'><td colspan='5' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
		echo "</table>";
	}
}


echo "<br>";
echo str_replace ('{seconds}', $phpAds_config['zone_cache_limit'], $strZoneCacheExplaination);
echo "<br><br>";

phpAds_ShowBreak();

if ($phpAds_config['zone_cache'])
{
	echo "<img src='images/".$phpAds_TextDirection."/icon-undo.gif' border='0' align='absmiddle'>&nbsp;<a href='maintenance-zones-rebuild.php'>$strRebuildZoneCache</a>&nbsp;&nbsp;";
	phpAds_ShowBreak();
}

echo "<br><br>";
phpAds_showZones();
echo "<br><br>";



/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

phpAds_PageFooter();

?>
