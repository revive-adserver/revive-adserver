<?php // $Revision$

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2000-2003 by the phpAdsNew developers                  */
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
phpAds_registerGlobal ('expand', 'collapse', 'listorder', 'orderdirection');


// Security check
phpAds_checkAccess(phpAds_Admin);



/*********************************************************/
/* Get preferences                                       */
/*********************************************************/

if (!isset($listorder))
{
	if (isset($Session['prefs']['stats-banner-affiliates.php']['listorder']))
		$listorder = $Session['prefs']['stats-banner-affiliates.php']['listorder'];
	else
		$listorder = '';
}

if (!isset($orderdirection))
{
	if (isset($Session['prefs']['stats-banner-affiliates.php']['orderdirection']))
		$orderdirection = $Session['prefs']['stats-banner-affiliates.php']['orderdirection'];
	else
		$orderdirection = '';
}

if (isset($Session['prefs']['stats-banner-affiliates.php']['nodes']))
	$node_array = explode (",", $Session['prefs']['stats-banner-affiliates.php']['nodes']);
else
	$node_array = array();



/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

if (isset($Session['prefs']['stats-campaign-banners.php']['listorder']))
	$navorder = $Session['prefs']['stats-campaign-banners.php']['listorder'];
else
	$navorder = '';

if (isset($Session['prefs']['stats-campaign-banners.php']['orderdirection']))
	$navdirection = $Session['prefs']['stats-campaign-banners.php']['orderdirection'];
else
	$navdirection = '';


$res = phpAds_dbQuery("
	SELECT
		*
	FROM
		".$phpAds_config['tbl_banners']."
	WHERE
		clientid = '$campaignid'
	".phpAds_getBannerListOrder($navorder, $navdirection)."
") or phpAds_sqlDie();

while ($row = phpAds_dbFetchArray($res))
{
	phpAds_PageContext (
		phpAds_buildBannerName ($row['bannerid'], $row['description'], $row['alt']),
		"stats-banner-affiliates.php?clientid=".$clientid."&campaignid=".$campaignid."&bannerid=".$row['bannerid'],
		$bannerid == $row['bannerid']
	);
}

phpAds_PageShortcut($strClientProperties, 'client-edit.php?clientid='.$clientid, 'images/icon-client.gif');
phpAds_PageShortcut($strCampaignProperties, 'campaign-edit.php?clientid='.$clientid.'&campaignid='.$campaignid, 'images/icon-campaign.gif');
phpAds_PageShortcut($strBannerProperties, 'banner-edit.php?clientid='.$clientid.'&campaignid='.$campaignid.'&bannerid='.$bannerid, 'images/icon-banner-stored.gif');
phpAds_PageShortcut($strModifyBannerAcl, 'banner-acl.php?clientid='.$clientid.'&campaignid='.$campaignid.'&bannerid='.$bannerid, 'images/icon-acl.gif');


phpAds_PageHeader("2.1.2.2.2");
	echo "<img src='images/icon-client.gif' align='absmiddle'>&nbsp;".phpAds_getParentName($campaignid);
	echo "&nbsp;<img src='images/".$phpAds_TextDirection."/caret-rs.gif'>&nbsp;";
	echo "<img src='images/icon-campaign.gif' align='absmiddle'>&nbsp;".phpAds_getClientName($campaignid);
	echo "&nbsp;<img src='images/".$phpAds_TextDirection."/caret-rs.gif'>&nbsp;";
	echo "<img src='images/icon-banner-stored.gif' align='absmiddle'>&nbsp;<b>".phpAds_getBannerName($bannerid)."</b><br><br>";
	echo phpAds_buildBannerCode($bannerid)."<br><br><br><br>";
	phpAds_ShowSections(array("2.1.2.2.1", "2.1.2.2.2"));



/*********************************************************/
/* Main code                                             */
/*********************************************************/

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
		zoneid, affiliateid, zonename, delivery, what
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
			bannerid = '".$bannerid."'
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
			bannerid = '".$bannerid."'
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
			bannerid = '".$bannerid."'
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



// Build Tree
if (isset($zones) && is_array($zones) && count($zones) > 0)
{
	// Add zone to affiliate
	for (reset($zones);$zkey=key($zones);next($zones))
		$affiliates[$zones[$zkey]['affiliateid']]['zones'][$zkey] = $zones[$zkey];
	
	unset ($zones);
}

$totalviews = 0;
$totalclicks = 0;

if (isset($affiliates) && is_array($affiliates) && count($affiliates) > 0)
{
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
}

$totalviews += $manual['views'];
$totalclicks += $manual['clicks'];


if ($totalviews > 0 || $totalclicks > 0)
{
	echo "<br><br>";
	echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";	
	
	echo "<tr height='25'>";
	echo '<td height="25" width="40%"><b>&nbsp;&nbsp;<a href="stats-banner-affiliates.php?clientid='.$clientid.'&campaignid='.$campaignid.'&bannerid='.$bannerid.'&listorder=name">'.$GLOBALS['strName'].'</a>';
	
	if (($listorder == "name") || ($listorder == ""))
	{
		if  (($orderdirection == "") || ($orderdirection == "down"))
		{
			echo ' <a href="stats-banner-affiliates.php?clientid='.$clientid.'&campaignid='.$campaignid.'&bannerid='.$bannerid.'&orderdirection=up">';
			echo '<img src="images/caret-ds.gif" border="0" alt="" title="">';
		}
		else
		{
			echo ' <a href="stats-banner-affiliates.php?clientid='.$clientid.'&campaignid='.$campaignid.'&bannerid='.$bannerid.'&orderdirection=down">';
			echo '<img src="images/caret-u.gif" border="0" alt="" title="">';
		}
		echo '</a>';
	}
	
	echo '</b></td>';
	echo '<td height="25"><b><a href="stats-banner-affiliates.php?clientid='.$clientid.'&campaignid='.$campaignid.'&bannerid='.$bannerid.'&listorder=id">'.$GLOBALS['strID'].'</a>';
	
	if ($listorder == "id")
	{
		if  (($orderdirection == "") || ($orderdirection == "down"))
		{
			echo ' <a href="stats-banner-affiliates.php?clientid='.$clientid.'&campaignid='.$campaignid.'&bannerid='.$bannerid.'&orderdirection=up">';
			echo '<img src="images/caret-ds.gif" border="0" alt="" title="">';
		}
		else
		{
			echo ' <a href="stats-banner-affiliates.php?clientid='.$clientid.'&campaignid='.$campaignid.'&bannerid='.$bannerid.'&orderdirection=down">';
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
	
	if (isset($affiliates) && is_array($affiliates) && count($affiliates))
	{
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
						echo "&nbsp;<a href='stats-banner-affiliates.php?clientid=".$clientid."&campaignid=".$campaignid."&bannerid=".$bannerid."&collapse=".$affiliate['affiliateid']."'><img src='images/triangle-d.gif' align='absmiddle' border='0'></a>&nbsp;";
					else
						echo "&nbsp;<a href='stats-banner-affiliates.php?clientid=".$clientid."&campaignid=".$campaignid."&bannerid=".$bannerid."&expand=".$affiliate['affiliateid']."'><img src='images/".$phpAds_TextDirection."/triangle-l.gif' align='absmiddle' border='0'></a>&nbsp;";
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
							echo "<img src='images/spacer.gif' height='16' width='16' align='absmiddle'>&nbsp;";
							
							if ($zones[$zkey]['what'] != '')
							{
								if ($zones[$zkey]['delivery'] == phpAds_ZoneBanner)
									echo "<img src='images/icon-zone.gif' align='absmiddle'>&nbsp;";
								elseif ($zones[$zkey]['delivery'] == phpAds_ZoneInterstitial)
									echo "<img src='images/icon-interstitial.gif' align='absmiddle'>&nbsp;";
								elseif ($zones[$zkey]['delivery'] == phpAds_ZonePopup)
									echo "<img src='images/icon-popup.gif' align='absmiddle'>&nbsp;";
								elseif ($zones[$zkey]['delivery'] == phpAds_ZoneText)
									echo "<img src='images/icon-textzone.gif' align='absmiddle'>&nbsp;";
							}
							else
							{
								if ($zones[$zkey]['delivery'] == phpAds_ZoneBanner)
									echo "<img src='images/icon-zone-d.gif' align='absmiddle'>&nbsp;";
								elseif ($zones[$zkey]['delivery'] == phpAds_ZoneInterstitial)
									echo "<img src='images/icon-interstitial-d.gif' align='absmiddle'>&nbsp;";
								elseif ($zones[$zkey]['delivery'] == phpAds_ZonePopup)
									echo "<img src='images/icon-popup-d.gif' align='absmiddle'>&nbsp;";
								elseif ($zones[$zkey]['delivery'] == phpAds_ZoneText)
									echo "<img src='images/icon-textzone-d.gif' align='absmiddle'>&nbsp;";
							}
							
							//echo "<img src='images/icon-zone.gif' align='absmiddle'>&nbsp;";
							
							echo "<a href='stats-zone-history.php?affiliateid=".$affiliate['affiliateid']."&zoneid=".$zones[$zkey]['zoneid']."'>".$zones[$zkey]['zonename']."</td>";
							echo "</td>";
							
							echo "<td height='25'>".$zones[$zkey]['zoneid']."</td>";
							echo "<td height='25' align='".$phpAds_TextAlignRight."'>".phpAds_formatNumber($zones[$zkey]['views'])."</td>";
							echo "<td height='25' align='".$phpAds_TextAlignRight."'>".phpAds_formatNumber($zones[$zkey]['clicks'])."</td>";
							echo "<td height='25' align='".$phpAds_TextAlignRight."'>".phpAds_buildCTR($zones[$zkey]['views'], $zones[$zkey]['clicks'])."&nbsp;&nbsp;</td>";
							echo "</tr>";
						}
					}
				}
				
				echo "<tr height='1'><td colspan='5' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
				$i++;
			}
		}
	}
	
	if ($manual['views'] || $manual['clicks'])
	{
		echo "<tr height='25' ".($i%2==0?"bgcolor='#F6F6F6'":"").">";
		echo "<td height='25'>&nbsp;&nbsp;".$strUnknown."</td>";
		
		echo "<td height='25'>-</td>";
		echo "<td height='25' align='".$phpAds_TextAlignRight."'>".phpAds_formatNumber($manual['views'])."</td>";
		echo "<td height='25' align='".$phpAds_TextAlignRight."'>".phpAds_formatNumber($manual['clicks'])."</td>";
		echo "<td height='25' align='".$phpAds_TextAlignRight."'>".phpAds_buildCTR($manual['views'], $manual['clicks'])."&nbsp;&nbsp;</td>";
		echo "</tr>";
		
		echo "<tr height='1'><td colspan='5' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
	}
	
	
	// Total
	echo "<tr height='25'><td height='25'>&nbsp;&nbsp;<b>".$strTotal."</b></td>";
	echo "<td height='25'>&nbsp;</td>";
	echo "<td height='25' align='".$phpAds_TextAlignRight."'>".phpAds_formatNumber($totalviews)."</td>";
	echo "<td height='25' align='".$phpAds_TextAlignRight."'>".phpAds_formatNumber($totalclicks)."</td>";
	echo "<td height='25' align='".$phpAds_TextAlignRight."'>".phpAds_buildCTR($totalviews, $totalclicks)."&nbsp;&nbsp;</td>";
	echo "</tr>";
	
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

$Session['prefs']['stats-banner-affiliates.php']['listorder'] = $listorder;
$Session['prefs']['stats-banner-affiliates.php']['orderdirection'] = $orderdirection;
$Session['prefs']['stats-banner-affiliates.php']['nodes'] = implode (",", $node_array);

phpAds_SessionDataStore();



/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

phpAds_PageFooter();

?>