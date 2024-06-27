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
$GLOBALS['strAppendCodes'] = "";

// Maintenance
$GLOBALS['strScheduledMaintenanceHasntRun'] = "";

$GLOBALS['strAutoMantenaceEnabledAndHasntRun'] = "";

$GLOBALS['strAutoMantenaceDisabledAndHasntRun'] = "";

$GLOBALS['strAutoMantenaceEnabledAndRunning'] = "";

$GLOBALS['strAutoMantenaceDisabledAndRunning'] = "";

$GLOBALS['strScheduledMantenaceRunning'] = "";

$GLOBALS['strAutomaticMaintenanceHasRun'] = "";

$GLOBALS['strAutoMantenaceEnabled'] = "";

// Priority
$GLOBALS['strRecalculatePriority'] = "Prioritás újraszámolása";

// Banner cache
$GLOBALS['strCheckBannerCache'] = "A banner gyorsítótár ellenőrzése";
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
$GLOBALS['strDeliveryCacheSharedMem'] = "	Jelenleg a megosztott memóriában tárolódik a kiszolgáló gyorsítótár.";
$GLOBALS['strDeliveryCacheDatabase'] = "	Jelenleg az adatbázisban tárolódik a kiszolgáló gyorsítótár.";
$GLOBALS['strDeliveryCacheFiles'] = "	Jelenleg a szerver több különböző fájljában tárolódik a kiszolgáló gyorsítótár.";

// Storage
$GLOBALS['strStorage'] = "Tárolás";
$GLOBALS['strMoveToDirectory'] = "Mozgassa az adatbázisban tárolt képeket egy könyvtárba";
$GLOBALS['strStorageExplaination'] = "	A helyi bannerek által használt képek az adatbázisban vagy helyi könyvtárban tárolódnak. Ha könyvtárban tárolja a képeket,
	akkor csökken az adatbázis terhelése és gyorsulást eredményez a kiszolgálásban.";

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
$GLOBALS['strSearchingUpdates'] = "Frissítések ellenőrzése folyamatban, kérjük várjon...";
$GLOBALS['strAvailableUpdates'] = "Elérhető frissítések";
$GLOBALS['strDownloadZip'] = "Letöltés (.zip)";
$GLOBALS['strDownloadGZip'] = "Letöltés (.tar.gz)";

$GLOBALS['strUpdateAlert'] = "{{PRODUCT_NAME}} egy új verziója elérhető.

Szeretnél több információt kapni
erről a frissítésről?";
$GLOBALS['strUpdateAlertSecurity'] = "{{PRODUCT_NAME}} egy új verziója elérhető.

A frissítés mielőbbi végrehajtása erősen ajánlott,
mert az új verzió egy vagy több biztonsági javítást is tartalmaz.";

$GLOBALS['strUpdateServerDown'] = "Valamilyen ismertlen okból nem sikerült ellenőrizni<br>az elérhető frissítéseket. Kérjük próbálja újra később!";

$GLOBALS['strNoNewVersionAvailable'] = "	{{PRODUCT_NAME}} a legfrissebb verzióban fut. Jelenleg nincs elérhető frissítés.";

$GLOBALS['strServerCommunicationError'] = "";

$GLOBALS['strCheckForUpdatesDisabled'] = "";

$GLOBALS['strNewVersionAvailable'] = "	<b>{{PRODUCT_NAME}} egy újabb verziója már elérhető.</b><br /> Az új verzió telepítése erősen ajánlott,
	mert kijavíthat néhány meglévő hibát és új funkciókat is tartalmaz. Ha több információt
	szeretne a frissítésről, akkor kérjük olvassa el dokumentációt, amit megtalál az alábbi fájlok között.";

$GLOBALS['strSecurityUpdate'] = "	<b>Az új verzió mielőbbi telepítése erősen ajánlott, mert az tartalmaz néhány
	biztonsági javítást.</b> Az {{PRODUCT_NAME}} Ön által használt verziója
	bizonyos támadásokkal szemben védtelen lehet és ezért nem biztonságos.
	Ha szeretne több információt a frissítésről, kérjük olvassa el a dokumentációt, amit megtalál az alábbi fájlok között.";

$GLOBALS['strNotAbleToCheck'] = "	<b>Mivel az XML kiterjesztés nem elérhető a szerveren, az {{PRODUCT_NAME}} nem tudja
   ellenőrizni, hogy elérhető-e újabb verzió.</b>";

$GLOBALS['strForUpdatesLookOnWebsite'] = "	Ha szeretné megtudni, hogy van-e elérhető frissítés, kérjük látogassa meg a honlapunkat.";

$GLOBALS['strClickToVisitWebsite'] = "Kattintson ide a honlapunk meglátogatásához!";
$GLOBALS['strCurrentlyUsing'] = "A jelenleg következőt használja:";
$GLOBALS['strRunningOn'] = "Futtatási környezet: ";
$GLOBALS['strAndPlain'] = ", ";

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
