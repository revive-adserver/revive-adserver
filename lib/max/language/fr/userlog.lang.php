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
$GLOBALS['strPublisher'] = "Site internet";
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
    $GLOBALS['strUserlog'] = [];
}
$GLOBALS['strUserlog'][phpAds_actionActivationMailed] = "Notification d'activation de la campagne {id} envoyée par e-mail";
