<?php // $Revision$

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2000-2003 by the phpAdsNew developers                  */
/* For more information visit: http://www.phpadsnew.com                 */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/



// Include required files
require ("config.php");
require ("lib-maintenance.inc.php");
require ("lib-statistics.inc.php");


// Register input variables
phpAds_registerGlobal ('action', 'min', 'count', 'days');


// Security check
phpAds_checkAccess(phpAds_Admin);



/*********************************************************/
/* Main code                                             */
/*********************************************************/

function phpAds_startResult ()
{
	echo "var result = findObj('result');\n";
}

function phpAds_printResult ($result)
{
	echo "result.value = result.value + \"".$result."\";\n";
}

function phpAds_getSpan ()
{
	global $phpAds_config;
	
	$result = phpAds_dbQuery("
		SELECT
			DATE_FORMAT(MIN(t_stamp), '%Y%m%d') as min,
			DATE_FORMAT(MAX(t_stamp), '%Y%m%d') as max,
			TO_DAYS(MAX(t_stamp)) - TO_DAYS(MIN(t_stamp)) + 1 as days
		FROM
			".$phpAds_config['tbl_adviews']."
	");
	
	if ($row = phpAds_dbFetchArray($result))
		return ($row);
	else
		return false;
}

function phpAds_getVerbose($base, $count)
{
	global $phpAds_config;
	
	$begin_timestamp = date('YmdHis', phpAds_makeTimestamp($base, $count * 60 * 60 * 24));
	$end_timestamp   = date('YmdHis', phpAds_makeTimestamp($base, ($count + 1) * 60 * 60 * 24 - 1));
	
	// Get views
	$result = phpAds_dbQuery("
		SELECT
			bannerid,
			zoneid,
			source,
			HOUR(t_stamp) AS hour,
			COUNT(*) AS qnt
		FROM
			".$phpAds_config['tbl_adviews']."
		WHERE
			t_stamp >= $begin_timestamp AND t_stamp <= $end_timestamp
		GROUP BY 
			bannerid, zoneid, source, hour
	") or phpAds_sqlDie();
	
	
	while ($row = phpAds_dbFetchArray($result))
		$stats["'".$row['bannerid']."'"]["'".$row['zoneid']."'"]["'".$row['hour']."'"]["'".$row['source']."'"] = array('views' => $row['qnt'], 'clicks' => 0);
	
	
	// Get clicks
	$result = phpAds_dbQuery("
		SELECT
			bannerid,
			zoneid,
			source,
			HOUR(t_stamp) AS hour,
			COUNT(*) AS qnt
		FROM
			".$phpAds_config['tbl_adclicks']."
		WHERE
			t_stamp >= $begin_timestamp AND t_stamp <= $end_timestamp
		GROUP BY 
			bannerid, zoneid, source, hour
	") or phpAds_sqlDie();
	
	
	while ($row = phpAds_dbFetchArray($result))
		if (isset($stats["'".$row['bannerid']."'"]["'".$row['zoneid']."'"]["'".$row['hour']."'"]["'".$row['source']."'"]))
			$stats["'".$row['bannerid']."'"]["'".$row['zoneid']."'"]["'".$row['hour']."'"]["'".$row['source']."'"]['clicks'] = $row['qnt'];
		else
			$stats["'".$row['bannerid']."'"]["'".$row['zoneid']."'"]["'".$row['hour']."'"]["'".$row['source']."'"] = array('views' => 0, 'clicks' => $row['qnt']);
	
	if (isset($stats) && count($stats))
		return $stats;
}

function phpAds_storeCompact ($base, $count, $stats)
{
	global $phpAds_config;
	global $strConvertAdViews, $strConvertAdClicks;
	
	$adviews = 0;
	$adclicks = 0;
	
	$day = date('Ymd', $base + ($count * 60 * 60 * 24));
	
	
	for (reset($stats); $bannerid = key($stats); next($stats))
	{
		$stats_b = $stats[$bannerid];
		
		for (reset($stats_b); $zoneid = key($stats_b); next($stats_b))
		{
			$stats_z = $stats_b[$zoneid];
			
			for (reset($stats_z); $hour = key($stats_z); next($stats_z))
			{
				$stats_h = $stats_z[$hour];
				
				for (reset($stats_h); $source = key($stats_h); next($stats_h))
				{
					$stats_s = $stats_h[$source];
					
			        $result = phpAds_dbQuery(
						"INSERT INTO ".
	                   	$phpAds_config['tbl_adstats']." SET clicks = ".$stats_s['clicks'].", views = ".$stats_s['views'].", 
						day = $day, hour = $hour, bannerid = $bannerid, zoneid = $zoneid, source = $source ");
					
		       		if (phpAds_dbAffectedRows() < 1) 
		       		{
						$result = phpAds_dbQuery(
							"UPDATE ".$phpAds_config['tbl_adstats']." SET views = views + ".$stats_s['views'].",
							clicks = clicks + ".$stats_s['clicks']." WHERE day = $day AND hour = $hour 
							AND bannerid = $bannerid AND zoneid = $zoneid AND source = $source ");
		       		}
					
					$adclicks += $stats_s['clicks'];
					$adviews  += $stats_s['views'];
				}
			}
		}
	}
	
	phpAds_printResult ("    ".$adviews." ".$strConvertAdViews." ".$adclicks." ".$strConvertAdClicks."\\n");
	
	return true;
}

function phpAds_deleteVerbose ($base, $count)
{
	global $phpAds_config;
	
	$begin_timestamp = date('YmdHis', phpAds_makeTimestamp($base, $count * 60 * 60 * 24));
	$end_timestamp   = date('YmdHis', phpAds_makeTimestamp($base, ($count + 1) * 60 * 60 * 24 - 1));
	
	
	// Delete views
	$result = phpAds_dbQuery("
		DELETE 
			LOW_PRIORITY 
		FROM
			".$phpAds_config['tbl_adviews']."
		WHERE
			t_stamp >= $begin_timestamp AND t_stamp <= $end_timestamp
	") or phpAds_sqlDie();
	
	// Delete clicks
	$result = phpAds_dbQuery("
		DELETE 
			LOW_PRIORITY 
		FROM
			".$phpAds_config['tbl_adclicks']."
		WHERE
			t_stamp >= $begin_timestamp AND t_stamp <= $end_timestamp
	") or phpAds_sqlDie();
}


/*********************************************************/
/* Main code                                             */
/*********************************************************/

header("Content-type: application/x-javascript");

if (isset($action) && $action == 'start')
{
	$span = phpAds_getSpan();
	
	phpAds_startResult ();
	
	if (is_array($span) && $span['days'] > 0)
	{
		phpAds_printResult (" Starting conversion...\\n\\n");
		
		echo "document.write (\"";
		echo "<script language='JavaScript' src='";
		echo "maintenance-stats-convert.php?min=".$span['min']."&count=0&days=".$span['days'];
		echo "'></script>";
		echo "\");";
	}
	else
	{
		phpAds_printResult (" ".$strConvertNothing."\\n");
		
		echo "var busy = findObj('busy');\n";
		echo "var done = findObj('done');\n";
		echo "if (busy) busy.style.display = 'none';\n";
		echo "if (done) done.style.display = '';\n";
	}
}
else
{
	// Set base variables
	$base 			 = mktime(0, 0, 0, substr($min, 4, 2), substr($min, 6, 2), substr($min, 0, 4));
	$formatted		 = date('d-m-Y', phpAds_makeTimestamp($base, ($count * 60 * 60 * 24)));
	
	
	// Start converting...
	phpAds_startResult ();
	phpAds_printResult (" ".$strConverting." ".$formatted."...\\n");
	
	$stats = phpAds_getVerbose($base, $count);
	
	if (isset($stats) && count($stats))
	{
		if (phpAds_storeCompact ($base, $count, $stats))
		{
			phpAds_deleteVerbose ($base, $count);
		}
	}
	else
		phpAds_printResult ("    ".$strConvertNothing."\\n");
	
	phpAds_printResult ("\\n");
	
	
	
	// Go to next day
	if ($count + 1 < $days)
	{
		echo "document.write (\"";
		echo "<script language='JavaScript' src='";
		echo "maintenance-stats-convert.php?min=".$min."&count=".($count + 1)."&days=".$days;
		echo "'></script>";
		echo "\");";
	}
	else
	{
		phpAds_printResult (" ".$strConvertFinished."\\n");
		
		echo "var busy = findObj('busy');\n";
		echo "var done = findObj('done');\n";
		echo "if (busy) busy.style.display = 'none';\n";
		echo "if (done) done.style.display = '';\n";
	}
}

?>