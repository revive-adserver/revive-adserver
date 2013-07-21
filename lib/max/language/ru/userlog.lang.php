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