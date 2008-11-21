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
 * A file for holding the "maintenance" English translation information.
 *
 * @package    MaxUI
 * @subpackage Languages
 */

// Main strings
$GLOBALS['strChooseSection']			= "انتخاب بخش";


// Priority
$GLOBALS['strRecalculatePriority']		= "محاسبه مجدد اولو&#1740;ت";
$GLOBALS['strHighPriorityCampaigns']		= "بااولو&#1740;ت تر&#1740;ن  campaigns";
$GLOBALS['strAdViewsAssigned']			= "مشاهدات تع&#1740;&#1740;ن شده";
$GLOBALS['strLowPriorityCampaigns']		= "پا&#1740;&#1740;ن تر&#1740;ن اولو&#1740;ت campaigns";
$GLOBALS['strPredictedAdViews']			= "مشاهدات پ&#1740;ش ب&#1740;ن&#1740; شده";
$GLOBALS['strPriorityDaysRunning']		= "در حا حاضر {days} روز دارا&#1740; ارزش آمار&#1740; برا&#1740;  ".$phpAds_productname." م&#1740; باشد که پ&#1740;ش ب&#1740;ن&#1740; روزانه م&#1740; تواند مبتن&#1740; بر آن م&#1740; باشد. ";
$GLOBALS['strPriorityBasedLastWeek']		= "ا&#1740;ن پ&#1740;ش ب&#1740;ن&#1740; مبتن&#1740; بر اطلاعات ا&#1740;ن هفته و هفته گذشته م&#1740; باشد. ";
$GLOBALS['strPriorityBasedLastDays']		= "ا&#1740;ن پ&#1740;ش ب&#1740;ن&#1740; م&#1740;تن&#1740; بر اطلاعات جفت&#1740; دو روز گذشته م&#1740; باشد. ";
$GLOBALS['strPriorityBasedYesterday']		= "ا&#1740;ن پ&#1740;ش ب&#1740;ن&#1740; مبتن&#1740; بر اطلاعات روز گذشته م&#1740; باشد. ";
$GLOBALS['strPriorityNoData']			= "There isn't enough data available to make a reliable prediction about the number of impressions this adserver will generate today. Priority assignments will be based on real time statistics only. ";
$GLOBALS['strPriorityEnoughAdViews']		= "There should be enough AdViews to fully satisfy the target all high priority campaigns. ";
$GLOBALS['strPriorityNotEnoughAdViews']		= "It isn't clear wether there will be enough AdViews served today to satisfy the target all high priority campaigns. ";


// Banner cache
$GLOBALS['strCheckBannerCache']		= "Check banner cache";
$GLOBALS['strRebuildBannerCache']		= "ساختن مجدد cache بنر";
$GLOBALS['strBannerCacheErrorsFound'] = "The database banner cache check has found some errors. These banners will not work until you manually fix them.";
$GLOBALS['strBannerCacheOK'] = "There were no errors detected. Your database banner cache is up to date";
$GLOBALS['strBannerCacheDifferencesFound'] = "The database banner cache check has found that your cache is not up to date and requires rebuilding. Click here to automatically  update your cache.";
$GLOBALS['strBannerCacheFixed'] = "The database banner cache rebuild was successfully completed. Your database cache is now up to date.";
$GLOBALS['strBannerCacheRebuildButton'] = "Rebuild";
$GLOBALS['strRebuildDeliveryCache']			= "Rebuild database banner cache";
$GLOBALS['strBannerCacheExplaination']		= "\n    The database banner cache is used to speed up delivery of banners during delivery<br />\n    This cache needs to be updated when:\n    <ul>\n        <li>You upgrade your version of Openads</li>\n        <li>You move your openads installation to a different server</li>\n    </ul>\n";

// Cache
$GLOBALS['strCache']			= "Delivery cache";
$GLOBALS['strAge']				= "Age";
$GLOBALS['strDeliveryCacheSharedMem']		= "\nحافظه تقسیم شده در حال حاضر برای تحویل cache استفاده می شود.\n\n";
$GLOBALS['strDeliveryCacheDatabase']		= "\nبانک اطلاعای در حال حاضر در حال استفاده تحیل cache می باشد.\n\n";
$GLOBALS['strDeliveryCacheFiles']		= "\ncache تحویل در حال حاضر درون فایل های چندگانه بر روی سرور شما ذخیره شده است.\n\n";


// Storage
$GLOBALS['strStorage']				= "ذخیره سازی";
$GLOBALS['strMoveToDirectory']			= "انتقال تصاویر ذخیره شده درون بانک اطلاعای بهیک دایرکتوری";
$GLOBALS['strStorageExplaination']		= "\n	The images used by local banners are stored inside the database or stored in a directory. If you store the images inside\n	a directory the load on the database will be reduced and this will lead to an increase in speed.\n";


// Storage
$GLOBALS['strStatisticsExplaination']		= "\n	You have enabled the <i>compact statistics</i>, but your old statistics are still in verbose format.\n	Do you want to convert your verbose statistics to the new compact format?\n";


// Product Updates
$GLOBALS['strSearchingUpdates']			= "جستجو برای بروزرسانی. منتظر بمانید....";
$GLOBALS['strAvailableUpdates']			= "به روزرسانی های در دسترس";
$GLOBALS['strDownloadZip']			= "دانلود (.zip)";
$GLOBALS['strDownloadGZip']			= "دانلود (.tar.gz)";

$GLOBALS['strUpdateAlert']			= "یک نسخه جدید از  موجود می باشد.                 \n\nآیا میخواهید اطلاعات یشتری در مورد این نسخه کسب نمایید؟ \nabout this update?";
$GLOBALS['strUpdateAlertSecurity']		= "یک نسخه جدید از  موجود می باشد.                 \.";

$GLOBALS['strUpdateServerDown']			= "\nبه دلیل یک مشکل ناسناخته امکان بازیابی وجود ندارد. <br>\nاطلاعات در باره بروزرسای هی ممکن.لطفا دوباره تلاش نمید.\n\n";
$GLOBALS['strNoNewVersionAvailable']		= "\nنسخه ".$phpAds_productname." به روز رسانی شد. درحال حاضر هیچ گونه بروزرسانی موجود نمی باشد.\n\n";

$GLOBALS['strNewVersionAvailable']		= "\n	<b>A new version of ".MAX_PRODUCT_NAME." is available.</b><br /> It is recommended to install this update,\n	because it may fix some currently existing problems and will add new features. For more information\n	about upgrading please read the documentation which is included in the files below.\n";

$GLOBALS['strSecurityUpdate']			= "\n	<b>It is highly recommended to install this update as soon as possible, because it contains a number\n	of security fixes.</b> The version of ".MAX_PRODUCT_NAME." which you are currently using might\n	be vulnerable to certain attacks and is probably not secure. For more information\n	about upgrading please read the documentation which is included in the files below.\n";

$GLOBALS['strNotAbleToCheck']			= "\n	<b>Because the XML extention isn't available on your server, ".MAX_PRODUCT_NAME." is not\n    able to check if a newer version is available.</b>\n";

$GLOBALS['strForUpdatesLookOnWebsite']	= "\n	If you want to know if there is a newer version available, please take a look at our website.\n";

$GLOBALS['strClickToVisitWebsite']		= "برای دیدن وب سایت ما اینجا کلیک نمایید";
$GLOBALS['strCurrentlyUsing'] 			= "شما در حال استفاده هستید.";
$GLOBALS['strRunningOn']				= "اجرا روی";
$GLOBALS['strAndPlain']					= "و";


// Stats conversion
$GLOBALS['strConverting']			= "برگرداندن";
$GLOBALS['strConvertingStats']			= "درحال برگرداندن آمار ...";
$GLOBALS['strConvertStats']			= "برگرداندن آمار";
$GLOBALS['strConvertAdViews']			= "مشاهدات برگردانده شد...";
$GLOBALS['strConvertAdClicks']			= "کل&#1740;ک ها برگردانده شد ...";
$GLOBALS['strConvertAdConversions']			= "AdConversions converted...";
$GLOBALS['strConvertNothing']			= "چ&#1740;ز&#1740; برا&#1740; برگرداندن ن&#1740;ست...";
$GLOBALS['strConvertFinished']			= "پا&#1740;ان &#1740;افت ...";

$GLOBALS['strConvertExplaination']		= "\n	You are currently using the compact format to store your statistics, but there are <br />\n	still some statistics in verbose format. As long as the verbose statistics aren't  <br />\n	converted to compact format they will not be used while viewing these pages.  <br />\n	Before converting your statistics, make a backup of the database!  <br />\n	Do you want to convert your verbose statistics to the new compact format? <br />\n";

$GLOBALS['strConvertingExplaination']		= "\n	All remaining verbose statistics are now being converted to the compact format. <br />\n	Depending on how many impressions are stored in verbose format this may take a  <br />\n	couple of minutes. Please wait until the conversion is finished before you visit other <br />\n	pages. Below you will see a log of all modification made to the database. <br />\n";

$GLOBALS['strConvertFinishedExplaination']  	= "\n	The conversion of the remaining verbose statistics was succesful and the data <br />\n	should now be usable again. Below you will see a log of all modification made <br />\n	to the database.<br />\n";



// Note: New translations not found in original lang files but found in CSV
$GLOBALS['strEncodingConvert'] = "تبدیل";
?>