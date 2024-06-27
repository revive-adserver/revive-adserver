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
$GLOBALS['strInstall'] = "Pasang";
$GLOBALS['strDatabaseSettings'] = "Konfigurasi Pengkalan Data";
$GLOBALS['strAdminAccount'] = "Akaun Pentadbir";
$GLOBALS['strAdvancedSettings'] = "Konfigurasi yang lebih mendalam";
$GLOBALS['strWarning'] = "Amaran";
$GLOBALS['strBtnContinue'] = "Seterusnya »";
$GLOBALS['strBtnRecover'] = "Pulihkan »";
$GLOBALS['strBtnAgree'] = "Saya Setuju »";
$GLOBALS['strBtnRetry'] = "Cuba lagi";
$GLOBALS['strTablesPrefix'] = "";
$GLOBALS['strTablesType'] = "";

$GLOBALS['strRecoveryRequiredTitle'] = "Cubaan pembaharuan anda yang terdahulu tidak berjaya";
$GLOBALS['strRecoveryRequired'] = "Terdapat kesilapan semasa memproses pembaharuan anda terdahulu dan {{PRODUCT_NAME}} mesti mencuba untuk memulihkan proses pembaharuan itu. Sila klik butang Pulih dibawah";

$GLOBALS['strProductUpToDateTitle'] = "";
$GLOBALS['strOaUpToDate'] = "Pengkalan data {{PRODUCT_NAME}} anda dan juga struktur failnya, adalah versi terkini, maka dengan ini tiada pembaharuan diperlukan. Sila klik Seterusnya untuk ke panel pentadbiran OpenX.";
$GLOBALS['strOaUpToDateCantRemove'] = "Amaran: fail Pembaharuan masih lagi terdapat didalam direktori var anda. Kami tidak dapat memadamkan fail ini disebabkan kekurangan hak keatasnya. Sila padamkan fail ini sendiri.";
$GLOBALS['strErrorWritePermissions'] = "";
$GLOBALS['strErrorFixPermissionsRCommand'] = "";
$GLOBALS['strNotWriteable'] = "";
$GLOBALS['strDirNotWriteableError'] = "";

$GLOBALS['strErrorWritePermissionsWin'] = "";
$GLOBALS['strCheckDocumentation'] = "";
$GLOBALS['strSystemCheckBadPHPConfig'] = "";

$GLOBALS['strAdminUrlPrefix'] = "URL sistem muka pentadbir";
$GLOBALS['strDeliveryUrlPrefix'] = "Enjin Penghantaran";
$GLOBALS['strDeliveryUrlPrefixSSL'] = "Enjin Penghantaran";
$GLOBALS['strImagesUrlPrefix'] = "URL stor imej";
$GLOBALS['strImagesUrlPrefixSSL'] = "URL (SSL) stor imej";


$GLOBALS['strUpgrade'] = "";

/* ------------------------------------------------------- */
/* Configuration translations                            */
/* ------------------------------------------------------- */

// Global
$GLOBALS['strChooseSection'] = "Pilih bahagian";
$GLOBALS['strEditConfigNotPossible'] = "";
$GLOBALS['strEditConfigPossible'] = "";
$GLOBALS['strUnableToWriteConfig'] = "";
$GLOBALS['strUnableToWritePrefs'] = "";
$GLOBALS['strImageDirLockedDetected'] = "";

// Configuration Settings
$GLOBALS['strConfigurationSettings'] = "";

// Administrator Settings
$GLOBALS['strAdminUsername'] = "Kata nama Pentadbir";
$GLOBALS['strAdminPassword'] = "Kata Laluan Pentadbir";
$GLOBALS['strInvalidUsername'] = "Kata nama tidak sah";
$GLOBALS['strBasicInformation'] = "Maklumat Asas";
$GLOBALS['strAdministratorEmail'] = "Alamat emel Pentadbir";
$GLOBALS['strAdminCheckUpdates'] = "";
$GLOBALS['strAdminShareStack'] = "";
$GLOBALS['strNovice'] = "Tindakan untuk memadam memerlukan maklum balas diatas tujuan keselamatan untuk mengelakkan kesilapan";
$GLOBALS['strUserlogEmail'] = "Log kesemua mesej emel keluar";
$GLOBALS['strEnableDashboard'] = "";
$GLOBALS['strEnableDashboardSyncNotice'] = "";
$GLOBALS['strTimezone'] = "Zon Waktu";
$GLOBALS['strEnableAutoMaintenance'] = "";

// Database Settings
$GLOBALS['strDatabaseSettings'] = "Konfigurasi Pengkalan Data";
$GLOBALS['strDatabaseServer'] = "Ciri-ciri global server pengkalan data";
$GLOBALS['strDbLocal'] = "";
$GLOBALS['strDbType'] = "Jenis pengkalan data";
$GLOBALS['strDbHost'] = "Nama host pengkalan data";
$GLOBALS['strDbSocket'] = "";
$GLOBALS['strDbPort'] = "Nombor port pengkalan data";
$GLOBALS['strDbUser'] = "Nama pengguna pengkalan data";
$GLOBALS['strDbPassword'] = "Kata laluan pengkalan data";
$GLOBALS['strDbName'] = "Nama pengkalan data";
$GLOBALS['strDbNameHint'] = "";
$GLOBALS['strDatabaseOptimalisations'] = "Ciri-ciri untuk mengoptimumkan pengkalan data";
$GLOBALS['strPersistentConnections'] = "Gunakan hubungan yang kekal";
$GLOBALS['strCantConnectToDb'] = "Tidak dapat berhubung dengan pengkalan data";
$GLOBALS['strCantConnectToDbDelivery'] = '';

// Email Settings
$GLOBALS['strEmailSettings'] = "";
$GLOBALS['strEmailAddresses'] = "";
$GLOBALS['strEmailFromName'] = "";
$GLOBALS['strEmailFromAddress'] = "";
$GLOBALS['strEmailFromCompany'] = "";
$GLOBALS['strUseManagerDetails'] = '';
$GLOBALS['strQmailPatch'] = "";
$GLOBALS['strEnableQmailPatch'] = "";
$GLOBALS['strEmailHeader'] = "";
$GLOBALS['strEmailLog'] = "";

// Audit Trail Settings
$GLOBALS['strAuditTrailSettings'] = "";
$GLOBALS['strEnableAudit'] = "";
$GLOBALS['strEnableAuditForZoneLinking'] = "";

// Debug Logging Settings
$GLOBALS['strDebug'] = "";
$GLOBALS['strEnableDebug'] = "";
$GLOBALS['strDebugMethodNames'] = "";
$GLOBALS['strDebugLineNumbers'] = "";
$GLOBALS['strDebugType'] = "";
$GLOBALS['strDebugTypeFile'] = "";
$GLOBALS['strDebugTypeMcal'] = "";
$GLOBALS['strDebugTypeSql'] = "Pengkalan Data SQL";
$GLOBALS['strDebugTypeSyslog'] = "";
$GLOBALS['strDebugName'] = "";
$GLOBALS['strDebugPriority'] = "";
$GLOBALS['strPEAR_LOG_DEBUG'] = "";
$GLOBALS['strPEAR_LOG_INFO'] = "";
$GLOBALS['strPEAR_LOG_NOTICE'] = "";
$GLOBALS['strPEAR_LOG_WARNING'] = "";
$GLOBALS['strPEAR_LOG_ERR'] = "";
$GLOBALS['strPEAR_LOG_CRIT'] = "";
$GLOBALS['strPEAR_LOG_ALERT'] = "";
$GLOBALS['strPEAR_LOG_EMERG'] = "";
$GLOBALS['strDebugIdent'] = "";
$GLOBALS['strDebugUsername'] = "";
$GLOBALS['strDebugPassword'] = "";
$GLOBALS['strProductionSystem'] = "";

// Delivery Settings
$GLOBALS['strWebPath'] = "";
$GLOBALS['strWebPathSimple'] = "";
$GLOBALS['strDeliveryPath'] = "";
$GLOBALS['strImagePath'] = "";
$GLOBALS['strDeliverySslPath'] = "";
$GLOBALS['strImageSslPath'] = "";
$GLOBALS['strImageStore'] = "Folder imej-imej";
$GLOBALS['strTypeWebSettings'] = "";
$GLOBALS['strTypeWebMode'] = "Cara menyimpan";
$GLOBALS['strTypeWebModeLocal'] = "Direktori Tempatan";
$GLOBALS['strTypeDirError'] = "";
$GLOBALS['strTypeWebModeFtp'] = "FTP Server Luar";
$GLOBALS['strTypeWebDir'] = "Direktori Tempatan";
$GLOBALS['strTypeFTPHost'] = "";
$GLOBALS['strTypeFTPDirectory'] = "";
$GLOBALS['strTypeFTPUsername'] = "Log Masuk";
$GLOBALS['strTypeFTPPassword'] = "Kata Laluan";
$GLOBALS['strTypeFTPPassive'] = "";
$GLOBALS['strTypeFTPErrorDir'] = "";
$GLOBALS['strTypeFTPErrorConnect'] = "";
$GLOBALS['strTypeFTPErrorNoSupport'] = "";
$GLOBALS['strTypeFTPErrorUpload'] = "";
$GLOBALS['strTypeFTPErrorHost'] = "";
$GLOBALS['strDeliveryFilenames'] = "";
$GLOBALS['strDeliveryFilenamesAdClick'] = "";
$GLOBALS['strDeliveryFilenamesSignedAdClick'] = "";
$GLOBALS['strDeliveryFilenamesAdConversionVars'] = "";
$GLOBALS['strDeliveryFilenamesAdContent'] = "Maklumat iklan";
$GLOBALS['strDeliveryFilenamesAdConversion'] = "";
$GLOBALS['strDeliveryFilenamesAdConversionJS'] = "";
$GLOBALS['strDeliveryFilenamesAdFrame'] = "";
$GLOBALS['strDeliveryFilenamesAdImage'] = "Imej Iklan";
$GLOBALS['strDeliveryFilenamesAdJS'] = "";
$GLOBALS['strDeliveryFilenamesAdLayer'] = "";
$GLOBALS['strDeliveryFilenamesAdLog'] = "Log Iklan";
$GLOBALS['strDeliveryFilenamesAdPopup'] = "";
$GLOBALS['strDeliveryFilenamesAdView'] = "";
$GLOBALS['strDeliveryFilenamesXMLRPC'] = "";
$GLOBALS['strDeliveryFilenamesLocal'] = "";
$GLOBALS['strDeliveryFilenamesFrontController'] = "";
$GLOBALS['strDeliveryFilenamesSinglePageCall'] = "";
$GLOBALS['strDeliveryFilenamesSinglePageCallJS'] = "";
$GLOBALS['strDeliveryFilenamesAsyncJS'] = "";
$GLOBALS['strDeliveryFilenamesAsyncPHP'] = "";
$GLOBALS['strDeliveryFilenamesAsyncSPC'] = "";
$GLOBALS['strDeliveryCaching'] = "";
$GLOBALS['strDeliveryCacheLimit'] = "";
$GLOBALS['strDeliveryCacheStore'] = "";
$GLOBALS['strDeliveryAcls'] = "";
$GLOBALS['strDeliveryAclsDirectSelection'] = "";
$GLOBALS['strDeliveryObfuscate'] = "";
$GLOBALS['strDeliveryClickUrlValidity'] = "";
$GLOBALS['strDeliveryRelAttribute'] = "";
$GLOBALS['strGlobalDefaultBannerInvalidZone'] = "";
$GLOBALS['strGlobalDefaultBannerSuspendedAccount'] = "";
$GLOBALS['strGlobalDefaultBannerInactiveAccount'] = "";
$GLOBALS['strP3PSettings'] = "";
$GLOBALS['strUseP3P'] = "";
$GLOBALS['strP3PCompactPolicy'] = "";
$GLOBALS['strP3PPolicyLocation'] = "";
$GLOBALS['strPrivacySettings'] = "";
$GLOBALS['strDisableViewerId'] = "";
$GLOBALS['strAnonymiseIp'] = "";

// General Settings
$GLOBALS['generalSettings'] = "";
$GLOBALS['uiEnabled'] = "";
$GLOBALS['defaultLanguage'] = "";

// Geotargeting Settings
$GLOBALS['strGeotargetingSettings'] = "";
$GLOBALS['strGeotargeting'] = "";
$GLOBALS['strGeotargetingType'] = "";
$GLOBALS['strGeoShowUnavailable'] = "";

// Interface Settings
$GLOBALS['strInventory'] = "Inventori";
$GLOBALS['strShowCampaignInfo'] = "";
$GLOBALS['strShowBannerInfo'] = "";
$GLOBALS['strShowCampaignPreview'] = "";
$GLOBALS['strShowBannerHTML'] = "";
$GLOBALS['strShowBannerPreview'] = "";
$GLOBALS['strUseWyswygHtmlEditorByDefault'] = "";
$GLOBALS['strHideInactive'] = "";
$GLOBALS['strGUIShowMatchingBanners'] = "";
$GLOBALS['strGUIShowParentCampaigns'] = "";
$GLOBALS['strShowEntityId'] = "";
$GLOBALS['strStatisticsDefaults'] = "";
$GLOBALS['strBeginOfWeek'] = "";
$GLOBALS['strPercentageDecimals'] = "";
$GLOBALS['strWeightDefaults'] = "";
$GLOBALS['strDefaultBannerWeight'] = "";
$GLOBALS['strDefaultCampaignWeight'] = "";
$GLOBALS['strConfirmationUI'] = "";

// Invocation Settings
$GLOBALS['strInvocationDefaults'] = "";
$GLOBALS['strEnable3rdPartyTrackingByDefault'] = "";

// Banner Delivery Settings
$GLOBALS['strBannerDelivery'] = "";

// Banner Logging Settings
$GLOBALS['strBannerLogging'] = "";
$GLOBALS['strLogAdRequests'] = "";
$GLOBALS['strLogAdImpressions'] = "";
$GLOBALS['strLogAdClicks'] = "";
$GLOBALS['strReverseLookup'] = "";
$GLOBALS['strProxyLookup'] = "";
$GLOBALS['strPreventLogging'] = "";
$GLOBALS['strIgnoreHosts'] = "";
$GLOBALS['strIgnoreUserAgents'] = "";
$GLOBALS['strEnforceUserAgents'] = "";

// Banner Storage Settings
$GLOBALS['strBannerStorage'] = "";

// Campaign ECPM settings
$GLOBALS['strEnableECPM'] = "";
$GLOBALS['strEnableContractECPM'] = "";
$GLOBALS['strEnableECPMfromRemnant'] = "";
$GLOBALS['strEnableECPMfromECPM'] = "";
$GLOBALS['strInactivatedCampaigns'] = "";

// Statistics & Maintenance Settings
$GLOBALS['strMaintenanceSettings'] = "";
$GLOBALS['strConversionTracking'] = "";
$GLOBALS['strEnableConversionTracking'] = "";
$GLOBALS['strBlockInactiveBanners'] = "";
$GLOBALS['strBlockAdClicks'] = "";
$GLOBALS['strMaintenanceOI'] = "";
$GLOBALS['strPrioritySettings'] = "";
$GLOBALS['strPriorityInstantUpdate'] = "";
$GLOBALS['strPriorityIntentionalOverdelivery'] = "";
$GLOBALS['strDefaultImpConvWindow'] = "";
$GLOBALS['strDefaultCliConvWindow'] = "";
$GLOBALS['strAdminEmailHeaders'] = "";
$GLOBALS['strWarnLimit'] = "";
$GLOBALS['strWarnLimitDays'] = "";
$GLOBALS['strWarnAdmin'] = "";
$GLOBALS['strWarnClient'] = "";
$GLOBALS['strWarnAgency'] = "";

// UI Settings
$GLOBALS['strGuiSettings'] = "";
$GLOBALS['strGeneralSettings'] = "";
$GLOBALS['strAppName'] = "";
$GLOBALS['strMyHeader'] = "";
$GLOBALS['strMyFooter'] = "";
$GLOBALS['strDefaultTrackerStatus'] = "";
$GLOBALS['strDefaultTrackerType'] = "";
$GLOBALS['strSSLSettings'] = "";
$GLOBALS['requireSSL'] = "";
$GLOBALS['sslPort'] = "";
$GLOBALS['strDashboardSettings'] = "";
$GLOBALS['strMyLogo'] = "";
$GLOBALS['strGuiHeaderForegroundColor'] = "";
$GLOBALS['strGuiHeaderBackgroundColor'] = "";
$GLOBALS['strGuiActiveTabColor'] = "";
$GLOBALS['strGuiHeaderTextColor'] = "";
$GLOBALS['strGuiSupportLink'] = "";
$GLOBALS['strGzipContentCompression'] = "";

// Regenerate Platfor Hash script
$GLOBALS['strPlatformHashRegenerate'] = "";
$GLOBALS['strNewPlatformHash'] = "";
$GLOBALS['strPlatformHashInsertingError'] = "";

// Plugin Settings
$GLOBALS['strPluginSettings'] = "";
$GLOBALS['strEnableNewPlugins'] = "";
$GLOBALS['strUseMergedFunctions'] = "";
