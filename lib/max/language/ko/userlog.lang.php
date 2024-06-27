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
$GLOBALS['strInserted'] = "";
$GLOBALS['strUpdated'] = "";
$GLOBALS['strDelete'] = "삭제";
$GLOBALS['strHas'] = "";
$GLOBALS['strFilters'] = "";
$GLOBALS['strAdvertiser'] = "광고주";
$GLOBALS['strPublisher'] = "웹사이트";
$GLOBALS['strCampaign'] = "캠페인";
$GLOBALS['strZone'] = "광고영역";
$GLOBALS['strType'] = "";
$GLOBALS['strAction'] = "작업";
$GLOBALS['strParameter'] = "";
$GLOBALS['strValue'] = "값";
$GLOBALS['strReturnAuditTrail'] = "";
$GLOBALS['strAuditTrail'] = "";
$GLOBALS['strMaintenanceLog'] = "";
$GLOBALS['strAuditResultsNotFound'] = "";
$GLOBALS['strCollectedAllEvents'] = "";
$GLOBALS['strClear'] = "";

if (!isset($GLOBALS['strUserlog'])) {
    $GLOBALS['strUserlog'] = [];
}
$GLOBALS['strUserlog'][phpAds_actionAdvertiserReportMailed] = "";
$GLOBALS['strUserlog'][phpAds_actionActiveCampaign] = "";
$GLOBALS['strUserlog'][phpAds_actionAutoClean] = "";
$GLOBALS['strUserlog'][phpAds_actionBatchStatistics] = "";
$GLOBALS['strUserlog'][phpAds_actionDeactivationMailed] = "";
$GLOBALS['strUserlog'][phpAds_actionDeactiveCampaign] = "";
$GLOBALS['strUserlog'][phpAds_actionPriorityCalculation] = "";
$GLOBALS['strUserlog'][phpAds_actionPublisherReportMailed] = "";
$GLOBALS['strUserlog'][phpAds_actionWarningMailed] = "";
$GLOBALS['strUserlog'][phpAds_actionActivationMailed] = "데이터베이스 자동 정리";
