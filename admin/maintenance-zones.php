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

$stats = array(
	'cachetimestamp' => 0,
	'cachesize' => 0,
	'cachedzones' => 0
);

// Get the zones for each affiliate
$res_zones = phpAds_dbQuery("
	SELECT 
		*
	FROM 
		".$phpAds_config['tbl_zones']."
") or phpAds_sqlDie();

while ($row_zones = phpAds_dbFetchArray($res_zones))
{
	$stats['cachetimestamp'] += $row_zones['cachetimestamp'];
	$stats['cachesize'] += strlen($row_zones['cachecontents']);
	if ($row_zones['cachecontents'] != '')
		$stats['cachedzones']++;
}


$stats['cachesize'] = round ($stats['cachesize'] / 1024);

if ($stats['cachedzones'] == 0)
	$stats['cachetimestamp'] = $strExpired;
else
{
	$stats['cachetimestamp'] = time() - round ($stats['cachetimestamp'] / $stats['cachedzones']);
	
	if ($stats['cachetimestamp'] > $phpAds_config['zone_cache_limit'])
		$stats['cachetimestamp'] = $strExpired;
	else
		$stats['cachetimestamp'] .= ' '.$strSeconds;
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
echo "<table width='100%' border='0' align='center' cellspacing='0' cellpadding='0'>";
echo "<tr><td height='25' colspan='3'><b>".$strOverall."</b></td></tr>";
echo "<tr height='1'><td colspan='3' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";

if (!$phpAds_config['zone_cache'])
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
echo "</table>";



/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

phpAds_PageFooter();

?>
