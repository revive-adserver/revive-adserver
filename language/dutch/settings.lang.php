<?php // $Revision$

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2000-2002 by the phpAdsNew developers                  */
/* For more information visit: http://www.phpadsnew.com                 */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/



// Installer translation strings
$GLOBALS['strInstall']				= "Installatie";
$GLOBALS['strChooseInstallLanguage']		= "Kies een taal voor de installatie procedure";
$GLOBALS['strLanguageSelection']		= "Taal selectie";
$GLOBALS['strDatabaseSettings']			= "Database instellingen";
$GLOBALS['strAdminSettings']			= "Beheer instellingen";
$GLOBALS['strAdvancedSettings']			= "Geavanceerde instellingen";
$GLOBALS['strOtherSettings']			= "Andere instellingen";

$GLOBALS['strWarning']				= "Waarschuwing";
$GLOBALS['strFatalError']			= "Er is een fout opgetreden";
$GLOBALS['strAlreadyInstalled']			= "phpAdsNew is reeds geinstalleerd op dit systeem. Indien u het systeem verder wilt configureren ga dan naar de <a href='settings-index.php'>instellingen</a>";
$GLOBALS['strCouldNotConnectToDB']		= "Er kon geen connectie opgebouwd worden met de database, controleer a.u.b. de door u opgegeven instellingen";
$GLOBALS['strCreateTableTestFailed']		= "De gebruiker die u heeft opgegeven heeft geen toestemming om de database aan te maken of te wijzigen, neem a.u.b. contact op met de beheerder van de database.";
$GLOBALS['strUpdateTableTestFailed']		= "De gebruiker die u heeft opgegeven heeft geen toestemming om de database structuur te wijzigen, neem a.u.b. contact op met de beheerder van de database.";
$GLOBALS['strTablePrefixInvalid']		= "De tabelnaam voorvoegsel bevat illegale tekens";
$GLOBALS['strTableInUse']			= "De database welke u opgegeven heeft is al ingebruik door phpAdsNew. Gebruik een ander tabelnaam voorvoegsel of lees de documentatie voor instructies om te upgraden.";
$GLOBALS['strMayNotFunction']			= "Voor dat uw verder gaat, corrigeer a.u.b. de volgende problemen:";
$GLOBALS['strIgnoreWarnings']			= "Negeer waarschuwingen";
$GLOBALS['strWarningPHPversion']		= "phpAdsNew heeft minimaal PHP 3.0.8 nodig om te functioneren. U gebruik momenteel versie {php_version}.";
$GLOBALS['strWarningRegisterGlobals']		= "De PHP instelling register_globals moet aan staan.";
$GLOBALS['strWarningMagicQuotesGPC']		= "De PHP instelling magic_quotes_gpc moet aan staan.";
$GLOBALS['strWarningMagicQuotesRuntime']	= "De PHP instelling magic_quotes_runtime moet uit staan.";
$GLOBALS['strConfigLockedDetected']		= "phpAdsNew heeft gedetecteerd dat uw <b>config.inc.php</b> bestand niet beschrijfbaar is door de server.<br> U kunt niet verder gaan tot u de bestands permissies gewijzigd heeft. <br>Raadpleeg de begevoegde documentatie indien u niet weet hoe u dit kunt doen.";
$GLOBALS['strCantUpdateDB']  			= "Het is momenteel nog niet mogelijk om de database bij te werken. Indien u beslist om door te gaan worden alle bestaande banners, statistieken and klanten verwijderd.";
$GLOBALS['strTableNames']			= "Tabelnamen";
$GLOBALS['strTablesPrefix']			= "Tabelnaam voorvoegsel";
$GLOBALS['strTablesType']			= "Tabeltype";

$GLOBALS['strInstallWelcome']			= "Welkom bij phpAdsNew";
$GLOBALS['strInstallMessage']			= "Voordat u phpAdsNew kunt gebruiken moet het eerst geconfigureerd <br> worden, tevens moet de database aangemaakt worden. Klik op <b>Verder</b> om door te gaan.";
$GLOBALS['strInstallSuccess']			= "<b>De installatie van phpAdsNew is nu compleet.</b><br><br>Om goed te functioneren moet de onderhouds bestand elk uur
						   gedraaid worden. Meer informatie over dit onderwerp kunt u vinden in de documentatie.
						   <br><br>Klik op <b>Verder</b> om door te gaan naar de configuratie pagina, waar u nog meer
						   items kunt instellen. Vergeet a.u.b. niet de permissies van het config.inc.php bestand weer terug te zetten, omdat dit
						   potentiele veiligheid problemen kan veroorzaken.";
$GLOBALS['strUpdateSuccess']			= "<b>Het bijwerken van phpAdsNew is succesvol afgerond.</b><br><br>Om goed te functioneren moet de maintenance functie elk uur gedraaid
						   worden (voorheen was dit elke dag). Meer informatie over dit onderwerp kunt u vinden in de documentatie.
						   <br><br>Klik op <b>Verder &gt;</b> om naar de administratie interface te gaan. Vergeet a.u.b. niet de permissies van het config.inc.php bestand weer terug te zetten, omdat dit
						   potentiele veiligheid problemen kan veroorzaken.";
$GLOBALS['strInstallNotSuccessful']		= "<b>De installatie van phpAdsNew was niet succesvol</b><br><br>Sommige onderdelen van het installatie proces konden niet succesvol.
						   afgesloten worden. Het is mogelijk dat deze problemen slechts tijdelijk zijn, in dat geval kunt u op <b>Verder</b> klikken en opnieuw
						   beginnen met de installatie. Indien u meer wilt weten over de foutmeldingen die hieronder vermeld staan, raadpleeg dan de 
						   bijgesloten documentatie.";
$GLOBALS['strErrorOccured']			= "De volgende fouten zijn opgetreden:";
$GLOBALS['strErrorInstallDatabase']		= "De database kon niet worden aangemaakt.";
$GLOBALS['strErrorInstallConfig']		= "Het configuratie bestand kont niet worden bijgewerkt.";
$GLOBALS['strErrorInstallDbConnect']		= "Het was niet mogelijk om een connectie te openen met de database.";

$GLOBALS['strUrlPrefix']			= "Locatie van phpAdsNew";

$GLOBALS['strProceed']				= "Verder &gt;";
$GLOBALS['strRepeatPassword']			= "Nogmaals";
$GLOBALS['strNotSamePasswords']			= "De opgegeven wachtwoorden kwamen niet overeen";
$GLOBALS['strInvalidUserPwd']			= "Ongeldige gebruikersnaam of wachtwoord";

$GLOBALS['strUpgrade']				= "Upgrade";
$GLOBALS['strSystemUpToDate']			= "Uw systeem is al bijgewerkt, het is momenteel niet nodig om verder bij te werken. <br>Klik op <b>Verder</b> om door te gaan.";
$GLOBALS['strSystemNeedsUpgrade']		= "Om goed te functioneren moeten de database structuur en het configuratie bestand worden bijgewerkt. Klik op <b>Verder</b> om te beginnen met bijwerken. <br>Het bijwerken kan enige minuten duren.";
$GLOBALS['strSystemUpgradeBusy']		= "Uw systeem wordt momenteel bijgewerkt, een moment geduld a.u.b...";
$GLOBALS['strSystemRebuildingCache']		= "Uw bestaande gegevens worden bijgewerkt, een moment geduld a.u.b...";
$GLOBALS['strServiceUnavalable']		= "Deze service is momenteel niet beschikbaar. Het systeem wordt bijgewerkt.";

$GLOBALS['strConfigNotWritable']		= "Uw config.inc.php is niet te wijzigen";





/*********************************************************/
/* Configuration translations                            */
/*********************************************************/

// Global
$GLOBALS['strChooseSection']			= "Kies sectie";
$GLOBALS['strDayFullNames'] 			= array("zondag","maandag","dinsdag","woensdag","donderdag","vrijdag","zaterdag");
$GLOBALS['strEditConfigNotPossible']    	= "Het is niet mogelijk om deze instellingen te wijzigen, omdat het configuratiebestand vanwege veiligheidsredenen op slot staat. ".
										  "Indien u veranderingen wilt maken dient u eerst het bestand config.inc.php schrijfbaar maken.";
$GLOBALS['strEditConfigPossible']		= "Het is mogelijk om alle instellingen te wijzigen, omdat het configuratiebestand niet op slot staat, maar dit zou kunnen lijden tot een veiligheidslek. ".
										  "Indien u uw systeem wilt behouden voor eventuele veiligheidsproblemen, dan moet u het bestand config.inc.php op slot zetten.";



// Database
$GLOBALS['strDatabaseSettings']			= "Database instellingen";
$GLOBALS['strDatabaseServer']			= "Database server";
$GLOBALS['strDbHost']				= "Database adres";
$GLOBALS['strDbUser']				= "Database gebruikersnaam";
$GLOBALS['strDbPassword']			= "Database wachtwoord";
$GLOBALS['strDbName']				= "Database naam";

$GLOBALS['strDatabaseOptimalisations']		= "Database optimalisaties";
$GLOBALS['strPersistentConnections']		= "Gebruik 'persistent connections'";
$GLOBALS['strInsertDelayed']			= "Gebruik 'delayed inserts'";
$GLOBALS['strCompatibilityMode']		= "Gebruik database compatibiliteits mode";
$GLOBALS['strCantConnectToDb']			= "Kan geen connectie maken met de database";



// Invocation and Delivery
$GLOBALS['strInvocationAndDelivery']		= "Aanroep en aflevering instellingen";

$GLOBALS['strAllowedInvocationTypes']		= "Toegestande aanroeptypes";
$GLOBALS['strAllowRemoteInvocation']		= "Gebruik Remote Invocation";
$GLOBALS['strAllowRemoteJavascript']		= "Gebruik Remote Invocation voor Javascript";
$GLOBALS['strAllowRemoteFrames']		= "Gebruik Remote Invocation voor Frames";
$GLOBALS['strAllowRemoteXMLRPC']		= "Gebruik Remote Invocation voor XML-RPC";
$GLOBALS['strAllowLocalmode']			= "Gebruik Lokale mode";
$GLOBALS['strAllowInterstitial']		= "Gebruik Interstitials";
$GLOBALS['strAllowPopups']			= "Gebruik Popups";

$GLOBALS['strKeywordRetrieval']			= "Sleutelwoord selectie";
$GLOBALS['strBannerRetrieval']			= "Banner selectie methode";
$GLOBALS['strRetrieveRandom']			= "Willekeurige banner selectie (standaard)";
$GLOBALS['strRetrieveNormalSeq']		= "Normale sequentieele banner selectie";
$GLOBALS['strWeightSeq']			= "Op gewicht gebaseerde sequentieele banner selectie";
$GLOBALS['strFullSeq']				= "Volledige sequentieele banner selectie";
$GLOBALS['strUseConditionalKeys']		= "Gebruik conditionele sleutelwoorden";
$GLOBALS['strUseMultipleKeys']			= "Gebruik meerdere sleutelwoorden";
$GLOBALS['strUseAcl']				= "Gebruik beperkingen";

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

$GLOBALS['strAllowedBannerTypes']		= "Toegestane banner types";
$GLOBALS['strTypeSqlAllow']			= "Sta lokale banners toe (SQL)";
$GLOBALS['strTypeWebAllow']			= "Sta lokale banners toe (Webserver)";
$GLOBALS['strTypeUrlAllow']			= "Sta externe banners toe";
$GLOBALS['strTypeHtmlAllow']			= "Sta HTML banners toe";

$GLOBALS['strTypeWebSettings']			= "Lokale banner (Webserver) instellingen";
$GLOBALS['strTypeWebMode']			= "Opslag methode";
$GLOBALS['strTypeWebModeLocal']			= "Lokale map";
$GLOBALS['strTypeWebModeFtp']			= "Externe FTP server)";
$GLOBALS['strTypeWebDir']			= "Lokale map";
$GLOBALS['strTypeWebFtp']			= "FTP server";
$GLOBALS['strTypeWebUrl']			= "Publieke URL";
$GLOBALS['strTypeFTPHost']			= "FTP server";
$GLOBALS['strTypeFTPDirectory']			= "Server map";
$GLOBALS['strTypeFTPUsername']			= "Gebruikersnaam";
$GLOBALS['strTypeFTPPassword']			= "Wachtwoord";

$GLOBALS['strDefaultBanners']			= "Standaard banner";
$GLOBALS['strDefaultBannerUrl']			= "Standaard banner afbeelding";
$GLOBALS['strDefaultBannerTarget']		= "Standaard banner doellocatie";

$GLOBALS['strTypeHtmlSettings']			= "HTML banner opties";
$GLOBALS['strTypeHtmlAuto']			= "Verander HTML automatisch om het loggen van AdClicks te forceren";
$GLOBALS['strTypeHtmlPhp']			= "Sta het gebruik van PHP code toe binnen in HTML banners.";



// Statistics Settings
$GLOBALS['strStatisticsSettings']		= "Statistieken Instellingen";

$GLOBALS['strStatisticsFormat']			= "Statistieken formaat";
$GLOBALS['strLogBeacon']			= "Gebruik beacons om Adviews te loggen";
$GLOBALS['strCompactStats']			= "Gebruik compacte statistieken";
$GLOBALS['strLogAdviews']			= "Log AdViews";
$GLOBALS['strBlockAdviews']			= "Log protectie (sec.)";
$GLOBALS['strLogAdclicks']			= "Log AdClicks";
$GLOBALS['strBlockAdclicks']			= "Log protectie (sec.)";

$GLOBALS['strEmailWarnings']			= "Waarschuwingen per email";
$GLOBALS['strAdminEmailHeaders']		= "Headers voor gebruik in te verzenden email";
$GLOBALS['strWarnLimit']			= "Waarschuwings limiet";
$GLOBALS['strWarnLimitErr']			= "Waarschuwings limiet moet een positief nummer zijn";
$GLOBALS['strWarnAdmin']			= "Waarschuw de beheerder";
$GLOBALS['strWarnClient']			= "Waarschuw de klant";
$GLOBALS['strQmailPatch']			= "Pas headers aan voor qmail";

$GLOBALS['strRemoteHosts']			= "Remote hosts";
$GLOBALS['strIgnoreHosts']			= "Negeer hosts";
$GLOBALS['strReverseLookup']			= "Reverse DNS Lookup";
$GLOBALS['strProxyLookup']			= "Proxy Lookup";



// Administrator settings
$GLOBALS['strAdministratorSettings']		= "Beheerder instellingen";

$GLOBALS['strLoginCredentials']			= "Inlog gegevens";
$GLOBALS['strAdminUsername']			= "Gebruikersnaam van de beheerder";
$GLOBALS['strOldPassword']			= "Oud wachtwoord";
$GLOBALS['strNewPassword']			= "Nieuw wachtwoord";
$GLOBALS['strInvalidUsername']			= "Ongeldige gebruikersnaam";
$GLOBALS['strInvalidPassword']			= "Ongeldig wachtwoord";

$GLOBALS['strBasicInformation']			= "Basis informatie";
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


// User interface settings
$GLOBALS['strGuiSettings']			= "Gebruikersinterface instellingen";

$GLOBALS['strGeneralSettings']			= "Algemene instellingen";
$GLOBALS['strAppName']				= "Applicatienaam";
$GLOBALS['strMyHeader']				= "Voetnoot";
$GLOBALS['strMyFooter']				= "Eindnoot";
$GLOBALS['strGzipContentCompression']		= "Gebruik GZIP content compression";

$GLOBALS['strClientInterface']			= "Adverteerder interface";
$GLOBALS['strClientWelcomeEnabled']		= "Toon een welkomstbericht";
$GLOBALS['strClientWelcomeText']		= "Welkomstbericht<br>(HTML is toegestaan)";



// Interface defaults
$GLOBALS['strInterfaceDefaults']		= "Interface standaardwaarden";

$GLOBALS['strInventory']			= "Vooraad";
$GLOBALS['strShowCampaignInfo']			= "Toon extra campagne informatie op de <i>Campagne overzicht</i> pagina";
$GLOBALS['strShowBannerInfo']			= "Toon extra banner informatie op de <i>Banner overzicht</i> pagina";
$GLOBALS['strShowCampaignPreview']		= "Toon voorvertooning van alle banners op de <i>Banner overzicht</i> pagina";
$GLOBALS['strShowBannerHTML']			= "Toon werkelijke banner in plaats van HTML code voor de voorvertoning van HTML banners";
$GLOBALS['strShowBannerPreview']		= "Toon voorvertoning bovenaan alle pagina's welke betrekking hebben op banners";
$GLOBALS['strHideInactive']			= "Verberg niet actieve items van de overzichtspagina's";

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

?>