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
$GLOBALS['strInstall']				= "설치";
$GLOBALS['strChooseInstallLanguage']		= "설치�? 사용할 언어를 선�?하세요.";
$GLOBALS['strLanguageSelection']		= "언어 선�?";
$GLOBALS['strDatabaseSettings']			= "�?��?�터베�?�스 설정";
$GLOBALS['strAdminSettings']			= "관리�? 설정";
$GLOBALS['strAdvancedSettings']			= "고급 설정";
$GLOBALS['strOtherSettings']			= "기타 설정";

$GLOBALS['strWarning']				= "경고";
$GLOBALS['strFatalError']			= "치명�?�?� 오류가 발�?했습니다.";
$GLOBALS['strAlreadyInstalled']			= MAX_PRODUCT_NAME."�?� �?�미 시스템�? 설치�?�어 있습니다. 설정�?� 하려면 <a href='settings-index.php'>설정 �?�터페�?�스</a>를 사용하십시오.";
$GLOBALS['strCouldNotConnectToDB']		= "�?��?�터베�?�스�? 연결할 수 없습니다. 입력한 설정�?� 맞는지 다시 확�?�하십시오.";
$GLOBALS['strCreateTableTestFailed']		= "입력�?� 사용�?는 �?��?�터베�?�스 구조를 �?성하거나 업�?��?�트할 수 있는 권한�?� 없습니다. �?��?�터베�?�스 관리�?�?게 문�?�하십시오.";
$GLOBALS['strUpdateTableTestFailed']		= "입력�?� 사용�?는 �?��?�터베�?�스 구조를 업�?��?�트할 수 있는 권한�?� 없습니다. �?��?�터베�?�스 관리�?�?게 문�?�하십시오..";
$GLOBALS['strTablePrefixInvalid']		= "테�?�블 접�?어로 사용할 수 없는 문�?가 있습니다.";
$GLOBALS['strTableInUse']			= "지정�?� �?��?�터베�?�스는 �?�미".MAX_PRODUCT_NAME."�?서 사용하고 있습니다. 다른 테�?�블 접�?어를 사용하거나 업그레�?�드 지침서를 참고하십시오.";
$GLOBALS['strMayNotFunction']			= "계�? 진행하기 전�? 문제를 수정하십시오. 문제를 수정하지 않고 진행하면 문제가 발�?할 수 있습니다:";
$GLOBALS['strIgnoreWarnings']			= "경고 무시";
$GLOBALS['strWarningDBavailable']		= "현재 사용중�?� PHP는 ".$phpAds_dbmsname." 연결�?� 지�?하지 않습니다. PHP ".$phpAds_dbmsname." 확장�?� 설치한 다�?��? 계�? 진행하십시오.";
$GLOBALS['strWarningPHPversion']		= MAX_PRODUCT_NAME." requires PHP 4.0 or higher to function correctly. You are currently using {php_version}.";
$GLOBALS['strWarningRegisterGlobals']		= "PHP 설정 변수 register_globals를 설정해야 합니다.";
$GLOBALS['strWarningMagicQuotesGPC']		= "PHP 설정 변수 magic_quotes_gpc를 설정해야 합니다.";
$GLOBALS['strWarningMagicQuotesRuntime']	= "PHP 설정 변수 magic_quotes_runtime�?� 제거해야합니다.";
$GLOBALS['strWarningFileUploads']		= "PHP 설정 변수 file_uploads를 설정해야 합니다.";
$GLOBALS['strConfigLockedDetected']		= MAX_PRODUCT_NAME." has detected that your <b>config.inc.php</b> file is not writeable by the server.<br> You can't proceed until you change permissions on the file. <br>Read the supplied documentation if you don't know how to do that.";
$GLOBALS['strCantUpdateDB']  			= "현재 �?��?�터베�?�스를 갱신할 수 없습니다. 계�? 진행하면 기존�? 설정한 배너, 통계, 광고주가 모�? 삭제�?�니다.";
$GLOBALS['strTableNames']			= "테�?�블 �?�름";
$GLOBALS['strTablesPrefix']			= "테�?�블 접�?어";
$GLOBALS['strTablesType']			= "테�?�블 종류";

$GLOBALS['strInstallWelcome']			= "환�?합니다. ".MAX_PRODUCT_NAME;
$GLOBALS['strInstallMessage']			= "Before you can use ".MAX_PRODUCT_NAME." it needs to be configured and <br> the database needs to be created. Click <b>Proceed</b> to continue.";
$GLOBALS['strInstallSuccess']			= "<b>The installation of ".MAX_PRODUCT_NAME." is now complete.</b><br><br>In order for ".MAX_PRODUCT_NAME." to function correctly you also need\n						   to make sure the maintenance file is run every hour. More information about this subject can be found in the documentation.\n						   <br><br>Click <b>Proceed</b> to go the configuration page, where you can\n						   set up more settings. Please do not forget to lock the config.inc.php file when you are finished to prevent security\n						   breaches.";
$GLOBALS['strUpdateSuccess']			= "<b>The upgrade of ".MAX_PRODUCT_NAME." was succesfull.</b><br><br>In order for ".MAX_PRODUCT_NAME." to function correctly you also need\n						   to make sure the maintenance file is run every hour (previously this was every day). More information about this subject can be found in the documentation.\n						   <br><br>Click <b>Proceed</b> to go to the administration interface. Please do not forget to lock the config.inc.php file\n						   to prevent security breaches.";
$GLOBALS['strInstallNotSuccessful']		= "<b>The installation of ".MAX_PRODUCT_NAME." was not succesful</b><br><br>Some portions of the install process could not be completed.\n						   It is possible these problems are only temporarily, in that case you can simply click <b>Proceed</b> and return to the\n						   first step of the install process. If you want to know more on what the error message below means, and how to solve it,\n						   please consult the supplied documentation.";
$GLOBALS['strErrorOccured']			= "다�?� 오류가 발�?했습니다:";
$GLOBALS['strErrorInstallDatabase']		= "�?��?�터베�?�스 구조가 �?성�?�지 않았습니다.";
$GLOBALS['strErrorInstallConfig']		= "설정 파�?� �?는 �?��?�터베�?�스를 업�?��?�트할 수 없습니다.";
$GLOBALS['strErrorInstallDbConnect']		= "�?��?�터베�?�스와 연결할 수 없습니다.";

$GLOBALS['strUrlPrefix']			= "URL 접�?어";

$GLOBALS['strProceed']				= "계�? >";
$GLOBALS['strRepeatPassword']			= "비밀번호 확�?�";
$GLOBALS['strNotSamePasswords']			= "비밀번호가 �?�치하지 않습니다.";
$GLOBALS['strInvalidUserPwd']			= "잘못�?� 사용�? ID �?는 비밀번호입니다.";

$GLOBALS['strUpgrade']				= "업그레�?�드";
$GLOBALS['strSystemUpToDate']			= "시스템�?� 구성요소가 �?�미 최신 버전입니다. 지금 업그레�?�드할 수 없습니다.<br> 홈페�?�지로 �?��?�하려면 <b>계�?</b>�?� �?�릭하세요.";
$GLOBALS['strSystemNeedsUpgrade']		= "시스템�?� 올바르게 �?�작하려면 �?��?�터베�?�스 구조와 설정 파�?��?� 업그레�?�드해야 합니다. 시스템�?� 업그레�?�드하기 위해 <b>계�?</b>�?� �?�릭하십시오.<br>시스템�?� 업그레�?�드하는 �?� 몇 분 정�?� 걸릴 수 있습니다.";
$GLOBALS['strSystemUpgradeBusy']		= "시스템�?� 업그레�?�드중입니다. 잠시 기다려주십시오...";
$GLOBALS['strSystemRebuildingCache']		= "�?시를 재구축중입니다. 잠시 기다려주십시오...";
$GLOBALS['strServiceUnavalable']		= "시스템�?� 업그레�?�드 중�?�므로 서비스를 잠시�?�안 �?�용할 수 없습니다.";

$GLOBALS['strConfigNotWritable']		= "config.inc.php 파�?��? 쓰기를 할 수 없습니다.";





/*********************************************************/
/* Configuration translations                            */
/*********************************************************/

// Global
$GLOBALS['strChooseSection']			= "�?역 선�?";
$GLOBALS['strDayFullNames'][0] = "�?�요�?�";
$GLOBALS['strDayFullNames'][1] = "월요�?�";
$GLOBALS['strDayFullNames'][2] = "화요�?�";
$GLOBALS['strDayFullNames'][3] = "수요�?�";
$GLOBALS['strDayFullNames'][4] = "목요�?�";
$GLOBALS['strDayFullNames'][5] = "금요�?�";
$GLOBALS['strDayFullNames'][6] = "토요�?�";

$GLOBALS['strEditConfigNotPossible']   		= "보안�? 설정 파�?��?� 잠겨있기 때문�?� 설정�?� 변경할 수 없습니다. \n설정�?� 변경하려면 config.inc.php 파�?��?� 잠금�?� 해제하십시오.\n";
$GLOBALS['strEditConfigPossible']		= "설정 파�?��?� 잠겨있지 않기 때문�? 모든 설정�?� 편집하는 것�?� 가능하지만, �?�로�?�해 보안 문제가 발�?할 수 있습니다.\n시스템�?� 안전하게 하려면 config.inc.php 파�?��? 잠금�?� 설정해야 합니다.\n";



// Database
$GLOBALS['strDatabaseSettings']			= "�?��?�터베�?�스 설정";
$GLOBALS['strDatabaseServer']			= "�?��?�터베�?�스 서버";
$GLOBALS['strDbHost']				= "�?��?�터베�?�스 호스트명";
$GLOBALS['strDbUser']				= "�?��?�터베�?�스 사용�?�?�름";
$GLOBALS['strDbPassword']			= "�?��?�터베�?�스 비밀번호";
$GLOBALS['strDbName']				= "�?��?�터베�?�스 �?�름";

$GLOBALS['strDatabaseOptimalisations']		= "�?��?�터베�?�스 최�?화";
$GLOBALS['strPersistentConnections']		= "연결 유지(persistent connection) 사용";
$GLOBALS['strInsertDelayed']			= "지연�?� 삽입 사용";
$GLOBALS['strCompatibilityMode']		= "�?��?�터베�?�스 호환 모드 사용";
$GLOBALS['strCantConnectToDb']			= "�?��?�터베�?�스�? 연결할 수 없습니다.";



// Invocation and Delivery
$GLOBALS['strInvocationAndDelivery']		= "배너 호출 �? 전달유지 설정";

$GLOBALS['strAllowedInvocationTypes']		= "허용�?� 배너 호출 종류";
$GLOBALS['strAllowRemoteInvocation']		= "�?격 배너 호출 허용";
$GLOBALS['strAllowRemoteJavascript']		= "�?격 배너 호출 허용(Javascript)";
$GLOBALS['strAllowRemoteFrames']		= "�?격 배너 호출 허용(프레임)";
$GLOBALS['strAllowRemoteXMLRPC']		= "배너 호출 허용(XML-RPC)";
$GLOBALS['strAllowLocalmode']			= "로컬 모드 허용";
$GLOBALS['strAllowInterstitial']		= "격�?형(Interstitial) 허용";
$GLOBALS['strAllowPopups']			= "�?업 허용";

$GLOBALS['strUseAcl']				= "배너 전송중�? 전달 유지 제한 �?�가";

$GLOBALS['strDeliverySettings']			= "전달 유지 설정";
$GLOBALS['strCacheType']				= "전달 유지 �?시 종류";
$GLOBALS['strCacheFiles']				= "파�?�";
$GLOBALS['strCacheDatabase']			= "�?��?�터베�?�스";
$GLOBALS['strCacheShmop']				= "공유 메모리(shmop)";
$GLOBALS['strKeywordRetrieval']			= "키워드 검색";
$GLOBALS['strBannerRetrieval']			= "배너 검색 방법";
$GLOBALS['strRetrieveRandom']			= "랜�?� 배너 검색(기본)";
$GLOBALS['strRetrieveNormalSeq']		= "배너 검색(�?�반)";
$GLOBALS['strWeightSeq']			= "가중치로 배너 검색";
$GLOBALS['strFullSeq']				= "전체 배너 검색";
$GLOBALS['strUseConditionalKeys']		= "�?접 선�?�?� 사용할 때 논리 연산�?를 허용합니다.";
$GLOBALS['strUseMultipleKeys']			= "�?접 선�?�?� 사용할 때 다수�?� 키워드를 허용합니다.";

$GLOBALS['strZonesSettings']			= "�?역 검색";
$GLOBALS['strZoneCache']			= "�?시 �?역, �?시 �?역�?� 사용하면 �?역�?� 사용할 때 �?�?�를 빠르게 합니다.";
$GLOBALS['strZoneCacheLimit']			= "�?시 업�?��?�트 간격(초 단위)";
$GLOBALS['strZoneCacheLimitErr']		= "업�?��?�트 간격�?는 �?�수를 사용할 수 없습니다.";

$GLOBALS['strP3PSettings']			= "P3P 개�?� 보호 정책";
$GLOBALS['strUseP3P']				= "P3P 정책 사용";
$GLOBALS['strP3PCompactPolicy']			= "P3P Compact 정책";
$GLOBALS['strP3PPolicyLocation']		= "P3P 정책 위치";



// Banner Settings
$GLOBALS['strBannerSettings']			= "배너 설정";

$GLOBALS['strAllowedBannerTypes']		= "배너 형�?";
$GLOBALS['strTypeSqlAllow']			= "로컬 배너(SQL) - DB 저장 방�?";
$GLOBALS['strTypeWebAllow']			= "로컬 배너(웹서버) - 웹 저장 방�?";
$GLOBALS['strTypeUrlAllow']			= "외부 배너";
$GLOBALS['strTypeHtmlAllow']			= "HTML 배너";
$GLOBALS['strTypeTxtAllow']			= "�?스트 광고";

$GLOBALS['strTypeWebSettings']			= "로컬 배너(웹서버) 설정";
$GLOBALS['strTypeWebMode']			= "저장 방법";
$GLOBALS['strTypeWebModeLocal']			= "로컬 디렉터리";
$GLOBALS['strTypeWebModeFtp']			= "외부 FTP 서버";
$GLOBALS['strTypeWebDir']			= "로컬 디렉터리";
$GLOBALS['strTypeWebFtp']			= "FTP 모드 웹 배너 서버";
$GLOBALS['strTypeWebUrl']			= "배너 URL";
$GLOBALS['strTypeFTPHost']			= "FTP 호스트";
$GLOBALS['strTypeFTPDirectory']			= "호스트 디렉터리";
$GLOBALS['strTypeFTPUsername']			= "로그�?�ID";
$GLOBALS['strTypeFTPPassword']			= "비밀번호";

$GLOBALS['strDefaultBanners']			= "기본 배너";
$GLOBALS['strDefaultBannerUrl']			= "기본 �?�미지 URL";
$GLOBALS['strDefaultBannerTarget']		= "기본 대�? URL";

$GLOBALS['strTypeHtmlSettings']			= "HTML 배너 옵션";
$GLOBALS['strTypeHtmlAuto']			= "�?�릭 트래킹�?� 강제 수행하기 위해 HTML 배너를 �?�?�으로 변경합니다.";
$GLOBALS['strTypeHtmlPhp']			= "HTML 배너안�?서 PHP 코드를 실행합니다.";



// Statistics Settings
$GLOBALS['strStatisticsSettings']		= "통계 설정";

$GLOBALS['strStatisticsFormat']			= "통계 형�?";
$GLOBALS['strLogBeacon']			= "AdViews를 기�?하기 위해 투명 �?�미지를 사용합니다.";
$GLOBALS['strCompactStats']			= "간단한 통계를 사용합니다.";
$GLOBALS['strLogAdviews']			= "AdViews 로그";
$GLOBALS['strBlockAdviews']			= "복수 로그 금지(초)";
$GLOBALS['strLogAdclicks']			= "AdClicks 로그";
$GLOBALS['strBlockAdclicks']			= "복수 로그 금지(초)";

$GLOBALS['strGeotargeting']			= "지역 정보 중심(Geotargeting)";
$GLOBALS['strGeotrackingType']			= "지역 정보 �?��?�터베�?�스 종류";
$GLOBALS['strGeotrackingLocation'] 		= "지역 정보 �?��?�터베�?�스 위치";
$GLOBALS['strGeoLogStats']			= "방문�? 국�?�?� 통계�? 기�?합니다.";
$GLOBALS['strGeoStoreCookie']		= "나중�? 참조하기 위해 쿠키�? 결과를 저장합니다.";

$GLOBALS['strEmailWarnings']			= "�?�메�?� 경고";
$GLOBALS['strAdminEmailHeaders']		= "�?��?� 광고 보고서�?� 발송�?�? 대한 정보를 메�?� 헤�?��? �?�함합니다.";
$GLOBALS['strWarnLimit']			= "경고횟수 제한(Warn Limit)";
$GLOBALS['strWarnLimitErr']			= "경고횟수 제한(Warn Limit)�?� �?�수를 사용할 수 없습니다.";
$GLOBALS['strWarnAdmin']			= "관리�?�?게 경고를 알립니다.";
$GLOBALS['strWarnClient']			= "광고주�?게 경고를 알립니다.";
$GLOBALS['strQmailPatch']			= "qmail 패치를 사용합니다.(qmail�?� 사용하는 경우)";

$GLOBALS['strRemoteHosts']			= "�?격 호스트";
$GLOBALS['strIgnoreHosts']			= "무시할 호스트";
$GLOBALS['strReverseLookup']			= "DNS 역참조";
$GLOBALS['strProxyLookup']			= "프�?시 참조";

$GLOBALS['strAutoCleanTables']			= "�?��?�터베�?�스 정리";
$GLOBALS['strAutoCleanStats']			= "통계 정리";
$GLOBALS['strAutoCleanUserlog']			= "사용�? 로그 정리";
$GLOBALS['strAutoCleanStatsWeeks']		= "다�?�보다 오래�?� 통계 �?�어쓰기<br>(최소 3주)";
$GLOBALS['strAutoCleanUserlogWeeks']		= "다�?�보다 오래�?� 사용�? 로그 �?�어쓰기<br>(최소 3주)";
$GLOBALS['strAutoCleanErr']			= "최대 보존 기간�?� 3주 �?��?�?�어야합니다.";
$GLOBALS['strAutoCleanVacuum']			= "VACUUM ANALYZE tables every night"; // only Pg


// Administrator settings
$GLOBALS['strAdministratorSettings']		= "관리�? 설정";

$GLOBALS['strLoginCredentials']			= "로그�?� 정보";
$GLOBALS['strAdminUsername']			= "관리�? ID";
$GLOBALS['strOldPassword']			= "기존 비밀번호";
$GLOBALS['strNewPassword']			= "새 비밀번호";
$GLOBALS['strInvalidUsername']			= "잘못�?� ID";
$GLOBALS['strInvalidPassword']			= "잘못�?� 비밀번호";

$GLOBALS['strBasicInformation']			= "기본 정보";
$GLOBALS['strAdminFullName']			= "관리�? 전체 �?�름";
$GLOBALS['strAdminEmail']			= "관리�? �?�메�?�";
$GLOBALS['strCompanyName']			= "회사 �?�름";

$GLOBALS['strAdminCheckUpdates']		= "업�?��?�트 검색";
$GLOBALS['strAdminCheckEveryLogin']		= "로긴마다";
$GLOBALS['strAdminCheckDaily']			= "�?��?�";
$GLOBALS['strAdminCheckWeekly']			= "주간";
$GLOBALS['strAdminCheckMonthly']		= "월간";
$GLOBALS['strAdminCheckNever']			= "안함";

$GLOBALS['strAdminNovice']			= "안전�?� 위해 관리�?가 삭제하기 전�? 확�?�합니다.";
$GLOBALS['strUserlogEmail']			= "모든 외부 발송 �?�메�?� 메시지를 기�?합니다.";
$GLOBALS['strUserlogPriority']			= "매시간마다 우선순위 계산�?� 기�?합니다.";
$GLOBALS['strUserlogAutoClean']			= "�?��?�터베�?�스 �?�?� 정리를 기�?합니다.";


// User interface settings
$GLOBALS['strGuiSettings']			= "사용�? �?�터페�?�스 설정";

$GLOBALS['strGeneralSettings']			= "�?�반 설정";
$GLOBALS['strAppName']				= "�?�용 프로그램 �?�름";
$GLOBALS['strMyHeader']				= "내 머리글";
$GLOBALS['strMyFooter']				= "내 바닥글";
$GLOBALS['strGzipContentCompression']		= "컨�?트 GZIP 압축 사용";

$GLOBALS['strClientInterface']			= "광고주 �?�터페�?�스";
$GLOBALS['strClientWelcomeEnabled']		= "광고주 환�? 메시지를 사용합니다.";
$GLOBALS['strClientWelcomeText']		= "환�? 메시지<br>(HTML 태그 가능)";



// Interface defaults
$GLOBALS['strInterfaceDefaults']		= "기본 �?�터페�?�스 설정";

$GLOBALS['strInventory']			= "목�?";
$GLOBALS['strShowCampaignInfo']			= "<i>캠페�?� 목�?</i> 페�?�지�? 캠페�?� 정보를 �?세히 보여�?니다.";
$GLOBALS['strShowBannerInfo']			= "<i>배너 목�?</i> 페�?�지�? 배너 정보를 �?세히 보여�?니다.";
$GLOBALS['strShowCampaignPreview']		= "<i>배너 목�?</i> 페�?�지�? 배너�?� 미리보기를 모�? 표시합니다.";
$GLOBALS['strShowBannerHTML']			= "HTML 코드 대신�? 실제 배너를 표시합니다.";
$GLOBALS['strShowBannerPreview']		= "배너 처리 화면�?서 페�?�지 �?단�? 배너 미리보기를 표시합니다.";
$GLOBALS['strHideInactive']			= "사용하지 않는 항목�?� 모든 목�? 페�?�지�?서 숨�?니다.";
$GLOBALS['strGUIShowMatchingBanners']		= "<i>연결�?� 배너</i> 페�?�지�? 해당 배너를 표시합니다.";
$GLOBALS['strGUIShowParentCampaigns']		= "<i>연결�?� 배너</i> 페�?�지�? 해당하는 �?위 �?페�?��?� 표시합니다.";
$GLOBALS['strGUILinkCompactLimit']		= "<i>항목�?� 많�?� 경우�?는 <i>연결�?� 배너</i> 페�?�지�? 연결�?� 캠페�?��?� 없는 배너는 숨�?니다.";

$GLOBALS['strStatisticsDefaults'] 		= "통계";
$GLOBALS['strBeginOfWeek']			= "한 주�?� 시작�?�";
$GLOBALS['strPercentageDecimals']		= "백분율 소수�?";

$GLOBALS['strWeightDefaults']			= "가중치 기본설정";
$GLOBALS['strDefaultBannerWeight']		= "배너 가중치 기본값";
$GLOBALS['strDefaultCampaignWeight']		= "캠페�?� 가중치 기본값";
$GLOBALS['strDefaultBannerWErr']		= "배너 가중치�?� 기본값�?� 정수를 입력해야합니다.";
$GLOBALS['strDefaultCampaignWErr']		= "캠페�?� 가중치�?� 기본값�?� 정수를 입력해야합니다.";



// Not used at the moment
$GLOBALS['strTableBorderColor']			= "테�?�블 테�?리 색�?";
$GLOBALS['strTableBackColor']			= "테�?�블 배경 색�?";
$GLOBALS['strTableBackColorAlt']		= "테�?�블 배경 색�?(Alternative)";
$GLOBALS['strMainBackColor']			= "주 배경 색�?";
$GLOBALS['strOverrideGD']			= "GD �?�미지 �?�맷�?� 무시합니다.";
$GLOBALS['strTimeZone']				= "시간 �?역";



// Note: New translations not found in original lang files but found in CSV
$GLOBALS['strDbSetupTitle'] = "�?��?�터베�?�스 설정";
$GLOBALS['strDeliveryUrlPrefix'] = "전달유지 엔진";
$GLOBALS['strDeliveryUrlPrefixSSL'] = "전달유지 엔진";
$GLOBALS['strDbType'] = "�?��?�터베�?�스 �?�름";
$GLOBALS['strDeliveryPath'] = "전달유지 �?시";
$GLOBALS['strDeliverySslPath'] = "전달유지 �?시";
$GLOBALS['strGeotargetingSettings'] = "지역 정보 중심(Geotargeting)";
$GLOBALS['strWarnAgency'] = "광고주�?게 경고를 알립니다.";
$GLOBALS['strEnableQmailPatch'] = "qmail 패치를 사용합니다.(qmail�?� 사용하는 경우)";
$GLOBALS['strEmailSettings'] = "설정";
?>