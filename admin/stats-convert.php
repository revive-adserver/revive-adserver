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
	
	if ($phpAds_name != "")
		echo "<tr><td valign='middle'><span class='phpAdsNew'>&nbsp;$phpAds_name</span></td></tr>";
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
	
	if ($phpAds_compact_stats)
	{
		$viewresult = db_query("SELECT COUNT(*) AS cnt FROM $phpAds_tbl_adviews");
		$viewrow = @mysql_fetch_array($viewresult);
		$verboseviews = $viewrow["cnt"];
		
		$clickresult = db_query("SELECT COUNT(*) AS cnt FROM $phpAds_tbl_adclicks");
		$clickrow = @mysql_fetch_array($viewresult);
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
		phpAds_convertTableCreate() or mysql_die();
		
		$day = array();
		
		// Get views
		$overviewresult = @db_query("SELECT bannerid, count(*) as count, DATE_FORMAT(t_stamp, '$date_format') as date_f, DATE_FORMAT(t_stamp, '%Y-%m-%d') as date FROM $phpAds_tbl_adviews GROUP BY date, bannerid");
		while ($overviewrow = @mysql_fetch_array($overviewresult))
		{
			$day[$overviewrow['date']][$overviewrow['bannerid']]['views'] = $overviewrow['count'];
			$day[$overviewrow['date']][$overviewrow['bannerid']]['date_f'] = $overviewrow['date_f'];
		}
		
		// Get clicks
		$overviewresult = @db_query("SELECT bannerid, count(*) as count, DATE_FORMAT(t_stamp, '$date_format') as date_f, DATE_FORMAT(t_stamp, '%Y-%m-%d') as date FROM $phpAds_tbl_adclicks GROUP BY date, bannerid");
		while ($overviewrow = @mysql_fetch_array($overviewresult))
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
	$result = @db_query("SELECT begin_stamp, DATE_FORMAT(begin_stamp, '$date_format') as date_f, sum(records) as sum FROM phpadsconversiontemp WHERE status='waiting' GROUP BY begin_stamp");
	
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
	while ($task = @mysql_fetch_array($result))
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
		$result = @db_query("SELECT * FROM phpadsconversiontemp WHERE begin_stamp='$id' AND status='waiting'");
		
		if (@mysql_num_rows($result) > 0)
		{
			// Get next task
			while ($task = @mysql_fetch_array($result))
			{
				$views = 0;
				$clicks = 0;
				
				$begintime 	= $task['begin_stamp'];
				$endtime 	= $task['end_stamp'];
				$bannerID 	= $task['bannerID'];
				$id		 	= $task['conversionID'];
				
				$day = substr($begintime, 0, 4)."-".substr($begintime, 4, 2)."-".substr($begintime, 6, 2);
				
				// Get views for this task
				$countresult = @db_query("SELECT count(*) as count FROM $phpAds_tbl_adviews WHERE bannerID='$bannerID' AND t_stamp >= $begintime AND t_stamp < $endtime");
				if ($countrow = @mysql_fetch_array($countresult))
				{
					$views = $countrow['count'];
				}
				
				// Get clicks for this task
				$countresult = @db_query("SELECT count(*) as count FROM $phpAds_tbl_adclicks WHERE bannerID='$bannerID' AND t_stamp >= $begintime AND t_stamp < $endtime"); 
				if ($countrow = @mysql_fetch_array($countresult))
				{
					$clicks = $countrow['count'];
				}
				
				// Check for clicks or views to convert
				if ($clicks > 0 || $views > 0)
				{
					// Check for existing compact stats for this task
					$checkresult = @db_query("SELECT count(*) as count FROM $phpAds_tbl_adstats WHERE day='$day' AND bannerID='$bannerID'");
					$checkrow = @mysql_fetch_array ($checkresult);
					
					if (isset($checkrow['count']) && $checkrow['count'] > 0)
					{
						// Add clicks / views to existing compact stats
						$updateresult = @db_query("UPDATE $phpAds_tbl_adstats SET clicks=clicks+$clicks, views=views+$views WHERE day='$day' AND bannerID='$bannerID'");
						
						if (@mysql_affected_rows() > 0)
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
						$updateresult = @db_query("INSERT INTO $phpAds_tbl_adstats SET bannerID='$bannerID', day='$day', clicks=$clicks, views=$views");
						
						if (@mysql_affected_rows() > 0)
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
		include ("../nocache.inc.php");
		$image = @fopen ('images/delete.gif', 'r');
		fpassthru ($image);
		fclose ($image);
	}
	else
	{
		// Show V
		header ("Content-type: image/gif");
		include ("../nocache.inc.php");
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
	
	$result = @db_query("select status, count(*) as count from phpadsconversiontemp group by status");
	while ($row = @mysql_fetch_array($result))
	{
		$status[$row['status']] = $row['count'];
	}
	
	if (sizeof($status) == 1 && isset ($status['finished']))
	{
		// Only one type of status and status = finished
		// Clean up whole table
		@db_query("delete from $phpAds_tbl_adviews");
		phpAds_convertTableDrop();
		$error = false;
	}
	elseif (sizeof($status) == 2 && isset ($status['finished']) && isset ($status['error']))
	{
		$result = @db_query("select * from phpadsconversiontemp where status='error'");
		
		$where = "";
		
		while ($error = @mysql_fetch_array($result))
		{
			$begintime 	= $error['begin_stamp'];
			$endtime 	= $error['end_stamp'];
			$bannerID 	= $error['bannerID'];
			
			if ($where == "")
			{
				$where .= "(bannerID='$bannerID' AND t_stamp >= $begintime AND t_stamp < $endtime)";
			}
			else
			{
				$where .= " OR (bannerID='$bannerID' AND t_stamp >= $begintime AND t_stamp < $endtime)";
			}
		}
		
		if ($where != "")
			$where = "WHERE NOT ($where)";
		
		@db_query("DELETE FROM adviews $where");
		@db_query("DELETE FROM adclicks $where");
		
		$error = false;
	}
	
	if ($error)
	{
		header ("Content-type: image/gif");
		include ("../nocache.inc.php");
		$image = @fopen ('images/delete.gif', 'r');
		fpassthru ($image);
		fclose ($image);
	}
	else
	{
		header ("Content-type: image/gif");
		include ("../nocache.inc.php");
		$image = @fopen ('images/save.gif', 'r');
		fpassthru ($image);
		fclose ($image);
	}
}


function phpAds_convertTableExists()
{
	$available = false;
	$result = @db_query("SHOW TABLES");
	
	while ($tables = @mysql_fetch_row($result)) 
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
	$result = @db_query("
		CREATE TABLE phpadsconversiontemp (
		   conversionID mediumint(9) NOT NULL auto_increment,
		   begin_stamp timestamp(14),
		   end_stamp timestamp(14),
		   status enum('waiting','running','finished','error') DEFAULT 'waiting',
		   records int(11),
		   bannerID mediumint(9),
		   PRIMARY KEY (conversionID)
		)
	");
	
	return ($result);
}


function phpAds_convertTableDrop()
{
	$result = @db_query("DROP TABLE phpadsconversiontemp");
}


function phpAds_convertAddTask($begin_stamp, $end_stamp, $records, $bannerID)
{
	$result = @db_query("
		INSERT INTO 
			phpadsconversiontemp
		SET
		   	begin_stamp = '$begin_stamp',
		   	end_stamp = '$end_stamp',
			bannerID = '$bannerID',
		   	records = $records
	");
}

function phpAds_convertSetStatus ($id, $status)
{
	$result = @db_query("
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
