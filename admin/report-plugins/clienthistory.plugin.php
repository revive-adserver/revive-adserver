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


// Public name of the plugin info function
$plugin_info_function		= "Plugin_ClienthistoryInfo";


// Public info function
function Plugin_ClienthistoryInfo()
{
	global $strClientHistory, $strClient;
	
	$plugininfo = array (
		"plugin-name"			=> $strClientHistory,
		"plugin-description"	=> $strPluginClient,
		"plugin-author"			=> "Niels Leenheer",
		"plugin-export"			=> "csv",
		"plugin-authorize"		=> phpAds_Admin+phpAds_Client,
		"plugin-execute"		=> "Plugin_ClienthistoryExecute",
		"plugin-import"			=> array (
			"campaignid"			=> array (
				"title"					=> $strClient,
				"type"					=> "clientid-dropdown" ),
			"delimiter"		=> array (
				"title"					=> $strDelimiter,
				"type"					=> "edit",
				"size"					=> 1,
				"default"				=> "," ) )
	);
	
	return ($plugininfo);
}



/*********************************************************/
/* Private plugin function                               */
/*********************************************************/

function Plugin_ClienthistoryExecute($clientid, $delimiter=",")
{
	global $phpAds_config, $date_format;
	global $strClient, $strTotal, $strDay, $strViews, $strClicks, $strCTRShort;
	
	header ("Content-type: application/csv\nContent-Disposition: \"inline; filename=clienthistory.csv\"");
	
	$idresult = phpAds_dbQuery ("
		SELECT
			b.bannerid
		FROM
			".$phpAds_config['tbl_banners']." AS b,
			".$phpAds_config['tbl_clients']." AS c
		WHERE
			c.parent = ".$clientid." AND
			c.clientid = b.clientid
	");
	
	while ($row = phpAds_dbFetchArray($idresult))
	{
		$bannerids[] = "bannerid = ".$row['bannerid'];
	}
	
	
	if ($phpAds_config['compact_stats'])
	{
		$res_query = "
			SELECT
				DATE_FORMAT(day, '".$date_format."') as day,
				SUM(views) AS adviews,
				SUM(clicks) AS adclicks
			FROM
				".$phpAds_config['tbl_adstats']."
			WHERE
				(".implode(' OR ', $bannerids).")
			GROUP BY
				day
		";
		
		$res_banners = phpAds_dbQuery($res_query) or phpAds_sqlDie();
		
		while ($row_banners = phpAds_dbFetchArray($res_banners))
		{
			$stats [$row_banners['day']]['views'] = $row_banners['adviews'];
			$stats [$row_banners['day']]['clicks'] = $row_banners['adclicks'];
		}
	}
	else
	{
		$res_query = "
			SELECT
				DATE_FORMAT(t_stamp, '".$date_format."') as day,
				count(bannerid) as adviews
			FROM
				".$phpAds_config['tbl_adviews']."
			WHERE
				(".implode(' OR ', $bannerids).")
			GROUP BY
				day
		";
		
		$res_banners = phpAds_dbQuery($res_query) or phpAds_sqlDie();
		
		while ($row_banners = phpAds_dbFetchArray($res_banners))
		{
			$stats [$row_banners['day']]['views'] = $row_banners['adviews'];
			$stats [$row_banners['day']]['clicks'] = 0;
		}
		
		$res_query = "
			SELECT
				DATE_FORMAT(t_stamp, '".$date_format."') as day,
				count(bannerid) as adclicks
			FROM
				".$phpAds_config['tbl_adclicks']."
			WHERE
				(".implode(' OR ', $bannerids).")
			GROUP BY
				day
		";
		
		$res_banners = phpAds_dbQuery($res_query) or phpAds_sqlDie();
		
		while ($row_banners = phpAds_dbFetchArray($res_banners))
		{
			$stats [$row_banners['day']]['clicks'] = $row_banners['adclicks'];
		}
	}
	
	echo $strClient.": ".phpAds_getClientName ($clientid)."\n\n";
	echo $strDay.$delimiter.$strViews.$delimiter.$strClicks.$delimiter.$strCTRShort."\n";
	
	$totalclicks = 0;
	$totalviews = 0;
	
	if (isset($stats) && is_array($stats))
	{
		for (reset($stats);$key=key($stats);next($stats))
		{
			$row = array();
			
			$row[] = $key;
			$row[] = $stats[$key]['views'];
			$row[] = $stats[$key]['clicks'];
			$row[] = phpAds_buildCTR ($stats[$key]['views'], $stats[$key]['clicks']);
			
			echo implode ($delimiter, $row)."\n";
			
			$totalclicks += $stats[$key]['clicks'];
			$totalviews += $stats[$key]['views'];
		}
	}
	
	echo "\n";
	echo $strTotal.$delimiter.$totalviews.$delimiter.$totalclicks.$delimiter.phpAds_buildCTR ($totalviews, $totalclicks)."\n";
}

?>