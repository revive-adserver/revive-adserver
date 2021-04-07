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





$GLOBALS['strScheduledMantenaceRunning'] = "<b>Gepland onderhoud wordt correct uitgevoerd.</b>";

$GLOBALS['strAutomaticMaintenanceHasRun'] = "<b>Automatisch onderhoud wordt correct uitgevoerd.</b>";

$GLOBALS['strAutoMantenaceEnabled'] = "Automatisch onderhoud is echter nog steeds ingeschakeld. Voor de beste prestaties moet u <a href='account-settings-maintenance.php'>automatisch onderhoud</a> uitschakelen.";

// Priority
$GLOBALS['strRecalculatePriority'] = "Prioriteit opnieuw berekenen";

// Banner cache
$GLOBALS['strCheckBannerCache'] = "Controleer banner cache";
$GLOBALS['strBannerCacheErrorsFound'] = "De database banner chase controle heeft enkele fouten gevonden. De banners zullen niet werken totdat u ze handmatig gerepareerd hebt.";
$GLOBALS['strBannerCacheOK'] = "Er zijn geen fouten gevonden. De database banner cache is up to date";
$GLOBALS['strBannerCacheDifferencesFound'] = "De controle van de database banner cache heeft opgeleverd dat de cache niet up to date is, en opnieuw moet worden opgebouwd. Click hier om de cache automatisch bij te werken.";
$GLOBALS['strBannerCacheRebuildButton'] = "Opnieuw opbouwen";
$GLOBALS['strRebuildDeliveryCache'] = "Leveringscache opnieuw aanmaken";

// Cache
$GLOBALS['strCache'] = "Leveringscache";
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
$GLOBALS['strEncodingConvertFrom'] = "Converteren van deze encoding:";
$GLOBALS['strEncodingConvertTest'] = "Conversie testen";
$GLOBALS['strConvertThese'] = "De volgende gegevens zullen worden gewijzigd als u doorgaat";

// Product Updates
$GLOBALS['strSearchingUpdates'] = "Zoeken naar nieuwere versies, een moment geduld a.u.b...";
$GLOBALS['strAvailableUpdates'] = "Beschikbare update";
$GLOBALS['strDownloadZip'] = "Downloaden (.zip)";
$GLOBALS['strDownloadGZip'] = "Downloaden (.tar.gz)";


$GLOBALS['strUpdateServerDown'] = "    Vanwege een onbekende reden is het momenteel niet mogelijk<br />
    om informatie op te halen over mogelijke updates. Probeer<br />
    het later nog eens.";



$GLOBALS['strCheckForUpdatesDisabled'] = "    <b>De controle op updates is uitgeschakeld. Schakel het svp in via het 
    <a href='account-settings-update.php'>Instellingen aanpassen</a> scherm.</b>";




$GLOBALS['strForUpdatesLookOnWebsite'] = "	Indien u wilt weten of er een nieuwere versie beschikbaar is, kijk dan op onze website.";

$GLOBALS['strClickToVisitWebsite'] = "Klik hier om onze website te bezoeken";
$GLOBALS['strCurrentlyUsing'] = "U gebruikt momenteel";
$GLOBALS['strRunningOn'] = "draaiend op";
$GLOBALS['strAndPlain'] = "en";

//  Deliver Limitations
$GLOBALS['strDeliveryLimitations'] = "Uitleveringsregels";
$GLOBALS['strAllBannerChannelCompiled'] = "Alle uitleveringsregels voor banners en verzamelingen zijn opnieuw gecompileerd";
$GLOBALS['strBannerChannelResult'] = "Dit zijn de resultaten van de controle van de gecompileerde uitleveringsregels van banners en verzamelingen";
$GLOBALS['strChannelCompiledLimitationsValid'] = "Alle gecompileerde uitleveringsregels in verzamelingen uitleveringsregels zijn geldig";
$GLOBALS['strBannerCompiledLimitationsValid'] = "Alle gecompileerde uitleveringsregels van banners zijn geldig";
$GLOBALS['strErrorsFound'] = "Fouten gevonden";
$GLOBALS['strRepairCompiledLimitations'] = "Er zijn enkele inconsistenties aangetroffen (zie boven), u kunt deze herstellen met de onderstaande knop, dit zal de de gecompileerde uitleveringsregels voor alle banners en alle verzamelingen opnieuw compileren<br />";
$GLOBALS['strRecompile'] = "Opnieuw compileren";
$GLOBALS['strDeliveryEngineDisagreeNotice'] = "Onder bepaalde omstandigheden kunnen er verschillen zijn tussen de opgeslagen uitleveringsregels voor banners en verzamelingen, gebruik de volgende link om de uitleveringsregels in de database te valideren";
$GLOBALS['strCheckACLs'] = "Controleer Uitleveringsregels";

//  Append codes
$GLOBALS['strAppendCodesDesc'] = "In sommige situaties kan de delivery engine afwijkingen aantreffen ten opzichte van de opgeslagen append codes voor trackers, gebruik de onderstaande link om de toegevoegde codes in de database te valideren";
$GLOBALS['strCheckAppendCodes'] = "Controleer toegevoegde codes";
$GLOBALS['strAppendCodesRecompiled'] = "Alle gecompileerde toegevoegde codes zijn opnieuw gecompileerd";
$GLOBALS['strAppendCodesResult'] = "Hier zijn de resultaten van de validatie van de gecompileerde toegevoegde codes";
$GLOBALS['strAppendCodesValid'] = "Alle gecompileerde toegevoegde codes voor trackers zijn in orde";
$GLOBALS['strRepairAppenedCodes'] = "Er zijn enkele inconsistenties gevonden (zie boven), u kunt deze herstellen met de onderstaande knop, dit zal de toegevoegde codes opnieuw compileren voor elke tracker in het systeem";

$GLOBALS['strPlugins'] = "Plugins";

$GLOBALS['strMenus'] = "Menu's";
$GLOBALS['strMenusPrecis'] = "Wederopbouw van de menu-cache";
$GLOBALS['strMenusCachedOk'] = "Menu cache is opnieuw opgebouwd";
