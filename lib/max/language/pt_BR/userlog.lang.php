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
$GLOBALS['strDeliveryEngine'] = "Engine de entrega";
$GLOBALS['strMaintenance'] = "Manutenção";
$GLOBALS['strAdministrator'] = "Administrador";

// Audit
$GLOBALS['strDeleted'] = "removido";
$GLOBALS['strInserted'] = "inserido";
$GLOBALS['strUpdated'] = "atualizado";
$GLOBALS['strDelete'] = "Remover";
$GLOBALS['strHas'] = "tem";
$GLOBALS['strFilters'] = "Filtros";
$GLOBALS['strAdvertiser'] = "Anunciante";
$GLOBALS['strPublisher'] = "Site";
$GLOBALS['strCampaign'] = "Campanha";
$GLOBALS['strZone'] = "Zona";
$GLOBALS['strType'] = "Tipo";
$GLOBALS['strAction'] = "Ação";
$GLOBALS['strParameter'] = "Parâmetro";
$GLOBALS['strValue'] = "Valor";
$GLOBALS['strReturnAuditTrail'] = "Voltar para Auditoria de percurso";
$GLOBALS['strAuditTrail'] = "Rastros de auditoria";
$GLOBALS['strMaintenanceLog'] = "Log de manutenção";
$GLOBALS['strAuditResultsNotFound'] = "Nenhum evento encontrado com os critérios informados";
$GLOBALS['strCollectedAllEvents'] = "Todos eventos";
$GLOBALS['strClear'] = "Limpar";

if (!isset($GLOBALS['strUserlog'])) {
    $GLOBALS['strUserlog'] = array();
}
$GLOBALS['strUserlog'][phpAds_actionAdvertiserReportMailed] = "Estatísticas compiladas";
$GLOBALS['strUserlog'][phpAds_actionActiveCampaign] = "Estatísticas compiladas";
$GLOBALS['strUserlog'][phpAds_actionAutoClean] = "Estatísticas compiladas";
$GLOBALS['strUserlog'][phpAds_actionBatchStatistics] = "Estatísticas compiladas";
$GLOBALS['strUserlog'][phpAds_actionDeactivationMailed] = "Estatísticas compiladas";
$GLOBALS['strUserlog'][phpAds_actionDeactiveCampaign] = "Estatísticas compiladas";
$GLOBALS['strUserlog'][phpAds_actionPriorityCalculation] = "Estatísticas compiladas";
$GLOBALS['strUserlog'][phpAds_actionPublisherReportMailed] = "Estatísticas compiladas";
$GLOBALS['strUserlog'][phpAds_actionWarningMailed] = "Estatísticas compiladas";
$GLOBALS['strUserlog'][phpAds_actionActivationMailed] = "Estatísticas compiladas";
