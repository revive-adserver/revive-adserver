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
$GLOBALS['strDeliveryEngine'] = "Motor d'entrega";
$GLOBALS['strMaintenance'] = "Manteniment";
$GLOBALS['strAdministrator'] = "Administrador/a";

// Audit
$GLOBALS['strDeleted'] = "s'ha suprimit";
$GLOBALS['strInserted'] = "s'ha inserit";
$GLOBALS['strUpdated'] = "s'ha actualitzat";
$GLOBALS['strDelete'] = "Suprimeix";
$GLOBALS['strHas'] = "té";
$GLOBALS['strFilters'] = "Filtres";
$GLOBALS['strAdvertiser'] = "Anunciant";
$GLOBALS['strPublisher'] = "Pàgina web";
$GLOBALS['strCampaign'] = "Campanya";
$GLOBALS['strZone'] = "Zona";
$GLOBALS['strType'] = "Tipus";
$GLOBALS['strAction'] = "Acció";
$GLOBALS['strParameter'] = "Paràmetre";
$GLOBALS['strValue'] = "Valor";
$GLOBALS['strReturnAuditTrail'] = "Torna a la pista d'auditoria";
$GLOBALS['strAuditTrail'] = "Pista d'auditoria";
$GLOBALS['strMaintenanceLog'] = "Log de manteniment";
$GLOBALS['strAuditResultsNotFound'] = "No s'han trobat esdeveniments pels criteris seleccionats";
$GLOBALS['strCollectedAllEvents'] = "Tots els esdeveniments";
$GLOBALS['strClear'] = "Neteja";

if (!isset($GLOBALS['strUserlog'])) {
    $GLOBALS['strUserlog'] = [];
}
$GLOBALS['strUserlog'][phpAds_actionAdvertiserReportMailed] = "Informe per l'anunciant {id} enviat per correu electrònic";
$GLOBALS['strUserlog'][phpAds_actionActiveCampaign] = "Campanya {id} activada";
$GLOBALS['strUserlog'][phpAds_actionAutoClean] = "Neteja automàtica de la base de dades";
$GLOBALS['strUserlog'][phpAds_actionBatchStatistics] = "Estadístiques compilades";
$GLOBALS['strUserlog'][phpAds_actionDeactivationMailed] = "Notificació de desactivació de la campanya {id} enviada per correu electrònic";
$GLOBALS['strUserlog'][phpAds_actionDeactiveCampaign] = "Campanya {id} desactivada";
$GLOBALS['strUserlog'][phpAds_actionPriorityCalculation] = "Prioritat recalculada";
$GLOBALS['strUserlog'][phpAds_actionPublisherReportMailed] = "Informe pel lloc web {id} enviat per correu electrònic";
$GLOBALS['strUserlog'][phpAds_actionWarningMailed] = "Avís de desactivació de la campanya {id} enviat per correu electrònic";
$GLOBALS['strUserlog'][phpAds_actionActivationMailed] = "Notificació d'activació de la campanya {id} enviada per correu electrònic";
