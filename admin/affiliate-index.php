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

if (isset($message))
{
	phpAds_ShowMessage($message);
}



/*********************************************************/
/* Main code                                             */
/*********************************************************/

$stats['cachesize'] = 0;
$stats['cachedzones'] = 0;
$stats['cachetimestamp'] = 0;


if (!isset($listorder)) 	 $listorder = '';
if (!isset($orderdirection)) $orderdirection = '';


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
	
	$stats['cachetimestamp'] += $row_zones['cachetimestamp'];
	$stats['cachesize'] += strlen($row_zones['cachecontents']);
	if ($row_zones['cachecontents'] != '')
		$stats['cachedzones']++;
}


// Expand tree nodes

if (isset($Session["affiliate_nodes"]) && $Session["affiliate_nodes"])
	$node_array = explode (",", $Session["affiliate_nodes"]);
else
	$node_array = array();

// Add ID found in expand to expanded nodes
if (isset($expand) && $expand != '')
	$node_array[] = $expand;

for ($i=0; $i < sizeof($node_array);$i++)
{
	if (isset($collapse) && $collapse == $node_array[$i])
		unset ($node_array[$i]);
	else
	{
		if (isset($affiliates[$node_array[$i]]))
			$affiliates[$node_array[$i]]['expand'] = 1;
	}
}

$Session["affiliate_nodes"] = implode (",", $node_array);
phpAds_SessionDataStore();


// Build Tree
if (isset($zones) && is_array($zones) && count($zones) > 0)
{
	// Add banner to campaigns
	for (reset($zones);$zkey=key($zones);next($zones))
		$affiliates[$zones[$zkey]['affiliateid']]['zones'][$zkey] = $zones[$zkey];
	
	unset ($zones);
}






echo "<br><br>";
echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";	

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
				echo "&nbsp;<a href='affiliate-index.php?listorder=".$listorder."&orderdirection=".$orderdirection."&collapse=".$affiliate['affiliateid']."'><img src='images/triangle-d.gif' align='absmiddle' border='0'></a>&nbsp;";
			else
				echo "&nbsp;<a href='affiliate-index.php?listorder=".$listorder."&orderdirection=".$orderdirection."&expand=".$affiliate['affiliateid']."'><img src='images/triangle-l.gif' align='absmiddle' border='0'></a>&nbsp;";
		}
		else
			echo "&nbsp;<img src='images/spacer.gif' height='16' width='16'>&nbsp;";
			
		echo "<img src='images/icon-affiliate.gif' align='absmiddle'>&nbsp;";
		echo "<a href='zone-index.php?affiliateid=".$affiliate['affiliateid']."'>".$affiliate['name']."</a>";
		echo "</td>";
		
		// ID
		echo "<td height='25'>".$affiliate['affiliateid']."</td>";
		
		// Button 1
		echo "<td height='25'>";
		if ($affiliate['expand'] == '1')
			echo "<a href='zone-edit.php?affiliateid=".$affiliate['affiliateid']."'><img src='images/icon-zone.gif' border='0' align='absmiddle' alt='$strCreate'>&nbsp;$strCreate</a>&nbsp;&nbsp;&nbsp;&nbsp;";
		else
			echo "&nbsp;";
		echo "</td>";
		
		// Button 2
		echo "<td height='25'>";
		echo "<a href='affiliate-edit.php?affiliateid=".$affiliate['affiliateid']."'><img src='images/icon-edit.gif' border='0' align='absmiddle' alt='$strEdit'>&nbsp;$strEdit</a>&nbsp;&nbsp;";
		echo "</td>";
		
		// Button 3
		echo "<td height='25'>";
		echo "<a href='affiliate-delete.php?affiliateid=".$affiliate['affiliateid']."'".phpAds_DelConfirm($strConfirmDeleteAffiliate)."><img src='images/icon-recycle.gif' border='0' align='absmiddle' alt='$strDelete'>&nbsp;$strDelete</a>&nbsp;&nbsp;&nbsp;&nbsp;";
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
				echo "<img src='images/spacer.gif' height='16' width='16'>&nbsp;";
				
				echo "<img src='images/icon-zone.gif' align='absmiddle'>&nbsp;";
				
				echo "<a href='zone-include.php?affiliateid=".$affiliate['affiliateid']."&zoneid=".$zones[$zkey]['zoneid']."'>".$zones[$zkey]['zonename']."</td>";
				echo "</td>";
				
				// ID
				echo "<td height='25'>".$zones[$zkey]['zoneid']."</td>";
				
				// Button 1
				echo "<td height='25'>";
				echo "&nbsp;";
				echo "</td>";
				
				// Button 2
				echo "<td height='25'>";
				echo "<a href='zone-edit.php?affiliateid=".$affiliate['affiliateid']."&zoneid=".$zones[$zkey]['zoneid']."'><img src='images/icon-edit.gif' border='0' align='absmiddle' alt='$strEdit'>&nbsp;$strEdit</a>&nbsp;&nbsp;";
				echo "</td>";
				
				// Button 3
				echo "<td height='25'>";
				echo "<a href='zone-delete.php?affiliateid=".$affiliate['affiliateid']."&zoneid=".$zones[$zkey]['zoneid']."'".phpAds_DelConfirm($strConfirmDeleteZone)."><img src='images/icon-recycle.gif' border='0' align='absmiddle' alt='$strDelete'>&nbsp;$strDelete</a>&nbsp;&nbsp;&nbsp;&nbsp;";
				echo "</td></tr>";
			}
		}
		
		echo "<tr height='1'><td colspan='5' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
		$i++;
	}
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
