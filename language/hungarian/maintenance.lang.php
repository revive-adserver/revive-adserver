<?php // $Revision: 1.1.2.1 $

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2000-2005 by the phpAdsNew developers                  */
/* For more information visit: http://www.phpadsnew.com                 */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/


// Main strings
$GLOBALS['strChooseSection']			= "Szekció kiválasztása";


// Priority
$GLOBALS['strRecalculatePriority']		= "Prioritás újraszámolása";
$GLOBALS['strHighPriorityCampaigns']		= "Magas prioritású kampány";
$GLOBALS['strAdViewsAssigned']			= "Beosztott letöltés";
$GLOBALS['strLowPriorityCampaigns']		= "Alacsony prioritású kampány";
$GLOBALS['strPredictedAdViews']			= "Letöltések elõrejelzése";
$GLOBALS['strPriorityDaysRunning']		= "Jelenleg {days} napra vonatkozó statisztika áll rendelkezésre, melybõl a ".$phpAds_productname." meg tudja állapítani a napi elõrejelzést. ";
$GLOBALS['strPriorityBasedLastWeek']		= "Az elõrejelzés az e heti és a múlt heti adatok alapján történik. ";
$GLOBALS['strPriorityBasedLastDays']		= "Az elõrejelzés az elmúlt néhány nap alapján történik. ";
$GLOBALS['strPriorityBasedYesterday']		= "Az elõrejelzés a tegnapi adatok alapján történik. ";
$GLOBALS['strPriorityNoData']			= "Megbízható elõrejelzés készítéséhez kevés adat áll rendelkezésre a hirdetéskiszolgáló által ma létrehozandó kiadások számával kapcsolatban. Csak valós idejû statisztika lesz a prioritás beosztások alapja. ";
$GLOBALS['strPriorityEnoughAdViews']		= "Elegendõ kattintásnak kell lennie a megcélzott magas prioritású kampányok teljes kielégítéséhez. ";
$GLOBALS['strPriorityNotEnoughAdViews']		= "Nem világos, hogy elegendõ letöltés lesz-e ma szolgáltatva a megcélzott magas prioritású kampányok kielégítéséhez ";


// Banner cache
$GLOBALS['strRebuildBannerCache']		= "Reklám gyorsítótár újraépítése";
$GLOBALS['strBannerCacheExplaination']		= "
	A reklám gyorsítótár a reklámot megjelenítõ HTML-kód másolatát tartalmazza. A reklám gyorsítótár használatával fel lehet
	gyorsítani a reklámok továbbítását, mert a HTML-kódot nem kell a reklám minden továbbításakor generálni. Mivel a reklám
	gyorsítótár a ".$phpAds_productname."-ra és reklámaira mutató nehezen módosítható hivatkozásokat tartalmaz, a gyorsítótárat
	a ".$phpAds_productname." minden áthelyezésekor a webkiszolgáló egy másik helyére történõ áthelyezésekor frissíteni kell.
";


// Cache
$GLOBALS['strCache']			= "Továbbítás gyorsítótár";
$GLOBALS['strAge']				= "Kor";
$GLOBALS['strRebuildDeliveryCache']			= "Továbbítás gyorsítótár újraépítése";
$GLOBALS['strDeliveryCacheExplaination']		= "
	A továbbítás gyorsítótárral növelhetõ a reklámok továbbításának sebessége. A gyorsítótár tartalmazza mindazon
	reklámok másolatát, melyek kapcsolva vannak ahhoz a zónához, amelyik menti az adatbázis lekérdezések számát,
	mikor éppen továbbítja õket a felhasználónak. A gyorsítótár újraépítése minden olyan alkalommal megtörténik,
	mikor változtatás történik a zónában vagy annak reklámaiban, s lehet, hogy a gyorsítótár elavulttá válik.
	Emiatt a gyorsítótár újraépítése óránként automatikusan történik, de lehetõség van a kézi újraépítésre is.
";
$GLOBALS['strDeliveryCacheSharedMem']		= "
	Jelenleg az osztott memóriában történik a továbbítás gyorsítótár tárolása. 
";
$GLOBALS['strDeliveryCacheDatabase']		= "
	Jelenleg az adatbázisban történik a továbbítás gyorsítótár tárolása. 
";
$GLOBALS['strDeliveryCacheFiles']		= "
	A továbbítás gyorsítótár tárolása jelenleg több fájlban történik a kiszolgálón.
";


// Storage
$GLOBALS['strStorage']				= "Tárolás";
$GLOBALS['strMoveToDirectory']			= "Az adatbázisban tárolt képek áthelyezése egy könyvtárba";
$GLOBALS['strStorageExplaination']		= "
	A helyi reklámok által használt képek tárolása az adatbázisban vagy egy könyvtárban történik.
	Ha könyvtárban tárolja a képeket, akkor az adatbázis terhelése csökken, ami a sebesség megnövekedését
	jelenti.
";


// Storage
$GLOBALS['strStatisticsExplaination']		= "
	Ön engedélyezte a <i>tömör statisztikát</i>, viszont a régi statisztika még részletes formában
	létezik. Átalakítja az új tömörített formátumba a részletes statisztikát?
";


// Product Updates
$GLOBALS['strSearchingUpdates']			= "Frissítés keresése. Kis türelmet...";
$GLOBALS['strAvailableUpdates']			= "Létezõ frissítések";
$GLOBALS['strDownloadZip']			= "Letöltés (.zip)";
$GLOBALS['strDownloadGZip']			= "Letöltés (.tar.gz)";

$GLOBALS['strUpdateAlert']			= "Megjelent a ".$phpAds_productname." új verziója.                 \\n\\nSzeretne több információt megtudni \\nerrõl a frissítésrõl?";
$GLOBALS['strUpdateAlertSecurity']		= "Megjelent a ".$phpAds_productname." új verziója.                 \\n\\nMielõbbi frissítése erõsen ajánlott, \\nmert ez a verzió egy vagy több \\nbiztonsági javítást tartalmaz.";

$GLOBALS['strUpdateServerDown']			= "
    Ismeretlen okból kifolyólag nem lehet információhoz <br>
		jutni a lehetséges frissítésekrõl. Próbálkozzon késõbb.
";

$GLOBALS['strNoNewVersionAvailable']		= "
	Ön a ".$phpAds_productname." legújabb verzióját használja. Frissítés jelenleg nem áll rendelkezésre.
";

$GLOBALS['strNewVersionAvailable']		= "
	<b>Megjelent a ".$phpAds_productname." új verziója.</b><br> Ezt a frissítést érdemes telepíteni, 
	mert kijavítottunk benne néhány jelenleg létezõ problémát, s új funkciókkal is bõvítettük. A frissítésrõl
	az alábbi fájlokban közreadott dokumentációból tudhat meg többet.
";

$GLOBALS['strSecurityUpdate']			= "
	<b>A frissítés mielõbbi telepítése erõsen ajánlott, mert számos biztonsági javítást tartalmaz.</b>
	A ".$phpAds_productname." ön által jelenleg használt verziója bizonyos támadásokkal sebezhetõ, és
	lehet, hogy nem biztonságos. A frissítésrõl	az alábbi fájlokban közreadott dokumentációból tudhat 
	meg többet.
";

$GLOBALS['strNotAbleToCheck']			= "
	<b>Mivel az XML bõvítmény nem elérhetõ a kiszolgálón, a ".$phpAds_productname." nem tudja
	ellenõrizni, hogy jelent-e meg újabb verzió.</b>
";

$GLOBALS['strForUpdatesLookOnWebsite']	= "
	Ha szeretné megtudni, hogy jelent-e meg újabb verzió, kérjük, hogy látogasson el webhelyünkre.
";

$GLOBALS['strClickToVisitWebsite']		= "Kattintson ide a webhelyünk felkereséséhez";
$GLOBALS['strCurrentlyUsing'] 			= "Az ön által jelenleg használt verzió:";
$GLOBALS['strRunningOn']				= "rendszer:";
$GLOBALS['strAndPlain']					= "és";


// Stats conversion
$GLOBALS['strConverting']			= "Konvertálás";
$GLOBALS['strConvertingStats']			= "A statisztika konvertálása...";
$GLOBALS['strConvertStats']			= "A statisztika konvertálása";
$GLOBALS['strConvertAdViews']			= "Letöltések konvertálva";
$GLOBALS['strConvertAdClicks']			= "Letöltések konvertálva...";
$GLOBALS['strConvertNothing']			= "Nincs mit konvertálni...";
$GLOBALS['strConvertFinished']			= "Befejezve...";

$GLOBALS['strConvertExplaination']		= "
	Ön jelenleg a statisztika tárolásának tömörített formátumát használja, de még van <br>
	néhány részletes formátumú statisztika. Amíg nem alakítja át a részletes statisztikát <br>
	tömör formátumba, addig nem használhatja ezeknek az oldalaknak a megtekintésekor. <br>
	A statisztika konvertálása elõtt készítsen biztonsági másolatot az adatbázisról! <br>
	Kívánja a részletes statisztikát az új, tömör formátumba konvertálni? <br>
";

$GLOBALS['strConvertingExplaination']		= "
	Minden maradék részletes statisztika most átalakításra kerül az új, tömör formátumba. <br>
	Attól függõen, hogy hány lenyomat tárolása történik részletes formátumban, ez eltarthat <br>
	pár percig. Más oldalak felkeresése elõtt várja meg a konertálás befejezését. <br>
	Alább megtekintheti az adatbázisban történt módosítások naplóját. <br>
";

$GLOBALS['strConvertFinishedExplaination']  	= "
	A maradék részletes statisztika konvertálása sikerült, és az adatok mostmár <br>
	újra használhatóak. Alább megtekintheti az adatbázisban történt módosítások <br>
	naplóját.<br>
";


?>