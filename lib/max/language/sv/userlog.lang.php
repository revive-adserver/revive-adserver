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
$GLOBALS['strDeliveryEngine'] = "Visningsmotor";
$GLOBALS['strMaintenance'] = "Underhåll";
$GLOBALS['strAdministrator'] = "Administratör";

// Audit
$GLOBALS['strDeleted'] = "raderade";
$GLOBALS['strInserted'] = "lade till";
$GLOBALS['strUpdated'] = "aktualiserade";
$GLOBALS['strDelete'] = "Radera";
$GLOBALS['strHas'] = "har";
$GLOBALS['strFilters'] = "Filter";
$GLOBALS['strAdvertiser'] = "Annonsör";
$GLOBALS['strPublisher'] = "Webbsida";
$GLOBALS['strCampaign'] = "Kampanj";
$GLOBALS['strZone'] = "Zon";
$GLOBALS['strType'] = "Typ";
$GLOBALS['strAction'] = "Handling";
$GLOBALS['strValue'] = "Värde";
$GLOBALS['strReturnAuditTrail'] = "Återvänd till Auditlista";
$GLOBALS['strAuditTrail'] = "Auditlista";
$GLOBALS['strMaintenanceLog'] = "Underhållslogg";
$GLOBALS['strAuditResultsNotFound'] = "Inga händelser passar till valda kriterier";
$GLOBALS['strCollectedAllEvents'] = "Alla händelser";
$GLOBALS['strClear'] = "Rensa";

if (!isset($GLOBALS['strUserlog'])) {
    $GLOBALS['strUserlog'] = array();
}
$GLOBALS['strUserlog'][phpAds_actionAdvertiserReportMailed] = "Aktiveringsmeddelande för kampanj {id} skickat per epost";
$GLOBALS['strUserlog'][phpAds_actionActiveCampaign] = "Aktiveringsmeddelande för kampanj {id} skickat per epost";
$GLOBALS['strUserlog'][phpAds_actionAutoClean] = "Aktiveringsmeddelande för kampanj {id} skickat per epost";
$GLOBALS['strUserlog'][phpAds_actionBatchStatistics] = "Aktiveringsmeddelande för kampanj {id} skickat per epost";
$GLOBALS['strUserlog'][phpAds_actionDeactivationMailed] = "Aktiveringsmeddelande för kampanj {id} skickat per epost";
$GLOBALS['strUserlog'][phpAds_actionDeactiveCampaign] = "Aktiveringsmeddelande för kampanj {id} skickat per epost";
$GLOBALS['strUserlog'][phpAds_actionPriorityCalculation] = "Aktiveringsmeddelande för kampanj {id} skickat per epost";
$GLOBALS['strUserlog'][phpAds_actionPublisherReportMailed] = "Aktiveringsmeddelande för kampanj {id} skickat per epost";
$GLOBALS['strUserlog'][phpAds_actionWarningMailed] = "Aktiveringsmeddelande för kampanj {id} skickat per epost";
$GLOBALS['strUserlog'][phpAds_actionActivationMailed] = "Aktiveringsmeddelande för kampanj {id} skickat per epost";
