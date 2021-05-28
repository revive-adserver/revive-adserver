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

/** status messages * */
$GLOBALS['strInstallStatusRecovery'] = 'بازیابی سرور تبلیغاتی Revive %s';
$GLOBALS['strInstallStatusInstall'] = 'نصب کردن Revive Adserver %s';
$GLOBALS['strInstallStatusUpgrade'] = 'تکامل revive Adserver %s';
$GLOBALS['strInstallStatusUpToDate'] = 'Revive Adserver پیدا شده %s';

/** welcome step * */
$GLOBALS['strWelcomeTitle'] = "خوش آمدید به {$PRODUCT_NAME}";
$GLOBALS['strInstallIntro'] = "با تشکر از انتخاب  {$PRODUCT_NAME}. این جادوگر از طریق نصب فرآیند  {$PRODUCT_NAME} راهنماییتان می کند.";
$GLOBALS['strUpgradeIntro'] = "{$PRODUCT_NAME }ممنون از انتخاب شما برای . این جادوگر از طریق فرآیند ارتقا {$PRODUCT_NAME} کمکتان می کند .";
$GLOBALS['strInstallerHelpIntro'] = "برای کمک در مراحل نصب {$PRODUCT_NAME} لطفا  <a href='{$PRODUCT_DOCSURL}' target='_blank'>اسناد</a> را ببینید.";
$GLOBALS['strTermsIntro'] = "{$PRODUCT_NAME} تحت مجوز منبع باز ، و با مجوز عمومی GNU توزیع شده است . لطفا اسناد زیر را مطالعه و موافقت نمایید تا نصب ادامه پیدا کند ";

/** check step * */
$GLOBALS['strSystemCheck'] = "بررسی سیستم";
$GLOBALS['strSystemCheckIntro'] = "جادوگر نصب شده تنظیمات وب سرور شما را بررسی خواهد کرد تا مطمین شود مراحل نصب به موفقیت کامل می شود . 
                                                  <br>لطفا هر گونه مسائل برجسته برای تکمیل مراحل نصب را بررسی کنید.";
$GLOBALS['strFixErrorsBeforeContinuing'] = "تنظیمات وب سرور شما نیاز های {$PRODUCT_NAME} را برطرف نم کند.
                                                   <br>به منظور ادام نصب و راه اندازی ، لطفا تمامی خطاها را رفع کنید
                                                  برای کمک مراجع کنید به <a href='{$PRODUCT_DOCSURL}'>اسنادn</a> و <a href='http://{$PRODUCT_URL}/faq'>FAQs</a>";

$GLOBALS['strAppCheckErrors'] = "خطا هنگامی تشخیص داده شد که نسخه های قبلی {$PRODUCT_NAME} پیدا شد";
$GLOBALS['strAppCheckDbIntegrityError'] = "ما مسائل صداقت با پایگاه داده خود را کشف کرده اند. این به این معنی که طرح از پایگاه داده خود را
                                                   متفاوت از آنچه که ما انتظار آن را داشتیم. این می تواند به علت سفارشی سازی پایگاه داده خود باشد.";

$GLOBALS['strSyscheckProgressMessage'] = "
بررسی پارامترهای سیستم ...";
$GLOBALS['strError'] = "خطا";
$GLOBALS['strWarning'] = "اخطار";
$GLOBALS['strOK'] = "خب";
$GLOBALS['strSyscheckName'] = "نام را بررسی کنید";
$GLOBALS['strSyscheckValue'] = "ارزش فعلی";
$GLOBALS['strSyscheckStatus'] = "وضعیت";
$GLOBALS['strSyscheckSeeFullReport'] = "اطلاعات دقیق سیستم را نشان بده";
$GLOBALS['strSyscheckSeeShortReport'] = "فقط خطا ها و مشکلات را نشان بده";
$GLOBALS['strBrowserCookies'] = '
کوکی های مرورگر';
$GLOBALS['strPHPConfiguration'] = 'تنظیمات پی اچ پی';
$GLOBALS['strCheckError'] = 'خطا';
$GLOBALS['strCheckErrors'] = 'خطاها';
$GLOBALS['strCheckWarning'] = 'مشکل';
$GLOBALS['strCheckWarnings'] = 'مشکلات';

/** admin login step * */
$GLOBALS['strAdminLoginTitle'] = " خود وارد شوید{$PRODUCT_NAME}  لطفا با نام مدیریتی ";
$GLOBALS['strAdminLoginIntro'] = "
برای ادامه، لطفا {$PRODUCT_NAME} مدیر سیستم اطلاعات ورود به حساب خود را وارد کنید.";
$GLOBALS['strLoginProgressMessage'] = 'در حال وارد شدن...';

/** database step * */
$GLOBALS['strDbSetupTitle'] = "پایگاه داده خود را ارایه دهید";
$GLOBALS['strDbSetupIntro'] = "برای اتصال به پایگاه داده {$PRODUCT_NAME} جزییات را وارد کنید ";
$GLOBALS['strDbUpgradeTitle'] = "پایگاه داده شما شناسایی شد";
$GLOBALS['strDbUpgradeIntro'] = "\" تا ادامه پیدا کند . ";
$GLOBALS['strDbProgressMessageInstall'] = 'در حال نصب پایگاه داده ...';
$GLOBALS['strDbProgressMessageUpgrade'] = 'در حال به روز رسانی پایگاه داده ...';
$GLOBALS['strDbSeeMoreFields'] = 'زمینه های بیشتری در مورد پایگاه داده ببینید ...';
$GLOBALS['strDbTimeZoneNoWarnings'] = "هشدار زمانی را در آینده نشان نده ... ";
$GLOBALS['strDBInstallSuccess'] = "پایگاه داده به طور کامل ساخته شد ";
$GLOBALS['strDBUpgradeSuccess'] = "پایگاه داده کاملا به روز رسانی شد ";

$GLOBALS['strDetectedVersion'] = "نسخه {$PRODUCT_NAME} شناسایی شد ";

/** config step * */
$GLOBALS['strConfigureInstallTitle'] = "حساب مدیریتی سیستم {$PRODUCT_NAME} خود را فعال کنید";
$GLOBALS['strConfigureInstallIntro'] = "لطفا اطلاعات ورود به سیستم خود را برای سیستم مدیریتی محلی {$PRODUCT_NAME}  را وارد کنید .";
$GLOBALS['strConfigureUpgradeTitle'] = "تنظیمات پیکربندی";
$GLOBALS['strConfigureUpgradeIntro'] = "مسیری را برای نصب {$PRODUCT_NAME} قبلی خود ارایه دهید ";
$GLOBALS['strConfigSeeMoreFields'] = "مشاهده تنظیمات پیکر بندی بیشتر ...";
$GLOBALS['strPreviousInstallTitle'] = "نصب های پیشین ...";
$GLOBALS['strPathToPrevious'] = "{$PRODUCT_NAME}مسیر نصب های پیشین ";
$GLOBALS['strPathToPreviousError'] = "یک یا چند فایل پلاگین نمی تواند واقع شود، بررسی کنید فایل install.log برای اطلاعات بیشتر";
$GLOBALS['strConfigureProgressMessage'] = "
پیکربندی {$PRODUCT_NAME} ...";

/** jobs step * */
$GLOBALS['strJobsInstallTitle'] = "
انجام وظایف نصب و راه اندازی";
$GLOBALS['strJobsInstallIntro'] = "نصب کننده در حال نصب آخرین مراحل است";
$GLOBALS['strJobsUpgradeTitle'] = "در حال اجرای مراحل به روز رسانی ";
$GLOBALS['strJobsUpgradeIntro'] = "نصب کننده در آخرین مرحله های نصب است .";
$GLOBALS['strJobsProgressInstallMessage'] = "در حال اجرای مراحل نصب ...";
$GLOBALS['strJobsProgressUpgradeMessage'] = "در حال اجرای آخرین مراحل به روز رسانی ... ";

$GLOBALS['strPluginTaskChecking'] = " {$PRODUCT_NAME}...بررسی کردن پلاگین های ";
$GLOBALS['strPluginTaskInstalling'] = "در حال نصب پلاگین های {$PRODUCT_NAME} ... ";
$GLOBALS['strPostInstallTaskRunning'] = "در حال اجرا کردن وظایف";

/** finish step * */
$GLOBALS['strFinishInstallTitle'] = "نصب {$PRODUCT_NAME}  به پایان رسید .";
$GLOBALS['strFinishUpgradeWithErrorsTitle'] = "ارتقای {$PRODUCT_NAME}  شما کامل شده است . لطفا مسایل برجسته را بررسی کنید ";
$GLOBALS['strFinishUpgradeTitle'] = "ارتقای {$PRODUCT_NAME}  شما کامل شده است ... ";
$GLOBALS['strFinishInstallWithErrorsTitle'] = "نصب {$PRODUCT_NAME}  شما کامل شده است . لطفا مسایل برجسته را بررسی کنید ";
$GLOBALS['strDetailedTaskErrorList'] = "جزییات خخطا ها لیست شد .. ";
$GLOBALS['strPluginInstallFailed'] = "نصب پلاگین های  \"%s\" نا موفق بود :";
$GLOBALS['strTaskInstallFailed'] = "
خطا در هنگام اجرای وظیفه نصب و راه اندازی رخ داده است \"%s\":";
$GLOBALS['strContinueToLogin'] = "برروی  \"Continue\" خود شوید{$PRODUCT_NAME}  کلیک کنید تا وارد حساب کاربری .";

$GLOBALS['strUnableCreateConfFile'] = "
ما قادر به ایجاد فایل پیکربندی شما نیستیم . لطفا دسترسی از {$PRODUCT_NAME} پوشه VAR دوباره چک کنید.";
$GLOBALS['strUnableUpdateConfFile'] = "ما قادر به به روز رسانی فایل پیکربندی شما نیستیم لطفا دوباره بررسی مجوز از {$PRODUCT_NAME} پوشه VARرا دوباره بررسی کنید . ، و همچنین مجوزهای قبلی نصب فایل پیکربندی که شما را به این پوشه کپی کنید.";
$GLOBALS['strUnableToCreateAdmin'] = "ما قادر به ایجاد حساب مدیریتی نیستیم ، آیا پایگاه داده شما در دسترس است ؟";

