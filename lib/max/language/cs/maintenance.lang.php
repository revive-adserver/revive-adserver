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
$GLOBALS['strChooseSection'] = "Vyberte sekci";
$GLOBALS['strAppendCodes'] = "Přidat kódy";

// Maintenance
$GLOBALS['strScheduledMaintenanceHasntRun'] = "<b>Plánovaná údržbu nelze spustit za poslední hodinu. To může znamenat, že není nastavena správně.</b>";

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
$GLOBALS['strRecalculatePriority'] = "Přepočítat prioritu";

// Banner cache
$GLOBALS['strCheckBannerCache'] = "Kontrola cache banerů";
$GLOBALS['strBannerCacheErrorsFound'] = "The database banner cache check has found some errors. These banners will not work until you manually fix them.";
$GLOBALS['strBannerCacheOK'] = "There were no errors detected. Your database banner cache is up to date";
$GLOBALS['strBannerCacheDifferencesFound'] = "The database banner cache check has found that your cache is not up to date and requires rebuilding. Click here to automatically  update your cache.";
$GLOBALS['strBannerCacheRebuildButton'] = "Rebuild";
$GLOBALS['strRebuildDeliveryCache'] = "Aktualizovat cache doručování";
$GLOBALS['strBannerCacheExplaination'] = "	Cache bannerů obsahuje kopii HTML kódu který se používá pro zobrazení banneru. Použitím chache bannerů je možné docílit zrychlení
	doručování bannerů protože se HTML kód nemusí generovat pokaždé když má být banner doručen. Protože cache bannerů obsahuje pevné
	okdazy na URL kde je umístěno {$PRODUCT_NAME} a jeho bannery, cache musí být aktualizována pokaždé, když dojde k přesunu
	{$PRODUCT_NAME} do jiného umístění na webserveru.";

// Cache
$GLOBALS['strCache'] = "Cache doručování";
$GLOBALS['strDeliveryCacheSharedMem'] = "	V tuto chvíli se pro ukládání cache doručování využívá sdílená paměť.";
$GLOBALS['strDeliveryCacheDatabase'] = "	V tuto chvíli se pro ukládání cache doručování využívá databáze.";
$GLOBALS['strDeliveryCacheFiles'] = "	V tuto chvíli se pro ukládání cache doručování využívá vícero souborů na disku.";

// Storage
$GLOBALS['strStorage'] = "Ukládání";
$GLOBALS['strMoveToDirectory'] = "Přesunout obrázky uložené v databázi do adresáře";
$GLOBALS['strStorageExplaination'] = "	Obrázky lokálních bannerů jsou uloženy v databázi nebo v adresáři. Pokud uložíte soubory do adresáře
	zátěž databáze výrazně poklesne a zvýší se rychlost doručování.";

// Encoding
$GLOBALS['strEncoding'] = "Encoding";
$GLOBALS['strEncodingExplaination'] = "{$PRODUCT_NAME} now stores all data in the database in UTF-8 format.<br />
    Where possible, your data will have been automatically converted to this encoding.<br />
    If after upgrading you find corrupt characters, and you know the encoding used, you may use this tool to convert the data from that format to UTF-8";
$GLOBALS['strEncodingConvertFrom'] = "Convert from this encoding:";
$GLOBALS['strEncodingConvertTest'] = "Test conversion";
$GLOBALS['strConvertThese'] = "The following data will be changed if you continue";

// Product Updates
$GLOBALS['strSearchingUpdates'] = "Hledám aktualizace. Prosím čekejte...";
$GLOBALS['strAvailableUpdates'] = "Dostupné aktualizace";
$GLOBALS['strDownloadZip'] = "Download (.zip)";
$GLOBALS['strDownloadGZip'] = "Download (.tar.gz)";

$GLOBALS['strUpdateAlert'] = "Je k dispozici nová verze {$PRODUCT_NAME} .

Přejete si více informací o tété
aktualizaci?";
$GLOBALS['strUpdateAlertSecurity'] = "Je k dispozici nová verze {$PRODUCT_NAME} .

Důrazně doporučujeme provést aktualizaci
co nejdříve, neboť tato verze obsahuje
jednu nebo více bezpečnostních oprav.";

$GLOBALS['strUpdateServerDown'] = "    Z neznámého důvodu nebylo možné získat <br>
	informace o aktualizacích. Prosím zkuste to znovu později.";

$GLOBALS['strNoNewVersionAvailable'] = "	Vaše verze {$PRODUCT_NAME} je aktuální. V tuto chvíli nejsou k dispozici žádné aktualizace.";

$GLOBALS['strServerCommunicationError'] = "    <b>Communication with the update server timed out, so {$PRODUCT_NAME} is not
    able to check if a newer version is available at this stage. Please try again later.</b>";

$GLOBALS['strCheckForUpdatesDisabled'] = "    <b>Check for updates is disabled. Please enable via the
    <a href='account-settings-update.php'>update settings</a> screen.</b>";

$GLOBALS['strNewVersionAvailable'] = "	<b>Novější verze {$PRODUCT_NAME} je k dispozici.</b><br> Doporučujeme nainstalovat tuto aktualizaci,
	protože může obsahovat opravy některých chyb a obsahovat nové funkce. Pro více informací o tom jak provést
	aktualizaci si prosím přečtěte dokumentaci která je v níže uvedených souborech.";

$GLOBALS['strSecurityUpdate'] = "	<b>Důrazně doporučujeme nainstalovat tuto aktualizaci co nejdříve, protože obsahuje několik oprav
	bezpečnostních chyb.</b> Verze {$PRODUCT_NAME} kterou používáte může být citlivá ná různé
	druhy útoků a zřejmě není bezpečná. Pro více informací o tom jak provést aktualizaci si prosím
	přečtěte dokumentaci která je v níže uvedených souborech.";

$GLOBALS['strNotAbleToCheck'] = "	<b>Protože XML doplněk není instalován na vašem serveru, {$PRODUCT_NAME} není
    schopen ověřit zda jsou k dispozici aktualizace.</b>";

$GLOBALS['strForUpdatesLookOnWebsite'] = "	Pokud chcete vědět jestli je k dispozici novější verze tak navštivte naše stránky.";

$GLOBALS['strClickToVisitWebsite'] = "Klikněte zde pro naše webové stránky";
$GLOBALS['strCurrentlyUsing'] = "V tuto chvíli používáte";
$GLOBALS['strRunningOn'] = "běžící na";
$GLOBALS['strAndPlain'] = "a";

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
