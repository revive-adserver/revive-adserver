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
$GLOBALS['strDeliveryEngine'] = "מנוע הפצה";
$GLOBALS['strMaintenance'] = "תחזוקה";
$GLOBALS['strAdministrator'] = "אחראי";

// Audit
$GLOBALS['strDeleted'] = "";
$GLOBALS['strInserted'] = "";
$GLOBALS['strUpdated'] = "";
$GLOBALS['strDelete'] = "מחק";
$GLOBALS['strHas'] = "";
$GLOBALS['strFilters'] = "";
$GLOBALS['strAdvertiser'] = "מפרסם";
$GLOBALS['strPublisher'] = "אתר אינטרנט";
$GLOBALS['strCampaign'] = "קמפיין";
$GLOBALS['strZone'] = "איזור";
$GLOBALS['strType'] = "סוג";
$GLOBALS['strAction'] = "פעולה";
$GLOBALS['strParameter'] = "";
$GLOBALS['strValue'] = "ערך";
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
$GLOBALS['strUserlog'][phpAds_actionActivationMailed] = "";
