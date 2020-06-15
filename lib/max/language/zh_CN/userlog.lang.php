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
$GLOBALS['strDeliveryEngine'] = "投放引擎";
$GLOBALS['strMaintenance'] = "维护";
$GLOBALS['strAdministrator'] = "管理员";

// Audit
$GLOBALS['strDeleted'] = "删除";
$GLOBALS['strInserted'] = "添加";
$GLOBALS['strUpdated'] = "更新";
$GLOBALS['strDelete'] = "删除";
$GLOBALS['strHas'] = "has";
$GLOBALS['strFilters'] = "过滤";
$GLOBALS['strAdvertiser'] = "客户";
$GLOBALS['strPublisher'] = "媒体";
$GLOBALS['strCampaign'] = "项目";
$GLOBALS['strZone'] = "版位";
$GLOBALS['strType'] = "类型";
$GLOBALS['strAction'] = "操作";
$GLOBALS['strParameter'] = "参数";
$GLOBALS['strValue'] = "值";
$GLOBALS['strReturnAuditTrail'] = "返回";
$GLOBALS['strAuditTrail'] = "Audit trail";
$GLOBALS['strMaintenanceLog'] = "Maintenance log";
$GLOBALS['strAuditResultsNotFound'] = "No events found matching the selected criteria";
$GLOBALS['strCollectedAllEvents'] = "所有";
$GLOBALS['strClear'] = "重置";

if (!isset($GLOBALS['strUserlog'])) {
    $GLOBALS['strUserlog'] = array();
}
$GLOBALS['strUserlog'][phpAds_actionAdvertiserReportMailed] = "Report for advertiser {id} send by email";
$GLOBALS['strUserlog'][phpAds_actionActiveCampaign] = "Campaign {id} activated";
$GLOBALS['strUserlog'][phpAds_actionAutoClean] = "Auto clean of database";
$GLOBALS['strUserlog'][phpAds_actionBatchStatistics] = "Statistics compiled";
$GLOBALS['strUserlog'][phpAds_actionDeactivationMailed] = "Deactivation notification for campaign {id} send by email";
$GLOBALS['strUserlog'][phpAds_actionDeactiveCampaign] = "Campaign {id} deactivated";
$GLOBALS['strUserlog'][phpAds_actionPriorityCalculation] = "Priority recalculated";
$GLOBALS['strUserlog'][phpAds_actionPublisherReportMailed] = "Report for website {id} send by email";
$GLOBALS['strUserlog'][phpAds_actionWarningMailed] = "Deactivation warning for campaign {id} send by email";
$GLOBALS['strUserlog'][phpAds_actionActivationMailed] = "Activation notification for campaign {id} send by email";
