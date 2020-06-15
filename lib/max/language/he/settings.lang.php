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
$GLOBALS['strInstall'] = "התקן";
$GLOBALS['strDatabaseSettings'] = "קביעות בסיס נתוני�?";
$GLOBALS['strAdminAccount'] = "System Administrator Account";
$GLOBALS['strAdvancedSettings'] = "קביעות מתקדמות";
$GLOBALS['strWarning'] = "�?זהרה";
$GLOBALS['strBtnContinue'] = "Continue »";
$GLOBALS['strBtnRecover'] = "Recover »";
$GLOBALS['strBtnAgree'] = "I Agree »";
$GLOBALS['strBtnRetry'] = "Retry";
$GLOBALS['strWarningRegisterArgcArv'] = "The PHP configuration variable register_argc_argv needs to be turned on to run maintenance from the command line.";
$GLOBALS['strTablesPrefix'] = "Table names prefix";
$GLOBALS['strTablesType'] = "סוגי הטבל�?ות";

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
$GLOBALS['strDeliveryUrlPrefix'] = "Delivery Engine URL";
$GLOBALS['strDeliveryUrlPrefixSSL'] = "Delivery Engine URL (SSL)";
$GLOBALS['strImagesUrlPrefix'] = "Image Store URL";
$GLOBALS['strImagesUrlPrefixSSL'] = "Image Store URL (SSL)";


$GLOBALS['strUpgrade'] = "Upgrade";

/* ------------------------------------------------------- */
/* Configuration translations                            */
/* ------------------------------------------------------- */

// Global
$GLOBALS['strChooseSection'] = "בחר מחלקה";
$GLOBALS['strEditConfigNotPossible'] = "It is not possible to edit all settings because the configuration file is locked for security reasons.
    If you want to make changes, you may need to unlock the configuration file for this installation first.";
$GLOBALS['strEditConfigPossible'] = "It is possible to edit all settings because the configuration file is not locked, but this could lead to security issues.
    If you want to secure your system, you need to lock the configuration file for this installation.";
$GLOBALS['strUnableToWriteConfig'] = "Unable to write changes to the config file";
$GLOBALS['strUnableToWritePrefs'] = "Unable to commit preferences to the database";
$GLOBALS['strImageDirLockedDetected'] = "The supplied <b>Images Folder</b> is not writeable by the server. <br>You can't proceed until you either change permissions of the folder or create the folder.";

// Configuration Settings
$GLOBALS['strConfigurationSettings'] = "Configuration settings";

// Administrator Settings
$GLOBALS['strAdminUsername'] = "ש�? המשתמש - מנהל";
$GLOBALS['strAdminPassword'] = "Administrator  Password";
$GLOBALS['strInvalidUsername'] = "ש�? משתמש פסול";
$GLOBALS['strBasicInformation'] = "מידע בסיסי";
$GLOBALS['strAdministratorEmail'] = "Administrator email Address";
$GLOBALS['strAdminCheckUpdates'] = "בדוק עדכוני�?";
$GLOBALS['strAdminShareStack'] = "Share technical information with the {$PRODUCT_NAME} Team to help with development and testing.";
$GLOBALS['strNovice'] = "Delete actions require confirmation for safety";
$GLOBALS['strUserlogEmail'] = " תעד �?ת כל ה�?ימייל היוצ�?";
$GLOBALS['strEnableDashboard'] = "Enable dashboard";
$GLOBALS['strEnableDashboardSyncNotice'] = "Please enable <a href='account-settings-update.php'>check for updates</a> to use the dashboard.";
$GLOBALS['strTimezone'] = "Timezone";
$GLOBALS['strEnableAutoMaintenance'] = "Automatically perform maintenance during delivery if scheduled maintenance is not set up";

// Database Settings
$GLOBALS['strDatabaseSettings'] = "קביעות בסיס נתוני�?";
$GLOBALS['strDatabaseServer'] = "שרת בסיס הנתוני�?";
$GLOBALS['strDbLocal'] = "התחבר לשרת המקומי ב�?מצעות מעברי�? (sockets)";
$GLOBALS['strDbType'] = "Database Type";
$GLOBALS['strDbHost'] = "השרת המ�?רח";
$GLOBALS['strDbSocket'] = "Database Socket";
$GLOBALS['strDbPort'] = "מספר המבו�? של בסיס הנתוני�? (port)";
$GLOBALS['strDbUser'] = "ש�? המשתמש בבסיס הנתוני�?";
$GLOBALS['strDbPassword'] = "הסיסמ�? של בסיס הנתוני�?";
$GLOBALS['strDbName'] = "הש�? של בסיס הנתוני�?";
$GLOBALS['strDbNameHint'] = "Database will be created if it does not exist";
$GLOBALS['strDatabaseOptimalisations'] = "ייטוב בסיס הנתוני�?";
$GLOBALS['strPersistentConnections'] = " השתמש בחיבור רציף (בסיס הנתוני�? תפוס יותר)";
$GLOBALS['strCantConnectToDb'] = " ל�? מסוגל להתחבר לבסיס הנתוני�?";
$GLOBALS['strCantConnectToDbDelivery'] = 'Can\'t Connect to Database for Delivery';

// Email Settings
$GLOBALS['strEmailSettings'] = "Email Settings";
$GLOBALS['strEmailAddresses'] = "Email 'From' Address";
$GLOBALS['strEmailFromName'] = "Email 'From' Name";
$GLOBALS['strEmailFromAddress'] = "Email 'From' Email Address";
$GLOBALS['strEmailFromCompany'] = "Email 'From' Company";
$GLOBALS['strUseManagerDetails'] = 'Use the owning account\'s Contact, Email and Name instead of the above Name, Email Address and Company when emailing reports to Advertiser or Website accounts.';
$GLOBALS['strQmailPatch'] = " �?פשר טל�?י qmail ";
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
$GLOBALS['strDeliveryPath'] = "Delivery path";
$GLOBALS['strImagePath'] = "Images path";
$GLOBALS['strDeliverySslPath'] = "Delivery SSL path";
$GLOBALS['strImageSslPath'] = "Images SSL path";
$GLOBALS['strImageStore'] = "Images folder";
$GLOBALS['strTypeWebSettings'] = "קונפיגורציית ב�?נר מקומי (השרת)";
$GLOBALS['strTypeWebMode'] = "שיטת �?יחסון";
$GLOBALS['strTypeWebModeLocal'] = "תיקייה מקומית";
$GLOBALS['strTypeDirError'] = "התיקייה המקומית �?ינה קיימת";
$GLOBALS['strTypeWebModeFtp'] = "שרת FTP חיצוני";
$GLOBALS['strTypeWebDir'] = "תיקייה מקומית";
$GLOBALS['strTypeFTPHost'] = "מ�?רח FTP";
$GLOBALS['strTypeFTPDirectory'] = "תיקיית FTP";
$GLOBALS['strTypeFTPUsername'] = "ש�? משתמש";
$GLOBALS['strTypeFTPPassword'] = "סיסמ�?";
$GLOBALS['strTypeFTPPassive'] = "Use passive FTP";
$GLOBALS['strTypeFTPErrorDir'] = "תקיית המ�?רח �?ינה קיימת";
$GLOBALS['strTypeFTPErrorConnect'] = "ל�? ניתן להתחבר לשרת ה-FTP, ש�? המשתמש �?ו הסיסמ�? שגויי�?";
$GLOBALS['strTypeFTPErrorNoSupport'] = "Your installation of PHP does not support FTP.";
$GLOBALS['strTypeFTPErrorUpload'] = "Could not upload file to the FTP Server, check set proper rights to Host Directory";
$GLOBALS['strTypeFTPErrorHost'] = "ש�? השרת המ�?רח �?ת ה-FTP שגוי";
$GLOBALS['strDeliveryFilenames'] = "Delivery File Names";
$GLOBALS['strDeliveryFilenamesAdClick'] = "Ad Click";
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
$GLOBALS['strP3PSettings'] = "פוליסות פרטיות מסוג P3P";
$GLOBALS['strUseP3P'] = " השתמש בפוליסות P3P";
$GLOBALS['strP3PCompactPolicy'] = "פוליסת P3P קומפקטית";
$GLOBALS['strP3PPolicyLocation'] = "מיקו�? פוליסת ה-P3P";
$GLOBALS['strPrivacySettings'] = "Privacy Settings";
$GLOBALS['strDisableViewerId'] = "Disable unique Viewer Id cookie";
$GLOBALS['strAnonymiseIp'] = "Anonymise viewer IP addresses";

// General Settings
$GLOBALS['generalSettings'] = "Global General System Settings";
$GLOBALS['uiEnabled'] = "User Interface Enabled";
$GLOBALS['defaultLanguage'] = "Default System Language<br />(Each user can select their own language)";

// Geotargeting Settings
$GLOBALS['strGeotargetingSettings'] = "Geotargeting Settings";
$GLOBALS['strGeotargeting'] = "Geotargeting - מיקוד גי�?וגרפי";
$GLOBALS['strGeotargetingType'] = "Geotargeting Module Type";
$GLOBALS['strGeoShowUnavailable'] = "Show geotargeting delivery rules even if GeoIP data unavailable";

// Interface Settings
$GLOBALS['strInventory'] = "מצ�?י";
$GLOBALS['strShowCampaignInfo'] = " הצג מידע נוסף עבור קמפיין בעמוד <i>סקירת קמפיין</i>";
$GLOBALS['strShowBannerInfo'] = " הצג מידע נוסף עבור ב�?נר בעמוד <i>סקירת ב�?נרי�?</i>";
$GLOBALS['strShowCampaignPreview'] = " תצוגה מקדמת של כל הב�?נרי�? בעמוד <i>סקירת ב�?נרי�?</i>";
$GLOBALS['strShowBannerHTML'] = " הצג ב�?נר ממשי במקו�? קוד רגיל של  HTML, במצב תצוגת ב�?נרי�? מסוג HTML";
$GLOBALS['strShowBannerPreview'] = " תצוגה מקדימה של ב�?נרי�? בכותרת העמוד העוסק בב�?נרי�?";
$GLOBALS['strUseWyswygHtmlEditorByDefault'] = "Use the WYSIWYG HTML Editor by default when creating or editing HTML banners";
$GLOBALS['strHideInactive'] = " הסתר פרטי�? ל�? פעילי�? בכל עמודי תצוגה מקדימה";
$GLOBALS['strGUIShowMatchingBanners'] = " הצג ב�?נרי�? תו�?מי�? בעמודי <i>ב�?נרי�? מקושרי�?</i>";
$GLOBALS['strGUIShowParentCampaigns'] = " הר�?ה קמפיין-�?ב בעמודי <i>ב�?נרי�? מקושרי�?</i>";
$GLOBALS['strShowEntityId'] = "Show entity identifiers";
$GLOBALS['strStatisticsDefaults'] = "סטטיסטיקה";
$GLOBALS['strBeginOfWeek'] = "השבוע מתחיל ביו�?";
$GLOBALS['strPercentageDecimals'] = "נקודה עשרונית";
$GLOBALS['strWeightDefaults'] = "משקל התחלתי (ברירת מחדל)";
$GLOBALS['strDefaultBannerWeight'] = "משקל ב�?נר התחלתי (ברירת מחדל)";
$GLOBALS['strDefaultCampaignWeight'] = "משקל קמפיין התחלתי (ברירת מחדל)";
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
$GLOBALS['strReverseLookup'] = "נסה לקבוע �?ת ספקית השירות של המבקר �?�? הנתון ל�? מגיע מהשרת";
$GLOBALS['strProxyLookup'] = "נסה לקבוע �?ת כתובת ה-IP ה�?מיתית של המבקר �?�? הו�? משתמש במ�?גר ביניי�? (proxy).";
$GLOBALS['strPreventLogging'] = "מנע התחברות";
$GLOBALS['strIgnoreHosts'] = "�?ל תתעד סטטיסטיקה ממבקרי�? המשתמשי�? ב�?חד ממספרי ה-IP �?ו שמות המ�?רחי�? הב�?י�?";
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
$GLOBALS['strAdminEmailHeaders'] = "הוסף �?ת הכותרת הב�?ה לכל �?ימייל שישלח על ידי {$PRODUCT_NAME}";
$GLOBALS['strWarnLimit'] = "שלח �?תר�?ה כ�?שר מספר החשיפות הנותר הינו פחות מהנקוב כ�?ן";
$GLOBALS['strWarnLimitDays'] = "Send a warning when the days left are less than specified here";
$GLOBALS['strWarnAdmin'] = " שלח התר�?ת מנהל בכל פע�? שקמפין מסויי�? לפני סיומו";
$GLOBALS['strWarnClient'] = " שלח התר�?ת מפרס�? בכל פע�? שהקמפין שלו לפני סיו�?";
$GLOBALS['strWarnAgency'] = "Send a warning to the account every time a campaign is almost expired";

// UI Settings
$GLOBALS['strGuiSettings'] = "קביעות ממשק משתמש";
$GLOBALS['strGeneralSettings'] = "קביעות כלליות";
$GLOBALS['strAppName'] = "ש�? היישו�? שיוצג";
$GLOBALS['strMyHeader'] = "כותרת העמוד שלי נמצ�?ת בכתובת:";
$GLOBALS['strMyFooter'] = "תחתית העמוד שלי נמצ�?ת בכתובת:";
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
$GLOBALS['strGzipContentCompression'] = "השתמש בדחיסת-תכולה GZIP";

// Regenerate Platfor Hash script
$GLOBALS['strPlatformHashRegenerate'] = "Platform Hash Regenerate";
$GLOBALS['strNewPlatformHash'] = "Your new Platform Hash is:";
$GLOBALS['strPlatformHashInsertingError'] = "Error inserting Platform Hash into database";

// Plugin Settings
$GLOBALS['strPluginSettings'] = "Plugin Settings";
$GLOBALS['strEnableNewPlugins'] = "Enable newly installed plugins";
$GLOBALS['strUseMergedFunctions'] = "Use merged delivery functions file";
