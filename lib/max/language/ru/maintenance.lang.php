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

// Main strings
$GLOBALS['strChooseSection']			= "Выберите раздел";


// Priority
$GLOBALS['strRecalculatePriority']		= "Пересчитать приоритеты";
$GLOBALS['strHighPriorityCampaigns']		= "Кампании с высоким приоритетом";
$GLOBALS['strAdViewsAssigned']			= "Выделено просмотров";
$GLOBALS['strLowPriorityCampaigns']		= "Кампании с низким приоритетом";
$GLOBALS['strPredictedAdViews']			= "Предсказано просмотров";
$GLOBALS['strPriorityDaysRunning']		= "Сейчас доступно {days} дней статистики, на которой ".$phpAds_productname." может основывать свои предсказания. ";
$GLOBALS['strPriorityBasedLastWeek']		= "Предсказания основаны на данных по этой и прошлой неделе. ";
$GLOBALS['strPriorityBasedYesterday']		= "Предсказание основано на данных за вчера. ";
$GLOBALS['strPriorityNoData']			= "Недостаточно данных для надёжного предсказания количества показов, которые данный сервер сгенерирует сегодня. Назначение проритетов будет основываться на статистике, собираемой в реальном времени. ";
$GLOBALS['strPriorityEnoughAdViews']		= "Должно быть достаточно показов для удовлетворения требований всех высокоприоритетных кампаний. ";
$GLOBALS['strPriorityNotEnoughAdViews']		= "Неочевидно, будет ли сегодня сгенерировано достаточно показов для удовлетворения требований всех высокопроритетных кампаний. ";


// Banner cache
$GLOBALS['strRebuildBannerCache']		= "Построить кэш баннеров заново";
$GLOBALS['strBannerCacheExplaination']		= "
	Кэш баннеров содержит копию HTML-кода, используемого для показа баннера. Использование кэша позволяет ускорить
	доставку баннеров, поскольку HTML-код не нужно генерировать для каждого показа баннера. Поскольку
	кэш содержит жёстко закодированные ссылки на расположение  и самих баннеров, кэш нужно перестраивать
	при каждом перемещении  на веб-сервере.
";


// Zone cache
$GLOBALS['strAge']				= "Срок";
$GLOBALS['strCache']                    = "Кэш доставки";
$GLOBALS['strRebuildDeliveryCache']                     = "Обновить кэш баннеров";
$GLOBALS['strDeliveryCacheExplaination']                = "
        Кэш доставки используется для ускорения доставки баннеров. Кэш содержит копию всех баннеров,
        привязанных к зоне/ Это экономит несколько запросов к базе данных в момент фактического показа баннера пользователю. Кэш
        обычно обновляется после каждого изменения в зоне или одном из привязанных к ней баннеров, но, возможно, он может устаревать. Поэтому
        кэш также обновляется автоматически каждый час, или может быть обновлён вручную.
";
$GLOBALS['strDeliveryCacheSharedMem']           = "
        Для хранения кэша доставки используется разделяемая память.
";
$GLOBALS['strDeliveryCacheDatabase']            = "
        Для хранения кэша доставки используется база данных.
";


// Storage
$GLOBALS['strStorage']				= "Хранение";
$GLOBALS['strMoveToDirectory']			= "Переместить картинки из БД в каталог";
$GLOBALS['strStorageExplaination']		= "
	Картинки, используемые локальными баннерами, хранятся в базе данных или в каталоге. Если вы будете хранить картинки
	в каталоге на диске, нагрузка на базу данных уменьшится, и это приведёт к ускорению.
";


// Storage
$GLOBALS['strStatisticsExplaination']		= "Вы включили режим <i>компактной статистики</i>, но ваши старые данные остаются в подробном формате. Хотите ли вы конвертировать ваши данные в компактный формат?";


// Product Updates
$GLOBALS['strSearchingUpdates']			= "Производится поиск обновлений. Пожалуйста, подождите...";
$GLOBALS['strAvailableUpdates']			= "Доступные обновления";
$GLOBALS['strDownloadZip']			= "Скачать (.zip)";
$GLOBALS['strDownloadGZip']			= "Скачать (.tar.gz)";

$GLOBALS['strUpdateAlert']			= "Доступна новая версия

Хотите узнать больше
об этом обновлении?";
$GLOBALS['strUpdateAlertSecurity']		= "Доступна новая версия

Рекомендуется произвести обновление
как можно скорее, так как эта
версия содержит одно или несколько исправлений, относящихся к безопасности.";

$GLOBALS['strUpdateServerDown']			= "
    По неизвестной причине невозможно получить информацию <br />
	о возможных обновлениях. Пожалуйста, попытайтесь позднее.
";

$GLOBALS['strNoNewVersionAvailable']		= "
	Ваша версия  не требует обновления. Никаких обновлений в настоящее время нет.
";

$GLOBALS['strNewVersionAvailable']		= "
	<b>Доступна новая версия </b><br /> Рекомендуется установить это обновление,
	поскольку оно может исправить некоторые существующие проблемы и добавить новую функциональность. За дополнительной
	информацией об обновлении обратитесь к документации, включенной в указанные ниже файлы.
";

$GLOBALS['strSecurityUpdate']			= "
	<b>Настоятельно рекомендуется установить это обновление как можно скорее, поскольку оно содержит несколько
	исправлений, связанных с безопасностью.</b> Версия , которую вы сейчас используете, может быть
	подвержена определённым атакам, и, вероятно, небезопасна. За дополнительной
	информацией об обновлении обратитесь к документации, включённой в указанные ниже файлы.
";

$GLOBALS['strNotAbleToCheck']                   = "
        <b>Поскольку модуль поддержки XML не установлен на вашем сервере,  ".MAX_PRODUCT_NAME." не может
    проверить наличие более свежей версии.</b>
";

$GLOBALS['strForUpdatesLookOnWebsite']  = "
        Если вы хотите узнать, нет ли более новой версии, посетите наш веб-сайт.
";

$GLOBALS['strClickToVisitWebsite']              = "
        Щёлкните здесь, чтобы посетить наш веб-сайт
";


// Stats conversion
$GLOBALS['strConverting']			= "Преобразование";
$GLOBALS['strConvertingStats']			= "Преобразовываем статистики...";
$GLOBALS['strConvertStats']			= "Преобразовать статистику";
$GLOBALS['strConvertAdViews']			= "Показы преобразованы,";
$GLOBALS['strConvertAdClicks']			= "Клики преобразованы...";
$GLOBALS['strConvertNothing']			= "Нечего преобразовывать...";
$GLOBALS['strConvertFinished']			= "Закончено...";

$GLOBALS['strConvertExplaination']		= "
	Вы сейчас используете компактный формат хранения вашей статистики, но у вас всё еще есть <br />
	некоторые данные в расширенном формате. До тех пор пока расширенная статистика не будет  <br />
	преобразована в компактный формат, она не будет использоваться при просмотре этих страниц.  <br />
	Перед преобразованием статистики, сделайте резервную копию базы данных!  <br />
	Вы хотите преобразовать вашу расширенную статистику в новый компактный формат? <br />
";

$GLOBALS['strConvertingExplaination']		= "
	Вся оставшаяся расширенная статистика сейчас преобразуется в компактный формат. <br />
	В зависимости от того, сколько показов сохранено в расширенном формате, это может занять  <br />
	несколько минут. Пожалуйста, подождите окончания преобразования, прежде чем вы перейдёте на другие <br />
	страницыpages. Ниже вы увидите журнал всех изменений, произвёденных в базе данных. <br />
";

$GLOBALS['strConvertFinishedExplaination']  	= "
	Преобразование остававшейся расширенной статистики было успешным и все данные <br />
	должны быть теперь доступны. Ниже вы можете увидеть журнал всех изменений, <br />
	произведённых в базе данных.<br />
";




// Note: new translatiosn not found in original lang files but found in CSV
$GLOBALS['strCheckBannerCache'] = "Проверить кеш баннеров";
$GLOBALS['strBannerCacheErrorsFound'] = "В результате проверки кеша баннеров обнаружены ошибки. þасть баннеров не будет показываться до тех пор, пока вы не исправите ошибки в кеше.";
$GLOBALS['strBannerCacheOK'] = "Ошибок не обнаружено. Кеш баннеров работает нормально.";
$GLOBALS['strBannerCacheDifferencesFound'] = "В результате проверки кеша баннеров обнаружено устаревание кеша. Нажмите сюда для автоматическогообновления кеша.";
$GLOBALS['strBannerCacheRebuildButton'] = "Перестроить";
$GLOBALS['strDeliveryCacheFiles'] = "\n        Для хранения кэша доставки используются файлы на сервере.\n";
$GLOBALS['strCurrentlyUsing'] = "В настоящее время вы используете";
$GLOBALS['strRunningOn'] = "запущенную на";
$GLOBALS['strAndPlain'] = "и";
$GLOBALS['strBannerCacheFixed'] = "Автоматическое обновление кеша произведено успешно. Кеш баннеров работает нормально.";
?>