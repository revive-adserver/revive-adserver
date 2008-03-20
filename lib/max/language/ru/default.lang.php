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

// Set text direction and characterset
$GLOBALS['phpAds_TextDirection']  = "ltr";
$GLOBALS['phpAds_TextAlignRight'] = "right";
$GLOBALS['phpAds_TextAlignLeft']  = "left";

// Set translation strings
$GLOBALS['strHome'] = "Дом";
$GLOBALS['date_format'] = "%d/%m/%Y";
$GLOBALS['time_format'] = "%H:%M:%S";
$GLOBALS['strMySQLError'] = "Ошибка MySQL:";
$GLOBALS['strAdminstration'] = "Администрирование";
$GLOBALS['strAddClient'] = "Добавить клиента";
$GLOBALS['strAddClient_Key']            = "Добавить <u>н</u>ового клиента";
$GLOBALS['strModifyClient'] = "Изменить клиента";
$GLOBALS['strDeleteClient'] = "Удалить клиента";
$GLOBALS['strViewClientStats'] = "Посмотреть статистику клиента";
$GLOBALS['strClientName'] = "Клиент";
$GLOBALS['strContact'] = "Контакт";
$GLOBALS['strEMail'] = "E-mail";
$GLOBALS['strImpressions'] =
$GLOBALS['strViews'] = "Показов";
$GLOBALS['strClicks'] = "Кликов";
$GLOBALS['strTotalViews'] = "Всего показов";
$GLOBALS['strTotalClicks'] = "Всего кликов";
$GLOBALS['strCTR'] = "Отношение клики/показы (CTR)";
$GLOBALS['strTotalClients'] = "Всего клиентов";
$GLOBALS['strActiveClients'] = "Активных клиентов";
$GLOBALS['strActiveBanners'] = "Активных баннеров";
$GLOBALS['strLogout'] = "Выход";
$GLOBALS['strCreditStats'] = "Статистика по кредитам";
$GLOBALS['strViewCredits'] = "Кредиты по показам";
$GLOBALS['strClickCredits'] = "Кредиты по кликам";
$GLOBALS['strPrevious'] = "Предыдущий";
$GLOBALS['strPrevious_Key']                     = "<u>П</u>редыдущий";
$GLOBALS['strNext'] = "Следующий";
$GLOBALS['strNext_Key']                                 = "<u>C</u>ледующий";
$GLOBALS['strNone'] = "Нет";
$GLOBALS['strImpressionsPurchased'] =
$GLOBALS['strViewsPurchased'] = "Куплено показов";
$GLOBALS['strClicksPurchased'] = "Куплено кликов";
$GLOBALS['strDaysPurchased'] = "Куплено дней";
$GLOBALS['strHTML'] = "HTML";
$GLOBALS['strAddSep'] = "Заполнять поля выше ИЛИ поля ниже!";
$GLOBALS['strTextBelow'] = "Текст под картинкой";
$GLOBALS['strSubmit'] = "Загрузить баннер";
$GLOBALS['strUsername'] = "Имя пользователя";
$GLOBALS['strPassword'] = "Пароль";
$GLOBALS['strBannerAdmin'] = "Администрируем баннеры для";
$GLOBALS['strNoBanners'] = "Нет баннеров";
$GLOBALS['strBanner'] = "Баннер";
$GLOBALS['strCurrentBanner'] = "Текущий баннер";
$GLOBALS['strDelete'] = "Удалить";
$GLOBALS['strAddBanner'] = "Добавить новый баннер";
$GLOBALS['strAddBanner_Key']                    = "Добавить <u>н</u>овый баннер";
$GLOBALS['strModifyBanner'] = "Изменить баннер";
$GLOBALS['strURL'] = "URL перехода (с http://)";
$GLOBALS['strKeyword'] = "Ключевое слово (латиницей и цифрами)";
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
$GLOBALS['strLinkedTo'] = "связано с";
$GLOBALS['strBannerID'] = "ID баннера";
$GLOBALS['strClientID'] = "ID клиента";
$GLOBALS['strMailSubject'] = "Отчёт о рекламе";
$GLOBALS['strMailSubjectDeleted'] = "Деактивированные баннеры";
$GLOBALS['strMailHeader'] = "Дорогой {contact},
";
$GLOBALS['strMailBannerStats'] = "Здесь вы видите статистику клиента {clientname}:";
$GLOBALS['strMailFooter'] = "с наилучшими пожеланиями,
   {adminfullname}";
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
$GLOBALS['strHTMLBanner'] = "HTML-баннер";
$GLOBALS['strNewBannerFile'] = "Файл баннера на диске";
$GLOBALS['strNewBannerURL'] = "URL изображения (с http://)";
$GLOBALS['strWidth'] = "ширина";
$GLOBALS['strHeight'] = "высота";
$GLOBALS['strTotalViews7Days'] = "Всего показов за неделю";
$GLOBALS['strTotalClicks7Days'] = "Всего кликов за неделю";
$GLOBALS['strAvgViews7Days'] = "В среднем показов за неделю";
$GLOBALS['strAvgClicks7Days'] = "В среднем кликов за неделю";
$GLOBALS['strClientIP'] = "IP клиента";
$GLOBALS['strUserAgent'] = "regexp строки User-agent";
$GLOBALS['strWeekDay'] = "День недели";
$GLOBALS['strDomain'] = "Домен (без точки в начале)";
$GLOBALS['strSource'] = "Источник";
$GLOBALS['strTime'] = "Время";
$GLOBALS['strAllow'] = "Доступ открыт для";
$GLOBALS['strDeny'] = "Доступ закрыт для";
$GLOBALS['strResetStats'] = "Обнулить статистику";
$GLOBALS['strExpiration'] = "Срок окончания";
$GLOBALS['strNoExpiration'] = "Срок окончания не установлен";
$GLOBALS['strDaysLeft'] = "Осталось дней";
$GLOBALS['strEstimated'] = "Ожидаемое окончание";
$GLOBALS['strConfirm'] = "Вы уверены ?";
$GLOBALS['strBannerNoStats'] = "Нет статистики для этого баннера!";
$GLOBALS['strWeek'] = "Неделя";
$GLOBALS['strWeeklyStats'] = "Еженедельная статистика";
$GLOBALS['strWeekDay'] = "День недели";
$GLOBALS['strDate'] = "Дата";
$GLOBALS['strCTRShort'] = "CTR";
$GLOBALS['strDayShortCuts'][0] = "Вс";
$GLOBALS['strDayShortCuts'][1] = "Пн";
$GLOBALS['strDayShortCuts'][2] = "Вт";
$GLOBALS['strDayShortCuts'][3] = "Ср";
$GLOBALS['strDayShortCuts'][4] = "Чт";
$GLOBALS['strDayShortCuts'][5] = "Пт";
$GLOBALS['strDayShortCuts'][6] = "Сб";

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
$GLOBALS['strDeleted'] = "удалён";
$GLOBALS['strMovedUp'] = "был перемещен выше";
$GLOBALS['strMovedDown'] = "был перемещен ниже";
$GLOBALS['strUpdated'] = "обновлён";
$GLOBALS['strLogin'] = "Логин";
$GLOBALS['strPreferences'] = "Настройки";
$GLOBALS['strAllowClientModifyInfo'] = "Разрешить редактировать собственные клиентские данные";
$GLOBALS['strAllowClientModifyBanner'] = "Разрешить модифицировать собственные баннеры";
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
$GLOBALS['strPermissions'] 				= "Права доступа";
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

$GLOBALS['strMonth'][0] = "Январь";
$GLOBALS['strMonth'][1] = "Февраль";
$GLOBALS['strMonth'][2] = "Март";
$GLOBALS['strMonth'][3] = "Апрель";
$GLOBALS['strMonth'][4] = "Май";
$GLOBALS['strMonth'][5] = "Июнь";
$GLOBALS['strMonth'][6] = "Июль";
$GLOBALS['strMonth'][7] = "Август";
$GLOBALS['strMonth'][8] = "Сентябрь";
$GLOBALS['strMonth'][9] = "Октябрь";
$GLOBALS['strMonth'][10] = "Ноябрь";
$GLOBALS['strMonth'][11] = "Декабрь";

$GLOBALS['strDontExpire']				= "Не деактивировать этого клиента по наступлению указанной даты";
$GLOBALS['strActivateNow'] 				= "Немедленно активировать этого клиента";
$GLOBALS['strExpirationDate']			= "Дата деактивации";
$GLOBALS['strActivationDate']			= "Дата активации";

$GLOBALS['strMailClientDeactivated'] 	= "Ваши баннеры бли выключены, так как";
$GLOBALS['strMailNothingLeft'] 			= "Если бы вы хотели продолжать размещать рекламу на нашем сайте, пожалуйста, свяжитесь с нами.";
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
$GLOBALS['strAddCampaign']                      = "Добавить новую кампанию";
$GLOBALS['strAddCampaign_Key']          = "Добавить <u>н</u>овую кампанию";

$GLOBALS['strEdit']						= "Редактировать";
$GLOBALS['strCreate']					= "Создать";
$GLOBALS['strUntitled']					= "Без названия";

$GLOBALS['strTotalCampaigns'] 			= "Всего кампаний";
$GLOBALS['strActiveCampaigns'] 			= "Активных кампаний";

$GLOBALS['strLinkedTo']					= "связано с";
$GLOBALS['strSendAdvertisingReport']	= "Посылать рекламный отчет по E-mail";
$GLOBALS['strNoDaysBetweenReports']		= "Дней между отчетами";
$GLOBALS['strSendDeactivationWarning']  = "Посылать предупреждение, когда кампания деактивируется";

$GLOBALS['strWarnClientTxt']			= "Количество действий, кликов или показов для ваших баннеров скоро станет меньше {limit}. ";
$GLOBALS['strImpressionsClicksLow']		=
$GLOBALS['strViewsClicksLow']			= "Рекламные просмотры/нажатия подходят к концу";

$GLOBALS['strDays']						= "Дней";
$GLOBALS['strHistory']					= "История";
$GLOBALS['strAverage']					= "В среднем";
$GLOBALS['strDuplicateClientName']		= "Указанное имя пользователя уже существует, пожалуйста введите другое имя.";
$GLOBALS['strAllowClientDisableBanner'] = "Разрешить деактивировать его баннеры";
$GLOBALS['strAllowClientActivateBanner'] = "Разрешить активировать его баннеры";

$GLOBALS['strGenerateBannercode']		= "Сгенерировать баннерный код";
$GLOBALS['strChooseInvocationType']		= "Пожалуйста, выберите тип вызова баннера";
$GLOBALS['strGenerate']					= "Сгенерировать";
$GLOBALS['strParameters']				= "Настройки метки";
$GLOBALS['strUniqueidentifier']			= "Уникальный идентификатор";
$GLOBALS['strFrameSize']				= "Размер фрейма";
$GLOBALS['strBannercode']				= "Баннерный код";

$GLOBALS['strSearch']					= "<u>П</u>оиск";
$GLOBALS['strNoMatchesFound']			= "Ничего не найдено";

$GLOBALS['strNoViewLoggedInInterval']   = "За период данного отчета не было зарегистрировано показов";
$GLOBALS['strNoClickLoggedInInterval']  = "За период данного отчета не было зарегистрировано кликов";
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
$GLOBALS['strAddNewZone_Key']                   = "Добавить <u>н</u>овую зону";

$GLOBALS['strOverview']					= "Обозрение";
$GLOBALS['strEqualTo']					= "равно";
$GLOBALS['strDifferentFrom']			= "отличается от";
$GLOBALS['strAND']						= "И";  // logical operator
$GLOBALS['strOR']						= "ИЛИ"; // logical operator
$GLOBALS['strOnlyDisplayWhen']			= "Показывать этот баннер только когда:";

$GLOBALS['strStatusText']				= "Текст в строке состояния";

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

$GLOBALS['strModifyBannerAcl'] 			= "Ограничения показа";
$GLOBALS['strACL'] 						= "Лимит";
$GLOBALS['strNoMoveUp'] 				= "Не могу переместить первый ряд выше";
$GLOBALS['strACLAdd'] 					= "Добавить новое ограничение";
$GLOBALS['strACLAdd_Key']                               = "Добавить <u>н</u>овое ограничение";
$GLOBALS['strNoLimitations']			= "Ограничений нет";

$GLOBALS['strLinkedZones']				= "Связанные зоны";
$GLOBALS['strNoZonesToLink']			= "Зон, к которым может быть отнесен данный баннер, нет";
$GLOBALS['strNoZones']					= "Сейчас не определено ни одной зоны";
$GLOBALS['strNoClients']				= "Сейчас не определено ни одного клиента";
$GLOBALS['strNoStats']					= "Сейчас не доступно никакой статистики";
$GLOBALS['strNoAffiliates']				= "Сейчас не определен ни один издатель";

$GLOBALS['strCustom']					= "Нестандартный";

$GLOBALS['strSettings'] 				= "Настройки";

$GLOBALS['strAffiliates']				= "Издатели";
$GLOBALS['strAffiliatesAndZones']		= "Издатели и зоны";
$GLOBALS['strAddAffiliate']				= "Создать издателя";
$GLOBALS['strModifyAffiliate']			= "Редактировать издателя";
$GLOBALS['strAddNewAffiliate']			= "Добавить нового издателя";
$GLOBALS['strAddNewAffiliate_Key']                      = "Добавить <u>н</u>ового издателя";

$GLOBALS['strCheckAllNone']				= "Пометить всё / ничего";

$GLOBALS['strExpandAll']                        = "<u>Р</u>аскрыть всё";
$GLOBALS['strCollapseAll']                      = "<u>З</u>акрыть всё";


$GLOBALS['strAllowAffiliateModifyInfo'] = "Разрешить редактировать свою издательскую информацию";
$GLOBALS['strAllowAffiliateModifyZones'] = "Разрешить редактировать его собственные зоны";
$GLOBALS['strAllowAffiliateLinkBanners'] = "Разрешить связывать баннеры с его собственными зонами";
$GLOBALS['strAllowAffiliateAddZone'] = "Разрешить определять новые зоны";
$GLOBALS['strAllowAffiliateDeleteZone'] = "Разрешить удалять существующие зоны";

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
$GLOBALS['strCheckSWF']					= "Проверять наличие жестко закодированных ссылок внутри Flash-файлов";
$GLOBALS['strURL2']						= "URL";
$GLOBALS['strTarget']					= "Target";
$GLOBALS['strConvert']					= "Преобразовать";
$GLOBALS['strCancel']					= "Отменить";

$GLOBALS['strConvertSWFLinks']			= "Преобразовать Flash-ссылки";
$GLOBALS['strHardcodedLinks']                   = "Жёстко закодированные ссылки";
$GLOBALS['strConvertSWF']				= "<br>Flash-файл, который вы только что загрузили, содержит жестко закодированные URL. phpAdsNew не сможет отслеживать клики для этого баннера, если вы не преобразуете эти ссылки. Ниже вы найдете список всех URL внутри этого Flash-файла. Если вы хотите их преобразовать, щелкните по <b>Преобразовать</b>, в противном случае <b>Отменить</b>.<br><br>Заметьте: если вы щелкнете по <b>Преобразовать</b>, Flash-файл, который вы только что загрузили, будет физически изменен. <br>Пожалуйста, сохраните резервную копию исходного файла. Вне зависимости от того, какой версией Flash был создан этот баннер, получившийся файл потребует Flash 4 (или старше) проигрыватель для корректного отображения.<br><br>";

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
$GLOBALS['strZoneProbListChain']                = "Все баннеры, связанные с выбранной зоной, неактивны. Цепь вызова зон, которая будет использована:";
$GLOBALS['strZoneProbNullPri']                  = "Все баннеры, связанные с этой зоной, неактивны";

// Hosts
$GLOBALS['strHosts']                            = "Хосты";
$GLOBALS['strTopHosts']                         = "Лучшие хосты";
$GLOBALS['strTopCountries']             = "Лучшие страны";
$GLOBALS['strRecentHosts']                      = "Недавно просматривавшие хосты";

// Reserved keys
// Do not change these unless absolutely needed
$GLOBALS['keyHome']                     = 'h';
$GLOBALS['keyUp']                       = 'u';
$GLOBALS['keyNextItem']         = '.';
$GLOBALS['keyPreviousItem']     = ',';
$GLOBALS['keyList']                     = 'l';

// Other keys
// Please make sure you underline the key you
// used in the string in default.lang.php
$GLOBALS['keySearch']           = 'П';
$GLOBALS['keyCollapseAll']      = 'З';
$GLOBALS['keyExpandAll']        = 'Р';
$GLOBALS['keyAddNew']           = 'н';
$GLOBALS['keyNext']                     = 'С';
$GLOBALS['keyPrevious']         = 'П';




// Note: new translatiosn not found in original lang files but found in CSV
$GLOBALS['strHideInactive'] = "Скрыть неактивные элементы со всех страниц";
$GLOBALS['strHelp'] = "Помощь";
$GLOBALS['strStartOver'] = "Начало";
$GLOBALS['strTrackerVariables'] = "Переменные трекера";
$GLOBALS['strLogoutURL'] = "URL для перехода при выходе. <br />Оставьте пустым для URL по умолчанию";
$GLOBALS['strAppendTrackerCode'] = "Добавить код трекера";
$GLOBALS['strDetails'] = "Подробнее";
$GLOBALS['strSyncSettings'] = "Настройки синхронизации";
$GLOBALS['strUser'] = "Пользователь";
$GLOBALS['strRefresh'] = "Обновить";
$GLOBALS['strShowAll'] = "Показать все";
$GLOBALS['strFieldContainsErrors'] = "Указанные поля содержат ошибки:";
$GLOBALS['strFieldFixBeforeContinue1'] = "Прежде чем вы сможете продолжить, вам необходимо";
$GLOBALS['strFieldFixBeforeContinue2'] = "для исправления этих ошибок";
$GLOBALS['strCollectedAllStats'] = "Вся статистика";
$GLOBALS['strCollectedToday'] = "Сегодня";
$GLOBALS['strCollectedYesterday'] = "Вчера";
$GLOBALS['strCollectedThisWeek'] = "Текущая неделя";
$GLOBALS['strCollectedLastWeek'] = "Предыдущая неделя";
$GLOBALS['strCollectedThisMonth'] = "Текущий месяц";
$GLOBALS['strCollectedLastMonth'] = "Предыдущий месяц";
$GLOBALS['strCollectedLast7Days'] = "Предыдущие 7 дней";
$GLOBALS['strCollectedSpecificDates'] = "Заданные даты";
$GLOBALS['strAdmin'] = "Администратор";
$GLOBALS['strNotice'] = "Уведомление";
$GLOBALS['strPriorityLevel'] = "Уровень приоритета";
$GLOBALS['strPriorityTargeting'] = "Распределение";
$GLOBALS['strPriorityOptimisation'] = "Разное";
$GLOBALS['strExclusiveAds'] = "Эксклюзивные кампании";
$GLOBALS['strHighAds'] = "Îые кампании";
$GLOBALS['strLowAds'] = "Ùе кампании";
$GLOBALS['strCapping'] = "þастотные ограничения";
$GLOBALS['strVariables'] = "Описание";
$GLOBALS['strComments'] = "Комментарии";
$GLOBALS['strEnterBoth'] = "Пожалуйста, введите логин и пароль";
$GLOBALS['strUsernameOrPasswordWrong'] = "Неправильные логин или пароль";
$GLOBALS['strDuplicateAgencyName'] = "Указанное имя пользователя уже существует, пожалуйста введите другое имя.";
$GLOBALS['strRequests'] = "Запросов";
$GLOBALS['strImpressions'] = "Показов";
$GLOBALS['strConversions'] = "Действий";
$GLOBALS['strCNVRShort'] = "SR";
$GLOBALS['strCNVR'] = "Показатель продаж (Sales Ratio)";
$GLOBALS['strTotalConversions'] = "Всего действий";
$GLOBALS['strConversionCredits'] = "Кредиты по действиям";
$GLOBALS['strDateTime'] = "Дата и время";
$GLOBALS['strTrackerID'] = "ID трекера";
$GLOBALS['strTrackerName'] = "Название трекера";
$GLOBALS['strCampaignID'] = "ID кампании";
$GLOBALS['strCampaignName'] = "Название кампании";
$GLOBALS['strCountry'] = "Страна";
$GLOBALS['strStatsAction'] = "Действие";
$GLOBALS['strWindowDelay'] = "Задержка окна";
$GLOBALS['strStatsVariables'] = "Переменные";
$GLOBALS['strFinanceCPM'] = "CPM (цена 1000 показов)";
$GLOBALS['strFinanceCPC'] = "CPC (цена клика)";
$GLOBALS['strFinanceCPA'] = "CPA (цена действия)";
$GLOBALS['strFinanceMT'] = "Цена месяца размещения";
$GLOBALS['strDay'] = "День";
$GLOBALS['strWeeks'] = "Недель";
$GLOBALS['strSingleMonth'] = "Месяц";
$GLOBALS['strMonths'] = "Месяцев";
$GLOBALS['strDayOfWeek'] = "День недели";
$GLOBALS['strHour'] = "час";
$GLOBALS['strMinutes'] = "минут";
$GLOBALS['strHours'] = "часов";
$GLOBALS['strClient'] = "Клиент";
$GLOBALS['strHideInactiveAdvertisers'] = "Скрыть неактивных клиентов";
$GLOBALS['strInactiveAdvertisersHidden'] = "неактивные клиенты скрыты";
$GLOBALS['strChars'] = "знаков";
$GLOBALS['strAllowClientViewTargetingStats'] = "Разрешить просмотр статистики таргетинга";
$GLOBALS['strCsvImportConversions'] = "Разрешить импортировать оффлайн-действия";
$GLOBALS['strDeleteAllCampaigns'] = "Удалить все кампании";
$GLOBALS['strLinkedCampaigns'] = "Связанные кампании";
$GLOBALS['strNoCampaigns'] = "В настоящее время нет активных кампаний";
$GLOBALS['strConfirmDeleteAllCampaigns'] = "Вы действительно хотите удалить все кампании этого клиента?";
$GLOBALS['strShowParentAdvertisers'] = "Показать связанных клиентов";
$GLOBALS['strHideParentAdvertisers'] = "Скрыть связанных клиентов";
$GLOBALS['strHideInactiveCampaigns'] = "Скрыть неактивные кампании";
$GLOBALS['strInactiveCampaignsHidden'] = "неактивные кампании скрыты";
$GLOBALS['strContractDetails'] = "Параметры контракта";
$GLOBALS['strInventoryDetails'] = "Параметры Éя";
$GLOBALS['strPriorityInformation'] = "Параметры приоритетов";
$GLOBALS['strPriorityExclusive'] = "Переопределить другие связанные кампании";
$GLOBALS['strPriorityHigh'] = "Платные кампании";
$GLOBALS['strPriorityLow'] = "Внутренние и неоплаченные кампании";
$GLOBALS['strHiddenCampaign'] = "Кампания";
$GLOBALS['strHiddenAd'] = "Баннер";
$GLOBALS['strHiddenAdvertiser'] = "Клиент";
$GLOBALS['strHiddenTracker'] = "Трекер";
$GLOBALS['strHiddenZone'] = "Зона";
$GLOBALS['strCompanionPositioning'] = "Совместное размещение баннеров этой кампании";
$GLOBALS['strSelectUnselectAll'] = "Выбрать всё / Снять выделение";
$GLOBALS['strLow'] = "Низкий";
$GLOBALS['strHigh'] = "Высокий";
$GLOBALS['strExclusive'] = "Эксклюзивный";
$GLOBALS['strExpirationDateComment'] = "Кампания закончится в конце этого дня";
$GLOBALS['strActivationDateComment'] = "Кампания начнется в начале этого дня";
$GLOBALS['strRevenueInfo'] = "Цена";
$GLOBALS['strImpressionsRemaining'] = "Осталось показов";
$GLOBALS['strClicksRemaining'] = "Осталось кликов";
$GLOBALS['strConversionsRemaining'] = "Осталось действий";
$GLOBALS['strImpressionsBooked'] = "Заказано показов";
$GLOBALS['strClicksBooked'] = "Заказано кликов";
$GLOBALS['strConversionsBooked'] = "Заказано действий";
$GLOBALS['strOptimise'] = "Оптимизировать";
$GLOBALS['strPriorityAutoTargeting'] = "Автоматически. Распределить показы равномерно на оставшиеся дни";
$GLOBALS['strCampaignWarningNoWeight'] = "Приоритет этой кампании был установлен на низком уровне, но вес был установлен равным нулю, или не был указан вовсе. Это вызовет отключение кампании и баннеры не будут показываться до тех пор, пока не будет задан вес, отличный от нуля.\n\nВы действительно хотите продолжить?";
$GLOBALS['strCampaignWarningNoTarget'] = "Приоритет этой кампании был задан высоким, но не было указано число показов. Это вызовет отключение кампании и баннеры не будут показываться до тех пор, пока не будет задано количество показов, отличное от нуля.\n\nВы действительно хотите продолжить?";
$GLOBALS['strTracker'] = "Трекер";
$GLOBALS['strTrackerOverview'] = "Параметры трекера";
$GLOBALS['strAddTracker'] = "Добавить трекер";
$GLOBALS['strAddTracker_Key'] = "Добавить <u></u>овый трекер";
$GLOBALS['strNoTrackers'] = "Трекеры не определены";
$GLOBALS['strConfirmDeleteAllTrackers'] = "вы действительно хотите удалить все трекеры этого клиента?";
$GLOBALS['strConfirmDeleteTracker'] = "Вы действительно хотите удалить этот трекер?";
$GLOBALS['strDeleteAllTrackers'] = "Удалить все трекеры";
$GLOBALS['strTrackerProperties'] = "Свойства трекера";
$GLOBALS['strModifyTracker'] = "Редактировать трекер";
$GLOBALS['strLog'] = "Записать в журнал?";
$GLOBALS['strDefaultStatus'] = "Статус по умолчанию";
$GLOBALS['strStatus'] = "Статус";
$GLOBALS['strLinkedTrackers'] = "Связанные трекеры";
$GLOBALS['strDefaultConversionRules'] = "Действие по умолчанию";
$GLOBALS['strConversionWindow'] = "Период действия";
$GLOBALS['strClickWindow'] = "Период клика";
$GLOBALS['strViewWindow'] = "Период показа";
$GLOBALS['strUniqueWindow'] = "Период уникального пользователя";
$GLOBALS['strClick'] = "Клик";
$GLOBALS['strView'] = "Показ";
$GLOBALS['strLinkCampaignsByDefault'] = "По умолчанию связывать с новыми кампаниями";
$GLOBALS['strDeleteAllBanners'] = "Удалить все баннеры";
$GLOBALS['strActivateAllBanners'] = "Активировать все баннеры";
$GLOBALS['strDeactivateAllBanners'] = "Деактивировать все баннеры";
$GLOBALS['strConfirmDeleteAllBanners'] = "Вы действительно хотите удалить все баннеры в этой кампании?";
$GLOBALS['strShowParentCampaigns'] = "Показать связанные кампании";
$GLOBALS['strHideParentCampaigns'] = "Скрыть связанные кампании";
$GLOBALS['strHideInactiveBanners'] = "Скрыть неактивные баннеры";
$GLOBALS['strInactiveBannersHidden'] = "неактивные баннеры скрыты";
$GLOBALS['strAppendTextAdNotPossible'] = "Невозможно добавить баннер к текстовому объявлению";
$GLOBALS['strWarningMissing'] = "Внимание, возможно отсутствует";
$GLOBALS['strWarningMissingClosing'] = " закрывающий тэг \">\"";
$GLOBALS['strWarningMissingOpening'] = " открывающий тэг \"<\"";
$GLOBALS['strSubmitAnyway'] = "Сохранить как есть";
$GLOBALS['strTextBanner'] = "Текстовый баннер";
$GLOBALS['strUploadOrKeepAlt'] = "Хотите сохранить <br>имеющуюся картинку: или хотите <br>загрузить другую?";
$GLOBALS['strNewBannerFileAlt'] = "Выберите изображение для показа <br />в том случае, если браузер клиента <br />не поддерживает Rich Media<br /><br />";
$GLOBALS['strAdserverTypeGeneric'] = "Простой HTML-баннер";
$GLOBALS['strGenericOutputAdServer'] = "Простой";
$GLOBALS['strSwfTransparency'] = "Прозрачный фон (только для Flash)";
$GLOBALS['strRemoveAllLimitations'] = "Удалить все ограничения";
$GLOBALS['strLaterThan'] = "позже чем";
$GLOBALS['strLaterThanOrEqual'] = "позже или равно";
$GLOBALS['strEarlierThan'] = "раньше чем";
$GLOBALS['strEarlierThanOrEqual'] = "раньше или равно";
$GLOBALS['strWeekDays'] = "Дни недели";
$GLOBALS['strCity'] = "Город";
$GLOBALS['strDeliveryLimitations'] = "Ограничения показов";
$GLOBALS['strDeliveryCapping'] = "þастотные ограничения";
$GLOBALS['strDeliveryCappingReset'] = "Сбросить счетчик показов после:";
$GLOBALS['strDeliveryCappingTotal'] = "всего";
$GLOBALS['strDeliveryCappingSession'] = "за сессию";
$GLOBALS['strAffiliateInvocation'] = "Код вызова";
$GLOBALS['strWebsite'] = "Веб-сайт";
$GLOBALS['strMnemonic'] = "Мнемоническое";
$GLOBALS['strAllowAffiliateGenerateCode'] = "Разрешить генерировать код вызова";
$GLOBALS['strAllowAffiliateZoneStats'] = "Разрешить просмотр статистики зон";
$GLOBALS['strAllowAffiliateApprPendConv'] = "Показывать этому пользователю только подтвержденные действия";
$GLOBALS['strPaymentInformation'] = "Информация о платеже";
$GLOBALS['strAddress'] = "Адрес";
$GLOBALS['strPostcode'] = "Почтовый индекс";
$GLOBALS['strPhone'] = "Телефон";
$GLOBALS['strFax'] = "Факс";
$GLOBALS['strAccountContact'] = "Контактное лицо";
$GLOBALS['strPayeeName'] = "Наименование плательщика";
$GLOBALS['strTaxID'] = "ID налога";
$GLOBALS['strModeOfPayment'] = "Тип платежа";
$GLOBALS['strPaymentChequeByPost'] = "þек по почте";
$GLOBALS['strCurrency'] = "Валюта";
$GLOBALS['strCurrencyGBP'] = "Английские фунты";
$GLOBALS['strOtherInformation'] = "Другая информация";
$GLOBALS['strUniqueUsersMonth'] = "Уникальных пользователей в месяц";
$GLOBALS['strUniqueViewsMonth'] = "Уникальных показов в месяц";
$GLOBALS['strPageRank'] = "Google Pagerank";
$GLOBALS['strCategory'] = "Категория";
$GLOBALS['strHelpFile'] = "Файл справки";
$GLOBALS['strZone'] = "Зона";
$GLOBALS['strZoneType'] = "Тип зоны";
$GLOBALS['strBannerButtonRectangle'] = "Баннер, кнопка или область";
$GLOBALS['strInterstitial'] = "Rich-Media и HTML баннеры";
$GLOBALS['strPopup'] = "Pop-Up";
$GLOBALS['strTextAdZone'] = "Текстовый баннер";
$GLOBALS['strEmailAdZone'] = "Баннер в рассылке";
$GLOBALS['strZoneClick'] = "Трекинга кликов";
$GLOBALS['strShowMatchingBanners'] = "Показать подходящие баннеры";
$GLOBALS['strHideMatchingBanners'] = "Скрыть подходящие баннеры";
$GLOBALS['strBannerLinkedAds'] = "Связанные баннеры";
$GLOBALS['strCampaignLinkedAds'] = "Связанные кампании";
$GLOBALS['strTotalZones'] = "Всего зон";
$GLOBALS['strCostInfo'] = "Медиа-стоимость";
$GLOBALS['strTechnologyCost'] = "Технологическаястоимость";
$GLOBALS['strInactiveZonesHidden'] = "неактивные зоны скрыты";
$GLOBALS['strWarnChangeZoneType'] = "При смене типа зоны на \"текст\" или \"е-мэйл\" все связи с баннерами и кампаниями будут потеряны                                                <ul>\\n                                                    <li>Текстовые зоны могут быть связаны только с текстовыми </li>\\n                                                    <li>E-mail зоны могут содержать только один активный </li>\\n                                                </ul>";
$GLOBALS['strWarnChangeZoneSize'] = "Изменение размеров зоны повлечет отключение текущих баннеров и подключение баннеров подходящего размера из связанных кампаний";
$GLOBALS['strAdvanced'] = "Дополнительно";
$GLOBALS['strChainSettings'] = "Настройки цепочки";
$GLOBALS['strZoneNoDelivery'] = "Если в этой зоне нет баннерных показов?";
$GLOBALS['strZoneStopDelivery'] = "Остановить показы";
$GLOBALS['strZoneOtherZone'] = "Показывать баннеры из указанной зоны";
$GLOBALS['strZoneAppend'] = "Всегда добавлять следующий HTML-код к баннерам в этой зоне";
$GLOBALS['strAppendSettings'] = "Настройки включений";
$GLOBALS['strZoneForecasting'] = "Настройки прогноза для зоны";
$GLOBALS['strZonePrependHTML'] = "Всегда добавлять следующий HTML-код ДО текстового баннера в этой зоне";
$GLOBALS['strZoneAppendHTML'] = "Всегда добавлять следующий HTML-код ПОСЛЕ текстового баннера в этой зоне";
$GLOBALS['strZoneAppendNoBanner'] = "Добавлять HTML-код даже если нет баннерных показов";
$GLOBALS['strZoneAppendType'] = "Тип вставки";
$GLOBALS['strZoneAppendHTMLCode'] = "HTML-код";
$GLOBALS['strZoneAppendZoneSelection'] = "Pop-Up или \"плавающий\" баннер\0";
$GLOBALS['strZoneAppendSelectZone'] = "Всегда добавлять следующий Pop-Up или \"плавающий\" баннер к баннерам в этой зоне\0";
$GLOBALS['strZoneProbListChainLoop'] = "Указанная цепочка генерирует замкнутый цикл. Доставка баннеров для этой зоны прекращена.";
$GLOBALS['strLinkedBanners'] = "Связь отдельных баннеров";
$GLOBALS['strCampaignDefaults'] = "Связь баннеров по кампаниям";
$GLOBALS['strLinkedCategories'] = "Связь баннеров по категориям";
$GLOBALS['strMatchingBanners'] = "{count} подходящих баннеров";
$GLOBALS['strNoCampaignsToLink'] = "Нет кампаний для связи с данной зоной";
$GLOBALS['strNoTrackersToLink'] = "Нет трекеров для связи с данной кампанией";
$GLOBALS['strNoZonesToLinkToCampaign'] = "Нет зон для связи с данной кампанией";
$GLOBALS['strSelectBannerToLink'] = "Выберите баннер для связи с этой зоной:";
$GLOBALS['strSelectCampaignToLink'] = "Выберите кампанию для связи с этой зоной:";
$GLOBALS['strSelectAdvertiser'] = "Выберите клиента";
$GLOBALS['strSelectPlacement'] = "Выберите кампанию";
$GLOBALS['strSelectAd'] = "Выберите баннер";
$GLOBALS['strStatusPending'] = "Ожидают";
$GLOBALS['strStatusApproved'] = "Одобрены";
$GLOBALS['strStatusDisapproved'] = "Не одобрены";
$GLOBALS['strStatusDuplicate'] = "Дублирующие";
$GLOBALS['strStatusOnHold'] = "Удерживаемые";
$GLOBALS['strStatusIgnore'] = "Игнорируемые";
$GLOBALS['strConnectionType'] = "Тип";
$GLOBALS['strConnTypeSale'] = "Продажа";
$GLOBALS['strConnTypeLead'] = "Следование";
$GLOBALS['strConnTypeSignUp'] = "Регистрация";
$GLOBALS['strShortcutEditStatuses'] = "Редактировать статусы";
$GLOBALS['strShortcutShowStatuses'] = "Показать статусы";
$GLOBALS['strNoTargetingStats'] = "Статистика по таргетингу недоступна";
$GLOBALS['strNoStatsForPeriod'] = "Статистика за период с %s по %s недоступна";
$GLOBALS['strNoTargetingStatsForPeriod'] = "Статистика по таргетингу за период с %s по %s недоступна";
$GLOBALS['strDailyHistory'] = "История по дням";
$GLOBALS['strWeeklyHistory'] = "История по неделям";
$GLOBALS['strMonthlyHistory'] = "История по месяцам";
$GLOBALS['strCampaignDistribution'] = "Распределение по кампаниям";
$GLOBALS['strKeywordStatistics'] = "Статистика ключевых слов";
$GLOBALS['strTargetStats'] = "Статистика таргетинга";
$GLOBALS['strViewBreakdown'] = "Просмотры за";
$GLOBALS['strBreakdownByDay'] = "День";
$GLOBALS['strBreakdownByWeek'] = "Неделю";
$GLOBALS['strBreakdownByMonth'] = "Месяц";
$GLOBALS['strBreakdownByDow'] = "День недели";
$GLOBALS['strBreakdownByHour'] = "þас";
$GLOBALS['strItemsPerPage'] = "Элементов на странице";
$GLOBALS['strDistributionHistory'] = "История распределения";
$GLOBALS['strShowGraphOfStatistics'] = "Показать <u></u>трафик";
$GLOBALS['strExportStatisticsToExcel'] = "<u></u>экспортировать статистику в Excel";
$GLOBALS['strGDnotEnabled'] = "Для отображения графиков вам необходимо Ø PHP Для работы с библиотекой GD. Обратитесь за подробностями к руководству по PHP: <a href='http://www.php.net/gd' target='_blank'>http://www.php.net/gd</a>";
$GLOBALS['strStartDate'] = "Дата начала";
$GLOBALS['strEndDate'] = "Дата окончания";
$GLOBALS['strAllAdvertisers'] = "Все клиенты";
$GLOBALS['strAnonAdvertisers'] = "Анонимные рекламодатели";
$GLOBALS['strAllAvailZones'] = "Все доступные зоны";
$GLOBALS['strUserLog'] = "Журнал действий пользователя";
$GLOBALS['strUserLogDetails'] = "Подробности действий пользователя";
$GLOBALS['strDeleteLog'] = "Удалить журнал";
$GLOBALS['strAction'] = "Действие";
$GLOBALS['strNoActionsLogged'] = "Действий не Ï";
$GLOBALS['strTrackercode'] = "Код трекера";
$GLOBALS['strBackToTheList'] = "Вернуться к списку отчетов";
$GLOBALS['strLogErrorConversions'] = "[phpAds] Ошибка доступа к БД действий.";
$GLOBALS['strErrorDBPlain'] = "Ошибка доступа к БД";
$GLOBALS['strErrorDBSerious'] = "Обнаружена серьезная проблема с БД";
$GLOBALS['strErrorDBNoDataPlain'] = "Из-за проблем с доступом к БД ".MAX_PRODUCT_NAME." не может сохранить или получить данные";
$GLOBALS['strErrorDBNoDataSerious'] = "Из-за серьезных проблем с БД ".MAX_PRODUCT_NAME." не может сохранить или получить данные";
$GLOBALS['strErrorDBContact'] = "Свяжитесь с администраторомсервера и сообщите ему о проблеме";
$GLOBALS['strErrorDBSubmitBug'] = "Если ошибку можно воспроизвести, возможно это баг ПО ".MAX_PRODUCT_NAME.". Пожалуйста, сообщите об этом разработчикам ".MAX_PRODUCT_NAME.". Приложите к сообщению возможно более подробное описание ошибки.";
$GLOBALS['strMaintenanceNotActive'] = "Утилита обслуживания БД не запускалась в последние 24 часа. Для корректной работы ".MAX_PRODUCT_NAME." необходимо запускать утилиту обслуживания каждый час. Обратитесь к руководству администратора для сведений по настройке обслуживания БД.";
$GLOBALS['strErrorLinkingBanner'] = "Невозможно привязать выбранный баннер к этой зоне, т.к.:";
$GLOBALS['strUnableToLinkBanner'] = "Невозможно привязать выбранный баннер:";
$GLOBALS['strErrorEditingCampaign'] = "Ошибка при обновлении кампании:";
$GLOBALS['strUnableToChangeCampaign'] = "Невозможно сохранить изменения, т.к.:";
$GLOBALS['strDatesConflict'] = "дата конфликтует с:";
$GLOBALS['strEmailNoDates'] = "Кампании в почтовых рассылках должны иметь даты начала и окончания";
$GLOBALS['strSirMadam'] = "Г-н/Г-жа";
$GLOBALS['strMailBannerActivatedSubject'] = "Кампания активирована";
$GLOBALS['strMailBannerDeactivatedSubject'] = "Кампания деактивирована";
$GLOBALS['strMailBannerActivated'] = "Указанные кампании были активированы, т.к.";
$GLOBALS['strMailBannerDeactivated'] = "Указанные кампании были деактивированы, т.к.";
$GLOBALS['strNoMoreImpressions'] = "все приобретенные показы использованы";
$GLOBALS['strNoMoreConversions'] = "все приобретенные действия использованы";
$GLOBALS['strWeightIsNull'] = "был установлен нулевой вес";
$GLOBALS['strTargetIsNull'] = "был установлен нулевой таргетинг";
$GLOBALS['strImpressionsClicksConversionsLow'] = "Показы, клики или действия заканчиваются";
$GLOBALS['strNoConversionLoggedInInterval'] = "За период данного отчета не было Ï действий";
$GLOBALS['strImpendingCampaignExpiry'] = "Неожиданная остановка кампании";
$GLOBALS['strYourCampaign'] = "Ваша кампания";
$GLOBALS['strTheCampiaignBelongingTo'] = "Кампания, принадлежащая";
$GLOBALS['strImpendingCampaignExpiryDateBody'] = "{clientname} указанному ниже, заканчивается {date}.";
$GLOBALS['strImpendingCampaignExpiryImpsBody'] = "{clientname} указанному ниже, осталось меньше {limit} показов";
$GLOBALS['strImpendingCampaignExpiryBody'] = "В результате чего кампания скоро будет автоматически отключена, и";
$GLOBALS['strSourceEdit'] = "Редактировать источники";
$GLOBALS['strProductUpdates'] = "Обновление ПО";
$GLOBALS['strCheckForUpdates'] = "Проверить наличие обновлений";
$GLOBALS['strViewPastUpdates'] = "Управление обновлениями и резервными копиями";
$GLOBALS['strAgencyManagement'] = "Управление агентствами";
$GLOBALS['strAgency'] = "Агентство";
$GLOBALS['strAddAgency'] = "Добавить новое агентство";
$GLOBALS['strAddAgency_Key'] = "Добавить <u></u>овое агентство";
$GLOBALS['strTotalAgencies'] = "Всего агентств";
$GLOBALS['strAgencyProperties'] = "Свойства агентства";
$GLOBALS['strNoAgencies'] = "В настоящее время агентства не определены";
$GLOBALS['strConfirmDeleteAgency'] = "Вы действительно хотите удалить это агентство?";
$GLOBALS['strHideInactiveAgencies'] = "Скрыть неактивные агентства";
$GLOBALS['strInactiveAgenciesHidden'] = "неактивные агентства скрыты";
$GLOBALS['strAllowAgencyEditConversions'] = "Разрешить редактировать действия";
$GLOBALS['strAllowMoreReports'] = "Показать кнопку \"Дополнительные отчеты\"";
$GLOBALS['strChannel'] = "Канал";
$GLOBALS['strChannels'] = "Каналы";
$GLOBALS['strChannelOverview'] = "Обозрение каналов";
$GLOBALS['strChannelManagement'] = "Управление каналами";
$GLOBALS['strAddNewChannel'] = "Добавить новый канал";
$GLOBALS['strAddNewChannel_Key'] = "Добавить <u></u>овый канал";
$GLOBALS['strNoChannels'] = "В настоящее время каналы не определены";
$GLOBALS['strEditChannelLimitations'] = "Редактировать ограничения канала";
$GLOBALS['strChannelProperties'] = "Свойства канала";
$GLOBALS['strChannelLimitations'] = "Параметры доставки";
$GLOBALS['strConfirmDeleteChannel'] = "Вы действительно хотите удалить этот канал?";
$GLOBALS['strVariableName'] = "Имя переменной";
$GLOBALS['strVariableDescription'] = "Описание";
$GLOBALS['strVariableDataType'] = "Тип данных";
$GLOBALS['strVariablePurpose'] = "Назначение";
$GLOBALS['strGeneric'] = "Простой";
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
$GLOBALS['strTrackerType'] = "Тип отслеживания";
$GLOBALS['strTrackerTypeJS'] = "Отслеживать значения переменных JavaScript";
$GLOBALS['strTrackerTypeDefault'] = "Отслеживать значения переменных JavaScript (для обратной совместимости необходимо экранирование)";
$GLOBALS['strTrackerTypeDOM'] = "Отслеживать значения переменных, используя DOM";
$GLOBALS['strTrackerTypeCustom'] = "Ê код JS";
$GLOBALS['strVariableCode'] = "Код отслеживания JS";
$GLOBALS['strForgotPassword'] = "Забыли пароль?";
$GLOBALS['strPasswordRecovery'] = "Восстановление пароля";
$GLOBALS['strEmailRequired'] = "Поле \"E-mail\" обязательно для заполнения\0";
$GLOBALS['strPwdRecEmailSent'] = "Вам отправлено письмо с инструкциями для восстановления пароля";
$GLOBALS['strPwdRecEmailNotFound'] = "Указанный адрес электронной почты не найден";
$GLOBALS['strPwdRecPasswordSaved'] = "Новый пароль сохранен, продолжить <a href='index.php'></a>";
$GLOBALS['strPwdRecWrongId'] = "Неправильный ID";
$GLOBALS['strPwdRecEnterEmail'] = "Введите ваш адрес электронной почты";
$GLOBALS['strPwdRecEnterPassword'] = "Введите ваш новый пароль";
$GLOBALS['strPwdRecResetLink'] = "Ссылка для сброса пароля";
$GLOBALS['strPwdRecEmailPwdRecovery'] = "%s восстановление пароля";
$GLOBALS['strValue'] = "Значение";
$GLOBALS['strOpenadsIdSettings'] = "Настройки ".MAX_PRODUCT_NAME." ID";
$GLOBALS['strNovice'] = "Действия администратора по удалению требуют подтверждения для подстраховки";
$GLOBALS['strNoAdminInterface'] = "Ê интерфейс недоступен на время планового обслуживания. Это никак не сказывается на ваших рекламных кампаниях.";
$GLOBALS['strGreaterThan'] = "больше чем";
$GLOBALS['strLessThan'] = "меньше чем";
$GLOBALS['strCappingBanner']['limit'] = "Лимит показов баннера:";
$GLOBALS['strCappingCampaign']['limit'] = "Лимит показов кампании:";
$GLOBALS['strCappingZone']['limit'] = "Лимит показов зоны:";
$GLOBALS['strOpenadsEmail'] = "".MAX_PRODUCT_NAME." . \" E-mail";
$GLOBALS['strEmailSettings'] = "Настройки e-mail";
$GLOBALS['strEnableQmailPatch'] = "Применять патч для qmail";
$GLOBALS['strEmailHeader'] = "Заголовки e-mail";
$GLOBALS['strEmailLog'] = "Журнал e-mail";
$GLOBALS['strAudit'] = "Журнал аудита";
$GLOBALS['strEnableAudit'] = "Разрешить аудит изменений";
$GLOBALS['strTypeFTPErrorNoSupport'] = "Ваша инсталляция PHP не поддерживает работу с FTP";
$GLOBALS['strGeotargetingUseBundledCountryDb'] = "Использовать встроенную версию MaxMind GeoLiteCountry БД";
$GLOBALS['strConfirmationUI'] = "Использовать подтверждения в GUI";
$GLOBALS['strBannerStorage'] = "Настройки хранения баннеров";
$GLOBALS['strMaintenanceSettings'] = "Настройки обслуживания";
$GLOBALS['strSSLSettings'] = "Настройки SSL";
$GLOBALS['strLogging'] = "Журналирование";
$GLOBALS['strDebugLog'] = "Журнал отладки";
$GLOBALS['strEvent'] = "Событие";
$GLOBALS['strTimestamp'] = "Метка даты";
$GLOBALS['strInserted'] = "вставлен";
$GLOBALS['strInsert'] = "Вставить";
$GLOBALS['strUpdate'] = "Обновить";
$GLOBALS['strFilters'] = "Фильтры";
$GLOBALS['strAdvertiser'] = "Клиент";
$GLOBALS['strType'] = "Тип";
$GLOBALS['strParameter'] = "Параметр";
$GLOBALS['strDetailedView'] = "Подробный вид";
$GLOBALS['strReturnAuditTrail'] = "Вернуться к аудиту изменений";
$GLOBALS['strAuditTrail'] = "Аудит изменений";
$GLOBALS['strMaintenanceLog'] = "Журнал обслуживания";
$GLOBALS['strAuditResultsNotFound'] = "Нет событий отвечающих выбранным критериям";
$GLOBALS['strCollectedAllEvents'] = "Все события";
$GLOBALS['strClear'] = "Очистить";
$GLOBALS['strLinkNewUser'] = "Привязать нового пользователя";
$GLOBALS['strLinkNewUser_Key'] = "Привязать <u></u>ользователя";
$GLOBALS['strUserAccess'] = "Доступ пользователя";
$GLOBALS['strMyAccount'] = "Мой аккаунт";
$GLOBALS['strCampaignStatusRunning'] = "Старновал";
$GLOBALS['strCampaignStatusPaused'] = "Приостановлен";
$GLOBALS['strCampaignStatusAwaiting'] = "Добавлен";
$GLOBALS['strCampaignStatusExpired'] = "Завершен";
$GLOBALS['strCampaignStatusApproval'] = "Ожидает подтверждения";
$GLOBALS['strCampaignStatusRejected'] = "Отклонен";
$GLOBALS['strCampaignApprove'] = "Подтвержден";
$GLOBALS['strCampaignApproveDescription'] = "подтвердить эту кампанию";
$GLOBALS['strCampaignReject'] = "Отменить";
$GLOBALS['strCampaignRejectDescription'] = "отменить эту кампанию";
$GLOBALS['strCampaignPause'] = "Приостановить";
$GLOBALS['strCampaignPauseDescription'] = "приостановить эту кампанию";
$GLOBALS['strCampaignRestart'] = "Продолжить";
$GLOBALS['strCampaignRestartDescription'] = "продолжить эту кампанию";
$GLOBALS['strCampaignStatus'] = "Состояние кампании";
$GLOBALS['strReasonForRejection'] = "Причина отказа";
$GLOBALS['strReasonSiteNotLive'] = "Сайт недоступен";
$GLOBALS['strReasonBadCreative'] = "Неприемлемый креатив";
$GLOBALS['strReasonBadUrl'] = "Неприемлемый URL перехода";
$GLOBALS['strReasonBreakTerms'] = "Сайт нарушает Правила";
$GLOBALS['strTrackerPreferences'] = "Предпочтения трекера";
$GLOBALS['strBannerPreferences'] = "Предпочтения баннера";
$GLOBALS['strAdvertiserSetup'] = "Регистрация рекламодателя";
$GLOBALS['strSelectZone'] = "Выбрать зону";
$GLOBALS['strMainPreferences'] = "Главные настройки";
$GLOBALS['strAccountPreferences'] = "Настройки аккаунта";
$GLOBALS['strCampaignEmailReportsPreferences'] = "Настройки доставки отчетов";
$GLOBALS['strAdminEmailWarnings'] = "Предупреждения администратора";
$GLOBALS['strAgencyEmailWarnings'] = "Предупреждения агентства";
$GLOBALS['strAdveEmailWarnings'] = "Предупреждения клиента";
$GLOBALS['strFullName'] = "ФИО";
$GLOBALS['strUserDetails'] = "Данные пользователя";
$GLOBALS['strLanguageTimezone'] = "Язык и часовой пояс";
$GLOBALS['strLanguageTimezonePreferences'] = "Настройки языка и часового пояса";
$GLOBALS['strUserInterfacePreferences'] = "Настройки GUI";
$GLOBALS['strInvocationPreferences'] = "Настройки вызова баннеров";
$GLOBALS['strEmailAddressFrom'] = "Адрес e-mail для поля ОТ:";
$GLOBALS['strUserProperties'] = "Настройки пользователя";
$GLOBALS['strBack'] = "Назад";
$GLOBALS['strUsernameToLink'] = "Имя пользователя для ссылки";
$GLOBALS['strEmailToLink'] = "E-mail для ссылки";
$GLOBALS['strNewUserWillBeCreated'] = "Будет создан новый пользователь";
$GLOBALS['strToLinkProvideEmail'] = "Для связи пользователя, задайте e-mail";
$GLOBALS['strToLinkProvideUsername'] = "Для связи пользователя, задайте его имя";
$GLOBALS['strContactName'] = "Имя";
$GLOBALS['strPwdRecReset'] = "Сброс пароля";
$GLOBALS['strPwdRecResetPwdThisUser'] = "Сброс пароля для пользователя";
$GLOBALS['keyLinkUser'] = "u";
$GLOBALS['strAllowCreateAccounts'] = "Разрешить пользователю создавать учетные записи";
$GLOBALS['strErrorWhileCreatingUser'] = "Ошибка при создании пользователя: %s";
$GLOBALS['strUserLinkedToAccount'] = "Пользователь привязан к учетной записи";
$GLOBALS['strUserAccountUpdated'] = "Учетная запись обновлена";
$GLOBALS['strUserUnlinkedFromAccount'] = "Пользователь отделен от учетной записи";
$GLOBALS['strUserWasDeleted'] = "Пользователь удален";
$GLOBALS['strUserNotLinkedWithAccount'] = "К учетной записи не привязан ни один пользователь";
$GLOBALS['strWorkingAs'] = "Работает как";
$GLOBALS['strWorkingFor'] = "%s для?";
$GLOBALS['strCantDeleteOneAdminUser'] = "Вы не можете удалить этого пользователя. Хотя бы один пользователь должен быть связан с учетной записью администратора.";
$GLOBALS['strWarnChangeBannerSize'] = "Изменение размеров баннера приведет к тому, что он будет перемещен в зоны, подходящие под новый размер.";
$GLOBALS['strLinkUserHelp'] = "<br />Введите имя пользователя. Для привязки:<ul><li>существующего пользователя - введите его имя и нажмите \"привязать пользователя\"</li><li>нового пользователя, введите его желаемое имя и нажмите \"привязать пользователя\"</li></ul>";
$GLOBALS['strAuditNoData'] = "За выбранный вами временной интервал не было зафиксировано никакой активности.";
$GLOBALS['strCampaignGoTo'] = "Перейти на стр. кампании";
$GLOBALS['strCampaignSetUp'] = "Настроить кампанию сегодня";
$GLOBALS['strCampaignNoRecords'] = "<li>Кампании позволяют группировать баннеры разных форматов, связанные по </li> \\n<li>При группировке баннеров в кампании отпадает необходимость настройки параметров для каждого баннера в </li>  \\n<li>Подробную документацию о кампаниях вы можете найти <a class=\"site-link\" href=\"http://".OX_PRODUCT_DOCSURL."/inventory/advertisersAndCampaigns/campaigns\">по этому </a>.</li>";
$GLOBALS['strCampaignNoDataTimeSpan'] = "В выбранный вами период ни одна кампания не стартовала и не закончилась";
$GLOBALS['strCampaignAuditNotActivated'] = "þтобы видеть, какие кампании стартовали или финишировали в заданный вами период, необходимо активировать аудит изменений";
$GLOBALS['strAuditTrailSetup'] = "Настроить аудит изменений сегодня";
$GLOBALS['strAuditTrailGoTo'] = "Перейти на страницу аудита изменений";
$GLOBALS['strAuditTrailNotEnabled'] = "<li>Аудит изменений позволяет видеть, кто, что и когда делал в системе. Иначе говоря, он позволяет отслеживать изменения в ".MAX_PRODUCT_NAME."</li> \n<li>Вы видите это сообщение, потому что вы не активировали Аудит </li> \n<li>Нужно больше информации? þитайте <a href='http://".OX_PRODUCT_DOCSURL."/settings/auditTrail' target='_blank'>документацию по аудиту </a></li>";
?>