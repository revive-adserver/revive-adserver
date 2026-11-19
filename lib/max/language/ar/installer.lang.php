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

/** status messages * */
$GLOBALS['strInstallStatusRecovery'] = 'استعادة Revive Adserver %s';
$GLOBALS['strInstallStatusInstall'] = 'تثبيت Revive Adserver %s';
$GLOBALS['strInstallStatusUpgrade'] = 'الترقية إلى Revive Adserver %s';
$GLOBALS['strInstallStatusUpToDate'] = 'الإصدار المكتشف: Revive Adserver %s';

/** welcome step * */
$GLOBALS['strWelcomeTitle'] = "مرحبًا بك في {$PRODUCT_NAME}";
$GLOBALS['strInstallIntro'] = "شكرًا لاختيارك {$PRODUCT_NAME}. سيرشدك هذا المعالج خلال خطوات تثبيت {$PRODUCT_NAME}.";
$GLOBALS['strUpgradeIntro'] = "شكرًا لاختيارك {$PRODUCT_NAME}. سيرشدك هذا المعالج خلال خطوات ترقية {$PRODUCT_NAME}.";
$GLOBALS['strInstallerHelpIntro'] = "للمساعدة في تثبيت {$PRODUCT_NAME}، راجع <a href='{$PRODUCT_DOCSURL}' target='_blank'>التوثيق</a>.";
$GLOBALS['strTermsIntro'] = "يُوزَّع {$PRODUCT_NAME} مجانًا بموجب رخصة مفتوحة المصدر، هي GNU General Public License. يُرجى مراجعة المستندات التالية والموافقة عليها لمتابعة التثبيت.";

/** check step * */
$GLOBALS['strSystemCheck'] = "فحص النظام";
$GLOBALS['strSystemCheckIntro'] = "أجرى معالج التثبيت فحصًا لإعدادات خادم الويب لديك للتأكد من أن التثبيت سيكتمل بنجاح.
<br>يُرجى مراجعة المشكلات المميَّزة لإكمال التثبيت.";
$GLOBALS['strFixErrorsBeforeContinuing'] = "لا تستوفي إعدادات خادم الويب لديك متطلبات {$PRODUCT_NAME}.
<br>يُرجى إصلاح جميع الأخطاء لمتابعة التثبيت.
للمساعدة، راجع <a href='{$PRODUCT_DOCSURL}'>التوثيق</a> و<a href='http://{$PRODUCT_URL}/faq'>الأسئلة الشائعة</a>";

$GLOBALS['strAppCheckErrors'] = "ظهرت أخطاء أثناء البحث عن تثبيتات سابقة من {$PRODUCT_NAME}";
$GLOBALS['strAppCheckDbIntegrityError'] = "اكتشفنا مشكلات في سلامة قاعدة بياناتك، أي أن بنية قاعدة البيانات
تختلف عن البنية المتوقعة. وقد يعود ذلك إلى تعديلات أُجريت على قاعدة البيانات.";

$GLOBALS['strSyscheckProgressMessage'] = "جارٍ فحص معاملات النظام...";
$GLOBALS['strError'] = "خطأ";
$GLOBALS['strWarning'] = "تحذير";
$GLOBALS['strOK'] = "سليم";
$GLOBALS['strSyscheckName'] = "اسم الفحص";
$GLOBALS['strSyscheckValue'] = "القيمة الحالية";
$GLOBALS['strSyscheckStatus'] = "الحالة";
$GLOBALS['strSyscheckSeeFullReport'] = "عرض فحص النظام المفصّل";
$GLOBALS['strSyscheckSeeShortReport'] = "عرض الأخطاء والتحذيرات فقط";
$GLOBALS['strBrowserCookies'] = 'كوكيز المتصفح';
$GLOBALS['strPHPConfiguration'] = 'إعدادات PHP';
$GLOBALS['strCheckError'] = 'خطأ';
$GLOBALS['strCheckErrors'] = 'أخطاء';
$GLOBALS['strCheckWarning'] = 'تحذير';
$GLOBALS['strCheckWarnings'] = 'تحذيرات';

/** admin login step * */
$GLOBALS['strAdminLoginTitle'] = "يُرجى تسجيل الدخول بحساب مدير النظام في {$PRODUCT_NAME}";
$GLOBALS['strAdminLoginIntro'] = "للمتابعة، أدخل بيانات الدخول إلى حساب مدير النظام في {$PRODUCT_NAME}.";
$GLOBALS['strLoginProgressMessage'] = 'جارٍ تسجيل الدخول...';

/** database step * */
$GLOBALS['strDbSetupTitle'] = "تحديد قاعدة البيانات";
$GLOBALS['strDbSetupIntro'] = "أدخل بيانات الاتصال بقاعدة بيانات {$PRODUCT_NAME}.";
$GLOBALS['strDbUpgradeTitle'] = "قاعدة البيانات المكتشفة";
$GLOBALS['strDbUpgradeIntro'] = "هذه قاعدة البيانات التي عثرنا عليها لتثبيت {$PRODUCT_NAME} لديك.
تأكد من صحتها، ثم اضغط «متابعة».";
$GLOBALS['strDbProgressMessageInstall'] = 'جارٍ تثبيت قاعدة البيانات...';
$GLOBALS['strDbProgressMessageUpgrade'] = 'جارٍ ترقية قاعدة البيانات...';
$GLOBALS['strDbSeeMoreFields'] = 'عرض المزيد من حقول قاعدة البيانات...';
$GLOBALS['strDbTimeZoneWarning'] = "<p>بدءًا من هذا الإصدار، يخزّن {$PRODUCT_NAME} التواريخ بتوقيت UTC بدلًا من توقيت الخادم.</p>
<p>إذا أردت عرض الإحصائيات السابقة بالمنطقة الزمنية الصحيحة، فعليك ترقية بياناتك يدويًا. تجد المزيد من التفاصيل <a target='help' href='%s'>هنا</a>.
وستبقى قيم الإحصائيات دقيقة حتى لو لم تغيّر بياناتك.
</p>";
$GLOBALS['strDbTimeZoneNoWarnings'] = "عدم عرض تحذيرات المنطقة الزمنية مستقبلًا";
$GLOBALS['strDBInstallSuccess'] = "اكتمل إنشاء قاعدة البيانات بنجاح";
$GLOBALS['strDBUpgradeSuccess'] = "اكتملت ترقية قاعدة البيانات بنجاح";

$GLOBALS['strDetectedVersion'] = "إصدار {$PRODUCT_NAME} المكتشف";

/** config step * */
$GLOBALS['strConfigureInstallTitle'] = "إعداد حساب مدير النظام المحلي في {$PRODUCT_NAME}";
$GLOBALS['strConfigureInstallIntro'] = "أدخل بيانات الدخول التي تريدها لحساب مدير النظام المحلي في {$PRODUCT_NAME}.";
$GLOBALS['strConfigureUpgradeTitle'] = "إعدادات التهيئة";
$GLOBALS['strConfigureUpgradeIntro'] = "أدخل مسار التثبيت السابق لـ {$PRODUCT_NAME}.";
$GLOBALS['strConfigSeeMoreFields'] = "عرض المزيد من حقول الإعدادات...";
$GLOBALS['strPreviousInstallTitle'] = "التثبيت السابق";
$GLOBALS['strPathToPrevious'] = "مسار التثبيت السابق لـ {$PRODUCT_NAME}";
$GLOBALS['strPathToPreviousError'] = "تعذّر العثور على ملف أو أكثر من ملفات الإضافات، راجع ملف install.log لمزيد من المعلومات";
$GLOBALS['strConfigureProgressMessage'] = "جارٍ إعداد {$PRODUCT_NAME}...";

/** jobs step * */
$GLOBALS['strJobsInstallTitle'] = "تنفيذ مهام التثبيت";
$GLOBALS['strJobsInstallIntro'] = "ينفّذ برنامج التثبيت الآن مهام التثبيت الأخيرة.";
$GLOBALS['strJobsUpgradeTitle'] = "تنفيذ مهام الترقية";
$GLOBALS['strJobsUpgradeIntro'] = "ينفّذ برنامج التثبيت الآن مهام الترقية الأخيرة.";
$GLOBALS['strJobsProgressInstallMessage'] = "جارٍ تشغيل مهام التثبيت...";
$GLOBALS['strJobsProgressUpgradeMessage'] = "جارٍ تشغيل مهام الترقية...";

$GLOBALS['strPluginTaskChecking'] = "فحص إضافة {$PRODUCT_NAME}";
$GLOBALS['strPluginTaskInstalling'] = "تثبيت إضافة {$PRODUCT_NAME}";
$GLOBALS['strPostInstallTaskRunning'] = "تشغيل المهمة";

/** finish step * */
$GLOBALS['strFinishInstallTitle'] = "اكتمل تثبيت {$PRODUCT_NAME}.";
$GLOBALS['strFinishUpgradeWithErrorsTitle'] = "اكتملت ترقية {$PRODUCT_NAME}. يُرجى مراجعة المشكلات المميَّزة.";
$GLOBALS['strFinishUpgradeTitle'] = "اكتملت ترقية {$PRODUCT_NAME}.";
$GLOBALS['strFinishInstallWithErrorsTitle'] = "اكتمل تثبيت {$PRODUCT_NAME}. يُرجى مراجعة المشكلات المميَّزة.";
$GLOBALS['strDetailedTaskErrorList'] = "قائمة مفصّلة بالأخطاء المكتشفة";
$GLOBALS['strPluginInstallFailed'] = "فشل تثبيت الإضافة «%s»:";
$GLOBALS['strTaskInstallFailed'] = "حدث خطأ أثناء تشغيل مهمة التثبيت «%s»:";
$GLOBALS['strContinueToLogin'] = "اضغط «متابعة» لتسجيل الدخول إلى نسختك من {$PRODUCT_NAME}.";

$GLOBALS['strUnableCreateConfFile'] = "تعذّر علينا إنشاء ملف الإعدادات. يُرجى التحقق مجددًا من صلاحيات المجلد var في {$PRODUCT_NAME}.";
$GLOBALS['strUnableUpdateConfFile'] = "تعذّر علينا تحديث ملف الإعدادات. يُرجى التحقق مجددًا من صلاحيات المجلد var في {$PRODUCT_NAME}، ومن صلاحيات ملف إعدادات التثبيت السابق الذي نسخته إلى هذا المجلد.";
$GLOBALS['strUnableToCreateAdmin'] = "تعذّر علينا إنشاء حساب مدير النظام. هل يمكن الوصول إلى قاعدة البيانات؟";
$GLOBALS['strTimezoneLocal'] = "اكتشف {$PRODUCT_NAME} أن PHP المثبّت لديك يعيد القيمة \"System/Localtime\" على أنها المنطقة الزمنية
لخادمك. ويعود ذلك إلى تعديل (patch) تطبّقه بعض توزيعات Linux على PHP.
لكن هذه القيمة ليست منطقة زمنية صالحة في PHP. يُرجى تعديل ملف php.ini وضبط الخاصية \"date.timezone\" على القيمة الصحيحة لخادمك.";

$GLOBALS['strInstallNonBlockingErrors'] = "حدث خطأ أثناء تنفيذ مهام التثبيت. للاطلاع على التفاصيل، راجع 
<a class=\"show-errors\" href=\"#\">قائمة الأخطاء</a> وسجل التثبيت في \\'%s\\'.
ومع ذلك، ستتمكن من تسجيل الدخول إلى نسختك من {$PRODUCT_NAME}.";
