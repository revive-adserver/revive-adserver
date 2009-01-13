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

// Installer translation strings
$GLOBALS['strInstall']				= "Installatie";
$GLOBALS['strChooseInstallLanguage']		= "Kies een taal voor de installatie procedure";
$GLOBALS['strLanguageSelection']		= "Taal selectie";
$GLOBALS['strDatabaseSettings']			= "Database instellingen";
$GLOBALS['strAdminSettings']			= "Administrator instellingen";
$GLOBALS['strAdvancedSettings']			= "Geavanceerde instellingen";
$GLOBALS['strOtherSettings']			= "Andere instellingen";

$GLOBALS['strWarning']				= "Waarschuwing";
$GLOBALS['strFatalError']			= "Er is een fout opgetreden";
$GLOBALS['strUpdateError']			= "Er is een fout opgetreden tijdens het bijwerken";
$GLOBALS['strUpdateDatabaseError']		= "Wegens een onbekende reden is het aanpassen van de database structuur niet gelukt. Het is aan te raden om te klikken op <b>Probeer opnieuw</b> om te proberen om deze fouten te herstellen. Indien u er zeker van bent dat deze fouten het functioneren van ".$phpAds_productname." niet in gevaar brengen kunt op de knop <b>Negeer foutmeldingen</b> klikken. Het negeren van deze foutmelding kan ernstige problemen veroorzaken en is niet aan te raden!";
$GLOBALS['strAlreadyInstalled']			= $phpAds_productname." is reeds geinstalleerd op dit systeem. Indien u het systeem verder wilt configureren ga dan naar de <a href='settings-index.php'>instellingen</a>";
$GLOBALS['strCouldNotConnectToDB']		= "Er kon geen connectie opgebouwd worden met de database, controleer a.u.b. de door u opgegeven instellingen";
$GLOBALS['strCreateTableTestFailed']		= "De gebruiker die u heeft opgegeven heeft geen toestemming om de database aan te maken of te wijzigen, neem a.u.b. contact op met de beheerder van de database.";
$GLOBALS['strUpdateTableTestFailed']		= "De gebruiker die u heeft opgegeven heeft geen toestemming om de database structuur te wijzigen, neem a.u.b. contact op met de beheerder van de database.";
$GLOBALS['strTablePrefixInvalid']		= "De tabelnaam voorvoegsel bevat illegale tekens";
$GLOBALS['strTableInUse']			= "De database welke u opgegeven heeft is al ingebruik door ".$phpAds_productname.". Gebruik een ander tabelnaam voorvoegsel of lees de documentatie voor instructies om te upgraden.";
$GLOBALS['strTableWrongType']			= "Het tabel type dat u geselecteerd heeft wordt niet ondersteund door uw ".$phpAds_dbmsname." installatie";
$GLOBALS['strMayNotFunction']			= "Voor dat uw verder gaat, corrigeer a.u.b. de volgende problemen:";
$GLOBALS['strFixProblemsBefore']		= "De volgende item(s) dienen gecorrigeerd te worden voordat u ".$phpAds_productname." kan installeren. Indien u vragen heeft over deze foutmelding, lees dan eerst de <i>Administrator guide</i>, welke u kunt vinden in het bestand dat u gedownload heeft.";
$GLOBALS['strFixProblemsAfter']			= "Indien u de volgende items niet zelf kan corrigeren neem dan contact op met de beheerder van deze server. De beheerder van de server kan u wellicht verder helpen.";
$GLOBALS['strIgnoreWarnings']			= "Negeer waarschuwingen";
$GLOBALS['strWarningPHPversion']		= $phpAds_productname." heeft minimaal PHP 4.0 nodig om te functioneren. U gebruik momenteel versie {php_version}.";
$GLOBALS['strWarningDBavailable']		= "De versie van PHP welke u gebruikt heeft geen ondersteuning voor connecties met een ".$phpAds_dbmsname." database server. U dient de PHP ".$phpAds_dbmsname." extentie te installeren voordat u verder kunt gaan.";
$GLOBALS['strWarningRegisterGlobals']		= "De PHP instelling register_globals moet aan staan.";
$GLOBALS['strWarningMagicQuotesGPC']		= "De PHP instelling magic_quotes_gpc moet aan staan.";
$GLOBALS['strWarningMagicQuotesRuntime']	= "De PHP instelling magic_quotes_runtime moet uit staan.";
$GLOBALS['strWarningFileUploads']		= "De PHP instelling file_uploads moet aan staan.";
$GLOBALS['strWarningTrackVars']			= "De PHP instelling track_vars moet aan staan.";
$GLOBALS['strWarningPREG']			= "De versie van PHP die u gebruikt heeft geen ondersteuning voor PERL compatible reguliere expressies. U dient de PREG extentie te installeren voordat u verder kunt gaan.";
$GLOBALS['strConfigLockedDetected']		= $phpAds_productname." heeft gedetecteerd dat uw <b>config.inc.php</b> bestand niet beschrijfbaar is door de server. U kunt niet verder gaan tot u de bestands permissies gewijzigd heeft. Raadpleeg de bijgevoegde documentatie indien u niet weet hoe u dit kunt doen.";
$GLOBALS['strCantUpdateDB']  			= "Het is momenteel nog niet mogelijk om de database bij te werken. Indien u beslist om door te gaan worden alle bestaande banners, statistieken and klanten verwijderd.";
$GLOBALS['strIgnoreErrors']			= "Negeer foutmeldingen";
$GLOBALS['strRetryUpdate']			= "Probeer opnieuw";
$GLOBALS['strTableNames']			= "Tabelnamen";
$GLOBALS['strTablesPrefix']			= "Tabelnaam voorvoegsel";
$GLOBALS['strTablesType']			= "Tabeltype";

$GLOBALS['strInstallWelcome']			= "Welkom op ". MAX_PRODUCT_NAME ."";
$GLOBALS['strInstallMessage']			= "Voordat u ".$phpAds_productname." kunt gebruiken moet het eerst geconfigureerd <br /> worden, tevens moet de database aangemaakt worden. Klik op <b>Verder</b> om door te gaan.";
$GLOBALS['strInstallSuccess']			= "<b>De installatie van ".$phpAds_productname." is nu compleet.</b><br /><br />Om goed te functioneren moet de onderhouds bestand elk uur\n						   gedraaid worden. Meer informatie over dit onderwerp kunt u vinden in de documentatie.\n						   <br /><br />Klik op <b>Verder</b> om door te gaan naar de configuratie pagina, waar u nog meer\n						   items kunt instellen. Vergeet a.u.b. niet de permissies van het config.inc.php bestand weer terug te zetten, omdat dit\n						   potentiele veiligheid problemen kan veroorzaken.";
$GLOBALS['strUpdateSuccess']			= "<b>Het bijwerken van ".$phpAds_productname." is succesvol afgerond.</b><br /><br />Om goed te functioneren moet de maintenance functie elk uur gedraaid\n						   worden (voorheen was dit elke dag). Meer informatie over dit onderwerp kunt u vinden in de documentatie.\n						   <br /><br />Klik op <b>Verder ></b> om naar de administratie interface te gaan. Vergeet a.u.b. niet de permissies van het config.inc.php bestand weer terug te zetten, omdat dit\n						   potentiele veiligheid problemen kan veroorzaken.";
$GLOBALS['strInstallNotSuccessful']		= "<b>De installatie van ". MAX_PRODUCT_NAME ." was niet succesvol</b><br /><br />Sommige onderdelen van het installatie proces konden niet succesvol afgesloten worden.\nHet is mogelijk dat deze problemen slechts tijdelijk zijn, in dat geval kunt u op <b>Verder</b> klikken en opnieuw\nbeginnen met de installatie. Indien u meer wilt weten over de foutmeldingen die hieronder vermeld staan, raadpleeg dan de \nbijgesloten documentatie.";
$GLOBALS['strErrorOccured']			= "De volgende fouten zijn opgetreden:";
$GLOBALS['strErrorInstallDatabase']		= "De database kon niet worden aangemaakt.";
$GLOBALS['strErrorUpgrade'] = 'The existing installation\'s database could not be upgraded.';
$GLOBALS['strErrorInstallConfig']		= "Het configuratie bestand kont niet worden bijgewerkt.";
$GLOBALS['strErrorInstallDbConnect']		= "Het was niet mogelijk om een connectie te openen met de database.";

$GLOBALS['strUrlPrefix']			= "Locatie van ".$phpAds_productname."";

$GLOBALS['strProceed']				= "Ga verder >";
$GLOBALS['strInvalidUserPwd']			= "Ongeldige gebruikersnaam of wachtwoord";

$GLOBALS['strUpgrade']				= "Upgrade";
$GLOBALS['strSystemUpToDate']			= "Uw systeem is al bijgewerkt, het is momenteel niet nodig om verder bij te werken. <br />Klik op <b>Verder</b> om door te gaan.";
$GLOBALS['strSystemNeedsUpgrade']		= "Om goed te functioneren moeten de database structuur en het configuratie bestand worden bijgewerkt. Klik op <b>Verder</b> om te beginnen met bijwerken. <br /><br />Afhankelijk van welke versie u wilt bijwerken en de hoeveelheid bestaande statistieken kan deze functie een hoge belasting veroorzaken op de database server. Het bijwerken kan enige minuten duren.";
$GLOBALS['strSystemUpgradeBusy']		= "Uw systeem wordt momenteel bijgewerkt, een moment geduld a.u.b...";
$GLOBALS['strSystemRebuildingCache']		= "Uw bestaande gegevens worden bijgewerkt, een moment geduld a.u.b...";
$GLOBALS['strServiceUnavalable']		= "Deze service is momenteel niet beschikbaar. Het systeem wordt bijgewerkt.";

$GLOBALS['strConfigNotWritable']		= "Uw config.inc.php is niet te wijzigen";





/*-------------------------------------------------------*/
/* Configuration translations                            */
/*-------------------------------------------------------*/

// Global
$GLOBALS['strChooseSection']			= "Kies sectie";
$GLOBALS['strDayFullNames'][0] = "Zondag";
$GLOBALS['strDayFullNames'][1] = "Maandag";
$GLOBALS['strDayFullNames'][2] = "Dinsdag";
$GLOBALS['strDayFullNames'][3] = "Woensdag";
$GLOBALS['strDayFullNames'][4] = "donderdag";
$GLOBALS['strDayFullNames'][5] = "vrijdag";
$GLOBALS['strDayFullNames'][6] = "Zaterdag";

$GLOBALS['strEditConfigNotPossible']    	= "Het is niet mogelijk om deze instellingen te wijzigen, omdat het configuratiebestand vanwege veiligheidsredenen op slot staat. Indien u veranderingen wilt maken dient u eerst het bestand config.inc.php schrijfbaar maken.";
$GLOBALS['strEditConfigPossible']		= "Het is mogelijk om alle instellingen te wijzigen, omdat het configuratiebestand niet op slot staat, maar dit zou kunnen lijden tot een veiligheidslek. Indien u uw systeem wilt behouden voor eventuele veiligheidsproblemen, dan moet u het bestand config.inc.php op slot zetten.";



// Database
$GLOBALS['strDatabaseSettings']			= "Database instellingen";
$GLOBALS['strDatabaseServer']			= "Database server";
$GLOBALS['strDbLocal']				= "Gebruik een lokale server door middel van sockets"; // Pg only
$GLOBALS['strDbPort']				= "Database poort nummer";
$GLOBALS['strDbHost']				= "Database adres";
$GLOBALS['strDbUser']				= "Database gebruikersnaam";
$GLOBALS['strDbPassword']			= "Database wachtwoord";
$GLOBALS['strDbName']				= "Database naam";

$GLOBALS['strDatabaseOptimalisations']		= "Database optimalisaties";
$GLOBALS['strPersistentConnections']		= "Gebruik 'persistent connections'";
$GLOBALS['strCompatibilityMode']		= "Gebruik database compatibiliteits mode";
$GLOBALS['strCantConnectToDb']			= "Kan geen connectie maken met de database";



// Invocation and Delivery
$GLOBALS['strInvocationAndDelivery']		= "aanroep instellingen";

$GLOBALS['strAllowedInvocationTypes']		= "Toegestande aanroeptypes";
$GLOBALS['strAllowRemoteInvocation']		= "Gebruik Remote Invocation";
$GLOBALS['strAllowRemoteJavascript']		= "Gebruik Remote Invocation voor Javascript";
$GLOBALS['strAllowRemoteFrames']		= "Gebruik Remote Invocation voor Frames";
$GLOBALS['strAllowRemoteXMLRPC']		= "Gebruik Remote Invocation voor XML-RPC";
$GLOBALS['strAllowLocalmode']			= "Gebruik Lokale mode";
$GLOBALS['strAllowInterstitial']		= "Gebruik Interstitials";
$GLOBALS['strAllowPopups']			= "Gebruik Popups";

$GLOBALS['strUseAcl']				= "Evalueer de leveringsbeperkingen tijdens de aflevering";

$GLOBALS['strDeliverySettings']			= "Leveringsinstellingen";
$GLOBALS['strCacheType']				= "Type leveringscache";
$GLOBALS['strCacheFiles']				= "Bestanden";
$GLOBALS['strCacheDatabase']			= "Database";
$GLOBALS['strCacheShmop']				= "Gedeeld geheugen/Shmop";
$GLOBALS['strCacheSysvshm']				= "Gedeeld geheugen/Sysvshm";
$GLOBALS['strExperimental']				= "Experimenteel";
$GLOBALS['strKeywordRetrieval']			= "Sleutelwoord selectie";
$GLOBALS['strBannerRetrieval']			= "Banner selectie methode";
$GLOBALS['strRetrieveRandom']			= "Willekeurige banner selectie (standaard)";
$GLOBALS['strRetrieveNormalSeq']		= "Normale sequentieele banner selectie";
$GLOBALS['strWeightSeq']			= "Op gewicht gebaseerde sequentieele banner selectie";
$GLOBALS['strFullSeq']				= "Volledige sequentieele banner selectie";
$GLOBALS['strUseConditionalKeys']		= "Sta het gebruik van logische operatoren toe tijdens directe selectie";
$GLOBALS['strUseMultipleKeys']			= "Sta het gebruik van meerdere sleutelwoorden toe tijdens directe selectie";

$GLOBALS['strZonesSettings']			= "Zone selectie";
$GLOBALS['strZoneCache']			= "Cache zones, dit zou het gebruik moeten versnellen wanneer gebruik gemaakt word van zones";
$GLOBALS['strZoneCacheLimit']			= "Tijd tussen het updaten van de cache (in seconden)";
$GLOBALS['strZoneCacheLimitErr']		= "De tijd tussen het updaten van de cache moet een positief getal zijn";

$GLOBALS['strP3PSettings']			= "P3P Privacy Policies";
$GLOBALS['strUseP3P']				= "Gebruik P3P Policies";
$GLOBALS['strP3PCompactPolicy']			= "P3P Compacte Policy";
$GLOBALS['strP3PPolicyLocation']		= "P3P Policy Locatie";



// Banner Settings
$GLOBALS['strBannerSettings']			= "Banner instellingen";

$GLOBALS['strAllowedBannerTypes']		= "Toegestane bannertypes";
$GLOBALS['strTypeSqlAllow']			= "Sta lokale banners toe (SQL)";
$GLOBALS['strTypeWebAllow']			= "Sta lokale banners toe (Webserver)";
$GLOBALS['strTypeUrlAllow']			= "Laat externe banners toe";
$GLOBALS['strTypeHtmlAllow']			= "Laat HTML banners toe";
$GLOBALS['strTypeTxtAllow']			= "Laat tekst advertenties toe";

$GLOBALS['strTypeWebSettings']			= "Lokale banner (Webserver) instellingen";
$GLOBALS['strTypeWebMode']			= "Opslag methode";
$GLOBALS['strTypeWebModeLocal']			= "Lokale map";
$GLOBALS['strTypeWebModeFtp']			= "Externe FTP server)";
$GLOBALS['strTypeWebDir']			= "Lokale map";
$GLOBALS['strTypeWebFtp']			= "FTP server";
$GLOBALS['strTypeWebUrl']			= "Publieke URL";
$GLOBALS['strTypeWebSslUrl']			= "Publieke URL (SSL)";
$GLOBALS['strTypeFTPHost']			= "FTP server";
$GLOBALS['strTypeFTPDirectory']			= "Server map";
$GLOBALS['strTypeFTPUsername']			= "Aanmelden";
$GLOBALS['strTypeFTPPassword']			= "Wachtwoord";
$GLOBALS['strTypeFTPErrorDir']			= "De server map bestaat niet";
$GLOBALS['strTypeFTPErrorConnect']		= "De verbinding met de FTP server kon niet worden opgebouwd, de gebruikersnaam of het wachtwoord zijn niet correct";
$GLOBALS['strTypeFTPErrorHost']			= "De hostname van de FTP server is niet correct";
$GLOBALS['strTypeDirError']				= "De lokale map bestaat niet";

$GLOBALS['strDefaultBanners']			= "Standaard banners";
$GLOBALS['strDefaultBannerUrl']			= "Standaard afbeelding URL";
$GLOBALS['strDefaultBannerTarget']		= "Standaard banner doellocatie";

$GLOBALS['strTypeHtmlSettings']			= "HTML banner opties";
$GLOBALS['strTypeHtmlAuto']			= "Verander HTML automatisch om het loggen van AdClicks te forceren";
$GLOBALS['strTypeHtmlPhp']			= "Sta het gebruik van PHP code toe binnen in HTML banners.";



// Host information and Geotargeting
$GLOBALS['strHostAndGeo']				= "Bezoekers en Geotargeting";

$GLOBALS['strRemoteHost']				= "Bezoekers";
$GLOBALS['strReverseLookup']			= "Probeer de hostname van de bezoeker te achterhalen als deze niet door de server wordt verstrekt";
$GLOBALS['strProxyLookup']				= "Probeer het echte IP adres van de bezoeker te achterhalen als er gebruik gemaakt wordt van een proxy server";

$GLOBALS['strGeotargeting']				= "Geotargeting";
$GLOBALS['strGeotrackingType']			= "Type Geotargeting database";
$GLOBALS['strGeotrackingLocation'] 		= "Geotargeting database locatie";
$GLOBALS['strGeotrackingLocationError'] = "De opgegeven locatie van de geotargeting database is niet correct";
$GLOBALS['strGeoStoreCookie']			= "Sla het resultaat op in een cookie voor hergebruik";


// Statistics Settings
$GLOBALS['strStatisticsSettings']		= "Statistieken Instellingen";

$GLOBALS['strStatisticsFormat']			= "Statistieken formaat";
$GLOBALS['strCompactStats']				= "Statistieken formaat";
$GLOBALS['strLogAdviews']				= "Sla een AdView op iedere keer als een banner is afgeleverd";
$GLOBALS['strLogAdclicks']				= "Sla een AdClick op ieder keer als een bezoeker op een banner klikt";
$GLOBALS['strLogSource']				= "Sla de doel parameter op welke tijdens de aanroep is gespecificeerd";
$GLOBALS['strGeoLogStats']				= "Sla het land van herkomst van de bezoeker op";
$GLOBALS['strLogHostnameOrIP']			= "Sla de hostname of het IP adres van de bezoeker op";
$GLOBALS['strLogIPOnly']				= "Sla alleen het IP adres van de bezoeker op, zelfs als de hostname bekend is";
$GLOBALS['strLogIP']					= "Sla het IP adres van de bezoeker op";
$GLOBALS['strLogBeacon']				= "Gebruik een klein beacon afbeelding op de AdViews op slaan";

$GLOBALS['strRemoteHost']				= "Bezoekers";
$GLOBALS['strIgnoreHosts']				= "Sla geen statistieken op van gebruikers met een van de volgende IP adressen";
$GLOBALS['strBlockAdviews']				= "Sla geen AdViews op als de gebruiker dezelfde banner al eens gezien heeft binnen het gespecifieerde aantal seconden";
$GLOBALS['strBlockAdclicks']			= "Sla geen AdClicks op als de gebruiker al eerder op dezelfde banner geklikt heeft binnen het gespecificeerde aantal seconden";

$GLOBALS['strEmailWarnings']			= "Waarschuwingen per email";
$GLOBALS['strAdminEmailHeaders']		= "Voeg de volgende header toe aan elke e-mail bericht verzonden door ". MAX_PRODUCT_NAME ."";
$GLOBALS['strWarnLimit']			= "Stuur een waarschuwing als de resterende impressies minder zijn dan hier gespecificeerd";
$GLOBALS['strWarnLimitErr']			= "Waarschuwings limiet moet een positief nummer zijn";
$GLOBALS['strWarnAdmin']			= "Stuur een waarschuwing naar de beheerder wanneer er voor een campagne bijna geen impressies meer over zijn";
$GLOBALS['strWarnClient']			= "Stuur een waarschuwing naar de adverteerder wanneer er voor een campagne bijna geen impressies meer over zijn";
$GLOBALS['strQmailPatch']			= "Pas headers aan voor qmail";


$GLOBALS['strAutoCleanTables']			= "Database opschoning";
$GLOBALS['strAutoCleanStats']			= "Schoon statistieken op";
$GLOBALS['strAutoCleanUserlog']			= "Schoon gebruikerslog op";
$GLOBALS['strAutoCleanStatsWeeks']		= "Maximale leeftijd statistieken <br />(minimaal 3 weken)";
$GLOBALS['strAutoCleanUserlogWeeks']		= "Maximale leeftijd gebruikerslog <br />(minimaal 3 weken)";
$GLOBALS['strAutoCleanErr']			= "De maximale leeftijd moet minstens drie weken zijn";
$GLOBALS['strAutoCleanVacuum']			= "VACUUM ANALYZE tabellen elke nacht"; // only Pg


// Administrator settings
$GLOBALS['strAdministratorSettings']		= "Administrator instellingen";

$GLOBALS['strLoginCredentials']			= "Inlog gegevens";
$GLOBALS['strAdminUsername']			= "Gebruikersnaam van de beheerder";
$GLOBALS['strInvalidUsername']			= "Ongeldige gebruikersnaam";

$GLOBALS['strBasicInformation']			= "Basisinformatie";
$GLOBALS['strAdminFullName']			= "Volledige naam van de beheerder";
$GLOBALS['strAdminEmail']			= "E-mail adres van de beheerder";
$GLOBALS['strCompanyName']			= "Bedrijfsnaam";

$GLOBALS['strAdminCheckUpdates']		= "Controleer op nieuwe versie";
$GLOBALS['strAdminCheckEveryLogin']		= "Altijd";
$GLOBALS['strAdminCheckDaily']			= "Dagelijks";
$GLOBALS['strAdminCheckWeekly']			= "Wekelijks";
$GLOBALS['strAdminCheckMonthly']		= "Maandelijks";
$GLOBALS['strAdminCheckNever']			= "Nooit";

$GLOBALS['strAdminNovice']			= "Toon een waarschuwing wanneer er items verwijderd worden";
$GLOBALS['strUserlogEmail']			= "Sla alle uitgaande e-mails op";
$GLOBALS['strUserlogPriority']			= "Sla alle uurlijkse prioriteit berekeningen op";
$GLOBALS['strUserlogAutoClean']			= "Sla automatisch opschonen van de database op";


// User interface settings
$GLOBALS['strGuiSettings']			= "Gebruikersinterface instellingen";

$GLOBALS['strGeneralSettings']			= "Algemene instellingen";
$GLOBALS['strAppName']				= "Applicatienaam";
$GLOBALS['strMyHeader']				= "Voetnoot bestand";
$GLOBALS['strMyHeaderError']		= "De opgegeven locatie van het voetnoot bestand is niet correct";
$GLOBALS['strMyFooter']				= "Eindnoot bestand";
$GLOBALS['strMyFooterError']		= "De opgegeven locatie van het eindnoot bestand is niet correct";
$GLOBALS['strGzipContentCompression']		= "Gebruik GZIP content compression";

$GLOBALS['strClientInterface']			= "Adverteerder interface";
$GLOBALS['strClientWelcomeEnabled']		= "Toon een welkomstbericht";
$GLOBALS['strClientWelcomeText']		= "Welkomstbericht<br />(HTML is toegestaan)";



// Interface defaults
$GLOBALS['strInterfaceDefaults']		= "Interface standaardwaarden";

$GLOBALS['strInventory']			= "Inventaris";
$GLOBALS['strShowCampaignInfo']			= "Toon extra campagne informatie op de <i>Campagne</i> pagina";
$GLOBALS['strShowBannerInfo']			= "Toon extra banner informatie op de <i>Banners</i> pagina";
$GLOBALS['strShowCampaignPreview']		= "Toon voorvertooning van alle banners op de <i>Banners</i> pagina";
$GLOBALS['strShowBannerHTML']			= "Toon werkelijke banner in plaats van HTML code voor de voorvertoning van HTML banners";
$GLOBALS['strShowBannerPreview']		= "Toon voorvertoning bovenaan alle pagina's welke betrekking hebben op banners";
$GLOBALS['strHideInactive']			= "Verberg inactiviteit ";
$GLOBALS['strGUIShowMatchingBanners']		= "Toon geschikte banners op de <i>Gekoppelde banners</i> paginas";
$GLOBALS['strGUIShowParentCampaigns']		= "Toon bovenliggende campagnes op de <i>Gekoppelde banners</i> pagina";
$GLOBALS['strGUILinkCompactLimit']		= "Verberg niet-gekoppelde campagnes of banners op de<i>Gekoppelde banners</i> paginas wanneer er meer zijn dan";

$GLOBALS['strStatisticsDefaults'] 		= "Statistieken";
$GLOBALS['strBeginOfWeek']			= "Begin van de week";
$GLOBALS['strPercentageDecimals']		= "Nauwkeurigheid van percentages";

$GLOBALS['strWeightDefaults']			= "Standaard gewicht";
$GLOBALS['strDefaultBannerWeight']		= "Standaard banner gewicht";
$GLOBALS['strDefaultCampaignWeight']		= "Standaard campagne gewicht";
$GLOBALS['strDefaultBannerWErr']		= "Standaard banner gewicht moet een positief getal zijn";
$GLOBALS['strDefaultCampaignWErr']		= "Standaard campagne gewicht moet een positief getal zijn";



// Not used at the moment
$GLOBALS['strTableBorderColor']			= "Tabel rand kleur";
$GLOBALS['strTableBackColor']			= "Table achtergrond kleur";
$GLOBALS['strTableBackColorAlt']		= "Table achtergrond kleur (alternatief)";
$GLOBALS['strMainBackColor']			= "Globale achtergrond kleur";
$GLOBALS['strOverrideGD']			= "Override GD Imageformat";
$GLOBALS['strTimeZone']				= "Tijdzone";



// Note: New translations not found in original lang files but found in CSV
$GLOBALS['strHasTaxID'] = "Tax ID";
$GLOBALS['strSpecifySyncSettings'] = "Synchronisatie instellingen";
$GLOBALS['strOpenadsIdYour'] = "Uw OpenX iD";
$GLOBALS['strOpenadsIdSettings'] = "OpenX ID instellingen";
$GLOBALS['strBtnContinue'] = "Ga verder »";
$GLOBALS['strBtnGoBack'] = "« Ga terug";
$GLOBALS['strBtnAgree'] = "Ik ga akkoord »";
$GLOBALS['strBtnDontAgree'] = "« Ik ga niet akkoord";
$GLOBALS['strInstallIntro'] = "Dank om te kiezen voor <a href='http://". MAX_PRODUCT_URL ."' target='_blank'><strong>". MAX_PRODUCT_NAME ."</strong></a><p>Deze wizard zal je gidsen door het installatie proces / upgrade van de ". MAX_PRODUCT_NAME ." advertentie server.</p><p>Om je te helpen doorheen het installatie proces hebben we een <a href='http://". OX_PRODUCT_DOCSURL ."/wizard/qsg-install' target='_blank'>Snelle startgids voor installatie</a> gemaakt om doorheen het proces te geraken om alles werkend te krijgen. Voor een meer gedetailleerde gids om alles te installeren en in te stellen van ". MAX_PRODUCT_NAME ." bezoek de <a href='http://". OX_PRODUCT_DOCSURL ."/wizard/admin-guide'target='_blank'>Administrator gids</a>.";
$GLOBALS['strTermsTitle'] = "Gebruikovereenkomst, privacy beleid";
$GLOBALS['strTermsIntro'] = "". MAX_PRODUCT_NAME ." s vrij verschenen onder een Open Source licentie, de GNU generale publieke licentie. Gelieve volgende documentatie na te kijken en goed te keuren om verder te gaan met de installatie.";
$GLOBALS['strPolicyTitle'] = "Privacy beleid";
$GLOBALS['strPolicyIntro'] = "Gelieve volgende documenten na te kijken en goed te keuren om verder te gaan met installatie";
$GLOBALS['strDbSetupTitle'] = "Database instellingen";
$GLOBALS['strDbSetupIntro'] = "Gelieve de details in te geven om een connectie aan te maken met jouw database. Indien u niet zeker bent over deze details, gelieve uw systeem administrator te contacteren. <p>De volgende stap zal uw database aanmaken . Druk op 'Ga verder' om verder te gaan.</p>";
$GLOBALS['strDbUpgradeIntro'] = "Onderdaan vind u de gevonden database detials van uw installatie van ". MAX_PRODUCT_NAME .".Gelieve deze te te kijken om er zeker van te zijn dat ze juist zijn.<p>De volgende stap zal uw database bijwerken. Klik op 'Ga verder' om uw systeem bij te werken.</p>";
$GLOBALS['strOaUpToDate'] = "Jouw ". MAX_PRODUCT_NAME ." database en bestandstructuur gebruiken beide de meest recente versie en moeten daardoor niet worden bijgewerkt op dit ogenblik. Gelieve op ga verder te drukken om verder te gaan naar het ". MAX_PRODUCT_NAME ." administratie paneel.";
$GLOBALS['strOaUpToDateCantRemove'] = "Waarschuwing: het UPGRADE bestand is nog steeds te vinden in jouw var map. We kunnen dit bestand niet verwijderen omwille van ontbrekende rechten. Gelieve dit bestand zelf te verwijderen. ";
$GLOBALS['strRemoveUpgradeFile'] = "Je moet het UPGRADE bestand verwijderen in de map var";
$GLOBALS['strSystemCheckIntro'] = "De installatie wizard is uw webserver instellingen aan het controleren om er zeker van te zijn dat de installatie succesvol kan verlopen.	<p>Gelieve de aangeduide zaken na te kijken om het installatieproces af te ronden.</p>";
$GLOBALS['strDbSuccessIntro'] = "De ". MAX_PRODUCT_NAME ." database is nu aangemaakt. Gelieve op de  'ga verder' knop te drukken om verder te gaan met het instellen van ". MAX_PRODUCT_NAME ." administrator en aanlever instellingen.";
$GLOBALS['strDbSuccessIntroUpgrade'] = "Uw systeem is met succes bijgewerkt. De volgende schermen zullen je helpen met het updaten van de configuratie van uw nieuwe advertentie server.";
$GLOBALS['strErrorWritePermissions'] = "Bestandsrechten errors zijn gedetecteerd, en moeten worden opgelost om te kunnen verdergaan.<br />Om de errors onder Linux op te lossen, probeer eens volgende commando(s) in te geven:";
$GLOBALS['strErrorWritePermissionsWin'] = "Bestandsrechten errors zijn gedetecteerd, en moeten worden opgelost om te kunnen verdergaan.";
$GLOBALS['strCheckDocumentation'] = "Voor meer hulp, gelieve de <a href='http://". OX_PRODUCT_DOCSURL ."'>". MAX_PRODUCT_NAME ." documentatie na te kijken</a>.";
$GLOBALS['strAdminUrlPrefix'] = "Admin interface URL";
$GLOBALS['strDeliveryUrlPrefix'] = "Bezorger";
$GLOBALS['strDeliveryUrlPrefixSSL'] = "Bezorger";
$GLOBALS['strAdministratorEmail'] = "E-mail adres administrator";
$GLOBALS['strTimezone'] = "Tijdzone";
$GLOBALS['strTimezoneEstimated'] = "Geschatte tijdzone";
$GLOBALS['strTimezoneGuessedValue'] = "De tijdzone van de server is niet correct ingesteld in PHP";
$GLOBALS['strTimezoneSeeDocs'] = "Gelieve de  %DOCS% na te kijken over de instellingen van deze variabele voor PHP in te stellen.";
$GLOBALS['strTimezoneDocumentation'] = "documentatie";
$GLOBALS['strLoginSettingsTitle'] = "Administrator login";
$GLOBALS['strLoginSettingsIntro'] = "Om verder te kunnen gaan met het upgrade proces, gelieve uw ". MAX_PRODUCT_NAME ." administrator gebruiker login details in te geven. U moet inloggen als de administrator gebruiker om verder te kunnen gaan met het upgrade proces. ";
$GLOBALS['strAdminSettingsTitle'] = "Maak een administrator account";
$GLOBALS['strAdminSettingsIntro'] = "Gelieve de velden te vervolledigen om jouw ad server administrator account aan te maken ";
$GLOBALS['strOpenadsUsername'] = "". MAX_PRODUCT_NAME ." Gebruikersnaam";
$GLOBALS['strOpenadsPassword'] = "". MAX_PRODUCT_NAME ." Wachtwoord ";
$GLOBALS['strOpenadsEmail'] = "". MAX_PRODUCT_NAME ." E-mail";
$GLOBALS['strDbType'] = "Database naam";
$GLOBALS['strDeliveryPath'] = "Leveringscache";
$GLOBALS['strDeliverySslPath'] = "Leveringscache";
$GLOBALS['strDeliveryFilenamesAdClick'] = "Ad Klik";
$GLOBALS['strDeliveryFilenamesAdContent'] = "Ad content ";
$GLOBALS['strDeliveryFilenamesAdFrame'] = "Ad frame";
$GLOBALS['strDeliveryFilenamesAdImage'] = "Ad afbeelding";
$GLOBALS['strDeliveryFilenamesAdJS'] = "Ad (javascript)";
$GLOBALS['strDeliveryFilenamesAdLayer'] = "Ad layer";
$GLOBALS['strDeliveryFilenamesAdLog'] = "Ad log";
$GLOBALS['strDeliveryFilenamesAdPopup'] = "Ad popup";
$GLOBALS['strDeliveryCaching'] = "Banner afleveringsinstellingen";
$GLOBALS['strGeotargetingSettings'] = "Geotargeting";
$GLOBALS['strGeotargetingGeoipCountryLocation'] = "MaxMind GeoIP Land Database locatie";
$GLOBALS['strGeotargetingGeoipRegionLocation'] = "MaxMind GeoIP Regio Database Locatie";
$GLOBALS['strGeotargetingGeoipCityLocation'] = "MaxMind GeoIP Stad Database Locatie";
$GLOBALS['strGeotargetingGeoipAreaLocation'] = "MaxMind GeoIP Gebied Database Locatie";
$GLOBALS['strGeotargetingGeoipDmaLocation'] = "MaxMind GeoIP ISP Database Locatie";
$GLOBALS['strGeotargetingGeoipOrgLocation'] = "MaxMind GeoIP Organisatie Database Locatie";
$GLOBALS['strGeotargetingGeoipIspLocation'] = "MaxMind GeoIP ISP Database Locatie";
$GLOBALS['strGeotargetingGeoipNetspeedLocation'] = "MaxMind GeoIP Stad Database Locatie";
$GLOBALS['strCategories'] = "Categorieën";
$GLOBALS['strHelpFiles'] = "Help bestanden";
$GLOBALS['strWarnAgency'] = "Stuur een waarschuwing naar de adverteerder wanneer er voor een campagne bijna geen impressies meer over zijn";
$GLOBALS['strMyLogoError'] = "Het logo bestand bestaat niet in de admin/images map";
$GLOBALS['strGuiHeaderForegroundColor'] = "Kleur van de header voorgrond";
$GLOBALS['strGuiHeaderBackgroundColor'] = "Kleur van de header achtergrond";
$GLOBALS['strGuiActiveTabColor'] = "Kleur van een actieve tab";
$GLOBALS['strGuiHeaderTextColor'] = "Kleur van headertekst";
$GLOBALS['strColorError'] = "Gelieve kleuren in het RGB formaat in te geven, zoals '0066CC'";
$GLOBALS['strReportsInterface'] = "Raporteer interface";
$GLOBALS['strEmailSettings'] = "Hoofd instellingen";
$GLOBALS['strAlreadyInstalled'] = "". MAX_PRODUCT_NAME ." is alreeds geïnstalleerd op dit systeem. Als je dit wilt configureren ga dan naar de  <a href='account-index.php'>instellingen interface</a>.";
$GLOBALS['strInvocationDefaults'] = "aanroep standaards";
$GLOBALS['strBannerDelivery'] = "Banner afleveringsinstellingen";
$GLOBALS['strDashboardSettings'] = "Dashboard instellingen";
?>