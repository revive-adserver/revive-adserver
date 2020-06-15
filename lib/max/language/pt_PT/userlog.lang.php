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
$GLOBALS['strUserlog'][phpAds_actionAdvertiserReportMailed] = "Report for advertiser {id} send by email";
$GLOBALS['strUserlog'][phpAds_actionActiveCampaign] = "Campaign {id} activated";
$GLOBALS['strUserlog'][phpAds_actionAutoClean] = "Auto clean of database";
$GLOBALS['strUserlog'][phpAds_actionBatchStatistics] = "Statistics compiled";
$GLOBALS['strUserlog'][phpAds_actionDeactivationMailed] = "Deactivation notification for campaign {id} send by email";
$GLOBALS['strUserlog'][phpAds_actionDeactiveCampaign] = "Campaign {id} deactivated";
$GLOBALS['strUserlog'][phpAds_actionPriorityCalculation] = "Priority recalculated";
$GLOBALS['strUserlog'][phpAds_actionPublisherReportMailed] = "Report for website {id} send by email";
$GLOBALS['strUserlog'][phpAds_actionWarningMailed] = "Deactivation warning for campaign {id} send by email";
$GLOBALS['strUserlog'][phpAds_actionActivationMailed] = "Relatório para o site {id} enviado por e-mail";
