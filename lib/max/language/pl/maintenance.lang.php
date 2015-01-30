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
$GLOBALS['strHighPriorityCampaigns'] = "Kampanie o wysokich priorytetach";
$GLOBALS['strAdViewsAssigned'] = "Odsłony przydzielone";
$GLOBALS['strLowPriorityCampaigns'] = "Kampanie o niskich priorytetach";
$GLOBALS['strPredictedAdViews'] = "Przewidziane Odsłony";
$GLOBALS['strPriorityDaysRunning'] = "Dostępnych jest obecnie {days} dni danych statystycznych, na których {$PRODUCT_NAME} może bazować swoje dzienne przewidywania. ";
$GLOBALS['strPriorityBasedLastWeek'] = "Predykcja jest oparta na danych z tego i poprzedniego tygodnia. ";
$GLOBALS['strPriorityBasedLastDays'] = "Predykcja jest oparta na danych z kilku ostatnich dni. ";
$GLOBALS['strPriorityBasedYesterday'] = "Predykcja jest oparta na danych z wczoraj. ";
$GLOBALS['strPriorityNoData'] = "Nie ma wystarczających danych na których możnaby oprzeć przewidywania co o ilości Odsłon, które ten serwer może wytworzyć dzisiaj. Przydziały priorytetów będą bazowały jedynie na chwilowych danych statystycznych. ";
$GLOBALS['strPriorityEnoughAdViews'] = "Powinno wystarczyć Odsłon aby zapewnić wykonanie limitów przydzielonych kampaniom o wysokim priorytecie. ";
$GLOBALS['strPriorityNotEnoughAdViews'] = "Nie jest pewne czy wystarczy Odsłon aby zapewnić wykonanie limitów wszystkich kampanii o wysokim priorytecie. Z tego powodu kampanie o niskim priorytecie zostają chwilowo wyłączone. ";


// Banner cache
$GLOBALS['strCheckBannerCache'] = "Sprawdź cache banerów";
$GLOBALS['strRebuildBannerCache'] = "Odbuduj cache bannerów";
$GLOBALS['strBannerCacheErrorsFound'] = "Wykryto błędy w cache banerów. Banery będą działać, jeśli problemy zostaną naprawione manualnie.";
$GLOBALS['strBannerCacheOK'] = "Nie wykryto błędów. Cache banerów jest aktualne.";
$GLOBALS['strBannerCacheDifferencesFound'] = "Twoje cache banerów nie jest aktualne i wymaga odbudowania. Kliknij tu, aby automatycznie aktualizować cache.";
$GLOBALS['strBannerCacheFixed'] = "Cache banerów zostało pomyślnie odbudowane. Cache bazy danych jest aktualne.";
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
$GLOBALS['strAge'] = "Wiek";
$GLOBALS['strDeliveryCacheSharedMem'] = "	Współdzielona pamięć jest obecnie wykorzystywana do przechowywania cache dostarczania.";
$GLOBALS['strDeliveryCacheDatabase'] = "	Baza danych jest obecnie wykorzystywana do przechowywania cache dostarczania.";
$GLOBALS['strDeliveryCacheFiles'] = "Cache dostarczania jest obecnie przechowywane w różnych plikach na serwerze.";


// Storage
$GLOBALS['strStorage'] = "Przechowywanie";
$GLOBALS['strMoveToDirectory'] = "Przenieś obrazy przechowywane w bazie danych do katalogu";
$GLOBALS['strStorageExplaination'] = "	Pliki graficzne wykorzystywane przez banery lokalne są przechowane w bazie danych lub katalogu. Jeśli przechowujesz je w
	katalogu zmniejszy to obciążenie bazy danych i poprawi szybkość działania.";

// Encoding
$GLOBALS['strEncoding'] = "Kodowanie";
$GLOBALS['strEncodingExplaination'] = "{$PRODUCT_NAME} przechowuje wszystkie dane w formacie UTF-8.<br />W miarę możliwości dane będą automatycznie konwertowane do tego kodowania.<br />Jeśli po aktualizacji znaki nie będą wyświetlane poprawnie i wiesz, które kodowanie zostało zastosowane, możesz użyć tego narzędzia do przekonwertowania danych z tego formatu do formatu UTF-8";
$GLOBALS['strEncodingConvertFrom'] = "Konwertuj z następującego kodowania:";
$GLOBALS['strEncodingConvert'] = "Konwertuj";
$GLOBALS['strEncodingConvertTest'] = "Konwersja próbna";
$GLOBALS['strConvertThese'] = "Następujące dane zostaną zmienione, jeśli przejdziesz dalej";


// Storage
$GLOBALS['strStatisticsExplaination'] = "	Wybrałeś opcję <i>statystyk skróconych</i>, jednakże stare statystyki są nadal w rozszerzonym formacie.
	Czy chcesz je skonwertować do nowego, skróconego formatu?";


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


// Stats conversion
$GLOBALS['strConverting'] = "Konwersja";
$GLOBALS['strConvertingStats'] = "Konwertowanie statystyk...";
$GLOBALS['strConvertStats'] = "Konwertuj statystyki";
$GLOBALS['strConvertAdViews'] = "Odsłony skonwertowane,";
$GLOBALS['strConvertAdClicks'] = "Kliknięcia skonwertowane...";
$GLOBALS['strConvertNothing'] = "Nie ma nic do konwersji...";
$GLOBALS['strConvertFinished'] = "Zakończone...";

$GLOBALS['strConvertExplaination'] = "	Używasz obecnie skróconego formatu statystyk, ale nadal niektóre dane statystyczne są <br />
	w rozszerzonym formacie. Dopóki nie zostaną one skonwertowane do formatu skróconego <br />
	nie będą wykorzystywane podczas przeglądania tych stron. <br />
	Przed konwersją statystyk zrób kopię zapasową bazy danych! <br />
	Czy chcesz skonwertować rozszczerzone statystyki do nowego, skróconego formatu? <br />";

$GLOBALS['strConvertingExplaination'] = "	Wszystkie pozostające rozszerzone statystyki są obecnie konwertowane do formatu skróconego. <br />
	Zależnie od ilości danych poddawanych konwersji może ona potrwać do kilkunastu minut. <br />
	Zaczekaj aż zostanie ona zakończona zanim przejdziesz na inną stronę. <br />
	Poniżej znajduje się lista wszystkich dokonanych modyfikacji w bazie danych. <br />";

$GLOBALS['strConvertFinishedExplaination'] = "	Konwersja pozostałych w formacie rozszerzonym statystyk została zakończona i <br />
	dane mogą być teraz znowu wykorzystywane. Poniżej znajdziesz listę wszystkich <br />
	zmian dokonanych w bazie danych.<br />";

//  Maintenace
$GLOBALS['strAutoMaintenanceDisabled'] = "Automatyczna konserwacja jest wyłączona.";
$GLOBALS['strAutoMaintenanceEnabled'] = "Automatyczna konserwacja jest włączona. Dla optymalnej wydajności zaleca się <a href='settings-admin.php'>wyłączenie automatycznej konserwacji</a>.";
$GLOBALS['strScheduledMaintenance'] = "Planowana konserwacja wydaje się działać poprawnie.";
$GLOBALS['strScheduledMaintenanceNotRun'] = "Planowana konserwacja nie była uruchomiona w ciągu ostatnich godzin. Może to oznaczać, że nie wszystko dobrze ustawiłeś.";
$GLOBALS['strAutoMaintenanceEnabledNotTriggered'] = "Automatyczna konserwacja jest włączona, ale nie została zastosowana. Należy pamiętać, że automatyczna konserwacja jest stosowana tylko wtedy, gdy {$PRODUCT_NAME} wyświetla bannery.";
$GLOBALS['strAutoMaintenanceBestPerformance'] = "Dla optymalnej wydajności zaleca się skonfigurowanie <a href='{$PRODUCT_DOCSURL}/maintenance.html' target='_blank'>planowanej konserwacji</a>";
$GLOBALS['strAutoMaintenanceEnabledWilltTrigger'] = "Automatyczna konserwacja jest włączona i będzie uruchamiana co godzinę.";
$GLOBALS['strAutoMaintenanceDisabledMaintenanceRan'] = "Automatyczna konserwacja jest wyłączona, ale zadanie konserwacji niedawno zostało uruchomione. Aby upewnić się, że {$PRODUCT_NAME} działa prawidłowo należy również ustawić <a href='http://{$PRODUCT_DOCSURL}/maintenance.html' target='_blank'>planowaną konserwację</a> lub <a href='settings-admin.php'>uruchomić automatyczną konserwację</a>.";
$GLOBALS['strAutoMaintenanceDisabledNotTriggered'] = "Ponadto, automatyczna konserwacja jest wyłączona, więc kiedy {$PRODUCT_NAME} wyświetla banery, konserwacja nie jest uruchamian. Jeśli nie planujesz uruchomić <a href='http://{$PRODUCT_DOCSURL}/maintenance.html' target='_blank'>planowanej konserwacji</a>, <a href='settings-admin.php'>musisz włączyć automatyczną konserwację</a>, aby upewnić się, że {$PRODUCT_NAME} działa poprawnie.";

//  Deliver Limitations
$GLOBALS['strAllBannerChannelCompiled'] = "Wszystkie skompilowane wartości limitów dla banerów/kanałów zostały zrekompilowane";
$GLOBALS['strBannerChannelResult'] = "Oto wyniki walidacji skompilowanych limitów dla banerów/kanałów";
$GLOBALS['strChannelCompiledLimitationsValid'] = "Wszystkie skompilowane limity dla kanału są ważne";
$GLOBALS['strBannerCompiledLimitationsValid'] = "Wszystkie skompilowane limity dla banerów są ważne";
$GLOBALS['strErrorsFound'] = "Znaleziono błędy";
$GLOBALS['strRepairCompiledLimitations'] = "Stwierdzono pewne nieprawidłowości powyżej, można naprawić je, korzystając z przycisku poniżej, aby ponownie skompilować ograniczenia dla każdego banera/kanału systemu<br />";
$GLOBALS['strRecompile'] = "Przekompiluj";
$GLOBALS['strDeliveryEngineDisagreeNotice'] = "W pewnych okolicznościach mechanizm dostarczania może nie być kompatybilny z listami ACL dla banerów i kanałów, użyj tego linku, aby sprawdzić poprawność list ACL w bazie danych";
$GLOBALS['strCheckACLs'] = "Sprawdź listy ACL";


//  Append codes
$GLOBALS['strAppendCodesDesc'] = "W pewnych okolicznościach mechanizm dostarczania może nie być kompatybilny z kodami dodawanymi do trackerów, użyj tego linku, aby sprawdzić poprawność kodów w bazie danych";
$GLOBALS['strCheckAppendCodes'] = "Sprawdź dołączone kody";
$GLOBALS['strAppendCodesRecompiled'] = "Wszystkie skompilowane wartości dla dodawanych kodów zostały zrekompilowane";
$GLOBALS['strAppendCodesResult'] = "Oto wyniki walidacji skompilowanch kodów dodanych";
$GLOBALS['strAppendCodesValid'] = "Wszystkie skompilowane kody trackera są ważne";
$GLOBALS['strRepairAppenedCodes'] = "Stwierdzono pewne nieprawidłowości powyżej, można naprawić te, korzystając z przycisku poniżej, aby ponownie skompilować kody dodane dla każdego trackera w systemie";

$GLOBALS['strPlugins'] = "Moduły dodatkowe";

