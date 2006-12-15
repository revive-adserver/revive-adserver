<?php

/*----------------------------------------------------------------------*/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2001 by TOMO <groove@spencernetwork.org>               */
/* For more information visit: http://www.phpadsnew.com                 */
/*----------------------------------------------------------------------*/

function phpAds_getSourceStatsByCampaignID($campaignid, $listorder='source', $orderdirection='up')
{
	// Get the adviews/clicks for each campaign
	$res_stats = phpAds_dbQuery(
		"SELECT".
		" source".
		",SUM(impressions) AS views".
		",SUM(clicks) AS clicks".
		",SUM(conversions) AS conversions".
		",IF(SUM(impressions) > 0, SUM(clicks)/SUM(impressions)*100, 0.00) AS ctr".
		",IF(SUM(clicks) > 0, SUM(conversions)/SUM(clicks)*100, 0.00) AS cnvr".
		" FROM ".$conf['table']['prefix'].$conf['table']['data_summary_ad_hourly']." AS s".
		",".$conf['table']['prefix'].$conf['table']['banners']." AS b".
		" WHERE b.bannerid=s.ad_id".
		" AND b.campaignid='".$campaignid."'".
		" GROUP BY source"
	) or phpAds_sqlDie();
	
	return getSourceStats($listorder, $orderdirection);
}

function phpAds_getSourceStats($query, $listorder, $orderdirection)
{
	$res_stats = phpAds_dbQuery($query)
		or phpAds_sqlDie();
	
	while ($row_stats = phpAds_dbFetchArray($res_stats))
	{
		$source = $row_stats['source'];
		if (strlen($source) > 0)
		{
			$sources = phpAds_buildSourceArray($sources, $source, '', $row_stats);
		}
	}
	// Sort the array
	$ascending = !( ($orderdirection == 'down') || ($orderdirection == '') );
	
	phpAds_qsort($sources, $listorder, $ascending);
}

function phpAds_buildSourceArray($sources, $source, $path, $row_stats)
{
	// Set the master array if there is not already one.
	if (!isset($sources) || !is_array($sources) )
		$sources = array();

	// First, get the name of this branch of the source.
	$len = strpos($source, '/');
	if ($len > -1)
	{
		$name = substr($source, 0, $len);
	}
	else
	{
		$name = $source;
	}
	
	// Next, see if there is already a branch present in the sources array
	$index = -1;
	for ($i=0; $i<sizeof($sources); $i++)
	{
		if ($sources[$i]['source'] == $name)
		{
			$index = $i;
			break;
		}
	}
	
	// If this branch is not present, add the default information
	if ($index == -1)
	{
		$source_arr['source'] = $name;
		if (strlen($path) > 0)
			$source_arr['path'] = $path.'/'.$source_arr['source'];
		else
			$source_arr['path'] = $source_arr['source'];

		$source_arr['clicks'] = 0;
		$source_arr['conversions'] = 0;
		$source_arr['views'] = 0;
		$source_arr['ctr'] = 0.00;
		$source_arr['cnvr'] = 0.00;
		$source_arr['children'] = array();
	}
	// ...Otherwise, grab this specific branch of the source array
	else 
	{
		$source_arr = $sources[$index];
	}
	
	// Increment the stats for this branch
	$source_arr['views'] += $row_stats['views'];
	$source_arr['clicks'] += $row_stats['clicks'];
	$source_arr['conversions'] += $row_stats['conversions'];
	$source_arr['ctr'] += $row_stats['ctr'];
	$source_arr['cnvr'] += $row_stats['cnvr'];

	// If there are children, recursively populate the children array
	if ($len > -1)
	{
		$source_arr['children'] = phpAds_buildSourceArray($source_arr['children'], substr($source, $len+1), $source_arr['path'], $row_stats);
	}
	
	if ($index == -1)
	{
		$sources[] = $source_arr;
	}
	else 
	{
		$sources[$index] = $source_arr;
	}
	
	return $sources;
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