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
$GLOBALS['strTablesPrefix'] = "Tabelnaam voorvoegsel";
$GLOBALS['strTablesType'] = "Tabeltype";

$GLOBALS['strRecoveryRequiredTitle'] = "Bij uw vorige upgrade poging is een fout opgetreden";
$GLOBALS['strRecoveryRequired'] = "Er is een fout opgetreden tijdens het verwerken van uw vorige upgrade en {$PRODUCT_NAME} moeten proberen te herstellen van het upgrade proces. Klik hieronder op de knop Herstellen.";

$GLOBALS['strProductUpToDateTitle'] = "{$PRODUCT_NAME} is up-to-date";
$GLOBALS['strOaUpToDate'] = "Uw {$PRODUCT_NAME} database en bestandstructuur gebruiken beide de meest recente versie en hoeven daarom niet te worden bijgewerkt op dit ogenblik. Gelieve op ga verder te drukken om verder te gaan naar het administratie paneel.";
$GLOBALS['strOaUpToDateCantRemove'] = "Waarschuwing: het UPGRADE bestand is nog steeds te vinden in jouw var map. We kunnen dit bestand niet verwijderen omwille van ontbrekende rechten. Gelieve dit bestand zelf te verwijderen. ";
$GLOBALS['strErrorWritePermissions'] = "Er zijn problemen geconstateerd m.b.t. bestandsrechten, deze moeten worden opgelost voordat u verder kunt gaan.<br />Om deze problemen te verhelpen op een Linux systeem, kunt u de volgende commando('s) proberen:";
$GLOBALS['strErrorFixPermissionsRCommand'] = "<i>chmod -R a+w %s</i>";
$GLOBALS['strNotWriteable'] = "NIET schrijfbaar";
$GLOBALS['strDirNotWriteableError'] = "Map moet schrijfbaar zijn";

$GLOBALS['strErrorWritePermissionsWin'] = "Er zijn problemen geconstateerd m.b.t. bestandsrechten, deze moeten worden opgelost voordat u verder kunt gaan.";
$GLOBALS['strCheckDocumentation'] = "Voor meer hulp, zie de <a href=\"{$PRODUCT_DOCSURL}\">{$PRODUCT_NAME}documentatie</a>.";
$GLOBALS['strSystemCheckBadPHPConfig'] = "Uw huidige PHP configuratie voldoet niet aan eisen van {$PRODUCT_NAME}. Om de problemen op te lossen, wijzig de instellingen in het bestand \"php.ini\".";

$GLOBALS['strAdminUrlPrefix'] = "Admin interface URL";
$GLOBALS['strDeliveryUrlPrefix'] = "Delivery Engine URL";
$GLOBALS['strDeliveryUrlPrefixSSL'] = "Delivery Engine URL (SSL)";
$GLOBALS['strImagesUrlPrefix'] = "URL voor opgeslagen afbeeldingen";
$GLOBALS['strImagesUrlPrefixSSL'] = "URL voor opgeslagen afbeeldingen (SSL)";


$GLOBALS['strUpgrade'] = "Upgrade";

/* ------------------------------------------------------- */
/* Configuration translations                            */
/* ------------------------------------------------------- */

// Global
$GLOBALS['strChooseSection'] = "Kies sectie";
$GLOBALS['strUnableToWriteConfig'] = "Wegschrijven van wijzigingen in de config file was niet mogelijk";
$GLOBALS['strUnableToWritePrefs'] = "Wegschrijven van voorkeursinstellingen in de database was niet mogelijk";
$GLOBALS['strImageDirLockedDetected'] = "De ingevoerde <b>Images Folder</b> is niet beschrijfbaar door de server. <br>U kunt niet verder gaan tot u ofwel de permissies van de folder heeft aangepast, of de betreffende folder heeft aangemaakt.";

// Configuration Settings
$GLOBALS['strConfigurationSettings'] = "Configuratie-instellingen";

// Administrator Settings
$GLOBALS['strAdminUsername'] = "Gebruikersnaam van de beheerder";
$GLOBALS['strAdminPassword'] = "Systeembeheerder-wachtwoord";
$GLOBALS['strInvalidUsername'] = "Ongeldige gebruikersnaam";
$GLOBALS['strBasicInformation'] = "Basisinformatie";
$GLOBALS['strAdministratorEmail'] = "Beheerder e-mail adres";
$GLOBALS['strAdminCheckUpdates'] = "Automatisch controleren op productupdates en beveiligingswaarschuwingen (aanbevolen).";
$GLOBALS['strAdminShareStack'] = "Technische informatie delen met het {$PRODUCT_NAME} Team om te helpen met de ontwikkeling en het testen.";
$GLOBALS['strNovice'] = "Verwijder-acties vereisen voor de veiligheid een bevestiging";
$GLOBALS['strUserlogEmail'] = "Sla alle uitgaande e-mails op";
$GLOBALS['strEnableDashboard'] = "Inschakelen van dashboard";
$GLOBALS['strEnableDashboardSyncNotice'] = "Schakel <a href='account-settings-update.php'>controleren op updates</a> in om het dashboard te gebruiken.";
$GLOBALS['strTimezone'] = "Tijdzone";
$GLOBALS['strEnableAutoMaintenance'] = "Automatisch het onderhoudsproces uitvoeren tijdens uitlevering van banners als gepland onderhoud niet is ingesteld";

// Database Settings
$GLOBALS['strDatabaseSettings'] = "Database instellingen";
$GLOBALS['strDatabaseServer'] = "Instellingen voor databaseserver";
$GLOBALS['strDbLocal'] = "Gebruik een lokale server door middel van sockets";
$GLOBALS['strDbType'] = "Database Type";
$GLOBALS['strDbHost'] = "Database hostnaam";
$GLOBALS['strDbSocket'] = "Database Socket";
$GLOBALS['strDbPort'] = "Database poort nummer";
$GLOBALS['strDbUser'] = "Database gebruikersnaam";
$GLOBALS['strDbPassword'] = "Database wachtwoord";
$GLOBALS['strDbName'] = "Database naam";
$GLOBALS['strDbNameHint'] = "Database zal worden gemaakt als deze niet bestaat";
$GLOBALS['strDatabaseOptimalisations'] = "Database optimalisatie-instellingen";
$GLOBALS['strPersistentConnections'] = "Gebruik 'persistent connections'";
$GLOBALS['strCantConnectToDb'] = "Kan geen connectie maken met de database";
$GLOBALS['strCantConnectToDbDelivery'] = 'Kan geen verbinding maken met de database voor uitlevering van banners';

// Email Settings
$GLOBALS['strEmailSettings'] = "Email instellingen";
$GLOBALS['strEmailAddresses'] = "Email 'From' adres";
$GLOBALS['strEmailFromName'] = "Email 'From' naam";
$GLOBALS['strEmailFromAddress'] = "Email 'From' email adres";
$GLOBALS['strEmailFromCompany'] = "Email 'From' bedrijf";
$GLOBALS['strUseManagerDetails'] = 'Gebruik de contactgegevens (naam en e-mail) van het account om de rapportages voor Adverteerders of websites te mailen, in plaats van de bovenstaande contactgegevens.';
$GLOBALS['strQmailPatch'] = "Pas headers aan voor qmail";
$GLOBALS['strEnableQmailPatch'] = "Inschakelen van qmail patch";
$GLOBALS['strEmailHeader'] = "Email headers";
$GLOBALS['strEmailLog'] = "E-mail log";

// Audit Trail Settings
$GLOBALS['strAuditTrailSettings'] = "Audit Trail Instellingen";
$GLOBALS['strEnableAudit'] = "Audit trail inschakelen";
$GLOBALS['strEnableAuditForZoneLinking'] = "Audit Trail voor het scherm Zones koppelen inschakelen (resulteert in een ernstige performance-daling bij het linken van een groot aantal zones)";

// Debug Logging Settings
$GLOBALS['strDebug'] = "Debug Logging Instellingen";
$GLOBALS['strEnableDebug'] = "Debug Logging inschakelen";
$GLOBALS['strDebugMethodNames'] = "Method names opnemen in Debug log";
$GLOBALS['strDebugLineNumbers'] = "Regelnummers opnemen in debug log";
$GLOBALS['strDebugType'] = "Debug Log Type";
$GLOBALS['strDebugTypeFile'] = "Bestand";
$GLOBALS['strDebugTypeMcal'] = "mCal";
$GLOBALS['strDebugTypeSql'] = "SQL-Database";
$GLOBALS['strDebugTypeSyslog'] = "Syslog";
$GLOBALS['strDebugName'] = "Debug Log Name, Calendar, SQL Table,<br />of Syslog Facility";
$GLOBALS['strDebugPriority'] = "Debug Priority Level";
$GLOBALS['strPEAR_LOG_DEBUG'] = "PEAR_LOG_DEBUG - Most Information";
$GLOBALS['strPEAR_LOG_INFO'] = "PEAR_LOG_INFO - Default Information";
$GLOBALS['strPEAR_LOG_NOTICE'] = "PEAR_LOG_NOTICE";
$GLOBALS['strPEAR_LOG_WARNING'] = "PEAR_LOG_WARNING";
$GLOBALS['strPEAR_LOG_ERR'] = "PEAR_LOG_ERR";
$GLOBALS['strPEAR_LOG_CRIT'] = "PEAR_LOG_CRIT";
$GLOBALS['strPEAR_LOG_ALERT'] = "PEAR_LOG_ALERT";
$GLOBALS['strPEAR_LOG_EMERG'] = "PEAR_LOG_EMERG - Least Information";
$GLOBALS['strDebugIdent'] = "Debug Identification String";
$GLOBALS['strDebugUsername'] = "mCal, SQL Server Username";
$GLOBALS['strDebugPassword'] = "mCal, SQL Server Password";
$GLOBALS['strProductionSystem'] = "Production System";

// Delivery Settings
$GLOBALS['strWebPath'] = "{$PRODUCT_NAME} Server toegang paden";
$GLOBALS['strWebPathSimple'] = "Web path";
$GLOBALS['strDeliveryPath'] = "Delivery path";
$GLOBALS['strImagePath'] = "Images path";
$GLOBALS['strDeliverySslPath'] = "Delivery SSL path";
$GLOBALS['strImageSslPath'] = "Images SSL path";
$GLOBALS['strImageStore'] = "Images folder";
$GLOBALS['strTypeWebSettings'] = "Lokale banner (Webserver) instellingen";
$GLOBALS['strTypeWebMode'] = "Opslag methode";
$GLOBALS['strTypeWebModeLocal'] = "Lokale map";
$GLOBALS['strTypeDirError'] = "De lokale map niet kan worden geschreven door de webserver";
$GLOBALS['strTypeWebModeFtp'] = "Externe FTP-Server";
$GLOBALS['strTypeWebDir'] = "Lokale map";
$GLOBALS['strTypeFTPHost'] = "FTP server";
$GLOBALS['strTypeFTPDirectory'] = "Server map";
$GLOBALS['strTypeFTPUsername'] = "Gebruikersnaam";
$GLOBALS['strTypeFTPPassword'] = "Wachtwoord";
$GLOBALS['strTypeFTPPassive'] = "Passieve FTP gebruiken";
$GLOBALS['strTypeFTPErrorDir'] = "De server map bestaat niet";
$GLOBALS['strTypeFTPErrorConnect'] = "De verbinding met de FTP server kon niet worden opgebouwd, de gebruikersnaam of het wachtwoord zijn niet correct";
$GLOBALS['strTypeFTPErrorNoSupport'] = "Uw installatie van PHP biedt geen ondersteuning voor FTP.";
$GLOBALS['strTypeFTPErrorUpload'] = "Uploaden van het bestand naar de FTP server is niet gelukt, controleer of de directory op de server de juiste rechten heeft";
$GLOBALS['strTypeFTPErrorHost'] = "De hostname van de FTP server is niet correct";
$GLOBALS['strDeliveryFilenames'] = "Delivery Bestandsnamen";
$GLOBALS['strDeliveryFilenamesAdClick'] = "Ad Click";
$GLOBALS['strDeliveryFilenamesAdConversionVars'] = "Advertentie conversie variabelen";
$GLOBALS['strDeliveryFilenamesAdContent'] = "Ad Content";
$GLOBALS['strDeliveryFilenamesAdConversion'] = "Advertentie conversie";
$GLOBALS['strDeliveryFilenamesAdConversionJS'] = "Advertentie conversie (JavaScript)";
$GLOBALS['strDeliveryFilenamesAdFrame'] = "Ad Frame";
$GLOBALS['strDeliveryFilenamesAdImage'] = "Ad Image";
$GLOBALS['strDeliveryFilenamesAdJS'] = "Ad (JavaScript)";
$GLOBALS['strDeliveryFilenamesAdLayer'] = "Ad Layer";
$GLOBALS['strDeliveryFilenamesAdLog'] = "Ad Log";
$GLOBALS['strDeliveryFilenamesAdPopup'] = "Ad Popup";
$GLOBALS['strDeliveryFilenamesAdView'] = "Ad View";
$GLOBALS['strDeliveryFilenamesXMLRPC'] = "XML RPC Invocation";
$GLOBALS['strDeliveryFilenamesLocal'] = "Local Invocation";
$GLOBALS['strDeliveryFilenamesFrontController'] = "Front Controller";
$GLOBALS['strDeliveryFilenamesFlash'] = "Flash Include (kan een volledige URL zijn)";
$GLOBALS['strDeliveryFilenamesSinglePageCall'] = "Single Page Call";
$GLOBALS['strDeliveryFilenamesSinglePageCallJS'] = "Single Page Call (JavaScript)";
$GLOBALS['strDeliveryCaching'] = "Instellingen voor de buffering van uitlevering van banners";
$GLOBALS['strDeliveryCacheLimit'] = "Tijd tussen Banner Cache Updates (seconden)";
$GLOBALS['strDeliveryCacheStore'] = "Banner Delivery Cache Store Type";
$GLOBALS['strDeliveryAcls'] = "Evalueer banner delivery limitations tijdens uitlevering";
$GLOBALS['strDeliveryAclsDirectSelection'] = "Evalueer banner delivery limitations tijdens uitlevering van direct geselecteerde banners";
$GLOBALS['strDeliveryObfuscate'] = "Channel verbergen tijdens uitlevering van advertenties";
$GLOBALS['strDeliveryExecPhp'] = "Sta toe dat PHP code in banners wordt uitgevoerd<br />(waarschuwing: veiligheidsrisico)";
$GLOBALS['strDeliveryCtDelimiter'] = "Scheidingsteken voor derde partij Click Tracking";
$GLOBALS['strGlobalDefaultBannerUrl'] = "Algemene standaard banner afbeeldings-URL";
$GLOBALS['strP3PSettings'] = "P3P-privacybeleid";
$GLOBALS['strUseP3P'] = "Gebruik P3P Policies";
$GLOBALS['strP3PCompactPolicy'] = "P3P Compacte Policy";
$GLOBALS['strP3PPolicyLocation'] = "P3P Policy Locatie";

// General Settings
$GLOBALS['generalSettings'] = "Globale algemene systeeminstellingen";
$GLOBALS['uiEnabled'] = "Gebruikersinterface ingeschakeld";
$GLOBALS['defaultLanguage'] = "Standaard systeemtaal<br />(Elke gebruiker kan een eigen taalvoorkeur kiezen)";

// Geotargeting Settings
$GLOBALS['strGeotargetingSettings'] = "Geotargeting Instellingen";
$GLOBALS['strGeotargeting'] = "Geotargeting Instellingen";
$GLOBALS['strGeotargetingType'] = "Geotargeting Module Type";
$GLOBALS['strGeoShowUnavailable'] = "Toon geotargeting uitleveringbeperkingen zelfs als GeoIP gegevens niet beschikbaar zijn";

// Interface Settings
$GLOBALS['strInventory'] = "Inventaris";
$GLOBALS['strShowCampaignInfo'] = "Toon extra campagne informatie op de <i>Campagne</i> pagina";
$GLOBALS['strShowBannerInfo'] = "Toon extra banner informatie op de <i>Banners</i> pagina";
$GLOBALS['strShowCampaignPreview'] = "Toon voorvertooning van alle banners op de <i>Banners</i> pagina";
$GLOBALS['strShowBannerHTML'] = "Toon werkelijke banner in plaats van HTML code voor de voorvertoning van HTML banners";
$GLOBALS['strShowBannerPreview'] = "Toon voorvertoning bovenaan alle pagina's die betrekking hebben op banners";
$GLOBALS['strHideInactive'] = "Verberg niet-actieve items van alle overzichtspagina's";
$GLOBALS['strGUIShowMatchingBanners'] = "Toon geschikte banners op de <i>Gekoppelde banners</i> pagina's";
$GLOBALS['strGUIShowParentCampaigns'] = "Toon bovenliggende campagnes op de <i>Gekoppelde banners</i> pagina's";
$GLOBALS['strShowEntityId'] = "Toon entiteit-ID 's";
$GLOBALS['strStatisticsDefaults'] = "Statistieken";
$GLOBALS['strBeginOfWeek'] = "Begin van de week";
$GLOBALS['strPercentageDecimals'] = "Nauwkeurigheid van percentages";
$GLOBALS['strWeightDefaults'] = "Standaard gewicht";
$GLOBALS['strDefaultBannerWeight'] = "Standaard banner gewicht";
$GLOBALS['strDefaultCampaignWeight'] = "Standaard campagne gewicht";
$GLOBALS['strConfirmationUI'] = "Bevestiging in gebruikersinterface";

// Invocation Settings
$GLOBALS['strInvocationDefaults'] = "Invocation standaardwaardes";
$GLOBALS['strEnable3rdPartyTrackingByDefault'] = "Derde partij Clicktracking standaard inschakelen";

// Banner Delivery Settings
$GLOBALS['strBannerDelivery'] = "Banner uitleveringsinstellingen";

// Banner Logging Settings
$GLOBALS['strBannerLogging'] = "Banner registratie instellingen";
$GLOBALS['strLogAdRequests'] = "Tel een request elke keer als een banner wordt opgevraagd";
$GLOBALS['strLogAdImpressions'] = "Tel een impressie elke keer als een banner wordt weergegeven";
$GLOBALS['strLogAdClicks'] = "Tel een klik elke keer als een viewer op een banner klikt";
$GLOBALS['strReverseLookup'] = "Probeer de hostname van de bezoeker te achterhalen als deze niet door de server wordt verstrekt";
$GLOBALS['strProxyLookup'] = "Probeer het echte IP adres van de bezoeker te achterhalen als er gebruik gemaakt wordt van een proxy server";
$GLOBALS['strPreventLogging'] = "Instellingen voor het verhinderen van registratie van banner statistieken";
$GLOBALS['strIgnoreHosts'] = "Sla geen statistieken op van gebruikers met een van de volgende IP adressen";
$GLOBALS['strIgnoreUserAgents'] = "<b>Geen</b> statistieken vastleggen van clients met een van de volgende tekenreeksen in hun user-agent (één-per-regel)";
$GLOBALS['strEnforceUserAgents'] = "<b>Alleen</b> statistieken vastleggen van clients met een van de volgende tekenreeksen in hun user-agent (één-per-regel)";

// Banner Storage Settings
$GLOBALS['strBannerStorage'] = "Banner-Opslaginstellingen";

// Campaign ECPM settings
$GLOBALS['strEnableECPM'] = "Gebruik prioriteiten op basis van eCPM optimalisatie in plaats van prioriteiten op basis van de gewichten van Remnant campagnes";
$GLOBALS['strEnableContractECPM'] = "Gebruik prioriteiten op basis van eCPM optimalisatie in plaats van standaard contract prioriteiten";
$GLOBALS['strEnableECPMfromRemnant'] = "(als u deze functie inschakelt zullen als uw Remnant campagnes worden gedeactiveerd, u zult ze handmatig moeten aanpassen om ze opnieuw te activeren)";
$GLOBALS['strEnableECPMfromECPM'] = "(als u deze functie uitschakelt zullen sommige van uw actieve eCPM campagnes gedeactiveerd worden, u zult ze handmatig moeten aanpassen om ze opnieuw te activeren)";
$GLOBALS['strInactivatedCampaigns'] = "Lijst van campagnes die inactief zijn geworden als gevolg van de veranderingen in de instellingen:";

// Statistics & Maintenance Settings
$GLOBALS['strMaintenanceSettings'] = "Onderhoudsinstellingen";
$GLOBALS['strConversionTracking'] = "Instellingen voor Conversion Tracking";
$GLOBALS['strEnableConversionTracking'] = "Conversion Tracking inschakelen";
$GLOBALS['strBlockAdClicks'] = "Tel geen kliks als de bezoeker op dezelfde advertentie/zone heeft geklikt binnen de aangegeven tijdsduur (secondes)";
$GLOBALS['strMaintenanceOI'] = "Operatie onderhoudsinterval (minuten)";
$GLOBALS['strPrioritySettings'] = "Prioriteitsinstellingen";
$GLOBALS['strPriorityInstantUpdate'] = "Bijwerken van advertentie prioriteiten onmiddellijk nadat er wijzigingen aangebracht via de gebruikersinterface";
$GLOBALS['strPriorityIntentionalOverdelivery'] = "Contract campagnes opzettelijk extra uitleveren<br />(% meer-uitlevering)";
$GLOBALS['strDefaultImpConWindow'] = "Standaard maximaal tijdsverloop tussen vertoning en connectie (seconden)";
$GLOBALS['strDefaultCliConWindow'] = "Standaard maximaal tijdsverloop tussen klik en connectie (seconden)";
$GLOBALS['strAdminEmailHeaders'] = "Voeg de volgende header toe aan elke e-mail bericht verzonden door {$PRODUCT_NAME}";
$GLOBALS['strWarnLimit'] = "Stuur een waarschuwing als de resterende impressies minder zijn dan hier gespecificeerd";
$GLOBALS['strWarnLimitDays'] = "Stuur een waarschuwing wanneer het aantal overgebleven dagen minder is dan het hier opgegeven";
$GLOBALS['strWarnAdmin'] = "Stuur een waarschuwing naar de systeembeheerder wanneer er voor een campagne bijna geen impressies meer over zijn";
$GLOBALS['strWarnClient'] = "Stuur een waarschuwing naar de adverteerder wanneer er voor een campagne bijna geen impressies meer over zijn";
$GLOBALS['strWarnAgency'] = "Stuur een waarschuwing naar de beheerder wanneer er voor een campagne bijna geen impressies meer over zijn";

// UI Settings
$GLOBALS['strGuiSettings'] = "Gebruikersinterface instellingen";
$GLOBALS['strGeneralSettings'] = "Algemene instellingen";
$GLOBALS['strAppName'] = "Applicatienaam";
$GLOBALS['strMyHeader'] = "Header bestandslocatie";
$GLOBALS['strMyFooter'] = "Footer Bestandslocatie";
$GLOBALS['strDefaultTrackerStatus'] = "Standaard tracker status";
$GLOBALS['strDefaultTrackerType'] = "Standaardtype tracker";
$GLOBALS['strSSLSettings'] = "SSL-instellingen";
$GLOBALS['requireSSL'] = "SSL toegang op gebruikersinterface forceren";
$GLOBALS['sslPort'] = "SSL-poort die wordt gebruikt door webserver";
$GLOBALS['strDashboardSettings'] = "Dashboard instellingen";
$GLOBALS['strMyLogo'] = "Naam/URL van aangepaste logo-bestand";
$GLOBALS['strGuiHeaderForegroundColor'] = "Kleur van de header voorgrond";
$GLOBALS['strGuiHeaderBackgroundColor'] = "Kleur van de header achtergrond";
$GLOBALS['strGuiActiveTabColor'] = "Kleur van een actieve tab";
$GLOBALS['strGuiHeaderTextColor'] = "Kleur van headertekst";
$GLOBALS['strGuiSupportLink'] = "Aangepaste URL voor 'Support' link in de koptekst";
$GLOBALS['strGzipContentCompression'] = "Gebruik GZIP content compression";

// Regenerate Platfor Hash script
$GLOBALS['strPlatformHashRegenerate'] = "Platform Hash regenereren";
$GLOBALS['strNewPlatformHash'] = "Uw nieuwe Platform Hash is:";
$GLOBALS['strPlatformHashInsertingError'] = "Foutmelding bij het opslaan van de Platform Hash in de database";

// Plugin Settings
$GLOBALS['strPluginSettings'] = "Plugin instellingen";
$GLOBALS['strEnableNewPlugins'] = "Inschakelen nieuw geïnstalleerde plugins";
$GLOBALS['strUseMergedFunctions'] = "Gebruik samengevoegde levering functies bestand";
