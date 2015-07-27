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
$GLOBALS['strDeliveryEngine'] = "Движок доставки";
$GLOBALS['strMaintenance'] = "Обслуговування";
$GLOBALS['strAdministrator'] = "Администратор";

// Audit
$GLOBALS['strDeleted'] = "Видалити";
$GLOBALS['strDelete'] = "Видалити";
$GLOBALS['strHas'] = "содержит";
$GLOBALS['strAdvertiser'] = "Клієнт";
$GLOBALS['strPublisher'] = "Вебсайт";
$GLOBALS['strCampaign'] = "Кампанія";
$GLOBALS['strZone'] = "Зона";
$GLOBALS['strType'] = "Тип";
$GLOBALS['strAction'] = "Дія";
$GLOBALS['strValue'] = "Значение";

if (!isset($GLOBALS['strUserlog'])) {
    $GLOBALS['strUserlog'] = array();
}
$GLOBALS['strUserlog'][phpAds_actionAdvertiserReportMailed] = "Уведомление активации кампании {id} отправлено по e-mail";
$GLOBALS['strUserlog'][phpAds_actionActiveCampaign] = "Уведомление активации кампании {id} отправлено по e-mail";
$GLOBALS['strUserlog'][phpAds_actionAutoClean] = "Уведомление активации кампании {id} отправлено по e-mail";
$GLOBALS['strUserlog'][phpAds_actionBatchStatistics] = "Уведомление активации кампании {id} отправлено по e-mail";
$GLOBALS['strUserlog'][phpAds_actionDeactivationMailed] = "Уведомление активации кампании {id} отправлено по e-mail";
$GLOBALS['strUserlog'][phpAds_actionDeactiveCampaign] = "Уведомление активации кампании {id} отправлено по e-mail";
$GLOBALS['strUserlog'][phpAds_actionPriorityCalculation] = "Уведомление активации кампании {id} отправлено по e-mail";
$GLOBALS['strUserlog'][phpAds_actionPublisherReportMailed] = "Уведомление активации кампании {id} отправлено по e-mail";
$GLOBALS['strUserlog'][phpAds_actionWarningMailed] = "Уведомление активации кампании {id} отправлено по e-mail";
$GLOBALS['strUserlog'][phpAds_actionActivationMailed] = "Уведомление активации кампании {id} отправлено по e-mail";
