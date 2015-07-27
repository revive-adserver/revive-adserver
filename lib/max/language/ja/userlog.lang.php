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
$GLOBALS['strHas'] = "=";
$GLOBALS['strFilters'] = "フィルター条件";
$GLOBALS['strAdvertiser'] = "広告主";
$GLOBALS['strPublisher'] = "Webサイト";
$GLOBALS['strCampaign'] = "キャンペーン";
$GLOBALS['strZone'] = "ゾーン";
$GLOBALS['strType'] = "タイプ";
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
    $GLOBALS['strUserlog'] = array();
}
$GLOBALS['strUserlog'][phpAds_actionAdvertiserReportMailed] = "キャンペーン: {id} の非アクティブ警告を電子メールにて送信する";
$GLOBALS['strUserlog'][phpAds_actionActiveCampaign] = "キャンペーン: {id} の非アクティブ警告を電子メールにて送信する";
$GLOBALS['strUserlog'][phpAds_actionAutoClean] = "キャンペーン: {id} の非アクティブ警告を電子メールにて送信する";
$GLOBALS['strUserlog'][phpAds_actionBatchStatistics] = "キャンペーン: {id} の非アクティブ警告を電子メールにて送信する";
$GLOBALS['strUserlog'][phpAds_actionDeactivationMailed] = "キャンペーン: {id} の非アクティブ警告を電子メールにて送信する";
$GLOBALS['strUserlog'][phpAds_actionDeactiveCampaign] = "キャンペーン: {id} の非アクティブ警告を電子メールにて送信する";
$GLOBALS['strUserlog'][phpAds_actionPriorityCalculation] = "キャンペーン: {id} の非アクティブ警告を電子メールにて送信する";
$GLOBALS['strUserlog'][phpAds_actionPublisherReportMailed] = "キャンペーン: {id} の非アクティブ警告を電子メールにて送信する";
$GLOBALS['strUserlog'][phpAds_actionWarningMailed] = "キャンペーン: {id} の非アクティブ警告を電子メールにて送信する";
$GLOBALS['strUserlog'][phpAds_actionActivationMailed] = "キャンペーン: {id} の非アクティブ警告を電子メールにて送信する";
