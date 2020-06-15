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
$GLOBALS['strInstall'] = "Установка";
$GLOBALS['strDatabaseSettings'] = "Настройки базы данных";
$GLOBALS['strAdminAccount'] = "Учетная запись администратора";
$GLOBALS['strAdvancedSettings'] = "Расширенные Настройки";
$GLOBALS['strWarning'] = "Попередження";
$GLOBALS['strBtnContinue'] = "Продолжить »";
$GLOBALS['strBtnRecover'] = "Исправить »";
$GLOBALS['strBtnAgree'] = "Я согласен »";
$GLOBALS['strBtnRetry'] = "Повторить";
$GLOBALS['strWarningRegisterArgcArv'] = "Переменная конфигурации PHP register_argc_argv должна иметь значение on для запуска утилиты обслуживания БД из командной строки";
$GLOBALS['strTablesPrefix'] = "Table names prefix";
$GLOBALS['strTablesType'] = "Тип таблиц";

$GLOBALS['strRecoveryRequiredTitle'] = "Во время предыдущей попытки обновления произошла ошибка";
$GLOBALS['strRecoveryRequired'] = "Во время предыдущей попытки обновления произошла ошибка. Нажмите на кнопку \"Исправить\" для исправления.";

$GLOBALS['strProductUpToDateTitle'] = "{$PRODUCT_NAME} is up to date";
$GLOBALS['strOaUpToDate'] = "Файловая структура и схема данных вашей инсталляции не нуждаются в обновлении. Нажмите \"продолжить\" для перехода в административную панель.";
$GLOBALS['strOaUpToDateCantRemove'] = "предупреждение: файл UPGRADE по прежнему находится в папке var. Программа установки не в состоянии удалить его из-за недостатка прав доступа. Пожалуйста, удалите его самостоятельно.";
$GLOBALS['strErrorWritePermissions'] = "Прежде, чем вы сможете продолжить, необходимо исправить ошибки прав доступа к файлам.<br />Чтобы исправить ошибки в ОС Linux попробуйте выполнить следующие команды:";
$GLOBALS['strErrorFixPermissionsRCommand'] = "<i>chmod -R a+w %s</i>";
$GLOBALS['strNotWriteable'] = "NOT writeable";
$GLOBALS['strDirNotWriteableError'] = "Directory must be writeable";

$GLOBALS['strErrorWritePermissionsWin'] = "Прежде, чем вы сможете продолжить, необходимо исправить ошибки прав доступа к файлам.";
$GLOBALS['strCheckDocumentation'] = "Для вызова справки, откройте <a href='{$PRODUCT_DOCSURL}'>Документацию {$PRODUCT_NAME}</a>.";
$GLOBALS['strSystemCheckBadPHPConfig'] = "Your current PHP configuration does not meet requirements of {$PRODUCT_NAME}. To resolve the problems, please modify settings in your 'php.ini' file.";

$GLOBALS['strAdminUrlPrefix'] = "URL административного интерфейса";
$GLOBALS['strDeliveryUrlPrefix'] = "URL движка доставки баннеров";
$GLOBALS['strDeliveryUrlPrefixSSL'] = "URL движка доставки баннеров (SSL)";
$GLOBALS['strImagesUrlPrefix'] = "URL хранилища изображений";
$GLOBALS['strImagesUrlPrefixSSL'] = "URL хранилища изображений (SSL)";


$GLOBALS['strUpgrade'] = "Upgrade";

/* ------------------------------------------------------- */
/* Configuration translations                            */
/* ------------------------------------------------------- */

// Global
$GLOBALS['strChooseSection'] = "Выберите раздел";
$GLOBALS['strEditConfigNotPossible'] = "It is not possible to edit all settings because the configuration file is locked for security reasons.
    If you want to make changes, you may need to unlock the configuration file for this installation first.";
$GLOBALS['strEditConfigPossible'] = "It is possible to edit all settings because the configuration file is not locked, but this could lead to security issues.
    If you want to secure your system, you need to lock the configuration file for this installation.";
$GLOBALS['strUnableToWriteConfig'] = "Невозможно сохранить изменения в файл конфигурации";
$GLOBALS['strUnableToWritePrefs'] = "Невозможно сохранить настройки в БД";
$GLOBALS['strImageDirLockedDetected'] = "Указанная<b>папка для изображений</b>недоступна для записи. <br>Необходимо изменить настройки доступа, или создать папку.";

// Configuration Settings
$GLOBALS['strConfigurationSettings'] = "Настройки конфигурации";

// Administrator Settings
$GLOBALS['strAdminUsername'] = "Имя пользователя-администратора";
$GLOBALS['strAdminPassword'] = "Пароль пользователя-администратора";
$GLOBALS['strInvalidUsername'] = "Неверное имя пользователя";
$GLOBALS['strBasicInformation'] = "Основна інформація";
$GLOBALS['strAdministratorEmail'] = "Адрес электронной почты администратора";
$GLOBALS['strAdminCheckUpdates'] = "Проверить обновления";
$GLOBALS['strAdminShareStack'] = "Share technical information with the {$PRODUCT_NAME} Team to help with development and testing.";
$GLOBALS['strNovice'] = "Delete actions require confirmation for safety";
$GLOBALS['strUserlogEmail'] = "Протоколировать все исходящие сообщения электронной почты";
$GLOBALS['strEnableDashboard'] = "Enable dashboard";
$GLOBALS['strEnableDashboardSyncNotice'] = "Пожалуйста разрешите <a href='account-settings-update.php'>Проверить обновление</a> если вы хотите использовать панель инструментов.";
$GLOBALS['strTimezone'] = "Часовой пояс";
$GLOBALS['strEnableAutoMaintenance'] = "Автоматически проводить обслуживание БД во время доставки баннеров, если обслуживание не настроено вручную";

// Database Settings
$GLOBALS['strDatabaseSettings'] = "Настройки базы данных";
$GLOBALS['strDatabaseServer'] = "Сервер баз данных";
$GLOBALS['strDbLocal'] = "Использовать соединение с локальным сокетом";
$GLOBALS['strDbType'] = "Тип БД";
$GLOBALS['strDbHost'] = "Имя хоста";
$GLOBALS['strDbSocket'] = "Сокет БД";
$GLOBALS['strDbPort'] = "Порт БД";
$GLOBALS['strDbUser'] = "Имя пользователя";
$GLOBALS['strDbPassword'] = "Пароль";
$GLOBALS['strDbName'] = "Имя базы данных";
$GLOBALS['strDbNameHint'] = "Если БД не существует, она будет создана автоматически";
$GLOBALS['strDatabaseOptimalisations'] = "Настройки оптимизации работы с БД";
$GLOBALS['strPersistentConnections'] = "Использовать постоянные соединения";
$GLOBALS['strCantConnectToDb'] = "Не могу связаться с базой данных";
$GLOBALS['strCantConnectToDbDelivery'] = 'Не удается подключиться к базе данных для доставки';

// Email Settings
$GLOBALS['strEmailSettings'] = "Email Settings";
$GLOBALS['strEmailAddresses'] = "Email \"От\" адрес";
$GLOBALS['strEmailFromName'] = "Email \"От\" Имя";
$GLOBALS['strEmailFromAddress'] = "Email \"От\" Электронная почта";
$GLOBALS['strEmailFromCompany'] = "Email \"От\" Компания";
$GLOBALS['strUseManagerDetails'] = 'Use the owning account\'s Contact, Email and Name instead of the above Name, Email Address and Company when emailing reports to Advertiser or Website accounts.';
$GLOBALS['strQmailPatch'] = "патч для qmail";
$GLOBALS['strEnableQmailPatch'] = "Enable qmail patch";
$GLOBALS['strEmailHeader'] = "Email headers";
$GLOBALS['strEmailLog'] = "Email log";

// Audit Trail Settings
$GLOBALS['strAuditTrailSettings'] = "Настройки аудита изменений";
$GLOBALS['strEnableAudit'] = "Enable Audit Trail";
$GLOBALS['strEnableAuditForZoneLinking'] = "Enable Audit Trail for Zone Linking screen (introduces huge performance penalty when linking large amounts of zones)";

// Debug Logging Settings
$GLOBALS['strDebug'] = "Глобальные настройки отладочного журнала";
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
$GLOBALS['strProductionSystem'] = "Production сервер";

// Delivery Settings
$GLOBALS['strWebPath'] = "{$PRODUCT_NAME} Server Access Paths";
$GLOBALS['strWebPathSimple'] = "Расположение веб-страниц";
$GLOBALS['strDeliveryPath'] = "Расположение папки доставки";
$GLOBALS['strImagePath'] = "Расположение папки изображений";
$GLOBALS['strDeliverySslPath'] = "Расположение папки доставки (SSL)";
$GLOBALS['strImageSslPath'] = "Расположение папки изображений (SSL)";
$GLOBALS['strImageStore'] = "Папка изображений";
$GLOBALS['strTypeWebSettings'] = "Конфигурация веб-баннеров";
$GLOBALS['strTypeWebMode'] = "Метод хранения";
$GLOBALS['strTypeWebModeLocal'] = "Локальный режим (хранятся в локальном каталоге)";
$GLOBALS['strTypeDirError'] = "У веб-сервера нет прав на запись в локальную папку.";
$GLOBALS['strTypeWebModeFtp'] = "FTP-режим (хранятся на внешнем FTP-сервере)";
$GLOBALS['strTypeWebDir'] = "Локальный режим (хранятся в локальном каталоге)";
$GLOBALS['strTypeFTPHost'] = "Имя FTP сервера";
$GLOBALS['strTypeFTPDirectory'] = "Папка";
$GLOBALS['strTypeFTPUsername'] = "Ім'я користувача";
$GLOBALS['strTypeFTPPassword'] = "Пароль";
$GLOBALS['strTypeFTPPassive'] = "Использовать пассивный режим";
$GLOBALS['strTypeFTPErrorDir'] = "Указанная папка недоступна";
$GLOBALS['strTypeFTPErrorConnect'] = "Невозможно соединиться с сервером, неправильные имя пользователя или пароль";
$GLOBALS['strTypeFTPErrorNoSupport'] = "Your installation of PHP does not support FTP.";
$GLOBALS['strTypeFTPErrorUpload'] = "Невозможно загрузить файл на FTP сервер, проверьте права доступа.";
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
$GLOBALS['strDeliveryFilenamesSinglePageCall'] = "Single Page Call";
$GLOBALS['strDeliveryFilenamesSinglePageCallJS'] = "Single Page Call (JavaScript)";
$GLOBALS['strDeliveryCaching'] = "Настройки кэширования доставки";
$GLOBALS['strDeliveryCacheLimit'] = "Время между обновлениями кэша (сек.)";
$GLOBALS['strDeliveryCacheStore'] = "Banner Delivery Cache Store Type";
$GLOBALS['strDeliveryAcls'] = "Evaluate banner delivery rules during delivery";
$GLOBALS['strDeliveryAclsDirectSelection'] = "Evaluate banner delivery rules for direct selected ads";
$GLOBALS['strDeliveryObfuscate'] = "Obfuscate delivery rule set when delivering ads";
$GLOBALS['strDeliveryExecPhp'] = "Разрешить исполнение кода PHP (Предупреждение: эта опция небезопасна)";
$GLOBALS['strDeliveryCtDelimiter'] = "Разделитель для сторонних трекеров";
$GLOBALS['strGlobalDefaultBannerUrl'] = "Глобальное значение баннера по умолчанию URL";
$GLOBALS['strP3PSettings'] = "Настройки P3P (политика обращения с частной информацией) ";
$GLOBALS['strUseP3P'] = "Использовать P3P-политики";
$GLOBALS['strP3PCompactPolicy'] = "Компактная политика P3P";
$GLOBALS['strP3PPolicyLocation'] = "Место размещения P3P-политики";
$GLOBALS['strPrivacySettings'] = "Privacy Settings";
$GLOBALS['strDisableViewerId'] = "Disable unique Viewer Id cookie";
$GLOBALS['strAnonymiseIp'] = "Anonymise viewer IP addresses";

// General Settings
$GLOBALS['generalSettings'] = "Global General System Settings";
$GLOBALS['uiEnabled'] = "Интерфейс пользователя включен";
$GLOBALS['defaultLanguage'] = "Default System Language<br />(Each user can select their own language)";

// Geotargeting Settings
$GLOBALS['strGeotargetingSettings'] = "Настройки гео-таргетинга";
$GLOBALS['strGeotargeting'] = "Настройки гео-таргетинга";
$GLOBALS['strGeotargetingType'] = "Тип модуля гео-таргетинга";
$GLOBALS['strGeoShowUnavailable'] = "Show geotargeting delivery rules even if GeoIP data unavailable";

// Interface Settings
$GLOBALS['strInventory'] = "Адміністрування";
$GLOBALS['strShowCampaignInfo'] = "Показывать дополнительную информацию на странице <i>обзора кампании</i>";
$GLOBALS['strShowBannerInfo'] = "Показывать дополнительную информацию на странице <i>обзора баннеров</i>";
$GLOBALS['strShowCampaignPreview'] = "Показывать превью баннеров на странице <i>обзора баннеров</i>";
$GLOBALS['strShowBannerHTML'] = "Показывать баннер вместо HTML-кода на странице обзора HTML баннеров";
$GLOBALS['strShowBannerPreview'] = "Показывать превью баннера вверху страниц управления баннерами";
$GLOBALS['strUseWyswygHtmlEditorByDefault'] = "Use the WYSIWYG HTML Editor by default when creating or editing HTML banners";
$GLOBALS['strHideInactive'] = "Приховати неактивні";
$GLOBALS['strGUIShowMatchingBanners'] = "Показывать баннеры на странице <i>Связанные баннеры</i>";
$GLOBALS['strGUIShowParentCampaigns'] = "Показывать кампании на странице <i>Связанные баннеры</i>";
$GLOBALS['strShowEntityId'] = "Show entity identifiers";
$GLOBALS['strStatisticsDefaults'] = "Статистика";
$GLOBALS['strBeginOfWeek'] = "Начало недели";
$GLOBALS['strPercentageDecimals'] = "Десятичные дроби";
$GLOBALS['strWeightDefaults'] = "Вес по умолчанию";
$GLOBALS['strDefaultBannerWeight'] = "Вес баннера по умолчанию";
$GLOBALS['strDefaultCampaignWeight'] = "Вес кампании по умолчанию";
$GLOBALS['strConfirmationUI'] = "Confirmation in User Interface";

// Invocation Settings
$GLOBALS['strInvocationDefaults'] = "Настройки вызова по умолчанию";
$GLOBALS['strEnable3rdPartyTrackingByDefault'] = "Разрешить сторонние трекеры по умолчанию";

// Banner Delivery Settings
$GLOBALS['strBannerDelivery'] = "Настройки доставки баннеров";

// Banner Logging Settings
$GLOBALS['strBannerLogging'] = "Настройки журналирования";
$GLOBALS['strLogAdRequests'] = "Регистрировать запрос каждый раз когда запрошен баннер";
$GLOBALS['strLogAdImpressions'] = "Регистрировать просмотр каждый раз когда просмотрен баннер";
$GLOBALS['strLogAdClicks'] = "Регистрировать клик каждый раз, когда пользователь кликает на баннере";
$GLOBALS['strReverseLookup'] = "Проверка обратного DNS";
$GLOBALS['strProxyLookup'] = "Проверка прокси";
$GLOBALS['strPreventLogging'] = "Глобальные настройки не-фиксируемых действий";
$GLOBALS['strIgnoreHosts'] = "Игнорировать хосты";
$GLOBALS['strIgnoreUserAgents'] = "<b>Не</b> считать статистику для клиентов со следующими строками в user-agent (по одной на строку)";
$GLOBALS['strEnforceUserAgents'] = "<b>Считать только</b> статистику для клиентов со следующими строками в user-agent (по одной на строку)";

// Banner Storage Settings
$GLOBALS['strBannerStorage'] = "Banner Storage Settings";

// Campaign ECPM settings
$GLOBALS['strEnableECPM'] = "Use eCPM optimized priorities instead of remnant-weighted priorities";
$GLOBALS['strEnableContractECPM'] = "Use eCPM optimized priorities instead of standard contract priorities";
$GLOBALS['strEnableECPMfromRemnant'] = "(If you enable this feature all your remnant campaigns will be deactivated, you will have to update them manually to reactivate them)";
$GLOBALS['strEnableECPMfromECPM'] = "(If you disable this feature some of your active eCPM campaigns will be deactivated, you will have to update them manually to reactivate them)";
$GLOBALS['strInactivatedCampaigns'] = "List of campaigns which became inactive due to the changes in preferences:";

// Statistics & Maintenance Settings
$GLOBALS['strMaintenanceSettings'] = "Maintenance Settings";
$GLOBALS['strConversionTracking'] = "Настройки учета конверсии";
$GLOBALS['strEnableConversionTracking'] = "Разрешить учет конверсии";
$GLOBALS['strBlockInactiveBanners'] = "Don't count ad impressions, clicks or re-direct the user to the target URL if the viewer clicks on a banner that is inactive";
$GLOBALS['strBlockAdClicks'] = "Не засчитывать клик, если пользователь кликает ту же пару баннер/зона в течение указанного времени (сек.)";
$GLOBALS['strMaintenanceOI'] = "Интервал между операциями обслуживания (минут)";
$GLOBALS['strPrioritySettings'] = "Глобальные настройки приоритетов";
$GLOBALS['strPriorityInstantUpdate'] = "Обновлять приоритеты немедленно при внесении изменений";
$GLOBALS['strPriorityIntentionalOverdelivery'] = "Intentionally over-deliver Contract Campaigns<br />(% over-delivery)";
$GLOBALS['strDefaultImpConvWindow'] = "Default Ad Impression Conversion Window (seconds)";
$GLOBALS['strDefaultCliConvWindow'] = "Default Ad Click Conversion Window (seconds)";
$GLOBALS['strAdminEmailHeaders'] = "Добавлять в каждое письмо заголовок message sent by {$PRODUCT_NAME}";
$GLOBALS['strWarnLimit'] = "Предупреждение о лимите";
$GLOBALS['strWarnLimitDays'] = "Отправлять сообщение если осталось дней меньше чем";
$GLOBALS['strWarnAdmin'] = "Отправлять сообщение администратору всякий раз когда кампания близка к завершению";
$GLOBALS['strWarnClient'] = "Отправлять сообщение клиенту всякий раз когда кампания близка к завершению";
$GLOBALS['strWarnAgency'] = "Отправлять сообщение агентству всякий раз когда кампания близка к завершению";

// UI Settings
$GLOBALS['strGuiSettings'] = "Настройка интерфейса пользователя";
$GLOBALS['strGeneralSettings'] = "Общие настройки";
$GLOBALS['strAppName'] = "Имя приложения";
$GLOBALS['strMyHeader'] = "Мой заголовок";
$GLOBALS['strMyFooter'] = "Мой подвал";
$GLOBALS['strDefaultTrackerStatus'] = "Статус по умолчанию";
$GLOBALS['strDefaultTrackerType'] = "Тип по умолчанию";
$GLOBALS['strSSLSettings'] = "SSL Settings";
$GLOBALS['requireSSL'] = "Принудительно использовать SSL в GUI";
$GLOBALS['sslPort'] = "SSL порт сервера";
$GLOBALS['strDashboardSettings'] = "Настройка панели";
$GLOBALS['strMyLogo'] = "Имя файла логотипа";
$GLOBALS['strGuiHeaderForegroundColor'] = "Цвет букв заголовка";
$GLOBALS['strGuiHeaderBackgroundColor'] = "Цвет фона заголовка";
$GLOBALS['strGuiActiveTabColor'] = "Цвет активной закладки";
$GLOBALS['strGuiHeaderTextColor'] = "Цвет текста в заголовке";
$GLOBALS['strGuiSupportLink'] = "Custom URL for 'Support' link in header";
$GLOBALS['strGzipContentCompression'] = "Использовать Gzip сжатие";

// Regenerate Platfor Hash script
$GLOBALS['strPlatformHashRegenerate'] = "Platform Hash Regenerate";
$GLOBALS['strNewPlatformHash'] = "Your new Platform Hash is:";
$GLOBALS['strPlatformHashInsertingError'] = "Error inserting Platform Hash into database";

// Plugin Settings
$GLOBALS['strPluginSettings'] = "Plugin Settings";
$GLOBALS['strEnableNewPlugins'] = "Enable newly installed plugins";
$GLOBALS['strUseMergedFunctions'] = "Use merged delivery functions file";
