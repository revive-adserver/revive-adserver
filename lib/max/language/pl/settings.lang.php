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
$GLOBALS['strAdminAccount'] = "Konto Administratora";
$GLOBALS['strAdvancedSettings'] = "Ustawienia zaawansowane";
$GLOBALS['strWarning'] = "Uwaga";
$GLOBALS['strBtnContinue'] = "Dalej »";
$GLOBALS['strBtnRecover'] = "Odzyskaj »";
$GLOBALS['strBtnAgree'] = "Wyrażam zgodę »";
$GLOBALS['strBtnRetry'] = "Próbuj ponownie";
$GLOBALS['strWarningRegisterArgcArv'] = "Aby uruchomić działania konserwacyjne z polecenia należy włączyć zmienną konfiguracji PHP register_argc_argv.";
$GLOBALS['strTablesType'] = "Typ tabeli";

$GLOBALS['strRecoveryRequiredTitle'] = "W czasie poprzedniej próby aktualizacji wystąpiły błędy";
$GLOBALS['strRecoveryRequired'] = "Wystąpił błąd w trakcie przetwarzania poprzedniej próby aktualizacji. {$PRODUCT_NAME} spróbuje odzyskać dane z poprzedniej aktualizacji. Kliknij Odzyskaj poniżej.";

$GLOBALS['strOaUpToDate'] = "Twoja baza danych {$PRODUCT_NAME} oraz struktura pliku wskazuje, że korzystasz z najnowszej wersji i aktualizacja nie jest wymagana w tym momencie. Kliknij Dalej, aby przejść do panelu administratora {$PRODUCT_NAME}.";
$GLOBALS['strOaUpToDateCantRemove'] = "Ostrzeżenie: plik UPGRADE wciąż znajduje się w folderze var. Nie możemy go usunąć ze względu na ograniczone uprawnienia. Musisz usunąć plik własnoręcznie.";
$GLOBALS['strErrorWritePermissions'] = "Wykryto błędy w dostępie do pliku. Błędy muszą zostać naprawione zanim przejdziesz dalej.<br/>Aby naprawić błędy w systemie Linux, spróbuj wpisać następujące polecenie(a):";

$GLOBALS['strErrorWritePermissionsWin'] = "Wykryto błędy w dostępie do pliku. Błędy muszą zostać naprawione zanim przejdziesz dalej.";
$GLOBALS['strCheckDocumentation'] = "Więcej wskazówek uzyskasz w <a href='{$PRODUCT_DOCSURL}'>Dokumentacji {$PRODUCT_NAME}</a>.";

$GLOBALS['strAdminUrlPrefix'] = "URL interfejsu administratora";
$GLOBALS['strDeliveryUrlPrefix'] = "URL serwera";
$GLOBALS['strDeliveryUrlPrefixSSL'] = "URL serwera (SSL)";
$GLOBALS['strImagesUrlPrefix'] = "URL pamięci plików graficznych";
$GLOBALS['strImagesUrlPrefixSSL'] = "URL pamięci plików graficznych (SSL)";



/* ------------------------------------------------------- */
/* Configuration translations                            */
/* ------------------------------------------------------- */

// Global
$GLOBALS['strChooseSection'] = "Wybierz sekcję";
$GLOBALS['strUnableToWriteConfig'] = "Nie można wprowadzić zmian w pliku config";
$GLOBALS['strUnableToWritePrefs'] = "Nie można wprowadzić preferencji w bazie danych";
$GLOBALS['strImageDirLockedDetected'] = "Wskazany <b>Folder Obrazów</b> nie jest otwarty do edycji. <b>Zmień uprawnienia w folderze lub utwórz folder, aby kontynuować.";

// Configuration Settings
$GLOBALS['strConfigurationSettings'] = "Ustawienia konfiguracji";

// Administrator Settings
$GLOBALS['strAdminUsername'] = "Nazwa użytkownika Administratora";
$GLOBALS['strAdminPassword'] = "Hasło Administratora";
$GLOBALS['strInvalidUsername'] = "Nieprawidłowa nazwa użytkownika";
$GLOBALS['strBasicInformation'] = "Informacje podstawowe";
$GLOBALS['strAdministratorEmail'] = "E-mail Administratora";
$GLOBALS['strAdminCheckUpdates'] = "Sorawdź aktualizacje";
$GLOBALS['strNovice'] = "Usuwanie wymaga potwierdzenia ze względu na bezpieczeństwo";
$GLOBALS['strUserlogEmail'] = "Loguj wszystkie wychodzące wiadomości e-mail";
$GLOBALS['strTimezone'] = "Strefa czasowa";
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
$GLOBALS['strGeoShowUnavailable'] = "Pokaż limity geotargetingu, nawet jeśli dane GeoIP nie są dostępne";

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
$GLOBALS['strStatisticsDefaults'] = "Statystyki";
$GLOBALS['strBeginOfWeek'] = "Początek tygodnia";
$GLOBALS['strPercentageDecimals'] = "Cyfr po przecinku";
$GLOBALS['strWeightDefaults'] = "Waga domyślna";
$GLOBALS['strDefaultBannerWeight'] = "Domyślna waga banera";
$GLOBALS['strDefaultCampaignWeight'] = "Domyślna waga kampanii";
$GLOBALS['strConfirmationUI'] = "Potwierdzenie w interfejsie użytkownika";

// Invocation Settings
$GLOBALS['strInvocationDefaults'] = "Domyślne ustawienia kodu wywołującego";
$GLOBALS['strEnable3rdPartyTrackingByDefault'] = "Niezależne śledzenie kliknięć jako ustawienie domyślne";

// Banner Delivery Settings
$GLOBALS['strBannerDelivery'] = "Ustawienia dostarczania banerów";

// Banner Logging Settings
$GLOBALS['strBannerLogging'] = "Ustawienia protokołowania banerów";
$GLOBALS['strLogAdRequests'] = "Protokołuj żądanie przy każdym żądaniu banera";
$GLOBALS['strLogAdImpressions'] = "Protokołuj odsłonę przy każdym wyświetlonym banerze";
$GLOBALS['strLogAdClicks'] = "Protokołuj kliknięcie za każdym razem, gdy odwiedzający klika na baner";
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
$GLOBALS['strBlockAdClicks'] = "Nie zliczaj Kliknięć, jeśli odwiedzający kliknął tę samą parę reklama/strefa w ciągu określonego okresu czasu (w sekundach)";
$GLOBALS['strMaintenanceOI'] = "Odstęp między przeprowadzaniem konserwacji (w minutach)";
$GLOBALS['strPrioritySettings'] = "Ustawienia priorytetów";
$GLOBALS['strPriorityInstantUpdate'] = "Aktualizuj priorytety reklamy natychmiast po modyfikacjach w interfejsie";
$GLOBALS['strDefaultImpConWindow'] = "Domyślny okres walidacji Odsłony (w sekundach)";
$GLOBALS['strDefaultCliConWindow'] = "Domyślny okres walidacji Kliknięcia (w sekundach)";
$GLOBALS['strAdminEmailHeaders'] = "Dodaj następujące nagłówki do każdego e-maila wysyłanego przez {$PRODUCT_NAME}";
$GLOBALS['strWarnLimit'] = "Limit Ostrzeżenia - wyślij ostrzeżenie, gdy ilość pozostałych odsłon jest mniejsza niż ta określona tutaj";
$GLOBALS['strWarnLimitDays'] = "Wyślij ostrzeżenie, gdy ilość dni jest mniejsza niż ta określona tutaj";
$GLOBALS['strWarnAdmin'] = "Wyślij ostrzeżenie do administratora zawsze, gdy kampania dobiega końca";
$GLOBALS['strWarnClient'] = "Wyślij ostrzeżenie do reklamodawcy zawsze, gdy kampania dobiega końca";
$GLOBALS['strWarnAgency'] = "Wyślij ostrzeżenie do agencji zawsze, gdy kampania dobiega końca";

// UI Settings
$GLOBALS['strGuiSettings'] = "Konfiguracja interfejsu użytkownika";
$GLOBALS['strGeneralSettings'] = "Ustawienia ogólne";
$GLOBALS['strAppName'] = "Nazwa programu";
$GLOBALS['strMyHeader'] = "Mój nagłówek";
$GLOBALS['strMyFooter'] = "Moja stopka";
$GLOBALS['strDefaultTrackerStatus'] = "Domyślny status trackera";
$GLOBALS['strDefaultTrackerType'] = "Domyślny typ trackera";
$GLOBALS['strSSLSettings'] = "Ustawienia SSL";
$GLOBALS['requireSSL'] = "Wymuś dostęp SSL w interfejsie użytkownika";
$GLOBALS['sslPort'] = "Port SSL używany przez serwer WWW";
$GLOBALS['strDashboardSettings'] = "Ustawienia Panelu Nawigacyjnego";
$GLOBALS['strMyLogo'] = "Nazwa pliku logo";
$GLOBALS['strGuiHeaderForegroundColor'] = "Kolor planu pierwszego w nagłówku";
$GLOBALS['strGuiHeaderBackgroundColor'] = "Kolor tła nagłówka";
$GLOBALS['strGuiActiveTabColor'] = "Kolor aktywnej zakładki";
$GLOBALS['strGuiHeaderTextColor'] = "Kolor tekstu w nagłówku";
$GLOBALS['strGzipContentCompression'] = "Użyj kompresji zawartości GZIP";

// Regenerate Platfor Hash script

// Plugin Settings
