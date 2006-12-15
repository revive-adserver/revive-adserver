<?php

/*----------------------------------------------------------------------*/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2001 by TOMO <groove@spencernetwork.org>               */
/* For more information visit: http://www.phpadsnew.com                 */
/*----------------------------------------------------------------------*/

function phpAds_getStatsByCampaignID($campaignid, $name='')
{
	$conf = $GLOBALS['_MAX']['CONF'];
	
	$query =
		"SELECT".
		" SUM(impressions) AS views".
		",SUM(clicks) AS clicks".
		",SUM(conversions) AS conversions".
		",FORMAT(SUM(clicks)/SUM(impressions),6) AS ctr".
		",FORMAT(SUM(conversions)/SUM(clicks),6) AS cnvr".
		" FROM ".$conf['table']['prefix'].$conf['table']['data_summary_ad_hourly']." AS s".
		",".$conf['table']['prefix'].$conf['table']['banners']." AS b".
		" WHERE b.bannerid=s.ad_id".
		" AND b.campaignid='".$campaignid."'"
	;
	
	return phpAds_getStats($query, $name);
}

function phpAds_getStats($query, $name)
{
	$stats = array();
	
	$res_stats = phpAds_dbQuery($query)
		or phpAds_sqlDie();
	
	if ($row_stats = phpAds_dbFetchArray($res_stats))
	{
		$stats = $row_stats;
		$stats['name'] = $name;
		$stats['path'] = $name;
	}
	
	return $stats;
}

function phpAds_getBannerStatsByCampaignID($campaignid, $name='', $listorder='name', $orderdirection='up', $omit_arr = null, $path = '')
{
	$conf = $GLOBALS['_MAX']['CONF'];

	$query =
		"SELECT".
		" b.bannerid AS bannerid".
		",b.description AS description".
		",b.alt AS alt".
		",SUM(impressions) AS views".
		",SUM(clicks) AS clicks".
		",SUM(conversions) AS conversions".
		",FORMAT(SUM(clicks)/SUM(impressions),6) AS ctr".
		",FORMAT(SUM(conversions)/SUM(clicks),6) AS cnvr".
		" FROM ".$conf['table']['prefix'].$conf['table']['data_summary_ad_hourly']." AS s".
		",".$conf['table']['prefix'].$conf['table']['banners']." AS b".
		" WHERE b.bannerid=s.ad_id".
		" AND b.campaignid='".$campaignid."'".
		" GROUP BY bannerid".
		phpAds_getBannerListOrder($listorder, $orderdirection)
	;
	
	return phpAds_getBannerStats($query, $name, $omit_arr);
}

function phpAds_getBannerStats($query, $name='', $omit_arr = null)
{
	if (!isset($omit_arr) || !is_array($omit_arr) )
		$omit_arr = array();
	
	$banner_stats = array();
	$banner_stats['name'] = $name;
	$banner_stats['path'] = $name;
	$banner_stats['views'] = 0;
	$banner_stats['clicks'] = 0;
	$banner_stats['conversions'] = 0;
	
	$res_banner_stats = phpAds_dbQuery($query)
		or phpAds_sqlDie();
	
	while ($row_banner_stats = phpAds_dbFetchArray($res_banner_stats))
	{
		$banner_stats['children'][] = $row_banner_stats;
		$index = sizeof($banner_stats['children']) - 1;
		$banner_stats['children'][$index]['name'] = phpAds_buildBannerName($row_banner_stats['bannerid'], $row_banner_stats['description'], $row_banner_stats['alt'], null, false);
		$banner_stats['children'][$index]['path'] = $name . '/' . $banner_stats['children'][$index]['name'];
		
		if (!in_array($banner_stats['children'][$index]['path'], $omit_arr))
		{
			$banner_stats['clicks'] += $row_banner_stats['clicks'];
			$banner_stats['conversions'] += $row_banner_stats['conversions'];
			$banner_stats['views'] += $row_banner_stats['views'];
			$banner_stats['id'][] = $row_banner_stats['bannerid'];
		}
	}
	
	$banner_stats['ctr'] += phpAds_buildRatio($banner_stats['clicks'], $banner_stats['views']);
	$banner_stats['cnvr'] += phpAds_buildRatio($banner_stats['conversions'], $banner_stats['clicks']);
	
	return $banner_stats;
}

function phpAds_getHourStatsByCampaignIDBannerIDs($campaignid, $bannerids, $name = '', $listorder='name', $orderdirection='up', $omit_arr = null)
{
	$conf = $GLOBALS['_MAX']['CONF'];

	$banner_sql = '';
	if ( (isset($bannerids)) && (is_array($bannerids)))
	{
		for ($i=0; $i<sizeof($bannerids); $i++)
		{
			if ($i == 0)
				$banner_sql .= " WHERE (bannerid=".$bannerids[$i];
			else
				$banner_sql .= " OR bannerid=".$bannerids[$i];
		}
		if (strlen($bannerids) > 0)
			$banner_sql .= ")";
	}
	
	$query =
		"SELECT".
		" hour".
		",SUM(impressions) AS views".
		",SUM(clicks) AS clicks".
		",SUM(conversions) AS conversions".
		",FORMAT(SUM(clicks)/SUM(impressions),6) AS ctr".
		",FORMAT(SUM(conversions)/SUM(clicks),6) AS cnvr".
		" FROM ".$conf['table']['prefix'].$conf['table']['data_summary_ad_hourly'].
		$banner_sql.
		" GROUP BY hour".
		phpAds_getHourListOrder($listorder, $orderdirection)
	;
	
	return phpAds_getHourStats($query, $name, $omit_arr);
}

function phpAds_getHourStats($query, $name = '', $omit_arr = null)
{
	if (!isset($omit_arr) || !is_array($omit_arr) )
		$omit_arr = array();
	
	$hour_stats = array();
	$hour_stats['name'] = $name;
	$hour_stats['path'] = $name;
	$hour_stats['views'] = 0;
	$hour_stats['clicks'] = 0;
	$hour_stats['conversions'] = 0;
	
	$res_hour_stats = phpAds_dbQuery($query)
		or phpAds_sqlDie();
	
	while ($row_hour_stats = phpAds_dbFetchArray($res_hour_stats))
	{
		$hour_stats['children'][] = $row_hour_stats;
		$index = sizeof($hour_stats['children']) - 1;
		$hour_stats['children'][$index]['name'] = $row_hour_stats['hour'];
		$hour_stats['children'][$index]['path'] = $name . '/' . $hour_stats['children'][$index]['name'];
		
		if (!in_array($hour_stats['children'][$index]['path'], $omit_arr))
		{
			$hour_stats['clicks'] += $row_hour_stats['clicks'];
			$hour_stats['conversions'] += $row_hour_stats['conversions'];
			$hour_stats['views'] += $row_hour_stats['views'];
			$hour_stats['id'][] = $row_hour_stats['hour'];
		}
	}
	
	$hour_stats['ctr'] += phpAds_buildRatio($hour_stats['clicks'], $hour_stats['views']);
	$hour_stats['cnvr'] += phpAds_buildRatio($hour_stats['conversions'], $hour_stats['clicks']);
	
	return $hour_stats;
}

function phpAds_getSourceStatsByCampaignIDBannerIDsHours($campaignid, $bannerids, $hours, $name='', $listorder='name', $orderdirection='up', $omit_arr = null)
{
	$conf = $GLOBALS['_MAX']['CONF'];

	$banner_sql = '';
	if ( (isset($bannerids)) && (is_array($bannerids)))
	{
		for ($i=0; $i<sizeof($bannerids); $i++)
		{
			if ($i == 0)
				$banner_sql .= " WHERE (bannerid=".$bannerids[$i];
			else
				$banner_sql .= " OR bannerid=".$bannerids[$i];
		}
		if (strlen($bannerids) > 0)
			$banner_sql .= ")";
	}
	
	$hour_sql = '';
	if ( (isset($hours)) && (is_array($hours)))
	{
		for ($i=0; $i<sizeof($hours); $i++)
		{
			if ($i == 0)
				$hour_sql .= " AND (hour=".$hours[$i];
			else
				$hour_sql .= " OR hour=".$hours[$i];
		}
		if (strlen($hours) > 0)
			$hour_sql .= ")";
	}
	
	$query =
		"SELECT ".
		"SUM(impressions) AS views".
		",SUM(clicks) AS clicks".
		",SUM(conversions) AS conversions".
		" FROM ".$conf['table']['prefix'].$conf['table']['data_summary_ad_hourly'].
		$banner_sql.
		$hour_sql;
	
	$sources = phpAds_getSourceStats($query, $name, $omit_arr);

	// Sort the array
	$ascending = !( ($orderdirection == 'down') || ($orderdirection == '') );
	phpAds_sortSources($sources, $listorder, $ascending);
	
	return $sources;
}

function phpAds_getSourceStats($query, $name='', $omit_arr=null)
{
	if (!isset($omit_arr) || !is_array($omit_arr) )
		$omit_arr = array();
	
	$source_stats = array();
	$source_stats['name'] = $name;
	$source_stats['path'] = $name;
	$source_stats['views'] = 0;
	$source_stats['clicks'] = 0;
	$source_stats['conversions'] = 0;
	
	$res_source_stats = phpAds_dbQuery($query)
		or phpAds_sqlDie();
	
	while ($row_source_stats = phpAds_dbFetchArray($res_source_stats))
	{
		phpAds_buildSourceArrayChildren($source_stats, $row_source_stats['source'], $row_source_stats);
		//$hour_stats['children'][] = $row_hour_stats;
		//$index = sizeof($hour_stats['children']) - 1;
		//$hour_stats['children'][$index]['name'] = $row_hour_stats['hour'];
		
		if (!in_array($name.'/'.$row_source_stats['source'], $omit_arr))
		{
			$source_stats['clicks'] += $row_source_stats['clicks'];
			$source_stats['conversions'] += $row_source_stats['conversions'];
			$source_stats['views'] += $row_source_stats['views'];
			$source_stats['id'][] = $row_source_stats['source'];
		}
	}
	
	$source_stats['ctr'] += phpAds_buildRatio($source_stats['clicks'], $source_stats['views']);
	$source_stats['cnvr'] += phpAds_buildRatio($source_stats['conversions'], $source_stats['clicks']);
	
	return $source_stats;
}

function phpAds_buildSourceArrayChildren(&$source_arr, $path, $row_source_stats)
{
	if (!isset($source_arr['children']) || !is_array($source_arr['children']))
		$source_arr['children'] = array();
	
	// First, get the name of this branch of the source.
	$len = strpos($path, '/');
	$name = (is_integer($len)) ? substr($path, 0, $len) : $path;
	$remainder = (is_integer($len)) ? substr($path, $len+1) : '';
		
	// Next, see if there is already a branch present in the sources array
	$index = false;
	for ($i=0; $i<sizeof($source_arr['children']); $i++)
	{
		if ($name == $source_arr['children'][$i]['name'])
		{
			$index = $i;
			break;
		}
	}
	if (!is_integer($index))
	{
		$tmp_source_arr['name'] = $name;
		$tmp_source_arr['path'] = (strlen($source_arr['path']) > 0) ? $source_arr['path'].'/'.$name : $name;
		$tmp_source_arr['clicks'] = 0;
		$tmp_source_arr['conversions'] = 0;
		$tmp_source_arr['views'] = 0;
		$tmp_source_arr['ctr'] = 0.00;
		$tmp_source_arr['cnvr'] = 0.00;
		if (is_integer($len))
			$tmp_source_arr['children'] = array();
		$source_arr['children'][] = $tmp_source_arr;
		$index = sizeof($source_arr['children']) - 1;
	}
	
	// Increment the stats for this branch
	$source_arr['children'][$index]['views'] += $row_source_stats['views'];
	$source_arr['children'][$index]['clicks'] += $row_source_stats['clicks'];
	$source_arr['children'][$index]['conversions'] += $row_source_stats['conversions'];
	$source_arr['children'][$index]['ctr'] = phpAds_buildRatio($source_arr['children'][$index]['clicks'], $source_arr['children'][$index]['views']);
	$source_arr['children'][$index]['cnvr'] = phpAds_buildRatio($source_arr['children'][$index]['conversions'], $source_arr['children'][$index]['clicks']);

	// If there are children, recursively populate the children array
	if (strlen($name) > 0)
	{
		phpAds_buildSourceArrayChildren($source_arr['children'][$index], $remainder, $row_source_stats);
	}
}

function phpAds_sortSources(&$sources, $column=0, $ascending=true)
{
	if (isset($sources['children']) && is_array($sources['children']))
	{
		if (sizeof($sources['children'] > 1))
			phpAds_qsort($sources['children'], $column, $ascending);

		for ($i=0; $i<sizeof($sources['children']); $i++)
		{
			phpAds_sortSources($sources['children'][$i], $column, $ascending);
		}
	}
}

function phpAds_sortArray(&$array, $column=0, $ascending=TRUE)
{
	
	for ($i=0; $i<sizeof($array); $i++)
		if (isset($array[$i]['children']) && is_array($array[$i]['children']))
			phpAds_sortArray($array[$i]['children'], $column, $ascending);
	
	phpAds_qsort($array, $column, $ascending);

}

function phpAds_qsort(&$array, $column=0, $ascending=true, $first=0, $last=0)
{
	if ($last == 0)
		$last = count($array) - 1;
	
	if ($last > $first)
	{
		$alpha = $first;
		$omega = $last;
		$mid = floor(($alpha+$omega)/2);
		$guess = $array[$mid][$column];
		
		while ($alpha <= $omega)
		{
			if ($ascending)
			{
				while ( ($array[$alpha][$column] < $guess) && ($alpha < $last) )
					$alpha++;
				while ( ($array[$omega][$column] > $guess) && ($omega > $first) )
					$omega--;
			}
			else
			{
				while ( ($array[$alpha][$column] > $guess) && ($alpha < $last) )
					$alpha++;
				while ( ($array[$omega][$column] < $guess) && ($omega > $first) )
					$omega--;
			}
			
			if ($alpha <= $omega)
			{
				$temp = $array[$alpha];
				$array[$alpha] = $array[$omega];
				$array[$omega] = $temp;

				$alpha++;
				$omega--;
			}
		}
		
		if ($first < $omega)
			phpAds_qsort($array, $column, $ascending, $first, $omega);
		if ($alpha < $last)
			phpAds_qsort($array, $column, $ascending, $alpha, $last);
	}
}

?>