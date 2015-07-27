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
$GLOBALS['strDeliveryEngine'] = "發布引擎";
$GLOBALS['strMaintenance'] = "維護";
$GLOBALS['strAdministrator'] = "管理員";

// Audit
$GLOBALS['strDeleted'] = "已刪除 ";
$GLOBALS['strInserted'] = "已插入";
$GLOBALS['strUpdated'] = "已更新";
$GLOBALS['strDelete'] = "刪除";
$GLOBALS['strHas'] = "具備";
$GLOBALS['strFilters'] = "過濾器";
$GLOBALS['strAdvertiser'] = "廣告商";
$GLOBALS['strPublisher'] = "網站";
$GLOBALS['strCampaign'] = "項目";
$GLOBALS['strZone'] = "版位";
$GLOBALS['strType'] = "類型";
$GLOBALS['strAction'] = "操作";
$GLOBALS['strParameter'] = "參數";
$GLOBALS['strValue'] = "值";
$GLOBALS['strReturnAuditTrail'] = "返回到審計跟蹤";
$GLOBALS['strAuditTrail'] = "審計跟踪";
$GLOBALS['strMaintenanceLog'] = "維護日誌";
$GLOBALS['strAuditResultsNotFound'] = "沒有滿足約束條件的事件";
$GLOBALS['strCollectedAllEvents'] = "所有事件";
$GLOBALS['strClear'] = "清除";

if (!isset($GLOBALS['strUserlog'])) {
    $GLOBALS['strUserlog'] = array();
}
$GLOBALS['strUserlog'][phpAds_actionAdvertiserReportMailed] = "已發送發布商{id}報告郵件";
$GLOBALS['strUserlog'][phpAds_actionActiveCampaign] = "已發送發布商{id}報告郵件";
$GLOBALS['strUserlog'][phpAds_actionAutoClean] = "已發送發布商{id}報告郵件";
$GLOBALS['strUserlog'][phpAds_actionBatchStatistics] = "已發送發布商{id}報告郵件";
$GLOBALS['strUserlog'][phpAds_actionDeactivationMailed] = "已發送發布商{id}報告郵件";
$GLOBALS['strUserlog'][phpAds_actionDeactiveCampaign] = "已發送發布商{id}報告郵件";
$GLOBALS['strUserlog'][phpAds_actionPriorityCalculation] = "已發送發布商{id}報告郵件";
$GLOBALS['strUserlog'][phpAds_actionPublisherReportMailed] = "已發送發布商{id}報告郵件";
$GLOBALS['strUserlog'][phpAds_actionWarningMailed] = "已發送發布商{id}報告郵件";
$GLOBALS['strUserlog'][phpAds_actionActivationMailed] = "已發送發布商{id}報告郵件";
