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
$plugin_info_function		= "Plugin_CampaignhistoryInfo";


// Public info function
function Plugin_CampaignhistoryInfo()
{
	global $strCampaignHistory, $strCampaign, $strPluginCampaign, $strDelimiter, $strUseQuotes;
	
	$plugininfo = array (
		"plugin-name"			=> $strCampaignHistory,
		"plugin-description"	=> $strPluginCampaign,
		"plugin-author"			=> "Niels Leenheer",
		"plugin-export"			=> "csv",
		"plugin-authorize"		=> phpAds_Admin+phpAds_Client,
		"plugin-execute"		=> "Plugin_CampaignhistoryExecute",
		"plugin-import"			=> array (
			"campaignid"			=> array (
				"title"					=> $strCampaign,
				"type"					=> "campaignid-dropdown" ),
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

function Plugin_CampaignhistoryExecute($campaignid, $delimiter="t", $quotes="")
{
	global $phpAds_config, $date_format;
	global $strCampaign, $strTotal, $strDay, $strViews, $strClicks, $strCTRShort;
	
	// Expand delimiter and quotes
	if ($delimiter == 't')	$delimiter = "\t";
	if ($quotes == '1')		$quotes = "'";
	if ($quotes == '2')		$quotes = '"';
	
	header ("Content-type: application/csv\nContent-Disposition: \"inline; filename=campaignhistory.csv\"");
	
	$idresult = phpAds_dbQuery ("
		SELECT
			bannerid
		FROM
			".$phpAds_config['tbl_banners']."
		WHERE
			clientid = '".$campaignid."'
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
	
	echo $quotes.$strCampaign.": ".strip_tags(phpAds_getClientName ($campaignid)).$quotes."\n\n";
	echo $quotes.$strDay.$quotes.$delimiter.$quotes.$strViews.$quotes.$delimiter;
	echo $quotes.$strClicks.$quotes.$delimiter.$quotes.$strCTRShort.$quotes."\n";
	
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