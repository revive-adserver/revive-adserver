<?php // $Revision$

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2001 by Niels Leenheer			                        */
/* http://sourceforge.net/projects/phpadsnew                            */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/



function phpAds_PriorityGetImpressions($days, $offset)
{
	global $phpAds_config;
	
	$offset = $offset * (60 * 60 * 24);
	
	$timestamp_end = mktime (0, 0, 0, date('m'), date('d'), date('Y')) - 1 - $offset;
	$timestamp_begin = mktime (0, 0, 0, date('m'), date('d'), date('Y')) - (60 * 60 * 24 * $days) - $offset;
	
	if ($phpAds_config['compact_stats'])
	{
		$query = "
			SELECT SUM(views) as sum_views
			FROM ".$phpAds_config['tbl_adstats']."
			WHERE UNIX_TIMESTAMP(day) >= ".$timestamp_begin."
			AND UNIX_TIMESTAMP(day) <= ".$timestamp_end."
		";
	}
	else
	{
		$query = "
			SELECT COUNT(*) as sum_views
			FROM ".$phpAds_config['tbl_adviews']."
			WHERE t_stamp >= FROM_UNIXTIME(".$timestamp_begin.")
			AND t_stamp <= FROM_UNIXTIME(".$timestamp_end.")
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
	
	$timestamp_end = mktime (0, 0, 0, date('m'), date('d'), date('Y')) - 1 - $offset;
	$timestamp_begin = mktime (0, 0, 0, date('m'), date('d'), date('Y')) - (60 * 60 * 24 * $days) - $offset;
	
	if ($phpAds_config['compact_stats'])
	{
		$query = "
			SELECT hour, SUM(views) AS sum_views
			FROM ".$phpAds_config['tbl_adstats']."
			WHERE UNIX_TIMESTAMP(day) >= ".$timestamp_begin."
			AND UNIX_TIMESTAMP(day) <= ".$timestamp_end."
			GROUP BY hour
		";
	}
	else
	{
		$query = "
			SELECT HOUR(t_stamp) AS hour, COUNT(*) AS sum_views
			FROM ".$phpAds_config['tbl_adviews']."
			WHERE t_stamp >= FROM_UNIXTIME(".$timestamp_begin.")
			AND t_stamp <= FROM_UNIXTIME(".$timestamp_end.")
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
	
	// Get the number of days running
	if ($phpAds_config['compact_stats'])
	{
		$res = phpAds_dbQuery("SELECT UNIX_TIMESTAMP(MIN(day)) AS days_running FROM ".$phpAds_config['tbl_adstats']." WHERE hour > 0");
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
		
		// determine trend
		$trend = $impressions_this_week / $impressions_last_week;
		
		// get profile seven days ago
		$profile = phpAds_PriorityGetHourlyProfile (1, 7);
		
		// apply trend
		for ($i=0;$i<count($profile);$i++)
			$profile[$i] = (int)round ($profile[$i] * $trend);
	}
	elseif ($days_running >= 2)
	{
		// get last couple of days
		$profile = phpAds_PriorityGetHourlyProfile ($days_running, 0);
		
		// average
		for ($i=0;$i<count($profile);$i++)
			$profile[$i] = (int)round ($profile[$i] / $days_running);
	}
	elseif ($days_running == 1)
	{
		// get yesterday
		$profile = phpAds_PriorityGetHourlyProfile ($days_running, 0);
	}
	
	
	
	
	
	$timestamp_begin = mktime (0, 0, 0, date('m'), date('d'), date('Y'));
	$timestamp_end   = mktime (date('H'), 0, 0, date('m'), date('d'), date('Y')) - 1;
	
	if ($phpAds_config['compact_stats'])
	{
		$query = "
			SELECT hour, SUM(views) AS sum_views
			FROM ".$phpAds_config['tbl_adstats']."
			WHERE UNIX_TIMESTAMP(day) = ".$timestamp_begin."
			AND hour <= ".date('H', $timestamp_end)."
			GROUP BY hour
		";
	}
	else
	{
		$query = "
			SELECT HOUR(t_stamp) AS hour, COUNT(*) AS sum_views
			FROM ".$phpAds_config['tbl_adviews']."
			WHERE t_stamp >= FROM_UNIXTIME(".$timestamp_begin.")
			AND t_stamp <=  FROM_UNIXTIME(".$timestamp_end.")
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
	
	
	
	
	//
	if (isset($profile))
	{
		if (date('H') > 0)
		{
			$predicted_today = 0;
			for ($i=0;$i<24;$i++)
				$predicted_today += $profile[$i];
			
			$predicted_up_till_now = 0;
			for ($i=0;$i<date('H');$i++)
				$predicted_up_till_now += $profile[$i];
			
			$predicted_left_today = $predicted_today - $predicted_up_till_now;
			
			
			// Adjust prediction for today
			if ($predicted_up_till_now > 0)
			{
				$deviance = $real_up_till_now / $predicted_up_till_now;
				$real_today = round($predicted_today * $deviance);
			}
			else
			{
				$real_today = $predicted_today + $real_up_till_now;
			}
			
			// Create new profile based on new prediction
			// and real data
			$real_left_today = $real_today - $real_up_till_now;
			
			if ($predicted_left_today > 0)
				$adjustment = $real_left_today / $predicted_left_today;
			else
				$adjustment = 1;
			
			
			if ($adjustment > 0)
			{
				for ($i=0;$i<24;$i++)
				{
					if ($i<date('H'))
						$profile[$i] = (int)$real_profile[$i];
					else
						$profile[$i] = (int)round($profile[$i] * $adjustment);
				}
			}
			else
			{
				for ($i=0;$i<24;$i++)
					if ($i<date('H'))
						$profile[$i] = (int)$real_profile[$i];
			}
		}
	}
	else
	{
		if ($real_up_till_now > 0 && date('H') > 0)
		{
			$predicted_today = $real_up_till_now / date('H') * 24;
			$predicted_left_today = $predicted_today - $real_up_till_now;
			$hours_left_today = 24 - date('H');
			
			for ($i=0;$i<24;$i++)
			{
				if ($i<date('H'))
					$profile[$i] = (int)$real_profile[$i];
				else
					$profile[$i] = (int)round($predicted_left_today / $hours_left_today);
			}
		}
		else
		{
			// No data available
			// Now it is time to make something up :)
			
			$total_target = 0;
			for (reset($campaigns);$c=key($campaigns);next($campaigns))
				$total_target += $campaigns[$c]['target'];
			
			if ($total_target > 0)
			{
				for ($i=0;$i<24;$i++)
				{
					if ($i<date('H'))
						$profile[$i] = (int)$real_profile[$i];
					else
						$profile[$i] = (int)round($total_target / 24);
				}
			}
			else
			{
				$total_campaign_weight = 0;
				for (reset($campaigns);$c=key($campaigns);next($campaigns))
					$total_campaign_weight += $campaigns[$c]['weight'];
				
				$total_banner_weight = 0;
				for (reset($banners);$b=key($banners);next($banners))
					$total_banner_weight += $banners[$b]['weight'];
				
				$total_weight = $total_banner_weight * $total_campaign_weight;
				
				for ($i=0;$i<24;$i++)
				{
					if ($i<date('H'))
						$profile[$i] = (int)$real_profile[$i];
					else
						$profile[$i] = (int)$total_weight;
				}
			}
		}
	}
	
	return ($profile);
}

function phpAds_PriorityPrepareCampaigns()
{
	global $phpAds_config;
	
	$query = "
		SELECT clientid, weight, target
		FROM ".$phpAds_config['tbl_clients']."
		WHERE parent > 0 AND active='t'
		AND (weight + target) > 0
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
	$timestamp_begin = mktime (0, 0, 0, date('m'), date('d'), date('Y'));
	$timestamp_end   = mktime (date('H'), 0, 0, date('m'), date('d'), date('Y')) - 1;
	
	if ($phpAds_config['compact_stats'])
	{
		$query = "
			SELECT bannerid, SUM(views) as sum_views
			FROM ".$phpAds_config['tbl_adstats']."
			WHERE UNIX_TIMESTAMP(day) = ".$timestamp_begin."
			AND hour <= ".date('H', $timestamp_end)."
			GROUP BY bannerid
		";
	}
	else
	{
		$query = "
			SELECT bannerid, count(*) as sum_views
			FROM ".$phpAds_config['tbl_adviews']."
			WHERE t_stamp >= FROM_UNIXTIME(".$timestamp_begin.")
			AND t_stamp <=  FROM_UNIXTIME(".$timestamp_end.")
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
			SET priority = ".$banners[$b]['priority']."
			WHERE bannerid = ".$banners[$b]['bannerid']."
		";
		
		$res = phpAds_dbQuery($query);
	}
}


function phpAds_PriorityCalculate()
{
	// Prepare information
	$banners   = phpAds_PriorityPrepareBanners();
	$campaigns = phpAds_PriorityPrepareCampaigns();
	$profile   = phpAds_PriorityPredictProfile($campaigns, $banners);
	
	var_dump($profile);
	echo "<hr>";
	
	// Determine period
	$maxperiod = 24;
	$period = date('H') - 1;
	
	
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
					$targeted_hits += $banners[$b]['hits'];
			
			$total_targeted_hits += $targeted_hits;
			$total_requested 	 += $campaigns[$c]['target'];
		}
		else
		{
			for (reset($banners);$b=key($banners);next($banners))
				if ($banners[$b]['parent'] == $c)
					$other_hits += $banners[$b]['hits'];
			
			$total_other_hits    += $other_hits;
			$total_weight 	     += $campaigns[$c]['weight'];
		}
		
		$campaigns[$c]['hits'] = $targeted_hits + $other_hits;
	}
	
	
	
	
	// Determine estimated number of hits
	$estimated_hits = 0;
	for ($p=0; $p<24; $p++)
		$estimated_hits += $profile[$p];
	
	$total_hits 		  = $total_targeted_hits + $total_other_hits;
	$estimated_remaining  = $estimated_hits - $total_hits;
	$requested_remaining  = $total_requested - $total_targeted_hits;
	
	
	
	
	
	echo "<table>";
	echo "<tr>";
	echo "<td>".$total_hits."</td><td>".$estimated_hits."</td><td>".$estimated_remaining."</td><td>".$requested_remaining."</td>";
	
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
	
	echo "<td>".($total_other_hits)."</td><td>".($total_targeted_hits)."</td><td>".($available_for_targeting)."</td>";
	echo "<td>".($available_for_others)."</td>";
	
	
	$totalassigned = 0;
	
	for (reset($campaigns);$c=key($campaigns);next($campaigns))
	{
		if ($campaigns[$c]['target'] > 0)
		{
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
				for ($p=0;$p<date('H');$p++)
					$profile_uptil_now += $profile[$p];
				
				$expected_hits_this_period = round ($profile_uptil_now / $total_profile * $campaigns[$c]['target']);
			}
			
			if ($period > 0)
				$extra_to_assign = $expected_hits_this_period - $campaigns[$c]['hits'];
			else
				$extra_to_assign = 0;
			
			$extra_to_assign  		 = $extra_to_assign * ($maxperiod - $period);
			$remaining_for_campaign += $extra_to_assign;
			$totalassigned 			+= $remaining_for_campaign;
			
			$total_banner_weight     = 0;
			for (reset($banners);$b=key($banners);next($banners))
				if ($banners[$b]['parent'] == $c)
					$total_banner_weight += $banners[$b]['weight'];
			
			for (reset($banners);$b=key($banners);next($banners))
				if ($banners[$b]['parent'] == $c)
					$banners[$b]['priority'] = round ($remaining_for_campaign / $total_banner_weight * $banners[$b]['weight']);
			
			
			echo "<td>&nbsp;</td><td>".$campaigns[$c]['hits']."</td>";
			echo "<td>".$remaining_for_campaign."</td><td>".($campaigns[$c]['hits'] > 0 ? round($campaigns[$c]['hits'] / $total_hits  * 100, 2) : 0)."</td>";
		}
	}
	
	$available_for_others = $estimated_remaining - $totalassigned;
	
	for (reset($campaigns);$c=key($campaigns);next($campaigns))
	{
		if ($campaigns[$c]['target'] == 0)
		{
			if ($available_for_others > 0)
				$remaining_for_campaign = round ($available_for_others / $total_weight * $campaigns[$c]['weight']);
			else
				$remaining_for_campaign = 0;
			
			
			$total_banner_weight = 0;
			for (reset($banners);$b=key($banners);next($banners))
				if ($banners[$b]['parent'] == $c)
					$total_banner_weight += $banners[$b]['weight'];
			
			for (reset($banners);$b=key($banners);next($banners))
				if ($banners[$b]['parent'] == $c)
					$banners[$b]['priority'] = round ($remaining_for_campaign / $total_banner_weight * $banners[$b]['weight']);
			
			echo "<td>&nbsp;</td><td>".$campaigns[$c]['hits']."</td>";
			echo "<td>".$remaining_for_campaign."</td><td>".($campaigns[$c]['hits'] > 0 ? round($campaigns[$c]['hits'] / $total_hits  * 100, 2) : 0)."</td>";
		}
	}
	
	echo "</tr></table>";
	var_dump($banners);
	
	// Store priority information
	phpAds_PriorityStore($banners);
}


?>