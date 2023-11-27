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
$GLOBALS['strInstall'] = "Встановити";
$GLOBALS['strDatabaseSettings'] = "Налаштування бази даних";
$GLOBALS['strAdminAccount'] = "Обліковий запис системного адміністратора";
$GLOBALS['strAdvancedSettings'] = "Розширені налаштування";
$GLOBALS['strWarning'] = "Попередження";
$GLOBALS['strBtnContinue'] = "Продовжити »";
$GLOBALS['strBtnRecover'] = "Відновити »";
$GLOBALS['strBtnAgree'] = "Я згоден »";
$GLOBALS['strBtnRetry'] = "Повторити";
$GLOBALS['strTablesPrefix'] = "Префікс імен таблиць";
$GLOBALS['strTablesType'] = "Тип таблиці";

$GLOBALS['strRecoveryRequiredTitle'] = "Під час вашої попередньої спроби оновлення сталася помилка";
$GLOBALS['strRecoveryRequired'] = "Під час обробки вашого попереднього оновлення сталася помилка, тому {$PRODUCT_NAME} має спробувати відновити процес оновлення. Натисніть кнопку «Відновити» нижче.";

$GLOBALS['strProductUpToDateTitle'] = "{$PRODUCT_NAME} оновлено";
$GLOBALS['strOaUpToDate'] = "Ваша база даних і файлова структура {$PRODUCT_NAME} використовують найновішу версію, тому оновлення наразі не потрібне. Натисніть «Продовжити», щоб перейти до панелі адміністрування.";
$GLOBALS['strOaUpToDateCantRemove'] = "Файл UPGRADE все ще присутній у вашій папці \"var\". Ми не можемо видалити цей файл через недостатні дозволи. Будь ласка, видаліть цей файл самостійно.";
$GLOBALS['strErrorWritePermissions'] = "Було виявлено помилки дозволу на файл, і їх потрібно виправити, перш ніж ви зможете продовжити.<br />Щоб виправити помилки в системі Linux, спробуйте ввести наступні команди:";
$GLOBALS['strErrorFixPermissionsRCommand'] = "<i>chmod -R a+w %s</i>";
$GLOBALS['strNotWriteable'] = "НЕ доступно для запису";
$GLOBALS['strDirNotWriteableError'] = "Каталог має бути доступним для запису";

$GLOBALS['strErrorWritePermissionsWin'] = "Було виявлено помилки дозволу на файл, і їх потрібно виправити, перш ніж ви зможете продовжити.";
$GLOBALS['strCheckDocumentation'] = "Щоб отримати додаткову допомогу, перегляньте <a href=\"{$PRODUCT_DOCSURL}\">документацію {$PRODUCT_NAME}</a>.";
$GLOBALS['strSystemCheckBadPHPConfig'] = "Ваша поточна конфігурація PHP не відповідає вимогам {$PRODUCT_NAME}. Щоб вирішити проблеми, будь ласка, змініть налаштування у файлі «php.ini».";

$GLOBALS['strAdminUrlPrefix'] = "URL-адреса інтерфейсу адміністратора";
$GLOBALS['strDeliveryUrlPrefix'] = "URL-адреса системи доставки";
$GLOBALS['strDeliveryUrlPrefixSSL'] = "URL-адреса системи доставки (SSL)";
$GLOBALS['strImagesUrlPrefix'] = "URL-адреса сховища зображень";
$GLOBALS['strImagesUrlPrefixSSL'] = "URL-адреса сховища зображень (SSL)";


$GLOBALS['strUpgrade'] = "Оновити";

/* ------------------------------------------------------- */
/* Configuration translations                            */
/* ------------------------------------------------------- */

// Global
$GLOBALS['strChooseSection'] = "Виберіть розділ";
$GLOBALS['strEditConfigNotPossible'] = "Неможливо редагувати всі налаштування, оскільки файл конфігурації заблоковано з міркувань безпеки.
     Якщо ви хочете внести зміни, вам, можливо, доведеться спочатку розблокувати файл конфігурації для цієї інсталяції.";
$GLOBALS['strEditConfigPossible'] = "Можна редагувати всі налаштування, оскільки файл конфігурації не заблоковано, але це може призвести до проблем із безпекою.
     Якщо ви хочете захистити свою систему, вам потрібно заблокувати файл конфігурації для цієї інсталяції.";
$GLOBALS['strUnableToWriteConfig'] = "Неможливо записати зміни до конфігураційного файлу";
$GLOBALS['strUnableToWritePrefs'] = "Неможливо закріпити налаштування для бази даних";
$GLOBALS['strImageDirLockedDetected'] = "Надана <b>папка зображень</b> не може бути записана сервером. <br>Ви не можете продовжити, доки не зміните дозволи папки або не створите її.";

// Configuration Settings
$GLOBALS['strConfigurationSettings'] = "Налаштування конфігурації";

// Administrator Settings
$GLOBALS['strAdminUsername'] = "Ім'я адміністратора";
$GLOBALS['strAdminPassword'] = "Пароль адміністратора";
$GLOBALS['strInvalidUsername'] = "Невірне ім'я користувача";
$GLOBALS['strBasicInformation'] = "Основна інформація";
$GLOBALS['strAdministratorEmail'] = "Адреса електронної пошти адміністратора";
$GLOBALS['strAdminCheckUpdates'] = "Автоматично перевіряти наявність оновлень продукту та сповіщень системи безпеки (рекомендовано).";
$GLOBALS['strAdminShareStack'] = "Поділіться технічною інформацією з командою {$PRODUCT_NAME}, щоб допомогти з розробкою та тестуванням.";
$GLOBALS['strNovice'] = "Дії видалення потребують підтвердження з міркувань безпеки";
$GLOBALS['strUserlogEmail'] = "Логувати всі вихідні повідомлення електронної пошти";
$GLOBALS['strEnableDashboard'] = "Увімкнути інформаційну панель";
$GLOBALS['strEnableDashboardSyncNotice'] = "Будь ласка, увімкніть <a href='account-settings-update.php'>перевірку оновлень</a>, щоб використовувати інформаційну панель.";
$GLOBALS['strTimezone'] = "Часовий пояс";
$GLOBALS['strEnableAutoMaintenance'] = "Автоматично виконувати технічне обслуговування під час доставки, якщо планове технічне обслуговування не налаштовано";

// Database Settings
$GLOBALS['strDatabaseSettings'] = "Налаштування бази даних";
$GLOBALS['strDatabaseServer'] = "Параметри сервера бази даних";
$GLOBALS['strDbLocal'] = "Використовувати підключення через локальний сокет";
$GLOBALS['strDbType'] = "Тип бази даних";
$GLOBALS['strDbHost'] = "Ім'я хосту бази даних";
$GLOBALS['strDbSocket'] = "Сокет бази даних";
$GLOBALS['strDbPort'] = "Номер порту бази даних";
$GLOBALS['strDbUser'] = "Ім'я користувача бази даних";
$GLOBALS['strDbPassword'] = "Пароль бази даних";
$GLOBALS['strDbName'] = "Ім'я бази даних";
$GLOBALS['strDbNameHint'] = "База даних буде створена, якщо її не існує";
$GLOBALS['strDatabaseOptimalisations'] = "Параметри оптимізації бази даних";
$GLOBALS['strPersistentConnections'] = "Використовуйте постійні підключення";
$GLOBALS['strCantConnectToDb'] = "Не вдається підключитися до бази даних";
$GLOBALS['strCantConnectToDbDelivery'] = 'Не вдається підключитися до бази даних для доставки';

// Email Settings
$GLOBALS['strEmailSettings'] = "Налаштування електронної пошти";
$GLOBALS['strEmailAddresses'] = "Адреса електронної пошти \"Від\"";
$GLOBALS['strEmailFromName'] = "Ім'я \"Від\" електронної пошти";
$GLOBALS['strEmailFromAddress'] = "Адреса електронної пошти «Від».";
$GLOBALS['strEmailFromCompany'] = "Електронна пошта «Від» компанії";
$GLOBALS['strUseManagerDetails'] = 'Використовуйте контакт, адресу електронної пошти та ім’я власного облікового запису замість наведених вище імені, адреси електронної пошти та компанії під час надсилання звітів електронною поштою до облікових записів рекламодавців або веб-сайтів.';
$GLOBALS['strQmailPatch'] = "патч qmail";
$GLOBALS['strEnableQmailPatch'] = "Увімкнути патч qmail";
$GLOBALS['strEmailHeader'] = "Заголовки електронного листа";
$GLOBALS['strEmailLog'] = "Журнал електронної пошти";

// Audit Trail Settings
$GLOBALS['strAuditTrailSettings'] = "Налаштування журналу аудиту";
$GLOBALS['strEnableAudit'] = "Увімкнути журнал аудиту";
$GLOBALS['strEnableAuditForZoneLinking'] = "Увімкнути журнал аудиту для екрана зв’язування зон (значне зниження продуктивності під час зв’язування великої кількості зон)";

// Debug Logging Settings
$GLOBALS['strDebug'] = "Налаштування журналу налагоджування";
$GLOBALS['strEnableDebug'] = "Увімкнути журнал налагодження";
$GLOBALS['strDebugMethodNames'] = "Включати назви методів у журнал налагодження";
$GLOBALS['strDebugLineNumbers'] = "Включіть номери рядків у журнал налагодження";
$GLOBALS['strDebugType'] = "Тип журналу налагодження";
$GLOBALS['strDebugTypeFile'] = "Файл";
$GLOBALS['strDebugTypeMcal'] = "mCal";
$GLOBALS['strDebugTypeSql'] = "База даних SQL";
$GLOBALS['strDebugTypeSyslog'] = "Syslog";
$GLOBALS['strDebugName'] = "Назва журналу налагодження, календар, таблиця SQL<br />або Syslog Facility";
$GLOBALS['strDebugPriority'] = "Рівень пріоритету налагодження";
$GLOBALS['strPEAR_LOG_DEBUG'] = "PEAR_LOG_DEBUG - більшість інформації";
$GLOBALS['strPEAR_LOG_INFO'] = "PEAR_LOG_INFO - Інформація за замовчуванням";
$GLOBALS['strPEAR_LOG_NOTICE'] = "PEAR_LOG_NOTICE";
$GLOBALS['strPEAR_LOG_WARNING'] = "PEAR_LOG_WARNING";
$GLOBALS['strPEAR_LOG_ERR'] = "PEAR_LOG_ERR";
$GLOBALS['strPEAR_LOG_CRIT'] = "PEAR_LOG_CRIT";
$GLOBALS['strPEAR_LOG_ALERT'] = "PEAR_LOG_ALERT";
$GLOBALS['strPEAR_LOG_EMERG'] = "PEAR_LOG_EMERG - мінімум інформації";
$GLOBALS['strDebugIdent'] = "Рядок ідентифікації налагодження";
$GLOBALS['strDebugUsername'] = "mCal, ім’я користувача SQL Server";
$GLOBALS['strDebugPassword'] = "mCal, пароль SQL Server";
$GLOBALS['strProductionSystem'] = "Виробнича система";

// Delivery Settings
$GLOBALS['strWebPath'] = "Шляхи доступу до сервера {$PRODUCT_NAME}";
$GLOBALS['strWebPathSimple'] = "Веб-шлях";
$GLOBALS['strDeliveryPath'] = "Шлях доставки";
$GLOBALS['strImagePath'] = "Шлях до зображень";
$GLOBALS['strDeliverySslPath'] = "Шлях SSL доставки";
$GLOBALS['strImageSslPath'] = "Шлях SSL зображень";
$GLOBALS['strImageStore'] = "Папка із зображеннями";
$GLOBALS['strTypeWebSettings'] = "Налаштування локального зберігання банерів веб-сервера";
$GLOBALS['strTypeWebMode'] = "Спосіб зберігання";
$GLOBALS['strTypeWebModeLocal'] = "Локальний каталог";
$GLOBALS['strTypeDirError'] = "Веб-сервер не може записати в локальний каталог";
$GLOBALS['strTypeWebModeFtp'] = "Зовнішній FTP-сервер";
$GLOBALS['strTypeWebDir'] = "Локальний каталог";
$GLOBALS['strTypeFTPHost'] = "Хост FTP";
$GLOBALS['strTypeFTPDirectory'] = "Каталог хостів";
$GLOBALS['strTypeFTPUsername'] = "Ім'я користувача";
$GLOBALS['strTypeFTPPassword'] = "Пароль";
$GLOBALS['strTypeFTPPassive'] = "Використовати пасивний FTP";
$GLOBALS['strTypeFTPErrorDir'] = "Каталог хосту FTP не існує";
$GLOBALS['strTypeFTPErrorConnect'] = "Не вдалося підключитися до FTP-сервера, логін або пароль неправильні";
$GLOBALS['strTypeFTPErrorNoSupport'] = "Ваша інсталяція PHP не підтримує FTP.";
$GLOBALS['strTypeFTPErrorUpload'] = "Не вдалося завантажити файл на FTP-сервер, перевірте, чи належні права для каталогу хосту";
$GLOBALS['strTypeFTPErrorHost'] = "FTP-хост неправильний";
$GLOBALS['strDeliveryFilenames'] = "Імена файлів доставки";
$GLOBALS['strDeliveryFilenamesAdClick'] = "Ad Click";
$GLOBALS['strDeliveryFilenamesSignedAdClick'] = "Підписанний Ad Click";
$GLOBALS['strDeliveryFilenamesAdConversionVars'] = "Змінні конверсії оголошення";
$GLOBALS['strDeliveryFilenamesAdContent'] = "Вміст реклами";
$GLOBALS['strDeliveryFilenamesAdConversion'] = "Конверсія реклами";
$GLOBALS['strDeliveryFilenamesAdConversionJS'] = "Конверсія реклами (JavaScript)";
$GLOBALS['strDeliveryFilenamesAdFrame'] = "Фрейм рекламы";
$GLOBALS['strDeliveryFilenamesAdImage'] = "Зображення рекламы";
$GLOBALS['strDeliveryFilenamesAdJS'] = "Реклама (JavaScript)";
$GLOBALS['strDeliveryFilenamesAdLayer'] = "Рекламний шар";
$GLOBALS['strDeliveryFilenamesAdLog'] = "Журнал реклами";
$GLOBALS['strDeliveryFilenamesAdPopup'] = "Спливаюче вікно реклами";
$GLOBALS['strDeliveryFilenamesAdView'] = "Перегляд реклами";
$GLOBALS['strDeliveryFilenamesXMLRPC'] = "Виклик XML RPC";
$GLOBALS['strDeliveryFilenamesLocal'] = "Локальний виклик";
$GLOBALS['strDeliveryFilenamesFrontController'] = "Фронт контролер";
$GLOBALS['strDeliveryFilenamesSinglePageCall'] = "Односторінковий виклик";
$GLOBALS['strDeliveryFilenamesSinglePageCallJS'] = "Односторінковий виклик (JavaScript)";
$GLOBALS['strDeliveryFilenamesAsyncJS'] = "Асинхронний JavaScript (вихідний файл)";
$GLOBALS['strDeliveryFilenamesAsyncPHP'] = "Асинхронний JavaScript";
$GLOBALS['strDeliveryFilenamesAsyncSPC'] = "Односторінковий виклик асинхронного JavaScript";
$GLOBALS['strDeliveryCaching'] = "Параметри кешу доставки банерів";
$GLOBALS['strDeliveryCacheLimit'] = "Час між оновленнями кешу банерів (секунди)";
$GLOBALS['strDeliveryCacheStore'] = "Тип сховища кешу доставки банерів";
$GLOBALS['strDeliveryAcls'] = "Перевіряти правила доставки банерів під час доставки";
$GLOBALS['strDeliveryAclsDirectSelection'] = "Перевіряти правила доставки банерів для прямого відбору оголошень";
$GLOBALS['strDeliveryObfuscate'] = "Обфускаціювати набор правил доставки під час показу оголошень";
$GLOBALS['strDeliveryClickUrlValidity'] = "Дійсність користувацьких переспрямувань цільової URL-адреси в макросах {clickurl} (у секундах). Введіть 0, щоб заборонити переспрямування";
$GLOBALS['strDeliveryRelAttribute'] = "Типовий атрибут rel для &lt;a href&gt;  HTML-тегів";
$GLOBALS['strGlobalDefaultBannerInvalidZone'] = "Глобальний HTML-банер за замовчуванням для неіснуючих зон";
$GLOBALS['strGlobalDefaultBannerSuspendedAccount'] = "Глобальний HTML-банер за умовчанням для призупинених облікових записів";
$GLOBALS['strGlobalDefaultBannerInactiveAccount'] = "Глобальний HTML-банер за замовчуванням для неактивних облікових записів";
$GLOBALS['strP3PSettings'] = "Політика конфіденційності P3P";
$GLOBALS['strUseP3P'] = "Використовуйте політики P3P";
$GLOBALS['strP3PCompactPolicy'] = "Компактна політика P3P";
$GLOBALS['strP3PPolicyLocation'] = "Розташування політики P3P";
$GLOBALS['strPrivacySettings'] = "Параметри конфіденційності";
$GLOBALS['strDisableViewerId'] = "Вимкнути файл cookie унікального ідентифікатора переглядача";
$GLOBALS['strAnonymiseIp'] = "Анонімні IP-адреси глядачів";

// General Settings
$GLOBALS['generalSettings'] = "Загальні параметри системи";
$GLOBALS['uiEnabled'] = "Інтерфейс користувача ввімкнено";
$GLOBALS['defaultLanguage'] = "Мова системи за замовчуванням<br />(кожен користувач може вибрати власну мову)";

// Geotargeting Settings
$GLOBALS['strGeotargetingSettings'] = "Налаштування географічного націлювання";
$GLOBALS['strGeotargeting'] = "Налаштування географічного націлювання";
$GLOBALS['strGeotargetingType'] = "Тип модуля геотаргетингу";
$GLOBALS['strGeoShowUnavailable'] = "Показувати правила доставки геотаргетингу, навіть якщо дані GeoIP недоступні";

// Interface Settings
$GLOBALS['strInventory'] = "Адміністрування";
$GLOBALS['strShowCampaignInfo'] = "Показати додаткову інформацію про кампанію на сторінці <i>Кампанії</i>";
$GLOBALS['strShowBannerInfo'] = "Показати додаткову інформацію про банер на сторінці <i>Баннери</i>";
$GLOBALS['strShowCampaignPreview'] = "Показати попередній перегляд усіх банерів на сторінці <i>Баннери</i>";
$GLOBALS['strShowBannerHTML'] = "Показати фактичний банер замість звичайного HTML-коду для попереднього перегляду HTML-банера";
$GLOBALS['strShowBannerPreview'] = "Показати попередній перегляд банерів у верхній частині сторінок, які стосуються банерів";
$GLOBALS['strUseWyswygHtmlEditorByDefault'] = "Використовуйте редактор WYSIWYG HTML за умовчанням під час створення або редагування банерів HTML";
$GLOBALS['strHideInactive'] = "Приховати неактивні";
$GLOBALS['strGUIShowMatchingBanners'] = "Показувати відповідні банери на сторінках <i>Зв'язунного банера</i>";
$GLOBALS['strGUIShowParentCampaigns'] = "Показати батьківські кампанії на сторінках <i>Зв'язунного банера</i>";
$GLOBALS['strShowEntityId'] = "Показати ідентифікатори об’єктів";
$GLOBALS['strStatisticsDefaults'] = "Статистика";
$GLOBALS['strBeginOfWeek'] = "Початок тижня";
$GLOBALS['strPercentageDecimals'] = "Десяткові знаки у відсотках";
$GLOBALS['strWeightDefaults'] = "Вага за замовчуванням";
$GLOBALS['strDefaultBannerWeight'] = "Вага банера за замовчуванням";
$GLOBALS['strDefaultCampaignWeight'] = "Вага кампанії за замовчуванням";
$GLOBALS['strConfirmationUI'] = "Підтвердження в інтерфейсі користувача";

// Invocation Settings
$GLOBALS['strInvocationDefaults'] = "Стандартні параметри виклику";
$GLOBALS['strEnable3rdPartyTrackingByDefault'] = "Увімкнути стороннє відстеження кліків за замовчуванням";

// Banner Delivery Settings
$GLOBALS['strBannerDelivery'] = "Налаштування доставки банерів";

// Banner Logging Settings
$GLOBALS['strBannerLogging'] = "Параметри журналювання банерів";
$GLOBALS['strLogAdRequests'] = "Реєструвати запит кожного разу, коли запитується банер";
$GLOBALS['strLogAdImpressions'] = "Реєструвати покази кожного разу, коли переглядається банер";
$GLOBALS['strLogAdClicks'] = "Реєструвати клік кожного разу, коли глядач натискає банер";
$GLOBALS['strReverseLookup'] = "Зворотний пошук імен хостів глядачів, якщо їх не надано";
$GLOBALS['strProxyLookup'] = "Старатися визначити справжню IP-адресу глядачів за проксі-сервером";
$GLOBALS['strPreventLogging'] = "Заблокувати параметри журналювання банерів";
$GLOBALS['strIgnoreHosts'] = "Не реєструвати жодної статистики для глядачів, які використовують будь-яку з наведених нижче IP-адрес або імен хостів";
$GLOBALS['strIgnoreUserAgents'] = "<b>Не</b> реєструвати статистику від клієнтів із будь-яким із наведених нижче строк у їхньому агенті користувача (один на рядок)";
$GLOBALS['strEnforceUserAgents'] = "<b>Лише</b> ркєструвати статистику від клієнтів із будь-яким із наведених нижче строк у їхньому агенті користувача (один на рядок)";

// Banner Storage Settings
$GLOBALS['strBannerStorage'] = "Налаштування зберігання банерів";

// Campaign ECPM settings
$GLOBALS['strEnableECPM'] = "Використовати оптимізовані пріоритети eCPM замість пріоритетів, зважених на залишки";
$GLOBALS['strEnableContractECPM'] = "Використовуйте оптимізовані пріоритети eCPM замість стандартних контрактних пріоритетів";
$GLOBALS['strEnableECPMfromRemnant'] = "(Якщо ви ввімкнете цю функцію, усі ваші залишкові кампанії буде деактивовано, вам доведеться оновити їх вручну, щоб повторно активувати)";
$GLOBALS['strEnableECPMfromECPM'] = "(Якщо ви вимкнете цю функцію, деякі з ваших активних кампаній eCPM буде деактивовано, вам доведеться оновити їх вручну, щоб повторно активувати їх)";
$GLOBALS['strInactivatedCampaigns'] = "Список кампаній, які стали неактивними через зміни налаштувань:";

// Statistics & Maintenance Settings
$GLOBALS['strMaintenanceSettings'] = "Параметри обслуговування";
$GLOBALS['strConversionTracking'] = "Налаштування відстеження конверсій";
$GLOBALS['strEnableConversionTracking'] = "Увімкнути відстеження конверсій";
$GLOBALS['strBlockInactiveBanners'] = "Не враховуйте покази оголошень, кліки та не перенаправлення користувача на цільову URL-адресу, якщо глядач натискає неактивний банер";
$GLOBALS['strBlockAdClicks'] = "Не засчитывать клик, если пользователь кликает ту же пару баннер/зона в течение указанного времени (сек.)";
$GLOBALS['strMaintenanceOI'] = "Інтервал технічного обслуговування (хвилин)";
$GLOBALS['strPrioritySettings'] = "Налаштування пріоритету";
$GLOBALS['strPriorityInstantUpdate'] = "Негайно оновлювати пріоритети реклами після внесення змін в інтерфейс користувача";
$GLOBALS['strPriorityIntentionalOverdelivery'] = "Навмисно передоставити Контрактні Кампанії<br />(% перевиконання)";
$GLOBALS['strDefaultImpConvWindow'] = "Вікно перетворення показів реклами за умовчанням (секунди)";
$GLOBALS['strDefaultCliConvWindow'] = "Вікно конверсії кліку оголошення за умовчанням (секунди)";
$GLOBALS['strAdminEmailHeaders'] = "Додайти такі заголовки до кожного повідомлення електронної пошти, надісланого {$PRODUCT_NAME}";
$GLOBALS['strWarnLimit'] = "Надсилати попередження, коли кількість показів, що залишилися, менша за вказану тут";
$GLOBALS['strWarnLimitDays'] = "Надіслати попередження, коли залишилося менше днів, ніж зазначено тут";
$GLOBALS['strWarnAdmin'] = "Надсилати попередження адміністратору щоразу, коли термін дії кампанії майже закінчився";
$GLOBALS['strWarnClient'] = "Надсилайте попередження рекламодавцю щоразу, коли термін дії кампанії майже закінчився";
$GLOBALS['strWarnAgency'] = "Надсилати попередження в обліковий запис щоразу, коли термін дії кампанії майже закінчився";

// UI Settings
$GLOBALS['strGuiSettings'] = "Налаштування інтерфейсу користувача";
$GLOBALS['strGeneralSettings'] = "Загальні налаштування";
$GLOBALS['strAppName'] = "Назва додатка";
$GLOBALS['strMyHeader'] = "Розташування файлу заголовка";
$GLOBALS['strMyFooter'] = "Розташування файлу нижнього колонтитула";
$GLOBALS['strDefaultTrackerStatus'] = "Статус трекера за замовчуванням";
$GLOBALS['strDefaultTrackerType'] = "Тип трекера за замовчуванням";
$GLOBALS['strSSLSettings'] = "Налаштування SSL";
$GLOBALS['requireSSL'] = "Примусовио встановити SSL-доступ до інтерфейсу користувача";
$GLOBALS['sslPort'] = "Порт SSL, який використовується веб-сервером";
$GLOBALS['strDashboardSettings'] = "Налаштування інформаційної панелі";
$GLOBALS['strMyLogo'] = "Ім’я/URL-адреса власного файлу логотипу";
$GLOBALS['strGuiHeaderForegroundColor'] = "Колір переднього плану заголовка";
$GLOBALS['strGuiHeaderBackgroundColor'] = "Колір фону заголовка";
$GLOBALS['strGuiActiveTabColor'] = "Колір активної вкладки";
$GLOBALS['strGuiHeaderTextColor'] = "Колір тексту в заголовку";
$GLOBALS['strGuiSupportLink'] = "Спеціальна URL-адреса для посилання «Підтримка» в заголовку";
$GLOBALS['strGzipContentCompression'] = "Використовуйте стиснення вмісту GZIP";

// Regenerate Platfor Hash script
$GLOBALS['strPlatformHashRegenerate'] = "Відновлення хешу платформи";
$GLOBALS['strNewPlatformHash'] = "Ваш новий хеш платформи:";
$GLOBALS['strPlatformHashInsertingError'] = "Помилка вставки хешу платформи в базу даних";

// Plugin Settings
$GLOBALS['strPluginSettings'] = "Налаштування плагіна";
$GLOBALS['strEnableNewPlugins'] = "Увімкнути нещодавно встановлені плагіни";
$GLOBALS['strUseMergedFunctions'] = "Використовувати об’єднаний файл функцій доставки";
