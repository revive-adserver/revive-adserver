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
$GLOBALS['strChooseSection']				= "Kies sectie";


// Priority
$GLOBALS['strRecalculatePriority']			= "Prioriteit opnieuw berekenen";
$GLOBALS['strHighPriorityCampaigns']			= "Hoge prioriteit campagnes";
$GLOBALS['strAdViewsAssigned']				= "AdViews toegewezen";
$GLOBALS['strLowPriorityCampaigns']			= "Lage prioriteit campagnes";
$GLOBALS['strPredictedAdViews']				= "Voorspelde AdViews";
$GLOBALS['strPriorityDaysRunning']			= "Er zijn momenteel {days} dagen aan statistieken beschikbaar waar ".MAX_PRODUCT_NAME." zijn dagelijkse voorspellingen op kan baseren. ";
$GLOBALS['strPriorityBasedLastWeek']			= "De voorspelling is gebaseerd op data van deze week en afgelopen week. ";
$GLOBALS['strPriorityBasedLastDays']			= "De voorspelling is gebaseerd op data van de laatste paar dagen. ";
$GLOBALS['strPriorityBasedYesterday']			= "De voorspelling is gebaseerd op data van gisteren. ";
$GLOBALS['strPriorityNoData']				= "Er is niet genoeg data beschikbaar om een betrouwbare voorspelling te doen betreffende het aantal impressies dat deze ad server vandaag zal genereren. De toewijzing van de prioriteit zal op basis van de statistieken van vandaag gebeuren. ";
$GLOBALS['strPriorityEnoughAdViews']			= "Er zijn genoeg AdViews om aan de doelstelling van alle hoge prioriteit campagnes te voldoen. ";
$GLOBALS['strPriorityNotEnoughAdViews']			= "Het is niet zeker dat er vandaag genoeg AdViews zijn om de doelstellingen van alle hoge prioriteit campaignes te halen. Daarom zijn alle lage prioriteit campagnes tijdelijk uitgeschaked. ";


// Banner cache
$GLOBALS['strRebuildBannerCache']			= "Banner cache opnieuw aanmaken";
$GLOBALS['strBannerCacheExplaination']			= "\nDe banner cache bevat een kopie van de HTML code welke gebruikt wordt om de banner tonen. Door het gebruik van de banner cache wordt<br />\nde banner sneller afgeleverd omdat de HTML code niet elke keer opnieuw gegenereerd te worden. Omdat de banner cache vast URLs bevat\n    <ul>\n        <li>naar de locatie van OpenX en de banners,</li>\n    <li>moet de banner cache opnieuwe aangemaakt worden wanneer de locatie van OpenX op de</li>\nserver veranderd.\n    </ul>\n";


// Cache
$GLOBALS['strCache']			= "Leveringscache";
$GLOBALS['strAge']				= "Leeftijd";
$GLOBALS['strRebuildDeliveryCache']			= "Leveringscache opnieuw aanmaken";
$GLOBALS['strDeliveryCacheExplaination']		= "\n	De leveringscache wordt gebruikt om de aflevering van banners te versnellen. De cache bevat een kopie van alle banners welke\n	gekoppeld zijn aan een zone, wat de aflevering versneld omdat de banners niet iedere keer opgehaald hoeven te worden. De cache\n	wordt iedere keer bijgewerkt als de zone of een van de gekoppelde banners gewijzigd wordt. het is echter mogelijk dat de cache\n	soms oude gegevens bevat. Hierom wordt de cache automatisch elk uur bijgewerkt, maar het is ook mogelijk om de cache handmatig bij te werken.\n";
$GLOBALS['strDeliveryCacheSharedMem']		= "\n	Momenteel wordt de cache opgeslagen in gedeeld geheugen.\n";
$GLOBALS['strDeliveryCacheDatabase']		= "\n	Momenteel wordt de cache opgeslagen in de database.\n";
$GLOBALS['strDeliveryCacheFiles']		= "\n	Momenteel wordt de cache opgeslagen in bestanden op de server.\n";


// Storage
$GLOBALS['strStorage']					= "Opslag methoden";
$GLOBALS['strMoveToDirectory']				= "Verplaats afbeeldingen van de database naar een directory";
$GLOBALS['strStorageExplaination']			= "\n	De afbeeldingen welke gebruikt worden door lokale banners worden, of in de database, of in een directory opgeslagen. \n	Indien de afbeeldingen in een directory worden opgeslagen wordt de database minder belast.\n";


// Storage
$GLOBALS['strStatisticsExplaination']			= "\n	U heeft <i>compacte statistieken</i> ingeschakeld, maar er zijn nog enkele oude statistieken beschikbaar\n	in het uitgebreide formaat. Wilt u de oude statistieken converteren naar het compacte formaat?\n";



// Product Updates
$GLOBALS['strSearchingUpdates']				= "Zoeken naar nieuwere versies, een moment geduld a.u.b...";
$GLOBALS['strAvailableUpdates']				= "Beschikbare update";
$GLOBALS['strDownloadZip']				= "Downloaden (.zip)";
$GLOBALS['strDownloadGZip']				= "Downloaden (.tar.gz)";

$GLOBALS['strUpdateAlert']				= "A nieuwe versie van ". MAX_PRODUCT_NAME ." is beschikbaar.                 \n\nWilt u meer informatie over deze\nupdate?";
$GLOBALS['strUpdateAlertSecurity']			= "A nieuwe versie van ". MAX_PRODUCT_NAME ." is beschikbaar.                 \n\nHet wordt aangeraden om uw versie\n bij te werken naar de nieuwste versie omdat \ndeze een of meerdere beveiligingsproblemen oplost.";

$GLOBALS['strUpdateServerDown']				= "\n    Vanwege een onbekende reden is het momenteel niet mogelijk<br />\n    om informatie op te halen over mogelijke updates. Probeer<br />\n    het later nog eens.\n";

$GLOBALS['strNoNewVersionAvailable']			= "\n	Uw versie van ". MAX_PRODUCT_NAME ." is up-to-date. Er zijn momenteel geen nieuwere versies beschikbaar.\n";

$GLOBALS['strNewVersionAvailable']			= "\n	<b>Een nieuwe versie van ". MAX_PRODUCT_NAME ." is beschikbaar.</b><br /> Het wordt aangeraden om de nieuwe\n	versie te installeren omdat deze update bestaande problemen mogelijk zal oplossen. Voor meer informatie\n	over het bijwerken van uw versie kunt het beste de documentatie lezen, welke bijgeleverd is bij de nieuwe versie.\n";

$GLOBALS['strSecurityUpdate']				= "\n	<b>Het wordt ten zeerste aangeraden om deze nieuwe versie zo snel mogelijk te installeren, omdat deze\n	een aantal veiligheidsproblemen oplost.</b> De versie van ". MAX_PRODUCT_NAME ." die u momenteel gebruikt\n	is mogelijk vatbaar voor aanvallen en is waarschijnlijk niet geheel veilig. Voor meer informatie over\n	het bijwerken van uw versie kunt het beste de documentatie lezen, welke bijgeleverd is bij de nieuwe versie.\n";

$GLOBALS['strNotAbleToCheck']			= "\n	<b>Omdat de XML extentie niet aanwezig is op uw server, kan ". MAX_PRODUCT_NAME ." niet controleren of\ner een nieuwere versie beschikbaar is.</b>\n";

$GLOBALS['strForUpdatesLookOnWebsite']	= "\n	Indien u wilt weten of er een nieuwere versie beschikbaar is, kijk dan op onze website.\n";

$GLOBALS['strClickToVisitWebsite']			= "Klik hier om onze website te bezoeken";
$GLOBALS['strCurrentlyUsing'] 				= "U gebruikt momenteel";
$GLOBALS['strRunningOn']				= "draaiend op";
$GLOBALS['strAndPlain']					= "en";



// Stats conversion
$GLOBALS['strConverting']				= "Bezig met converteren...";
$GLOBALS['strConvertingStats']				= "Statistieken aan het converteren...";
$GLOBALS['strConvertStats']				= "Converteer statitieken";
$GLOBALS['strConvertAdViews']				= "AdViews geconverteerd,";
$GLOBALS['strConvertAdClicks']				= "AdClicks geconverteerd...";
$GLOBALS['strConvertNothing']				= "Er zijn geen statistieken aanwezig om te converteren...";
$GLOBALS['strConvertFinished']				= "Klaar...";

$GLOBALS['strConvertExplaination']			= "\n	U gebruikt momenteel het compacte formaat om uw statistieken te bewaren, maar er zijn<br />\n	nog steeds statistieken aanwezig in het uitgebreide formaat. Zolang deze uitgebreide<br />\n	statistieken niet geconverteerd zijn naar het compacte formaat zullen deze niet getoond<br />\n	worden binnen op de overzichtspagina's. Voordat u uw statistieken gaat converteren, maak<br />\n	eerst een backup van de database! Wilt u de uitgebreide statistieken converteren? <br />\n";

$GLOBALS['strConvertingExplaination']			= "\n	Alle uitgebreide statistieken worden nu geconverteerd naar het compate formaat.<br />\n	Afhankelijk van de grootte van de statistieken kan dit enige minuten duren.<br />\n	Wacht tot de gehele conversie klaar is voordat u andere pagina's gaat bekijken.<br />\n	Hieronder ziet een een lijst met alle veranderingen welke gemaakt zijn in de database.<br />\n";

$GLOBALS['strConvertFinishedExplaination']  		= "\n	De conversie van de uitgebreide statistieken is succesvol afgerond en de gegevens<br />\n	zouden nu beschikbaar moeten zijn in alle overzichten. Hieronder vindt u een lijst<br />\n	met alle veranderingen welke gemaakt zijn in de database.<br />\n";




// Note: New translations not found in original lang files but found in CSV
$GLOBALS['strCheckBannerCache'] = "Controleer banner cache";
$GLOBALS['strBannerCacheErrorsFound'] = "De database banner chase controle heeft geen fouten gevonden. De banners zullen niet werken totdat je ze manueel gerepareerd hebt.";
$GLOBALS['strBannerCacheOK'] = "Er zijn geen fouten gevonden. De database banner cache is up to date";
$GLOBALS['strEncodingConvert'] = "Converteer";
$GLOBALS['strErrorsFound'] = "Fouten gevonden";
?>