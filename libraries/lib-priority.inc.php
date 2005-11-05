<?php // $Revision$

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2000-2005 by the phpAdsNew developers                  */
/* For more information visit: http://www.phpadsnew.com                 */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/


// Set define to prevent duplicate include
define ('LIBPRIORITY_INCLUDED', true);


// Defaults
define('phpAds_CurrentHour', (int)date('H'));
$debuglog = '';


function phpAds_PriorityGetImpressions($days, $offset)
{
	global $phpAds_config;
	
	$offset = $offset * (60 * 60 * 24);
	
	if ($phpAds_config['compact_stats'])
	{
		$begin = date('Ymd', phpAds_makeTimestamp(mktime (0, 0, 0, date('m'), date('d'), date('Y')), - 1 - $offset));
		$end   = date('Ymd', phpAds_makeTimestamp(mktime (0, 0, 0, date('m'), date('d'), date('Y')), - (60 * 60 * 24 * $days) - $offset));
		
		$query = "
			SELECT SUM(views) as sum_views
			FROM ".$phpAds_config['tbl_adstats']."
			WHERE day <= ".$begin."
			AND day >= ".$end."
		";
	}
	else
	{
		$begin = date('YmdHis', phpAds_makeTimestamp(mktime (0, 0, 0, date('m'), date('d'), date('Y')), - 1 - $offset));
		$end   = date('YmdHis', phpAds_makeTimestamp(mktime (0, 0, 0, date('m'), date('d'), date('Y')), - (60 * 60 * 24 * $days) - $offset));
		
		$query = "
			SELECT COUNT(*) as sum_views
			FROM ".$phpAds_config['tbl_adviews']."
			WHERE t_stamp <= ".$begin."
			AND t_stamp >= ".$end."
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
		$begin = date('Ymd', phpAds_makeTimestamp(mktime (0, 0, 0, date('m'), date('d'), date('Y')), - 1 - $offset));
		$end   = date('Ymd', phpAds_makeTimestamp(mktime (0, 0, 0, date('m'), date('d'), date('Y')), - (60 * 60 * 24 * $days) - $offset));
		
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
		$begin = date('YmdHis', phpAds_makeTimestamp(mktime (0, 0, 0, date('m'), date('d'), date('Y')), - 1 - $offset));
		$end   = date('YmdHis', phpAds_makeTimestamp(mktime (0, 0, 0, date('m'), date('d'), date('Y')), - (60 * 60 * 24 * $days) - $offset));
		
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
		$res = phpAds_dbQuery("SELECT UNIX_TIMESTAMP(MIN(day)) AS days_running FROM ".$phpAds_config['tbl_adstats']);
		$days_running = phpAds_dbResult($res, 0, 'days_running');
	}
	else
	{
		$res = phpAds_dbQuery("SELECT UNIX_TIMESTAMP(MIN(t_stamp)) AS days_running FROM ".$phpAds_config['tbl_adviews']);
		$days_running = phpAds_dbResult($res, 0, 'days_running');
	}
	
	if ($days_running > 0)
	{
		$now = mktime (0, 0, 0, date('m'), date('d'), date('Y'));
		$days_running = $now - $days_running + (date('I', $days_running) - date('I', $now)) * 60;
		$days_running = round ($days_running / (60 * 60 * 24)) - 1;
	}
	
	if ($days_running < 0)
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
			
			if ($days_running > 9)
			{
				// get profile using a normal distribution
				$profile = phpAds_PriorityGetGaussianProfile ($days_running);

				// BEGIN REPORTING
				$debuglog .= "Using gaussian profile prediction\n";
				// END REPORTING
			}
			else
			{
				// get profile seven days ago
				$profile = phpAds_PriorityGetHourlyProfile (1, 6);
			}
			
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
	
	if (!$days_running)
	{
		// BEGIN REPORTING
		$debuglog .= "There's no data to predict a profile\n";
		$debuglog .= "-----------------------------------------------------\n\n\n";
		// END REPORTING
	}

	
	
	// BEGIN REPORTING
	if (isset($profile))
	{
		$debuglog .= "PREDICTED PROFILE\n";
		$debuglog .= "-----------------------------------------------------\n";
		
		$debuglog .= phpAds_PriorityPrintProfile($profile);	
		
		$debuglog .= "\n\n\n";
	}
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
				$importance = (sin(M_PI*(sin(M_PI*pow(phpAds_CurrentHour/24, 0.9)-M_PI/2)+1)/2-M_PI/2)+1)/2;				
				$deviance_old   = ($real_up_till_now / $predicted_up_till_now - 1) * $importance + 1;
				
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
				$debuglog .= "Importance factor: ".sprintf('%.4f', phpAds_PriorityGetImportance(phpAds_CurrentHour))." \n";
				$debuglog .= "Deviance: ".sprintf('%.4f (%.4f before correction)', $deviance, $deviance_old)." \n";
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
				$debuglog .= sprintf("Adjustment: %.4f\n", $adjustment);
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
	foreach (array_keys($campaigns) as $c)
		$total_target += $campaigns[$c]['target'];
	
	if ($total_profile == 0)
	{
		// No data available, profile is completely zero
		// create a profile to match campaign weights only
		
		$total_weight = phpAds_PriorityTotalWeight($campaigns, $banners);
		
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
			c.target AS target,
			c.active AS active
		FROM
			".$phpAds_config['tbl_clients']." AS c,
			".$phpAds_config['tbl_banners']." AS b
		WHERE
			c.clientid = b.clientid AND
			c.parent > 0 AND
			c.active='t' AND
			b.active='t' AND
			(c.weight + c.target) > 0
			ORDER BY clientid
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
		ORDER BY bannerid
	";
	
	$res = phpAds_dbQuery($query);
	
	while ($row = phpAds_dbFetchArray($res))
	{
		$banners[$row['bannerid']] = $row;
		$banners[$row['bannerid']]['priority'] = 0;
		$banners[$row['bannerid']]['hits'] = 0;
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


function phpAds_PriorityStore($banners, $campaigns = '')
{
	global $phpAds_config;
	
	if (!is_array($campaigns))
		$campaigns = array();

	// Reset existing priorities
	$query = "
		UPDATE ".$phpAds_config['tbl_banners']."
		SET priority = 0
	";
	
	$res = phpAds_dbQuery($query);
	
	// Set correct priority
	foreach (array_keys($banners) as $b)
	{
		$query = "
			UPDATE ".$phpAds_config['tbl_banners']."
			SET priority = ".(isset($banners[$b]['priority']) ? $banners[$b]['priority'] : 0)."
			WHERE bannerid = ".$banners[$b]['bannerid']."
		";
		
		$res = phpAds_dbQuery($query);
	}
	
	// Update targetstats at midnight
	if (phpAds_CurrentHour == 0)
	{
		foreach (array_keys($campaigns) as $c)
		{
			if ($campaigns[$c]['target'])
				phpAds_dbQuery("
					INSERT INTO ".$phpAds_config['tbl_targetstats']."
						(day, clientid, target)
					VALUES
						(NOW(), ".$campaigns[$c]['clientid'].", ".$campaigns[$c]['target'].")
				");
		}
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
	$total_campaign_weight 		 = 0;
	$total_targeted_hits = 0;
	$total_other_hits 	 = 0;
	
	foreach (array_keys($campaigns) as $c)
	{
		$targeted_hits = 0;
		$other_hits    = 0;
		
		if ($campaigns[$c]['target'] > 0)
		{
			foreach (array_keys($banners) as $b)
				if ($banners[$b]['parent'] == $c)
					$targeted_hits += isset($banners[$b]['hits']) ? $banners[$b]['hits'] : 0;
			
			$total_targeted_hits += $targeted_hits > $campaigns[$c]['target'] ? $campaigns[$c]['target'] : $targeted_hits;
			$total_requested 	 += $campaigns[$c]['target'];
		}
		else
		{
			$bannercount = 0;
			
			foreach (array_keys($banners) as $b)
				if ($banners[$b]['parent'] == $c)
				{
					$other_hits += isset($banners[$b]['hits']) ? $banners[$b]['hits'] : 0;
					$bannercount++;
				}
			
			$total_other_hits    += $other_hits;
			
			if ($bannercount > 0)
				$total_campaign_weight    += $campaigns[$c]['weight'];
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
			$debuglog .= abs($total_targeted_hits+$total_other_hits-$corrected_hits)." hits were ".
				(($total_targeted_hits+$total_other_hits-$corrected_hits) > 0 ? "added" : "removed").
				" during peak compensation\n";
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
		
		foreach (array_keys($campaigns) as $c)
		{
			if ($campaigns[$c]['target'] > 0)
			{
				// BEGIN REPORTING
				$debuglog .= "\n\n\nHIGH-PRI CAMPAIGN $c \n";
				$debuglog .= "-----------------------------------------------------\n";
				// END REPORTING
				
				
				// Hits assigned  = 
				$remaining_for_campaign 	= $campaigns[$c]['target'] - $campaigns[$c]['hits'];
				
				$total_profile = 0;
				for ($p=0;$p<$maxperiod;$p++)
					$total_profile += isset($profile[$p]) ? $profile[$p] : 0;

				$profile_uptil_now = 0;
				for ($p=0;$p<$period;$p++)
					$profile_uptil_now += isset($profile[$p]) ? $profile[$p] : 0;
					
					
				if ($total_profile == 0)
				{
					// No profile available yet, just divide evently
					$expected_hits_this_period  = round($campaigns[$c]['target'] / $maxperiod * ($period + 1));
				}
				else
				{
					if ($profile[$period] == 0)
					{
						// Profile available, but no impressions expected this hour
						// Set the number of expected hits to 1, to make sure the campaign isn't deactivated
						// and the real impressions won't bring it much of target
						$expected_hits_this_period = 1;
					}
					else
					{	
						// Profile available, use expected impressions
						$expected_hits_this_period = round ($profile_uptil_now / $total_profile * $campaigns[$c]['target']);
						
						if (!$expected_hits_this_period) $expected_hits_this_period = 1;
					}
				}
				
				// BEGIN REPORTING
				$debuglog .= "Target for campaign: ".$campaigns[$c]['target']." \n";
				$debuglog .= "Remaining for campaign: $remaining_for_campaign \n";
				// END REPORTING
				
				
				if ($period > 0)
				{
					// The first time the priority calculation is running there is no
					// need to compensate, since there are no previous hours available
					
					$current_deviance_from_prediction  = $campaigns[$c]['hits'] / $expected_hits_this_period; // > 1 = overdelivery, < 1 = underdelivery
					$expected_today_without_correction = $campaigns[$c]['target'] * $current_deviance_from_prediction;
					$expected_deviance_todays_in_hits  = $expected_today_without_correction - $campaigns[$c]['target'];
					
					// BEGIN REPORTING
					$debuglog .= "Real impressions up till now: ".$campaigns[$c]['hits']." \n";
					$debuglog .= "Expected impressions up till now: $expected_hits_this_period \n";
					$debuglog .= "Deviance from prediction: ".$current_deviance_from_prediction."x \n";
					$debuglog .= "Total impressions expected without correction: $expected_today_without_correction \n";
					$debuglog .= "Total deviance expected without correction: $expected_deviance_todays_in_hits \n";
					// END REPORTING
	
					$aggression = 2; // The deviance needs to be fixed in the remaining hours / agression
					
					$fix_in_no_hours = round(($maxperiod - $period) / $aggression);
					$extra_to_assign = 0 - ($expected_deviance_todays_in_hits / $fix_in_no_hours);
					
					// BEGIN REPORTING
					$debuglog .= "Deviance needs to fixed in: $fix_in_no_hours hours (aggression ".$aggression.")\n";
					$debuglog .= "Compensate linear by: $extra_to_assign \n";
					// END REPORTING
					
					// Find out how many impressions the next hour will generate compared
					// to the other hours (according to predictions).
					
					$total_next_hours = 0;
					for ($p = $period; $p < $period + $fix_in_no_hours; $p++)
						$total_next_hours += isset($profile[$p]) ? $profile[$p] : 0;
					
					if ($avg_impressions_per_hour = $total_next_hours / $fix_in_no_hours)
					{
						$compensation_factor = $profile[$period] / $avg_impressions_per_hour;
						$extra_to_assign = round($compensation_factor * $extra_to_assign);
					}
					else
					{
						$compensation_factor = 'n.a.';
						$extra_to_assign = 0;
					}
					
					
					// BEGIN REPORTING
					$debuglog .= "Average impressions per hour: ".$avg_impressions_per_hour."\n";
					$debuglog .= "Expected impressions next hour: ".$profile[$period]."\n";
					$debuglog .= "Deviance from average: ".$compensation_factor."\n";
					$debuglog .= "Compensate realisticly by: $extra_to_assign \n";
					// END REPORTING

					$remaining_for_campaign += $extra_to_assign;
				
					if ($remaining_for_campaign < 0)
						$remaining_for_campaign = 0;
				}
				
				
				// BEGIN REPORTING
				$debuglog .= "Priority for whole campaign: $remaining_for_campaign \n";
				// END REPORTING

				$totalassigned 			+= $remaining_for_campaign;
				
				$total_banner_weight     = 0;
				foreach (array_keys($banners) as $b)
					if ($banners[$b]['parent'] == $c)
						$total_banner_weight += $banners[$b]['weight'];
				
				foreach (array_keys($banners) as $b)
					if ($banners[$b]['parent'] == $c)
					{
						$banners[$b]['priority'] = round ($remaining_for_campaign / $total_banner_weight * $banners[$b]['weight']);
						
						// BEGIN REPORTING
						$debuglog .= "- Priority of banner $b: ".$banners[$b]['priority']." \n";
						// END REPORTING
					}
			}
		}

		// BEGIN REPORTING
		$debuglog .= "\n\n\n";
		$debuglog .= "Impressions assigned to meet the targets: $totalassigned \n";
		// END REPORTING

		$no_high_pri = !$totalassigned;
	}	
	else
	{
		// BEGIN REPORTING
		$debuglog .= "-----------------------------------------------------\n";
		$debuglog .= "No targeting needed, skipping profile prediction.\n";
		$debuglog .= "-----------------------------------------------------\n";
		// END REPORTING
		
		$no_high_pri = true;
	}

	$total_weight =  phpAds_PriorityTotalWeight($campaigns, $banners);

	if ($no_high_pri || !$available_for_others)
	{
		// BEGIN REPORTING


		if ($no_high_pri)
		{
			$debuglog .= "\n\n\nNo impressions assigned to meet the targets\n";
		}
		else
		{
			$debuglog .= "\n\n\nNo or few impressions left over, this would result\n";
			$debuglog .= "in low-priority banners never shown\n";
		}

		$debuglog .= "Total weight: $total_weight\n";
		// END REPORTING

		// Use total weight as avaliable impressions for low-pri
		$available_for_others = $total_weight;

		// Boost high-pri banners by total_weight
		$high_pri_boost = $total_weight;
	}
	else
	{
		// No boost
		$high_pri_boost = 1;
	}


	// Init array for GCD calculation
	$banner_priorities = array();

	// Flag used when a campaign gets a null priority
	$zero_pri = false;

	// BEGIN REPORTING
	$debuglog .= "Impressions left over: $available_for_others \n";
	$debuglog .= "-----------------------------------------------------\n";
	// END REPORTING

	$loop_ok = false;
	
	while (!$loop_ok)
	{
		foreach (array_keys($campaigns) as $c)
		{
			if ($campaigns[$c]['target'] == 0)
			{
				// BEGIN REPORTING
				$debuglog .= "\n\n\nLOW-PRI CAMPAIGN $c \n";
				$debuglog .= "-----------------------------------------------------\n";
				// END REPORTING
				
				
				if ($available_for_others > 0)
					$remaining_for_campaign = round ($available_for_others / $total_campaign_weight * $campaigns[$c]['weight']);
				else
					$remaining_for_campaign = 0;
				
				// BEGIN REPORTING
				$debuglog .= "Remaining for campaign: $remaining_for_campaign \n";
				// END REPORTING
				
				$total_banner_weight = 0;
				foreach (array_keys($banners) as $b)
					if ($banners[$b]['parent'] == $c)
						$total_banner_weight += $banners[$b]['weight'];
				
				foreach (array_keys($banners) as $b)
					if ($banners[$b]['parent'] == $c)
					{
						$banners[$b]['priority'] = round ($remaining_for_campaign / $total_banner_weight * $banners[$b]['weight']);
						
						if (!$banners[$b]['priority'])
						{
							// BEGIN REPORTING
							$debuglog .= "- Banner $b had a null priority.\n";
							// END REPORTING
	
							$zero_pri = true;
							break;
						}
					
						$banner_priorities[] = $banners[$b]['priority'];
						
						// BEGIN REPORTING
						$debuglog .= "- Assigned priority to banner $b: ".$banners[$b]['priority']." \n";
						// END REPORTING
					}
			}
	
			if ($zero_pri)
			{
				if (!$available_for_others)
				{
					// It should never get here, but avoid an endless loop to be safe...
					break;
				}
	
				// Restart low-pri assignment, increasing available impressions
				$zero_pri = false;
				$banner_priorities = array();
				
				$available_for_others *= 2;
				$high_pri_boost *= 2;
	
				// BEGIN REPORTING
				$debuglog .= "\n\n\n-----------------------------------------------------\n";
				$debuglog .= "Restarting...\n";
				$debuglog .= "-----------------------------------------------------\n";
				$debuglog .= "\n\n\nImpressions left over: $available_for_others \n";
				$debuglog .= "-----------------------------------------------------\n";
				// END REPORTING
	
				// Restart loop
				break;
			}
		}
		
		$loop_ok = true;
	}
			
	if ($high_pri_boost > 1 && !$no_high_pri && $total_weight)
	{
		// We need to raise high-pri priorities to reduce the side-effect
		// introduced increasing remaining impressions for low-pri campaigns

		// BEGIN REPORTING
		$debuglog .= "\n\n\n-----------------------------------------------------\n";
		$debuglog .= "HIGH PRIORITY CAMPAIGNS BOOST ENABLED\n";
		$debuglog .= "-----------------------------------------------------\n";
		// END REPORTING

		// Try to find a GCD to avoid to reduce priority values
		$banner_priorities[] = $high_pri_boost;
		$gcd = phpAds_PriorityGetGCD($banner_priorities);

		if ($gcd > 1)
		{
			// A GCD was found, we can lower boost rate and low-pri priorities

			$high_pri_boost /= $gcd;

			// BEGIN REPORTING
			$debuglog .= "GCD PRIORITY SOFTENER ENABLED\n";
			$debuglog .= "-----------------------------------------------------\n";
			// END REPORTING
		}
		
		foreach (array_keys($campaigns) as $c)
		{
			if ($campaigns[$c]['target'] > 0)
			{
				// BEGIN REPORTING
				$debuglog .= "\n\n\nHIGH-PRI CAMPAIGN $c \n";
				$debuglog .= "-----------------------------------------------------\n";
				// END REPORTING

				foreach (array_keys($banners) as $b)
					if ($banners[$b]['parent'] == $c)
					{
						// BEGIN REPORTING
						$debuglog .= "- Assigned priority to banner $b: ".$banners[$b]['priority']." * $high_pri_boost = ";
						// END REPORTING

						$banners[$b]['priority'] *= $high_pri_boost;
					
						// BEGIN REPORTING
						$debuglog .= $banners[$b]['priority']."\n";
						// END REPORTING
					}
			}
			elseif ($gcd > 1)
			{
				// BEGIN REPORTING
				$debuglog .= "\n\n\nLOW-PRI CAMPAIGN $c \n";
				$debuglog .= "-----------------------------------------------------\n";
				// END REPORTING

				foreach (array_keys($banners) as $b)
					if ($banners[$b]['parent'] == $c)
					{
						// BEGIN REPORTING
						$debuglog .= "- Assigned priority to banner $b: ".$banners[$b]['priority']." / $gcd = ";
						// END REPORTING

						$banners[$b]['priority'] /= $gcd;
					
						// BEGIN REPORTING
						$debuglog .= $banners[$b]['priority']."\n";
						// END REPORTING
					}
			}
		}
	}



	$priority_sum = 0;
	foreach ($banners as $b)
		$priority_sum += $b['priority'];
	
	if ($priority_sum)
	{
		$softener = 1;
		
		while (($priority_sum/$softener) > 0x7ffffffe)
			$softener *= 2;
		
		if ($softener > 1)
		{
			$debuglog .= "\n\n\n-----------------------------------------------------\n";
			$debuglog .= "OVERFLOW SOFTENER ENABLED\n";
			$debuglog .= "-----------------------------------------------------\n\n\n\n";
			
			foreach (array_keys($banners) as $b)
			{
				// BEGIN REPORTING
				$debuglog .= "- Assigned priority to banner $b: ".$banners[$b]['priority']." / $softener = ";
				// END REPORTING

				$roundto1 = $banners[$b]['priority'] > 0;

				$banners[$b]['priority'] = round($banners[$b]['priority'] / $softener);

				if ($roundto1 && !$banners[$b]['priority'])
				{
					$banners[$b]['priority'] = 1;

					// BEGIN REPORTING
					$debuglog .= '0, rounding up to ';
					// END REPORTING
				}

				// BEGIN REPORTING
				$debuglog .= $banners[$b]['priority']."\n";
				// END REPORTING
			}
		}
	}


	// Store priority information
	phpAds_PriorityStore($banners, $campaigns);
	
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



function phpAds_PriorityTotalWeight($campaigns, $banners)
{
	$tcw = 0;
	$tbw = array();
	$pr  = array();
	
	// Get total campaign weight
	foreach (array_keys($campaigns) as $c)
	{
		$tcw += $campaigns[$c]['weight'];
		$tbw[$c] = 0;
	}
	
	
	if ($tcw == 0)
		return 0;  // All campaigns are disabled or high priority
	
	
	// Get total banner weight for each campaign
	foreach (array_keys($banners) as $b)
		if (isset($campaigns[$banners[$b]['parent']]) && $campaigns[$banners[$b]['parent']]['active'] == 't')
			$tbw[$banners[$b]['parent']] += $banners[$b]['weight'];
	
	// Determine probability or low priority campaigns
	foreach (array_keys($banners) as $b)
		if (isset($campaigns[$banners[$b]['parent']]) && $campaigns[$banners[$b]['parent']]['active'] == 't' && $campaigns[$banners[$b]['parent']]['weight'] > 0)
			$pr[] = ($campaigns[$banners[$b]['parent']]['weight'] / $tcw / $tbw[$banners[$b]['parent']]) * $banners[$b]['weight'];
	
	// Return if probability array is empty
	if (!count($pr))
		return 0;
	
	// Determine minimum probability
	$min = min($pr);
	
	
	if ($min == 0)
		return 0; // No active banners in low priority campaigns
	
	
	// Determine total weight
	reset($pr); $total = 0;
	while (list(,$v) = each($pr))
		$total += round ($v / $min);
	
	return $total;
}



function phpAds_PriorityGetGCD($numbers)
{
	if (!($count = count($numbers)))
		return 0;

	$i = 0;
	$res = $numbers[0];

	while ($i < $count)
	{
		if ($i == $count - 1)
		{
			$res = phpAds_PriorityGetGCD2($res, $numbers[$i]);
			break;
		}

		$i++;
		$res = phpAds_PriorityGetGCD2(phpAds_PriorityGetGCD2($res,
			$numbers[$i]), $numbers[$i]);
	}

	return $res;
}

function phpAds_PriorityGetGCD2($a, $b)
{
	if ($a == 0)
		return $b;
	else
		return (phpAds_PriorityGetGCD2($b % $a, $a));
}

function phpAds_PriorityNormalDistribution($x, $variation = 1, $mean = 0)
{
	return $j = exp(-pow($x - $mean,2)/2/pow($variation,2))/(sqrt(2*pow($variation,2)*M_PI));
}

function phpAds_PriorityGetGaussianProfile($days_running)
{
	$result = array(
		0, 0, 0, 0, 0, 0,
		0, 0, 0, 0, 0, 0,
		0, 0, 0, 0, 0, 0,
		0, 0, 0, 0, 0, 0
	);
	
	// Go for the last 5 weeks (if any)
	for ($i = 1; $i < 6 && $days_running > 7; $i++)
	{
		$j_tot = 0;
		
		// Get an centered interval of 3 days
		for ($x=-1; $x <= 1; $x++)
		{
			$j = phpAds_PriorityNormalDistribution($x, 2/3);
			$j_tot += $j;
			
			$tmp = phpAds_PriorityGetHourlyProfile(1, 7 * $i - $x - 1);
			
			for ($h=0;$h<24;$h++)
			{
				if (!isset($profile[$i][$h]))
					$profile[$i][$h] = 0;
				
				$profile[$i][$h] += $j * $tmp[$h];
			}
		}
		// Apply trend to get back lost impressions
		for ($h=0;$h<24;$h++)
			$profile[$i][$h] /= $j_tot;
		
		$days_running -= 7;
	}
	
	
	// Apply normal distribution to last weeks profile
	if (isset($profile))
	{
		if (count($profile) > 1)
		{
			// More than a week of statistics gathered
			$j_tot = 0;
			
			while (list($k, $v) = each($profile))
			{
				$j = phpAds_PriorityNormalDistribution($k, 1.5, 1);
				$j_tot += $j;
				
				for ($h=0;$h<24;$h++)
					$result[$h] += $v[$h] * $j;
			}
			
			// Apply trend to get back lost impressions
			if ($j_tot)
			{
				for ($h=0;$h<24;$h++)
					$result[$h] /= $j_tot;
			}
		}
		else
		{
			// Only one week of statistics gathered
			for ($h=0;$h<24;$h++)
				$result[$h] = $profile[1][$h];
		}
	}
	
	
	for ($h=0;$h<24;$h++)
		$result[$h] = round($result[$h]);
	
	return $result;
}


?>