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
    $GLOBALS['strUserlog'] = [];
}
$GLOBALS['strUserlog'][phpAds_actionActivationMailed] = "Уведомление активации кампании {id} отправлено по e-mail";
