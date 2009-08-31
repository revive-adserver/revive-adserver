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
$GLOBALS['strInstall']				= "Zainstaluj";
$GLOBALS['strChooseInstallLanguage']		= "Wybierz język dla procedury instalacji";
$GLOBALS['strLanguageSelection']		= "Język";
$GLOBALS['strDatabaseSettings']			= "Ustawienia bazy danych";
$GLOBALS['strAdminSettings']			= "Ustawienia Administratora";
$GLOBALS['strAdvancedSettings']			= "Ustawienia zaawansowane";
$GLOBALS['strOtherSettings']			= "Inne Ustawienia";

$GLOBALS['strWarning']				= "Uwaga";
$GLOBALS['strFatalError']			= "Wystąpił błąd krytyczny";
$GLOBALS['strAlreadyInstalled']			= MAX_PRODUCT_NAME." jest już zainstalowany na tym systemie. Jeżeli chcesz go skonfigurować, idź do <a href='settings-index.php'>części ustawień</a>";
$GLOBALS['strCouldNotConnectToDB']		= "Połączenie z bazą danych nie było możliwe, sprawdź poprawność wpisanych danych";
$GLOBALS['strCreateTableTestFailed']		= "Użytkownik, którego podałeś nie ma uprawnień do tworzenia lub zmiany tabel w bazie danych, skontaktuj się z administratorem bazy danych.";
$GLOBALS['strUpdateTableTestFailed']		= "Użytkownik, którego podałeś nie ma uprawnień do zmiany struktury bazy danych, skontaktuj się z administratorem bazy danych.";
$GLOBALS['strTablePrefixInvalid']		= "Prefiks tabeli zawiera nieprawidłowe znaki";
$GLOBALS['strTableInUse']			= "Baza danych, którą podałeś jest już używana przez ".MAX_PRODUCT_NAME.", podaj inny prefiks tabeli lub przeczytaj w dokumentacji instrukcje dotyczące aktualizacji.";
$GLOBALS['strTableWrongType']			= "Wybrany przez ciebie typ tabeli nie jest obsługiwany przez twoją instalację ".$phpAds_dbmsname;
$GLOBALS['strMayNotFunction']			= "Przed kontynuacją popraw te potencjalne problemy:";
$GLOBALS['strIgnoreWarnings']			= "Ignoruj ostrzeżenia";
$GLOBALS['strWarningDBavailable']		= "Wersja PHP, której używasz nie ma możliwości korzystania z serwera baz danych ".$phpAds_dbmsname.". Musisz włączyć rozszerzenie PHP ".$phpAds_dbmsname." zanim będziesz mógł kontynuować.";
$GLOBALS['strWarningPHPversion']		= MAX_PRODUCT_NAME." wymaga PHP 4.0 lub nowszego do poprawnego funkcjonowania. Na serwerze jest obecnie {php_version}.";
$GLOBALS['strWarningRegisterGlobals']		= "Opcja konfiguracyjna PHP register_globals musi być włączona.";
$GLOBALS['strWarningMagicQuotesGPC']		= "Opcja konfiguracyjna PHP magic_quotes_gpc musi być włączona.";
$GLOBALS['strWarningMagicQuotesRuntime']	= "Opcja konfiguracyjna PHP magic_quotes_runtime musi być wyłączona.";
$GLOBALS['strWarningFileUploads']		= "Opcja konfiguracyjna PHP file_uploads musi być wyłączona.";
$GLOBALS['strWarningTrackVars']			= "Opcja konfiguracyjna PHP variable track_vars musi być wyłączona.";
$GLOBALS['strWarningPREG']			= "Wersja PHP, której używasz nie posiada obsługi wyrażeń regularnych w formacie PERL'a. Musisz włączyć rozszerzenie PREG zanim będziesz mógł przejść dalej.";
$GLOBALS['strConfigLockedDetected']		= MAX_PRODUCT_NAME." wykryło, że twój plik <b>config.inc.php</b> nie może być modyfikowany przez server.<br /> Kontynuacja nie będzie możliwa zanim nie zmienisz uprawnień dla tego pliku. <br />Przeczytaj dołączoną dokumentację, jeżeli nie wiesz jak to zrobić.";
$GLOBALS['strCantUpdateDB']  			= "Aktualizacja bazy danych nie jest w tej chwili możliwa. Jeżeli zdecydujesz się kontynuować, wszystkie istniejące bannery, statystyki i reklamodawcy zostaną usunięci.";
$GLOBALS['strTableNames']			= "Nazwy Tabeli";
$GLOBALS['strTablesPrefix']			= "Prefiks nazw tabeli";
$GLOBALS['strTablesType']			= "Typ tabeli";

$GLOBALS['strInstallWelcome']			= "Witamy w ".MAX_PRODUCT_NAME;
$GLOBALS['strInstallMessage']			= "Zanim możesz zacząć używać ".MAX_PRODUCT_NAME." musi on zostać skonfigurowany i <br /> utworzona zostać baza danych. Kliknij <b>Dalej</b> aby kontynuować.";
$GLOBALS['strInstallSuccess']			= "Po kliknięciu 'Dalej' zostaniesz zalogowany do serwera. <p><strong>Co dalej?</strong></p> <div class='psub'> <p><b>Zarejestruj się, aby być na bieżąco z aktualizacjami produktu</b><br> <a href='". OX_PRODUCT_DOCSURL ."/wizard/join' target='_blank'>Zapisz się na listę ". MAX_PRODUCT_NAME ."</a> , aby otrzymywać  informacje na temat aktualizacji, alerty zabezpieczeń oraz nowości z zakresu produktu. </p> <p><b>Pierwsza kampania reklamowa</b><br> Nasz <a href='". OX_PRODUCT_DOCSURL ."/wizard/qsg-firstcampaign' target='_blank'>przewodnik w pigułce pozwoli Ci sprawnie skonfigurować pierwszą kampanię</a>. </p> </div> <p><strong>Opcjonalne kroki podczas instalacji</strong></p> <div class='psub'> <p><b>Blokada plików konfiguracyjnych</b><br> Ten krok pozwala zabezpieczyć serwer przed wprowadzeniem niepożądanych zmian w jego konfiguracji. <a href='". OX_PRODUCT_DOCSURL ."/wizard/lock-config' target='_blank'>Więcej na ten temat</a>. </p> <p><b>Ustawienie regularnej konserwacji</b><br> Zalecamy skrypt konserwacyjny, gdyż zapewnia on terminowe sporządzanie raportów oraz optymalną efektywność dostarczania. <a href='". OX_PRODUCT_DOCSURL ."/wizard/setup-cron' target='_blank'>Więcej na ten temat</a> </p> <p><b>Sprawdzenie konfiguracji systemu</b><br> Zanim rozpoczniesz korzystanie z ". MAX_PRODUCT_NAME ." zalecamy sprawdzenie ustawień w zakładce 'Ustawienia'. </p> </div>";
$GLOBALS['strUpdateSuccess']			= "<b>Aktualizacja ".MAX_PRODUCT_NAME." zakończyła się pomyślnie.</b><br /><br />Aby zapewnić prawidłowe funkcjonowanie ".MAX_PRODUCT_NAME." musisz także\n						   zapewnić uruchamianie pliku utrzymania co godzinę (przedtem wystarczyło raz dziennie). Więcej informacji na ten temat znajdziesz w dokumentacji.\n						   <br /><br />Kliknij <b>Dalej</b> aby przejść do interfejsu administracyjnego. Nie zapomnij także zablokować pliku config.inc.php \n						   aby zapobiec naruszeniu bezpieczeństwa.";
$GLOBALS['strInstallNotSuccessful']		= "<b>Instalacja ". MAX_PRODUCT_NAME ." nie powiodła się</b><br /><br />Niektóre części procesu instalacyjnego nie zostały zakończone.\nMożliwe, że te problemy są jedynie przejściowe, w takim wypadku możesz po prostu kliknąć <b>Dalej</b> i powrócić do \npierwszego kroku instalacji. Jeżeli chcesz dowiedzieć się więcej o znaczeniu tego błędu i sposobach jego rozwiązania,\nzajrzyj do dołączonej dokumentacji.";
$GLOBALS['strErrorOccured']			= "Wystąpiły następujące błędy:";
$GLOBALS['strErrorInstallDatabase']		= "Nie udało się strowzyć struktury bazy danych.";
$GLOBALS['strErrorUpgrade'] = 'The existing installation\'s database could not be upgraded.';
$GLOBALS['strErrorInstallConfig']		= "Plik konfiguracyjny lub naza danych nie mogły zostać zaktualizowane.";
$GLOBALS['strErrorInstallDbConnect']		= "Nie można było połączyć się z bazą danych.";

$GLOBALS['strUrlPrefix']			= "Prefiks adresu URL";

$GLOBALS['strProceed']				= "Dalej >";
$GLOBALS['strRepeatPassword']			= "Powtórz hasło";
$GLOBALS['strNotSamePasswords']			= "Hasła nie są identyczne";
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
$GLOBALS['strChooseSection']			= "Wybierz sekcję";
$GLOBALS['strDayFullNames'][0] = "Niedziela";
$GLOBALS['strDayFullNames'][1] = "Poniedziałek";
$GLOBALS['strDayFullNames'][2] = "Wtorek";
$GLOBALS['strDayFullNames'][3] = "Środa";
$GLOBALS['strDayFullNames'][4] = "Czwartek";
$GLOBALS['strDayFullNames'][5] = "Piątek";
$GLOBALS['strDayFullNames'][6] = "Sobota";

$GLOBALS['strEditConfigNotPossible']    	= "Nie można edytować ustawień, ponieważ plik konfiguracji został zablokowany do edycji ze względów bezpieczeństwa. Jeśli chcesz wprowadzić zmiany, musisz odblokować plik konfiguracji przed rozpoczęciem instalacji.";
$GLOBALS['strEditConfigPossible']		= "Można edytować wszystkie ustawienia, ponieważ plik konfiguracji nie został zablokowany, jednak stwarza to pewne zagrożenia. Jeśli chcesz zabezpieczyć system, powinieneś zablokować plik konfiguracji przed instalacją.";



// Database
$GLOBALS['strDatabaseSettings']			= "Ustawienia Bazy Danych";
$GLOBALS['strDatabaseServer']			= "Ogólne ustawienia serwera bazy danych";
$GLOBALS['strDbLocal']				= "Użyj lokalnego połączenia z portem"; // Pg only
$GLOBALS['strDbHost']				= "Adres serwera";
$GLOBALS['strDbPort']				= "Numer portu bazy danych";
$GLOBALS['strDbUser']				= "Nazwa użytkownika";
$GLOBALS['strDbPassword']			= "Hasło";
$GLOBALS['strDbName']				= "Nazwa bazy danych";

$GLOBALS['strDatabaseOptimalisations']		= "Optymalizacja bazy danych";
$GLOBALS['strPersistentConnections']		= "Użyj połączeń stałych";
$GLOBALS['strCompatibilityMode']		= "Tryb kompatybilności bazy danych";
$GLOBALS['strCantConnectToDb']			= "Nie można połączyć z bazą danych";



// Invocation and Delivery
$GLOBALS['strInvocationAndDelivery']		= "Ustawienia kodu wywołującego";

$GLOBALS['strAllowedInvocationTypes']		= "Dopuszczalne typy kodu wywołującego";
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
$GLOBALS['strCacheFiles']			= "Plik";
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

$GLOBALS['strP3PSettings']			= "Polityka prywatności P3P";
$GLOBALS['strUseP3P']				= "Użyj deklaracji P3P";
$GLOBALS['strP3PCompactPolicy']			= "Skrócona deklaracja P3P";
$GLOBALS['strP3PPolicyLocation']		= "Lokalizacja deklaracji P3P";



// Banner Settings
$GLOBALS['strBannerSettings']			= "Ustawienia banera";

$GLOBALS['strAllowedBannerTypes']		= "Dozwolone typy banerów";
$GLOBALS['strTypeSqlAllow']			= "Dopuść banery lokalne SQL";
$GLOBALS['strTypeWebAllow']			= "Dopuść banery serwera lokalnego";
$GLOBALS['strTypeUrlAllow']			= "Dopuść banery zewnętrzne";
$GLOBALS['strTypeHtmlAllow']			= "Dopuść banery HTML";
$GLOBALS['strTypeTxtAllow']			= "Dopuść reklamy tekstowe";

$GLOBALS['strTypeWebSettings']			= "Konfiguracja banerów lokalnych (Webserwer)";
$GLOBALS['strTypeWebMode']			= "Metoda przechowywania";
$GLOBALS['strTypeWebModeLocal']			= "Katalog lokalny";
$GLOBALS['strTypeWebModeFtp']			= "Zewnętrzny serwer FTP";
$GLOBALS['strTypeWebDir']			= "Katalog lokalny";
$GLOBALS['strTypeWebFtp']			= "Tryb FTP webservera bannerów";
$GLOBALS['strTypeWebUrl']			= "Publiczny URL";
$GLOBALS['strTypeWebSslUrl']			= "Publiczny URL (SSL)";
$GLOBALS['strTypeFTPHost']			= "Adres serwera FTP";
$GLOBALS['strTypeFTPDirectory']			= "Katalog serwera";
$GLOBALS['strTypeFTPUsername']			= "Login";
$GLOBALS['strTypeFTPPassword']			= "Hasło";
$GLOBALS['strTypeFTPErrorDir']			= "Podany katalog na serwerze nie istnieje";
$GLOBALS['strTypeFTPErrorConnect']		= "Błąd połączenia z serwerem FTP, login lub hasło jest niepoprawne";
$GLOBALS['strTypeFTPErrorHost']			= "Nazwa hosta serwera FTP nie jest poprawna";
$GLOBALS['strTypeDirError']			= "Serwer nie może dokonywać wpisów w katalogu lokalnym";



$GLOBALS['strDefaultBanners']			= "Banery domyślne";
$GLOBALS['strDefaultBannerUrl']			= "Położenie domyślnego obrazka (adres URL)";
$GLOBALS['strDefaultBannerTarget']		= "Adres URL docelowy";

$GLOBALS['strTypeHtmlSettings']			= "Opcje banera HTML";
$GLOBALS['strTypeHtmlAuto']			= "Automatycznie modyfikuj banery HTML, aby włączyć śledzenie kliknięć";
$GLOBALS['strTypeHtmlPhp']			= "Zezwól na wykonywanie kodu PHP, gdy banery napisane są w HTML";



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
$GLOBALS['strStatisticsSettings']		= "Ustawienia statystyk i konserwacji";

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
$GLOBALS['strIgnoreHosts']			= "Nie protokołuj statystyk dla odwiedzających używających jednego z poniższych adresów IP lub hostów";
$GLOBALS['strBlockAdviews']			= "Nie loguj Odsłon jeżeli odwiedzający widział ten sam banner w ciągu podanego w sekundach czasu";
$GLOBALS['strBlockAdclicks']			= "Nie loguj Kliknięć jeżeli odwiedzający kliknął w banner w ciągu podanego w sekundach czasu";


$GLOBALS['strEmailWarnings']			= "Ostrzeżenia e-mail";
$GLOBALS['strAdminEmailHeaders']		= "Dodaj następujące nagłówki do każdego e-maila wysyłanego przez ". MAX_PRODUCT_NAME ."";
$GLOBALS['strWarnLimit']			= "Limit Ostrzeżenia - wyślij ostrzeżenie, gdy ilość pozostałych odsłon jest mniejsza niż ta określona tutaj";
$GLOBALS['strWarnLimitErr']			= "Limit ostrzeżenia musi być dodatnią liczbą całkowitą";
$GLOBALS['strWarnAdmin']			= "Wyślij ostrzeżenie do administratora zawsze, gdy kampania dobiega końca";
$GLOBALS['strWarnClient']			= "Wyślij ostrzeżenie do reklamodawcy zawsze, gdy kampania dobiega końca";
$GLOBALS['strQmailPatch']			= "Włącz łatkę qmail";

$GLOBALS['strAutoCleanTables']			= "Automatycznie Czyszczenie Bazy Danych";
$GLOBALS['strAutoCleanStats']			= "Wyczyść statystyki";
$GLOBALS['strAutoCleanUserlog']			= "Wyczyść log użytkownika";
$GLOBALS['strAutoCleanStatsWeeks']		= "Maksymalny wiek statystyk <br />(minimum 3 tygodnie)";
$GLOBALS['strAutoCleanUserlogWeeks']		= "Maksymalny wiek logu użytkownika <br />(minimum 3 tygodnie)";
$GLOBALS['strAutoCleanErr']			= "Maksymalny wiek musi mieć przynajmniej 3 tygodnie";
$GLOBALS['strAutoCleanVacuum']			= "ANALIZA VACUUM tabel co noc"; // only Pg



// Administrator settings
$GLOBALS['strAdministratorSettings']		= "Ustawienia Administratora";

$GLOBALS['strLoginCredentials']			= "Informacje logowania";
$GLOBALS['strAdminUsername']			= "Nazwa użytkownika Administratora";
$GLOBALS['strOldPassword']			= "Stare hasło";
$GLOBALS['strNewPassword']			= "Nowe hasło";
$GLOBALS['strInvalidUsername']			= "Nieprawidłowa nazwa użytkownika";
$GLOBALS['strInvalidPassword']			= "Nowe hasło jest nieprawidłowe. Podaj inne hasło.";

$GLOBALS['strBasicInformation']			= "Informacje podstawowe";
$GLOBALS['strAdminFullName']			= "Imię i nazwisko admina";
$GLOBALS['strAdminEmail']			= "E-mail admina";
$GLOBALS['strCompanyName']			= "Nazwa firmy";

$GLOBALS['strAdminCheckUpdates']		= "Sorawdź aktualizacje";
$GLOBALS['strAdminCheckEveryLogin']		= "Przy każdym logowaniu";
$GLOBALS['strAdminCheckDaily']			= "Codziennie";
$GLOBALS['strAdminCheckWeekly']			= "Co tydzień";
$GLOBALS['strAdminCheckMonthly']		= "Co miesiąc";
$GLOBALS['strAdminCheckNever']			= "Nigdy";

$GLOBALS['strAdminNovice']			= "Usuwanie przez Administratora wymaga potwierdzenia ze względów bezpieczeństwa";
$GLOBALS['strUserlogEmail']			= "Loguj wszystkie wychodzące wiadomości e-mail";
$GLOBALS['strUserlogPriority']			= "Loguj godzinne kalkukacje priorytetów";
$GLOBALS['strUserlogAutoClean']			= "Loguj automatyczne czyszczenie bazy danych";


// User interface settings
$GLOBALS['strGuiSettings']			= "Konfiguracja interfejsu użytkownika";

$GLOBALS['strGeneralSettings']			= "Ustawienia ogólne";
$GLOBALS['strAppName']				= "Nazwa programu";
$GLOBALS['strMyHeader']				= "Mój nagłówek";
$GLOBALS['strMyFooter']				= "Moja stopka";
$GLOBALS['strGzipContentCompression']		= "Użyj kompresji zawartości GZIP";

$GLOBALS['strClientInterface']			= "Interfejs Reklamodawcy";
$GLOBALS['strClientWelcomeEnabled']		= "Włącz wiadomości powitalne dla Reklamodawcy";
$GLOBALS['strClientWelcomeText']		= "Tekst powitalny<br />(znaczniki HTML dozwolone)";



// Interface defaults
$GLOBALS['strInterfaceDefaults']		= "Ustawienia domyślne interfejsu";

$GLOBALS['strInventory']			= "Inwentarz";
$GLOBALS['strShowCampaignInfo']			= "Pokaż dodatkowe informacje o kampanii na stronie <i>Kampanie</i>";
$GLOBALS['strShowBannerInfo']			= "Pokaż dodatkowe informacje o banerze na stronie <i>Banery</i>";
$GLOBALS['strShowCampaignPreview']		= "Pokaż podgląd wszystkich banerów na stronie <i>Banery</i>";
$GLOBALS['strShowBannerHTML']			= "Pokaż baner zamiast zwykłego kodu HTML w podglądzie banerów HTML";
$GLOBALS['strShowBannerPreview']		= "Pokaż podgląd banera na górze stron, które wyświetlają banery";
$GLOBALS['strHideInactive']			= "Ukryj nieaktywne";
$GLOBALS['strGUIShowMatchingBanners']		= "Pokaż pasujące banery na stronach <i>Podłączony baner</i>";
$GLOBALS['strGUIShowParentCampaigns']		= "Pokaż nadrzędne kampanie na stronach <i>Podłączony baner</i>";
$GLOBALS['strGUILinkCompactLimit']		= "Hide non-linked campaigns or banners on the <i>Linked banner</i> pages when there are more than";

$GLOBALS['strStatisticsDefaults'] 		= "Statystyki";
$GLOBALS['strBeginOfWeek']			= "Początek tygodnia";
$GLOBALS['strPercentageDecimals']		= "Cyfr po przecinku";

$GLOBALS['strWeightDefaults']			= "Waga domyślna";
$GLOBALS['strDefaultBannerWeight']		= "Domyślna waga banera";
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



// Note: New translations not found in original lang files but found in CSV
$GLOBALS['strHasTaxID'] = "NIP";
$GLOBALS['strAdminAccount'] = "Konto Administratora";
$GLOBALS['strSpecifySyncSettings'] = "Ustawienia synchronizacji";
$GLOBALS['strOpenadsIdYour'] = "Twoje ID OpenX";
$GLOBALS['strOpenadsIdSettings'] = "Ustawienia ID OpenX";
$GLOBALS['strBtnContinue'] = "Dalej »";
$GLOBALS['strBtnRecover'] = "Odzyskaj »";
$GLOBALS['strBtnStartAgain'] = "Rozpocznij aktualizację od początku »";
$GLOBALS['strBtnGoBack'] = "« Wstecz";
$GLOBALS['strBtnAgree'] = "Wyrażam zgodę »";
$GLOBALS['strBtnDontAgree'] = "« Nie wyrażam zgody";
$GLOBALS['strBtnRetry'] = "Próbuj ponownie";
$GLOBALS['strFixErrorsBeforeContinuing'] = "Napraw błędy zanim przejdziesz dalej.";
$GLOBALS['strWarningRegisterArgcArv'] = "Aby uruchomić działania konserwacyjne z polecenia należy włączyć zmienną konfiguracji PHP register_argc_argv.";
$GLOBALS['strInstallIntro'] = "Dziękujemy za wybranie <a href='http://". MAX_PRODUCT_URL ."' target='_blank'><strong>". MAX_PRODUCT_NAME ."</strong></a><p>Kreator pomoże Ci zainstalować / zaktualizować ". MAX_PRODUCT_NAME ."  </p><p> Aby ułatwić proces instalacji opracowaliśmy przewodnik a href='". OX_PRODUCT_DOCSURL ."/wizard/qsg-install' target='_blank'>Installation Quick Start Guide</a>, który umożliwi Ci sprawną aktywację. Bardziej szczegółowe informacje na temat instalacji i konfiguracji ". MAX_PRODUCT_NAME ."  uzyskasz w przewodniku <a href='". OX_PRODUCT_DOCSURL ."/wizard/admin-guide' target='_blank'>Administrator Guide</a>.";
$GLOBALS['strRecoveryRequiredTitle'] = "W czasie poprzedniej próby aktualizacji wystąpiły błędy";
$GLOBALS['strRecoveryRequired'] = "Wystąpił błąd w trakcie przetwarzania poprzedniej próby aktualizacji. ". MAX_PRODUCT_NAME ." spróbuje odzyskać dane z poprzedniej aktualizacji. Kliknij Odzyskaj poniżej.";
$GLOBALS['strTermsTitle'] = "Warunki i zasady korzystania z serwisu, Polityka prywatności";
$GLOBALS['strTermsIntro'] = "". MAX_PRODUCT_NAME ." jest udostępniony w ramach licencji Open Source, GNU General Public License. Proszę przeczytać i zaakceptować następujące dokumenty, aby kontynuować instalację.";
$GLOBALS['strPolicyTitle'] = "Polityka prywatności";
$GLOBALS['strPolicyIntro'] = "Przed kontynuacją instalacji zapoznaj się z następującym dokumentem i potwierdź, że się z nim zgadzasz.";
$GLOBALS['strDbSetupTitle'] = "Ustawienia bazy danych";
$GLOBALS['strDbSetupIntro'] = "Wprowadź dane, aby połączyć się z bazą danych. Jeśli nie masz pewności, jakie dane należy wprowadzić, skontaktuj się ze swoim administratorem systemu. <p> Kolejnym krokiem będzie konfiguracja bazy danych. Kliknij 'Dalej', aby kontynuować.</p>";
$GLOBALS['strDbUpgradeIntro'] = "Poniżej znajdują się informacje o bazie danych potrzebne do instalacji ". MAX_PRODUCT_NAME .". Sprawdź ich poprawność. <p>Kolejnym krokiem będzie aktualizowanie bazy danych. Kliknij 'Dalej', aby aktualizować system.</p>";
$GLOBALS['strOaUpToDate'] = "Twoja baza danych ". MAX_PRODUCT_NAME ." oraz struktura pliku wskazuje, że korzystasz z najnowszej wersji i aktualizacja nie jest wymagana w tym momencie. Kliknij Dalej, aby przejść do panelu administratora ". MAX_PRODUCT_NAME .".";
$GLOBALS['strOaUpToDateCantRemove'] = "Ostrzeżenie: plik UPGRADE wciąż znajduje się w folderze var. Nie możemy go usunąć ze względu na ograniczone uprawnienia. Musisz usunąć plik własnoręcznie.";
$GLOBALS['strRemoveUpgradeFile'] = "Musisz usunąć plik UPGRADE z folderu var.";
$GLOBALS['strSystemCheck'] = "Sprawdzanie systemu";
$GLOBALS['strSystemCheckIntro'] = "Instalator sprawdza ustawienia serwera, aby upenić się, że proces instalacji przebiegnie bez zakłóceń. 	<p>Zaznacz wszystkie wyróżnione punkty, aby dokończyć proces instalacji.</p>";
$GLOBALS['strDbSuccessIntro'] = "Baza danych ". MAX_PRODUCT_NAME ." została utworzona. Kliknij 'Dalej', aby kontynuować konfigurację Administratora ". MAX_PRODUCT_NAME ." oraz Ustawień Dostarczania.";
$GLOBALS['strDbSuccessIntroUpgrade'] = "Aktualizacja systemu zakończyła się pomyślnie. Pozostałe instrukcje pomogą Ci zaktualizować konfigurację Twojego nowego serwera do obsługi reklam.";
$GLOBALS['strErrorWritePermissions'] = "Wykryto błędy w dostępie do pliku. Błędy muszą zostać naprawione zanim przejdziesz dalej.<br/>Aby naprawić błędy w systemie Linux, spróbuj wpisać następujące polecenie(a):";
$GLOBALS['strErrorFixPermissionsCommand'] = "<i>chmod a+w %s</i>";
$GLOBALS['strErrorWritePermissionsWin'] = "Wykryto błędy w dostępie do pliku. Błędy muszą zostać naprawione zanim przejdziesz dalej.";
$GLOBALS['strCheckDocumentation'] = "Więcej wskazówek uzyskasz w <a href='". OX_PRODUCT_DOCSURL ."'>Dokumentacji ". MAX_PRODUCT_NAME ."<a/>.";
$GLOBALS['strAdminUrlPrefix'] = "URL interfejsu administratora";
$GLOBALS['strDeliveryUrlPrefix'] = "URL serwera";
$GLOBALS['strDeliveryUrlPrefixSSL'] = "URL serwera (SSL)";
$GLOBALS['strImagesUrlPrefix'] = "URL pamięci plików graficznych";
$GLOBALS['strImagesUrlPrefixSSL'] = "URL pamięci plików graficznych (SSL)";
$GLOBALS['strUnableToWriteConfig'] = "Nie można wprowadzić zmian w pliku config";
$GLOBALS['strUnableToWritePrefs'] = "Nie można wprowadzić preferencji w bazie danych";
$GLOBALS['strImageDirLockedDetected'] = "Wskazany <b>Folder Obrazów</b> nie jest otwarty do edycji. <b>Zmień uprawnienia w folderze lub utwórz folder, aby kontynuować.";
$GLOBALS['strConfigurationSetup'] = "Lista sprawdzająca konfiguracji";
$GLOBALS['strConfigurationSettings'] = "Ustawienia konfiguracji";
$GLOBALS['strAdminPassword'] = "Hasło Administratora";
$GLOBALS['strAdministratorEmail'] = "E-mail Administratora";
$GLOBALS['strTimezone'] = "Strefa czasowa";
$GLOBALS['strTimezoneEstimated'] = "Szacowana strefa czasowa";
$GLOBALS['strTimezoneGuessedValue'] = "Strefa czasowa serwera jest niepoprawnie skonfigurowana w PHP";
$GLOBALS['strTimezoneSeeDocs'] = "Sprawdź %DOCS% odnośnie ustwień tej zmiennej w PHP.";
$GLOBALS['strTimezoneDocumentation'] = "dokumentacja";
$GLOBALS['strLoginSettingsTitle'] = "Login Administratora";
$GLOBALS['strLoginSettingsIntro'] = "Zaloguj się jako administrator ". MAX_PRODUCT_NAME .", aby kontynuować proces aktualizacji. Do ukończenia aktualizacji wymagany jest login administratora.";
$GLOBALS['strAdminSettingsTitle'] = "Utwórz konto administratora";
$GLOBALS['strAdminSettingsIntro'] = "Wypełnij formularz, aby utworzyć konto administratora serwera.";
$GLOBALS['strConfigSettingsIntro'] = "Proszę sprawdzić ustawienia konfiguracji poniżej oraz wprowadzić wymagane zmiany przed przejściem dalej. Jeśli nie jesteś pewny, pozostaw wartości domyślne.";
$GLOBALS['strEnableAutoMaintenance'] = "Jeśli nie ustawiono konserwacji, przeprowadź ją automatycznie w trakcie dostarczania";
$GLOBALS['strOpenadsUsername'] = "Nazwa użytkownika ". MAX_PRODUCT_NAME ."";
$GLOBALS['strOpenadsPassword'] = "Hasło ". MAX_PRODUCT_NAME ."";
$GLOBALS['strOpenadsEmail'] = "E-mail ". MAX_PRODUCT_NAME ."";
$GLOBALS['strDbType'] = "Typ bazy danych";
$GLOBALS['strDemoDataInstall'] = "Zainstaluj dane przykładowe";
$GLOBALS['strDemoDataIntro'] = "Możesz załadować domyślne dane konfiguracyjne do ". MAX_PRODUCT_NAME .", aby ułatwić sobie start w obsłudze reklam online. Najpopularniejsze typy banerów czy pewne kampanie początkowe można załadować z podstawową konfiguracją. Zalecamy, aby postąpili tak użytkownicy, dla których jest to pierwsza instalacja.";
$GLOBALS['strDebug'] = "Ustawienia protokołowania diagnostycznego";
$GLOBALS['strProduction'] = "Serwer działający";
$GLOBALS['strEnableDebug'] = "Włącz protokołowanie diagnostyczne";
$GLOBALS['strDebugMethodNames'] = "Uwzględnij nazwę metody w protokole diagnostycznym";
$GLOBALS['strDebugLineNumbers'] = "Uwzględnij numer linii w protokole diagnostycznym";
$GLOBALS['strDebugType'] = "Typ protokołu diagnostycznego";
$GLOBALS['strDebugTypeFile'] = "Plik";
$GLOBALS['strDebugTypeMcal'] = "mCal";
$GLOBALS['strDebugTypeSql'] = "Baza danych SQL";
$GLOBALS['strDebugTypeSyslog'] = "Syslog";
$GLOBALS['strDebugName'] = "Nazwa protokołu diagnostycznego, kalendarz, tabela SQL, <br />lub urządzenie Syslog";
$GLOBALS['strDebugPriority'] = "Poziom priorytetu diagnozowania";
$GLOBALS['strPEAR_LOG_DEBUG'] = "PEAR_LOG_DEBUG - Pełne dane";
$GLOBALS['strPEAR_LOG_INFO'] = "PEAR_LOG_INFO - Dane standardowe";
$GLOBALS['strPEAR_LOG_NOTICE'] = "PEAR_LOG_NOTICE - Wskazówki ogólne";
$GLOBALS['strPEAR_LOG_WARNING'] = "PEAR_LOG_WARNING - Ostrzeżenie";
$GLOBALS['strPEAR_LOG_ERR'] = "PEAR_LOG_ERR - Błędy proste";
$GLOBALS['strPEAR_LOG_CRIT'] = "PEAR_LOG_CRIT - Błędy poważne";
$GLOBALS['strPEAR_LOG_ALERT'] = "PEAR_LOG_ALERT - Błędy krytyczne";
$GLOBALS['strPEAR_LOG_EMERG'] = "PEAR_LOG_EMERG - Dane minimalne";
$GLOBALS['strDebugIdent'] = "Popraw ścieżkę identyfikacyjną";
$GLOBALS['strDebugUsername'] = "Nazwa użytkownika serwera mCal, SQL";
$GLOBALS['strDebugPassword'] = "Hasło serwera mCal, SQL";
$GLOBALS['strWebPath'] = "Ścieżka dostępu serwera ". MAX_PRODUCT_NAME ."";
$GLOBALS['strWebPathSimple'] = "Ścieżka strony";
$GLOBALS['strDeliveryPath'] = "Ścieżka dostarczania";
$GLOBALS['strImagePath'] = "Ścieżka obrazów";
$GLOBALS['strDeliverySslPath'] = "SSL - Ścieżka dostarczania";
$GLOBALS['strImageSslPath'] = "SSL - Ścieżka obrazów";
$GLOBALS['strImageStore'] = "Folder obrazów";
$GLOBALS['strTypeFTPPassive'] = "Używaj pasywnego FTP";
$GLOBALS['strDeliveryFilenames'] = "Nazwy plików przychodzących";
$GLOBALS['strDeliveryFilenamesAdClick'] = "Kliknięcie";
$GLOBALS['strDeliveryFilenamesAdConversionVars'] = "Zmienne konwersji";
$GLOBALS['strDeliveryFilenamesAdContent'] = "Zawartość reklamy";
$GLOBALS['strDeliveryFilenamesAdConversion'] = "Konwersja";
$GLOBALS['strDeliveryFilenamesAdConversionJS'] = "Konwersja (JavaScript)";
$GLOBALS['strDeliveryFilenamesAdFrame'] = "Ramka (frame) reklamy";
$GLOBALS['strDeliveryFilenamesAdImage'] = "Obraz reklamy";
$GLOBALS['strDeliveryFilenamesAdJS'] = "Reklama (JavaScript)";
$GLOBALS['strDeliveryFilenamesAdLayer'] = "Warstwa reklamy";
$GLOBALS['strDeliveryFilenamesAdLog'] = "Log reklamy";
$GLOBALS['strDeliveryFilenamesAdPopup'] = "Reklama typu Popup";
$GLOBALS['strDeliveryFilenamesAdView'] = "Wyświetlenie reklamy";
$GLOBALS['strDeliveryFilenamesXMLRPC'] = "Kod wywołujący XML RPC";
$GLOBALS['strDeliveryFilenamesLocal'] = "Lokalny kod wywołujący";
$GLOBALS['strDeliveryFilenamesFrontController'] = "Sterownik główny";
$GLOBALS['strDeliveryFilenamesFlash'] = "Animacja Flash (może być pełny URL)";
$GLOBALS['strDeliveryCaching'] = "Ustawienia cache banerów";
$GLOBALS['strDeliveryCacheLimit'] = "Okres czasu pomiędzy aktualizacjami cache banerów (w sekundach)";
$GLOBALS['strOrigin'] = "Użyj zdalnego serwera głównego";
$GLOBALS['strOriginType'] = "Typ serwera głównego";
$GLOBALS['strOriginHost'] = "Nazwa serwera głównego";
$GLOBALS['strOriginPort'] = "Numer portu głównej bazy danych";
$GLOBALS['strOriginScript'] = "Plik skryptowy głównej bazy danych";
$GLOBALS['strOriginTypeXMLRPC'] = "XMLRPC";
$GLOBALS['strOriginTimeout'] = "Czas oczekiwania (w sekundach)";
$GLOBALS['strOriginProtocol'] = "Protokół serwera głównego";
$GLOBALS['strDeliveryAcls'] = "Ewaluacja limitów dostarczania banerów w trakcie ich dostarczania";
$GLOBALS['strDeliveryObfuscate'] = "Ukryj kanał podczas dostarczania reklam";
$GLOBALS['strDeliveryExecPhp'] = "Zezwól na wykonywanie kodu PHP w reklamach <br /> (UWAGA: Obniża poziom bezpieczeństwa)";
$GLOBALS['strDeliveryCtDelimiter'] = "Ogranicznik śledzenia kliknięć strony trzeciej";
$GLOBALS['uiEnabled'] = "Interfejs użytkownika aktywny";
$GLOBALS['strGeotargetingSettings'] = "Geotargeting";
$GLOBALS['strGeotargetingType'] = "Typ modułu Geotargetingu";
$GLOBALS['strGeotargetingGeoipCountryLocation'] = "Lokalizacja Bazy Danych Państw MaxMind GeoIP";
$GLOBALS['strGeotargetingGeoipRegionLocation'] = "Lokalizacja Bazy Danych Regionów MaxMind GeoIP";
$GLOBALS['strGeotargetingGeoipCityLocation'] = "Lokalizacja Bazy Danych Miast MaxMind GeoIP";
$GLOBALS['strGeotargetingGeoipAreaLocation'] = "Lokalizacja Bazy Danych Obszaru MaxMind GeoIP";
$GLOBALS['strGeotargetingGeoipDmaLocation'] = "Lokalizacja Bazy Danych DMA MaxMind GeoIP";
$GLOBALS['strGeotargetingGeoipOrgLocation'] = "Lokalizacja Bazy Danych Organizacji MaxMind GeoIP";
$GLOBALS['strGeotargetingGeoipIspLocation'] = "Lokalizacja Bazy Danych ISP MaxMind GeoIP";
$GLOBALS['strGeotargetingGeoipNetspeedLocation'] = "Lokalizacja Bazy Danych Netspeed MaxMind GeoIP";
$GLOBALS['strGeoSaveStats'] = "Zachowaj dane GeoIP w logu bazy danych";
$GLOBALS['strGeoShowUnavailable'] = "Pokaż limity geotargetingu, nawet jeśli dane GeoIP nie są dostępne";
$GLOBALS['strGeotrackingGeoipCountryLocationError'] = "We wskazanej lokalizacji nie znaleziono Bazy Danych Państw MaxMind GeoIP";
$GLOBALS['strGeotrackingGeoipRegionLocationError'] = "We wskazanej lokalizacji nie znaleziono Bazy Danych Regionów MaxMind GeoIP";
$GLOBALS['strGeotrackingGeoipCityLocationError'] = "We wskazanej lokalizacji nie znaleziono Bazy Danych Miast MaxMind GeoIP";
$GLOBALS['strGeotrackingGeoipAreaLocationError'] = "We wskazanej lokalizacji nie znaleziono Bazy Danych Obszaru MaxMind GeoIP";
$GLOBALS['strGeotrackingGeoipDmaLocationError'] = "We wskazanej lokalizacji nie znaleziono Bazy Danych MaxMind GeoIP DMA";
$GLOBALS['strGeotrackingGeoipOrgLocationError'] = "We wskazanej lokalizacji nie znaleziono Bazy Danych Organizacji MaxMind GeoIP";
$GLOBALS['strGeotrackingGeoipIspLocationError'] = "We wskazanej lokalizacji nie znaleziono Bazy Danych ISP MaxMind GeoIP";
$GLOBALS['strGeotrackingGeoipNetspeedLocationError'] = "We wskazanej lokalizacji nie znaleziono Bazy Danych Netspeed MaxMind GeoIP";
$GLOBALS['strGUIAnonymousCampaignsByDefault'] = "Ustawienie domyślne Kampanii na anonimowe";
$GLOBALS['strPublisherDefaults'] = "Domyślne ustawienia strony";
$GLOBALS['strModesOfPayment'] = "Metody płatności";
$GLOBALS['strCurrencies'] = "Waluta";
$GLOBALS['strCategories'] = "Kategorie";
$GLOBALS['strHelpFiles'] = "Pliki pomocy";
$GLOBALS['strDefaultApproved'] = "Zatwierdzone - okienko do odznaczenia";
$GLOBALS['strEnable3rdPartyTrackingByDefault'] = "Niezależne śledzenie kliknięć jako ustawienie domyślne";
$GLOBALS['strCsvImport'] = "Zezwalaj na wysyłanie konwersji offline";
$GLOBALS['strLogAdRequests'] = "Protokołuj żądanie przy każdym żądaniu banera";
$GLOBALS['strLogAdImpressions'] = "Protokołuj odsłonę przy każdym wyświetlonym banerze";
$GLOBALS['strLogAdClicks'] = "Protokołuj kliknięcie za każdym razem, gdy odwiedzający klika na baner";
$GLOBALS['strLogTrackerImpressions'] = "Loguj odsłonę tackera każdorazowo, gdy wyświetlany jest sygnał trackera";
$GLOBALS['strPreventLogging'] = "Zablokuj ustawienia protokołowania banerów";
$GLOBALS['strBlockAdViews'] = "Nie zliczaj Odsłon, jeśli odwiedzający widział tę samą parę reklama/strefa w ciągu określonego okresu czasu (w sekundach)";
$GLOBALS['strBlockAdViewsError'] = "Wartość blokowania Odsłon musi być dodatnią liczbą całkowitą";
$GLOBALS['strBlockAdClicks'] = "Nie zliczaj Kliknięć, jeśli odwiedzający kliknął tę samą parę reklama/strefa w ciągu określonego okresu czasu (w sekundach)";
$GLOBALS['strBlockAdClicksError'] = "Wartość blokowania Kliknięć musi być dodatnią liczbą całkowitą";
$GLOBALS['strMaintenanceOI'] = "Odstęp między przeprowadzaniem konserwacji (w minutach)";
$GLOBALS['strMaintenanceOIError'] = "Odstęp między przeprowadzaniem konserwacji jest nieprawidłowo określony - definicję prawidłowych wartości znajdziesz w dokumentacji";
$GLOBALS['strPrioritySettings'] = "Ustawienia priorytetów";
$GLOBALS['strPriorityInstantUpdate'] = "Aktualizuj priorytety reklamy natychmiast po modyfikacjach w interfejsie";
$GLOBALS['strDefaultImpConWindow'] = "Domyślny okres walidacji Odsłony (w sekundach)";
$GLOBALS['strDefaultImpConWindowError'] = "Domyślny okres walidacji Odsłony musi być dodatnią liczbą całkowitą";
$GLOBALS['strDefaultCliConWindow'] = "Domyślny okres walidacji Kliknięcia (w sekundach)";
$GLOBALS['strDefaultCliConWindowError'] = "Domyślny okres walidacji Kliknięcia musi być dodatnią liczbą całkowitą";
$GLOBALS['strWarnLimitDays'] = "Wyślij ostrzeżenie, gdy ilość dni jest mniejsza niż ta określona tutaj";
$GLOBALS['strWarnLimitDaysErr'] = "Ostrzeżenie: Limit dni powinien być liczbą dodatnią";
$GLOBALS['strWarnAgency'] = "Wyślij ostrzeżenie do agencji zawsze, gdy kampania dobiega końca";
$GLOBALS['strEnableQmailPatch'] = "Włącz łatkę qmail";
$GLOBALS['strMyHeaderError'] = "Plik nagłówka nie istnieje w podanej lokalizacji";
$GLOBALS['strMyFooterError'] = "Plik stopki nie istnieje w podanej lokalizacji";
$GLOBALS['strDefaultTrackerStatus'] = "Domyślny status trackera";
$GLOBALS['strDefaultTrackerType'] = "Domyślny typ trackera";
$GLOBALS['strMyLogo'] = "Nazwa pliku logo";
$GLOBALS['strMyLogoError'] = "Plik logo nie istnieje w katalogu admin/images";
$GLOBALS['strGuiHeaderForegroundColor'] = "Kolor planu pierwszego w nagłówku";
$GLOBALS['strGuiHeaderBackgroundColor'] = "Kolor tła nagłówka";
$GLOBALS['strGuiActiveTabColor'] = "Kolor aktywnej zakładki";
$GLOBALS['strGuiHeaderTextColor'] = "Kolor tekstu w nagłówku";
$GLOBALS['strColorError'] = "Wpisz kolory w formacie RGB, np.'0066CC'";
$GLOBALS['strReportsInterface'] = "Interfejs raportów";
$GLOBALS['strPublisherInterface'] = "Interfejs Strony";
$GLOBALS['strPublisherAgreementEnabled'] = "Kontrola loginu dla Stron, które nie zaakceptowały Warunków Serwisu";
$GLOBALS['strPublisherAgreementText'] = "Tekst loginu (dopuszczalne znaczniki HTML)";
$GLOBALS['strNovice'] = "Usuwanie wymaga potwierdzenia ze względu na bezpieczeństwo";
$GLOBALS['strEmailSettings'] = "Ustawienia e-maila";
$GLOBALS['strEmailHeader'] = "Nagłówki e-mail";
$GLOBALS['strEmailLog'] = "Log e-maila";
$GLOBALS['strAuditTrailSettings'] = "Ustawienia Audytu";
$GLOBALS['strEnableAudit'] = "Włącz Audyt";
$GLOBALS['strTypeFTPErrorNoSupport'] = "Zainstalowana wersja PHP nie obsługuje FTP.";
$GLOBALS['strGeotargetingUseBundledCountryDb'] = "Użyj bazy MaxMind GeoLiteCountry";
$GLOBALS['strConfirmationUI'] = "Potwierdzenie w interfejsie użytkownika";
$GLOBALS['strBannerStorage'] = "Ustawienia przechowywania banerów";
$GLOBALS['strMaintenanceSettings'] = "Ustawienia konserwacji";
$GLOBALS['strSSLSettings'] = "Ustawienia SSL";
$GLOBALS['requireSSL'] = "Wymuś dostęp SSL w interfejsie użytkownika";
$GLOBALS['sslPort'] = "Port SSL używany przez serwer WWW";
$GLOBALS['strAlreadyInstalled'] = "". MAX_PRODUCT_NAME ." został juz zainstalowany. Jeśli chcesz go skonfigurować przejdź do <a href='account-index.php'>menadżera ustawień</a>.";
$GLOBALS['strAllowEmail'] = "Ogólne zezwolenie na wysyłanie e-maili";
$GLOBALS['strEmailAddressFrom'] = "Adres e-mail, z którego wysyłane są raporty";
$GLOBALS['strEmailAddressName'] = "Nazwa firmy lub osoby, która figuruje w syganturze wiadomości";
$GLOBALS['strInvocationDefaults'] = "Domyślne ustawienia kodu wywołującego";
$GLOBALS['strDbSocket'] = "Port bazy danych";
$GLOBALS['strEmailAddresses'] = "Wyślij \"Od\" - adres e-mail";
$GLOBALS['strEmailFromName'] = "Wyślij \"Od\" - nazwa";
$GLOBALS['strEmailFromAddress'] = "Wyślij \"Od\" - adres e-mail";
$GLOBALS['strEmailFromCompany'] = "Wyślij \"Od\" - firma";
$GLOBALS['strIgnoreUserAgents'] = "<b>Nie</b> loguj statystyk dla klientów, których aplikacja kliencka zawiera jeden z następujących ciągów (po jednym w rubryce)";
$GLOBALS['strEnforceUserAgents'] = "<b>Loguj wyłącznie</b> statystyki dla klientów, których aplikacja kliencka zawiera jeden z następujących ciągów (po jednym w rubryce)";
$GLOBALS['strConversionTracking'] = "Ustawienia śledzenia konwersji";
$GLOBALS['strEnableConversionTracking'] = "Uruchom śledzenie konwersji";
$GLOBALS['strDbNameHint'] = "Baza danych zostanie utworzona, jeżeli nie istnieje";
$GLOBALS['strProductionSystem'] = "System produkcji";
$GLOBALS['strTypeFTPErrorUpload'] = "Nie można przesłać pliku na serwer FTP, sprawdź ustawienia uprawnień hosta";
$GLOBALS['strBannerLogging'] = "Ustawienia protokołowania banerów";
$GLOBALS['strBannerDelivery'] = "Ustawienia dostarczania banerów";
$GLOBALS['strDashboardSettings'] = "Ustawienia Panelu Nawigacyjnego";
$GLOBALS['strErrorFixPermissionsRCommand'] = "<i>chmod -R a+w %s</i>";
$GLOBALS['strGlobalDefaultBannerUrl'] = "Ogólny domyślny URL banera obrazu";
$GLOBALS['strCantConnectToDbDelivery'] = "Nie można połączyć z bazą danych dostarczania";
$GLOBALS['strDefaultConversionStatus'] = "Domyślny status konwersji";
$GLOBALS['strDefaultConversionType'] = "Domyślny typ konwersji";
?>