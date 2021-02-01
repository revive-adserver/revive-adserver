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
$GLOBALS['strInstall'] = "Installation";
$GLOBALS['strDatabaseSettings'] = "Datenbankeinstellungen";
$GLOBALS['strAdminAccount'] = "Administrator Zugang";
$GLOBALS['strAdvancedSettings'] = "Ergänzende Einstellungen";
$GLOBALS['strWarning'] = "Warnung";
$GLOBALS['strBtnContinue'] = "Fortsetzen »";
$GLOBALS['strBtnRecover'] = "Wiederherstellen »";
$GLOBALS['strBtnAgree'] = "Ich stimme zu »";
$GLOBALS['strBtnRetry'] = "Erneut versuchen";
$GLOBALS['strWarningRegisterArgcArv'] = "Um das Maintenance-Wartungsscript von der Shell aufzurufen muß die PHP Konfigurationseinstellung 'register_argc_argv' auf 'On' gesetzt werden.";
$GLOBALS['strTablesPrefix'] = "Präfix für Tabellennamen";
$GLOBALS['strTablesType'] = "Tabellentype";

$GLOBALS['strRecoveryRequiredTitle'] = "Der vorige Upgrade-Versuch hat Fehler hinterlassen.";
$GLOBALS['strRecoveryRequired'] = "Bei der vorigen Upgrade-Prozedur sind Fehler aufgetreten. {$PRODUCT_NAME} wird versuchen den Zustand vor dem Upgrade wieder herzustellen. Bitte klicken Sie auf Wiederherstellen.";

$GLOBALS['strProductUpToDateTitle'] = "{$PRODUCT_NAME} ist aktuell";
$GLOBALS['strOaUpToDate'] = "Ihre {$PRODUCT_NAME} Datenbank und Verzeichnisstruktur ist auf dem neusten Stand, für diese Daten ist kein Upgradevorgang nötig. Bitte klicken Sie auf Fortsetzen um zur Administrationsseite von {$PRODUCT_NAME} zu gelangen.";
$GLOBALS['strOaUpToDateCantRemove'] = "Warnung: Es fehlen die nötigen Rechte an der Datei UPGRADE um diese aus dem Openads-'var'-Verzeichnis zu entfernen. Bitte löschen Sie die Datei manuell.";
$GLOBALS['strErrorWritePermissions'] = "Nicht ausreichende Datei- und Verzeichnisrechte erkannt, Sie müssen dies beheben bevor die Installation fortgesetzt werden kann.<br />Um diese Rechte auf einem Linux System zu gewähren, tippen Sie den/die folgenden Befehle auf einer Shell:";
$GLOBALS['strNotWriteable'] = "NICHT schreibbar";
$GLOBALS['strDirNotWriteableError'] = "Verzeichnis muss schreibbar sein";

$GLOBALS['strErrorWritePermissionsWin'] = "Nicht ausreichende Datei- und Verzeichnisrechte erkannt, Sie müssen dies beheben bevor die Installation fortgesetzt werden kann.";
$GLOBALS['strCheckDocumentation'] = "Wenn Sie mehr Hilfe benötigen, besuchen Sie bitte die <a href='{$PRODUCT_DOCSURL}'>{$PRODUCT_NAME} Online-Dokumentation</a>.";
$GLOBALS['strSystemCheckBadPHPConfig'] = "Die aktuelle PHP-Konfiguration erfüllt nicht die Anforderungen des {$PRODUCT_NAME}. Um die Probleme zu beheben, ändern Sie bitte die Einstellungen in der Datei \"php.ini\".";

$GLOBALS['strAdminUrlPrefix'] = "URL der Admin-Oberfläche";
$GLOBALS['strDeliveryUrlPrefix'] = "URL des Ad-Servers";
$GLOBALS['strDeliveryUrlPrefixSSL'] = "URL des Ad-Servers (SSL)";
$GLOBALS['strImagesUrlPrefix'] = "URL des Verzeichnisses in dem die Grafiken gespeichert werden.";
$GLOBALS['strImagesUrlPrefixSSL'] = "URL des Verzeichnisses in dem die Grafiken gespeichert werden (SSL).";


$GLOBALS['strUpgrade'] = "Programmaktualisierung (Upgrade)";

/* ------------------------------------------------------- */
/* Configuration translations                            */
/* ------------------------------------------------------- */

// Global
$GLOBALS['strUnableToWriteConfig'] = "Die Änderungen konnten nicht in die Konfigurationsdatei übernommen werden";
$GLOBALS['strUnableToWritePrefs'] = "Die Voreinstellungen konnten nicht in die Datenbank geschrieben werden.";
$GLOBALS['strImageDirLockedDetected'] = "Für das angegebene <b>Banner-Verzeichnis</b> hat der Server keine Schreibrechte.<br>Sie können den Vorgang erst fortsetzen wenn Sie die Verzeichnisrechte ändern oder das Verzeichnis anlegen.";

// Configuration Settings
$GLOBALS['strConfigurationSettings'] = "Konfigurationseinstellungen";

// Administrator Settings
$GLOBALS['strAdminUsername'] = "Benutzername (Admin)";
$GLOBALS['strAdminPassword'] = "Passwort (Admin)";
$GLOBALS['strInvalidUsername'] = "Benutzername fehlerhaft";
$GLOBALS['strBasicInformation'] = "Grundinformation";
$GLOBALS['strAdministratorEmail'] = "E-Mail des Administrators";
$GLOBALS['strAdminCheckUpdates'] = "Automatisch auf Produktupdates und Sicherheitshinweise prüfen (Empfohlen).";
$GLOBALS['strAdminShareStack'] = "Technische Informationen an das OpenX-Team übermitteln um die Weiterentwicklung und das Testen zu unterstützen.";
$GLOBALS['strNovice'] = "Löschvorgänge im Admin-Bereich nur mit Sicherheitsbestätigung";
$GLOBALS['strUserlogEmail'] = "Alle ausgehenden E-Mails protokollieren ";
$GLOBALS['strEnableDashboard'] = "Dashboard aktivieren";
$GLOBALS['strEnableDashboardSyncNotice'] = "Bitte aktivieren Sie <a href='account-settings-update.php'>Prüfen, ob neue Programmversionen vorhanden sind</a> wenn Sie das Dashboard nutzen möchten.";
$GLOBALS['strTimezone'] = "Zeitzone";
$GLOBALS['strEnableAutoMaintenance'] = "Durchführen von automatischen Maintenance-Wartungsläufen während der Bannerauslieferung, wenn regelmäßigen Wartungsläufe nicht eingerichtet sind.";

// Database Settings
$GLOBALS['strDatabaseSettings'] = "Datenbankeinstellungen";
$GLOBALS['strDatabaseServer'] = "Datenbank Server";
$GLOBALS['strDbLocal'] = "Verwenden Sie eine lokale Socket-Verbindung";
$GLOBALS['strDbType'] = "Datenbank Typ";
$GLOBALS['strDbHost'] = "Datenbank Hostname";
$GLOBALS['strDbSocket'] = "Datenbank-Socket";
$GLOBALS['strDbPort'] = "Datenbank Portnummer";
$GLOBALS['strDbUser'] = "Datenbank Benutzername";
$GLOBALS['strDbPassword'] = "Datenbank Passwort";
$GLOBALS['strDbName'] = "Datenbank Name";
$GLOBALS['strDbNameHint'] = "Die Datenbank wird angelegt falls sie noch nicht existiert";
$GLOBALS['strDatabaseOptimalisations'] = "Einstellungen zur Datenbank-Optimierung";
$GLOBALS['strPersistentConnections'] = "Dauerhafte (persistente) Verbindung zur Datenbank";
$GLOBALS['strCantConnectToDb'] = "Verbindung zur Datenbank nicht möglich";
$GLOBALS['strCantConnectToDbDelivery'] = 'Keine Datenbankverbindung für die Auslieferung';

// Email Settings
$GLOBALS['strEmailSettings'] = "Einstellungen E-Mail";
$GLOBALS['strEmailAddresses'] = "E-Mail \"Von\" Adresse";
$GLOBALS['strEmailFromName'] = "E-Mail \"Von\" Name";
$GLOBALS['strEmailFromAddress'] = "E-Mail \"Von\" E-Mail Adresse";
$GLOBALS['strEmailFromCompany'] = "E-Mail \"Von\" Firma";
$GLOBALS['strQmailPatch'] = "Änderungen für qmail";
$GLOBALS['strEnableQmailPatch'] = "Kopfzeile auch für qmail lesbar machen";
$GLOBALS['strEmailHeader'] = "E-Mail-Header";
$GLOBALS['strEmailLog'] = "E-Mail Protokoll";

// Audit Trail Settings
$GLOBALS['strAuditTrailSettings'] = "Einstellungen Prüfprotokoll";
$GLOBALS['strEnableAudit'] = "Prüfprotokoll aktivieren";
$GLOBALS['strEnableAuditForZoneLinking'] = "Aktivieren der Audits-Logs für die Zoneverlinkung (u.U. kann dies eine gewisse Leistungseinbuße beim Verlinken von vielen Zonen mit sich bringen)";

// Debug Logging Settings
$GLOBALS['strDebug'] = "Grundsätzliche Einstellungen für das Debug-Logging";
$GLOBALS['strEnableDebug'] = "Debug-Logging aktivieren";
$GLOBALS['strDebugMethodNames'] = "Methodennamen im Debug-Log eintragen";
$GLOBALS['strDebugLineNumbers'] = "Zeilennummern im Debug-Log vermerken";
$GLOBALS['strDebugType'] = "Typ des Debug-Logs";
$GLOBALS['strDebugTypeFile'] = "Datei";
$GLOBALS['strDebugTypeMcal'] = "mCal";
$GLOBALS['strDebugTypeSql'] = "SQL-Datenbank";
$GLOBALS['strDebugTypeSyslog'] = "Syslog";
$GLOBALS['strDebugName'] = "Name des Debug-Logs, Kalender, SQL-Tabelle,<br />oder Syslog Facility";
$GLOBALS['strDebugPriority'] = "Debug Dringlichkeitsstufe";
$GLOBALS['strPEAR_LOG_DEBUG'] = "PEAR_LOG_DEBUG - Alle Informationen";
$GLOBALS['strPEAR_LOG_INFO'] = "PEAR_LOG_INFO – fast alle Informationen";
$GLOBALS['strPEAR_LOG_NOTICE'] = "PEAR_LOG_NOTICE – nur allgemeine Hinweise";
$GLOBALS['strPEAR_LOG_WARNING'] = "PEAR_LOG_WARNING – Warnungen";
$GLOBALS['strPEAR_LOG_ERR'] = "PEAR_LOG_ERR – einfache Fehler";
$GLOBALS['strPEAR_LOG_CRIT'] = "PEAR_LOG_CRIT – schwerwiegende Fehler";
$GLOBALS['strPEAR_LOG_ALERT'] = "PEAR_LOG_ALERT – kritische Fehler";
$GLOBALS['strPEAR_LOG_EMERG'] = "PEAR_LOG_EMERG - Minimalinformationen";
$GLOBALS['strDebugIdent'] = "Debug Identifikations-String";
$GLOBALS['strDebugUsername'] = "mCal, SQL-Server Nutzername";
$GLOBALS['strDebugPassword'] = "mCal, SQL-Server Paßwort";
$GLOBALS['strProductionSystem'] = "Produktionssystem";

// Delivery Settings
$GLOBALS['strWebPath'] = "{$PRODUCT_NAME} Server Verzeichnisse";
$GLOBALS['strWebPathSimple'] = "Web-Pfad";
$GLOBALS['strDeliveryPath'] = "Auslieferungs-Pfad";
$GLOBALS['strImagePath'] = "Banner-Pfad";
$GLOBALS['strDeliverySslPath'] = "Auslieferungs-Pfad SSL";
$GLOBALS['strImageSslPath'] = "Banner-Pfad SSL";
$GLOBALS['strImageStore'] = "Banner Verzeichnis";
$GLOBALS['strTypeWebSettings'] = "Allgemeine Einstellungen zur lokalen Speicherung von Werbemitteln";
$GLOBALS['strTypeWebMode'] = "Speicherart";
$GLOBALS['strTypeWebModeLocal'] = "Lokales Verzeichnis";
$GLOBALS['strTypeDirError'] = "Der Web-Server hat keine Schreibrechte auf das lokale Verzeichnis";
$GLOBALS['strTypeWebModeFtp'] = "Externer FTP-Server";
$GLOBALS['strTypeWebDir'] = "Lokales Verzeichnis";
$GLOBALS['strTypeFTPHost'] = "FTP-Rechner";
$GLOBALS['strTypeFTPDirectory'] = "FTP-Verzeichnis";
$GLOBALS['strTypeFTPUsername'] = "Anmelden";
$GLOBALS['strTypeFTPPassword'] = "Passwort";
$GLOBALS['strTypeFTPPassive'] = "Passives FTP verwenden";
$GLOBALS['strTypeFTPErrorDir'] = "FTP-Verzeichnis existiert nicht";
$GLOBALS['strTypeFTPErrorConnect'] = "Verbindung zum FTP Server nicht möglich. Benutzername oder Passwort waren fehlerhaft";
$GLOBALS['strTypeFTPErrorNoSupport'] = "Ihre PHP-Installation unterstützt kein FTP.";
$GLOBALS['strTypeFTPErrorUpload'] = "Hochladen auf den FTP-Server nicht möglich, überprüfen Sie die Zugangsrechte in dem Host-Verzeichnis.";
$GLOBALS['strTypeFTPErrorHost'] = "Rechnername für FTP-Server ist fehlerhaft";
$GLOBALS['strDeliveryFilenames'] = "Namen der Dateien, die das System zur Werbemittelauslieferung nutzt";
$GLOBALS['strDeliveryFilenamesAdConversionVars'] = "Ad Conversion Variablen";
$GLOBALS['strDeliveryFilenamesXMLRPC'] = "XML RPC Bannercode";
$GLOBALS['strDeliveryFilenamesLocal'] = "Lokaler Bannercode";
$GLOBALS['strDeliveryCaching'] = "Allgemeine Einstellungen des Auslieferungs-Caches";
$GLOBALS['strDeliveryCacheLimit'] = "Zeitintervall zwischen Cache-Aktualisierungen (in Sek.)";
$GLOBALS['strDeliveryCacheStore'] = "Cache-Typ für die Bannerauslieferung";

// General Settings

// Geotargeting Settings

// Interface Settings
$GLOBALS['strInventory'] = "Inventar-Seiten";
$GLOBALS['strStatisticsDefaults'] = "Statistiken";

// Invocation Settings

// Banner Delivery Settings

// Banner Logging Settings

// Banner Storage Settings

// Campaign ECPM settings

// Statistics & Maintenance Settings

// UI Settings
$GLOBALS['strGeneralSettings'] = "Allgemeine Einstellungen";

// Regenerate Platfor Hash script

// Plugin Settings
