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

// Set text direction and characterset
$GLOBALS['phpAds_TextDirection'] = "ltr";
$GLOBALS['phpAds_TextAlignRight'] = "right";
$GLOBALS['phpAds_TextAlignLeft'] = "left";
$GLOBALS['phpAds_CharSet'] = "UTF-8";

$GLOBALS['phpAds_DecimalPoint'] = ".";
$GLOBALS['phpAds_ThousandsSeperator'] = ",";

// Date & time configuration
$GLOBALS['date_format'] = "%d/%m/%Y";
$GLOBALS['time_format'] = "%H:%M:%S";
$GLOBALS['minute_format'] = "%H:%M";
$GLOBALS['month_format'] = "%m-%Y";
$GLOBALS['day_format'] = "%d-%m";
$GLOBALS['week_format'] = "%W-%Y";
$GLOBALS['weekiso_format'] = "%V-%G";

// Formats used by PEAR Spreadsheet_Excel_Writer packate
$GLOBALS['excel_integer_formatting'] = "#,##0;-#,##0;-";
$GLOBALS['excel_decimal_formatting'] = "#,##0.000;-#,##0.000;-";

/* ------------------------------------------------------- */
/* Translations                                          */
/* ------------------------------------------------------- */

$GLOBALS['strHome'] = "Дом";
$GLOBALS['strHelp'] = "Допомога";
$GLOBALS['strStartOver'] = "Початок";
$GLOBALS['strShortcuts'] = "Скорочення";
$GLOBALS['strActions'] = "Дія";
$GLOBALS['strAndXMore'] = "и %s больше";
$GLOBALS['strAdminstration'] = "Адміністрування";
$GLOBALS['strMaintenance'] = "Обслуговування";
$GLOBALS['strProbability'] = "Вірогідність";
$GLOBALS['strInvocationcode'] = "Код виклику";
$GLOBALS['strBasicInformation'] = "Основна інформація";
$GLOBALS['strAppendTrackerCode'] = "Додати код трекера";
$GLOBALS['strOverview'] = "Огляд";
$GLOBALS['strSearch'] = "<u>П</u>оиск";
$GLOBALS['strDetails'] = "Докладніше";
$GLOBALS['strUpdateSettings'] = "Настройки обновления";
$GLOBALS['strCheckForUpdates'] = "Проверить обновления";
$GLOBALS['strWhenCheckingForUpdates'] = "При проверке наличия обновлений";
$GLOBALS['strCompact'] = "Компактно";
$GLOBALS['strUser'] = "Користувач";
$GLOBALS['strDuplicate'] = "Дублювати";
$GLOBALS['strCopyOf'] = "Копия";
$GLOBALS['strMoveTo'] = "Перемістити в";
$GLOBALS['strDelete'] = "Видалити";
$GLOBALS['strActivate'] = "Активувати";
$GLOBALS['strConvert'] = "Конвертувати";
$GLOBALS['strRefresh'] = "Відновити";
$GLOBALS['strSaveChanges'] = "Зберегти зміни";
$GLOBALS['strUp'] = "Вгору";
$GLOBALS['strDown'] = "Вниз";
$GLOBALS['strSave'] = "Зберегти";
$GLOBALS['strCancel'] = "Відмінити";
$GLOBALS['strBack'] = "Назад";
$GLOBALS['strPrevious'] = "Попередній";
$GLOBALS['strNext'] = "Наступний";
$GLOBALS['strYes'] = "Так";
$GLOBALS['strNo'] = "Ні";
$GLOBALS['strNone'] = "Ніхто";
$GLOBALS['strCustom'] = "Нестандартний";
$GLOBALS['strDefault'] = "За умовчанням";
$GLOBALS['strUnknown'] = "Неизвестное";
$GLOBALS['strUnlimited'] = "Не обмежено";
$GLOBALS['strUntitled'] = "Без назви";
$GLOBALS['strAll'] = "все";
$GLOBALS['strAverage'] = "В середньому";
$GLOBALS['strOverall'] = "Всього";
$GLOBALS['strTotal'] = "Разом";
$GLOBALS['strFrom'] = "С";
$GLOBALS['strTo'] = "по";
$GLOBALS['strAdd'] = "Добавить";
$GLOBALS['strLinkedTo'] = "пов'язано з";
$GLOBALS['strDaysLeft'] = "Залишилося днів";
$GLOBALS['strCheckAllNone'] = "Помітити все / нічого";
$GLOBALS['strKiloByte'] = "Кб";
$GLOBALS['strExpandAll'] = "<u>Р</u>озкрити все";
$GLOBALS['strCollapseAll'] = "<u>З</u>акрити все";
$GLOBALS['strShowAll'] = "Показати все";
$GLOBALS['strNoAdminInterface'] = "Адміністративний інтерфейс недоступний на час планового обслуговування. Це ніяк не позначається на ваших рекламних кампаніях.";
$GLOBALS['strFieldStartDateBeforeEnd'] = "\\'От' должно быть ранее даты 'До'";
$GLOBALS['strFieldContainsErrors'] = "Вказані поля містять помилки:";
$GLOBALS['strFieldFixBeforeContinue1'] = "Перш ніж ви зможете продовжити, вам необхідно";
$GLOBALS['strFieldFixBeforeContinue2'] = "для виправлення цих помилок";
$GLOBALS['strMiscellaneous'] = "Різне";
$GLOBALS['strCollectedAllStats'] = "Вся статистика";
$GLOBALS['strCollectedToday'] = "Сьогодні";
$GLOBALS['strCollectedYesterday'] = "Вчора";
$GLOBALS['strCollectedThisWeek'] = "Поточний тиждень";
$GLOBALS['strCollectedLastWeek'] = "Попередній тиждень";
$GLOBALS['strCollectedThisMonth'] = "Поточний місяць";
$GLOBALS['strCollectedLastMonth'] = "Попередній місяць";
$GLOBALS['strCollectedLast7Days'] = "За останні 7 днів";
$GLOBALS['strCollectedSpecificDates'] = "Задані дати";
$GLOBALS['strValue'] = "Значение";
$GLOBALS['strWarning'] = "Попередження";
$GLOBALS['strNotice'] = "Повідомлення";

// Dashboard
$GLOBALS['strDashboardCantBeDisplayed'] = "Лента не может быть отображена";
$GLOBALS['strNoCheckForUpdates'] = "Лента не может отобразиться, если <br /> выключена проверка на наличие обновлений.";
$GLOBALS['strEnableCheckForUpdates'] = "Пожалуйста, включите <a href='account-settings-update.php' target='_top'>проверку на наличие обновлений</a> на <br/><a href='account-settings-update.php' target='_top'>странице настроек</a>.";
// Dashboard Errors
$GLOBALS['strDashboardErrorCode'] = "код";
$GLOBALS['strDashboardSystemMessage'] = "Системное собщение";
$GLOBALS['strDashboardErrorHelp'] = "Если эта ошибка повторяется просьба описать проблему в деталях и разместить её на <a href='http://forum.openx.org/'>OpenX форуме</а>.";

// Priority
$GLOBALS['strPriority'] = "Пріоритет";
$GLOBALS['strPriorityLevel'] = "Рівень пріоритету";
$GLOBALS['strOverrideAds'] = "Override Campaign Advertisements";
$GLOBALS['strHighAds'] = "Îые кампании";
$GLOBALS['strECPMAds'] = "eCPM Campaign Advertisements";
$GLOBALS['strLowAds'] = "Ùе кампании";
$GLOBALS['strLimitations'] = "Delivery rules";
$GLOBALS['strNoLimitations'] = "No delivery rules";
$GLOBALS['strCapping'] = "Часткові обмеження";

// Properties
$GLOBALS['strName'] = "Ім'я";
$GLOBALS['strSize'] = "Розмір";
$GLOBALS['strWidth'] = "ширина";
$GLOBALS['strHeight'] = "висота";
$GLOBALS['strTarget'] = "Мета";
$GLOBALS['strLanguage'] = "Мова";
$GLOBALS['strDescription'] = "Опис";
$GLOBALS['strVariables'] = "Змінні";
$GLOBALS['strID'] = "ID";
$GLOBALS['strComments'] = "Коментарі";

// User access
$GLOBALS['strWorkingAs'] = "Работает как";
$GLOBALS['strWorkingAs_Key'] = "<u>Р</u>аботаете как";
$GLOBALS['strWorkingAs'] = "Работает как";
$GLOBALS['strSwitchTo'] = "Переключиться в";
$GLOBALS['strUseSearchBoxToFindMoreAccounts'] = "Использовать переключатель в поисковом поле для большего поиска аккаунтов";
$GLOBALS['strWorkingFor'] = "%s для…";
$GLOBALS['strNoAccountWithXInNameFound'] = "Никаких аккаунтов с именем \"%s\" не обнаружено";
$GLOBALS['strRecentlyUsed'] = "Недавно использованные";
$GLOBALS['strLinkUser'] = "Добавить пользователя";
$GLOBALS['strLinkUser_Key'] = "Привязать <u>п</u>ользователя";
$GLOBALS['strUsernameToLink'] = "Имя пользователя для ссылки";
$GLOBALS['strNewUserWillBeCreated'] = "Будет создан новый пользователь";
$GLOBALS['strToLinkProvideEmail'] = "Для связи пользователя, задайте e-mail";
$GLOBALS['strToLinkProvideUsername'] = "Для связи пользователя, задайте его имя";
$GLOBALS['strUserLinkedToAccount'] = "Пользователь добавлен к учетной записи";
$GLOBALS['strUserAccountUpdated'] = "Учетная запись обновлена";
$GLOBALS['strUserUnlinkedFromAccount'] = "Пользователь был удален из учетной записи";
$GLOBALS['strUserWasDeleted'] = "Пользователь был удален";
$GLOBALS['strUserNotLinkedWithAccount'] = "К учетной записи не привязан ни один пользователь";
$GLOBALS['strCantDeleteOneAdminUser'] = "Вы не можете удалить этого пользователя. Хотя бы один пользователь должен быть связан с учетной записью администратора.";
$GLOBALS['strLinkUserHelp'] = "Для привязки <b>существующего пользователя</b>, напишите %1\$s и нажмите %2\$s <br />Для привязки <b>нового пользователя</b> напишите желаемое %1\$s и нажмите %2\$s";
$GLOBALS['strLinkUserHelpUser'] = "Ім'я користувача";
$GLOBALS['strLinkUserHelpEmail'] = "Адрес e-mail";
$GLOBALS['strLastLoggedIn'] = "Последний вход в систему";
$GLOBALS['strDateLinked'] = "Дата привязана";

// Login & Permissions
$GLOBALS['strUserAccess'] = "Доступ пользователя";
$GLOBALS['strAdminAccess'] = "Административный доступ";
$GLOBALS['strUserProperties'] = "Параметри банера";
$GLOBALS['strPermissions'] = "Права доступа";
$GLOBALS['strAuthentification'] = "Доступ";
$GLOBALS['strWelcomeTo'] = "Ласкаво просимо в";
$GLOBALS['strEnterUsername'] = "Введіть ваш логін і пароль для входу в систему";
$GLOBALS['strEnterBoth'] = "Будь ласка, введіть логін і пароль";
$GLOBALS['strEnableCookies'] = "You need to enable cookies before you can use {$PRODUCT_NAME}";
$GLOBALS['strSessionIDNotMatch'] = "Ошибка cookie, пожалуйста, авторизуйтесь заново";
$GLOBALS['strLogin'] = "Ім'я користувача";
$GLOBALS['strLogout'] = "Вихід";
$GLOBALS['strUsername'] = "Ім'я користувача";
$GLOBALS['strPassword'] = "Пароль";
$GLOBALS['strPasswordRepeat'] = "Повторите пароль";
$GLOBALS['strAccessDenied'] = "Доступ заборонений";
$GLOBALS['strUsernameOrPasswordWrong'] = "Ім'я користувача і/або пароль, неправильні. Будь ласка, спробуйте ще раз.";
$GLOBALS['strPasswordWrong'] = "Пароль вказаний невірно";
$GLOBALS['strNotAdmin'] = "Ваш аккаунт не имеет необходимых полномочий, но вы можете войти под другим именем. Нажмите <a href='logout.php'>здесь</a> для входа под другим именем.";
$GLOBALS['strDuplicateClientName'] = "Вказане ім'я користувача вже існує, будь ласка введіть інше ім'я.";
$GLOBALS['strInvalidPassword'] = "Новий пароль невірний, будь ласка, використовуйте інший пароль.";
$GLOBALS['strInvalidEmail'] = "Этот e-mail имеет некорректный формат";
$GLOBALS['strNotSamePasswords'] = "Введені Вами паролі не співпадають";
$GLOBALS['strRepeatPassword'] = "Повторите пароль";
$GLOBALS['strDeadLink'] = "Ваша ссылка некорректна";
$GLOBALS['strNoPlacement'] = "Выбранная кампания не существует. Попробуйте нажать на <a href='{link}'>эту ссылку</a>";
$GLOBALS['strNoAdvertiser'] = "Выбранный рекламодатель не существует. Попробуйте нажать на <a href='{link}'>эту ссылку</a>";

// General advertising
$GLOBALS['strRequests'] = "Запитів";
$GLOBALS['strImpressions'] = "Показів";
$GLOBALS['strClicks'] = "Кліков";
$GLOBALS['strConversions'] = "Переходів";
$GLOBALS['strCTRShort'] = "CTR";
$GLOBALS['strCNVRShort'] = "SR";
$GLOBALS['strCTR'] = "CTR";
$GLOBALS['strTotalClicks'] = "Всього кліков";
$GLOBALS['strTotalConversions'] = "Всього переходів";
$GLOBALS['strDateTime'] = "Дата і час";
$GLOBALS['strTrackerID'] = "ID трекера";
$GLOBALS['strTrackerName'] = "Назва трекера";
$GLOBALS['strTrackerImageTag'] = "Метка изображения";
$GLOBALS['strTrackerJsTag'] = "Метка JavaScript";
$GLOBALS['strTrackerAlwaysAppend'] = "Всегда отображать добавленные код, даже если преобразование не регистрируется трекером?";
$GLOBALS['strBanners'] = "Банери";
$GLOBALS['strCampaigns'] = "Кампанія";
$GLOBALS['strCampaignID'] = "ID кампанії";
$GLOBALS['strCampaignName'] = "Назва кампанії";
$GLOBALS['strCountry'] = "Країна";
$GLOBALS['strStatsAction'] = "Дія";
$GLOBALS['strWindowDelay'] = "Затримка вікна";
$GLOBALS['strStatsVariables'] = "Змінні";

// Finance
$GLOBALS['strFinanceCPM'] = "CPM (ціна 1000 показів)";
$GLOBALS['strFinanceCPC'] = "CPC (ціна кліка)";
$GLOBALS['strFinanceCPA'] = "CPA (ціна дії)";
$GLOBALS['strFinanceMT'] = "Ціна місяця розміщення";
$GLOBALS['strFinanceCTR'] = "CTR";
$GLOBALS['strFinanceCR'] = "CR";

// Time and date related
$GLOBALS['strDate'] = "Дата";
$GLOBALS['strDay'] = "День";
$GLOBALS['strDays'] = "Днів";
$GLOBALS['strWeek'] = "Тиждень";
$GLOBALS['strWeeks'] = "Тижнів";
$GLOBALS['strSingleMonth'] = "Місяць";
$GLOBALS['strMonths'] = "Місяців";
$GLOBALS['strDayOfWeek'] = "День тижня";


if (!isset($GLOBALS['strDayFullNames'])) {
    $GLOBALS['strDayFullNames'] = array();
}
$GLOBALS['strDayFullNames'][0] = 'Воскресение';
$GLOBALS['strDayFullNames'][1] = 'Понедельник';
$GLOBALS['strDayFullNames'][2] = 'Вторник';
$GLOBALS['strDayFullNames'][3] = 'Среда';
$GLOBALS['strDayFullNames'][4] = 'Четверг';
$GLOBALS['strDayFullNames'][5] = 'Пятница';
$GLOBALS['strDayFullNames'][6] = 'Суббота';

if (!isset($GLOBALS['strDayShortCuts'])) {
    $GLOBALS['strDayShortCuts'] = array();
}
$GLOBALS['strDayShortCuts'][0] = 'Вс';
$GLOBALS['strDayShortCuts'][1] = 'Пн';
$GLOBALS['strDayShortCuts'][2] = 'Вт';
$GLOBALS['strDayShortCuts'][3] = 'Ср';
$GLOBALS['strDayShortCuts'][4] = 'Чт';
$GLOBALS['strDayShortCuts'][5] = 'Пт';
$GLOBALS['strDayShortCuts'][6] = 'Сб';

$GLOBALS['strHour'] = "година";
$GLOBALS['strSeconds'] = "секунд";
$GLOBALS['strMinutes'] = "хвилин";
$GLOBALS['strHours'] = "годин";

// Advertiser
$GLOBALS['strClient'] = "Клієнт";
$GLOBALS['strClients'] = "Клієнти";
$GLOBALS['strClientsAndCampaigns'] = "Клієнти і кампанії";
$GLOBALS['strAddClient'] = "Додати клієнта";
$GLOBALS['strClientProperties'] = "Параметри клієнта";
$GLOBALS['strClientHistory'] = "Advertiser Statistics";
$GLOBALS['strNoClients'] = "в даний час не визначено жодного клієнта. Для створення кампанії необхідно спочатку <a href='advertiser-edit.php'>додати клієнта</a>.";
$GLOBALS['strConfirmDeleteClient'] = "Ви дійсно хочете видалити цього клієнта?";
$GLOBALS['strConfirmDeleteClients'] = "Ви дійсно хочете видалити цього клієнта?";
$GLOBALS['strHideInactive'] = "Приховати неактивні";
$GLOBALS['strInactiveAdvertisersHidden'] = "неактивні клієнти приховані";
$GLOBALS['strAdvertiserSignup'] = "Регистрация рекламодателя";
$GLOBALS['strAdvertiserCampaigns'] = "Клієнти і кампанії";

// Advertisers properties
$GLOBALS['strContact'] = "Контакт";
$GLOBALS['strContactName'] = "Имя";
$GLOBALS['strEMail'] = "E-mail";
$GLOBALS['strSendAdvertisingReport'] = "Посилати рекламний звіт по E-mail";
$GLOBALS['strNoDaysBetweenReports'] = "Кількість днів між звітами";
$GLOBALS['strSendDeactivationWarning'] = "Посилати попередження, коли кампанія деактивує";
$GLOBALS['strAllowClientModifyBanner'] = "Дозволити модифікувати власні банери";
$GLOBALS['strAllowClientDisableBanner'] = "Дозволити деактивувати його банери";
$GLOBALS['strAllowClientActivateBanner'] = "Дозволити активувати його банери";
$GLOBALS['strAllowCreateAccounts'] = "Allow this user to manage this account's users";
$GLOBALS['strAdvertiserLimitation'] = "Показывать только один баннер этого рекламодателя на странице";
$GLOBALS['strAllowAuditTrailAccess'] = "разрешить этому пользователю доступ к аудиту";
$GLOBALS['strAllowDeleteItems'] = "Allow this user to delete items";

// Campaign
$GLOBALS['strCampaign'] = "Кампанія";
$GLOBALS['strCampaigns'] = "Кампанія";
$GLOBALS['strAddCampaign'] = "Додати нову кампанію";
$GLOBALS['strAddCampaign_Key'] = "Додати <u>н</u>ову кампанію";
$GLOBALS['strCampaignForAdvertiser'] = "для рекламодателя";
$GLOBALS['strLinkedCampaigns'] = "Зв'язані кампанії";
$GLOBALS['strCampaignProperties'] = "Параметри кампанії";
$GLOBALS['strCampaignOverview'] = "Огляд кампанії";
$GLOBALS['strCampaignHistory'] = "Campaign Statistics";
$GLOBALS['strNoCampaigns'] = "В настоящее время нет активных кампаний";
$GLOBALS['strNoCampaignsAddAdvertiser'] = "В настоящее время не определено ни одной компании, потому что нет рекламодателей. Для созданий компании, сначала <a href='advertiser-edit.php'>добавьте нового рекламодателя</a>.";
$GLOBALS['strConfirmDeleteCampaign'] = "Ви дійсно хочете видалити цю кампанію?";
$GLOBALS['strConfirmDeleteCampaigns'] = "Ви дійсно хочете видалити цю кампанію?";
$GLOBALS['strShowParentAdvertisers'] = "Показати зв'язаних клієнтів";
$GLOBALS['strHideParentAdvertisers'] = "Приховати зв'язаних клієнтів";
$GLOBALS['strHideInactiveCampaigns'] = "Приховати неактивні кампанії";
$GLOBALS['strInactiveCampaignsHidden'] = "неактивні кампаня(ії) приховані";
$GLOBALS['strPriorityInformation'] = "Пріоритет по відношенню до інших кампаній";
$GLOBALS['strECPMInformation'] = "eCPM приоритеты ";
$GLOBALS['strRemnantEcpmDescription'] = "eCPM вычисляется автоматически на основании производительности этой компании. <br /> Этот раздел будет использоваться для приоритезации остатка кампаний относительно друг друга.";
$GLOBALS['strEcpmMinImpsDescription'] = "Установите желаемую Вами основу для вычисления eCPM этой компании.";
$GLOBALS['strHiddenCampaign'] = "Кампанія";
$GLOBALS['strHiddenAd'] = "Банер";
$GLOBALS['strHiddenAdvertiser'] = "Клієнт";
$GLOBALS['strHiddenTracker'] = "Трекер";
$GLOBALS['strHiddenWebsite'] = "Вебсайт";
$GLOBALS['strHiddenZone'] = "Зона";
$GLOBALS['strCampaignDelivery'] = "Доходы компании";
$GLOBALS['strCompanionPositioning'] = "Сумісне розміщення банерів цієї кампанії";
$GLOBALS['strSelectUnselectAll'] = "Вибрати все / Зняти виділення";
$GLOBALS['strCampaignsOfAdvertiser'] = "из"; //this is added between page name and advertiser name eg. 'Campaigns of Advertiser 1'
$GLOBALS['strShowCappedNoCookie'] = "Show capped ads if cookies are disabled";

// Campaign-zone linking page
$GLOBALS['strCalculatedForAllCampaigns'] = "Calculated for all campaigns";
$GLOBALS['strCalculatedForThisCampaign'] = "Calculated for this campaign";
$GLOBALS['strLinkingZonesProblem'] = "Problem occurred when linking zones";
$GLOBALS['strUnlinkingZonesProblem'] = "Problem occurred when unlinking zones";
$GLOBALS['strZonesLinked'] = "zone(s) linked";
$GLOBALS['strZonesUnlinked'] = "zone(s) unlinked";
$GLOBALS['strZonesSearch'] = "Search";
$GLOBALS['strZonesSearchTitle'] = "Search zones and websites by name";
$GLOBALS['strNoWebsitesAndZones'] = "No websites and zones";
$GLOBALS['strNoWebsitesAndZonesText'] = "with \"%s\" in name";
$GLOBALS['strToLink'] = "to link";
$GLOBALS['strToUnlink'] = "to unlink";
$GLOBALS['strLinked'] = "Linked";
$GLOBALS['strAvailable'] = "Available";
$GLOBALS['strShowing'] = "Showing";
$GLOBALS['strEditZone'] = "Edit zone";
$GLOBALS['strEditWebsite'] = "Edit website";


// Campaign properties
$GLOBALS['strDontExpire'] = "Не деактивировать";
$GLOBALS['strActivateNow'] = "Немедленно активировать";
$GLOBALS['strSetSpecificDate'] = "Set specific date";
$GLOBALS['strLow'] = "Низький";
$GLOBALS['strHigh'] = "Високий";
$GLOBALS['strExpirationDate'] = "Дата окончания";
$GLOBALS['strExpirationDateComment'] = "Кампанія закінчиться в кінці цього дня";
$GLOBALS['strActivationDate'] = "Дата начала";
$GLOBALS['strActivationDateComment'] = "Кампанія почнеться на початку цього дня";
$GLOBALS['strImpressionsRemaining'] = "Залишилося показів";
$GLOBALS['strClicksRemaining'] = "Залишилося кліков";
$GLOBALS['strConversionsRemaining'] = "Залишилося дій";
$GLOBALS['strImpressionsBooked'] = "Замовлено показів";
$GLOBALS['strClicksBooked'] = "Замовлене кліков";
$GLOBALS['strConversionsBooked'] = "Замовлено дій";
$GLOBALS['strCampaignWeight'] = "Вес кампании";
$GLOBALS['strAnonymous'] = "Приховати клієнта і сайти цієї кампанії";
$GLOBALS['strTargetPerDay'] = "у день.";
$GLOBALS['strCampaignWarningRemnantNoWeight'] = "The type of this campaign has been set to Remnant,
but the weight is set to zero or it has not been
specified. This will cause the campaign to be
deactivated and its banners won't be delivered
until the weight has been set to a valid number.

Are you sure you want to continue?";
$GLOBALS['strCampaignWarningEcpmNoRevenue'] = "This campaign uses eCPM optimisation
but the 'revenue' is set to zero or it has not been specified.
This will cause the campaign to be deactivated
and its banners won't be delivered until the
revenue has been set to a valid number.

Are you sure you want to continue?";
$GLOBALS['strCampaignWarningOverrideNoWeight'] = "The type of this campaign has been set to Override,
but the weight is set to zero or it has not been
specified. This will cause the campaign to be
deactivated and its banners won't be delivered
until the weight has been set to a valid number.

Are you sure you want to continue?";
$GLOBALS['strCampaignWarningNoTarget'] = "The type of this campaign has been set to Contract,
but Limit per day is not specified.
This will cause the campaign to be deactivated and
its banners won't be delivered until a valid Limit per day has been set.

Are you sure you want to continue?";
$GLOBALS['strCampaignStatusPending'] = "Ожидают";
$GLOBALS['strCampaignStatusInactive'] = "активний";
$GLOBALS['strCampaignStatusRunning'] = "Запущен ";
$GLOBALS['strCampaignStatusPaused'] = "Припинити";
$GLOBALS['strCampaignStatusAwaiting'] = "Ожидает";
$GLOBALS['strCampaignStatusExpired'] = "Завершен";
$GLOBALS['strCampaignStatusApproval'] = "Ожидает подтверждения";
$GLOBALS['strCampaignStatusRejected'] = "Отклонен";
$GLOBALS['strCampaignStatusAdded'] = "Добавлен";
$GLOBALS['strCampaignStatusStarted'] = "Стартовал";
$GLOBALS['strCampaignStatusRestarted'] = "Перезапустити";
$GLOBALS['strCampaignStatusDeleted'] = "Видалити";
$GLOBALS['strCampaignType'] = "Назва кампанії";
$GLOBALS['strType'] = "Тип";
$GLOBALS['strContract'] = "Контакт";
$GLOBALS['strOverride'] = "Override";
$GLOBALS['strOverrideInfo'] = "Override campaigns are a special campaign type specifically to
    override (i.e. take priority over) Remnant and Contract campaigns. Override campaigns are generally used with
    specific targeting and/or capping rules to ensure that the campaign banners are always displayed in certain
    locations, to certain users, and perhaps a certain number of times, as part of a specific promotion. (This campaign
    type was previously known as 'Contract (Exclusive)'.)";
$GLOBALS['strStandardContract'] = "Контакт";
$GLOBALS['strStandardContractInfo'] = "Contract campaigns are for smoothly delivering the impressions
    required to achieve a specified time-critical performance requirement. That is, Contract campaigns are for when
    an advertiser has paid specifically to have a given number of impressions, clicks and/or conversions to be
    achieved either between two dates, or per day.";
$GLOBALS['strRemnant'] = "Remnant";
$GLOBALS['strRemnantInfo'] = "The default campaign type. Remnant campaigns have lots of different
    delivery options, and you should ideally always have at least one Remnant campaign linked to every zone, to ensure
    that there is always something to show. Use Remnant campaigns to display house banners, ad-network banners, or even
    direct advertising that has been sold, but where there is not a time-critical performance requirement for the
    campaign to adhere to.";
$GLOBALS['strECPMInfo'] = "This is a standard campaign which can be constrained with either an end date or a specific limit. Based on current settings it will be prioritised using eCPM.";
$GLOBALS['strPricing'] = "Pricing";
$GLOBALS['strPricingModel'] = "Pricing model";
$GLOBALS['strSelectPricingModel'] = "-- select model --";
$GLOBALS['strRatePrice'] = "Rate / Price";
$GLOBALS['strMinimumImpressions'] = "Minimum daily impressions";
$GLOBALS['strLimit'] = "Limit";
$GLOBALS['strLowExclusiveDisabled'] = "You cannot change this campaign to Remnant or Exclusive, since both an end date and either of impressions/clicks/conversions limit are set. <br>In order to change type, you need to set no expiry date or remove limits.";
$GLOBALS['strCannotSetBothDateAndLimit'] = "You cannot set both an end date and limit for a Remnant or Exclusive campaign.<br>If you need to set both an end date and limit impressions/clicks/conversions please use a non-exclusive Contract campaign.";
$GLOBALS['strWhyDisabled'] = "why is it disabled?";
$GLOBALS['strBackToCampaigns'] = "Back to campaigns";
$GLOBALS['strCampaignBanners'] = "Campaign's banners";
$GLOBALS['strCookies'] = "Cookies";

// Tracker
$GLOBALS['strTracker'] = "Трекер";
$GLOBALS['strTrackers'] = "Трекер";
$GLOBALS['strTrackerPreferences'] = "Предпочтения трекера";
$GLOBALS['strAddTracker'] = "Додати трекер";
$GLOBALS['strTrackerForAdvertiser'] = "для рекламодателя";
$GLOBALS['strNoTrackers'] = "Трекеры не определены";
$GLOBALS['strConfirmDeleteTrackers'] = "Ви дійсно хочете видалити цей трекер?";
$GLOBALS['strConfirmDeleteTracker'] = "Ви дійсно хочете видалити цей трекер?";
$GLOBALS['strTrackerProperties'] = "Властивості трекера";
$GLOBALS['strDefaultStatus'] = "Статус за умовчанням";
$GLOBALS['strStatus'] = "Статус";
$GLOBALS['strLinkedTrackers'] = "Зв'язані трекери";
$GLOBALS['strTrackerInformation'] = "Tracker Information";
$GLOBALS['strConversionWindow'] = "Період дії";
$GLOBALS['strUniqueWindow'] = "Період унікального користувача";
$GLOBALS['strClick'] = "Клік";
$GLOBALS['strView'] = "Показ";
$GLOBALS['strArrival'] = "Arrival";
$GLOBALS['strManual'] = "Manual";
$GLOBALS['strImpression'] = "Impression";
$GLOBALS['strConversionType'] = "Тип конверсії";
$GLOBALS['strLinkCampaignsByDefault'] = "За умовчанням пов'язувати з новими кампаніями";
$GLOBALS['strBackToTrackers'] = "Back to trackers";
$GLOBALS['strIPAddress'] = "IP Address";

// Banners (General)
$GLOBALS['strBanner'] = "Банер";
$GLOBALS['strBanners'] = "Банери";
$GLOBALS['strAddBanner'] = "Додати новий банер";
$GLOBALS['strAddBanner_Key'] = "Додати <u>н</u>овый банер";
$GLOBALS['strBannerToCampaign'] = "Ваша кампания";
$GLOBALS['strShowBanner'] = "Показати банер";
$GLOBALS['strBannerProperties'] = "Параметри банера";
$GLOBALS['strBannerHistory'] = "Banner Statistics";
$GLOBALS['strNoBanners'] = "Нет баннеров";
$GLOBALS['strNoBannersAddCampaign'] = "В настоящее время не определено ни одного веб-сайта. Для создания зоны необходимо сначала<a href='affiliate-edit.php'>создать веб-сайт</a>.";
$GLOBALS['strNoBannersAddAdvertiser'] = "в даний час не визначено жодного клієнта. Для створення кампанії необхідно спочатку <а href='advertiser-edit.php'>додати клієнта</a>.";
$GLOBALS['strConfirmDeleteBanner'] = "Ви дійсно хочете видалити цей банер?";
$GLOBALS['strConfirmDeleteBanners'] = "Ви дійсно хочете видалити цей банер?";
$GLOBALS['strShowParentCampaigns'] = "Показати зв'язані кампанії";
$GLOBALS['strHideParentCampaigns'] = "Приховати зв'язані кампанії";
$GLOBALS['strHideInactiveBanners'] = "Приховати неактивні банери";
$GLOBALS['strInactiveBannersHidden'] = "неактивний банер(ы) прихований";
$GLOBALS['strWarningMissing'] = "Увага, можливо відсутній";
$GLOBALS['strWarningMissingClosing'] = " закриваючий тег \">\"";
$GLOBALS['strWarningMissingOpening'] = " відкриваючий тег \"<\"";
$GLOBALS['strSubmitAnyway'] = "Зберегти як є";
$GLOBALS['strBannersOfCampaign'] = "в"; //this is added between page name and campaign name eg. 'Banners in coca cola campaign'

// Banner Preferences
$GLOBALS['strBannerPreferences'] = "Предпочтения баннера";
$GLOBALS['strCampaignPreferences'] = "Campaign Preferences";
$GLOBALS['strDefaultBanners'] = "Default Banners";
$GLOBALS['strDefaultBannerUrl'] = "Стандартный URL-изображения";
$GLOBALS['strDefaultBannerDestination'] = "Стандартный URL-адрес назначения";
$GLOBALS['strAllowedBannerTypes'] = "Допустимые типы баннеров";
$GLOBALS['strTypeSqlAllow'] = "Разрешить местные баннеры SQL";
$GLOBALS['strTypeWebAllow'] = "Разрешить локальные баннеры веб-сервера";
$GLOBALS['strTypeUrlAllow'] = "Разрешить внешние баннеры";
$GLOBALS['strTypeHtmlAllow'] = "Разрешить HTML баннеры";
$GLOBALS['strTypeTxtAllow'] = "Разрешить текстовые объявления";

// Banner (Properties)
$GLOBALS['strChooseBanner'] = "Виберіть тип банера.";
$GLOBALS['strMySQLBanner'] = "Баннер с вашего компьютера помещается в базу данных на сервере";
$GLOBALS['strWebBanner'] = "Баннер с вашего компьютера сохраняется в каталоге на веб-сервере";
$GLOBALS['strURLBanner'] = "Баннер лежит где-то в Интернет";
$GLOBALS['strHTMLBanner'] = "HTML-баннер";
$GLOBALS['strTextBanner'] = "Текстовый баннер";
$GLOBALS['strAlterHTML'] = "Изменить HTML для включения отслеживания кликов для:";
$GLOBALS['strIframeFriendly'] = "Этот баннер может безопасно отображаться в iframe (например, не расширяясь)";
$GLOBALS['strUploadOrKeep'] = "Хочете зберегти уже<br>имеющуюся картинку: або хочете <br>загрузить іншу?";
$GLOBALS['strNewBannerFile'] = "Виберіть зображення, яке Ви хочете <Br /> використовувати для цього банера <Br /> <br />";
$GLOBALS['strNewBannerFileAlt'] = "Виберіть зображення для показу <br />в тому випадку, якщо браузер клієнта <br />не підтримує Rich Media<br /><br />";
$GLOBALS['strNewBannerURL'] = "URL зображення (з http://)";
$GLOBALS['strURL'] = "URL переходу (з http://)";
$GLOBALS['strKeyword'] = "Ключове слово (латиницею і цифрами)";
$GLOBALS['strTextBelow'] = "Текст під картинкою";
$GLOBALS['strWeight'] = "Вага";
$GLOBALS['strAlt'] = "Alt-Tекст";
$GLOBALS['strStatusText'] = "Текст в рядку стану";
$GLOBALS['strCampaignsWeight'] = "Campaign's Weight";
$GLOBALS['strBannerWeight'] = "Вага банера";
$GLOBALS['strBannersWeight'] = "Banner's Weight";
$GLOBALS['strAdserverTypeGeneric'] = "Простій HTML-банер";
$GLOBALS['strDoNotAlterHtml'] = "Не изменять HTML";
$GLOBALS['strGenericOutputAdServer'] = "Простій";
$GLOBALS['strBackToBanners'] = "Вернуться к баннерам";
$GLOBALS['strUseWyswygHtmlEditor'] = "Use WYSIWYG HTML Editor";
$GLOBALS['strChangeDefault'] = "Change default";

// Banner (advanced)
$GLOBALS['strBannerPrependHTML'] = "Всегда вставляйте следующий HTML-код для этого баннера";
$GLOBALS['strBannerAppendHTML'] = "Всегда добавляйте следующий HTML-код для этого баннера";

// Display Delviery Rules
$GLOBALS['strModifyBannerAcl'] = "Ограничения показа";
$GLOBALS['strACL'] = "Ограничения показа";
$GLOBALS['strACLAdd'] = "Add delivery rule";
$GLOBALS['strApplyLimitationsTo'] = "Apply delivery rules to";
$GLOBALS['strAllBannersInCampaign'] = "Все баннеры в этой компании";
$GLOBALS['strRemoveAllLimitations'] = "Remove all delivery rules";
$GLOBALS['strEqualTo'] = "равно";
$GLOBALS['strDifferentFrom'] = "отличается от";
$GLOBALS['strLaterThan'] = "is later than";
$GLOBALS['strLaterThanOrEqual'] = "is later than or equal to";
$GLOBALS['strEarlierThan'] = "is earlier than";
$GLOBALS['strEarlierThanOrEqual'] = "is earlier than or equal to";
$GLOBALS['strContains'] = "содержит";
$GLOBALS['strNotContains'] = "doesn't contain";
$GLOBALS['strGreaterThan'] = "больше чем";
$GLOBALS['strLessThan'] = "меньше чем";
$GLOBALS['strGreaterOrEqualTo'] = "is greater or equal to";
$GLOBALS['strLessOrEqualTo'] = "is less or equal to";
$GLOBALS['strAND'] = "И";                          // logical operator
$GLOBALS['strOR'] = "ИЛИ";                         // logical operator
$GLOBALS['strOnlyDisplayWhen'] = "Показывать этот баннер только когда:";
$GLOBALS['strWeekDays'] = "Дни недели";
$GLOBALS['strTime'] = "Время";
$GLOBALS['strDomain'] = "Domain";
$GLOBALS['strSource'] = "Источник";
$GLOBALS['strBrowser'] = "Browser";
$GLOBALS['strOS'] = "OS";
$GLOBALS['strDeliveryLimitations'] = "Delivery Rules";

$GLOBALS['strDeliveryCappingReset'] = "Сбросить счетчик показов после:";
$GLOBALS['strDeliveryCappingTotal'] = "всего";
$GLOBALS['strDeliveryCappingSession'] = "за сессию";

if (!isset($GLOBALS['strCappingBanner'])) {
    $GLOBALS['strCappingBanner'] = array();
}
$GLOBALS['strCappingBanner']['title'] = "Ограничения показа на посетителя";
$GLOBALS['strCappingBanner']['limit'] = "Лимит показов баннера:";

if (!isset($GLOBALS['strCappingCampaign'])) {
    $GLOBALS['strCappingCampaign'] = array();
}
$GLOBALS['strCappingCampaign']['title'] = "Ограничения показа на посетителя";
$GLOBALS['strCappingCampaign']['limit'] = "Лимит показов кампании:";

if (!isset($GLOBALS['strCappingZone'])) {
    $GLOBALS['strCappingZone'] = array();
}
$GLOBALS['strCappingZone']['title'] = "Ограничения показа на посетителя";
$GLOBALS['strCappingZone']['limit'] = "Лимит показов зоны:";

// Website
$GLOBALS['strAffiliate'] = "Вебсайт";
$GLOBALS['strAffiliates'] = "Вебсайт";
$GLOBALS['strAffiliatesAndZones'] = "Сайты и зоны";
$GLOBALS['strAddNewAffiliate'] = "Добавить новый сайт";
$GLOBALS['strAffiliateProperties'] = "Свойства сайта";
$GLOBALS['strAffiliateHistory'] = "Website Statistics";
$GLOBALS['strNoAffiliates'] = "в даний час не визначено жодного клієнта. Для створення кампанії необхідно спочатку <а href='advertiser-edit.php'>додати клієнта</a>.";
$GLOBALS['strConfirmDeleteAffiliate'] = "Ви дійсно хочете видалити цього клієнта?";
$GLOBALS['strConfirmDeleteAffiliates'] = "Ви дійсно хочете видалити цього клієнта?";
$GLOBALS['strInactiveAffiliatesHidden'] = "неактивні клієнти приховані";
$GLOBALS['strShowParentAffiliates'] = "Показать связанные сайты";
$GLOBALS['strHideParentAffiliates'] = "Скрыть связанные сайты";

// Website (properties)
$GLOBALS['strWebsite'] = "Вебсайт";
$GLOBALS['strWebsiteURL'] = "URL Веб-сайта";
$GLOBALS['strAllowAffiliateModifyZones'] = "Дозволити модифікувати власні банери";
$GLOBALS['strAllowAffiliateLinkBanners'] = "Разрешить связывать баннеры с его собственными зонами";
$GLOBALS['strAllowAffiliateAddZone'] = "Разрешить определять новые зоны";
$GLOBALS['strAllowAffiliateDeleteZone'] = "Разрешить удалять существующие зоны";
$GLOBALS['strAllowAffiliateGenerateCode'] = "Разрешить генерировать код вызова";

// Website (properties - payment information)
$GLOBALS['strPostcode'] = "Почтовый индекс";
$GLOBALS['strCountry'] = "Країна";

// Website (properties - other information)
$GLOBALS['strWebsiteZones'] = "Сайты и зоны";

// Zone
$GLOBALS['strZone'] = "Зона";
$GLOBALS['strZones'] = "Ніхто";
$GLOBALS['strAddNewZone'] = "Добавить новую зону";
$GLOBALS['strAddNewZone_Key'] = "Додати <u>н</u>овый банер";
$GLOBALS['strZoneToWebsite'] = "Ни один веб-сайт";
$GLOBALS['strLinkedZones'] = "Связанные зоны";
$GLOBALS['strAvailableZones'] = "Доступные зоны";
$GLOBALS['strLinkingNotSuccess'] = "Связывание не удалось, попробуйте еще раз";
$GLOBALS['strZoneProperties'] = "Параметри банера";
$GLOBALS['strZoneHistory'] = "История зон";
$GLOBALS['strNoZones'] = "Сейчас не определено ни одной зоны";
$GLOBALS['strNoZonesAddWebsite'] = "в даний час не визначено жодного клієнта. Для створення кампанії необхідно спочатку <а href='advertiser-edit.php'>додати клієнта</a>.";
$GLOBALS['strConfirmDeleteZone'] = "Ви дійсно хочете видалити цього клієнта?";
$GLOBALS['strConfirmDeleteZones'] = "Ви дійсно хочете видалити цього клієнта?";
$GLOBALS['strConfirmDeleteZoneLinkActive'] = "С выбранной зоной связаны платные кампании. Если вы удалите эту зону - платные кампании остановятся и вы не получите за них денег.";
$GLOBALS['strZoneType'] = "Тип зоны";
$GLOBALS['strBannerButtonRectangle'] = "Баннер, кнопка или область";
$GLOBALS['strInterstitial'] = "Rich-Media и HTML баннеры";
$GLOBALS['strPopup'] = "Pop-Up";
$GLOBALS['strTextAdZone'] = "Текстовий банер";
$GLOBALS['strEmailAdZone'] = "Баннер в рассылке";
$GLOBALS['strZoneVideoInstream'] = "Встроенная видео реклама";
$GLOBALS['strZoneVideoOverlay'] = "Наложенная видео реклама";
$GLOBALS['strShowMatchingBanners'] = "Показать подходящие баннеры";
$GLOBALS['strHideMatchingBanners'] = "Скрыть подходящие баннеры";
$GLOBALS['strBannerLinkedAds'] = "Связанные баннеры";
$GLOBALS['strCampaignLinkedAds'] = "Связанные кампании";
$GLOBALS['strInactiveZonesHidden'] = "неактивні клієнти приховані";
$GLOBALS['strWarnChangeZoneType'] = "При смене типа зоны на \"текст\" или \"е-мэйл\" все связи с баннерами и кампаниями будут потеряны                                                <ul>";
$GLOBALS['strWarnChangeZoneSize'] = 'Изменение размеров зоны повлечет отключение текущих баннеров и подключение баннеров подходящего размера из связанных кампаний';
$GLOBALS['strWarnChangeBannerSize'] = 'Изменение размеров баннера приведет к тому, что он будет перемещен в зоны, подходящие под новый размер.';
$GLOBALS['strWarnBannerReadonly'] = 'Этот баннер доступен только для чтения, потому что расширение было выключено. Обратитесь к Вашему системному администратору для получения дополнительной информации.';
$GLOBALS['strZonesOfWebsite'] = 'в'; //this is added between page name and website name eg. 'Zones in www.example.com'
$GLOBALS['strBackToZones'] = "Вернуться к зонам";

$GLOBALS['strIab']['IAB_FullBanner(468x60)'] = "Полный баннер IAB (468 x 60)";
$GLOBALS['strIab']['IAB_Skyscraper(120x600)'] = "IAB Skyscraper (120 x 600)";
$GLOBALS['strIab']['IAB_Leaderboard(728x90)'] = "IAB Leaderboard (728 x 90)";
$GLOBALS['strIab']['IAB_Button1(120x90)'] = "IAB Button 1 (120 x 90)";
$GLOBALS['strIab']['IAB_Button2(120x60)'] = "IAB Button 2 (120 x 60)";
$GLOBALS['strIab']['IAB_HalfBanner(234x60)'] = "IAB Half Banner (234 x 60)";
$GLOBALS['strIab']['IAB_MicroBar(88x31)'] = "IAB Micro Bar (88 x 31)";
$GLOBALS['strIab']['IAB_SquareButton(125x125)'] = "IAB Square Button (125 x 125)";
$GLOBALS['strIab']['IAB_Rectangle(180x150)*'] = "IAB Rectangle (180 x 150)";
$GLOBALS['strIab']['IAB_SquarePop-up(250x250)'] = "IAB Square Pop-up (250 x 250)";
$GLOBALS['strIab']['IAB_VerticalBanner(120x240)'] = "IAB Vertical Banner (120 x 240)";
$GLOBALS['strIab']['IAB_MediumRectangle(300x250)*'] = "IAB Medium Rectangle (300 x 250)";
$GLOBALS['strIab']['IAB_LargeRectangle(336x280)'] = "IAB Large Rectangle (336 x 280)";
$GLOBALS['strIab']['IAB_VerticalRectangle(240x400)'] = "IAB Vertical Rectangle (240 x 400)";
$GLOBALS['strIab']['IAB_WideSkyscraper(160x600)*'] = "IAB Wide Skyscraper (160 x 600)";
$GLOBALS['strIab']['IAB_Pop-Under(720x300)'] = "IAB Pop-Under (720 x 300)";
$GLOBALS['strIab']['IAB_3:1Rectangle(300x100)'] = "IAB 3:1 Rectangle (300 x 100)";

// Advanced zone settings
$GLOBALS['strAdvanced'] = "Дополнительно";
$GLOBALS['strChainSettings'] = "Настройки цепочки";
$GLOBALS['strZoneNoDelivery'] = "Если в этой зоне нет баннерных показов…";
$GLOBALS['strZoneStopDelivery'] = "Остановить показы";
$GLOBALS['strZoneOtherZone'] = "Показывать баннеры из указанной зоны";
$GLOBALS['strZoneAppend'] = "Всегда добавлять следующий HTML-код к баннерам в этой зоне";
$GLOBALS['strAppendSettings'] = "Настройки включений";
$GLOBALS['strZonePrependHTML'] = "Всегда добавлять следующий HTML-код ДО текстового баннера в этой зоне";
$GLOBALS['strZoneAppendNoBanner'] = "Добавлять HTML-код даже если нет баннерных показов";
$GLOBALS['strZoneAppendHTMLCode'] = "HTML-код";
$GLOBALS['strZoneAppendZoneSelection'] = "Pop-Up или \"плавающий\" баннер";

// Zone probability
$GLOBALS['strZoneProbListChain'] = "Все баннеры, связанные с выбранной зоной, неактивны. Цепь вызова зон, которая будет использована:";
$GLOBALS['strZoneProbNullPri'] = "Все баннеры, связанные с этой зоной, неактивны";
$GLOBALS['strZoneProbListChainLoop'] = "Указанная цепочка генерирует замкнутый цикл. Доставка баннеров для этой зоны прекращена.";

// Linked banners/campaigns/trackers
$GLOBALS['strSelectZoneType'] = "Пожалуйста, выберите тип связи баннеров";
$GLOBALS['strLinkedBanners'] = "Связь отдельных баннеров";
$GLOBALS['strCampaignDefaults'] = "Связь баннеров по кампаниям";
$GLOBALS['strLinkedCategories'] = "Связь баннеров по категориям";
$GLOBALS['strWithXBanners'] = "%d баннер(ы)";
$GLOBALS['strRawQueryString'] = "Ключове слово (латиницею і цифрами)";
$GLOBALS['strIncludedBanners'] = "Связанные баннеры";
$GLOBALS['strMatchingBanners'] = "{count} подходящих баннеров";
$GLOBALS['strNoCampaignsToLink'] = "Нет кампаний для связи с данной зоной";
$GLOBALS['strNoTrackersToLink'] = "Нет трекеров для связи с данной кампанией";
$GLOBALS['strNoZonesToLinkToCampaign'] = "Нет зон для связи с данной кампанией";
$GLOBALS['strSelectBannerToLink'] = "Выберите баннер для связи с этой зоной:";
$GLOBALS['strSelectCampaignToLink'] = "Выберите кампанию для связи с этой зоной:";
$GLOBALS['strSelectAdvertiser'] = "Выберите клиента";
$GLOBALS['strSelectPlacement'] = "Выберите кампанию";
$GLOBALS['strSelectAd'] = "Выберите баннер";
$GLOBALS['strSelectPublisher'] = "Выбрать сайт";
$GLOBALS['strSelectZone'] = "Выбрать зону";
$GLOBALS['strStatusPending'] = "Ожидают";
$GLOBALS['strStatusApproved'] = "Approved";
$GLOBALS['strStatusDisapproved'] = "Disapproved";
$GLOBALS['strStatusDuplicate'] = "Дублювати";
$GLOBALS['strStatusOnHold'] = "On Hold";
$GLOBALS['strStatusIgnore'] = "Ignore";
$GLOBALS['strConnectionType'] = "Тип";
$GLOBALS['strConnTypeSale'] = "Sale";
$GLOBALS['strConnTypeLead'] = "Lead";
$GLOBALS['strConnTypeSignUp'] = "Signup";
$GLOBALS['strShortcutEditStatuses'] = "Редактировать статусы";
$GLOBALS['strShortcutShowStatuses'] = "Показать статусы";

// Statistics
$GLOBALS['strStats'] = "Статистика";
$GLOBALS['strNoStats'] = "Сейчас не доступно никакой статистики";
$GLOBALS['strNoStatsForPeriod'] = "Статистика за период с %s по %s недоступна";
$GLOBALS['strGlobalHistory'] = "Global Statistics";
$GLOBALS['strDailyHistory'] = "Daily Statistics";
$GLOBALS['strDailyStats'] = "Daily Statistics";
$GLOBALS['strWeeklyHistory'] = "Weekly Statistics";
$GLOBALS['strMonthlyHistory'] = "Monthly Statistics";
$GLOBALS['strTotalThisPeriod'] = "Всего за этот период";
$GLOBALS['strPublisherDistribution'] = "Распределение по сайтам";
$GLOBALS['strCampaignDistribution'] = "Распределение по кампаниям";
$GLOBALS['strViewBreakdown'] = "Просмотры за";
$GLOBALS['strBreakdownByDay'] = "День";
$GLOBALS['strBreakdownByWeek'] = "Тиждень";
$GLOBALS['strBreakdownByMonth'] = "Місяць";
$GLOBALS['strBreakdownByDow'] = "День тижня";
$GLOBALS['strBreakdownByHour'] = "година";
$GLOBALS['strItemsPerPage'] = "Элементов на странице";
$GLOBALS['strDistributionHistoryCampaign'] = "Distribution Statistics (Campaign)";
$GLOBALS['strDistributionHistoryBanner'] = "Distribution Statistics (Banner)";
$GLOBALS['strDistributionHistoryWebsite'] = "Distribution Statistics (Website)";
$GLOBALS['strDistributionHistoryZone'] = "Distribution Statistics (Zone)";
$GLOBALS['strShowGraphOfStatistics'] = "Показать <u>г</u>трафик";
$GLOBALS['strExportStatisticsToExcel'] = "<u>Э</u>экспортировать статистику в Excel";
$GLOBALS['strGDnotEnabled'] = "Для отображения графиков вам необходимо сконфигурировать PHP Для работы с библиотекой GD. Обратитесь за подробностями к руководству по PHP: <a href='http://www.php.net/gd' target='_blank'>http://www.php.net/gd</a>";
$GLOBALS['strStatsArea'] = "Область";

// Expiration
$GLOBALS['strNoExpiration'] = "Срок окончания не установлен";
$GLOBALS['strEstimated'] = "Ожидаемое окончание";
$GLOBALS['strNoExpirationEstimation'] = "Ограничения еще не достигнуты";
$GLOBALS['strDaysAgo'] = "дней назад";
$GLOBALS['strCampaignStop'] = "Історія кампаній";

// Reports
$GLOBALS['strAdvancedReports'] = "Расширенные отчеты";
$GLOBALS['strStartDate'] = "Start Date";
$GLOBALS['strEndDate'] = "End Date";
$GLOBALS['strPeriod'] = "Период";
$GLOBALS['strLimitations'] = "Delivery Rules";
$GLOBALS['strWorksheets'] = "Worksheets";

// Admin_UI_Fields
$GLOBALS['strAllAdvertisers'] = "Всього клієнтів";
$GLOBALS['strAnonAdvertisers'] = "Анонимные рекламодатели";
$GLOBALS['strAllPublishers'] = "Все сайты";
$GLOBALS['strAnonPublishers'] = "Анонимные сайты";
$GLOBALS['strAllAvailZones'] = "Все доступные зоны";

// Userlog
$GLOBALS['strUserLog'] = "Журнал действий пользователя";
$GLOBALS['strUserLogDetails'] = "Подробности действий пользователя";
$GLOBALS['strDeleteLog'] = "Удалить журнал";
$GLOBALS['strAction'] = "Дія";
$GLOBALS['strNoActionsLogged'] = "Действий не зарегистрировано";

// Code generation
$GLOBALS['strGenerateBannercode'] = "Сгенерировать баннерный код";
$GLOBALS['strChooseInvocationType'] = "Виберіть тип банера.";
$GLOBALS['strGenerate'] = "Сгенерировать";
$GLOBALS['strParameters'] = "Настройки метки";
$GLOBALS['strFrameSize'] = "Размер фрейма";
$GLOBALS['strBannercode'] = "Баннерный код";
$GLOBALS['strTrackercode'] = "Код трекера";
$GLOBALS['strBackToTheList'] = "Вернуться к списку отчетов";
$GLOBALS['strCharset'] = "Кодировка";
$GLOBALS['strAutoDetect'] = "Автоопределение";
$GLOBALS['strCacheBusterComment'] = "  * Replace all instances of {random} with
  * a generated random number (or timestamp).
  *";
$GLOBALS['strSSLBackupComment'] = "
  * The backup image section of this tag has been generated for use on a
  * non-SSL page. If this tag is to be placed on an SSL page, change the
  *   'http://%s/...'
  * to
  *   'https://%s/...'
  *";
$GLOBALS['strSSLDeliveryComment'] = "
  * This tag has been generated for use on a non-SSL page. If this tag
  * is to be placed on an SSL page, change the
  *   'http://%s/...'
  * to
  *   'https://%s/...'
  *";

// Errors
$GLOBALS['strErrorDatabaseConnection'] = "Database connection error.";
$GLOBALS['strErrorCantConnectToDatabase'] = "A fatal error occurred %1\$s can't connect to the database. Because
                                                   of this it isn't possible to use the administrator interface. The delivery
                                                   of banners might also be affected. Possible reasons for the problem are:
                                                   <ul>
                                                     <li>The database server isn't functioning at the moment</li>
                                                     <li>The location of the database server has changed</li>
                                                     <li>The username or password used to contact the database server are not correct</li>
                                                     <li>PHP has not loaded the <i>%2\$s</i> extension</li>
                                                   </ul>";
$GLOBALS['strNoMatchesFound'] = "Ничего не найдено";
$GLOBALS['strErrorOccurred'] = "Произошла ошибка";
$GLOBALS['strErrorDBPlain'] = "Ошибка доступа к БД";
$GLOBALS['strErrorDBSerious'] = "Обнаружена серьезная проблема с БД";
$GLOBALS['strErrorDBNoDataPlain'] = "Due to a problem with the database {$PRODUCT_NAME} couldn't retrieve or store data. ";
$GLOBALS['strErrorDBNoDataSerious'] = "Due to a serious problem with the database, {$PRODUCT_NAME} couldn't retrieve data";
$GLOBALS['strErrorDBCorrupt'] = "Возможно, БД повреждена и нуждается в починке. Для дополнительной информации о починке поврежденных таблиц БД прочтите раздел <i>Устранение неполадок</i> в <i>Руководстве Администратора</i>";
$GLOBALS['strErrorDBContact'] = "Свяжитесь с администратором сервера и сообщите ему о проблеме";
$GLOBALS['strErrorDBSubmitBug'] = "If this problem is reproducable it might be caused by a bug in {$PRODUCT_NAME}. Please report the following information to the creators of {$PRODUCT_NAME}. Also try to describe the actions that led to this error as clearly as possible.";
$GLOBALS['strMaintenanceNotActive'] = "The maintenance script has not been run in the last 24 hours.
In order for the application to function correctly it needs to run
every hour.

Please read the Administrator guide for more information
about configuring the maintenance script.";
$GLOBALS['strErrorLinkingBanner'] = "Невозможно привязать выбранный баннер к этой зоне, т.к.:";
$GLOBALS['strUnableToLinkBanner'] = "Невозможно привязать выбранный баннер:";
$GLOBALS['strErrorEditingCampaignRevenue'] = "некорректный формат в поле Информация об оплате";
$GLOBALS['strErrorEditingCampaignECPM'] = "incorrect number format in ECPM Information field";
$GLOBALS['strErrorEditingZone'] = "Ошибка обновления зоны:";
$GLOBALS['strUnableToChangeZone'] = "Невозможно сохранить изменения, т.к.:";
$GLOBALS['strDatesConflict'] = "дата конфликтует с:";
$GLOBALS['strEmailNoDates'] = "Campaigns linked to Email Zones must have a start and end date set. {$PRODUCT_NAME} ensures that on a given date, only one active banner is linked to an Email Zone. Please ensure that the campaigns already linked to the zone do not have overlapping dates with the campaign you are trying to link.";
$GLOBALS['strWarningInaccurateStats'] = "Часть статистики была собрана в не-UTC часовом поясе, и не может быть отображена при использовании корректного часового пояса.";
$GLOBALS['strWarningInaccurateReadMore'] = "Узнать больше";
$GLOBALS['strWarningInaccurateReport'] = "Часть статистики была собрана в не-UTC часовом поясе, и не может быть отображена при использовании корректного часового пояса.";

//Validation
$GLOBALS['strRequiredFieldLegend'] = "denotes required field";
$GLOBALS['strFormContainsErrors'] = "Form contains errors, please correct the marked fields below.";
$GLOBALS['strXRequiredField'] = "%s is required";
$GLOBALS['strEmailField'] = "Please enter a valid email";
$GLOBALS['strNumericField'] = "Please enter a number (only digits allowed)";
$GLOBALS['strGreaterThanZeroField'] = "Must be greater than 0";
$GLOBALS['strXGreaterThanZeroField'] = "%s must be greater than 0";
$GLOBALS['strXPositiveWholeNumberField'] = "%s must be a positive whole number";
$GLOBALS['strInvalidWebsiteURL'] = "Invalid Website URL";

// Email
$GLOBALS['strSirMadam'] = "Г-н/Г-жа";
$GLOBALS['strMailSubject'] = "Отчёт о рекламе";
$GLOBALS['strMailHeader'] = "Dear {contact},";
$GLOBALS['strMailBannerStats'] = "Здесь вы видите статистику клиента {clientname}:";
$GLOBALS['strMailBannerActivatedSubject'] = "Кампания активирована";
$GLOBALS['strMailBannerDeactivatedSubject'] = "Кампания деактивирована";
$GLOBALS['strMailBannerActivated'] = "Your campaign shown below has been activated because
the campaign activation date has been reached.";
$GLOBALS['strMailBannerDeactivated'] = "Указанные кампании были деактивированы, т.к.";
$GLOBALS['strMailFooter'] = "Regards,
   {adminfullname}";
$GLOBALS['strClientDeactivated'] = "Данный клиент в настоящее время деактивирован, так как";
$GLOBALS['strBeforeActivate'] = "дата активации еще не достигнута";
$GLOBALS['strAfterExpire'] = "была достигнута дата деактивации";
$GLOBALS['strNoMoreImpressions'] = "все приобретенные показы использованы";
$GLOBALS['strNoMoreClicks'] = "все приобретенные клики использованы";
$GLOBALS['strNoMoreConversions'] = "все приобретенные действия использованы";
$GLOBALS['strWeightIsNull'] = "был установлен нулевой вес";
$GLOBALS['strRevenueIsNull'] = "its revenue is set to zero";
$GLOBALS['strTargetIsNull'] = "был установлен нулевой таргетинг";
$GLOBALS['strNoViewLoggedInInterval'] = "За период данного отчета не было зарегистрировано показов";
$GLOBALS['strNoClickLoggedInInterval'] = "За период данного отчета не было зарегистрировано кликов";
$GLOBALS['strNoConversionLoggedInInterval'] = "За период данного отчета не было зарегистрировано действий";
$GLOBALS['strMailReportPeriod'] = "Этот отчет включает в себя статистику с {startdate} по {enddate}.";
$GLOBALS['strMailReportPeriodAll'] = "Этот отчет включает в себя всю статистику вплоть до {enddate}.";
$GLOBALS['strNoStatsForCampaign'] = "Нет статистики для этой кампании";
$GLOBALS['strImpendingCampaignExpiry'] = "Приближается окончание запланированной кампании";
$GLOBALS['strYourCampaign'] = "Ваша кампания";
$GLOBALS['strTheCampiaignBelongingTo'] = "Кампания, принадлежащая";
$GLOBALS['strImpendingCampaignExpiryDateBody'] = "{clientname} указанному ниже, заканчивается {date}.";
$GLOBALS['strImpendingCampaignExpiryImpsBody'] = "{clientname} указанному ниже, осталось меньше {limit} показов";
$GLOBALS['strImpendingCampaignExpiryBody'] = "As a result, the campaign will soon be automatically disabled, and the
following banners in the campaign will also be disabled:";

// Priority
$GLOBALS['strPriority'] = "Пріоритет";
$GLOBALS['strSourceEdit'] = "Редактировать источники";

// Preferences
$GLOBALS['strPreferences'] = "Настройки";
$GLOBALS['strUserPreferences'] = "Предпочтения пользователя";
$GLOBALS['strChangePassword'] = "Сменить пароль";
$GLOBALS['strChangeEmail'] = "Сменить e-mail";
$GLOBALS['strCurrentPassword'] = "Текущий пароль";
$GLOBALS['strChooseNewPassword'] = "Новый пароль";
$GLOBALS['strReenterNewPassword'] = "Подтвердите пароль";
$GLOBALS['strNameLanguage'] = "Имя и Язык";
$GLOBALS['strAccountPreferences'] = "Настройки аккаунта";
$GLOBALS['strCampaignEmailReportsPreferences'] = "Настройки доставки отчетов";
$GLOBALS['strTimezonePreferences'] = "Timezone Preferences";
$GLOBALS['strAdminEmailWarnings'] = "Предупреждения администратора";
$GLOBALS['strAgencyEmailWarnings'] = "Предупреждения агентства";
$GLOBALS['strAdveEmailWarnings'] = "Предупреждения клиента";
$GLOBALS['strFullName'] = "ФИО";
$GLOBALS['strEmailAddress'] = "Email address";
$GLOBALS['strUserDetails'] = "Данные пользователя";
$GLOBALS['strUserInterfacePreferences'] = "Настройки GUI";
$GLOBALS['strPluginPreferences'] = "Главные настройки";
$GLOBALS['strColumnName'] = "имя колонки";
$GLOBALS['strShowColumn'] = "Показать колонку";
$GLOBALS['strCustomColumnName'] = "Пользовательское имя колонки";
$GLOBALS['strColumnRank'] = "Приоритет колонки";

// Long names
$GLOBALS['strRevenue'] = "Доход";
$GLOBALS['strNumberOfItems'] = "Количество элементов";
$GLOBALS['strRevenueCPC'] = "Доход CPC";
$GLOBALS['strERPM'] = "CPM (ціна 1000 показів)";
$GLOBALS['strERPC'] = "CPC (ціна кліка)";
$GLOBALS['strERPS'] = "CPM (ціна 1000 показів)";
$GLOBALS['strEIPM'] = "CPM (ціна 1000 показів)";
$GLOBALS['strEIPC'] = "CPC (ціна кліка)";
$GLOBALS['strEIPS'] = "CPM (ціна 1000 показів)";
$GLOBALS['strECPM'] = "CPM (ціна 1000 показів)";
$GLOBALS['strECPC'] = "CPC (ціна кліка)";
$GLOBALS['strECPS'] = "CPM (ціна 1000 показів)";
$GLOBALS['strPendingConversions'] = "Неизрасходованные действия";
$GLOBALS['strImpressionSR'] = "Показів";
$GLOBALS['strClickSR'] = "Клик (SR)";

// Short names
$GLOBALS['strRevenue_short'] = "Доход";
$GLOBALS['strBasketValue_short'] = "Корзина";
$GLOBALS['strNumberOfItems_short'] = "Кол-во поз.";
$GLOBALS['strRevenueCPC_short'] = "Дох. CPC";
$GLOBALS['strERPM_short'] = "CPM (ціна 1000 показів)";
$GLOBALS['strERPC_short'] = "CPC (ціна кліка)";
$GLOBALS['strERPS_short'] = "CPM (ціна 1000 показів)";
$GLOBALS['strEIPM_short'] = "CPM (ціна 1000 показів)";
$GLOBALS['strEIPC_short'] = "CPC (ціна кліка)";
$GLOBALS['strEIPS_short'] = "CPM (ціна 1000 показів)";
$GLOBALS['strECPM_short'] = "CPM (ціна 1000 показів)";
$GLOBALS['strECPC_short'] = "CPC (ціна кліка)";
$GLOBALS['strECPS_short'] = "CPM (ціна 1000 показів)";
$GLOBALS['strID_short'] = "ID";
$GLOBALS['strRequests_short'] = "Запр.";
$GLOBALS['strImpressions_short'] = "Impr.";
$GLOBALS['strClicks_short'] = "Кліков";
$GLOBALS['strCTR_short'] = "CTR";
$GLOBALS['strConversions_short'] = "Конв.";
$GLOBALS['strPendingConversions_short'] = "Неизрасходованные действ.";
$GLOBALS['strImpressionSR_short'] = "Impr. SR";
$GLOBALS['strClickSR_short'] = "Клик (SR)";

// Global Settings
$GLOBALS['strConfiguration'] = "Configuration";
$GLOBALS['strGlobalSettings'] = "Общие настройки";
$GLOBALS['strGeneralSettings'] = "Общие установки";
$GLOBALS['strMainSettings'] = "Главные настройки";
$GLOBALS['strPlugins'] = "Plugins";
$GLOBALS['strChooseSection'] = 'Choose Section';

// Product Updates
$GLOBALS['strProductUpdates'] = "Обновление ПО";
$GLOBALS['strViewPastUpdates'] = "Управление обновлениями и резервными копиями";
$GLOBALS['strFromVersion'] = "С версии";
$GLOBALS['strToVersion'] = "До версии";
$GLOBALS['strToggleDataBackupDetails'] = "Показать/спрятать подробности резервного копирования";
$GLOBALS['strClickViewBackupDetails'] = "нажмите для просмотра подробной информации";
$GLOBALS['strClickHideBackupDetails'] = "нажмите чтобы скрыть подробности";
$GLOBALS['strShowBackupDetails'] = "показать подробную информацию";
$GLOBALS['strHideBackupDetails'] = "скрыть подробную информацию";
$GLOBALS['strBackupDeleteConfirm'] = "Вы действительно хотите удалить все резервные копии созданные со времени обновления?";
$GLOBALS['strDeleteArtifacts'] = "Удалить артефакты";
$GLOBALS['strArtifacts'] = "Артефакты";
$GLOBALS['strBackupDbTables'] = "Копировать таблицы БД";
$GLOBALS['strLogFiles'] = "Журналы регистрации";
$GLOBALS['strConfigBackups'] = "Резервные копии конфигурации";
$GLOBALS['strUpdatedDbVersionStamp'] = "Метка версии обновленной БД";
$GLOBALS['aProductStatus']['UPGRADE_COMPLETE'] = "Обновление завершено";
$GLOBALS['aProductStatus']['UPGRADE_FAILED'] = "Обновление не удалось";

// Agency
$GLOBALS['strAgencyManagement'] = "Управление учетными записями";
$GLOBALS['strAgency'] = "Учетная запись";
$GLOBALS['strAddAgency'] = "Добавить новую учетную запись";
$GLOBALS['strAddAgency_Key'] = "Додати <u>н</u>овый банер";
$GLOBALS['strTotalAgencies'] = "Всего учетных записей";
$GLOBALS['strAgencyProperties'] = "Свойства учетной записи";
$GLOBALS['strNoAgencies'] = "Немає банерів";
$GLOBALS['strConfirmDeleteAgency'] = "Ви дійсно хочете видалити цього клієнта?";
$GLOBALS['strHideInactiveAgencies'] = "Скрыть неактивные учетные записи";
$GLOBALS['strInactiveAgenciesHidden'] = "неактивні клієнти приховані";
$GLOBALS['strSwitchAccount'] = "Переключиться в этот аккаунт";
$GLOBALS['strAgencyStatusRunning'] = "Active";
$GLOBALS['strAgencyStatusInactive'] = "активний";
$GLOBALS['strAgencyStatusPaused'] = "Suspended";

// Channels
$GLOBALS['strChannel'] = "Delivery Rule Set";
$GLOBALS['strChannels'] = "Delivery Rule Sets";
$GLOBALS['strChannelManagement'] = "Delivery Rule Set Management";
$GLOBALS['strAddNewChannel'] = "Add new Delivery Rule Set";
$GLOBALS['strAddNewChannel_Key'] = "Add <u>n</u>ew Delivery Rule Set";
$GLOBALS['strChannelToWebsite'] = "Ни один веб-сайт";
$GLOBALS['strNoChannels'] = "There are currently no delivery rule sets defined";
$GLOBALS['strNoChannelsAddWebsite'] = "There are currently no delivery rule sets defined, because there are no websites. To create a delivery rule set, <a href='affiliate-edit.php'>add a new website</a> first.";
$GLOBALS['strEditChannelLimitations'] = "Edit delivery rules for the delivery rule set";
$GLOBALS['strChannelProperties'] = "Delivery Rule Set Properties";
$GLOBALS['strChannelLimitations'] = "Ограничения показа";
$GLOBALS['strConfirmDeleteChannel'] = "Do you really want to delete this delivery rule set?";
$GLOBALS['strConfirmDeleteChannels'] = "Do you really want to delete the selected delivery rule sets?";
$GLOBALS['strChannelsOfWebsite'] = 'в'; //this is added between page name and website name eg. 'delivery rule sets in www.example.com'

// Tracker Variables
$GLOBALS['strVariableName'] = "Имя переменной";
$GLOBALS['strVariableDescription'] = "Опис";
$GLOBALS['strVariableDataType'] = "Тип данных";
$GLOBALS['strVariablePurpose'] = "Назначение";
$GLOBALS['strGeneric'] = "Простій";
$GLOBALS['strBasketValue'] = "Значение корзины";
$GLOBALS['strNumItems'] = "Количество элементов";
$GLOBALS['strVariableIsUnique'] = "Избегать дублирования действий?";
$GLOBALS['strNumber'] = "Номер";
$GLOBALS['strString'] = "Строка";
$GLOBALS['strTrackFollowingVars'] = "Отслеживать за переменной";
$GLOBALS['strAddVariable'] = "Добавить переменную";
$GLOBALS['strNoVarsToTrack'] = "Нет переменных для отслеживания";
$GLOBALS['strVariableRejectEmpty'] = "Отказаться если пусто?";
$GLOBALS['strTrackingSettings'] = "Настройки отслеживания";
$GLOBALS['strTrackerType'] = "Назва трекера";
$GLOBALS['strTrackerTypeJS'] = "Отслеживать значения переменных JavaScript";
$GLOBALS['strTrackerTypeDefault'] = "Отслеживать значения переменных JavaScript (для обратной совместимости необходимо экранирование)";
$GLOBALS['strTrackerTypeDOM'] = "Отслеживать значения переменных, используя DOM";
$GLOBALS['strTrackerTypeCustom'] = "Пользовательский код JS";
$GLOBALS['strVariableCode'] = "Код отслеживания JS";

// Password recovery
$GLOBALS['strForgotPassword'] = "Забыли пароль?";
$GLOBALS['strPasswordRecovery'] = "Password reset";
$GLOBALS['strEmailRequired'] = "Поле \"E-mail\" обязательно для заполнения";
$GLOBALS['strPwdRecWrongId'] = "Неправильный ID";
$GLOBALS['strPwdRecEnterEmail'] = "Введите ваш адрес электронной почты";
$GLOBALS['strPwdRecEnterPassword'] = "Введите ваш новый пароль";
$GLOBALS['strProceed'] = "Proceed >";
$GLOBALS['strNotifyPageMessage'] = "An e-mail has been sent to you, which includes a link that will allow you
                                         to reset your password and log in.<br />Please allow a few minutes for the e-mail to arrive.<br />
                                         If you do not receive the e-mail, please check your spam folder.<br />
                                         <a href=\"index.php\">Return to the main login page.</a>";

$GLOBALS['strPwdRecEmailPwdRecovery'] = "Reset Your %s Password";
$GLOBALS['strPwdRecEmailBody'] = "Dear {name},

You, or someone pretending to be you, recently requested that your {$PRODUCT_NAME} password be reset.

If this request was made by you, then you can reset the password for your username '{username}' by
clicking on the following link:

{reset_link}

If you submitted the password reset request by mistake, or if you didn't make a request at all, simply
ignore this email. No changes have been made to your password and the password reset link will expire
automatically.

If you continue to receive these password reset mails, then it may indicate that someone is attempting
to gain access to your username. In that case, please contact the support team or system administrator
for your {$PRODUCT_NAME} system, and notify them of the situation.

{admin_signature}";
$GLOBALS['strPwdRecEmailSincerely'] = "Sincerely,";

// Audit
$GLOBALS['strAdditionalItems'] = "добавить дополнительные элементы";
$GLOBALS['strFor'] = "для";
$GLOBALS['strHas'] = "содержит";
$GLOBALS['strBinaryData'] = "Двоичные данные";
$GLOBALS['strAuditTrailDisabled'] = "Аудит был отключен администратором. Сообщения аудита больше не фиксируются и не отображаются в журнале аудита.";

// Widget - Audit
$GLOBALS['strAuditNoData'] = "За выбранный вами временной интервал не было зафиксировано никакой активности.";
$GLOBALS['strAuditTrail'] = "Аудит изменений";
$GLOBALS['strAuditTrailSetup'] = "Настроить аудит изменений сегодня";
$GLOBALS['strAuditTrailGoTo'] = "Перейти на страницу аудита изменений";
$GLOBALS['strAuditTrailNotEnabled'] = "<li>Audit Trail allows you to see who did what and when. Or to put it another way, it keeps track of system changes within {$PRODUCT_NAME}</li>
        <li>You are seeing this message, because you have not activated the Audit Trail</li>
        <li>Interested in learning more? Read the <a href='{$PRODUCT_DOCSURL}/admin/settings/auditTrail' class='site-link' target='help' >Audit Trail documentation</a></li>";

// Widget - Campaign
$GLOBALS['strCampaignGoTo'] = "Перейти на стр. кампании";
$GLOBALS['strCampaignSetUp'] = "Настроить кампанию сегодня";
$GLOBALS['strCampaignNoRecords'] = "<li>Campaigns let you group together any number of banner ads, of any size, that share common advertising requirements</li>
        <li>Save time by grouping banners within a campaign and no longer define delivery settings for each ad separately</li>
        <li>Check out the <a class='site-link' target='help' href='{$PRODUCT_DOCSURL}/user/inventory/advertisersAndCampaigns/campaigns'>Campaign documentation</a>!</li>";
$GLOBALS['strCampaignNoRecordsAdmin'] = "<li>У вас нет активных кампаний.</li>";

$GLOBALS['strCampaignNoDataTimeSpan'] = "В выбранный вами период ни одна кампания не стартовала и не закончилась";
$GLOBALS['strCampaignAuditNotActivated'] = "<li>In order to view campaigns which have started or finished during the timeframe you have selected, the Audit Trail must be activated</li>
        <li>You are seeing this message because you didn't activate the Audit Trail</li>";
$GLOBALS['strCampaignAuditTrailSetup'] = "Активируйте аудит для начала отображения кампаний";

$GLOBALS['strUnsavedChanges'] = "У вас есть несохраненные изменения. Не забудьте нажать кнопку \"Сохранить\" когда закончите редактирование";
$GLOBALS['strDeliveryLimitationsDisagree'] = "WARNING: The cached delivery rules <strong>DO NOT AGREE</strong> with the delivery rules shown below<br />Please hit save changes to update the cached delivery rules";
$GLOBALS['strDeliveryRulesDbError'] = "WARNING: When saving the delivery rules, a database error occured. Please check the delivery rules below carefully, and update, if required.";
$GLOBALS['strDeliveryRulesTruncation'] = "WARNING: When saving the delivery rules, MySQL truncated the data, so the original values were restored. Please reduce your rule size, and try again.";
$GLOBALS['strDeliveryLimitationsInputErrors'] = "Some delivery rules report incorrect values:";

//confirmation messages
$GLOBALS['strYouAreNowWorkingAsX'] = "You are now working as <b>%s</b>";
$GLOBALS['strYouDontHaveAccess'] = "You don't have access to that page. You have been re-directed.";

$GLOBALS['strAdvertiserHasBeenAdded'] = "Advertiser <a href='%s'>%s</a> has been added, <a href='%s'>add a campaign</a>";
$GLOBALS['strAdvertiserHasBeenUpdated'] = "Advertiser <a href='%s'>%s</a> has been updated";
$GLOBALS['strAdvertiserHasBeenDeleted'] = "Advertiser <b>%s</b> has been deleted";
$GLOBALS['strAdvertisersHaveBeenDeleted'] = "All selected advertisers have been deleted";

$GLOBALS['strTrackerHasBeenAdded'] = "Tracker <a href='%s'>%s</a> has been added";
$GLOBALS['strTrackerHasBeenUpdated'] = "Tracker <a href='%s'>%s</a> has been updated";
$GLOBALS['strTrackerVarsHaveBeenUpdated'] = "Variables of tracker <a href='%s'>%s</a> have been updated";
$GLOBALS['strTrackerCampaignsHaveBeenUpdated'] = "Linked campaigns of tracker <a href='%s'>%s</a> have been updated";
$GLOBALS['strTrackerAppendHasBeenUpdated'] = "Append tracker code of tracker <a href='%s'>%s</a> has been updated";
$GLOBALS['strTrackerHasBeenDeleted'] = "Tracker <b>%s</b> has been deleted";
$GLOBALS['strTrackersHaveBeenDeleted'] = "All selected trackers have been deleted";
$GLOBALS['strTrackerHasBeenDuplicated'] = "Tracker <a href='%s'>%s</a> has been copied to <a href='%s'>%s</a>";
$GLOBALS['strTrackerHasBeenMoved'] = "Tracker <b>%s</b> has been moved to advertiser <b>%s</b>";

$GLOBALS['strCampaignHasBeenAdded'] = "Campaign <a href='%s'>%s</a> has been added, <a href='%s'>add a banner</a>";
$GLOBALS['strCampaignHasBeenUpdated'] = "Campaign <a href='%s'>%s</a> has been updated";
$GLOBALS['strCampaignTrackersHaveBeenUpdated'] = "Linked trackers of campaign <a href='%s'>%s</a> have been updated";
$GLOBALS['strCampaignHasBeenDeleted'] = "Campaign <b>%s</b> has been deleted";
$GLOBALS['strCampaignsHaveBeenDeleted'] = "All selected campaigns have been deleted";
$GLOBALS['strCampaignHasBeenDuplicated'] = "Campaign <a href='%s'>%s</a> has been copied to <a href='%s'>%s</a>";
$GLOBALS['strCampaignHasBeenMoved'] = "Campaign <b>%s</b> has been moved to advertiser <b>%s</b>";

$GLOBALS['strBannerHasBeenAdded'] = "Banner <a href='%s'>%s</a> has been added";
$GLOBALS['strBannerHasBeenUpdated'] = "Banner <a href='%s'>%s</a> has been updated";
$GLOBALS['strBannerAdvancedHasBeenUpdated'] = "Advanced settings for banner <a href='%s'>%s</a> have been updated";
$GLOBALS['strBannerAclHasBeenUpdated'] = "Delivery options for banner <a href='%s'>%s</a> have been updated";
$GLOBALS['strBannerAclHasBeenAppliedTo'] = "Delivery options for banner <a href='%s'>%s</a> have been applied to %d banners";
$GLOBALS['strBannerHasBeenDeleted'] = "Banner <b>%s</b> has been deleted";
$GLOBALS['strBannersHaveBeenDeleted'] = "All selected banners have been deleted";
$GLOBALS['strBannerHasBeenDuplicated'] = "Banner <a href='%s'>%s</a> has been copied to <a href='%s'>%s</a>";
$GLOBALS['strBannerHasBeenMoved'] = "Banner <b>%s</b> has been moved to campaign <b>%s</b>";
$GLOBALS['strBannerHasBeenActivated'] = "Banner <a href='%s'>%s</a> has been activated";
$GLOBALS['strBannerHasBeenDeactivated'] = "Banner <a href='%s'>%s</a> has been deactivated";

$GLOBALS['strXZonesLinked'] = "<b>%s</b> zone(s) linked";
$GLOBALS['strXZonesUnlinked'] = "<b>%s</b> zone(s) unlinked";

$GLOBALS['strWebsiteHasBeenAdded'] = "Website <a href='%s'>%s</a> has been added, <a href='%s'>add a zone</a>";
$GLOBALS['strWebsiteHasBeenUpdated'] = "Website <a href='%s'>%s</a> has been updated";
$GLOBALS['strWebsiteHasBeenDeleted'] = "Website <b>%s</b> has been deleted";
$GLOBALS['strWebsitesHaveBeenDeleted'] = "All selected website have been deleted";
$GLOBALS['strWebsiteHasBeenDuplicated'] = "Website <a href='%s'>%s</a> has been copied to <a href='%s'>%s</a>";

$GLOBALS['strZoneHasBeenAdded'] = "Zone <a href='%s'>%s</a> has been added";
$GLOBALS['strZoneHasBeenUpdated'] = "Zone <a href='%s'>%s</a> has been updated";
$GLOBALS['strZoneAdvancedHasBeenUpdated'] = "Advanced settings for zone <a href='%s'>%s</a> have been updated";
$GLOBALS['strZoneHasBeenDeleted'] = "Zone <b>%s</b> has been deleted";
$GLOBALS['strZonesHaveBeenDeleted'] = "All selected zone have been deleted";
$GLOBALS['strZoneHasBeenDuplicated'] = "Zone <a href='%s'>%s</a> has been copied to <a href='%s'>%s</a>";
$GLOBALS['strZoneHasBeenMoved'] = "Zone <b>%s</b> has been moved to website <b>%s</b>";
$GLOBALS['strZoneLinkedBanner'] = "Banner has been linked to zone <a href='%s'>%s</a>";
$GLOBALS['strZoneLinkedCampaign'] = "Campaign has been linked to zone <a href='%s'>%s</a>";
$GLOBALS['strZoneRemovedBanner'] = "Banner has been unlinked from zone <a href='%s'>%s</a>";
$GLOBALS['strZoneRemovedCampaign'] = "Campaign has been unlinked from zone <a href='%s'>%s</a>";

$GLOBALS['strChannelHasBeenAdded'] = "Delivery rule set <a href='%s'>%s</a> has been added. <a href='%s'>Set the delivery rules.</a>";
$GLOBALS['strChannelHasBeenUpdated'] = "Delivery rule set <a href='%s'>%s</a> has been updated";
$GLOBALS['strChannelAclHasBeenUpdated'] = "Delivery options for the delivery rule set <a href='%s'>%s</a> have been updated";
$GLOBALS['strChannelHasBeenDeleted'] = "Delivery rule set <b>%s</b> has been deleted";
$GLOBALS['strChannelsHaveBeenDeleted'] = "All selected delivery rule sets have been deleted";
$GLOBALS['strChannelHasBeenDuplicated'] = "Delivery rule set <a href='%s'>%s</a> has been copied to <a href='%s'>%s</a>";

$GLOBALS['strUserPreferencesUpdated'] = "Your <b>%s</b> preferences has been updated";
$GLOBALS['strEmailChanged'] = "Your E-mail has been changed";
$GLOBALS['strPasswordChanged'] = "Your password has been changed";
$GLOBALS['strXPreferencesHaveBeenUpdated'] = "<b>%s</b> have been updated";
$GLOBALS['strXSettingsHaveBeenUpdated'] = "<b>%s</b> have been updated";
$GLOBALS['strTZPreferencesWarning'] = "However, campaign activation and expiry were not updated, nor time-based banner delivery rules.<br />You will need to update them manually if you wish them to use the new timezone";

// Report error messages
$GLOBALS['strReportErrorMissingSheets'] = "No worksheet was selected for report";
$GLOBALS['strReportErrorUnknownCode'] = "Unknown error code #";

/* ------------------------------------------------------- */
/* Keyboard shortcut assignments                           */
/* ------------------------------------------------------- */

// Reserved keys
// Do not change these unless absolutely needed
$GLOBALS['keyHome'] = "h";
$GLOBALS['keyUp'] = "u";
$GLOBALS['keyNextItem'] = ".";
$GLOBALS['keyPreviousItem'] = ",";
$GLOBALS['keyList'] = "l";

// Other keys
// Please make sure you underline the key you
// used in the string in default.lang.php
$GLOBALS['keySearch'] = "П";
$GLOBALS['keyCollapseAll'] = "З";
$GLOBALS['keyExpandAll'] = "Р";
$GLOBALS['keyAddNew'] = "н";
$GLOBALS['keyNext'] = "н";
$GLOBALS['keyPrevious'] = "П";
$GLOBALS['keyLinkUser'] = "u";
$GLOBALS['keyWorkingAs'] = "w";
