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

// Main strings
$GLOBALS['strChooseSection'] = "選擇章節";

// Maintenance








// Priority
$GLOBALS['strRecalculatePriority'] = "重新計算優先級";

// Banner cache
$GLOBALS['strCheckBannerCache'] = "檢查廣告緩存";
$GLOBALS['strBannerCacheErrorsFound'] = "經查，數據庫廣告緩存發現錯誤。在手工修正這些錯誤之前，這些廣告將無法正常運行。";
$GLOBALS['strBannerCacheOK'] = "未發現錯誤，您的數據庫廣告緩存已是最新的";
$GLOBALS['strBannerCacheDifferencesFound'] = "經查，數據庫廣告緩存不是最新的，需要重建。點擊這裡自動更新緩存。";
$GLOBALS['strBannerCacheRebuildButton'] = "重構";
$GLOBALS['strRebuildDeliveryCache'] = "重構數據庫廣告緩存";
$GLOBALS['strBannerCacheExplaination'] = "廣告數據庫緩存的作用是加速廣告的投放
 該緩存需要在以下情況下更新：
          <ul>
                  <li>您升級了OpenX</li>
                   <li>您將OpenX遷移到一個新的伺服器上</li>
          </ul>";

// Cache
$GLOBALS['strCache'] = "發布緩存";
$GLOBALS['strDeliveryCacheSharedMem'] = "共享內存目前正被發布緩存佔用";
$GLOBALS['strDeliveryCacheDatabase'] = "數據正在存儲發布緩存";
$GLOBALS['strDeliveryCacheFiles'] = "發布緩存正在存儲到你伺服器上的多個文件 ";

// Storage
$GLOBALS['strStorage'] = "存儲";
$GLOBALS['strMoveToDirectory'] = "將圖片從數據庫中移動到目錄下 ";
$GLOBALS['strStorageExplaination'] = "圖片文件可存儲在數據庫或文件系統中。存儲在文件系統中將比存儲在數據庫中效率更高。";

// Security

// Encoding

// Product Updates
$GLOBALS['strSearchingUpdates'] = "查找更新，請稍候……";
$GLOBALS['strAvailableUpdates'] = "提供的更新";
$GLOBALS['strDownloadZip'] = "下載 (.zip)";
$GLOBALS['strDownloadGZip'] = "下載 (.tar.gz)";

$GLOBALS['strUpdateAlert'] = "{$PRODUCT_NAME} 新版本已發布。

 您希望了解更多關於新版本的資訊嗎？? ";
$GLOBALS['strUpdateAlertSecurity'] = "{$PRODUCT_NAME} 新版本已發布。

 由於提供了很多安全方面的修改? 所以強烈建議您更新到新版本。 ";


$GLOBALS['strNoNewVersionAvailable'] = "您{$PRODUCT_NAME}的版本已是最新的。 ";



$GLOBALS['strNewVersionAvailable'] = "<b>{$PRODUCT_NAME}的新版本已經發布。 </b><br />由於修改一些已知的問題及增加了一些新功能。所以建議您安裝這個更新。如果您希望進一步了解相關細心，請參閱文件中的相關文檔。
 ";

$GLOBALS['strSecurityUpdate'] = "<b>由於涉及若干個安全更新，所以強烈建議您升級。</b>
 您現在的{$PRODUCT_NAME}版本，可能因為攻擊而變得不可靠。如果希望了解進一步的資訊，請參閱文件中的相關文檔。 ";

$GLOBALS['strNotAbleToCheck'] = "<b>由於您伺服器上沒有XML引申，所以{$PRODUCT_NAME}無法查找是否有新的更新提供。</b>";

$GLOBALS['strForUpdatesLookOnWebsite'] = "如果您希望知道是否有新的版本提供，請查閱我們的網站。";

$GLOBALS['strClickToVisitWebsite'] = "點擊訪問官方網站";
$GLOBALS['strCurrentlyUsing'] = "你正在使用的";
$GLOBALS['strRunningOn'] = "運行的";
$GLOBALS['strAndPlain'] = "與";

//  Deliver Limitations

//  Append codes



// Users
