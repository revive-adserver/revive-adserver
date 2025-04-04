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
$GLOBALS['strDeliveryEngine'] = "Механізм доставки";
$GLOBALS['strMaintenance'] = "Обслуговування";
$GLOBALS['strAdministrator'] = "Адміністратор";

// Audit
$GLOBALS['strDeleted'] = "Видалити";
$GLOBALS['strInserted'] = "вставлено";
$GLOBALS['strUpdated'] = "оновлено";
$GLOBALS['strDelete'] = "Видалити";
$GLOBALS['strHas'] = "має";
$GLOBALS['strFilters'] = "Фільтри";
$GLOBALS['strAdvertiser'] = "Клієнт";
$GLOBALS['strPublisher'] = "Вебсайт";
$GLOBALS['strCampaign'] = "Кампанія";
$GLOBALS['strZone'] = "Зона";
$GLOBALS['strType'] = "Тип";
$GLOBALS['strAction'] = "Дія";
$GLOBALS['strParameter'] = "Параметр";
$GLOBALS['strValue'] = "Значення";
$GLOBALS['strReturnAuditTrail'] = "Повернутися до аудиту";
$GLOBALS['strAuditTrail'] = "Аудит";
$GLOBALS['strMaintenanceLog'] = "Журнал технічного обслуговування";
$GLOBALS['strAuditResultsNotFound'] = "Не знайдено подій, що відповідають вибраним критеріям";
$GLOBALS['strCollectedAllEvents'] = "Всі події";
$GLOBALS['strClear'] = "Очистити";

if (!isset($GLOBALS['strUserlog'])) {
    $GLOBALS['strUserlog'] = [];
}
$GLOBALS['strUserlog'][phpAds_actionAdvertiserReportMailed] = "Сповіщення про активацію кампанії {id} надіслано електронною поштою";
