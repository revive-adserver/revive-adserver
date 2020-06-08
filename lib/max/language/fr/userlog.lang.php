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
$GLOBALS['strDeliveryEngine'] = "Moteur de distribution";
$GLOBALS['strMaintenance'] = "Entretien";
$GLOBALS['strAdministrator'] = "Administrateur";

// Audit
$GLOBALS['strDeleted'] = "supprimé(e)";
$GLOBALS['strInserted'] = "inséré(e)";
$GLOBALS['strUpdated'] = "mis(e) à jour";
$GLOBALS['strDelete'] = "Supprimer";
$GLOBALS['strHas'] = "contient";
$GLOBALS['strFilters'] = "Filtres";
$GLOBALS['strAdvertiser'] = "Annonceur";
$GLOBALS['strPublisher'] = "Site web";
$GLOBALS['strCampaign'] = "Campagne";
$GLOBALS['strZone'] = "Zone";
$GLOBALS['strType'] = "Type";
$GLOBALS['strAction'] = "Action";
$GLOBALS['strParameter'] = "Paramètre";
$GLOBALS['strValue'] = "Valeur";
$GLOBALS['strReturnAuditTrail'] = "Retourner à la piste d'audit";
$GLOBALS['strAuditTrail'] = "Piste d'audit";
$GLOBALS['strMaintenanceLog'] = "Journal de maintenance";
$GLOBALS['strAuditResultsNotFound'] = "Aucun évènement trouvé correspondant aux critères sélectionnés";
$GLOBALS['strCollectedAllEvents'] = "Tous les évènements";
$GLOBALS['strClear'] = "Vider";

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
$GLOBALS['strUserlog'][phpAds_actionActivationMailed] = "Notification d'activation de la campagne {id} envoyée par e-mail";
