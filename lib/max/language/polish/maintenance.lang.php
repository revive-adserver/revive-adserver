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
$GLOBALS['strChooseSection']			= "Wybierz sekcj�";


// Priority
$GLOBALS['strRecalculatePriority']		= "Przelicz priorytety";
$GLOBALS['strHighPriorityCampaigns']		= "Kampanie o wysokich priorytetach";
$GLOBALS['strAdViewsAssigned']			= "Ods�ony przydzielone";
$GLOBALS['strLowPriorityCampaigns']		= "Kampanie o niskich priorytetach";
$GLOBALS['strPredictedAdViews']			= "Przewidziane Ods�ony";
$GLOBALS['strPriorityDaysRunning']		= "Dost�pnych jest obecnie {days} dni danych statystycznych, na kt�rych ".$phpAds_productname." mo�e bazowa� swoje dzienne przewidywania. ";
$GLOBALS['strPriorityBasedLastWeek']		= "Predykcja jest oparta na danych z tego i poprzedniego tygodnia. ";
$GLOBALS['strPriorityBasedLastDays']		= "Predykcja jest oparta na danych z kilku ostatnich dni. ";
$GLOBALS['strPriorityBasedYesterday']		= "Predykcja jest oparta na danych z wczoraj. ";
$GLOBALS['strPriorityNoData']			= "Nie ma wystarczaj�cych danych na kt�rych mo�naby oprze� przewidywania co o ilo�ci Ods�on, kt�re ten serwer mo�e wytworzy� dzisiaj. Przydzia�y priorytet�w b�d� bazowa�y jedynie na chwilowych danych statystycznych. ";
$GLOBALS['strPriorityEnoughAdViews']		= "Powinno wystarczy� Ods�on aby zapewni� wykonanie limit�w przydzielonych kampaniom o wysokim priorytecie. ";
$GLOBALS['strPriorityNotEnoughAdViews']		= "Nie jest pewne czy wystarczy Ods�on aby zapewni� wykonanie limit�w wszystkich kampanii o wysokim priorytecie. Z tego powodu kampanie o niskim priorytecie zostaj� chwilowo wy��czone. ";


// Banner cache
$GLOBALS['strRebuildBannerCache']		= "Odbuduj cache banner�w";
$GLOBALS['strBannerCacheExplaination']		= "
	Cache banner�w przechowuje kopi� kodu HTML, kt�ry jest wykorzystywany do wy�wietlania bannera. Korzystaj�c z cache'u banner�w mo�liwe jest
	przy�pieszenie ich dostarczania poniewa� kod HTML nie musi by� generowany na nowo przy ka�dym wywo�aniu. Poniewa� cache zawiera
	wpisane adresy URL z lokalizacj� ".$phpAds_productname." i jego banner�w, musi on by� aktualizowany za ka�dym razem
	kiedy ".$phpAds_productname." jest przenoszony do innej lokalizacji na serwerze.
";


// Cache
$GLOBALS['strCache']				= "Cache dostarczania";
$GLOBALS['strAge']				= "Wiek";
$GLOBALS['strRebuildDeliveryCache']		= "Odbuduj cache dostarczania";
$GLOBALS['strDeliveryCacheExplaination']	= "
	Cache dostarczania jest wykorzystywany do przyspieszenia wy�wietlania banner�w. Cache zawiera kopi� wszystkich banner�w,
	kt�re s� pod��czone do strefy, co pozwala zaoszcz�dzi� kilka odwo�a� do bazy danych kiedy bannery s� dostarczane u�ytkownik�wi. Cache
	jest zazwyczaj odbudowywany za ka�dym razem kiedy zostanie dokonana zmiana w strefie lub jednym z jej banner�w. Mo�e si� zdarzy�, �e
	cache przestanie by� aktualny. Z tego powodu jest odbudowywany co godzin� oraz dodatkowo mo�na go odbudowa� r�cznie.
";
$GLOBALS['strDeliveryCacheSharedMem']		= "
	Wsp�dzielona pami�� jest obecnie wykorzystywana do przechowywania cache'u dostarczania.
";
$GLOBALS['strDeliveryCacheDatabase']		= "
	Baza danych jest obecnie wykorzystywana do przechowywania cache'u dostarczania.
";


// Storage
$GLOBALS['strStorage']				= "Przechowywanie";
$GLOBALS['strMoveToDirectory']			= "Przenie� obrazki przechowywane w bazie danych do katalogu";
$GLOBALS['strStorageExplaination']		= "
	Obrazki wykorzystywane przez lokalne bannery s� przechowany w bazie danych lub katalogu. Je�li przechowujesz je w
	katalogu zmniejszy to obci��enie bazy danych i poprawi pr�dko�� dzia�ania.
";


// Storage
$GLOBALS['strStatisticsExplaination']		= "
	Wybra�e� opcj� <i>statystyk skr�conych</i>, jednak�e stare statystyki s� nadal w rozszerzonym formacie.
	Czy chcesz je skonwertowa� do nowego, skr�conego formatu?
";


// Product Updates
$GLOBALS['strSearchingUpdates']			= "Wyszukiwanie aktualizacji. Prosz� zaczeka�...";
$GLOBALS['strAvailableUpdates']			= "Dost�pne aktualizacje";
$GLOBALS['strDownloadZip']			= "�ci�gnij (.zip)";
$GLOBALS['strDownloadGZip']			= "�ci�gnij (.tar.gz)";

$GLOBALS['strUpdateAlert']			= "Jest dost�pna nowa wersja ".$phpAds_productname.".                 \\n\\nDo you want to get more information \\nabout this update?";
$GLOBALS['strUpdateAlertSecurity']		= "Jest dost�pna nowa wersja ".$phpAds_productname.".                 \\n\\nIt is highly recommended to upgrade \\nas soon as possible, because this \\nversion contains one or more security fixes.";

$GLOBALS['strUpdateServerDown']			= "
    Z niewiadomego powodu nie jest mo�liwe pobranie<br />
    	informacji o mo�liwych aktualizacjach. Spr�buj zrobi� to p�niej.
";

$GLOBALS['strNoNewVersionAvailable']		= "
	Twoja wersja ".$phpAds_productname." jest najbardziej aktualna. Nie ma obecnie �adnych nowych aktualizacji.
";

$GLOBALS['strNewVersionAvailable']		= "
	<b>Jest dost�pna nowa wersja ".$phpAds_productname.".</b><br /> Zaleca si� instalacj� tek aktualizacji,
	poniewa� mo�e ona usuwa� niekt�re z istniej�cych problem�w i dodawa� nowe funkcje. Wi�cej informacji
	o aktualizowaniu znajdziesz si� w do��czonej dokumentacji, znajduj�cej si� w plikach poni�ej.
";

$GLOBALS['strSecurityUpdate']			= "
	<b>Instalacja tej aktualizacji jest szczeg�lnie zalecana w jak najkr�tszym terminie, poniewa� zawiera
	istotne poprawki zwi�zane z bezpiecze�stwem.</b> Wersja ".$phpAds_productname.", z kt�ej korzystasz obecnie
	mo�e by� podatna na ataki i prawdopodobnie nie jest bezpieczna. Wi�cej informacji o aktualizowaniu
	znajdziesz si� w do��czonej dokumentacji, znajduj�cej si� w plikach poni�ej.
";

$GLOBALS['strNotAbleToCheck']			= "
	<b>Poniewa� rozszerzenie XML jest niedost�pne na twoim serwerze , ".$phpAds_productname." nie mo�e
	sprawdzi�, czy jest dost�pna nowsza wersja</b>
";

$GLOBALS['strForUpdatesLookOnWebsite']		= "
	Pracujesz obecnie z wersj� ".$phpAds_productname." ".$phpAds_version_readable.". 
	Je�li chcesz dowiedzie� si�, czy jest dost�pna nowsza wersja, zobacz nasz� stron�.
";

$GLOBALS['strClickToVisitWebsite']		= "
	Kliknij aby odwiedzi� nasz� stron�
";


// Stats conversion
$GLOBALS['strConverting']			= "Konwersja";
$GLOBALS['strConvertingStats']			= "Konwertowanie statystyk...";
$GLOBALS['strConvertStats']			= "Konwertuj statystyki";
$GLOBALS['strConvertAdViews']			= "Ods�ony skonwertowane,";
$GLOBALS['strConvertAdClicks']			= "Klikni�cia skonwertowane...";
$GLOBALS['strConvertNothing']			= "Nie ma nic do konwersji...";
$GLOBALS['strConvertFinished']			= "Zako�czone...";

$GLOBALS['strConvertExplaination']		= "
	U�ywasz obecnie skr�conego formatu statystyk, ale nadal niekt�re dane statystyczne s� <br />
	w rozszerzonym formacie. Dop�ki nie zostan� one skonwertowane do formatu skr�conego <br />
	nie b�d� wykorzystywane podczas przegl�dania tych stron. <br />
	Przed konwersj� statystyk zr�b kopi� zapasow� bazy danych! <br />
	Czy chcesz skonwertowa� rozszczerzone statystyki do nowego, skr�conego formatu? <br />
";

$GLOBALS['strConvertingExplaination']		= "
	Wszystkie pozostaj�ce rozszerzone statystyki s� obecnie konwertowane do formatu skr�conego. <br />
	Zale�nie od ilo�ci danych poddawanych konwersji mo�e ona potrwa� do kilkunastu minut. <br />
	Zaczekaj a� zostanie ona zako�czona zanim przejdziesz na inn� stron�. <br />
	Poni�ej znajduje si� lista wszystkich dokonanych modyfikacji w bazie danych. <br />
";

$GLOBALS['strConvertFinishedExplaination']  	= "
	Konwersja pozosta�ych w formacie rozszerzonym statystyk zosta�a zako�czona i <br />
	dane mog� by� teraz znowu wykorzystywane. Poni�ej znajdziesz list� wszystkich <br />
	zmian dokonanych w bazie danych.<br />
";


?>