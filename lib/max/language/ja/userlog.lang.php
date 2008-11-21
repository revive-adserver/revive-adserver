<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
| For contact details, see: http://www.openx.org/                           |
|                                                                           |
| This program is free software; you can redistribute it and/or modify      |
| it under the terms of the GNU General Public License as published by      |
| the Free Software Foundation; either version 2 of the License, or         |
| (at your option) any later version.                                       |
|                                                                           |
| This program is distributed in the hope that it will be useful,           |
| but WITHOUT ANY WARRANTY; without even the implied warranty of            |
| MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
| GNU General Public License for more details.                              |
|                                                                           |
| You should have received a copy of the GNU General Public License         |
| along with this program; if not, write to the Free Software               |
| Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA |
+---------------------------------------------------------------------------+
$Id$
*/

// Set translation strings

$GLOBALS['strDeliveryEngine']				= "配信エンジン";
$GLOBALS['strMaintenance']					= "メンテナンス";
$GLOBALS['strAdministrator']				= "管理者";

// Audit
$GLOBALS['strLogging']                      = "ロギング";
$GLOBALS['strAudit']                        = "追跡記録ログ";
$GLOBALS['strDebugLog']                     = "デバッグログ";
$GLOBALS['strEvent']                        = "イベント";
$GLOBALS['strTimestamp']                    = "タイムスタンプ";
$GLOBALS['strDeleted']                      = "削除済";
$GLOBALS['strInserted']                     = "挿入済";
$GLOBALS['strUpdated']                      = "更新済";
$GLOBALS['strDelete']                       = "削除";
$GLOBALS['strInsert']                       = "挿入";
$GLOBALS['strUpdate']                       = "更新";
$GLOBALS['strHas']                          = "=";
$GLOBALS['strFilters']                      = "フィルター条件";
$GLOBALS['strAdvertiser']                   = "広告主";
$GLOBALS['strPublisher']                    = "Webサイト";
$GLOBALS['strCampaign']                     = "キャンペーン";
$GLOBALS['strZone']                         = "ゾーン";
$GLOBALS['strType']                         = "タイプ";
$GLOBALS['strAction']                       = "アクション";
$GLOBALS['strParameter']                    = "パラメータ";
$GLOBALS['strValue']                        = "数値";
$GLOBALS['strDetailedView']                 = "明細ビュー";
$GLOBALS['strReturnAuditTrail']             = "追跡記録に戻る";
$GLOBALS['strAuditTrail']                   = "追跡記録";
$GLOBALS['strMaintenanceLog']               = "メンテナンスログ";
$GLOBALS['strAuditResultsNotFound']         = "指定条件にマッチするイベントはありません";
$GLOBALS['strCollectedAllEvents']           = "全てのイベント";
$GLOBALS['strClear']                        = "クリア";

$GLOBALS['strUserlog'][phpAds_actionAdvertiserReportMailed] = "電子メールでアドバタイザ: {id} の報告を送信する";
$GLOBALS['strUserlog'][phpAds_actionActiveCampaign] = "キャンペーン: {id} をアクティブにしました";
$GLOBALS['strUserlog'][phpAds_actionAutoClean] = "データベース自動クリーニング";
$GLOBALS['strUserlog'][phpAds_actionBatchStatistics] = "統計情報をコンパイルしました";
$GLOBALS['strUserlog'][phpAds_actionDeactivationMailed] = "キャンペーン: {id} の非アクティブ通知を電子メールにて送信する";
$GLOBALS['strUserlog'][phpAds_actionDeactiveCampaign] = "キャンペーン: {id} を非アクティブにしました";
$GLOBALS['strUserlog'][phpAds_actionInventoryCalculation] = "インベントリの配信プランを構成しました";
$GLOBALS['strUserlog'][phpAds_actionPriorityCalculation] = "優先度を再計算しました";
$GLOBALS['strUserlog'][phpAds_actionPublisherReportMailed] = "電子メールでパブリッシャ: {id} のレポートを送信する";
$GLOBALS['strUserlog'][phpAds_actionWarningMailed] = "キャンペーン: {id} の非アクティブ警告を電子メールにて送信する";




// Note: New translations not found in original lang files but found in CSV
$GLOBALS['strUserlog'][phpAds_actionActivationMailed] = "キャンペーン: {id} の非アクティブ通知を電子メールにて送信する";
?>