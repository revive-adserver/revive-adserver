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


// Main strings
$GLOBALS['strChooseSection']				= "Choose section";


// Priority
$GLOBALS['strRecalculatePriority']			= "Recalculate priority";
$GLOBALS['strHighPriorityCampaigns']		= "High priority campaigns";
$GLOBALS['strAdViewsAssigned']				= "AdViews assigned";
$GLOBALS['strLowPriorityCampaigns']			= "Low priority campaigns";
$GLOBALS['strPredictedAdViews']				= "Predicted AdViews";
$GLOBALS['strPriorityDaysRunning']			= "There are currently {days} days worth of statistics available from where phpAdsNew can base its daily prediction on. ";
$GLOBALS['strPriorityBasedLastWeek']		= "The prediction is based on data from this week and last week. ";
$GLOBALS['strPriorityBasedLastDays']		= "The prediction is based on data from the last couple of days. ";
$GLOBALS['strPriorityBasedYesterday']		= "The prediction is based on data from yesterday. ";
$GLOBALS['strPriorityNoData']				= "There isn't enough data available to make a reliable prediction about the number of impressions this adserver will generate today. Priority assignments will be based on real time statistics only. ";
$GLOBALS['strPriorityEnoughAdViews']		= "There should be enough AdViews to fully satisfy the target all high priority campaigns. ";
$GLOBALS['strPriorityNotEnoughAdViews']		= "It isn't clear wether there will be enough AdViews served today to satisfy the target all high priority campaigns. Because of this all low priority campaigns are temporarily disabled. ";


// Banner cache
$GLOBALS['strRebuildBannerCache']			= "Rebuild banner cache";
$GLOBALS['strBannerCacheExplaination']		= "
	The banner cache contains a copy of the HTML code which is used to display the banner. By using a banner cache it is possible to speed
	up the delivery of banners because the HTML code doesn't need to be generated every time a banner is being delivered. Because the
	banner cache contains hard coded URLs to the location of phpAdsNew and its banners, the cache needs to be updated
	everytime phpAdsNew is moved to another location on the webserver.
";


// Zone cache
$GLOBALS['strZoneCache']					= "Zone cache";
$GLOBALS['strAge']							= "Age";
$GLOBALS['strRebuildZoneCache']				= "Rebuild zone cache";
$GLOBALS['strZoneCacheExplaination']		= "
	The zone cache is used to speed up delivery of banners which are linked to zones. The zone cache contains a copy of all the banners
	which are linked to the zone which saves a number of database queries when the banners are actually delivered to the user. The cache
	is usually rebuild everytime a change is made to the zone or one of it's banners, it is possible the cache will become outdated. Because
	of this the cache will automatically rebuild every {seconds} seconds, but it is also possible to rebuild the cache manually.
";


// Storage
$GLOBALS['strStorage']						= "Storage";
$GLOBALS['strMoveToDirectory']				= "Move images stored inside the database to a directory";
$GLOBALS['strStorageExplaination']			= "
	The images used by local banners are stored inside the database or stored in a directory. If you store the images inside 
	a directory the load on the database will be reduced and this will lead to a increase in speed.
";


// Storage
$GLOBALS['strStatisticsExplaination']		= "
	You have enabled the <i>compact statistics</i>, but your old statistics are still in verbose format. 
	Do you want to convert your verbose statistics to the new compact format?
";


// Product Updates
$GLOBALS['strSearchingUpdates']				= "Looking for updates. Please wait...";
$GLOBALS['strAvailableUpdates']				= "Available updates";
$GLOBALS['strDownloadZip']					= "Download (.zip)";
$GLOBALS['strDownloadGZip']					= "Download (.tar.gz)";

$GLOBALS['strUpdateAlert']					= "A new version of ".$phpAds_productname." is available.                 \\n\\nDo you want to get more information \\nabout this update?";
$GLOBALS['strUpdateAlertSecurity']			= "A new version of ".$phpAds_productname." is available.                 \\n\\nIt is highly recommended to upgrade \\nas soon as possible, because this \\nversion contains one or more security fixes.";

$GLOBALS['strUpdateServerDown']				= "
    Due to an unknown reason it isn't possible to retrieve <br>
	information about possible updates. Please try again later.
";

$GLOBALS['strNoNewVersionAvailable']		= "
	Your version of ".$phpAds_productname." is up-to-date. There are currently no updates available.
";

$GLOBALS['strNewVersionAvailable']			= "
	<b>A new version of ".$phpAds_productname." is available.</b><br> It is recommended to install this update,
	because it may fix some currently existing problems and will add new features. For more information
	about upgrading please read the documentation which is included in the files below.
";

$GLOBALS['strSecurityUpdate']				= "
	<b>It is highly recommended to install this update as soon as possible, because it contains a number
	of security fixes.</b> The version of ".$phpAds_productname." which you are currently using might 
	be vulnerable to certain attacks and is probably not secure. For more information
	about upgrading please read the documentation which is included in the files below.
";


// Stats conversion
$GLOBALS['strConverting']					= "Converting";
$GLOBALS['strConvertingStats']				= "Converting statistics...";
$GLOBALS['strConvertStats']					= "Convert statistics";
$GLOBALS['strConvertAdViews']				= "AdViews converted,";
$GLOBALS['strConvertAdClicks']				= "AdClicks converted...";
$GLOBALS['strConvertNothing']				= "Nothing to convert...";
$GLOBALS['strConvertFinished']				= "Finished...";

$GLOBALS['strConvertExplaination']			= "
	You are currently using the compact format to store your statistics, but there are <br>
	still some statistics in verbose format. As long as the verbose statistics aren't  <br>
	converted to compact format they will not be used while viewing these pages.  <br>
	Before converting your statistics, make a backup of the database!  <br>
	Do you want to convert your verbose statistics to the new compact format? <br>
";

$GLOBALS['strConvertingExplaination']		= "
	All remaining verbose statistics are now being converted to the compact format. <br>
	Depending on how many impressions are stored in verbose format this may take a  <br>
	couple of minutes. Please wait until the conversion is finished before you visit other <br>
	pages. Below you will see a log of all modification made to the database. <br>
";

$GLOBALS['strConvertFinishedExplaination']  = "
	The conversion of the remaining verbose statistics was succesful and the data <br>
	should now be usable again. Below you will see a log of all modification made <br>
	to the database.<br>
";


?>