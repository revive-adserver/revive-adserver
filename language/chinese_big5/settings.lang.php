<?php // $Revision: 2.3 $

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



// Installer translation strings
$GLOBALS['strInstall']				= "安裝";
$GLOBALS['strChooseInstallLanguage']		= "選擇安裝過程的語言";
$GLOBALS['strLanguageSelection']		= "選擇語言";
$GLOBALS['strDatabaseSettings']			= "資料庫設定";
$GLOBALS['strAdminSettings']			= "管理員設定";
$GLOBALS['strAdvancedSettings']			= "高級設定";
$GLOBALS['strOtherSettings']			= "其他設定";

$GLOBALS['strWarning']				= "警告";
$GLOBALS['strFatalError']			= "發生一個致命錯誤";
$GLOBALS['strAlreadyInstalled']			= $phpAds_productname."已經安裝. 如果您想配置系統,請到 <a href='settings-index.php'>設定界面</a>";
$GLOBALS['strCouldNotConnectToDB']		= "不能連接資料庫,請檢查您的設定";
$GLOBALS['strCreateTableTestFailed']		= "您提供的用戶沒有權限創建資料庫結構,請聯係資料庫管理員.";
$GLOBALS['strUpdateTableTestFailed']		= "您提供的用戶沒有權限更新資料庫結構,請聯係資料庫管理員.";
$GLOBALS['strTablePrefixInvalid']		= "數據表的前綴包含非法字符";
$GLOBALS['strTableInUse']			= "您提供的資料庫已經被".$phpAds_productname."使用,請使用不同的表前綴,或者參考用戶手冊中系統升級的指導部份.";
$GLOBALS['strTableWrongType']			= "您安裝的".$phpAds_dbmsname."不支持您所選擇的數據表類型"; 
$GLOBALS['strMayNotFunction']			= "進行下一步之前,請改正這些潛在的錯誤:";
$GLOBALS['strIgnoreWarnings']			= "忽略警告";
$GLOBALS['strWarningDBavailable']		= "您現在使用的PHP版本不支持".$phpAds_dbmsname."資料庫.在進行下面的步驟之前,您需要啟用PHP對".$phpAds_dbmsname."的支持";
$GLOBALS['strWarningPHPversion']		= $phpAds_productname."需要PHP 4.0或者更高版本才能正常工作。您現在使用的版本是{php_version}.";
$GLOBALS['strWarningRegisterGlobals']		= "PHP設定變量register_globals需要打開.";
$GLOBALS['strWarningMagicQuotesGPC']		= "PHP設定變量magic_quotes_gpc需要打開.";
$GLOBALS['strWarningMagicQuotesRuntime']	= "PHP設定變量magic_quotes_runtime需要關閉.";
$GLOBALS['strWarningFileUploads']		= "PHP設定變量file_uploads需要打開.";
$GLOBALS['strWarningTrackVars']			= "PHP設定變量track_vars需要打開.";
$GLOBALS['strWarningPREG']			= "您現在使用的PHP版本不支持PERL兼容模式的正則表達式. 在進行下面的步驟之前,您需要啟用PREL正則表達式的支持.";
$GLOBALS['strConfigLockedDetected']		= $phpAds_productname."檢測到您的配置文件<b>config.inc.php</b>不可寫<br>請必須修改權限之後才能進行下一步.<br>如果您不知道如何操作請參考文檔.";
$GLOBALS['strCantUpdateDB']  			= "現在不能更新資料庫.如果您確認進行,所有已有的廣告,報表和客戶都會被刪除.";
$GLOBALS['strTableNames']			= "數據表名字";
$GLOBALS['strTablesPrefix']			= "數據表前綴";
$GLOBALS['strTablesType']			= "數據表類型";

$GLOBALS['strInstallWelcome']			= "歡迎使用".$phpAds_productname;
$GLOBALS['strInstallMessage']			= "在您使用".$phpAds_productname."之前,需要配置系統和<br>創建資料庫.按<b>下一步</b>繼續.";
$GLOBALS['strInstallSuccess']			= "<b>".$phpAds_productname."安裝完成.</b><br><br>為了".$phpAds_productname."的正常使用,您還需要確認維護文件每小時運行一次,有關的信息可以參考相關文檔.<br><br>按<b>下一步</b>進入配置頁面,您可以進行更多的設定.在配置完成候請不要忘記鎖定config.inc.php以保證安全.";
$GLOBALS['strUpdateSuccess']			= "<b>".$phpAds_productname."升級成功.</b><br><br>為了".$phpAds_productname."的正常使用,您還需要確認維護文件每小時運行一次,有關的信息可以參考相關文檔.<br><br>按<b>下一步</b>進入配置頁面,您可以進行更多的設定.在配置完成候請不要忘記鎖定config.inc.php以保證安全.";
$GLOBALS['strInstallNotSuccessful']		= "<b>".$phpAds_productname."安裝不能完成</b><br><br>安裝中的一些部份不能進行.這些問題可能只是暫時性的,這樣您可以簡單的按<b>下一步</b>並且返回到安裝的第一步,如果您想知道更多關於錯誤的信息和如何解決,請參考相關文檔.";
$GLOBALS['strErrorOccured']			= "有下面錯誤發生:";
$GLOBALS['strErrorInstallDatabase']		= "不能創建資料庫.";
$GLOBALS['strErrorInstallConfig']		= "T配置文件或者資料庫不能更新.";
$GLOBALS['strErrorInstallDbConnect']		= "不能連接到資料庫.";

$GLOBALS['strUrlPrefix']			= "URL前綴";

$GLOBALS['strProceed']				= "下一步 &gt;";
$GLOBALS['strRepeatPassword']			= "確認密碼";
$GLOBALS['strNotSamePasswords']			= "密碼不匹配";
$GLOBALS['strInvalidUserPwd']			= "錯誤的用戶名或密碼";

$GLOBALS['strUpgrade']				= "升級";
$GLOBALS['strSystemUpToDate']			= "您的系統已經是最新版,現在不需要升級<br>按<b>下一步</b>回到首頁.";
$GLOBALS['strSystemNeedsUpgrade']		= "資料庫結構和配置文件需要升級才能正常工作。按<b>下一步</b>開始升級。<br>升級時間因資料庫統計數據的多少而不同,這個過程可能引起系統資料庫負載昇高.請耐心等待,可能需要幾分鐘的時間.";
$GLOBALS['strSystemUpgradeBusy']		= "系統升級中，請稍候...";
$GLOBALS['strSystemRebuildingCache']		= "重建緩存區中，請稍候...";
$GLOBALS['strServiceUnavalable']		= "服務暫時不可用,系統升級中...";

$GLOBALS['strConfigNotWritable']		= "您的配置文件config.inc.php不可寫";





/*********************************************************/
/* Configuration translations                            */
/*********************************************************/

// Global
$GLOBALS['strChooseSection']			= "選擇部份";
$GLOBALS['strDayFullNames'] 			= array("星期日","星期一","星期二","星期三","星期四","星期五","星期六");
$GLOBALS['strEditConfigNotPossible']   		= "因為安全原因配置文件已經被鎖定,所以不能修改配置<br>如果您想修改,您需要使config.inc.php文件可寫.";
$GLOBALS['strEditConfigPossible']		= "現在可以修改所有配置,因為配置文件沒有鎖定,這樣可能導致安全問題.<br>如果您想保護您的系統,您需要鎖定config.inc.php文件.";



// Database
$GLOBALS['strDatabaseSettings']			= "資料庫設定";
$GLOBALS['strDatabaseServer']			= "資料庫設定";
$GLOBALS['strDbHost']				= "資料庫主機";
$GLOBALS['strDbPort']				= "資料庫端口號";
$GLOBALS['strDbUser']				= "資料庫用戶名";
$GLOBALS['strDbPassword']			= "資料庫密碼";
$GLOBALS['strDbName']				= "資料庫名字";
	
$GLOBALS['strDatabaseOptimalisations']		= "資料庫優化";
$GLOBALS['strPersistentConnections']		= "使用永久連接";
$GLOBALS['strInsertDelayed']			= "使用延遲插入";
$GLOBALS['strCompatibilityMode']		= "使用資料庫兼容模式";
$GLOBALS['strCantConnectToDb']			= "不能連接到資料庫";



// Invocation and Delivery
$GLOBALS['strInvocationAndDelivery']		= "調用和發送設定";
$GLOBALS['strAllowedInvocationTypes']		= "允許的調用方式";
$GLOBALS['strAllowRemoteInvocation']		= "允許遠程調用";
$GLOBALS['strAllowRemoteJavascript']		= "允許遠程調用Javascript";
$GLOBALS['strAllowRemoteFrames']		= "允許遠程調用Frames";
$GLOBALS['strAllowRemoteXMLRPC']		= "允許遠程調用XML-RPC";
$GLOBALS['strAllowLocalmode']			= "允許本地模式";
$GLOBALS['strAllowInterstitial']		= "允許空隙模式";
$GLOBALS['strAllowPopups']			= "允許彈出模式";

$GLOBALS['strUseAcl']				= "在發送過程中預估發送限制";

$GLOBALS['strDeliverySettings']			= "發送設定";
$GLOBALS['strCacheType']			= "發送緩沖區類型";
$GLOBALS['strCacheFiles']			= "文件";
$GLOBALS['strCacheDatabase']			= "資料庫";
$GLOBALS['strCacheShmop']			= "共享內存/shmop";
$GLOBALS['strCacheSysvshm']			= "共享內存/Sysvshm";
$GLOBALS['strExperimental']			= "實驗性的";
$GLOBALS['strKeywordRetrieval']			= "獲取關鍵字";
$GLOBALS['strBannerRetrieval']			= "廣告獲取模式";
$GLOBALS['strRetrieveRandom']			= "隨機廣告獲取(預設)";
$GLOBALS['strRetrieveNormalSeq']		= "獲取普通系列廣告";
$GLOBALS['strWeightSeq']			= "獲取權重系列廣告";
$GLOBALS['strFullSeq']				= "獲取全部系列的廣告";
$GLOBALS['strUseConditionalKeys']		= "直接廣告選取中允許使用邏輯操作";
$GLOBALS['strUseMultipleKeys']			= "直接廣告選取中允許使用多個關鍵字";

$GLOBALS['strZonesSettings']			= "獲取版位";
$GLOBALS['strZoneCache']			= "緩存版位，在使用版位時此選項能夠提高運行速度";
$GLOBALS['strZoneCacheLimit']			= "緩存區更新的時間間隔(秒)";
$GLOBALS['strZoneCacheLimitErr']		= "緩存區更新的時間間隔應該是一個整數";

$GLOBALS['strP3PSettings']			= "P3P隱私策略";
$GLOBALS['strUseP3P']				= "使用P3P策略";
$GLOBALS['strP3PCompactPolicy']			= "P3P縮略策略";
$GLOBALS['strP3PPolicyLocation']		= "P3P策略位置"; 



// Banner Settings
$GLOBALS['strBannerSettings']			= "廣告設定";

$GLOBALS['strAllowedBannerTypes']		= "允許的廣告類型";
$GLOBALS['strTypeSqlAllow']			= "允許本地廣告（本地資料庫）";
$GLOBALS['strTypeWebAllow']			= "允許本地廣告（本地網頁伺服器）";
$GLOBALS['strTypeUrlAllow']			= "允許外部廣告";
$GLOBALS['strTypeHtmlAllow']			= "允許HTML廣告";
$GLOBALS['strTypeTxtAllow']			= "允許文字廣告";

$GLOBALS['strTypeWebSettings']			= "本地廣告（本地網頁伺服器）設定";
$GLOBALS['strTypeWebMode']			= "存儲方式";
$GLOBALS['strTypeWebModeLocal']			= "本地目錄";
$GLOBALS['strTypeWebModeFtp']			= "外部Ftp伺服器";
$GLOBALS['strTypeWebDir']			= "本地目錄";
$GLOBALS['strTypeWebFtp']			= "Ftp模式廣告伺服器";
$GLOBALS['strTypeWebUrl']			= "公開的URL";
$GLOBALS['strTypeFTPHost']			= "FTP主機";
$GLOBALS['strTypeFTPDirectory']			= "主機目錄";
$GLOBALS['strTypeFTPUsername']			= "登錄";
$GLOBALS['strTypeFTPPassword']			= "密碼";
$GLOBALS['strTypeFTPErrorDir']			= "主機目錄不存在";
$GLOBALS['strTypeFTPErrorConnect']		= "不能連接到FTP伺服器,用戶名或者密碼錯誤";
$GLOBALS['strTypeFTPErrorHost']			= "FTP伺服器主機主機名錯誤";
$GLOBALS['strTypeDirError']			= "本地目錄不存在";

$GLOBALS['strDefaultBanners']			= "預設廣告";
$GLOBALS['strDefaultBannerUrl']			= "預設的圖片URL";
$GLOBALS['strDefaultBannerTarget']		= "預設的目標URL";

$GLOBALS['strTypeHtmlSettings']			= "HTML廣告選項";
$GLOBALS['strTypeHtmlAuto']			= "自動修改HTML廣告以記錄點擊數";
$GLOBALS['strTypeHtmlPhp']			= "允許在HTML廣告內執行php代碼";



// Host information and Geotargeting
$GLOBALS['strHostAndGeo']			= "主機信息和地域";

$GLOBALS['strRemoteHost']			= "遠程主機";
$GLOBALS['strReverseLookup']			= "如果伺服器沒有提供訪問者的主機名,反向查詢域名";
$GLOBALS['strProxyLookup']			= "如果訪問者使用了代理,查詢真實IP地址";

$GLOBALS['strGeotargeting']			= "地域";
$GLOBALS['strGeotrackingType']			= "地域資料庫類型";
$GLOBALS['strGeotrackingLocation'] 		= "地域資料庫位置";
$GLOBALS['strGeoStoreCookie']			= "保存結果到cookie中供以後參考";



// Statistics Settings
$GLOBALS['strStatisticsSettings']		= "報表設定";

$GLOBALS['strStatisticsFormat']			= "報表格式";
$GLOBALS['strCompactStats']			= "使用簡潔模式";
$GLOBALS['strLogAdviews']			= "記錄廣告訪問數";
$GLOBALS['strLogAdclicks']			= "記錄廣告點擊數";
$GLOBALS['strLogSource']			= "記錄調用過程中的來源參數";
$GLOBALS['strGeoLogStats']			= "記錄訪問者的國家";
$GLOBALS['strLogHostnameOrIP']			= "記錄訪問者的主機名和IP地址";
$GLOBALS['strLogIPOnly']			= "如果主機名未知,僅記錄訪問者的IP地址";
$GLOBALS['strLogIP']				= "記錄訪問者的IP地址";
$GLOBALS['strLogBeacon']			= "使用信號燈來記錄廣告訪問數,可以保證只記錄發送成功的廣告";

$GLOBALS['strRemoteHosts']			= "遠程主機";
$GLOBALS['strIgnoreHosts']			= "不記錄下列IP地址或者主機名的訪問者的數據";
$GLOBALS['strBlockAdviews']			= "如果訪問者已經訪問了廣告,不記錄同一廣告訪問數的時間間隔";
$GLOBALS['strBlockAdclicks']			= "如果訪問者已經點擊了廣告,不記錄同一廣告點擊數的時間間隔";


$GLOBALS['strEmailWarnings']			= "電子郵件警告";
$GLOBALS['strAdminEmailHeaders']		= "顯示每日報表發送者的郵件頭";
$GLOBALS['strWarnLimit']			= "警告限制";
$GLOBALS['strWarnLimitErr']			= "警告限制必須是一個正整數";
$GLOBALS['strWarnAdmin']			= "警告管理員";
$GLOBALS['strWarnClient']			= "警告客戶";
$GLOBALS['strQmailPatch']			= "啟用qmail補丁";

$GLOBALS['strAutoCleanTables']			= "自動清理資料庫";
$GLOBALS['strAutoCleanStats']			= "清除統計數據";
$GLOBALS['strAutoCleanUserlog']			= "清除用戶記錄";
$GLOBALS['strAutoCleanStatsWeeks']		= "統計數據的最大壽命<br>(最小3周)";
$GLOBALS['strAutoCleanUserlogWeeks']		= "用戶記錄的最大壽命<br>(最小3周)";
$GLOBALS['strAutoCleanErr']			= "最大壽命必須大於3周";
$GLOBALS['strAutoCleanVacuum']			= "每晚真空分析數據表"; // only Pg


// Administrator settings
$GLOBALS['strAdministratorSettings']		= "管理員設定";

$GLOBALS['strLoginCredentials']			= "登錄信息";
$GLOBALS['strAdminUsername']			= "管理員名字";
$GLOBALS['strOldPassword']			= "舊密碼";
$GLOBALS['strNewPassword']			= "新密碼";
$GLOBALS['strInvalidUsername']			= "錯誤用戶名";
$GLOBALS['strInvalidPassword']			= "錯誤密碼";

$GLOBALS['strBasicInformation']			= "基本信息";
$GLOBALS['strAdminFullName']			= "管理員全名";
$GLOBALS['strAdminEmail']			= "管理員的電子郵件地址";
$GLOBALS['strCompanyName']			= "公司名字";

$GLOBALS['strAdminCheckUpdates']		= "檢查更新";
$GLOBALS['strAdminCheckEveryLogin']		= "每次登錄";
$GLOBALS['strAdminCheckDaily']			= "每天";
$GLOBALS['strAdminCheckWeekly']			= "每週";
$GLOBALS['strAdminCheckMonthly']		= "每月";
$GLOBALS['strAdminCheckNever']			= "從不";

$GLOBALS['strAdminNovice']			= "管理員的刪除操作需要確認以保證安全";
$GLOBALS['strUserlogEmail']			= "記錄發出的所有電子郵件信息";
$GLOBALS['strUserlogPriority']			= "記錄每小時的優先級計算";
$GLOBALS['strUserlogAutoClean']			= "記錄資料庫的自動清理";


// User interface settings
$GLOBALS['strGuiSettings']			= "用戶界面設定";

$GLOBALS['strGeneralSettings']			= "一般設定";
$GLOBALS['strAppName']				= "程序名字";
$GLOBALS['strMyHeader']				= "頁面頂部";
$GLOBALS['strMyFooter']				= "頁面底部";
$GLOBALS['strGzipContentCompression']		= "使用GZIP內容壓縮";

$GLOBALS['strClientInterface']			= "客戶界面";
$GLOBALS['strClientWelcomeEnabled']		= "啟用客戶歡迎信息";
$GLOBALS['strClientWelcomeText']		= "歡迎文字<br>(允許HTML標記)";



// Interface defaults
$GLOBALS['strInterfaceDefaults']		= "預設界面";

$GLOBALS['strInventory']			= "詳細目錄";
$GLOBALS['strShowCampaignInfo']			= "在<i>項目總覽</i>頁面顯示額外項目信息";
$GLOBALS['strShowBannerInfo']			= "在<i>廣告總覽</i>頁面顯示額外廣告信息";
$GLOBALS['strShowCampaignPreview']		= "在<i>廣告總覽</i>頁面顯示所有廣告的預覽";
$GLOBALS['strShowBannerHTML']			= "HTML廣告的預覽顯示實際的廣告而不是普通HTML代碼";
$GLOBALS['strShowBannerPreview']		= "在處理廣告的頁面頂部顯示廣告預覽";
$GLOBALS['strHideInactive']			= "所有的總覽頁面隱藏已經停用的項目";
$GLOBALS['strGUIShowMatchingBanners']		= "在<i>連接廣告</i>頁面顯示符合的廣告";
$GLOBALS['strGUIShowParentCampaigns']		= "在<i>連接廣告</i>頁面顯示上層項目";
$GLOBALS['strGUILinkCompactLimit']		= "在<i>連接廣告</i>頁面隱藏沒有連接的項目或廣告，當數目大於";

$GLOBALS['strStatisticsDefaults'] 		= "統計數據";
$GLOBALS['strBeginOfWeek']			= "一周的開始";
$GLOBALS['strPercentageDecimals']		= "百分比精確度";

$GLOBALS['strWeightDefaults']			= "預設權重值";
$GLOBALS['strDefaultBannerWeight']		= "預設廣告權重值";
$GLOBALS['strDefaultCampaignWeight']		= "預設項目權重值";
$GLOBALS['strDefaultBannerWErr']		= "預設廣告權重值應該是一個正整數";
$GLOBALS['strDefaultCampaignWErr']		= "預設項目權重值應該是一個正整數";



// Not used at the moment
$GLOBALS['strTableBorderColor']			= "表格邊的顏色";
$GLOBALS['strTableBackColor']			= "表格的背景色";
$GLOBALS['strTableBackColorAlt']		= "表格的背景色(可選)";
$GLOBALS['strMainBackColor']			= "主要背景色";
$GLOBALS['strOverrideGD']			= "覆蓋GD圖形庫格式";
$GLOBALS['strTimeZone']				= "時區";

?>
