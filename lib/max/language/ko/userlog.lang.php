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
$GLOBALS['strDelete'] = "삭제";
$GLOBALS['strAdvertiser'] = "광고주";
$GLOBALS['strPublisher'] = "광고게시자";
$GLOBALS['strCampaign'] = "캠페�?�";
$GLOBALS['strZone'] = "�?역";
$GLOBALS['strAction'] = "행동";
$GLOBALS['strValue'] = "값";

if (!isset($GLOBALS['strUserlog'])) {
    $GLOBALS['strUserlog'] = array();
}
$GLOBALS['strUserlog'][phpAds_actionAdvertiserReportMailed] = "데이터베이스 자동 정리";
$GLOBALS['strUserlog'][phpAds_actionActiveCampaign] = "데이터베이스 자동 정리";
$GLOBALS['strUserlog'][phpAds_actionAutoClean] = "데이터베이스 자동 정리";
$GLOBALS['strUserlog'][phpAds_actionBatchStatistics] = "데이터베이스 자동 정리";
$GLOBALS['strUserlog'][phpAds_actionDeactivationMailed] = "데이터베이스 자동 정리";
$GLOBALS['strUserlog'][phpAds_actionDeactiveCampaign] = "데이터베이스 자동 정리";
$GLOBALS['strUserlog'][phpAds_actionPriorityCalculation] = "데이터베이스 자동 정리";
$GLOBALS['strUserlog'][phpAds_actionPublisherReportMailed] = "데이터베이스 자동 정리";
$GLOBALS['strUserlog'][phpAds_actionWarningMailed] = "데이터베이스 자동 정리";
$GLOBALS['strUserlog'][phpAds_actionActivationMailed] = "데이터베이스 자동 정리";
