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
$GLOBALS['strInstall'] = "安裝";
$GLOBALS['strDatabaseSettings'] = "數據庫設置";
$GLOBALS['strAdminAccount'] = "管理員帳號";
$GLOBALS['strAdvancedSettings'] = "高級設置";
$GLOBALS['strWarning'] = "警告";
$GLOBALS['strBtnContinue'] = "繼續》";
$GLOBALS['strBtnRecover'] = "恢復》";
$GLOBALS['strBtnAgree'] = "我同意》";
$GLOBALS['strBtnRetry'] = "重試";
$GLOBALS['strWarningRegisterArgcArv'] = "如許運行維護腳本，您需要開啟PHP配置變量中的register_argc_argv";
$GLOBALS['strTablesPrefix'] = "Table names prefix";
$GLOBALS['strTablesType'] = "表格類型";

$GLOBALS['strRecoveryRequiredTitle'] = "你以前嘗試升級遇到一個錯誤";
$GLOBALS['strRecoveryRequired'] = "你之前升級{$PRODUCT_NAME}中出現了一個錯誤，請點擊恢復按鈕恢復到錯誤產生之前的狀態。 ";

$GLOBALS['strProductUpToDateTitle'] = "{$PRODUCT_NAME} is up to date";
$GLOBALS['strOaUpToDate'] = "您的{$PRODUCT_NAME}和數據庫都使用的都是最新的版本，沒有需要更新的。請點擊繼續進入管理員面板。 ";
$GLOBALS['strOaUpToDateCantRemove'] = "警告: 升級文件仍在var目錄。因為權限不夠，我們無法移除此檔案。請先手動刪除該文件吧。 ";
$GLOBALS['strErrorWritePermissions'] = "文件權限錯誤。
 </br>在Linux下修正這個錯誤，請輸入以下命令: ";
$GLOBALS['strErrorFixPermissionsRCommand'] = "<i>chmod a+w %s</i>";
$GLOBALS['strNotWriteable'] = "NOT writeable";
$GLOBALS['strDirNotWriteableError'] = "Directory must be writeable";

$GLOBALS['strErrorWritePermissionsWin'] = "文件權限錯誤。您必須先修正這個錯誤才可繼續下一步。 ";
$GLOBALS['strCheckDocumentation'] = "需要幫助，請參閱 <a href='http://{$PRODUCT_DOCSURL}'>{$PRODUCT_NAME} 文檔.</a> ";
$GLOBALS['strSystemCheckBadPHPConfig'] = "Your current PHP configuration does not meet requirements of {$PRODUCT_NAME}. To resolve the problems, please modify settings in your 'php.ini' file.";

$GLOBALS['strAdminUrlPrefix'] = "管理員介面路徑";
$GLOBALS['strDeliveryUrlPrefix'] = "發布引擎路徑";
$GLOBALS['strDeliveryUrlPrefixSSL'] = "發布引擎路徑 (SSL)";
$GLOBALS['strImagesUrlPrefix'] = "由於安全原因無法編輯所有設定。如果你希望修改，你需要解鎖配置文件。 ";
$GLOBALS['strImagesUrlPrefixSSL'] = "由於安全原因無法編輯所有設定。如果你希望修改，你需要解鎖配置文件。 (SSL)";


$GLOBALS['strUpgrade'] = "Upgrade";

/* ------------------------------------------------------- */
/* Configuration translations                            */
/* ------------------------------------------------------- */

// Global
$GLOBALS['strChooseSection'] = "選擇章節";
$GLOBALS['strEditConfigNotPossible'] = "It is not possible to edit all settings because the configuration file is locked for security reasons.
    If you want to make changes, you may need to unlock the configuration file for this installation first.";
$GLOBALS['strEditConfigPossible'] = "It is possible to edit all settings because the configuration file is not locked, but this could lead to security issues.
    If you want to secure your system, you need to lock the configuration file for this installation.";
$GLOBALS['strUnableToWriteConfig'] = "無法修改配置文件";
$GLOBALS['strUnableToWritePrefs'] = "無法向數據庫提交屬性更改 ";
$GLOBALS['strImageDirLockedDetected'] = "<b>圖片文件夾</b>不可寫<br>在修改文件夾權限之前無法修改或創建相關文件夾。";

// Configuration Settings
$GLOBALS['strConfigurationSettings'] = "Configuration settings";

// Administrator Settings
$GLOBALS['strAdminUsername'] = "管理員用戶名";
$GLOBALS['strAdminPassword'] = "管理員密碼";
$GLOBALS['strInvalidUsername'] = "用戶名不正確";
$GLOBALS['strBasicInformation'] = "基本信息";
$GLOBALS['strAdministratorEmail'] = "管理員郵件地址";
$GLOBALS['strAdminCheckUpdates'] = "Automatically check for product updates and security alerts (Recommended).";
$GLOBALS['strAdminShareStack'] = "Share technical information with the {$PRODUCT_NAME} Team to help with development and testing.";
$GLOBALS['strNovice'] = "管理員的刪除操作需確認";
$GLOBALS['strUserlogEmail'] = "記錄所有發出郵件資訊";
$GLOBALS['strEnableDashboard'] = "Enable dashboard";
$GLOBALS['strEnableDashboardSyncNotice'] = "Please enable <a href='account-settings-update.php'>check for updates</a> to use the dashboard.";
$GLOBALS['strTimezone'] = "時區";
$GLOBALS['strEnableAutoMaintenance'] = "運行期間的自動維護還未設定";

// Database Settings
$GLOBALS['strDatabaseSettings'] = "數據庫設置";
$GLOBALS['strDatabaseServer'] = "全局數據庫伺服器設置";
$GLOBALS['strDbLocal'] = "Use local socket connection";
$GLOBALS['strDbType'] = "數據庫類型";
$GLOBALS['strDbHost'] = "數據庫主機名";
$GLOBALS['strDbSocket'] = "Database Socket";
$GLOBALS['strDbPort'] = "數據庫端口號";
$GLOBALS['strDbUser'] = "數據庫用戶名";
$GLOBALS['strDbPassword'] = "數據庫密碼";
$GLOBALS['strDbName'] = "數據庫名";
$GLOBALS['strDbNameHint'] = "Database will be created if it does not exist";
$GLOBALS['strDatabaseOptimalisations'] = "全局數據庫優化設置";
$GLOBALS['strPersistentConnections'] = "使用持久連結";
$GLOBALS['strCantConnectToDb'] = "無法連結數據庫";
$GLOBALS['strCantConnectToDbDelivery'] = 'Can\'t Connect to Database for Delivery';

// Email Settings
$GLOBALS['strEmailSettings'] = "電子郵件設置";
$GLOBALS['strEmailAddresses'] = "Email 'From' Address";
$GLOBALS['strEmailFromName'] = "Email 'From' Name";
$GLOBALS['strEmailFromAddress'] = "Email 'From' Email Address";
$GLOBALS['strEmailFromCompany'] = "Email 'From' Company";
$GLOBALS['strUseManagerDetails'] = 'Use the owning account\'s Contact, Email and Name instead of the above Name, Email Address and Company when emailing reports to Advertiser or Website accounts.';
$GLOBALS['strQmailPatch'] = "qmail的補丁";
$GLOBALS['strEnableQmailPatch'] = "啟用qmail補丁";
$GLOBALS['strEmailHeader'] = "電子郵件標題";
$GLOBALS['strEmailLog'] = "電子郵件日誌";

// Audit Trail Settings
$GLOBALS['strAuditTrailSettings'] = "審計追蹤設置";
$GLOBALS['strEnableAudit'] = "啟用審計追蹤";
$GLOBALS['strEnableAuditForZoneLinking'] = "Enable Audit Trail for Zone Linking screen (introduces huge performance penalty when linking large amounts of zones)";

// Debug Logging Settings
$GLOBALS['strDebug'] = "調試日誌設置";
$GLOBALS['strEnableDebug'] = "啟用調試日誌";
$GLOBALS['strDebugMethodNames'] = "在調試日誌中包括方法名";
$GLOBALS['strDebugLineNumbers'] = "在調試日誌中包括方線程號碼";
$GLOBALS['strDebugType'] = "調試日誌類型";
$GLOBALS['strDebugTypeFile'] = "文件";
$GLOBALS['strDebugTypeMcal'] = "mCal";
$GLOBALS['strDebugTypeSql'] = "SQL數據庫";
$GLOBALS['strDebugTypeSyslog'] = "系統日誌";
$GLOBALS['strDebugName'] = "除錯日誌名，日曆，SQL表格或系統日誌工具";
$GLOBALS['strDebugPriority'] = "除錯優先級";
$GLOBALS['strPEAR_LOG_DEBUG'] = "PEAR_LOG_DEBUG - 所有信息";
$GLOBALS['strPEAR_LOG_INFO'] = "PEAR_LOG_INFO - 默認信息";
$GLOBALS['strPEAR_LOG_NOTICE'] = "PEAR_LOG_NOTICE";
$GLOBALS['strPEAR_LOG_WARNING'] = "PEAR_LOG_WARNING";
$GLOBALS['strPEAR_LOG_ERR'] = "PEAR_LOG_ERR";
$GLOBALS['strPEAR_LOG_CRIT'] = "PEAR_LOG_CRIT";
$GLOBALS['strPEAR_LOG_ALERT'] = "PEAR_LOG_ALERT";
$GLOBALS['strPEAR_LOG_EMERG'] = "PEAR_LOG_EMERG - 最少信息";
$GLOBALS['strDebugIdent'] = "調試鑑定弦";
$GLOBALS['strDebugUsername'] = "mCal, SQL Server Username";
$GLOBALS['strDebugPassword'] = "mCal, SQL Server Password";
$GLOBALS['strProductionSystem'] = "Production System";

// Delivery Settings
$GLOBALS['strWebPath'] = "{$PRODUCT_NAME} Server Access Paths";
$GLOBALS['strWebPathSimple'] = "頁面路徑";
$GLOBALS['strDeliveryPath'] = "發布緩存";
$GLOBALS['strImagePath'] = "圖片路徑";
$GLOBALS['strDeliverySslPath'] = "發布SSL緩存";
$GLOBALS['strImageSslPath'] = "圖片SSL路徑";
$GLOBALS['strImageStore'] = "圖片文件夾";
$GLOBALS['strTypeWebSettings'] = "Webserver本地廣告全局存儲設置 ";
$GLOBALS['strTypeWebMode'] = "存儲模式";
$GLOBALS['strTypeWebModeLocal'] = "本地目錄";
$GLOBALS['strTypeDirError'] = "無法通過Web Server寫入本地目錄 ";
$GLOBALS['strTypeWebModeFtp'] = "External FTP Server";
$GLOBALS['strTypeWebDir'] = "本地目錄";
$GLOBALS['strTypeFTPHost'] = "FTP主機";
$GLOBALS['strTypeFTPDirectory'] = "主機目錄";
$GLOBALS['strTypeFTPUsername'] = "登錄";
$GLOBALS['strTypeFTPPassword'] = "密碼";
$GLOBALS['strTypeFTPPassive'] = "使用被動FTP";
$GLOBALS['strTypeFTPErrorDir'] = "FTP主機目錄不存在";
$GLOBALS['strTypeFTPErrorConnect'] = "無法連結FTP伺服器，登錄名或密碼不正確";
$GLOBALS['strTypeFTPErrorNoSupport'] = "您安裝的PHP不支持FTP";
$GLOBALS['strTypeFTPErrorUpload'] = "Could not upload file to the FTP Server, check set proper rights to Host Directory";
$GLOBALS['strTypeFTPErrorHost'] = "主機不正確";
$GLOBALS['strDeliveryFilenames'] = "全局發布文件名";
$GLOBALS['strDeliveryFilenamesAdClick'] = "廣告點擊";
$GLOBALS['strDeliveryFilenamesSignedAdClick'] = "Signed Ad Click";
$GLOBALS['strDeliveryFilenamesAdConversionVars'] = "廣告轉化參數";
$GLOBALS['strDeliveryFilenamesAdContent'] = "廣告內容";
$GLOBALS['strDeliveryFilenamesAdConversion'] = "廣告轉化";
$GLOBALS['strDeliveryFilenamesAdConversionJS'] = "廣告轉化（JavaScript)";
$GLOBALS['strDeliveryFilenamesAdFrame'] = "廣告框架";
$GLOBALS['strDeliveryFilenamesAdImage'] = "廣告圖片";
$GLOBALS['strDeliveryFilenamesAdJS'] = "廣告 (JavaScript)";
$GLOBALS['strDeliveryFilenamesAdLayer'] = "廣告層";
$GLOBALS['strDeliveryFilenamesAdLog'] = "廣告記錄";
$GLOBALS['strDeliveryFilenamesAdPopup'] = "彈出廣告";
$GLOBALS['strDeliveryFilenamesAdView'] = "廣告預覽";
$GLOBALS['strDeliveryFilenamesXMLRPC'] = "生成遠程調用XML";
$GLOBALS['strDeliveryFilenamesLocal'] = "生成本地的";
$GLOBALS['strDeliveryFilenamesFrontController'] = "字體控制器";
$GLOBALS['strDeliveryFilenamesSinglePageCall'] = "Single Page Call";
$GLOBALS['strDeliveryFilenamesSinglePageCallJS'] = "Single Page Call (JavaScript)";
$GLOBALS['strDeliveryFilenamesAsyncJS'] = "Async JavaScript (source file)";
$GLOBALS['strDeliveryFilenamesAsyncPHP'] = "Async JavaScript";
$GLOBALS['strDeliveryFilenamesAsyncSPC'] = "Async JavaScript Single Page Call";
$GLOBALS['strDeliveryCaching'] = "全局發送緩存設置";
$GLOBALS['strDeliveryCacheLimit'] = "緩存刷新頻率（秒)";
$GLOBALS['strDeliveryCacheStore'] = "Banner Delivery Cache Store Type";
$GLOBALS['strDeliveryAcls'] = "Evaluate banner delivery rules during delivery";
$GLOBALS['strDeliveryAclsDirectSelection'] = "Evaluate banner delivery rules for direct selected ads";
$GLOBALS['strDeliveryObfuscate'] = "Obfuscate delivery rule set when delivering ads";
$GLOBALS['strDeliveryCtDelimiter'] = "第三方廣告跟蹤分隔符";
$GLOBALS['strGlobalDefaultBannerUrl'] = "Global default Banner Image URL";
$GLOBALS['strGlobalDefaultBannerInvalidZone'] = "Global default HTML Banner for non-existing zones";
$GLOBALS['strGlobalDefaultBannerSuspendedAccount'] = "Global default HTML Banner for suspended accounts";
$GLOBALS['strGlobalDefaultBannerInactiveAccount'] = "Global default HTML Banner for inactive accounts";
$GLOBALS['strP3PSettings'] = "P3P隱私策略的全局設置";
$GLOBALS['strUseP3P'] = "使用P3P策略";
$GLOBALS['strP3PCompactPolicy'] = "P3P壓縮策略";
$GLOBALS['strP3PPolicyLocation'] = "P3P策略地點";
$GLOBALS['strPrivacySettings'] = "Privacy Settings";
$GLOBALS['strDisableViewerId'] = "Disable unique Viewer Id cookie";
$GLOBALS['strAnonymiseIp'] = "Anonymise viewer IP addresses";

// General Settings
$GLOBALS['generalSettings'] = "Global General System Settings";
$GLOBALS['uiEnabled'] = "啟用用戶界面";
$GLOBALS['defaultLanguage'] = "Default System Language<br />(Each user can select their own language)";

// Geotargeting Settings
$GLOBALS['strGeotargetingSettings'] = "地理定位設置";
$GLOBALS['strGeotargeting'] = "地理定位設置";
$GLOBALS['strGeotargetingType'] = "地理定位模塊類型";
$GLOBALS['strGeoShowUnavailable'] = "Show geotargeting delivery rules even if GeoIP data unavailable";

// Interface Settings
$GLOBALS['strInventory'] = "系統管理";
$GLOBALS['strShowCampaignInfo'] = "Show extra campaign info on <i>Campaigns</i> page";
$GLOBALS['strShowBannerInfo'] = "Show extra banner info on <i>Banners</i> page";
$GLOBALS['strShowCampaignPreview'] = "在<i>廣告</i>頁中預覽所有廣告";
$GLOBALS['strShowBannerHTML'] = "實際顯示廣告，以代替plain html代碼的廣告預覽";
$GLOBALS['strShowBannerPreview'] = "在頁首顯示廣告預覽";
$GLOBALS['strUseWyswygHtmlEditorByDefault'] = "Use the WYSIWYG HTML Editor by default when creating or editing HTML banners";
$GLOBALS['strHideInactive'] = "Hide inactive items from all overview pages";
$GLOBALS['strGUIShowMatchingBanners'] = "顯示符合<i>Linked banner</i>的廣告";
$GLOBALS['strGUIShowParentCampaigns'] = "顯示<i>Linked banner</i>的父項目";
$GLOBALS['strShowEntityId'] = "Show entity identifiers";
$GLOBALS['strStatisticsDefaults'] = "統計";
$GLOBALS['strBeginOfWeek'] = "一周的開始";
$GLOBALS['strPercentageDecimals'] = "十進製百分比";
$GLOBALS['strWeightDefaults'] = "默認權重";
$GLOBALS['strDefaultBannerWeight'] = "默認廣告權重";
$GLOBALS['strDefaultCampaignWeight'] = "默認項目權重";
$GLOBALS['strConfirmationUI'] = "在用戶介面(UI)確認";

// Invocation Settings
$GLOBALS['strInvocationDefaults'] = "默認調用方式";
$GLOBALS['strEnable3rdPartyTrackingByDefault'] = "默認啟用第三方點擊跟蹤";

// Banner Delivery Settings
$GLOBALS['strBannerDelivery'] = "全局發送緩存設置";

// Banner Logging Settings
$GLOBALS['strBannerLogging'] = "全球防止統計登錄設置";
$GLOBALS['strLogAdRequests'] = "廣告的每次請求都需要記錄";
$GLOBALS['strLogAdImpressions'] = "廣告的每次瀏覽都需要記錄";
$GLOBALS['strLogAdClicks'] = "廣告的每次點擊都需要記錄";
$GLOBALS['strReverseLookup'] = "反向查找瀏覽者的主機名";
$GLOBALS['strProxyLookup'] = "嘗試查找通過代理伺服器訪問的訪問者的真是IP地址";
$GLOBALS['strPreventLogging'] = "全球防止統計登錄設置";
$GLOBALS['strIgnoreHosts'] = "來自以下IP地址或主機的訪客數據不統計";
$GLOBALS['strIgnoreUserAgents'] = "<b>Don't</b> log statistics from clients with any of the following strings in their user-agent (one-per-line)";
$GLOBALS['strEnforceUserAgents'] = "<b>Only</b> log statistics from clients with any of the following strings in their user-agent (one-per-line)";

// Banner Storage Settings
$GLOBALS['strBannerStorage'] = "廣告存儲設置";

// Campaign ECPM settings
$GLOBALS['strEnableECPM'] = "Use eCPM optimized priorities instead of remnant-weighted priorities";
$GLOBALS['strEnableContractECPM'] = "Use eCPM optimized priorities instead of standard contract priorities";
$GLOBALS['strEnableECPMfromRemnant'] = "(If you enable this feature all your remnant campaigns will be deactivated, you will have to update them manually to reactivate them)";
$GLOBALS['strEnableECPMfromECPM'] = "(If you disable this feature some of your active eCPM campaigns will be deactivated, you will have to update them manually to reactivate them)";
$GLOBALS['strInactivatedCampaigns'] = "List of campaigns which became inactive due to the changes in preferences:";

// Statistics & Maintenance Settings
$GLOBALS['strMaintenanceSettings'] = "維護設置";
$GLOBALS['strConversionTracking'] = "Conversion Tracking Settings";
$GLOBALS['strEnableConversionTracking'] = "Enable Conversion Tracking";
$GLOBALS['strBlockInactiveBanners'] = "Don't count ad impressions, clicks or re-direct the user to the target URL if the viewer clicks on a banner that is inactive";
$GLOBALS['strBlockAdClicks'] = "如果瀏覽者在在指定時間（秒）內點擊同一個廣告，不計算廣告點擊數";
$GLOBALS['strMaintenanceOI'] = "管理運行間隔（分鐘)";
$GLOBALS['strPrioritySettings'] = "全局優先權設定";
$GLOBALS['strPriorityInstantUpdate'] = "修改後廣告優先級立即生效";
$GLOBALS['strPriorityIntentionalOverdelivery'] = "Intentionally over-deliver Contract Campaigns<br />(% over-delivery)";
$GLOBALS['strDefaultImpConvWindow'] = "Default Ad Impression Conversion Window (seconds)";
$GLOBALS['strDefaultCliConvWindow'] = "Default Ad Click Conversion Window (seconds)";
$GLOBALS['strAdminEmailHeaders'] = "Add the following headers to each email message sent by {$PRODUCT_NAME}";
$GLOBALS['strWarnLimit'] = "郵件提醒剩餘曝光投放數以少於指定的數量";
$GLOBALS['strWarnLimitDays'] = "在指定日期之前發送一封提醒郵件";
$GLOBALS['strWarnAdmin'] = "郵件提醒管理員項目即將過期";
$GLOBALS['strWarnClient'] = "郵件提醒客戶項目即將過期";
$GLOBALS['strWarnAgency'] = "郵件提醒代理商項目即將過期";

// UI Settings
$GLOBALS['strGuiSettings'] = "用戶界面設定";
$GLOBALS['strGeneralSettings'] = "一般設置";
$GLOBALS['strAppName'] = "應用名稱";
$GLOBALS['strMyHeader'] = "頁眉文件位置";
$GLOBALS['strMyFooter'] = "頁腳文件位置";
$GLOBALS['strDefaultTrackerStatus'] = "默認跟蹤狀態";
$GLOBALS['strDefaultTrackerType'] = "默認跟蹤模式";
$GLOBALS['strSSLSettings'] = "SSL設置";
$GLOBALS['requireSSL'] = "強制使用SSL訪問用戶介面(UI)";
$GLOBALS['sslPort'] = "Web伺服器使用的SSL端口";
$GLOBALS['strDashboardSettings'] = "Dashboard Settings";
$GLOBALS['strMyLogo'] = "自定義logo文件名";
$GLOBALS['strGuiHeaderForegroundColor'] = "頁眉前景顏色";
$GLOBALS['strGuiHeaderBackgroundColor'] = "頁眉背景顏色";
$GLOBALS['strGuiActiveTabColor'] = "激活標籤的顏色";
$GLOBALS['strGuiHeaderTextColor'] = "頁眉文本的顏色";
$GLOBALS['strGuiSupportLink'] = "Custom URL for 'Support' link in header";
$GLOBALS['strGzipContentCompression'] = "使用GZIP進行壓縮";

// Regenerate Platfor Hash script
$GLOBALS['strPlatformHashRegenerate'] = "Platform Hash Regenerate";
$GLOBALS['strNewPlatformHash'] = "Your new Platform Hash is:";
$GLOBALS['strPlatformHashInsertingError'] = "Error inserting Platform Hash into database";

// Plugin Settings
$GLOBALS['strPluginSettings'] = "Plugin Settings";
$GLOBALS['strEnableNewPlugins'] = "Enable newly installed plugins";
$GLOBALS['strUseMergedFunctions'] = "Use merged delivery functions file";
