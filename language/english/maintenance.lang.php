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
$GLOBALS['strZoneCacheOn']					= "Zone caching is turned on";
$GLOBALS['strZoneCacheOff']					= "Zone caching is turned off";
$GLOBALS['strCachedZones']					= "Cached zones";
$GLOBALS['strSizeOfCache']					= "Size of cache";
$GLOBALS['strAverageAge']					= "Average age";
$GLOBALS['strRebuildZoneCache']				= "Rebuild zone cache";
$GLOBALS['strZoneCacheExplaination']		= "
	The zone cache is used to speed up delivery of banners which are linked to zones. The zone cache contains a copy of all the banners
	which are linked to the zone which saves a number of database queries when the banners are actually delivered to the user. The cache
	is usually rebuild everytime a change is made to the zone or one of it's banners, it is possible the cache will become outdated. Because
	of this the cache will automatically rebuild every {seconds} seconds, but it is also possible to rebuild the cache manually.
";

?>