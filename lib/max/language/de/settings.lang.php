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
$GLOBALS['strTablesPrefix'] = "Präfix für Tabellennamen";
$GLOBALS['strTablesType'] = "Tabellentype";

$GLOBALS['strRecoveryRequiredTitle'] = "Der vorige Upgrade-Versuch hat Fehler hinterlassen.";
$GLOBALS['strRecoveryRequired'] = "Bei der vorigen Upgrade-Prozedur sind Fehler aufgetreten. {$PRODUCT_NAME} wird versuchen den Zustand vor dem Upgrade wieder herzustellen. Bitte klicken Sie auf Wiederherstellen.";

$GLOBALS['strProductUpToDateTitle'] = "{$PRODUCT_NAME} ist aktuell";
$GLOBALS['strOaUpToDate'] = "Ihre {$PRODUCT_NAME} Datenbank und Verzeichnisstruktur ist auf dem neusten Stand, für diese Daten ist kein Upgradevorgang nötig. Bitte klicken Sie auf Fortsetzen um zur Administrationsseite von {$PRODUCT_NAME} zu gelangen.";
$GLOBALS['strOaUpToDateCantRemove'] = "Warnung: Es fehlen die nötigen Rechte an der Datei UPGRADE um diese aus dem Openads-'var'-Verzeichnis zu entfernen. Bitte löschen Sie die Datei manuell.";
$GLOBALS['strErrorWritePermissions'] = "Nicht ausreichende Datei- und Verzeichnisrechte erkannt, Sie müssen dies beheben bevor die Installation fortgesetzt werden kann.<br />Um diese Rechte auf einem Linux System zu gewähren, tippen Sie den/die folgenden Befehle auf einer Shell:";
$GLOBALS['strErrorFixPermissionsRCommand'] = "<i>chmod -R a+w %s</i>";
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
$GLOBALS['strChooseSection'] = "Bereichsauswahl";
$GLOBALS['strEditConfigNotPossible'] = "Es ist nicht möglich, die Einstellungen zu bearbeiten, da die Konfigurationsdatei aus Sicherheitsgründen schreibgeschützt ist.
Wenn Sie Änderungen vornehmen möchten, müssen Sie den Schreibschutz der Konfigurationsdatei möglicherweise erst entfernen.";
$GLOBALS['strEditConfigPossible'] = "Momentan ist es möglich Einstellungen zu ändern, da die Konfigurationsdatei nicht schreibgeschützt ist. Dies kann zu Sicherheitsproblemen führen. Wenn Sie Ihr System absichern möchten, müssen Sie die Konfigurationsdatei für diese Installation mit einem Schreibschutz versehen.";
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
$GLOBALS['strUseManagerDetails'] = 'Verwenden Sie den Kontakt, die E-Mail und den Namen des Eigentümerkontos anstelle des obigen Namens, der E-Mail-Adresse und der Firma, wenn Sie Berichte an Werbetreibende oder Website-Konten versenden.';
$GLOBALS['strQmailPatch'] = "Änderungen für qmail";
$GLOBALS['strEnableQmailPatch'] = "Kopfzeile auch für qmail lesbar machen";
$GLOBALS['strEmailHeader'] = "E-Mail-Header";
$GLOBALS['strEmailLog'] = "E-Mail Protokoll";

// Security settings
$GLOBALS['strSecurityAndDebug'] = "Sicherheits- und Debug-Einstellungen";
$GLOBALS['strSecuritySettings'] = "Sicherheitseinstellungen";
$GLOBALS['strSecurityPasswordMinLength'] = "Minimale Passwortlänge";
$GLOBALS['strSecurityBadLoginPath'] = "Logdatei für fehlerhafte Anmeldungen";

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
$GLOBALS['strDeliveryFilenamesAdClick'] = "Klick auf Anzeigen";
$GLOBALS['strDeliveryFilenamesSignedAdClick'] = "Signierter Klick auf Anzeigen";
$GLOBALS['strDeliveryFilenamesAdConversionVars'] = "Ad Conversion Variablen";
$GLOBALS['strDeliveryFilenamesAdContent'] = "Inhalt einer Anzeige";
$GLOBALS['strDeliveryFilenamesAdConversion'] = "Konversion einer Anzeige";
$GLOBALS['strDeliveryFilenamesAdConversionJS'] = "Konversion einer Javascript-Anzeige";
$GLOBALS['strDeliveryFilenamesAdFrame'] = "Anzeige im Frame";
$GLOBALS['strDeliveryFilenamesAdImage'] = "Anzeige-Bild";
$GLOBALS['strDeliveryFilenamesAdJS'] = "Anzeige (JavaScript)";
$GLOBALS['strDeliveryFilenamesAdLayer'] = "Anzeige-Layer";
$GLOBALS['strDeliveryFilenamesAdLog'] = "Anzeige-Protokoll";
$GLOBALS['strDeliveryFilenamesAdPopup'] = "Anzeige-Popup";
$GLOBALS['strDeliveryFilenamesAdView'] = "Anzeige-View";
$GLOBALS['strDeliveryFilenamesXMLRPC'] = "XML RPC Bannercode";
$GLOBALS['strDeliveryFilenamesLocal'] = "Lokaler Bannercode";
$GLOBALS['strDeliveryFilenamesFrontController'] = "Front-Controller";
$GLOBALS['strDeliveryFilenamesSinglePageCall'] = "Einzelner Seitenanruf";
$GLOBALS['strDeliveryFilenamesSinglePageCallJS'] = "Einzelner Seitenaufruf (JavaScript)";
$GLOBALS['strDeliveryFilenamesAsyncJS'] = "Asynchrones JavaScript (Quelldatei)";
$GLOBALS['strDeliveryFilenamesAsyncPHP'] = "Asynchrones JavaScript";
$GLOBALS['strDeliveryFilenamesAsyncSPC'] = "Einzelner Seitenaufruf mit asynchronem JavaScript";
$GLOBALS['strDeliveryCaching'] = "Allgemeine Einstellungen des Auslieferungs-Caches";
$GLOBALS['strDeliveryCacheLimit'] = "Zeitintervall zwischen Cache-Aktualisierungen (in Sek.)";
$GLOBALS['strDeliveryCacheStore'] = "Cache-Typ für die Bannerauslieferung";
$GLOBALS['strDeliveryAcls'] = "Auslieferungsregeln für Banner während der Auslieferung überprüfen";
$GLOBALS['strDeliveryAclsDirectSelection'] = "Auslieferungsregeln für Banner für direkt ausgewählte Anzeigen überprüfen";
$GLOBALS['strDeliveryObfuscate'] = "Auslieferungsregelsatz bei der Auslieferung von Anzeigen verbergen";
$GLOBALS['strDeliveryPreconnect'] = "Bitten Sie die Browser mit der URL des Bildes vorab zu verbinden (falls sich von der URL der Zustellung unterscheidet, nur HTTPS-Funktion)";
$GLOBALS['strDeliveryClickUrlValidity'] = "Gültigkeit der benutzerdefinierten Ziel-URL leitet in {clickurl} Makros (Sekunden) um. Geben Sie 0 ein, um Umleitungen zu verbieten";
$GLOBALS['strDeliveryRelAttribute'] = "Standardmäßiges \"rel\"-Attribut für &lt;a href&gt; HTML-Tags";
$GLOBALS['strGlobalDefaultBannerInvalidZone'] = "Globaler Standard-HTML-Banner für nicht existierende Zonen";
$GLOBALS['strGlobalDefaultBannerSuspendedAccount'] = "Globales HTML-Standard-Banner für gesperrte Konten";
$GLOBALS['strGlobalDefaultBannerInactiveAccount'] = "Globales HTML-Standard-Banner für inaktive Konten";
$GLOBALS['strPrivacySettings'] = "Einstellungen zur Privatsphäre";
$GLOBALS['strDisableViewerId'] = "Eindeutigen \"Viewer Id\"-Cookie deaktivieren";
$GLOBALS['strAnonymiseIp'] = "IP-Adressen des Betrachters anonymisieren";
$GLOBALS['strDisableDeliveryCookies'] = 'Deaktiviere Zustellcookies';
$GLOBALS['strBannerFileSettings'] = 'Allgemeine Banner-Datei-Einstellungen';
$GLOBALS['strMaxBannerFilesize'] = 'Maximale Banner-Dateigröße (Bytes, 0 bedeutet unbegrenzt)';

// General Settings
$GLOBALS['generalSettings'] = "Allgemeine globale Systemeinstellungen";
$GLOBALS['uiEnabled'] = "Benutzeroberfläche aktiviert";
$GLOBALS['defaultLanguage'] = "Voreinstellung der Systemsprache<br />(Jeder Benutzer kann seine eigene Sprache einstellen)";

// Geotargeting Settings
$GLOBALS['strGeotargetingSettings'] = "Einstellungen Geotargeting";
$GLOBALS['strGeotargeting'] = "Einstellungen Geotargeting";
$GLOBALS['strGeotargetingType'] = "Typ des Geotargeting Moduls";
$GLOBALS['strGeoShowUnavailable'] = "Zeige Auslieferungsregeln für Geo-Targeting auch wenn GeoIP-Daten nicht verfügbar sind";

// Interface Settings
$GLOBALS['strInventory'] = "Inventar";
$GLOBALS['strShowCampaignInfo'] = "Anzeigen zusätzlicher Informationen auf der Seite <i>Übersicht Kampagnen</i>";
$GLOBALS['strShowBannerInfo'] = "Anzeigen zusätzlicher Bannerinformationen auf der Seite <i>Werbemittel</i> ";
$GLOBALS['strShowCampaignPreview'] = "Vorschau aller Werbemittel auf der Seite  <i>Werbemittel</i>";
$GLOBALS['strShowBannerHTML'] = "Anzeige des Banners anstelle des HTML-Codes bei Vorschau von HTML-Bannern";
$GLOBALS['strShowBannerPreview'] = "Werbemittelvorschau oben auf allen Seiten mit Bezug zum Werbemittel";
$GLOBALS['strUseWyswygHtmlEditorByDefault'] = "Verwenden Sie standardmäßig den WYSIWYG HTML-Editor beim Erstellen oder Bearbeiten von HTML-Bannern";
$GLOBALS['strHideInactive'] = "Inaktive ausblenden";
$GLOBALS['strGUIShowMatchingBanners'] = "Anzeige des zugehörenden Werbemittels auf der Seite <i>Verknüpfte Werbemittel</i>";
$GLOBALS['strGUIShowParentCampaigns'] = "Anzeige der zugehörenden Kampagne auf der Seite <i>Veknüpfte Werbemittel</i>";
$GLOBALS['strShowEntityId'] = "Zeige Kennzeichen der Einheit";
$GLOBALS['strStatisticsDefaults'] = "Statistiken";
$GLOBALS['strBeginOfWeek'] = "Wochenbeginn";
$GLOBALS['strPercentageDecimals'] = "Dezimalstellen bei Prozentangaben";
$GLOBALS['strWeightDefaults'] = "Gewichtung (Voreinstellung)";
$GLOBALS['strDefaultBannerWeight'] = "Bannergewichtung (Voreinstellung)";
$GLOBALS['strDefaultCampaignWeight'] = "Kampagnengewichtung (Voreinstellung)";
$GLOBALS['strConfirmationUI'] = "Bestätigung in der Benutzeroberfläche";

// Invocation Settings
$GLOBALS['strInvocationDefaults'] = "Banneranforderung Voreinstellung";
$GLOBALS['strEnable3rdPartyTrackingByDefault'] = "Erlaube '3rd Party Clicktracking' als Voreinstellung";

// Banner Delivery Settings
$GLOBALS['strBannerDelivery'] = "Einstellungen der Auslieferung";

// Banner Logging Settings
$GLOBALS['strBannerLogging'] = "Bannerprotokollierung - Einstellungen";
$GLOBALS['strLogAdRequests'] = "Protokolliere bei jedem Aufruf eines Werbemittels auf dem Server einen Ad Request";
$GLOBALS['strLogAdImpressions'] = "Protokolliere eine Ad Impression, wenn ein Werbemittel beim Nutzer angekommen ist (Truecount)";
$GLOBALS['strLogAdClicks'] = "Protoklliere einen Ad Click , wenn ein Nutzer auf ein Werbemittel klickt";
$GLOBALS['strReverseLookup'] = "Es wird versucht, den Name des Hosts für den Besucher zu ermitteln, wenn er nicht mitgeliefert wird";
$GLOBALS['strProxyLookup'] = "Es wird versucht, die echte IP-Adresse des Besuchers zu ermitteln, wenn er einen Proxy-Server nutzt";
$GLOBALS['strPreventLogging'] = "Protokollieren verhindern";
$GLOBALS['strIgnoreHosts'] = "Keine Statistikdaten speichern für Besucher mit folgenden IP-Adressen oder Hostnamen";
$GLOBALS['strIgnoreUserAgents'] = "<b>Keine</b> Statistikdaten loggen von den folgenden Browsern (user-agent), jeweils nur ein Eintrag pro Zeile";
$GLOBALS['strEnforceUserAgents'] = "Die Statistikdaten <b>nur</b> von den folgenden Browsern loggen (user-agent), jeweils nur ein Eintrag pro Zeile";

// Banner Storage Settings
$GLOBALS['strBannerStorage'] = "Einstellungen Speicherung der Banner";

// Campaign ECPM settings
$GLOBALS['strEnableECPM'] = "Verwenden Sie eCPM-optimierte Prioritäten statt Prioritäten nach Gewichtung";
$GLOBALS['strEnableContractECPM'] = "Verwenden Sie eCPM optimierte Prioritäten statt Prioritäten nach Standard-Verträgen";
$GLOBALS['strEnableECPMfromRemnant'] = "(Wenn Sie diese Funktion aktivieren, werden alle Ihre verbleibenden Kampagnen deaktiviert, Sie müssen sie manuell aktualisieren, um sie wieder zu aktivieren)";
$GLOBALS['strEnableECPMfromECPM'] = "(Wenn Sie diese Funktion deaktivieren, werden einige Ihrer aktiven eCPM-Kampagnen deaktiviert, Sie müssen sie manuell aktualisieren um sie zu reaktivieren)";
$GLOBALS['strInactivatedCampaigns'] = "Durch die Änderungen der Voreinstellungen werden die folgende Kampagnen deaktiviert:";

// Statistics & Maintenance Settings
$GLOBALS['strMaintenanceSettings'] = "Wartungseinstellungen";
$GLOBALS['strConversionTracking'] = "Einstellungen zum Konversionen-Tracking";
$GLOBALS['strEnableConversionTracking'] = "Konversionen-Tracking aktivieren";
$GLOBALS['strBlockInactiveBanners'] = "Zähle keine Anzeigen-Impressions oder Klicks und leite den Nutzer nicht zur Ziel-URL weiter, wenn der Betrachter auf ein inaktives Banner klickt";
$GLOBALS['strBlockAdClicks'] = "Zähle keine Ad Klicks wenn der Betrachter auf diese Banner/Zonen-Kombination innerhalb dieses Zeitraums schon geklickt hat (in Sekunden)";
$GLOBALS['strMaintenanceOI'] = "Wartungsintervall (in Minuten)";
$GLOBALS['strPrioritySettings'] = "Einstellung der Prioritäten";
$GLOBALS['strPriorityInstantUpdate'] = "Sofortige Neuberechnung der Prioritäten nach Änderungen in der Benutzeroberfläche.";
$GLOBALS['strPriorityIntentionalOverdelivery'] = "Vertragskampagnen vorsätzlich überliefern<br />(% Überlieferung)";
$GLOBALS['strDefaultImpConvWindow'] = "Standard-Zeitfenster für Konversion einer Anzeige (Sekunden)";
$GLOBALS['strDefaultCliConvWindow'] = "Standard-Zeitfenster für Konversion eines Anzeigen-Klicks (Sekunden)";
$GLOBALS['strAdminEmailHeaders'] = "Alle e-Mails, die von {$PRODUCT_NAME} gesendet werden, erhalten die folgenden Header hinzugefügt";
$GLOBALS['strWarnLimit'] = "Warnung per E-Mail bei Unterschreiten der definierten Untergrenze";
$GLOBALS['strWarnLimitDays'] = "Sende eine Warnung wenn weniger Tage verblieben sind als hier angegeben.";
$GLOBALS['strWarnAdmin'] = "Warnung per E-Mail an den Administrator, wenn eine Kampagne ausgelaufen ist";
$GLOBALS['strWarnClient'] = "Warnung per E-Mail an den Werbetreibenden, wenn eine Kampagne ausgelaufen ist";
$GLOBALS['strWarnAgency'] = "Warnung per E-Mail an die Agentur kurz bevor eine Kampagne ausläuft";

// UI Settings
$GLOBALS['strGuiSettings'] = "Konfiguration Benutzerbereich (Inhaber des AdServers)";
$GLOBALS['strGeneralSettings'] = "Allgemeine Einstellungen";
$GLOBALS['strAppName'] = "Name oder Bezeichnung der Anwendung";
$GLOBALS['strMyHeader'] = "Kopfzeile im Admin-Bereich";
$GLOBALS['strMyFooter'] = "Fußzeile im Admin-Bereich";
$GLOBALS['strDefaultTrackerStatus'] = "Standardstatus Tracker";
$GLOBALS['strDefaultTrackerType'] = "Standardtyp Tracker";
$GLOBALS['strSSLSettings'] = "Einstellungen SSL";
$GLOBALS['requireSSL'] = "Erzwinge die SSL Nutzung für die Benutzeroberfläche";
$GLOBALS['sslPort'] = "SSL Port des Webservers";
$GLOBALS['strDashboardSettings'] = "Dashboard Einstellungen";
$GLOBALS['strMyLogo'] = "Name der individuellen Logo-Datei";
$GLOBALS['strGuiHeaderForegroundColor'] = "Vordergrundfarbe der Kopfzeile";
$GLOBALS['strGuiHeaderBackgroundColor'] = "Hintergrundfarbe der Kopfzeile";
$GLOBALS['strGuiActiveTabColor'] = "Farbe des aktiven Reiters";
$GLOBALS['strGuiHeaderTextColor'] = "Textfarbe in der Kopfzeile";
$GLOBALS['strGuiSupportLink'] = "Eigene URL für 'Support' Link im Header";
$GLOBALS['strAdminCookieDomain'] = "Benutzerdefinierte Cookie-Domäne für die Benutzeroberfläche";
$GLOBALS['strGuiLoaderDelay'] = "Ladeanimation anzeigen, wenn der nächste Bildschirm länger als X Millisekunden benötigt wird (verwenden Sie -1 zum Deaktivieren)";
$GLOBALS['strGzipContentCompression'] = "Komprimieren mit GZIP";

// Regenerate Platfor Hash script
$GLOBALS['strPlatformHashRegenerate'] = "Platform Hash neu erzeugen";
$GLOBALS['strNewPlatformHash'] = "Ihr neuer Platform Hash ist:";
$GLOBALS['strPlatformHashInsertingError'] = "Fehler beim Eintragen des Platform Hash in die Datenbank";

// Plugin Settings
$GLOBALS['strPluginSettings'] = "Plugin Einstellungen";
$GLOBALS['strEnableNewPlugins'] = "Aktiviere neu installierte Plugins";
$GLOBALS['strUseMergedFunctions'] = "Zusammengefügte Datei mit Auslieferungsfunktionen verwenden";
