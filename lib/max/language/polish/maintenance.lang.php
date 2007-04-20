<?php

/*
+---------------------------------------------------------------------------+
| Openads v2.3                                                              |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2007 Openads Ltd                                       |
| For contact details, see: http://www.openads.org/                         |
|                                                                           |
| Copyright (c) 2000-2003 the phpAdsNew developers                          |
| For contact details, see: http://www.phpadsnew.com/                       |
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
$GLOBALS['strChooseSection']			= "Wybierz sekcjê";


// Priority
$GLOBALS['strRecalculatePriority']		= "Przelicz priorytety";
$GLOBALS['strHighPriorityCampaigns']		= "Kampanie o wysokich priorytetach";
$GLOBALS['strAdViewsAssigned']			= "Ods³ony przydzielone";
$GLOBALS['strLowPriorityCampaigns']		= "Kampanie o niskich priorytetach";
$GLOBALS['strPredictedAdViews']			= "Przewidziane Ods³ony";
$GLOBALS['strPriorityDaysRunning']		= "Dostêpnych jest obecnie {days} dni danych statystycznych, na których ".$phpAds_productname." mo¿e bazowaæ swoje dzienne przewidywania. ";
$GLOBALS['strPriorityBasedLastWeek']		= "Predykcja jest oparta na danych z tego i poprzedniego tygodnia. ";
$GLOBALS['strPriorityBasedLastDays']		= "Predykcja jest oparta na danych z kilku ostatnich dni. ";
$GLOBALS['strPriorityBasedYesterday']		= "Predykcja jest oparta na danych z wczoraj. ";
$GLOBALS['strPriorityNoData']			= "Nie ma wystarczaj±cych danych na których mo¿naby oprzeæ przewidywania co o ilo¶ci Ods³on, które ten serwer mo¿e wytworzyæ dzisiaj. Przydzia³y priorytetów bêd± bazowa³y jedynie na chwilowych danych statystycznych. ";
$GLOBALS['strPriorityEnoughAdViews']		= "Powinno wystarczyæ Ods³on aby zapewniæ wykonanie limitów przydzielonych kampaniom o wysokim priorytecie. ";
$GLOBALS['strPriorityNotEnoughAdViews']		= "Nie jest pewne czy wystarczy Ods³on aby zapewniæ wykonanie limitów wszystkich kampanii o wysokim priorytecie. Z tego powodu kampanie o niskim priorytecie zostaj± chwilowo wy³±czone. ";


// Banner cache
$GLOBALS['strRebuildBannerCache']		= "Odbuduj cache bannerów";
$GLOBALS['strBannerCacheExplaination']		= "
	Cache bannerów przechowuje kopiê kodu HTML, który jest wykorzystywany do wy¶wietlania bannera. Korzystaj±c z cache'u bannerów mo¿liwe jest
	przy¶pieszenie ich dostarczania poniewa¿ kod HTML nie musi byæ generowany na nowo przy ka¿dym wywo³aniu. Poniewa¿ cache zawiera
	wpisane adresy URL z lokalizacj± ".$phpAds_productname." i jego bannerów, musi on byæ aktualizowany za ka¿dym razem
	kiedy ".$phpAds_productname." jest przenoszony do innej lokalizacji na serwerze.
";


// Cache
$GLOBALS['strCache']				= "Cache dostarczania";
$GLOBALS['strAge']				= "Wiek";
$GLOBALS['strRebuildDeliveryCache']		= "Odbuduj cache dostarczania";
$GLOBALS['strDeliveryCacheExplaination']	= "
	Cache dostarczania jest wykorzystywany do przyspieszenia wy¶wietlania bannerów. Cache zawiera kopiê wszystkich bannerów,
	które s± pod³±czone do strefy, co pozwala zaoszczêdziæ kilka odwo³añ do bazy danych kiedy bannery s± dostarczane u¿ytkownikówi. Cache
	jest zazwyczaj odbudowywany za ka¿dym razem kiedy zostanie dokonana zmiana w strefie lub jednym z jej bannerów. Mo¿e siê zdarzyæ, ¿e
	cache przestanie byæ aktualny. Z tego powodu jest odbudowywany co godzinê oraz dodatkowo mo¿na go odbudowaæ rêcznie.
";
$GLOBALS['strDeliveryCacheSharedMem']		= "
	Wspó³dzielona pamiêæ jest obecnie wykorzystywana do przechowywania cache'u dostarczania.
";
$GLOBALS['strDeliveryCacheDatabase']		= "
	Baza danych jest obecnie wykorzystywana do przechowywania cache'u dostarczania.
";


// Storage
$GLOBALS['strStorage']				= "Przechowywanie";
$GLOBALS['strMoveToDirectory']			= "Przenie¶ obrazki przechowywane w bazie danych do katalogu";
$GLOBALS['strStorageExplaination']		= "
	Obrazki wykorzystywane przez lokalne bannery s± przechowany w bazie danych lub katalogu. Je¶li przechowujesz je w
	katalogu zmniejszy to obci±¿enie bazy danych i poprawi prêdko¶æ dzia³ania.
";


// Storage
$GLOBALS['strStatisticsExplaination']		= "
	Wybra³e¶ opcjê <i>statystyk skróconych</i>, jednak¿e stare statystyki s± nadal w rozszerzonym formacie.
	Czy chcesz je skonwertowaæ do nowego, skróconego formatu?
";


// Product Updates
$GLOBALS['strSearchingUpdates']			= "Wyszukiwanie aktualizacji. Proszê zaczekaæ...";
$GLOBALS['strAvailableUpdates']			= "Dostêpne aktualizacje";
$GLOBALS['strDownloadZip']			= "¦ci±gnij (.zip)";
$GLOBALS['strDownloadGZip']			= "¦ci±gnij (.tar.gz)";

$GLOBALS['strUpdateAlert']			= "Jest dostêpna nowa wersja ".$phpAds_productname.".                 \\n\\nDo you want to get more information \\nabout this update?";
$GLOBALS['strUpdateAlertSecurity']		= "Jest dostêpna nowa wersja ".$phpAds_productname.".                 \\n\\nIt is highly recommended to upgrade \\nas soon as possible, because this \\nversion contains one or more security fixes.";

$GLOBALS['strUpdateServerDown']			= "
    Z niewiadomego powodu nie jest mo¿liwe pobranie<br />
    	informacji o mo¿liwych aktualizacjach. Spróbuj zrobiæ to pó¼niej.
";

$GLOBALS['strNoNewVersionAvailable']		= "
	Twoja wersja ".$phpAds_productname." jest najbardziej aktualna. Nie ma obecnie ¿adnych nowych aktualizacji.
";

$GLOBALS['strNewVersionAvailable']		= "
	<b>Jest dostêpna nowa wersja ".$phpAds_productname.".</b><br /> Zaleca siê instalacjê tek aktualizacji,
	poniewa¿ mo¿e ona usuwaæ niektóre z istniej±cych problemów i dodawaæ nowe funkcje. Wiêcej informacji
	o aktualizowaniu znajdziesz siê w do³±czonej dokumentacji, znajduj±cej siê w plikach poni¿ej.
";

$GLOBALS['strSecurityUpdate']			= "
	<b>Instalacja tej aktualizacji jest szczególnie zalecana w jak najkrótszym terminie, poniewa¿ zawiera
	istotne poprawki zwi±zane z bezpieczeñstwem.</b> Wersja ".$phpAds_productname.", z któej korzystasz obecnie
	mo¿e byæ podatna na ataki i prawdopodobnie nie jest bezpieczna. Wiêcej informacji o aktualizowaniu
	znajdziesz siê w do³±czonej dokumentacji, znajduj±cej siê w plikach poni¿ej.
";

$GLOBALS['strNotAbleToCheck']			= "
	<b>Poniewa¿ rozszerzenie XML jest niedostêpne na twoim serwerze , ".$phpAds_productname." nie mo¿e
	sprawdziæ, czy jest dostêpna nowsza wersja</b>
";

$GLOBALS['strForUpdatesLookOnWebsite']		= "
	Pracujesz obecnie z wersj± ".$phpAds_productname." ".$phpAds_version_readable.". 
	Je¶li chcesz dowiedzieæ siê, czy jest dostêpna nowsza wersja, zobacz nasz± stronê.
";

$GLOBALS['strClickToVisitWebsite']		= "
	Kliknij aby odwiedziæ nasz± stronê
";


// Stats conversion
$GLOBALS['strConverting']			= "Konwersja";
$GLOBALS['strConvertingStats']			= "Konwertowanie statystyk...";
$GLOBALS['strConvertStats']			= "Konwertuj statystyki";
$GLOBALS['strConvertAdViews']			= "Ods³ony skonwertowane,";
$GLOBALS['strConvertAdClicks']			= "Klikniêcia skonwertowane...";
$GLOBALS['strConvertNothing']			= "Nie ma nic do konwersji...";
$GLOBALS['strConvertFinished']			= "Zakoñczone...";

$GLOBALS['strConvertExplaination']		= "
	U¿ywasz obecnie skróconego formatu statystyk, ale nadal niektóre dane statystyczne s± <br />
	w rozszerzonym formacie. Dopóki nie zostan± one skonwertowane do formatu skróconego <br />
	nie bêd± wykorzystywane podczas przegl±dania tych stron. <br />
	Przed konwersj± statystyk zrób kopiê zapasow± bazy danych! <br />
	Czy chcesz skonwertowaæ rozszczerzone statystyki do nowego, skróconego formatu? <br />
";

$GLOBALS['strConvertingExplaination']		= "
	Wszystkie pozostaj±ce rozszerzone statystyki s± obecnie konwertowane do formatu skróconego. <br />
	Zale¿nie od ilo¶ci danych poddawanych konwersji mo¿e ona potrwaæ do kilkunastu minut. <br />
	Zaczekaj a¿ zostanie ona zakoñczona zanim przejdziesz na inn± stronê. <br />
	Poni¿ej znajduje siê lista wszystkich dokonanych modyfikacji w bazie danych. <br />
";

$GLOBALS['strConvertFinishedExplaination']  	= "
	Konwersja pozosta³ych w formacie rozszerzonym statystyk zosta³a zakoñczona i <br />
	dane mog± byæ teraz znowu wykorzystywane. Poni¿ej znajdziesz listê wszystkich <br />
	zmian dokonanych w bazie danych.<br />
";


?>