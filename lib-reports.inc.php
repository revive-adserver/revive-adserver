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




function phpAds_SendMaintenanceReport ($clientID, $first_unixtimestamp, $last_unixtimestamp, $update=true)
{
	global $phpAds_language, $date_format, $phpAds_compact_stats;
	global $phpAds_tbl_clients, $phpAds_tbl_banners, $phpAds_tbl_adstats;
	global $phpAds_tbl_adviews, $phpAds_tbl_adclicks;
	
	global $phpAds_admin_fullname, $phpAds_admin_email_headers, $strMailReportPeriodAll;
	global $strMailSubject, $strMailHeader, $strMailBannerStats, $strMailFooter, $strMailReportPeriod;
	global $strLogErrorClients, $strLogErrorBanners, $strLogErrorViews, $strNoStatsForCampaign;
	global $strLogErrorClicks, $strNoClickLoggedInInterval, $strNoViewLoggedInInterval;
	global $strCampaign, $strBanner, $strLinkedTo, $strViews, $strClicks, $phpAds_CharSet;
	
	
	// Convert timestamps to SQL format
	$last_sqltimestamp    = date ("YmdHis", $last_unixtimestamp);
	$first_sqltimestamp   = date ("YmdHis", $first_unixtimestamp);
	
	
	// Get Client information
	$res_client = phpAds_dbQuery("
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
			clientID=".$clientID."
		");
	
	if (phpAds_dbNumRows($res_client) > 0)
	{
		$client = phpAds_dbFetchArray($res_client);
		
		// Load client language strings
		if (isset($client["language"]) && $client["language"] != "")
			include (phpAds_path."/language/".$client["language"].".inc.php");
		else
			include (phpAds_path."/language/$phpAds_language.inc.php");
		
		
		$active_campaigns = false;
		$log = "";
		
		// Fetch all campaings belonging to client
		
		$res_campaigns = phpAds_dbQuery("
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
		
		while($campaign = phpAds_dbFetchArray($res_campaigns))
		{
			// Fetch all banners belonging to campaign
			$res_banners = phpAds_dbQuery("
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
					clientID = ".$campaign['clientID']."
				") or die($strLogErrorBanners);
			
			
			$active_banners = false;
		    
			$log .= "\n".$strCampaign."  ".phpAds_buildClientName ($campaign['clientID'], $campaign['clientname'])."\n";
			$log .= "=======================================================\n\n";
			
			while($row_banners = phpAds_dbFetchArray($res_banners))
			{
				$adviews = phpAds_totalViews($row_banners["bannerID"]);
		        $client["views_used"] = $adviews;
				$adclicks = phpAds_totalClicks($row_banners["bannerID"]);
				$campaign["clicks_used"] = $adclicks;
				
				if ($adviews > 0 || $adclicks > 0)
				{
					$log .= $strBanner."  ".phpAds_buildBannerName ($row_banners['bannerID'], $row_banners['description'], $row_banners['alt'])."\n";
					$log .= $strLinkedTo.": ".$row_banners['URL']."\n";
					$log .= "-------------------------------------------------------\n";
					
					$active_banner_stats = false;
					
					if ($adviews > 0)
					{
						$log .= "$strViews (total):   $adviews\n";
						
						// Fetch all adviews belonging to banner belonging to client, grouped by day
						if ($phpAds_compact_stats)
				            $res_adviews = phpAds_dbQuery("
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
				    		$res_adviews = phpAds_dbQuery("
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
				        
						if (phpAds_dbNumRows($res_adviews))
						{
							while($row_adviews = phpAds_dbFetchArray($res_adviews))
								$log .= "      $row_adviews[t_stamp_f]:   $row_adviews[qnt]\n";
							
							$active_banner_stats = true;
						}
						else
						{
							$log .= "      ".$strNoViewLoggedInInterval."\n";
						}
			        }
					
					if ($adclicks > 0)
					{
						// Total adclicks
				        $log .= "\n$strClicks (total):   $adclicks\n";
						
						// Fetch all adclicks belonging to banner belonging to client, grouped by day
						if ($phpAds_compact_stats)
				            $res_adclicks = phpAds_dbQuery("
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
				    			") or die("$strLogErrorClicks ".phpAds_dbError());
				        else
				            $res_adclicks = phpAds_dbQuery("
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
				    			") or die("$strLogErrorClicks ".phpAds_dbError());
						
						if (phpAds_dbNumRows($res_adviews))
						{
							while($row_adclicks = phpAds_dbFetchArray($res_adclicks))
								$log .= "      $row_adclicks[t_stamp_f]:   $row_adclicks[qnt]\n";
							
							$active_banner_stats = true;
						}
						else
						{
							$log .= "      ".$strNoClickLoggedInInterval."\n";
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
			else
			{
				$log .= $strNoStatsForCampaign."\n\n\n";
			}
		}
		
		
		// E-mail Stats to active clients
		if ($client["email"] != '' && $active_campaigns == true)
		{
			$Subject  = $strMailSubject.": ".$client["clientname"];
			$To		  = $client['email'];
			
			$Headers = "Content-Transfer-Encoding: 8bit\n";
			
			if (isset($phpAds_CharSet))
				$Headers .= "Content-Type: text/plain; charset=".$phpAds_CharSet."\n"; 
			
			$Headers .= "To: ".$client['contact']." <".$client['email'].">\n";
			$Headers .= $phpAds_admin_email_headers."\n";
			
			
			$Body    = "$strMailHeader\n";
			$Body   .= "$strMailBannerStats\n";
			
			if ($first_unixtimestamp == 0)
				$Body   .= "$strMailReportPeriodAll\n\n";
			else
				$Body   .= "$strMailReportPeriod\n\n";
				
			$Body   .= "$log\n";
			$Body   .= "$strMailFooter";
			
			$Body    = str_replace ("{clientname}", 	$client['clientname'], $Body);
			$Body	 = str_replace ("{contact}", 		$client['contact'], $Body);
			$Body    = str_replace ("{adminfullname}", 	$phpAds_admin_fullname, $Body);
			$Body	 = str_replace ("{startdate}", 		date(str_replace('%', '', $date_format), $first_unixtimestamp), $Body);
			$Body	 = str_replace ("{enddate}", 		date(str_replace('%', '', $date_format), $last_unixtimestamp), $Body);
			
			if (@mail ($To, $Subject, $Body, $Headers))
			{
				// Update last run
				if ($update == true)
					$res_update = phpAds_dbQuery("UPDATE $phpAds_tbl_clients SET reportlastdate=NOW() WHERE clientID=".$client['clientID']);
				
				return (true);
			}
		}
	}
	
	return (false);
}