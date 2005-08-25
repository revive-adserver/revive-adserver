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
require ("lib-statistics.inc.php");


// Register input variables
phpAds_registerGlobal ('expand', 'collapse', 'hideinactive', 'listorder', 'orderdirection', 'period', 'period_range');


// Security check
phpAds_checkAccess(phpAds_Admin);


// Set default values
$tabindex = 1;



/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

$extra  = "<br><br><br>";
$extra .= "<b>$strMaintenance</b><br>";
$extra .= "<img src='images/break.gif' height='1' width='160' vspace='4'><br>";
$extra .= "<a href='stats-reset.php?all=true'".phpAds_DelConfirm($strConfirmResetStats).">";
$extra .= "<img src='images/".$phpAds_TextDirection."/icon-undo.gif' align='absmiddle' border='0'>&nbsp;$strResetStats</a>";
$extra .= "<br><br>";

phpAds_PageHeader("2.1", $extra);
phpAds_ShowSections(array("2.1", "2.4", "2.2", "2.5"));



/*********************************************************/
/* Get preferences                                       */
/*********************************************************/

if (!isset($hideinactive))
{
	if (isset($Session['prefs']['stats-global-client.php']['hideinactive']))
		$hideinactive = $Session['prefs']['stats-global-client.php']['hideinactive'];
	else
		$hideinactive = ($phpAds_config['gui_hide_inactive'] == 't');
}

if (!isset($listorder))
{
	if (isset($Session['prefs']['stats-global-client.php']['listorder']))
		$listorder = $Session['prefs']['stats-global-client.php']['listorder'];
	else
		$listorder = '';
}

if (!isset($orderdirection))
{
	if (isset($Session['prefs']['stats-global-client.php']['orderdirection']))
		$orderdirection = $Session['prefs']['stats-global-client.php']['orderdirection'];
	else
		$orderdirection = '';
}

if (isset($Session['prefs']['stats-global-client.php']['nodes']))
	$node_array = explode (",", $Session['prefs']['stats-global-client.php']['nodes']);
else
	$node_array = array();



if (!isset($period))
{
	if (isset($Session['prefs']['stats-global-client.php']['period']))
		$period = $Session['prefs']['stats-global-client.php']['period'];
	else
		$period = '';
}


if (!isset($period_range))
{
	if (isset($Session['prefs']['stats-global-client.php']['period_range']))
		$period_range = $Session['prefs']['stats-global-client.php']['period_range'];
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

// Get clients & campaign and build the tree
if (phpAds_isUser(phpAds_Admin))
{
	$res_clients = phpAds_dbQuery("
		SELECT 
			*
		FROM 
			".$phpAds_config['tbl_clients']."
		".phpAds_getListOrder ($listorder, $orderdirection)."
		") or phpAds_sqlDie();
}
else
{
	$res_clients = phpAds_dbQuery("
		SELECT 
			*
		FROM 
			".$phpAds_config['tbl_clients']."
		WHERE
			clientid = ".phpAds_getUserID()." OR
			parent = ".phpAds_getUserID()."
		".phpAds_getListOrder ($listorder, $orderdirection)."
		") or phpAds_sqlDie();
}

while ($row_clients = phpAds_dbFetchArray($res_clients))
{
	if ($row_clients['parent'] == 0)
	{
		$clients[$row_clients['clientid']] = $row_clients;
		$clients[$row_clients['clientid']]['expand'] = 0;
		$clients[$row_clients['clientid']]['count'] = 0;
		$clients[$row_clients['clientid']]['hideinactive'] = 0;
	}
	else
	{
		$campaigns[$row_clients['clientid']] = $row_clients;
		$campaigns[$row_clients['clientid']]['expand'] = 0;
		$campaigns[$row_clients['clientid']]['count'] = 0;
	}
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
	$period_end = @mktime(0, 0, 0, $period_range['end_month'], $period_range['end_day'] + 1, $period_range['end_year']);



if (!$phpAds_config['compact_stats'])
{
	switch ($period)
	{
		case 'r':	$limit 		    	= "t_stamp >= ".date('YmdHis', $period_begin)." AND t_stamp < ".date('YmdHis', $period_end);
					break;
				
		case 'y':	$timestamp_begin	= mktime(0, 0, 0, date('m'), date('d') - 1, date('Y'));	
					$timestamp_end		= mktime(0, 0, 0, date('m'), date('d'), date('Y'));
					$limit 		    	= "t_stamp >= ".date('YmdHis', $timestamp_begin)." AND t_stamp < ".date('YmdHis', $timestamp_end);
					break;
				
		case 't':	$timestamp_begin	= mktime(0, 0, 0, date('m'), date('d'), date('Y'));
					$limit 				= "t_stamp >= ".date('YmdHis', $timestamp_begin);
					break;
				
		case 'w':	$timestamp_begin	= mktime(0, 0, 0, date('m'), date('d') - 6, date('Y'));
					$limit 				= "t_stamp >= ".date('YmdHis', $timestamp_begin);
					break;
				
		case 'm':	$timestamp_begin	= mktime(0, 0, 0, date('m'), 1, date('Y'));
					$limit 				= "t_stamp >= ".date('YmdHis', $timestamp_begin);
					break;
				
		case 'l':	$timestamp_begin	= mktime(0, 0, 0, date('m')-1, 1, date('Y'));
					$timestamp_end		= mktime(0, 0, 0, date('m'), 0, date('Y'));
					$limit 		    	= "t_stamp >= ".date('YmdHis', $timestamp_begin)." AND t_stamp < ".date('YmdHis', $timestamp_end);
					break;
				
		case 'z':	$timestamp_begin	= mktime(0, 0, 0, 1, 1, date('Y'));
					$limit 				= "t_stamp >= ".date('YmdHis', $timestamp_begin);
					break;

		case 'x':	$timestamp_begin	= mktime(0, 0, 0, 1, 1, date('Y')-1);
					$timestamp_end		= mktime(0, 0, 0, 1, 0, date('Y'));
					$limit 		    	= "t_stamp >= ".date('YmdHis', $timestamp_begin)." AND t_stamp < ".date('YmdHis', $timestamp_end);
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
		case 'r':	$limit 		    	= "day >= ".date('Ymd', $period_begin)." AND day < ".date('Ymd', $period_end);
					break;
				
		case 'y':	$timestamp_begin	= mktime(0, 0, 0, date('m'), date('d') - 1, date('Y'));
					$timestamp_end		= mktime(0, 0, 0, date('m'), date('d'), date('Y'));
					$limit 				= "day >= ".date('Ymd', $timestamp_begin)." AND day < ".date('Ymd', $timestamp_end);
					break;
				
		case 't':	$timestamp_begin	= mktime(0, 0, 0, date('m'), date('d'), date('Y'));
					$limit 				= "day >= ".date('Ymd', $timestamp_begin);
					break;
				
		case 'w':	$timestamp_begin	= mktime(0, 0, 0, date('m'), date('d') - 6, date('Y'));
					$limit 				= "day >= ".date('Ymd', $timestamp_begin);
					break;
				
		case 'm':	$timestamp_begin	= mktime(0, 0, 0, date('m'), 1, date('Y'));
					$limit 				= "day >= ".date('Ymd', $timestamp_begin);
					break;
				

		case 'l':	$timestamp_begin	= mktime(0, 0, 0, date('m')-1, 1, date('Y'));
					$timestamp_end		= mktime(0, 0, 0, date('m'), 0, date('Y'));
					$limit 				= "day >= ".date('Ymd', $timestamp_begin)." AND day < ".date('Ymd', $timestamp_end);
					break;
				
		case 'z':	$timestamp_begin	= mktime(0, 0, 0, 1, 1, date('Y'));
					$limit 				= "day >= ".date('Ymd', $timestamp_begin);
					break;

		case 'x':	$timestamp_begin	= mktime(0, 0, 0, 1, 1, date('Y')-1);
					$timestamp_end		= mktime(0, 0, 0, 1, 0, date('Y'));
					$limit 				= "day >= ".date('Ymd', $timestamp_begin)." AND day < ".date('Ymd', $timestamp_end);
					break;
				
		default:	$limit = '';
					$period = '';
					break;
	}
}


// Get the banners for each campaign
$res_banners = phpAds_dbQuery("
	SELECT 
		bannerid,
		clientid,
		alt,
		description,
		active,
		storagetype
	FROM 
		".$phpAds_config['tbl_banners']."
		".phpAds_getBannerListOrder ($listorder, $orderdirection)."
	") or phpAds_sqlDie();

while ($row_banners = phpAds_dbFetchArray($res_banners))
{
	if (isset($clients[$row_banners['clientid']]))
	{
		$clients[$row_banners['clientid']]['count']++;
	}
	
	if (isset($campaigns[$row_banners['clientid']]))
	{
		$banners[$row_banners['bannerid']] = $row_banners;
		$banners[$row_banners['bannerid']]['clicks'] = 0;
		$banners[$row_banners['bannerid']]['views'] = 0;
		$campaigns[$row_banners['clientid']]['count']++;
	}
	
	$bannerids[] = $row_banners['bannerid'];
}

if (count($bannerids))
{
	// Create WHERE clause
	$where = $limit ? "WHERE ".$limit : '';

	if (!$phpAds_config['compact_stats'])
	{
		$res_stats = phpAds_dbQuery("
			SELECT
				bannerid,
				count(*) as views
			FROM 
				".$phpAds_config['tbl_adviews']."
			".$where."
			GROUP BY
				bannerid
			") or phpAds_sqlDie();
		
		while ($row_stats = phpAds_dbFetchArray($res_stats))
		{
			$banners[$row_stats['bannerid']]['views'] = $row_stats['views'];
			$banners[$row_stats['bannerid']]['clicks'] = 0;
		}
		
		
		$res_stats = phpAds_dbQuery("
			SELECT
				bannerid,
				count(*) as clicks
			FROM 
				".$phpAds_config['tbl_adclicks']."
			".$where."
			GROUP BY
				bannerid
			") or phpAds_sqlDie();
		
		while ($row_stats = phpAds_dbFetchArray($res_stats))
		{
			$banners[$row_stats['bannerid']]['clicks'] = $row_stats['clicks'];
		}
	}
	else
	{
		$res_stats = phpAds_dbQuery("
			SELECT
				bannerid,
				sum(views) as views,
				sum(clicks) as clicks
			FROM 
				".$phpAds_config['tbl_adstats']."
			".$where."
			GROUP BY
				bannerid
			") or phpAds_sqlDie();
		
		while ($row_stats = phpAds_dbFetchArray($res_stats))
		{
			$banners[$row_stats['bannerid']]['clicks'] = $row_stats['clicks'];
			$banners[$row_stats['bannerid']]['views'] = $row_stats['views'];
		}
	}
}



// Add ID found in expand to expanded nodes
if (isset($expand) && $expand != '')
{
	switch ($expand)
	{
		case 'all' :	$node_array   = array();
						if (isset($clients)) while (list($key,) = each($clients)) $node_array[] = $key;
						if (isset($campaigns)) while (list($key,) = each($campaigns)) $node_array[] = $key;
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
		if (isset($clients[$node_array[$i]]))
			$clients[$node_array[$i]]['expand'] = 1;
		if (isset($campaigns[$node_array[$i]]))
			$campaigns[$node_array[$i]]['expand'] = 1;
	}
}



// Build Tree
$clientshidden = 0;

if (isset($banners) && is_array($banners) && count($banners) > 0)
{
	// Add banner to campaigns
	reset ($banners);
	while (list ($bkey, $banner) = each ($banners))
		if ($hideinactive == false || $banner['active'] == 't')
			$campaigns[$banner['clientid']]['banners'][$bkey] = $banner;
	
	unset ($banners);
}

if (isset($campaigns) && is_array($campaigns) && count($campaigns) > 0)
{
	reset ($campaigns);
	while (list ($ckey, $campaign) = each ($campaigns))
	{
		if (!isset($campaign['banners']))
			$campaign['banners'] = array();
		
		if ($hideinactive == false || $campaign['active'] == 't' && 
		   (count($campaign['banners']) != 0 || count($campaign['banners']) == $campaign['count']))
			$clients[$campaign['parent']]['campaigns'][$ckey] = $campaign;
		else
			$clients[$campaign['parent']]['hideinactive']++;
	}
	
	unset ($campaigns);
}

if (isset($clients) && is_array($clients) && count($clients) > 0)
{
	reset ($clients);
	while (list ($key, $client) = each ($clients))
	{
		if (!isset($client['campaigns']))
			$client['campaigns'] = array();
		
		if (count($client['campaigns']) == 0 && $client['hideinactive'] > 0)
		{
			$clientshidden++;
			unset($clients[$key]);
		}
	}
}



$totalviews = 0;
$totalclicks = 0;

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
		
		$totalviews += $clientviews;
		$totalclicks += $clientclicks;
		
		$clients[$key]['clicks'] = $clientclicks;
		$clients[$key]['views'] = $clientviews;
	}
	
	unset ($campaigns);
	unset ($banners);
}




echo "<form action='".$HTTP_SERVER_VARS['PHP_SELF']."'>";

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






if ($clientshidden > 0 || $totalviews > 0 || $totalclicks > 0)
{
	echo "<br><br>";
	echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";	
	
	echo "<tr height='25'>";
	echo '<td height="25" width="40%"><b>&nbsp;&nbsp;<a href="stats-global-client.php?listorder=name">'.$GLOBALS['strName'].'</a>';
	if (($listorder == "name") || ($listorder == ""))
	{
		if  (($orderdirection == "") || ($orderdirection == "down"))
		{
			echo ' <a href="stats-global-client.php?orderdirection=up">';
			echo '<img src="images/caret-ds.gif" border="0" alt="" title="">';
		}
		else
		{
			echo ' <a href="stats-global-client.php?orderdirection=down">';
			echo '<img src="images/caret-u.gif" border="0" alt="" title="">';
		}
		echo '</a>';
	}
	echo '</b></td>';
	echo '<td height="25"><b><a href="stats-global-client.php?listorder=id">'.$GLOBALS['strID'].'</a>';
	if ($listorder == "id")
	{
		if  (($orderdirection == "") || ($orderdirection == "down"))
		{
			echo ' <a href="stats-global-client.php?orderdirection=up">';
			echo '<img src="images/caret-ds.gif" border="0" alt="" title="">';
		}
		else
		{
			echo ' <a href="stats-global-client.php?orderdirection=down">';
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
	for (reset($clients);$key=key($clients);next($clients))
	{
		$client = $clients[$key];
		
		echo "<tr height='25' ".($i%2==0?"bgcolor='#F6F6F6'":"").">";
		
		// Icon & name
		echo "<td height='25'>";
		if (isset($client['campaigns']))
		{
			if ($client['expand'] == '1')
				echo "&nbsp;<a href='stats-global-client.php?collapse=".$client['clientid']."'><img src='images/triangle-d.gif' align='absmiddle' border='0'></a>&nbsp;";
			else
				echo "&nbsp;<a href='stats-global-client.php?expand=".$client['clientid']."'><img src='images/".$phpAds_TextDirection."/triangle-l.gif' align='absmiddle' border='0'></a>&nbsp;";
		}
		else
			echo "&nbsp;<img src='images/spacer.gif' height='16' width='16'>&nbsp;";
			
		echo "<img src='images/icon-client.gif' align='absmiddle'>&nbsp;";
		echo "<a href='stats-client-history.php?clientid=".$client['clientid']."'>".$client['clientname']."</a>";
		echo "</td>";
		
		// ID
		echo "<td height='25'>".$client['clientid']."</td>";
		
		// Button 1
		echo "<td height='25' align='".$phpAds_TextAlignRight."'>".phpAds_formatNumber($client['views'])."</td>";
		
		// Empty
		echo "<td height='25' align='".$phpAds_TextAlignRight."'>".phpAds_formatNumber($client['clicks'])."</td>";
		
		// Button 3
		echo "<td height='25' align='".$phpAds_TextAlignRight."'>".phpAds_buildCTR($client['views'], $client['clicks'])."&nbsp;&nbsp;</td>";
		
		
		
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
						echo "<a href='stats-global-client.php?collapse=".$campaigns[$ckey]['clientid']."'><img src='images/triangle-d.gif' align='absmiddle' border='0'></a>&nbsp;";
					else
						echo "<a href='stats-global-client.php?expand=".$campaigns[$ckey]['clientid']."'><img src='images/".$phpAds_TextDirection."/triangle-l.gif' align='absmiddle' border='0'></a>&nbsp;";
				}
				else
					echo "<img src='images/spacer.gif' height='16' width='16' align='absmiddle'>&nbsp;";
				
				
				if ($campaigns[$ckey]['active'] == 't')
					echo "<img src='images/icon-campaign.gif' align='absmiddle'>&nbsp;";
				else
					echo "<img src='images/icon-campaign-d.gif' align='absmiddle'>&nbsp;";
				
				echo "<a href='stats-campaign-history.php?clientid=".$client['clientid']."&campaignid=".$campaigns[$ckey]['clientid']."'>".$campaigns[$ckey]['clientname']."</td>";
				echo "</td>";
				
				// ID
				echo "<td height='25'>".$campaigns[$ckey]['clientid']."</td>";
				
				// Button 1
				echo "<td height='25' align='".$phpAds_TextAlignRight."'>".phpAds_formatNumber($campaigns[$ckey]['views'])."</td>";
				
				// Button 2
				echo "<td height='25' align='".$phpAds_TextAlignRight."'>".phpAds_formatNumber($campaigns[$ckey]['clicks'])."</td>";
				
				// Button 3
				echo "<td height='25' align='".$phpAds_TextAlignRight."'>".phpAds_buildCTR($campaigns[$ckey]['views'], $campaigns[$ckey]['clicks'])."&nbsp;&nbsp;</td>";
				
				
				
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
						
						if ($banners[$bkey]['active'] == 't' && $campaigns[$ckey]['active'] == 't')
						{
							if ($banners[$bkey]['storagetype'] == 'html')
								echo "<img src='images/icon-banner-html.gif' align='absmiddle'>";
							elseif ($banners[$bkey]['storagetype'] == 'txt')
								echo "<img src='images/icon-banner-text.gif' align='absmiddle'>";
							elseif ($banners[$bkey]['storagetype'] == 'url')
								echo "<img src='images/icon-banner-url.gif' align='absmiddle'>";
							else
								echo "<img src='images/icon-banner-stored.gif' align='absmiddle'>";
						}
						else
						{
							if ($banners[$bkey]['storagetype'] == 'html')
								echo "<img src='images/icon-banner-html-d.gif' align='absmiddle'>";
							elseif ($banners[$bkey]['storagetype'] == 'txt')
								echo "<img src='images/icon-banner-text-d.gif' align='absmiddle'>";
							elseif ($banners[$bkey]['storagetype'] == 'url')
								echo "<img src='images/icon-banner-url-d.gif' align='absmiddle'>";
							else
								echo "<img src='images/icon-banner-stored-d.gif' align='absmiddle'>";
						}
						
						echo "&nbsp;<a href='stats-banner-history.php?clientid=".$client['clientid']."&campaignid=".$campaigns[$ckey]['clientid']."&bannerid=".$banners[$bkey]['bannerid']."'>".$name."</a></td>";
						
						// ID
						echo "<td height='25'>".$banners[$bkey]['bannerid']."</td>";
						
						// Empty
						echo "<td height='25' align='".$phpAds_TextAlignRight."'>".phpAds_formatNumber($banners[$bkey]['views'])."</td>";
						
						// Button 2
						echo "<td height='25' align='".$phpAds_TextAlignRight."'>".phpAds_formatNumber($banners[$bkey]['clicks'])."</td>";
						
						// Button 1
						echo "<td height='25' align='".$phpAds_TextAlignRight."'>".phpAds_buildCTR($banners[$bkey]['views'], $banners[$bkey]['clicks'])."&nbsp;&nbsp;</td>";
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
	
	
	// Total
	echo "<tr height='25' ".($i % 2 == 0 ? "bgcolor='#F6F6F6'" : "")."><td height='25'>&nbsp;&nbsp;<b>".$strTotal."</b></td>";
	echo "<td height='25'>&nbsp;</td>";
	echo "<td height='25' align='".$phpAds_TextAlignRight."'>".phpAds_formatNumber($totalviews)."</td>";
	echo "<td height='25' align='".$phpAds_TextAlignRight."'>".phpAds_formatNumber($totalclicks)."</td>";
	echo "<td height='25' align='".$phpAds_TextAlignRight."'>".phpAds_buildCTR($totalviews, $totalclicks)."&nbsp;&nbsp;</td>";
	echo "</tr>";
	echo "<tr height='1'><td colspan='5' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
	
	
	echo "<tr><td height='25' colspan='3' align='".$phpAds_TextAlignLeft."' nowrap>";
	
	if ($hideinactive == true)
	{
		echo "&nbsp;&nbsp;<img src='images/icon-activate.gif' align='absmiddle' border='0'>";
		echo "&nbsp;<a href='stats-global-client.php?hideinactive=0'>".$strShowAll."</a>";
		echo "&nbsp;&nbsp;|&nbsp;&nbsp;".$clientshidden." ".$strInactiveAdvertisersHidden;
	}
	else
	{
		echo "&nbsp;&nbsp;<img src='images/icon-hideinactivate.gif' align='absmiddle' border='0'>";
		echo "&nbsp;<a href='stats-global-client.php?hideinactive=1'>".$strHideInactiveAdvertisers."</a>";
	}
	
	echo "</td><td height='25' colspan='2' align='".$phpAds_TextAlignRight."' nowrap>";
	echo "<img src='images/triangle-d.gif' align='absmiddle' border='0'>";
	echo "&nbsp;<a href='stats-global-client.php?expand=all' accesskey='".$keyExpandAll."'>".$strExpandAll."</a>";
	echo "&nbsp;&nbsp;|&nbsp;&nbsp;";
	echo "<img src='images/".$phpAds_TextDirection."/triangle-l.gif' align='absmiddle' border='0'>";
	echo "&nbsp;<a href='stats-global-client.php?expand=none' accesskey='".$keyCollapseAll."'>".$strCollapseAll."</a>&nbsp;&nbsp;";
	echo "</td></tr>";
	
	
	/*
	
	// Spacer
	echo "<tr><td colspan='5' height='40'>&nbsp;</td></tr>";
	
	
	
	// Stats today
	$adviews  = (int)phpAds_totalViews("", "day");
	$adclicks = (int)phpAds_totalClicks("", "day");
	$ctr = phpAds_buildCTR($adviews, $adclicks);
		echo "<tr><td height='25' colspan='2'>&nbsp;&nbsp;<b>".$strToday."</b></td>";
		echo "<td height='25' align='".$phpAds_TextAlignRight."'>".phpAds_formatNumber($adviews)."</td>";
		echo "<td height='25' align='".$phpAds_TextAlignRight."'>".phpAds_formatNumber($adclicks)."</td>";
		echo "<td height='25' align='".$phpAds_TextAlignRight."'>".$ctr."&nbsp;&nbsp;</td></tr>";
		echo "<tr height='1'><td colspan='5' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
	
	
	// Stats this week
	$adviews  = (int)phpAds_totalViews("", "week");
	$adclicks = (int)phpAds_totalClicks("", "week");
	$ctr = phpAds_buildCTR($adviews, $adclicks);
		echo "<tr><td height='25' colspan='2'>&nbsp;&nbsp;".$strLast7Days."</td>";
		echo "<td height='25' align='".$phpAds_TextAlignRight."'>".phpAds_formatNumber($adviews)."</td>";
		echo "<td height='25' align='".$phpAds_TextAlignRight."'>".phpAds_formatNumber($adclicks)."</td>";
		echo "<td height='25' align='".$phpAds_TextAlignRight."'>".$ctr."&nbsp;&nbsp;</td></tr>";
		echo "<tr height='1'><td colspan='5' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
	
	
	// Stats this month
	$adviews  = (int)phpAds_totalViews("", "month");
	$adclicks = (int)phpAds_totalClicks("", "month");
	$ctr = phpAds_buildCTR($adviews, $adclicks);
		echo "<tr><td height='25' colspan='2'>&nbsp;&nbsp;".$strThisMonth."</td>";
		echo "<td height='25' align='".$phpAds_TextAlignRight."'>".phpAds_formatNumber($adviews)."</td>";
		echo "<td height='25' align='".$phpAds_TextAlignRight."'>".phpAds_formatNumber($adclicks)."</td>";
		echo "<td height='25' align='".$phpAds_TextAlignRight."'>".$ctr."&nbsp;&nbsp;</td></tr>";
		echo "<tr height='1'><td colspan='5' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
	
	*/
	
	echo "</table>";
	echo "<br><br>";
}
else
{
	echo "<br><br><div class='errormessage'><img class='errormessage' src='images/info.gif' width='16' height='16' border='0' align='absmiddle'>";
	echo $strNoStats.'</div>';
}



/*********************************************************/
/* Store preferences                                     */
/*********************************************************/

$Session['prefs']['stats-global-client.php']['hideinactive'] = $hideinactive;
$Session['prefs']['stats-global-client.php']['listorder'] = $listorder;
$Session['prefs']['stats-global-client.php']['orderdirection'] = $orderdirection;
$Session['prefs']['stats-global-client.php']['nodes'] = implode (",", $node_array);

$Session['prefs']['stats-global-client.php']['period'] = $period;
$Session['prefs']['stats-global-client.php']['period_range'] = $period_range;

phpAds_SessionDataStore();



/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

phpAds_PageFooter();

?>