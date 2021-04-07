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

// Main strings
$GLOBALS['strChooseSection'] = "Выберите раздел";
$GLOBALS['strAppendCodes'] = "Добавить коды";

// Maintenance
$GLOBALS['strScheduledMaintenanceHasntRun'] = "<b>Запланированное обслуживание не запускалось в последний час. Возможно, обслуживание не настроено или настроено некорректно.</b>";





$GLOBALS['strScheduledMantenaceRunning'] = "<b>Запланированное обслуживание работает корректно.</b>";

$GLOBALS['strAutomaticMaintenanceHasRun'] = "<b>Автоматическое обслуживание работает корректно.</b>";

$GLOBALS['strAutoMantenaceEnabled'] = "Автоматическое обслуживание было включено. для лучшей производительности рекомендуется настроить <a href='account-settings-maintenance.php'>запланированное обслуживание</a>.";

// Priority
$GLOBALS['strRecalculatePriority'] = "Пересчитать приоритеты";

// Banner cache
$GLOBALS['strCheckBannerCache'] = "Проверить кэш баннеров";
$GLOBALS['strBannerCacheErrorsFound'] = "В процессе проверки кэша баннеров были обнаружены ошибки. До ручного исправления этих ошибок баннеры показываться не будут.";
$GLOBALS['strBannerCacheOK'] = "В процессе проверки кэша баннеров ошибок не обнаружено.";
$GLOBALS['strBannerCacheDifferencesFound'] = "В процессе проверки кэша баннеров обнаружено устаревание кэша. Нажмите на ссылку для автоматического обновления кэша.";
$GLOBALS['strBannerCacheRebuildButton'] = "Обновить";
$GLOBALS['strRebuildDeliveryCache'] = "Обновить кэш баннеров";

// Cache
$GLOBALS['strCache'] = "Кэш доставки";
$GLOBALS['strDeliveryCacheSharedMem'] = "        Для хранения кэша доставки используется разделяема\\ память.";
$GLOBALS['strDeliveryCacheDatabase'] = "        Для хранения кэша доставки используется база данных.";
$GLOBALS['strDeliveryCacheFiles'] = "        Для хранения кэша доставки используются файлы на сервере.";

// Storage
$GLOBALS['strStorage'] = "Хранение";
$GLOBALS['strMoveToDirectory'] = "Переместить картинки из БД в каталог";
$GLOBALS['strStorageExplaination'] = "	Картинки, используемые локальными баннерами, хранятся в базе данных или в каталоге. Если вы будете хранить картинки
	в каталоге на диске, нагрузка на базу данных уменьшится, и это приведёт к ускорению.";

// Encoding
$GLOBALS['strEncoding'] = "Кодировка";
$GLOBALS['strEncodingConvertFrom'] = "Исходная кодировка:";
$GLOBALS['strEncodingConvertTest'] = "Тестировать преобразование";
$GLOBALS['strConvertThese'] = "Если вы продолжите, следующие данные будут изменены";

// Product Updates
$GLOBALS['strSearchingUpdates'] = "Производится поиск обновлений. Пожалуйста, подождите...";
$GLOBALS['strAvailableUpdates'] = "Доступные обновления";
$GLOBALS['strDownloadZip'] = "Скачать (.zip)";
$GLOBALS['strDownloadGZip'] = "Скачать (.tar.gz)";


$GLOBALS['strUpdateServerDown'] = "    По неизвестной причине невозможно получить информацию <br />
	о возможных обновлениях. Пожалуйста, попытайтесь позднее.";



$GLOBALS['strCheckForUpdatesDisabled'] = "    <b>Проверка обновлений отключена. Пожалуйста, включите через
    <a href='account-settings-update.php'>настройки обновления</a> экрана.</b>";




$GLOBALS['strForUpdatesLookOnWebsite'] = "        Если вы хотите узнать, нет ли более новой версии, посетите наш веб-сайт.";

$GLOBALS['strClickToVisitWebsite'] = "        Щёлкните здесь, чтобы посетить наш веб-сайт";
$GLOBALS['strCurrentlyUsing'] = "В настоящее время вы используете";
$GLOBALS['strRunningOn'] = "запущенную на";
$GLOBALS['strAndPlain'] = "и";

//  Deliver Limitations
$GLOBALS['strDeliveryLimitations'] = "Правила доставки";
$GLOBALS['strAllBannerChannelCompiled'] = "Все наборы правил баннера/доставки перекомпилированы";
$GLOBALS['strErrorsFound'] = "Найдены ошибки";
$GLOBALS['strRepairCompiledLimitations'] = "Были найдены несоответствия, которые вы можете исправить нажав кнопку ниже.<br />";
$GLOBALS['strRecompile'] = "Пересчитать";

//  Append codes
$GLOBALS['strAppendCodesDesc'] = "При некоторых обстоятельствах механизм доставки может некорректно добавлять коды трекеров, используйте следующие ссылки для проверки кодов в БД.";
$GLOBALS['strCheckAppendCodes'] = "Проверить коды";
$GLOBALS['strAppendCodesRecompiled'] = "Все коды были пересчитаны";
$GLOBALS['strAppendCodesResult'] = "Результаты пересчета кодов";
$GLOBALS['strAppendCodesValid'] = "Все коды корректны";
$GLOBALS['strRepairAppenedCodes'] = "Были найдены некоторые несовпадения. для их коррекции нажмите пожалуйста кнопку ниже.";


