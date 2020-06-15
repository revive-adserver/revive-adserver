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
$GLOBALS['strWarningRegisterArgcArv'] = "حتى تتم عملية الصيانة من خلال سطر الأوامر يجب أن يكون المتغير register_argc_argv مفعلاً في خيارات PHP.";
$GLOBALS['strTablesPrefix'] = "Table names prefix";
$GLOBALS['strTablesType'] = "نوع الجدول";

$GLOBALS['strRecoveryRequiredTitle'] = "عملية محاولة الترقية السابقة واجهت بعض المشاكل";
$GLOBALS['strRecoveryRequired'] = "حدثت مشكلة أثناء محاولة الترقية و سيقوم برنامج {$PRODUCT_NAME} بمحاولة إصلاح عملية الترقية. إضغط زر التصحيح بالأسفل.";

$GLOBALS['strProductUpToDateTitle'] = "{$PRODUCT_NAME} is up to date";
$GLOBALS['strOaUpToDate'] = "Your {$PRODUCT_NAME} database and file structure are both using the most recent version and therefore no upgrade is required at this time. Please click Continue to proceed to the administration panel.";
$GLOBALS['strOaUpToDateCantRemove'] = "The UPGRADE file is still present inside of your 'var' folder. We are unable to remove this file because of insufficient permissions. Please delete this file yourself.";
$GLOBALS['strErrorWritePermissions'] = "هناك خلل في تصاريح الملفات ، يجب عليك إصلاحه قبل الاستمرار.<br />لحل الأخطاء في نظام لينوكس ، قم بكتابة هذه الأوامر :";
$GLOBALS['strErrorFixPermissionsRCommand'] = "<i>إعطاء التصريح a+w %s</i>";
$GLOBALS['strNotWriteable'] = "NOT writeable";
$GLOBALS['strDirNotWriteableError'] = "Directory must be writeable";

$GLOBALS['strErrorWritePermissionsWin'] = "هناك خلل في تصاريح الملفات ، يجب عليك إصلاحه قبل الاستمرار";
$GLOBALS['strCheckDocumentation'] = "لمزيد من التعليمات ، الرجاء الإطلاع على <وثائق مساعدة>. ";
$GLOBALS['strSystemCheckBadPHPConfig'] = "Your current PHP configuration does not meet requirements of {$PRODUCT_NAME}. To resolve the problems, please modify settings in your 'php.ini' file.";

$GLOBALS['strAdminUrlPrefix'] = "رابط لوحة التحكم";
$GLOBALS['strDeliveryUrlPrefix'] = "نظام التوزيع";
$GLOBALS['strDeliveryUrlPrefixSSL'] = "نظام التوزيع";
$GLOBALS['strImagesUrlPrefix'] = "رابط حفظ الصور";
$GLOBALS['strImagesUrlPrefixSSL'] = "رابط حفظ الصور (رابط آمن)";


$GLOBALS['strUpgrade'] = "Upgrade";

/* ------------------------------------------------------- */
/* Configuration translations                            */
/* ------------------------------------------------------- */

// Global
$GLOBALS['strChooseSection'] = "إختيار قسم";
$GLOBALS['strEditConfigNotPossible'] = "It is not possible to edit all settings because the configuration file is locked for security reasons.
    If you want to make changes, you may need to unlock the configuration file for this installation first.";
$GLOBALS['strEditConfigPossible'] = "It is possible to edit all settings because the configuration file is not locked, but this could lead to security issues.
    If you want to secure your system, you need to lock the configuration file for this installation.";
$GLOBALS['strUnableToWriteConfig'] = "تعذر حفظ التعديلات في ملف الإعدادات";
$GLOBALS['strUnableToWritePrefs'] = "تعذر حفظ التعديلات في قاعدة البيانات";
$GLOBALS['strImageDirLockedDetected'] = "<b>ملجد الصور</b>غير قابل للكتابة. <br> يجب عليك إنشاء المجلد او تعديل صلاحياته قبل الاستمرار";

// Configuration Settings
$GLOBALS['strConfigurationSettings'] = "تعديل الاعدادات";

// Administrator Settings
$GLOBALS['strAdminUsername'] = "اسم المستخدم للمدير";
$GLOBALS['strAdminPassword'] = "كلمة السر للمدير";
$GLOBALS['strInvalidUsername'] = "اسم المستخدم غير صالح";
$GLOBALS['strBasicInformation'] = "معلومات أساسية";
$GLOBALS['strAdministratorEmail'] = "البريد الالكتروني للمدير العام";
$GLOBALS['strAdminCheckUpdates'] = "Automatically check for product updates and security alerts (Recommended).";
$GLOBALS['strAdminShareStack'] = "Share technical information with the {$PRODUCT_NAME} Team to help with development and testing.";
$GLOBALS['strNovice'] = "نحتاج للتأكيد قبل الحذف كخطوة احترازية";
$GLOBALS['strUserlogEmail'] = "حفظ كل الرسائل الصادرة";
$GLOBALS['strEnableDashboard'] = "Enable dashboard";
$GLOBALS['strEnableDashboardSyncNotice'] = "Please enable <a href='account-settings-update.php'>check for updates</a> to use the dashboard.";
$GLOBALS['strTimezone'] = "المنطقة الزمنية";
$GLOBALS['strEnableAutoMaintenance'] = "Automatically perform maintenance during delivery if scheduled maintenance is not set up";

// Database Settings
$GLOBALS['strDatabaseSettings'] = "خيارات قواعد البيانات";
$GLOBALS['strDatabaseServer'] = "الإعدادات العامة لمستضيف قاعدة البيانات";
$GLOBALS['strDbLocal'] = "Use local socket connection";
$GLOBALS['strDbType'] = "نوع قاعدة البيانات";
$GLOBALS['strDbHost'] = "مستضيف قاعدة البيانات";
$GLOBALS['strDbSocket'] = "Database Socket";
$GLOBALS['strDbPort'] = "رقم المنفذ (بورت) قاعدة البيانات";
$GLOBALS['strDbUser'] = "اسم مستخدم قاعدة البيانات";
$GLOBALS['strDbPassword'] = "كلمة سر قاعدة البيانات";
$GLOBALS['strDbName'] = "اسم قاعدة البيانات";
$GLOBALS['strDbNameHint'] = "Database will be created if it does not exist";
$GLOBALS['strDatabaseOptimalisations'] = "Database Optimisation Settings";
$GLOBALS['strPersistentConnections'] = "استخدام الاتصال المستمر";
$GLOBALS['strCantConnectToDb'] = "لا يمكن الاتصال بقاعدة البيانات";
$GLOBALS['strCantConnectToDbDelivery'] = 'Can\'t Connect to Database for Delivery';

// Email Settings
$GLOBALS['strEmailSettings'] = "Email Settings";
$GLOBALS['strEmailAddresses'] = "Email 'From' Address";
$GLOBALS['strEmailFromName'] = "Email 'From' Name";
$GLOBALS['strEmailFromAddress'] = "Email 'From' Email Address";
$GLOBALS['strEmailFromCompany'] = "Email 'From' Company";
$GLOBALS['strUseManagerDetails'] = 'Use the owning account\'s Contact, Email and Name instead of the above Name, Email Address and Company when emailing reports to Advertiser or Website accounts.';
$GLOBALS['strQmailPatch'] = "qmail patch";
$GLOBALS['strEnableQmailPatch'] = "Enable qmail patch";
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
$GLOBALS['strDebugTypeFile'] = "ملف";
$GLOBALS['strDebugTypeMcal'] = "mCal";
$GLOBALS['strDebugTypeSql'] = "قاعدة بيانات SQL";
$GLOBALS['strDebugTypeSyslog'] = "سجل النظام";
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
$GLOBALS['strDeliveryPath'] = "Delivery path";
$GLOBALS['strImagePath'] = "مسار الصور";
$GLOBALS['strDeliverySslPath'] = "Delivery SSL path";
$GLOBALS['strImageSslPath'] = "مسار الصور (آمن)";
$GLOBALS['strImageStore'] = "مجلد الصور";
$GLOBALS['strTypeWebSettings'] = "Webserver Local Banner Storage Settings";
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
$GLOBALS['strTypeFTPErrorNoSupport'] = "Your installation of PHP does not support FTP.";
$GLOBALS['strTypeFTPErrorUpload'] = "Could not upload file to the FTP Server, check set proper rights to Host Directory";
$GLOBALS['strTypeFTPErrorHost'] = "عنوان مستضيف FTP غير صحيح";
$GLOBALS['strDeliveryFilenames'] = "Delivery File Names";
$GLOBALS['strDeliveryFilenamesAdClick'] = "رابط الضغط على الإعلان";
$GLOBALS['strDeliveryFilenamesAdConversionVars'] = "Ad Conversion Variables";
$GLOBALS['strDeliveryFilenamesAdContent'] = "Ad Content";
$GLOBALS['strDeliveryFilenamesAdConversion'] = "Ad Conversion";
$GLOBALS['strDeliveryFilenamesAdConversionJS'] = "Ad Conversion (JavaScript)";
$GLOBALS['strDeliveryFilenamesAdFrame'] = "Ad Frame";
$GLOBALS['strDeliveryFilenamesAdImage'] = "صورة الاعلان";
$GLOBALS['strDeliveryFilenamesAdJS'] = "Ad (JavaScript)";
$GLOBALS['strDeliveryFilenamesAdLayer'] = "Ad Layer";
$GLOBALS['strDeliveryFilenamesAdLog'] = "Ad Log";
$GLOBALS['strDeliveryFilenamesAdPopup'] = "Ad Popup";
$GLOBALS['strDeliveryFilenamesAdView'] = "Ad View";
$GLOBALS['strDeliveryFilenamesXMLRPC'] = "XML RPC Invocation";
$GLOBALS['strDeliveryFilenamesLocal'] = "Local Invocation";
$GLOBALS['strDeliveryFilenamesFrontController'] = "Front Controller";
$GLOBALS['strDeliveryFilenamesFlash'] = "Flash Include (Can be a full URL)";
$GLOBALS['strDeliveryFilenamesSinglePageCall'] = "Single Page Call";
$GLOBALS['strDeliveryFilenamesSinglePageCallJS'] = "Single Page Call (JavaScript)";
$GLOBALS['strDeliveryCaching'] = "Banner Delivery Cache Settings";
$GLOBALS['strDeliveryCacheLimit'] = "Time Between Banner Cache Updates (seconds)";
$GLOBALS['strDeliveryCacheStore'] = "Banner Delivery Cache Store Type";
$GLOBALS['strDeliveryAcls'] = "Evaluate banner delivery rules during delivery";
$GLOBALS['strDeliveryAclsDirectSelection'] = "Evaluate banner delivery rules for direct selected ads";
$GLOBALS['strDeliveryObfuscate'] = "Obfuscate delivery rule set when delivering ads";
$GLOBALS['strDeliveryExecPhp'] = "Allow PHP code in ads to be executed<br />(Warning: Security risk)";
$GLOBALS['strDeliveryCtDelimiter'] = "3rd Party Click Tracking Delimiter";
$GLOBALS['strGlobalDefaultBannerUrl'] = "Global default Banner Image URL";
$GLOBALS['strP3PSettings'] = "P3P Privacy Policies";
$GLOBALS['strUseP3P'] = "Use P3P Policies";
$GLOBALS['strP3PCompactPolicy'] = "P3P Compact Policy";
$GLOBALS['strP3PPolicyLocation'] = "P3P Policy Location";
$GLOBALS['strPrivacySettings'] = "Privacy Settings";
$GLOBALS['strDisableViewerId'] = "Disable unique Viewer Id cookie";
$GLOBALS['strAnonymiseIp'] = "Anonymise viewer IP addresses";

// General Settings
$GLOBALS['generalSettings'] = "Global General System Settings";
$GLOBALS['uiEnabled'] = "User Interface Enabled";
$GLOBALS['defaultLanguage'] = "Default System Language<br />(Each user can select their own language)";

// Geotargeting Settings
$GLOBALS['strGeotargetingSettings'] = "Geotargeting Settings";
$GLOBALS['strGeotargeting'] = "Geotargeting Settings";
$GLOBALS['strGeotargetingType'] = "Geotargeting Module Type";
$GLOBALS['strGeoShowUnavailable'] = "Show geotargeting delivery rules even if GeoIP data unavailable";

// Interface Settings
$GLOBALS['strInventory'] = "المخزن";
$GLOBALS['strShowCampaignInfo'] = "Show extra campaign info on <i>Campaigns</i> page";
$GLOBALS['strShowBannerInfo'] = "Show extra banner info on <i>Banners</i> page";
$GLOBALS['strShowCampaignPreview'] = "Show preview of all banners on <i>Banners</i> page";
$GLOBALS['strShowBannerHTML'] = "Show actual banner instead of plain HTML code for HTML banner preview";
$GLOBALS['strShowBannerPreview'] = "Show banner preview at the top of pages which deal with banners";
$GLOBALS['strUseWyswygHtmlEditorByDefault'] = "Use the WYSIWYG HTML Editor by default when creating or editing HTML banners";
$GLOBALS['strHideInactive'] = "إخفاء الغير فعّال";
$GLOBALS['strGUIShowMatchingBanners'] = "Show matching banners on the <i>Linked banner</i> pages";
$GLOBALS['strGUIShowParentCampaigns'] = "Show parent campaigns on the <i>Linked banner</i> pages";
$GLOBALS['strShowEntityId'] = "Show entity identifiers";
$GLOBALS['strStatisticsDefaults'] = "Statistics";
$GLOBALS['strBeginOfWeek'] = "Beginning of Week";
$GLOBALS['strPercentageDecimals'] = "Percentage Decimals";
$GLOBALS['strWeightDefaults'] = "الوزن الافتراضي";
$GLOBALS['strDefaultBannerWeight'] = "الوزن الافتراضي للبنر";
$GLOBALS['strDefaultCampaignWeight'] = "الوزن الافتراضي للحملة الاعلانية";
$GLOBALS['strConfirmationUI'] = "Confirmation in User Interface";

// Invocation Settings
$GLOBALS['strInvocationDefaults'] = "Invocation Defaults";
$GLOBALS['strEnable3rdPartyTrackingByDefault'] = "Enable 3rd Party Clicktracking by Default";

// Banner Delivery Settings
$GLOBALS['strBannerDelivery'] = "Banner Delivery Settings";

// Banner Logging Settings
$GLOBALS['strBannerLogging'] = "خيارات حجب تسجيل البنرات";
$GLOBALS['strLogAdRequests'] = "تسجيل وقت طلب البنر كل مرة يتم طلبه";
$GLOBALS['strLogAdImpressions'] = "زيادة مرات الظهور في كل مرة يتم عرض البنر";
$GLOBALS['strLogAdClicks'] = "زيادة مرات الضغطات في كل مرة يتم ضغط البنر";
$GLOBALS['strReverseLookup'] = "Reverse lookup the hostnames of viewers when not supplied";
$GLOBALS['strProxyLookup'] = "Try to determine the real IP address of viewers behind a proxy server";
$GLOBALS['strPreventLogging'] = "خيارات حجب تسجيل البنرات";
$GLOBALS['strIgnoreHosts'] = "Don't log any statistics for viewers using any of the following IP addresses or hostnames";
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
$GLOBALS['strMaintenanceOI'] = "توقيت عمليات الصيانة (كل × دقيقة)";
$GLOBALS['strPrioritySettings'] = "إعدادات الأهمية";
$GLOBALS['strPriorityInstantUpdate'] = "Update advertisement priorities immediately when changes made in the UI";
$GLOBALS['strPriorityIntentionalOverdelivery'] = "Intentionally over-deliver Contract Campaigns<br />(% over-delivery)";
$GLOBALS['strDefaultImpConvWindow'] = "Default Ad Impression Conversion Window (seconds)";
$GLOBALS['strDefaultCliConvWindow'] = "Default Ad Click Conversion Window (seconds)";
$GLOBALS['strAdminEmailHeaders'] = "Add the following headers to each email message sent by {$PRODUCT_NAME}";
$GLOBALS['strWarnLimit'] = "ارسل تحذيراً عندما يكون عدد مرات الظهور أقل من الرقم المكتوب هنا";
$GLOBALS['strWarnLimitDays'] = "Send a warning when the days left are less than specified here";
$GLOBALS['strWarnAdmin'] = "Send a warning to the administrator every time a campaign is almost expired";
$GLOBALS['strWarnClient'] = "Send a warning to the advertiser every time a campaign is almost expired";
$GLOBALS['strWarnAgency'] = "Send a warning to the account every time a campaign is almost expired";

// UI Settings
$GLOBALS['strGuiSettings'] = "User Interface Settings";
$GLOBALS['strGeneralSettings'] = "الإعدادات العامة";
$GLOBALS['strAppName'] = "اسم التطبيق";
$GLOBALS['strMyHeader'] = "Header File Location";
$GLOBALS['strMyFooter'] = "Footer File Location";
$GLOBALS['strDefaultTrackerStatus'] = "النوع الافتراضي للمتتبع";
$GLOBALS['strDefaultTrackerType'] = "النوع الافتراضي للمتتبع";
$GLOBALS['strSSLSettings'] = "SSL Settings";
$GLOBALS['requireSSL'] = "Force SSL Access on User Interface";
$GLOBALS['sslPort'] = "SSL Port Used by Web Server";
$GLOBALS['strDashboardSettings'] = "Dashboard Settings";
$GLOBALS['strMyLogo'] = "اسم الشعار المخصص";
$GLOBALS['strGuiHeaderForegroundColor'] = "Color of the header foreground";
$GLOBALS['strGuiHeaderBackgroundColor'] = "Color of the header background";
$GLOBALS['strGuiActiveTabColor'] = "Color of the active tab";
$GLOBALS['strGuiHeaderTextColor'] = "Color of the text in the header";
$GLOBALS['strGuiSupportLink'] = "Custom URL for 'Support' link in header";
$GLOBALS['strGzipContentCompression'] = "Use GZIP Content Compression";

// Regenerate Platfor Hash script
$GLOBALS['strPlatformHashRegenerate'] = "Platform Hash Regenerate";
$GLOBALS['strNewPlatformHash'] = "Your new Platform Hash is:";
$GLOBALS['strPlatformHashInsertingError'] = "Error inserting Platform Hash into database";

// Plugin Settings
$GLOBALS['strPluginSettings'] = "Plugin Settings";
$GLOBALS['strEnableNewPlugins'] = "Enable newly installed plugins";
$GLOBALS['strUseMergedFunctions'] = "Use merged delivery functions file";
