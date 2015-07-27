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
$GLOBALS['strTablesType'] = "表格類型";

$GLOBALS['strRecoveryRequiredTitle'] = "你以前嘗試升級遇到一個錯誤";
$GLOBALS['strRecoveryRequired'] = "你之前升級{$PRODUCT_NAME}中出現了一個錯誤，請點擊恢復按鈕恢復到錯誤產生之前的狀態。 ";

$GLOBALS['strOaUpToDate'] = "您的{$PRODUCT_NAME}和數據庫都使用的都是最新的版本，沒有需要更新的。請點擊繼續進入管理員面板。 ";
$GLOBALS['strOaUpToDateCantRemove'] = "警告: 升級文件仍在var目錄。因為權限不夠，我們無法移除此檔案。請先手動刪除該文件吧。 ";
$GLOBALS['strErrorWritePermissions'] = "文件權限錯誤。
 </br>在Linux下修正這個錯誤，請輸入以下命令: ";
$GLOBALS['strErrorFixPermissionsRCommand'] = "<i>chmod a+w %s</i>";

$GLOBALS['strErrorWritePermissionsWin'] = "文件權限錯誤。您必須先修正這個錯誤才可繼續下一步。 ";
$GLOBALS['strCheckDocumentation'] = "需要幫助，請參閱 <a href='http://{$PRODUCT_DOCSURL}'>{$PRODUCT_NAME} 文檔.</a> ";

$GLOBALS['strAdminUrlPrefix'] = "管理員介面路徑";
$GLOBALS['strDeliveryUrlPrefix'] = "發布引擎路徑";
$GLOBALS['strDeliveryUrlPrefixSSL'] = "發布引擎路徑 (SSL)";
$GLOBALS['strImagesUrlPrefix'] = "由於安全原因無法編輯所有設定。如果你希望修改，你需要解鎖配置文件。 ";
$GLOBALS['strImagesUrlPrefixSSL'] = "由於安全原因無法編輯所有設定。如果你希望修改，你需要解鎖配置文件。 (SSL)";



/* ------------------------------------------------------- */
/* Configuration translations                            */
/* ------------------------------------------------------- */

// Global
$GLOBALS['strChooseSection'] = "選擇章節";
$GLOBALS['strUnableToWriteConfig'] = "無法修改配置文件";
$GLOBALS['strUnableToWritePrefs'] = "無法向數據庫提交屬性更改 ";
$GLOBALS['strImageDirLockedDetected'] = "<b>圖片文件夾</b>不可寫<br>在修改文件夾權限之前無法修改或創建相關文件夾。";

// Configuration Settings
$GLOBALS['strConfigurationSettings'] = "配置設置";

// Administrator Settings
$GLOBALS['strAdminUsername'] = "管理員用戶名";
$GLOBALS['strAdminPassword'] = "管理員密碼";
$GLOBALS['strInvalidUsername'] = "用戶名不正確";
$GLOBALS['strBasicInformation'] = "基本信息";
$GLOBALS['strAdministratorEmail'] = "管理員郵件地址";
$GLOBALS['strNovice'] = "管理員的刪除操作需確認";
$GLOBALS['strUserlogEmail'] = "記錄所有發出郵件資訊";
$GLOBALS['strTimezone'] = "時區";
$GLOBALS['strEnableAutoMaintenance'] = "運行期間的自動維護還未設定";

// Database Settings
$GLOBALS['strDatabaseSettings'] = "數據庫設置";
$GLOBALS['strDatabaseServer'] = "全局數據庫伺服器設置";
$GLOBALS['strDbType'] = "數據庫類型";
$GLOBALS['strDbHost'] = "數據庫主機名";
$GLOBALS['strDbPort'] = "數據庫端口號";
$GLOBALS['strDbUser'] = "數據庫用戶名";
$GLOBALS['strDbPassword'] = "數據庫密碼";
$GLOBALS['strDbName'] = "數據庫名";
$GLOBALS['strDatabaseOptimalisations'] = "全局數據庫優化設置";
$GLOBALS['strPersistentConnections'] = "使用持久連結";
$GLOBALS['strCantConnectToDb'] = "無法連結數據庫";

// Email Settings
$GLOBALS['strEmailSettings'] = "電子郵件設置";
$GLOBALS['strQmailPatch'] = "qmail的補丁";
$GLOBALS['strEnableQmailPatch'] = "啟用qmail補丁";
$GLOBALS['strEmailHeader'] = "電子郵件標題";
$GLOBALS['strEmailLog'] = "電子郵件日誌";

// Audit Trail Settings
$GLOBALS['strAuditTrailSettings'] = "審計追蹤設置";
$GLOBALS['strEnableAudit'] = "啟用審計追蹤";

// Debug Logging Settings
$GLOBALS['strDebug'] = "調試日誌設置";
$GLOBALS['strEnableDebug'] = "啟用調試日誌";
$GLOBALS['strDebugMethodNames'] = "在調試日誌中包括方法名";
$GLOBALS['strDebugLineNumbers'] = "在調試日誌中包括方線程號碼";
$GLOBALS['strDebugType'] = "調試日誌類型";
$GLOBALS['strDebugTypeFile'] = "文件";
$GLOBALS['strDebugTypeSql'] = "SQL數據庫";
$GLOBALS['strDebugTypeSyslog'] = "系統日誌";
$GLOBALS['strDebugName'] = "除錯日誌名，日曆，SQL表格或系統日誌工具";
$GLOBALS['strDebugPriority'] = "除錯優先級";
$GLOBALS['strPEAR_LOG_DEBUG'] = "PEAR_LOG_DEBUG - 所有信息";
$GLOBALS['strPEAR_LOG_INFO'] = "PEAR_LOG_INFO - 默認信息";
$GLOBALS['strPEAR_LOG_EMERG'] = "PEAR_LOG_EMERG - 最少信息";
$GLOBALS['strDebugIdent'] = "調試鑑定弦";

// Delivery Settings
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
$GLOBALS['strTypeWebDir'] = "本地目錄";
$GLOBALS['strTypeFTPHost'] = "FTP主機";
$GLOBALS['strTypeFTPDirectory'] = "主機目錄";
$GLOBALS['strTypeFTPUsername'] = "登錄";
$GLOBALS['strTypeFTPPassword'] = "密碼";
$GLOBALS['strTypeFTPPassive'] = "使用被動FTP";
$GLOBALS['strTypeFTPErrorDir'] = "FTP主機目錄不存在";
$GLOBALS['strTypeFTPErrorConnect'] = "無法連結FTP伺服器，登錄名或密碼不正確";
$GLOBALS['strTypeFTPErrorNoSupport'] = "您安裝的PHP不支持FTP";
$GLOBALS['strTypeFTPErrorHost'] = "主機不正確";
$GLOBALS['strDeliveryFilenames'] = "全局發布文件名";
$GLOBALS['strDeliveryFilenamesAdClick'] = "廣告點擊";
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
$GLOBALS['strDeliveryFilenamesFlash'] = "包括Flash（可以使用絕對路徑)";
$GLOBALS['strDeliveryCaching'] = "全局發送緩存設置";
$GLOBALS['strDeliveryCacheLimit'] = "緩存刷新頻率（秒)";
$GLOBALS['strDeliveryAcls'] = "在分發時評估廣告的分發";
$GLOBALS['strDeliveryObfuscate'] = "混淆通道時廣告";
$GLOBALS['strDeliveryExecPhp'] = "可在廣告中使用PHP代碼（可能存在安全隱患)";
$GLOBALS['strDeliveryCtDelimiter'] = "第三方廣告跟蹤分隔符";
$GLOBALS['strP3PSettings'] = "P3P隱私策略的全局設置";
$GLOBALS['strUseP3P'] = "使用P3P策略";
$GLOBALS['strP3PCompactPolicy'] = "P3P壓縮策略";
$GLOBALS['strP3PPolicyLocation'] = "P3P策略地點";

// General Settings
$GLOBALS['uiEnabled'] = "啟用用戶界面";

// Geotargeting Settings
$GLOBALS['strGeotargetingSettings'] = "地理定位設置";
$GLOBALS['strGeotargeting'] = "地理定位設置";
$GLOBALS['strGeotargetingType'] = "地理定位模塊類型";
$GLOBALS['strGeoShowUnavailable'] = "如果沒有GeoIP數據，則提示地理定位發布條件";

// Interface Settings
$GLOBALS['strInventory'] = "系統管理";
$GLOBALS['strShowCampaignPreview'] = "在<i>廣告</i>頁中預覽所有廣告";
$GLOBALS['strShowBannerHTML'] = "實際顯示廣告，以代替plain html代碼的廣告預覽";
$GLOBALS['strShowBannerPreview'] = "在頁首顯示廣告預覽";
$GLOBALS['strGUIShowMatchingBanners'] = "顯示符合<i>Linked banner</i>的廣告";
$GLOBALS['strGUIShowParentCampaigns'] = "顯示<i>Linked banner</i>的父項目";
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

// Banner Storage Settings
$GLOBALS['strBannerStorage'] = "廣告存儲設置";

// Campaign ECPM settings

// Statistics & Maintenance Settings
$GLOBALS['strMaintenanceSettings'] = "維護設置";
$GLOBALS['strBlockAdClicks'] = "如果瀏覽者在在指定時間（秒）內點擊同一個廣告，不計算廣告點擊數";
$GLOBALS['strMaintenanceOI'] = "管理運行間隔（分鐘)";
$GLOBALS['strPrioritySettings'] = "全局優先權設定";
$GLOBALS['strPriorityInstantUpdate'] = "修改後廣告優先級立即生效";
$GLOBALS['strDefaultImpConWindow'] = "默認廣告曝光連結窗口（秒)";
$GLOBALS['strDefaultCliConWindow'] = "默認廣告點擊連結窗口（秒)";
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
$GLOBALS['strMyLogo'] = "自定義logo文件名";
$GLOBALS['strGuiHeaderForegroundColor'] = "頁眉前景顏色";
$GLOBALS['strGuiHeaderBackgroundColor'] = "頁眉背景顏色";
$GLOBALS['strGuiActiveTabColor'] = "激活標籤的顏色";
$GLOBALS['strGuiHeaderTextColor'] = "頁眉文本的顏色";
$GLOBALS['strGzipContentCompression'] = "使用GZIP進行壓縮";

// Regenerate Platfor Hash script

// Plugin Settings
