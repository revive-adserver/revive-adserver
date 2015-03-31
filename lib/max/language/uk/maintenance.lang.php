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

$GLOBALS['strAutoMantenaceEnabledAndHasntRun'] = "Автоматическое обслуживание разрешено, но ни разу не запускалось. для лучшей производительности рекомендуется настроить <a href='{$PRODUCT_DOCSURL}/maintenance' target='_blank'>запланированное обслуживание</a>.";

$GLOBALS['strAutoMantenaceDisabledAndHasntRun'] = "Автоматическое обслуживание запрещено. для лучшей производительности рекомендуется настроить <a href='{$PRODUCT_DOCSURL}/maintenance' target='_blank'>запланированное обслуживание</a>.";

$GLOBALS['strAutoMantenaceEnabledAndRunning'] = "Автоматическое обслуживание разрешено, и работает. для лучшей производительности рекомендуется настроить <a href='{$PRODUCT_DOCSURL}/maintenance' target='_blank'>запланированное обслуживание</a>.";

$GLOBALS['strAutoMantenaceDisabledAndRunning'] = "Автоматическое обслуживание было отключено. для лучшей производительности рекомендуется настроить <a href='{$PRODUCT_DOCSURL}/maintenance' target='_blank'>запланированное обслуживание</a>.";

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
$GLOBALS['strBannerCacheExplaination'] = "	Кэш баннеров содержит копию HTML-кода, используемого для показа баннера. Использование кэша позволяет ускорить
	доставку баннеров, поскольку HTML-код не нужно генерировать для каждого показа баннера. Поскольку
	кэш содержит жёстко закодированные ссылки на расположение и самих баннеров, кэш нужно перестраивать
	при каждом перемещении на веб-сервере.";

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
$GLOBALS['strEncodingExplaination'] = "{$PRODUCT_NAME} сохраняет данные в кодировке UTF-8 format.<br />Мы попытаемся конвертировать ваши данные автоматически.<br />Если после обновления вы обнаружите поврежденные данные, и вы знаете исходную кодировку этих данных, вы можете использовать этот инструмент для конвертации ваших данных в UTF-8";
$GLOBALS['strEncodingConvertFrom'] = "Исходная кодировка:";
$GLOBALS['strEncodingConvertTest'] = "Тестировать преобразование";
$GLOBALS['strConvertThese'] = "Если вы продолжите, следующие данные будут изменены";

// Product Updates
$GLOBALS['strSearchingUpdates'] = "Производится поиск обновлений. Пожалуйста, подождите...";
$GLOBALS['strAvailableUpdates'] = "Доступные обновления";
$GLOBALS['strDownloadZip'] = "Скачать (.zip)";
$GLOBALS['strDownloadGZip'] = "Скачать (.tar.gz)";

$GLOBALS['strUpdateAlert'] = "Доступна новас версия {$PRODUCT_NAME}

Хотите узнать больше
об этом обновлении?";
$GLOBALS['strUpdateAlertSecurity'] = "Доступна новас версия {$PRODUCT_NAME}

Рекомендуется произвести обновление
как можно скорее, так как ста
версия содержит одно или несколько исправлений, относящихся к безопасности.";

$GLOBALS['strUpdateServerDown'] = "    По неизвестной причине невозможно получить информацию <br />
	о возможных обновлениях. Пожалуйста, попытайтесь позднее.";

$GLOBALS['strNoNewVersionAvailable'] = "	Ваша версия {$PRODUCT_NAME} не требует обновления. Никаких обновлений в настоящее время нет.";

$GLOBALS['strServerCommunicationError'] = "<b>Связи с сервером обновлений нет, поэтому {$PRODUCT_NAME} не в состоянии проверить, доступна ли новас версия в данный момент. Пожалуйста, повторите попытку позже.</b>";


$GLOBALS['strNewVersionAvailable'] = "	<b>Доступна новас версия </b><br /> Рекомендуется установить это обновление,
	поскольку оно может исправить некоторые существующие проблемы и добавить новую функциональность. За дополнительной
	информацией об обновлении обратитесь к документации, включенной в указанные ниже файлы.";

$GLOBALS['strSecurityUpdate'] = "	<b>Настоятельно рекомендуется установить это обновление как можно скорее, поскольку оно содержит несколько
	исправлений, связанных с безопасностью.</b> Версия , которую вы сейчас используете, может быть
	подвержена определённым атакам, и, вероятно, небезопасна. За дополнительной
	информацией об обновлении обратитесь к документации, включённой в указанные ниже файлы.";

$GLOBALS['strNotAbleToCheck'] = "        <b>Поскольку модуль поддержки XML не установлен на вашем сервере,  {$PRODUCT_NAME} не может
    проверить наличие более свежей версии.</b>";

$GLOBALS['strForUpdatesLookOnWebsite'] = "        Если вы хотите узнать, нет ли более новой версии, посетите наш веб-сайт.";

$GLOBALS['strClickToVisitWebsite'] = "        Щёлкните здесь, чтобы посетить наш веб-сайт";
$GLOBALS['strCurrentlyUsing'] = "В настоящее время вы используете";
$GLOBALS['strRunningOn'] = "запущенную на";
$GLOBALS['strAndPlain'] = "и";

//  Deliver Limitations
$GLOBALS['strDeliveryLimitations'] = "Ограничения показов";
$GLOBALS['strAllBannerChannelCompiled'] = "Все ограничения каналов и баннеров были пересчитаны";
$GLOBALS['strBannerChannelResult'] = "Ниже приведены результаты проверки ограничений баннеров и каналов";
$GLOBALS['strChannelCompiledLimitationsValid'] = "Все ограничения канала корректны";
$GLOBALS['strBannerCompiledLimitationsValid'] = "Все ограничения баннера корректны";
$GLOBALS['strErrorsFound'] = "Найдены ошибки";
$GLOBALS['strRepairCompiledLimitations'] = "Были найдены несоответствия, которые вы можете исправить нажав кнопку ниже.<br />";
$GLOBALS['strRecompile'] = "Пересчитать";
$GLOBALS['strDeliveryEngineDisagreeNotice'] = "При некоторых обстоятельствах механизм доставки может некорректно работать с правами доступа к баннерам и каналам, используйте следующие ссылки для проверки прав доступа в БД.";
$GLOBALS['strCheckACLs'] = "Проверить права доступа";

//  Append codes
$GLOBALS['strAppendCodesDesc'] = "При некоторых обстоятельствах механизм доставки может некорректно добавлять коды трекеров, используйте следующие ссылки для проверки кодов в БД.";
$GLOBALS['strCheckAppendCodes'] = "Проверить коды";
$GLOBALS['strAppendCodesRecompiled'] = "Все коды были пересчитаны";
$GLOBALS['strAppendCodesResult'] = "Результаты пересчета кодов";
$GLOBALS['strAppendCodesValid'] = "Все коды корректны";
$GLOBALS['strRepairAppenedCodes'] = "Были найдены некоторые несовпадения. для их коррекции нажмите пожалуйста кнопку ниже.";


