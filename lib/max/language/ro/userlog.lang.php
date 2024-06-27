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
$GLOBALS['strAdministrator'] = "";

// Audit
$GLOBALS['strDeleted'] = "şters";
$GLOBALS['strInserted'] = "adăugat";
$GLOBALS['strUpdated'] = "actualizat";
$GLOBALS['strDelete'] = "Şterge";
$GLOBALS['strHas'] = "are";
$GLOBALS['strFilters'] = "Filtre";
$GLOBALS['strAdvertiser'] = "";
$GLOBALS['strPublisher'] = "";
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
$GLOBALS['strUserlog'][phpAds_actionActivationMailed] = "Notificarea de activare pentru campania {id} a fost trimisă prin email";
