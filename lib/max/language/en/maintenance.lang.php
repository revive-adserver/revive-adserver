<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
| For contact details, see: http://www.openx.org/                           |
|                                                                           |
| This program is free software; you can redistribute it and/or modify      |
| it under the terms of the GNU General Public License as published by      |
| the Free Software Foundation; either version 2 of the License, or         |
| (at your option) any later version.                                       |
|                                                                           |
| This program is distributed in the hope that it will be useful,           |
| but WITHOUT ANY WARRANTY; without even the implied warranty of            |
| MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
| GNU General Public License for more details.                              |
|                                                                           |
| You should have received a copy of the GNU General Public License         |
| along with this program; if not, write to the Free Software               |
| Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA |
+---------------------------------------------------------------------------+
$Id$
*/

// Main strings
$GLOBALS['strChooseSection']			= "Choose section";

// Maintenance
$GLOBALS['strMaintenanceHasntRun']		= "<b>Scheduled maintenance hasn't run in the past hour. This may mean that you have not set it up correctly.</b>";
$GLOBALS['strAutoMantenaceEnabledAndHasntRun'] = "
	Automatic maintenance is enabled, but it has not been triggered. Note that automatic maintenance is triggered only when OpenX delivers banners.
    For best performance it is advised to set up <a href='http://" . OX_PRODUCT_DOCSURL . "/maintenance' target='_blank'>scheduled maintenance</a>.
";
$GLOBALS['strAutoMantenaceDisabledAndHasntRun'] = "
	Also, automatic maintenance is disabled, so when ".MAX_PRODUCT_NAME." delivers banners, maintenance is not triggered.
	If you do not plan to run <a href='http://" . OX_PRODUCT_DOCSURL . "/maintenance' target='_blank'>scheduled maintenance</a>,
	you must <a href='settings-admin.php'>enable auto maintenance</a> to ensure that ".MAX_PRODUCT_NAME." works correctly.
";

$GLOBALS['strAutoMantenaceEnabledAndRunning']   = "
	Automatic maintenance is enabled and will trigger maintenance every hour.
    For best performance it is advised to set up <a href='http://" . OX_PRODUCT_DOCSURL . "/maintenance' target='_blank'>scheduled maintenance</a>.
";
$GLOBALS['strAutoMantenaceDisabledAndRunning']  = "
	Automatic maintenance is disabled too but a maintenance task has recently run. To make sure that ".MAX_PRODUCT_NAME." works correctly you should either
    set up <a href='http://" . OX_PRODUCT_DOCSURL . "/maintenance' target='_blank'>scheduled maintenance</a> or <a href='settings-admin.php'>enable auto maintenance</a>.
";

$GLOBALS['strMantenaceRunning']  		= "<b>Scheduled maintenance seems to be correctly running.</b>";
$GLOBALS['strAutoMantenaceEnabled']		= "Automatic maintenance is enabled. For best performance it is advised to <a href='account-settings-maintenance.php'>disable automatic maintenance</a>.";
$GLOBALS['strAutoMantenaceDisabled']	= "Automatic maintenance is disabled.";


// Priority
$GLOBALS['strRecalculatePriority']		= "Recalculate priority";
$GLOBALS['strHighPriorityCampaigns']		= "High priority campaigns";
$GLOBALS['strAdViewsAssigned']			= "AdViews assigned";
$GLOBALS['strLowPriorityCampaigns']		= "Low priority campaigns";
$GLOBALS['strPredictedAdViews']			= "Predicted AdViews";
$GLOBALS['strPriorityDaysRunning']		= "There are currently {days} days worth of statistics available from where ".MAX_PRODUCT_NAME." can base its daily prediction on. ";
$GLOBALS['strPriorityBasedLastWeek']		= "The prediction is based on data from this week and last week. ";
$GLOBALS['strPriorityBasedLastDays']		= "The prediction is based on data from the last couple of days. ";
$GLOBALS['strPriorityBasedYesterday']		= "The prediction is based on data from yesterday. ";
$GLOBALS['strPriorityNoData']			= "There isn't enough data available to make a reliable prediction about the number of impressions this adserver will generate today. Priority assignments will be based on real time statistics only. ";
$GLOBALS['strPriorityEnoughAdViews']		= "There should be enough AdViews to fully satisfy the target all high priority campaigns. ";
$GLOBALS['strPriorityNotEnoughAdViews']		= "It isn't clear wether there will be enough AdViews served today to satisfy the target all high priority campaigns. ";


// Banner cache
$GLOBALS['strCheckBannerCache']		= "Check banner cache";
$GLOBALS['strRebuildBannerCache']		= "Rebuild banner cache";
$GLOBALS['strBannerCacheErrorsFound'] = "The database banner cache check has found some errors. These banners will not work until you manually fix them.";
$GLOBALS['strBannerCacheOK'] = "There were no errors detected. Your database banner cache is up to date";
$GLOBALS['strBannerCacheDifferencesFound'] = "The database banner cache check has found that your cache is not up to date and requires rebuilding. Click here to automatically  update your cache.";
$GLOBALS['strBannerCacheFixed'] = "The database banner cache rebuild was successfully completed. Your database cache is now up to date.";
$GLOBALS['strBannerCacheRebuildButton'] = "Rebuild";
$GLOBALS['strRebuildDeliveryCache']			= "Rebuild database banner cache";
$GLOBALS['strBannerCacheExplaination']		= "
    The database banner cache is used to speed up delivery of banners during delivery<br />
    This cache needs to be updated when:
    <ul>
        <li>You upgrade your version of ".MAX_PRODUCT_NAME."</li>
        <li>You move your ".MAX_PRODUCT_NAME." installation to a different server</li>
    </ul>
";

// Cache
$GLOBALS['strCache']			= "Delivery cache";
$GLOBALS['strAge']				= "Age";
$GLOBALS['strDeliveryCacheSharedMem']		= "
	Shared memory is currently being used for storing the delivery cache.
";
$GLOBALS['strDeliveryCacheDatabase']		= "
	The database is currently being used for storing the delivery cache.
";
$GLOBALS['strDeliveryCacheFiles']		= "
	The delivery cache is currently being stored into multiple files on your server.
";


// Storage
$GLOBALS['strStorage']				= "Storage";
$GLOBALS['strMoveToDirectory']			= "Move images stored inside the database to a directory";
$GLOBALS['strStorageExplaination']		= "
	The images used by local banners are stored inside the database or stored in a directory. If you store the images inside
	a directory the load on the database will be reduced and this will lead to an increase in speed.
";

// Encoding
$GLOBALS['strEncoding']                 = "Encoding";
$GLOBALS['strEncodingExplaination']     = MAX_PRODUCT_NAME . ' now stores all data in the database in UTF-8 format.<br />
    Where possible, your data will have been automatically converted to this encoding.<br />
    If after upgrading you find corrupt characters, and you know the encoding used, you may use this tool to convert the data from that format to UTF-8';
$GLOBALS['strEncodingConvertFrom']      = "Convert from this encoding:";
$GLOBALS['strEncodingConvert']          = "Convert";
$GLOBALS['strEncodingConvertTest']      = "Test conversion";
$GLOBALS['strConvertThese']             = "The following data will be changed if you continue";


// Storage
$GLOBALS['strStatisticsExplaination']		= "
	You have enabled the <i>compact statistics</i>, but your old statistics are still in verbose format.
	Do you want to convert your verbose statistics to the new compact format?
";


// Product Updates
$GLOBALS['strSearchingUpdates']			= "Looking for updates. Please wait...";
$GLOBALS['strAvailableUpdates']			= "Available updates";
$GLOBALS['strDownloadZip']			= "Download (.zip)";
$GLOBALS['strDownloadGZip']			= "Download (.tar.gz)";

$GLOBALS['strUpdateAlert']			= "A new version of ".MAX_PRODUCT_NAME." is available.                 \\n\\nDo you want to get more information \\nabout this update?";
$GLOBALS['strUpdateAlertSecurity']		= "A new version of ".MAX_PRODUCT_NAME." is available.                 \\n\\nIt is highly recommended to upgrade \\nas soon as possible, because this \\nversion contains one or more security fixes.";

$GLOBALS['strUpdateServerDown']			= "Due to an unknown reason it isn't possible to retrieve <br>information about possible updates. Please try again later.";

$GLOBALS['strNoNewVersionAvailable']		= "
	Your version of ".MAX_PRODUCT_NAME." is up-to-date. There are currently no updates available.
";

$GLOBALS['strNewVersionAvailable']		= "
	<b>A new version of ".MAX_PRODUCT_NAME." is available.</b><br /> It is recommended to install this update,
	because it may fix some currently existing problems and will add new features. For more information
	about upgrading please read the documentation which is included in the files below.
";

$GLOBALS['strSecurityUpdate']			= "
	<b>It is highly recommended to install this update as soon as possible, because it contains a number
	of security fixes.</b> The version of ".MAX_PRODUCT_NAME." which you are currently using might
	be vulnerable to certain attacks and is probably not secure. For more information
	about upgrading please read the documentation which is included in the files below.
";

$GLOBALS['strNotAbleToCheck']			= "
	<b>Because the XML extention isn't available on your server, ".MAX_PRODUCT_NAME." is not
    able to check if a newer version is available.</b>
";

$GLOBALS['strForUpdatesLookOnWebsite']	= "
	If you want to know if there is a newer version available, please take a look at our website.
";

$GLOBALS['strClickToVisitWebsite']		= "Click here to visit our website";
$GLOBALS['strCurrentlyUsing'] 			= "You are currently using";
$GLOBALS['strRunningOn']				= "running on";
$GLOBALS['strAndPlain']					= "and";


// Stats conversion
$GLOBALS['strConverting']			= "Converting";
$GLOBALS['strConvertingStats']			= "Converting statistics...";
$GLOBALS['strConvertStats']			= "Convert statistics";
$GLOBALS['strConvertAdViews']			= "AdViews converted,";
$GLOBALS['strConvertAdClicks']			= "AdClicks converted...";
$GLOBALS['strConvertAdConversions']			= "AdConversions converted...";
$GLOBALS['strConvertNothing']			= "Nothing to convert...";
$GLOBALS['strConvertFinished']			= "Finished...";

$GLOBALS['strConvertExplaination']		= "
	You are currently using the compact format to store your statistics, but there are <br />
	still some statistics in verbose format. As long as the verbose statistics aren't  <br />
	converted to compact format they will not be used while viewing these pages.  <br />
	Before converting your statistics, make a backup of the database!  <br />
	Do you want to convert your verbose statistics to the new compact format? <br />
";

$GLOBALS['strConvertingExplaination']		= "
	All remaining verbose statistics are now being converted to the compact format. <br />
	Depending on how many impressions are stored in verbose format this may take a  <br />
	couple of minutes. Please wait until the conversion is finished before you visit other <br />
	pages. Below you will see a log of all modification made to the database. <br />
";

$GLOBALS['strConvertFinishedExplaination']  	= "
	The conversion of the remaining verbose statistics was succesful and the data <br />
	should now be usable again. Below you will see a log of all modification made <br />
	to the database.<br />
";

?>