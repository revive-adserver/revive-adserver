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


// Set text direction and characterset
$GLOBALS['phpAds_TextDirection']  = "ltr";
$GLOBALS['phpAds_TextAlignRight'] = "right";
$GLOBALS['phpAds_TextAlignLeft']  = "left";
$GLOBALS['phpAds_CharSet'] = "koi8-r";


// Set translation strings
$GLOBALS['strHome'] = "Главная страница";
$GLOBALS['date_format'] = "%d/%m/%Y";
$GLOBALS['time_format'] = "%H:%M:%S";
$GLOBALS['strMySQLError'] = "Ошибка MySQL:";
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
$GLOBALS['strCTR'] = "Отношение клики/показы (CTR)";
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
$GLOBALS['strBannerID'] = "ID баннера";
$GLOBALS['strClientID'] = "ID клиента";
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
$GLOBALS['strClientIP'] = "IP клиента";
$GLOBALS['strUserAgent'] = "regexp строки User-agent";
$GLOBALS['strWeekDay'] = "День недели (0 - 6) ((с воскресенья))";
$GLOBALS['strDomain'] = "Домен (без точки в начале)";
$GLOBALS['strSource'] = "Источник";
$GLOBALS['strTime'] = "Время";
$GLOBALS['strAllow'] = "Доступ открыт для";
$GLOBALS['strDeny'] = "Доступ закрыт для";
$GLOBALS['strResetStats'] = "Обнулить статистику";
$GLOBALS['strExpiration'] = "Годность";
$GLOBALS['strNoExpiration'] = "Срок годности не установлен";
$GLOBALS['strDaysLeft'] = "Осталось дней";
$GLOBALS['strEstimated'] = "Годен приблизительно до";
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
$GLOBALS['strUp'] = "Вверх";
$GLOBALS['strDown'] = "Вниз";
$GLOBALS['strSave'] = "Сохранить";
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
$GLOBALS['strTrackerImage'] = "Картинка слежения:";

// New strings for version 2
$GLOBALS['strNavigation'] 				= "Навигация";
$GLOBALS['strShortcuts'] 				= "Сокращения";
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
$GLOBALS['strOrderBy']					= "отсортировать по";
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
$GLOBALS['strModifyCampaign']			= "Редактировать кампанию";
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
$GLOBALS['strAND']						= "И";  // logical operator
$GLOBALS['strOR']						= "ИЛИ"; // logical operator
$GLOBALS['strOnlyDisplayWhen']			= "Показывать этот баннер только когда:";

$GLOBALS['strStatusText']				= "Описание статуса";

$GLOBALS['strConfirmDeleteClient'] 		= "Вы действительно хотите удалить этого клиента?";
$GLOBALS['strConfirmDeleteCampaign']	= "Вы действительно хотите удалить эту кампанию?";
$GLOBALS['strConfirmDeleteBanner']		= "Вы действительно хотите удалить этот баннер?";
$GLOBALS['strConfirmDeleteZone']		= "Вы действительно хотите удалить эту зону?";
$GLOBALS['strConfirmDeleteAffiliate']	= "Вы действительно хотите удалить этого партнера?";

$GLOBALS['strConfirmResetStats']		= "Вы действительно хотите обнулить всю статистику?";
$GLOBALS['strConfirmResetCampaignStats']= "Вы действительно хотите обнулить статистику для этой кампании?";
$GLOBALS['strConfirmResetClientStats']	= "Вы действительно хотите обнулить статистику для этого клиента?";
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
$GLOBALS['strNoZones']					= "Сейчас не определено ни одной зоны";
$GLOBALS['strNoClients']				= "Сечас не определено ни одного клиента";
$GLOBALS['strNoStats']					= "Сейчас не доступно никакой статистики";
$GLOBALS['strNoAffiliates']				= "Сейчас не определен ни один издатель";

$GLOBALS['strCustom']					= "Нестандартный";

$GLOBALS['strSettings'] 				= "Настройки";

$GLOBALS['strAffiliates']				= "Издатели";
$GLOBALS['strAffiliatesAndZones']		= "Издатели и зоны";
$GLOBALS['strAddAffiliate']				= "Создать издателя";
$GLOBALS['strModifyAffiliate']			= "Редактировать издателя";
$GLOBALS['strAddNewAffiliate']			= "Добавить нового издателя";

$GLOBALS['strCheckAllNone']				= "Пометить всё / ничего";

$GLOBALS['strAllowAffiliateModifyInfo'] = "Разрешить этому пользователю редактировать свою издательскую информацию";
$GLOBALS['strAllowAffiliateModifyZones'] = "Разрешить этому пользователю редактировать его собственные зоны";
$GLOBALS['strAllowAffiliateLinkBanners'] = "Разрешить этому пользователю свзяывать баннеры с его собственными зонами";
$GLOBALS['strAllowAffiliateAddZone'] = "Разрешить этому пользователю определять новые зоны";
$GLOBALS['strAllowAffiliateDeleteZone'] = "Разрешить этому пользователю удалять существующие зоны";

$GLOBALS['strPriority']					= "Приоритет";
$GLOBALS['strHighPriority']				= "Показывать баннеры в этой кампании с высоким приоритетом.<br>
										   Если вы используете эту опцию, phpAdsNew будет пытаться распределить 
										   количество просмотров равномерно по всему дню.";
$GLOBALS['strLowPriority']				= "Показывать баннеры в этой кампании с низким приоритетом.<br>
										   Эта кампания используетися для показа оставшихся просмотров, которые 
										   не используются высокоприоритетными кампаниями.";
$GLOBALS['strTargetLimitAdviews']		= "Ошраничить количество показов до";
$GLOBALS['strTargetPerDay']				= "в день.";
$GLOBALS['strRecalculatePriority']		= "Пересчитать приоритеты";

$GLOBALS['strProperties']				= "Параметры";
$GLOBALS['strAffiliateProperties']		= "Свойства издателя";
$GLOBALS['strBannerOverview']			= "Обозрение баннера";
$GLOBALS['strBannerProperties']			= "Параметры баннера";
$GLOBALS['strCampaignProperties']		= "Параметры кампании";
$GLOBALS['strClientProperties']			= "Параметры клиента";
$GLOBALS['strZoneOverview']				= "Обозрение зоны";
$GLOBALS['strZoneProperties']			= "Параметры зоны";
$GLOBALS['strAffiliateOverview']		= "Обозрение издателя";
$GLOBALS['strLinkedBannersOverview']	= "Обозрение связанных баннеров";

$GLOBALS['strGlobalHistory']			= "Общая история";
$GLOBALS['strBannerHistory']			= "История баннеров";
$GLOBALS['strCampaignHistory']			= "История кампаний";
$GLOBALS['strClientHistory']			= "История клиентов";
$GLOBALS['strAffiliateHistory']			= "История издателей";
$GLOBALS['strZoneHistory']				= "История зон";
$GLOBALS['strLinkedBannerHistory']		= "История связанных баннеров";

$GLOBALS['strMoveTo']					= "Переместить в";
$GLOBALS['strDuplicate']				= "Скопировать";

$GLOBALS['strMainSettings']				= "Главные настройки";
$GLOBALS['strAdminSettings']			= "Административные настройки";

$GLOBALS['strApplyLimitationsTo']		= "Применить ограничения к";
$GLOBALS['strWholeCampaign']			= "Всей кампании";
$GLOBALS['strZonesWithoutAffiliate']	= "Зонам без издателя";
$GLOBALS['strMoveToNewAffiliate']		= "Переместить к новому издателю";

$GLOBALS['strNoBannersToLink']			= "Сейчас нет баннеров, которые могли бы быть привязаны к этой зоне";
$GLOBALS['strNoLinkedBanners']			= "Сейчас нет баннеров, которые привязаны к этой зоне";

$GLOBALS['strAdviewsLimit']				= "Лимит показов";

$GLOBALS['strTotalThisPeriod']			= "Всего за этот период";
$GLOBALS['strAverageThisPeriod']		= "В среднем за этот период";
$GLOBALS['strLast7Days']				= "Последние 7 дней";
$GLOBALS['strDistribution']				= "Распределение";
$GLOBALS['strOther']					= "Другое";
$GLOBALS['strUnknown']					= "Неизвестное";

$GLOBALS['strWelcomeTo']				= "Добро пожаловать в";
$GLOBALS['strEnterUsername']			= "Введите ваш логин и пароль для входа в систему";

$GLOBALS['strBannerNetwork']			= "Баннерная сеть";
$GLOBALS['strMoreInformation']			= "Доп. информация...";
$GLOBALS['strChooseNetwork']			= "Выберите баннерную сеть, которую вы хотите использовать";
$GLOBALS['strRichMedia']				= "Richmedia";
$GLOBALS['strTrackAdClicks']			= "Отслеживать клики";
$GLOBALS['strYes']						= "Да";
$GLOBALS['strNo']						= "Нет";
$GLOBALS['strUploadOrKeep']				= "Хотите сохранить уже<br>имеющуюся картинку: или хотите <br>загрузить другую?";
$GLOBALS['strCheckSWF']					= "Проверять наличие жестко закодированных линков внутри Flash-файлов";
$GLOBALS['strURL2']						= "URL";
$GLOBALS['strTarget']					= "Target";
$GLOBALS['strConvert']					= "Преобразовать";
$GLOBALS['strCancel']					= "Отменить";

$GLOBALS['strConvertSWFLinks']			= "Преобразовать Flash-линки";
$GLOBALS['strHardcodedLinks']                   = "Жёстко закодированные ссылки";
$GLOBALS['strConvertSWF']				= "<br>Flash-файл, который вы только что загрузили, содержит жестко закодированные URL-ы. phpAdsNew не сможет ".
										  "отслеживать клики для этого баннера, если вы не преобразуете эти ".
										  "линки. Ниже вы найдете список всех URL внутри этого Flash-файла. ".
										  "Если вы хотите их преобразовать, щелкните по <b>Преобразовать</b>, в противном случае ".
										  "<b>Отменить</b>.<br><br>".
										  "Заметьте: если вы щелкнете по <b>Преобразовать</b>, Flash-файл, ".
									  	  "который вы только что загрузили, будет физически изменен. <br>Пожалуйста, сохраните резервную копию ".
										  "исходного файла. Вне зависимости от того, какой версией Flash был создан этот баннер, получившийся ".
										  "файл потребует Flash 4 (или старше) проигрыватель для корректного отображения.<br><br>";

$GLOBALS['strCompressSWF']                      = "Сжать SWF-файл для ускорения загрузки (требует установки Flash 6 плагина)";
$GLOBALS['strOverwriteSource']          = "Перезаписать параметр источника";

$GLOBALS['strSourceStats']				= "Статистика по источнику";
$GLOBALS['strSelectSource']				= "Выберите источник, который вы хотите просмотреть:";
$GLOBALS['strSizeDistribution']         = "Распределение по размеру";
$GLOBALS['strCountryDistribution']      = "Распределение по стране";
$GLOBALS['strEffectivity']                      = "Эффективность";


$GLOBALS['strDelimiter']                        = "Разделитель";
$GLOBALS['strMiscellaneous']            = "Разное";


$GLOBALS['strErrorUploadSecurity']              = "Обнаружена возможная проблема с безопасностью, загрузка остановлена!";
$GLOBALS['strErrorUploadBasedir']               = "Загруженный файл недоступен, вероятно, в результате действия safe_mode или ограничений open_basedir";
$GLOBALS['strErrorUploadUnknown']               = "Не могу получить доступ к загруженному файлу по неизвестной причине. Пожалуйста, проверьте настройки PHP!";
$GLOBALS['strErrorStoreLocal']                  = "Во время попытки сохранения баннера в локальном каталоге произошла ошибка. Вероятно, это результат неверного указания пути к локальному каталогу";
$GLOBALS['strErrorStoreFTP']                    = "Во время попытки загрузки баннера на FTP-сервер произошла ошибка. Это может быть из-за того, что сервер недоступен, или из-за неправильной настройки его параметров";

// Zone probability
$GLOBALS['strZoneProbListChain']                = "Все баннеры, связанные с выбранной зоной, имеют нулевой приоритет. Цепь вызова зон, которая будет использована:";
$GLOBALS['strZoneProbNullPri']                  = "Все баннеры, связанные с этой зоной, имеют нулевой приоритет";

// Hosts
$GLOBALS['strHosts']                            = "Хосты";
$GLOBALS['strTopHosts']                         = "Лучшие хосты";
$GLOBALS['strTopCountries']             = "Лучшие страны";
$GLOBALS['strRecentHosts']                      = "Недавно просматривавшие хосты";


?>