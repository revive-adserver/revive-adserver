<?php // $Revision$

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2000-2005 by the phpAdsNew developers                  */
/* For more information visit: http://www.phpadsnew.com                 */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/



// Include required files
require ("config.php");
require ("lib-maintenance.inc.php");
require ("lib-statistics.inc.php");


// Rebuild cache
if (!defined('LIBVIEWCACHE_INCLUDED')) 
	include (phpAds_path.'/libraries/deliverycache/cache-'.$phpAds_config['delivery_caching'].'.inc.php');


// Security check
phpAds_checkAccess(phpAds_Admin);



/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

phpAds_PageHeader("5.3");
phpAds_ShowSections(array("5.1", "5.3", "5.4", "5.2"));
phpAds_MaintenanceSelection("zones");



/*********************************************************/
/* Main code                                             */
/*********************************************************/

function phpAds_showCache ()
{
	global $phpAds_config;
	global $strKeyword, $strSize, $strKiloByte;
	global $phpAds_TextDirection;
	
	
	$rows = phpAds_cacheInfo();
	
	if (is_array($rows))
	{
		$i=0;
		
		// Header
		echo "<table width='100%' border='0' align='center' cellspacing='0' cellpadding='0'>";
		echo "<tr height='25'>";
		echo "<td height='25'><b>&nbsp;&nbsp;".$strKeyword."</b></td>";
		echo "<td height='25'><b>".$strSize."</b></td>";
		echo "</tr>";
		
		echo "<tr height='1'><td colspan='5' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
		
		for (reset($rows);$key=key($rows);next($rows))
		{
			$type = strtok($key, "=");
			$what = strtok("&");
			
			if ($i > 0) echo "<tr height='1'><td colspan='5' bgcolor='#888888'><img src='images/break-l.gif' height='1' width='100%'></td></tr>";
			
	    	echo "<tr height='25' ".($i%2==0?"bgcolor='#F6F6F6'":"").">";
			
			echo "<td height='25'>";
			echo "&nbsp;&nbsp;";
			
			// Icon
			if ($type == 'bannerid')
				echo "<img src='images/icon-banner-stored.gif' align='absmiddle'>&nbsp;";			
			elseif (substr($what,0,5) == 'zone:')
				echo "<img src='images/icon-zone.gif' align='absmiddle'>&nbsp;";
			else
				echo "<img src='images/icon-generatecode.gif' align='absmiddle'>&nbsp;";
			
			
			// Name
			echo $what;
			echo "</td>";
			
			echo "<td height='25'>".round ($rows[$key] / 1024)." ".$strKiloByte."</td>";
			
			echo "</tr>";
			$i++;
		}
		
		// Footer
		echo "<tr height='1'><td colspan='5' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
		echo "</table>";
	}
}


echo "<br>".$strDeliveryCacheExplaination;

switch ($phpAds_config['delivery_caching'])
{
	case 'shm': 		echo $strDeliveryCacheSharedMem; break;
	case 'sysvshm': 	echo $strDeliveryCacheSharedMem; break;
	case 'file': 		echo $strDeliveryCacheFiles; break;
	default:    		echo $strDeliveryCacheDatabase; break;
}

echo "<br><br>";

phpAds_ShowBreak();

echo "<img src='images/".$phpAds_TextDirection."/icon-undo.gif' border='0' align='absmiddle'>&nbsp;<a href='maintenance-cache-rebuild.php'>$strRebuildDeliveryCache</a>&nbsp;&nbsp;";
phpAds_ShowBreak();

echo "<br><br>";
phpAds_showCache();
echo "<br><br>";



/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

phpAds_PageFooter();

?>