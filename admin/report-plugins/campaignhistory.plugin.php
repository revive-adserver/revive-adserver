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
			"campaignid"			=> array (
				"title"					=> "Campaign",
				"type"					=> "campaignid-dropdown" ),
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

function Plugin_CampaignhistoryExecute($campaignid, $delimiter=",")
{
	global $phpAds_config;
	
	header ("Content-type: application/csv\nContent-Disposition: \"inline; filename=campaignhistory.csv\"");
	
	if ($phpAds_config['compact_stats'])
	{
		$res_query = "
			SELECT
				".$phpAds_config['tbl_adstats'].".day AS day,
				SUM(".$phpAds_config['tbl_adstats'].".views) AS adviews,
				SUM(".$phpAds_config['tbl_adstats'].".clicks) AS adclicks
			FROM
				".$phpAds_config['tbl_banners']."
				LEFT JOIN ".$phpAds_config['tbl_adstats']." USING (bannerid)
			WHERE
				".$phpAds_config['tbl_banners'].".clientid = $campaignid
			GROUP BY
				".$phpAds_config['tbl_adstats'].".day
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
				DATE_FORMAT(".$phpAds_config['tbl_adviews'].".t_stamp, '%Y-%m-%d') as day,
				count(".$phpAds_config['tbl_adviews'].".bannerid) as adviews
			FROM
				".$phpAds_config['tbl_banners']."
				LEFT JOIN ".$phpAds_config['tbl_adviews']." USING (bannerid)
			WHERE
				".$phpAds_config['tbl_banners'].".clientid = $campaignid
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
				DATE_FORMAT(".$phpAds_config['tbl_adclicks'].".t_stamp, '%Y-%m-%d') as day,
				count(".$phpAds_config['tbl_adclicks'].".bannerid) as adclicks
			FROM
				".$phpAds_config['tbl_banners']."
				LEFT JOIN ".$phpAds_config['tbl_adclicks']." USING (bannerid)
			WHERE
				".$phpAds_config['tbl_banners'].".clientid = $campaignid
			GROUP BY
				day
			";
		
		$res_banners = phpAds_dbQuery($res_query) or phpAds_sqlDie();
		
		while ($row_banners = phpAds_dbFetchArray($res_banners))
		{
			$stats [$row_banners['day']]['clicks'] = $row_banners['adclicks'];
		}
	}
	
	echo "Campaign: ".phpAds_getClientName ($campaignid)."\n\n";
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