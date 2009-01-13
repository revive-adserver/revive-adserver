<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
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

$GLOBALS['strDeliveryEngine']				= "Движок доставки";
$GLOBALS['strMaintenance']					= "Обслуживание";
$GLOBALS['strAdministrator']				= "Администратор";


$GLOBALS['strUserlog'][phpAds_actionAdvertiserReportMailed] = "Отчет для клиента {id} отправлен по e-mail";
$GLOBALS['strUserlog'][phpAds_actionPublisherReportMailed] = "Отчет для сайта {id} отправлен по e-mail";
$GLOBALS['strUserlog'][phpAds_actionWarningMailed] = "Предупреждение о деактивации кампании {id} отослано по электронной почте";
$GLOBALS['strUserlog'][phpAds_actionDeactivationMailed] = "Уведомление об остановке кампании {id} отправлено по e-mail";
$GLOBALS['strUserlog'][phpAds_actionPriorityCalculation] = "Приоритеты пересчитаны";
$GLOBALS['strUserlog'][phpAds_actionPriorityAutoTargeting] = "Цели кампании пересчитаны";
$GLOBALS['strUserlog'][phpAds_actionDeactiveCampaign] = "Кампания {id} остановлена";
$GLOBALS['strUserlog'][phpAds_actionActiveCampaign] = "Кампания {id} активирована";
$GLOBALS['strUserlog'][phpAds_actionAutoClean] = "Авто-очистка БД";




// Note: new translatiosn not found in original lang files but found in CSV
$GLOBALS['strUserlog']['hpAds_actionBatchStatistic'] = "Статистика обработана";


// Note: New translations not found in original lang files but found in CSV
$GLOBALS['strPublisher'] = "Вебсайт";
$GLOBALS['strUserlog'][phpAds_actionBatchStatistics] = "Статистика обработана";
$GLOBALS['strHas'] = "содержит";
$GLOBALS['strUserlog'][phpAds_actionActivationMailed] = "Уведомление активации кампании {id} отправлено по e-mail";
?>