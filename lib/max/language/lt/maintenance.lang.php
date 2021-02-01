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
$GLOBALS['strChooseSection'] = "Pasirinkti dalį";
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
$GLOBALS['strRecalculatePriority'] = "Perskaičiuoti pirmenybę";

// Banner cache
$GLOBALS['strCheckBannerCache'] = "Patikrinti banerių atsargas";
$GLOBALS['strBannerCacheErrorsFound'] = "Banerių duomenų bazė rado tam tikrų klaidų. Šie baneriai neveiks tol, kol jų rankiniu būdu nesutvarkysite.";
$GLOBALS['strBannerCacheOK'] = "Jokių klaidų nerasta. Jūsų banerių duomenų bazė atnaujinta ";
$GLOBALS['strBannerCacheDifferencesFound'] = "The database banner cache check has found that your cache is not up to date and requires rebuilding. Click here to automatically  update your cache.";
$GLOBALS['strBannerCacheRebuildButton'] = "Atstatyti";
$GLOBALS['strRebuildDeliveryCache'] = "Atstatyti banerių duomenų bazės sandėlius";
$GLOBALS['strBannerCacheExplaination'] = "    Banerių duomenų bazės naudojamos pagreitinti pristatymus, kai jie užsakyti<br />
   Atsargos turi būti atnaujintos, kai:
    <ul>
        <li>Jūsų atnaujinta versija OpenX</li>
        <li>Perkelkite OpenX instaliaciją į kitą serverį</li>
    </ul>";

// Cache
$GLOBALS['strCache'] = "Pristatymo sandėlys";
$GLOBALS['strDeliveryCacheSharedMem'] = "	 Pasidalinta atmintis yra naudojama pristatymo sandėliui.";
$GLOBALS['strDeliveryCacheDatabase'] = "	 Duomenų bazė naudojama pristatymo sandėlio duomenims išsaugoti.";
$GLOBALS['strDeliveryCacheFiles'] = "	 Pristatymo sandėlio atsargų kiekis yra išsaugotas per kelis failus Jūsų serveryje.";

// Storage
$GLOBALS['strStorage'] = "Saugojimas";
$GLOBALS['strMoveToDirectory'] = "Išsaugotus vaizdus perkelti į katalogą";
$GLOBALS['strStorageExplaination'] = "	 Vaizdai, kuriuos naudoja vietiniai baneriaiyra išsaugoti kataloge. Jei išsaugosite vaizdus viduje
	a katalogo tai tuomet padidės siuntimo į bazę greitis, tačiau sumažės vietos pačioje bazėje.";

// Encoding
$GLOBALS['strEncoding'] = "Užkoduota";
$GLOBALS['strEncodingExplaination'] = "{$PRODUCT_NAME} now stores all data in the database in UTF-8 format.<br />
    Where possible, your data will have been automatically converted to this encoding.<br />
    If after upgrading you find corrupt characters, and you know the encoding used, you may use this tool to convert the data from that format to UTF-8";
$GLOBALS['strEncodingConvertFrom'] = "Konvertuoti iš šio užkodavimo:";
$GLOBALS['strEncodingConvertTest'] = "Perkeitimo testas";
$GLOBALS['strConvertThese'] = "Šie duomenys bus pakeisti jei nuspręsite tęsti";

// Product Updates
$GLOBALS['strSearchingUpdates'] = "Ieškoma atnaujinimų. Prašome palaukti...";
$GLOBALS['strAvailableUpdates'] = "Galimi atnaujinimai";
$GLOBALS['strDownloadZip'] = "Parsisiųsti(.zip)";
$GLOBALS['strDownloadGZip'] = "Parsisiųsti (.zip)";

$GLOBALS['strUpdateAlert'] = "A new version of {$PRODUCT_NAME} is available.                 \\n\\nDo you want to get more information \\nabout this update?";
$GLOBALS['strUpdateAlertSecurity'] = "A new version of {$PRODUCT_NAME} is available.                 \\n\\nIt is highly recommended to upgrade \\nas soon as possible, because this \\nversion contains one or more security fixes.";

$GLOBALS['strUpdateServerDown'] = "Dėl nežinomų priežasčių neįmanoma atkurti <br>informacijos apie galimus atnaujinimus. Prašome vėliau pabandyti iš naujo.";

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

$GLOBALS['strForUpdatesLookOnWebsite'] = "	jei norite sužinoti ar yra galima naujesnė versija, prašome užsukti į mūasų internetinį puslapį.";

$GLOBALS['strClickToVisitWebsite'] = "Spauskite čia jei norite užsukti į mūsų internetinį puslapį";
$GLOBALS['strCurrentlyUsing'] = "Šiuo metu Jūs naudojate";
$GLOBALS['strRunningOn'] = "paleista per";
$GLOBALS['strAndPlain'] = "Ir";

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
