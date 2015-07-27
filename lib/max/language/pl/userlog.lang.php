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
$GLOBALS['strMaintenance'] = "Utrzymanie";

// Audit
$GLOBALS['strDeleted'] = "usunięto";
$GLOBALS['strInserted'] = "dodano";
$GLOBALS['strUpdated'] = "aktualizowano";
$GLOBALS['strDelete'] = "Usuń";
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
$GLOBALS['strUserlog'][phpAds_actionAdvertiserReportMailed] = "Informacja o aktywacji kampanii {id} została wysłana e-mailem";
$GLOBALS['strUserlog'][phpAds_actionActiveCampaign] = "Informacja o aktywacji kampanii {id} została wysłana e-mailem";
$GLOBALS['strUserlog'][phpAds_actionAutoClean] = "Informacja o aktywacji kampanii {id} została wysłana e-mailem";
$GLOBALS['strUserlog'][phpAds_actionBatchStatistics] = "Informacja o aktywacji kampanii {id} została wysłana e-mailem";
$GLOBALS['strUserlog'][phpAds_actionDeactivationMailed] = "Informacja o aktywacji kampanii {id} została wysłana e-mailem";
$GLOBALS['strUserlog'][phpAds_actionDeactiveCampaign] = "Informacja o aktywacji kampanii {id} została wysłana e-mailem";
$GLOBALS['strUserlog'][phpAds_actionPriorityCalculation] = "Informacja o aktywacji kampanii {id} została wysłana e-mailem";
$GLOBALS['strUserlog'][phpAds_actionPublisherReportMailed] = "Informacja o aktywacji kampanii {id} została wysłana e-mailem";
$GLOBALS['strUserlog'][phpAds_actionWarningMailed] = "Informacja o aktywacji kampanii {id} została wysłana e-mailem";
$GLOBALS['strUserlog'][phpAds_actionActivationMailed] = "Informacja o aktywacji kampanii {id} została wysłana e-mailem";
