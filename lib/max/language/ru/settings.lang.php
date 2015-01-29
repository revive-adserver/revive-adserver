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

// Installer translation strings
$GLOBALS['strInstall']					= "Установка";
$GLOBALS['strChooseInstallLanguage']	= "Выберите язык для процедуры установки";
$GLOBALS['strLanguageSelection']		= "Выбор Языка";
$GLOBALS['strDatabaseSettings']			= "Настройки базы данных";
$GLOBALS['strAdminSettings']			= "Настройки администратора";
$GLOBALS['strAdvancedSettings']			= "Расширенные Настройки";
$GLOBALS['strOtherSettings']			= "Другие Настройки";

$GLOBALS['strWarning']					= "Предупреждение";
$GLOBALS['strFatalError']				= "Произошла фатальная ошибка";
$GLOBALS['strAlreadyInstalled']			= "{$PRODUCT_NAME} уже установлен. Для его настройки перейдите в <a href='account-index.php'>раздел настроек</a>.";
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
$GLOBALS['strTablesPrefix']				= "Префикс к именам таблиц";
$GLOBALS['strTablesType']				= "Тип таблиц";

$GLOBALS['strInstallWelcome']			= "Добро пожаловать в {$PRODUCT_NAME} ";
$GLOBALS['strInstallMessage']			= "Прежде чем вы сможете начать использовать phpAdsNew, необходимо произвести конфигурацию и <br>создать базу данных. Щёлкните <b>Дальше</b> для продолжения.";
$GLOBALS['strInstallSuccess']			= "<b>Установка {$PRODUCT_NAME} завершена.</b><br><br>Для корректного функционирования {$PRODUCT_NAME} вы также должны убедиться, что утилита обслуживания запускается каждый день. Дополнительная информация по этому поводу может быть найдена в документации.
<br><br>Щёлкните <b>Дальше</b> для перехода на страницу конфигурации, где вы можете изменить дополнительные настройки. Пожалуйста, не забудьте заблокировать файл config.inc.php, когда вы закончите с настройками - это предотвратит возможный взлом системы.";
$GLOBALS['strInstallNotSuccessful']		= "<b>Инсталляция {$PRODUCT_NAME}  закончилась неудачно.</b><br /><br />Процесс инсталляции не завершен. Возможно, это были временные проблемы, в таком случае нажмите кнопку <b>Продолжить</b> и вернитесь к началу инсталляции. Если вы хотите узнать больше о том, что означают сообщения об ошибке, указанные ниже - обратитесь к документации";
$GLOBALS['strErrorOccured']				= "Произошла следующая ошибка:";
$GLOBALS['strErrorInstallDatabase']		= "Структура базы данных не могла быть создана.";
$GLOBALS['strErrorInstallConfig']		= "Файл конфигурации или база данных не могут быть обновлены.";
$GLOBALS['strErrorInstallDbConnect']	= "Не получилось открыть соединение с базой данных.";

$GLOBALS['strUrlPrefix']				= "Префикс URL";

$GLOBALS['strProceed']					= "Дальше >";
$GLOBALS['strRepeatPassword']			= "Повторите пароль";
$GLOBALS['strNotSamePasswords']			= "Введенные Вами пароли не совпадают";
$GLOBALS['strInvalidUserPwd']			= "Неверное имя пользователя или пароль";

$GLOBALS['strUpgrade']					= "Обновить";
$GLOBALS['strSystemUpToDate']			= "Ваша система не требует обновления. <br>Щёлкните по <b>Дальше</b> для перехода на домашнюю страницу.";
$GLOBALS['strSystemNeedsUpgrade']		= "Сруктура базы данных и файл конфигурации должны быть обновлены для корректного функционирования системы. Щёлкните <b>Дальше</b>, чтобы запустить процесс обновления. <br>Будьте терпеливы? обновление может занять пару минут.";
$GLOBALS['strSystemUpgradeBusy']		= "Происходит обновление системы? пожалуйста? подождите...";
$GLOBALS['strServiceUnavalable']		= "Обслуживание временно недоступно. Происходит обновление системы";

$GLOBALS['strConfigNotWritable']		= "Ваш файл config.inc.php не имеет прав на запись в него";





/*-------------------------------------------------------*/
/* Configuration translations                            */
/*-------------------------------------------------------*/

// Global
$GLOBALS['strChooseSection']			= "Выберите раздел";
$GLOBALS['strDayFullNames'][0] = "Воскресенье";
$GLOBALS['strDayFullNames'][1] = "Понедельник";
$GLOBALS['strDayFullNames'][2] = "Вторник";
$GLOBALS['strDayFullNames'][3] = "Среда";
$GLOBALS['strDayFullNames'][4] = "Четверг";
$GLOBALS['strDayFullNames'][5] = "Пятница";
$GLOBALS['strDayFullNames'][6] = "Суббота";

$GLOBALS['strEditConfigNotPossible']    = "Отредактировать данные настройки невозможно, так как файл конфигурации заперт из соображений безопасности. Если вы хотите произвести изменения, вам нужно сначала отпереть файл сonfig.inc.php.";
$GLOBALS['strEditConfigPossible']		= "Можно редактировать все настройки, так как файл конфигурации не заперт, но это может привести к проблемам с безопасностью системы. Если вы хотите обезопасить вашу систему, вам необходимо запереть файл config.inc.php.";



// Database
$GLOBALS['strDatabaseSettings']			= "Настройки базы данных";
$GLOBALS['strDatabaseServer']			= "Сервер баз данных";
$GLOBALS['strDbHost']					= "Имя хоста";
$GLOBALS['strDbUser']					= "Имя пользователя";
$GLOBALS['strDbPassword']				= "Пароль";
$GLOBALS['strDbName']					= "Имя базы данных";

$GLOBALS['strDatabaseOptimalisations']	= "Настройки оптимизации работы с БД";
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
$GLOBALS['strCacheFiles']                               = "Файл";
$GLOBALS['strCacheDatabase']                    = "База данных";
$GLOBALS['strCacheShmop']                               = "Разделяемая память (shmop)";

$GLOBALS['strZonesSettings']			= "Извлечение зон";
$GLOBALS['strZoneCache']				= "Кэшировать зоны (это должно ускорять работу при использовании зон)";
$GLOBALS['strZoneCacheLimit']			= "Время между обновлениями кэша (в секундах)";
$GLOBALS['strZoneCacheLimitErr']		= "Время между обновлениями кэша должно быть положительным целым числом";

$GLOBALS['strP3PSettings']				= "Настройки P3P (политика обращения с частной информацией) ";
$GLOBALS['strUseP3P']					= "Использовать P3P-политики";
$GLOBALS['strP3PCompactPolicy']			= "Компактная политика P3P";
$GLOBALS['strP3PPolicyLocation']		= "Место размещения P3P-политики";



// Banner Settings
$GLOBALS['strBannerSettings']			= "Настройки баннеров";

$GLOBALS['strTypeHtmlSettings']			= "Опции HTML-баннеров";
$GLOBALS['strTypeHtmlAuto']				= "Автоматически изменять код HTML-баннеров для регистрации кликов";
$GLOBALS['strTypeHtmlPhp']				= "Разрешить исполнение PHP-кода в HTML баннерах";

$GLOBALS['strTypeWebSettings']			= "Конфигурация веб-баннеров";
$GLOBALS['strTypeWebMode']				= "Метод хранения";
$GLOBALS['strTypeWebModeLocal']			= "Локальный режим (хранятся в локальном каталоге)";
$GLOBALS['strTypeWebModeFtp']			= "FTP-режим (хранятся на внешнем FTP-сервере)";
$GLOBALS['strTypeWebDir']				= "Локальный режим (хранятся в локальном каталоге)";
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
$GLOBALS['strGeotargeting']                     = "Настройки гео-таргетинга";
$GLOBALS['strGeoLogStats']                      = "Регистрировать страну посетителя в статистике";
$GLOBALS['strGeoStoreCookie']           = "Сохранять результат в куке для использования впоследствии";


$GLOBALS['strEmailWarnings']			= "Предупреждения по е-мэйлу";
$GLOBALS['strAdminEmailHeaders']		= "Добавлять в каждое письмо заголовок message sent by {$PRODUCT_NAME}";
$GLOBALS['strWarnLimit']				= "Предупреждение о лимите";
$GLOBALS['strWarnLimitErr']				= "Предупреждение о лимите должно быть положительным целым числом";
$GLOBALS['strWarnAdmin']				= "Отправлять сообщение администратору всякий раз когда кампания близка к завершению";
$GLOBALS['strWarnClient']				= "Отправлять сообщение клиенту всякий раз когда кампания близка к завершению";

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
$GLOBALS['strInvalidPassword']			= "Новый пароль неверен, пожалуйста, используйте другой пароль.";

$GLOBALS['strBasicInformation']			= "Основная информация";
$GLOBALS['strAdminFullName']			= "Полное имя администратора";
$GLOBALS['strAdminEmail']				= "Адрес электронной почты администратора";
$GLOBALS['strCompanyName']				= "Название компании";

$GLOBALS['strAdminNovice']				= "Действия по удалению требуют подтверждения";



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
$GLOBALS['strTypeSqlAllow']				= "Разрешить баннеры, хранящиеся в БД";
$GLOBALS['strTypeWebAllow']				= "Разрешить баннеры, хранящиеся на веб-сервере";
$GLOBALS['strTypeUrlAllow']				= "Разрешить внешние баннеры";
$GLOBALS['strTypeHtmlAllow']			= "Разрешить HTML-баннеры";



// Not used at the moment
$GLOBALS['strTableBorderColor']			= "Цвет рамки таблицы";
$GLOBALS['strTableBackColor']			= "Цвет фона таблицы";
$GLOBALS['strTableBackColorAlt']		= "Альтернативный цвет фона таблицы";
$GLOBALS['strMainBackColor']			= "Основной цвет фона";
$GLOBALS['strOverrideGD']				= "Игнорировать автопределение формата картинок в GD";
$GLOBALS['strTimeZone']					= "Временная зона";



// Note: new translatiosn not found in original lang files but found in CSV
$GLOBALS['strAdminAccount'] = "Учетная запись администратора";
$GLOBALS['strSpecifySyncSettings'] = "Настройки синхронизации";
$GLOBALS['strBtnContinue'] = "Продолжить »";
$GLOBALS['strBtnRecover'] = "Исправить »";
$GLOBALS['strBtnStartAgain'] = "Запустить обновление снова »";
$GLOBALS['strBtnGoBack'] = "« Вернуться назад";
$GLOBALS['strBtnAgree'] = "Я согласен »";
$GLOBALS['strBtnDontAgree'] = "« Я не согласен";
$GLOBALS['strBtnRetry'] = "Повторить";
$GLOBALS['strFixErrorsBeforeContinuing'] = "Пожалуйста, исправьте все ошибки прежде чем продолжить";
$GLOBALS['strWarningRegisterArgcArv'] = "Переменная конфигурации PHP register_argc_argv должна иметь значение on для запуска утилиты обслуживания БД из командной строки";
$GLOBALS['strInstallIntro'] = "Спасибо, что выбрали a href='http://{$PRODUCT_URL}' target='_blank'><strong>{$PRODUCT_NAME}</strong></a><p>Этот мастер поможет вам установить или обновить существующий сервер {$PRODUCT_NAME}.</p><p>Чтобы помочь вам разобраться в процессе инсталляции,  мы создали <a href='{$PRODUCT_DOCSURL}/wizard/qsg-install' target='_blank'>Руководство по быстрому старту</a>. Для более детальной информации об установке и конфигурировании {$PRODUCT_NAME} обратитесь к <a href='{$PRODUCT_DOCSURL}/wizard/admin-guide' target='_blank'>Руководству администратора</a>.";
$GLOBALS['strRecoveryRequiredTitle'] = "Во время предыдущей попытки обновления произошла ошибка";
$GLOBALS['strRecoveryRequired'] = "Во время предыдущей попытки обновления произошла ошибка. Нажмите на кнопку \"Исправить\" для исправления.";
$GLOBALS['strTermsTitle'] = "Условия использования и политика обращения с частной информацией";
$GLOBALS['strPolicyTitle'] = "Политика обращения с личными данными";
$GLOBALS['strPolicyIntro'] = "Прочтите и согласитесь с данным документом для продолжения исталляции";
$GLOBALS['strDbSetupTitle'] = "Настройки базы данных";
$GLOBALS['strDbUpgradeIntro'] = "Ниже указаны данные для подключения к БД текущей инсталляции {$PRODUCT_NAME}. проверьте их, пожалуйста. Когда вы нажмете кнопку \"продолжить\"";
$GLOBALS['strOaUpToDate'] = "Файловая структура и схема данных вашей инсталляции не нуждаются в обновлении. Нажмите \"продолжить\" для перехода в административную панель.";
$GLOBALS['strOaUpToDateCantRemove'] = "предупреждение: файл UPGRADE по прежнему находится в папке var. Программа установки не в состоянии удалить его из-за недостатка прав доступа. Пожалуйста, удалите его самостоятельно.";
$GLOBALS['strRemoveUpgradeFile'] = "Вам необходимо удалить файл UPGRADE из папки var";
$GLOBALS['strSystemCheck'] = "Проверка системы";
$GLOBALS['strDbSuccessIntro'] = "Была создана БД для {$PRODUCT_NAME}. Нажмите кнопку \"Продолжить\" для конфигурирования настроек администрирования и доставки баннеров.";
$GLOBALS['strDbSuccessIntroUpgrade'] = "Ваша система была обновлена. Оставшиеся шаги помогут вам обновить конфигурационные файлы вашего сервера.";
$GLOBALS['strErrorWritePermissions'] = "Прежде, чем вы сможете продолжить, необходимо исправить ошибки прав доступа к файлам.<br />Чтобы исправить ошибки в ОС Linux попробуйте выполнить следующие команды:";
$GLOBALS['strErrorFixPermissionsCommand'] = "<i>chmod a+w %s</i>";
$GLOBALS['strErrorFixPermissionsRCommand']  = "<i>chmod -R a+w %s</i>";
$GLOBALS['strErrorWritePermissionsWin'] = "Прежде, чем вы сможете продолжить, необходимо исправить ошибки прав доступа к файлам.";
$GLOBALS['strCheckDocumentation'] = "Для вызова справки, откройте <a href='{$PRODUCT_DOCSURL}'>Документацию {$PRODUCT_NAME}</a>.";
$GLOBALS['strAdminUrlPrefix'] = "URL административного интерфейса";
$GLOBALS['strDeliveryUrlPrefix'] = "URL движка доставки баннеров";
$GLOBALS['strDeliveryUrlPrefixSSL'] = "URL движка доставки баннеров (SSL)";
$GLOBALS['strImagesUrlPrefix'] = "URL хранилища изображений";
$GLOBALS['strImagesUrlPrefixSSL'] = "URL хранилища изображений (SSL)";
$GLOBALS['strUnableToWriteConfig'] = "Невозможно сохранить изменения в файл конфигурации";
$GLOBALS['strUnableToWritePrefs'] = "Невозможно сохранить настройки в БД";
$GLOBALS['strImageDirLockedDetected'] = "Указанная<b>папка для изображений</b>недоступна для записи. <br>Необходимо изменить настройки доступа, или создать папку.";
$GLOBALS['strConfigurationSetup'] = "Настройка конфигурации";
$GLOBALS['strConfigurationSettings'] = "Настройки конфигурации";
$GLOBALS['strAdminPassword'] = "Пароль пользователя-администратора";
$GLOBALS['strAdministratorEmail'] = "Адрес электронной почты администратора";
$GLOBALS['strAdminCheckUpdates'] = "Проверить обновления";
$GLOBALS['strUserlogEmail'] = "Протоколировать все исходящие сообщения электронной почты";
$GLOBALS['strTimezoneInformation'] = "Информация о часовом поясе (изменения скажутся на статистике)";
$GLOBALS['strTimezone'] = "Часовой пояс";
$GLOBALS['strTimezoneEstimated'] = "Выбранный часовой пояс";
$GLOBALS['strTimezoneGuessedValue'] = "Часовой пояс сервера в PHP настроен некорректно";
$GLOBALS['strTimezoneSeeDocs'] = "Подробнее об установке переменных в PHP читайте в %DOCS%";
$GLOBALS['strTimezoneDocumentation'] = "документация";
$GLOBALS['strLoginSettingsTitle'] = "Логин администратора";
$GLOBALS['strLoginSettingsIntro'] = "Для продолжения процесса обновления введите административные логин и пароль";
$GLOBALS['strAdminSettingsTitle'] = "Создать аккаунт администратора";
$GLOBALS['strAdminSettingsIntro'] = "Заполните форму для создания административного аккаунта.";
$GLOBALS['strEnableAutoMaintenance'] = "Автоматически проводить обслуживание БД во время доставки баннеров, если обслуживание не настроено вручную";
$GLOBALS['strDefaultBannerDestination'] = "Ссылка по умолчанию";
$GLOBALS['strTypeTxtAllow'] = "Разрешить текстовые баннеры";
$GLOBALS['strDbType'] = "Тип БД";
$GLOBALS['strDbPort'] = "Порт БД";
$GLOBALS['strDemoDataInstall'] = "Инсталлировать демо-данные";
$GLOBALS['strDemoDataIntro'] = "В БД {$PRODUCT_NAME} могут быть проинсталлированы демо-данные, для того, чтобы помочь вам освоится с программой. Будут загружены и настроены основные типы баннеров, а также несколько демо-кампаний. Мы очень рекомендуем использовать демо-данные для новых инсталляций.";
$GLOBALS['strDebugSettings'] = "Отладочный журнал";
$GLOBALS['strDebug'] = "Глобальные настройки отладочного журнала";
$GLOBALS['strProduction'] = "Рабочий сервер";
$GLOBALS['strEnableDebug'] = "Разрешить вести отладочный журнал";
$GLOBALS['strDebugMethodNames'] = "Включать имена методов в отладочный журнал";
$GLOBALS['strDebugLineNumbers'] = "Включать номера строк в отладочный журнал";
$GLOBALS['strDebugType'] = "Тип отладочного журнала";
$GLOBALS['strDebugTypeFile'] = "Файл";
$GLOBALS['strDebugTypeMcal'] = "mCal";
$GLOBALS['strDebugTypeSql'] = "БД";
$GLOBALS['strDebugTypeSyslog'] = "Syslog";
$GLOBALS['strDebugName'] = "Имя файла Журнала отладки, таблица БД или метка Syslog";
$GLOBALS['strDebugPriority'] = "Уровень приоритета отладки";
$GLOBALS['strPEAR_LOG_DEBUG'] = "PEAR_LOG_DEBUG - Основная информация";
$GLOBALS['strPEAR_LOG_INFO'] = "PEAR_LOG_INFO - Информация по умолчанию";
$GLOBALS['strPEAR_LOG_NOTICE'] = "PEAR_LOG_NOTICE";
$GLOBALS['strPEAR_LOG_WARNING'] = "PEAR_LOG_WARNING";
$GLOBALS['strPEAR_LOG_ERR'] = "PEAR_LOG_ERR";
$GLOBALS['strPEAR_LOG_CRIT'] = "PEAR_LOG_CRIT";
$GLOBALS['strPEAR_LOG_ALERT'] = "PEAR_LOG_ALERT";
$GLOBALS['strPEAR_LOG_EMERG'] = "PEAR_LOG_EMERG - Полная информация";
$GLOBALS['strDebugIdent'] = "Строка идентификации отладки";
$GLOBALS['strDebugUsername'] = "Имя пользователя для mCal или SQL сервера";
$GLOBALS['strDebugPassword'] = "Пароль для mCal или SQL сервера";
$GLOBALS['strWebPath'] = "Глобальные пути доступа сервера {$PRODUCT_NAME}";
$GLOBALS['strWebPathSimple'] = "Расположение веб-страниц";
$GLOBALS['strDeliveryPath'] = "Расположение папки доставки";
$GLOBALS['strImagePath'] = "Расположение папки изображений";
$GLOBALS['strDeliverySslPath'] = "Расположение папки доставки (SSL)";
$GLOBALS['strImageSslPath'] = "Расположение папки изображений (SSL)";
$GLOBALS['strImageStore'] = "Папка изображений";
$GLOBALS['strTypeFTPHost'] = "Имя FTP сервера";
$GLOBALS['strTypeFTPDirectory'] = "Папка";
$GLOBALS['strTypeFTPUsername'] = "Имя пользователя";
$GLOBALS['strTypeFTPPassword'] = "Пароль";
$GLOBALS['strTypeFTPPassive'] = "Использовать пассивный режим";
$GLOBALS['strTypeFTPErrorDir'] = "Указанная папка недоступна";
$GLOBALS['strTypeFTPErrorConnect'] = "Невозможно соединиться с сервером, неправильные имя пользователя или пароль";
$GLOBALS['strTypeFTPErrorHost'] = "Неправильное имя сервера";
$GLOBALS['strDeliveryFilenames'] = "Имена файлов глобальной доставки";
$GLOBALS['strDeliveryFilenamesAdClick'] = "Клик по баннеру";
$GLOBALS['strDeliveryFilenamesAdConversionVars'] = "Переменные действия";
$GLOBALS['strDeliveryFilenamesAdContent'] = "Содержание баннера";
$GLOBALS['strDeliveryFilenamesAdConversion'] = "Действие баннера";
$GLOBALS['strDeliveryFilenamesAdConversionJS'] = "Действие баннера (JavaScript)";
$GLOBALS['strDeliveryFilenamesAdFrame'] = "Фрейм баннера";
$GLOBALS['strDeliveryFilenamesAdImage'] = "Изображение баннера";
$GLOBALS['strDeliveryFilenamesAdJS'] = "Баннер (JavaScript)";
$GLOBALS['strDeliveryFilenamesAdLayer'] = "Слой баннера";
$GLOBALS['strDeliveryFilenamesAdLog'] = "Журнал баннера";
$GLOBALS['strDeliveryFilenamesAdPopup'] = "Pop-Up баннера";
$GLOBALS['strDeliveryFilenamesAdView'] = "Просмотр баннера";
$GLOBALS['strDeliveryFilenamesXMLRPC'] = "Вызов XML-RPC";
$GLOBALS['strDeliveryFilenamesLocal'] = "Локальный вызов";
$GLOBALS['strDeliveryFilenamesFrontController'] = "Фронт контроллер";
$GLOBALS['strDeliveryFilenamesFlash'] = "Flash-включение (может быть полным URL)";
$GLOBALS['strDeliveryCaching'] = "Настройки кэширования доставки";
$GLOBALS['strDeliveryCacheLimit'] = "Время между обновлениями кэша (сек.)";
$GLOBALS['strOrigin'] = "Использовать удаленный сервер";
$GLOBALS['strOriginType'] = "Тип удаленного сервера";
$GLOBALS['strOriginHost'] = "Имя удаленного сервера";
$GLOBALS['strOriginPort'] = "Номер порта БД";
$GLOBALS['strOriginScript'] = "Файл скрипта БД";
$GLOBALS['strOriginTypeXMLRPC'] = "XML-RPC";
$GLOBALS['strOriginTimeout'] = "Таймаут (сек.)";
$GLOBALS['strOriginProtocol'] = "Протокол";
$GLOBALS['strDeliveryBanner'] = "Настройки доставки баннеров";
$GLOBALS['strDeliveryAcls'] = "Проверять ограничения в процессе доставки";
$GLOBALS['strDeliveryObfuscate'] = "Скрывать каналы при показе баннеров";
$GLOBALS['strDeliveryExecPhp'] = "Разрешить исполнение кода PHP (Предупреждение: эта опция небезопасна)";
$GLOBALS['strDeliveryCtDelimiter'] = "Разделитель для сторонних трекеров";
$GLOBALS['strGeotargetingSettings'] = "Настройки гео-таргетинга";
$GLOBALS['strGeotargetingType'] = "Тип модуля гео-таргетинга";
$GLOBALS['strGeotargetingGeoipRegionLocation'] = "Путь к БД MaxMind GeoIP Region";
$GLOBALS['strGeotargetingGeoipCityLocation'] = "Путь к БД  MaxMind GeoIP City";
$GLOBALS['strGeotargetingGeoipAreaLocation'] = "Путь к БД MaxMind GeoIP Area";
$GLOBALS['strGeotargetingGeoipDmaLocation'] = "Путь к БД MaxMind GeoIP DMA";
$GLOBALS['strGeotargetingGeoipOrgLocation'] = "Путь к БД MaxMind GeoIP Organisation";
$GLOBALS['strGeotargetingGeoipIspLocation'] = "Путь к БД MaxMind GeoIP ISP";
$GLOBALS['strGeotargetingGeoipNetspeedLocation'] = "Путь к БД MaxMind GeoIP Netspeed";
$GLOBALS['strGeoShowUnavailable'] = "Показать настройки гео-таргетинга даже есть БД GeoIP недоступна";
$GLOBALS['strGeotrackingGeoipCountryLocationError'] = "БД MaxMind GeoIP Country недоступна по указанному адресу";
$GLOBALS['strGeotrackingGeoipRegionLocationError'] = "БД MaxMind GeoIP Region недоступна по указанному адресу";
$GLOBALS['strGeotrackingGeoipCityLocationError'] = "БД MaxMind GeoIP City недоступна по указанному адресу";
$GLOBALS['strGeotrackingGeoipAreaLocationError'] = "БД MaxMind GeoIP Area недоступна по указанному адресу";
$GLOBALS['strGeotrackingGeoipDmaLocationError'] = "БД MaxMind GeoIP DMA недоступна по указанному адресу";
$GLOBALS['strGeotrackingGeoipOrgLocationError'] = "БД MaxMind GeoIP Database недоступна по указанному адресу";
$GLOBALS['strGeotrackingGeoipIspLocationError'] = "БД MaxMind GeoIP ISP недоступна по указанному адресу";
$GLOBALS['strGeotrackingGeoipNetspeedLocationError'] = "БД MaxMind GeoIP Netspeed недоступна по указанному адресу";
$GLOBALS['strInventory'] = "Администрирование";
$GLOBALS['strShowCampaignInfo'] = "Показывать дополнительную информацию на странице <i>обзора кампании</i>";
$GLOBALS['strShowBannerInfo'] = "Показывать дополнительную информацию на странице <i>обзора баннеров</i>";
$GLOBALS['strShowCampaignPreview'] = "Показывать превью баннеров на странице <i>обзора баннеров</i>";
$GLOBALS['strShowBannerHTML'] = "Показывать баннер вместо HTML-кода на странице обзора HTML баннеров";
$GLOBALS['strShowBannerPreview'] = "Показывать превью баннера вверху страниц управления баннерами";
$GLOBALS['strHideInactive'] = "Скрыть неактивные";
$GLOBALS['strGUIShowMatchingBanners'] = "Показывать баннеры на странице <i>Связанные баннеры</i>";
$GLOBALS['strGUIShowParentCampaigns'] = "Показывать кампании на странице <i>Связанные баннеры</i>";
$GLOBALS['strGUIAnonymousCampaignsByDefault'] = "По умолчанию кампании анонимны";
$GLOBALS['strModesOfPayment'] = "Способ платежа";
$GLOBALS['strCurrencies'] = "Валюты";
$GLOBALS['strCategories'] = "Категории";
$GLOBALS['strHelpFiles'] = "Файлы помощи";
$GLOBALS['strHasTaxID'] = "Тип налога";
$GLOBALS['strDefaultApproved'] = "Одобрено";
$GLOBALS['strAllowedInvocationTypes'] = "Разрешенные типы вызова";
$GLOBALS['strInvocationDefaults'] = "Настройки вызова по умолчанию";
$GLOBALS['strEnable3rdPartyTrackingByDefault'] = "Разрешить сторонние трекеры по умолчанию";
$GLOBALS['strStatisticsLogging'] = "Настройки глобальной статистики и журналирования";
$GLOBALS['strCsvImport'] = "разрешить загрузку оффлайн-действий";
$GLOBALS['strLogAdRequests'] = "Регистрировать запрос каждый раз когда запрошен баннер";
$GLOBALS['strLogAdImpressions'] = "Регистрировать просмотр каждый раз когда просмотрен баннер";
$GLOBALS['strLogAdClicks'] = "Регистрировать клик каждый раз, когда пользователь кликает на баннере";
$GLOBALS['strLogTrackerImpressions'] = "Регистрировать действие каждый раз когда пользователь загружает код действия";
$GLOBALS['strPreventLogging'] = "Глобальные настройки не-фиксируемых действий";
$GLOBALS['strBlockAdViews'] = "Не засчитывать показ, если пользователь видит ту же пару баннер/зона в течение указанного времени (сек.)";
$GLOBALS['strBlockAdViewsError'] = "Блок показа баннера должен быть положительным целым числом";
$GLOBALS['strBlockAdClicks'] = "Не засчитывать клик, если пользователь кликает ту же пару баннер/зона в течение указанного времени (сек.)";
$GLOBALS['strBlockAdClicksError'] = "Блок клика баннера должен быть положительным целым числом";
$GLOBALS['strMaintenaceSettings'] = "Глобальные настройки обслуживания";
$GLOBALS['strMaintenanceOI'] = "Интервал между операциями обслуживания (минут)";
$GLOBALS['strMaintenanceOIError'] = "Введенный вами интервал некорректен - см. документацию";
$GLOBALS['strMaintenanceCompactStats'] = "Удалять необработанные данные после обработки";
$GLOBALS['strMaintenanceCompactStatsGrace'] = "Период между удалением обработанной статистики (сек.)";
$GLOBALS['strPrioritySettings'] = "Глобальные настройки приоритетов";
$GLOBALS['strPriorityInstantUpdate'] = "Обновлять приоритеты немедленно при внесении изменений";
$GLOBALS['strWarnCompactStatsGrace'] = "Период компактной статистики должен быть положительным целым числом";
$GLOBALS['strDefaultImpConWindow'] = "Окно показа в секундах по умолчанию";
$GLOBALS['strDefaultImpConWindowError'] = "Окно показа должно быть положительным целым числом";
$GLOBALS['strDefaultCliConWindow'] = "Окно клика в секундах по умолчанию";
$GLOBALS['strDefaultCliConWindowError'] = "Окно клика должно быть положительным целым числом";
$GLOBALS['strWarnLimitDays'] = "Отправлять сообщение если осталось дней меньше чем";
$GLOBALS['strWarnLimitDaysErr'] = "Число дней должно быть положительным целым числом";
$GLOBALS['strWarnAgency'] = "Отправлять сообщение агентству всякий раз когда кампания близка к завершению";
$GLOBALS['strQmailPatch'] = "патч для qmail";
$GLOBALS['strMyHeaderError'] = "Указанный файл заголовка недоступен";
$GLOBALS['strMyFooterError'] = "Указанный файл подвала недоступен";
$GLOBALS['strDefaultTrackerStatus'] = "Статус по умолчанию";
$GLOBALS['strDefaultTrackerType'] = "Тип по умолчанию";
$GLOBALS['strMyLogo'] = "Имя файла логотипа";
$GLOBALS['strMyLogoError'] = "Файл с указанным именем должен лежать в папке admin/images";
$GLOBALS['strGuiHeaderForegroundColor'] = "Цвет букв заголовка";
$GLOBALS['strGuiHeaderBackgroundColor'] = "Цвет фона заголовка";
$GLOBALS['strGuiActiveTabColor'] = "Цвет активной закладки";
$GLOBALS['strGuiHeaderTextColor'] = "Цвет текста в заголовке";
$GLOBALS['strColorError'] = "Укажите цвет в формате RGB, например '0066CC'";
$GLOBALS['strGzipContentCompression'] = "Использовать Gzip сжатие";
$GLOBALS['strReportsInterface'] = "Интерфейс отчетов";
$GLOBALS['strPublisherAgreementText'] = "Текст страницы входа";
$GLOBALS['requireSSL'] = "Принудительно использовать SSL в GUI";
$GLOBALS['sslPort'] = "SSL порт сервера";
$GLOBALS['strEmailAddress'] = "Адрес e-mail";
$GLOBALS['strAllowEmail'] = "Разрешить отправку сообщений по e-mail";
$GLOBALS['strEmailAddressName'] = "Имя для поля ОТ:";


// Note: New translations not found in original lang files but found in CSV
$GLOBALS['strTermsIntro'] = "{$PRODUCT_NAME} распространяется под открытой лицензией GNU General Public Licence. Пожалуйста, прочтите и согласитесь с нижеследующим документом для продолжения инсталляции.";
$GLOBALS['strDbSetupIntro'] = "Введите данные для соединения с вашей БД. Если вы не знаете что вводить - свяжитесь с вашим системным администратором.<p> нажмите 'продолжить' для продолжения инсталляции.";
$GLOBALS['strSystemCheckIntro'] = "Мастер проверяет настройки веб-сервера, чтобы убедиться, что инсталляция будет проведена успешно. 	<p>Пожалуйста, проверьте подсвеченные замечания, чтобы инсталляция прошла успешно.</p>";
$GLOBALS['strConfigSettingsIntro'] = "Проверьте настройки конфигурации и внесите все необходимые изменения. Если вы не уверены, оставляйте значения по умолчанию.";
$GLOBALS['strTypeDirError'] = "У веб-сервера нет прав на запись в локальную папку.";
$GLOBALS['uiEnabled'] = "Интерфейс пользователя включен";
$GLOBALS['strGeotargetingGeoipCountryLocation'] = "Путь к БД MaxMind GeoIP Country. Оставьте пустым для использования бесплатной версии.";
$GLOBALS['strPublisherDefaults'] = "Свойства вебсайта";
$GLOBALS['strPublisherInterface'] = "Интерфейс сайта";
$GLOBALS['strPublisherAgreementEnabled'] = "Разрешить вход для сайтов, которые не согласились с Условиями использования";
$GLOBALS['strAuditTrailSettings'] = "Настройки аудита изменений";
$GLOBALS['strDbLocal'] = "Использовать соединение с локальным сокетом";
$GLOBALS['strDbSocket'] = "Сокет БД";
$GLOBALS['strEmailAddresses'] = "Email \"От\" адрес";
$GLOBALS['strEmailFromName'] = "Email \"От\" Имя";
$GLOBALS['strEmailFromAddress'] = "Email \"От\" Электронная почта";
$GLOBALS['strEmailFromCompany'] = "Email \"От\" Компания";
$GLOBALS['strIgnoreUserAgents'] = "<b>Не</b> считать статистику для клиентов со следующими строками в user-agent (по одной на строку)";
$GLOBALS['strEnforceUserAgents'] = "<b>Считать только</b> статистику для клиентов со следующими строками в user-agent (по одной на строку)";
$GLOBALS['strConversionTracking'] = "Настройки учета конверсии";
$GLOBALS['strEnableConversionTracking'] = "Разрешить учет конверсии";
$GLOBALS['strDbNameHint'] = "Если БД не существует, она будет создана автоматически";
$GLOBALS['strProductionSystem'] = "Production сервер";
$GLOBALS['strTypeFTPErrorUpload'] = "Невозможно загрузить файл на FTP сервер, проверьте права доступа.";
$GLOBALS['strBannerLogging'] = "Настройки журналирования";
$GLOBALS['strBannerDelivery'] = "Настройки доставки баннеров";
$GLOBALS['strEnableDashboardSyncNotice'] = "Пожалуйста разрешите <a href='account-settings-update.php'>Проверить обновление</a> если вы хотите использовать панель инструментов.";
$GLOBALS['strDashboardSettings'] = "Настройка панели";
$GLOBALS['strGlobalDefaultBannerUrl'] = "Глобальное значение баннера по умолчанию URL";
$GLOBALS['strCantConnectToDbDelivery'] = "Не удается подключиться к базе данных для доставки";
$GLOBALS['strDefaultConversionStatus'] = "Действие по умолчанию";
$GLOBALS['strDefaultConversionType'] = "Действие по умолчанию";
?>