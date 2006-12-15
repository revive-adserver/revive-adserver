<?php

/*
+---------------------------------------------------------------------------+
| Max Media Manager v0.1                                                    |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2006 m3 Media Services Limited                         |
| For contact details, see: http://www.m3.net/                              |
|                                                                           |
| Copyright (c) 2000-2003 the phpAdsNew developers                          |
| For contact details, see: http://www.phpadsnew.com/                       |
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
$Id: settings.lang.php 3145 2005-10-12 12:30:00Z axelo $
*/ 


// Installer translation strings
$GLOBALS['strInstall']				= "Instalace";
$GLOBALS['strChooseInstallLanguage']		= "Vyberte si jazyk pro instalcni proceduru";
$GLOBALS['strLanguageSelection']		= "Vyber jazyka";
$GLOBALS['strDatabaseSettings']			= "Nastaveni databaze";
$GLOBALS['strAdminSettings']			= "Nastaveni administratora";
$GLOBALS['strAdvancedSettings']			= "Rozsirena nastaveni databaze";
$GLOBALS['strOtherSettings']			= "Ostatni nastaveni";

$GLOBALS['strWarning']				= "Upozornìní";
$GLOBALS['strFatalError']			= "Nastala fatalni chyba";
$GLOBALS['strUpdateError']			= "Nastala chyba pri aktualizaci";
$GLOBALS['strUpdateDatabaseError']	= "Z neznameho duvodu nebyla aktualizace databazove struktury uspesna. Doporucovany postup je kliknout na <b>Zopakuj aktualizaci</b> k zopakovani pokusu o aktualizaci a napravu problemu. Pokud jste si jist ze tyto chyby nenarusi funkcnost ".$phpAds_productname." muzete kliknout na <b>Ignorovat chyby</b> a pokracovat. Ignorovani techto chyb muze zpusobit zavazne problemy a neni doporucovane!";
$GLOBALS['strAlreadyInstalled']			= $phpAds_productname." je jiz instalovan. Pokud ho chcete konfigurovat bezte na <a href='settings-index.php'>rozhrani nastaveni</a>";
$GLOBALS['strCouldNotConnectToDB']		= "Nemohu se pripojit k databazi, prosim zkontrolujte zadane udaje. Take zkontrolujte zda databaze zadaneho jmena existuje na serveru. ".$phpAds_productname." pro vas tuto databazi nezalozi, musite ji rucne vytvorit pred zapocetim instalace.";
$GLOBALS['strCreateTableTestFailed']		= "The user you specified doesn't have permission to create or update the database structure, please contact the database administrator.";
$GLOBALS['strUpdateTableTestFailed']		= "The user you specified doesn't have permission to update the database structure, please contact the database administrator.";
$GLOBALS['strTablePrefixInvalid']		= "Table prefix contains invalid characters";
$GLOBALS['strTableInUse']			= "The database which you specified is already used for ".$phpAds_productname.", please use a different table prefix, or read the manual for upgrading instructions.";
$GLOBALS['strTableWrongType']		= "The table type you selected isn't supported by your installation of ".$phpAds_dbmsname;
$GLOBALS['strMayNotFunction']			= "Before you continue, please correct these potential problems:";
$GLOBALS['strFixProblemsBefore']		= "The following item(s) need to be corrected before you can install ".$phpAds_productname.". If you have any questions about this error message, please read the <i>Administrator guide</i>, which is part of the package you downloaded.";
$GLOBALS['strFixProblemsAfter']			= "If you are not able to correct the problems listed above, please contact the administrator of the server you are trying to install ".$phpAds_productname." on. The administrator of the server may be able to help you.";
$GLOBALS['strIgnoreWarnings']			= "Ignorovat upozorneni";
$GLOBALS['strWarningDBavailable']		= "The version of PHP you are using doesn't have support for connecting to a ".$phpAds_dbmsname." database server. You need to enable the PHP ".$phpAds_dbmsname." extension before you can proceed.";
$GLOBALS['strWarningPHPversion']		= $phpAds_productname." requires PHP 4.0.3 or higher to function correctly. You are currently using {php_version}.";
$GLOBALS['strWarningRegisterGlobals']		= "The PHP configuration variable register_globals needs to be turned on.";
$GLOBALS['strWarningMagicQuotesGPC']		= "The PHP configuration variable magic_quotes_gpc needs to be turned on.";
$GLOBALS['strWarningMagicQuotesRuntime']	= "The PHP configuration variable magic_quotes_runtime needs to be turned off.";
$GLOBALS['strWarningFileUploads']		= "The PHP configuration variable file_uploads needs to be turned on.";
$GLOBALS['strWarningTrackVars']			= "The PHP configuration variable track_vars needs to be turned on.";
$GLOBALS['strWarningPREG']				= "The version of PHP you are using doesn't have support for PERL compatible regular expressions. You need to enable the PREG extension before you can proceed.";
$GLOBALS['strConfigLockedDetected']		= $phpAds_productname." has detected that your <b>config.inc.php</b> file is not writeable by the server. You can't proceed until you change permissions on the file. Read the supplied documentation if you don't know how to do that.";
$GLOBALS['strCantUpdateDB']  			= "It is currently not possible to update the database. If you decide to proceed, all existing banners, statistics and advertisers will be deleted.";
$GLOBALS['strIgnoreErrors']			= "Ignorovat chyby";
$GLOBALS['strRetryUpdate']			= "Zopakovat aktualizaci";
$GLOBALS['strTableNames']			= "Nazvy tabulek";
$GLOBALS['strTablesPrefix']			= "Prefix nazvu tabulek";
$GLOBALS['strTablesType']			= "Typ tabulky";

$GLOBALS['strInstallWelcome']			= "Welcome to ".$phpAds_productname;
$GLOBALS['strInstallMessage']			= "Before you can use ".$phpAds_productname." it needs to be configured and <br> the database needs to be created. Click <b>Proceed</b> to continue.";
$GLOBALS['strInstallSuccess']			= "<b>The installation of ".$phpAds_productname." is now complete.</b><br><br>In order for ".$phpAds_productname." to function correctly you also need
						   to make sure the maintenance file is run every hour. More information about this subject can be found in the documentation.
						   <br><br>Click <b>Proceed</b> to go the configuration page, where you can 
						   set up more settings. Please do not forget to lock the config.inc.php file when you are finished to prevent security
						   breaches.";
$GLOBALS['strUpdateSuccess']			= "<b>The upgrade of ".$phpAds_productname." was succesful.</b><br><br>In order for ".$phpAds_productname." to function correctly you also need
						   to make sure the maintenance file is run every hour (previously this was every day). More information about this subject can be found in the documentation.
						   <br><br>Click <b>Proceed</b> to go to the administration interface. Please do not forget to lock the config.inc.php file 
						   to prevent security breaches.";
$GLOBALS['strInstallNotSuccessful']		= "<b>The installation of ".$phpAds_productname." was not succesful</b><br><br>Some portions of the install process could not be completed.
						   It is possible these problems are only temporarily, in that case you can simply click <b>Proceed</b> and return to the
						   first step of the install process. If you want to know more on what the error message below means, and how to solve it, 
						   please consult the supplied documentation.";
$GLOBALS['strErrorOccured']			= "Nastala tato chyba:";
$GLOBALS['strErrorInstallDatabase']		= "Databázová struktura nemohla být vytvoøena.";
$GLOBALS['strErrorUpgrade'] 			= "Databáze souèasné instalace nemohla být aktualizována"; 
$GLOBALS['strErrorInstallConfig']		= "Konfiguraèní soubor nebo databáze nemohla být aktualizována.";
$GLOBALS['strErrorInstallDbConnect']		= "Nepodaøilo se pøipojit k databázi.";

$GLOBALS['strUrlPrefix']			= "Delivery Engine URL Prefix";
$GLOBALS['strUrlPrefix']			= "Delivery Engine SSL URL Prefix";

$GLOBALS['strProceed']				= "Pokraèovat &gt;";
$GLOBALS['strInvalidUserPwd']			= "©patné jméno nebo heslo";

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
$GLOBALS['strDayFullNames'] 			= array("Nedìle","Pondìlí","Úterý","Støeda","Ètvrtek","Pátek","Sobota");
$GLOBALS['strEditConfigNotPossible']   		= "Není mo¾né upravit tato nastavení, nebo» konfiguraèní soubor je z bezpeènostních dùvodù uzamèen. ".
										  "Pokud chcete provádìt zmeny, musíte nejprve odemknout soubor config.inc.php.";
$GLOBALS['strEditConfigPossible']		= "Je mo¾né provádìt zmìny v nastavení, nebo» konfiguraèní soubor není uzamèen. Toto ale mù¾e zpùsobit bezpeènostní problémy. ".
										  "Pokud chcete zabezpeèit vá¹ systém, musíte uzamknout soubor config.inc.php.";



// Database
$GLOBALS['strDatabaseSettings']			= "Nastavení databáze";
$GLOBALS['strDatabaseServer']			= "Databázový server";
$GLOBALS['strDbLocal']				= "Pøipojit k lokálnímu serveru pomocí soketù"; // Pg only
$GLOBALS['strDbHost']				= "Hostname databáze";
$GLOBALS['strDbPort']				= "Port databáze";
$GLOBALS['strDbUser']				= "U¾ivatel databáze";
$GLOBALS['strDbPassword']			= "Heslo databáze";
$GLOBALS['strDbName']				= "Jméno databáze";

$GLOBALS['strDatabaseOptimalisations']		= "Optimalizace databáze";
$GLOBALS['strPersistentConnections']		= "Pou¾ít trvalé pøipojení";
$GLOBALS['strInsertDelayed']			= "Pou¾ít spo¾dìné inserty";
$GLOBALS['strCompatibilityMode']		= "Pou¾ít mód kompatibility databáze";
$GLOBALS['strCantConnectToDb']			= "Nemohu se pøipojit k databázi";



// Invocation and Delivery
$GLOBALS['strInvocationAndDelivery']		= "Nastavení volání a doruèování";

$GLOBALS['strAllowedInvocationTypes']		= "Povolené typy volání";
$GLOBALS['strAllowRemoteInvocation']		= "Povolit vzdálené volání";
$GLOBALS['strAllowRemoteInvocation']		= "Povolit vzdálené volání - bez cookies";
$GLOBALS['strAllowRemoteJavascript']		= "Povolit vzdálené volání Javascriptem";
$GLOBALS['strAllowRemoteFrames']		= "Povolit vzdálené volání pomocí Frames";
$GLOBALS['strAllowRemoteXMLRPC']		= "Povolit vzdálené volání pomocí XML-RPC";
$GLOBALS['strAllowLocalmode']			= "Povolit lokální mód";
$GLOBALS['strAllowInterstitial']		= "Povolit Interstitialy";
$GLOBALS['strAllowPopups']			= "Povolit Popupy";

$GLOBALS['strUseAcl']				= "Vyhodnocovat omezení doruèování v prùbehu doruèování";

$GLOBALS['strDeliverySettings']			= "Nastavení doruèování";
$GLOBALS['strCacheType']				= "Typ doruèovací cache";
$GLOBALS['strCacheFiles']				= "Soubory";
$GLOBALS['strCacheDatabase']			= "Databáze";
$GLOBALS['strCacheShmop']				= "Sdílená pamì»/Shmop";
$GLOBALS['strCacheSysvshm']				= "Sdílená pamì»/Sysvshm";
$GLOBALS['strExperimental']				= "Experimentální";
$GLOBALS['strKeywordRetrieval']			= "Naèítání klíèových slov";
$GLOBALS['strBannerRetrieval']			= "Zpùsob naèítání bannerù";
$GLOBALS['strRetrieveRandom']			= "Náhodné naèítání bannerù (standardní)";
$GLOBALS['strRetrieveNormalSeq']		= "Normální sekvenèní naèítání bannerù";
$GLOBALS['strWeightSeq']			= "Vá¾ené sekvenèní naèítání bannerù";
$GLOBALS['strFullSeq']				= "Plnì sekvenèní naèítání bannerù";
$GLOBALS['strUseKeywords']				= "Pou¾ít klíèová slova k volbì bannerù"; 
$GLOBALS['strUseConditionalKeys']		= "Povolit logické operatory pøi pou¾ití pøímé volby";
$GLOBALS['strUseMultipleKeys']			= "Povolit vícero klíèových slov pøi pou¾ití pøímé volby";

$GLOBALS['strZonesSettings']			= "Naèítání zón";
$GLOBALS['strZoneCache']			= "Cacheování zón, toto zrychlí naèítání pøi pou¾ití zón";
$GLOBALS['strZoneCacheLimit']			= "Èas mezi obnovami cache (ve vteøinách)";
$GLOBALS['strZoneCacheLimitErr']		= "Èas mezi obnovami cache musí být kladné èíslo";

$GLOBALS['strP3PSettings']			= "Pravidla soukromí P3P";
$GLOBALS['strUseP3P']				= "Pou¾ít P3P pravidla";
$GLOBALS['strP3PCompactPolicy']			= "Kompaktní P3P pravidlo";
$GLOBALS['strP3PPolicyLocation']		= "Umístìní P3P pravidla"; 



// Banner Settings
$GLOBALS['strBannerSettings']			= "Nastavení banneru";

$GLOBALS['strAllowedBannerTypes']		= "Povolené typy bannerù";
$GLOBALS['strTypeSqlAllow']			= "Povolit lokální bannery (SQL)";
$GLOBALS['strTypeWebAllow']			= "Povolit lokální bannery (Webserver)";
$GLOBALS['strTypeUrlAllow']			= "Povolit externí bannery";
$GLOBALS['strTypeHtmlAllow']			= "Povolit HTML bannery";
$GLOBALS['strTypeTxtAllow']			= "Povolit textovou reklamu";

$GLOBALS['strTypeWebSettings']			= "Nastavení lokálních bannerù (Webserver)";
$GLOBALS['strTypeWebMode']			= "Typ ukládání";
$GLOBALS['strTypeWebModeLocal']			= "Lokální adresáø";
$GLOBALS['strTypeWebModeFtp']			= "Externí FTP server";
$GLOBALS['strTypeWebDir']			= "Lokální adresáø";
$GLOBALS['strTypeWebFtp']			= "Server bannerù FTP re¾imu";
$GLOBALS['strTypeWebUrl']			= "Veøejné URL";
$GLOBALS['strTypeWebSslUrl']			= "Veøejné URL (SSL)";
$GLOBALS['strTypeFTPHost']			= "Server FTP";
$GLOBALS['strTypeFTPDirectory']			= "Adresáø serveru";
$GLOBALS['strTypeFTPUsername']			= "Jméno";
$GLOBALS['strTypeFTPPassword']			= "Heslo";
$GLOBALS['strTypeFTPErrorDir']			= "Adresáø serveru neexistuje";
$GLOBALS['strTypeFTPErrorConnect']		= "Nemohu se pøihlásit k FTP serveru. U¾ivatelské jméno a heslo nejsou správné";
$GLOBALS['strTypeFTPErrorHost']			= "Jméno FTP server není správné";
$GLOBALS['strTypeDirError']				= "Lokální adresáø neexistuje";



$GLOBALS['strDefaultBanners']			= "Implicitní bannery";
$GLOBALS['strDefaultBannerUrl']			= "URL implicitního obrázku";
$GLOBALS['strDefaultBannerTarget']		= "Implicitní cílové URL";

$GLOBALS['strTypeHtmlSettings']			= "Parametry HTML banneru";
$GLOBALS['strTypeHtmlAuto']			= "Automaticky uprav HTML bannery aby bylo mo¾né sledovat kliknutí";
$GLOBALS['strTypeHtmlPhp']			= "Povolit spou¹tìní PHP výrazù z HTML bannerù";



// Host information and Geotargeting
$GLOBALS['strHostAndGeo']				= "Informace o hostech a geocílení";

$GLOBALS['strRemoteHost']				= "Vzdálený host";
$GLOBALS['strReverseLookup']			= "Pokus se urèit název hostitele náv¹tìníka pokud není poskytnuto serverem";
$GLOBALS['strProxyLookup']				= "Pokus se urèit pravou IP adresu nav¹tìvníka, který pou¾ívá proxy server";
$GLOBALS['strObfuscate']				= "Oèesat zdrojový kód pro doruèování reklamy."; 

$GLOBALS['strGeotargeting']				= "Geocílení";
$GLOBALS['strGeotrackingType']			= "Typ databáze geocílení";
$GLOBALS['strGeotrackingLocation'] 		= "Místo databáze Geocílení";
$GLOBALS['strGeotrackingLocationError'] = "Databáze Geocílení neexistuje v místì které jste zadal";
$GLOBALS['strGeoStoreCookie']			= "Ulo¾it cookie s výsledkem pro pøí¹tì";



// Statistics Settings
$GLOBALS['strStatisticsSettings']		= "Nastavení statistik";

$GLOBALS['strStatisticsFormat']			= "Formát statistik";
$GLOBALS['strCompactStats']				= "Formát statistik";
$GLOBALS['strLogAdviews']				= "Logovat zobrazení pøi ka¾dém doruèení banneru";
$GLOBALS['strLogAdclicks']				= "Logovat kliknuí pøí ka¾dém kliknutí na banner";
$GLOBALS['strLogAdConversions']			= "Logovat prodeje pøi ka¾dém zobrazení stránky se sledovacím kódem"; 
$GLOBALS['strLogSource']				= "Logovat parametr zdroje pøedaný pøi volání";
$GLOBALS['strGeoLogStats']				= "Logovat zemi náv¹tìvníka ve statistikách";
$GLOBALS['strLogHostnameOrIP']			= "Logovat jméno hostitele nebo IP adresu náv¹tìvníka";
$GLOBALS['strLogIPOnly']				= "Logovat pouze IP addresu náv¹tìvníka i kdy¾ je znám název hostitele";
$GLOBALS['strLogIP']					= "Logovat IP addresu náv¹tìvníka";
$GLOBALS['strLogBeacon']				= "Pou¾ívat malý markovací obrázek k logování AdViews aby bylo zaji¹tìno ¾e jsou logovány pouze doruèené bannery";

$GLOBALS['strRemoteHosts']				= "Vzdálení hostitelé";
$GLOBALS['strIgnoreHosts']				= "Neukládát statistiky pro náv¹tìvníky u¾ívající jednu z následujících IP adres nebo názvù hostitelù";
$GLOBALS['strBlockAdviews']				= "Nelogovat zobrazení pokud náv¹tìvník vidìl stejný banner v prùbìhu zadaného poètu vteøin";
$GLOBALS['strBlockAdclicks']			= "Nelogovat kliknuti pokud náv¹tìvník kliknul na stejný banner v prùbìhu zadaného poètu vteøin";
$GLOBALS['strBlockAdConversions']		= "Nelogovat prodeje pokud náv¹tìvník nav¹tívil stránku se sledovacím kódem v prùbìhu zadaného poètu vteøin";


$GLOBALS['strPreventLogging']			= "Zamezit logování";
$GLOBALS['strEmailWarnings']			= "E-mailová upozornìní";
$GLOBALS['strAdminEmailHeaders']		= "Pøidej následujíc hlavièku ke ka¾dé správì poslané ".$phpAds_productname;
$GLOBALS['strWarnLimit']				= "Poslat upozornìní kdy¾ poèet zbývajících impresí je ni¾¹í ne¾ zde uvedený";
$GLOBALS['strWarnLimitErr']				= "Limit pro upozornìní by mìlo být kladné èíslo";
$GLOBALS['strWarnAdmin']				= "Poslat upozornìní správci kdykoliv je kampaò témìø vyèerpána";
$GLOBALS['strWarnClient']				= "Poslat upozornìní inzerentovi kdykoliv je kampaò témìø vyèerpána";
$GLOBALS['strWarnAgency']				= "Poslat upozornìní partnerovi kdykoliv je kampaò témìø vyèerpána"; 
$GLOBALS['strQmailPatch']				= "Zapnout qmail patch";

$GLOBALS['strAutoCleanTables']			= "Èi¹tìní databáze";
$GLOBALS['strAutoCleanStats']			= "Èistit statistiky";
$GLOBALS['strAutoCleanUserlog']			= "Èistit log u¾ivatelù";
$GLOBALS['strAutoCleanStatsWeeks']		= "Maximální stáøí statistik <br>(minimálnì 3 týdny)";
$GLOBALS['strAutoCleanUserlogWeeks']	= "Maximální stáøí logu u¾ivatelù <br>(minimálnì 3 týdny)";
$GLOBALS['strAutoCleanErr']				= "Maximální støí musí být vý¹¹í ne¾ 3 týdny";
$GLOBALS['strAutoCleanVacuum']			= "VACUUM ANALYZE tabulky ka¾dou noc"; // only Pg


// Administrator settings
$GLOBALS['strAdministratorSettings']		= "Nastavení administrátora";

$GLOBALS['strLoginCredentials']			= "Pøihla¹ovací údaje";
$GLOBALS['strAdminUsername']			= "Jméno Admina";
$GLOBALS['strInvalidUsername']			= "©patné Jméno";

$GLOBALS['strBasicInformation']			= "Základní údaje";
$GLOBALS['strAdminFullName']			= "Celé jméno";
$GLOBALS['strAdminEmail']			= "Emailová adresa";
$GLOBALS['strCompanyName']			= "Název firmy";

$GLOBALS['strAdminCheckUpdates']		= "Kontrolovat aktualizace";
$GLOBALS['strAdminCheckEveryLogin']		= "Pøi pøihlá¹ení";
$GLOBALS['strAdminCheckDaily']			= "Dennì";
$GLOBALS['strAdminCheckWeekly']			= "Týdennì";
$GLOBALS['strAdminCheckMonthly']		= "Mìsíènì";
$GLOBALS['strAdminCheckNever']			= "Nikdy";

$GLOBALS['strAdminNovice']			= "Mazací akce Admina vy¾adují z bezpeènostních dùvodù potvrzení";
$GLOBALS['strUserlogEmail']			= "Logovat ve¹kerou odchozí po¹tu";
$GLOBALS['strUserlogPriority']			= "Logovat hodinové kalkulace priorit";
$GLOBALS['strUserlogAutoClean']			= "Logovat automatické èi¹tìní databáze";


// User interface settings
$GLOBALS['strGuiSettings']			= "Nastavení u¾ivatelského rozhraní";

$GLOBALS['strGeneralSettings']			= "Základní nastavení";
$GLOBALS['strAppName']				= "Název aplikace";
$GLOBALS['strMyHeader']				= "Umístìní souboru hlavièky";
$GLOBALS['strMyHeaderError']		= "Soubor hlavièky neexistuje v místì které jste zadal";
$GLOBALS['strMyFooter']				= "Umístìní souboru patièky";
$GLOBALS['strMyFooterError']		= "Soubor patièky neexistuje v místì které jste zadal";
$GLOBALS['strGzipContentCompression']		= "Pou¾ít kompresi obsahu GZIPem";

$GLOBALS['strClientInterface']			= "Rozhraní inzerenta";
$GLOBALS['strClientWelcomeEnabled']		= "Zapnout uvítací text inzerenta";
$GLOBALS['strClientWelcomeText']		= "Uvítací text<br>(HTML tagy jsou povoleny)";

$GLOBALS['strInstantUpdateSettings']    = "Aktualizovat priority v reálném èase";
$GLOBALS['strInstantUpdate']            = "Povolit aktualizace v reálném èase";
$GLOBALS['strInstantUpdatePriority']    = "Aktualizovat priority";
$GLOBALS['strInstantUpdateCache']       = "Expirovat soubory cache";


// Interface defaults
$GLOBALS['strInterfaceDefaults']		= "Implicitní parametry rozhraní";

$GLOBALS['strInventory']			= "Inventáø";
$GLOBALS['strShowCampaignInfo']			= "Zobrazit extra informace o kampani na stránce <i>Pøehled kampanì</i>";
$GLOBALS['strShowBannerInfo']			= "Zobrazit extra informace o banneru na stránce <i>Pøehled banneru</i>";
$GLOBALS['strShowCampaignPreview']		= "Zobrazit náhled v¹ech bannerù na stránce <i>Pøehled banneru</i>";
$GLOBALS['strShowBannerHTML']			= "Zobrazit banner místo HTML kódu pro náhled HTML banneru";
$GLOBALS['strShowBannerPreview']		= "Zobrazit náhled banneru na konci stránek které pracují s bannery";
$GLOBALS['strHideInactive']			= "Skrýt neaktivní polo¾ky ze v¹ech pøehledových stránek";
$GLOBALS['strGUIShowMatchingBanners']		= "Zobrazit odpovídající bannery na stránce <i>Pøipojený banner</i>";
$GLOBALS['strGUIShowParentCampaigns']		= "Zobrazit nadøazenou kampaò na stránce <i>Pøipojený banner</i>";
$GLOBALS['strGUILinkCompactLimit']		= "Skrýt nepøipojené kampanì nebo bannery na stránce <i>Pøipojený banner</i> kdy¾ je jich více ne¾";

$GLOBALS['strStatisticsDefaults'] 		= "Statistiky";
$GLOBALS['strBeginOfWeek']			= "Poèátek týdne";
$GLOBALS['strPercentageDecimals']		= "Desetinná místa procent";

$GLOBALS['strWeightDefaults']			= "Implicitní váha";
$GLOBALS['strDefaultBannerWeight']		= "Implicitní váha banneru";
$GLOBALS['strDefaultCampaignWeight']		= "Implicitní váha kampanì";
$GLOBALS['strDefaultBannerWErr']		= "Implicitní váha banneru by mìla být kladné èíslo";
$GLOBALS['strDefaultCampaignWErr']		= "Implicitní váha kampanì by mìla být kladné èíslo";



// Not used at the moment
$GLOBALS['strTableBorderColor']			= "Barva okraje tabulky";
$GLOBALS['strTableBackColor']			= "Barva pozadí tabulky";
$GLOBALS['strTableBackColorAlt']		= "Barva pozadí tabulky (alternativní)";
$GLOBALS['strMainBackColor']			= "Základní barva pozadí";
$GLOBALS['strOverrideGD']			= "Anulovat formát obrázku GD";
$GLOBALS['strTimeZone']				= "Èasové pásmo";

?>
