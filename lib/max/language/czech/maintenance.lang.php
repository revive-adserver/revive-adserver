<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2007 Openads Ltd                                       |
| For contact details, see: http://www.openads.org/                         |
|                                                                           |
| Copyright (c) 2000-2003 the phpAdsNew developers                          |
| For contact details, see: http://www.phpadsnew.com/                       |
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
$GLOBALS['strRecalculatePriority']		= "Pøepoèítat prioritu";
$GLOBALS['strHighPriorityCampaigns']		= "Kampanì s vysokou prioritou";
$GLOBALS['strAdViewsAssigned']			= "Pøidìlìných zobrazení";
$GLOBALS['strLowPriorityCampaigns']		= "Kampanì s nízkou prioritou";
$GLOBALS['strPredictedAdViews']			= "Pøedpovìzených zobrazení";
$GLOBALS['strPriorityDaysRunning']		= "V tuto chvíli jsou k dispozici statistiky za {days} dní z èeho¾ ".$phpAds_productname." mù¾e vytvoøit denní pøedpovìï. ";
$GLOBALS['strPriorityBasedLastWeek']		= "Pøedpovìï je zalo¾ena na údajích z tohoto a pøedchozího týdne. ";
$GLOBALS['strPriorityBasedLastDays']		= "Pøedpovìï je zalo¾ena na údajích z pøedchozích nìkolika dnù. ";
$GLOBALS['strPriorityBasedYesterday']		= "Pøedpovìï je zalo¾ena na údajích ze vèerej¹ka. ";
$GLOBALS['strPriorityNoData']			= "Není k dispozici dostatek údajù pro vytvoøení dùvìryhodné pøedpovìdi poètu impresí pro dne¹ní den. Pøidìlení priorit bude prùbì¾nì upravováno na základì prùbì¾ných údajù. ";
$GLOBALS['strPriorityEnoughAdViews']		= "Mìlo by být k dispozici dostatek AdViews pro plné splnìní kampaní s vysokou prioritou. ";
$GLOBALS['strPriorityNotEnoughAdViews']		= "Není jisté ¾e bude k dispozici dostatek AdViews pro plné splnìní kampaní s vysokou prioritou. ";


// Banner cache
$GLOBALS['strRebuildBannerCache']		= "Aktualizovat cache bannerù";
$GLOBALS['strBannerCacheExplaination']		= "
	Cache bannerù obsahuje kopii HTML kódu který se pou¾ívá pro zobrazení banneru. Pou¾itím chache bannerù je mo¾né docílit zrychlení
	doruèování bannerù proto¾e se HTML kód nemusí generovat poka¾dé kdy¾ má být banner doruèen. Proto¾e cache bannerù obsahuje pevné 
	okdazy na URL kde je umístìno ".$phpAds_productname." a jeho bannery, cache musí být aktualizována poka¾dé, kdy¾ dojde k pøesunu
	".$phpAds_productname." do jiného umístìní na webserveru.
";


// Cache
$GLOBALS['strCache']			= "Cache doruèování";
$GLOBALS['strAge']				= "Stáøí";
$GLOBALS['strRebuildDeliveryCache']			= "Aktualizovat cache doruèování";
$GLOBALS['strDeliveryCacheExplaination']		= "
	Cache doruèováné je pou¾ívána pro urychlení doruèování bannerù. Cache obsahuje kopii v¹ech bannerù
	které jsou pøipojené k zónì co¾ u¹etøí nìkolik databázových dotazù a bannery jsou pøímo doruèovány u¾ivateli. Cache
	je normálnì znovu vytváøena pøi ka¾dé zmìnì zóny nebo bannerù zóny a pokud je to mo¾né je cache aktualizována. Z tohoto
	dùvodu se cache automaticky aktualizuje ka¾dou hodinu, ale je mo¾né ji aktualizovat i ruènì.
";
$GLOBALS['strDeliveryCacheSharedMem']		= "
	V tuto chvíli se pro ukládání cache doruèování vyu¾ívá sdílená pamì».
";
$GLOBALS['strDeliveryCacheDatabase']		= "
	V tuto chvíli se pro ukládání cache doruèování vyu¾ívá databáze.
";
$GLOBALS['strDeliveryCacheFiles']		= "
	V tuto chvíli se pro ukládání cache doruèování vyu¾ívá vícero souborù na disku.
";


// Storage
$GLOBALS['strStorage']				= "Ukládání";
$GLOBALS['strMoveToDirectory']			= "Pøesunout obrázky ulo¾ené v databázi do adresáøe";
$GLOBALS['strStorageExplaination']		= "
	Obrázky lokálních bannerù jsou ulo¾eny v databázi nebo v adresáøi. Pokud ulo¾íte soubory do adresáøe 
	zátì¾ databáze výraznì poklesne a zvý¹í se rychlost doruèování.
";


// Storage
$GLOBALS['strStatisticsExplaination']		= "
	Zapnul jste formát <i>kompaktních statistik</i>, ale va¹e staré statistiky jsou stále v detailním formátu. 
	Pøejete si pøevést va¹e detailní statistiky do kompaktního formátu?
";


// Product Updates
$GLOBALS['strSearchingUpdates']			= "Hledám aktualizace. Prosím èekejte...";
$GLOBALS['strAvailableUpdates']			= "Dostupné aktualizace";
$GLOBALS['strDownloadZip']			= "Download (.zip)";
$GLOBALS['strDownloadGZip']			= "Download (.tar.gz)";

$GLOBALS['strUpdateAlert']			= "Je k dispozici nová verze ".$phpAds_productname." .                 \\n\\nPøejete si více informací o tété \\naktualizaci?";
$GLOBALS['strUpdateAlertSecurity']		= "Je k dispozici nová verze ".$phpAds_productname." .                 \\n\\nDùraznì doporuèujeme provést aktualizaci \\nco nejdøíve, nebo» tato verze obsahuje \\njednu nebo více bezpeènostních oprav.";

$GLOBALS['strUpdateServerDown']			= "
    Z neznámého dùvodu nebylo mo¾né získat <br>
	informace o aktualizacích. Prosím zkuste to znovu pozdìji.
";

$GLOBALS['strNoNewVersionAvailable']		= "
	Va¹e verze ".$phpAds_productname." je aktuální. V tuto chvíli nejsou k dispozici ¾ádné aktualizace.
";

$GLOBALS['strNewVersionAvailable']		= "
	<b>Novìj¹í verze ".$phpAds_productname." je k dispozici.</b><br> Doporuèujeme nainstalovat tuto aktualizaci,
	proto¾e mù¾e obsahovat opravy nìkterých chyb a obsahovat nové funkce. Pro více informací o tom jak provést
	aktualizaci si prosím pøeètìte dokumentaci která je v ní¾e uvedených souborech.
";

$GLOBALS['strSecurityUpdate']			= "
	<b>Dùraznì doporuèujeme nainstalovat tuto aktualizaci co nejdøíve, proto¾e obsahuje nìkolik oprav
	bezpeènostních chyb.</b> Verze ".$phpAds_productname." kterou pou¾íváte mù¾e být citlivá ná rùzné 
	druhy útokù a zøejmì není bezpeèná. Pro více informací o tom jak provést aktualizaci si prosím 
	pøeètìte dokumentaci která je v ní¾e uvedených souborech.
";

$GLOBALS['strNotAbleToCheck']			= "
	<b>Proto¾e XML doplnìk není instalován na va¹em serveru, ".$phpAds_productname." není 
    schopen ovìøit zda jsou k dispozici aktualizace.</b>
";

$GLOBALS['strForUpdatesLookOnWebsite']	= "
	Pokud chcete vìdìt jestli je k dispozici novìj¹í verze tak nav¹tivte na¹e stránky.
";

$GLOBALS['strClickToVisitWebsite']		= "Kliknìte zde pro na¹e webové stránky";
$GLOBALS['strCurrentlyUsing'] 			= "V tuto chvíli pou¾íváte";
$GLOBALS['strRunningOn']				= "bì¾ící na";
$GLOBALS['strAndPlain']					= "a";


// Stats conversion
$GLOBALS['strConverting']			= "Probíhá pøevod";
$GLOBALS['strConvertingStats']			= "Pøevod statistik...";
$GLOBALS['strConvertStats']			= "Pøeveï statistiky";
$GLOBALS['strConvertAdViews']			= "Pøevedených zobrazení,";
$GLOBALS['strConvertAdClicks']			= "Pøevedených kliknutí...";
$GLOBALS['strConvertAdConversions']			= "Pøevedených prodejù..."; 
$GLOBALS['strConvertNothing']			= "Není nic k pøevodu...";
$GLOBALS['strConvertFinished']			= "Dokonèeno...";

$GLOBALS['strConvertExplaination']		= "
	V tuto chvíli pou¾íváte kompaktní formát statistik, ale stále máte nìkteré statsitiky <br>
	v datailním formátu. Dokud nebudou deatilní statistiky pøevedny do kompaktního formátu <br>
	nebudou zobrazovány pøi prohlí¾ení této stránky.  <br>
	Pøed pøevodem statistiky si zazálohujte databázi!  <br>
	Chcete pøevést deatilní statistiky do kompaktního formátu? <br>
";

$GLOBALS['strConvertingExplaination']		= "
	V¹echny zbývající detailní statistiky jsou pøevádìny do kompaktního formátu. <br>
	V závislosti na poètu impresí ulo¾ených v detailním formátu tato akce mù¾e trvat  <br>
	a¾ nìkolik minut. Prosím vyèkejte na ukonèení pøevodu ne¾ nav¹ívíte jiné stráky. <br>
	Ní¾e máte seznam v¹ech úprav provedených na databázi. <br>
";

$GLOBALS['strConvertFinishedExplaination']  	= "
	Pøevod zbývajících detailních statistik byl úspì¹ný a data by nyní mìla být <br>
	znovu pou¾itelná. Ní¾e máte seznam v¹ech úprav provedených na databázi. <br>
";


?>
