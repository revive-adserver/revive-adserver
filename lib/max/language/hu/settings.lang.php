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

// Installer translation strings
$GLOBALS['strInstall'] = "Installálás";
$GLOBALS['strDatabaseSettings'] = "Adatbázis beállításai";
$GLOBALS['strAdminSettings'] = "Adminisztrátor beállítások";
$GLOBALS['strAdminAccount'] = "Adminisztrátor";
$GLOBALS['strAdvancedSettings'] = "Haladó beállítások";
$GLOBALS['strWarning'] = "Figyelmeztetés";
$GLOBALS['strBtnContinue'] = "Folytatás »";
$GLOBALS['strBtnRecover'] = "Visszaállítás »";
$GLOBALS['strBtnStartAgain'] = "Újraépítés újrakezdése »";
$GLOBALS['strBtnGoBack'] = "« Vissza";
$GLOBALS['strBtnAgree'] = "Elfogadom »";
$GLOBALS['strBtnRetry'] = "Újrapróbál";
$GLOBALS['strWarningRegisterArgcArv'] = "A register_argc_argv PHP konfigurációs változót be kell kapcsolni hogy a parancssorból el lehessen végezni a karbantartást.";
$GLOBALS['strTablesType'] = "Tábla típusa";


$GLOBALS['strRecoveryRequiredTitle'] = "Az előző újraépítési kísérlete során hiba történt";
$GLOBALS['strRecoveryRequired'] = "Az előző frissítés során hiba történt és az {$PRODUCT_NAME}nek most meg kell próbálnia visszaállítani a frissítés előtti állapotot. Kattintson a Visszaállítás gombra!";

$GLOBALS['strOaUpToDate'] = "Az {$PRODUCT_NAME} adatbázis és fájlstruktúra a lehető legfrissebb verziót használja, így nincs szükség újraépítésre. Kérjük kattintson a Folytatásra, hogy az {$PRODUCT_NAME} adminisztrációs felületre irányíthassuk!";
$GLOBALS['strOaUpToDateCantRemove'] = "Figyelmeztetés: Az UPGRADE fájl még mindig a var könyvtárban van. Nem sikerült automatikusan eltávolítani a fájlt, mert a fájlra vonatkozó engedélyezések nem tették lehetővé. Kérjük törölje a fájlt manuálisan!";
$GLOBALS['strRemoveUpgradeFile'] = "Az UPGRADE fájlt el kell távolítania a var könyvtárból!";
$GLOBALS['strInstallSuccess'] = "<b>A {$PRODUCT_NAME} telepítése ezzel befejeződött.</b><br><br>A {$PRODUCT_NAME} megfelelő működéséhez ellenőrizze
               a karbantartás fájl óránkénti futtatásának végrehajtását. A dokumentációban több információt talál erről a témáról.
						   <br><br>A <b>Tovább</b> gomb megnyomásával töltheti be Beállítások lapot, ahol elvégezheti
							 a testreszabást. Miután elkészült, ne feledje el lezárni a config.inc.php fájlt, mert így
							 megelőzheti a biztonsági sértéseket.";
$GLOBALS['strInstallNotSuccessful'] = "<b>A {$PRODUCT_NAME} telepítése nem sikerült.</b><br><br>A telepítési folyamat részét nem lehetett befejezni.
						   Ezek a problémák valószínűleg csak ideiglenesek, ebben az esetben nyugodtan nyomja meg a <b>Tovább</b>t,
							 és térjen vissza a telepítési folyamat első lépéséhez. Ha többet szeretni tudni arról, hogy mit jelent az alábbi
							 hibaüzenet, és hogyan háríthatja el, akkor nézzen utána a dokumentációban.";
$GLOBALS['strDbSuccessIntro'] = "Az {$PRODUCT_NAME} adatbázis frissítése megtörtént. Kérjük kattintson a 'Folytatás' gombra az {$PRODUCT_NAME} Adminisztrátor és Kiszolgálás beállításainak megtekintéséhez.";
$GLOBALS['strErrorOccured'] = "A következő hiba történt:";
$GLOBALS['strErrorInstallDatabase'] = "Nem lehet létrehozni az adatbázis szerkezetet.";
$GLOBALS['strErrorInstallDbConnect'] = "Nem lehet kapcsolatot létesíteni az adatbázissal.";

$GLOBALS['strErrorWritePermissions'] = "Fájl engedélyezési hibákat észleltünk, amiket meg kell oldani a folytatás előtt.<br />A hibák kijavításához Linux rendszeren a következő parancs(ok) beírását érdemes megpróbálni:";
$GLOBALS['strErrorFixPermissionsRCommand'] = "<i>chmod a+w %s</i>";

$GLOBALS['strErrorWritePermissionsWin'] = "Fájl engedélyezési hibákat észleltünk, amiket meg kell oldani a folytatás előtt.";
$GLOBALS['strCheckDocumentation'] = "További segítséghez kérjük nézze meg az <a href='http://{$PRODUCT_DOCSURL}'>{$PRODUCT_NAME} dokumentációt</a>.";

$GLOBALS['strAdminUrlPrefix'] = "Az Adminisztrációs Felület URL-je";
$GLOBALS['strDeliveryUrlPrefix'] = "A Kiszolgáló Motor URL-je";
$GLOBALS['strDeliveryUrlPrefixSSL'] = "A Kiszoláló Motor URL-je (SSL)";
$GLOBALS['strImagesUrlPrefix'] = "A Kép Tár URL-je";
$GLOBALS['strImagesUrlPrefixSSL'] = "A Kép Tár URL-je (SSL)";

$GLOBALS['strInvalidUserPwd'] = "A felhasználónév vagy a jelszó érvénytelen";

$GLOBALS['strUpgrade'] = "Frissítés";
$GLOBALS['strSystemUpToDate'] = "A rendszer frissítése már megtörtént, jelenleg nincs szükség az aktualizálására. <br>A <b>Tovább</b> megnyomásával ugorjon a kezdőlapra.";
$GLOBALS['strSystemNeedsUpgrade'] = "A megfelelő működés céljából frissíteni kell az adatbázis szerkezetet és a konfigurációs fájlt. A <b>Tovább</b> megnyomásával indíthatja a frissítési folyamatot. <br><br>Attól függően, hogy melyik verzióról frissít, és mennyi statisztikát tárol már az adatbázisban, ez a folyamat az adatbázis kiszolgálót nagyon leterhelheti. Legyen türelemmel, a frissítés eltarthat néhány percig.";
$GLOBALS['strSystemUpgradeBusy'] = "A rendszer frissítése folyamatban. Kis türelmet...";
$GLOBALS['strSystemRebuildingCache'] = "A gyorsítótár újraépítése. Kis türelmet...";
$GLOBALS['strServiceUnavalable'] = "A szolgáltatás átmenetileg nem elérhető. A rendszer frissítése folyamatban";

/* ------------------------------------------------------- */
/* Configuration translations                            */
/* ------------------------------------------------------- */

// Global
$GLOBALS['strChooseSection'] = "Válasszon szekciót";
$GLOBALS['strEditConfigNotPossible'] = "It is not possible to edit all settings because the configuration file is locked for security reasons. " .
    "If you want to make changes, you may need to unlock the configuration file for this installation first.";
$GLOBALS['strEditConfigPossible'] = "It is possible to edit all settings because the configuration file is not locked, but this could lead to security issues. " .
    "If you want to secure your system, you need to lock the configuration file for this installation.";
$GLOBALS['strUnableToWriteConfig'] = "A konfigurációs fájl írása sikertelen";
$GLOBALS['strUnableToWritePrefs'] = "A beállítás adatbázisba írása sikertelen";
$GLOBALS['strImageDirLockedDetected'] = "A kiszolgáló nem tudja írnia a megadott <b>Képek Könyvtárt</b>. <br>Addig nem tud továbblépni, amíg vagy meg nem változtatja a beállításokat vagy létre nem hozza a könyvtárat.";

// Configuration Settings
$GLOBALS['strConfigurationSettings'] = "Konfiguráció beállítása";

// Administrator Settings
$GLOBALS['strAdministratorSettings'] = "Adminisztrátor beállítások";
$GLOBALS['strLoginCredentials'] = "Belépési adatok";
$GLOBALS['strAdminUsername'] = "Adminisztrátor  felhasználóneve";
$GLOBALS['strAdminPassword'] = "Adminisztrátor  jelszava";
$GLOBALS['strInvalidUsername'] = "Érvénytelen felhasználóinév";
$GLOBALS['strBasicInformation'] = "Alapinformációk";
$GLOBALS['strAdminFullName'] = "Admin teljes neve";
$GLOBALS['strAdminEmail'] = "Admin e-mail címe";
$GLOBALS['strAdministratorEmail'] = "Adminisztrátor e-mail címe";
$GLOBALS['strCompanyName'] = "Szervezet neve";
$GLOBALS['strAdminCheckUpdates'] = "Frissítés keresése";
$GLOBALS['strAdminCheckEveryLogin'] = "Minden belépéskor";
$GLOBALS['strAdminCheckDaily'] = "Naponta";
$GLOBALS['strAdminCheckWeekly'] = "Hetente";
$GLOBALS['strAdminCheckMonthly'] = "Havonta";
$GLOBALS['strAdminCheckNever'] = "Soha";
$GLOBALS['strNovice'] = "A törlésekhez megerősítés szükséges biztonsági okokból";
$GLOBALS['strUserlogEmail'] = "Kimenő e-mail üzenetek naplózása";
$GLOBALS['strTimezone'] = "Időzóna";
$GLOBALS['strTimezoneEstimated'] = "Becsült időzóna";
$GLOBALS['strTimezoneGuessedValue'] = "A szerver időzónája nincs megfelelően beállítva a PHP-ben";
$GLOBALS['strTimezoneSeeDocs'] = "Ennek a PHP változónak a beállításáról további információt találsz itt: %DOCS%";
$GLOBALS['strTimezoneDocumentation'] = "dokumentáció";

$GLOBALS['strEnableAutoMaintenance'] = "Automatikusan fusson le a karbantartó eljárás a kiszolgáláskor, ha nincs beállítva a karbantartás ütemterve. ";

// Database Settings
$GLOBALS['strDatabaseSettings'] = "Adatbázis beállításai";
$GLOBALS['strDatabaseServer'] = "Globális adatbázis szerver beállítások";
$GLOBALS['strDbLocal'] = "Kapcsolódás helyi kiszolgálóhoz szoftvercsatornával";
$GLOBALS['strDbType'] = "Adatbázis típusa";
$GLOBALS['strDbHost'] = "Adatbázis kiszolgálóneve";
$GLOBALS['strDbPort'] = "Adatbázis port száma";
$GLOBALS['strDbUser'] = "Adatbázis felhasználói neve";
$GLOBALS['strDbPassword'] = "Adatbázis jelszó";
$GLOBALS['strDbName'] = "Adatbázis név";
$GLOBALS['strDatabaseOptimalisations'] = "Adatbázis optimalizációs beállítások";
$GLOBALS['strPersistentConnections'] = "�?llandó kapcsolat használata";
$GLOBALS['strCantConnectToDb'] = "Nem sikerült kapcsolódni az adatbázishoz";
$GLOBALS['strDemoDataInstall'] = "Demo adatok telepítése";
$GLOBALS['strDemoDataIntro'] = "Alapértelmezett adatokkal lehet feltölteni az {$PRODUCT_NAME} adatbázisát, hogy segítse az online hirdetések kiszolgálásának megkezdését. A legelterjedtebb banner típusok és néhány kezdeti kampány kerül ezzel betöltésre és előre beállításra. Használata erősen ajánlott az új telepítésekhez.";



// Email Settings
$GLOBALS['strQmailPatch'] = "A qmail folt engedélyezése";
$GLOBALS['strEnableQmailPatch'] = "Qmail patch engedélyezése";

// Audit Trail Settings

// Debug Logging Settings
$GLOBALS['strDebug'] = "Hibakereső naplózázás beállításai";
$GLOBALS['strProduction'] = "Publikus szerver";
$GLOBALS['strEnableDebug'] = "Hibakereső naplózás engedélyezése";
$GLOBALS['strDebugMethodNames'] = "Eljárásnevek hozzáadása a hibereső naplózáshoz";
$GLOBALS['strDebugLineNumbers'] = "Naplózott sorok sorszámának hozzáadása a hibakereső naplózáshoz";
$GLOBALS['strDebugType'] = "Hibakereső napló típusa";
$GLOBALS['strDebugTypeFile'] = "Fájl";
$GLOBALS['strDebugTypeSql'] = "SQL adatbázis";
$GLOBALS['strDebugName'] = "Hibakereső napló név, naptár, SQL tábla,<br />vagy Syslog Facility";
$GLOBALS['strDebugPriority'] = "Hibakereső prioritási szint";
$GLOBALS['strPEAR_LOG_DEBUG'] = "PEAR_LOG_DEBUG - Az elérhető legtöbb információ";
$GLOBALS['strPEAR_LOG_INFO'] = "PEAR_LOG_INFO - Alapértelmezett információmennyiség";
$GLOBALS['strPEAR_LOG_EMERG'] = "PEAR_LOG_EMERG - Minimális információ";
$GLOBALS['strDebugIdent'] = "Azonosító sztring hibakeresése";
$GLOBALS['strDebugUsername'] = "mCal, SQL szerver felhasználóinév";
$GLOBALS['strDebugPassword'] = "mCal, SQL szerver jelszó";

// Delivery Settings
$GLOBALS['strDeliverySettings'] = "Kézbesítési beállítások";
$GLOBALS['strWebPath'] = "$PRODUCT_NAME Server Access Paths";
$GLOBALS['strWebPathSimple'] = "Webes elérési út";
$GLOBALS['strDeliveryPath'] = "Kézbesítés elérési útja";
$GLOBALS['strImagePath'] = "Képek elérési útja";
$GLOBALS['strDeliverySslPath'] = "Kézbesítés SSL elérési útja";
$GLOBALS['strImageSslPath'] = "Képek SSL elérési útja";
$GLOBALS['strImageStore'] = "Képek könyvtár";
$GLOBALS['strTypeWebSettings'] = "Webszerver helyi banner tárolásának beállításai";
$GLOBALS['strTypeWebMode'] = "Tárolási mód";
$GLOBALS['strTypeWebModeLocal'] = "Helyi könyvtár";
$GLOBALS['strTypeDirError'] = "A helyi könyvtár a webszerver számára nem írható";
$GLOBALS['strTypeWebModeFtp'] = "Külső FTP szerver";
$GLOBALS['strTypeWebDir'] = "Helyi könyvtár";
$GLOBALS['strTypeFTPHost'] = "FTP kiszolgáló";
$GLOBALS['strTypeFTPDirectory'] = "Kiszolgáló könyvtár";
$GLOBALS['strTypeFTPUsername'] = "Login név (FTP felhasználó)";
$GLOBALS['strTypeFTPPassword'] = "Jelszó";
$GLOBALS['strTypeFTPPassive'] = "Passzív kapcsolat használata";
$GLOBALS['strTypeFTPErrorDir'] = "Az FTP kiszolgáló könyvtár nem létezik";
$GLOBALS['strTypeFTPErrorConnect'] = "Nem sikerült kapcsolódni az FTP szerverhez, a login név vagy a jelszó nem megfelelő";
$GLOBALS['strTypeFTPErrorHost'] = "Az FTP kiszolgáló nem megfelelő";
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
$GLOBALS['strDeliveryFilenamesFlash'] = "Flash beágyazás (teljes URL cím is lehet)";
$GLOBALS['strDeliveryCaching'] = "Banner kézbesítési gyorsítótár beállításai";
$GLOBALS['strDeliveryCacheLimit'] = "A banner gyorsítótár frissítései közti idő (másodpercekben)";


$GLOBALS['strOrigin'] = "Távoli eredet szerver használata";
$GLOBALS['strOriginType'] = "Eredet szerver típusa";
$GLOBALS['strOriginHost'] = "Eredet szerver kiszolgálói neve";
$GLOBALS['strOriginPort'] = "Eredet adatbázis port száma";
$GLOBALS['strOriginScript'] = "Eredet adatbázis script fájlja";
$GLOBALS['strOriginTimeout'] = "Eredet időtúllépés (másodpercekben)";
$GLOBALS['strOriginProtocol'] = "Eredet szerver protokol";

$GLOBALS['strDeliveryAcls'] = "Banner kézbesítési korlátozások megbecslése kézbesítés közben.";
$GLOBALS['strDeliveryObfuscate'] = "Csatornazavarás a hirdetések kézbesítése közben";
$GLOBALS['strDeliveryExecPhp'] = "PHP kódok futtatásának engedélyezése a hirdetésekben<br />(Figyelem: Biztonsági kockázat)";
$GLOBALS['strDeliveryCtDelimiter'] = "Harmadik féltől származó kattintás követési határolójel";
$GLOBALS['strP3PSettings'] = "P3P adatvédelmi irányelvek";
$GLOBALS['strUseP3P'] = "P3P irányelvek használata";
$GLOBALS['strP3PCompactPolicy'] = "P3P tömörített irányelv";
$GLOBALS['strP3PPolicyLocation'] = "P3P irányelvek helye";

// General Settings

// Geotargeting Settings
$GLOBALS['strGeotargetingSettings'] = "Geotargeting beállítások";
$GLOBALS['strGeotargeting'] = "Geotargeting beállítások";
$GLOBALS['strGeotargetingType'] = "Geotargeting modul típus";
$GLOBALS['strGeotargetingGeoipCountryLocation'] = "MaxMind GeoIP ország adatbázis helye";
$GLOBALS['strGeotargetingGeoipRegionLocation'] = "MaxMind GeoIP régió adatbázis helye";
$GLOBALS['strGeotargetingGeoipCityLocation'] = "MaxMind GeoIP város adatbázis helye";
$GLOBALS['strGeotargetingGeoipAreaLocation'] = "MaxMind GeoIP terület adatbázis helye";
$GLOBALS['strGeotargetingGeoipDmaLocation'] = "MaxMind GeoIP DMA adatbázis helye";
$GLOBALS['strGeotargetingGeoipOrgLocation'] = "MaxMind GeoIP szervezet adatbázis helye";
$GLOBALS['strGeotargetingGeoipIspLocation'] = "MaxMind GeoIP ISP adatbázis helye";
$GLOBALS['strGeotargetingGeoipNetspeedLocation'] = "MaxMind GeoIP internetsebesség adatbázis helye";
$GLOBALS['strGeoShowUnavailable'] = "Geotargeting kézbesítési korlátok mutatása a GeoIP adatok elérhetetlensége esetén";
$GLOBALS['strGeotrackingGeoipCountryLocationError'] = "A MaxMind GeoIP ország adatbázis nem elérhető a megadott helyen";
$GLOBALS['strGeotrackingGeoipRegionLocationError'] = "A MaxMind GeoIP régió adatbázis nem elérhető a megadott helyen";
$GLOBALS['strGeotrackingGeoipCityLocationError'] = "A MaxMind GeoIP város adatbázis nem elérhető a megadott helyen";
$GLOBALS['strGeotrackingGeoipAreaLocationError'] = "A MaxMind GeoIP terület adatbázis nem elérhető a megadott helyen";
$GLOBALS['strGeotrackingGeoipDmaLocationError'] = "A MaxMind GeoIP DMA adatbázis nem elérhető a megadott helyen";
$GLOBALS['strGeotrackingGeoipOrgLocationError'] = "A MaxMind GeoIP szervezet adatbázis nem elérhető a megadott helyen";
$GLOBALS['strGeotrackingGeoipIspLocationError'] = "A MaxMind GeoIP ISP adatbázis nem elérhető a megadott helyen";
$GLOBALS['strGeotrackingGeoipNetspeedLocationError'] = "A MaxMind GeoIP internet sebesség adatbázis nem elérhető a megadott helyen";

// Interface Settings
$GLOBALS['strInventory'] = "Leltár";
$GLOBALS['strShowCampaignInfo'] = "Extra kampány info megjelenítése a <i>Kampány áttekintés</i> oldalon";
$GLOBALS['strShowBannerInfo'] = "Extra banner info megjelenítése a <i>Banner áttekintés</i> oldalon";
$GLOBALS['strShowCampaignPreview'] = "Minden banner megjelenítése a <i>Banner áttekintés</i> oldalon";
$GLOBALS['strShowBannerHTML'] = "A HTML code helyett a tényleges banner megmutatása a HTML bannerek megjelenítésekor";
$GLOBALS['strShowBannerPreview'] = "Bannerek megjelenítése a kapcsolódó oldalak tetején";
$GLOBALS['strHideInactive'] = "Az inaktív objektumok elrejtése az áttekintéses oldalakról";
$GLOBALS['strGUIShowMatchingBanners'] = "Egyező bannerek megjelenítése a <i>Linkelt banner</i> oldalakon";
$GLOBALS['strGUIShowParentCampaigns'] = "Szülő kampányok megjelenítése a <i>Linkelt banner</i> oldalakon";
$GLOBALS['strGUIAnonymousCampaignsByDefault'] = "Kampányok alapértelmezése Anonymousként";
$GLOBALS['strStatisticsDefaults'] = "Statisztikák";
$GLOBALS['strBeginOfWeek'] = "Hét kezdete";
$GLOBALS['strPercentageDecimals'] = "Százalékok tört része";
$GLOBALS['strWeightDefaults'] = "Alapértelmezett súly";
$GLOBALS['strDefaultBannerWeight'] = "Alapértelmezett banner súly";
$GLOBALS['strDefaultCampaignWeight'] = "Alapértelmezett kampány súly";
$GLOBALS['strDefaultBannerWErr'] = "Az alapértelmezett reklám fontosság pozitív egész szám legyen";
$GLOBALS['strDefaultCampaignWErr'] = "Az alapértelmezett kampány fontosság pozitív egész szám legyen";

$GLOBALS['strPublisherDefaults'] = "Weboldal alapértelmezések";
$GLOBALS['strModesOfPayment'] = "Fizetési módok";
$GLOBALS['strCurrencies'] = "Valuták";
$GLOBALS['strCategories'] = "Kategóriák";
$GLOBALS['strHelpFiles'] = "Súgó fájlok";
$GLOBALS['strHasTaxID'] = "Adó azonosító";
$GLOBALS['strDefaultApproved'] = "Jóváhagyott választónégyzet";

// CSV Import Settings

/**
 * @todo remove strBannerSettings if banner is only configurable as a preference
 *       rename // Banner Settings to  // Banner Preferences
 */
// Invocation Settings
$GLOBALS['strAllowedInvocationTypes'] = "Megengedett követelés típusok";
$GLOBALS['strInvocationDefaults'] = "Követelések alapértelmezett beállításai";
$GLOBALS['strEnable3rdPartyTrackingByDefault'] = "Harmadik fél által készített kattintáskövetés alapértelmezettként";

// Banner Delivery Settings
$GLOBALS['strBannerDelivery'] = "Banner kézbesítési gyorsítótár beállításai";

// Banner Logging Settings
$GLOBALS['strBannerLogging'] = "Banner naplózás blokkolásának beállításai";
$GLOBALS['strLogAdRequests'] = "Minden banner lekérés naplózása";
$GLOBALS['strLogAdImpressions'] = "Minden banner megtekintés naplózása";
$GLOBALS['strLogAdClicks'] = "Minden kattintás naplózása amikor a látogató a bannerre kattint";
$GLOBALS['strReverseLookup'] = "Látogató kiszolgálónevének visszakeresése ha nincs megadva";
$GLOBALS['strProxyLookup'] = "Valódi IP cím keresése amikor a látogató proxy szerver mögött van";
$GLOBALS['strPreventLogging'] = "Banner naplózás blokkolásának beállításai";
$GLOBALS['strIgnoreHosts'] = "A következő IP címek és kiszolgálónevek kihagyása a naplózásból";

// Banner Storage Settings

// Campaign ECPM settings

// Statistics & Maintenance Settings
$GLOBALS['strCsvImport'] = "Offline konverziók feltöltésének engedélyezése";
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
$GLOBALS['strAdminEmailHeaders'] = "A következő fejlécek hozzáadása a {$PRODUCT_NAME} által küldött elektronikus üzenethez";
$GLOBALS['strWarnLimit'] = "Figyelmeztetés küldése ha a hátrelévő megtekintések száma kevesebb mint";
$GLOBALS['strWarnLimitErr'] = "Figyelmeztetési határ csak pozitív egész lehet";
$GLOBALS['strWarnLimitDays'] = "Figyelmeztetés küldése ha a hátralévő napok száma kevesebb mint ";
$GLOBALS['strWarnLimitDaysErr'] = "A figyelmeztetési napok száma pozitív egész kellene hogy legyen";
$GLOBALS['strWarnAdmin'] = "Figyelmeztetés küldése az adminisztrátornak ha a kampány hamarosan lejár";
$GLOBALS['strWarnClient'] = "Figyelmeztetés küldése a hirdetőnek ha a kampány hamarosan lejár";
$GLOBALS['strWarnAgency'] = "Figyelmeztetés küldése az ügynökségnek ha a kampány hamarosan lejár";

// UI Settings
$GLOBALS['strGuiSettings'] = "Felhasználói felület beállításai";
$GLOBALS['strGeneralSettings'] = "�?ltalános beállítások";
$GLOBALS['strAppName'] = "Alkalmazás neve";
$GLOBALS['strMyHeader'] = "Fejléc fájl helye";
$GLOBALS['strMyHeaderError'] = "Az Ön által megadott helyen nem található fejléc fájl";
$GLOBALS['strMyFooter'] = "Lábléc fájl helye";
$GLOBALS['strMyFooterError'] = "Az Ön által megadott helyen nem található lábléc fájl";
$GLOBALS['strDefaultTrackerStatus'] = "Alapértelmezett követő státusz";
$GLOBALS['strDefaultTrackerType'] = "Alapértelmezett követő típus";

$GLOBALS['strMyLogo'] = "Egyedi logó fájl neve";
$GLOBALS['strMyLogoError'] = "Nincs a megadott logó fájl az admin/images könyvtárban";
$GLOBALS['strGuiHeaderForegroundColor'] = "Fejléc előtér színe";
$GLOBALS['strGuiHeaderBackgroundColor'] = "Fejléc háttér színe";
$GLOBALS['strGuiActiveTabColor'] = "Az aktív fül színe";
$GLOBALS['strGuiHeaderTextColor'] = "A fejléc szövegének színe";
$GLOBALS['strColorError'] = "Kérjük a színeket RGB formában adja meg (pl: 0066CC)";

$GLOBALS['strGzipContentCompression'] = "GZIP tartalom tömörítés használata";
$GLOBALS['strClientInterface'] = "Hirdetői felület";
$GLOBALS['strReportsInterface'] = "Jelentés felület";
$GLOBALS['strClientWelcomeEnabled'] = "Hirdető üdvözlő üzenet engedélyezése";
$GLOBALS['strClientWelcomeText'] = "Üdvözlő szöveg<br />(HTML tagek használata megengedett)";

$GLOBALS['strPublisherInterface'] = "Weboldali felület";
$GLOBALS['strPublisherAgreementEnabled'] = "Belépés szabályozás engedélyezése a Felhasználói feltételeket el nem fogadó weboldalaknak";
$GLOBALS['strPublisherAgreementText'] = "Belépési szöveg (HTML tagek használata megengedett)";

// Regenerate Platfor Hash script

// Plugin Settings

/* ------------------------------------------------------- */
/* Unknown (unused?) translations                        */
/* ------------------------------------------------------- */

$GLOBALS['strExperimental'] = "Kísérleti";
$GLOBALS['strKeywordRetrieval'] = "Kulcsszó visszakeresés";
$GLOBALS['strBannerRetrieval'] = "Reklám visszakeresési mód";
$GLOBALS['strRetrieveRandom'] = "Véletlenszerű reklám visszakeresés (alapértelmezett)";
$GLOBALS['strRetrieveNormalSeq'] = "Normál soros reklám viszakeresés";
$GLOBALS['strWeightSeq'] = "Fontosságon alapuló soros reklám visszakeresés";
$GLOBALS['strFullSeq'] = "Teljes soros reklám visszakeresés";
$GLOBALS['strUseConditionalKeys'] = "Logikai műveleti jelek engedélyezése a közvetlen kiválasztás használatakor";
$GLOBALS['strUseMultipleKeys'] = "Több kulcsszó engedélyezése a közvetlen kiválasztás használatakor";

$GLOBALS['strTableBorderColor'] = "Táblázatszegély színe";
$GLOBALS['strTableBackColor'] = "Táblázatháttér színer";
$GLOBALS['strTableBackColorAlt'] = "Táblázatháttér színe (választható)";
$GLOBALS['strMainBackColor'] = "Fő háttérszín";
$GLOBALS['strOverrideGD'] = "A GD képformátum hatálytalanítása";
$GLOBALS['strTimeZone'] = "Időzóna";
