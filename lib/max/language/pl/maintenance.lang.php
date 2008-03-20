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

// Main strings
$GLOBALS['strChooseSection']			= "Wybierz sekcję";


// Priority
$GLOBALS['strRecalculatePriority']		= "Przelicz priorytety";
$GLOBALS['strHighPriorityCampaigns']		= "Kampanie o wysokich priorytetach";
$GLOBALS['strAdViewsAssigned']			= "Odsłony przydzielone";
$GLOBALS['strLowPriorityCampaigns']		= "Kampanie o niskich priorytetach";
$GLOBALS['strPredictedAdViews']			= "Przewidziane Odsłony";
$GLOBALS['strPriorityDaysRunning']		= "Dostępnych jest obecnie {days} dni danych statystycznych, na których ".$phpAds_productname." może bazować swoje dzienne przewidywania. ";
$GLOBALS['strPriorityBasedLastWeek']		= "Predykcja jest oparta na danych z tego i poprzedniego tygodnia. ";
$GLOBALS['strPriorityBasedLastDays']		= "Predykcja jest oparta na danych z kilku ostatnich dni. ";
$GLOBALS['strPriorityBasedYesterday']		= "Predykcja jest oparta na danych z wczoraj. ";
$GLOBALS['strPriorityNoData']			= "Nie ma wystarczających danych na których możnaby oprzeć przewidywania co o ilości Odsłon, które ten serwer może wytworzyć dzisiaj. Przydziały priorytetów będą bazowały jedynie na chwilowych danych statystycznych. ";
$GLOBALS['strPriorityEnoughAdViews']		= "Powinno wystarczyć Odsłon aby zapewnić wykonanie limitów przydzielonych kampaniom o wysokim priorytecie. ";
$GLOBALS['strPriorityNotEnoughAdViews']		= "Nie jest pewne czy wystarczy Odsłon aby zapewnić wykonanie limitów wszystkich kampanii o wysokim priorytecie. Z tego powodu kampanie o niskim priorytecie zostają chwilowo wyłączone. ";


// Banner cache
$GLOBALS['strRebuildBannerCache']		= "Odbuduj cache bannerów";
$GLOBALS['strBannerCacheExplaination']		= "
	Cache bannerów przechowuje kopię kodu HTML, który jest wykorzystywany do wyświetlania bannera. Korzystając z cache'u bannerów możliwe jest
	przyśpieszenie ich dostarczania ponieważ kod HTML nie musi być generowany na nowo przy każdym wywołaniu. Ponieważ cache zawiera
	wpisane adresy URL z lokalizacją ".$phpAds_productname." i jego bannerów, musi on być aktualizowany za każdym razem
	kiedy ".$phpAds_productname." jest przenoszony do innej lokalizacji na serwerze.
";


// Cache
$GLOBALS['strCache']				= "Cache dostarczania";
$GLOBALS['strAge']				= "Wiek";
$GLOBALS['strRebuildDeliveryCache']		= "Odbuduj cache dostarczania";
$GLOBALS['strDeliveryCacheExplaination']	= "
	Cache dostarczania jest wykorzystywany do przyspieszenia wyświetlania bannerów. Cache zawiera kopię wszystkich bannerów,
	które są podłączone do strefy, co pozwala zaoszczędzić kilka odwołań do bazy danych kiedy bannery są dostarczane użytkownikówi. Cache
	jest zazwyczaj odbudowywany za każdym razem kiedy zostanie dokonana zmiana w strefie lub jednym z jej bannerów. Może się zdarzyć, że
	cache przestanie być aktualny. Z tego powodu jest odbudowywany co godzinę oraz dodatkowo można go odbudować ręcznie.
";
$GLOBALS['strDeliveryCacheSharedMem']		= "
	Współdzielona pamięć jest obecnie wykorzystywana do przechowywania cache'u dostarczania.
";
$GLOBALS['strDeliveryCacheDatabase']		= "
	Baza danych jest obecnie wykorzystywana do przechowywania cache'u dostarczania.
";


// Storage
$GLOBALS['strStorage']				= "Przechowywanie";
$GLOBALS['strMoveToDirectory']			= "Przenieś obrazki przechowywane w bazie danych do katalogu";
$GLOBALS['strStorageExplaination']		= "
	Obrazki wykorzystywane przez lokalne bannery są przechowany w bazie danych lub katalogu. Jeśli przechowujesz je w
	katalogu zmniejszy to obciążenie bazy danych i poprawi prędkość działania.
";


// Storage
$GLOBALS['strStatisticsExplaination']		= "
	Wybrałeś opcję <i>statystyk skróconych</i>, jednakże stare statystyki są nadal w rozszerzonym formacie.
	Czy chcesz je skonwertować do nowego, skróconego formatu?
";


// Product Updates
$GLOBALS['strSearchingUpdates']			= "Wyszukiwanie aktualizacji. Proszę zaczekać...";
$GLOBALS['strAvailableUpdates']			= "Dostępne aktualizacje";
$GLOBALS['strDownloadZip']			= "Ściągnij (.zip)";
$GLOBALS['strDownloadGZip']			= "Ściągnij (.tar.gz)";

$GLOBALS['strUpdateAlert']			= "Jest dostępna nowa wersja ".$phpAds_productname.".                 \\n\\nDo you want to get more information \\nabout this update?";
$GLOBALS['strUpdateAlertSecurity']		= "Jest dostępna nowa wersja ".$phpAds_productname.".                 \\n\\nIt is highly recommended to upgrade \\nas soon as possible, because this \\nversion contains one or more security fixes.";

$GLOBALS['strUpdateServerDown']			= "
    Z niewiadomego powodu nie jest możliwe pobranie<br />
    	informacji o możliwych aktualizacjach. Spróbuj zrobić to później.
";

$GLOBALS['strNoNewVersionAvailable']		= "
	Twoja wersja ".$phpAds_productname." jest najbardziej aktualna. Nie ma obecnie żadnych nowych aktualizacji.
";

$GLOBALS['strNewVersionAvailable']		= "
	<b>Jest dostępna nowa wersja ".$phpAds_productname.".</b><br /> Zaleca się instalację tek aktualizacji,
	ponieważ może ona usuwać niektóre z istniejących problemów i dodawać nowe funkcje. Więcej informacji
	o aktualizowaniu znajdziesz się w dołączonej dokumentacji, znajdującej się w plikach poniżej.
";

$GLOBALS['strSecurityUpdate']			= "
	<b>Instalacja tej aktualizacji jest szczególnie zalecana w jak najkrótszym terminie, ponieważ zawiera
	istotne poprawki związane z bezpieczeństwem.</b> Wersja ".$phpAds_productname.", z któej korzystasz obecnie
	może być podatna na ataki i prawdopodobnie nie jest bezpieczna. Więcej informacji o aktualizowaniu
	znajdziesz się w dołączonej dokumentacji, znajdującej się w plikach poniżej.
";

$GLOBALS['strNotAbleToCheck']			= "
	<b>Ponieważ rozszerzenie XML jest niedostępne na twoim serwerze , ".$phpAds_productname." nie może
	sprawdzić, czy jest dostępna nowsza wersja</b>
";

$GLOBALS['strForUpdatesLookOnWebsite']		= "
	Pracujesz obecnie z wersją ".$phpAds_productname." ".$phpAds_version_readable.". 
	Jeśli chcesz dowiedzieć się, czy jest dostępna nowsza wersja, zobacz naszą stronę.
";

$GLOBALS['strClickToVisitWebsite']		= "
	Kliknij aby odwiedzić naszą stronę
";


// Stats conversion
$GLOBALS['strConverting']			= "Konwersja";
$GLOBALS['strConvertingStats']			= "Konwertowanie statystyk...";
$GLOBALS['strConvertStats']			= "Konwertuj statystyki";
$GLOBALS['strConvertAdViews']			= "Odsłony skonwertowane,";
$GLOBALS['strConvertAdClicks']			= "Kliknięcia skonwertowane...";
$GLOBALS['strConvertNothing']			= "Nie ma nic do konwersji...";
$GLOBALS['strConvertFinished']			= "Zakończone...";

$GLOBALS['strConvertExplaination']		= "
	Używasz obecnie skróconego formatu statystyk, ale nadal niektóre dane statystyczne są <br />
	w rozszerzonym formacie. Dopóki nie zostaną one skonwertowane do formatu skróconego <br />
	nie będą wykorzystywane podczas przeglądania tych stron. <br />
	Przed konwersją statystyk zrób kopię zapasową bazy danych! <br />
	Czy chcesz skonwertować rozszczerzone statystyki do nowego, skróconego formatu? <br />
";

$GLOBALS['strConvertingExplaination']		= "
	Wszystkie pozostające rozszerzone statystyki są obecnie konwertowane do formatu skróconego. <br />
	Zależnie od ilości danych poddawanych konwersji może ona potrwać do kilkunastu minut. <br />
	Zaczekaj aż zostanie ona zakończona zanim przejdziesz na inną stronę. <br />
	Poniżej znajduje się lista wszystkich dokonanych modyfikacji w bazie danych. <br />
";

$GLOBALS['strConvertFinishedExplaination']  	= "
	Konwersja pozostałych w formacie rozszerzonym statystyk została zakończona i <br />
	dane mogą być teraz znowu wykorzystywane. Poniżej znajdziesz listę wszystkich <br />
	zmian dokonanych w bazie danych.<br />
";


?>