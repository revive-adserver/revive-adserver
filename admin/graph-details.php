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



// Include required files
require ("config.php");



/*********************************************************/
/* Prepare data for graph                                */
/*********************************************************/

if (isset ($GLOBALS['phpAds_CharSet']) && $GLOBALS['phpAds_CharSet'] != '')
	$text=array(
	    'value1' => 'AdViews',
	    'value2' => 'AdClicks');
else
	$text=array(
	    'value1' => $GLOBALS['strViews'],
	    'value2' => $GLOBALS['strClicks']);

$stats = array();


if ($phpAds_config['compact_stats']) 
{
	$result = phpAds_dbQuery("
		SELECT
			day,
			SUM(views) AS sum_views,
			SUM(clicks) AS sum_clicks,
			DATE_FORMAT(day, '$date_format') AS t_stamp_f
		FROM
			".$phpAds_config['tbl_adstats']."
		WHERE
			bannerid = $bannerid
		GROUP BY
			day
		ORDER BY
			day DESC
		LIMIT $limit 
	");
    
    $num2 = phpAds_dbNumRows($result);
	
    while ($row = phpAds_dbFetchArray($result))
    {
		$stats[$row['day']] = $row;
    }
}
else
{
	$result = phpAds_dbQuery("
		SELECT
			COUNT(*) AS sum_views,
			DATE_FORMAT(t_stamp, '$date_format') AS t_stamp_f,
			DATE_FORMAT(t_stamp, '%Y-%m-%d') AS day
		FROM
			".$phpAds_config['tbl_adviews']."
		WHERE
			bannerid = $bannerid
		GROUP BY
		    day
		ORDER BY
			day DESC
		LIMIT $limit 
	");
	
	while ($row = phpAds_dbFetchArray($result))
	{
		$stats[$row['day']]['sum_views'] = $row['sum_views'];
		$stats[$row['day']]['sum_clicks'] = '0';
		$stats[$row['day']]['t_stamp_f'] = $row['t_stamp_f'];
	}
	
	
	$result = phpAds_dbQuery("
		SELECT
			COUNT(*) AS sum_clicks,
			DATE_FORMAT(t_stamp, '$date_format') AS t_stamp_f,
			DATE_FORMAT(t_stamp, '%Y-%m-%d') AS day
		FROM
			".$phpAds_config['tbl_adclicks']."
		WHERE
			bannerid = $bannerid
		GROUP BY
		    day
		ORDER BY
			day DESC
		LIMIT $limit 
	");
	
	while ($row = phpAds_dbFetchArray($result))
	{
		$stats[$row['day']]['sum_clicks'] = $row['sum_clicks'];
		$stats[$row['day']]['t_stamp_f'] = $row['t_stamp_f'];
	}
}

$items = array();
$today = time();

for ($d=0;$d<$limit;$d++)
{
	$key = date ("Y-m-d", $today - ((60 * 60 * 24) * $d));
	
	if (isset($stats[$key]))
	{
		$items[$d]['value1'] = $stats[$key]['sum_views'];
		$items[$d]['value2'] = $stats[$key]['sum_clicks'];
		$items[$d]['text']   = $stats[$key]['t_stamp_f'];
	}
	else
	{
		$items[$d]['value1'] = 0;
		$items[$d]['value2'] = 0;
		$items[$d]['text']   = "";
	}
}


// Build the graph
include('lib-graph.inc.php');

?>
 
