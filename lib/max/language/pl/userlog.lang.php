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
$GLOBALS['strAdministrator'] = "Administrator";

// Audit
$GLOBALS['strDeleted'] = "usunięto";
$GLOBALS['strInserted'] = "dodano";
$GLOBALS['strUpdated'] = "aktualizowano";
$GLOBALS['strDelete'] = "Usuń";
$GLOBALS['strHas'] = "has";
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
$GLOBALS['strUserlog'][phpAds_actionActivationMailed] = "Informacja o aktywacji kampanii {id} została wysłana e-mailem";
