<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
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
$Id: translation.php 28570 2008-11-06 16:21:37Z chris.nutting $
*/



// Note: New translations not found in original lang files but found in CSV
$GLOBALS['strInventory'] = "المخزن";
$GLOBALS['strBasicInformation'] = "معلومات أساسية";
$GLOBALS['strWarning'] = "تحذير";
$GLOBALS['strTypeFTPUsername'] = "اسم الدخول";
$GLOBALS['strTypeFTPPassword'] = "كلمة السر";
$GLOBALS['strHideInactive'] = "إخفاء الغير فعّال";
$GLOBALS['strHasTaxID'] = "رقم الضريبة";
$GLOBALS['strGeneralSettings'] = "الإعدادات العامة";
$GLOBALS['strAdminSettings'] = "خيارات المدير";
$GLOBALS['strAdministratorSettings'] = "خيارات المدير";
$GLOBALS['strChooseSection'] = "إختيار قسم";
$GLOBALS['strInstall'] = "تنصيب";
$GLOBALS['strLanguageSelection'] = "إختيار اللغة";
$GLOBALS['strDatabaseSettings'] = "خيارات قواعد البيانات";
$GLOBALS['strAdminAccount'] = "حساب المدير";
$GLOBALS['strAdvancedSettings'] = "خيارات متقدمة";
$GLOBALS['strSpecifySyncSettings'] = "خيارات التزامن";
$GLOBALS['strOpenadsIdYour'] = "رقم حسابك في برنامج الإعلانات";
$GLOBALS['strOpenadsIdSettings'] = "خيارات رقم حسابك في برنامج الإعلانات";
$GLOBALS['strBtnContinue'] = "متابعة >>";
$GLOBALS['strBtnRecover'] = "إسترجاع >>";
$GLOBALS['strBtnStartAgain'] = "البدء بالتحديث من جديد >>";
$GLOBALS['strBtnGoBack'] = "<< الرجوع";
$GLOBALS['strBtnAgree'] = "موافق >>";
$GLOBALS['strBtnRetry'] = "فصح جديد";
$GLOBALS['strFixErrorsBeforeContinuing'] = "الرجاء إصلاح الأخطاء الموجودة قبل المتابعة.";
$GLOBALS['strWarningRegisterArgcArv'] = "حتى تتم عملية الصيانة من خلال سطر الأوامر يجب أن يكون المتغير register_argc_argv مفعلاً في خيارات PHP.";
$GLOBALS['strTablesPrefix'] = "السابقة لإسم الجداول";
$GLOBALS['strTablesType'] = "نوع الجدول";
$GLOBALS['strRecoveryRequiredTitle'] = "عملية محاولة الترقية السابقة واجهت بعض المشاكل";
$GLOBALS['strRecoveryRequired'] = "حدثت مشكلة أثناء محاولة الترقية و سيقوم برنامج ". MAX_PRODUCT_NAME ." بمحاولة إصلاح عملية الترقية. إضغط زر التصحيح بالأسفل.";
$GLOBALS['strDbSetupTitle'] = "خيارات قواعد البيانات";
$GLOBALS['strSystemCheck'] = "فحص النظام";
$GLOBALS['strDbSuccessIntro'] = "تم إنشاء قاعد بيانات لـ ". MAX_PRODUCT_NAME ." . إضغط 'استمرار' لمتابعة تعديل الاعدادات.";
$GLOBALS['strErrorWritePermissions'] = "هناك خلل في تصاريح الملفات ، يجب عليك إصلاحه قبل الاستمرار.<br />لحل الأخطاء في نظام لينوكس ، قم بكتابة هذه الأوامر :";
$GLOBALS['strErrorFixPermissionsCommand'] = "<i>إعطاء التصريح a+w %s</i>";
$GLOBALS['strErrorWritePermissionsWin'] = "هناك خلل في تصاريح الملفات ، يجب عليك إصلاحه قبل الاستمرار";
$GLOBALS['strCheckDocumentation'] = "لمزيد من التعليمات ، الرجاء الإطلاع على <وثائق مساعدة>. ";
$GLOBALS['strAdminUrlPrefix'] = "رابط لوحة التحكم";
$GLOBALS['strDeliveryUrlPrefix'] = "نظام التوزيع";
$GLOBALS['strDeliveryUrlPrefixSSL'] = "نظام التوزيع";
$GLOBALS['strImagesUrlPrefix'] = "رابط حفظ الصور";
$GLOBALS['strImagesUrlPrefixSSL'] = "رابط حفظ الصور (رابط آمن)";
$GLOBALS['strEditConfigNotPossible'] = "لا يمكن تعديل جميع الخيارات لأن ملف الاعدادات مغلق لأسباب أمنية ، إذا كنت تريد التعديل ، تحتاج لفتح الملف أولاً .";
$GLOBALS['strEditConfigPossible'] = "يمكن تعديل جميع الخيارات لأن ملف الاعدادات غير مقفل ، و هذا يؤدي لمشاكل أمنية . اذا كنت تريد زيادة الأمان في نظامك ، قم بقفل ملف الاعدادات";
$GLOBALS['strUnableToWriteConfig'] = "تعذر حفظ التعديلات في ملف الإعدادات";
$GLOBALS['strUnableToWritePrefs'] = "تعذر حفظ التعديلات في قاعدة البيانات";
$GLOBALS['strImageDirLockedDetected'] = "<b>ملجد الصور</b>غير قابل للكتابة. <br> يجب عليك إنشاء المجلد او تعديل صلاحياته قبل الاستمرار";
$GLOBALS['strConfigurationSettings'] = "تعديل الاعدادات";
$GLOBALS['strLoginCredentials'] = "معلومات الدخول";
$GLOBALS['strAdminUsername'] = "اسم المستخدم للمدير";
$GLOBALS['strAdminPassword'] = "كلمة السر للمدير";
$GLOBALS['strInvalidUsername'] = "اسم المستخدم غير صالح";
$GLOBALS['strAdminFullName'] = "الاسم الكامل للمدير";
$GLOBALS['strAdminEmail'] = "البريد الالكتروني للمدير";
$GLOBALS['strAdministratorEmail'] = "البريد الالكتروني للمدير العام";
$GLOBALS['strCompanyName'] = "اسم الشركة";
$GLOBALS['strUserlogEmail'] = "حفظ كل الرسائل الصادرة";
$GLOBALS['strTimezone'] = "المنطقة الزمنية";
$GLOBALS['strTimezoneEstimated'] = "المنطقة الزمنية المتوقعة";
$GLOBALS['strTimezoneGuessedValue'] = "المنطقة الزمنية للسيرفر غير مجهزة في إعدادات PHP";
$GLOBALS['strTimezoneSeeDocs'] = "الرجاء الإطلاع على %DOCS% بخصوص تجهيز هذا المتغير في PHP.";
$GLOBALS['strTimezoneDocumentation'] = "وثائق المساعدة";
$GLOBALS['strLoginSettingsTitle'] = "تسجيل دخول المدير";
$GLOBALS['strDatabaseServer'] = "الإعدادات العامة لمستضيف قاعدة البيانات";
$GLOBALS['strDbType'] = "نوع قاعدة البيانات";
$GLOBALS['strDbHost'] = "مستضيف قاعدة البيانات";
$GLOBALS['strDbPort'] = "رقم المنفذ (بورت) قاعدة البيانات";
$GLOBALS['strDbUser'] = "اسم مستخدم قاعدة البيانات";
$GLOBALS['strDbPassword'] = "كلمة سر قاعدة البيانات";
$GLOBALS['strDbName'] = "اسم قاعدة البيانات";
$GLOBALS['strPersistentConnections'] = "استخدام الاتصال المستمر";
$GLOBALS['strCantConnectToDb'] = "لا يمكن الاتصال بقاعدة البيانات";
$GLOBALS['strDemoDataInstall'] = "تركيب بيانات تجريبية";
$GLOBALS['strProduction'] = "بيئة عمل";
$GLOBALS['strDebugTypeFile'] = "ملف";
$GLOBALS['strDebugTypeSql'] = "قاعدة بيانات SQL";
$GLOBALS['strDebugTypeSyslog'] = "سجل النظام";
$GLOBALS['strImagePath'] = "مسار الصور";
$GLOBALS['strImageSslPath'] = "مسار الصور (آمن)";
$GLOBALS['strImageStore'] = "مجلد الصور";
$GLOBALS['strTypeWebMode'] = "اسلوب التخزين";
$GLOBALS['strTypeWebModeLocal'] = "المجلد المحلي";
$GLOBALS['strTypeWebDir'] = "المجلد المحلي";
$GLOBALS['strTypeDirError'] = "المجلد المحلي غير قابل للكتابة";
$GLOBALS['strTypeWebModeFtp'] = "مستضيف FTP خارجي";
$GLOBALS['strTypeFTPHost'] = "مستضيف FTP";
$GLOBALS['strTypeFTPDirectory'] = "مجلد المستضيف";
$GLOBALS['strTypeFTPPassive'] = "استخدام اسلوب passive FTP";
$GLOBALS['strTypeFTPErrorDir'] = "مجلد المستضيف غير موجود";
$GLOBALS['strTypeFTPErrorConnect'] = "لا يمكن الاتصال بمستضيف FTP ، الرجاء التحقق من اسم المستخدم او كلمة السر.";
$GLOBALS['strTypeFTPErrorHost'] = "عنوان مستضيف FTP غير صحيح";
$GLOBALS['strDeliveryFilenamesAdClick'] = "رابط الضغط على الإعلان";
$GLOBALS['strDeliveryFilenamesAdImage'] = "صورة الاعلان";
$GLOBALS['strOriginTypeXMLRPC'] = "XMLRPC";
$GLOBALS['strWeightDefaults'] = "الوزن الافتراضي";
$GLOBALS['strDefaultBannerWeight'] = "الوزن الافتراضي للبنر";
$GLOBALS['strDefaultCampaignWeight'] = "الوزن الافتراضي للحملة الاعلانية";
$GLOBALS['strPublisherDefaults'] = "الخيارات الافتراضية للموقع";
$GLOBALS['strModesOfPayment'] = "أساليب الدفع";
$GLOBALS['strCurrencies'] = "العملات";
$GLOBALS['strCategories'] = "الأقسام";
$GLOBALS['strHelpFiles'] = "ملفات التعليمات";
$GLOBALS['strLogAdRequests'] = "تسجيل وقت طلب البنر كل مرة يتم طلبه";
$GLOBALS['strLogAdImpressions'] = "زيادة مرات الظهور في كل مرة يتم عرض البنر";
$GLOBALS['strLogAdClicks'] = "زيادة مرات الضغطات في كل مرة يتم ضغط البنر";
$GLOBALS['strPreventLogging'] = "خيارات حجب تسجيل البنرات";
$GLOBALS['strMaintenanceOI'] = "توقيت عمليات الصيانة (كل × دقيقة)";
$GLOBALS['strMaintenanceOIError'] = "توقيت عمليات الصيانة غير صحيح - الرجاء الاطلاع على التعليمات لمعرفة القيم الصحيحة";
$GLOBALS['strPrioritySettings'] = "إعدادات الأهمية";
$GLOBALS['strWarnLimit'] = "ارسل تحذيراً عندما يكون عدد مرات الظهور أقل من الرقم المكتوب هنا";
$GLOBALS['strAppName'] = "اسم التطبيق";
$GLOBALS['strDefaultTrackerStatus'] = "النوع الافتراضي للمتتبع";
$GLOBALS['strDefaultTrackerType'] = "النوع الافتراضي للمتتبع";
$GLOBALS['strMyLogo'] = "اسم الشعار المخصص";
$GLOBALS['strMyLogoError'] = "ملف الشعار غير موجود في مجلد admin/images ";
$GLOBALS['strClientInterface'] = "واجهة المعلن";
$GLOBALS['strReportsInterface'] = "واجهة التقارير";
$GLOBALS['strClientWelcomeEnabled'] = "إتاحة رسالة الترحيب بالمعلن";
$GLOBALS['strClientWelcomeText'] = "نص الترحيب<br />(HTML متاح)";
$GLOBALS['strPublisherInterface'] = "واجهة الموقع";
$GLOBALS['strPublisherAgreementText'] = "نص تسجيل الدخول<br />(HTML متاح)";
$GLOBALS['strNovice'] = "نحتاج للتأكيد قبل الحذف كخطوة احترازية";
$GLOBALS['strAlreadyInstalled'] = "". MAX_PRODUCT_NAME ." تم تنصيبه بنجاح على نظامك. إذا كنت تريد تعديله يمكنك الذهاب إلى <a href='account-index.php'>خيارات شكل لوحة التحكم</a>.";
$GLOBALS['strAllowEmail'] = "السماح بإرسال الإيميلات بشكل عام";
$GLOBALS['strEmailAddressFrom'] = "البريد الإلكتروني الذي يراد إرسال التقارير منه";
$GLOBALS['strEmailAddressName'] = "الشركة أو الإسم الذي يراد توقيع الرسائل الإلكترونية به";
$GLOBALS['strBannerLogging'] = "خيارات حجب تسجيل البنرات";
$GLOBALS['strErrorFixPermissionsRCommand'] = "<i>إعطاء التصريح a+w %s</i>";
$GLOBALS['strDefaultConversionStatus'] = "قوانين التحويل الإفتراضية";
$GLOBALS['strDefaultConversionType'] = "قوانين التحويل الإفتراضية";
?>