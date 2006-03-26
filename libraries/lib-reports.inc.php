<?php // $Revision$

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2000-2006 by the phpAdsNew developers                  */
/* For more information visit: http://www.phpadsnew.com                 */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/



// Prevent full path disclosure
if (!defined('phpAds_path')) die();



if (!defined('LIBMAIL_INCLUDED'))
	require (phpAds_path.'/libraries/lib-mail.inc.php');


function phpAds_SendMaintenanceReport ($clientid, $first_unixtimestamp, $last_unixtimestamp, $update=true)
{
	global $phpAds_config;
	global $date_format;
	global $strMailSubject, $strMailHeader, $strMailBannerStats, $strMailFooter, $strMailReportPeriod;
	global $strLogErrorClients, $strLogErrorBanners, $strLogErrorViews, $strNoStatsForCampaign;
	global $strLogErrorClicks, $strNoClickLoggedInInterval, $strNoViewLoggedInInterval;
	global $strTotal, $strTotalThisPeriod;
	global $strCampaign, $strBanner, $strLinkedTo, $strViews, $strClicks, $strMailReportPeriodAll;
	global $phpAds_CharSet;
	
	
	// Convert timestamps to SQL format
	$last_sqltimestamp    = date ("YmdHis", $last_unixtimestamp);
	$first_sqltimestamp   = date ("YmdHis", $first_unixtimestamp);
	
	
	// Get Client information
	$res_client = phpAds_dbQuery("
		SELECT
			clientid,
			clientname,
			contact,
			email,
			language,
			report,
			reportinterval,
			reportlastdate,
			UNIX_TIMESTAMP(reportlastdate) AS reportlastdate_t
		FROM
			".$phpAds_config['tbl_clients']."
		WHERE
			clientid='".$clientid."'
		");
	
	if (phpAds_dbNumRows($res_client) > 0)
	{
		$client = phpAds_dbFetchArray($res_client);
		
		// Load client language strings
		@include (phpAds_path.'/language/english/default.lang.php');
		if ($client['language'] != '') $phpAds_config['language'] = $client['language'];
		if ($phpAds_config['language'] != 'english' && file_exists(phpAds_path.'/language/'.$phpAds_config['language'].'/default.lang.php'))
			@include (phpAds_path.'/language/'.$phpAds_config['language'].'/default.lang.php');
		
		
		$active_campaigns = false;
		$log = "";
		
		// Fetch all campaings belonging to client
		
		$res_campaigns = phpAds_dbQuery("
			SELECT
				clientid,
				clientname,
				views,
				clicks,
				expire,
				UNIX_TIMESTAMP(expire) as expire_st,
				activate,
				UNIX_TIMESTAMP(activate) as activate_st,
				active
			FROM
				".$phpAds_config['tbl_clients']."
			WHERE
				parent = ".$client['clientid']."
		
		") or die($strLogErrorClients);
		
		while($campaign = phpAds_dbFetchArray($res_campaigns))
		{
			$current_log = '';
			
			// Fetch all banners belonging to campaign
			$res_banners = phpAds_dbQuery("
				SELECT
					bannerid,
					clientid,
					url,
					active,
					description,
					alt
				FROM
					".$phpAds_config['tbl_banners']."
				WHERE
					clientid = ".$campaign['clientid']."
				") or die($strLogErrorBanners);
			
			
			$active_banners = false;
		    
			$current_log .= "\n".$strCampaign."  ".phpAds_buildClientName ($campaign['clientid'], $campaign['clientname'], false)."\n";
			$current_log .= "=======================================================\n\n";
			
			while($row_banners = phpAds_dbFetchArray($res_banners))
			{
				$adviews = phpAds_totalViews($row_banners["bannerid"]);
		        $client["views_used"] = $adviews;
				$adclicks = phpAds_totalClicks($row_banners["bannerid"]);
				$campaign["clicks_used"] = $adclicks;
				
				
				$current_log .= $strBanner."  ".phpAds_buildBannerName ($row_banners['bannerid'], $row_banners['description'], $row_banners['alt'], 0, false)."\n";
				$current_log .= $strLinkedTo.": ".$row_banners['url']."\n";
				$current_log .= "-------------------------------------------------------\n";
				
				$active_banner_stats = false;
				
				if ($adviews > 0)
				{
					$current_log .= $strViews." (".$strTotal."):    ".$adviews."\n";
					
					// Fetch all adviews belonging to banner belonging to client, grouped by day
					if ($phpAds_config['compact_stats'])
						$res_adviews = phpAds_dbQuery("
							SELECT
								SUM(views) as qnt,
								DATE_FORMAT(day, '$date_format') as t_stamp_f,
								TO_DAYS(day) AS the_day
							FROM
								".$phpAds_config['tbl_adstats']."
							WHERE
								bannerid = ".$row_banners['bannerid']." AND
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
								".$phpAds_config['tbl_adviews']."
							WHERE
								bannerid = ".$row_banners['bannerid']." AND
								t_stamp >= $first_sqltimestamp AND
								t_stamp < $last_sqltimestamp
							GROUP BY
								the_day
							ORDER BY
								the_day DESC
							") or die($strLogErrorViews);
					
					if (phpAds_dbNumRows($res_adviews))
					{
						$total = 0;
						
						while($row_adviews = phpAds_dbFetchArray($res_adviews))
						{
							$current_log .= "      ".$row_adviews['t_stamp_f'].":   ".$row_adviews['qnt']."\n";
							$total += $row_adviews['qnt'];
						}
						
						$current_log .= $strTotalThisPeriod.": ".$total."\n";
						$active_banner_stats = true;
					}
					else
					{
						$current_log .= "      ".$strNoViewLoggedInInterval."\n";
					}
				}
				
				if ($adclicks > 0)
				{
					// Total adclicks
					$current_log .= "\n".$strClicks." (".$strTotal."):   ".$adclicks."\n";
					
					// Fetch all adclicks belonging to banner belonging to client, grouped by day
					if ($phpAds_config['compact_stats'])
						$res_adclicks = phpAds_dbQuery("
							SELECT
								SUM(clicks) as qnt,
								DATE_FORMAT(day, '$date_format') as t_stamp_f,
								TO_DAYS(day) AS the_day
							FROM
								".$phpAds_config['tbl_adstats']."
							WHERE
								bannerid = ".$row_banners['bannerid']." AND
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
								".$phpAds_config['tbl_adclicks']."
							WHERE
								bannerid = ".$row_banners['bannerid']." AND
								t_stamp >= $first_sqltimestamp AND
								t_stamp < $last_sqltimestamp
							GROUP BY
								the_day
							ORDER BY
								the_day DESC
							") or die("$strLogErrorClicks ".phpAds_dbError());
					
					if (phpAds_dbNumRows($res_adclicks))
					{
						$total = 0;
						
						while($row_adclicks = phpAds_dbFetchArray($res_adclicks))
						{
							$current_log .= "      ".$row_adclicks['t_stamp_f'].":   ".$row_adclicks['qnt']."\n";
							$total += $row_adclicks['qnt'];
						}
						
						$current_log .= $strTotalThisPeriod.": ".$total."\n";
						$active_banner_stats = true;
					}
					else
					{
						$current_log .= "      ".$strNoClickLoggedInInterval."\n";
					}
				}
				
				if ($adclicks == 0 && $adviews == 0)
				{
					$current_log .= "      ".$strNoStatsForCampaign."\n";
				}
				
				
				$current_log .= "\n\n";
				
				if ($campaign['active'] == 't' || $active_banner_stats == true)
					$active_banners = true;
			}
			
			if ($active_banners == true)
			{
				$active_campaigns = true;
				$log .= $current_log;
			}
		}
		
		
		// E-mail Stats to active clients
		if ($client["email"] != '' && $active_campaigns == true)
		{
			$Subject  = $strMailSubject.": ".$client["clientname"];
			
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
			$Body    = str_replace ("{adminfullname}", 	$phpAds_config['admin_fullname'], $Body);
			$Body	 = str_replace ("{startdate}", 		date(str_replace('%', '', $date_format), $first_unixtimestamp), $Body);
			$Body	 = str_replace ("{enddate}", 		date(str_replace('%', '', $date_format), $last_unixtimestamp), $Body);
			
			if ($phpAds_config['userlog_email']) 
				phpAds_userlogAdd (phpAds_actionAdvertiserReportMailed, $client['clientid'], $Subject."\n\n".$Body);
			
			if (phpAds_sendMail ($client['email'], $client['contact'], $Subject, $Body))
			{
				// Update last run
				if ($update == true)
					$res_update = phpAds_dbQuery("UPDATE ".$phpAds_config['tbl_clients']." SET reportlastdate=NOW() WHERE clientid=".$client['clientid']);
				
				return (true);
			}
		}
	}
	
	return (false);
}

?>