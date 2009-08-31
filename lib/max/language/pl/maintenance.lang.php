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

// Main strings
$GLOBALS['strChooseSection']			= "Wybierz sekcję";


// Priority
$GLOBALS['strRecalculatePriority']		= "Przelicz priorytety";
$GLOBALS['strHighPriorityCampaigns']		= "Kampanie o wysokich priorytetach";
$GLOBALS['strAdViewsAssigned']			= "Odsłony przydzielone";
$GLOBALS['strLowPriorityCampaigns']		= "Kampanie o niskich priorytetach";
$GLOBALS['strPredictedAdViews']			= "Przewidziane Odsłony";
$GLOBALS['strPriorityDaysRunning']		= "Dostępnych jest obecnie {days} dni danych statystycznych, na których ".MAX_PRODUCT_NAME." może bazować swoje dzienne przewidywania. ";
$GLOBALS['strPriorityBasedLastWeek']		= "Predykcja jest oparta na danych z tego i poprzedniego tygodnia. ";
$GLOBALS['strPriorityBasedLastDays']		= "Predykcja jest oparta na danych z kilku ostatnich dni. ";
$GLOBALS['strPriorityBasedYesterday']		= "Predykcja jest oparta na danych z wczoraj. ";
$GLOBALS['strPriorityNoData']			= "Nie ma wystarczających danych na których możnaby oprzeć przewidywania co o ilości Odsłon, które ten serwer może wytworzyć dzisiaj. Przydziały priorytetów będą bazowały jedynie na chwilowych danych statystycznych. ";
$GLOBALS['strPriorityEnoughAdViews']		= "Powinno wystarczyć Odsłon aby zapewnić wykonanie limitów przydzielonych kampaniom o wysokim priorytecie. ";
$GLOBALS['strPriorityNotEnoughAdViews']		= "Nie jest pewne czy wystarczy Odsłon aby zapewnić wykonanie limitów wszystkich kampanii o wysokim priorytecie. Z tego powodu kampanie o niskim priorytecie zostają chwilowo wyłączone. ";


// Banner cache
$GLOBALS['strRebuildBannerCache']		= "Odbuduj cache bannerów";
$GLOBALS['strBannerCacheExplaination']		= "\n    Cache banerów wykorzystywane jest do przyśpieszenia ich dostarczania<br />\n    Cache musi zostać aktualizowane, gdy:\n<ul>\n<li>aktualizowana jest wersja OpenX</li>\n<li>OpenX przenoszony jest do innej lokalizacji na serwerze</li>\n</ul>\n";


// Cache
$GLOBALS['strCache']				= "Cache dostarczania";
$GLOBALS['strAge']				= "Wiek";
$GLOBALS['strRebuildDeliveryCache']		= "Odbuduj cache banerów";
$GLOBALS['strDeliveryCacheExplaination']	= "\n	Cache dostarczania jest wykorzystywany do przyspieszenia wyświetlania bannerów. Cache zawiera kopię wszystkich bannerów,\n	które są podłączone do strefy, co pozwala zaoszczędzić kilka odwołań do bazy danych kiedy bannery są dostarczane użytkownikówi. Cache\n	jest zazwyczaj odbudowywany za każdym razem kiedy zostanie dokonana zmiana w strefie lub jednym z jej bannerów. Może się zdarzyć, że\n	cache przestanie być aktualny. Z tego powodu jest odbudowywany co godzinę oraz dodatkowo można go odbudować ręcznie.\n";
$GLOBALS['strDeliveryCacheSharedMem']		= "\n	Współdzielona pamięć jest obecnie wykorzystywana do przechowywania cache dostarczania.\n";
$GLOBALS['strDeliveryCacheDatabase']		= "\n	Baza danych jest obecnie wykorzystywana do przechowywania cache dostarczania.\n";


// Storage
$GLOBALS['strStorage']				= "Przechowywanie";
$GLOBALS['strMoveToDirectory']			= "Przenieś obrazy przechowywane w bazie danych do katalogu";
$GLOBALS['strStorageExplaination']		= "\n	Pliki graficzne wykorzystywane przez banery lokalne są przechowane w bazie danych lub katalogu. Jeśli przechowujesz je w\n	katalogu zmniejszy to obciążenie bazy danych i poprawi szybkość działania.\n";


// Storage
$GLOBALS['strStatisticsExplaination']		= "\n	Wybrałeś opcję <i>statystyk skróconych</i>, jednakże stare statystyki są nadal w rozszerzonym formacie.\n	Czy chcesz je skonwertować do nowego, skróconego formatu?\n";


// Product Updates
$GLOBALS['strSearchingUpdates']			= "Wyszukiwanie aktualizacji. Proszę czekać...";
$GLOBALS['strAvailableUpdates']			= "Dostępne aktualizacje";
$GLOBALS['strDownloadZip']			= "Pobierz (zip.)";
$GLOBALS['strDownloadGZip']			= "Pobierz (.tar.gz)";

$GLOBALS['strUpdateAlert']			= "Dostępna jest nowa wersja ". MAX_PRODUCT_NAME .".                 \n\nChcesz uzyskać więcej \ninformacji na jej temat?";
$GLOBALS['strUpdateAlertSecurity']		= "Dostępna jest nowa wersja ". MAX_PRODUCT_NAME .".                 \n\nZalecamy aktualizację \nw możliwie szybkim terminie, ponieważ ta \nwersja zawiera jedną lub więcej łatek bezpieczeństwa.";

$GLOBALS['strUpdateServerDown']			= "Z nieznanego powodu nie jest możliwe pobranie<br />informacji o możliwych aktualizacjach. Spróbuj ponownie później.";

$GLOBALS['strNoNewVersionAvailable']		= "\n	Twoja wersja ". MAX_PRODUCT_NAME ." jest najbardziej aktualna. Nie ma obecnie żadnych nowych aktualizacji.\n";

$GLOBALS['strNewVersionAvailable']		= "\n	<b>Dostępna jest nowa wersja ". MAX_PRODUCT_NAME .".</b><br /> Zaleca się instalację tej aktualizacji,\n	ponieważ może ona usuwać niektóre z istniejących problemów i dodawać nowe funkcje. Więcej informacji\n	o aktualizowaniu znajdziesz się w dokumentacji załączonej w plikach poniżej.</b>\n";

$GLOBALS['strSecurityUpdate']			= "\n	<b>Zalecamy natychmiastową instalację aktualizacji, ponieważ zawiera ona\n	istotne poprawki związane z bezpieczeństwem.</b> Wersja ". MAX_PRODUCT_NAME .", z której korzystasz obecnie\n	może być podatna na ataki i prawdopodobnie nie jest bezpieczna. Więcej informacji o aktualizowaniu\n	znajdziesz w dokumentacj załączonejw plikach poniżej.</b>\n";

$GLOBALS['strNotAbleToCheck']			= "\n	<b>Ponieważ rozszerzenie XML jest niedostępne na Twoim serwerze , ". MAX_PRODUCT_NAME ." nie może\n	sprawdzić, czy jest dostępna nowsza wersja</b>\n";

$GLOBALS['strForUpdatesLookOnWebsite']		= "\n	Jeśli chcesz sprawdzić, czy dostępna jest nowsza wersja, odwiedź naszą stronę.\n";

$GLOBALS['strClickToVisitWebsite']		= "	Kliknij, aby odwiedzić naszą stronę";


// Stats conversion
$GLOBALS['strConverting']			= "Konwersja";
$GLOBALS['strConvertingStats']			= "Konwertowanie statystyk...";
$GLOBALS['strConvertStats']			= "Konwertuj statystyki";
$GLOBALS['strConvertAdViews']			= "Odsłony skonwertowane,";
$GLOBALS['strConvertAdClicks']			= "Kliknięcia skonwertowane...";
$GLOBALS['strConvertNothing']			= "Nie ma nic do konwersji...";
$GLOBALS['strConvertFinished']			= "Zakończone...";

$GLOBALS['strConvertExplaination']		= "\n	Używasz obecnie skróconego formatu statystyk, ale nadal niektóre dane statystyczne są <br />\n	w rozszerzonym formacie. Dopóki nie zostaną one skonwertowane do formatu skróconego <br />\n	nie będą wykorzystywane podczas przeglądania tych stron. <br />\n	Przed konwersją statystyk zrób kopię zapasową bazy danych! <br />\n	Czy chcesz skonwertować rozszczerzone statystyki do nowego, skróconego formatu? <br />\n";

$GLOBALS['strConvertingExplaination']		= "\n	Wszystkie pozostające rozszerzone statystyki są obecnie konwertowane do formatu skróconego. <br />\n	Zależnie od ilości danych poddawanych konwersji może ona potrwać do kilkunastu minut. <br />\n	Zaczekaj aż zostanie ona zakończona zanim przejdziesz na inną stronę. <br />\n	Poniżej znajduje się lista wszystkich dokonanych modyfikacji w bazie danych. <br />\n";

$GLOBALS['strConvertFinishedExplaination']  	= "\n	Konwersja pozostałych w formacie rozszerzonym statystyk została zakończona i <br />\n	dane mogą być teraz znowu wykorzystywane. Poniżej znajdziesz listę wszystkich <br />\n	zmian dokonanych w bazie danych.<br />\n";




// Note: New translations not found in original lang files but found in CSV
$GLOBALS['strCheckBannerCache'] = "Sprawdź cache banerów";
$GLOBALS['strBannerCacheErrorsFound'] = "Wykryto błędy w cache banerów. Banery będą działać, jeśli problemy zostaną naprawione manualnie.";
$GLOBALS['strBannerCacheOK'] = "Nie wykryto błędów. Cache banerów jest aktualne.";
$GLOBALS['strBannerCacheDifferencesFound'] = "Twoje cache banerów nie jest aktualne i wymaga odbudowania. Kliknij tu, aby automatycznie aktualizować cache.";
$GLOBALS['strBannerCacheRebuildButton'] = "Odbuduj";
$GLOBALS['strDeliveryCacheFiles'] = "Cache dostarczania jest obecnie przechowywane w różnych plikach na serwerze.";
$GLOBALS['strCurrentlyUsing'] = "Obecnie korzystasz z";
$GLOBALS['strRunningOn'] = "obsługujący";
$GLOBALS['strAndPlain'] = "i";
$GLOBALS['strBannerCacheFixed'] = "Cache banerów zostało pomyślnie odbudowane. Cache bazy danych jest aktualne.";
$GLOBALS['strEncoding'] = "Kodowanie";
$GLOBALS['strEncodingExplaination'] = "". MAX_PRODUCT_NAME ." przechowuje wszystkie dane w formacie UTF-8.<br />W miarę możliwości dane będą automatycznie konwertowane do tego kodowania.<br />Jeśli po aktualizacji znaki nie będą wyświetlane poprawnie i wiesz, które kodowanie zostało zastosowane, możesz użyć tego narzędzia do przekonwertowania danych z tego formatu do formatu UTF-8";
$GLOBALS['strEncodingConvertFrom'] = "Konwertuj z następującego kodowania:";
$GLOBALS['strEncodingConvert'] = "Konwertuj";
$GLOBALS['strEncodingConvertTest'] = "Konwersja próbna";
$GLOBALS['strConvertThese'] = "Następujące dane zostaną zmienione, jeśli przejdziesz dalej";
$GLOBALS['strAppendCodes'] = "Dołącz kody";
$GLOBALS['strScheduledMaintenanceHasntRun'] = "<b>Planowana konserwacja nie była uruchomiona w ciągu ostatniej godziny. Może to oznaczać, że nie została poprawnie skonfigurowana.</b>";
$GLOBALS['strAutoMantenaceEnabledAndHasntRun'] = "Automatyczna konserwacja jest włączona, ale nie została zastosowana. Automatyczna konserwacja jest stosowana tylko wtedy, gdy ". MAX_PRODUCT_NAME ." wyświetla banery. Dla zapewnienia najlepszej wydajności, należy skonfigurować <a href='". OX_PRODUCT_DOCSURL ."/maintenance' target='_blank'>planowaną konserwację </a>.";
$GLOBALS['strAutoMantenaceDisabledAndHasntRun'] = "Automatyczna konserwacja jest obecnie wyłączona, więc nie zostanie uruchomiona w czasie dostarcznia banerów przez ". MAX_PRODUCT_NAME .". Aby uzystakać maksymalną wydajność skonfiguruj <a href='". OX_PRODUCT_DOCSURL ."/maintenance' target='_blank'>planowaną konserwację</a>. Jednak, jeśli nie zamierzasz skonfigurować <a href='". OX_PRODUCT_DOCSURL ."/maintenance' target='_blank'>planowanej konserwacji</a>, <i>musisz</i> <a href='account-settings-maintenance.php'>>uruchomić konserwację automatyczną</a>, aby mieć pewność, że ". MAX_PRODUCT_NAME ." działa poprawnie.";
$GLOBALS['strAutoMantenaceEnabledAndRunning'] = "Automatyczna konserwacja jest włączona i zostanie wywołana, gdy będzie to konieczne, kiedy ". MAX_PRODUCT_NAME ." wyświetli banery. Jednak dla optymalnej wydajności należy skonfigurować <a href='". OX_PRODUCT_DOCSURL ."/maintenance' target='_blank'>planowaną konserwację</a>.";
$GLOBALS['strAutoMantenaceDisabledAndRunning'] = "Jednakże, automatyczna konserwacja została niedawno wyłączona. Aby upewnić się, że". MAX_PRODUCT_NAME ." działa poprawnie, można skonfigurować <a href='". OX_PRODUCT_DOCSURL ."/maintenance' target='_blank'> planowaną konserwację</a> lub <a href='account-settings-maintenance.php'> ponownie włączyć automatyczną konserwację</a>.<br><br>. Dla optymalnej wydajności, należy skonfigurować <a href='". OX_PRODUCT_DOCSURL ."/maintenance' target='_blank'>planowaną konserwację</a>.";
$GLOBALS['strScheduledMantenaceRunning'] = "<b>Planowana konserwacja działa poprawnie.</b>";
$GLOBALS['strAutomaticMaintenanceHasRun'] = "<b>Automatyczna konserwacja działa poprawnie.</b>";
$GLOBALS['strAutoMantenaceEnabled'] = "Jednakże, automatyczna konserwacja jest nadal włączona. Dla optymalnej wydajności, należy wyłączyć <a href='account-settings-maintenance.php'>automatyczną konserwację</a>.";
$GLOBALS['strAutoMaintenanceDisabled'] = "Automatyczna konserwacja jest wyłączona.";
$GLOBALS['strAutoMaintenanceEnabled'] = "Automatyczna konserwacja jest włączona. Dla optymalnej wydajności zaleca się <a href='settings-admin.php'>wyłączenie automatycznej konserwacji</a>.";
$GLOBALS['strCheckACLs'] = "Sprawdź listy ACL";
$GLOBALS['strScheduledMaintenance'] = "Planowana konserwacja wydaje się działać poprawnie.";
$GLOBALS['strAutoMaintenanceEnabledNotTriggered'] = "Automatyczna konserwacja jest włączona, ale nie została zastosowana. Należy pamiętać, że automatyczna konserwacja jest stosowana tylko wtedy, gdy ". MAX_PRODUCT_NAME ." wyświetla bannery.";
$GLOBALS['strAutoMaintenanceBestPerformance'] = "Dla optymalnej wydajności zaleca się skonfigurowanie <a href='". OX_PRODUCT_DOCSURL ."/maintenance.html' target='_blank'>planowanej konserwacji</a>";
$GLOBALS['strAutoMaintenanceEnabledWilltTrigger'] = "Automatyczna konserwacja jest włączona i będzie uruchamiana co godzinę.";
$GLOBALS['strAutoMaintenanceDisabledMaintenanceRan'] = "Automatyczna konserwacja jest wyłączona, ale zadanie konserwacji niedawno zostało uruchomione. Aby upewnić się, że ". MAX_PRODUCT_NAME ." działa prawidłowo należy również ustawić <a href='http://". OX_PRODUCT_DOCSURL ."/maintenance.html' target='_blank'>planowaną konserwację</a> lub <a href='settings-admin.php'>uruchomić automatyczną konserwację</a>.";
$GLOBALS['strAutoMaintenanceDisabledNotTriggered'] = "Ponadto, automatyczna konserwacja jest wyłączona, więc kiedy ". MAX_PRODUCT_NAME ." wyświetla banery, konserwacja nie jest uruchamian. Jeśli nie planujesz uruchomić <a href='http://". OX_PRODUCT_DOCSURL ."/maintenance.html' target='_blank'>planowanej konserwacji</a>, <a href='settings-admin.php'>musisz włączyć automatyczną konserwację</a>, aby upewnić się, że ". MAX_PRODUCT_NAME ." działa poprawnie.";
$GLOBALS['strAllBannerChannelCompiled'] = "Wszystkie skompilowane wartości limitów dla banerów/kanałów zostały zrekompilowane";
$GLOBALS['strBannerChannelResult'] = "Oto wyniki walidacji skompilowanych limitów dla banerów/kanałów";
$GLOBALS['strChannelCompiledLimitationsValid'] = "Wszystkie skompilowane limity dla kanału są ważne";
$GLOBALS['strBannerCompiledLimitationsValid'] = "Wszystkie skompilowane limity dla banerów są ważne";
$GLOBALS['strErrorsFound'] = "Znaleziono błędy";
$GLOBALS['strRepairCompiledLimitations'] = "Stwierdzono pewne nieprawidłowości powyżej, można naprawić je, korzystając z przycisku poniżej, aby ponownie skompilować ograniczenia dla każdego banera/kanału systemu<br />";
$GLOBALS['strRecompile'] = "Przekompiluj";
$GLOBALS['strAppendCodesDesc'] = "W pewnych okolicznościach mechanizm dostarczania może nie być kompatybilny z kodami dodawanymi do trackerów, użyj tego linku, aby sprawdzić poprawność kodów w bazie danych";
$GLOBALS['strCheckAppendCodes'] = "Sprawdź dołączone kody";
$GLOBALS['strAppendCodesRecompiled'] = "Wszystkie skompilowane wartości dla dodawanych kodów zostały zrekompilowane";
$GLOBALS['strAppendCodesResult'] = "Oto wyniki walidacji skompilowanch kodów dodanych";
$GLOBALS['strAppendCodesValid'] = "Wszystkie skompilowane kody trackera są ważne";
$GLOBALS['strRepairAppenedCodes'] = "Stwierdzono pewne nieprawidłowości powyżej, można naprawić te, korzystając z przycisku poniżej, aby ponownie skompilować kody dodane dla każdego trackera w systemie";
$GLOBALS['strScheduledMaintenanceNotRun'] = "Planowana konserwacja nie była uruchomiona w ciągu ostatnich godzin. Może to oznaczać, że nie wszystko dobrze ustawiłeś.";
$GLOBALS['strDeliveryEngineDisagreeNotice'] = "W pewnych okolicznościach mechanizm dostarczania może nie być kompatybilny z listami ACL dla banerów i kanałów, użyj tego linku, aby sprawdzić poprawność list ACL w bazie danych";
$GLOBALS['strPlugins'] = "Moduły dodatkowe";
$GLOBALS['strServerCommunicationError'] = "<b>Serwer z aktualizacjami nie odpowiada. ".MAX_PRODUCT_NAME." nie może w tym momencie sprawdzić czy dostępna jest bardziej aktualna wersja. Odczekaj kilka minut i spróbuj ponownie</b>";
?>