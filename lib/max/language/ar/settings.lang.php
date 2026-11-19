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

// Installer translation strings
$GLOBALS['strInstall'] = "تنصيب";
$GLOBALS['strDatabaseSettings'] = "خيارات قواعد البيانات";
$GLOBALS['strAdminAccount'] = "حساب المدير";
$GLOBALS['strAdvancedSettings'] = "خيارات متقدمة";
$GLOBALS['strWarning'] = "تحذير";
$GLOBALS['strBtnContinue'] = "متابعة >>";
$GLOBALS['strBtnRecover'] = "إسترجاع >>";
$GLOBALS['strBtnAgree'] = "موافق >>";
$GLOBALS['strBtnRetry'] = "إعادة المحاولة";
$GLOBALS['strTablesPrefix'] = "السابقة لإسم الجداول";
$GLOBALS['strTablesType'] = "نوع الجدول";

$GLOBALS['strRecoveryRequiredTitle'] = "عملية محاولة الترقية السابقة واجهت بعض المشاكل";
$GLOBALS['strRecoveryRequired'] = "حدثت مشكلة أثناء محاولة الترقية و سيقوم برنامج {$PRODUCT_NAME} بمحاولة إصلاح عملية الترقية. إضغط زر التصحيح بالأسفل.";

$GLOBALS['strProductUpToDateTitle'] = "{$PRODUCT_NAME} محدث إلى أحدث إصدار";
$GLOBALS['strOaUpToDate'] = "تستخدم قاعدة بيانات {$PRODUCT_NAME} وبنية ملفاته أحدث إصدار، لذلك لا حاجة إلى الترقية الآن. اضغط «متابعة» للانتقال إلى لوحة الإدارة.";
$GLOBALS['strOaUpToDateCantRemove'] = "لا يزال ملف UPGRADE موجودًا في مجلد 'var'، ولم نتمكن من حذفه لعدم كفاية الصلاحيات. يُرجى حذف هذا الملف بنفسك.";
$GLOBALS['strErrorWritePermissions'] = "هناك خلل في تصاريح الملفات ، يجب عليك إصلاحه قبل الاستمرار.<br />لحل الأخطاء في نظام لينوكس ، قم بكتابة هذه الأوامر :";
$GLOBALS['strErrorFixPermissionsRCommand'] = "<i>chmod -R a+w %s</i>";
$GLOBALS['strNotWriteable'] = "غير قابل للكتابة";
$GLOBALS['strDirNotWriteableError'] = "يجب أن يكون المجلد قابلًا للكتابة";

$GLOBALS['strErrorWritePermissionsWin'] = "هناك خلل في تصاريح الملفات ، يجب عليك إصلاحه قبل الاستمرار";
$GLOBALS['strCheckDocumentation'] = "لمزيد من التعليمات ، الرجاء الإطلاع على <وثائق مساعدة>. ";
$GLOBALS['strSystemCheckBadPHPConfig'] = "لا تستوفي إعدادات PHP الحالية متطلبات {$PRODUCT_NAME}. لحل هذه المشكلات، عدّل الإعدادات في ملف 'php.ini'.";

$GLOBALS['strAdminUrlPrefix'] = "رابط لوحة التحكم";
$GLOBALS['strDeliveryUrlPrefix'] = "رابط محرك التوصيل";
$GLOBALS['strDeliveryUrlPrefixSSL'] = "رابط محرك التوصيل (SSL)";
$GLOBALS['strImagesUrlPrefix'] = "رابط حفظ الصور";
$GLOBALS['strImagesUrlPrefixSSL'] = "رابط حفظ الصور (رابط آمن)";


$GLOBALS['strUpgrade'] = "الترقية";

/* ------------------------------------------------------- */
/* Configuration translations                            */
/* ------------------------------------------------------- */

// Global
$GLOBALS['strChooseSection'] = "إختيار قسم";
$GLOBALS['strEditConfigNotPossible'] = "لا يمكن تعديل جميع الإعدادات لأن ملف الإعدادات مقفل لأسباب أمنية.
    إذا أردت إجراء تغييرات، فقد تحتاج أولًا إلى إلغاء قفل ملف الإعدادات لهذا التثبيت.";
$GLOBALS['strEditConfigPossible'] = "يمكن تعديل جميع الإعدادات لأن ملف الإعدادات غير مقفل، لكن ذلك قد يسبب مشكلات أمنية.
    إذا أردت تأمين نظامك، فعليك قفل ملف الإعدادات لهذا التثبيت.";
$GLOBALS['strUnableToWriteConfig'] = "تعذر حفظ التعديلات في ملف الإعدادات";
$GLOBALS['strUnableToWritePrefs'] = "تعذر حفظ التعديلات في قاعدة البيانات";
$GLOBALS['strImageDirLockedDetected'] = "لا يستطيع الخادم الكتابة في مجلد الصور المحدد. لا يمكنك المتابعة حتى تغيّر صلاحيات المجلد أو تنشئه.";

// Configuration Settings
$GLOBALS['strConfigurationSettings'] = "إعدادات التهيئة";

// Administrator Settings
$GLOBALS['strAdminUsername'] = "اسم المستخدم للمدير";
$GLOBALS['strAdminPassword'] = "كلمة السر للمدير";
$GLOBALS['strInvalidUsername'] = "اسم المستخدم غير صالح";
$GLOBALS['strBasicInformation'] = "معلومات أساسية";
$GLOBALS['strAdministratorEmail'] = "البريد الالكتروني للمدير العام";
$GLOBALS['strAdminCheckUpdates'] = "التحقق تلقائيًا من تحديثات المنتج والتنبيهات الأمنية (موصى به).";
$GLOBALS['strAdminShareStack'] = "مشاركة معلومات تقنية مع فريق {$PRODUCT_NAME} للمساعدة في التطوير والاختبار.";
$GLOBALS['strMinimumReleaseStability'] = "الحد الأدنى لاستقرار الإصدار";
$GLOBALS['strStableReleases'] = "مستقر";
$GLOBALS['strDevelopmentReleases'] = "قيد التطوير";
$GLOBALS['strInvalidReleaseStability'] = "اختر حدًّا أدنى صالحًا لاستقرار الإصدار.";
$GLOBALS['strNovice'] = "نحتاج للتأكيد قبل الحذف كخطوة احترازية";
$GLOBALS['strUserlogEmail'] = "حفظ كل الرسائل الصادرة";
$GLOBALS['strEnableDashboard'] = "تفعيل لوحة التحكم";
$GLOBALS['strEnableDashboardSyncNotice'] = "يُرجى تفعيل <a href='account-settings-update.php'>التحقق من التحديثات</a> لاستخدام لوحة التحكم.";
$GLOBALS['strTimezone'] = "المنطقة الزمنية";
$GLOBALS['strEnableAutoMaintenance'] = "إجراء الصيانة تلقائيًا أثناء التوصيل إذا لم تُضبط الصيانة المجدولة";
$GLOBALS['strInvalidLanguage'] = "لغة غير صالحة";

// Database Settings
$GLOBALS['strDatabaseSettings'] = "خيارات قواعد البيانات";
$GLOBALS['strDatabaseServer'] = "الإعدادات العامة لمستضيف قاعدة البيانات";
$GLOBALS['strDbLocal'] = "استخدام الاتصال عبر مقبس محلي (socket)";
$GLOBALS['strDbType'] = "نوع قاعدة البيانات";
$GLOBALS['strDbHost'] = "مستضيف قاعدة البيانات";
$GLOBALS['strDbSocket'] = "مقبس قاعدة البيانات (socket)";
$GLOBALS['strDbPort'] = "رقم المنفذ (بورت) قاعدة البيانات";
$GLOBALS['strDbUser'] = "اسم مستخدم قاعدة البيانات";
$GLOBALS['strDbPassword'] = "كلمة سر قاعدة البيانات";
$GLOBALS['strDbName'] = "اسم قاعدة البيانات";
$GLOBALS['strDbNameHint'] = "ستُنشأ قاعدة البيانات إذا لم تكن موجودة";
$GLOBALS['strDatabaseOptimalisations'] = "إعدادات تحسين أداء قاعدة البيانات";
$GLOBALS['strPersistentConnections'] = "استخدام الاتصال المستمر";
$GLOBALS['strCantConnectToDb'] = "لا يمكن الاتصال بقاعدة البيانات";
$GLOBALS['strCantConnectToDbDelivery'] = 'لا يمكن الاتصال بقاعدة البيانات لعمليات التوصيل';

// Email Settings
$GLOBALS['strEmailSettings'] = "إعدادات البريد الإلكتروني";
$GLOBALS['strEmailAddresses'] = "عنوان المرسل في رسائل البريد الإلكتروني";
$GLOBALS['strEmailFromName'] = "اسم المرسل";
$GLOBALS['strEmailFromAddress'] = "البريد الإلكتروني للمرسل";
$GLOBALS['strEmailFromCompany'] = "شركة المرسل";
$GLOBALS['strUseManagerDetails'] = 'استخدام جهة الاتصال والبريد الإلكتروني والاسم المسجلة في الحساب المالك بدلًا من الاسم وعنوان البريد الإلكتروني والشركة في الحقول أعلاه عند إرسال التقارير بالبريد الإلكتروني إلى حسابات المعلنين أو المواقع.';
$GLOBALS['strQmailPatch'] = "رقعة qmail";
$GLOBALS['strEnableQmailPatch'] = "تفعيل رقعة qmail";
$GLOBALS['strEmailHeader'] = "رؤوس رسائل البريد الإلكتروني";
$GLOBALS['strEmailLog'] = "سجل البريد الإلكتروني";
$GLOBALS['strMailerPlugin'] = "إضافة إرسال البريد المختارة";

// Security settings
$GLOBALS['strSecurityAndDebug'] = "إعدادات الأمان وتصحيح الأخطاء";
$GLOBALS['strSecuritySettings'] = "إعدادات الأمان";
$GLOBALS['strSecurityPasswordMinLength'] = "الحد الأدنى لطول كلمة السر";
$GLOBALS['strSecurityBadLoginPath'] = "ملف سجل محاولات الدخول الفاشلة";
$GLOBALS['strSecurityAllowLinkingExistingUsers'] = "السماح للمديرين بربط مستخدمين موجودين (غير آمن في النسخ المشتركة)";

// Audit Trail Settings
$GLOBALS['strAuditTrailSettings'] = "إعدادات سجل التدقيق";
$GLOBALS['strEnableAudit'] = "تفعيل سجل التدقيق";
$GLOBALS['strEnableAuditForZoneLinking'] = "تفعيل سجل التدقيق لشاشة ربط مناطق العرض (يُبطئ الأداء كثيرًا عند ربط عدد كبير من مناطق العرض)";

// Debug Logging Settings
$GLOBALS['strDebug'] = "إعدادات سجل تصحيح الأخطاء";
$GLOBALS['strEnableDebug'] = "تفعيل سجل تصحيح الأخطاء";
$GLOBALS['strDebugMethodNames'] = "تضمين أسماء الدوال في سجل تصحيح الأخطاء";
$GLOBALS['strDebugLineNumbers'] = "تضمين أرقام الأسطر في سجل تصحيح الأخطاء";
$GLOBALS['strDebugType'] = "نوع سجل تصحيح الأخطاء";
$GLOBALS['strDebugTypeFile'] = "ملف";
$GLOBALS['strDebugTypeMcal'] = "mCal";
$GLOBALS['strDebugTypeSql'] = "قاعدة بيانات SQL";
$GLOBALS['strDebugTypeSyslog'] = "سجل النظام";
$GLOBALS['strDebugName'] = "اسم سجل تصحيح الأخطاء أو التقويم أو جدول SQL<br />أو فئة Syslog (facility)";
$GLOBALS['strDebugPriority'] = "مستوى الأهمية في سجل تصحيح الأخطاء";
$GLOBALS['strPEAR_LOG_DEBUG'] = "PEAR_LOG_DEBUG - Most Information";
$GLOBALS['strPEAR_LOG_INFO'] = "PEAR_LOG_INFO - Default Information";
$GLOBALS['strPEAR_LOG_NOTICE'] = "PEAR_LOG_NOTICE";
$GLOBALS['strPEAR_LOG_WARNING'] = "PEAR_LOG_WARNING";
$GLOBALS['strPEAR_LOG_ERR'] = "PEAR_LOG_ERR";
$GLOBALS['strPEAR_LOG_CRIT'] = "PEAR_LOG_CRIT";
$GLOBALS['strPEAR_LOG_ALERT'] = "PEAR_LOG_ALERT";
$GLOBALS['strPEAR_LOG_EMERG'] = "PEAR_LOG_EMERG - Least Information";
$GLOBALS['strDebugIdent'] = "النص التعريفي لسجل تصحيح الأخطاء";
$GLOBALS['strDebugUsername'] = "اسم مستخدم خادم mCal أو SQL";
$GLOBALS['strDebugPassword'] = "كلمة سر خادم mCal أو SQL";
$GLOBALS['strProductionSystem'] = "بيئة الإنتاج";

// Delivery Settings
$GLOBALS['strWebPath'] = "مسارات الوصول إلى خادم {$PRODUCT_NAME}";
$GLOBALS['strWebPathSimple'] = "مسار الويب";
$GLOBALS['strDeliveryPath'] = "مسار التوصيل";
$GLOBALS['strImagePath'] = "مسار الصور";
$GLOBALS['strDeliverySslPath'] = "مسار التوصيل (SSL)";
$GLOBALS['strImageSslPath'] = "مسار الصور (آمن)";
$GLOBALS['strImageStore'] = "مجلد الصور";
$GLOBALS['strTypeWebSettings'] = "إعدادات تخزين البنرات محليًا على خادم الويب";
$GLOBALS['strTypeWebMode'] = "اسلوب التخزين";
$GLOBALS['strTypeWebModeLocal'] = "المجلد المحلي";
$GLOBALS['strTypeDirError'] = "المجلد المحلي غير قابل للكتابة";
$GLOBALS['strTypeWebModeFtp'] = "مستضيف FTP خارجي";
$GLOBALS['strTypeWebDir'] = "المجلد المحلي";
$GLOBALS['strTypeFTPHost'] = "مستضيف FTP";
$GLOBALS['strTypeFTPDirectory'] = "مجلد المستضيف";
$GLOBALS['strTypeFTPUsername'] = "اسم المستخدم";
$GLOBALS['strTypeFTPPassword'] = "كلمة السر";
$GLOBALS['strTypeFTPPassive'] = "استخدام اسلوب passive FTP";
$GLOBALS['strTypeFTPErrorDir'] = "مجلد المستضيف غير موجود";
$GLOBALS['strTypeFTPErrorConnect'] = "لا يمكن الاتصال بمستضيف FTP ، الرجاء التحقق من اسم المستخدم او كلمة السر.";
$GLOBALS['strTypeFTPErrorNoSupport'] = "لا تدعم نسخة PHP المثبتة لديك بروتوكول FTP.";
$GLOBALS['strTypeFTPErrorUpload'] = "تعذّر رفع الملف إلى خادم FTP. تحقق من ضبط الصلاحيات المناسبة لمجلد المستضيف.";
$GLOBALS['strTypeFTPErrorHost'] = "عنوان مستضيف FTP غير صحيح";
$GLOBALS['strDeliveryFilenames'] = "أسماء ملفات التوصيل";
$GLOBALS['strDeliveryFilenamesAdClick'] = "رابط الضغط على الإعلان";
$GLOBALS['strDeliveryFilenamesSignedAdClick'] = "ضغطة إعلان موقّعة";
$GLOBALS['strDeliveryFilenamesAdConversionVars'] = "متغيرات تحويل الإعلان";
$GLOBALS['strDeliveryFilenamesAdContent'] = "محتوى الإعلان";
$GLOBALS['strDeliveryFilenamesAdConversion'] = "تحويل الإعلان";
$GLOBALS['strDeliveryFilenamesAdConversionJS'] = "تحويل الإعلان (JavaScript)";
$GLOBALS['strDeliveryFilenamesAdFrame'] = "إطار الإعلان";
$GLOBALS['strDeliveryFilenamesAdImage'] = "صورة الاعلان";
$GLOBALS['strDeliveryFilenamesAdJS'] = "الإعلان (JavaScript)";
$GLOBALS['strDeliveryFilenamesAdLayer'] = "طبقة الإعلان";
$GLOBALS['strDeliveryFilenamesAdLog'] = "سجل الإعلان";
$GLOBALS['strDeliveryFilenamesAdPopup'] = "النافذة المنبثقة للإعلان";
$GLOBALS['strDeliveryFilenamesAdView'] = "عرض الإعلان";
$GLOBALS['strDeliveryFilenamesXMLRPC'] = "التركيب عبر XML RPC";
$GLOBALS['strDeliveryFilenamesLocal'] = "التركيب المحلي";
$GLOBALS['strDeliveryFilenamesFrontController'] = "المتحكم الأمامي (Front Controller)";
$GLOBALS['strDeliveryFilenamesSinglePageCall'] = "الاستدعاء الموحد للصفحة (Single Page Call)";
$GLOBALS['strDeliveryFilenamesSinglePageCallJS'] = "الاستدعاء الموحد للصفحة (JavaScript)";
$GLOBALS['strDeliveryFilenamesAsyncJS'] = "JavaScript غير المتزامن (الملف المصدري)";
$GLOBALS['strDeliveryFilenamesAsyncPHP'] = "JavaScript غير المتزامن";
$GLOBALS['strDeliveryFilenamesAsyncSPC'] = "الاستدعاء الموحد للصفحة عبر JavaScript غير المتزامن";
$GLOBALS['strDeliveryCaching'] = "إعدادات كاش توصيل البنرات";
$GLOBALS['strDeliveryCacheLimit'] = "المدة بين تحديثات كاش البنرات (بالثواني)";
$GLOBALS['strDeliveryCacheStore'] = "نوع تخزين كاش توصيل البنرات";
$GLOBALS['strDeliveryAcls'] = "التحقق من قواعد توصيل البنرات أثناء التوصيل";
$GLOBALS['strDeliveryAclsDirectSelection'] = "التحقق من قواعد توصيل البنرات للإعلانات المختارة مباشرة";
$GLOBALS['strDeliveryObfuscate'] = "تعمية مجموعة قواعد التوصيل عند توصيل الإعلانات";
$GLOBALS['strDeliveryPreconnect'] = "مطالبة المتصفحات بالاتصال المسبق بعنوان URL للصور (إن اختلف عن عنوان URL للتوصيل، وهي ميزة تعمل مع HTTPS فقط)";
$GLOBALS['strDeliveryClickUrlValidity'] = "مدة صلاحية إعادة التوجيه إلى عنوان URL مخصص للوجهة عبر ماكرو {clickurl} (بالثواني). أدخل 0 لمنع إعادة التوجيه";
$GLOBALS['strDeliveryLogUrlValidity'] = "مدة صلاحية عناوين URL الموقّعة لتسجيل مرات الظهور (بالثواني). أدخل 0 لتعطيل انتهاء الصلاحية";
$GLOBALS['strDeliveryRelAttribute'] = "قيمة الخاصية rel الافتراضية لوسوم &lt;a href&gt; في HTML";
$GLOBALS['strGlobalDefaultBannerInvalidZone'] = "بنر HTML الافتراضي العام لمناطق العرض غير الموجودة";
$GLOBALS['strGlobalDefaultBannerSuspendedAccount'] = "بنر HTML الافتراضي العام للحسابات الموقوفة";
$GLOBALS['strGlobalDefaultBannerInactiveAccount'] = "بنر HTML الافتراضي العام للحسابات غير النشطة";
$GLOBALS['strPrivacySettings'] = "إعدادات الخصوصية";
$GLOBALS['strDisableViewerId'] = "تعطيل كوكيز المعرّف الفريد للزائر";
$GLOBALS['strAnonymiseIp'] = "إخفاء هوية عناوين IP للزوار";
$GLOBALS['strDisableDeliveryCookies'] = 'تعطيل كوكيز التوصيل';
$GLOBALS['strBannerFileSettings'] = 'الإعدادات العامة لملفات البنرات';
$GLOBALS['strMaxBannerFilesize'] = 'الحد الأقصى لحجم ملف البنر (بالبايت، والقيمة 0 تعني بلا حد)';

// General Settings
$GLOBALS['generalSettings'] = "الإعدادات العامة للنظام";
$GLOBALS['uiEnabled'] = "تفعيل واجهة المستخدم";
$GLOBALS['defaultLanguage'] = "لغة النظام الافتراضية<br />(يمكن لكل مستخدم اختيار لغته)";

// Geotargeting Settings
$GLOBALS['strGeotargetingSettings'] = "إعدادات الاستهداف الجغرافي";
$GLOBALS['strGeotargeting'] = "إعدادات الاستهداف الجغرافي";
$GLOBALS['strGeotargetingType'] = "نوع وحدة الاستهداف الجغرافي";
$GLOBALS['strGeoShowUnavailable'] = "عرض قواعد التوصيل للاستهداف الجغرافي حتى إن لم تتوفر بيانات GeoIP";

// Interface Settings
$GLOBALS['strInventory'] = "المخزون";
$GLOBALS['strShowCampaignInfo'] = "عرض معلومات إضافية عن الحملة في صفحة <i>الحملات</i>";
$GLOBALS['strShowBannerInfo'] = "عرض معلومات إضافية عن البنر في صفحة <i>البنرات</i>";
$GLOBALS['strShowCampaignPreview'] = "عرض معاينة لجميع البنرات في صفحة <i>البنرات</i>";
$GLOBALS['strShowBannerHTML'] = "عرض البنر الفعلي بدلًا من كود HTML العادي عند معاينة بنرات HTML";
$GLOBALS['strShowBannerPreview'] = "عرض معاينة البنر أعلى الصفحات المتعلقة بالبنرات";
$GLOBALS['strUseWyswygHtmlEditorByDefault'] = "استخدام محرر HTML المرئي (WYSIWYG) افتراضيًا عند إنشاء بنرات HTML أو تعديلها";
$GLOBALS['strHideInactive'] = "إخفاء الغير فعّال";
$GLOBALS['strGUIShowMatchingBanners'] = "عرض البنرات المطابقة في صفحات <i>البنرات المرتبطة</i>";
$GLOBALS['strGUIShowParentCampaigns'] = "عرض الحملات الأم في صفحات <i>البنرات المرتبطة</i>";
$GLOBALS['strShowEntityId'] = "عرض معرّفات العناصر";
$GLOBALS['strStatisticsDefaults'] = "الإحصائيات";
$GLOBALS['strBeginOfWeek'] = "بداية الأسبوع";
$GLOBALS['strPercentageDecimals'] = "عدد المنازل العشرية للنسب المئوية";
$GLOBALS['strWeightDefaults'] = "الوزن الافتراضي";
$GLOBALS['strDefaultBannerWeight'] = "الوزن الافتراضي للبنر";
$GLOBALS['strDefaultCampaignWeight'] = "الوزن الافتراضي للحملة الاعلانية";
$GLOBALS['strConfirmationUI'] = "التأكيد في واجهة المستخدم";

// Invocation Settings
$GLOBALS['strInvocationDefaults'] = "الإعدادات الافتراضية لكود التركيب";
$GLOBALS['strEnable3rdPartyTrackingByDefault'] = "تفعيل تتبع الضغطات عبر جهات خارجية افتراضيًا";

// Banner Delivery Settings
$GLOBALS['strBannerDelivery'] = "إعدادات توصيل البنرات";

// Banner Logging Settings
$GLOBALS['strBannerLogging'] = "إعدادات تسجيل البنرات";
$GLOBALS['strLogAdRequests'] = "تسجيل وقت طلب البنر كل مرة يتم طلبه";
$GLOBALS['strLogAdImpressions'] = "زيادة مرات الظهور في كل مرة يتم عرض البنر";
$GLOBALS['strLogAdClicks'] = "زيادة مرات الضغطات في كل مرة يتم ضغط البنر";
$GLOBALS['strReverseLookup'] = "البحث العكسي عن أسماء المضيفين للزوار إن لم تكن متوفرة";
$GLOBALS['strProxyLookup'] = "محاولة تحديد عنوان IP الحقيقي للزوار الذين يتصلون عبر خادم وكيل (proxy)";
$GLOBALS['strPreventLogging'] = "خيارات حجب تسجيل البنرات";
$GLOBALS['strIgnoreHosts'] = "عدم تسجيل أي إحصائيات للزوار الذين يستخدمون أيًّا من عناوين IP أو أسماء المضيفين التالية";
$GLOBALS['strIgnoreUserAgents'] = "<b>عدم</b> تسجيل الإحصائيات للعملاء الذين يحتوي user-agent لديهم على أيٍّ من النصوص التالية (نص واحد في كل سطر)";
$GLOBALS['strEnforceUserAgents'] = "تسجيل الإحصائيات <b>فقط</b> للعملاء الذين يحتوي user-agent لديهم على أيٍّ من النصوص التالية (نص واحد في كل سطر)";

// Banner Storage Settings
$GLOBALS['strBannerStorage'] = "إعدادات تخزين البنرات";

// Campaign ECPM settings
$GLOBALS['strEnableECPM'] = "استخدام مستويات أهمية محسّنة وفق eCPM بدلًا من مستويات الأهمية الموزونة للحملات الاحتياطية";
$GLOBALS['strEnableContractECPM'] = "استخدام مستويات أهمية محسّنة وفق eCPM بدلًا من مستويات الأهمية القياسية للحملات التعاقدية";
$GLOBALS['strEnableECPMfromRemnant'] = "(إذا فعّلت هذه الميزة، فستُعطَّل جميع حملاتك الاحتياطية، وعليك تحديثها يدويًا لإعادة تفعيلها)";
$GLOBALS['strEnableECPMfromECPM'] = "(إذا عطّلت هذه الميزة، فستُعطَّل بعض حملات eCPM النشطة لديك، وعليك تحديثها يدويًا لإعادة تفعيلها)";
$GLOBALS['strInactivatedCampaigns'] = "قائمة الحملات التي أصبحت غير نشطة بسبب تغيير الخيارات:";

// Statistics & Maintenance Settings
$GLOBALS['strMaintenanceSettings'] = "إعدادات الصيانة";
$GLOBALS['strConversionTracking'] = "إعدادات تتبع التحويلات";
$GLOBALS['strEnableConversionTracking'] = "تفعيل تتبع التحويلات";
$GLOBALS['strBlockInactiveBanners'] = "عدم احتساب مرات الظهور أو الضغطات، وعدم توجيه المستخدم إلى عنوان URL الوجهة، إذا ضغط الزائر على بنر غير نشط";
$GLOBALS['strBlockAdClicks'] = "عدم احتساب الضغطات على الإعلان إذا ضغط الزائر على الإعلان نفسه في منطقة العرض نفسها خلال المدة المحددة (بالثواني)";
$GLOBALS['strMaintenanceOI'] = "توقيت عمليات الصيانة (كل × دقيقة)";
$GLOBALS['strPrioritySettings'] = "إعدادات الأهمية";
$GLOBALS['strPriorityInstantUpdate'] = "تحديث مستويات أهمية الإعلانات فورًا عند إجراء تغييرات في واجهة المستخدم";
$GLOBALS['strPriorityIntentionalOverdelivery'] = "التوصيل الزائد المتعمّد للحملات التعاقدية<br />(نسبة التوصيل الزائد %)";
$GLOBALS['strDefaultImpConvWindow'] = "نافذة التحويل الافتراضية بعد ظهور الإعلان (بالثواني)";
$GLOBALS['strDefaultCliConvWindow'] = "نافذة التحويل الافتراضية بعد الضغط على الإعلان (بالثواني)";
$GLOBALS['strAdminEmailHeaders'] = "إضافة الرؤوس التالية إلى كل رسالة بريد إلكتروني يرسلها {$PRODUCT_NAME}";
$GLOBALS['strWarnLimit'] = "ارسل تحذيراً عندما يكون عدد مرات الظهور أقل من الرقم المكتوب هنا";
$GLOBALS['strWarnLimitDays'] = "إرسال تحذير عندما يقل عدد الأيام المتبقية عن العدد المحدد هنا";
$GLOBALS['strWarnAdmin'] = "إرسال تحذير إلى مدير النظام كلما أوشكت حملة على الانتهاء";
$GLOBALS['strWarnClient'] = "إرسال تحذير إلى المعلن كلما أوشكت حملة على الانتهاء";
$GLOBALS['strWarnAgency'] = "إرسال تحذير إلى الحساب كلما أوشكت حملة على الانتهاء";

// UI Settings
$GLOBALS['strGuiSettings'] = "إعدادات واجهة المستخدم";
$GLOBALS['strGeneralSettings'] = "الإعدادات العامة";
$GLOBALS['strAppName'] = "اسم التطبيق";
$GLOBALS['strMyHeader'] = "مسار ملف رأس الصفحة";
$GLOBALS['strMyFooter'] = "مسار ملف تذييل الصفحة";
$GLOBALS['strDefaultTrackerStatus'] = "الحالة الافتراضية للمتتبع";
$GLOBALS['strDefaultTrackerType'] = "النوع الافتراضي للمتتبع";
$GLOBALS['strSSLSettings'] = "إعدادات SSL";
$GLOBALS['requireSSL'] = "فرض الوصول عبر SSL إلى واجهة المستخدم";
$GLOBALS['sslPort'] = "منفذ SSL الذي يستخدمه خادم الويب";
$GLOBALS['strDashboardSettings'] = "إعدادات لوحة التحكم";
$GLOBALS['strMyLogo'] = "اسم الشعار المخصص";
$GLOBALS['strGuiHeaderForegroundColor'] = "لون المقدمة في رأس الصفحة";
$GLOBALS['strGuiHeaderBackgroundColor'] = "لون الخلفية في رأس الصفحة";
$GLOBALS['strGuiActiveTabColor'] = "لون علامة التبويب النشطة";
$GLOBALS['strGuiHeaderTextColor'] = "لون النص في رأس الصفحة";
$GLOBALS['strGuiSupportLink'] = "عنوان URL مخصص لرابط «الدعم» في رأس الصفحة";
$GLOBALS['strAdminCookieDomain'] = "نطاق مخصص للكوكيز في واجهة المستخدم";
$GLOBALS['strGuiLoaderDelay'] = "عرض رسوم متحركة للتحميل عندما يستغرق تحميل الشاشة التالية أكثر من X مللي ثانية (أدخل ‎-1 للتعطيل)";
$GLOBALS['strGzipContentCompression'] = "استخدام ضغط المحتوى بتقنية GZIP";

// Regenerate Platfor Hash script
$GLOBALS['strPlatformHashRegenerate'] = "إعادة توليد بصمة المنصة";
$GLOBALS['strNewPlatformHash'] = "بصمة المنصة الجديدة:";
$GLOBALS['strPlatformHashInsertingError'] = "حدث خطأ أثناء إدراج بصمة المنصة في قاعدة البيانات";

// Plugin Settings
$GLOBALS['strPluginSettings'] = "إعدادات الإضافات";
$GLOBALS['strEnableNewPlugins'] = "تفعيل الإضافات المثبّتة حديثًا";
$GLOBALS['strUseMergedFunctions'] = "استخدام ملف دوال التوصيل المدمجة";
