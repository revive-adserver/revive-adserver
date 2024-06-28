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
$GLOBALS['strChooseSection'] = "Виберіть розділ";
$GLOBALS['strAppendCodes'] = "Додати коди";

// Maintenance
$GLOBALS['strScheduledMaintenanceHasntRun'] = "<b>Планове технічне обслуговування не проводилося протягом останньої години. Це може означати, що ви неправильно налаштували його.</b>";





$GLOBALS['strScheduledMantenaceRunning'] = "<b>Планове технічне обслуговування виконується правильно.</b>";

$GLOBALS['strAutomaticMaintenanceHasRun'] = "<b>Автоматичне обслуговування працює правильно.</b>";

$GLOBALS['strAutoMantenaceEnabled'] = "Однак автоматичне обслуговування все ще ввімкнено. Для найкращої продуктивності вам слід <a href='account-settings-maintenance.php'>вимкнути автоматичне обслуговування</a>.";

// Priority
$GLOBALS['strRecalculatePriority'] = "Перерахувати пріоритет";

// Banner cache
$GLOBALS['strCheckBannerCache'] = "Перевірити кеш банерів";
$GLOBALS['strBannerCacheErrorsFound'] = "Перевірка кешу банерів бази даних виявила деякі помилки. Ці банери не працюватимуть, доки ви не виправите їх вручну.";
$GLOBALS['strBannerCacheOK'] = "Помилок не виявлено. Кеш банерів вашої бази даних оновлений";
$GLOBALS['strBannerCacheDifferencesFound'] = "Перевірка кешу банерів бази даних виявила, що ваш кеш не оновлений і потребує перебудови. Натисніть тут, щоб автоматично оновити кеш.";
$GLOBALS['strBannerCacheRebuildButton'] = "Перебудувати";
$GLOBALS['strRebuildDeliveryCache'] = "Перебудувати кеш банерів бази даних";

// Cache
$GLOBALS['strCache'] = "Кеш доставки";
$GLOBALS['strDeliveryCacheSharedMem'] = "Спільна пам'ять наразі використовується для зберігання кешу доставки.";
$GLOBALS['strDeliveryCacheDatabase'] = "Зараз база даних використовується для зберігання кешу доставки.";
$GLOBALS['strDeliveryCacheFiles'] = "Кеш доставки зараз зберігається в кількох файлах на вашому сервері.";

// Storage
$GLOBALS['strStorage'] = "Місце зберегання";
$GLOBALS['strMoveToDirectory'] = "Перемістіть зображення, що зберігаються в базі даних, до каталогу";
$GLOBALS['strStorageExplaination'] = "Зображення, які використовуються локальними банерами, зберігаються в базі даних або в каталозі. Якщо ви зберігаєте зображення в каталозі, навантаження на базу даних буде зменшено, і це призведе до збільшення швидкості.";

// Security
$GLOBALS['strSecurity'] = "Безпека";
$GLOBALS['strSecurityOK'] = "Ваш браузер не зміг отримати захищені файли, це чудова новина!";
$GLOBALS['strSecurityKO'] = "Ваш браузер зміг отримати деякі файли, які не повинні бути доступні. Наприклад:";
$GLOBALS['strSecurityReadMore'] = "Клацніть тут, щоб дізнатися більше про те, як захистити вашу установку.";

// Encoding
$GLOBALS['strEncoding'] = "Кодування";
$GLOBALS['strEncodingConvertFrom'] = "Перетворити з цього кодування:";
$GLOBALS['strEncodingConvertTest'] = "Тестувати перетворення";
$GLOBALS['strConvertThese'] = "Наступні дані будуть змінені, якщо ви продовжите";

// Product Updates
$GLOBALS['strSearchingUpdates'] = "Шукаються оновлення. Будь ласка, зачекайте...";
$GLOBALS['strAvailableUpdates'] = "Доступні оновлення";
$GLOBALS['strDownloadZip'] = "Завантажити (.zip)";
$GLOBALS['strDownloadGZip'] = "Завантажити (.tar.gz)";


$GLOBALS['strUpdateServerDown'] = "З невідомих причин неможливо отримати <br>інформацію про можливі оновлення. Будь-ласка спробуйте пізніше.";



$GLOBALS['strCheckForUpdatesDisabled'] = "<b>Перевірку оновлень вимкнено. Увімкніть на екрані <a href='account-settings-update.php'>налаштування оновлення</a>.</b>";




$GLOBALS['strForUpdatesLookOnWebsite'] = "Якщо ви хочете дізнатися, чи доступна новіша версія, перегляньте наш веб-сайт.";

$GLOBALS['strClickToVisitWebsite'] = "Натисніть тут, щоб відвідати наш веб-сайт";
$GLOBALS['strCurrentlyUsing'] = "Ви зараз використовуєте";
$GLOBALS['strRunningOn'] = "працює";
$GLOBALS['strAndPlain'] = "і";

//  Deliver Limitations
$GLOBALS['strDeliveryLimitations'] = "Правила доставки";
$GLOBALS['strAllBannerChannelCompiled'] = "Усі скомпільовані значення правил доставки набору банерів/правил доставки було перекомпільовано";
$GLOBALS['strBannerChannelResult'] = "Ось результати перевірки скомпільованих правил доставки для набору банерів/правил доставки";
$GLOBALS['strChannelCompiledLimitationsValid'] = "Усі скомпільовані правила доставки для наборів правил доставки є дійсними";
$GLOBALS['strBannerCompiledLimitationsValid'] = "Усі складені правила доставки для банерів дійсні";
$GLOBALS['strErrorsFound'] = "Знайдено помилки";
$GLOBALS['strRepairCompiledLimitations'] = "Были найдены несоответствия, которые вы можете исправить нажав кнопку ниже.<br />";
$GLOBALS['strRecompile'] = "Перекомпілювати";
$GLOBALS['strDeliveryEngineDisagreeNotice'] = "За деяких обставин механізм доставки може не погоджуватися зі збереженими правилами доставки для банерів і наборів правил доставки, скористайтеся наступним посиланням, щоб перевірити правила доставки в базі даних";
$GLOBALS['strCheckACLs'] = "Перевірити правила доставки";

//  Append codes
$GLOBALS['strAppendCodesDesc'] = "За деяких обставин механізм доставки може не погоджуватися зі збереженими кодами додавання для трекерів, скористайтеся наступним посиланням, щоб перевірити коди додавання в базі даних";
$GLOBALS['strCheckAppendCodes'] = "Перевірити Додані коди";
$GLOBALS['strAppendCodesRecompiled'] = "Усі скомпільовані значення кодів додавання було перекомпільовано";
$GLOBALS['strAppendCodesResult'] = "Ось результати перевірки скомпільованих доданих кодів";
$GLOBALS['strAppendCodesValid'] = "Усі додані коди, скомпільовані трекером, дійсні";
$GLOBALS['strRepairAppenedCodes'] = "Были найдены некоторые несовпадения. для их коррекции нажмите пожалуйста кнопку ниже.";

$GLOBALS['strPlugins'] = "Плагіни";

$GLOBALS['strMenus'] = "Меню";
$GLOBALS['strMenusPrecis'] = "Перебудувати кеш меню";
$GLOBALS['strMenusCachedOk'] = "Кеш меню було перебудовано";

// Users
$GLOBALS['strUserPasswords'] = "Паролі користувачів";
$GLOBALS['strCheckUserPasswords'] = "Перевіртии паролі користувачів";
$GLOBALS['strUserPasswordsEverythingOK'] = "Жоден користувач не вимагає скидання пароля, все в порядку.";
$GLOBALS['strUserPasswordsEmailsSent'] = "Електронні листи для вибраних користувачів надіслано.";
