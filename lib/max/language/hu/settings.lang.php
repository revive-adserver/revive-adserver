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
$GLOBALS['strAdminAccount'] = "Adminisztrátor";
$GLOBALS['strAdvancedSettings'] = "Haladó beállítások";
$GLOBALS['strWarning'] = "Figyelmeztetés";
$GLOBALS['strBtnContinue'] = "Folytatás »";
$GLOBALS['strBtnRecover'] = "Visszaállítás »";
$GLOBALS['strBtnAgree'] = "Elfogadom »";
$GLOBALS['strBtnRetry'] = "Újrapróbál";
$GLOBALS['strWarningRegisterArgcArv'] = "A register_argc_argv PHP konfigurációs változót be kell kapcsolni hogy a parancssorból el lehessen végezni a karbantartást.";
$GLOBALS['strTablesType'] = "Tábla típusa";

$GLOBALS['strRecoveryRequiredTitle'] = "Az előző újraépítési kísérlete során hiba történt";
$GLOBALS['strRecoveryRequired'] = "Az előző frissítés során hiba történt és az {$PRODUCT_NAME}nek most meg kell próbálnia visszaállítani a frissítés előtti állapotot. Kattintson a Visszaállítás gombra!";

$GLOBALS['strOaUpToDate'] = "Az {$PRODUCT_NAME} adatbázis és fájlstruktúra a lehető legfrissebb verziót használja, így nincs szükség újraépítésre. Kérjük kattintson a Folytatásra, hogy az {$PRODUCT_NAME} adminisztrációs felületre irányíthassuk!";
$GLOBALS['strOaUpToDateCantRemove'] = "Figyelmeztetés: Az UPGRADE fájl még mindig a var könyvtárban van. Nem sikerült automatikusan eltávolítani a fájlt, mert a fájlra vonatkozó engedélyezések nem tették lehetővé. Kérjük törölje a fájlt manuálisan!";
$GLOBALS['strErrorWritePermissions'] = "Fájl engedélyezési hibákat észleltünk, amiket meg kell oldani a folytatás előtt.<br />A hibák kijavításához Linux rendszeren a következő parancs(ok) beírását érdemes megpróbálni:";
$GLOBALS['strErrorFixPermissionsRCommand'] = "<i>chmod a+w %s</i>";

$GLOBALS['strErrorWritePermissionsWin'] = "Fájl engedélyezési hibákat észleltünk, amiket meg kell oldani a folytatás előtt.";
$GLOBALS['strCheckDocumentation'] = "További segítséghez kérjük nézze meg az <a href='http://{$PRODUCT_DOCSURL}'>{$PRODUCT_NAME} dokumentációt</a>.";

$GLOBALS['strAdminUrlPrefix'] = "Az Adminisztrációs Felület URL-je";
$GLOBALS['strDeliveryUrlPrefix'] = "A Kiszolgáló Motor URL-je";
$GLOBALS['strDeliveryUrlPrefixSSL'] = "A Kiszoláló Motor URL-je (SSL)";
$GLOBALS['strImagesUrlPrefix'] = "A Kép Tár URL-je";
$GLOBALS['strImagesUrlPrefixSSL'] = "A Kép Tár URL-je (SSL)";



/* ------------------------------------------------------- */
/* Configuration translations                            */
/* ------------------------------------------------------- */

// Global
$GLOBALS['strChooseSection'] = "Válasszon szekciót";
$GLOBALS['strUnableToWriteConfig'] = "A konfigurációs fájl írása sikertelen";
$GLOBALS['strUnableToWritePrefs'] = "A beállítás adatbázisba írása sikertelen";
$GLOBALS['strImageDirLockedDetected'] = "A kiszolgáló nem tudja írnia a megadott <b>Képek Könyvtárt</b>. <br>Addig nem tud továbblépni, amíg vagy meg nem változtatja a beállításokat vagy létre nem hozza a könyvtárat.";

// Configuration Settings
$GLOBALS['strConfigurationSettings'] = "Konfiguráció beállítása";

// Administrator Settings
$GLOBALS['strAdminUsername'] = "Adminisztrátor  felhasználóneve";
$GLOBALS['strAdminPassword'] = "Adminisztrátor  jelszava";
$GLOBALS['strInvalidUsername'] = "Érvénytelen felhasználóinév";
$GLOBALS['strBasicInformation'] = "Alapinformációk";
$GLOBALS['strAdministratorEmail'] = "Adminisztrátor e-mail címe";
$GLOBALS['strAdminCheckUpdates'] = "Frissítés keresése";
$GLOBALS['strNovice'] = "A törlésekhez megerősítés szükséges biztonsági okokból";
$GLOBALS['strUserlogEmail'] = "Kimenő e-mail üzenetek naplózása";
$GLOBALS['strTimezone'] = "Időzóna";
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

// Email Settings
$GLOBALS['strQmailPatch'] = "A qmail folt engedélyezése";
$GLOBALS['strEnableQmailPatch'] = "Qmail patch engedélyezése";

// Audit Trail Settings

// Debug Logging Settings
$GLOBALS['strDebug'] = "Hibakereső naplózázás beállításai";
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
$GLOBALS['strGeoShowUnavailable'] = "Geotargeting kézbesítési korlátok mutatása a GeoIP adatok elérhetetlensége esetén";

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
$GLOBALS['strStatisticsDefaults'] = "Statisztikák";
$GLOBALS['strBeginOfWeek'] = "Hét kezdete";
$GLOBALS['strPercentageDecimals'] = "Százalékok tört része";
$GLOBALS['strWeightDefaults'] = "Alapértelmezett súly";
$GLOBALS['strDefaultBannerWeight'] = "Alapértelmezett banner súly";
$GLOBALS['strDefaultCampaignWeight'] = "Alapértelmezett kampány súly";

// Invocation Settings
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
$GLOBALS['strBlockAdClicks'] = "Hírdetés kattintás számlálásának kihagyása ha a látogató kattintott az adott hírdetés/zóna párra a megadott időn belül (másodpercben)";
$GLOBALS['strMaintenanceOI'] = "Karbantartás művelet időköze (percben)";
$GLOBALS['strPrioritySettings'] = "Prioritás beállítások";
$GLOBALS['strPriorityInstantUpdate'] = "Hirdetés prioritások frissítése rögtön a változtatások mentése után";
$GLOBALS['strDefaultImpConWindow'] = "A hirdetés megtekintés alapértelmezett kapcsolati ideje (másodpercben)";
$GLOBALS['strDefaultCliConWindow'] = "A hirdetés kattintás alapértelmezett kapcsolati ideje (másodpercben)";
$GLOBALS['strAdminEmailHeaders'] = "A következő fejlécek hozzáadása a {$PRODUCT_NAME} által küldött elektronikus üzenethez";
$GLOBALS['strWarnLimit'] = "Figyelmeztetés küldése ha a hátrelévő megtekintések száma kevesebb mint";
$GLOBALS['strWarnLimitDays'] = "Figyelmeztetés küldése ha a hátralévő napok száma kevesebb mint ";
$GLOBALS['strWarnAdmin'] = "Figyelmeztetés küldése az adminisztrátornak ha a kampány hamarosan lejár";
$GLOBALS['strWarnClient'] = "Figyelmeztetés küldése a hirdetőnek ha a kampány hamarosan lejár";
$GLOBALS['strWarnAgency'] = "Figyelmeztetés küldése az ügynökségnek ha a kampány hamarosan lejár";

// UI Settings
$GLOBALS['strGuiSettings'] = "Felhasználói felület beállításai";
$GLOBALS['strGeneralSettings'] = "�?ltalános beállítások";
$GLOBALS['strAppName'] = "Alkalmazás neve";
$GLOBALS['strMyHeader'] = "Fejléc fájl helye";
$GLOBALS['strMyFooter'] = "Lábléc fájl helye";
$GLOBALS['strDefaultTrackerStatus'] = "Alapértelmezett követő státusz";
$GLOBALS['strDefaultTrackerType'] = "Alapértelmezett követő típus";
$GLOBALS['strMyLogo'] = "Egyedi logó fájl neve";
$GLOBALS['strGuiHeaderForegroundColor'] = "Fejléc előtér színe";
$GLOBALS['strGuiHeaderBackgroundColor'] = "Fejléc háttér színe";
$GLOBALS['strGuiActiveTabColor'] = "Az aktív fül színe";
$GLOBALS['strGuiHeaderTextColor'] = "A fejléc szövegének színe";
$GLOBALS['strGzipContentCompression'] = "GZIP tartalom tömörítés használata";

// Regenerate Platfor Hash script

// Plugin Settings
