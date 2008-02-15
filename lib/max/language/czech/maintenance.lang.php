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
$GLOBALS['strChooseSection']			= "Vyberte sekci";


// Priority
$GLOBALS['strRecalculatePriority']		= "P�epo��tat prioritu";
$GLOBALS['strHighPriorityCampaigns']		= "Kampan� s vysokou prioritou";
$GLOBALS['strAdViewsAssigned']			= "P�id�l�n�ch zobrazen�";
$GLOBALS['strLowPriorityCampaigns']		= "Kampan� s n�zkou prioritou";
$GLOBALS['strPredictedAdViews']			= "P�edpov�zen�ch zobrazen�";
$GLOBALS['strPriorityDaysRunning']		= "V tuto chv�li jsou k dispozici statistiky za {days} dn� z �eho� ".$phpAds_productname." m�e vytvo�it denn� p�edpov��. ";
$GLOBALS['strPriorityBasedLastWeek']		= "P�edpov�� je zalo�ena na �daj�ch z tohoto a p�edchoz�ho t�dne. ";
$GLOBALS['strPriorityBasedLastDays']		= "P�edpov�� je zalo�ena na �daj�ch z p�edchoz�ch n�kolika dn�. ";
$GLOBALS['strPriorityBasedYesterday']		= "P�edpov�� je zalo�ena na �daj�ch ze v�erej�ka. ";
$GLOBALS['strPriorityNoData']			= "Nen� k dispozici dostatek �daj� pro vytvo�en� d�v�ryhodn� p�edpov�di po�tu impres� pro dne�n� den. P�id�len� priorit bude pr�b�n� upravov�no na z�klad� pr�b�n�ch �daj�. ";
$GLOBALS['strPriorityEnoughAdViews']		= "M�lo by b�t k dispozici dostatek AdViews pro pln� spln�n� kampan� s vysokou prioritou. ";
$GLOBALS['strPriorityNotEnoughAdViews']		= "Nen� jist� �e bude k dispozici dostatek AdViews pro pln� spln�n� kampan� s vysokou prioritou. ";


// Banner cache
$GLOBALS['strRebuildBannerCache']		= "Aktualizovat cache banner�";
$GLOBALS['strBannerCacheExplaination']		= "
	Cache banner� obsahuje kopii HTML k�du kter� se pou��v� pro zobrazen� banneru. Pou�it�m chache banner� je mo�n� doc�lit zrychlen�
	doru�ov�n� banner� proto�e se HTML k�d nemus� generovat poka�d� kdy� m� b�t banner doru�en. Proto�e cache banner� obsahuje pevn� 
	okdazy na URL kde je um�st�no ".$phpAds_productname." a jeho bannery, cache mus� b�t aktualizov�na poka�d�, kdy� dojde k p�esunu
	".$phpAds_productname." do jin�ho um�st�n� na webserveru.
";


// Cache
$GLOBALS['strCache']			= "Cache doru�ov�n�";
$GLOBALS['strAge']				= "St���";
$GLOBALS['strRebuildDeliveryCache']			= "Aktualizovat cache doru�ov�n�";
$GLOBALS['strDeliveryCacheExplaination']		= "
	Cache doru�ov�n� je pou��v�na pro urychlen� doru�ov�n� banner�. Cache obsahuje kopii v�ech banner�
	kter� jsou p�ipojen� k z�n� co� u�et�� n�kolik datab�zov�ch dotaz� a bannery jsou p��mo doru�ov�ny u�ivateli. Cache
	je norm�ln� znovu vytv��ena p�i ka�d� zm�n� z�ny nebo banner� z�ny a pokud je to mo�n� je cache aktualizov�na. Z tohoto
	d�vodu se cache automaticky aktualizuje ka�dou hodinu, ale je mo�n� ji aktualizovat i ru�n�.
";
$GLOBALS['strDeliveryCacheSharedMem']		= "
	V tuto chv�li se pro ukl�d�n� cache doru�ov�n� vyu��v� sd�len� pam�.
";
$GLOBALS['strDeliveryCacheDatabase']		= "
	V tuto chv�li se pro ukl�d�n� cache doru�ov�n� vyu��v� datab�ze.
";
$GLOBALS['strDeliveryCacheFiles']		= "
	V tuto chv�li se pro ukl�d�n� cache doru�ov�n� vyu��v� v�cero soubor� na disku.
";


// Storage
$GLOBALS['strStorage']				= "Ukl�d�n�";
$GLOBALS['strMoveToDirectory']			= "P�esunout obr�zky ulo�en� v datab�zi do adres��e";
$GLOBALS['strStorageExplaination']		= "
	Obr�zky lok�ln�ch banner� jsou ulo�eny v datab�zi nebo v adres��i. Pokud ulo��te soubory do adres��e 
	z�t� datab�ze v�razn� poklesne a zv�� se rychlost doru�ov�n�.
";


// Storage
$GLOBALS['strStatisticsExplaination']		= "
	Zapnul jste form�t <i>kompaktn�ch statistik</i>, ale va�e star� statistiky jsou st�le v detailn�m form�tu. 
	P�ejete si p�ev�st va�e detailn� statistiky do kompaktn�ho form�tu?
";


// Product Updates
$GLOBALS['strSearchingUpdates']			= "Hled�m aktualizace. Pros�m �ekejte...";
$GLOBALS['strAvailableUpdates']			= "Dostupn� aktualizace";
$GLOBALS['strDownloadZip']			= "Download (.zip)";
$GLOBALS['strDownloadGZip']			= "Download (.tar.gz)";

$GLOBALS['strUpdateAlert']			= "Je k dispozici nov� verze ".$phpAds_productname." .                 \\n\\nP�ejete si v�ce informac� o t�t� \\naktualizaci?";
$GLOBALS['strUpdateAlertSecurity']		= "Je k dispozici nov� verze ".$phpAds_productname." .                 \\n\\nD�razn� doporu�ujeme prov�st aktualizaci \\nco nejd��ve, nebo� tato verze obsahuje \\njednu nebo v�ce bezpe�nostn�ch oprav.";

$GLOBALS['strUpdateServerDown']			= "
    Z nezn�m�ho d�vodu nebylo mo�n� z�skat <br>
	informace o aktualizac�ch. Pros�m zkuste to znovu pozd�ji.
";

$GLOBALS['strNoNewVersionAvailable']		= "
	Va�e verze ".$phpAds_productname." je aktu�ln�. V tuto chv�li nejsou k dispozici ��dn� aktualizace.
";

$GLOBALS['strNewVersionAvailable']		= "
	<b>Nov�j�� verze ".$phpAds_productname." je k dispozici.</b><br> Doporu�ujeme nainstalovat tuto aktualizaci,
	proto�e m�e obsahovat opravy n�kter�ch chyb a obsahovat nov� funkce. Pro v�ce informac� o tom jak prov�st
	aktualizaci si pros�m p�e�t�te dokumentaci kter� je v n�e uveden�ch souborech.
";

$GLOBALS['strSecurityUpdate']			= "
	<b>D�razn� doporu�ujeme nainstalovat tuto aktualizaci co nejd��ve, proto�e obsahuje n�kolik oprav
	bezpe�nostn�ch chyb.</b> Verze ".$phpAds_productname." kterou pou��v�te m�e b�t citliv� n� r�zn� 
	druhy �tok� a z�ejm� nen� bezpe�n�. Pro v�ce informac� o tom jak prov�st aktualizaci si pros�m 
	p�e�t�te dokumentaci kter� je v n�e uveden�ch souborech.
";

$GLOBALS['strNotAbleToCheck']			= "
	<b>Proto�e XML dopln�k nen� instalov�n na va�em serveru, ".$phpAds_productname." nen� 
    schopen ov��it zda jsou k dispozici aktualizace.</b>
";

$GLOBALS['strForUpdatesLookOnWebsite']	= "
	Pokud chcete v�d�t jestli je k dispozici nov�j�� verze tak nav�tivte na�e str�nky.
";

$GLOBALS['strClickToVisitWebsite']		= "Klikn�te zde pro na�e webov� str�nky";
$GLOBALS['strCurrentlyUsing'] 			= "V tuto chv�li pou��v�te";
$GLOBALS['strRunningOn']				= "b��c� na";
$GLOBALS['strAndPlain']					= "a";


// Stats conversion
$GLOBALS['strConverting']			= "Prob�h� p�evod";
$GLOBALS['strConvertingStats']			= "P�evod statistik...";
$GLOBALS['strConvertStats']			= "P�eve� statistiky";
$GLOBALS['strConvertAdViews']			= "P�eveden�ch zobrazen�,";
$GLOBALS['strConvertAdClicks']			= "P�eveden�ch kliknut�...";
$GLOBALS['strConvertAdConversions']			= "P�eveden�ch prodej�..."; 
$GLOBALS['strConvertNothing']			= "Nen� nic k p�evodu...";
$GLOBALS['strConvertFinished']			= "Dokon�eno...";

$GLOBALS['strConvertExplaination']		= "
	V tuto chv�li pou��v�te kompaktn� form�t statistik, ale st�le m�te n�kter� statsitiky <br>
	v datailn�m form�tu. Dokud nebudou deatiln� statistiky p�evedny do kompaktn�ho form�tu <br>
	nebudou zobrazov�ny p�i prohl�en� t�to str�nky.  <br>
	P�ed p�evodem statistiky si zaz�lohujte datab�zi!  <br>
	Chcete p�ev�st deatiln� statistiky do kompaktn�ho form�tu? <br>
";

$GLOBALS['strConvertingExplaination']		= "
	V�echny zb�vaj�c� detailn� statistiky jsou p�ev�d�ny do kompaktn�ho form�tu. <br>
	V z�vislosti na po�tu impres� ulo�en�ch v detailn�m form�tu tato akce m�e trvat  <br>
	a� n�kolik minut. Pros�m vy�kejte na ukon�en� p�evodu ne� nav��v�te jin� str�ky. <br>
	N�e m�te seznam v�ech �prav proveden�ch na datab�zi. <br>
";

$GLOBALS['strConvertFinishedExplaination']  	= "
	P�evod zb�vaj�c�ch detailn�ch statistik byl �sp�n� a data by nyn� m�la b�t <br>
	znovu pou�iteln�. N�e m�te seznam v�ech �prav proveden�ch na datab�zi. <br>
";


?>
