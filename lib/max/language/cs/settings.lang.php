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
$GLOBALS['strInstall']				= "Instalace";
$GLOBALS['strChooseInstallLanguage']		= "Vyberte si jazyk pro instalcni proceduru";
$GLOBALS['strLanguageSelection']		= "Vyber jazyka";
$GLOBALS['strDatabaseSettings']			= "Nastavení databáze";
$GLOBALS['strAdminSettings']			= "Nastavení administrátora";
$GLOBALS['strAdvancedSettings']			= "Rozsirena nastaveni databaze";
$GLOBALS['strOtherSettings']			= "Ostatni nastaveni";

$GLOBALS['strWarning']				= "Upozornění";
$GLOBALS['strFatalError']			= "Nastala fatalni chyba";
$GLOBALS['strUpdateError']			= "Nastala chyba pri aktualizaci";
$GLOBALS['strUpdateDatabaseError']	= "Z neznameho duvodu nebyla aktualizace databazove struktury uspesna. Doporucovany postup je kliknout na <b>Zopakuj aktualizaci</b> k zopakovani pokusu o aktualizaci a napravu problemu. Pokud jste si jist ze tyto chyby nenarusi funkcnost ".MAX_PRODUCT_NAME." muzete kliknout na <b>Ignorovat chyby</b> a pokracovat. Ignorovani techto chyb muze zpusobit zavazne problemy a neni doporucovane!";
$GLOBALS['strAlreadyInstalled']			= MAX_PRODUCT_NAME." je jiz instalovan. Pokud ho chcete konfigurovat bezte na <a href='settings-index.php'>rozhrani nastaveni</a>";
$GLOBALS['strCouldNotConnectToDB']		= "Nemohu se pripojit k databazi, prosim zkontrolujte zadane udaje. Take zkontrolujte zda databaze zadaneho jmena existuje na serveru. ".MAX_PRODUCT_NAME." pro vas tuto databazi nezalozi, musite ji rucne vytvorit pred zapocetim instalace.";
$GLOBALS['strCreateTableTestFailed']		= "The user you specified doesn't have permission to create or update the database structure, please contact the database administrator.";
$GLOBALS['strUpdateTableTestFailed']		= "The user you specified doesn't have permission to update the database structure, please contact the database administrator.";
$GLOBALS['strTablePrefixInvalid']		= "Table prefix contains invalid characters";
$GLOBALS['strTableInUse']			= "The database which you specified is already used for ".MAX_PRODUCT_NAME.", please use a different table prefix, or read the manual for upgrading instructions.";
$GLOBALS['strTableWrongType']		= "The table type you selected isn't supported by your installation of ".$phpAds_dbmsname;
$GLOBALS['strMayNotFunction']			= "Before you continue, please correct these potential problems:";
$GLOBALS['strFixProblemsBefore']		= "The following item(s) need to be corrected before you can install ".MAX_PRODUCT_NAME.". If you have any questions about this error message, please read the <i>Administrator guide</i>, which is part of the package you downloaded.";
$GLOBALS['strFixProblemsAfter']			= "If you are not able to correct the problems listed above, please contact the administrator of the server you are trying to install ".MAX_PRODUCT_NAME." on. The administrator of the server may be able to help you.";
$GLOBALS['strIgnoreWarnings']			= "Ignorovat upozorneni";
$GLOBALS['strWarningDBavailable']		= "The version of PHP you are using doesn't have support for connecting to a ".$phpAds_dbmsname." database server. You need to enable the PHP ".$phpAds_dbmsname." extension before you can proceed.";
$GLOBALS['strWarningPHPversion']		= MAX_PRODUCT_NAME." requires PHP 4.0.3 or higher to function correctly. You are currently using {php_version}.";
$GLOBALS['strWarningRegisterGlobals']		= "The PHP configuration variable register_globals needs to be turned on.";
$GLOBALS['strWarningMagicQuotesGPC']		= "The PHP configuration variable magic_quotes_gpc needs to be turned on.";
$GLOBALS['strWarningMagicQuotesRuntime']	= "The PHP configuration variable magic_quotes_runtime needs to be turned off.";
$GLOBALS['strWarningFileUploads']		= "The PHP configuration variable file_uploads needs to be turned on.";
$GLOBALS['strWarningTrackVars']			= "The PHP configuration variable track_vars needs to be turned on.";
$GLOBALS['strWarningPREG']				= "The version of PHP you are using doesn't have support for PERL compatible regular expressions. You need to enable the PREG extension before you can proceed.";
$GLOBALS['strConfigLockedDetected']		= MAX_PRODUCT_NAME." has detected that your <b>config.inc.php</b> file is not writeable by the server. You can't proceed until you change permissions on the file. Read the supplied documentation if you don't know how to do that.";
$GLOBALS['strCantUpdateDB']  			= "It is currently not possible to update the database. If you decide to proceed, all existing banners, statistics and advertisers will be deleted.";
$GLOBALS['strIgnoreErrors']			= "Ignorovat chyby";
$GLOBALS['strRetryUpdate']			= "Zopakovat aktualizaci";
$GLOBALS['strTableNames']			= "Nazvy tabulek";
$GLOBALS['strTablesPrefix']			= "Prefix nazvu tabulek";
$GLOBALS['strTablesType']			= "Typ tabulky";

$GLOBALS['strInstallWelcome']			= "Welcome to ".MAX_PRODUCT_NAME;
$GLOBALS['strInstallMessage']			= "Before you can use ".MAX_PRODUCT_NAME." it needs to be configured and <br> the database needs to be created. Click <b>Proceed</b> to continue.";
$GLOBALS['strInstallSuccess']			= "<b>The installation of ".MAX_PRODUCT_NAME." is now complete.</b><br><br>In order for ".MAX_PRODUCT_NAME." to function correctly you also need\n						   to make sure the maintenance file is run every hour. More information about this subject can be found in the documentation.\n						   <br><br>Click <b>Proceed</b> to go the configuration page, where you can\n						   set up more settings. Please do not forget to lock the config.inc.php file when you are finished to prevent security\n						   breaches.";
$GLOBALS['strUpdateSuccess']			= "<b>The upgrade of ".MAX_PRODUCT_NAME." was succesful.</b><br><br>In order for ".MAX_PRODUCT_NAME." to function correctly you also need\n						   to make sure the maintenance file is run every hour (previously this was every day). More information about this subject can be found in the documentation.\n						   <br><br>Click <b>Proceed</b> to go to the administration interface. Please do not forget to lock the config.inc.php file\n						   to prevent security breaches.";
$GLOBALS['strInstallNotSuccessful']		= "<b>The installation of ".MAX_PRODUCT_NAME." was not succesful</b><br><br>Some portions of the install process could not be completed.\n						   It is possible these problems are only temporarily, in that case you can simply click <b>Proceed</b> and return to the\n						   first step of the install process. If you want to know more on what the error message below means, and how to solve it,\n						   please consult the supplied documentation.";
$GLOBALS['strErrorOccured']			= "Nastala tato chyba:";
$GLOBALS['strErrorInstallDatabase']		= "Databázová struktura nemohla být vytvořena.";
$GLOBALS['strErrorUpgrade'] 			= "Databáze sou�?asné instalace nemohla být aktualizována";
$GLOBALS['strErrorInstallConfig']		= "Konfigura�?ní soubor nebo databáze nemohla být aktualizována.";
$GLOBALS['strErrorInstallDbConnect']		= "Nepodařilo se připojit k databázi.";

$GLOBALS['strUrlPrefix']			= "Delivery Engine URL Prefix";
$GLOBALS['strUrlPrefix']			= "Delivery Engine SSL URL Prefix";

$GLOBALS['strProceed']				= "Pokra�?ovat >";
$GLOBALS['strInvalidUserPwd']			= "Špatné jméno nebo heslo";

$GLOBALS['strUpgrade']				= "Aktualizace";
$GLOBALS['strSystemUpToDate']			= "Your system is already up to date, no upgrade is needed at the moment. <br>Click on <b>Proceed</b> to go to home page.";
$GLOBALS['strSystemNeedsUpgrade']		= "The database structure and configuration file need to be upgraded in order to function correctly. Click <b>Proceed</b> to start the upgrade process. <br><br>Depending on which version you are upgrading from and how many statistics are already stored in the database, this process can cause high load on your database server. Please be patient, the upgrade can take up to a couple of minutes.";
$GLOBALS['strSystemUpgradeBusy']		= "System upgrade in progress, please wait...";
$GLOBALS['strSystemRebuildingCache']		= "Rebuilding cache, please wait...";
$GLOBALS['strServiceUnavalable']		= "The service is temporarily unavailable. System upgrade in progress";

$GLOBALS['strConfigNotWritable']		= "Your config.inc.php file is not writable";



/*********************************************************/
/* Configuration translations                            */
/*********************************************************/

// Global
$GLOBALS['strChooseSection']			= "Vyberte sekci";
$GLOBALS['strDayFullNames'][0] = "Neděle";
$GLOBALS['strDayFullNames'][1] = "Pondělí";
$GLOBALS['strDayFullNames'][2] = "Úterý";
$GLOBALS['strDayFullNames'][3] = "Středa";
$GLOBALS['strDayFullNames'][4] = "Čtvrtek";
$GLOBALS['strDayFullNames'][5] = "Pátek";
$GLOBALS['strDayFullNames'][6] = "Sobota";

$GLOBALS['strEditConfigNotPossible']   		= "Není možné upravit tato nastavení, neboť konfigura�?ní soubor je z bezpe�?nostních důvodů uzam�?en.";
$GLOBALS['strEditConfigPossible']		= "Je možné provádět změny v nastavení, neboť konfigura�?ní soubor není uzam�?en. Toto ale může způsobit bezpe�?nostní problémy.";



// Database
$GLOBALS['strDatabaseSettings']			= "Nastavení databáze";
$GLOBALS['strDatabaseServer']			= "Databázový server";
$GLOBALS['strDbLocal']				= "Připojit k lokálnímu serveru pomocí soketů"; // Pg only
$GLOBALS['strDbHost']				= "Hostname databáze";
$GLOBALS['strDbPort']				= "Port databáze";
$GLOBALS['strDbUser']				= "Uživatel databáze";
$GLOBALS['strDbPassword']			= "Heslo databáze";
$GLOBALS['strDbName']				= "Jméno databáze";

$GLOBALS['strDatabaseOptimalisations']		= "Optimalizace databáze";
$GLOBALS['strPersistentConnections']		= "Použít trvalé připojení";
$GLOBALS['strInsertDelayed']			= "Použít spožděné inserty";
$GLOBALS['strCompatibilityMode']		= "Použít mód kompatibility databáze";
$GLOBALS['strCantConnectToDb']			= "Nemohu se připojit k databázi";



// Invocation and Delivery
$GLOBALS['strInvocationAndDelivery']		= "Nastavení volání a doru�?ování";

$GLOBALS['strAllowedInvocationTypes']		= "Povolené typy volání";
$GLOBALS['strAllowRemoteInvocation']		= "Povolit vzdálené volání";
$GLOBALS['strAllowRemoteInvocation']		= "Povolit vzdálené volání - bez cookies";
$GLOBALS['strAllowRemoteJavascript']		= "Povolit vzdálené volání Javascriptem";
$GLOBALS['strAllowRemoteFrames']		= "Povolit vzdálené volání pomocí Frames";
$GLOBALS['strAllowRemoteXMLRPC']		= "Povolit vzdálené volání pomocí XML-RPC";
$GLOBALS['strAllowLocalmode']			= "Povolit lokální mód";
$GLOBALS['strAllowInterstitial']		= "Povolit Interstitialy";
$GLOBALS['strAllowPopups']			= "Povolit Popupy";

$GLOBALS['strUseAcl']				= "Vyhodnocovat omezení doru�?ování v průbehu doru�?ování";

$GLOBALS['strDeliverySettings']			= "Nastavení doru�?ování";
$GLOBALS['strCacheType']				= "Typ doru�?ovací cache";
$GLOBALS['strCacheFiles']				= "Soubory";
$GLOBALS['strCacheDatabase']			= "Databáze";
$GLOBALS['strCacheShmop']				= "Sdílená paměť/Shmop";
$GLOBALS['strCacheSysvshm']				= "Sdílená paměť/Sysvshm";
$GLOBALS['strExperimental']				= "Experimentální";
$GLOBALS['strKeywordRetrieval']			= "Na�?ítání klí�?ových slov";
$GLOBALS['strBannerRetrieval']			= "Způsob na�?ítání bannerů";
$GLOBALS['strRetrieveRandom']			= "Náhodné na�?ítání bannerů (standardní)";
$GLOBALS['strRetrieveNormalSeq']		= "Normální sekven�?ní na�?ítání bannerů";
$GLOBALS['strWeightSeq']			= "Vážené sekven�?ní na�?ítání bannerů";
$GLOBALS['strFullSeq']				= "Plně sekven�?ní na�?ítání bannerů";
$GLOBALS['strUseKeywords']				= "Použít klí�?ová slova k volbě bannerů";
$GLOBALS['strUseConditionalKeys']		= "Povolit logické operatory při použití přímé volby";
$GLOBALS['strUseMultipleKeys']			= "Povolit vícero klí�?ových slov při použití přímé volby";

$GLOBALS['strZonesSettings']			= "Na�?ítání zón";
$GLOBALS['strZoneCache']			= "Cacheování zón, toto zrychlí na�?ítání při použití zón";
$GLOBALS['strZoneCacheLimit']			= "Čas mezi obnovami cache (ve vteřinách)";
$GLOBALS['strZoneCacheLimitErr']		= "Čas mezi obnovami cache musí být kladné �?íslo";

$GLOBALS['strP3PSettings']			= "Pravidla soukromí P3P";
$GLOBALS['strUseP3P']				= "Použít P3P pravidla";
$GLOBALS['strP3PCompactPolicy']			= "Kompaktní P3P pravidlo";
$GLOBALS['strP3PPolicyLocation']		= "Umístění P3P pravidla";



// Banner Settings
$GLOBALS['strBannerSettings']			= "Nastavení banneru";

$GLOBALS['strAllowedBannerTypes']		= "Povolené typy bannerů";
$GLOBALS['strTypeSqlAllow']			= "Povolit lokální bannery (SQL)";
$GLOBALS['strTypeWebAllow']			= "Povolit lokální bannery (Webserver)";
$GLOBALS['strTypeUrlAllow']			= "Povolit externí bannery";
$GLOBALS['strTypeHtmlAllow']			= "Povolit HTML bannery";
$GLOBALS['strTypeTxtAllow']			= "Povolit textovou reklamu";

$GLOBALS['strTypeWebSettings']			= "Nastavení lokálních bannerů (Webserver)";
$GLOBALS['strTypeWebMode']			= "Typ ukládání";
$GLOBALS['strTypeWebModeLocal']			= "Lokální adresář";
$GLOBALS['strTypeWebModeFtp']			= "Externí FTP server";
$GLOBALS['strTypeWebDir']			= "Lokální adresář";
$GLOBALS['strTypeWebFtp']			= "Server bannerů FTP režimu";
$GLOBALS['strTypeWebUrl']			= "Veřejné URL";
$GLOBALS['strTypeWebSslUrl']			= "Veřejné URL (SSL)";
$GLOBALS['strTypeFTPHost']			= "Server FTP";
$GLOBALS['strTypeFTPDirectory']			= "Adresář serveru";
$GLOBALS['strTypeFTPUsername']			= "Přihlásit";
$GLOBALS['strTypeFTPPassword']			= "Heslo";
$GLOBALS['strTypeFTPErrorDir']			= "Adresář serveru neexistuje";
$GLOBALS['strTypeFTPErrorConnect']		= "Nemohu se přihlásit k FTP serveru. Uživatelské jméno a heslo nejsou správné";
$GLOBALS['strTypeFTPErrorHost']			= "Jméno FTP server není správné";
$GLOBALS['strTypeDirError']				= "Lokální adresář neexistuje";



$GLOBALS['strDefaultBanners']			= "Implicitní bannery";
$GLOBALS['strDefaultBannerUrl']			= "URL implicitního obrázku";
$GLOBALS['strDefaultBannerTarget']		= "Implicitní cílové URL";

$GLOBALS['strTypeHtmlSettings']			= "Parametry HTML banneru";
$GLOBALS['strTypeHtmlAuto']			= "Automaticky uprav HTML bannery aby bylo možné sledovat kliknutí";
$GLOBALS['strTypeHtmlPhp']			= "Povolit spouštění PHP výrazů z HTML bannerů";



// Host information and Geotargeting
$GLOBALS['strHostAndGeo']				= "Informace o hostech a geocílení";

$GLOBALS['strRemoteHost']				= "Vzdálený host";
$GLOBALS['strReverseLookup']			= "Pokus se ur�?it název hostitele návštěníka pokud není poskytnuto serverem";
$GLOBALS['strProxyLookup']				= "Pokus se ur�?it pravou IP adresu navštěvníka, který používá proxy server";
$GLOBALS['strObfuscate']				= "O�?esat zdrojový kód pro doru�?ování reklamy.";

$GLOBALS['strGeotargeting']				= "Geocílení";
$GLOBALS['strGeotrackingType']			= "Typ databáze geocílení";
$GLOBALS['strGeotrackingLocation'] 		= "Místo databáze Geocílení";
$GLOBALS['strGeotrackingLocationError'] = "Databáze Geocílení neexistuje v místě které jste zadal";
$GLOBALS['strGeoStoreCookie']			= "Uložit cookie s výsledkem pro příště";



// Statistics Settings
$GLOBALS['strStatisticsSettings']		= "Nastavení statistik";

$GLOBALS['strStatisticsFormat']			= "Formát statistik";
$GLOBALS['strCompactStats']				= "Formát statistik";
$GLOBALS['strLogAdviews']				= "Logovat zobrazení při každém doru�?ení banneru";
$GLOBALS['strLogAdclicks']				= "Logovat kliknuí pří každém kliknutí na banner";
$GLOBALS['strLogAdConversions']			= "Logovat prodeje při každém zobrazení stránky se sledovacím kódem";
$GLOBALS['strLogSource']				= "Logovat parametr zdroje předaný při volání";
$GLOBALS['strGeoLogStats']				= "Logovat zemi návštěvníka ve statistikách";
$GLOBALS['strLogHostnameOrIP']			= "Logovat jméno hostitele nebo IP adresu návštěvníka";
$GLOBALS['strLogIPOnly']				= "Logovat pouze IP addresu návštěvníka i když je znám název hostitele";
$GLOBALS['strLogIP']					= "Logovat IP addresu návštěvníka";
$GLOBALS['strLogBeacon']				= "Používat malý markovací obrázek k logování AdViews aby bylo zajištěno že jsou logovány pouze doru�?ené bannery";

$GLOBALS['strRemoteHosts']				= "Vzdálení hostitelé";
$GLOBALS['strIgnoreHosts']				= "Neukládát statistiky pro návštěvníky užívající jednu z následujících IP adres nebo názvů hostitelů";
$GLOBALS['strBlockAdviews']				= "Nelogovat zobrazení pokud návštěvník viděl stejný banner v průběhu zadaného po�?tu vteřin";
$GLOBALS['strBlockAdclicks']			= "Nelogovat kliknuti pokud návštěvník kliknul na stejný banner v průběhu zadaného po�?tu vteřin";
$GLOBALS['strBlockAdConversions']		= "Nelogovat prodeje pokud návštěvník navštívil stránku se sledovacím kódem v průběhu zadaného po�?tu vteřin";


$GLOBALS['strPreventLogging']			= "Zamezit logování";
$GLOBALS['strEmailWarnings']			= "E-mailová upozornění";
$GLOBALS['strAdminEmailHeaders']		= "Přidej následujíc hlavi�?ku ke každé správě poslané ".MAX_PRODUCT_NAME;
$GLOBALS['strWarnLimit']				= "Poslat upozornění když po�?et zbývajících impresí je nižší než zde uvedený";
$GLOBALS['strWarnLimitErr']				= "Limit pro upozornění by mělo být kladné �?íslo";
$GLOBALS['strWarnAdmin']				= "Poslat upozornění správci kdykoliv je kampaň téměř vy�?erpána";
$GLOBALS['strWarnClient']				= "Poslat upozornění inzerentovi kdykoliv je kampaň téměř vy�?erpána";
$GLOBALS['strWarnAgency']				= "Poslat upozornění partnerovi kdykoliv je kampaň téměř vy�?erpána";
$GLOBALS['strQmailPatch']				= "Zapnout qmail patch";

$GLOBALS['strAutoCleanTables']			= "Čištění databáze";
$GLOBALS['strAutoCleanStats']			= "Čistit statistiky";
$GLOBALS['strAutoCleanUserlog']			= "Čistit log uživatelů";
$GLOBALS['strAutoCleanStatsWeeks']		= "Maximální stáří statistik <br>(minimálně 3 týdny)";
$GLOBALS['strAutoCleanUserlogWeeks']	= "Maximální stáří logu uživatelů <br>(minimálně 3 týdny)";
$GLOBALS['strAutoCleanErr']				= "Maximální stří musí být výšší než 3 týdny";
$GLOBALS['strAutoCleanVacuum']			= "VACUUM ANALYZE tabulky každou noc"; // only Pg


// Administrator settings
$GLOBALS['strAdministratorSettings']		= "Nastavení administrátora";

$GLOBALS['strLoginCredentials']			= "Přihlašovací údaje";
$GLOBALS['strAdminUsername']			= "Jméno Admina";
$GLOBALS['strInvalidUsername']			= "Špatné Jméno";

$GLOBALS['strBasicInformation']			= "Základní údaje";
$GLOBALS['strAdminFullName']			= "Celé jméno";
$GLOBALS['strAdminEmail']			= "Emailová adresa";
$GLOBALS['strCompanyName']			= "Název firmy";

$GLOBALS['strAdminCheckUpdates']		= "Kontrolovat aktualizace";
$GLOBALS['strAdminCheckEveryLogin']		= "Při přihlášení";
$GLOBALS['strAdminCheckDaily']			= "Denně";
$GLOBALS['strAdminCheckWeekly']			= "Týdenně";
$GLOBALS['strAdminCheckMonthly']		= "Měsí�?ně";
$GLOBALS['strAdminCheckNever']			= "Nikdy";

$GLOBALS['strAdminNovice']			= "Mazací akce Admina vyžadují z bezpe�?nostních důvodů potvrzení";
$GLOBALS['strUserlogEmail']			= "Logovat veškerou odchozí poštu";
$GLOBALS['strUserlogPriority']			= "Logovat hodinové kalkulace priorit";
$GLOBALS['strUserlogAutoClean']			= "Logovat automatické �?ištění databáze";


// User interface settings
$GLOBALS['strGuiSettings']			= "Nastavení uživatelského rozhraní";

$GLOBALS['strGeneralSettings']			= "Základní nastavení";
$GLOBALS['strAppName']				= "Název aplikace";
$GLOBALS['strMyHeader']				= "Umístění souboru hlavi�?ky";
$GLOBALS['strMyHeaderError']		= "Soubor hlavi�?ky neexistuje v místě které jste zadal";
$GLOBALS['strMyFooter']				= "Umístění souboru pati�?ky";
$GLOBALS['strMyFooterError']		= "Soubor pati�?ky neexistuje v místě které jste zadal";
$GLOBALS['strGzipContentCompression']		= "Použít kompresi obsahu GZIPem";

$GLOBALS['strClientInterface']			= "Rozhraní inzerenta";
$GLOBALS['strClientWelcomeEnabled']		= "Zapnout uvítací text inzerenta";
$GLOBALS['strClientWelcomeText']		= "Uvítací text<br>(HTML tagy jsou povoleny)";

$GLOBALS['strInstantUpdateSettings']    = "Aktualizovat priority v reálném �?ase";
$GLOBALS['strInstantUpdate']            = "Povolit aktualizace v reálném �?ase";
$GLOBALS['strInstantUpdatePriority']    = "Aktualizovat priority";
$GLOBALS['strInstantUpdateCache']       = "Expirovat soubory cache";


// Interface defaults
$GLOBALS['strInterfaceDefaults']		= "Implicitní parametry rozhraní";

$GLOBALS['strInventory']			= "Inventář";
$GLOBALS['strShowCampaignInfo']			= "Zobrazit extra informace o kampani na stránce <i>Přehled kampaně</i>";
$GLOBALS['strShowBannerInfo']			= "Zobrazit extra informace o banneru na stránce <i>Přehled banneru</i>";
$GLOBALS['strShowCampaignPreview']		= "Zobrazit náhled všech bannerů na stránce <i>Přehled banneru</i>";
$GLOBALS['strShowBannerHTML']			= "Zobrazit banner místo HTML kódu pro náhled HTML banneru";
$GLOBALS['strShowBannerPreview']		= "Zobrazit náhled banneru na konci stránek které pracují s bannery";
$GLOBALS['strHideInactive']			= "Skrýt neaktivní položky ze všech přehledových stránek";
$GLOBALS['strGUIShowMatchingBanners']		= "Zobrazit odpovídající bannery na stránce <i>Připojený banner</i>";
$GLOBALS['strGUIShowParentCampaigns']		= "Zobrazit nadřazenou kampaň na stránce <i>Připojený banner</i>";
$GLOBALS['strGUILinkCompactLimit']		= "Skrýt nepřipojené kampaně nebo bannery na stránce <i>Připojený banner</i> když je jich více než";

$GLOBALS['strStatisticsDefaults'] 		= "Statistiky";
$GLOBALS['strBeginOfWeek']			= "Po�?átek týdne";
$GLOBALS['strPercentageDecimals']		= "Desetinná místa procent";

$GLOBALS['strWeightDefaults']			= "Implicitní váha";
$GLOBALS['strDefaultBannerWeight']		= "Implicitní váha banneru";
$GLOBALS['strDefaultCampaignWeight']		= "Implicitní váha kampaně";
$GLOBALS['strDefaultBannerWErr']		= "Implicitní váha banneru by měla být kladné �?íslo";
$GLOBALS['strDefaultCampaignWErr']		= "Implicitní váha kampaně by měla být kladné �?íslo";



// Not used at the moment
$GLOBALS['strTableBorderColor']			= "Barva okraje tabulky";
$GLOBALS['strTableBackColor']			= "Barva pozadí tabulky";
$GLOBALS['strTableBackColorAlt']		= "Barva pozadí tabulky (alternativní)";
$GLOBALS['strMainBackColor']			= "Základní barva pozadí";
$GLOBALS['strOverrideGD']			= "Anulovat formát obrázku GD";
$GLOBALS['strTimeZone']				= "Časové pásmo";



// Note: New translations not found in original lang files but found in CSV
$GLOBALS['strDbSetupTitle'] = "Nastavení databáze";
$GLOBALS['strDeliveryUrlPrefix'] = "Doru�?ovací engine";
$GLOBALS['strDeliveryUrlPrefixSSL'] = "Doru�?ovací engine";
$GLOBALS['strDbType'] = "Jméno databáze";
$GLOBALS['strDebugTypeFile'] = "Soubory";
$GLOBALS['strDeliveryPath'] = "Cache doru�?ování";
$GLOBALS['strDeliverySslPath'] = "Cache doru�?ování";
$GLOBALS['strGeotargetingSettings'] = "Geocílení";
$GLOBALS['strEnableQmailPatch'] = "Zapnout qmail patch";
$GLOBALS['strEmailSettings'] = "Základní nastavení";
$GLOBALS['strBannerLogging'] = "Zamezit logování";
$GLOBALS['strDefaultConversionStatus'] = "Implicitní pravidla prodeje";
$GLOBALS['strDefaultConversionType'] = "Implicitní pravidla prodeje";
?>