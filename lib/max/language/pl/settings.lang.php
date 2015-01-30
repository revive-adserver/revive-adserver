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
$GLOBALS['strInstall'] = "Zainstaluj";
$GLOBALS['strDatabaseSettings'] = "Ustawienia Bazy Danych";
$GLOBALS['strAdminSettings'] = "Ustawienia Administratora";
$GLOBALS['strAdminAccount'] = "Konto Administratora";
$GLOBALS['strAdvancedSettings'] = "Ustawienia zaawansowane";
$GLOBALS['strWarning'] = "Uwaga";
$GLOBALS['strBtnContinue'] = "Dalej »";
$GLOBALS['strBtnRecover'] = "Odzyskaj »";
$GLOBALS['strBtnStartAgain'] = "Rozpocznij aktualizację od początku »";
$GLOBALS['strBtnGoBack'] = "« Wstecz";
$GLOBALS['strBtnAgree'] = "Wyrażam zgodę »";
$GLOBALS['strBtnDontAgree'] = "« Nie wyrażam zgody";
$GLOBALS['strBtnRetry'] = "Próbuj ponownie";
$GLOBALS['strWarningRegisterArgcArv'] = "Aby uruchomić działania konserwacyjne z polecenia należy włączyć zmienną konfiguracji PHP register_argc_argv.";
$GLOBALS['strTablesType'] = "Typ tabeli";


$GLOBALS['strRecoveryRequiredTitle'] = "W czasie poprzedniej próby aktualizacji wystąpiły błędy";
$GLOBALS['strRecoveryRequired'] = "Wystąpił błąd w trakcie przetwarzania poprzedniej próby aktualizacji. {$PRODUCT_NAME} spróbuje odzyskać dane z poprzedniej aktualizacji. Kliknij Odzyskaj poniżej.";

$GLOBALS['strOaUpToDate'] = "Twoja baza danych {$PRODUCT_NAME} oraz struktura pliku wskazuje, że korzystasz z najnowszej wersji i aktualizacja nie jest wymagana w tym momencie. Kliknij Dalej, aby przejść do panelu administratora {$PRODUCT_NAME}.";
$GLOBALS['strOaUpToDateCantRemove'] = "Ostrzeżenie: plik UPGRADE wciąż znajduje się w folderze var. Nie możemy go usunąć ze względu na ograniczone uprawnienia. Musisz usunąć plik własnoręcznie.";
$GLOBALS['strRemoveUpgradeFile'] = "Musisz usunąć plik UPGRADE z folderu var.";
$GLOBALS['strInstallSuccess'] = "Po kliknięciu 'Dalej' zostaniesz zalogowany do serwera. <p><strong>Co dalej?</strong></p> <div class='psub'> <p><b>Zarejestruj się, aby być na bieżąco z aktualizacjami produktu</b><br> <a href='{$PRODUCT_DOCSURL}/wizard/join' target='_blank'>Zapisz się na listę {$PRODUCT_NAME}</a> , aby otrzymywać  informacje na temat aktualizacji, alerty zabezpieczeń oraz nowości z zakresu produktu. </p> <p><b>Pierwsza kampania reklamowa</b><br> Nasz <a href='{$PRODUCT_DOCSURL}/wizard/qsg-firstcampaign' target='_blank'>przewodnik w pigułce pozwoli Ci sprawnie skonfigurować pierwszą kampanię</a>. </p> </div> <p><strong>Opcjonalne kroki podczas instalacji</strong></p> <div class='psub'> <p><b>Blokada plików konfiguracyjnych</b><br> Ten krok pozwala zabezpieczyć serwer przed wprowadzeniem niepożądanych zmian w jego konfiguracji. <a href='{$PRODUCT_DOCSURL}/wizard/lock-config' target='_blank'>Więcej na ten temat</a>. </p> <p><b>Ustawienie regularnej konserwacji</b><br> Zalecamy skrypt konserwacyjny, gdyż zapewnia on terminowe sporządzanie raportów oraz optymalną efektywność dostarczania. <a href='{$PRODUCT_DOCSURL}/wizard/setup-cron' target='_blank'>Więcej na ten temat</a> </p> <p><b>Sprawdzenie konfiguracji systemu</b><br> Zanim rozpoczniesz korzystanie z {$PRODUCT_NAME} zalecamy sprawdzenie ustawień w zakładce 'Ustawienia'. </p> </div>";
$GLOBALS['strInstallNotSuccessful'] = "<b>Instalacja {$PRODUCT_NAME} nie powiodła się</b><br /><br />Niektóre części procesu instalacyjnego nie zostały zakończone.
Możliwe, że te problemy są jedynie przejściowe, w takim wypadku możesz po prostu kliknąć <b>Dalej</b> i powrócić do
pierwszego kroku instalacji. Jeżeli chcesz dowiedzieć się więcej o znaczeniu tego błędu i sposobach jego rozwiązania,
zajrzyj do dołączonej dokumentacji.";
$GLOBALS['strDbSuccessIntro'] = "Baza danych {$PRODUCT_NAME} została utworzona. Kliknij 'Dalej', aby kontynuować konfigurację Administratora {$PRODUCT_NAME} oraz Ustawień Dostarczania.";
$GLOBALS['strDbSuccessIntroUpgrade'] = "Aktualizacja systemu zakończyła się pomyślnie. Pozostałe instrukcje pomogą Ci zaktualizować konfigurację Twojego nowego serwera do obsługi reklam.";
$GLOBALS['strErrorOccured'] = "Wystąpiły następujące błędy:";
$GLOBALS['strErrorInstallDatabase'] = "Nie udało się strowzyć struktury bazy danych.";
$GLOBALS['strErrorInstallDbConnect'] = "Nie można było połączyć się z bazą danych.";

$GLOBALS['strErrorWritePermissions'] = "Wykryto błędy w dostępie do pliku. Błędy muszą zostać naprawione zanim przejdziesz dalej.<br/>Aby naprawić błędy w systemie Linux, spróbuj wpisać następujące polecenie(a):";

$GLOBALS['strErrorWritePermissionsWin'] = "Wykryto błędy w dostępie do pliku. Błędy muszą zostać naprawione zanim przejdziesz dalej.";
$GLOBALS['strCheckDocumentation'] = "Więcej wskazówek uzyskasz w <a href='{$PRODUCT_DOCSURL}'>Dokumentacji {$PRODUCT_NAME}</a>.";

$GLOBALS['strAdminUrlPrefix'] = "URL interfejsu administratora";
$GLOBALS['strDeliveryUrlPrefix'] = "URL serwera";
$GLOBALS['strDeliveryUrlPrefixSSL'] = "URL serwera (SSL)";
$GLOBALS['strImagesUrlPrefix'] = "URL pamięci plików graficznych";
$GLOBALS['strImagesUrlPrefixSSL'] = "URL pamięci plików graficznych (SSL)";

$GLOBALS['strInvalidUserPwd'] = "Błędna nazwa użytkownika lub hasło";

$GLOBALS['strUpgrade'] = "Aktualizacja";
$GLOBALS['strSystemUpToDate'] = "Twój system ma już zainstalowaną najnowszą wersję programu, aktualizacja nie jest potrzebna. <br />Kliknij <b>Dalej</b> aby przejść na stronę główną.";
$GLOBALS['strSystemNeedsUpgrade'] = "Struktura bazy danych i plik konfiguracyjny muszą zostać zaktualizowane, aby zapewnić prawidłowe funkcjonowanie systemu. Kliknij <b>Dalej</b> aby rozpocząć proces aktualizacji. <br /><br />Zależnie od tego, z której wersji dokonywana jest aktualizacja i ile statystyk znajduje się już w bazie danych, może to spowodować znaczne obciążenie dla serwera. Przygotuj się na to, że aktualizacja może potrwać do kilkunastu minut.";
$GLOBALS['strSystemUpgradeBusy'] = "System w trakcie aktualizacji, proszę zaczekać...";
$GLOBALS['strSystemRebuildingCache'] = "Odbudowywanie cache'u, proszę zaczekać...";
$GLOBALS['strServiceUnavalable'] = "System jest obecnie niedostępny. Trwa aktualizacja";

/* ------------------------------------------------------- */
/* Configuration translations                            */
/* ------------------------------------------------------- */

// Global
$GLOBALS['strChooseSection'] = "Wybierz sekcję";
$GLOBALS['strEditConfigNotPossible'] = "It is not possible to edit all settings because the configuration file is locked for security reasons. " .
    "If you want to make changes, you may need to unlock the configuration file for this installation first.";
$GLOBALS['strEditConfigPossible'] = "It is possible to edit all settings because the configuration file is not locked, but this could lead to security issues. " .
    "If you want to secure your system, you need to lock the configuration file for this installation.";
$GLOBALS['strUnableToWriteConfig'] = "Nie można wprowadzić zmian w pliku config";
$GLOBALS['strUnableToWritePrefs'] = "Nie można wprowadzić preferencji w bazie danych";
$GLOBALS['strImageDirLockedDetected'] = "Wskazany <b>Folder Obrazów</b> nie jest otwarty do edycji. <b>Zmień uprawnienia w folderze lub utwórz folder, aby kontynuować.";

// Configuration Settings
$GLOBALS['strConfigurationSetup'] = "Lista sprawdzająca konfiguracji";
$GLOBALS['strConfigurationSettings'] = "Ustawienia konfiguracji";

// Administrator Settings
$GLOBALS['strAdministratorSettings'] = "Ustawienia Administratora";
$GLOBALS['strLoginCredentials'] = "Informacje logowania";
$GLOBALS['strAdminUsername'] = "Nazwa użytkownika Administratora";
$GLOBALS['strAdminPassword'] = "Hasło Administratora";
$GLOBALS['strInvalidUsername'] = "Nieprawidłowa nazwa użytkownika";
$GLOBALS['strBasicInformation'] = "Informacje podstawowe";
$GLOBALS['strAdminFullName'] = "Imię i nazwisko admina";
$GLOBALS['strAdminEmail'] = "E-mail admina";
$GLOBALS['strAdministratorEmail'] = "E-mail Administratora";
$GLOBALS['strCompanyName'] = "Nazwa firmy";
$GLOBALS['strAdminCheckUpdates'] = "Sorawdź aktualizacje";
$GLOBALS['strAdminCheckEveryLogin'] = "Przy każdym logowaniu";
$GLOBALS['strAdminCheckDaily'] = "Codziennie";
$GLOBALS['strAdminCheckWeekly'] = "Co tydzień";
$GLOBALS['strAdminCheckMonthly'] = "Co miesiąc";
$GLOBALS['strAdminCheckNever'] = "Nigdy";
$GLOBALS['strNovice'] = "Usuwanie wymaga potwierdzenia ze względu na bezpieczeństwo";
$GLOBALS['strUserlogEmail'] = "Loguj wszystkie wychodzące wiadomości e-mail";
$GLOBALS['strTimezone'] = "Strefa czasowa";
$GLOBALS['strTimezoneEstimated'] = "Szacowana strefa czasowa";
$GLOBALS['strTimezoneGuessedValue'] = "Strefa czasowa serwera jest niepoprawnie skonfigurowana w PHP";
$GLOBALS['strTimezoneSeeDocs'] = "Sprawdź %DOCS% odnośnie ustwień tej zmiennej w PHP.";
$GLOBALS['strTimezoneDocumentation'] = "dokumentacja";
$GLOBALS['strAdminSettingsTitle'] = "Utwórz konto administratora";
$GLOBALS['strAdminSettingsIntro'] = "Wypełnij formularz, aby utworzyć konto administratora serwera.";
$GLOBALS['strConfigSettingsIntro'] = "Proszę sprawdzić ustawienia konfiguracji poniżej oraz wprowadzić wymagane zmiany przed przejściem dalej. Jeśli nie jesteś pewny, pozostaw wartości domyślne.";

$GLOBALS['strEnableAutoMaintenance'] = "Jeśli nie ustawiono konserwacji, przeprowadź ją automatycznie w trakcie dostarczania";

// Database Settings
$GLOBALS['strDatabaseSettings'] = "Ustawienia Bazy Danych";
$GLOBALS['strDatabaseServer'] = "Ogólne ustawienia serwera bazy danych";
$GLOBALS['strDbLocal'] = "Użyj lokalnego połączenia z portem";
$GLOBALS['strDbType'] = "Typ bazy danych";
$GLOBALS['strDbHost'] = "Adres serwera";
$GLOBALS['strDbSocket'] = "Port bazy danych";
$GLOBALS['strDbPort'] = "Numer portu bazy danych";
$GLOBALS['strDbUser'] = "Nazwa użytkownika";
$GLOBALS['strDbPassword'] = "Hasło";
$GLOBALS['strDbName'] = "Nazwa bazy danych";
$GLOBALS['strDbNameHint'] = "Baza danych zostanie utworzona, jeżeli nie istnieje";
$GLOBALS['strDatabaseOptimalisations'] = "Optymalizacja bazy danych";
$GLOBALS['strPersistentConnections'] = "Użyj połączeń stałych";
$GLOBALS['strCantConnectToDb'] = "Nie można połączyć z bazą danych";
$GLOBALS['strCantConnectToDbDelivery'] = 'Nie można połączyć z bazą danych dostarczania';
$GLOBALS['strDemoDataInstall'] = "Zainstaluj dane przykładowe";
$GLOBALS['strDemoDataIntro'] = "Możesz załadować domyślne dane konfiguracyjne do {$PRODUCT_NAME}, aby ułatwić sobie start w obsłudze reklam online. Najpopularniejsze typy banerów czy pewne kampanie początkowe można załadować z podstawową konfiguracją. Zalecamy, aby postąpili tak użytkownicy, dla których jest to pierwsza instalacja.";



// Email Settings
$GLOBALS['strEmailSettings'] = "Ustawienia e-maila";
$GLOBALS['strEmailAddresses'] = "Wyślij \"Od\" - adres e-mail";
$GLOBALS['strEmailFromName'] = "Wyślij \"Od\" - nazwa";
$GLOBALS['strEmailFromAddress'] = "Wyślij \"Od\" - adres e-mail";
$GLOBALS['strEmailFromCompany'] = "Wyślij \"Od\" - firma";
$GLOBALS['strQmailPatch'] = "Włącz łatkę qmail";
$GLOBALS['strEnableQmailPatch'] = "Włącz łatkę qmail";
$GLOBALS['strEmailHeader'] = "Nagłówki e-mail";
$GLOBALS['strEmailLog'] = "Log e-maila";

// Audit Trail Settings
$GLOBALS['strAuditTrailSettings'] = "Ustawienia Audytu";
$GLOBALS['strEnableAudit'] = "Włącz Audyt";

// Debug Logging Settings
$GLOBALS['strDebug'] = "Ustawienia protokołowania diagnostycznego";
$GLOBALS['strProduction'] = "Serwer działający";
$GLOBALS['strEnableDebug'] = "Włącz protokołowanie diagnostyczne";
$GLOBALS['strDebugMethodNames'] = "Uwzględnij nazwę metody w protokole diagnostycznym";
$GLOBALS['strDebugLineNumbers'] = "Uwzględnij numer linii w protokole diagnostycznym";
$GLOBALS['strDebugType'] = "Typ protokołu diagnostycznego";
$GLOBALS['strDebugTypeFile'] = "Plik";
$GLOBALS['strDebugTypeSql'] = "Baza danych SQL";
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
$GLOBALS['strProductionSystem'] = "System produkcji";

// Delivery Settings
$GLOBALS['strDeliverySettings'] = "Ustawienia dostarczania";
$GLOBALS['strWebPath'] = "$PRODUCT_NAME Server Access Paths";
$GLOBALS['strWebPathSimple'] = "Ścieżka strony";
$GLOBALS['strDeliveryPath'] = "Ścieżka dostarczania";
$GLOBALS['strImagePath'] = "Ścieżka obrazów";
$GLOBALS['strDeliverySslPath'] = "SSL - Ścieżka dostarczania";
$GLOBALS['strImageSslPath'] = "SSL - Ścieżka obrazów";
$GLOBALS['strImageStore'] = "Folder obrazów";
$GLOBALS['strTypeWebSettings'] = "Konfiguracja banerów lokalnych (Webserwer)";
$GLOBALS['strTypeWebMode'] = "Metoda przechowywania";
$GLOBALS['strTypeWebModeLocal'] = "Katalog lokalny";
$GLOBALS['strTypeDirError'] = "Serwer nie może dokonywać wpisów w katalogu lokalnym";
$GLOBALS['strTypeWebModeFtp'] = "Zewnętrzny serwer FTP";
$GLOBALS['strTypeWebDir'] = "Katalog lokalny";
$GLOBALS['strTypeFTPHost'] = "Adres serwera FTP";
$GLOBALS['strTypeFTPDirectory'] = "Katalog serwera";
$GLOBALS['strTypeFTPPassword'] = "Hasło";
$GLOBALS['strTypeFTPPassive'] = "Używaj pasywnego FTP";
$GLOBALS['strTypeFTPErrorDir'] = "Podany katalog na serwerze nie istnieje";
$GLOBALS['strTypeFTPErrorConnect'] = "Błąd połączenia z serwerem FTP, login lub hasło jest niepoprawne";
$GLOBALS['strTypeFTPErrorNoSupport'] = "Zainstalowana wersja PHP nie obsługuje FTP.";
$GLOBALS['strTypeFTPErrorUpload'] = "Nie można przesłać pliku na serwer FTP, sprawdź ustawienia uprawnień hosta";
$GLOBALS['strTypeFTPErrorHost'] = "Nazwa hosta serwera FTP nie jest poprawna";
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
$GLOBALS['strOriginTimeout'] = "Czas oczekiwania (w sekundach)";
$GLOBALS['strOriginProtocol'] = "Protokół serwera głównego";

$GLOBALS['strDeliveryAcls'] = "Ewaluacja limitów dostarczania banerów w trakcie ich dostarczania";
$GLOBALS['strDeliveryObfuscate'] = "Ukryj kanał podczas dostarczania reklam";
$GLOBALS['strDeliveryExecPhp'] = "Zezwól na wykonywanie kodu PHP w reklamach <br /> (UWAGA: Obniża poziom bezpieczeństwa)";
$GLOBALS['strDeliveryCtDelimiter'] = "Ogranicznik śledzenia kliknięć strony trzeciej";
$GLOBALS['strGlobalDefaultBannerUrl'] = "Ogólny domyślny URL banera obrazu";
$GLOBALS['strP3PSettings'] = "Polityka prywatności P3P";
$GLOBALS['strUseP3P'] = "Użyj deklaracji P3P";
$GLOBALS['strP3PCompactPolicy'] = "Skrócona deklaracja P3P";
$GLOBALS['strP3PPolicyLocation'] = "Lokalizacja deklaracji P3P";

// General Settings
$GLOBALS['uiEnabled'] = "Interfejs użytkownika aktywny";

// Geotargeting Settings
$GLOBALS['strGeotargetingSettings'] = "Geotargeting";
$GLOBALS['strGeotargeting'] = "Geotargeting";
$GLOBALS['strGeotargetingType'] = "Typ modułu Geotargetingu";
$GLOBALS['strGeotargetingUseBundledCountryDb'] = "Użyj bazy MaxMind GeoLiteCountry";
$GLOBALS['strGeotargetingGeoipCountryLocation'] = "Lokalizacja Bazy Danych Państw MaxMind GeoIP";
$GLOBALS['strGeotargetingGeoipRegionLocation'] = "Lokalizacja Bazy Danych Regionów MaxMind GeoIP";
$GLOBALS['strGeotargetingGeoipCityLocation'] = "Lokalizacja Bazy Danych Miast MaxMind GeoIP";
$GLOBALS['strGeotargetingGeoipAreaLocation'] = "Lokalizacja Bazy Danych Obszaru MaxMind GeoIP";
$GLOBALS['strGeotargetingGeoipDmaLocation'] = "Lokalizacja Bazy Danych DMA MaxMind GeoIP";
$GLOBALS['strGeotargetingGeoipOrgLocation'] = "Lokalizacja Bazy Danych Organizacji MaxMind GeoIP";
$GLOBALS['strGeotargetingGeoipIspLocation'] = "Lokalizacja Bazy Danych ISP MaxMind GeoIP";
$GLOBALS['strGeotargetingGeoipNetspeedLocation'] = "Lokalizacja Bazy Danych Netspeed MaxMind GeoIP";
$GLOBALS['strGeoShowUnavailable'] = "Pokaż limity geotargetingu, nawet jeśli dane GeoIP nie są dostępne";
$GLOBALS['strGeotrackingGeoipCountryLocationError'] = "We wskazanej lokalizacji nie znaleziono Bazy Danych Państw MaxMind GeoIP";
$GLOBALS['strGeotrackingGeoipRegionLocationError'] = "We wskazanej lokalizacji nie znaleziono Bazy Danych Regionów MaxMind GeoIP";
$GLOBALS['strGeotrackingGeoipCityLocationError'] = "We wskazanej lokalizacji nie znaleziono Bazy Danych Miast MaxMind GeoIP";
$GLOBALS['strGeotrackingGeoipAreaLocationError'] = "We wskazanej lokalizacji nie znaleziono Bazy Danych Obszaru MaxMind GeoIP";
$GLOBALS['strGeotrackingGeoipDmaLocationError'] = "We wskazanej lokalizacji nie znaleziono Bazy Danych MaxMind GeoIP DMA";
$GLOBALS['strGeotrackingGeoipOrgLocationError'] = "We wskazanej lokalizacji nie znaleziono Bazy Danych Organizacji MaxMind GeoIP";
$GLOBALS['strGeotrackingGeoipIspLocationError'] = "We wskazanej lokalizacji nie znaleziono Bazy Danych ISP MaxMind GeoIP";
$GLOBALS['strGeotrackingGeoipNetspeedLocationError'] = "We wskazanej lokalizacji nie znaleziono Bazy Danych Netspeed MaxMind GeoIP";

// Interface Settings
$GLOBALS['strInventory'] = "Inwentarz";
$GLOBALS['strShowCampaignInfo'] = "Pokaż dodatkowe informacje o kampanii na stronie <i>Kampanie</i>";
$GLOBALS['strShowBannerInfo'] = "Pokaż dodatkowe informacje o banerze na stronie <i>Banery</i>";
$GLOBALS['strShowCampaignPreview'] = "Pokaż podgląd wszystkich banerów na stronie <i>Banery</i>";
$GLOBALS['strShowBannerHTML'] = "Pokaż baner zamiast zwykłego kodu HTML w podglądzie banerów HTML";
$GLOBALS['strShowBannerPreview'] = "Pokaż podgląd banera na górze stron, które wyświetlają banery";
$GLOBALS['strHideInactive'] = "Ukryj nieaktywne";
$GLOBALS['strGUIShowMatchingBanners'] = "Pokaż pasujące banery na stronach <i>Podłączony baner</i>";
$GLOBALS['strGUIShowParentCampaigns'] = "Pokaż nadrzędne kampanie na stronach <i>Podłączony baner</i>";
$GLOBALS['strGUIAnonymousCampaignsByDefault'] = "Ustawienie domyślne Kampanii na anonimowe";
$GLOBALS['strStatisticsDefaults'] = "Statystyki";
$GLOBALS['strBeginOfWeek'] = "Początek tygodnia";
$GLOBALS['strPercentageDecimals'] = "Cyfr po przecinku";
$GLOBALS['strWeightDefaults'] = "Waga domyślna";
$GLOBALS['strDefaultBannerWeight'] = "Domyślna waga banera";
$GLOBALS['strDefaultCampaignWeight'] = "Domyślna waga kampanii";
$GLOBALS['strDefaultBannerWErr'] = "Domyślna waga bannera powinna być dodatnią liczbę całkowitą";
$GLOBALS['strDefaultCampaignWErr'] = "Domyślna waga kampanii powinna być dodatnią liczbę całkowitą";
$GLOBALS['strConfirmationUI'] = "Potwierdzenie w interfejsie użytkownika";

$GLOBALS['strPublisherDefaults'] = "Domyślne ustawienia strony";
$GLOBALS['strModesOfPayment'] = "Metody płatności";
$GLOBALS['strCurrencies'] = "Waluta";
$GLOBALS['strCategories'] = "Kategorie";
$GLOBALS['strHelpFiles'] = "Pliki pomocy";
$GLOBALS['strHasTaxID'] = "NIP";
$GLOBALS['strDefaultApproved'] = "Zatwierdzone - okienko do odznaczenia";

// CSV Import Settings
$GLOBALS['strDefaultConversionStatus'] = "Domyślny status konwersji";
$GLOBALS['strDefaultConversionType'] = "Domyślny typ konwersji";

/**
 * @todo remove strBannerSettings if banner is only configurable as a preference
 *       rename // Banner Settings to  // Banner Preferences
 */
// Invocation Settings
$GLOBALS['strAllowedInvocationTypes'] = "Dopuszczalne typy kodu wywołującego";
$GLOBALS['strInvocationDefaults'] = "Domyślne ustawienia kodu wywołującego";
$GLOBALS['strEnable3rdPartyTrackingByDefault'] = "Niezależne śledzenie kliknięć jako ustawienie domyślne";

// Banner Delivery Settings
$GLOBALS['strBannerDelivery'] = "Ustawienia dostarczania banerów";

// Banner Logging Settings
$GLOBALS['strBannerLogging'] = "Ustawienia protokołowania banerów";
$GLOBALS['strLogAdRequests'] = "Protokołuj żądanie przy każdym żądaniu banera";
$GLOBALS['strLogAdImpressions'] = "Protokołuj odsłonę przy każdym wyświetlonym banerze";
$GLOBALS['strLogAdClicks'] = "Protokołuj kliknięcie za każdym razem, gdy odwiedzający klika na baner";
$GLOBALS['strLogTrackerImpressions'] = "Loguj odsłonę tackera każdorazowo, gdy wyświetlany jest sygnał trackera";
$GLOBALS['strReverseLookup'] = "Spróbuj ustalić nazwę hosta odwiedzającego, jeżeli nie została podana przez serwer";
$GLOBALS['strProxyLookup'] = "Spróbuj ustalić prawdziwy adres IP odwiedzającego, jeżeli korzysta on z Proxy";
$GLOBALS['strPreventLogging'] = "Zablokuj ustawienia protokołowania banerów";
$GLOBALS['strIgnoreHosts'] = "Nie protokołuj statystyk dla odwiedzających używających jednego z poniższych adresów IP lub hostów";
$GLOBALS['strIgnoreUserAgents'] = "<b>Nie</b> loguj statystyk dla klientów, których aplikacja kliencka zawiera jeden z następujących ciągów (po jednym w rubryce)";
$GLOBALS['strEnforceUserAgents'] = "<b>Loguj wyłącznie</b> statystyki dla klientów, których aplikacja kliencka zawiera jeden z następujących ciągów (po jednym w rubryce)";

// Banner Storage Settings
$GLOBALS['strBannerStorage'] = "Ustawienia przechowywania banerów";

// Campaign ECPM settings

// Statistics & Maintenance Settings
$GLOBALS['strMaintenanceSettings'] = "Ustawienia konserwacji";
$GLOBALS['strConversionTracking'] = "Ustawienia śledzenia konwersji";
$GLOBALS['strEnableConversionTracking'] = "Uruchom śledzenie konwersji";
$GLOBALS['strCsvImport'] = "Zezwalaj na wysyłanie konwersji offline";
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
$GLOBALS['strAdminEmailHeaders'] = "Dodaj następujące nagłówki do każdego e-maila wysyłanego przez {$PRODUCT_NAME}";
$GLOBALS['strWarnLimit'] = "Limit Ostrzeżenia - wyślij ostrzeżenie, gdy ilość pozostałych odsłon jest mniejsza niż ta określona tutaj";
$GLOBALS['strWarnLimitErr'] = "Limit ostrzeżenia musi być dodatnią liczbą całkowitą";
$GLOBALS['strWarnLimitDays'] = "Wyślij ostrzeżenie, gdy ilość dni jest mniejsza niż ta określona tutaj";
$GLOBALS['strWarnLimitDaysErr'] = "Ostrzeżenie: Limit dni powinien być liczbą dodatnią";
$GLOBALS['strAllowEmail'] = "Ogólne zezwolenie na wysyłanie e-maili";
$GLOBALS['strEmailAddressFrom'] = "Adres e-mail, z którego wysyłane są raporty";
$GLOBALS['strEmailAddressName'] = "Nazwa firmy lub osoby, która figuruje w syganturze wiadomości";
$GLOBALS['strWarnAdmin'] = "Wyślij ostrzeżenie do administratora zawsze, gdy kampania dobiega końca";
$GLOBALS['strWarnClient'] = "Wyślij ostrzeżenie do reklamodawcy zawsze, gdy kampania dobiega końca";
$GLOBALS['strWarnAgency'] = "Wyślij ostrzeżenie do agencji zawsze, gdy kampania dobiega końca";

// UI Settings
$GLOBALS['strGuiSettings'] = "Konfiguracja interfejsu użytkownika";
$GLOBALS['strGeneralSettings'] = "Ustawienia ogólne";
$GLOBALS['strAppName'] = "Nazwa programu";
$GLOBALS['strMyHeader'] = "Mój nagłówek";
$GLOBALS['strMyHeaderError'] = "Plik nagłówka nie istnieje w podanej lokalizacji";
$GLOBALS['strMyFooter'] = "Moja stopka";
$GLOBALS['strMyFooterError'] = "Plik stopki nie istnieje w podanej lokalizacji";
$GLOBALS['strDefaultTrackerStatus'] = "Domyślny status trackera";
$GLOBALS['strDefaultTrackerType'] = "Domyślny typ trackera";
$GLOBALS['strSSLSettings'] = "Ustawienia SSL";
$GLOBALS['requireSSL'] = "Wymuś dostęp SSL w interfejsie użytkownika";
$GLOBALS['sslPort'] = "Port SSL używany przez serwer WWW";
$GLOBALS['strDashboardSettings'] = "Ustawienia Panelu Nawigacyjnego";

$GLOBALS['strMyLogo'] = "Nazwa pliku logo";
$GLOBALS['strMyLogoError'] = "Plik logo nie istnieje w katalogu admin/images";
$GLOBALS['strGuiHeaderForegroundColor'] = "Kolor planu pierwszego w nagłówku";
$GLOBALS['strGuiHeaderBackgroundColor'] = "Kolor tła nagłówka";
$GLOBALS['strGuiActiveTabColor'] = "Kolor aktywnej zakładki";
$GLOBALS['strGuiHeaderTextColor'] = "Kolor tekstu w nagłówku";
$GLOBALS['strColorError'] = "Wpisz kolory w formacie RGB, np.'0066CC'";

$GLOBALS['strGzipContentCompression'] = "Użyj kompresji zawartości GZIP";
$GLOBALS['strClientInterface'] = "Interfejs Reklamodawcy";
$GLOBALS['strReportsInterface'] = "Interfejs raportów";
$GLOBALS['strClientWelcomeEnabled'] = "Włącz wiadomości powitalne dla Reklamodawcy";
$GLOBALS['strClientWelcomeText'] = "Tekst powitalny<br />(znaczniki HTML dozwolone)";

$GLOBALS['strPublisherInterface'] = "Interfejs Strony";
$GLOBALS['strPublisherAgreementEnabled'] = "Kontrola loginu dla Stron, które nie zaakceptowały Warunków Serwisu";
$GLOBALS['strPublisherAgreementText'] = "Tekst loginu (dopuszczalne znaczniki HTML)";

// Regenerate Platfor Hash script

// Plugin Settings

/* ------------------------------------------------------- */
/* Unknown (unused?) translations                        */
/* ------------------------------------------------------- */

$GLOBALS['strExperimental'] = "Eksperymentalne";
$GLOBALS['strKeywordRetrieval'] = "Słowa Kluczowe";
$GLOBALS['strBannerRetrieval'] = "Metoda Doboru Bannerów";
$GLOBALS['strRetrieveRandom'] = "Losowy wybór (domyślnie)";
$GLOBALS['strRetrieveNormalSeq'] = "Normalny, sekwencyjny wybór";
$GLOBALS['strWeightSeq'] = "Sekwencyjny wybór w oparciu o wagę";
$GLOBALS['strFullSeq'] = "Pełny wybór sekwencyjny";
$GLOBALS['strUseConditionalKeys'] = "Zezwól na operatory logiczne przy bezpśrednim wyborze";
$GLOBALS['strUseMultipleKeys'] = "Zezwól na kilka słów kluczowych przy bezpośrednim wyborze";

$GLOBALS['strTableBorderColor'] = "Kolor Obramowania Tabeli";
$GLOBALS['strTableBackColor'] = "Kolor Tła Tabeli";
$GLOBALS['strTableBackColorAlt'] = "Kolor Tła Tabeli (Alternatywny)";
$GLOBALS['strMainBackColor'] = "Główny Kolor Tła";
$GLOBALS['strOverrideGD'] = "Zignoruj Format Grafiki GD";
$GLOBALS['strTimeZone'] = "Strefa Czasowa";
