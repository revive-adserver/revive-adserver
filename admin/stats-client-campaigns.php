<?php // $Revision$

/************************************************************************/
/* Openads 2.0                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2000-2007 by the Openads developers                    */
/* For more information visit: http://www.openads.org                   */
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
phpAds_checkAccess(phpAds_Admin+phpAds_Client);


// Set default values
$tabindex = 1;



/*********************************************************/
/* Client interface security                             */
/*********************************************************/

if (phpAds_isUser(phpAds_Client))
{
	$clientid = phpAds_getUserID();
}



/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

if (phpAds_isUser(phpAds_Admin))
{
	if (isset($Session['prefs']['stats-global-client.php']['listorder']))
		$navorder = $Session['prefs']['stats-global-client.php']['listorder'];
	else
		$navorder = '';
	
	if (isset($Session['prefs']['stats-global-client.php']['orderdirection']))
		$navdirection = $Session['prefs']['stats-global-client.php']['orderdirection'];
	else
		$navdirection = '';
	
	$res = phpAds_dbQuery("
		SELECT
			*
		FROM
			".$phpAds_config['tbl_clients']."
		WHERE
			parent = 0
		".phpAds_getListOrder ($navorder, $navdirection)."
	") or phpAds_sqlDie();
	
	while ($row = phpAds_dbFetchArray($res))
	{
		phpAds_PageContext (
			phpAds_buildClientName ($row['clientid'], $row['clientname']),
			"stats-client-campaigns.php?clientid=".$row['clientid'],
			$clientid == $row['clientid']
		);
	}
	
	phpAds_PageShortcut($strClientProperties, 'client-edit.php?clientid='.$clientid, 'images/icon-client.gif');
	
	phpAds_PageHeader("2.1.2");
		echo "<img src='images/icon-client.gif' align='absmiddle'>&nbsp;<b>".phpAds_getClientName($clientid)."</b><br><br><br>";
		phpAds_ShowSections(array("2.1.1", "2.1.2"));
}

if (phpAds_isUser(phpAds_Client))
{
	phpAds_PageHeader("1.2");
	
	if ($phpAds_config['client_welcome'])
	{
		echo "<br><br>";
		// Show welcome message
		if (!empty($phpAds_client_welcome_msg))
			echo $phpAds_client_welcome_msg;
		else
			include('templates/welcome-advertiser.html');
		echo "<br><br>";
	}
	
	phpAds_ShowSections(array("1.1", "1.2"));
}



/*********************************************************/
/* Get preferences                                       */
/*********************************************************/

if (!isset($hideinactive))
{
	if (isset($Session['prefs']['stats-client-campaigns.php']['hideinactive']))
		$hideinactive = $Session['prefs']['stats-client-campaigns.php']['hideinactive'];
	else
		$hideinactive = ($phpAds_config['gui_hide_inactive'] == 't');
}

if (!isset($listorder))
{
	if (isset($Session['prefs']['stats-client-campaigns.php']['listorder']))
		$listorder = $Session['prefs']['stats-client-campaigns.php']['listorder'];
	else
		$listorder = '';
}

if (!isset($orderdirection))
{
	if (isset($Session['prefs']['stats-client-campaigns.php']['orderdirection']))
		$orderdirection = $Session['prefs']['stats-client-campaigns.php']['orderdirection'];
	else
		$orderdirection = '';
}

if (isset($Session['prefs']['stats-client-campaigns.php']['nodes']))
	$node_array = explode (",", $Session['prefs']['stats-client-campaigns.php']['nodes']);
else
	$node_array = array();


if (!isset($period))
{
	if (isset($Session['prefs']['stats-client-campaigns.php']['period']))
		$period = $Session['prefs']['stats-client-campaigns.php']['period'];
	else
		$period = '';
}


if (!isset($period_range))
{
	if (isset($Session['prefs']['stats-client-campaigns.php']['period_range']))
		$period_range = $Session['prefs']['stats-client-campaigns.php']['period_range'];
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

$res_campaigns = phpAds_dbQuery("
	SELECT 
		*
	FROM 
		".$phpAds_config['tbl_clients']."
	WHERE
		parent = ".$clientid."
	".phpAds_getListOrder ($listorder, $orderdirection)."
") or phpAds_sqlDie();

$campaignids = array();
while ($row_campaigns = phpAds_dbFetchArray($res_campaigns))
{
	$campaigns[$row_campaigns['clientid']] = $row_campaigns;
	$campaigns[$row_campaigns['clientid']]['expand'] = 0;
	$campaigns[$row_campaigns['clientid']]['count'] = 0;
	
	$campaignids[] = $row_campaigns['clientid'];
}

$banners = array();
$bannerids = array();
if (count($campaignids))
{
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
		WHERE
			clientid IN (".join(', ', $campaignids).")
			".phpAds_getBannerListOrder ($listorder, $orderdirection)."
		") or phpAds_sqlDie();
	
	while ($row_banners = phpAds_dbFetchArray($res_banners))
	{
		if (isset($campaigns[$row_banners['clientid']]))
		{
			$banners[$row_banners['bannerid']] = $row_banners;
			$banners[$row_banners['bannerid']]['clicks'] = 0;
			$banners[$row_banners['bannerid']]['views'] = 0;
			$campaigns[$row_banners['clientid']]['count']++;
			
			$bannerids[] = $row_banners['bannerid'];
		}
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
if (count($bannerids))
{
	if ($phpAds_config['compact_stats'])
	{
			$res_stats = phpAds_dbQuery("
				SELECT
					bannerid,
					sum(views) as views,
					sum(clicks) as clicks
				FROM 
					".$phpAds_config['tbl_adstats']."
				WHERE
					bannerid IN (".join(', ', $bannerids).")".$limit."
				GROUP BY
					bannerid
				") or phpAds_sqlDie();
			
			while ($row_stats = phpAds_dbFetchArray($res_stats))
			{
				$banners[$row_stats['bannerid']]['clicks'] = $row_stats['clicks'];
				$banners[$row_stats['bannerid']]['views'] = $row_stats['views'];
			}
	}
	else
	{
		$res_stats = phpAds_dbQuery("
			SELECT
				bannerid,
				count(*) as views
			FROM 
				".$phpAds_config['tbl_adviews']."
			WHERE
				bannerid IN (".join(', ', $bannerids).")".$limit."
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
			WHERE
				bannerid IN (".join(', ', $bannerids).")".$limit."
			GROUP BY
				bannerid
			") or phpAds_sqlDie();
		
		while ($row_stats = phpAds_dbFetchArray($res_stats))
		{
			$banners[$row_stats['bannerid']]['clicks'] = $row_stats['clicks'];
		}
	}
}



// Add ID found in expand to expanded nodes
if (isset($expand) && $expand != '')
{
	switch ($expand)
	{
		case 'all' :	$node_array   = array();
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
		if (isset($campaigns[$node_array[$i]]))
			$campaigns[$node_array[$i]]['expand'] = 1;
	}
}



// Build Tree
$campaignshidden = 0;

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
	while (list ($key, $campaign) = each ($campaigns))
	{
		if (!isset($campaign['banners']))
			$campaign['banners'] = array();
		
		if ($hideinactive == true && ($campaign['active'] == 'f' || $campaign['active'] == 't' && 
			count($campaign['banners']) == 0 && count($campaign['banners']) < $campaign['count']))
		{
			$campaignshidden++;
			unset($campaigns[$key]);
		}
	}
}


$totalviews = 0;
$totalclicks = 0;

if (isset($campaigns) && is_array($campaigns) && sizeof ($campaigns) > 0)
{
	// Calculate statistics for campaigns
	foreach (array_keys($campaigns) as $ckey)
	{
		$campaignviews = 0;
		$campaignclicks = 0;
		
		if (isset($campaigns[$ckey]['banners']) && sizeof ($campaigns[$ckey]['banners']) > 0)
		{
			$banners = $campaigns[$ckey]['banners'];
			foreach (array_keys($banners) as $bkey)
			{
				$campaignviews += $banners[$bkey]['views'];
				$campaignclicks += $banners[$bkey]['clicks'];
			}
		}
		
		$totalviews += $campaignviews;
		$totalclicks += $campaignclicks;
		
		$campaigns[$ckey]['views'] = $campaignviews;
		$campaigns[$ckey]['clicks'] = $campaignclicks;
	}
	
	unset ($banners);
}


echo "<form action='".$_SERVER['PHP_SELF']."'>";
echo "<input type='hidden' name='clientid' value='".$clientid."'>";

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





if ($campaignshidden > 0 || $totalviews > 0 || $totalclicks > 0)
{
	echo "<br><br>";
	echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";	
	
	echo "<tr height='25'>";
	echo '<td height="25" width="40%"><b>&nbsp;&nbsp;<a href="stats-client-campaigns.php?clientid='.$clientid.'&listorder=name">'.$GLOBALS['strName'].'</a>';
	if (($listorder == "name") || ($listorder == ""))
	{
		if  (($orderdirection == "") || ($orderdirection == "down"))
		{
			echo ' <a href="stats-client-campaigns.php?clientid='.$clientid.'&orderdirection=up">';
			echo '<img src="images/caret-ds.gif" border="0" alt="" title="">';
		}
		else
		{
			echo ' <a href="stats-client-campaigns.php?clientid='.$clientid.'&orderdirection=down">';
			echo '<img src="images/caret-u.gif" border="0" alt="" title="">';
		}
		echo '</a>';
	}
	echo '</b></td>';
	echo '<td height="25"><b><a href="stats-client-campaigns.php?clientid='.$clientid.'&listorder=id">'.$GLOBALS['strID'].'</a>';
	if ($listorder == "id")
	{
		if  (($orderdirection == "") || ($orderdirection == "down"))
		{
			echo ' <a href="stats-client-campaigns.php?clientid='.$clientid.'&orderdirection=up">';
			echo '<img src="images/caret-ds.gif" border="0" alt="" title="">';
		}
		else
		{
			echo ' <a href="stats-client-campaigns.php?clientid='.$clientid.'&orderdirection=down">';
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
	foreach (array_keys($campaigns) as $ckey)
	{
		// Icon & name
		echo "<tr height='25' ".($i % 2 == 0 ? "bgcolor='#F6F6F6'" : "")."><td height='25'>";
		echo "&nbsp;";
		
		if (isset($campaigns[$ckey]['banners']))
		{
			if ($campaigns[$ckey]['expand'] == '1')
				echo "<a href='stats-client-campaigns.php?clientid=".$clientid."&collapse=".$campaigns[$ckey]['clientid']."'><img src='images/triangle-d.gif' align='absmiddle' border='0'></a>&nbsp;";
			else
				echo "<a href='stats-client-campaigns.php?clientid=".$clientid."&expand=".$campaigns[$ckey]['clientid']."'><img src='images/".$phpAds_TextDirection."/triangle-l.gif' align='absmiddle' border='0'></a>&nbsp;";
		}
		else
			echo "<img src='images/spacer.gif' height='16' width='16'>&nbsp;";
		
		
		if ($campaigns[$ckey]['active'] == 't')
			echo "<img src='images/icon-campaign.gif' align='absmiddle'>&nbsp;";
		else
			echo "<img src='images/icon-campaign-d.gif' align='absmiddle'>&nbsp;";
		
		echo "<a href='stats-campaign-history.php?clientid=".$clientid."&campaignid=".$campaigns[$ckey]['clientid']."'>".$campaigns[$ckey]['clientname']."</td>";
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
			foreach (array_keys($banners) as $bkey)
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
				echo "<td height='25'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
				
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
				
				echo "&nbsp;<a href='stats-banner-history.php?clientid=".$clientid."&campaignid=".$campaigns[$ckey]['clientid']."&bannerid=".$banners[$bkey]['bannerid']."'>".$name."</a></td>";
				
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
	
	echo "<tr height='25'><td colspan='2' height='25' align='".$phpAds_TextAlignLeft."' nowrap>";
	
	if ($hideinactive == true)
	{
		echo "&nbsp;&nbsp;<img src='images/icon-activate.gif' align='absmiddle' border='0'>";
		echo "&nbsp;<a href='stats-client-campaigns.php?clientid=".$clientid."&hideinactive=0'>".$strShowAll."</a>";
		echo "&nbsp;&nbsp;|&nbsp;&nbsp;".$campaignshidden." ".$strInactiveCampaignsHidden;
	}
	else
	{
		echo "&nbsp;&nbsp;<img src='images/icon-hideinactivate.gif' align='absmiddle' border='0'>";
		echo "&nbsp;<a href='stats-client-campaigns.php?clientid=".$clientid."&hideinactive=1'>".$strHideInactiveCampaigns."</a>";
	}
	
	echo "</td>";
	echo "<td colspan='3' height='25' align='".$phpAds_TextAlignRight."' nowrap>";
	echo "<img src='images/triangle-d.gif' align='absmiddle' border='0'>";
	echo "&nbsp;<a href='stats-client-campaigns.php?clientid=".$clientid."&expand=all' accesskey='".$keyExpandAll."'>".$strExpandAll."</a>";
	echo "&nbsp;&nbsp;|&nbsp;&nbsp;";
	echo "<img src='images/".$phpAds_TextDirection."/triangle-l.gif' align='absmiddle' border='0'>";
	echo "&nbsp;<a href='stats-client-campaigns.php?clientid=".$clientid."&expand=none' accesskey='".$keyCollapseAll."'>".$strCollapseAll."</a>&nbsp;&nbsp;";
	echo "</td>";
	echo "</tr>";
	
	
	echo "</table>";
	echo "<br><br><br><br>";
}
else
{
	echo "<br><div class='errormessage'><img class='errormessage' src='images/info.gif' width='16' height='16' border='0' align='absmiddle'>";
	echo $strNoStats.'</div>';
}



/*********************************************************/
/* Store preferences                                     */
/*********************************************************/

$Session['prefs']['stats-client-campaigns.php']['hideinactive'] = $hideinactive;
$Session['prefs']['stats-client-campaigns.php']['listorder'] = $listorder;
$Session['prefs']['stats-client-campaigns.php']['orderdirection'] = $orderdirection;
$Session['prefs']['stats-client-campaigns.php']['nodes'] = implode (",", $node_array);

$Session['prefs']['stats-client-campaigns.php']['period'] = $period;
$Session['prefs']['stats-client-campaigns.php']['period_range'] = $period_range;

phpAds_SessionDataStore();



/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

phpAds_PageFooter();

?>