<?php // $Revision: 1.9 $

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2001 by the phpAdsNew developers                       */
/* http://sourceforge.net/projects/phpadsnew                            */
/*                                                                      */
/* Translations by Yen-Shuo Su <yssu@dottech.com.tw>                    */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/


// Set text direction and characterset
$GLOBALS['phpAds_TextDirection']  = "ltr";
$GLOBALS['phpAds_TextAlignRight'] = "right";
$GLOBALS['phpAds_TextAlignLeft']  = "left";
$GLOBALS['phpAds_CharSet'] 		  = "big5";


// Set translation strings
$GLOBALS['strHome'] = "首頁";
$GLOBALS['date_format'] = "%m/%d/%Y";
$GLOBALS['time_format'] = "%H:%i:%S";
$GLOBALS['strMySQLError'] = "MySQL 錯誤訊息:";
$GLOBALS['strAdminstration'] = "系統管理";
$GLOBALS['strAddClient'] = "新增客戶";
$GLOBALS['strModifyClient'] = "編輯客戶";
$GLOBALS['strDeleteClient'] = "移除客戶";
$GLOBALS['strViewClientStats'] = "檢視客戶統計數據";
$GLOBALS['strClientName'] = "客戶名稱";
$GLOBALS['strContact'] = "聯絡人";
$GLOBALS['strEMail'] = "電子郵件信箱";
$GLOBALS['strViews'] = "廣告推播數";
$GLOBALS['strClicks'] = "廣告點選數";
$GLOBALS['strTotalViews'] = "總計推播數";
$GLOBALS['strTotalClicks'] = "總計點選數";
$GLOBALS['strCTR'] = "廣告點選比 (CTR)";
$GLOBALS['strTotalClients'] = "客戶總數";
$GLOBALS['strActiveClients'] = "啟用中客戶數";
$GLOBALS['strActiveBanners'] = "啟用中廣告數";
$GLOBALS['strLogout'] = "登出";
$GLOBALS['strCreditStats'] = "";
$GLOBALS['strViewCredits'] = "推播數購買量";
$GLOBALS['strClickCredits'] = "點閱數購買量";
$GLOBALS['strPrevious'] = "上一頁";
$GLOBALS['strNext'] = "下一頁";
$GLOBALS['strNone'] = "無";
$GLOBALS['strViewsPurchased'] = "廣告推播次數購買量";
$GLOBALS['strClicksPurchased'] = "廣告點選次數購買量";
$GLOBALS['strDaysPurchased'] = "廣告天數購買量";
$GLOBALS['strHTML'] = "HTML";
$GLOBALS['strAddSep'] = "請填入上方欄位或下方欄位!";
$GLOBALS['strTextBelow'] = "廣告圖形下方文字";
$GLOBALS['strSubmit'] = "儲存廣告";
$GLOBALS['strUsername'] = "使用者代號";
$GLOBALS['strPassword'] = "使用者密碼";
$GLOBALS['strBannerAdmin'] = "廣告管理權";
$GLOBALS['strNoBanners'] = "目前無廣告";
$GLOBALS['strBanner'] = "廣告";
$GLOBALS['strCurrentBanner'] = "目前廣告";
$GLOBALS['strDelete'] = "移除";
$GLOBALS['strAddBanner'] = "新增廣告";
$GLOBALS['strModifyBanner'] = "編輯廣告內容";
$GLOBALS['strURL'] = "廣告連結網址 (包含 http://)";
$GLOBALS['strKeyword'] = "關鍵字";
$GLOBALS['strWeight'] = "專案比重";
$GLOBALS['strAlt'] = "說明文字";
$GLOBALS['strAccessDenied'] = "無權存取";
$GLOBALS['strPasswordWrong'] = "密碼不正確";
$GLOBALS['strNotAdmin'] = "您的權限等級不足";
$GLOBALS['strClientAdded'] = "成功\新增客戶";
$GLOBALS['strClientModified'] = "成功\修改客戶資料";
$GLOBALS['strClientDeleted'] = "成功\移除客戶";
$GLOBALS['strBannerAdmin'] = "廣告管理權限";
$GLOBALS['strBannerAdded'] = "成功\新增廣告";
$GLOBALS['strBannerModified'] = "成功\修改廣告資料";
$GLOBALS['strBannerDeleted'] = "成功\移除廣告";
$GLOBALS['strBannerChanged'] = "成功\更新廣告";
$GLOBALS['strStats'] = "統計數據";
$GLOBALS['strDailyStats'] = "每日統計數據";
$GLOBALS['strDetailStats'] = "詳細統計數據";
$GLOBALS['strCreditStats'] = "廣告存量統計";
$GLOBALS['strActive'] = "啟用";
$GLOBALS['strActivate'] = "啟用";
$GLOBALS['strDeActivate'] = "停用";
$GLOBALS['strAuthentification'] = "認證資訊";
$GLOBALS['strGo'] = "Go";
$GLOBALS['strLinkedTo'] = "連結至";
$GLOBALS['strBannerID'] = "廣告代碼";
$GLOBALS['strClientID'] = "客戶代碼";
$GLOBALS['strMailSubject'] = "廣告報表";
$GLOBALS['strMailSubjectDeleted'] = "已停用廣告";
$GLOBALS['strMailHeader'] = "親愛的{contact}，\n";
$GLOBALS['strMailBannerStats'] = "以下為客戶「{clientname}」的廣告統計數據:";
$GLOBALS['strMailFooter'] = "Regards，\n   {adminfullname}";
$GLOBALS['strLogMailSent'] = "[phpAds] 統計數據已成功寄送";
$GLOBALS['strLogErrorClients'] = "[phpAds] 系統從資料庫下載客戶資料時發生錯誤";
$GLOBALS['strLogErrorBanners'] = "[phpAds] 系統從資料庫下載廣告資料時發生錯誤";
$GLOBALS['strLogErrorViews'] = "[phpAds] 系統從資料庫下載廣告推播數時發生錯誤";
$GLOBALS['strLogErrorClicks'] = "[phpAds] 系統從資料庫下載廣告點選數時發生錯誤";
$GLOBALS['strLogErrorDisactivate'] = "[phpAds] 系統在停用廣告時發生錯誤";
$GLOBALS['strRatio'] = "廣告點選比 (CTR)";
$GLOBALS['strChooseBanner'] = "請選擇廣告內容儲存方式";
$GLOBALS['strMySQLBanner'] = "廣告圖形儲存於 MySQL 資料庫";
$GLOBALS['strWebBanner'] = "廣告圖形儲存於網頁主機上";
$GLOBALS['strURLBanner'] = "廣告圖形連結到特定網址";
$GLOBALS['strHTMLBanner'] = "HTML 文件型廣告";
$GLOBALS['strNewBannerFile'] = "廣告圖形檔案";
$GLOBALS['strNewBannerURL'] = "廣告圖形網址 (包含 http://)";
$GLOBALS['strWidth'] = "寬度";
$GLOBALS['strHeight'] = "高度";
$GLOBALS['strTotalViews7Days'] = "過去七日廣告推播數總計";
$GLOBALS['strTotalClicks7Days'] = "過去七日廣告點選數總計";
$GLOBALS['strAvgViews7Days'] = "過去七日廣告推播數平均";
$GLOBALS['strAvgClicks7Days'] = "過去七日廣告點選數平均";
$GLOBALS['strTopTenHosts'] = "Top ten requesting hosts";
$GLOBALS['strClientIP'] = "使用者來源位址";
$GLOBALS['strUserAgent'] = "使用者瀏覽器(Regexp)";
$GLOBALS['strWeekDay'] = "星期 (0 - 6)";
$GLOBALS['strDomain'] = "網域名稱 (不含點)";
$GLOBALS['strSource'] = "來源代碼";
$GLOBALS['strTime'] = "時間";
$GLOBALS['strAllow'] = "符合";
$GLOBALS['strDeny'] = "不符合";
$GLOBALS['strResetStats'] = "重新開始統計";
$GLOBALS['strExpiration'] = "廣告失效日期";
$GLOBALS['strNoExpiration'] = "未設定失效日期";
$GLOBALS['strDaysLeft'] = "剩餘天數";
$GLOBALS['strEstimated'] = "預估失效日期";
$GLOBALS['strConfirm'] = "您是否確定 ?";
$GLOBALS['strBannerNoStats'] = "目前沒有這個廣告的統計數據";
$GLOBALS['strWeek'] = "週數";
$GLOBALS['strWeeklyStats'] = "每週統計報表";
$GLOBALS['strWeekDay'] = "星期";
$GLOBALS['strDate'] = "日期";
$GLOBALS['strCTRShort'] = "CTR";
$GLOBALS['strDayShortCuts'] = array("日","一","二","三","四","五","六");
$GLOBALS['strShowWeeks'] = "最多顯示週數";
$GLOBALS['strAll'] = "全部";
$GLOBALS['strAvg'] = "平均";
$GLOBALS['strHourly'] = "每小時推播數/點選數";
$GLOBALS['strTotal'] = "總計";
$GLOBALS['strUnlimited'] = "無限制";
$GLOBALS['strSave'] = "儲存";
$GLOBALS['strUp'] = "上移";
$GLOBALS['strDown'] = "下移";
$GLOBALS['strSaved'] = "已成功\儲存!";
$GLOBALS['strDeleted'] = "已成功\移除!";
$GLOBALS['strMovedUp'] = "已往上移";
$GLOBALS['strMovedDown'] = "已往下移";
$GLOBALS['strUpdated'] = "已成功\更新";
$GLOBALS['strLogin'] = "登入";
$GLOBALS['strPreferences'] = "喜好設定";
$GLOBALS['strAllowClientModifyInfo'] = "允許該使用者更動客戶基本資料";
$GLOBALS['strAllowClientModifyBanner'] = "允許該使用者更動廣告內容";
$GLOBALS['strAllowClientAddBanner'] = "允許該使用者新增廣告";
$GLOBALS['strLanguage'] = "使用語言";
$GLOBALS['strDefault'] = "預設值";
$GLOBALS['strErrorViews'] = "您需要輸入推播數量或是選擇無限制選項!";
$GLOBALS['strErrorNegViews'] = "推播數量無法使用負數";
$GLOBALS['strErrorClicks'] =  "您需要輸入點選數量或是選擇無限制選項!";
$GLOBALS['strErrorNegClicks'] = "點選數量無法使用負數";
$GLOBALS['strErrorDays'] = "您需要輸入購買天數或是選擇無限制選項!";
$GLOBALS['strErrorNegDays'] = "購買天數無法使用負數";
$GLOBALS['strTrackerImage'] = "追蹤圖形：";

// New strings for version 2
$GLOBALS['strNavigation'] 				= "選項";
$GLOBALS['strShortcuts'] 				= "捷徑";
$GLOBALS['strDescription'] 				= "內容敘述";
$GLOBALS['strClients'] 					= "客戶";
$GLOBALS['strID']				 		= "代碼";
$GLOBALS['strOverall'] 					= "總覽";
$GLOBALS['strTotalBanners'] 			= "廣告總數";
$GLOBALS['strToday'] 					= "本日";
$GLOBALS['strThisWeek'] 				= "本週";
$GLOBALS['strThisMonth'] 				= "本月";
$GLOBALS['strBasicInformation'] 		= "基本資料";
$GLOBALS['strContractInformation'] 		= "合約資料";
$GLOBALS['strLoginInformation'] 		= "登入資料";
$GLOBALS['strPermissions'] 				= "權限";
$GLOBALS['strGeneralSettings']			= "一般設定";
$GLOBALS['strSaveChanges']		 		= "儲存資料";
$GLOBALS['strCompact']					= "精簡格式";
$GLOBALS['strVerbose']					= "完整格式";
$GLOBALS['strOrderBy']					= "排序條件為";
$GLOBALS['strShowAllBanners']	 		= "列出全部廣告";
$GLOBALS['strShowBannersNoAdClicks']	= "列出無點選數的廣告";
$GLOBALS['strShowBannersNoAdViews']		= "列出無推播數的廣告";
$GLOBALS['strShowAllClients'] 			= "列出全部客戶";
$GLOBALS['strShowClientsActive'] 		= "列出目前有啟用中廣告的客戶";
$GLOBALS['strShowClientsInactive']		= "列出目前有停用中廣告的客戶";
$GLOBALS['strSize']						= "尺寸";

$GLOBALS['strMonth'] 					= array("一月","二月","三月","四月","五月","六月","七月","八月","九月","十月","十一月","十二月");
$GLOBALS['strDontExpire']				= "此專案永遠不失效";
$GLOBALS['strActivateNow'] 				= "即刻啟用此專案";
$GLOBALS['strExpirationDate']			= "失效日期";
$GLOBALS['strActivationDate']			= "啟用日期";

$GLOBALS['strMailClientDeactivated'] 	= "下列廣告以被停用，原因：";
$GLOBALS['strMailNothingLeft'] 			= "如果您願意繼續在敝網站刊登廣告，煩請和我們聯絡，\n我們非常樂意為您服務。";
$GLOBALS['strClientDeactivated']		= "此專案已被停用，原因：";
$GLOBALS['strBeforeActivate']			= "未達廣告啟用日";
$GLOBALS['strAfterExpire']				= "廣告失效日期已過";
$GLOBALS['strNoMoreClicks']				= "已達點選數購買量";
$GLOBALS['strNoMoreViews']				= "已達推播數購買量";

$GLOBALS['strBanners'] 					= "廣告";
$GLOBALS['strCampaigns']				= "專案";
$GLOBALS['strCampaign']					= "專案";
$GLOBALS['strModifyCampaign']			= "編輯專案";
$GLOBALS['strName']						= "名稱";
$GLOBALS['strBannersWithoutCampaign']	= "不屬於任何專案的廣告";
$GLOBALS['strMoveToNewCampaign']		= "移動至新的專案";
$GLOBALS['strCreateNewCampaign']		= "新增專案";
$GLOBALS['strEditCampaign']				= "編輯專案";
$GLOBALS['strEdit']						= "編輯";
$GLOBALS['strCreate']					= "新增";
$GLOBALS['strUntitled']					= "未命名";

$GLOBALS['strTotalCampaigns'] 			= "專案總數";
$GLOBALS['strActiveCampaigns'] 			= "啟用中專案總數";

$GLOBALS['strLinkedTo']					= "連結到";
$GLOBALS['strSendAdvertisingReport']	= "使用電子郵件傳送廣告效益報表";
$GLOBALS['strNoDaysBetweenReports']		= "廣告效益報表寄送間隔";
$GLOBALS['strSendDeactivationWarning']  = "當廣告專案被停用時傳送警示電子郵件";

$GLOBALS['strWarnClientTxt']			= "您所托播的廣告推播數或點選數存量已剩下 {limit} 次。\n當推播數或點選數存量已用盡時，您的廣告將會自動停用。";
$GLOBALS['strViewsClicksLow']			= "廣告推播數或點選數存量過低";

$GLOBALS['strDays']						= "日期";
$GLOBALS['strHistory']					= "歷史記錄";
$GLOBALS['strAverage']					= "平均";
$GLOBALS['strDuplicateClientName']		= "您所使用的使用者代碼已經有人使用了，請更換其他的使用者代碼。";
$GLOBALS['strAllowClientDisableBanner'] = "允許該使用者停用廣告";
$GLOBALS['strAllowClientActivateBanner'] = "允許該使用者啟用廣告";

$GLOBALS['strGenerateBannercode']		= "自動產生網頁原始碼";
$GLOBALS['strChooseInvocationType']		= "請選擇廣告原始碼型態";
$GLOBALS['strGenerate']					= "產生";
$GLOBALS['strParameters']				= "參數設定";
$GLOBALS['strUniqueidentifier']			= "廣告辨識代碼";
$GLOBALS['strFrameSize']				= "分頁尺寸";
$GLOBALS['strBannercode']				= "網頁原始碼";

$GLOBALS['strSearch']					= "搜尋";
$GLOBALS['strNoMatchesFound']			= "沒有找到符合的資料";

$GLOBALS['strNoViewLoggedInInterval']   = "本報告的統計期間中沒有任何的點選動作";
$GLOBALS['strNoClickLoggedInInterval']  = "本報告的統計期間中沒有任何的推播動作";
$GLOBALS['strMailReportPeriod']			= "本報表包含了自 {startdate} 至 {enddate} 的統計數據。";
$GLOBALS['strMailReportPeriodAll']		= "本報表包含了至 {enddate} 的所有統計數據。";
$GLOBALS['strNoStatsForCampaign'] 		= "本專案目前沒有任何的統計數據";
$GLOBALS['strFrom']						= "自";
$GLOBALS['strTo']						= "至";
$GLOBALS['strMaintenance']				= "維護";
$GLOBALS['strCampaignStats']			= "專案統計";
$GLOBALS['strClientStats']				= "客戶統計";
$GLOBALS['strErrorOccurred']			= "發生錯誤";
$GLOBALS['strAdReportSent']				= "廣告效益報表已寄送完成";

$GLOBALS['strAutoChangeHTML']			= "自動轉換 HTML 原始碼以記錄廣告點選數";

$GLOBALS['strZones']					= "版位";
$GLOBALS['strAddZone']					= "增加版位";
$GLOBALS['strModifyZone']				= "編輯版位";
$GLOBALS['strAddNewZone']				= "新增版位";

$GLOBALS['strOverview']					= "總覽";
$GLOBALS['strEqualTo']					= "符合";
$GLOBALS['strDifferentFrom']			= "不符合";
$GLOBALS['strAND']						= "AND(且)";  // logical operator
$GLOBALS['strOR']						= "OR(或)"; // logical operator
$GLOBALS['strOnlyDisplayWhen']			= "當下列條件成立時才推播廣告：";

$GLOBALS['strStatusText']				= "狀態列文字";

$GLOBALS['strConfirmDeleteClient'] 		= "是否確定要移除此客戶?";
$GLOBALS['strConfirmDeleteCampaign']	= "是否確定要移除此專案?";
$GLOBALS['strConfirmDeleteBanner']		= "是否確定要移除此廣告?";
$GLOBALS['strConfirmDeleteZone']		= "Do you really want to delete this zone?";
$GLOBALS['strConfirmDeleteAffiliate']	= "Do you really want to delete this affiliate?";

$GLOBALS['strConfirmResetStats']		= "是否確定要重設統計數據?";
$GLOBALS['strConfirmResetCampaignStats']= "是否確定要重設此專案統計數據?";
$GLOBALS['strConfirmResetClientStats']	= "是否確定要重設此客戶統計數據?";
$GLOBALS['strConfirmResetBannerStats']	= "是否確定要重設此廣告統計數據?";

$GLOBALS['strClientsAndCampaigns']		= "客戶 & 專案";
$GLOBALS['strCampaignOverview']			= "專案總覽";
$GLOBALS['strReports']					= "廣告效益報表";
$GLOBALS['strShowBanner']				= "顯示廣告";

$GLOBALS['strIncludedBanners']			= "連結廣告";
$GLOBALS['strProbability']				= "推播比例";
$GLOBALS['strInvocationcode']			= "產生網頁原始碼";
$GLOBALS['strSelectZoneType']			= "請選擇版位與廣告連結的檢視方式";
$GLOBALS['strBannerSelection']			= "廣告列表";
$GLOBALS['strInteractive']				= "互動連結";
$GLOBALS['strRawQueryString']			= "詳細內容";

$GLOBALS['strBannerWeight']				= "廣告比重";
$GLOBALS['strCampaignWeight']			= "專案比重";

$GLOBALS['strZoneCacheOn']				= "版位快取暫存空間已啟用";
$GLOBALS['strZoneCacheOff']				= "版位快取暫存空間已停用";
$GLOBALS['strCachedZones']				= "已暫存的版位";
$GLOBALS['strSizeOfCache']				= "版位空間";
$GLOBALS['strAverageAge']				= "平均停留時數";
$GLOBALS['strRebuildZoneCache']			= "重建版位快取暫存空間";
$GLOBALS['strKiloByte']					= "KB";
$GLOBALS['strSeconds']					= "秒";
$GLOBALS['strExpired']					= "已失效";

$GLOBALS['strModifyBannerAcl'] 			= "推播限制";
$GLOBALS['strACL'] 						= "限制";
$GLOBALS['strNoMoveUp'] 				= "無法將第一筆資料往上移";
$GLOBALS['strACLAdd'] 					= "新增推播限制";
$GLOBALS['strNoLimitations']			= "無限制";

$GLOBALS['strLinkedZones']				= "連結版位";
$GLOBALS['strNoZonesToLink']			= "目前沒有任何版位可以和此廣告連結";
$GLOBALS['strNoZones']					= "There are currently no zones defined";
$GLOBALS['strNoClients']				= "There are currently no clients defined";
$GLOBALS['strNoStats']					= "There are currently no statistics available";
$GLOBALS['strNoAffiliates']				= "There are currently no affiliates defined";

$GLOBALS['strCustom']					= "自訂";

$GLOBALS['strSettings'] 				= "Settings";

$GLOBALS['strAffiliates']				= "Affiliates";
$GLOBALS['strAffiliatesAndZones']		= "Affiliates & Zones";
$GLOBALS['strAddAffiliate']				= "Create affiliate";
$GLOBALS['strModifyAffiliate']			= "Modify affiliate";
$GLOBALS['strAddNewAffiliate']			= "Add new affiliate";

$GLOBALS['strCheckAllNone']				= "Check all / none";

$GLOBALS['strAllowAffiliateModifyInfo'] = "Allow this user to modify his own affiliate information";
$GLOBALS['strAllowAffiliateModifyZones'] = "Allow this user to modify his own zones";
$GLOBALS['strAllowAffiliateLinkBanners'] = "Allow this user to link banners to his own zones";
$GLOBALS['strAllowAffiliateAddZone'] = "Allow this user to define new zones";
$GLOBALS['strAllowAffiliateDeleteZone'] = "Allow this user to delete existing zones";

$GLOBALS['strPriority']					= "Priority";
$GLOBALS['strHighPriority']				= "Show banners in this campaign with high priority.<br>
										   If you use this option phpAdsNew will try to distribute the 
										   number of AdViews evenly over the course of the day.";
$GLOBALS['strLowPriority']				= "Show banner in this campaign with low priority.<br>
										   This campaign is used to show the left over AdViews which 
										   aren't used by high priority campaigns.";
$GLOBALS['strTargetLimitAdviews']		= "Limit the number of AdViews to";
$GLOBALS['strTargetPerDay']				= "per day.";
$GLOBALS['strRecalculatePriority']		= "Recalculate priority";

$GLOBALS['strProperties']				= "Properties";
$GLOBALS['strAffiliateProperties']		= "Affiliate properties";
$GLOBALS['strBannerOverview']			= "Banner overview";
$GLOBALS['strBannerProperties']			= "Banner properties";
$GLOBALS['strCampaignProperties']		= "Campaign properties";
$GLOBALS['strClientProperties']			= "Client properties";
$GLOBALS['strZoneOverview']				= "Zone overview";
$GLOBALS['strZoneProperties']			= "Zone properties";
$GLOBALS['strAffiliateOverview']		= "Affiliate overview";
$GLOBALS['strLinkedBannersOverview']	= "Linked banners overview";

$GLOBALS['strGlobalHistory']			= "Global history";
$GLOBALS['strBannerHistory']			= "Banner history";
$GLOBALS['strCampaignHistory']			= "Campaign history";
$GLOBALS['strClientHistory']			= "Client history";
$GLOBALS['strAffiliateHistory']			= "Affiliate history";
$GLOBALS['strZoneHistory']				= "Zone history";
$GLOBALS['strLinkedBannerHistory']		= "Linked banner history";

$GLOBALS['strMoveTo']					= "Move to";
$GLOBALS['strDuplicate']				= "Duplicate";

$GLOBALS['strMainSettings']				= "Main settings";
$GLOBALS['strAdminSettings']			= "Administration settings";

$GLOBALS['strApplyLimitationsTo']		= "Apply limitations to";
$GLOBALS['strWholeCampaign']			= "Whole campaign";
$GLOBALS['strZonesWithoutAffiliate']	= "Zones without affiliate";
$GLOBALS['strMoveToNewAffiliate']		= "Move to new affiliate";

$GLOBALS['strNoBannersToLink']			= "There are currently no banners available which can be linked to this zone";
$GLOBALS['strNoLinkedBanners']			= "There are no banners available which are linked to this zone";

$GLOBALS['strAdviewsLimit']				= "AdViews limit";

$GLOBALS['strTotalThisPeriod']			= "Total this period";
$GLOBALS['strAverageThisPeriod']		= "Average this period";
$GLOBALS['strLast7Days']				= "Last 7 days";
$GLOBALS['strDistribution']				= "Distribution";
$GLOBALS['strOther']					= "Other";
$GLOBALS['strUnknown']					= "Unknown";

$GLOBALS['strWelcomeTo']				= "Welcome to";
$GLOBALS['strEnterUsername']			= "Enter your username and password to log in";

$GLOBALS['strBannerNetwork']			= "Banner network";
$GLOBALS['strMoreInformation']			= "More information...";
$GLOBALS['strChooseNetwork']			= "Choose the banner network you want to use";
$GLOBALS['strRichMedia']				= "Richmedia";
$GLOBALS['strTrackAdClicks']			= "Track AdClicks";
$GLOBALS['strYes']						= "Yes";
$GLOBALS['strNo']						= "No";
$GLOBALS['strUploadOrKeep']				= "Do you wish to keep your <br>existing image, or do you <br>want to upload another?";
$GLOBALS['strCheckSWF']					= "Check for hard-coded links inside the Flash file";
$GLOBALS['strURL2']						= "URL";
$GLOBALS['strTarget']					= "Target";
$GLOBALS['strConvert']					= "Convert";
$GLOBALS['strCancel']					= "Cancel";

$GLOBALS['strConvertSWFLinks']			= "Convert Flash links";
$GLOBALS['strConvertSWF']				= "<br>The Flash file you just uploaded contains hard-coded urls. phpAdsNew won't be ".
										  "able to track the number of AdClicks for this banner unless you convert these ".
										  "hard-coded urls. Below you will find a list of all urls inside the Flash file. ".
										  "If you want to convert the urls, simply click <b>Convert</b>, otherwise click ".
										  "<b>Cancel</b>.<br><br>".
										  "Please note: if you click <b>Convert</b> the Flash file ".
									  	  "you just uploaded will be physically altered. <br>Please keep a backup of the ".
										  "original file. Regardless of in which version this banner was created, the resulting ".
										  "file will need the Flash 4 player (or higher) to display correctly.<br><br>";

$GLOBALS['strSourceStats']				= "Source Stats";
$GLOBALS['strSelectSource']				= "Select the source you want to view:";

?>