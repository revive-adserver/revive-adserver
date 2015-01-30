<?php

/*
  +---------------------------------------------------------------------------+
  | Revive Adserver                                                           |
  | http://www.revive-adserver.com                                            |
  |                                                                           |
  | Copyright: See the COPYRIGHT.txt file.                                    |
  | License: GPLv2 or later, see the LICENSE.txt file.                        |
  +---------------------------------------------------------------------------+
 */

// Main strings
$GLOBALS['strChooseSection'] = "�?역 선�?";

// Maintenance









// Priority
$GLOBALS['strRecalculatePriority'] = "우선순위 다시 계산";
$GLOBALS['strHighPriorityCampaigns'] = "높�?� 우선순위 캠페�?�";
$GLOBALS['strAdViewsAssigned'] = "할당�?� AdViews";
$GLOBALS['strLowPriorityCampaigns'] = "낮�?� 우선순위 캠페�?�";
$GLOBALS['strPredictedAdViews'] = "예�? AdViews";
$GLOBALS['strPriorityDaysRunning'] = "�?��?� 예�?치를 기준으로 {days}�?� 정�?� 남아있습니다.";
$GLOBALS['strPriorityBasedLastWeek'] = "지난주와 금주�?� �?��?�터를 토대로 예�? 노출수 계산. ";
$GLOBALS['strPriorityBasedLastDays'] = "최근 며칠간�?� �?��?�터를 토대로 예�? 노출수 계산. ";
$GLOBALS['strPriorityBasedYesterday'] = "어제 �?��?�터를 기준으로 예�? 노출수 계산. ";


// Banner cache
$GLOBALS['strRebuildBannerCache'] = "배너 �?시 다시 빌드";
$GLOBALS['strRebuildDeliveryCache'] = "전달유지 �?시 다시 빌드";
$GLOBALS['strBannerCacheExplaination'] = "	The banner cache contains a copy of the HTML code which is used to display the banner. By using a banner cache it is possible to speed
	up the delivery of banners because the HTML code doesn't need to be generated every time a banner is being delivered. Because the
	banner cache contains hard coded URLs to the location of {$PRODUCT_NAME} and its banners, the cache needs to be updated
	everytime {$PRODUCT_NAME} is moved to another location on the webserver.";

// Cache
$GLOBALS['strCache'] = "전달유지 �?시";
$GLOBALS['strDeliveryCacheSharedMem'] = "현재 전달유지 �?시를 저장하기 위해 공유 메모리를 사용하고 있습니다.";
$GLOBALS['strDeliveryCacheDatabase'] = "현재 전달유지 �?시를 저장하기 위해 �?��?�터베�?�스를 사용하고 있습니다.";


// Storage
$GLOBALS['strStorage'] = "저장�?역";
$GLOBALS['strMoveToDirectory'] = "�?��?�터베�?�스�? 저장�?� �?�미지를 디렉터리로 옮기기";
$GLOBALS['strStorageExplaination'] = "로컬 배너로 사용하는 �?�미지는 �?��?�터베�?�스 �?는 디렉터리�? 저장�?�어 있습니다. �?�미지를 디렉터리�? 저장한 경우�?는 �?��?�터베�?�스�? 대한 부하를 줄임으로�?� �?�?�를 향�?시킬 수 있습니다.";

// Encoding
$GLOBALS['strEncodingConvert'] = "변환";


// Storage


// Product Updates
$GLOBALS['strSearchingUpdates'] = "업�?��?�트를 겅색중입니다. 잠시 기다려주십시오...";
$GLOBALS['strAvailableUpdates'] = "�?�용할 수 있는 업�?��?�트";
$GLOBALS['strDownloadZip'] = "다운로드(.zip)";
$GLOBALS['strDownloadGZip'] = "다운로드(.tar.gz)";

$GLOBALS['strUpdateAlert'] = "{$PRODUCT_NAME}�?� 새 버전�?� �?�용할 수 있습니다.\\n\\n새 업�?��?�트�? 대한 �?세한 정보를 보겠습니까?";
$GLOBALS['strUpdateAlertSecurity'] = "{$PRODUCT_NAME}�?� 새 버전�?� �?�용할 수 있습니다.\\n\\n새 버전�?� 하나 �?는 그 �?��?�?� 보안 수정�?� �?�함하고 있으므로 가능한한 빨리 업그레�?�드할 것�?� 권합니다.";

$GLOBALS['strUpdateServerDown'] = "    Due to an unknown reason it isn't possible to retrieve <br>
	information about possible updates. Please try again later.";

$GLOBALS['strNoNewVersionAvailable'] = "	현재 사용중�?� {$PRODUCT_NAME}�?� 버전�?� 최신입니다. 현재 �?�용할 수 있는 업�?��?�트가 없습니다.";



$GLOBALS['strNewVersionAvailable'] = "	<b>A new version of {$PRODUCT_NAME} is available.</b><br> It is recommended to install this update,
	because it may fix some currently existing problems and will add new features. For more information
	about upgrading please read the documentation which is included in the files below.";

$GLOBALS['strSecurityUpdate'] = "	<b>It is highly recommended to install this update as soon as possible, because it contains a number
	of security fixes.</b> The version of {$PRODUCT_NAME} which you are currently using might
	be vulnerable to certain attacks and is probably not secure. For more information
	about upgrading please read the documentation which is included in the files below.";



$GLOBALS['strClickToVisitWebsite'] = "	Click here to visit our website";


// Stats conversion
$GLOBALS['strConverting'] = "변환중";
$GLOBALS['strConvertingStats'] = "통계를 변환중입니다...";
$GLOBALS['strConvertStats'] = "통계 변환";
$GLOBALS['strConvertAdViews'] = "AdViews 변환,";
$GLOBALS['strConvertAdClicks'] = "AdClicks 변환...";
$GLOBALS['strConvertNothing'] = "변환할 것�?� 없습니다...";
$GLOBALS['strConvertFinished'] = "완료...";

$GLOBALS['strConvertExplaination'] = "	You are currently using the compact format to store your statistics, but there are <br>
	still some statistics in verbose format. As long as the verbose statistics aren't  <br>
	converted to compact format they will not be used while viewing these pages.  <br>
	Before converting your statistics, make a backup of the database!  <br>
	Do you want to convert your verbose statistics to the new compact format? <br>";

$GLOBALS['strConvertingExplaination'] = "	All remaining verbose statistics are now being converted to the compact format. <br>
	Depending on how many impressions are stored in verbose format this may take a  <br>
	couple of minutes. Please wait until the conversion is finished before you visit other <br>
	pages. Below you will see a log of all modification made to the database. <br>";

$GLOBALS['strConvertFinishedExplaination'] = "	The conversion of the remaining verbose statistics was succesful and the data <br>
	should now be usable again. Below you will see a log of all modification made <br>
	to the database.<br>";

//  Maintenace

//  Deliver Limitations


//  Append codes


