<?php // $Revision: 3830 $

/************************************************************************/
/* Openads 2.0                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2000-2007 by the Openads developers                    */
/* For more information visit: http://www.openads.org                   */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/



// Figure out our location
if (strlen(__FILE__) > strlen(basename(__FILE__)))
    define ('phpAds_path', ereg_replace("[/\\\\]maintenance[/\\\\][^/\\\\]+$", '', __FILE__));
else
    define ('phpAds_path', '..');



// Include required files
require (phpAds_path."/config.inc.php");

// Exit if load balancing is not enabled
if (!$phpAds_config['lb_enabled'])
	die();

// Include required files
require (phpAds_path."/libraries/lib-io.inc.php");
require (phpAds_path."/libraries/lib-db.inc.php");
require (phpAds_path."/libraries/lib-dbconfig.inc.php");
require (phpAds_path."/libraries/lib-cache.inc.php");
require (phpAds_path."/admin/lib-statistics.inc.php");

if (!defined('LIBUSERLOG_INCLUDED'))
	require (phpAds_path."/libraries/lib-userlog.inc.php");

if (!defined('LIBLOCKS_INCLUDED'))
	require (phpAds_path.'/libraries/lib-locks.inc.php');

if (!defined('LIBCLEANTABLES_INCLUDED'))
	require (phpAds_path.'/libraries/lib-cleantables.inc.php');

require (phpAds_path."/libraries/lib-log.inc.php");
require (phpAds_path."/maintenance/lib-maintenance.inc.php");


// Acquire lock
if ($dlock = phpAds_maintenanceGetLock(phpAds_lockDistributed))
{
	phpAds_userlogSetUser(phpAds_userDistributedMaintenance);

	// Check when the last run was
	$t_stamp_start = phpAds_dbResult(phpAds_dbQuery("
		SELECT
			last_run
		FROM
			".$phpAds_config['tbl_lb_local']."
		"), 0, 0);
	
	if (empty($t_stamp_start))
	{
		// Distributed maintenance hasn't run
		$t_stamp_start = mktime(0, 0, 0, 1, 1, 2000);
		
		// Make suire that the local config row exists
		phpAds_dbQuery("INSERT INTO ".$phpAds_config['tbl_lb_local']." (last_run) VALUES (0)");
	}
	
	// Only fetch rows inserted until the last second
	$t_stamp_end = time() - 1;
	
	// Force replicating to compact stats
	$compact_stats = true;
	
	$stats = array();	
	$count = array();
	
	if ($compact_stats)
	{
		$query_views = "
			SELECT
				DATE(t_stamp) AS day,
				HOUR(t_stamp) AS hour,
				bannerid,
				zoneid,
				".($phpAds_config['log_source'] ? "source," : "'' as source")."
				COUNT(*) AS views
			FROM
				".$phpAds_config['tbl_adviews']."
			WHERE
				t_stamp >= '".date('Y-m-d H:i:s', $t_stamp_start)."' AND
				t_stamp < '".date('Y-m-d H:i:s', $t_stamp_end)."'
			GROUP BY
				day,
				hour,
				bannerid,
				zoneid,
				source
			";
		
		$query_clicks = "
			SELECT
				DATE(t_stamp) AS day,
				HOUR(t_stamp) AS hour,
				bannerid,
				zoneid,
				".($phpAds_config['log_source'] ? "source," : "'' as source")."
				COUNT(*) AS clicks
			FROM
				".$phpAds_config['tbl_adclicks']."
			WHERE
				t_stamp >= '".date('Y-m-d H:i:s', $t_stamp_start)."' AND
				t_stamp < '".date('Y-m-d H:i:s', $t_stamp_end)."'
			GROUP BY
				day,
				hour,
				bannerid,
				zoneid,
				source
			";
	
		$res = phpAds_dbQuery($query_views);
		while ($row = phpAds_dbFetchArray($res))
		{
			if (!isset($stats[$row['day']][$row['hour']][$row['bannerid']][$row['zoneid']][$row['source']]))
				$stats[$row['day']][$row['hour']][$row['bannerid']][$row['zoneid']][$row['source']] = array(
					'views'		=> $row['views'],
					'clicks'	=> 0
				);
			else
				$stats[$row['day']][$row['hour']][$row['bannerid']][$row['zoneid']][$row['source']]['views'] = $row['views'];
			
			if (!isset($count[$row['bannerid']]))
				$count[$row['bannerid']] = array(
					'views'		=> $row['views'],
					'clicks'	=> 0
				);
			else
				$count[$row['bannerid']]['views'] += $row['views'];
		}
	
		$res = phpAds_dbQuery($query_clicks);
		while ($row = phpAds_dbFetchArray($res))
		{
			if (!isset($stats[$row['day']][$row['hour']][$row['bannerid']][$row['zoneid']][$row['source']]))
				$stats[$row['day']][$row['hour']][$row['bannerid']][$row['zoneid']][$row['source']] = array(
					'views'		=> 0,
					'clicks'	=> $row['clicks']
				);
			else
				$stats[$row['day']][$row['hour']][$row['bannerid']][$row['zoneid']][$row['source']]['clicks'] = $row['clicks'];
			
			if (!isset($count[$row['bannerid']]))
				$count[$row['bannerid']] = array(
					'views'		=> 0,
					'clicks'	=> $row['clicks']
				);
			else
				$count[$row['bannerid']]['clicks'] += $row['clicks'];
		}
		
		// Switch databases
		phpAds_dbDistributedMode();
		
		// Reconnect
		phpAds_dbConnect();
		
		foreach ($stats as $day => $row)
		{
			foreach ($row as $hour => $row)
			{
				foreach ($row as $bannerid => $row)
				{
					foreach ($row as $zoneid => $row)
					{
						foreach ($row as $source => $row)
						{
							$query_update = "
								UPDATE
									".$phpAds_config['tbl_adstats']."
								SET
									views = views + ".$row['views'].",
									clicks = clicks + ".$row['clicks']."
								WHERE
									day = '".addslashes($day)."' AND
									hour = '".addslashes($hour)."' AND
									bannerid = '".addslashes($bannerid)."' AND
									zoneid = '".addslashes($zoneid)."' AND
									source = '".addslashes($source)."'
								";
									
							$res = phpAds_dbQuery($query_update);
							
							if (!phpAds_dbAffectedRows($res))
							{
								$query_insert = "
									INSERT INTO ".$phpAds_config['tbl_adstats']." (
										day,
										hour,
										bannerid,
										zoneid,
										source,
										views,
										clicks
									) VALUES (
										'".addslashes($day)."',
										'".addslashes($hour)."',
										'".addslashes($bannerid)."',
										'".addslashes($zoneid)."',
										'".addslashes($source)."',
										".$row['views'].",
										".$row['clicks']."
									)";
	
								$res = phpAds_dbQuery($query_insert);
								
								if (!$res)
								{
									$res = phpAds_dbQuery($query_update);
								}
							}
						}
					}
				}
			}
		}
	}
	else
	{
		$query_views = "
			SELECT
				*
			FROM
				".$phpAds_config['tbl_adviews']."
			WHERE
				t_stamp >= '".date('Y-m-d H:i:s', $t_stamp_start)."' AND
				t_stamp < '".date('Y-m-d H:i:s', $t_stamp_end)."'
			";
		
		$query_clicks = "
			SELECT
				*
			FROM
				".$phpAds_config['tbl_adclicks']."
			WHERE
				t_stamp >= '".date('Y-m-d H:i:s', $t_stamp_start)."' AND
				t_stamp < '".date('Y-m-d H:i:s', $t_stamp_end)."'
			";
	
		$stats = array(
			'views'		=> array(),
			'clicks'	=> array()
		);
	
		$res = phpAds_dbQuery($query_views);
		while ($row = phpAds_dbFetchArray($res))
		{
			$stats['views'][] = $row;
			
			if (!isset($count[$row['bannerid']]))
				$count[$row['bannerid']] = array(
					'views'		=> 1,
					'clicks'	=> 0
				);
			else
				$count[$row['bannerid']]['views']++;
		}
	
		$res = phpAds_dbQuery($query_clicks);
		while ($row = phpAds_dbFetchArray($res))
		{
			$stats['clicks'][] = $row;
			
			if (!isset($count[$row['bannerid']]))
				$count[$row['bannerid']] = array(
					'views'		=> 0,
					'clicks'	=> 1
				);
			else
				$count[$row['bannerid']]['clicks']++;
		}
		
		// Switch databases
		phpAds_dbNormalMode();
	
		foreach ($stats['views'] as $row)
		{
			foreach ($row as $k => $v)
				$row[$k] = addslashes($v);
			
			$query = "
				INSERT INTO ".$phpAds_config['tbl_adviews']." (
				".join(', ', array_keys($row))."
				) VALUES (
				'".join("', '", $row)."'
				)";
			
			phpAds_dbQuery($query);
		}
	
		foreach ($stats['clicks'] as $row)
		{
			foreach ($row as $k => $v)
				$row[$k] = addslashes($v);
			
			$query = "
				INSERT INTO ".$phpAds_config['tbl_adclicks']." (
				".join(', ', array_keys($row))."
				) VALUES (
				'".join("', '", $row)."'
				)";
			
			phpAds_dbQuery($query);
		}
	}

	$report = '';

	$imported_views = 0;
	$imported_clicks = 0;

	if (count($count))
	{

		$res = phpAds_dbQuery("SELECT bannerid, clientid FROM ".$phpAds_config['tbl_banners']." WHERE bannerid IN (".join(',', array_keys($count)).")");
		while ($row = phpAds_dbFetchArray($res))
		{
			if ($count[$row['bannerid']]['views'])
			{
				phpAds_logExpire ($row['clientid'], phpAds_Views, $count[$row['bannerid']]['views'], true);
				$imported_views += $count[$row['bannerid']]['views'];
			}
				
			if ($count[$row['bannerid']]['clicks'])
			{
				phpAds_logExpire ($row['clientid'], phpAds_Clicks, $count[$row['bannerid']]['clicks'], true);
				$imported_clicks += $count[$row['bannerid']]['clicks'];
			}
		}
	}
	
	if ($imported_views || $imported_clicks)
	{
		$report .= "Server name: ".(isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'Unknown')."\n\n";
		$report .= "Imported views:  {$imported_views}\n";
		$report .= "Imported clicks: {$imported_clicks}\n";
	
		phpAds_userlogAdd(phpAds_actionDistributedStats, 0, $report);
	}	
	
	// Switch databases
	phpAds_dbNormalMode();

	// Prune stats
	phpAds_cleanTables(1, true);
	
	// Update the timestamp
	phpAds_dbQuery ("
		UPDATE
			".$phpAds_config['tbl_lb_local']."
		SET
			last_run = '".$t_stamp_end."'
	");
	
	// Release lock
	phpAds_maintenanceReleaseLock($dlock);
}

?>