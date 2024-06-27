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
$GLOBALS['phpAds_CharSet'] = "";

$GLOBALS['phpAds_DecimalPoint'] = ".";
$GLOBALS['phpAds_ThousandsSeperator'] = "";

// Date & time configuration
$GLOBALS['date_format'] = "";
$GLOBALS['time_format'] = "";
$GLOBALS['minute_format'] = "";
$GLOBALS['month_format'] = "";
$GLOBALS['day_format'] = "";
$GLOBALS['week_format'] = "";
$GLOBALS['weekiso_format'] = "";

// Formats used by PEAR Spreadsheet_Excel_Writer packate
$GLOBALS['excel_integer_formatting'] = "";
$GLOBALS['excel_decimal_formatting'] = "";

/* ------------------------------------------------------- */
/* Translations                                          */
/* ------------------------------------------------------- */

$GLOBALS['strHome'] = "الصفحة الرّئيسية";
$GLOBALS['strHelp'] = "مساعدة";
$GLOBALS['strStartOver'] = "البدء من جديد";
$GLOBALS['strShortcuts'] = "الاختصارات";
$GLOBALS['strActions'] = "الفعل";
$GLOBALS['strAndXMore'] = "";
$GLOBALS['strAdminstration'] = "المخزن";
$GLOBALS['strMaintenance'] = "الصيانة";
$GLOBALS['strProbability'] = "الإحتماليات";
$GLOBALS['strInvocationcode'] = "كود التركيب";
$GLOBALS['strBasicInformation'] = "معلومات أساسية";
$GLOBALS['strAppendTrackerCode'] = "";
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
$GLOBALS['strFieldStartDateBeforeEnd'] = "";
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
$GLOBALS['strEnableCheckForUpdates'] = "";
// Dashboard Errors
$GLOBALS['strDashboardErrorCode'] = "";
$GLOBALS['strDashboardSystemMessage'] = "رسالة من النظام";
$GLOBALS['strDashboardErrorHelp'] = "إذا تكرر هذا الخطأ الرجاء وصف المشكلة بالتفصيل على <a href='http://forum.revive-adserver.com/'> forum.revive-adserver.com/</a>.";

// Priority
$GLOBALS['strPriority'] = "الأهمية";
$GLOBALS['strPriorityLevel'] = "مستوى الأهمية";
$GLOBALS['strOverrideAds'] = "تجاوز إعلانات الحملة";
$GLOBALS['strHighAds'] = "";
$GLOBALS['strECPMAds'] = "";
$GLOBALS['strLowAds'] = "";
$GLOBALS['strLimitations'] = "";
$GLOBALS['strNoLimitations'] = "";
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
$GLOBALS['strWorkingAs'] = "";
$GLOBALS['strWorkingAs_Key'] = "";
$GLOBALS['strWorkingAs'] = "";
$GLOBALS['strSwitchTo'] = "قم بالتبديل إلى";
$GLOBALS['strUseSearchBoxToFindMoreAccounts'] = "";
$GLOBALS['strWorkingFor'] = "";
$GLOBALS['strNoAccountWithXInNameFound'] = "";
$GLOBALS['strRecentlyUsed'] = "المستخدمة مؤخرا";
$GLOBALS['strLinkUser'] = "إضافة مستخدم";
$GLOBALS['strLinkUser_Key'] = "";
$GLOBALS['strUsernameToLink'] = "اسم المستخدم للاضافة";
$GLOBALS['strNewUserWillBeCreated'] = "سيتم خلق مستخدم جديد";
$GLOBALS['strToLinkProvideEmail'] = "لإضافة مستخدم، زود البريد الإلكتروني للمستخدم";
$GLOBALS['strToLinkProvideUsername'] = "لإضافة مستخدم، توفير اسم المستخدم";
$GLOBALS['strUserLinkedToAccount'] = "";
$GLOBALS['strUserLinkedAndWelcomeSent'] = "";
$GLOBALS['strUserAccountUpdated'] = "تم تحديث حساب المستخدم";
$GLOBALS['strUserUnlinkedFromAccount'] = "";
$GLOBALS['strUserWasDeleted'] = "تم حذف المستخدم";
$GLOBALS['strUserNotLinkedWithAccount'] = "هذا المستخدم غير مرتبط بحساب";
$GLOBALS['strCantDeleteOneAdminUser'] = "";
$GLOBALS['strLinkUserHelp'] = "";
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
$GLOBALS['strEnableCookies'] = "يجب عليك تفعيل الكوكيز قبل أن تستخدم {{PRODUCT_NAME}}";
$GLOBALS['strSessionIDNotMatch'] = "هنالك مشكلة في الكوكيز، الرجاء الدخول من جديد";
$GLOBALS['strLogin'] = "اسم الدخول";
$GLOBALS['strLogout'] = "تسجيل الخروج";
$GLOBALS['strUsername'] = "اسم المستخدم";
$GLOBALS['strPassword'] = "كلمة السر";
$GLOBALS['strPasswordRepeat'] = "قم بإعادة كتابة كلمة السر";
$GLOBALS['strAccessDenied'] = "الدخول ممنوع";
$GLOBALS['strUsernameOrPasswordWrong'] = "قمت بإدخال بيانات خاطئة في اسم المستخدم أو كلمة السر. الرجاء المحاولة مرة أخرى.";
$GLOBALS['strPasswordWrong'] = "كلمة السر غير صحيحة";
$GLOBALS['strNotAdmin'] = "الحساب الخاص بك ليس لديه الصلاحيات المطلوبة لاستخدام هذه الميزة، يمكنك تسجيل الدخول إلى حساب آخر لاستخدامها.";
$GLOBALS['strDuplicateClientName'] = "اسم المستخدم الذي أدخلته موجود مسبقاً ، الرجاء اختيار اسم آخر.";
$GLOBALS['strInvalidPassword'] = "كلمة السر الجديدة غير صالحة ، الرجاء اختيار كلمة سر أخرى.";
$GLOBALS['strInvalidEmail'] = "البريد الإلكتروني غير منسق، الرجاء وضع عنوان البريد إلكتروني صحيح.";
$GLOBALS['strNotSamePasswords'] = "كلمتا السر التي قمت بإدخالهما غير متطابقتين";
$GLOBALS['strRepeatPassword'] = "قم بإعادة كتابة كلمة السر";
$GLOBALS['strDeadLink'] = "الرابط الخاص بك غير صالح.";
$GLOBALS['strNoPlacement'] = "";
$GLOBALS['strNoAdvertiser'] = "";

// General advertising
$GLOBALS['strRequests'] = "الطلبات";
$GLOBALS['strImpressions'] = "مرات الظهور";
$GLOBALS['strClicks'] = "الضغطات";
$GLOBALS['strConversions'] = "التحويل";
$GLOBALS['strCTRShort'] = "معدل الضغطات";
$GLOBALS['strCNVRShort'] = "";
$GLOBALS['strCTR'] = "معدل الضغطات";
$GLOBALS['strTotalClicks'] = "مجموع الضغطات";
$GLOBALS['strTotalConversions'] = "مجموع التحويلات";
$GLOBALS['strDateTime'] = "التاريخ الوقت";
$GLOBALS['strTrackerID'] = "رقم المتتبع";
$GLOBALS['strTrackerName'] = "اسم المتتبع";
$GLOBALS['strTrackerImageTag'] = "";
$GLOBALS['strTrackerJsTag'] = "";
$GLOBALS['strTrackerAlwaysAppend'] = "";
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
$GLOBALS['strFinanceCR'] = "";

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
$GLOBALS['strClientHistory'] = "";
$GLOBALS['strNoClients'] = "لا يوجد معلنين حتى الآن. لإضافة حملة إعلانية، يجب <a href='advertiser-edit.php'>إضافة معلن</a> قبل ذلك.";
$GLOBALS['strConfirmDeleteClient'] = "هل أنت متأكد من رغبتك في حذف هذا المعلن ؟";
$GLOBALS['strConfirmDeleteClients'] = "هل أنت متأكد من رغبتك في حذف هذا المعلن ؟";
$GLOBALS['strHideInactive'] = "إخفاء الغير فعّال";
$GLOBALS['strInactiveAdvertisersHidden'] = "المعلنين غير النشطين تم إخفائهم";
$GLOBALS['strAdvertiserSignup'] = "";
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
$GLOBALS['strAllowCreateAccounts'] = "";
$GLOBALS['strAdvertiserLimitation'] = "";
$GLOBALS['strAllowAuditTrailAccess'] = "السماح لهذا المستخدم الوصول إلى سجل المراجعة";
$GLOBALS['strAllowDeleteItems'] = "";

// Campaign
$GLOBALS['strCampaign'] = "الحملة الإعلانية";
$GLOBALS['strCampaigns'] = "الحملة الإعلانية";
$GLOBALS['strAddCampaign'] = "إضافة حملة إعلانية";
$GLOBALS['strAddCampaign_Key'] = "إضافة حملة إعلانية";
$GLOBALS['strCampaignForAdvertiser'] = "للمعلن";
$GLOBALS['strLinkedCampaigns'] = "الحملات الاعلانية المرتبطة";
$GLOBALS['strCampaignProperties'] = "خواص الحملة الإعلانية";
$GLOBALS['strCampaignOverview'] = "نظرة عامة على الحملة الإعلانية";
$GLOBALS['strCampaignHistory'] = "";
$GLOBALS['strNoCampaigns'] = "لا يوجد حاليا حملات لهذا المعلن.";
$GLOBALS['strNoCampaignsAddAdvertiser'] = "";
$GLOBALS['strConfirmDeleteCampaign'] = "هل تريد حذف هذه الحملة الاعلانية ؟";
$GLOBALS['strConfirmDeleteCampaigns'] = "هل تريد حذف هذه الحملة الاعلانية ؟";
$GLOBALS['strShowParentAdvertisers'] = "عرض المعلنين الرئيسيين";
$GLOBALS['strHideParentAdvertisers'] = "إخفاء المعلنين الرئيسيين";
$GLOBALS['strHideInactiveCampaigns'] = "إخفاء الحملات الاعلانية غير النشطة";
$GLOBALS['strInactiveCampaignsHidden'] = "تم إخفاء الحملات الاعلانية غير النشطة";
$GLOBALS['strPriorityInformation'] = "الأهمية مقارنة بالحملات الإعلانية الأخرى";
$GLOBALS['strECPMInformation'] = "";
$GLOBALS['strRemnantEcpmDescription'] = "";
$GLOBALS['strEcpmMinImpsDescription'] = "";
$GLOBALS['strHiddenCampaign'] = "الحملة الإعلانية";
$GLOBALS['strHiddenAd'] = "الاعلانات";
$GLOBALS['strHiddenAdvertiser'] = "المعلن";
$GLOBALS['strHiddenTracker'] = "المتتبع";
$GLOBALS['strHiddenWebsite'] = "الموقع";
$GLOBALS['strHiddenZone'] = "المنطقة";
$GLOBALS['strCampaignDelivery'] = "";
$GLOBALS['strCompanionPositioning'] = "";
$GLOBALS['strSelectUnselectAll'] = "اختيار/عدم اختيار الكل";
$GLOBALS['strCampaignsOfAdvertiser'] = ""; //this is added between page name and advertiser name eg. 'Campaigns of Advertiser 1'
$GLOBALS['strShowCappedNoCookie'] = "";

// Campaign-zone linking page
$GLOBALS['strCalculatedForAllCampaigns'] = "";
$GLOBALS['strCalculatedForThisCampaign'] = "";
$GLOBALS['strLinkingZonesProblem'] = "";
$GLOBALS['strUnlinkingZonesProblem'] = "";
$GLOBALS['strZonesLinked'] = "";
$GLOBALS['strZonesUnlinked'] = "";
$GLOBALS['strZonesSearch'] = "";
$GLOBALS['strZonesSearchTitle'] = "";
$GLOBALS['strNoWebsitesAndZones'] = "";
$GLOBALS['strNoWebsitesAndZonesText'] = "";
$GLOBALS['strToLink'] = "";
$GLOBALS['strToUnlink'] = "";
$GLOBALS['strLinked'] = "";
$GLOBALS['strAvailable'] = "موجود";
$GLOBALS['strShowing'] = "";
$GLOBALS['strEditZone'] = "";
$GLOBALS['strEditWebsite'] = "";


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
$GLOBALS['strCampaignWeight'] = "";
$GLOBALS['strAnonymous'] = "إخفاء المعلن و المواقع لهذه الحملة الاعلانية";
$GLOBALS['strTargetPerDay'] = "في اليوم";
$GLOBALS['strCampaignWarningRemnantNoWeight'] = "أهمية هذه الحملة تم تحديدها كمنخفضة، 
ولكن الوزن تم تحديده كصفر أو لم يتم تحديده.
هذا الأمر سيجعل الحملة غير نشطة
و لن يتم عرض الإعلانات الموجودة فيها
حتى يتم تعديل الوزن إلى رقم صحيح.

هل أنت متأكد من رغبتك في المواصلة؟";
$GLOBALS['strCampaignWarningEcpmNoRevenue'] = "";
$GLOBALS['strCampaignWarningOverrideNoWeight'] = "";
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
$GLOBALS['strOverride'] = "";
$GLOBALS['strOverrideInfo'] = "";
$GLOBALS['strStandardContract'] = "الاتصال";
$GLOBALS['strStandardContractInfo'] = "";
$GLOBALS['strRemnant'] = "";
$GLOBALS['strRemnantInfo'] = "";
$GLOBALS['strECPMInfo'] = "";
$GLOBALS['strPricing'] = "";
$GLOBALS['strPricingModel'] = "";
$GLOBALS['strSelectPricingModel'] = "";
$GLOBALS['strRatePrice'] = "";
$GLOBALS['strMinimumImpressions'] = "";
$GLOBALS['strLimit'] = "";
$GLOBALS['strLowExclusiveDisabled'] = "";
$GLOBALS['strCannotSetBothDateAndLimit'] = "";
$GLOBALS['strWhyDisabled'] = "";
$GLOBALS['strBackToCampaigns'] = "";
$GLOBALS['strCampaignBanners'] = "";
$GLOBALS['strCookies'] = "";

// Tracker
$GLOBALS['strTracker'] = "المتتبع";
$GLOBALS['strTrackers'] = "المتتبع";
$GLOBALS['strTrackerPreferences'] = "الخيارات العامة";
$GLOBALS['strAddTracker'] = "إضافة متتبع جديد";
$GLOBALS['strTrackerForAdvertiser'] = "للمعلن";
$GLOBALS['strNoTrackers'] = "";
$GLOBALS['strConfirmDeleteTrackers'] = "هل تريد حذف هذا المتتبع ؟";
$GLOBALS['strConfirmDeleteTracker'] = "هل تريد حذف هذا المتتبع ؟";
$GLOBALS['strTrackerProperties'] = "خواص المتتبع";
$GLOBALS['strDefaultStatus'] = "الحالة الافتراضية";
$GLOBALS['strStatus'] = "الحالة";
$GLOBALS['strLinkedTrackers'] = "المتتبعات المرتبطة";
$GLOBALS['strTrackerInformation'] = "";
$GLOBALS['strConversionWindow'] = "نافذة التحويل";
$GLOBALS['strUniqueWindow'] = "ناقذة فريدة";
$GLOBALS['strClick'] = "ضغطة";
$GLOBALS['strView'] = "عرض";
$GLOBALS['strArrival'] = "";
$GLOBALS['strManual'] = "";
$GLOBALS['strImpression'] = "مرات الظهور";
$GLOBALS['strConversionType'] = "نوع التحويل";
$GLOBALS['strLinkCampaignsByDefault'] = "ربط الحملات الاعلانية الجديدة افتراضياً";
$GLOBALS['strBackToTrackers'] = "";
$GLOBALS['strIPAddress'] = "";

// Banners (General)
$GLOBALS['strBanner'] = "بنر";
$GLOBALS['strBanners'] = "بنرات";
$GLOBALS['strAddBanner'] = "إضافة بنر جديد";
$GLOBALS['strAddBanner_Key'] = "إضافة بنر جديد";
$GLOBALS['strBannerToCampaign'] = "";
$GLOBALS['strShowBanner'] = "عرض البنر";
$GLOBALS['strBannerProperties'] = "خواص البنر";
$GLOBALS['strBannerHistory'] = "";
$GLOBALS['strNoBanners'] = "";
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
$GLOBALS['strBannersOfCampaign'] = ""; //this is added between page name and campaign name eg. 'Banners in coca cola campaign'

// Banner Preferences
$GLOBALS['strBannerPreferences'] = "الخيارات العامة";
$GLOBALS['strCampaignPreferences'] = "";
$GLOBALS['strDefaultBanners'] = "البنر الافتراضي";
$GLOBALS['strDefaultBannerUrl'] = "الصورة الافتراضية";
$GLOBALS['strDefaultBannerDestination'] = "الرابط الافتراضي";
$GLOBALS['strAllowedBannerTypes'] = "أنواع البنرات المسموحة";
$GLOBALS['strTypeSqlAllow'] = "";
$GLOBALS['strTypeWebAllow'] = "";
$GLOBALS['strTypeUrlAllow'] = "إتاحة البنرات الخارجية";
$GLOBALS['strTypeHtmlAllow'] = "إتاحة بنرات HTML";
$GLOBALS['strTypeTxtAllow'] = "إتاحة الاعلانات النصية";

// Banner (Properties)
$GLOBALS['strChooseBanner'] = "الرجاء اختيار نوع البنر";
$GLOBALS['strMySQLBanner'] = "";
$GLOBALS['strWebBanner'] = "";
$GLOBALS['strURLBanner'] = "";
$GLOBALS['strHTMLBanner'] = "";
$GLOBALS['strTextBanner'] = "";
$GLOBALS['strAlterHTML'] = "";
$GLOBALS['strIframeFriendly'] = "";
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
$GLOBALS['strCampaignsWeight'] = "";
$GLOBALS['strBannerWeight'] = "وزن البنر";
$GLOBALS['strBannersWeight'] = "";
$GLOBALS['strAdserverTypeGeneric'] = "بنر HTML عام";
$GLOBALS['strDoNotAlterHtml'] = "";
$GLOBALS['strGenericOutputAdServer'] = "عام";
$GLOBALS['strBackToBanners'] = "";
$GLOBALS['strUseWyswygHtmlEditor'] = "";
$GLOBALS['strChangeDefault'] = "";

// Banner (advanced)
$GLOBALS['strBannerPrependHTML'] = "";
$GLOBALS['strBannerAppendHTML'] = "";

// Display Delviery Rules
$GLOBALS['strModifyBannerAcl'] = "خيارات التوصيل";
$GLOBALS['strACL'] = "خيارات التوصيل";
$GLOBALS['strACLAdd'] = "";
$GLOBALS['strApplyLimitationsTo'] = "";
$GLOBALS['strAllBannersInCampaign'] = "";
$GLOBALS['strRemoveAllLimitations'] = "";
$GLOBALS['strEqualTo'] = "يساوي";
$GLOBALS['strDifferentFrom'] = "مختلف عن";
$GLOBALS['strLaterThan'] = "أحدث من";
$GLOBALS['strLaterThanOrEqual'] = "أحدث من أو يساوي";
$GLOBALS['strEarlierThan'] = "أقدم من";
$GLOBALS['strEarlierThanOrEqual'] = "أقدم من أو يساوي";
$GLOBALS['strContains'] = "";
$GLOBALS['strNotContains'] = "";
$GLOBALS['strGreaterThan'] = "أكبر من";
$GLOBALS['strLessThan'] = "أصغر من";
$GLOBALS['strGreaterOrEqualTo'] = "";
$GLOBALS['strLessOrEqualTo'] = "";
$GLOBALS['strAND'] = "و";                          // logical operator
$GLOBALS['strOR'] = "أو";                         // logical operator
$GLOBALS['strOnlyDisplayWhen'] = "إعرض البنر فقط عندما";
$GLOBALS['strWeekDays'] = "أيام الاسبوع";
$GLOBALS['strTime'] = "الوقت";
$GLOBALS['strDomain'] = "";
$GLOBALS['strSource'] = "المصدر";
$GLOBALS['strBrowser'] = "";
$GLOBALS['strOS'] = "";
$GLOBALS['strDeliveryLimitations'] = "";

$GLOBALS['strDeliveryCappingReset'] = "قم بتصفير العداد بعد :";
$GLOBALS['strDeliveryCappingTotal'] = "في المجموع";
$GLOBALS['strDeliveryCappingSession'] = "كل جلسة";

if (!isset($GLOBALS['strCappingBanner'])) {
    $GLOBALS['strCappingBanner'] = [];
}
$GLOBALS['strCappingBanner']['title'] = "";
$GLOBALS['strCappingBanner']['limit'] = "تحديد عرض الإعلانات إلى:";

if (!isset($GLOBALS['strCappingCampaign'])) {
    $GLOBALS['strCappingCampaign'] = [];
}
$GLOBALS['strCappingCampaign']['title'] = "";
$GLOBALS['strCappingCampaign']['limit'] = "تحديد عرض الحملة الإعلانية إلى:";

if (!isset($GLOBALS['strCappingZone'])) {
    $GLOBALS['strCappingZone'] = [];
}
$GLOBALS['strCappingZone']['title'] = "";
$GLOBALS['strCappingZone']['limit'] = "تحديد عرض المنطقة الإعلانية إلى:";

// Website
$GLOBALS['strAffiliate'] = "الموقع";
$GLOBALS['strAffiliates'] = "المواقع";
$GLOBALS['strAffiliatesAndZones'] = "المواقع و مناطق العرض";
$GLOBALS['strAddNewAffiliate'] = "إضافة موقع جديد";
$GLOBALS['strAffiliateProperties'] = "خواص الموقع";
$GLOBALS['strAffiliateHistory'] = "";
$GLOBALS['strNoAffiliates'] = "لا يوجد حتى الآن أية مواقع. لإضافة منطقة إعلانية، يجب <a href='affiliate-edit.php'>إضافة موقع جديد</a> قبل ذلك.";
$GLOBALS['strConfirmDeleteAffiliate'] = "هل تريد حذف هذا الموقع؟";
$GLOBALS['strConfirmDeleteAffiliates'] = "هل تريد حذف هذا الموقع؟";
$GLOBALS['strInactiveAffiliatesHidden'] = "تم إخفاء المواقع غير النشطة";
$GLOBALS['strShowParentAffiliates'] = "عرض المواقع الرئيسية";
$GLOBALS['strHideParentAffiliates'] = "إخفاء المواقع الرئيسية";

// Website (properties)
$GLOBALS['strWebsite'] = "الموقع";
$GLOBALS['strWebsiteURL'] = "";
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
$GLOBALS['strAvailableZones'] = "";
$GLOBALS['strLinkingNotSuccess'] = "";
$GLOBALS['strZoneProperties'] = "خواص منطقة العرض";
$GLOBALS['strZoneHistory'] = "سجل منطقة العرض";
$GLOBALS['strNoZones'] = "";
$GLOBALS['strNoZonesAddWebsite'] = "لا يوجد حتى الآن أية مواقع. لإضافة منطقة إعلانية، يجب <a href='affiliate-edit.php'>إضافة موقع جديد</a> قبل ذلك.";
$GLOBALS['strConfirmDeleteZone'] = "هل تريد حذف منطقة العرض ؟";
$GLOBALS['strConfirmDeleteZones'] = "هل تريد حذف منطقة العرض ؟";
$GLOBALS['strConfirmDeleteZoneLinkActive'] = "";
$GLOBALS['strZoneType'] = "نوع منطقة العرض";
$GLOBALS['strBannerButtonRectangle'] = "بنر";
$GLOBALS['strInterstitial'] = "ضمن المحتوى";
$GLOBALS['strPopup'] = "نافذة منبثقة";
$GLOBALS['strTextAdZone'] = "اعلان نصي";
$GLOBALS['strEmailAdZone'] = "بريد الكتروني/قائمة مراسلات";
$GLOBALS['strZoneVideoInstream'] = "";
$GLOBALS['strZoneVideoOverlay'] = "";
$GLOBALS['strShowMatchingBanners'] = "عرض البنرات المطابقة";
$GLOBALS['strHideMatchingBanners'] = "إخفاء البنرات المطابقة";
$GLOBALS['strBannerLinkedAds'] = "البنرات المرتبطة بمنطقة العرض هذه";
$GLOBALS['strCampaignLinkedAds'] = "الحملات الاعلانية المرتبطة بمنطقة العرض هذه";
$GLOBALS['strInactiveZonesHidden'] = "تم إخفاء مناطق العرض غير النشطة";
$GLOBALS['strWarnChangeZoneType'] = "";
$GLOBALS['strWarnChangeZoneSize'] = '';
$GLOBALS['strWarnChangeBannerSize'] = '';
$GLOBALS['strWarnBannerReadonly'] = '';
$GLOBALS['strZonesOfWebsite'] = ''; //this is added between page name and website name eg. 'Zones in www.example.com'
$GLOBALS['strBackToZones'] = "";

$GLOBALS['strIab']['IAB_FullBanner(468x60)'] = "";
$GLOBALS['strIab']['IAB_Skyscraper(120x600)'] = "";
$GLOBALS['strIab']['IAB_Leaderboard(728x90)'] = "";
$GLOBALS['strIab']['IAB_Button1(120x90)'] = "";
$GLOBALS['strIab']['IAB_Button2(120x60)'] = "";
$GLOBALS['strIab']['IAB_HalfBanner(234x60)'] = "";
$GLOBALS['strIab']['IAB_MicroBar(88x31)'] = "";
$GLOBALS['strIab']['IAB_SquareButton(125x125)'] = "";
$GLOBALS['strIab']['IAB_Rectangle(180x150)*'] = "";
$GLOBALS['strIab']['IAB_SquarePop-up(250x250)'] = "";
$GLOBALS['strIab']['IAB_VerticalBanner(120x240)'] = "";
$GLOBALS['strIab']['IAB_MediumRectangle(300x250)*'] = "";
$GLOBALS['strIab']['IAB_LargeRectangle(336x280)'] = "";
$GLOBALS['strIab']['IAB_VerticalRectangle(240x400)'] = "";
$GLOBALS['strIab']['IAB_WideSkyscraper(160x600)*'] = "";
$GLOBALS['strIab']['IAB_Pop-Under(720x300)'] = "";
$GLOBALS['strIab']['IAB_3:1Rectangle(300x100)'] = "";

// Advanced zone settings
$GLOBALS['strAdvanced'] = "متقدم";
$GLOBALS['strChainSettings'] = "";
$GLOBALS['strZoneNoDelivery'] = "";
$GLOBALS['strZoneStopDelivery'] = "إيقاف العرض و عدم عرض أي بنر";
$GLOBALS['strZoneOtherZone'] = "ستخدم منطقة العرض كـ بديل";
$GLOBALS['strZoneAppend'] = "";
$GLOBALS['strAppendSettings'] = "";
$GLOBALS['strZonePrependHTML'] = "";
$GLOBALS['strZoneAppendNoBanner'] = "";
$GLOBALS['strZoneAppendHTMLCode'] = "كود HTML";
$GLOBALS['strZoneAppendZoneSelection'] = "نافذة منبثقة أو ضمن النص";

// Zone probability
$GLOBALS['strZoneProbListChain'] = "";
$GLOBALS['strZoneProbNullPri'] = "";
$GLOBALS['strZoneProbListChainLoop'] = "";

// Linked banners/campaigns/trackers
$GLOBALS['strSelectZoneType'] = "";
$GLOBALS['strLinkedBanners'] = "ربط بنرات منفردة";
$GLOBALS['strCampaignDefaults'] = "ربط بنرات عبر الحملة الاعلانية";
$GLOBALS['strLinkedCategories'] = "ربط بنرات حسب التصنيف";
$GLOBALS['strWithXBanners'] = "";
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
$GLOBALS['strSelectPublisher'] = "";
$GLOBALS['strSelectZone'] = "إختيار المنطقة";
$GLOBALS['strStatusPending'] = "بانتظار الموافقة";
$GLOBALS['strStatusApproved'] = "تمت الموافقة";
$GLOBALS['strStatusDisapproved'] = "لم تتم الموافقة";
$GLOBALS['strStatusDuplicate'] = "نسخ";
$GLOBALS['strStatusOnHold'] = "";
$GLOBALS['strStatusIgnore'] = "تجاهل";
$GLOBALS['strConnectionType'] = "النوع";
$GLOBALS['strConnTypeSale'] = "حفظ";
$GLOBALS['strConnTypeLead'] = "";
$GLOBALS['strConnTypeSignUp'] = "تسجيل جديد";
$GLOBALS['strShortcutEditStatuses'] = "تعديل الحالات";
$GLOBALS['strShortcutShowStatuses'] = "عرض الحالات";

// Statistics
$GLOBALS['strStats'] = "";
$GLOBALS['strNoStats'] = "لا تتوفر إحصائيات حالياً";
$GLOBALS['strNoStatsForPeriod'] = "";
$GLOBALS['strGlobalHistory'] = "";
$GLOBALS['strDailyHistory'] = "";
$GLOBALS['strDailyStats'] = "";
$GLOBALS['strWeeklyHistory'] = "";
$GLOBALS['strMonthlyHistory'] = "";
$GLOBALS['strTotalThisPeriod'] = "المجموع لهذه الفترة";
$GLOBALS['strPublisherDistribution'] = "";
$GLOBALS['strCampaignDistribution'] = "";
$GLOBALS['strViewBreakdown'] = "عرض حسب";
$GLOBALS['strBreakdownByDay'] = "يوم";
$GLOBALS['strBreakdownByWeek'] = "اسبوع";
$GLOBALS['strBreakdownByMonth'] = "شهر";
$GLOBALS['strBreakdownByDow'] = "اليوم من الأسبوع";
$GLOBALS['strBreakdownByHour'] = "الساعة";
$GLOBALS['strItemsPerPage'] = "عدد العناصر في الصفحة";
$GLOBALS['strDistributionHistoryCampaign'] = "";
$GLOBALS['strDistributionHistoryBanner'] = "";
$GLOBALS['strDistributionHistoryWebsite'] = "";
$GLOBALS['strDistributionHistoryZone'] = "";
$GLOBALS['strShowGraphOfStatistics'] = "عرض مخطط بياني للاحصائيات";
$GLOBALS['strExportStatisticsToExcel'] = "تصدير الاحصائيات الى Excel";
$GLOBALS['strGDnotEnabled'] = "";
$GLOBALS['strStatsArea'] = "";

// Expiration
$GLOBALS['strNoExpiration'] = "لم يتم تحديد تاريخ الانتهاء";
$GLOBALS['strEstimated'] = "تاريخ الانتهاء المتوقع";
$GLOBALS['strNoExpirationEstimation'] = "";
$GLOBALS['strDaysAgo'] = "";
$GLOBALS['strCampaignStop'] = "سجل الحملة الإعلانية";

// Reports
$GLOBALS['strAdvancedReports'] = "";
$GLOBALS['strStartDate'] = "تاريخ البداية";
$GLOBALS['strEndDate'] = "تاريخ النهاية";
$GLOBALS['strPeriod'] = "";
$GLOBALS['strLimitations'] = "";
$GLOBALS['strWorksheets'] = "";

// Admin_UI_Fields
$GLOBALS['strAllAdvertisers'] = "كل المعلنين";
$GLOBALS['strAnonAdvertisers'] = "";
$GLOBALS['strAllPublishers'] = "كل المواقع";
$GLOBALS['strAnonPublishers'] = "";
$GLOBALS['strAllAvailZones'] = "كل مناطق العرض المتوفرة";

// Userlog
$GLOBALS['strUserLog'] = "سجل المستخدم";
$GLOBALS['strUserLogDetails'] = "تفاصيل سجل المستخدم";
$GLOBALS['strDeleteLog'] = "حذف السجل";
$GLOBALS['strAction'] = "الفعل";
$GLOBALS['strNoActionsLogged'] = "";

// Code generation
$GLOBALS['strGenerateBannercode'] = "اختيار مباشر";
$GLOBALS['strChooseInvocationType'] = "الرجاء اختيار نوع البنر";
$GLOBALS['strGenerate'] = "إنشاء";
$GLOBALS['strParameters'] = "";
$GLOBALS['strFrameSize'] = "حجم الاطار";
$GLOBALS['strBannercode'] = "كود البنر";
$GLOBALS['strTrackercode'] = "";
$GLOBALS['strBackToTheList'] = "العودة لقائمة التقارير";
$GLOBALS['strCharset'] = "";
$GLOBALS['strAutoDetect'] = "";
$GLOBALS['strCacheBusterComment'] = "";
$GLOBALS['strGenerateHttpsTags'] = "";

// Errors
$GLOBALS['strErrorDatabaseConnection'] = "";
$GLOBALS['strErrorCantConnectToDatabase'] = "";
$GLOBALS['strNoMatchesFound'] = "";
$GLOBALS['strErrorOccurred'] = "حدث خطأ ما";
$GLOBALS['strErrorDBPlain'] = "";
$GLOBALS['strErrorDBSerious'] = "";
$GLOBALS['strErrorDBNoDataPlain'] = "";
$GLOBALS['strErrorDBNoDataSerious'] = "";
$GLOBALS['strErrorDBCorrupt'] = "";
$GLOBALS['strErrorDBContact'] = "";
$GLOBALS['strErrorDBSubmitBug'] = "";
$GLOBALS['strMaintenanceNotActive'] = "";
$GLOBALS['strErrorLinkingBanner'] = "";
$GLOBALS['strUnableToLinkBanner'] = "";
$GLOBALS['strErrorEditingCampaignRevenue'] = "";
$GLOBALS['strErrorEditingCampaignECPM'] = "";
$GLOBALS['strErrorEditingZone'] = "";
$GLOBALS['strUnableToChangeZone'] = "";
$GLOBALS['strDatesConflict'] = "";
$GLOBALS['strEmailNoDates'] = "";
$GLOBALS['strWarningInaccurateStats'] = "";
$GLOBALS['strWarningInaccurateReadMore'] = "";
$GLOBALS['strWarningInaccurateReport'] = "";

//Validation
$GLOBALS['strRequiredFieldLegend'] = "";
$GLOBALS['strFormContainsErrors'] = "";
$GLOBALS['strXRequiredField'] = "";
$GLOBALS['strEmailField'] = "";
$GLOBALS['strNumericField'] = "";
$GLOBALS['strGreaterThanZeroField'] = "";
$GLOBALS['strXGreaterThanZeroField'] = "";
$GLOBALS['strXPositiveWholeNumberField'] = "";
$GLOBALS['strInvalidWebsiteURL'] = "";

// Email
$GLOBALS['strSirMadam'] = "";
$GLOBALS['strMailSubject'] = "";
$GLOBALS['strMailHeader'] = "";
$GLOBALS['strMailBannerStats'] = "";
$GLOBALS['strMailBannerActivatedSubject'] = "";
$GLOBALS['strMailBannerDeactivatedSubject'] = "";
$GLOBALS['strMailBannerActivated'] = "";
$GLOBALS['strMailBannerDeactivated'] = "";
$GLOBALS['strMailFooter'] = "";
$GLOBALS['strClientDeactivated'] = "";
$GLOBALS['strBeforeActivate'] = "";
$GLOBALS['strAfterExpire'] = "";
$GLOBALS['strNoMoreImpressions'] = "";
$GLOBALS['strNoMoreClicks'] = "";
$GLOBALS['strNoMoreConversions'] = "";
$GLOBALS['strWeightIsNull'] = "";
$GLOBALS['strRevenueIsNull'] = "";
$GLOBALS['strTargetIsNull'] = "";
$GLOBALS['strNoViewLoggedInInterval'] = "";
$GLOBALS['strNoClickLoggedInInterval'] = "";
$GLOBALS['strNoConversionLoggedInInterval'] = "";
$GLOBALS['strMailReportPeriod'] = "";
$GLOBALS['strMailReportPeriodAll'] = "";
$GLOBALS['strNoStatsForCampaign'] = "";
$GLOBALS['strImpendingCampaignExpiry'] = "";
$GLOBALS['strYourCampaign'] = "";
$GLOBALS['strTheCampiaignBelongingTo'] = "";
$GLOBALS['strImpendingCampaignExpiryDateBody'] = "";
$GLOBALS['strImpendingCampaignExpiryImpsBody'] = "";
$GLOBALS['strImpendingCampaignExpiryBody'] = "";

// Priority
$GLOBALS['strPriority'] = "الأهمية";
$GLOBALS['strSourceEdit'] = "";

// Preferences
$GLOBALS['strPreferences'] = "الخيارات";
$GLOBALS['strUserPreferences'] = "الخيارات العامة";
$GLOBALS['strChangePassword'] = "تغيير كلمة المرور";
$GLOBALS['strChangeEmail'] = "";
$GLOBALS['strCurrentPassword'] = "كلمة المرور الحالية";
$GLOBALS['strChooseNewPassword'] = "كلمة المرور الجديدة";
$GLOBALS['strReenterNewPassword'] = "إعادة كتابة كلمة المرور الجديدة";
$GLOBALS['strNameLanguage'] = "الإسم و اللغة";
$GLOBALS['strAccountPreferences'] = "خيارات الحساب";
$GLOBALS['strCampaignEmailReportsPreferences'] = "خيارات التقارير الخاصة بالحملة الإعلانية";
$GLOBALS['strTimezonePreferences'] = "";
$GLOBALS['strAdminEmailWarnings'] = "البريد الالكتروني للمدير العام";
$GLOBALS['strAgencyEmailWarnings'] = "التنبيهات البريدية للوكالة الإعلانية";
$GLOBALS['strAdveEmailWarnings'] = "التنبيهات البريدية للمعلنين";
$GLOBALS['strFullName'] = "الإسم الكامل";
$GLOBALS['strEmailAddress'] = "البريد الإلكتروني";
$GLOBALS['strUserDetails'] = "معلومات العضو";
$GLOBALS['strUserInterfacePreferences'] = "خيارات شكل لوحة التحكم";
$GLOBALS['strPluginPreferences'] = "الخيارات العامة";
$GLOBALS['strColumnName'] = "";
$GLOBALS['strShowColumn'] = "";
$GLOBALS['strCustomColumnName'] = "";
$GLOBALS['strColumnRank'] = "";

// Long names
$GLOBALS['strRevenue'] = "";
$GLOBALS['strNumberOfItems'] = "";
$GLOBALS['strRevenueCPC'] = "";
$GLOBALS['strERPM'] = "تكلفة الظهور";
$GLOBALS['strERPC'] = "تكلفة الضغطات";
$GLOBALS['strERPS'] = "تكلفة الظهور";
$GLOBALS['strEIPM'] = "تكلفة الظهور";
$GLOBALS['strEIPC'] = "تكلفة الضغطات";
$GLOBALS['strEIPS'] = "تكلفة الظهور";
$GLOBALS['strECPM'] = "تكلفة الظهور";
$GLOBALS['strECPC'] = "تكلفة الضغطات";
$GLOBALS['strECPS'] = "تكلفة الظهور";
$GLOBALS['strPendingConversions'] = "";
$GLOBALS['strImpressionSR'] = "مرات الظهور";
$GLOBALS['strClickSR'] = "";

// Short names
$GLOBALS['strRevenue_short'] = "";
$GLOBALS['strBasketValue_short'] = "";
$GLOBALS['strNumberOfItems_short'] = "";
$GLOBALS['strRevenueCPC_short'] = "";
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
$GLOBALS['strRequests_short'] = "";
$GLOBALS['strImpressions_short'] = "";
$GLOBALS['strClicks_short'] = "الضغطات";
$GLOBALS['strCTR_short'] = "معدل الضغطات";
$GLOBALS['strConversions_short'] = "";
$GLOBALS['strPendingConversions_short'] = "";
$GLOBALS['strImpressionSR_short'] = "";
$GLOBALS['strClickSR_short'] = "";

// Global Settings
$GLOBALS['strConfiguration'] = "";
$GLOBALS['strGlobalSettings'] = "الإعدادات العامة";
$GLOBALS['strGeneralSettings'] = "الإعدادات العامة";
$GLOBALS['strMainSettings'] = "";
$GLOBALS['strPlugins'] = "";
$GLOBALS['strChooseSection'] = 'إختيار قسم';

// Product Updates
$GLOBALS['strProductUpdates'] = "";
$GLOBALS['strViewPastUpdates'] = "";
$GLOBALS['strFromVersion'] = "";
$GLOBALS['strToVersion'] = "";
$GLOBALS['strToggleDataBackupDetails'] = "";
$GLOBALS['strClickViewBackupDetails'] = "";
$GLOBALS['strClickHideBackupDetails'] = "";
$GLOBALS['strShowBackupDetails'] = "";
$GLOBALS['strHideBackupDetails'] = "";
$GLOBALS['strBackupDeleteConfirm'] = "";
$GLOBALS['strDeleteArtifacts'] = "";
$GLOBALS['strArtifacts'] = "";
$GLOBALS['strBackupDbTables'] = "";
$GLOBALS['strLogFiles'] = "";
$GLOBALS['strConfigBackups'] = "";
$GLOBALS['strUpdatedDbVersionStamp'] = "";
$GLOBALS['aProductStatus']['UPGRADE_COMPLETE'] = "";
$GLOBALS['aProductStatus']['UPGRADE_FAILED'] = "";

// Agency
$GLOBALS['strAgencyManagement'] = "";
$GLOBALS['strAgency'] = "";
$GLOBALS['strAddAgency'] = "";
$GLOBALS['strAddAgency_Key'] = "إضافة منطقة عرض جديدة";
$GLOBALS['strTotalAgencies'] = "";
$GLOBALS['strAgencyProperties'] = "";
$GLOBALS['strNoAgencies'] = "لم يتم تعريف أي منطقة عرض";
$GLOBALS['strConfirmDeleteAgency'] = "هل تريد حذف منطقة العرض ؟";
$GLOBALS['strHideInactiveAgencies'] = "";
$GLOBALS['strInactiveAgenciesHidden'] = "تم إخفاء مناطق العرض غير النشطة";
$GLOBALS['strSwitchAccount'] = "";
$GLOBALS['strAgencyStatusRunning'] = "";
$GLOBALS['strAgencyStatusInactive'] = "فعال";
$GLOBALS['strAgencyStatusPaused'] = "";

// Channels
$GLOBALS['strChannel'] = "";
$GLOBALS['strChannels'] = "";
$GLOBALS['strChannelManagement'] = "";
$GLOBALS['strAddNewChannel'] = "";
$GLOBALS['strAddNewChannel_Key'] = "";
$GLOBALS['strChannelToWebsite'] = "كل المواقع";
$GLOBALS['strNoChannels'] = "";
$GLOBALS['strNoChannelsAddWebsite'] = "";
$GLOBALS['strEditChannelLimitations'] = "";
$GLOBALS['strChannelProperties'] = "";
$GLOBALS['strChannelLimitations'] = "خيارات التوصيل";
$GLOBALS['strConfirmDeleteChannel'] = "";
$GLOBALS['strConfirmDeleteChannels'] = "";
$GLOBALS['strChannelsOfWebsite'] = ''; //this is added between page name and website name eg. 'delivery rule sets in www.example.com'

// Tracker Variables
$GLOBALS['strVariableName'] = "";
$GLOBALS['strVariableDescription'] = "الوصف";
$GLOBALS['strVariableDataType'] = "";
$GLOBALS['strVariablePurpose'] = "";
$GLOBALS['strGeneric'] = "عام";
$GLOBALS['strBasketValue'] = "";
$GLOBALS['strNumItems'] = "";
$GLOBALS['strVariableIsUnique'] = "";
$GLOBALS['strNumber'] = "";
$GLOBALS['strString'] = "";
$GLOBALS['strTrackFollowingVars'] = "";
$GLOBALS['strAddVariable'] = "";
$GLOBALS['strNoVarsToTrack'] = "";
$GLOBALS['strVariableRejectEmpty'] = "";
$GLOBALS['strTrackingSettings'] = "";
$GLOBALS['strTrackerType'] = "اسم المتتبع";
$GLOBALS['strTrackerTypeJS'] = "";
$GLOBALS['strTrackerTypeDefault'] = "";
$GLOBALS['strTrackerTypeDOM'] = "";
$GLOBALS['strTrackerTypeCustom'] = "";
$GLOBALS['strVariableCode'] = "";

// Password recovery
$GLOBALS['strForgotPassword'] = "";
$GLOBALS['strPasswordRecovery'] = "";
$GLOBALS['strWelcomePage'] = "";
$GLOBALS['strWelcomePageText'] = "";
$GLOBALS['strEmailRequired'] = "";
$GLOBALS['strPwdRecWrongExpired'] = "";
$GLOBALS['strPwdRecEnterEmail'] = "";
$GLOBALS['strPwdRecEnterPassword'] = "";
$GLOBALS['strProceed'] = "";
$GLOBALS['strNotifyPageMessage'] = "";

// Password recovery - Default
$GLOBALS['strPwdRecEmailPwdRecovery'] = "";
$GLOBALS['strPwdRecEmailBody'] = "";

$GLOBALS['strPwdRecEmailSincerely'] = "";

// Password recovery - Welcome email
$GLOBALS['strWelcomeEmailSubject'] = "";
$GLOBALS['strWelcomeEmailBody'] = "";

// Password recovery - Hash update
$GLOBALS['strPasswordUpdateEmailSubject'] = "";
$GLOBALS['strPasswordUpdateEmailBody'] = "";

// Password reset warning
$GLOBALS['strPasswordResetRequiredTitle'] = "";
$GLOBALS['strPasswordResetRequired'] = "";
$GLOBALS['strPasswordUnsafeWarning'] = "";

// Audit
$GLOBALS['strAdditionalItems'] = "";
$GLOBALS['strAuditSystem'] = "";
$GLOBALS['strFor'] = "";
$GLOBALS['strHas'] = "";
$GLOBALS['strBinaryData'] = "معلومات Binary";
$GLOBALS['strAuditTrailDisabled'] = "";

// Widget - Audit
$GLOBALS['strAuditNoData'] = "";
$GLOBALS['strAuditTrail'] = "";
$GLOBALS['strAuditTrailSetup'] = "";
$GLOBALS['strAuditTrailGoTo'] = "";
$GLOBALS['strAuditTrailNotEnabled'] = "";

// Widget - Campaign
$GLOBALS['strCampaignGoTo'] = "";
$GLOBALS['strCampaignSetUp'] = "";
$GLOBALS['strCampaignNoRecords'] = "";
$GLOBALS['strCampaignNoRecordsAdmin'] = "<li>لا يوجد أي نشاط لأي حملة للعرض.</li>";

$GLOBALS['strCampaignNoDataTimeSpan'] = "";
$GLOBALS['strCampaignAuditNotActivated'] = "";
$GLOBALS['strCampaignAuditTrailSetup'] = "";

$GLOBALS['strUnsavedChanges'] = "";
$GLOBALS['strDeliveryLimitationsDisagree'] = "";
$GLOBALS['strDeliveryRulesDbError'] = "";
$GLOBALS['strDeliveryRulesTruncation'] = "";
$GLOBALS['strDeliveryLimitationsInputErrors'] = "";

//confirmation messages
$GLOBALS['strYouAreNowWorkingAsX'] = "";
$GLOBALS['strYouDontHaveAccess'] = "";

$GLOBALS['strAdvertiserHasBeenAdded'] = "";
$GLOBALS['strAdvertiserHasBeenUpdated'] = "";
$GLOBALS['strAdvertiserHasBeenDeleted'] = "";
$GLOBALS['strAdvertisersHaveBeenDeleted'] = "";

$GLOBALS['strTrackerHasBeenAdded'] = "";
$GLOBALS['strTrackerHasBeenUpdated'] = "";
$GLOBALS['strTrackerVarsHaveBeenUpdated'] = "";
$GLOBALS['strTrackerCampaignsHaveBeenUpdated'] = "";
$GLOBALS['strTrackerAppendHasBeenUpdated'] = "";
$GLOBALS['strTrackerHasBeenDeleted'] = "";
$GLOBALS['strTrackersHaveBeenDeleted'] = "";
$GLOBALS['strTrackerHasBeenDuplicated'] = "";
$GLOBALS['strTrackerHasBeenMoved'] = "";

$GLOBALS['strCampaignHasBeenAdded'] = "";
$GLOBALS['strCampaignHasBeenUpdated'] = "";
$GLOBALS['strCampaignTrackersHaveBeenUpdated'] = "";
$GLOBALS['strCampaignHasBeenDeleted'] = "";
$GLOBALS['strCampaignsHaveBeenDeleted'] = "";
$GLOBALS['strCampaignHasBeenDuplicated'] = "";
$GLOBALS['strCampaignHasBeenMoved'] = "";

$GLOBALS['strBannerHasBeenAdded'] = "";
$GLOBALS['strBannerHasBeenUpdated'] = "";
$GLOBALS['strBannerAdvancedHasBeenUpdated'] = "";
$GLOBALS['strBannerAclHasBeenUpdated'] = "";
$GLOBALS['strBannerAclHasBeenAppliedTo'] = "";
$GLOBALS['strBannerHasBeenDeleted'] = "";
$GLOBALS['strBannersHaveBeenDeleted'] = "";
$GLOBALS['strBannerHasBeenDuplicated'] = "";
$GLOBALS['strBannerHasBeenMoved'] = "";
$GLOBALS['strBannerHasBeenActivated'] = "";
$GLOBALS['strBannerHasBeenDeactivated'] = "";

$GLOBALS['strXZonesLinked'] = "";
$GLOBALS['strXZonesUnlinked'] = "";

$GLOBALS['strWebsiteHasBeenAdded'] = "";
$GLOBALS['strWebsiteHasBeenUpdated'] = "";
$GLOBALS['strWebsiteHasBeenDeleted'] = "";
$GLOBALS['strWebsitesHaveBeenDeleted'] = "";
$GLOBALS['strWebsiteHasBeenDuplicated'] = "";

$GLOBALS['strZoneHasBeenAdded'] = "";
$GLOBALS['strZoneHasBeenUpdated'] = "";
$GLOBALS['strZoneAdvancedHasBeenUpdated'] = "";
$GLOBALS['strZoneHasBeenDeleted'] = "";
$GLOBALS['strZonesHaveBeenDeleted'] = "";
$GLOBALS['strZoneHasBeenDuplicated'] = "";
$GLOBALS['strZoneHasBeenMoved'] = "";
$GLOBALS['strZoneLinkedBanner'] = "";
$GLOBALS['strZoneLinkedCampaign'] = "";
$GLOBALS['strZoneRemovedBanner'] = "";
$GLOBALS['strZoneRemovedCampaign'] = "";

$GLOBALS['strChannelHasBeenAdded'] = "";
$GLOBALS['strChannelHasBeenUpdated'] = "";
$GLOBALS['strChannelAclHasBeenUpdated'] = "";
$GLOBALS['strChannelHasBeenDeleted'] = "";
$GLOBALS['strChannelsHaveBeenDeleted'] = "";
$GLOBALS['strChannelHasBeenDuplicated'] = "";

$GLOBALS['strUserPreferencesUpdated'] = "";
$GLOBALS['strEmailChanged'] = "";
$GLOBALS['strPasswordChanged'] = "";
$GLOBALS['strXPreferencesHaveBeenUpdated'] = "";
$GLOBALS['strXSettingsHaveBeenUpdated'] = "";
$GLOBALS['strTZPreferencesWarning'] = "";

// Report error messages
$GLOBALS['strReportErrorMissingSheets'] = "";
$GLOBALS['strReportErrorUnknownCode'] = "";

/* ------------------------------------------------------- */
/* Password strength                                       */
/* ------------------------------------------------------- */

$GLOBALS['strPasswordMinLength'] = '';
$GLOBALS['strPasswordTooShort'] = "";

if (!isset($GLOBALS['strPasswordScore'])) {
    $GLOBALS['strPasswordScore'] = [];
}

$GLOBALS['strPasswordScore'][0] = "";
$GLOBALS['strPasswordScore'][1] = "";
$GLOBALS['strPasswordScore'][2] = "";
$GLOBALS['strPasswordScore'][3] = "";
$GLOBALS['strPasswordScore'][4] = "";


/* ------------------------------------------------------- */
/* Keyboard shortcut assignments                           */
/* ------------------------------------------------------- */

// Reserved keys
// Do not change these unless absolutely needed
$GLOBALS['keyHome'] = "";
$GLOBALS['keyUp'] = "";
$GLOBALS['keyNextItem'] = ".";
$GLOBALS['keyPreviousItem'] = "";
$GLOBALS['keyList'] = "";

// Other keys
// Please make sure you underline the key you
// used in the string in default.lang.php
$GLOBALS['keySearch'] = "";
$GLOBALS['keyCollapseAll'] = "";
$GLOBALS['keyExpandAll'] = "";
$GLOBALS['keyAddNew'] = "";
$GLOBALS['keyNext'] = "";
$GLOBALS['keyPrevious'] = "";
$GLOBALS['keyLinkUser'] = "";
$GLOBALS['keyWorkingAs'] = "";
