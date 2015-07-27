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
$GLOBALS['strDeliveryEngine'] = "Motor de entrega";
$GLOBALS['strMaintenance'] = "Mantenimiento";
$GLOBALS['strAdministrator'] = "Administrador";

// Audit
$GLOBALS['strDeleted'] = "borrado";
$GLOBALS['strInserted'] = "insertado";
$GLOBALS['strUpdated'] = "actualizado";
$GLOBALS['strDelete'] = "Borrar";
$GLOBALS['strHas'] = "tiene";
$GLOBALS['strFilters'] = "Filtros";
$GLOBALS['strAdvertiser'] = "Anunciante";
$GLOBALS['strPublisher'] = "Página web";
$GLOBALS['strCampaign'] = "Campaña";
$GLOBALS['strZone'] = "Zona";
$GLOBALS['strType'] = "Tipo";
$GLOBALS['strAction'] = "Acción";
$GLOBALS['strParameter'] = "Parámetro";
$GLOBALS['strValue'] = "Valor";
$GLOBALS['strReturnAuditTrail'] = "Volver a Audit Trail";
$GLOBALS['strAuditTrail'] = "Audit Trail";
$GLOBALS['strMaintenanceLog'] = "Registro de mantenimiento";
$GLOBALS['strAuditResultsNotFound'] = "No hay eventos que concuerden con el criterio de selección";
$GLOBALS['strCollectedAllEvents'] = "Todos los eventos";
$GLOBALS['strClear'] = "Limpiar";

if (!isset($GLOBALS['strUserlog'])) {
    $GLOBALS['strUserlog'] = array();
}
$GLOBALS['strUserlog'][phpAds_actionAdvertiserReportMailed] = "Notificación de activación de la campaña {id} enviada por e-mail";
$GLOBALS['strUserlog'][phpAds_actionActiveCampaign] = "Notificación de activación de la campaña {id} enviada por e-mail";
$GLOBALS['strUserlog'][phpAds_actionAutoClean] = "Notificación de activación de la campaña {id} enviada por e-mail";
$GLOBALS['strUserlog'][phpAds_actionBatchStatistics] = "Notificación de activación de la campaña {id} enviada por e-mail";
$GLOBALS['strUserlog'][phpAds_actionDeactivationMailed] = "Notificación de activación de la campaña {id} enviada por e-mail";
$GLOBALS['strUserlog'][phpAds_actionDeactiveCampaign] = "Notificación de activación de la campaña {id} enviada por e-mail";
$GLOBALS['strUserlog'][phpAds_actionPriorityCalculation] = "Notificación de activación de la campaña {id} enviada por e-mail";
$GLOBALS['strUserlog'][phpAds_actionPublisherReportMailed] = "Notificación de activación de la campaña {id} enviada por e-mail";
$GLOBALS['strUserlog'][phpAds_actionWarningMailed] = "Notificación de activación de la campaña {id} enviada por e-mail";
$GLOBALS['strUserlog'][phpAds_actionActivationMailed] = "Notificación de activación de la campaña {id} enviada por e-mail";
