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

$GLOBALS['strAutoMantenaceEnabledAndHasntRun'] = "";

$GLOBALS['strAutoMantenaceDisabledAndHasntRun'] = "";

$GLOBALS['strAutoMantenaceEnabledAndRunning'] = "";

$GLOBALS['strAutoMantenaceDisabledAndRunning'] = "";

$GLOBALS['strScheduledMantenaceRunning'] = "";

$GLOBALS['strAutomaticMaintenanceHasRun'] = "";

$GLOBALS['strAutoMantenaceEnabled'] = "";

// Priority
$GLOBALS['strRecalculatePriority'] = "Přepočítat prioritu";

// Banner cache
$GLOBALS['strCheckBannerCache'] = "Kontrola cache banerů";
$GLOBALS['strBannerCacheErrorsFound'] = "";
$GLOBALS['strBannerCacheOK'] = "";
$GLOBALS['strBannerCacheDifferencesFound'] = "";
$GLOBALS['strBannerCacheRebuildButton'] = "";
$GLOBALS['strRebuildDeliveryCache'] = "Aktualizovat cache doručování";
$GLOBALS['strBannerCacheExplaination'] = "	Cache bannerů obsahuje kopii HTML kódu který se používá pro zobrazení banneru. Použitím chache bannerů je možné docílit zrychlení
	doručování bannerů protože se HTML kód nemusí generovat pokaždé když má být banner doručen. Protože cache bannerů obsahuje pevné
	okdazy na URL kde je umístěno {{PRODUCT_NAME}} a jeho bannery, cache musí být aktualizována pokaždé, když dojde k přesunu
	{{PRODUCT_NAME}} do jiného umístění na webserveru.";

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

// Security
$GLOBALS['strSecurity'] = "";
$GLOBALS['strSecurityExplanation'] = "";
$GLOBALS['strSecurityOK'] = "";
$GLOBALS['strSecurityKO'] = "";
$GLOBALS['strSecurityReadMore'] = "";

// Encoding
$GLOBALS['strEncoding'] = "";
$GLOBALS['strEncodingExplaination'] = "";
$GLOBALS['strEncodingConvertFrom'] = "";
$GLOBALS['strEncodingConvertTest'] = "";
$GLOBALS['strConvertThese'] = "";

// Product Updates
$GLOBALS['strSearchingUpdates'] = "Hledám aktualizace. Prosím čekejte...";
$GLOBALS['strAvailableUpdates'] = "Dostupné aktualizace";
$GLOBALS['strDownloadZip'] = "";
$GLOBALS['strDownloadGZip'] = "";

$GLOBALS['strUpdateAlert'] = "Je k dispozici nová verze {{PRODUCT_NAME}} .

Přejete si více informací o tété
aktualizaci?";
$GLOBALS['strUpdateAlertSecurity'] = "Je k dispozici nová verze {{PRODUCT_NAME}} .

Důrazně doporučujeme provést aktualizaci
co nejdříve, neboť tato verze obsahuje
jednu nebo více bezpečnostních oprav.";

$GLOBALS['strUpdateServerDown'] = "    Z neznámého důvodu nebylo možné získat <br>
	informace o aktualizacích. Prosím zkuste to znovu později.";

$GLOBALS['strNoNewVersionAvailable'] = "	Vaše verze {{PRODUCT_NAME}} je aktuální. V tuto chvíli nejsou k dispozici žádné aktualizace.";

$GLOBALS['strServerCommunicationError'] = "";

$GLOBALS['strCheckForUpdatesDisabled'] = "";

$GLOBALS['strNewVersionAvailable'] = "	<b>Novější verze {{PRODUCT_NAME}} je k dispozici.</b><br> Doporučujeme nainstalovat tuto aktualizaci,
	protože může obsahovat opravy některých chyb a obsahovat nové funkce. Pro více informací o tom jak provést
	aktualizaci si prosím přečtěte dokumentaci která je v níže uvedených souborech.";

$GLOBALS['strSecurityUpdate'] = "	<b>Důrazně doporučujeme nainstalovat tuto aktualizaci co nejdříve, protože obsahuje několik oprav
	bezpečnostních chyb.</b> Verze {{PRODUCT_NAME}} kterou používáte může být citlivá ná různé
	druhy útoků a zřejmě není bezpečná. Pro více informací o tom jak provést aktualizaci si prosím
	přečtěte dokumentaci která je v níže uvedených souborech.";

$GLOBALS['strNotAbleToCheck'] = "	<b>Protože XML doplněk není instalován na vašem serveru, {{PRODUCT_NAME}} není
    schopen ověřit zda jsou k dispozici aktualizace.</b>";

$GLOBALS['strForUpdatesLookOnWebsite'] = "	Pokud chcete vědět jestli je k dispozici novější verze tak navštivte naše stránky.";

$GLOBALS['strClickToVisitWebsite'] = "Klikněte zde pro naše webové stránky";
$GLOBALS['strCurrentlyUsing'] = "V tuto chvíli používáte";
$GLOBALS['strRunningOn'] = "běžící na";
$GLOBALS['strAndPlain'] = "a";

//  Deliver Limitations
$GLOBALS['strDeliveryLimitations'] = "";
$GLOBALS['strAllBannerChannelCompiled'] = "";
$GLOBALS['strBannerChannelResult'] = "";
$GLOBALS['strChannelCompiledLimitationsValid'] = "";
$GLOBALS['strBannerCompiledLimitationsValid'] = "";
$GLOBALS['strErrorsFound'] = "";
$GLOBALS['strRepairCompiledLimitations'] = "";
$GLOBALS['strRecompile'] = "";
$GLOBALS['strDeliveryEngineDisagreeNotice'] = "";
$GLOBALS['strCheckACLs'] = "";

//  Append codes
$GLOBALS['strAppendCodesDesc'] = "";
$GLOBALS['strCheckAppendCodes'] = "";
$GLOBALS['strAppendCodesRecompiled'] = "";
$GLOBALS['strAppendCodesResult'] = "";
$GLOBALS['strAppendCodesValid'] = "";
$GLOBALS['strRepairAppenedCodes'] = "";

$GLOBALS['strPlugins'] = "";
$GLOBALS['strPluginsPrecis'] = "";

$GLOBALS['strMenus'] = "";
$GLOBALS['strMenusPrecis'] = "";
$GLOBALS['strMenusCachedOk'] = "";

// Users
$GLOBALS['strUserPasswords'] = "";
$GLOBALS['strUserPasswordsExplaination'] = "";
$GLOBALS['strCheckUserPasswords'] = "";
$GLOBALS['strUserPasswordsEverythingOK'] = "";
$GLOBALS['strUserPasswordsEmailsSent'] = "";
