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

$extra = '';

$res = phpAds_dbQuery("
	SELECT
		*
	FROM
		".$phpAds_config['tbl_banners']."
	WHERE
		clientid = $campaignid
") or phpAds_sqlDie();

while ($row = phpAds_dbFetchArray($res))
{
	if ($bannerid == $row['bannerid'])
		$extra .= "&nbsp;&nbsp;&nbsp;<img src='images/box-1.gif'>&nbsp;";
	else
		$extra .= "&nbsp;&nbsp;&nbsp;<img src='images/box-0.gif'>&nbsp;";
	
	$extra .= "<a href='stats-banner-affiliates.php?campaignid=$campaignid&bannerid=".$row['bannerid']."'>";
	$extra .= phpAds_buildBannerName ($row['bannerid'], $row['description'], $row['alt']);
	$extra .= "</a>";
	$extra .= "<br>"; 
}
$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";


$extra .= "<br><br><br><br><br>";
$extra .= "<b>$strShortcuts</b><br>";
$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
$extra .= "<img src='images/icon-client.gif' align='absmiddle'>&nbsp;<a href=client-edit.php?clientid=".phpAds_getParentID ($campaignid).">$strClientProperties</a><br>";
$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
$extra .= "<img src='images/icon-edit.gif' align='absmiddle'>&nbsp;<a href=campaign-edit.php?campaignid=$campaignid>$strCampaignProperties</a><br>";
$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
$extra .= "<img src='images/icon-campaign.gif' align='absmiddle'>&nbsp;<a href=campaign-index.php?campaignid=$campaignid>$strBannerOverview</a><br>";
$extra .= "<img src='images/break-el.gif' height='1' width='160' vspace='4'><br>";
$extra .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src='images/icon-banner-stored.gif' align='absmiddle'>&nbsp;<a href=banner-edit.php?campaignid=$campaignid&bannerid=$bannerid>$strBannerProperties</a><br>";
	
if ($phpAds_config['acl'])
{
	$extra .= "<img src='images/break-el.gif' height='1' width='160' vspace='4'><br>";
	$extra .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src='images/icon-acl.gif' align='absmiddle'>&nbsp;<a href=banner-acl.php?campaignid=$campaignid&bannerid=$bannerid>$strModifyBannerAcl</a><br>";
}
$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";


phpAds_PageHeader("2.1.2.2", $extra);
	echo "<img src='images/icon-client.gif' align='absmiddle'>&nbsp;".phpAds_getParentName($campaignid);
	echo "&nbsp;<img src='images/caret-rs.gif'>&nbsp;";
	echo "<img src='images/icon-campaign.gif' align='absmiddle'>&nbsp;".phpAds_getClientName($campaignid);
	echo "&nbsp;<img src='images/caret-rs.gif'>&nbsp;";
	echo "<img src='images/icon-banner-stored.gif' align='absmiddle'>&nbsp;<b>".phpAds_getBannerName($bannerid)."</b><br><br>";
	echo phpAds_getBannerCode($bannerid)."<br><br><br><br>";
	phpAds_ShowSections(array("2.1.2.1", "2.1.2.2"));



/*********************************************************/
/* Main code                                             */
/*********************************************************/

if (!isset($listorder)) 	 $listorder = '';
if (!isset($orderdirection)) $orderdirection = '';

$manual['clicks'] = 0;
$manual['views'] = 0;


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
		zoneid, affiliateid, zonename
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
}


// Get the adviews/clicks for each banner
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
			bannerid = ".$bannerid."
		GROUP BY
			zoneid
		") or phpAds_sqlDie();
	
	while ($row_stats = phpAds_dbFetchArray($res_stats))
	{
		if (isset($zones[$row_stats['zoneid']]))
		{
			$zones[$row_stats['zoneid']]['clicks'] = $row_stats['clicks'];
			$zones[$row_stats['zoneid']]['views'] = $row_stats['views'];
		}
		else
		{
			$manual['clicks'] += $row_stats['clicks'];
			$manual['views'] += $row_stats['views'];
		}
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
			bannerid = ".$bannerid."
		GROUP BY
			zoneid
		") or phpAds_sqlDie();
	
	while ($row_stats = phpAds_dbFetchArray($res_stats))
	{
		if (isset($zones[$row_stats['zoneid']]))
		{
			$zones[$row_stats['zoneid']]['views'] = $row_stats['views'];
			$zones[$row_stats['zoneid']]['clicks'] = 0;
		}
		else
		{
			$manual['views'] += $row_stats['views'];
		}
	}
	
	
	$res_stats = phpAds_dbQuery("
		SELECT
			zoneid,
			count(*) as clicks
		FROM 
			".$phpAds_config['tbl_adclicks']."
		WHERE
			bannerid = ".$bannerid."
		GROUP BY
			zoneid
		") or phpAds_sqlDie();
	
	while ($row_stats = phpAds_dbFetchArray($res_stats))
	{
		if (isset($zones[$row_stats['zoneid']]))
		{
			$zones[$row_stats['zoneid']]['clicks'] = $row_stats['clicks'];
		}
		else
		{
			$manual['clicks'] += $row_stats['clicks'];
		}
	}
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
	// Add zone to affiliate
	for (reset($zones);$zkey=key($zones);next($zones))
		$affiliates[$zones[$zkey]['affiliateid']]['zones'][$zkey] = $zones[$zkey];
	
	unset ($zones);
}

if (isset($affiliates) && is_array($affiliates) && count($affiliates) > 0)
{
	$totalviews = 0;
	$totalclicks = 0;
	
	// Calculate statistics for affiliates
	for (reset($affiliates);$key=key($affiliates);next($affiliates))
	{
		$affiliatesviews = 0;
		$affiliatesclicks = 0;
		
		if (isset($affiliates[$key]['zones']) && sizeof ($affiliates[$key]['zones']) > 0)
		{
			$zones = $affiliates[$key]['zones'];
			
			// Calculate statistics for zones
			for (reset($zones);$zkey=key($zones);next($zones))
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
	
	$totalviews += $manual['views'];
	$totalclicks += $manual['clicks'];
}






echo "<br><br>";
echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";	

echo "<tr height='25'>";
echo '<td height="25"><b>&nbsp;&nbsp;<a href="'.$PHP_SELF.'?campaignid='.$campaignid.'&bannerid='.$bannerid.'&listorder=name">'.$GLOBALS['strName'].'</a>';

if (($listorder == "name") || ($listorder == ""))
{
	if  (($orderdirection == "") || ($orderdirection == "down"))
	{
		echo ' <a href="'.$PHP_SELF.'?campaignid='.$campaignid.'&bannerid='.$bannerid.'&?listorder=name&orderdirection=up">';
		echo '<img src="images/caret-ds.gif" border="0" alt="" title="">';
	}
	else
	{
		echo ' <a href="'.$PHP_SELF.'?campaignid='.$campaignid.'&bannerid='.$bannerid.'&listorder=name&orderdirection=down">';
		echo '<img src="images/caret-u.gif" border="0" alt="" title="">';
	}
	echo '</a>';
}

echo '</b></td>';
echo '<td height="25"><b><a href="'.$PHP_SELF.'?campaignid='.$campaignid.'&bannerid='.$bannerid.'&listorder=id">'.$GLOBALS['strID'].'</a>';

if ($listorder == "id")
{
	if  (($orderdirection == "") || ($orderdirection == "down"))
	{
		echo ' <a href="'.$PHP_SELF.'?campaignid='.$campaignid.'&bannerid='.$bannerid.'&listorder=id&orderdirection=up">';
		echo '<img src="images/caret-ds.gif" border="0" alt="" title="">';
	}
	else
	{
		echo ' <a href="'.$PHP_SELF.'?campaignid='.$campaignid.'&bannerid='.$bannerid.'&listorder=id&orderdirection=down">';
		echo '<img src="images/caret-u.gif" border="0" alt="" title="">';
	}
	echo '</a>';
}

echo '</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>';
echo "<td height='25' align='right'><b>".$GLOBALS['strViews']."</b></td>";
echo "<td height='25' align='right'><b>".$GLOBALS['strClicks']."</b></td>";
echo "<td height='25' align='right'><b>".$GLOBALS['strCTRShort']."</b>&nbsp;&nbsp;</td>";
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
		
		if ($affiliate['views'] || $affiliate['clicks'])
		{
			echo "<tr height='25' ".($i%2==0?"bgcolor='#F6F6F6'":"").">";
			
			// Icon & name
			echo "<td height='25'>";
			if (isset($affiliate['zones']))
			{
				if ($affiliate['expand'] == '1')
					echo "&nbsp;<a href='stats-banner-affiliates.php?campaignid=".$campaignid."&bannerid=".$bannerid."&listorder=".$listorder."&orderdirection=".$orderdirection."&collapse=".$affiliate['affiliateid']."'><img src='images/triangle-d.gif' align='absmiddle' border='0'></a>&nbsp;";
				else
					echo "&nbsp;<a href='stats-banner-affiliates.php?campaignid=".$campaignid."&bannerid=".$bannerid."&listorder=".$listorder."&orderdirection=".$orderdirection."&expand=".$affiliate['affiliateid']."'><img src='images/triangle-l.gif' align='absmiddle' border='0'></a>&nbsp;";
			}
			else
				echo "&nbsp;<img src='images/spacer.gif' height='16' width='16'>&nbsp;";
				
			echo "<img src='images/icon-affiliate.gif' align='absmiddle'>&nbsp;";
			echo "<a href='stats-affiliate-history.php?affiliateid=".$affiliate['affiliateid']."'>".$affiliate['name']."</a>";
			echo "</td>";
			
			echo "<td height='25'>".$affiliate['affiliateid']."</td>";
			echo "<td height='25' align='right'>".$affiliate['views']."</td>";
			echo "<td height='25' align='right'>".$affiliate['clicks']."</td>";
			echo "<td height='25' align='right'>".phpAds_buildCTR($affiliate['views'], $affiliate['clicks'])."&nbsp;&nbsp;</td>";
			echo "</tr>";
			
			
			
			if (isset($affiliate['zones']) && sizeof ($affiliate['zones']) > 0 && $affiliate['expand'] == '1')
			{
				$zones = $affiliate['zones'];
				
				for (reset($zones);$zkey=key($zones);next($zones))
				{
					if ($zones[$zkey]['views'] || $zones[$zkey]['clicks'])
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
						echo "<a href='stats-zone-history.php?affiliateid=".$affiliate['affiliateid']."&zoneid=".$zones[$zkey]['zoneid']."'>".$zones[$zkey]['zonename']."</td>";
						echo "</td>";
						
						echo "<td height='25'>".$zones[$zkey]['zoneid']."</td>";
						echo "<td height='25' align='right'>".$zones[$zkey]['views']."</td>";
						echo "<td height='25' align='right'>".$zones[$zkey]['clicks']."</td>";
						echo "<td height='25' align='right'>".phpAds_buildCTR($zones[$zkey]['views'], $zones[$zkey]['clicks'])."&nbsp;&nbsp;</td>";
						echo "</tr>";
					}
				}
			}
			
			echo "<tr height='1'><td colspan='5' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
			$i++;
		}
	}
	
	
	if ($manual['views'] || $manual['clicks'])
	{
		echo "<tr height='25' ".($i%2==0?"bgcolor='#F6F6F6'":"").">";
		echo "<td height='25'>&nbsp;&nbsp;".$strUnknown."</td>";
		
		echo "<td height='25'>-</td>";
		echo "<td height='25' align='right'>".$manual['views']."</td>";
		echo "<td height='25' align='right'>".$manual['clicks']."</td>";
		echo "<td height='25' align='right'>".phpAds_buildCTR($manual['views'], $manual['clicks'])."&nbsp;&nbsp;</td>";
		echo "</tr>";
		
		echo "<tr height='1'><td colspan='5' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
	}
	
	
	// Total
	echo "<tr height='25'><td height='25'>&nbsp;&nbsp;<b>".$strTotal."</b></td>";
	echo "<td height='25'>&nbsp;</td>";
	echo "<td height='25' align='right'>".$totalviews."</td>";
	echo "<td height='25' align='right'>".$totalclicks."</td>";
	echo "<td height='25' align='right'>".phpAds_buildCTR($totalviews, $totalclicks)."&nbsp;&nbsp;</td>";
	echo "</tr>";
}

echo "</table>";

echo "<br><br>";

/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

phpAds_PageFooter();

?>
