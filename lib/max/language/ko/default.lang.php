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

$GLOBALS['phpAds_DecimalPoint'] = ",";
$GLOBALS['phpAds_ThousandsSeperator'] = ".";

// Date & time configuration
$GLOBALS['date_format'] = "";
$GLOBALS['time_format'] = "";
$GLOBALS['minute_format'] = "%H:% M";
$GLOBALS['month_format'] = "";
$GLOBALS['day_format'] = "%m-%d";
$GLOBALS['week_format'] = "";
$GLOBALS['weekiso_format'] = "";

// Formats used by PEAR Spreadsheet_Excel_Writer packate
$GLOBALS['excel_integer_formatting'] = "";
$GLOBALS['excel_decimal_formatting'] = "";

/* ------------------------------------------------------- */
/* Translations                                          */
/* ------------------------------------------------------- */

$GLOBALS['strHome'] = "홈";
$GLOBALS['strHelp'] = "�?�움�?";
$GLOBALS['strStartOver'] = "재시작";
$GLOBALS['strShortcuts'] = "바로가기";
$GLOBALS['strActions'] = "작업";
$GLOBALS['strAndXMore'] = "";
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
$GLOBALS['strECPMAds'] = "";
$GLOBALS['strLowAds'] = "남은 캠페인 광고";
$GLOBALS['strLimitations'] = "";
$GLOBALS['strNoLimitations'] = "";
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
$GLOBALS['strUseSearchBoxToFindMoreAccounts'] = "";
$GLOBALS['strWorkingFor'] = "";
$GLOBALS['strNoAccountWithXInNameFound'] = "이름이 \"%s\"인 계정이 없습니다.";
$GLOBALS['strRecentlyUsed'] = "최근 사용";
$GLOBALS['strLinkUser'] = "사용자 추가";
$GLOBALS['strLinkUser_Key'] = "사용자 추가";
$GLOBALS['strUsernameToLink'] = "추가할 사용자의 계정 아이디";
$GLOBALS['strNewUserWillBeCreated'] = "새로운 사용자가 생성됩니다";
$GLOBALS['strToLinkProvideEmail'] = "";
$GLOBALS['strToLinkProvideUsername'] = "";
$GLOBALS['strUserLinkedToAccount'] = "";
$GLOBALS['strUserLinkedAndWelcomeSent'] = "";
$GLOBALS['strUserAccountUpdated'] = "";
$GLOBALS['strUserUnlinkedFromAccount'] = "";
$GLOBALS['strUserWasDeleted'] = "";
$GLOBALS['strUserNotLinkedWithAccount'] = "";
$GLOBALS['strCantDeleteOneAdminUser'] = "";
$GLOBALS['strLinkUserHelp'] = "";
$GLOBALS['strLinkUserHelpUser'] = "사용자 이름";
$GLOBALS['strLinkUserHelpEmail'] = "이메일 주소";
$GLOBALS['strLastLoggedIn'] = "마지막 로그인";
$GLOBALS['strDateLinked'] = "";

// Login & Permissions
$GLOBALS['strUserAccess'] = "";
$GLOBALS['strAdminAccess'] = "";
$GLOBALS['strUserProperties'] = "사용자 속성";
$GLOBALS['strPermissions'] = "권한";
$GLOBALS['strAuthentification'] = "인증";
$GLOBALS['strWelcomeTo'] = "환영합니다!";
$GLOBALS['strEnterUsername'] = "사용자ID와 비밀번호를 입력해 주세요.";
$GLOBALS['strEnterBoth'] = "사용자ID와 비밀번호를 모두 입력하세요!";
$GLOBALS['strEnableCookies'] = "{{PRODUCT_NAME}}를 사용하려면 쿠키를 사용하도록 설정해야 한다.";
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
$GLOBALS['strNoPlacement'] = "";
$GLOBALS['strNoAdvertiser'] = "";

// General advertising
$GLOBALS['strRequests'] = "";
$GLOBALS['strImpressions'] = "노출수";
$GLOBALS['strClicks'] = "클릭수";
$GLOBALS['strConversions'] = "변환";
$GLOBALS['strCTRShort'] = "클릭율";
$GLOBALS['strCNVRShort'] = "";
$GLOBALS['strCTR'] = "클릭한 비율";
$GLOBALS['strTotalClicks'] = "전체 클릭 수";
$GLOBALS['strTotalConversions'] = "변환 합계";
$GLOBALS['strDateTime'] = "날짜/시간";
$GLOBALS['strTrackerID'] = "추적 ID";
$GLOBALS['strTrackerName'] = "추적 이름";
$GLOBALS['strTrackerImageTag'] = "이미지 태그";
$GLOBALS['strTrackerJsTag'] = "자바 스크립트 태그";
$GLOBALS['strTrackerAlwaysAppend'] = "";
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
$GLOBALS['strFinanceCPA'] = "";
$GLOBALS['strFinanceMT'] = "";
$GLOBALS['strFinanceCTR'] = "클릭율";
$GLOBALS['strFinanceCR'] = "";

// Time and date related
$GLOBALS['strDate'] = "날짜";
$GLOBALS['strDay'] = "일";
$GLOBALS['strDays'] = "일간";
$GLOBALS['strWeek'] = "주";
$GLOBALS['strWeeks'] = "주간";
$GLOBALS['strSingleMonth'] = "월";
$GLOBALS['strMonths'] = "월간";
$GLOBALS['strDayOfWeek'] = "";


if (!isset($GLOBALS['strDayFullNames'])) {
    $GLOBALS['strDayFullNames'] = [];
}
$GLOBALS['strDayFullNames'][0] = '';
$GLOBALS['strDayFullNames'][1] = '';
$GLOBALS['strDayFullNames'][2] = '';
$GLOBALS['strDayFullNames'][3] = '';
$GLOBALS['strDayFullNames'][4] = '';
$GLOBALS['strDayFullNames'][5] = '';
$GLOBALS['strDayFullNames'][6] = '';

if (!isset($GLOBALS['strDayShortCuts'])) {
    $GLOBALS['strDayShortCuts'] = [];
}
$GLOBALS['strDayShortCuts'][0] = '일';
$GLOBALS['strDayShortCuts'][1] = '월';
$GLOBALS['strDayShortCuts'][2] = '화';
$GLOBALS['strDayShortCuts'][3] = '수';
$GLOBALS['strDayShortCuts'][4] = '목';
$GLOBALS['strDayShortCuts'][5] = '금';
$GLOBALS['strDayShortCuts'][6] = '토';

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
$GLOBALS['strClientHistory'] = "";
$GLOBALS['strNoClients'] = "현재 등록된 광고주가 없습니다. 캠페인을 만들려면 <a href='advertiser-edit.php'> 새 광고주 추가</a>를 하십시오.";
$GLOBALS['strConfirmDeleteClient'] = "해당 광고주를 삭제합니까?";
$GLOBALS['strConfirmDeleteClients'] = "해당 광고주를 삭제합니까?";
$GLOBALS['strHideInactive'] = "";
$GLOBALS['strInactiveAdvertisersHidden'] = "광고주가 숨겨져 있습니다.";
$GLOBALS['strAdvertiserSignup'] = "";
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
$GLOBALS['strAllowCreateAccounts'] = "";
$GLOBALS['strAdvertiserLimitation'] = "";
$GLOBALS['strAllowAuditTrailAccess'] = "";
$GLOBALS['strAllowDeleteItems'] = "";

// Campaign
$GLOBALS['strCampaign'] = "캠페인";
$GLOBALS['strCampaigns'] = "캠페인";
$GLOBALS['strAddCampaign'] = "새 캠페인 추가";
$GLOBALS['strAddCampaign_Key'] = "새 캠페인 추가 (<u>n</u>)";
$GLOBALS['strCampaignForAdvertiser'] = "";
$GLOBALS['strLinkedCampaigns'] = "";
$GLOBALS['strCampaignProperties'] = "캠페인 정보";
$GLOBALS['strCampaignOverview'] = "캠페인 요약";
$GLOBALS['strCampaignHistory'] = "";
$GLOBALS['strNoCampaigns'] = "해당 광고주에 대한 캠페인이 존재하지 않습니다.";
$GLOBALS['strNoCampaignsAddAdvertiser'] = "";
$GLOBALS['strConfirmDeleteCampaign'] = "정말로 캠페인을 삭제 하시겠습니까?";
$GLOBALS['strConfirmDeleteCampaigns'] = "정말로 선택된 캠페인을 삭제 하시겠습니까?";
$GLOBALS['strShowParentAdvertisers'] = "";
$GLOBALS['strHideParentAdvertisers'] = "";
$GLOBALS['strHideInactiveCampaigns'] = "사용 가능한 캠페인 숨김";
$GLOBALS['strInactiveCampaignsHidden'] = "활성 가능한 캠페인이 숨겨져 있습니다.";
$GLOBALS['strPriorityInformation'] = "";
$GLOBALS['strECPMInformation'] = "";
$GLOBALS['strRemnantEcpmDescription'] = "";
$GLOBALS['strEcpmMinImpsDescription'] = "";
$GLOBALS['strHiddenCampaign'] = "캠페인";
$GLOBALS['strHiddenAd'] = "";
$GLOBALS['strHiddenAdvertiser'] = "광고주";
$GLOBALS['strHiddenTracker'] = "";
$GLOBALS['strHiddenWebsite'] = "웹사이트";
$GLOBALS['strHiddenZone'] = "광고영역";
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
$GLOBALS['strLinked'] = "연결됨";
$GLOBALS['strAvailable'] = "";
$GLOBALS['strShowing'] = "";
$GLOBALS['strEditZone'] = "";
$GLOBALS['strEditWebsite'] = "";


// Campaign properties
$GLOBALS['strDontExpire'] = "캠페인을 만료하지 않습니다.";
$GLOBALS['strActivateNow'] = "해당 캠페인을 지금 활성화 합니다.";
$GLOBALS['strSetSpecificDate'] = "";
$GLOBALS['strLow'] = "낮음";
$GLOBALS['strHigh'] = "높음";
$GLOBALS['strExpirationDate'] = "만료일자";
$GLOBALS['strExpirationDateComment'] = "";
$GLOBALS['strActivationDate'] = "시작일자";
$GLOBALS['strActivationDateComment'] = "";
$GLOBALS['strImpressionsRemaining'] = "";
$GLOBALS['strClicksRemaining'] = "";
$GLOBALS['strConversionsRemaining'] = "";
$GLOBALS['strImpressionsBooked'] = "";
$GLOBALS['strClicksBooked'] = "";
$GLOBALS['strConversionsBooked'] = "";
$GLOBALS['strCampaignWeight'] = "캠페인 가중치 설정";
$GLOBALS['strAnonymous'] = "";
$GLOBALS['strTargetPerDay'] = "일별 제한";
$GLOBALS['strCampaignWarningRemnantNoWeight'] = "";
$GLOBALS['strCampaignWarningEcpmNoRevenue'] = "";
$GLOBALS['strCampaignWarningOverrideNoWeight'] = "";
$GLOBALS['strCampaignWarningNoTarget'] = "";
$GLOBALS['strCampaignStatusPending'] = "";
$GLOBALS['strCampaignStatusInactive'] = "사용가능";
$GLOBALS['strCampaignStatusRunning'] = "";
$GLOBALS['strCampaignStatusPaused'] = "";
$GLOBALS['strCampaignStatusAwaiting'] = "";
$GLOBALS['strCampaignStatusExpired'] = "";
$GLOBALS['strCampaignStatusApproval'] = "";
$GLOBALS['strCampaignStatusRejected'] = "";
$GLOBALS['strCampaignStatusAdded'] = "";
$GLOBALS['strCampaignStatusStarted'] = "";
$GLOBALS['strCampaignStatusRestarted'] = "";
$GLOBALS['strCampaignStatusDeleted'] = "삭제";
$GLOBALS['strCampaignType'] = "캠페인 유형";
$GLOBALS['strType'] = "";
$GLOBALS['strContract'] = "연락처";
$GLOBALS['strOverride'] = "";
$GLOBALS['strOverrideInfo'] = "";
$GLOBALS['strStandardContract'] = "연락처";
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
$GLOBALS['strConfirmDeleteTrackers'] = "정말 선택된 추적내역을 삭제 하시겠습니까?";
$GLOBALS['strConfirmDeleteTracker'] = "정말 추적내역을 삭제 하시겠습니까?";
$GLOBALS['strTrackerProperties'] = "추적 속성";
$GLOBALS['strDefaultStatus'] = "";
$GLOBALS['strStatus'] = "상태";
$GLOBALS['strLinkedTrackers'] = "";
$GLOBALS['strTrackerInformation'] = "";
$GLOBALS['strConversionWindow'] = "";
$GLOBALS['strUniqueWindow'] = "";
$GLOBALS['strClick'] = "";
$GLOBALS['strView'] = "";
$GLOBALS['strArrival'] = "";
$GLOBALS['strManual'] = "사용방법";
$GLOBALS['strImpression'] = "";
$GLOBALS['strConversionType'] = "";
$GLOBALS['strLinkCampaignsByDefault'] = "";
$GLOBALS['strBackToTrackers'] = "";
$GLOBALS['strIPAddress'] = "";

// Banners (General)
$GLOBALS['strBanner'] = "배너";
$GLOBALS['strBanners'] = "배너";
$GLOBALS['strAddBanner'] = "새 배너 추가";
$GLOBALS['strAddBanner_Key'] = "새 배너 추가(<u>n</u>)";
$GLOBALS['strBannerToCampaign'] = "";
$GLOBALS['strShowBanner'] = "배너 보기";
$GLOBALS['strBannerProperties'] = "배너 속성";
$GLOBALS['strBannerHistory'] = "";
$GLOBALS['strNoBanners'] = "이 캠페인에 등록된 배너가 없습니다.";
$GLOBALS['strNoBannersAddCampaign'] = "";
$GLOBALS['strNoBannersAddAdvertiser'] = "";
$GLOBALS['strConfirmDeleteBanner'] = "해당 배너를 삭제하시면 통계내역도 함께 삭제됩니다.
정말 이 배너를 삭제 하시겠습니까?";
$GLOBALS['strConfirmDeleteBanners'] = "해당 배너를 삭제하시면 통계내역도 함께 삭제됩니다.
정말 선택된 배너를 삭제 하시겠습니까?";
$GLOBALS['strShowParentCampaigns'] = "상위 캠페인 표시";
$GLOBALS['strHideParentCampaigns'] = "상위 캠페인 숨김";
$GLOBALS['strHideInactiveBanners'] = "비활성화 된 배너 숨김";
$GLOBALS['strInactiveBannersHidden'] = "비활성화 된 배너가 숨겨져 있습니다.";
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
$GLOBALS['strChooseBanner'] = "배너 형태를 선택해 주세요.";
$GLOBALS['strMySQLBanner'] = "로컬 배너 (SQL - DB 저장방식)";
$GLOBALS['strWebBanner'] = "로컬 배너 (웹서버 - 웹 저장 방식)";
$GLOBALS['strURLBanner'] = "외부 배너";
$GLOBALS['strHTMLBanner'] = "HTML 배너 생성";
$GLOBALS['strTextBanner'] = "텍스트 광고 생성";
$GLOBALS['strAlterHTML'] = "";
$GLOBALS['strIframeFriendly'] = "";
$GLOBALS['strUploadOrKeep'] = "현재 �?�미지를 �?�용하거나<br> 다른 �?�미지를 업로드할<br> 수 있습니다.";
$GLOBALS['strNewBannerFile'] = "배너로 사용 할 이미지를 선택해 주세요.";
$GLOBALS['strNewBannerFileAlt'] = "";
$GLOBALS['strNewBannerURL'] = "이미지 URL(incl. http://)";
$GLOBALS['strURL'] = "대상 URL(incl. http://)";
$GLOBALS['strKeyword'] = "키워드";
$GLOBALS['strTextBelow'] = "이미지 하단 텍스트";
$GLOBALS['strWeight'] = "가중치";
$GLOBALS['strAlt'] = "Alt 텍스트";
$GLOBALS['strStatusText'] = "상태표시줄 텍스트";
$GLOBALS['strCampaignsWeight'] = "";
$GLOBALS['strBannerWeight'] = "배너 가중치";
$GLOBALS['strBannersWeight'] = "";
$GLOBALS['strAdserverTypeGeneric'] = "일반 HTML 배너";
$GLOBALS['strDoNotAlterHtml'] = "";
$GLOBALS['strGenericOutputAdServer'] = "";
$GLOBALS['strBackToBanners'] = "";
$GLOBALS['strUseWyswygHtmlEditor'] = "";
$GLOBALS['strChangeDefault'] = "";

// Banner (advanced)
$GLOBALS['strBannerPrependHTML'] = "";
$GLOBALS['strBannerAppendHTML'] = "";

// Display Delviery Rules
$GLOBALS['strModifyBannerAcl'] = "전송 옵션";
$GLOBALS['strACL'] = "전송 옵션";
$GLOBALS['strACLAdd'] = "";
$GLOBALS['strApplyLimitationsTo'] = "";
$GLOBALS['strAllBannersInCampaign'] = "";
$GLOBALS['strRemoveAllLimitations'] = "";
$GLOBALS['strEqualTo'] = "같을 경우";
$GLOBALS['strDifferentFrom'] = "다른 경우";
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
$GLOBALS['strAND'] = "그리고";                          // logical operator
$GLOBALS['strOR'] = "또는";                         // logical operator
$GLOBALS['strOnlyDisplayWhen'] = "다음 조건에서만 배너를 표시합니다.:";
$GLOBALS['strWeekDays'] = "주간";
$GLOBALS['strTime'] = "시간";
$GLOBALS['strDomain'] = "도메인";
$GLOBALS['strSource'] = "소스";
$GLOBALS['strBrowser'] = "브라우저";
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
$GLOBALS['strAffiliate'] = "웹사이트";
$GLOBALS['strAffiliates'] = "웹사이트";
$GLOBALS['strAffiliatesAndZones'] = "웹사이트 & 광고영역";
$GLOBALS['strAddNewAffiliate'] = "새 웹사이트 추가";
$GLOBALS['strAffiliateProperties'] = "웹사이트 속성";
$GLOBALS['strAffiliateHistory'] = "";
$GLOBALS['strNoAffiliates'] = "현재 웹사이트가 존재하지 않습니다. 웹사이트 추가 후 광고영역을 생성해 주세요.";
$GLOBALS['strConfirmDeleteAffiliate'] = "해당 웹사이트를 정말로 삭제 하시겠습니까?";
$GLOBALS['strConfirmDeleteAffiliates'] = "선택된 해당 웹사이트를 정말로 삭제 하시겠습니까?";
$GLOBALS['strInactiveAffiliatesHidden'] = "배너가 숨겨져 있습니다.";
$GLOBALS['strShowParentAffiliates'] = "";
$GLOBALS['strHideParentAffiliates'] = "";

// Website (properties)
$GLOBALS['strWebsite'] = "웹사이트";
$GLOBALS['strWebsiteURL'] = "";
$GLOBALS['strAllowAffiliateModifyZones'] = "사용자가 광고영역을 수정하는 것을 허용합니다.";
$GLOBALS['strAllowAffiliateLinkBanners'] = "사용자가 광고영역과 배너를 연결할 수 있도록 허용 하시겠습니까?";
$GLOBALS['strAllowAffiliateAddZone'] = "사용자가 새로운 광고영역을 생성할 수 있도록 허용 하시겠습니까?";
$GLOBALS['strAllowAffiliateDeleteZone'] = "사용자가 광고영역을 삭제 할 수 있도록 허용 하시겠습니까?";
$GLOBALS['strAllowAffiliateGenerateCode'] = "";

// Website (properties - payment information)
$GLOBALS['strPostcode'] = "";
$GLOBALS['strCountry'] = "국가";

// Website (properties - other information)
$GLOBALS['strWebsiteZones'] = "광고게시 웹사이트 영역";

// Zone
$GLOBALS['strZone'] = "광고영역";
$GLOBALS['strZones'] = "영역";
$GLOBALS['strAddNewZone'] = "새 광고영역 추가";
$GLOBALS['strAddNewZone_Key'] = "새 광고영역 추가 (<u>n</u>)";
$GLOBALS['strZoneToWebsite'] = "";
$GLOBALS['strLinkedZones'] = "연결된 광고영역";
$GLOBALS['strAvailableZones'] = "";
$GLOBALS['strLinkingNotSuccess'] = "";
$GLOBALS['strZoneProperties'] = "광고영역 속성";
$GLOBALS['strZoneHistory'] = "광고영역 내역";
$GLOBALS['strNoZones'] = "현재 웹사이트에 광고영역이 존재하지 않습니다.";
$GLOBALS['strNoZonesAddWebsite'] = "";
$GLOBALS['strConfirmDeleteZone'] = "정말로 광고영역을 삭제 하시겠습니까?";
$GLOBALS['strConfirmDeleteZones'] = "정말로 선택하신 광고영역을 삭제 하시겠습니까?";
$GLOBALS['strConfirmDeleteZoneLinkActive'] = "";
$GLOBALS['strZoneType'] = "광고영역 종류";
$GLOBALS['strBannerButtonRectangle'] = "배너, 버튼형 혹은 사각형";
$GLOBALS['strInterstitial'] = "플로팅 DHTML";
$GLOBALS['strPopup'] = "팝업";
$GLOBALS['strTextAdZone'] = "텍스트 광고";
$GLOBALS['strEmailAdZone'] = "";
$GLOBALS['strZoneVideoInstream'] = "";
$GLOBALS['strZoneVideoOverlay'] = "";
$GLOBALS['strShowMatchingBanners'] = "일치하는 배너보기";
$GLOBALS['strHideMatchingBanners'] = "일치하는 배너 숨기기";
$GLOBALS['strBannerLinkedAds'] = "";
$GLOBALS['strCampaignLinkedAds'] = "";
$GLOBALS['strInactiveZonesHidden'] = "배너가 숨겨져 있습니다.";
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
$GLOBALS['strAdvanced'] = "고급 설정";
$GLOBALS['strChainSettings'] = "연결 설정";
$GLOBALS['strZoneNoDelivery'] = "만약 해당영역에 배너가 존재하지 않으면, 정상적으로 광고전달이 되지 않습니다. 다시 시도해 주세요.";
$GLOBALS['strZoneStopDelivery'] = "해당 광고영역에 배너를 중지합니다.";
$GLOBALS['strZoneOtherZone'] = "선택된 광고영역에 표시합니다.";
$GLOBALS['strZoneAppend'] = "�?� �?역�? 연결�?� 배너�? �?업�?�나 격�? 배너 호출 코드를 항�? 추가합니다.";
$GLOBALS['strAppendSettings'] = "배너 첨부 설정";
$GLOBALS['strZonePrependHTML'] = "�?� �?역�? 표시�?� �?스트 광고 앞�? HTML 코드를 추가합니다.";
$GLOBALS['strZoneAppendNoBanner'] = "";
$GLOBALS['strZoneAppendHTMLCode'] = "";
$GLOBALS['strZoneAppendZoneSelection'] = "";

// Zone probability
$GLOBALS['strZoneProbListChain'] = "선�?한 �?역�? 연결�?� 배너는 모�? �?(null) 우선순위입니다. �?역 연결�?� 다�?�과 같습니다.:";
$GLOBALS['strZoneProbNullPri'] = "�?� �?역�? 연결�?� 배너는 모�? �?(null) 우선순위입니다.";
$GLOBALS['strZoneProbListChainLoop'] = "";

// Linked banners/campaigns/trackers
$GLOBALS['strSelectZoneType'] = "이 광고영역에 연결한 배너를 선택해 주세요.";
$GLOBALS['strLinkedBanners'] = "";
$GLOBALS['strCampaignDefaults'] = "";
$GLOBALS['strLinkedCategories'] = "";
$GLOBALS['strWithXBanners'] = "";
$GLOBALS['strRawQueryString'] = "키워드";
$GLOBALS['strIncludedBanners'] = "연결 된 배너";
$GLOBALS['strMatchingBanners'] = "일치하는 배너 수  {count}";
$GLOBALS['strNoCampaignsToLink'] = "현재 �?� �?역�? 연결할 �?페�?��?� 없습니다.";
$GLOBALS['strNoTrackersToLink'] = "현재 �?� �?역�? 연결할 �?페�?��?� 없습니다.";
$GLOBALS['strNoZonesToLinkToCampaign'] = "현재 �?� �?역�? 연결�?� �?페�?��?� 없습니다.";
$GLOBALS['strSelectBannerToLink'] = "�?� �?역�? 연결할 배너를 선�?하세요:";
$GLOBALS['strSelectCampaignToLink'] = "�?� �?역�? 연결할 캠페�?� 선�?합니다:";
$GLOBALS['strSelectAdvertiser'] = "광고주 선택";
$GLOBALS['strSelectPlacement'] = "";
$GLOBALS['strSelectAd'] = "배너 선택";
$GLOBALS['strSelectPublisher'] = "웹사이트 선택";
$GLOBALS['strSelectZone'] = "광고영역 선택";
$GLOBALS['strStatusPending'] = "";
$GLOBALS['strStatusApproved'] = "";
$GLOBALS['strStatusDisapproved'] = "";
$GLOBALS['strStatusDuplicate'] = "복제";
$GLOBALS['strStatusOnHold'] = "";
$GLOBALS['strStatusIgnore'] = "";
$GLOBALS['strConnectionType'] = "";
$GLOBALS['strConnTypeSale'] = "저장";
$GLOBALS['strConnTypeLead'] = "";
$GLOBALS['strConnTypeSignUp'] = "";
$GLOBALS['strShortcutEditStatuses'] = "";
$GLOBALS['strShortcutShowStatuses'] = "";

// Statistics
$GLOBALS['strStats'] = "통계";
$GLOBALS['strNoStats'] = "현재 통계내역이 없습니다.";
$GLOBALS['strNoStatsForPeriod'] = "";
$GLOBALS['strGlobalHistory'] = "";
$GLOBALS['strDailyHistory'] = "";
$GLOBALS['strDailyStats'] = "";
$GLOBALS['strWeeklyHistory'] = "";
$GLOBALS['strMonthlyHistory'] = "";
$GLOBALS['strTotalThisPeriod'] = "기간 합계";
$GLOBALS['strPublisherDistribution'] = "";
$GLOBALS['strCampaignDistribution'] = "";
$GLOBALS['strViewBreakdown'] = "";
$GLOBALS['strBreakdownByDay'] = "일";
$GLOBALS['strBreakdownByWeek'] = "주";
$GLOBALS['strBreakdownByMonth'] = "월";
$GLOBALS['strBreakdownByDow'] = "";
$GLOBALS['strBreakdownByHour'] = "시";
$GLOBALS['strItemsPerPage'] = "";
$GLOBALS['strDistributionHistoryCampaign'] = "";
$GLOBALS['strDistributionHistoryBanner'] = "";
$GLOBALS['strDistributionHistoryWebsite'] = "";
$GLOBALS['strDistributionHistoryZone'] = "";
$GLOBALS['strShowGraphOfStatistics'] = "";
$GLOBALS['strExportStatisticsToExcel'] = "";
$GLOBALS['strGDnotEnabled'] = "";
$GLOBALS['strStatsArea'] = "지역";

// Expiration
$GLOBALS['strNoExpiration'] = "기간제한 없음";
$GLOBALS['strEstimated'] = "예상되는 만료일";
$GLOBALS['strNoExpirationEstimation'] = "";
$GLOBALS['strDaysAgo'] = "몇일 전";
$GLOBALS['strCampaignStop'] = "캠페인 중지";

// Reports
$GLOBALS['strAdvancedReports'] = "";
$GLOBALS['strStartDate'] = "시작일자";
$GLOBALS['strEndDate'] = "종료일자";
$GLOBALS['strPeriod'] = "";
$GLOBALS['strLimitations'] = "";
$GLOBALS['strWorksheets'] = "";

// Admin_UI_Fields
$GLOBALS['strAllAdvertisers'] = "모든 광고주";
$GLOBALS['strAnonAdvertisers'] = "";
$GLOBALS['strAllPublishers'] = "";
$GLOBALS['strAnonPublishers'] = "";
$GLOBALS['strAllAvailZones'] = "";

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
$GLOBALS['strTrackercode'] = "";
$GLOBALS['strBackToTheList'] = "";
$GLOBALS['strCharset'] = "";
$GLOBALS['strAutoDetect'] = "";
$GLOBALS['strCacheBusterComment'] = "";
$GLOBALS['strGenerateHttpsTags'] = "";

// Errors
$GLOBALS['strErrorDatabaseConnection'] = "";
$GLOBALS['strErrorCantConnectToDatabase'] = "";
$GLOBALS['strNoMatchesFound'] = "검색 결과가 없습니다.";
$GLOBALS['strErrorOccurred'] = "오류가 발생했습니다.";
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
$GLOBALS['strMailSubject'] = "광고주 보고서";
$GLOBALS['strMailHeader'] = "{contact}님,";
$GLOBALS['strMailBannerStats'] = "{clientname}님!  배너 통계는 다음과 같습니다.";
$GLOBALS['strMailBannerActivatedSubject'] = "캠페인 {id} 활성화";
$GLOBALS['strMailBannerDeactivatedSubject'] = "캠페인 {id} 비활성화";
$GLOBALS['strMailBannerActivated'] = "";
$GLOBALS['strMailBannerDeactivated'] = "";
$GLOBALS['strMailFooter'] = "";
$GLOBALS['strClientDeactivated'] = "�?� 캠페�?��?� 현재 다�?�과 같�?� �?�유로 운�?하지 않습니다.";
$GLOBALS['strBeforeActivate'] = "아직 광고 활성화 기간이 아닙니다.";
$GLOBALS['strAfterExpire'] = "만기일자가 다가옵니다.";
$GLOBALS['strNoMoreImpressions'] = "";
$GLOBALS['strNoMoreClicks'] = "남아있는 클릭수가 없습니다.";
$GLOBALS['strNoMoreConversions'] = "남아있는 광고상품이 없습니다.";
$GLOBALS['strWeightIsNull'] = "";
$GLOBALS['strRevenueIsNull'] = "";
$GLOBALS['strTargetIsNull'] = "";
$GLOBALS['strNoViewLoggedInInterval'] = "�?� 기간 �?�안�?� 보고서�? 기�?�?� AdViews가 없습니다.";
$GLOBALS['strNoClickLoggedInInterval'] = "�?� 기간 �?�안�?� 보고서�? 기�?�?� AdClicks�?� 없습니다.";
$GLOBALS['strNoConversionLoggedInInterval'] = "�?� 기간 �?�안�?� 보고서�? 기�?�?� AdViews가 없습니다.";
$GLOBALS['strMailReportPeriod'] = "�?� 보고서�?는 {startdate}�?서 {enddate}까지�?� 통계를 �?�함하고 있습니다.";
$GLOBALS['strMailReportPeriodAll'] = "�?� 보고서�?는 {enddate}까지�?� 통계를 �?�함하고 있습니다.";
$GLOBALS['strNoStatsForCampaign'] = "�?� 캠페�?��?서 �?�용할 수 있는 통계가 없습니다.";
$GLOBALS['strImpendingCampaignExpiry'] = "";
$GLOBALS['strYourCampaign'] = "";
$GLOBALS['strTheCampiaignBelongingTo'] = "";
$GLOBALS['strImpendingCampaignExpiryDateBody'] = "";
$GLOBALS['strImpendingCampaignExpiryImpsBody'] = "";
$GLOBALS['strImpendingCampaignExpiryBody'] = "";

// Priority
$GLOBALS['strPriority'] = "우선순위";
$GLOBALS['strSourceEdit'] = "";

// Preferences
$GLOBALS['strPreferences'] = "환경설정";
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
$GLOBALS['strFullName'] = "전체 이름";
$GLOBALS['strEmailAddress'] = "이메일 주소";
$GLOBALS['strUserDetails'] = "사용자 상세정보";
$GLOBALS['strUserInterfacePreferences'] = "사용자 환경설정";
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
$GLOBALS['strClicks_short'] = "클릭수";
$GLOBALS['strCTR_short'] = "클릭율";
$GLOBALS['strConversions_short'] = "";
$GLOBALS['strPendingConversions_short'] = "";
$GLOBALS['strImpressionSR_short'] = "";
$GLOBALS['strClickSR_short'] = "";

// Global Settings
$GLOBALS['strConfiguration'] = "";
$GLOBALS['strGlobalSettings'] = "전체 설정";
$GLOBALS['strGeneralSettings'] = "일반 설정";
$GLOBALS['strMainSettings'] = "메인설정";
$GLOBALS['strPlugins'] = "플러그인";
$GLOBALS['strChooseSection'] = '�?역 선�?';

// Product Updates
$GLOBALS['strProductUpdates'] = "제품 업데이트";
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
$GLOBALS['strAgency'] = "계정";
$GLOBALS['strAddAgency'] = "새 계정 추가";
$GLOBALS['strAddAgency_Key'] = "새 �?역 추가(<u>n</u>)";
$GLOBALS['strTotalAgencies'] = "전체 계정";
$GLOBALS['strAgencyProperties'] = "";
$GLOBALS['strNoAgencies'] = "현재 등�?�?� �?역�?� 없습니다.";
$GLOBALS['strConfirmDeleteAgency'] = "�?� �?역�?� 삭제합니까?";
$GLOBALS['strHideInactiveAgencies'] = "";
$GLOBALS['strInactiveAgenciesHidden'] = "배너가 숨겨져 있습니다.";
$GLOBALS['strSwitchAccount'] = "";
$GLOBALS['strAgencyStatusRunning'] = "";
$GLOBALS['strAgencyStatusInactive'] = "사용가능";
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
$GLOBALS['strChannelLimitations'] = "전송 옵션";
$GLOBALS['strConfirmDeleteChannel'] = "";
$GLOBALS['strConfirmDeleteChannels'] = "";
$GLOBALS['strChannelsOfWebsite'] = ''; //this is added between page name and website name eg. 'delivery rule sets in www.example.com'

// Tracker Variables
$GLOBALS['strVariableName'] = "";
$GLOBALS['strVariableDescription'] = "설명";
$GLOBALS['strVariableDataType'] = "데이터 형식";
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
$GLOBALS['strCampaignHasBeenUpdated'] = "캠페인 <a href='%s'>%s</a> 이 업데이트 되었습니다.";
$GLOBALS['strCampaignTrackersHaveBeenUpdated'] = "";
$GLOBALS['strCampaignHasBeenDeleted'] = "캠페인 <b>%s</b> 이 삭제 되었습니다.";
$GLOBALS['strCampaignsHaveBeenDeleted'] = "선택 된 모든 캠페인이 삭제 되었습니다.";
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
$GLOBALS['keyNextItem'] = ",";
$GLOBALS['keyPreviousItem'] = ".";
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
