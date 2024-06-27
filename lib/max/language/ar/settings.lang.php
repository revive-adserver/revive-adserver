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
$GLOBALS['strInstall'] = "تنصيب";
$GLOBALS['strDatabaseSettings'] = "خيارات قواعد البيانات";
$GLOBALS['strAdminAccount'] = "حساب المدير";
$GLOBALS['strAdvancedSettings'] = "خيارات متقدمة";
$GLOBALS['strWarning'] = "تحذير";
$GLOBALS['strBtnContinue'] = "متابعة >>";
$GLOBALS['strBtnRecover'] = "إسترجاع >>";
$GLOBALS['strBtnAgree'] = "موافق >>";
$GLOBALS['strBtnRetry'] = "فصح جديد";
$GLOBALS['strTablesPrefix'] = "السابقة لإسم الجداول";
$GLOBALS['strTablesType'] = "نوع الجدول";

$GLOBALS['strRecoveryRequiredTitle'] = "عملية محاولة الترقية السابقة واجهت بعض المشاكل";
$GLOBALS['strRecoveryRequired'] = "حدثت مشكلة أثناء محاولة الترقية و سيقوم برنامج {{PRODUCT_NAME}} بمحاولة إصلاح عملية الترقية. إضغط زر التصحيح بالأسفل.";

$GLOBALS['strProductUpToDateTitle'] = "";
$GLOBALS['strOaUpToDate'] = "";
$GLOBALS['strOaUpToDateCantRemove'] = "";
$GLOBALS['strErrorWritePermissions'] = "هناك خلل في تصاريح الملفات ، يجب عليك إصلاحه قبل الاستمرار.<br />لحل الأخطاء في نظام لينوكس ، قم بكتابة هذه الأوامر :";
$GLOBALS['strErrorFixPermissionsRCommand'] = "<i>إعطاء التصريح a+w %s</i>";
$GLOBALS['strNotWriteable'] = "";
$GLOBALS['strDirNotWriteableError'] = "";

$GLOBALS['strErrorWritePermissionsWin'] = "هناك خلل في تصاريح الملفات ، يجب عليك إصلاحه قبل الاستمرار";
$GLOBALS['strCheckDocumentation'] = "لمزيد من التعليمات ، الرجاء الإطلاع على <وثائق مساعدة>. ";
$GLOBALS['strSystemCheckBadPHPConfig'] = "";

$GLOBALS['strAdminUrlPrefix'] = "رابط لوحة التحكم";
$GLOBALS['strDeliveryUrlPrefix'] = "نظام التوزيع";
$GLOBALS['strDeliveryUrlPrefixSSL'] = "نظام التوزيع";
$GLOBALS['strImagesUrlPrefix'] = "رابط حفظ الصور";
$GLOBALS['strImagesUrlPrefixSSL'] = "رابط حفظ الصور (رابط آمن)";


$GLOBALS['strUpgrade'] = "";

/* ------------------------------------------------------- */
/* Configuration translations                            */
/* ------------------------------------------------------- */

// Global
$GLOBALS['strChooseSection'] = "إختيار قسم";
$GLOBALS['strEditConfigNotPossible'] = "";
$GLOBALS['strEditConfigPossible'] = "";
$GLOBALS['strUnableToWriteConfig'] = "تعذر حفظ التعديلات في ملف الإعدادات";
$GLOBALS['strUnableToWritePrefs'] = "تعذر حفظ التعديلات في قاعدة البيانات";
$GLOBALS['strImageDirLockedDetected'] = "<b>ملجد الصور</b>غير قابل للكتابة. <br> يجب عليك إنشاء المجلد او تعديل صلاحياته قبل الاستمرار";

// Configuration Settings
$GLOBALS['strConfigurationSettings'] = "";

// Administrator Settings
$GLOBALS['strAdminUsername'] = "اسم المستخدم للمدير";
$GLOBALS['strAdminPassword'] = "كلمة السر للمدير";
$GLOBALS['strInvalidUsername'] = "اسم المستخدم غير صالح";
$GLOBALS['strBasicInformation'] = "معلومات أساسية";
$GLOBALS['strAdministratorEmail'] = "البريد الالكتروني للمدير العام";
$GLOBALS['strAdminCheckUpdates'] = "";
$GLOBALS['strAdminShareStack'] = "";
$GLOBALS['strNovice'] = "نحتاج للتأكيد قبل الحذف كخطوة احترازية";
$GLOBALS['strUserlogEmail'] = "حفظ كل الرسائل الصادرة";
$GLOBALS['strEnableDashboard'] = "";
$GLOBALS['strEnableDashboardSyncNotice'] = "";
$GLOBALS['strTimezone'] = "المنطقة الزمنية";
$GLOBALS['strEnableAutoMaintenance'] = "";

// Database Settings
$GLOBALS['strDatabaseSettings'] = "خيارات قواعد البيانات";
$GLOBALS['strDatabaseServer'] = "الإعدادات العامة لمستضيف قاعدة البيانات";
$GLOBALS['strDbLocal'] = "";
$GLOBALS['strDbType'] = "نوع قاعدة البيانات";
$GLOBALS['strDbHost'] = "مستضيف قاعدة البيانات";
$GLOBALS['strDbSocket'] = "";
$GLOBALS['strDbPort'] = "رقم المنفذ (بورت) قاعدة البيانات";
$GLOBALS['strDbUser'] = "اسم مستخدم قاعدة البيانات";
$GLOBALS['strDbPassword'] = "كلمة سر قاعدة البيانات";
$GLOBALS['strDbName'] = "اسم قاعدة البيانات";
$GLOBALS['strDbNameHint'] = "";
$GLOBALS['strDatabaseOptimalisations'] = "";
$GLOBALS['strPersistentConnections'] = "استخدام الاتصال المستمر";
$GLOBALS['strCantConnectToDb'] = "لا يمكن الاتصال بقاعدة البيانات";
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
$GLOBALS['strDebugTypeFile'] = "ملف";
$GLOBALS['strDebugTypeMcal'] = "";
$GLOBALS['strDebugTypeSql'] = "قاعدة بيانات SQL";
$GLOBALS['strDebugTypeSyslog'] = "سجل النظام";
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
$GLOBALS['strImagePath'] = "مسار الصور";
$GLOBALS['strDeliverySslPath'] = "";
$GLOBALS['strImageSslPath'] = "مسار الصور (آمن)";
$GLOBALS['strImageStore'] = "مجلد الصور";
$GLOBALS['strTypeWebSettings'] = "";
$GLOBALS['strTypeWebMode'] = "اسلوب التخزين";
$GLOBALS['strTypeWebModeLocal'] = "المجلد المحلي";
$GLOBALS['strTypeDirError'] = "المجلد المحلي غير قابل للكتابة";
$GLOBALS['strTypeWebModeFtp'] = "مستضيف FTP خارجي";
$GLOBALS['strTypeWebDir'] = "المجلد المحلي";
$GLOBALS['strTypeFTPHost'] = "مستضيف FTP";
$GLOBALS['strTypeFTPDirectory'] = "مجلد المستضيف";
$GLOBALS['strTypeFTPUsername'] = "اسم الدخول";
$GLOBALS['strTypeFTPPassword'] = "كلمة السر";
$GLOBALS['strTypeFTPPassive'] = "استخدام اسلوب passive FTP";
$GLOBALS['strTypeFTPErrorDir'] = "مجلد المستضيف غير موجود";
$GLOBALS['strTypeFTPErrorConnect'] = "لا يمكن الاتصال بمستضيف FTP ، الرجاء التحقق من اسم المستخدم او كلمة السر.";
$GLOBALS['strTypeFTPErrorNoSupport'] = "";
$GLOBALS['strTypeFTPErrorUpload'] = "";
$GLOBALS['strTypeFTPErrorHost'] = "عنوان مستضيف FTP غير صحيح";
$GLOBALS['strDeliveryFilenames'] = "";
$GLOBALS['strDeliveryFilenamesAdClick'] = "رابط الضغط على الإعلان";
$GLOBALS['strDeliveryFilenamesSignedAdClick'] = "";
$GLOBALS['strDeliveryFilenamesAdConversionVars'] = "";
$GLOBALS['strDeliveryFilenamesAdContent'] = "";
$GLOBALS['strDeliveryFilenamesAdConversion'] = "";
$GLOBALS['strDeliveryFilenamesAdConversionJS'] = "";
$GLOBALS['strDeliveryFilenamesAdFrame'] = "";
$GLOBALS['strDeliveryFilenamesAdImage'] = "صورة الاعلان";
$GLOBALS['strDeliveryFilenamesAdJS'] = "";
$GLOBALS['strDeliveryFilenamesAdLayer'] = "";
$GLOBALS['strDeliveryFilenamesAdLog'] = "";
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
$GLOBALS['strInventory'] = "المخزن";
$GLOBALS['strShowCampaignInfo'] = "";
$GLOBALS['strShowBannerInfo'] = "";
$GLOBALS['strShowCampaignPreview'] = "";
$GLOBALS['strShowBannerHTML'] = "";
$GLOBALS['strShowBannerPreview'] = "";
$GLOBALS['strUseWyswygHtmlEditorByDefault'] = "";
$GLOBALS['strHideInactive'] = "إخفاء الغير فعّال";
$GLOBALS['strGUIShowMatchingBanners'] = "";
$GLOBALS['strGUIShowParentCampaigns'] = "";
$GLOBALS['strShowEntityId'] = "";
$GLOBALS['strStatisticsDefaults'] = "";
$GLOBALS['strBeginOfWeek'] = "";
$GLOBALS['strPercentageDecimals'] = "";
$GLOBALS['strWeightDefaults'] = "الوزن الافتراضي";
$GLOBALS['strDefaultBannerWeight'] = "الوزن الافتراضي للبنر";
$GLOBALS['strDefaultCampaignWeight'] = "الوزن الافتراضي للحملة الاعلانية";
$GLOBALS['strConfirmationUI'] = "";

// Invocation Settings
$GLOBALS['strInvocationDefaults'] = "";
$GLOBALS['strEnable3rdPartyTrackingByDefault'] = "";

// Banner Delivery Settings
$GLOBALS['strBannerDelivery'] = "";

// Banner Logging Settings
$GLOBALS['strBannerLogging'] = "خيارات حجب تسجيل البنرات";
$GLOBALS['strLogAdRequests'] = "تسجيل وقت طلب البنر كل مرة يتم طلبه";
$GLOBALS['strLogAdImpressions'] = "زيادة مرات الظهور في كل مرة يتم عرض البنر";
$GLOBALS['strLogAdClicks'] = "زيادة مرات الضغطات في كل مرة يتم ضغط البنر";
$GLOBALS['strReverseLookup'] = "";
$GLOBALS['strProxyLookup'] = "";
$GLOBALS['strPreventLogging'] = "خيارات حجب تسجيل البنرات";
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
$GLOBALS['strMaintenanceOI'] = "توقيت عمليات الصيانة (كل × دقيقة)";
$GLOBALS['strPrioritySettings'] = "إعدادات الأهمية";
$GLOBALS['strPriorityInstantUpdate'] = "";
$GLOBALS['strPriorityIntentionalOverdelivery'] = "";
$GLOBALS['strDefaultImpConvWindow'] = "";
$GLOBALS['strDefaultCliConvWindow'] = "";
$GLOBALS['strAdminEmailHeaders'] = "";
$GLOBALS['strWarnLimit'] = "ارسل تحذيراً عندما يكون عدد مرات الظهور أقل من الرقم المكتوب هنا";
$GLOBALS['strWarnLimitDays'] = "";
$GLOBALS['strWarnAdmin'] = "";
$GLOBALS['strWarnClient'] = "";
$GLOBALS['strWarnAgency'] = "";

// UI Settings
$GLOBALS['strGuiSettings'] = "";
$GLOBALS['strGeneralSettings'] = "الإعدادات العامة";
$GLOBALS['strAppName'] = "اسم التطبيق";
$GLOBALS['strMyHeader'] = "";
$GLOBALS['strMyFooter'] = "";
$GLOBALS['strDefaultTrackerStatus'] = "النوع الافتراضي للمتتبع";
$GLOBALS['strDefaultTrackerType'] = "النوع الافتراضي للمتتبع";
$GLOBALS['strSSLSettings'] = "";
$GLOBALS['requireSSL'] = "";
$GLOBALS['sslPort'] = "";
$GLOBALS['strDashboardSettings'] = "";
$GLOBALS['strMyLogo'] = "اسم الشعار المخصص";
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
