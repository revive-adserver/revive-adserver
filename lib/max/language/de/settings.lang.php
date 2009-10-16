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

// German
// Installer translation strings
$GLOBALS['strInstall']				= "Installation";
$GLOBALS['strChooseInstallLanguage']		= "Wählen Sie die Sprache für den Installationsprozeß";
$GLOBALS['strLanguageSelection']		= "Sprachauswahl";
$GLOBALS['strDatabaseSettings']			= "Datenbankeinstellungen";
$GLOBALS['strAdminSettings']			= "Einstellung für Administrator";
$GLOBALS['strAdminAccount']                 = "Administrator Zugang";
$GLOBALS['strAdministrativeSettings']       = "Administrative Einstellungen";
$GLOBALS['strAdvancedSettings']		= "Ergänzende Einstellungen";
$GLOBALS['strOtherSettings']			= "Andere Einstellungen";
$GLOBALS['strSpecifySyncSettings']          = "Synchronisations-Einstellungen";
$GLOBALS['strLicenseInformation']           = "Lizenz Information";
$GLOBALS['strOpenadsIdYour']                = "Ihre OpenX ID";
$GLOBALS['strOpenadsIdSettings']            = "OpenX ID Einstellungen";
$GLOBALS['strWarning']				= "Warnung";
$GLOBALS['strFatalError']			= "Ein schwerer Fehler ist aufgetreten";
$GLOBALS['strUpdateError']			= "Während des Updates ist ein Fehler aufgetreten";
$GLOBALS['strBtnContinue']                  = "Fortsetzen »";
$GLOBALS['strBtnGoBack']                    = "« zurück";
$GLOBALS['strBtnAgree']                     = "Ich stimme zu »";
$GLOBALS['strBtnDontAgree']                 = "« Ich widerspreche";
$GLOBALS['strBtnRetry']                     = "Erneut versuchen";
$GLOBALS['strUpdateDatabaseError']	= "Aus unbekannten Gründen war die Aktualisierung der Datenbankstruktur nicht erfolgreich. Es wird empfohlen, zu versuchen, mit <b>Wiederhole Update</b> das Problem zu beheben. Sollte der Fehler - Ihrer Meinung nach - die Funktionalitä von ".MAX_PRODUCT_NAME." nicht berühren, können Sie durch <b>Fehler ignorieren</b> fortfahren. Das Ignorieren des Fehlers wird nicht empfohlen!";
$GLOBALS['strAlreadyInstalled']			= "". MAX_PRODUCT_NAME ." ist auf Ihrem System bereits installiert. Wenn Sie es konfigurieren möchten, wechseln Sie zu den <a href='account-index.php'>Einstellungen</a>.";
$GLOBALS['strCouldNotConnectToDB']		= "Verbindung zur Datenbank war nicht möglich. Bitte vorgenommene Einstellung prüfen.";
$GLOBALS['strCreateTableTestFailed']		= "Der von Ihnen angegebene Nutzer hat nicht die notwendigen Zugriffsrechte, um die Datenbankstruktur anlegen zu können. Wenden Sie sich an den Systemverwalter.";
$GLOBALS['strUpdateTableTestFailed']		= " Der von Ihnen angegebene Nutzer hat nicht die notwendigen Zugriffsrechte, um die Datenbank zu aktualisieren. Wenden Sie sich an den Systemverwalter.";
$GLOBALS['strTablePrefixInvalid']		= "Ungültiges Vorzeichen (Präfix) im Tabellennamen";
$GLOBALS['strTableInUse']			= "Die genannte Datenbank wird bereits von ".MAX_PRODUCT_NAME.", genutzt. Verwenden Sie einen anderes Präfix oder lesen Sie im Handbuch die Hinweise für ein Upgrade.";
$GLOBALS['strNoVersionInfo']                = "Konnte Datenbankversion nicht rausfinden.";
$GLOBALS['strInvalidVersionInfo']           = "Konnte Datenbankversion nicht rausfinden.";
$GLOBALS['strInvalidMySqlVersion']          = "" . MAX_PRODUCT_NAME." benötigt MySQL 4.0 oder höher, um korrekt zu arbeiten. Bitte wählen Sie einen anderen Datenbankserver.";
$GLOBALS['strTableWrongType']		= "Der gewählte Tabellentype wird bei der Installation von ".$phpAds_dbmsname." nicht unterstützt";
$GLOBALS['strMayNotFunction']			= "Folgende Probleme sind zu beheben, um fortzufahren";
$GLOBALS['strFixProblemsBefore']		= "Folgende Teile müssen korrigiert werden, bevor der Installationsprozeß von ".MAX_PRODUCT_NAME." fortgesetzt werden kann. Informationen über Fehlermeldungen finden sich im Handbuch.";
$GLOBALS['strFixProblemsAfter']			= "Sollten Sie die oben aufgeführten Fehler nicht selbst heben können, nehmen Sie Kontakt mit der Systemadministration Ihres Servers auf. Diese wird Ihnen weiterhelfen können.";
$GLOBALS['strIgnoreWarnings']			= "Ignoriere Warnungen";
$GLOBALS['strWarningDBavailable']		= "Die eingesetzte PHP-Version unterstützt nicht die Verbindung zum ".$phpAds_dbmsname." Datenbankserver. Die PHP- ".$phpAds_dbmsname."-Erweiterung wird benötigt.";
$GLOBALS['strWarningPHPversion']		= "". MAX_PRODUCT_NAME ." benötigt mindestens PHP 5.1.4. Der Server verwendet aktuell {php_version}.";
$GLOBALS['strWarningRegisterGlobals']		= "Die PHP-Konfigurationsvaribable <i>register_globals</i> muß gesetzt werden.";
$GLOBALS['strWarningMagicQuotesGPC']		= " Die PHP-Konfigurationsvaribable <i> magic_quotes_gpc</i> muß gesetzt werden.";
$GLOBALS['strWarningMagicQuotesRuntime']	= " Die PHP-Konfigurationsvaribable <i> magic_quotes_runtime</i> muß deaktiviert werden.";
$GLOBALS['strWarningFileUploads']		= " Die PHP-Konfigurationsvaribable <i> file_uploads</i> muß gesetzt werden.";
$GLOBALS['strWarningTrackVars']			= " Die PHP-Konfigurationsvaribable <i> track_vars</i> muß gesetzt werden.";
$GLOBALS['strWarningPREG']				= "Die verwendete PHP-Version unterstützt nicht PERL-kompatible Ausdrücke. Um fortfahren zu können wird die PHP-Erweiterung <i>PREG</i> benötigt.";
$GLOBALS['strConfigLockedDetected']		= "" . MAX_PRODUCT_NAME." hat erkannt, daß die Datei <b>config.inc.php</b> schreibgeschützt ist.<br /> Die Installation kann aber ohne Schreibberechtigung nicht fortgesetzt werden. <br />Weitere Informationen finden sich im Handbuch.";

$GLOBALS['strCantUpdateDB']  			= "Ein Update der Datenbank ist derzeit nicht möglich. Wenn Sie die Installation fortsetzen, werden alle existierende Banner, Statistiken und Werbetreibenden gelöscht. ";
$GLOBALS['strIgnoreErrors']			= "Fehler ignorieren";
$GLOBALS['strRetryUpdate']			= "Wiederhole Update";
$GLOBALS['strTableNames']			= "Tabellenname";
$GLOBALS['strTablesPrefix']			= "Präfix zum Tabellenname";
$GLOBALS['strTablesType']			= "Tabellentype";
$GLOBALS['strInstallWelcome']			= "Willkommen bei ".MAX_PRODUCT_NAME;
$GLOBALS['strInstallMessage']			= "Bevor ".MAX_PRODUCT_NAME." genutzt werden kann, müssen die Einstellungen konfiguriert  <br /> sowie die Datenbank geschaffen (create) werden. Drücken Sie <b>Weiter</b> , um fortzufahren.";

$GLOBALS['strInstallIntro']                 = "Vielen Dank das Sie <a href='http://".MAX_PRODUCT_URL."' target='_blank'><strong>".MAX_PRODUCT_NAME."</strong></a> gewählt haben<p>Dieser Assistent wird Sie durch den Installations oder Upgradevorgang des ".MAX_PRODUCT_NAME." AdServers führen.</p><p>Zu Ihrer Unterstützung bei der Installation haben wir eine an <a href='". OX_PRODUCT_DOCSURL ."/wizard/qsg-install' target='_blank'>Kurzanleitung für die Installation</a> erstellt. Diese Anleitung erklärt die wichtigsten Schritte während der Installation. Ausführlichere Informationen und weitere Konfigurationsdetails über ".MAX_PRODUCT_NAME." finden Sie auf im <a href='". OX_PRODUCT_DOCSURL ."/wizard/admin-guide' target='_blank'>Administrator Leitfaden</a>.";
$GLOBALS['strTermsTitle']               = "Nutzungsbedingungen, Datenschutzerklärung";
$GLOBALS['strTermsIntro']               = "".MAX_PRODUCT_NAME." wird unter der Open Source Lizenz 'GNU General Public License' vertrieben. Sie sollten das folgende Dokument lesen und müssen die Bedingungen akzeptieren, bevor Sie mit der Installation fortfahren können.";
$GLOBALS['strPolicyTitle']               = "Datenschutzerklärung";
$GLOBALS['strPolicyIntro']               = "Bitte lesen und akzeptieren Sie die folgenden Bedingungen um mit der Installation fortzufahren.";
$GLOBALS['strDbSetupTitle']               = "Datenbankeinstellungen";
$GLOBALS['strDbSetupIntro']               = "Bitte tragen Sie die Zugangsdetails für Ihre Datenbank ein. Bitten Sie Ihren Systemadministrator um Unterstützung wenn Sie sich nicht sicher sind.<p>Im nächsten Schritt wird Ihre Datenbank eingerichtet. Klicken Sie auf 'Fortsetzen' um hiermit zu beginnen.</p>";
$GLOBALS['strDbUpgradeIntro']             = "Unten finden Sie die ermittelten Datenbank-Informationen für Ihre Installation von ".MAX_PRODUCT_NAME.". Bitte überprüfen Sie die Angaben auf Richtigkeit.<p>Der nächste Schritt wird die Datenbank aktualisieren. Klicken Sie auf 'Fortsetzen' um hiermit zu beginnen.</p>";

$GLOBALS['strOaUpToDate']               = "Ihre ". MAX_PRODUCT_NAME ." Datenbank und Verzeichnisstruktur ist auf dem neusten Stand, für diese Daten ist kein Upgradevorgang nötig. Bitte klicken Sie auf Fortsetzen um zur Administrationsseite von ". MAX_PRODUCT_NAME ." zu gelangen.";
$GLOBALS['strOaUpToDateCantRemove']     = "Warnung: Es fehlen die nötigen Rechte an der Datei UPGRADE um diese aus dem Openads-'var'-Verzeichnis zu entfernen. Bitte löschen Sie die Datei manuell.";
$GLOBALS['strRemoveUpgradeFile']               = "Sie müssen die Datei UPGRADE aus dem var-Verzeichnis löschen.";


$GLOBALS['strInstallSuccess']			=
"Mit einem Klick auf 'Fortsetzen' werden Sie in den AdServer eingeloggt.<p><strong>Was sollten Sie als nächstes tun?</strong></p><div class='psub'><p><b>Registrieren Sie sich für Produktupgrades</b><br><a href='". OX_PRODUCT_DOCSURL ."/wizard/join' target='_blank'>Tragen Sie sich in die ". MAX_PRODUCT_NAME ." e-Mail-Verteiler ein.</a> um über Produktupgrades, Sicherheitshinweise und neue Produktankündigungen informiert zu werden.</p><p><b>Liefern Sie Ihre erste Kampagne aus</b><br>Lesen Sie unsere <a href='". OX_PRODUCT_DOCSURL ."/wizard/qsg-firstcampaign' target='_blank'>Kurzanleitung zur Einrichtung einer ersten Werbekampagne</a></p></div><p><strong>Weitere (optionale) Schritte</strong></p><div class='psub'><p><b>Entfernen Sie den Schreibschutz der Konfigurationsdatei</b><br>Sie erhöhen die Sicherheit Ihres AdServers und verhindern ungewollte Modifikationen an den Einstellungen. <a href='". OX_PRODUCT_DOCSURL ."/wizard/lock-config' target='_blank'>Lesen Sie mehr ...</a></p><p><b>Einrichtung eines regelmäßigen Wartungslaufes</b><br>Der Wartungslauf ist erforderlich um zeitnahe Statistiken und die bestmögliche Ausführungsgeschwindigkeit des AdServers zu erhalten. <a href='". OX_PRODUCT_DOCSURL ."/wizard/setup-cron' target='_blank'>Lesen Sie mehr ...</a></p><p><b>Überprüfen Sie die Konfigurationseinstellungen</b><br>Bevor Sie ". MAX_PRODUCT_NAME ." in Betrieb nehmen, sollten Sie die Konfiguration unter dem Tab 'Einstellungen' überprüfen.</p></div>";

$GLOBALS['strInstallNotSuccessful']		= "Die Installation von ". MAX_PRODUCT_NAME ."  war nicht erfolgreich. Einige Teilschritte der Installationprozedur konnten nicht ausgeführt werden. Es ist durchaus möglich, das dieses Problem nur vorübergehend besteht und eine Wiederholung der Installation vom ersten Installationschritt durch einen Klick auf 'Weiter' zum Erfolg führt. Mehr über die untenstehende Fehlermeldung erfahren Sie aus der Dokumentation.";
$GLOBALS['strSystemCheck']                  = "Systemüberprüfung";
$GLOBALS['strSystemCheckIntro']             = "Der Installations-Assistent überprüft die Einstellungen Ihres Webservers um sicherzustellen, dass die Installation erfolgreich fortgesetzt werden kann.<p>Bitte überprüfen Sie alle markieren Probleme um die Installation fortzusetzen.</p>";
$GLOBALS['strDbSuccessIntro']               = "Die ".MAX_PRODUCT_NAME." Datenbank ist erstellt worden. Bitte klicken Sie auf 'Fortsetzen' um mit der Konfiguration der Einstellungen von ".MAX_PRODUCT_NAME." zum Administrator und der Auslieferung zu beginnen.";
$GLOBALS['strDbSuccessIntroUpgrade']        = "Ihr System wurde erfolgreich aktualisiert. Die folgenden Seiten unterstützen Sie dabei, zusätzliche Einstellungen Ihres AdServers zu überprüfen.";
$GLOBALS['strErrorOccured']			= "Der folgende Fehler ist aufgetreten:";
$GLOBALS['strErrorInstallDatabase']		= "Die Datenbankstruktur konnte nicht angelegt werden.";
$GLOBALS['strErrorInstallPrefs']            = "Die Benutzereinstellungen für den Administrator konnten nicht in die Datenbank geschrieben werden.";
$GLOBALS['strErrorInstallVersion']          = "Die " . MAX_PRODUCT_NAME . " Versionsnummer konnte nicht in die Datenbank geschrieben werden.";
$GLOBALS['strErrorUpgrade'] = 'Das Upgrade der Datenbank der bestehenden Installation ist fehlgeschlagen.';
$GLOBALS['strErrorInstallDbConnect']		= "Eine Verbindung zur Datenbank konnte nicht geöffnet werden.";
$GLOBALS['strErrorWritePermissions']        = "Nicht ausreichende Datei- und Verzeichnisrechte erkannt, Sie müssen dies beheben bevor die Installation fortgesetzt werden kann.<br />Um diese Rechte auf einem Linux System zu gewähren, tippen Sie den/die folgenden Befehle auf einer Shell:";
$GLOBALS['strErrorFixPermissionsCommand']   = "<i>chmod a+w %s</i>";
$GLOBALS['strErrorFixPermissionsRCommand']  = "<i>chmod -R a+w %s</i>";
$GLOBALS['strCheckDocumentation']           = "Für weitere Hilfe sehen Sie bitte in das Handbuch unter http://".OA_DOCUMENTATION_BASE_URL;

$GLOBALS['strAdminUrlPrefix']               = "URL der Admin-Oberfläche";
$GLOBALS['strDeliveryUrlPrefix']            = "URL des Ad-Servers";
$GLOBALS['strDeliveryUrlPrefixSSL']         = "URL des Ad-Servers (SSL)";
$GLOBALS['strImagesUrlPrefix']              = "URL des Verzeichnisses in dem die Grafiken gespeichert werden.";
$GLOBALS['strImagesUrlPrefixSSL']           = "URL des Verzeichnisses in dem die Grafiken gespeichert werden (SSL).";

$GLOBALS['strInvalidUserPwd']			= "Fehlerhafter Benutzername oder Passwort";

$GLOBALS['strUpgrade']				= "Programmaktualisierung (Upgrade)";
$GLOBALS['strSystemUpToDate']		= "Das System ist bereits aktuell. Eine Aktualisierung (Upgrade) ist nicht notwendig. <br />\nDrücken Sie <b>Weiter</b>, um zur Startseite zu gelangen.";
$GLOBALS['strSystemNeedsUpgrade']		= "Die Datenbankstruktur und die Konfigurationsdateien sollten aktualisiert werden. Drücken Sie <b>Weiter</b> für den Start des Aktualisierungslaufes.\n <br /><br />Abhängig von der derzeitig genutzten Version und der Anzahl der vorhandenen Statistiken kann dieser Prozeß Ihre Datenbank stark belasten. Das Upgrade kann einige Minuten dauern.";
$GLOBALS['strSystemUpgradeBusy']		= "Aktualisierung des Systems läuft. Bitte warten ...";
$GLOBALS['strSystemRebuildingCache']		= "Cache wird neu erstellt. Bitte warten ...";
$GLOBALS['strServiceUnavalable']		= "Dieser Service ist zur Zeit nicht erreichbar. System wird aktualisiert...";


/*-------------------------------------------------------*/
/* Configuration translations                            */
/*-------------------------------------------------------*/

// Global
$GLOBALS['strChooseSection']			= "Bereichsauswahl";
$GLOBALS['strEditConfigNotPossible']   		= "Änderungen der Systemeinstellung nicht möglich. Für die Konfigurationsdatei besteht Schreibschutz. Für Änderungen muß der Schreibschutz aufgehoben werden.";
$GLOBALS['strEditConfigPossible']		= "Unbefugte Systemänderungen sind möglich. Die Zugriffsrechte der Konfigurationsdatei sind auf Schreibberechtigung gesetzt. Zur Sicherung des Systems sollte der Schreibschutz gesetzt werden. Nähere Informationen im Handbuch.";
$GLOBALS['strUnableToWriteConfig']                   = 'Die Änderungen konnten nicht in die Konfigurationsdatei übernommen werden';
$GLOBALS['strUnableToWritePrefs']                    = 'Die Voreinstellungen konnten nicht in die Datenbank geschrieben werden.';
$GLOBALS['strImageDirLockedDetected']	             = "Für das angegebene <b>Banner-Verzeichnis</b> hat der Server keine Schreibrechte.<br>Sie können den Vorgang erst fortsetzen wenn Sie die Verzeichnisrechte ändern oder das Verzeichnis anlegen.";

// Configuration Settings
$GLOBALS['strConfigurationSetup']                    = 'Aufstellung der Konfiguration';
$GLOBALS['strConfigurationSettings']                    = 'Einstellungen der Konfiguration';

// Administrator settings
$GLOBALS['strAdministratorSettings']		= "Einstellung für Administrator";
$GLOBALS['strAdministratorAccount']                  = 'Das Administrator Konto';
$GLOBALS['strLoginCredentials']			= "Anmeldeinformationen";
$GLOBALS['strAdminUsername']			= "Benutzername (Admin)";
$GLOBALS['strAdminPassword']                         = 'Passwort (Admin)';
$GLOBALS['strInvalidUsername']			= "Benutzername fehlerhaft";
$GLOBALS['strBasicInformation']			= "Grundinformation";
$GLOBALS['strAdminFullName']			= "Vorname Name des Admin";
$GLOBALS['strAdminEmail']			= "E-Mail des Admin";
$GLOBALS['strAdministratorEmail']                            = 'E-Mail des Administrators';
$GLOBALS['strCompanyName']			= "Firma";
$GLOBALS['strAdminCheckUpdates']		= "Automatisch auf Produktupdates und Sicherheitshinweise prüfen (Empfohlen).";
$GLOBALS['strAdminCheckEveryLogin']		= "Bei jedem Login";
$GLOBALS['strAdminCheckDaily']		= "Täglich";
$GLOBALS['strAdminCheckWeekly']		= "Wöchentlich";
$GLOBALS['strAdminCheckMonthly']		= "Monatlich";
$GLOBALS['strAdminCheckNever']		= "Nie";
$GLOBALS['strAdminNovice']			= "Löschen durch den Administrator erfordert zur Sicherheit eine zusätzliche Bestätigung";
$GLOBALS['strUserlogEmail']			= "Alle ausgehenden E-Mails protokollieren ";
$GLOBALS['strEnableDashboard']                       = "Dashboard aktivieren";
$GLOBALS['strTimezoneInformation']                   = "Zeitzone (Änderungen beeinflussen die Statistik)";
$GLOBALS['strTimezone']                              = "Zeitzone";
$GLOBALS['strTimezoneEstimated']                     = "Vermutete Zeitzone";
$GLOBALS['strTimezoneGuessedValue']                  = "Die Server-Zeitzone für PHP ist nicht richtig gesetzt.";
$GLOBALS['strTimezoneSeeDocs']                       = "Für Informationen über diese PHP Variable sehen Sie bitte unter %DOCS% nach.";
$GLOBALS['strTimezoneDocumentation']                 = "Dokumentation";
$GLOBALS['strLoginSettingsTitle']                    = "Administrator Anmeldung";
$GLOBALS['strLoginSettingsIntro']                    = "Bitte verwenden Sie Ihre ".MAX_PRODUCT_NAME." Administrator-Zugangsdaten in den entsprechenden Feldern. Sie müssen sich als Administrator einloggen um den Upgradevorgang fortzusetzen.";
$GLOBALS['strAdminSettingsTitle']                    = "Anlegen des Administrations-Zugangs";
$GLOBALS['strAdminSettingsIntro']                    = "Bitte füllen Sie die Eingabefelder aus um den Administrator-Zugang für diesen AdServer anzulegen.";
$GLOBALS['strConfigSettingsIntro']                    = "Bitte überprüfen Sie die unten stehenden Einstellungen und nehmen Sie ggf. die nötigen Änderungen vor. Wenn Sie sich nicht sicher sind, verwenden Sie die vorgegebenen Werte.";
$GLOBALS['strEnableAutoMaintenance']	             = "Durchführen von automatischen Maintenance-Wartungsläufen während der Bannerauslieferung, wenn regelmäßigen Wartungsläufe nicht eingerichtet sind.";

// OpenX ID Settings
$GLOBALS['strOpenadsUsername']                       = "".MAX_PRODUCT_NAME." Benutzername";
$GLOBALS['strOpenadsPassword']                       = "".MAX_PRODUCT_NAME." Passwort";
$GLOBALS['strOpenadsEmail']                          = "".MAX_PRODUCT_NAME." e-Mail";

// Banner Settings
$GLOBALS['strBannerSettings']                        = 'Bannereinstellungen';
$GLOBALS['strDefaultBanners']			= "Ersatzbanner <i>(kein reguläres Banner steht zur Verfügung)</i>";
$GLOBALS['strDefaultBannerUrl']		= "Bild-URL für Ersatzbanner";
$GLOBALS['strDefaultBannerDestination']      = 'Ziel-URL für Ersatzbanner';
$GLOBALS['strAllowedBannerTypes']		= "Zugelassene Bannertypen (Mehrfachnennung möglich)";
$GLOBALS['strTypeSqlAllow']			= "Banner in Datenbank speichern (SQL)";
$GLOBALS['strTypeWebAllow']			= "Banner auf Web-Server (lokal)";
$GLOBALS['strTypeUrlAllow']			= "Banner über URL verwalten";
$GLOBALS['strTypeHtmlAllow']			= "HTML-Banner";
$GLOBALS['strTypeTxtAllow']			= "Textanzeigen";
$GLOBALS['strTypeHtmlSettings']		= "Optionen für HTML-Banner";
$GLOBALS['strTypeHtmlAuto']			= "HTML-Code zum Aufzeichnen der AdClicks modifizieren";
$GLOBALS['strTypeHtmlPhp']			= "Erlaube die Ausführung von PHP-Anweisungen innerhalb eines HTML-Banners";


// Database
$GLOBALS['strDatabaseSettings']			= "Datenbankeinstellungen";
$GLOBALS['strDatabaseServer']			= "Datenbank Server";
$GLOBALS['strDbLocal']				= "Verwenden Sie eine lokale Socket-Verbindung"; // Pg only
$GLOBALS['strDbType']                                = 'Datenbank Typ';
$GLOBALS['strDbHost']				= "Datenbank Hostname";
$GLOBALS['strDbPort']				= "Datenbank Portnummer";
$GLOBALS['strDbUser']				= "Datenbank Benutzername";
$GLOBALS['strDbPassword']			= "Datenbank Passwort";
$GLOBALS['strDbName']			= "Datenbank Name";
$GLOBALS['strDatabaseOptimalisations']		= "Einstellungen zur Datenbank-Optimierung";
$GLOBALS['strPersistentConnections']		= "Dauerhafte (persistente) Verbindung zur Datenbank";
$GLOBALS['strCantConnectToDb']		= "Verbindung zur Datenbank nicht möglich";
$GLOBALS['strDemoDataInstall']                       = 'Einrichten von Beispieldaten';
$GLOBALS['strDemoDataIntro']                         = 'Um Ihnen zu zeigen wie Kampagnen, Banner und Zonen in ".'.MAX_PRODUCT_NAME.'." organisiert werden, können bei der Installation einige Beispieldaten eingerichtet werden. Wenn Sie ".'.MAX_PRODUCT_NAME.'." das erste mal nutzen, empfehlen wir Ihnen diese Daten einzurichten. ';

// Debug Logging Settings
$GLOBALS['strDebugSettings']                         = 'Debug-Logging';
$GLOBALS['strDebug']                                 = 'Grundsätzliche Einstellungen für das Debug-Logging';
$GLOBALS['strProduction']                            = 'Produktions-Server';
$GLOBALS['strEnableDebug']                           = 'Debug-Logging aktivieren';
$GLOBALS['strDebugMethodNames']                      = 'Methodennamen im Debug-Log eintragen';
$GLOBALS['strDebugLineNumbers']                      = 'Zeilennummern im Debug-Log vermerken';
$GLOBALS['strDebugType']                             = 'Typ des Debug-Logs';
$GLOBALS['strDebugTypeFile']                         = 'Datei';
$GLOBALS['strDebugTypeMcal']                         = 'mCal';
$GLOBALS['strDebugTypeSql']                          = 'SQL-Datenbank';
$GLOBALS['strDebugTypeSyslog']                       = 'Syslog';
$GLOBALS['strDebugName']                             = 'Name des Debug-Logs, Kalender, SQL-Tabelle,<br />oder Syslog Facility';
$GLOBALS['strDebugPriority']                         = 'Debug Dringlichkeitsstufe';
$GLOBALS['strPEAR_LOG_DEBUG']                        = 'PEAR_LOG_DEBUG - Alle Informationen';
$GLOBALS['strPEAR_LOG_INFO']                         = 'PEAR_LOG_INFO – fast alle Informationen';
$GLOBALS['strPEAR_LOG_NOTICE']                       = 'PEAR_LOG_NOTICE – nur allgemeine Hinweise';
$GLOBALS['strPEAR_LOG_WARNING']                      = 'PEAR_LOG_WARNING – Warnungen';
$GLOBALS['strPEAR_LOG_ERR']                          = 'PEAR_LOG_ERR – einfache Fehler';
$GLOBALS['strPEAR_LOG_CRIT']                         = 'PEAR_LOG_CRIT – schwerwiegende Fehler';
$GLOBALS['strPEAR_LOG_ALERT']                        = 'PEAR_LOG_ALERT – kritische Fehler';
$GLOBALS['strPEAR_LOG_EMERG']                        = 'PEAR_LOG_EMERG - Minimalinformationen';
$GLOBALS['strDebugIdent']                            = 'Debug Identifikations-String';
$GLOBALS['strDebugUsername']                         = 'mCal, SQL-Server Nutzername';
$GLOBALS['strDebugPassword']                         = 'mCal, SQL-Server Paßwort';

// Delivery Settings
$GLOBALS['strDeliverySettings']			= "Einstellungen für Bannerauslieferung";
$GLOBALS['strWebPath']                               = 'Übersicht ".'.MAX_PRODUCT_NAME.'." Server-Pfade';
$GLOBALS['strWebPathSimple']                         = 'Web-Pfad';
$GLOBALS['strDeliveryPath']                          = 'Auslieferungs-Pfad';
$GLOBALS['strImagePath']                             = 'Banner-Pfad';
$GLOBALS['strDeliverySslPath']                       = 'Auslieferungs-Pfad SSL';
$GLOBALS['strImageSslPath']                          = 'Banner-Pfad SSL';
$GLOBALS['strImageStore']                            = 'Banner Verzeichnis';
$GLOBALS['strTypeWebSettings']                       = 'Allgemeine Einstellungen zur lokalen Speicherung von Werbemitteln';
$GLOBALS['strTypeWebMode']                           = 'Speicherart';
$GLOBALS['strTypeWebModeLocal']                      = 'Lokales Verzeichnis';
$GLOBALS['strTypeDirError']                          = 'Der Web-Server hat keine Schreibrechte auf das lokale Verzeichnis';
$GLOBALS['strTypeWebModeFtp']                        = 'Externer FTP-Server';
$GLOBALS['strTypeWebDir']                            = 'Lokales Verzeichnis';
$GLOBALS['strTypeFTPHost']			= "FTP-Rechner";
$GLOBALS['strTypeFTPDirectory']		= "FTP-Verzeichnis";
$GLOBALS['strTypeFTPUsername']		= "Anmelden";
$GLOBALS['strTypeFTPPassword']		= "Passwort";
$GLOBALS['strTypeFTPPassive']                        = 'Passives FTP verwenden';
$GLOBALS['strTypeFTPErrorDir']		= "FTP-Verzeichnis existiert nicht";
$GLOBALS['strTypeFTPErrorConnect']		= "Verbindung zum FTP Server nicht möglich. Benutzername oder Passwort waren fehlerhaft";
$GLOBALS['strTypeFTPErrorHost']			= "Rechnername für FTP-Server ist fehlerhaft";
$GLOBALS['strDeliveryFilenames']                     = 'Namen der Dateien, die das System zur Werbemittelauslieferung nutzt';
$GLOBALS['strDeliveryFilenamesAdClick']              = 'Ad Click';
$GLOBALS['strDeliveryFilenamesAdConversionVars']     = 'Ad Conversion Variablen';
$GLOBALS['strDeliveryFilenamesAdContent']            = 'Ad Content';
$GLOBALS['strDeliveryFilenamesAdConversion']         = 'Ad Conversion';
$GLOBALS['strDeliveryFilenamesAdConversionJS']       = 'Ad Conversion (JavaScript)';
$GLOBALS['strDeliveryFilenamesAdFrame']              = 'Ad Frame';
$GLOBALS['strDeliveryFilenamesAdImage']              = 'Ad Image';
$GLOBALS['strDeliveryFilenamesAdJS']                 = 'Ad (JavaScript)';
$GLOBALS['strDeliveryFilenamesAdLayer']              = 'Ad Layer';
$GLOBALS['strDeliveryFilenamesAdLog']                = 'Ad Log';
$GLOBALS['strDeliveryFilenamesAdPopup']              = 'Ad Popup';
$GLOBALS['strDeliveryFilenamesAdView']               = 'Ad View';
$GLOBALS['strDeliveryFilenamesXMLRPC']               = 'XML RPC Bannercode';
$GLOBALS['strDeliveryFilenamesLocal']                = 'Lokaler Bannercode';
$GLOBALS['strDeliveryFilenamesFrontController']      = 'Front Controller';
$GLOBALS['strDeliveryFilenamesFlash']                = 'Flash Include (Kann eine vollständige URL sein)';
$GLOBALS['strDeliveryCaching']                       = 'Allgemeine Einstellungen des Auslieferungs-Caches';
$GLOBALS['strDeliveryCacheEnable']                   = 'Auslieferungs-Cache aktivieren';
$GLOBALS['strDeliveryCacheType']                     = 'Typ des Auslieferungs-Caches';
$GLOBALS['strCacheFiles']                            = 'Datei';
$GLOBALS['strCacheDatabase']                         = 'Datenbank';
$GLOBALS['strDeliveryCacheLimit']                    = 'Zeitintervall zwischen Cache-Aktualisierungen (in Sek.)';
$GLOBALS['strOrigin']                                = 'Nutze entfernten Ursprungsserver';
$GLOBALS['strOriginType']                            = 'Ursprungsserver Typ';
$GLOBALS['strOriginHost']                            = 'Hostname des Ursprungsservers';
$GLOBALS['strOriginPort']                            = 'Port-Nummer des Ursprungsserver Datenbank';
$GLOBALS['strOriginScript']                          = 'Script-Datei für Ursprungsserver Datenbank';
$GLOBALS['strOriginTypeXMLRPC']                      = 'XMLRPC';
$GLOBALS['strOriginTimeout']                         = 'Zeitlimit (Sekunden) für Ursprungsserver';
$GLOBALS['strOriginProtocol']                        = 'Protokoll für Ursprungsserver ';
$GLOBALS['strDeliveryBanner']                        = 'Allgemeine Einstellungen der Werbemittelauslieferung';
$GLOBALS['strDeliveryAcls']                          = 'Überprüfe die Auslieferungseinschränkungen eines Banners während der Auslieferung';
$GLOBALS['strDeliveryObfuscate']                     = 'Bei der Auslieferung die Gruppe eines Werbemittels verschleiern';
$GLOBALS['strDeliveryExecPhp']                       = 'PHP-Code in Werbemitteln wird ausgeführt<br />(Achtung: Starkes Sicherheitsrisiko)';
$GLOBALS['strDeliveryCtDelimiter']                   = 'Begrenzung des 3rd Party Kick-Trackings';
$GLOBALS['strP3PSettings']			= "P3P-Datenschutzrichtlinien";
$GLOBALS['strUseP3P']				= "Verwendung von P3P-Richtlinien";
$GLOBALS['strP3PCompactPolicy']		= "P3P-Datenschutzrichtlinien (kompakte Form)";
$GLOBALS['strP3PPolicyLocation']		= "Speicherort der P3P-Richtlinien";

// General Settings
$GLOBALS['generalSettings']                          = 'Allgemeine globale Systemeinstellungen';
$GLOBALS['uiEnabled']                                = 'Benutzeroberfläche aktiviert';
$GLOBALS['defaultLanguage']                          = 'Voreinstellung der Systemsprache<br />(Jeder Benutzer kann seine eigene Sprache einstellen)';
$GLOBALS['requireSSL']                               = 'Erzwinge die SSL Nutzung für die Benutzeroberfläche';
$GLOBALS['sslPort']                                  = 'SSL Port des Webservers';

// Geotargeting
$GLOBALS['strGeotargetingSettings']                  = 'Einstellungen Geotargeting';
$GLOBALS['strGeotargeting']			= "Einstellungen Geotargeting";
$GLOBALS['strGeotargetingType']                      = 'Typ des Geotargeting Moduls';
$GLOBALS['strGeotargetingGeoipCountryLocation']      = 'Speicherort der MaxMind GeoIP Länderdatenbank<br />(Leer lassen um freie Datenbank zu nutzen)';
$GLOBALS['strGeotargetingGeoipRegionLocation']       = 'Speicherort der MaxMind GeoIP Regionendatenbank';
$GLOBALS['strGeotargetingGeoipCityLocation']         = 'Speicherort der MaxMind GeoIP Städtedatenbank';
$GLOBALS['strGeotargetingGeoipAreaLocation']         = 'Speicherort der MaxMind GeoIP Gebietsdatenbank';
$GLOBALS['strGeotargetingGeoipDmaLocation']          = 'Speicherort der MaxMind GeoIP DMA-Databank (nur USA)';
$GLOBALS['strGeotargetingGeoipOrgLocation']          = 'Speicherort der MaxMind GeoIP Organisationendatenbank';
$GLOBALS['strGeotargetingGeoipIspLocation']          = 'Speicherort der MaxMind GeoIP ISP-Datenbank';
$GLOBALS['strGeotargetingGeoipNetspeedLocation']     = 'Speicherort der MaxMind GeoIP Bandbreitendatenbank';
$GLOBALS['strGeoSaveStats']                          = 'Speichere die GeoIP-Daten in den Datenbank-Logs';
$GLOBALS['strGeoShowUnavailable']                    = 'Zeige die durch Geotargeting verursachten Auslieferungslimitierungen an, auch wenn keine GeoIP-Daten verfügbar sind';
$GLOBALS['strGeotrackingGeoipCountryLocationError']  = 'Die MaxMind GeoIP Länderdatenbank konnte im angegebenen Verzeichnis nicht gefunden werden';
$GLOBALS['strGeotrackingGeoipRegionLocationError']   = 'Die MaxMind GeoIP Regionendatenbank konnte im angegebenen Verzeichnis nicht gefunden werden';
$GLOBALS['strGeotrackingGeoipCityLocationError']     = 'Die MaxMind GeoIP Städtedatenbank konnte im angegebenen Verzeichnis nicht gefunden werden';
$GLOBALS['strGeotrackingGeoipAreaLocationError']     = 'Die MaxMind GeoIP Gebietsdatenbank konnte im angegebenen Verzeichnis nicht gefunden werden';
$GLOBALS['strGeotrackingGeoipDmaLocationError']      = 'Die MaxMind GeoIP DMA-Datenbank konnte im angegebenen Verzeichnis nicht gefunden werden';
$GLOBALS['strGeotrackingGeoipOrgLocationError']      = 'Die MaxMind GeoIP Organisationendatenbank konnte im angegebenen Verzeichnis nicht gefunden werden';
$GLOBALS['strGeotrackingGeoipIspLocationError']      = 'Die MaxMind GeoIP ISP-Datenbank konnte im angegebenen Verzeichnis nicht gefunden werden';
$GLOBALS['strGeotrackingGeoipNetspeedLocationError'] = 'Die MaxMind GeoIP Bandbreitendatenbank konnte im angegebenen Verzeichnis nicht gefunden werden';

// Interface Settings
$GLOBALS['strInterfaceDefaults']		= "Einstellungen der Nutzeroberfläche";
$GLOBALS['strInventory']			= "Inventar-Seiten";
$GLOBALS['strUploadConversions']                     = 'Konversionen hochladen';
$GLOBALS['strShowCampaignInfo']		= "Anzeigen zusätzlicher Informationen auf der Seite <i>Übersicht Kampagnen</i>";
$GLOBALS['strShowBannerInfo']			= "Anzeigen zusätzlicher Bannerinformationen auf der Seite <i>Werbemittel</i> ";
$GLOBALS['strShowCampaignPreview']		= "Vorschau aller Werbemittel auf der Seite  <i>Werbemittel</i>";
$GLOBALS['strShowBannerHTML']			= "Anzeige des Banners anstelle des HTML-Codes bei Vorschau von HTML-Bannern";
$GLOBALS['strShowBannerPreview']		= "Werbemittelvorschau oben auf allen Seiten mit Bezug zum Werbemittel";
$GLOBALS['strHideInactive']			= "Inaktive ausblenden";
$GLOBALS['strGUIShowMatchingBanners']		= "Anzeige des zugehörenden Werbemittels auf der Seite <i>Verknüpfte Werbemittel</i>";
$GLOBALS['strGUIShowParentCampaigns']		= "Anzeige der zugehörenden Kampagne auf der Seite <i>Veknüpfte Werbemittel</i>";
$GLOBALS['strGUIAnonymousCampaignsByDefault']        = 'anonyme Kampagnen als Grundeinstellung';
$GLOBALS['strStatisticsDefaults'] 		= "Statistiken";
$GLOBALS['strBeginOfWeek']			= "Wochenbeginn";
$GLOBALS['strPercentageDecimals']		= "Dezimalstellen bei Prozentangaben";
$GLOBALS['strWeightDefaults']			= "Gewichtung (Voreinstellung)";
$GLOBALS['strDefaultBannerWeight']		= "Bannergewichtung (Voreinstellung)";
$GLOBALS['strDefaultCampaignWeight']		= "Kampagnengewichtung (Voreinstellung)";
$GLOBALS['strDefaultBannerWErr']		= "Die Voreinstellung der Bannergewichtung muß eine positive ganze Zahl sein";
$GLOBALS['strDefaultCampaignWErr']		= "Die Voreinstellung der Kampagnengewichtung muß eine positive ganze Zahl sein";

$GLOBALS['strPublisherDefaults']                     = 'Voreinstellung Webseite';
$GLOBALS['strModesOfPayment']                        = 'Zahlungsweise';
$GLOBALS['strCurrencies']                            = 'Währungen';
$GLOBALS['strCategories']                            = 'Kategorien';
$GLOBALS['strHelpFiles']                             = 'Hilfedateien';
$GLOBALS['strHasTaxID']                              = 'Steuer-Nr.';
$GLOBALS['strDefaultApproved']                       = 'zugestimmt Schaltfäche';

// CSV Import Settings
$GLOBALS['strChooseAdvertiser']                      = 'Werbetreibenden auswählen';
$GLOBALS['strChooseCampaign']                        = 'Kampagne auswählen';
$GLOBALS['strChooseCampaignBanner']                  = 'Banner auswählen';
$GLOBALS['strChooseTracker']                         = 'Tracker auswählen';
$GLOBALS['strDefaultConversionStatus']               = 'Voreinstellung des Konversionstatus';
$GLOBALS['strDefaultConversionType']                 = 'Voreinstellung des Konversionstyps';
$GLOBALS['strCSVTemplateSettings']                   = 'CSV Template Einstellung';
$GLOBALS['strIncludeCountryInfo']                    = 'Länderinformation hinzufügen';
$GLOBALS['strIncludeBrowserInfo']                    = 'Browserinformation hinzufügen';
$GLOBALS['strIncludeOSInfo']                         = 'Betriebssysteminformation hinzufügen';
$GLOBALS['strIncludeSampleRow']                      = 'Beispielzeile hinzufügen';
$GLOBALS['strCSVTemplateAdvanced']                   = 'Erweitertes Template';
$GLOBALS['strCSVTemplateIncVariables']               = 'Trackervariablen hinzufügen';

// Invocation Settings
$GLOBALS['strInvocationAndDelivery']                 = 'Einstellungen Bannercode';
$GLOBALS['strAllowedInvocationTypes']                = 'Erlaubete Banneranforderungstypen';
$GLOBALS['strInvocationDefaults']                    = 'Banneranforderung Voreinstellung';
$GLOBALS['strEnable3rdPartyTrackingByDefault']       = 'Erlaube \'3rd Party Clicktracking\' als Voreinstellung';

// Statistics Settings
$GLOBALS['strStatisticsSettings']			= "Statistikeinstellungen";
$GLOBALS['strStatisticsLogging']                     = 'Allgemeine Protokollierungseinstellungen';
$GLOBALS['strCsvImport']                             = 'Hochladen von \'offline\' Konversionen erlauben';
$GLOBALS['strLogAdRequests']                         = 'Protokolliere bei jedem Aufruf eines Werbemittels auf dem Server einen Ad Request';
$GLOBALS['strLogAdImpressions']                      = 'Protokolliere eine Ad Impression, wenn ein Werbemittel beim Nutzer angekommen ist (Truecount)';
$GLOBALS['strLogAdClicks']                           = 'Protoklliere einen Ad Click , wenn ein Nutzer auf ein Werbemittel klickt';
$GLOBALS['strLogTrackerImpressions']                 = 'Protokolliere eine Tracker Impression, wenn ein Nutzer eine Seite mit Tracker-Code vollständig lädt.';
$GLOBALS['strReverseLookup']                         = 'Es wird versucht, den Name des Hosts für den Besucher zu ermitteln, wenn er nicht mitgeliefert wird';
$GLOBALS['strProxyLookup']                           = 'Es wird versucht, die echte IP-Adresse des Besuchers zu ermitteln, wenn er einen Proxy-Server nutzt';
$GLOBALS['strPreventLogging']			= "Protokollieren verhindern";
$GLOBALS['strIgnoreHosts']				= "Keine Statistikdaten speichern für Besucher mit folgenden IP-Adressen oder Hostnamen";
$GLOBALS['strBlockAdViews']				= "Zähle keine Ad Impressions wenn der Betrachter diese Banner/Zonen-Kombination innerhalb dieses Zeitraums schon gesehen hat (in Sekunden)";
$GLOBALS['strBlockAdViewsError']                     = 'Ad Impression Sperre muß eine positive, ganze Zahl sein.';
$GLOBALS['strBlockAdClicks']			= "Zähle keine Ad Klicks wenn der Betrachter auf diese Banner/Zonen-Kombination innerhalb dieses Zeitraums schon geklickt hat (in Sekunden)";
$GLOBALS['strBlockAdClicksError']                    = 'Intervall für Reklick-Sperre muß eine positive ganze Zahl sein';
$GLOBALS['strBlockAdConversions']                    = 'Keine Tracker-Impression protokollieren, wenn der Nutzer die Seite mit dem Tracker-Code im angegeben Zeitintervall gesehen hat (in Sekunden)';
$GLOBALS['strBlockAdConversionsError']               = 'Intervall für Tracking-Sperre muß eine positive ganze Zahl sein';
$GLOBALS['strMaintenaceSettings']                    = 'Allgemine Wartungseinstellungen';
$GLOBALS['strMaintenanceAdServerInstalled']          = 'Berechnung der Statistikdaten durch AdServer-Modul.';
$GLOBALS['strMaintenanceTrackerInstalled']           = 'Berechnung der Trackerdaten durch Tracker-Modul.';
$GLOBALS['strMaintenanceOI']                         = 'Wartungsintervall (in Minuten)';
$GLOBALS['strMaintenanceOIError']                    = 'Dieses Wartungsintervall ist nicht zulässig - bitte konsultieren Sie die Dokumentation';
$GLOBALS['strMaintenanceCompactStats']               = 'Löschen der Roh-Statistik-Daten nach der Weiterverarbeitung';
$GLOBALS['strMaintenanceCompactStatsGrace']          = 'Karenzzeit bevor verarbeitete Roh-Statistik-Daten gelöscht werden (Sekunden)';
$GLOBALS['strPrioritySettings']                      = 'Einstellung der Prioritäten';
$GLOBALS['strPriorityInstantUpdate']                 = 'Sofortige Neuberechnung der Prioritäten nach Änderungen in der Benutzeroberfläche.';
$GLOBALS['strWarnCompactStatsGrace']                 = 'Die Karenzzeit bevor die Statistiken kompaktiert werden muß eine positive ganze Zahl sein';
$GLOBALS['strDefaultImpConWindow']                   = 'Vorgabewert (in Sekunden) für das Zeitfenster von Ad Impressions bei der Neuanlage von Trackern';
$GLOBALS['strDefaultImpConWindowError']              = 'Wenn gesetzt, muß der Vorgabewert für das Zeitfenster der Tracker Ad Impression eine positive ganze Zahl sein';
$GLOBALS['strDefaultCliConWindow']                   = 'Vorgabewert (in Sekunden) für das Zeitfenster von Ad Klicks bei der Neuanlage von Trackern';
$GLOBALS['strDefaultCliConWindowError']              = 'Wenn gesetzt, muß der Vorgabewert für das Zeitfenster der Tracker Ad Klicks eine positive ganze Zahl sein';
$GLOBALS['strEmailWarnings']			= "Warnungen per E-Mail";
$GLOBALS['strAdminEmailHeaders']		= "Alle e-Mails, die von ". MAX_PRODUCT_NAME ." gesendet werden, erhalten die folgenden Header hinzugefügt";
$GLOBALS['strWarnLimit']				= "Warnung per E-Mail bei Unterschreiten der definierten Untergrenze";
$GLOBALS['strWarnLimitErr']				= "Warnlimit muß eine positive Ganzzahl sein";
$GLOBALS['strWarnLimitDays']                         = 'Sende eine Warnung wenn weniger Tage verblieben sind als hier angegeben.';
$GLOBALS['strWarnLimitDaysErr']                      = 'Anzahl Tage für die Warnung muß eine positive Zahl sein.';
$GLOBALS['strAllowEmail']                            = 'Erlaube das Senden von E-Mails';
$GLOBALS['strEmailAddress']                          = 'E-Mail Adresse';
$GLOBALS['strEmailAddressName']                      = 'Firmenname oder persönlicher Name als Unterschrift am Ende aller E-Mails';
$GLOBALS['strWarnAdmin']				= "Warnung per E-Mail an den Administrator, wenn eine Kampagne ausgelaufen ist";
$GLOBALS['strWarnClient']				= "Warnung per E-Mail an den Werbetreibenden, wenn eine Kampagne ausgelaufen ist";
$GLOBALS['strWarnAgency']                            = 'Warnung per E-Mail an die Agentur kurz bevor eine Kampagne ausläuft';
$GLOBALS['strQmailPatch']				= "Änderungen für qmail";

// UI Settings
$GLOBALS['strGuiSettings']			= "Konfiguration Benutzerbereich (Inhaber des AdServers)";
$GLOBALS['strGeneralSettings']				= "Allgemeine Grundeinstellungen des Systems";
$GLOBALS['strAppName']				= "Name oder Bezeichnung der Anwendung";
$GLOBALS['strMyHeader']				= "Kopfzeile im Admin-Bereich";
$GLOBALS['strMyHeaderError']		= "Die Datei für die Kopfzeile wurde an angegebenen Adresse nicht vorgefunden";
$GLOBALS['strMyFooter']				= "Fußzeile im Admin-Bereich";
$GLOBALS['strMyFooterError']		= "Die Datei für die Fußzeile wurde an angegebenen Adresse nicht vorgefunden";
$GLOBALS['strDefaultTrackerStatus']                  = 'Standardstatus Tracker';
$GLOBALS['strDefaultTrackerType']                    = 'Standardtyp Tracker';

$GLOBALS['strMyLogo']                                = 'Name der individuellen Logo-Datei';
$GLOBALS['strMyLogoError']                           = 'Diese Logo-Datei ist im Verzeichnis admin/images nicht vorhanden';
$GLOBALS['strGuiHeaderForegroundColor']              = 'Vordergrundfarbe der Kopfzeile';
$GLOBALS['strGuiHeaderBackgroundColor']              = 'Hintergrundfarbe der Kopfzeile';
$GLOBALS['strGuiActiveTabColor']                     = 'Farbe des aktiven Reiters';
$GLOBALS['strGuiHeaderTextColor']                    = 'Textfarbe in der Kopfzeile';
$GLOBALS['strColorError']                            = 'Bitte geben Sie die Farben im RGB-Format an, z.B. \'0066CC\'';

$GLOBALS['strGzipContentCompression']		= "Komprimieren mit GZIP";
$GLOBALS['strClientInterface']			= "Nutzeroberfläche für Werbetreibende";
$GLOBALS['strReportsInterface']                      = 'Oberfläche Reports';
$GLOBALS['strClientWelcomeEnabled']		= "Begrüßungstext für Werbetreibende verwenden";
$GLOBALS['strClientWelcomeText']		= "Begrüßungstext<br /><i>(HTML Tags sind zugelassen)</i>";

$GLOBALS['strPublisherInterface']                    = 'Schnittstelle der Webseite';
$GLOBALS['strPublisherAgreementEnabled']             = 'Erlaube das Einloggen von Webseiten die die Konditionen (AGB) noch nicht akzeptiert haben.';
$GLOBALS['strPublisherAgreementText']                = 'Konditionen (AGB) für Werbetreibende beim Login (HTML-Tags sind erlaubt)';



/*-------------------------------------------------------*/
/* Unknown (unused?) translations                        */
/*-------------------------------------------------------*/

$GLOBALS['strExperimental']                 = "Experimental";
$GLOBALS['strKeywordRetrieval']             = "Keyword retrieval";
$GLOBALS['strBannerRetrieval']              = "Banner retrieval method";
$GLOBALS['strRetrieveRandom']               = "Random banner retrieval (default)";
$GLOBALS['strRetrieveNormalSeq']            = "Normal sequental banner retrieval";
$GLOBALS['strWeightSeq']                    = "Weight based sequential banner retrieval";
$GLOBALS['strFullSeq']                      = "Full sequential banner retrieval";
$GLOBALS['strUseKeywords']                  = "Use keywords to select banners";
$GLOBALS['strUseConditionalKeys']           = "Allow logical operators when using direct selection";
$GLOBALS['strUseMultipleKeys']              = "Allow multiple keywords when using direct selection";

$GLOBALS['strTableBorderColor']             = "Table Border Color";
$GLOBALS['strTableBackColor']               = "Table Back Color";
$GLOBALS['strTableBackColorAlt']            = "Table Back Color (Alternative)";
$GLOBALS['strMainBackColor']                = "Main Back Color";
$GLOBALS['strOverrideGD']                   = "Override GD Imageformat";
$GLOBALS['strTimeZone']                     = "Time Zone";


// Note: New translations not found in original lang files but found in CSV
$GLOBALS['strBtnRecover'] = "Wiederherstellen »";
$GLOBALS['strBtnStartAgain'] = "Das Upgrade erneut starten »";
$GLOBALS['strFixErrorsBeforeContinuing'] = "Vor dem Fortsetzen bitte alle Fehler beheben.";
$GLOBALS['strWarningRegisterArgcArv'] = "Um das Maintenance-Wartungsscript von der Shell aufzurufen muß die PHP Konfigurationseinstellung 'register_argc_argv' auf 'On' gesetzt werden.";
$GLOBALS['strRecoveryRequiredTitle'] = "Der vorige Upgrade-Versuch hat Fehler hinterlassen.";
$GLOBALS['strRecoveryRequired'] = "Bei der vorigen Upgrade-Prozedur sind Fehler aufgetreten. ".MAX_PRODUCT_NAME." wird versuchen den Zustand vor dem Upgrade wieder herzustellen. Bitte klicken Sie auf Wiederherstellen.";
$GLOBALS['strErrorWritePermissionsWin'] = "Nicht ausreichende Datei- und Verzeichnisrechte erkannt, Sie müssen dies beheben bevor die Installation fortgesetzt werden kann.";
$GLOBALS['strCheckDocumentation'] = "Wenn Sie mehr Hilfe benötigen, besuchen Sie bitte die <a href='". OX_PRODUCT_DOCSURL ."'>".MAX_PRODUCT_NAME." Online-Dokumentation</a>.";
$GLOBALS['strEnableQmailPatch'] = "Kopfzeile auch für qmail lesbar machen";
$GLOBALS['strNovice'] = "Löschvorgänge im Admin-Bereich nur mit Sicherheitsbestätigung";
$GLOBALS['strEmailSettings'] = "Einstellungen E-Mail";
$GLOBALS['strEmailHeader'] = "E-Mail-Header";
$GLOBALS['strEmailLog'] = "E-Mail Protokoll";
$GLOBALS['strAuditTrailSettings'] = "Einstellungen Prüfprotokoll";
$GLOBALS['strEnableAudit'] = "Prüfprotokoll aktivieren";
$GLOBALS['strTypeFTPErrorNoSupport'] = "Ihre PHP-Installation unterstützt kein FTP.";
$GLOBALS['strGeotargetingUseBundledCountryDb'] = "Verwenden Sie die mitgelieferte MaxMind GeoLiteCountry Datenbank";
$GLOBALS['strConfirmationUI'] = "Bestätigung in der Benutzeroberfläche";
$GLOBALS['strBannerStorage'] = "Einstellungen Speicherung der Banner";
$GLOBALS['strMaintenanceSettings'] = "Wartungseinstellungen";
$GLOBALS['strSSLSettings'] = "Einstellungen SSL";
$GLOBALS['strEmailAddressFrom'] = "Absenderadresse (From:) für das Versenden von E-Mails";
$GLOBALS['strDbSocket'] = "Datenbank-Socket";
$GLOBALS['strEmailAddresses'] = "E-Mail \"Von\" Adresse";
$GLOBALS['strEmailFromName'] = "E-Mail \"Von\" Name";
$GLOBALS['strEmailFromAddress'] = "E-Mail \"Von\" E-Mail Adresse";
$GLOBALS['strEmailFromCompany'] = "E-Mail \"Von\" Firma";
$GLOBALS['strIgnoreUserAgents'] = "<b>Keine</b> Statistikdaten loggen von den folgenden Browsern (user-agent), jeweils nur ein Eintrag pro Zeile";
$GLOBALS['strEnforceUserAgents'] = "Die Statistikdaten <b>nur</b> von den folgenden Browsern loggen (user-agent), jeweils nur ein Eintrag pro Zeile";
$GLOBALS['strConversionTracking'] = "Einstellungen zum Konversionen-Tracking";
$GLOBALS['strEnableConversionTracking'] = "Konversionen-Tracking aktivieren";
$GLOBALS['strDbNameHint'] = "Die Datenbank wird angelegt falls sie noch nicht existiert";
$GLOBALS['strProductionSystem'] = "Produktionssystem";
$GLOBALS['strTypeFTPErrorUpload'] = "Hochladen auf den FTP-Server nicht möglich, überprüfen Sie die Zugangsrechte in dem Host-Verzeichnis.";
$GLOBALS['strBannerLogging'] = "Bannerprotokollierung - Einstellungen";
$GLOBALS['strBannerDelivery'] = "Einstellungen der Auslieferung";
$GLOBALS['strEnableDashboardSyncNotice'] = "Bitte aktivieren Sie <a href='account-settings-update.php'>Prüfen, ob neue Programmversionen vorhanden sind</a> wenn Sie das Dashboard nutzen möchten.";
$GLOBALS['strDashboardSettings'] = "Dashboard Einstellungen";
$GLOBALS['strDeliveryCacheStore'] = "Cache-Typ für die Bannerauslieferung";
$GLOBALS['strErrorInCacheStorePlugin'] = "Das Plugin \"%s\" für den Auslieferungsspeicher hat einige Fehler festgestellt:";
$GLOBALS['strDeliveryCacheStorage'] = "Auslieferungscache Speichertyp";
$GLOBALS['strGlobalDefaultBannerUrl'] = "Globale Default-Image-Banner URL";
$GLOBALS['strAdminShareStack'] = "Technische Informationen an das OpenX-Team übermitteln um die Weiterentwicklung und das Testen zu unterstützen.";
$GLOBALS['strAdminShareData'] = "Anonymisierte Informationen über das ausgelieferten Werbemittelvolumen an die Community mitteilen.";
$GLOBALS['strCantConnectToDbDelivery'] = "Keine Datenbankverbindung für die Auslieferung";
?>