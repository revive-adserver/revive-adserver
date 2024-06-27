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
$GLOBALS['phpAds_TextDirection'] = "";
$GLOBALS['phpAds_TextAlignRight'] = "";
$GLOBALS['phpAds_TextAlignLeft'] = "";
$GLOBALS['phpAds_CharSet'] = "";

$GLOBALS['phpAds_DecimalPoint'] = ".";
$GLOBALS['phpAds_ThousandsSeperator'] = ",";

// Date & time configuration
$GLOBALS['date_format'] = "";
$GLOBALS['time_format'] = "";
$GLOBALS['minute_format'] = "";
$GLOBALS['month_format'] = "";
$GLOBALS['day_format'] = "";
$GLOBALS['week_format'] = "";
$GLOBALS['weekiso_format'] = "";

// Formats used by PEAR Spreadsheet_Excel_Writer packate
$GLOBALS['excel_integer_formatting'] = "";
$GLOBALS['excel_decimal_formatting'] = "";

/* ------------------------------------------------------- */
/* Translations                                          */
/* ------------------------------------------------------- */

$GLOBALS['strHome'] = "Trang chủ";
$GLOBALS['strHelp'] = "Trợ giúp";
$GLOBALS['strStartOver'] = "Bắt đầu lại";
$GLOBALS['strShortcuts'] = "Phím tắt";
$GLOBALS['strActions'] = "Các hành động";
$GLOBALS['strAndXMore'] = "và %s thêm";
$GLOBALS['strAdminstration'] = "Hàng tồn kho";
$GLOBALS['strMaintenance'] = "Bảo trì";
$GLOBALS['strProbability'] = "Xác suất";
$GLOBALS['strInvocationcode'] = "Mã Invocation";
$GLOBALS['strBasicInformation'] = "Thông tin cơ bản";
$GLOBALS['strAppendTrackerCode'] = "Thêm Mã Theo Dõi";
$GLOBALS['strOverview'] = "Tổng thể";
$GLOBALS['strSearch'] = "<u>S</u>earch";
$GLOBALS['strDetails'] = "Chi tiết";
$GLOBALS['strUpdateSettings'] = "Cập nhật cài đặt";
$GLOBALS['strCheckForUpdates'] = "Kiểm tra bản cập nhật";
$GLOBALS['strWhenCheckingForUpdates'] = "Khi kiểm tra Cập Nhật";
$GLOBALS['strCompact'] = "Nhỏ gọn";
$GLOBALS['strUser'] = "Người dùng";
$GLOBALS['strDuplicate'] = "Tạo bản sao";
$GLOBALS['strCopyOf'] = "Bản sao của";
$GLOBALS['strMoveTo'] = "Di chuyển tới";
$GLOBALS['strDelete'] = "Xoá";
$GLOBALS['strActivate'] = "Kích hoạt";
$GLOBALS['strConvert'] = "Chuyển đổi";
$GLOBALS['strRefresh'] = "Làm mới";
$GLOBALS['strSaveChanges'] = "Lưu Thay Đổi";
$GLOBALS['strUp'] = "Lên";
$GLOBALS['strDown'] = "Xuống";
$GLOBALS['strSave'] = "Lưu";
$GLOBALS['strCancel'] = "Huỷ";
$GLOBALS['strBack'] = "Quay về";
$GLOBALS['strPrevious'] = "Về trước";
$GLOBALS['strNext'] = "Tiếp";
$GLOBALS['strYes'] = "Có";
$GLOBALS['strNo'] = "Không";
$GLOBALS['strNone'] = "Không gì cả";
$GLOBALS['strCustom'] = "Tuỳ chỉnh";
$GLOBALS['strDefault'] = "Mặc định";
$GLOBALS['strUnknown'] = "không rõ";
$GLOBALS['strUnlimited'] = "Không giới hạn";
$GLOBALS['strUntitled'] = "Chưa có tiêu đề";
$GLOBALS['strAll'] = "tất cả";
$GLOBALS['strAverage'] = "Trung bình";
$GLOBALS['strOverall'] = "Tổng thể";
$GLOBALS['strTotal'] = "Tổng cộng";
$GLOBALS['strFrom'] = "Từ";
$GLOBALS['strTo'] = "Đến";
$GLOBALS['strAdd'] = "Thêm mới";
$GLOBALS['strLinkedTo'] = "Liên kết đến";
$GLOBALS['strDaysLeft'] = "Ngày còn lại";
$GLOBALS['strCheckAllNone'] = "Chọn tất cả/Bỏ chọn";
$GLOBALS['strKiloByte'] = "KB";
$GLOBALS['strExpandAll'] = "Xây dựng";
$GLOBALS['strCollapseAll'] = "<u>T</u>hu gọn tất cả";
$GLOBALS['strShowAll'] = "Hiện Tất cả";
$GLOBALS['strNoAdminInterface'] = "Màn hình quản trị đã được tắt để bảo trì.  Điều này không ảnh hưởng đến việc phân phối các chiến dịch của bạn.";
$GLOBALS['strFieldStartDateBeforeEnd'] = "Ngày Bắt đầu phải lớn hơn ngày Kết thúc";
$GLOBALS['strFieldContainsErrors'] = "Các trường sau đây lỗi:";
$GLOBALS['strFieldFixBeforeContinue1'] = "Trước khi bạn có thể tiếp tục bạn cần";
$GLOBALS['strFieldFixBeforeContinue2'] = "khắc phục các lỗi này.";
$GLOBALS['strMiscellaneous'] = "Hỗn hợp";
$GLOBALS['strCollectedAllStats'] = "Tất cả thống kê";
$GLOBALS['strCollectedToday'] = "Hôm nay";
$GLOBALS['strCollectedYesterday'] = "Ngày hôm qua";
$GLOBALS['strCollectedThisWeek'] = "Tuần này";
$GLOBALS['strCollectedLastWeek'] = "Tuần trước";
$GLOBALS['strCollectedThisMonth'] = "Tháng này";
$GLOBALS['strCollectedLastMonth'] = "Tháng trước";
$GLOBALS['strCollectedLast7Days'] = "7 ngày qua";
$GLOBALS['strCollectedSpecificDates'] = "Chọn ngày";
$GLOBALS['strValue'] = "Giá trị";
$GLOBALS['strWarning'] = "Cảnh báo";
$GLOBALS['strNotice'] = "Chú ý";

// Dashboard
$GLOBALS['strDashboardCantBeDisplayed'] = "Bảng điều khiển có thể không hiển thị được";
$GLOBALS['strNoCheckForUpdates'] = "Bảng điều khiển không thể hiển thị trừ khi các <br /> kiểm tra cho Cập Nhật cài đặt được kích hoạt.";
$GLOBALS['strEnableCheckForUpdates'] = "Vui lòng kích hoạt các thiết lập <a href='account-settings-update.php' target='_top'> kiểm tra bản Cập Nhật</a> trên các <br/> <a href='account-settings-update.php' target='_top'> Cập Nhật cài đặt</a> trang.";
// Dashboard Errors
$GLOBALS['strDashboardErrorCode'] = "code";
$GLOBALS['strDashboardSystemMessage'] = "Thông báo hệ thống";
$GLOBALS['strDashboardErrorHelp'] = "Nếu lặp đi lặp lại lỗi này xin vui lòng mô tả vấn đề của bạn chi tiết và đăng nó trên <a href='http://forum.revive-adserver.com/'> forum.revive-adserver.com/</a>.";

// Priority
$GLOBALS['strPriority'] = "Độ ưu tiên";
$GLOBALS['strPriorityLevel'] = "Mức độ ưu tiên";
$GLOBALS['strOverrideAds'] = "Ghi đè lên các chiến dịch quảng cáo";
$GLOBALS['strHighAds'] = "Hợp đồng chiến dịch quảng cáo độc quyền";
$GLOBALS['strECPMAds'] = "eCPM Chiến dịch quảng cáo";
$GLOBALS['strLowAds'] = "Chiến dịch quảng cáo còn lại";
$GLOBALS['strLimitations'] = "Quy tắc giao hàng";
$GLOBALS['strNoLimitations'] = "Không có quy tắc giao hàng";
$GLOBALS['strCapping'] = "Đóng nắp";

// Properties
$GLOBALS['strName'] = "Tên";
$GLOBALS['strSize'] = "Kích thước";
$GLOBALS['strWidth'] = "Chiều Rộng";
$GLOBALS['strHeight'] = "Chiều cao";
$GLOBALS['strTarget'] = "Mục tiêu";
$GLOBALS['strLanguage'] = "Ngôn ngữ";
$GLOBALS['strDescription'] = "Mô tả";
$GLOBALS['strVariables'] = "Các biến số";
$GLOBALS['strID'] = "ID";
$GLOBALS['strComments'] = "Bình luận";

// User access
$GLOBALS['strWorkingAs'] = "Làm việc như";
$GLOBALS['strWorkingAs_Key'] = "<u>W</u>orking as";
$GLOBALS['strWorkingAs'] = "Làm việc như";
$GLOBALS['strSwitchTo'] = "Chuyển sang";
$GLOBALS['strUseSearchBoxToFindMoreAccounts'] = "Sử dụng hộp tìm kiếm của switcher để tìm thêm tài khoản";
$GLOBALS['strWorkingFor'] = "%s cho...";
$GLOBALS['strNoAccountWithXInNameFound'] = "Không có tài khoản với \"%s\" trong tên tìm thấy";
$GLOBALS['strRecentlyUsed'] = "Dùng gần đây";
$GLOBALS['strLinkUser'] = "Thêm người dùng";
$GLOBALS['strLinkUser_Key'] = "Thêm <u>N</u> gười dùng";
$GLOBALS['strUsernameToLink'] = "Tên người dùng của người dùng để thêm";
$GLOBALS['strNewUserWillBeCreated'] = "Người dùng mới sẽ được tạo ra";
$GLOBALS['strToLinkProvideEmail'] = "Để thêm người sử dụng, cung cấp thư điện tử của người dùng";
$GLOBALS['strToLinkProvideUsername'] = "Để thêm người sử dụng, cung cấp tên người dùng";
$GLOBALS['strUserLinkedToAccount'] = "";
$GLOBALS['strUserLinkedAndWelcomeSent'] = "";
$GLOBALS['strUserAccountUpdated'] = "Trương mục người dùng Cập Nhật";
$GLOBALS['strUserUnlinkedFromAccount'] = "";
$GLOBALS['strUserWasDeleted'] = "Người dùng đã bị xóa";
$GLOBALS['strUserNotLinkedWithAccount'] = "";
$GLOBALS['strCantDeleteOneAdminUser'] = "";
$GLOBALS['strLinkUserHelp'] = "";
$GLOBALS['strLinkUserHelpUser'] = "";
$GLOBALS['strLinkUserHelpEmail'] = "địa chỉ Email";
$GLOBALS['strLastLoggedIn'] = "Lần đăng nhập cuối";
$GLOBALS['strDateLinked'] = "Ngày liên kết";

// Login & Permissions
$GLOBALS['strUserAccess'] = "Người dùng được phép truy cập";
$GLOBALS['strAdminAccess'] = "Truy cập quản trị";
$GLOBALS['strUserProperties'] = "Thông tin chi tiết người dùng";
$GLOBALS['strPermissions'] = "Quyền";
$GLOBALS['strAuthentification'] = "Xác thực";
$GLOBALS['strWelcomeTo'] = "Chào mừng đến với";
$GLOBALS['strEnterUsername'] = "Nhập tên tài khoản và mật khẩu của bạn";
$GLOBALS['strEnterBoth'] = "Xin vui lòng điền vào cả tên đăng nhập và mật khẩu";
$GLOBALS['strEnableCookies'] = "Bạn cần phải bật cookie trước khi bạn có thể sử dụng {{PRODUCT_NAME}}";
$GLOBALS['strSessionIDNotMatch'] = "Phiên cookie lỗi, xin vui lòng đăng nhập lại";
$GLOBALS['strLogin'] = "Đăng nhập";
$GLOBALS['strLogout'] = "Đăng xuất";
$GLOBALS['strUsername'] = "Tài khoản";
$GLOBALS['strPassword'] = "Mật khẩu";
$GLOBALS['strPasswordRepeat'] = "Nhập lại mật khẩu";
$GLOBALS['strAccessDenied'] = "Truy cập bị từ chối";
$GLOBALS['strUsernameOrPasswordWrong'] = "Tên đăng nhập hoặc mật khẩu không được chính xác. Xin vui lòng thử lại.";
$GLOBALS['strPasswordWrong'] = "Mật khẩu không chính xác";
$GLOBALS['strNotAdmin'] = "Tài khoản của bạn không có quyền để sử dụng tính năng này, bạn có thể đăng nhập vào các tài khoản khác để sử dụng nó.";
$GLOBALS['strDuplicateClientName'] = "Tên đăng nhập đã tồn tại. Vui lòng chọn tên đăng nhập khác.";
$GLOBALS['strInvalidPassword'] = "";
$GLOBALS['strInvalidEmail'] = "";
$GLOBALS['strNotSamePasswords'] = "";
$GLOBALS['strRepeatPassword'] = "";
$GLOBALS['strDeadLink'] = "";
$GLOBALS['strNoPlacement'] = "";
$GLOBALS['strNoAdvertiser'] = "";

// General advertising
$GLOBALS['strRequests'] = "";
$GLOBALS['strImpressions'] = "";
$GLOBALS['strClicks'] = "";
$GLOBALS['strConversions'] = "";
$GLOBALS['strCTRShort'] = "";
$GLOBALS['strCNVRShort'] = "";
$GLOBALS['strCTR'] = "";
$GLOBALS['strTotalClicks'] = "";
$GLOBALS['strTotalConversions'] = "";
$GLOBALS['strDateTime'] = "";
$GLOBALS['strTrackerID'] = "";
$GLOBALS['strTrackerName'] = "";
$GLOBALS['strTrackerImageTag'] = "";
$GLOBALS['strTrackerJsTag'] = "";
$GLOBALS['strTrackerAlwaysAppend'] = "";
$GLOBALS['strBanners'] = "";
$GLOBALS['strCampaigns'] = "";
$GLOBALS['strCampaignID'] = "";
$GLOBALS['strCampaignName'] = "";
$GLOBALS['strCountry'] = "";
$GLOBALS['strStatsAction'] = "";
$GLOBALS['strWindowDelay'] = "";
$GLOBALS['strStatsVariables'] = "Các biến số";

// Finance
$GLOBALS['strFinanceCPM'] = "";
$GLOBALS['strFinanceCPC'] = "";
$GLOBALS['strFinanceCPA'] = "";
$GLOBALS['strFinanceMT'] = "";
$GLOBALS['strFinanceCTR'] = "";
$GLOBALS['strFinanceCR'] = "";

// Time and date related
$GLOBALS['strDate'] = "";
$GLOBALS['strDay'] = "";
$GLOBALS['strDays'] = "";
$GLOBALS['strWeek'] = "Tuần";
$GLOBALS['strWeeks'] = "Nhiều tuần";
$GLOBALS['strSingleMonth'] = "Tháng";
$GLOBALS['strMonths'] = "Nhiều tháng";
$GLOBALS['strDayOfWeek'] = "Ngày trong tuần";


if (!isset($GLOBALS['strDayFullNames'])) {
    $GLOBALS['strDayFullNames'] = [];
}
$GLOBALS['strDayFullNames'][0] = 'Chủ Nhật';
$GLOBALS['strDayFullNames'][1] = 'Thứ hai';
$GLOBALS['strDayFullNames'][2] = 'Thứ Ba';
$GLOBALS['strDayFullNames'][3] = 'Thứ Tư';
$GLOBALS['strDayFullNames'][4] = 'Thứ năm';
$GLOBALS['strDayFullNames'][5] = 'Thứ Sáu';
$GLOBALS['strDayFullNames'][6] = 'Thứ Bảy';

if (!isset($GLOBALS['strDayShortCuts'])) {
    $GLOBALS['strDayShortCuts'] = [];
}
$GLOBALS['strDayShortCuts'][0] = 'Chủ nhật';
$GLOBALS['strDayShortCuts'][1] = 'Thứ hai';
$GLOBALS['strDayShortCuts'][2] = 'Thứ ba';
$GLOBALS['strDayShortCuts'][3] = 'Thứ tư';
$GLOBALS['strDayShortCuts'][4] = 'Thứ năm';
$GLOBALS['strDayShortCuts'][5] = 'Thứ sáu';
$GLOBALS['strDayShortCuts'][6] = 'Thứ bảy';

$GLOBALS['strHour'] = "Giờ";
$GLOBALS['strSeconds'] = "giây";
$GLOBALS['strMinutes'] = "phút";
$GLOBALS['strHours'] = "giờ";

// Advertiser
$GLOBALS['strClient'] = "Nhà quảng cáo";
$GLOBALS['strClients'] = "Nhà quảng cáo";
$GLOBALS['strClientsAndCampaigns'] = "Nhà quảng cáo & chiến dịch";
$GLOBALS['strAddClient'] = "Thêm nhà quảng cáo mới";
$GLOBALS['strClientProperties'] = "";
$GLOBALS['strClientHistory'] = "";
$GLOBALS['strNoClients'] = "";
$GLOBALS['strConfirmDeleteClient'] = "";
$GLOBALS['strConfirmDeleteClients'] = "";
$GLOBALS['strHideInactive'] = "";
$GLOBALS['strInactiveAdvertisersHidden'] = "";
$GLOBALS['strAdvertiserSignup'] = "";
$GLOBALS['strAdvertiserCampaigns'] = "";

// Advertisers properties
$GLOBALS['strContact'] = "";
$GLOBALS['strContactName'] = "";
$GLOBALS['strEMail'] = "";
$GLOBALS['strSendAdvertisingReport'] = "";
$GLOBALS['strNoDaysBetweenReports'] = "";
$GLOBALS['strSendDeactivationWarning'] = "";
$GLOBALS['strAllowClientModifyBanner'] = "";
$GLOBALS['strAllowClientDisableBanner'] = "";
$GLOBALS['strAllowClientActivateBanner'] = "";
$GLOBALS['strAllowCreateAccounts'] = "";
$GLOBALS['strAdvertiserLimitation'] = "";
$GLOBALS['strAllowAuditTrailAccess'] = "";
$GLOBALS['strAllowDeleteItems'] = "";

// Campaign
$GLOBALS['strCampaign'] = "";
$GLOBALS['strCampaigns'] = "";
$GLOBALS['strAddCampaign'] = "";
$GLOBALS['strAddCampaign_Key'] = "";
$GLOBALS['strCampaignForAdvertiser'] = "";
$GLOBALS['strLinkedCampaigns'] = "";
$GLOBALS['strCampaignProperties'] = "";
$GLOBALS['strCampaignOverview'] = "";
$GLOBALS['strCampaignHistory'] = "";
$GLOBALS['strNoCampaigns'] = "";
$GLOBALS['strNoCampaignsAddAdvertiser'] = "";
$GLOBALS['strConfirmDeleteCampaign'] = "";
$GLOBALS['strConfirmDeleteCampaigns'] = "";
$GLOBALS['strShowParentAdvertisers'] = "";
$GLOBALS['strHideParentAdvertisers'] = "";
$GLOBALS['strHideInactiveCampaigns'] = "";
$GLOBALS['strInactiveCampaignsHidden'] = "";
$GLOBALS['strPriorityInformation'] = "";
$GLOBALS['strECPMInformation'] = "";
$GLOBALS['strRemnantEcpmDescription'] = "";
$GLOBALS['strEcpmMinImpsDescription'] = "";
$GLOBALS['strHiddenCampaign'] = "";
$GLOBALS['strHiddenAd'] = "";
$GLOBALS['strHiddenAdvertiser'] = "Nhà quảng cáo";
$GLOBALS['strHiddenTracker'] = "";
$GLOBALS['strHiddenWebsite'] = "";
$GLOBALS['strHiddenZone'] = "";
$GLOBALS['strCampaignDelivery'] = "";
$GLOBALS['strCompanionPositioning'] = "";
$GLOBALS['strSelectUnselectAll'] = "";
$GLOBALS['strCampaignsOfAdvertiser'] = ""; //this is added between page name and advertiser name eg. 'Campaigns of Advertiser 1'
$GLOBALS['strShowCappedNoCookie'] = "";

// Campaign-zone linking page
$GLOBALS['strCalculatedForAllCampaigns'] = "";
$GLOBALS['strCalculatedForThisCampaign'] = "";
$GLOBALS['strLinkingZonesProblem'] = "";
$GLOBALS['strUnlinkingZonesProblem'] = "";
$GLOBALS['strZonesLinked'] = "";
$GLOBALS['strZonesUnlinked'] = "";
$GLOBALS['strZonesSearch'] = "";
$GLOBALS['strZonesSearchTitle'] = "";
$GLOBALS['strNoWebsitesAndZones'] = "";
$GLOBALS['strNoWebsitesAndZonesText'] = "";
$GLOBALS['strToLink'] = "";
$GLOBALS['strToUnlink'] = "";
$GLOBALS['strLinked'] = "";
$GLOBALS['strAvailable'] = "";
$GLOBALS['strShowing'] = "";
$GLOBALS['strEditZone'] = "";
$GLOBALS['strEditWebsite'] = "";


// Campaign properties
$GLOBALS['strDontExpire'] = "";
$GLOBALS['strActivateNow'] = "";
$GLOBALS['strSetSpecificDate'] = "";
$GLOBALS['strLow'] = "";
$GLOBALS['strHigh'] = "";
$GLOBALS['strExpirationDate'] = "";
$GLOBALS['strExpirationDateComment'] = "";
$GLOBALS['strActivationDate'] = "";
$GLOBALS['strActivationDateComment'] = "";
$GLOBALS['strImpressionsRemaining'] = "";
$GLOBALS['strClicksRemaining'] = "";
$GLOBALS['strConversionsRemaining'] = "";
$GLOBALS['strImpressionsBooked'] = "";
$GLOBALS['strClicksBooked'] = "";
$GLOBALS['strConversionsBooked'] = "";
$GLOBALS['strCampaignWeight'] = "";
$GLOBALS['strAnonymous'] = "";
$GLOBALS['strTargetPerDay'] = "";
$GLOBALS['strCampaignWarningRemnantNoWeight'] = "";
$GLOBALS['strCampaignWarningEcpmNoRevenue'] = "";
$GLOBALS['strCampaignWarningOverrideNoWeight'] = "";
$GLOBALS['strCampaignWarningNoTarget'] = "";
$GLOBALS['strCampaignStatusPending'] = "";
$GLOBALS['strCampaignStatusInactive'] = "";
$GLOBALS['strCampaignStatusRunning'] = "";
$GLOBALS['strCampaignStatusPaused'] = "";
$GLOBALS['strCampaignStatusAwaiting'] = "";
$GLOBALS['strCampaignStatusExpired'] = "";
$GLOBALS['strCampaignStatusApproval'] = "";
$GLOBALS['strCampaignStatusRejected'] = "";
$GLOBALS['strCampaignStatusAdded'] = "";
$GLOBALS['strCampaignStatusStarted'] = "";
$GLOBALS['strCampaignStatusRestarted'] = "";
$GLOBALS['strCampaignStatusDeleted'] = "";
$GLOBALS['strCampaignType'] = "";
$GLOBALS['strType'] = "";
$GLOBALS['strContract'] = "";
$GLOBALS['strOverride'] = "";
$GLOBALS['strOverrideInfo'] = "";
$GLOBALS['strStandardContract'] = "";
$GLOBALS['strStandardContractInfo'] = "";
$GLOBALS['strRemnant'] = "";
$GLOBALS['strRemnantInfo'] = "";
$GLOBALS['strECPMInfo'] = "";
$GLOBALS['strPricing'] = "";
$GLOBALS['strPricingModel'] = "";
$GLOBALS['strSelectPricingModel'] = "";
$GLOBALS['strRatePrice'] = "";
$GLOBALS['strMinimumImpressions'] = "";
$GLOBALS['strLimit'] = "";
$GLOBALS['strLowExclusiveDisabled'] = "";
$GLOBALS['strCannotSetBothDateAndLimit'] = "";
$GLOBALS['strWhyDisabled'] = "";
$GLOBALS['strBackToCampaigns'] = "";
$GLOBALS['strCampaignBanners'] = "";
$GLOBALS['strCookies'] = "";

// Tracker
$GLOBALS['strTracker'] = "";
$GLOBALS['strTrackers'] = "";
$GLOBALS['strTrackerPreferences'] = "";
$GLOBALS['strAddTracker'] = "";
$GLOBALS['strTrackerForAdvertiser'] = "";
$GLOBALS['strNoTrackers'] = "";
$GLOBALS['strConfirmDeleteTrackers'] = "";
$GLOBALS['strConfirmDeleteTracker'] = "";
$GLOBALS['strTrackerProperties'] = "";
$GLOBALS['strDefaultStatus'] = "";
$GLOBALS['strStatus'] = "";
$GLOBALS['strLinkedTrackers'] = "";
$GLOBALS['strTrackerInformation'] = "";
$GLOBALS['strConversionWindow'] = "";
$GLOBALS['strUniqueWindow'] = "";
$GLOBALS['strClick'] = "";
$GLOBALS['strView'] = "";
$GLOBALS['strArrival'] = "";
$GLOBALS['strManual'] = "";
$GLOBALS['strImpression'] = "";
$GLOBALS['strConversionType'] = "";
$GLOBALS['strLinkCampaignsByDefault'] = "";
$GLOBALS['strBackToTrackers'] = "";
$GLOBALS['strIPAddress'] = "";

// Banners (General)
$GLOBALS['strBanner'] = "";
$GLOBALS['strBanners'] = "";
$GLOBALS['strAddBanner'] = "";
$GLOBALS['strAddBanner_Key'] = "";
$GLOBALS['strBannerToCampaign'] = "";
$GLOBALS['strShowBanner'] = "";
$GLOBALS['strBannerProperties'] = "";
$GLOBALS['strBannerHistory'] = "";
$GLOBALS['strNoBanners'] = "";
$GLOBALS['strNoBannersAddCampaign'] = "";
$GLOBALS['strNoBannersAddAdvertiser'] = "";
$GLOBALS['strConfirmDeleteBanner'] = "";
$GLOBALS['strConfirmDeleteBanners'] = "";
$GLOBALS['strShowParentCampaigns'] = "";
$GLOBALS['strHideParentCampaigns'] = "";
$GLOBALS['strHideInactiveBanners'] = "";
$GLOBALS['strInactiveBannersHidden'] = "";
$GLOBALS['strWarningMissing'] = "";
$GLOBALS['strWarningMissingClosing'] = "";
$GLOBALS['strWarningMissingOpening'] = "";
$GLOBALS['strSubmitAnyway'] = "";
$GLOBALS['strBannersOfCampaign'] = ""; //this is added between page name and campaign name eg. 'Banners in coca cola campaign'

// Banner Preferences
$GLOBALS['strBannerPreferences'] = "";
$GLOBALS['strCampaignPreferences'] = "";
$GLOBALS['strDefaultBanners'] = "";
$GLOBALS['strDefaultBannerUrl'] = "";
$GLOBALS['strDefaultBannerDestination'] = "";
$GLOBALS['strAllowedBannerTypes'] = "";
$GLOBALS['strTypeSqlAllow'] = "";
$GLOBALS['strTypeWebAllow'] = "";
$GLOBALS['strTypeUrlAllow'] = "";
$GLOBALS['strTypeHtmlAllow'] = "";
$GLOBALS['strTypeTxtAllow'] = "";

// Banner (Properties)
$GLOBALS['strChooseBanner'] = "";
$GLOBALS['strMySQLBanner'] = "";
$GLOBALS['strWebBanner'] = "";
$GLOBALS['strURLBanner'] = "";
$GLOBALS['strHTMLBanner'] = "";
$GLOBALS['strTextBanner'] = "";
$GLOBALS['strAlterHTML'] = "";
$GLOBALS['strIframeFriendly'] = "";
$GLOBALS['strUploadOrKeep'] = "";
$GLOBALS['strNewBannerFile'] = "";
$GLOBALS['strNewBannerFileAlt'] = "";
$GLOBALS['strNewBannerURL'] = "";
$GLOBALS['strURL'] = "";
$GLOBALS['strKeyword'] = "";
$GLOBALS['strTextBelow'] = "";
$GLOBALS['strWeight'] = "";
$GLOBALS['strAlt'] = "";
$GLOBALS['strStatusText'] = "";
$GLOBALS['strCampaignsWeight'] = "";
$GLOBALS['strBannerWeight'] = "";
$GLOBALS['strBannersWeight'] = "";
$GLOBALS['strAdserverTypeGeneric'] = "";
$GLOBALS['strDoNotAlterHtml'] = "";
$GLOBALS['strGenericOutputAdServer'] = "";
$GLOBALS['strBackToBanners'] = "";
$GLOBALS['strUseWyswygHtmlEditor'] = "";
$GLOBALS['strChangeDefault'] = "";

// Banner (advanced)
$GLOBALS['strBannerPrependHTML'] = "";
$GLOBALS['strBannerAppendHTML'] = "";

// Display Delviery Rules
$GLOBALS['strModifyBannerAcl'] = "";
$GLOBALS['strACL'] = "";
$GLOBALS['strACLAdd'] = "";
$GLOBALS['strApplyLimitationsTo'] = "";
$GLOBALS['strAllBannersInCampaign'] = "";
$GLOBALS['strRemoveAllLimitations'] = "";
$GLOBALS['strEqualTo'] = "";
$GLOBALS['strDifferentFrom'] = "";
$GLOBALS['strLaterThan'] = "";
$GLOBALS['strLaterThanOrEqual'] = "";
$GLOBALS['strEarlierThan'] = "";
$GLOBALS['strEarlierThanOrEqual'] = "";
$GLOBALS['strContains'] = "";
$GLOBALS['strNotContains'] = "";
$GLOBALS['strGreaterThan'] = "";
$GLOBALS['strLessThan'] = "";
$GLOBALS['strGreaterOrEqualTo'] = "";
$GLOBALS['strLessOrEqualTo'] = "";
$GLOBALS['strAND'] = "";                          // logical operator
$GLOBALS['strOR'] = "";                         // logical operator
$GLOBALS['strOnlyDisplayWhen'] = "";
$GLOBALS['strWeekDays'] = "";
$GLOBALS['strTime'] = "";
$GLOBALS['strDomain'] = "";
$GLOBALS['strSource'] = "";
$GLOBALS['strBrowser'] = "";
$GLOBALS['strOS'] = "";
$GLOBALS['strDeliveryLimitations'] = "";

$GLOBALS['strDeliveryCappingReset'] = "";
$GLOBALS['strDeliveryCappingTotal'] = "";
$GLOBALS['strDeliveryCappingSession'] = "";

if (!isset($GLOBALS['strCappingBanner'])) {
    $GLOBALS['strCappingBanner'] = [];
}
$GLOBALS['strCappingBanner']['title'] = "";
$GLOBALS['strCappingBanner']['limit'] = "";

if (!isset($GLOBALS['strCappingCampaign'])) {
    $GLOBALS['strCappingCampaign'] = [];
}
$GLOBALS['strCappingCampaign']['title'] = "";
$GLOBALS['strCappingCampaign']['limit'] = "";

if (!isset($GLOBALS['strCappingZone'])) {
    $GLOBALS['strCappingZone'] = [];
}
$GLOBALS['strCappingZone']['title'] = "";
$GLOBALS['strCappingZone']['limit'] = "";

// Website
$GLOBALS['strAffiliate'] = "";
$GLOBALS['strAffiliates'] = "";
$GLOBALS['strAffiliatesAndZones'] = "";
$GLOBALS['strAddNewAffiliate'] = "";
$GLOBALS['strAffiliateProperties'] = "";
$GLOBALS['strAffiliateHistory'] = "";
$GLOBALS['strNoAffiliates'] = "";
$GLOBALS['strConfirmDeleteAffiliate'] = "";
$GLOBALS['strConfirmDeleteAffiliates'] = "";
$GLOBALS['strInactiveAffiliatesHidden'] = "";
$GLOBALS['strShowParentAffiliates'] = "";
$GLOBALS['strHideParentAffiliates'] = "";

// Website (properties)
$GLOBALS['strWebsite'] = "";
$GLOBALS['strWebsiteURL'] = "";
$GLOBALS['strAllowAffiliateModifyZones'] = "";
$GLOBALS['strAllowAffiliateLinkBanners'] = "";
$GLOBALS['strAllowAffiliateAddZone'] = "";
$GLOBALS['strAllowAffiliateDeleteZone'] = "";
$GLOBALS['strAllowAffiliateGenerateCode'] = "";

// Website (properties - payment information)
$GLOBALS['strPostcode'] = "";
$GLOBALS['strCountry'] = "";

// Website (properties - other information)
$GLOBALS['strWebsiteZones'] = "";

// Zone
$GLOBALS['strZone'] = "";
$GLOBALS['strZones'] = "";
$GLOBALS['strAddNewZone'] = "";
$GLOBALS['strAddNewZone_Key'] = "";
$GLOBALS['strZoneToWebsite'] = "";
$GLOBALS['strLinkedZones'] = "";
$GLOBALS['strAvailableZones'] = "";
$GLOBALS['strLinkingNotSuccess'] = "";
$GLOBALS['strZoneProperties'] = "";
$GLOBALS['strZoneHistory'] = "";
$GLOBALS['strNoZones'] = "";
$GLOBALS['strNoZonesAddWebsite'] = "";
$GLOBALS['strConfirmDeleteZone'] = "";
$GLOBALS['strConfirmDeleteZones'] = "";
$GLOBALS['strConfirmDeleteZoneLinkActive'] = "";
$GLOBALS['strZoneType'] = "";
$GLOBALS['strBannerButtonRectangle'] = "";
$GLOBALS['strInterstitial'] = "";
$GLOBALS['strPopup'] = "";
$GLOBALS['strTextAdZone'] = "";
$GLOBALS['strEmailAdZone'] = "";
$GLOBALS['strZoneVideoInstream'] = "";
$GLOBALS['strZoneVideoOverlay'] = "";
$GLOBALS['strShowMatchingBanners'] = "";
$GLOBALS['strHideMatchingBanners'] = "";
$GLOBALS['strBannerLinkedAds'] = "";
$GLOBALS['strCampaignLinkedAds'] = "";
$GLOBALS['strInactiveZonesHidden'] = "";
$GLOBALS['strWarnChangeZoneType'] = "";
$GLOBALS['strWarnChangeZoneSize'] = '';
$GLOBALS['strWarnChangeBannerSize'] = '';
$GLOBALS['strWarnBannerReadonly'] = '';
$GLOBALS['strZonesOfWebsite'] = ''; //this is added between page name and website name eg. 'Zones in www.example.com'
$GLOBALS['strBackToZones'] = "";

$GLOBALS['strIab']['IAB_FullBanner(468x60)'] = "";
$GLOBALS['strIab']['IAB_Skyscraper(120x600)'] = "";
$GLOBALS['strIab']['IAB_Leaderboard(728x90)'] = "";
$GLOBALS['strIab']['IAB_Button1(120x90)'] = "";
$GLOBALS['strIab']['IAB_Button2(120x60)'] = "";
$GLOBALS['strIab']['IAB_HalfBanner(234x60)'] = "";
$GLOBALS['strIab']['IAB_MicroBar(88x31)'] = "";
$GLOBALS['strIab']['IAB_SquareButton(125x125)'] = "";
$GLOBALS['strIab']['IAB_Rectangle(180x150)*'] = "";
$GLOBALS['strIab']['IAB_SquarePop-up(250x250)'] = "";
$GLOBALS['strIab']['IAB_VerticalBanner(120x240)'] = "";
$GLOBALS['strIab']['IAB_MediumRectangle(300x250)*'] = "";
$GLOBALS['strIab']['IAB_LargeRectangle(336x280)'] = "";
$GLOBALS['strIab']['IAB_VerticalRectangle(240x400)'] = "";
$GLOBALS['strIab']['IAB_WideSkyscraper(160x600)*'] = "";
$GLOBALS['strIab']['IAB_Pop-Under(720x300)'] = "";
$GLOBALS['strIab']['IAB_3:1Rectangle(300x100)'] = "";

// Advanced zone settings
$GLOBALS['strAdvanced'] = "";
$GLOBALS['strChainSettings'] = "";
$GLOBALS['strZoneNoDelivery'] = "";
$GLOBALS['strZoneStopDelivery'] = "";
$GLOBALS['strZoneOtherZone'] = "";
$GLOBALS['strZoneAppend'] = "";
$GLOBALS['strAppendSettings'] = "";
$GLOBALS['strZonePrependHTML'] = "";
$GLOBALS['strZoneAppendNoBanner'] = "";
$GLOBALS['strZoneAppendHTMLCode'] = "";
$GLOBALS['strZoneAppendZoneSelection'] = "";

// Zone probability
$GLOBALS['strZoneProbListChain'] = "";
$GLOBALS['strZoneProbNullPri'] = "";
$GLOBALS['strZoneProbListChainLoop'] = "";

// Linked banners/campaigns/trackers
$GLOBALS['strSelectZoneType'] = "";
$GLOBALS['strLinkedBanners'] = "";
$GLOBALS['strCampaignDefaults'] = "";
$GLOBALS['strLinkedCategories'] = "";
$GLOBALS['strWithXBanners'] = "";
$GLOBALS['strRawQueryString'] = "";
$GLOBALS['strIncludedBanners'] = "";
$GLOBALS['strMatchingBanners'] = "";
$GLOBALS['strNoCampaignsToLink'] = "";
$GLOBALS['strNoTrackersToLink'] = "";
$GLOBALS['strNoZonesToLinkToCampaign'] = "";
$GLOBALS['strSelectBannerToLink'] = "";
$GLOBALS['strSelectCampaignToLink'] = "";
$GLOBALS['strSelectAdvertiser'] = "";
$GLOBALS['strSelectPlacement'] = "";
$GLOBALS['strSelectAd'] = "";
$GLOBALS['strSelectPublisher'] = "";
$GLOBALS['strSelectZone'] = "";
$GLOBALS['strStatusPending'] = "";
$GLOBALS['strStatusApproved'] = "";
$GLOBALS['strStatusDisapproved'] = "";
$GLOBALS['strStatusDuplicate'] = "Tạo bản sao";
$GLOBALS['strStatusOnHold'] = "";
$GLOBALS['strStatusIgnore'] = "";
$GLOBALS['strConnectionType'] = "";
$GLOBALS['strConnTypeSale'] = "";
$GLOBALS['strConnTypeLead'] = "";
$GLOBALS['strConnTypeSignUp'] = "";
$GLOBALS['strShortcutEditStatuses'] = "";
$GLOBALS['strShortcutShowStatuses'] = "";

// Statistics
$GLOBALS['strStats'] = "";
$GLOBALS['strNoStats'] = "";
$GLOBALS['strNoStatsForPeriod'] = "";
$GLOBALS['strGlobalHistory'] = "";
$GLOBALS['strDailyHistory'] = "";
$GLOBALS['strDailyStats'] = "";
$GLOBALS['strWeeklyHistory'] = "";
$GLOBALS['strMonthlyHistory'] = "";
$GLOBALS['strTotalThisPeriod'] = "";
$GLOBALS['strPublisherDistribution'] = "";
$GLOBALS['strCampaignDistribution'] = "";
$GLOBALS['strViewBreakdown'] = "";
$GLOBALS['strBreakdownByDay'] = "";
$GLOBALS['strBreakdownByWeek'] = "Tuần";
$GLOBALS['strBreakdownByMonth'] = "Tháng";
$GLOBALS['strBreakdownByDow'] = "Ngày trong tuần";
$GLOBALS['strBreakdownByHour'] = "Giờ";
$GLOBALS['strItemsPerPage'] = "";
$GLOBALS['strDistributionHistoryCampaign'] = "";
$GLOBALS['strDistributionHistoryBanner'] = "";
$GLOBALS['strDistributionHistoryWebsite'] = "";
$GLOBALS['strDistributionHistoryZone'] = "";
$GLOBALS['strShowGraphOfStatistics'] = "";
$GLOBALS['strExportStatisticsToExcel'] = "";
$GLOBALS['strGDnotEnabled'] = "";
$GLOBALS['strStatsArea'] = "";

// Expiration
$GLOBALS['strNoExpiration'] = "";
$GLOBALS['strEstimated'] = "";
$GLOBALS['strNoExpirationEstimation'] = "";
$GLOBALS['strDaysAgo'] = "";
$GLOBALS['strCampaignStop'] = "";

// Reports
$GLOBALS['strAdvancedReports'] = "";
$GLOBALS['strStartDate'] = "";
$GLOBALS['strEndDate'] = "";
$GLOBALS['strPeriod'] = "";
$GLOBALS['strLimitations'] = "";
$GLOBALS['strWorksheets'] = "";

// Admin_UI_Fields
$GLOBALS['strAllAdvertisers'] = "";
$GLOBALS['strAnonAdvertisers'] = "";
$GLOBALS['strAllPublishers'] = "";
$GLOBALS['strAnonPublishers'] = "";
$GLOBALS['strAllAvailZones'] = "";

// Userlog
$GLOBALS['strUserLog'] = "";
$GLOBALS['strUserLogDetails'] = "";
$GLOBALS['strDeleteLog'] = "";
$GLOBALS['strAction'] = "";
$GLOBALS['strNoActionsLogged'] = "";

// Code generation
$GLOBALS['strGenerateBannercode'] = "";
$GLOBALS['strChooseInvocationType'] = "";
$GLOBALS['strGenerate'] = "";
$GLOBALS['strParameters'] = "";
$GLOBALS['strFrameSize'] = "";
$GLOBALS['strBannercode'] = "";
$GLOBALS['strTrackercode'] = "";
$GLOBALS['strBackToTheList'] = "";
$GLOBALS['strCharset'] = "";
$GLOBALS['strAutoDetect'] = "";
$GLOBALS['strCacheBusterComment'] = "";
$GLOBALS['strGenerateHttpsTags'] = "";

// Errors
$GLOBALS['strErrorDatabaseConnection'] = "";
$GLOBALS['strErrorCantConnectToDatabase'] = "";
$GLOBALS['strNoMatchesFound'] = "";
$GLOBALS['strErrorOccurred'] = "";
$GLOBALS['strErrorDBPlain'] = "";
$GLOBALS['strErrorDBSerious'] = "";
$GLOBALS['strErrorDBNoDataPlain'] = "";
$GLOBALS['strErrorDBNoDataSerious'] = "";
$GLOBALS['strErrorDBCorrupt'] = "";
$GLOBALS['strErrorDBContact'] = "";
$GLOBALS['strErrorDBSubmitBug'] = "";
$GLOBALS['strMaintenanceNotActive'] = "";
$GLOBALS['strErrorLinkingBanner'] = "";
$GLOBALS['strUnableToLinkBanner'] = "";
$GLOBALS['strErrorEditingCampaignRevenue'] = "";
$GLOBALS['strErrorEditingCampaignECPM'] = "";
$GLOBALS['strErrorEditingZone'] = "";
$GLOBALS['strUnableToChangeZone'] = "";
$GLOBALS['strDatesConflict'] = "";
$GLOBALS['strEmailNoDates'] = "";
$GLOBALS['strWarningInaccurateStats'] = "";
$GLOBALS['strWarningInaccurateReadMore'] = "";
$GLOBALS['strWarningInaccurateReport'] = "";

//Validation
$GLOBALS['strRequiredFieldLegend'] = "";
$GLOBALS['strFormContainsErrors'] = "";
$GLOBALS['strXRequiredField'] = "";
$GLOBALS['strEmailField'] = "";
$GLOBALS['strNumericField'] = "";
$GLOBALS['strGreaterThanZeroField'] = "";
$GLOBALS['strXGreaterThanZeroField'] = "";
$GLOBALS['strXPositiveWholeNumberField'] = "";
$GLOBALS['strInvalidWebsiteURL'] = "";

// Email
$GLOBALS['strSirMadam'] = "";
$GLOBALS['strMailSubject'] = "";
$GLOBALS['strMailHeader'] = "";
$GLOBALS['strMailBannerStats'] = "";
$GLOBALS['strMailBannerActivatedSubject'] = "";
$GLOBALS['strMailBannerDeactivatedSubject'] = "";
$GLOBALS['strMailBannerActivated'] = "";
$GLOBALS['strMailBannerDeactivated'] = "";
$GLOBALS['strMailFooter'] = "";
$GLOBALS['strClientDeactivated'] = "";
$GLOBALS['strBeforeActivate'] = "";
$GLOBALS['strAfterExpire'] = "";
$GLOBALS['strNoMoreImpressions'] = "";
$GLOBALS['strNoMoreClicks'] = "";
$GLOBALS['strNoMoreConversions'] = "";
$GLOBALS['strWeightIsNull'] = "";
$GLOBALS['strRevenueIsNull'] = "";
$GLOBALS['strTargetIsNull'] = "";
$GLOBALS['strNoViewLoggedInInterval'] = "";
$GLOBALS['strNoClickLoggedInInterval'] = "";
$GLOBALS['strNoConversionLoggedInInterval'] = "";
$GLOBALS['strMailReportPeriod'] = "";
$GLOBALS['strMailReportPeriodAll'] = "";
$GLOBALS['strNoStatsForCampaign'] = "";
$GLOBALS['strImpendingCampaignExpiry'] = "";
$GLOBALS['strYourCampaign'] = "";
$GLOBALS['strTheCampiaignBelongingTo'] = "";
$GLOBALS['strImpendingCampaignExpiryDateBody'] = "";
$GLOBALS['strImpendingCampaignExpiryImpsBody'] = "";
$GLOBALS['strImpendingCampaignExpiryBody'] = "";

// Priority
$GLOBALS['strPriority'] = "Độ ưu tiên";
$GLOBALS['strSourceEdit'] = "";

// Preferences
$GLOBALS['strPreferences'] = "";
$GLOBALS['strUserPreferences'] = "";
$GLOBALS['strChangePassword'] = "";
$GLOBALS['strChangeEmail'] = "";
$GLOBALS['strCurrentPassword'] = "";
$GLOBALS['strChooseNewPassword'] = "";
$GLOBALS['strReenterNewPassword'] = "";
$GLOBALS['strNameLanguage'] = "";
$GLOBALS['strAccountPreferences'] = "";
$GLOBALS['strCampaignEmailReportsPreferences'] = "";
$GLOBALS['strTimezonePreferences'] = "";
$GLOBALS['strAdminEmailWarnings'] = "";
$GLOBALS['strAgencyEmailWarnings'] = "";
$GLOBALS['strAdveEmailWarnings'] = "";
$GLOBALS['strFullName'] = "";
$GLOBALS['strEmailAddress'] = "";
$GLOBALS['strUserDetails'] = "";
$GLOBALS['strUserInterfacePreferences'] = "";
$GLOBALS['strPluginPreferences'] = "";
$GLOBALS['strColumnName'] = "";
$GLOBALS['strShowColumn'] = "";
$GLOBALS['strCustomColumnName'] = "";
$GLOBALS['strColumnRank'] = "";

// Long names
$GLOBALS['strRevenue'] = "";
$GLOBALS['strNumberOfItems'] = "";
$GLOBALS['strRevenueCPC'] = "";
$GLOBALS['strERPM'] = "";
$GLOBALS['strERPC'] = "";
$GLOBALS['strERPS'] = "";
$GLOBALS['strEIPM'] = "";
$GLOBALS['strEIPC'] = "";
$GLOBALS['strEIPS'] = "";
$GLOBALS['strECPM'] = "";
$GLOBALS['strECPC'] = "";
$GLOBALS['strECPS'] = "";
$GLOBALS['strPendingConversions'] = "";
$GLOBALS['strImpressionSR'] = "";
$GLOBALS['strClickSR'] = "";

// Short names
$GLOBALS['strRevenue_short'] = "";
$GLOBALS['strBasketValue_short'] = "";
$GLOBALS['strNumberOfItems_short'] = "";
$GLOBALS['strRevenueCPC_short'] = "";
$GLOBALS['strERPM_short'] = "";
$GLOBALS['strERPC_short'] = "";
$GLOBALS['strERPS_short'] = "";
$GLOBALS['strEIPM_short'] = "";
$GLOBALS['strEIPC_short'] = "";
$GLOBALS['strEIPS_short'] = "";
$GLOBALS['strECPM_short'] = "";
$GLOBALS['strECPC_short'] = "";
$GLOBALS['strECPS_short'] = "";
$GLOBALS['strID_short'] = "ID";
$GLOBALS['strRequests_short'] = "";
$GLOBALS['strImpressions_short'] = "";
$GLOBALS['strClicks_short'] = "";
$GLOBALS['strCTR_short'] = "";
$GLOBALS['strConversions_short'] = "";
$GLOBALS['strPendingConversions_short'] = "";
$GLOBALS['strImpressionSR_short'] = "";
$GLOBALS['strClickSR_short'] = "";

// Global Settings
$GLOBALS['strConfiguration'] = "";
$GLOBALS['strGlobalSettings'] = "";
$GLOBALS['strGeneralSettings'] = "";
$GLOBALS['strMainSettings'] = "";
$GLOBALS['strPlugins'] = "";
$GLOBALS['strChooseSection'] = '';

// Product Updates
$GLOBALS['strProductUpdates'] = "";
$GLOBALS['strViewPastUpdates'] = "";
$GLOBALS['strFromVersion'] = "";
$GLOBALS['strToVersion'] = "";
$GLOBALS['strToggleDataBackupDetails'] = "";
$GLOBALS['strClickViewBackupDetails'] = "";
$GLOBALS['strClickHideBackupDetails'] = "";
$GLOBALS['strShowBackupDetails'] = "";
$GLOBALS['strHideBackupDetails'] = "";
$GLOBALS['strBackupDeleteConfirm'] = "";
$GLOBALS['strDeleteArtifacts'] = "";
$GLOBALS['strArtifacts'] = "";
$GLOBALS['strBackupDbTables'] = "";
$GLOBALS['strLogFiles'] = "";
$GLOBALS['strConfigBackups'] = "";
$GLOBALS['strUpdatedDbVersionStamp'] = "";
$GLOBALS['aProductStatus']['UPGRADE_COMPLETE'] = "";
$GLOBALS['aProductStatus']['UPGRADE_FAILED'] = "";

// Agency
$GLOBALS['strAgencyManagement'] = "";
$GLOBALS['strAgency'] = "";
$GLOBALS['strAddAgency'] = "";
$GLOBALS['strAddAgency_Key'] = "";
$GLOBALS['strTotalAgencies'] = "";
$GLOBALS['strAgencyProperties'] = "";
$GLOBALS['strNoAgencies'] = "";
$GLOBALS['strConfirmDeleteAgency'] = "";
$GLOBALS['strHideInactiveAgencies'] = "";
$GLOBALS['strInactiveAgenciesHidden'] = "";
$GLOBALS['strSwitchAccount'] = "";
$GLOBALS['strAgencyStatusRunning'] = "";
$GLOBALS['strAgencyStatusInactive'] = "";
$GLOBALS['strAgencyStatusPaused'] = "";

// Channels
$GLOBALS['strChannel'] = "";
$GLOBALS['strChannels'] = "";
$GLOBALS['strChannelManagement'] = "";
$GLOBALS['strAddNewChannel'] = "";
$GLOBALS['strAddNewChannel_Key'] = "";
$GLOBALS['strChannelToWebsite'] = "";
$GLOBALS['strNoChannels'] = "";
$GLOBALS['strNoChannelsAddWebsite'] = "";
$GLOBALS['strEditChannelLimitations'] = "";
$GLOBALS['strChannelProperties'] = "";
$GLOBALS['strChannelLimitations'] = "";
$GLOBALS['strConfirmDeleteChannel'] = "";
$GLOBALS['strConfirmDeleteChannels'] = "";
$GLOBALS['strChannelsOfWebsite'] = ''; //this is added between page name and website name eg. 'delivery rule sets in www.example.com'

// Tracker Variables
$GLOBALS['strVariableName'] = "";
$GLOBALS['strVariableDescription'] = "Mô tả";
$GLOBALS['strVariableDataType'] = "";
$GLOBALS['strVariablePurpose'] = "";
$GLOBALS['strGeneric'] = "";
$GLOBALS['strBasketValue'] = "";
$GLOBALS['strNumItems'] = "";
$GLOBALS['strVariableIsUnique'] = "";
$GLOBALS['strNumber'] = "";
$GLOBALS['strString'] = "";
$GLOBALS['strTrackFollowingVars'] = "";
$GLOBALS['strAddVariable'] = "";
$GLOBALS['strNoVarsToTrack'] = "";
$GLOBALS['strVariableRejectEmpty'] = "";
$GLOBALS['strTrackingSettings'] = "";
$GLOBALS['strTrackerType'] = "";
$GLOBALS['strTrackerTypeJS'] = "";
$GLOBALS['strTrackerTypeDefault'] = "";
$GLOBALS['strTrackerTypeDOM'] = "";
$GLOBALS['strTrackerTypeCustom'] = "";
$GLOBALS['strVariableCode'] = "";

// Password recovery
$GLOBALS['strForgotPassword'] = "";
$GLOBALS['strPasswordRecovery'] = "";
$GLOBALS['strWelcomePage'] = "";
$GLOBALS['strWelcomePageText'] = "";
$GLOBALS['strEmailRequired'] = "";
$GLOBALS['strPwdRecWrongExpired'] = "";
$GLOBALS['strPwdRecEnterEmail'] = "";
$GLOBALS['strPwdRecEnterPassword'] = "";
$GLOBALS['strProceed'] = "";
$GLOBALS['strNotifyPageMessage'] = "";

// Password recovery - Default
$GLOBALS['strPwdRecEmailPwdRecovery'] = "";
$GLOBALS['strPwdRecEmailBody'] = "";

$GLOBALS['strPwdRecEmailSincerely'] = "";

// Password recovery - Welcome email
$GLOBALS['strWelcomeEmailSubject'] = "";
$GLOBALS['strWelcomeEmailBody'] = "";

// Password recovery - Hash update
$GLOBALS['strPasswordUpdateEmailSubject'] = "";
$GLOBALS['strPasswordUpdateEmailBody'] = "";

// Password reset warning
$GLOBALS['strPasswordResetRequiredTitle'] = "";
$GLOBALS['strPasswordResetRequired'] = "";
$GLOBALS['strPasswordUnsafeWarning'] = "";

// Audit
$GLOBALS['strAdditionalItems'] = "";
$GLOBALS['strAuditSystem'] = "";
$GLOBALS['strFor'] = "";
$GLOBALS['strHas'] = "";
$GLOBALS['strBinaryData'] = "";
$GLOBALS['strAuditTrailDisabled'] = "";

// Widget - Audit
$GLOBALS['strAuditNoData'] = "";
$GLOBALS['strAuditTrail'] = "";
$GLOBALS['strAuditTrailSetup'] = "";
$GLOBALS['strAuditTrailGoTo'] = "";
$GLOBALS['strAuditTrailNotEnabled'] = "";

// Widget - Campaign
$GLOBALS['strCampaignGoTo'] = "";
$GLOBALS['strCampaignSetUp'] = "";
$GLOBALS['strCampaignNoRecords'] = "";
$GLOBALS['strCampaignNoRecordsAdmin'] = "";

$GLOBALS['strCampaignNoDataTimeSpan'] = "";
$GLOBALS['strCampaignAuditNotActivated'] = "";
$GLOBALS['strCampaignAuditTrailSetup'] = "";

$GLOBALS['strUnsavedChanges'] = "";
$GLOBALS['strDeliveryLimitationsDisagree'] = "";
$GLOBALS['strDeliveryRulesDbError'] = "";
$GLOBALS['strDeliveryRulesTruncation'] = "";
$GLOBALS['strDeliveryLimitationsInputErrors'] = "";

//confirmation messages
$GLOBALS['strYouAreNowWorkingAsX'] = "";
$GLOBALS['strYouDontHaveAccess'] = "";

$GLOBALS['strAdvertiserHasBeenAdded'] = "";
$GLOBALS['strAdvertiserHasBeenUpdated'] = "";
$GLOBALS['strAdvertiserHasBeenDeleted'] = "";
$GLOBALS['strAdvertisersHaveBeenDeleted'] = "";

$GLOBALS['strTrackerHasBeenAdded'] = "";
$GLOBALS['strTrackerHasBeenUpdated'] = "";
$GLOBALS['strTrackerVarsHaveBeenUpdated'] = "";
$GLOBALS['strTrackerCampaignsHaveBeenUpdated'] = "";
$GLOBALS['strTrackerAppendHasBeenUpdated'] = "";
$GLOBALS['strTrackerHasBeenDeleted'] = "";
$GLOBALS['strTrackersHaveBeenDeleted'] = "";
$GLOBALS['strTrackerHasBeenDuplicated'] = "";
$GLOBALS['strTrackerHasBeenMoved'] = "";

$GLOBALS['strCampaignHasBeenAdded'] = "";
$GLOBALS['strCampaignHasBeenUpdated'] = "";
$GLOBALS['strCampaignTrackersHaveBeenUpdated'] = "";
$GLOBALS['strCampaignHasBeenDeleted'] = "";
$GLOBALS['strCampaignsHaveBeenDeleted'] = "";
$GLOBALS['strCampaignHasBeenDuplicated'] = "";
$GLOBALS['strCampaignHasBeenMoved'] = "";

$GLOBALS['strBannerHasBeenAdded'] = "";
$GLOBALS['strBannerHasBeenUpdated'] = "";
$GLOBALS['strBannerAdvancedHasBeenUpdated'] = "";
$GLOBALS['strBannerAclHasBeenUpdated'] = "";
$GLOBALS['strBannerAclHasBeenAppliedTo'] = "";
$GLOBALS['strBannerHasBeenDeleted'] = "";
$GLOBALS['strBannersHaveBeenDeleted'] = "";
$GLOBALS['strBannerHasBeenDuplicated'] = "";
$GLOBALS['strBannerHasBeenMoved'] = "";
$GLOBALS['strBannerHasBeenActivated'] = "";
$GLOBALS['strBannerHasBeenDeactivated'] = "";

$GLOBALS['strXZonesLinked'] = "";
$GLOBALS['strXZonesUnlinked'] = "";

$GLOBALS['strWebsiteHasBeenAdded'] = "";
$GLOBALS['strWebsiteHasBeenUpdated'] = "";
$GLOBALS['strWebsiteHasBeenDeleted'] = "";
$GLOBALS['strWebsitesHaveBeenDeleted'] = "";
$GLOBALS['strWebsiteHasBeenDuplicated'] = "";

$GLOBALS['strZoneHasBeenAdded'] = "";
$GLOBALS['strZoneHasBeenUpdated'] = "";
$GLOBALS['strZoneAdvancedHasBeenUpdated'] = "";
$GLOBALS['strZoneHasBeenDeleted'] = "";
$GLOBALS['strZonesHaveBeenDeleted'] = "";
$GLOBALS['strZoneHasBeenDuplicated'] = "";
$GLOBALS['strZoneHasBeenMoved'] = "";
$GLOBALS['strZoneLinkedBanner'] = "";
$GLOBALS['strZoneLinkedCampaign'] = "";
$GLOBALS['strZoneRemovedBanner'] = "";
$GLOBALS['strZoneRemovedCampaign'] = "";

$GLOBALS['strChannelHasBeenAdded'] = "";
$GLOBALS['strChannelHasBeenUpdated'] = "";
$GLOBALS['strChannelAclHasBeenUpdated'] = "";
$GLOBALS['strChannelHasBeenDeleted'] = "";
$GLOBALS['strChannelsHaveBeenDeleted'] = "";
$GLOBALS['strChannelHasBeenDuplicated'] = "";

$GLOBALS['strUserPreferencesUpdated'] = "";
$GLOBALS['strEmailChanged'] = "";
$GLOBALS['strPasswordChanged'] = "";
$GLOBALS['strXPreferencesHaveBeenUpdated'] = "";
$GLOBALS['strXSettingsHaveBeenUpdated'] = "";
$GLOBALS['strTZPreferencesWarning'] = "";

// Report error messages
$GLOBALS['strReportErrorMissingSheets'] = "";
$GLOBALS['strReportErrorUnknownCode'] = "";

/* ------------------------------------------------------- */
/* Password strength                                       */
/* ------------------------------------------------------- */

$GLOBALS['strPasswordMinLength'] = '';
$GLOBALS['strPasswordTooShort'] = "";

if (!isset($GLOBALS['strPasswordScore'])) {
    $GLOBALS['strPasswordScore'] = [];
}

$GLOBALS['strPasswordScore'][0] = "";
$GLOBALS['strPasswordScore'][1] = "";
$GLOBALS['strPasswordScore'][2] = "";
$GLOBALS['strPasswordScore'][3] = "";
$GLOBALS['strPasswordScore'][4] = "";


/* ------------------------------------------------------- */
/* Keyboard shortcut assignments                           */
/* ------------------------------------------------------- */

// Reserved keys
// Do not change these unless absolutely needed
$GLOBALS['keyHome'] = "";
$GLOBALS['keyUp'] = "";
$GLOBALS['keyNextItem'] = ".";
$GLOBALS['keyPreviousItem'] = ",";
$GLOBALS['keyList'] = "";

// Other keys
// Please make sure you underline the key you
// used in the string in default.lang.php
$GLOBALS['keySearch'] = "";
$GLOBALS['keyCollapseAll'] = "";
$GLOBALS['keyExpandAll'] = "";
$GLOBALS['keyAddNew'] = "";
$GLOBALS['keyNext'] = "";
$GLOBALS['keyPrevious'] = "";
$GLOBALS['keyLinkUser'] = "";
$GLOBALS['keyWorkingAs'] = "";
