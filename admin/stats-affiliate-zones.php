<?php // $Revision$

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2000-2002 by the phpAdsNew developers                  */
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
phpAds_checkAccess(phpAds_Admin+phpAds_Affiliate);



/*********************************************************/
/* Affiliate interface security                          */
/*********************************************************/

if (phpAds_isUser(phpAds_Affiliate))
{
	$affiliateid = phpAds_getUserID();
}



/*********************************************************/
/* Get preferences                                       */
/*********************************************************/

if (!isset($listorder))
{
	if (isset($Session['prefs']['stats-affiliate-zones.php']['listorder']))
		$listorder = $Session['prefs']['stats-affiliate-zones.php']['listorder'];
	else
		$listorder = '';
}

if (!isset($orderdirection))
{
	if (isset($Session['prefs']['stats-affiliate-zones.php']['orderdirection']))
		$orderdirection = $Session['prefs']['stats-affiliate-zones.php']['orderdirection'];
	else
		$orderdirection = '';
}

if (isset($Session['prefs']['stats-affiliate-zones.php']['nodes']))
	$node_array = explode (",", $Session['prefs']['stats-affiliate-zones.php']['nodes']);
else
	$node_array = array();



/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

if (phpAds_isUser(phpAds_Admin))
{
	$res = phpAds_dbQuery("
		SELECT
			*
		FROM
			".$phpAds_config['tbl_affiliates']."
	") or phpAds_sqlDie();
	
	while ($row = phpAds_dbFetchArray($res))
	{
		phpAds_PageContext (
			phpAds_buildAffiliateName ($row['affiliateid'], $row['name']),
			"stats-affiliate-zones.php?affiliateid=".$row['affiliateid'],
			$affiliateid == $row['affiliateid']
		);
	}
	
	phpAds_PageShortcut($strAffiliateProperties, 'affiliate-edit.php?affiliateid='.$affiliateid, 'images/icon-affiliate.gif');
	
	
	phpAds_PageHeader("2.4.2");
		echo "<img src='images/icon-affiliate.gif' align='absmiddle'>&nbsp;<b>".phpAds_getAffiliateName($affiliateid)."</b><br><br><br>";
		phpAds_ShowSections(array("2.4.1", "2.4.2"));
}
else
{
	phpAds_PageHeader("1.1");
	
	if ($phpAds_config['client_welcome'])
	{
		echo "<br><br>";
		// Show welcome message
		if (!empty($phpAds_client_welcome_msg))
			echo $phpAds_client_welcome_msg;
		else
			include('templates/welcome-publisher.html');
		echo "<br><br>";
	}
	
	phpAds_ShowSections(array("1.1", "1.2"));
}


/*********************************************************/
/* Main code                                             */
/*********************************************************/

// Get the zones for each affiliate
$res_zones = phpAds_dbQuery("
	SELECT 
		zoneid, affiliateid, zonename, what, delivery
	FROM 
		".$phpAds_config['tbl_zones']."
	WHERE
		affiliateid = ".$affiliateid."
		".phpAds_getZoneListOrder ($listorder, $orderdirection)."
	") or phpAds_sqlDie();

while ($row_zones = phpAds_dbFetchArray($res_zones))
{
	$zones[$row_zones['zoneid']] = $row_zones;
	$zones[$row_zones['zoneid']]['views'] = 0;
	$zones[$row_zones['zoneid']]['clicks'] = 0;
}


// Get the adviews/clicks for each banner
if ($phpAds_config['compact_stats'])
{
	$res_stats = phpAds_dbQuery("
		SELECT
			s.zoneid as zoneid,
			s.bannerid as bannerid,
			sum(s.views) as views,
			sum(s.clicks) as clicks
		FROM 
			".$phpAds_config['tbl_adstats']." as s,
			".$phpAds_config['tbl_zones']." as z
		WHERE
			s.zoneid = z.zoneid AND
			z.affiliateid = ".$affiliateid."
		GROUP BY
			zoneid, bannerid
		") or phpAds_sqlDie();
	
	while ($row_stats = phpAds_dbFetchArray($res_stats))
	{
		if (isset($zones[$row_stats['zoneid']]))
		{
			$zones[$row_stats['zoneid']]['banners'][$row_stats['bannerid']]['bannerid'] = $row_stats['bannerid'];
			$zones[$row_stats['zoneid']]['banners'][$row_stats['bannerid']]['clicks'] = $row_stats['clicks'];
			$zones[$row_stats['zoneid']]['banners'][$row_stats['bannerid']]['views'] = $row_stats['views'];
		}
	}
}
else
{
	$res_stats = phpAds_dbQuery("
		SELECT
			s.zoneid as zoneid,
			s.bannerid as bannerid,
			count(s.bannerid) as views
		FROM 
			".$phpAds_config['tbl_adviews']." as s,
			".$phpAds_config['tbl_zones']." as z
		WHERE
			s.zoneid = z.zoneid AND
			z.affiliateid = ".$affiliateid."
		GROUP BY
			zoneid, bannerid
		") or phpAds_sqlDie();
	
	while ($row_stats = phpAds_dbFetchArray($res_stats))
	{
		if (isset($zones[$row_stats['zoneid']]))
		{
			$zones[$row_stats['zoneid']]['banners'][$row_stats['bannerid']]['bannerid'] = $row_stats['bannerid'];
			$zones[$row_stats['zoneid']]['banners'][$row_stats['bannerid']]['views'] = $row_stats['views'];
			$zones[$row_stats['zoneid']]['banners'][$row_stats['bannerid']]['clicks'] = 0;
		}
	}
	
	
	$res_stats = phpAds_dbQuery("
		SELECT
			s.zoneid as zoneid,
			s.bannerid as bannerid,
			count(s.bannerid) as clicks
		FROM 
			".$phpAds_config['tbl_adclicks']." as s,
			".$phpAds_config['tbl_zones']." as z
		WHERE
			s.zoneid = z.zoneid AND
			z.affiliateid = ".$affiliateid."
		GROUP BY
			zoneid, bannerid
		") or phpAds_sqlDie();
	
	while ($row_stats = phpAds_dbFetchArray($res_stats))
	{
		if (isset($zones[$row_stats['zoneid']]))
		{
			$zones[$row_stats['zoneid']]['banners'][$row_stats['bannerid']]['bannerid'] = $row_stats['bannerid'];
			$zones[$row_stats['zoneid']]['banners'][$row_stats['bannerid']]['clicks'] = $row_stats['clicks'];
		}
	}
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
		if (isset($zones[$node_array[$i]]))
			$zones[$node_array[$i]]['expand'] = 1;
	}
}



if (isset($zones) && is_array($zones) && count($zones) > 0)
{
	$totalviews = 0;
	$totalclicks = 0;
	
	// Calculate statistics for affiliates
	for (reset($zones);$key=key($zones);next($zones))
	{
		$zoneviews = 0;
		$zoneclicks = 0;
		
		if (isset($zones[$key]['banners']) && sizeof ($zones[$key]['banners']) > 0)
		{
			$banners = $zones[$key]['banners'];
			
			// Calculate statistics for zones
			while (list ($bkey,) = each ($banners))
			{
				$zoneviews += $banners[$bkey]['views'];
				$zoneclicks += $banners[$bkey]['clicks'];
			}
		}
		
		$totalviews += $zoneviews;
		$totalclicks += $zoneclicks;
		
		$zones[$key]['clicks'] = $zoneclicks;
		$zones[$key]['views'] = $zoneviews;
	}
	
	unset ($banners);
}



echo "<br><br>";
echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";	

echo "<tr height='25'>";
echo '<td height="25"><b>&nbsp;&nbsp;<a href="stats-affiliate-zones.php?affiliateid='.$affiliateid.'&listorder=name">'.$GLOBALS['strName'].'</a>';

if (($listorder == "name") || ($listorder == ""))
{
	if  (($orderdirection == "") || ($orderdirection == "down"))
	{
		echo ' <a href="stats-affiliate-zones.php?affiliateid='.$affiliateid.'&orderdirection=up">';
		echo '<img src="images/caret-ds.gif" border="0" alt="" title="">';
	}
	else
	{
		echo ' <a href="stats-affiliate-zones.php?affiliateid='.$affiliateid.'&orderdirection=down">';
		echo '<img src="images/caret-u.gif" border="0" alt="" title="">';
	}
	echo '</a>';
}

echo '</b></td>';
echo '<td height="25"><b><a href="stats-affiliate-zones.php?affiliateid='.$affiliateid.'&listorder=id">'.$GLOBALS['strID'].'</a>';

if ($listorder == "id")
{
	if  (($orderdirection == "") || ($orderdirection == "down"))
	{
		echo ' <a href="stats-affiliate-zones.php?affiliateid='.$affiliateid.'&orderdirection=up">';
		echo '<img src="images/caret-ds.gif" border="0" alt="" title="">';
	}
	else
	{
		echo ' <a href="stats-affiliate-zones.php?affiliateid='.$affiliateid.'&orderdirection=down">';
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


if (!isset($zones) || !is_array($zones) || count($zones) == 0)
{
	echo "<tr height='25' bgcolor='#F6F6F6'><td height='25' colspan='5'>";
	echo "&nbsp;&nbsp;".$strNoZones;
	echo "</td></tr>";
	
	echo "<td colspan='5' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td>";
}
else
{
	$i=0;
	for (reset($zones);$key=key($zones);next($zones))
	{
		$zone = $zones[$key];
		
		echo "<tr height='25' ".($i%2==0?"bgcolor='#F6F6F6'":"").">";
		
		// Icon & name
		echo "<td height='25'>";
		if (isset($zone['banners']))
		{
			if (isset($zone['expand']) && $zone['expand'] == '1')
				echo "&nbsp;<a href='stats-affiliate-zones.php?affiliateid=".$affiliateid."&collapse=".$zone['zoneid']."'><img src='images/triangle-d.gif' align='absmiddle' align='absmiddle' border='0'></a>&nbsp;";
			else
				echo "&nbsp;<a href='stats-affiliate-zones.php?affiliateid=".$affiliateid."&expand=".$zone['zoneid']."'><img src='images/".$phpAds_TextDirection."/triangle-l.gif' align='absmiddle' border='0'></a>&nbsp;";
		}
		else
			echo "&nbsp;<img src='images/spacer.gif' height='16' width='16' align='absmiddle'>&nbsp;";
		
		if ($zone['delivery'] == phpAds_ZoneBanner)
			echo "<img src='images/icon-zone.gif' align='absmiddle'>&nbsp;";
		elseif ($zone['delivery'] == phpAds_ZoneInterstitial)
			echo "<img src='images/icon-interstitial.gif' align='absmiddle'>&nbsp;";
		elseif ($zone['delivery'] == phpAds_ZonePopup)
			echo "<img src='images/icon-popup.gif' align='absmiddle'>&nbsp;";
		elseif ($zone['delivery'] == phpAds_ZoneText)
			echo "<img src='images/icon-textzone.gif' align='absmiddle'>&nbsp;";
		
		echo "<a href='stats-zone-history.php?affiliateid=".$zone['affiliateid']."&zoneid=".$zone['zoneid']."'>".$zone['zonename']."</a>";
		echo "</td>";
		
		echo "<td height='25'>".$zone['zoneid']."</td>";
		echo "<td height='25' align='right'>".phpAds_formatNumber($zone['views'])."</td>";
		echo "<td height='25' align='right'>".phpAds_formatNumber($zone['clicks'])."</td>";
		echo "<td height='25' align='right'>".phpAds_buildCTR($zone['views'], $zone['clicks'])."&nbsp;&nbsp;</td>";
		echo "</tr>";
		
		
		
		if (isset($zone['banners']) && sizeof ($zone['banners']) > 0 && isset($zone['expand']) && $zone['expand'] == '1')
		{
			$banners = $zone['banners'];
			
			while (list($bkey,) = each($banners))
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
				
				if (ereg ('bannerid:'.$banners[$bkey]['bannerid'], $zone['what']))
					echo "<img src='images/icon-zone-linked.gif' align='absmiddle'>&nbsp;";
				else
					echo "<img src='images/icon-banner-stored.gif' align='absmiddle'>&nbsp;";
				
				
				echo "<a href='stats-linkedbanner-history.php?affiliateid=".$zone['affiliateid']."&zoneid=".$zone['zoneid']."&bannerid=".$banners[$bkey]['bannerid']."'>".phpAds_getBannerName($banners[$bkey]['bannerid'], 30, false)."</td>";
				echo "</td>";
				
				echo "<td height='25'>".$banners[$bkey]['bannerid']."</td>";
				echo "<td height='25' align='right'>".phpAds_formatNumber($banners[$bkey]['views'])."</td>";
				echo "<td height='25' align='right'>".phpAds_formatNumber($banners[$bkey]['clicks'])."</td>";
				echo "<td height='25' align='right'>".phpAds_buildCTR($banners[$bkey]['views'], $banners[$bkey]['clicks'])."&nbsp;&nbsp;</td>";
				echo "</tr>";
			}
		}
		
		echo "<tr height='1'><td colspan='5' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
		$i++;
	}
	
	// Total
	echo "<tr height='25'><td height='25'>&nbsp;&nbsp;<b>".$strTotal."</b></td>";
	echo "<td height='25'>&nbsp;</td>";
	echo "<td height='25' align='right'>".phpAds_formatNumber($totalviews)."</td>";
	echo "<td height='25' align='right'>".phpAds_formatNumber($totalclicks)."</td>";
	echo "<td height='25' align='right'>".phpAds_buildCTR($totalviews, $totalclicks)."&nbsp;&nbsp;</td>";
	echo "</tr>";
	
	//echo "<tr height='1'><td colspan='5' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
}

echo "</table>";
echo "<br><br>";



/*********************************************************/
/* Store preferences                                     */
/*********************************************************/

$Session['prefs']['stats-affiliate-zones.php']['listorder'] = $listorder;
$Session['prefs']['stats-affiliate-zones.php']['orderdirection'] = $orderdirection;
$Session['prefs']['stats-affiliate-zones.php']['nodes'] = implode (",", $node_array);

phpAds_SessionDataStore();



/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

phpAds_PageFooter();

?>
