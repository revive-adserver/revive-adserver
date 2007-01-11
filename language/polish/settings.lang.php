<?php // $Revision$

/************************************************************************/
/* Openads 2.0                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2000-2007 by the Openads developers                    */
/* For more information visit: http://www.openads.org                   */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/



// Installer translation strings
$GLOBALS['strInstall']				= "Instalacja";
$GLOBALS['strChooseInstallLanguage']		= "Wybierz jêzyk dla procedury instalacji";
$GLOBALS['strLanguageSelection']		= "Wybór Jêzyka";
$GLOBALS['strDatabaseSettings']			= "Ustawienia Bazy Danych";
$GLOBALS['strAdminSettings']			= "Ustawienia Administratora";
$GLOBALS['strAdvancedSettings']			= "Ustawienia Zaawansowane";
$GLOBALS['strOtherSettings']			= "Inne Ustawienia";

$GLOBALS['strWarning']				= "Uwaga";
$GLOBALS['strFatalError']			= "Wyst±pi³ b³ad krytyczny";
$GLOBALS['strUpdateError']			= "Wyst±pi³ b³±d podczas aktualizacji";
$GLOBALS['strUpdateDatabaseError']		= "Z nieznanych powodów aktualizacja struktury bazy danych nie powiod³a siê. Rekomendowan± drog± postêpowania w tej sytuacji jest klikniêcie <b>Ponowna aktualizacja</b> aby spróbowaæ naprawiæ potencjalne problemy. Je¶li jeste¶ pewien, ¿e b³êdy nie bêd± mia³y wp³ywu na funkcjonowanie  ".$phpAds_productname." mo¿esz klikn±æ <b>Zignoruj b³êdy</b> aby kontynuowaæ. Zignorowanie tych b³êdów mo¿e byæ przyczyn± powa¿nych problemów i nie jest polecane!";
$GLOBALS['strAlreadyInstalled']			= $phpAds_productname." jest ju¿ zainstalowany na tym systemie. Je¶li chcesz go skonfigurowaæ, id¼ do <a href='settings-index.php'>czê¶ci ustawieñ</a>";
$GLOBALS['strCouldNotConnectToDB']		= "Po³±czenie z baz± danych nie by³o mo¿liwe, sprawd¼ poprawno¶æ wpisanych danych";
$GLOBALS['strCreateTableTestFailed']		= "U¿ytkownik, którego poda³e¶ nie ma uprawnieñ do tworzenia lub zmiany tabel w bazie danych, skontaktuj siê z administratorem bazy danych.";
$GLOBALS['strUpdateTableTestFailed']		= "U¿ytkownik, którego poda³e¶ nie ma uprawnieñ do zmiany struktury bazy danych, skontaktuj siê z administratorem bazy danych.";
$GLOBALS['strTablePrefixInvalid']		= "Prefiks tabeli zawiera nieprawid³owe znaki";
$GLOBALS['strTableInUse']			= "Baza danych, któr± poda³e¶ jest ju¿ u¿ywana przez ".$phpAds_productname.", podaj inny prefiks tabeli lub przeczytaj w dokumentacji instrukcje dotycz±ce aktualizacji.";
$GLOBALS['strTableWrongType']			= "Wybrany przez ciebie typ tabeli nie jest obs³ugiwany przez twoj± instalacjê ".$phpAds_dbmsname;
$GLOBALS['strMayNotFunction']			= "Przed kontynuacj± popraw te potencjalne problemy:";
$GLOBALS['strFixProblemsBefore']		= "Poni¿sze elementy musz± zostaæ skorygowane zanim bêdziesz móg³ zainstalowaæ ".$phpAds_productname.". Je¶li masz pytania dotycz±ce tej informacji o b³êdzie przeczytaj <i>Podrêcznik administratora</i>, który jest czê¶ci± ¶ci±gnietego przez ciebie pakietu.";
$GLOBALS['strFixProblemsAfter']			= "Je¶li nie jeste¶ w stanie skorygowaæ podanych problemów, skontaktuj siê z administratorem serwera, na którym chcesz zainstalowaæ ".$phpAds_productname.". Mo¿e on udzieliæ ci w tej kwestii pomocy.";
$GLOBALS['strIgnoreWarnings']			= "Ignoruj ostrze¿enia";
$GLOBALS['strWarningDBavailable']		= "Wersja PHP, której u¿ywasz nie ma mo¿liwo¶ci korzystania z serwera baz danych ".$phpAds_dbmsname.". Musisz w³±czyæ rozszerzenie PHP ".$phpAds_dbmsname." zanim bêdziesz móg³ kontynuowaæ.";
$GLOBALS['strWarningPHPversion']		= $phpAds_productname." wymaga PHP 4.0 lub nowszego do poprawnego funkcjonowania. Na serwerze jest obecnie {php_version}.";
$GLOBALS['strWarningRegisterGlobals']		= "Opcja konfiguracyjna PHP register_globals musi byæ w³±czona.";
$GLOBALS['strWarningMagicQuotesGPC']		= "Opcja konfiguracyjna PHP magic_quotes_gpc musi byæ w³±czona.";
$GLOBALS['strWarningMagicQuotesRuntime']	= "Opcja konfiguracyjna PHP magic_quotes_runtime musi byæ wy³±czona.";
$GLOBALS['strWarningFileUploads']		= "Opcja konfiguracyjna PHP file_uploads musi byæ w³±czona.";
$GLOBALS['strWarningTrackVars']			= "Opcja konfiguracyjna PHP variable track_vars musi byæ w³±czona.";
$GLOBALS['strWarningPREG']			= "Wersja PHP, której u¿ywasz nie posiada obs³ugi wyra¿eñ regularnych w formacie PERL'a. Musisz w³±czyæ rozszerzenie PREG zanim bêdziesz móg³ przej¶æ dalej.";
$GLOBALS['strConfigLockedDetected']		= $phpAds_productname." wykry³o, ¿e twój plik <b>config.inc.php</b> nie mo¿e byæ modyfikowany przez server. Kontynuacja nie bêdzie mo¿liwa zanim nie zmienisz uprawnieñ dla tego pliku. Przeczytaj do³±czon± dokumentacjê, je¶li nie wiesz jak to zrobiæ.";
$GLOBALS['strCantUpdateDB']  			= "Aktualizacja bazy danych nie jest w tej chwili mo¿liwa. Je¶li zdecydujesz siê kontynuowaæ, wszystkie istniej±ce bannery, statystyki i reklamodawcy zostan± usuniêci.";
$GLOBALS['strIgnoreErrors']			= "Zignoruj b³êdy";
$GLOBALS['strRetryUpdate']			= "Ponowna aktualizacja";
$GLOBALS['strTableNames']			= "Nazwy Tabeli";
$GLOBALS['strTablesPrefix']			= "Prefiks nazw tabeli";
$GLOBALS['strTablesType']			= "Typ tabeli";

$GLOBALS['strInstallWelcome']			= "Witamy w ".$phpAds_productname;
$GLOBALS['strInstallMessage']			= "Zanim mo¿esz zacz±æ u¿ywaæ ".$phpAds_productname." musi on zostaæ skonfigurowany i <br> utworzona zostaæ baza danych. Kliknij <b>Dalej</b> aby kontynuowaæ.";
$GLOBALS['strInstallSuccess']			= "<bProcedura instalacji ".$phpAds_productname." zosta³a zakoñczona.</b><br><br>Aby zapewniæ prawid³owe funkcjonowanie ".$phpAds_productname." musisz tak¿e
						   zapewniæ codzienne uruchamianie pliku utrzymania. Wiêcej informacji na ten temat znajdziesz w dokumentacji.
						   <br><br>Kliknij <b>Dalej</b> aby przej¶æ do czê¶ci konfiguracyjnej, gdzie mo¿esz 
						   zmieniæ inne ustawienia. Nie zapomnij tak¿e zablokowaæ pliku config.inc.php po zakoñczeniu konfiguracji aby zapobiec
						   naruszeniu bezpieczeñstwa.";
$GLOBALS['strUpdateSuccess']			= "<b>Aktualizacja ".$phpAds_productname." zakoñczy³a siê pomy¶lnie.</b><br><br>Aby zapewniæ prawid³owe funkcjonowanie ".$phpAds_productname." musisz tak¿e
						   zapewniæ uruchamianie pliku utrzymania co godzinê (przedtem wystarczy³o raz dziennie). Wiêcej informacji na ten temat znajdziesz w dokumentacji.
						   <br><br>Kliknij <b>Dalej</b> aby przej¶æ do interfejsu administracyjnego. Nie zapomnij tak¿e zablokowaæ pliku config.inc.php 
						   aby zapobiec naruszeniu bezpieczeñstwa.";
$GLOBALS['strInstallNotSuccessful']		= "<b>Instalacja ".$phpAds_productname." nie powiod³a siê</b><br><br>Niektóre czê¶ci procesu instalacyjnego nie zosta³y zakoñczone.
						   Mo¿liwe, ¿e te problemy s± jedynie przej¶ciowe, w takim wypadku mo¿esz po prostu klikn±æ <b>Dalej</b> i powróciæ do 
						   pierwszego kroku instalacji. Je¶li chcesz dowiedzieæ siê wiêcej o znaczeniu tego b³êdu i sposobach jego rozwi±zania, 
						   zajrzyj do do³±czonej dokumentacji.";
$GLOBALS['strErrorOccured']			= "Wyst±pi³y nastêpuj±ce b³êdy:";
$GLOBALS['strErrorInstallDatabase']		= "Nie uda³o siê strowzyæ struktury bazy danych.";
$GLOBALS['strErrorInstallConfig']		= "Plik konfiguracyjny lub naza danych nie mog³y zostaæ zaktualizowane.";
$GLOBALS['strErrorInstallDbConnect']		= "Nie mo¿na by³o po³±czyæ siê z baz± danych.";

$GLOBALS['strUrlPrefix']			= "Prefiks adresu URL";

$GLOBALS['strProceed']				= "Dalej &gt;";
$GLOBALS['strInvalidUserPwd']			= "B³êdna nazwa u¿ytkownika lub has³o";

$GLOBALS['strUpgrade']				= "Aktualizacja";
$GLOBALS['strSystemUpToDate']			= "Twój system ma ju¿ zainstalowan± najnowsz± wersjê programu, aktualizacja nie jest potrzebna. <br>Kliknij <b>Dalej</b> aby przej¶æ na stronê g³ówn±.";
$GLOBALS['strSystemNeedsUpgrade']		= "Struktura bazy danych i plik konfiguracyjny musz± zostaæ zaktualizowane, aby zapewniæ prawid³owe funkcjonowanie systemu. Kliknij <b>Dalej</b> aby rozpocz±æ proces aktualizacji. <br><br>Zale¿nie od tego, z której wersji dokonywana jest aktualizacja i ile statystyk znajduje siê ju¿ w bazie danych, mo¿e to spowodowaæ znaczne obci±¿enie dla serwera. Przygotuj siê na to, ¿e aktualizacja mo¿e potrwaæ do kilkunastu minut.";
$GLOBALS['strSystemUpgradeBusy']		= "System w trakcie aktualizacji, proszê zaczekaæ...";
$GLOBALS['strSystemRebuildingCache']		= "Odbudowywanie cache'u, proszê zaczekaæ...";
$GLOBALS['strServiceUnavalable']		= "System jest obecnie niedostêpny. Trwa aktualizacja";

$GLOBALS['strConfigNotWritable']		= "Plik config.inc.php nie mo¿e zostaæ zmodyfikowany";





/*********************************************************/
/* Configuration translations                            */
/*********************************************************/

// Global
$GLOBALS['strChooseSection']			= "Wybierz Sekcjê";
$GLOBALS['strDayFullNames'] 			= array("Niedziela","Poniedzia³ek","Wtorek","¦roda","Czwartek","Pi±tek","Sobota");
$GLOBALS['strEditConfigNotPossible']    	= "Zmiana tych ustawieñ nie jest mo¿liwa, poniewa¿ plik konfiguracji jest zablokowany ze wzglêdów bezpieczeñstwa. ".
										  "Je¶li chcesz dokonaæ zmian, musisz najpierw odblokowaæ plik config.inc.php.";
$GLOBALS['strEditConfigPossible']		= "Edycja wszystkich ustawieñ jest mo¿liwa, poniewa¿ plik konfiguracyjny nie jest zablokowany, co mo¿e prowadziæ do zagro¿enia bezpieczeñstwa. ".
										  "Je¶li chcesz zabezpieczyæ swój system, zablokuj plik config.inc.php.";



// Database
$GLOBALS['strDatabaseSettings']			= "Ustawienia Bazy Danych";
$GLOBALS['strDatabaseServer']			= "Serwer Bazy Danych";
$GLOBALS['strDbLocal']				= "Po³±cz z lokalnym serwerem u¿ywaj±c sockets"; // Pg only
$GLOBALS['strDbHost']				= "Adres serwera";
$GLOBALS['strDbPort']				= "Numer portu bazy danych";
$GLOBALS['strDbUser']				= "Nazwa u¿ytkownika";
$GLOBALS['strDbPassword']			= "Has³o";
$GLOBALS['strDbName']				= "Nazwa bazy danych";

$GLOBALS['strDatabaseOptimalisations']		= "Optymalizacja Bazy Danych";
$GLOBALS['strPersistentConnections']		= "U¿yj sta³ych po³±czeñ";
$GLOBALS['strInsertDelayed']			= "U¿yj opó¼nionych wstawieñ";
$GLOBALS['strCompatibilityMode']		= "Tryb kompatybilno¶ci bazy danych";
$GLOBALS['strCantConnectToDb']			= "Nie mo¿na po³±czyæ z baz± danych";



// Invocation and Delivery
$GLOBALS['strInvocationAndDelivery']		= "Ustawienia Inwokacji i Dostarczania";

$GLOBALS['strAllowedInvocationTypes']		= "Dozwolone Typy Inwokacji";
$GLOBALS['strAllowRemoteInvocation']		= "Zezwól na zdaln± inwokacjê";
$GLOBALS['strAllowRemoteJavascript']		= "Zezwól na zdaln± inwokacjê z JavaScript";
$GLOBALS['strAllowRemoteFrames']		= "Zezwól na zdaln± inwokacjê z ramkani";
$GLOBALS['strAllowRemoteXMLRPC']		= "Zezwól na zdaln± inwokacjê z wykorzystaniem XML-RPC";
$GLOBALS['strAllowLocalmode']			= "Zezwól na tryb lokalny";
$GLOBALS['strAllowInterstitial']		= "Zezwól na Interstitials";
$GLOBALS['strAllowPopups']			= "Zezwól na Popups";

$GLOBALS['strUseAcl']				= "U¿yj ograniczeñ wy¶wietlania podczas dostarczania";

$GLOBALS['strDeliverySettings']			= "Ustawienia dostarczania";
$GLOBALS['strCacheType']			= "Typ cache'u dostarczania";
$GLOBALS['strCacheFiles']			= "Pliki";
$GLOBALS['strCacheDatabase']			= "Baza danych";
$GLOBALS['strCacheShmop']			= "Wspó³dzielona pamiêæ/Shmop";
$GLOBALS['strCacheSysvshm']			= "Wspó³dzielona pamiêæ/Sysvshm";
$GLOBALS['strExperimental']			= "Eksperymentalne";
$GLOBALS['strKeywordRetrieval']			= "S³owa Kluczowe";
$GLOBALS['strBannerRetrieval']			= "Metoda Doboru Bannerów";
$GLOBALS['strRetrieveRandom']			= "Losowy wybór (domy¶lnie)";
$GLOBALS['strRetrieveNormalSeq']		= "Normalny, sekwencyjny wybór";
$GLOBALS['strWeightSeq']			= "Sekwencyjny wybór w oparciu o wagê";
$GLOBALS['strFullSeq']				= "Pe³ny wybór sekwencyjny";
$GLOBALS['strUseConditionalKeys']		= "Zezwól na operatory logiczne przy bezpo¶rednim wyborze";
$GLOBALS['strUseMultipleKeys']			= "Zezwól na kilka s³ów kluczowych przy bezpo¶rednim wyborze";

$GLOBALS['strZonesSettings']			= "Wy¶wietlanie Stref";
$GLOBALS['strZoneCache']			= "Przechowuj strefy w cache'u, to powinno przy¶pieszyæ ich dzia³anie";
$GLOBALS['strZoneCacheLimit']			= "Czas miêdzy aktualizacjami cache'u (w sekundach)";
$GLOBALS['strZoneCacheLimitErr']		= "Czas miêdzy aktualizacjami powinien by¶ dodatni± liczb± ca³kowit±";

$GLOBALS['strP3PSettings']			= "Polityka Prywatno¶ci P3P";
$GLOBALS['strUseP3P']				= "U¿yj Deklaracji P3P";
$GLOBALS['strP3PCompactPolicy']			= "Skrócona Deklaracja P3P";
$GLOBALS['strP3PPolicyLocation']		= "Lokalizacja Deklaracji P3P";



// Banner Settings
$GLOBALS['strBannerSettings']			= "Ustawienia Bannerów";

$GLOBALS['strAllowedBannerTypes']		= "Dozwolone Typy Bannerów";
$GLOBALS['strTypeSqlAllow']			= "Zezwól na lokalne bannery (SQL)";
$GLOBALS['strTypeWebAllow']			= "Zezwól na lokalne bannery (Webserver)";
$GLOBALS['strTypeUrlAllow']			= "Zezwól na zewnêtrzne bannery";
$GLOBALS['strTypeHtmlAllow']			= "Zezwól na bannery HTML";
$GLOBALS['strTypeTxtAllow']			= "Zezwól na odno¶niki tekstowe";

$GLOBALS['strTypeWebSettings']			= "Konfiguracja Lokalnych Bannerów (Webserver)";
$GLOBALS['strTypeWebMode']			= "Metoda przechowywania";
$GLOBALS['strTypeWebModeLocal']			= "Lokalny katalog";
$GLOBALS['strTypeWebModeFtp']			= "Zewnêtrzny server FTP";
$GLOBALS['strTypeWebDir']			= "Lokalny katalog";
$GLOBALS['strTypeWebFtp']			= "Tryb FTP webservera bannerów";
$GLOBALS['strTypeWebUrl']			= "Publiczny URL";
$GLOBALS['strTypeFTPHost']			= "Adres servera FTP";
$GLOBALS['strTypeFTPDirectory']			= "Katalog servera";
$GLOBALS['strTypeFTPUsername']			= "Login";
$GLOBALS['strTypeFTPPassword']			= "Has³o";
$GLOBALS['strTypeFTPErrorDir']			= "Podany katalog na serwerze nie istnieje";
$GLOBALS['strTypeFTPErrorConnect']		= "B³±d po³±czenia z serwerem FTP, login i has³o s± niepoprawne";
$GLOBALS['strTypeFTPErrorHost']			= "Nazwa hosta serwera FTP nie jest poprawna";
$GLOBALS['strTypeDirError']			= "Lokalny katalog nie istnieje";



$GLOBALS['strDefaultBanners']			= "Domy¶lne Bannery";
$GLOBALS['strDefaultBannerUrl']			= "Adres URL domy¶lnego bannera";
$GLOBALS['strDefaultBannerTarget']		= "Adres URL docelowy";

$GLOBALS['strTypeHtmlSettings']			= "Opcje bannera HTML";
$GLOBALS['strTypeHtmlAuto']			= "Automatycznie zmieniaj bannery HTML aby wymusiæ ¶ledzenie Klikniêæ";
$GLOBALS['strTypeHtmlPhp']			= "Zezwól na wykonywanie poleceñ PHP w bannerach HTML";



// Host information and Geotargeting
$GLOBALS['strHostAndGeo']			= "Informacje o serwerze i ¶ledzeniu geograficznym";

$GLOBALS['strRemoteHost']			= "Zdalny serwer";
$GLOBALS['strReverseLookup']			= "Spróbuj ustaliæ nazwê hosta odwiedzaj±cego, je¶li nie zosta³a podana przez serwer";
$GLOBALS['strProxyLookup']			= "Spróbuj ustaliæ prawdziwy adres IP odwiedzaj±cego, je¶li korzysta on z Proxy";

$GLOBALS['strGeotargeting']			= "Geotargeting";
$GLOBALS['strGeotrackingType']			= "Typ bazy danych ¶ledzenia geograficznego";
$GLOBALS['strGeotrackingLocation'] 		= "Lokalizacja bazy danych ¶ledzenia geograficznego";
$GLOBALS['strGeotrackingLocationError'] 	= "Baza danych ¶ledzenia geograficznego nie istnieje w podanej lokalizacji";
$GLOBALS['strGeoStoreCookie']			= "Zapisz wyniki w cookie dla pó¼niejszego wykorzystania";



// Statistics Settings
$GLOBALS['strStatisticsSettings']		= "Ustawienia Statystyk";

$GLOBALS['strStatisticsFormat']			= "Format Statystyk";
$GLOBALS['strCompactStats']			= "Format statystyk";
$GLOBALS['strLogAdviews']			= "Loguj Ods³onê przy ka¿dym dostarczeniu bannera";
$GLOBALS['strLogAdclicks']			= "Loguj Klikniêcie za ka¿dym razem gdy odwiedzaj±cy kliknie w banner";
$GLOBALS['strLogSource']			= "Loguj parametr ¼ród³a podany w inwokacji";
$GLOBALS['strGeoLogStats']			= "Loguj kraj odwiedzaj±cego w statystykach";
$GLOBALS['strLogHostnameOrIP']			= "Loguj nazwê hosta lub adres IP odwiedzaj±cego";
$GLOBALS['strLogIPOnly']			= "Loguj tylko adres IP dwiedzaj±cego, nawet je¶li nazwa hosta jest znana";
$GLOBALS['strLogIP']				= "Loguj adres IP odwiedzaj±cego";
$GLOBALS['strLogBeacon']			= "U¿ywaj ma³ego obrazka przy logowaniu Ods³on aby zapewniæ, ¿e tylko dostarczone bannery s± logowane";

$GLOBALS['strRemoteHosts']			= "Zdalne Hosty";
$GLOBALS['strIgnoreHosts']			= "Nie przechowuj statystyk dla odwiedzaj±cych u¿ywaj±cych jednego z poni¿szych adresów IP lub hostów";
$GLOBALS['strBlockAdviews']			= "Nie loguj Ods³on je¶li odwiedzaj±cy widzia³ ten sam banner w ci±gu podanego w sekundach czasu";
$GLOBALS['strBlockAdclicks']			= "Nie loguj Klikniêæ je¶li odwiedzaj±cy klikn±³ w banner w ci±gu podanego w sekundach czasu";


$GLOBALS['strEmailWarnings']			= "Ostrze¿enia Przez E-mail";
$GLOBALS['strAdminEmailHeaders']		= "Dodaj nastêpuj±cy nag³owek do wszystkich emaili wysy³anych przez ".$phpAds_productname;
$GLOBALS['strWarnLimit']			= "Wy¶lij ostrze¿enie kiedy liczba pozosta³ych ods³on spadnie poni¿ej podanej warto¶ci";
$GLOBALS['strWarnLimitErr']			= "Limit ostrze¿enia powinien byæ liczb± dodatni±";
$GLOBALS['strWarnAdmin']			= "Wy¶lij ostrze¿enie do administratora za ka¿dym razem kiedy kampania prawie wygasa";
$GLOBALS['strWarnClient']			= "Wy¶lij ostrze¿enie do reklamodawcy za ka¿dym razem kiedy kampania prawie wygasa";
$GLOBALS['strQmailPatch']			= "W³±cz ³atkê qmail'a";

$GLOBALS['strAutoCleanTables']			= "Automatycznie Czyszczenie Bazy Danych";
$GLOBALS['strAutoCleanStats']			= "Wyczy¶æ statystyki";
$GLOBALS['strAutoCleanUserlog']			= "Wyczy¶æ log u¿ytkownika";
$GLOBALS['strAutoCleanStatsWeeks']		= "Maksymalny wiek statystyk <br>(minimum 3 tygodnie)";
$GLOBALS['strAutoCleanUserlogWeeks']		= "Maksymalny wiek logu u¿ytkownika <br>(minimum 3 tygodnie)";
$GLOBALS['strAutoCleanErr']			= "Maksymalny wiek musi mieæ przynajmniej 3 tygodnie";
$GLOBALS['strAutoCleanVacuum']			= "ANALIZA VACUUM tabel co noc"; // only Pg



// Administrator settings
$GLOBALS['strAdministratorSettings']		= "Ustawienia Administratora";

$GLOBALS['strLoginCredentials']			= "Informacje Logowania";
$GLOBALS['strAdminUsername']			= "Nazwa u¿ytkownika Admina";
$GLOBALS['strInvalidUsername']			= "Nieprawid³owa nazwa u¿ytkownika";

$GLOBALS['strBasicInformation']			= "Podstawowe informacje";
$GLOBALS['strAdminFullName']			= "Imiê i nazwisko admina";
$GLOBALS['strAdminEmail']			= "Adres email admina";
$GLOBALS['strCompanyName']			= "Nazwa firmy";

$GLOBALS['strAdminCheckUpdates']		= "Sorawd¼ aktualizacje";
$GLOBALS['strAdminCheckEveryLogin']		= "Przy ka¿dym logowaniu";
$GLOBALS['strAdminCheckDaily']			= "Codziennie";
$GLOBALS['strAdminCheckWeekly']			= "Co tydzieñ";
$GLOBALS['strAdminCheckMonthly']		= "Co miesi±c";
$GLOBALS['strAdminCheckNever']			= "Nigdy";

$GLOBALS['strAdminNovice']			= "Dzia³ania administratora usuwaj±ce dane wymagaj± potwierdzenia dla bezpieczeñstwa";
$GLOBALS['strUserlogEmail']			= "Loguj wszystkie wychodz±ce wiadomo¶ci email";
$GLOBALS['strUserlogPriority']			= "Loguj godzinne kalkukacje priorytetów";
$GLOBALS['strUserlogAutoClean']			= "Loguj automatyczne czyszczenie bazy danych";


// User interface settings
$GLOBALS['strGuiSettings']			= "Konfiguracja Interfejsu U¿ytkownika";

$GLOBALS['strGeneralSettings']			= "Ogólne Ustawienia";
$GLOBALS['strAppName']				= "Nazwa programu";
$GLOBALS['strMyHeader']				= "Lokalizacja pliku nag³ówka";
$GLOBALS['strMyHeaderError']			= "Plik nag³ówka nie istnieje w podanej lokalizacji";
$GLOBALS['strMyFooter']				= "Lokalizacja pliku stopki";
$GLOBALS['strMyFooterError']			= "Plik stopki nie istnieje w podanej lokalizacji";
$GLOBALS['strGzipContentCompression']		= "U¿yj kompresji zawarto¶ci GZIP";

$GLOBALS['strClientInterface']			= "Interfejs Reklamodawcy";
$GLOBALS['strClientWelcomeEnabled']		= "W³±cz wiadomo¶ci powitalne dla reklamodawcy";
$GLOBALS['strClientWelcomeText']		= "Tekst powitalny<br>(znaczniki HTML dozwolone)";



// Interface defaults
$GLOBALS['strInterfaceDefaults']		= "Domy¶lne Ustawienia Interfejsu";

$GLOBALS['strInventory']			= "Administracja";
$GLOBALS['strShowCampaignInfo']			= "Poka¿ dodatkowe informacje o kampanii na stronie <i>Przegl±d Kampanii</i>";
$GLOBALS['strShowBannerInfo']			= "Poka¿ dodatkowe informacje o bannerze na stronie <i>Przegl±d Bannerów</i>";
$GLOBALS['strShowCampaignPreview']		= "Poka¿ podgl±d wszystkich bannerów na stronie <i>Przegl±d Bannerów</i>";
$GLOBALS['strShowBannerHTML']			= "Poka¿ w³a¶ciwy banner zamiast kodu HTML dla podgl±du bannerów HTML";
$GLOBALS['strShowBannerPreview']		= "Poka¿ podgl±d bannera na górze stron, które dotycz± bannerów";
$GLOBALS['strHideInactive']			= "Ukryj nieaktywne elementy ze wszystkich stron przegl±dowych";
$GLOBALS['strGUIShowMatchingBanners']		= "Poka¿ pasuj±ce bannery na stronach <i>Przy³±czony banner</i>";
$GLOBALS['strGUIShowParentCampaigns']		= "Poka¿ nadrzêdne kampanie na stronach <i>Przy³±czony banner</i>";
$GLOBALS['strGUILinkCompactLimit']		= "Hide non-linked campaigns or banners on the <i>Linked banner</i> pages when there are more than";

$GLOBALS['strStatisticsDefaults'] 		= "Statystyki";
$GLOBALS['strBeginOfWeek']			= "Pocz±tek tygodnia";
$GLOBALS['strPercentageDecimals']		= "Cyfr po przecinku";

$GLOBALS['strWeightDefaults']			= "Domy¶lne Wagi";
$GLOBALS['strDefaultBannerWeight']		= "Domy¶lna waga bannera";
$GLOBALS['strDefaultCampaignWeight']		= "Domy¶lna waga kampanii";
$GLOBALS['strDefaultBannerWErr']		= "Domy¶lna waga bannera powinna byæ dodatni± liczb± ca³kowit±";
$GLOBALS['strDefaultCampaignWErr']		= "Domy¶lna waga kampanii powinna byæ dodatni± liczb± ca³kowit±";



// Not used at the moment
$GLOBALS['strTableBorderColor']			= "Kolor Obramowania Tabeli";
$GLOBALS['strTableBackColor']			= "Kolor T³a Tabeli";
$GLOBALS['strTableBackColorAlt']		= "Kolor T³a Tabeli (Alternatywny)";
$GLOBALS['strMainBackColor']			= "G³ówny Kolor T³a";
$GLOBALS['strOverrideGD']			= "Zignoruj Format Grafiki GD";
$GLOBALS['strTimeZone']				= "Strefa Czasowa";

?>