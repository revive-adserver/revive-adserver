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
$GLOBALS['strChooseSection'] = "Szekció kiválasztása";
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
$GLOBALS['strRecalculatePriority'] = "Prioritás újraszámolása";

// Banner cache
$GLOBALS['strCheckBannerCache'] = "A banner gyorsítótár ellenőrzése";
$GLOBALS['strBannerCacheErrorsFound'] = "Az adatbázis banner gyorsítótár hibát talált. A hibás bannerek nem lesznek elérhetőek amíg manuálisan helyre nem állítják őket.";
$GLOBALS['strBannerCacheOK'] = "Az ellenőrzés nem talált hibát, az adatbázis banner gyorsítótár nem igényel frissítést.";
$GLOBALS['strBannerCacheDifferencesFound'] = "Az adatbázis banner gyorsítótár elavult és újraépítést igényel. Kattintson ide az automatikus frissítéshez.";
$GLOBALS['strBannerCacheRebuildButton'] = "Újraépítés";
$GLOBALS['strRebuildDeliveryCache'] = "Az adatbázis banner gyorsítótár újraépítése";
$GLOBALS['strBannerCacheExplaination'] = "    Az adatbázis banner gyorsítótára a bannerek kiszolgálásának meggyorsítására szolgál<br />
    Ez a gyorsítótár újraépítésre szorul amikor:
    <ul>
        <li>Az OpenX rendszer frissítésre kerül</li>
        <li>Új szerverre kerül az OpenX rendszer</li>
    </ul>";

// Cache
$GLOBALS['strCache'] = "Kiszolgáló gyorsítótár";
$GLOBALS['strDeliveryCacheSharedMem'] = "	Jelenleg a megosztott memóriában tárolódik a kiszolgáló gyorsítótár.";
$GLOBALS['strDeliveryCacheDatabase'] = "	Jelenleg az adatbázisban tárolódik a kiszolgáló gyorsítótár.";
$GLOBALS['strDeliveryCacheFiles'] = "	Jelenleg a szerver több különböző fájljában tárolódik a kiszolgáló gyorsítótár.";

// Storage
$GLOBALS['strStorage'] = "Tárolás";
$GLOBALS['strMoveToDirectory'] = "Mozgassa az adatbázisban tárolt képeket egy könyvtárba";
$GLOBALS['strStorageExplaination'] = "	A helyi bannerek által használt képek az adatbázisban vagy helyi könyvtárban tárolódnak. Ha könyvtárban tárolja a képeket,
	akkor csökken az adatbázis terhelése és gyorsulást eredményez a kiszolgálásban.";

// Encoding
$GLOBALS['strEncoding'] = "Encoding";
$GLOBALS['strEncodingExplaination'] = "{$PRODUCT_NAME} now stores all data in the database in UTF-8 format.<br />
    Where possible, your data will have been automatically converted to this encoding.<br />
    If after upgrading you find corrupt characters, and you know the encoding used, you may use this tool to convert the data from that format to UTF-8";
$GLOBALS['strEncodingConvertFrom'] = "Convert from this encoding:";
$GLOBALS['strEncodingConvertTest'] = "Test conversion";
$GLOBALS['strConvertThese'] = "The following data will be changed if you continue";

// Product Updates
$GLOBALS['strSearchingUpdates'] = "Frissítések ellenőrzése folyamatban, kérjük várjon...";
$GLOBALS['strAvailableUpdates'] = "Elérhető frissítések";
$GLOBALS['strDownloadZip'] = "Letöltés (.zip)";
$GLOBALS['strDownloadGZip'] = "Letöltés (.tar.gz)";

$GLOBALS['strUpdateAlert'] = "{$PRODUCT_NAME} egy új verziója elérhető.

Szeretnél több információt kapni
erről a frissítésről?";
$GLOBALS['strUpdateAlertSecurity'] = "{$PRODUCT_NAME} egy új verziója elérhető.

A frissítés mielőbbi végrehajtása erősen ajánlott,
mert az új verzió egy vagy több biztonsági javítást is tartalmaz.";

$GLOBALS['strUpdateServerDown'] = "Valamilyen ismertlen okból nem sikerült ellenőrizni<br>az elérhető frissítéseket. Kérjük próbálja újra később!";

$GLOBALS['strNoNewVersionAvailable'] = "	{$PRODUCT_NAME} a legfrissebb verzióban fut. Jelenleg nincs elérhető frissítés.";

$GLOBALS['strServerCommunicationError'] = "    <b>Communication with the update server timed out, so {$PRODUCT_NAME} is not
    able to check if a newer version is available at this stage. Please try again later.</b>";

$GLOBALS['strCheckForUpdatesDisabled'] = "    <b>Check for updates is disabled. Please enable via the
    <a href='account-settings-update.php'>update settings</a> screen.</b>";

$GLOBALS['strNewVersionAvailable'] = "	<b>{$PRODUCT_NAME} egy újabb verziója már elérhető.</b><br /> Az új verzió telepítése erősen ajánlott,
	mert kijavíthat néhány meglévő hibát és új funkciókat is tartalmaz. Ha több információt
	szeretne a frissítésről, akkor kérjük olvassa el dokumentációt, amit megtalál az alábbi fájlok között.";

$GLOBALS['strSecurityUpdate'] = "	<b>Az új verzió mielőbbi telepítése erősen ajánlott, mert az tartalmaz néhány
	biztonsági javítást.</b> Az {$PRODUCT_NAME} Ön által használt verziója
	bizonyos támadásokkal szemben védtelen lehet és ezért nem biztonságos.
	Ha szeretne több információt a frissítésről, kérjük olvassa el a dokumentációt, amit megtalál az alábbi fájlok között.";

$GLOBALS['strNotAbleToCheck'] = "	<b>Mivel az XML kiterjesztés nem elérhető a szerveren, az {$PRODUCT_NAME} nem tudja
   ellenőrizni, hogy elérhető-e újabb verzió.</b>";

$GLOBALS['strForUpdatesLookOnWebsite'] = "	Ha szeretné megtudni, hogy van-e elérhető frissítés, kérjük látogassa meg a honlapunkat.";

$GLOBALS['strClickToVisitWebsite'] = "Kattintson ide a honlapunk meglátogatásához!";
$GLOBALS['strCurrentlyUsing'] = "A jelenleg következőt használja:";
$GLOBALS['strRunningOn'] = "Futtatási környezet: ";
$GLOBALS['strAndPlain'] = ", ";

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
