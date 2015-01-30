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
$GLOBALS['strAdminSettings'] = "Einstellung für Administrator";
$GLOBALS['strAdminAccount'] = "Administrator Zugang";
$GLOBALS['strAdvancedSettings'] = "Ergänzende Einstellungen";
$GLOBALS['strWarning'] = "Warnung";
$GLOBALS['strBtnContinue'] = "Fortsetzen »";
$GLOBALS['strBtnRecover'] = "Wiederherstellen »";
$GLOBALS['strBtnStartAgain'] = "Das Upgrade erneut starten »";
$GLOBALS['strBtnGoBack'] = "« zurück";
$GLOBALS['strBtnAgree'] = "Ich stimme zu »";
$GLOBALS['strBtnDontAgree'] = "« Ich widerspreche";
$GLOBALS['strBtnRetry'] = "Erneut versuchen";
$GLOBALS['strWarningRegisterArgcArv'] = "Um das Maintenance-Wartungsscript von der Shell aufzurufen muß die PHP Konfigurationseinstellung 'register_argc_argv' auf 'On' gesetzt werden.";
$GLOBALS['strTablesType'] = "Tabellentype";


$GLOBALS['strRecoveryRequiredTitle'] = "Der vorige Upgrade-Versuch hat Fehler hinterlassen.";
$GLOBALS['strRecoveryRequired'] = "Bei der vorigen Upgrade-Prozedur sind Fehler aufgetreten. {$PRODUCT_NAME} wird versuchen den Zustand vor dem Upgrade wieder herzustellen. Bitte klicken Sie auf Wiederherstellen.";

$GLOBALS['strOaUpToDate'] = "Ihre {$PRODUCT_NAME} Datenbank und Verzeichnisstruktur ist auf dem neusten Stand, für diese Daten ist kein Upgradevorgang nötig. Bitte klicken Sie auf Fortsetzen um zur Administrationsseite von {$PRODUCT_NAME} zu gelangen.";
$GLOBALS['strOaUpToDateCantRemove'] = "Warnung: Es fehlen die nötigen Rechte an der Datei UPGRADE um diese aus dem Openads-'var'-Verzeichnis zu entfernen. Bitte löschen Sie die Datei manuell.";
$GLOBALS['strRemoveUpgradeFile'] = "Sie müssen die Datei UPGRADE aus dem var-Verzeichnis löschen.";
$GLOBALS['strInstallSuccess'] = "Mit einem Klick auf 'Fortsetzen' werden Sie in den AdServer eingeloggt.<p><strong>Was sollten Sie als nächstes tun?</strong></p><div class='psub'><p><b>Registrieren Sie sich für Produktupgrades</b><br><a href='{$PRODUCT_DOCSURL}/wizard/join' target='_blank'>Tragen Sie sich in die {$PRODUCT_NAME} e-Mail-Verteiler ein.</a> um über Produktupgrades, Sicherheitshinweise und neue Produktankündigungen informiert zu werden.</p><p><b>Liefern Sie Ihre erste Kampagne aus</b><br>Lesen Sie unsere <a href='{$PRODUCT_DOCSURL}/wizard/qsg-firstcampaign' target='_blank'>Kurzanleitung zur Einrichtung einer ersten Werbekampagne</a></p></div><p><strong>Weitere (optionale) Schritte</strong></p><div class='psub'><p><b>Entfernen Sie den Schreibschutz der Konfigurationsdatei</b><br>Sie erhöhen die Sicherheit Ihres AdServers und verhindern ungewollte Modifikationen an den Einstellungen. <a href='{$PRODUCT_DOCSURL}/wizard/lock-config' target='_blank'>Lesen Sie mehr ...</a></p><p><b>Einrichtung eines regelmäßigen Wartungslaufes</b><br>Der Wartungslauf ist erforderlich um zeitnahe Statistiken und die bestmögliche Ausführungsgeschwindigkeit des AdServers zu erhalten. <a href='{$PRODUCT_DOCSURL}/wizard/setup-cron' target='_blank'>Lesen Sie mehr ...</a></p><p><b>Überprüfen Sie die Konfigurationseinstellungen</b><br>Bevor Sie {$PRODUCT_NAME} in Betrieb nehmen, sollten Sie die Konfiguration unter dem Tab 'Einstellungen' überprüfen.</p></div>";
$GLOBALS['strInstallNotSuccessful'] = "Die Installation von {$PRODUCT_NAME}  war nicht erfolgreich. Einige Teilschritte der Installationprozedur konnten nicht ausgeführt werden. Es ist durchaus möglich, das dieses Problem nur vorübergehend besteht und eine Wiederholung der Installation vom ersten Installationschritt durch einen Klick auf 'Weiter' zum Erfolg führt. Mehr über die untenstehende Fehlermeldung erfahren Sie aus der Dokumentation.";
$GLOBALS['strDbSuccessIntro'] = "Die {$PRODUCT_NAME} Datenbank ist erstellt worden. Bitte klicken Sie auf 'Fortsetzen' um mit der Konfiguration der Einstellungen von {$PRODUCT_NAME} zum Administrator und der Auslieferung zu beginnen.";
$GLOBALS['strDbSuccessIntroUpgrade'] = "Ihr System wurde erfolgreich aktualisiert. Die folgenden Seiten unterstützen Sie dabei, zusätzliche Einstellungen Ihres AdServers zu überprüfen.";
$GLOBALS['strErrorOccured'] = "Der folgende Fehler ist aufgetreten:";
$GLOBALS['strErrorInstallDatabase'] = "Die Datenbankstruktur konnte nicht angelegt werden.";
$GLOBALS['strErrorInstallPrefs'] = "Die Benutzereinstellungen für den Administrator konnten nicht in die Datenbank geschrieben werden.";
$GLOBALS['strErrorInstallVersion'] = "Die {$PRODUCT_NAME} Versionsnummer konnte nicht in die Datenbank geschrieben werden.";
$GLOBALS['strErrorUpgrade'] = 'Das Upgrade der Datenbank der bestehenden Installation ist fehlgeschlagen.';
$GLOBALS['strErrorInstallDbConnect'] = "Eine Verbindung zur Datenbank konnte nicht geöffnet werden.";

$GLOBALS['strErrorWritePermissions'] = "Nicht ausreichende Datei- und Verzeichnisrechte erkannt, Sie müssen dies beheben bevor die Installation fortgesetzt werden kann.<br />Um diese Rechte auf einem Linux System zu gewähren, tippen Sie den/die folgenden Befehle auf einer Shell:";

$GLOBALS['strErrorWritePermissionsWin'] = "Nicht ausreichende Datei- und Verzeichnisrechte erkannt, Sie müssen dies beheben bevor die Installation fortgesetzt werden kann.";
$GLOBALS['strCheckDocumentation'] = "Wenn Sie mehr Hilfe benötigen, besuchen Sie bitte die <a href='{$PRODUCT_DOCSURL}'>{$PRODUCT_NAME} Online-Dokumentation</a>.";

$GLOBALS['strAdminUrlPrefix'] = "URL der Admin-Oberfläche";
$GLOBALS['strDeliveryUrlPrefix'] = "URL des Ad-Servers";
$GLOBALS['strDeliveryUrlPrefixSSL'] = "URL des Ad-Servers (SSL)";
$GLOBALS['strImagesUrlPrefix'] = "URL des Verzeichnisses in dem die Grafiken gespeichert werden.";
$GLOBALS['strImagesUrlPrefixSSL'] = "URL des Verzeichnisses in dem die Grafiken gespeichert werden (SSL).";

$GLOBALS['strInvalidUserPwd'] = "Fehlerhafter Benutzername oder Passwort";

$GLOBALS['strUpgrade'] = "Programmaktualisierung (Upgrade)";
$GLOBALS['strSystemUpToDate'] = "Das System ist bereits aktuell. Eine Aktualisierung (Upgrade) ist nicht notwendig. <br />
Drücken Sie <b>Weiter</b>, um zur Startseite zu gelangen.";
$GLOBALS['strSystemNeedsUpgrade'] = "Die Datenbankstruktur und die Konfigurationsdateien sollten aktualisiert werden. Drücken Sie <b>Weiter</b> für den Start des Aktualisierungslaufes.
 <br /><br />Abhängig von der derzeitig genutzten Version und der Anzahl der vorhandenen Statistiken kann dieser Prozeß Ihre Datenbank stark belasten. Das Upgrade kann einige Minuten dauern.";
$GLOBALS['strSystemUpgradeBusy'] = "Aktualisierung des Systems läuft. Bitte warten ...";
$GLOBALS['strSystemRebuildingCache'] = "Cache wird neu erstellt. Bitte warten ...";
$GLOBALS['strServiceUnavalable'] = "Dieser Service ist zur Zeit nicht erreichbar. System wird aktualisiert...";

/* ------------------------------------------------------- */
/* Configuration translations                            */
/* ------------------------------------------------------- */

// Global
$GLOBALS['strChooseSection'] = "Bereichsauswahl";
$GLOBALS['strEditConfigNotPossible'] = "It is not possible to edit all settings because the configuration file is locked for security reasons. " .
    "If you want to make changes, you may need to unlock the configuration file for this installation first.";
$GLOBALS['strEditConfigPossible'] = "It is possible to edit all settings because the configuration file is not locked, but this could lead to security issues. " .
    "If you want to secure your system, you need to lock the configuration file for this installation.";
$GLOBALS['strUnableToWriteConfig'] = "Die Änderungen konnten nicht in die Konfigurationsdatei übernommen werden";
$GLOBALS['strUnableToWritePrefs'] = "Die Voreinstellungen konnten nicht in die Datenbank geschrieben werden.";
$GLOBALS['strImageDirLockedDetected'] = "Für das angegebene <b>Banner-Verzeichnis</b> hat der Server keine Schreibrechte.<br>Sie können den Vorgang erst fortsetzen wenn Sie die Verzeichnisrechte ändern oder das Verzeichnis anlegen.";

// Configuration Settings
$GLOBALS['strConfigurationSetup'] = "Aufstellung der Konfiguration";
$GLOBALS['strConfigurationSettings'] = "Einstellungen der Konfiguration";

// Administrator Settings
$GLOBALS['strAdministratorSettings'] = "Einstellung für Administrator";
$GLOBALS['strAdministratorAccount'] = "Das Administrator Konto";
$GLOBALS['strLoginCredentials'] = "Anmeldeinformationen";
$GLOBALS['strAdminUsername'] = "Benutzername (Admin)";
$GLOBALS['strAdminPassword'] = "Passwort (Admin)";
$GLOBALS['strInvalidUsername'] = "Benutzername fehlerhaft";
$GLOBALS['strBasicInformation'] = "Grundinformation";
$GLOBALS['strAdminFullName'] = "Vorname Name des Admin";
$GLOBALS['strAdminEmail'] = "E-Mail des Admin";
$GLOBALS['strAdministratorEmail'] = "E-Mail des Administrators";
$GLOBALS['strCompanyName'] = "Firma";
$GLOBALS['strAdminCheckUpdates'] = "Automatisch auf Produktupdates und Sicherheitshinweise prüfen (Empfohlen).";
$GLOBALS['strAdminShareStack'] = "Technische Informationen an das OpenX-Team übermitteln um die Weiterentwicklung und das Testen zu unterstützen.";
$GLOBALS['strAdminCheckEveryLogin'] = "Bei jedem Login";
$GLOBALS['strAdminCheckDaily'] = "Täglich";
$GLOBALS['strAdminCheckWeekly'] = "Wöchentlich";
$GLOBALS['strAdminCheckMonthly'] = "Monatlich";
$GLOBALS['strAdminCheckNever'] = "Nie";
$GLOBALS['strNovice'] = "Löschvorgänge im Admin-Bereich nur mit Sicherheitsbestätigung";
$GLOBALS['strUserlogEmail'] = "Alle ausgehenden E-Mails protokollieren ";
$GLOBALS['strEnableDashboard'] = "Dashboard aktivieren";
$GLOBALS['strEnableDashboardSyncNotice'] = "Bitte aktivieren Sie <a href='account-settings-update.php'>Prüfen, ob neue Programmversionen vorhanden sind</a> wenn Sie das Dashboard nutzen möchten.";
$GLOBALS['strTimezone'] = "Zeitzone";
$GLOBALS['strTimezoneEstimated'] = "Vermutete Zeitzone";
$GLOBALS['strTimezoneGuessedValue'] = "Die Server-Zeitzone für PHP ist nicht richtig gesetzt.";
$GLOBALS['strTimezoneSeeDocs'] = "Für Informationen über diese PHP Variable sehen Sie bitte unter %DOCS% nach.";
$GLOBALS['strTimezoneDocumentation'] = "Dokumentation";
$GLOBALS['strAdminSettingsTitle'] = "Anlegen des Administrations-Zugangs";
$GLOBALS['strAdminSettingsIntro'] = "Bitte füllen Sie die Eingabefelder aus um den Administrator-Zugang für diesen AdServer anzulegen.";
$GLOBALS['strConfigSettingsIntro'] = "Bitte überprüfen Sie die unten stehenden Einstellungen und nehmen Sie ggf. die nötigen Änderungen vor. Wenn Sie sich nicht sicher sind, verwenden Sie die vorgegebenen Werte.";

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
$GLOBALS['strDemoDataInstall'] = "Einrichten von Beispieldaten";
$GLOBALS['strDemoDataIntro'] = "Um Ihnen zu zeigen wie Kampagnen, Banner und Zonen in {$PRODUCT_NAME} organisiert werden, können bei der Installation einige Beispieldaten eingerichtet werden. Wenn Sie {$PRODUCT_NAME} das erste mal nutzen, empfehlen wir Ihnen diese Daten einzurichten. ";



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

// Debug Logging Settings
$GLOBALS['strDebug'] = "Grundsätzliche Einstellungen für das Debug-Logging";
$GLOBALS['strProduction'] = "Produktions-Server";
$GLOBALS['strEnableDebug'] = "Debug-Logging aktivieren";
$GLOBALS['strDebugMethodNames'] = "Methodennamen im Debug-Log eintragen";
$GLOBALS['strDebugLineNumbers'] = "Zeilennummern im Debug-Log vermerken";
$GLOBALS['strDebugType'] = "Typ des Debug-Logs";
$GLOBALS['strDebugTypeFile'] = "Datei";
$GLOBALS['strDebugTypeSql'] = "SQL-Datenbank";
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
$GLOBALS['strDeliverySettings'] = "Einstellungen für Bannerauslieferung";
$GLOBALS['strWebPath'] = "$PRODUCT_NAME Server Access Paths";
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
$GLOBALS['strDeliveryFilenamesFlash'] = "Flash Include (Kann eine vollständige URL sein)";
$GLOBALS['strDeliveryCaching'] = "Allgemeine Einstellungen des Auslieferungs-Caches";
$GLOBALS['strDeliveryCacheLimit'] = "Zeitintervall zwischen Cache-Aktualisierungen (in Sek.)";
$GLOBALS['strDeliveryCacheStore'] = "Cache-Typ für die Bannerauslieferung";

$GLOBALS['strErrorInCacheStorePlugin'] = "Das Plugin \"%s\" für den Auslieferungsspeicher hat einige Fehler festgestellt:";
$GLOBALS['strDeliveryCacheStorage'] = "Auslieferungscache Speichertyp";

$GLOBALS['strOrigin'] = "Nutze entfernten Ursprungsserver";
$GLOBALS['strOriginType'] = "Ursprungsserver Typ";
$GLOBALS['strOriginHost'] = "Hostname des Ursprungsservers";
$GLOBALS['strOriginPort'] = "Port-Nummer des Ursprungsserver Datenbank";
$GLOBALS['strOriginScript'] = "Script-Datei für Ursprungsserver Datenbank";
$GLOBALS['strOriginTimeout'] = "Zeitlimit (Sekunden) für Ursprungsserver";
$GLOBALS['strOriginProtocol'] = "Protokoll für Ursprungsserver ";

$GLOBALS['strDeliveryAcls'] = "Überprüfe die Auslieferungseinschränkungen eines Banners während der Auslieferung";
$GLOBALS['strDeliveryObfuscate'] = "Bei der Auslieferung die Gruppe eines Werbemittels verschleiern";
$GLOBALS['strDeliveryExecPhp'] = "PHP-Code in Werbemitteln wird ausgeführt<br />(Achtung: Starkes Sicherheitsrisiko)";
$GLOBALS['strDeliveryCtDelimiter'] = "Begrenzung des 3rd Party Kick-Trackings";
$GLOBALS['strGlobalDefaultBannerUrl'] = "Globale Default-Image-Banner URL";
$GLOBALS['strP3PSettings'] = "P3P-Datenschutzrichtlinien";
$GLOBALS['strUseP3P'] = "Verwendung von P3P-Richtlinien";
$GLOBALS['strP3PCompactPolicy'] = "P3P-Datenschutzrichtlinien (kompakte Form)";
$GLOBALS['strP3PPolicyLocation'] = "Speicherort der P3P-Richtlinien";

// General Settings
$GLOBALS['generalSettings'] = "Allgemeine globale Systemeinstellungen";
$GLOBALS['uiEnabled'] = "Benutzeroberfläche aktiviert";
$GLOBALS['defaultLanguage'] = "Voreinstellung der Systemsprache<br />(Jeder Benutzer kann seine eigene Sprache einstellen)";

// Geotargeting Settings
$GLOBALS['strGeotargetingSettings'] = "Einstellungen Geotargeting";
$GLOBALS['strGeotargeting'] = "Einstellungen Geotargeting";
$GLOBALS['strGeotargetingType'] = "Typ des Geotargeting Moduls";
$GLOBALS['strGeotargetingUseBundledCountryDb'] = "Verwenden Sie die mitgelieferte MaxMind GeoLiteCountry Datenbank";
$GLOBALS['strGeotargetingGeoipCountryLocation'] = "Speicherort der MaxMind GeoIP Länderdatenbank<br />(Leer lassen um freie Datenbank zu nutzen)";
$GLOBALS['strGeotargetingGeoipRegionLocation'] = "Speicherort der MaxMind GeoIP Regionendatenbank";
$GLOBALS['strGeotargetingGeoipCityLocation'] = "Speicherort der MaxMind GeoIP Städtedatenbank";
$GLOBALS['strGeotargetingGeoipAreaLocation'] = "Speicherort der MaxMind GeoIP Gebietsdatenbank";
$GLOBALS['strGeotargetingGeoipDmaLocation'] = "Speicherort der MaxMind GeoIP DMA-Databank (nur USA)";
$GLOBALS['strGeotargetingGeoipOrgLocation'] = "Speicherort der MaxMind GeoIP Organisationendatenbank";
$GLOBALS['strGeotargetingGeoipIspLocation'] = "Speicherort der MaxMind GeoIP ISP-Datenbank";
$GLOBALS['strGeotargetingGeoipNetspeedLocation'] = "Speicherort der MaxMind GeoIP Bandbreitendatenbank";
$GLOBALS['strGeoShowUnavailable'] = "Zeige die durch Geotargeting verursachten Auslieferungslimitierungen an, auch wenn keine GeoIP-Daten verfügbar sind";
$GLOBALS['strGeotrackingGeoipCountryLocationError'] = "Die MaxMind GeoIP Länderdatenbank konnte im angegebenen Verzeichnis nicht gefunden werden";
$GLOBALS['strGeotrackingGeoipRegionLocationError'] = "Die MaxMind GeoIP Regionendatenbank konnte im angegebenen Verzeichnis nicht gefunden werden";
$GLOBALS['strGeotrackingGeoipCityLocationError'] = "Die MaxMind GeoIP Städtedatenbank konnte im angegebenen Verzeichnis nicht gefunden werden";
$GLOBALS['strGeotrackingGeoipAreaLocationError'] = "Die MaxMind GeoIP Gebietsdatenbank konnte im angegebenen Verzeichnis nicht gefunden werden";
$GLOBALS['strGeotrackingGeoipDmaLocationError'] = "Die MaxMind GeoIP DMA-Datenbank konnte im angegebenen Verzeichnis nicht gefunden werden";
$GLOBALS['strGeotrackingGeoipOrgLocationError'] = "Die MaxMind GeoIP Organisationendatenbank konnte im angegebenen Verzeichnis nicht gefunden werden";
$GLOBALS['strGeotrackingGeoipIspLocationError'] = "Die MaxMind GeoIP ISP-Datenbank konnte im angegebenen Verzeichnis nicht gefunden werden";
$GLOBALS['strGeotrackingGeoipNetspeedLocationError'] = "Die MaxMind GeoIP Bandbreitendatenbank konnte im angegebenen Verzeichnis nicht gefunden werden";

// Interface Settings
$GLOBALS['strInventory'] = "Inventar-Seiten";
$GLOBALS['strUploadConversions'] = "Konversionen hochladen";
$GLOBALS['strShowCampaignInfo'] = "Anzeigen zusätzlicher Informationen auf der Seite <i>Übersicht Kampagnen</i>";
$GLOBALS['strShowBannerInfo'] = "Anzeigen zusätzlicher Bannerinformationen auf der Seite <i>Werbemittel</i> ";
$GLOBALS['strShowCampaignPreview'] = "Vorschau aller Werbemittel auf der Seite  <i>Werbemittel</i>";
$GLOBALS['strShowBannerHTML'] = "Anzeige des Banners anstelle des HTML-Codes bei Vorschau von HTML-Bannern";
$GLOBALS['strShowBannerPreview'] = "Werbemittelvorschau oben auf allen Seiten mit Bezug zum Werbemittel";
$GLOBALS['strHideInactive'] = "Inaktive ausblenden";
$GLOBALS['strGUIShowMatchingBanners'] = "Anzeige des zugehörenden Werbemittels auf der Seite <i>Verknüpfte Werbemittel</i>";
$GLOBALS['strGUIShowParentCampaigns'] = "Anzeige der zugehörenden Kampagne auf der Seite <i>Veknüpfte Werbemittel</i>";
$GLOBALS['strGUIAnonymousCampaignsByDefault'] = "anonyme Kampagnen als Grundeinstellung";
$GLOBALS['strStatisticsDefaults'] = "Statistiken";
$GLOBALS['strBeginOfWeek'] = "Wochenbeginn";
$GLOBALS['strPercentageDecimals'] = "Dezimalstellen bei Prozentangaben";
$GLOBALS['strWeightDefaults'] = "Gewichtung (Voreinstellung)";
$GLOBALS['strDefaultBannerWeight'] = "Bannergewichtung (Voreinstellung)";
$GLOBALS['strDefaultCampaignWeight'] = "Kampagnengewichtung (Voreinstellung)";
$GLOBALS['strDefaultBannerWErr'] = "Die Voreinstellung der Bannergewichtung muß eine positive ganze Zahl sein";
$GLOBALS['strDefaultCampaignWErr'] = "Die Voreinstellung der Kampagnengewichtung muß eine positive ganze Zahl sein";
$GLOBALS['strConfirmationUI'] = "Bestätigung in der Benutzeroberfläche";

$GLOBALS['strPublisherDefaults'] = "Voreinstellung Webseite";
$GLOBALS['strModesOfPayment'] = "Zahlungsweise";
$GLOBALS['strCurrencies'] = "Währungen";
$GLOBALS['strCategories'] = "Kategorien";
$GLOBALS['strHelpFiles'] = "Hilfedateien";
$GLOBALS['strHasTaxID'] = "Steuer-Nr.";
$GLOBALS['strDefaultApproved'] = "zugestimmt Schaltfäche";

// CSV Import Settings
$GLOBALS['strChooseAdvertiser'] = "Werbetreibenden auswählen";
$GLOBALS['strChooseCampaign'] = "Kampagne auswählen";
$GLOBALS['strChooseCampaignBanner'] = "Banner auswählen";
$GLOBALS['strChooseTracker'] = "Tracker auswählen";
$GLOBALS['strDefaultConversionStatus'] = "Voreinstellung des Konversionstatus";
$GLOBALS['strDefaultConversionType'] = "Voreinstellung des Konversionstyps";
$GLOBALS['strCSVTemplateSettings'] = "CSV Template Einstellung";
$GLOBALS['strIncludeCountryInfo'] = "Länderinformation hinzufügen";
$GLOBALS['strIncludeBrowserInfo'] = "Browserinformation hinzufügen";
$GLOBALS['strIncludeOSInfo'] = "Betriebssysteminformation hinzufügen";
$GLOBALS['strIncludeSampleRow'] = "Beispielzeile hinzufügen";
$GLOBALS['strCSVTemplateAdvanced'] = "Erweitertes Template";
$GLOBALS['strCSVTemplateIncVariables'] = "Trackervariablen hinzufügen";

/**
 * @todo remove strBannerSettings if banner is only configurable as a preference
 *       rename // Banner Settings to  // Banner Preferences
 */
// Invocation Settings
$GLOBALS['strAllowedInvocationTypes'] = "Erlaubete Banneranforderungstypen";
$GLOBALS['strInvocationDefaults'] = "Banneranforderung Voreinstellung";
$GLOBALS['strEnable3rdPartyTrackingByDefault'] = "Erlaube '3rd Party Clicktracking' als Voreinstellung";

// Banner Delivery Settings
$GLOBALS['strBannerDelivery'] = "Einstellungen der Auslieferung";

// Banner Logging Settings
$GLOBALS['strBannerLogging'] = "Bannerprotokollierung - Einstellungen";
$GLOBALS['strLogAdRequests'] = "Protokolliere bei jedem Aufruf eines Werbemittels auf dem Server einen Ad Request";
$GLOBALS['strLogAdImpressions'] = "Protokolliere eine Ad Impression, wenn ein Werbemittel beim Nutzer angekommen ist (Truecount)";
$GLOBALS['strLogAdClicks'] = "Protoklliere einen Ad Click , wenn ein Nutzer auf ein Werbemittel klickt";
$GLOBALS['strLogTrackerImpressions'] = "Protokolliere eine Tracker Impression, wenn ein Nutzer eine Seite mit Tracker-Code vollständig lädt.";
$GLOBALS['strReverseLookup'] = "Es wird versucht, den Name des Hosts für den Besucher zu ermitteln, wenn er nicht mitgeliefert wird";
$GLOBALS['strProxyLookup'] = "Es wird versucht, die echte IP-Adresse des Besuchers zu ermitteln, wenn er einen Proxy-Server nutzt";
$GLOBALS['strPreventLogging'] = "Protokollieren verhindern";
$GLOBALS['strIgnoreHosts'] = "Keine Statistikdaten speichern für Besucher mit folgenden IP-Adressen oder Hostnamen";
$GLOBALS['strIgnoreUserAgents'] = "<b>Keine</b> Statistikdaten loggen von den folgenden Browsern (user-agent), jeweils nur ein Eintrag pro Zeile";
$GLOBALS['strEnforceUserAgents'] = "Die Statistikdaten <b>nur</b> von den folgenden Browsern loggen (user-agent), jeweils nur ein Eintrag pro Zeile";

// Banner Storage Settings
$GLOBALS['strBannerStorage'] = "Einstellungen Speicherung der Banner";

// Campaign ECPM settings

// Statistics & Maintenance Settings
$GLOBALS['strMaintenanceSettings'] = "Wartungseinstellungen";
$GLOBALS['strConversionTracking'] = "Einstellungen zum Konversionen-Tracking";
$GLOBALS['strEnableConversionTracking'] = "Konversionen-Tracking aktivieren";
$GLOBALS['strCsvImport'] = "Hochladen von 'offline' Konversionen erlauben";
$GLOBALS['strBlockAdViews'] = "Zähle keine Ad Impressions wenn der Betrachter diese Banner/Zonen-Kombination innerhalb dieses Zeitraums schon gesehen hat (in Sekunden)";
$GLOBALS['strBlockAdViewsError'] = "Ad Impression Sperre muß eine positive, ganze Zahl sein.";
$GLOBALS['strBlockAdClicks'] = "Zähle keine Ad Klicks wenn der Betrachter auf diese Banner/Zonen-Kombination innerhalb dieses Zeitraums schon geklickt hat (in Sekunden)";
$GLOBALS['strBlockAdClicksError'] = "Intervall für Reklick-Sperre muß eine positive ganze Zahl sein";
$GLOBALS['strMaintenanceOI'] = "Wartungsintervall (in Minuten)";
$GLOBALS['strMaintenanceOIError'] = "Dieses Wartungsintervall ist nicht zulässig - bitte konsultieren Sie die Dokumentation";
$GLOBALS['strPrioritySettings'] = "Einstellung der Prioritäten";
$GLOBALS['strPriorityInstantUpdate'] = "Sofortige Neuberechnung der Prioritäten nach Änderungen in der Benutzeroberfläche.";
$GLOBALS['strDefaultImpConWindow'] = "Vorgabewert (in Sekunden) für das Zeitfenster von Ad Impressions bei der Neuanlage von Trackern";
$GLOBALS['strDefaultImpConWindowError'] = "Wenn gesetzt, muß der Vorgabewert für das Zeitfenster der Tracker Ad Impression eine positive ganze Zahl sein";
$GLOBALS['strDefaultCliConWindow'] = "Vorgabewert (in Sekunden) für das Zeitfenster von Ad Klicks bei der Neuanlage von Trackern";
$GLOBALS['strDefaultCliConWindowError'] = "Wenn gesetzt, muß der Vorgabewert für das Zeitfenster der Tracker Ad Klicks eine positive ganze Zahl sein";
$GLOBALS['strAdminEmailHeaders'] = "Alle e-Mails, die von {$PRODUCT_NAME} gesendet werden, erhalten die folgenden Header hinzugefügt";
$GLOBALS['strWarnLimit'] = "Warnung per E-Mail bei Unterschreiten der definierten Untergrenze";
$GLOBALS['strWarnLimitErr'] = "Warnlimit muß eine positive Ganzzahl sein";
$GLOBALS['strWarnLimitDays'] = "Sende eine Warnung wenn weniger Tage verblieben sind als hier angegeben.";
$GLOBALS['strWarnLimitDaysErr'] = "Anzahl Tage für die Warnung muß eine positive Zahl sein.";
$GLOBALS['strAllowEmail'] = "Erlaube das Senden von E-Mails";
$GLOBALS['strEmailAddressFrom'] = "Absenderadresse (From:) für das Versenden von E-Mails";
$GLOBALS['strEmailAddressName'] = "Firmenname oder persönlicher Name als Unterschrift am Ende aller E-Mails";
$GLOBALS['strWarnAdmin'] = "Warnung per E-Mail an den Administrator, wenn eine Kampagne ausgelaufen ist";
$GLOBALS['strWarnClient'] = "Warnung per E-Mail an den Werbetreibenden, wenn eine Kampagne ausgelaufen ist";
$GLOBALS['strWarnAgency'] = "Warnung per E-Mail an die Agentur kurz bevor eine Kampagne ausläuft";

// UI Settings
$GLOBALS['strGuiSettings'] = "Konfiguration Benutzerbereich (Inhaber des AdServers)";
$GLOBALS['strGeneralSettings'] = "Allgemeine Grundeinstellungen des Systems";
$GLOBALS['strAppName'] = "Name oder Bezeichnung der Anwendung";
$GLOBALS['strMyHeader'] = "Kopfzeile im Admin-Bereich";
$GLOBALS['strMyHeaderError'] = "Die Datei für die Kopfzeile wurde an angegebenen Adresse nicht vorgefunden";
$GLOBALS['strMyFooter'] = "Fußzeile im Admin-Bereich";
$GLOBALS['strMyFooterError'] = "Die Datei für die Fußzeile wurde an angegebenen Adresse nicht vorgefunden";
$GLOBALS['strDefaultTrackerStatus'] = "Standardstatus Tracker";
$GLOBALS['strDefaultTrackerType'] = "Standardtyp Tracker";
$GLOBALS['strSSLSettings'] = "Einstellungen SSL";
$GLOBALS['requireSSL'] = "Erzwinge die SSL Nutzung für die Benutzeroberfläche";
$GLOBALS['sslPort'] = "SSL Port des Webservers";
$GLOBALS['strDashboardSettings'] = "Dashboard Einstellungen";

$GLOBALS['strMyLogo'] = "Name der individuellen Logo-Datei";
$GLOBALS['strMyLogoError'] = "Diese Logo-Datei ist im Verzeichnis admin/images nicht vorhanden";
$GLOBALS['strGuiHeaderForegroundColor'] = "Vordergrundfarbe der Kopfzeile";
$GLOBALS['strGuiHeaderBackgroundColor'] = "Hintergrundfarbe der Kopfzeile";
$GLOBALS['strGuiActiveTabColor'] = "Farbe des aktiven Reiters";
$GLOBALS['strGuiHeaderTextColor'] = "Textfarbe in der Kopfzeile";
$GLOBALS['strColorError'] = "Bitte geben Sie die Farben im RGB-Format an, z.B. '0066CC'";

$GLOBALS['strGzipContentCompression'] = "Komprimieren mit GZIP";
$GLOBALS['strClientInterface'] = "Nutzeroberfläche für Werbetreibende";
$GLOBALS['strReportsInterface'] = "Oberfläche Reports";
$GLOBALS['strClientWelcomeEnabled'] = "Begrüßungstext für Werbetreibende verwenden";
$GLOBALS['strClientWelcomeText'] = "Begrüßungstext<br /><i>(HTML Tags sind zugelassen)</i>";

$GLOBALS['strPublisherInterface'] = "Schnittstelle der Webseite";
$GLOBALS['strPublisherAgreementEnabled'] = "Erlaube das Einloggen von Webseiten die die Konditionen (AGB) noch nicht akzeptiert haben.";
$GLOBALS['strPublisherAgreementText'] = "Konditionen (AGB) für Werbetreibende beim Login (HTML-Tags sind erlaubt)";

// Regenerate Platfor Hash script

// Plugin Settings

/* ------------------------------------------------------- */
/* Unknown (unused?) translations                        */
/* ------------------------------------------------------- */


