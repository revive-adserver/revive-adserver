<?php // $Revision$

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2001 by Niels Leenheer                                 */
/* http://sourceforge.net/projects/phpadsnew                            */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/



// Include required files
require ("config.php");


// Security check
phpAds_checkAccess(phpAds_Admin);



/*********************************************************/
/* Build frameset                                        */
/*********************************************************/

if ($command == 'frame')
{
	echo "<html>";
	echo "<frameset rows='50,*' frameborder='no' border='0' framespacing='0'>";
	echo "<frame name='top' src='stats-convert.php?command=top' scrolling='no' marginwidth='0' marginheight='0' frameborder='no' noresize>";
	echo "<frame name='bottom' src='stats-convert.php?command=start' scrolling='yes' marginwidth='0' marginheight='0' frameboder='no'>";
	echo "</frameset>";
	echo "</html>";
}



/*********************************************************/
/* Build header                                          */
/*********************************************************/

if ($command == 'top')
{
	echo "<html><head>";
	echo "<link rel='stylesheet' href='interface.css'>";
	echo "</head>";
	
	echo "<body bgcolor='#000063'>";
	echo "<table width='100%' height='100%' cellpadding='0' cellspacing='0' border='0'>";
	
	if ($phpAds_config['name'] != "")
		echo "<tr><td valign='middle'><span class='phpAdsNew'>&nbsp;".$phpAds_config['name']."</span></td></tr>";
	else
		echo "<tr><td valign='bottom'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src='images/logo.gif' width='163' height='34' vspace='2'></td></tr>";
	
	echo "</table>";
	echo "</body></html>";
}



/*********************************************************/
/* Build information and start button                    */
/*********************************************************/

if ($command == 'start')
{
	echo "<html><head>";
	echo "<link rel='stylesheet' href='interface.css'>";
	echo "</head><body bgcolor='#FFFFFF' text='#000000'>";
	echo "<table width='100%' cellpadding='0' cellspacing='0' border='0'>";
	echo "<tr><td height='25' colspan='3'>&nbsp;</td></tr>";
	
	echo "<tr><td><img src='images/spacer.gif' width='30'></td><td>";
	
	if ($phpAds_config['compact_stats'])
	{
		$viewresult = phpAds_dbQuery("SELECT COUNT(*) AS cnt FROM ".$phpAds_config['tbl_adviews']);
		$viewrow = phpAds_dbFetchArray($viewresult);
		$verboseviews = $viewrow["cnt"];
		
		$clickresult = phpAds_dbQuery("SELECT COUNT(*) AS cnt FROM ".$phpAds_config['tbl_adclicks']);
		$clickrow = phpAds_dbFetchArray($viewresult);
		$verboseclicks = $clickrow["cnt"];
		
		if ($verboseviews > 0 || $verboseclicks > 0)
		{
			echo "You have enabled the compact statistics, but your old statistics are still 
				  in verbose format. As long as the verbose statistics aren't converted to compact format 
				  they will not be used while viewing these pages.<br>
				  <b>Before converting your statistics, make a backup of the database!</b><br><br>
  				  Do you want to convert your verbose statistics to the 
				  new compact format?
				 ";
			echo "<br><br>";
			echo "<a href='stats-convert.php?command=overview'><img src='images/icon-update.gif' border='0' align='absmiddle'>&nbsp;Start</a>";
		}
		else
		{
			echo "There is nothing to convert to compact stats";
		}
	}
	else
	{
		echo "You are using verbose stats, there is no need to convert anything";
	}
	
	echo "</td><td><img src='images/spacer.gif' width='30'></td></tr>";
	echo "</table>";
	echo "</body></html>";
}



/*********************************************************/
/* Build overview and call to conversion routines        */
/*********************************************************/

if ($command == 'overview')
{
	if (!phpAds_convertTableExists())
	{
		// Setup a new conversion
		phpAds_convertTableCreate() or phpAds_sqlDie();
		
		$day = array();
		
		// Get views
		$overviewresult = phpAds_dbQuery("SELECT bannerid, count(*) as count, DATE_FORMAT(t_stamp, '$date_format') as date_f, DATE_FORMAT(t_stamp, '%Y-%m-%d') as date FROM ".$phpAds_config['tbl_adviews']." GROUP BY date, bannerid");
		while ($overviewrow = phpAds_dbFetchArray($overviewresult))
		{
			$day[$overviewrow['date']][$overviewrow['bannerid']]['views'] = $overviewrow['count'];
			$day[$overviewrow['date']][$overviewrow['bannerid']]['date_f'] = $overviewrow['date_f'];
		}
		
		// Get clicks
		$overviewresult = phpAds_dbQuery("SELECT bannerid, count(*) as count, DATE_FORMAT(t_stamp, '$date_format') as date_f, DATE_FORMAT(t_stamp, '%Y-%m-%d') as date FROM ".$phpAds_config['tbl_adclicks']." GROUP BY date, bannerid");
		while ($overviewrow = phpAds_dbFetchArray($overviewresult))
		{
			$day[$overviewrow['date']][$overviewrow['bannerid']]['clicks'] = $overviewrow['count'];
			$day[$overviewrow['date']][$overviewrow['bannerid']]['date_f'] = $overviewrow['date_f'];
		}
		
		// Loop through all days
		for (reset($day);$key=key($day);next($day))
		{
			$section_year = substr ($key, 0, 4);
			$section_month  = substr ($key, 5, 2);
			$section_day  = substr ($key, 8, 2);
			
			$begin_stamp = date ("Ymd000000", mktime(0, 0, 0, $section_month, $section_day, $section_year));
			$end_stamp = date ("Ymd000000", mktime(0, 0, 0, $section_month, $section_day, $section_year) + 86400);
			
			$banner = $day[$key];
			
			// Loop through all banners within this day
			for (reset($banner);$bkey=key($banner);next($banner))
			{
				$records = 0;
				if (isset($banner[$bkey]['views'])) $records += $banner[$bkey]['views'];
				if (isset($banner[$bkey]['clicks'])) $records += $banner[$bkey]['clicks'];
				
				// Add this banner/day to the Tasklist
				phpAds_convertAddTask($begin_stamp, $end_stamp, $records, $bkey);
			}
		}
	}
	
	
	
	// Build HTML Taskscheduler :-)
	$result = phpAds_dbQuery("SELECT begin_stamp, DATE_FORMAT(begin_stamp, '$date_format') as date_f, sum(records) as sum FROM phpadsconversiontemp WHERE status='waiting' GROUP BY begin_stamp");
	
	echo "<html><head>";
	echo "<link rel='stylesheet' href='interface.css'>";
	?>
		<script language='JavaScript'>
		<!--
			function StartCleanup()
			{
				document.images.cleanup.src = 'stats-convert.php?command=cleanup';
			}
		//-->
		</script>
	<?php
	echo "</head><body bgcolor='#FFFFFF' text='#000000' onLoad=\"StartCleanup();\">";
	echo "<table width='100%' cellpadding='0' cellspacing='0' border='0'>";
	
	// Show all tasks
	while ($task = phpAds_dbFetchArray($result))
	{
		echo "<tr>";
		echo "<td height='25'>&nbsp;&nbsp;<img src='stats-convert.php?command=convert&id=".$task['begin_stamp']."' width='16' height='16'></td>";
		echo "<td>".$task['date_f']."</td>";
		echo "<td>".$task['sum']." records to convert...</td>";
		echo "</tr>";
		
		echo "<tr><td colspan='3'><img src='images/break-l.gif' width='100%' height='1'></td></tr>";
	}
	
	
	echo "<tr>";
	echo "<td height='25'>&nbsp;&nbsp;<img name='cleanup' src='images/spacer.gif' width='16' height='16'></td>";
	echo "<td>&nbsp;</td>";
	echo "<td>Cleaning up...</td>";
	echo "</tr>";
	
	echo "<tr><td colspan='3'><img src='images/break-l.gif' width='100%' height='1'></td></tr>";
	
	echo "</table>";
	echo "</body></html>";
}



/*********************************************************/
/* Convert verbose stats to compact stats                */
/*********************************************************/

if ($command == 'convert')
{
	// don't let the user interupt with this process!
	// timeout this script in 10 minutes for safety
	if (!get_cfg_var ('safe_mode'))
	{
		set_time_limit (600);
		ignore_user_abort(1);
	}
	
	// Assume something went wrong until
	// it is certain everything went alright
	$error = true;
	
	if (isset($id) && $id != '')
	{
		// Get a list of waiting tasks for this day
		$result = phpAds_dbQuery("SELECT * FROM phpadsconversiontemp WHERE begin_stamp='$id' AND status='waiting'");
		
		if (phpAds_dbNumRows($result) > 0)
		{
			// Get next task
			while ($task = phpAds_dbFetchArray($result))
			{
				$views = 0;
				$clicks = 0;
				
				$begintime 	= $task['begin_stamp'];
				$endtime 	= $task['end_stamp'];
				$bannerid 	= $task['bannerid'];
				$id		 	= $task['conversionID'];
				
				$day = substr($begintime, 0, 4)."-".substr($begintime, 4, 2)."-".substr($begintime, 6, 2);
				
				// Get views for this task
				$countresult = phpAds_dbQuery("SELECT count(*) AS count FROM ".$phpAds_config['tbl_adviews']." WHERE bannerid='$bannerid' AND t_stamp >= $begintime AND t_stamp < $endtime");
				if ($countrow = phpAds_dbFetchArray($countresult))
				{
					$views = $countrow['count'];
				}
				
				// Get clicks for this task
				$countresult = phpAds_dbQuery("SELECT count(*) AS count FROM ".$phpAds_config['tbl_adclicks']." WHERE bannerid='$bannerid' AND t_stamp >= $begintime AND t_stamp < $endtime"); 
				if ($countrow = phpAds_dbFetchArray($countresult))
				{
					$clicks = $countrow['count'];
				}
				
				// Check for clicks or views to convert
				if ($clicks > 0 || $views > 0)
				{
					// Check for existing compact stats for this task
					$checkresult = phpAds_dbQuery("SELECT count(*) AS count FROM ".$phpAds_config['tbl_adstats']." WHERE day='$day' AND bannerid='$bannerid'");
					$checkrow = phpAds_dbFetchArray ($checkresult);
					
					if (isset($checkrow['count']) && $checkrow['count'] > 0)
					{
						// Add clicks / views to existing compact stats
						$updateresult = phpAds_dbQuery("UPDATE ".$phpAds_config['tbl_adstats']." SET clicks=clicks+$clicks, views=views+$views WHERE day='$day' AND bannerid='$bannerid'");
						
						if (phpAds_dbAffectedRows($updateresult) > 0)
						{
							// Everything went alright
							phpAds_convertSetStatus ($id, 'finished');
							$error = false;
						}
						else
							phpAds_convertSetStatus ($id, 'error');
					}
					else
					{
						// Insert a new record to the compact stats
						$updateresult = phpAds_dbQuery("INSERT INTO ".$phpAds_config['tbl_adstats']." SET bannerid='$bannerid', day='$day', clicks=$clicks, views=$views");
						
						if (phpAds_dbAffectedRows($updateresult) > 0)
						{
							// Everything went alright
							phpAds_convertSetStatus ($id, 'finished');
							$error = false;
						}
						else
							phpAds_convertSetStatus ($id, 'error');
					}
				}
			}
		}
	}
	
	
	if ($error)
	{
		// Show X
		header ("Content-type: image/gif");
		include ("../lib-cache.inc.php");
		$image = @fopen ('images/delete.gif', 'r');
		fpassthru ($image);
		fclose ($image);
	}
	else
	{
		// Show V
		header ("Content-type: image/gif");
		include ("../lib-cache.inc.php");
		$image = @fopen ('images/save.gif', 'r');
		fpassthru ($image);
		fclose ($image);
	}
}



/*********************************************************/
/* Cleanup mess                                          */
/*********************************************************/

if ($command == 'cleanup')
{
	if (!get_cfg_var ('safe_mode'))
	{
		set_time_limit (600);
		ignore_user_abort(1);
	}
	
	$error = true;
	$status = array();
	
	$result = phpAds_dbQuery("SELECT status, COUNT(*) AS count FROM phpadsconversiontemp GROUP BY status");
	while ($row = phpAds_dbFetchArray($result))
	{
		$status[$row['status']] = $row['count'];
	}
	
	if (sizeof($status) == 1 && isset ($status['finished']))
	{
		// Only one type of status and status = finished
		// Clean up whole table
		phpAds_dbQuery("DELETE FROM ".$phpAds_config['tbl_adviews']);
		phpAds_convertTableDrop();
		$error = false;
	}
	elseif (sizeof($status) == 2 && isset ($status['finished']) && isset ($status['error']))
	{
		$result = phpAds_dbQuery("SELECT * FROM phpadsconversiontemp WHERE status='error'");
		
		$where = "";
		
		while ($error = phpAds_dbFetchArray($result))
		{
			$begintime 	= $error['begin_stamp'];
			$endtime 	= $error['end_stamp'];
			$bannerid 	= $error['bannerid'];
			
			if ($where == "")
			{
				$where .= "(bannerid='$bannerid' AND t_stamp >= $begintime AND t_stamp < $endtime)";
			}
			else
			{
				$where .= " OR (bannerid='$bannerid' AND t_stamp >= $begintime AND t_stamp < $endtime)";
			}
		}
		
		if ($where != "")
			$where = "WHERE NOT ($where)";
		
		phpAds_dbQuery("DELETE FROM adviews $where");
		phpAds_dbQuery("DELETE FROM adclicks $where");
		
		$error = false;
	}
	
	if ($error)
	{
		header ("Content-type: image/gif");
		include ("../lib-cache.inc.php");
		$image = @fopen ('images/delete.gif', 'r');
		fpassthru ($image);
		fclose ($image);
	}
	else
	{
		header ("Content-type: image/gif");
		include ("../lib-cache.inc.php");
		$image = @fopen ('images/save.gif', 'r');
		fpassthru ($image);
		fclose ($image);
	}
}


function phpAds_convertTableExists()
{
	$available = false;
	$result = phpAds_dbQuery("SHOW TABLES");
	
	while ($tables = phpAds_dbFetchRow($result)) 
	{
    	if (strtolower($tables[0]) == 'phpadsconversiontemp') 
		{
			$available = true;
		}
	}
	
	return ($available);
}


function phpAds_convertTableCreate()
{
	$result = phpAds_dbQuery("
		CREATE TABLE phpadsconversiontemp (
		   conversionID mediumint(9) NOT NULL auto_increment,
		   begin_stamp timestamp(14),
		   end_stamp timestamp(14),
		   status enum('waiting','running','finished','error') DEFAULT 'waiting',
		   records int(11),
		   bannerid mediumint(9),
		   PRIMARY KEY (conversionID)
		)
	");
	
	return ($result);
}


function phpAds_convertTableDrop()
{
	$result = phpAds_dbQuery("DROP TABLE phpadsconversiontemp");
}


function phpAds_convertAddTask($begin_stamp, $end_stamp, $records, $bannerid)
{
	$result = phpAds_dbQuery("
		INSERT INTO 
			phpadsconversiontemp
		SET
		   	begin_stamp = '$begin_stamp',
		   	end_stamp = '$end_stamp',
			bannerid = '$bannerid',
		   	records = $records
	");
}

function phpAds_convertSetStatus ($id, $status)
{
	$result = phpAds_dbQuery("
		UPDATE 
			phpadsconversiontemp
		SET
		   	status = '$status',
			begin_stamp = begin_stamp,
			end_stamp = end_stamp
		WHERE
			conversionID = '$id'
	");
}

?>
