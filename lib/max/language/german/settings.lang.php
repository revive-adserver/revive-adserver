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
$GLOBALS['strChooseInstallLanguage']		= "W&auml;hlen Sie die Sprache f&uuml;r den Installationsproze&szlig;";
$GLOBALS['strLanguageSelection']		= "Sprachauswahl";
$GLOBALS['strDatabaseSettings']			= "Datenbankeinstellungen";
$GLOBALS['strAdminSettings']			= "Einstellung f&uuml;r Administrator";
$GLOBALS['strAdminAccount']                 = "Administrator Konto";
$GLOBALS['strAdministrativeSettings']       = "Administrative Einstellungen";
$GLOBALS['strAdvancedSettings']		= "Erg&auml;nzende Einstellungen";
$GLOBALS['strOtherSettings']			= "Andere Einstellungen";
$GLOBALS['strSpecifySyncSettings']          = "Synchronizationseinstellungen";
$GLOBALS['strLicenseInformation']           = "Lizenz Information";
$GLOBALS['strOpenadsIdYour']                = "Ihre OpenX ID";
$GLOBALS['strOpenadsIdSettings']            = "OpenX ID Einstellungen";
$GLOBALS['strWarning']				= "Warnung";
$GLOBALS['strFatalError']			= "Ein schwerer Fehler ist aufgetreten";
$GLOBALS['strUpdateError']			= "W&auml;hrend des Updates ist ein Fehler aufgetreten";
$GLOBALS['strBtnContinue']                  = "Weiter &raquo;";
$GLOBALS['strBtnGoBack']                    = "&laquo; Zur&uuml;ck";
$GLOBALS['strBtnAgree']                     = "Ich stimme zu &raquo;";
$GLOBALS['strBtnDontAgree']                 = "&laquo; Ich stimme nicht zu";
$GLOBALS['strBtnRetry']                     = "Wiederholen";
$GLOBALS['strUpdateDatabaseError']	= "Aus unbekannten Gr&uuml;nden war die Aktualisierung der Datenbankstruktur nicht erfolgreich. Es wird empfohlen, zu versuchen, mit <b>Wiederhole Update</b> das Problem zu beheben. Sollte der Fehler - Ihrer Meinung nach - die Funktionalit&auml; von ".MAX_PRODUCT_NAME." nicht ber&uuml;hren, k&ouml;nnen Sie durch <b>Fehler ignorieren</b> fortfahren. Das Ignorieren des Fehlers wird nicht empfohlen!";
$GLOBALS['strAlreadyInstalled']			= MAX_PRODUCT_NAME." ist bereits auf diesem System installiert. Zur Konfiguration nutzen Sie das <a href='settings-index.php'>Konfigurationsmen&uuml;</a>";
$GLOBALS['strCouldNotConnectToDB']		= "Verbindung zur Datenbank war nicht m&ouml;glich. Bitte vorgenommene Einstellung pr&uuml;fen.";
$GLOBALS['strCreateTableTestFailed']		= "Der von Ihnen angegebene Nutzer hat nicht die notwendigen Zugriffsrechte, um die Datenbankstruktur anlegen zu k&ouml;nnen. Wenden Sie sich an den Systemverwalter.";
$GLOBALS['strUpdateTableTestFailed']		= " Der von Ihnen angegebene Nutzer hat nicht die notwendigen Zugriffsrechte, um die Datenbank zu aktualisieren. Wenden Sie sich an den Systemverwalter.";
$GLOBALS['strTablePrefixInvalid']		= "Ung&uuml;ltiges Vorzeichen (Pr&auml;fix) im Tabellennamen";
$GLOBALS['strTableInUse']			= "Die genannte Datenbank wird bereits von ".MAX_PRODUCT_NAME.", genutzt. Verwenden Sie einen anderes Pr&auml;fix oder lesen Sie im Handbuch die Hinweise f&uuml;r ein Upgrade.";
$GLOBALS['strNoVersionInfo']                = "Konnte Datenbankversion nicht rausfinden.";
$GLOBALS['strInvalidVersionInfo']           = "Konnte Datenbankversion nicht rausfinden.";
$GLOBALS['strInvalidMySqlVersion']          = MAX_PRODUCT_NAME." ben&ouml;tigt MySQL 4.0 oder h&ouml;her, um korrekt zu arbeiten. Bitte w&auml;hlen Sie einen anderen Datenbankserver.";
$GLOBALS['strTableWrongType']		= "Der gew&auml;hlte Tabellentype wird bei der Installation von ".$phpAds_dbmsname." nicht unterst&uuml;tzt";
$GLOBALS['strMayNotFunction']			= "Folgende Probleme sind zu beheben, um fortzufahren";
$GLOBALS['strFixProblemsBefore']		= "Folgende Teile m&uuml;ssen korrigiert werden, bevor der Installationsproze&szlig; von ".MAX_PRODUCT_NAME." fortgesetzt werden kann. Informationen &uuml;ber Fehlermeldungen finden sich im Handbuch.";
$GLOBALS['strFixProblemsAfter']			= "Sollten Sie die oben aufgef&uuml;hrten Fehler nicht selbst heben k&ouml;nnen, nehmen Sie Kontakt mit der Systemadministration Ihres Servers auf. Diese wird Ihnen weiterhelfen k&ouml;nnen.";
$GLOBALS['strIgnoreWarnings']			= "Ignoriere Warnungen";
$GLOBALS['strWarningDBavailable']		= "Die eingesetzte PHP-Version unterst&uuml;tzt nicht die Verbindung zum ".$phpAds_dbmsname." Datenbankserver. Die PHP- ".$phpAds_dbmsname."-Erweiterung wird ben&ouml;tigt.";
$GLOBALS['strWarningPHPversion']		= MAX_PRODUCT_NAME." ben&ouml;tigt PHP 4.0 oder h&ouml;her, um korrekt genutzt werden zu k&ouml;nnen. Sie nutzten {php_version}.";
$GLOBALS['strWarningRegisterGlobals']		= "Die PHP-Konfigurationsvaribable <i>register_globals</i> mu&szlig; gesetzt werden.";
$GLOBALS['strWarningMagicQuotesGPC']		= " Die PHP-Konfigurationsvaribable <i> magic_quotes_gpc</i> mu&szlig; gesetzt werden.";
$GLOBALS['strWarningMagicQuotesRuntime']	= " Die PHP-Konfigurationsvaribable <i> magic_quotes_runtime</i> mu&szlig; deaktiviert werden.";
$GLOBALS['strWarningFileUploads']		= " Die PHP-Konfigurationsvaribable <i> file_uploads</i> mu&szlig; gesetzt werden.";
$GLOBALS['strWarningTrackVars']			= " Die PHP-Konfigurationsvaribable <i> track_vars</i> mu&szlig; gesetzt werden.";
$GLOBALS['strWarningPREG']				= "Die verwendete PHP-Version unterst&uuml;tzt nicht PERL-kompatible Ausdr&uuml;cke. Um fortfahren zu k&ouml;nnen wird die PHP-Erweiterung <i>PREG</i> ben&ouml;tigt.";
$GLOBALS['strConfigLockedDetected']		= MAX_PRODUCT_NAME." hat erkannt, da&szlig; die Datei <b>config.inc.php</b> schreibgesch&uuml;tzt ist.<br /> Die Installation kann aber ohne Schreibberechtigung nicht fortgesetzt werden. <br />Weitere Informationen finden sich im Handbuch.";

$GLOBALS['strCantUpdateDB']  			= "Ein Update der Datenbank ist derzeit nicht m&ouml;glich. Wenn Sie die Installation fortsetzen, werden alle existierende Banner, Statistiken und Werbetreibenden gel&ouml;scht. ";
$GLOBALS['strIgnoreErrors']			= "Fehler ignorieren";
$GLOBALS['strRetryUpdate']			= "Wiederhole Update";
$GLOBALS['strTableNames']			= "Tabellenname";
$GLOBALS['strTablesPrefix']			= "Pr&auml;fix zum Tabellenname";
$GLOBALS['strTablesType']			= "Tabellentype";
$GLOBALS['strInstallWelcome']			= "Willkommen bei ".MAX_PRODUCT_NAME;
$GLOBALS['strInstallMessage']			= "Bevor ".MAX_PRODUCT_NAME." genutzt werden kann, m&uuml;ssen die Einstellungen konfiguriert  <br /> sowie die Datenbank geschaffen (create) werden. Dr&uuml;cken Sie <b>Weiter</b> , um fortzufahren.";

$GLOBALS['strInstallIntro']                 = "Willkommen zu <a href='http://".MAX_PRODUCT_URL."' target='_blank'><strong>".MAX_PRODUCT_NAME."</strong></a>! Bald sind Sie auch ein Teil der gr&ouml;&szlig;ten Adserver Community.
<p>Wir werden unser bestes tun, um die Installation bzw. das Update so einfach wie m&ouml;glich zu halten. Bitte halten Sie sich an die Anweisungen auf dem Bildschirm, und sollten Sie weiterf&uuml;hrende Hilfe ben&ouml;tigen wenden Sie sich bitte an <a href='http://".OA_DOCUMENTATION_BASE_URL."' target='_blank'><strong>die Dokumentation</strong></a>.</p>
<p>Sollten Sie auch nach Durchsicht der Dokumentation noch weitere Fragen haben, schauen Sie zum <a href='http://".MAX_PRODUCT_URL."/support/overview.html' target='_blank'><strong>Support</strong></a> Bereich unserer Website und dem " . MAX_PRODUCT_NAME . " <a href='http://".MAX_PRODUCT_FORUMURL."' target='_blank'><strong>Community Forum</strong></a>.</p>
<p>Vielen Dank, dass Sie sich f&uuml;r OpenAds entschieden haben.</p>";
$GLOBALS['strTermsTitle']               = "Lizenz Information";
$GLOBALS['strTermsIntro']               = MAX_PRODUCT_NAME . " ist ein freier, open source Adserver, vertrieben unter der GPL Lizenz. Bitte lesen Sie diese und stimmen Sie dieser zu, um die Installation fort zu fahren.";
$GLOBALS['strPolicyTitle']               = "Datenschutzvereinbarung";
$GLOBALS['strPolicyIntro']               = "Bitte lesen Sie unsere Datenschutzvereinbarung genau durch, bevor Sie mit der Installation weiter machen.";
$GLOBALS['strDbSetupTitle']               = "Datenbank Setup";
$GLOBALS['strDbSetupIntro']               = MAX_PRODUCT_NAME . " verwendet den MySQL oder PostgreSQL Datenbankserver, um Daten zu speichern. Bitte tragen Sie die Daten Ihres Datenbankservers nachfolgend ein.  Wenn Sie sich nicht sicher sind, welche Daten hier einzutragen sind, fragen Sie bitte Ihren Serveradministrator.";
$GLOBALS['strDbUpgradeIntro']             = "Nachfolgend k&ouml;nnen Sie die Daten Ihres Datenbankservers einsehen und korrigieren, falls diese falsch sind. Wenn Sie jetzt auf Weiter klicken, wird " . MAX_PRODUCT_NAME . " mit der Installation bzw. dem Upgrade der Datenbankdaten fortfahren. Bitte vergewissern Sie sich, dass Sie ein aktuelles und g&uuml;ltiges Backup Ihrer Daten erstellt haben.";

$GLOBALS['strOaUpToDate']               = "Ihre " . MAX_PRODUCT_NAME . " Datenbank und Dateien verwenden bereits die neueste Version von ".MAX_PRODUCT_NAME." und muss daher zum jetztigen Zeitpunkt nicht aktualisiert werden. Bitte klicken Sie auf Weiter, um zur Administrationsoberfl&auml;che fortzufahren.";
$GLOBALS['strOaUpToDateCantRemove']     = "Warnung: Die Datei UPGRADE im var Unterverzeichnis ist weiterhin vorhanden. Leider war es uns aufgrund mangelnden Zugriffsrechten nicht m&ouml;glich die Datei zu l&ouml;schen. Bitte l&ouml;schen Sie diese Datei manuell.";
$GLOBALS['strRemoveUpgradeFile']               = "Sie m&uuml;ssen die Datei UPGRADE im var Unterverzeichnis manuell l&ouml;schen.";


$GLOBALS['strInstallSuccess']			=
"<strog>Herzlichen Gl&uuml;ckwunsch! Die Installation von " . MAX_PRODUCT_NAME . " " . OA_VERSION ." war erfolgreich.</strong><br />
<br />Um das beste aus ". MAX_PRODUCT_NAME ." herauszuholen, sollten Sie noch folgende zwei Schritte durchf&uuml;hren.

<strong>Wartungsmodul</strong><br />
Damit ".MAX_PRODUCT_NAME." korrekt arbeitet, mu&szlig; sichergestellt sein, da&szlig; das Wartungsmodul (maintenance.php) st&uuml;ndlich aktiviert wird.
Es ist zwar nicht zwingend notwendig das Wartungsmodul &uuml;ber das Cron zu starten, da solange Banner ausgeliefert werden, das Wartungsmodul automatisch von
der Auslieferungsskripten gestartet wird. Der Zuverl&auml;ssigkeit wegen ist es jedoch empfehlenswert das Wartungsmodul &uuml;ber das Cron st&uuml;ndlich zu starten.
N&auml;here Informationen finden sich im <a href='http://".OA_DOCUMENTATION_BASE_URL."' target='_blank'>Handbuch</a>. <br />
<br />
<strong>Sicherheit</strong><br />
Die " . MAX_PRODUCT_NAME . " Installationsroutine muss auf die Konfigurationsdatei schreibend zugreifen k&ouml;nnen. Nachdem die Installation und die nachfolgende Konfiguration beendet ist,
sollte der Schreibschutz auf der Konfigurationsdatei wieder entfernt werden.<br />
N&auml;here Informationen finden sich im <a href='http://".OA_DOCUMENTATION_BASE_URL."' target='_blank'>Handbuch</a>.
<br /><br />
Klicken Sie nun auf Weiter, um mit der Konfiguration fortzufahren.";

$GLOBALS['strInstallNotSuccessful']		= "<b>Die Installation von ".MAX_PRODUCT_NAME." war nicht erfolgreich</b><br /><br />
Teile des Installationsprozesses wurden nicht beendet. Das Problem ist m&ouml;glicherweise nur tempor&auml;r. In diesem Fall dr&uuml;cken Sie <b> Weiter</b> und beginnen Sie den Installationsproze&szlig; von Neuem. N&auml;heres zu Fehlermeldungen und -behebung findet sich im Handbuch.";
$GLOBALS['strSystemCheck']                  = "System �berpr�fung";
$GLOBALS['strSystemCheckIntro']             = MAX_PRODUCT_NAME . " setzt einige Dinge voraus, welche nun gepr&uuml;ft werden. Sie erhalten eine Meldung, sollte etwas nicht stimmen.";
$GLOBALS['strDbSuccessIntro']               = "Die " . MAX_PRODUCT_NAME . " Datenbank wurde erstellt. Bitte dr&uuml;cken Sie nun auf Weiter, um die " . MAX_PRODUCT_NAME . " Administrations- und Auslieferungseinstellungen zu t&auml;tigen.";
$GLOBALS['strDbSuccessIntroUpgrade']        = "Die " . MAX_PRODUCT_NAME . " Datenbank wurde aktualisiert. Bitte dr&uuml;cken Sie nun auf Weiter, um die " . MAX_PRODUCT_NAME . " Administrations- und Auslieferungseinstellungen zu t&auml;tigen.";
$GLOBALS['strErrorOccured']			= "Der folgende Fehler ist aufgetreten:";
$GLOBALS['strErrorInstallDatabase']		= "Die Datenbankstruktur konnte nicht angelegt werden.";
$GLOBALS['strErrorInstallPrefs']            = "Die Benutzereinstellungen f&uuml;r den Administrator konnten nicht in die Datenbank geschrieben werden.";
$GLOBALS['strErrorInstallVersion']          = "Die " . MAX_PRODUCT_NAME . " Versionsnummer konnte nicht in die Datenbank geschrieben werden.";
$GLOBALS['strErrorUpgrade'] = 'Das Upgrade der Datenbank der bestehenden Installation ist fehlgeschlagen.';
$GLOBALS['strErrorInstallDbConnect']		= "Eine Verbindung zur Datenbank konnte nicht ge&ouml;ffnet werden.";
$GLOBALS['strErrorWritePermissions']        = "Um diese(n) Fehler auf Ihrem Linux Server zu beheben, m&uuml;ssen Sie folgende(n) Befehl(e) eingeben:";
$GLOBALS['strErrorFixPermissionsCommand']   = "<i>chmod a+w %s</i>";
$GLOBALS['strCheckDocumentation']           = "F&uuml;r weitere Hilfe sehen Sie bitte in das Handbuch unter http://".OA_DOCUMENTATION_BASE_URL;

$GLOBALS['strAdminUrlPrefix']               = "URL der Admin-Oberfl&auml;che";
$GLOBALS['strDeliveryUrlPrefix']            = "URL des Ad-Servers";
$GLOBALS['strDeliveryUrlPrefixSSL']         = "URL des Ad-Servers (SSL)";
$GLOBALS['strImagesUrlPrefix']              = "URL des Verzeichnisses in dem die Grafiken gespeichert werden";
$GLOBALS['strImagesUrlPrefixSSL']           = "URL des Verzeichnisses in dem die Grafiken gespeichert werden (SSL)";

$GLOBALS['strInvalidUserPwd']			= "Fehlerhafter Benutzername oder Passwort";

$GLOBALS['strUpgrade']				= "Programmaktualisierung (Upgrade)";
$GLOBALS['strSystemUpToDate']		= "Das System ist bereits aktuell. Eine Aktualisierung (Upgrade) ist nicht notwendig. <br />
Dr&uuml;cken Sie <b>Weiter</b>, um zur Startseite zu gelangen.";
$GLOBALS['strSystemNeedsUpgrade']		= "Die Datenbankstruktur und die Konfigurationsdateien sollten aktualisiert werden. Dr&uuml;cken Sie <b>Weiter</b> f&uuml;r den Start des Aktualisierungslaufes.
 <br /><br />Abh&auml;ngig von der derzeitig genutzten Version und der Anzahl der vorhandenen Statistiken kann dieser Proze&szlig; Ihre Datenbank stark belasten. Das Upgrade kann einige Minuten dauern.";
$GLOBALS['strSystemUpgradeBusy']		= "Aktualisierung des Systems l&auml;uft. Bitte warten ...";
$GLOBALS['strSystemRebuildingCache']		= "Cache wird neu erstellt. Bitte warten ...";
$GLOBALS['strServiceUnavalable']		= "Dieser Service ist zur Zeit nicht erreichbar. System wird aktualisiert...";


/*-------------------------------------------------------*/
/* Configuration translations                            */
/*-------------------------------------------------------*/

// Global
$GLOBALS['strChooseSection']			= "Bereichsauswahl";
$GLOBALS['strEditConfigNotPossible']   		= "&Auml;nderungen der Systemeinstellung nicht m&ouml;glich. F&uuml;r die Konfigurationsdatei  <i>config.inc.php</i> besteht Schreibschutz. ".
										  "F&uuml;r &Auml;nderungen mu&szlig; der Schreibschutz aufgehoben werden.";
$GLOBALS['strEditConfigPossible']		= "Unbefugte System&auml;nderungen sind m&ouml;glich. Die Zugriffsrechte der Konfigurationsdatei <i>config.inc.php</i> sind auf Schreibbrechtigung gesetzt. ".
										  "Zur Sicherung des Systems sollte der Schreibschutz gesetzt werden. N&auml;here Informationen im Handbuch.";
$GLOBALS['strUnableToWriteConfig']                   = 'Die &Auml;nderungen konnten nicht in die Konfigurationsdatei &uuml;bernommen werden';
$GLOBALS['strUnableToWritePrefs']                    = 'Die Voreinstellungen konnten nicht in die Datenbank geschrieben werden.';
$GLOBALS['strImageDirLockedDetected']	             = "Das angegebene Verzeichnis f&uuml;r die Bilder hat keine Webserver Schreibrechte gesetzt. Sie k&ouml;nnen nicht fortfahren, bis Sie die Zugriffsrechte &auml;ndern oder das Verzeichnis erstellen.";

// Configuration Settings
$GLOBALS['strConfigurationSetup']                    = 'Konfiguration';
$GLOBALS['strConfigurationSettings']                    = 'Konfigurationseinstellungen';

// Administrator settings
$GLOBALS['strAdministratorSettings']		= "Einstellungen f&uuml;r Administrator";
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
$GLOBALS['strAdminCheckUpdates']		= "Pr&uuml;fen, ob neue Programmversionen vorhanden sind";
$GLOBALS['strAdminCheckEveryLogin']		= "Bei jedem Login";
$GLOBALS['strAdminCheckDaily']		= "T&auml;glich";
$GLOBALS['strAdminCheckWeekly']		= "W&ouml;chentlich";
$GLOBALS['strAdminCheckMonthly']		= "Monatlich";
$GLOBALS['strAdminCheckNever']		= "Nie";
$GLOBALS['strAdminNovice']			= "L&ouml;schvorg&auml;nge im Admin-Bereich nur mit Sicherheitsbest&auml;tigung";
$GLOBALS['strUserlogEmail']			= "Alle ausgehenden E-Mails protokollieren ";
$GLOBALS['strEnableDashboard']                       = "Dashboard aktivieren";
$GLOBALS['strTimezoneInformation']                   = "Zeitzone Einstellungen (&Auml;ndern der Zeitzone wirkt sich auf die Statistiken aus)";
$GLOBALS['strTimezone']                              = "Zeitzone";
$GLOBALS['strTimezoneEstimated']                     = "Ihre wahrscheinliche Zeitzone";
$GLOBALS['strTimezoneGuessedValue']                  = "Die Zeitzoneneinstellungen in PHP sind nicht korrekt gesetzt.";
$GLOBALS['strTimezoneSeeDocs']                       = "Bitte konsultieren Sie das Handbuch unter %DOCS% welche Variable in PHP gesetzt werden muss.";
$GLOBALS['strTimezoneDocumentation']                 = "Handbuch";
$GLOBALS['strLoginSettingsTitle']                    = "Administrator Login";
$GLOBALS['strLoginSettingsIntro']                    = "Um mit dem Upgrade Prozess fortzufahren, geben Sie Ihre " . MAX_PRODUCT_NAME . " Administrator Zugangsdaten ein. Sie m&uuml;ssen sich als Administrator einloggen, um mit dem Upgrade Prozess fortzufahren.";
$GLOBALS['strAdminSettingsTitle']                    = "Ihr Administrator Konto";
$GLOBALS['strAdminSettingsIntro']                    = "Das Administator Konto wird verwendet, um sich in die  " . MAX_PRODUCT_NAME . " Ad-Server Overfl&auml;che einzuloggen, die Banner und Kampagnen zu verwalten und Statistiken einzusehen. Bitte tragen Sie nachfolgend die Daten f&uuml;r den Administrator ein.";
$GLOBALS['strConfigSettingsIntro']                    = "Bitte &uuml;berpr&uuml;fen Sie die nachfolgenden Konfigurationseinstellungen. Es ist sehr wichtig, dass Sie sehr sorgf&auml;ltig diese Einstellungen kontrollieren, da sich diese auf die Betrieb des " . MAX_PRODUCT_NAME ." Ad-Servers sehr start auswirken.";
$GLOBALS['strEnableAutoMaintenance']	             = "Das Wartungsmodul wird automatisch w&auml;hrend der Bannerauslieferung gestartet, sofern das Wartungsmodul nicht &uuml;ber Cron (oder &auml;hnliches) eingebunden ist";

// OpenX ID Settings
$GLOBALS['strOpenadsUsername']                       = MAX_PRODUCT_NAME . " Benutzername";
$GLOBALS['strOpenadsPassword']                       = MAX_PRODUCT_NAME . " Passwort";
$GLOBALS['strOpenadsEmail']                          = MAX_PRODUCT_NAME . " E-Mail";

// Banner Settings
$GLOBALS['strBannerSettings']                        = 'Bannereinstellungen';
$GLOBALS['strDefaultBanners']			= "Ersatzbanner <i>(kein regul&auml;res Banner steht zur Verf&uuml;gung)</i>";
$GLOBALS['strDefaultBannerUrl']		= "Bild-URL f&uuml;r Ersatzbanner";
$GLOBALS['strDefaultBannerDestination']      = 'Ziel-URL f&uuml;r Ersatzbanner';
$GLOBALS['strAllowedBannerTypes']		= "Zugelassene Bannertypen (Mehrfachnennung m&ouml;glich)";
$GLOBALS['strTypeSqlAllow']			= "Banner in Datenbank speichern (SQL)";
$GLOBALS['strTypeWebAllow']			= "Banner auf Web-Server (lokal)";
$GLOBALS['strTypeUrlAllow']			= "Banner &uuml;ber URL verwalten";
$GLOBALS['strTypeHtmlAllow']			= "HTML-Banner";
$GLOBALS['strTypeTxtAllow']			= "Textanzeigen";
$GLOBALS['strTypeHtmlSettings']		= "Optionen f&uuml;r HTML-Banner";
$GLOBALS['strTypeHtmlAuto']			= "HTML-Code zum Aufzeichnen der AdClicks modifizieren";
$GLOBALS['strTypeHtmlPhp']			= "Ausf&uuml;hrbarer PHP-Code ist in HTML-Banner zugelassen ";


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
$GLOBALS['strCantConnectToDb']		= "Verbindung zur Datenbank nicht m&ouml;glich";
$GLOBALS['strDemoDataInstall']                       = 'Installation von Demonstrationsdaten';
$GLOBALS['strDemoDataIntro']                         = 'Standardwerte k&ouml;nnen in die ' . MAX_PRODUCT_NAME . ' Datenbank geladen werden, um Ihnen die
Start mit dem Ad-Server zu erleichtern. Die meist verwendeten Bannertypen als auch einige Kampagnen werden vorkonfiguriert.

Dies ist f&uuml;r Neuinstallationen sehr empfehlenswert.';

// Debug Logging Settings
$GLOBALS['strDebugSettings']                         = 'Debug-Logging';
$GLOBALS['strDebug']                                 = 'Grunds&auml;tzliche Einstellungen f&uuml;r das Debug-Logging';
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
$GLOBALS['strDebugPassword']                         = 'mCal, SQL-Server Pa&szlig;wort';

// Delivery Settings
$GLOBALS['strDeliverySettings']			= "Einstellungen f&uuml;r Bannerauslieferung";
$GLOBALS['strWebPath']                               = '&Uuml;bersicht ' . MAX_PRODUCT_NAME . ' Server-Pfade';
$GLOBALS['strWebPathSimple']                         = 'Server-Pfad';
$GLOBALS['strDeliveryPath']                          = 'Pfad f&uuml;r die Auslieferung';
$GLOBALS['strImagePath']                             = 'Pfad zur Speicherung von Bildern';
$GLOBALS['strDeliverySslPath']                       = 'Pfad f&uuml;r die Auslieferung (SSL)';
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
$GLOBALS['strTypeFTPErrorConnect']		= "Verbindung zum FTP Server nicht m&ouml;glich. Benutzername oder Passwort waren fehlerhaft";
$GLOBALS['strTypeFTPErrorHost']			= "Hostname f&uuml;r FTP-Server ist fehlerhaft";
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
$GLOBALS['strOriginScript']                          = 'Script-Datei f&uuml;r origin Datenbank';
$GLOBALS['strOriginTypeXMLRPC']                      = 'XMLRPC';
$GLOBALS['strOriginTimeout']                         = 'Origin timeout (Sekunden)';
$GLOBALS['strOriginProtocol']                        = 'Origin-Server Protokoll';
$GLOBALS['strDeliveryBanner']                        = 'Allgemeine Einstellungen der Werbemittelauslieferung';
$GLOBALS['strDeliveryAcls']                          = '&Uuml;berpr&uuml;fe die Auslieferungseinschr&auml;nkungen eines Banners w&auml;hrend der Auslieferung';
$GLOBALS['strDeliveryObfuscate']                     = 'Bei der Auslieferung die Gruppe eines Werbemittels verschleiern';
$GLOBALS['strDeliveryExecPhp']                       = 'PHP-Code in Werbemitteln wird ausgef&uuml;hrt<br />(Achtung: Starkes Sicherheitsrisiko)';
$GLOBALS['strDeliveryCtDelimiter']                   = 'Begrenzung des 3rd Party Kick-Trackings';
$GLOBALS['strP3PSettings']			= "P3P-Datenschutzrichtlinien";
$GLOBALS['strUseP3P']				= "Verwendung von P3P-Richtlinien";
$GLOBALS['strP3PCompactPolicy']		= "P3P-Datenschutzrichtlinien (kompakte Form)";
$GLOBALS['strP3PPolicyLocation']		= "Speicherort der P3P-Richtlinien";

// General Settings
$GLOBALS['generalSettings']                          = 'Allgemeine Grundeinstellungen des Sytems';
$GLOBALS['uiEnabled']                                = 'Nutzer-Interface aktivieren';
$GLOBALS['defaultLanguage']                          = 'Standard-Sprache<br />(Jeder Nutzer kann seine eigene Systemsprache w&auml;hlen)';
$GLOBALS['requireSSL']                               = 'Erzwinge SSL-Zugang zum Nutzer-Interface';
$GLOBALS['sslPort']                                  = 'Vom Web-Server genutzer SSL-Port';

// Geotargeting
$GLOBALS['strGeotargetingSettings']                  = 'Einstellungen Geotargeting';
$GLOBALS['strGeotargeting']			= "Allgemeine Einstellungen Geotargeting";
$GLOBALS['strGeotargetingType']                      = 'Geotargeting Modultyp';
$GLOBALS['strGeotargetingGeoipCountryLocation']      = 'Speicherort der MaxMind GeoIP L&auml;nderdatenbank';
$GLOBALS['strGeotargetingGeoipRegionLocation']       = 'Speicherort der MaxMind GeoIP Regionendatenbank';
$GLOBALS['strGeotargetingGeoipCityLocation']         = 'Speicherort der MaxMind GeoIP St&auml;dtedatenbank';
$GLOBALS['strGeotargetingGeoipAreaLocation']         = 'Speicherort der MaxMind GeoIP Gebietsdatenbank';
$GLOBALS['strGeotargetingGeoipDmaLocation']          = 'Speicherort der MaxMind GeoIP DMA-Databank (nur USA)';
$GLOBALS['strGeotargetingGeoipOrgLocation']          = 'Speicherort der MaxMind GeoIP Organisationendatenbank';
$GLOBALS['strGeotargetingGeoipIspLocation']          = 'Speicherort der MaxMind GeoIP ISP-Datenbank';
$GLOBALS['strGeotargetingGeoipNetspeedLocation']     = 'Speicherort der MaxMind GeoIP Bandbreitendatenbank';
$GLOBALS['strGeoSaveStats']                          = 'Speichere die GeoIP-Daten in den Datenbank-Logs';
$GLOBALS['strGeoShowUnavailable']                    = 'Zeige die durch Geotargeting verursachten Auslieferungslimitierungen an, auch wenn keine GeoIP-Daten verf&uuml;gbar sind';
$GLOBALS['strGeotrackingGeoipCountryLocationError']  = 'Die MaxMind GeoIP L&auml;nderdatenbank konnte im angegebenen Verzeichnis nicht gefunden werden';
$GLOBALS['strGeotrackingGeoipRegionLocationError']   = 'Die MaxMind GeoIP Regionendatenbank konnte im angegebenen Verzeichnis nicht gefunden werden';
$GLOBALS['strGeotrackingGeoipCityLocationError']     = 'Die MaxMind GeoIP St&auml;dtedatenbank konnte im angegebenen Verzeichnis nicht gefunden werden';
$GLOBALS['strGeotrackingGeoipAreaLocationError']     = 'Die MaxMind GeoIP Gebietsdatenbank konnte im angegebenen Verzeichnis nicht gefunden werden';
$GLOBALS['strGeotrackingGeoipDmaLocationError']      = 'Die MaxMind GeoIP DMA-Datenbank konnte im angegebenen Verzeichnis nicht gefunden werden';
$GLOBALS['strGeotrackingGeoipOrgLocationError']      = 'Die MaxMind GeoIP Organisationendatenbank konnte im angegebenen Verzeichnis nicht gefunden werden';
$GLOBALS['strGeotrackingGeoipIspLocationError']      = 'Die MaxMind GeoIP ISP-Datenbank konnte im angegebenen Verzeichnis nicht gefunden werden';
$GLOBALS['strGeotrackingGeoipNetspeedLocationError'] = 'Die MaxMind GeoIP Bandbreitendatenbank konnte im angegebenen Verzeichnis nicht gefunden werden';

// Interface Settings
$GLOBALS['strInterfaceDefaults']		= "Einstellungen der Nutzeroberfl&auml;che";
$GLOBALS['strInventory']			= "Inventar-Seiten";
$GLOBALS['strUploadConversions']                     = 'Konversionen hochladen';
$GLOBALS['strShowCampaignInfo']		= "Anzeigen zus&auml;tzlicher Informationen auf der Seite <i>&Uuml;bersicht Kampagnen</i>";
$GLOBALS['strShowBannerInfo']			= "Anzeigen zus&auml;tzlicher Werbemittelinformationen auf der Seite <i>&uuml;bersicht Werbemittel</i> ";
$GLOBALS['strShowCampaignPreview']		= "Vorschau aller Werbemittel auf der Seite  <i>&Uuml;bersicht Werbemittel</i>";
$GLOBALS['strShowBannerHTML']			= "Anzeige des Banners anstelle des HTML-Codes bei Vorschau von HTML-Bannern";
$GLOBALS['strShowBannerPreview']		= "Werbemittelvorschau oben auf allen Seiten mit Bezug zum Werbemittel";
$GLOBALS['strHideInactive']			= "Verbergen inaktiver Elemente auf den &Uuml;bersichtsseiten";
$GLOBALS['strGUIShowMatchingBanners']		= "Anzeige des zugeh&ouml;renden Werbemittels auf der Seite <i>Verkn&uuml;pfte Werbemittel</i>";
$GLOBALS['strGUIShowParentCampaigns']		= "Anzeige der zugeh&ouml;renden Kampagne auf der Seite <i>Vekn&uuml;pfte Werbemittel</i>";
$GLOBALS['strGUIAnonymousCampaignsByDefault']        = 'Default Campaigns to Anonymous';
$GLOBALS['strStatisticsDefaults'] 		= "Statistiken";
$GLOBALS['strBeginOfWeek']			= "Wochenbeginn";
$GLOBALS['strPercentageDecimals']		= "Dezimalstellen bei Prozentangaben";
$GLOBALS['strWeightDefaults']			= "Gewichtung (Voreinstellung)";
$GLOBALS['strDefaultBannerWeight']		= "Bannergewichtung (Voreinstellung)";
$GLOBALS['strDefaultCampaignWeight']		= "Kampagnengewichtung (Voreinstellung)";
$GLOBALS['strDefaultBannerWErr']		= "Voreinstellung f&uuml;r Bannergewichtung mu&szlig; eine positive Ganzzahl sein";
$GLOBALS['strDefaultCampaignWErr']		= " Voreinstellung f&uuml;r Kampagne mu&szlig; eine positive Ganzzahl sein";

$GLOBALS['strPublisherDefaults']                     = 'Defaulteinstellungen f&uuml;r Werbetr&auml;ger';
$GLOBALS['strModesOfPayment']                        = 'Zahlungsarten';
$GLOBALS['strCurrencies']                            = 'W&auml;hrungen';
$GLOBALS['strCategories']                            = 'Kategorien';
$GLOBALS['strHelpFiles']                             = 'Hilfsdateien';
$GLOBALS['strHasTaxID']                              = 'USt.-ID';
$GLOBALS['strDefaultApproved']                       = 'Ich stimme zu - Checkbox';

// CSV Import Settings
$GLOBALS['strChooseAdvertiser']                      = 'Werbetreibenden ausw&auml;hlen';
$GLOBALS['strChooseCampaign']                        = 'Kampagne aus&auml;hlen';
$GLOBALS['strChooseCampaignBanner']                  = 'Banner aus&auml;hlen';
$GLOBALS['strChooseTracker']                         = 'Tracker aus&auml;hlen';
$GLOBALS['strDefaultConversionStatus']               = 'Standard Status von Konversionen';
$GLOBALS['strDefaultConversionType']                 = 'Standard Typ von Konversionen';
$GLOBALS['strCSVTemplateSettings']                   = 'CSV-Vorlagen Einstellungen';
$GLOBALS['strIncludeCountryInfo']                    = 'L&auml;nderinformationen einschlie&szlig;en';
$GLOBALS['strIncludeBrowserInfo']                    = 'Browserinformationen einschlie&szlig;en';
$GLOBALS['strIncludeOSInfo']                         = 'Betriebsysteminformationen einschlie&szlig;en';
$GLOBALS['strIncludeSampleRow']                      = 'Beispielinformation einschlie&szlig;en';
$GLOBALS['strCSVTemplateAdvanced']                   = 'Erweiterte Vorlage';
$GLOBALS['strCSVTemplateIncVariables']               = 'Tracker Variablen einschlie&szlig;en';

// Invocation Settings
$GLOBALS['strInvocationAndDelivery']                 = 'Einstellungen Bannercode';
$GLOBALS['strAllowedInvocationTypes']                = 'Erlaubte Einbindungsarten';
$GLOBALS['strInvocationDefaults']                    = 'Einbindungsvorgabe';
$GLOBALS['strEnable3rdPartyTrackingByDefault']       = 'Aktiviere standardm&auml;&szlig;ig das 3rd Party Klicktracking';

// Statistics Settings
$GLOBALS['strStatisticsSettings']			= "Statistikeinstellungen";
$GLOBALS['strStatisticsLogging']                     = 'Allgemeine Protokollierungseinstellungen';
$GLOBALS['strCsvImport']                             = 'Upload von offline Konversionen erlauben';
$GLOBALS['strLogAdRequests']                         = 'Protokolliere bei jedem Aufruf eines Werbemittels auf dem Server einen Ad Request';
$GLOBALS['strLogAdImpressions']                      = 'Protokolliere eine Ad Impression, wenn ein Werbemittel beim Nutzer angekommen ist (Truecount)';
$GLOBALS['strLogAdClicks']                           = 'Protoklliere einen Ad Click , wenn ein Nutzer auf ein Werbemittel klickt';
$GLOBALS['strLogTrackerImpressions']                 = 'Protokolliere eine Tracker Impression, wenn ein Nutzer eine Seite mit Tracker-Code vollst&auml;ndig l&auml;dt.';
$GLOBALS['strReverseLookup']                         = 'F&uuml;hre fallls notwendig einen Reverse lookup der IP Adresse durch, um Hostname zu erhalten (kann den Ad-Server stark verz&ouml;gern!)';
$GLOBALS['strProxyLookup']                           = 'Versuche die echte IP Adresse eines Proxy Besuchers zu ermitteln.';
$GLOBALS['strSniff']                                 = 'Ermittele das Betriebsystem und den Browser des Besuchers mit phpSniff.';
$GLOBALS['strPreventLogging']			= "Protokollieren verhindern";
$GLOBALS['strIgnoreHosts']				= "AdViews und AdClicks f&uuml;r Besucher mit folgenden IP-Adressen oder Hostnamen bleiben in den Statistiken unber&uuml;cksichtigt";
$GLOBALS['strBlockAdViews']				= "Reloadsperre (Zeitraum in Sek.)";
$GLOBALS['strBlockAdViewsError']                     = 'Intervall f&uuml;r Reload-Sperre mu&szlig; eine positive ganze Zahl sein';
$GLOBALS['strBlockAdClicks']			= " Reclicksperre (Zeitraum in Sek.) ";
$GLOBALS['strBlockAdClicksError']                    = 'Intervall f&uuml;r Reklick-Sperre mu&szlig; eine positive ganze Zahl sein';
$GLOBALS['strBlockAdConversions']                    = 'Keine Tracker-Impression protokollieren, wenn der Nutzer die Seite mit dem Tracker-Code im angegeben Zeitintervall gesehen hat (in Sekunden)';
$GLOBALS['strBlockAdConversionsError']               = 'Intervall f&uuml;r Tracking-Sperre mu&szlig; eine positive ganze Zahl sein';
$GLOBALS['strMaintenaceSettings']                    = 'Allgemine Wartungseinstellungen';
$GLOBALS['strMaintenanceAdServerInstalled']          = 'Verarbeite Statistiken der Ad-Server-Module';
$GLOBALS['strMaintenanceTrackerInstalled']           = 'Verarbeite Statistiken f&uuml;r Tracker-Module';
$GLOBALS['strMaintenanceOI']                         = 'Wartungsintervall (in Minuten)';
$GLOBALS['strMaintenanceOIError']                    = 'Dieses Wartungsintervall ist nicht zul&auml;ssig - bitte konsultieren Sie die Dokumentation';
$GLOBALS['strMaintenanceCompactStats']               = 'L&ouml;schen der Original-Statistiken nach der Verarbeitung?';
$GLOBALS['strMaintenanceCompactStatsGrace']          = 'Karenzzeit bevor verarbeitete Statistiken gel&ouml;scht werden (Sekunden)';
$GLOBALS['strPrioritySettings']                      = 'Allgemeine Dringlichkeitseinstellungen';
$GLOBALS['strPriorityInstantUpdate']                 = 'Aktualisiere Werbemittel die &auml;lter sind als...';
$GLOBALS['strWarnCompactStatsGrace']                 = 'Die Karenzzeit bevor die Statistiken kompaktiert werden mu&szlig; eine positive ganze Zahl sein';
$GLOBALS['strDefaultImpConWindow']                   = 'Standard Ad Impression Connection Window (Sekunden)';
$GLOBALS['strDefaultImpConWindowError']              = 'Wenn gesetzt, mu&szlig; der Standard Ad Impression Connection Window eine positive ganze Zahl sein';
$GLOBALS['strDefaultCliConWindow']                   = 'Standard Ad Click Connection Window (Sekunden)';
$GLOBALS['strDefaultCliConWindowError']              = 'Wenn gesetzt, mu&szlig; der Standard Ad Click Connection Window eine positive ganze Zahl sein';
$GLOBALS['strEmailWarnings']			= "Warnungen per E-Mail";
$GLOBALS['strAdminEmailHeaders']		= "Kopfzeile f&uuml;r alle E-Mails, die versandt werden";
$GLOBALS['strWarnLimit']				= "Warnung per E-Mail bei Unterschreiten der definierten Untergrenze";
$GLOBALS['strWarnLimitErr']				= "Warnlimit mu&szlig; eine positive Ganzzahl sein";
$GLOBALS['strWarnLimitDays']                         = 'Warnung per E-Mail bei Unterschreiten der m&ouml;glichen Tage';
$GLOBALS['strWarnLimitDaysErr']                      = 'Die angegebenen Tage sollten als eine positive Zahl angegeben werden';
$GLOBALS['strAllowEmail']                            = 'Globale Einstellung: Versand von eMails erlaubt';
$GLOBALS['strEmailAddress']                          = 'Welche E-Mail Adresse soll als Absender bei Reports angegeben werden';
$GLOBALS['strEmailAddressName']                      = 'Firma oder Personenname mit welche(r/m) die eMails signiert werden sollen';
$GLOBALS['strWarnAdmin']				= "Warnung per E-Mail an den Administrator, wenn eine Kampagne ausgelaufen ist";
$GLOBALS['strWarnClient']				= "Warnung per E-Mail an den Werbetreibenden, wenn eine Kampagne ausgelaufen ist";
$GLOBALS['strWarnAgency']                            = 'Warnung per E-Mail an die Agentur kurz bevor eine Kampagne ausl&auml;uft';
$GLOBALS['strQmailPatch']				= "Kopfzeile auch f&uuml;r qMail lesbar machen";

// UI Settings
$GLOBALS['strGuiSettings']			= "Konfiguration Benutzerbereich (Inhaber des AdServers)";
$GLOBALS['strGeneralSettings']				= "Allgemeine Grundeinstellungen des Sytems";
$GLOBALS['strAppName']				= "Name oder Bezeichnung der Anwendung";
$GLOBALS['strMyHeader']				= "Kopfzeile im Admin-Bereich";
$GLOBALS['strMyHeaderError']		= "Die Datei f&uuml;r die Kopfzeile wurde an angegebenen Adresse nicht vorgefunden";
$GLOBALS['strMyFooter']				= "Fu&szlig;zeile im Admin-Bereich";
$GLOBALS['strMyFooterError']		= "Die Datei f&uuml;r die Fu&uuml;zeile wurde an angegebenen Adresse nicht vorgefunden";
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
$GLOBALS['strClientInterface']			= "Nutzeroberfl&auml;che f&uuml;r Werbetreibende";
$GLOBALS['strReportsInterface']                      = 'Nutzeroberfl&auml;che f&uuml;r Berichte';
$GLOBALS['strClientWelcomeEnabled']		= "Begr&uuml;&szlig;ungstext f&uuml;r Werbetreibende verwenden";
$GLOBALS['strClientWelcomeText']		= "Begr&uuml;&szlig;ungstext<br /><i>(HTML Tags sind zugelassen)</i>";

$GLOBALS['strPublisherInterface']                    = 'Nutzeroberfl&auml;che f&uuml;r Werbetr&auml;ger';
$GLOBALS['strPublisherAgreementEnabled']             = 'Login f&uuml;r Werbetr&auml;ger erlauben, die unsere Gesch&auml;ftsbedingungen nicht akzeptiert haben.';
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
