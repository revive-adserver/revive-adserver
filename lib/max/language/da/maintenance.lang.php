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
$GLOBALS['strChooseSection'] = "Vælg sektion";
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
$GLOBALS['strRecalculatePriority'] = "Genkalkuler prioritet";

// Banner cache
$GLOBALS['strCheckBannerCache'] = "Tjek banner cache";
$GLOBALS['strBannerCacheErrorsFound'] = "Denne database banner cache tjek har fundet nogle fejl. Denne banner vil ikke fungere indtil du manuelt har løst fejlene.";
$GLOBALS['strBannerCacheOK'] = "Der blev ikke dedekteret nogle fejl. Din database banner cache er opdateret.";
$GLOBALS['strBannerCacheDifferencesFound'] = "Database banner cache tjek har fundet at din cache ikke er opdateret og den kræver genopbygning. Klik her for automatisk at opdatere din cache.";
$GLOBALS['strBannerCacheRebuildButton'] = "Genopbygge";
$GLOBALS['strRebuildDeliveryCache'] = "Genopbyg database banner cache";
$GLOBALS['strBannerCacheExplaination'] = "Database banner cache er anvendt for at forøge leveringshastigheden af bannere under levering <br />
Denne cache skal opdateres når:
<ul>
<li>Du opgrader din version af OpenX</li>
<li>Du flytter din OpenX version til en anden server</li>
</ul>";

// Cache
$GLOBALS['strCache'] = "Cache levering";
$GLOBALS['strDeliveryCacheSharedMem'] = "	Delt hukommelse bliver for øjeblikket anvendt til at gemme leverings cachen.";
$GLOBALS['strDeliveryCacheDatabase'] = "	Databasen bliver for øjeblikket anvendt til at gemme leverings cachen.";
$GLOBALS['strDeliveryCacheFiles'] = "	Leverings cachen er for øjeblikket gemt i forskellige filer på din server.";

// Storage
$GLOBALS['strStorage'] = "Lager";
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
$GLOBALS['strSearchingUpdates'] = "Kontrollere for opdateringer. Venligst vent...";
$GLOBALS['strAvailableUpdates'] = "Tilgængelige opdateringer";
$GLOBALS['strDownloadZip'] = "Download (.zip)";
$GLOBALS['strDownloadGZip'] = "Download (.tar.gz)";

$GLOBALS['strUpdateAlert'] = "En ny version af {$PRODUCT_NAME} er tilgængelig.

Ønsker fu at få mere information
om denne opdatering?";
$GLOBALS['strUpdateAlertSecurity'] = "En ny version af {$PRODUCT_NAME} er tilgængelig.

Det anbefales meget at opgradere
så hurtigt som muligt, da denne
version indeholder en eller flere sikkerhedsopdateringer.";

$GLOBALS['strUpdateServerDown'] = "Af en ukendt årsag er det ikke muligt at indente<br>information om mulige opdateringer. Venligst forsøg igen senere.";

$GLOBALS['strNoNewVersionAvailable'] = "	Din version af {$PRODUCT_NAME} er opdateret. Der er for øjeblikket ingen opdateringer tilgængelige.";

$GLOBALS['strServerCommunicationError'] = "    <b>Communication with the update server timed out, so {$PRODUCT_NAME} is not
    able to check if a newer version is available at this stage. Please try again later.</b>";

$GLOBALS['strCheckForUpdatesDisabled'] = "    <b>Check for updates is disabled. Please enable via the
    <a href='account-settings-update.php'>update settings</a> screen.</b>";

$GLOBALS['strNewVersionAvailable'] = "	<b>En ny version af {$PRODUCT_NAME} er tilgængelig.</b><br /> Det anbefales at installere denne opdatering,
	fordi den vil muligvis reperere nogle eksisterende problemer og tilføje nye funktioner. For yderligere information
	om opgradering venligst læs dokumentationen som er inkluderet i filen vist nedenfor";

$GLOBALS['strSecurityUpdate'] = "	<b>Det anbefales kraftigt at installere denne opdatering så hurtigt som muligt, da den indeholder et antal
	sikkerheds fejlrettelser.</b> Denne version af {$PRODUCT_NAME} som du anvender for øjeblikket er
	sårbar overfor nogle angreb og er måske ikke sikker. For yderligere information
	om omdateringen venligst læs dokumentationen som er inkluderet i filen nedenfor.";

$GLOBALS['strNotAbleToCheck'] = "	<b>På grund af XML udvidelse ikke er tilgængelig på din server, {$PRODUCT_NAME} har ikke
mulighed for at kontrollere om der er en ny version tilgængelig.</b>";

$GLOBALS['strForUpdatesLookOnWebsite'] = "	Hvis du ønsker at vide om der er en nyere version tilgængelig, venligst besøg vores webside.";

$GLOBALS['strClickToVisitWebsite'] = "Klik her for at besøge vores webside";
$GLOBALS['strCurrentlyUsing'] = "Du anvender for øjeblikket";
$GLOBALS['strRunningOn'] = "kører på";
$GLOBALS['strAndPlain'] = "og";

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
