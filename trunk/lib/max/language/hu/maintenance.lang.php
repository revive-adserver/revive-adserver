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
$GLOBALS['strChooseSection']			= "Szekció kiválasztása";


// Priority
$GLOBALS['strRecalculatePriority']		= "Prioritás újraszámolása";
$GLOBALS['strHighPriorityCampaigns']		= "Magas prioritású kampány";
$GLOBALS['strAdViewsAssigned']			= "Beosztott letöltés";
$GLOBALS['strLowPriorityCampaigns']		= "Alacsony prioritású kampány";
$GLOBALS['strPredictedAdViews']			= "Letöltések előrejelzése";
$GLOBALS['strPriorityDaysRunning']		= "Jelenleg {days} napra vonatkozó statisztika áll rendelkezésre, melyből a ".$phpAds_productname." meg tudja állapítani a napi előrejelzést. ";
$GLOBALS['strPriorityBasedLastWeek']		= "Az előrejelzés az e heti és a múlt heti adatok alapján történik. ";
$GLOBALS['strPriorityBasedLastDays']		= "Az előrejelzés az elmúlt néhány nap alapján történik. ";
$GLOBALS['strPriorityBasedYesterday']		= "Az előrejelzés a tegnapi adatok alapján történik. ";
$GLOBALS['strPriorityNoData']			= "Megbízható előrejelzés készítéséhez kevés adat áll rendelkezésre a hirdetéskiszolgáló által ma létrehozandó kiadások számával kapcsolatban. Csak valós idejű statisztika lesz a prioritás beosztások alapja. ";
$GLOBALS['strPriorityEnoughAdViews']		= "Elegendő kattintásnak kell lennie a megcélzott magas prioritású kampányok teljes kielégítéséhez. ";
$GLOBALS['strPriorityNotEnoughAdViews']		= "Nem világos, hogy elegendő letöltés lesz-e ma szolgáltatva a megcélzott magas prioritású kampányok kielégítéséhez ";


// Banner cache
$GLOBALS['strRebuildBannerCache']		= "Reklám gyorsítótár újraépítése";
$GLOBALS['strBannerCacheExplaination']		= "
	A reklám gyorsítótár a reklámot megjelenítő HTML-kód másolatát tartalmazza. A reklám gyorsítótár használatával fel lehet
	gyorsítani a reklámok továbbítását, mert a HTML-kódot nem kell a reklám minden továbbításakor generálni. Mivel a reklám
	gyorsítótár a ".$phpAds_productname."-ra és reklámaira mutató nehezen módosítható hivatkozásokat tartalmaz, a gyorsítótárat
	a ".$phpAds_productname." minden áthelyezésekor a webkiszolgáló egy másik helyére történő áthelyezésekor frissíteni kell.
";


// Cache
$GLOBALS['strCache']			= "Továbbítás gyorsítótár";
$GLOBALS['strAge']				= "Kor";
$GLOBALS['strRebuildDeliveryCache']			= "Továbbítás gyorsítótár újraépítése";
$GLOBALS['strDeliveryCacheExplaination']		= "
	A továbbítás gyorsítótárral növelhető a reklámok továbbításának sebessége. A gyorsítótár tartalmazza mindazon
	reklámok másolatát, melyek kapcsolva vannak ahhoz a zónához, amelyik menti az adatbázis lekérdezések számát,
	mikor éppen továbbítja őket a felhasználónak. A gyorsítótár újraépítése minden olyan alkalommal megtörténik,
	mikor változtatás történik a zónában vagy annak reklámaiban, s lehet, hogy a gyorsítótár elavulttá válik.
	Emiatt a gyorsítótár újraépítése óránként automatikusan történik, de lehetőség van a kézi újraépítésre is.
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
$GLOBALS['strAvailableUpdates']			= "Létező frissítések";
$GLOBALS['strDownloadZip']			= "Letöltés (.zip)";
$GLOBALS['strDownloadGZip']			= "Letöltés (.tar.gz)";

$GLOBALS['strUpdateAlert']			= "Megjelent a ".$phpAds_productname." új verziója.                 \\n\\nSzeretne több információt megtudni \\nerről a frissítésről?";
$GLOBALS['strUpdateAlertSecurity']		= "Megjelent a ".$phpAds_productname." új verziója.                 \\n\\nMielőbbi frissítése erősen ajánlott, \\nmert ez a verzió egy vagy több \\nbiztonsági javítást tartalmaz.";

$GLOBALS['strUpdateServerDown']			= "
    Ismeretlen okból kifolyólag nem lehet információhoz <br>
		jutni a lehetséges frissítésekről. Próbálkozzon később.
";

$GLOBALS['strNoNewVersionAvailable']		= "
	Ön a ".$phpAds_productname." legújabb verzióját használja. Frissítés jelenleg nem áll rendelkezésre.
";

$GLOBALS['strNewVersionAvailable']		= "
	<b>Megjelent a ".$phpAds_productname." új verziója.</b><br> Ezt a frissítést érdemes telepíteni,
	mert kijavítottunk benne néhány jelenleg létező problémát, s új funkciókkal is bővítettük. A frissítésről
	az alábbi fájlokban közreadott dokumentációból tudhat meg többet.
";

$GLOBALS['strSecurityUpdate']			= "
	<b>A frissítés mielőbbi telepítése erősen ajánlott, mert számos biztonsági javítást tartalmaz.</b>
	A ".$phpAds_productname." ön által jelenleg használt verziója bizonyos támadásokkal sebezhető, és
	lehet, hogy nem biztonságos. A frissítésről	az alábbi fájlokban közreadott dokumentációból tudhat
	meg többet.
";

$GLOBALS['strNotAbleToCheck']			= "
	<b>Mivel az XML bővítmény nem elérhető a kiszolgálón, a ".$phpAds_productname." nem tudja
	ellenőrizni, hogy jelent-e meg újabb verzió.</b>
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
	A statisztika konvertálása előtt készítsen biztonsági másolatot az adatbázisról! <br>
	Kívánja a részletes statisztikát az új, tömör formátumba konvertálni? <br>
";

$GLOBALS['strConvertingExplaination']		= "
	Minden maradék részletes statisztika most átalakításra kerül az új, tömör formátumba. <br>
	Attól függően, hogy hány lenyomat tárolása történik részletes formátumban, ez eltarthat <br>
	pár percig. Más oldalak felkeresése előtt várja meg a konertálás befejezését. <br>
	Alább megtekintheti az adatbázisban történt módosítások naplóját. <br>
";

$GLOBALS['strConvertFinishedExplaination']  	= "
	A maradék részletes statisztika konvertálása sikerült, és az adatok mostmár <br>
	újra használhatóak. Alább megtekintheti az adatbázisban történt módosítások <br>
	naplóját.<br>
";


?>