<?php // $Revision$

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2001 by the phpAdsNew developers                       */
/* http://sourceforge.net/projects/phpadsnew                            */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/



// Include required files
require ("config.php");


/*********************************************************/
/* Prepare for current selection                         */
/*********************************************************/

// Bannerid
if ($bannerid != '')
{
	$where[] = 'bannerid = '.$bannerid;
	
	if ($zoneid != '')
	{
		$where[] = "zoneid = ".$zoneid;
	}
}

// Clientid
elseif ($clientid != '')
{
	$idresult = phpAds_dbQuery ("
		SELECT
			b.bannerid
		FROM
			".$phpAds_config['tbl_banners']." AS b,
			".$phpAds_config['tbl_clients']." AS c
		WHERE
			c.parent = $clientid AND
			c.clientid = b.clientid
	");
	
	if (phpAds_dbNumRows($idresult) > 0)
		while ($row = phpAds_dbFetchArray($idresult))
			$bannerids[] = "bannerid = ".$row['bannerid'];
	
	$where[] = "(".implode(' OR ', $bannerids).")";
}

// Campaignid
elseif ($campaignid != '')
{
	$idresult = phpAds_dbQuery ("
		SELECT
			bannerid
		FROM
			".$phpAds_config['tbl_banners']."
		WHERE
			clientid = $campaignid
	");
	
	if (phpAds_dbNumRows($idresult) > 0)
		while ($row = phpAds_dbFetchArray($idresult))
			$bannerids[] = "bannerid = ".$row['bannerid'];
	
	$where[] = "(".implode(' OR ', $bannerids).")";
}

// Zoneid
elseif ($zoneid != '')
{
	$where[] = "zoneid = ".$zoneid;
}

// Affiliateid
elseif ($affiliateid != '')
{
	$idresult = phpAds_dbQuery (" 
		SELECT
			zoneid
		FROM
			".$phpAds_config['tbl_zones']."
		WHERE
			affiliateid = ".$affiliateid."
	");
	
	if (phpAds_dbNumRows($idresult) > 0)
		while ($row = phpAds_dbFetchArray($idresult))
			$zoneids[] = "zoneid = ".$row['zoneid'];
	
	$where[] = "(".implode(' OR ', $zoneids).")";
}


// Convert to SQL query
if (isset($where))
	$where = implode (' AND ', $where);



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

if ($phpAds_config['compact_stats']) 
{
	// Get stats for selected period
	$begin = date('Ymd', $begin_timestamp);
	$end   = date('Ymd', $end_timestamp);
	
	$result = phpAds_dbQuery("
		SELECT
			sum(views) AS sum_views,
			sum(clicks) AS sum_clicks,
			DATE_FORMAT(day, '".$formatted."') AS date,
			DATE_FORMAT(day, '".$unformatted."') AS date_u
		FROM
			".$phpAds_config['tbl_adstats']."
		WHERE
			day >= $begin AND day < $end
			".(isset($where) ? 'AND '.$where : '')."
		GROUP BY
			date_u
		ORDER BY
			date_u DESC
		LIMIT 
			$returnlimit
	");
	
	while ($row = phpAds_dbFetchArray($result))
	{
		$stats[$row['date']]['sum_views'] = $row['sum_views'];
		$stats[$row['date']]['sum_clicks'] = $row['sum_clicks'];
	}
}
else
{
	// Get stats for selected period
	$begin = date('YmdHis', $begin_timestamp);
	$end   = date('YmdHis', $end_timestamp);
	
	$result = phpAds_dbQuery("
		SELECT
			COUNT(*) AS sum_views,
			DATE_FORMAT(t_stamp, '".$formatted."') AS date,
			DATE_FORMAT(t_stamp, '".$unformatted."') AS date_u
		FROM
			".$phpAds_config['tbl_adviews']."
		WHERE
			t_stamp >= $begin AND t_stamp < $end
			".(isset($where) ? 'AND '.$where : '')."
		GROUP BY
			date_u
		ORDER BY
			date_u DESC
		LIMIT 
			$returnlimit
	");
	
	while ($row = phpAds_dbFetchArray($result))
	{
		$stats[$row['date']]['sum_views'] = $row['sum_views'];
		$stats[$row['date']]['sum_clicks'] = '0';
	}
	
	
	$result = phpAds_dbQuery("
		SELECT
			COUNT(*) AS sum_clicks,
			DATE_FORMAT(t_stamp, '".$formatted."') AS date,
			DATE_FORMAT(t_stamp, '".$unformatted."') AS date_u
		FROM
			".$phpAds_config['tbl_adclicks']."
		WHERE
			t_stamp >= $begin AND t_stamp < $end
			".(isset($where) ? 'AND '.$where : '')."
		GROUP BY
			date_u
		ORDER BY
			date_u DESC
		LIMIT 
			$returnlimit
	");
	
	while ($row = phpAds_dbFetchArray($result))
	{
		$stats[$row['date']]['sum_clicks'] = $row['sum_clicks'];
	}
}




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
			$items[$d]['value1'] = isset($stats[$key]['sum_views']) ? $stats[$key]['sum_views'] : 0;
			$items[$d]['value2'] = isset($stats[$key]['sum_clicks']) ? $stats[$key]['sum_clicks'] : 0;
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
		$totalweekclicks = 0;
		
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
				$totalweekviews  += $stats[$key]['sum_views'];
				$totalweekclicks += $stats[$key]['sum_clicks'];
				$days++;
			}
		}
		
		$items[$d]['value1'] = $totalweekviews;
		$items[$d]['value2'] = $totalweekclicks;
		$items[$d]['text']   = $week_formatted;
	}
}


// Build the graph
include('lib-graph.inc.php');

?>