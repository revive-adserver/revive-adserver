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

// Main strings
$GLOBALS['strChooseSection'] = "Wybierz sekcję";
$GLOBALS['strAppendCodes'] = "Dołącz kody";

// Maintenance
$GLOBALS['strScheduledMaintenanceHasntRun'] = "<b>Planowana konserwacja nie była uruchomiona w ciągu ostatniej godziny. Może to oznaczać, że nie została poprawnie skonfigurowana.</b>";

$GLOBALS['strAutoMantenaceEnabledAndHasntRun'] = "Automatyczna konserwacja jest włączona, ale nie została zastosowana. Automatyczna konserwacja jest stosowana tylko wtedy, gdy {$PRODUCT_NAME} wyświetla banery. Dla zapewnienia najlepszej wydajności, należy skonfigurować <a href='{$PRODUCT_DOCSURL}/maintenance' target='_blank'>planowaną konserwację </a>.";

$GLOBALS['strAutoMantenaceDisabledAndHasntRun'] = "Automatyczna konserwacja jest obecnie wyłączona, więc nie zostanie uruchomiona w czasie dostarcznia banerów przez {$PRODUCT_NAME}. Aby uzystakać maksymalną wydajność skonfiguruj <a href='{$PRODUCT_DOCSURL}/maintenance' target='_blank'>planowaną konserwację</a>. Jednak, jeśli nie zamierzasz skonfigurować <a href='{$PRODUCT_DOCSURL}/maintenance' target='_blank'>planowanej konserwacji</a>, <i>musisz</i> <a href='account-settings-maintenance.php'>>uruchomić konserwację automatyczną</a>, aby mieć pewność, że {$PRODUCT_NAME} działa poprawnie.";

$GLOBALS['strAutoMantenaceEnabledAndRunning'] = "Automatyczna konserwacja jest włączona i zostanie wywołana, gdy będzie to konieczne, kiedy {$PRODUCT_NAME} wyświetli banery. Jednak dla optymalnej wydajności należy skonfigurować <a href='{$PRODUCT_DOCSURL}/maintenance' target='_blank'>planowaną konserwację</a>.";

$GLOBALS['strAutoMantenaceDisabledAndRunning'] = "Jednakże, automatyczna konserwacja została niedawno wyłączona. Aby upewnić się, że{$PRODUCT_NAME} działa poprawnie, można skonfigurować <a href='{$PRODUCT_DOCSURL}/maintenance' target='_blank'> planowaną konserwację</a> lub <a href='account-settings-maintenance.php'> ponownie włączyć automatyczną konserwację</a>.<br><br>. Dla optymalnej wydajności, należy skonfigurować <a href='{$PRODUCT_DOCSURL}/maintenance' target='_blank'>planowaną konserwację</a>.";

$GLOBALS['strScheduledMantenaceRunning'] = "<b>Planowana konserwacja działa poprawnie.</b>";

$GLOBALS['strAutomaticMaintenanceHasRun'] = "<b>Automatyczna konserwacja działa poprawnie.</b>";

$GLOBALS['strAutoMantenaceEnabled'] = "Jednakże, automatyczna konserwacja jest nadal włączona. Dla optymalnej wydajności, należy wyłączyć <a href='account-settings-maintenance.php'>automatyczną konserwację</a>.";

// Priority
$GLOBALS['strRecalculatePriority'] = "Przelicz priorytety";

// Banner cache
$GLOBALS['strCheckBannerCache'] = "Sprawdź cache banerów";
$GLOBALS['strBannerCacheErrorsFound'] = "Wykryto błędy w cache banerów. Banery będą działać, jeśli problemy zostaną naprawione manualnie.";
$GLOBALS['strBannerCacheOK'] = "Nie wykryto błędów. Cache banerów jest aktualne.";
$GLOBALS['strBannerCacheDifferencesFound'] = "Twoje cache banerów nie jest aktualne i wymaga odbudowania. Kliknij tu, aby automatycznie aktualizować cache.";
$GLOBALS['strBannerCacheRebuildButton'] = "Odbuduj";
$GLOBALS['strRebuildDeliveryCache'] = "Odbuduj cache banerów";
$GLOBALS['strBannerCacheExplaination'] = "    Cache banerów wykorzystywane jest do przyśpieszenia ich dostarczania<br />
    Cache musi zostać aktualizowane, gdy:
<ul>
<li>aktualizowana jest wersja OpenX</li>
<li>OpenX przenoszony jest do innej lokalizacji na serwerze</li>
</ul>";

// Cache
$GLOBALS['strCache'] = "Cache dostarczania";
$GLOBALS['strDeliveryCacheSharedMem'] = "	Współdzielona pamięć jest obecnie wykorzystywana do przechowywania cache dostarczania.";
$GLOBALS['strDeliveryCacheDatabase'] = "	Baza danych jest obecnie wykorzystywana do przechowywania cache dostarczania.";
$GLOBALS['strDeliveryCacheFiles'] = "Cache dostarczania jest obecnie przechowywane w różnych plikach na serwerze.";

// Storage
$GLOBALS['strStorage'] = "Przechowywanie";
$GLOBALS['strMoveToDirectory'] = "Przenieś obrazy przechowywane w bazie danych do katalogu";
$GLOBALS['strStorageExplaination'] = "	Pliki graficzne wykorzystywane przez banery lokalne są przechowane w bazie danych lub katalogu. Jeśli przechowujesz je w
	katalogu zmniejszy to obciążenie bazy danych i poprawi szybkość działania.";

// Security

// Encoding
$GLOBALS['strEncoding'] = "Kodowanie";
$GLOBALS['strEncodingExplaination'] = "{$PRODUCT_NAME} przechowuje wszystkie dane w formacie UTF-8.<br />W miarę możliwości dane będą automatycznie konwertowane do tego kodowania.<br />Jeśli po aktualizacji znaki nie będą wyświetlane poprawnie i wiesz, które kodowanie zostało zastosowane, możesz użyć tego narzędzia do przekonwertowania danych z tego formatu do formatu UTF-8";
$GLOBALS['strEncodingConvertFrom'] = "Konwertuj z następującego kodowania:";
$GLOBALS['strEncodingConvertTest'] = "Konwersja próbna";
$GLOBALS['strConvertThese'] = "Następujące dane zostaną zmienione, jeśli przejdziesz dalej";

// Product Updates
$GLOBALS['strSearchingUpdates'] = "Wyszukiwanie aktualizacji. Proszę czekać...";
$GLOBALS['strAvailableUpdates'] = "Dostępne aktualizacje";
$GLOBALS['strDownloadZip'] = "Pobierz (zip.)";
$GLOBALS['strDownloadGZip'] = "Pobierz (.tar.gz)";

$GLOBALS['strUpdateAlert'] = "Dostępna jest nowa wersja {$PRODUCT_NAME}.

Chcesz uzyskać więcej
informacji na jej temat?";
$GLOBALS['strUpdateAlertSecurity'] = "Dostępna jest nowa wersja {$PRODUCT_NAME}.

Zalecamy aktualizację
w możliwie szybkim terminie, ponieważ ta
wersja zawiera jedną lub więcej łatek bezpieczeństwa.";

$GLOBALS['strUpdateServerDown'] = "Z nieznanego powodu nie jest możliwe pobranie<br />informacji o możliwych aktualizacjach. Spróbuj ponownie później.";

$GLOBALS['strNoNewVersionAvailable'] = "	Twoja wersja {$PRODUCT_NAME} jest najbardziej aktualna. Nie ma obecnie żadnych nowych aktualizacji.";

$GLOBALS['strServerCommunicationError'] = "<b>Serwer z aktualizacjami nie odpowiada. {$PRODUCT_NAME} nie może w tym momencie sprawdzić czy dostępna jest bardziej aktualna wersja. Odczekaj kilka minut i spróbuj ponownie</b>";


$GLOBALS['strNewVersionAvailable'] = "	<b>Dostępna jest nowa wersja {$PRODUCT_NAME}.</b><br /> Zaleca się instalację tej aktualizacji,
	ponieważ może ona usuwać niektóre z istniejących problemów i dodawać nowe funkcje. Więcej informacji
	o aktualizowaniu znajdziesz się w dokumentacji załączonej w plikach poniżej.</b>";

$GLOBALS['strSecurityUpdate'] = "	<b>Zalecamy natychmiastową instalację aktualizacji, ponieważ zawiera ona
	istotne poprawki związane z bezpieczeństwem.</b> Wersja {$PRODUCT_NAME}, z której korzystasz obecnie
	może być podatna na ataki i prawdopodobnie nie jest bezpieczna. Więcej informacji o aktualizowaniu
	znajdziesz w dokumentacj załączonejw plikach poniżej.</b>";

$GLOBALS['strNotAbleToCheck'] = "	<b>Ponieważ rozszerzenie XML jest niedostępne na Twoim serwerze , {$PRODUCT_NAME} nie może
	sprawdzić, czy jest dostępna nowsza wersja</b>";

$GLOBALS['strForUpdatesLookOnWebsite'] = "	Jeśli chcesz sprawdzić, czy dostępna jest nowsza wersja, odwiedź naszą stronę.";

$GLOBALS['strClickToVisitWebsite'] = "	Kliknij, aby odwiedzić naszą stronę";
$GLOBALS['strCurrentlyUsing'] = "Obecnie korzystasz z";
$GLOBALS['strRunningOn'] = "obsługujący";
$GLOBALS['strAndPlain'] = "i";

//  Deliver Limitations
$GLOBALS['strErrorsFound'] = "Znaleziono błędy";
$GLOBALS['strRepairCompiledLimitations'] = "Stwierdzono pewne nieprawidłowości powyżej, można naprawić je, korzystając z przycisku poniżej, aby ponownie skompilować ograniczenia dla każdego banera/kanału systemu<br />";
$GLOBALS['strRecompile'] = "Przekompiluj";

//  Append codes
$GLOBALS['strAppendCodesDesc'] = "W pewnych okolicznościach mechanizm dostarczania może nie być kompatybilny z kodami dodawanymi do trackerów, użyj tego linku, aby sprawdzić poprawność kodów w bazie danych";
$GLOBALS['strCheckAppendCodes'] = "Sprawdź dołączone kody";
$GLOBALS['strAppendCodesRecompiled'] = "Wszystkie skompilowane wartości dla dodawanych kodów zostały zrekompilowane";
$GLOBALS['strAppendCodesResult'] = "Oto wyniki walidacji skompilowanch kodów dodanych";
$GLOBALS['strAppendCodesValid'] = "Wszystkie skompilowane kody trackera są ważne";
$GLOBALS['strRepairAppenedCodes'] = "Stwierdzono pewne nieprawidłowości powyżej, można naprawić te, korzystając z przycisku poniżej, aby ponownie skompilować kody dodane dla każdego trackera w systemie";

$GLOBALS['strPlugins'] = "Moduły dodatkowe";


// Users
