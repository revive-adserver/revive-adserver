<?php // $Revision: 2.0 $

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
$GLOBALS['strChooseSection']			= "選擇部份";


// Priority
$GLOBALS['strRecalculatePriority']		= "重新計算優先權";
$GLOBALS['strHighPriorityCampaigns']		= "高優先權項目";
$GLOBALS['strAdViewsAssigned']			= "分配的廣告訪問數";
$GLOBALS['strLowPriorityCampaigns']		= "低優先權項目";
$GLOBALS['strPredictedAdViews']			= "預定的廣告訪問數";
$GLOBALS['strPriorityDaysRunning']		= $phpAds_productname."可以在現在有{days}天數據的基礎上預估每天的優先權.";
$GLOBALS['strPriorityBasedLastWeek']		= "在上週和本週數據基礎上的預估值.";
$GLOBALS['strPriorityBasedLastDays']		= "T在前幾天數據的基礎上的預估值.";
$GLOBALS['strPriorityBasedYesterday']		= "在昨天數據的基礎上的預估值";
$GLOBALS['strPriorityNoData']			= "現在沒有足夠的數據來精確估算此廣告伺服器今天點擊數的預計值。所以只在實時數據的基礎上分配優先權.";
$GLOBALS['strPriorityEnoughAdViews']		= "有足夠的訪問數來完全滿足預定的所有高優先權的方案.";
$GLOBALS['strPriorityNotEnoughAdViews']		= "還不知道是否有足夠的推播數來完全滿足預定的所有高優先權的方案,所以所有低優先權的方案已經暫時停用了.";


// Banner cache
$GLOBALS['strRebuildBannerCache']		= "重建廣告緩存區";
$GLOBALS['strBannerCacheExplaination']		= "廣告緩存區包含了用來顯示廣告的HTML代碼的一個副本.使用廣告緩存區可以提高廣告發放的速度,因為不再需要每次發放的時候都要生出那個一次HTML代碼.因為此廣告緩存區包含了".$phpAds_productname."和廣告的URL地址,所以緩存區需要在每次".$phpAds_productname."移動到網頁伺服器的另一個位置的時候重建.";


// Cache
$GLOBALS['strCache']				= "發送緩存區";
$GLOBALS['strAge']				= "壽命";
$GLOBALS['strRebuildDeliveryCache']		= "重建發送緩存區";
$GLOBALS['strDeliveryCacheExplaination']	= "發送緩存區可以提高廣告的發放速度.發送緩存區包含連接到此版位的所有廣告的一個副本,當廣告實際發放給用戶的時候減少了一些資料庫的查詢.此緩存區通常在一個版位或者版位的一個廣告改動的時候重建,它可能會過期.所以緩存區會每個小時自動重建一次,但您也可以手工重建.";
$GLOBALS['strDeliveryCacheSharedMem']		= "現在使用共享內存來存放發送緩存區.";
$GLOBALS['strDeliveryCacheDatabase']		= "現在使用資料庫來存放發送緩存區.";


// Storage
$GLOBALS['strStorage']				= "存儲";
$GLOBALS['strMoveToDirectory']			= "把存儲在資料庫中的圖片移動到一個目錄";
$GLOBALS['strStorageExplaination']		= "本地廣告使用的圖片存儲在資料庫或者一個目錄中.如果您把圖片存儲到一個目錄,減小了資料庫的負載會提高運行速度.";


// Storage
$GLOBALS['strStatisticsExplaination']		= "您已經啟用了<i>簡潔報表</i>,但是老的報表還是詳細格式.您想把詳細格式的報表轉換成新的簡潔格式嗎?";


// Product Updates
$GLOBALS['strSearchingUpdates']			= "查看升級. 請稍候...";
$GLOBALS['strAvailableUpdates']			= "可用升級";
$GLOBALS['strDownloadZip']			= "下載(.zip)";
$GLOBALS['strDownloadGZip']			= "下載(.tar.gz)";

$GLOBALS['strUpdateAlert']			= $phpAds_productname."有新的版本可用\\n\\n您想知道更多關於此次升級的消息嗎?";
$GLOBALS['strUpdateAlertSecurity']		= $phpAds_productname."有新的版本可用\\n\\n強烈推薦您儘快升級,\\n因為此次新版本包含了一個或多個安全補丁!";

$GLOBALS['strUpdateServerDown']			= "因為未知原因不能得到升級信息,請稍候再試.";

$GLOBALS['strNoNewVersionAvailable']		= "您的".$phpAds_productname."是最新版的.現在沒有可用的升級版本.";

$GLOBALS['strNewVersionAvailable']		= "<b>一個新版本".$phpAds_productname."可用</b><br>推薦您安裝此次更新,因為可能修補了一些存在的問題和增加了一些新的功能.更多的有關升級的信息請參考下面的相關文檔.";

$GLOBALS['strSecurityUpdate']			= "<b>強烈推薦您儘快安裝此次更新，因為包含了一些安全補丁</b>您現在使用的".$phpAds_productname."的版本的漏洞可能被攻擊和不安全.更多的有關升級的信息請參考下面的相關文檔.";

$GLOBALS['strNotAbleToCheck']			= "<b>因為您的伺服器XML擴展功能不能使用,".$phpAds_productname."無法檢查是否有新的版本可以使用.</b>";

$GLOBALS['strForUpdatesLookOnWebsite']		= "您現在運行的是".$phpAds_productname." ".$phpAds_version_readable.".如果您想知道是否有新的版本可用,請訪問我們的網站.";

$GLOBALS['strClickToVisitWebsite']		= "請點擊這裡來訪問我們的網站.";


// Stats conversion
$GLOBALS['strConverting']			= "轉換中";
$GLOBALS['strConvertingStats']			= "統計數據轉換中...";
$GLOBALS['strConvertStats']			= "轉換統計數據";
$GLOBALS['strConvertAdViews']			= "訪問數已經轉換完畢,";
$GLOBALS['strConvertAdClicks']			= "點擊數已經轉換完畢...";
$GLOBALS['strConvertNothing']			= "沒有數據可以轉換...";
$GLOBALS['strConvertFinished']			= "完畢...";

$GLOBALS['strConvertExplaination']		= "您現在使用簡潔格式來保存報表,但是還有一些報表是詳細格式.<br>詳細格式的報表沒有轉換成簡潔格式將不能在頁面上直接使用.<br>在轉換您的報表之前,保存資料庫的一個備份!<br>是否確認要把詳細格式的報表轉換成新的簡潔格式?<br>";

$GLOBALS['strConvertingExplaination']		= "所有剩餘的詳細格式的報表正在轉換成簡潔格式<br>根據詳細格式的數目而需要時間不同，可能需要幾分鐘。在瀏覽其他頁面之前一定要等到轉換完成。<br>下面您將看到資料庫修改的記錄.<br>";

$GLOBALS['strConvertFinishedExplaination']  	= "剩餘的詳細格式的報表已經轉換成功。數據現在要再次使用，下面您將看到資料庫修改的記錄<br>";


?>