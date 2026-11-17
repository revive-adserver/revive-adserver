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

// Set text direction and characterset
$GLOBALS['phpAds_TextDirection'] = "rtl";
$GLOBALS['phpAds_TextAlignRight'] = "left";
$GLOBALS['phpAds_TextAlignLeft'] = "right";

$GLOBALS['phpAds_DecimalPoint'] = ".";

// Date & time configuration

// Formats used by PEAR Spreadsheet_Excel_Writer packate

/* ------------------------------------------------------- */
/* Translations                                          */
/* ------------------------------------------------------- */

$GLOBALS['strHome'] = "الصفحة الرّئيسية";
$GLOBALS['strHelp'] = "مساعدة";
$GLOBALS['strStartOver'] = "البدء من جديد";
$GLOBALS['strShortcuts'] = "الاختصارات";
$GLOBALS['strActions'] = "الفعل";
$GLOBALS['strAndXMore'] = "و%s أخرى";
$GLOBALS['strAdminstration'] = "المخزن";
$GLOBALS['strMaintenance'] = "الصيانة";
$GLOBALS['strProbability'] = "الإحتماليات";
$GLOBALS['strInvocationcode'] = "كود التركيب";
$GLOBALS['strBasicInformation'] = "معلومات أساسية";
$GLOBALS['strAppendTrackerCode'] = "إلحاق كود المتتبع";
$GLOBALS['strOverview'] = "نظرة عامة";
$GLOBALS['strSearch'] = "البحث";
$GLOBALS['strDetails'] = "التفاصيل";
$GLOBALS['strUpdateSettings'] = "تحديث الإعدادات";
$GLOBALS['strCheckForUpdates'] = "فحص التحديثات";
$GLOBALS['strWhenCheckingForUpdates'] = "التحقق من التحديثات";
$GLOBALS['strCompact'] = "مدمج";
$GLOBALS['strUser'] = "مستخدم";
$GLOBALS['strDuplicate'] = "نسخ";
$GLOBALS['strCopyOf'] = "نسخ من";
$GLOBALS['strMoveTo'] = "نقل إلى";
$GLOBALS['strDelete'] = "حذف";
$GLOBALS['strActivate'] = "تفعيل";
$GLOBALS['strConvert'] = "تحويل";
$GLOBALS['strRefresh'] = "تحديث";
$GLOBALS['strSaveChanges'] = "حفظ التعديلات";
$GLOBALS['strUp'] = "فوق";
$GLOBALS['strDown'] = "تحت";
$GLOBALS['strSave'] = "حفظ";
$GLOBALS['strCancel'] = "إلغاء";
$GLOBALS['strBack'] = "رجوع للخلف";
$GLOBALS['strPrevious'] = "السابق";
$GLOBALS['strNext'] = "التالي";
$GLOBALS['strYes'] = "نعم";
$GLOBALS['strNo'] = "لا";
$GLOBALS['strNone'] = "المنطقة";
$GLOBALS['strCustom'] = "مخصص";
$GLOBALS['strDefault'] = "افتراضي";
$GLOBALS['strUnknown'] = "مجهول";
$GLOBALS['strUnlimited'] = "غير محدود";
$GLOBALS['strUntitled'] = "بدون عنوان";
$GLOBALS['strAll'] = "الكل";
$GLOBALS['strAverage'] = "المتوسط";
$GLOBALS['strOverall'] = "بشكل عام";
$GLOBALS['strTotal'] = "المجموع";
$GLOBALS['strFrom'] = "من";
$GLOBALS['strTo'] = "إلى";
$GLOBALS['strAdd'] = "اضافة";
$GLOBALS['strLinkedTo'] = "رابط إلى";
$GLOBALS['strDaysLeft'] = "أيام باقية";
$GLOBALS['strCheckAllNone'] = "تحديد الكل/ إزالة التحديد";
$GLOBALS['strKiloByte'] = "كيلو بايت";
$GLOBALS['strExpandAll'] = "<u>فـ</u>ـتح الكل";
$GLOBALS['strCollapseAll'] = "<u>غـ</u>ـلق الكل";
$GLOBALS['strShowAll'] = "عرض الكل";
$GLOBALS['strNoAdminInterface'] = "تم إيقاف لوحة تحكم المدراء بسبب الصيانة. هذا الإيقاف لن يؤثر على عملية عرض الإعلانات في حملتك الإعلانية.";
$GLOBALS['strFieldStartDateBeforeEnd'] = "يجب أن يكون تاريخ «من» قبل تاريخ «إلى»";
$GLOBALS['strFieldContainsErrors'] = "الحقول التالية تحتوي على أخطاء:";
$GLOBALS['strFieldFixBeforeContinue1'] = "قبل الاستمرار يجب أن";
$GLOBALS['strFieldFixBeforeContinue2'] = "لتصليح هذه الأخطاء";
$GLOBALS['strMiscellaneous'] = "خيارات متنوعة";
$GLOBALS['strCollectedAllStats'] = "كل الاحصائيات";
$GLOBALS['strCollectedToday'] = "اليوم";
$GLOBALS['strCollectedYesterday'] = "أمس";
$GLOBALS['strCollectedThisWeek'] = "هذا الاسبوع";
$GLOBALS['strCollectedLastWeek'] = "الاسبوع الماضي";
$GLOBALS['strCollectedThisMonth'] = "هذا الشهر";
$GLOBALS['strCollectedLastMonth'] = "الشهر الماضي";
$GLOBALS['strCollectedLast7Days'] = "آخر 7 أيام";
$GLOBALS['strCollectedSpecificDates'] = "تواريخ محددة";
$GLOBALS['strValue'] = "القيمة";
$GLOBALS['strWarning'] = "تحذير";
$GLOBALS['strNotice'] = "تنبيه";

// Dashboard
$GLOBALS['strDashboardCantBeDisplayed'] = "لا يمكن عرض لوحة المعلومات";
$GLOBALS['strNoCheckForUpdates'] = "لا يمكن عرض لوحة المعلومات ما لم يكن التحق من خلال <br/> عن التحديثات ممكن.";
$GLOBALS['strEnableCheckForUpdates'] = "يرجى تفعيل خيار <a href='account-settings-update.php' target='_top'>التحقق من التحديثات</a> في صفحة<br/><a href='account-settings-update.php' target='_top'>إعدادات التحديثات</a>.";
// Dashboard Errors
$GLOBALS['strDashboardErrorCode'] = "الرمز";
$GLOBALS['strDashboardSystemMessage'] = "رسالة من النظام";
$GLOBALS['strDashboardErrorHelp'] = "إذا تكرر هذا الخطأ الرجاء وصف المشكلة بالتفصيل على <a href='http://forum.revive-adserver.com/'> forum.revive-adserver.com/</a>.";

// Priority
$GLOBALS['strPriority'] = "الأهمية";
$GLOBALS['strPriorityLevel'] = "مستوى الأهمية";
$GLOBALS['strOverrideAds'] = "تجاوز إعلانات الحملة";
$GLOBALS['strHighAds'] = "إعلانات الحملات التعاقدية";
$GLOBALS['strECPMAds'] = "إعلانات حملات eCPM";
$GLOBALS['strLowAds'] = "إعلانات الحملات الاحتياطية";
$GLOBALS['strLimitations'] = "قواعد التوصيل";
$GLOBALS['strNoLimitations'] = "لا توجد قواعد توصيل";
$GLOBALS['strCapping'] = "تغطية";

// Properties
$GLOBALS['strName'] = "الإسم";
$GLOBALS['strSize'] = "الحجم";
$GLOBALS['strWidth'] = "العرض";
$GLOBALS['strHeight'] = "الارتفاع";
$GLOBALS['strTarget'] = "الوجهة";
$GLOBALS['strLanguage'] = "اللغة";
$GLOBALS['strDescription'] = "الوصف";
$GLOBALS['strVariables'] = "المتغيرات";
$GLOBALS['strID'] = "الرقم";
$GLOBALS['strComments'] = "التعليقات";

// User access
$GLOBALS['strWorkingAs'] = "العمل بحساب";
$GLOBALS['strWorkingAs_Key'] = "العمل بحساب";
$GLOBALS['strWorkingAs'] = "العمل بحساب";
$GLOBALS['strSwitchTo'] = "قم بالتبديل إلى";
$GLOBALS['strUseSearchBoxToFindMoreAccounts'] = "استخدم مربع البحث في قائمة تبديل الحسابات للعثور على حسابات أخرى";
$GLOBALS['strWorkingFor'] = "بصفة %s لدى...";
$GLOBALS['strNoAccountWithXInNameFound'] = "لا توجد حسابات يحتوي اسمها على «%s»";
$GLOBALS['strRecentlyUsed'] = "المستخدمة مؤخرا";
$GLOBALS['strLinkUser'] = "إضافة مستخدم";
$GLOBALS['strLinkUser_Key'] = "إضافة مستخدم";
$GLOBALS['strUsernameToLink'] = "اسم المستخدم للاضافة";
$GLOBALS['strNewUserWillBeCreated'] = "سيتم خلق مستخدم جديد";
$GLOBALS['strToLinkProvideEmail'] = "لإضافة مستخدم، زود البريد الإلكتروني للمستخدم";
$GLOBALS['strToLinkProvideUsername'] = "لإضافة مستخدم، توفير اسم المستخدم";
$GLOBALS['strUserLinkedToAccount'] = "أضيف المستخدم إلى الحساب";
$GLOBALS['strUserLinkedAndWelcomeSent'] = "أضيف المستخدم إلى الحساب، وستصله رسالة بريد إلكتروني لتعيين كلمة السر.";
$GLOBALS['strUserAccountUpdated'] = "تم تحديث حساب المستخدم";
$GLOBALS['strUserUnlinkedFromAccount'] = "أزيل المستخدم من الحساب";
$GLOBALS['strUserWasDeleted'] = "تم حذف المستخدم";
$GLOBALS['strUserNotLinkedWithAccount'] = "هذا المستخدم غير مرتبط بحساب";
$GLOBALS['strCantDeleteOneAdminUser'] = "لا يمكنك حذف هذا المستخدم، إذ يجب أن يبقى مستخدم واحد على الأقل مرتبطًا بحساب مدير النظام.";
$GLOBALS['strLinkUserHelp'] = "لإضافة <b>مستخدم موجود</b>، اكتب %1\$s ثم اضغط %2\$s <br />ولإضافة <b>مستخدم جديد</b>، اكتب %1\$s الذي تريده ثم اضغط %2\$s";
$GLOBALS['strLinkUserHelpUser'] = "اسم المستخدم";
$GLOBALS['strLinkUserHelpEmail'] = "البريد الإلكتروني";
$GLOBALS['strLastLoggedIn'] = "آخر تسجيل دخول";
$GLOBALS['strDateLinked'] = "تاريخ الربط";

// Login & Permissions
$GLOBALS['strUserAccess'] = "صلاحيات مستخدم";
$GLOBALS['strAdminAccess'] = "صلاحيات مسؤول";
$GLOBALS['strUserProperties'] = "خواص البنر";
$GLOBALS['strPermissions'] = "الصلاحيّات";
$GLOBALS['strAuthentification'] = "التحقق";
$GLOBALS['strWelcomeTo'] = "مرحباً بك في";
$GLOBALS['strEnterUsername'] = "الرجاء كتابة اسم المستخدم و كلمة السر للدخول";
$GLOBALS['strEnterBoth'] = "الرجاء كتابة اسم المستخدم و كلمة السر";
$GLOBALS['strEnableCookies'] = "يجب عليك تفعيل الكوكيز قبل أن تستخدم {$PRODUCT_NAME}";
$GLOBALS['strSessionIDNotMatch'] = "هنالك مشكلة في الكوكيز، الرجاء الدخول من جديد";
$GLOBALS['strLogin'] = "اسم الدخول";
$GLOBALS['strLogout'] = "تسجيل الخروج";
$GLOBALS['strUsername'] = "اسم المستخدم";
$GLOBALS['strPassword'] = "كلمة السر";
$GLOBALS['strPasswordRepeat'] = "قم بإعادة كتابة كلمة السر";
$GLOBALS['strAccessDenied'] = "الدخول ممنوع";
$GLOBALS['strUsernameOrPasswordWrong'] = "قمت بإدخال بيانات خاطئة في اسم المستخدم أو كلمة السر. الرجاء المحاولة مرة أخرى.";
$GLOBALS['strPasswordWrong'] = "كلمة السر غير صحيحة";
$GLOBALS['strNotAdmin'] = "ليست لديك الصلاحيات اللازمة لاستخدام هذه الميزة، ويمكنك تسجيل الدخول باسم مستخدم آخر لاستخدامها.";
$GLOBALS['strDuplicateClientName'] = "اسم المستخدم الذي أدخلته موجود مسبقاً ، الرجاء اختيار اسم آخر.";
$GLOBALS['strInvalidPassword'] = "كلمة السر الجديدة غير صالحة ، الرجاء اختيار كلمة سر أخرى.";
$GLOBALS['strInvalidEmail'] = "صيغة البريد الإلكتروني غير صحيحة، يرجى إدخال عنوان بريد إلكتروني بصيغة صحيحة.";
$GLOBALS['strNotSamePasswords'] = "كلمتا السر التي قمت بإدخالهما غير متطابقتين";
$GLOBALS['strRepeatPassword'] = "قم بإعادة كتابة كلمة السر";
$GLOBALS['strDeadLink'] = "الرابط الخاص بك غير صالح.";
$GLOBALS['strNoPlacement'] = "الحملة المحددة غير موجودة. جرّب <a href='{link}'>هذا الرابط</a> بدلًا منها";
$GLOBALS['strNoAdvertiser'] = "المعلن المحدد غير موجود. جرّب <a href='{link}'>هذا الرابط</a> بدلًا منه";

// General advertising
$GLOBALS['strRequests'] = "الطلبات";
$GLOBALS['strImpressions'] = "مرات الظهور";
$GLOBALS['strClicks'] = "الضغطات";
$GLOBALS['strConversions'] = "التحويل";
$GLOBALS['strCTRShort'] = "معدل الضغطات";
$GLOBALS['strCNVRShort'] = "معدل التحويل";
$GLOBALS['strCTR'] = "معدل الضغطات";
$GLOBALS['strTotalClicks'] = "مجموع الضغطات";
$GLOBALS['strTotalConversions'] = "مجموع التحويلات";
$GLOBALS['strDateTime'] = "التاريخ الوقت";
$GLOBALS['strTrackerID'] = "رقم المتتبع";
$GLOBALS['strTrackerName'] = "اسم المتتبع";
$GLOBALS['strTrackerImageTag'] = "كود الصورة";
$GLOBALS['strTrackerJsTag'] = "كود Javascript";
$GLOBALS['strTrackerAlwaysAppend'] = "عرض الكود الملحق دائمًا حتى لو لم يسجل المتتبع أي تحويل؟";
$GLOBALS['strBanners'] = "بنرات";
$GLOBALS['strCampaigns'] = "الحملة الإعلانية";
$GLOBALS['strCampaignID'] = "رقم الحملة الاعلانية";
$GLOBALS['strCampaignName'] = "اسم الحملة الاعلانية";
$GLOBALS['strCountry'] = "الدولة";
$GLOBALS['strStatsAction'] = "الفعل";
$GLOBALS['strWindowDelay'] = "تأخير الشاشة";
$GLOBALS['strStatsVariables'] = "المتغيرات";

// Finance
$GLOBALS['strFinanceCPM'] = "تكلفة الظهور";
$GLOBALS['strFinanceCPC'] = "تكلفة الضغطات";
$GLOBALS['strFinanceCPA'] = "تكلفة العمليات";
$GLOBALS['strFinanceMT'] = "الإيجار الشهري";
$GLOBALS['strFinanceCTR'] = "معدل الضغطات";
$GLOBALS['strFinanceCR'] = "معدل التحويل";

// Time and date related
$GLOBALS['strDate'] = "التاريخ";
$GLOBALS['strDay'] = "يوم";
$GLOBALS['strDays'] = "أيام";
$GLOBALS['strWeek'] = "اسبوع";
$GLOBALS['strWeeks'] = "أسابيع";
$GLOBALS['strSingleMonth'] = "شهر";
$GLOBALS['strMonths'] = "أشهر";
$GLOBALS['strDayOfWeek'] = "اليوم من الأسبوع";


if (!isset($GLOBALS['strDayFullNames'])) {
    $GLOBALS['strDayFullNames'] = [];
}
$GLOBALS['strDayFullNames'][0] = 'الأحد';
$GLOBALS['strDayFullNames'][1] = 'الإثنين';
$GLOBALS['strDayFullNames'][2] = 'الثلاثاء';
$GLOBALS['strDayFullNames'][3] = 'الأربعاء';
$GLOBALS['strDayFullNames'][4] = 'الخميس';
$GLOBALS['strDayFullNames'][5] = 'الجمعة';
$GLOBALS['strDayFullNames'][6] = 'السبت';

if (!isset($GLOBALS['strDayShortCuts'])) {
    $GLOBALS['strDayShortCuts'] = [];
}
$GLOBALS['strDayShortCuts'][0] = 'أح';
$GLOBALS['strDayShortCuts'][1] = 'إث';
$GLOBALS['strDayShortCuts'][2] = 'ث';
$GLOBALS['strDayShortCuts'][3] = 'أر';
$GLOBALS['strDayShortCuts'][4] = 'خ';
$GLOBALS['strDayShortCuts'][5] = 'ج';
$GLOBALS['strDayShortCuts'][6] = 'س';

$GLOBALS['strHour'] = "الساعة";
$GLOBALS['strSeconds'] = "الثواني";
$GLOBALS['strMinutes'] = "الدقائق";
$GLOBALS['strHours'] = "الساعات";

// Advertiser
$GLOBALS['strClient'] = "المعلن";
$GLOBALS['strClients'] = "المعلنين";
$GLOBALS['strClientsAndCampaigns'] = "المعلنين و الحملات الاعلانية";
$GLOBALS['strAddClient'] = "إضافة معلن جديد";
$GLOBALS['strClientProperties'] = "خواص المعلن";
$GLOBALS['strClientHistory'] = "إحصائيات المعلن";
$GLOBALS['strNoClients'] = "لا يوجد معلنين حتى الآن. لإضافة حملة إعلانية، يجب <a href='advertiser-edit.php'>إضافة معلن</a> قبل ذلك.";
$GLOBALS['strConfirmDeleteClient'] = "هل أنت متأكد من رغبتك في حذف هذا المعلن ؟";
$GLOBALS['strConfirmDeleteClients'] = "هل أنت متأكد من رغبتك في حذف هذا المعلن ؟";
$GLOBALS['strHideInactive'] = "إخفاء الغير فعّال";
$GLOBALS['strInactiveAdvertisersHidden'] = "المعلنين غير النشطين تم إخفائهم";
$GLOBALS['strAdvertiserSignup'] = "تسجيل المعلنين";
$GLOBALS['strAdvertiserCampaigns'] = "المعلنين و الحملات الاعلانية";

// Advertisers properties
$GLOBALS['strContact'] = "الاتصال";
$GLOBALS['strContactName'] = "اسم جهة الإتصال";
$GLOBALS['strEMail'] = "البريد الالكتروني";
$GLOBALS['strSendAdvertisingReport'] = "إرسال تفاصيل الحملة الاعلانية بالبريد الالكتروني";
$GLOBALS['strNoDaysBetweenReports'] = "عدد الأيام بين تقارير عرض الحملات";
$GLOBALS['strSendDeactivationWarning'] = "إرسال بريد إلكتروني عندما يتم إيقاف أو تفعيل الحملة بشكل تلقائي";
$GLOBALS['strAllowClientModifyBanner'] = "السماح لهذا العضو بتعديل الإعلانات الخاصة به";
$GLOBALS['strAllowClientDisableBanner'] = "السماح لهذا العضو بتعطيل الإعلانات الخاصة به";
$GLOBALS['strAllowClientActivateBanner'] = "السماح لهذا العضو بتفعيل الإعلانات الخاصة به";
$GLOBALS['strAllowCreateAccounts'] = "السماح لهذا المستخدم بإدارة مستخدمي هذا الحساب";
$GLOBALS['strAdvertiserLimitation'] = "عرض بنر واحد فقط من هذا المعلن في صفحة الويب الواحدة";
$GLOBALS['strAllowAuditTrailAccess'] = "السماح لهذا المستخدم الوصول إلى سجل المراجعة";
$GLOBALS['strAllowDeleteItems'] = "السماح لهذا المستخدم بحذف العناصر";

// Campaign
$GLOBALS['strCampaign'] = "الحملة الإعلانية";
$GLOBALS['strCampaigns'] = "الحملة الإعلانية";
$GLOBALS['strAddCampaign'] = "إضافة حملة إعلانية";
$GLOBALS['strAddCampaign_Key'] = "إضافة حملة إعلانية";
$GLOBALS['strCampaignForAdvertiser'] = "للمعلن";
$GLOBALS['strLinkedCampaigns'] = "الحملات الاعلانية المرتبطة";
$GLOBALS['strCampaignProperties'] = "خواص الحملة الإعلانية";
$GLOBALS['strCampaignOverview'] = "نظرة عامة على الحملة الإعلانية";
$GLOBALS['strCampaignHistory'] = "إحصائيات الحملة";
$GLOBALS['strNoCampaigns'] = "لا يوجد حاليا حملات لهذا المعلن.";
$GLOBALS['strNoCampaignsAddAdvertiser'] = "لا توجد حاليًا حملات إعلانية لأنه لا يوجد معلنون. لإنشاء حملة، <a href='advertiser-edit.php'>أضف معلنًا جديدًا</a> أولًا.";
$GLOBALS['strConfirmDeleteCampaign'] = "هل تريد حذف هذه الحملة الاعلانية ؟";
$GLOBALS['strConfirmDeleteCampaigns'] = "هل تريد حذف هذه الحملة الاعلانية ؟";
$GLOBALS['strShowParentAdvertisers'] = "عرض المعلنين الرئيسيين";
$GLOBALS['strHideParentAdvertisers'] = "إخفاء المعلنين الرئيسيين";
$GLOBALS['strHideInactiveCampaigns'] = "إخفاء الحملات الاعلانية غير النشطة";
$GLOBALS['strInactiveCampaignsHidden'] = "تم إخفاء الحملات الاعلانية غير النشطة";
$GLOBALS['strPriorityInformation'] = "الأهمية مقارنة بالحملات الإعلانية الأخرى";
$GLOBALS['strECPMInformation'] = "ترتيب الأهمية حسب eCPM";
$GLOBALS['strRemnantEcpmDescription'] = "يحسب النظام eCPM تلقائيًا بناءً على أداء هذه الحملة.<br />ويستخدمه لترتيب أهمية الحملات الاحتياطية فيما بينها.";
$GLOBALS['strEcpmMinImpsDescription'] = "أدخل الحد الأدنى الذي تريده من مرات الظهور ليحسب النظام على أساسه eCPM لهذه الحملة.";
$GLOBALS['strHiddenCampaign'] = "الحملة الإعلانية";
$GLOBALS['strHiddenAd'] = "الاعلانات";
$GLOBALS['strHiddenAdvertiser'] = "المعلن";
$GLOBALS['strHiddenTracker'] = "المتتبع";
$GLOBALS['strHiddenWebsite'] = "الموقع";
$GLOBALS['strHiddenZone'] = "المنطقة";
$GLOBALS['strCampaignDelivery'] = "توصيل الحملة";
$GLOBALS['strCompanionPositioning'] = "العرض المصاحب";
$GLOBALS['strSelectUnselectAll'] = "اختيار/عدم اختيار الكل";
$GLOBALS['strCampaignsOfAdvertiser'] = "التابعة للمعلن"; //this is added between page name and advertiser name eg. 'Campaigns of Advertiser 1'
$GLOBALS['strShowCappedNoCookie'] = "عرض الإعلانات المقيدة بحد التكرار إذا كانت الكوكيز معطلة";

// Campaign-zone linking page
$GLOBALS['strCalculatedForAllCampaigns'] = "محسوبة لكل الحملات";
$GLOBALS['strCalculatedForThisCampaign'] = "محسوبة لهذه الحملة";
$GLOBALS['strLinkingZonesProblem'] = "حدثت مشكلة أثناء ربط مناطق العرض";
$GLOBALS['strUnlinkingZonesProblem'] = "حدثت مشكلة أثناء إلغاء ربط مناطق العرض";
$GLOBALS['strZonesLinked'] = "من مناطق العرض مرتبطة الآن";
$GLOBALS['strZonesUnlinked'] = "من مناطق العرض لم تعد مرتبطة";
$GLOBALS['strZonesSearch'] = "بحث";
$GLOBALS['strZonesSearchTitle'] = "البحث عن مناطق العرض والمواقع بالاسم";
$GLOBALS['strNoWebsitesAndZones'] = "لا توجد مواقع أو مناطق عرض";
$GLOBALS['strNoWebsitesAndZonesText'] = "يحتوي اسمها على «%s»";
$GLOBALS['strToLink'] = "للربط";
$GLOBALS['strToUnlink'] = "لإلغاء الربط";
$GLOBALS['strLinked'] = "المرتبطة";
$GLOBALS['strAvailable'] = "موجود";
$GLOBALS['strShowing'] = "المعروضة";
$GLOBALS['strEditZone'] = "تعديل منطقة العرض";
$GLOBALS['strEditWebsite'] = "تعديل الموقع";


// Campaign properties
$GLOBALS['strDontExpire'] = "لا تنتهي";
$GLOBALS['strActivateNow'] = "تبدأ على الفور";
$GLOBALS['strSetSpecificDate'] = "تعيين تاريخ محدد";
$GLOBALS['strLow'] = "منخفض";
$GLOBALS['strHigh'] = "عالي";
$GLOBALS['strExpirationDate'] = "تاريخ النهاية";
$GLOBALS['strExpirationDateComment'] = "الحملة الاعلانية ستنتهي مع نهاية هذا اليوم";
$GLOBALS['strActivationDate'] = "تاريخ البداية";
$GLOBALS['strActivationDateComment'] = "الحملة الاعلانية ستبدأ مع بداية اليوم";
$GLOBALS['strImpressionsRemaining'] = "مرات الظهور المتبقية";
$GLOBALS['strClicksRemaining'] = "الضغطات المتبقية";
$GLOBALS['strConversionsRemaining'] = "مرات الظهور المتبقية";
$GLOBALS['strImpressionsBooked'] = "مرات الظهور المحجوزة";
$GLOBALS['strClicksBooked'] = "الضغطات المحجوزة";
$GLOBALS['strConversionsBooked'] = "التحويلات المحجوزة";
$GLOBALS['strCampaignWeight'] = "تحديد وزن الحملة";
$GLOBALS['strAnonymous'] = "إخفاء المعلن و المواقع لهذه الحملة الاعلانية";
$GLOBALS['strTargetPerDay'] = "في اليوم";
$GLOBALS['strCampaignWarningRemnantNoWeight'] = "أهمية هذه الحملة تم تحديدها كمنخفضة، 
ولكن الوزن تم تحديده كصفر أو لم يتم تحديده.
هذا الأمر سيجعل الحملة غير نشطة
و لن يتم عرض الإعلانات الموجودة فيها
حتى يتم تعديل الوزن إلى رقم صحيح.

هل أنت متأكد من رغبتك في المواصلة؟";
$GLOBALS['strCampaignWarningEcpmNoRevenue'] = "تستخدم هذه الحملة تحسين eCPM،
لكن قيمة «الإيرادات» صفر أو غير محددة.
وسيؤدي ذلك إلى تعطيل الحملة،
وإيقاف توصيل بنراتها حتى
تضبط الإيرادات على رقم صالح.

هل أنت متأكد أنك تريد المتابعة؟";
$GLOBALS['strCampaignWarningOverrideNoWeight'] = "نوع هذه الحملة «تجاوز»،
لكن قيمة الوزن صفر أو
غير محددة. وسيؤدي ذلك إلى
تعطيل الحملة وإيقاف توصيل بنراتها
حتى تضبط الوزن على رقم صالح.

هل أنت متأكد أنك تريد المتابعة؟";
$GLOBALS['strCampaignWarningNoTarget'] = "أهمية هذه الحملة تم تحديدها كمرتفعة،
ولكن مرات الظهور المستهدفة لم يتم تحديدها.
هذا الأمر سيعطل الحملة و
الإعلانات المرتبطة بها لن يتم عرضها حتى يتم
تحديد عدد مرات الظهور المستهدف.

هل أنت متأكد من رغبتك في المواصلة؟";
$GLOBALS['strCampaignStatusPending'] = "بانتظار الموافقة";
$GLOBALS['strCampaignStatusInactive'] = "فعال";
$GLOBALS['strCampaignStatusRunning'] = "قيد التشغيل";
$GLOBALS['strCampaignStatusPaused'] = "إيقاف مؤقت";
$GLOBALS['strCampaignStatusAwaiting'] = "قيد الانتظار";
$GLOBALS['strCampaignStatusExpired'] = "أنجزت";
$GLOBALS['strCampaignStatusApproval'] = "في انتظار الموافقة";
$GLOBALS['strCampaignStatusRejected'] = "تم رفضها";
$GLOBALS['strCampaignStatusAdded'] = "تمت الاضافة";
$GLOBALS['strCampaignStatusStarted'] = "بدأت";
$GLOBALS['strCampaignStatusRestarted'] = "إعادة تشغيل";
$GLOBALS['strCampaignStatusDeleted'] = "حذف";
$GLOBALS['strCampaignType'] = "اسم الحملة الاعلانية";
$GLOBALS['strType'] = "النوع";
$GLOBALS['strContract'] = "الاتصال";
$GLOBALS['strOverride'] = "تجاوز";
$GLOBALS['strOverrideInfo'] = "حملات التجاوز نوع خاص من الحملات هدفه
    تجاوز الحملات الاحتياطية والتعاقدية (أي التقدم عليها في الأهمية). وتستخدم حملات التجاوز عادةً مع
    قواعد استهداف أو حد تكرار محددة، لضمان عرض بنرات الحملة دائمًا في مواضع معينة،
    ولمستخدمين معينين، وربما لعدد معين من المرات، ضمن عرض ترويجي محدد. (كان هذا النوع من
    الحملات يعرف سابقًا باسم «تعاقدية (حصرية)».)";
$GLOBALS['strStandardContract'] = "الاتصال";
$GLOBALS['strStandardContractInfo'] = "الحملات التعاقدية مخصصة لتوصيل مرات الظهور بوتيرة منتظمة
    لتحقيق هدف أداء محدد مرتبط بمهلة زمنية. أي أنها تناسب الحالات التي
    يدفع فيها المعلن مقابل عدد محدد من مرات الظهور و/أو الضغطات و/أو التحويلات، على أن
    يتحقق هذا العدد بين تاريخين أو في كل يوم.";
$GLOBALS['strRemnant'] = "احتياطية";
$GLOBALS['strRemnantInfo'] = "نوع الحملة الافتراضي. للحملات الاحتياطية خيارات
    توصيل كثيرة ومتنوعة، ويستحسن أن تربط دائمًا حملة احتياطية واحدة على الأقل بكل منطقة عرض، لتضمن
    وجود ما يعرض فيها في كل وقت. استخدم الحملات الاحتياطية لعرض بنراتك الداخلية أو بنرات شبكات الإعلانات، أو حتى
    الإعلانات المباشرة المبيعة التي لا يشترط فيها تحقيق هدف أداء
    مرتبط بمهلة زمنية.";
$GLOBALS['strECPMInfo'] = "هذه حملة قياسية يمكن تقييدها بتاريخ انتهاء أو بحد معين. وبحسب الإعدادات الحالية، يعتمد ترتيب أهميتها على eCPM.";
$GLOBALS['strPricing'] = "التسعير";
$GLOBALS['strPricingModel'] = "نموذج التسعير";
$GLOBALS['strSelectPricingModel'] = "-- اختر النموذج --";
$GLOBALS['strRatePrice'] = "المعدل / السعر";
$GLOBALS['strMinimumImpressions'] = "الحد الأدنى لمرات الظهور اليومية";
$GLOBALS['strLimit'] = "الحد";
$GLOBALS['strLowExclusiveDisabled'] = "لا يمكنك تحويل هذه الحملة إلى احتياطية أو حصرية، لأن لها تاريخ انتهاء وحدًا لمرات الظهور أو الضغطات أو التحويلات في الوقت نفسه. <br>ولتغيير نوعها، احذف تاريخ الانتهاء أو أزل الحدود.";
$GLOBALS['strCannotSetBothDateAndLimit'] = "لا يمكنك تحديد تاريخ انتهاء وحد معًا لحملة احتياطية أو حصرية.<br>وإذا احتجت إلى تحديد تاريخ انتهاء وحد لمرات الظهور أو الضغطات أو التحويلات معًا، فاستخدم حملة تعاقدية غير حصرية.";
$GLOBALS['strWhyDisabled'] = "لماذا هذا الخيار معطل؟";
$GLOBALS['strBackToCampaigns'] = "العودة إلى الحملات";
$GLOBALS['strCampaignBanners'] = "بنرات الحملة";
$GLOBALS['strCookies'] = "الكوكيز";

// Tracker
$GLOBALS['strTracker'] = "المتتبع";
$GLOBALS['strTrackers'] = "المتتبع";
$GLOBALS['strTrackerPreferences'] = "الخيارات العامة";
$GLOBALS['strAddTracker'] = "إضافة متتبع جديد";
$GLOBALS['strTrackerForAdvertiser'] = "للمعلن";
$GLOBALS['strNoTrackers'] = "لا توجد حاليًا متتبعات لهذا المعلن";
$GLOBALS['strConfirmDeleteTrackers'] = "هل تريد حذف هذا المتتبع ؟";
$GLOBALS['strConfirmDeleteTracker'] = "هل تريد حذف هذا المتتبع ؟";
$GLOBALS['strTrackerProperties'] = "خواص المتتبع";
$GLOBALS['strDefaultStatus'] = "الحالة الافتراضية";
$GLOBALS['strStatus'] = "الحالة";
$GLOBALS['strLinkedTrackers'] = "المتتبعات المرتبطة";
$GLOBALS['strTrackerInformation'] = "معلومات المتتبع";
$GLOBALS['strConversionWindow'] = "نافذة التحويل";
$GLOBALS['strUniqueWindow'] = "ناقذة فريدة";
$GLOBALS['strClick'] = "ضغطة";
$GLOBALS['strView'] = "عرض";
$GLOBALS['strArrival'] = "الوصول";
$GLOBALS['strManual'] = "يدوي";
$GLOBALS['strImpression'] = "مرات الظهور";
$GLOBALS['strConversionType'] = "نوع التحويل";
$GLOBALS['strLinkCampaignsByDefault'] = "ربط الحملات الاعلانية الجديدة افتراضياً";
$GLOBALS['strBackToTrackers'] = "العودة إلى المتتبعات";
$GLOBALS['strIPAddress'] = "عنوان IP";

// Banners (General)
$GLOBALS['strBanner'] = "بنر";
$GLOBALS['strBanners'] = "بنرات";
$GLOBALS['strAddBanner'] = "إضافة بنر جديد";
$GLOBALS['strAddBanner_Key'] = "إضافة بنر جديد";
$GLOBALS['strBannerToCampaign'] = "إلى الحملة";
$GLOBALS['strShowBanner'] = "عرض البنر";
$GLOBALS['strBannerProperties'] = "خواص البنر";
$GLOBALS['strBannerHistory'] = "إحصائيات البنر";
$GLOBALS['strNoBanners'] = "لا توجد حاليًا بنرات لهذه الحملة.";
$GLOBALS['strNoBannersAddCampaign'] = "لا يوجد حتى الآن أية مواقع. لإضافة منطقة إعلانية، يجب <a href='affiliate-edit.php'>إضافة موقع جديد</a> قبل ذلك.";
$GLOBALS['strNoBannersAddAdvertiser'] = "لا يوجد حتى الآن أية مواقع. لإضافة منطقة إعلانية، يجب <a href='affiliate-edit.php'>إضافة موقع جديد</a> قبل ذلك.";
$GLOBALS['strConfirmDeleteBanner'] = "هل تريد حذف هذا البنر ؟";
$GLOBALS['strConfirmDeleteBanners'] = "هل تريد حذف هذا البنر ؟";
$GLOBALS['strShowParentCampaigns'] = "عرض الحملة الاعلانية الرئيسية";
$GLOBALS['strHideParentCampaigns'] = "إخفاء الحملات الاعلانية الرئيسية";
$GLOBALS['strHideInactiveBanners'] = "إخفاء البنرات غير النشطة";
$GLOBALS['strInactiveBannersHidden'] = "تم إخفاء البنرات غير النشطة";
$GLOBALS['strWarningMissing'] = "تحذير، أمور مفقودة محتملة";
$GLOBALS['strWarningMissingClosing'] = "علامة الإغلاق";
$GLOBALS['strWarningMissingOpening'] = "علامة الإبتداء";
$GLOBALS['strSubmitAnyway'] = "إضافة دون تغيير";
$GLOBALS['strBannersOfCampaign'] = "في الحملة"; //this is added between page name and campaign name eg. 'Banners in coca cola campaign'

// Banner Preferences
$GLOBALS['strBannerPreferences'] = "الخيارات العامة";
$GLOBALS['strCampaignPreferences'] = "خيارات الحملة";
$GLOBALS['strDefaultBanners'] = "البنر الافتراضي";
$GLOBALS['strDefaultBannerUrl'] = "الصورة الافتراضية";
$GLOBALS['strDefaultBannerDestination'] = "الرابط الافتراضي";
$GLOBALS['strAllowedBannerTypes'] = "أنواع البنرات المسموحة";
$GLOBALS['strTypeSqlAllow'] = "إتاحة البنرات المحلية في قاعدة بيانات SQL";
$GLOBALS['strTypeWebAllow'] = "إتاحة البنرات المحلية على خادم الويب";
$GLOBALS['strTypeUrlAllow'] = "إتاحة البنرات الخارجية";
$GLOBALS['strTypeHtmlAllow'] = "إتاحة بنرات HTML";
$GLOBALS['strTypeTxtAllow'] = "إتاحة الاعلانات النصية";

// Banner (Properties)
$GLOBALS['strChooseBanner'] = "الرجاء اختيار نوع البنر";
$GLOBALS['strMySQLBanner'] = "رفع بنر محلي إلى قاعدة البيانات";
$GLOBALS['strWebBanner'] = "رفع بنر محلي إلى خادم الويب";
$GLOBALS['strURLBanner'] = "ربط بنر خارجي";
$GLOBALS['strHTMLBanner'] = "إنشاء بنر HTML";
$GLOBALS['strTextBanner'] = "إنشاء بنر نصي";
$GLOBALS['strAlterHTML'] = "تعديل HTML لتفعيل تتبع الضغطات في:";
$GLOBALS['strIframeFriendly'] = "يمكن عرض هذا البنر بأمان داخل iframe (لأنه لا يتمدد مثلًا)";
$GLOBALS['strUploadOrKeep'] = "هل تريد حفظ <br />الصورة الحالية ، أو<br />رفع صورة أخرى ؟";
$GLOBALS['strNewBannerFile'] = "الرجاء اختيار الصورة التي تريد<br />استخدامها لهذا البنر<br /><br />";
$GLOBALS['strNewBannerFileAlt'] = "إختيار صورة إحتياطية <br /> تريد إستخدامها في حال لم يتمكن المستعرض <br /> من عرض الوسائط المتعددة<br /><br />";
$GLOBALS['strNewBannerURL'] = "رابط الصورة (مع http://)";
$GLOBALS['strURL'] = "رابط الوجهة (مع http://)";
$GLOBALS['strKeyword'] = "كلمات مفتاحية";
$GLOBALS['strTextBelow'] = "النص تحت الصورة";
$GLOBALS['strWeight'] = "الوزن";
$GLOBALS['strAlt'] = "النص البديل";
$GLOBALS['strStatusText'] = "نص الحالة";
$GLOBALS['strCampaignsWeight'] = "وزن الحملة";
$GLOBALS['strBannerWeight'] = "وزن البنر";
$GLOBALS['strBannersWeight'] = "وزن البنر";
$GLOBALS['strAdserverTypeGeneric'] = "بنر HTML عام";
$GLOBALS['strDoNotAlterHtml'] = "عدم تعديل HTML";
$GLOBALS['strGenericOutputAdServer'] = "عام";
$GLOBALS['strBackToBanners'] = "العودة إلى البنرات";
$GLOBALS['strUseWyswygHtmlEditor'] = "استخدام محرر HTML المرئي (WYSIWYG)";
$GLOBALS['strChangeDefault'] = "تغيير الافتراضي";
$GLOBALS['strBannerNotSslCompliant'] = "يحتوي البنر على موارد لا تستخدم HTTPS، لذلك لن يظهر في صفحات HTTPS";

// Banner (advanced)
$GLOBALS['strBannerPrependHTML'] = "إدراج كود HTML التالي دائمًا قبل هذا البنر";
$GLOBALS['strBannerAppendHTML'] = "إلحاق كود HTML التالي دائمًا بهذا البنر";

// Display Delviery Rules
$GLOBALS['strModifyBannerAcl'] = "خيارات التوصيل";
$GLOBALS['strACL'] = "خيارات التوصيل";
$GLOBALS['strACLAdd'] = "إضافة قاعدة توصيل";
$GLOBALS['strApplyLimitationsTo'] = "تطبيق قواعد التوصيل على";
$GLOBALS['strAllBannersInCampaign'] = "كل البنرات في هذه الحملة";
$GLOBALS['strRemoveAllLimitations'] = "إزالة كل قواعد التوصيل";
$GLOBALS['strEqualTo'] = "يساوي";
$GLOBALS['strDifferentFrom'] = "مختلف عن";
$GLOBALS['strLaterThan'] = "أحدث من";
$GLOBALS['strLaterThanOrEqual'] = "أحدث من أو يساوي";
$GLOBALS['strEarlierThan'] = "أقدم من";
$GLOBALS['strEarlierThanOrEqual'] = "أقدم من أو يساوي";
$GLOBALS['strContains'] = "يحتوي على";
$GLOBALS['strNotContains'] = "لا يحتوي على";
$GLOBALS['strGreaterThan'] = "أكبر من";
$GLOBALS['strLessThan'] = "أصغر من";
$GLOBALS['strGreaterOrEqualTo'] = "أكبر من أو يساوي";
$GLOBALS['strLessOrEqualTo'] = "أصغر من أو يساوي";
$GLOBALS['strAND'] = "و";                          // logical operator
$GLOBALS['strOR'] = "أو";                         // logical operator
$GLOBALS['strOnlyDisplayWhen'] = "إعرض البنر فقط عندما";
$GLOBALS['strWeekDays'] = "أيام الاسبوع";
$GLOBALS['strTime'] = "الوقت";
$GLOBALS['strDomain'] = "النطاق";
$GLOBALS['strSource'] = "المصدر";
$GLOBALS['strBrowser'] = "المتصفح";
$GLOBALS['strOS'] = "نظام التشغيل";
$GLOBALS['strDeliveryLimitations'] = "قواعد التوصيل";

$GLOBALS['strDeliveryCappingReset'] = "قم بتصفير العداد بعد :";
$GLOBALS['strDeliveryCappingTotal'] = "في المجموع";
$GLOBALS['strDeliveryCappingSession'] = "كل جلسة";

if (!isset($GLOBALS['strCappingBanner'])) {
    $GLOBALS['strCappingBanner'] = [];
}
$GLOBALS['strCappingBanner']['title'] = "حد تكرار التوصيل لكل زائر";
$GLOBALS['strCappingBanner']['limit'] = "تحديد عرض الإعلانات إلى:";

if (!isset($GLOBALS['strCappingCampaign'])) {
    $GLOBALS['strCappingCampaign'] = [];
}
$GLOBALS['strCappingCampaign']['title'] = "حد تكرار التوصيل لكل زائر";
$GLOBALS['strCappingCampaign']['limit'] = "تحديد عرض الحملة الإعلانية إلى:";

if (!isset($GLOBALS['strCappingZone'])) {
    $GLOBALS['strCappingZone'] = [];
}
$GLOBALS['strCappingZone']['title'] = "حد تكرار التوصيل لكل زائر";
$GLOBALS['strCappingZone']['limit'] = "تحديد عرض المنطقة الإعلانية إلى:";

// Website
$GLOBALS['strAffiliate'] = "الموقع";
$GLOBALS['strAffiliates'] = "المواقع";
$GLOBALS['strAffiliatesAndZones'] = "المواقع و مناطق العرض";
$GLOBALS['strAddNewAffiliate'] = "إضافة موقع جديد";
$GLOBALS['strAffiliateProperties'] = "خواص الموقع";
$GLOBALS['strAffiliateHistory'] = "إحصائيات الموقع";
$GLOBALS['strNoAffiliates'] = "لا يوجد حتى الآن أية مواقع. لإضافة منطقة إعلانية، يجب <a href='affiliate-edit.php'>إضافة موقع جديد</a> قبل ذلك.";
$GLOBALS['strConfirmDeleteAffiliate'] = "هل تريد حذف هذا الموقع؟";
$GLOBALS['strConfirmDeleteAffiliates'] = "هل تريد حذف هذا الموقع؟";
$GLOBALS['strInactiveAffiliatesHidden'] = "تم إخفاء المواقع غير النشطة";
$GLOBALS['strShowParentAffiliates'] = "عرض المواقع الرئيسية";
$GLOBALS['strHideParentAffiliates'] = "إخفاء المواقع الرئيسية";

// Website (properties)
$GLOBALS['strWebsite'] = "الموقع";
$GLOBALS['strWebsiteURL'] = "عنوان URL للموقع";
$GLOBALS['strAllowAffiliateModifyZones'] = "السماح لهذا العضو بتعديل مناطقه الإعلانية الخاصة";
$GLOBALS['strAllowAffiliateLinkBanners'] = "السماح لهذا العضو بربط الإعلانات لمناطقة الخاصة";
$GLOBALS['strAllowAffiliateAddZone'] = "السماح لهذا العضو بإنشاء منطقة إعلانية جديدة";
$GLOBALS['strAllowAffiliateDeleteZone'] = "السماح لهذا العضو بحذف منطقة إعلانية موجودة";
$GLOBALS['strAllowAffiliateGenerateCode'] = "السماح لهذا العضو بإنشاء أكواد التركيب";

// Website (properties - payment information)
$GLOBALS['strPostcode'] = "الرمز البريدي";
$GLOBALS['strCountry'] = "الدولة";

// Website (properties - other information)
$GLOBALS['strWebsiteZones'] = "المواقع و مناطق العرض";

// Zone
$GLOBALS['strZone'] = "المنطقة";
$GLOBALS['strZones'] = "مناطق العرض";
$GLOBALS['strAddNewZone'] = "إضافة منطقة عرض جديدة";
$GLOBALS['strAddNewZone_Key'] = "إضافة منطقة عرض جديدة";
$GLOBALS['strZoneToWebsite'] = "كل المواقع";
$GLOBALS['strLinkedZones'] = "مناطق العرض المرتبطة";
$GLOBALS['strAvailableZones'] = "مناطق العرض المتاحة";
$GLOBALS['strLinkingNotSuccess'] = "لم ينجح الربط، يرجى المحاولة مجددًا";
$GLOBALS['strZoneProperties'] = "خواص منطقة العرض";
$GLOBALS['strZoneHistory'] = "سجل منطقة العرض";
$GLOBALS['strNoZones'] = "لا توجد حاليًا مناطق عرض لهذا الموقع.";
$GLOBALS['strNoZonesAddWebsite'] = "لا يوجد حتى الآن أية مواقع. لإضافة منطقة إعلانية، يجب <a href='affiliate-edit.php'>إضافة موقع جديد</a> قبل ذلك.";
$GLOBALS['strConfirmDeleteZone'] = "هل تريد حذف منطقة العرض ؟";
$GLOBALS['strConfirmDeleteZones'] = "هل تريد حذف منطقة العرض ؟";
$GLOBALS['strConfirmDeleteZoneLinkActive'] = "لا تزال هناك حملات مرتبطة بمنطقة العرض هذه، وإذا حذفتها فلن تتمكن هذه الحملات من العمل ولن تتقاضى مقابلًا عنها.";
$GLOBALS['strZoneType'] = "نوع منطقة العرض";
$GLOBALS['strBannerButtonRectangle'] = "بنر";
$GLOBALS['strInterstitial'] = "ضمن المحتوى";
$GLOBALS['strPopup'] = "نافذة منبثقة";
$GLOBALS['strTextAdZone'] = "اعلان نصي";
$GLOBALS['strEmailAdZone'] = "بريد الكتروني/قائمة مراسلات";
$GLOBALS['strZoneVideoInstream'] = "إعلان فيديو مدمج";
$GLOBALS['strZoneVideoOverlay'] = "إعلان فيديو متراكب";
$GLOBALS['strShowMatchingBanners'] = "عرض البنرات المطابقة";
$GLOBALS['strHideMatchingBanners'] = "إخفاء البنرات المطابقة";
$GLOBALS['strBannerLinkedAds'] = "البنرات المرتبطة بمنطقة العرض هذه";
$GLOBALS['strCampaignLinkedAds'] = "الحملات الاعلانية المرتبطة بمنطقة العرض هذه";
$GLOBALS['strInactiveZonesHidden'] = "تم إخفاء مناطق العرض غير النشطة";
$GLOBALS['strWarnChangeZoneType'] = "سيؤدي تغيير نوع منطقة العرض إلى نصي أو بريد إلكتروني إلى إلغاء ربط كل البنرات والحملات بسبب قيود هذين النوعين من مناطق العرض
                                                <ul>
                                                    <li>لا يمكن ربط مناطق العرض النصية إلا بالإعلانات النصية</li>
                                                    <li>لا يمكن أن يكون لحملات مناطق عرض البريد الإلكتروني إلا بنر نشط واحد في كل مرة</li>
                                                </ul>";
$GLOBALS['strWarnChangeZoneSize'] = 'سيؤدي تغيير حجم منطقة العرض إلى إلغاء ربط أي بنرات لا تطابق الحجم الجديد، وإلى إضافة بنرات الحملات المرتبطة التي تطابق الحجم الجديد';
$GLOBALS['strWarnChangeBannerSize'] = 'سيؤدي تغيير حجم البنر إلى إلغاء ربطه بأي مناطق عرض لا تطابق الحجم الجديد، وإذا كانت <strong>حملة</strong> هذا البنر مرتبطة بمنطقة عرض بالحجم الجديد، فسيرتبط هذا البنر بها تلقائيًا';
$GLOBALS['strWarnBannerReadonly'] = 'هذا البنر للقراءة فقط لأن إحدى الإضافات معطلة. تواصل مع مدير النظام لمزيد من المعلومات.';
$GLOBALS['strZonesOfWebsite'] = 'في الموقع'; //this is added between page name and website name eg. 'Zones in www.example.com'
$GLOBALS['strBackToZones'] = "العودة إلى مناطق العرض";

$GLOBALS['strIab']['IAB_FullBanner(468x60)'] = "بنر كامل IAB (468 x 60)‎";
$GLOBALS['strIab']['IAB_Skyscraper(120x600)'] = "ناطحة سحاب IAB (120 x 600)‎";
$GLOBALS['strIab']['IAB_Leaderboard(728x90)'] = "لوحة صدارة IAB (728 x 90)‎";
$GLOBALS['strIab']['IAB_Button1(120x90)'] = "زر 1 IAB (120 x 90)‎";
$GLOBALS['strIab']['IAB_Button2(120x60)'] = "زر 2 IAB (120 x 60)‎";
$GLOBALS['strIab']['IAB_HalfBanner(234x60)'] = "نصف بنر IAB (234 x 60)‎";
$GLOBALS['strIab']['IAB_MicroBar(88x31)'] = "شريط صغير IAB (88 x 31)‎";
$GLOBALS['strIab']['IAB_SquareButton(125x125)'] = "زر مربع IAB (125 x 125)‎";
$GLOBALS['strIab']['IAB_Rectangle(180x150)*'] = "مستطيل IAB (180 x 150)‎";
$GLOBALS['strIab']['IAB_SquarePop-up(250x250)'] = "نافذة منبثقة مربعة IAB (250 x 250)‎";
$GLOBALS['strIab']['IAB_VerticalBanner(120x240)'] = "بنر عمودي IAB (120 x 240)‎";

// Advanced zone settings
$GLOBALS['strAdvanced'] = "متقدم";
$GLOBALS['strZoneStopDelivery'] = "إيقاف العرض و عدم عرض أي بنر";
$GLOBALS['strZoneOtherZone'] = "ستخدم منطقة العرض كـ بديل";
$GLOBALS['strZoneAppendHTMLCode'] = "كود HTML";
$GLOBALS['strZoneAppendZoneSelection'] = "نافذة منبثقة أو ضمن النص";

// Zone probability

// Linked banners/campaigns/trackers
$GLOBALS['strLinkedBanners'] = "ربط بنرات منفردة";
$GLOBALS['strCampaignDefaults'] = "ربط بنرات عبر الحملة الاعلانية";
$GLOBALS['strRawQueryString'] = "كلمة مفتاحية";
$GLOBALS['strIncludedBanners'] = "البنرات المرتبطة";
$GLOBALS['strMatchingBanners'] = "{count} بنرات مطابقة";
$GLOBALS['strNoCampaignsToLink'] = "لا توجد حملات إعلانية متوفرة للربط بهذا البنر";
$GLOBALS['strNoTrackersToLink'] = "لا يوجد متتبع متوفر للربط بهذا البنر";
$GLOBALS['strNoZonesToLinkToCampaign'] = "لا توجد مناطق عرض متوفرة للربط بهذه الحملة الاعلانية";
$GLOBALS['strSelectBannerToLink'] = "الرجاء اختيار البنر الذي ترغب بربطه مع منطقة العرض هذه :";
$GLOBALS['strSelectCampaignToLink'] = "الرجاء اختيار الحملة الاعلانية الذي ترغب بربطها مع منطقة العرض هذه :";
$GLOBALS['strSelectAdvertiser'] = "إختيار المعلن";
$GLOBALS['strSelectPlacement'] = "إختيار الحملة الاعلانية";
$GLOBALS['strSelectAd'] = "إختيار البنر";
$GLOBALS['strSelectZone'] = "إختيار المنطقة";
$GLOBALS['strStatusPending'] = "بانتظار الموافقة";
$GLOBALS['strStatusApproved'] = "تمت الموافقة";
$GLOBALS['strStatusDisapproved'] = "لم تتم الموافقة";
$GLOBALS['strStatusDuplicate'] = "نسخ";
$GLOBALS['strStatusIgnore'] = "تجاهل";
$GLOBALS['strConnectionType'] = "النوع";
$GLOBALS['strConnTypeSale'] = "حفظ";
$GLOBALS['strConnTypeSignUp'] = "تسجيل جديد";
$GLOBALS['strShortcutEditStatuses'] = "تعديل الحالات";
$GLOBALS['strShortcutShowStatuses'] = "عرض الحالات";

// Statistics
$GLOBALS['strNoStats'] = "لا تتوفر إحصائيات حالياً";
$GLOBALS['strTotalThisPeriod'] = "المجموع لهذه الفترة";
$GLOBALS['strViewBreakdown'] = "عرض حسب";
$GLOBALS['strBreakdownByDay'] = "يوم";
$GLOBALS['strBreakdownByWeek'] = "اسبوع";
$GLOBALS['strBreakdownByMonth'] = "شهر";
$GLOBALS['strBreakdownByDow'] = "اليوم من الأسبوع";
$GLOBALS['strBreakdownByHour'] = "الساعة";
$GLOBALS['strItemsPerPage'] = "عدد العناصر في الصفحة";
$GLOBALS['strShowGraphOfStatistics'] = "عرض مخطط بياني للاحصائيات";
$GLOBALS['strExportStatisticsToExcel'] = "تصدير الاحصائيات الى Excel";

// Expiration
$GLOBALS['strNoExpiration'] = "لم يتم تحديد تاريخ الانتهاء";
$GLOBALS['strEstimated'] = "تاريخ الانتهاء المتوقع";
$GLOBALS['strCampaignStop'] = "سجل الحملة الإعلانية";

// Reports
$GLOBALS['strStartDate'] = "تاريخ البداية";
$GLOBALS['strEndDate'] = "تاريخ النهاية";
$GLOBALS['strLimitations'] = "قواعد التوصيل";

// Admin_UI_Fields
$GLOBALS['strAllAdvertisers'] = "كل المعلنين";
$GLOBALS['strAllPublishers'] = "كل المواقع";
$GLOBALS['strAllAvailZones'] = "كل مناطق العرض المتوفرة";

// Userlog
$GLOBALS['strUserLog'] = "سجل المستخدم";
$GLOBALS['strUserLogDetails'] = "تفاصيل سجل المستخدم";
$GLOBALS['strDeleteLog'] = "حذف السجل";
$GLOBALS['strAction'] = "الفعل";

// Code generation
$GLOBALS['strGenerateBannercode'] = "اختيار مباشر";
$GLOBALS['strChooseInvocationType'] = "الرجاء اختيار نوع البنر";
$GLOBALS['strGenerate'] = "إنشاء";
$GLOBALS['strParameters'] = "إعدادات الكود";
$GLOBALS['strFrameSize'] = "حجم الاطار";
$GLOBALS['strBannercode'] = "كود البنر";
$GLOBALS['strTrackercode'] = "كود المتتبع";
$GLOBALS['strBackToTheList'] = "العودة لقائمة التقارير";
$GLOBALS['strCharset'] = "ترميز الأحرف";
$GLOBALS['strAutoDetect'] = "اكتشاف تلقائي";
$GLOBALS['strCacheBusterComment'] = "  * ضع مكان كل {random}
  * رقمًا عشوائيًا مولدًا (أو طابعًا زمنيًا).
  *";
$GLOBALS['strGenerateHttpsTags'] = "إنشاء الأكواد باستخدام بروتوكول HTTPS";

// Errors
$GLOBALS['strErrorDatabaseConnection'] = "خطأ في الاتصال بقاعدة البيانات.";
$GLOBALS['strErrorCantConnectToDatabase'] = "حدث خطأ فادح: يتعذر على %1\$s الاتصال بقاعدة البيانات، ولذلك
                                                   لا يمكن استخدام واجهة الإدارة، وقد يتأثر توصيل
                                                   البنرات أيضًا. ومن الأسباب المحتملة للمشكلة:
                                                   <ul>
                                                     <li>خادم قاعدة البيانات لا يعمل حاليًا</li>
                                                     <li>تغير موقع خادم قاعدة البيانات</li>
                                                     <li>اسم المستخدم أو كلمة السر المستخدمان للاتصال بخادم قاعدة البيانات غير صحيحين</li>
                                                     <li>لم يحمل PHP الامتداد <i>%2\$s</i></li>
                                                   </ul>";
$GLOBALS['strNoMatchesFound'] = "لا توجد نتائج مطابقة";
$GLOBALS['strErrorOccurred'] = "حدث خطأ ما";
$GLOBALS['strErrorDBPlain'] = "حدث خطأ أثناء الوصول إلى قاعدة البيانات";
$GLOBALS['strErrorDBSerious'] = "رصد النظام مشكلة خطيرة في قاعدة البيانات";
$GLOBALS['strErrorDBNoDataPlain'] = "تعذر على {$PRODUCT_NAME} استرجاع البيانات أو تخزينها بسبب مشكلة في قاعدة البيانات. ";
$GLOBALS['strErrorDBNoDataSerious'] = "تعذر على {$PRODUCT_NAME} استرجاع البيانات بسبب مشكلة خطيرة في قاعدة البيانات";
$GLOBALS['strErrorDBCorrupt'] = "يبدو أن جدول قاعدة البيانات تالف ويحتاج إلى إصلاح. لمزيد من المعلومات عن إصلاح الجداول التالفة، اقرأ فصل <i>استكشاف الأخطاء وإصلاحها</i> في <i>دليل مدير النظام</i>.";
$GLOBALS['strErrorDBContact'] = "يرجى التواصل مع مدير هذا الخادم وإبلاغه بالمشكلة.";
$GLOBALS['strErrorDBSubmitBug'] = "إذا أمكن تكرار هذه المشكلة، فقد يكون سببها خلل برمجي في {$PRODUCT_NAME}. يرجى إرسال المعلومات التالية إلى مطوري {$PRODUCT_NAME}، وحاول أيضًا أن تصف الخطوات التي أدت إلى هذا الخطأ بأوضح صورة ممكنة.";
$GLOBALS['strMaintenanceNotActive'] = "لم يعمل سكربت الصيانة في آخر 24 ساعة.
ولكي يعمل التطبيق على النحو الصحيح، يجب تشغيل السكربت
كل ساعة.

اقرأ دليل مدير النظام لمزيد من المعلومات
عن إعداد سكربت الصيانة.";
$GLOBALS['strErrorLinkingBanner'] = "تعذر ربط هذا البنر بمنطقة العرض هذه، والسبب:";
$GLOBALS['strUnableToLinkBanner'] = "تعذر ربط هذا البنر: ";
$GLOBALS['strErrorEditingCampaignRevenue'] = "صيغة الرقم غير صحيحة في حقل معلومات الإيرادات";
$GLOBALS['strErrorEditingCampaignECPM'] = "صيغة الرقم غير صحيحة في حقل معلومات ECPM";
$GLOBALS['strErrorEditingZone'] = "خطأ في تحديث منطقة العرض:";
$GLOBALS['strUnableToChangeZone'] = "تعذر تطبيق هذا التغيير، والسبب:";
$GLOBALS['strDatesConflict'] = "تتداخل تواريخ الحملة التي تحاول ربطها مع تواريخ حملة مرتبطة بالفعل ";
$GLOBALS['strEmailNoDates'] = "يجب تحديد تاريخ بدء وتاريخ انتهاء للحملات المرتبطة بمناطق عرض البريد الإلكتروني، إذ يضمن {$PRODUCT_NAME} ألا يرتبط بمنطقة عرض البريد الإلكتروني في أي تاريخ إلا بنر نشط واحد. لذا تأكد من أن تواريخ الحملات المرتبطة بمنطقة العرض لا تتداخل مع تواريخ الحملة التي تحاول ربطها.";
$GLOBALS['strWarningInaccurateStats'] = "بعض هذه الإحصائيات مسجل بمنطقة زمنية غير UTC، وقد لا يظهر بالمنطقة الزمنية الصحيحة.";
$GLOBALS['strWarningInaccurateReport'] = "بعض الإحصائيات في هذا التقرير مسجل بمنطقة زمنية غير UTC، وقد لا يظهر بالمنطقة الزمنية الصحيحة";

//Validation
$GLOBALS['strRequiredFieldLegend'] = "يدل على حقل إلزامي";
$GLOBALS['strFormContainsErrors'] = "يحتوي النموذج على أخطاء، يرجى تصحيح الحقول المميزة أدناه.";
$GLOBALS['strXRequiredField'] = "الحقل %s إلزامي";
$GLOBALS['strEmailField'] = "يرجى إدخال بريد إلكتروني صالح";
$GLOBALS['strNumericField'] = "يرجى إدخال رقم (أرقام فقط)";
$GLOBALS['strGreaterThanZeroField'] = "يجب أن تكون القيمة أكبر من 0";
$GLOBALS['strXGreaterThanZeroField'] = "يجب أن تكون قيمة %s أكبر من 0";
$GLOBALS['strXPositiveWholeNumberField'] = "يجب أن تكون قيمة %s عددًا صحيحًا موجبًا";
$GLOBALS['strInvalidWebsiteURL'] = "عنوان URL للموقع غير صالح";
$GLOBALS['strUploadedRequired'] = "يجب رفع ملف";
$GLOBALS['strUploadedFileTooBig'] = "حجم الملف المرفوع يتجاوز الحد المسموح به. تأكد من أن حجمه أقل من %s بايت";

// Email
$GLOBALS['strSirMadam'] = "السيد/السيدة";
$GLOBALS['strMailSubject'] = "تقرير المعلن";
$GLOBALS['strMailHeader'] = "عزيزي {contact}،";
$GLOBALS['strMailBannerStats'] = "تجد أدناه إحصائيات بنرات {clientname}:";
$GLOBALS['strMailBannerActivatedSubject'] = "تفعيل الحملة الإعلانية";
$GLOBALS['strMailBannerDeactivatedSubject'] = "تعطيل الحملة الإعلانية";
$GLOBALS['strMailBannerActivated'] = "أصبحت حملتك الإعلانية المبينة أدناه نشطة لأن
تاريخ بدئها قد حلّ.";
$GLOBALS['strMailBannerDeactivated'] = "أصبحت حملتك الإعلانية المبينة أدناه غير نشطة لأن";
$GLOBALS['strMailFooter'] = "مع التحية،
   {adminfullname}";
$GLOBALS['strClientDeactivated'] = "هذه الحملة الإعلانية غير نشطة الآن لأن";
$GLOBALS['strBeforeActivate'] = "تاريخ البدء لم يحن بعد";
$GLOBALS['strAfterExpire'] = "تاريخ الانتهاء قد حلّ";
$GLOBALS['strNoMoreImpressions'] = "رصيد مرات الظهور نفد";
$GLOBALS['strNoMoreClicks'] = "رصيد الضغطات نفد";
$GLOBALS['strNoMoreConversions'] = "رصيد التحويلات نفد";
$GLOBALS['strWeightIsNull'] = "وزنها مضبوط على الصفر";
$GLOBALS['strRevenueIsNull'] = "إيراداتها مضبوطة على الصفر";
$GLOBALS['strTargetIsNull'] = "حدها اليومي مضبوط على الصفر - حدد تاريخ الانتهاء والحد كليهما، أو اضبط قيمة «الحد اليومي»";
$GLOBALS['strNoViewLoggedInInterval'] = "لا توجد مرات ظهور مسجلة خلال فترة هذا التقرير";
$GLOBALS['strNoClickLoggedInInterval'] = "لا توجد ضغطات مسجلة خلال فترة هذا التقرير";
$GLOBALS['strNoConversionLoggedInInterval'] = "لا توجد تحويلات مسجلة خلال فترة هذا التقرير";
$GLOBALS['strMailReportPeriod'] = "يتضمن هذا التقرير الإحصائيات من {startdate} حتى {enddate}.";
$GLOBALS['strMailReportPeriodAll'] = "يتضمن هذا التقرير جميع الإحصائيات حتى {enddate}.";
$GLOBALS['strNoStatsForCampaign'] = "لا تتوفر إحصائيات لهذه الحملة الإعلانية";
$GLOBALS['strImpendingCampaignExpiry'] = "اقتراب انتهاء الحملة الإعلانية";
$GLOBALS['strYourCampaign'] = "حملتك الإعلانية";
$GLOBALS['strTheCampiaignBelongingTo'] = "الحملة الإعلانية التابعة للمعلن";
$GLOBALS['strImpendingCampaignExpiryDateBody'] = "من المقرر أن تنتهي {clientname} المبينة أدناه في {date}.";
$GLOBALS['strImpendingCampaignExpiryImpsBody'] = "يقل رصيد مرات الظهور المتبقي في {clientname} المبينة أدناه عن {limit}.";
$GLOBALS['strImpendingCampaignExpiryBody'] = "لذلك ستتعطل الحملة الإعلانية تلقائيا قريبا، وستتعطل معها
البنرات التالية:";

// Priority
$GLOBALS['strPriority'] = "الأهمية";
$GLOBALS['strSourceEdit'] = "تعديل المصادر";

// Preferences
$GLOBALS['strPreferences'] = "الخيارات";
$GLOBALS['strUserPreferences'] = "الخيارات العامة";
$GLOBALS['strChangePassword'] = "تغيير كلمة المرور";
$GLOBALS['strChangeEmail'] = "تغيير البريد الإلكتروني";
$GLOBALS['strCurrentPassword'] = "كلمة المرور الحالية";
$GLOBALS['strChooseNewPassword'] = "كلمة المرور الجديدة";
$GLOBALS['strReenterNewPassword'] = "إعادة كتابة كلمة المرور الجديدة";
$GLOBALS['strNameLanguage'] = "الإسم و اللغة";
$GLOBALS['strAccountPreferences'] = "خيارات الحساب";
$GLOBALS['strCampaignEmailReportsPreferences'] = "خيارات التقارير الخاصة بالحملة الإعلانية";
$GLOBALS['strTimezonePreferences'] = "خيارات المنطقة الزمنية";
$GLOBALS['strAdminEmailWarnings'] = "البريد الالكتروني للمدير العام";
$GLOBALS['strAgencyEmailWarnings'] = "التنبيهات البريدية للوكالة الإعلانية";
$GLOBALS['strAdveEmailWarnings'] = "التنبيهات البريدية للمعلنين";
$GLOBALS['strFullName'] = "الإسم الكامل";
$GLOBALS['strEmailAddress'] = "البريد الإلكتروني";
$GLOBALS['strUserDetails'] = "معلومات العضو";
$GLOBALS['strUserInterfacePreferences'] = "خيارات شكل لوحة التحكم";
$GLOBALS['strPluginPreferences'] = "الخيارات العامة";
$GLOBALS['strColumnName'] = "اسم العمود";
$GLOBALS['strShowColumn'] = "إظهار العمود";
$GLOBALS['strCustomColumnName'] = "اسم مخصص للعمود";
$GLOBALS['strColumnRank'] = "ترتيب العمود";

// Long names
$GLOBALS['strRevenue'] = "الإيرادات";
$GLOBALS['strNumberOfItems'] = "عدد العناصر";
$GLOBALS['strRevenueCPC'] = "إيرادات CPC";
$GLOBALS['strERPM'] = "تكلفة الظهور";
$GLOBALS['strERPC'] = "تكلفة الضغطات";
$GLOBALS['strERPS'] = "تكلفة الظهور";
$GLOBALS['strEIPM'] = "تكلفة الظهور";
$GLOBALS['strEIPC'] = "تكلفة الضغطات";
$GLOBALS['strEIPS'] = "تكلفة الظهور";
$GLOBALS['strECPM'] = "تكلفة الظهور";
$GLOBALS['strECPC'] = "تكلفة الضغطات";
$GLOBALS['strECPS'] = "تكلفة الظهور";
$GLOBALS['strImpressionSR'] = "مرات الظهور";

// Short names
$GLOBALS['strERPM_short'] = "تكلفة الظهور";
$GLOBALS['strERPC_short'] = "تكلفة الضغطات";
$GLOBALS['strERPS_short'] = "تكلفة الظهور";
$GLOBALS['strEIPM_short'] = "تكلفة الظهور";
$GLOBALS['strEIPC_short'] = "تكلفة الضغطات";
$GLOBALS['strEIPS_short'] = "تكلفة الظهور";
$GLOBALS['strECPM_short'] = "تكلفة الظهور";
$GLOBALS['strECPC_short'] = "تكلفة الضغطات";
$GLOBALS['strECPS_short'] = "تكلفة الظهور";
$GLOBALS['strID_short'] = "الرقم";
$GLOBALS['strClicks_short'] = "الضغطات";
$GLOBALS['strCTR_short'] = "معدل الضغطات";

// Global Settings
$GLOBALS['strGlobalSettings'] = "الإعدادات العامة";
$GLOBALS['strGeneralSettings'] = "الإعدادات العامة";
$GLOBALS['strChooseSection'] = 'إختيار قسم';

// Product Updates
$GLOBALS['strHideBackupDetails'] = "إخفاء تفاصيل النسخة الاحتياطية للبيانات";
$GLOBALS['strBackupDeleteConfirm'] = "هل أنت متأكد من حذف جميع النسخ الاحتياطية التي أنشأتها هذه الترقية؟";
$GLOBALS['strDeleteArtifacts'] = "حذف مخرجات الترقية";
$GLOBALS['strArtifacts'] = "مخرجات الترقية";
$GLOBALS['strBackupDbTables'] = "نسخ احتياطية لجداول قاعدة البيانات";
$GLOBALS['strLogFiles'] = "ملفات السجل";
$GLOBALS['strConfigBackups'] = "نسخ احتياطية للإعدادات";
$GLOBALS['strUpdatedDbVersionStamp'] = "تحديث رقم إصدار قاعدة البيانات";
$GLOBALS['aProductStatus']['UPGRADE_COMPLETE'] = "اكتملت الترقية";
$GLOBALS['aProductStatus']['UPGRADE_FAILED'] = "فشلت الترقية";

// Agency
$GLOBALS['strAgencyManagement'] = "إدارة الحسابات";
$GLOBALS['strGlobalAgency'] = 'الحسابات';
$GLOBALS['strAgencyHistory'] = 'إحصائيات الحساب';
$GLOBALS['strAgency'] = "الحساب";
$GLOBALS['strAddAgency'] = "إضافة حساب جديد";
$GLOBALS['strAddAgency_Key'] = "إضافة منطقة عرض جديدة";
$GLOBALS['strTotalAgencies'] = "إجمالي الحسابات";
$GLOBALS['strAgencyProperties'] = "خواص الحساب";
$GLOBALS['strNoAgencies'] = "لم يتم تعريف أي منطقة عرض";
$GLOBALS['strConfirmDeleteAgency'] = "هل تريد حذف منطقة العرض ؟";
$GLOBALS['strHideInactiveAgencies'] = "إخفاء الحسابات غير النشطة";
$GLOBALS['strInactiveAgenciesHidden'] = "تم إخفاء مناطق العرض غير النشطة";
$GLOBALS['strSwitchAccount'] = "التبديل إلى هذا الحساب";
$GLOBALS['strAgencyStatusRunning'] = "نشط";
$GLOBALS['strAgencyStatusInactive'] = "فعال";
$GLOBALS['strAgencyStatusPaused'] = "معلّق";

// Channels
$GLOBALS['strChannel'] = "مجموعة قواعد التوصيل";
$GLOBALS['strChannels'] = "مجموعات قواعد التوصيل";
$GLOBALS['strChannelManagement'] = "إدارة مجموعات قواعد التوصيل";
$GLOBALS['strAddNewChannel'] = "إضافة مجموعة قواعد توصيل جديدة";
$GLOBALS['strAddNewChannel_Key'] = "إضافة مجموعة قواعد توصيل جديدة";
$GLOBALS['strChannelToWebsite'] = "كل المواقع";
$GLOBALS['strNoChannels'] = "لا توجد مجموعات قواعد توصيل معرّفة حتى الآن";
$GLOBALS['strNoChannelsAddWebsite'] = "لا توجد مجموعات قواعد توصيل معرّفة حتى الآن لعدم وجود مواقع. لإنشاء مجموعة قواعد توصيل، <a href='affiliate-edit.php'>أضف موقعا جديدا</a> أولا.";
$GLOBALS['strEditChannelLimitations'] = "تعديل قواعد التوصيل في مجموعة قواعد التوصيل";
$GLOBALS['strChannelProperties'] = "خواص مجموعة قواعد التوصيل";
$GLOBALS['strChannelLimitations'] = "خيارات التوصيل";
$GLOBALS['strConfirmDeleteChannel'] = "هل أنت متأكد من حذف مجموعة قواعد التوصيل هذه؟";
$GLOBALS['strConfirmDeleteChannels'] = "هل أنت متأكد من حذف مجموعات قواعد التوصيل المحددة؟";
$GLOBALS['strChannelsOfWebsite'] = 'في'; //this is added between page name and website name eg. 'delivery rule sets in www.example.com'

// Tracker Variables
$GLOBALS['strVariableName'] = "اسم المتغير";
$GLOBALS['strVariableDescription'] = "الوصف";
$GLOBALS['strVariableDataType'] = "نوع البيانات";
$GLOBALS['strVariablePurpose'] = "الغرض";
$GLOBALS['strGeneric'] = "عام";
$GLOBALS['strBasketValue'] = "قيمة السلة";
$GLOBALS['strNumItems'] = "عدد العناصر";
$GLOBALS['strVariableIsUnique'] = "إزالة تكرار التحويلات؟";
$GLOBALS['strNumber'] = "رقم";
$GLOBALS['strString'] = "نص";
$GLOBALS['strTrackFollowingVars'] = "تتبع المتغير التالي";
$GLOBALS['strAddVariable'] = "إضافة متغير";
$GLOBALS['strNoVarsToTrack'] = "لا توجد متغيرات للتتبع.";
$GLOBALS['strVariableRejectEmpty'] = "رفض القيمة الفارغة؟";
$GLOBALS['strTrackingSettings'] = "إعدادات التتبع";
$GLOBALS['strTrackerType'] = "اسم المتتبع";
$GLOBALS['strTrackerTypeJS'] = "تتبع متغيرات JavaScript";
$GLOBALS['strTrackerTypeDefault'] = "تتبع متغيرات JavaScript (متوافق مع الإصدارات السابقة، ويتطلب تهريب المحارف)";
$GLOBALS['strTrackerTypeDOM'] = "تتبع عناصر HTML باستخدام DOM";
$GLOBALS['strTrackerTypeCustom'] = "كود JS مخصص";

// Password recovery

// Password recovery - Default


// Password recovery - Welcome email

// Password recovery - Hash update

// Password reset warning

// Audit
$GLOBALS['strBinaryData'] = "معلومات Binary";

// Widget - Audit

// Widget - Campaign
$GLOBALS['strCampaignNoRecordsAdmin'] = "<li>لا يوجد أي نشاط لأي حملة للعرض.</li>";



//confirmation messages


$GLOBALS['strTrackerVarsHaveBeenUpdated'] = "حفظت تعديلات متغيرات المتتبع <a href='%s'>%s</a>";
$GLOBALS['strTrackerCampaignsHaveBeenUpdated'] = "حفظت تعديلات الحملات الإعلانية المرتبطة بالمتتبع <a href='%s'>%s</a>";
$GLOBALS['strTrackerAppendHasBeenUpdated'] = "حفظت تعديلات الكود الملحق بالمتتبع <a href='%s'>%s</a>";
$GLOBALS['strTrackerHasBeenDeleted'] = "حذف المتتبع <b>%s</b>";
$GLOBALS['strTrackersHaveBeenDeleted'] = "حذف جميع المتتبعات المحددة";
$GLOBALS['strTrackerHasBeenDuplicated'] = "نسخ المتتبع <a href='%s'>%s</a> إلى <a href='%s'>%s</a>";
$GLOBALS['strTrackerHasBeenMoved'] = "نقل المتتبع <b>%s</b> إلى المعلن <b>%s</b>";

$GLOBALS['strCampaignHasBeenAdded'] = "أضيفت الحملة الإعلانية <a href='%s'>%s</a>، <a href='%s'>أضف بنرا</a>";
$GLOBALS['strCampaignHasBeenUpdated'] = "حفظت تعديلات الحملة الإعلانية <a href='%s'>%s</a>";
$GLOBALS['strCampaignTrackersHaveBeenUpdated'] = "حفظت تعديلات المتتبعات المرتبطة بالحملة الإعلانية <a href='%s'>%s</a>";
$GLOBALS['strCampaignHasBeenDeleted'] = "حذفت الحملة الإعلانية <b>%s</b>";
$GLOBALS['strCampaignsHaveBeenDeleted'] = "حذف جميع الحملات الإعلانية المحددة";
$GLOBALS['strCampaignHasBeenDuplicated'] = "نسخت الحملة الإعلانية <a href='%s'>%s</a> إلى <a href='%s'>%s</a>";
$GLOBALS['strCampaignHasBeenMoved'] = "نقلت الحملة الإعلانية <b>%s</b> إلى المعلن <b>%s</b>";

$GLOBALS['strBannerHasBeenAdded'] = "أضيف البنر <a href='%s'>%s</a>";
$GLOBALS['strBannerHasBeenUpdated'] = "حفظت تعديلات البنر <a href='%s'>%s</a>";
$GLOBALS['strBannerAdvancedHasBeenUpdated'] = "حفظت تعديلات الإعدادات المتقدمة للبنر <a href='%s'>%s</a>";
$GLOBALS['strBannerAclHasBeenUpdated'] = "حفظت تعديلات خيارات توصيل البنر <a href='%s'>%s</a>";
$GLOBALS['strBannerAclHasBeenAppliedTo'] = "طبّقت خيارات توصيل البنر <a href='%s'>%s</a> على %d من البنرات";
$GLOBALS['strBannerHasBeenDeleted'] = "حذف البنر <b>%s</b>";
$GLOBALS['strBannersHaveBeenDeleted'] = "حذف جميع البنرات المحددة";
$GLOBALS['strBannerHasBeenDuplicated'] = "نسخ البنر <a href='%s'>%s</a> إلى <a href='%s'>%s</a>";
$GLOBALS['strBannerHasBeenMoved'] = "نقل البنر <b>%s</b> إلى الحملة الإعلانية <b>%s</b>";
$GLOBALS['strBannerHasBeenActivated'] = "أصبح البنر <a href='%s'>%s</a> نشطا";
$GLOBALS['strBannerHasBeenDeactivated'] = "أصبح البنر <a href='%s'>%s</a> غير نشط";

$GLOBALS['strXZonesLinked'] = "عدد مناطق العرض المرتبطة: <b>%s</b>";
$GLOBALS['strXZonesUnlinked'] = "عدد مناطق العرض التي ألغي ربطها: <b>%s</b>";

$GLOBALS['strWebsiteHasBeenAdded'] = "أضيف الموقع <a href='%s'>%s</a>، <a href='%s'>أضف منطقة عرض</a>";
$GLOBALS['strWebsiteHasBeenUpdated'] = "حفظت تعديلات الموقع <a href='%s'>%s</a>";
$GLOBALS['strWebsiteHasBeenDeleted'] = "حذف الموقع <b>%s</b>";
$GLOBALS['strWebsitesHaveBeenDeleted'] = "حذف جميع المواقع المحددة";
$GLOBALS['strWebsiteHasBeenDuplicated'] = "نسخ الموقع <a href='%s'>%s</a> إلى <a href='%s'>%s</a>";

$GLOBALS['strZoneHasBeenAdded'] = "أضيفت منطقة العرض <a href='%s'>%s</a>";
$GLOBALS['strZoneHasBeenUpdated'] = "حفظت تعديلات منطقة العرض <a href='%s'>%s</a>";
$GLOBALS['strZoneAdvancedHasBeenUpdated'] = "حفظت تعديلات الإعدادات المتقدمة لمنطقة العرض <a href='%s'>%s</a>";
$GLOBALS['strZoneHasBeenDeleted'] = "حذفت منطقة العرض <b>%s</b>";
$GLOBALS['strZonesHaveBeenDeleted'] = "حذف جميع مناطق العرض المحددة";
$GLOBALS['strZoneHasBeenDuplicated'] = "نسخت منطقة العرض <a href='%s'>%s</a> إلى <a href='%s'>%s</a>";
$GLOBALS['strZoneHasBeenMoved'] = "نقلت منطقة العرض <b>%s</b> إلى الموقع <b>%s</b>";
$GLOBALS['strZoneLinkedBanner'] = "ربط البنر بمنطقة العرض <a href='%s'>%s</a>";
$GLOBALS['strZoneLinkedCampaign'] = "ربطت الحملة الإعلانية بمنطقة العرض <a href='%s'>%s</a>";
$GLOBALS['strZoneRemovedBanner'] = "ألغي ربط البنر بمنطقة العرض <a href='%s'>%s</a>";
$GLOBALS['strZoneRemovedCampaign'] = "ألغي ربط الحملة الإعلانية بمنطقة العرض <a href='%s'>%s</a>";

$GLOBALS['strChannelHasBeenAdded'] = "أضيفت مجموعة قواعد التوصيل <a href='%s'>%s</a>. <a href='%s'>حدد قواعد التوصيل.</a>";
$GLOBALS['strChannelHasBeenUpdated'] = "حفظت تعديلات مجموعة قواعد التوصيل <a href='%s'>%s</a>";
$GLOBALS['strChannelAclHasBeenUpdated'] = "حفظت تعديلات خيارات التوصيل لمجموعة قواعد التوصيل <a href='%s'>%s</a>";
$GLOBALS['strChannelHasBeenDeleted'] = "حذفت مجموعة قواعد التوصيل <b>%s</b>";
$GLOBALS['strChannelsHaveBeenDeleted'] = "حذف جميع مجموعات قواعد التوصيل المحددة";
$GLOBALS['strChannelHasBeenDuplicated'] = "نسخت مجموعة قواعد التوصيل <a href='%s'>%s</a> إلى <a href='%s'>%s</a>";

$GLOBALS['strUserPreferencesUpdated'] = "حفظت تعديلات خيارات <b>%s</b>";

// Report error messages

/* ------------------------------------------------------- */
/* HTML5                                                   */
/* ------------------------------------------------------- */

/* ------------------------------------------------------- */
/* Password strength                                       */
/* ------------------------------------------------------- */


if (!isset($GLOBALS['strPasswordScore'])) {
    $GLOBALS['strPasswordScore'] = [];
}



/* ------------------------------------------------------- */
/* Keyboard shortcut assignments                           */
/* ------------------------------------------------------- */

// Reserved keys
// Do not change these unless absolutely needed
$GLOBALS['keyNextItem'] = ".";

// Other keys
// Please make sure you underline the key you
// used in the string in default.lang.php
