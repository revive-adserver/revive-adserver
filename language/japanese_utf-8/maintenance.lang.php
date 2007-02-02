<?php // $Revision$

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

//  Translator: Tadashi Jokagi <elf2000@users.sourceforge.net>
//  EN-Revision: 2.1.2.3

// Main strings
$GLOBALS['strChooseSection']			= "セクション選択";


// Priority
$GLOBALS['strRecalculatePriority']		= "優先度の再計算";
$GLOBALS['strHighPriorityCampaigns']		= "高い重要度のキャンペーン";
$GLOBALS['strAdViewsAssigned']			= "AdViews 割り当て";
$GLOBALS['strLowPriorityCampaigns']		= "低優先度のキャンペーン";
$GLOBALS['strPredictedAdViews']			= "AdViews を予測する";
$GLOBALS['strPriorityDaysRunning']		= "There are currently {days} days worth of statistics available from where ".$phpAds_productname." can base its daily prediction on. ";
$GLOBALS['strPriorityBasedLastWeek']		= "予測は今週と先週のデータに基づきます。";
$GLOBALS['strPriorityBasedLastDays']		= "予測は過去 2・3日のデータに基づきます。";
$GLOBALS['strPriorityBasedYesterday']		= "予測は昨日のデータに基づきます。 ";
$GLOBALS['strPriorityNoData']			= "There isn't enough data available to make a reliable prediction about the number of impressions this adserver will generate today. Priority assignments will be based on real time statistics only. ";
$GLOBALS['strPriorityEnoughAdViews']		= "There should be enough AdViews to fully satisfy the target all high priority campaigns. ";
$GLOBALS['strPriorityNotEnoughAdViews']		= "It isn't clear wether there will be enough AdViews served today to satisfy the target all high priority campaigns. ";


// Banner cache
$GLOBALS['strRebuildBannerCache']		= "バナーキャッシュを再構築する";
$GLOBALS['strBannerCacheExplaination']		= "
	The banner cache contains a copy of the HTML code which is used to display the banner. By using a banner cache it is possible to speed
	up the delivery of banners because the HTML code doesn't need to be generated every time a banner is being delivered. Because the
	banner cache contains hard coded URLs to the location of ".$phpAds_productname." and its banners, the cache needs to be updated
	everytime ".$phpAds_productname." is moved to another location on the webserver.
";


// Cache
$GLOBALS['strCache']			= "配信キャッシュ";
$GLOBALS['strAge']				= "Age";
$GLOBALS['strRebuildDeliveryCache']			= "配信キャッシュの再構築";
$GLOBALS['strDeliveryCacheExplaination']		= "
	配信キャッシュはバナーの配信のスピードアップに使用されます。The cache contains a copy of all the banners
	which are linked to the zone which saves a number of database queries when the banners are actually delivered to the user. The cache
	is usually rebuild everytime a change is made to the zone or one of it's banners, it is possible the cache will become outdated.
	このために、キャッシュは自動的に毎時間再構築するでしょう。しかし、さらにキャッシュを手動で再構築することができます。
";
$GLOBALS['strDeliveryCacheSharedMem']		= "
	共有メモリは、配信キャッシュの格納に現在使用されています。
";
$GLOBALS['strDeliveryCacheDatabase']		= "
	データベースは、配信キャッシュの格納に現在使用されています。
";
$GLOBALS['strDeliveryCacheFiles']		= "
	配信キャッシュは現在サーバー上の複数のファイルに格納されています。
";


// Storage
$GLOBALS['strStorage']				= "ストレージ";
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
$GLOBALS['strSearchingUpdates']			= "アップデートを検索しています。暫くお待ちください...";
$GLOBALS['strAvailableUpdates']			= "利用可能なアップデート";
$GLOBALS['strDownloadZip']			= "ダウンロードする (.zip)";
$GLOBALS['strDownloadGZip']			= "ダウンロードする (.tar.gz)";

$GLOBALS['strUpdateAlert']			= $phpAds_productname . "の新規バージョンが利用可能です。                 \\n\\nこのアップデートのより詳細を\\n取得しますか?";
$GLOBALS['strUpdateAlertSecurity']		= $phpAds_productname . "の新規バージョンが利用可能です。                 \\n\\nIt is highly recommended to upgrade \\nas soon as possible, because this \\nversion contains one or more security fixes.";

$GLOBALS['strUpdateServerDown']			= "
    Due to an unknown reason it isn't possible to retrieve <br>
	information about possible updates. Please try again later.
";

$GLOBALS['strNoNewVersionAvailable']		= "
	".$phpAds_productname." のバージョンをアップデートしました。現在利用できるはアップデートはありません。";

$GLOBALS['strNewVersionAvailable']		= "
	<b>".$phpAds_productname." の新しいバージョンが利用可能です。</b><br> いくつかの現在既存の問題を解決するかもしれないことと、新機能の追加がされているので、この更新のインストールが推奨されます。
    アップグレードに関するより詳細な情報は下記のファイルに含まれるドキュメントを読んでください。
";

$GLOBALS['strSecurityUpdate']			= "
	<b>いくつかのセキュリティの修正を含む為、できるだけ早くこの更新をインストールすることが高く推奨されます。</b>
	現在使用している ".$phpAds_productname." のバージョンはある攻撃に脆弱かもしれないし、恐らく安全ではありません。
    アップグレードに関するより詳細な情報は下記のファイルに含まれるドキュメントを読んでください。
";

$GLOBALS['strNotAbleToCheck']			= "
	<b>Because the XML extention isn't available on your server, ".$phpAds_productname." is not
    able to check if a newer version is available.</b>
";

$GLOBALS['strForUpdatesLookOnWebsite']	= "
	利用可能なより新しいバージョンがあるかどうか知りたい場合、ウェブサイトを見てください。
";

$GLOBALS['strClickToVisitWebsite']		= "ウェブサイトを訪問する為にここをクリックします";
$GLOBALS['strCurrentlyUsing'] 			= "現在";
$GLOBALS['strRunningOn']				= "を次の環境で実行中:";
$GLOBALS['strAndPlain']					= "と";


// Stats conversion
$GLOBALS['strConverting']			= "変換中";
$GLOBALS['strConvertingStats']			= "統計の変換中...";
$GLOBALS['strConvertStats']			= "統計を変換する";
$GLOBALS['strConvertAdViews']			= "AdViews を変換しました。";
$GLOBALS['strConvertAdClicks']			= "AdClicks を変換中...";
$GLOBALS['strConvertNothing']			= "なにも変換しません...";
$GLOBALS['strConvertFinished']			= "終了しました...";

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