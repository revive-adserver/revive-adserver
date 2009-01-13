<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
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
$GLOBALS['strChooseSection']			= "영역 선택";


// Priority
$GLOBALS['strRecalculatePriority']		= "우선순위 다시 계산";
$GLOBALS['strHighPriorityCampaigns']		= "높은 우선순위 캠페인";
$GLOBALS['strAdViewsAssigned']			= "할당된 AdViews";
$GLOBALS['strLowPriorityCampaigns']		= "낮은 우선순위 캠페인";
$GLOBALS['strPredictedAdViews']			= "예상 AdViews";
$GLOBALS['strPriorityDaysRunning']		= "일일 예상치를 기준으로 {days}일 정도 남아있습니다.";
$GLOBALS['strPriorityBasedLastWeek']		= "지난주와 금주의 데이터를 토대로 예상 노출수 계산. ";
$GLOBALS['strPriorityBasedLastDays']		= "최근 며칠간의 데이터를 토대로 예상 노출수 계산. ";
$GLOBALS['strPriorityBasedYesterday']		= "어제 데이터를 기준으로 예상 노출수 계산. ";
$GLOBALS['strPriorityNoData']			= "There isn't enough data available to make a reliable prediction about the number of impressions this adserver will generate today. Priority assignments will be based on real time statistics only. ";
$GLOBALS['strPriorityEnoughAdViews']		= "There should be enough AdViews to fully satisfy the target all high priority campaigns. ";
$GLOBALS['strPriorityNotEnoughAdViews']		= "It isn't clear wether there will be enough AdViews served today to satisfy the target all high priority campaigns. ";


// Banner cache
$GLOBALS['strRebuildBannerCache']		= "배너 캐시 다시 빌드";
$GLOBALS['strBannerCacheExplaination']		= "\n	The banner cache contains a copy of the HTML code which is used to display the banner. By using a banner cache it is possible to speed\n	up the delivery of banners because the HTML code doesn't need to be generated every time a banner is being delivered. Because the\n	banner cache contains hard coded URLs to the location of ".$phpAds_productname." and its banners, the cache needs to be updated\n	everytime ".$phpAds_productname." is moved to another location on the webserver.\n";


// Cache
$GLOBALS['strCache']			= "전달유지 캐시";
$GLOBALS['strAge']				= "Age";
$GLOBALS['strRebuildDeliveryCache']			= "전달유지 캐시 다시 빌드";
$GLOBALS['strDeliveryCacheExplaination']		= "\n	전달유지 캐시(delivery cache)는 배너를 빠르게 전달하기 위해 사용하는 방법이다.\n	The cache contains a copy of all the banners\n	which are linked to the zone which saves a number of database queries when the banners are actually delivered to the user. The cache\n	is usually rebuild everytime a change is made to the zone or one of it's banners, it is possible the cache will become outdated. Because\n	of this the cache will automatically rebuild every hour, but it is also possible to rebuild the cache manually.\n";
$GLOBALS['strDeliveryCacheSharedMem']		= "\n현재 전달유지 캐시를 저장하기 위해 공유 메모리를 사용하고 있습니다. \n";
$GLOBALS['strDeliveryCacheDatabase']		= "\n현재 전달유지 캐시를 저장하기 위해 데이터베이스를 사용하고 있습니다. \n";


// Storage
$GLOBALS['strStorage']				= "저장영역";
$GLOBALS['strMoveToDirectory']			= "데이터베이스에 저장된 이미지를 디렉터리로 옮기기";
$GLOBALS['strStorageExplaination']		= "\n로컬 배너로 사용하는 이미지는 데이터베이스 또는 디렉터리에 저장되어 있습니다. 이미지를 디렉터리에 저장한 경우에는 데이터베이스에 대한 부하를 줄임으로써 속도를 향상시킬 수 있습니다.\n";


// Storage
$GLOBALS['strStatisticsExplaination']		= "\n	You have enabled the <i>compact statistics</i>, but your old statistics are still in verbose format.\n	Do you want to convert your verbose statistics to the new compact format?\n";


// Product Updates
$GLOBALS['strSearchingUpdates']			= "업데이트를 겅색중입니다. 잠시 기다려주십시오...";
$GLOBALS['strAvailableUpdates']			= "이용할 수 있는 업데이트";
$GLOBALS['strDownloadZip']			= "다운로드(.zip)";
$GLOBALS['strDownloadGZip']			= "다운로드(.tar.gz)";

$GLOBALS['strUpdateAlert']			= $phpAds_productname."의 새 버전을 이용할 수 있습니다.\\n\\n새 업데이트에 대한 자세한 정보를 보겠습니까?";
$GLOBALS['strUpdateAlertSecurity']		= $phpAds_productname."의 새 버전을 이용할 수 있습니다.\\n\\n새 버전은 하나 또는 그 이상의 보안 수정을 포함하고 있으므로 가능한한 빨리 업그레이드할 것을 권합니다.";

$GLOBALS['strUpdateServerDown']			= "\n    Due to an unknown reason it isn't possible to retrieve <br>\n	information about possible updates. Please try again later.\n";

$GLOBALS['strNoNewVersionAvailable']		= "\n	현재 사용중인 ". MAX_PRODUCT_NAME ."의 버전은 최신입니다. 현재 이용할 수 있는 업데이트가 없습니다.\n";

$GLOBALS['strNewVersionAvailable']		= "\n	<b>A new version of ".$phpAds_productname." is available.</b><br> It is recommended to install this update,\n	because it may fix some currently existing problems and will add new features. For more information\n	about upgrading please read the documentation which is included in the files below.\n";

$GLOBALS['strSecurityUpdate']			= "\n	<b>It is highly recommended to install this update as soon as possible, because it contains a number\n	of security fixes.</b> The version of ".$phpAds_productname." which you are currently using might\n	be vulnerable to certain attacks and is probably not secure. For more information\n	about upgrading please read the documentation which is included in the files below.\n";

$GLOBALS['strNotAbleToCheck']			= "\n	<b>Because the XML extention isn't available on your server, ".$phpAds_productname." is not\n    able to check if a newer version is available.</b>\n";

$GLOBALS['strForUpdatesLookOnWebsite']	= "\n	You are currently running ".$phpAds_productname." ".$phpAds_version_readable.".\n	If you want to know if there is a newer version available, please take a look at our website.\n";

$GLOBALS['strClickToVisitWebsite']		= "\n	Click here to visit our website\n";


// Stats conversion
$GLOBALS['strConverting']			= "변환중";
$GLOBALS['strConvertingStats']			= "통계를 변환중입니다...";
$GLOBALS['strConvertStats']			= "통계 변환";
$GLOBALS['strConvertAdViews']			= "AdViews 변환,";
$GLOBALS['strConvertAdClicks']			= "AdClicks 변환...";
$GLOBALS['strConvertNothing']			= "변환할 것이 없습니다...";
$GLOBALS['strConvertFinished']			= "완료...";

$GLOBALS['strConvertExplaination']		= "\n	You are currently using the compact format to store your statistics, but there are <br>\n	still some statistics in verbose format. As long as the verbose statistics aren't  <br>\n	converted to compact format they will not be used while viewing these pages.  <br>\n	Before converting your statistics, make a backup of the database!  <br>\n	Do you want to convert your verbose statistics to the new compact format? <br>\n";

$GLOBALS['strConvertingExplaination']		= "\n	All remaining verbose statistics are now being converted to the compact format. <br>\n	Depending on how many impressions are stored in verbose format this may take a  <br>\n	couple of minutes. Please wait until the conversion is finished before you visit other <br>\n	pages. Below you will see a log of all modification made to the database. <br>\n";

$GLOBALS['strConvertFinishedExplaination']  	= "\n	The conversion of the remaining verbose statistics was succesful and the data <br>\n	should now be usable again. Below you will see a log of all modification made <br>\n	to the database.<br>\n";




// Note: New translations not found in original lang files but found in CSV
$GLOBALS['strEncodingConvert'] = "변환";
?>