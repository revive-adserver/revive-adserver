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
$plugin_info_function		= "Plugin_CampaignoverviewInfo";


// Public info function
function Plugin_CampaignoverviewInfo()
{
	$plugininfo = array (
		"plugin-name"			=> "Campaign Overview",
		"plugin-description"	=> "Generate an overview of the selected campaign.
									The report is exported as CSV for use in a spreadsheet.",
		"plugin-author"			=> "Niels Leenheer",
		"plugin-export"			=> "csv",
		"plugin-authorize"		=> phpAds_Admin+phpAds_Client,
		"plugin-execute"		=> "Plugin_CampaignoverviewExecute",
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

function Plugin_CampaignoverviewExecute($campaignid, $delimiter=",")
{
	global $phpAds_config;
	
	header ("Content-type: application/csv\nContent-Disposition: \"inline; filename=campaignoverview.csv\"");
	
	if ($phpAds_config['compact_stats'])
	{
		$res_query = "
			SELECT
				".$phpAds_config['tbl_banners'].".bannerid as bannerid,
				".$phpAds_config['tbl_banners'].".description as description, 
				".$phpAds_config['tbl_banners'].".alt as alt,
				sum(".$phpAds_config['tbl_adstats'].".views) as adviews,
				sum(".$phpAds_config['tbl_adstats'].".clicks) as adclicks
			FROM
				".$phpAds_config['tbl_banners']."
				LEFT JOIN ".$phpAds_config['tbl_adstats']." USING (bannerid)
			WHERE
				".$phpAds_config['tbl_banners'].".clientid = $campaignid
			GROUP BY
				".$phpAds_config['tbl_banners'].".bannerid
			";
		
		$res_banners = phpAds_dbQuery($res_query) or phpAds_sqlDie();
		
		while ($row_banners = phpAds_dbFetchArray($res_banners))
		{
			$stats [$row_banners['bannerid']]['views'] = $row_banners['adviews'];
			$stats [$row_banners['bannerid']]['clicks'] = $row_banners['adclicks'];
			$stats [$row_banners['bannerid']]['description'] = $row_banners['description'];
			$stats [$row_banners['bannerid']]['alt'] = $row_banners['alt'];
		}
	}
	else
	{
		$res_query = "
			SELECT
				".$phpAds_config['tbl_banners'].".bannerid as bannerid,
				".$phpAds_config['tbl_banners'].".description as description, 
				".$phpAds_config['tbl_banners'].".alt as alt,
				count(".$phpAds_config['tbl_adviews'].".bannerid) as adviews
			FROM
				".$phpAds_config['tbl_banners']."
				LEFT JOIN ".$phpAds_config['tbl_adviews']." USING (bannerid)
			WHERE
				".$phpAds_config['tbl_banners'].".clientid = $campaignid
			GROUP BY
				".$phpAds_config['tbl_banners'].".bannerid
			";
		
		$res_banners = phpAds_dbQuery($res_query) or phpAds_sqlDie();
		
		while ($row_banners = phpAds_dbFetchArray($res_banners))
		{
			$stats [$row_banners['bannerid']]['views'] = $row_banners['adviews'];
			$stats [$row_banners['bannerid']]['description'] = $row_banners['description'];
			$stats [$row_banners['bannerid']]['alt'] = $row_banners['alt'];
		}
		
		$res_query = "
			SELECT
				".$phpAds_config['tbl_banners'].".bannerid as bannerid,
				".$phpAds_config['tbl_banners'].".description as description, 
				".$phpAds_config['tbl_banners'].".alt as alt,
				count(".$phpAds_config['tbl_adclicks'].".bannerid) as adclicks
			FROM
				".$phpAds_config['tbl_banners']."
				LEFT JOIN ".$phpAds_config['tbl_adclicks']." USING (bannerid)
			WHERE
				".$phpAds_config['tbl_banners'].".clientid = $campaignid
			GROUP BY
				".$phpAds_config['tbl_banners'].".bannerid
			";
		
		$res_banners = phpAds_dbQuery($res_query) or phpAds_sqlDie();
		
		while ($row_banners = phpAds_dbFetchArray($res_banners))
		{
			$stats [$row_banners['bannerid']]['clicks'] = $row_banners['adclicks'];
			$stats [$row_banners['bannerid']]['description'] = $row_banners['description'];
			$stats [$row_banners['bannerid']]['alt'] = $row_banners['alt'];
		}
	}
	
	echo "Campaign: ".phpAds_getClientName ($campaignid)."\n\n";
	echo "Banner".$delimiter."AdViews".$delimiter."AdClicks".$delimiter."CTR\n";
	
	$totalclicks = 0;
	$totalviews = 0;
	
	if (isset($stats) && is_array($stats))
	{
		for (reset($stats);$key=key($stats);next($stats))
		{
			$row = array();
			
			$row[] = phpAds_buildBannerName ($key, $stats[$key]['description'], $stats[$key]['alt']);
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