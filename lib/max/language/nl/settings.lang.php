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

// Installer translation strings
$GLOBALS['strInstall'] = "Installatie";
$GLOBALS['strDatabaseSettings'] = "Database instellingen";
$GLOBALS['strAdminSettings'] = "Administrator instellingen";
$GLOBALS['strAdvancedSettings'] = "Geavanceerde instellingen";
$GLOBALS['strWarning'] = "Waarschuwing";
$GLOBALS['strBtnContinue'] = "Ga verder »";
$GLOBALS['strBtnGoBack'] = "« Ga terug";
$GLOBALS['strBtnAgree'] = "Ik ga akkoord »";
$GLOBALS['strBtnDontAgree'] = "« Ik ga niet akkoord";
$GLOBALS['strTablesType'] = "Tabeltype";



$GLOBALS['strOaUpToDate'] = "Jouw {$PRODUCT_NAME} database en bestandstructuur gebruiken beide de meest recente versie en moeten daardoor niet worden bijgewerkt op dit ogenblik. Gelieve op ga verder te drukken om verder te gaan naar het {$PRODUCT_NAME} administratie paneel.";
$GLOBALS['strOaUpToDateCantRemove'] = "Waarschuwing: het UPGRADE bestand is nog steeds te vinden in jouw var map. We kunnen dit bestand niet verwijderen omwille van ontbrekende rechten. Gelieve dit bestand zelf te verwijderen. ";
$GLOBALS['strRemoveUpgradeFile'] = "Je moet het UPGRADE bestand verwijderen in de map var";
$GLOBALS['strInstallSuccess'] = "<b>De installatie van {$PRODUCT_NAME} is nu compleet.</b><br /><br />Om goed te functioneren moet de onderhouds bestand elk uur
						   gedraaid worden. Meer informatie over dit onderwerp kunt u vinden in de documentatie.
						   <br /><br />Klik op <b>Verder</b> om door te gaan naar de configuratie pagina, waar u nog meer
						   items kunt instellen. Vergeet a.u.b. niet de permissies van het config.inc.php bestand weer terug te zetten, omdat dit
						   potentiele veiligheid problemen kan veroorzaken.";
$GLOBALS['strInstallNotSuccessful'] = "<b>De installatie van {$PRODUCT_NAME} was niet succesvol</b><br /><br />Sommige onderdelen van het installatie proces konden niet succesvol afgesloten worden.
Het is mogelijk dat deze problemen slechts tijdelijk zijn, in dat geval kunt u op <b>Verder</b> klikken en opnieuw
beginnen met de installatie. Indien u meer wilt weten over de foutmeldingen die hieronder vermeld staan, raadpleeg dan de
bijgesloten documentatie.";
$GLOBALS['strDbSuccessIntro'] = "De {$PRODUCT_NAME} database is nu aangemaakt. Gelieve op de  'ga verder' knop te drukken om verder te gaan met het instellen van {$PRODUCT_NAME} administrator en aanlever instellingen.";
$GLOBALS['strDbSuccessIntroUpgrade'] = "Uw systeem is met succes bijgewerkt. De volgende schermen zullen je helpen met het updaten van de configuratie van uw nieuwe advertentie server.";
$GLOBALS['strErrorOccured'] = "De volgende fouten zijn opgetreden:";
$GLOBALS['strErrorInstallDatabase'] = "De database kon niet worden aangemaakt.";
$GLOBALS['strErrorInstallDbConnect'] = "Het was niet mogelijk om een connectie te openen met de database.";

$GLOBALS['strErrorWritePermissions'] = "Bestandsrechten errors zijn gedetecteerd, en moeten worden opgelost om te kunnen verdergaan.<br />Om de errors onder Linux op te lossen, probeer eens volgende commando(s) in te geven:";

$GLOBALS['strErrorWritePermissionsWin'] = "Bestandsrechten errors zijn gedetecteerd, en moeten worden opgelost om te kunnen verdergaan.";
$GLOBALS['strCheckDocumentation'] = "Voor meer hulp, gelieve de <a href='http://{$PRODUCT_DOCSURL}'>{$PRODUCT_NAME} documentatie na te kijken</a>.";

$GLOBALS['strAdminUrlPrefix'] = "Admin interface URL";
$GLOBALS['strDeliveryUrlPrefix'] = "Bezorger";
$GLOBALS['strDeliveryUrlPrefixSSL'] = "Bezorger";

$GLOBALS['strInvalidUserPwd'] = "Ongeldige gebruikersnaam of wachtwoord";

$GLOBALS['strSystemUpToDate'] = "Uw systeem is al bijgewerkt, het is momenteel niet nodig om verder bij te werken. <br />Klik op <b>Verder</b> om door te gaan.";
$GLOBALS['strSystemNeedsUpgrade'] = "Om goed te functioneren moeten de database structuur en het configuratie bestand worden bijgewerkt. Klik op <b>Verder</b> om te beginnen met bijwerken. <br /><br />Afhankelijk van welke versie u wilt bijwerken en de hoeveelheid bestaande statistieken kan deze functie een hoge belasting veroorzaken op de database server. Het bijwerken kan enige minuten duren.";
$GLOBALS['strSystemUpgradeBusy'] = "Uw systeem wordt momenteel bijgewerkt, een moment geduld a.u.b...";
$GLOBALS['strSystemRebuildingCache'] = "Uw bestaande gegevens worden bijgewerkt, een moment geduld a.u.b...";
$GLOBALS['strServiceUnavalable'] = "Deze service is momenteel niet beschikbaar. Het systeem wordt bijgewerkt.";

/* ------------------------------------------------------- */
/* Configuration translations                            */
/* ------------------------------------------------------- */

// Global
$GLOBALS['strChooseSection'] = "Kies sectie";
$GLOBALS['strEditConfigNotPossible'] = "It is not possible to edit all settings because the configuration file is locked for security reasons. " .
    "If you want to make changes, you may need to unlock the configuration file for this installation first.";
$GLOBALS['strEditConfigPossible'] = "It is possible to edit all settings because the configuration file is not locked, but this could lead to security issues. " .
    "If you want to secure your system, you need to lock the configuration file for this installation.";

// Configuration Settings

// Administrator Settings
$GLOBALS['strAdministratorSettings'] = "Administrator instellingen";
$GLOBALS['strLoginCredentials'] = "Inlog gegevens";
$GLOBALS['strAdminUsername'] = "Gebruikersnaam van de beheerder";
$GLOBALS['strInvalidUsername'] = "Ongeldige gebruikersnaam";
$GLOBALS['strBasicInformation'] = "Basisinformatie";
$GLOBALS['strAdminFullName'] = "Volledige naam van de beheerder";
$GLOBALS['strAdminEmail'] = "E-mail adres van de beheerder";
$GLOBALS['strAdministratorEmail'] = "E-mail adres administrator";
$GLOBALS['strCompanyName'] = "Bedrijfsnaam";
$GLOBALS['strAdminCheckUpdates'] = "Controleer op nieuwe versie";
$GLOBALS['strAdminCheckEveryLogin'] = "Altijd";
$GLOBALS['strAdminCheckDaily'] = "Dagelijks";
$GLOBALS['strAdminCheckWeekly'] = "Wekelijks";
$GLOBALS['strAdminCheckMonthly'] = "Maandelijks";
$GLOBALS['strAdminCheckNever'] = "Nooit";
$GLOBALS['strUserlogEmail'] = "Sla alle uitgaande e-mails op";
$GLOBALS['strTimezone'] = "Tijdzone";
$GLOBALS['strTimezoneEstimated'] = "Geschatte tijdzone";
$GLOBALS['strTimezoneGuessedValue'] = "De tijdzone van de server is niet correct ingesteld in PHP";
$GLOBALS['strTimezoneSeeDocs'] = "Gelieve de  %DOCS% na te kijken over de instellingen van deze variabele voor PHP in te stellen.";
$GLOBALS['strTimezoneDocumentation'] = "documentatie";
$GLOBALS['strAdminSettingsTitle'] = "Maak een administrator account";
$GLOBALS['strAdminSettingsIntro'] = "Gelieve de velden te vervolledigen om jouw ad server administrator account aan te maken ";


// Database Settings
$GLOBALS['strDatabaseSettings'] = "Database instellingen";
$GLOBALS['strDatabaseServer'] = "Database server";
$GLOBALS['strDbLocal'] = "Gebruik een lokale server door middel van sockets";
$GLOBALS['strDbType'] = "Database naam";
$GLOBALS['strDbHost'] = "Database adres";
$GLOBALS['strDbPort'] = "Database poort nummer";
$GLOBALS['strDbUser'] = "Database gebruikersnaam";
$GLOBALS['strDbPassword'] = "Database wachtwoord";
$GLOBALS['strDbName'] = "Database naam";
$GLOBALS['strDatabaseOptimalisations'] = "Database optimalisaties";
$GLOBALS['strPersistentConnections'] = "Gebruik 'persistent connections'";
$GLOBALS['strCantConnectToDb'] = "Kan geen connectie maken met de database";



// Email Settings
$GLOBALS['strEmailSettings'] = "Hoofd instellingen";
$GLOBALS['strQmailPatch'] = "Pas headers aan voor qmail";

// Audit Trail Settings

// Debug Logging Settings

// Delivery Settings
$GLOBALS['strDeliverySettings'] = "Leveringsinstellingen";
$GLOBALS['strWebPath'] = "$PRODUCT_NAME Server Access Paths";
$GLOBALS['strDeliveryPath'] = "Leveringscache";
$GLOBALS['strDeliverySslPath'] = "Leveringscache";
$GLOBALS['strTypeWebSettings'] = "Lokale banner (Webserver) instellingen";
$GLOBALS['strTypeWebMode'] = "Opslag methode";
$GLOBALS['strTypeWebModeLocal'] = "Lokale map";
$GLOBALS['strTypeDirError'] = "De lokale map bestaat niet";
$GLOBALS['strTypeWebModeFtp'] = "Externe FTP server)";
$GLOBALS['strTypeWebDir'] = "Lokale map";
$GLOBALS['strTypeFTPHost'] = "FTP server";
$GLOBALS['strTypeFTPDirectory'] = "Server map";
$GLOBALS['strTypeFTPUsername'] = "Aanmelden";
$GLOBALS['strTypeFTPPassword'] = "Wachtwoord";
$GLOBALS['strTypeFTPErrorDir'] = "De server map bestaat niet";
$GLOBALS['strTypeFTPErrorConnect'] = "De verbinding met de FTP server kon niet worden opgebouwd, de gebruikersnaam of het wachtwoord zijn niet correct";
$GLOBALS['strTypeFTPErrorHost'] = "De hostname van de FTP server is niet correct";
$GLOBALS['strDeliveryFilenamesAdClick'] = "Ad Klik";
$GLOBALS['strDeliveryFilenamesAdContent'] = "Ad content ";
$GLOBALS['strDeliveryFilenamesAdFrame'] = "Ad frame";
$GLOBALS['strDeliveryFilenamesAdImage'] = "Ad afbeelding";
$GLOBALS['strDeliveryFilenamesAdJS'] = "Ad (javascript)";
$GLOBALS['strDeliveryFilenamesAdLayer'] = "Ad layer";
$GLOBALS['strDeliveryFilenamesAdLog'] = "Ad log";
$GLOBALS['strDeliveryFilenamesAdPopup'] = "Ad popup";
$GLOBALS['strDeliveryCaching'] = "Banner afleveringsinstellingen";



$GLOBALS['strUseP3P'] = "Gebruik P3P Policies";
$GLOBALS['strP3PCompactPolicy'] = "P3P Compacte Policy";
$GLOBALS['strP3PPolicyLocation'] = "P3P Policy Locatie";

// General Settings

// Geotargeting Settings
$GLOBALS['strGeotargetingSettings'] = "Geotargeting";
$GLOBALS['strGeotargeting'] = "Geotargeting";
$GLOBALS['strGeotargetingGeoipCountryLocation'] = "MaxMind GeoIP Land Database locatie";
$GLOBALS['strGeotargetingGeoipRegionLocation'] = "MaxMind GeoIP Regio Database Locatie";
$GLOBALS['strGeotargetingGeoipCityLocation'] = "MaxMind GeoIP Stad Database Locatie";
$GLOBALS['strGeotargetingGeoipAreaLocation'] = "MaxMind GeoIP Gebied Database Locatie";
$GLOBALS['strGeotargetingGeoipDmaLocation'] = "MaxMind GeoIP ISP Database Locatie";
$GLOBALS['strGeotargetingGeoipOrgLocation'] = "MaxMind GeoIP Organisatie Database Locatie";
$GLOBALS['strGeotargetingGeoipIspLocation'] = "MaxMind GeoIP ISP Database Locatie";
$GLOBALS['strGeotargetingGeoipNetspeedLocation'] = "MaxMind GeoIP Stad Database Locatie";

// Interface Settings
$GLOBALS['strInventory'] = "Inventaris";
$GLOBALS['strShowCampaignInfo'] = "Toon extra campagne informatie op de <i>Campagne</i> pagina";
$GLOBALS['strShowBannerInfo'] = "Toon extra banner informatie op de <i>Banners</i> pagina";
$GLOBALS['strShowCampaignPreview'] = "Toon voorvertooning van alle banners op de <i>Banners</i> pagina";
$GLOBALS['strShowBannerHTML'] = "Toon werkelijke banner in plaats van HTML code voor de voorvertoning van HTML banners";
$GLOBALS['strShowBannerPreview'] = "Toon voorvertoning bovenaan alle pagina's welke betrekking hebben op banners";
$GLOBALS['strHideInactive'] = "Verberg inactiviteit ";
$GLOBALS['strGUIShowMatchingBanners'] = "Toon geschikte banners op de <i>Gekoppelde banners</i> paginas";
$GLOBALS['strGUIShowParentCampaigns'] = "Toon bovenliggende campagnes op de <i>Gekoppelde banners</i> pagina";
$GLOBALS['strStatisticsDefaults'] = "Statistieken";
$GLOBALS['strBeginOfWeek'] = "Begin van de week";
$GLOBALS['strPercentageDecimals'] = "Nauwkeurigheid van percentages";
$GLOBALS['strWeightDefaults'] = "Standaard gewicht";
$GLOBALS['strDefaultBannerWeight'] = "Standaard banner gewicht";
$GLOBALS['strDefaultCampaignWeight'] = "Standaard campagne gewicht";
$GLOBALS['strDefaultBannerWErr'] = "Standaard banner gewicht moet een positief getal zijn";
$GLOBALS['strDefaultCampaignWErr'] = "Standaard campagne gewicht moet een positief getal zijn";

$GLOBALS['strCategories'] = "Categorieën";
$GLOBALS['strHelpFiles'] = "Help bestanden";

// CSV Import Settings

/**
 * @todo remove strBannerSettings if banner is only configurable as a preference
 *       rename // Banner Settings to  // Banner Preferences
 */
// Invocation Settings
$GLOBALS['strAllowedInvocationTypes'] = "Toegestande aanroeptypes";
$GLOBALS['strInvocationDefaults'] = "aanroep standaards";

// Banner Delivery Settings
$GLOBALS['strBannerDelivery'] = "Banner afleveringsinstellingen";

// Banner Logging Settings
$GLOBALS['strReverseLookup'] = "Probeer de hostname van de bezoeker te achterhalen als deze niet door de server wordt verstrekt";
$GLOBALS['strProxyLookup'] = "Probeer het echte IP adres van de bezoeker te achterhalen als er gebruik gemaakt wordt van een proxy server";
$GLOBALS['strIgnoreHosts'] = "Sla geen statistieken op van gebruikers met een van de volgende IP adressen";

// Banner Storage Settings

// Campaign ECPM settings

// Statistics & Maintenance Settings
$GLOBALS['strAdminEmailHeaders'] = "Voeg de volgende header toe aan elke e-mail bericht verzonden door {$PRODUCT_NAME}";
$GLOBALS['strWarnLimit'] = "Stuur een waarschuwing als de resterende impressies minder zijn dan hier gespecificeerd";
$GLOBALS['strWarnLimitErr'] = "Waarschuwings limiet moet een positief nummer zijn";
$GLOBALS['strWarnAdmin'] = "Stuur een waarschuwing naar de beheerder wanneer er voor een campagne bijna geen impressies meer over zijn";
$GLOBALS['strWarnClient'] = "Stuur een waarschuwing naar de adverteerder wanneer er voor een campagne bijna geen impressies meer over zijn";
$GLOBALS['strWarnAgency'] = "Stuur een waarschuwing naar de adverteerder wanneer er voor een campagne bijna geen impressies meer over zijn";

// UI Settings
$GLOBALS['strGuiSettings'] = "Gebruikersinterface instellingen";
$GLOBALS['strGeneralSettings'] = "Algemene instellingen";
$GLOBALS['strAppName'] = "Applicatienaam";
$GLOBALS['strMyHeader'] = "Voetnoot bestand";
$GLOBALS['strMyHeaderError'] = "De opgegeven locatie van het voetnoot bestand is niet correct";
$GLOBALS['strMyFooter'] = "Eindnoot bestand";
$GLOBALS['strMyFooterError'] = "De opgegeven locatie van het eindnoot bestand is niet correct";
$GLOBALS['strDashboardSettings'] = "Dashboard instellingen";

$GLOBALS['strMyLogoError'] = "Het logo bestand bestaat niet in de admin/images map";
$GLOBALS['strGuiHeaderForegroundColor'] = "Kleur van de header voorgrond";
$GLOBALS['strGuiHeaderBackgroundColor'] = "Kleur van de header achtergrond";
$GLOBALS['strGuiActiveTabColor'] = "Kleur van een actieve tab";
$GLOBALS['strGuiHeaderTextColor'] = "Kleur van headertekst";
$GLOBALS['strColorError'] = "Gelieve kleuren in het RGB formaat in te geven, zoals '0066CC'";

$GLOBALS['strGzipContentCompression'] = "Gebruik GZIP content compression";
$GLOBALS['strClientInterface'] = "Adverteerder interface";
$GLOBALS['strReportsInterface'] = "Raporteer interface";
$GLOBALS['strClientWelcomeEnabled'] = "Toon een welkomstbericht";
$GLOBALS['strClientWelcomeText'] = "Welkomstbericht<br />(HTML is toegestaan)";


// Regenerate Platfor Hash script

// Plugin Settings

/* ------------------------------------------------------- */
/* Unknown (unused?) translations                        */
/* ------------------------------------------------------- */

$GLOBALS['strExperimental'] = "Experimenteel";
$GLOBALS['strKeywordRetrieval'] = "Sleutelwoord selectie";
$GLOBALS['strBannerRetrieval'] = "Banner selectie methode";
$GLOBALS['strRetrieveRandom'] = "Willekeurige banner selectie (standaard)";
$GLOBALS['strRetrieveNormalSeq'] = "Normale sequentieele banner selectie";
$GLOBALS['strWeightSeq'] = "Op gewicht gebaseerde sequentieele banner selectie";
$GLOBALS['strFullSeq'] = "Volledige sequentieele banner selectie";
$GLOBALS['strUseConditionalKeys'] = "Sta het gebruik van logische operatoren toe tijdens directe selectie";
$GLOBALS['strUseMultipleKeys'] = "Sta het gebruik van meerdere sleutelwoorden toe tijdens directe selectie";

$GLOBALS['strTableBorderColor'] = "Tabel rand kleur";
$GLOBALS['strTableBackColor'] = "Table achtergrond kleur";
$GLOBALS['strTableBackColorAlt'] = "Table achtergrond kleur (alternatief)";
$GLOBALS['strMainBackColor'] = "Globale achtergrond kleur";
$GLOBALS['strTimeZone'] = "Tijdzone";
