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


if (!isset($type) || $type == '')
	$type = 's';

if (isset($lib_misc_params))
{
	for (reset($lib_misc_params); $key = key($lib_misc_params); next($lib_misc_params))
	{
		$params[] = $key.'='.$lib_misc_params[$key];
	}
	
	$params = '?'.implode ('&', $params).'&';
}
else
	$params = '?';



/*********************************************************/
/* Header                                                */
/*********************************************************/

$tabindex = 1;

echo "<form action='".$HTTP_SERVER_VARS['PHP_SELF']."'>";

if (isset($lib_misc_params))
	for (reset($lib_misc_params); $key = key($lib_misc_params); next($lib_misc_params))
		echo "<input type='hidden' name='".$key."' value='".$lib_misc_params[$key]."'>";

echo "<select name='type' onChange='this.form.submit();' accesskey='".$keyList."' tabindex='".($tabindex++)."'>";
echo "<option value='s'".($type == 's' ? ' selected' : '').">".$strSizeDistribution."</option>";
if (!$phpAds_config['compact_stats'] && $phpAds_config['geotracking_stats']) 
	echo "<option value='c'".($type == 'c' ? ' selected' : '').">".$strCountryDistribution."</option>";

echo "</select>&nbsp;&nbsp;<input type='image' src='images/".$phpAds_TextDirection."/go_blue.gif' border='0' name='submit'>&nbsp;";

phpAds_ShowBreak();
echo "</form>";
echo "<br><br>";


if ($type == 's')
{
	$dimensions = array();
	
	
	// Get the banners for each campaign
	$res_banners = phpAds_dbQuery("
		SELECT 
			bannerid,
			width,
			height
		FROM 
			".$phpAds_config['tbl_banners']."
		ORDER BY
			(width * height)
		") or phpAds_sqlDie();
	
	while ($row_banners = phpAds_dbFetchArray($res_banners))
	{
		$banners[$row_banners['bannerid']] = $row_banners;
		
		$dimension = $row_banners['width'].' x '.$row_banners['height'];
		$dimensions[$dimension] = array (
			'views' => 0,
			'clicks' => 0,
			'square' => $row_banners['width'] * $row_banners['height']
		);
	}
	
	
	// Get the adviews/clicks for each banner
	if ($phpAds_config['compact_stats'])
	{
		$res_stats = phpAds_dbQuery("
			SELECT
				bannerid,
				sum(views) as views,
				sum(clicks) as clicks
			FROM 
				".$phpAds_config['tbl_adstats']."
			GROUP BY
				bannerid
			") or phpAds_sqlDie();
		
		while ($row_stats = phpAds_dbFetchArray($res_stats))
		{
			$dimension = $banners[$row_stats['bannerid']]['width'].' x '.
						 $banners[$row_stats['bannerid']]['height'];
			
			$dimensions[$dimension]['clicks'] += $row_stats['clicks'];
			$dimensions[$dimension]['views'] += $row_stats['views'];
		}
	}
	else
	{
		$res_stats = phpAds_dbQuery("
			SELECT
				bannerid,
				count(bannerid) as views
			FROM 
				".$phpAds_config['tbl_adviews']."
			GROUP BY
				bannerid
			") or phpAds_sqlDie();
		
		while ($row_stats = phpAds_dbFetchArray($res_stats))
		{
			$dimension = $banners[$row_stats['bannerid']]['width'].' x '.
						 $banners[$row_stats['bannerid']]['height'];
			
			$dimensions[$dimension]['views'] += $row_stats['views'];
		}
		
		
		$res_stats = phpAds_dbQuery("
			SELECT
				bannerid,
				count(bannerid) as clicks
			FROM 
				".$phpAds_config['tbl_adclicks']."
			GROUP BY
				bannerid
			") or phpAds_sqlDie();
		
		while ($row_stats = phpAds_dbFetchArray($res_stats))
		{
			$dimension = $banners[$row_stats['bannerid']]['width'].' x '.
						 $banners[$row_stats['bannerid']]['height'];
			
			$dimensions[$dimension]['clicks'] += $row_stats['clicks'];
		}
	}
	
	// Get totals
	$totals['clicks'] = 0;
	$totals['views']  = 0;
	$top['cpp']	      = 0;
	
	reset ($dimensions);
	while (list($key, $value) = each ($dimensions))
	{
		$totals['clicks'] += $value['clicks'];
		$totals['views'] += $value['views'];
		
		$cpp = $value['square'] > 0 && $value['views'] > 0 ? $value['clicks'] / 
			   ($value['views'] * ($value['square'] / (468 * 60))) * 100 : 0;
		
		if ($cpp > $top['cpp']) $top['cpp'] = $cpp;
	}
	
	
	// Header
	echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";
	echo "<tr bgcolor='#FFFFFF' height='25'>";
	echo "<td align='".$phpAds_TextAlignLeft."' nowrap height='25'>&nbsp;<b>".$strSize."</b></td>";
	echo "<td width='20%' align='".$phpAds_TextAlignRight."' nowrap height='25'><b>".$strViews."</b></td>";
	echo "<td width='20%' align='".$phpAds_TextAlignRight."' nowrap height='25'><b>".$strClicks."</b></td>";
	echo "<td width='20%' align='".$phpAds_TextAlignRight."' nowrap height='25'><b>".$strCTRShort."</b></td>";
	echo "<td width='20%' align='".$phpAds_TextAlignRight."' nowrap height='25'><b>".$strEffectivity."</b>&nbsp;&nbsp;</td>";
	echo "</tr>";
	echo "<tr><td height='1' colspan='5' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
	
	
	$i = 0;
	reset ($dimensions);
	while (list($key, $value) = each ($dimensions))
	{
		$bgcolor = "#FFFFFF";
		$i % 2 ? 0 : $bgcolor = "#F6F6F6";
		
		echo "<tr><td height='25' bgcolor='$bgcolor'>&nbsp;";
		echo "<img src='images/icon-size.gif' align='absmiddle'>&nbsp;";
		echo $key."</td>";
		
		if ($top['cpp'] > 0)
		{
			$cpp = $value['square'] > 0 && $value['views'] > 0 ? $value['clicks'] / 
				   ($value['views'] * ($value['square'] / (468 * 60))) * 100 : 0;
			
			$effect = number_format($cpp * 100 / $top['cpp'], $phpAds_config['percentage_decimals'], $phpAds_DecimalPoint, $phpAds_ThousandsSeperator)."%";
		}
		else
			$effect = '-';
		
		echo "<td align='".$phpAds_TextAlignRight."' height='25' bgcolor='$bgcolor'>".phpAds_formatNumber($value['views'])."</td>";
		echo "<td align='".$phpAds_TextAlignRight."' height='25' bgcolor='$bgcolor'>".phpAds_formatNumber($value['clicks'])."</td>";
		echo "<td align='".$phpAds_TextAlignRight."' height='25' bgcolor='$bgcolor'>".phpAds_buildCTR($value['views'], $value['clicks'])."</td>";
		echo "<td align='".$phpAds_TextAlignRight."' height='25' bgcolor='$bgcolor'>".$effect."&nbsp;&nbsp;</td>";
		echo "</tr>";
		
		echo "<tr><td height='1' colspan='5' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";	
		
		$i++;
	}
	
	$bgcolor = "#FFFFFF";
	$i % 2 ? 0 : $bgcolor = "#F6F6F6";
	
	echo "<tr><td height='25' bgcolor='$bgcolor'>&nbsp;";
	echo "<b>".$strTotal."</b></td>";
	echo "<td align='".$phpAds_TextAlignRight."' height='25' bgcolor='$bgcolor'>".phpAds_formatNumber($totals['views'])."</td>";
	echo "<td align='".$phpAds_TextAlignRight."' height='25' bgcolor='$bgcolor'>".phpAds_formatNumber($totals['clicks'])."</td>";
	echo "<td align='".$phpAds_TextAlignRight."' height='25' bgcolor='$bgcolor'>".phpAds_buildCTR($totals['views'], $totals['clicks'])."</td>";
	echo "<td align='".$phpAds_TextAlignRight."' height='25' bgcolor='$bgcolor'>&nbsp;</td>";
	echo "</tr>";
	echo "<tr><td height='1' colspan='5' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";	
	
	echo "</table>";
}


if ($type == 'c')
{
	require	(phpAds_path."/libraries/resources/res-iso3166.inc.php"); 
	require	(phpAds_path."/libraries/resources/res-continent.inc.php"); 
	
	$countries = array();
	$continents = array();
	
	// Get the adviews/clicks for each banner
	$res_stats = phpAds_dbQuery("
		SELECT
			country,
			count(bannerid) as views
		FROM 
			".$phpAds_config['tbl_adviews']."
		GROUP BY
			country
		") or phpAds_sqlDie();
	
	while ($row_stats = phpAds_dbFetchArray($res_stats))
	{
		if (isset($countries[$row_stats['country']]))
		{
			$countries[$row_stats['country']]['views'] += $row_stats['views'];
		}
		else
		{
			$countries[$row_stats['country']]['views']  = $row_stats['views'];
			$countries[$row_stats['country']]['clicks'] = 0;
		}
		
		if (isset($phpAds_continent[$row_stats['country']]))
			$continent = $phpAds_continent[$row_stats['country']];
		else
			$continent = '';
		
		if (isset($continents[$continent]))
		{
			$continents[$continent]['views'] += $row_stats['views'];
		}
		else
		{
			$continents[$continent]['views']  = $row_stats['views'];
			$continents[$continent]['clicks'] = 0;
		}
	}
	
	
	$res_stats = phpAds_dbQuery("
		SELECT
			country,
			count(bannerid) as clicks
		FROM 
			".$phpAds_config['tbl_adclicks']."
		GROUP BY
			country
		") or phpAds_sqlDie();
	
	while ($row_stats = phpAds_dbFetchArray($res_stats))
	{
		if (isset($countries[$row_stats['country']]))
		{
			$countries[$row_stats['country']]['clicks'] += $row_stats['clicks'];
		}
		else
		{
			$countries[$row_stats['country']]['clicks']  = $row_stats['clicks'];
			$countries[$row_stats['country']]['views'] = 0;
		}
		
		if (isset($phpAds_continent[$row_stats['country']]))
			$continent = $phpAds_continent[$row_stats['country']];
		else
			$continent = '';
		
		if (isset($continents[$continent]))
		{
			$continents[$continent]['clicks'] += $row_stats['clicks'];
		}
		else
		{
			$continents[$continent]['clicks']  = $row_stats['clicks'];
			$continents[$continent]['views'] = 0;
		}
	}
	
	arsort ($countries);
	arsort ($continents);
	
	// Header
	echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";
	echo "<tr bgcolor='#FFFFFF' height='25'>";
	echo "<td align='".$phpAds_TextAlignLeft."' nowrap height='25'>&nbsp;<b>".$strContinent."</b></td>";
	echo "<td width='20%' align='".$phpAds_TextAlignRight."' nowrap height='25'><b>".$strViews."</b></td>";
	echo "<td width='20%' align='".$phpAds_TextAlignRight."' nowrap height='25'><b>".$strClicks."</b></td>";
	echo "<td width='20%' align='".$phpAds_TextAlignRight."' nowrap height='25'><b>".$strCTRShort."</b>&nbsp;&nbsp;</td>";
	echo "</tr>";
	echo "<tr><td height='1' colspan='4' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
	
	$totals['clicks'] = 0;
	$totals['views']  = 0;
	
	$i = 0;
	reset ($continents);
	while (list($key, $value) = each ($continents))
	{
		$bgcolor = "#FFFFFF";
		$i % 2 ? 0 : $bgcolor = "#F6F6F6";
		
		echo "<tr><td height='25' bgcolor='$bgcolor'>&nbsp;";
		echo $key != '' ? $phpAds_cont_name[$key] : $strUnknown;
		echo "</td>";
		echo "<td align='".$phpAds_TextAlignRight."' height='25' bgcolor='$bgcolor'>".phpAds_formatNumber($value['views'])."</td>";
		echo "<td align='".$phpAds_TextAlignRight."' height='25' bgcolor='$bgcolor'>".phpAds_formatNumber($value['clicks'])."</td>";
		echo "<td align='".$phpAds_TextAlignRight."' height='25' bgcolor='$bgcolor'>".phpAds_buildCTR($value['views'], $value['clicks'])."&nbsp;&nbsp;</td>";
		echo "</tr>";
		
		echo "<tr><td height='1' colspan='4' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";	
		
		$totals['clicks'] += $value['clicks'];
		$totals['views']  += $value['views'];
		
		$i++;
	}
	
	$bgcolor = "#FFFFFF";
	$i % 2 ? 0 : $bgcolor = "#F6F6F6";
	
	echo "<tr><td height='25' bgcolor='$bgcolor'>&nbsp;";
	echo "<b>".$strTotal."</b></td>";
	echo "<td align='".$phpAds_TextAlignRight."' height='25' bgcolor='$bgcolor'>".phpAds_formatNumber($totals['views'])."</td>";
	echo "<td align='".$phpAds_TextAlignRight."' height='25' bgcolor='$bgcolor'>".phpAds_formatNumber($totals['clicks'])."</td>";
	echo "<td align='".$phpAds_TextAlignRight."' height='25' bgcolor='$bgcolor'>".phpAds_buildCTR($totals['views'], $totals['clicks'])."&nbsp;&nbsp;</td>";
	echo "</tr>";
	echo "<tr><td height='1' colspan='4' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";	
	
	echo "</table>";
	echo "<br><br>";
	echo "<br><br>";
	
	
	// Header
	echo "<table border='0' width='100%' cellpadding='0' cellspacing='0'>";
	echo "<tr bgcolor='#FFFFFF' height='25'>";
	echo "<td align='".$phpAds_TextAlignLeft."' nowrap height='25'>&nbsp;<b>".$strCountry."</b></td>";
	echo "<td width='20%' align='".$phpAds_TextAlignRight."' nowrap height='25'><b>".$strViews."</b></td>";
	echo "<td width='20%' align='".$phpAds_TextAlignRight."' nowrap height='25'><b>".$strClicks."</b></td>";
	echo "<td width='20%' align='".$phpAds_TextAlignRight."' nowrap height='25'><b>".$strCTRShort."</b>&nbsp;&nbsp;</td>";
	echo "</tr>";
	echo "<tr><td height='1' colspan='4' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";
	
	$totals['clicks'] = 0;
	$totals['views']  = 0;
	
	$i = 0;
	reset ($countries);
	while (list($key, $value) = each ($countries))
	{
		$bgcolor = "#FFFFFF";
		$i % 2 ? 0 : $bgcolor = "#F6F6F6";
		
		echo "<tr><td height='25' bgcolor='$bgcolor'>&nbsp;";
		echo $key != '' ? "<img src='images/flags/".strtolower($key).".gif' width='19' height'11'>&nbsp;".$phpAds_ISO3166[$key] : $strUnknown;
		echo "</td>";
		echo "<td align='".$phpAds_TextAlignRight."' height='25' bgcolor='$bgcolor'>".phpAds_formatNumber($value['views'])."</td>";
		echo "<td align='".$phpAds_TextAlignRight."' height='25' bgcolor='$bgcolor'>".phpAds_formatNumber($value['clicks'])."</td>";
		echo "<td align='".$phpAds_TextAlignRight."' height='25' bgcolor='$bgcolor'>".phpAds_buildCTR($value['views'], $value['clicks'])."&nbsp;&nbsp;</td>";
		echo "</tr>";
		
		echo "<tr><td height='1' colspan='4' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";	
		
		$totals['clicks'] += $value['clicks'];
		$totals['views']  += $value['views'];
		
		$i++;
	}
	
	$bgcolor = "#FFFFFF";
	$i % 2 ? 0 : $bgcolor = "#F6F6F6";
	
	echo "<tr><td height='25' bgcolor='$bgcolor'>&nbsp;";
	echo "<b>".$strTotal."</b></td>";
	echo "<td align='".$phpAds_TextAlignRight."' height='25' bgcolor='$bgcolor'>".phpAds_formatNumber($totals['views'])."</td>";
	echo "<td align='".$phpAds_TextAlignRight."' height='25' bgcolor='$bgcolor'>".phpAds_formatNumber($totals['clicks'])."</td>";
	echo "<td align='".$phpAds_TextAlignRight."' height='25' bgcolor='$bgcolor'>".phpAds_buildCTR($totals['views'], $totals['clicks'])."&nbsp;&nbsp;</td>";
	echo "</tr>";
	echo "<tr><td height='1' colspan='4' bgcolor='#888888'><img src='images/break.gif' height='1' width='100%'></td></tr>";	
	
	echo "</table>";
}


echo "<br><br>";

?>