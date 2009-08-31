<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2009 OpenX Limited                                     |
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

// Installer translation strings
$GLOBALS['strInstall']				= "Installálás";
$GLOBALS['strChooseInstallLanguage']		= "Válassza ki a telepítési folyamat nyelvét";
$GLOBALS['strLanguageSelection']		= "Nyelvválasztás";
$GLOBALS['strDatabaseSettings']			= "Adatbázis beállítások";
$GLOBALS['strAdminSettings']			= "Adminisztrátor beállítások";
$GLOBALS['strAdvancedSettings']			= "Haladó beállítások";
$GLOBALS['strOtherSettings']			= "Egyéb beállítások";

$GLOBALS['strWarning']				= "Figyelmeztetés";
$GLOBALS['strFatalError']			= "Végzetes hiba történt";
$GLOBALS['strUpdateError']			= "Hiba történt frissítés közben";
$GLOBALS['strUpdateDatabaseError']	= "Ismeretlen okból kifolyólag az adatbázis szerkezet frissítése nem sikerült. Végrehajtásának javasolt módja a <b>Frissítés újrapróbálására</b> kattintás, amivel megpróbálhatja kijavítani e lehetséges problémákat. Ha ön biztos abban, hogy ezek a hibák nincsenek kihatással a ".MAX_PRODUCT_NAME." működésére, akkor a <b>Hibák kihagyása</b> választásával folytathatja. Ezeknek a hibáknak a figyelmen kívül hagyása komoly problémákat okozhat, és nem ajánlott!";
$GLOBALS['strAlreadyInstalled']			= "Már telepítette a ".MAX_PRODUCT_NAME."-t erre a rendszerre. Ha be szeretné állítani, akkor váltson át a <a href='settings-index.php'>beállítások kezelőfelületre</a>";
$GLOBALS['strCouldNotConnectToDB']		= "Nem lehet kapcsolódni az adatbázishoz, ellenőrizze ismét az ön által megadott beállításokat";
$GLOBALS['strCreateTableTestFailed']		= "Az ön által megadott felhasználónak nincs joga létrehozni vagy frissíteni az adatbázis szerkezetet. Vegye fel a kapcsolatot az adatbázis adminisztrátorával.";
$GLOBALS['strUpdateTableTestFailed']		= "Az ön által megadott felhasználónak nincs joga frissíteni az adatbázis szerkezetet. Vegye fel a kapcsolatot az adatbázis adminisztrátorával.";
$GLOBALS['strTablePrefixInvalid']		= "A tábla előtag érvénytelen karaktert tartalmaz";
$GLOBALS['strTableInUse']			= "Az ön által megadott adatbázis már létezik a ".MAX_PRODUCT_NAME." számára. Használjon másik tábla előtagot, vagy olvassa el a kézikönyvben a frissítésre vonatkozó utasításokat.";
$GLOBALS['strTableWrongType']		= "A ".$phpAds_dbmsname." telepítés nem támogatja az ön által kiválasztott táblatípust.";
$GLOBALS['strMayNotFunction']			= "Folytatás előtt javítsa ki ezeket a lehetséges hibákat:";
$GLOBALS['strFixProblemsBefore']		= "Javítsa ki a következő objektumo(ka)t a ".MAX_PRODUCT_NAME." telepítése előtt. Ha kérdése van ezzel a hibaüzenettel kapcsolatban, akkor tanulmányozza az <i>Administrator guide</i> kézikönyvet, mely része az ön által letöltött csomagnak.";
$GLOBALS['strFixProblemsAfter']			= "Ha nem tudja kijavítani a fenti problémákat, akkor vegye fel a kapcsolatot annak a kiszolgálónak az adminisztrátorával, melyre a ".MAX_PRODUCT_NAME."-t próbálja telepíteni. A kiszolgáló adminisztrátora biztosan tud segíteni önnek.";
$GLOBALS['strIgnoreWarnings']			= "Figyelmeztetések mellőzése";
$GLOBALS['strWarningDBavailable']		= "Az ön által használt PHP-változat nem támogatja a kapcsolódást a ".$phpAds_dbmsname." adatbázis kiszolgálóhoz. Engedélyezze a PHP ".$phpAds_dbmsname." bővítményt, mielőtt folytatná.";
$GLOBALS['strWarningPHPversion']		= "A ".MAX_PRODUCT_NAME." megfelelő működéséhez PHP 4.0 vagy újabb szükséges. Ön jelenleg a {php_version}-s verziót használja.";
$GLOBALS['strWarningRegisterGlobals']		= "A register_globals PHP konfigurációs változónak engedélyezettnek kell lennie.";
$GLOBALS['strWarningMagicQuotesGPC']		= "A magic_quotes_gpc PHP konfigurációs változónak engedélyezettnek kell lennie.";
$GLOBALS['strWarningMagicQuotesRuntime']	= "A magic_quotes_runtime PHP konfigurációs változónak letiltottnak kell lennie.";
$GLOBALS['strWarningFileUploads']		= "A file_uploads  PHP konfigurációs változónak engedélyezettnek kell lennie.";
$GLOBALS['strWarningTrackVars']			= "A track_vars PHP konfigurációs változónak engedélyezettnek kell lennie.";
$GLOBALS['strWarningPREG']				= "Az ön által használt PHP-verzió nem rendelkezik PERL kompatibilis reguláris kifejezés támogatással. Engedélyezze a PREG kiterjesztést, mielőtt folytatná.";
$GLOBALS['strConfigLockedDetected']		="A ".MAX_PRODUCT_NAME." megállapította, hogy a kiszolgáló nem tud írni a <b>config.inc.php</b> fájlba. Csak a fájl engedélyeinek módosítása után folytathatja. Olvassa el a hozzá adott dokumentációban, ha nem tudja, hogyan kell.";
$GLOBALS['strCantUpdateDB']  			= "Az adatbázis jelenleg nem frissíthető. Ha a folytatás mellett dönt, akkor valamennyi reklám, statisztika és hirdető törlésre kerül.";
$GLOBALS['strIgnoreErrors']			= "Hibák kihagyása";
$GLOBALS['strRetryUpdate']			= "Frissítés ismétlése";
$GLOBALS['strTableNames']			= "Táblanevek";
$GLOBALS['strTablesPrefix']			= "Táblanevek előtagja";
$GLOBALS['strTablesType']			= "Tábla típusa";

$GLOBALS['strInstallWelcome']			= "Üdvözli a ".MAX_PRODUCT_NAME."";
$GLOBALS['strInstallMessage']			= "Mielőtt használatba venné, végezze el a ".MAX_PRODUCT_NAME." beállítását, és <br>hozza létre az adatbázist. A <b>Tovább</b> gombbal folytathatja.";
$GLOBALS['strInstallSuccess']			= "<b>A ".MAX_PRODUCT_NAME." telepítése ezzel befejeződött.</b><br><br>A ".MAX_PRODUCT_NAME." megfelelő működéséhez ellenőrizze\n               a karbantartás fájl óránkénti futtatásának végrehajtását. A dokumentációban több információt talál erről a témáról.\n						   <br><br>A <b>Tovább</b> gomb megnyomásával töltheti be Beállítások lapot, ahol elvégezheti\n							 a testreszabást. Miután elkészült, ne feledje el lezárni a config.inc.php fájlt, mert így\n							 megelőzheti a biztonsági sértéseket.";
$GLOBALS['strUpdateSuccess']			= "<b>A ".MAX_PRODUCT_NAME." frissítése sikerült.</b><br><br>A ".MAX_PRODUCT_NAME." megfelelő működése céljából ellenőrizze\n               azt is, hogy fut-e óránként a karbantartás fájl (előtte ez napontára volt állítva). A dokumentációban több információt talál erről a témáról.\n						   <br><br>A <b>Tovább</b> megnyomásával válthat át az adminisztrátor kezelőfelületre. Ne feledje el lezárni a config.inc.php fájlt, mert így\n							 megelőzheti a biztonsági sértéseket.";
$GLOBALS['strInstallNotSuccessful']		= "<b>A ".MAX_PRODUCT_NAME." telepítése nem sikerült.</b><br><br>A telepítési folyamat részét nem lehetett befejezni.\n						   Ezek a problémák valószínűleg csak ideiglenesek, ebben az esetben nyugodtan nyomja meg a <b>Tovább</b>t,\n							 és térjen vissza a telepítési folyamat első lépéséhez. Ha többet szeretni tudni arról, hogy mit jelent az alábbi\n							 hibaüzenet, és hogyan háríthatja el, akkor nézzen utána a dokumentációban.";
$GLOBALS['strErrorOccured']			= "A következő hiba történt:";
$GLOBALS['strErrorInstallDatabase']		= "Nem lehet létrehozni az adatbázis szerkezetet.";
$GLOBALS['strErrorInstallConfig']		= "Nem lehet frissíteni a konfigurációs fájlt vagy az adatbázist.";
$GLOBALS['strErrorInstallDbConnect']		= "Nem lehet kapcsolatot létesíteni az adatbázissal.";

$GLOBALS['strUrlPrefix']			= "Hivatkozás előtag";

$GLOBALS['strProceed']				= "Tovább >";
$GLOBALS['strInvalidUserPwd']			= "A felhasználónév vagy a jelszó érvénytelen";

$GLOBALS['strUpgrade']				= "Frissítés";
$GLOBALS['strSystemUpToDate']			= "A rendszer frissítése már megtörtént, jelenleg nincs szükség az aktualizálására. <br>A <b>Tovább</b> megnyomásával ugorjon a kezdőlapra.";
$GLOBALS['strSystemNeedsUpgrade']		= "A megfelelő működés céljából frissíteni kell az adatbázis szerkezetet és a konfigurációs fájlt. A <b>Tovább</b> megnyomásával indíthatja a frissítési folyamatot. <br><br>Attól függően, hogy melyik verzióról frissít, és mennyi statisztikát tárol már az adatbázisban, ez a folyamat az adatbázis kiszolgálót nagyon leterhelheti. Legyen türelemmel, a frissítés eltarthat néhány percig.";
$GLOBALS['strSystemUpgradeBusy']		= "A rendszer frissítése folyamatban. Kis türelmet...";
$GLOBALS['strSystemRebuildingCache']		= "A gyorsítótár újraépítése. Kis türelmet...";
$GLOBALS['strServiceUnavalable']		= "A szolgáltatás átmenetileg nem elérhető. A rendszer frissítése folyamatban";

$GLOBALS['strConfigNotWritable']		= "A config.inc.php fájl nem írható";





/*********************************************************/
/* Configuration translations                            */
/*********************************************************/

// Global
$GLOBALS['strChooseSection']			= "Válasszon szekciót";
$GLOBALS['strDayFullNames'][0] = "Vasárnap";
$GLOBALS['strDayFullNames'][1] = "Hétfő";
$GLOBALS['strDayFullNames'][2] = "Kedd";
$GLOBALS['strDayFullNames'][3] = "Szerda";
$GLOBALS['strDayFullNames'][4] = "Csütörtök";
$GLOBALS['strDayFullNames'][5] = "Péntek";
$GLOBALS['strDayFullNames'][6] = "Szombat";

$GLOBALS['strEditConfigNotPossible']   		= "Jelenleg nem lehet szerkeszteni minden beállítást, mert a konfigurációs fájl biztonsági okokból le lett zárva. Ha változtatásokat szeretne végrehajtani, lehetséges hogy először föl kell oldalnia a telepítéshez tartozó konfigurációs fájlokat. (Jogosultságot kell adnia a szoftvernek a beállítások elvégzéséhez.)";
$GLOBALS['strEditConfigPossible']		= "Jelenleg minden beállítás szerkeszthető, mert a konfigurációs fájl nincs lezárva, de ez biztonsági problémákhoz vezethet. Ha szeretné megvédeni a rendszerét, akkor érdemes lenne a telepítéshez tartozó konfigurációs fájlokat lezárnia.";



// Database
$GLOBALS['strDatabaseSettings']			= "Adatbázis beállításai";
$GLOBALS['strDatabaseServer']			= "Globális adatbázis szerver beállítások";
$GLOBALS['strDbLocal']				= "Kapcsolódás helyi kiszolgálóhoz szoftvercsatornával"; // Pg only
$GLOBALS['strDbHost']				= "Adatbázis kiszolgálóneve";
$GLOBALS['strDbPort']				= "Adatbázis port száma";
$GLOBALS['strDbUser']				= "Adatbázis felhasználói neve";
$GLOBALS['strDbPassword']			= "Adatbázis jelszó";
$GLOBALS['strDbName']				= "Adatbázis név";

$GLOBALS['strDatabaseOptimalisations']		= "Adatbázis optimalizációs beállítások";
$GLOBALS['strPersistentConnections']		= "�?llandó kapcsolat használata";
$GLOBALS['strInsertDelayed']			= "Késleltetett beszúrások használata";
$GLOBALS['strCompatibilityMode']		= "Adatbázis kompatibilitás mód használata";
$GLOBALS['strCantConnectToDb']			= "Nem sikerült kapcsolódni az adatbázishoz";



// Invocation and Delivery
$GLOBALS['strInvocationAndDelivery']		= "Követelés beállítások";

$GLOBALS['strAllowedInvocationTypes']		= "Megengedett követelés típusok";
$GLOBALS['strAllowRemoteInvocation']		= "Távhívás engedélyezése";
$GLOBALS['strAllowRemoteJavascript']		= "Távhívás JavaScripthez engedélyezése";
$GLOBALS['strAllowRemoteFrames']		= "Távhívás keretekhez engedélyezése";
$GLOBALS['strAllowRemoteXMLRPC']		= "Távhívás XML-RPC használatával engedélyezése";
$GLOBALS['strAllowLocalmode']			= "Helyi mód engedélyezése";
$GLOBALS['strAllowInterstitial']		= "Interstíciós ablakok engedélyezése";
$GLOBALS['strAllowPopups']			= "Felbukkanó ablakok engedélyezése";

$GLOBALS['strUseAcl']				= "A továbbítási korlátozások kiértékelése továbbítás közben";

$GLOBALS['strDeliverySettings']			= "Kézbesítési beállítások";
$GLOBALS['strCacheType']				= "Továbbítás gyorsítótár típusa";
$GLOBALS['strCacheFiles']				= "Fájl";
$GLOBALS['strCacheDatabase']			= "Adatbázis";
$GLOBALS['strCacheShmop']				= "Osztott memória/Shmop";
$GLOBALS['strCacheSysvshm']				= "Osztott memória/Sysvshm";
$GLOBALS['strExperimental']				= "Kísérleti";
$GLOBALS['strKeywordRetrieval']			= "Kulcsszó visszakeresés";
$GLOBALS['strBannerRetrieval']			= "Reklám visszakeresési mód";
$GLOBALS['strRetrieveRandom']			= "Véletlenszerű reklám visszakeresés (alapértelmezett)";
$GLOBALS['strRetrieveNormalSeq']		= "Normál soros reklám viszakeresés";
$GLOBALS['strWeightSeq']			= "Fontosságon alapuló soros reklám visszakeresés";
$GLOBALS['strFullSeq']				= "Teljes soros reklám visszakeresés";
$GLOBALS['strUseConditionalKeys']		= "Logikai műveleti jelek engedélyezése a közvetlen kiválasztás használatakor";
$GLOBALS['strUseMultipleKeys']			= "Több kulcsszó engedélyezése a közvetlen kiválasztás használatakor";

$GLOBALS['strZonesSettings']			= "Zóna visszakeresése";
$GLOBALS['strZoneCache']			= "Zónák gyorsítótárazása, ez felgyorsíthat dolgokat a zónák használatakor";
$GLOBALS['strZoneCacheLimit']			= "A gyorsítótár két frissítése közti idő (másodpercben)";
$GLOBALS['strZoneCacheLimitErr']		= "A gyorsítótár két frissítése közti idő pozitív egész szám legyen";

$GLOBALS['strP3PSettings']			= "P3P adatvédelmi irányelvek";
$GLOBALS['strUseP3P']				= "P3P irányelvek használata";
$GLOBALS['strP3PCompactPolicy']			= "P3P tömörített irányelv";
$GLOBALS['strP3PPolicyLocation']		= "P3P irányelvek helye";



// Banner Settings
$GLOBALS['strBannerSettings']			= "Banner beállítások";

$GLOBALS['strAllowedBannerTypes']		= "Megengedett banner típusok";
$GLOBALS['strTypeSqlAllow']			= "Helyi SQL bannerek engedélyezése";
$GLOBALS['strTypeWebAllow']			= "Helyi webszerver bannerek engedélyezése";
$GLOBALS['strTypeUrlAllow']			= "Külső bannerek engedélyezése";
$GLOBALS['strTypeHtmlAllow']			= "HTML bannerek engedélyezése";
$GLOBALS['strTypeTxtAllow']			= "Szöveges hirdetések engedélyezése";

$GLOBALS['strTypeWebSettings']			= "Webszerver helyi banner tárolásának beállításai";
$GLOBALS['strTypeWebMode']			= "Tárolási mód";
$GLOBALS['strTypeWebModeLocal']			= "Helyi könyvtár";
$GLOBALS['strTypeWebModeFtp']			= "Külső FTP szerver";
$GLOBALS['strTypeWebDir']			= "Helyi könyvtár";
$GLOBALS['strTypeWebFtp']			= "FTP-módú webreklámkiszolgáló";
$GLOBALS['strTypeWebUrl']			= "Nyilvános hivatkozás";
$GLOBALS['strTypeFTPHost']			= "FTP kiszolgáló";
$GLOBALS['strTypeFTPDirectory']			= "Kiszolgáló könyvtár";
$GLOBALS['strTypeFTPUsername']			= "Login név (FTP felhasználó)";
$GLOBALS['strTypeFTPPassword']			= "Jelszó";
$GLOBALS['strTypeFTPErrorDir']			= "Az FTP kiszolgáló könyvtár nem létezik";
$GLOBALS['strTypeFTPErrorConnect']		= "Nem sikerült kapcsolódni az FTP szerverhez, a login név vagy a jelszó nem megfelelő";
$GLOBALS['strTypeFTPErrorHost']			= "Az FTP kiszolgáló nem megfelelő";
$GLOBALS['strTypeDirError']				= "A helyi könyvtár a webszerver számára nem írható";



$GLOBALS['strDefaultBanners']			= "Alapértelmezett bannerek";
$GLOBALS['strDefaultBannerUrl']			= "Alapértelmezett kép URL";
$GLOBALS['strDefaultBannerTarget']		= "Alapértelmezett cél hivatkozás";

$GLOBALS['strTypeHtmlSettings']			= "HTML banner beállítások";
$GLOBALS['strTypeHtmlAuto']			= "A HTML bannerek automatikus módosítása a kattintás-követés elérhetővé tétetele érdekében";
$GLOBALS['strTypeHtmlPhp']			= "A PHP-leírások HTML-reklámból történő végrehajtásának engedélyezése";



// Host information and Geotargeting
$GLOBALS['strHostAndGeo']				= "�?llomás információja és geotargeting";

$GLOBALS['strRemoteHost']				= "Távoli állomás";
$GLOBALS['strReverseLookup']			= "Látogató kiszolgálónevének visszakeresése ha nincs megadva";
$GLOBALS['strProxyLookup']				= "Valódi IP cím keresése amikor a látogató proxy szerver mögött van";

$GLOBALS['strGeotargeting']				= "Geotargeting beállítások";
$GLOBALS['strGeotrackingType']			= "A geotargeting adatbázis típusa";
$GLOBALS['strGeotrackingLocation'] 		= "A geotargeting adatbázis helye";
$GLOBALS['strGeotrackingLocationError'] = "A geotargeting adatbázis nem létezik az ön által megadott helyen";
$GLOBALS['strGeoStoreCookie']			= "Az eredmény tárolása cookie-ban a későbbi hivatkozás céljára";



// Statistics Settings
$GLOBALS['strStatisticsSettings']		= "Statisztikák és Karbantartási beállítások";

$GLOBALS['strStatisticsFormat']			= "Statisztika formátuma";
$GLOBALS['strCompactStats']				= "Statisztika formátuma";
$GLOBALS['strLogAdviews']				= "Letöltés naplózása a reklám minden továbbításakor";
$GLOBALS['strLogAdclicks']				= "Kattintás naplózása a felhasználó a reklámra történő minden kattintásakor";
$GLOBALS['strLogSource']				= "A hívás közben megadott forrás paraméter naplózása";
$GLOBALS['strGeoLogStats']				= "A látogató országának naplózása a statisztikában";
$GLOBALS['strLogHostnameOrIP']			= "A látogató állomásnevének vagy IP-címének naplózása";
$GLOBALS['strLogIPOnly']				= "Csak a látogató IP-címének naplózása, még ha az állomásnév ismert is";
$GLOBALS['strLogIP']					= "A látogató IP-címének naplózása";
$GLOBALS['strLogBeacon']				= "Kis jelzőkép használata a letöltések naplózásához a csak a továbbított reklámok naplózásának ellenőrzéséhez";

$GLOBALS['strRemoteHosts']				= "Távoli állomások";
$GLOBALS['strIgnoreHosts']				= "A következő IP címek és kiszolgálónevek kihagyása a naplózásból";
$GLOBALS['strBlockAdviews']				= "Nincs letöltés naplózás, ha a látogató már látta ugyanazt a reklámot a megadott másodperceken belül";
$GLOBALS['strBlockAdclicks']			= "Nincs kattintás naplózás, ha a látogató már rákattintott ugyanarra a reklámra a megadott másodperceken belül";


$GLOBALS['strPreventLogging']			= "Banner naplózás blokkolásának beállításai";
$GLOBALS['strEmailWarnings']			= "Email Figyelmeztetések";
$GLOBALS['strAdminEmailHeaders']		= "A következő fejlécek hozzáadása a ".MAX_PRODUCT_NAME." által küldött elektronikus üzenethez";
$GLOBALS['strWarnLimit']				= "Figyelmeztetés küldése ha a hátrelévő megtekintések száma kevesebb mint";
$GLOBALS['strWarnLimitErr']				= "Figyelmeztetési határ csak pozitív egész lehet";
$GLOBALS['strWarnAdmin']				= "Figyelmeztetés küldése az adminisztrátornak ha a kampány hamarosan lejár";
$GLOBALS['strWarnClient']				= "Figyelmeztetés küldése a hirdetőnek ha a kampány hamarosan lejár";
$GLOBALS['strQmailPatch']				= "A qmail folt engedélyezése";

$GLOBALS['strAutoCleanTables']			= "Adatbázis karbantartása";
$GLOBALS['strAutoCleanStats']			= "Statisztika kiürítése";
$GLOBALS['strAutoCleanUserlog']			= "Felhasználói napló kiürítése";
$GLOBALS['strAutoCleanStatsWeeks']		= "A statisztika maximális kora <br>(minimum 3 hét)";
$GLOBALS['strAutoCleanUserlogWeeks']	= "A felhasználói napló maximális <br>kora (minimum 3 hét)";
$GLOBALS['strAutoCleanErr']				= "A maximális kor legalább 3 hét legyen";
$GLOBALS['strAutoCleanVacuum']			= "A táblák V�?KUMOS ELEMZÉSE minden éjjel"; // only Pg


// Administrator settings
$GLOBALS['strAdministratorSettings']		= "Adminisztrátor beállítások";

$GLOBALS['strLoginCredentials']			= "Belépési adatok";
$GLOBALS['strAdminUsername']			= "Adminisztrátor  felhasználóneve";
$GLOBALS['strInvalidUsername']			= "Érvénytelen felhasználóinév";

$GLOBALS['strBasicInformation']			= "Alapinformációk";
$GLOBALS['strAdminFullName']			= "Admin teljes neve";
$GLOBALS['strAdminEmail']			= "Admin e-mail címe";
$GLOBALS['strCompanyName']			= "Szervezet neve";

$GLOBALS['strAdminCheckUpdates']		= "Frissítés keresése";
$GLOBALS['strAdminCheckEveryLogin']		= "Minden belépéskor";
$GLOBALS['strAdminCheckDaily']			= "Naponta";
$GLOBALS['strAdminCheckWeekly']			= "Hetente";
$GLOBALS['strAdminCheckMonthly']		= "Havonta";
$GLOBALS['strAdminCheckNever']			= "Soha";

$GLOBALS['strAdminNovice']			= "Biztonsági célból megerősítés szükséges az adminisztrátor törléseihez";
$GLOBALS['strUserlogEmail']			= "Kimenő e-mail üzenetek naplózása";
$GLOBALS['strUserlogPriority']			= "Óránkénti prioritás számítások naplózása";
$GLOBALS['strUserlogAutoClean']			= "Az adatbázis automatikus karbantartásának naplózása";


// User interface settings
$GLOBALS['strGuiSettings']			= "Felhasználói felület beállításai";

$GLOBALS['strGeneralSettings']			= "�?ltalános beállítások";
$GLOBALS['strAppName']				= "Alkalmazás neve";
$GLOBALS['strMyHeader']				= "Fejléc fájl helye";
$GLOBALS['strMyHeaderError']		= "Az Ön által megadott helyen nem található fejléc fájl";
$GLOBALS['strMyFooter']				= "Lábléc fájl helye";
$GLOBALS['strMyFooterError']		= "Az Ön által megadott helyen nem található lábléc fájl";
$GLOBALS['strGzipContentCompression']		= "GZIP tartalom tömörítés használata";

$GLOBALS['strClientInterface']			= "Hirdetői felület";
$GLOBALS['strClientWelcomeEnabled']		= "Hirdető üdvözlő üzenet engedélyezése";
$GLOBALS['strClientWelcomeText']		= "Üdvözlő szöveg<br />(HTML tagek használata megengedett)";



// Interface defaults
$GLOBALS['strInterfaceDefaults']		= "Felület alapértelmezések";

$GLOBALS['strInventory']			= "Leltár";
$GLOBALS['strShowCampaignInfo']			= "Extra kampány info megjelenítése a <i>Kampány áttekintés</i> oldalon";
$GLOBALS['strShowBannerInfo']			= "Extra banner info megjelenítése a <i>Banner áttekintés</i> oldalon";
$GLOBALS['strShowCampaignPreview']		= "Minden banner megjelenítése a <i>Banner áttekintés</i> oldalon";
$GLOBALS['strShowBannerHTML']			= "A HTML code helyett a tényleges banner megmutatása a HTML bannerek megjelenítésekor";
$GLOBALS['strShowBannerPreview']		= "Bannerek megjelenítése a kapcsolódó oldalak tetején";
$GLOBALS['strHideInactive']			= "Az inaktív objektumok elrejtése az áttekintéses oldalakról";
$GLOBALS['strGUIShowMatchingBanners']		= "Egyező bannerek megjelenítése a <i>Linkelt banner</i> oldalakon";
$GLOBALS['strGUIShowParentCampaigns']		= "Szülő kampányok megjelenítése a <i>Linkelt banner</i> oldalakon";
$GLOBALS['strGUILinkCompactLimit']		= "A nem kapcsolt kampányok vagy reklámok elrejtése a <i>Kapcsolt reklám</i> oldalakon, ha nincs több, mint";

$GLOBALS['strStatisticsDefaults'] 		= "Statisztikák";
$GLOBALS['strBeginOfWeek']			= "Hét kezdete";
$GLOBALS['strPercentageDecimals']		= "Százalékok tört része";

$GLOBALS['strWeightDefaults']			= "Alapértelmezett súly";
$GLOBALS['strDefaultBannerWeight']		= "Alapértelmezett banner súly";
$GLOBALS['strDefaultCampaignWeight']		= "Alapértelmezett kampány súly";
$GLOBALS['strDefaultBannerWErr']		= "Az alapértelmezett reklám fontosság pozitív egész szám legyen";
$GLOBALS['strDefaultCampaignWErr']		= "Az alapértelmezett kampány fontosság pozitív egész szám legyen";



// Not used at the moment
$GLOBALS['strTableBorderColor']			= "Táblázatszegély színe";
$GLOBALS['strTableBackColor']			= "Táblázatháttér színer";
$GLOBALS['strTableBackColorAlt']		= "Táblázatháttér színe (választható)";
$GLOBALS['strMainBackColor']			= "Fő háttérszín";
$GLOBALS['strOverrideGD']			= "A GD képformátum hatálytalanítása";
$GLOBALS['strTimeZone']				= "Időzóna";



// Note: New translations not found in original lang files but found in CSV
$GLOBALS['strHasTaxID'] = "Adó azonosító";
$GLOBALS['strAdminAccount'] = "Adminisztrátor";
$GLOBALS['strSpecifySyncSettings'] = "Szinkronizációs beállítások";
$GLOBALS['strOpenadsIdYour'] = "Az Ön OpenX azonosítója";
$GLOBALS['strOpenadsIdSettings'] = "OpenX azonosító beállítások";
$GLOBALS['strBtnContinue'] = "Folytatás »";
$GLOBALS['strBtnRecover'] = "Visszaállítás »";
$GLOBALS['strBtnStartAgain'] = "Újraépítés újrakezdése »";
$GLOBALS['strBtnGoBack'] = "« Vissza";
$GLOBALS['strBtnAgree'] = "Elfogadom »";
$GLOBALS['strBtnRetry'] = "Újrapróbál";
$GLOBALS['strFixErrorsBeforeContinuing'] = "Kérjük javítson ki minden hibát a folytatás előtt!";
$GLOBALS['strWarningRegisterArgcArv'] = "A register_argc_argv PHP konfigurációs változót be kell kapcsolni hogy a parancssorból el lehessen végezni a karbantartást.";
$GLOBALS['strRecoveryRequiredTitle'] = "Az előző újraépítési kísérlete során hiba történt";
$GLOBALS['strRecoveryRequired'] = "Az előző frissítés során hiba történt és az ". MAX_PRODUCT_NAME ."nek most meg kell próbálnia visszaállítani a frissítés előtti állapotot. Kattintson a Visszaállítás gombra!";
$GLOBALS['strDbSetupTitle'] = "Adatbázis beállítások";
$GLOBALS['strOaUpToDate'] = "Az ". MAX_PRODUCT_NAME ." adatbázis és fájlstruktúra a lehető legfrissebb verziót használja, így nincs szükség újraépítésre. Kérjük kattintson a Folytatásra, hogy az ". MAX_PRODUCT_NAME ." adminisztrációs felületre irányíthassuk!";
$GLOBALS['strOaUpToDateCantRemove'] = "Figyelmeztetés: Az UPGRADE fájl még mindig a var könyvtárban van. Nem sikerült automatikusan eltávolítani a fájlt, mert a fájlra vonatkozó engedélyezések nem tették lehetővé. Kérjük törölje a fájlt manuálisan!";
$GLOBALS['strRemoveUpgradeFile'] = "Az UPGRADE fájlt el kell távolítania a var könyvtárból!";
$GLOBALS['strSystemCheck'] = "Rendszer ellenőrzés";
$GLOBALS['strDbSuccessIntro'] = "Az ". MAX_PRODUCT_NAME ." adatbázis frissítése megtörtént. Kérjük kattintson a 'Folytatás' gombra az ". MAX_PRODUCT_NAME ." Adminisztrátor és Kiszolgálás beállításainak megtekintéséhez.";
$GLOBALS['strErrorWritePermissions'] = "Fájl engedélyezési hibákat észleltünk, amiket meg kell oldani a folytatás előtt.<br />A hibák kijavításához Linux rendszeren a következő parancs(ok) beírását érdemes megpróbálni:";
$GLOBALS['strErrorFixPermissionsCommand'] = "<i>chmod a+w %s</i>";
$GLOBALS['strErrorWritePermissionsWin'] = "Fájl engedélyezési hibákat észleltünk, amiket meg kell oldani a folytatás előtt.";
$GLOBALS['strCheckDocumentation'] = "További segítséghez kérjük nézze meg az <a href='http://". OX_PRODUCT_DOCSURL ."'>". MAX_PRODUCT_NAME ." dokumentációt<a/>.";
$GLOBALS['strAdminUrlPrefix'] = "Az Adminisztrációs Felület URL-je";
$GLOBALS['strDeliveryUrlPrefix'] = "A Kiszolgáló Motor URL-je";
$GLOBALS['strDeliveryUrlPrefixSSL'] = "A Kiszoláló Motor URL-je (SSL)";
$GLOBALS['strImagesUrlPrefix'] = "A Kép Tár URL-je";
$GLOBALS['strImagesUrlPrefixSSL'] = "A Kép Tár URL-je (SSL)";
$GLOBALS['strUnableToWriteConfig'] = "A konfigurációs fájl írása sikertelen";
$GLOBALS['strUnableToWritePrefs'] = "A beállítás adatbázisba írása sikertelen";
$GLOBALS['strImageDirLockedDetected'] = "A kiszolgáló nem tudja írnia a megadott <b>Képek Könyvtárt</b>. <br>Addig nem tud továbblépni, amíg vagy meg nem változtatja a beállításokat vagy létre nem hozza a könyvtárat.";
$GLOBALS['strConfigurationSettings'] = "Konfiguráció beállítása";
$GLOBALS['strAdminPassword'] = "Adminisztrátor  jelszava";
$GLOBALS['strAdministratorEmail'] = "Adminisztrátor e-mail címe";
$GLOBALS['strTimezone'] = "Időzóna";
$GLOBALS['strTimezoneEstimated'] = "Becsült időzóna";
$GLOBALS['strTimezoneGuessedValue'] = "A szerver időzónája nincs megfelelően beállítva a PHP-ben";
$GLOBALS['strTimezoneSeeDocs'] = "Ennek a PHP változónak a beállításáról további információt találsz itt: %DOCS%";
$GLOBALS['strTimezoneDocumentation'] = "dokumentáció";
$GLOBALS['strLoginSettingsTitle'] = "Adminisztrátori belépés";
$GLOBALS['strLoginSettingsIntro'] = "Kérjük addja meg az ". MAX_PRODUCT_NAME ." adminisztrátor felhasználó belépési adatait a frissítés folytatásához!  Adminisztrátor felhasználóként kell belépnie a frissítés végrehajtásához.";
$GLOBALS['strEnableAutoMaintenance'] = "Automatikusan fusson le a karbantartó eljárás a kiszolgáláskor, ha nincs beállítva a karbantartás ütemterve. ";
$GLOBALS['strDbType'] = "Adatbázis típusa";
$GLOBALS['strDemoDataInstall'] = "Demo adatok telepítése";
$GLOBALS['strDemoDataIntro'] = "Alapértelmezett adatokkal lehet feltölteni az ". MAX_PRODUCT_NAME ." adatbázisát, hogy segítse az online hirdetések kiszolgálásának megkezdését. A legelterjedtebb banner típusok és néhány kezdeti kampány kerül ezzel betöltésre és előre beállításra. Használata erősen ajánlott az új telepítésekhez.";
$GLOBALS['strDebug'] = "Hibakereső naplózázás beállításai";
$GLOBALS['strProduction'] = "Publikus szerver";
$GLOBALS['strEnableDebug'] = "Hibakereső naplózás engedélyezése";
$GLOBALS['strDebugMethodNames'] = "Eljárásnevek hozzáadása a hibereső naplózáshoz";
$GLOBALS['strDebugLineNumbers'] = "Naplózott sorok sorszámának hozzáadása a hibakereső naplózáshoz";
$GLOBALS['strDebugType'] = "Hibakereső napló típusa";
$GLOBALS['strDebugTypeFile'] = "Fájl";
$GLOBALS['strDebugTypeMcal'] = "mCal";
$GLOBALS['strDebugTypeSql'] = "SQL adatbázis";
$GLOBALS['strDebugTypeSyslog'] = "Syslog";
$GLOBALS['strDebugName'] = "Hibakereső napló név, naptár, SQL tábla,<br />vagy Syslog Facility";
$GLOBALS['strDebugPriority'] = "Hibakereső prioritási szint";
$GLOBALS['strPEAR_LOG_DEBUG'] = "PEAR_LOG_DEBUG - Az elérhető legtöbb információ";
$GLOBALS['strPEAR_LOG_INFO'] = "PEAR_LOG_INFO - Alapértelmezett információmennyiség";
$GLOBALS['strPEAR_LOG_NOTICE'] = "PEAR_LOG_NOTICE";
$GLOBALS['strPEAR_LOG_WARNING'] = "PEAR_LOG_WARNING";
$GLOBALS['strPEAR_LOG_ERR'] = "PEAR_LOG_ERR";
$GLOBALS['strPEAR_LOG_CRIT'] = "PEAR_LOG_CRIT";
$GLOBALS['strPEAR_LOG_ALERT'] = "PEAR_LOG_ALERT";
$GLOBALS['strPEAR_LOG_EMERG'] = "PEAR_LOG_EMERG - Minimális információ";
$GLOBALS['strDebugIdent'] = "Azonosító sztring hibakeresése";
$GLOBALS['strDebugUsername'] = "mCal, SQL szerver felhasználóinév";
$GLOBALS['strDebugPassword'] = "mCal, SQL szerver jelszó";
$GLOBALS['strWebPath'] = "". MAX_PRODUCT_NAME ." Szerver hozzáférési utak";
$GLOBALS['strWebPathSimple'] = "Webes elérési út";
$GLOBALS['strDeliveryPath'] = "Kézbesítés elérési útja";
$GLOBALS['strImagePath'] = "Képek elérési útja";
$GLOBALS['strDeliverySslPath'] = "Kézbesítés SSL elérési útja";
$GLOBALS['strImageSslPath'] = "Képek SSL elérési útja";
$GLOBALS['strImageStore'] = "Képek könyvtár";
$GLOBALS['strTypeFTPPassive'] = "Passzív kapcsolat használata";
$GLOBALS['strDeliveryFilenames'] = "Kézbesítendő fájl nevek";
$GLOBALS['strDeliveryFilenamesAdClick'] = "Hirdetés kattintás";
$GLOBALS['strDeliveryFilenamesAdConversionVars'] = "Hirdetés változó behelyettesítés";
$GLOBALS['strDeliveryFilenamesAdContent'] = "Hirdetés tartalom";
$GLOBALS['strDeliveryFilenamesAdConversion'] = "Hirdetés behelyettesítés";
$GLOBALS['strDeliveryFilenamesAdConversionJS'] = "Hirdetés behelyettesítés (JavaScript)";
$GLOBALS['strDeliveryFilenamesAdFrame'] = "Hirdetési keret";
$GLOBALS['strDeliveryFilenamesAdImage'] = "Hirdetési kép";
$GLOBALS['strDeliveryFilenamesAdJS'] = "Hirdetés (JavaScript)";
$GLOBALS['strDeliveryFilenamesAdLayer'] = "Hirdetési réteg";
$GLOBALS['strDeliveryFilenamesAdLog'] = "Hirdetési napló";
$GLOBALS['strDeliveryFilenamesAdPopup'] = "Hirdetés popup";
$GLOBALS['strDeliveryFilenamesAdView'] = "Hirdetés megtekintés";
$GLOBALS['strDeliveryFilenamesXMLRPC'] = "XML RPC kérés";
$GLOBALS['strDeliveryFilenamesLocal'] = "Helyi kérés";
$GLOBALS['strDeliveryFilenamesFrontController'] = "Front Controller";
$GLOBALS['strDeliveryFilenamesFlash'] = "Flash beágyazás (teljes URL cím is lehet)";
$GLOBALS['strDeliveryCaching'] = "Banner kézbesítési gyorsítótár beállításai";
$GLOBALS['strDeliveryCacheLimit'] = "A banner gyorsítótár frissítései közti idő (másodpercekben)";
$GLOBALS['strOrigin'] = "Távoli eredet szerver használata";
$GLOBALS['strOriginType'] = "Eredet szerver típusa";
$GLOBALS['strOriginHost'] = "Eredet szerver kiszolgálói neve";
$GLOBALS['strOriginPort'] = "Eredet adatbázis port száma";
$GLOBALS['strOriginScript'] = "Eredet adatbázis script fájlja";
$GLOBALS['strOriginTypeXMLRPC'] = "XMLRPC";
$GLOBALS['strOriginTimeout'] = "Eredet időtúllépés (másodpercekben)";
$GLOBALS['strOriginProtocol'] = "Eredet szerver protokol";
$GLOBALS['strDeliveryAcls'] = "Banner kézbesítési korlátozások megbecslése kézbesítés közben.";
$GLOBALS['strDeliveryObfuscate'] = "Csatornazavarás a hirdetések kézbesítése közben";
$GLOBALS['strDeliveryExecPhp'] = "PHP kódok futtatásának engedélyezése a hirdetésekben<br />(Figyelem: Biztonsági kockázat)";
$GLOBALS['strDeliveryCtDelimiter'] = "Harmadik féltől származó kattintás követési határolójel";
$GLOBALS['strGeotargetingSettings'] = "Geotargeting beállítások";
$GLOBALS['strGeotargetingType'] = "Geotargeting modul típus";
$GLOBALS['strGeotargetingGeoipCountryLocation'] = "MaxMind GeoIP ország adatbázis helye";
$GLOBALS['strGeotargetingGeoipRegionLocation'] = "MaxMind GeoIP régió adatbázis helye";
$GLOBALS['strGeotargetingGeoipCityLocation'] = "MaxMind GeoIP város adatbázis helye";
$GLOBALS['strGeotargetingGeoipAreaLocation'] = "MaxMind GeoIP terület adatbázis helye";
$GLOBALS['strGeotargetingGeoipDmaLocation'] = "MaxMind GeoIP DMA adatbázis helye";
$GLOBALS['strGeotargetingGeoipOrgLocation'] = "MaxMind GeoIP szervezet adatbázis helye";
$GLOBALS['strGeotargetingGeoipIspLocation'] = "MaxMind GeoIP ISP adatbázis helye";
$GLOBALS['strGeotargetingGeoipNetspeedLocation'] = "MaxMind GeoIP internetsebesség adatbázis helye";
$GLOBALS['strGeoSaveStats'] = "GeoIP adatok mentése az adatbázis naplókba";
$GLOBALS['strGeoShowUnavailable'] = "Geotargeting kézbesítési korlátok mutatása a GeoIP adatok elérhetetlensége esetén";
$GLOBALS['strGeotrackingGeoipCountryLocationError'] = "A MaxMind GeoIP ország adatbázis nem elérhető a megadott helyen";
$GLOBALS['strGeotrackingGeoipRegionLocationError'] = "A MaxMind GeoIP régió adatbázis nem elérhető a megadott helyen";
$GLOBALS['strGeotrackingGeoipCityLocationError'] = "A MaxMind GeoIP város adatbázis nem elérhető a megadott helyen";
$GLOBALS['strGeotrackingGeoipAreaLocationError'] = "A MaxMind GeoIP terület adatbázis nem elérhető a megadott helyen";
$GLOBALS['strGeotrackingGeoipDmaLocationError'] = "A MaxMind GeoIP DMA adatbázis nem elérhető a megadott helyen";
$GLOBALS['strGeotrackingGeoipOrgLocationError'] = "A MaxMind GeoIP szervezet adatbázis nem elérhető a megadott helyen";
$GLOBALS['strGeotrackingGeoipIspLocationError'] = "A MaxMind GeoIP ISP adatbázis nem elérhető a megadott helyen";
$GLOBALS['strGeotrackingGeoipNetspeedLocationError'] = "A MaxMind GeoIP internet sebesség adatbázis nem elérhető a megadott helyen";
$GLOBALS['strGUIAnonymousCampaignsByDefault'] = "Kampányok alapértelmezése Anonymousként";
$GLOBALS['strPublisherDefaults'] = "Weboldal alapértelmezések";
$GLOBALS['strModesOfPayment'] = "Fizetési módok";
$GLOBALS['strCurrencies'] = "Valuták";
$GLOBALS['strCategories'] = "Kategóriák";
$GLOBALS['strHelpFiles'] = "Súgó fájlok";
$GLOBALS['strDefaultApproved'] = "Jóváhagyott választónégyzet";
$GLOBALS['strEnable3rdPartyTrackingByDefault'] = "Harmadik fél által készített kattintáskövetés alapértelmezettként";
$GLOBALS['strCsvImport'] = "Offline konverziók feltöltésének engedélyezése";
$GLOBALS['strLogAdRequests'] = "Minden banner lekérés naplózása";
$GLOBALS['strLogAdImpressions'] = "Minden banner megtekintés naplózása";
$GLOBALS['strLogAdClicks'] = "Minden kattintás naplózása amikor a látogató a bannerre kattint";
$GLOBALS['strBlockAdViews'] = "Hirdetés megtekintés számlálásának kihagyása ha a látogató látta az adott hírdetés/zóna párt a megadott időn belül (másodpercben)";
$GLOBALS['strBlockAdViewsError'] = "A hírdetés megtekintés blokkolás értéke csak nem negatív egész lehet";
$GLOBALS['strBlockAdClicks'] = "Hírdetés kattintás számlálásának kihagyása ha a látogató kattintott az adott hírdetés/zóna párra a megadott időn belül (másodpercben)";
$GLOBALS['strBlockAdClicksError'] = "A hírdetés kattintás blokkolás értéke csak nem negatív egész lehet";
$GLOBALS['strMaintenanceOI'] = "Karbantartás művelet időköze (percben)";
$GLOBALS['strMaintenanceOIError'] = "A karbantartás művelet időköze nem érvényes - tekintse meg a dokumentációt az érvényes értékekről";
$GLOBALS['strPrioritySettings'] = "Prioritás beállítások";
$GLOBALS['strPriorityInstantUpdate'] = "Hirdetés prioritások frissítése rögtön a változtatások mentése után";
$GLOBALS['strDefaultImpConWindow'] = "A hirdetés megtekintés alapértelmezett kapcsolati ideje (másodpercben)";
$GLOBALS['strDefaultImpConWindowError'] = "Ha meg van adva, a hirdetés megtekintés kapcsolati ideje csak pozitív egész lehet";
$GLOBALS['strDefaultCliConWindow'] = "A hirdetés kattintás alapértelmezett kapcsolati ideje (másodpercben)";
$GLOBALS['strDefaultCliConWindowError'] = "Ha meg van adva, a hirdetés kattintás kapcsolati ideje csak pozitív egész lehet";
$GLOBALS['strWarnLimitDays'] = "Figyelmeztetés küldése ha a hátralévő napok száma kevesebb mint ";
$GLOBALS['strWarnLimitDaysErr'] = "A figyelmeztetési napok száma pozitív egész kellene hogy legyen";
$GLOBALS['strWarnAgency'] = "Figyelmeztetés küldése az ügynökségnek ha a kampány hamarosan lejár";
$GLOBALS['strEnableQmailPatch'] = "Qmail patch engedélyezése";
$GLOBALS['strDefaultTrackerStatus'] = "Alapértelmezett követő státusz";
$GLOBALS['strDefaultTrackerType'] = "Alapértelmezett követő típus";
$GLOBALS['strMyLogo'] = "Egyedi logó fájl neve";
$GLOBALS['strMyLogoError'] = "Nincs a megadott logó fájl az admin/images könyvtárban";
$GLOBALS['strGuiHeaderForegroundColor'] = "Fejléc előtér színe";
$GLOBALS['strGuiHeaderBackgroundColor'] = "Fejléc háttér színe";
$GLOBALS['strGuiActiveTabColor'] = "Az aktív fül színe";
$GLOBALS['strGuiHeaderTextColor'] = "A fejléc szövegének színe";
$GLOBALS['strColorError'] = "Kérjük a színeket RGB formában adja meg (pl: 0066CC)";
$GLOBALS['strReportsInterface'] = "Jelentés felület";
$GLOBALS['strPublisherInterface'] = "Weboldali felület";
$GLOBALS['strPublisherAgreementEnabled'] = "Belépés szabályozás engedélyezése a Felhasználói feltételeket el nem fogadó weboldalaknak";
$GLOBALS['strPublisherAgreementText'] = "Belépési szöveg (HTML tagek használata megengedett)";
$GLOBALS['strNovice'] = "A törlésekhez megerősítés szükséges biztonsági okokból";
$GLOBALS['strInvocationDefaults'] = "Követelések alapértelmezett beállításai";
$GLOBALS['strBannerLogging'] = "Banner naplózás blokkolásának beállításai";
$GLOBALS['strBannerDelivery'] = "Banner kézbesítési gyorsítótár beállításai";
$GLOBALS['strErrorFixPermissionsRCommand'] = "<i>chmod a+w %s</i>";
?>