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
$GLOBALS['strChooseSection'] = "Choose section";
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
$GLOBALS['strRecalculatePriority'] = "Recalculate priority";

// Banner cache
$GLOBALS['strCheckBannerCache'] = "Check banner cache";
$GLOBALS['strBannerCacheErrorsFound'] = "The database banner cache check has found some errors. These banners will not work until you manually fix them.";
$GLOBALS['strBannerCacheOK'] = "There were no errors detected. Your database banner cache is up to date";
$GLOBALS['strBannerCacheDifferencesFound'] = "The database banner cache check has found that your cache is not up to date and requires rebuilding. Click here to automatically  update your cache.";
$GLOBALS['strBannerCacheRebuildButton'] = "Rebuild";
$GLOBALS['strRebuildDeliveryCache'] = "Rebuild database banner cache";
$GLOBALS['strBannerCacheExplaination'] = "    The database banner cache is used to speed up delivery of banners during delivery<br />
    This cache needs to be updated when:
    <ul>
        <li>You upgrade your version of {$PRODUCT_NAME}</li>
        <li>You move your {$PRODUCT_NAME} installation to a different server</li>
    </ul>";

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

$GLOBALS['strUpdateServerDown'] = "Due to an unknown reason it isn't possible to retrieve <br>information about possible updates. Please try again later.";

$GLOBALS['strNoNewVersionAvailable'] = "	Your version of {$PRODUCT_NAME} is up-to-date. There are currently no updates available.";

$GLOBALS['strServerCommunicationError'] = "    <b>Communication with the update server timed out, so {$PRODUCT_NAME} is not
    able to check if a newer version is available at this stage. Please try again later.</b>";

$GLOBALS['strCheckForUpdatesDisabled'] = "    <b>Check for updates is disabled. Please enable via the
    <a href='account-settings-update.php'>update settings</a> screen.</b>";

$GLOBALS['strNewVersionAvailable'] = "	<b>A new version of {$PRODUCT_NAME} is available.</b><br /> It is recommended to install this update,
	because it may fix some currently existing problems and will add new features. For more information
	about upgrading please read the documentation which is included in the files below.</b>";

$GLOBALS['strSecurityUpdate'] = "	<b>It is highly recommended to install this update as soon as possible, because it contains a number
	of security fixes.</b> The version of {$PRODUCT_NAME} which you are currently using might
	be vulnerable to certain attacks and is probably not secure. For more information
	about upgrading please read the documentation which is included in the files below.</b>";

$GLOBALS['strNotAbleToCheck'] = "	<b>Because the XML extention isn't available on your server, {$PRODUCT_NAME} is not
    able to check if a newer version is available.</b>";

$GLOBALS['strForUpdatesLookOnWebsite'] = "	If you want to know if there is a newer version available, please take a look at our website.";

$GLOBALS['strClickToVisitWebsite'] = "Click here to visit our website";
$GLOBALS['strCurrentlyUsing'] = "You are currently using";
$GLOBALS['strRunningOn'] = "running on";
$GLOBALS['strAndPlain'] = "and";

//  Deliver Limitations
$GLOBALS['strDeliveryLimitations'] = "Delivery Limitations";
$GLOBALS['strAllBannerChannelCompiled'] = "All banner/channel compiled limitation values have been recompiled";
$GLOBALS['strBannerChannelResult'] = "Here are the results of the banner/channel compiled limitation validation";
$GLOBALS['strChannelCompiledLimitationsValid'] = "All channel compiled limitations are valid";
$GLOBALS['strBannerCompiledLimitationsValid'] = "All banner compiled limitations are valid";
$GLOBALS['strErrorsFound'] = "Errors found";
$GLOBALS['strRepairCompiledLimitations'] = "Some inconsistancies were found above, you can repair these using the button below, this will recompile the compiled limitation for every banner/channel in the system<br />";
$GLOBALS['strRecompile'] = "Recompile";
$GLOBALS['strDeliveryEngineDisagreeNotice'] = "Under some circumstances the delivery engine can disagree with the stored ACLs for banners and channels, use the folowing link to validate the ACLs in the database";
$GLOBALS['strCheckACLs'] = "Check ACLs";

//  Append codes
$GLOBALS['strAppendCodesDesc'] = "Under some circumstances the delivery engine can disagree with the stored append codes for trackers, use the folowing link to validate the append codes in the database";
$GLOBALS['strCheckAppendCodes'] = "Check Append codes";
$GLOBALS['strAppendCodesRecompiled'] = "All compiled append codes values have been recompiled";
$GLOBALS['strAppendCodesResult'] = "Here are the results of the compiled append codes validation";
$GLOBALS['strAppendCodesValid'] = "All tracker compiled appendcodes are valid";
$GLOBALS['strRepairAppenedCodes'] = "Some inconsistancies were found above, you can repair these using the button below, this will recompile the append codes for every tracker in the system";

$GLOBALS['strPlugins'] = "Plugins";
$GLOBALS['strPluginsPrecis'] = "Diagnose and repair problems with {$PRODUCT_NAME} plugins";

$GLOBALS['strMenus'] = "Menus";
$GLOBALS['strMenusPrecis'] = "Rebuild the menu cache";
$GLOBALS['strMenusCachedOk'] = "Menu cache has been rebuilt";
