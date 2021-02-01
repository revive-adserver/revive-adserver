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
$GLOBALS['phpAds_CharSet'] = "UTF-8";

$GLOBALS['phpAds_DecimalPoint'] = ".";
$GLOBALS['phpAds_ThousandsSeperator'] = ",";

// Date & time configuration
$GLOBALS['date_format'] = "%d-%m-%Y";
$GLOBALS['time_format'] = "%H:%M:%S";
$GLOBALS['minute_format'] = "%H:%M";
$GLOBALS['month_format'] = "%m-%Y";
$GLOBALS['day_format'] = "%d-%m";
$GLOBALS['week_format'] = "%W-%Y";
$GLOBALS['weekiso_format'] = "%V-%G";

// Formats used by PEAR Spreadsheet_Excel_Writer packate
$GLOBALS['excel_integer_formatting'] = "#,##0;-#,##0;-";
$GLOBALS['excel_decimal_formatting'] = "#,##0.000;-#,##0.000;-";

/* ------------------------------------------------------- */
/* Translations                                          */
/* ------------------------------------------------------- */

$GLOBALS['strHome'] = "الصفحة الرّئيسية";
$GLOBALS['strHelp'] = "مساعدة";
$GLOBALS['strStartOver'] = "البدء من جديد";
$GLOBALS['strShortcuts'] = "الاختصارات";
$GLOBALS['strActions'] = "الفعل";
$GLOBALS['strAndXMore'] = "and %s more";
$GLOBALS['strAdminstration'] = "المخزن";
$GLOBALS['strMaintenance'] = "الصيانة";
$GLOBALS['strProbability'] = "الإحتماليات";
$GLOBALS['strInvocationcode'] = "كود التركيب";
$GLOBALS['strBasicInformation'] = "معلومات أساسية";
$GLOBALS['strAppendTrackerCode'] = "Append Tracker Code";
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
$GLOBALS['strUnknown'] = "Unknown";
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
$GLOBALS['strFieldStartDateBeforeEnd'] = "'From' date must be earlier then 'To' date";
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
$GLOBALS['strEnableCheckForUpdates'] = "Please enable the <a href='account-settings-update.php' target='_top'>check for updates</a> setting on the<br/><a href='account-settings-update.php' target='_top'>update settings</a> page.";
// Dashboard Errors
$GLOBALS['strDashboardErrorCode'] = "code";
$GLOBALS['strDashboardSystemMessage'] = "رسالة من النظام";
$GLOBALS['strDashboardErrorHelp'] = "إذا تكرر هذا الخطأ الرجاء وصف المشكلة بالتفصيل على <a href='http://forum.revive-adserver.com/'> forum.revive-adserver.com/</a>.";

// Priority
$GLOBALS['strPriority'] = "الأهمية";
$GLOBALS['strPriorityLevel'] = "مستوى الأهمية";
$GLOBALS['strOverrideAds'] = "تجاوز إعلانات الحملة";
$GLOBALS['strHighAds'] = "Contract Campaign Advertisements";
$GLOBALS['strECPMAds'] = "eCPM Campaign Advertisements";
$GLOBALS['strLowAds'] = "Remnant Campaign Advertisements";
$GLOBALS['strLimitations'] = "Delivery rules";
$GLOBALS['strNoLimitations'] = "No delivery rules";
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
$GLOBALS['strWorkingAs'] = "Working as";
$GLOBALS['strWorkingAs_Key'] = "<u>W</u>orking as";
$GLOBALS['strWorkingAs'] = "Working as";
$GLOBALS['strSwitchTo'] = "قم بالتبديل إلى";
$GLOBALS['strUseSearchBoxToFindMoreAccounts'] = "Use the switcher's search box to find more accounts";
$GLOBALS['strWorkingFor'] = "%s for...";
$GLOBALS['strNoAccountWithXInNameFound'] = "No accounts with \"%s\" in name found";
$GLOBALS['strRecentlyUsed'] = "المستخدمة مؤخرا";
$GLOBALS['strLinkUser'] = "إضافة مستخدم";
$GLOBALS['strLinkUser_Key'] = "Add <u>u</u>ser";
$GLOBALS['strUsernameToLink'] = "اسم المستخدم للاضافة";
$GLOBALS['strNewUserWillBeCreated'] = "سيتم خلق مستخدم جديد";
$GLOBALS['strToLinkProvideEmail'] = "لإضافة مستخدم، زود البريد الإلكتروني للمستخدم";
$GLOBALS['strToLinkProvideUsername'] = "لإضافة مستخدم، توفير اسم المستخدم";
$GLOBALS['strUserLinkedToAccount'] = "قد تم إضافة المستخدم إلى الحساب";
$GLOBALS['strUserAccountUpdated'] = "تم تحديث حساب المستخدم";
$GLOBALS['strUserUnlinkedFromAccount'] = "لقد تمت إزالة المستخدم من الحساب";
$GLOBALS['strUserWasDeleted'] = "تم حذف المستخدم";
$GLOBALS['strUserNotLinkedWithAccount'] = "هذا المستخدم غير مرتبط بحساب";
$GLOBALS['strCantDeleteOneAdminUser'] = "لا يمكنك حذف مستخدم. يحتاج أن يكون مستخدم واحد على الأقل مرتبط مع حساب المسؤول.";
$GLOBALS['strLinkUserHelp'] = "To add an <b>existing user</b>, type the %1\$s and click %2\$s <br />To add a <b>new user</b>, type the desired %1\$s and click %2\$s";
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
$GLOBALS['strEnableCookies'] = "You need to enable cookies before you can use {$PRODUCT_NAME}";
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
$GLOBALS['strNoPlacement'] = "Selected campaign does not exist. Try this <a href='{link}'>link</a> instead";
$GLOBALS['strNoAdvertiser'] = "Selected advertiser does not exist. Try this <a href='{link}'>link</a> instead";

// General advertising
$GLOBALS['strRequests'] = "الطلبات";
$GLOBALS['strImpressions'] = "مرات الظهور";
$GLOBALS['strClicks'] = "الضغطات";
$GLOBALS['strConversions'] = "التحويل";
$GLOBALS['strCTRShort'] = "معدل الضغطات";
$GLOBALS['strCNVRShort'] = "SR";
$GLOBALS['strCTR'] = "معدل الضغطات";
$GLOBALS['strTotalClicks'] = "مجموع الضغطات";
$GLOBALS['strTotalConversions'] = "مجموع التحويلات";
$GLOBALS['strDateTime'] = "التاريخ الوقت";
$GLOBALS['strTrackerID'] = "رقم المتتبع";
$GLOBALS['strTrackerName'] = "اسم المتتبع";
$GLOBALS['strTrackerImageTag'] = "Image Tag";
$GLOBALS['strTrackerJsTag'] = "Javascript Tag";
$GLOBALS['strTrackerAlwaysAppend'] = "Always display appended code, even if no conversion is recorded by the tracker?";
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
$GLOBALS['strFinanceCR'] = "CR";

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
    $GLOBALS['strDayFullNames'] = array();
}
$GLOBALS['strDayFullNames'][0] = 'الأحد';
$GLOBALS['strDayFullNames'][1] = 'الإثنين';
$GLOBALS['strDayFullNames'][2] = 'الثلاثاء';
$GLOBALS['strDayFullNames'][3] = 'الأربعاء';
$GLOBALS['strDayFullNames'][4] = 'الخميس';
$GLOBALS['strDayFullNames'][5] = 'الجمعة';
$GLOBALS['strDayFullNames'][6] = 'السبت';

if (!isset($GLOBALS['strDayShortCuts'])) {
    $GLOBALS['strDayShortCuts'] = array();
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
$GLOBALS['strClientHistory'] = "Advertiser Statistics";
$GLOBALS['strNoClients'] = "لا يوجد معلنين حتى الآن. لإضافة حملة إعلانية، يجب <a href='advertiser-edit.php'>إضافة معلن</a> قبل ذلك.";
$GLOBALS['strConfirmDeleteClient'] = "هل أنت متأكد من رغبتك في حذف هذا المعلن ؟";
$GLOBALS['strConfirmDeleteClients'] = "هل أنت متأكد من رغبتك في حذف هذا المعلن ؟";
$GLOBALS['strHideInactive'] = "إخفاء الغير فعّال";
$GLOBALS['strInactiveAdvertisersHidden'] = "المعلنين غير النشطين تم إخفائهم";
$GLOBALS['strAdvertiserSignup'] = "Advertiser Sign Up";
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
$GLOBALS['strAllowCreateAccounts'] = "Allow this user to manage this account's users";
$GLOBALS['strAdvertiserLimitation'] = "Display only one banner from this advertiser on a web page";
$GLOBALS['strAllowAuditTrailAccess'] = "السماح لهذا المستخدم الوصول إلى سجل المراجعة";
$GLOBALS['strAllowDeleteItems'] = "Allow this user to delete items";

// Campaign
$GLOBALS['strCampaign'] = "الحملة الإعلانية";
$GLOBALS['strCampaigns'] = "الحملة الإعلانية";
$GLOBALS['strAddCampaign'] = "إضافة حملة إعلانية";
$GLOBALS['strAddCampaign_Key'] = "إضافة حملة إعلانية";
$GLOBALS['strCampaignForAdvertiser'] = "للمعلن";
$GLOBALS['strLinkedCampaigns'] = "الحملات الاعلانية المرتبطة";
$GLOBALS['strCampaignProperties'] = "خواص الحملة الإعلانية";
$GLOBALS['strCampaignOverview'] = "نظرة عامة على الحملة الإعلانية";
$GLOBALS['strCampaignHistory'] = "Campaign Statistics";
$GLOBALS['strNoCampaigns'] = "لا يوجد حاليا حملات لهذا المعلن.";
$GLOBALS['strNoCampaignsAddAdvertiser'] = "There are currently no campaigns defined, because there are no advertisers. To create a campaign, <a href='advertiser-edit.php'>add a new advertiser</a> first.";
$GLOBALS['strConfirmDeleteCampaign'] = "هل تريد حذف هذه الحملة الاعلانية ؟";
$GLOBALS['strConfirmDeleteCampaigns'] = "هل تريد حذف هذه الحملة الاعلانية ؟";
$GLOBALS['strShowParentAdvertisers'] = "عرض المعلنين الرئيسيين";
$GLOBALS['strHideParentAdvertisers'] = "إخفاء المعلنين الرئيسيين";
$GLOBALS['strHideInactiveCampaigns'] = "إخفاء الحملات الاعلانية غير النشطة";
$GLOBALS['strInactiveCampaignsHidden'] = "تم إخفاء الحملات الاعلانية غير النشطة";
$GLOBALS['strPriorityInformation'] = "الأهمية مقارنة بالحملات الإعلانية الأخرى";
$GLOBALS['strECPMInformation'] = "eCPM prioritization";
$GLOBALS['strRemnantEcpmDescription'] = "eCPM is automatically calculated based on this campaign's performance.<br />It will be used to prioritise Remnant campaigns relative to each other.";
$GLOBALS['strEcpmMinImpsDescription'] = "Set this to your desired minium basis on which to calculate this campaign's eCPM.";
$GLOBALS['strHiddenCampaign'] = "الحملة الإعلانية";
$GLOBALS['strHiddenAd'] = "الاعلانات";
$GLOBALS['strHiddenAdvertiser'] = "المعلن";
$GLOBALS['strHiddenTracker'] = "المتتبع";
$GLOBALS['strHiddenWebsite'] = "الموقع";
$GLOBALS['strHiddenZone'] = "المنطقة";
$GLOBALS['strCampaignDelivery'] = "Campaign delivery";
$GLOBALS['strCompanionPositioning'] = "Companion positioning";
$GLOBALS['strSelectUnselectAll'] = "اختيار/عدم اختيار الكل";
$GLOBALS['strCampaignsOfAdvertiser'] = "of"; //this is added between page name and advertiser name eg. 'Campaigns of Advertiser 1'
$GLOBALS['strShowCappedNoCookie'] = "Show capped ads if cookies are disabled";

// Campaign-zone linking page
$GLOBALS['strCalculatedForAllCampaigns'] = "Calculated for all campaigns";
$GLOBALS['strCalculatedForThisCampaign'] = "Calculated for this campaign";
$GLOBALS['strLinkingZonesProblem'] = "Problem occurred when linking zones";
$GLOBALS['strUnlinkingZonesProblem'] = "Problem occurred when unlinking zones";
$GLOBALS['strZonesLinked'] = "zone(s) linked";
$GLOBALS['strZonesUnlinked'] = "zone(s) unlinked";
$GLOBALS['strZonesSearch'] = "Search";
$GLOBALS['strZonesSearchTitle'] = "Search zones and websites by name";
$GLOBALS['strNoWebsitesAndZones'] = "No websites and zones";
$GLOBALS['strNoWebsitesAndZonesText'] = "with \"%s\" in name";
$GLOBALS['strToLink'] = "to link";
$GLOBALS['strToUnlink'] = "to unlink";
$GLOBALS['strLinked'] = "Linked";
$GLOBALS['strAvailable'] = "موجود";
$GLOBALS['strShowing'] = "Showing";
$GLOBALS['strEditZone'] = "Edit zone";
$GLOBALS['strEditWebsite'] = "Edit website";


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
$GLOBALS['strCampaignWeight'] = "Set the campaign weight";
$GLOBALS['strAnonymous'] = "إخفاء المعلن و المواقع لهذه الحملة الاعلانية";
$GLOBALS['strTargetPerDay'] = "في اليوم";
$GLOBALS['strCampaignWarningRemnantNoWeight'] = "The type of this campaign has been set to Remnant,
but the weight is set to zero or it has not been
specified. This will cause the campaign to be
deactivated and its banners won't be delivered
until the weight has been set to a valid number.

Are you sure you want to continue?";
$GLOBALS['strCampaignWarningEcpmNoRevenue'] = "This campaign uses eCPM optimisation
but the 'revenue' is set to zero or it has not been specified.
This will cause the campaign to be deactivated
and its banners won't be delivered until the
revenue has been set to a valid number.

Are you sure you want to continue?";
$GLOBALS['strCampaignWarningOverrideNoWeight'] = "The type of this campaign has been set to Override,
but the weight is set to zero or it has not been
specified. This will cause the campaign to be
deactivated and its banners won't be delivered
until the weight has been set to a valid number.

Are you sure you want to continue?";
$GLOBALS['strCampaignWarningNoTarget'] = "The type of this campaign has been set to Contract,
but Limit per day is not specified.
This will cause the campaign to be deactivated and
its banners won't be delivered until a valid Limit per day has been set.

Are you sure you want to continue?";
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
$GLOBALS['strOverride'] = "Override";
$GLOBALS['strOverrideInfo'] = "Override campaigns are a special campaign type specifically to
    override (i.e. take priority over) Remnant and Contract campaigns. Override campaigns are generally used with
    specific targeting and/or capping rules to ensure that the campaign banners are always displayed in certain
    locations, to certain users, and perhaps a certain number of times, as part of a specific promotion. (This campaign
    type was previously known as 'Contract (Exclusive)'.)";
$GLOBALS['strStandardContract'] = "الاتصال";
$GLOBALS['strStandardContractInfo'] = "Contract campaigns are for smoothly delivering the impressions
    required to achieve a specified time-critical performance requirement. That is, Contract campaigns are for when
    an advertiser has paid specifically to have a given number of impressions, clicks and/or conversions to be
    achieved either between two dates, or per day.";
$GLOBALS['strRemnant'] = "Remnant";
$GLOBALS['strRemnantInfo'] = "The default campaign type. Remnant campaigns have lots of different
    delivery options, and you should ideally always have at least one Remnant campaign linked to every zone, to ensure
    that there is always something to show. Use Remnant campaigns to display house banners, ad-network banners, or even
    direct advertising that has been sold, but where there is not a time-critical performance requirement for the
    campaign to adhere to.";
$GLOBALS['strECPMInfo'] = "This is a standard campaign which can be constrained with either an end date or a specific limit. Based on current settings it will be prioritised using eCPM.";
$GLOBALS['strPricing'] = "Pricing";
$GLOBALS['strPricingModel'] = "Pricing model";
$GLOBALS['strSelectPricingModel'] = "-- select model --";
$GLOBALS['strRatePrice'] = "Rate / Price";
$GLOBALS['strMinimumImpressions'] = "Minimum daily impressions";
$GLOBALS['strLimit'] = "Limit";
$GLOBALS['strLowExclusiveDisabled'] = "You cannot change this campaign to Remnant or Exclusive, since both an end date and either of impressions/clicks/conversions limit are set. <br>In order to change type, you need to set no expiry date or remove limits.";
$GLOBALS['strCannotSetBothDateAndLimit'] = "You cannot set both an end date and limit for a Remnant or Exclusive campaign.<br>If you need to set both an end date and limit impressions/clicks/conversions please use a non-exclusive Contract campaign.";
$GLOBALS['strWhyDisabled'] = "why is it disabled?";
$GLOBALS['strBackToCampaigns'] = "Back to campaigns";
$GLOBALS['strCampaignBanners'] = "Campaign's banners";
$GLOBALS['strCookies'] = "Cookies";

// Tracker
$GLOBALS['strTracker'] = "المتتبع";
$GLOBALS['strTrackers'] = "المتتبع";
$GLOBALS['strTrackerPreferences'] = "الخيارات العامة";
$GLOBALS['strAddTracker'] = "إضافة متتبع جديد";
$GLOBALS['strTrackerForAdvertiser'] = "للمعلن";
$GLOBALS['strNoTrackers'] = "There are currently no trackers defined for this advertiser";
$GLOBALS['strConfirmDeleteTrackers'] = "هل تريد حذف هذا المتتبع ؟";
$GLOBALS['strConfirmDeleteTracker'] = "هل تريد حذف هذا المتتبع ؟";
$GLOBALS['strTrackerProperties'] = "خواص المتتبع";
$GLOBALS['strDefaultStatus'] = "الحالة الافتراضية";
$GLOBALS['strStatus'] = "الحالة";
$GLOBALS['strLinkedTrackers'] = "المتتبعات المرتبطة";
$GLOBALS['strTrackerInformation'] = "Tracker Information";
$GLOBALS['strConversionWindow'] = "نافذة التحويل";
$GLOBALS['strUniqueWindow'] = "ناقذة فريدة";
$GLOBALS['strClick'] = "ضغطة";
$GLOBALS['strView'] = "عرض";
$GLOBALS['strArrival'] = "Arrival";
$GLOBALS['strManual'] = "Manual";
$GLOBALS['strImpression'] = "Impression";
$GLOBALS['strConversionType'] = "نوع التحويل";
$GLOBALS['strLinkCampaignsByDefault'] = "ربط الحملات الاعلانية الجديدة افتراضياً";
$GLOBALS['strBackToTrackers'] = "Back to trackers";
$GLOBALS['strIPAddress'] = "IP Address";

// Banners (General)
$GLOBALS['strBanner'] = "بنر";
$GLOBALS['strBanners'] = "بنرات";
$GLOBALS['strAddBanner'] = "إضافة بنر جديد";
$GLOBALS['strAddBanner_Key'] = "إضافة بنر جديد";
$GLOBALS['strBannerToCampaign'] = "to campaign";
$GLOBALS['strShowBanner'] = "عرض البنر";
$GLOBALS['strBannerProperties'] = "خواص البنر";
$GLOBALS['strBannerHistory'] = "Banner Statistics";
$GLOBALS['strNoBanners'] = "There are currently no banners defined for this campaign.";
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
$GLOBALS['strBannersOfCampaign'] = "in"; //this is added between page name and campaign name eg. 'Banners in coca cola campaign'

// Banner Preferences
$GLOBALS['strBannerPreferences'] = "الخيارات العامة";
$GLOBALS['strCampaignPreferences'] = "Campaign Preferences";
$GLOBALS['strDefaultBanners'] = "البنر الافتراضي";
$GLOBALS['strDefaultBannerUrl'] = "الصورة الافتراضية";
$GLOBALS['strDefaultBannerDestination'] = "الرابط الافتراضي";
$GLOBALS['strAllowedBannerTypes'] = "أنواع البنرات المسموحة";
$GLOBALS['strTypeSqlAllow'] = "Allow SQL Local Banners";
$GLOBALS['strTypeWebAllow'] = "Allow Webserver Local Banners";
$GLOBALS['strTypeUrlAllow'] = "إتاحة البنرات الخارجية";
$GLOBALS['strTypeHtmlAllow'] = "إتاحة بنرات HTML";
$GLOBALS['strTypeTxtAllow'] = "إتاحة الاعلانات النصية";

// Banner (Properties)
$GLOBALS['strChooseBanner'] = "الرجاء اختيار نوع البنر";
$GLOBALS['strMySQLBanner'] = "Upload a local banner to the database";
$GLOBALS['strWebBanner'] = "Upload a local banner to the webserver";
$GLOBALS['strURLBanner'] = "Link an external banner";
$GLOBALS['strHTMLBanner'] = "Create an HTML banner";
$GLOBALS['strTextBanner'] = "Create a Text banner";
$GLOBALS['strAlterHTML'] = "Alter HTML to enable click tracking for:";
$GLOBALS['strIframeFriendly'] = "This banner can be safely displayed inside an iframe (e.g. is not expandable)";
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
$GLOBALS['strCampaignsWeight'] = "Campaign's Weight";
$GLOBALS['strBannerWeight'] = "وزن البنر";
$GLOBALS['strBannersWeight'] = "Banner's Weight";
$GLOBALS['strAdserverTypeGeneric'] = "بنر HTML عام";
$GLOBALS['strDoNotAlterHtml'] = "Do not alter HTML";
$GLOBALS['strGenericOutputAdServer'] = "عام";
$GLOBALS['strBackToBanners'] = "Back to banners";
$GLOBALS['strUseWyswygHtmlEditor'] = "Use WYSIWYG HTML Editor";
$GLOBALS['strChangeDefault'] = "Change default";

// Banner (advanced)
$GLOBALS['strBannerPrependHTML'] = "Always prepend the following HTML code to this banner";
$GLOBALS['strBannerAppendHTML'] = "Always append the following HTML code to this banner";

// Display Delviery Rules
$GLOBALS['strModifyBannerAcl'] = "خيارات التوصيل";
$GLOBALS['strACL'] = "خيارات التوصيل";
$GLOBALS['strACLAdd'] = "Add delivery rule";
$GLOBALS['strApplyLimitationsTo'] = "Apply delivery rules to";
$GLOBALS['strAllBannersInCampaign'] = "All banners in this campaign";
$GLOBALS['strRemoveAllLimitations'] = "Remove all delivery rules";
$GLOBALS['strEqualTo'] = "يساوي";
$GLOBALS['strDifferentFrom'] = "مختلف عن";
$GLOBALS['strLaterThan'] = "is later than";
$GLOBALS['strLaterThanOrEqual'] = "is later than or equal to";
$GLOBALS['strEarlierThan'] = "is earlier than";
$GLOBALS['strEarlierThanOrEqual'] = "is earlier than or equal to";
$GLOBALS['strContains'] = "contains";
$GLOBALS['strNotContains'] = "doesn't contain";
$GLOBALS['strGreaterThan'] = "أكبر من";
$GLOBALS['strLessThan'] = "أصغر من";
$GLOBALS['strGreaterOrEqualTo'] = "is greater or equal to";
$GLOBALS['strLessOrEqualTo'] = "is less or equal to";
$GLOBALS['strAND'] = "و";                          // logical operator
$GLOBALS['strOR'] = "أو";                         // logical operator
$GLOBALS['strOnlyDisplayWhen'] = "إعرض البنر فقط عندما";
$GLOBALS['strWeekDays'] = "أيام الاسبوع";
$GLOBALS['strTime'] = "Time";
$GLOBALS['strDomain'] = "Domain";
$GLOBALS['strSource'] = "المصدر";
$GLOBALS['strBrowser'] = "Browser";
$GLOBALS['strOS'] = "OS";
$GLOBALS['strDeliveryLimitations'] = "Delivery Rules";

$GLOBALS['strDeliveryCappingReset'] = "قم بتصفير العداد بعد :";
$GLOBALS['strDeliveryCappingTotal'] = "في المجموع";
$GLOBALS['strDeliveryCappingSession'] = "كل جلسة";

if (!isset($GLOBALS['strCappingBanner'])) {
    $GLOBALS['strCappingBanner'] = array();
}
$GLOBALS['strCappingBanner']['title'] = "Delivery capping per visitor";
$GLOBALS['strCappingBanner']['limit'] = "تحديد عرض الإعلانات إلى:";

if (!isset($GLOBALS['strCappingCampaign'])) {
    $GLOBALS['strCappingCampaign'] = array();
}
$GLOBALS['strCappingCampaign']['title'] = "Delivery capping per visitor";
$GLOBALS['strCappingCampaign']['limit'] = "تحديد عرض الحملة الإعلانية إلى:";

if (!isset($GLOBALS['strCappingZone'])) {
    $GLOBALS['strCappingZone'] = array();
}
$GLOBALS['strCappingZone']['title'] = "Delivery capping per visitor";
$GLOBALS['strCappingZone']['limit'] = "تحديد عرض المنطقة الإعلانية إلى:";

// Website
$GLOBALS['strAffiliate'] = "الموقع";
$GLOBALS['strAffiliates'] = "المواقع";
$GLOBALS['strAffiliatesAndZones'] = "المواقع و مناطق العرض";
$GLOBALS['strAddNewAffiliate'] = "إضافة موقع جديد";
$GLOBALS['strAffiliateProperties'] = "خواص الموقع";
$GLOBALS['strAffiliateHistory'] = "Website Statistics";
$GLOBALS['strNoAffiliates'] = "لا يوجد حتى الآن أية مواقع. لإضافة منطقة إعلانية، يجب <a href='affiliate-edit.php'>إضافة موقع جديد</a> قبل ذلك.";
$GLOBALS['strConfirmDeleteAffiliate'] = "هل تريد حذف هذا الموقع؟";
$GLOBALS['strConfirmDeleteAffiliates'] = "هل تريد حذف هذا الموقع؟";
$GLOBALS['strInactiveAffiliatesHidden'] = "تم إخفاء المواقع غير النشطة";
$GLOBALS['strShowParentAffiliates'] = "عرض المواقع الرئيسية";
$GLOBALS['strHideParentAffiliates'] = "إخفاء المواقع الرئيسية";

// Website (properties)
$GLOBALS['strWebsite'] = "الموقع";
$GLOBALS['strWebsiteURL'] = "Website URL";
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
$GLOBALS['strAvailableZones'] = "Available Zones";
$GLOBALS['strLinkingNotSuccess'] = "Linking not successful, please try again";
$GLOBALS['strZoneProperties'] = "خواص منطقة العرض";
$GLOBALS['strZoneHistory'] = "سجل منطقة العرض";
$GLOBALS['strNoZones'] = "There are currently no zones defined for this website.";
$GLOBALS['strNoZonesAddWebsite'] = "لا يوجد حتى الآن أية مواقع. لإضافة منطقة إعلانية، يجب <a href='affiliate-edit.php'>إضافة موقع جديد</a> قبل ذلك.";
$GLOBALS['strConfirmDeleteZone'] = "هل تريد حذف منطقة العرض ؟";
$GLOBALS['strConfirmDeleteZones'] = "هل تريد حذف منطقة العرض ؟";
$GLOBALS['strConfirmDeleteZoneLinkActive'] = "There are campaigns still linked to this zone, if you delete it these will not be able to run and you will not be paid for them.";
$GLOBALS['strZoneType'] = "نوع منطقة العرض";
$GLOBALS['strBannerButtonRectangle'] = "بنر";
$GLOBALS['strInterstitial'] = "ضمن المحتوى";
$GLOBALS['strPopup'] = "نافذة منبثقة";
$GLOBALS['strTextAdZone'] = "اعلان نصي";
$GLOBALS['strEmailAdZone'] = "بريد الكتروني/قائمة مراسلات";
$GLOBALS['strZoneVideoInstream'] = "Inline Video ad";
$GLOBALS['strZoneVideoOverlay'] = "Overlay Video ad";
$GLOBALS['strShowMatchingBanners'] = "عرض البنرات المطابقة";
$GLOBALS['strHideMatchingBanners'] = "إخفاء البنرات المطابقة";
$GLOBALS['strBannerLinkedAds'] = "البنرات المرتبطة بمنطقة العرض هذه";
$GLOBALS['strCampaignLinkedAds'] = "الحملات الاعلانية المرتبطة بمنطقة العرض هذه";
$GLOBALS['strInactiveZonesHidden'] = "تم إخفاء مناطق العرض غير النشطة";
$GLOBALS['strWarnChangeZoneType'] = "Changing the zone type to text or email will unlink all banners/campaigns due to restrictions of these zone types
                                                <ul>
                                                    <li>Text zones can only be linked to text ads</li>
                                                    <li>Email zone campaigns can only have one active banner at a time</li>
                                                </ul>";
$GLOBALS['strWarnChangeZoneSize'] = 'Changing the zone size will unlink any banners that are not the new size, and will add any banners from linked campaigns which are the new size';
$GLOBALS['strWarnChangeBannerSize'] = 'Changing the banner size will unlink this banner from any zones that are not the new size, and if this banner\'s <strong>campaign</strong> is linked to a zone of the new size, this banner will be automatically linked';
$GLOBALS['strWarnBannerReadonly'] = 'This banner is read-only because an extension has been disabled. Contact your system administrator for more information.';
$GLOBALS['strZonesOfWebsite'] = 'in'; //this is added between page name and website name eg. 'Zones in www.example.com'
$GLOBALS['strBackToZones'] = "Back to zones";

$GLOBALS['strIab']['IAB_FullBanner(468x60)'] = "IAB Full Banner (468 x 60)";
$GLOBALS['strIab']['IAB_Skyscraper(120x600)'] = "IAB Skyscraper (120 x 600)";
$GLOBALS['strIab']['IAB_Leaderboard(728x90)'] = "IAB Leaderboard (728 x 90)";
$GLOBALS['strIab']['IAB_Button1(120x90)'] = "IAB Button 1 (120 x 90)";
$GLOBALS['strIab']['IAB_Button2(120x60)'] = "IAB Button 2 (120 x 60)";
$GLOBALS['strIab']['IAB_HalfBanner(234x60)'] = "IAB Half Banner (234 x 60)";
$GLOBALS['strIab']['IAB_MicroBar(88x31)'] = "IAB Micro Bar (88 x 31)";
$GLOBALS['strIab']['IAB_SquareButton(125x125)'] = "IAB Square Button (125 x 125)";
$GLOBALS['strIab']['IAB_Rectangle(180x150)*'] = "IAB Rectangle (180 x 150)";
$GLOBALS['strIab']['IAB_SquarePop-up(250x250)'] = "IAB Square Pop-up (250 x 250)";
$GLOBALS['strIab']['IAB_VerticalBanner(120x240)'] = "IAB Vertical Banner (120 x 240)";
$GLOBALS['strIab']['IAB_MediumRectangle(300x250)*'] = "IAB Medium Rectangle (300 x 250)";
$GLOBALS['strIab']['IAB_LargeRectangle(336x280)'] = "IAB Large Rectangle (336 x 280)";
$GLOBALS['strIab']['IAB_VerticalRectangle(240x400)'] = "IAB Vertical Rectangle (240 x 400)";
$GLOBALS['strIab']['IAB_WideSkyscraper(160x600)*'] = "IAB Wide Skyscraper (160 x 600)";
$GLOBALS['strIab']['IAB_Pop-Under(720x300)'] = "IAB Pop-Under (720 x 300)";
$GLOBALS['strIab']['IAB_3:1Rectangle(300x100)'] = "IAB 3:1 Rectangle (300 x 100)";

// Advanced zone settings
$GLOBALS['strAdvanced'] = "متقدم";
$GLOBALS['strChainSettings'] = "Chain settings";
$GLOBALS['strZoneNoDelivery'] = "If no banners from this zone <br />can be delivered, try to...";
$GLOBALS['strZoneStopDelivery'] = "إيقاف العرض و عدم عرض أي بنر";
$GLOBALS['strZoneOtherZone'] = "ستخدم منطقة العرض كـ بديل";
$GLOBALS['strZoneAppend'] = "Always append the following HTML code to banners displayed by this zone";
$GLOBALS['strAppendSettings'] = "Append and prepend settings";
$GLOBALS['strZonePrependHTML'] = "Always prepend the following HTML code to banners displayed by this zone";
$GLOBALS['strZoneAppendNoBanner'] = "Prepend/Append even if no banner delivered";
$GLOBALS['strZoneAppendHTMLCode'] = "كود HTML";
$GLOBALS['strZoneAppendZoneSelection'] = "نافذة منبثقة أو ضمن النص";

// Zone probability
$GLOBALS['strZoneProbListChain'] = "All the banners linked to the selected zone are currently not active. <br />This is the zone chain that will be followed:";
$GLOBALS['strZoneProbNullPri'] = "There are no active banners linked to this zone.";
$GLOBALS['strZoneProbListChainLoop'] = "Following the zone chain would cause a circular loop. Delivery for this zone is halted.";

// Linked banners/campaigns/trackers
$GLOBALS['strSelectZoneType'] = "Please choose what to link to this zone";
$GLOBALS['strLinkedBanners'] = "ربط بنرات منفردة";
$GLOBALS['strCampaignDefaults'] = "ربط بنرات عبر الحملة الاعلانية";
$GLOBALS['strLinkedCategories'] = "ربط بنرات حسب التصنيف";
$GLOBALS['strWithXBanners'] = "%d banner(s)";
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
$GLOBALS['strSelectPublisher'] = "Select Website";
$GLOBALS['strSelectZone'] = "إختيار المنطقة";
$GLOBALS['strStatusPending'] = "بانتظار الموافقة";
$GLOBALS['strStatusApproved'] = "Approved";
$GLOBALS['strStatusDisapproved'] = "Disapproved";
$GLOBALS['strStatusDuplicate'] = "نسخ";
$GLOBALS['strStatusOnHold'] = "On Hold";
$GLOBALS['strStatusIgnore'] = "Ignore";
$GLOBALS['strConnectionType'] = "النوع";
$GLOBALS['strConnTypeSale'] = "Sale";
$GLOBALS['strConnTypeLead'] = "Lead";
$GLOBALS['strConnTypeSignUp'] = "Signup";
$GLOBALS['strShortcutEditStatuses'] = "تعديل الحالات";
$GLOBALS['strShortcutShowStatuses'] = "عرض الحالات";

// Statistics
$GLOBALS['strStats'] = "Statistics";
$GLOBALS['strNoStats'] = "لا تتوفر إحصائيات حالياً";
$GLOBALS['strNoStatsForPeriod'] = "There are currently no statistics available for the period %s to %s";
$GLOBALS['strGlobalHistory'] = "Global Statistics";
$GLOBALS['strDailyHistory'] = "Daily Statistics";
$GLOBALS['strDailyStats'] = "Daily Statistics";
$GLOBALS['strWeeklyHistory'] = "Weekly Statistics";
$GLOBALS['strMonthlyHistory'] = "Monthly Statistics";
$GLOBALS['strTotalThisPeriod'] = "المجموع لهذه الفترة";
$GLOBALS['strPublisherDistribution'] = "Website Distribution";
$GLOBALS['strCampaignDistribution'] = "Campaign Distribution";
$GLOBALS['strViewBreakdown'] = "عرض حسب";
$GLOBALS['strBreakdownByDay'] = "يوم";
$GLOBALS['strBreakdownByWeek'] = "اسبوع";
$GLOBALS['strBreakdownByMonth'] = "شهر";
$GLOBALS['strBreakdownByDow'] = "اليوم من الأسبوع";
$GLOBALS['strBreakdownByHour'] = "الساعة";
$GLOBALS['strItemsPerPage'] = "عدد العناصر في الصفحة";
$GLOBALS['strDistributionHistoryCampaign'] = "Distribution Statistics (Campaign)";
$GLOBALS['strDistributionHistoryBanner'] = "Distribution Statistics (Banner)";
$GLOBALS['strDistributionHistoryWebsite'] = "Distribution Statistics (Website)";
$GLOBALS['strDistributionHistoryZone'] = "Distribution Statistics (Zone)";
$GLOBALS['strShowGraphOfStatistics'] = "عرض مخطط بياني للاحصائيات";
$GLOBALS['strExportStatisticsToExcel'] = "تصدير الاحصائيات الى Excel";
$GLOBALS['strGDnotEnabled'] = "You must have GD enabled in PHP to display graphs. <br />Please see <a href='http://www.php.net/gd' target='_blank'>http://www.php.net/gd</a> for more information, including how to install GD on your server.";
$GLOBALS['strStatsArea'] = "Area";

// Expiration
$GLOBALS['strNoExpiration'] = "لم يتم تحديد تاريخ الانتهاء";
$GLOBALS['strEstimated'] = "تاريخ الانتهاء المتوقع";
$GLOBALS['strNoExpirationEstimation'] = "No expiration estimated yet";
$GLOBALS['strDaysAgo'] = "days ago";
$GLOBALS['strCampaignStop'] = "سجل الحملة الإعلانية";

// Reports
$GLOBALS['strAdvancedReports'] = "Advanced Reports";
$GLOBALS['strStartDate'] = "Start Date";
$GLOBALS['strEndDate'] = "End Date";
$GLOBALS['strPeriod'] = "Period";
$GLOBALS['strLimitations'] = "Delivery Rules";
$GLOBALS['strWorksheets'] = "Worksheets";

// Admin_UI_Fields
$GLOBALS['strAllAdvertisers'] = "كل المعلنين";
$GLOBALS['strAnonAdvertisers'] = "Anonymous advertisers";
$GLOBALS['strAllPublishers'] = "كل المواقع";
$GLOBALS['strAnonPublishers'] = "Anonymous websites";
$GLOBALS['strAllAvailZones'] = "كل مناطق العرض المتوفرة";

// Userlog
$GLOBALS['strUserLog'] = "سجل المستخدم";
$GLOBALS['strUserLogDetails'] = "تفاصيل سجل المستخدم";
$GLOBALS['strDeleteLog'] = "حذف السجل";
$GLOBALS['strAction'] = "الفعل";
$GLOBALS['strNoActionsLogged'] = "No actions are logged";

// Code generation
$GLOBALS['strGenerateBannercode'] = "اختيار مباشر";
$GLOBALS['strChooseInvocationType'] = "الرجاء اختيار نوع البنر";
$GLOBALS['strGenerate'] = "إنشاء";
$GLOBALS['strParameters'] = "Tag settings";
$GLOBALS['strFrameSize'] = "حجم الاطار";
$GLOBALS['strBannercode'] = "كود البنر";
$GLOBALS['strTrackercode'] = "Trackercode";
$GLOBALS['strBackToTheList'] = "العودة لقائمة التقارير";
$GLOBALS['strCharset'] = "Character set";
$GLOBALS['strAutoDetect'] = "Auto-detect";
$GLOBALS['strCacheBusterComment'] = "  * Replace all instances of {random} with
  * a generated random number (or timestamp).
  *";
$GLOBALS['strSSLBackupComment'] = "
  * The backup image section of this tag has been generated for use on a
  * non-SSL page. If this tag is to be placed on an SSL page, change the
  *   'http://%s/...'
  * to
  *   'https://%s/...'
  *";
$GLOBALS['strSSLDeliveryComment'] = "
  * This tag has been generated for use on a non-SSL page. If this tag
  * is to be placed on an SSL page, change the
  *   'http://%s/...'
  * to
  *   'https://%s/...'
  *";

// Errors
$GLOBALS['strErrorDatabaseConnection'] = "Database connection error.";
$GLOBALS['strErrorCantConnectToDatabase'] = "A fatal error occurred %1\$s can't connect to the database. Because
                                                   of this it isn't possible to use the administrator interface. The delivery
                                                   of banners might also be affected. Possible reasons for the problem are:
                                                   <ul>
                                                     <li>The database server isn't functioning at the moment</li>
                                                     <li>The location of the database server has changed</li>
                                                     <li>The username or password used to contact the database server are not correct</li>
                                                     <li>PHP has not loaded the <i>%2\$s</i> extension</li>
                                                   </ul>";
$GLOBALS['strNoMatchesFound'] = "No matches were found";
$GLOBALS['strErrorOccurred'] = "حدث خطأ ما";
$GLOBALS['strErrorDBPlain'] = "An error occurred while accessing the database";
$GLOBALS['strErrorDBSerious'] = "A serious problem with the database has been detected";
$GLOBALS['strErrorDBNoDataPlain'] = "Due to a problem with the database {$PRODUCT_NAME} couldn't retrieve or store data. ";
$GLOBALS['strErrorDBNoDataSerious'] = "Due to a serious problem with the database, {$PRODUCT_NAME} couldn't retrieve data";
$GLOBALS['strErrorDBCorrupt'] = "The database table is probably corrupt and needs to be repaired. For more information about repairing corrupted tables please read the chapter <i>Troubleshooting</i> of the <i>Administrator guide</i>.";
$GLOBALS['strErrorDBContact'] = "Please contact the administrator of this server and notify him or her of the problem.";
$GLOBALS['strErrorDBSubmitBug'] = "If this problem is reproducable it might be caused by a bug in {$PRODUCT_NAME}. Please report the following information to the creators of {$PRODUCT_NAME}. Also try to describe the actions that led to this error as clearly as possible.";
$GLOBALS['strMaintenanceNotActive'] = "The maintenance script has not been run in the last 24 hours.
In order for the application to function correctly it needs to run
every hour.

Please read the Administrator guide for more information
about configuring the maintenance script.";
$GLOBALS['strErrorLinkingBanner'] = "It was not possible to link this banner to this zone because:";
$GLOBALS['strUnableToLinkBanner'] = "Cannot link this banner: ";
$GLOBALS['strErrorEditingCampaignRevenue'] = "incorrect number format in Revenue Information field";
$GLOBALS['strErrorEditingCampaignECPM'] = "incorrect number format in ECPM Information field";
$GLOBALS['strErrorEditingZone'] = "Error updating zone:";
$GLOBALS['strUnableToChangeZone'] = "Cannot apply this change because:";
$GLOBALS['strDatesConflict'] = "Dates of the campaign you are trying to link overlap with the dates of a campaign already linked ";
$GLOBALS['strEmailNoDates'] = "Campaigns linked to Email Zones must have a start and end date set. {$PRODUCT_NAME} ensures that on a given date, only one active banner is linked to an Email Zone. Please ensure that the campaigns already linked to the zone do not have overlapping dates with the campaign you are trying to link.";
$GLOBALS['strWarningInaccurateStats'] = "Some of these statistics were logged in a non-UTC timezone, and may not be displayed in the correct timezone.";
$GLOBALS['strWarningInaccurateReadMore'] = "Read more about this";
$GLOBALS['strWarningInaccurateReport'] = "Some of the statistics in this report were logged in a non-UTC timezone, and may not be displayed in the correct timezone";

//Validation
$GLOBALS['strRequiredFieldLegend'] = "denotes required field";
$GLOBALS['strFormContainsErrors'] = "Form contains errors, please correct the marked fields below.";
$GLOBALS['strXRequiredField'] = "%s is required";
$GLOBALS['strEmailField'] = "Please enter a valid email";
$GLOBALS['strNumericField'] = "Please enter a number (only digits allowed)";
$GLOBALS['strGreaterThanZeroField'] = "Must be greater than 0";
$GLOBALS['strXGreaterThanZeroField'] = "%s must be greater than 0";
$GLOBALS['strXPositiveWholeNumberField'] = "%s must be a positive whole number";
$GLOBALS['strInvalidWebsiteURL'] = "Invalid Website URL";

// Email
$GLOBALS['strSirMadam'] = "Sir/Madam";
$GLOBALS['strMailSubject'] = "Advertiser report";
$GLOBALS['strMailHeader'] = "Dear {contact},";
$GLOBALS['strMailBannerStats'] = "Below you will find the banner statistics for {clientname}:";
$GLOBALS['strMailBannerActivatedSubject'] = "Campaign activated";
$GLOBALS['strMailBannerDeactivatedSubject'] = "Campaign deactivated";
$GLOBALS['strMailBannerActivated'] = "Your campaign shown below has been activated because
the campaign activation date has been reached.";
$GLOBALS['strMailBannerDeactivated'] = "Your campaign shown below has been deactivated because";
$GLOBALS['strMailFooter'] = "Regards,
   {adminfullname}";
$GLOBALS['strClientDeactivated'] = "This campaign is currently not active because";
$GLOBALS['strBeforeActivate'] = "the activation date has not yet been reached";
$GLOBALS['strAfterExpire'] = "the expiration date has been reached";
$GLOBALS['strNoMoreImpressions'] = "there are no Impressions remaining";
$GLOBALS['strNoMoreClicks'] = "there are no Clicks remaining";
$GLOBALS['strNoMoreConversions'] = "there are no Sales remaining";
$GLOBALS['strWeightIsNull'] = "its weight is set to zero";
$GLOBALS['strRevenueIsNull'] = "its revenue is set to zero";
$GLOBALS['strTargetIsNull'] = "its limit per day is set to zero - you need to either specify both an end date and a limit or set Limit per day value";
$GLOBALS['strNoViewLoggedInInterval'] = "No Impressions were logged during the span of this report";
$GLOBALS['strNoClickLoggedInInterval'] = "No Clicks were logged during the span of this report";
$GLOBALS['strNoConversionLoggedInInterval'] = "No Conversions were logged during the span of this report";
$GLOBALS['strMailReportPeriod'] = "This report includes statistics from {startdate} up to {enddate}.";
$GLOBALS['strMailReportPeriodAll'] = "This report includes all statistics up to {enddate}.";
$GLOBALS['strNoStatsForCampaign'] = "There are no statistics available for this campaign";
$GLOBALS['strImpendingCampaignExpiry'] = "Impending campaign expiration";
$GLOBALS['strYourCampaign'] = "Your campaign";
$GLOBALS['strTheCampiaignBelongingTo'] = "The campaign belonging to";
$GLOBALS['strImpendingCampaignExpiryDateBody'] = "{clientname} shown below is due to end on {date}.";
$GLOBALS['strImpendingCampaignExpiryImpsBody'] = "{clientname} shown below has less than {limit} impressions remaining.";
$GLOBALS['strImpendingCampaignExpiryBody'] = "As a result, the campaign will soon be automatically disabled, and the
following banners in the campaign will also be disabled:";

// Priority
$GLOBALS['strPriority'] = "الأهمية";
$GLOBALS['strSourceEdit'] = "Edit Sources";

// Preferences
$GLOBALS['strPreferences'] = "الخيارات";
$GLOBALS['strUserPreferences'] = "الخيارات العامة";
$GLOBALS['strChangePassword'] = "تغيير كلمة المرور";
$GLOBALS['strChangeEmail'] = "Change E-mail";
$GLOBALS['strCurrentPassword'] = "كلمة المرور الحالية";
$GLOBALS['strChooseNewPassword'] = "كلمة المرور الجديدة";
$GLOBALS['strReenterNewPassword'] = "إعادة كتابة كلمة المرور الجديدة";
$GLOBALS['strNameLanguage'] = "الإسم و اللغة";
$GLOBALS['strAccountPreferences'] = "خيارات الحساب";
$GLOBALS['strCampaignEmailReportsPreferences'] = "خيارات التقارير الخاصة بالحملة الإعلانية";
$GLOBALS['strTimezonePreferences'] = "Timezone Preferences";
$GLOBALS['strAdminEmailWarnings'] = "البريد الالكتروني للمدير العام";
$GLOBALS['strAgencyEmailWarnings'] = "التنبيهات البريدية للوكالة الإعلانية";
$GLOBALS['strAdveEmailWarnings'] = "التنبيهات البريدية للمعلنين";
$GLOBALS['strFullName'] = "الإسم الكامل";
$GLOBALS['strEmailAddress'] = "البريد الإلكتروني";
$GLOBALS['strUserDetails'] = "معلومات العضو";
$GLOBALS['strUserInterfacePreferences'] = "خيارات شكل لوحة التحكم";
$GLOBALS['strPluginPreferences'] = "الخيارات العامة";
$GLOBALS['strColumnName'] = "Column Name";
$GLOBALS['strShowColumn'] = "Show Column";
$GLOBALS['strCustomColumnName'] = "Custom Column Name";
$GLOBALS['strColumnRank'] = "Column Rank";

// Long names
$GLOBALS['strRevenue'] = "Revenue";
$GLOBALS['strNumberOfItems'] = "Number of items";
$GLOBALS['strRevenueCPC'] = "Revenue CPC";
$GLOBALS['strERPM'] = "تكلفة الظهور";
$GLOBALS['strERPC'] = "تكلفة الضغطات";
$GLOBALS['strERPS'] = "تكلفة الظهور";
$GLOBALS['strEIPM'] = "تكلفة الظهور";
$GLOBALS['strEIPC'] = "تكلفة الضغطات";
$GLOBALS['strEIPS'] = "تكلفة الظهور";
$GLOBALS['strECPM'] = "تكلفة الظهور";
$GLOBALS['strECPC'] = "تكلفة الضغطات";
$GLOBALS['strECPS'] = "تكلفة الظهور";
$GLOBALS['strPendingConversions'] = "Pending conversions";
$GLOBALS['strImpressionSR'] = "مرات الظهور";
$GLOBALS['strClickSR'] = "Click SR";

// Short names
$GLOBALS['strRevenue_short'] = "Rev.";
$GLOBALS['strBasketValue_short'] = "BV";
$GLOBALS['strNumberOfItems_short'] = "Num. Items";
$GLOBALS['strRevenueCPC_short'] = "Rev. CPC";
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
$GLOBALS['strRequests_short'] = "Req.";
$GLOBALS['strImpressions_short'] = "Impr.";
$GLOBALS['strClicks_short'] = "الضغطات";
$GLOBALS['strCTR_short'] = "معدل الضغطات";
$GLOBALS['strConversions_short'] = "Conv.";
$GLOBALS['strPendingConversions_short'] = "Pend conv.";
$GLOBALS['strImpressionSR_short'] = "Impr. SR";
$GLOBALS['strClickSR_short'] = "Click SR";

// Global Settings
$GLOBALS['strConfiguration'] = "Configuration";
$GLOBALS['strGlobalSettings'] = "الإعدادات العامة";
$GLOBALS['strGeneralSettings'] = "الإعدادات العامة";
$GLOBALS['strMainSettings'] = "Main Settings";
$GLOBALS['strPlugins'] = "Plugins";
$GLOBALS['strChooseSection'] = 'إختيار قسم';

// Product Updates
$GLOBALS['strProductUpdates'] = "Product Updates";
$GLOBALS['strViewPastUpdates'] = "Manage Past Updates and Backups";
$GLOBALS['strFromVersion'] = "From Version";
$GLOBALS['strToVersion'] = "To Version";
$GLOBALS['strToggleDataBackupDetails'] = "Toggle data backup details";
$GLOBALS['strClickViewBackupDetails'] = "click to view backup details";
$GLOBALS['strClickHideBackupDetails'] = "click to hide backup details";
$GLOBALS['strShowBackupDetails'] = "Show data backup details";
$GLOBALS['strHideBackupDetails'] = "Hide data backup details";
$GLOBALS['strBackupDeleteConfirm'] = "Do you really want to delete all backups created from this upgrade?";
$GLOBALS['strDeleteArtifacts'] = "Delete Artifacts";
$GLOBALS['strArtifacts'] = "Artifacts";
$GLOBALS['strBackupDbTables'] = "Backup database tables";
$GLOBALS['strLogFiles'] = "Log files";
$GLOBALS['strConfigBackups'] = "Conf backups";
$GLOBALS['strUpdatedDbVersionStamp'] = "Updated database version stamp";
$GLOBALS['aProductStatus']['UPGRADE_COMPLETE'] = "UPGRADE COMPLETE";
$GLOBALS['aProductStatus']['UPGRADE_FAILED'] = "UPGRADE FAILED";

// Agency
$GLOBALS['strAgencyManagement'] = "Account Management";
$GLOBALS['strAgency'] = "Account";
$GLOBALS['strAddAgency'] = "Add new account";
$GLOBALS['strAddAgency_Key'] = "إضافة منطقة عرض جديدة";
$GLOBALS['strTotalAgencies'] = "Total accounts";
$GLOBALS['strAgencyProperties'] = "Account Properties";
$GLOBALS['strNoAgencies'] = "لم يتم تعريف أي منطقة عرض";
$GLOBALS['strConfirmDeleteAgency'] = "هل تريد حذف منطقة العرض ؟";
$GLOBALS['strHideInactiveAgencies'] = "Hide inactive accounts";
$GLOBALS['strInactiveAgenciesHidden'] = "تم إخفاء مناطق العرض غير النشطة";
$GLOBALS['strSwitchAccount'] = "Switch to this account";
$GLOBALS['strAgencyStatusRunning'] = "Active";
$GLOBALS['strAgencyStatusInactive'] = "فعال";
$GLOBALS['strAgencyStatusPaused'] = "Suspended";

// Channels
$GLOBALS['strChannel'] = "Delivery Rule Set";
$GLOBALS['strChannels'] = "Delivery Rule Sets";
$GLOBALS['strChannelManagement'] = "Delivery Rule Set Management";
$GLOBALS['strAddNewChannel'] = "Add new Delivery Rule Set";
$GLOBALS['strAddNewChannel_Key'] = "Add <u>n</u>ew Delivery Rule Set";
$GLOBALS['strChannelToWebsite'] = "كل المواقع";
$GLOBALS['strNoChannels'] = "There are currently no delivery rule sets defined";
$GLOBALS['strNoChannelsAddWebsite'] = "There are currently no delivery rule sets defined, because there are no websites. To create a delivery rule set, <a href='affiliate-edit.php'>add a new website</a> first.";
$GLOBALS['strEditChannelLimitations'] = "Edit delivery rules for the delivery rule set";
$GLOBALS['strChannelProperties'] = "Delivery Rule Set Properties";
$GLOBALS['strChannelLimitations'] = "خيارات التوصيل";
$GLOBALS['strConfirmDeleteChannel'] = "Do you really want to delete this delivery rule set?";
$GLOBALS['strConfirmDeleteChannels'] = "Do you really want to delete the selected delivery rule sets?";
$GLOBALS['strChannelsOfWebsite'] = 'in'; //this is added between page name and website name eg. 'delivery rule sets in www.example.com'

// Tracker Variables
$GLOBALS['strVariableName'] = "Variable Name";
$GLOBALS['strVariableDescription'] = "الوصف";
$GLOBALS['strVariableDataType'] = "Data Type";
$GLOBALS['strVariablePurpose'] = "Purpose";
$GLOBALS['strGeneric'] = "عام";
$GLOBALS['strBasketValue'] = "Basket value";
$GLOBALS['strNumItems'] = "Number of items";
$GLOBALS['strVariableIsUnique'] = "Dedup conversions?";
$GLOBALS['strNumber'] = "Number";
$GLOBALS['strString'] = "String";
$GLOBALS['strTrackFollowingVars'] = "Track the following variable";
$GLOBALS['strAddVariable'] = "Add Variable";
$GLOBALS['strNoVarsToTrack'] = "No Variables to track.";
$GLOBALS['strVariableRejectEmpty'] = "Reject if empty?";
$GLOBALS['strTrackingSettings'] = "Tracking settings";
$GLOBALS['strTrackerType'] = "اسم المتتبع";
$GLOBALS['strTrackerTypeJS'] = "Track JavaScript variables";
$GLOBALS['strTrackerTypeDefault'] = "Track JavaScript variables (backwards compatible, escaping needed)";
$GLOBALS['strTrackerTypeDOM'] = "Track HTML elements using DOM";
$GLOBALS['strTrackerTypeCustom'] = "Custom JS code";
$GLOBALS['strVariableCode'] = "Javascript tracking code";

// Password recovery
$GLOBALS['strForgotPassword'] = "Forgot your password?";
$GLOBALS['strPasswordRecovery'] = "Password reset";
$GLOBALS['strEmailRequired'] = "Email is a required field";
$GLOBALS['strPwdRecWrongId'] = "Wrong ID";
$GLOBALS['strPwdRecEnterEmail'] = "Enter your email address below";
$GLOBALS['strPwdRecEnterPassword'] = "Enter your new password below";
$GLOBALS['strProceed'] = "Proceed >";
$GLOBALS['strNotifyPageMessage'] = "An e-mail has been sent to you, which includes a link that will allow you
                                         to reset your password and log in.<br />Please allow a few minutes for the e-mail to arrive.<br />
                                         If you do not receive the e-mail, please check your spam folder.<br />
                                         <a href=\"index.php\">Return to the main login page.</a>";

$GLOBALS['strPwdRecEmailPwdRecovery'] = "Reset Your %s Password";
$GLOBALS['strPwdRecEmailBody'] = "Dear {name},

You, or someone pretending to be you, recently requested that your {$PRODUCT_NAME} password be reset.

If this request was made by you, then you can reset the password for your username '{username}' by
clicking on the following link:

{reset_link}

If you submitted the password reset request by mistake, or if you didn't make a request at all, simply
ignore this email. No changes have been made to your password and the password reset link will expire
automatically.

If you continue to receive these password reset mails, then it may indicate that someone is attempting
to gain access to your username. In that case, please contact the support team or system administrator
for your {$PRODUCT_NAME} system, and notify them of the situation.

{admin_signature}";
$GLOBALS['strPwdRecEmailSincerely'] = "Sincerely,";

// Audit
$GLOBALS['strAdditionalItems'] = "and additional items";
$GLOBALS['strFor'] = "for";
$GLOBALS['strHas'] = "has";
$GLOBALS['strBinaryData'] = "معلومات Binary";
$GLOBALS['strAuditTrailDisabled'] = "Audit Trail has been disabled by the system administrator. No further events are logged and shown in Audit Trail list.";

// Widget - Audit
$GLOBALS['strAuditNoData'] = "No user activity has been recorded during the timeframe you have selected.";
$GLOBALS['strAuditTrail'] = "Audit Trail";
$GLOBALS['strAuditTrailSetup'] = "Setup the Audit Trail today";
$GLOBALS['strAuditTrailGoTo'] = "Go to Audit Trail page";
$GLOBALS['strAuditTrailNotEnabled'] = "<li>Audit Trail allows you to see who did what and when. Or to put it another way, it keeps track of system changes within {$PRODUCT_NAME}</li>
        <li>You are seeing this message, because you have not activated the Audit Trail</li>
        <li>Interested in learning more? Read the <a href='{$PRODUCT_DOCSURL}/admin/settings/auditTrail' class='site-link' target='help' >Audit Trail documentation</a></li>";

// Widget - Campaign
$GLOBALS['strCampaignGoTo'] = "Go to Campaigns page";
$GLOBALS['strCampaignSetUp'] = "Set up a Campaign today";
$GLOBALS['strCampaignNoRecords'] = "<li>Campaigns let you group together any number of banner ads, of any size, that share common advertising requirements</li>
        <li>Save time by grouping banners within a campaign and no longer define delivery settings for each ad separately</li>
        <li>Check out the <a class='site-link' target='help' href='{$PRODUCT_DOCSURL}/user/inventory/advertisersAndCampaigns/campaigns'>Campaign documentation</a>!</li>";
$GLOBALS['strCampaignNoRecordsAdmin'] = "<li>لا يوجد أي نشاط لأي حملة للعرض.</li>";

$GLOBALS['strCampaignNoDataTimeSpan'] = "No campaigns have started or finished during the timeframe you have selected";
$GLOBALS['strCampaignAuditNotActivated'] = "<li>In order to view campaigns which have started or finished during the timeframe you have selected, the Audit Trail must be activated</li>
        <li>You are seeing this message because you didn't activate the Audit Trail</li>";
$GLOBALS['strCampaignAuditTrailSetup'] = "Activate Audit Trail to start viewing Campaigns";

$GLOBALS['strUnsavedChanges'] = "You have unsaved changes on this page, make sure you press &quot;Save Changes&quot; when finished";
$GLOBALS['strDeliveryLimitationsDisagree'] = "WARNING: The cached delivery rules <strong>DO NOT AGREE</strong> with the delivery rules shown below<br />Please hit save changes to update the cached delivery rules";
$GLOBALS['strDeliveryRulesDbError'] = "WARNING: When saving the delivery rules, a database error occured. Please check the delivery rules below carefully, and update, if required.";
$GLOBALS['strDeliveryRulesTruncation'] = "WARNING: When saving the delivery rules, MySQL truncated the data, so the original values were restored. Please reduce your rule size, and try again.";
$GLOBALS['strDeliveryLimitationsInputErrors'] = "Some delivery rules report incorrect values:";

//confirmation messages
$GLOBALS['strYouAreNowWorkingAsX'] = "You are now working as <b>%s</b>";
$GLOBALS['strYouDontHaveAccess'] = "You don't have access to that page. You have been re-directed.";

$GLOBALS['strAdvertiserHasBeenAdded'] = "Advertiser <a href='%s'>%s</a> has been added, <a href='%s'>add a campaign</a>";
$GLOBALS['strAdvertiserHasBeenUpdated'] = "Advertiser <a href='%s'>%s</a> has been updated";
$GLOBALS['strAdvertiserHasBeenDeleted'] = "Advertiser <b>%s</b> has been deleted";
$GLOBALS['strAdvertisersHaveBeenDeleted'] = "All selected advertisers have been deleted";

$GLOBALS['strTrackerHasBeenAdded'] = "Tracker <a href='%s'>%s</a> has been added";
$GLOBALS['strTrackerHasBeenUpdated'] = "Tracker <a href='%s'>%s</a> has been updated";
$GLOBALS['strTrackerVarsHaveBeenUpdated'] = "Variables of tracker <a href='%s'>%s</a> have been updated";
$GLOBALS['strTrackerCampaignsHaveBeenUpdated'] = "Linked campaigns of tracker <a href='%s'>%s</a> have been updated";
$GLOBALS['strTrackerAppendHasBeenUpdated'] = "Append tracker code of tracker <a href='%s'>%s</a> has been updated";
$GLOBALS['strTrackerHasBeenDeleted'] = "Tracker <b>%s</b> has been deleted";
$GLOBALS['strTrackersHaveBeenDeleted'] = "All selected trackers have been deleted";
$GLOBALS['strTrackerHasBeenDuplicated'] = "Tracker <a href='%s'>%s</a> has been copied to <a href='%s'>%s</a>";
$GLOBALS['strTrackerHasBeenMoved'] = "Tracker <b>%s</b> has been moved to advertiser <b>%s</b>";

$GLOBALS['strCampaignHasBeenAdded'] = "Campaign <a href='%s'>%s</a> has been added, <a href='%s'>add a banner</a>";
$GLOBALS['strCampaignHasBeenUpdated'] = "Campaign <a href='%s'>%s</a> has been updated";
$GLOBALS['strCampaignTrackersHaveBeenUpdated'] = "Linked trackers of campaign <a href='%s'>%s</a> have been updated";
$GLOBALS['strCampaignHasBeenDeleted'] = "Campaign <b>%s</b> has been deleted";
$GLOBALS['strCampaignsHaveBeenDeleted'] = "All selected campaigns have been deleted";
$GLOBALS['strCampaignHasBeenDuplicated'] = "Campaign <a href='%s'>%s</a> has been copied to <a href='%s'>%s</a>";
$GLOBALS['strCampaignHasBeenMoved'] = "Campaign <b>%s</b> has been moved to advertiser <b>%s</b>";

$GLOBALS['strBannerHasBeenAdded'] = "Banner <a href='%s'>%s</a> has been added";
$GLOBALS['strBannerHasBeenUpdated'] = "Banner <a href='%s'>%s</a> has been updated";
$GLOBALS['strBannerAdvancedHasBeenUpdated'] = "Advanced settings for banner <a href='%s'>%s</a> have been updated";
$GLOBALS['strBannerAclHasBeenUpdated'] = "Delivery options for banner <a href='%s'>%s</a> have been updated";
$GLOBALS['strBannerAclHasBeenAppliedTo'] = "Delivery options for banner <a href='%s'>%s</a> have been applied to %d banners";
$GLOBALS['strBannerHasBeenDeleted'] = "Banner <b>%s</b> has been deleted";
$GLOBALS['strBannersHaveBeenDeleted'] = "All selected banners have been deleted";
$GLOBALS['strBannerHasBeenDuplicated'] = "Banner <a href='%s'>%s</a> has been copied to <a href='%s'>%s</a>";
$GLOBALS['strBannerHasBeenMoved'] = "Banner <b>%s</b> has been moved to campaign <b>%s</b>";
$GLOBALS['strBannerHasBeenActivated'] = "Banner <a href='%s'>%s</a> has been activated";
$GLOBALS['strBannerHasBeenDeactivated'] = "Banner <a href='%s'>%s</a> has been deactivated";

$GLOBALS['strXZonesLinked'] = "<b>%s</b> zone(s) linked";
$GLOBALS['strXZonesUnlinked'] = "<b>%s</b> zone(s) unlinked";

$GLOBALS['strWebsiteHasBeenAdded'] = "Website <a href='%s'>%s</a> has been added, <a href='%s'>add a zone</a>";
$GLOBALS['strWebsiteHasBeenUpdated'] = "Website <a href='%s'>%s</a> has been updated";
$GLOBALS['strWebsiteHasBeenDeleted'] = "Website <b>%s</b> has been deleted";
$GLOBALS['strWebsitesHaveBeenDeleted'] = "All selected website have been deleted";
$GLOBALS['strWebsiteHasBeenDuplicated'] = "Website <a href='%s'>%s</a> has been copied to <a href='%s'>%s</a>";

$GLOBALS['strZoneHasBeenAdded'] = "Zone <a href='%s'>%s</a> has been added";
$GLOBALS['strZoneHasBeenUpdated'] = "Zone <a href='%s'>%s</a> has been updated";
$GLOBALS['strZoneAdvancedHasBeenUpdated'] = "Advanced settings for zone <a href='%s'>%s</a> have been updated";
$GLOBALS['strZoneHasBeenDeleted'] = "Zone <b>%s</b> has been deleted";
$GLOBALS['strZonesHaveBeenDeleted'] = "All selected zone have been deleted";
$GLOBALS['strZoneHasBeenDuplicated'] = "Zone <a href='%s'>%s</a> has been copied to <a href='%s'>%s</a>";
$GLOBALS['strZoneHasBeenMoved'] = "Zone <b>%s</b> has been moved to website <b>%s</b>";
$GLOBALS['strZoneLinkedBanner'] = "Banner has been linked to zone <a href='%s'>%s</a>";
$GLOBALS['strZoneLinkedCampaign'] = "Campaign has been linked to zone <a href='%s'>%s</a>";
$GLOBALS['strZoneRemovedBanner'] = "Banner has been unlinked from zone <a href='%s'>%s</a>";
$GLOBALS['strZoneRemovedCampaign'] = "Campaign has been unlinked from zone <a href='%s'>%s</a>";

$GLOBALS['strChannelHasBeenAdded'] = "Delivery rule set <a href='%s'>%s</a> has been added. <a href='%s'>Set the delivery rules.</a>";
$GLOBALS['strChannelHasBeenUpdated'] = "Delivery rule set <a href='%s'>%s</a> has been updated";
$GLOBALS['strChannelAclHasBeenUpdated'] = "Delivery options for the delivery rule set <a href='%s'>%s</a> have been updated";
$GLOBALS['strChannelHasBeenDeleted'] = "Delivery rule set <b>%s</b> has been deleted";
$GLOBALS['strChannelsHaveBeenDeleted'] = "All selected delivery rule sets have been deleted";
$GLOBALS['strChannelHasBeenDuplicated'] = "Delivery rule set <a href='%s'>%s</a> has been copied to <a href='%s'>%s</a>";

$GLOBALS['strUserPreferencesUpdated'] = "Your <b>%s</b> preferences has been updated";
$GLOBALS['strEmailChanged'] = "Your E-mail has been changed";
$GLOBALS['strPasswordChanged'] = "Your password has been changed";
$GLOBALS['strXPreferencesHaveBeenUpdated'] = "<b>%s</b> have been updated";
$GLOBALS['strXSettingsHaveBeenUpdated'] = "<b>%s</b> have been updated";
$GLOBALS['strTZPreferencesWarning'] = "However, campaign activation and expiry were not updated, nor time-based banner delivery rules.<br />You will need to update them manually if you wish them to use the new timezone";

// Report error messages
$GLOBALS['strReportErrorMissingSheets'] = "No worksheet was selected for report";
$GLOBALS['strReportErrorUnknownCode'] = "Unknown error code #";

/* ------------------------------------------------------- */
/* Keyboard shortcut assignments                           */
/* ------------------------------------------------------- */

// Reserved keys
// Do not change these unless absolutely needed
$GLOBALS['keyHome'] = "h";
$GLOBALS['keyUp'] = "u";
$GLOBALS['keyNextItem'] = ".";
$GLOBALS['keyPreviousItem'] = ",";
$GLOBALS['keyList'] = "l";

// Other keys
// Please make sure you underline the key you
// used in the string in default.lang.php
$GLOBALS['keySearch'] = "s";
$GLOBALS['keyCollapseAll'] = "c";
$GLOBALS['keyExpandAll'] = "e";
$GLOBALS['keyAddNew'] = "n";
$GLOBALS['keyNext'] = "n";
$GLOBALS['keyPrevious'] = "p";
$GLOBALS['keyLinkUser'] = "u";
$GLOBALS['keyWorkingAs'] = "w";
