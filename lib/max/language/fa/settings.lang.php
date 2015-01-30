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
$GLOBALS['strAdminSettings'] = "تنظیمات مدیریت";
$GLOBALS['strAdminAccount'] = "اکانت مدیریت";
$GLOBALS['strAdvancedSettings'] = "تنظیمات پیشر�?ته";
$GLOBALS['strWarning'] = "اخطار";
$GLOBALS['strBtnContinue'] = "ادامه دادن »";
$GLOBALS['strBtnRecover'] = "دوباره »";
$GLOBALS['strBtnStartAgain'] = "شروع به روزرسانی مجدد";
$GLOBALS['strBtnGoBack'] = "« بازگشت";
$GLOBALS['strBtnAgree'] = "من موا�?قم »";
$GLOBALS['strBtnDontAgree'] = "« من موا�?ق نیستم";
$GLOBALS['strBtnRetry'] = "مجدد";
$GLOBALS['strTablesType'] = "نوع جدول";


$GLOBALS['strRecoveryRequired'] = "There was an error while processing your previous upgrade and Openads must attempt to recover the upgrade process. Please click the Recover button below.";

$GLOBALS['strOaUpToDate'] = "Your Openads database and file structure are both using the most recent version and therefore no upgrade is required at this time. Please click Continue to proceed to the Openads administration panel.";
$GLOBALS['strOaUpToDateCantRemove'] = "Warning: the UPGRADE file is still present inside of your var folder. We are unable to remove this file because of insufficient permissions. Please delete this file yourself.";
$GLOBALS['strRemoveUpgradeFile'] = "You must remove the UPGRADE file from the var folder.";
$GLOBALS['strInstallSuccess'] = "<strong>Congratulations! You have finished installing Openads</strong>
<p>Welcome to the Openads community! To get the most out of Openads, there are two last steps you should perform.</p>

<p><strong>Maintenance</strong><br>
Openads is configured to automatically run some maintenance tasks every hour as long as ads are being served. To speed up ad delivery, you can set this up by automatically calling a maintenance file every hour (e.g a cron job). This is not required, but is highly recommended. For more information about this, please reference the <a href='http://{$PRODUCT_DOCSURL}' target='_blank'><strong>documentation</strong></a>.</p>

<p><strong>Security</strong><br>
The Openads installation needs the configuration file to be writable by the server. After making your configuration changes, it is highly recommended to enable read-only access to this file, to provide higher security. For more information, please reference the <a href='http://{$PRODUCT_DOCSURL}' target='_blank'><strong>documentation</strong></a>.</p>

<p>You are now ready to start using Openads. Clicking continue will take you to your newly installed/upgraded version.</p>
<p>Before you start using Openads we suggest you take some time to review your configuration settings found within the \"Settings\" tab.";
$GLOBALS['strDbSuccessIntro'] = "The {$PRODUCT_NAME} database has now been created. Please click the 'Continue' button to proceed with configuring Openads Administrator and Delivery settings.";
$GLOBALS['strDbSuccessIntroUpgrade'] = "The {$PRODUCT_NAME} database has now been updated.  Please click the 'Continue' button to proceed with reviewing the {$PRODUCT_NAME} Administrator and Delivery settings.";


$GLOBALS['strCheckDocumentation'] = "For more help, please see the <a href=\"http://{$PRODUCT_DOCSURL}\">Openads documentation</a>.";

$GLOBALS['strAdminUrlPrefix'] = "آدرس ورود به مدیریت";
$GLOBALS['strDeliveryUrlPrefix'] = "آدرس خروجی";
$GLOBALS['strDeliveryUrlPrefixSSL'] = "آدرس خروجی به صورت (SSL)";
$GLOBALS['strImagesUrlPrefix'] = "آدرس ذخیره سازی عکسها";
$GLOBALS['strImagesUrlPrefixSSL'] = "آدرس عکسها به صورت (SSL)";

$GLOBALS['strInvalidUserPwd'] = "نام کاربری و پسورد اشتباه است";

$GLOBALS['strUpgrade'] = "به روز رسانی";

/* ------------------------------------------------------- */
/* Configuration translations                            */
/* ------------------------------------------------------- */

// Global
$GLOBALS['strChooseSection'] = "انتخاب بخش";
$GLOBALS['strEditConfigNotPossible'] = "It is not possible to edit all settings because the configuration file is locked for security reasons. " .
    "If you want to make changes, you may need to unlock the configuration file for this installation first.";
$GLOBALS['strEditConfigPossible'] = "It is possible to edit all settings because the configuration file is not locked, but this could lead to security issues. " .
    "If you want to secure your system, you need to lock the configuration file for this installation.";

// Configuration Settings
$GLOBALS['strConfigurationSetup'] = "نصب پیکربندی";
$GLOBALS['strConfigurationSettings'] = "تنظیمات پیکربندی";

// Administrator Settings
$GLOBALS['strAdministratorSettings'] = "تنظیمات مدیریت";
$GLOBALS['strAdministratorAccount'] = "اکانت مدیریت";
$GLOBALS['strLoginCredentials'] = "اطلاعات ورود";
$GLOBALS['strAdminUsername'] = "نام کاربری مدیریت";
$GLOBALS['strAdminPassword'] = "پسورد مدیریت";
$GLOBALS['strInvalidUsername'] = "نام کاربری اشتباه است";
$GLOBALS['strBasicInformation'] = "اطلاعات اصلی";
$GLOBALS['strAdminFullName'] = "نام کامل مدیر";
$GLOBALS['strAdminEmail'] = "آدرس ایمیل مدیران";
$GLOBALS['strAdministratorEmail'] = "آدرس ایمیل مدیریت";
$GLOBALS['strCompanyName'] = "نام کمپانی";
$GLOBALS['strAdminCheckUpdates'] = "چک برای به روزرسانی";
$GLOBALS['strAdminCheckEveryLogin'] = "ورود  همه";
$GLOBALS['strAdminCheckDaily'] = "روزانه";
$GLOBALS['strAdminCheckWeekly'] = "ه�?تگی";
$GLOBALS['strAdminCheckMonthly'] = "ماهیانه";
$GLOBALS['strAdminCheckNever'] = "همیشه";
$GLOBALS['strUserlogEmail'] = "همه خروجی پیامهای ایمیل";
$GLOBALS['strEnableDashboard'] = "�?عال بودن داشبورد";
$GLOBALS['strTimezone'] = "ساعت";
$GLOBALS['strTimezoneEstimated'] = "قیمت ساعتی";
$GLOBALS['strTimezoneDocumentation'] = "مدارک";
$GLOBALS['strAdminSettingsTitle'] = "اکانت مدیریت شما";
$GLOBALS['strAdminSettingsIntro'] = "The administrator account is used to login to the {$PRODUCT_NAME} interface and manage inventory, view statistics, and create tags. Please fill in the username, password, and email address of the administrator.";
$GLOBALS['strConfigSettingsIntro'] = "Please review the following configuration settings. It is very important that you carefully review these settings as they are vital to the performance and usage of {$PRODUCT_NAME}";

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
$GLOBALS['strDemoDataInstall'] = "نصب اطلاعات پیش �?رض";



// Email Settings
$GLOBALS['strEmailSettings'] = "تنظیمات اصلی";
$GLOBALS['strQmailPatch'] = "Enable qmail patch";

// Audit Trail Settings

// Debug Logging Settings
$GLOBALS['strDebug'] = "تنظیمات کلی ر�?ع اشکال";
$GLOBALS['strProduction'] = "خرورجی سرور";
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
$GLOBALS['strDeliverySettings'] = "تنظیمات خروجی";
$GLOBALS['strWebPath'] = "$PRODUCT_NAME Server Access Paths";
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


$GLOBALS['strOrigin'] = "است�?اده جزیی مبدا سرور";
$GLOBALS['strOriginType'] = "نوع اصلی سرور";
$GLOBALS['strOriginHost'] = "نام هاست برای سرور اصلی";
$GLOBALS['strOriginPort'] = "شماره پرت برای دیتابیس اصلی";
$GLOBALS['strOriginScript'] = "�?ایل اسکریپت برای دیتابیس اصلی";
$GLOBALS['strOriginTimeout'] = "زمان باقیمانده ( ثانیه )";
$GLOBALS['strOriginProtocol'] = "قاعده سرور اصلی";

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
$GLOBALS['strGeotargetingGeoipCountryLocation'] = "آخرین آی پی دیتابیس";

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

$GLOBALS['strPublisherDefaults'] = "ناشر پیش �?رض";
$GLOBALS['strModesOfPayment'] = "نحوه پرداخت وجه";
$GLOBALS['strCurrencies'] = "پول رایج";
$GLOBALS['strCategories'] = "مجموعه ها";
$GLOBALS['strHelpFiles'] = "�?ایل راهنما";
$GLOBALS['strDefaultApproved'] = "چک کردن بسته تایید شده ها";

// CSV Import Settings
$GLOBALS['strDefaultConversionStatus'] = "عملکرد تغییرات پیش �?رض";
$GLOBALS['strDefaultConversionType'] = "عملکرد تغییرات پیش �?رض";

/**
 * @todo remove strBannerSettings if banner is only configurable as a preference
 *       rename // Banner Settings to  // Banner Preferences
 */
// Invocation Settings
$GLOBALS['strAllowedInvocationTypes'] = "انواع مجوز خروجی";
$GLOBALS['strEnable3rdPartyTrackingByDefault'] = "�?عال شدن 3ار دی در قبال هر کلیک به صورت پیش �?رض";

// Banner Delivery Settings

// Banner Logging Settings
$GLOBALS['strLogAdRequests'] = "ورود آگهی دهنده همیشه در صورت درخواست";
$GLOBALS['strLogAdImpressions'] = "ورود آگهی دهنده همیشه در صورت نمایش آثار";
$GLOBALS['strLogAdClicks'] = "ورود آگهی دهنده همیشه بعد از کلیک و نمایش کلیک";
$GLOBALS['strLogTrackerImpressions'] = "ورود تراکر در صورت نمایش یک اثر برای همیشه";
$GLOBALS['strPreventLogging'] = "Global Prevent Statistics Logging Settings";
$GLOBALS['strIgnoreHosts'] = "Don't store statistics for viewers using one of the following IP addresses or hostnames";

// Banner Storage Settings

// Campaign ECPM settings

// Statistics & Maintenance Settings
$GLOBALS['strBlockAdViews'] = "Don't log an Ad Impression if the viewer has seen the same ad within the specified time (seconds)";
$GLOBALS['strBlockAdClicks'] = "Don't log an Ad Click if the viewer has clicked on the same ad within the specified time (seconds)";
$GLOBALS['strPrioritySettings'] = "Global Priority Settings";
$GLOBALS['strAdminEmailHeaders'] = "Add the following headers to each e-mail message sent by {$PRODUCT_NAME}";
$GLOBALS['strAllowEmail'] = "Globally allow sending of e-mails";
$GLOBALS['strEmailAddressName'] = "Company or personal name to sign off e-mail with";
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

$GLOBALS['strPublisherInterface'] = "Publisher interface";
$GLOBALS['strPublisherAgreementEnabled'] = "Enable login control for publishers who haven't accepted Terms and Conditions";

// Regenerate Platfor Hash script

// Plugin Settings

/* ------------------------------------------------------- */
/* Unknown (unused?) translations                        */
/* ------------------------------------------------------- */


