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
$GLOBALS['strInstall'] = "نصب";
$GLOBALS['strDatabaseSettings'] = "تنظیمات پایگاه داده";
$GLOBALS['strAdminAccount'] = "اکانت ادمین سیستم";
$GLOBALS['strAdvancedSettings'] = "تنظیمات پیشرفته";
$GLOBALS['strWarning'] = "اخطار";
$GLOBALS['strBtnContinue'] = "ادامه »";
$GLOBALS['strBtnRecover'] = "بازیابی »";
$GLOBALS['strBtnAgree'] = "موافقم »";
$GLOBALS['strBtnRetry'] = "دوباری";
$GLOBALS['strTablesPrefix'] = " پیشوند نام های جدول ";
$GLOBALS['strTablesType'] = "نوع جدول";

$GLOBALS['strRecoveryRequiredTitle'] = "تلاش قبلی شما برای بروزرسانی شکست خورد";
$GLOBALS['strRecoveryRequired'] = "اروری هنگام پردازش بروزرسانی قبلی شما بود و{$PRODUCT_NAME}  باید برای بازیابی بروزرسانی تلاش کند لطفا دکمه ی بازیابی زیر را بفشارید";

$GLOBALS['strProductUpToDateTitle'] = "{$PRODUCT_NAME} بروزرسانی شده";
$GLOBALS['strOaUpToDate'] = "ساختمان فایل و پایگاه داده شما از جدیدترین نسخه استفاده می کنند و بنابراین به بروزرسانی نیاز ندارند . لطفا روی ادامه کلیک کنید تا به پنل ادمین وارد شوید";
$GLOBALS['strOaUpToDateCantRemove'] = " فایل آپدیت همچنان در داخل فولدر 'var' است . ما قادر به حذف این فایل نیستیم زیرا دسترسی وجود ندارد . لطفا خودتان این فایل را حذف کنید ";
$GLOBALS['strErrorWritePermissions'] = "ارور های اجازه ی فایل یافت شدند, و باید قبل از ادامه درست شوند.<br />برای حل مشکلات در سیستم عامل linux, دستورات زیر را وارد کنید(s):";
$GLOBALS['strNotWriteable'] = "قابلیت نوشتن ندارد";
$GLOBALS['strDirNotWriteableError'] = "دایرکتوری باید نوشتنی باشد";

$GLOBALS['strErrorWritePermissionsWin'] = "ارور های دسترسی فایل یافت شدند, و باید قبل از ادامه حل شوند.";
$GLOBALS['strCheckDocumentation'] = "برای کمک بیشتر, مراجعه کنید به <a href=\"{$PRODUCT_DOCSURL}\">{$PRODUCT_NAME} اسناد</a>.";
$GLOBALS['strSystemCheckBadPHPConfig'] = "تنظیمات فعلی php شما نیازمندی های {$PRODUCT_NAME} را ندارد. برای حل مشکلات, لطفا تنظیمات را در فایل’php.ini’انجام دهید.";

$GLOBALS['strAdminUrlPrefix'] = "URL رابط ادمین";
$GLOBALS['strDeliveryUrlPrefix'] = "موتور تحویل URL";
$GLOBALS['strDeliveryUrlPrefixSSL'] = "موتور تحویل URL (SSL)";
$GLOBALS['strImagesUrlPrefix'] = "پایگاه عکس URL";
$GLOBALS['strImagesUrlPrefixSSL'] = " پایگاه عکس URL (SSL)";


$GLOBALS['strUpgrade'] = "ارتقاء";

/* ------------------------------------------------------- */
/* Configuration translations                            */
/* ------------------------------------------------------- */

// Global
$GLOBALS['strChooseSection'] = "انتخاب بخش";
$GLOBALS['strEditConfigNotPossible'] = " این امکان پذیر است که تمام تنظیمات را ویرایش کنید بدلیل اینکه فایل پیکربندی قفل است بنا به دلایل امنیتی . اگر می خواهید تغییراتی ایجاد کنید ، ممکن است نیاز باشد فایل پیکربندی را برای این نصب بگشایید. ";
$GLOBALS['strEditConfigPossible'] = " این امکان پذیر است که تمام تنظیمات را ویرایش کنید بدلیل اینکه فایل پیکربندی قفل نیست ، اما این ممکن است به مشکل امنیتی منجر شود . اگر می خواهید سیستم خود را امن کنید ، نیازمند است فایل پیکر بندی را برای نصب قف کنید.";
$GLOBALS['strUnableToWriteConfig'] = "امکان نوشتن تغییرات روی فایل تنظیم نیست";
$GLOBALS['strUnableToWritePrefs'] = "امکان تغییر ظواهر در پایگاه داده نیست";
$GLOBALS['strImageDirLockedDetected'] = "فولدر عکس داده شده قابل نوشتن از طریق سرور نیست. <br> شما نمی توانید ادامه دهید مگر اینکه دسترسی فولدر را تغییر داده یا فولدر جدیدی بسازید.";

// Configuration Settings
$GLOBALS['strConfigurationSettings'] = "تنظیمات پیکربندی";

// Administrator Settings
$GLOBALS['strAdminUsername'] = "یوزر ادمین";
$GLOBALS['strAdminPassword'] = "پسورد ادمین";
$GLOBALS['strInvalidUsername'] = "یوزر اشتباه";
$GLOBALS['strBasicInformation'] = "اطلاعات پایه";
$GLOBALS['strAdministratorEmail'] = "ایمیل ادمین";
$GLOBALS['strAdminCheckUpdates'] = "چک کردن بروزرسانی و پیام های امنیتی به صورت اتوماتیک(پیشنهاد شده).";
$GLOBALS['strAdminShareStack'] = "به اشتراک گذاری اطلاعات با تیم {$PRODUCT_NAME} برای کمک به پیشرفت و آزمایش .";
$GLOBALS['strNovice'] = "حذف اقداماتی که نیازمند تایید برای امنیت اند.";
$GLOBALS['strUserlogEmail'] = "ثبت تمام ایمیل های خروجی ";
$GLOBALS['strEnableDashboard'] = "فعال سازی داشبورد";
$GLOBALS['strEnableDashboardSyncNotice'] = "لطفا را فعال کنید چک کردن بروزرسانی تا بتوانید از داشبورد استفاده کنید.";
$GLOBALS['strTimezone'] = "منطقه زمانی";
$GLOBALS['strEnableAutoMaintenance'] = "تعمیر اتوماتیک هنگام تحویل اگر تعمیر برنامه ریزی شده انجام نشده";

// Database Settings
$GLOBALS['strDatabaseSettings'] = "تنظیمات پایگاه داده";
$GLOBALS['strDatabaseServer'] = "تنظیمات سرور پایگاه داده";
$GLOBALS['strDbLocal'] = "استفاده از اتصال محلی";
$GLOBALS['strDbType'] = "نوع پایگاه داده";
$GLOBALS['strDbHost'] = "نام میزبان پایگاه داده";
$GLOBALS['strDbSocket'] = "سوکت پایگاه داده";
$GLOBALS['strDbPort'] = "شماره پورت پایگاه داده";
$GLOBALS['strDbUser'] = "یوزر پایگاه داده";
$GLOBALS['strDbPassword'] = "پسورد پایگاه داده";
$GLOBALS['strDbName'] = "نام پایگاده داده";
$GLOBALS['strDbNameHint'] = "پایگاه داده ایجاد خواهد شد اگر وجود نداشته باشد";
$GLOBALS['strDatabaseOptimalisations'] = "تنظیمات بهینه سازی پایگاه داده";
$GLOBALS['strPersistentConnections'] = "استفاده از اتصال پایدار";
$GLOBALS['strCantConnectToDb'] = "عدم اتصال به پایگاه داده";
$GLOBALS['strCantConnectToDbDelivery'] = 'عدم اتصال به پایگاه داده برای تحویل ';

// Email Settings
$GLOBALS['strEmailSettings'] = "تنظیمات ایمیل";
$GLOBALS['strEmailAddresses'] = "ایمیل 'از' آدرس";
$GLOBALS['strEmailFromName'] = "ایمیل 'از' نام";
$GLOBALS['strEmailFromAddress'] = "ایمیل 'از' ایمیل آدرس";
$GLOBALS['strEmailFromCompany'] = "ایمیل 'از' شرکت";
$GLOBALS['strUseManagerDetails'] = 'استفاده از مخاطب ، ایمیل و نام صاحبان جساب به جای نام ، ایمیل آدرس و شرکت بالا زمانی که گزارشات به تبلیغ کننده یا وبسایت حساب ها ایمیل می شود. ';
$GLOBALS['strQmailPatch'] = "پچ کیومیل";
$GLOBALS['strEnableQmailPatch'] = "فعال سازی پچ کیومیل";
$GLOBALS['strEmailHeader'] = "هدر های ایمیل";
$GLOBALS['strEmailLog'] = "ثبت ایمیل";

// Audit Trail Settings
$GLOBALS['strAuditTrailSettings'] = "تنظیمات حسابرسی نوین";
$GLOBALS['strEnableAudit'] = "فعال سازی حسابرسی نویس";
$GLOBALS['strEnableAuditForZoneLinking'] = "فعال سازی حسابرسی نویس برای منطقه ی صفحه نمایش لینک کردن (خطا عملکرد عظیم را هنگام اتصال تعداد زیادی منطقه منجر می شود) ";

// Debug Logging Settings
$GLOBALS['strDebug'] = "اشکال زدایی تنظیمات ورودی";
$GLOBALS['strEnableDebug'] = "فعال سازی ورود اشکال زدایی";
$GLOBALS['strDebugMethodNames'] = "شامل شدن نام های متد در ثبت اشکال زدایی";
$GLOBALS['strDebugLineNumbers'] = "شامل شدن تعداد خطوط در ثبت اشکال زدایی";
$GLOBALS['strDebugType'] = "نوع ثبت اشکال زدایی";
$GLOBALS['strDebugTypeFile'] = "فایل";
$GLOBALS['strDebugTypeMcal'] = "ام کال";
$GLOBALS['strDebugTypeSql'] = "پایگاه داده sql";
$GLOBALS['strDebugTypeSyslog'] = "سیستم ورود";
$GLOBALS['strDebugName'] = "اشکال زدایی ثبت نام ، تاریخ ، جدول sql
یا امکانات syslog";
$GLOBALS['strDebugPriority'] = "اشکال زدایی سطح اولویت";
$GLOBALS['strPEAR_LOG_DEBUG'] = "PEAR_LOG_اشکال زدایی - اکثر اطلاعات";
$GLOBALS['strPEAR_LOG_INFO'] = "PEAR_LOG_اطلاعات - اطلاعات اولیه";
$GLOBALS['strPEAR_LOG_NOTICE'] = "PEAR_LOG_ااطلاعیه";
$GLOBALS['strPEAR_LOG_WARNING'] = "PEAR_LOG_اخطار";
$GLOBALS['strPEAR_LOG_ERR'] = "PEAR_LOG_ارور";
$GLOBALS['strPEAR_LOG_CRIT'] = "PEAR_LOG_مهم";
$GLOBALS['strPEAR_LOG_ALERT'] = "PEAR_LOG_پیغام";
$GLOBALS['strPEAR_LOG_EMERG'] = "PEAR_LOG_نمایان شدن - حداقل اطلاعات";
$GLOBALS['strDebugIdent'] = "اشکال زدایی شناسایی رشته";
$GLOBALS['strDebugUsername'] = "mCal, SQL Server یوزر";
$GLOBALS['strDebugPassword'] = "mCal, SQL Server پسورد";
$GLOBALS['strProductionSystem'] = "سیستم تولید";

// Delivery Settings
$GLOBALS['strWebPath'] = "{$PRODUCT_NAME} مسیر دستیابی سرور";
$GLOBALS['strWebPathSimple'] = "مسیر وب";
$GLOBALS['strDeliveryPath'] = "مسیر تحویل";
$GLOBALS['strImagePath'] = "مسیر عکس";
$GLOBALS['strDeliverySslPath'] = "مسیر ssl تحویل";
$GLOBALS['strImageSslPath'] = "مسیر ssl عکس";
$GLOBALS['strImageStore'] = "فولدر عکس";
$GLOBALS['strTypeWebSettings'] = "تنظیمات ذخیره سازی بنر محلی سرور";
$GLOBALS['strTypeWebMode'] = "متد ذخیره سازی";
$GLOBALS['strTypeWebModeLocal'] = "دایرکتوری محلی";
$GLOBALS['strTypeDirError'] = "دایرکتوری محلی نمی تواند توسط وب سرور نوشته شود";
$GLOBALS['strTypeWebModeFtp'] = "سرور ftp خارجی";
$GLOBALS['strTypeWebDir'] = "دایرکتوری محلی";
$GLOBALS['strTypeFTPHost'] = "میزبان ftp";
$GLOBALS['strTypeFTPDirectory'] = "دایرکتوری میزبان";
$GLOBALS['strTypeFTPUsername'] = "ورود";
$GLOBALS['strTypeFTPPassword'] = "رمز ";
$GLOBALS['strTypeFTPPassive'] = "استفاده از passive ftp";
$GLOBALS['strTypeFTPErrorDir'] = "دایرکتوری میزبان ftp موجود نمی باشد";
$GLOBALS['strTypeFTPErrorConnect'] = "وصل شدن به سرور ftp امکان پذیر نمی باشد ، یوزر یا پسورد اشتباه است";
$GLOBALS['strTypeFTPErrorNoSupport'] = "php نصب شده شما از ftp پشتیبانی نمی کند.";
$GLOBALS['strTypeFTPErrorUpload'] = "امکان بارگذاری فایل ها به ftp server وجود ندارد ، حقوق مناسب برای دایرکتوری میزبان را چک کنید ";
$GLOBALS['strTypeFTPErrorHost'] = "میزبان ftp درست نمی باشد";
$GLOBALS['strDeliveryFilenames'] = "تحویل نام فایلها";
$GLOBALS['strDeliveryFilenamesAdClick'] = "کلیک تبلغ";
$GLOBALS['strDeliveryFilenamesAdConversionVars'] = "تغییر متغییرات تبلیغ";
$GLOBALS['strDeliveryFilenamesAdContent'] = "محتوی تبلیغ";
$GLOBALS['strDeliveryFilenamesAdConversion'] = "تغییر تبلیغ";
$GLOBALS['strDeliveryFilenamesAdConversionJS'] = "تغییر تبلیغ(JavaScript)";
$GLOBALS['strDeliveryFilenamesAdFrame'] = "چارچوب تبلیغ";
$GLOBALS['strDeliveryFilenamesAdImage'] = "عکس تبلیغ";
$GLOBALS['strDeliveryFilenamesAdJS'] = "تبلیغ (JavaScript)";
$GLOBALS['strDeliveryFilenamesAdLayer'] = "لایه تبلیغ";
$GLOBALS['strDeliveryFilenamesAdLog'] = "ثبت تبلیغ";
$GLOBALS['strDeliveryFilenamesAdPopup'] = "پنجره تبلیغ";
$GLOBALS['strDeliveryFilenamesAdView'] = "نمایش تبلیغ";
$GLOBALS['strDeliveryFilenamesXMLRPC'] = "XML RPC فراخوانی";
$GLOBALS['strDeliveryFilenamesLocal'] = "فراخوانی محلی";
$GLOBALS['strDeliveryFilenamesFrontController'] = "کنترل کننده ی جلویی";
$GLOBALS['strDeliveryFilenamesSinglePageCall'] = "فراخوانی یک صفحه";
$GLOBALS['strDeliveryFilenamesSinglePageCallJS'] = "فراخوانی یک صفحه (JavaScript)";
$GLOBALS['strDeliveryCaching'] = "تنظیمات کش تحویل بنر";
$GLOBALS['strDeliveryCacheLimit'] = "زمان بین بروزرسانی کش بنر(ثانیه)";
$GLOBALS['strDeliveryCacheStore'] = "نوع ذخیره سازی کش تویل بنر";
$GLOBALS['strP3PSettings'] = "P3P سیاست حفظ حریم خصوصی";
$GLOBALS['strUseP3P'] = "استفاده از P3P سیاست";
$GLOBALS['strP3PCompactPolicy'] = "P3P سیاست جمع و جور";
$GLOBALS['strP3PPolicyLocation'] = "P3P سیاست محل سکونت";

// General Settings
$GLOBALS['generalSettings'] = "تنظیمات سیستم عمومی جهانی";
$GLOBALS['uiEnabled'] = "رابط کاربری فعال شد";
$GLOBALS['defaultLanguage'] = "زبان اولیه ی سیستمe
(هر کاربر می تواند زبان خودش را انتخاب کند)";

// Geotargeting Settings
$GLOBALS['strGeotargetingSettings'] = "Geotargeting سیستم";
$GLOBALS['strGeotargeting'] = "Geotargeting سیستم";
$GLOBALS['strGeotargetingType'] = "Geotargeting نوع مدل";

// Interface Settings
$GLOBALS['strInventory'] = "فهرست";
$GLOBALS['strShowCampaignInfo'] = "نمایش اطلاعات اضافی در صفحه کمپین";
$GLOBALS['strShowBannerInfo'] = "نمایش اطلاعات اضافی بنر در صفحه بنر";
$GLOBALS['strShowCampaignPreview'] = "پیش نمایش تمام بنر ها در صفحه بنر ها";
$GLOBALS['strShowBannerHTML'] = "نمایش بنر واقعی به جای کد HTML ساده برای پیشمایش بنر HTML ";
$GLOBALS['strShowBannerPreview'] = "نمایش پیش نمایش بنر در بالای صفحات که با بنر ها سر و کار دارد";
$GLOBALS['strHideInactive'] = "پنهان کردن اعضای غیر فعال از تمام صفحات نمایش";
$GLOBALS['strGUIShowMatchingBanners'] = "نمایش بنر های مچ شده در صفحه های لینک شده بنر";
$GLOBALS['strGUIShowParentCampaigns'] = "نمایش کمپین های پدر در صفحات بنر لینک شده";
$GLOBALS['strShowEntityId'] = "نمایش شناسایی کننده ی وجودیت";
$GLOBALS['strStatisticsDefaults'] = "آمار";
$GLOBALS['strBeginOfWeek'] = "شروع هفته";
$GLOBALS['strPercentageDecimals'] = "اعشار درصد ها";
$GLOBALS['strWeightDefaults'] = "وزن اولیه";
$GLOBALS['strDefaultBannerWeight'] = "وزن اولیه بنر";
$GLOBALS['strDefaultCampaignWeight'] = "وزن کمپین اولیه";
$GLOBALS['strConfirmationUI'] = "تایید رابط کاربری";

// Invocation Settings
$GLOBALS['strInvocationDefaults'] = "پیش فرضیات فراخوانی";
$GLOBALS['strEnable3rdPartyTrackingByDefault'] = "فعال سازی پیگیری کیلک بخش سوم به شکل پیش فرض";

// Banner Delivery Settings
$GLOBALS['strBannerDelivery'] = "تنظیمات تحویل بنر";

// Banner Logging Settings
$GLOBALS['strBannerLogging'] = "تنظیمات ورود بنر";
$GLOBALS['strLogAdRequests'] = "ثبت یک درخواست هر وقت بنری درخواست شود";
$GLOBALS['strLogAdImpressions'] = "ثبت اثر هر وقت بنری مشاهده شد";
$GLOBALS['strLogAdClicks'] = "ثبت کلیک هر وقت مشاهده کننده ای روی بنر کلیک کرد";
$GLOBALS['strReverseLookup'] = "بر عکس کردن جستجو نام های میزبان مشاهده کنندگان وقتی در دسترس نبود";
$GLOBALS['strProxyLookup'] = "تلاش برای تخمین آدرس ip مشاهده کنندگان پشت سرور پراکسی";
$GLOBALS['strPreventLogging'] = "بلاک تنظیمات ورودی بنر";
$GLOBALS['strIgnoreHosts'] = "ثبت نکردن آمار برای بازدیدکنندگان بدون استفاده از هیچ یک از ip آدرس ها یا نام میزبان ها";
$GLOBALS['strIgnoreUserAgents'] = "ثبت نکردن آمار از مشتریان بدون استفاده از هیچ یک از رشته های موجود در user-agent آنها ";
$GLOBALS['strEnforceUserAgents'] = " تنها ثبت کردن آمار از مشتریان بدون استفاده از هیچ یک از رشته های موجود در user-agent آنها";

// Banner Storage Settings
$GLOBALS['strBannerStorage'] = "تنظیمات ذخیره سازی بنر";

// Campaign ECPM settings
$GLOBALS['strEnableECPM'] = "استفاده از eCPM اولویت های بهینه شده به جای اولویت های باقی مانده ";
$GLOBALS['strEnableContractECPM'] = "استفاده از eCPM اولویت های بهینه شده به جای اولویت های رابطه استاندارد";
$GLOBALS['strEnableECPMfromRemnant'] = "(اگر شما این ویژگی را فعال کنید تمام کمپین های باقی مانده شما غیر فعال می شوند ، شما باید آنها را به صورت دستی بروزرسانی کنید تا فعال شوند .)";
$GLOBALS['strEnableECPMfromECPM'] = "(اگر شما این ویژگی را غیر فعال کنید برخی از eCPM های فعال شما غیر فعال می شوند ، شما باید آنها را به صورت دستی بروزرسانی کنید تا دوباره فعال شوند)";
$GLOBALS['strInactivatedCampaigns'] = "لیست کمپین هایی که بر اساس تغییر در ظواهر غیر فعال می شوند:";

// Statistics & Maintenance Settings
$GLOBALS['strMaintenanceSettings'] = "تنظیمات نگهداری";
$GLOBALS['strConversionTracking'] = "تنظیمات پیگیری تغییرات";
$GLOBALS['strEnableConversionTracking'] = "فعال سازی پیگیری تغییرات";
$GLOBALS['strBlockAdClicks'] = "نشمردن کلیک تبلیغات اگر بیننده روی همان جفت منطقه/تبلیغ در زمانی مشخص کلیک کرده";
$GLOBALS['strMaintenanceOI'] = "تعمیر و نگهداری عملیات فاصله (دقیقه)";
$GLOBALS['strPrioritySettings'] = "تنظیمات اولویت ها";
$GLOBALS['strPriorityInstantUpdate'] = "بروزرسانی اولویت تبلیغات بلافاصله بعد از اعمال تغییرات در UI";
$GLOBALS['strPriorityIntentionalOverdelivery'] = "ارائه ی بیش از حد قرارداد کمپین ها به صورت عمدی
(% over-delivery)";
$GLOBALS['strAdminEmailHeaders'] = "اضافه کردن هدر های داده شده به هر یک از ایمیل های فرستاده شده از {$PRODUCT_NAME}";
$GLOBALS['strWarnLimit'] = "ارسال ارور هر وقت تاثیرات باقی مانده کمتر از تاثیرات مشخص شده در اینجا";
$GLOBALS['strWarnLimitDays'] = "ارسال ارور هر وقت روز های باقی مانده کمتر از روز های مشخص شده در اینجا";
$GLOBALS['strWarnAdmin'] = "ارسال ارور به ادمین هر وقت کمپینی منقضی شده";
$GLOBALS['strWarnClient'] = "ارسال ارور به تبلیغ کننده هر وقت کمپینی منقضی شده";
$GLOBALS['strWarnAgency'] = "ارسال ارور به اکانت هر وقت کمپینی منقضی شده";

// UI Settings
$GLOBALS['strGuiSettings'] = "تنظیمات رابط کاربری";
$GLOBALS['strGeneralSettings'] = "تنظیمات عمومی";
$GLOBALS['strAppName'] = "نام برنامه";
$GLOBALS['strMyHeader'] = "محل فایل هدر";
$GLOBALS['strMyFooter'] = "محل فایل فوتر";
$GLOBALS['strDefaultTrackerStatus'] = "وضعیت پیگیر کننده ی اولیه";
$GLOBALS['strDefaultTrackerType'] = "نوع پیگیر کننده ی اولیه";
$GLOBALS['strSSLSettings'] = "تنظیمات SSL";
$GLOBALS['requireSSL'] = "اعمال دسترسی SSL به رابط کاربری";
$GLOBALS['sslPort'] = "پورت SSL استفاده شده توسط وب سرور";
$GLOBALS['strDashboardSettings'] = "تنظیمات داشبورد";
$GLOBALS['strMyLogo'] = "نام/ URL لوگو فایل مرسوم";
$GLOBALS['strGuiHeaderForegroundColor'] = "رنگ پیش زمینه ی هدر";
$GLOBALS['strGuiHeaderBackgroundColor'] = "رنگ پس زمینه ی هدر";
$GLOBALS['strGuiActiveTabColor'] = "رنگ تب فعال";
$GLOBALS['strGuiHeaderTextColor'] = "رنگ متن هدر";
$GLOBALS['strGuiSupportLink'] = "URL مرسوم برای لینک Support در هدر";
$GLOBALS['strGzipContentCompression'] = "استفاده از فشرده سازی محتوای GZIp";

// Regenerate Platfor Hash script
$GLOBALS['strPlatformHashRegenerate'] = "پلتفرم هش بازسازی شد";
$GLOBALS['strNewPlatformHash'] = "پلت فرم هش جدید شما:";
$GLOBALS['strPlatformHashInsertingError'] = "خطا در افزودن پلتفرم hash به پایگاه داده";

// Plugin Settings
$GLOBALS['strPluginSettings'] = "تنظیمات پلاگین";
$GLOBALS['strEnableNewPlugins'] = "فعال سازی پلاگین هایی که به تازگی نصب شده اند .";
$GLOBALS['strUseMergedFunctions'] = "استفاده از ادغام فایل توابع تحویل";
