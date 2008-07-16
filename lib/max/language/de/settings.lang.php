<?php

/*
+---------------------------------------------------------------------------+
| OpenX v${RELEASE_MAJOR_MINOR}                                                                |
| =======${RELEASE_MAJOR_MINOR_DOUBLE_UNDERLINE}                                                                |
|                                                                           |
| Copyright (c) 2003-2008 OpenX Limited                                     |
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
$GLOBALS['strAdminAccount']                 = "Administrator Konto";
$GLOBALS['strAdministrativeSettings']       = "Administrative Einstellungen";
$GLOBALS['strAdvancedSettings']		= "Ergänzende Einstellungen";
$GLOBALS['strOtherSettings']			= "Andere Einstellungen";
$GLOBALS['strSpecifySyncSettings']          = "Synchronizationseinstellungen";
$GLOBALS['strLicenseInformation']           = "Lizenz Information";
$GLOBALS['strOpenadsIdYour']                = "Ihre OpenX ID";
$GLOBALS['strOpenadsIdSettings']            = "OpenX ID Einstellungen";
$GLOBALS['strWarning']				= "Warnung";
$GLOBALS['strFatalError']			= "Ein schwerer Fehler ist aufgetreten";
$GLOBALS['strUpdateError']			= "Während des Updates ist ein Fehler aufgetreten";
$GLOBALS['strBtnContinue']                  = "Weiter »";
$GLOBALS['strBtnGoBack']                    = "« Zurück";
$GLOBALS['strBtnAgree']                     = "Ich stimme zu »";
$GLOBALS['strBtnDontAgree']                 = "« Ich stimme nicht zu";
$GLOBALS['strBtnRetry']                     = "Wiederholen";
$GLOBALS['strUpdateDatabaseError']	= "Aus unbekannten Gründen war die Aktualisierung der Datenbankstruktur nicht erfolgreich. Es wird empfohlen, zu versuchen, mit <b>Wiederhole Update</b> das Problem zu beheben. Sollte der Fehler - Ihrer Meinung nach - die Funktionalitä von ".MAX_PRODUCT_NAME." nicht berühren, können Sie durch <b>Fehler ignorieren</b> fortfahren. Das Ignorieren des Fehlers wird nicht empfohlen!";
$GLOBALS['strAlreadyInstalled']			= MAX_PRODUCT_NAME." ist bereits auf diesem System installiert. Zur Konfiguration nutzen Sie das <a href='settings-index.php'>Konfigurationsmenü</a>";
$GLOBALS['strCouldNotConnectToDB']		= "Verbindung zur Datenbank war nicht möglich. Bitte vorgenommene Einstellung prüfen.";
$GLOBALS['strCreateTableTestFailed']		= "Der von Ihnen angegebene Nutzer hat nicht die notwendigen Zugriffsrechte, um die Datenbankstruktur anlegen zu können. Wenden Sie sich an den Systemverwalter.";
$GLOBALS['strUpdateTableTestFailed']		= " Der von Ihnen angegebene Nutzer hat nicht die notwendigen Zugriffsrechte, um die Datenbank zu aktualisieren. Wenden Sie sich an den Systemverwalter.";
$GLOBALS['strTablePrefixInvalid']		= "Ungültiges Vorzeichen (Präfix) im Tabellennamen";
$GLOBALS['strTableInUse']			= "Die genannte Datenbank wird bereits von ".MAX_PRODUCT_NAME.", genutzt. Verwenden Sie einen anderes Präfix oder lesen Sie im Handbuch die Hinweise für ein Upgrade.";
$GLOBALS['strNoVersionInfo']                = "Konnte Datenbankversion nicht rausfinden.";
$GLOBALS['strInvalidVersionInfo']           = "Konnte Datenbankversion nicht rausfinden.";
$GLOBALS['strInvalidMySqlVersion']          = MAX_PRODUCT_NAME." benötigt MySQL 4.0 oder höher, um korrekt zu arbeiten. Bitte wählen Sie einen anderen Datenbankserver.";
$GLOBALS['strTableWrongType']		= "Der gewählte Tabellentype wird bei der Installation von ".$phpAds_dbmsname." nicht unterstützt";
$GLOBALS['strMayNotFunction']			= "Folgende Probleme sind zu beheben, um fortzufahren";
$GLOBALS['strFixProblemsBefore']		= "Folgende Teile müssen korrigiert werden, bevor der Installationsprozeß von ".MAX_PRODUCT_NAME." fortgesetzt werden kann. Informationen über Fehlermeldungen finden sich im Handbuch.";
$GLOBALS['strFixProblemsAfter']			= "Sollten Sie die oben aufgeführten Fehler nicht selbst heben können, nehmen Sie Kontakt mit der Systemadministration Ihres Servers auf. Diese wird Ihnen weiterhelfen können.";
$GLOBALS['strIgnoreWarnings']			= "Ignoriere Warnungen";
$GLOBALS['strWarningDBavailable']		= "Die eingesetzte PHP-Version unterstützt nicht die Verbindung zum ".$phpAds_dbmsname." Datenbankserver. Die PHP- ".$phpAds_dbmsname."-Erweiterung wird benötigt.";
$GLOBALS['strWarningPHPversion']		= MAX_PRODUCT_NAME." benötigt PHP 4.0 oder höher, um korrekt genutzt werden zu können. Sie nutzten {php_version}.";
$GLOBALS['strWarningRegisterGlobals']		= "Die PHP-Konfigurationsvaribable <i>register_globals</i> muß gesetzt werden.";
$GLOBALS['strWarningMagicQuotesGPC']		= " Die PHP-Konfigurationsvaribable <i> magic_quotes_gpc</i> muß gesetzt werden.";
$GLOBALS['strWarningMagicQuotesRuntime']	= " Die PHP-Konfigurationsvaribable <i> magic_quotes_runtime</i> muß deaktiviert werden.";
$GLOBALS['strWarningFileUploads']		= " Die PHP-Konfigurationsvaribable <i> file_uploads</i> muß gesetzt werden.";
$GLOBALS['strWarningTrackVars']			= " Die PHP-Konfigurationsvaribable <i> track_vars</i> muß gesetzt werden.";
$GLOBALS['strWarningPREG']				= "Die verwendete PHP-Version unterstützt nicht PERL-kompatible Ausdrücke. Um fortfahren zu können wird die PHP-Erweiterung <i>PREG</i> benötigt.";
$GLOBALS['strConfigLockedDetected']		= MAX_PRODUCT_NAME." hat erkannt, daß die Datei <b>config.inc.php</b> schreibgeschützt ist.<br /> Die Installation kann aber ohne Schreibberechtigung nicht fortgesetzt werden. <br />Weitere Informationen finden sich im Handbuch.";

$GLOBALS['strCantUpdateDB']  			= "Ein Update der Datenbank ist derzeit nicht möglich. Wenn Sie die Installation fortsetzen, werden alle existierende Banner, Statistiken und Werbetreibenden gelöscht. ";
$GLOBALS['strIgnoreErrors']			= "Fehler ignorieren";
$GLOBALS['strRetryUpdate']			= "Wiederhole Update";
$GLOBALS['strTableNames']			= "Tabellenname";
$GLOBALS['strTablesPrefix']			= "Präfix zum Tabellenname";
$GLOBALS['strTablesType']			= "Tabellentype";
$GLOBALS['strInstallWelcome']			= "Willkommen bei ".MAX_PRODUCT_NAME;
$GLOBALS['strInstallMessage']			= "Bevor ".MAX_PRODUCT_NAME." genutzt werden kann, müssen die Einstellungen konfiguriert  <br /> sowie die Datenbank geschaffen (create) werden. Drücken Sie <b>Weiter</b> , um fortzufahren.";

$GLOBALS['strInstallIntro']                 = "Willkommen zu <a href='http://".MAX_PRODUCT_URL."' target='_blank'><strong>".MAX_PRODUCT_NAME."</strong></a>! Bald sind Sie auch ein Teil der größten Adserver Community.
<p>Wir werden unser bestes tun, um die Installation bzw. das Update so einfach wie möglich zu halten. Bitte halten Sie sich an die Anweisungen auf dem Bildschirm, und sollten Sie weiterführende Hilfe benötigen wenden Sie sich bitte an <a href='http://".OA_DOCUMENTATION_BASE_URL."' target='_blank'><strong>die Dokumentation</strong></a>.</p>
<p>Sollten Sie auch nach Durchsicht der Dokumentation noch weitere Fragen haben, schauen Sie zum <a href='http://".MAX_PRODUCT_URL."/support/overview.html' target='_blank'><strong>Support</strong></a> Bereich unserer Website und dem " . MAX_PRODUCT_NAME . " <a href='http://".MAX_PRODUCT_FORUMURL."' target='_blank'><strong>Community Forum</strong></a>.</p>
<p>Vielen Dank, dass Sie sich für " . MAX_PRODUCT_NAME . " entschieden haben.</p>";
$GLOBALS['strTermsTitle']               = "Lizenz Information";
$GLOBALS['strTermsIntro']               = MAX_PRODUCT_NAME . " ist ein freier, open source Adserver, vertrieben unter der GPL Lizenz. Bitte lesen Sie diese und stimmen Sie dieser zu, um die Installation fort zu fahren.";
$GLOBALS['strPolicyTitle']               = "Datenschutzvereinbarung";
$GLOBALS['strPolicyIntro']               = "Bitte lesen Sie unsere Datenschutzvereinbarung genau durch, bevor Sie mit der Installation weiter machen.";
$GLOBALS['strDbSetupTitle']               = "Datenbank Setup";
$GLOBALS['strDbSetupIntro']               = MAX_PRODUCT_NAME . " verwendet den MySQL oder PostgreSQL Datenbankserver, um Daten zu speichern. Bitte tragen Sie die Daten Ihres Datenbankservers nachfolgend ein.  Wenn Sie sich nicht sicher sind, welche Daten hier einzutragen sind, fragen Sie bitte Ihren Serveradministrator.";
$GLOBALS['strDbUpgradeIntro']             = "Nachfolgend können Sie die Daten Ihres Datenbankservers einsehen und korrigieren, falls diese falsch sind. Wenn Sie jetzt auf Weiter klicken, wird " . MAX_PRODUCT_NAME . " mit der Installation bzw. dem Upgrade der Datenbankdaten fortfahren. Bitte vergewissern Sie sich, dass Sie ein aktuelles und gültiges Backup Ihrer Daten erstellt haben.";

$GLOBALS['strOaUpToDate']               = "Ihre " . MAX_PRODUCT_NAME . " Datenbank und Dateien verwenden bereits die neueste Version von ".MAX_PRODUCT_NAME." und muss daher zum jetztigen Zeitpunkt nicht aktualisiert werden. Bitte klicken Sie auf Weiter, um zur Administrationsoberfläche fortzufahren.";
$GLOBALS['strOaUpToDateCantRemove']     = "Warnung: Die Datei UPGRADE im var Unterverzeichnis ist weiterhin vorhanden. Leider war es uns aufgrund mangelnden Zugriffsrechten nicht möglich die Datei zu löschen. Bitte löschen Sie diese Datei manuell.";
$GLOBALS['strRemoveUpgradeFile']               = "Sie müssen die Datei UPGRADE im var Unterverzeichnis manuell löschen.";


$GLOBALS['strInstallSuccess']			=
"<strog>Herzlichen Glückwunsch! Die Installation von " . MAX_PRODUCT_NAME . " " . OA_VERSION ." war erfolgreich.</strong><br />
<br />Um das beste aus ". MAX_PRODUCT_NAME ." herauszuholen, sollten Sie noch folgende zwei Schritte durchführen.

<strong>Wartungsmodul</strong><br />
Damit ".MAX_PRODUCT_NAME." korrekt arbeitet, muß sichergestellt sein, daß das Wartungsmodul (maintenance.php) stündlich aktiviert wird.
Es ist zwar nicht zwingend notwendig das Wartungsmodul über das Cron zu starten, da solange Banner ausgeliefert werden, das Wartungsmodul automatisch von
der Auslieferungsskripten gestartet wird. Der Zuverlässigkeit wegen ist es jedoch empfehlenswert das Wartungsmodul über das Cron stündlich zu starten.
Nähere Informationen finden sich im <a href='http://".OA_DOCUMENTATION_BASE_URL."' target='_blank'>Handbuch</a>. <br />
<br />
<strong>Sicherheit</strong><br />
Die " . MAX_PRODUCT_NAME . " Installationsroutine muss auf die Konfigurationsdatei schreibend zugreifen können. Nachdem die Installation und die nachfolgende Konfiguration beendet ist,
sollte der Schreibschutz auf der Konfigurationsdatei wieder entfernt werden.<br />
Nähere Informationen finden sich im <a href='http://".OA_DOCUMENTATION_BASE_URL."' target='_blank'>Handbuch</a>.
<br /><br />
Klicken Sie nun auf Weiter, um mit der Konfiguration fortzufahren.";

$GLOBALS['strInstallNotSuccessful']		= "<b>Die Installation von ".MAX_PRODUCT_NAME." war nicht erfolgreich</b><br /><br />
Teile des Installationsprozesses wurden nicht beendet. Das Problem ist möglicherweise nur temporär. In diesem Fall drücken Sie <b> Weiter</b> und beginnen Sie den Installationsprozeß von Neuem. Näheres zu Fehlermeldungen und -behebung findet sich im Handbuch.";
$GLOBALS['strSystemCheck']                  = "System �berpr�fung";
$GLOBALS['strSystemCheckIntro']             = MAX_PRODUCT_NAME . " setzt einige Dinge voraus, welche nun geprüft werden. Sie erhalten eine Meldung, sollte etwas nicht stimmen.";
$GLOBALS['strDbSuccessIntro']               = "Die " . MAX_PRODUCT_NAME . " Datenbank wurde erstellt. Bitte drücken Sie nun auf Weiter, um die " . MAX_PRODUCT_NAME . " Administrations- und Auslieferungseinstellungen zu tätigen.";
$GLOBALS['strDbSuccessIntroUpgrade']        = "Die " . MAX_PRODUCT_NAME . " Datenbank wurde aktualisiert. Bitte drücken Sie nun auf Weiter, um die " . MAX_PRODUCT_NAME . " Administrations- und Auslieferungseinstellungen zu tätigen.";
$GLOBALS['strErrorOccured']			= "Der folgende Fehler ist aufgetreten:";
$GLOBALS['strErrorInstallDatabase']		= "Die Datenbankstruktur konnte nicht angelegt werden.";
$GLOBALS['strErrorInstallPrefs']            = "Die Benutzereinstellungen für den Administrator konnten nicht in die Datenbank geschrieben werden.";
$GLOBALS['strErrorInstallVersion']          = "Die " . MAX_PRODUCT_NAME . " Versionsnummer konnte nicht in die Datenbank geschrieben werden.";
$GLOBALS['strErrorUpgrade'] = 'Das Upgrade der Datenbank der bestehenden Installation ist fehlgeschlagen.';
$GLOBALS['strErrorInstallDbConnect']		= "Eine Verbindung zur Datenbank konnte nicht geöffnet werden.";
$GLOBALS['strErrorWritePermissions']        = "Um diese(n) Fehler auf Ihrem Linux Server zu beheben, müssen Sie folgende(n) Befehl(e) eingeben:";
$GLOBALS['strErrorFixPermissionsCommand']   = "<i>chmod a+w %s</i>";
$GLOBALS['strErrorFixPermissionsRCommand']  = "<i>chmod -R a+w %s</i>";
$GLOBALS['strCheckDocumentation']           = "Für weitere Hilfe sehen Sie bitte in das Handbuch unter http://".OA_DOCUMENTATION_BASE_URL;

$GLOBALS['strAdminUrlPrefix']               = "URL der Admin-Oberfläche";
$GLOBALS['strDeliveryUrlPrefix']            = "URL des Ad-Servers";
$GLOBALS['strDeliveryUrlPrefixSSL']         = "URL des Ad-Servers (SSL)";
$GLOBALS['strImagesUrlPrefix']              = "URL des Verzeichnisses in dem die Grafiken gespeichert werden";
$GLOBALS['strImagesUrlPrefixSSL']           = "URL des Verzeichnisses in dem die Grafiken gespeichert werden (SSL)";

$GLOBALS['strInvalidUserPwd']			= "Fehlerhafter Benutzername oder Passwort";

$GLOBALS['strUpgrade']				= "Programmaktualisierung (Upgrade)";
$GLOBALS['strSystemUpToDate']		= "Das System ist bereits aktuell. Eine Aktualisierung (Upgrade) ist nicht notwendig. <br />
Drücken Sie <b>Weiter</b>, um zur Startseite zu gelangen.";
$GLOBALS['strSystemNeedsUpgrade']		= "Die Datenbankstruktur und die Konfigurationsdateien sollten aktualisiert werden. Drücken Sie <b>Weiter</b> für den Start des Aktualisierungslaufes.
 <br /><br />Abhängig von der derzeitig genutzten Version und der Anzahl der vorhandenen Statistiken kann dieser Prozeß Ihre Datenbank stark belasten. Das Upgrade kann einige Minuten dauern.";
$GLOBALS['strSystemUpgradeBusy']		= "Aktualisierung des Systems läuft. Bitte warten ...";
$GLOBALS['strSystemRebuildingCache']		= "Cache wird neu erstellt. Bitte warten ...";
$GLOBALS['strServiceUnavalable']		= "Dieser Service ist zur Zeit nicht erreichbar. System wird aktualisiert...";


/*-------------------------------------------------------*/
/* Configuration translations                            */
/*-------------------------------------------------------*/

// Global
$GLOBALS['strChooseSection']			= "Bereichsauswahl";
$GLOBALS['strEditConfigNotPossible']   		= "Änderungen der Systemeinstellung nicht möglich. Für die Konfigurationsdatei  <i>config.inc.php</i> besteht Schreibschutz. ".
										  "Für Änderungen muß der Schreibschutz aufgehoben werden.";
$GLOBALS['strEditConfigPossible']		= "Unbefugte Systemänderungen sind möglich. Die Zugriffsrechte der Konfigurationsdatei <i>config.inc.php</i> sind auf Schreibbrechtigung gesetzt. ".
										  "Zur Sicherung des Systems sollte der Schreibschutz gesetzt werden. Nähere Informationen im Handbuch.";
$GLOBALS['strUnableToWriteConfig']                   = 'Die Änderungen konnten nicht in die Konfigurationsdatei übernommen werden';
$GLOBALS['strUnableToWritePrefs']                    = 'Die Voreinstellungen konnten nicht in die Datenbank geschrieben werden.';
$GLOBALS['strImageDirLockedDetected']	             = "Das angegebene Verzeichnis für die Bilder hat keine Webserver Schreibrechte gesetzt. Sie können nicht fortfahren, bis Sie die Zugriffsrechte ändern oder das Verzeichnis erstellen.";

// Configuration Settings
$GLOBALS['strConfigurationSetup']                    = 'Konfiguration';
$GLOBALS['strConfigurationSettings']                    = 'Konfigurationseinstellungen';

// Administrator settings
$GLOBALS['strAdministratorSettings']		= "Einstellungen für Administrator";
$GLOBALS['strAdministratorAccount']                  = 'Das Administrator Konto';
$GLOBALS['strLoginCredentials']			= "Login";
$GLOBALS['strAdminUsername']			= "Benutzername (Admin)";
$GLOBALS['strAdminPassword']                         = 'Passwort (Admin)';
$GLOBALS['strInvalidUsername']			= "Benutzername fehlerhaft";
$GLOBALS['strBasicInformation']			= "Basisinformation";
$GLOBALS['strAdminFullName']			= "Vorname Name";
$GLOBALS['strAdminEmail']			= "E-Mail";
$GLOBALS['strAdministratorEmail']                            = 'E-Mail (Admin)';
$GLOBALS['strCompanyName']			= "Firma";
$GLOBALS['strAdminCheckUpdates']		= "Prüfen, ob neue Programmversionen vorhanden sind";
$GLOBALS['strAdminCheckEveryLogin']		= "Bei jedem Login";
$GLOBALS['strAdminCheckDaily']		= "Täglich";
$GLOBALS['strAdminCheckWeekly']		= "Wöchentlich";
$GLOBALS['strAdminCheckMonthly']		= "Monatlich";
$GLOBALS['strAdminCheckNever']		= "Nie";
$GLOBALS['strAdminNovice']			= "Löschvorgänge im Admin-Bereich nur mit Sicherheitsbestätigung";
$GLOBALS['strUserlogEmail']			= "Alle ausgehenden E-Mails protokollieren ";
$GLOBALS['strEnableDashboard']                       = "Dashboard aktivieren";
$GLOBALS['strTimezoneInformation']                   = "Zeitzone Einstellungen (Ändern der Zeitzone wirkt sich auf die Statistiken aus)";
$GLOBALS['strTimezone']                              = "Zeitzone";
$GLOBALS['strTimezoneEstimated']                     = "Ihre wahrscheinliche Zeitzone";
$GLOBALS['strTimezoneGuessedValue']                  = "Die Zeitzoneneinstellungen in PHP sind nicht korrekt gesetzt.";
$GLOBALS['strTimezoneSeeDocs']                       = "Bitte konsultieren Sie das Handbuch unter %DOCS% welche Variable in PHP gesetzt werden muss.";
$GLOBALS['strTimezoneDocumentation']                 = "Handbuch";
$GLOBALS['strLoginSettingsTitle']                    = "Administrator Login";
$GLOBALS['strLoginSettingsIntro']                    = "Um mit dem Upgrade Prozess fortzufahren, geben Sie Ihre " . MAX_PRODUCT_NAME . " Administrator Zugangsdaten ein. Sie müssen sich als Administrator einloggen, um mit dem Upgrade Prozess fortzufahren.";
$GLOBALS['strAdminSettingsTitle']                    = "Ihr Administrator Konto";
$GLOBALS['strAdminSettingsIntro']                    = "Das Administator Konto wird verwendet, um sich in die  " . MAX_PRODUCT_NAME . " Ad-Server Overfläche einzuloggen, die Banner und Kampagnen zu verwalten und Statistiken einzusehen. Bitte tragen Sie nachfolgend die Daten für den Administrator ein.";
$GLOBALS['strConfigSettingsIntro']                    = "Bitte überprüfen Sie die nachfolgenden Konfigurationseinstellungen. Es ist sehr wichtig, dass Sie sehr sorgfältig diese Einstellungen kontrollieren, da sich diese auf die Betrieb des " . MAX_PRODUCT_NAME ." Ad-Servers sehr start auswirken.";
$GLOBALS['strEnableAutoMaintenance']	             = "Das Wartungsmodul wird automatisch während der Bannerauslieferung gestartet, sofern das Wartungsmodul nicht über Cron (oder ähnliches) eingebunden ist";

// OpenX ID Settings
$GLOBALS['strOpenadsUsername']                       = MAX_PRODUCT_NAME . " Benutzername";
$GLOBALS['strOpenadsPassword']                       = MAX_PRODUCT_NAME . " Passwort";
$GLOBALS['strOpenadsEmail']                          = MAX_PRODUCT_NAME . " E-Mail";

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
$GLOBALS['strTypeHtmlPhp']			= "Ausführbarer PHP-Code ist in HTML-Banner zugelassen ";


// Database
$GLOBALS['strDatabaseSettings']			= "Datenbankeinstellungen";
$GLOBALS['strDatabaseServer']			= "Datenbank Server";
$GLOBALS['strDbLocal']				= "Verbindung zum lokalen Server mittels Sockets"; // Pg only
$GLOBALS['strDbType']                                = 'Datenbank Typ';
$GLOBALS['strDbHost']				= "Datenbank Hostname";
$GLOBALS['strDbPort']				= "Datenbank Portnummer";
$GLOBALS['strDbUser']				= "Datenbank Benutzername";
$GLOBALS['strDbPassword']			= "Datenbank Passwort";
$GLOBALS['strDbName']			= "Datenbank Name";
$GLOBALS['strDatabaseOptimalisations']		= " Datenbank Optimierung";
$GLOBALS['strPersistentConnections']		= "Dauerhafte (persistente) Verbindung zur Datenbank";
$GLOBALS['strCantConnectToDb']		= "Verbindung zur Datenbank nicht möglich";
$GLOBALS['strDemoDataInstall']                       = 'Installation von Demonstrationsdaten';
$GLOBALS['strDemoDataIntro']                         = 'Standardwerte können in die ' . MAX_PRODUCT_NAME . ' Datenbank geladen werden, um Ihnen die
Start mit dem Ad-Server zu erleichtern. Die meist verwendeten Bannertypen als auch einige Kampagnen werden vorkonfiguriert.

Dies ist für Neuinstallationen sehr empfehlenswert.';

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
$GLOBALS['strPEAR_LOG_INFO']                         = 'PEAR_LOG_INFO - Basisinformationen';
$GLOBALS['strPEAR_LOG_NOTICE']                       = 'PEAR_LOG_NOTICE';
$GLOBALS['strPEAR_LOG_WARNING']                      = 'PEAR_LOG_WARNING';
$GLOBALS['strPEAR_LOG_ERR']                          = 'PEAR_LOG_ERR';
$GLOBALS['strPEAR_LOG_CRIT']                         = 'PEAR_LOG_CRIT';
$GLOBALS['strPEAR_LOG_ALERT']                        = 'PEAR_LOG_ALERT';
$GLOBALS['strPEAR_LOG_EMERG']                        = 'PEAR_LOG_EMERG - Minimalinformationen';
$GLOBALS['strDebugIdent']                            = 'Debug Identifikations-String';
$GLOBALS['strDebugUsername']                         = 'mCal, SQL-Server Benutzername';
$GLOBALS['strDebugPassword']                         = 'mCal, SQL-Server Paßwort';

// Delivery Settings
$GLOBALS['strDeliverySettings']			= "Einstellungen für Bannerauslieferung";
$GLOBALS['strWebPath']                               = 'Übersicht ' . MAX_PRODUCT_NAME . ' Server-Pfade';
$GLOBALS['strWebPathSimple']                         = 'Server-Pfad';
$GLOBALS['strDeliveryPath']                          = 'Pfad für die Auslieferung';
$GLOBALS['strImagePath']                             = 'Pfad zur Speicherung von Bildern';
$GLOBALS['strDeliverySslPath']                       = 'Pfad für die Auslieferung (SSL)';
$GLOBALS['strImageSslPath']                          = 'Pfad zur Speicherung von Bildern (SSL)';
$GLOBALS['strImageStore']                            = 'Bilder Verzeichnis';
$GLOBALS['strTypeWebSettings']                       = 'Allgemeine Einstellungen zur lokalen Speicherung von Werbemitteln';
$GLOBALS['strTypeWebMode']                           = 'Speicherart';
$GLOBALS['strTypeWebModeLocal']                      = 'Lokales Verzeichnis';
$GLOBALS['strTypeDirError']                          = 'Der Web-Server hat keine Schreibrechte auf das lokale Verzeichnis';
$GLOBALS['strTypeWebModeFtp']                        = 'Externer FTP-Server';
$GLOBALS['strTypeWebDir']                            = 'Lokales Verzeichnis';
$GLOBALS['strTypeFTPHost']			= "FTP-Host";
$GLOBALS['strTypeFTPDirectory']		= "FTP-Verzeichnis";
$GLOBALS['strTypeFTPUsername']		= "FTP-Benutzername";
$GLOBALS['strTypeFTPPassword']		= "FTP-Passwort";
$GLOBALS['strTypeFTPPassive']                        = 'Passives FTP verwenden';
$GLOBALS['strTypeFTPErrorDir']		= "FTP-Verzeichnis existiert nicht";
$GLOBALS['strTypeFTPErrorConnect']		= "Verbindung zum FTP Server nicht möglich. Benutzername oder Passwort waren fehlerhaft";
$GLOBALS['strTypeFTPErrorHost']			= "Hostname für FTP-Server ist fehlerhaft";
$GLOBALS['strDeliveryFilenames']                     = 'Namen der Dateien, die das System zur Werbemittelauslieferung nutzt';
$GLOBALS['strDeliveryFilenamesAdClick']              = 'Ad Click';
$GLOBALS['strDeliveryFilenamesAdConversionVars']     = 'Ad Conversion Variables';
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
$GLOBALS['strDeliveryFilenamesFlash']                = 'Flash Include (Kann auch eine komplette URL sein)';
$GLOBALS['strDeliveryCaching']                       = 'Allgemeine Einstellungen des Auslieferungs-Caches';
$GLOBALS['strDeliveryCacheEnable']                   = 'Auslieferungs-Cache aktivieren';
$GLOBALS['strDeliveryCacheType']                     = 'Typ des Auslieferungs-Caches';
$GLOBALS['strCacheFiles']                            = 'Datei';
$GLOBALS['strCacheDatabase']                         = 'Datenbank';
$GLOBALS['strDeliveryCacheLimit']                    = 'Zeit zwischen Aktualisierungen des Auslieferungs-Caches (Sekunden)';
$GLOBALS['strOrigin']                                = 'Nutze remote origin server';
$GLOBALS['strOriginType']                            = 'Origin server Typ';
$GLOBALS['strOriginHost']                            = 'Hostname des origin server';
$GLOBALS['strOriginPort']                            = 'Port-Nummer der origin Datenbank';
$GLOBALS['strOriginScript']                          = 'Script-Datei für origin Datenbank';
$GLOBALS['strOriginTypeXMLRPC']                      = 'XMLRPC';
$GLOBALS['strOriginTimeout']                         = 'Origin timeout (Sekunden)';
$GLOBALS['strOriginProtocol']                        = 'Origin-Server Protokoll';
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
$GLOBALS['generalSettings']                          = 'Allgemeine Grundeinstellungen des Sytems';
$GLOBALS['uiEnabled']                                = 'Nutzer-Interface aktivieren';
$GLOBALS['defaultLanguage']                          = 'Standard-Sprache<br />(Jeder Nutzer kann seine eigene Systemsprache wählen)';
$GLOBALS['requireSSL']                               = 'Erzwinge SSL-Zugang zum Nutzer-Interface';
$GLOBALS['sslPort']                                  = 'Vom Web-Server genutzer SSL-Port';

// Geotargeting
$GLOBALS['strGeotargetingSettings']                  = 'Einstellungen Geotargeting';
$GLOBALS['strGeotargeting']			= "Allgemeine Einstellungen Geotargeting";
$GLOBALS['strGeotargetingType']                      = 'Geotargeting Modultyp';
$GLOBALS['strGeotargetingGeoipCountryLocation']      = 'Speicherort der MaxMind GeoIP Länderdatenbank';
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
$GLOBALS['strShowBannerInfo']			= "Anzeigen zusätzlicher Werbemittelinformationen auf der Seite <i>übersicht Werbemittel</i> ";
$GLOBALS['strShowCampaignPreview']		= "Vorschau aller Werbemittel auf der Seite  <i>Übersicht Werbemittel</i>";
$GLOBALS['strShowBannerHTML']			= "Anzeige des Banners anstelle des HTML-Codes bei Vorschau von HTML-Bannern";
$GLOBALS['strShowBannerPreview']		= "Werbemittelvorschau oben auf allen Seiten mit Bezug zum Werbemittel";
$GLOBALS['strHideInactive']			= "Verbergen inaktiver Elemente auf den Übersichtsseiten";
$GLOBALS['strGUIShowMatchingBanners']		= "Anzeige des zugehörenden Werbemittels auf der Seite <i>Verknüpfte Werbemittel</i>";
$GLOBALS['strGUIShowParentCampaigns']		= "Anzeige der zugehörenden Kampagne auf der Seite <i>Veknüpfte Werbemittel</i>";
$GLOBALS['strGUIAnonymousCampaignsByDefault']        = 'Default Campaigns to Anonymous';
$GLOBALS['strStatisticsDefaults'] 		= "Statistiken";
$GLOBALS['strBeginOfWeek']			= "Wochenbeginn";
$GLOBALS['strPercentageDecimals']		= "Dezimalstellen bei Prozentangaben";
$GLOBALS['strWeightDefaults']			= "Gewichtung (Voreinstellung)";
$GLOBALS['strDefaultBannerWeight']		= "Bannergewichtung (Voreinstellung)";
$GLOBALS['strDefaultCampaignWeight']		= "Kampagnengewichtung (Voreinstellung)";
$GLOBALS['strDefaultBannerWErr']		= "Voreinstellung für Bannergewichtung muß eine positive Ganzzahl sein";
$GLOBALS['strDefaultCampaignWErr']		= " Voreinstellung für Kampagne muß eine positive Ganzzahl sein";

$GLOBALS['strPublisherDefaults']                     = 'Defaulteinstellungen für Werbeträger';
$GLOBALS['strModesOfPayment']                        = 'Zahlungsarten';
$GLOBALS['strCurrencies']                            = 'Währungen';
$GLOBALS['strCategories']                            = 'Kategorien';
$GLOBALS['strHelpFiles']                             = 'Hilfsdateien';
$GLOBALS['strHasTaxID']                              = 'USt.-ID';
$GLOBALS['strDefaultApproved']                       = 'Ich stimme zu - Checkbox';

// CSV Import Settings
$GLOBALS['strChooseAdvertiser']                      = 'Werbetreibenden auswählen';
$GLOBALS['strChooseCampaign']                        = 'Kampagne ausählen';
$GLOBALS['strChooseCampaignBanner']                  = 'Banner ausählen';
$GLOBALS['strChooseTracker']                         = 'Tracker ausählen';
$GLOBALS['strDefaultConversionStatus']               = 'Standard Status von Konversionen';
$GLOBALS['strDefaultConversionType']                 = 'Standard Typ von Konversionen';
$GLOBALS['strCSVTemplateSettings']                   = 'CSV-Vorlagen Einstellungen';
$GLOBALS['strIncludeCountryInfo']                    = 'Länderinformationen einschließen';
$GLOBALS['strIncludeBrowserInfo']                    = 'Browserinformationen einschließen';
$GLOBALS['strIncludeOSInfo']                         = 'Betriebsysteminformationen einschließen';
$GLOBALS['strIncludeSampleRow']                      = 'Beispielinformation einschließen';
$GLOBALS['strCSVTemplateAdvanced']                   = 'Erweiterte Vorlage';
$GLOBALS['strCSVTemplateIncVariables']               = 'Tracker Variablen einschließen';

// Invocation Settings
$GLOBALS['strInvocationAndDelivery']                 = 'Einstellungen Bannercode';
$GLOBALS['strAllowedInvocationTypes']                = 'Erlaubte Einbindungsarten';
$GLOBALS['strInvocationDefaults']                    = 'Einbindungsvorgabe';
$GLOBALS['strEnable3rdPartyTrackingByDefault']       = 'Aktiviere standardmäßig das 3rd Party Klicktracking';

// Statistics Settings
$GLOBALS['strStatisticsSettings']			= "Statistikeinstellungen";
$GLOBALS['strStatisticsLogging']                     = 'Allgemeine Protokollierungseinstellungen';
$GLOBALS['strCsvImport']                             = 'Upload von offline Konversionen erlauben';
$GLOBALS['strLogAdRequests']                         = 'Protokolliere bei jedem Aufruf eines Werbemittels auf dem Server einen Ad Request';
$GLOBALS['strLogAdImpressions']                      = 'Protokolliere eine Ad Impression, wenn ein Werbemittel beim Nutzer angekommen ist (Truecount)';
$GLOBALS['strLogAdClicks']                           = 'Protoklliere einen Ad Click , wenn ein Nutzer auf ein Werbemittel klickt';
$GLOBALS['strLogTrackerImpressions']                 = 'Protokolliere eine Tracker Impression, wenn ein Nutzer eine Seite mit Tracker-Code vollständig lädt.';
$GLOBALS['strReverseLookup']                         = 'Führe fallls notwendig einen Reverse lookup der IP Adresse durch, um Hostname zu erhalten (kann den Ad-Server stark verzögern!)';
$GLOBALS['strProxyLookup']                           = 'Versuche die echte IP Adresse eines Proxy Besuchers zu ermitteln.';
$GLOBALS['strSniff']                                 = 'Ermittele das Betriebsystem und den Browser des Besuchers mit phpSniff.';
$GLOBALS['strPreventLogging']			= "Protokollieren verhindern";
$GLOBALS['strIgnoreHosts']				= "AdViews und AdClicks für Besucher mit folgenden IP-Adressen oder Hostnamen bleiben in den Statistiken unberücksichtigt";
$GLOBALS['strBlockAdViews']				= "Reloadsperre (Zeitraum in Sek.)";
$GLOBALS['strBlockAdViewsError']                     = 'Intervall für Reload-Sperre muß eine positive ganze Zahl sein';
$GLOBALS['strBlockAdClicks']			= " Reclicksperre (Zeitraum in Sek.) ";
$GLOBALS['strBlockAdClicksError']                    = 'Intervall für Reklick-Sperre muß eine positive ganze Zahl sein';
$GLOBALS['strBlockAdConversions']                    = 'Keine Tracker-Impression protokollieren, wenn der Nutzer die Seite mit dem Tracker-Code im angegeben Zeitintervall gesehen hat (in Sekunden)';
$GLOBALS['strBlockAdConversionsError']               = 'Intervall für Tracking-Sperre muß eine positive ganze Zahl sein';
$GLOBALS['strMaintenaceSettings']                    = 'Allgemine Wartungseinstellungen';
$GLOBALS['strMaintenanceAdServerInstalled']          = 'Verarbeite Statistiken der Ad-Server-Module';
$GLOBALS['strMaintenanceTrackerInstalled']           = 'Verarbeite Statistiken für Tracker-Module';
$GLOBALS['strMaintenanceOI']                         = 'Wartungsintervall (in Minuten)';
$GLOBALS['strMaintenanceOIError']                    = 'Dieses Wartungsintervall ist nicht zulässig - bitte konsultieren Sie die Dokumentation';
$GLOBALS['strMaintenanceCompactStats']               = 'Löschen der Original-Statistiken nach der Verarbeitung?';
$GLOBALS['strMaintenanceCompactStatsGrace']          = 'Karenzzeit bevor verarbeitete Statistiken gelöscht werden (Sekunden)';
$GLOBALS['strPrioritySettings']                      = 'Allgemeine Dringlichkeitseinstellungen';
$GLOBALS['strPriorityInstantUpdate']                 = 'Aktualisiere Werbemittel die älter sind als...';
$GLOBALS['strWarnCompactStatsGrace']                 = 'Die Karenzzeit bevor die Statistiken kompaktiert werden muß eine positive ganze Zahl sein';
$GLOBALS['strDefaultImpConWindow']                   = 'Standard Ad Impression Connection Window (Sekunden)';
$GLOBALS['strDefaultImpConWindowError']              = 'Wenn gesetzt, muß der Standard Ad Impression Connection Window eine positive ganze Zahl sein';
$GLOBALS['strDefaultCliConWindow']                   = 'Standard Ad Click Connection Window (Sekunden)';
$GLOBALS['strDefaultCliConWindowError']              = 'Wenn gesetzt, muß der Standard Ad Click Connection Window eine positive ganze Zahl sein';
$GLOBALS['strEmailWarnings']			= "Warnungen per E-Mail";
$GLOBALS['strAdminEmailHeaders']		= "Kopfzeile für alle E-Mails, die versandt werden";
$GLOBALS['strWarnLimit']				= "Warnung per E-Mail bei Unterschreiten der definierten Untergrenze";
$GLOBALS['strWarnLimitErr']				= "Warnlimit muß eine positive Ganzzahl sein";
$GLOBALS['strWarnLimitDays']                         = 'Warnung per E-Mail bei Unterschreiten der möglichen Tage';
$GLOBALS['strWarnLimitDaysErr']                      = 'Die angegebenen Tage sollten als eine positive Zahl angegeben werden';
$GLOBALS['strAllowEmail']                            = 'Globale Einstellung: Versand von eMails erlaubt';
$GLOBALS['strEmailAddress']                          = 'Welche E-Mail Adresse soll als Absender bei Reports angegeben werden';
$GLOBALS['strEmailAddressName']                      = 'Firma oder Personenname mit welche(r/m) die eMails signiert werden sollen';
$GLOBALS['strWarnAdmin']				= "Warnung per E-Mail an den Administrator, wenn eine Kampagne ausgelaufen ist";
$GLOBALS['strWarnClient']				= "Warnung per E-Mail an den Werbetreibenden, wenn eine Kampagne ausgelaufen ist";
$GLOBALS['strWarnAgency']                            = 'Warnung per E-Mail an die Agentur kurz bevor eine Kampagne ausläuft';
$GLOBALS['strQmailPatch']				= "Kopfzeile auch für qMail lesbar machen";

// UI Settings
$GLOBALS['strGuiSettings']			= "Konfiguration Benutzerbereich (Inhaber des AdServers)";
$GLOBALS['strGeneralSettings']				= "Allgemeine Grundeinstellungen des Sytems";
$GLOBALS['strAppName']				= "Name oder Bezeichnung der Anwendung";
$GLOBALS['strMyHeader']				= "Kopfzeile im Admin-Bereich";
$GLOBALS['strMyHeaderError']		= "Die Datei für die Kopfzeile wurde an angegebenen Adresse nicht vorgefunden";
$GLOBALS['strMyFooter']				= "Fußzeile im Admin-Bereich";
$GLOBALS['strMyFooterError']		= "Die Datei für die Fuüzeile wurde an angegebenen Adresse nicht vorgefunden";
$GLOBALS['strDefaultTrackerStatus']                  = 'Standardstatus Tracker';
$GLOBALS['strDefaultTrackerType']                    = 'Standardtyp Tracker';

$GLOBALS['strMyLogo']                                = 'Name der individuellen Logo-Datei';
$GLOBALS['strMyLogoError']                           = 'Diese Logo-Datei  ist im Verzeichnis admin/images nicht vorhanden';
$GLOBALS['strGuiHeaderForegroundColor']              = 'Vordergrundfarbe der Kopfzeile';
$GLOBALS['strGuiHeaderBackgroundColor']              = 'Hintergrundfarbe der Kopfzeile';
$GLOBALS['strGuiActiveTabColor']                     = 'Farbe des aktiven Reiters';
$GLOBALS['strGuiHeaderTextColor']                    = 'Textfarbe in der Kopfzeile';
$GLOBALS['strColorError']                            = 'Bitte geben Sie die Farben im RGB-Format an, z.B. \'0066CC\'';

$GLOBALS['strGzipContentCompression']		= "Komprimieren mit GZIP";
$GLOBALS['strClientInterface']			= "Nutzeroberfläche für Werbetreibende";
$GLOBALS['strReportsInterface']                      = 'Nutzeroberfläche für Berichte';
$GLOBALS['strClientWelcomeEnabled']		= "Begrüßungstext für Werbetreibende verwenden";
$GLOBALS['strClientWelcomeText']		= "Begrüßungstext<br /><i>(HTML Tags sind zugelassen)</i>";

$GLOBALS['strPublisherInterface']                    = 'Nutzeroberfläche für Werbeträger';
$GLOBALS['strPublisherAgreementEnabled']             = 'Login für Werbeträger erlauben, die unsere Geschäftsbedingungen nicht akzeptiert haben.';
$GLOBALS['strPublisherAgreementText']                = 'Login Text (HTML Tags erlaubt)';



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
?>
