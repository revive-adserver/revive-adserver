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

// Installer translation strings
$GLOBALS['strInstall'] = "설치";
$GLOBALS['strDatabaseSettings'] = "�?��?�터베�?�스 설정";
$GLOBALS['strAdminSettings'] = "관리�? 설정";
$GLOBALS['strAdvancedSettings'] = "고급 설정";
$GLOBALS['strWarning'] = "경고";
$GLOBALS['strTablesType'] = "테�?�블 종류";



$GLOBALS['strInstallSuccess'] = "<b>The installation of {$PRODUCT_NAME} is now complete.</b><br><br>In order for {$PRODUCT_NAME} to function correctly you also need
						   to make sure the maintenance file is run every hour. More information about this subject can be found in the documentation.
						   <br><br>Click <b>Proceed</b> to go the configuration page, where you can
						   set up more settings. Please do not forget to lock the config.inc.php file when you are finished to prevent security
						   breaches.";
$GLOBALS['strInstallNotSuccessful'] = "<b>The installation of {$PRODUCT_NAME} was not succesful</b><br><br>Some portions of the install process could not be completed.
						   It is possible these problems are only temporarily, in that case you can simply click <b>Proceed</b> and return to the
						   first step of the install process. If you want to know more on what the error message below means, and how to solve it,
						   please consult the supplied documentation.";
$GLOBALS['strErrorOccured'] = "다�?� 오류가 발�?했습니다:";
$GLOBALS['strErrorInstallDatabase'] = "�?��?�터베�?�스 구조가 �?성�?�지 않았습니다.";
$GLOBALS['strErrorInstallDbConnect'] = "�?��?�터베�?�스와 연결할 수 없습니다.";



$GLOBALS['strDeliveryUrlPrefix'] = "전달유지 엔진";
$GLOBALS['strDeliveryUrlPrefixSSL'] = "전달유지 엔진";

$GLOBALS['strInvalidUserPwd'] = "잘못�?� 사용�? ID �?는 비밀번호입니다.";

$GLOBALS['strUpgrade'] = "업그레�?�드";
$GLOBALS['strSystemUpToDate'] = "시스템�?� 구성요소가 �?�미 최신 버전입니다. 지금 업그레�?�드할 수 없습니다.<br> 홈페�?�지로 �?��?�하려면 <b>계�?</b>�?� �?�릭하세요.";
$GLOBALS['strSystemNeedsUpgrade'] = "시스템�?� 올바르게 �?�작하려면 �?��?�터베�?�스 구조와 설정 파�?��?� 업그레�?�드해야 합니다. 시스템�?� 업그레�?�드하기 위해 <b>계�?</b>�?� �?�릭하십시오.<br>시스템�?� 업그레�?�드하는 �?� 몇 분 정�?� 걸릴 수 있습니다.";
$GLOBALS['strSystemUpgradeBusy'] = "시스템�?� 업그레�?�드중입니다. 잠시 기다려주십시오...";
$GLOBALS['strSystemRebuildingCache'] = "�?시를 재구축중입니다. 잠시 기다려주십시오...";
$GLOBALS['strServiceUnavalable'] = "시스템�?� 업그레�?�드 중�?�므로 서비스를 잠시�?�안 �?�용할 수 없습니다.";

/* ------------------------------------------------------- */
/* Configuration translations                            */
/* ------------------------------------------------------- */

// Global
$GLOBALS['strChooseSection'] = "�?역 선�?";
$GLOBALS['strEditConfigNotPossible'] = "It is not possible to edit all settings because the configuration file is locked for security reasons. " .
    "If you want to make changes, you may need to unlock the configuration file for this installation first.";
$GLOBALS['strEditConfigPossible'] = "It is possible to edit all settings because the configuration file is not locked, but this could lead to security issues. " .
    "If you want to secure your system, you need to lock the configuration file for this installation.";

// Configuration Settings

// Administrator Settings
$GLOBALS['strAdministratorSettings'] = "관리�? 설정";
$GLOBALS['strLoginCredentials'] = "로그�?� 정보";
$GLOBALS['strAdminUsername'] = "관리�? ID";
$GLOBALS['strInvalidUsername'] = "잘못�?� ID";
$GLOBALS['strBasicInformation'] = "기본 정보";
$GLOBALS['strAdminFullName'] = "관리�? 전체 �?�름";
$GLOBALS['strAdminEmail'] = "관리�? �?�메�?�";
$GLOBALS['strCompanyName'] = "회사 �?�름";
$GLOBALS['strAdminCheckUpdates'] = "업�?��?�트 검색";
$GLOBALS['strAdminCheckEveryLogin'] = "로긴마다";
$GLOBALS['strAdminCheckDaily'] = "�?��?�";
$GLOBALS['strAdminCheckWeekly'] = "주간";
$GLOBALS['strAdminCheckMonthly'] = "월간";
$GLOBALS['strAdminCheckNever'] = "안함";
$GLOBALS['strUserlogEmail'] = "모든 외부 발송 �?�메�?� 메시지를 기�?합니다.";


// Database Settings
$GLOBALS['strDatabaseSettings'] = "�?��?�터베�?�스 설정";
$GLOBALS['strDatabaseServer'] = "�?��?�터베�?�스 서버";
$GLOBALS['strDbType'] = "�?��?�터베�?�스 �?�름";
$GLOBALS['strDbHost'] = "�?��?�터베�?�스 호스트명";
$GLOBALS['strDbUser'] = "�?��?�터베�?�스 사용�?�?�름";
$GLOBALS['strDbPassword'] = "�?��?�터베�?�스 비밀번호";
$GLOBALS['strDbName'] = "�?��?�터베�?�스 �?�름";
$GLOBALS['strDatabaseOptimalisations'] = "�?��?�터베�?�스 최�?화";
$GLOBALS['strPersistentConnections'] = "연결 유지(persistent connection) 사용";
$GLOBALS['strCantConnectToDb'] = "�?��?�터베�?�스�? 연결할 수 없습니다.";



// Email Settings
$GLOBALS['strEmailSettings'] = "설정";
$GLOBALS['strQmailPatch'] = "qmail 패치를 사용합니다.(qmail�?� 사용하는 경우)";
$GLOBALS['strEnableQmailPatch'] = "qmail 패치를 사용합니다.(qmail�?� 사용하는 경우)";

// Audit Trail Settings

// Debug Logging Settings

// Delivery Settings
$GLOBALS['strDeliverySettings'] = "전달 유지 설정";
$GLOBALS['strWebPath'] = "$PRODUCT_NAME Server Access Paths";
$GLOBALS['strDeliveryPath'] = "전달유지 �?시";
$GLOBALS['strDeliverySslPath'] = "전달유지 �?시";
$GLOBALS['strTypeWebSettings'] = "로컬 배너(웹서버) 설정";
$GLOBALS['strTypeWebMode'] = "저장 방법";
$GLOBALS['strTypeWebModeLocal'] = "로컬 디렉터리";
$GLOBALS['strTypeWebModeFtp'] = "외부 FTP 서버";
$GLOBALS['strTypeWebDir'] = "로컬 디렉터리";
$GLOBALS['strTypeFTPHost'] = "FTP 호스트";
$GLOBALS['strTypeFTPDirectory'] = "호스트 디렉터리";
$GLOBALS['strTypeFTPUsername'] = "로그�?�ID";
$GLOBALS['strTypeFTPPassword'] = "비밀번호";



$GLOBALS['strP3PSettings'] = "P3P 개�?� 보호 정책";
$GLOBALS['strUseP3P'] = "P3P 정책 사용";
$GLOBALS['strP3PCompactPolicy'] = "P3P Compact 정책";
$GLOBALS['strP3PPolicyLocation'] = "P3P 정책 위치";

// General Settings

// Geotargeting Settings
$GLOBALS['strGeotargetingSettings'] = "지역 정보 중심(Geotargeting)";
$GLOBALS['strGeotargeting'] = "지역 정보 중심(Geotargeting)";

// Interface Settings
$GLOBALS['strInventory'] = "목�?";
$GLOBALS['strShowCampaignInfo'] = "<i>캠페�?� 목�?</i> 페�?�지�? 캠페�?� 정보를 �?세히 보여�?니다.";
$GLOBALS['strShowBannerInfo'] = "<i>배너 목�?</i> 페�?�지�? 배너 정보를 �?세히 보여�?니다.";
$GLOBALS['strShowCampaignPreview'] = "<i>배너 목�?</i> 페�?�지�? 배너�?� 미리보기를 모�? 표시합니다.";
$GLOBALS['strShowBannerHTML'] = "HTML 코드 대신�? 실제 배너를 표시합니다.";
$GLOBALS['strShowBannerPreview'] = "배너 처리 화면�?서 페�?�지 �?단�? 배너 미리보기를 표시합니다.";
$GLOBALS['strHideInactive'] = "사용하지 않는 항목�?� 모든 목�? 페�?�지�?서 숨�?니다.";
$GLOBALS['strGUIShowMatchingBanners'] = "<i>연결�?� 배너</i> 페�?�지�? 해당 배너를 표시합니다.";
$GLOBALS['strGUIShowParentCampaigns'] = "<i>연결�?� 배너</i> 페�?�지�? 해당하는 �?위 �?페�?��?� 표시합니다.";
$GLOBALS['strStatisticsDefaults'] = "통계";
$GLOBALS['strBeginOfWeek'] = "한 주�?� 시작�?�";
$GLOBALS['strPercentageDecimals'] = "백분율 소수�?";
$GLOBALS['strWeightDefaults'] = "가중치 기본설정";
$GLOBALS['strDefaultBannerWeight'] = "배너 가중치 기본값";
$GLOBALS['strDefaultCampaignWeight'] = "캠페�?� 가중치 기본값";
$GLOBALS['strDefaultBannerWErr'] = "배너 가중치�?� 기본값�?� 정수를 입력해야합니다.";
$GLOBALS['strDefaultCampaignWErr'] = "캠페�?� 가중치�?� 기본값�?� 정수를 입력해야합니다.";


// CSV Import Settings

/**
 * @todo remove strBannerSettings if banner is only configurable as a preference
 *       rename // Banner Settings to  // Banner Preferences
 */
// Invocation Settings
$GLOBALS['strAllowedInvocationTypes'] = "허용�?� 배너 호출 종류";

// Banner Delivery Settings

// Banner Logging Settings
$GLOBALS['strReverseLookup'] = "DNS 역참조";
$GLOBALS['strProxyLookup'] = "프�?시 참조";
$GLOBALS['strIgnoreHosts'] = "무시할 호스트";

// Banner Storage Settings

// Campaign ECPM settings

// Statistics & Maintenance Settings
$GLOBALS['strAdminEmailHeaders'] = "�?��?� 광고 보고서�?� 발송�?�? 대한 정보를 메�?� 헤�?��? �?�함합니다.";
$GLOBALS['strWarnLimit'] = "경고횟수 제한(Warn Limit)";
$GLOBALS['strWarnLimitErr'] = "경고횟수 제한(Warn Limit)�?� �?�수를 사용할 수 없습니다.";
$GLOBALS['strWarnAdmin'] = "관리�?�?게 경고를 알립니다.";
$GLOBALS['strWarnClient'] = "광고주�?게 경고를 알립니다.";
$GLOBALS['strWarnAgency'] = "광고주�?게 경고를 알립니다.";

// UI Settings
$GLOBALS['strGuiSettings'] = "사용�? �?�터페�?�스 설정";
$GLOBALS['strGeneralSettings'] = "�?�반 설정";
$GLOBALS['strAppName'] = "�?�용 프로그램 �?�름";
$GLOBALS['strMyHeader'] = "내 머리글";
$GLOBALS['strMyFooter'] = "내 바닥글";


$GLOBALS['strGzipContentCompression'] = "컨�?트 GZIP 압축 사용";
$GLOBALS['strClientInterface'] = "광고주 �?�터페�?�스";
$GLOBALS['strClientWelcomeEnabled'] = "광고주 환�? 메시지를 사용합니다.";
$GLOBALS['strClientWelcomeText'] = "환�? 메시지<br>(HTML 태그 가능)";


// Regenerate Platfor Hash script

// Plugin Settings

/* ------------------------------------------------------- */
/* Unknown (unused?) translations                        */
/* ------------------------------------------------------- */

$GLOBALS['strKeywordRetrieval'] = "키워드 검색";
$GLOBALS['strBannerRetrieval'] = "배너 검색 방법";
$GLOBALS['strRetrieveRandom'] = "랜�?� 배너 검색(기본)";
$GLOBALS['strRetrieveNormalSeq'] = "배너 검색(�?�반)";
$GLOBALS['strWeightSeq'] = "가중치로 배너 검색";
$GLOBALS['strFullSeq'] = "전체 배너 검색";
$GLOBALS['strUseConditionalKeys'] = "�?접 선�?�?� 사용할 때 논리 연산�?를 허용합니다.";
$GLOBALS['strUseMultipleKeys'] = "�?접 선�?�?� 사용할 때 다수�?� 키워드를 허용합니다.";

$GLOBALS['strTableBorderColor'] = "테�?�블 테�?리 색�?";
$GLOBALS['strTableBackColor'] = "테�?�블 배경 색�?";
$GLOBALS['strTableBackColorAlt'] = "테�?�블 배경 색�?(Alternative)";
$GLOBALS['strMainBackColor'] = "주 배경 색�?";
$GLOBALS['strOverrideGD'] = "GD �?�미지 �?�맷�?� 무시합니다.";
$GLOBALS['strTimeZone'] = "시간 �?역";
