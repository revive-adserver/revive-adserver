<?php // $Revision$

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2000-2005 by the phpAdsNew developers                  */
/* http://sourceforge.net/projects/phpadsnew                            */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/



// Installer translation strings
$GLOBALS['strInstall']					= "Установка";
$GLOBALS['strChooseInstallLanguage']	= "Выберите язык для процедуры установки";
$GLOBALS['strLanguageSelection']		= "Выбор Языка";
$GLOBALS['strDatabaseSettings']			= "Настройки Базы Данных";
$GLOBALS['strAdminSettings']			= "Настройки Администратора";
$GLOBALS['strAdvancedSettings']			= "Расширенные Настройки";
$GLOBALS['strOtherSettings']			= "Другие Настройки";

$GLOBALS['strWarning']					= "Предупреждение";
$GLOBALS['strFatalError']				= "Произошла фатальная ошибка";
$GLOBALS['strAlreadyInstalled']			= "phpAdsNew уже установлена на этой системе. Если вы хотите ее настроить, переходите к <a href='settings-index.php'>интерфейсу настроек</a>";
$GLOBALS['strCouldNotConnectToDB']		= "Не удалось связаться с базой данной, перепроверьте указанные вами параметры";
$GLOBALS['strCreateTableTestFailed']	= "Указанный вами пользователь не имеет прав создавать или изменять структуру базы данных, пожалуйста, свяжитесь с администратором БД.";
$GLOBALS['strUpdateTableTestFailed']	= "Указанный вами пользователь не имеет прав на изменение структуры базы данных, пожалуйста, свяжитесь с администратором БД.";
$GLOBALS['strTablePrefixInvalid']		= "Приставка к имени таблицы содержит запрещенные символы";
$GLOBALS['strTableInUse']				= "Указанная вами база даных уже используется для phpAdsNew, пожалуйста, укажите другую приставку к именам таблиц, или прочтите в руководстве инструкции по апгрейду.";
$GLOBALS['strMayNotFunction']			= "Перед тем как проолжить, пожалуйта, исправьте эти возможные проблемы:";
$GLOBALS['strIgnoreWarnings']			= "Игнорировать предупреждения";
$GLOBALS['strWarningPHPversion']		= "phpAdsNew для корректной работы необходим PHP 3.0.8 или выше. Вы сейчас используете {php_version}.";
$GLOBALS['strWarningRegisterGlobals']	= "Конфигурационная переменная PHP register_globals должна быть включена (on).";
$GLOBALS['strWarningMagicQuotesGPC']	= "Конфигурационная переменная PHP magic_quotes_gpc должна быть включена (on).";
$GLOBALS['strWarningMagicQuotesRuntime']= "Конфигурационная переменная PHP magic_quotes_runtime должна быть включена (on).";
$GLOBALS['strConfigLockedDetected']		= "phpAdsNew определила, что ваш файл <b>config.inc.php</b> не может быть записан сервером.<br> Вы не можете продолжить, прежде чем поменяете права доступа к этому файлу. <br>Прочитайте прилагаемую документацию, если вы не знаете, как это сделать.";
$GLOBALS['strCantUpdateDB']  			= "Не представляется возможным обновить базу данных. Если вы решите продолжить, все существующие баннеры, статистика и данные о клиентах будут стерты.";
$GLOBALS['strTableNames']				= "Имена таблиц";
$GLOBALS['strTablesPrefix']				= "Приставка к именам таблиц";
$GLOBALS['strTablesType']				= "Тип таблиц";

$GLOBALS['strInstallWelcome']			= "Добро пожаловать в phpAdsNew";
$GLOBALS['strInstallMessage']			= "Прежде чем вы сможете начать использовать phpAdsNew, необходимо произвести конфигурацию и <br>создать базу данных. Щёлкните <b>Дальше</b> для продолжения.";
$GLOBALS['strInstallSuccess']			= "<b>Установка phpAdsNew завершена..</b><br><br>Для корректного функционирования phpAdsNew вы также должны
										   убедиться, что файл обслуживания запускается каждый день. Дополнительная информация по этому поводу может быть найдена в документации.
										   <br><br>Щёлкните <b>Дальше</b> для перехода на страницу конфигурации, где вы можете 
										   сконфигурировать дополнительные настройки. Пожалуйста, не забудьте заблокировать файл config.inc.php, когда вы закончите с настройками - это предотвратит возможный взлом системы.";
$GLOBALS['strInstallNotSuccessful']		= "<b>Установка phpAdsNew не произошла</b><br><br>Некоторые части процесса установки не могли быть завершены.
										   Возможно, эти проблемы исключительно временные, в таком случае вы можете просто щёлкнуть <b>Дальше</b> и вернуться к
										   первому шагу процесса установки. Если вы хотите узнать больше о значении нижеследующего сообщения об ошибке и как её устранить, 
										   обратитесь к поставляемой документации.";
$GLOBALS['strErrorOccured']				= "Произошла следующая ошибка:";
$GLOBALS['strErrorInstallDatabase']		= "Структура базы данных не могла быть создана.";
$GLOBALS['strErrorInstallConfig']		= "Файл конфигурации или база данных не могут быть обновлены.";
$GLOBALS['strErrorInstallDbConnect']	= "Не получилось открыть соединение с базой данных.";

$GLOBALS['strUrlPrefix']				= "Префикс URL";

$GLOBALS['strProceed']					= "Дальше &gt;";
$GLOBALS['strRepeatPassword']			= "Повторите пароль";
$GLOBALS['strNotSamePasswords']			= "Пароли не совпали";
$GLOBALS['strInvalidUserPwd']			= "Неверное имя пользователя или пароль";

$GLOBALS['strUpgrade']					= "Обновить";
$GLOBALS['strSystemUpToDate']			= "Ваша система не требует обновления. <br>Щёлкните по <b>Дальше</b> для перехода на домашнюю страницу.";
$GLOBALS['strSystemNeedsUpgrade']		= "Сруктура базы данных и файл конфигурации должны быть обновлены для корректного функционирования системы. Щёлкните <b>Дальше</b>, чтобы запустить процесс обновления. <br>Будьте терпеливы? обновление может занять пару минут.";
$GLOBALS['strSystemUpgradeBusy']		= "Происходит обновление системы? пожалуйста? подождите...";
$GLOBALS['strServiceUnavalable']		= "Обслуживание временно недоступно. Происходит обновление системы";

$GLOBALS['strConfigNotWritable']		= "Ваш файл config.inc.php не имеет прав на запись в него";





/*********************************************************/
/* Configuration translations                            */
/*********************************************************/

// Global
$GLOBALS['strChooseSection']			= "Выберите раздел";
$GLOBALS['strDayFullNames'] 			= array("Воскресенье","Понедельник","Вторник","Среда","Четверг","Пятница","Суббота");
$GLOBALS['strEditConfigNotPossible']    = "Отредактировать данные настройки невозможно, так как файл конфигурации заперт из соображений безопасности. ".
										  "Если вы хотите произвести изменения, вам нужно сначала отпереть файл сonfig.inc.php.";
$GLOBALS['strEditConfigPossible']		= "Можно редактировать все настройки, так как файл конфигурации не заперт, но это может привести к проблемам с безопасностью системы. ".
										  "Если вы хотите обезопасить вашу систему, вам необходимо запереть файл config.inc.php.";



// Database
$GLOBALS['strDatabaseSettings']			= "Настройки базы данных";
$GLOBALS['strDatabaseServer']			= "Сервер баз данных";
$GLOBALS['strDbHost']					= "Имя хоста";
$GLOBALS['strDbUser']					= "Имя пользователя";
$GLOBALS['strDbPassword']				= "Пароль";
$GLOBALS['strDbName']					= "Имя базы данных";

$GLOBALS['strDatabaseOptimalisations']	= "Оптимизация базы данных";
$GLOBALS['strPersistentConnections']	= "Использовать постоянные соединения";
$GLOBALS['strInsertDelayed']			= "Использовать отложенные вставки";
$GLOBALS['strCompatibilityMode']		= "Использовать режим совместимости по базе данных";
$GLOBALS['strCantConnectToDb']			= "Не могу связаться с базой данных";



// Invocation and Delivery
$GLOBALS['strInvocationAndDelivery']	= "Настройки вызова и доставки";

$GLOBALS['strKeywordRetrieval']			= "Извлечение по ключевым словам";
$GLOBALS['strBannerRetrieval']			= "Метод извлечения баннеров";
$GLOBALS['strRetrieveRandom']			= "Случайное извлечение (по умолчанию)";
$GLOBALS['strRetrieveNormalSeq']		= "Обычное последовательное извлечение";
$GLOBALS['strWeightSeq']				= "Последовательное извлечение с учётом весов";
$GLOBALS['strFullSeq']					= "Полное последовательное извлечение";
$GLOBALS['strUseConditionalKeys']		= "Разрешить логические операторы при прямой выборке";
$GLOBALS['strUseMultipleKeys']			= "Разрешить множественные ключевые слова при прямой выборке";
$GLOBALS['strUseAcl']					= "Оценивать ограничения по доставке в процессе показов";

$GLOBALS['strDeliverySettings']                 = "Настройки доставки";
$GLOBALS['strCacheType']                                = "Тип кэша доставки";
$GLOBALS['strCacheFiles']                               = "Файлы";
$GLOBALS['strCacheDatabase']                    = "База данных";
$GLOBALS['strCacheShmop']                               = "Разделяемая память (shmop)";

$GLOBALS['strZonesSettings']			= "Извлечение зон";
$GLOBALS['strZoneCache']				= "Кэшировать зоны (это должно ускорять работу при использовании зон)";
$GLOBALS['strZoneCacheLimit']			= "Время между обновлениями кэша (в секундах)";
$GLOBALS['strZoneCacheLimitErr']		= "Время между обновлениями кэша должно быть положительным целым числом";

$GLOBALS['strP3PSettings']				= "Настройки P3P (политика обращения с частной информацией) ";
$GLOBALS['strUseP3P']					= "Использовать P3P-политики";
$GLOBALS['strP3PCompactPolicy']			= "Компакнтая политика P3P";
$GLOBALS['strP3PPolicyLocation']		= "Место размещения P3P-политики";



// Banner Settings
$GLOBALS['strBannerSettings']			= "Настройки баннеров";

$GLOBALS['strTypeHtmlSettings']			= "Опции HTML-баннеров";
$GLOBALS['strTypeHtmlAuto']				= "Автоматически изменять HTML-баннеры для регистрации кликов";
$GLOBALS['strTypeHtmlPhp']				= "Разрешить выполнение PHP-выражений из HTML-баннера";

$GLOBALS['strTypeWebSettings']			= "Конфигурация веб-баннеров";
$GLOBALS['strTypeWebMode']				= "Метод хранения";
$GLOBALS['strTypeWebModeLocal']			= "Локальный режим (хранятся в локальном каталоге)";
$GLOBALS['strTypeWebModeFtp']			= "FTP-режим (хранятся на внешнем FTP-сервере)";
$GLOBALS['strTypeWebDir']				= "Каталог для локального режима хранения веб-баннеров";
$GLOBALS['strTypeWebFtp']				= "Сервер для FTP-режима хранения веб-баннеров";
$GLOBALS['strTypeWebUrl']				= "Публично доступный URL локального каталога или FTP-сервера";

$GLOBALS['strDefaultBanners']			= "Баннеры по умолчанию";
$GLOBALS['strDefaultBannerUrl']			= "URL баннера по умолчанию";
$GLOBALS['strDefaultBannerTarget']		= "Назначение баннера по умолчанию";



// Statistics Settings
$GLOBALS['strStatisticsSettings']		= "Настройки статистики";

$GLOBALS['strStatisticsFormat']			= "Формат статистики";
$GLOBALS['strLogBeacon']				= "Использовать маячки для регистрации просмотров";
$GLOBALS['strCompactStats']				= "Использовать компактную статистику";
$GLOBALS['strLogAdviews']				= "Регистрировать просмотры";
$GLOBALS['strLogAdclicks']				= "Регистрировать клики";

$GLOBALS['strGeotrackingType']                  = "Тип базы данных для геотаргетинга";
$GLOBALS['strGeotrackingLocation']              = "Расположение базы данных для геотаргетинга";
$GLOBALS['strGeotargeting']                     = "Геотаргетинг";
$GLOBALS['strGeoLogStats']                      = "Регистрировать страну посетителя в статистике";
$GLOBALS['strGeoStoreCookie']           = "Сохранять результат в куке для использования впоследствии";


$GLOBALS['strEmailWarnings']			= "Предупреждения по емэйлу";
$GLOBALS['strAdminEmailHeaders']		= "Почтовые заголовки для обозначения автора ежедневных отчётов о рекламе";
$GLOBALS['strWarnLimit']				= "Предупреждение о лимите";
$GLOBALS['strWarnLimitErr']				= "Предупреждение о лимите должно быть положительным целым числом";
$GLOBALS['strWarnAdmin']				= "Предупреждать администратора";
$GLOBALS['strWarnClient']				= "Предупреждать клиента";

$GLOBALS['strRemoteHosts']				= "Удалённые хосты";
$GLOBALS['strIgnoreHosts']				= "Игнорировать хосты";
$GLOBALS['strReverseLookup']			= "Проверка обратного DNS";
$GLOBALS['strProxyLookup']				= "Проверка прокси";



// Administrator settings
$GLOBALS['strAdministratorSettings']	= "Настройки администратора";

$GLOBALS['strLoginCredentials']			= "Данные для входа в систему";
$GLOBALS['strAdminUsername']			= "Имя пользователя-администратора";
$GLOBALS['strOldPassword']				= "Старый пароль";
$GLOBALS['strNewPassword']				= "Новый пароль";
$GLOBALS['strInvalidUsername']			= "Неверное имя пользователя";
$GLOBALS['strInvalidPassword']			= "Неверный пароль";

$GLOBALS['strBasicInformation']			= "Основная информация";
$GLOBALS['strAdminFullName']			= "Полное имя администратора";
$GLOBALS['strAdminEmail']				= "Адрес электронной почты администратора";
$GLOBALS['strCompanyName']				= "Название компании";

$GLOBALS['strAdminNovice']				= "Действия администратора по удалению требуют подтверждения для подстраховки";



// User interface settings
$GLOBALS['strGuiSettings']				= "Настройка интерфейса пользователя";

$GLOBALS['strGeneralSettings']			= "Общие настройки";
$GLOBALS['strAppName']					= "Имя приложения";
$GLOBALS['strMyHeader']					= "Мой заголовок";
$GLOBALS['strMyFooter']					= "Мой подвал";

$GLOBALS['strClientInterface']			= "Клиентский интерфейс";
$GLOBALS['strClientWelcomeEnabled']		= "Включить приветственное сообщение для клиентов";
$GLOBALS['strClientWelcomeText']		= "Текст приветственного сообщения для клиентов<br>(разрешены тэги HTML)";



// Interface defaults
$GLOBALS['strInterfaceDefaults']		= "Настройки интерфейса по умолчанию";

$GLOBALS['strStatisticsDefaults'] 		= "Статистика";
$GLOBALS['strBeginOfWeek']				= "Начало недели";
$GLOBALS['strPercentageDecimals']		= "Десятичные дроби";

$GLOBALS['strWeightDefaults']			= "Вес по умолчанию";
$GLOBALS['strDefaultBannerWeight']		= "Вес баннера по умолчанию";
$GLOBALS['strDefaultCampaignWeight']	= "Вес кампании по умолчанию";
$GLOBALS['strDefaultBannerWErr']		= "Вес баннера по умолчанию должен быть положительным целым числом";
$GLOBALS['strDefaultCampaignWErr']		= "Вес кампании по умолчанию должен быть положительным целым числом";

$GLOBALS['strAllowedBannerTypes']		= "Разрешённые типы баннеров";
$GLOBALS['strTypeSqlAllow']				= "Разрешить баннеры, хранящиеся в SQL";
$GLOBALS['strTypeWebAllow']				= "Разрешить баннеры, хранящиеся на вебсервере";
$GLOBALS['strTypeUrlAllow']				= "Разрешить URL-баннеры";
$GLOBALS['strTypeHtmlAllow']			= "Разрешить HTML-баннеры";



// Not used at the moment
$GLOBALS['strTableBorderColor']			= "Цвет рамки таблицы";
$GLOBALS['strTableBackColor']			= "Цвет фона таблицы";
$GLOBALS['strTableBackColorAlt']		= "Альтернативный цвет фона таблицы";
$GLOBALS['strMainBackColor']			= "Основной цвет фона";
$GLOBALS['strOverrideGD']				= "Игнорировать автопределение формата картинок в GD";
$GLOBALS['strTimeZone']					= "Временная зона";

?>
