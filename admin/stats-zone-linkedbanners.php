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


// Register input variables
phpAds_registerGlobal ('expand', 'collapse', 'listorder', 'orderdirection', 'period', 'period_range');


// Security check
phpAds_checkAccess(phpAds_Admin+phpAds_Affiliate);


// Set default values
$tabindex = 1;



/*********************************************************/
/* Affiliate interface security                          */
/*********************************************************/

if (phpAds_isUser(phpAds_Affiliate))
{
	if (isset($zoneid) && $zoneid > 0)
	{
		$result = phpAds_dbQuery("
			SELECT
				affiliateid
			FROM
				".$phpAds_config['tbl_zones']."
			WHERE
				zoneid = '$zoneid'
			") or phpAds_sqlDie();
		$row = phpAds_dbFetchArray($result);
		
		if ($row["affiliateid"] == '' || phpAds_getUserID() != $row["affiliateid"])
		{
			phpAds_PageHeader("1");
			phpAds_Die ($strAccessDenied, $strNotAdmin);
		}
		else
		{
			$affiliateid = phpAds_getUserID();
		}
	}
	else
	{
		phpAds_PageHeader("1");
		phpAds_Die ($strAccessDenied, $strNotAdmin);
	}
}



/*********************************************************/
/* Get preferences                                       */
/*********************************************************/

if (!isset($period))
{
	if (isset($Session['prefs']['stats-zone-linkedbanners.php']['period']))
		$period = $Session['prefs']['stats-zone-linkedbanners.php']['period'];
	else
		$period = '';
}


if (!isset($period_range))
{
	if (isset($Session['prefs']['stats-zone-linkedbanners.php']['period_range']))
		$period_range = $Session['prefs']['stats-zone-linkedbanners.php']['period_range'];
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
/* HTML framework                                        */
/*********************************************************/

if (phpAds_isUser(phpAds_Admin))
{
	$res = phpAds_dbQuery("
		SELECT
			*
		FROM
			".$phpAds_config['tbl_zones']."
		WHERE
			affiliateid = '".$affiliateid."'
	") or phpAds_sqlDie();
	
	while ($row = phpAds_dbFetchArray($res))
	{
		phpAds_PageContext (
			phpAds_buildZoneName ($row['zoneid'], $row['zonename']),
			"stats-zone-linkedbanners.php?affiliateid=".$affiliateid."&zoneid=".$row['zoneid'],
			$zoneid == $row['zoneid']
		);
	}
	
	phpAds_PageShortcut($strAffiliateProperties, 'affiliate-edit.php?affiliateid='.$affiliateid, 'images/icon-affiliate.gif');	
	phpAds_PageShortcut($strZoneProperties, 'zone-edit.php?affiliateid='.$affiliateid.'&zoneid='.$zoneid, 'images/icon-zone.gif');	
	phpAds_PageShortcut($strIncludedBanners, 'zone-include.php?affiliateid='.$affiliateid.'&zoneid='.$zoneid, 'images/icon-zone-linked.gif');	
	
	
	phpAds_PageHeader("2.4.2.2");
		echo "<img src='images/icon-affiliate.gif' align='absmiddle'>&nbsp;".phpAds_getAffiliateName($affiliateid);
		echo "&nbsp;<img src='images/".$phpAds_TextDirection."/caret-rs.gif'>&nbsp;";
		echo "<img src='images/icon-zone.gif' align='absmiddle'>&nbsp;<b>".phpAds_getZoneName($zoneid)."</b><br><br><br>";
		phpAds_ShowSections(array("2.4.2.1", "2.4.2.2"));
}
else
{
	phpAds_PageHeader("1.1.2");
		echo "<img src='images/icon-zone.gif' align='absmiddle'>&nbsp;<b>".phpAds_getZoneName($zoneid)."</b><br><br><br>";
		phpAds_ShowSections(array("1.1.1", "1.1.2"));
}



/*********************************************************/
/* Main code                                             */
/*********************************************************/

$totalviews = 0;
$totalclicks = 0;

// Get the zone information
$res_stats = phpAds_dbQuery("
	SELECT
		what
	FROM 
		".$phpAds_config['tbl_zones']."
	WHERE
		zoneid = '".$zoneid."'
");

if ($row_zone = phpAds_dbFetchArray($res_stats))
{
	$zone = $row_zone;
	

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
	if ($phpAds_config['compact_stats'])
	{
		$res_stats = phpAds_dbQuery("
			SELECT
				bannerid,
				SUM(views) AS views,
				sum(clicks) AS clicks
			FROM 
				".$phpAds_config['tbl_adstats']."
			WHERE
				zoneid = '".$zoneid."'".$limit."
			GROUP BY
				zoneid, bannerid
		");
		
		while ($row_stats = phpAds_dbFetchArray($res_stats))
		{
			$linkedbanners[$row_stats['bannerid']]['bannerid'] = $row_stats['bannerid'];
			$linkedbanners[$row_stats['bannerid']]['clicks'] = $row_stats['clicks'];
			$linkedbanners[$row_stats['bannerid']]['views'] = $row_stats['views'];
			
			$totalclicks += $row_stats['clicks'];
			$totalviews  += $row_stats['views'];
		}
	}
	else
	{
		$res_stats = phpAds_dbQuery("
			SELECT
				zoneid,
				bannerid,
				count(bannerid) as views
			FROM 
				".$phpAds_config['tbl_adviews']."
			WHERE
				zoneid = '".$zoneid."'".$limit."
			GROUP BY
				zoneid, bannerid
		");
		
		while ($row_stats = phpAds_dbFetchArray($res_stats))
		{
			$linkedbanners[$row_stats['bannerid']]['bannerid'] = $row_stats['bannerid'];
			$linkedbanners[$row_stats['bannerid']]['clicks'] = 0;
			$linkedbanners[$row_stats['bannerid']]['views'] = $row_stats['views'];
			
			$totalviews  += $row_stats['views'];
		}
		
		
		$res_stats = phpAds_dbQuery("
			SELECT
				zoneid,
				bannerid,
				count(bannerid) as clicks
			FROM 
				".$phpAds_config['tbl_adclicks']."
			WHERE
				zoneid = '".$zoneid."'".$limit."
			GROUP BY
				zoneid, bannerid
		");
		
		while ($row_stats = phpAds_dbFetchArray($res_stats))
		{
			$linkedbanners[$row_stats['bannerid']]['bannerid'] = $row_stats['bannerid'];
			$linkedbanners[$row_stats['bannerid']]['clicks'] = $row_stats['clicks'];
			
			$totalclicks += $row_stats['clicks'];
		}
	}
}


echo "<form action='".$_SERVER['PHP_SELF']."'>";
echo "<input type='hidden' name='affiliateid' value='".$affiliateid."'>";
echo "<input type='hidden' name='zoneid' value='".$zoneid."'>";

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
	echo '<td height="25"><b>&nbsp;&nbsp;'.$GLOBALS['strName'].'</b></td>';
	echo '<td height="25"><b>'.$GLOBALS['strID'].'</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>';
	echo "<td height='25' align='".$phpAds_TextAlignRight."'><b>".$GLOBALS['strViews']."</b></td>";
	echo "<td height='25' align='".$phpAds_TextAlignRight."'><b>".$GLOBALS['strClicks']."</b></td>";
	echo "<td height='25' align='".$phpAds_TextAlignRight."'><b>".$GLOBALS['strCTRShort']."</b>&nbsp;&nbsp;</td>";
	echo "</tr>";
	
	echo "<tr height='1'><td colspan='5' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
	
	
	$i=0;
	while (list($key,) = each($linkedbanners))
	{
		$linkedbanner = $linkedbanners[$key];
		
		echo "<tr height='25' ".($i%2==0?"bgcolor='#F6F6F6'":"").">";
		
		// Icon & name
		echo "<td height='25'>";
		
		if (ereg ('bannerid:'.$linkedbanner['bannerid'], $zone['what']))
			echo "&nbsp;&nbsp;<img src='images/icon-zone-linked.gif' align='absmiddle'>&nbsp;";
		else
			echo "&nbsp;&nbsp;<img src='images/icon-banner-stored.gif' align='absmiddle'>&nbsp;";
		
		echo "<a href='stats-linkedbanner-history.php?affiliateid=".$affiliateid."&zoneid=".$zoneid."&bannerid=".$linkedbanner['bannerid']."'>".phpAds_getBannerName($linkedbanner['bannerid'], 30, false)."</a>";
		echo "</td>";
		
		echo "<td height='25'>".$linkedbanner['bannerid']."</td>";
		echo "<td height='25' align='".$phpAds_TextAlignRight."'>".phpAds_formatNumber($linkedbanner['views'])."</td>";
		echo "<td height='25' align='".$phpAds_TextAlignRight."'>".phpAds_formatNumber($linkedbanner['clicks'])."</td>";
		echo "<td height='25' align='".$phpAds_TextAlignRight."'>".phpAds_buildCTR($linkedbanner['views'], $linkedbanner['clicks'])."&nbsp;&nbsp;</td>";
		echo "</tr>";
		
		echo "<tr height='1'><td colspan='5' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
		$i++;
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

$Session['prefs']['stats-zone-linkedbanners.php']['period'] = $period;
$Session['prefs']['stats-zone-linkedbanners.php']['period_range'] = $period_range;

phpAds_SessionDataStore();



/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

phpAds_PageFooter();

?>