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


// Public name of the plugin info function
$plugin_info_function		= "Plugin_ZonehistoryInfo";


// Public info function
function Plugin_ZonehistoryInfo()
{
	global $strZoneHistory, $strZone, $strPluginZone, $strDelimiter, $strUseQuotes;
	
	$plugininfo = array (
		"plugin-name"			=> $strZoneHistory,
		"plugin-description"	=> $strPluginZone,
		"plugin-author"			=> "Niels Leenheer",
		"plugin-export"			=> "csv",
		"plugin-authorize"		=> phpAds_Admin+phpAds_Affiliate,
		"plugin-execute"		=> "Plugin_ZonehistoryExecute",
		"plugin-import"			=> array (
			"campaignid"			=> array (
				"title"					=> $strZone,
				"type"					=> "zoneid-dropdown" ),
			"delimiter"				=> array (
				"title"					=> $strDelimiter,
				"type"					=> "delimiter" ),
			"quotes"				=> array (
				"title"					=> $strUseQuotes,
				"type"					=> "quotes" ) )
	);
	
	return ($plugininfo);
}



/*********************************************************/
/* Private plugin function                               */
/*********************************************************/

function Plugin_ZonehistoryExecute($zoneid, $delimiter=",", $quotes="")
{
	global $phpAds_config, $date_format;
	global $strZone, $strTotal, $strDay, $strViews, $strClicks, $strCTRShort;
	
	// Expand delimiter and quotes
	if ($delimiter == 't')	$delimiter = "\t";
	if ($quotes == '1')		$quotes = "'";
	if ($quotes == '2')		$quotes = '"';
	
	header ("Content-type: application/csv\nContent-Disposition: inline; filename=\"zonehistory.csv\"");
	
	if ($phpAds_config['compact_stats'])
	{
		$res_query = "
			SELECT
				DATE_FORMAT(day, '%Y%m%d') as date,
				DATE_FORMAT(day, '$date_format') as date_formatted,
				SUM(views) AS adviews,
				SUM(clicks) AS adclicks
			FROM
				".$phpAds_config['tbl_adstats']."
			WHERE
				zoneid = '".$zoneid."'
			GROUP BY
				day
			ORDER BY
				date
		";
		
		$res_banners = phpAds_dbQuery($res_query) or phpAds_sqlDie();
		
		while ($row_banners = phpAds_dbFetchArray($res_banners))
		{
			$stats [$row_banners['date_formatted']]['views'] = $row_banners['adviews'];
			$stats [$row_banners['date_formatted']]['clicks'] = $row_banners['adclicks'];
		}
	}
	else
	{
		$res_query = "
			SELECT
				DATE_FORMAT(t_stamp, '%Y%m%d') as date,
				DATE_FORMAT(t_stamp, '".$date_format."') as date_formatted,
				count(bannerid) as adviews
			FROM
				".$phpAds_config['tbl_adviews']."
			WHERE
				zoneid = '".$zoneid."'
			GROUP BY
				date, date_formatted
			ORDER BY
				date
		";
		
		$res_banners = phpAds_dbQuery($res_query) or phpAds_sqlDie();
		
		while ($row_banners = phpAds_dbFetchArray($res_banners))
		{
			$stats [$row_banners['date_formatted']]['views'] = $row_banners['adviews'];
			$stats [$row_banners['date_formatted']]['clicks'] = 0;
		}
		
		$res_query = "
			SELECT
				DATE_FORMAT(t_stamp, '%Y%m%d') as date,
				DATE_FORMAT(t_stamp, '".$date_format."') as date_formatted,
				count(bannerid) as adclicks
			FROM
				".$phpAds_config['tbl_adclicks']."
			WHERE
				zoneid = '".$zoneid."'
			GROUP BY
				date, date_formatted
			ORDER BY
				date
		";
		
		$res_banners = phpAds_dbQuery($res_query) or phpAds_sqlDie();
		
		while ($row_banners = phpAds_dbFetchArray($res_banners))
		{
			$stats [$row_banners['date_formatted']]['clicks'] = $row_banners['adclicks'];
		}
	}
	
	echo $quotes.$strZone.": ".strip_tags(phpAds_getZoneName ($zoneid)).$quotes."\n\n";
	echo $quotes.$strDay.$quotes.$delimiter.$quotes.$strViews.$quotes;
	echo $delimiter.$quotes.$strClicks.$quotes.$delimiter.$quotes.$strCTRShort.$quotes."\n";
	
	$totalclicks = 0;
	$totalviews = 0;
	
	if (isset($stats) && is_array($stats))
	{
		for (reset($stats);$key=key($stats);next($stats))
		{
			$row = array();
			
			$row[] = $quotes.$key.$quotes;
			$row[] = $quotes.$stats[$key]['views'].$quotes;
			$row[] = $quotes.$stats[$key]['clicks'].$quotes;
			$row[] = $quotes.phpAds_buildCTR ($stats[$key]['views'], $stats[$key]['clicks']).$quotes;
			
			echo implode ($delimiter, $row)."\n";
			
			$totalclicks += $stats[$key]['clicks'];
			$totalviews += $stats[$key]['views'];
		}
	}
	
	echo "\n";
	echo $quotes.$strTotal.$quotes.$delimiter.$quotes.$totalviews.$quotes.$delimiter;
	echo $quotes.$totalclicks.$quotes.$delimiter.$quotes.phpAds_buildCTR ($totalviews, $totalclicks).$quotes."\n";
}

?>