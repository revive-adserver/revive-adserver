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
	
	echo "<body bgcolor='#000088'>";
	echo "<table width='100%' height='100%' cellpadding='0' cellspacing='0' border='0'>";
	echo "<tr><td><span class='phpAdsNew'>&nbsp;$phpAds_name</span></td></tr>";
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
	echo "</head><body>";
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
			echo "<a href='stats-convert.php?command=overview'><img src='images/go_blue.gif' border='0'>&nbsp;Start</a>";
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
	echo "</body></html>";
}



/*********************************************************/
/* Build overview and call to conversion routines        */
/*********************************************************/

if ($command == 'overview')
{
	$day = array();
	
	$overviewresult = @db_query("SELECT count(*) as count, DATE_FORMAT(t_stamp, '$date_format') as date_f, DATE_FORMAT(t_stamp, '%Y-%m-%d') as date FROM $phpAds_tbl_adviews GROUP BY date");
	while ($overviewrow = @mysql_fetch_array($overviewresult))
	{
		$day[$overviewrow['date']]['views'] = $overviewrow['count'];
		$day[$overviewrow['date']]['date_f'] = $overviewrow['date_f'];
	}
	
	$overviewresult = @db_query("SELECT count(*) as count, DATE_FORMAT(t_stamp, '$date_format') as date_f, DATE_FORMAT(t_stamp, '%Y-%m-%d') as date FROM $phpAds_tbl_adclicks GROUP BY date");
	while ($overviewrow = @mysql_fetch_array($overviewresult))
	{
		$day[$overviewrow['date']]['clicks'] = $overviewrow['count'];
		$day[$overviewrow['date']]['date_f'] = $overviewrow['date_f'];
	}
	
	echo "<html><head>";
	echo "<link rel='stylesheet' href='interface.css'>";
	echo "</head><body>";
	echo "<table width='100%' cellpadding='0' cellspacing='0' border='0'>";
	
	for (reset($day);$key=key($day);next($day))
	{
		$records = 0;
		if (isset($day[$key]['views'])) $records += $day[$key]['views'];
		if (isset($day[$key]['clicks'])) $records += $day[$key]['clicks'];
		
		echo "<tr>";
		echo "<td height='25'>&nbsp;&nbsp;<img src='stats-convert.php?command=convert&day=$key' width='16' height='16'></td>";
		echo "<td>".$day[$key]['date_f']."</td>";
		echo "<td>$records records to convert...</td>";
		echo "</tr>";
		
		echo "<tr><td colspan='3'><img src='images/break-l.gif' width='100%' height='1'></td></tr>";
	}
	
	echo "</table>";
	echo "</body></html>";
}



/*********************************************************/
/* Convert verbose stats to compact stats                */
/*********************************************************/

if ($command == 'convert')
{
	// don't let the user interupt with this process!
	// timeout this script in 5 minutes for safety
	if (!get_cfg_var ('safe_mode'))
	{
		set_time_limit (600);
		ignore_user_abort(1);
	}
	
	$error = true;
	
	if (isset($day) && $day != '')
	{
		//$countresult = @db_query("LOCK TABLES $phpAds_tbl_adviews");
		
		$section_year = substr ($day, 0, 4);
		$section_month  = substr ($day, 5, 2);
		$section_day  = substr ($day, 8, 2);
		
		$begintime = date ("Ymd000000", mktime(0, 0, 0, $section_month, $section_day, $section_year));
		$endtime = date ("Ymd000000", mktime(0, 0, 0, $section_month, $section_day, $section_year) + 86400);
		
		//echo "$begintime - $endtime";
		
		//echo "SELECT bannerID, count(*) as count FROM $phpAds_tbl_adviews WHERE t_stamp > $begintime AND t_stamp < $endtime GROUP BY bannerID <br>";
			
		$countresult = @db_query("SELECT bannerID, count(*) as count FROM $phpAds_tbl_adviews WHERE t_stamp > $begintime AND t_stamp < $endtime GROUP BY bannerID");
		while ($countrow = @mysql_fetch_array($countresult))
		{
			$bannerID = $countrow['bannerID'];
			$adstats[$bannerID]['views'] = $countrow['count'];
		}
		
		$countresult = @db_query("SELECT bannerID, count(*) as count FROM $phpAds_tbl_adclicks WHERE t_stamp > $begintime AND t_stamp < $endtime GROUP BY bannerID"); 
		while ($countrow = @mysql_fetch_array($countresult))
		{
			$bannerID = $countrow['bannerID'];
			$adstats[$bannerID]['clicks'] = $countrow['count'];
		}
		
		if (isset($adstats) && is_array($adstats))
		{
			$deleteid = array();
			
			for (reset($adstats);$bannerID=key($adstats);next($adstats))
			{
				$checkresult = @db_query("SELECT count(*) as count FROM $phpAds_tbl_adstats WHERE day='$day' AND bannerID='$bannerID'");
				$checkrow = @mysql_fetch_array ($checkresult);
				
				$clicks = 0;
				$views = 0;
				if (isset($adstats[$bannerID]['views'])) $views = $adstats[$bannerID]['views'];
				if (isset($adstats[$bannerID]['clicks'])) $clicks = $adstats[$bannerID]['clicks'];
				
				if (isset($checkrow['count']) && $checkrow['count'] > 0)
				{
					$result = @db_query("UPDATE $phpAds_tbl_adstats SET clicks=clicks+$clicks, views=views+$views WHERE day='$day' AND bannerID='$bannerID'");
					if (@mysql_affected_rows() > 0)
					{
						$deleteid[$bannerID] = true;
					}
					$error = false;
				}
				else
				{
					//echo "INSERT INTO $phpAds_tbl_adstats SET bannerID='$bannerID', day='$day', clicks=$clicks, views=$views";
					
					$result = @db_query("INSERT INTO $phpAds_tbl_adstats SET bannerID='$bannerID', day='$day', clicks=$clicks, views=$views");
					if (@mysql_affected_rows() > 0)
					{
						$deleteid[$bannerID] = true;
					}
					$error = false;
				}
			}
			
			if ($error)
			{
				header ("Content-type: image/gif");
				$image = @fopen ('images/delete.gif', 'r');
				fpassthru ($image);
				fclose ($image);
			}
			else
			{
				header ("Content-type: image/gif");
				$image = @fopen ('images/save.gif', 'r');
				fpassthru ($image);
				fclose ($image);
			}
			
			flush();
			
			if (sizeof($deleteid) == sizeof($adstats))
			{
				//echo "REMOVING IN ONE";
				$result = @db_query("DELETE LOW_PRIORITY FROM $phpAds_tbl_adviews WHERE t_stamp > $begintime AND t_stamp < $endtime");
				$result = @db_query("DELETE LOW_PRIORITY FROM $phpAds_tbl_adclicks WHERE t_stamp > $begintime AND t_stamp < $endtime");
			}
			else
			{
				for (reset($deleteid);$bannerID=key($deleteid);next($deleteid))
				{
					$result = @db_query("DELETE LOW_PRIORITY FROM $phpAds_tbl_adviews WHERE bannerID='$bannerID' AND t_stamp > $begintime AND t_stamp < $endtime");
					$result = @db_query("DELETE LOW_PRIORITY FROM $phpAds_tbl_adclicks WHERE bannerID='$bannerID' AND t_stamp > $begintime AND t_stamp < $endtime");
				}
			}
			
			exit;
		}
		
		//$countresult = @db_query("UNLOCK TABLES");
	}
	
	if ($error)
	{
		header ("Content-type: image/gif");
		$image = @fopen ('images/delete.gif', 'r');
		fpassthru ($image);
		fclose ($image);
	}
	else
	{
		header ("Content-type: image/gif");
		$image = @fopen ('images/save.gif', 'r');
		fpassthru ($image);
		fclose ($image);
	}
	
}

?>
