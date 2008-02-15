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

// Installer translation strings
$GLOBALS['strInstall']				= "Instalace";
$GLOBALS['strChooseInstallLanguage']		= "Vyberte si jazyk pro instalcni proceduru";
$GLOBALS['strLanguageSelection']		= "Vyber jazyka";
$GLOBALS['strDatabaseSettings']			= "Nastaveni databaze";
$GLOBALS['strAdminSettings']			= "Nastaveni administratora";
$GLOBALS['strAdvancedSettings']			= "Rozsirena nastaveni databaze";
$GLOBALS['strOtherSettings']			= "Ostatni nastaveni";

$GLOBALS['strWarning']				= "Upozorn�n�";
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
$GLOBALS['strErrorInstallDatabase']		= "Datab�zov� struktura nemohla b�t vytvo�ena.";
$GLOBALS['strErrorUpgrade'] 			= "Datab�ze sou�asn� instalace nemohla b�t aktualizov�na"; 
$GLOBALS['strErrorInstallConfig']		= "Konfigura�n� soubor nebo datab�ze nemohla b�t aktualizov�na.";
$GLOBALS['strErrorInstallDbConnect']		= "Nepoda�ilo se p�ipojit k datab�zi.";

$GLOBALS['strUrlPrefix']			= "Delivery Engine URL Prefix";
$GLOBALS['strUrlPrefix']			= "Delivery Engine SSL URL Prefix";

$GLOBALS['strProceed']				= "Pokra�ovat &gt;";
$GLOBALS['strInvalidUserPwd']			= "�patn� jm�no nebo heslo";

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
$GLOBALS['strDayFullNames'] 			= array("Ned�le","Pond�l�","�ter�","St�eda","�tvrtek","P�tek","Sobota");
$GLOBALS['strEditConfigNotPossible']   		= "Nen� mo�n� upravit tato nastaven�, nebo� konfigura�n� soubor je z bezpe�nostn�ch d�vod� uzam�en. ".
										  "Pokud chcete prov�d�t zmeny, mus�te nejprve odemknout soubor config.inc.php.";
$GLOBALS['strEditConfigPossible']		= "Je mo�n� prov�d�t zm�ny v nastaven�, nebo� konfigura�n� soubor nen� uzam�en. Toto ale m�e zp�sobit bezpe�nostn� probl�my. ".
										  "Pokud chcete zabezpe�it v� syst�m, mus�te uzamknout soubor config.inc.php.";



// Database
$GLOBALS['strDatabaseSettings']			= "Nastaven� datab�ze";
$GLOBALS['strDatabaseServer']			= "Datab�zov� server";
$GLOBALS['strDbLocal']				= "P�ipojit k lok�ln�mu serveru pomoc� soket�"; // Pg only
$GLOBALS['strDbHost']				= "Hostname datab�ze";
$GLOBALS['strDbPort']				= "Port datab�ze";
$GLOBALS['strDbUser']				= "U�ivatel datab�ze";
$GLOBALS['strDbPassword']			= "Heslo datab�ze";
$GLOBALS['strDbName']				= "Jm�no datab�ze";

$GLOBALS['strDatabaseOptimalisations']		= "Optimalizace datab�ze";
$GLOBALS['strPersistentConnections']		= "Pou��t trval� p�ipojen�";
$GLOBALS['strInsertDelayed']			= "Pou��t spo�d�n� inserty";
$GLOBALS['strCompatibilityMode']		= "Pou��t m�d kompatibility datab�ze";
$GLOBALS['strCantConnectToDb']			= "Nemohu se p�ipojit k datab�zi";



// Invocation and Delivery
$GLOBALS['strInvocationAndDelivery']		= "Nastaven� vol�n� a doru�ov�n�";

$GLOBALS['strAllowedInvocationTypes']		= "Povolen� typy vol�n�";
$GLOBALS['strAllowRemoteInvocation']		= "Povolit vzd�len� vol�n�";
$GLOBALS['strAllowRemoteInvocation']		= "Povolit vzd�len� vol�n� - bez cookies";
$GLOBALS['strAllowRemoteJavascript']		= "Povolit vzd�len� vol�n� Javascriptem";
$GLOBALS['strAllowRemoteFrames']		= "Povolit vzd�len� vol�n� pomoc� Frames";
$GLOBALS['strAllowRemoteXMLRPC']		= "Povolit vzd�len� vol�n� pomoc� XML-RPC";
$GLOBALS['strAllowLocalmode']			= "Povolit lok�ln� m�d";
$GLOBALS['strAllowInterstitial']		= "Povolit Interstitialy";
$GLOBALS['strAllowPopups']			= "Povolit Popupy";

$GLOBALS['strUseAcl']				= "Vyhodnocovat omezen� doru�ov�n� v pr�behu doru�ov�n�";

$GLOBALS['strDeliverySettings']			= "Nastaven� doru�ov�n�";
$GLOBALS['strCacheType']				= "Typ doru�ovac� cache";
$GLOBALS['strCacheFiles']				= "Soubory";
$GLOBALS['strCacheDatabase']			= "Datab�ze";
$GLOBALS['strCacheShmop']				= "Sd�len� pam�/Shmop";
$GLOBALS['strCacheSysvshm']				= "Sd�len� pam�/Sysvshm";
$GLOBALS['strExperimental']				= "Experiment�ln�";
$GLOBALS['strKeywordRetrieval']			= "Na��t�n� kl��ov�ch slov";
$GLOBALS['strBannerRetrieval']			= "Zp�sob na��t�n� banner�";
$GLOBALS['strRetrieveRandom']			= "N�hodn� na��t�n� banner� (standardn�)";
$GLOBALS['strRetrieveNormalSeq']		= "Norm�ln� sekven�n� na��t�n� banner�";
$GLOBALS['strWeightSeq']			= "V�en� sekven�n� na��t�n� banner�";
$GLOBALS['strFullSeq']				= "Pln� sekven�n� na��t�n� banner�";
$GLOBALS['strUseKeywords']				= "Pou��t kl��ov� slova k volb� banner�"; 
$GLOBALS['strUseConditionalKeys']		= "Povolit logick� operatory p�i pou�it� p��m� volby";
$GLOBALS['strUseMultipleKeys']			= "Povolit v�cero kl��ov�ch slov p�i pou�it� p��m� volby";

$GLOBALS['strZonesSettings']			= "Na��t�n� z�n";
$GLOBALS['strZoneCache']			= "Cacheov�n� z�n, toto zrychl� na��t�n� p�i pou�it� z�n";
$GLOBALS['strZoneCacheLimit']			= "�as mezi obnovami cache (ve vte�in�ch)";
$GLOBALS['strZoneCacheLimitErr']		= "�as mezi obnovami cache mus� b�t kladn� ��slo";

$GLOBALS['strP3PSettings']			= "Pravidla soukrom� P3P";
$GLOBALS['strUseP3P']				= "Pou��t P3P pravidla";
$GLOBALS['strP3PCompactPolicy']			= "Kompaktn� P3P pravidlo";
$GLOBALS['strP3PPolicyLocation']		= "Um�st�n� P3P pravidla"; 



// Banner Settings
$GLOBALS['strBannerSettings']			= "Nastaven� banneru";

$GLOBALS['strAllowedBannerTypes']		= "Povolen� typy banner�";
$GLOBALS['strTypeSqlAllow']			= "Povolit lok�ln� bannery (SQL)";
$GLOBALS['strTypeWebAllow']			= "Povolit lok�ln� bannery (Webserver)";
$GLOBALS['strTypeUrlAllow']			= "Povolit extern� bannery";
$GLOBALS['strTypeHtmlAllow']			= "Povolit HTML bannery";
$GLOBALS['strTypeTxtAllow']			= "Povolit textovou reklamu";

$GLOBALS['strTypeWebSettings']			= "Nastaven� lok�ln�ch banner� (Webserver)";
$GLOBALS['strTypeWebMode']			= "Typ ukl�d�n�";
$GLOBALS['strTypeWebModeLocal']			= "Lok�ln� adres��";
$GLOBALS['strTypeWebModeFtp']			= "Extern� FTP server";
$GLOBALS['strTypeWebDir']			= "Lok�ln� adres��";
$GLOBALS['strTypeWebFtp']			= "Server banner� FTP re�imu";
$GLOBALS['strTypeWebUrl']			= "Ve�ejn� URL";
$GLOBALS['strTypeWebSslUrl']			= "Ve�ejn� URL (SSL)";
$GLOBALS['strTypeFTPHost']			= "Server FTP";
$GLOBALS['strTypeFTPDirectory']			= "Adres�� serveru";
$GLOBALS['strTypeFTPUsername']			= "Jm�no";
$GLOBALS['strTypeFTPPassword']			= "Heslo";
$GLOBALS['strTypeFTPErrorDir']			= "Adres�� serveru neexistuje";
$GLOBALS['strTypeFTPErrorConnect']		= "Nemohu se p�ihl�sit k FTP serveru. U�ivatelsk� jm�no a heslo nejsou spr�vn�";
$GLOBALS['strTypeFTPErrorHost']			= "Jm�no FTP server nen� spr�vn�";
$GLOBALS['strTypeDirError']				= "Lok�ln� adres�� neexistuje";



$GLOBALS['strDefaultBanners']			= "Implicitn� bannery";
$GLOBALS['strDefaultBannerUrl']			= "URL implicitn�ho obr�zku";
$GLOBALS['strDefaultBannerTarget']		= "Implicitn� c�lov� URL";

$GLOBALS['strTypeHtmlSettings']			= "Parametry HTML banneru";
$GLOBALS['strTypeHtmlAuto']			= "Automaticky uprav HTML bannery aby bylo mo�n� sledovat kliknut�";
$GLOBALS['strTypeHtmlPhp']			= "Povolit spou�t�n� PHP v�raz� z HTML banner�";



// Host information and Geotargeting
$GLOBALS['strHostAndGeo']				= "Informace o hostech a geoc�len�";

$GLOBALS['strRemoteHost']				= "Vzd�len� host";
$GLOBALS['strReverseLookup']			= "Pokus se ur�it n�zev hostitele n�v�t�n�ka pokud nen� poskytnuto serverem";
$GLOBALS['strProxyLookup']				= "Pokus se ur�it pravou IP adresu nav�t�vn�ka, kter� pou��v� proxy server";
$GLOBALS['strObfuscate']				= "O�esat zdrojov� k�d pro doru�ov�n� reklamy."; 

$GLOBALS['strGeotargeting']				= "Geoc�len�";
$GLOBALS['strGeotrackingType']			= "Typ datab�ze geoc�len�";
$GLOBALS['strGeotrackingLocation'] 		= "M�sto datab�ze Geoc�len�";
$GLOBALS['strGeotrackingLocationError'] = "Datab�ze Geoc�len� neexistuje v m�st� kter� jste zadal";
$GLOBALS['strGeoStoreCookie']			= "Ulo�it cookie s v�sledkem pro p��t�";



// Statistics Settings
$GLOBALS['strStatisticsSettings']		= "Nastaven� statistik";

$GLOBALS['strStatisticsFormat']			= "Form�t statistik";
$GLOBALS['strCompactStats']				= "Form�t statistik";
$GLOBALS['strLogAdviews']				= "Logovat zobrazen� p�i ka�d�m doru�en� banneru";
$GLOBALS['strLogAdclicks']				= "Logovat kliknu� p�� ka�d�m kliknut� na banner";
$GLOBALS['strLogAdConversions']			= "Logovat prodeje p�i ka�d�m zobrazen� str�nky se sledovac�m k�dem"; 
$GLOBALS['strLogSource']				= "Logovat parametr zdroje p�edan� p�i vol�n�";
$GLOBALS['strGeoLogStats']				= "Logovat zemi n�v�t�vn�ka ve statistik�ch";
$GLOBALS['strLogHostnameOrIP']			= "Logovat jm�no hostitele nebo IP adresu n�v�t�vn�ka";
$GLOBALS['strLogIPOnly']				= "Logovat pouze IP addresu n�v�t�vn�ka i kdy� je zn�m n�zev hostitele";
$GLOBALS['strLogIP']					= "Logovat IP addresu n�v�t�vn�ka";
$GLOBALS['strLogBeacon']				= "Pou��vat mal� markovac� obr�zek k logov�n� AdViews aby bylo zaji�t�no �e jsou logov�ny pouze doru�en� bannery";

$GLOBALS['strRemoteHosts']				= "Vzd�len� hostitel�";
$GLOBALS['strIgnoreHosts']				= "Neukl�d�t statistiky pro n�v�t�vn�ky u��vaj�c� jednu z n�sleduj�c�ch IP adres nebo n�zv� hostitel�";
$GLOBALS['strBlockAdviews']				= "Nelogovat zobrazen� pokud n�v�t�vn�k vid�l stejn� banner v pr�b�hu zadan�ho po�tu vte�in";
$GLOBALS['strBlockAdclicks']			= "Nelogovat kliknuti pokud n�v�t�vn�k kliknul na stejn� banner v pr�b�hu zadan�ho po�tu vte�in";
$GLOBALS['strBlockAdConversions']		= "Nelogovat prodeje pokud n�v�t�vn�k nav�t�vil str�nku se sledovac�m k�dem v pr�b�hu zadan�ho po�tu vte�in";


$GLOBALS['strPreventLogging']			= "Zamezit logov�n�";
$GLOBALS['strEmailWarnings']			= "E-mailov� upozorn�n�";
$GLOBALS['strAdminEmailHeaders']		= "P�idej n�sleduj�c hlavi�ku ke ka�d� spr�v� poslan� ".$phpAds_productname;
$GLOBALS['strWarnLimit']				= "Poslat upozorn�n� kdy� po�et zb�vaj�c�ch impres� je ni��� ne� zde uveden�";
$GLOBALS['strWarnLimitErr']				= "Limit pro upozorn�n� by m�lo b�t kladn� ��slo";
$GLOBALS['strWarnAdmin']				= "Poslat upozorn�n� spr�vci kdykoliv je kampa� t�m�� vy�erp�na";
$GLOBALS['strWarnClient']				= "Poslat upozorn�n� inzerentovi kdykoliv je kampa� t�m�� vy�erp�na";
$GLOBALS['strWarnAgency']				= "Poslat upozorn�n� partnerovi kdykoliv je kampa� t�m�� vy�erp�na"; 
$GLOBALS['strQmailPatch']				= "Zapnout qmail patch";

$GLOBALS['strAutoCleanTables']			= "�i�t�n� datab�ze";
$GLOBALS['strAutoCleanStats']			= "�istit statistiky";
$GLOBALS['strAutoCleanUserlog']			= "�istit log u�ivatel�";
$GLOBALS['strAutoCleanStatsWeeks']		= "Maxim�ln� st��� statistik <br>(minim�ln� 3 t�dny)";
$GLOBALS['strAutoCleanUserlogWeeks']	= "Maxim�ln� st��� logu u�ivatel� <br>(minim�ln� 3 t�dny)";
$GLOBALS['strAutoCleanErr']				= "Maxim�ln� st�� mus� b�t v�� ne� 3 t�dny";
$GLOBALS['strAutoCleanVacuum']			= "VACUUM ANALYZE tabulky ka�dou noc"; // only Pg


// Administrator settings
$GLOBALS['strAdministratorSettings']		= "Nastaven� administr�tora";

$GLOBALS['strLoginCredentials']			= "P�ihla�ovac� �daje";
$GLOBALS['strAdminUsername']			= "Jm�no Admina";
$GLOBALS['strInvalidUsername']			= "�patn� Jm�no";

$GLOBALS['strBasicInformation']			= "Z�kladn� �daje";
$GLOBALS['strAdminFullName']			= "Cel� jm�no";
$GLOBALS['strAdminEmail']			= "Emailov� adresa";
$GLOBALS['strCompanyName']			= "N�zev firmy";

$GLOBALS['strAdminCheckUpdates']		= "Kontrolovat aktualizace";
$GLOBALS['strAdminCheckEveryLogin']		= "P�i p�ihl�en�";
$GLOBALS['strAdminCheckDaily']			= "Denn�";
$GLOBALS['strAdminCheckWeekly']			= "T�denn�";
$GLOBALS['strAdminCheckMonthly']		= "M�s��n�";
$GLOBALS['strAdminCheckNever']			= "Nikdy";

$GLOBALS['strAdminNovice']			= "Mazac� akce Admina vy�aduj� z bezpe�nostn�ch d�vod� potvrzen�";
$GLOBALS['strUserlogEmail']			= "Logovat ve�kerou odchoz� po�tu";
$GLOBALS['strUserlogPriority']			= "Logovat hodinov� kalkulace priorit";
$GLOBALS['strUserlogAutoClean']			= "Logovat automatick� �i�t�n� datab�ze";


// User interface settings
$GLOBALS['strGuiSettings']			= "Nastaven� u�ivatelsk�ho rozhran�";

$GLOBALS['strGeneralSettings']			= "Z�kladn� nastaven�";
$GLOBALS['strAppName']				= "N�zev aplikace";
$GLOBALS['strMyHeader']				= "Um�st�n� souboru hlavi�ky";
$GLOBALS['strMyHeaderError']		= "Soubor hlavi�ky neexistuje v m�st� kter� jste zadal";
$GLOBALS['strMyFooter']				= "Um�st�n� souboru pati�ky";
$GLOBALS['strMyFooterError']		= "Soubor pati�ky neexistuje v m�st� kter� jste zadal";
$GLOBALS['strGzipContentCompression']		= "Pou��t kompresi obsahu GZIPem";

$GLOBALS['strClientInterface']			= "Rozhran� inzerenta";
$GLOBALS['strClientWelcomeEnabled']		= "Zapnout uv�tac� text inzerenta";
$GLOBALS['strClientWelcomeText']		= "Uv�tac� text<br>(HTML tagy jsou povoleny)";

$GLOBALS['strInstantUpdateSettings']    = "Aktualizovat priority v re�ln�m �ase";
$GLOBALS['strInstantUpdate']            = "Povolit aktualizace v re�ln�m �ase";
$GLOBALS['strInstantUpdatePriority']    = "Aktualizovat priority";
$GLOBALS['strInstantUpdateCache']       = "Expirovat soubory cache";


// Interface defaults
$GLOBALS['strInterfaceDefaults']		= "Implicitn� parametry rozhran�";

$GLOBALS['strInventory']			= "Invent��";
$GLOBALS['strShowCampaignInfo']			= "Zobrazit extra informace o kampani na str�nce <i>P�ehled kampan�</i>";
$GLOBALS['strShowBannerInfo']			= "Zobrazit extra informace o banneru na str�nce <i>P�ehled banneru</i>";
$GLOBALS['strShowCampaignPreview']		= "Zobrazit n�hled v�ech banner� na str�nce <i>P�ehled banneru</i>";
$GLOBALS['strShowBannerHTML']			= "Zobrazit banner m�sto HTML k�du pro n�hled HTML banneru";
$GLOBALS['strShowBannerPreview']		= "Zobrazit n�hled banneru na konci str�nek kter� pracuj� s bannery";
$GLOBALS['strHideInactive']			= "Skr�t neaktivn� polo�ky ze v�ech p�ehledov�ch str�nek";
$GLOBALS['strGUIShowMatchingBanners']		= "Zobrazit odpov�daj�c� bannery na str�nce <i>P�ipojen� banner</i>";
$GLOBALS['strGUIShowParentCampaigns']		= "Zobrazit nad�azenou kampa� na str�nce <i>P�ipojen� banner</i>";
$GLOBALS['strGUILinkCompactLimit']		= "Skr�t nep�ipojen� kampan� nebo bannery na str�nce <i>P�ipojen� banner</i> kdy� je jich v�ce ne�";

$GLOBALS['strStatisticsDefaults'] 		= "Statistiky";
$GLOBALS['strBeginOfWeek']			= "Po��tek t�dne";
$GLOBALS['strPercentageDecimals']		= "Desetinn� m�sta procent";

$GLOBALS['strWeightDefaults']			= "Implicitn� v�ha";
$GLOBALS['strDefaultBannerWeight']		= "Implicitn� v�ha banneru";
$GLOBALS['strDefaultCampaignWeight']		= "Implicitn� v�ha kampan�";
$GLOBALS['strDefaultBannerWErr']		= "Implicitn� v�ha banneru by m�la b�t kladn� ��slo";
$GLOBALS['strDefaultCampaignWErr']		= "Implicitn� v�ha kampan� by m�la b�t kladn� ��slo";



// Not used at the moment
$GLOBALS['strTableBorderColor']			= "Barva okraje tabulky";
$GLOBALS['strTableBackColor']			= "Barva pozad� tabulky";
$GLOBALS['strTableBackColorAlt']		= "Barva pozad� tabulky (alternativn�)";
$GLOBALS['strMainBackColor']			= "Z�kladn� barva pozad�";
$GLOBALS['strOverrideGD']			= "Anulovat form�t obr�zku GD";
$GLOBALS['strTimeZone']				= "�asov� p�smo";

?>
