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
$GLOBALS['strChooseInstallLanguage']		= "Wybierz język dla procedury instalacji";
$GLOBALS['strLanguageSelection']		= "Wybór Języka";
$GLOBALS['strDatabaseSettings']			= "Ustawienia Bazy Danych";
$GLOBALS['strAdminSettings']			= "Ustawienia Administratora";
$GLOBALS['strAdvancedSettings']			= "Ustawienia Zaawansowane";
$GLOBALS['strOtherSettings']			= "Inne Ustawienia";

$GLOBALS['strWarning']				= "Uwaga";
$GLOBALS['strFatalError']			= "Wystąpił błąd krytyczny";
$GLOBALS['strAlreadyInstalled']			= $phpAds_productname." jest już zainstalowany na tym systemie. Jeżeli chcesz go skonfigurować, idź do <a href='settings-index.php'>części ustawień</a>";
$GLOBALS['strCouldNotConnectToDB']		= "Połączenie z bazą danych nie było możliwe, sprawdź poprawność wpisanych danych";
$GLOBALS['strCreateTableTestFailed']		= "Użytkownik, którego podałeś nie ma uprawnień do tworzenia lub zmiany tabel w bazie danych, skontaktuj się z administratorem bazy danych.";
$GLOBALS['strUpdateTableTestFailed']		= "Użytkownik, którego podałeś nie ma uprawnień do zmiany struktury bazy danych, skontaktuj się z administratorem bazy danych.";
$GLOBALS['strTablePrefixInvalid']		= "Prefiks tabeli zawiera nieprawidłowe znaki";
$GLOBALS['strTableInUse']			= "Baza danych, którą podałeś jest już używana przez ".$phpAds_productname.", podaj inny prefiks tabeli lub przeczytaj w dokumentacji instrukcje dotyczące aktualizacji.";
$GLOBALS['strTableWrongType']			= "Wybrany przez ciebie typ tabeli nie jest obsługiwany przez twoją instalację ".$phpAds_dbmsname;
$GLOBALS['strMayNotFunction']			= "Przed kontynuacją popraw te potencjalne problemy:";
$GLOBALS['strIgnoreWarnings']			= "Ignoruj ostrzeżenia";
$GLOBALS['strWarningDBavailable']		= "Wersja PHP, której używasz nie ma możliwości korzystania z serwera baz danych ".$phpAds_dbmsname.". Musisz włączyć rozszerzenie PHP ".$phpAds_dbmsname." zanim będziesz mógł kontynuować.";
$GLOBALS['strWarningPHPversion']		= $phpAds_productname." wymaga PHP 4.0 lub nowszego do poprawnego funkcjonowania. Na serwerze jest obecnie {php_version}.";
$GLOBALS['strWarningRegisterGlobals']		= "Opcja konfiguracyjna PHP register_globals musi być włączona.";
$GLOBALS['strWarningMagicQuotesGPC']		= "Opcja konfiguracyjna PHP magic_quotes_gpc musi być włączona.";
$GLOBALS['strWarningMagicQuotesRuntime']	= "Opcja konfiguracyjna PHP magic_quotes_runtime musi być wyłączona.";
$GLOBALS['strWarningFileUploads']		= "Opcja konfiguracyjna PHP file_uploads musi być wyłączona.";
$GLOBALS['strWarningTrackVars']			= "Opcja konfiguracyjna PHP variable track_vars musi być wyłączona.";
$GLOBALS['strWarningPREG']			= "Wersja PHP, której używasz nie posiada obsługi wyrażeń regularnych w formacie PERL'a. Musisz włączyć rozszerzenie PREG zanim będziesz mógł przejść dalej.";
$GLOBALS['strConfigLockedDetected']		= $phpAds_productname." wykryło, że twój plik <b>config.inc.php</b> nie może być modyfikowany przez server.<br /> Kontynuacja nie będzie możliwa zanim nie zmienisz uprawnień dla tego pliku. <br />Przeczytaj dołączoną dokumentację, jeżeli nie wiesz jak to zrobić.";
$GLOBALS['strCantUpdateDB']  			= "Aktualizacja bazy danych nie jest w tej chwili możliwa. Jeżeli zdecydujesz się kontynuować, wszystkie istniejące bannery, statystyki i reklamodawcy zostaną usunięci.";
$GLOBALS['strTableNames']			= "Nazwy Tabeli";
$GLOBALS['strTablesPrefix']			= "Prefiks nazw tabeli";
$GLOBALS['strTablesType']			= "Typ tabeli";

$GLOBALS['strInstallWelcome']			= "Witamy w ".$phpAds_productname;
$GLOBALS['strInstallMessage']			= "Zanim możesz zacząć używać ".$phpAds_productname." musi on zostać skonfigurowany i <br /> utworzona zostać baza danych. Kliknij <b>Dalej</b> aby kontynuować.";
$GLOBALS['strInstallSuccess']			= "<bProcedura instalacji ".$phpAds_productname." została zakończona.</b><br /><br />Aby zapewnić prawidłowe funkcjonowanie ".$phpAds_productname." musisz także
						   zapewnić codzienne uruchamianie pliku utrzymania. Więcej informacji na ten temat znajdziesz w dokumentacji.
						   <br /><br />Kliknij <b>Dalej</b> aby przejść do części konfiguracyjnej, gdzie możesz 
						   zmienić inne ustawienia. Nie zapomnij także zablokować pliku config.inc.php po zakończeniu konfiguracji aby zapobiec
						   naruszeniu bezpieczeństwa.";
$GLOBALS['strUpdateSuccess']			= "<b>Aktualizacja ".$phpAds_productname." zakończyła się pomyślnie.</b><br /><br />Aby zapewnić prawidłowe funkcjonowanie ".$phpAds_productname." musisz także
						   zapewnić uruchamianie pliku utrzymania co godzinę (przedtem wystarczyło raz dziennie). Więcej informacji na ten temat znajdziesz w dokumentacji.
						   <br /><br />Kliknij <b>Dalej</b> aby przejść do interfejsu administracyjnego. Nie zapomnij także zablokować pliku config.inc.php 
						   aby zapobiec naruszeniu bezpieczeństwa.";
$GLOBALS['strInstallNotSuccessful']		= "<b>Instalacja ".$phpAds_productname." nie powiodła się</b><br /><br />Niektóre części procesu instalacyjnego nie zostały zakończone.
						   Możliwe, że te problemy są jedynie przejściowe, w takim wypadku możesz po prostu kliknąć <b>Dalej</b> i powrócić do 
						   pierwszego kroku instalacji. Jeżeli chcesz dowiedzieć się więcej o znaczeniu tego błędu i sposobach jego rozwiązania, 
						   zajrzyj do dołączonej dokumentacji.";
$GLOBALS['strErrorOccured']			= "Wystąpiły następujące błędy:";
$GLOBALS['strErrorInstallDatabase']		= "Nie udało się strowzyć struktury bazy danych.";
$GLOBALS['strErrorUpgrade'] = 'The existing installation\'s database could not be upgraded.';
$GLOBALS['strErrorInstallConfig']		= "Plik konfiguracyjny lub naza danych nie mogły zostać zaktualizowane.";
$GLOBALS['strErrorInstallDbConnect']		= "Nie można było połączyć się z bazą danych.";

$GLOBALS['strUrlPrefix']			= "Prefiks adresu URL";

$GLOBALS['strProceed']				= "Dalej >";
$GLOBALS['strRepeatPassword']			= "Powtórz hasło";
$GLOBALS['strNotSamePasswords']			= "Hasła nie pasują do siebie";
$GLOBALS['strInvalidUserPwd']			= "Błędna nazwa użytkownika lub hasło";

$GLOBALS['strUpgrade']				= "Aktualizacja";
$GLOBALS['strSystemUpToDate']			= "Twój system ma już zainstalowaną najnowszą wersję programu, aktualizacja nie jest potrzebna. <br />Kliknij <b>Dalej</b> aby przejść na stronę główną.";
$GLOBALS['strSystemNeedsUpgrade']		= "Struktura bazy danych i plik konfiguracyjny muszą zostać zaktualizowane, aby zapewnić prawidłowe funkcjonowanie systemu. Kliknij <b>Dalej</b> aby rozpocząć proces aktualizacji. <br /><br />Zależnie od tego, z której wersji dokonywana jest aktualizacja i ile statystyk znajduje się już w bazie danych, może to spowodować znaczne obciążenie dla serwera. Przygotuj się na to, że aktualizacja może potrwać do kilkunastu minut.";
$GLOBALS['strSystemUpgradeBusy']		= "System w trakcie aktualizacji, proszę zaczekać...";
$GLOBALS['strSystemRebuildingCache']		= "Odbudowywanie cache'u, proszę zaczekać...";
$GLOBALS['strServiceUnavalable']		= "System jest obecnie niedostępny. Trwa aktualizacja";

$GLOBALS['strConfigNotWritable']		= "Plik config.inc.php nie może zostać zmodyfikowany";





/*-------------------------------------------------------*/
/* Configuration translations                            */
/*-------------------------------------------------------*/

// Global
$GLOBALS['strChooseSection']			= "Wybierz Sekcję";
$GLOBALS['strDayFullNames'] 			= array("Niedziela","Poniedziałek","Wtorek","Środa","Czwartek","Piątek","Sobota");
$GLOBALS['strEditConfigNotPossible']    	= "Zmiana tych ustawień nie jest możliwa, ponieważ plik konfiguracji jest zablokowany ze względów bezpieczeństwa. ".
										  "Jeżeli chcesz dokonać zmian, musisz najpierw odblokować plik config.inc.php.";
$GLOBALS['strEditConfigPossible']		= "Edycja wszystkich ustawień jest możliwa, ponieważ plik konfiguracyjny nie jest zablokowany, co może prowadzić do zagrożenia bezpieczeństwa. ".
										  "Jeżeli chcesz zabezpieczyć swój system, zablokuj plik config.inc.php.";



// Database
$GLOBALS['strDatabaseSettings']			= "Ustawienia Bazy Danych";
$GLOBALS['strDatabaseServer']			= "Serwer Bazy Danych";
$GLOBALS['strDbLocal']				= "Połącz z lokalnym serwerem używając sockets"; // Pg only
$GLOBALS['strDbHost']				= "Adres serwera";
$GLOBALS['strDbPort']				= "Numer portu bazy danych";
$GLOBALS['strDbUser']				= "Nazwa użytkownika";
$GLOBALS['strDbPassword']			= "Hasło";
$GLOBALS['strDbName']				= "Nazwa bazy danych";

$GLOBALS['strDatabaseOptimalisations']		= "Optymalizacja Bazy Danych";
$GLOBALS['strPersistentConnections']		= "Użyj stałych połączeń";
$GLOBALS['strCompatibilityMode']		= "Tryb kompatybilności bazy danych";
$GLOBALS['strCantConnectToDb']			= "Nie można połączyć z bazą danych";



// Invocation and Delivery
$GLOBALS['strInvocationAndDelivery']		= "Ustawienia Inwokacji i Dostarczania";

$GLOBALS['strAllowedInvocationTypes']		= "Dozwolone Typy Inwokacji";
$GLOBALS['strAllowRemoteInvocation']		= "Zezwól na zdalną inwokację";
$GLOBALS['strAllowRemoteJavascript']		= "Zezwól na zdalną inwokację z JavaScript";
$GLOBALS['strAllowRemoteFrames']		= "Zezwól na zdalną inwokację z ramkani";
$GLOBALS['strAllowRemoteXMLRPC']		= "Zezwól na zdalną inwokację z wykorzystaniem XML-RPC";
$GLOBALS['strAllowLocalmode']			= "Zezwól na tryb lokalny";
$GLOBALS['strAllowInterstitial']		= "Zezwól na Interstitials";
$GLOBALS['strAllowPopups']			= "Zezwól na Popups";

$GLOBALS['strUseAcl']				= "Użyj ograniczeń wyświetlania podczas dostarczania";

$GLOBALS['strDeliverySettings']			= "Ustawienia dostarczania";
$GLOBALS['strCacheType']			= "Typ cache'u dostarczania";
$GLOBALS['strCacheFiles']			= "Pliki";
$GLOBALS['strCacheDatabase']			= "Baza danych";
$GLOBALS['strCacheShmop']			= "Współdzielona pamięć/Shmop";
$GLOBALS['strCacheSysvshm']			= "Współdzielona pamięć/Sysvshm";
$GLOBALS['strExperimental']			= "Eksperymentalne";
$GLOBALS['strKeywordRetrieval']			= "Słowa Kluczowe";
$GLOBALS['strBannerRetrieval']			= "Metoda Doboru Bannerów";
$GLOBALS['strRetrieveRandom']			= "Losowy wybór (domyślnie)";
$GLOBALS['strRetrieveNormalSeq']		= "Normalny, sekwencyjny wybór";
$GLOBALS['strWeightSeq']			= "Sekwencyjny wybór w oparciu o wagę";
$GLOBALS['strFullSeq']				= "Pełny wybór sekwencyjny";
$GLOBALS['strUseConditionalKeys']		= "Zezwól na operatory logiczne przy bezpśrednim wyborze";
$GLOBALS['strUseMultipleKeys']			= "Zezwól na kilka słów kluczowych przy bezpośrednim wyborze";

$GLOBALS['strZonesSettings']			= "Wyświetlanie Stref";
$GLOBALS['strZoneCache']			= "Przechowuj strefy w cache'u, to powinno przyśpieszyć ich działanie";
$GLOBALS['strZoneCacheLimit']			= "Czas między aktualizacjami cache'u (w sekundach)";
$GLOBALS['strZoneCacheLimitErr']		= "Czas między aktualizacjami powinien być dodatnią liczbą całkowitą";

$GLOBALS['strP3PSettings']			= "Polityka Prywatności P3P";
$GLOBALS['strUseP3P']				= "Użyj Deklaracji P3P";
$GLOBALS['strP3PCompactPolicy']			= "Skrócona Deklaracja P3P";
$GLOBALS['strP3PPolicyLocation']		= "Lokalizacja Deklaracji P3P";



// Banner Settings
$GLOBALS['strBannerSettings']			= "Ustawienia Bannerów";

$GLOBALS['strAllowedBannerTypes']		= "Dozwolone Typy Bannerów";
$GLOBALS['strTypeSqlAllow']			= "Zezwól na lokalne bannery (SQL)";
$GLOBALS['strTypeWebAllow']			= "Zezwól na lokalne bannery (Webserver)";
$GLOBALS['strTypeUrlAllow']			= "Zezwól na zewnętrzne bannery";
$GLOBALS['strTypeHtmlAllow']			= "Zezwól na bannery HTML";
$GLOBALS['strTypeTxtAllow']			= "Zezwól na odnośniki tekstowe";

$GLOBALS['strTypeWebSettings']			= "Konfiguracja Lokalnych Bannerów (Webserver)";
$GLOBALS['strTypeWebMode']			= "Metoda przechowywania";
$GLOBALS['strTypeWebModeLocal']			= "Lokalny katalog";
$GLOBALS['strTypeWebModeFtp']			= "Zewnętrzny server FTP";
$GLOBALS['strTypeWebDir']			= "Lokalny katalog";
$GLOBALS['strTypeWebFtp']			= "Tryb FTP webservera bannerów";
$GLOBALS['strTypeWebUrl']			= "Publiczny URL";
$GLOBALS['strTypeWebSslUrl']			= "Publiczny URL (SSL)";
$GLOBALS['strTypeFTPHost']			= "Adres servera FTP";
$GLOBALS['strTypeFTPDirectory']			= "Katalog servera";
$GLOBALS['strTypeFTPUsername']			= "Login";
$GLOBALS['strTypeFTPPassword']			= "Hasło";
$GLOBALS['strTypeFTPErrorDir']			= "Podany katalog na serwerze nie istnieje";
$GLOBALS['strTypeFTPErrorConnect']		= "Błąd połączenia z serwerem FTP, login i hasło są niepoprawne";
$GLOBALS['strTypeFTPErrorHost']			= "Nazwa hosta serwera FTP nie jest poprawna";
$GLOBALS['strTypeDirError']			= "Lokalny katalog nie istnieje";



$GLOBALS['strDefaultBanners']			= "Domyślne Bannery";
$GLOBALS['strDefaultBannerUrl']			= "Adres URL domyślnego bannera";
$GLOBALS['strDefaultBannerTarget']		= "Adres URL docelowy";

$GLOBALS['strTypeHtmlSettings']			= "Opcje bannera HTML";
$GLOBALS['strTypeHtmlAuto']			= "Automatycznie zmieniaj bannery HTML aby wymusię śledzenie Kliknięć";
$GLOBALS['strTypeHtmlPhp']			= "Zezwól na wykonywanie poleceń PHP w bannerach HTML";



// Host information and Geotargeting
$GLOBALS['strHostAndGeo']			= "Informacje o serwerze i śledzeniu geograficznym";

$GLOBALS['strRemoteHost']			= "Zdalny serwer";
$GLOBALS['strReverseLookup']			= "Spróbuj ustalić nazwę hosta odwiedzającego, jeżeli nie została podana przez serwer";
$GLOBALS['strProxyLookup']			= "Spróbuj ustalić prawdziwy adres IP odwiedzającego, jeżeli korzysta on z Proxy";

$GLOBALS['strGeotargeting']			= "Geotargeting";
$GLOBALS['strGeotrackingType']			= "Typ bazy danych śledzenia geograficznego";
$GLOBALS['strGeotrackingLocation'] 		= "Lokalizacja bazy danych śledzenia geograficznego";
$GLOBALS['strGeoStoreCookie']			= "Zapisz wyniki w cookie dla późniejszego wykorzystania";



// Statistics Settings
$GLOBALS['strStatisticsSettings']		= "Ustawienia Statystyk";

$GLOBALS['strStatisticsFormat']			= "Format Statystyk";
$GLOBALS['strCompactStats']			= "Format statystyk";
$GLOBALS['strLogAdviews']			= "Loguj Odsłonę przy każdym dostarczeniu bannera";
$GLOBALS['strLogAdclicks']			= "Loguj Kliknięcie za każdym razem gdy odwiedzający kliknie w banner";
$GLOBALS['strLogSource']			= "Loguj parametr źródła podany w inwokacji";
$GLOBALS['strGeoLogStats']			= "Loguj kraj odwiedzającego w statystykach";
$GLOBALS['strLogHostnameOrIP']			= "Loguj nazwę hosta lub adres IP odwiedzającego";
$GLOBALS['strLogIPOnly']			= "Loguj tylko adres IP odwiedzającego, nawet jeżeli nazwa hosta jest znana";
$GLOBALS['strLogIP']				= "Loguj adres IP odwiedzającego";
$GLOBALS['strLogBeacon']			= "Używaj małego obrazka przy logowaniu Odsłon aby zapewnić, że tylko dostarczone bannery są logowane";

$GLOBALS['strRemoteHosts']			= "Zdalne Hosty";
$GLOBALS['strIgnoreHosts']			= "Nie przechowuj statystyk dla odwiedzających używających jednego z poniższych adresów IP lub hostów";
$GLOBALS['strBlockAdviews']			= "Nie loguj Odsłon jeżeli odwiedzający widział ten sam banner w ciągu podanego w sekundach czasu";
$GLOBALS['strBlockAdclicks']			= "Nie loguj Kliknięć jeżeli odwiedzający kliknął w banner w ciągu podanego w sekundach czasu";


$GLOBALS['strEmailWarnings']			= "Ostrzeżenia Przez E-mail";
$GLOBALS['strAdminEmailHeaders']		= "Nagłówek z informacją o nadawcy dziennych raportów";
$GLOBALS['strWarnLimit']			= "Limit Ostrzeżenia";
$GLOBALS['strWarnLimitErr']			= "Limit ostrzeżenia powinien być dodatnią liczbą całkowitą";
$GLOBALS['strWarnAdmin']			= "Ostrzeżenie Administratora";
$GLOBALS['strWarnClient']			= "Ostrzeżenie Reklamodawcy";
$GLOBALS['strQmailPatch']			= "Włącz łatkę qmail'a";

$GLOBALS['strAutoCleanTables']			= "Automatycznie Czyszczenie Bazy Danych";
$GLOBALS['strAutoCleanStats']			= "Wyczyść statystyki";
$GLOBALS['strAutoCleanUserlog']			= "Wyczyść log użytkownika";
$GLOBALS['strAutoCleanStatsWeeks']		= "Maksymalny wiek statystyk <br />(minimum 3 tygodnie)";
$GLOBALS['strAutoCleanUserlogWeeks']		= "Maksymalny wiek logu użytkownika <br />(minimum 3 tygodnie)";
$GLOBALS['strAutoCleanErr']			= "Maksymalny wiek musi mieć przynajmniej 3 tygodnie";
$GLOBALS['strAutoCleanVacuum']			= "ANALIZA VACUUM tabel co noc"; // only Pg



// Administrator settings
$GLOBALS['strAdministratorSettings']		= "Ustawienia Administratora";

$GLOBALS['strLoginCredentials']			= "Informacje Logowania";
$GLOBALS['strAdminUsername']			= "Nazwa użytkownika Admina";
$GLOBALS['strOldPassword']			= "Stare hasło";
$GLOBALS['strNewPassword']			= "Nowe hasło";
$GLOBALS['strInvalidUsername']			= "Nieprawidłowa nazwa użytkownika";
$GLOBALS['strInvalidPassword']			= "Nieprawidłowe hasło";

$GLOBALS['strBasicInformation']			= "Podstawowe informacje";
$GLOBALS['strAdminFullName']			= "Imię i nazwisko admina";
$GLOBALS['strAdminEmail']			= "Adres email admina";
$GLOBALS['strCompanyName']			= "Nazwa firmy";

$GLOBALS['strAdminCheckUpdates']		= "Sorawdź aktualizacje";
$GLOBALS['strAdminCheckEveryLogin']		= "Przy każdym logowaniu";
$GLOBALS['strAdminCheckDaily']			= "Codziennie";
$GLOBALS['strAdminCheckWeekly']			= "Co tydzień";
$GLOBALS['strAdminCheckMonthly']		= "Co miesiąc";
$GLOBALS['strAdminCheckNever']			= "Nigdy";

$GLOBALS['strAdminNovice']			= "Działania administratora usuwające dane wymagają potwierdzenia dla bezpieczeństwa";
$GLOBALS['strUserlogEmail']			= "Loguj wszystkie wychodzące wiadomości email";
$GLOBALS['strUserlogPriority']			= "Loguj godzinne kalkukacje priorytetów";
$GLOBALS['strUserlogAutoClean']			= "Loguj automatyczne czyszczenie bazy danych";


// User interface settings
$GLOBALS['strGuiSettings']			= "Konfiguracja Interfejsu Użytkownika";

$GLOBALS['strGeneralSettings']			= "Ogólne Ustawienia";
$GLOBALS['strAppName']				= "Nazwa programu";
$GLOBALS['strMyHeader']				= "Mój nagłówek";
$GLOBALS['strMyFooter']				= "Moja stopka";
$GLOBALS['strGzipContentCompression']		= "Użyj kompresji zawartości GZIP";

$GLOBALS['strClientInterface']			= "Interfejs Reklamodawcy";
$GLOBALS['strClientWelcomeEnabled']		= "Włącz wiadomości powitalne dla reklamodawcy";
$GLOBALS['strClientWelcomeText']		= "Tekst powitalny<br />(znaczniki HTML dozwolone)";



// Interface defaults
$GLOBALS['strInterfaceDefaults']		= "Domyślne Ustawienia Interfejsu";

$GLOBALS['strInventory']			= "Administracja";
$GLOBALS['strShowCampaignInfo']			= "Pokaż dodatkowe informacje o kampanii na stronie <i>Przegląd Kampanii</i>";
$GLOBALS['strShowBannerInfo']			= "Pokaż dodatkowe informacje o bannerze na stronie <i>Przegląd Bannerów</i>";
$GLOBALS['strShowCampaignPreview']		= "Pokaż podgąd wszystkich bannerów na stronie <i>Przegląd Bannerów</i>";
$GLOBALS['strShowBannerHTML']			= "Pokaż właściwy banner zamiast kodu HTML dla podglądu bannerów HTML";
$GLOBALS['strShowBannerPreview']		= "Pokaż podgląd bannera na górze stron, które dotyczą bannerów";
$GLOBALS['strHideInactive']			= "Ukryj nieaktywne elementy ze wszystkich stron przeglądowych";
$GLOBALS['strGUIShowMatchingBanners']		= "Pokaż pasujące bannery na stronach <i>Przyłączony banner</i>";
$GLOBALS['strGUIShowParentCampaigns']		= "Pokaż nadrzędne kampanie na stronach <i>Przyłączony banner</i>";
$GLOBALS['strGUILinkCompactLimit']		= "Hide non-linked campaigns or banners on the <i>Linked banner</i> pages when there are more than";

$GLOBALS['strStatisticsDefaults'] 		= "Statystyki";
$GLOBALS['strBeginOfWeek']			= "Początek tygodnia";
$GLOBALS['strPercentageDecimals']		= "Cyfr po przecinku";

$GLOBALS['strWeightDefaults']			= "Domyślne Wagi";
$GLOBALS['strDefaultBannerWeight']		= "Domyślna waga bannera";
$GLOBALS['strDefaultCampaignWeight']		= "Domyślna waga kampanii";
$GLOBALS['strDefaultBannerWErr']		= "Domyślna waga bannera powinna być dodatnią liczbę całkowitą";
$GLOBALS['strDefaultCampaignWErr']		= "Domyślna waga kampanii powinna być dodatnią liczbę całkowitą";



// Not used at the moment
$GLOBALS['strTableBorderColor']			= "Kolor Obramowania Tabeli";
$GLOBALS['strTableBackColor']			= "Kolor Tła Tabeli";
$GLOBALS['strTableBackColorAlt']		= "Kolor Tła Tabeli (Alternatywny)";
$GLOBALS['strMainBackColor']			= "Główny Kolor Tła";
$GLOBALS['strOverrideGD']			= "Zignoruj Format Grafiki GD";
$GLOBALS['strTimeZone']				= "Strefa Czasowa";

?>