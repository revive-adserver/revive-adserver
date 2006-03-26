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



// Include required files
require	(phpAds_path."/libraries/lib-autotargeting.inc.php"); 


// Set defaults
$report = '';


// Save views into targetstats table
phpAds_TargetStatsSaveViews();


// Get campaigns that need autotargeting
$res = phpAds_dbQuery("
	SELECT
		clientid,
		clientname,
		views,
		UNIX_TIMESTAMP(expire) AS expire
	FROM
		".$phpAds_config['tbl_clients']."
	WHERE
		parent > 0 AND
		active AND
		expire > NOW() AND
		views > 0 AND
		weight = 0
	ORDER BY
		clientid
	");


if (phpAds_dbNumRows($res))
{
	// Autotargeting needed
	$report .= "==================================================\n";
	$report .= "AUTOTARGETING STARTED\n";
	$report .= "==================================================\n\n";
	$report .= "--------------------------------------------------\n";
	$report .= "Smoothing factor calculation ";
	
	
	// Prepare the average view profile
	$profile = phpAds_AutoTargetingPrepareProfile();
	
	// Calculate the factor to use on sunday or if it's disabled
	if (!date('w') || !isset($phpAds_config['autotarget_factor']) || $phpAds_config['autotarget_factor'] == -1)
	{
		$report .= "started\n";
		$report .= "--------------------------------------------------\n";
		
		$phpAds_config['autotarget_factor'] = phpAds_AutoTargetingCaclulateFactor($profile, $report);
		
		// Save factor into db
		phpAds_dbQuery("
			UPDATE
				".$phpAds_config['tbl_config']."
			SET
				autotarget_factor = ".$phpAds_config['autotarget_factor']."
			WHERE
				configid = 0
			");
	}
	elseif (!phpAds_AutoTargetingProfileSum($profile))
	{
		// Disable if a null profile was supplied
		$phpAds_config['autotarget_factor'] = -1;
		
		$report .= "skipped: supplied profile is null\n\n";
	}
	else
		$report .= "skipped: already set\n\n";
	
	
	$report .= "--------------------------------------------------\n";
	$report .= "Smoothing factor:               ".sprintf('%.2f', $phpAds_config['autotarget_factor'])."\n";
	$report .= "Today dow:                      ".phpAds_DowToday."\n";
	$report .= "Today profile value:            ".$profile[phpAds_DowToday]."\n";
	
	if ($phpAds_config['autotarget_factor'] != -1)
	{
		// Targets should not be fully satisfied if using plain autotargeting
		// Smoothing the view profile for later use
		$profile = phpAds_AutoTargetingSmoothProfile($profile, $phpAds_config['autotarget_factor']);

		$report .= "Today smoothed profile value:   ".$profile[phpAds_DowToday]."\n";
	}
	
	$report .= "--------------------------------------------------\n\n";
	
	while ($row = phpAds_dbFetchArray($res))
	{
		$target = phpAds_AutoTargetingGetTarget($profile, $row['views'], $row['expire'], $phpAds_config['autotarget_factor']);
		
		if (is_array($target))
			list($target, $debuglog) = $target;
		else
			$debuglog = 'no debug info available';
		
		phpAds_dbQuery("
			UPDATE
				".$phpAds_config['tbl_clients']."
			SET
				target = ".$target."
			WHERE
				clientid = ".$row['clientid']."
		");
		
		$report .= "\n<b>$row[clientname] [id$row[clientid]]:</b> $target $debuglog\n\n";
	}
}

if ($report != '' && $phpAds_config['userlog_priority'])
	phpAds_userlogAdd (phpAds_actionPriorityAutoTargeting, 0, $report);

?>