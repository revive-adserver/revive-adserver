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
$GLOBALS['strUpdated'] = "uppdaterat";
$GLOBALS['strDelete'] = "Radera";
$GLOBALS['strHas'] = "har";
$GLOBALS['strFilters'] = "Filter";
$GLOBALS['strAdvertiser'] = "Annonsör";
$GLOBALS['strPublisher'] = "Webbsida";
$GLOBALS['strCampaign'] = "Kampanj";
$GLOBALS['strZone'] = "Zon";
$GLOBALS['strType'] = "Typ";
$GLOBALS['strAction'] = "Handling";
$GLOBALS['strParameter'] = "Parameter";
$GLOBALS['strValue'] = "Värde";
$GLOBALS['strReturnAuditTrail'] = "Återvänd till Auditlista";
$GLOBALS['strAuditTrail'] = "Auditlista";
$GLOBALS['strMaintenanceLog'] = "Underhållslogg";
$GLOBALS['strAuditResultsNotFound'] = "Inga händelser passar till valda kriterier";
$GLOBALS['strCollectedAllEvents'] = "Alla händelser";
$GLOBALS['strClear'] = "Rensa";

if (!isset($GLOBALS['strUserlog'])) {
    $GLOBALS['strUserlog'] = [];
}
$GLOBALS['strUserlog'][phpAds_actionAdvertiserReportMailed] = "Rapport för annonsör {id} skicka via e-post";
$GLOBALS['strUserlog'][phpAds_actionActiveCampaign] = "Kampanj {id} aktiverad";
$GLOBALS['strUserlog'][phpAds_actionAutoClean] = "Automatisk rengöring av databasen";
$GLOBALS['strUserlog'][phpAds_actionBatchStatistics] = "Statistik sammanställd";
$GLOBALS['strUserlog'][phpAds_actionDeactivationMailed] = "Inaktiveringsanmälan för kampanj {id} skicka via e-post";
$GLOBALS['strUserlog'][phpAds_actionDeactiveCampaign] = "Kampanj {id} avaktiverad";
$GLOBALS['strUserlog'][phpAds_actionPriorityCalculation] = "Prioritet omräknad";
$GLOBALS['strUserlog'][phpAds_actionPublisherReportMailed] = "Rapport för webbplatsen {id} skicka via e-post";
$GLOBALS['strUserlog'][phpAds_actionWarningMailed] = "Inaktiveringsvarning för kampanj {id} skicka via e-post";
$GLOBALS['strUserlog'][phpAds_actionActivationMailed] = "Aktiveringsmeddelande för kampanj {id} skickat per epost";
