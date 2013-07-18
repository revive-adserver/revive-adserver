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
$GLOBALS['strDeliveryEngine']				= "Engine de entrega";
$GLOBALS['strMaintenance']					= "Manutenção";
$GLOBALS['strAdministrator']				= "Administrador";

$GLOBALS['strUserlog'][phpAds_actionAdvertiserReportMailed] = "Relatório para o anunciante {id} enviado por e-mail";
$GLOBALS['strUserlog'][phpAds_actionPublisherReportMailed] = "Relatório para o site {id} enviado por e-mail";
$GLOBALS['strUserlog'][phpAds_actionWarningMailed] = "E-mail de alerta de desativação enviado para a campanha {id}";
$GLOBALS['strUserlog'][phpAds_actionDeactivationMailed] = "Notificação de desativação para a campanha {id} enviada por e-mail";
$GLOBALS['strUserlog'][phpAds_actionPriorityCalculation] = "Prioridade re-calculada";
$GLOBALS['strUserlog'][phpAds_actionPriorityAutoTargeting] = "Destinos da campanha recalculados";
$GLOBALS['strUserlog'][phpAds_actionDeactiveCampaign] = "Campanha {id} desativada";
$GLOBALS['strUserlog'][phpAds_actionActiveCampaign] = "Campanha {id} ativada";
$GLOBALS['strUserlog'][phpAds_actionAutoClean] = "Auto-limpeza da base de dados";




// Note: new translatiosn not found in original lang files but found in CSV
$GLOBALS['strUserlog']['hpAds_actionBatchStatistic'] = "Estatísticas compiladas";


// Note: New translations not found in original lang files but found in CSV
$GLOBALS['strPublisher'] = "Site";
$GLOBALS['strUserlog'][phpAds_actionBatchStatistics] = "Estatísticas compiladas";
$GLOBALS['strUserlog'][phpAds_actionActivationMailed] = "Notificação de desativação para a campanha {id} enviada por e-mail";
?>