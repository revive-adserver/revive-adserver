<?php // $Revision$

/************************************************************************/
/* phpAdsNew 2 - Campaign Overview Plugin 1.0                           */
/* ==========================================                           */
/*                                                                      */
/* Copyright (c) 2001 by Niels Leenheer <niels@creatype.nl>             */
/* http://sourceforge.net/projects/phpadsnew                            */
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
	$plugininfo = array (
		"plugin-name"			=> "Campaign History",
		"plugin-description"	=> "Generate an overview of the history of the selected campaign.
									The report is exported as CSV for use in a spreadsheet.",
		"plugin-author"			=> "Niels Leenheer",
		"plugin-export"			=> "csv",
		"plugin-authorize"		=> phpAds_Admin+phpAds_Client,
		"plugin-execute"		=> "Plugin_CampaignhistoryExecute",
		"plugin-import"			=> array (
			"campaignID"			=> array (
				"title"					=> "Campaign",
				"type"					=> "campaignID-dropdown" ),
			"delimiter"		=> array (
				"title"					=> "Delimiter",
				"type"					=> "edit",
				"size"					=> 1,
				"default"				=> "," ) )
	);
	
	return ($plugininfo);
}



/*********************************************************/
/* Private plugin function                               */
/*********************************************************/

function Plugin_CampaignhistoryExecute($campaignID, $delimiter=",")
{
	global $phpAds_tbl_banners, $phpAds_tbl_adstats, $phpAds_tbl_adviews, $phpAds_tbl_adclicks;
	global $phpAds_compact_stats;
	
	header ("Content-type: application/csv\nContent-Disposition: \"inline; filename=campaignhistory.csv\"");
	
	if ($phpAds_compact_stats)
	{
		$res_query = "
			SELECT
				$phpAds_tbl_adstats.day as day,
				sum($phpAds_tbl_adstats.views) as adviews,
				sum($phpAds_tbl_adstats.clicks) as adclicks
			FROM
				$phpAds_tbl_banners
				LEFT JOIN $phpAds_tbl_adstats USING (bannerID)
			WHERE
				$phpAds_tbl_banners.clientID = $campaignID
			GROUP BY
				$phpAds_tbl_adstats.day
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
				DATE_FORMAT($phpAds_tbl_adviews.t_stamp, '%Y-%m-%d') as day,
				count($phpAds_tbl_adviews.bannerID) as adviews
			FROM
				$phpAds_tbl_banners
				LEFT JOIN $phpAds_tbl_adviews USING (bannerID)
			WHERE
				$phpAds_tbl_banners.clientID = $campaignID
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
				DATE_FORMAT($phpAds_tbl_adclicks.t_stamp, '%Y-%m-%d') as day,
				count($phpAds_tbl_adclicks.bannerID) as adclicks
			FROM
				$phpAds_tbl_banners
				LEFT JOIN $phpAds_tbl_adclicks USING (bannerID)
			WHERE
				$phpAds_tbl_banners.clientID = $campaignID
			GROUP BY
				day
			";
		
		$res_banners = phpAds_dbQuery($res_query) or phpAds_sqlDie();
		
		while ($row_banners = phpAds_dbFetchArray($res_banners))
		{
			$stats [$row_banners['day']]['clicks'] = $row_banners['adclicks'];
		}
	}
	
	echo "Campaign: ".phpAds_getClientName ($campaignID)."\n\n";
	echo "Day".$delimiter."AdViews".$delimiter."AdClicks".$delimiter."CTR\n";
	
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
	echo "Total".$delimiter.$totalviews.$delimiter.$totalclicks.$delimiter.phpAds_buildCTR ($totalviews, $totalclicks)."\n";
}

?>