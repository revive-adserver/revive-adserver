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

// Maintenance









// Priority
$GLOBALS['strRecalculatePriority'] = "Prioritás újraszámolása";
$GLOBALS['strHighPriorityCampaigns'] = "Magas prioritású kampány";
$GLOBALS['strAdViewsAssigned'] = "Beosztott letöltés";
$GLOBALS['strLowPriorityCampaigns'] = "Alacsony prioritású kampány";
$GLOBALS['strPredictedAdViews'] = "Letöltések előrejelzése";
$GLOBALS['strPriorityDaysRunning'] = "Jelenleg {days} napra vonatkozó statisztika áll rendelkezésre, melyből a {$PRODUCT_NAME} meg tudja állapítani a napi előrejelzést. ";
$GLOBALS['strPriorityBasedLastWeek'] = "Az előrejelzés az e heti és a múlt heti adatok alapján történik. ";
$GLOBALS['strPriorityBasedLastDays'] = "Az előrejelzés az elmúlt néhány nap alapján történik. ";
$GLOBALS['strPriorityBasedYesterday'] = "Az előrejelzés a tegnapi adatok alapján történik. ";
$GLOBALS['strPriorityNoData'] = "Megbízható előrejelzés készítéséhez kevés adat áll rendelkezésre a hirdetéskiszolgáló által ma létrehozandó kiadások számával kapcsolatban. Csak valós idejű statisztika lesz a prioritás beosztások alapja. ";
$GLOBALS['strPriorityEnoughAdViews'] = "Elegendő kattintásnak kell lennie a megcélzott magas prioritású kampányok teljes kielégítéséhez. ";
$GLOBALS['strPriorityNotEnoughAdViews'] = "Nem világos, hogy elegendő letöltés lesz-e ma szolgáltatva a megcélzott magas prioritású kampányok kielégítéséhez ";


// Banner cache
$GLOBALS['strCheckBannerCache'] = "A banner gyorsítótár ellenőrzése";
$GLOBALS['strRebuildBannerCache'] = "Reklám gyorsítótár újraépítése";
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
$GLOBALS['strAge'] = "Kor";
$GLOBALS['strDeliveryCacheSharedMem'] = "	Jelenleg a megosztott memóriában tárolódik a kiszolgáló gyorsítótár.";
$GLOBALS['strDeliveryCacheDatabase'] = "	Jelenleg az adatbázisban tárolódik a kiszolgáló gyorsítótár.";
$GLOBALS['strDeliveryCacheFiles'] = "	Jelenleg a szerver több különböző fájljában tárolódik a kiszolgáló gyorsítótár.";


// Storage
$GLOBALS['strStorage'] = "Tárolás";
$GLOBALS['strMoveToDirectory'] = "Mozgassa az adatbázisban tárolt képeket egy könyvtárba";
$GLOBALS['strStorageExplaination'] = "	A helyi bannerek által használt képek az adatbázisban vagy helyi könyvtárban tárolódnak. Ha könyvtárban tárolja a képeket,
	akkor csökken az adatbázis terhelése és gyorsulást eredményez a kiszolgálásban.";

// Encoding
$GLOBALS['strEncodingConvert'] = "Konvertál";


// Storage
$GLOBALS['strStatisticsExplaination'] = "	Ön engedélyezte a <i>tömör statisztikát</i>, viszont a régi statisztika még részletes formában
	létezik. �?talakítja az új tömörített formátumba a részletes statisztikát?";


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


// Stats conversion
$GLOBALS['strConverting'] = "Konvertálás";
$GLOBALS['strConvertingStats'] = "A statisztika konvertálása...";
$GLOBALS['strConvertStats'] = "A statisztika konvertálása";
$GLOBALS['strConvertAdViews'] = "Letöltések konvertálva";
$GLOBALS['strConvertAdClicks'] = "Letöltések konvertálva...";
$GLOBALS['strConvertNothing'] = "Nincs mit konvertálni...";
$GLOBALS['strConvertFinished'] = "Befejezve...";

$GLOBALS['strConvertExplaination'] = "	Ön jelenleg a statisztika tárolásának tömörített formátumát használja, de még van <br>
	néhány részletes formátumú statisztika. Amíg nem alakítja át a részletes statisztikát <br>
	tömör formátumba, addig nem használhatja ezeknek az oldalaknak a megtekintésekor. <br>
	A statisztika konvertálása előtt készítsen biztonsági másolatot az adatbázisról! <br>
	Kívánja a részletes statisztikát az új, tömör formátumba konvertálni? <br>";

$GLOBALS['strConvertingExplaination'] = "	Minden maradék részletes statisztika most átalakításra kerül az új, tömör formátumba. <br>
	Attól függően, hogy hány lenyomat tárolása történik részletes formátumban, ez eltarthat <br>
	pár percig. Más oldalak felkeresése előtt várja meg a konertálás befejezését. <br>
	Alább megtekintheti az adatbázisban történt módosítások naplóját. <br>";

$GLOBALS['strConvertFinishedExplaination'] = "	A maradék részletes statisztika konvertálása sikerült, és az adatok mostmár <br>
	újra használhatóak. Alább megtekintheti az adatbázisban történt módosítások <br>
	naplóját.<br>";

//  Maintenace

//  Deliver Limitations


//  Append codes


