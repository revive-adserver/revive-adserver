<?php // $Revision$

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2000-2006 by the phpAdsNew developers                  */
/* For more information visit: http://www.phpadsnew.com                 */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/



// Include required files
require ("config.php");
require ("lib-statistics.inc.php");
require ("lib-size.inc.php");
require ("lib-zones.inc.php");


// Register input variables
phpAds_registerGlobal ('expand', 'collapse', 'listorder', 'orderdirection', 'period', 'period_range');


// Security check
phpAds_checkAccess(phpAds_Admin);


// Set default values
$tabindex = 1;



/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

phpAds_PageHeader("2.4");
phpAds_ShowSections(array("2.1", "2.4", "2.2", "2.5"));



/*********************************************************/
/* Get preferences                                       */
/*********************************************************/

if (!isset($listorder))
{
	if (isset($Session['prefs']['stats-global-affiliates.php']['listorder']))
		$listorder = $Session['prefs']['stats-global-affiliates.php']['listorder'];
	else
		$listorder = '';
}

if (!isset($orderdirection))
{
	if (isset($Session['prefs']['stats-global-affiliates.php']['orderdirection']))
		$orderdirection = $Session['prefs']['stats-global-affiliates.php']['orderdirection'];
	else
		$orderdirection = '';
}

if (isset($Session['prefs']['stats-global-affiliates.php']['nodes']))
	$node_array = explode (",", $Session['prefs']['stats-global-affiliates.php']['nodes']);
else
	$node_array = array();


if (!isset($period))
{
	if (isset($Session['prefs']['stats-global-affiliates.php']['period']))
		$period = $Session['prefs']['stats-global-affiliates.php']['period'];
	else
		$period = '';
}


if (!isset($period_range))
{
	if (isset($Session['prefs']['stats-global-affiliates.php']['period_range']))
		$period_range = $Session['prefs']['stats-global-affiliates.php']['period_range'];
	else
		$period_range = array (
			'start_day' => 0,
			'start_month' => 0,
			'start_year' => 0,
			'end_day' => 0,
			'end_month' => 0,
			'end_year' => 0
		);
}



/*********************************************************/
/* Main code                                             */
/*********************************************************/

// Get affiliates and build the tree
$res_affiliates = phpAds_dbQuery("
	SELECT 
		affiliateid, name
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
		zoneid, affiliateid, zonename, delivery
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
		
		$zones[$row_zones['zoneid']]['views'] = 0;
		$zones[$row_zones['zoneid']]['clicks'] = 0;
	}
	
	$zoneids[] = $row_zones['zoneid'];
}





// Check period range
if ($period_range['start_month'] == 0 || $period_range['start_day'] == 0 || $period_range['start_year'] == 0)
{
	$period_begin = 0;
	$period_range['start_day'] = $period_range['start_month'] = $period_range['start_year'] = 0;
}
else
	$period_begin = mktime(0, 0, 0, $period_range['start_month'], $period_range['start_day'], $period_range['start_year']);


if ($period_range['end_month'] == 0 || $period_range['end_day'] == 0 || $period_range['end_year'] == 0)
{
	$period_end = mktime(0, 0, 0, date('m'), date('d') + 1, date('Y'));
	$period_range['end_day'] = $period_range['end_month'] = $period_range['end_year'] = 0;
}
else
	$period_end = mktime(0, 0, 0, $period_range['end_month'], $period_range['end_day'], $period_range['end_year']);



if (!$phpAds_config['compact_stats'])
{
	switch ($period)
	{
		case 'r':	$limit 		    	= " AND t_stamp >= ".date('YmdHis', $period_begin)." AND t_stamp < ".date('YmdHis', $period_end);
					break;
				
		case 'y':	$timestamp_begin	= mktime(0, 0, 0, date('m'), date('d') - 1, date('Y'));	
					$timestamp_end		= mktime(0, 0, 0, date('m'), date('d'), date('Y'));
					$limit 		    	= " AND t_stamp >= ".date('YmdHis', $timestamp_begin)." AND t_stamp < ".date('YmdHis', $timestamp_end);
					break;
				
		case 't':	$timestamp_begin	= mktime(0, 0, 0, date('m'), date('d'), date('Y'));
					$limit 				= " AND t_stamp >= ".date('YmdHis', $timestamp_begin);
					break;
				
		case 'w':	$timestamp_begin	= mktime(0, 0, 0, date('m'), date('d') - 6, date('Y'));
					$limit 				= " AND t_stamp >= ".date('YmdHis', $timestamp_begin);
					break;
				
		case 'm':	$timestamp_begin	= mktime(0, 0, 0, date('m'), 1, date('Y'));
					$limit 				= " AND t_stamp >= ".date('YmdHis', $timestamp_begin);
					break;
				
		case 'l':	$timestamp_begin	= mktime(0, 0, 0, date('m')-1, 1, date('Y'));
					$timestamp_end		= mktime(0, 0, 0, date('m'), 1, date('Y'));
					$limit 		    	= " AND t_stamp >= ".date('YmdHis', $timestamp_begin)." AND t_stamp < ".date('YmdHis', $timestamp_end);
					break;
				
		case 'z':	$timestamp_begin	= mktime(0, 0, 0, 1, 1, date('Y'));
					$limit 				= " AND t_stamp >= ".date('YmdHis', $timestamp_begin);
					break;

		case 'x':	$timestamp_begin	= mktime(0, 0, 0, 1, 1, date('Y')-1);
					$timestamp_end		= mktime(0, 0, 0, 1, 1, date('Y'));
					$limit 		    	= " AND t_stamp >= ".date('YmdHis', $timestamp_begin)." AND t_stamp < ".date('YmdHis', $timestamp_end);
					break;

		default:	$limit = '';
					$period = '';
					break;
	}
}
else
{
	switch ($period)
	{
		case 'r':	$limit 		    	= " AND day >= ".date('Ymd', $period_begin)." AND day < ".date('Ymd', $period_end);
					break;
				
		case 'y':	$timestamp_begin	= mktime(0, 0, 0, date('m'), date('d') - 1, date('Y'));
					$timestamp_end		= mktime(0, 0, 0, date('m'), date('d'), date('Y'));
					$limit 				= " AND day >= ".date('Ymd', $timestamp_begin)." AND day < ".date('Ymd', $timestamp_end);
					break;
				
		case 't':	$timestamp_begin	= mktime(0, 0, 0, date('m'), date('d'), date('Y'));
					$limit 				= " AND day >= ".date('Ymd', $timestamp_begin);
					break;
				
		case 'w':	$timestamp_begin	= mktime(0, 0, 0, date('m'), date('d') - 6, date('Y'));
					$limit 				= " AND day >= ".date('Ymd', $timestamp_begin);
					break;
				
		case 'm':	$timestamp_begin	= mktime(0, 0, 0, date('m'), 1, date('Y'));
					$limit 				= " AND day >= ".date('Ymd', $timestamp_begin);
					break;
				
		case 'l':	$timestamp_begin	= mktime(0, 0, 0, date('m')-1, 1, date('Y'));
					$timestamp_end		= mktime(0, 0, 0, date('m'), 1, date('Y'));
					$limit 				= " AND day >= ".date('Ymd', $timestamp_begin)." AND day < ".date('Ymd', $timestamp_end);
					break;
				
		case 'z':	$timestamp_begin	= mktime(0, 0, 0, 1, 1, date('Y'));
					$limit 				= " AND day >= ".date('Ymd', $timestamp_begin);
					break;

		case 'x':	$timestamp_begin	= mktime(0, 0, 0, 1, 1, date('Y')-1);
					$timestamp_end		= mktime(0, 0, 0, 1, 1, date('Y'));
					$limit 				= " AND day >= ".date('Ymd', $timestamp_begin)." AND day < ".date('Ymd', $timestamp_end);
					break;

		default:	$limit = '';
					$period = '';
					break;
	}
}


// Get the adviews/clicks for each banner
if (count($zoneids))
{
	if ($phpAds_config['compact_stats'])
	{
		$res_stats = phpAds_dbQuery("
			SELECT
				zoneid,
				sum(views) as views,
				sum(clicks) as clicks
			FROM 
				".$phpAds_config['tbl_adstats']."
			WHERE
				zoneid IN (".join(', ', $zoneids).")".$limit."
			GROUP BY
				zoneid
			") or phpAds_sqlDie();
		
		while ($row_stats = phpAds_dbFetchArray($res_stats))
		{
			$zones[$row_stats['zoneid']]['clicks'] = $row_stats['clicks'];
			$zones[$row_stats['zoneid']]['views'] = $row_stats['views'];
		}
	}
	else
	{
		$res_stats = phpAds_dbQuery("
			SELECT
				zoneid,
				count(*) as views
			FROM 
				".$phpAds_config['tbl_adviews']."
			WHERE
				zoneid IN (".join(', ', $zoneids).")".$limit."
			GROUP BY
				zoneid
			") or phpAds_sqlDie();
		
		while ($row_stats = phpAds_dbFetchArray($res_stats))
		{
			$zones[$row_stats['zoneid']]['views'] = $row_stats['views'];
			$zones[$row_stats['zoneid']]['clicks'] = 0;
		}
		
		
		$res_stats = phpAds_dbQuery("
			SELECT
				zoneid,
				count(*) as clicks
			FROM 
				".$phpAds_config['tbl_adclicks']."
			WHERE
				zoneid IN (".join(', ', $zoneids).")".$limit."
			GROUP BY
				zoneid
			") or phpAds_sqlDie();
		
		while ($row_stats = phpAds_dbFetchArray($res_stats))
		{
			$zones[$row_stats['zoneid']]['clicks'] = $row_stats['clicks'];
		}
	}
}


// Add ID found in expand to expanded nodes
if (isset($expand) && $expand != '')
{
	switch ($expand)
	{
		case 'all' :	$node_array   = array();
						if (isset($affiliates)) foreach (array_keys($affiliates) as $key)	$node_array[] = $key;
						break;
						
		case 'none':	$node_array   = array();
						break;
						
		default:		$node_array[] = $expand;
						break;
	}
}

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
	// Add zone to affiliate
	foreach (array_keys($zones) as $zkey)
		$affiliates[$zones[$zkey]['affiliateid']]['zones'][$zkey] = $zones[$zkey];
	
	unset ($zones);
}

$totalviews = 0;
$totalclicks = 0;

if (isset($affiliates) && is_array($affiliates) && count($affiliates) > 0)
{
	// Calculate statistics for affiliates
	foreach (array_keys($affiliates) as $key)
	{
		$affiliatesviews = 0;
		$affiliatesclicks = 0;
		
		if (isset($affiliates[$key]['zones']) && sizeof ($affiliates[$key]['zones']) > 0)
		{
			$zones = $affiliates[$key]['zones'];
			
			// Calculate statistics for zones
			foreach (array_keys($zones) as $zkey)
			{
				$affiliatesviews += $zones[$zkey]['views'];
				$affiliatesclicks += $zones[$zkey]['clicks'];
			}
		}
		
		$totalviews += $affiliatesviews;
		$totalclicks += $affiliatesclicks;
		
		$affiliates[$key]['clicks'] = $affiliatesclicks;
		$affiliates[$key]['views'] = $affiliatesviews;
	}
	
	unset ($zones);
}



echo "<form action='".$_SERVER['PHP_SELF']."'>";

echo "<select name='period' onChange='this.form.submit();' accesskey='".$keyList."' tabindex='".($tabindex++)."'>";
	echo "<option value=''".($period == '' ? ' selected' : '').">".$strCollectedAll."</option>";
	echo "<option value='' disabled>-----------------------------------------</option>";
	echo "<option value='t'".($period == 't' ? ' selected' : '').">".$strCollectedToday."</option>";
	echo "<option value='y'".($period == 'y' ? ' selected' : '').">".$strCollectedYesterday."</option>";
	echo "<option value='w'".($period == 'w' ? ' selected' : '').">".$strCollected7Days."</option>";
	echo "<option value='m'".($period == 'm' ? ' selected' : '').">".$strCollectedMonth."</option>";
	echo "<option value='l'".($period == 'l' ? ' selected' : '').">".$strCollectedLastMonth."</option>";
	echo "<option value='z'".($period == 'z' ? ' selected' : '').">".$strCollectedYear."</option>";
	echo "<option value='x'".($period == 'x' ? ' selected' : '').">".$strCollectedLastYear."</option>";
	echo "<option value='' disabled>-----------------------------------------</option>";
	echo "<option value='r'".($period == 'r' ? ' selected' : '').">".$strCollectedRange."</option>";
echo "</select>";


if ($period == 'r')
{
	phpAds_ShowBreak();
	echo $strFrom."&nbsp;&nbsp;";
	
	// Starting date
	echo "<select name='period_range[start_day]'>\n";
	echo "<option value='0'".($period_range['start_day'] == 0 ? ' selected' : '').">-</option>\n";
	for ($i=1;$i<=31;$i++)
		echo "<option value='$i'".($i == $period_range['start_day'] ? ' selected' : '').">$i</option>\n";
	echo "</select>&nbsp;\n";
	
	echo "<select name='period_range[start_month]'>\n";
	echo "<option value='0'".($period_range['start_month'] == 0 ? ' selected' : '').">-</option>\n";
	for ($i=1;$i<=12;$i++)
		echo "<option value='$i'".($i == $period_range['start_month'] ? ' selected' : '').">".$strMonth[$i-1]."</option>\n";
	echo "</select>&nbsp;\n";
	
	echo "<select name='period_range[start_year]'>\n";
	echo "<option value='0'".($period_range['start_year'] == 0 ? ' selected' : '').">-</option>\n";
	for ($i=date('Y')-4;$i<=date('Y');$i++)
		echo "<option value='$i'".($i == $period_range['start_year'] ? ' selected' : '').">$i</option>\n";
	echo "</select>\n";	
	
	// To
	echo "&nbsp;$strTo&nbsp;&nbsp;";
	
	// End date
	echo "<select name='period_range[end_day]'>\n";
	echo "<option value='0'".($period_range['end_day'] == 0 ? ' selected' : '').">-</option>\n";
	for ($i=1;$i<=31;$i++)
		echo "<option value='$i'".($i == $period_range['end_day'] ? ' selected' : '').">$i</option>\n";
	echo "</select>&nbsp;\n";
	
	echo "<select name='period_range[end_month]'>\n";
	echo "<option value='0'".($period_range['end_month'] == 0 ? ' selected' : '').">-</option>\n";
	for ($i=1;$i<=12;$i++)
		echo "<option value='$i'".($i == $period_range['end_month'] ? ' selected' : '').">".$strMonth[$i-1]."</option>\n";
	echo "</select>&nbsp;\n";
	
	echo "<select name='period_range[end_year]'>\n";
	echo "<option value='0'".($period_range['end_year'] == 0 ? ' selected' : '').">-</option>\n";
	for ($i=date('Y')-4;$i<=date('Y');$i++)
		echo "<option value='$i'".($i == $period_range['end_year'] ? ' selected' : '').">$i</option>\n";
	echo "</select>\n";	
	
	echo "&nbsp;";
	echo "<input type='image' src='images/".$phpAds_TextDirection."/go_blue.gif'>";
}

phpAds_ShowBreak();
echo "</form>";



if ($totalviews > 0 || $totalclicks > 0)
{
	echo "<br><br>";
	echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";	
	
	echo "<tr height='25'>";
	echo '<td height="25"><b>&nbsp;&nbsp;<a href="stats-global-affiliates.php?listorder=name">'.$GLOBALS['strName'].'</a>';
	
	if (($listorder == "name") || ($listorder == ""))
	{
		if  (($orderdirection == "") || ($orderdirection == "down"))
		{
			echo ' <a href="stats-global-affiliates.php?orderdirection=up">';
			echo '<img src="images/caret-ds.gif" border="0" alt="" title="">';
		}
		else
		{
			echo ' <a href="stats-global-affiliates.php?orderdirection=down">';
			echo '<img src="images/caret-u.gif" border="0" alt="" title="">';
		}
		echo '</a>';
	}
	
	echo '</b></td>';
	echo '<td height="25"><b><a href="stats-global-affiliates.php?listorder=id">'.$GLOBALS['strID'].'</a>';
	
	if ($listorder == "id")
	{
		if  (($orderdirection == "") || ($orderdirection == "down"))
		{
			echo ' <a href="stats-global-affiliates.php?orderdirection=up">';
			echo '<img src="images/caret-ds.gif" border="0" alt="" title="">';
		}
		else
		{
			echo ' <a href="stats-global-affiliates.php?orderdirection=down">';
			echo '<img src="images/caret-u.gif" border="0" alt="" title="">';
		}
		echo '</a>';
	}
	
	echo '</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>';
	echo "<td height='25' align='".$phpAds_TextAlignRight."'><b>".$GLOBALS['strViews']."</b></td>";
	echo "<td height='25' align='".$phpAds_TextAlignRight."'><b>".$GLOBALS['strClicks']."</b></td>";
	echo "<td height='25' align='".$phpAds_TextAlignRight."'><b>".$GLOBALS['strCTRShort']."</b>&nbsp;&nbsp;</td>";
	echo "</tr>";
	
	echo "<tr height='1'><td colspan='5' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
	
	
	$i=0;
	foreach (array_keys($affiliates) as $key)
	{
		$affiliate = $affiliates[$key];
		
		echo "<tr height='25' ".($i%2==0?"bgcolor='#F6F6F6'":"").">";
		
		// Icon & name
		echo "<td height='25'>";
		if (isset($affiliate['zones']))
		{
			if ($affiliate['expand'] == '1')
				echo "&nbsp;<a href='stats-global-affiliates.php?listorder=".$listorder."&orderdirection=".$orderdirection."&collapse=".$affiliate['affiliateid']."'><img src='images/triangle-d.gif' align='absmiddle' border='0'></a>&nbsp;";
			else
				echo "&nbsp;<a href='stats-global-affiliates.php?listorder=".$listorder."&orderdirection=".$orderdirection."&expand=".$affiliate['affiliateid']."'><img src='images/".$phpAds_TextDirection."/triangle-l.gif' align='absmiddle' border='0'></a>&nbsp;";
		}
		else
			echo "&nbsp;<img src='images/spacer.gif' height='16' width='16'>&nbsp;";
			
		echo "<img src='images/icon-affiliate.gif' align='absmiddle'>&nbsp;";
		echo "<a href='stats-affiliate-history.php?affiliateid=".$affiliate['affiliateid']."'>".$affiliate['name']."</a>";
		echo "</td>";
		
		echo "<td height='25'>".$affiliate['affiliateid']."</td>";
		echo "<td height='25' align='".$phpAds_TextAlignRight."'>".phpAds_formatNumber($affiliate['views'])."</td>";
		echo "<td height='25' align='".$phpAds_TextAlignRight."'>".phpAds_formatNumber($affiliate['clicks'])."</td>";
		echo "<td height='25' align='".$phpAds_TextAlignRight."'>".phpAds_buildCTR($affiliate['views'], $affiliate['clicks'])."&nbsp;&nbsp;</td>";
		echo "</tr>";
		
		
		
		if (isset($affiliate['zones']) && sizeof ($affiliate['zones']) > 0 && $affiliate['expand'] == '1')
		{
			$zones = $affiliate['zones'];
			
			foreach (array_keys($zones) as $zkey)
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
				
				if ($zones[$zkey]['delivery'] == phpAds_ZoneBanner)
					echo "<img src='images/icon-zone.gif' align='absmiddle'>&nbsp;";
				elseif ($zones[$zkey]['delivery'] == phpAds_ZoneInterstitial)
					echo "<img src='images/icon-interstitial.gif' align='absmiddle'>&nbsp;";
				elseif ($zones[$zkey]['delivery'] == phpAds_ZonePopup)
					echo "<img src='images/icon-popup.gif' align='absmiddle'>&nbsp;";
				elseif ($zones[$zkey]['delivery'] == phpAds_ZoneText)
					echo "<img src='images/icon-textzone.gif' align='absmiddle'>&nbsp;";
				
				echo "<a href='stats-zone-history.php?affiliateid=".$affiliate['affiliateid']."&zoneid=".$zones[$zkey]['zoneid']."'>".$zones[$zkey]['zonename']."</td>";
				echo "</td>";
				
				echo "<td height='25'>".$zones[$zkey]['zoneid']."</td>";
				echo "<td height='25' align='".$phpAds_TextAlignRight."'>".phpAds_formatNumber($zones[$zkey]['views'])."</td>";
				echo "<td height='25' align='".$phpAds_TextAlignRight."'>".phpAds_formatNumber($zones[$zkey]['clicks'])."</td>";
				echo "<td height='25' align='".$phpAds_TextAlignRight."'>".phpAds_buildCTR($zones[$zkey]['views'], $zones[$zkey]['clicks'])."&nbsp;&nbsp;</td>";
				echo "</tr>";
			}
		}
		
		echo "<tr height='1'><td colspan='5' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
		$i++;
	}
	
	// Total
	echo "<tr height='25' ".($i % 2 == 0 ? "bgcolor='#F6F6F6'" : "")."><td height='25'>&nbsp;&nbsp;<b>".$strTotal."</b></td>";
	echo "<td height='25'>&nbsp;</td>";
	echo "<td height='25' align='".$phpAds_TextAlignRight."'>".phpAds_formatNumber($totalviews)."</td>";
	echo "<td height='25' align='".$phpAds_TextAlignRight."'>".phpAds_formatNumber($totalclicks)."</td>";
	echo "<td height='25' align='".$phpAds_TextAlignRight."'>".phpAds_buildCTR($totalviews, $totalclicks)."&nbsp;&nbsp;</td>";
	echo "</tr>";
	echo "<tr height='1'><td colspan='5' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
	
	echo "<tr><td height='25' colspan='5' align='".$phpAds_TextAlignRight."'>";
	echo "<img src='images/triangle-d.gif' align='absmiddle' border='0'>";
	echo "&nbsp;<a href='stats-global-affiliates.php?expand=all' accesskey='".$keyExpandAll."'>".$strExpandAll."</a>";
	echo "&nbsp;&nbsp;|&nbsp;&nbsp;";
	echo "<img src='images/".$phpAds_TextDirection."/triangle-l.gif' align='absmiddle' border='0'>";
	echo "&nbsp;<a href='stats-global-affiliates.php?expand=none' accesskey='".$keyCollapseAll."'>".$strCollapseAll."</a>";
	echo "</td></tr>";
	
	echo "</table>";
	echo "<br><br>";
}
else
{
	echo "<br><div class='errormessage'><img class='errormessage' src='images/info.gif' width='16' height='16' border='0' align='absmiddle'>";
	echo $strNoStats.'</div>';
}



/*********************************************************/
/* Store preferences                                     */
/*********************************************************/

$Session['prefs']['stats-global-affiliates.php']['listorder'] = $listorder;
$Session['prefs']['stats-global-affiliates.php']['orderdirection'] = $orderdirection;
$Session['prefs']['stats-global-affiliates.php']['nodes'] = implode (",", $node_array);

$Session['prefs']['stats-global-affiliates.php']['period'] = $period;
$Session['prefs']['stats-global-affiliates.php']['period_range'] = $period_range;

phpAds_SessionDataStore();



/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

phpAds_PageFooter();

?>