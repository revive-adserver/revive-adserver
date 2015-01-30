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

// Maintenance









// Priority
$GLOBALS['strRecalculatePriority'] = "Přepočítat prioritu";
$GLOBALS['strHighPriorityCampaigns'] = "Kampaně s vysokou prioritou";
$GLOBALS['strAdViewsAssigned'] = "Přidělěných zobrazení";
$GLOBALS['strLowPriorityCampaigns'] = "Kampaně s nízkou prioritou";
$GLOBALS['strPredictedAdViews'] = "Předpovězených zobrazení";
$GLOBALS['strPriorityDaysRunning'] = "V tuto chvíli jsou k dispozici statistiky za {days} dní z čehož {$PRODUCT_NAME} může vytvořit denní předpověď. ";
$GLOBALS['strPriorityBasedLastWeek'] = "Předpověď je založena na údajích z tohoto a předchozího týdne. ";
$GLOBALS['strPriorityBasedLastDays'] = "Předpověď je založena na údajích z předchozích několika dnů. ";
$GLOBALS['strPriorityBasedYesterday'] = "Předpověď je založena na údajích ze včerejška. ";
$GLOBALS['strPriorityNoData'] = "Není k dispozici dostatek údajů pro vytvoření důvěryhodné předpovědi počtu impresí pro dnešní den. Přidělení priorit bude průběžně upravováno na základě průběžných údajů. ";
$GLOBALS['strPriorityEnoughAdViews'] = "Mělo by být k dispozici dostatek AdViews pro plné splnění kampaní s vysokou prioritou. ";
$GLOBALS['strPriorityNotEnoughAdViews'] = "Není jisté že bude k dispozici dostatek AdViews pro plné splnění kampaní s vysokou prioritou. ";


// Banner cache
$GLOBALS['strRebuildBannerCache'] = "Aktualizovat cache bannerů";
$GLOBALS['strRebuildDeliveryCache'] = "Aktualizovat cache doručování";
$GLOBALS['strBannerCacheExplaination'] = "	Cache bannerů obsahuje kopii HTML kódu který se používá pro zobrazení banneru. Použitím chache bannerů je možné docílit zrychlení
	doručování bannerů protože se HTML kód nemusí generovat pokaždé když má být banner doručen. Protože cache bannerů obsahuje pevné
	okdazy na URL kde je umístěno {$PRODUCT_NAME} a jeho bannery, cache musí být aktualizována pokaždé, když dojde k přesunu
	{$PRODUCT_NAME} do jiného umístění na webserveru.";

// Cache
$GLOBALS['strCache'] = "Cache doručování";
$GLOBALS['strAge'] = "Stáří";
$GLOBALS['strDeliveryCacheSharedMem'] = "	V tuto chvíli se pro ukládání cache doručování využívá sdílená paměť.";
$GLOBALS['strDeliveryCacheDatabase'] = "	V tuto chvíli se pro ukládání cache doručování využívá databáze.";
$GLOBALS['strDeliveryCacheFiles'] = "	V tuto chvíli se pro ukládání cache doručování využívá vícero souborů na disku.";


// Storage
$GLOBALS['strStorage'] = "Ukládání";
$GLOBALS['strMoveToDirectory'] = "Přesunout obrázky uložené v databázi do adresáře";
$GLOBALS['strStorageExplaination'] = "	Obrázky lokálních bannerů jsou uloženy v databázi nebo v adresáři. Pokud uložíte soubory do adresáře
	zátěž databáze výrazně poklesne a zvýší se rychlost doručování.";

// Encoding
$GLOBALS['strEncodingConvert'] = "Konvertovat";


// Storage


// Product Updates
$GLOBALS['strSearchingUpdates'] = "Hledám aktualizace. Prosím čekejte...";
$GLOBALS['strAvailableUpdates'] = "Dostupné aktualizace";

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


// Stats conversion
$GLOBALS['strConverting'] = "Probíhá převod";
$GLOBALS['strConvertingStats'] = "Převod statistik...";
$GLOBALS['strConvertStats'] = "Převeď statistiky";
$GLOBALS['strConvertAdViews'] = "Převedených zobrazení,";
$GLOBALS['strConvertAdClicks'] = "Převedených kliknutí...";
$GLOBALS['strConvertAdConversions'] = "Převedených prodejů...";
$GLOBALS['strConvertNothing'] = "Není nic k převodu...";
$GLOBALS['strConvertFinished'] = "Dokončeno...";

$GLOBALS['strConvertExplaination'] = "	V tuto chvíli používáte kompaktní formát statistik, ale stále máte některé statsitiky <br>
	v datailním formátu. Dokud nebudou deatilní statistiky převedny do kompaktního formátu <br>
	nebudou zobrazovány při prohlížení této stránky.  <br>
	Před převodem statistiky si zazálohujte databázi!  <br>
	Chcete převést deatilní statistiky do kompaktního formátu? <br>";

$GLOBALS['strConvertingExplaination'] = "	Všechny zbývající detailní statistiky jsou převáděny do kompaktního formátu. <br>
	V závislosti na počtu impresí uložených v detailním formátu tato akce může trvat  <br>
	až několik minut. Prosím vyčkejte na ukončení převodu než navšívíte jiné stráky. <br>
	Níže máte seznam všech úprav provedených na databázi. <br>";

$GLOBALS['strConvertFinishedExplaination'] = "	Převod zbývajících detailních statistik byl úspěšný a data by nyní měla být <br>
	znovu použitelná. Níže máte seznam všech úprav provedených na databázi. <br>";

//  Maintenace

//  Deliver Limitations


//  Append codes


