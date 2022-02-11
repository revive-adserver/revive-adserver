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

$GLOBALS['phpAds_DecimalPoint'] = ".";
$GLOBALS['phpAds_ThousandsSeperator'] = ",";

// Date & time configuration

// Formats used by PEAR Spreadsheet_Excel_Writer packate

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
$GLOBALS['strUserAccountUpdated'] = "Trương mục người dùng Cập Nhật";
$GLOBALS['strUserWasDeleted'] = "Người dùng đã bị xóa";
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
$GLOBALS['strEnableCookies'] = "Bạn cần phải bật cookie trước khi bạn có thể sử dụng {$PRODUCT_NAME}";
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

// General advertising
$GLOBALS['strStatsVariables'] = "Các biến số";

// Finance

// Time and date related
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

// Advertisers properties

// Campaign
$GLOBALS['strHiddenAdvertiser'] = "Nhà quảng cáo";

// Campaign-zone linking page


// Campaign properties

// Tracker

// Banners (General)

// Banner Preferences

// Banner (Properties)

// Banner (advanced)

// Display Delviery Rules


if (!isset($GLOBALS['strCappingBanner'])) {
    $GLOBALS['strCappingBanner'] = [];
}

if (!isset($GLOBALS['strCappingCampaign'])) {
    $GLOBALS['strCappingCampaign'] = [];
}

if (!isset($GLOBALS['strCappingZone'])) {
    $GLOBALS['strCappingZone'] = [];
}

// Website

// Website (properties)

// Website (properties - payment information)

// Website (properties - other information)

// Zone


// Advanced zone settings

// Zone probability

// Linked banners/campaigns/trackers
$GLOBALS['strStatusDuplicate'] = "Tạo bản sao";

// Statistics
$GLOBALS['strBreakdownByWeek'] = "Tuần";
$GLOBALS['strBreakdownByMonth'] = "Tháng";
$GLOBALS['strBreakdownByDow'] = "Ngày trong tuần";
$GLOBALS['strBreakdownByHour'] = "Giờ";

// Expiration

// Reports

// Admin_UI_Fields

// Userlog

// Code generation

// Errors

//Validation

// Email

// Priority
$GLOBALS['strPriority'] = "Độ ưu tiên";

// Preferences

// Long names

// Short names
$GLOBALS['strID_short'] = "ID";

// Global Settings

// Product Updates

// Agency

// Channels

// Tracker Variables
$GLOBALS['strVariableDescription'] = "Mô tả";

// Password recovery

// Password recovery - Default


// Password recovery - Welcome email

// Password recovery - Hash update

// Password reset warning

// Audit

// Widget - Audit

// Widget - Campaign



//confirmation messages










// Report error messages

/* ------------------------------------------------------- */
/* Password strength                                       */
/* ------------------------------------------------------- */


if (!isset($GLOBALS['strPasswordScore'])) {
    $GLOBALS['strPasswordScore'] = [];
}



/* ------------------------------------------------------- */
/* Keyboard shortcut assignments                           */
/* ------------------------------------------------------- */

// Reserved keys
// Do not change these unless absolutely needed
$GLOBALS['keyNextItem'] = ".";
$GLOBALS['keyPreviousItem'] = ",";

// Other keys
// Please make sure you underline the key you
// used in the string in default.lang.php
