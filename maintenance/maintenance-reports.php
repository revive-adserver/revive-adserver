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




/*********************************************************/
/* PHP3 replacement for substr_count()					 */
/*********************************************************/

function substr_count2($string,$search)
{
	$temp = str_replace($search,$search."a",$string);
	return strlen($temp)-strlen($string); 
}



/*********************************************************/
/* Mail clients and check for activation  				 */
/* and expiration dates					 				 */
/*********************************************************/


// Fetch all clients
// Some extra info: The client interval is the number of
// days between reports and thus also the maximum number
// of day of statistics of this report. The report 
// last date is the date on which the last report was
// generated. A report never included the current date
// because the statistics are not completely collected
// for the current day. The last date therefor must be
// included in the statistics for today.

$res_clients = db_query("
	SELECT
		clientID,
		clientname,
		contact,
		email,
		language,
		report,
		reportinterval,
		reportlastdate,
		UNIX_TIMESTAMP(reportlastdate) AS reportlastdate_t
	FROM
		$phpAds_tbl_clients
	WHERE
		parent = 0 AND report='true'
	
	") or die($strLogErrorClients.'  '.@mysql_error($phpAds_db_link));

while($client = @mysql_fetch_array($res_clients))
{
	// Process this client
	print "Processing client ".$client["clientname"]."...<BR>\n";
	flush();
    
	
	$intervaldaysago = mktime(0, 0, 0, date('m'), date('d'), date('Y')) - ($client['reportinterval'] * (60 * 60 * 24));
	print "&nbsp;&nbsp;&nbsp;".$client['reportinterval']." days ago = $intervaldaysago ...<BR>\n";
	print "&nbsp;&nbsp;&nbsp;Last run = ".$client['reportlastdate_t']." ...<BR>\n";
	
	if ($client['reportlastdate_t'] <= $intervaldaysago && $client['reportlastdate'] != '0000-00-00')
	{
		$last_unixtimestamp   = mktime(0, 0, 0, date('m'), date('d'), date('Y')) - (60 * 60 * 24);
		$first_unixtimestamp  = $client['reportlastdate_t'];
		$last_sqltimestamp    = date ("Ymd000000", $last_unixtimestamp);
		$first_sqltimestamp   = date ("Ymd000000", $first_unixtimestamp);
		
		print "&nbsp;&nbsp;&nbsp;Preparing report ($last_sqltimestamp to $first_sqltimestamp)...<BR>\n";
		flush();
		
		// Update last run
		$res_update = db_query("UPDATE $phpAds_tbl_clients SET reportlastdate=NOW() WHERE clientID=".$client['clientID']);
		
		// Load client language strings
		if (isset($client["language"]) && $client["language"] != "")
			include ("../language/".$client["language"].".inc.php");
		else
			include ("../language/$phpAds_language.inc.php");
		
		
		$active_campaigns = false;
		$log = "";
		
		// Fetch all campaings belonging to client
		
		$res_campaigns = @db_query("
			SELECT
				clientID,
				clientname,
				views,
				clicks,
				expire,
				UNIX_TIMESTAMP(expire) as expire_st,
				activate,
				UNIX_TIMESTAMP(activate) as activate_st,
				active
			FROM
				$phpAds_tbl_clients
			WHERE
				parent = ".$client['clientID']."
		
		") or die($strLogErrorClients);
		
		while($campaign = @mysql_fetch_array($res_campaigns))
		{
			print "&nbsp;&nbsp;&nbsp;Processing campaign ".$campaign["clientname"]."...<BR>\n";
			flush();
			
			// Fetch all banners belonging to campaign
			$res_banners = @db_query("
				SELECT
					bannerID,
					clientID,
					URL,
					active,
					description,
					alt
				FROM
					$phpAds_tbl_banners
				WHERE
					clientID = $campaign[clientID]
				") or die($strLogErrorBanners);
			
			
			$active_banners = false;
		    
			$log .= "\n".$strCampaign."  ".phpAds_buildClientName ($campaign['clientID'], $campaign['clientname'])."\n";
			$log .= "=======================================================\n\n";
			
			while($row_banners = @mysql_fetch_array($res_banners))
			{
				$adviews = db_total_views($row_banners["bannerID"]);
		        $client["views_used"] = $adviews;
				$adclicks = db_total_clicks($row_banners["bannerID"]);
				$campaign["clicks_used"] = $adclicks;
				
				if ($adviews > 0 || $adclicks > 0)
				{
					$log .= $strBanner."  ".phpAds_buildBannerName ($row_banners['bannerID'], $row_banners['description'], $row_banners['alt'])."\n";
					$log .= $strLinkedTo.": ".$row_banners['URL']."\n";
					$log .= "-------------------------------------------------------\n";
					
					print "<LI>Processing banner $row_banners[bannerID] [linked to: $row_banners[URL]]...<BR>\n";
					flush();
					
					$active_banner_stats = false;
					
					if ($adviews > 0)
					{
						$log .= "$strViews (total):   $adviews\n";
						
						// Fetch all adviews belonging to banner belonging to client, grouped by day
						if ($phpAds_compact_stats)
				            $res_adviews = @db_query("
				    			SELECT
				    				SUM(views) as qnt,
				    				DATE_FORMAT(day, '$date_format') as t_stamp_f,
				    				TO_DAYS(day) AS the_day
				    			FROM
				    				$phpAds_tbl_adstats
				    			WHERE
				    				bannerID = ".$row_banners['bannerID']." AND
				                    views > 0 AND
									UNIX_TIMESTAMP(day) >= $first_unixtimestamp AND
									UNIX_TIMESTAMP(day) < $last_unixtimestamp
				    			GROUP BY
				    				day
				    			ORDER BY
				    				day DESC
				    			") or die($strLogErrorViews);
				        else
				    		$res_adviews = @db_query("
				    			SELECT
				    				*,
				    				count(*) as qnt,
				    				DATE_FORMAT(t_stamp, '$date_format') as t_stamp_f,
				    				TO_DAYS(t_stamp) AS the_day
				    			FROM
				    				$phpAds_tbl_adviews
				    			WHERE
				    				bannerID = ".$row_banners['bannerID']." AND
									t_stamp >= $first_sqltimestamp AND
									t_stamp < $last_sqltimestamp
				    			GROUP BY
				    				the_day
				    			ORDER BY
				    				the_day DESC
				    			") or die($strLogErrorViews);
				        
						if (@mysql_num_rows($res_adviews))
						{
							while($row_adviews = @mysql_fetch_array($res_adviews))
								$log .= "      $row_adviews[t_stamp_f]:   $row_adviews[qnt]\n";
							
							$active_banner_stats = true;
						}
						else
						{
							$log .= "      ".str_replace("{interval}", $client['reportinterval'], $strNoViewLoggedInInterval)."\n";
						}
			        }
					
					if ($adclicks > 0)
					{
						// Total adclicks
				        $log .= "\n$strClicks (total):   $adclicks\n";                  
						
						// Fetch all adclicks belonging to banner belonging to client, grouped by day
						if ($phpAds_compact_stats)
				            $res_adclicks = @db_query("
				    			SELECT
				    				SUM(clicks) as qnt,
				    				DATE_FORMAT(day, '$date_format') as t_stamp_f,
				    				TO_DAYS(day) AS the_day
				    			FROM
				    				$phpAds_tbl_adstats
				    			WHERE
				    				bannerID = ".$row_banners['bannerID']." AND
				                    clicks > 0 AND
									UNIX_TIMESTAMP(day) >= $first_unixtimestamp AND
									UNIX_TIMESTAMP(day) < $last_unixtimestamp
				    			GROUP BY
				    				day
				    			ORDER BY
				    				day DESC
				    			LIMIT 7
				    			") or die("$strLogErrorClicks ".mysql_error($phpAds_db_link));
				        else
				            $res_adclicks = @db_query("
				    			SELECT
				    				count(*) as qnt,
				    				DATE_FORMAT(t_stamp, '$date_format') as t_stamp_f,
				    				TO_DAYS(t_stamp) AS the_day
				    			FROM
				    				$phpAds_tbl_adclicks
				    			WHERE
				    				bannerID = ".$row_banners['bannerID']." AND
									t_stamp >= $first_sqltimestamp AND
									t_stamp < $last_sqltimestamp
				    			GROUP BY
				    				the_day
				    			ORDER BY
				    				the_day DESC
				    			") or die("$strLogErrorClicks ".mysql_error($phpAds_db_link));
						
						if (@mysql_num_rows($res_adviews))
						{
							while($row_adclicks = @mysql_fetch_array($res_adclicks))
								$log .= "      $row_adclicks[t_stamp_f]:   $row_adclicks[qnt]\n";
							
							$active_banner_stats = true;
						}
						else
						{
							$log .= "      ".str_replace("{interval}", $client['reportinterval'], $strNoClickLoggedInInterval)."\n";
						}
					}
					
					$log .= "\n\n";
					
					if ($active_banner_stats == true || ($active_banner_stats == false && $campaign['active'] == 'true'))
						$active_banners = true;
				}
			}
			
			if ($active_banners == true)
			{
				$active_campaigns = true;
			}
		}
		
		
		// E-mail Stats to active clients
		if ($client["email"] != '' && $active_campaigns == true)
		{
			$Subject = $strMailSubject.": ".$client["clientname"];
			$To		 = $client["contact"]." <".$client["email"].">";
			
			$Body    = "$strMailHeader\n";
			$Body   .= "$strMailBannerStats\n\n";
			$Body   .= "$log\n";
			$Body   .= "$strMailFooter";
			
			$Body    = str_replace ("{clientname}", $client["clientname"], $Body);
			$Body	 = str_replace ("{contact}", $client["contact"], $Body);
			$Body    = str_replace ("{adminfullname}", $phpAds_admin_fullname, $Body);
			
			@mail ($To, $Subject, $Body, $phpAds_admin_email_headers);
			unset ($Subject);
			
			print "Report sent to ".$client["email"]."...<BR>\n";
			flush();
		}
		
		print ("<br><br>\n");
		flush();
	}
	else
	{
		print "&nbsp;&nbsp;&nbsp;Report interval was not yet reached...<BR>\n";
		flush();
		print ("<br>\n");
		flush();
	}
}

echo "$strLogMailSent\n";


?>
