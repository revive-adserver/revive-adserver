<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.4                                                              |
| ============                                                              |
|                                                                           |
| Copyright (c) 2003-2007 Openads Limited                                   |
| For contact details, see: http://www.openads.org/                         |
|   Translation :  Adel Shia Ali  http://MasterDesign.ir                    |
+---------------------------------------------------------------------------+
$Id$
*/

/**
 * A file for holding the "settings" English translation information.
 *
 * @package    MaxUI
 * @subpackage Languages
 */

// Installer translation strings
$GLOBALS['strInstall']                      = "نصب";
$GLOBALS['strChooseInstallLanguage']        = "انتخاب زبان جدید برای نصب";
$GLOBALS['strLanguageSelection']            = "تنظیمات زبان";
$GLOBALS['strDatabaseSettings']             = "تنظیمات دیتابیس";
$GLOBALS['strAdminSettings']                = "تنظیمات مدیریت";
$GLOBALS['strAdminAccount']                 = "اکانت مدیریت";
$GLOBALS['strAdministrativeSettings']       = "تنظیمات مدیراجرایی";
$GLOBALS['strAdvancedSettings']             = "تنظیمات پیشر�?ته";
$GLOBALS['strOtherSettings']                = "سایر تنظیمات";
$GLOBALS['strSpecifySyncSettings']          = "تنظیمات همگانی";
$GLOBALS['strLicenseInformation']           = "اطلاعات لایسنس";
$GLOBALS['strOpenadsIdYour']                = "آی دی اپن ادس شما";
$GLOBALS['strOpenadsIdSettings']            = "تنظیمات آی دی اپن ادز";
$GLOBALS['strWarning']                      = "اخطار";
$GLOBALS['strFatalError']			= "  یک خطای مهم رخ داده است";
$GLOBALS['strUpdateError']			= "یک خطا در طی بروزرسانی برنامه رخ داده است";
$GLOBALS['strBtnContinue']                  = "ادامه دادن »";
$GLOBALS['strBtnRecover']                   = "دوباره »";
$GLOBALS['strBtnStartAgain']                   = "شروع به روزرسانی مجدد";
$GLOBALS['strBtnGoBack']                    = "« بازگشت";
$GLOBALS['strBtnAgree']                     = "من موا�?قم »";
$GLOBALS['strBtnDontAgree']                 = "« من موا�?ق نیستم";
$GLOBALS['strBtnRetry']                     = "مجدد";
$GLOBALS['strUpdateDatabaseError']	= "به دلایل ناشناخته ساختار بانک اطلاعاتی بروزرسانی نشد. برای پردازش دوباره توصیه میشود که <b>تلاش دوباره</b> برای ر�?ع این مشکل انجام دهید.اگر شما می دانید که این خطا از وظای�? و توابع".MAX_PRODUCT_NAME." می باشد شما می توانید بر روی <b>نادیده گر�?تن خطا</b>برای ادامه کلیک نمایید. نادیده گر�?تن این خطاها ممکن است بعدا باعث مشکلات جدی در بانک اطلاعات و نحوه کارکرد سیستم برنامه شود!";
$GLOBALS['strAlreadyInstalled']			= MAX_PRODUCT_NAME." قبلا بر روی این سیستم نصب شده است. اگر می خواهید برنامه را پیکر بندی نمایید بر روی گزینه <a href='settings-index.php'>تنظیمات</a> کلیک نمایید";
$GLOBALS['strCouldNotConnectToDB']		= "قادر به اتصال به بانک اطلاعاتی نیستیم, تنظیماتی را که تعییر کرده اید رادوباره چک نمایید. همچنین مطمئن شوید که بانک اطلاعاتی با این نامی که مشخص کرده اید بر روی سرور شما موحود باشد. ".MAX_PRODUCT_NAME." یک بانک اطلاعاتی را برای شما ایجاد نکرده است, شما باید این بانک اطلاعاتی را قبل از شروع نصب ایجاد نماییید.";
$GLOBALS['strCreateTableTestFailed']		= "کاربری که شما مشخص کرده اید دسترسی کا�?ی برای ایجاد و بروزرسانی بانک اطلاعاتی را ندارد,با مدیریت بانک اطلاعاتی خود تماس بگیرید.";
$GLOBALS['strUpdateTableTestFailed']		= "کاربری که شما مشخص کرده اید دسترسی کا�?ی برای ایجاد و بروزرسانی بانک اطلاعاتی را ندارد,با مدیریت بانک اطلاعاتی خود تماس بگیرید.";
$GLOBALS['strTablePrefixInvalid']		= "پیشوند جدول ها دارای کاراکتر غیر مجاز می باشد";
$GLOBALS['strTableInUse']			= "بانک اطلاعاتی تعیین شده قبلا برای ".MAX_PRODUCT_NAME." ایجاد شده و مورد است�?اده است, لط�?ا یک پیشوند مت�?اوت را برای جدول ها انتخاب نمایید, یا راهنما را برای انجام پردازش های بروزرسانی مطالعه نمایید.";
$GLOBALS['strNoVersionInfo']                = "Unable to select the database version";
$GLOBALS['strInvalidVersionInfo']           = "Unable to determine the database version";
$GLOBALS['strInvalidMySqlVersion']          = "" . MAX_PRODUCT_NAME." requires MySQL 4.0 or higher to function correctly. Please select a different database server.";
$GLOBALS['strTableWrongType']		= "نوع جدول انتخاب شده توسط برنامه نصب کننده ".$phpAds_dbmsname." پشتیبانی نمی شود";
$GLOBALS['strMayNotFunction']			= "قبل از ادامه این مشکل جدی را اصلاح نمایید:";
$GLOBALS['strFixProblemsBefore']		= "قبل از ادامه نصب".MAX_PRODUCT_NAME."باید گزینه های زیر را اصلاح نمایید. اگر شما سوالی در مورد این پیام های خطا دارید, راهنمای مدیریت را که با بسته برنامه دانلود کرده اید را مطالعه �?رمایید.";
$GLOBALS['strFixProblemsAfter']			= "اگر شما قادر به اصلاح خطاهای لیست شده در بالا نیستید, با مدیریت سروری که شما می خواهید برنامه ".MAX_PRODUCT_NAME." را روی آن نصب کنید تماس بگیرید. مدیریت سرور ممکن است که بتواند شما را یاری نماید.";
$GLOBALS['strIgnoreWarnings']			= "نادیده گر�?تن هشدارها";
$GLOBALS['strFixErrorsBeforeContinuing']    = "Please fix all errors before continuing.";
$GLOBALS['strWarningDBavailable']		= "نسخه PHP  سرور شما از بانک اطلاعاتی ".$phpAds_dbmsname." پشتیبانی نمی کند. شما نیاز دارید که PHP ".$phpAds_dbmsname."را برای پردازش های بعدی �?عال نمایید.";
$GLOBALS['strWarningPHPversion']		= MAX_PRODUCT_NAME." نیازمند نسخه PHP 4.0.3 یا بالاتر برای اجرای توابع به صورت صحیح می باشد. شما در حال حاضر است�?اده می کنید از نسخه {php_version}.";
$GLOBALS['strWarningRegisterGlobals']		= "گزینه register_globals در پیکربندی PHP نیاز دارد که بر روی گزینه on تنظیم شود.";
$GLOBALS['strWarningRegisterArgcArv']       = "The PHP configuration variable register_argc_argv needs to be turned on to run maintenance from the command line.";
$GLOBALS['strWarningMagicQuotesGPC']		= "متغیر magic_quotes_gpc در پیکر بندی PHP باید بر روی گزینه on تنظیم شود.";
$GLOBALS['strWarningMagicQuotesRuntime']	= "گزینه magic_quotes_runtime در پیکر بندی PHP نیاز دارد که بر روی گزینه off تنظیم شود.";
$GLOBALS['strWarningFileUploads']		= "متغیر file_uploads در پیکربندیPHP نیاز دارد که بر روی گزینه on تنظیم شود.";
$GLOBALS['strWarningTrackVars']			= "متغیر track_vars در پیکربندیPHP  نیاز دارد که بر روی گزینه on تنظیم شود.";
$GLOBALS['strWarningPREG']				= "نسخه PHP شما برای پشتیبانی از عبارت منطقی PERL همسازی ندارد. شما نیاز به �?عال کردن PREG extension قبل از ادامه پردازش دارید.";
$GLOBALS['strConfigLockedDetected']		= MAX_PRODUCT_NAME." شناسایی کرده که �?ایل <b>config.inc.php</b> برای سرور قابل نوشتن نمی باشد. شما باید سطح دسترسی به این �?ایل را تغییر دهید.اگر منظور این پیام را نمی �?همید راهنما و مستندات برنامه را مطالعه �?رمایید.";
$GLOBALS['strCantUpdateDB']  			= "در حال حاضر امکان بروزرسانی بانک اطلاعاتی وجود ندارد. اگر شما تصمیم جدی به این کار دارید کلیه اطلاعات بانک اطلاعاتی شما از بین خواهد ر�?ت.";
$GLOBALS['strIgnoreErrors']			= "نادیده گر�?تن خطاها";
$GLOBALS['strRetryUpdate']			= "تلاش برای بروزرسانی";
$GLOBALS['strTableNames']			= "نام های جدول";
$GLOBALS['strTablesPrefix']			= "پیشوند نام جدولها";
$GLOBALS['strTablesType']			= "نوع جدول";

$GLOBALS['strInstallWelcome']               = "خوش آمدید به ".MAX_PRODUCT_NAME;
$GLOBALS['strInstallMessage']               = "Before you can use ".MAX_PRODUCT_NAME." it needs to be configured and <br /> the database needs to be created. Click <b>Proceed</b> to continue.";
$GLOBALS['strInstallIntro']                 = "Welcome to <a href='http://".MAX_PRODUCT_URL."' target='_blank'><strong>".MAX_PRODUCT_NAME."</strong></a>! You will soon become part of the web's largest ad-space community.\n<p>We try very hard to make this installation or upgrade process as simple as possible. Please follow the instructions on the screen, and if you need more help, please reference the <a href='http://".MAX_PRODUCT_DOCSURL."' target='_blank'><strong>documentation</strong></a>.</p>\n<p>If you still have questions after reading the documentation, visit the <a href='http://".MAX_PRODUCT_URL."/support/overview.html' target='_blank'><strong>support</strong></a> section of our website and the Openads <a href='http://".MAX_PRODUCT_FORUMURL."' target='_blank'><strong>community forum</strong></a>.</p>\n<p>Thank you for choosing Openads.</p>";
$GLOBALS['strRecoveryRequiredTitle']    = "Your previous upgrade attempt encountered an error";
$GLOBALS['strRecoveryRequired']         = "There was an error while processing your previous upgrade and Openads must attempt to recover the upgrade process. Please click the Recover button below.";
$GLOBALS['strTermsTitle']               = "License information";
$GLOBALS['strTermsIntro']               = "" . MAX_PRODUCT_NAME . " is a free and open source adserver, distributed under the GPL license. Please review this license, and agree to its terms to continue installation.";
$GLOBALS['strPolicyTitle']               = "Privacy and Data Usage Policy";
$GLOBALS['strPolicyIntro']               = "Please review the Privacy and Data Usage Policy before agreeing to continue the installation.";
$GLOBALS['strDbSetupTitle']               = "تنظیمات دیتابیس";
$GLOBALS['strDbSetupIntro']               = "" . MAX_PRODUCT_NAME . " uses a MySQL database to store all of its data.  Please fill in the address of your server, as well as the database name, username and password.  If you do not know which information you should provide here, please contact the administrator of your server.";
$GLOBALS['strDbUpgradeIntro']             = "Below are the detected database details for your installation of " . MAX_PRODUCT_NAME . ". Please check to make sure that these details are correct. When you click continue, " . MAX_PRODUCT_NAME . " will proceed with performing upgrade tasks on your data. Please make sure that you have a proper backup of your data before continuing.";

$GLOBALS['strOaUpToDate']               = "Your Openads database and file structure are both using the most recent version and therefore no upgrade is required at this time. Please click Continue to proceed to the Openads administration panel.";
$GLOBALS['strOaUpToDateCantRemove']     = "Warning: the UPGRADE file is still present inside of your var folder. We are unable to remove this file because of insufficient permissions. Please delete this file yourself.";
$GLOBALS['strRemoveUpgradeFile']               = "You must remove the UPGRADE file from the var folder.";
$GLOBALS['strInstallSuccess']               = "<strong>Congratulations! You have finished installing Openads</strong>\n<p>Welcome to the Openads community! To get the most out of Openads, there are two last steps you should perform.</p>\n\n<p><strong>Maintenance</strong><br>\nOpenads is configured to automatically run some maintenance tasks every hour as long as ads are being served. To speed up ad delivery, you can set this up by automatically calling a maintenance file every hour (e.g a cron job). This is not required, but is highly recommended. For more information about this, please reference the <a href='http://".MAX_PRODUCT_DOCSURL."' target='_blank'><strong>documentation</strong></a>.</p>\n\n<p><strong>Security</strong><br>\nThe Openads installation needs the configuration file to be writable by the server. After making your configuration changes, it is highly recommended to enable read-only access to this file, to provide higher security. For more information, please reference the <a href='http://".MAX_PRODUCT_DOCSURL."' target='_blank'><strong>documentation</strong></a>.</p>\n\n<p>You are now ready to start using Openads. Clicking continue will take you to your newly installed/upgraded version.</p>\n<p>Before you start using Openads we suggest you take some time to review your configuration settings found within the \"Settings\" tab.";
$GLOBALS['strInstallNotSuccessful']         = "<b>The installation of ".MAX_PRODUCT_NAME." was not succesful</b><br /><br />Some portions of the install process could not be completed.\n                                                It is possible these problems are only temporarily, in that case you can simply click <b>Proceed</b> and return to the\n                                                first step of the install process. If you want to know more on what the error message below means, and how to solve it,\n                                                please consult the supplied documentation.";
$GLOBALS['strSystemCheck']                  = "چک کردن سیستم";
$GLOBALS['strSystemCheckIntro']             = "" . MAX_PRODUCT_NAME . " has certain requirements which will now be checked. We will warn you if any settings need to be changed.";
$GLOBALS['strDbSuccessIntro']               = "The " . MAX_PRODUCT_NAME . " database has now been created. Please click the 'Continue' button to proceed with configuring Openads Administrator and Delivery settings.";
$GLOBALS['strDbSuccessIntroUpgrade']        = "The " . MAX_PRODUCT_NAME . " database has now been updated.  Please click the 'Continue' button to proceed with reviewing the " . MAX_PRODUCT_NAME . " Administrator and Delivery settings.";
$GLOBALS['strErrorOccured']                 = "The following error occured:";
$GLOBALS['strErrorInstallDatabase']         = "The database structure could not be created.";
$GLOBALS['strErrorInstallPrefs']            = "The administrator user preferences could not be written to the database.";
$GLOBALS['strErrorInstallVersion']          = "The " . MAX_PRODUCT_NAME . " version number could not be written to the database.";
$GLOBALS['strErrorUpgrade']                 = 'The existing installation\'s database could not be upgraded.';
$GLOBALS['strErrorInstallDbConnect']        = "It was not possible to open a connection to the database.";

$GLOBALS['strErrorWritePermissions']        = "File permission errors have been detected, and must be fixed before you can continue.<br />To fix the errors on a Linux system, try typing in the following command(s):";
$GLOBALS['strErrorFixPermissionsCommand']   = "<i>chmod a+w %s</i>";
$GLOBALS['strErrorFixPermissionsRCommand']  = "<i>chmod -R a+w %s</i>";
$GLOBALS['strErrorWritePermissionsWin']     = "File permission errors have been detected, and must be fixed before you can continue.";
$GLOBALS['strCheckDocumentation']           = "For more help, please see the <a href=\"http://".MAX_PRODUCT_DOCSURL."\">Openads documentation</a>.";

$GLOBALS['strAdminUrlPrefix']               = "آدرس ورود به مدیریت";
$GLOBALS['strDeliveryUrlPrefix']            = "آدرس خروجی";
$GLOBALS['strDeliveryUrlPrefixSSL']         = "آدرس خروجی به صورت (SSL)";
$GLOBALS['strImagesUrlPrefix']              = "آدرس ذخیره سازی عکسها";
$GLOBALS['strImagesUrlPrefixSSL']           = "آدرس عکسها به صورت (SSL)";

$GLOBALS['strInvalidUserPwd']               = "نام کاربری و پسورد اشتباه است";

$GLOBALS['strUpgrade']                      = "به روز رسانی";
$GLOBALS['strSystemUpToDate']               = "Your system is already up to date, no upgrade is needed at the moment. <br />Click on <b>Proceed</b> to go to home page.";
$GLOBALS['strSystemNeedsUpgrade']           = "The database structure and configuration file need to be upgraded in order to function correctly. Click <b>Proceed</b> to start the upgrade process. <br /><br />Depending on which version you are upgrading from and how many statistics are already stored in the database, this process can cause high load on your database server. Please be patient, the upgrade can take up to a couple of minutes.";
$GLOBALS['strSystemUpgradeBusy']            = "System upgrade in progress, please wait...";
$GLOBALS['strSystemRebuildingCache']        = "Rebuilding cache, please wait...";
$GLOBALS['strServiceUnavalable']            = "The service is temporarily unavailable. System upgrade in progress";

/*-------------------------------------------------------*/
/* Configuration translations                            */
/*-------------------------------------------------------*/

// Global
$GLOBALS['strChooseSection']                         = 'انتخاب بخش';
$GLOBALS['strEditConfigNotPossible']   		= "امکان ویرایش تنظیمات وجود ندارد زیرا �?ایل پیکریندی به دلایل امنیتی ق�?ل شده است. \nاگر مایل به ایجاد تغییرات هستید باید �?ایل config.inc.php را ازحالت ق�?ل درآورید.\n";
$GLOBALS['strEditConfigPossible']		= "ممکن است که تمام تنظیمات پیکر بندی ویرایش شود.زیرا �?ایل پیکربندی ق�?ل نشده است.و این می تواند باعث ایجاد سوراخ امنیتی برای هکران شود. \nاگر مایلید که انتیت سیستم بالا برود باید �?ایل config.inc.php را ق�?ل کنید.\n";
$GLOBALS['strUnableToWriteConfig']                   = 'Unable to write changes to the config file';
$GLOBALS['strUnableToWritePrefs']                    = 'Unable to commit preferences to the database';
$GLOBALS['strImageDirLockedDetected']	             = "The supplied <b>Images Folder</b> is not writeable by the server. <br>You can't proceed until you either change permissions of the folder or create the folder.";

// Configuration Settings
$GLOBALS['strConfigurationSetup']                    = 'نصب پیکربندی';
$GLOBALS['strConfigurationSettings']                    = 'تنظیمات پیکربندی';

// Administrator Settings
$GLOBALS['strAdministratorSettings']                 = 'تنظیمات مدیریت';
$GLOBALS['strAdministratorAccount']                  = 'اکانت مدیریت';
$GLOBALS['strLoginCredentials']                      = 'اطلاعات ورود';
$GLOBALS['strAdminUsername']                         = 'نام کاربری مدیریت';
$GLOBALS['strAdminPassword']                         = 'پسورد مدیریت';
$GLOBALS['strInvalidUsername']                       = 'نام کاربری اشتباه است';
$GLOBALS['strBasicInformation']                      = 'اطلاعات اصلی';
$GLOBALS['strAdminFullName']                         = 'نام کامل مدیر';
$GLOBALS['strAdminEmail']                            = 'آدرس ایمیل مدیران';
$GLOBALS['strAdministratorEmail']                            = 'آدرس ایمیل مدیریت';
$GLOBALS['strCompanyName']                           = 'نام کمپانی';
$GLOBALS['strAdminCheckUpdates']                     = 'چک برای به روزرسانی';
$GLOBALS['strAdminCheckEveryLogin']                  = 'ورود  همه';
$GLOBALS['strAdminCheckDaily']                       = 'روزانه';
$GLOBALS['strAdminCheckWeekly']                      = 'ه�?تگی';
$GLOBALS['strAdminCheckMonthly']                     = 'ماهیانه';
$GLOBALS['strAdminCheckNever']                       = 'همیشه';
$GLOBALS['strAdminNovice']                           = 'مدیران نیاز هست که تایید کنند';
$GLOBALS['strUserlogEmail']                          = 'همه خروجی پیامهای ایمیل';
$GLOBALS['strEnableDashboard']                       = "�?عال بودن داشبورد";
$GLOBALS['strTimezoneInformation']                   = "اطلاعات زمان منطقه ای";
$GLOBALS['strTimezone']                              = "ساعت";
$GLOBALS['strTimezoneEstimated']                     = "قیمت ساعتی";
$GLOBALS['strTimezoneGuessedValue']                  = "Server timezone not correctly set in PHP";
$GLOBALS['strTimezoneSeeDocs']                       = "Please see the %DOCS% about setting this variable for PHP.";
$GLOBALS['strTimezoneDocumentation']                 = "مدارک";
$GLOBALS['strLoginSettingsTitle']                    = "ورود مدیریت";
$GLOBALS['strLoginSettingsIntro']                    = "In order to continue with the upgrade process, please enter your " . MAX_PRODUCT_NAME . " administrator user login details.  You must login as the admnistrator user to continue with the upgrade process.";
$GLOBALS['strAdminSettingsTitle']                    = "اکانت مدیریت شما";
$GLOBALS['strAdminSettingsIntro']                    = "The administrator account is used to login to the " . MAX_PRODUCT_NAME . " interface and manage inventory, view statistics, and create tags. Please fill in the username, password, and email address of the administrator.";
$GLOBALS['strConfigSettingsIntro']                    = "Please review the following configuration settings. It is very important that you carefully review these settings as they are vital to the performance and usage of " . MAX_PRODUCT_NAME;

$GLOBALS['strEnableAutoMaintenance']	             = "نگهداری به صورت اتوماتیک تا زمان تحویل ";

// Openads ID Settings
$GLOBALS['strOpenadsUsername']                       = "" . MAX_PRODUCT_NAME . " نام کاربری";
$GLOBALS['strOpenadsPassword']                       = "" . MAX_PRODUCT_NAME . " پسورد";
$GLOBALS['strOpenadsEmail']                          = "" . MAX_PRODUCT_NAME . "ایمیل";

// Banner Settings
$GLOBALS['strBannerSettings']                        = 'تنظیمات بنر';
$GLOBALS['strDefaultBanners']                        = 'بنرهای پیش �?رض';
$GLOBALS['strDefaultBannerUrl']                      = 'آدرس عکس پیش �?رض';
$GLOBALS['strDefaultBannerDestination']              = 'آدرس مقصد پیش �?رض';
$GLOBALS['strAllowedBannerTypes']                    = 'تایید انواع بنر';
$GLOBALS['strTypeSqlAllow']                          = 'تایید بنرهای لوکال اس کیو ال';
$GLOBALS['strTypeWebAllow']                          = 'مجاز بودن بنرهای وب سرور';
$GLOBALS['strTypeUrlAllow']                          = 'مجاز بودن بنرهای خارجی';
$GLOBALS['strTypeHtmlAllow']                         = 'مجاز بودن است�?اده از  در بنرها';
$GLOBALS['strTypeTxtAllow']                          = 'تایید تبلیغات متنی';
$GLOBALS['strTypeHtmlSettings']                      = 'انتخاب بنر HTML';
$GLOBALS['strTypeHtmlAuto']                          = 'در ادامه به صورت اتوماتیک کدهای اچ تی ام ال را تغییر بدهد';
$GLOBALS['strTypeHtmlPhp']                           = 'Allow PHP expressions to be executed from within a HTML banner';

// Database Settings
$GLOBALS['strDatabaseSettings']                      = 'تنظیمت دیتابیس';
$GLOBALS['strDatabaseServer']                        = 'تنظیمات کلی سرور دیتابیس';
$GLOBALS['strDbLocal']                               = 'متصل شدن به لوکال سرور'; // Pg only
$GLOBALS['strDbType']                                = 'نوع دیتابیس';
$GLOBALS['strDbHost']                                = 'نام هاست دیتابیس';
$GLOBALS['strDbPort']                                = 'پرت دیتابیس';
$GLOBALS['strDbUser']                                = 'نام کاربری دیتابیس';
$GLOBALS['strDbPassword']                            = 'پسورد دیتابیس';
$GLOBALS['strDbName']                                = 'نام دیتابیس';
$GLOBALS['strDatabaseOptimalisations']               = 'تنظیمات آپشنهای کلی دیتابیس';
$GLOBALS['strPersistentConnections']                 = 'نسبت مانده مصر�?';
$GLOBALS['strCantConnectToDb']                       = 'Can\'t Connect to Database';
$GLOBALS['strDemoDataInstall']                       = 'نصب اطلاعات پیش �?رض';
$GLOBALS['strDemoDataIntro']                         = 'Default setup data can be loaded into ' . MAX_PRODUCT_NAME . ' to help you get started serving online advertising. The most common banner types, as well as some initial campaigns can be loaded and pre-configured. This is highly recommended for new installations.';

// Debug Logging Settings
$GLOBALS['strDebugSettings']                         = 'ر�?ع اشکال ورود';
$GLOBALS['strDebug']                                 = 'تنظیمات کلی ر�?ع اشکال';
$GLOBALS['strProduction']                            = 'خرورجی سرور';
$GLOBALS['strEnableDebug']                           = '�?عال بودن ر�?ع اشکال';
$GLOBALS['strDebugMethodNames']                      = 'همراه بودن نام مشکل و دلیل آن';
$GLOBALS['strDebugLineNumbers']                      = 'همراه بودن شماره خط ارور';
$GLOBALS['strDebugType']                             = 'نوع اشکال زدا';
$GLOBALS['strDebugTypeFile']                         = '�?ایل';
$GLOBALS['strDebugTypeMcal']                         = 'mCal';
$GLOBALS['strDebugTypeSql']                          = 'دیتا بیس اس کیو ال';
$GLOBALS['strDebugTypeSyslog']                       = 'سیستم ورود';
$GLOBALS['strDebugName']                             = 'نام و تاریخ ارور در جدول دیتابیس با نام';
$GLOBALS['strDebugPriority']                         = 'انتخاب مرحله اول ر�?ع مشکل';
$GLOBALS['strPEAR_LOG_DEBUG']                        = 'PEAR_LOG_DEBUG - Most Information';
$GLOBALS['strPEAR_LOG_INFO']                         = 'PEAR_LOG_INFO - Default Information';
$GLOBALS['strPEAR_LOG_NOTICE']                       = 'PEAR_LOG_NOTICE';
$GLOBALS['strPEAR_LOG_WARNING']                      = 'PEAR_LOG_WARNING';
$GLOBALS['strPEAR_LOG_ERR']                          = 'PEAR_LOG_ERR';
$GLOBALS['strPEAR_LOG_CRIT']                         = 'PEAR_LOG_CRIT';
$GLOBALS['strPEAR_LOG_ALERT']                        = 'PEAR_LOG_ALERT';
$GLOBALS['strPEAR_LOG_EMERG']                        = 'PEAR_LOG_EMERG - Least Information';
$GLOBALS['strDebugIdent']                            = 'شناسایی ریشه مشکل';
$GLOBALS['strDebugUsername']                         = 'نام کاربری سرور اس کیو ال و سی پنل';
$GLOBALS['strDebugPassword']                         = 'پسورد سرور اس کیو ال و سی پنل';

// Delivery Settings
$GLOBALS['strDeliverySettings']                      = 'تنظیمات خروجی';
$GLOBALS['strWebPath']                               = 'دسترسی آدرس های سرور';
$GLOBALS['strWebPathSimple']                         = 'آدرس وب';
$GLOBALS['strDeliveryPath']                          = 'آدرس خروجی';
$GLOBALS['strImagePath']                             = 'آدرس عکسها';
$GLOBALS['strDeliverySslPath']                       = 'Delivery SSL path';
$GLOBALS['strImageSslPath']                          = 'Images SSL path';
$GLOBALS['strImageStore']                            = '�?ولدر عکسها';
$GLOBALS['strTypeWebSettings']                       = 'تنظیمات کلی بنرهای در لوکال سرور';
$GLOBALS['strTypeWebMode']                           = 'روش ذخیره سازی';
$GLOBALS['strTypeWebModeLocal']                      = 'لوکال دایرکتوری';
$GLOBALS['strTypeDirError']                          = 'The local directory cannot be written to by the web server';
$GLOBALS['strTypeWebModeFtp']                        = 'External FTP Server';
$GLOBALS['strTypeWebDir']                            = 'لوکال دایرکتوری';
$GLOBALS['strTypeFTPHost']                           = 'ا�? ت پی هاست';
$GLOBALS['strTypeFTPDirectory']                      = 'هاست دایرکتوری';
$GLOBALS['strTypeFTPUsername']                       = 'ورود به سیستم';
$GLOBALS['strTypeFTPPassword']                       = 'رمز ';
$GLOBALS['strTypeFTPPassive']                        = 'است�?اده ا�? تی پی غیر�?عال';
$GLOBALS['strTypeFTPErrorDir']                       = 'The FTP Host Directory does not exist';
$GLOBALS['strTypeFTPErrorConnect']                   = 'Could not connect to the FTP Server, the Login or Password is not correct';
$GLOBALS['strTypeFTPErrorHost']                      = 'The FTP Host is not correct';
$GLOBALS['strDeliveryFilenames']                     = 'کل نامهای �?ایل خروجی';
$GLOBALS['strDeliveryFilenamesAdClick']              = 'کلیکها';
$GLOBALS['strDeliveryFilenamesAdConversionVars']     = 'تغییر و متغییرها';
$GLOBALS['strDeliveryFilenamesAdContent']            = 'گنجایش ( مثدار )';
$GLOBALS['strDeliveryFilenamesAdConversion']         = 'تبدیلات';
$GLOBALS['strDeliveryFilenamesAdConversionJS']       = 'تغییر (JavaScript)';
$GLOBALS['strDeliveryFilenamesAdFrame']              = '�?ریم';
$GLOBALS['strDeliveryFilenamesAdImage']              = 'عکس';
$GLOBALS['strDeliveryFilenamesAdJS']                 = 'جاوا اسکریپت';
$GLOBALS['strDeliveryFilenamesAdLayer']              = 'لایه';
$GLOBALS['strDeliveryFilenamesAdLog']                = 'گزارش روزانه';
$GLOBALS['strDeliveryFilenamesAdPopup']              = 'پاپ آپ';
$GLOBALS['strDeliveryFilenamesAdView']               = 'نمایش';
$GLOBALS['strDeliveryFilenamesXMLRPC']               = 'خروجی XML';
$GLOBALS['strDeliveryFilenamesLocal']                = 'خروجی لوکال';
$GLOBALS['strDeliveryFilenamesFrontController']      = 'جلو کنترل کننده';
$GLOBALS['strDeliveryFilenamesFlash']                = 'همراه �?لش';
$GLOBALS['strDeliveryCaching']                       = 'تنظیمات کلی خروجی';
$GLOBALS['strDeliveryCacheEnable']                   = 'Enable Delivery Caching';
$GLOBALS['strDeliveryCacheType']                     = 'Delivery Cache Type';
$GLOBALS['strCacheFiles']                            = '�?ایل';
$GLOBALS['strCacheDatabase']                         = 'دیتابیس';
$GLOBALS['strDeliveryCacheLimit']                    = 'زمان بین به روز رسانی (ثانیه)';

$GLOBALS['strOrigin']                                = 'است�?اده جزیی مبدا سرور';
$GLOBALS['strOriginType']                            = 'نوع اصلی سرور';
$GLOBALS['strOriginHost']                            = 'نام هاست برای سرور اصلی';
$GLOBALS['strOriginPort']                            = 'شماره پرت برای دیتابیس اصلی';
$GLOBALS['strOriginScript']                          = '�?ایل اسکریپت برای دیتابیس اصلی';
$GLOBALS['strOriginTypeXMLRPC']                      = 'XMLRPC';
$GLOBALS['strOriginTimeout']                         = 'زمان باقیمانده ( ثانیه )';
$GLOBALS['strOriginProtocol']                        = 'قاعده سرور اصلی';

$GLOBALS['strDeliveryBanner']                        = 'تنظیمات کلی خروجی بنرها';
$GLOBALS['strDeliveryAcls']                          = 'تعیین کردن با محدودیت خروجی برای بنرها';
$GLOBALS['strDeliveryObfuscate']                     = 'مبهم بودن خط مشی در هنگام خروجی تبلیغ';
$GLOBALS['strDeliveryExecPhp']                       = 'مجاز بودن است�?اده از کدهای پی اچ پی در آگهی ( از نظر امنیتی مشکل دارد )';
$GLOBALS['strDeliveryCtDelimiter']                   = 'پیگیری �?رد کلیک کننده';
$GLOBALS['strP3PSettings']                           = 'کنترل کلی به صورت مخ�?یانه';
$GLOBALS['strUseP3P']                                = 'کنترل مخ�?یانه';
$GLOBALS['strP3PCompactPolicy']                      = 'کنترل به صورت �?شرده';
$GLOBALS['strP3PPolicyLocation']                     = 'موقعیت کنترل';

// General Settings
$GLOBALS['generalSettings']                          = 'کل تنظیمات عمومی سیستم';
$GLOBALS['uiEnabled']                                = '�?عال بودن کاربر';
$GLOBALS['defaultLanguage']                          = 'زبان پیش �?رض سیستم';
$GLOBALS['requireSSL']                               = 'کاربر مجاز به است�?اده از SSL می باشد';
$GLOBALS['sslPort']                                  = 'پرت SSL توسط وب سرور';

// Geotargeting Settings
$GLOBALS['strGeotargetingSettings']                  = 'تنظیمات آی اس پی';
$GLOBALS['strGeotargeting']                          = 'تنظیمات کلی آی اس پی';
$GLOBALS['strGeotargetingType']                      = 'نوع نمونه آی اس پی';
$GLOBALS['strGeotargetingGeoipCountryLocation']      = 'آخرین آی پی دیتابیس';
$GLOBALS['strGeotargetingGeoipRegionLocation']       = 'MaxMind GeoIP Region Database Location';
$GLOBALS['strGeotargetingGeoipCityLocation']         = 'MaxMind GeoIP City Database Location';
$GLOBALS['strGeotargetingGeoipAreaLocation']         = 'MaxMind GeoIP Area Database Location';
$GLOBALS['strGeotargetingGeoipDmaLocation']          = 'MaxMind GeoIP DMA Database Location';
$GLOBALS['strGeotargetingGeoipOrgLocation']          = 'MaxMind GeoIP Organisation Database Location';
$GLOBALS['strGeotargetingGeoipIspLocation']          = 'MaxMind GeoIP ISP Database Location';
$GLOBALS['strGeotargetingGeoipNetspeedLocation']     = 'MaxMind GeoIP Netspeed Database Location';
$GLOBALS['strGeoShowUnavailable']                    = 'Show geotargeting delivery limitations even if GeoIP data unavailable';
$GLOBALS['strGeotrackingGeoipCountryLocationError']  = 'The MaxMind GeoIP Country Database does not exist in the location specified';
$GLOBALS['strGeotrackingGeoipRegionLocationError']   = 'The MaxMind GeoIP Region Database does not exist in the location specified';
$GLOBALS['strGeotrackingGeoipCityLocationError']     = 'The MaxMind GeoIP City Database does not exist in the location specified';
$GLOBALS['strGeotrackingGeoipAreaLocationError']     = 'The MaxMind GeoIP Area Database does not exist in the location specified';
$GLOBALS['strGeotrackingGeoipDmaLocationError']      = 'The MaxMind GeoIP DMA Database does not exist in the location specified';
$GLOBALS['strGeotrackingGeoipOrgLocationError']      = 'The MaxMind GeoIP Organisation Database does not exist in the location specified';
$GLOBALS['strGeotrackingGeoipIspLocationError']      = 'The MaxMind GeoIP ISP Database does not exist in the location specified';
$GLOBALS['strGeotrackingGeoipNetspeedLocationError'] = 'The MaxMind GeoIP Netspeed Database does not exist in the location specified';

// Interface Settings
$GLOBALS['strInterfaceDefaults']                     = 'میانجی پیش �?رض';
$GLOBALS['strInventory']                             = 'صورت موجودی';
$GLOBALS['strUploadConversions']                     = 'Upload Conversions';
$GLOBALS['strShowCampaignInfo']                      = 'Show extra campaign info on <i>Campaign overview</i> page';
$GLOBALS['strShowBannerInfo']                        = 'Show extra banner info on <i>Banner overview</i> page';
$GLOBALS['strShowCampaignPreview']                   = 'Show preview of all banners on <i>Banner overview</i> page';
$GLOBALS['strShowBannerHTML']                        = 'Show actual banner instead of plain HTML code for HTML banner preview';
$GLOBALS['strShowBannerPreview']                     = 'Show banner preview at the top of pages which deal with banners';
$GLOBALS['strHideInactive']                          = 'Hide inactive items from all overview pages';
$GLOBALS['strGUIShowMatchingBanners']                = 'Show matching banners on the <i>Linked banner</i> pages';
$GLOBALS['strGUIShowParentCampaigns']                = 'Show parent campaigns on the <i>Linked banner</i> pages';
$GLOBALS['strGUIAnonymousCampaignsByDefault']        = 'Default Campaigns to Anonymous';
$GLOBALS['strStatisticsDefaults']                    = 'آمار';
$GLOBALS['strBeginOfWeek']                           = 'آغاز ه�?ته';
$GLOBALS['strPercentageDecimals']                    = 'درصد اعشار';
$GLOBALS['strWeightDefaults']                        = 'وزن پیش �?رض';
$GLOBALS['strDefaultBannerWeight']                   = 'حجم پیش �?رض بنر';
$GLOBALS['strDefaultCampaignWeight']                 = 'حجم پیش �?رض داخلی';
$GLOBALS['strDefaultBannerWErr']                     = 'Default banner weight should be a positive integer';
$GLOBALS['strDefaultCampaignWErr']                   = 'Default campaign weight should be a positive integer';

$GLOBALS['strPublisherDefaults']                     = 'ناشر پیش �?رض';
$GLOBALS['strModesOfPayment']                        = 'نحوه پرداخت وجه';
$GLOBALS['strCurrencies']                            = 'پول رایج';
$GLOBALS['strCategories']                            = 'مجموعه ها';
$GLOBALS['strHelpFiles']                             = '�?ایل راهنما';
$GLOBALS['strHasTaxID']                              = 'Tax ID';
$GLOBALS['strDefaultApproved']                       = 'چک کردن بسته تایید شده ها';

// CSV Import Settings
$GLOBALS['strChooseAdvertiser']                      = 'Choose Advertiser';
$GLOBALS['strChooseCampaign']                        = 'Choose Campaign';
$GLOBALS['strChooseCampaignBanner']                  = 'Choose Banner';
$GLOBALS['strChooseTracker']                         = 'Choose Tracker';
$GLOBALS['strDefaultConversionStatus']               = 'عملکرد تغییرات پیش �?رض';
$GLOBALS['strDefaultConversionType']                 = 'عملکرد تغییرات پیش �?رض';
$GLOBALS['strCSVTemplateSettings']                   = 'CSV Template Settings';
$GLOBALS['strIncludeCountryInfo']                    = 'Include Country Info';
$GLOBALS['strIncludeBrowserInfo']                    = 'Include Browser Info';
$GLOBALS['strIncludeOSInfo']                         = 'Include OS Info';
$GLOBALS['strIncludeSampleRow']                      = 'Include Sample Row';
$GLOBALS['strCSVTemplateAdvanced']                   = 'Advanced Template';
$GLOBALS['strCSVTemplateIncVariables']               = 'Include Tracker Variables';

// Invocation Settings
$GLOBALS['strInvocationAndDelivery']                 = 'تنظیمات مجوزهای خروجی';
$GLOBALS['strAllowedInvocationTypes']                = 'انواع مجوز خروجی';
$GLOBALS['strIncovationDefaults']                    = 'خروجی پیش �?رض';
$GLOBALS['strEnable3rdPartyTrackingByDefault']       = '�?عال شدن 3ار دی در قبال هر کلیک به صورت پیش �?رض';

// Statistics & Maintenance Settings
$GLOBALS['strStatisticsSettings']                    = 'تنظیمات نگهداری و آمار';
$GLOBALS['strStatisticsLogging']                     = 'کلیه تنظیمات و آمار ورودی ها';
$GLOBALS['strCsvImport']                             = 'Allow upload of offline conversions';
$GLOBALS['strLogAdRequests']                         = 'ورود آگهی دهنده همیشه در صورت درخواست';
$GLOBALS['strLogAdImpressions']                      = 'ورود آگهی دهنده همیشه در صورت نمایش آثار';
$GLOBALS['strLogAdClicks']                           = 'ورود آگهی دهنده همیشه بعد از کلیک و نمایش کلیک';
$GLOBALS['strLogTrackerImpressions']                 = 'ورود تراکر در صورت نمایش یک اثر برای همیشه';
$GLOBALS['strReverseLookup']                         = 'Reverse lookup the hostnames of viewers when not supplied';
$GLOBALS['strProxyLookup']                           = 'Try to determine the real IP address of viewers behind a proxy server';
$GLOBALS['strPreventLogging']                        = 'Global Prevent Statistics Logging Settings';
$GLOBALS['strIgnoreHosts']                           = 'Don\'t store statistics for viewers using one of the following IP addresses or hostnames';
$GLOBALS['strBlockAdViews']                          = 'Don\'t log an Ad Impression if the viewer has seen the same ad within the specified time (seconds)';
$GLOBALS['strBlockAdViewsError']                     = 'Ad Impression block value must be a non-negative integer';
$GLOBALS['strBlockAdClicks']                         = 'Don\'t log an Ad Click if the viewer has clicked on the same ad within the specified time (seconds)';
$GLOBALS['strBlockAdClicksError']                    = 'Ad Click block value must be a non-negative integer';
$GLOBALS['strBlockAdConversions']                    = 'Don\'t log a Tracker Impression if the viewer has seen the page with the tracker beacon within the specified time (seconds)';
$GLOBALS['strBlockAdConversionsError']               = 'Tracker Impression block value must be a non-negative integer';
$GLOBALS['strMaintenaceSettings']                    = 'Global Maintenance Settings';
$GLOBALS['strMaintenanceAdServerInstalled']          = 'Process Statistics for AdServer Module';
$GLOBALS['strMaintenanceTrackerInstalled']           = 'Process Statistics for Tracker Module';
$GLOBALS['strMaintenanceOI']                         = 'Maintenance Operation Interval (minutes)';
$GLOBALS['strMaintenanceOIError']                    = 'The Maintenace Operation Interval is not valid - see documentation for valid values';
$GLOBALS['strMaintenanceCompactStats']               = 'Delete raw statistics after processing?';
$GLOBALS['strMaintenanceCompactStatsGrace']          = 'Grace period before deleting processed statistics (seconds)';
$GLOBALS['strPrioritySettings']                      = 'Global Priority Settings';
$GLOBALS['strPriorityInstantUpdate']                 = 'Update advertisement priorities immediately when changes made in the UI';
$GLOBALS['strWarnCompactStatsGrace']                 = 'The Compact Stats Grace period must be a positive integer';
$GLOBALS['strDefaultImpConWindow']                   = 'Default Ad Impression Connection Window (seconds)';
$GLOBALS['strDefaultImpConWindowError']              = 'If set, the Default Ad Impression Connection Window must be a positive integer';
$GLOBALS['strDefaultCliConWindow']                   = 'Default Ad Click Connection Window (seconds)';
$GLOBALS['strDefaultCliConWindowError']              = 'If set, the Default Ad Click Connection Window must be a positive integer';
$GLOBALS['strEmailWarnings']                         = 'E-mail Warnings';
$GLOBALS['strAdminEmailHeaders']                     = 'Add the following headers to each e-mail message sent by ' . MAX_PRODUCT_NAME;
$GLOBALS['strWarnLimit']                             = 'Send a warning when the number of impressions left are less than specified here';
$GLOBALS['strWarnLimitErr']                          = 'Warn Limit must be a positive integer';
$GLOBALS['strWarnLimitDays']                         = 'Send a warning when the days left are less than specified here';
$GLOBALS['strWarnLimitDaysErr']                      = 'Warn Limit Days should be a positive number';
$GLOBALS['strAllowEmail']                            = 'Globally allow sending of e-mails';
$GLOBALS['strEmailAddress']                          = 'E-mail address to send reports FROM';
$GLOBALS['strEmailAddressName']                      = 'Company or personal name to sign off e-mail with';
$GLOBALS['strWarnAdmin']                             = 'Send a warning to the administrator every time a campaign is almost expired';
$GLOBALS['strWarnClient']                            = 'Send a warning to the advertiser every time a campaign is almost expired';
$GLOBALS['strWarnAgency']                            = 'Send a warning to the agency every time a campaign is almost expired';
$GLOBALS['strQmailPatch']                            = 'Enable qmail patch';

// UI Settings
$GLOBALS['strGuiSettings']                           = 'تنظیمات بین کاربر';
$GLOBALS['strGeneralSettings']                       = 'تنظیمات عمومی';
$GLOBALS['strAppName']                               = 'نام درخواست کننده';
$GLOBALS['strMyHeader']                              = 'مکان �?ایل هدر';
$GLOBALS['strMyHeaderError']                         = 'The header file does not exist in the location you specified';
$GLOBALS['strMyFooter']                              = 'مکان �?ایل �?وتر';
$GLOBALS['strMyFooterError']                         = 'The footer file does not exist in the location you specified';
$GLOBALS['strDefaultTrackerStatus']                  = 'وضعیت پیش �?رض تراکر';
$GLOBALS['strDefaultTrackerType']                    = 'نوع پیش �?رض تراکر';

$GLOBALS['strMyLogo']                                = 'نام مبدا �?ایل لوگو';
$GLOBALS['strMyLogoError']                           = 'The logo file does not exist in the admin/images directory';
$GLOBALS['strGuiHeaderForegroundColor']              = 'رنگ جلو هدر';
$GLOBALS['strGuiHeaderBackgroundColor']              = 'رنگ بکگراند هدر';
$GLOBALS['strGuiActiveTabColor']                     = 'رنگ تب �?عال';
$GLOBALS['strGuiHeaderTextColor']                    = 'رنگ متن هدر';
$GLOBALS['strColorError']                            = 'Please enter colors in an RGB format, like \'0066CC\'';

$GLOBALS['strGzipContentCompression']                = 'است�?اده از زیپ کردن برای �?شرده سازی';
$GLOBALS['strClientInterface']                       = 'Advertiser Interface';
$GLOBALS['strReportsInterface']                      = 'Reports Interface';
$GLOBALS['strClientWelcomeEnabled']                  = 'Enable Advertiser Welcome Message';
$GLOBALS['strClientWelcomeText']                     = 'Welcome Text<br />(HTML Tags Allowed)';

$GLOBALS['strPublisherInterface']                    = 'Publisher interface';
$GLOBALS['strPublisherAgreementEnabled']             = 'Enable login control for publishers who haven\'t accepted Terms and Conditions';
$GLOBALS['strPublisherAgreementText']                = 'Login text (HTML tags allowed)';


/*-------------------------------------------------------*/
/* Unknown (unused?) translations                        */
/*-------------------------------------------------------*/

$GLOBALS['strExperimental']                 = "Experimental";
$GLOBALS['strKeywordRetrieval']             = "Keyword retrieval";
$GLOBALS['strBannerRetrieval']              = "Banner retrieval method";
$GLOBALS['strRetrieveRandom']               = "Random banner retrieval (default)";
$GLOBALS['strRetrieveNormalSeq']            = "Normal sequental banner retrieval";
$GLOBALS['strWeightSeq']                    = "Weight based sequential banner retrieval";
$GLOBALS['strFullSeq']                      = "Full sequential banner retrieval";
$GLOBALS['strUseKeywords']                  = "Use keywords to select banners";
$GLOBALS['strUseConditionalKeys']           = "Allow logical operators when using direct selection";
$GLOBALS['strUseMultipleKeys']              = "Allow multiple keywords when using direct selection";

$GLOBALS['strTableBorderColor']             = "Table Border Color";
$GLOBALS['strTableBackColor']               = "Table Back Color";
$GLOBALS['strTableBackColorAlt']            = "Table Back Color (Alternative)";
$GLOBALS['strMainBackColor']                = "Main Back Color";
$GLOBALS['strOverrideGD']                   = "Override GD Imageformat";
$GLOBALS['strTimeZone']                     = "Time Zone";



// Note: New translations not found in original lang files but found in CSV
$GLOBALS['strEmailSettings'] = "تنظیمات اصلی";
?>