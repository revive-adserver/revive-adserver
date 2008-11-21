<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
| For contact details, see: http://www.openx.org/                           |
|                                                                           |
| This program is free software; you can redistribute it and/or modify      |
| it under the terms of the GNU General Public License as published by      |
| the Free Software Foundation; either version 2 of the License, or         |
| (at your option) any later version.                                       |
|                                                                           |
| This program is distributed in the hope that it will be useful,           |
| but WITHOUT ANY WARRANTY; without even the implied warranty of            |
| MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
| GNU General Public License for more details.                              |
|                                                                           |
| You should have received a copy of the GNU General Public License         |
| along with this program; if not, write to the Free Software               |
| Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA |
+---------------------------------------------------------------------------+
$Id$
*/



// Installer translation strings
$GLOBALS['strInstall']				= "설치";
$GLOBALS['strChooseInstallLanguage']		= "설치에 사용할 언어를 선택하세요.";
$GLOBALS['strLanguageSelection']		= "언어 선택";
$GLOBALS['strDatabaseSettings']			= "데이터베이스 설정";
$GLOBALS['strAdminSettings']			= "관리자 설정";
$GLOBALS['strAdvancedSettings']			= "고급 설정";
$GLOBALS['strOtherSettings']			= "기타 설정";

$GLOBALS['strWarning']				= "경고";
$GLOBALS['strFatalError']			= "치명적인 오류가 발생했습니다.";
$GLOBALS['strAlreadyInstalled']			= $phpAds_productname."이 이미 시스템에 설치되어 있습니다. 설정을 하려면 <a href='settings-index.php'>설정 인터페이스</a>를 사용하십시오.";
$GLOBALS['strCouldNotConnectToDB']		= "데이터베이스에 연결할 수 없습니다. 입력한 설정이 맞는지 다시 확인하십시오.";
$GLOBALS['strCreateTableTestFailed']		= "입력된 사용자는 데이터베이스 구조를 생성하거나 업데이트할 수 있는 권한이 없습니다. 데이터베이스 관리자에게 문의하십시오.";
$GLOBALS['strUpdateTableTestFailed']		= "입력된 사용자는 데이터베이스 구조를 업데이트할 수 있는 권한이 없습니다. 데이터베이스 관리자에게 문의하십시오..";
$GLOBALS['strTablePrefixInvalid']		= "테이블 접두어로 사용할 수 없는 문자가 있습니다.";
$GLOBALS['strTableInUse']			= "지정된 데이터베이스는 이미".$phpAds_productname."에서 사용하고 있습니다. 다른 테이블 접두어를 사용하거나 업그레이드 지침서를 참고하십시오.";
$GLOBALS['strMayNotFunction']			= "계속 진행하기 전에 문제를 수정하십시오. 문제를 수정하지 않고 진행하면 문제가 발생할 수 있습니다:";
$GLOBALS['strIgnoreWarnings']			= "경고 무시";
$GLOBALS['strWarningDBavailable']		= "현재 사용중인 PHP는 ".$phpAds_dbmsname." 연결을 지원하지 않습니다. PHP ".$phpAds_dbmsname." 확장을 설치한 다음에 계속 진행하십시오.";
$GLOBALS['strWarningPHPversion']		= $phpAds_productname." requires PHP 4.0 or higher to function correctly. You are currently using {php_version}.";
$GLOBALS['strWarningRegisterGlobals']		= "PHP 설정 변수 register_globals를 설정해야 합니다.";
$GLOBALS['strWarningMagicQuotesGPC']		= "PHP 설정 변수 magic_quotes_gpc를 설정해야 합니다.";
$GLOBALS['strWarningMagicQuotesRuntime']	= "PHP 설정 변수 magic_quotes_runtime을 제거해야합니다.";
$GLOBALS['strWarningFileUploads']		= "PHP 설정 변수 file_uploads를 설정해야 합니다.";
$GLOBALS['strConfigLockedDetected']		= $phpAds_productname." has detected that your <b>config.inc.php</b> file is not writeable by the server.<br> You can't proceed until you change permissions on the file. <br>Read the supplied documentation if you don't know how to do that.";
$GLOBALS['strCantUpdateDB']  			= "현재 데이터베이스를 갱신할 수 없습니다. 계속 진행하면 기존에 설정한 배너, 통계, 광고주가 모두 삭제됩니다.";
$GLOBALS['strTableNames']			= "테이블 이름";
$GLOBALS['strTablesPrefix']			= "테이블 접두어";
$GLOBALS['strTablesType']			= "테이블 종류";

$GLOBALS['strInstallWelcome']			= "환영합니다. ".$phpAds_productname;
$GLOBALS['strInstallMessage']			= "Before you can use ".$phpAds_productname." it needs to be configured and <br> the database needs to be created. Click <b>Proceed</b> to continue.";
$GLOBALS['strInstallSuccess']			= "<b>The installation of ".$phpAds_productname." is now complete.</b><br><br>In order for ".$phpAds_productname." to function correctly you also need\n						   to make sure the maintenance file is run every hour. More information about this subject can be found in the documentation.\n						   <br><br>Click <b>Proceed</b> to go the configuration page, where you can\n						   set up more settings. Please do not forget to lock the config.inc.php file when you are finished to prevent security\n						   breaches.";
$GLOBALS['strUpdateSuccess']			= "<b>The upgrade of ".$phpAds_productname." was succesfull.</b><br><br>In order for ".$phpAds_productname." to function correctly you also need\n						   to make sure the maintenance file is run every hour (previously this was every day). More information about this subject can be found in the documentation.\n						   <br><br>Click <b>Proceed</b> to go to the administration interface. Please do not forget to lock the config.inc.php file\n						   to prevent security breaches.";
$GLOBALS['strInstallNotSuccessful']		= "<b>The installation of ".$phpAds_productname." was not succesful</b><br><br>Some portions of the install process could not be completed.\n						   It is possible these problems are only temporarily, in that case you can simply click <b>Proceed</b> and return to the\n						   first step of the install process. If you want to know more on what the error message below means, and how to solve it,\n						   please consult the supplied documentation.";
$GLOBALS['strErrorOccured']			= "다음 오류가 발생했습니다:";
$GLOBALS['strErrorInstallDatabase']		= "데이터베이스 구조가 생성되지 않았습니다.";
$GLOBALS['strErrorInstallConfig']		= "설정 파일 또는 데이터베이스를 업데이트할 수 없습니다.";
$GLOBALS['strErrorInstallDbConnect']		= "데이터베이스와 연결할 수 없습니다.";

$GLOBALS['strUrlPrefix']			= "URL 접두어";

$GLOBALS['strProceed']				= "계속 >";
$GLOBALS['strRepeatPassword']			= "비밀번호 확인";
$GLOBALS['strNotSamePasswords']			= "비밀번호가 일치하지 않습니다.";
$GLOBALS['strInvalidUserPwd']			= "잘못된 사용자 ID 또는 비밀번호입니다.";

$GLOBALS['strUpgrade']				= "업그레이드";
$GLOBALS['strSystemUpToDate']			= "시스템의 구성요소가 이미 최신 버전입니다. 지금 업그레이드할 수 없습니다.<br> 홈페이지로 이동하려면 <b>계속</b>을 클릭하세요.";
$GLOBALS['strSystemNeedsUpgrade']		= "시스템이 올바르게 동작하려면 데이터베이스 구조와 설정 파일을 업그레이드해야 합니다. 시스템을 업그레이드하기 위해 <b>계속</b>을 클릭하십시오.<br>시스템을 업그레이드하는 데 몇 분 정도 걸릴 수 있습니다.";
$GLOBALS['strSystemUpgradeBusy']		= "시스템을 업그레이드중입니다. 잠시 기다려주십시오...";
$GLOBALS['strSystemRebuildingCache']		= "캐시를 재구축중입니다. 잠시 기다려주십시오...";
$GLOBALS['strServiceUnavalable']		= "시스템을 업그레이드 중이므로 서비스를 잠시동안 이용할 수 없습니다.";

$GLOBALS['strConfigNotWritable']		= "config.inc.php 파일에 쓰기를 할 수 없습니다.";





/*********************************************************/
/* Configuration translations                            */
/*********************************************************/

// Global
$GLOBALS['strChooseSection']			= "영역 선택";
$GLOBALS['strDayFullNames'][0] = "일요일";
$GLOBALS['strDayFullNames'][1] = "월요일";
$GLOBALS['strDayFullNames'][2] = "화요일";
$GLOBALS['strDayFullNames'][3] = "수요일";
$GLOBALS['strDayFullNames'][4] = "목요일";
$GLOBALS['strDayFullNames'][5] = "금요일";
$GLOBALS['strDayFullNames'][6] = "토요일";

$GLOBALS['strEditConfigNotPossible']   		= "보안상 설정 파일이 잠겨있기 때문이 설정을 변경할 수 없습니다. \n설정을 변경하려면 config.inc.php 파일의 잠금을 해제하십시오.\n";
$GLOBALS['strEditConfigPossible']		= "설정 파일이 잠겨있지 않기 때문에 모든 설정을 편집하는 것이 가능하지만, 이로인해 보안 문제가 발생할 수 있습니다.\n시스템을 안전하게 하려면 config.inc.php 파일에 잠금을 설정해야 합니다.\n";



// Database
$GLOBALS['strDatabaseSettings']			= "데이터베이스 설정";
$GLOBALS['strDatabaseServer']			= "데이터베이스 서버";
$GLOBALS['strDbHost']				= "데이터베이스 호스트명";
$GLOBALS['strDbUser']				= "데이터베이스 사용자이름";
$GLOBALS['strDbPassword']			= "데이터베이스 비밀번호";
$GLOBALS['strDbName']				= "데이터베이스 이름";

$GLOBALS['strDatabaseOptimalisations']		= "데이터베이스 최적화";
$GLOBALS['strPersistentConnections']		= "연결 유지(persistent connection) 사용";
$GLOBALS['strInsertDelayed']			= "지연된 삽입 사용";
$GLOBALS['strCompatibilityMode']		= "데이터베이스 호환 모드 사용";
$GLOBALS['strCantConnectToDb']			= "데이터베이스에 연결할 수 없습니다.";



// Invocation and Delivery
$GLOBALS['strInvocationAndDelivery']		= "배너 호출 및 전달유지 설정";

$GLOBALS['strAllowedInvocationTypes']		= "허용된 배너 호출 종류";
$GLOBALS['strAllowRemoteInvocation']		= "원격 배너 호출 허용";
$GLOBALS['strAllowRemoteJavascript']		= "원격 배너 호출 허용(Javascript)";
$GLOBALS['strAllowRemoteFrames']		= "원격 배너 호출 허용(프레임)";
$GLOBALS['strAllowRemoteXMLRPC']		= "배너 호출 허용(XML-RPC)";
$GLOBALS['strAllowLocalmode']			= "로컬 모드 허용";
$GLOBALS['strAllowInterstitial']		= "격자형(Interstitial) 허용";
$GLOBALS['strAllowPopups']			= "팝업 허용";

$GLOBALS['strUseAcl']				= "배너 전송중에 전달 유지 제한 평가";

$GLOBALS['strDeliverySettings']			= "전달 유지 설정";
$GLOBALS['strCacheType']				= "전달 유지 캐시 종류";
$GLOBALS['strCacheFiles']				= "파일";
$GLOBALS['strCacheDatabase']			= "데이터베이스";
$GLOBALS['strCacheShmop']				= "공유 메모리(shmop)";
$GLOBALS['strKeywordRetrieval']			= "키워드 검색";
$GLOBALS['strBannerRetrieval']			= "배너 검색 방법";
$GLOBALS['strRetrieveRandom']			= "랜덤 배너 검색(기본)";
$GLOBALS['strRetrieveNormalSeq']		= "배너 검색(일반)";
$GLOBALS['strWeightSeq']			= "가중치로 배너 검색";
$GLOBALS['strFullSeq']				= "전체 배너 검색";
$GLOBALS['strUseConditionalKeys']		= "직접 선택을 사용할 때 논리 연산자를 허용합니다.";
$GLOBALS['strUseMultipleKeys']			= "직접 선택을 사용할 때 다수의 키워드를 허용합니다.";

$GLOBALS['strZonesSettings']			= "영역 검색";
$GLOBALS['strZoneCache']			= "캐시 영역, 캐시 영역을 사용하면 영역을 사용할 때 속도를 빠르게 합니다.";
$GLOBALS['strZoneCacheLimit']			= "캐시 업데이트 간격(초 단위)";
$GLOBALS['strZoneCacheLimitErr']		= "업데이트 간격에는 음수를 사용할 수 없습니다.";

$GLOBALS['strP3PSettings']			= "P3P 개인 보호 정책";
$GLOBALS['strUseP3P']				= "P3P 정책 사용";
$GLOBALS['strP3PCompactPolicy']			= "P3P Compact 정책";
$GLOBALS['strP3PPolicyLocation']		= "P3P 정책 위치";



// Banner Settings
$GLOBALS['strBannerSettings']			= "배너 설정";

$GLOBALS['strAllowedBannerTypes']		= "배너 형식";
$GLOBALS['strTypeSqlAllow']			= "로컬 배너(SQL) - DB 저장 방식";
$GLOBALS['strTypeWebAllow']			= "로컬 배너(웹서버) - 웹 저장 방식";
$GLOBALS['strTypeUrlAllow']			= "외부 배너";
$GLOBALS['strTypeHtmlAllow']			= "HTML 배너";
$GLOBALS['strTypeTxtAllow']			= "텍스트 광고";

$GLOBALS['strTypeWebSettings']			= "로컬 배너(웹서버) 설정";
$GLOBALS['strTypeWebMode']			= "저장 방법";
$GLOBALS['strTypeWebModeLocal']			= "로컬 디렉터리";
$GLOBALS['strTypeWebModeFtp']			= "외부 FTP 서버";
$GLOBALS['strTypeWebDir']			= "로컬 디렉터리";
$GLOBALS['strTypeWebFtp']			= "FTP 모드 웹 배너 서버";
$GLOBALS['strTypeWebUrl']			= "배너 URL";
$GLOBALS['strTypeFTPHost']			= "FTP 호스트";
$GLOBALS['strTypeFTPDirectory']			= "호스트 디렉터리";
$GLOBALS['strTypeFTPUsername']			= "로그인ID";
$GLOBALS['strTypeFTPPassword']			= "비밀번호";

$GLOBALS['strDefaultBanners']			= "기본 배너";
$GLOBALS['strDefaultBannerUrl']			= "기본 이미지 URL";
$GLOBALS['strDefaultBannerTarget']		= "기본 대상 URL";

$GLOBALS['strTypeHtmlSettings']			= "HTML 배너 옵션";
$GLOBALS['strTypeHtmlAuto']			= "클릭 트래킹을 강제 수행하기 위해 HTML 배너를 자동으로 변경합니다.";
$GLOBALS['strTypeHtmlPhp']			= "HTML 배너안에서 PHP 코드를 실행합니다.";



// Statistics Settings
$GLOBALS['strStatisticsSettings']		= "통계 설정";

$GLOBALS['strStatisticsFormat']			= "통계 형식";
$GLOBALS['strLogBeacon']			= "AdViews를 기록하기 위해 투명 이미지를 사용합니다.";
$GLOBALS['strCompactStats']			= "간단한 통계를 사용합니다.";
$GLOBALS['strLogAdviews']			= "AdViews 로그";
$GLOBALS['strBlockAdviews']			= "복수 로그 금지(초)";
$GLOBALS['strLogAdclicks']			= "AdClicks 로그";
$GLOBALS['strBlockAdclicks']			= "복수 로그 금지(초)";

$GLOBALS['strGeotargeting']			= "지역 정보 중심(Geotargeting)";
$GLOBALS['strGeotrackingType']			= "지역 정보 데이터베이스 종류";
$GLOBALS['strGeotrackingLocation'] 		= "지역 정보 데이터베이스 위치";
$GLOBALS['strGeoLogStats']			= "방문자 국적을 통계에 기록합니다.";
$GLOBALS['strGeoStoreCookie']		= "나중에 참조하기 위해 쿠키에 결과를 저장합니다.";

$GLOBALS['strEmailWarnings']			= "이메일 경고";
$GLOBALS['strAdminEmailHeaders']		= "일일 광고 보고서의 발송자에 대한 정보를 메일 헤더에 포함합니다.";
$GLOBALS['strWarnLimit']			= "경고횟수 제한(Warn Limit)";
$GLOBALS['strWarnLimitErr']			= "경고횟수 제한(Warn Limit)은 음수를 사용할 수 없습니다.";
$GLOBALS['strWarnAdmin']			= "관리자에게 경고를 알립니다.";
$GLOBALS['strWarnClient']			= "광고주에게 경고를 알립니다.";
$GLOBALS['strQmailPatch']			= "qmail 패치를 사용합니다.(qmail을 사용하는 경우)";

$GLOBALS['strRemoteHosts']			= "원격 호스트";
$GLOBALS['strIgnoreHosts']			= "무시할 호스트";
$GLOBALS['strReverseLookup']			= "DNS 역참조";
$GLOBALS['strProxyLookup']			= "프록시 참조";

$GLOBALS['strAutoCleanTables']			= "데이터베이스 정리";
$GLOBALS['strAutoCleanStats']			= "통계 정리";
$GLOBALS['strAutoCleanUserlog']			= "사용자 로그 정리";
$GLOBALS['strAutoCleanStatsWeeks']		= "다음보다 오래된 통계 덮어쓰기<br>(최소 3주)";
$GLOBALS['strAutoCleanUserlogWeeks']		= "다음보다 오래된 사용자 로그 덮어쓰기<br>(최소 3주)";
$GLOBALS['strAutoCleanErr']			= "최대 보존 기간은 3주 이상이어야합니다.";
$GLOBALS['strAutoCleanVacuum']			= "VACUUM ANALYZE tables every night"; // only Pg


// Administrator settings
$GLOBALS['strAdministratorSettings']		= "관리자 설정";

$GLOBALS['strLoginCredentials']			= "로그인 정보";
$GLOBALS['strAdminUsername']			= "관리자 ID";
$GLOBALS['strOldPassword']			= "기존 비밀번호";
$GLOBALS['strNewPassword']			= "새 비밀번호";
$GLOBALS['strInvalidUsername']			= "잘못된 ID";
$GLOBALS['strInvalidPassword']			= "잘못된 비밀번호";

$GLOBALS['strBasicInformation']			= "기본 정보";
$GLOBALS['strAdminFullName']			= "관리자 전체 이름";
$GLOBALS['strAdminEmail']			= "관리자 이메일";
$GLOBALS['strCompanyName']			= "회사 이름";

$GLOBALS['strAdminCheckUpdates']		= "업데이트 검색";
$GLOBALS['strAdminCheckEveryLogin']		= "로긴마다";
$GLOBALS['strAdminCheckDaily']			= "일일";
$GLOBALS['strAdminCheckWeekly']			= "주간";
$GLOBALS['strAdminCheckMonthly']		= "월간";
$GLOBALS['strAdminCheckNever']			= "안함";

$GLOBALS['strAdminNovice']			= "안전을 위해 관리자가 삭제하기 전에 확인합니다.";
$GLOBALS['strUserlogEmail']			= "모든 외부 발송 이메일 메시지를 기록합니다.";
$GLOBALS['strUserlogPriority']			= "매시간마다 우선순위 계산을 기록합니다.";
$GLOBALS['strUserlogAutoClean']			= "데이터베이스 자동 정리를 기록합니다.";


// User interface settings
$GLOBALS['strGuiSettings']			= "사용자 인터페이스 설정";

$GLOBALS['strGeneralSettings']			= "일반 설정";
$GLOBALS['strAppName']				= "응용 프로그램 이름";
$GLOBALS['strMyHeader']				= "내 머리글";
$GLOBALS['strMyFooter']				= "내 바닥글";
$GLOBALS['strGzipContentCompression']		= "컨텐트 GZIP 압축 사용";

$GLOBALS['strClientInterface']			= "광고주 인터페이스";
$GLOBALS['strClientWelcomeEnabled']		= "광고주 환영 메시지를 사용합니다.";
$GLOBALS['strClientWelcomeText']		= "환영 메시지<br>(HTML 태그 가능)";



// Interface defaults
$GLOBALS['strInterfaceDefaults']		= "기본 인터페이스 설정";

$GLOBALS['strInventory']			= "목록";
$GLOBALS['strShowCampaignInfo']			= "<i>캠페인 목록</i> 페이지에 캠페인 정보를 자세히 보여줍니다.";
$GLOBALS['strShowBannerInfo']			= "<i>배너 목록</i> 페이지에 배너 정보를 자세히 보여줍니다.";
$GLOBALS['strShowCampaignPreview']		= "<i>배너 목록</i> 페이지에 배너의 미리보기를 모두 표시합니다.";
$GLOBALS['strShowBannerHTML']			= "HTML 코드 대신에 실제 배너를 표시합니다.";
$GLOBALS['strShowBannerPreview']		= "배너 처리 화면에서 페이지 상단에 배너 미리보기를 표시합니다.";
$GLOBALS['strHideInactive']			= "사용하지 않는 항목을 모든 목록 페이지에서 숨깁니다.";
$GLOBALS['strGUIShowMatchingBanners']		= "<i>연결된 배너</i> 페이지에 해당 배너를 표시합니다.";
$GLOBALS['strGUIShowParentCampaigns']		= "<i>연결된 배너</i> 페이지에 해당하는 상위 켐페인을 표시합니다.";
$GLOBALS['strGUILinkCompactLimit']		= "<i>항목이 많은 경우에는 <i>연결된 배너</i> 페이지에 연결된 캠페인이 없는 배너는 숨깁니다.";

$GLOBALS['strStatisticsDefaults'] 		= "통계";
$GLOBALS['strBeginOfWeek']			= "한 주의 시작일";
$GLOBALS['strPercentageDecimals']		= "백분율 소수점";

$GLOBALS['strWeightDefaults']			= "가중치 기본설정";
$GLOBALS['strDefaultBannerWeight']		= "배너 가중치 기본값";
$GLOBALS['strDefaultCampaignWeight']		= "캠페인 가중치 기본값";
$GLOBALS['strDefaultBannerWErr']		= "배너 가중치의 기본값은 정수를 입력해야합니다.";
$GLOBALS['strDefaultCampaignWErr']		= "캠페인 가중치의 기본값은 정수를 입력해야합니다.";



// Not used at the moment
$GLOBALS['strTableBorderColor']			= "테이블 테두리 색상";
$GLOBALS['strTableBackColor']			= "테이블 배경 색상";
$GLOBALS['strTableBackColorAlt']		= "테이블 배경 색상(Alternative)";
$GLOBALS['strMainBackColor']			= "주 배경 색상";
$GLOBALS['strOverrideGD']			= "GD 이미지 포맷을 무시합니다.";
$GLOBALS['strTimeZone']				= "시간 영역";



// Note: New translations not found in original lang files but found in CSV
$GLOBALS['strDbSetupTitle'] = "데이터베이스 설정";
$GLOBALS['strDeliveryUrlPrefix'] = "전달유지 엔진";
$GLOBALS['strDeliveryUrlPrefixSSL'] = "전달유지 엔진";
$GLOBALS['strDbType'] = "데이터베이스 이름";
$GLOBALS['strDeliveryPath'] = "전달유지 캐시";
$GLOBALS['strDeliverySslPath'] = "전달유지 캐시";
$GLOBALS['strGeotargetingSettings'] = "지역 정보 중심(Geotargeting)";
$GLOBALS['strWarnAgency'] = "광고주에게 경고를 알립니다.";
$GLOBALS['strEnableQmailPatch'] = "qmail 패치를 사용합니다.(qmail을 사용하는 경우)";
$GLOBALS['strEmailSettings'] = "설정";
?>