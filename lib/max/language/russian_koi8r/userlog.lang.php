<?php

/*
+---------------------------------------------------------------------------+
| Max Media Manager v0.3                                                    |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2006 m3 Media Services Limited                         |
| For contact details, see: http://www.m3.net/                              |
|                                                                           |
| Copyright (c) 2000-2003 the phpAdsNew developers                          |
| For contact details, see: http://www.phpadsnew.com/                       |
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


$GLOBALS['strUserlog'] = array (
	phpAds_actionAdvertiserReportMailed 	=> "Отчёт для рекламодателя {id} отослан по электронной почте",
	phpAds_actionPublisherReportMailed 		=> "Отчёт для издателя {id} отослан по электронной почте",
	phpAds_actionWarningMailed				=> "Предупреждение о деактивации кампании {id} отослано по электронной почте",
	phpAds_actionDeactivationMailed			=> "Уведомление о деактивации кампании {id} отослано по электронной почте",
	phpAds_actionPriorityCalculation		=> "Приоритеты пересчитаны",
	phpAds_actionPriorityAutoTargeting		=> "Цели кампании пересчитаны",
	phpAds_actionDeactiveCampaign			=> "Кампания {id} деактивирована",
	phpAds_actionActiveCampaign				=> "Кампания {id} активирована",
	phpAds_actionAutoClean					=> "Автоочистка базы данных"
);

?>