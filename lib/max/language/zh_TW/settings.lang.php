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

// Email Settings

// Audit Trail Settings

// Debug Logging Settings

// Delivery Settings
$GLOBALS['strTypeFTPUsername'] = "登錄";
$GLOBALS['strTypeFTPPassword'] = "密碼";

// General Settings

// Geotargeting Settings

// Interface Settings
$GLOBALS['strInventory'] = "系統管理";
$GLOBALS['strStatisticsDefaults'] = "統計";

// Invocation Settings

// Banner Delivery Settings

// Banner Logging Settings

// Banner Storage Settings

// Campaign ECPM settings

// Statistics & Maintenance Settings

// UI Settings

// Regenerate Platfor Hash script

// Plugin Settings
