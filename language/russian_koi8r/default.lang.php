<?php // $Revision$

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2001 by the phpAdsNew developers                       */
/* http://sourceforge.net/projects/phpadsnew                            */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/


// Set character-set
$GLOBALS['phpAds_CharSet'] = "koi8-r";


// Set translation strings
$GLOBALS['strHome'] = "Главная страница";
$GLOBALS['date_format'] = "%d/%m/%Y";
$GLOBALS['time_format'] = "%H:%i:%S";
$GLOBALS['strMySQLError'] = "MySQL-Error:";
$GLOBALS['strAdminstration'] = "Администрирование";
$GLOBALS['strAddClient'] = "Добавить клиента";
$GLOBALS['strModifyClient'] = "Изменить клиента";
$GLOBALS['strDeleteClient'] = "Удалить клиента";
$GLOBALS['strViewClientStats'] = "Посмотреть статистику клиента";
$GLOBALS['strClientName'] = "Клиент";
$GLOBALS['strContact'] = "Контакт";
$GLOBALS['strEMail'] = "EMail";
$GLOBALS['strViews'] = "Показов";
$GLOBALS['strClicks'] = "Кликов";
$GLOBALS['strTotalViews'] = "Всего показов";
$GLOBALS['strTotalClicks'] = "Всего кликов";
$GLOBALS['strCTR'] = "Click-Through Ratio";
$GLOBALS['strTotalClients'] = "Всего клиентов";
$GLOBALS['strActiveClients'] = "Активных клиентов";
$GLOBALS['strActiveBanners'] = "Активных баннеров";
$GLOBALS['strLogout'] = "Выход";
$GLOBALS['strCreditStats'] = "Статистика кредитов";
$GLOBALS['strViewCredits'] = "Кредиты по показам";   
$GLOBALS['strClickCredits'] = "Кредиты по кликам";
$GLOBALS['strPrevious'] = "Предыдущий";
$GLOBALS['strNext'] = "Следующий";
$GLOBALS['strNone'] = "Нет";
$GLOBALS['strViewsPurchased'] = "Куплено показов";
$GLOBALS['strClicksPurchased'] = "Куплено кликов";
$GLOBALS['strDaysPurchased'] = "Куплено дней";
$GLOBALS['strHTML'] = "HTML";
$GLOBALS['strAddSep'] = "Заполнять поля выше ИЛИ поля ниже!";
$GLOBALS['strTextBelow'] = "Текст под картинкой";
$GLOBALS['strSubmit'] = "Загрузить баннер";
$GLOBALS['strUsername'] = "Логин";
$GLOBALS['strPassword'] = "Пароль";
$GLOBALS['strBannerAdmin'] = "Администрируем баннеры для";
$GLOBALS['strNoBanners'] = "Нет баннеров";
$GLOBALS['strBanner'] = "Баннер";
$GLOBALS['strCurrentBanner'] = "Текущий баннер";
$GLOBALS['strDelete'] = "Удалить";
$GLOBALS['strAddBanner'] = "Добавить новый баннер";
$GLOBALS['strModifyBanner'] = "Изменить баннер";
$GLOBALS['strURL'] = "URL (с http://)";
$GLOBALS['strKeyword'] = "ключевое слово (латиницей и цифрами)";
$GLOBALS['strWeight'] = "Вес";
$GLOBALS['strAlt'] = "Alt-Tекст";
$GLOBALS['strUsername'] = "Логин";
$GLOBALS['strPassword'] = "Пароль";
$GLOBALS['strAccessDenied'] = "Доступ запрещён";
$GLOBALS['strPasswordWrong'] = "Пароль указан неверно";
$GLOBALS['strNotAdmin'] = "Вероятно, у вас нет прав доступа";
$GLOBALS['strClientAdded'] = "Клиент добавлен.";
$GLOBALS['strClientModified'] = "Клиент изменён.";
$GLOBALS['strClientDeleted'] = "Клиент удален.";
$GLOBALS['strBannerAdmin'] = "Администрирование баннеров";
$GLOBALS['strBannerAdded'] = "Баннер добавлен.";
$GLOBALS['strBannerModified'] = "Баннер изменён.";
$GLOBALS['strBannerDeleted'] = "Баннер удалён";
$GLOBALS['strBannerChanged'] = "Баннер изменён";
$GLOBALS['strStats'] = "Статистика";
$GLOBALS['strDailyStats'] = "Статистика по дням";
$GLOBALS['strDetailStats'] = "Детальная статистика";
$GLOBALS['strCreditStats'] = "Статистика по кредитам";
$GLOBALS['strActive'] = "активен";
$GLOBALS['strActivate'] = "Активировать";
$GLOBALS['strDeActivate'] = "Деактивировать";
$GLOBALS['strAuthentification'] = "Доступ";
$GLOBALS['strGo'] = "Пошёл!";
$GLOBALS['strLinkedTo'] = "ссылка";
$GLOBALS['strBannerID'] = "Banner-ID";
$GLOBALS['strClientID'] = "Client ID";
$GLOBALS['strMailSubject'] = "Отчёт о рекламе";
$GLOBALS['strMailSubjectDeleted'] = "Деактивированные баннеры";
$GLOBALS['strMailHeader'] = "Дорогой {contact},\n";
$GLOBALS['strMailBannerStats'] = "Здесь вы видите статистику клиента {clientname}:";
$GLOBALS['strMailFooter'] = "с наилучшими пожеланиями,\n   {adminfullname}";
$GLOBALS['strLogMailSent'] = "[phpAds] Статистика успешно отправлена.";
$GLOBALS['strLogErrorClients'] = "[phpAds] ошибка доступа к базе данных информации о клиентах.";
$GLOBALS['strLogErrorBanners'] = "[phpAds] Ошибка доступа к БД баннеров.";
$GLOBALS['strLogErrorViews'] = "[phpAds] Ошибка доступа к БД показов.";
$GLOBALS['strLogErrorClicks'] = "[phpAds] Ошибка доступа к БД кликов.";
$GLOBALS['strLogErrorDisactivate'] = "[phpAds] Ошибка деактивации баннера.";
$GLOBALS['strRatio'] = "Рейтинг кликабельности";
$GLOBALS['strChooseBanner'] = "Выберите тип баннера.";
$GLOBALS['strMySQLBanner'] = "Баннер с вашего компьютера помещается в базу данных на сервере";
$GLOBALS['strWebBanner'] = "Баннер с вашего компьютера сохраняется в каталоге на веб-сервере";
$GLOBALS['strURLBanner'] = "Баннер лежит где-то в Интернет";
$GLOBALS['strHTMLBanner'] = "Текстовый баннер";
$GLOBALS['strNewBannerFile'] = "Файл баннера на диске";
$GLOBALS['strNewBannerURL'] = "URL баннера (с http://)";
$GLOBALS['strWidth'] = "ширина";
$GLOBALS['strHeight'] = "высота";
$GLOBALS['strTotalViews7Days'] = "Всего показов за неделю";
$GLOBALS['strTotalClicks7Days'] = "Всего кликов за неделю";
$GLOBALS['strAvgViews7Days'] = "В среднем показов за неделю";
$GLOBALS['strAvgClicks7Days'] = "В среднем кликов за неделю";
$GLOBALS['strTopTenHosts'] = "Top ten адресов просматривавших баннеры";
$GLOBALS['strClientIP'] = "IP Клиента";
$GLOBALS['strUserAgent'] = "regexp строки User-agent";
$GLOBALS['strWeekDay'] = "День недели (0 - 6) ((с воскресенья))";
$GLOBALS['strDomain'] = "Домен (без точки в начале)";
$GLOBALS['strSource'] = "Источник";
$GLOBALS['strTime'] = "Время";
$GLOBALS['strAllow'] = "Доступ открыт для";
$GLOBALS['strDeny'] = "Доступ закрыт для";
$GLOBALS['strExpiration'] = "Expiration";
$GLOBALS['strNoExpiration'] = "No expiration date set";
$GLOBALS['strDaysLeft'] = "Осталось дней";
$GLOBALS['strEstimated'] = "Estimated expiration";
$GLOBALS['strConfirm'] = "Вы уверены ?";
$GLOBALS['strBannerNoStats'] = "Нет статистики для этого баннера!";
$GLOBALS['strWeek'] = "Неделя";
$GLOBALS['strWeeklyStats'] = "Еженедельная статистика";
$GLOBALS['strWeekDay'] = "День недели";
$GLOBALS['strDate'] = "Дата";
$GLOBALS['strCTRShort'] = "CTR";
$GLOBALS['strDayShortCuts'] = array("Вс","Пн","Вт","Ср","Чт","Пт","Сб");
$GLOBALS['strShowWeeks'] = "Макс. число показываемых недель";
$GLOBALS['strAll'] = "все";
$GLOBALS['strAvg'] = "Среднее";
$GLOBALS['strHourly'] = "Просмотров/Кликов по часам";
$GLOBALS['strTotal'] = "Всего";
$GLOBALS['strUnlimited'] = "Не ограничено";
$GLOBALS['strSave'] = "Сохранить";
$GLOBALS['strUp'] = "Вверх";
$GLOBALS['strDown'] = "Вниз";
$GLOBALS['strSaved'] = "был сохранен!";
$GLOBALS['strDeleted'] = "был удален!";  
$GLOBALS['strMovedUp'] = "был перемещен выше";
$GLOBALS['strMovedDown'] = "был перемещен ниже";
$GLOBALS['strUpdated'] = "был обновлен";
$GLOBALS['strLogin'] = "Login";
$GLOBALS['strPreferences'] = "Предпочтения";
$GLOBALS['strAllowClientModifyInfo'] = "Разрешить этому пользователю редактировать собственные клиентские данные";
$GLOBALS['strAllowClientModifyBanner'] = "Разрешить этому пользователю модифицировать собственные баннеры";
$GLOBALS['strAllowClientAddBanner'] = "Разрешить этому пользователю добавлять новые баннеры";
$GLOBALS['strLanguage'] = "Язык";
$GLOBALS['strDefault'] = "По умолчанию";
$GLOBALS['strErrorViews'] = "Вы должны ввести число показов или выбрать 'Не ограничено' !";
$GLOBALS['strErrorNegViews'] = "Отрицательное число показов не разрешено";
$GLOBALS['strErrorClicks'] =  "Вы должны ввести число кликов или выбрать 'Не ограничено' !";
$GLOBALS['strErrorNegClicks'] = "Отрицательное число кликов не разрешено";
$GLOBALS['strErrorDays'] = "Вы должны ввести число дней или выбрать 'Не ограничено' !";
$GLOBALS['strErrorNegDays'] = "Отрицательное число дней не разрешено";
$GLOBALS['strTrackerImage'] = "Tracker image:";

// New strings for version 2
$GLOBALS['strNavigation'] 				= "Навигация";
$GLOBALS['strShortcuts'] 				= "Shortcuts";
$GLOBALS['strDescription'] 				= "Описание";
$GLOBALS['strClients'] 					= "Клиенты";
$GLOBALS['strID']				 		= "ID";
$GLOBALS['strOverall'] 					= "Всего";
$GLOBALS['strTotalBanners'] 			= "Всего баннеров";
$GLOBALS['strToday'] 					= "Сегодня";
$GLOBALS['strThisWeek'] 				= "За эту неделю";
$GLOBALS['strThisMonth'] 				= "За этот месяц";
$GLOBALS['strBasicInformation'] 		= "Основная информация";
$GLOBALS['strContractInformation'] 		= "Контрактная информация";
$GLOBALS['strLoginInformation'] 		= "Информация о логине";
$GLOBALS['strPermissions'] 				= "Допуски";
$GLOBALS['strGeneralSettings']			= "Общие установки";
$GLOBALS['strSaveChanges']		 		= "Сохранить изменения";
$GLOBALS['strCompact']					= "Компактно";
$GLOBALS['strVerbose']					= "Подробно";
$GLOBALS['strOrderBy']					= "order by";
$GLOBALS['strShowAllBanners']	 		= "Показать все баннеры";
$GLOBALS['strShowBannersNoAdClicks']	= "Показать баннеры без кликов";
$GLOBALS['strShowBannersNoAdViews']		= "Показать баннеры без просмотров";
$GLOBALS['strShowAllClients'] 			= "Показать всех клиентов";
$GLOBALS['strShowClientsActive'] 		= "Показать клиентов с активными баннерами";
$GLOBALS['strShowClientsInactive']		= "Показать клиентов с неактивными баннерами";
$GLOBALS['strSize']						= "Размер";

$GLOBALS['strMonth'] 					= array("Январь","Февраль","Март","Апрель","Май","Июнь","Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь");
$GLOBALS['strDontExpire']				= "Не деактивировать этого клиента по наступлению указанной даты";
$GLOBALS['strActivateNow'] 				= "Немедленно активировать этого клиента";
$GLOBALS['strExpirationDate']			= "Дата деактивации";
$GLOBALS['strActivationDate']			= "Дата активации";

$GLOBALS['strMailClientDeactivated'] 	= "Ваши баннеры бли выключены, так как";
$GLOBALS['strMailNothingLeft'] 			= "Если бы вы хотели продолжать размещать рекламу на нашем сайте, пожалуйста, свяжитесь с нами. Мы будем рады вновь слышать вас.";
$GLOBALS['strClientDeactivated']		= "Данный клиент в настоящее время деактивирован, так как";
$GLOBALS['strBeforeActivate']			= "дата активации еще не достигнута";
$GLOBALS['strAfterExpire']				= "была достигнута дата деактивации";
$GLOBALS['strNoMoreClicks']				= "все приобретенные клики использованы";
$GLOBALS['strNoMoreViews']				= "все приобретенные просмотры использованы";

$GLOBALS['strBanners'] 					= "Баннеры";
$GLOBALS['strCampaigns']				= "Кампании";
$GLOBALS['strCampaign']					= "Кампания";
$GLOBALS['strName']						= "Имя";
$GLOBALS['strBannersWithoutCampaign']	= "Баннеры без кампании";
$GLOBALS['strMoveToNewCampaign']		= "Перейти к новой кампании";
$GLOBALS['strCreateNewCampaign']		= "Создать новую кампанию";
$GLOBALS['strEditCampaign']				= "Редактировать кампанию";
$GLOBALS['strEdit']						= "Редактировать";
$GLOBALS['strCreate']					= "Создать";
$GLOBALS['strUntitled']					= "Без названия";

$GLOBALS['strTotalCampaigns'] 			= "Всего кампаний";
$GLOBALS['strActiveCampaigns'] 			= "Активных кампаний";

$GLOBALS['strLinkedTo']					= "связано с";
$GLOBALS['strSendAdvertisingReport']	= "Посылать рекламный отчет по e-mail";
$GLOBALS['strNoDaysBetweenReports']		= "Количество дней между отчетами";
$GLOBALS['strSendDeactivationWarning']  = "Посылать предупреждение, когда кампания деактивировануется";

$GLOBALS['strWarnClientTxt']			= "Количество нажатий или просмотров для ваших баннеров скоро станет меньше {limit}. ";
$GLOBALS['strViewsClicksLow']			= "Рекламные просмотры/нажатия подходят к концу";

$GLOBALS['strDays']						= "Дней";
$GLOBALS['strHistory']					= "История";
$GLOBALS['strAverage']					= "В среднем";
$GLOBALS['strDuplicateClientName']		= "Указанное имя пользователя уже существует, пожалуйста введите другое имя.";
$GLOBALS['strAllowClientDisableBanner'] = "Разрешить этому пользователю деактивировать его баннеры";
$GLOBALS['strAllowClientActivateBanner'] = "Разрешить этому пользователю активировать его баннеры";

$GLOBALS['strGenerateBannercode']		= "Сгенерировать баннерный код";
$GLOBALS['strChooseInvocationType']		= "Пожалуйста, выберите тип вызова баннера";
$GLOBALS['strGenerate']					= "Сгенерировать";
$GLOBALS['strParameters']				= "Параметры";
$GLOBALS['strUniqueidentifier']			= "Уникальный идентификатор";
$GLOBALS['strFrameSize']				= "Размер фрэйма";
$GLOBALS['strBannercode']				= "Баннерный код";

$GLOBALS['strSearch']					= "Поиск";
$GLOBALS['strNoMatchesFound']			= "Ничего не найдено";

$GLOBALS['strNoViewLoggedInInterval']   = "За период данного отчета не было зарегистрировано просмотров";
$GLOBALS['strNoClickLoggedInInterval']  = "За период данного отчета не было зарегистрировано нажатий";
$GLOBALS['strMailReportPeriod']			= "Этот отчет включает в себя статистику с {startdate} по {enddate}.";
$GLOBALS['strMailReportPeriodAll']		= "Этот отчет включает в себя всю статистику вплоть до {enddate}.";
$GLOBALS['strNoStatsForCampaign'] 		= "Нет статистики для этой кампании";
$GLOBALS['strFrom']						= "С";
$GLOBALS['strTo']						= "по";
$GLOBALS['strMaintenance']				= "Обслуживание";
$GLOBALS['strCampaignStats']			= "Статистика по кампаниям";
$GLOBALS['strClientStats']				= "Статистика по клиентам";
$GLOBALS['strErrorOccurred']			= "Произошла ошибка";
$GLOBALS['strAdReportSent']				= "Отчет о рекламе выслан";

$GLOBALS['strAutoChangeHTML']			= "Изменить HTML для подсчета кликов";

$GLOBALS['strZones']					= "Зоны";
$GLOBALS['strAddZone']					= "Создать зону";
$GLOBALS['strModifyZone']				= "Редактировать зону";
$GLOBALS['strAddNewZone']				= "Добавить новую зону";

$GLOBALS['strOverview']					= "Обозрение";
$GLOBALS['strEqualTo']					= "равно";
$GLOBALS['strDifferentFrom']			= "отличается от";
$GLOBALS['strAND']						= "AND";  // logical operator
$GLOBALS['strOR']						= "OR"; // logical operator
$GLOBALS['strOnlyDisplayWhen']			= "Показывать этот баннер только когда:";

$GLOBALS['strStatusText']				= "Описание статуса";

$GLOBALS['strConfirmDeleteClient'] 		= "Вы действительно хотите удалить этого клиента?";
$GLOBALS['strConfirmDeleteCampaign']	= "Вы действительно хотите удалить эту кампанию?";
$GLOBALS['strConfirmDeleteBanner']		= "Вы действительно хотите удалить этот баннер?";
$GLOBALS['strConfirmResetStats']		= "Вы действительно хотите обнулить всю статистику?";
$GLOBALS['strConfirmResetCampaignStats']= "Вы действительно хотите обнулить статистику для этой кампании?";
$GLOBALS['strConfirmResetClientStats']	= "Вы действительно хотите обнулить статистику для этого клиента ?";
$GLOBALS['strConfirmResetBannerStats']	= "Вы действительно хотите обнулить статистику для этого баннера?";

$GLOBALS['strClientsAndCampaigns']		= "Клиенты и кампании";
$GLOBALS['strCampaignOverview']			= "Обзор кампании";
$GLOBALS['strReports']					= "Отчеты";
$GLOBALS['strShowBanner']				= "Показать баннер";

$GLOBALS['strIncludedBanners']			= "Связанные баннеры";
$GLOBALS['strProbability']				= "Вероятность";
$GLOBALS['strInvocationcode']			= "Код вызова";
$GLOBALS['strSelectZoneType']			= "Пожалуйста, выберите тип связи баннеров";
$GLOBALS['strBannerSelection']			= "Выбор баннеров";
$GLOBALS['strInteractive']				= "Интерактивный";
$GLOBALS['strRawQueryString']			= "Строка запроса 'как есть'";

$GLOBALS['strBannerWeight']				= "Вес баннера";
$GLOBALS['strCampaignWeight']			= "Вес кампании";

$GLOBALS['strZoneCacheOn']				= "Кэширование зон включено";
$GLOBALS['strZoneCacheOff']				= "Кэширование зон выключено";
$GLOBALS['strCachedZones']				= "Закэшированные зоны";
$GLOBALS['strSizeOfCache']				= "Размер кэша";
$GLOBALS['strAverageAge']				= "Среднее время нахождения в кэше";
$GLOBALS['strRebuildZoneCache']			= "Построить кэш зон заново";
$GLOBALS['strKiloByte']					= "KB";
$GLOBALS['strSeconds']					= "секунд";
$GLOBALS['strExpired']					= "Устарело";

$GLOBALS['strModifyBannerAcl'] 			= "Ограниченя показа";
$GLOBALS['strACL'] 						= "Лимит";
$GLOBALS['strNoMoveUp'] 				= "Не могу переместить первый ряд выше";
$GLOBALS['strACLAdd'] 					= "Добавить новое ограничение";
$GLOBALS['strNoLimitations']			= "Ограничений нет";

$GLOBALS['strLinkedZones']				= "Связанные зоны";
$GLOBALS['strNoZonesToLink']			= "Зон, к которым может быть отнесен данный баннер, нет";
$GLOBALS['strNoZones']					= "There are currently no zones defined";
$GLOBALS['strNoClients']				= "There are currently no clients defined";
$GLOBALS['strNoStats']					= "There are currently no statistics available";

$GLOBALS['strCustom']					= "Custom";

$GLOBALS['strSettings'] 				= "Settings";

$GLOBALS['strAffiliates']				= "Affiliates";
$GLOBALS['strAffiliatesAndZones']		= "Affiliates & Zones";
$GLOBALS['strAddAffiliate']				= "Create affiliate";
$GLOBALS['strModifyAffiliate']			= "Modify affiliate";
$GLOBALS['strAddNewAffiliate']			= "Add new affiliate";

$GLOBALS['strCheckAllNone']				= "Check all / none";

$GLOBALS['strAllowAffiliateModifyInfo'] = "Allow this user to modify his own affiliate information";
$GLOBALS['strAllowAffiliateModifyZones'] = "Allow this user to modify his own zones";
$GLOBALS['strAllowAffiliateLinkBanners'] = "Allow this user to link banners to his own zones";
$GLOBALS['strAllowAffiliateAddZone'] = "Allow this user to define new zones";
$GLOBALS['strAllowAffiliateDeleteZone'] = "Allow this user to delete existing zones";

$GLOBALS['strPriority']					= "Priority";
$GLOBALS['strHighPriority']				= "Show banners in this campaign with high priority.<br>
										   If you use this option phpAdsNew will try to distribute the 
										   number of AdViews evenly over the course of the day.";
$GLOBALS['strLowPriority']				= "Show banner in this campaign with low priority.<br>
										   This campaign is used to show the left over AdViews which 
										   aren't used by high priority campaigns.";
$GLOBALS['strTargetLimitAdviews']		= "Limit the number of AdViews to";
$GLOBALS['strTargetPerDay']				= "per day.";
$GLOBALS['strRecalculatePriority']		= "Recalculate priority";

$GLOBALS['strProperties']				= "Properties";
$GLOBALS['strAffiliateProperties']		= "Affiliate Properties";
$GLOBALS['strBannerOverview']			= "Banner Overview";
$GLOBALS['strBannerProperties']			= "Banner Properties";
$GLOBALS['strCampaignProperties']		= "Campaign Properties";
$GLOBALS['strClientProperties']			= "Client Properties";
$GLOBALS['strZoneOverview']				= "Zone Overview";
$GLOBALS['strZoneProperties']			= "Zone Properties";

$GLOBALS['strGlobalHistory']			= "Global History";

$GLOBALS['strMoveTo']					= "Move to";
$GLOBALS['strDuplicate']				= "Duplicate";

$GLOBALS['strMainSettings']				= "Main settings";
$GLOBALS['strAdminSettings']			= "Administration settings";

$GLOBALS['strApplyLimitationsTo']		= "Apply limitations to";
$GLOBALS['strWholeCampaign']			= "Whole campaign";
$GLOBALS['strZonesWithoutAffiliate']	= "Zones without affiliate";
$GLOBALS['strMoveToNewAffiliate']		= "Move to new affiliate";

$GLOBALS['strNoBannersToLink']			= "There are currently no banners available which can be linked to this zone";

$GLOBALS['strAdviewsLimit']				= "AdViews limit";

?>