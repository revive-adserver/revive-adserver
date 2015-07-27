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

// Audit
$GLOBALS['strDeleted'] = "şters";
$GLOBALS['strInserted'] = "adăugat";
$GLOBALS['strUpdated'] = "actualizat";
$GLOBALS['strDelete'] = "Şterge";
$GLOBALS['strHas'] = "are";
$GLOBALS['strFilters'] = "Filtre";
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
$GLOBALS['strUserlog'][phpAds_actionAdvertiserReportMailed] = "Notificarea de activare pentru campania {id} a fost trimisă prin email";
$GLOBALS['strUserlog'][phpAds_actionActiveCampaign] = "Notificarea de activare pentru campania {id} a fost trimisă prin email";
$GLOBALS['strUserlog'][phpAds_actionAutoClean] = "Notificarea de activare pentru campania {id} a fost trimisă prin email";
$GLOBALS['strUserlog'][phpAds_actionBatchStatistics] = "Notificarea de activare pentru campania {id} a fost trimisă prin email";
$GLOBALS['strUserlog'][phpAds_actionDeactivationMailed] = "Notificarea de activare pentru campania {id} a fost trimisă prin email";
$GLOBALS['strUserlog'][phpAds_actionDeactiveCampaign] = "Notificarea de activare pentru campania {id} a fost trimisă prin email";
$GLOBALS['strUserlog'][phpAds_actionPriorityCalculation] = "Notificarea de activare pentru campania {id} a fost trimisă prin email";
$GLOBALS['strUserlog'][phpAds_actionPublisherReportMailed] = "Notificarea de activare pentru campania {id} a fost trimisă prin email";
$GLOBALS['strUserlog'][phpAds_actionWarningMailed] = "Notificarea de activare pentru campania {id} a fost trimisă prin email";
$GLOBALS['strUserlog'][phpAds_actionActivationMailed] = "Notificarea de activare pentru campania {id} a fost trimisă prin email";
