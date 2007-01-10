<?php // $Revision: 2777 $

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



// Include required files
require ("config.php");
require ("lib-maintenance.inc.php");
require ("lib-statistics.inc.php");
require ("lib-zones.inc.php");


// Security check
phpAds_checkAccess(phpAds_Admin);



/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

phpAds_PageHeader("5.3");
phpAds_ShowSections(array("5.1", "5.3", "5.4", "5.2"));
phpAds_MaintenanceSelection("maintenance");


/*********************************************************/
/* Main code                                             */
/*********************************************************/

echo "<br>";



$last_cron_run = $phpAds_config['maintenance_cron_timestamp'];

// Make sure that negative values don't break the script
if ($last_cron_run > 0)
	$last_cron_run = strtotime(date('Y-m-d H:00:00', $last_cron_run));

if (time() >= $last_cron_run + 3600)
{
	// Scheduled maintenance wasn't run in the last hour
	
	echo "<b>Scheduled maintenance hasn't run in the past hour. This means that you probably didn't correctly set it up.</b>"."<br><br>";

	$last_run = $phpAds_config['maintenance_timestamp'];
	
	// Make sure that negative values don't break the script
	if ($last_run > 0)
		$last_run = strtotime(date('Y-m-d H:00:00', $last_run));

	if (time() >= $last_run + 3600)
	{
		// Automatic maintenance wasn't run in the last hour
		
		if ($phpAds_config['auto_maintenance'])
			echo "Automatic maintenance is enabled, but there is something which prevents it to get triggered. ".$phpAds_productname." needs to deliver
				banners to be able to trigger automatic maintenance and guarantee that maintenance is correctly run.";
		else
			echo "Also, automatic maintenance is disabled, so ".$phpAds_productname." cannot guarantee that maintenance is run.
				You should enable it if you do not plan to run scheduled maintenance but want to make sure that ".$phpAds_productname." works correctly.";
	}
	else
	{
		if ($phpAds_config['auto_maintenance'])
			echo "Automatic maintenance is enabled, and it seems that ".$phpAds_productname." is correctly triggering it.
				For best performance it is advised to set up scheduled maintenance.";
		else
			echo "Automatic maintenance is disabled too but a maintenance task has recently run.
				You should enable it if you do not plan to run scheduled maintenance but want to make sure that ".$phpAds_productname." works correctly.";
	}
}
else
{
	echo "<b>Scheduled maintenance seems to be correctly running.</b>"."<br><br>";
	
	if ($phpAds_config['auto_maintenance'])
		echo "Automatic maintenance is enabled. For best performance it is advised to disable automatic maintenance.";
	else
		echo "Automatic maintenance is disabled.";
}

echo "<br><br>";

phpAds_ShowBreak();



/*********************************************************/
/* HTML framework                                        */
/*********************************************************/

phpAds_PageFooter();

?>