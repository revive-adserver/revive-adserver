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
$GLOBALS['phpAds_ThousandsSeperator'] = ",";

// Date & time configuration
$GLOBALS['day_format'] = "%d-%m";

// Formats used by PEAR Spreadsheet_Excel_Writer packate

/* ------------------------------------------------------- */
/* Translations                                          */
/* ------------------------------------------------------- */

$GLOBALS['strHome'] = "خانه";
$GLOBALS['strHelp'] = "کمک";
$GLOBALS['strStartOver'] = "شروع دوباره";
$GLOBALS['strShortcuts'] = "کلید های میانبر";
$GLOBALS['strActions'] = "اقدامات";
$GLOBALS['strAndXMore'] = "و %s بیشتر";
$GLOBALS['strAdminstration'] = "فهرست";
$GLOBALS['strMaintenance'] = "نگهداری";
$GLOBALS['strProbability'] = "احتمال";
$GLOBALS['strInvocationcode'] = "
کد نیایش";
$GLOBALS['strBasicInformation'] = "
اطلاعات اولیه";
$GLOBALS['strAppendTrackerCode'] = "اضافه کد ردیاب";
$GLOBALS['strOverview'] = "
بررسی اجمالی";
$GLOBALS['strSearch'] = "<u>جستجو</u>";
$GLOBALS['strDetails'] = "جزییات";
$GLOBALS['strUpdateSettings'] = "تنظیمات به روز رسانی ";
$GLOBALS['strCheckForUpdates'] = "بررسی به روز رسانی ها";
$GLOBALS['strWhenCheckingForUpdates'] = "هنگامی که برای به روز رسانی بررسی می شود";
$GLOBALS['strCompact'] = "
جمع و جور";
$GLOBALS['strUser'] = "کاربر";
$GLOBALS['strDuplicate'] = "
تکراری";
$GLOBALS['strCopyOf'] = "
رونوشت";
$GLOBALS['strMoveTo'] = "
انتقال به";
$GLOBALS['strDelete'] = "حذف";
$GLOBALS['strActivate'] = "فعال کردن";
$GLOBALS['strConvert'] = "
تبدیل";
$GLOBALS['strRefresh'] = "
تازه کردن";
$GLOBALS['strSaveChanges'] = "ذخیره تغییرات";
$GLOBALS['strUp'] = "بالا";
$GLOBALS['strDown'] = "پایین";
$GLOBALS['strSave'] = "ذخیره";
$GLOBALS['strCancel'] = "لغو";
$GLOBALS['strBack'] = "عقب";
$GLOBALS['strPrevious'] = "قبلی";
$GLOBALS['strNext'] = "بعدی";
$GLOBALS['strYes'] = "بله";
$GLOBALS['strNo'] = "خیر";
$GLOBALS['strNone'] = "هیچ";
$GLOBALS['strCustom'] = "سفارشی";
$GLOBALS['strDefault'] = "
به طور پیش فرض";
$GLOBALS['strUnknown'] = "مجهول";
$GLOBALS['strUnlimited'] = "بدون محدودیت";
$GLOBALS['strUntitled'] = "بدون تیتر";
$GLOBALS['strAll'] = "همه";
$GLOBALS['strAverage'] = "میانگین";
$GLOBALS['strOverall'] = "به طور کلی";
$GLOBALS['strTotal'] = "نتیجه";
$GLOBALS['strFrom'] = "از";
$GLOBALS['strTo'] = "به";
$GLOBALS['strAdd'] = "اضافه کردن";
$GLOBALS['strLinkedTo'] = "وصل است به";
$GLOBALS['strDaysLeft'] = "روزهای باقی مانده";
$GLOBALS['strCheckAllNone'] = "همه رو بررسی کن / هیچی";
$GLOBALS['strKiloByte'] = "کیلوبایت";
$GLOBALS['strExpandAll'] = "<u>
باز کردن همه</u>";
$GLOBALS['strCollapseAll'] = "<u>جمع شدن همه</u>";
$GLOBALS['strShowAll'] = "همه را نشان بده";
$GLOBALS['strNoAdminInterface'] = "صفحه نمایش مدیریت خاموش شده است برای تعمیر و نگهداری.  این بر روی تحویل مبارزات شما تاثیر نخواهد گذاشت.";
$GLOBALS['strFieldStartDateBeforeEnd'] = "'از 'تاریخ باید قبل از تاریخ' به 'شود";
$GLOBALS['strFieldContainsErrors'] = "زمینه های زیر حاوی اشتباهات:";
$GLOBALS['strFieldFixBeforeContinue1'] = "قبل از ادام ، شما باید ";
$GLOBALS['strFieldFixBeforeContinue2'] = "برای رفع این خطا ها ";
$GLOBALS['strMiscellaneous'] = "
متفرقه";
$GLOBALS['strCollectedAllStats'] = "همه آمار";
$GLOBALS['strCollectedToday'] = "امروز";
$GLOBALS['strCollectedYesterday'] = "دیروز";
$GLOBALS['strCollectedThisWeek'] = "این هفته";
$GLOBALS['strCollectedLastWeek'] = "هفته پیش";
$GLOBALS['strCollectedThisMonth'] = "این ماه";
$GLOBALS['strCollectedLastMonth'] = "ماه قبل";
$GLOBALS['strCollectedLast7Days'] = "7 روز گذشته";
$GLOBALS['strCollectedSpecificDates'] = "روزهای مشخص";
$GLOBALS['strValue'] = "ارزش";
$GLOBALS['strWarning'] = "اخطار";
$GLOBALS['strNotice'] = "توجه";

// Dashboard
$GLOBALS['strDashboardCantBeDisplayed'] = "داشبورد نمایش داده نمی شود";
$GLOBALS['strNoCheckForUpdates'] = "
داشبورد نمی تواند نمایش داده شود مگر اینکه<br />برای تنظیم به روز رسانی بررسی را فعال کنید.";
$GLOBALS['strEnableCheckForUpdates'] = "لطفا فعال ککنید  <a href='account-settings-update.php' target='_top'>جست و ججو برای تبلیغات را </a> تنظیمات در<br/><a href='account-settings-update.php' target='_top'>تنظیمات به روز رسانی</a> page.";
// Dashboard Errors
$GLOBALS['strDashboardErrorCode'] = "کد";
$GLOBALS['strDashboardSystemMessage'] = "پیام سیستم ";
$GLOBALS['strDashboardErrorHelp'] = "
اگر این خطا تکرار شد لطفا مشکل خود را با جزییات تشریح دهید و آن را به <a href='http://forum.revive-adserver.com/'>forum.revive-adserver.com/</a> ارسال کنید.";

// Priority
$GLOBALS['strPriority'] = "
اولویت";
$GLOBALS['strPriorityLevel'] = "
سطح اولویت";
$GLOBALS['strOverrideAds'] = "نادیده گرفتن کمپین تبلیغات";
$GLOBALS['strHighAds'] = "
قرارداد کمپین تبلیغات";
$GLOBALS['strECPMAds'] = "eCPM کمپین تبلیغات";
$GLOBALS['strLowAds'] = "تبلیغات کمپین باقی ماندهs";
$GLOBALS['strCapping'] = "
سر پوش";

// Properties
$GLOBALS['strName'] = "نام";
$GLOBALS['strSize'] = "اندازه";
$GLOBALS['strWidth'] = "عرض";
$GLOBALS['strHeight'] = "طول";
$GLOBALS['strTarget'] = "هدف";
$GLOBALS['strLanguage'] = "زبان";
$GLOBALS['strDescription'] = "توضیحات";
$GLOBALS['strVariables'] = "مقادیر";
$GLOBALS['strID'] = "شناسه";
$GLOBALS['strComments'] = "توضیحات";

// User access
$GLOBALS['strWorkingAs'] = "
کار به عنوان";
$GLOBALS['strWorkingAs_Key'] = "<u>
کار به عنوان</u>";
$GLOBALS['strWorkingAs'] = "
کار به عنوان";
$GLOBALS['strSwitchTo'] = "
تغییر به";
$GLOBALS['strUseSearchBoxToFindMoreAccounts'] = "استفاده از جعبه سوئیچر جستجو برای پیدا کردن حساب های بیشتر";
$GLOBALS['strWorkingFor'] = "%s برای...";
$GLOBALS['strNoAccountWithXInNameFound'] = "حساب کاربری با اسم  \"%s\" پیدا نشد";
$GLOBALS['strRecentlyUsed'] = "اخیرا مورد استفاده قرار گرفته";
$GLOBALS['strLinkUser'] = "اضافه کردن کاربر ";
$GLOBALS['strLinkUser_Key'] = "اضافه کردن <u>کاربر</u>";
$GLOBALS['strUsernameToLink'] = "نام کاربری کاربر برای اضافه کردن";
$GLOBALS['strNewUserWillBeCreated'] = "
کاربر جدید ایجاد خواهد شد";
$GLOBALS['strToLinkProvideEmail'] = "برای اضافه کردن کاربر، ارائه ایمیل کاربر";
$GLOBALS['strToLinkProvideUsername'] = "
برای اضافه کردن کاربر، ارائه نام کاربری";
$GLOBALS['strUserAccountUpdated'] = "حساب کاربر به روز شد";
$GLOBALS['strUserWasDeleted'] = "کاربر حذف شد";
$GLOBALS['strUserNotLinkedWithAccount'] = "چنین کاربر با حساب مرتبط نیست";
$GLOBALS['strLinkUserHelp'] = "برای اضاقه کردن <b>کاربر موجود</b>, بنویسدe %1\$s و کلیک کنید %2\$s <br />باز اضافه کردن <b>کاربر جدید</b>, نوع مورد نظر را تایپ کنید %1\$s و کلیک کنید %2\$s";
$GLOBALS['strLinkUserHelpUser'] = "نام کاربری";
$GLOBALS['strLinkUserHelpEmail'] = "آدرس ایمیل";
$GLOBALS['strLastLoggedIn'] = "آخرین ورود";
$GLOBALS['strDateLinked'] = "زمان اتصال";

// Login & Permissions
$GLOBALS['strUserAccess'] = "دسترسی کاربر";
$GLOBALS['strAdminAccess'] = "دسترسی مدیریت";
$GLOBALS['strUserProperties'] = "ویژگی های کاربر";
$GLOBALS['strPermissions'] = "اجازه ها";
$GLOBALS['strAuthentification'] = "احراز هویت";
$GLOBALS['strWelcomeTo'] = "خوش آمدید به ";
$GLOBALS['strEnterUsername'] = "نام کاربری و رمز خود را برای ورود وارد کنید";
$GLOBALS['strEnterBoth'] = "لطفا هم نام کاربری و هم رمز را وارد کنید";
$GLOBALS['strEnableCookies'] = "شما نیاز به فعال کردن کوکی ها دارید قبل از استفاده از {$PRODUCT_NAME}";
$GLOBALS['strSessionIDNotMatch'] = "خطا در کوکی ، لطفا دوباره وارد شوید";
$GLOBALS['strLogin'] = "ورود";
$GLOBALS['strLogout'] = "خروج";
$GLOBALS['strUsername'] = "نام کاربری";
$GLOBALS['strPassword'] = "رمز ";
$GLOBALS['strPasswordRepeat'] = "دوباره رمز را وارد کنید";
$GLOBALS['strAccessDenied'] = "دسترسی قطع شد";
$GLOBALS['strUsernameOrPasswordWrong'] = "نام کاربری یا رمز درست وارد نشده است . لطفا دوباره تلاش کنید ..";
$GLOBALS['strPasswordWrong'] = "رمز درست نیست ";
$GLOBALS['strNotAdmin'] = "حساب کاربری شما سطح دسترسی مورد نیاز برای استفاده از این ویژگی را ندارد، شما می توانید به حساب دیگر، ورود آن استفاده کنید.";
$GLOBALS['strDuplicateClientName'] = "نام کاربری شما ارائه قبل وجود دارد، لطفا با استفاده از نام کاربری دیگری وارد شوید.";
$GLOBALS['strInvalidPassword'] = "رمز عبور جدید نامعتبر است, لطفا از یک رمز عبور متفاوت استفاده کنید.";
$GLOBALS['strInvalidEmail'] = "ایمیل صحیح فرمت نشده است, لطفا آدرس ایمیل صحیح را قرار دهید.";
$GLOBALS['strNotSamePasswords'] = "دو رمز ورودی یکسان نیستند";
$GLOBALS['strRepeatPassword'] = "رمز را دوباره بزن";
$GLOBALS['strDeadLink'] = "لینک شما نا معتبر است .";
$GLOBALS['strNoPlacement'] = "کمپین انتخاب شده وجود ندارد.  این رو به جاش امتحان کنید  <a href='{link}'>لینک</a> ";
$GLOBALS['strNoAdvertiser'] = "
تبلیغ انتخاب شده وجود ندارد. این را امتحان کنید <a href='{link}'>لینک </a> ";

// General advertising
$GLOBALS['strRequests'] = "درخواست ها";
$GLOBALS['strImpressions'] = "احساسs";
$GLOBALS['strClicks'] = "کلیک";
$GLOBALS['strConversions'] = "
تبدیل";
$GLOBALS['strCTRShort'] = "نرخ کلیک";
$GLOBALS['strCTR'] = "کلیک از طریق نسبت";
$GLOBALS['strTotalClicks'] = "مجموع کلیک ها";
$GLOBALS['strTotalConversions'] = "مجموع مکالمات";
$GLOBALS['strDateTime'] = "زمان تاریخ";
$GLOBALS['strTrackerID'] = "ردیاب  ID";
$GLOBALS['strTrackerName'] = "ردیاب  اسم";
$GLOBALS['strTrackerImageTag'] = "برچسب تصویر";
$GLOBALS['strTrackerJsTag'] = "برچسب Javascript";
$GLOBALS['strTrackerAlwaysAppend'] = " همیشه  کد منضم را نشان بده, حتی اگر مکالمه ای توسط ردیاب ذخیره نشده باشد?";
$GLOBALS['strBanners'] = "تبلیغات";
$GLOBALS['strCampaigns'] = "کمپین ها";
$GLOBALS['strCampaignID'] = "کمپین ID";
$GLOBALS['strCampaignName'] = "اسم کمپین";
$GLOBALS['strCountry'] = "کشور";
$GLOBALS['strStatsAction'] = "اقدامات";
$GLOBALS['strWindowDelay'] = "تاخیر پنجره";
$GLOBALS['strStatsVariables'] = "مقادیر";

// Finance
$GLOBALS['strFinanceMT'] = "مدت اجاره";
$GLOBALS['strFinanceCTR'] = "نرخ کلیک";
$GLOBALS['strFinanceCR'] = "کپی رایت";

// Time and date related
$GLOBALS['strDate'] = "تاریخ";
$GLOBALS['strDay'] = "روز";
$GLOBALS['strDays'] = "روزها";
$GLOBALS['strWeek'] = "هفته";
$GLOBALS['strWeeks'] = "هفته ها";
$GLOBALS['strSingleMonth'] = "ماه";
$GLOBALS['strMonths'] = "ماه ها";
$GLOBALS['strDayOfWeek'] = "روز هفته";


if (!isset($GLOBALS['strDayFullNames'])) {
    $GLOBALS['strDayFullNames'] = [];
}
$GLOBALS['strDayFullNames'][0] = 'یک شنبه';
$GLOBALS['strDayFullNames'][1] = 'دو شنبه';
$GLOBALS['strDayFullNames'][2] = 'سه شنبه';
$GLOBALS['strDayFullNames'][3] = 'چهار شنبه';
$GLOBALS['strDayFullNames'][4] = 'پنج شنبه';
$GLOBALS['strDayFullNames'][5] = 'جمعه';
$GLOBALS['strDayFullNames'][6] = 'شنبه';

if (!isset($GLOBALS['strDayShortCuts'])) {
    $GLOBALS['strDayShortCuts'] = [];
}
$GLOBALS['strDayShortCuts'][0] = 'یکشنبه';
$GLOBALS['strDayShortCuts'][1] = 'دوشنبه';
$GLOBALS['strDayShortCuts'][2] = 'سه شنبه';
$GLOBALS['strDayShortCuts'][3] = 'چهارشنبه';
$GLOBALS['strDayShortCuts'][4] = 'پنجشنبه';
$GLOBALS['strDayShortCuts'][5] = 'جمعه';
$GLOBALS['strDayShortCuts'][6] = 'شنبه';

$GLOBALS['strHour'] = "ساعت";
$GLOBALS['strSeconds'] = "ثانیه ها";
$GLOBALS['strMinutes'] = "دقیقه ها";
$GLOBALS['strHours'] = "ساعت ها";

// Advertiser
$GLOBALS['strClient'] = "تبلیغ کننده";
$GLOBALS['strClients'] = "تبلیغات کننده ها";
$GLOBALS['strClientsAndCampaigns'] = "تبلیغات کننده ها و کمپین ها";
$GLOBALS['strAddClient'] = "تبلیغ ککننده جدید اضافه کنید";
$GLOBALS['strClientProperties'] = "ویژگی های تبلیغ کننده ";
$GLOBALS['strClientHistory'] = "آمار تبلیغ کننده";
$GLOBALS['strNoClients'] = "در حال حاضر هیچ تبلیغ تعریف شده وجود ندارد.برای ایجاد یک کمپین, ابتدا <a href='advertiser-edit.php'>اضافه کنید تبلیغ کننده جدید</a>.";
$GLOBALS['strConfirmDeleteClient'] = "آیا واقعا میخواهید این تبلیغ کننده را حذف کنید؟";
$GLOBALS['strConfirmDeleteClients'] = "
آیا شما واقعا مایل به حذف تبلیغ کننده انتخاب شده اید؟";
$GLOBALS['strHideInactive'] = "پنهان کردن غیرفعال";
$GLOBALS['strInactiveAdvertisersHidden'] = "تبلیغ کنندگان غیر فعال (بازدید کنندگان) پنهان شدند";
$GLOBALS['strAdvertiserSignup'] = "ثبت نام تبلیغ کننده";
$GLOBALS['strAdvertiserCampaigns'] = "کمپین تبلیغ کنننده";

// Advertisers properties
$GLOBALS['strContact'] = "مخاطب";
$GLOBALS['strContactName'] = "نام مخاطب";
$GLOBALS['strEMail'] = "ایمیل";
$GLOBALS['strSendAdvertisingReport'] = "ایمیل گزارش تحویل کمپین";
$GLOBALS['strNoDaysBetweenReports'] = "تعداد روزهای بین گزارش تحویل کمپین";
$GLOBALS['strSendDeactivationWarning'] = "
ایمیل زمانی که یک کمپین به طور خودکار فعال / غیر فعال";
$GLOBALS['strAllowClientModifyBanner'] = "
به این کاربر اجازه تغییر آگهی ها خود را بدهید";
$GLOBALS['strAllowClientDisableBanner'] = "به این کاربر اجازه غیر فعال کردن آگهی ها خود را بدهید";
$GLOBALS['strAllowClientActivateBanner'] = "به این کاربر اجازه فعال شدن آگهی ها خود را بدهید";
$GLOBALS['strAdvertiserLimitation'] = "نمایش تنها یک بنر از این تبلیغ کننده در صفحه وب";
$GLOBALS['strAllowAuditTrailAccess'] = "به این کاربر اجازه دسترسی به دنباله حسابرسی بدهید";

// Campaign
$GLOBALS['strCampaign'] = "کمپین";
$GLOBALS['strCampaigns'] = "کمپین ها";
$GLOBALS['strAddCampaign'] = "کمپین جدید ایجاد کنید";
$GLOBALS['strAddCampaign_Key'] = " <u>جدید</u> ایجاد کمپین";
$GLOBALS['strCampaignForAdvertiser'] = "برای تبلیغ کنندگان";
$GLOBALS['strLinkedCampaigns'] = "کمپین مرتبط";
$GLOBALS['strCampaignProperties'] = "
خواص کمپین";
$GLOBALS['strCampaignOverview'] = "
نمای کلی کمپین";
$GLOBALS['strCampaignHistory'] = "آمار کمپین";
$GLOBALS['strNoCampaigns'] = "در حال حاضر هیچ کمپین تعریف شده برای این تبلیغ کنندگان وجود دارد.";
$GLOBALS['strNoCampaignsAddAdvertiser'] = "در حال حاضر هیچ کمپین تعریف شده وجود ندارد, زیرا هیچ تبلیغ کننده وجود دارد. 
برای ایجاد یک کمپین, <a href='advertiser-edit.php'>aاضافه کردن تبلیغ کنندگان جدید</a> ابتدا.";
$GLOBALS['strConfirmDeleteCampaign'] = "
آیا واقعا میخواهید این کمپین را حذف کنید؟";
$GLOBALS['strConfirmDeleteCampaigns'] = "آیا شما واقعا مایل به حذف کمپین انتخاب شده اید؟";
$GLOBALS['strShowParentAdvertisers'] = "خانواده تبلیغ کننده را نشان ده ";
$GLOBALS['strHideParentAdvertisers'] = "خانواده تبلیغ کننده را پنهان کن ";
$GLOBALS['strHideInactiveCampaigns'] = "
مخفی کردن کمپین های غیر فعال";
$GLOBALS['strInactiveCampaignsHidden'] = "کمپین غیر فعال (هپنهان شدندکمپین غیر فعال (ها) پنهان شدند";
$GLOBALS['strPriorityInformation'] = "
اولویت در رابطه با دیگر کمپین";
$GLOBALS['strECPMInformation'] = "اولویت بندی ECPM";
$GLOBALS['strRemnantEcpmDescription'] = "eCPM به طور خودکار بر اساس عملکرد این کمپین محاسبه می شود.<br />این استفاده می شود برای اولویت بندی مبارزات باقی مانده نسبت به یکدیگر.";
$GLOBALS['strEcpmMinImpsDescription'] = "این را به مجموعه حداقل اساس مورد نظر خود را که در آن به محاسبه ECPM این کمپین است.";
$GLOBALS['strHiddenCampaign'] = "کمپین";
$GLOBALS['strHiddenAd'] = "تبلیغات";
$GLOBALS['strHiddenAdvertiser'] = "تبلیغ کننده";
$GLOBALS['strHiddenTracker'] = "ردیاب";
$GLOBALS['strHiddenWebsite'] = "وب سایت";
$GLOBALS['strHiddenZone'] = "منطقه";
$GLOBALS['strCampaignDelivery'] = "دریافت کمپین";
$GLOBALS['strCompanionPositioning'] = "موقعیت همنشین";
$GLOBALS['strSelectUnselectAll'] = "انتخاب / عدم انتخاب همه";
$GLOBALS['strCampaignsOfAdvertiser'] = "از"; //this is added between page name and advertiser name eg. 'Campaigns of Advertiser 1'
$GLOBALS['strShowCappedNoCookie'] = " تبلیغات دربسته اگر کوکی ها غیر فعال هستند نشان داده شود";

// Campaign-zone linking page
$GLOBALS['strCalculatedForAllCampaigns'] = "
محاسبه شده برای تمامی کمپین ها";
$GLOBALS['strCalculatedForThisCampaign'] = "
محاسبه برای این کمپین";
$GLOBALS['strLinkingZonesProblem'] = "مشکل رخ داده است هنگام ارتباط مناطق";
$GLOBALS['strUnlinkingZonesProblem'] = "مشکل رخ داده است هنگام لغو پیوند مناطق";
$GLOBALS['strZonesLinked'] = "
منطقه (ها) مرتبط";
$GLOBALS['strZonesUnlinked'] = "
منطقه (ها) غیر مرتبط";
$GLOBALS['strZonesSearch'] = "
جستجو کردن";
$GLOBALS['strZonesSearchTitle'] = "مناطق جستجو و وب سایت های با نام";
$GLOBALS['strNoWebsitesAndZones'] = "
هیچ وب سایت و مناطق";
$GLOBALS['strNoWebsitesAndZonesText'] = "با \"%s\" در اسم";
$GLOBALS['strToLink'] = "
اتصال دادن";
$GLOBALS['strToUnlink'] = "تا قطع ارتباط";
$GLOBALS['strLinked'] = "
مرتبط";
$GLOBALS['strAvailable'] = "در دسترس";
$GLOBALS['strShowing'] = "نمایش";
$GLOBALS['strEditZone'] = "
ویرایش منطقه";
$GLOBALS['strEditWebsite'] = "ویرایش وب سایت";


// Campaign properties
$GLOBALS['strDontExpire'] = "
منقضی نیست";
$GLOBALS['strActivateNow'] = "شروع بلافاصله";
$GLOBALS['strSetSpecificDate'] = "
تاریخ خاصی را تنظیم کنید";
$GLOBALS['strLow'] = "ضعیف";
$GLOBALS['strHigh'] = "قوی";
$GLOBALS['strExpirationDate'] = "پایان تاریخ";
$GLOBALS['strExpirationDateComment'] = "کمپین در پایان این روز به پایان برسد";
$GLOBALS['strActivationDate'] = "
تاریخ شروع";
$GLOBALS['strActivationDateComment'] = "کمپین در آغاز این روز آغاز میشود";
$GLOBALS['strImpressionsRemaining'] = "برداشت باقی مانده";
$GLOBALS['strClicksRemaining'] = "کلیک باقی مانده";
$GLOBALS['strConversionsRemaining'] = "تبدیل باقی مانده";
$GLOBALS['strImpressionsBooked'] = "
برداشت رزرو شده";
$GLOBALS['strClicksBooked'] = "
کلیک رزرو شده";
$GLOBALS['strConversionsBooked'] = "
تبدیل رزرو شده";
$GLOBALS['strCampaignWeight'] = "
تنظیم وزن کمپین";
$GLOBALS['strAnonymous'] = "مخفی کردن تبلیغ کنندگان و وب سایت این کمپین.";
$GLOBALS['strTargetPerDay'] = "در روز.";
$GLOBALS['strCampaignWarningRemnantNoWeight'] = "
نوع این کمپین تعیین شده است برای باقی مانده,
اما وزن روی صفر تنظیم و یا از آن شده است نمی
مشخص شده. این کمپین باعث می شود
غیر فعال و آگهی ها خود را تحویل داده نخواهد شد
تا زمانی که وزن شده است به یک شماره تلفن معتبر تنظیم شده است.

آیا مطمئن هستید که میخواهید ادامه دهید؟";
$GLOBALS['strCampaignWarningEcpmNoRevenue'] = "این کمپین با استفاده از بهینه سازی ECPM

اما «درآمد» را روی صفر تنظیم و یا آن مشخص نشده است.
این باعث می شود این کمپین غیر فعال شود
و آگهی ها آن دریافت نخواهد شد تا
درآمد بر روی یک مقدار معتبر تنظیم شودr.


آیا مطمئن هستید که میخواهید ادامه دهید؟";
$GLOBALS['strCampaignWarningOverrideNoWeight'] = "نوع این کمپین نادیده گرفته شده است,

اما وزن روی صفر تنظیم و یا
مشخص نشده است ین باعث می شود کمپین
غیر فعال و آگهی ها آن ها دریافت نشود
تا زمانی که وزن بر روی یک مقدار معتبر تنظیم شود.

آیا مطمئن هستید که میخواهید ادامه دهید؟";
$GLOBALS['strCampaignWarningNoTarget'] = "
نوع این کمپین تنظیم شده به صورت به قرارداد،
اما حد پستها در طول روز مشخص نشده است.
این باعث می شود این کمپین غیر فعال شود و
آگهی ها آن ها تحویل داده نخواهد شد تا زمانی که یک محدوده معتبر پستها در طول روز تعیین شده باشد.


آیا مطمئن هستید که میخواهید ادامه دهید؟";
$GLOBALS['strCampaignStatusPending'] = "
در انتظار";
$GLOBALS['strCampaignStatusInactive'] = "
غیر فعال";
$GLOBALS['strCampaignStatusRunning'] = "در حال اجرا";
$GLOBALS['strCampaignStatusPaused'] = "
مکث";
$GLOBALS['strCampaignStatusAwaiting'] = "
چشم انتظار";
$GLOBALS['strCampaignStatusExpired'] = "
تکمیل شده";
$GLOBALS['strCampaignStatusApproval'] = "
منتظر تایید »";
$GLOBALS['strCampaignStatusRejected'] = "
رد شد ";
$GLOBALS['strCampaignStatusAdded'] = "اضافه شد ";
$GLOBALS['strCampaignStatusStarted'] = "شروع شد";
$GLOBALS['strCampaignStatusRestarted'] = "راه اندازی مجدد";
$GLOBALS['strCampaignStatusDeleted'] = "حذف شده";
$GLOBALS['strCampaignType'] = "
نوع کمپین";
$GLOBALS['strType'] = "نوع";
$GLOBALS['strContract'] = "تماس";
$GLOBALS['strOverride'] = "باطل کردن";
$GLOBALS['strOverrideInfo'] = "کمپین نادیده گرفته شده یک نوع کمپین ویژه به طور خاص برای
     باطل کردن )اولویت به بیش) 
کمپین باقی مانده و قرارداد.کمپین نادیده گرفته شده به طور کلی با
     هدف قرار دادن خاص و / یا دربندی قوانین به اطمینان حاصل شود استفاده می شود که آگهی ها کمپین همیشه در مکان معین نمایش داده می شود
     به کاربران خاص، و شاید یک تعداد معینی از زمان، به عنوان بخشی از ارتقاء خاص (این کمپین
     نوع قبلا به عنوان قرارداد (منحصر به فرد) شناخته می شد.).)";
$GLOBALS['strStandardContract'] = "تماس";
$GLOBALS['strStandardContractInfo'] = "کمپین قرارداد برای هموار ارائه برداشت هستند
     مورد نیاز برای رسیدن به یک زمان بحرانی عملکرد مورد نیاز مشخص شده است. این است که، کمپین قرارداد برای زمانی که می
     یک تبلیغ است به طور خاص پرداخت می شود به یک تعداد معین از برداشت، کلیک و / یا تبدیل به
     به دست آورد یا بین دو تاریخ، و یا در روز است.";
$GLOBALS['strRemnant'] = "باقی مانده";
$GLOBALS['strRemnantInfo'] = "نوع کمپین به طور پیش فرض. کمپین باقی مانده تعداد زیادی از مختلف
     گزینه های تحویل داده شده است ، و شما باید در حالت ایده آل همیشه حداقل یک کمپین باقی مانده مربوط به هر منطقه، برای اطمینان از
     است که همیشه چیزی برای نمایش وجود دارد. استفاده از کمپین های باقی مانده برای نمایش آگهی به خانه، آگهی ها آگهی های شبکه، و یا حتی
     تبلیغات مستقیم است که فروخته شده است، اما جایی است که یک عملکرد مورد نیاز زمان بحرانی برای وجود ندارد
     کمپین به پایبندی به.";
$GLOBALS['strECPMInfo'] = "این یک کمپین استاندارد است که می تواند با هر دو تاریخ پایان و یا محدود کردن خاص محدود است. بر اساس تنظیمات فعلی با استفاده از CPM اولویت بندی خواهد شد.";
$GLOBALS['strPricing'] = "
قیمت گذاری";
$GLOBALS['strPricingModel'] = "
مدل قیمت گذاری";
$GLOBALS['strSelectPricingModel'] = "-- 
مدل را انتخاب کنید--";
$GLOBALS['strRatePrice'] = "
نرخ / هزینه";
$GLOBALS['strMinimumImpressions'] = "
حداقل برداشت روزانه";
$GLOBALS['strLimit'] = "
حد";
$GLOBALS['strLowExclusiveDisabled'] = "شما نمی توانید این کمپین را به باقی مانده و یا منحصر به فرد تبدیل کنید، چون هر دو تاریخ پایان و هم از برداشت / کلیک / تبدیل حد تعیین می را تغییر دهید. <br> به منظور تغییر نوع، شما نیاز به تنظیم هیچ تاریخ انقضای یا حذف محدودیت دارید.";
$GLOBALS['strCannotSetBothDateAndLimit'] = "
شما نمی توانید هر دو تاریخ پایان و محدودیتی برای یک کمپین باقی مانده و یا منحصر به فرد تبدیل کنید تنظیم شده است. <br> اگر شما نیاز به تنظیم هر دو تاریخ پایان و محدود برداشت / کلیک / تبدیل لطفا با استفاده از یک کمپین قرارداد غیر انحصاری.";
$GLOBALS['strWhyDisabled'] = "
چرا  غیر فعال است؟";
$GLOBALS['strBackToCampaigns'] = "برگشت به کمپین";
$GLOBALS['strCampaignBanners'] = "آگهی ها کمپین";
$GLOBALS['strCookies'] = "کوکی ها";

// Tracker
$GLOBALS['strTracker'] = "ردیاب";
$GLOBALS['strTrackers'] = "ردیاب ها ";
$GLOBALS['strTrackerPreferences'] = "تنظیمات ردیاب";
$GLOBALS['strAddTracker'] = "اضافه کردن ردیاب جدید";
$GLOBALS['strTrackerForAdvertiser'] = "برای تبلیغ کنندگان";
$GLOBALS['strNoTrackers'] = "در حال حاضر هیچ ردیابی تعریف شده برای این تبلیغ کننده وجود دارد";
$GLOBALS['strConfirmDeleteTrackers'] = "
آیا شما واقعا می خواهید که ردیاب های انتخاب شده را حذف کنید؟";
$GLOBALS['strConfirmDeleteTracker'] = "آیا واقعا میخواهید این ردیاب را حذف کنید?";
$GLOBALS['strTrackerProperties'] = "
خواص ردیاب";
$GLOBALS['strDefaultStatus'] = "
پیش فرض وضعیت";
$GLOBALS['strStatus'] = "وضعیت";
$GLOBALS['strLinkedTrackers'] = "رد یاب های مرتبط";
$GLOBALS['strTrackerInformation'] = "اطلاعات ردیاب";
$GLOBALS['strConversionWindow'] = "
پنجره تبدیل";
$GLOBALS['strUniqueWindow'] = "
پنجره های منحصر به فرد";
$GLOBALS['strClick'] = "کلیک";
$GLOBALS['strView'] = "مشاهده";
$GLOBALS['strArrival'] = "ورود";
$GLOBALS['strManual'] = "
کتابچه راهنمای";
$GLOBALS['strImpression'] = "حساس";
$GLOBALS['strConversionType'] = "
تبدیل نوع";
$GLOBALS['strLinkCampaignsByDefault'] = "پیوند کمپین به تازگی ایجاد شده به طور پیش فرض";
$GLOBALS['strBackToTrackers'] = "
برگشت به ردیاب ها";
$GLOBALS['strIPAddress'] = "آدرس آی پی";

// Banners (General)
$GLOBALS['strBanner'] = "
تبلیغات";
$GLOBALS['strBanners'] = "تبلیغات";
$GLOBALS['strAddBanner'] = "اضافه کردن تبلیغات جدید";
$GLOBALS['strAddBanner_Key'] = "<u>جدید</u> اضافه کردن تبلیغات";
$GLOBALS['strBannerToCampaign'] = "به کمپین";
$GLOBALS['strShowBanner'] = "تبلیغ را نشان بده";
$GLOBALS['strBannerProperties'] = "خواص تبلیغات";
$GLOBALS['strBannerHistory'] = "آمار بنر";
$GLOBALS['strNoBanners'] = "
در حال حاضر هیچ تبلیغات تعریف شده برای این کمپین وجود ندارد.";
$GLOBALS['strNoBannersAddCampaign'] = "در حال حاضر هیچ تبلیغات تعریف شده است، زیرا هیچ کمپین وجود دارد. برای ایجاد یک بنر، <a href='campaign-edit.php?clientid=%s'>کمپینی را اضافه کنید</a> ابتدا";
$GLOBALS['strNoBannersAddAdvertiser'] = "در حال حاضر هیچ تبلیغات تعریف شده است، زیرا هیچ تبلیغ وجود دارد. برای ایجاد یک بنر، <a href='advertiser-edit.php'>تبلیغ کننده جدید اضافه کنید </a> ابتدا.";
$GLOBALS['strConfirmDeleteBanner'] = "حذف این بنر همچنین آمار خود را حذف می کند
آیا شما واقعا می خواهید این بنر را حذف کنید؟";
$GLOBALS['strConfirmDeleteBanners'] = "حذف این بنر باعث پاک شدن آمارش نیز می شود .
آیا شما واقعا می خواهید تبلیغات انتخاب شده را حذف کنید؟";
$GLOBALS['strShowParentCampaigns'] = "
کمپین نمایش منشأ";
$GLOBALS['strHideParentCampaigns'] = "مخفی کردن کمپین خانواده";
$GLOBALS['strHideInactiveBanners'] = "مخفی کردن تبلیغات غیر فعال";
$GLOBALS['strInactiveBannersHidden'] = "حذف بنر غیر فعال (ها)";
$GLOBALS['strWarningMissing'] = "اخطار، احتمالا از دست رفته ";
$GLOBALS['strWarningMissingClosing'] = " 
تگ پایانی'>'";
$GLOBALS['strWarningMissingOpening'] = " 
تگ آغاز کننده '<'";
$GLOBALS['strSubmitAnyway'] = "
ارسال به هرحال";
$GLOBALS['strBannersOfCampaign'] = "در"; //this is added between page name and campaign name eg. 'Banners in coca cola campaign'

// Banner Preferences
$GLOBALS['strBannerPreferences'] = "
تنظیمات تبلیغات";
$GLOBALS['strCampaignPreferences'] = "
تنظیمات کمپین";
$GLOBALS['strDefaultBanners'] = "
آگهی ها پیش فرض";
$GLOBALS['strDefaultBannerUrl'] = "پیش فرض URL تصویر";
$GLOBALS['strDefaultBannerDestination'] = "
پیش فرض URL مقصد";
$GLOBALS['strAllowedBannerTypes'] = "
انواع بنر مجاز";
$GLOBALS['strTypeSqlAllow'] = "اجازه به SQL تبلیغات محلی";
$GLOBALS['strTypeWebAllow'] = "اجازه به تبلیغات محلی وب سایت و سرور";
$GLOBALS['strTypeUrlAllow'] = "اجازه به تبلیغات خارجی";
$GLOBALS['strTypeHtmlAllow'] = "اجازه به آگهی HTML";
$GLOBALS['strTypeTxtAllow'] = "اجازه تبلیغات متنی";

// Banner (Properties)
$GLOBALS['strChooseBanner'] = "لطفا نوع این بنر را انتخاب کنید";
$GLOBALS['strMySQLBanner'] = "
آپلود بنر محلی برای پایگاه داده";
$GLOBALS['strWebBanner'] = "آپلود بنر محلی به وب سرور";
$GLOBALS['strURLBanner'] = "پیوند یک بنر خارجی";
$GLOBALS['strHTMLBanner'] = "ایجاد یک بنر HTML";
$GLOBALS['strTextBanner'] = "ایجاد یک بنر متن";
$GLOBALS['strAlterHTML'] = "HTML را تغییر دهید تا کلیک ردیابی را فعال کنید . ";
$GLOBALS['strIframeFriendly'] = "
این بنر را می توان با خیال راحت در داخل یک iframe نمایش داد(e.g. قابل ارتقا نیست)";
$GLOBALS['strUploadOrKeep'] = "آیا مایلید که  <br />که تصویر موجود را نگهداری کنید؟ , یا آیا شما <br />می خواهید عکس دیگری را بارگذاری کنید؟";
$GLOBALS['strNewBannerFile'] = "تصویری که می خواهید انتخاب کنید <br />
برای استفاده برای این بنر<br /><br />";
$GLOBALS['strNewBannerFileAlt'] = "یک تصویری به عنوان نسخه ی پشتیبانی انتخاب کنید <br /> که می خواهید به استفاده در مرورگرهای مورد <br /> در رسانه های غنی <br /> <br /> او را پشتیبانی نمی کند";
$GLOBALS['strNewBannerURL'] = "تصویر URL (incl. http://)";
$GLOBALS['strURL'] = "مقصد URL (incl. http://)";
$GLOBALS['strKeyword'] = "کلمات کلیدی";
$GLOBALS['strTextBelow'] = "متن زیر تصویر";
$GLOBALS['strWeight'] = "وزن";
$GLOBALS['strAlt'] = "متن ALT";
$GLOBALS['strStatusText'] = "متن وضعیت";
$GLOBALS['strBannerWeight'] = "وزن تبلیغات";
$GLOBALS['strAdserverTypeGeneric'] = "بنر عمومی Html";
$GLOBALS['strDoNotAlterHtml'] = "HTML را تغییر ندهید";
$GLOBALS['strGenericOutputAdServer'] = "عمومی سازی";
$GLOBALS['strBackToBanners'] = "بازگشت به تبلیغات";

// Banner (advanced)
$GLOBALS['strBannerPrependHTML'] = "همیشه کدHTML زیر به این بنر prepend کنید";
$GLOBALS['strBannerAppendHTML'] = "
همیشه کدHTML زیر را به این بنر اضافه کنید";

// Display Delviery Rules
$GLOBALS['strModifyBannerAcl'] = "گزینه های تحویل";
$GLOBALS['strACL'] = "گزینه های تحویل";
$GLOBALS['strAllBannersInCampaign'] = "همه تبلیغات در این کمپین";
$GLOBALS['strEqualTo'] = "برابر است با";
$GLOBALS['strDifferentFrom'] = "متفاوت است";
$GLOBALS['strLaterThan'] = "است بعد از";
$GLOBALS['strLaterThanOrEqual'] = "است بعد از یا برابر با";
$GLOBALS['strEarlierThan'] = "زودتر از است";
$GLOBALS['strEarlierThanOrEqual'] = "زودتر از یا مساوی";
$GLOBALS['strContains'] = "شامل";
$GLOBALS['strNotContains'] = "را شامل نمی شود";
$GLOBALS['strGreaterThan'] = "
بزرگتر است از";
$GLOBALS['strLessThan'] = "کمتر است از";
$GLOBALS['strGreaterOrEqualTo'] = "بزرگتر یا مساوی";
$GLOBALS['strLessOrEqualTo'] = "کمتر یا مساوی";
$GLOBALS['strAND'] = "و";                          // logical operator
$GLOBALS['strOR'] = "یا";                         // logical operator
$GLOBALS['strOnlyDisplayWhen'] = "زمانی این بنر را نشان بده که :";
$GLOBALS['strWeekDays'] = "روزهای هفته";
$GLOBALS['strTime'] = "زمان";
$GLOBALS['strDomain'] = "دامنه";
$GLOBALS['strSource'] = "منبع";
$GLOBALS['strBrowser'] = "مرورگر";
$GLOBALS['strOS'] = "سیستم عامل";

$GLOBALS['strDeliveryCappingReset'] = "تنظیم مجدد نمایش شمارنده پس از:";
$GLOBALS['strDeliveryCappingTotal'] = "در مجموع";
$GLOBALS['strDeliveryCappingSession'] = "در هر جلسه";

if (!isset($GLOBALS['strCappingBanner'])) {
    $GLOBALS['strCappingBanner'] = [];
}
$GLOBALS['strCappingBanner']['title'] = "تحویل سر پوش هر بازدید کننده";
$GLOBALS['strCappingBanner']['limit'] = "تحویل سر پوش در هر بار نمایش بنر بازدید کننده محدود به:";

if (!isset($GLOBALS['strCappingCampaign'])) {
    $GLOBALS['strCappingCampaign'] = [];
}
$GLOBALS['strCappingCampaign']['title'] = "تحویل سر پوش هر بازدید کننده";
$GLOBALS['strCappingCampaign']['limit'] = "نمایش کمپین را محدود کن به :";

if (!isset($GLOBALS['strCappingZone'])) {
    $GLOBALS['strCappingZone'] = [];
}
$GLOBALS['strCappingZone']['title'] = "تحویل سر پوش هر بازدید کننده";
$GLOBALS['strCappingZone']['limit'] = "نمایش منطقه را محدود کن به :";

// Website
$GLOBALS['strAffiliate'] = "وب سایت";
$GLOBALS['strAffiliates'] = "وب سایت ها";
$GLOBALS['strAffiliatesAndZones'] = "وب سایت ها و مناطق";
$GLOBALS['strAddNewAffiliate'] = "اضافه کردن وب سایت جدید";
$GLOBALS['strAffiliateProperties'] = "خواص وب سایت";
$GLOBALS['strAffiliateHistory'] = "آمار وب سایت";
$GLOBALS['strNoAffiliates'] = "در حال حاضر هیچ وب سایت های تعریف شده وجود دارد. برای ایجاد یک منطقه, <a href='affiliate-edit.php'>یک وب سایت جدید ایجاد کنید</a> در ابتدا.";
$GLOBALS['strConfirmDeleteAffiliate'] = "آیا واقعا میخواهید این وب سایت را حذف کنید؟";
$GLOBALS['strConfirmDeleteAffiliates'] = "آیا شما واقعا می خواهید وب سایت های انتخاب شده را حذف کنید؟";
$GLOBALS['strInactiveAffiliatesHidden'] = "وب سایت های غیر فعال) پنهان شوند";
$GLOBALS['strShowParentAffiliates'] = "نمایش وب سایت های خانواده";
$GLOBALS['strHideParentAffiliates'] = "پنهان کردن وب سایت خانواده";

// Website (properties)
$GLOBALS['strWebsite'] = "وب سایت";
$GLOBALS['strWebsiteURL'] = "سایت اینترنتی URL";
$GLOBALS['strAllowAffiliateModifyZones'] = "به این کاربر اجازه تغییر مناطق خود را دهید";
$GLOBALS['strAllowAffiliateLinkBanners'] = "به این کاربر اجازه پیوند تبلیغات به مناطق خود را دعید";
$GLOBALS['strAllowAffiliateAddZone'] = "به این کاربر اجازه تعریف مناطق جدید بدهبد";
$GLOBALS['strAllowAffiliateDeleteZone'] = "به کاربر اجازه حذف منطقه بده ";
$GLOBALS['strAllowAffiliateGenerateCode'] = "به این کاربر اجازه برای تولید کد نیایش داده شود ";

// Website (properties - payment information)
$GLOBALS['strPostcode'] = "کد پستی";
$GLOBALS['strCountry'] = "کشور";

// Website (properties - other information)
$GLOBALS['strWebsiteZones'] = "مناطق وب سایت";

// Zone
$GLOBALS['strZone'] = "منطقه";
$GLOBALS['strZones'] = "مناطق";
$GLOBALS['strAddNewZone'] = "اضافه کردن منطقه جدید";
$GLOBALS['strAddNewZone_Key'] = " <u>اضافه کردن منطقه جدید</u>";
$GLOBALS['strZoneToWebsite'] = "به وب سایت";
$GLOBALS['strLinkedZones'] = "مناطق مرتبط";
$GLOBALS['strAvailableZones'] = "مناطق در دسترس";
$GLOBALS['strLinkingNotSuccess'] = "لینک کردن موفق نیست، لطفا دوباره امتحان کنید";
$GLOBALS['strZoneProperties'] = "خواص منطقه";
$GLOBALS['strZoneHistory'] = "تاریخچه منطقه";
$GLOBALS['strNoZones'] = "در حال حاضر هیچ مناطق تعریف شده برای این وب سایت وجود دارد.";
$GLOBALS['strNoZonesAddWebsite'] = "در حال حاضر هیچ مناطق تعریف شده است، زیرا هیچ وب سایت وجود دارد. برای ایجاد یک منطقه، <a href='affiliate-edit.php'>اضافه کردن وب سایت جدید</a> ابتدا.";
$GLOBALS['strConfirmDeleteZone'] = "آیا شما واقعا می خواهید که حذف این منطقه?";
$GLOBALS['strConfirmDeleteZones'] = "آیا شما واقعا می خواهید مناطق انتخاب شده را حذف کنید?";
$GLOBALS['strConfirmDeleteZoneLinkActive'] = " کمپین هنوز به این منطقه مرتبط است، اگر شما آن را حذف کنید این خواهد بود قادر به اجرا وجود دارد و شما خواهد شد برای آنها پرداخت نشده است.";
$GLOBALS['strZoneType'] = "نوع منطقه";
$GLOBALS['strBannerButtonRectangle'] = "بنر، دکمه و یا مستطیل";
$GLOBALS['strInterstitial'] = "DHTML بینابینی یا شناور";
$GLOBALS['strPopup'] = "پنجره";
$GLOBALS['strTextAdZone'] = "تبلیغ متنی";
$GLOBALS['strEmailAdZone'] = "ایمیل / منطقه خبرنامه";
$GLOBALS['strZoneVideoInstream'] = "آگهی های درون خطی های ویدیوئی";
$GLOBALS['strZoneVideoOverlay'] = "آگهی پوشش های ویدئویی";
$GLOBALS['strShowMatchingBanners'] = "آگهی ها نشان تطبیق";
$GLOBALS['strHideMatchingBanners'] = "مخفی کردن تبلیغات یکسان";
$GLOBALS['strBannerLinkedAds'] = "تبلیغات مربوط به منطقه";
$GLOBALS['strCampaignLinkedAds'] = "
کمپین مربوط به منطقه";
$GLOBALS['strInactiveZonesHidden'] = "مناطق (ها)ی غیر فعال پنهان وند ";
$GLOBALS['strWarnChangeZoneType'] = "پنهان تغییر نوع منطقه به متن و یا ایمیل را به همه تبلیغات / کمپین توجه به محدودیت های این نوع منطقه قطع ارتباط
                                                <ul>
                                                    <li>مناطق متن تنها می تواند مربوط به متن آگهی</li>
                                                    <li>کمپین منطقه ایمیل تنها می توانید یک بنر فعال در یک زمان</li>
                                                </ul>";
$GLOBALS['strWarnChangeZoneSize'] = 'تغییر اندازه منطقه خواهد بر خلاف هر گونه تبلیغات که به اندازه جدید نیست، و هر گونه آگهی ها از کمپین مرتبط که به اندازه جدید اضافه کنید';
$GLOBALS['strZonesOfWebsite'] = 'در'; //this is added between page name and website name eg. 'Zones in www.example.com'
$GLOBALS['strBackToZones'] = "برگشتن به ناحیه ها";

$GLOBALS['strIab']['IAB_FullBanner(468x60)'] = "IAB فول بنر (468 x 60)";
$GLOBALS['strIab']['IAB_Button1(120x90)'] = "IAB دکمه 1 (120 x 90)";
$GLOBALS['strIab']['IAB_Button2(120x60)'] = "IAB دکمه 2 (120 x 60)";
$GLOBALS['strIab']['IAB_HalfBanner(234x60)'] = "IAB نیم بنر (234 x 60)";
$GLOBALS['strIab']['IAB_MicroBar(88x31)'] = "IAB میکرو بار (88 x 31)";
$GLOBALS['strIab']['IAB_SquareButton(125x125)'] = "IAB دکمه مربعی (125 x 125)";
$GLOBALS['strIab']['IAB_Rectangle(180x150)*'] = "IAB مثلثی (180 x 150)";
$GLOBALS['strIab']['IAB_SquarePop-up(250x250)'] = "IAB مثلثی پاپ آپ (250 x 250)";
$GLOBALS['strIab']['IAB_VerticalBanner(120x240)'] = "IAB عمودی Banner (120 x 240)";
$GLOBALS['strIab']['IAB_MediumRectangle(300x250)*'] = "IAB مثلثی متوسط (300 x 250)";
$GLOBALS['strIab']['IAB_LargeRectangle(336x280)'] = "IAB مثلثی بزرگ (336 x 280)";
$GLOBALS['strIab']['IAB_VerticalRectangle(240x400)'] = "IAB مثلثی عمودی (240 x 400)";
$GLOBALS['strIab']['IAB_WideSkyscraper(160x600)*'] = "IAB پهن Skyscraper (160 x 600)";
$GLOBALS['strIab']['IAB_3:1Rectangle(300x100)'] = "IAB 3:1 مثلثی (300 x 100)";

// Advanced zone settings
$GLOBALS['strAdvanced'] = "پیشرفته ";
$GLOBALS['strChainSettings'] = "رشته تنظیمات";
$GLOBALS['strZoneNoDelivery'] = "اگر هیچ بنری از این منطقه دلیور نمیشه ، امتحان کنید....";
$GLOBALS['strZoneStopDelivery'] = "تحویل را متوقف کن و بنر را نمایش نده";
$GLOBALS['strZoneOtherZone'] = "ناحیه انتخاب شده را در عوض نشان بده";
$GLOBALS['strZoneAppend'] = "همیشه این کد HTML را در بنرهای این منطقه نشان بده";
$GLOBALS['strAppendSettings'] = "الحاق و prepend تنظیمات";
$GLOBALS['strZonePrependHTML'] = "همیشه این کد HTML را به بنرهای این منطقه prepend کن .";
$GLOBALS['strZoneAppendNoBanner'] = "Prepend/Append حتی اگر هیچ بنری تحویل داده نشده";
$GLOBALS['strZoneAppendHTMLCode'] = "HTML کد";
$GLOBALS['strZoneAppendZoneSelection'] = "پنجره و یا بینابینی";

// Zone probability
$GLOBALS['strZoneProbListChain'] = "کلیه بنرهایی که به این منطقه انتخاب شده لینک شده اند ، فعال نیستند. <br />این رشته منطقه است که فالو میشود::";
$GLOBALS['strZoneProbNullPri'] = "هیچ بنر فعالی لینک شده ای به این منطقه نیست.";
$GLOBALS['strZoneProbListChainLoop'] = "تحویل متوقف شده است چون در حلقه دایره ای افتاده است.";

// Linked banners/campaigns/trackers
$GLOBALS['strSelectZoneType'] = "لطفا انتخاب کنید چه چیزی به این منطقه لینک شود";
$GLOBALS['strLinkedBanners'] = "لینک کردن بنرهای تکی";
$GLOBALS['strCampaignDefaults'] = "لینک کردن به وسیله کمپین والد";
$GLOBALS['strLinkedCategories'] = "لینک کردن توسط دسته بندی";
$GLOBALS['strWithXBanners'] = "%d بنر(s)";
$GLOBALS['strRawQueryString'] = "کلید واژه";
$GLOBALS['strIncludedBanners'] = "بنرهای لینک شده";
$GLOBALS['strMatchingBanners'] = "{count} بنرهای برابر";
$GLOBALS['strNoCampaignsToLink'] = "هیچ کمپینی که بشه به این منطقه لینک کرد ، وجود ندارد";
$GLOBALS['strNoTrackersToLink'] = "هیچ پخش کننده ای وجود ندارد که به این منطقه لینک شود.";
$GLOBALS['strNoZonesToLinkToCampaign'] = "هیچ منطقه ای وجود ندارد که این کمپین به آن لینک شود";
$GLOBALS['strSelectBannerToLink'] = "بنری که میخواهید به این منطقه لینک شود را انتخاب کنید:";
$GLOBALS['strSelectCampaignToLink'] = "کمپینی که میخواهید به این منطقه لینک شود را انتخاب کنید:";
$GLOBALS['strSelectAdvertiser'] = "انتخاب مبلغ";
$GLOBALS['strSelectPlacement'] = "انتخاب کمپین";
$GLOBALS['strSelectAd'] = "انتخاب بنر";
$GLOBALS['strSelectPublisher'] = "انتخاب سایت";
$GLOBALS['strSelectZone'] = "انتخاب منطقه";
$GLOBALS['strStatusPending'] = "
در انتظار";
$GLOBALS['strStatusApproved'] = "تایید شده";
$GLOBALS['strStatusDisapproved'] = "تایید نشده";
$GLOBALS['strStatusDuplicate'] = "
تکراری";
$GLOBALS['strStatusOnHold'] = "در انتظار";
$GLOBALS['strStatusIgnore'] = "نادیده گرفتن";
$GLOBALS['strConnectionType'] = "نوع";
$GLOBALS['strConnTypeSale'] = "فروش";
$GLOBALS['strConnTypeLead'] = "هدایت";
$GLOBALS['strConnTypeSignUp'] = "ثبت نام";
$GLOBALS['strShortcutEditStatuses'] = "ویرایش وضعیت ها";
$GLOBALS['strShortcutShowStatuses'] = "نمایش وضعیت ها";

// Statistics
$GLOBALS['strStats'] = "آمار";
$GLOBALS['strNoStats'] = "در حال حاضر هیچ آماری وحود ندارد";
$GLOBALS['strNoStatsForPeriod'] = "هیچ آماری برای دوره ی  %s تا %s وجود ندارد";
$GLOBALS['strGlobalHistory'] = "آمار کلی";
$GLOBALS['strDailyHistory'] = "آمار روزانه";
$GLOBALS['strDailyStats'] = "آمار روزانه";
$GLOBALS['strWeeklyHistory'] = "آمار هفتگی";
$GLOBALS['strMonthlyHistory'] = "آمار ماهانه";
$GLOBALS['strTotalThisPeriod'] = "کل این دوره";
$GLOBALS['strPublisherDistribution'] = "توزیع وب سایت";
$GLOBALS['strCampaignDistribution'] = "توضیع کمپین";
$GLOBALS['strViewBreakdown'] = "مشاهده توسط";
$GLOBALS['strBreakdownByDay'] = "روز";
$GLOBALS['strBreakdownByWeek'] = "هفته";
$GLOBALS['strBreakdownByMonth'] = "ماه";
$GLOBALS['strBreakdownByDow'] = "روز هفته";
$GLOBALS['strBreakdownByHour'] = "ساعت";
$GLOBALS['strItemsPerPage'] = "آیتم ها در هر صفحه";
$GLOBALS['strShowGraphOfStatistics'] = "نمایش گراف آمار";
$GLOBALS['strExportStatisticsToExcel'] = "خروجی آمار به صورت اکسل";
$GLOBALS['strStatsArea'] = "ناحیه";

// Expiration
$GLOBALS['strNoExpiration'] = "هیچ تاریخ انقضایی ست نشده";
$GLOBALS['strEstimated'] = "تاریخ تخمینی انقضا";
$GLOBALS['strDaysAgo'] = "روز پیش";
$GLOBALS['strCampaignStop'] = "توقف کمپین";

// Reports
$GLOBALS['strAdvancedReports'] = "گزارش های پیشرفته";
$GLOBALS['strStartDate'] = "آغاز تاریخ";
$GLOBALS['strEndDate'] = "پایان تاریخ";
$GLOBALS['strPeriod'] = "دوره";
$GLOBALS['strWorksheets'] = "آموزشی";

// Admin_UI_Fields
$GLOBALS['strAllAdvertisers'] = "همه ی مبلغ ها";
$GLOBALS['strAnonAdvertisers'] = "مبلغ های ناشناس";
$GLOBALS['strAllPublishers'] = "همه ی سایت ها";
$GLOBALS['strAnonPublishers'] = "سایت های ناشناس";
$GLOBALS['strAllAvailZones'] = "همه ی منطقه های موجود";

// Userlog
$GLOBALS['strUserLog'] = "لاگ کاربر";
$GLOBALS['strUserLogDetails'] = "جزئیات لاگ کاربر";
$GLOBALS['strDeleteLog'] = "حذف لاگ";
$GLOBALS['strAction'] = "اقدامات";
$GLOBALS['strNoActionsLogged'] = "هیچ عملیاتی ثبت نشده است";

// Code generation
$GLOBALS['strGenerateBannercode'] = "انتخاب مستقیم";
$GLOBALS['strChooseInvocationType'] = "لطفا نوع بنر را انتخاب کنید invocation";
$GLOBALS['strGenerate'] = "تولید";
$GLOBALS['strParameters'] = "تنظیمات برچسب";
$GLOBALS['strFrameSize'] = "سایز فریم";
$GLOBALS['strBannercode'] = "کدبنر";
$GLOBALS['strTrackercode'] = "کدپخش کننده";
$GLOBALS['strBackToTheList'] = "برگرد به لیست گزارشات";
$GLOBALS['strCharset'] = "ست کارکتر";
$GLOBALS['strAutoDetect'] = "تشخیص خودکار";

// Errors
$GLOBALS['strErrorDatabaseConnection'] = "خطای اتصال پایگاه داده.";
$GLOBALS['strNoMatchesFound'] = "هیچ چیز مطابی پیدا نشد";
$GLOBALS['strErrorOccurred'] = "یخ خطا اتفاق افتاد";
$GLOBALS['strErrorDBPlain'] = "یک خطا هنگام اتصال به دیتابیس اتفاق افتاد";
$GLOBALS['strErrorDBSerious'] = "یک مشکل جدی با دیتابیس تشخیص داده شد";
$GLOBALS['strErrorDBNoDataPlain'] = "با توجه به مشکل با دیتابیس {$PRODUCT_NAME} نیمتوان دیتا را ذخیره یا فراخوانی کرد. ";
$GLOBALS['strErrorDBNoDataSerious'] = "با توجه به مشکل جدی با دیتابیس, {$PRODUCT_NAME} نمیتوان دیتا را بازخوانی کرد";
$GLOBALS['strErrorDBCorrupt'] = "جدول دیتبایس خراب است و نیاز به تعمیر دارد .";
$GLOBALS['strErrorDBContact'] = "لطقا با مدیر سورور ارتباط برقرار کنید و مشکل را با او در میان بگذارید";
$GLOBALS['strErrorDBSubmitBug'] = "اگر این مشکل قابل پردازش مجدد باشد باعث ایجاد یک خطا در.می شود. لط�?ا اطلاعات زیر را به نویسنده برنامه گزارش دهید. همچنین سعی کنید که اعمالی را که باعث ایجاد این خطا شده اند برای نوسنده برنامه تشریح نمایید.";
$GLOBALS['strMaintenanceNotActive'] = "این برنامه هر 24 ساعت برای تگهداری قابل اجرا نمی باشد.
برای اطلاعات بیشتر
 برای پیکربندی نگهداری اسکریپت.";
$GLOBALS['strErrorLinkingBanner'] = "امکان لینک شدن این به بنر به ناحیه میسر نبود زیرا ::";
$GLOBALS['strUnableToLinkBanner'] = "نمیتوان این بنر را لینک کرد: ";
$GLOBALS['strErrorEditingCampaignRevenue'] = "فرمت اشتباه شماره";
$GLOBALS['strErrorEditingCampaignECPM'] = "فرمت اشتباه شمار در in ECPM Information فیلد";
$GLOBALS['strErrorEditingZone'] = "ارور بروزراسننی منطقه:";
$GLOBALS['strUnableToChangeZone'] = "نمیتوان این تغییرات را اعمال کرد زیرا :";
$GLOBALS['strDatesConflict'] = "dates conflict with:";
$GLOBALS['strEmailNoDates'] = "Email zone campaigns must have a start and end date";
$GLOBALS['strWarningInaccurateReadMore'] = "دربارهی ی این بیشتر بخوانید";

//Validation
$GLOBALS['strFormContainsErrors'] = "فرم شامل ارور است ، لطفا فیلدهای مشخص شده را تصحیح کنید ";
$GLOBALS['strXRequiredField'] = "%s نیاز است";
$GLOBALS['strEmailField'] = "لطفا یک ایمیل معتبر وارد کنید";
$GLOBALS['strNumericField'] = "لطفا یک شماره وارد کنید";
$GLOBALS['strGreaterThanZeroField'] = "باید بزرگتر از صفر باشد";
$GLOBALS['strXGreaterThanZeroField'] = "%s باید بزرگتر از صفر باشد";
$GLOBALS['strXPositiveWholeNumberField'] = "%s کل شماره باید مثبت باشد";
$GLOBALS['strInvalidWebsiteURL'] = "آدرس وبسایت نامعتبر";

// Email
$GLOBALS['strSirMadam'] = "خانم/آقا";
$GLOBALS['strMailSubject'] = "گزارش تبلیغ دهنده";
$GLOBALS['strMailHeader'] = "عزیز {contact},";
$GLOBALS['strMailBannerStats'] = "در زیر آمار را برای بنر پیدا میکنید {clientname}:";
$GLOBALS['strMailBannerActivatedSubject'] = "کمپین فعال شد";
$GLOBALS['strMailBannerDeactivatedSubject'] = "کمپین غیر فعال شد";
$GLOBALS['strMailBannerActivated'] = "کمپینی که در زیر مشاهده میکند فعال شد ، چون موعد فعال شدن آن رسیده بود ";
$GLOBALS['strMailBannerDeactivated'] = "کمپین که در زیر نشان داده شده غیر فعال شد جون";
$GLOBALS['strMailFooter'] = "درود,
   {adminfullname}";
$GLOBALS['strClientDeactivated'] = "این کمپین در حال حاضر فعال نیست زیرا";
$GLOBALS['strBeforeActivate'] = "هنوز موعد فعال شدن فرا نرسیده است";
$GLOBALS['strAfterExpire'] = "تاریخ انقضا فرا رسیده است";
$GLOBALS['strNoMoreClicks'] = "هیچ کلیکی باقی نمانده است";
$GLOBALS['strNoMoreConversions'] = "هیچ فروشی باقی نمانده است";
$GLOBALS['strWeightIsNull'] = "وزن آن صفر تنظیم شده است";
$GLOBALS['strRevenueIsNull'] = "در آمد آن به صفر تنظیم شده است";
$GLOBALS['strTargetIsNull'] = "its target is set to zero";
$GLOBALS['strNoViewLoggedInInterval'] = "هیچ مشاهده تبلیغاتی در طول این گزارش ثبت نشده است";
$GLOBALS['strNoClickLoggedInInterval'] = "هیچ کلیک تبلیغاتی در طول این گزارش ثبت نشده است";
$GLOBALS['strNoConversionLoggedInInterval'] = "هیچ مشاهده تبلیغاتی در طول این گزارش ثبت نشده است";
$GLOBALS['strMailReportPeriod'] = "این گزارش شامل آماری از {startdate} تا {enddate}می باشد.";
$GLOBALS['strMailReportPeriodAll'] = "این گزارش شامل�? همه آمار تا {enddate} می باشد.";
$GLOBALS['strNoStatsForCampaign'] = "هیچ آماری برای این  موجود نمی باشد";
$GLOBALS['strYourCampaign'] = "کمپین شما";
$GLOBALS['strTheCampiaignBelongingTo'] = "کمپین متعلق به";

// Priority
$GLOBALS['strPriority'] = "
اولویت";
$GLOBALS['strSourceEdit'] = "ویرایش منشا";

// Preferences
$GLOBALS['strPreferences'] = "تنظیمات";
$GLOBALS['strUserPreferences'] = "تنظیمات کاربر";
$GLOBALS['strChangePassword'] = "تغییر پسورد";
$GLOBALS['strChangeEmail'] = "تغییر ایمیل";
$GLOBALS['strCurrentPassword'] = "پسورد حال حاضر";
$GLOBALS['strChooseNewPassword'] = "انتخاب یه پسورد جدید";
$GLOBALS['strReenterNewPassword'] = "دوباره وارد کردن رمز جدید";
$GLOBALS['strNameLanguage'] = "نام و زبان";
$GLOBALS['strAccountPreferences'] = "تنظیمات حساب کاربری";
$GLOBALS['strCampaignEmailReportsPreferences'] = "تنظیمات گزارش ایمیل کمپین";
$GLOBALS['strTimezonePreferences'] = "Timezone تنظیمات";
$GLOBALS['strAdminEmailWarnings'] = "سیستم اخطار از طریق ایمیل ادمین";
$GLOBALS['strAgencyEmailWarnings'] = "ایمیل اخطار حساب کاربری";
$GLOBALS['strAdveEmailWarnings'] = "ایمیل اخطار ادمین";
$GLOBALS['strFullName'] = "نام کامل";
$GLOBALS['strEmailAddress'] = "آدرس ایمیل";
$GLOBALS['strUserDetails'] = "جزئیات کاربر";
$GLOBALS['strPluginPreferences'] = "تنظیمات افزونه";
$GLOBALS['strColumnName'] = "نام ردیف";
$GLOBALS['strShowColumn'] = "نمایش ردیف";
$GLOBALS['strCustomColumnName'] = "نام ردیف دلخواه";
$GLOBALS['strColumnRank'] = "رتبه ردیف";

// Long names
$GLOBALS['strRevenue'] = "درآمد";
$GLOBALS['strNumberOfItems'] = "تعداد آیتم ها";
$GLOBALS['strPendingConversions'] = "مکالمات در حال پردازش";
$GLOBALS['strImpressionSR'] = "آثار";
$GLOBALS['strClickSR'] = "کلیک SR";

// Short names
$GLOBALS['strID_short'] = "شناسه";
$GLOBALS['strClicks_short'] = "کلیک";
$GLOBALS['strCTR_short'] = "نرخ کلیک";
$GLOBALS['strClickSR_short'] = "کلیک SR";

// Global Settings
$GLOBALS['strConfiguration'] = "پیکربندی";
$GLOBALS['strGlobalSettings'] = "تنظیمات سراسری";
$GLOBALS['strGeneralSettings'] = "تنظیمات عمومی";
$GLOBALS['strMainSettings'] = "تنظیمات اصلی";
$GLOBALS['strPlugins'] = "افزونه ها";
$GLOBALS['strChooseSection'] = 'انتخاب بخش';

// Product Updates
$GLOBALS['strProductUpdates'] = "بروزرسانی های محصول";
$GLOBALS['strViewPastUpdates'] = "مدیریت آپدیت ها و افزونه های قبلی";
$GLOBALS['strFromVersion'] = "از نسخه";
$GLOBALS['strToVersion'] = "به نسخه";
$GLOBALS['strClickViewBackupDetails'] = "برای مشاهده جزئیات پشتیبان گیری کلیک کنید.";
$GLOBALS['strClickHideBackupDetails'] = "برای مخفی شدن جزئیات پتیبان گیری کلیک کنید";
$GLOBALS['strShowBackupDetails'] = "جزئیات دیتا پشتیبان گیری را نمایش بده";
$GLOBALS['strHideBackupDetails'] = "جزئیات دیتا پشتیبان گیری را مخفی کن";
$GLOBALS['strBackupDeleteConfirm'] = "واقعا میخواهید همه پشتیبان گیری های که توسط این ارتقا ساخته شده اند را پاک کنید؟";
$GLOBALS['strDeleteArtifacts'] = "حذف آثار";
$GLOBALS['strArtifacts'] = "آثار";
$GLOBALS['strBackupDbTables'] = "پشتیبان گیری از جدول های دیتابیس";
$GLOBALS['strLogFiles'] = "فایل های لاگ";
$GLOBALS['strUpdatedDbVersionStamp'] = "استم بروزرسانی شده دیتابیس";
$GLOBALS['aProductStatus']['UPGRADE_COMPLETE'] = "ارتقا رسانی کامل شد";
$GLOBALS['aProductStatus']['UPGRADE_FAILED'] = "ارتقا رسانی شکست خورد";

// Agency
$GLOBALS['strAgencyManagement'] = "مدیریت حساب کاربری";
$GLOBALS['strAgency'] = "حساب کاربری";
$GLOBALS['strAddAgency'] = "اضافه کردن حساب کاربری جدید";
$GLOBALS['strAddAgency_Key'] = "اضافه کردن حساب کاربری جدید";
$GLOBALS['strTotalAgencies'] = "همه ی حساب های کاربری";
$GLOBALS['strAgencyProperties'] = "اطلاعات حساب کاربری";
$GLOBALS['strNoAgencies'] = "در حال حاضر هیچ حساب کاربری تعریف نشده است";
$GLOBALS['strConfirmDeleteAgency'] = "آیا واقعا میخواهید این حساب کاربری را پاک کنید؟";
$GLOBALS['strHideInactiveAgencies'] = "مخفی کردن حساب های کاربری غیر فعال";
$GLOBALS['strInactiveAgenciesHidden'] = "اکانت های غیر فعال مخفی شدند.";
$GLOBALS['strSwitchAccount'] = "انتقال به این حساب کاربری";
$GLOBALS['strAgencyStatusInactive'] = "
غیر فعال";

// Channels
$GLOBALS['strChannelToWebsite'] = "به وب سایت";
$GLOBALS['strChannelLimitations'] = "گزینه های تحویل";
$GLOBALS['strChannelsOfWebsite'] = 'در'; //this is added between page name and website name eg. 'delivery rule sets in www.example.com'

// Tracker Variables
$GLOBALS['strVariableName'] = "نام متغیر";
$GLOBALS['strVariableDescription'] = "توضیحات";
$GLOBALS['strVariableDataType'] = "نوع دیتا";
$GLOBALS['strVariablePurpose'] = "هدف";
$GLOBALS['strGeneric'] = "عمومی سازی";
$GLOBALS['strBasketValue'] = "ارزش سبد";
$GLOBALS['strNumItems'] = "تعداد آیتم ها";
$GLOBALS['strNumber'] = "عدد";
$GLOBALS['strString'] = "رشته";
$GLOBALS['strAddVariable'] = "اضافه کردن متغیر";
$GLOBALS['strVariableRejectEmpty'] = "پس زدن در صورت خالی بودن ؟";
$GLOBALS['strTrackerType'] = "نام تراکر";
$GLOBALS['strTrackerTypeCustom'] = "کد سفارشی جاوا اسکریپت";

// Password recovery
$GLOBALS['strForgotPassword'] = "رمز خود را فراموش کردید؟";
$GLOBALS['strEmailRequired'] = "ایمیل یک فیلد ضروری است";
$GLOBALS['strPwdRecEnterEmail'] = "در زیر ایمیل خود را وارد کنید";
$GLOBALS['strPwdRecEnterPassword'] = "در زیر پسورد جدید خود را وارد کنید";
$GLOBALS['strProceed'] = "ادامه >";

// Password recovery - Default


// Password recovery - Welcome email

// Password recovery - Hash update

// Password reset warning

// Audit
$GLOBALS['strAdditionalItems'] = "وآیتم های اضافه";
$GLOBALS['strFor'] = "برای";
$GLOBALS['strHas'] = "دارد";
$GLOBALS['strBinaryData'] = "دیتا باینری";

// Widget - Audit
$GLOBALS['strAuditNoData'] = "هیچ فعالیت کاربری در دوره ای که انتخاب کردید ، ثبت نشده است";
$GLOBALS['strAuditTrail'] = "حسابرسی نویسن";
$GLOBALS['strAuditTrailSetup'] = "امروز حسابرسی نویسن را راهن اندازی کنید";
$GLOBALS['strAuditTrailGoTo'] = "برو به صفحه ی حسابرسی نوین";
$GLOBALS['strAuditTrailNotEnabled'] = "<li>حسابرسی نوین به شما کمک میکند تا بفهمید چه شخصی در چه زمانی چه کاری انجام داده است {$PRODUCT_NAME}</li>
        <li>این پیام را به این دلیل میبینید چون هنوز حسابرسی نویسن را فعال نکرده اید.</li>
        <li>علاقه دارید بیشتر بدانید؟ <a href='{$PRODUCT_DOCSURL}/admin/settings/auditTrail' class='site-link' target='help' >راهنما حسابرسی نوین</a></li>";

// Widget - Campaign
$GLOBALS['strCampaignGoTo'] = "رفتن به صفحه ی کمپین ها";
$GLOBALS['strCampaignSetUp'] = "تنظیم یک کمپین امروز";
$GLOBALS['strCampaignNoRecords'] = "<li>کمپین ها به شما کمک میکنند تا بنرها و تبلیغ و .. را که یک هدف تبلیغاتی را دنال میکنند ، هماهنگ کنید.</li>
        <li>با همگروه کردن بنرها با هم در زمان صرفه جویی کنید و برای هر کدام جداگانه تنظیمات تحویل را انجام ندهید.</li>
        <li>پک کنید <a class='site-link' target='help' href='{$PRODUCT_DOCSURL}/user/inventory/advertisersAndCampaigns/campaigns'>Campaign documentation</a>!</li>";
$GLOBALS['strCampaignNoRecordsAdmin'] = "<li>هیچ فعالیت کمپینی برای نمایش وجود ندارد.</li>";

$GLOBALS['strCampaignNoDataTimeSpan'] = "هیچ کمپینی در دوره ای که انتخاب کرده اید ، نه شروع شده و نه پایان یافته است.";
$GLOBALS['strCampaignAuditNotActivated'] = "<li>برای دیدن کمپین هایی که در دوره ای که انتخاب کردید شروع یا تمام شده اند ، نیاز دارید حسابرسی نوین را فعال کنید.</li>
        <li>این پیام را به این دلیل میبینید چون هنوز حسابرسی نویسن را فعال نکرده اید.</li>";
$GLOBALS['strCampaignAuditTrailSetup'] = "برای دیدن کمپین ها ، حسابرسی نویسن را فعال کنید.";

$GLOBALS['strUnsavedChanges'] = "تنظیمات را در این صفحه ذخیره نکرده اید . مطمن شوید آن ها را ذخیره کرده باشید.";

//confirmation messages
$GLOBALS['strYouAreNowWorkingAsX'] = "شما در حال انجام کار به عنوان <b>%s</b>";
$GLOBALS['strYouDontHaveAccess'] = "شما اجازه دسترسی به صفحه را ندارید و منقل شده اید..";

$GLOBALS['strAdvertiserHasBeenAdded'] = "تبلیغ دهنده <a href='%s'>%s</a> اضافه شد, <a href='%s'>اضافه کردن یک کمپین</a>";
$GLOBALS['strAdvertiserHasBeenUpdated'] = "Aتبلیغ دهنده <a href='%s'>%s</a> بروزرسانی شد";
$GLOBALS['strAdvertiserHasBeenDeleted'] = "تبلیغ دهنده <b>%s</b> حذف گردید";
$GLOBALS['strAdvertisersHaveBeenDeleted'] = "همه ی تبلیغ دهنده های انتخاب شده حذف گردیدند.";

$GLOBALS['strTrackerHasBeenAdded'] = "Tracker <a href='%s'>%s</a> اضافه شد";
$GLOBALS['strTrackerHasBeenUpdated'] = "Tracker <a href='%s'>%s</a> بروزرسانی شد";
$GLOBALS['strTrackerVarsHaveBeenUpdated'] = "مقدار tracker <a href='%s'>%s</a> بروزرسانی شد";
$GLOBALS['strTrackerCampaignsHaveBeenUpdated'] = "کمپین های لینک شده tracker <a href='%s'>%s</a> بروزرسانی شد.";
$GLOBALS['strTrackerHasBeenDeleted'] = "Tracker <b>%s</b> حذف شد";
$GLOBALS['strTrackersHaveBeenDeleted'] = "همه ی ترکرهای انتخاب شده ، حذف گردیدند.";
$GLOBALS['strTrackerHasBeenDuplicated'] = "Tracker <a href='%s'>%s</a> کپی شد به <a href='%s'>%s</a>";
$GLOBALS['strTrackerHasBeenMoved'] = "Tracker <b>%s</b> به مبلغ انتقال داده شد <b>%s</b>";

$GLOBALS['strCampaignHasBeenAdded'] = "کمپین <a href='%s'>%s</a> اضافه شد, <a href='%s'>اضافه کردن یک بنر</a>";
$GLOBALS['strCampaignHasBeenUpdated'] = "کمپین <a href='%s'>%s</a> بروزرسانی شد";
$GLOBALS['strCampaignTrackersHaveBeenUpdated'] = "ترکرهای لینک شده کمپین <a href='%s'>%s</a> بروزرسانی شد.";
$GLOBALS['strCampaignHasBeenDeleted'] = "کمپین <b>%s</b> حذف گردید";
$GLOBALS['strCampaignsHaveBeenDeleted'] = "همه ی کمپین های انتخاب شده حذف گردیدند.";
$GLOBALS['strCampaignHasBeenDuplicated'] = "کمپین <a href='%s'>%s</a> کپی شد به <a href='%s'>%s</a>";
$GLOBALS['strCampaignHasBeenMoved'] = "کمپین <b>%s</b> به تبلیغ دهنده منتقل شد <b>%s</b>";

$GLOBALS['strBannerHasBeenAdded'] = "بنر <a href='%s'>%s</a> اضافه شد";
$GLOBALS['strBannerHasBeenUpdated'] = "بنر <a href='%s'>%s</a> بروزرسانی شد";
$GLOBALS['strBannerAdvancedHasBeenUpdated'] = "تنظیمات پیشرفته برای بنر <a href='%s'>%s</a> بروزرسانی شد";
$GLOBALS['strBannerAclHasBeenUpdated'] = "تنظیمات تحویل برای بنر <a href='%s'>%s</a> بروزرسانی شد";
$GLOBALS['strBannerAclHasBeenAppliedTo'] = "تنظیمات تحویل برای بنر <a href='%s'>%s</a> به %d بنر اعمال گردید";
$GLOBALS['strBannerHasBeenDeleted'] = "بنر <b>%s</b> حذف شد";
$GLOBALS['strBannersHaveBeenDeleted'] = "همه ی بنر های انتخاب شده حذف گردیدند.";
$GLOBALS['strBannerHasBeenDuplicated'] = "بنر <a href='%s'>%s</a> کپی شد به <a href='%s'>%s</a>";
$GLOBALS['strBannerHasBeenMoved'] = "بنر <b>%s</b> به کمپین انتقال پیدا کرد <b>%s</b>";
$GLOBALS['strBannerHasBeenActivated'] = "بنر <a href='%s'>%s</a> فعال شد";
$GLOBALS['strBannerHasBeenDeactivated'] = "بنر <a href='%s'>%s</a> غیر فعال شد";

$GLOBALS['strXZonesLinked'] = "<b>%s</b> منطقه یا منطقه های لینک شد";
$GLOBALS['strXZonesUnlinked'] = "<b>%s</b> منطقه یا منطقهه های غیر لینک شده";

$GLOBALS['strWebsiteHasBeenAdded'] = "سایت <a href='%s'>%s</a> اضافه شد, <a href='%s'>اضافه کردن یک منطقهe</a>";
$GLOBALS['strWebsiteHasBeenUpdated'] = "سایت <a href='%s'>%s</a> بروزرسانی شد";
$GLOBALS['strWebsiteHasBeenDeleted'] = "سایت <b>%s</b> حذف شد";
$GLOBALS['strWebsitesHaveBeenDeleted'] = "همه ی سایت های انتخاب شده حذف گردیدند";

$GLOBALS['strZoneHasBeenAdded'] = "منطقه <a href='%s'>%s</a> اضافه شد";
$GLOBALS['strZoneHasBeenUpdated'] = "منطقه <a href='%s'>%s</a> بروزرسانی شد";
$GLOBALS['strZoneAdvancedHasBeenUpdated'] = "تنظیمات پیشرفته برای منطقه <a href='%s'>%s</a> بروزرسانی شد";
$GLOBALS['strZoneHasBeenDeleted'] = "منطقه <b>%s</b> حذف گردید";
$GLOBALS['strZonesHaveBeenDeleted'] = "همه مناطق انتخاب شده حذف گردیدند";
$GLOBALS['strZoneHasBeenDuplicated'] = "منطقه <a href='%s'>%s</a> کپی شد به <a href='%s'>%s</a>";
$GLOBALS['strZoneHasBeenMoved'] = "منطقه <b>%s</b> انتقال یافت به منطقه <b>%s</b>";
$GLOBALS['strZoneLinkedBanner'] = "بنر به منطقه متصل شد <a href='%s'>%s</a>";
$GLOBALS['strZoneLinkedCampaign'] = "کمپین به منطقه متصل شد <a href='%s'>%s</a>";
$GLOBALS['strZoneRemovedBanner'] = "بنر از منطقه جدا شد <a href='%s'>%s</a>";
$GLOBALS['strZoneRemovedCampaign'] = "کمپین از منطقه غیر لینک شد <a href='%s'>%s</a>";


$GLOBALS['strUserPreferencesUpdated'] = "شما <b>%s</b> تنظیمات بروزرسانی شد";
$GLOBALS['strEmailChanged'] = "ایمیل شما تغییر کرد";
$GLOBALS['strPasswordChanged'] = "رمز شما تغییر کرد";
$GLOBALS['strXPreferencesHaveBeenUpdated'] = "<b>%s</b> hبروزرسانی شد";
$GLOBALS['strXSettingsHaveBeenUpdated'] = "<b>%s</b> hبروزرسانی شد";

// Report error messages
$GLOBALS['strReportErrorMissingSheets'] = "هیچ کاربرگی برای گزارش انتخاب نشده است";
$GLOBALS['strReportErrorUnknownCode'] = "ارور ناممشخص کد #";

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
$GLOBALS['keyPreviousItem'] = ",";

// Other keys
// Please make sure you underline the key you
// used in the string in default.lang.php
