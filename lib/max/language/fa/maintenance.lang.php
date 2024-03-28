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

// Main strings
$GLOBALS['strChooseSection'] = "قسمتی را انتخاب کنید ";
$GLOBALS['strAppendCodes'] = "کد های اضافه ... ";

// Maintenance
$GLOBALS['strScheduledMaintenanceHasntRun'] = "<b>تعمیر و نگهداری برنامه ریزی شده در ساعت گذشته اجرا نشده است این به این معناست که شما آن را بدرستی تنظیم نکرده اید .</b>";

$GLOBALS['strAutoMantenaceEnabledAndHasntRun'] = "	تعمیر و نگهداری خودکار فعال است، اما آن را ایجاد نکرده است تعمیر و نگهداری خودکار ایجاد می شود که تنها زمانی که {$PRODUCT_NAME} آگهی ارایه شده باشد .
    برای بهرین اجرا شما باید  <a href='{$PRODUCT_DOCSURL}/admin/maintenance' target='_blank'>تعمیر و نگهداری خودکار را </a> نصب کنید .";

$GLOBALS['strAutoMantenaceDisabledAndHasntRun'] = "	
تعمیر و نگهداری خودکار حال حاضر غیرفعال است, 
بنابراین، هنگامی که {$PRODUCT_NAME} آگهی دریافت کرد , 
تعمیر و نگهداری خودکار شروع نخواهد شد.
	
برای بهترین عملکرد, شما باید راه اندازی <a href='{$PRODUCT_DOCSURL}/admin/maintenance' target='_blank'>
تعمیر و نگهداری برنامه ریزی شده</a>.
    
با این حال، اگر شما در حال رفتن به راه اندازی نباشید<a href='{$PRODUCT_DOCSURL}/admin/maintenance' target='_blank'>
تعمیر و نگهداری برنامه ریزی شده</a>,
    شما <i>باید</i> <a href='account-settings-maintenance.php'>تعمیر و نگهداری خودکار را فعال کنید</a> 
تا اطمینان حاصل شود که {$PRODUCT_NAME} درست کار می کند.";

$GLOBALS['strAutoMantenaceEnabledAndRunning'] = "	تعمیر و نگهداری خودکار فعال شده و فعال نخواهد شد, 
در صورت لزوم, 
وقتی {$PRODUCT_NAME} آگهی دریافت کرد .
	
با این حال، برای بهترین عملکرد، شما باید راه اندازی کنید <a href='{$PRODUCT_DOCSURL}/admin/maintenance' target='_blank'>
تعمیر و نگهداری برنامه ریزی شده را</a>.";

$GLOBALS['strAutoMantenaceDisabledAndRunning'] = "	با این حال, 
تعمیر و نگهداری خودکار اخیرا غیر فعال شده است. 
برای اطمینان از اینکه {$PRODUCT_NAME} درستی کار می کند، 
شما باید
  هم تنظیم کنید<a href='{$PRODUCT_DOCSURL}/admin/maintenance' target='_blank'>
تعمیر و نگهداری برنامه ریزی شده را</a> یا
	<a href='account-settings-maintenance.php'>rدوباره فعال کردن تعمیر و نگهداری خودکار </a>.
	<br><br>
	
برای بهترین عملکرد، شما باید راه اندازی کنید <a href='{$PRODUCT_DOCSURL}/admin/maintenance' target='_blank'>تعمیر و نگهداری برنامه ریزی شده را</a>.";

$GLOBALS['strScheduledMantenaceRunning'] = "<b>تعمیر و نگهداری برنامه ریزی شده به درستی در حال اجرا است .</b>";

$GLOBALS['strAutomaticMaintenanceHasRun'] = "<b>
تعمیر و نگهداری خودکار به درستی در حال اجرا است ی.</b>";

$GLOBALS['strAutoMantenaceEnabled'] = "
با این حال، تعمیر و نگهداری خودکار هنوز فعال است. برای بهترین عملکرد، باید <a href='account-settings-maintenance.php'> تعمیر و نگهداری خودکار را غیر فعال کنید</a>.";

// Priority
$GLOBALS['strRecalculatePriority'] = "اولوبت محاسبه";

// Banner cache
$GLOBALS['strCheckBannerCache'] = "بررسی کش بنر";
$GLOBALS['strBannerCacheErrorsFound'] = "بررسی کش پایگاه داده تبلیغات چند خطا را پیدا کرده است  . این آگهی ها کار نخواهد کرد تا زمانی که شما به صورت دستی آنها را تعمیر کنید.";
$GLOBALS['strBannerCacheOK'] = "هیچ خطاهای شناسایی نشده است. کش پایگاه داده تبلیغاتی شما به رئز است ";
$GLOBALS['strBannerCacheDifferencesFound'] = "بررسی کش پایگاه داده بنر نشان داده است که کش شما به به روز نیست و نیاز به بازسازی دارد .برای به روز رسانی خودکار کش تان این ججا را کلیک کنید ";
$GLOBALS['strBannerCacheRebuildButton'] = "بازسازی";
$GLOBALS['strRebuildDeliveryCache'] = "بازسازی کش پایگاه داده تبلیغاتی";
$GLOBALS['strBannerCacheExplaination'] = "   کش پابگاه داده تبلیغاتی برای سرعت بخشیدن به دریافت تبلیغات در هنگام دریافت استفاده می شود <br />
    
این کش باید به روز شود زمانی که:
    <ul>
        <li>شما نسخه {$PRODUCT_NAME} خود را ارتقا داده باشید </li>
        <li>شما {$PRODUCT_NAME}  نصب و راه اندازی خود را  به سرور های مختلف حرکت داده اید </li>
    </ul>";

// Cache
$GLOBALS['strCache'] = "کش دریافتی ";
$GLOBALS['strDeliveryCacheSharedMem'] = "	حافظه مشترک در حال حاضر برای ذخیره سازی کش تحویل استفاده می شود.";
$GLOBALS['strDeliveryCacheDatabase'] = "	پایگاه داده در حال حاضر برای ذخیره سازی کش تحویل استفاده می شود.";
$GLOBALS['strDeliveryCacheFiles'] = "	کش تحویل در حال حاضر به چند فایل بر روی سرور شما ذخیره می شود.";

// Storage
$GLOBALS['strStorage'] = "
ذخیره سازی";
$GLOBALS['strMoveToDirectory'] = "نتقال تصاویر ذخیره شده در داخل پایگاه داده به یک دایرکتوری";
$GLOBALS['strStorageExplaination'] = "	تصاویر مورد استفاده توسط آگهی ها محلی در داخل پایگاه داده ذخیره شده و یا ذخیره شده در یک دایرکتوری. 
اگر شما در تصاویر را ذخیره داخل
یک دایرکتوری بار بر روی پایگاه داده کاهش خواهد یافت و این به افزایش در سرعت منجر شود.";

// Security

// Encoding
$GLOBALS['strEncoding'] = "
رمز گذاری";
$GLOBALS['strEncodingExplaination'] = "{$PRODUCT_NAME}در حال حاضر ذخیره تمام داده ها در پایگاه داده در فرمت UTF-8.<br />
    در صورت امکان، اطلاعات خود را دارند به طور خودکار به این رمزگذاری تبدیل شده است.<br />
   اگر پس از ارتقا به شما پیدا کردن شخصیت های فاسد، و شما می دانید را پشتیبانی می کند استفاده می شود، شما ممکن است این ابزار برای تبدیل داده ها از DAT فرمت به UTF-8 استفاده";
$GLOBALS['strEncodingConvertFrom'] = "
تبدیل از این رمزگذاری:";
$GLOBALS['strEncodingConvertTest'] = "بررسی مکالمات";
$GLOBALS['strConvertThese'] = "
داده های زیر تغییر خواهد کرد اگر ادامه دهید";

// Product Updates
$GLOBALS['strSearchingUpdates'] = "در حال جست و جوی به روز رسانی . اطفا صبر کنید ... ";
$GLOBALS['strAvailableUpdates'] = "به روز رسانی های موجود ";
$GLOBALS['strDownloadZip'] = "دانلود (.zip)";
$GLOBALS['strDownloadGZip'] = "دانلود (.tar.gz)";

$GLOBALS['strUpdateAlert'] = "
نسخه جدید {$PRODUCT_NAME} در دسترس است.

آیا شما می خواهید اطلاعات بیشتری را دریافت کنید
در مورد این به روز رسانی?";
$GLOBALS['strUpdateAlertSecurity'] = "نسخه جدید {$PRODUCT_NAME} در دسترس است.

بسیار توصیه می شود برای ارتقاء \\nدر اسرع وقت,چرا که این
نسخه شامل یک یا چند اصلاحات امنیتی می باشد.";

$GLOBALS['strUpdateServerDown'] = "
به سبب دلیلی نامعلوم ممکن نیست تا بازیابی شود <br>اطلاعات در مورد به روز رسانی های محتمل . اطلاعات در مورد به روز رسانی محتمل. لطفا بعدا دوباره امتحان کنید.";

$GLOBALS['strNoNewVersionAvailable'] = "	نسخه{$PRODUCT_NAME} شما به روز است . 
در حال حاضر هیچ به روز رسانی در دسترس وجود دارد.";

$GLOBALS['strServerCommunicationError'] = "    <b>ارتباط با سرور به روز رسانی به پایان رسیده است, بنابراین {$PRODUCT_NAME}
     قادر به بررسی این نیست که آیا یک نسخه جدیدتر در این مرحله در دسترس است یا خیر. 
لطفا بعدا دوباره امتحان کنید.</b>";

$GLOBALS['strCheckForUpdatesDisabled'] = "    <b>بررسی برای به روز رسانی غیر فعال است . از طریق 
    <a href='account-settings-update.php'>به روز رسانی تنظیمات </a>صفحه .</b> فعال کنید ";

$GLOBALS['strNewVersionAvailable'] = "	<b> {$PRODUCT_NAME}   نسخه ی جدیدی  از آماده است  </b><br /> پیشنهاد می شود که این آپدیت را نصب کنید ,
	
چرا که ممکن است برخی از مشکلات موجود در حال حاضر تعمیر و ویژگی های جدید اضافه کنید. برای اطلاعات بیشتر
در مورد ارتقاء لطفا مستندات است که در فایل های زیر را شامل شده است بخوانید.</b>";

$GLOBALS['strSecurityUpdate'] = "	<b>بسیار توصیه می شود تا این آپدیت را را در اسرع وقت به دلیل رفع بسیاری از مشکلات نصب کنید . </b> نسخه {$PRODUCT_NAME} که شما در حال حاضر استفاده از آن هستید شاید
آسیب پذیر به حملات خاص و احتمالا امن باشد. برای اطلاعات بیشتر در مورد ارتقا مستندات زیر را که در فایل ها آمده هست بخوانید . </b>";

$GLOBALS['strNotAbleToCheck'] = "	<b>از آنجا که پسوند XML در دسترس بر روی سرور شما نیست ، {$PRODUCT_NAME} قابل بررسی شدن نیست اگر نسخه ی جدیدی حاضر باشد .</b>";

$GLOBALS['strForUpdatesLookOnWebsite'] = "
اگر می خواهید بدانید که اگر یک نسخه جدیدتر در دسترس وجود دارد، لطفا نگاهی به وب سایت ما بیندازید.";

$GLOBALS['strClickToVisitWebsite'] = "اینجا را کلیک کنید تا وارد شوید";
$GLOBALS['strCurrentlyUsing'] = "
در حال استفاده";
$GLOBALS['strRunningOn'] = "در حال اجرا";
$GLOBALS['strAndPlain'] = "و";

//  Deliver Limitations
$GLOBALS['strErrorsFound'] = "خطاهایی پیدا شد ";
$GLOBALS['strRepairCompiledLimitations'] = "برخی از تناقضات بالا پیدا شد، شما می توانید این با استفاده از دکمه زیر تعمیر، این محدودیت کامپایلر برای هر بنر / کانال در سیستم کامپایل را<br />";
$GLOBALS['strRecompile'] = "کامپایل مجدد";

//  Append codes
$GLOBALS['strAppendCodesDesc'] = " تحت برخی شرایط موتور تحویل می توانید با کدهای اضافه ذخیره شده برای رهگیری اختلاف نظر دارند، از لینک های زیر استفاده کنید به اعتبار کدهای پیوست در پایگاه داده ";
$GLOBALS['strCheckAppendCodes'] = "کد های اضافه را بررسی کنید";
$GLOBALS['strAppendCodesRecompiled'] = "همه الحاق ارزش کدهای وارد شده اند مجددا کامپایل شدند";
$GLOBALS['strAppendCodesResult'] = "
نتایج حاصل از کامپایل اعتبار سنجی کد اضافه عبارتند از";
$GLOBALS['strAppendCodesValid'] = "تمام کدهای ردیاب کامپایل الحاق معتبر هستند";
$GLOBALS['strRepairAppenedCodes'] = "برخی از تناقضات بالا پیدا شد، شما می توانید تعمیر این با استفاده از دکمه زیر تعمیر کنید ، این کد اضافه برای هر ردیاب در سیستم کامپایل مجدد خوانده می شود . ";

$GLOBALS['strPlugins'] = "افزونه ها";
$GLOBALS['strPluginsPrecis'] = "
تشخیص و تعمیر مشکلات با پلاگین {$PRODUCT_NAME}";

$GLOBALS['strMenus'] = "منوها";
$GLOBALS['strMenusPrecis'] = "بازسازی کش منو";
$GLOBALS['strMenusCachedOk'] = "کش منو بازسازی شده است";

// Users
