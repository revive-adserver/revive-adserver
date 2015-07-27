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
$GLOBALS['strDeliveryEngine'] = "Delivery Engine";
$GLOBALS['strMaintenance'] = "Onderhoud";
$GLOBALS['strAdministrator'] = "Beheerder";

// Audit
$GLOBALS['strDeleted'] = "verwijderd";
$GLOBALS['strInserted'] = "ingevoegd";
$GLOBALS['strUpdated'] = "bijgewerkt";
$GLOBALS['strDelete'] = "Verwijder";
$GLOBALS['strHas'] = "heeft";
$GLOBALS['strFilters'] = "Filters";
$GLOBALS['strAdvertiser'] = "Adverteerder";
$GLOBALS['strPublisher'] = "Website";
$GLOBALS['strCampaign'] = "Campagne";
$GLOBALS['strZone'] = "Zone";
$GLOBALS['strType'] = "Type";
$GLOBALS['strAction'] = "Actie";
$GLOBALS['strParameter'] = "Parameter";
$GLOBALS['strValue'] = "Waarde";
$GLOBALS['strReturnAuditTrail'] = "Terug naar Audit Logboek";
$GLOBALS['strAuditTrail'] = "Audit logboek";
$GLOBALS['strMaintenanceLog'] = "Maintenance logboek";
$GLOBALS['strAuditResultsNotFound'] = "Geen logboekregistraties gevonden die overeenkomen met de geselecteerde criteria";
$GLOBALS['strCollectedAllEvents'] = "Alle gebeurtenissen";
$GLOBALS['strClear'] = "Leegmaken";

if (!isset($GLOBALS['strUserlog'])) {
    $GLOBALS['strUserlog'] = array();
}
$GLOBALS['strUserlog'][phpAds_actionAdvertiserReportMailed] = "Melding van de activering voor campagne {id} verzenden per e-mail";
$GLOBALS['strUserlog'][phpAds_actionActiveCampaign] = "Melding van de activering voor campagne {id} verzenden per e-mail";
$GLOBALS['strUserlog'][phpAds_actionAutoClean] = "Melding van de activering voor campagne {id} verzenden per e-mail";
$GLOBALS['strUserlog'][phpAds_actionBatchStatistics] = "Melding van de activering voor campagne {id} verzenden per e-mail";
$GLOBALS['strUserlog'][phpAds_actionDeactivationMailed] = "Melding van de activering voor campagne {id} verzenden per e-mail";
$GLOBALS['strUserlog'][phpAds_actionDeactiveCampaign] = "Melding van de activering voor campagne {id} verzenden per e-mail";
$GLOBALS['strUserlog'][phpAds_actionPriorityCalculation] = "Melding van de activering voor campagne {id} verzenden per e-mail";
$GLOBALS['strUserlog'][phpAds_actionPublisherReportMailed] = "Melding van de activering voor campagne {id} verzenden per e-mail";
$GLOBALS['strUserlog'][phpAds_actionWarningMailed] = "Melding van de activering voor campagne {id} verzenden per e-mail";
$GLOBALS['strUserlog'][phpAds_actionActivationMailed] = "Melding van de activering voor campagne {id} verzenden per e-mail";
