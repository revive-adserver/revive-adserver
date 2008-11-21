<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
| For contact details, see: http://www.openx.org/                           |
|                                                                           |
| This program is free software; you can redistribute it and/or modify      |
| it under the terms of the GNU General Public License as published by      |
| the Free Software Foundation; either version 2 of the License, or         |
| (at your option) any later version.                                       |
|                                                                           |
| This program is distributed in the hope that it will be useful,           |
| but WITHOUT ANY WARRANTY; without even the implied warranty of            |
| MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
| GNU General Public License for more details.                              |
|                                                                           |
| You should have received a copy of the GNU General Public License         |
| along with this program; if not, write to the Free Software               |
| Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA |
+---------------------------------------------------------------------------+
$Id$
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