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
phpAds_ShowSections(array("4.1", "4.2", "4.3", "4.4"));



/*********************************************************/
/* Get preferences                                       */
/*********************************************************/

if (!isset($listorder))
{
	if (isset($Session['prefs']['affiliate-index.php']['listorder']))
		$listorder = $Session['prefs']['affiliate-index.php']['listorder'];
	else
		$listorder = '';
}

if (!isset($orderdirection))
{
	if (isset($Session['prefs']['affiliate-index.php']['orderdirection']))
		$orderdirection = $Session['prefs']['affiliate-index.php']['orderdirection'];
	else
		$orderdirection = '';
}

if (isset($Session['prefs']['affiliate-index.php']['nodes']))
	$node_array = explode (",", $Session['prefs']['affiliate-index.php']['nodes']);
else
	$node_array = array();



/*********************************************************/
/* Main code                                             */
/*********************************************************/

$stats['cachesize'] = 0;
$stats['cachedzones'] = 0;
$stats['cachetimestamp'] = 0;

$loosezones = false;


// Get affiliates and build the tree
$res_affiliates = phpAds_dbQuery("
	SELECT 
		*
	FROM 
		".$phpAds_config['tbl_affiliates']."
	".phpAds_getAffiliateListOrder ($listorder, $orderdirection)."
	") or phpAds_sqlDie();


while ($row_affiliates = phpAds_dbFetchArray($res_affiliates))
{
	$affiliates[$row_affiliates['affiliateid']] = $row_affiliates;
	$affiliates[$row_affiliates['affiliateid']]['expand'] = 0;
	$affiliates[$row_affiliates['affiliateid']]['count'] = 0;
}

// Get the zones for each affiliate
$res_zones = phpAds_dbQuery("
	SELECT 
		*
	FROM 
		".$phpAds_config['tbl_zones']."
		".phpAds_getZoneListOrder ($listorder, $orderdirection)."
	") or phpAds_sqlDie();

while ($row_zones = phpAds_dbFetchArray($res_zones))
{
	if (isset($affiliates[$row_zones['affiliateid']]))
	{
		$zones[$row_zones['zoneid']] = $row_zones;
		$affiliates[$row_zones['affiliateid']]['count']++;
	}
	else
		$loosezones = true;
	
	$stats['cachetimestamp'] += $row_zones['cachetimestamp'];
	$stats['cachesize'] += strlen($row_zones['cachecontents']);
	if ($row_zones['cachecontents'] != '')
		$stats['cachedzones']++;
}



// Add ID found in expand to expanded nodes
if (isset($expand) && $expand != '')
	$node_array[] = $expand;

$node_array_size = sizeof($node_array);
for ($i=0; $i < $node_array_size;$i++)
{
	if (isset($collapse) && $collapse == $node_array[$i])
		unset ($node_array[$i]);
	else
	{
		if (isset($affiliates[$node_array[$i]]))
			$affiliates[$node_array[$i]]['expand'] = 1;
	}
}



// Build Tree
if (isset($zones) && is_array($zones) && count($zones) > 0)
{
	// Add banner to campaigns
	for (reset($zones);$zkey=key($zones);next($zones))
	{
		$affiliates[$zones[$zkey]['affiliateid']]['zones'][$zkey] = $zones[$zkey];
	}
	
	unset ($zones);
}






echo "<br><br>";
echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";	

echo "<tr height='25'>";
echo '<td height="25"><b>&nbsp;&nbsp;<a href="affiliate-index.php?listorder=name">'.$GLOBALS['strName'].'</a>';

if (($listorder == "name") || ($listorder == ""))
{
	if  (($orderdirection == "") || ($orderdirection == "down"))
	{
		echo ' <a href="affiliate-index.php?orderdirection=up">';
		echo '<img src="images/caret-ds.gif" border="0" alt="" title="">';
	}
	else
	{
		echo ' <a href="affiliate-index.php?orderdirection=down">';
		echo '<img src="images/caret-u.gif" border="0" alt="" title="">';
	}
	echo '</a>';
}

echo '</b></td>';
echo '<td height="25"><b><a href="affiliate-index.php?listorder=id">'.$GLOBALS['strID'].'</a>';

if ($listorder == "id")
{
	if  (($orderdirection == "") || ($orderdirection == "down"))
	{
		echo ' <a href="affiliate-index.php?orderdirection=up">';
		echo '<img src="images/caret-ds.gif" border="0" alt="" title="">';
	}
	else
	{
		echo ' <a href="affiliate-index.php?orderdirection=down">';
		echo '<img src="images/caret-u.gif" border="0" alt="" title="">';
	}
	echo '</a>';
}

echo '</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>';
echo "<td height='25'>&nbsp;</td>";
echo "<td height='25'>&nbsp;</td>";
echo "<td height='25'>&nbsp;</td>";
echo "</tr>";

echo "<tr height='1'><td colspan='5' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";


if (!isset($affiliates) || !is_array($affiliates) || count($affiliates) == 0)
{
	echo "<tr height='25' bgcolor='#F6F6F6'><td height='25' colspan='5'>";
	echo "&nbsp;&nbsp;".$strNoAffiliates;
	echo "</td></tr>";
	
	echo "<td colspan='5' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td>";
}
else
{
	$i=0;
	for (reset($affiliates);$key=key($affiliates);next($affiliates))
	{
		$affiliate = $affiliates[$key];
		
		echo "<tr height='25' ".($i%2==0?"bgcolor='#F6F6F6'":"").">";
		
		// Icon & name
		echo "<td height='25'>";
		if (isset($affiliate['zones']))
		{
			if ($affiliate['expand'] == '1')
				echo "&nbsp;<a href='affiliate-index.php?collapse=".$affiliate['affiliateid']."'><img src='images/triangle-d.gif' align='absmiddle' border='0'></a>&nbsp;";
			else
				echo "&nbsp;<a href='affiliate-index.php?expand=".$affiliate['affiliateid']."'><img src='images/".$phpAds_TextDirection."/triangle-l.gif' align='absmiddle' border='0'></a>&nbsp;";
		}
		else
			echo "&nbsp;<img src='images/spacer.gif' height='16' width='16'>&nbsp;";
			
		echo "<img src='images/icon-affiliate.gif' align='absmiddle'>&nbsp;";
		echo "<a href='affiliate-edit.php?affiliateid=".$affiliate['affiliateid']."'>".$affiliate['name']."</a>";
		echo "</td>";
		
		// ID
		echo "<td height='25'>".$affiliate['affiliateid']."</td>";
		
		// Button 1
		echo "<td height='25'>";
		if ($affiliate['expand'] == '1' || !isset($affiliate['zones']))
			echo "<a href='zone-edit.php?affiliateid=".$affiliate['affiliateid']."'><img src='images/icon-zone.gif' border='0' align='absmiddle' alt='$strCreate'>&nbsp;$strCreate</a>&nbsp;&nbsp;&nbsp;&nbsp;";
		else
			echo "&nbsp;";
		echo "</td>";
		
		// Button 2
		echo "<td height='25'>";
		echo "<a href='zone-index.php?affiliateid=".$affiliate['affiliateid']."'><img src='images/icon-overview.gif' border='0' align='absmiddle' alt='$strOverview'>&nbsp;$strOverview</a>&nbsp;&nbsp;";
		echo "</td>";
		
		// Button 3
		echo "<td height='25'>";
		echo "<a href='affiliate-delete.php?affiliateid=".$affiliate['affiliateid']."&returnurl=affiliate-index.php'".phpAds_DelConfirm($strConfirmDeleteAffiliate)."><img src='images/icon-recycle.gif' border='0' align='absmiddle' alt='$strDelete'>&nbsp;$strDelete</a>&nbsp;&nbsp;&nbsp;&nbsp;";
		echo "</td></tr>";
		
		
		
		if (isset($affiliate['zones']) && sizeof ($affiliate['zones']) > 0 && $affiliate['expand'] == '1')
		{
			$zones = $affiliate['zones'];
			
			for (reset($zones);$zkey=key($zones);next($zones))
			{
				// Divider
				echo "<tr height='1'>";
				echo "<td ".($i%2==0?"bgcolor='#F6F6F6'":"")."><img src='images/spacer.gif' width='1' height='1'></td>";
				echo "<td colspan='5' bgcolor='#888888'><img src='images/break-l.gif' height='1' width='100%'></td>";
				echo "</tr>";
				
				// Icon & name
				echo "<tr height='25' ".($i%2==0?"bgcolor='#F6F6F6'":"")."><td height='25'>";
				echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
				echo "<img src='images/spacer.gif' height='16' width='16' align='absmiddle'>&nbsp;";
				
				echo "<img src='images/icon-zone.gif' align='absmiddle'>&nbsp;";
				
				echo "<a href='zone-edit.php?affiliateid=".$affiliate['affiliateid']."&zoneid=".$zones[$zkey]['zoneid']."'>".$zones[$zkey]['zonename']."</td>";
				echo "</td>";
				
				// ID
				echo "<td height='25'>".$zones[$zkey]['zoneid']."</td>";
				
				// Button 1
				echo "<td height='25'>";
				echo "&nbsp;";
				echo "</td>";
				
				// Button 2
				echo "<td height='25'>";
				echo "<a href='zone-include.php?affiliateid=".$affiliate['affiliateid']."&zoneid=".$zones[$zkey]['zoneid']."'><img src='images/icon-zone-linked.gif' border='0' align='absmiddle' alt='$strIncludedBanners'>&nbsp;$strIncludedBanners</a>&nbsp;&nbsp;";
				echo "</td>";
				
				// Button 3
				echo "<td height='25'>";
				echo "<a href='zone-delete.php?affiliateid=".$affiliate['affiliateid']."&zoneid=".$zones[$zkey]['zoneid']."&returnurl=affiliate-index.php'".phpAds_DelConfirm($strConfirmDeleteZone)."><img src='images/icon-recycle.gif' border='0' align='absmiddle' alt='$strDelete'>&nbsp;$strDelete</a>&nbsp;&nbsp;&nbsp;&nbsp;";
				echo "</td></tr>";
			}
		}
		
		echo "<tr height='1'><td colspan='5' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
		$i++;
	}
}

if ($loosezones)
{
	echo "<tr height='25' ".($i%2==0?"bgcolor='#F6F6F6'":"").">";
	echo "<td height='25'>&nbsp;&nbsp;";
	echo "<img src='images/icon-zone.gif' align='absmiddle'>&nbsp;";
	echo $strZonesWithoutAffiliate."</td>";
	echo "<td height='25'>&nbsp;-&nbsp;</td>";
	echo "<td height='25' colspan='3'>";
	echo "<a href='affiliate-edit.php?move=t'>";
	echo "<img src='images/".$phpAds_TextDirection."/icon-update.gif' border='0' align='absmiddle' alt='$strMoveToNewAffiliate'>&nbsp;$strMoveToNewAffiliate</a>&nbsp;&nbsp;";
	echo "</td>";
	echo "</tr>";
	
	echo "<tr height='1'><td colspan='5' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
}

echo "<tr height='25'><td colspan='5' height='25'>";
echo "<img src='images/icon-affiliate.gif' border='0' align='absmiddle'>&nbsp;<a href='affiliate-edit.php'>$strAddAffiliate</a>&nbsp;&nbsp;";
echo "</td></tr>";

echo "</table>";



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

echo "<br><br><br><br>";
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

if ($phpAds_config['zone_cache'])
{
	echo "<tr height='25'><td colspan='3' height='25'>";
	echo "<img src='images/".$phpAds_TextDirection."/icon-undo.gif' border='0' align='absmiddle'>&nbsp;<a href='zone-rebuildcache.php'>$strRebuildZoneCache</a>&nbsp;&nbsp;";
	echo "</td></tr>";
}

echo "</table>";
echo "<br><br>";



/*********************************************************/
/* Store preferences                                     */
/*********************************************************/

$Session['prefs']['affiliate-index.php']['listorder'] = $listorder;
$Session['prefs']['affiliate-index.php']['orderdirection'] = $orderdirection;
$Session['prefs']['affiliate-index.php']['nodes'] = implode (",", $node_array);

phpAds_SessionDataStore();



/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

phpAds_PageFooter();

?>
