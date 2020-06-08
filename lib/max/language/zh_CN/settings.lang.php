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
$GLOBALS['strInstall'] = "安装";
$GLOBALS['strDatabaseSettings'] = "数据库";
$GLOBALS['strAdminAccount'] = "Administrator Account";
$GLOBALS['strAdvancedSettings'] = "高级设置";
$GLOBALS['strWarning'] = "警告！​​​​​";
$GLOBALS['strBtnContinue'] = "继续»";
$GLOBALS['strBtnRecover'] = "恢复»";
$GLOBALS['strBtnAgree'] = "我同意»";
$GLOBALS['strBtnRetry'] = "重试";
$GLOBALS['strWarningRegisterArgcArv'] = "The PHP configuration variable register_argc_argv needs to be turned on to run maintenance from the command line.";
$GLOBALS['strTablesPrefix'] = "Table names prefix";
$GLOBALS['strTablesType'] = "Table type";

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


$GLOBALS['strUpgrade'] = "升级";

/* ------------------------------------------------------- */
/* Configuration translations                            */
/* ------------------------------------------------------- */

// Global
$GLOBALS['strChooseSection'] = "请选择任务";
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
$GLOBALS['strAdminUsername'] = "管理员用户名";
$GLOBALS['strAdminPassword'] = "管理员密码";
$GLOBALS['strInvalidUsername'] = "无效的用户名";
$GLOBALS['strBasicInformation'] = "Basic Information";
$GLOBALS['strAdministratorEmail'] = "管理员邮箱地址";
$GLOBALS['strAdminCheckUpdates'] = "Automatically check for product updates and security alerts (Recommended).";
$GLOBALS['strAdminShareStack'] = "Share technical information with the {$PRODUCT_NAME} Team to help with development and testing.";
$GLOBALS['strNovice'] = "执行删除操作之前需要确认";
$GLOBALS['strUserlogEmail'] = "Log all outgoing email messages";
$GLOBALS['strEnableDashboard'] = "启用首页仪表盘";
$GLOBALS['strEnableDashboardSyncNotice'] = "Please enable <a href='account-settings-update.php'>check for updates</a> to use the dashboard.";
$GLOBALS['strTimezone'] = "时区";
$GLOBALS['strEnableAutoMaintenance'] = "Automatically perform maintenance during delivery if scheduled maintenance is not set up";

// Database Settings
$GLOBALS['strDatabaseSettings'] = "数据库";
$GLOBALS['strDatabaseServer'] = "数据库服务器设置";
$GLOBALS['strDbLocal'] = "Use local socket connection";
$GLOBALS['strDbType'] = "数据库类型";
$GLOBALS['strDbHost'] = "Database Hostname";
$GLOBALS['strDbSocket'] = "Database Socket";
$GLOBALS['strDbPort'] = "Database Port Number";
$GLOBALS['strDbUser'] = "Database Username";
$GLOBALS['strDbPassword'] = "Database Password";
$GLOBALS['strDbName'] = "Database Name";
$GLOBALS['strDbNameHint'] = "Database will be created if it does not exist";
$GLOBALS['strDatabaseOptimalisations'] = "Database Optimisation Settings";
$GLOBALS['strPersistentConnections'] = "Use Persistent Connections";
$GLOBALS['strCantConnectToDb'] = "Can't Connect to Database";
$GLOBALS['strCantConnectToDbDelivery'] = 'Can\'t Connect to Database for Delivery';

// Email Settings
$GLOBALS['strEmailSettings'] = "Email 功能";
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
$GLOBALS['strDebug'] = "调试日志";
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
$GLOBALS['strTypeWebSettings'] = "Webserver Local Banner Storage Settings";
$GLOBALS['strTypeWebMode'] = "Storing Method";
$GLOBALS['strTypeWebModeLocal'] = "Local Directory";
$GLOBALS['strTypeDirError'] = "The local directory cannot be written to by the web server";
$GLOBALS['strTypeWebModeFtp'] = "External FTP Server";
$GLOBALS['strTypeWebDir'] = "Local Directory";
$GLOBALS['strTypeFTPHost'] = "FTP Host";
$GLOBALS['strTypeFTPDirectory'] = "Host Directory";
$GLOBALS['strTypeFTPUsername'] = "登录";
$GLOBALS['strTypeFTPPassword'] = "密码";
$GLOBALS['strTypeFTPPassive'] = "Use passive FTP";
$GLOBALS['strTypeFTPErrorDir'] = "The FTP Host Directory does not exist";
$GLOBALS['strTypeFTPErrorConnect'] = "Could not connect to the FTP Server, the Login or Password is not correct";
$GLOBALS['strTypeFTPErrorNoSupport'] = "Your installation of PHP does not support FTP.";
$GLOBALS['strTypeFTPErrorUpload'] = "Could not upload file to the FTP Server, check set proper rights to Host Directory";
$GLOBALS['strTypeFTPErrorHost'] = "The FTP Host is not correct";
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
$GLOBALS['strDeliveryCaching'] = "素材缓存";
$GLOBALS['strDeliveryCacheLimit'] = "更新间隔（秒）";
$GLOBALS['strDeliveryCacheStore'] = "存储类型";
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
$GLOBALS['strGeotargetingSettings'] = "地理信息库";
$GLOBALS['strGeotargeting'] = "地理信息库";
$GLOBALS['strGeotargetingType'] = "Geotargeting Module Type";
$GLOBALS['strGeoShowUnavailable'] = "Show geotargeting delivery rules even if GeoIP data unavailable";

// Interface Settings
$GLOBALS['strInventory'] = "管理界面";
$GLOBALS['strShowCampaignInfo'] = "在<i>项目列表</i>页面显示更多信息";
$GLOBALS['strShowBannerInfo'] = "在<i>素材列表</i>页面显示更多信息";
$GLOBALS['strShowCampaignPreview'] = "在<i>素材列表</i>页面显示所有素材的预览";
$GLOBALS['strShowBannerHTML'] = "预览 HTML 素材时显示实际内容（而不是 HTML 代码）";
$GLOBALS['strShowBannerPreview'] = "在所有操作素材的页面顶部显示素材预览";
$GLOBALS['strUseWyswygHtmlEditorByDefault'] = "Use the WYSIWYG HTML Editor by default when creating or editing HTML banners";
$GLOBALS['strHideInactive'] = "在所有列表页面隐藏无效的行";
$GLOBALS['strGUIShowMatchingBanners'] = "在<i>素材关联<i>页面显示可匹配的素材";
$GLOBALS['strGUIShowParentCampaigns'] = "在<i>素材关联<i>页面显示素材所属的项目";
$GLOBALS['strShowEntityId'] = "显示 ID";
$GLOBALS['strStatisticsDefaults'] = "报表";
$GLOBALS['strBeginOfWeek'] = "每周的第一天";
$GLOBALS['strPercentageDecimals'] = "精确到小数点后...位";
$GLOBALS['strWeightDefaults'] = "默认权重";
$GLOBALS['strDefaultBannerWeight'] = "素材";
$GLOBALS['strDefaultCampaignWeight'] = "项目";
$GLOBALS['strConfirmationUI'] = "操作确认";

// Invocation Settings
$GLOBALS['strInvocationDefaults'] = "Invocation Defaults";
$GLOBALS['strEnable3rdPartyTrackingByDefault'] = "Enable 3rd Party Clicktracking by Default";

// Banner Delivery Settings
$GLOBALS['strBannerDelivery'] = "素材投放";

// Banner Logging Settings
$GLOBALS['strBannerLogging'] = "素材投放日志";
$GLOBALS['strLogAdRequests'] = "Log a request every time a banner is requested";
$GLOBALS['strLogAdImpressions'] = "Log an impression every time a banner is viewed";
$GLOBALS['strLogAdClicks'] = "Log a click every time a viewer clicks on a banner";
$GLOBALS['strReverseLookup'] = "Reverse lookup the hostnames of viewers when not supplied";
$GLOBALS['strProxyLookup'] = "Try to determine the real IP address of viewers behind a proxy server";
$GLOBALS['strPreventLogging'] = "Block Banner Logging Settings";
$GLOBALS['strIgnoreHosts'] = "Don't log any statistics for viewers using any of the following IP addresses or hostnames";
$GLOBALS['strIgnoreUserAgents'] = "<b>Don't</b> log statistics from clients with any of the following strings in their user-agent (one-per-line)";
$GLOBALS['strEnforceUserAgents'] = "<b>Only</b> log statistics from clients with any of the following strings in their user-agent (one-per-line)";

// Banner Storage Settings
$GLOBALS['strBannerStorage'] = "素材存储";

// Campaign ECPM settings
$GLOBALS['strEnableECPM'] = "Use eCPM optimized priorities instead of remnant-weighted priorities";
$GLOBALS['strEnableContractECPM'] = "Use eCPM optimized priorities instead of standard contract priorities";
$GLOBALS['strEnableECPMfromRemnant'] = "(If you enable this feature all your remnant campaigns will be deactivated, you will have to update them manually to reactivate them)";
$GLOBALS['strEnableECPMfromECPM'] = "(If you disable this feature some of your active eCPM campaigns will be deactivated, you will have to update them manually to reactivate them)";
$GLOBALS['strInactivatedCampaigns'] = "List of campaigns which became inactive due to the changes in preferences:";

// Statistics & Maintenance Settings
$GLOBALS['strMaintenanceSettings'] = "维护任务";
$GLOBALS['strConversionTracking'] = "数据追踪";
$GLOBALS['strEnableConversionTracking'] = "Enable Conversion Tracking";
$GLOBALS['strBlockInactiveBanners'] = "Don't count ad impressions, clicks or re-direct the user to the target URL if the viewer clicks on a banner that is inactive";
$GLOBALS['strBlockAdClicks'] = "Don't count ad clicks if the viewer has clicked on the same ad/zone pair within the specified time (seconds)";
$GLOBALS['strMaintenanceOI'] = "Maintenance Operation Interval (minutes)";
$GLOBALS['strPrioritySettings'] = "Priority Settings";
$GLOBALS['strPriorityInstantUpdate'] = "Update advertisement priorities immediately when changes made in the UI";
$GLOBALS['strPriorityIntentionalOverdelivery'] = "Intentionally over-deliver Contract Campaigns<br />(% over-delivery)";
$GLOBALS['strDefaultImpConvWindow'] = "Default Ad Impression Conversion Window (seconds)";
$GLOBALS['strDefaultCliConvWindow'] = "Default Ad Click Conversion Window (seconds)";
$GLOBALS['strAdminEmailHeaders'] = "Add the following headers to each email message sent by {$PRODUCT_NAME}";
$GLOBALS['strWarnLimit'] = "如果剩余投放量低于";
$GLOBALS['strWarnLimitDays'] = "如果剩余天数少于";
$GLOBALS['strWarnAdmin'] = "项目即将过期时发送通知";
$GLOBALS['strWarnClient'] = "项目即将过期时发送通知";
$GLOBALS['strWarnAgency'] = "项目即将过期时发送通知";

// UI Settings
$GLOBALS['strGuiSettings'] = "用户界面";
$GLOBALS['strGeneralSettings'] = "基本";
$GLOBALS['strAppName'] = "系统名称";
$GLOBALS['strMyHeader'] = "页眉文件";
$GLOBALS['strMyFooter'] = "页脚文件";
$GLOBALS['strDefaultTrackerStatus'] = "Default tracker status";
$GLOBALS['strDefaultTrackerType'] = "Default tracker type";
$GLOBALS['strSSLSettings'] = "HTTPS";
$GLOBALS['requireSSL'] = "强制使用 HTTPS 登录用户界面";
$GLOBALS['sslPort'] = "HTTPS 端口";
$GLOBALS['strDashboardSettings'] = "首页仪表盘";
$GLOBALS['strMyLogo'] = "Logo 文件名或 URL";
$GLOBALS['strGuiHeaderForegroundColor'] = "页眉前景色";
$GLOBALS['strGuiHeaderBackgroundColor'] = "页眉背景色";
$GLOBALS['strGuiActiveTabColor'] = "激活标签颜色";
$GLOBALS['strGuiHeaderTextColor'] = "页眉文本颜色";
$GLOBALS['strGuiSupportLink'] = "Custom URL for 'Support' link in header";
$GLOBALS['strGzipContentCompression'] = "使用 GZIP 压缩";

// Regenerate Platfor Hash script
$GLOBALS['strPlatformHashRegenerate'] = "Platform Hash Regenerate";
$GLOBALS['strNewPlatformHash'] = "Your new Platform Hash is:";
$GLOBALS['strPlatformHashInsertingError'] = "Error inserting Platform Hash into database";

// Plugin Settings
$GLOBALS['strPluginSettings'] = "插件";
$GLOBALS['strEnableNewPlugins'] = "Enable newly installed plugins";
$GLOBALS['strUseMergedFunctions'] = "Use merged delivery functions file";
