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
$GLOBALS['strEditConfigNotPossible'] = "Het is niet mogelijk om alle instellingen te bewerken omdat het configuratiebestand is vergrendeld om veiligheidsredenen. Indien u wijzigingen wil aanbrengen, moet u wellicht het configuratiebestand voor deze installatie eerst ontgrendelen.";
$GLOBALS['strEditConfigPossible'] = "Het is mogelijk om alle instellingen te bewerken omdat het configuratiebestand niet isvergrendeld, wat tot beveiligingsproblemen zou kunnen. Indien u uw systeem wilt beveiligen, moet u het configurattiebestand van deze installatie vergrendelen.";
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
$GLOBALS['strTypeFTPUsername'] = "Inloggen";
$GLOBALS['strTypeFTPPassword'] = "Wachtwoord";
$GLOBALS['strDeliveryFilenamesSignedAdClick'] = "Gesigneerde advertentie klik";
$GLOBALS['strDeliveryFilenamesAsyncJS'] = "Async JavaScript (bronbestand)";
$GLOBALS['strDeliveryFilenamesAsyncPHP'] = "Async JavaScript";
$GLOBALS['strDeliveryFilenamesAsyncSPC'] = "Async JavaScript Enkelvoudige Pagina-aanroep";
$GLOBALS['strGlobalDefaultBannerInvalidZone'] = "Algemene standaard HTML Banner voor niet-bestaande zones";
$GLOBALS['strGlobalDefaultBannerSuspendedAccount'] = "Algemene standaard HTML Banner voor opgeschorte accounts";
$GLOBALS['strGlobalDefaultBannerInactiveAccount'] = "Globale standaard HTML Banner voor niet-actieve accounts";

// General Settings

// Geotargeting Settings

// Interface Settings
$GLOBALS['strInventory'] = "Inventaris";
$GLOBALS['strStatisticsDefaults'] = "Statistieken";

// Invocation Settings

// Banner Delivery Settings

// Banner Logging Settings

// Banner Storage Settings

// Campaign ECPM settings

// Statistics & Maintenance Settings

// UI Settings

// Regenerate Platfor Hash script

// Plugin Settings
