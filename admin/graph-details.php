<?php // $Revision$

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2001 by Martin Braun <martin@braun.cc>                 */
/* http://sourceforge.net/projects/phpadsnew                            */
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



if ($phpAds_compact_stats) 
{
    // Get totals from compact stats
	$result = phpAds_dbQuery(
		"SELECT
			*,
			views,
			clicks,
			DATE_FORMAT(day, '$date_format') as t_stamp_f
		 FROM
			$phpAds_tbl_adstats
		 WHERE
			bannerID = $bannerID
		 ORDER BY
			day DESC
		 LIMIT $limit 
		");
    
    $stats = array();
    $num2 = phpAds_dbNumRows($result);
	
    $i=0;
    while ($row = phpAds_dbFetchArray($result))
    {
    	$stats[$row['day']]=array();
    	$stats[$row['day']]['views'] 	 = $row['views'];     	// views
    	$stats[$row['day']]['clicks'] 	 = $row['clicks'];      // clicks
    	$stats[$row['day']]['t_stamp_f'] = $row['t_stamp_f'];   // week sign
    	$i++;
    }
}
else
{
	$result = phpAds_dbQuery(" SELECT
							count(*) as views,
							DATE_FORMAT(t_stamp, '$date_format') as t_stamp_f,
							DATE_FORMAT(t_stamp, '%Y-%m-%d') as day
				 		 FROM
							$phpAds_tbl_adviews
						 WHERE
							bannerID = $bannerID
						 GROUP BY
						    day
						 ORDER BY
							day DESC
						 LIMIT $limit 
			  ");
	
	while ($row = phpAds_dbFetchArray($result))
	{
		$stats[$row['day']]['views'] = $row['views'];
		$stats[$row['day']]['clicks'] = '0';
		$stats[$row['day']]['t_stamp_f'] = $row['t_stamp_f'];
	}
	
	
	$result = phpAds_dbQuery(" SELECT
							count(*) as clicks,
							DATE_FORMAT(t_stamp, '$date_format') as t_stamp_f,
							DATE_FORMAT(t_stamp, '%Y-%m-%d') as day
				 		 FROM
							$phpAds_tbl_adclicks
						 WHERE
							bannerID = $bannerID
						 GROUP BY
						    day
						 ORDER BY
							day DESC
						 LIMIT $limit 
			  ");
	
	while ($row = phpAds_dbFetchArray($result))
	{
		$stats[$row['day']]['clicks'] = $row['clicks'];
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
		$items[$d]['value1'] = $stats[$key]['views'];
		$items[$d]['value2'] = $stats[$key]['clicks'];
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
 
