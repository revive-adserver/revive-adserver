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
$GLOBALS['strAdminAccount'] = "System Administrator Account";
$GLOBALS['strAdvancedSettings'] = "Geavanceerde instellingen";
$GLOBALS['strWarning'] = "Waarschuwing";
$GLOBALS['strBtnContinue'] = "Ga verder »";
$GLOBALS['strBtnRecover'] = "Herstellen »";
$GLOBALS['strBtnAgree'] = "Ik ga akkoord »";
$GLOBALS['strBtnRetry'] = "Probeer opnieuw";
$GLOBALS['strWarningRegisterArgcArv'] = "De PHP configuratie variabele register_argc_argv moet worden ingeschakeld om onderhoud vanaf de opdrachtregel uit te kunnen voeren.";
$GLOBALS['strTablesType'] = "Tabeltype";

$GLOBALS['strRecoveryRequiredTitle'] = "Bij uw vorige upgrade poging is een fout opgetreden";
$GLOBALS['strRecoveryRequired'] = "Er is een fout opgetreden tijdens het verwerken van uw vorige upgrade en {$PRODUCT_NAME} moeten proberen te herstellen van het upgrade proces. Klik hieronder op de knop Herstellen.";

$GLOBALS['strProductUpToDateTitle'] = "{$PRODUCT_NAME} is up-to-date";
$GLOBALS['strOaUpToDate'] = "Uw {$PRODUCT_NAME} database en bestandstructuur gebruiken beide de meest recente versie en hoeven daarom niet te worden bijgewerkt op dit ogenblik. Gelieve op ga verder te drukken om verder te gaan naar het administratie paneel.";
$GLOBALS['strOaUpToDateCantRemove'] = "Waarschuwing: het UPGRADE bestand is nog steeds te vinden in jouw var map. We kunnen dit bestand niet verwijderen omwille van ontbrekende rechten. Gelieve dit bestand zelf te verwijderen. ";
$GLOBALS['strErrorWritePermissions'] = "Bestandsrechten errors zijn gedetecteerd, en moeten worden opgelost om te kunnen verdergaan.<br />Om de errors onder Linux op te lossen, probeer eens volgende commando(s) in te geven:";
$GLOBALS['strNotWriteable'] = "NIET schrijfbaar";
$GLOBALS['strDirNotWriteableError'] = "Map moet schrijfbaar zijn";

$GLOBALS['strErrorWritePermissionsWin'] = "Bestandsrechten errors zijn gedetecteerd, en moeten worden opgelost om te kunnen verdergaan.";
$GLOBALS['strCheckDocumentation'] = "Voor meer hulp, gelieve de <a href='http://{$PRODUCT_DOCSURL}'>{$PRODUCT_NAME} documentatie na te kijken</a>.";
$GLOBALS['strSystemCheckBadPHPConfig'] = "Uw huidige PHP configuratie voldoet niet aan eisen van {$PRODUCT_NAME}. Om de problemen op te lossen, wijzig de instellingen in het bestand \"php.ini\".";

$GLOBALS['strAdminUrlPrefix'] = "Admin interface URL";
$GLOBALS['strDeliveryUrlPrefix'] = "Bezorger";
$GLOBALS['strDeliveryUrlPrefixSSL'] = "Bezorger";
$GLOBALS['strImagesUrlPrefix'] = "URL voor opgeslagen afbeeldingen";
$GLOBALS['strImagesUrlPrefixSSL'] = "URL voor opgeslagen afbeeldingen (SSL)";

/* ------------------------------------------------------- */
/* Configuration translations                            */
/* ------------------------------------------------------- */

// Global
$GLOBALS['strChooseSection'] = "Kies sectie";
$GLOBALS['strEditConfigNotPossible'] = "It is not possible to edit all settings because the configuration file is locked for security reasons. " .
    "If you want to make changes, you may need to unlock the configuration file for this installation first.";
$GLOBALS['strEditConfigPossible'] = "It is possible to edit all settings because the configuration file is not locked, but this could lead to security issues. " .
    "If you want to secure your system, you need to lock the configuration file for this installation.";
$GLOBALS['strUnableToWriteConfig'] = "Wegschrijven van wijzigingen in de config file was niet mogelijk";
$GLOBALS['strUnableToWritePrefs'] = "Wegschrijven van voorkeursinstellingen in de database was niet mogelijk";

// Configuration Settings
$GLOBALS['strConfigurationSettings'] = "Configuratie-instellingen";

// Administrator Settings
$GLOBALS['strAdminUsername'] = "Gebruikersnaam van de beheerder";
$GLOBALS['strAdminPassword'] = "Systeembeheerder-wachtwoord";
$GLOBALS['strInvalidUsername'] = "Ongeldige gebruikersnaam";
$GLOBALS['strBasicInformation'] = "Basisinformatie";
$GLOBALS['strAdministratorEmail'] = "E-mail adres administrator";
$GLOBALS['strAdminCheckUpdates'] = "Controleer op nieuwe versie";
$GLOBALS['strAdminShareStack'] = "Technische informatie delen met het {$PRODUCT_NAME} Team om te helpen met de ontwikkeling en het testen.";
$GLOBALS['strNovice'] = "Verwijder-acties vereisen voor de veiligheid een bevestiging";
$GLOBALS['strUserlogEmail'] = "Sla alle uitgaande e-mails op";
$GLOBALS['strEnableDashboard'] = "Inschakelen van dashboard";
$GLOBALS['strEnableDashboardSyncNotice'] = "Schakel <a href='account-settings-update.php'>controleren op updates</a> in om het dashboard te gebruiken.";
$GLOBALS['strTimezone'] = "Tijdzone";


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
$GLOBALS['strDbNameHint'] = "Database zal worden gemaakt als deze niet bestaat";
$GLOBALS['strDatabaseOptimalisations'] = "Database optimalisaties";
$GLOBALS['strPersistentConnections'] = "Gebruik 'persistent connections'";
$GLOBALS['strCantConnectToDb'] = "Kan geen connectie maken met de database";

// Email Settings
$GLOBALS['strEmailSettings'] = "Hoofd instellingen";
$GLOBALS['strEmailAddresses'] = "Email 'From' adres";
$GLOBALS['strEmailFromName'] = "Email 'From' naam";
$GLOBALS['strEmailFromAddress'] = "Email 'From' email adres";
$GLOBALS['strEmailFromCompany'] = "Email 'From' bedrijf";
$GLOBALS['strQmailPatch'] = "Pas headers aan voor qmail";
$GLOBALS['strEnableQmailPatch'] = "Inschakelen van qmail patch";
$GLOBALS['strEmailHeader'] = "Email headers";

// Audit Trail Settings
$GLOBALS['strEnableAudit'] = "Audit trail inschakelen";

// Debug Logging Settings

// Delivery Settings
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

// Invocation Settings
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
$GLOBALS['strWarnAdmin'] = "Stuur een waarschuwing naar de beheerder wanneer er voor een campagne bijna geen impressies meer over zijn";
$GLOBALS['strWarnClient'] = "Stuur een waarschuwing naar de adverteerder wanneer er voor een campagne bijna geen impressies meer over zijn";
$GLOBALS['strWarnAgency'] = "Stuur een waarschuwing naar de adverteerder wanneer er voor een campagne bijna geen impressies meer over zijn";

// UI Settings
$GLOBALS['strGuiSettings'] = "Gebruikersinterface instellingen";
$GLOBALS['strGeneralSettings'] = "Algemene instellingen";
$GLOBALS['strAppName'] = "Applicatienaam";
$GLOBALS['strMyHeader'] = "Voetnoot bestand";
$GLOBALS['strMyFooter'] = "Eindnoot bestand";
$GLOBALS['strDashboardSettings'] = "Dashboard instellingen";
$GLOBALS['strGuiHeaderForegroundColor'] = "Kleur van de header voorgrond";
$GLOBALS['strGuiHeaderBackgroundColor'] = "Kleur van de header achtergrond";
$GLOBALS['strGuiActiveTabColor'] = "Kleur van een actieve tab";
$GLOBALS['strGuiHeaderTextColor'] = "Kleur van headertekst";
$GLOBALS['strGzipContentCompression'] = "Gebruik GZIP content compression";

// Regenerate Platfor Hash script

// Plugin Settings
