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
$GLOBALS['strBannerCacheExplaination']		= "
    The database banner cache is used to speed up delivery of banners during delivery<br />
    This cache needs to be updated when:
    <ul>
        <li>You upgrade your version of Openads</li>
        <li>You move your openads installation to a different server</li>
    </ul>
";

// Cache
$GLOBALS['strCache']			= "Delivery cache";
$GLOBALS['strAge']				= "Age";
$GLOBALS['strDeliveryCacheSharedMem']		= "
	حافظه تقس&#1740;م شده در حال حاضر برا&#1740; تحو&#1740;ل cache استفاده م&#1740; شود.
";
$GLOBALS['strDeliveryCacheDatabase']		= "
	بانک اطلاعات&#1740; در حال حاضر در حال استفاده تحو&#1740;ل cache م&#1740; باشد.
";
$GLOBALS['strDeliveryCacheFiles']		= "
cache تحو&#1740;ل در حال حاضر درون فا&#1740;ل ها&#1740; چندگانه بر رو&#1740; سرور شما ذخ&#1740;ره شده است.
";


// Storage
$GLOBALS['strStorage']				= "ذخ&#1740;ره ساز&#1740;";
$GLOBALS['strMoveToDirectory']			= "انتقال تصاو&#1740;ر ذخ&#1740;ره شده درون بانک اطلاعات&#1740; به &#1740;ک دا&#1740;رکتور&#1740;";
$GLOBALS['strStorageExplaination']		= "
	The images used by local banners are stored inside the database or stored in a directory. If you store the images inside
	a directory the load on the database will be reduced and this will lead to an increase in speed.
";


// Storage
$GLOBALS['strStatisticsExplaination']		= "
	You have enabled the <i>compact statistics</i>, but your old statistics are still in verbose format.
	Do you want to convert your verbose statistics to the new compact format?
";


// Product Updates
$GLOBALS['strSearchingUpdates']			= "جستجو برا&#1740; بروزرسان&#1740;. منتظر بمان&#1740;د....";
$GLOBALS['strAvailableUpdates']			= "به روزرسان&#1740; ها&#1740; در دسترس";
$GLOBALS['strDownloadZip']			= "دانلود (.zip)";
$GLOBALS['strDownloadGZip']			= "دانلود (.tar.gz)";

$GLOBALS['strUpdateAlert']			= "&#1740;ک نسخه جد&#1740;د از ".$phpAds_productname." موجود م&#1740; باشد.                 \\n\\nآ&#1740;ا م&#1740;خواه&#1740;د اطلاعات ب&#1740;شتر&#1740; در مورد ا&#1740;ن نسخه کسب نما&#1740;&#1740;د؟ \\nabout this update?";
$GLOBALS['strUpdateAlertSecurity']		= "&#1740;ک نسخه جد&#1740;د از ".$phpAds_productname." موجود م&#1740; باشد.                 \\n\\nIt is highly recommended to upgrade \\nas soon as possible, because this \\nversion contains one or more security fixes.";

$GLOBALS['strUpdateServerDown']			= "
    به دل&#1740;ل &#1740;ک مشکل ناسناخته امکان باز&#1740;اب&#1740; وجود ندارد. <br>
اطلاعات در باره بروزرسان&#1740; ها&#1740; ممکن.لطفا دوباره تلاش نما&#1740;&#1740;د.
";
$GLOBALS['strNoNewVersionAvailable']		= "
	نسخه ".$phpAds_productname." به روز رسان&#1740; شد. درحال حاضر ه&#1740;چ گونه بروزرسان&#1740; موجود نم&#1740; باشد.
";

$GLOBALS['strNewVersionAvailable']		= "
	<b>A new version of ".MAX_PRODUCT_NAME." is available.</b><br /> It is recommended to install this update,
	because it may fix some currently existing problems and will add new features. For more information
	about upgrading please read the documentation which is included in the files below.
";

$GLOBALS['strSecurityUpdate']			= "
	<b>It is highly recommended to install this update as soon as possible, because it contains a number
	of security fixes.</b> The version of ".MAX_PRODUCT_NAME." which you are currently using might
	be vulnerable to certain attacks and is probably not secure. For more information
	about upgrading please read the documentation which is included in the files below.
";

$GLOBALS['strNotAbleToCheck']			= "
	<b>Because the XML extention isn't available on your server, ".MAX_PRODUCT_NAME." is not
    able to check if a newer version is available.</b>
";

$GLOBALS['strForUpdatesLookOnWebsite']	= "
	If you want to know if there is a newer version available, please take a look at our website.
";

$GLOBALS['strClickToVisitWebsite']		= "برا&#1740; د&#1740;دن وب سا&#1740;ت ما ا&#1740;نجا کل&#1740;ک نما&#1740;&#1740;د";
$GLOBALS['strCurrentlyUsing'] 			= "شما در حال استفاده هست&#1740;د.";
$GLOBALS['strRunningOn']				= "اجرا رو&#1740;";
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

$GLOBALS['strConvertExplaination']		= "
	You are currently using the compact format to store your statistics, but there are <br />
	still some statistics in verbose format. As long as the verbose statistics aren't  <br />
	converted to compact format they will not be used while viewing these pages.  <br />
	Before converting your statistics, make a backup of the database!  <br />
	Do you want to convert your verbose statistics to the new compact format? <br />
";

$GLOBALS['strConvertingExplaination']		= "
	All remaining verbose statistics are now being converted to the compact format. <br />
	Depending on how many impressions are stored in verbose format this may take a  <br />
	couple of minutes. Please wait until the conversion is finished before you visit other <br />
	pages. Below you will see a log of all modification made to the database. <br />
";

$GLOBALS['strConvertFinishedExplaination']  	= "
	The conversion of the remaining verbose statistics was succesful and the data <br />
	should now be usable again. Below you will see a log of all modification made <br />
	to the database.<br />
";

?>