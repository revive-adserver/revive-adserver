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
$GLOBALS['strChooseSection'] = "Kies sectie";
$GLOBALS['strAppendCodes'] = "Codes toevoegen";

// Maintenance
$GLOBALS['strScheduledMaintenanceHasntRun'] = "<b>Gepland onderhoud is in het afgelopen uur niet uitgevoerd. Dit kan betekenen dat u het niet correct hebt ingesteld.</b>";

$GLOBALS['strAutoMantenaceEnabledAndHasntRun'] = "	Automatisch onderhoud is ingeschakeld, maar het is nog niet geactiveerd. Automatisch onderhoud wordt alleen geactiveerd als {$PRODUCT_NAME} banners vertoond.
    Voor de beste prestaties, kunt u beter <a href='{$PRODUCT_DOCSURL}/admin/maintenance' target='_blank'>gepland onderhoud</a> instellen.";

$GLOBALS['strAutoMantenaceDisabledAndHasntRun'] = "	Automatisch onderhoud is momenteel uitgeschakeld, dus als {$PRODUCT_NAME} banners vertoond, zal automatisch onderhoud niet worden geactiveerd.
	Voor de beste prestaties, zou u <a href='{$PRODUCT_DOCSURL}/admin/maintenance' target='_blank'>gepland onderhoud</a> moeten inschakelen.
    Als u echter <a href='{$PRODUCT_DOCSURL}/admin/maintenance' target='_blank'>gepland onderhoud</a> niet inschakelt,
    dan <i>must</i> u <a href='account-settings-maintenance.php'>automatisch onderhoud inschakelen</a> om er voor te zorgen dat {$PRODUCT_NAME} goed werkt.";

$GLOBALS['strAutoMantenaceEnabledAndRunning'] = "	Automatisch onderhoud is ingeschakeld en zal worden geactiveerd, indien nodig, wanneer {$PRODUCT_NAME} banners vertoond.
	Voor de beste prestaties, zou u <a href='{$PRODUCT_DOCSURL}/admin/maintenance' target='_blank'>gepland onderhoud</a> moeten inschakelen.";


$GLOBALS['strScheduledMantenaceRunning'] = "<b>Gepland onderhoud wordt correct uitgevoerd.</b>";

$GLOBALS['strAutomaticMaintenanceHasRun'] = "<b>Automatisch onderhoud wordt correct uitgevoerd.</b>";



// Priority
$GLOBALS['strRecalculatePriority'] = "Prioriteit opnieuw berekenen";
$GLOBALS['strHighPriorityCampaigns'] = "Hoge prioriteit campagnes";
$GLOBALS['strAdViewsAssigned'] = "AdViews toegewezen";
$GLOBALS['strLowPriorityCampaigns'] = "Lage prioriteit campagnes";
$GLOBALS['strPredictedAdViews'] = "Voorspelde AdViews";
$GLOBALS['strPriorityDaysRunning'] = "Er zijn momenteel {days} dagen aan statistieken beschikbaar waar {$PRODUCT_NAME} zijn dagelijkse voorspellingen op kan baseren. ";
$GLOBALS['strPriorityBasedLastWeek'] = "De voorspelling is gebaseerd op data van deze week en afgelopen week. ";
$GLOBALS['strPriorityBasedLastDays'] = "De voorspelling is gebaseerd op data van de laatste paar dagen. ";
$GLOBALS['strPriorityBasedYesterday'] = "De voorspelling is gebaseerd op data van gisteren. ";
$GLOBALS['strPriorityNoData'] = "Er is niet genoeg data beschikbaar om een betrouwbare voorspelling te doen betreffende het aantal impressies dat deze ad server vandaag zal genereren. De toewijzing van de prioriteit zal op basis van de statistieken van vandaag gebeuren. ";
$GLOBALS['strPriorityEnoughAdViews'] = "Er zijn genoeg AdViews om aan de doelstelling van alle hoge prioriteit campagnes te voldoen. ";
$GLOBALS['strPriorityNotEnoughAdViews'] = "Het is niet zeker dat er vandaag genoeg AdViews zijn om de doelstellingen van alle hoge prioriteit campaignes te halen. Daarom zijn alle lage prioriteit campagnes tijdelijk uitgeschaked. ";


// Banner cache
$GLOBALS['strCheckBannerCache'] = "Controleer banner cache";
$GLOBALS['strRebuildBannerCache'] = "Banner cache opnieuw aanmaken";
$GLOBALS['strBannerCacheErrorsFound'] = "De database banner chase controle heeft enkele fouten gevonden. De banners zullen niet werken totdat u ze handmatig gerepareerd hebt.";
$GLOBALS['strBannerCacheOK'] = "Er zijn geen fouten gevonden. De database banner cache is up to date";
$GLOBALS['strBannerCacheDifferencesFound'] = "De controle van de database banner cache heeft opgeleverd dat de cache niet up to date is, en opnieuw moet worden opgebouwd. Click hier om de cache automatisch bij te werken.";
$GLOBALS['strBannerCacheFixed'] = "De banner cache in de database is met succes opnieuw opgebouwd. De database cache is nu bijgewerkt.";
$GLOBALS['strBannerCacheRebuildButton'] = "Opnieuw opbouwen";
$GLOBALS['strRebuildDeliveryCache'] = "Leveringscache opnieuw aanmaken";
$GLOBALS['strBannerCacheExplaination'] = "De banner cache bevat een kopie van de HTML code welke gebruikt wordt om de banner tonen. Door het gebruik van de banner cache wordt<br />
de banner sneller afgeleverd omdat de HTML code niet elke keer opnieuw gegenereerd te worden. Omdat de banner cache vast URLs bevat
    <ul>
        <li>naar de locatie van OpenX en de banners,</li>
    <li>moet de banner cache opnieuwe aangemaakt worden wanneer de locatie van OpenX op de</li>
server veranderd.
    </ul>";

// Cache
$GLOBALS['strCache'] = "Leveringscache";
$GLOBALS['strAge'] = "Leeftijd";
$GLOBALS['strDeliveryCacheSharedMem'] = "	Momenteel wordt de cache opgeslagen in gedeeld geheugen.";
$GLOBALS['strDeliveryCacheDatabase'] = "	Momenteel wordt de cache opgeslagen in de database.";
$GLOBALS['strDeliveryCacheFiles'] = "	Momenteel wordt de cache opgeslagen in bestanden op de server.";


// Storage
$GLOBALS['strStorage'] = "Opslag";
$GLOBALS['strMoveToDirectory'] = "Verplaats afbeeldingen van de database naar een directory";
$GLOBALS['strStorageExplaination'] = "	De afbeeldingen welke gebruikt worden door lokale banners worden, of in de database, of in een directory opgeslagen.
	Indien de afbeeldingen in een directory worden opgeslagen wordt de database minder belast.";

// Encoding
$GLOBALS['strEncoding'] = "Codering";
$GLOBALS['strEncodingConvert'] = "Converteer";
$GLOBALS['strConvertThese'] = "De volgende gegevens zullen worden gewijzigd als u doorgaat";


// Storage
$GLOBALS['strStatisticsExplaination'] = "	U heeft <i>compacte statistieken</i> ingeschakeld, maar er zijn nog enkele oude statistieken beschikbaar
	in het uitgebreide formaat. Wilt u de oude statistieken converteren naar het compacte formaat?";


// Product Updates
$GLOBALS['strSearchingUpdates'] = "Zoeken naar nieuwere versies, een moment geduld a.u.b...";
$GLOBALS['strAvailableUpdates'] = "Beschikbare update";
$GLOBALS['strDownloadZip'] = "Downloaden (.zip)";
$GLOBALS['strDownloadGZip'] = "Downloaden (.tar.gz)";

$GLOBALS['strUpdateAlert'] = "A nieuwe versie van {$PRODUCT_NAME} is beschikbaar.\\n\\nWilt u meer informatie \\nover deze update?";
$GLOBALS['strUpdateAlertSecurity'] = "A nieuwe versie van {$PRODUCT_NAME} is beschikbaar.

Het wordt aangeraden om uw versie
 bij te werken naar de nieuwste versie omdat
deze een of meerdere beveiligingsproblemen oplost.";

$GLOBALS['strUpdateServerDown'] = "    Vanwege een onbekende reden is het momenteel niet mogelijk<br />
    om informatie op te halen over mogelijke updates. Probeer<br />
    het later nog eens.";

$GLOBALS['strNoNewVersionAvailable'] = "	Uw versie van {$PRODUCT_NAME} is up-to-date. Er zijn momenteel geen nieuwere versies beschikbaar.";

$GLOBALS['strServerCommunicationError'] = "    <b>De communicatie met de update server is niet gelukt, daarom kan {$PRODUCT_NAME} niet controleren of er nu een nieuwere versie beschikbaar is. Probeer het later nogmaals.</b>";

$GLOBALS['strCheckForUpdatesDisabled'] = "    <b>De controle op updates is uitgeschakeld. Schakel het svp in via het 
    <a href='account-settings-update.php'>Instellingen aanpassen</a> scherm.</b>";

$GLOBALS['strNewVersionAvailable'] = "	<b>Een nieuwe versie van {$PRODUCT_NAME} is beschikbaar.</b><br /> Het wordt aangeraden om de nieuwe
	versie te installeren omdat deze update bestaande problemen mogelijk zal oplossen. Voor meer informatie
	over het bijwerken van uw versie kunt het beste de documentatie lezen, welke bijgeleverd is bij de nieuwe versie.";

$GLOBALS['strSecurityUpdate'] = "	<b>Het wordt ten zeerste aangeraden om deze nieuwe versie zo snel mogelijk te installeren, omdat deze
	een aantal veiligheidsproblemen oplost.</b> De versie van {$PRODUCT_NAME} die u momenteel gebruikt
	is mogelijk vatbaar voor aanvallen en is waarschijnlijk niet geheel veilig. Voor meer informatie over
	het bijwerken van uw versie kunt het beste de documentatie lezen, welke bijgeleverd is bij de nieuwe versie.";

$GLOBALS['strNotAbleToCheck'] = "	<b>Omdat de XML extentie niet aanwezig is op uw server, kan {$PRODUCT_NAME} niet controleren of
er een nieuwere versie beschikbaar is.</b>";

$GLOBALS['strForUpdatesLookOnWebsite'] = "	Indien u wilt weten of er een nieuwere versie beschikbaar is, kijk dan op onze website.";

$GLOBALS['strClickToVisitWebsite'] = "Klik hier om onze website te bezoeken";
$GLOBALS['strCurrentlyUsing'] = "U gebruikt momenteel";
$GLOBALS['strRunningOn'] = "draaiend op";
$GLOBALS['strAndPlain'] = "en";


// Stats conversion
$GLOBALS['strConverting'] = "Bezig met converteren...";
$GLOBALS['strConvertingStats'] = "Statistieken aan het converteren...";
$GLOBALS['strConvertStats'] = "Converteer statitieken";
$GLOBALS['strConvertAdViews'] = "AdViews geconverteerd,";
$GLOBALS['strConvertAdClicks'] = "AdClicks geconverteerd...";
$GLOBALS['strConvertNothing'] = "Er zijn geen statistieken aanwezig om te converteren...";
$GLOBALS['strConvertFinished'] = "Klaar...";

$GLOBALS['strConvertExplaination'] = "	U gebruikt momenteel het compacte formaat om uw statistieken te bewaren, maar er zijn<br />
	nog steeds statistieken aanwezig in het uitgebreide formaat. Zolang deze uitgebreide<br />
	statistieken niet geconverteerd zijn naar het compacte formaat zullen deze niet getoond<br />
	worden binnen op de overzichtspagina's. Voordat u uw statistieken gaat converteren, maak<br />
	eerst een backup van de database! Wilt u de uitgebreide statistieken converteren? <br />";

$GLOBALS['strConvertingExplaination'] = "	Alle uitgebreide statistieken worden nu geconverteerd naar het compate formaat.<br />
	Afhankelijk van de grootte van de statistieken kan dit enige minuten duren.<br />
	Wacht tot de gehele conversie klaar is voordat u andere pagina's gaat bekijken.<br />
	Hieronder ziet een een lijst met alle veranderingen welke gemaakt zijn in de database.<br />";

$GLOBALS['strConvertFinishedExplaination'] = "	De conversie van de uitgebreide statistieken is succesvol afgerond en de gegevens<br />
	zouden nu beschikbaar moeten zijn in alle overzichten. Hieronder vindt u een lijst<br />
	met alle veranderingen welke gemaakt zijn in de database.<br />";

//  Maintenace
$GLOBALS['strAutoMaintenanceDisabled'] = "Automatisch onderhoud is uitgeschakeld.";
$GLOBALS['strAutoMaintenanceEnabled'] = "Automatisch onderhoud is ingeschakeld. Voor de beste prestaties is het aan te bevelen om <a href='settings-admin.php'>automatisch onderhoud uit te schakelen</a>.";
$GLOBALS['strScheduledMaintenance'] = "Gepland onderhoud lijkt correct worden uitgevoerd.";
$GLOBALS['strScheduledMaintenanceNotRun'] = "Gepland onderhoud is in het afgelopen uur niet uitgevoerd. Dit kan betekenen dat u het niet correct hebt ingesteld.";
$GLOBALS['strAutoMaintenanceEnabledNotTriggered'] = "Automatisch onderhoud is ingeschakeld, maar nog niet geactiveerd. Denk er om dat automatisch onderhoud alleen wordt geactiveerd als Openads banners vertoond.";
$GLOBALS['strAutoMaintenanceEnabledWilltTrigger'] = "Automatisch onderhoud is ingeschakeld en zal elk uur het onderhoudsproces activeren.";

//  Deliver Limitations
$GLOBALS['strAllBannerChannelCompiled'] = "Alle gecompileerde banner/channel limitations zijn opnieuw gecompileerd";
$GLOBALS['strBannerChannelResult'] = "Dit zijn de uitkomsten van de validatie van de gecompileerde banner/channel limitations";
$GLOBALS['strChannelCompiledLimitationsValid'] = "Alle gecompileerde channel limitations zijn valide";
$GLOBALS['strBannerCompiledLimitationsValid'] = "Alle gecompileerde banner limitations zijn valide";
$GLOBALS['strErrorsFound'] = "Fouten gevonden";
$GLOBALS['strRepairCompiledLimitations'] = "Er zijn enkele inconsistenties aangetroffen (zie boven), u kunt deze herstellen met behulp van de onderstaande button, dit zal de gecompileerde limitations voor elke banner/channel in het systeem opnieuw compileren<br />";
$GLOBALS['strRecompile'] = "Opnieuw compileren";


//  Append codes

$GLOBALS['strPlugins'] = "Plugins";
$GLOBALS['strPluginsPrecis'] = "Diagnosticeren en herstellen van problemen met {$PRODUCT_NAME} plugins";
$GLOBALS['strPluginsOk'] = "Geen problemen gevonden";

$GLOBALS['strMenus'] = "Menu's";
$GLOBALS['strMenusPrecis'] = "Wederopbouw van de menu-cache";
$GLOBALS['strMenusCachedOk'] = "Menu cache is opnieuw opgebouwd";
