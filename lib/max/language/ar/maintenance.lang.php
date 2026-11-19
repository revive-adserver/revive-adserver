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
$GLOBALS['strChooseSection'] = "إختيار قسم";
$GLOBALS['strAppendCodes'] = "الأكواد الملحقة";

// Maintenance
$GLOBALS['strScheduledMaintenanceHasntRun'] = "<b>لم تعمل الصيانة المجدولة خلال الساعة الماضية، وقد يعني ذلك أن إعدادها غير صحيح.</b>";

$GLOBALS['strAutoMantenaceEnabledAndHasntRun'] = "	الصيانة التلقائية مفعّلة، لكنها لم تعمل بعد، إذ لا تعمل إلا عندما يعرض {$PRODUCT_NAME} البنرات.
    وللحصول على أفضل أداء، ننصح بإعداد <a href='{$PRODUCT_DOCSURL}/admin/maintenance' target='_blank'>صيانة مجدولة</a>.";

$GLOBALS['strAutoMantenaceDisabledAndHasntRun'] = "	الصيانة التلقائية معطّلة حاليًا، لذلك لن تعمل عندما يعرض {$PRODUCT_NAME} البنرات.
	وللحصول على أفضل أداء، ننصح بإعداد <a href='{$PRODUCT_DOCSURL}/admin/maintenance' target='_blank'>صيانة مجدولة</a>.
    أما إذا لم تكن تنوي إعداد <a href='{$PRODUCT_DOCSURL}/admin/maintenance' target='_blank'>صيانة مجدولة</a>،
    <i>فيجب</i> <a href='account-settings-maintenance.php'>تفعيل الصيانة التلقائية</a> ليعمل {$PRODUCT_NAME} بشكل صحيح.";

$GLOBALS['strAutoMantenaceEnabledAndRunning'] = "	الصيانة التلقائية مفعّلة وستعمل عند الحاجة عندما يعرض {$PRODUCT_NAME} البنرات.
	ومع ذلك، وللحصول على أفضل أداء، ننصح بإعداد <a href='{$PRODUCT_DOCSURL}/admin/maintenance' target='_blank'>صيانة مجدولة</a>.";

$GLOBALS['strAutoMantenaceDisabledAndRunning'] = "	غير أن الصيانة التلقائية عطّلت مؤخرًا. ولكي يعمل {$PRODUCT_NAME} بشكل صحيح، يجب
	إما إعداد <a href='{$PRODUCT_DOCSURL}/admin/maintenance' target='_blank'>صيانة مجدولة</a> أو
	<a href='account-settings-maintenance.php'>إعادة تفعيل الصيانة التلقائية</a>.
	<br><br>
	وللحصول على أفضل أداء، ننصح بإعداد <a href='{$PRODUCT_DOCSURL}/admin/maintenance' target='_blank'>صيانة مجدولة</a>.";

$GLOBALS['strScheduledMantenaceRunning'] = "<b>تعمل الصيانة المجدولة بشكل سليم.</b>";

$GLOBALS['strAutomaticMaintenanceHasRun'] = "<b>تعمل الصيانة التلقائية بشكل سليم.</b>";

$GLOBALS['strAutoMantenaceEnabled'] = "غير أن الصيانة التلقائية ما زالت مفعّلة. وللحصول على أفضل أداء، ينبغي <a href='account-settings-maintenance.php'>تعطيل الصيانة التلقائية</a>.";

// Priority
$GLOBALS['strRecalculatePriority'] = "إعادة حساب الأهمية";

// Banner cache
$GLOBALS['strCheckBannerCache'] = "فحص كاش البنرات";
$GLOBALS['strBannerCacheErrorsFound'] = "وجد الفحص بعض الأخطاء.لن تعمل البنرات إلا بعد إصلاحهم بشكل يدوي.";
$GLOBALS['strBannerCacheOK'] = "لم يجد الفحص أي أخطاء. الكاش الموجود محدّث حتى اللحظة.";
$GLOBALS['strBannerCacheDifferencesFound'] = "أثناء فحص الكاش للبنرات وجد النظام أنها ليست محدثة لأحدث نسخة. إضغط هنا للقيام بتحديث الكاش تلقائياً.";
$GLOBALS['strBannerCacheRebuildButton'] = "إعادة البناء";
$GLOBALS['strRebuildDeliveryCache'] = "إعادة بناء كاش البنرات في قاعدة البيانات";
$GLOBALS['strBannerCacheExplaination'] = "    يستخدم كاش البنرات في قاعدة البيانات لتسريع توصيل البنرات<br />
    ويجب تحديث هذا الكاش في الحالات التالية:
    <ul>
        <li>عند ترقية نسخة {$PRODUCT_NAME}</li>
        <li>عند نقل تثبيت {$PRODUCT_NAME} إلى خادم آخر</li>
    </ul>";

// Cache
$GLOBALS['strCache'] = "كاش التوصيل";
$GLOBALS['strDeliveryCacheSharedMem'] = "	حالياً يتم استخدام الذاكرة المشتركة لتخزين كاش التسليم.";
$GLOBALS['strDeliveryCacheDatabase'] = "	حالياً يتم استخدام قاعدة البيانات لتخزين كاش التسليم.";
$GLOBALS['strDeliveryCacheFiles'] = "	حالياً يتم تخزين كاش التسليم في ملفات متعددة على الخادم.";

// Storage
$GLOBALS['strStorage'] = "تخزين";
$GLOBALS['strMoveToDirectory'] = "نقل الصورالمخزنة في قاعدة البيانات إلى مجلد";
$GLOBALS['strStorageExplaination'] = "	صور البنرات المستخدمة داخلياً مخزنة في قاعدة البيانات أو أحد المجلدات. إن كنت تستخدم تخزين الصور داخل
	المجلدات سيقل الضغط على قواعد البيانات و سيؤدي ذلك إلى زيادة في سرعة عرض الإعلانات.";

// Security
$GLOBALS['strSecurity'] = "الأمان";
$GLOBALS['strSecurityExplanation'] = "لدواعٍ أمنية، لا ينبغي أن يتيح خادم الويب الوصول المباشر إلى بعض مجلدات حزمة {$PRODUCT_NAME}.
وترك هذه الملفات والمجلدات متاحة قد يكشف معلومات لا تريد كشفها
ويشكّل خطرًا أمنيًا. أجرينا فحصًا أمنيًا سريعًا، وستجد نتائجه أدناه.";
$GLOBALS['strSecurityOK'] = "لم يتمكن متصفحك من جلب الملفات المحمية، وهذا خبر رائع!";
$GLOBALS['strSecurityKO'] = "تمكّن متصفحك من جلب بعض الملفات التي يُفترض أن يتعذر الوصول إليها، ومنها:";
$GLOBALS['strSecurityReadMore'] = "اضغط هنا لمعرفة المزيد عن تأمين التثبيت لديك.";

// Encoding
$GLOBALS['strEncoding'] = "الترميز";
$GLOBALS['strEncodingExplaination'] = "يخزّن {$PRODUCT_NAME} الآن جميع البيانات في قاعدة البيانات بترميز UTF-8.<br />
وقد حُوِّلت بياناتك تلقائيًا إلى هذا الترميز حيثما أمكن.<br />
إذا وجدت بعد الترقية أحرفًا تالفة وكنت تعرف الترميز المستخدم، فيمكنك استخدام هذه الأداة لتحويل البيانات من ذلك الترميز إلى UTF-8";
$GLOBALS['strEncodingConvertFrom'] = "التحويل من هذا الترميز:";
$GLOBALS['strEncodingConvertTest'] = "تجربة التحويل";
$GLOBALS['strConvertThese'] = "ستتغير البيانات التالية إذا تابعت";

// Product Updates
$GLOBALS['strSearchingUpdates'] = "يتم البحث عن تحديثات، الرجاء الإنتظار...";
$GLOBALS['strAvailableUpdates'] = "التحديثات المتوافرة";
$GLOBALS['strAlternativeUpdateOptions'] = "وإن تعذّرت الترقية إلى إصدار رئيسي أو فرعي أحدث، فيمكنك اللجوء إلى هذا الخيار بدلًا من ذلك:";
$GLOBALS['strDownloadZip'] = "تحميل (ملف مضغوط .zip)";
$GLOBALS['strDownloadGZip'] = "تحميل (ملف مضغوط .tar.gz)";

$GLOBALS['strUpdateAlert'] = "نسخة جديدة متوافرة من {$PRODUCT_NAME}

 هل تريد الحصول على معلومات أكثر
 حول هذا التحديث؟";
$GLOBALS['strUpdateAlertSecurity'] = "نسخة جديدة متوافر من {$PRODUCT_NAME}

 ينصح بشدة أن تتم الترقية
 بأقرب فرصة، هذه النسخة
 تحتوي على تحديث أمني أو أكثر.";

$GLOBALS['strUpdateServerDown'] = "لسبب غير معروف، تعذر<br>استرجاع معلومات حول التحديثات المتاحة. يرجى المحاولة لاحقًا.";

$GLOBALS['strNoNewVersionAvailable'] = "	 نسختكم من {$PRODUCT_NAME} هي آخر نسخة متوافرة. لا يوجد أي تحديث حالياً.";

$GLOBALS['strServerCommunicationError'] = "<b>انتهت مهلة الاتصال بخادم التحديثات، لذا لا يستطيع {$PRODUCT_NAME}
التحقق من توفر إصدار أحدث حاليًا. يُرجى المحاولة لاحقًا.</b>";

$GLOBALS['strCheckForUpdatesDisabled'] = "<b>التحقق من التحديثات معطّل. يُرجى تفعيله من شاشة
<a href='account-settings-update.php'>إعدادات التحديث</a>.</b>";

$GLOBALS['strNewVersionAvailable'] = "	<b>تتوفر نسخة جديدة من {$PRODUCT_NAME}.</b><br /> ننصح بتثبيت هذا التحديث،
	لأنه قد يصلح بعض المشاكل الحالية ويضيف ميزات جديدة. لمزيد من المعلومات
	حول الترقية، يرجى قراءة الوثائق المرفقة في الملفات أدناه.</b>";

$GLOBALS['strSecurityUpdate'] = "	<b>ينصح بشدة أن تقوم بتركيب التحديثات بأقرب فرصة ممكنة، هذه التحديثات تحتوي على عدد
	من التحديثات الأمنية.</b> نسخة {$PRODUCT_NAME} التي تستخدمها حالياً قد تحتوي على
	بعض الثغرات الأمنية و قد تكون غير آمنة. للمزيد من المعلومات
	حول عملية الترقية، الرجاء قراءة التعليمات الموجودة ضمن الملف بالأسفل.";

$GLOBALS['strNotAbleToCheck'] = "	<b>بسبب عدم تفعيل خاصية XML أو عدم وجودها على السيرفر {$PRODUCT_NAME} لم يتمكن
من التحقق من وجود نسخ جديدة.</b>";

$GLOBALS['strForUpdatesLookOnWebsite'] = "	إن كنت تريد التحقق من وجود نسخ جديدة، الرجاء زيارة موقعنا.";

$GLOBALS['strClickToVisitWebsite'] = "إضغط هنا لزيارة موقعنا";
$GLOBALS['strCurrentlyUsing'] = "تستخدم الآن";
$GLOBALS['strRunningOn'] = "تعمل على";
$GLOBALS['strAndPlain'] = "و";

//  Deliver Limitations
$GLOBALS['strDeliveryLimitations'] = "قواعد التوصيل";
$GLOBALS['strAllBannerChannelCompiled'] = "أُعيد تجميع قيم قواعد التوصيل المجمّعة لجميع البنرات ومجموعات قواعد التوصيل";
$GLOBALS['strBannerChannelResult'] = "فيما يلي نتائج التحقق من قواعد التوصيل المجمّعة للبنرات ومجموعات قواعد التوصيل";
$GLOBALS['strChannelCompiledLimitationsValid'] = "جميع قواعد التوصيل المجمّعة لمجموعات قواعد التوصيل صالحة";
$GLOBALS['strBannerCompiledLimitationsValid'] = "جميع قواعد التوصيل المجمّعة للبنرات صالحة";
$GLOBALS['strErrorsFound'] = "الأخطاء المكتشفة";
$GLOBALS['strRepairCompiledLimitations'] = "ظهرت أعلاه بعض حالات عدم الاتساق، ويمكنك إصلاحها بالزر أدناه الذي يعيد تجميع قواعد التوصيل لكل بنر ومجموعة قواعد توصيل في النظام<br />";
$GLOBALS['strRecompile'] = "إعادة التجميع";
$GLOBALS['strDeliveryEngineDisagreeNotice'] = "قد لا يتوافق محرك التوصيل في بعض الحالات مع قواعد التوصيل المخزّنة للبنرات ومجموعات قواعد التوصيل، فاستخدم الرابط التالي للتحقق من قواعد التوصيل في قاعدة البيانات";
$GLOBALS['strCheckACLs'] = "فحص قواعد التوصيل";

//  Append codes
$GLOBALS['strAppendCodesDesc'] = "قد لا يتوافق محرك التوصيل في بعض الحالات مع الأكواد الملحقة المخزّنة للمتتبعات، فاستخدم الرابط التالي للتحقق من الأكواد الملحقة في قاعدة البيانات";
$GLOBALS['strCheckAppendCodes'] = "فحص الأكواد الملحقة";
$GLOBALS['strAppendCodesRecompiled'] = "أُعيد تجميع قيم جميع الأكواد الملحقة المجمّعة";
$GLOBALS['strAppendCodesResult'] = "فيما يلي نتائج التحقق من الأكواد الملحقة المجمّعة";
$GLOBALS['strAppendCodesValid'] = "جميع الأكواد الملحقة المجمّعة للمتتبعات صالحة";
$GLOBALS['strRepairAppenedCodes'] = "ظهرت أعلاه بعض حالات عدم الاتساق، ويمكنك إصلاحها بالزر أدناه الذي يعيد تجميع الأكواد الملحقة لكل متتبع في النظام";

$GLOBALS['strPlugins'] = "الإضافات";
$GLOBALS['strPluginsPrecis'] = "تشخيص مشكلات إضافات {$PRODUCT_NAME} وإصلاحها";

$GLOBALS['strMenus'] = "القوائم";
$GLOBALS['strMenusPrecis'] = "إعادة بناء كاش القوائم";
$GLOBALS['strMenusCachedOk'] = "أُعيد بناء كاش القوائم";

// Users
$GLOBALS['strUserPasswords'] = "كلمات سر المستخدمين";
$GLOBALS['strUserPasswordsExplaination'] = "بدءًا من الإصدار 5.4، يخزّن {$PRODUCT_NAME} كلمات السر بصيغة أكثر أمانًا.
استخدم هذه الأداة لمعرفة المستخدمين الذين ما زالت كلمات سرهم مخزّنة بالصيغة القديمة، ولإرسال بريد إلكتروني إلى المستخدمين الذين تختارهم يتيح لهم إدخال كلمة سر جديدة.
ويمكنك أيضًا استخدام الأداة لتذكير المستخدمين الجدد بتعيين كلمة السر الأولى.";
$GLOBALS['strCheckUserPasswords'] = "فحص كلمات سر المستخدمين";
$GLOBALS['strUserPasswordsEverythingOK'] = "لا يحتاج أي مستخدم إلى إعادة تعيين كلمة السر، وكل شيء سليم.";
$GLOBALS['strUserPasswordsEmailsSent'] = "أُرسلت رسائل البريد الإلكتروني إلى المستخدمين الذين اخترتهم.";
