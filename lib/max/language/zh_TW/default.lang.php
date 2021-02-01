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

// Set text direction and characterset
$GLOBALS['phpAds_TextDirection'] = "ltr";
$GLOBALS['phpAds_TextAlignRight'] = "right";
$GLOBALS['phpAds_TextAlignLeft'] = "left";
$GLOBALS['phpAds_CharSet'] = "UTF-8";

$GLOBALS['phpAds_DecimalPoint'] = ".";
$GLOBALS['phpAds_ThousandsSeperator'] = ",";

// Date & time configuration
$GLOBALS['date_format'] = "%d-%m-%Y";
$GLOBALS['time_format'] = "%H:%M:%S";
$GLOBALS['minute_format'] = "%H:%M";
$GLOBALS['month_format'] = "%m-%Y";
$GLOBALS['day_format'] = "%d-%m";
$GLOBALS['week_format'] = "%W-%Y";
$GLOBALS['weekiso_format'] = "%V-%G";

// Formats used by PEAR Spreadsheet_Excel_Writer packate
$GLOBALS['excel_integer_formatting'] = "#,##0;-#,##0;-";
$GLOBALS['excel_decimal_formatting'] = "#,##0.000;-#,##0.000;-";

/* ------------------------------------------------------- */
/* Translations                                          */
/* ------------------------------------------------------- */

$GLOBALS['strHome'] = "主頁";
$GLOBALS['strHelp'] = "幫助";
$GLOBALS['strStartOver'] = "重新開始";
$GLOBALS['strShortcuts'] = "快捷方式";
$GLOBALS['strActions'] = "操作";
$GLOBALS['strAndXMore'] = "and %s more";
$GLOBALS['strAdminstration'] = "系統管理";
$GLOBALS['strMaintenance'] = "維護";
$GLOBALS['strProbability'] = "Probability";
$GLOBALS['strInvocationcode'] = "調用代碼";
$GLOBALS['strBasicInformation'] = "基本信息";
$GLOBALS['strAppendTrackerCode'] = "附加跟蹤碼";
$GLOBALS['strOverview'] = "Overview";
$GLOBALS['strSearch'] = "<u>搜索</u>";
$GLOBALS['strDetails'] = "詳細";
$GLOBALS['strUpdateSettings'] = "Update Settings";
$GLOBALS['strCheckForUpdates'] = "查找更新";
$GLOBALS['strWhenCheckingForUpdates'] = "When checking for updates";
$GLOBALS['strCompact'] = "壓縮";
$GLOBALS['strUser'] = "用戶";
$GLOBALS['strDuplicate'] = "複製";
$GLOBALS['strCopyOf'] = "Copy of";
$GLOBALS['strMoveTo'] = "移動到";
$GLOBALS['strDelete'] = "刪除";
$GLOBALS['strActivate'] = "激活";
$GLOBALS['strConvert'] = "轉換";
$GLOBALS['strRefresh'] = "刷新";
$GLOBALS['strSaveChanges'] = "保存更改";
$GLOBALS['strUp'] = "上";
$GLOBALS['strDown'] = "下";
$GLOBALS['strSave'] = "保存";
$GLOBALS['strCancel'] = "取消";
$GLOBALS['strBack'] = "回退";
$GLOBALS['strPrevious'] = "上一步";
$GLOBALS['strNext'] = "下一步";
$GLOBALS['strYes'] = "是";
$GLOBALS['strNo'] = "否";
$GLOBALS['strNone'] = "無";
$GLOBALS['strCustom'] = "定制";
$GLOBALS['strDefault'] = "默認";
$GLOBALS['strUnknown'] = "Unknown";
$GLOBALS['strUnlimited'] = "無限制";
$GLOBALS['strUntitled'] = "未命名";
$GLOBALS['strAll'] = "all";
$GLOBALS['strAverage'] = "平均";
$GLOBALS['strOverall'] = "Overall";
$GLOBALS['strTotal'] = "合計";
$GLOBALS['strFrom'] = "From";
$GLOBALS['strTo'] = "到";
$GLOBALS['strAdd'] = "Add";
$GLOBALS['strLinkedTo'] = "連接到";
$GLOBALS['strDaysLeft'] = "剩餘天數";
$GLOBALS['strCheckAllNone'] = "全選/取消全選";
$GLOBALS['strKiloByte'] = "KB";
$GLOBALS['strExpandAll'] = "<u>全部展開</u>";
$GLOBALS['strCollapseAll'] = "<u>全部收起</u>";
$GLOBALS['strShowAll'] = "顯示全部";
$GLOBALS['strNoAdminInterface'] = "管理界面將會在維護之後關閉，但不會影響你正在投放的項目。";
$GLOBALS['strFieldStartDateBeforeEnd'] = "'From' date must be earlier then 'To' date";
$GLOBALS['strFieldContainsErrors'] = "The following fields contain errors:";
$GLOBALS['strFieldFixBeforeContinue1'] = "在繼續之前，您需要";
$GLOBALS['strFieldFixBeforeContinue2'] = "糾正這些錯誤";
$GLOBALS['strMiscellaneous'] = "雜項";
$GLOBALS['strCollectedAllStats'] = "所有統計數據";
$GLOBALS['strCollectedToday'] = "今天";
$GLOBALS['strCollectedYesterday'] = "昨天";
$GLOBALS['strCollectedThisWeek'] = "本周";
$GLOBALS['strCollectedLastWeek'] = "上周";
$GLOBALS['strCollectedThisMonth'] = "本月";
$GLOBALS['strCollectedLastMonth'] = "上月";
$GLOBALS['strCollectedLast7Days'] = "過去7天";
$GLOBALS['strCollectedSpecificDates'] = "特殊數據";
$GLOBALS['strValue'] = "值";
$GLOBALS['strWarning'] = "警告";
$GLOBALS['strNotice'] = "提示";

// Dashboard
$GLOBALS['strDashboardCantBeDisplayed'] = "The dashboard can not be displayed";
$GLOBALS['strNoCheckForUpdates'] = "The dashboard cannot be displayed unless the<br />check for updates setting is enabled.";
$GLOBALS['strEnableCheckForUpdates'] = "Please enable the <a href='account-settings-update.php' target='_top'>check for updates</a> setting on the<br/><a href='account-settings-update.php' target='_top'>update settings</a> page.";
// Dashboard Errors
$GLOBALS['strDashboardErrorCode'] = "code";
$GLOBALS['strDashboardSystemMessage'] = "System message";
$GLOBALS['strDashboardErrorHelp'] = "If this error repeats please describe your problem in detail and post it on <a href='http://forum.revive-adserver.com/'>forum.revive-adserver.com/</a>.";

// Priority
$GLOBALS['strPriority'] = "優先";
$GLOBALS['strPriorityLevel'] = "優先級";
$GLOBALS['strOverrideAds'] = "Override Campaign Advertisements";
$GLOBALS['strHighAds'] = "Contract Campaign Advertisements";
$GLOBALS['strECPMAds'] = "eCPM Campaign Advertisements";
$GLOBALS['strLowAds'] = "Remnant Campaign Advertisements";
$GLOBALS['strLimitations'] = "Delivery rules";
$GLOBALS['strNoLimitations'] = "No delivery rules";
$GLOBALS['strCapping'] = "上限";

// Properties
$GLOBALS['strName'] = "名稱";
$GLOBALS['strSize'] = "大小";
$GLOBALS['strWidth'] = "寬";
$GLOBALS['strHeight'] = "高";
$GLOBALS['strTarget'] = "目標";
$GLOBALS['strLanguage'] = "語言";
$GLOBALS['strDescription'] = "Description";
$GLOBALS['strVariables'] = "變量";
$GLOBALS['strID'] = "ID";
$GLOBALS['strComments'] = "注釋";

// User access
$GLOBALS['strWorkingAs'] = "用作";
$GLOBALS['strWorkingAs_Key'] = "<u>W</u>orking as";
$GLOBALS['strWorkingAs'] = "用作";
$GLOBALS['strSwitchTo'] = "Switch to";
$GLOBALS['strUseSearchBoxToFindMoreAccounts'] = "Use the switcher's search box to find more accounts";
$GLOBALS['strWorkingFor'] = "%s用於";
$GLOBALS['strNoAccountWithXInNameFound'] = "No accounts with \"%s\" in name found";
$GLOBALS['strRecentlyUsed'] = "Recently used";
$GLOBALS['strLinkUser'] = "Add user";
$GLOBALS['strLinkUser_Key'] = "Add <u>u</u>ser";
$GLOBALS['strUsernameToLink'] = "將被添加用戶的姓名";
$GLOBALS['strNewUserWillBeCreated'] = "將創建新用戶";
$GLOBALS['strToLinkProvideEmail'] = "如想新增用戶,請提供用戶電子郵件";
$GLOBALS['strToLinkProvideUsername'] = "如想新增用戶,請提供用戶名稱";
$GLOBALS['strUserLinkedToAccount'] = "用戶已經被添加到賬號內";
$GLOBALS['strUserAccountUpdated'] = "用戶賬號已經更新";
$GLOBALS['strUserUnlinkedFromAccount'] = "用戶已經從賬號內被刪除";
$GLOBALS['strUserWasDeleted'] = "用戶已經被刪除";
$GLOBALS['strUserNotLinkedWithAccount'] = "Such user is not linked with account";
$GLOBALS['strCantDeleteOneAdminUser'] = "You can't delete a user. At least one user needs to be linked with admin account.";
$GLOBALS['strLinkUserHelp'] = "To add an <b>existing user</b>, type the %1\$s and click %2\$s <br />To add a <b>new user</b>, type the desired %1\$s and click %2\$s";
$GLOBALS['strLinkUserHelpUser'] = "用戶名";
$GLOBALS['strLinkUserHelpEmail'] = "電子郵件地址";
$GLOBALS['strLastLoggedIn'] = "Last logged in";
$GLOBALS['strDateLinked'] = "Date linked";

// Login & Permissions
$GLOBALS['strUserAccess'] = "用戶訪問";
$GLOBALS['strAdminAccess'] = "Admin Access";
$GLOBALS['strUserProperties'] = "廣告屬性";
$GLOBALS['strPermissions'] = "權限";
$GLOBALS['strAuthentification'] = "認證";
$GLOBALS['strWelcomeTo'] = "歡迎來到";
$GLOBALS['strEnterUsername'] = "請填入你的用戶名和密碼";
$GLOBALS['strEnterBoth'] = "請填入你的用戶名和密碼";
$GLOBALS['strEnableCookies'] = "You need to enable cookies before you can use {$PRODUCT_NAME}";
$GLOBALS['strSessionIDNotMatch'] = "Session cookie error, please log in again";
$GLOBALS['strLogin'] = "登錄";
$GLOBALS['strLogout'] = "退出";
$GLOBALS['strUsername'] = "用戶名";
$GLOBALS['strPassword'] = "密碼";
$GLOBALS['strPasswordRepeat'] = "重複輸入密碼";
$GLOBALS['strAccessDenied'] = "拒絕訪問";
$GLOBALS['strUsernameOrPasswordWrong'] = "用戶名或密碼不正確，請重新輸入";
$GLOBALS['strPasswordWrong'] = "密碼不正確";
$GLOBALS['strNotAdmin'] = "Your account does not have the required permissions to use this feature, you can log into another account to use it.";
$GLOBALS['strDuplicateClientName'] = "用戶名已經存在，請重新選擇用戶名";
$GLOBALS['strInvalidPassword'] = "新密碼無效，請重新選擇密碼";
$GLOBALS['strInvalidEmail'] = "The email is not correctly formatted, please put a correct email address.";
$GLOBALS['strNotSamePasswords'] = "兩次輸入的密碼不一致";
$GLOBALS['strRepeatPassword'] = "重複輸入密碼";
$GLOBALS['strDeadLink'] = "Your link is invalid.";
$GLOBALS['strNoPlacement'] = "Selected campaign does not exist. Try this <a href='{link}'>link</a> instead";
$GLOBALS['strNoAdvertiser'] = "Selected advertiser does not exist. Try this <a href='{link}'>link</a> instead";

// General advertising
$GLOBALS['strRequests'] = "請求";
$GLOBALS['strImpressions'] = "曝光量";
$GLOBALS['strClicks'] = "點擊";
$GLOBALS['strConversions'] = "轉化";
$GLOBALS['strCTRShort'] = "CTR";
$GLOBALS['strCNVRShort'] = "SR";
$GLOBALS['strCTR'] = "Click-Through Ratio";
$GLOBALS['strTotalClicks'] = "Total Clicks";
$GLOBALS['strTotalConversions'] = "Total Conversions";
$GLOBALS['strDateTime'] = "每日時間";
$GLOBALS['strTrackerID'] = "跟蹤ID";
$GLOBALS['strTrackerName'] = "跟蹤器名稱";
$GLOBALS['strTrackerImageTag'] = "Image Tag";
$GLOBALS['strTrackerJsTag'] = "Javascript Tag";
$GLOBALS['strTrackerAlwaysAppend'] = "Always display appended code, even if no conversion is recorded by the tracker?";
$GLOBALS['strBanners'] = "廣告";
$GLOBALS['strCampaigns'] = "項目";
$GLOBALS['strCampaignID'] = "項目ID";
$GLOBALS['strCampaignName'] = "項目名稱";
$GLOBALS['strCountry'] = "國家";
$GLOBALS['strStatsAction'] = "操作";
$GLOBALS['strWindowDelay'] = "窗口延時";
$GLOBALS['strStatsVariables'] = "變量";

// Finance
$GLOBALS['strFinanceCPM'] = "千人成本";
$GLOBALS['strFinanceCPC'] = "每次點擊的費用";
$GLOBALS['strFinanceCPA'] = "每次行動的費用";
$GLOBALS['strFinanceMT'] = "月租";
$GLOBALS['strFinanceCTR'] = "CTR";
$GLOBALS['strFinanceCR'] = "CR";

// Time and date related
$GLOBALS['strDate'] = "日期";
$GLOBALS['strDay'] = "日";
$GLOBALS['strDays'] = "日";
$GLOBALS['strWeek'] = "周";
$GLOBALS['strWeeks'] = "周";
$GLOBALS['strSingleMonth'] = "月";
$GLOBALS['strMonths'] = "月";
$GLOBALS['strDayOfWeek'] = "周一至周七";


if (!isset($GLOBALS['strDayFullNames'])) {
    $GLOBALS['strDayFullNames'] = array();
}
$GLOBALS['strDayFullNames'][0] = 'Sunday';
$GLOBALS['strDayFullNames'][1] = 'Monday';
$GLOBALS['strDayFullNames'][2] = 'Tuesday';
$GLOBALS['strDayFullNames'][3] = 'Wednesday';
$GLOBALS['strDayFullNames'][4] = 'Thursday';
$GLOBALS['strDayFullNames'][5] = 'Friday';
$GLOBALS['strDayFullNames'][6] = 'Saturday';

if (!isset($GLOBALS['strDayShortCuts'])) {
    $GLOBALS['strDayShortCuts'] = array();
}
$GLOBALS['strDayShortCuts'][0] = 'Su';
$GLOBALS['strDayShortCuts'][1] = 'Mo';
$GLOBALS['strDayShortCuts'][2] = 'Tu';
$GLOBALS['strDayShortCuts'][3] = 'We';
$GLOBALS['strDayShortCuts'][4] = 'Th';
$GLOBALS['strDayShortCuts'][5] = 'Fr';
$GLOBALS['strDayShortCuts'][6] = 'Sa';

$GLOBALS['strHour'] = "小時";
$GLOBALS['strSeconds'] = "秒";
$GLOBALS['strMinutes'] = "分鐘";
$GLOBALS['strHours'] = "小時";

// Advertiser
$GLOBALS['strClient'] = "廣告商";
$GLOBALS['strClients'] = "客戶";
$GLOBALS['strClientsAndCampaigns'] = "廣告商與項目";
$GLOBALS['strAddClient'] = "新增廣告商";
$GLOBALS['strClientProperties'] = "廣告商屬性";
$GLOBALS['strClientHistory'] = "Advertiser Statistics";
$GLOBALS['strNoClients'] = "目前沒有廣告，請先<a href='advertiser-edit.php'>創建</a>";
$GLOBALS['strConfirmDeleteClient'] = "您真的希望刪除該廣告商";
$GLOBALS['strConfirmDeleteClients'] = "您真的希望刪除該廣告商";
$GLOBALS['strHideInactive'] = "Hide inactive";
$GLOBALS['strInactiveAdvertisersHidden'] = "不顯示停用的廣告商";
$GLOBALS['strAdvertiserSignup'] = "註冊廣告主";
$GLOBALS['strAdvertiserCampaigns'] = "廣告商與項目";

// Advertisers properties
$GLOBALS['strContact'] = "聯繫人";
$GLOBALS['strContactName'] = "聯繫人名稱";
$GLOBALS['strEMail'] = "電子郵件";
$GLOBALS['strSendAdvertisingReport'] = "Email campaign delivery reports";
$GLOBALS['strNoDaysBetweenReports'] = "Number of days between campaign delivery reports";
$GLOBALS['strSendDeactivationWarning'] = "Email when a campaign is automatically activated/deactivated";
$GLOBALS['strAllowClientModifyBanner'] = "允許用戶修改自己版面";
$GLOBALS['strAllowClientDisableBanner'] = "允許用戶修改自己版面";
$GLOBALS['strAllowClientActivateBanner'] = "允許用戶修改自己版面";
$GLOBALS['strAllowCreateAccounts'] = "Allow this user to manage this account's users";
$GLOBALS['strAdvertiserLimitation'] = "Display only one banner from this advertiser on a web page";
$GLOBALS['strAllowAuditTrailAccess'] = "Allow this user to access the audit trail";
$GLOBALS['strAllowDeleteItems'] = "Allow this user to delete items";

// Campaign
$GLOBALS['strCampaign'] = "項目";
$GLOBALS['strCampaigns'] = "項目";
$GLOBALS['strAddCampaign'] = "新增一個項目";
$GLOBALS['strAddCampaign_Key'] = "新增<u>n</u>ew 項目";
$GLOBALS['strCampaignForAdvertiser'] = "for advertiser";
$GLOBALS['strLinkedCampaigns'] = "Linked Campaigns";
$GLOBALS['strCampaignProperties'] = "項目屬性";
$GLOBALS['strCampaignOverview'] = "項目概要";
$GLOBALS['strCampaignHistory'] = "Campaign Statistics";
$GLOBALS['strNoCampaigns'] = "There are currently no campaigns defined for this advertiser.";
$GLOBALS['strNoCampaignsAddAdvertiser'] = "There are currently no campaigns defined, because there are no advertisers. To create a campaign, <a href='advertiser-edit.php'>add a new advertiser</a> first.";
$GLOBALS['strConfirmDeleteCampaign'] = "你是否希望刪除該項目";
$GLOBALS['strConfirmDeleteCampaigns'] = "你是否希望刪除該項目";
$GLOBALS['strShowParentAdvertisers'] = "顯示父客戶";
$GLOBALS['strHideParentAdvertisers'] = "隱藏父客戶";
$GLOBALS['strHideInactiveCampaigns'] = "隱藏停用的項目";
$GLOBALS['strInactiveCampaignsHidden'] = "隱藏被撤銷的項目";
$GLOBALS['strPriorityInformation'] = "Priority in relation to other campaigns";
$GLOBALS['strECPMInformation'] = "eCPM prioritization";
$GLOBALS['strRemnantEcpmDescription'] = "eCPM is automatically calculated based on this campaign's performance.<br />It will be used to prioritise Remnant campaigns relative to each other.";
$GLOBALS['strEcpmMinImpsDescription'] = "Set this to your desired minium basis on which to calculate this campaign's eCPM.";
$GLOBALS['strHiddenCampaign'] = "項目";
$GLOBALS['strHiddenAd'] = "廣告";
$GLOBALS['strHiddenAdvertiser'] = "廣告商";
$GLOBALS['strHiddenTracker'] = "跟蹤系統";
$GLOBALS['strHiddenWebsite'] = "網站";
$GLOBALS['strHiddenZone'] = "版位";
$GLOBALS['strCampaignDelivery'] = "Campaign delivery";
$GLOBALS['strCompanionPositioning'] = "項目撇之";
$GLOBALS['strSelectUnselectAll'] = "選擇/反選";
$GLOBALS['strCampaignsOfAdvertiser'] = "of"; //this is added between page name and advertiser name eg. 'Campaigns of Advertiser 1'
$GLOBALS['strShowCappedNoCookie'] = "Show capped ads if cookies are disabled";

// Campaign-zone linking page
$GLOBALS['strCalculatedForAllCampaigns'] = "Calculated for all campaigns";
$GLOBALS['strCalculatedForThisCampaign'] = "Calculated for this campaign";
$GLOBALS['strLinkingZonesProblem'] = "Problem occurred when linking zones";
$GLOBALS['strUnlinkingZonesProblem'] = "Problem occurred when unlinking zones";
$GLOBALS['strZonesLinked'] = "zone(s) linked";
$GLOBALS['strZonesUnlinked'] = "zone(s) unlinked";
$GLOBALS['strZonesSearch'] = "Search";
$GLOBALS['strZonesSearchTitle'] = "Search zones and websites by name";
$GLOBALS['strNoWebsitesAndZones'] = "No websites and zones";
$GLOBALS['strNoWebsitesAndZonesText'] = "with \"%s\" in name";
$GLOBALS['strToLink'] = "to link";
$GLOBALS['strToUnlink'] = "to unlink";
$GLOBALS['strLinked'] = "Linked";
$GLOBALS['strAvailable'] = "Available";
$GLOBALS['strShowing'] = "Showing";
$GLOBALS['strEditZone'] = "Edit zone";
$GLOBALS['strEditWebsite'] = "Edit website";


// Campaign properties
$GLOBALS['strDontExpire'] = "Don't expire";
$GLOBALS['strActivateNow'] = "Start immediately";
$GLOBALS['strSetSpecificDate'] = "Set specific date";
$GLOBALS['strLow'] = "低";
$GLOBALS['strHigh'] = "高";
$GLOBALS['strExpirationDate'] = "結束日期";
$GLOBALS['strExpirationDateComment'] = "項目結束日期";
$GLOBALS['strActivationDate'] = "開始日期";
$GLOBALS['strActivationDateComment'] = "項目自該日起啟動";
$GLOBALS['strImpressionsRemaining'] = "剩餘曝光量";
$GLOBALS['strClicksRemaining'] = "剩餘點擊數";
$GLOBALS['strConversionsRemaining'] = "剩餘轉化數";
$GLOBALS['strImpressionsBooked'] = "記錄的曝光量";
$GLOBALS['strClicksBooked'] = "記錄的點擊數";
$GLOBALS['strConversionsBooked'] = "記錄的轉化數";
$GLOBALS['strCampaignWeight'] = "Set the campaign weight";
$GLOBALS['strAnonymous'] = "隱藏該項目的廣告主和網站";
$GLOBALS['strTargetPerDay'] = "平均每天";
$GLOBALS['strCampaignWarningRemnantNoWeight'] = "The type of this campaign has been set to Remnant,
but the weight is set to zero or it has not been
specified. This will cause the campaign to be
deactivated and its banners won't be delivered
until the weight has been set to a valid number.

Are you sure you want to continue?";
$GLOBALS['strCampaignWarningEcpmNoRevenue'] = "This campaign uses eCPM optimisation
but the 'revenue' is set to zero or it has not been specified.
This will cause the campaign to be deactivated
and its banners won't be delivered until the
revenue has been set to a valid number.

Are you sure you want to continue?";
$GLOBALS['strCampaignWarningOverrideNoWeight'] = "The type of this campaign has been set to Override,
but the weight is set to zero or it has not been
specified. This will cause the campaign to be
deactivated and its banners won't be delivered
until the weight has been set to a valid number.

Are you sure you want to continue?";
$GLOBALS['strCampaignWarningNoTarget'] = "The type of this campaign has been set to Contract,
but Limit per day is not specified.
This will cause the campaign to be deactivated and
its banners won't be delivered until a valid Limit per day has been set.

Are you sure you want to continue?";
$GLOBALS['strCampaignStatusPending'] = "未決的";
$GLOBALS['strCampaignStatusInactive'] = "活躍";
$GLOBALS['strCampaignStatusRunning'] = "運行中";
$GLOBALS['strCampaignStatusPaused'] = "已暫停";
$GLOBALS['strCampaignStatusAwaiting'] = "等待中";
$GLOBALS['strCampaignStatusExpired'] = "結束";
$GLOBALS['strCampaignStatusApproval'] = "等待批准 »";
$GLOBALS['strCampaignStatusRejected'] = "被拒絕";
$GLOBALS['strCampaignStatusAdded'] = "Added";
$GLOBALS['strCampaignStatusStarted'] = "Started";
$GLOBALS['strCampaignStatusRestarted'] = "重啟";
$GLOBALS['strCampaignStatusDeleted'] = "刪除";
$GLOBALS['strCampaignType'] = "項目名稱";
$GLOBALS['strType'] = "類型";
$GLOBALS['strContract'] = "聯繫人";
$GLOBALS['strOverride'] = "Override";
$GLOBALS['strOverrideInfo'] = "Override campaigns are a special campaign type specifically to
    override (i.e. take priority over) Remnant and Contract campaigns. Override campaigns are generally used with
    specific targeting and/or capping rules to ensure that the campaign banners are always displayed in certain
    locations, to certain users, and perhaps a certain number of times, as part of a specific promotion. (This campaign
    type was previously known as 'Contract (Exclusive)'.)";
$GLOBALS['strStandardContract'] = "聯繫人";
$GLOBALS['strStandardContractInfo'] = "Contract campaigns are for smoothly delivering the impressions
    required to achieve a specified time-critical performance requirement. That is, Contract campaigns are for when
    an advertiser has paid specifically to have a given number of impressions, clicks and/or conversions to be
    achieved either between two dates, or per day.";
$GLOBALS['strRemnant'] = "Remnant";
$GLOBALS['strRemnantInfo'] = "The default campaign type. Remnant campaigns have lots of different
    delivery options, and you should ideally always have at least one Remnant campaign linked to every zone, to ensure
    that there is always something to show. Use Remnant campaigns to display house banners, ad-network banners, or even
    direct advertising that has been sold, but where there is not a time-critical performance requirement for the
    campaign to adhere to.";
$GLOBALS['strECPMInfo'] = "This is a standard campaign which can be constrained with either an end date or a specific limit. Based on current settings it will be prioritised using eCPM.";
$GLOBALS['strPricing'] = "Pricing";
$GLOBALS['strPricingModel'] = "Pricing model";
$GLOBALS['strSelectPricingModel'] = "-- select model --";
$GLOBALS['strRatePrice'] = "Rate / Price";
$GLOBALS['strMinimumImpressions'] = "Minimum daily impressions";
$GLOBALS['strLimit'] = "Limit";
$GLOBALS['strLowExclusiveDisabled'] = "You cannot change this campaign to Remnant or Exclusive, since both an end date and either of impressions/clicks/conversions limit are set. <br>In order to change type, you need to set no expiry date or remove limits.";
$GLOBALS['strCannotSetBothDateAndLimit'] = "You cannot set both an end date and limit for a Remnant or Exclusive campaign.<br>If you need to set both an end date and limit impressions/clicks/conversions please use a non-exclusive Contract campaign.";
$GLOBALS['strWhyDisabled'] = "why is it disabled?";
$GLOBALS['strBackToCampaigns'] = "Back to campaigns";
$GLOBALS['strCampaignBanners'] = "Campaign's banners";
$GLOBALS['strCookies'] = "Cookies";

// Tracker
$GLOBALS['strTracker'] = "跟蹤系統";
$GLOBALS['strTrackers'] = "跟蹤系統";
$GLOBALS['strTrackerPreferences'] = "跟蹤器首選項";
$GLOBALS['strAddTracker'] = "增加一個跟蹤器";
$GLOBALS['strTrackerForAdvertiser'] = "for advertiser";
$GLOBALS['strNoTrackers'] = "There are currently no trackers defined for this advertiser";
$GLOBALS['strConfirmDeleteTrackers'] = "您是否希望刪除該跟蹤器 ";
$GLOBALS['strConfirmDeleteTracker'] = "您是否希望刪除該跟蹤器 ";
$GLOBALS['strTrackerProperties'] = "跟蹤器屬性";
$GLOBALS['strDefaultStatus'] = "默認狀態";
$GLOBALS['strStatus'] = "狀態";
$GLOBALS['strLinkedTrackers'] = "已連結的跟蹤器";
$GLOBALS['strTrackerInformation'] = "Tracker Information";
$GLOBALS['strConversionWindow'] = "轉化窗口";
$GLOBALS['strUniqueWindow'] = "獨立窗口";
$GLOBALS['strClick'] = "點擊";
$GLOBALS['strView'] = "瀏覽";
$GLOBALS['strArrival'] = "Arrival";
$GLOBALS['strManual'] = "Manual";
$GLOBALS['strImpression'] = "Impression";
$GLOBALS['strConversionType'] = "轉化類型";
$GLOBALS['strLinkCampaignsByDefault'] = "Link newly created campaigns by default";
$GLOBALS['strBackToTrackers'] = "Back to trackers";
$GLOBALS['strIPAddress'] = "IP Address";

// Banners (General)
$GLOBALS['strBanner'] = "廣告";
$GLOBALS['strBanners'] = "廣告";
$GLOBALS['strAddBanner'] = "新增一個廣告";
$GLOBALS['strAddBanner_Key'] = "<u>新增</u>一個廣告";
$GLOBALS['strBannerToCampaign'] = "您的項目";
$GLOBALS['strShowBanner'] = "顯示廣告";
$GLOBALS['strBannerProperties'] = "廣告屬性";
$GLOBALS['strBannerHistory'] = "Banner Statistics";
$GLOBALS['strNoBanners'] = "There are currently no banners defined for this campaign.";
$GLOBALS['strNoBannersAddCampaign'] = "目前沒有網站，想要新建一個版位，請先<a href='affiliate-edit.php'>創建</a>一個網站";
$GLOBALS['strNoBannersAddAdvertiser'] = "目前沒有網站，想要新建一個版位，請先<a href='affiliate-edit.php'>創建</a>一個網站";
$GLOBALS['strConfirmDeleteBanner'] = "您是否真的希望刪除該廣告";
$GLOBALS['strConfirmDeleteBanners'] = "您是否真的希望刪除該廣告";
$GLOBALS['strShowParentCampaigns'] = "顯示父項目";
$GLOBALS['strHideParentCampaigns'] = "顯示父項目";
$GLOBALS['strHideInactiveBanners'] = "隱藏停用的廣告";
$GLOBALS['strInactiveBannersHidden'] = "隱藏已停用的廣告";
$GLOBALS['strWarningMissing'] = "警告，可能失蹤";
$GLOBALS['strWarningMissingClosing'] = "正在關閉標籤\">\"";
$GLOBALS['strWarningMissingOpening'] = "正在打開標籤\"<\"";
$GLOBALS['strSubmitAnyway'] = "提交";
$GLOBALS['strBannersOfCampaign'] = "屬於"; //this is added between page name and campaign name eg. 'Banners in coca cola campaign'

// Banner Preferences
$GLOBALS['strBannerPreferences'] = "廣告首選項";
$GLOBALS['strCampaignPreferences'] = "Campaign Preferences";
$GLOBALS['strDefaultBanners'] = "默認廣告";
$GLOBALS['strDefaultBannerUrl'] = "默認圖片URL";
$GLOBALS['strDefaultBannerDestination'] = "默認連結地址";
$GLOBALS['strAllowedBannerTypes'] = "允許的廣告形式";
$GLOBALS['strTypeSqlAllow'] = "可使用本地數據庫廣告";
$GLOBALS['strTypeWebAllow'] = "可使用Webserver伺服器本地廣告";
$GLOBALS['strTypeUrlAllow'] = "使用外部廣告";
$GLOBALS['strTypeHtmlAllow'] = "可使用HTML廣告";
$GLOBALS['strTypeTxtAllow'] = "可使用文字廣告";

// Banner (Properties)
$GLOBALS['strChooseBanner'] = "請選擇廣告形式";
$GLOBALS['strMySQLBanner'] = "Upload a local banner to the database";
$GLOBALS['strWebBanner'] = "Upload a local banner to the webserver";
$GLOBALS['strURLBanner'] = "Link an external banner";
$GLOBALS['strHTMLBanner'] = "Create an HTML banner";
$GLOBALS['strTextBanner'] = "Create a Text banner";
$GLOBALS['strAlterHTML'] = "Alter HTML to enable click tracking for:";
$GLOBALS['strIframeFriendly'] = "This banner can be safely displayed inside an iframe (e.g. is not expandable)";
$GLOBALS['strUploadOrKeep'] = "你是否希望保留已有的圖片，還是上傳其它文件？";
$GLOBALS['strNewBannerFile'] = "選擇該廣告使用的圖片";
$GLOBALS['strNewBannerFileAlt'] = "請在瀏覽狂中選擇希望使用的備份圖片（但不支持富媒體格式）";
$GLOBALS['strNewBannerURL'] = "廣告圖形 URL (包含 http://) ";
$GLOBALS['strURL'] = "Destination URL (incl. http://)";
$GLOBALS['strKeyword'] = "關鍵詞";
$GLOBALS['strTextBelow'] = "圖注";
$GLOBALS['strWeight'] = "權重";
$GLOBALS['strAlt'] = "說明文字";
$GLOBALS['strStatusText'] = "狀態文字";
$GLOBALS['strCampaignsWeight'] = "Campaign's Weight";
$GLOBALS['strBannerWeight'] = "項目權重 ";
$GLOBALS['strBannersWeight'] = "Banner's Weight";
$GLOBALS['strAdserverTypeGeneric'] = "生成HTML廣告";
$GLOBALS['strDoNotAlterHtml'] = "Do not alter HTML";
$GLOBALS['strGenericOutputAdServer'] = "生成";
$GLOBALS['strBackToBanners'] = "Back to banners";
$GLOBALS['strUseWyswygHtmlEditor'] = "Use WYSIWYG HTML Editor";
$GLOBALS['strChangeDefault'] = "Change default";

// Banner (advanced)
$GLOBALS['strBannerPrependHTML'] = "Always prepend the following HTML code to this banner";
$GLOBALS['strBannerAppendHTML'] = "Always append the following HTML code to this banner";

// Display Delviery Rules
$GLOBALS['strModifyBannerAcl'] = "發送選項";
$GLOBALS['strACL'] = "發送選項";
$GLOBALS['strACLAdd'] = "Add delivery rule";
$GLOBALS['strApplyLimitationsTo'] = "Apply delivery rules to";
$GLOBALS['strAllBannersInCampaign'] = "All banners in this campaign";
$GLOBALS['strRemoveAllLimitations'] = "Remove all delivery rules";
$GLOBALS['strEqualTo'] = "等於";
$GLOBALS['strDifferentFrom'] = "不同於";
$GLOBALS['strLaterThan'] = "is later than";
$GLOBALS['strLaterThanOrEqual'] = "is later than or equal to";
$GLOBALS['strEarlierThan'] = "is earlier than";
$GLOBALS['strEarlierThanOrEqual'] = "is earlier than or equal to";
$GLOBALS['strContains'] = "contains";
$GLOBALS['strNotContains'] = "doesn't contain";
$GLOBALS['strGreaterThan'] = "大於";
$GLOBALS['strLessThan'] = "少於";
$GLOBALS['strGreaterOrEqualTo'] = "is greater or equal to";
$GLOBALS['strLessOrEqualTo'] = "is less or equal to";
$GLOBALS['strAND'] = "與";                          // logical operator
$GLOBALS['strOR'] = "或";                         // logical operator
$GLOBALS['strOnlyDisplayWhen'] = "當： 時候顯示這條廣告";
$GLOBALS['strWeekDays'] = "工作日";
$GLOBALS['strTime'] = "Time";
$GLOBALS['strDomain'] = "Domain";
$GLOBALS['strSource'] = "來源";
$GLOBALS['strBrowser'] = "Browser";
$GLOBALS['strOS'] = "OS";
$GLOBALS['strDeliveryLimitations'] = "Delivery Rules";

$GLOBALS['strDeliveryCappingReset'] = "於此時之後重新開始統計";
$GLOBALS['strDeliveryCappingTotal'] = "合計";
$GLOBALS['strDeliveryCappingSession'] = "平均每個線程";

if (!isset($GLOBALS['strCappingBanner'])) {
    $GLOBALS['strCappingBanner'] = array();
}
$GLOBALS['strCappingBanner']['title'] = "Delivery capping per visitor";
$GLOBALS['strCappingBanner']['limit'] = "限定廣告瀏覽數為:";

if (!isset($GLOBALS['strCappingCampaign'])) {
    $GLOBALS['strCappingCampaign'] = array();
}
$GLOBALS['strCappingCampaign']['title'] = "Delivery capping per visitor";
$GLOBALS['strCappingCampaign']['limit'] = "限定項目瀏覽數為:";

if (!isset($GLOBALS['strCappingZone'])) {
    $GLOBALS['strCappingZone'] = array();
}
$GLOBALS['strCappingZone']['title'] = "Delivery capping per visitor";
$GLOBALS['strCappingZone']['limit'] = "限定版位瀏覽數為:";

// Website
$GLOBALS['strAffiliate'] = "網站";
$GLOBALS['strAffiliates'] = "網站";
$GLOBALS['strAffiliatesAndZones'] = "網站和版位";
$GLOBALS['strAddNewAffiliate'] = "新增一個網站";
$GLOBALS['strAffiliateProperties'] = "網站屬性";
$GLOBALS['strAffiliateHistory'] = "Website Statistics";
$GLOBALS['strNoAffiliates'] = "目前沒有網站，想要新建一個版位，請先<a href='affiliate-edit.php'>創建</a>一個網站";
$GLOBALS['strConfirmDeleteAffiliate'] = "確定刪除此網站？";
$GLOBALS['strConfirmDeleteAffiliates'] = "確定刪除此網站？";
$GLOBALS['strInactiveAffiliatesHidden'] = "隱藏未激活的網站";
$GLOBALS['strShowParentAffiliates'] = "顯示父網站";
$GLOBALS['strHideParentAffiliates'] = "隱藏父網站";

// Website (properties)
$GLOBALS['strWebsite'] = "網站";
$GLOBALS['strWebsiteURL'] = "Website URL";
$GLOBALS['strAllowAffiliateModifyZones'] = "允許用戶修改自己版面";
$GLOBALS['strAllowAffiliateLinkBanners'] = "允許用戶";
$GLOBALS['strAllowAffiliateAddZone'] = "允許用戶新建版位";
$GLOBALS['strAllowAffiliateDeleteZone'] = "允允許用戶刪除版位";
$GLOBALS['strAllowAffiliateGenerateCode'] = "允許用戶生成調用代碼";

// Website (properties - payment information)
$GLOBALS['strPostcode'] = "Postcode";
$GLOBALS['strCountry'] = "國家";

// Website (properties - other information)
$GLOBALS['strWebsiteZones'] = "網站和版位";

// Zone
$GLOBALS['strZone'] = "版位";
$GLOBALS['strZones'] = "版位";
$GLOBALS['strAddNewZone'] = "新增一個版位";
$GLOBALS['strAddNewZone_Key'] = "新增<u>n</u>ew版位";
$GLOBALS['strZoneToWebsite'] = "沒有網站";
$GLOBALS['strLinkedZones'] = "Linked Zones";
$GLOBALS['strAvailableZones'] = "Available Zones";
$GLOBALS['strLinkingNotSuccess'] = "Linking not successful, please try again";
$GLOBALS['strZoneProperties'] = "版位屬性";
$GLOBALS['strZoneHistory'] = "版位歷史";
$GLOBALS['strNoZones'] = "There are currently no zones defined for this website.";
$GLOBALS['strNoZonesAddWebsite'] = "目前沒有網站，想要新建一個版位，請先<a href='affiliate-edit.php'>創建</a>一個網站";
$GLOBALS['strConfirmDeleteZone'] = "您真的希望刪除該版位";
$GLOBALS['strConfirmDeleteZones'] = "您真的希望刪除該版位";
$GLOBALS['strConfirmDeleteZoneLinkActive'] = "There are campaigns still linked to this zone, if you delete it these will not be able to run and you will not be paid for them.";
$GLOBALS['strZoneType'] = "版位類型";
$GLOBALS['strBannerButtonRectangle'] = "旗標廣告、按鈕廣告或矩形廣告";
$GLOBALS['strInterstitial'] = "Interstitial or Floating DHTML";
$GLOBALS['strPopup'] = "Popup";
$GLOBALS['strTextAdZone'] = "文字廣告";
$GLOBALS['strEmailAdZone'] = "電子郵件/郵件列表版位";
$GLOBALS['strZoneVideoInstream'] = "Inline Video ad";
$GLOBALS['strZoneVideoOverlay'] = "Overlay Video ad";
$GLOBALS['strShowMatchingBanners'] = "顯示符合條件的廣告";
$GLOBALS['strHideMatchingBanners'] = "顯示符合條件的廣告";
$GLOBALS['strBannerLinkedAds'] = "Banners linked to the zone";
$GLOBALS['strCampaignLinkedAds'] = "Campaigns linked to the zone";
$GLOBALS['strInactiveZonesHidden'] = "隱藏已停用的廣告";
$GLOBALS['strWarnChangeZoneType'] = "因為廣告形式的限制,將版位的形式更改成文字或電子郵件將會斷開與所有廣告/項目的關聯。
<ul>
 <li>文字版位只能與文字廣告相關聯</li>
<li>電子郵件廣告版位項目一次僅能與一個激活廣告關聯</li>
</ul>";
$GLOBALS['strWarnChangeZoneSize'] = '由於廣告尺寸沒有任何變化，所改變了版位的尺寸，斷開所有現有廣告與該版位的關聯。需要重新連結符合新尺寸的廣告。';
$GLOBALS['strWarnChangeBannerSize'] = 'Changing the banner size will unlink this banner from any zones that are not the new size, and if this banner\'s <strong>campaign</strong> is linked to a zone of the new size, this banner will be automatically linked';
$GLOBALS['strWarnBannerReadonly'] = 'This banner is read-only because an extension has been disabled. Contact your system administrator for more information.';
$GLOBALS['strZonesOfWebsite'] = '屬於'; //this is added between page name and website name eg. 'Zones in www.example.com'
$GLOBALS['strBackToZones'] = "Back to zones";

$GLOBALS['strIab']['IAB_FullBanner(468x60)'] = "IAB Full Banner (468 x 60)";
$GLOBALS['strIab']['IAB_Skyscraper(120x600)'] = "IAB Skyscraper (120 x 600)";
$GLOBALS['strIab']['IAB_Leaderboard(728x90)'] = "IAB Leaderboard (728 x 90)";
$GLOBALS['strIab']['IAB_Button1(120x90)'] = "IAB Button 1 (120 x 90)";
$GLOBALS['strIab']['IAB_Button2(120x60)'] = "IAB Button 2 (120 x 60)";
$GLOBALS['strIab']['IAB_HalfBanner(234x60)'] = "IAB Half Banner (234 x 60)";
$GLOBALS['strIab']['IAB_MicroBar(88x31)'] = "IAB Micro Bar (88 x 31)";
$GLOBALS['strIab']['IAB_SquareButton(125x125)'] = "IAB Square Button (125 x 125)";
$GLOBALS['strIab']['IAB_Rectangle(180x150)*'] = "IAB Rectangle (180 x 150)";
$GLOBALS['strIab']['IAB_SquarePop-up(250x250)'] = "IAB Square Pop-up (250 x 250)";
$GLOBALS['strIab']['IAB_VerticalBanner(120x240)'] = "IAB Vertical Banner (120 x 240)";
$GLOBALS['strIab']['IAB_MediumRectangle(300x250)*'] = "IAB Medium Rectangle (300 x 250)";
$GLOBALS['strIab']['IAB_LargeRectangle(336x280)'] = "IAB Large Rectangle (336 x 280)";
$GLOBALS['strIab']['IAB_VerticalRectangle(240x400)'] = "IAB Vertical Rectangle (240 x 400)";
$GLOBALS['strIab']['IAB_WideSkyscraper(160x600)*'] = "IAB Wide Skyscraper (160 x 600)";
$GLOBALS['strIab']['IAB_Pop-Under(720x300)'] = "IAB Pop-Under (720 x 300)";
$GLOBALS['strIab']['IAB_3:1Rectangle(300x100)'] = "IAB 3:1 Rectangle (300 x 100)";

// Advanced zone settings
$GLOBALS['strAdvanced'] = "高級";
$GLOBALS['strChainSettings'] = "主要設置";
$GLOBALS['strZoneNoDelivery'] = "If no banners from this zone <br />can be delivered, try to...";
$GLOBALS['strZoneStopDelivery'] = "Stop delivery and don't show a banner";
$GLOBALS['strZoneOtherZone'] = "Display the selected zone instead";
$GLOBALS['strZoneAppend'] = "該版位可以附加彈出或浮動效果";
$GLOBALS['strAppendSettings'] = "附加和預先設定";
$GLOBALS['strZonePrependHTML'] = "該版位允許為文字廣告預先設定HTML代碼";
$GLOBALS['strZoneAppendNoBanner'] = "如果沒有廣告投放則附加";
$GLOBALS['strZoneAppendHTMLCode'] = "HTML代碼";
$GLOBALS['strZoneAppendZoneSelection'] = "彈出或浮動";

// Zone probability
$GLOBALS['strZoneProbListChain'] = "All the banners linked to the selected zone are currently not active. <br />This is the zone chain that will be followed:";
$GLOBALS['strZoneProbNullPri'] = "There are no active banners linked to this zone.";
$GLOBALS['strZoneProbListChainLoop'] = "Following the zone chain would cause a circular loop. Delivery for this zone is halted.";

// Linked banners/campaigns/trackers
$GLOBALS['strSelectZoneType'] = "Please choose what to link to this zone";
$GLOBALS['strLinkedBanners'] = "Link individual banners";
$GLOBALS['strCampaignDefaults'] = "Link banners by parent campaign";
$GLOBALS['strLinkedCategories'] = "Link banners by category";
$GLOBALS['strWithXBanners'] = "%d banner(s)";
$GLOBALS['strRawQueryString'] = "關鍵詞";
$GLOBALS['strIncludedBanners'] = "Linked Banners";
$GLOBALS['strMatchingBanners'] = "{count} 配對廣告";
$GLOBALS['strNoCampaignsToLink'] = "There are currently no campaigns available which can be linked to this zone";
$GLOBALS['strNoTrackersToLink'] = "There are currently no trackers available which can be linked to this campaign";
$GLOBALS['strNoZonesToLinkToCampaign'] = "There are no zones available to which this campaign can be linked";
$GLOBALS['strSelectBannerToLink'] = "Select the banner you would like to link to this zone:";
$GLOBALS['strSelectCampaignToLink'] = "Select the campaign you would like to link to this zone:";
$GLOBALS['strSelectAdvertiser'] = "選擇客戶";
$GLOBALS['strSelectPlacement'] = "選擇項目";
$GLOBALS['strSelectAd'] = "選擇廣告";
$GLOBALS['strSelectPublisher'] = "選擇網站";
$GLOBALS['strSelectZone'] = "選擇版位";
$GLOBALS['strStatusPending'] = "未決的";
$GLOBALS['strStatusApproved'] = "Approved";
$GLOBALS['strStatusDisapproved'] = "Disapproved";
$GLOBALS['strStatusDuplicate'] = "複製";
$GLOBALS['strStatusOnHold'] = "On Hold";
$GLOBALS['strStatusIgnore'] = "Ignore";
$GLOBALS['strConnectionType'] = "類型";
$GLOBALS['strConnTypeSale'] = "Sale";
$GLOBALS['strConnTypeLead'] = "Lead";
$GLOBALS['strConnTypeSignUp'] = "Signup";
$GLOBALS['strShortcutEditStatuses'] = "編輯狀態";
$GLOBALS['strShortcutShowStatuses'] = "顯示狀態";

// Statistics
$GLOBALS['strStats'] = "統計";
$GLOBALS['strNoStats'] = "沒有統計數據";
$GLOBALS['strNoStatsForPeriod'] = "沒有統計數據可供百分比計算";
$GLOBALS['strGlobalHistory'] = "Global Statistics";
$GLOBALS['strDailyHistory'] = "Daily Statistics";
$GLOBALS['strDailyStats'] = "Daily Statistics";
$GLOBALS['strWeeklyHistory'] = "Weekly Statistics";
$GLOBALS['strMonthlyHistory'] = "Monthly Statistics";
$GLOBALS['strTotalThisPeriod'] = "在該期限之前累計";
$GLOBALS['strPublisherDistribution'] = "網站發布數";
$GLOBALS['strCampaignDistribution'] = "項目發布數";
$GLOBALS['strViewBreakdown'] = "瀏覽按照";
$GLOBALS['strBreakdownByDay'] = "日";
$GLOBALS['strBreakdownByWeek'] = "周";
$GLOBALS['strBreakdownByMonth'] = "月";
$GLOBALS['strBreakdownByDow'] = "周一至周七";
$GLOBALS['strBreakdownByHour'] = "小時";
$GLOBALS['strItemsPerPage'] = "每頁顯示條數";
$GLOBALS['strDistributionHistoryCampaign'] = "Distribution Statistics (Campaign)";
$GLOBALS['strDistributionHistoryBanner'] = "Distribution Statistics (Banner)";
$GLOBALS['strDistributionHistoryWebsite'] = "Distribution Statistics (Website)";
$GLOBALS['strDistributionHistoryZone'] = "Distribution Statistics (Zone)";
$GLOBALS['strShowGraphOfStatistics'] = "顯示<u>統計</u>圖形";
$GLOBALS['strExportStatisticsToExcel'] = "<u>導出</u>數據成EXCEL文件";
$GLOBALS['strGDnotEnabled'] = "為了顯示圖表，您必須在PHP中啟用GD。<br /> 請參閱 <a href='http://www.php.net/gd' target='_blank'>http://www.php.net/gd</a> 。";
$GLOBALS['strStatsArea'] = "Area";

// Expiration
$GLOBALS['strNoExpiration'] = "沒有到期日";
$GLOBALS['strEstimated'] = "預期到期日";
$GLOBALS['strNoExpirationEstimation'] = "No expiration estimated yet";
$GLOBALS['strDaysAgo'] = "days ago";
$GLOBALS['strCampaignStop'] = "項目歷史";

// Reports
$GLOBALS['strAdvancedReports'] = "Advanced Reports";
$GLOBALS['strStartDate'] = "Start Date";
$GLOBALS['strEndDate'] = "End Date";
$GLOBALS['strPeriod'] = "Period";
$GLOBALS['strLimitations'] = "Delivery Rules";
$GLOBALS['strWorksheets'] = "Worksheets";

// Admin_UI_Fields
$GLOBALS['strAllAdvertisers'] = "所有客戶";
$GLOBALS['strAnonAdvertisers'] = "匿名客戶";
$GLOBALS['strAllPublishers'] = "所有網站";
$GLOBALS['strAnonPublishers'] = "匿名網站";
$GLOBALS['strAllAvailZones'] = "所有可選擇的版位";

// Userlog
$GLOBALS['strUserLog'] = "用戶日誌";
$GLOBALS['strUserLogDetails'] = "詳細用戶日誌";
$GLOBALS['strDeleteLog'] = "刪除日誌";
$GLOBALS['strAction'] = "操作";
$GLOBALS['strNoActionsLogged'] = "不記錄操作";

// Code generation
$GLOBALS['strGenerateBannercode'] = "Direct Selection";
$GLOBALS['strChooseInvocationType'] = "請選擇生成的公告形式";
$GLOBALS['strGenerate'] = "生成";
$GLOBALS['strParameters'] = "標籤設置";
$GLOBALS['strFrameSize'] = "框架尺寸";
$GLOBALS['strBannercode'] = "旗標代碼";
$GLOBALS['strTrackercode'] = "Trackercode";
$GLOBALS['strBackToTheList'] = "返回報告列表";
$GLOBALS['strCharset'] = "Character set";
$GLOBALS['strAutoDetect'] = "Auto-detect";
$GLOBALS['strCacheBusterComment'] = "  * Replace all instances of {random} with
  * a generated random number (or timestamp).
  *";
$GLOBALS['strSSLBackupComment'] = "
  * The backup image section of this tag has been generated for use on a
  * non-SSL page. If this tag is to be placed on an SSL page, change the
  *   'http://%s/...'
  * to
  *   'https://%s/...'
  *";
$GLOBALS['strSSLDeliveryComment'] = "
  * This tag has been generated for use on a non-SSL page. If this tag
  * is to be placed on an SSL page, change the
  *   'http://%s/...'
  * to
  *   'https://%s/...'
  *";

// Errors
$GLOBALS['strErrorDatabaseConnection'] = "Database connection error.";
$GLOBALS['strErrorCantConnectToDatabase'] = "A fatal error occurred %1\$s can't connect to the database. Because
                                                   of this it isn't possible to use the administrator interface. The delivery
                                                   of banners might also be affected. Possible reasons for the problem are:
                                                   <ul>
                                                     <li>The database server isn't functioning at the moment</li>
                                                     <li>The location of the database server has changed</li>
                                                     <li>The username or password used to contact the database server are not correct</li>
                                                     <li>PHP has not loaded the <i>%2\$s</i> extension</li>
                                                   </ul>";
$GLOBALS['strNoMatchesFound'] = "沒有符合的結果";
$GLOBALS['strErrorOccurred'] = "出錯";
$GLOBALS['strErrorDBPlain'] = "訪問數據庫出錯";
$GLOBALS['strErrorDBSerious'] = "數據庫出錯";
$GLOBALS['strErrorDBNoDataPlain'] = "Due to a problem with the database {$PRODUCT_NAME} couldn't retrieve or store data. ";
$GLOBALS['strErrorDBNoDataSerious'] = "Due to a serious problem with the database, {$PRODUCT_NAME} couldn't retrieve data";
$GLOBALS['strErrorDBCorrupt'] = "數據庫表格出錯需要修復。希望了解關於修復表格的更多資訊，請參閱<i>管理員手冊</i>中的<i>排錯</i>章節";
$GLOBALS['strErrorDBContact'] = "請聯繫伺服器管理員注意相關問題。";
$GLOBALS['strErrorDBSubmitBug'] = "If this problem is reproducable it might be caused by a bug in {$PRODUCT_NAME}. Please report the following information to the creators of {$PRODUCT_NAME}. Also try to describe the actions that led to this error as clearly as possible.";
$GLOBALS['strMaintenanceNotActive'] = "The maintenance script has not been run in the last 24 hours.
In order for the application to function correctly it needs to run
every hour.

Please read the Administrator guide for more information
about configuring the maintenance script.";
$GLOBALS['strErrorLinkingBanner'] = "It was not possible to link this banner to this zone because:";
$GLOBALS['strUnableToLinkBanner'] = "Cannot link this banner: ";
$GLOBALS['strErrorEditingCampaignRevenue'] = "incorrect number format in Revenue Information field";
$GLOBALS['strErrorEditingCampaignECPM'] = "incorrect number format in ECPM Information field";
$GLOBALS['strErrorEditingZone'] = "Error updating zone:";
$GLOBALS['strUnableToChangeZone'] = "因為以下原因無法應用更新";
$GLOBALS['strDatesConflict'] = "數據衝突";
$GLOBALS['strEmailNoDates'] = "Campaigns linked to Email Zones must have a start and end date set. {$PRODUCT_NAME} ensures that on a given date, only one active banner is linked to an Email Zone. Please ensure that the campaigns already linked to the zone do not have overlapping dates with the campaign you are trying to link.";
$GLOBALS['strWarningInaccurateStats'] = "Some of these statistics were logged in a non-UTC timezone, and may not be displayed in the correct timezone.";
$GLOBALS['strWarningInaccurateReadMore'] = "Read more about this";
$GLOBALS['strWarningInaccurateReport'] = "Some of the statistics in this report were logged in a non-UTC timezone, and may not be displayed in the correct timezone";

//Validation
$GLOBALS['strRequiredFieldLegend'] = "denotes required field";
$GLOBALS['strFormContainsErrors'] = "Form contains errors, please correct the marked fields below.";
$GLOBALS['strXRequiredField'] = "%s is required";
$GLOBALS['strEmailField'] = "Please enter a valid email";
$GLOBALS['strNumericField'] = "Please enter a number (only digits allowed)";
$GLOBALS['strGreaterThanZeroField'] = "Must be greater than 0";
$GLOBALS['strXGreaterThanZeroField'] = "%s must be greater than 0";
$GLOBALS['strXPositiveWholeNumberField'] = "%s must be a positive whole number";
$GLOBALS['strInvalidWebsiteURL'] = "Invalid Website URL";

// Email
$GLOBALS['strSirMadam'] = "先生/女士";
$GLOBALS['strMailSubject'] = "客戶報告";
$GLOBALS['strMailHeader'] = "Dear {contact},";
$GLOBALS['strMailBannerStats'] = "{clientname}的廣告統計數據:";
$GLOBALS['strMailBannerActivatedSubject'] = "激活的項目";
$GLOBALS['strMailBannerDeactivatedSubject'] = "撤銷的項目";
$GLOBALS['strMailBannerActivated'] = "Your campaign shown below has been activated because
the campaign activation date has been reached.";
$GLOBALS['strMailBannerDeactivated'] = "由於以下原因，您的項目已被撤銷";
$GLOBALS['strMailFooter'] = "Regards,
   {adminfullname}";
$GLOBALS['strClientDeactivated'] = "由於以下原因，該項目未被激活";
$GLOBALS['strBeforeActivate'] = "激活日期還未到";
$GLOBALS['strAfterExpire'] = "項目已過期";
$GLOBALS['strNoMoreImpressions'] = "曝光量已全部使用";
$GLOBALS['strNoMoreClicks'] = "點擊數已全部使用";
$GLOBALS['strNoMoreConversions'] = "已經沒有可出售的了";
$GLOBALS['strWeightIsNull'] = "其權重被設為零";
$GLOBALS['strRevenueIsNull'] = "its revenue is set to zero";
$GLOBALS['strTargetIsNull'] = "its limit per day is set to zero - you need to either specify both an end date and a limit or set Limit per day value";
$GLOBALS['strNoViewLoggedInInterval'] = "發送本報告時，系統並沒有關於廣告曝光量的記錄。";
$GLOBALS['strNoClickLoggedInInterval'] = "發送本報告時，系統並沒有關於廣告點擊數的記錄。";
$GLOBALS['strNoConversionLoggedInInterval'] = "發送本報告時，系統並沒有關於廣告轉換數的記錄。";
$GLOBALS['strMailReportPeriod'] = "本報告統計數據範圍為自{startdate}至{enddate}.";
$GLOBALS['strMailReportPeriodAll'] = "本報告數據截止至{enddate}.";
$GLOBALS['strNoStatsForCampaign'] = "本項目沒有統計數據";
$GLOBALS['strImpendingCampaignExpiry'] = "項目即將到期";
$GLOBALS['strYourCampaign'] = "您的項目";
$GLOBALS['strTheCampiaignBelongingTo'] = "該項目屬於";
$GLOBALS['strImpendingCampaignExpiryDateBody'] = "{clientname}在{date}之前.";
$GLOBALS['strImpendingCampaignExpiryImpsBody'] = "{clientname} 剩餘的曝光量已低於 {limit}。";
$GLOBALS['strImpendingCampaignExpiryBody'] = "As a result, the campaign will soon be automatically disabled, and the
following banners in the campaign will also be disabled:";

// Priority
$GLOBALS['strPriority'] = "優先";
$GLOBALS['strSourceEdit'] = "編輯來源";

// Preferences
$GLOBALS['strPreferences'] = "首選設定";
$GLOBALS['strUserPreferences'] = "廣告首選項";
$GLOBALS['strChangePassword'] = "Change Password";
$GLOBALS['strChangeEmail'] = "Change E-mail";
$GLOBALS['strCurrentPassword'] = "Current Password";
$GLOBALS['strChooseNewPassword'] = "Choose a new password";
$GLOBALS['strReenterNewPassword'] = "Re-enter new password";
$GLOBALS['strNameLanguage'] = "Name & Language";
$GLOBALS['strAccountPreferences'] = "賬號首選項";
$GLOBALS['strCampaignEmailReportsPreferences'] = "項目的電子郵件首選項";
$GLOBALS['strTimezonePreferences'] = "Timezone Preferences";
$GLOBALS['strAdminEmailWarnings'] = "管理員電子郵件報警";
$GLOBALS['strAgencyEmailWarnings'] = "代理商電子郵件告警";
$GLOBALS['strAdveEmailWarnings'] = "廣告主電子郵件告警";
$GLOBALS['strFullName'] = "全名";
$GLOBALS['strEmailAddress'] = "電子郵件地址";
$GLOBALS['strUserDetails'] = "User Details";
$GLOBALS['strUserInterfacePreferences'] = "用戶界面(UI)首選項";
$GLOBALS['strPluginPreferences'] = "主要選項";
$GLOBALS['strColumnName'] = "Column Name";
$GLOBALS['strShowColumn'] = "Show Column";
$GLOBALS['strCustomColumnName'] = "Custom Column Name";
$GLOBALS['strColumnRank'] = "Column Rank";

// Long names
$GLOBALS['strRevenue'] = "Revenue";
$GLOBALS['strNumberOfItems'] = "條目數";
$GLOBALS['strRevenueCPC'] = "Revenue CPC";
$GLOBALS['strERPM'] = "千人成本";
$GLOBALS['strERPC'] = "每次點擊的費用";
$GLOBALS['strERPS'] = "千人成本";
$GLOBALS['strEIPM'] = "千人成本";
$GLOBALS['strEIPC'] = "每次點擊的費用";
$GLOBALS['strEIPS'] = "千人成本";
$GLOBALS['strECPM'] = "千人成本";
$GLOBALS['strECPC'] = "每次點擊的費用";
$GLOBALS['strECPS'] = "千人成本";
$GLOBALS['strPendingConversions'] = "Pending conversions";
$GLOBALS['strImpressionSR'] = "曝光數SR";
$GLOBALS['strClickSR'] = "Click SR";

// Short names
$GLOBALS['strRevenue_short'] = "請求數";
$GLOBALS['strBasketValue_short'] = "BV";
$GLOBALS['strNumberOfItems_short'] = "Num. Items";
$GLOBALS['strRevenueCPC_short'] = "Rev. CPC";
$GLOBALS['strERPM_short'] = "千人成本";
$GLOBALS['strERPC_short'] = "每次點擊的費用";
$GLOBALS['strERPS_short'] = "千人成本";
$GLOBALS['strEIPM_short'] = "千人成本";
$GLOBALS['strEIPC_short'] = "每次點擊的費用";
$GLOBALS['strEIPS_short'] = "千人成本";
$GLOBALS['strECPM_short'] = "千人成本";
$GLOBALS['strECPC_short'] = "每次點擊的費用";
$GLOBALS['strECPS_short'] = "千人成本";
$GLOBALS['strID_short'] = "ID";
$GLOBALS['strRequests_short'] = "請求數";
$GLOBALS['strImpressions_short'] = "Impr.";
$GLOBALS['strClicks_short'] = "點擊";
$GLOBALS['strCTR_short'] = "CTR";
$GLOBALS['strConversions_short'] = "Conv.";
$GLOBALS['strPendingConversions_short'] = "Pend conv.";
$GLOBALS['strImpressionSR_short'] = "Impr. SR";
$GLOBALS['strClickSR_short'] = "Click SR";

// Global Settings
$GLOBALS['strConfiguration'] = "Configuration";
$GLOBALS['strGlobalSettings'] = "一般設置";
$GLOBALS['strGeneralSettings'] = "一般設置";
$GLOBALS['strMainSettings'] = "主要設置";
$GLOBALS['strPlugins'] = "Plugins";
$GLOBALS['strChooseSection'] = '選擇章節';

// Product Updates
$GLOBALS['strProductUpdates'] = "產品更新";
$GLOBALS['strViewPastUpdates'] = "更新與備份管理";
$GLOBALS['strFromVersion'] = "From Version";
$GLOBALS['strToVersion'] = "To Version";
$GLOBALS['strToggleDataBackupDetails'] = "Toggle data backup details";
$GLOBALS['strClickViewBackupDetails'] = "click to view backup details";
$GLOBALS['strClickHideBackupDetails'] = "click to hide backup details";
$GLOBALS['strShowBackupDetails'] = "Show data backup details";
$GLOBALS['strHideBackupDetails'] = "Hide data backup details";
$GLOBALS['strBackupDeleteConfirm'] = "Do you really want to delete all backups created from this upgrade?";
$GLOBALS['strDeleteArtifacts'] = "Delete Artifacts";
$GLOBALS['strArtifacts'] = "Artifacts";
$GLOBALS['strBackupDbTables'] = "Backup database tables";
$GLOBALS['strLogFiles'] = "Log files";
$GLOBALS['strConfigBackups'] = "Conf backups";
$GLOBALS['strUpdatedDbVersionStamp'] = "Updated database version stamp";
$GLOBALS['aProductStatus']['UPGRADE_COMPLETE'] = "UPGRADE COMPLETE";
$GLOBALS['aProductStatus']['UPGRADE_FAILED'] = "UPGRADE FAILED";

// Agency
$GLOBALS['strAgencyManagement'] = "帳戶管理";
$GLOBALS['strAgency'] = "賬號";
$GLOBALS['strAddAgency'] = "新增一個賬戶";
$GLOBALS['strAddAgency_Key'] = "新增版位";
$GLOBALS['strTotalAgencies'] = "賬戶統計";
$GLOBALS['strAgencyProperties'] = "Account Properties";
$GLOBALS['strNoAgencies'] = "沒有相關的賬戶";
$GLOBALS['strConfirmDeleteAgency'] = "您真的希望刪除該賬戶？";
$GLOBALS['strHideInactiveAgencies'] = "藏不活躍的帳戶";
$GLOBALS['strInactiveAgenciesHidden'] = "藏不活躍的帳戶";
$GLOBALS['strSwitchAccount'] = "Switch to this account";
$GLOBALS['strAgencyStatusRunning'] = "Active";
$GLOBALS['strAgencyStatusInactive'] = "活躍";
$GLOBALS['strAgencyStatusPaused'] = "Suspended";

// Channels
$GLOBALS['strChannel'] = "Delivery Rule Set";
$GLOBALS['strChannels'] = "Delivery Rule Sets";
$GLOBALS['strChannelManagement'] = "Delivery Rule Set Management";
$GLOBALS['strAddNewChannel'] = "Add new Delivery Rule Set";
$GLOBALS['strAddNewChannel_Key'] = "Add <u>n</u>ew Delivery Rule Set";
$GLOBALS['strChannelToWebsite'] = "沒有網站";
$GLOBALS['strNoChannels'] = "There are currently no delivery rule sets defined";
$GLOBALS['strNoChannelsAddWebsite'] = "There are currently no delivery rule sets defined, because there are no websites. To create a delivery rule set, <a href='affiliate-edit.php'>add a new website</a> first.";
$GLOBALS['strEditChannelLimitations'] = "Edit delivery rules for the delivery rule set";
$GLOBALS['strChannelProperties'] = "Delivery Rule Set Properties";
$GLOBALS['strChannelLimitations'] = "發送選項";
$GLOBALS['strConfirmDeleteChannel'] = "Do you really want to delete this delivery rule set?";
$GLOBALS['strConfirmDeleteChannels'] = "Do you really want to delete the selected delivery rule sets?";
$GLOBALS['strChannelsOfWebsite'] = '屬於'; //this is added between page name and website name eg. 'delivery rule sets in www.example.com'

// Tracker Variables
$GLOBALS['strVariableName'] = "變量名";
$GLOBALS['strVariableDescription'] = "Description";
$GLOBALS['strVariableDataType'] = "數據類型";
$GLOBALS['strVariablePurpose'] = "目的";
$GLOBALS['strGeneric'] = "生成";
$GLOBALS['strBasketValue'] = "籃價值";
$GLOBALS['strNumItems'] = "條目數";
$GLOBALS['strVariableIsUnique'] = "dedup轉換";
$GLOBALS['strNumber'] = "數";
$GLOBALS['strString'] = "串值";
$GLOBALS['strTrackFollowingVars'] = "根據以下變量跟蹤";
$GLOBALS['strAddVariable'] = "新增變量";
$GLOBALS['strNoVarsToTrack'] = "沒有跟蹤的變量";
$GLOBALS['strVariableRejectEmpty'] = "拒絕為空";
$GLOBALS['strTrackingSettings'] = "跟蹤設置";
$GLOBALS['strTrackerType'] = "跟蹤模式";
$GLOBALS['strTrackerTypeJS'] = "跟蹤JavaScript變量";
$GLOBALS['strTrackerTypeDefault'] = "跟踪JavaScript变量（backwards compatible, escaping needed）";
$GLOBALS['strTrackerTypeDOM'] = "使用DOM跟蹤HTML元素";
$GLOBALS['strTrackerTypeCustom'] = "自定義JS代碼";
$GLOBALS['strVariableCode'] = "JavaScript跟蹤代碼";

// Password recovery
$GLOBALS['strForgotPassword'] = "忘記密碼？";
$GLOBALS['strPasswordRecovery'] = "Password reset";
$GLOBALS['strEmailRequired'] = "電子郵件為必填項";
$GLOBALS['strPwdRecWrongId'] = "錯誤ID";
$GLOBALS['strPwdRecEnterEmail'] = "請填入你的郵件地址";
$GLOBALS['strPwdRecEnterPassword'] = "請填入新密碼";
$GLOBALS['strProceed'] = "繼續>";
$GLOBALS['strNotifyPageMessage'] = "An e-mail has been sent to you, which includes a link that will allow you
                                         to reset your password and log in.<br />Please allow a few minutes for the e-mail to arrive.<br />
                                         If you do not receive the e-mail, please check your spam folder.<br />
                                         <a href=\"index.php\">Return to the main login page.</a>";

$GLOBALS['strPwdRecEmailPwdRecovery'] = "Reset Your %s Password";
$GLOBALS['strPwdRecEmailBody'] = "Dear {name},

You, or someone pretending to be you, recently requested that your {$PRODUCT_NAME} password be reset.

If this request was made by you, then you can reset the password for your username '{username}' by
clicking on the following link:

{reset_link}

If you submitted the password reset request by mistake, or if you didn't make a request at all, simply
ignore this email. No changes have been made to your password and the password reset link will expire
automatically.

If you continue to receive these password reset mails, then it may indicate that someone is attempting
to gain access to your username. In that case, please contact the support team or system administrator
for your {$PRODUCT_NAME} system, and notify them of the situation.

{admin_signature}";
$GLOBALS['strPwdRecEmailSincerely'] = "Sincerely,";

// Audit
$GLOBALS['strAdditionalItems'] = "and additional items";
$GLOBALS['strFor'] = "for";
$GLOBALS['strHas'] = "具備";
$GLOBALS['strBinaryData'] = "Binary data";
$GLOBALS['strAuditTrailDisabled'] = "Audit Trail has been disabled by the system administrator. No further events are logged and shown in Audit Trail list.";

// Widget - Audit
$GLOBALS['strAuditNoData'] = "No user activity has been recorded during the timeframe you have selected.";
$GLOBALS['strAuditTrail'] = "審計跟踪";
$GLOBALS['strAuditTrailSetup'] = "Setup the Audit Trail today";
$GLOBALS['strAuditTrailGoTo'] = "Go to Audit Trail page";
$GLOBALS['strAuditTrailNotEnabled'] = "<li>Audit Trail allows you to see who did what and when. Or to put it another way, it keeps track of system changes within {$PRODUCT_NAME}</li>
        <li>You are seeing this message, because you have not activated the Audit Trail</li>
        <li>Interested in learning more? Read the <a href='{$PRODUCT_DOCSURL}/admin/settings/auditTrail' class='site-link' target='help' >Audit Trail documentation</a></li>";

// Widget - Campaign
$GLOBALS['strCampaignGoTo'] = "Go to Campaigns page";
$GLOBALS['strCampaignSetUp'] = "Set up a Campaign today";
$GLOBALS['strCampaignNoRecords'] = "<li>Campaigns let you group together any number of banner ads, of any size, that share common advertising requirements</li>
        <li>Save time by grouping banners within a campaign and no longer define delivery settings for each ad separately</li>
        <li>Check out the <a class='site-link' target='help' href='{$PRODUCT_DOCSURL}/user/inventory/advertisersAndCampaigns/campaigns'>Campaign documentation</a>!</li>";
$GLOBALS['strCampaignNoRecordsAdmin'] = "<li>There is no campaign activity to display.</li>";

$GLOBALS['strCampaignNoDataTimeSpan'] = "No campaigns have started or finished during the timeframe you have selected";
$GLOBALS['strCampaignAuditNotActivated'] = "<li>In order to view campaigns which have started or finished during the timeframe you have selected, the Audit Trail must be activated</li>
        <li>You are seeing this message because you didn't activate the Audit Trail</li>";
$GLOBALS['strCampaignAuditTrailSetup'] = "Activate Audit Trail to start viewing Campaigns";

$GLOBALS['strUnsavedChanges'] = "You have unsaved changes on this page, make sure you press &quot;Save Changes&quot; when finished";
$GLOBALS['strDeliveryLimitationsDisagree'] = "WARNING: The cached delivery rules <strong>DO NOT AGREE</strong> with the delivery rules shown below<br />Please hit save changes to update the cached delivery rules";
$GLOBALS['strDeliveryRulesDbError'] = "WARNING: When saving the delivery rules, a database error occured. Please check the delivery rules below carefully, and update, if required.";
$GLOBALS['strDeliveryRulesTruncation'] = "WARNING: When saving the delivery rules, MySQL truncated the data, so the original values were restored. Please reduce your rule size, and try again.";
$GLOBALS['strDeliveryLimitationsInputErrors'] = "Some delivery rules report incorrect values:";

//confirmation messages
$GLOBALS['strYouAreNowWorkingAsX'] = "You are now working as <b>%s</b>";
$GLOBALS['strYouDontHaveAccess'] = "You don't have access to that page. You have been re-directed.";

$GLOBALS['strAdvertiserHasBeenAdded'] = "Advertiser <a href='%s'>%s</a> has been added, <a href='%s'>add a campaign</a>";
$GLOBALS['strAdvertiserHasBeenUpdated'] = "Advertiser <a href='%s'>%s</a> has been updated";
$GLOBALS['strAdvertiserHasBeenDeleted'] = "Advertiser <b>%s</b> has been deleted";
$GLOBALS['strAdvertisersHaveBeenDeleted'] = "All selected advertisers have been deleted";

$GLOBALS['strTrackerHasBeenAdded'] = "Tracker <a href='%s'>%s</a> has been added";
$GLOBALS['strTrackerHasBeenUpdated'] = "Tracker <a href='%s'>%s</a> has been updated";
$GLOBALS['strTrackerVarsHaveBeenUpdated'] = "Variables of tracker <a href='%s'>%s</a> have been updated";
$GLOBALS['strTrackerCampaignsHaveBeenUpdated'] = "Linked campaigns of tracker <a href='%s'>%s</a> have been updated";
$GLOBALS['strTrackerAppendHasBeenUpdated'] = "Append tracker code of tracker <a href='%s'>%s</a> has been updated";
$GLOBALS['strTrackerHasBeenDeleted'] = "Tracker <b>%s</b> has been deleted";
$GLOBALS['strTrackersHaveBeenDeleted'] = "All selected trackers have been deleted";
$GLOBALS['strTrackerHasBeenDuplicated'] = "Tracker <a href='%s'>%s</a> has been copied to <a href='%s'>%s</a>";
$GLOBALS['strTrackerHasBeenMoved'] = "Tracker <b>%s</b> has been moved to advertiser <b>%s</b>";

$GLOBALS['strCampaignHasBeenAdded'] = "Campaign <a href='%s'>%s</a> has been added, <a href='%s'>add a banner</a>";
$GLOBALS['strCampaignHasBeenUpdated'] = "Campaign <a href='%s'>%s</a> has been updated";
$GLOBALS['strCampaignTrackersHaveBeenUpdated'] = "Linked trackers of campaign <a href='%s'>%s</a> have been updated";
$GLOBALS['strCampaignHasBeenDeleted'] = "Campaign <b>%s</b> has been deleted";
$GLOBALS['strCampaignsHaveBeenDeleted'] = "All selected campaigns have been deleted";
$GLOBALS['strCampaignHasBeenDuplicated'] = "Campaign <a href='%s'>%s</a> has been copied to <a href='%s'>%s</a>";
$GLOBALS['strCampaignHasBeenMoved'] = "Campaign <b>%s</b> has been moved to advertiser <b>%s</b>";

$GLOBALS['strBannerHasBeenAdded'] = "Banner <a href='%s'>%s</a> has been added";
$GLOBALS['strBannerHasBeenUpdated'] = "Banner <a href='%s'>%s</a> has been updated";
$GLOBALS['strBannerAdvancedHasBeenUpdated'] = "Advanced settings for banner <a href='%s'>%s</a> have been updated";
$GLOBALS['strBannerAclHasBeenUpdated'] = "Delivery options for banner <a href='%s'>%s</a> have been updated";
$GLOBALS['strBannerAclHasBeenAppliedTo'] = "Delivery options for banner <a href='%s'>%s</a> have been applied to %d banners";
$GLOBALS['strBannerHasBeenDeleted'] = "Banner <b>%s</b> has been deleted";
$GLOBALS['strBannersHaveBeenDeleted'] = "All selected banners have been deleted";
$GLOBALS['strBannerHasBeenDuplicated'] = "Banner <a href='%s'>%s</a> has been copied to <a href='%s'>%s</a>";
$GLOBALS['strBannerHasBeenMoved'] = "Banner <b>%s</b> has been moved to campaign <b>%s</b>";
$GLOBALS['strBannerHasBeenActivated'] = "Banner <a href='%s'>%s</a> has been activated";
$GLOBALS['strBannerHasBeenDeactivated'] = "Banner <a href='%s'>%s</a> has been deactivated";

$GLOBALS['strXZonesLinked'] = "<b>%s</b> zone(s) linked";
$GLOBALS['strXZonesUnlinked'] = "<b>%s</b> zone(s) unlinked";

$GLOBALS['strWebsiteHasBeenAdded'] = "Website <a href='%s'>%s</a> has been added, <a href='%s'>add a zone</a>";
$GLOBALS['strWebsiteHasBeenUpdated'] = "Website <a href='%s'>%s</a> has been updated";
$GLOBALS['strWebsiteHasBeenDeleted'] = "Website <b>%s</b> has been deleted";
$GLOBALS['strWebsitesHaveBeenDeleted'] = "All selected website have been deleted";
$GLOBALS['strWebsiteHasBeenDuplicated'] = "Website <a href='%s'>%s</a> has been copied to <a href='%s'>%s</a>";

$GLOBALS['strZoneHasBeenAdded'] = "Zone <a href='%s'>%s</a> has been added";
$GLOBALS['strZoneHasBeenUpdated'] = "Zone <a href='%s'>%s</a> has been updated";
$GLOBALS['strZoneAdvancedHasBeenUpdated'] = "Advanced settings for zone <a href='%s'>%s</a> have been updated";
$GLOBALS['strZoneHasBeenDeleted'] = "Zone <b>%s</b> has been deleted";
$GLOBALS['strZonesHaveBeenDeleted'] = "All selected zone have been deleted";
$GLOBALS['strZoneHasBeenDuplicated'] = "Zone <a href='%s'>%s</a> has been copied to <a href='%s'>%s</a>";
$GLOBALS['strZoneHasBeenMoved'] = "Zone <b>%s</b> has been moved to website <b>%s</b>";
$GLOBALS['strZoneLinkedBanner'] = "Banner has been linked to zone <a href='%s'>%s</a>";
$GLOBALS['strZoneLinkedCampaign'] = "Campaign has been linked to zone <a href='%s'>%s</a>";
$GLOBALS['strZoneRemovedBanner'] = "Banner has been unlinked from zone <a href='%s'>%s</a>";
$GLOBALS['strZoneRemovedCampaign'] = "Campaign has been unlinked from zone <a href='%s'>%s</a>";

$GLOBALS['strChannelHasBeenAdded'] = "Delivery rule set <a href='%s'>%s</a> has been added. <a href='%s'>Set the delivery rules.</a>";
$GLOBALS['strChannelHasBeenUpdated'] = "Delivery rule set <a href='%s'>%s</a> has been updated";
$GLOBALS['strChannelAclHasBeenUpdated'] = "Delivery options for the delivery rule set <a href='%s'>%s</a> have been updated";
$GLOBALS['strChannelHasBeenDeleted'] = "Delivery rule set <b>%s</b> has been deleted";
$GLOBALS['strChannelsHaveBeenDeleted'] = "All selected delivery rule sets have been deleted";
$GLOBALS['strChannelHasBeenDuplicated'] = "Delivery rule set <a href='%s'>%s</a> has been copied to <a href='%s'>%s</a>";

$GLOBALS['strUserPreferencesUpdated'] = "Your <b>%s</b> preferences has been updated";
$GLOBALS['strEmailChanged'] = "Your E-mail has been changed";
$GLOBALS['strPasswordChanged'] = "Your password has been changed";
$GLOBALS['strXPreferencesHaveBeenUpdated'] = "<b>%s</b> have been updated";
$GLOBALS['strXSettingsHaveBeenUpdated'] = "<b>%s</b> have been updated";
$GLOBALS['strTZPreferencesWarning'] = "However, campaign activation and expiry were not updated, nor time-based banner delivery rules.<br />You will need to update them manually if you wish them to use the new timezone";

// Report error messages
$GLOBALS['strReportErrorMissingSheets'] = "No worksheet was selected for report";
$GLOBALS['strReportErrorUnknownCode'] = "Unknown error code #";

/* ------------------------------------------------------- */
/* Keyboard shortcut assignments                           */
/* ------------------------------------------------------- */

// Reserved keys
// Do not change these unless absolutely needed
$GLOBALS['keyHome'] = "h";
$GLOBALS['keyUp'] = "u";
$GLOBALS['keyNextItem'] = ".";
$GLOBALS['keyPreviousItem'] = ",";
$GLOBALS['keyList'] = "l";

// Other keys
// Please make sure you underline the key you
// used in the string in default.lang.php
$GLOBALS['keySearch'] = "s";
$GLOBALS['keyCollapseAll'] = "c";
$GLOBALS['keyExpandAll'] = "e";
$GLOBALS['keyAddNew'] = "n";
$GLOBALS['keyNext'] = "n";
$GLOBALS['keyPrevious'] = "p";
$GLOBALS['keyLinkUser'] = "u";
$GLOBALS['keyWorkingAs'] = "w";
