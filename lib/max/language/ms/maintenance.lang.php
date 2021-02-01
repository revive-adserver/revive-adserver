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
$GLOBALS['strChooseSection'] = "Pilih bahagian";
$GLOBALS['strAppendCodes'] = "Append codes";

// Maintenance
$GLOBALS['strScheduledMaintenanceHasntRun'] = "<b>Scheduled maintenance hasn't run in the past hour. This may mean that you have not set it up correctly.</b>";

$GLOBALS['strAutoMantenaceEnabledAndHasntRun'] = "	Automatic maintenance is enabled, but it has not been triggered. Automatic maintenance is triggered only when {$PRODUCT_NAME} delivers banners.
    For the best performance, you should set up <a href='{$PRODUCT_DOCSURL}/admin/maintenance' target='_blank'>scheduled maintenance</a>.";

$GLOBALS['strAutoMantenaceDisabledAndHasntRun'] = "	Automatic maintenance is currently disabled, so when {$PRODUCT_NAME} delivers banners, automatic maintenance will not be triggered.
	For the best performance, you should set up <a href='{$PRODUCT_DOCSURL}/admin/maintenance' target='_blank'>scheduled maintenance</a>.
    However, if you are not going to set up <a href='{$PRODUCT_DOCSURL}/admin/maintenance' target='_blank'>scheduled maintenance</a>,
    then you <i>must</i> <a href='account-settings-maintenance.php'>enable automatic maintenance</a> to ensure that {$PRODUCT_NAME} works correctly.";

$GLOBALS['strAutoMantenaceEnabledAndRunning'] = "	Automatic maintenance is enabled and will be triggered, as required, when {$PRODUCT_NAME} delivers banners.
	However, for the best performance, you should set up <a href='{$PRODUCT_DOCSURL}/admin/maintenance' target='_blank'>scheduled maintenance</a>.";

$GLOBALS['strAutoMantenaceDisabledAndRunning'] = "	However, automatic maintenance has recently been disabled. To ensure that {$PRODUCT_NAME} works correctly, you should
	either set up <a href='{$PRODUCT_DOCSURL}/admin/maintenance' target='_blank'>scheduled maintenance</a> or
	<a href='account-settings-maintenance.php'>re-enable automatic maintenance</a>.
	<br><br>
	For the best performance, you should set up <a href='{$PRODUCT_DOCSURL}/admin/maintenance' target='_blank'>scheduled maintenance</a>.";

$GLOBALS['strScheduledMantenaceRunning'] = "<b>Scheduled maintenance is running correctly.</b>";

$GLOBALS['strAutomaticMaintenanceHasRun'] = "<b>Automatic maintenance is running correctly.</b>";

$GLOBALS['strAutoMantenaceEnabled'] = "However, automatic maintenance is still enabled. For the best performance, you should <a href='account-settings-maintenance.php'>disable automatic maintenance</a>.";

// Priority
$GLOBALS['strRecalculatePriority'] = "Kira semula prioriti";

// Banner cache
$GLOBALS['strCheckBannerCache'] = "Periksa semula banner cache";
$GLOBALS['strBannerCacheErrorsFound'] = "Pemeriksaan kepada pengkalan data \"banner cache\" mendapati terdapat beberapa kesilapan. Banner-banner ini tidak akan berfungsi dengan sempurna sehingga anda memperbetulkannya secara manual.";
$GLOBALS['strBannerCacheOK'] = "Tiada kesilapan dijumpai. Pengkalan data \"banner cache\" anda adalah yang terkini";
$GLOBALS['strBannerCacheDifferencesFound'] = "Pemeriksaan terhadap pengkalan data \"banner cache\" mendapati yang \"cache\" anda tidak dikemaskini dan memerlukan penyusunan semula. Klik disini untuk secara automatik memperbaharui \"cache\" anda.";
$GLOBALS['strBannerCacheRebuildButton'] = "Bina semula";
$GLOBALS['strRebuildDeliveryCache'] = "Bina semula pengkalan data \"banner cache\"";
$GLOBALS['strBannerCacheExplaination'] = "Pengkalan data \"banner cache\" digunakan untuk mempercepatkan penyampaian banner semasa penghantaran<br />";

// Cache
$GLOBALS['strCache'] = "Delivery cache";
$GLOBALS['strDeliveryCacheSharedMem'] = "	Shared memory is currently being used for storing the delivery cache.";
$GLOBALS['strDeliveryCacheDatabase'] = "	The database is currently being used for storing the delivery cache.";
$GLOBALS['strDeliveryCacheFiles'] = "	The delivery cache is currently being stored into multiple files on your server.";

// Storage
$GLOBALS['strStorage'] = "Storage";
$GLOBALS['strMoveToDirectory'] = "Move images stored inside the database to a directory";
$GLOBALS['strStorageExplaination'] = "	The images used by local banners are stored inside the database or stored in a directory. If you store the images inside
	a directory the load on the database will be reduced and this will lead to an increase in speed.";

// Encoding
$GLOBALS['strEncoding'] = "Encoding";
$GLOBALS['strEncodingExplaination'] = "{$PRODUCT_NAME} now stores all data in the database in UTF-8 format.<br />
    Where possible, your data will have been automatically converted to this encoding.<br />
    If after upgrading you find corrupt characters, and you know the encoding used, you may use this tool to convert the data from that format to UTF-8";
$GLOBALS['strEncodingConvertFrom'] = "Convert from this encoding:";
$GLOBALS['strEncodingConvertTest'] = "Test conversion";
$GLOBALS['strConvertThese'] = "The following data will be changed if you continue";

// Product Updates
$GLOBALS['strSearchingUpdates'] = "Looking for updates. Please wait...";
$GLOBALS['strAvailableUpdates'] = "Available updates";
$GLOBALS['strDownloadZip'] = "Download (.zip)";
$GLOBALS['strDownloadGZip'] = "Download (.tar.gz)";

$GLOBALS['strUpdateAlert'] = "A new version of {$PRODUCT_NAME} is available.                 \\n\\nDo you want to get more information \\nabout this update?";
$GLOBALS['strUpdateAlertSecurity'] = "A new version of {$PRODUCT_NAME} is available.                 \\n\\nIt is highly recommended to upgrade \\nas soon as possible, because this \\nversion contains one or more security fixes.";

$GLOBALS['strUpdateServerDown'] = "Diatas sebab-sebab yang tidak diketahui, maklumat tentang<br>versi baru tidak dapat dicapai. Sila cuba lagi kemudian.";

$GLOBALS['strNoNewVersionAvailable'] = "	 Versi anda untuk {$PRODUCT_NAME} adalah terkini. Tiada versi baru yang terdapat kini.";

$GLOBALS['strServerCommunicationError'] = "    <b>Communication with the update server timed out, so {$PRODUCT_NAME} is not
    able to check if a newer version is available at this stage. Please try again later.</b>";

$GLOBALS['strCheckForUpdatesDisabled'] = "    <b>Check for updates is disabled. Please enable via the
    <a href='account-settings-update.php'>update settings</a> screen.</b>";

$GLOBALS['strNewVersionAvailable'] = "	<b>Versi baru untuk {$PRODUCT_NAME} telah dikeluarkan.</b><br /> Adalah digalakkan untuk memperbaharui sistem anda menggunakan versi baru ini,
	berkemungkinan ini akan memperbaiki masalah yang terdapat kini dan juga menambahkan ciri-ciri baru. Maklumat lanjut
	tentang proses pembaharuan, sila baca dokumen yang terdapa bersama fail-fail dibawah.";

$GLOBALS['strSecurityUpdate'] = "	<b>It is highly recommended to install this update as soon as possible, because it contains a number
	of security fixes.</b> The version of {$PRODUCT_NAME} which you are currently using might
	be vulnerable to certain attacks and is probably not secure. For more information
	about upgrading please read the documentation which is included in the files below.</b>";

$GLOBALS['strNotAbleToCheck'] = "	<b>Because the XML extention isn't available on your server, {$PRODUCT_NAME} is not
    able to check if a newer version is available.</b>";

$GLOBALS['strForUpdatesLookOnWebsite'] = "	Jika anda mahu memeriksa jika terdapat versi baru, sila lawat laman web kami.";

$GLOBALS['strClickToVisitWebsite'] = "Klik disini untuk melawat laman web kami";
$GLOBALS['strCurrentlyUsing'] = "Anda sedang menggunakan";
$GLOBALS['strRunningOn'] = "menggunakan";
$GLOBALS['strAndPlain'] = "dan";

//  Deliver Limitations
$GLOBALS['strDeliveryLimitations'] = "Delivery Rules";
$GLOBALS['strAllBannerChannelCompiled'] = "All banner/delivery rule set compiled delivery rule values have been recompiled";
$GLOBALS['strBannerChannelResult'] = "Here are the results of the banner/delivery rule set compiled delivery rule validation";
$GLOBALS['strChannelCompiledLimitationsValid'] = "All compiled delivery rules for delivery rule sets are valid";
$GLOBALS['strBannerCompiledLimitationsValid'] = "All compiled delivery rules for banners are valid";
$GLOBALS['strErrorsFound'] = "Errors found";
$GLOBALS['strRepairCompiledLimitations'] = "Some inconsistencies were found above, you can repair these using the button below, this will recompile the compiled limitation for every banner/delivery rule set in the system<br />";
$GLOBALS['strRecompile'] = "Recompile";
$GLOBALS['strDeliveryEngineDisagreeNotice'] = "Under some circumstances the delivery engine can disagree with the stored delivery rules for banners and delivery rule sets, use the folowing link to validate the delivery rules in the database";
$GLOBALS['strCheckACLs'] = "Check delivery rules";

//  Append codes
$GLOBALS['strAppendCodesDesc'] = "Under some circumstances the delivery engine can disagree with the stored append codes for trackers, use the folowing link to validate the append codes in the database";
$GLOBALS['strCheckAppendCodes'] = "Check Append codes";
$GLOBALS['strAppendCodesRecompiled'] = "All compiled append codes values have been recompiled";
$GLOBALS['strAppendCodesResult'] = "Here are the results of the compiled append codes validation";
$GLOBALS['strAppendCodesValid'] = "All tracker compiled appendcodes are valid";
$GLOBALS['strRepairAppenedCodes'] = "Some inconsistencies were found above, you can repair these using the button below, this will recompile the append codes for every tracker in the system";

$GLOBALS['strPlugins'] = "Plugins";
$GLOBALS['strPluginsPrecis'] = "Diagnose and repair problems with {$PRODUCT_NAME} plugins";

$GLOBALS['strMenus'] = "Menus";
$GLOBALS['strMenusPrecis'] = "Rebuild the menu cache";
$GLOBALS['strMenusCachedOk'] = "Menu cache has been rebuilt";
