<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
| For contact details, see: http://www.openx.org/                           |
|                                                                           |
| This program is free software; you can redistribute it and/or modify      |
| it under the terms of the GNU General Public License as published by      |
| the Free Software Foundation; either version 2 of the License, or         |
| (at your option) any later version.                                       |
|                                                                           |
| This program is distributed in the hope that it will be useful,           |
| but WITHOUT ANY WARRANTY; without even the implied warranty of            |
| MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
| GNU General Public License for more details.                              |
|                                                                           |
| You should have received a copy of the GNU General Public License         |
| along with this program; if not, write to the Free Software               |
| Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA |
+---------------------------------------------------------------------------+
$Id$
*/


// Main strings
$GLOBALS['strChooseSection']			= "Vyberte sekci";


// Priority
$GLOBALS['strRecalculatePriority']		= "Přepočítat prioritu";
$GLOBALS['strHighPriorityCampaigns']		= "Kampaně s vysokou prioritou";
$GLOBALS['strAdViewsAssigned']			= "Přidělěných zobrazení";
$GLOBALS['strLowPriorityCampaigns']		= "Kampaně s nízkou prioritou";
$GLOBALS['strPredictedAdViews']			= "Předpovězených zobrazení";
$GLOBALS['strPriorityDaysRunning']		= "V tuto chvíli jsou k dispozici statistiky za {days} dní z čehož ".$phpAds_productname." může vytvořit denní předpověď. ";
$GLOBALS['strPriorityBasedLastWeek']		= "Předpověď je založena na údajích z tohoto a předchozího týdne. ";
$GLOBALS['strPriorityBasedLastDays']		= "Předpověď je založena na údajích z předchozích několika dnů. ";
$GLOBALS['strPriorityBasedYesterday']		= "Předpověď je založena na údajích ze včerejška. ";
$GLOBALS['strPriorityNoData']			= "Není k dispozici dostatek údajů pro vytvoření důvěryhodné předpovědi počtu impresí pro dnešní den. Přidělení priorit bude průběžně upravováno na základě průběžných údajů. ";
$GLOBALS['strPriorityEnoughAdViews']		= "Mělo by být k dispozici dostatek AdViews pro plné splnění kampaní s vysokou prioritou. ";
$GLOBALS['strPriorityNotEnoughAdViews']		= "Není jisté že bude k dispozici dostatek AdViews pro plné splnění kampaní s vysokou prioritou. ";


// Banner cache
$GLOBALS['strRebuildBannerCache']		= "Aktualizovat cache bannerů";
$GLOBALS['strBannerCacheExplaination']		= "\n	Cache bannerů obsahuje kopii HTML kódu který se používá pro zobrazení banneru. Použitím chache bannerů je možné docílit zrychlení\n	doručování bannerů protože se HTML kód nemusí generovat pokaždé když má být banner doručen. Protože cache bannerů obsahuje pevné\n	okdazy na URL kde je umístěno ".$phpAds_productname." a jeho bannery, cache musí být aktualizována pokaždé, když dojde k přesunu\n	".$phpAds_productname." do jiného umístění na webserveru.\n";


// Cache
$GLOBALS['strCache']			= "Cache doručování";
$GLOBALS['strAge']				= "Stáří";
$GLOBALS['strRebuildDeliveryCache']			= "Aktualizovat cache doručování";
$GLOBALS['strDeliveryCacheExplaination']		= "\n	Cache doručováné je používána pro urychlení doručování bannerů. Cache obsahuje kopii všech bannerů\n	které jsou připojené k zóně což ušetří několik databázových dotazů a bannery jsou přímo doručovány uživateli. Cache\n	je normálně znovu vytvářena při každé změně zóny nebo bannerů zóny a pokud je to možné je cache aktualizována. Z tohoto\n	důvodu se cache automaticky aktualizuje každou hodinu, ale je možné ji aktualizovat i ručně.\n";
$GLOBALS['strDeliveryCacheSharedMem']		= "\n	V tuto chvíli se pro ukládání cache doručování využívá sdílená paměť.\n";
$GLOBALS['strDeliveryCacheDatabase']		= "\n	V tuto chvíli se pro ukládání cache doručování využívá databáze.\n";
$GLOBALS['strDeliveryCacheFiles']		= "\n	V tuto chvíli se pro ukládání cache doručování využívá vícero souborů na disku.\n";


// Storage
$GLOBALS['strStorage']				= "Ukládání";
$GLOBALS['strMoveToDirectory']			= "Přesunout obrázky uložené v databázi do adresáře";
$GLOBALS['strStorageExplaination']		= "\n	Obrázky lokálních bannerů jsou uloženy v databázi nebo v adresáři. Pokud uložíte soubory do adresáře\n	zátěž databáze výrazně poklesne a zvýší se rychlost doručování.\n";


// Storage
$GLOBALS['strStatisticsExplaination']		= "\n";


// Product Updates
$GLOBALS['strSearchingUpdates']			= "Hledám aktualizace. Prosím čekejte...";
$GLOBALS['strAvailableUpdates']			= "Dostupné aktualizace";
$GLOBALS['strDownloadZip']			= "Download (.zip)";
$GLOBALS['strDownloadGZip']			= "Download (.tar.gz)";

$GLOBALS['strUpdateAlert']			= "Je k dispozici nová verze ". MAX_PRODUCT_NAME ." .                 \n\nPřejete si více informací o tété \naktualizaci?";
$GLOBALS['strUpdateAlertSecurity']		= "Je k dispozici nová verze ". MAX_PRODUCT_NAME ." .                 \n\nDůrazně doporučujeme provést aktualizaci \nco nejdříve, neboť tato verze obsahuje \njednu nebo více bezpečnostních oprav.";

$GLOBALS['strUpdateServerDown']			= "\n    Z neznámého důvodu nebylo možné získat <br>\n	informace o aktualizacích. Prosím zkuste to znovu později.\n";

$GLOBALS['strNoNewVersionAvailable']		= "\n	Vaše verze ".$phpAds_productname." je aktuální. V tuto chvíli nejsou k dispozici žádné aktualizace.\n";

$GLOBALS['strNewVersionAvailable']		= "\n	<b>Novější verze ".$phpAds_productname." je k dispozici.</b><br> Doporučujeme nainstalovat tuto aktualizaci,\n	protože může obsahovat opravy některých chyb a obsahovat nové funkce. Pro více informací o tom jak provést\n	aktualizaci si prosím přečtěte dokumentaci která je v níže uvedených souborech.\n";

$GLOBALS['strSecurityUpdate']			= "\n	<b>Důrazně doporučujeme nainstalovat tuto aktualizaci co nejdříve, protože obsahuje několik oprav\n	bezpečnostních chyb.</b> Verze ".$phpAds_productname." kterou používáte může být citlivá ná různé\n	druhy útoků a zřejmě není bezpečná. Pro více informací o tom jak provést aktualizaci si prosím\n	přečtěte dokumentaci která je v níže uvedených souborech.\n";

$GLOBALS['strNotAbleToCheck']			= "\n	<b>Protože XML doplněk není instalován na vašem serveru, ".$phpAds_productname." není\n    schopen ověřit zda jsou k dispozici aktualizace.</b>\n";

$GLOBALS['strForUpdatesLookOnWebsite']	= "\n	Pokud chcete vědět jestli je k dispozici novější verze tak navštivte naše stránky.\n";

$GLOBALS['strClickToVisitWebsite']		= "Klikněte zde pro naše webové stránky";
$GLOBALS['strCurrentlyUsing'] 			= "V tuto chvíli používáte";
$GLOBALS['strRunningOn']				= "běžící na";
$GLOBALS['strAndPlain']					= "a";


// Stats conversion
$GLOBALS['strConverting']			= "Probíhá převod";
$GLOBALS['strConvertingStats']			= "Převod statistik...";
$GLOBALS['strConvertStats']			= "Převeď statistiky";
$GLOBALS['strConvertAdViews']			= "Převedených zobrazení,";
$GLOBALS['strConvertAdClicks']			= "Převedených kliknutí...";
$GLOBALS['strConvertAdConversions']			= "Převedených prodejů...";
$GLOBALS['strConvertNothing']			= "Není nic k převodu...";
$GLOBALS['strConvertFinished']			= "Dokončeno...";

$GLOBALS['strConvertExplaination']		= "\n	V tuto chvíli používáte kompaktní formát statistik, ale stále máte některé statsitiky <br>\n	v datailním formátu. Dokud nebudou deatilní statistiky převedny do kompaktního formátu <br>\n	nebudou zobrazovány při prohlížení této stránky.  <br>\n	Před převodem statistiky si zazálohujte databázi!  <br>\n	Chcete převést deatilní statistiky do kompaktního formátu? <br>\n";

$GLOBALS['strConvertingExplaination']		= "\n	Všechny zbývající detailní statistiky jsou převáděny do kompaktního formátu. <br>\n	V závislosti na počtu impresí uložených v detailním formátu tato akce může trvat  <br>\n	až několik minut. Prosím vyčkejte na ukončení převodu než navšívíte jiné stráky. <br>\n	Níže máte seznam všech úprav provedených na databázi. <br>\n";

$GLOBALS['strConvertFinishedExplaination']  	= "\n	Převod zbývajících detailních statistik byl úspěšný a data by nyní měla být <br>\n	znovu použitelná. Níže máte seznam všech úprav provedených na databázi. <br>\n";




// Note: New translations not found in original lang files but found in CSV
$GLOBALS['strEncodingConvert'] = "Konvertovat";
?>