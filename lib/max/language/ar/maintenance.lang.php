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

// Maintenance

$GLOBALS['strAutoMantenaceEnabledAndHasntRun'] = "	<unk> الصيانة التلقائية مفعلة وسيتم تشغيلها، حسب الاقتضاء، عندما يقوم {$PRODUCT_NAME} بتسليم اللافتات.
	<unk> ولكن من أجل أفضل أداء ، يجب عليك إعداد <a href='{$PRODUCT_DOCSURL}/admin/maintenance' target='_blank'>صيانة مجدولة</a>.";

$GLOBALS['strAutoMantenaceDisabledAndHasntRun'] = "	<unk> الصيانة التلقائية معطلة حاليًا، لذلك عندما يقوم {$PRODUCT_NAME} بتسليم اللافتات، لن يتم تشغيل الصيانة التلقائية.
	<unk> من أجل أفضل أداء، يجب عليك إعداد <a href='{$PRODUCT_DOCSURL}/admin/maintenance' target='_blank'>صيانة مجدولة</a>.
    ومع ذلك، إذا لم تقم بإعداد <a href='{$PRODUCT_DOCSURL}/admin/maintenance' target='_blank'>صيانة مجدولة</a>،
    ثم <i>يجب</i> <a href='account-settings-maintenance.php'>تمكين الصيانة التلقائية</a> لضمان أن {$PRODUCT_NAME} يعمل بشكل صحيح.";

$GLOBALS['strAutoMantenaceEnabledAndRunning'] = "	<unk> الصيانة التلقائية مفعلة وسيتم تشغيلها، حسب الاقتضاء، عندما يقوم {$PRODUCT_NAME} بتسليم اللافتات.
	<unk> ولكن من أجل أفضل أداء ، يجب عليك إعداد <a href='{$PRODUCT_DOCSURL}/admin/maintenance' target='_blank'>صيانة مجدولة</a>.";

$GLOBALS['strAutoMantenaceDisabledAndRunning'] = "	• غير أن الصيانة التلقائية قد أوقفت مؤخرا. للتأكد من أن {$PRODUCT_NAME} يعمل بشكل صحيح، يجب عليك
	<unk> إعداد <a href='{$PRODUCT_DOCSURL}/admin/maintenance' target='_blank'>صيانة مجدولة</a> أو
	<a href='account-settings-maintenance.php'>إعادة تمكين الصيانة التلقائية</a>.
	<br><br>
	<unk> من أجل أفضل أداء ، يجب عليك إعداد <a href='{$PRODUCT_DOCSURL}/admin/maintenance' target='_blank'>الصيانة المجدولة</a>.";




// Priority
$GLOBALS['strRecalculatePriority'] = "إعادة حساب الأهمية";

// Banner cache
$GLOBALS['strCheckBannerCache'] = "فحص كاش البنرات";
$GLOBALS['strBannerCacheErrorsFound'] = "وجد الفحص بعض الأخطاء.لن تعمل البنرات إلا بعد إصلاحهم بشكل يدوي.";
$GLOBALS['strBannerCacheOK'] = "لم يجد الفحص أي أخطاء. الكاش الموجود محدّث حتى اللحظة.";
$GLOBALS['strBannerCacheDifferencesFound'] = "أثناء فحص الكاش للبنرات وجد النظام أنها ليست محدثة لأحدث نسخة. إضغط هنا للقيام بتحديث الكاش تلقائياً.";
$GLOBALS['strBannerCacheRebuildButton'] = "إعادة البناء";
$GLOBALS['strRebuildDeliveryCache'] = "إعادة بناء كاش البنرات في قاعدة البيانات";
$GLOBALS['strBannerCacheExplaination'] = "كاش قاعدة بيانات البنرات يستخد لزيادة سرعة تسليم البنرات<br />
هذا الكاش يحتاج إلى تحديث :
<ul>
<li>عندما تقوم بترقية نسختك من OpendX</li>
<li>عندماتقوم بنقل OpenX إلى خادم آخر</li>
</ul>";

// Cache
$GLOBALS['strDeliveryCacheSharedMem'] = "	حالياً يتم استخدام الذاكرة المشتركة لتخزين كاش التسليم.";
$GLOBALS['strDeliveryCacheDatabase'] = "	حالياً يتم استخدام قاعدة البيانات لتخزين كاش التسليم.";
$GLOBALS['strDeliveryCacheFiles'] = "	حالياً يتم تخزين كاش التسليم في ملفات متعددة على الخادم.";

// Storage
$GLOBALS['strStorage'] = "تخزين";
$GLOBALS['strMoveToDirectory'] = "نقل الصورالمخزنة في قاعدة البيانات إلى مجلد";
$GLOBALS['strStorageExplaination'] = "	صور البنرات المستخدمة داخلياً مخزنة في قاعدة البيانات أو أحد المجلدات. إن كنت تستخدم تخزين الصور داخل
	المجلدات سيقل الضغط على قواعد البيانات و سيؤدي ذلك إلى زيادة في سرعة عرض الإعلانات.";

// Security

// Encoding

// Product Updates
$GLOBALS['strSearchingUpdates'] = "يتم البحث عن تحديثات، الرجاء الإنتظار...";
$GLOBALS['strAvailableUpdates'] = "التحديثات المتوافرة";
$GLOBALS['strDownloadZip'] = "تحميل (ملف مضغوط .zip)";
$GLOBALS['strDownloadGZip'] = "تحميل (ملف مضغوط .tar.gz)";

$GLOBALS['strUpdateAlert'] = "نسخة جديدة متوافرة من {$PRODUCT_NAME}

 هل تريد الحصول على معلومات أكثر
 حول هذا التحديث؟";
$GLOBALS['strUpdateAlertSecurity'] = "نسخة جديدة متوافر من {$PRODUCT_NAME}

 ينصح بشدة أن تتم الترقية
 بأقرب فرصة، هذه النسخة
 تحتوي على تحديث أمني أو أكثر.";

$GLOBALS['strUpdateServerDown'] = "لسبب غير معروف لم نتمكن من<br> إسترجاع أي معلومة حول التحديثات المتوقعة. نرجو الرجو في وقت لاحق.";

$GLOBALS['strNoNewVersionAvailable'] = "	 نسختكم من {$PRODUCT_NAME} هي آخر نسخة متوافرة. لا يوجد أي تحديث حالياً.";



$GLOBALS['strNewVersionAvailable'] = "	<b>نسخة جديدة متوفرة من {$PRODUCT_NAME}</b><br /> It is ننصح بالتحديث إلى هذه النسخة،
	قد تحتوي النسخة على تحديثات لإصلاح بعض المشاكل الحالية، أو قد تكون بعض الإضافات الجديدة إضيفت لهذه النسخة، لمزيد من المعلومات
	حول التحديث نرجو مراجعة المعلومات الموجودة بالملفات بالأسفل.";

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

//  Append codes



// Users
