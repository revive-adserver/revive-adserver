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

$GLOBALS['strAutoMantenaceDisabledAndRunning'] = "	Automatisch onderhoud is echter onlangs uitgeschakeld. Om zeker te stellen dat {$PRODUCT_NAME} goed werkt, zou u ofwel <a href='{$PRODUCT_DOCSURL}/admin/maintenance' target='_blank'>gpeland onderhoud</a> moeten instellen ofwel
	<a href='account-settings-maintenance.php'>automatisch onderhoud</a> opnieuw inschakelen.
	<br><br>
	Voor de beste prestaties, kunt u <a href='{$PRODUCT_DOCSURL}/admin/maintenance' target='_blank'>gepland onderhoud</a> instellen.";

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
$GLOBALS['strBannerCacheExplaination'] = "De banner cache bevat een kopie van de HTML code welke gebruikt wordt om de banner tonen. Door het gebruik van de banner cache wordt<br />
de banner sneller afgeleverd omdat de HTML code niet elke keer opnieuw gegenereerd te worden. Omdat de banner cache vast URLs bevat
    <ul>
        <li>naar de locatie van OpenX en de banners,</li>
    <li>moet de banner cache opnieuwe aangemaakt worden wanneer de locatie van OpenX op de</li>
server veranderd.
    </ul>";

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
$GLOBALS['strEncodingExplaination'] = "{$PRODUCT_NAME} slaat nu alle gegevens in de database op in UTF-8 format.<br />
    Als dat mogelijk was, is uw data automatische geconverteerd naar deze encoding.<br />
    Als u na de upgrade misvormde tekens vindt, en u weet welke encoding gebruikt wordt, dan kunt u dit hulpmiddel gebruiken om de gegevens om te zetten van dat format naar UTF-8";
$GLOBALS['strEncodingConvertFrom'] = "Converteren van deze encoding:";
$GLOBALS['strEncodingConvertTest'] = "Conversie testen";
$GLOBALS['strConvertThese'] = "De volgende gegevens zullen worden gewijzigd als u doorgaat";

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

//  Deliver Limitations
$GLOBALS['strDeliveryLimitations'] = "Leveringsbeperkingen";
$GLOBALS['strAllBannerChannelCompiled'] = "Alle gecompileerde banner/channel limitations zijn opnieuw gecompileerd";
$GLOBALS['strBannerChannelResult'] = "Dit zijn de uitkomsten van de validatie van de gecompileerde banner/channel limitations";
$GLOBALS['strChannelCompiledLimitationsValid'] = "Alle gecompileerde channel limitations zijn valide";
$GLOBALS['strBannerCompiledLimitationsValid'] = "Alle gecompileerde banner limitations zijn valide";
$GLOBALS['strErrorsFound'] = "Fouten gevonden";
$GLOBALS['strRepairCompiledLimitations'] = "Er zijn enkele inconsistenties aangetroffen (zie boven), u kunt deze herstellen met behulp van de onderstaande button, dit zal de gecompileerde limitations voor elke banner/channel in het systeem opnieuw compileren<br />";
$GLOBALS['strRecompile'] = "Opnieuw compileren";
$GLOBALS['strDeliveryEngineDisagreeNotice'] = "Onder bepaalde omstandigheden kan de the delivery engine afwijken van de opgeslagen ACLs voor banners en channels, gebruik de onderstaande link om de ACLs in de database te valideren";
$GLOBALS['strCheckACLs'] = "Check ACLs";

//  Append codes
$GLOBALS['strAppendCodesDesc'] = "In sommige situaties kan de delivery engine afwijkingen aantreffen ten opzichte van de opgeslagen append codes voor trackers, gebruik de onderstaande link om de toegevoegde codes in de database te valideren";
$GLOBALS['strCheckAppendCodes'] = "Controleer toegevoegde codes";
$GLOBALS['strAppendCodesRecompiled'] = "Alle gecompileerde toegevoegde codes zijn opnieuw gecompileerd";
$GLOBALS['strAppendCodesResult'] = "Hier zijn de resultaten van de validatie van de gecompileerde toegevoegde codes";
$GLOBALS['strAppendCodesValid'] = "Alle gecompileerde toegevoegde codes voor trackers zijn in orde";
$GLOBALS['strRepairAppenedCodes'] = "Er zijn enkele inconsistenties gevonden (zie boven), u kunt deze herstellen met de onderstaande knop, dit zal de toegevoegde codes opnieuw compileren voor elke tracker in het systeem";

$GLOBALS['strPlugins'] = "Plugins";
$GLOBALS['strPluginsPrecis'] = "Diagnosticeren en herstellen van problemen met {$PRODUCT_NAME} plugins";

$GLOBALS['strMenus'] = "Menu's";
$GLOBALS['strMenusPrecis'] = "Wederopbouw van de menu-cache";
$GLOBALS['strMenusCachedOk'] = "Menu cache is opnieuw opgebouwd";
