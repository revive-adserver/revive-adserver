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
$GLOBALS['strTablesPrefix'] = "Table names prefix";
$GLOBALS['strTablesType'] = "Tábla típusa";

$GLOBALS['strRecoveryRequiredTitle'] = "Az előző újraépítési kísérlete során hiba történt";
$GLOBALS['strRecoveryRequired'] = "Az előző frissítés során hiba történt és az {$PRODUCT_NAME}nek most meg kell próbálnia visszaállítani a frissítés előtti állapotot. Kattintson a Visszaállítás gombra!";

$GLOBALS['strProductUpToDateTitle'] = "{$PRODUCT_NAME} is up to date";
$GLOBALS['strOaUpToDate'] = "Az {$PRODUCT_NAME} adatbázis és fájlstruktúra a lehető legfrissebb verziót használja, így nincs szükség újraépítésre. Kérjük kattintson a Folytatásra, hogy az {$PRODUCT_NAME} adminisztrációs felületre irányíthassuk!";
$GLOBALS['strOaUpToDateCantRemove'] = "Figyelmeztetés: Az UPGRADE fájl még mindig a var könyvtárban van. Nem sikerült automatikusan eltávolítani a fájlt, mert a fájlra vonatkozó engedélyezések nem tették lehetővé. Kérjük törölje a fájlt manuálisan!";
$GLOBALS['strErrorWritePermissions'] = "Fájl engedélyezési hibákat észleltünk, amiket meg kell oldani a folytatás előtt.<br />A hibák kijavításához Linux rendszeren a következő parancs(ok) beírását érdemes megpróbálni:";
$GLOBALS['strErrorFixPermissionsRCommand'] = "<i>chmod a+w %s</i>";
$GLOBALS['strNotWriteable'] = "NOT writeable";
$GLOBALS['strDirNotWriteableError'] = "Directory must be writeable";

$GLOBALS['strErrorWritePermissionsWin'] = "Fájl engedélyezési hibákat észleltünk, amiket meg kell oldani a folytatás előtt.";
$GLOBALS['strCheckDocumentation'] = "További segítséghez kérjük nézze meg az <a href='http://{$PRODUCT_DOCSURL}'>{$PRODUCT_NAME} dokumentációt</a>.";
$GLOBALS['strSystemCheckBadPHPConfig'] = "Your current PHP configuration does not meet requirements of {$PRODUCT_NAME}. To resolve the problems, please modify settings in your 'php.ini' file.";

$GLOBALS['strAdminUrlPrefix'] = "Az Adminisztrációs Felület URL-je";
$GLOBALS['strDeliveryUrlPrefix'] = "A Kiszolgáló Motor URL-je";
$GLOBALS['strDeliveryUrlPrefixSSL'] = "A Kiszoláló Motor URL-je (SSL)";
$GLOBALS['strImagesUrlPrefix'] = "A Kép Tár URL-je";
$GLOBALS['strImagesUrlPrefixSSL'] = "A Kép Tár URL-je (SSL)";


$GLOBALS['strUpgrade'] = "Upgrade";

/* ------------------------------------------------------- */
/* Configuration translations                            */
/* ------------------------------------------------------- */

// Global
$GLOBALS['strChooseSection'] = "Válasszon egyet";
$GLOBALS['strEditConfigNotPossible'] = "It is not possible to edit all settings because the configuration file is locked for security reasons.
    If you want to make changes, you may need to unlock the configuration file for this installation first.";
$GLOBALS['strEditConfigPossible'] = "It is possible to edit all settings because the configuration file is not locked, but this could lead to security issues.
    If you want to secure your system, you need to lock the configuration file for this installation.";
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
$GLOBALS['strAdministratorEmail'] = "Adminisztrátori e-mailek";
$GLOBALS['strAdminCheckUpdates'] = "Frissítés keresése";
$GLOBALS['strAdminShareStack'] = "Share technical information with the {$PRODUCT_NAME} Team to help with development and testing.";
$GLOBALS['strNovice'] = "A törlésekhez megerősítés szükséges biztonsági okokból";
$GLOBALS['strUserlogEmail'] = "Kimenő e-mail üzenetek naplózása";
$GLOBALS['strEnableDashboard'] = "Enable dashboard";
$GLOBALS['strEnableDashboardSyncNotice'] = "Please enable <a href='account-settings-update.php'>check for updates</a> to use the dashboard.";
$GLOBALS['strTimezone'] = "Időzóna";
$GLOBALS['strEnableAutoMaintenance'] = "Automatikusan fusson le a karbantartó eljárás a kiszolgáláskor, ha nincs beállítva a karbantartás ütemterve. ";

// Database Settings
$GLOBALS['strDatabaseSettings'] = "Adatbázis beállításai";
$GLOBALS['strDatabaseServer'] = "Globális adatbázis szerver beállítások";
$GLOBALS['strDbLocal'] = "Kapcsolódás helyi kiszolgálóhoz szoftvercsatornával";
$GLOBALS['strDbType'] = "Adatbázis típusa";
$GLOBALS['strDbHost'] = "Adatbázis kiszolgálóneve";
$GLOBALS['strDbSocket'] = "Database Socket";
$GLOBALS['strDbPort'] = "Adatbázis port száma";
$GLOBALS['strDbUser'] = "Adatbázis felhasználói neve";
$GLOBALS['strDbPassword'] = "Adatbázis jelszó";
$GLOBALS['strDbName'] = "Adatbázis név";
$GLOBALS['strDbNameHint'] = "Database will be created if it does not exist";
$GLOBALS['strDatabaseOptimalisations'] = "Adatbázis optimalizációs beállítások";
$GLOBALS['strPersistentConnections'] = "�?llandó kapcsolat használata";
$GLOBALS['strCantConnectToDb'] = "Nem sikerült kapcsolódni az adatbázishoz";
$GLOBALS['strCantConnectToDbDelivery'] = 'Can\'t Connect to Database for Delivery';

// Email Settings
$GLOBALS['strEmailSettings'] = "Email Settings";
$GLOBALS['strEmailAddresses'] = "Email 'From' Address";
$GLOBALS['strEmailFromName'] = "Email 'From' Name";
$GLOBALS['strEmailFromAddress'] = "Email 'From' Email Address";
$GLOBALS['strEmailFromCompany'] = "Email 'From' Company";
$GLOBALS['strUseManagerDetails'] = 'Use the owning account\'s Contact, Email and Name instead of the above Name, Email Address and Company when emailing reports to Advertiser or Website accounts.';
$GLOBALS['strQmailPatch'] = "A qmail folt engedélyezése";
$GLOBALS['strEnableQmailPatch'] = "Qmail patch engedélyezése";
$GLOBALS['strEmailHeader'] = "Email headers";
$GLOBALS['strEmailLog'] = "Email log";

// Audit Trail Settings
$GLOBALS['strAuditTrailSettings'] = "Audit Trail Settings";
$GLOBALS['strEnableAudit'] = "Enable Audit Trail";
$GLOBALS['strEnableAuditForZoneLinking'] = "Enable Audit Trail for Zone Linking screen (introduces huge performance penalty when linking large amounts of zones)";

// Debug Logging Settings
$GLOBALS['strDebug'] = "Hibakereső naplózázás beállításai";
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
$GLOBALS['strProductionSystem'] = "Production System";

// Delivery Settings
$GLOBALS['strWebPath'] = "{$PRODUCT_NAME} Server Access Paths";
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
$GLOBALS['strTypeFTPUsername'] = "Bejelentkezés";
$GLOBALS['strTypeFTPPassword'] = "Jelszó";
$GLOBALS['strTypeFTPPassive'] = "Passzív kapcsolat használata";
$GLOBALS['strTypeFTPErrorDir'] = "Az FTP kiszolgáló könyvtár nem létezik";
$GLOBALS['strTypeFTPErrorConnect'] = "Nem sikerült kapcsolódni az FTP szerverhez, a login név vagy a jelszó nem megfelelő";
$GLOBALS['strTypeFTPErrorNoSupport'] = "Your installation of PHP does not support FTP.";
$GLOBALS['strTypeFTPErrorUpload'] = "Could not upload file to the FTP Server, check set proper rights to Host Directory";
$GLOBALS['strTypeFTPErrorHost'] = "Az FTP kiszolgáló nem megfelelő";
$GLOBALS['strDeliveryFilenames'] = "Kézbesítendő fájl nevek";
$GLOBALS['strDeliveryFilenamesAdClick'] = "Hirdetés kattintás";
$GLOBALS['strDeliveryFilenamesSignedAdClick'] = "Signed Ad Click";
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
$GLOBALS['strDeliveryFilenamesSinglePageCall'] = "Single Page Call";
$GLOBALS['strDeliveryFilenamesSinglePageCallJS'] = "Single Page Call (JavaScript)";
$GLOBALS['strDeliveryFilenamesAsyncJS'] = "Async JavaScript (source file)";
$GLOBALS['strDeliveryFilenamesAsyncPHP'] = "Async JavaScript";
$GLOBALS['strDeliveryFilenamesAsyncSPC'] = "Async JavaScript Single Page Call";
$GLOBALS['strDeliveryCaching'] = "Banner kézbesítési gyorsítótár beállításai";
$GLOBALS['strDeliveryCacheLimit'] = "A banner gyorsítótár frissítései közti idő (másodpercekben)";
$GLOBALS['strDeliveryCacheStore'] = "Banner Delivery Cache Store Type";
$GLOBALS['strDeliveryAcls'] = "Evaluate banner delivery rules during delivery";
$GLOBALS['strDeliveryAclsDirectSelection'] = "Evaluate banner delivery rules for direct selected ads";
$GLOBALS['strDeliveryObfuscate'] = "Obfuscate delivery rule set when delivering ads";
$GLOBALS['strDeliveryCtDelimiter'] = "Harmadik féltől származó kattintás követési határolójel";
$GLOBALS['strGlobalDefaultBannerUrl'] = "Global default Banner Image URL";
$GLOBALS['strGlobalDefaultBannerInvalidZone'] = "Global default HTML Banner for non-existing zones";
$GLOBALS['strGlobalDefaultBannerSuspendedAccount'] = "Global default HTML Banner for suspended accounts";
$GLOBALS['strGlobalDefaultBannerInactiveAccount'] = "Global default HTML Banner for inactive accounts";
$GLOBALS['strP3PSettings'] = "P3P adatvédelmi irányelvek";
$GLOBALS['strUseP3P'] = "P3P irányelvek használata";
$GLOBALS['strP3PCompactPolicy'] = "P3P tömörített irányelv";
$GLOBALS['strP3PPolicyLocation'] = "P3P irányelvek helye";
$GLOBALS['strPrivacySettings'] = "Privacy Settings";
$GLOBALS['strDisableViewerId'] = "Disable unique Viewer Id cookie";
$GLOBALS['strAnonymiseIp'] = "Anonymise viewer IP addresses";

// General Settings
$GLOBALS['generalSettings'] = "Global General System Settings";
$GLOBALS['uiEnabled'] = "User Interface Enabled";
$GLOBALS['defaultLanguage'] = "Default System Language<br />(Each user can select their own language)";

// Geotargeting Settings
$GLOBALS['strGeotargetingSettings'] = "Geotargeting beállítások";
$GLOBALS['strGeotargeting'] = "Geotargeting beállítások";
$GLOBALS['strGeotargetingType'] = "Geotargeting modul típus";
$GLOBALS['strGeoShowUnavailable'] = "Show geotargeting delivery rules even if GeoIP data unavailable";

// Interface Settings
$GLOBALS['strInventory'] = "Leltár";
$GLOBALS['strShowCampaignInfo'] = "Extra kampány info megjelenítése a <i>Kampány áttekintés</i> oldalon";
$GLOBALS['strShowBannerInfo'] = "Extra banner info megjelenítése a <i>Banner áttekintés</i> oldalon";
$GLOBALS['strShowCampaignPreview'] = "Minden banner megjelenítése a <i>Banner áttekintés</i> oldalon";
$GLOBALS['strShowBannerHTML'] = "A HTML code helyett a tényleges banner megmutatása a HTML bannerek megjelenítésekor";
$GLOBALS['strShowBannerPreview'] = "Bannerek megjelenítése a kapcsolódó oldalak tetején";
$GLOBALS['strUseWyswygHtmlEditorByDefault'] = "Use the WYSIWYG HTML Editor by default when creating or editing HTML banners";
$GLOBALS['strHideInactive'] = "Az inaktív objektumok elrejtése az áttekintéses oldalakról";
$GLOBALS['strGUIShowMatchingBanners'] = "Egyező bannerek megjelenítése a <i>Linkelt banner</i> oldalakon";
$GLOBALS['strGUIShowParentCampaigns'] = "Szülő kampányok megjelenítése a <i>Linkelt banner</i> oldalakon";
$GLOBALS['strShowEntityId'] = "Show entity identifiers";
$GLOBALS['strStatisticsDefaults'] = "Statisztikák";
$GLOBALS['strBeginOfWeek'] = "Hét kezdete";
$GLOBALS['strPercentageDecimals'] = "Százalékok tört része";
$GLOBALS['strWeightDefaults'] = "Alapértelmezett súlyozás";
$GLOBALS['strDefaultBannerWeight'] = "Alapértelmezett  reklám súly";
$GLOBALS['strDefaultCampaignWeight'] = "Alapértelmezett  kampány súly";
$GLOBALS['strConfirmationUI'] = "Confirmation in User Interface";

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
$GLOBALS['strIgnoreUserAgents'] = "<b>Don't</b> log statistics from clients with any of the following strings in their user-agent (one-per-line)";
$GLOBALS['strEnforceUserAgents'] = "<b>Only</b> log statistics from clients with any of the following strings in their user-agent (one-per-line)";

// Banner Storage Settings
$GLOBALS['strBannerStorage'] = "Banner Storage Settings";

// Campaign ECPM settings
$GLOBALS['strEnableECPM'] = "Use eCPM optimized priorities instead of remnant-weighted priorities";
$GLOBALS['strEnableContractECPM'] = "Use eCPM optimized priorities instead of standard contract priorities";
$GLOBALS['strEnableECPMfromRemnant'] = "(If you enable this feature all your remnant campaigns will be deactivated, you will have to update them manually to reactivate them)";
$GLOBALS['strEnableECPMfromECPM'] = "(If you disable this feature some of your active eCPM campaigns will be deactivated, you will have to update them manually to reactivate them)";
$GLOBALS['strInactivatedCampaigns'] = "List of campaigns which became inactive due to the changes in preferences:";

// Statistics & Maintenance Settings
$GLOBALS['strMaintenanceSettings'] = "Maintenance Settings";
$GLOBALS['strConversionTracking'] = "Conversion Tracking Settings";
$GLOBALS['strEnableConversionTracking'] = "Enable Conversion Tracking";
$GLOBALS['strBlockInactiveBanners'] = "Don't count ad impressions, clicks or re-direct the user to the target URL if the viewer clicks on a banner that is inactive";
$GLOBALS['strBlockAdClicks'] = "Hírdetés kattintás számlálásának kihagyása ha a látogató kattintott az adott hírdetés/zóna párra a megadott időn belül (másodpercben)";
$GLOBALS['strMaintenanceOI'] = "Karbantartás művelet időköze (percben)";
$GLOBALS['strPrioritySettings'] = "Prioritás beállítások";
$GLOBALS['strPriorityInstantUpdate'] = "Hirdetés prioritások frissítése rögtön a változtatások mentése után";
$GLOBALS['strPriorityIntentionalOverdelivery'] = "Intentionally over-deliver Contract Campaigns<br />(% over-delivery)";
$GLOBALS['strDefaultImpConvWindow'] = "Alapértelmezett megtekintési konverziós ablak (másodpercben)";
$GLOBALS['strDefaultCliConvWindow'] = "Alapértelmezett kattintási konverziós ablak (másodpercben)";
$GLOBALS['strAdminEmailHeaders'] = "A következő fejlécek hozzáadása a {$PRODUCT_NAME} által küldött elektronikus üzenethez";
$GLOBALS['strWarnLimit'] = "Figyelmeztetés küldése ha a hátrelévő megtekintések száma kevesebb mint";
$GLOBALS['strWarnLimitDays'] = "Figyelmeztetés küldése ha a hátralévő napok száma kevesebb mint ";
$GLOBALS['strWarnAdmin'] = "Figyelmeztetés küldése az adminisztrátornak ha a kampány hamarosan lejár";
$GLOBALS['strWarnClient'] = "Figyelmeztetés küldése a hirdetőnek ha a kampány hamarosan lejár";
$GLOBALS['strWarnAgency'] = "Figyelmeztetés küldése az ügynökségnek ha a kampány hamarosan lejár";

// UI Settings
$GLOBALS['strGuiSettings'] = "Felhasználói felület beállításai";
$GLOBALS['strGeneralSettings'] = "Általános beállítások";
$GLOBALS['strAppName'] = "Alkalmazás neve";
$GLOBALS['strMyHeader'] = "Fejléc fájl helye";
$GLOBALS['strMyFooter'] = "Lábléc fájl helye";
$GLOBALS['strDefaultTrackerStatus'] = "Alapértelmezett követő státusz";
$GLOBALS['strDefaultTrackerType'] = "Alapértelmezett követő típus";
$GLOBALS['strSSLSettings'] = "SSL Settings";
$GLOBALS['requireSSL'] = "Force SSL Access on User Interface";
$GLOBALS['sslPort'] = "SSL Port Used by Web Server";
$GLOBALS['strDashboardSettings'] = "Dashboard Settings";
$GLOBALS['strMyLogo'] = "Egyedi logó fájl neve";
$GLOBALS['strGuiHeaderForegroundColor'] = "Fejléc előtér színe";
$GLOBALS['strGuiHeaderBackgroundColor'] = "Fejléc háttér színe";
$GLOBALS['strGuiActiveTabColor'] = "Az aktív fül színe";
$GLOBALS['strGuiHeaderTextColor'] = "A fejléc szövegének színe";
$GLOBALS['strGuiSupportLink'] = "Custom URL for 'Support' link in header";
$GLOBALS['strGzipContentCompression'] = "GZIP tartalom tömörítés használata";

// Regenerate Platfor Hash script
$GLOBALS['strPlatformHashRegenerate'] = "Platform Hash Regenerate";
$GLOBALS['strNewPlatformHash'] = "Your new Platform Hash is:";
$GLOBALS['strPlatformHashInsertingError'] = "Error inserting Platform Hash into database";

// Plugin Settings
$GLOBALS['strPluginSettings'] = "Plugin Settings";
$GLOBALS['strEnableNewPlugins'] = "Enable newly installed plugins";
$GLOBALS['strUseMergedFunctions'] = "Use merged delivery functions file";
