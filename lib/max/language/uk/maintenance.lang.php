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

$GLOBALS['strAutoMantenaceEnabledAndHasntRun'] = "Автоматичне обслуговування ввімкнено, але його не було запущено. Автоматичне обслуговування запускається лише тоді, коли {$PRODUCT_NAME} доставляє банери.
     Для найкращої продуктивності вам слід налаштувати <a href='{$PRODUCT_DOCSURL}/admin/maintenance' target='_blank'>планове технічне обслуговування</a>.";

$GLOBALS['strAutoMantenaceDisabledAndHasntRun'] = "Автоматичне обслуговування наразі вимкнено, тому, коли {$PRODUCT_NAME} доставляє банери, автоматичне обслуговування не запускатиметься.
Для найкращої продуктивності вам слід налаштувати <a href='{$PRODUCT_DOCSURL}/admin/maintenance' target='_blank'>планове технічне обслуговування</a>.
     Однак, якщо ви не збираєтеся налаштовувати <a href='{$PRODUCT_DOCSURL}/admin/maintenance' target='_blank'>планове технічне обслуговування</a>, ви <i>повинні</i> <a href='account-settings-maintenance.php'>увімкніть автоматичне обслуговування</a>, щоб переконатися, що {$PRODUCT_NAME} працює правильно.";

$GLOBALS['strAutoMantenaceEnabledAndRunning'] = "Автоматичне технічне обслуговування ввімкнено та запускатиметься за потреби, коли {$PRODUCT_NAME} доставить банери.
Однак для найкращої продуктивності вам слід налаштувати <a href='{$PRODUCT_DOCSURL}/admin/maintenance' target='_blank'>планове технічне обслуговування</a>.";

$GLOBALS['strAutoMantenaceDisabledAndRunning'] = "Однак нещодавно автоматичне обслуговування було вимкнено. Щоб переконатися, що {$PRODUCT_NAME} працює належним чином, вам слід налаштувати <a href='{$PRODUCT_DOCSURL}/admin/maintenance' target='_blank'>планове технічне обслуговування</a> або
<a href='account-settings-maintenance.php'>знову ввімкнути автоматичне обслуговування</a>.
<br><br>
Для найкращої продуктивності вам слід налаштувати <a href='{$PRODUCT_DOCSURL}/admin/maintenance' target='_blank'>планове технічне обслуговування</a>.";

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
$GLOBALS['strBannerCacheExplaination'] = "Кеш банерів бази даних використовується для прискорення доставки банерів під час доставки<br />
     Цей кеш потрібно оновити, коли:
     <ul>
         <li>Ви оновлюєте свою версію {$PRODUCT_NAME}</li>
         <li>Ви перемістили установку {$PRODUCT_NAME} на інший сервер</li>
     </ul>";

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
$GLOBALS['strSecurityExplanation'] = "З міркувань безпеки деякі каталоги в пакеті {$PRODUCT_NAME} не повинні обслуговуватися безпосередньо вашим веб-сервером. Якщо залишити доступ до таких файлів і каталогів, це може призвести до розкриття небажаної інформації та становити загрозу безпеці. Було виконано швидку перевірку безпеки, і ви знайдете результати нижче.";
$GLOBALS['strSecurityOK'] = "Ваш браузер не зміг отримати захищені файли, це чудова новина!";
$GLOBALS['strSecurityKO'] = "Ваш браузер зміг отримати деякі файли, які не повинні бути доступні. Наприклад:";
$GLOBALS['strSecurityReadMore'] = "Клацніть тут, щоб дізнатися більше про те, як захистити вашу установку.";

// Encoding
$GLOBALS['strEncoding'] = "Кодування";
$GLOBALS['strEncodingExplaination'] = "{$PRODUCT_NAME} тепер зберігає всі дані в базі даних у форматі UTF-8.<br />
     Якщо це можливо, ваші дані будуть автоматично перетворені в це кодування.<br />
     Якщо після оновлення ви виявите пошкоджені символи та знаєте використовуване кодування, ви можете скористатися цим інструментом для перетворення даних із цього формату на UTF-8";
$GLOBALS['strEncodingConvertFrom'] = "Перетворити з цього кодування:";
$GLOBALS['strEncodingConvertTest'] = "Тестувати перетворення";
$GLOBALS['strConvertThese'] = "Наступні дані будуть змінені, якщо ви продовжите";

// Product Updates
$GLOBALS['strSearchingUpdates'] = "Шукаються оновлення. Будь ласка, зачекайте...";
$GLOBALS['strAvailableUpdates'] = "Доступні оновлення";
$GLOBALS['strDownloadZip'] = "Завантажити (.zip)";
$GLOBALS['strDownloadGZip'] = "Завантажити (.tar.gz)";

$GLOBALS['strUpdateAlert'] = "Доступна нова версія {$PRODUCT_NAME}.

Бажаєте отримати більше інформації про це оновлення?";
$GLOBALS['strUpdateAlertSecurity'] = "Доступна нова версія {$PRODUCT_NAME}.

Наполегливо рекомендуємо оновити якнайшвидше, оскільки ця версія містить одне або кілька виправлень безпеки.";

$GLOBALS['strUpdateServerDown'] = "З невідомих причин неможливо отримати <br>інформацію про можливі оновлення. Будь-ласка спробуйте пізніше.";

$GLOBALS['strNoNewVersionAvailable'] = "Ваша версія {$PRODUCT_NAME} є найновішою. Наразі немає доступних оновлень.";

$GLOBALS['strServerCommunicationError'] = "<b>Час очікування зв’язку із сервером оновлення минув, тому {$PRODUCT_NAME} не може перевірити, чи доступна новіша версія на цьому етапі. Повторіть спробу пізніше.</b>";

$GLOBALS['strCheckForUpdatesDisabled'] = "<b>Перевірку оновлень вимкнено. Увімкніть на екрані <a href='account-settings-update.php'>налаштування оновлення</a>.</b>";

$GLOBALS['strNewVersionAvailable'] = "<b>Доступна нова версія {$PRODUCT_NAME}.</b><br /> Рекомендовано встановити це оновлення, оскільки воно може вирішити деякі існуючі проблеми та додасть нові функції. Щоб дізнатися більше про оновлення, прочитайте документацію, яка міститься у файлах нижче.</b>";

$GLOBALS['strSecurityUpdate'] = "<b>Наполегливо рекомендуємо якнайшвидше встановити це оновлення, оскільки воно містить низку виправлень безпеки.</b> Версія {$PRODUCT_NAME}, якою ви зараз користуєтеся, може бути вразливою до певних атак і є ймовірно, не безпечно. Щоб дізнатися більше про оновлення, прочитайте документацію, яка міститься у файлах нижче.</b>";

$GLOBALS['strNotAbleToCheck'] = "<b>Оскільки розширення XML недоступне на вашому сервері, {$PRODUCT_NAME} не може перевірити, чи доступна новіша версія.</b>";

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
$GLOBALS['strPluginsPrecis'] = "Діагностика та вирішення проблем із плагінами {$PRODUCT_NAME}";

$GLOBALS['strMenus'] = "Меню";
$GLOBALS['strMenusPrecis'] = "Перебудувати кеш меню";
$GLOBALS['strMenusCachedOk'] = "Кеш меню було перебудовано";

// Users
$GLOBALS['strUserPasswords'] = "Паролі користувачів";
$GLOBALS['strUserPasswordsExplaination'] = "Починаючи з версії 5.4, {$PRODUCT_NAME} зберігає паролі в безпечнішому форматі.
Використовуйте цей інструмент, щоб перевірити, чи зберігаються у користувачів паролі в старому форматі, і надіслати вибраним користувачам електронні листи, щоб вони могли ввести новий пароль.
Інструмент також можна використовувати для нагадування новим користувачам, що вони повинні встановити свій перший пароль.";
$GLOBALS['strCheckUserPasswords'] = "Перевіртии паролі користувачів";
$GLOBALS['strUserPasswordsEverythingOK'] = "Жоден користувач не вимагає скидання пароля, все в порядку.";
$GLOBALS['strUserPasswordsEmailsSent'] = "Електронні листи для вибраних користувачів надіслано.";
