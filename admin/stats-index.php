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
phpAds_checkAccess(phpAds_Admin+phpAds_Client);



/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

if (phpAds_isUser(phpAds_Admin))
{
	$extra = '';
	
	if ($phpAds_compact_stats)
	{
		// Determine left over verbose stats
		$viewresult = db_query("SELECT COUNT(*) AS cnt FROM $phpAds_tbl_adviews");
		$viewrow = @mysql_fetch_array($viewresult);
		if (isset($viewrow["cnt"]) && $viewrow["cnt"] != '')
			$verboseviews = $viewrow["cnt"];
		else
			$verboseviews = 0;
		
		$clickresult = db_query("SELECT COUNT(*) AS cnt FROM $phpAds_tbl_adclicks");
		$clickrow = @mysql_fetch_array($viewresult);
		if (isset($clickrow["cnt"]) && $clickrow["cnt"] != '')
			$verboseclicks = $clickrow["cnt"];
		else
			$verboseclicks = 0;
		
		if ($verboseviews > 0 || $verboseclicks > 0)
		{
			// Show link to verbose stats convertor
			$extra .= "<br><br>
					  <table cellspacing='0' cellpadding='1' width='140' bgcolor='#000088'><tr><td>
					  <table cellpadding='4' cellspacing='0' bgcolor='#FFFFFF'><tr>
					  <td valign='top'><img src='images/info-w.gif' vspace='absmiddle'></td>
					  <td valign='top'><b>Alert:</b><br>
					  You have enabled the compact statistics, but your old statistics are still 
					  in verbose format. Do you want to convert your verbose statistics to the 
					  new compact format?<br><br>
					  <a href='stats-convert.php?command=frame' target='_new' onClick=\"return openWindow('stats-convert.php?command=frame','','status=yes,scrollbars=yes,resizable=yes,width=400,height=500');\">
					  <img src='images/icon-update.gif' border='0' align='absmiddle'>&nbsp;Convert</a>
					  </td>
					  </tr></table>
					  </td></tr></table>";
		}
	}
	
	phpAds_PageHeader("2.1", $extra);
	phpAds_ShowSections(array("2.1", "2.2", "2.3"));
}

if (phpAds_isUser(phpAds_Client))
{
	phpAds_PageHeader("1.1");
	phpAds_ShowSections(array("1.1", "1.2"));
}

if (isset($message))
{
	phpAds_ShowMessage($message);
}

echo "<br><br>";
echo "<br><br>";
echo "<br><br>";




/*********************************************************/
/* Main code                                             */
/*********************************************************/

if (phpAds_isUser(phpAds_Client) && $phpAds_client_welcome)
{
	// Show welcome message
	include ('templates/welcome.html');
	
	echo "<br><br>";
}




// Get clients & campaign and build the tree
if (phpAds_isUser(phpAds_Admin))
{
	$res_clients = db_query("
		SELECT 
			*
		FROM 
			".$phpAds_tbl_clients."
		".phpAds_getListOrder ($listorder, $orderdirection)."
		") or mysql_die();
}
else
{
	$res_clients = db_query("
		SELECT 
			*
		FROM 
			".$phpAds_tbl_clients."
		WHERE
			clientID = ".$Session["clientID"]." OR
			parent = ".$Session["clientID"]."
		".phpAds_getListOrder ($listorder, $orderdirection)."
		") or mysql_die();
}

while ($row_clients = mysql_fetch_array($res_clients))
{
	if ($row_clients['parent'] == 0)
	{
		$clients[$row_clients['clientID']] = $row_clients;
		$clients[$row_clients['clientID']]['expand'] = 0;
	}
	else
	{
		$campaigns[$row_clients['clientID']] = $row_clients;
		$campaigns[$row_clients['clientID']]['expand'] = 0;
	}
}


// Get the banners for each campaign
$res_banners = db_query("
	SELECT 
		bannerID,
		clientID,
		alt,
		description,
		format,
		active
	FROM 
		".$phpAds_tbl_banners."
		".phpAds_getBannerListOrder ($listorder, $orderdirection)."
	") or mysql_die();

while ($row_banners = mysql_fetch_array($res_banners))
{
	if (isset($campaigns[$row_banners['clientID']]))
	{
		$banners[$row_banners['bannerID']] = $row_banners;
		$banners[$row_banners['bannerID']]['clicks'] = 0;
		$banners[$row_banners['bannerID']]['views'] = 0;
	}
}



// Get the adviews/clicks for each banner
if ($phpAds_compact_stats == 1)
{
	$res_stats = db_query("
		SELECT
			s.bannerID as bannerID,
			b.clientID as clientID, 
			sum(s.views) as views,
			sum(s.clicks) as clicks		
		FROM 
			$phpAds_tbl_adstats as s, 
			$phpAds_tbl_banners as b
		WHERE
			b.bannerID = s.BannerID
		GROUP BY
			s.bannerID
		") or mysql_die();
	
	while ($row_stats = mysql_fetch_array($res_stats))
	{
		if (isset($banners[$row_stats['bannerID']]))
		{
			$banners[$row_stats['bannerID']]['clicks'] = $row_stats['clicks'];
			$banners[$row_stats['bannerID']]['views'] = $row_stats['views'];
		}
	}
}
else
{
	$res_stats = db_query("
		SELECT
			v.bannerID as bannerID,
			b.clientID as clientID, 
			count(v.bannerID) as views
		FROM 
			$phpAds_tbl_adviews as v,
			$phpAds_tbl_banners as b
		WHERE
			b.bannerID = v.bannerID
		GROUP BY
			v.bannerID
		") or mysql_die();
	
	while ($row_stats = mysql_fetch_array($res_stats))
	{
		if (isset($banners[$row_stats['bannerID']]))
		{
			$banners[$row_stats['bannerID']]['views'] = $row_stats['views'];
			$banners[$row_stats['bannerID']]['clicks'] = 0;
		}
	}
	
	
	$res_stats = db_query("
		SELECT
			c.bannerID as bannerID,
			b.clientID as clientID, 
			count(c.bannerID) as clicks
		FROM 
			$phpAds_tbl_adclicks as c,
			$phpAds_tbl_banners as b
		WHERE
			b.bannerID = c.bannerID
		GROUP BY
			c.bannerID
		") or mysql_die();
	
	while ($row_stats = mysql_fetch_array($res_stats))
	{
		if (isset($banners[$row_stats['bannerID']]))
		{
			$banners[$row_stats['bannerID']]['clicks'] = $row_stats['clicks'];
		}
	}
}



// Expand tree nodes

if (isset($Session["stats_nodes"]) && $Session["stats_nodes"])
	$node_array = explode (",", $Session["stats_nodes"]);
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
		if (isset($clients[$node_array[$i]]))
			$clients[$node_array[$i]]['expand'] = 1;
		if (isset($campaigns[$node_array[$i]]))
			$campaigns[$node_array[$i]]['expand'] = 1;
	}
}

$Session["stats_nodes"] = implode (",", $node_array);
phpAds_SessionDataStore();



// Build Tree
if (isset($banners) && is_array($banners) && count($banners) > 0)
{
	// Add banner to campaigns
	for (reset($banners);$bkey=key($banners);next($banners))
		$campaigns[$banners[$bkey]['clientID']]['banners'][$bkey] = $banners[$bkey];
	
	unset ($banners);
}

if (isset($campaigns) && is_array($campaigns) && count($campaigns) > 0)
{
	for (reset($campaigns);$ckey=key($campaigns);next($campaigns))
		$clients[$campaigns[$ckey]['parent']]['campaigns'][$ckey] = $campaigns[$ckey];
	
	unset ($campaigns);
}



if (isset($clients) && is_array($clients) && count($clients) > 0)
{
	// Calculate statistics for clients
	for (reset($clients);$key=key($clients);next($clients))
	{
		$clientviews = 0;
		$clientclicks = 0;
		
		if (isset($clients[$key]['campaigns']) && sizeof ($clients[$key]['campaigns']) > 0)
		{
			$campaigns = $clients[$key]['campaigns'];
			
			// Calculate statistics for campaigns
			for (reset($campaigns);$ckey=key($campaigns);next($campaigns))
			{
				$campaignviews = 0;
				$campaignclicks = 0;
				
				if (isset($campaigns[$ckey]['banners']) && sizeof ($campaigns[$ckey]['banners']) > 0)
				{
					$banners = $campaigns[$ckey]['banners'];
					for (reset($banners);$bkey=key($banners);next($banners))
					{
						$campaignviews += $banners[$bkey]['views'];
						$campaignclicks += $banners[$bkey]['clicks'];
					}
				}
				
				$clientviews += $campaignviews;
				$clientclicks += $campaignclicks;
				
				$clients[$key]['campaigns'][$ckey]['views'] = $campaignviews;
				$clients[$key]['campaigns'][$ckey]['clicks'] = $campaignclicks;
			}
		}
		
		$clients[$key]['clicks'] = $clientclicks;
		$clients[$key]['views'] = $clientviews;
	}
	
	unset ($campaigns);
	unset ($banners);
}

if (phpAds_isUser(phpAds_Admin)) 
{
	// Information for the Administrator
	
	if (isset($clients) && is_array($clients) && count($clients) > 0)
	{
		echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";	
		
		echo "<tr height='25'>";
		echo '<td height="25"><b>&nbsp;&nbsp;<a href="'.$PHP_SELF.'?listorder=name">'.$GLOBALS['strName'].'</a>';
		if (($listorder == "name") || ($listorder == ""))
		{
			if  (($orderdirection == "") || ($orderdirection == "down"))
			{
				echo '<a href="'.$PHP_SELF.'?listorder=name&orderdirection=up">';
				echo '<img src="images/triangle-d.gif" border="0" alt="" title="">';
			}
			else
			{
				echo '<a href="'.$PHP_SELF.'?listorder=name&orderdirection=down">';
				echo '<img src="images/triangle-u.gif" border="0" alt="" title="">';
			}
			echo '</a>';
		}
		echo '</b></td>';
		echo '<td height="25"><b><a href="'.$PHP_SELF.'?listorder=id">'.$GLOBALS['strID'].'</a>';
		if ($listorder == "id")
		{
			if  (($orderdirection == "") || ($orderdirection == "down"))
			{
				echo '<a href="'.$PHP_SELF.'?listorder=id&orderdirection=up">';
				echo '<img src="images/triangle-d.gif" border="0" alt="" title="">';
			}
			else
			{
				echo '<a href="'.$PHP_SELF.'?listorder=id&orderdirection=down">';
				echo '<img src="images/triangle-u.gif" border="0" alt="" title="">';
			}
			echo '</a>';
		}
		echo '</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>';
		echo "<td height='25' align='right'><b>".$GLOBALS['strViews']."</b></td>";
		echo "<td height='25' align='right'><b>".$GLOBALS['strClicks']."</b></td>";
		echo "<td height='25' align='right'><b>".$GLOBALS['strCTRShort']."</b>&nbsp;&nbsp;</td>";
		echo "</tr>";
		
		echo "<tr height='1'><td colspan='5' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
		
		$i=0;
		for (reset($clients);$key=key($clients);next($clients))
		{
			$client = $clients[$key];
			
			echo "<tr height='25' ".($i%2==0?"bgcolor='#F6F6F6'":"").">";
			
			// Icon & name
			echo "<td height='25'>";
			if (isset($client['campaigns']))
			{
				if ($client['expand'] == '1')
					echo "&nbsp;<a href='stats-index.php?collapse=".$client['clientID']."'><img src='images/triangle-d.gif' align='absmiddle' border='0'></a>&nbsp;";
				else
					echo "&nbsp;<a href='stats-index.php?expand=".$client['clientID']."'><img src='images/triangle-l.gif' align='absmiddle' border='0'></a>&nbsp;";
			}
			else
				echo "&nbsp;<img src='images/spacer.gif' height='16' width='16'>&nbsp;";
				
			echo "<img src='images/icon-client.gif' align='absmiddle'>&nbsp;";
			echo "<a href='stats-client.php?clientID=".$client['clientID']."'>".$client['clientname']."</a>";
			echo "</td>";
			
			// ID
			echo "<td height='25'>".$client['clientID']."</td>";
			
			// Button 1
			echo "<td height='25' align='right'>".$client['views']."</td>";
			
			// Empty
			echo "<td height='25' align='right'>".$client['clicks']."</td>";
			
			// Button 3
			echo "<td height='25' align='right'>".phpAds_buildCTR($client['views'], $client['clicks'])."&nbsp;&nbsp;</td>";
			
			
			
			if (isset($client['campaigns']) && sizeof ($client['campaigns']) > 0 && $client['expand'] == '1')
			{
				$campaigns = $client['campaigns'];
				
				for (reset($campaigns);$ckey=key($campaigns);next($campaigns))
				{
					// Divider
					echo "<tr height='1'>";
					echo "<td ".($i%2==0?"bgcolor='#F6F6F6'":"")."><img src='images/spacer.gif' width='1' height='1'></td>";
					echo "<td colspan='5' bgcolor='#888888'><img src='images/break-l.gif' height='1' width='100%'></td>";
					echo "</tr>";
					
					// Icon & name
					echo "<tr height='25' ".($i%2==0?"bgcolor='#F6F6F6'":"")."><td height='25'>";
					echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
					
					if (isset($campaigns[$ckey]['banners']))
					{
						if ($campaigns[$ckey]['expand'] == '1')
							echo "<a href='stats-index.php?collapse=".$campaigns[$ckey]['clientID']."'><img src='images/triangle-d.gif' align='absmiddle' border='0'></a>&nbsp;";
						else
							echo "<a href='stats-index.php?expand=".$campaigns[$ckey]['clientID']."'><img src='images/triangle-l.gif' align='absmiddle' border='0'></a>&nbsp;";
					}
					else
						echo "<img src='images/spacer.gif' height='16' width='16'>&nbsp;";
					
					
					if ($campaigns[$ckey]['active'] == 'true')
						echo "<img src='images/icon-campaign.gif' align='absmiddle'>&nbsp;";
					else
						echo "<img src='images/icon-campaign-d.gif' align='absmiddle'>&nbsp;";
					
					echo "<a href='stats-campaign.php?campaignID=".$campaigns[$ckey]['clientID']."'>".$campaigns[$ckey]['clientname']."</td>";
					echo "</td>";
					
					// ID
					echo "<td height='25'>".$campaigns[$ckey]['clientID']."</td>";
					
					// Button 1
					echo "<td height='25' align='right'>".$campaigns[$ckey]['views']."</td>";
					
					// Button 2
					echo "<td height='25' align='right'>".$campaigns[$ckey]['clicks']."</td>";
					
					// Button 3
					echo "<td height='25' align='right'>".phpAds_buildCTR($campaigns[$ckey]['views'], $campaigns[$ckey]['clicks'])."&nbsp;&nbsp;</td>";
					
					
					
					if ($campaigns[$ckey]['expand'] == '1' && isset($campaigns[$ckey]['banners']))
					{
						$banners = $campaigns[$ckey]['banners'];
						for (reset($banners);$bkey=key($banners);next($banners))
						{
							$name = $strUntitled;
							if (isset($banners[$bkey]['alt']) && $banners[$bkey]['alt'] != '') $name = $banners[$bkey]['alt'];
							if (isset($banners[$bkey]['description']) && $banners[$bkey]['description'] != '') $name = $banners[$bkey]['description'];
							
							$name = phpAds_breakString ($name, '30');
							
							// Divider
							echo "<tr height='1'>";
							echo "<td ".($i%2==0?"bgcolor='#F6F6F6'":"")."><img src='images/spacer.gif' width='1' height='1'></td>";
							echo "<td colspan='4' bgcolor='#888888'><img src='images/break-l.gif' height='1' width='100%'></td>";
							echo "</tr>";
							
							// Icon & name
							echo "<tr height='25' ".($i%2==0?"bgcolor='#F6F6F6'":"").">";
							echo "<td height='25'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
							
							if ($banners[$bkey]['active'] == 'true' && $campaigns[$ckey]['active'] == 'true')
							{
								if ($banners[$bkey]['format'] == 'html')
									echo "<img src='images/icon-banner-html.gif' align='absmiddle'>";
								elseif ($banners[$bkey]['format'] == 'url')
									echo "<img src='images/icon-banner-url.gif' align='absmiddle'>";
								else
									echo "<img src='images/icon-banner-stored.gif' align='absmiddle'>";
							}
							else
							{
								if ($banners[$bkey]['format'] == 'html')
									echo "<img src='images/icon-banner-html-d.gif' align='absmiddle'>";
								elseif ($banners[$bkey]['format'] == 'url')
									echo "<img src='images/icon-banner-url-d.gif' align='absmiddle'>";
								else
									echo "<img src='images/icon-banner-stored-d.gif' align='absmiddle'>";
							}
							
							echo "&nbsp;<a href='stats-details.php?bannerID=".$banners[$bkey]['bannerID']."&campaignID=".$campaigns[$ckey]['clientID']."'>".$name."</a></td>";
							
							// ID
							echo "<td height='25'>".$banners[$bkey]['bannerID']."</td>";
							
							// Empty
							echo "<td height='25' align='right'>".$banners[$bkey]['views']."</td>";
							
							// Button 2
							echo "<td height='25' align='right'>".$banners[$bkey]['clicks']."</td>";
							
							// Button 1
							echo "<td height='25' align='right'>".phpAds_buildCTR($banners[$bkey]['views'], $banners[$bkey]['clicks'])."&nbsp;&nbsp;</td>";
						}
					}
				}
			}
			
			if (isset ($client['banners']) && sizeof($client['banners']) > 0)
			{
				// Divider
				echo "<tr height='1'><td colspan='1'></td><td colspan='3' bgcolor='#888888'><img src='images/break-l.gif' height='1' width='100%'></td></tr>";
				
				echo "<tr height='25' ".($i%2==0?"bgcolor='#F6F6F6'":"").">";
				echo "<td height='25'>$strBannersWithoutCampaign</td>";
				echo "<td height='25'>&nbsp;-&nbsp;</td>";
				echo "<td>&nbsp;</td>";
				echo "<td>&nbsp;</td>";
				echo "<td>&nbsp;</td>";
				echo "</tr>";
			}
			
			echo "<tr height='1'><td colspan='5' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
			$i++;
		}
		
		echo "</table>";
		echo "<br><br><br><br>";
	}
	
	echo "<table width='100%' border='0' align='center' cellspacing='0' cellpadding='0'>";
  	echo "<tr><td height='25' colspan='4'><b>$strStats</b></td></tr>";
  	echo "<tr height='1'><td colspan='4' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
	
	
	// stats today
	$adviews = db_total_views("", "day");
	$adclicks = db_total_clicks("", "day");
	$ctr = phpAds_buildCTR($adviews, $adclicks);
  	echo "<tr><td height='25'>$strToday</td>";
  	echo "<td height='25'>$strViews: <b>$adviews</b></td>";
    echo "<td height='25'>$strClicks: <b>$adclicks</b></td>";
    echo "<td height='25'>$strCTRShort: <b>$ctr</b></td></tr>";
  	echo "<tr height='1'><td colspan='4' bgcolor='#888888'><img src='images/break-el.gif' height='1' width='100%'></td></tr>";
	
	
	// stats this week
	$adviews = db_total_views("", "week");
	$adclicks = db_total_clicks("", "week");
	$ctr = phpAds_buildCTR($adviews, $adclicks);
	
  	echo "<tr><td height='25'>$strThisWeek</td>";
	echo "<td height='25'>$strViews: <b>$adviews</b></td>";
    echo "<td height='25'>$strClicks: <b>$adclicks</b></td>";
    echo "<td height='25'>$strCTRShort: <b>$ctr</b></td></tr>";
  	echo "<tr height='1'><td colspan='4' bgcolor='#888888'><img src='images/break-el.gif' height='1' width='100%'></td></tr>";
	
	
	// stats this month
	$adviews = db_total_views("", "month");
	$adclicks = db_total_clicks("", "month");
	$ctr = phpAds_buildCTR($adviews, $adclicks);
	
  	echo "<tr><td height='25'>$strThisMonth</td>";
  	echo "<td height='25'>$strViews: <b>$adviews</b></td>";
 	echo "<td height='25'>$strClicks: <b>$adclicks</b></td>";
    echo "<td height='25'>$strCTRShort: <b>$ctr</b></td></tr>";
  	echo "<tr height='1'><td colspan='4' bgcolor='#888888'><img src='images/break-el.gif' height='1' width='100%'></td></tr>";
  	
  	
	// overall stats
	$adviews = db_total_views();
	$adclicks = db_total_clicks();
	$ctr = phpAds_buildCTR($adviews, $adclicks);
	
  	echo "<tr><td height='25'>$strOverall</td>";
 	echo "<td height='25'>$strViews: <b>$adviews</b></td>";
    echo "<td height='25'>$strClicks: <b>$adclicks</b></td>";
    echo "<td height='25'>$strCTRShort: <b>$ctr</b></td></tr>";
  	echo "<tr height='1'><td colspan='4' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
	
	
  	echo "<tr height='25'><td colspan='4' height='25'>";
	echo "<img src='images/icon-undo.gif' align='absmiddle'>&nbsp;<a href='stats-reset.php?all=true'".phpAds_DelConfirm($strConfirmResetStats).">$strResetStats</a>&nbsp;&nbsp;&nbsp;&nbsp;";
  	echo "</td></tr>";
	echo "</table>";
}
else
{
	// Information for the client
	
	$client = $clients[$Session["clientID"]];
	
	if (isset($client['campaigns']) && sizeof ($client['campaigns']) > 0)
	{
		echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";	
		
		echo "<tr height='25'>";
		echo "<td height='25'><b>&nbsp;&nbsp;".$GLOBALS['strName']."</b></td>";
		echo "<td height='25'><b>".$GLOBALS['strID']."</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
		echo "<td height='25' align='right'><b>".$GLOBALS['strViews']."</b></td>";
		echo "<td height='25' align='right'><b>".$GLOBALS['strClicks']."</b></td>";
		echo "<td height='25' align='right'><b>".$GLOBALS['strCTRShort']."</b>&nbsp;&nbsp;</td>";
		echo "</tr>";
		
		echo "<tr height='1'><td colspan='5' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
		
		$i=0;
		$campaigns = $client['campaigns'];
		
		for (reset($campaigns);$ckey=key($campaigns);next($campaigns))
		{
			// Icon & name
			echo "<tr height='25' ".($i%2==0?"bgcolor='#F6F6F6'":"")."><td height='25'>";
			echo "&nbsp;&nbsp;";
			
			if (isset($campaigns[$ckey]['banners']))
			{
				if ($campaigns[$ckey]['expand'] == '1')
					echo "<a href='stats-index.php?collapse=".$campaigns[$ckey]['clientID']."'><img src='images/triangle-d.gif' align='absmiddle' border='0'></a>&nbsp;";
				else
					echo "<a href='stats-index.php?expand=".$campaigns[$ckey]['clientID']."'><img src='images/triangle-l.gif' align='absmiddle' border='0'></a>&nbsp;";
			}
			else
				echo "<img src='images/spacer.gif' height='16' width='16'>&nbsp;";
			
			
			if ($campaigns[$ckey]['active'] == 'true')
				echo "<img src='images/icon-campaign.gif' align='absmiddle'>&nbsp;";
			else
				echo "<img src='images/icon-campaign-d.gif' align='absmiddle'>&nbsp;";
			
			echo "<a href='stats-campaign.php?campaignID=".$campaigns[$ckey]['clientID']."'>".$campaigns[$ckey]['clientname']."</td>";
			echo "</td>";
			
			// ID
			echo "<td height='25'>".$campaigns[$ckey]['clientID']."</td>";
			
			// Button 1
			echo "<td height='25' align='right'>".$campaigns[$ckey]['views']."</td>";
			
			// Button 2
			echo "<td height='25' align='right'>".$campaigns[$ckey]['clicks']."</td>";
			
			// Button 3
			echo "<td height='25' align='right'>".phpAds_buildCTR($campaigns[$ckey]['views'], $campaigns[$ckey]['clicks'])."&nbsp;&nbsp;</td>";
			
			
			
			if ($campaigns[$ckey]['expand'] == '1' && isset($campaigns[$ckey]['banners']))
			{
				$banners = $campaigns[$ckey]['banners'];
				for (reset($banners);$bkey=key($banners);next($banners))
				{
					$name = $strUntitled;
					if (isset($banners[$bkey]['alt']) && $banners[$bkey]['alt'] != '') $name = $banners[$bkey]['alt'];
					if (isset($banners[$bkey]['description']) && $banners[$bkey]['description'] != '') $name = $banners[$bkey]['description'];
					
					$name = phpAds_breakString ($name, '30');
					
					// Divider
					echo "<tr height='1'>";
					echo "<td ".($i%2==0?"bgcolor='#F6F6F6'":"")."><img src='images/spacer.gif' width='1' height='1'></td>";
					echo "<td colspan='4' bgcolor='#888888'><img src='images/break-l.gif' height='1' width='100%'></td>";
					echo "</tr>";
					
					// Icon & name
					echo "<tr height='25' ".($i%2==0?"bgcolor='#F6F6F6'":"").">";
					echo "<td height='25'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
					
					if ($banners[$bkey]['active'] == 'true' && $campaigns[$ckey]['active'] == 'true')
					{
						if ($banners[$bkey]['format'] == 'html')
							echo "<img src='images/icon-banner-html.gif' align='absmiddle'>";
						elseif ($banners[$bkey]['format'] == 'url')
							echo "<img src='images/icon-banner-url.gif' align='absmiddle'>";
						else
							echo "<img src='images/icon-banner-stored.gif' align='absmiddle'>";
					}
					else
					{
						if ($banners[$bkey]['format'] == 'html')
							echo "<img src='images/icon-banner-html-d.gif' align='absmiddle'>";
						elseif ($banners[$bkey]['format'] == 'url')
							echo "<img src='images/icon-banner-url-d.gif' align='absmiddle'>";
						else
							echo "<img src='images/icon-banner-stored-d.gif' align='absmiddle'>";
					}
					
					echo "&nbsp;<a href='stats-details.php?bannerID=".$banners[$bkey]['bannerID']."&campaignID=".$campaigns[$ckey]['clientID']."'>".$name."</a></td>";
					
					// ID
					echo "<td height='25'>".$banners[$bkey]['bannerID']."</td>";
					
					// Empty
					echo "<td height='25' align='right'>".$banners[$bkey]['views']."</td>";
					
					// Button 2
					echo "<td height='25' align='right'>".$banners[$bkey]['clicks']."</td>";
					
					// Button 1
					echo "<td height='25' align='right'>".phpAds_buildCTR($banners[$bkey]['views'], $banners[$bkey]['clicks'])."&nbsp;&nbsp;</td>";
				}
			}
			
			if (isset ($client['banners']) && sizeof($client['banners']) > 0)
			{
				// Divider
				echo "<tr height='1'><td colspan='1'></td><td colspan='3' bgcolor='#888888'><img src='images/break-l.gif' height='1' width='100%'></td></tr>";
				
				echo "<tr height='25' ".($i%2==0?"bgcolor='#F6F6F6'":"").">";
				echo "<td height='25'>$strBannersWithoutCampaign</td>";
				echo "<td height='25'>&nbsp;-&nbsp;</td>";
				echo "<td>&nbsp;</td>";
				echo "<td>&nbsp;</td>";
				echo "<td>&nbsp;</td>";
				echo "</tr>";
			}
			
			echo "<tr height='1'><td colspan='5' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
			$i++;
		}
		
		echo "</table>";
		echo "<br><br><br><br>";
	}
}



echo "<br><br>";



/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

phpAds_PageFooter();

?>
