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
$GLOBALS['strInstall']				= "Instalacja";
$GLOBALS['strChooseInstallLanguage']		= "Wybierz j�zyk dla procedury instalacji";
$GLOBALS['strLanguageSelection']		= "Wyb�r J�zyka";
$GLOBALS['strDatabaseSettings']			= "Ustawienia Bazy Danych";
$GLOBALS['strAdminSettings']			= "Ustawienia Administratora";
$GLOBALS['strAdvancedSettings']			= "Ustawienia Zaawansowane";
$GLOBALS['strOtherSettings']			= "Inne Ustawienia";

$GLOBALS['strWarning']				= "Uwaga";
$GLOBALS['strFatalError']			= "Wyst�pi� b��d krytyczny";
$GLOBALS['strAlreadyInstalled']			= $phpAds_productname." jest ju� zainstalowany na tym systemie. Je�eli chcesz go skonfigurowa�, id� do <a href='settings-index.php'>cz�ci ustawie�</a>";
$GLOBALS['strCouldNotConnectToDB']		= "Po��czenie z baz� danych nie by�o mo�liwe, sprawd� poprawno�� wpisanych danych";
$GLOBALS['strCreateTableTestFailed']		= "U�ytkownik, kt�rego poda�e� nie ma uprawnie� do tworzenia lub zmiany tabel w bazie danych, skontaktuj si� z administratorem bazy danych.";
$GLOBALS['strUpdateTableTestFailed']		= "U�ytkownik, kt�rego poda�e� nie ma uprawnie� do zmiany struktury bazy danych, skontaktuj si� z administratorem bazy danych.";
$GLOBALS['strTablePrefixInvalid']		= "Prefiks tabeli zawiera nieprawid�owe znaki";
$GLOBALS['strTableInUse']			= "Baza danych, kt�r� poda�e� jest ju� u�ywana przez ".$phpAds_productname.", podaj inny prefiks tabeli lub przeczytaj w dokumentacji instrukcje dotycz�ce aktualizacji.";
$GLOBALS['strTableWrongType']			= "Wybrany przez ciebie typ tabeli nie jest obs�ugiwany przez twoj� instalacj� ".$phpAds_dbmsname;
$GLOBALS['strMayNotFunction']			= "Przed kontynuacj� popraw te potencjalne problemy:";
$GLOBALS['strIgnoreWarnings']			= "Ignoruj ostrze�enia";
$GLOBALS['strWarningDBavailable']		= "Wersja PHP, kt�rej u�ywasz nie ma mo�liwo�ci korzystania z serwera baz danych ".$phpAds_dbmsname.". Musisz w��czy� rozszerzenie PHP ".$phpAds_dbmsname." zanim b�dziesz m�g� kontynuowa�.";
$GLOBALS['strWarningPHPversion']		= $phpAds_productname." wymaga PHP 4.0 lub nowszego do poprawnego funkcjonowania. Na serwerze jest obecnie {php_version}.";
$GLOBALS['strWarningRegisterGlobals']		= "Opcja konfiguracyjna PHP register_globals musi by� w��czona.";
$GLOBALS['strWarningMagicQuotesGPC']		= "Opcja konfiguracyjna PHP magic_quotes_gpc musi by� w��czona.";
$GLOBALS['strWarningMagicQuotesRuntime']	= "Opcja konfiguracyjna PHP magic_quotes_runtime musi by� wy��czona.";
$GLOBALS['strWarningFileUploads']		= "Opcja konfiguracyjna PHP file_uploads musi by� wy��czona.";
$GLOBALS['strWarningTrackVars']			= "Opcja konfiguracyjna PHP variable track_vars musi by� wy��czona.";
$GLOBALS['strWarningPREG']			= "Wersja PHP, kt�rej u�ywasz nie posiada obs�ugi wyra�e� regularnych w formacie PERL'a. Musisz w��czy� rozszerzenie PREG zanim b�dziesz m�g� przej�� dalej.";
$GLOBALS['strConfigLockedDetected']		= $phpAds_productname." wykry�o, �e tw�j plik <b>config.inc.php</b> nie mo�e by� modyfikowany przez server.<br /> Kontynuacja nie b�dzie mo�liwa zanim nie zmienisz uprawnie� dla tego pliku. <br />Przeczytaj do��czon� dokumentacj�, je�eli nie wiesz jak to zrobi�.";
$GLOBALS['strCantUpdateDB']  			= "Aktualizacja bazy danych nie jest w tej chwili mo�liwa. Je�eli zdecydujesz si� kontynuowa�, wszystkie istniej�ce bannery, statystyki i reklamodawcy zostan� usuni�ci.";
$GLOBALS['strTableNames']			= "Nazwy Tabeli";
$GLOBALS['strTablesPrefix']			= "Prefiks nazw tabeli";
$GLOBALS['strTablesType']			= "Typ tabeli";

$GLOBALS['strInstallWelcome']			= "Witamy w ".$phpAds_productname;
$GLOBALS['strInstallMessage']			= "Zanim mo�esz zacz�� u�ywa� ".$phpAds_productname." musi on zosta� skonfigurowany i <br /> utworzona zosta� baza danych. Kliknij <b>Dalej</b> aby kontynuowa�.";
$GLOBALS['strInstallSuccess']			= "<bProcedura instalacji ".$phpAds_productname." zosta�a zako�czona.</b><br /><br />Aby zapewni� prawid�owe funkcjonowanie ".$phpAds_productname." musisz tak�e
						   zapewni� codzienne uruchamianie pliku utrzymania. Wi�cej informacji na ten temat znajdziesz w dokumentacji.
						   <br /><br />Kliknij <b>Dalej</b> aby przej�� do cz�ci konfiguracyjnej, gdzie mo�esz 
						   zmieni� inne ustawienia. Nie zapomnij tak�e zablokowa� pliku config.inc.php po zako�czeniu konfiguracji aby zapobiec
						   naruszeniu bezpiecze�stwa.";
$GLOBALS['strUpdateSuccess']			= "<b>Aktualizacja ".$phpAds_productname." zako�czy�a si� pomy�lnie.</b><br /><br />Aby zapewni� prawid�owe funkcjonowanie ".$phpAds_productname." musisz tak�e
						   zapewni� uruchamianie pliku utrzymania co godzin� (przedtem wystarczy�o raz dziennie). Wi�cej informacji na ten temat znajdziesz w dokumentacji.
						   <br /><br />Kliknij <b>Dalej</b> aby przej�� do interfejsu administracyjnego. Nie zapomnij tak�e zablokowa� pliku config.inc.php 
						   aby zapobiec naruszeniu bezpiecze�stwa.";
$GLOBALS['strInstallNotSuccessful']		= "<b>Instalacja ".$phpAds_productname." nie powiod�a si�</b><br /><br />Niekt�re cz�ci procesu instalacyjnego nie zosta�y zako�czone.
						   Mo�liwe, �e te problemy s� jedynie przej�ciowe, w takim wypadku mo�esz po prostu klikn�� <b>Dalej</b> i powr�ci� do 
						   pierwszego kroku instalacji. Je�eli chcesz dowiedzie� si� wi�cej o znaczeniu tego b��du i sposobach jego rozwi�zania, 
						   zajrzyj do do��czonej dokumentacji.";
$GLOBALS['strErrorOccured']			= "Wyst�pi�y nast�puj�ce b��dy:";
$GLOBALS['strErrorInstallDatabase']		= "Nie uda�o si� strowzy� struktury bazy danych.";
$GLOBALS['strErrorUpgrade'] = 'The existing installation\'s database could not be upgraded.';
$GLOBALS['strErrorInstallConfig']		= "Plik konfiguracyjny lub naza danych nie mog�y zosta� zaktualizowane.";
$GLOBALS['strErrorInstallDbConnect']		= "Nie mo�na by�o po��czy� si� z baz� danych.";

$GLOBALS['strUrlPrefix']			= "Prefiks adresu URL";

$GLOBALS['strProceed']				= "Dalej &gt;";
$GLOBALS['strRepeatPassword']			= "Powt�rz has�o";
$GLOBALS['strNotSamePasswords']			= "Has�a nie pasuj� do siebie";
$GLOBALS['strInvalidUserPwd']			= "B��dna nazwa u�ytkownika lub has�o";

$GLOBALS['strUpgrade']				= "Aktualizacja";
$GLOBALS['strSystemUpToDate']			= "Tw�j system ma ju� zainstalowan� najnowsz� wersj� programu, aktualizacja nie jest potrzebna. <br />Kliknij <b>Dalej</b> aby przej�� na stron� g��wn�.";
$GLOBALS['strSystemNeedsUpgrade']		= "Struktura bazy danych i plik konfiguracyjny musz� zosta� zaktualizowane, aby zapewni� prawid�owe funkcjonowanie systemu. Kliknij <b>Dalej</b> aby rozpocz�� proces aktualizacji. <br /><br />Zale�nie od tego, z kt�rej wersji dokonywana jest aktualizacja i ile statystyk znajduje si� ju� w bazie danych, mo�e to spowodowa� znaczne obci��enie dla serwera. Przygotuj si� na to, �e aktualizacja mo�e potrwa� do kilkunastu minut.";
$GLOBALS['strSystemUpgradeBusy']		= "System w trakcie aktualizacji, prosz� zaczeka�...";
$GLOBALS['strSystemRebuildingCache']		= "Odbudowywanie cache'u, prosz� zaczeka�...";
$GLOBALS['strServiceUnavalable']		= "System jest obecnie niedost�pny. Trwa aktualizacja";

$GLOBALS['strConfigNotWritable']		= "Plik config.inc.php nie mo�e zosta� zmodyfikowany";





/*-------------------------------------------------------*/
/* Configuration translations                            */
/*-------------------------------------------------------*/

// Global
$GLOBALS['strChooseSection']			= "Wybierz Sekcj�";
$GLOBALS['strDayFullNames'] 			= array("Niedziela","Poniedzia�ek","Wtorek","�roda","Czwartek","Pi�tek","Sobota");
$GLOBALS['strEditConfigNotPossible']    	= "Zmiana tych ustawie� nie jest mo�liwa, poniewa� plik konfiguracji jest zablokowany ze wzgl�d�w bezpiecze�stwa. ".
										  "Je�eli chcesz dokona� zmian, musisz najpierw odblokowa� plik config.inc.php.";
$GLOBALS['strEditConfigPossible']		= "Edycja wszystkich ustawie� jest mo�liwa, poniewa� plik konfiguracyjny nie jest zablokowany, co mo�e prowadzi� do zagro�enia bezpiecze�stwa. ".
										  "Je�eli chcesz zabezpieczy� sw�j system, zablokuj plik config.inc.php.";



// Database
$GLOBALS['strDatabaseSettings']			= "Ustawienia Bazy Danych";
$GLOBALS['strDatabaseServer']			= "Serwer Bazy Danych";
$GLOBALS['strDbLocal']				= "Po��cz z lokalnym serwerem u�ywaj�c sockets"; // Pg only
$GLOBALS['strDbHost']				= "Adres serwera";
$GLOBALS['strDbPort']				= "Numer portu bazy danych";
$GLOBALS['strDbUser']				= "Nazwa u�ytkownika";
$GLOBALS['strDbPassword']			= "Has�o";
$GLOBALS['strDbName']				= "Nazwa bazy danych";

$GLOBALS['strDatabaseOptimalisations']		= "Optymalizacja Bazy Danych";
$GLOBALS['strPersistentConnections']		= "U�yj sta�ych po��cze�";
$GLOBALS['strCompatibilityMode']		= "Tryb kompatybilno�ci bazy danych";
$GLOBALS['strCantConnectToDb']			= "Nie mo�na po��czy� z baz� danych";



// Invocation and Delivery
$GLOBALS['strInvocationAndDelivery']		= "Ustawienia Inwokacji i Dostarczania";

$GLOBALS['strAllowedInvocationTypes']		= "Dozwolone Typy Inwokacji";
$GLOBALS['strAllowRemoteInvocation']		= "Zezw�l na zdaln� inwokacj�";
$GLOBALS['strAllowRemoteJavascript']		= "Zezw�l na zdaln� inwokacj� z JavaScript";
$GLOBALS['strAllowRemoteFrames']		= "Zezw�l na zdaln� inwokacj� z ramkani";
$GLOBALS['strAllowRemoteXMLRPC']		= "Zezw�l na zdaln� inwokacj� z wykorzystaniem XML-RPC";
$GLOBALS['strAllowLocalmode']			= "Zezw�l na tryb lokalny";
$GLOBALS['strAllowInterstitial']		= "Zezw�l na Interstitials";
$GLOBALS['strAllowPopups']			= "Zezw�l na Popups";

$GLOBALS['strUseAcl']				= "U�yj ogranicze� wy�wietlania podczas dostarczania";

$GLOBALS['strDeliverySettings']			= "Ustawienia dostarczania";
$GLOBALS['strCacheType']			= "Typ cache'u dostarczania";
$GLOBALS['strCacheFiles']			= "Pliki";
$GLOBALS['strCacheDatabase']			= "Baza danych";
$GLOBALS['strCacheShmop']			= "Wsp�dzielona pami��/Shmop";
$GLOBALS['strCacheSysvshm']			= "Wsp�dzielona pami��/Sysvshm";
$GLOBALS['strExperimental']			= "Eksperymentalne";
$GLOBALS['strKeywordRetrieval']			= "S�owa Kluczowe";
$GLOBALS['strBannerRetrieval']			= "Metoda Doboru Banner�w";
$GLOBALS['strRetrieveRandom']			= "Losowy wyb�r (domy�lnie)";
$GLOBALS['strRetrieveNormalSeq']		= "Normalny, sekwencyjny wyb�r";
$GLOBALS['strWeightSeq']			= "Sekwencyjny wyb�r w oparciu o wag�";
$GLOBALS['strFullSeq']				= "Pe�ny wyb�r sekwencyjny";
$GLOBALS['strUseConditionalKeys']		= "Zezw�l na operatory logiczne przy bezp�rednim wyborze";
$GLOBALS['strUseMultipleKeys']			= "Zezw�l na kilka s��w kluczowych przy bezpo�rednim wyborze";

$GLOBALS['strZonesSettings']			= "Wy�wietlanie Stref";
$GLOBALS['strZoneCache']			= "Przechowuj strefy w cache'u, to powinno przy�pieszy� ich dzia�anie";
$GLOBALS['strZoneCacheLimit']			= "Czas mi�dzy aktualizacjami cache'u (w sekundach)";
$GLOBALS['strZoneCacheLimitErr']		= "Czas mi�dzy aktualizacjami powinien by� dodatni� liczb� ca�kowit�";

$GLOBALS['strP3PSettings']			= "Polityka Prywatno�ci P3P";
$GLOBALS['strUseP3P']				= "U�yj Deklaracji P3P";
$GLOBALS['strP3PCompactPolicy']			= "Skr�cona Deklaracja P3P";
$GLOBALS['strP3PPolicyLocation']		= "Lokalizacja Deklaracji P3P";



// Banner Settings
$GLOBALS['strBannerSettings']			= "Ustawienia Banner�w";

$GLOBALS['strAllowedBannerTypes']		= "Dozwolone Typy Banner�w";
$GLOBALS['strTypeSqlAllow']			= "Zezw�l na lokalne bannery (SQL)";
$GLOBALS['strTypeWebAllow']			= "Zezw�l na lokalne bannery (Webserver)";
$GLOBALS['strTypeUrlAllow']			= "Zezw�l na zewn�trzne bannery";
$GLOBALS['strTypeHtmlAllow']			= "Zezw�l na bannery HTML";
$GLOBALS['strTypeTxtAllow']			= "Zezw�l na odno�niki tekstowe";

$GLOBALS['strTypeWebSettings']			= "Konfiguracja Lokalnych Banner�w (Webserver)";
$GLOBALS['strTypeWebMode']			= "Metoda przechowywania";
$GLOBALS['strTypeWebModeLocal']			= "Lokalny katalog";
$GLOBALS['strTypeWebModeFtp']			= "Zewn�trzny server FTP";
$GLOBALS['strTypeWebDir']			= "Lokalny katalog";
$GLOBALS['strTypeWebFtp']			= "Tryb FTP webservera banner�w";
$GLOBALS['strTypeWebUrl']			= "Publiczny URL";
$GLOBALS['strTypeWebSslUrl']			= "Publiczny URL (SSL)";
$GLOBALS['strTypeFTPHost']			= "Adres servera FTP";
$GLOBALS['strTypeFTPDirectory']			= "Katalog servera";
$GLOBALS['strTypeFTPUsername']			= "Login";
$GLOBALS['strTypeFTPPassword']			= "Has�o";
$GLOBALS['strTypeFTPErrorDir']			= "Podany katalog na serwerze nie istnieje";
$GLOBALS['strTypeFTPErrorConnect']		= "B��d po��czenia z serwerem FTP, login i has�o s� niepoprawne";
$GLOBALS['strTypeFTPErrorHost']			= "Nazwa hosta serwera FTP nie jest poprawna";
$GLOBALS['strTypeDirError']			= "Lokalny katalog nie istnieje";



$GLOBALS['strDefaultBanners']			= "Domy�lne Bannery";
$GLOBALS['strDefaultBannerUrl']			= "Adres URL domy�lnego bannera";
$GLOBALS['strDefaultBannerTarget']		= "Adres URL docelowy";

$GLOBALS['strTypeHtmlSettings']			= "Opcje bannera HTML";
$GLOBALS['strTypeHtmlAuto']			= "Automatycznie zmieniaj bannery HTML aby wymusi� �ledzenie Klikni��";
$GLOBALS['strTypeHtmlPhp']			= "Zezw�l na wykonywanie polece� PHP w bannerach HTML";



// Host information and Geotargeting
$GLOBALS['strHostAndGeo']			= "Informacje o serwerze i �ledzeniu geograficznym";

$GLOBALS['strRemoteHost']			= "Zdalny serwer";
$GLOBALS['strReverseLookup']			= "Spr�buj ustali� nazw� hosta odwiedzaj�cego, je�eli nie zosta�a podana przez serwer";
$GLOBALS['strProxyLookup']			= "Spr�buj ustali� prawdziwy adres IP odwiedzaj�cego, je�eli korzysta on z Proxy";

$GLOBALS['strGeotargeting']			= "Geotargeting";
$GLOBALS['strGeotrackingType']			= "Typ bazy danych �ledzenia geograficznego";
$GLOBALS['strGeotrackingLocation'] 		= "Lokalizacja bazy danych �ledzenia geograficznego";
$GLOBALS['strGeoStoreCookie']			= "Zapisz wyniki w cookie dla p�niejszego wykorzystania";



// Statistics Settings
$GLOBALS['strStatisticsSettings']		= "Ustawienia Statystyk";

$GLOBALS['strStatisticsFormat']			= "Format Statystyk";
$GLOBALS['strCompactStats']			= "Format statystyk";
$GLOBALS['strLogAdviews']			= "Loguj Ods�on� przy ka�dym dostarczeniu bannera";
$GLOBALS['strLogAdclicks']			= "Loguj Klikni�cie za ka�dym razem gdy odwiedzaj�cy kliknie w banner";
$GLOBALS['strLogSource']			= "Loguj parametr �r�d�a podany w inwokacji";
$GLOBALS['strGeoLogStats']			= "Loguj kraj odwiedzaj�cego w statystykach";
$GLOBALS['strLogHostnameOrIP']			= "Loguj nazw� hosta lub adres IP odwiedzaj�cego";
$GLOBALS['strLogIPOnly']			= "Loguj tylko adres IP odwiedzaj�cego, nawet je�eli nazwa hosta jest znana";
$GLOBALS['strLogIP']				= "Loguj adres IP odwiedzaj�cego";
$GLOBALS['strLogBeacon']			= "U�ywaj ma�ego obrazka przy logowaniu Ods�on aby zapewni�, �e tylko dostarczone bannery s� logowane";

$GLOBALS['strRemoteHosts']			= "Zdalne Hosty";
$GLOBALS['strIgnoreHosts']			= "Nie przechowuj statystyk dla odwiedzaj�cych u�ywaj�cych jednego z poni�szych adres�w IP lub host�w";
$GLOBALS['strBlockAdviews']			= "Nie loguj Ods�on je�eli odwiedzaj�cy widzia� ten sam banner w ci�gu podanego w sekundach czasu";
$GLOBALS['strBlockAdclicks']			= "Nie loguj Klikni�� je�eli odwiedzaj�cy klikn�� w banner w ci�gu podanego w sekundach czasu";


$GLOBALS['strEmailWarnings']			= "Ostrze�enia Przez E-mail";
$GLOBALS['strAdminEmailHeaders']		= "Nag��wek z informacj� o nadawcy dziennych raport�w";
$GLOBALS['strWarnLimit']			= "Limit Ostrze�enia";
$GLOBALS['strWarnLimitErr']			= "Limit ostrze�enia powinien by� dodatni� liczb� ca�kowit�";
$GLOBALS['strWarnAdmin']			= "Ostrze�enie Administratora";
$GLOBALS['strWarnClient']			= "Ostrze�enie Reklamodawcy";
$GLOBALS['strQmailPatch']			= "W��cz �atk� qmail'a";

$GLOBALS['strAutoCleanTables']			= "Automatycznie Czyszczenie Bazy Danych";
$GLOBALS['strAutoCleanStats']			= "Wyczy�� statystyki";
$GLOBALS['strAutoCleanUserlog']			= "Wyczy�� log u�ytkownika";
$GLOBALS['strAutoCleanStatsWeeks']		= "Maksymalny wiek statystyk <br />(minimum 3 tygodnie)";
$GLOBALS['strAutoCleanUserlogWeeks']		= "Maksymalny wiek logu u�ytkownika <br />(minimum 3 tygodnie)";
$GLOBALS['strAutoCleanErr']			= "Maksymalny wiek musi mie� przynajmniej 3 tygodnie";
$GLOBALS['strAutoCleanVacuum']			= "ANALIZA VACUUM tabel co noc"; // only Pg



// Administrator settings
$GLOBALS['strAdministratorSettings']		= "Ustawienia Administratora";

$GLOBALS['strLoginCredentials']			= "Informacje Logowania";
$GLOBALS['strAdminUsername']			= "Nazwa u�ytkownika Admina";
$GLOBALS['strOldPassword']			= "Stare has�o";
$GLOBALS['strNewPassword']			= "Nowe has�o";
$GLOBALS['strInvalidUsername']			= "Nieprawid�owa nazwa u�ytkownika";
$GLOBALS['strInvalidPassword']			= "Nieprawid�owe has�o";

$GLOBALS['strBasicInformation']			= "Podstawowe informacje";
$GLOBALS['strAdminFullName']			= "Imi� i nazwisko admina";
$GLOBALS['strAdminEmail']			= "Adres email admina";
$GLOBALS['strCompanyName']			= "Nazwa firmy";

$GLOBALS['strAdminCheckUpdates']		= "Sorawd� aktualizacje";
$GLOBALS['strAdminCheckEveryLogin']		= "Przy ka�dym logowaniu";
$GLOBALS['strAdminCheckDaily']			= "Codziennie";
$GLOBALS['strAdminCheckWeekly']			= "Co tydzie�";
$GLOBALS['strAdminCheckMonthly']		= "Co miesi�c";
$GLOBALS['strAdminCheckNever']			= "Nigdy";

$GLOBALS['strAdminNovice']			= "Dzia�ania administratora usuwaj�ce dane wymagaj� potwierdzenia dla bezpiecze�stwa";
$GLOBALS['strUserlogEmail']			= "Loguj wszystkie wychodz�ce wiadomo�ci email";
$GLOBALS['strUserlogPriority']			= "Loguj godzinne kalkukacje priorytet�w";
$GLOBALS['strUserlogAutoClean']			= "Loguj automatyczne czyszczenie bazy danych";


// User interface settings
$GLOBALS['strGuiSettings']			= "Konfiguracja Interfejsu U�ytkownika";

$GLOBALS['strGeneralSettings']			= "Og�lne Ustawienia";
$GLOBALS['strAppName']				= "Nazwa programu";
$GLOBALS['strMyHeader']				= "M�j nag��wek";
$GLOBALS['strMyFooter']				= "Moja stopka";
$GLOBALS['strGzipContentCompression']		= "U�yj kompresji zawarto�ci GZIP";

$GLOBALS['strClientInterface']			= "Interfejs Reklamodawcy";
$GLOBALS['strClientWelcomeEnabled']		= "W��cz wiadomo�ci powitalne dla reklamodawcy";
$GLOBALS['strClientWelcomeText']		= "Tekst powitalny<br />(znaczniki HTML dozwolone)";



// Interface defaults
$GLOBALS['strInterfaceDefaults']		= "Domy�lne Ustawienia Interfejsu";

$GLOBALS['strInventory']			= "Administracja";
$GLOBALS['strShowCampaignInfo']			= "Poka� dodatkowe informacje o kampanii na stronie <i>Przegl�d Kampanii</i>";
$GLOBALS['strShowBannerInfo']			= "Poka� dodatkowe informacje o bannerze na stronie <i>Przegl�d Banner�w</i>";
$GLOBALS['strShowCampaignPreview']		= "Poka� podg�d wszystkich banner�w na stronie <i>Przegl�d Banner�w</i>";
$GLOBALS['strShowBannerHTML']			= "Poka� w�a�ciwy banner zamiast kodu HTML dla podgl�du banner�w HTML";
$GLOBALS['strShowBannerPreview']		= "Poka� podgl�d bannera na g�rze stron, kt�re dotycz� banner�w";
$GLOBALS['strHideInactive']			= "Ukryj nieaktywne elementy ze wszystkich stron przegl�dowych";
$GLOBALS['strGUIShowMatchingBanners']		= "Poka� pasuj�ce bannery na stronach <i>Przy��czony banner</i>";
$GLOBALS['strGUIShowParentCampaigns']		= "Poka� nadrz�dne kampanie na stronach <i>Przy��czony banner</i>";
$GLOBALS['strGUILinkCompactLimit']		= "Hide non-linked campaigns or banners on the <i>Linked banner</i> pages when there are more than";

$GLOBALS['strStatisticsDefaults'] 		= "Statystyki";
$GLOBALS['strBeginOfWeek']			= "Pocz�tek tygodnia";
$GLOBALS['strPercentageDecimals']		= "Cyfr po przecinku";

$GLOBALS['strWeightDefaults']			= "Domy�lne Wagi";
$GLOBALS['strDefaultBannerWeight']		= "Domy�lna waga bannera";
$GLOBALS['strDefaultCampaignWeight']		= "Domy�lna waga kampanii";
$GLOBALS['strDefaultBannerWErr']		= "Domy�lna waga bannera powinna by� dodatni� liczb� ca�kowit�";
$GLOBALS['strDefaultCampaignWErr']		= "Domy�lna waga kampanii powinna by� dodatni� liczb� ca�kowit�";



// Not used at the moment
$GLOBALS['strTableBorderColor']			= "Kolor Obramowania Tabeli";
$GLOBALS['strTableBackColor']			= "Kolor T�a Tabeli";
$GLOBALS['strTableBackColorAlt']		= "Kolor T�a Tabeli (Alternatywny)";
$GLOBALS['strMainBackColor']			= "G��wny Kolor T�a";
$GLOBALS['strOverrideGD']			= "Zignoruj Format Grafiki GD";
$GLOBALS['strTimeZone']				= "Strefa Czasowa";

?>