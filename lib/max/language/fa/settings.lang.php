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
$GLOBALS['strDatabaseSettings'] = "تنظیمت دیتابیس";
$GLOBALS['strAdminAccount'] = "اکانت مدیریت";
$GLOBALS['strAdvancedSettings'] = "تنظیمات پیشر�?ته";
$GLOBALS['strWarning'] = "اخطار";
$GLOBALS['strBtnContinue'] = "ادامه دادن »";
$GLOBALS['strBtnRecover'] = "دوباره »";
$GLOBALS['strBtnAgree'] = "من موا�?قم »";
$GLOBALS['strBtnRetry'] = "مجدد";
$GLOBALS['strTablesType'] = "نوع جدول";

$GLOBALS['strRecoveryRequired'] = "There was an error while processing your previous upgrade and Openads must attempt to recover the upgrade process. Please click the Recover button below.";

$GLOBALS['strOaUpToDate'] = "Your Openads database and file structure are both using the most recent version and therefore no upgrade is required at this time. Please click Continue to proceed to the Openads administration panel.";
$GLOBALS['strOaUpToDateCantRemove'] = "Warning: the UPGRADE file is still present inside of your var folder. We are unable to remove this file because of insufficient permissions. Please delete this file yourself.";

$GLOBALS['strCheckDocumentation'] = "For more help, please see the <a href=\"http://{$PRODUCT_DOCSURL}\">Openads documentation</a>.";

$GLOBALS['strAdminUrlPrefix'] = "آدرس ورود به مدیریت";
$GLOBALS['strDeliveryUrlPrefix'] = "آدرس خروجی";
$GLOBALS['strDeliveryUrlPrefixSSL'] = "آدرس خروجی به صورت (SSL)";
$GLOBALS['strImagesUrlPrefix'] = "آدرس ذخیره سازی عکسها";
$GLOBALS['strImagesUrlPrefixSSL'] = "آدرس عکسها به صورت (SSL)";



/* ------------------------------------------------------- */
/* Configuration translations                            */
/* ------------------------------------------------------- */

// Global
$GLOBALS['strChooseSection'] = "انتخاب بخش";

// Configuration Settings
$GLOBALS['strConfigurationSettings'] = "تنظیمات پیکربندی";

// Administrator Settings
$GLOBALS['strAdminUsername'] = "نام کاربری مدیریت";
$GLOBALS['strAdminPassword'] = "پسورد مدیریت";
$GLOBALS['strInvalidUsername'] = "نام کاربری اشتباه است";
$GLOBALS['strBasicInformation'] = "اطلاعات اصلی";
$GLOBALS['strAdministratorEmail'] = "آدرس ایمیل مدیریت";
$GLOBALS['strAdminCheckUpdates'] = "چک برای به روزرسانی";
$GLOBALS['strUserlogEmail'] = "همه خروجی پیامهای ایمیل";
$GLOBALS['strEnableDashboard'] = "�?عال بودن داشبورد";
$GLOBALS['strTimezone'] = "ساعت";
$GLOBALS['strEnableAutoMaintenance'] = "نگهداری به صورت اتوماتیک تا زمان تحویل ";

// Database Settings
$GLOBALS['strDatabaseSettings'] = "تنظیمت دیتابیس";
$GLOBALS['strDatabaseServer'] = "تنظیمات کلی سرور دیتابیس";
$GLOBALS['strDbLocal'] = "متصل شدن به لوکال سرور";
$GLOBALS['strDbType'] = "نوع دیتابیس";
$GLOBALS['strDbHost'] = "نام هاست دیتابیس";
$GLOBALS['strDbPort'] = "پرت دیتابیس";
$GLOBALS['strDbUser'] = "نام کاربری دیتابیس";
$GLOBALS['strDbPassword'] = "پسورد دیتابیس";
$GLOBALS['strDbName'] = "نام دیتابیس";
$GLOBALS['strDatabaseOptimalisations'] = "تنظیمات آپشنهای کلی دیتابیس";
$GLOBALS['strPersistentConnections'] = "نسبت مانده مصر�?";

// Email Settings
$GLOBALS['strEmailSettings'] = "تنظیمات اصلی";
$GLOBALS['strQmailPatch'] = "Enable qmail patch";

// Audit Trail Settings

// Debug Logging Settings
$GLOBALS['strDebug'] = "تنظیمات کلی ر�?ع اشکال";
$GLOBALS['strEnableDebug'] = "�?عال بودن ر�?ع اشکال";
$GLOBALS['strDebugMethodNames'] = "همراه بودن نام مشکل و دلیل آن";
$GLOBALS['strDebugLineNumbers'] = "همراه بودن شماره خط ارور";
$GLOBALS['strDebugType'] = "نوع اشکال زدا";
$GLOBALS['strDebugTypeFile'] = "�?ایل";
$GLOBALS['strDebugTypeSql'] = "دیتا بیس اس کیو ال";
$GLOBALS['strDebugTypeSyslog'] = "سیستم ورود";
$GLOBALS['strDebugName'] = "نام و تاریخ ارور در جدول دیتابیس با نام";
$GLOBALS['strDebugPriority'] = "انتخاب مرحله اول ر�?ع مشکل";
$GLOBALS['strDebugIdent'] = "شناسایی ریشه مشکل";
$GLOBALS['strDebugUsername'] = "نام کاربری سرور اس کیو ال و سی پنل";
$GLOBALS['strDebugPassword'] = "پسورد سرور اس کیو ال و سی پنل";

// Delivery Settings
$GLOBALS['strWebPathSimple'] = "آدرس وب";
$GLOBALS['strDeliveryPath'] = "آدرس خروجی";
$GLOBALS['strImagePath'] = "آدرس عکسها";
$GLOBALS['strImageStore'] = "�?ولدر عکسها";
$GLOBALS['strTypeWebSettings'] = "تنظیمات کلی بنرهای در لوکال سرور";
$GLOBALS['strTypeWebMode'] = "روش ذخیره سازی";
$GLOBALS['strTypeWebModeLocal'] = "لوکال دایرکتوری";
$GLOBALS['strTypeWebDir'] = "لوکال دایرکتوری";
$GLOBALS['strTypeFTPHost'] = "ا�? ت پی هاست";
$GLOBALS['strTypeFTPDirectory'] = "هاست دایرکتوری";
$GLOBALS['strTypeFTPUsername'] = "ورود به سیستم";
$GLOBALS['strTypeFTPPassword'] = "رمز ";
$GLOBALS['strTypeFTPPassive'] = "است�?اده ا�? تی پی غیر�?عال";
$GLOBALS['strDeliveryFilenames'] = "کل نامهای �?ایل خروجی";
$GLOBALS['strDeliveryFilenamesAdClick'] = "کلیکها";
$GLOBALS['strDeliveryFilenamesAdConversionVars'] = "تغییر و متغییرها";
$GLOBALS['strDeliveryFilenamesAdContent'] = "گنجایش ( مثدار )";
$GLOBALS['strDeliveryFilenamesAdConversion'] = "تبدیلات";
$GLOBALS['strDeliveryFilenamesAdConversionJS'] = "تغییر (JavaScript)";
$GLOBALS['strDeliveryFilenamesAdFrame'] = "�?ریم";
$GLOBALS['strDeliveryFilenamesAdImage'] = "عکس";
$GLOBALS['strDeliveryFilenamesAdJS'] = "جاوا اسکریپت";
$GLOBALS['strDeliveryFilenamesAdLayer'] = "لایه";
$GLOBALS['strDeliveryFilenamesAdLog'] = "گزارش روزانه";
$GLOBALS['strDeliveryFilenamesAdPopup'] = "پاپ آپ";
$GLOBALS['strDeliveryFilenamesAdView'] = "نمایش";
$GLOBALS['strDeliveryFilenamesXMLRPC'] = "خروجی XML";
$GLOBALS['strDeliveryFilenamesLocal'] = "خروجی لوکال";
$GLOBALS['strDeliveryFilenamesFrontController'] = "جلو کنترل کننده";
$GLOBALS['strDeliveryFilenamesFlash'] = "همراه �?لش";
$GLOBALS['strDeliveryCaching'] = "تنظیمات کلی خروجی";
$GLOBALS['strDeliveryCacheLimit'] = "زمان بین به روز رسانی (ثانیه)";
$GLOBALS['strDeliveryAcls'] = "تعیین کردن با محدودیت خروجی برای بنرها";
$GLOBALS['strDeliveryObfuscate'] = "مبهم بودن خط مشی در هنگام خروجی تبلیغ";
$GLOBALS['strDeliveryExecPhp'] = "مجاز بودن است�?اده از کدهای پی اچ پی در آگهی ( از نظر امنیتی مشکل دارد )";
$GLOBALS['strDeliveryCtDelimiter'] = "پیگیری �?رد کلیک کننده";
$GLOBALS['strP3PSettings'] = "کنترل کلی به صورت مخ�?یانه";
$GLOBALS['strUseP3P'] = "کنترل مخ�?یانه";
$GLOBALS['strP3PCompactPolicy'] = "کنترل به صورت �?شرده";
$GLOBALS['strP3PPolicyLocation'] = "موقعیت کنترل";

// General Settings
$GLOBALS['generalSettings'] = "کل تنظیمات عمومی سیستم";
$GLOBALS['uiEnabled'] = "�?عال بودن کاربر";
$GLOBALS['defaultLanguage'] = "زبان پیش �?رض سیستم";

// Geotargeting Settings
$GLOBALS['strGeotargetingSettings'] = "تنظیمات آی اس پی";
$GLOBALS['strGeotargeting'] = "تنظیمات کلی آی اس پی";
$GLOBALS['strGeotargetingType'] = "نوع نمونه آی اس پی";

// Interface Settings
$GLOBALS['strInventory'] = "صورت موجودی";
$GLOBALS['strShowCampaignInfo'] = "Show extra campaign info on <i>Campaign overview</i> page";
$GLOBALS['strShowBannerInfo'] = "Show extra banner info on <i>Banner overview</i> page";
$GLOBALS['strShowCampaignPreview'] = "Show preview of all banners on <i>Banner overview</i> page";
$GLOBALS['strStatisticsDefaults'] = "آمار";
$GLOBALS['strBeginOfWeek'] = "آغاز ه�?ته";
$GLOBALS['strPercentageDecimals'] = "درصد اعشار";
$GLOBALS['strWeightDefaults'] = "وزن پیش �?رض";
$GLOBALS['strDefaultBannerWeight'] = "حجم پیش �?رض بنر";
$GLOBALS['strDefaultCampaignWeight'] = "حجم پیش �?رض داخلی";

// Invocation Settings
$GLOBALS['strEnable3rdPartyTrackingByDefault'] = "�?عال شدن 3ار دی در قبال هر کلیک به صورت پیش �?رض";

// Banner Delivery Settings

// Banner Logging Settings
$GLOBALS['strLogAdRequests'] = "ورود آگهی دهنده همیشه در صورت درخواست";
$GLOBALS['strLogAdImpressions'] = "ورود آگهی دهنده همیشه در صورت نمایش آثار";
$GLOBALS['strLogAdClicks'] = "ورود آگهی دهنده همیشه بعد از کلیک و نمایش کلیک";
$GLOBALS['strPreventLogging'] = "Global Prevent Statistics Logging Settings";
$GLOBALS['strIgnoreHosts'] = "Don't store statistics for viewers using one of the following IP addresses or hostnames";

// Banner Storage Settings

// Campaign ECPM settings

// Statistics & Maintenance Settings
$GLOBALS['strBlockAdClicks'] = "Don't log an Ad Click if the viewer has clicked on the same ad within the specified time (seconds)";
$GLOBALS['strPrioritySettings'] = "Global Priority Settings";
$GLOBALS['strAdminEmailHeaders'] = "Add the following headers to each e-mail message sent by {$PRODUCT_NAME}";
$GLOBALS['strWarnAgency'] = "Send a warning to the agency every time a campaign is almost expired";

// UI Settings
$GLOBALS['strGuiSettings'] = "تنظیمات بین کاربر";
$GLOBALS['strGeneralSettings'] = "تنظیمات عمومی";
$GLOBALS['strAppName'] = "نام درخواست کننده";
$GLOBALS['strMyHeader'] = "مکان �?ایل هدر";
$GLOBALS['strMyFooter'] = "مکان �?ایل �?وتر";
$GLOBALS['strDefaultTrackerStatus'] = "وضعیت پیش �?رض تراکر";
$GLOBALS['strDefaultTrackerType'] = "نوع پیش �?رض تراکر";
$GLOBALS['requireSSL'] = "کاربر مجاز به است�?اده از SSL می باشد";
$GLOBALS['sslPort'] = "پرت SSL توسط وب سرور";
$GLOBALS['strMyLogo'] = "نام مبدا �?ایل لوگو";
$GLOBALS['strGuiHeaderForegroundColor'] = "رنگ جلو هدر";
$GLOBALS['strGuiHeaderBackgroundColor'] = "رنگ بکگراند هدر";
$GLOBALS['strGuiActiveTabColor'] = "رنگ تب �?عال";
$GLOBALS['strGuiHeaderTextColor'] = "رنگ متن هدر";
$GLOBALS['strGzipContentCompression'] = "است�?اده از زیپ کردن برای �?شرده سازی";

// Regenerate Platfor Hash script

// Plugin Settings
