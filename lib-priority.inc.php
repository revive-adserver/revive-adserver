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


define('phpAds_CurrentHour', date('H'));

$debuglog = '';


function phpAds_PriorityGetImpressions($days, $offset)
{
	global $phpAds_config;
	
	$offset = $offset * (60 * 60 * 24);
	
	if ($phpAds_config['compact_stats'])
	{
		$begin = date('Ymd', mktime (0, 0, 0, date('m'), date('d'), date('Y')) - 1 - $offset);
		$end   = date('Ymd', mktime (0, 0, 0, date('m'), date('d'), date('Y')) - (60 * 60 * 24 * $days) - $offset);
		
		$query = "
			SELECT SUM(views) as sum_views
			FROM ".$phpAds_config['tbl_adstats']."
			WHERE day >= ".$begin."
			AND day <= ".$end."
		";
	}
	else
	{
		$begin = date('YmdHis', mktime (0, 0, 0, date('m'), date('d'), date('Y')) - 1 - $offset);
		$end   = date('YmdHis', mktime (0, 0, 0, date('m'), date('d'), date('Y')) - (60 * 60 * 24 * $days) - $offset);
		
		$query = "
			SELECT COUNT(*) as sum_views
			FROM ".$phpAds_config['tbl_adviews']."
			WHERE t_stamp >= ".$begin."
			AND t_stamp <= ".$end."
		";
	}

	$res = phpAds_dbQuery($query);
	
	return (phpAds_dbResult($res, 0, 'sum_views'));
}

function phpAds_PriorityGetHourlyProfile($days, $offset)
{
	global $phpAds_config;
	
	$profile = array (0, 0, 0, 0, 0, 0,
					  0, 0, 0, 0, 0, 0,
					  0, 0, 0, 0, 0, 0,
					  0, 0, 0, 0, 0, 0);
	
	// Determine days
	$offset = $offset * (60 * 60 * 24);
	
	if ($phpAds_config['compact_stats'])
	{
		$begin = date('Ymd', mktime (0, 0, 0, date('m'), date('d'), date('Y')) - 1 - $offset);
		$end   = date('Ymd', mktime (0, 0, 0, date('m'), date('d'), date('Y')) - (60 * 60 * 24 * $days) - $offset);
		
		$query = "
			SELECT hour, SUM(views) AS sum_views
			FROM ".$phpAds_config['tbl_adstats']."
			WHERE day <= ".$begin."
			AND day >= ".$end."
			GROUP BY hour
		";
	}
	else
	{
		$begin = date('YmdHis', mktime (0, 0, 0, date('m'), date('d'), date('Y')) - 1 - $offset);
		$end   = date('YmdHis', mktime (0, 0, 0, date('m'), date('d'), date('Y')) - (60 * 60 * 24 * $days) - $offset);
		
		$query = "
			SELECT HOUR(t_stamp) AS hour, COUNT(*) AS sum_views
			FROM ".$phpAds_config['tbl_adviews']."
			WHERE t_stamp <= ".$begin."
			AND t_stamp >= ".$end."
			GROUP BY hour
		";
	}
	
	$res = phpAds_dbQuery($query);
	
	while ($row = phpAds_dbFetchArray($res))
	{
		$profile [$row['hour']] = (int)$row['sum_views'];
	}
	
	return ($profile);
}

function phpAds_PriorityPredictProfile($campaigns, $banners)
{
	global $phpAds_config;
	global $debug, $debuglog;
	
	
	$real_profile = array (0, 0, 0, 0, 0, 0,
					  0, 0, 0, 0, 0, 0,
					  0, 0, 0, 0, 0, 0,
					  0, 0, 0, 0, 0, 0);
	
	$profile_correction_executed = false;
	
	// Get the number of days running
	if ($phpAds_config['compact_stats'])
	{
		$res = phpAds_dbQuery("SELECT UNIX_TIMESTAMP(MIN(day)) AS days_running FROM ".$phpAds_config['tbl_adstats']." WHERE day > 0 AND hour > 0");
		$days_running = phpAds_dbResult($res, 0, 'days_running');
	}
	else
	{
		$res = phpAds_dbQuery("SELECT UNIX_TIMESTAMP(MIN(t_stamp)) AS days_running FROM ".$phpAds_config['tbl_adviews']);
		$days_running = phpAds_dbResult($res, 0, 'days_running');
	}
	
	if ($days_running > 0)
	{
		$days_running = mktime (0, 0, 0, date('m'), date('d'), date('Y')) - $days_running;
		$days_running = round ($days_running / (60 * 60 * 24)) - 1;
	}
	else
		$days_running = 0;
	
	// BEGIN REPORTING
	$debuglog .= "-----------------------------------------------------\n";
	$debuglog .= "Number of days running: $days_running\n";
	// END REPORTING
	
	if ($days_running >= 8)
	{
		// determine the history
		if ($days_running > 13)
			$use_days = $days_running - 7;
		else
			$use_days = 6;
		
		// get total impressions last {$use_days} days
		$impressions_this_week = phpAds_PriorityGetImpressions ($use_days, 0);
		
		// get total impressions last {$use_days} days last week
		$impressions_last_week = phpAds_PriorityGetImpressions ($use_days, 7);
		
		// BEGIN REPORTING
		$debuglog .= "Using data from data from this week and last week\n";
		$debuglog .= "Days fetched: $use_days\n";
		$debuglog .= "Impressions up to this week: ".$impressions_this_week."\n";
		$debuglog .= "Impressions up to last week: ".$impressions_last_week."\n";
		// END REPORTING

		if ($impressions_last_week > 0)
		{
			// determine trend
			$trend = $impressions_this_week / $impressions_last_week;
			
			// get profile seven days ago
			$profile = phpAds_PriorityGetHourlyProfile (1, 7);
			
			// apply trend
			for ($i=0;$i<count($profile);$i++)
				$profile[$i] = (int)round ($profile[$i] * $trend);

			// BEGIN REPORTING
			$debuglog .= sprintf("Trend: %.4f\n", $trend);
			// END REPORTING
		}
		else
		{
			// no stats for last week, fall back to looking only at yesterday
			$days_running = 1;

			// BEGIN REPORTING
			$debuglog .= "No stats up to last week: days running set to 1\n";
			// END REPORTING
		}

		// BEGIN REPORTING
		$debuglog .= "-----------------------------------------------------\n\n\n";
		// END REPORTING
	}
	
	if ($days_running >= 2 && $days_running < 8)
	{
		// BEGIN REPORTING
		$debuglog .= "Using data from data from the last couple of days\n";
		$debuglog .= "-----------------------------------------------------\n\n\n";
		// END REPORTING

		// get last couple of days
		$profile = phpAds_PriorityGetHourlyProfile ($days_running, 0);
		
		// average
		for ($i=0;$i<count($profile);$i++)
			$profile[$i] = (int)round ($profile[$i] / $days_running);
	}
	
	if ($days_running == 1)
	{
		// BEGIN REPORTING
		$debuglog .= "Using data from data from yesterday\n";
		$debuglog .= "-----------------------------------------------------\n\n\n";
		// END REPORTING

		// get yesterday
		$profile = phpAds_PriorityGetHourlyProfile ($days_running, 0);
	}
	
	
	
	// BEGIN REPORTING
	$debuglog .= "PREDICTED PROFILE\n";
	$debuglog .= "-----------------------------------------------------\n";
	
	$debuglog .= phpAds_PriorityPrintProfile($profile);	
	
	$debuglog .= "\n\n\n";
	// END REPORTING
	
	
	
	if ($phpAds_config['compact_stats'])
	{
		$begin = date('Ymd', mktime (0, 0, 0, date('m'), date('d'), date('Y')));
		
		$query = "
			SELECT hour, SUM(views) AS sum_views
			FROM ".$phpAds_config['tbl_adstats']."
			WHERE day = ".$begin."
			AND hour < ".phpAds_CurrentHour."
			GROUP BY hour
		";
	}
	else
	{
		$begin = date('YmdHis', mktime (0, 0, 0, date('m'), date('d'), date('Y')));
		$end   = date('YmdHis', mktime (phpAds_CurrentHour, 0, 0, date('m'), date('d'), date('Y')) - 1);
		
		$query = "
			SELECT HOUR(t_stamp) AS hour, COUNT(*) AS sum_views
			FROM ".$phpAds_config['tbl_adviews']."
			WHERE t_stamp >= ".$begin."
			AND t_stamp <= ".$end."
			GROUP BY hour
		";
	}
	
	$res = phpAds_dbQuery($query);
	
	$real_up_till_now = 0;
	
	while ($row = phpAds_dbFetchArray($res))
	{
		$real_profile [$row['hour']] = $row['sum_views'];
		$real_up_till_now += $row['sum_views'];
	}
	
	
	// BEGIN REPORTING
	$debuglog .= "REAL VALUES UP TILL ".phpAds_CurrentHour.":00 \n";
	$debuglog .= "-----------------------------------------------------\n";
	
	$debuglog .= phpAds_PriorityPrintProfile($real_profile);	
	
	$debuglog .= "\n\n\n";
	// END REPORTING
	
	
	
	// Calculate total predicted profile
	$total_profile = 0;
	for ($i=0;$i<24;$i++)
		$total_profile += isset($profile[$i]) ? $profile[$i] : 0;
	
	// Adjust profile with real data
	if ($total_profile > 0)
	{
		if (phpAds_CurrentHour > 0)
		{
			$predicted_today = 0;
			for ($i=0;$i<24;$i++)
				$predicted_today += isset($profile[$i]) ? $profile[$i] : 0;
			
			$predicted_up_till_now = 0;
			for ($i=0;$i<phpAds_CurrentHour;$i++)
				$predicted_up_till_now += isset($profile[$i]) ? $profile[$i] : 0;
			
			$predicted_left_today = $predicted_today - $predicted_up_till_now;
			
			// BEGIN REPORTING
			$debuglog .= "Predicted impressions today: $predicted_today \n";
			$debuglog .= "Predicted impression up till now: $predicted_up_till_now \n";
			$debuglog .= "Predicted impressions left today: $predicted_left_today \n";
			$debuglog .= "-----------------------------------------------------\n";
			// END REPORTING
			
			// Adjust prediction for today
			if ($predicted_up_till_now > 0)
			{
				$importance_old = (sin(M_PI*(sin(M_PI*pow(phpAds_CurrentHour/24, 0.9)-M_PI/2)+1)/2-M_PI/2)+1)/2;				
				$deviance_old   = ($real_up_till_now / $predicted_up_till_now - 1) * $importance_old + 1;
				
				// Matteo
				$profile_correction_done = false;
				
				while (!$profile_correction_done)
				{
					for ($i=phpAds_CurrentHour;$i>0;$i--)
					{
						$deviance = phpAds_PriorityGetDeviance($i, $profile, $real_profile);
						
						if ($deviance > 2.25)
						{
							// BEGIN REPORTING
							$debuglog .= sprintf("Got deviance %.4f at %02d:00\n", $deviance, $i);
							// END REPORTING
							$k = $i > 1 ? $i - 1 : $i;
							
							while ($k && phpAds_PriorityGetDeviance($k, $profile, $real_profile) > $deviance)
							{
								// BEGIN REPORTING
								$debuglog .= sprintf("Got greater deviance (%.4f) at %02d:00\n", $deviance, $k);
								// END REPORTING
								$k--;
							}
							
							$deviance = (phpAds_PriorityGetDeviance($k, $profile, $real_profile) +
								phpAds_PriorityGetDeviance($k == phpAds_CurrentHour ? $k : $k+1, $profile, $real_profile)) / 2;
							
							for ($j=0;$j<$k;$j++)
							{
								$profile[$j] = ($profile[$j] ? $profile[$j] : 1) * $deviance;
								$profile_correction_executed = true;
							}
							
							break;
						}
						
						if ($i == 1)
							$profile_correction_done = true;
					}
				}
				
				if ($profile_correction_executed)
				{
					for ($i=0;$i<24;$i++)
						$profile[$i] = round($profile[$i]);
					
					$predicted_today = 0;
					for ($i=0;$i<24;$i++)
						$predicted_today += $profile[$i];
					
					$predicted_up_till_now = 0;
					for ($i=0;$i<phpAds_CurrentHour;$i++)
						$predicted_up_till_now += $profile[$i];
					
					$predicted_left_today = $predicted_today - $predicted_up_till_now;
				}
				
				$deviance   = phpAds_PriorityGetDeviance(phpAds_CurrentHour, $profile, $real_profile);
				
				// BEGIN REPORTING
				$debuglog .= "Importance factor: ".sprintf('%.4f (%.4f)', phpAds_PriorityGetImportance(phpAds_CurrentHour), $importance_old)." \n";
				$debuglog .= "Deviance: ".sprintf('%.4f (%.4f)', $deviance, $deviance_old)." \n";
				$debuglog .= "-----------------------------------------------------\n";
				
				if ($profile_correction_executed)
				{
					$debuglog .= "Predicted impressions today after correction: $predicted_today \n";
					$debuglog .= "Predicted impression up till now after correction: $predicted_up_till_now \n";
					$debuglog .= "Predicted impressions left today after correction: $predicted_left_today \n";
					
					$debuglog .= "\n\nNEW PREDICTED PROFILE\n";
					$debuglog .= "-----------------------------------------------------\n";
					
					$debuglog .= phpAds_PriorityPrintProfile($profile);	
					
					$debuglog .= "\n\n\n";
				}
				// END REPORTING
				
				$real_left_today = round($predicted_left_today * $deviance);
			}
			else
			{
				$real_left_today = $predicted_today;
			}
			
			// Create new profile based on new prediction
			// and real data
			$real_today = $real_left_today + $real_up_till_now;
			
			if ($predicted_left_today > 0)
				$adjustment = $real_left_today / $predicted_left_today;
			else
				$adjustment = 1;
			
			// BEGIN REPORTING
			$debuglog .= "Real impressions up till now: $real_up_till_now \n";
			// END REPORTING
			
			if ($predicted_up_till_now)
			{
				// BEGIN REPORTING
				$debuglog .= "Adjustment: $adjustment\n";
				$debuglog .= "Adjusted predicted impressions today: $real_today\n";
				$debuglog .= "Adjusted predicted impressions left today: $real_left_today\n";
				$debuglog .= "-----------------------------------------------------\n";
				// END REPORTING
			}
			
			if ($adjustment > 0)
			{
				for ($i=0;$i<24;$i++)
				{
					if ($i<phpAds_CurrentHour)
					{
						if (!$profile_correction_executed)
							$profile[$i] = (int)$real_profile[$i];
					}
					else
						$profile[$i] = (int)round($profile[$i] * $adjustment);
				}
			}
			elseif (!$profile_correction_executed) // ??????
			{
				for ($i=0;$i<phpAds_CurrentHour;$i++)
					$profile[$i] = (int)$real_profile[$i];
			}
		}
	}
	else
	{
		if ($real_up_till_now > 0 && phpAds_CurrentHour > 0)
		{
			$predicted_today = $real_up_till_now / phpAds_CurrentHour * 24;
			$predicted_left_today = $predicted_today - $real_up_till_now;
			$hours_left_today = 24 - phpAds_CurrentHour;
			
			for ($i=0;$i<24;$i++)
			{
				if ($i<phpAds_CurrentHour)
					$profile[$i] = isset($real_profile[$i]) ? $real_profile[$i] : 0;
				else
					$profile[$i] = (int)round($predicted_left_today / $hours_left_today);
			}
		}
		else
		{
			// No data available
			// Now it is time to make something up :)
			
			for ($i=0;$i<24;$i++)
			{
				if ($i<phpAds_CurrentHour)
					$profile[$i] = isset($real_profile[$i]) ? $real_profile[$i] : 0;
				else
					$profile[$i] = isset($total_target) ? (int)round($total_target / 24) : 0;
			}
		}
	}
	
	
	// Calculate total predicted profile
	$total_profile = 0;
	for ($i=0;$i<24;$i++)
		$total_profile += $profile[$i];
	
	// Calculate total impressions target
	$total_target = 0;
	for (reset($campaigns);$c=key($campaigns);next($campaigns))
		$total_target += $campaigns[$c]['target'];
	
	if ($total_profile == 0)
	{
		// No data available, profile is completely zero
		// create a profile to match campaign weights only
		
		$total_campaign_weight = 0;
		for (reset($campaigns);$c=key($campaigns);next($campaigns))
			$total_campaign_weight += $campaigns[$c]['weight'];
		
		$total_banner_weight = 0;
		for (reset($banners);$b=key($banners);next($banners))
			$total_banner_weight += $banners[$b]['weight'];
		
		$total_weight = $total_banner_weight * $total_campaign_weight;
		
		for ($i=0;$i<24;$i++)
			$profile[$i] = (int)$total_weight;
		
		
		$profile_correction_executed = false;
	}
	
	
	
	// BEGIN REPORTING
	$debuglog .= "\n\n\nADJUSTED PROFILE\n";
	$debuglog .= "-----------------------------------------------------\n";
	
	$debuglog .= phpAds_PriorityPrintProfile($profile);	
	
	$debuglog .= "\n\n\n";
	// END REPORTING
	
	return array ($profile, $profile_correction_executed);
}

function phpAds_PriorityPrepareCampaigns()
{
	global $phpAds_config;
	
	$campaigns = array();

	$query = "
		SELECT DISTINCT
			c.clientid AS clientid,
			c.weight AS weight,
			c.target AS target
		FROM
			".$phpAds_config['tbl_clients']." AS c,
			".$phpAds_config['tbl_banners']." AS b
		WHERE
			c.clientid = b.clientid AND
			c.parent > 0 AND
			c.active='t' AND
			b.active='t' AND
			(c.weight + c.target) > 0
	";
	
	$res = phpAds_dbQuery($query);
	
	while ($row = phpAds_dbFetchArray($res))
	{
		$campaigns[$row['clientid']] = $row;
	}

	return $campaigns;
}

function phpAds_PriorityPrepareBanners()
{
	global $phpAds_config;
	
	$banners = array();
	
	// Get all banners
	$query = "
		SELECT bannerid, weight, clientid AS parent
		FROM ".$phpAds_config['tbl_banners']."
		WHERE active='t' AND weight > 0
	";
	
	$res = phpAds_dbQuery($query);
	
	while ($row = phpAds_dbFetchArray($res))
	{
		$banners[$row['bannerid']] = $row;
	}
	
	
	// Get statistics
	if ($phpAds_config['compact_stats'])
	{
		$begin = date ('Ymd', mktime (0, 0, 0, date('m'), date('d'), date('Y')));
		$end   = date ('Ymd', mktime (phpAds_CurrentHour, 0, 0, date('m'), date('d'), date('Y')) - 1);
		
		$query = "
			SELECT bannerid, SUM(views) as sum_views
			FROM ".$phpAds_config['tbl_adstats']."
			WHERE day = ".$begin."
			AND hour < ".phpAds_CurrentHour."
			GROUP BY bannerid
		";
	}
	else
	{
		$begin = date ('YmdHis', mktime (0, 0, 0, date('m'), date('d'), date('Y')));
		$end   = date ('YmdHis', mktime (phpAds_CurrentHour, 0, 0, date('m'), date('d'), date('Y')) - 1);
		
		$query = "
			SELECT bannerid, count(*) as sum_views
			FROM ".$phpAds_config['tbl_adviews']."
			WHERE t_stamp >= ".$begin."
			AND t_stamp <= ".$end."
			GROUP BY bannerid
		";
	}
	
	$res = phpAds_dbQuery($query);
	
	while ($row = phpAds_dbFetchArray($res))
	{
		if (isset($banners[$row['bannerid']]))
		{
			$banners[$row['bannerid']]['hits'] = $row['sum_views'];
		}
	}
	
	return $banners;
}


function phpAds_PriorityStore($banners)
{
	global $phpAds_config;
	
	// Reset existing priorities
	$query = "
		UPDATE ".$phpAds_config['tbl_banners']."
		SET priority = 0
	";
	
	$res = phpAds_dbQuery($query);
	
	// Set correct priority
	for (reset($banners);$b=key($banners);next($banners))
	{
		$query = "
			UPDATE ".$phpAds_config['tbl_banners']."
			SET priority = ".(isset($banners[$b]['priority']) ? $banners[$b]['priority'] : 0)."
			WHERE bannerid = ".$banners[$b]['bannerid']."
		";
		
		$res = phpAds_dbQuery($query);
	}
}


function phpAds_PriorityCalculate()
{
	global $debug, $debuglog;
	
	// Prepare information
	$banners   = phpAds_PriorityPrepareBanners();
	$campaigns = phpAds_PriorityPrepareCampaigns();
	$profile   = array();
	
	// Determine period
	$maxperiod = 24;
	$period = phpAds_CurrentHour;
	
	// Populate campaign statistics
	$total_requested 	 = 0;
	$total_weight 		 = 0;
	$total_targeted_hits = 0;
	$total_other_hits 	 = 0;
	
	
	for (reset($campaigns);$c=key($campaigns);next($campaigns))
	{
		$targeted_hits = 0;
		$other_hits    = 0;
		
		if ($campaigns[$c]['target'] > 0)
		{
			for (reset($banners);$b=key($banners);next($banners))
				if ($banners[$b]['parent'] == $c)
					$targeted_hits += isset($banners[$b]['hits']) ? $banners[$b]['hits'] : 0;
			
			$total_targeted_hits += $targeted_hits;
			$total_requested 	 += $campaigns[$c]['target'];
		}
		else
		{
			$bannercount = 0;
			
			for (reset($banners);$b=key($banners);next($banners))
				if ($banners[$b]['parent'] == $c)
				{
					$other_hits += isset($banners[$b]['hits']) ? $banners[$b]['hits'] : 0;
					$bannercount++;
				}
			
			$total_other_hits    += $other_hits;
			
			if ($bannercount > 0)
				$total_weight    += $campaigns[$c]['weight'];
		}
		
		$campaigns[$c]['hits'] = $targeted_hits + $other_hits;
	}
	
	if ($total_requested)
	{
		// High pri campaigns present, run profiling
		list($profile, $profile_correction_executed) = phpAds_PriorityPredictProfile($campaigns, $banners);
		
		
		// Determine estimated number of hits
		$corrected_hits = 0;
		$estimated_hits = 0;
		for ($p=0; $p<24; $p++)
		{
			$corrected_hits += $profile_correction_executed && $p < phpAds_CurrentHour ? $profile[$p] : 0;
			$estimated_hits += $profile[$p];
		}
		
		// Apply correction to other hits
		if ($profile_correction_executed)
		{
			// BEGIN REPORTING
			$debuglog .= "\n\n";
			$debuglog .= "Removed ".($total_targeted_hits+$total_other_hits-$corrected_hits)." hits added during peak compensation\n";
			// END REPORTING
			
			$total_other_hits = $corrected_hits - $total_targeted_hits;
		}
		
		$total_hits 		  = $total_targeted_hits + $total_other_hits;
		$estimated_remaining  = $estimated_hits - $total_hits;
		$requested_remaining  = $total_requested - $total_targeted_hits;
		
		
		if ($estimated_remaining > $requested_remaining)
		{
			$available_for_targeting = $requested_remaining;
			$available_for_others    = $estimated_remaining - $requested_remaining;
		}
		else
		{
			$available_for_targeting = $estimated_remaining;
			$available_for_others    = 0;
		}
		
		// BEGIN REPORTING
		$debuglog .= "\n\n";
		$debuglog .= "Estimated number of impressions today: $estimated_hits \n";
		$debuglog .= "Estimated number of impressions remaining: $estimated_remaining \n";
		$debuglog .= "-----------------------------------------------------\n";
		$debuglog .= "Total number of requested impressions: $total_requested \n";
		$debuglog .= "Number of requested impressions satisfied: $total_targeted_hits \n";
		$debuglog .= "Number of requested impressions remaining: $requested_remaining \n";
		$debuglog .= "-----------------------------------------------------\n\n\n";
		$debuglog .= "Impressions available to meet the targets: $available_for_targeting \n";
		$debuglog .= "Impressions left over: $available_for_others \n";
		$debuglog .= "-----------------------------------------------------\n";
		// END REPORTING
		
		$totalassigned = 0;
		
		for (reset($campaigns);$c=key($campaigns);next($campaigns))
		{
			if ($campaigns[$c]['target'] > 0)
			{
				// BEGIN REPORTING
				$debuglog .= "\n\n\nCAMPAIGN $c \n";
				$debuglog .= "-----------------------------------------------------\n";
				// END REPORTING
				
				
				// Hits assigned  = 
				$remaining_for_campaign 	= $campaigns[$c]['target'] - $campaigns[$c]['hits'];
				
				// Determine expected hits uptil period
				if (!isset($profile[$period]) || $profile[$period] == 0)
				{
					$expected_hits_this_period  = round($campaigns[$c]['target'] / $maxperiod * ($period));
				}
				else
				{
					$total_profile = 0;
					for ($p=0;$p<$maxperiod;$p++)
						$total_profile += $profile[$p];
					
					$profile_uptil_now = 0;
					for ($p=0;$p<phpAds_CurrentHour;$p++)
						$profile_uptil_now += $profile[$p];
					
					$expected_hits_this_period = round ($profile_uptil_now / $total_profile * $campaigns[$c]['target']);
				}
				
				// BEGIN REPORTING
				$debuglog .= "Remaining for campaign: $remaining_for_campaign \n";
				$debuglog .= "Real impressions up till now: ".$campaigns[$c]['hits']." \n";
				$debuglog .= "Expected impressions up till now: $expected_hits_this_period \n";
				// END REPORTING
				
				if ($period > 0)
					$extra_to_assign = $expected_hits_this_period - $campaigns[$c]['hits'];
				else
					$extra_to_assign = 0;
				
				$extra_to_assign  		 = $extra_to_assign * ($maxperiod - $period);
				$remaining_for_campaign += $extra_to_assign;
				
				if ($remaining_for_campaign < 0)
					$remaining_for_campaign = 0;
				
				// BEGIN REPORTING
				$debuglog .= "Compensate by: $extra_to_assign \n";
				$debuglog .= "Priority for whole campaign: $remaining_for_campaign \n";
				// END REPORTING
				
				$totalassigned 			+= $remaining_for_campaign;
				
				$total_banner_weight     = 0;
				for (reset($banners);$b=key($banners);next($banners))
					if ($banners[$b]['parent'] == $c)
						$total_banner_weight += $banners[$b]['weight'];
				
				for (reset($banners);$b=key($banners);next($banners))
					if ($banners[$b]['parent'] == $c)
					{
						$banners[$b]['priority'] = round ($remaining_for_campaign / $total_banner_weight * $banners[$b]['weight']);
						
						// BEGIN REPORTING
						$debuglog .= "- Priority of banner $b: ".$banners[$b]['priority']." \n";
						// END REPORTING
					}
			}
		}
		
		//$available_for_others = $estimated_remaining - $totalassigned;
		
		
		// BEGIN REPORTING
		$debuglog .= "\n\n\n";
		$debuglog .= "Impressions assigned to meet the targets: $totalassigned \n";
		// END REPORTING
	}	
	else
	{
		// BEGIN REPORTING
		$debuglog .= "-----------------------------------------------------\n";
		$debuglog .= "No targeding needed, skipping profile prediction.\n";
		// END REPORTING
		
		$total_campaign_weight = 0;
		for (reset($campaigns);$c=key($campaigns);next($campaigns))
			$total_campaign_weight += $campaigns[$c]['weight'];
		
		$total_banner_weight = 0;
		for (reset($banners);$b=key($banners);next($banners))
			$total_banner_weight += $banners[$b]['weight'];
		
		$available_for_others = $total_banner_weight * $total_campaign_weight;
	}
		
		// BEGIN REPORTING
	$debuglog .= "Impressions left over: $available_for_others \n";
	$debuglog .= "-----------------------------------------------------\n";
	// END REPORTING

	for (reset($campaigns);$c=key($campaigns);next($campaigns))
	{
		if ($campaigns[$c]['target'] == 0)
		{
			// BEGIN REPORTING
			$debuglog .= "\n\n\nCAMPAIGN $c \n";
			$debuglog .= "-----------------------------------------------------\n";
			// END REPORTING
			
			
			if ($available_for_others > 0)
				$remaining_for_campaign = round ($available_for_others / $total_weight * $campaigns[$c]['weight']);
			else
				$remaining_for_campaign = 0;
			
			// BEGIN REPORTING
			$debuglog .= "Remaining for campaign: $remaining_for_campaign \n";
			// END REPORTING
			
			$total_banner_weight = 0;
			for (reset($banners);$b=key($banners);next($banners))
				if ($banners[$b]['parent'] == $c)
					$total_banner_weight += $banners[$b]['weight'];
			
			for (reset($banners);$b=key($banners);next($banners))
				if ($banners[$b]['parent'] == $c)
				{
					$banners[$b]['priority'] = round ($remaining_for_campaign / $total_banner_weight * $banners[$b]['weight']);
					
					// BEGIN REPORTING
					$debuglog .= "- Assigned priority to banner $b: ".$banners[$b]['priority']." \n";
					// END REPORTING
				}
		}
	}
	
	// Store priority information
	phpAds_PriorityStore($banners);
	
	return ($debuglog);
}



function phpAds_PriorityGetImportance($hour)
{
	$importance = (sin(M_PI*pow($hour/24, 0.9)-M_PI/2)+1)/2;
	$importance = (sin(M_PI*$importance-M_PI/2)+1)/2;
	
	return $importance;
}



function phpAds_PriorityGetDeviance($hour, $profile, $real_profile)
{
	$predicted = 0;
	$real = 0;
	
	for ($i=0;$i<$hour;$i++)
	{
		$predicted += isset($profile[$i]) ? $profile[$i] : 0;
		$real += isset($real_profile[$i]) ? $real_profile[$i] : 0;
	}
	
	if (!$predicted)
		$predicted = 0.1;
	
	return (($real / $predicted)-1) * phpAds_priorityGetImportance($hour) + 1;
}

function phpAds_PriorityPrintProfile($profile)
{
	$debuglog = '';

	for ($i=0;$i<24;$i++)
	{
		if ($i && !($i % 6))
			$debuglog .= "\n";

		$debuglog .= sprintf('%7d', isset($profile[$i]) ? $profile[$i] : '0')."  ";
	}

	return $debuglog;
}

?>