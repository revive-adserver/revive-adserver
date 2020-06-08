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
$GLOBALS['strDeliveryEngine'] = "Motor de Livrare";
$GLOBALS['strMaintenance'] = "Întreţinere";
$GLOBALS['strAdministrator'] = "Administrator";

// Audit
$GLOBALS['strDeleted'] = "şters";
$GLOBALS['strInserted'] = "adăugat";
$GLOBALS['strUpdated'] = "actualizat";
$GLOBALS['strDelete'] = "Şterge";
$GLOBALS['strHas'] = "are";
$GLOBALS['strFilters'] = "Filtre";
$GLOBALS['strAdvertiser'] = "Advertiser";
$GLOBALS['strPublisher'] = "Website";
$GLOBALS['strCampaign'] = "Campanie";
$GLOBALS['strZone'] = "Zonă";
$GLOBALS['strType'] = "Tip";
$GLOBALS['strAction'] = "Acţiune";
$GLOBALS['strParameter'] = "Parametru";
$GLOBALS['strValue'] = "Valoare";
$GLOBALS['strReturnAuditTrail'] = "Întoarcere la Urmărirea Bilanţului";
$GLOBALS['strAuditTrail'] = "Urmărirea Bilanţului";
$GLOBALS['strMaintenanceLog'] = "Jurnal întreţinere";
$GLOBALS['strAuditResultsNotFound'] = "Nu a fost găsit nici un eveniment care să corespundă criteriilor selectate.";
$GLOBALS['strCollectedAllEvents'] = "Toate evenimentele";
$GLOBALS['strClear'] = "Curăţă";

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
$GLOBALS['strUserlog'][phpAds_actionActivationMailed] = "Notificarea de activare pentru campania {id} a fost trimisă prin email";
