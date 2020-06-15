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
$GLOBALS['strChooseSection'] = "בחר מחלקה";
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
$GLOBALS['strRecalculatePriority'] = "שקלל קדימויות";

// Banner cache
$GLOBALS['strCheckBannerCache'] = "Check banner cache";
$GLOBALS['strBannerCacheErrorsFound'] = "The database banner cache check has found some errors. These banners will not work until you manually fix them.";
$GLOBALS['strBannerCacheOK'] = "There were no errors detected. Your database banner cache is up to date";
$GLOBALS['strBannerCacheDifferencesFound'] = "The database banner cache check has found that your cache is not up to date and requires rebuilding. Click here to automatically  update your cache.";
$GLOBALS['strBannerCacheRebuildButton'] = "Rebuild";
$GLOBALS['strRebuildDeliveryCache'] = "רענן זיכרון-מטמון תפוצה";
$GLOBALS['strBannerCacheExplaination'] = "זיכרון-מטמון של הב�?נרי�? מכיל כעת העתק של קוד HTML  המשמש לתצוגה של הב�?נר. על ידי שימוש בזיכרון זה ניתן לה�?יץ �?ת ההפצה של הב�?נרי�? כי קוד ה-HTML ל�? דורש הפקה מחודשת בכל פע�? שב�?נר צריך להיחשף.<br /> מכיוון שזיכרון הב�?נר כולל קוד מוטבע של ה-URLs למיקו�? ה-{$PRODUCT_NAME} והב�?נרי�? שלו, הזיכרון צריך להתעדכן בכל פע�? שה-{$PRODUCT_NAME} מועבר למיקו�? �?חר על השרת. ";

// Cache
$GLOBALS['strCache'] = "זיכרון-מטמון תפוצה";
$GLOBALS['strDeliveryCacheSharedMem'] = "נעשה כעת שימוש בזכרון משותף	ל�?יחסון זכרון מטמון (cache).";
$GLOBALS['strDeliveryCacheDatabase'] = "	בסיס הנתוני�? משמשמ בעת ל�?יחסון מטמון הפקת הבנ�?רי�? (cache).";
$GLOBALS['strDeliveryCacheFiles'] = "מטמון הפקת הבנ�?רי�? (cache) מ�?וחסן כעת על כמה קבצי�? בשרת שלך.";

// Storage
$GLOBALS['strStorage'] = "�?יחסון";
$GLOBALS['strMoveToDirectory'] = "העבר �?ת התמונות השמורות בתוך בסיס הנתוני�? �?ל תוך התיקייה.";
$GLOBALS['strStorageExplaination'] = "הב�?נרי�? בשימוש מקומי מ�?וחסני�? בתוך בסיס הנתוני�? �?ו בתיקייה על השרת. �?�? �?תה שומר �?ת הב�?נרי�? בתוך תיקייה יפחת העומס על בסיס הנתוני�? ו�?ף המהירות תו�?ץ. ";

// Encoding
$GLOBALS['strEncoding'] = "Encoding";
$GLOBALS['strEncodingExplaination'] = "{$PRODUCT_NAME} now stores all data in the database in UTF-8 format.<br />
    Where possible, your data will have been automatically converted to this encoding.<br />
    If after upgrading you find corrupt characters, and you know the encoding used, you may use this tool to convert the data from that format to UTF-8";
$GLOBALS['strEncodingConvertFrom'] = "Convert from this encoding:";
$GLOBALS['strEncodingConvertTest'] = "Test conversion";
$GLOBALS['strConvertThese'] = "The following data will be changed if you continue";

// Product Updates
$GLOBALS['strSearchingUpdates'] = "מחפש עדכוני�?. �?נ�? המתן...";
$GLOBALS['strAvailableUpdates'] = "עדכוני�? זמיני�?";
$GLOBALS['strDownloadZip'] = "הורד (.zip)";
$GLOBALS['strDownloadGZip'] = "הורד (.tar.gz)";

$GLOBALS['strUpdateAlert'] = "גירסה חדשה של {$PRODUCT_NAME} יצ�?ה ל�?ור.                 \n\nה�?�? �?תה רוצה מידע נוסף \n�?ודות העדכון?";
$GLOBALS['strUpdateAlertSecurity'] = "גירסה חדשה של {$PRODUCT_NAME} יצ�?ה ל�?ור.                 \n\nמומלץ מ�?וד לעדכן \nבהזדמנות הקרובה ביותר, כיוון שגירסה זו \nמכילה תיקוניי�? בטיחוטיי�?.";

$GLOBALS['strUpdateServerDown'] = "מסיבה בלתי ידועה ל�? ניתן להשיג<br />מידע על עדכוני�? �?פשריי�?. �?נ�? נסה שוב מ�?וחר יותר.";

$GLOBALS['strNoNewVersionAvailable'] = "הגירסה שלך של {$PRODUCT_NAME} מעודכנת. �?ין כעת עידכוני�? חדשי�?";

$GLOBALS['strServerCommunicationError'] = "    <b>Communication with the update server timed out, so {$PRODUCT_NAME} is not
    able to check if a newer version is available at this stage. Please try again later.</b>";

$GLOBALS['strCheckForUpdatesDisabled'] = "    <b>Check for updates is disabled. Please enable via the
    <a href='account-settings-update.php'>update settings</a> screen.</b>";

$GLOBALS['strNewVersionAvailable'] = "<b>גירסה חדשה של {$PRODUCT_NAME}יצ�?ה ל�?ור.</b><br /> מומלץ להתקין גירסה זו, כיוון שהי  עשויה לתקן כמה בעיות קיימות ותוסיף תכונות חדשות. למידע נוסף �?ודות השדרוג �?נ�? קר�? �?ת התיועד הכלול בקבצי�? מטה. ";

$GLOBALS['strSecurityUpdate'] = "<b>מומלץ ביותר להתקין �?ת העדכון הזה בהקד�? ה�?פשרי, כיוון שהו�? מכיל מספר תיקוני �?בטחה.</b><br /> הגירסה של {$PRODUCT_NAME}, בה �?תה משתמש כעת, �?פשר שהי�? פגיעה להתקפות מסוימות ו�?ולי �?ינה מוגנת. למידע נוסף �?ודות העדכון �?נ�? קר�? �?ת התיועד הכלול בקבצי�? מטה. ";

$GLOBALS['strNotAbleToCheck'] = "	<b>כיוון שהרחבת ה-XML �?ינה קיימת על השרת שלך, {$PRODUCT_NAME} �?ינה יכולה לבדוק �?ת יצ�?ה גירסה חדשה.</b>";

$GLOBALS['strForUpdatesLookOnWebsite'] = "	If you want to know if there is a newer version available, please take a look at our website.";

$GLOBALS['strClickToVisitWebsite'] = "	לחץ כ�?ן כדי לבקר ב�?תר שלנו";
$GLOBALS['strCurrentlyUsing'] = "�?תה משתמש כעת";
$GLOBALS['strRunningOn'] = "רץ על";
$GLOBALS['strAndPlain'] = "ו";

//  Deliver Limitations
$GLOBALS['strDeliveryLimitations'] = "כללי משלוח";
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
