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
$GLOBALS['strDeliveryEngine'] = "Motore di Distribuzione";
$GLOBALS['strMaintenance'] = "Manutenzione";
$GLOBALS['strAdministrator'] = "Amministratore";

// Audit
$GLOBALS['strDeleted'] = "cancellato";
$GLOBALS['strInserted'] = "inserito";
$GLOBALS['strUpdated'] = "aggiornato";
$GLOBALS['strDelete'] = "Elimina";
$GLOBALS['strHas'] = "era";
$GLOBALS['strFilters'] = "Filtri";
$GLOBALS['strAdvertiser'] = "Inserzionista";
$GLOBALS['strPublisher'] = "Sito";
$GLOBALS['strCampaign'] = "Campagna";
$GLOBALS['strZone'] = "Zona";
$GLOBALS['strType'] = "Tipo";
$GLOBALS['strAction'] = "Azione";
$GLOBALS['strParameter'] = "Parametro";
$GLOBALS['strValue'] = "Valore";
$GLOBALS['strReturnAuditTrail'] = "Torna a Audit Trail";
$GLOBALS['strAuditTrail'] = "Audit Trail";
$GLOBALS['strMaintenanceLog'] = "Log di manutenzione";
$GLOBALS['strAuditResultsNotFound'] = "Nessun evento trovato corrispondente ai criteri selezionati";
$GLOBALS['strCollectedAllEvents'] = "Tutti gli eventi";
$GLOBALS['strClear'] = "Pulisci";

if (!isset($GLOBALS['strUserlog'])) {
    $GLOBALS['strUserlog'] = [];
}
$GLOBALS['strUserlog'][phpAds_actionAdvertiserReportMailed] = "Relazione per l'interzionista {id} inviato per email";
$GLOBALS['strUserlog'][phpAds_actionActiveCampaign] = "Campagna {id} attivata";
$GLOBALS['strUserlog'][phpAds_actionAutoClean] = "Pulizia automatica del database";
$GLOBALS['strUserlog'][phpAds_actionBatchStatistics] = "Statistiche compilate";
$GLOBALS['strUserlog'][phpAds_actionDeactivationMailed] = "Notifica di disattivazione per la campagna {id} inviato per email";
$GLOBALS['strUserlog'][phpAds_actionDeactiveCampaign] = "Campagna {id} disattivata";
$GLOBALS['strUserlog'][phpAds_actionPriorityCalculation] = "Priorità ricalcolata";
$GLOBALS['strUserlog'][phpAds_actionPublisherReportMailed] = "Relazione per il sito {id} inviato per email";
$GLOBALS['strUserlog'][phpAds_actionWarningMailed] = "Avviso di disattivazione per la campagna {id} inviato per email";
$GLOBALS['strUserlog'][phpAds_actionActivationMailed] = "Notifica attivazione per campagna {id} spedito via email";
