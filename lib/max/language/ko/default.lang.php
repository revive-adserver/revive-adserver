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

$GLOBALS['phpAds_DecimalPoint'] = ",";
$GLOBALS['phpAds_ThousandsSeperator'] = ".";

// Date & time configuration
$GLOBALS['date_format'] = "%d-%m-%Y";
$GLOBALS['time_format'] = "%H:%M:%S";
$GLOBALS['minute_format'] = "%H:% M";
$GLOBALS['month_format'] = "%m-%Y";
$GLOBALS['day_format'] = "%m-%d";
$GLOBALS['week_format'] = "%W-%Y";
$GLOBALS['weekiso_format'] = "%V-%G";

// Formats used by PEAR Spreadsheet_Excel_Writer packate
$GLOBALS['excel_integer_formatting'] = "#,##0;-#,##0;-";
$GLOBALS['excel_decimal_formatting'] = "#,##0.000;-#,##0.000;-";

/* ------------------------------------------------------- */
/* Translations                                          */
/* ------------------------------------------------------- */

$GLOBALS['strHome'] = "홈";
$GLOBALS['strHelp'] = "�?�움�?";
$GLOBALS['strStartOver'] = "재시작";
$GLOBALS['strShortcuts'] = "바로가기";
$GLOBALS['strActions'] = "작업";
$GLOBALS['strAndXMore'] = "and %s more";
$GLOBALS['strAdminstration'] = "목�?";
$GLOBALS['strMaintenance'] = "유지보수";
$GLOBALS['strProbability'] = "확률";
$GLOBALS['strInvocationcode'] = "호출코드";
$GLOBALS['strBasicInformation'] = "기본 정보";
$GLOBALS['strAppendTrackerCode'] = "추적 코드 추가";
$GLOBALS['strOverview'] = "목�?보기";
$GLOBALS['strSearch'] = "검색(<u>S</u>)";
$GLOBALS['strDetails'] = "�?세히";
$GLOBALS['strUpdateSettings'] = "업데이트 설정";
$GLOBALS['strCheckForUpdates'] = "업�?��?�트 검색";
$GLOBALS['strWhenCheckingForUpdates'] = "업데이트를 확인할 때";
$GLOBALS['strCompact'] = "간단히";
$GLOBALS['strUser'] = "사용�?";
$GLOBALS['strDuplicate'] = "복제";
$GLOBALS['strCopyOf'] = "복사:";
$GLOBALS['strMoveTo'] = "�?��?�하기";
$GLOBALS['strDelete'] = "삭제";
$GLOBALS['strActivate'] = "활성화";
$GLOBALS['strConvert'] = "변환";
$GLOBALS['strRefresh'] = "새로고침";
$GLOBALS['strSaveChanges'] = "변경사항 저장";
$GLOBALS['strUp'] = "위로";
$GLOBALS['strDown'] = "아래로";
$GLOBALS['strSave'] = "저장";
$GLOBALS['strCancel'] = "취소";
$GLOBALS['strBack'] = "뒤로";
$GLOBALS['strPrevious'] = "�?�전";
$GLOBALS['strNext'] = "다�?�";
$GLOBALS['strYes'] = "예";
$GLOBALS['strNo'] = "아니오";
$GLOBALS['strNone'] = "없�?�";
$GLOBALS['strCustom'] = "사용�? 지정";
$GLOBALS['strDefault'] = "기본설정";
$GLOBALS['strUnknown'] = "알려지지 않�?�";
$GLOBALS['strUnlimited'] = "제한없�?�";
$GLOBALS['strUntitled'] = "제목없�?�";
$GLOBALS['strAll'] = "전체";
$GLOBALS['strAverage'] = "평균";
$GLOBALS['strOverall'] = "전체";
$GLOBALS['strTotal'] = "합계";
$GLOBALS['strFrom'] = "드림";
$GLOBALS['strTo'] = "받는 사람";
$GLOBALS['strAdd'] = "추가 ";
$GLOBALS['strLinkedTo'] = "연결할 링크";
$GLOBALS['strDaysLeft'] = "남은 기간";
$GLOBALS['strCheckAllNone'] = "모두 선택 / 해제";
$GLOBALS['strKiloByte'] = "KB";
$GLOBALS['strExpandAll'] = "모�? 보기(<u>E</u>)";
$GLOBALS['strCollapseAll'] = "모�? 숨기기(<u>C</u>)";
$GLOBALS['strShowAll'] = "모�? 보기";
$GLOBALS['strNoAdminInterface'] = "서비스를 �?�용할 수 없습니다.";
$GLOBALS['strFieldStartDateBeforeEnd'] = "시작일은 종료일보다 이전이어야 합니다.";
$GLOBALS['strFieldContainsErrors'] = "다�?� 필드�? 오류가 있습니다.:";
$GLOBALS['strFieldFixBeforeContinue1'] = "오류를 수정한 후�?";
$GLOBALS['strFieldFixBeforeContinue2'] = "다시 시작해야 합니다..";
$GLOBALS['strMiscellaneous'] = "기타";
$GLOBALS['strCollectedAllStats'] = "�?��?� 통계";
$GLOBALS['strCollectedToday'] = "오늘";
$GLOBALS['strCollectedYesterday'] = "어제";
$GLOBALS['strCollectedThisWeek'] = "이번 주";
$GLOBALS['strCollectedLastWeek'] = "지난 주";
$GLOBALS['strCollectedThisMonth'] = "이번 달";
$GLOBALS['strCollectedLastMonth'] = "지난 달";
$GLOBALS['strCollectedLast7Days'] = "지난 7일간";
$GLOBALS['strCollectedSpecificDates'] = "특정 날짜";
$GLOBALS['strValue'] = "값";
$GLOBALS['strWarning'] = "경고";
$GLOBALS['strNotice'] = "공지사항";

// Dashboard
$GLOBALS['strDashboardCantBeDisplayed'] = "대시보드를 표시할 수 없습니다";
$GLOBALS['strNoCheckForUpdates'] = "업데이트 확인 설정이 체크되어 있지 않다면<br />대시보드를 표시할 수 없습니다.";
$GLOBALS['strEnableCheckForUpdates'] = "<a href='account-settings-update.php' target='_top'>업데이트 확인</a>설정을 <a href='account-settings-update.php' target='_top'>업데이트 설정</a>화면에서<br/>활성화해 주세요.";
// Dashboard Errors
$GLOBALS['strDashboardErrorCode'] = "코드";
$GLOBALS['strDashboardSystemMessage'] = "시스템 메시지";
$GLOBALS['strDashboardErrorHelp'] = "이 오류가 반복해서 발생하는 경우 <a href='http://forum.revive-adserver.com/'> forum.revive-adserver.com</a>에 자세한 오류 사항을 게시해 주세요.";

// Priority
$GLOBALS['strPriority'] = "우선순위";
$GLOBALS['strPriorityLevel'] = "우선 순위";
$GLOBALS['strOverrideAds'] = "캠페인 광고 재정비";
$GLOBALS['strHighAds'] = "캠페인 광고 규정";
$GLOBALS['strECPMAds'] = "eCPM Campaign Advertisements";
$GLOBALS['strLowAds'] = "남은 캠페인 광고";
$GLOBALS['strLimitations'] = "Delivery rules";
$GLOBALS['strNoLimitations'] = "No delivery rules";
$GLOBALS['strCapping'] = "상한";

// Properties
$GLOBALS['strName'] = "이름";
$GLOBALS['strSize'] = "크기";
$GLOBALS['strWidth'] = "가로 크기";
$GLOBALS['strHeight'] = "높이";
$GLOBALS['strTarget'] = "대상";
$GLOBALS['strLanguage'] = "언어";
$GLOBALS['strDescription'] = "설명";
$GLOBALS['strVariables'] = "변수";
$GLOBALS['strID'] = "ID";
$GLOBALS['strComments'] = "댓글";

// User access
$GLOBALS['strWorkingAs'] = "다음 권한으로 관리중입니다 :";
$GLOBALS['strWorkingAs_Key'] = "다음 권한으로 관리중 :";
$GLOBALS['strWorkingAs'] = "다음 권한으로 관리중입니다 :";
$GLOBALS['strSwitchTo'] = "로 전환";
$GLOBALS['strUseSearchBoxToFindMoreAccounts'] = "Use the switcher's search box to find more accounts";
$GLOBALS['strWorkingFor'] = "%s for...";
$GLOBALS['strNoAccountWithXInNameFound'] = "이름이 \"%s\"인 계정이 없습니다.";
$GLOBALS['strRecentlyUsed'] = "최근 사용";
$GLOBALS['strLinkUser'] = "사용자 추가";
$GLOBALS['strLinkUser_Key'] = "사용자 추가";
$GLOBALS['strUsernameToLink'] = "추가할 사용자의 계정 아이디";
$GLOBALS['strNewUserWillBeCreated'] = "새로운 사용자가 생성됩니다";
$GLOBALS['strToLinkProvideEmail'] = "To add user, provide user's email";
$GLOBALS['strToLinkProvideUsername'] = "To add user, provide username";
$GLOBALS['strUserLinkedToAccount'] = "User has been added to account";
$GLOBALS['strUserAccountUpdated'] = "User account updated";
$GLOBALS['strUserUnlinkedFromAccount'] = "User has been removed from account";
$GLOBALS['strUserWasDeleted'] = "User has been deleted";
$GLOBALS['strUserNotLinkedWithAccount'] = "Such user is not linked with account";
$GLOBALS['strCantDeleteOneAdminUser'] = "You can't delete a user. At least one user needs to be linked with admin account.";
$GLOBALS['strLinkUserHelp'] = "To add an <b>existing user</b>, type the %1\$s and click %2\$s <br />To add a <b>new user</b>, type the desired %1\$s and click %2\$s";
$GLOBALS['strLinkUserHelpUser'] = "사용자 이름";
$GLOBALS['strLinkUserHelpEmail'] = "이메일 주소";
$GLOBALS['strLastLoggedIn'] = "마지막 로그인";
$GLOBALS['strDateLinked'] = "Date linked";

// Login & Permissions
$GLOBALS['strUserAccess'] = "User Access";
$GLOBALS['strAdminAccess'] = "Admin Access";
$GLOBALS['strUserProperties'] = "사용자 속성";
$GLOBALS['strPermissions'] = "권한";
$GLOBALS['strAuthentification'] = "인증";
$GLOBALS['strWelcomeTo'] = "환영합니다!";
$GLOBALS['strEnterUsername'] = "사용자ID와 비밀번호를 입력해 주세요.";
$GLOBALS['strEnterBoth'] = "사용자ID와 비밀번호를 모두 입력하세요!";
$GLOBALS['strEnableCookies'] = "You need to enable cookies before you can use {$PRODUCT_NAME}";
$GLOBALS['strSessionIDNotMatch'] = "세션 쿠키 오류, 다시 로그인 하시기 바랍니다";
$GLOBALS['strLogin'] = "로그인";
$GLOBALS['strLogout'] = "로그아웃";
$GLOBALS['strUsername'] = "사용자 이름";
$GLOBALS['strPassword'] = "비밀번호";
$GLOBALS['strPasswordRepeat'] = "비밀번호 확인";
$GLOBALS['strAccessDenied'] = "접근할 수 없습니다.";
$GLOBALS['strUsernameOrPasswordWrong'] = "사용자 이름 혹은 비밀번호가 정확하지 않습니다. 다시 시도해 주십시오.";
$GLOBALS['strPasswordWrong'] = "올바른 비밀번호가 아닙니다.";
$GLOBALS['strNotAdmin'] = "권한�?� 없습니다.";
$GLOBALS['strDuplicateClientName'] = "이미 존재하는 ID입니다. 다른 사용자ID를 입력해 주세요!";
$GLOBALS['strInvalidPassword'] = "새 암호가 유효하지 않습니다. 다른 암호를 사용하세요.";
$GLOBALS['strInvalidEmail'] = "이메일 주소가 명확하지 않습니다. 이메일 주소를 정확하게 입력하세요.";
$GLOBALS['strNotSamePasswords'] = "두개의 암호가 일치하지 않습니다.";
$GLOBALS['strRepeatPassword'] = "비밀번호 확인";
$GLOBALS['strDeadLink'] = "링크가 올바르지 않습니다.";
$GLOBALS['strNoPlacement'] = "Selected campaign does not exist. Try this <a href='{link}'>link</a> instead";
$GLOBALS['strNoAdvertiser'] = "Selected advertiser does not exist. Try this <a href='{link}'>link</a> instead";

// General advertising
$GLOBALS['strRequests'] = "Requests";
$GLOBALS['strImpressions'] = "노출수";
$GLOBALS['strClicks'] = "클릭수";
$GLOBALS['strConversions'] = "변환";
$GLOBALS['strCTRShort'] = "클릭율";
$GLOBALS['strCNVRShort'] = "SR";
$GLOBALS['strCTR'] = "클릭한 비율";
$GLOBALS['strTotalClicks'] = "전체 클릭 수";
$GLOBALS['strTotalConversions'] = "변환 합계";
$GLOBALS['strDateTime'] = "날짜/시간";
$GLOBALS['strTrackerID'] = "추적 ID";
$GLOBALS['strTrackerName'] = "추적 이름";
$GLOBALS['strTrackerImageTag'] = "이미지 태그";
$GLOBALS['strTrackerJsTag'] = "자바 스크립트 태그";
$GLOBALS['strTrackerAlwaysAppend'] = "Always display appended code, even if no conversion is recorded by the tracker?";
$GLOBALS['strBanners'] = "배너";
$GLOBALS['strCampaigns'] = "캠페인";
$GLOBALS['strCampaignID'] = "캠페인 ID";
$GLOBALS['strCampaignName'] = "캠페인 이름";
$GLOBALS['strCountry'] = "국가";
$GLOBALS['strStatsAction'] = "작업";
$GLOBALS['strWindowDelay'] = "윈도우 지연";
$GLOBALS['strStatsVariables'] = "변수";

// Finance
$GLOBALS['strFinanceCPM'] = "노출광고";
$GLOBALS['strFinanceCPC'] = "클릭광고";
$GLOBALS['strFinanceCPA'] = "CPA";
$GLOBALS['strFinanceMT'] = "Tenancy";
$GLOBALS['strFinanceCTR'] = "클릭율";
$GLOBALS['strFinanceCR'] = "CR";

// Time and date related
$GLOBALS['strDate'] = "날짜";
$GLOBALS['strDay'] = "일";
$GLOBALS['strDays'] = "일간";
$GLOBALS['strWeek'] = "주";
$GLOBALS['strWeeks'] = "주간";
$GLOBALS['strSingleMonth'] = "월";
$GLOBALS['strMonths'] = "월간";
$GLOBALS['strDayOfWeek'] = "Day of week";


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
$GLOBALS['strDayShortCuts'][0] = '일';
$GLOBALS['strDayShortCuts'][1] = '월';
$GLOBALS['strDayShortCuts'][2] = 'Tu';
$GLOBALS['strDayShortCuts'][3] = 'We';
$GLOBALS['strDayShortCuts'][4] = 'Th';
$GLOBALS['strDayShortCuts'][5] = 'Fr';
$GLOBALS['strDayShortCuts'][6] = 'Sa';

$GLOBALS['strHour'] = "시";
$GLOBALS['strSeconds'] = "초";
$GLOBALS['strMinutes'] = "분";
$GLOBALS['strHours'] = "시간";

// Advertiser
$GLOBALS['strClient'] = "광고주";
$GLOBALS['strClients'] = "광고주";
$GLOBALS['strClientsAndCampaigns'] = "광고주 & 캠페인";
$GLOBALS['strAddClient'] = "새 광고주 추가";
$GLOBALS['strClientProperties'] = "광고주 속성";
$GLOBALS['strClientHistory'] = "Advertiser Statistics";
$GLOBALS['strNoClients'] = "현재 등록된 광고주가 없습니다. 캠페인을 만들려면 <a href='advertiser-edit.php'> 새 광고주 추가</a>를 하십시오.";
$GLOBALS['strConfirmDeleteClient'] = "해당 광고주를 삭제합니까?";
$GLOBALS['strConfirmDeleteClients'] = "해당 광고주를 삭제합니까?";
$GLOBALS['strHideInactive'] = "Hide inactive";
$GLOBALS['strInactiveAdvertisersHidden'] = "광고주가 숨겨져 있습니다.";
$GLOBALS['strAdvertiserSignup'] = "Advertiser Sign Up";
$GLOBALS['strAdvertiserCampaigns'] = "광고주의 캠페인";

// Advertisers properties
$GLOBALS['strContact'] = "연락처";
$GLOBALS['strContactName'] = "연락처 이름";
$GLOBALS['strEMail'] = "이메일";
$GLOBALS['strSendAdvertisingReport'] = "광고 보고서를 이메일로 수신합니다.";
$GLOBALS['strNoDaysBetweenReports'] = "광고보고서 발송간격";
$GLOBALS['strSendDeactivationWarning'] = "캠페인이 자동으로 활성화/비활성화 되면 이메일로 알립니다.";
$GLOBALS['strAllowClientModifyBanner'] = "사용자가 배너를 수정하는 것을 허용합니다.";
$GLOBALS['strAllowClientDisableBanner'] = "사용자가 배너를 비활성화 하는것을 허용합니다.";
$GLOBALS['strAllowClientActivateBanner'] = "사용자가 배너를 활성화 하는것을 허용합니다.";
$GLOBALS['strAllowCreateAccounts'] = "Allow this user to manage this account's users";
$GLOBALS['strAdvertiserLimitation'] = "Display only one banner from this advertiser on a web page";
$GLOBALS['strAllowAuditTrailAccess'] = "Allow this user to access the audit trail";
$GLOBALS['strAllowDeleteItems'] = "Allow this user to delete items";

// Campaign
$GLOBALS['strCampaign'] = "캠페인";
$GLOBALS['strCampaigns'] = "캠페인";
$GLOBALS['strAddCampaign'] = "새 캠페인 추가";
$GLOBALS['strAddCampaign_Key'] = "새 캠페인 추가 (<u>n</u>)";
$GLOBALS['strCampaignForAdvertiser'] = "for advertiser";
$GLOBALS['strLinkedCampaigns'] = "Linked Campaigns";
$GLOBALS['strCampaignProperties'] = "캠페인 정보";
$GLOBALS['strCampaignOverview'] = "캠페인 요약";
$GLOBALS['strCampaignHistory'] = "Campaign Statistics";
$GLOBALS['strNoCampaigns'] = "해당 광고주에 대한 캠페인이 존재하지 않습니다.";
$GLOBALS['strNoCampaignsAddAdvertiser'] = "There are currently no campaigns defined, because there are no advertisers. To create a campaign, <a href='advertiser-edit.php'>add a new advertiser</a> first.";
$GLOBALS['strConfirmDeleteCampaign'] = "정말로 캠페인을 삭제 하시겠습니까?";
$GLOBALS['strConfirmDeleteCampaigns'] = "정말로 선택된 캠페인을 삭제 하시겠습니까?";
$GLOBALS['strShowParentAdvertisers'] = "Show parent advertisers";
$GLOBALS['strHideParentAdvertisers'] = "Hide parent advertisers";
$GLOBALS['strHideInactiveCampaigns'] = "사용 가능한 캠페인 숨김";
$GLOBALS['strInactiveCampaignsHidden'] = "활성 가능한 캠페인이 숨겨져 있습니다.";
$GLOBALS['strPriorityInformation'] = "Priority in relation to other campaigns";
$GLOBALS['strECPMInformation'] = "eCPM prioritization";
$GLOBALS['strRemnantEcpmDescription'] = "eCPM is automatically calculated based on this campaign's performance.<br />It will be used to prioritise Remnant campaigns relative to each other.";
$GLOBALS['strEcpmMinImpsDescription'] = "Set this to your desired minium basis on which to calculate this campaign's eCPM.";
$GLOBALS['strHiddenCampaign'] = "캠페인";
$GLOBALS['strHiddenAd'] = "Advertisement";
$GLOBALS['strHiddenAdvertiser'] = "광고주";
$GLOBALS['strHiddenTracker'] = "Tracker";
$GLOBALS['strHiddenWebsite'] = "웹사이트";
$GLOBALS['strHiddenZone'] = "광고영역";
$GLOBALS['strCampaignDelivery'] = "Campaign delivery";
$GLOBALS['strCompanionPositioning'] = "Companion positioning";
$GLOBALS['strSelectUnselectAll'] = "Select / Unselect All";
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
$GLOBALS['strLinked'] = "연결됨";
$GLOBALS['strAvailable'] = "Available";
$GLOBALS['strShowing'] = "Showing";
$GLOBALS['strEditZone'] = "Edit zone";
$GLOBALS['strEditWebsite'] = "Edit website";


// Campaign properties
$GLOBALS['strDontExpire'] = "캠페인을 만료하지 않습니다.";
$GLOBALS['strActivateNow'] = "해당 캠페인을 지금 활성화 합니다.";
$GLOBALS['strSetSpecificDate'] = "Set specific date";
$GLOBALS['strLow'] = "낮음";
$GLOBALS['strHigh'] = "높음";
$GLOBALS['strExpirationDate'] = "만료일자";
$GLOBALS['strExpirationDateComment'] = "Campaign will finish at the end of this day";
$GLOBALS['strActivationDate'] = "시작일자";
$GLOBALS['strActivationDateComment'] = "Campaign will commence at the start of this day";
$GLOBALS['strImpressionsRemaining'] = "Impressions Remaining";
$GLOBALS['strClicksRemaining'] = "Clicks Remaining";
$GLOBALS['strConversionsRemaining'] = "Conversions Remaining";
$GLOBALS['strImpressionsBooked'] = "Impressions Booked";
$GLOBALS['strClicksBooked'] = "Clicks Booked";
$GLOBALS['strConversionsBooked'] = "Conversions Booked";
$GLOBALS['strCampaignWeight'] = "캠페인 가중치 설정";
$GLOBALS['strAnonymous'] = "Hide the advertiser and websites of this campaign.";
$GLOBALS['strTargetPerDay'] = "일별 제한";
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
$GLOBALS['strCampaignStatusPending'] = "Pending";
$GLOBALS['strCampaignStatusInactive'] = "사용가능";
$GLOBALS['strCampaignStatusRunning'] = "Running";
$GLOBALS['strCampaignStatusPaused'] = "Paused";
$GLOBALS['strCampaignStatusAwaiting'] = "Awaiting";
$GLOBALS['strCampaignStatusExpired'] = "Completed";
$GLOBALS['strCampaignStatusApproval'] = "Awaiting approval »";
$GLOBALS['strCampaignStatusRejected'] = "Rejected";
$GLOBALS['strCampaignStatusAdded'] = "Added";
$GLOBALS['strCampaignStatusStarted'] = "Started";
$GLOBALS['strCampaignStatusRestarted'] = "Restarted";
$GLOBALS['strCampaignStatusDeleted'] = "삭제";
$GLOBALS['strCampaignType'] = "캠페인 유형";
$GLOBALS['strType'] = "Type";
$GLOBALS['strContract'] = "연락처";
$GLOBALS['strOverride'] = "Override";
$GLOBALS['strOverrideInfo'] = "Override campaigns are a special campaign type specifically to
    override (i.e. take priority over) Remnant and Contract campaigns. Override campaigns are generally used with
    specific targeting and/or capping rules to ensure that the campaign banners are always displayed in certain
    locations, to certain users, and perhaps a certain number of times, as part of a specific promotion. (This campaign
    type was previously known as 'Contract (Exclusive)'.)";
$GLOBALS['strStandardContract'] = "연락처";
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
$GLOBALS['strTracker'] = "Tracker";
$GLOBALS['strTrackers'] = "Trackers";
$GLOBALS['strTrackerPreferences'] = "Tracker Preferences";
$GLOBALS['strAddTracker'] = "Add new tracker";
$GLOBALS['strTrackerForAdvertiser'] = "for advertiser";
$GLOBALS['strNoTrackers'] = "There are currently no trackers defined for this advertiser";
$GLOBALS['strConfirmDeleteTrackers'] = "정말 선택된 추적내역을 삭제 하시겠습니까?";
$GLOBALS['strConfirmDeleteTracker'] = "정말 추적내역을 삭제 하시겠습니까?";
$GLOBALS['strTrackerProperties'] = "추적 속성";
$GLOBALS['strDefaultStatus'] = "Default Status";
$GLOBALS['strStatus'] = "Status";
$GLOBALS['strLinkedTrackers'] = "Linked Trackers";
$GLOBALS['strTrackerInformation'] = "Tracker Information";
$GLOBALS['strConversionWindow'] = "Conversion window";
$GLOBALS['strUniqueWindow'] = "Unique window";
$GLOBALS['strClick'] = "Click";
$GLOBALS['strView'] = "View";
$GLOBALS['strArrival'] = "Arrival";
$GLOBALS['strManual'] = "사용방법";
$GLOBALS['strImpression'] = "Impression";
$GLOBALS['strConversionType'] = "Conversion Type";
$GLOBALS['strLinkCampaignsByDefault'] = "Link newly created campaigns by default";
$GLOBALS['strBackToTrackers'] = "Back to trackers";
$GLOBALS['strIPAddress'] = "IP Address";

// Banners (General)
$GLOBALS['strBanner'] = "배너";
$GLOBALS['strBanners'] = "배너";
$GLOBALS['strAddBanner'] = "새 배너 추가";
$GLOBALS['strAddBanner_Key'] = "새 배너 추가(<u>n</u>)";
$GLOBALS['strBannerToCampaign'] = "to campaign";
$GLOBALS['strShowBanner'] = "배너 보기";
$GLOBALS['strBannerProperties'] = "배너 속성";
$GLOBALS['strBannerHistory'] = "Banner Statistics";
$GLOBALS['strNoBanners'] = "이 캠페인에 등록된 배너가 없습니다.";
$GLOBALS['strNoBannersAddCampaign'] = "There are currently no banners defined, because there are no campaigns. To create a banner, <a href='campaign-edit.php?clientid=%s'>add a new campaign</a> first.";
$GLOBALS['strNoBannersAddAdvertiser'] = "There are currently no banners defined, because there are no advertisers. To create a banner, <a href='advertiser-edit.php'>add a new advertiser</a> first.";
$GLOBALS['strConfirmDeleteBanner'] = "해당 배너를 삭제하시면 통계내역도 함께 삭제됩니다.
정말 이 배너를 삭제 하시겠습니까?";
$GLOBALS['strConfirmDeleteBanners'] = "해당 배너를 삭제하시면 통계내역도 함께 삭제됩니다.
정말 선택된 배너를 삭제 하시겠습니까?";
$GLOBALS['strShowParentCampaigns'] = "상위 캠페인 표시";
$GLOBALS['strHideParentCampaigns'] = "상위 캠페인 숨김";
$GLOBALS['strHideInactiveBanners'] = "비활성화 된 배너 숨김";
$GLOBALS['strInactiveBannersHidden'] = "비활성화 된 배너가 숨겨져 있습니다.";
$GLOBALS['strWarningMissing'] = "Warning, possibly missing ";
$GLOBALS['strWarningMissingClosing'] = " closing tag '>'";
$GLOBALS['strWarningMissingOpening'] = " opening tag '<'";
$GLOBALS['strSubmitAnyway'] = "Submit Anyway";
$GLOBALS['strBannersOfCampaign'] = "in"; //this is added between page name and campaign name eg. 'Banners in coca cola campaign'

// Banner Preferences
$GLOBALS['strBannerPreferences'] = "Banner Preferences";
$GLOBALS['strCampaignPreferences'] = "Campaign Preferences";
$GLOBALS['strDefaultBanners'] = "Default Banners";
$GLOBALS['strDefaultBannerUrl'] = "Default Image URL";
$GLOBALS['strDefaultBannerDestination'] = "Default Destination URL";
$GLOBALS['strAllowedBannerTypes'] = "Allowed Banner Types";
$GLOBALS['strTypeSqlAllow'] = "Allow SQL Local Banners";
$GLOBALS['strTypeWebAllow'] = "Allow Webserver Local Banners";
$GLOBALS['strTypeUrlAllow'] = "Allow External Banners";
$GLOBALS['strTypeHtmlAllow'] = "Allow HTML Banners";
$GLOBALS['strTypeTxtAllow'] = "Allow Text Ads";

// Banner (Properties)
$GLOBALS['strChooseBanner'] = "배너 형태를 선택해 주세요.";
$GLOBALS['strMySQLBanner'] = "로컬 배너 (SQL - DB 저장방식)";
$GLOBALS['strWebBanner'] = "로컬 배너 (웹서버 - 웹 저장 방식)";
$GLOBALS['strURLBanner'] = "외부 배너";
$GLOBALS['strHTMLBanner'] = "HTML 배너 생성";
$GLOBALS['strTextBanner'] = "텍스트 광고 생성";
$GLOBALS['strAlterHTML'] = "Alter HTML to enable click tracking for:";
$GLOBALS['strIframeFriendly'] = "This banner can be safely displayed inside an iframe (e.g. is not expandable)";
$GLOBALS['strUploadOrKeep'] = "현재 �?�미지를 �?�용하거나<br> 다른 �?�미지를 업로드할<br> 수 있습니다.";
$GLOBALS['strNewBannerFile'] = "배너로 사용 할 이미지를 선택해 주세요.";
$GLOBALS['strNewBannerFileAlt'] = "Select a backup image you <br />want to use in case browsers<br />don't support rich media<br /><br />";
$GLOBALS['strNewBannerURL'] = "이미지 URL(incl. http://)";
$GLOBALS['strURL'] = "대상 URL(incl. http://)";
$GLOBALS['strKeyword'] = "키워드";
$GLOBALS['strTextBelow'] = "이미지 하단 텍스트";
$GLOBALS['strWeight'] = "가중치";
$GLOBALS['strAlt'] = "Alt 텍스트";
$GLOBALS['strStatusText'] = "상태표시줄 텍스트";
$GLOBALS['strCampaignsWeight'] = "Campaign's Weight";
$GLOBALS['strBannerWeight'] = "배너 가중치";
$GLOBALS['strBannersWeight'] = "Banner's Weight";
$GLOBALS['strAdserverTypeGeneric'] = "Generic HTML Banner";
$GLOBALS['strDoNotAlterHtml'] = "Do not alter HTML";
$GLOBALS['strGenericOutputAdServer'] = "Generic";
$GLOBALS['strBackToBanners'] = "Back to banners";
$GLOBALS['strUseWyswygHtmlEditor'] = "Use WYSIWYG HTML Editor";
$GLOBALS['strChangeDefault'] = "Change default";

// Banner (advanced)
$GLOBALS['strBannerPrependHTML'] = "Always prepend the following HTML code to this banner";
$GLOBALS['strBannerAppendHTML'] = "Always append the following HTML code to this banner";

// Display Delviery Rules
$GLOBALS['strModifyBannerAcl'] = "전송 옵션";
$GLOBALS['strACL'] = "전송 옵션";
$GLOBALS['strACLAdd'] = "Add delivery rule";
$GLOBALS['strApplyLimitationsTo'] = "Apply delivery rules to";
$GLOBALS['strAllBannersInCampaign'] = "All banners in this campaign";
$GLOBALS['strRemoveAllLimitations'] = "Remove all delivery rules";
$GLOBALS['strEqualTo'] = "같을 경우";
$GLOBALS['strDifferentFrom'] = "다른 경우";
$GLOBALS['strLaterThan'] = "is later than";
$GLOBALS['strLaterThanOrEqual'] = "is later than or equal to";
$GLOBALS['strEarlierThan'] = "is earlier than";
$GLOBALS['strEarlierThanOrEqual'] = "is earlier than or equal to";
$GLOBALS['strContains'] = "contains";
$GLOBALS['strNotContains'] = "doesn't contain";
$GLOBALS['strGreaterThan'] = "is greater than";
$GLOBALS['strLessThan'] = "is less than";
$GLOBALS['strGreaterOrEqualTo'] = "is greater or equal to";
$GLOBALS['strLessOrEqualTo'] = "is less or equal to";
$GLOBALS['strAND'] = "그리고";                          // logical operator
$GLOBALS['strOR'] = "또는";                         // logical operator
$GLOBALS['strOnlyDisplayWhen'] = "다음 조건에서만 배너를 표시합니다.:";
$GLOBALS['strWeekDays'] = "주간";
$GLOBALS['strTime'] = "Time";
$GLOBALS['strDomain'] = "도메인";
$GLOBALS['strSource'] = "소스";
$GLOBALS['strBrowser'] = "브라우저";
$GLOBALS['strOS'] = "OS";
$GLOBALS['strDeliveryLimitations'] = "Delivery Rules";

$GLOBALS['strDeliveryCappingReset'] = "Reset view counters after:";
$GLOBALS['strDeliveryCappingTotal'] = "in total";
$GLOBALS['strDeliveryCappingSession'] = "per session";

if (!isset($GLOBALS['strCappingBanner'])) {
    $GLOBALS['strCappingBanner'] = array();
}
$GLOBALS['strCappingBanner']['title'] = "Delivery capping per visitor";
$GLOBALS['strCappingBanner']['limit'] = "Limit banner views to:";

if (!isset($GLOBALS['strCappingCampaign'])) {
    $GLOBALS['strCappingCampaign'] = array();
}
$GLOBALS['strCappingCampaign']['title'] = "Delivery capping per visitor";
$GLOBALS['strCappingCampaign']['limit'] = "Limit campaign views to:";

if (!isset($GLOBALS['strCappingZone'])) {
    $GLOBALS['strCappingZone'] = array();
}
$GLOBALS['strCappingZone']['title'] = "Delivery capping per visitor";
$GLOBALS['strCappingZone']['limit'] = "Limit zone views to:";

// Website
$GLOBALS['strAffiliate'] = "웹사이트";
$GLOBALS['strAffiliates'] = "웹사이트";
$GLOBALS['strAffiliatesAndZones'] = "웹사이트 & 광고영역";
$GLOBALS['strAddNewAffiliate'] = "새 웹사이트 추가";
$GLOBALS['strAffiliateProperties'] = "웹사이트 속성";
$GLOBALS['strAffiliateHistory'] = "Website Statistics";
$GLOBALS['strNoAffiliates'] = "현재 웹사이트가 존재하지 않습니다. 웹사이트 추가 후 광고영역을 생성해 주세요.";
$GLOBALS['strConfirmDeleteAffiliate'] = "해당 웹사이트를 정말로 삭제 하시겠습니까?";
$GLOBALS['strConfirmDeleteAffiliates'] = "선택된 해당 웹사이트를 정말로 삭제 하시겠습니까?";
$GLOBALS['strInactiveAffiliatesHidden'] = "배너가 숨겨져 있습니다.";
$GLOBALS['strShowParentAffiliates'] = "Show parent websites";
$GLOBALS['strHideParentAffiliates'] = "Hide parent websites";

// Website (properties)
$GLOBALS['strWebsite'] = "웹사이트";
$GLOBALS['strWebsiteURL'] = "Website URL";
$GLOBALS['strAllowAffiliateModifyZones'] = "사용자가 광고영역을 수정하는 것을 허용합니다.";
$GLOBALS['strAllowAffiliateLinkBanners'] = "사용자가 광고영역과 배너를 연결할 수 있도록 허용 하시겠습니까?";
$GLOBALS['strAllowAffiliateAddZone'] = "사용자가 새로운 광고영역을 생성할 수 있도록 허용 하시겠습니까?";
$GLOBALS['strAllowAffiliateDeleteZone'] = "사용자가 광고영역을 삭제 할 수 있도록 허용 하시겠습니까?";
$GLOBALS['strAllowAffiliateGenerateCode'] = "Allow this user to generate invocation code";

// Website (properties - payment information)
$GLOBALS['strPostcode'] = "Postcode";
$GLOBALS['strCountry'] = "국가";

// Website (properties - other information)
$GLOBALS['strWebsiteZones'] = "광고게시 웹사이트 영역";

// Zone
$GLOBALS['strZone'] = "광고영역";
$GLOBALS['strZones'] = "영역";
$GLOBALS['strAddNewZone'] = "새 광고영역 추가";
$GLOBALS['strAddNewZone_Key'] = "새 광고영역 추가 (<u>n</u>)";
$GLOBALS['strZoneToWebsite'] = "to website";
$GLOBALS['strLinkedZones'] = "연결된 광고영역";
$GLOBALS['strAvailableZones'] = "Available Zones";
$GLOBALS['strLinkingNotSuccess'] = "Linking not successful, please try again";
$GLOBALS['strZoneProperties'] = "광고영역 속성";
$GLOBALS['strZoneHistory'] = "광고영역 내역";
$GLOBALS['strNoZones'] = "현재 웹사이트에 광고영역이 존재하지 않습니다.";
$GLOBALS['strNoZonesAddWebsite'] = "There are currently no zones defined, because there are no websites. To create a zone, <a href='affiliate-edit.php'>add a new website</a> first.";
$GLOBALS['strConfirmDeleteZone'] = "정말로 광고영역을 삭제 하시겠습니까?";
$GLOBALS['strConfirmDeleteZones'] = "정말로 선택하신 광고영역을 삭제 하시겠습니까?";
$GLOBALS['strConfirmDeleteZoneLinkActive'] = "There are campaigns still linked to this zone, if you delete it these will not be able to run and you will not be paid for them.";
$GLOBALS['strZoneType'] = "광고영역 종류";
$GLOBALS['strBannerButtonRectangle'] = "배너, 버튼형 혹은 사각형";
$GLOBALS['strInterstitial'] = "플로팅 DHTML";
$GLOBALS['strPopup'] = "팝업";
$GLOBALS['strTextAdZone'] = "텍스트 광고";
$GLOBALS['strEmailAdZone'] = "Email/Newsletter zone";
$GLOBALS['strZoneVideoInstream'] = "Inline Video ad";
$GLOBALS['strZoneVideoOverlay'] = "Overlay Video ad";
$GLOBALS['strShowMatchingBanners'] = "일치하는 배너보기";
$GLOBALS['strHideMatchingBanners'] = "일치하는 배너 숨기기";
$GLOBALS['strBannerLinkedAds'] = "Banners linked to the zone";
$GLOBALS['strCampaignLinkedAds'] = "Campaigns linked to the zone";
$GLOBALS['strInactiveZonesHidden'] = "배너가 숨겨져 있습니다.";
$GLOBALS['strWarnChangeZoneType'] = "Changing the zone type to text or email will unlink all banners/campaigns due to restrictions of these zone types
                                                <ul>
                                                    <li>Text zones can only be linked to text ads</li>
                                                    <li>Email zone campaigns can only have one active banner at a time</li>
                                                </ul>";
$GLOBALS['strWarnChangeZoneSize'] = 'Changing the zone size will unlink any banners that are not the new size, and will add any banners from linked campaigns which are the new size';
$GLOBALS['strWarnChangeBannerSize'] = 'Changing the banner size will unlink this banner from any zones that are not the new size, and if this banner\'s <strong>campaign</strong> is linked to a zone of the new size, this banner will be automatically linked';
$GLOBALS['strWarnBannerReadonly'] = 'This banner is read-only because an extension has been disabled. Contact your system administrator for more information.';
$GLOBALS['strZonesOfWebsite'] = 'in'; //this is added between page name and website name eg. 'Zones in www.example.com'
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
$GLOBALS['strAdvanced'] = "고급 설정";
$GLOBALS['strChainSettings'] = "연결 설정";
$GLOBALS['strZoneNoDelivery'] = "만약 해당영역에 배너가 존재하지 않으면, 정상적으로 광고전달이 되지 않습니다. 다시 시도해 주세요.";
$GLOBALS['strZoneStopDelivery'] = "해당 광고영역에 배너를 중지합니다.";
$GLOBALS['strZoneOtherZone'] = "선택된 광고영역에 표시합니다.";
$GLOBALS['strZoneAppend'] = "�?� �?역�? 연결�?� 배너�? �?업�?�나 격�? 배너 호출 코드를 항�? 추가합니다.";
$GLOBALS['strAppendSettings'] = "배너 첨부 설정";
$GLOBALS['strZonePrependHTML'] = "�?� �?역�? 표시�?� �?스트 광고 앞�? HTML 코드를 추가합니다.";
$GLOBALS['strZoneAppendNoBanner'] = "Prepend/Append even if no banner delivered";
$GLOBALS['strZoneAppendHTMLCode'] = "HTML code";
$GLOBALS['strZoneAppendZoneSelection'] = "Popup or interstitial";

// Zone probability
$GLOBALS['strZoneProbListChain'] = "선�?한 �?역�? 연결�?� 배너는 모�? �?(null) 우선순위입니다. �?역 연결�?� 다�?�과 같습니다.:";
$GLOBALS['strZoneProbNullPri'] = "�?� �?역�? 연결�?� 배너는 모�? �?(null) 우선순위입니다.";
$GLOBALS['strZoneProbListChainLoop'] = "Following the zone chain would cause a circular loop. Delivery for this zone is halted.";

// Linked banners/campaigns/trackers
$GLOBALS['strSelectZoneType'] = "이 광고영역에 연결한 배너를 선택해 주세요.";
$GLOBALS['strLinkedBanners'] = "Link individual banners";
$GLOBALS['strCampaignDefaults'] = "Link banners by parent campaign";
$GLOBALS['strLinkedCategories'] = "Link banners by category";
$GLOBALS['strWithXBanners'] = "%d banner(s)";
$GLOBALS['strRawQueryString'] = "키워드";
$GLOBALS['strIncludedBanners'] = "연결 된 배너";
$GLOBALS['strMatchingBanners'] = "일치하는 배너 수  {count}";
$GLOBALS['strNoCampaignsToLink'] = "현재 �?� �?역�? 연결할 �?페�?��?� 없습니다.";
$GLOBALS['strNoTrackersToLink'] = "현재 �?� �?역�? 연결할 �?페�?��?� 없습니다.";
$GLOBALS['strNoZonesToLinkToCampaign'] = "현재 �?� �?역�? 연결�?� �?페�?��?� 없습니다.";
$GLOBALS['strSelectBannerToLink'] = "�?� �?역�? 연결할 배너를 선�?하세요:";
$GLOBALS['strSelectCampaignToLink'] = "�?� �?역�? 연결할 캠페�?� 선�?합니다:";
$GLOBALS['strSelectAdvertiser'] = "광고주 선택";
$GLOBALS['strSelectPlacement'] = "Select Campaign";
$GLOBALS['strSelectAd'] = "배너 선택";
$GLOBALS['strSelectPublisher'] = "웹사이트 선택";
$GLOBALS['strSelectZone'] = "광고영역 선택";
$GLOBALS['strStatusPending'] = "Pending";
$GLOBALS['strStatusApproved'] = "Approved";
$GLOBALS['strStatusDisapproved'] = "Disapproved";
$GLOBALS['strStatusDuplicate'] = "복제";
$GLOBALS['strStatusOnHold'] = "On Hold";
$GLOBALS['strStatusIgnore'] = "Ignore";
$GLOBALS['strConnectionType'] = "Type";
$GLOBALS['strConnTypeSale'] = "Sale";
$GLOBALS['strConnTypeLead'] = "Lead";
$GLOBALS['strConnTypeSignUp'] = "Signup";
$GLOBALS['strShortcutEditStatuses'] = "Edit statuses";
$GLOBALS['strShortcutShowStatuses'] = "Show statuses";

// Statistics
$GLOBALS['strStats'] = "통계";
$GLOBALS['strNoStats'] = "현재 통계내역이 없습니다.";
$GLOBALS['strNoStatsForPeriod'] = "There are currently no statistics available for the period %s to %s";
$GLOBALS['strGlobalHistory'] = "Global Statistics";
$GLOBALS['strDailyHistory'] = "Daily Statistics";
$GLOBALS['strDailyStats'] = "Daily Statistics";
$GLOBALS['strWeeklyHistory'] = "Weekly Statistics";
$GLOBALS['strMonthlyHistory'] = "Monthly Statistics";
$GLOBALS['strTotalThisPeriod'] = "기간 합계";
$GLOBALS['strPublisherDistribution'] = "Website Distribution";
$GLOBALS['strCampaignDistribution'] = "Campaign Distribution";
$GLOBALS['strViewBreakdown'] = "View by";
$GLOBALS['strBreakdownByDay'] = "일";
$GLOBALS['strBreakdownByWeek'] = "주";
$GLOBALS['strBreakdownByMonth'] = "월";
$GLOBALS['strBreakdownByDow'] = "Day of week";
$GLOBALS['strBreakdownByHour'] = "시";
$GLOBALS['strItemsPerPage'] = "Items per page";
$GLOBALS['strDistributionHistoryCampaign'] = "Distribution Statistics (Campaign)";
$GLOBALS['strDistributionHistoryBanner'] = "Distribution Statistics (Banner)";
$GLOBALS['strDistributionHistoryWebsite'] = "Distribution Statistics (Website)";
$GLOBALS['strDistributionHistoryZone'] = "Distribution Statistics (Zone)";
$GLOBALS['strShowGraphOfStatistics'] = "Show <u>G</u>raph of Statistics";
$GLOBALS['strExportStatisticsToExcel'] = "<u>E</u>xport Statistics to Excel";
$GLOBALS['strGDnotEnabled'] = "You must have GD enabled in PHP to display graphs. <br />Please see <a href='http://www.php.net/gd' target='_blank'>http://www.php.net/gd</a> for more information, including how to install GD on your server.";
$GLOBALS['strStatsArea'] = "지역";

// Expiration
$GLOBALS['strNoExpiration'] = "기간제한 없음";
$GLOBALS['strEstimated'] = "예상되는 만료일";
$GLOBALS['strNoExpirationEstimation'] = "No expiration estimated yet";
$GLOBALS['strDaysAgo'] = "몇일 전";
$GLOBALS['strCampaignStop'] = "캠페인 중지";

// Reports
$GLOBALS['strAdvancedReports'] = "Advanced Reports";
$GLOBALS['strStartDate'] = "시작일자";
$GLOBALS['strEndDate'] = "종료일자";
$GLOBALS['strPeriod'] = "Period";
$GLOBALS['strLimitations'] = "Delivery Rules";
$GLOBALS['strWorksheets'] = "Worksheets";

// Admin_UI_Fields
$GLOBALS['strAllAdvertisers'] = "모든 광고주";
$GLOBALS['strAnonAdvertisers'] = "Anonymous advertisers";
$GLOBALS['strAllPublishers'] = "All websites";
$GLOBALS['strAnonPublishers'] = "Anonymous websites";
$GLOBALS['strAllAvailZones'] = "All available zones";

// Userlog
$GLOBALS['strUserLog'] = "사용자 로그";
$GLOBALS['strUserLogDetails'] = "사용자 로그 상세내역";
$GLOBALS['strDeleteLog'] = "로그 삭제";
$GLOBALS['strAction'] = "작업";
$GLOBALS['strNoActionsLogged'] = "작업 내역이 없습니다.";

// Code generation
$GLOBALS['strGenerateBannercode'] = "직접 선택";
$GLOBALS['strChooseInvocationType'] = "배너 유형을 선택해 주십시오.";
$GLOBALS['strGenerate'] = "생성하기";
$GLOBALS['strParameters'] = "카테고리 설정";
$GLOBALS['strFrameSize'] = "프레임 크기";
$GLOBALS['strBannercode'] = "배너코드";
$GLOBALS['strTrackercode'] = "Trackercode";
$GLOBALS['strBackToTheList'] = "Go back to report list";
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
$GLOBALS['strNoMatchesFound'] = "검색 결과가 없습니다.";
$GLOBALS['strErrorOccurred'] = "오류가 발생했습니다.";
$GLOBALS['strErrorDBPlain'] = "An error occurred while accessing the database";
$GLOBALS['strErrorDBSerious'] = "A serious problem with the database has been detected";
$GLOBALS['strErrorDBNoDataPlain'] = "Due to a problem with the database {$PRODUCT_NAME} couldn't retrieve or store data. ";
$GLOBALS['strErrorDBNoDataSerious'] = "Due to a serious problem with the database, {$PRODUCT_NAME} couldn't retrieve data";
$GLOBALS['strErrorDBCorrupt'] = "The database table is probably corrupt and needs to be repaired. For more information about repairing corrupted tables please read the chapter <i>Troubleshooting</i> of the <i>Administrator guide</i>.";
$GLOBALS['strErrorDBContact'] = "Please contact the administrator of this server and notify him or her of the problem.";
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
$GLOBALS['strUnableToChangeZone'] = "Cannot apply this change because:";
$GLOBALS['strDatesConflict'] = "Dates of the campaign you are trying to link overlap with the dates of a campaign already linked ";
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
$GLOBALS['strSirMadam'] = "Sir/Madam";
$GLOBALS['strMailSubject'] = "광고주 보고서";
$GLOBALS['strMailHeader'] = "Dear {contact},";
$GLOBALS['strMailBannerStats'] = "{clientname}님!  배너 통계는 다음과 같습니다.";
$GLOBALS['strMailBannerActivatedSubject'] = "캠페인 {id} 활성화";
$GLOBALS['strMailBannerDeactivatedSubject'] = "캠페인 {id} 비활성화";
$GLOBALS['strMailBannerActivated'] = "Your campaign shown below has been activated because
the campaign activation date has been reached.";
$GLOBALS['strMailBannerDeactivated'] = "Your campaign shown below has been deactivated because";
$GLOBALS['strMailFooter'] = "Regards,
   {adminfullname}";
$GLOBALS['strClientDeactivated'] = "�?� 캠페�?��?� 현재 다�?�과 같�?� �?�유로 운�?하지 않습니다.";
$GLOBALS['strBeforeActivate'] = "아직 광고 활성화 기간이 아닙니다.";
$GLOBALS['strAfterExpire'] = "만기일자가 다가옵니다.";
$GLOBALS['strNoMoreImpressions'] = "there are no Impressions remaining";
$GLOBALS['strNoMoreClicks'] = "남아있는 클릭수가 없습니다.";
$GLOBALS['strNoMoreConversions'] = "남아있는 광고상품이 없습니다.";
$GLOBALS['strWeightIsNull'] = "its weight is set to zero";
$GLOBALS['strRevenueIsNull'] = "its revenue is set to zero";
$GLOBALS['strTargetIsNull'] = "its limit per day is set to zero - you need to either specify both an end date and a limit or set Limit per day value";
$GLOBALS['strNoViewLoggedInInterval'] = "�?� 기간 �?�안�?� 보고서�? 기�?�?� AdViews가 없습니다.";
$GLOBALS['strNoClickLoggedInInterval'] = "�?� 기간 �?�안�?� 보고서�? 기�?�?� AdClicks�?� 없습니다.";
$GLOBALS['strNoConversionLoggedInInterval'] = "�?� 기간 �?�안�?� 보고서�? 기�?�?� AdViews가 없습니다.";
$GLOBALS['strMailReportPeriod'] = "�?� 보고서�?는 {startdate}�?서 {enddate}까지�?� 통계를 �?�함하고 있습니다.";
$GLOBALS['strMailReportPeriodAll'] = "�?� 보고서�?는 {enddate}까지�?� 통계를 �?�함하고 있습니다.";
$GLOBALS['strNoStatsForCampaign'] = "�?� 캠페�?��?서 �?�용할 수 있는 통계가 없습니다.";
$GLOBALS['strImpendingCampaignExpiry'] = "Impending campaign expiration";
$GLOBALS['strYourCampaign'] = "Your campaign";
$GLOBALS['strTheCampiaignBelongingTo'] = "The campaign belonging to";
$GLOBALS['strImpendingCampaignExpiryDateBody'] = "{clientname} shown below is due to end on {date}.";
$GLOBALS['strImpendingCampaignExpiryImpsBody'] = "{clientname} shown below has less than {limit} impressions remaining.";
$GLOBALS['strImpendingCampaignExpiryBody'] = "As a result, the campaign will soon be automatically disabled, and the
following banners in the campaign will also be disabled:";

// Priority
$GLOBALS['strPriority'] = "우선순위";
$GLOBALS['strSourceEdit'] = "Edit Sources";

// Preferences
$GLOBALS['strPreferences'] = "환경설정";
$GLOBALS['strUserPreferences'] = "User Preferences";
$GLOBALS['strChangePassword'] = "Change Password";
$GLOBALS['strChangeEmail'] = "Change E-mail";
$GLOBALS['strCurrentPassword'] = "Current Password";
$GLOBALS['strChooseNewPassword'] = "Choose a new password";
$GLOBALS['strReenterNewPassword'] = "Re-enter new password";
$GLOBALS['strNameLanguage'] = "Name & Language";
$GLOBALS['strAccountPreferences'] = "Account Preferences";
$GLOBALS['strCampaignEmailReportsPreferences'] = "Campaign email Reports Preferences";
$GLOBALS['strTimezonePreferences'] = "Timezone Preferences";
$GLOBALS['strAdminEmailWarnings'] = "System administrator email Warnings";
$GLOBALS['strAgencyEmailWarnings'] = "Account email Warnings";
$GLOBALS['strAdveEmailWarnings'] = "Advertiser email Warnings";
$GLOBALS['strFullName'] = "전체 이름";
$GLOBALS['strEmailAddress'] = "이메일 주소";
$GLOBALS['strUserDetails'] = "사용자 상세정보";
$GLOBALS['strUserInterfacePreferences'] = "사용자 환경설정";
$GLOBALS['strPluginPreferences'] = "Plugin Preferences";
$GLOBALS['strColumnName'] = "Column Name";
$GLOBALS['strShowColumn'] = "Show Column";
$GLOBALS['strCustomColumnName'] = "Custom Column Name";
$GLOBALS['strColumnRank'] = "Column Rank";

// Long names
$GLOBALS['strRevenue'] = "Revenue";
$GLOBALS['strNumberOfItems'] = "Number of items";
$GLOBALS['strRevenueCPC'] = "Revenue CPC";
$GLOBALS['strERPM'] = "ERPM";
$GLOBALS['strERPC'] = "ERPC";
$GLOBALS['strERPS'] = "ERPS";
$GLOBALS['strEIPM'] = "EIPM";
$GLOBALS['strEIPC'] = "EIPC";
$GLOBALS['strEIPS'] = "EIPS";
$GLOBALS['strECPM'] = "eCPM";
$GLOBALS['strECPC'] = "ECPC";
$GLOBALS['strECPS'] = "ECPS";
$GLOBALS['strPendingConversions'] = "Pending conversions";
$GLOBALS['strImpressionSR'] = "Impression SR";
$GLOBALS['strClickSR'] = "Click SR";

// Short names
$GLOBALS['strRevenue_short'] = "Rev.";
$GLOBALS['strBasketValue_short'] = "BV";
$GLOBALS['strNumberOfItems_short'] = "Num. Items";
$GLOBALS['strRevenueCPC_short'] = "Rev. CPC";
$GLOBALS['strERPM_short'] = "ERPM";
$GLOBALS['strERPC_short'] = "ERPC";
$GLOBALS['strERPS_short'] = "ERPS";
$GLOBALS['strEIPM_short'] = "EIPM";
$GLOBALS['strEIPC_short'] = "EIPC";
$GLOBALS['strEIPS_short'] = "EIPS";
$GLOBALS['strECPM_short'] = "ECPM";
$GLOBALS['strECPC_short'] = "ECPC";
$GLOBALS['strECPS_short'] = "ECPS";
$GLOBALS['strID_short'] = "ID";
$GLOBALS['strRequests_short'] = "Req.";
$GLOBALS['strImpressions_short'] = "Impr.";
$GLOBALS['strClicks_short'] = "클릭수";
$GLOBALS['strCTR_short'] = "클릭율";
$GLOBALS['strConversions_short'] = "Conv.";
$GLOBALS['strPendingConversions_short'] = "Pend conv.";
$GLOBALS['strImpressionSR_short'] = "Impr. SR";
$GLOBALS['strClickSR_short'] = "Click SR";

// Global Settings
$GLOBALS['strConfiguration'] = "Configuration";
$GLOBALS['strGlobalSettings'] = "전체 설정";
$GLOBALS['strGeneralSettings'] = "일반 설정";
$GLOBALS['strMainSettings'] = "메인설정";
$GLOBALS['strPlugins'] = "Plugins";
$GLOBALS['strChooseSection'] = 'Choose Section';

// Product Updates
$GLOBALS['strProductUpdates'] = "제품 업데이트";
$GLOBALS['strViewPastUpdates'] = "Manage Past Updates and Backups";
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
$GLOBALS['strAgencyManagement'] = "Account Management";
$GLOBALS['strAgency'] = "계정";
$GLOBALS['strAddAgency'] = "새 계정 추가";
$GLOBALS['strAddAgency_Key'] = "새 �?역 추가(<u>n</u>)";
$GLOBALS['strTotalAgencies'] = "전체 계정";
$GLOBALS['strAgencyProperties'] = "Account Properties";
$GLOBALS['strNoAgencies'] = "현재 등�?�?� �?역�?� 없습니다.";
$GLOBALS['strConfirmDeleteAgency'] = "�?� �?역�?� 삭제합니까?";
$GLOBALS['strHideInactiveAgencies'] = "Hide inactive accounts";
$GLOBALS['strInactiveAgenciesHidden'] = "배너가 숨겨져 있습니다.";
$GLOBALS['strSwitchAccount'] = "Switch to this account";
$GLOBALS['strAgencyStatusRunning'] = "Active";
$GLOBALS['strAgencyStatusInactive'] = "사용가능";
$GLOBALS['strAgencyStatusPaused'] = "Suspended";

// Channels
$GLOBALS['strChannel'] = "Delivery Rule Set";
$GLOBALS['strChannels'] = "Delivery Rule Sets";
$GLOBALS['strChannelManagement'] = "Delivery Rule Set Management";
$GLOBALS['strAddNewChannel'] = "Add new Delivery Rule Set";
$GLOBALS['strAddNewChannel_Key'] = "Add <u>n</u>ew Delivery Rule Set";
$GLOBALS['strChannelToWebsite'] = "to website";
$GLOBALS['strNoChannels'] = "There are currently no delivery rule sets defined";
$GLOBALS['strNoChannelsAddWebsite'] = "There are currently no delivery rule sets defined, because there are no websites. To create a delivery rule set, <a href='affiliate-edit.php'>add a new website</a> first.";
$GLOBALS['strEditChannelLimitations'] = "Edit delivery rules for the delivery rule set";
$GLOBALS['strChannelProperties'] = "Delivery Rule Set Properties";
$GLOBALS['strChannelLimitations'] = "전송 옵션";
$GLOBALS['strConfirmDeleteChannel'] = "Do you really want to delete this delivery rule set?";
$GLOBALS['strConfirmDeleteChannels'] = "Do you really want to delete the selected delivery rule sets?";
$GLOBALS['strChannelsOfWebsite'] = 'in'; //this is added between page name and website name eg. 'delivery rule sets in www.example.com'

// Tracker Variables
$GLOBALS['strVariableName'] = "Variable Name";
$GLOBALS['strVariableDescription'] = "설명";
$GLOBALS['strVariableDataType'] = "데이터 형식";
$GLOBALS['strVariablePurpose'] = "Purpose";
$GLOBALS['strGeneric'] = "Generic";
$GLOBALS['strBasketValue'] = "Basket value";
$GLOBALS['strNumItems'] = "Number of items";
$GLOBALS['strVariableIsUnique'] = "Dedup conversions?";
$GLOBALS['strNumber'] = "Number";
$GLOBALS['strString'] = "String";
$GLOBALS['strTrackFollowingVars'] = "Track the following variable";
$GLOBALS['strAddVariable'] = "Add Variable";
$GLOBALS['strNoVarsToTrack'] = "No Variables to track.";
$GLOBALS['strVariableRejectEmpty'] = "Reject if empty?";
$GLOBALS['strTrackingSettings'] = "Tracking settings";
$GLOBALS['strTrackerType'] = "Tracker type";
$GLOBALS['strTrackerTypeJS'] = "Track JavaScript variables";
$GLOBALS['strTrackerTypeDefault'] = "Track JavaScript variables (backwards compatible, escaping needed)";
$GLOBALS['strTrackerTypeDOM'] = "Track HTML elements using DOM";
$GLOBALS['strTrackerTypeCustom'] = "Custom JS code";
$GLOBALS['strVariableCode'] = "Javascript tracking code";

// Password recovery
$GLOBALS['strForgotPassword'] = "Forgot your password?";
$GLOBALS['strPasswordRecovery'] = "Password reset";
$GLOBALS['strEmailRequired'] = "Email is a required field";
$GLOBALS['strPwdRecWrongId'] = "Wrong ID";
$GLOBALS['strPwdRecEnterEmail'] = "Enter your email address below";
$GLOBALS['strPwdRecEnterPassword'] = "Enter your new password below";
$GLOBALS['strProceed'] = "Proceed >";
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
$GLOBALS['strHas'] = "has";
$GLOBALS['strBinaryData'] = "Binary data";
$GLOBALS['strAuditTrailDisabled'] = "Audit Trail has been disabled by the system administrator. No further events are logged and shown in Audit Trail list.";

// Widget - Audit
$GLOBALS['strAuditNoData'] = "No user activity has been recorded during the timeframe you have selected.";
$GLOBALS['strAuditTrail'] = "Audit Trail";
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
$GLOBALS['strCampaignHasBeenUpdated'] = "캠페인 <a href='%s'>%s</a> 이 업데이트 되었습니다.";
$GLOBALS['strCampaignTrackersHaveBeenUpdated'] = "Linked trackers of campaign <a href='%s'>%s</a> have been updated";
$GLOBALS['strCampaignHasBeenDeleted'] = "캠페인 <b>%s</b> 이 삭제 되었습니다.";
$GLOBALS['strCampaignsHaveBeenDeleted'] = "선택 된 모든 캠페인이 삭제 되었습니다.";
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
$GLOBALS['keyNextItem'] = ",";
$GLOBALS['keyPreviousItem'] = ".";
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
