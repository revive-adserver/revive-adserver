<?php // $Revision: 2777 $

/************************************************************************/
/* Openads 2.0                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2000-2007 by the Openads developers                    */
/* For more information visit: http://www.openads.org                   */
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
	
	echo "<b>Scheduled maintenance hasn't run in the past hour. This may mean that you have not set it up correctly.</b>"."<br><br>";

	$last_run = $phpAds_config['maintenance_timestamp'];
	
	// Make sure that negative values don't break the script
	if ($last_run > 0)
		$last_run = strtotime(date('Y-m-d H:00:00', $last_run));

	if (time() >= $last_run + 3600)
	{
		// Automatic maintenance wasn't run in the last hour
		
		if ($phpAds_config['auto_maintenance'])
			echo "Automatic maintenance is enabled, but it has not been triggered. Note that automatic maintenance is triggered only when Openads delivers banners.
				  For best performance it is advised to set up <a href='http://docs.openads.org/openads-2.0-guide/maintenance.html' target='_blank'>scheduled maintenance</a>.";
		else
			echo "Also, automatic maintenance is disabled, so when ".$phpAds_productname." delivers banners, maintenance is not triggered.
				  If you do not plan to run <a href='http://docs.openads.org/openads-2.0-guide/maintenance.html' target='_blank'>scheduled maintenance</a>,
				  you must <a href='settings-admin.php?auto_maintenance=t'>enable auto maintenance</a> to ensure that ".$phpAds_productname." works correctly.";
	}
	else
	{
		if ($phpAds_config['auto_maintenance'])
			echo "Automatic maintenance is enabled and will trigger maintenance every hour.
				  For best performance it is advised to set up <a href='http://docs.openads.org/openads-2.0-guide/maintenance.html' target='_blank'>scheduled maintenance</a>.";
		else
			echo "Automatic maintenance is disabled too but a maintenance task has recently run. To make sure that ".$phpAds_productname." works correctly you should either
				  set up <a href='http://docs.openads.org/openads-2.0-guide/maintenance.html' target='_blank'>scheduled maintenance</a> or <a href='settings-admin.php?auto_maintenance=t'>enable auto maintenance</a>. ";
	}
}
else
{
	echo "<b>Scheduled maintenance seems to be correctly running.</b>"."<br><br>";
	
	if ($phpAds_config['auto_maintenance'])
		echo "Automatic maintenance is enabled. For best performance it is advised to <a href='settings-admin.php?auto_maintenance=f'>disable automatic maintenance</a>.";
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