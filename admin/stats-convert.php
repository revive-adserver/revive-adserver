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
	phpAds_CSS();
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
	phpAds_CSS();
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
	phpAds_CSS();
	echo "</head><body>";
	echo "<table width='100%' cellpadding='0' cellspacing='0' border='0'>";
	
	for (reset($day);$key=key($day);next($day))
	{
		echo "<tr>";
		echo "<td height='25'>&nbsp;&nbsp;<img src='stats-convert.php?command=convert&day=$key' width='16' height='16'></td>";
		echo "<td>".$day[$key]['date_f']."</td>";
		echo "<td>".($day[$key]['views'] + $day[$key]['clicks'])." records to convert...</td>";
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
		set_time_limit (300);
		ignore_user_abort(1);
	}
	
	$error = true;
	
	if ($day != '')
	{
		$countresult = @db_query("SELECT bannerID, count(*) as count FROM $phpAds_tbl_adviews WHERE DATE_FORMAT(t_stamp, '%Y-%m-%d')='$day' GROUP BY bannerID");
		while ($countrow = @mysql_fetch_array($countresult))
		{
			$bannerID = $countrow['bannerID'];
			$adstats[$bannerID]['views'] = $countrow['count'];
		}
		
		$countresult = @db_query("SELECT bannerID, count(*) as count FROM $phpAds_tbl_adclicks WHERE DATE_FORMAT(t_stamp, '%Y-%m-%d')='$day' GROUP BY bannerID"); 
		while ($countrow = @mysql_fetch_array($countresult))
		{
			$bannerID = $countrow['bannerID'];
			$adstats[$bannerID]['clicks'] = $countrow['count'];
		}
		
		if (is_array($adstats))
		{
			for (reset($adstats);$bannerID=key($adstats);next($adstats))
			{
				//echo "$bannerID - ".$adstats[$bannerID]['views']." - ".$adstats[$bannerID]['clicks']." <br>";
				
				$checkresult = @db_query("SELECT count(*) as count FROM $phpAds_tbl_adstats WHERE day='$day' AND bannerID='$bannerID'");
				$checkrow = @mysql_fetch_array ($checkresult);
				
				$views = 0 + $adstats[$bannerID]['views'];
				$clicks = 0 + $adstats[$bannerID]['clicks'];
				
				if ($checkrow['count'] > 0)
				{
					$result = @db_query("UPDATE $phpAds_tbl_adstats SET clicks=clicks+$clicks, views=views+$views WHERE day='$day' AND bannerID='$bannerID'");
					if (@mysql_affected_rows() > 0)
					{
						$result = @db_query("DELETE FROM $phpAds_tbl_adviews WHERE bannerID='$bannerID' AND DATE_FORMAT(t_stamp, '%Y-%m-%d')='$day'");
						$result = @db_query("DELETE FROM $phpAds_tbl_adclicks WHERE bannerID='$bannerID' AND DATE_FORMAT(t_stamp, '%Y-%m-%d')='$day'");
					}
					$error = false;
				}
				else
				{
					$result = @db_query("INSERT INTO $phpAds_tbl_adstats SET bannerID='$bannerID', day='$day', clicks=$clicks, views=$views");
					if (@mysql_affected_rows() > 0)
					{
						$result = @db_query("DELETE FROM $phpAds_tbl_adviews WHERE bannerID='$bannerID' AND DATE_FORMAT(t_stamp, '%Y-%m-%d')='$day'");
						$result = @db_query("DELETE FROM $phpAds_tbl_adclicks WHERE bannerID='$bannerID' AND DATE_FORMAT(t_stamp, '%Y-%m-%d')='$day'");
					}
					$error = false;
				}
			}
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
}



/*********************************************************/
/* CSS definitions for use in above functions            */
/*********************************************************/

function phpAds_CSS()
{
	?>
	<style type="text/css">
		<!--
			.phpAdsNew 	{ font-family: Arial, Helvetica, sans-serif; font-size: 24px; font-style: italic; font-weight: bold; color: #FFFFFF; }
			.location 	{ font-family: Arial, Helvetica, sans-serif; font-size: 14px; font-style: italic; font-weight: bold; color: #FFFFFF; }
			.topnav 	{ font-family: Arial, Helvetica, sans-serif; font-size: 11px; font-style: italic; font-weight: bold; color: #FFFFFF; text-decoration:none; }
			.nav 		{ font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; color: #003399; }
			.heading 	{ font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 14pt; font-weight: bold; color: white; margin-bottom: 0px; }
			body 		{ font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; margin-left: 0px; margin-right: 0px; margin-top: 0px; margin-bottom: 0px; }
			table 		{ font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; }
			td 			{ font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; }
			td.gray 	{ font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; color: #888888; }
			a 			{ color: #003399; text-decoration:none; }
			a.black 	{ color: #000000; text-decoration:none; }
			a.gray 		{ color: #888888; text-decoration:none; }
			select,textarea,input 
						{ font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; }
		-->
	</style>
	<?
}

