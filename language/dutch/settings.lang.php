<?php // $Revision$

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2001 by the phpAdsNew developers                       */
/* http://sourceforge.net/projects/phpadsnew                            */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/



// Installer translation strings
$GLOBALS['strInstall']					= "Installatie";
$GLOBALS['strChooseInstallLanguage']	= "Kies een taal voor de installatie procedure";
$GLOBALS['strLanguageSelection']		= "Taal selectie";
$GLOBALS['strDatabaseSettings']			= "Database instellingen";
$GLOBALS['strAdminSettings']			= "Beheer instellingen";
$GLOBALS['strAdvancedSettings']			= "Geavanceerde instellingen";
$GLOBALS['strOtherSettings']			= "Andere instellingen";

$GLOBALS['strWarning']					= "Waarschuwing";
$GLOBALS['strFatalError']				= "Er is een fout opgetreden";
$GLOBALS['strAlreadyInstalled']			= "phpAdsNew is reeds geinstalleerd op dit systeem. Indien u het systeem verder wilt configureren ga dan naar de <a href='settings-index.php'>instellingen</a>";
$GLOBALS['strCouldNotConnectToDB']		= "Er kon geen connectie opgebouwd worden met de database, controleer a.u.b. de door u opgegeven instellingen";
$GLOBALS['strCreateTableTestFailed']	= "De gebruiker die u heeft opgegeven heeft geen toestemming om de database aan te maken of te wijzigen, neem a.u.b. contact op met de beheerder van de database.";
$GLOBALS['strUpdateTableTestFailed']	= "De gebruiker die u heeft opgegeven heeft geen toestemming om de database structuur te wijzigen, neem a.u.b. contact op met de beheerder van de database.";
$GLOBALS['strTablePrefixInvalid']		= "Table prefix contains invalid characters";
$GLOBALS['strMayNotFunction']			= "Voor dat uw verder gaat, corrigeer a.u.b. de volgende problemen:";
$GLOBALS['strIgnoreWarnings']			= "Ignore warnings";
$GLOBALS['strWarningPHPversion']		= "phpAdsNew heeft minimaal PHP 3.0.8 nodig om te functioneren. U gebruik momenteel versie {php_version}.";
$GLOBALS['strWarningRegisterGlobals']	= "De PHP instelling register_globals moet aan staan.";
$GLOBALS['strWarningMagicQuotesGPC']	= "De PHP instelling magic_quote_gpc moet aan staan.";
$GLOBALS['strWarningMagicQuotesRuntime']= "De PHP instelling magic_quotes_runtime moet uit staan.";
$GLOBALS['strConfigLockedDetected']		= "phpAdsNew heeft gedetecteerd dat uw <b>config.inc.php</b> bestand niet beschrijfbaar is door de server.<br> U kunt niet verder gaan tot u de bestands permissies gewijzigd heeft. <br>Raadpleeg de begevoegde documentatie indien u niet weet hoe u dit kunt doen.";
$GLOBALS['strCantUpdateDB']  			= "Het is momenteel nog niet mogelijk om de database up te daten. Indien u beslist om door te gaan worden alle bestaande banners, statistieken and klanten verwijderd.";
$GLOBALS['strTableNames']				= "Tabelnamen";
$GLOBALS['strTablesPrefix']				= "Tabelnaam voorvoegsel";
$GLOBALS['strTablesType']				= "Tabeltype";

$GLOBALS['strInstallWelcome']			= "Welkom bij phpAdsNew";
$GLOBALS['strInstallMessage']			= "Voordat u phpAdsNew kunt gebruiken moet het eerst geconfigureerd <br> worden, tevens moet de database aangemaakt worden. Klik op <b>Verder</b> om door te gaan.";
$GLOBALS['strInstallSuccess']			= "<b>De installatie van phpAdsNew is nu compleet.</b><br><br>Om goed te functioneren moet de onderhouds bestand elke dag
										   gedraaid worden. Meer informatie over dit onderwerp kunt u vinden in de documentatie.
										   <br><br>Klik op <b>Verder</b> om door te gaan naar de configuratie pagina, waar u nog meer
										   items kunt instellen. Vergeet a.u.b. niet de permissies van het config.inc.php bestand weer terug te zetten, omdat dit
										   potentiele veiligheid problemen kan veroorzaken.";
$GLOBALS['strInstallNotSuccessful']		= "<b>De installatie van phpAdsNew was niet succesvol</b><br><br>Sommige onderdelen van het installatie proces konden niet succesvol.
										   afgesloten worden. Het is mogelijk dat deze problemen slechts tijdelijk zijn, in dat geval kunt u op <b>Verder</b> klikken en opnieuw
										   beginnen met de installatie. Indien u meer wilt weten over de foutmeldingen die hieronder vermeld staan, raadpleeg dan de 
										   bijgesloten documentatie.";
$GLOBALS['strErrorOccured']				= "De volgende fouten zijn opgetreden:";
$GLOBALS['strErrorInstallDatabase']		= "De database kon niet worden aangemaakt.";
$GLOBALS['strErrorInstallConfig']		= "Het configuratie bestand kont niet worden bijgewerkt.";
$GLOBALS['strErrorInstallDbConnect']	= "Het was niet mogelijk om een connectie te openen met de database.";

$GLOBALS['strUrlPrefix']				= "Locatie van phpAdsNew";

$GLOBALS['strProceed']					= "Verder &gt;";
$GLOBALS['strInstallDatabase']			= "Database structuur installatie";
$GLOBALS['strFunctionAlreadyExists']	= "Functie %s bestaat al";
$GLOBALS['strFunctionInAllDotSqlErr']	= "Kan geen functies creeren die vermeld staan in het 'all.sql' bestand";
$GLOBALS['strFunctionClickProceed']		= "Wilt u de bestande functies overschrijven?";
$GLOBALS['strYes']						= "Ja";
$GLOBALS['strNo']						= "Nee";
$GLOBALS['strDatabaseCreated']			= "De database structuur is succesvol aangemaakt:";
$GLOBALS['strTableCreated']				= "Tabel <b>%s</b> is succesvol aangemaakt";
$GLOBALS['strSequenceCreated']			= "Sequence <b>%s</b> is succesvol aangemaakt";
$GLOBALS['strIndexCreated']				= "Index <b>%s</b> is succesvol aangemaakt";
$GLOBALS['strFunctionCreated']			= "Functie <b>%s</b> is succesvol aangemaakt";
$GLOBALS['strFunctionReplaced']			= "Functie <b>%s</b> is succesvol vervangen";
$GLOBALS['strUnknownStatementExec']		= "Onbekende opdracht uitgevoerd";
$GLOBALS['strAdminPasswordSetup']		= "Beheerder wachtwoord instellingen";
$GLOBALS['strRepeatPassword']			= "Nogmaals";
$GLOBALS['strNotSamePasswords']			= "De opgegeven wachtwoorden kwamen niet overeen";
$GLOBALS['strInvalidUserPwd']			= "Ongeldige gebruikersnaam of wachtwoord";
$GLOBALS['strInstallCompleted']			= "Installatie succesvol afgesloten";
$GLOBALS['strInstallCompleted2']		= "Klik op <b>Verder</b> om door te gaan naar de configuratie pagina.";

$GLOBALS['strUpgrade']					= "Upgrade";
$GLOBALS['strSystemUpToDate']			= "Uw systeem is bijgewerkt, het is momenteel niet nodig om verder bij te werken. <br>Klik op <b>Verder</b> om door te gaan.";
$GLOBALS['strSystemNeedsUpgrade']		= "Om goed te functioneren moeten de database structuur en het configuratie bestand worden bijgewerkt. Klik op <b>Verder</b> om te beginnen met bijwerken. <br>Het bijwerken kan enige minuten duren.";
$GLOBALS['strSystemUpgradeBusy']		= "Uw systeem wordt momenteel bijgewerkt, een moment geduld a.u.b...";
$GLOBALS['strServiceUnavalable']		= "Deze service is momenteel niet beschikbaar. Het systeem wordt bijgewerkt.";
$GLOBALS['strDownloadConfig']			= "Download your <b>config.inc.php</b> and upload it to your server, then click <b>Proceed</b>.";
$GLOBALS['strDownload']					= "Download";

$GLOBALS['strConfigNotWritable']		= "Uw config.inc.php is niet te wijzigen";

// Settings translation strings
$GLOBALS['strChooseSection']			= "Kies sectie";

$GLOBALS['strDbHost']					= "Database server";
$GLOBALS['strDbUser']					= "Database gebruikersnaam";
$GLOBALS['strDbPassword']				= "Database wachtwoord";
$GLOBALS['strDbName']					= "Database naam";
$GLOBALS['strPersistentConnections']	= "Gebruik 'persistent connections'";
$GLOBALS['strInsertDelayed']			= "Gebruik 'delayed inserts'";
$GLOBALS['strCompatibilityMode']		= "Gebruik database compatibiliteits mode";
$GLOBALS['strCantConnectToDb']			= "Kan geen connectie maken met de database";

$GLOBALS['strAdminUsername']			= "Gebruikersnaam van de beheerder";
$GLOBALS['strAdminFullName']			= "Volledige naam van de beheerder";
$GLOBALS['strAdminEmail']				= "E-mail adres van de beheerder";
$GLOBALS['strAdminEmailHeaders']		= "Mail Headers for the reflection of the sender of the daily ad reports";
$GLOBALS['strAdminNovice']				= "Toon een waarschuwing wanneer er items verwijderd worden";
$GLOBALS['strOldPassword']				= "Oud wachtwoord";
$GLOBALS['strNewPassword']				= "Nieuw wachtwoord";
$GLOBALS['strInvalidUsername']			= "Ongeldige gebruikersnaam";
$GLOBALS['strInvalidPassword']			= "Ongeldig wachtwoord";

$GLOBALS['strGuiSettings']				= "Gebruikers Interface Instellingen";
$GLOBALS['strMyHeader']					= "My Header";
$GLOBALS['strMyFooter']					= "My Footer";
$GLOBALS['strTableBorderColor']			= "Table Border Color";
$GLOBALS['strTableBackColor']			= "Table Back Color";
$GLOBALS['strTableBackColorAlt']		= "Table Back Color (Alternative)";
$GLOBALS['strMainBackColor']			= "Main Back Color";
$GLOBALS['strAppName']					= "Applicatienaam";
$GLOBALS['strCompanyName']				= "Bedrijfsnaam";
$GLOBALS['strOverrideGD']				= "Override GD Imageformat";
$GLOBALS['strTimeZone']					= "Tijdzone";

$GLOBALS['strDayFullNames'] = array("zondag","maandag","dinsdag","woensdag","donderdag","vrijdag","zaterdag");

$GLOBALS['strIgnoreHosts']				= "Negeer hosts";
$GLOBALS['strWarnLimit']				= "Waarschuwings limiet";
$GLOBALS['strWarnLimitErr']				= "Waarschuwings limiet moet een positief nummer zijn";
$GLOBALS['strBeginOfWeek']				= "Begin van de week";
$GLOBALS['strPercentageDecimals']		= "Nauwkeurigheid van percentages";
$GLOBALS['strCompactStats']				= "Gebruik compacte statistieken";
$GLOBALS['strLogAdviews']				= "Log AdViews";
$GLOBALS['strLogAdclicks']				= "Log AdClicks";
$GLOBALS['strReverseLookup']			= "Reverse DNS Lookup";
$GLOBALS['strWarnAdmin']				= "Waarschuw de beheerder";
$GLOBALS['strWarnClient']				= "Waarschuw de klant";

$GLOBALS['strAllowedBannerTypes']		= "Toegestane banner types";
$GLOBALS['strTypeSqlAllow']				= "Sta banners opgeslagen in de SQL database toe";
$GLOBALS['strTypeWebAllow']				= "Sta banners opgeslagen op een webserver toe";
$GLOBALS['strTypeUrlAllow']				= "Sta URL banners toe";
$GLOBALS['strTypeHtmlAllow']			= "Sta HTML banners toe";
$GLOBALS['strTypeWebSettings']			= "Web banner instellingen";
$GLOBALS['strTypeWebMode']				= "Opslag methode";
$GLOBALS['strTypeWebModeLocal']			= "Lokaal (opgeslagen in een lokale map)";
$GLOBALS['strTypeWebModeFtp']			= "FTP (opgeslagen op een externe FTP server)";
$GLOBALS['strTypeWebDir']				= "Lokale map";
$GLOBALS['strTypeWebFtp']				= "FTP server";
$GLOBALS['strTypeWebUrl']				= "Publieke URL van de lokale map of FTP server";
$GLOBALS['strTypeHtmlSettings']			= "HTML banner instellingen";
$GLOBALS['strTypeHtmlAuto']				= "Verander HTML automatisch om het loggen van AdClicks te forceren";
$GLOBALS['strTypeHtmlPhp']				= "Sta het gebruik van PHP code toe binnen in HTML banners.";

$GLOBALS['strBannerRetrieval']			= "Banner selectie methode";
$GLOBALS['strRetrieveRandom']			= "Willekeurige banner selectie (standaard)";
$GLOBALS['strRetrieveNormalSeq']		= "Normale sequentieele banner selectie";
$GLOBALS['strWeightSeq']				= "Op gewicht gebaseerde sequentieele banner selectie";
$GLOBALS['strFullSeq']					= "Volledige sequentieele banner selectie";
$GLOBALS['strDefaultBannerUrl']			= "Standaard banner afbeelding";
$GLOBALS['strDefaultBannerTarget']		= "Standaard banner doellocatie";
$GLOBALS['strUseConditionalKeys']		= "Gebruik conditionele sleutelwoorden";
$GLOBALS['strUseMultipleKeys']			= "Gebruik meerdere sleutelwoorden";
$GLOBALS['strUseAcl']					= "Gebruik beperkingen";

$GLOBALS['strZonesSettings']			= "Zone Instellingen";
$GLOBALS['strZoneCache']				= "Cache zones, dit zou het gebruik moeten versnellen wanneer gebruik gemaakt word van zones";
$GLOBALS['strZoneCacheLimit']			= "Tijd tussen het updaten van de cache (in seconden)";
$GLOBALS['strZoneCacheLimitErr']		= "De tijd tussen het updaten van de cache moet een positief getal zijn";

$GLOBALS['strP3PSettings']				= "P3P Instellingen";
$GLOBALS['strUseP3P']					= "Gebruik P3P Policies";
$GLOBALS['strP3PCompactPolicy']			= "P3P Compacte Policy";
$GLOBALS['strP3PPolicyLocation']		= "P3P Policy Locatie";

$GLOBALS['strClientWelcomeMessage']		= "Klanten Welkomsbericht";
$GLOBALS['strClientWelcomeEnabled']		= "Toon een welkomsbericht";
$GLOBALS['strClientWelcomeText']		= "Welkomsbericht<br>(HTML is toegestaan)";

$GLOBALS['strDefaultBannerWeight']		= "Standaard banner gewicht";
$GLOBALS['strDefaultCampaignWeight']	= "Standaard campagne gewicht";

$GLOBALS['strDefaultBannerWErr']		= "Standaard banner gewicht moet een positief getal zijn";
$GLOBALS['strDefaultCampaignWErr']		= "Standaard campagne gewicht moet een positief getal zijn";

?>