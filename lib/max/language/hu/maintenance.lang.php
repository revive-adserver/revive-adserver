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
$GLOBALS['strBannerCacheExplaination']		= "\n    Az adatbázis banner gyorsítótára a bannerek kiszolgálásának meggyorsítására szolgál<br />\n    Ez a gyorsítótár újraépítésre szorul amikor:\n    <ul>\n        <li>Az OpenX rendszer frissítésre kerül</li>\n        <li>Új szerverre kerül az OpenX rendszer</li>\n    </ul>\n";


// Cache
$GLOBALS['strCache']			= "Kiszolgáló gyorsítótár";
$GLOBALS['strAge']				= "Kor";
$GLOBALS['strRebuildDeliveryCache']			= "Az adatbázis banner gyorsítótár újraépítése";
$GLOBALS['strDeliveryCacheExplaination']		= "\n	A továbbítás gyorsítótárral növelhető a reklámok továbbításának sebessége. A gyorsítótár tartalmazza mindazon\n	reklámok másolatát, melyek kapcsolva vannak ahhoz a zónához, amelyik menti az adatbázis lekérdezések számát,\n	mikor éppen továbbítja őket a felhasználónak. A gyorsítótár újraépítése minden olyan alkalommal megtörténik,\n	mikor változtatás történik a zónában vagy annak reklámaiban, s lehet, hogy a gyorsítótár elavulttá válik.\n	Emiatt a gyorsítótár újraépítése óránként automatikusan történik, de lehetőség van a kézi újraépítésre is.\n";
$GLOBALS['strDeliveryCacheSharedMem']		= "\n	Jelenleg a megosztott memóriában tárolódik a kiszolgáló gyorsítótár.\n";
$GLOBALS['strDeliveryCacheDatabase']		= "\n	Jelenleg az adatbázisban tárolódik a kiszolgáló gyorsítótár.\n";
$GLOBALS['strDeliveryCacheFiles']		= "\n	Jelenleg a szerver több különböző fájljában tárolódik a kiszolgáló gyorsítótár.\n";


// Storage
$GLOBALS['strStorage']				= "Tárolás";
$GLOBALS['strMoveToDirectory']			= "Mozgassa az adatbázisban tárolt képeket egy könyvtárba";
$GLOBALS['strStorageExplaination']		= "\n	A helyi bannerek által használt képek az adatbázisban vagy helyi könyvtárban tárolódnak. Ha könyvtárban tárolja a képeket,\n	akkor csökken az adatbázis terhelése és gyorsulást eredményez a kiszolgálásban.\n";


// Storage
$GLOBALS['strStatisticsExplaination']		= "\n	Ön engedélyezte a <i>tömör statisztikát</i>, viszont a régi statisztika még részletes formában\n	létezik. Átalakítja az új tömörített formátumba a részletes statisztikát?\n";


// Product Updates
$GLOBALS['strSearchingUpdates']			= "Frissítések ellenőrzése folyamatban, kérjük várjon...";
$GLOBALS['strAvailableUpdates']			= "Elérhető frissítések";
$GLOBALS['strDownloadZip']			= "Letöltés (.zip)";
$GLOBALS['strDownloadGZip']			= "Letöltés (.tar.gz)";

$GLOBALS['strUpdateAlert']			= "". MAX_PRODUCT_NAME ." egy új verziója elérhető.                      \n\nSzeretnél több információt kapni\nerről a frissítésről?";
$GLOBALS['strUpdateAlertSecurity']		= "". MAX_PRODUCT_NAME ." egy új verziója elérhető.                 \n\nA frissítés mielőbbi végrehajtása erősen ajánlott, \nmert az új verzió egy vagy több biztonsági javítást is tartalmaz.";

$GLOBALS['strUpdateServerDown']			= "Valamilyen ismertlen okból nem sikerült ellenőrizni<br>az elérhető frissítéseket. Kérjük próbálja újra később!";

$GLOBALS['strNoNewVersionAvailable']		= "\n	". MAX_PRODUCT_NAME ." a legfrissebb verzióban fut. Jelenleg nincs elérhető frissítés.\n";

$GLOBALS['strNewVersionAvailable']		= "\n	<b>". MAX_PRODUCT_NAME ." egy újabb verziója már elérhető.</b><br /> Az új verzió telepítése erősen ajánlott,\n	mert kijavíthat néhány meglévő hibát és új funkciókat is tartalmaz. Ha több információt\n	szeretne a frissítésről, akkor kérjük olvassa el dokumentációt, amit megtalál az alábbi fájlok között.\n";

$GLOBALS['strSecurityUpdate']			= "\n	<b>Az új verzió mielőbbi telepítése erősen ajánlott, mert az tartalmaz néhány\n	biztonsági javítást.</b> Az ". MAX_PRODUCT_NAME ." Ön által használt verziója\n	bizonyos támadásokkal szemben védtelen lehet és ezért nem biztonságos.\n	Ha szeretne több információt a frissítésről, kérjük olvassa el a dokumentációt, amit megtalál az alábbi fájlok között.\n";

$GLOBALS['strNotAbleToCheck']			= "\n	<b>Mivel az XML kiterjesztés nem elérhető a szerveren, az ". MAX_PRODUCT_NAME ." nem tudja\n   ellenőrizni, hogy elérhető-e újabb verzió.</b>\n";

$GLOBALS['strForUpdatesLookOnWebsite']	= "\n	Ha szeretné megtudni, hogy van-e elérhető frissítés, kérjük látogassa meg a honlapunkat.\n";

$GLOBALS['strClickToVisitWebsite']		= "Kattintson ide a honlapunk meglátogatásához!";
$GLOBALS['strCurrentlyUsing'] 			= "A jelenleg következőt használja:";
$GLOBALS['strRunningOn']				= "Futtatási környezet: ";
$GLOBALS['strAndPlain']					= ", ";


// Stats conversion
$GLOBALS['strConverting']			= "Konvertálás";
$GLOBALS['strConvertingStats']			= "A statisztika konvertálása...";
$GLOBALS['strConvertStats']			= "A statisztika konvertálása";
$GLOBALS['strConvertAdViews']			= "Letöltések konvertálva";
$GLOBALS['strConvertAdClicks']			= "Letöltések konvertálva...";
$GLOBALS['strConvertNothing']			= "Nincs mit konvertálni...";
$GLOBALS['strConvertFinished']			= "Befejezve...";

$GLOBALS['strConvertExplaination']		= "\n	Ön jelenleg a statisztika tárolásának tömörített formátumát használja, de még van <br>\n	néhány részletes formátumú statisztika. Amíg nem alakítja át a részletes statisztikát <br>\n	tömör formátumba, addig nem használhatja ezeknek az oldalaknak a megtekintésekor. <br>\n	A statisztika konvertálása előtt készítsen biztonsági másolatot az adatbázisról! <br>\n	Kívánja a részletes statisztikát az új, tömör formátumba konvertálni? <br>\n";

$GLOBALS['strConvertingExplaination']		= "\n	Minden maradék részletes statisztika most átalakításra kerül az új, tömör formátumba. <br>\n	Attól függően, hogy hány lenyomat tárolása történik részletes formátumban, ez eltarthat <br>\n	pár percig. Más oldalak felkeresése előtt várja meg a konertálás befejezését. <br>\n	Alább megtekintheti az adatbázisban történt módosítások naplóját. <br>\n";

$GLOBALS['strConvertFinishedExplaination']  	= "\n	A maradék részletes statisztika konvertálása sikerült, és az adatok mostmár <br>\n	újra használhatóak. Alább megtekintheti az adatbázisban történt módosítások <br>\n	naplóját.<br>\n";




// Note: New translations not found in original lang files but found in CSV
$GLOBALS['strCheckBannerCache'] = "A banner gyorsítótár ellenőrzése";
$GLOBALS['strBannerCacheErrorsFound'] = "Az adatbázis banner gyorsítótár hibát talált. A hibás bannerek nem lesznek elérhetőek amíg manuálisan helyre nem állítják őket.";
$GLOBALS['strBannerCacheOK'] = "Az ellenőrzés nem talált hibát, az adatbázis banner gyorsítótár nem igényel frissítést.";
$GLOBALS['strBannerCacheDifferencesFound'] = "Az adatbázis banner gyorsítótár elavult és újraépítést igényel. Kattintson ide az automatikus frissítéshez.";
$GLOBALS['strBannerCacheRebuildButton'] = "Újraépítés";
$GLOBALS['strEncodingConvert'] = "Konvertál";
?>