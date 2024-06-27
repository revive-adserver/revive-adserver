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
$GLOBALS['strDeliveryEngine'] = "Dostarczanie";
$GLOBALS['strMaintenance'] = "Konserwacja";
$GLOBALS['strAdministrator'] = "";

// Audit
$GLOBALS['strDeleted'] = "usunięto";
$GLOBALS['strInserted'] = "dodano";
$GLOBALS['strUpdated'] = "aktualizowano";
$GLOBALS['strDelete'] = "Usuń";
$GLOBALS['strHas'] = "";
$GLOBALS['strFilters'] = "Filtry";
$GLOBALS['strAdvertiser'] = "Reklamodawca";
$GLOBALS['strPublisher'] = "Strona";
$GLOBALS['strCampaign'] = "Kampania";
$GLOBALS['strZone'] = "Strefa";
$GLOBALS['strType'] = "Typ";
$GLOBALS['strAction'] = "Akcja";
$GLOBALS['strParameter'] = "Parametr";
$GLOBALS['strValue'] = "Wartość";
$GLOBALS['strReturnAuditTrail'] = "Powrót do Audytu";
$GLOBALS['strAuditTrail'] = "Audyt";
$GLOBALS['strMaintenanceLog'] = "Log konserwacji";
$GLOBALS['strAuditResultsNotFound'] = "Brak wyników dla wybranych kryteriów.";
$GLOBALS['strCollectedAllEvents'] = "Wszystkie wyniki";
$GLOBALS['strClear'] = "Wyczyść";

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
$GLOBALS['strUserlog'][phpAds_actionActivationMailed] = "Informacja o aktywacji kampanii {id} została wysłana e-mailem";
