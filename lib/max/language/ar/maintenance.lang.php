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
$GLOBALS['strAppendCodes'] = "Append codes";

// Maintenance
$GLOBALS['strScheduledMaintenanceHasntRun'] = "<b>Scheduled maintenance hasn't run in the past hour. This may mean that you have not set it up correctly.</b>";

$GLOBALS['strAutoMantenaceEnabledAndHasntRun'] = "	Automatic maintenance is enabled, but it has not been triggered. Automatic maintenance is triggered only when {$PRODUCT_NAME} delivers banners.
    For the best performance, you should set up <a href='{$PRODUCT_DOCSURL}/admin/maintenance' target='_blank'>scheduled maintenance</a>.";

$GLOBALS['strAutoMantenaceDisabledAndHasntRun'] = "	Automatic maintenance is currently disabled, so when {$PRODUCT_NAME} delivers banners, automatic maintenance will not be triggered.
	For the best performance, you should set up <a href='{$PRODUCT_DOCSURL}/admin/maintenance' target='_blank'>scheduled maintenance</a>.
    However, if you are not going to set up <a href='{$PRODUCT_DOCSURL}/admin/maintenance' target='_blank'>scheduled maintenance</a>,
    then you <i>must</i> <a href='account-settings-maintenance.php'>enable automatic maintenance</a> to ensure that {$PRODUCT_NAME} works correctly.";

$GLOBALS['strAutoMantenaceEnabledAndRunning'] = "	Automatic maintenance is enabled and will be triggered, as required, when {$PRODUCT_NAME} delivers banners.
	However, for the best performance, you should set up <a href='{$PRODUCT_DOCSURL}/admin/maintenance' target='_blank'>scheduled maintenance</a>.";

$GLOBALS['strAutoMantenaceDisabledAndRunning'] = "	However, automatic maintenance has recently been disabled. To ensure that {$PRODUCT_NAME} works correctly, you should
	either set up <a href='{$PRODUCT_DOCSURL}/admin/maintenance' target='_blank'>scheduled maintenance</a> or
	<a href='account-settings-maintenance.php'>re-enable automatic maintenance</a>.
	<br><br>
	For the best performance, you should set up <a href='{$PRODUCT_DOCSURL}/admin/maintenance' target='_blank'>scheduled maintenance</a>.";

$GLOBALS['strScheduledMantenaceRunning'] = "<b>Scheduled maintenance is running correctly.</b>";

$GLOBALS['strAutomaticMaintenanceHasRun'] = "<b>Automatic maintenance is running correctly.</b>";

$GLOBALS['strAutoMantenaceEnabled'] = "However, automatic maintenance is still enabled. For the best performance, you should <a href='account-settings-maintenance.php'>disable automatic maintenance</a>.";

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
$GLOBALS['strCache'] = "Delivery cache";
$GLOBALS['strDeliveryCacheSharedMem'] = "	حالياً يتم استخدام الذاكرة المشتركة لتخزين كاش التسليم.";
$GLOBALS['strDeliveryCacheDatabase'] = "	حالياً يتم استخدام قاعدة البيانات لتخزين كاش التسليم.";
$GLOBALS['strDeliveryCacheFiles'] = "	حالياً يتم تخزين كاش التسليم في ملفات متعددة على الخادم.";

// Storage
$GLOBALS['strStorage'] = "تخزين";
$GLOBALS['strMoveToDirectory'] = "نقل الصورالمخزنة في قاعدة البيانات إلى مجلد";
$GLOBALS['strStorageExplaination'] = "	صور البنرات المستخدمة داخلياً مخزنة في قاعدة البيانات أو أحد المجلدات. إن كنت تستخدم تخزين الصور داخل
	المجلدات سيقل الضغط على قواعد البيانات و سيؤدي ذلك إلى زيادة في سرعة عرض الإعلانات.";

// Encoding
$GLOBALS['strEncoding'] = "Encoding";
$GLOBALS['strEncodingExplaination'] = "{$PRODUCT_NAME} now stores all data in the database in UTF-8 format.<br />
    Where possible, your data will have been automatically converted to this encoding.<br />
    If after upgrading you find corrupt characters, and you know the encoding used, you may use this tool to convert the data from that format to UTF-8";
$GLOBALS['strEncodingConvertFrom'] = "Convert from this encoding:";
$GLOBALS['strEncodingConvertTest'] = "Test conversion";
$GLOBALS['strConvertThese'] = "The following data will be changed if you continue";

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

$GLOBALS['strServerCommunicationError'] = "    <b>Communication with the update server timed out, so {$PRODUCT_NAME} is not
    able to check if a newer version is available at this stage. Please try again later.</b>";

$GLOBALS['strCheckForUpdatesDisabled'] = "    <b>Check for updates is disabled. Please enable via the
    <a href='account-settings-update.php'>update settings</a> screen.</b>";

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
$GLOBALS['strDeliveryLimitations'] = "Delivery Rules";
$GLOBALS['strAllBannerChannelCompiled'] = "All banner/delivery rule set compiled delivery rule values have been recompiled";
$GLOBALS['strBannerChannelResult'] = "Here are the results of the banner/delivery rule set compiled delivery rule validation";
$GLOBALS['strChannelCompiledLimitationsValid'] = "All compiled delivery rules for delivery rule sets are valid";
$GLOBALS['strBannerCompiledLimitationsValid'] = "All compiled delivery rules for banners are valid";
$GLOBALS['strErrorsFound'] = "Errors found";
$GLOBALS['strRepairCompiledLimitations'] = "Some inconsistencies were found above, you can repair these using the button below, this will recompile the compiled limitation for every banner/delivery rule set in the system<br />";
$GLOBALS['strRecompile'] = "Recompile";
$GLOBALS['strDeliveryEngineDisagreeNotice'] = "Under some circumstances the delivery engine can disagree with the stored delivery rules for banners and delivery rule sets, use the folowing link to validate the delivery rules in the database";
$GLOBALS['strCheckACLs'] = "Check delivery rules";

//  Append codes
$GLOBALS['strAppendCodesDesc'] = "Under some circumstances the delivery engine can disagree with the stored append codes for trackers, use the folowing link to validate the append codes in the database";
$GLOBALS['strCheckAppendCodes'] = "Check Append codes";
$GLOBALS['strAppendCodesRecompiled'] = "All compiled append codes values have been recompiled";
$GLOBALS['strAppendCodesResult'] = "Here are the results of the compiled append codes validation";
$GLOBALS['strAppendCodesValid'] = "All tracker compiled appendcodes are valid";
$GLOBALS['strRepairAppenedCodes'] = "Some inconsistencies were found above, you can repair these using the button below, this will recompile the append codes for every tracker in the system";

$GLOBALS['strPlugins'] = "Plugins";
$GLOBALS['strPluginsPrecis'] = "Diagnose and repair problems with {$PRODUCT_NAME} plugins";

$GLOBALS['strMenus'] = "Menus";
$GLOBALS['strMenusPrecis'] = "Rebuild the menu cache";
$GLOBALS['strMenusCachedOk'] = "Menu cache has been rebuilt";
