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



// Include required files
require ("config.php");


// Register input variables
phpAds_registerGlobal ('period', 'start', 'limit');


/*********************************************************/
/* Prepare for selected period                           */
/*********************************************************/

if ($period == 'd')
{
	$formatted   = $date_format;
	$unformatted = "%d%m%Y";
	$returnlimit = $limit;
	
	$begin_timestamp = mktime(0, 0, 0, date('m'), date('d') - $limit + 1 - $start, date('Y'));
	$end_timestamp	 = mktime(0, 0, 0, date('m'), date('d') + 1 - $start, date('Y'));
}

if ($period == 'w')
{
	$formatted   = $date_format;
	$unformatted = "%d%m%Y";
	$returnlimit = $limit * 7;
	
	$shift = date('w') - ($phpAds_config['begin_of_week'] ? 1 - (date('w') == 0 ? 7 : 0) : 0);
	$begin_timestamp = mktime(0, 0, 0, date('m'), date('d') - $shift + 7 - (7 * ($limit + $start)), date('Y'));
	$end_timestamp   = mktime(0, 0, 0, date('m'), date('d') - $shift + 7 - (7 * $start), date('Y'));
}

if ($period == 'm')
{
	$formatted   = $month_format;
	$unformatted = "%m%Y";
	$returnlimit = $limit;
	
	$begin_timestamp = mktime(0, 0, 0, date('m') - $limit + 1 - $start, 1, date('Y'));
	$end_timestamp   = mktime(0, 0, 0, date('m') + 1 - $start, 1, date('Y'));
}



/*********************************************************/
/* Get statistics for selected period                    */
/*********************************************************/

$begin = date('Ymd', $begin_timestamp);
$end   = date('Ymd', $end_timestamp);
	
$result = phpAds_dbQuery("
	SELECT
		sum(views) AS sum_views,
		sum(target) AS sum_target,
		DATE_FORMAT(day, '".$formatted."') AS date,
		DATE_FORMAT(day, '".$unformatted."') AS date_u
	FROM
		".$phpAds_config['tbl_targetstats']."
	WHERE
		clientid > 0 AND
		day >= $begin AND day < $end
		".(isset($lib_targetstats_where) ? 'AND '.$lib_targetstats_where : '')."
	GROUP BY
		date, date_u
	ORDER BY
		date_u DESC
	LIMIT 
		$returnlimit
");
	
while ($row = phpAds_dbFetchArray($result))
{
	$stats[$row['date']]['sum_views'] = $row['sum_views'];
	$stats[$row['date']]['sum_target'] = $row['sum_target'];
}



/*********************************************************/
/* Get statistics for today                              */
/*********************************************************/

$clientids = array();

$result = phpAds_dbQuery("
	SELECT
		clientid
	FROM
		".$phpAds_config['tbl_clients']."
	WHERE
		parent > 0 AND
		target > 0
	");

while ($row = phpAds_dbFetchArray($result))
	$clientids[] = $row['clientid'];

if (count($clientids))
{
	$clientids = join(', ', $clientids);

	if ($phpAds_config['compact_stats']) 
	{
		// Get stats for selected period
		$day = date('Ymd');
		
		$result = phpAds_dbQuery("
			SELECT
				sum(views) AS sum_views,
				DATE_FORMAT(day, '".$formatted."') AS date
			FROM
				".$phpAds_config['tbl_adstats'].",
				".$phpAds_config['tbl_banners']."
			WHERE
				".$phpAds_config['tbl_adstats'].".bannerid = ".$phpAds_config['tbl_banners'].".bannerid AND
				day = $day AND
				clientid IN ($clientids)
				".(isset($lib_targetstats_where) ? 'AND '.$lib_targetstats_where : '')."
			GROUP BY
				date
		");

		while ($row = phpAds_dbFetchArray($result))
			$stats[$row['date']]['sum_views'] = $row['sum_views'];
	}
	else
	{
		// Get stats for selected period
		$begin = date('Ymd000000');
		$end   = date('Ymd235959');
		
		$result = phpAds_dbQuery("
			SELECT
				COUNT(*) AS sum_views,
				DATE_FORMAT(t_stamp, '".$formatted."') AS date
			FROM
				".$phpAds_config['tbl_adviews'].",
				".$phpAds_config['tbl_banners']."
			WHERE
				".$phpAds_config['tbl_adviews'].".bannerid = ".$phpAds_config['tbl_banners'].".bannerid AND
				t_stamp >= $begin AND t_stamp <= $end AND
				clientid IN ($clientids)
				".(isset($lib_targetstats_where) ? 'AND '.$lib_targetstats_where : '')."
			GROUP BY
				date
		") or phpAds_sqlDie();
		
		while ($row = phpAds_dbFetchArray($result))
			$stats[$row['date']]['sum_views'] = $row['sum_views'];
	}
}

/*********************************************************/
/* Prepare data for graph                                */
/*********************************************************/

if (isset ($GLOBALS['phpAds_CharSet']) && $GLOBALS['phpAds_CharSet'] != '')
	$text=array(
	    'value1' => 'Target',
	    'value2' => 'AdViews');
else
	$text=array(
	    'value1' => $GLOBALS['strTarget'],
	    'value2' => $GLOBALS['strViews']);

if ($period == 'd' || $period == 'm')
{
	for ($d=0;$d<$limit;$d++)
	{
		switch ($period)
		{
			case 'm':	$timestamp = mktime (0, 0, 0, date('m') - $d - $start, 1, date('Y'));
						break;
					
			case 'd':	$timestamp = mktime (0, 0, 0, date('m'), date('d') - $d - $start, date('Y'));
						break;
		}
		
		$key = strftime ($formatted, $timestamp);
		
		if (isset($stats[$key]))
		{
			$items[$d]['value1'] = isset($stats[$key]['sum_target']) ? $stats[$key]['sum_target'] : 0;
			$items[$d]['value2'] = isset($stats[$key]['sum_views']) ? $stats[$key]['sum_views'] : 0;
			$items[$d]['text']   = $key;
		}
		else
		{
			$items[$d]['value1'] = 0;
			$items[$d]['value2'] = 0;
			$items[$d]['text']   = $key;
		}
	}
}


if ($period == 'w')
{
	$days = 0;
	
	for ($d=0;$d<$limit;$d++)
	{
		$totalweekviews = 0;
		$totalweektarget = 0;
		
		$shift = date('w') - ($phpAds_config['begin_of_week'] ? 1 - (date('w') == 0 ? 7 : 0) : 0);
		$week_timestamp = mktime(0, 0, 0, date('m'), date('d') - $shift - (7 * ($d + $start)), date('Y'));
		$week_formatted = strftime("%V") != '' ? strftime ($weekiso_format, $week_timestamp + ($phpAds_config['begin_of_week'] ? 0 : (60*60*24))) : 
						  						 strftime ($week_format, $week_timestamp + ($phpAds_config['begin_of_week'] ? 0 : (60*60*24)));
		
		for ($i = 0; $i < 7; $i++)
		{
			$day_timestamp = $week_timestamp + ($i * (60 * 60 * 24));
			$key = strftime ($formatted, $week_timestamp + ($i * (60 * 60 * 24)));
			
			if (isset($stats[$key]))
			{
				$totalweekviews  += isset($stats[$key]['sum_views']) ? $stats[$key]['sum_views'] : 0;
				$totalweektarget += isset($stats[$key]['sum_target']) ? $stats[$key]['sum_target'] : 0;
				$days++;
			}
		}
		
		$items[$d]['value1'] = $totalweektarget;
		$items[$d]['value2'] = $totalweekviews;
		$items[$d]['text']   = $week_formatted;
	}
}


// Build the graph
define('LIB_GRAPH_SAME_SCALE', 1);
include('lib-graph.inc.php');

?>