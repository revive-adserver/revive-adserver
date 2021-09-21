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
    $GLOBALS['strUserlog'] = [];
}
$GLOBALS['strUserlog'][phpAds_actionAdvertiserReportMailed] = "Informe para el anunciante {id} enviar por correo electrónico";
$GLOBALS['strUserlog'][phpAds_actionActiveCampaign] = "Campaña {id} activada";
$GLOBALS['strUserlog'][phpAds_actionAutoClean] = "Auto limpieza de base de datos";
$GLOBALS['strUserlog'][phpAds_actionBatchStatistics] = "Estadísticas compiladas";
$GLOBALS['strUserlog'][phpAds_actionDeactivationMailed] = "Notificación de desactivación de la campaña {id} enviada por e-mail";
$GLOBALS['strUserlog'][phpAds_actionDeactiveCampaign] = "Campaña {id} desactivada";
$GLOBALS['strUserlog'][phpAds_actionPriorityCalculation] = "Prioridad recalculada";
$GLOBALS['strUserlog'][phpAds_actionPublisherReportMailed] = "Informe para el sitio web {id} enviado por correo electrónico";
$GLOBALS['strUserlog'][phpAds_actionWarningMailed] = "Advertencia de desactivación para la campaña {id} enviada por correo electrónico";
$GLOBALS['strUserlog'][phpAds_actionActivationMailed] = "Notificación de activación de la campaña {id} enviada por e-mail";
