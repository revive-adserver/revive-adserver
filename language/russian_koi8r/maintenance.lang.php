<?php // $Revision$

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2000-2002 by the phpAdsNew developers                  */
/* For more information visit: http://www.phpadsnew.com                 */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/


// Main strings
$GLOBALS['strChooseSection']			= "Выберите раздел";


// Priority
$GLOBALS['strRecalculatePriority']		= "Пересчитать приоритеты";
$GLOBALS['strHighPriorityCampaigns']		= "Кампании с высоким приоритетом";
$GLOBALS['strAdViewsAssigned']			= "Выделено просмотров";
$GLOBALS['strLowPriorityCampaigns']		= "Кампании с низким приоритетом";
$GLOBALS['strPredictedAdViews']			= "Предсказано просмотров";
$GLOBALS['strPriorityDaysRunning']		= "Сейчас доступно {days} дней статистики, на которой ".$phpAds_productname." может основывать свои предсказания. ";
$GLOBALS['strPriorityBasedLastWeek']		= "Предсказания основаны на данных по этой и прошлой неделе. ";
$GLOBALS['strPriorityBasedYesterday']		= "Предсказание основано на данных за вчера. ";
$GLOBALS['strPriorityNoData']			= "Недостаточно данных для надёжного предсказания количества показов, которые данный сервер сгенерирует сегодня. Назначение проритетов будет основываться на статистике, собираемой в реальном времени. ";
$GLOBALS['strPriorityEnoughAdViews']		= "Должно быть достаточно показов для удовлетворения требований всех высокоприоритетных кампаний. ";
$GLOBALS['strPriorityNotEnoughAdViews']		= "Неочевидно, будет ли сегодня сгенерировано достаточно показов для удовлетворения требований всех высокопроритетных кампаний. ";


// Banner cache
$GLOBALS['strRebuildBannerCache']		= "Построить кэш баннеров заново";
$GLOBALS['strBannerCacheExplaination']		= "
	Кэш баннеров содержит копию HTML-кода, используемого для показа баннера. Использование кэша позволяет ускорить
	доставку баннеров, поскольку HTML-код не нужно генерировать для каждого показа баннера. Поскольку
	кэш содержит жёстко закодированные ссылки на расположение ".$phpAds_productname." и самих баннеров, кэш нужно перестраивать
	при каждом перемещении ".$phpAds_productname." на вебсервере.
";


// Zone cache
$GLOBALS['strZoneCache']			= "Zone cache";
$GLOBALS['strAge']				= "Age";
$GLOBALS['strRebuildZoneCache']			= "Rebuild zone cache";
$GLOBALS['strZoneCacheExplaination']		= "
	The zone cache is used to speed up delivery of banners which are linked to zones. The zone cache contains a copy of all the banners
	which are linked to the zone which saves a number of database queries when the banners are actually delivered to the user. The cache
	is usually rebuild everytime a change is made to the zone or one of it's banners, it is possible the cache will become outdated. Because
	of this the cache will automatically rebuild every {seconds} seconds, but it is also possible to rebuild the cache manually.
";


// Storage
$GLOBALS['strStorage']				= "Storage";
$GLOBALS['strMoveToDirectory']			= "Move images stored inside the database to a directory";
$GLOBALS['strStorageExplaination']		= "
	The images used by local banners are stored inside the database or stored in a directory. If you store the images inside 
	a directory the load on the database will be reduced and this will lead to a increase in speed.
";


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

$GLOBALS['strUpdateAlert']			= "A new version of ".$phpAds_productname." is available.                 \\n\\nDo you want to get more information \\nabout this update?";
$GLOBALS['strUpdateAlertSecurity']		= "A new version of ".$phpAds_productname." is available.                 \\n\\nIt is highly recommended to upgrade \\nas soon as possible, because this \\nversion contains one or more security fixes.";

$GLOBALS['strUpdateServerDown']			= "
    Due to an unknown reason it isn't possible to retrieve <br>
	information about possible updates. Please try again later.
";

$GLOBALS['strNoNewVersionAvailable']		= "
	Your version of ".$phpAds_productname." is up-to-date. There are currently no updates available.
";

$GLOBALS['strNewVersionAvailable']		= "
	<b>A new version of ".$phpAds_productname." is available.</b><br> It is recommended to install this update,
	because it may fix some currently existing problems and will add new features. For more information
	about upgrading please read the documentation which is included in the files below.
";

$GLOBALS['strSecurityUpdate']			= "
	<b>It is highly recommended to install this update as soon as possible, because it contains a number
	of security fixes.</b> The version of ".$phpAds_productname." which you are currently using might 
	be vulnerable to certain attacks and is probably not secure. For more information
	about upgrading please read the documentation which is included in the files below.
";


// Stats conversion
$GLOBALS['strConverting']			= "Converting";
$GLOBALS['strConvertingStats']			= "Converting statistics...";
$GLOBALS['strConvertStats']			= "Convert statistics";
$GLOBALS['strConvertAdViews']			= "AdViews converted,";
$GLOBALS['strConvertAdClicks']			= "AdClicks converted...";
$GLOBALS['strConvertNothing']			= "Nothing to convert...";
$GLOBALS['strConvertFinished']			= "Finished...";

$GLOBALS['strConvertExplaination']		= "
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

$GLOBALS['strConvertFinishedExplaination']  	= "
	The conversion of the remaining verbose statistics was succesful and the data <br>
	should now be usable again. Below you will see a log of all modification made <br>
	to the database.<br>
";


?>
