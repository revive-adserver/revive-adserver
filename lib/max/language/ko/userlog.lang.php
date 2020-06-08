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
$GLOBALS['strDeliveryEngine'] = "전달유지 엔진";
$GLOBALS['strMaintenance'] = "유지보수";
$GLOBALS['strAdministrator'] = "관리자";

// Audit
$GLOBALS['strDeleted'] = "삭제";
$GLOBALS['strInserted'] = "inserted";
$GLOBALS['strUpdated'] = "updated";
$GLOBALS['strDelete'] = "삭제";
$GLOBALS['strHas'] = "has";
$GLOBALS['strFilters'] = "Filters";
$GLOBALS['strAdvertiser'] = "광고주";
$GLOBALS['strPublisher'] = "광고게시자";
$GLOBALS['strCampaign'] = "캠페인";
$GLOBALS['strZone'] = "광고영역";
$GLOBALS['strType'] = "Type";
$GLOBALS['strAction'] = "작업";
$GLOBALS['strParameter'] = "Parameter";
$GLOBALS['strValue'] = "값";
$GLOBALS['strReturnAuditTrail'] = "Return to Audit Trail";
$GLOBALS['strAuditTrail'] = "Audit trail";
$GLOBALS['strMaintenanceLog'] = "Maintenance log";
$GLOBALS['strAuditResultsNotFound'] = "No events found matching the selected criteria";
$GLOBALS['strCollectedAllEvents'] = "All events";
$GLOBALS['strClear'] = "Clear";

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
$GLOBALS['strUserlog'][phpAds_actionActivationMailed] = "데이터베이스 자동 정리";
