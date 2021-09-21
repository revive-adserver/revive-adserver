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

// Set translation strings
$GLOBALS['strDeliveryEngine'] = "配信エンジン";
$GLOBALS['strMaintenance'] = "メンテナンス";
$GLOBALS['strAdministrator'] = "管理者";

// Audit
$GLOBALS['strDeleted'] = "削除済";
$GLOBALS['strInserted'] = "挿入済";
$GLOBALS['strUpdated'] = "更新済";
$GLOBALS['strDelete'] = "削除";
$GLOBALS['strHas'] = "\\=";
$GLOBALS['strFilters'] = "フィルター条件";
$GLOBALS['strAdvertiser'] = "広告主";
$GLOBALS['strPublisher'] = "Webサイト";
$GLOBALS['strCampaign'] = "キャンペーン";
$GLOBALS['strZone'] = "ゾーン";
$GLOBALS['strAction'] = "アクション";
$GLOBALS['strParameter'] = "パラメータ";
$GLOBALS['strValue'] = "数値";
$GLOBALS['strReturnAuditTrail'] = "追跡記録に戻る";
$GLOBALS['strAuditTrail'] = "追跡記録";
$GLOBALS['strMaintenanceLog'] = "メンテナンスログ";
$GLOBALS['strAuditResultsNotFound'] = "指定条件にマッチするイベントはありません";
$GLOBALS['strCollectedAllEvents'] = "全てのイベント";
$GLOBALS['strClear'] = "クリア";

if (!isset($GLOBALS['strUserlog'])) {
    $GLOBALS['strUserlog'] = [];
}
$GLOBALS['strUserlog'][phpAds_actionActivationMailed] = "キャンペーン: {id} の非アクティブ警告を電子メールにて送信する";
