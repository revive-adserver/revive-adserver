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
$GLOBALS['strDeliveryEngine'] = "Kiszolgáló motor";
$GLOBALS['strMaintenance'] = "Karbantartás";
$GLOBALS['strAdministrator'] = "Adminisztrátor";

// Audit
$GLOBALS['strDeleted'] = "Töröl";
$GLOBALS['strInserted'] = "inserted";
$GLOBALS['strUpdated'] = "frissítve";
$GLOBALS['strDelete'] = "Törlés";
$GLOBALS['strHas'] = "has";
$GLOBALS['strFilters'] = "Szűrők";
$GLOBALS['strAdvertiser'] = "Hirdető";
$GLOBALS['strPublisher'] = "Weboldal";
$GLOBALS['strCampaign'] = "Kampány";
$GLOBALS['strZone'] = "Zónák";
$GLOBALS['strType'] = "Típus";
$GLOBALS['strAction'] = "Művelet";
$GLOBALS['strParameter'] = "Paraméter";
$GLOBALS['strValue'] = "Érték";
$GLOBALS['strReturnAuditTrail'] = "Return to Audit Trail";
$GLOBALS['strAuditTrail'] = "Audit trail";
$GLOBALS['strMaintenanceLog'] = "Maintenance log";
$GLOBALS['strAuditResultsNotFound'] = "No events found matching the selected criteria";
$GLOBALS['strCollectedAllEvents'] = "Összes esemény";
$GLOBALS['strClear'] = "Töröl";

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
$GLOBALS['strUserlog'][phpAds_actionActivationMailed] = "Adatbázis automatikus tisztítása";
