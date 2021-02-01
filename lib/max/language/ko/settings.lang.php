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
$GLOBALS['strAdminAccount'] = "System Administrator Account";
$GLOBALS['strAdvancedSettings'] = "고급 설정";
$GLOBALS['strWarning'] = "경고";
$GLOBALS['strBtnContinue'] = "Continue »";
$GLOBALS['strBtnRecover'] = "Recover »";
$GLOBALS['strBtnAgree'] = "I Agree »";
$GLOBALS['strBtnRetry'] = "Retry";
$GLOBALS['strWarningRegisterArgcArv'] = "The PHP configuration variable register_argc_argv needs to be turned on to run maintenance from the command line.";
$GLOBALS['strTablesPrefix'] = "Table names prefix";
$GLOBALS['strTablesType'] = "테�?�블 종류";

$GLOBALS['strRecoveryRequiredTitle'] = "Your previous upgrade attempt encountered an error";
$GLOBALS['strRecoveryRequired'] = "There was an error while processing your previous upgrade and {$PRODUCT_NAME} must attempt to recover the upgrade process. Please click the Recover button below.";

$GLOBALS['strProductUpToDateTitle'] = "{$PRODUCT_NAME} is up to date";
$GLOBALS['strOaUpToDate'] = "Your {$PRODUCT_NAME} database and file structure are both using the most recent version and therefore no upgrade is required at this time. Please click Continue to proceed to the administration panel.";
$GLOBALS['strOaUpToDateCantRemove'] = "The UPGRADE file is still present inside of your 'var' folder. We are unable to remove this file because of insufficient permissions. Please delete this file yourself.";
$GLOBALS['strErrorWritePermissions'] = "File permission errors have been detected, and must be fixed before you can continue.<br />To fix the errors on a Linux system, try typing in the following command(s):";
$GLOBALS['strErrorFixPermissionsRCommand'] = "<i>chmod -R a+w %s</i>";
$GLOBALS['strNotWriteable'] = "NOT writeable";
$GLOBALS['strDirNotWriteableError'] = "Directory must be writeable";

$GLOBALS['strErrorWritePermissionsWin'] = "File permission errors have been detected, and must be fixed before you can continue.";
$GLOBALS['strCheckDocumentation'] = "For more help, please see the <a href=\"{$PRODUCT_DOCSURL}\">{$PRODUCT_NAME} documentation</a>.";
$GLOBALS['strSystemCheckBadPHPConfig'] = "Your current PHP configuration does not meet requirements of {$PRODUCT_NAME}. To resolve the problems, please modify settings in your 'php.ini' file.";

$GLOBALS['strAdminUrlPrefix'] = "Admin Interface URL";
$GLOBALS['strDeliveryUrlPrefix'] = "전달유지 엔진";
$GLOBALS['strDeliveryUrlPrefixSSL'] = "전달유지 엔진";
$GLOBALS['strImagesUrlPrefix'] = "Image Store URL";
$GLOBALS['strImagesUrlPrefixSSL'] = "Image Store URL (SSL)";


$GLOBALS['strUpgrade'] = "업그레이드";

/* ------------------------------------------------------- */
/* Configuration translations                            */
/* ------------------------------------------------------- */

// Global
$GLOBALS['strChooseSection'] = "Choose Section";
$GLOBALS['strEditConfigNotPossible'] = "It is not possible to edit all settings because the configuration file is locked for security reasons.
    If you want to make changes, you may need to unlock the configuration file for this installation first.";
$GLOBALS['strEditConfigPossible'] = "It is possible to edit all settings because the configuration file is not locked, but this could lead to security issues.
    If you want to secure your system, you need to lock the configuration file for this installation.";
$GLOBALS['strUnableToWriteConfig'] = "Unable to write changes to the config file";
$GLOBALS['strUnableToWritePrefs'] = "Unable to commit preferences to the database";
$GLOBALS['strImageDirLockedDetected'] = "The supplied <b>Images Folder</b> is not writeable by the server. <br>You can't proceed until you either change permissions of the folder or create the folder.";

// Configuration Settings
$GLOBALS['strConfigurationSettings'] = "구성 설정";

// Administrator Settings
$GLOBALS['strAdminUsername'] = "관리�? ID";
$GLOBALS['strAdminPassword'] = "Administrator  Password";
$GLOBALS['strInvalidUsername'] = "잘못�?� ID";
$GLOBALS['strBasicInformation'] = "기본 정보";
$GLOBALS['strAdministratorEmail'] = "Administrator email Address";
$GLOBALS['strAdminCheckUpdates'] = "업�?��?�트 검색";
$GLOBALS['strAdminShareStack'] = "Share technical information with the {$PRODUCT_NAME} Team to help with development and testing.";
$GLOBALS['strNovice'] = "Delete actions require confirmation for safety";
$GLOBALS['strUserlogEmail'] = "모든 외부 발송 �?�메�?� 메시지를 기�?합니다.";
$GLOBALS['strEnableDashboard'] = "Enable dashboard";
$GLOBALS['strEnableDashboardSyncNotice'] = "Please enable <a href='account-settings-update.php'>check for updates</a> to use the dashboard.";
$GLOBALS['strTimezone'] = "Timezone";
$GLOBALS['strEnableAutoMaintenance'] = "Automatically perform maintenance during delivery if scheduled maintenance is not set up";

// Database Settings
$GLOBALS['strDatabaseSettings'] = "�?��?�터베�?�스 설정";
$GLOBALS['strDatabaseServer'] = "�?��?�터베�?�스 서버";
$GLOBALS['strDbLocal'] = "Use local socket connection";
$GLOBALS['strDbType'] = "�?��?�터베�?�스 �?�름";
$GLOBALS['strDbHost'] = "�?��?�터베�?�스 호스트명";
$GLOBALS['strDbSocket'] = "Database Socket";
$GLOBALS['strDbPort'] = "Database Port Number";
$GLOBALS['strDbUser'] = "�?��?�터베�?�스 사용�?�?�름";
$GLOBALS['strDbPassword'] = "데이터베이스 비밀번호";
$GLOBALS['strDbName'] = "데이터베이스 이름";
$GLOBALS['strDbNameHint'] = "Database will be created if it does not exist";
$GLOBALS['strDatabaseOptimalisations'] = "데이터베이스 최적화 설정";
$GLOBALS['strPersistentConnections'] = "연결 유지(persistent connection) 사용";
$GLOBALS['strCantConnectToDb'] = "�?��?�터베�?�스�? 연결할 수 없습니다.";
$GLOBALS['strCantConnectToDbDelivery'] = 'Can\'t Connect to Database for Delivery';

// Email Settings
$GLOBALS['strEmailSettings'] = "설정";
$GLOBALS['strEmailAddresses'] = "Email 'From' Address";
$GLOBALS['strEmailFromName'] = "Email 'From' Name";
$GLOBALS['strEmailFromAddress'] = "Email 'From' Email Address";
$GLOBALS['strEmailFromCompany'] = "Email 'From' Company";
$GLOBALS['strUseManagerDetails'] = 'Use the owning account\'s Contact, Email and Name instead of the above Name, Email Address and Company when emailing reports to Advertiser or Website accounts.';
$GLOBALS['strQmailPatch'] = "qmail 패치를 사용합니다.(qmail�?� 사용하는 경우)";
$GLOBALS['strEnableQmailPatch'] = "qmail 패치를 사용합니다.(qmail�?� 사용하는 경우)";
$GLOBALS['strEmailHeader'] = "Email headers";
$GLOBALS['strEmailLog'] = "Email log";

// Audit Trail Settings
$GLOBALS['strAuditTrailSettings'] = "Audit Trail Settings";
$GLOBALS['strEnableAudit'] = "Enable Audit Trail";
$GLOBALS['strEnableAuditForZoneLinking'] = "Enable Audit Trail for Zone Linking screen (introduces huge performance penalty when linking large amounts of zones)";

// Debug Logging Settings
$GLOBALS['strDebug'] = "Debug Logging Settings";
$GLOBALS['strEnableDebug'] = "Enable Debug Logging";
$GLOBALS['strDebugMethodNames'] = "Include method names in debug log";
$GLOBALS['strDebugLineNumbers'] = "Include line numbers in debug log";
$GLOBALS['strDebugType'] = "Debug Log Type";
$GLOBALS['strDebugTypeFile'] = "File";
$GLOBALS['strDebugTypeMcal'] = "mCal";
$GLOBALS['strDebugTypeSql'] = "SQL Database";
$GLOBALS['strDebugTypeSyslog'] = "Syslog";
$GLOBALS['strDebugName'] = "Debug Log Name, Calendar, SQL Table,<br />or Syslog Facility";
$GLOBALS['strDebugPriority'] = "Debug Priority Level";
$GLOBALS['strPEAR_LOG_DEBUG'] = "PEAR_LOG_DEBUG - Most Information";
$GLOBALS['strPEAR_LOG_INFO'] = "PEAR_LOG_INFO - Default Information";
$GLOBALS['strPEAR_LOG_NOTICE'] = "PEAR_LOG_NOTICE";
$GLOBALS['strPEAR_LOG_WARNING'] = "PEAR_LOG_WARNING";
$GLOBALS['strPEAR_LOG_ERR'] = "PEAR_LOG_ERR";
$GLOBALS['strPEAR_LOG_CRIT'] = "PEAR_LOG_CRIT";
$GLOBALS['strPEAR_LOG_ALERT'] = "PEAR_LOG_ALERT";
$GLOBALS['strPEAR_LOG_EMERG'] = "PEAR_LOG_EMERG - Least Information";
$GLOBALS['strDebugIdent'] = "Debug Identification String";
$GLOBALS['strDebugUsername'] = "mCal, SQL Server Username";
$GLOBALS['strDebugPassword'] = "mCal, SQL Server Password";
$GLOBALS['strProductionSystem'] = "Production System";

// Delivery Settings
$GLOBALS['strWebPath'] = "{$PRODUCT_NAME} Server Access Paths";
$GLOBALS['strWebPathSimple'] = "Web path";
$GLOBALS['strDeliveryPath'] = "전송경로";
$GLOBALS['strImagePath'] = "Images path";
$GLOBALS['strDeliverySslPath'] = "전송 SSL 경로";
$GLOBALS['strImageSslPath'] = "Images SSL path";
$GLOBALS['strImageStore'] = "Images folder";
$GLOBALS['strTypeWebSettings'] = "로컬 배너(웹서버) 설정";
$GLOBALS['strTypeWebMode'] = "저장 방법";
$GLOBALS['strTypeWebModeLocal'] = "로컬 디렉토리";
$GLOBALS['strTypeDirError'] = "The local directory cannot be written to by the web server";
$GLOBALS['strTypeWebModeFtp'] = "외부 FTP 서버";
$GLOBALS['strTypeWebDir'] = "로컬 디렉토리";
$GLOBALS['strTypeFTPHost'] = "FTP 호스트";
$GLOBALS['strTypeFTPDirectory'] = "호스트 디렉터리";
$GLOBALS['strTypeFTPUsername'] = "로그인";
$GLOBALS['strTypeFTPPassword'] = "비밀번호";
$GLOBALS['strTypeFTPPassive'] = "Use passive FTP";
$GLOBALS['strTypeFTPErrorDir'] = "The FTP Host Directory does not exist";
$GLOBALS['strTypeFTPErrorConnect'] = "Could not connect to the FTP Server, the Login or Password is not correct";
$GLOBALS['strTypeFTPErrorNoSupport'] = "Your installation of PHP does not support FTP.";
$GLOBALS['strTypeFTPErrorUpload'] = "Could not upload file to the FTP Server, check set proper rights to Host Directory";
$GLOBALS['strTypeFTPErrorHost'] = "The FTP Host is not correct";
$GLOBALS['strDeliveryFilenames'] = "Delivery File Names";
$GLOBALS['strDeliveryFilenamesAdClick'] = "Ad Click";
$GLOBALS['strDeliveryFilenamesSignedAdClick'] = "Signed Ad Click";
$GLOBALS['strDeliveryFilenamesAdConversionVars'] = "Ad Conversion Variables";
$GLOBALS['strDeliveryFilenamesAdContent'] = "Ad Content";
$GLOBALS['strDeliveryFilenamesAdConversion'] = "Ad Conversion";
$GLOBALS['strDeliveryFilenamesAdConversionJS'] = "Ad Conversion (JavaScript)";
$GLOBALS['strDeliveryFilenamesAdFrame'] = "Ad Frame";
$GLOBALS['strDeliveryFilenamesAdImage'] = "Ad Image";
$GLOBALS['strDeliveryFilenamesAdJS'] = "Ad (JavaScript)";
$GLOBALS['strDeliveryFilenamesAdLayer'] = "Ad Layer";
$GLOBALS['strDeliveryFilenamesAdLog'] = "Ad Log";
$GLOBALS['strDeliveryFilenamesAdPopup'] = "Ad Popup";
$GLOBALS['strDeliveryFilenamesAdView'] = "Ad View";
$GLOBALS['strDeliveryFilenamesXMLRPC'] = "XML RPC Invocation";
$GLOBALS['strDeliveryFilenamesLocal'] = "Local Invocation";
$GLOBALS['strDeliveryFilenamesFrontController'] = "Front Controller";
$GLOBALS['strDeliveryFilenamesSinglePageCall'] = "Single Page Call";
$GLOBALS['strDeliveryFilenamesSinglePageCallJS'] = "Single Page Call (JavaScript)";
$GLOBALS['strDeliveryFilenamesAsyncJS'] = "Async JavaScript (source file)";
$GLOBALS['strDeliveryFilenamesAsyncPHP'] = "Async JavaScript";
$GLOBALS['strDeliveryFilenamesAsyncSPC'] = "Async JavaScript Single Page Call";
$GLOBALS['strDeliveryCaching'] = "Banner Delivery Cache Settings";
$GLOBALS['strDeliveryCacheLimit'] = "Time Between Banner Cache Updates (seconds)";
$GLOBALS['strDeliveryCacheStore'] = "Banner Delivery Cache Store Type";
$GLOBALS['strDeliveryAcls'] = "Evaluate banner delivery rules during delivery";
$GLOBALS['strDeliveryAclsDirectSelection'] = "Evaluate banner delivery rules for direct selected ads";
$GLOBALS['strDeliveryObfuscate'] = "Obfuscate delivery rule set when delivering ads";
$GLOBALS['strDeliveryCtDelimiter'] = "3rd Party Click Tracking Delimiter";
$GLOBALS['strGlobalDefaultBannerUrl'] = "Global default Banner Image URL";
$GLOBALS['strGlobalDefaultBannerInvalidZone'] = "Global default HTML Banner for non-existing zones";
$GLOBALS['strGlobalDefaultBannerSuspendedAccount'] = "Global default HTML Banner for suspended accounts";
$GLOBALS['strGlobalDefaultBannerInactiveAccount'] = "Global default HTML Banner for inactive accounts";
$GLOBALS['strP3PSettings'] = "P3P 개인정보 보호정책";
$GLOBALS['strUseP3P'] = "P3P 정책 사용";
$GLOBALS['strP3PCompactPolicy'] = "P3P Compact 정책";
$GLOBALS['strP3PPolicyLocation'] = "P3P 정책 위치";
$GLOBALS['strPrivacySettings'] = "Privacy Settings";
$GLOBALS['strDisableViewerId'] = "Disable unique Viewer Id cookie";
$GLOBALS['strAnonymiseIp'] = "Anonymise viewer IP addresses";

// General Settings
$GLOBALS['generalSettings'] = "Global General System Settings";
$GLOBALS['uiEnabled'] = "User Interface Enabled";
$GLOBALS['defaultLanguage'] = "Default System Language<br />(Each user can select their own language)";

// Geotargeting Settings
$GLOBALS['strGeotargetingSettings'] = "지역별 광고설정";
$GLOBALS['strGeotargeting'] = "지역별 광고설정";
$GLOBALS['strGeotargetingType'] = "Geotargeting Module Type";
$GLOBALS['strGeoShowUnavailable'] = "Show geotargeting delivery rules even if GeoIP data unavailable";

// Interface Settings
$GLOBALS['strInventory'] = "목�?";
$GLOBALS['strShowCampaignInfo'] = "<i>캠페�?� 목�?</i> 페�?�지�? 캠페�?� 정보를 �?세히 보여�?니다.";
$GLOBALS['strShowBannerInfo'] = "<i>배너 목�?</i> 페�?�지�? 배너 정보를 �?세히 보여�?니다.";
$GLOBALS['strShowCampaignPreview'] = "<i>배너 목�?</i> 페�?�지�? 배너�?� 미리보기를 모�? 표시합니다.";
$GLOBALS['strShowBannerHTML'] = "HTML 코드 대신�? 실제 배너를 표시합니다.";
$GLOBALS['strShowBannerPreview'] = "배너 처리 화면�?서 페�?�지 �?단�? 배너 미리보기를 표시합니다.";
$GLOBALS['strUseWyswygHtmlEditorByDefault'] = "Use the WYSIWYG HTML Editor by default when creating or editing HTML banners";
$GLOBALS['strHideInactive'] = "사용하지 않는 항목�?� 모든 목�? 페�?�지�?서 숨�?니다.";
$GLOBALS['strGUIShowMatchingBanners'] = "<i>연결�?� 배너</i> 페�?�지�? 해당 배너를 표시합니다.";
$GLOBALS['strGUIShowParentCampaigns'] = "<i>연결�?� 배너</i> 페�?�지�? 해당하는 �?위 �?페�?��?� 표시합니다.";
$GLOBALS['strShowEntityId'] = "Show entity identifiers";
$GLOBALS['strStatisticsDefaults'] = "통계";
$GLOBALS['strBeginOfWeek'] = "한 주�?� 시작�?�";
$GLOBALS['strPercentageDecimals'] = "백분율 소수�?";
$GLOBALS['strWeightDefaults'] = "가중치 기본설정";
$GLOBALS['strDefaultBannerWeight'] = "배너 가중치 기본값";
$GLOBALS['strDefaultCampaignWeight'] = "캠페인 가중치 기본값";
$GLOBALS['strConfirmationUI'] = "Confirmation in User Interface";

// Invocation Settings
$GLOBALS['strInvocationDefaults'] = "Invocation Defaults";
$GLOBALS['strEnable3rdPartyTrackingByDefault'] = "Enable 3rd Party Clicktracking by Default";

// Banner Delivery Settings
$GLOBALS['strBannerDelivery'] = "Banner Delivery Settings";

// Banner Logging Settings
$GLOBALS['strBannerLogging'] = "Banner Logging Settings";
$GLOBALS['strLogAdRequests'] = "Log a request every time a banner is requested";
$GLOBALS['strLogAdImpressions'] = "Log an impression every time a banner is viewed";
$GLOBALS['strLogAdClicks'] = "Log a click every time a viewer clicks on a banner";
$GLOBALS['strReverseLookup'] = "DNS 역참조";
$GLOBALS['strProxyLookup'] = "프�?시 참조";
$GLOBALS['strPreventLogging'] = "Block Banner Logging Settings";
$GLOBALS['strIgnoreHosts'] = "해당 IP주소 혹은 호스트명은 통계에 기록하지 마십시오.";
$GLOBALS['strIgnoreUserAgents'] = "<b>Don't</b> log statistics from clients with any of the following strings in their user-agent (one-per-line)";
$GLOBALS['strEnforceUserAgents'] = "<b>Only</b> log statistics from clients with any of the following strings in their user-agent (one-per-line)";

// Banner Storage Settings
$GLOBALS['strBannerStorage'] = "Banner Storage Settings";

// Campaign ECPM settings
$GLOBALS['strEnableECPM'] = "Use eCPM optimized priorities instead of remnant-weighted priorities";
$GLOBALS['strEnableContractECPM'] = "Use eCPM optimized priorities instead of standard contract priorities";
$GLOBALS['strEnableECPMfromRemnant'] = "(If you enable this feature all your remnant campaigns will be deactivated, you will have to update them manually to reactivate them)";
$GLOBALS['strEnableECPMfromECPM'] = "(If you disable this feature some of your active eCPM campaigns will be deactivated, you will have to update them manually to reactivate them)";
$GLOBALS['strInactivatedCampaigns'] = "List of campaigns which became inactive due to the changes in preferences:";

// Statistics & Maintenance Settings
$GLOBALS['strMaintenanceSettings'] = "Maintenance Settings";
$GLOBALS['strConversionTracking'] = "Conversion Tracking Settings";
$GLOBALS['strEnableConversionTracking'] = "Enable Conversion Tracking";
$GLOBALS['strBlockInactiveBanners'] = "Don't count ad impressions, clicks or re-direct the user to the target URL if the viewer clicks on a banner that is inactive";
$GLOBALS['strBlockAdClicks'] = "Don't count ad clicks if the viewer has clicked on the same ad/zone pair within the specified time (seconds)";
$GLOBALS['strMaintenanceOI'] = "Maintenance Operation Interval (minutes)";
$GLOBALS['strPrioritySettings'] = "Priority Settings";
$GLOBALS['strPriorityInstantUpdate'] = "Update advertisement priorities immediately when changes made in the UI";
$GLOBALS['strPriorityIntentionalOverdelivery'] = "Intentionally over-deliver Contract Campaigns<br />(% over-delivery)";
$GLOBALS['strDefaultImpConvWindow'] = "Default Ad Impression Conversion Window (seconds)";
$GLOBALS['strDefaultCliConvWindow'] = "Default Ad Click Conversion Window (seconds)";
$GLOBALS['strAdminEmailHeaders'] = "�?��?� 광고 보고서�?� 발송�?�? 대한 정보를 메�?� 헤�?��? �?�함합니다.";
$GLOBALS['strWarnLimit'] = "경고횟수 제한(Warn Limit)";
$GLOBALS['strWarnLimitDays'] = "Send a warning when the days left are less than specified here";
$GLOBALS['strWarnAdmin'] = "캠페인의 만료일이 다가올때 관리자에게 알립니다.";
$GLOBALS['strWarnClient'] = "캠페인의 만료일이 다가올때 광고주에게 알립니다.";
$GLOBALS['strWarnAgency'] = "캠페인의 만료일이 다가올때마다 사용자에게 알립니다.";

// UI Settings
$GLOBALS['strGuiSettings'] = "사용자 환경설정";
$GLOBALS['strGeneralSettings'] = "일반 설정";
$GLOBALS['strAppName'] = "어플리케이션 이름";
$GLOBALS['strMyHeader'] = "헤더 파일 경로";
$GLOBALS['strMyFooter'] = "푸터 파일 경로";
$GLOBALS['strDefaultTrackerStatus'] = "Default tracker status";
$GLOBALS['strDefaultTrackerType'] = "Default tracker type";
$GLOBALS['strSSLSettings'] = "SSL Settings";
$GLOBALS['requireSSL'] = "Force SSL Access on User Interface";
$GLOBALS['sslPort'] = "SSL Port Used by Web Server";
$GLOBALS['strDashboardSettings'] = "Dashboard Settings";
$GLOBALS['strMyLogo'] = "Name/URL of custom logo file";
$GLOBALS['strGuiHeaderForegroundColor'] = "Color of the header foreground";
$GLOBALS['strGuiHeaderBackgroundColor'] = "Color of the header background";
$GLOBALS['strGuiActiveTabColor'] = "Color of the active tab";
$GLOBALS['strGuiHeaderTextColor'] = "Color of the text in the header";
$GLOBALS['strGuiSupportLink'] = "Custom URL for 'Support' link in header";
$GLOBALS['strGzipContentCompression'] = "컨텐츠 GZIP 압축 사용";

// Regenerate Platfor Hash script
$GLOBALS['strPlatformHashRegenerate'] = "Platform Hash Regenerate";
$GLOBALS['strNewPlatformHash'] = "Your new Platform Hash is:";
$GLOBALS['strPlatformHashInsertingError'] = "Error inserting Platform Hash into database";

// Plugin Settings
$GLOBALS['strPluginSettings'] = "Plugin Settings";
$GLOBALS['strEnableNewPlugins'] = "Enable newly installed plugins";
$GLOBALS['strUseMergedFunctions'] = "Use merged delivery functions file";
