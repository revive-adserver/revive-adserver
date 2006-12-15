<?php

/*
+---------------------------------------------------------------------------+
| Max Media Manager v0.3                                                    |
| =================                                                         |
|                                                                           |
| Copyright (c) 2003-2006 m3 Media Services Limited                         |
| For contact details, see: http://www.m3.net/                              |
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
$Id: settings.lang.php 5631 2006-10-09 18:21:43Z andrew@m3.net $
*/

// German
// Installer translation strings
$GLOBALS['strInstall']				= "Installation";
$GLOBALS['strChooseInstallLanguage']		= "W&auml;hlen Sie die Sprache f&uuml;r den Installationsproze&szlig;";
$GLOBALS['strLanguageSelection']		= "Sprachauswahl";
$GLOBALS['strDatabaseSettings']			= "Datenbankeinstellungen";
$GLOBALS['strAdminSettings']			= "Einstellung f&uuml;r Administrator";
$GLOBALS['strAdvancedSettings']		= "Erg&auml;nzende Einstellungen";
$GLOBALS['strOtherSettings']			= "Andere Einstellungen";

$GLOBALS['strWarning']				= "Warnung";
$GLOBALS['strFatalError']			= "Ein schwerer Fehler ist aufgetreten";
$GLOBALS['strUpdateError']			= "W&auml;hrend des Updates ist ein Fehler aufgetreten";
$GLOBALS['strUpdateDatabaseError']	= "Aus unbekannten Gr&uuml;nden war die Aktualisierung der Datenbankstruktur nicht erfolgreich. Es wird empfohlen, zu versuchen, mit <b>Wiederhole Update</b> das Problem zu beheben. Sollte der Fehler - Ihrer Meinung nach - die Funktionalit&auml; von ".$phpAds_productname." nicht ber&uuml;hren, k&ouml;nnen Sie durch <b>Fehler ignorieren</b> fortfahren. Das Ignorieren des Fehlers wird nicht empfohlen!";
$GLOBALS['strAlreadyInstalled']			= $phpAds_productname." ist bereits auf diesem System installiert. Zur Konfiguration nutzen Sie das <a href='settings-index.php'>Konfigurationsmen&uuml;</a>";
$GLOBALS['strCouldNotConnectToDB']		= "Verbindung zur Datenbank war nicht m&ouml;glich. Bitte vorgenommene Einstellung pr&uuml;fen.";
$GLOBALS['strCreateTableTestFailed']		= "Der von Ihnen angegebene Nutzer hat nicht die notwendigen Zugriffsrechte, um die Datenbankstruktur anlegen zu k&ouml;nnen. Wenden Sie sich an den Systemverwalter.";
$GLOBALS['strUpdateTableTestFailed']		= " Der von Ihnen angegebene Nutzer hat nicht die notwendigen Zugriffsrechte, um die Datenbank zu aktualisieren. Wenden Sie sich an den Systemverwalter.";
$GLOBALS['strTablePrefixInvalid']		= "Ung&uuml;ltiges Vorzeichen (Pr&auml;fix) im Tabellennamen";
$GLOBALS['strTableInUse']			= "Die genannte Datenbank wird bereits von ".$phpAds_productname.", genutzt. Verwenden Sie einen anderes Pr&auml;fix oder lesen Sie im Handbuch die Hinweise f&uuml;r ein Upgrade.";
$GLOBALS['strTableWrongType']		= "Der gew&auml;hlte Tabellentype wird bei der Installation von ".$phpAds_dbmsname." nicht unterst&uuml;tzt";
$GLOBALS['strMayNotFunction']			= "Folgende Probleme sind zu beheben, um fortzufahren";
$GLOBALS['strFixProblemsBefore']		= "Folgende Teile m&uuml;ssen korrigiert werden, bevor der Installationsproze&szlig; von ".$phpAds_productname." fortgesetzt werden kann. Informationen &uuml;ber Fehlermeldungen finden sich im Handbuch.";
$GLOBALS['strFixProblemsAfter']			= "Sollten Sie die oben aufgef&uuml;hrten Fehler nicht selbst heben k&ouml;nnen, nehmen Sie Kontakt mit der Systemadministration Ihres Servers auf. Diese wird Ihnen weiterhelfen k&ouml;nnen.";
$GLOBALS['strIgnoreWarnings']			= "Ignoriere Warnungen";
$GLOBALS['strWarningDBavailable']		= "Die eingesetzte PHP-Version unterst&uuml;tzt nicht die Verbindung zum ".$phpAds_dbmsname." Datenbankserver. Die PHP- ".$phpAds_dbmsname."-Erweiterung wird ben&ouml;tigt.";
$GLOBALS['strWarningPHPversion']		= $phpAds_productname." ben&ouml;tigt PHP 4.0 oder h&ouml;her, um korrekt genutzt werden zu k&ouml;nnen. Sie nutzten {php_version}.";
$GLOBALS['strWarningRegisterGlobals']		= "Die PHP-Konfigurationsvaribable <i>register_globals</i> mu&szlig; gesetzt werden.";
$GLOBALS['strWarningMagicQuotesGPC']		= " Die PHP-Konfigurationsvaribable <i> magic_quotes_gpc</i> mu&szlig; gesetzt werden.";
$GLOBALS['strWarningMagicQuotesRuntime']	= " Die PHP-Konfigurationsvaribable <i> magic_quotes_runtime</i> mu&szlig; deaktiviert werden.";
$GLOBALS['strWarningFileUploads']		= " Die PHP-Konfigurationsvaribable <i> file_uploads</i> mu&szlig; gesetzt werden.";
$GLOBALS['strWarningTrackVars']			= " Die PHP-Konfigurationsvaribable <i> track_vars</i> mu&szlig; gesetzt werden.";
$GLOBALS['strWarningPREG']				= "Die verwendete PHP-Version unterst&uuml;tzt nicht PERL-kompatible Ausdr&uuml;cke. Um fortfahren zu k&ouml;nnen wird die PHP-Erweiterung <i>PREG</i> ben&ouml;tigt.";
$GLOBALS['strConfigLockedDetected']		= $phpAds_productname." hat erkannt, da&szlig; die Datei <b>config.inc.php</b> schreibgesch&uuml;tzt ist.<br /> Die Installation kann aber ohne Schreibberechtigung nicht fortgesetzt werden. <br />Weitere Informationen finden sich im Handbuch.";

$GLOBALS['strCantUpdateDB']  			= "Ein Update der Datenbank ist derzeit nicht m&ouml;glich. Wenn Sie die Installation fortsetzen, werden alle existierende Banner, Statistiken und Werbetreibenden gel&ouml;scht. ";
$GLOBALS['strIgnoreErrors']			= "Fehler ignorieren";
$GLOBALS['strRetryUpdate']			= "Wiederhole Update";
$GLOBALS['strTableNames']			= "Tabellenname";
$GLOBALS['strTablesPrefix']			= "Pr&auml;fix zum Tabellenname";
$GLOBALS['strTablesType']			= "Tabellentype";
$GLOBALS['strInstallWelcome']			= "Willkommen bei ".$phpAds_productname;
$GLOBALS['strInstallMessage']			= "Bevor ".$phpAds_productname." genutzt werden kann, m&uuml;ssen die Einstellungen konfiguriert  <br /> sowie die Datenbank geschaffen (create) werden. Dr&uuml;cken Sie <b>Weiter</b> , um fortzufahren.";
$GLOBALS['strInstallSuccess']			= "<b>die Installation von ".$phpAds_productname." war erfolgreich.</b><br /><br />Damit ".$phpAds_productname." korrekt arbeitet, mu&szlig; sichergestellt sein, da&szlig; das Wartungsmodul (maintenance.php) st&uuml;ndlich aktiviert wird. N&auml;here Informationen finden sich im Handbuch. <br /><br />
F&uuml;r weitere Einstellungen auf der Konfigurationsseite dr&uuml;cken Sie  <b>Weiter</b>.
<BR>
Der Schreibschutz der Datei <i>config.inc.php</i> sollte aus Sicherheitsgr&uuml;nden wieder gesetzt werden.";
$GLOBALS['strUpdateSuccess']		= "<b>Das Update von ".$phpAds_productname." war erfolgreich.</b><br /><br />
Damit ".$phpAds_productname." korrekt arbeitet, mu&szlig; sichergestellt sein, da&szlig; das Wartungsmodul (maintenance.php) st&uuml;ndlich aktiviert wird. N&auml;here Informationen finden sich im Handbuch. <br /><br />
F&uuml;r weitere Einstellungen auf der Konfigurationsseite dr&uuml;cken Sie  <b>Weiter</b>.
<BR>
Der Schreibschutz der Datei <i>config.inc.php</i> sollte aus Sicherheitsgr&uuml;nden wieder gesetzt werden.";

$GLOBALS['strInstallNotSuccessful']		= "<b>Die Installation von ".$phpAds_productname." war nicht erfolgreich</b><br /><br />
Teile des Installationsprozesses wurden nicht beendet. Das Problem ist m&ouml;glicherweise nur tempor&auml;r. In diesem Fall dr&uuml;cken Sie <b> Weiter</b> und beginnen Sie den Installationsproze&szlig; von neuem. N&auml;heres zu Fehlermeldungen und -behebung findet sich im Handbuch.";
$GLOBALS['strErrorOccured']			= "Der folgende Fehler ist aufgetreten:";
$GLOBALS['strErrorInstallDatabase']		= "Die Datenbankstruktur konnte nicht angelegt werden.";
$GLOBALS['strErrorUpgrade'] = 'Das Upgrade der Datenbank der bestehenden Installation ist fehlgeschlagen.';
$GLOBALS['strErrorInstallConfig']		= "Die Konfigurationsdatei oder die Datenbank konnten nicht aktualisiert werden.";
$GLOBALS['strErrorInstallDbConnect']		= "Eine Verbindung zur Datenbank war nicht m&ouml;glich.";

$GLOBALS['strUrlPrefix']			= "URL Pr&auml;fix";

$GLOBALS['strProceed']				= "Weiter &gt;";
$GLOBALS['strInvalidUserPwd']			= "Fehlerhafter Benutzername oder Passwort";

$GLOBALS['strUpgrade']				= "Prorammerg&uuml;nzung (Upgrade)";
$GLOBALS['strSystemUpToDate']		= "Das System ist up to date. Eine Erg&auml;nzung (Upgrade) ist nicht notwendig. <br />
Dr&uuml;cken Sie <b>Weiter</b>, um zur Startseite zu gelangen.";
$GLOBALS['strSystemNeedsUpgrade']		= "Die Datenbankstruktur und die Konfigurationsdateien sollten aktualisiert werden. Dr&uuml;cken Sie <b>Weiter</b> f&uuml;r den Start des Aktualisierungslaufes.
 <br /><br />Abh&auml;ngig von der derzeitig genutzten Version und der Anzahl der vorhandenen Statistiken kann dieser Proze&szlig; Ihre Datenbank stark belasten. Das Upgrade kann einige Minuten dauern.";
$GLOBALS['strSystemUpgradeBusy']		= "Aktualisierung des Systems l&auml;uft. Bitte warten ...";
$GLOBALS['strSystemRebuildingCache']		= "Cache wird neu erstellt. Bitte warten ...";
$GLOBALS['strServiceUnavalable']		= "Dieser Service ist zur Zeit nicht erreichbar. System wird aktualisiert...";

$GLOBALS['strConfigNotWritable']		= "F&uuml;r die Datei <i>config.inc.php</i>  besteht Schreibschutz";
//neu in MMM 0.3
$GLOBALS['strAdminUrlPrefix']               = "URL der Admin-Oberfl&auml;che";
$GLOBALS['strDeliveryUrlPrefix']            = "URL des Ad-Servers";
$GLOBALS['strDeliveryUrlPrefixSSL']         = "URL des Ad-Servers (SSL)";
$GLOBALS['strErrorInstallPrefs']            = "Die Voreinstellungen f&uuml;r den Adminsitrator-Account konnten nicht in die Datenbank &uuml;bernommen werden.";
$GLOBALS['strErrorInstallVersion']          = "Die Nummer der Max-Version konnte nicht in die Datenbank &uuml;bernommen werden.";
$GLOBALS['strImagesUrlPrefix']              = "URL des Verzeichnisses in dem die Grafiken gespeichert werden.";
$GLOBALS['strImagesUrlPrefixSSL']           = "URL des Verzeichnisses in dem die Grafiken gespeichert werden (SSL).";
$GLOBALS['strInvalidMySqlVersion']          = MAX_PRODUCT_NAME." ben&ouml;tigt MySQL 4.0 oder h&ouml;her um ordnungsgem&auml;&szlig; zu funktionieren. Bitte w&auml;hlen Sie einen anderen Datenbank-Server aus.";
$GLOBALS['strInvalidVersionInfo']           = "Versionsnummer der Datenbank-Software kann nicht ermittelt werden.";
$GLOBALS['strNoVersionInfo']                = "Die korrekte Versionsnummer der Datenbank-Software kann nicht ausgew&auml;hlt werden";
$GLOBALS['strSystemNeedsUpgrade']           = "Die Struktur der Datenbank und die Konfigurationsdatei m&uuml;ssen aktualisert werden um ordnungsgem&auml;&szlig; zu funktionieren. Klicken Sie auf <b>Weiter</b> um den Aktualisierungsproze&szlig; zu starten.<br /><br /> Die Dauer der Aktualisierung ist abh&auml;ngig von Versionsnummer Ihres Ad-servers und dem Umfang der Datenbank. Dieser Proze&szlig; kann Ihren Datenbank-Server sehr stark belasten und einige Minuten dauern.";
$GLOBALS['strUpdateSuccess']                = "<b>The upgrade von ".MAX_PRODUCT_NAME." war erfolgreich.</b><br /><br />Damit ".MAX_PRODUCT_NAME." korrekt funktioniert m&uuml;ssen Sie sicherstellen, da&szlig; die Wartungsdatei jede Stunde aufgerufen wird (in fr&uuml;heren Versionen mu&szlig;te diese Datei einmal t&auml;glich aufgerufen werden). Weitere Informationen zu diesem Thema finden Sie in der Dokumentation.<br /><br />Klicken Sie auf <b>Weiter</b>, um die Admin-Oberfl&auml;che des Ad-Servers aufzurufen. Vergessen Sie nicht, die Datei config.inc.php file auf Systemebene mit einem Schreibschutz zu versehen um unzul&auml;ssige Ver&auml;nderungen dieser Datei zu verhindern.";


/*-------------------------------------------------------*/
/* Configuration translations                            */
/*-------------------------------------------------------*/

// Global
$GLOBALS['strChooseSection']			= "Bereichsauswahl";
$GLOBALS['strDayFullNames'] 			= array("Sonntag","Montag","Dienstag","Mittwoch","Donnerstag","Freitag","Samstag");
$GLOBALS['strEditConfigNotPossible']   		= "&Auml;nderungen der Systemeinstellung nicht m&ouml;glich. F&uuml;r die Konfigurationsdatei  <i>config.inc.php</i> besteht Schreibschutz. ".
										  "F&uuml;r &Auml;nderungen mu&szlig; der Schreibschutz aufgehoben werden.";
$GLOBALS['strEditConfigPossible']		= "Unbefugte System&auml;nderungen sind m&ouml;glich. Die Zugriffsrechte der Konfigurationsdatei <i>config.inc.php</i> sind auf Schreibbrechtigung gesetzt. ".
										  "Zur Sicherung des Systems sollte der Schreibschutz gesetzt werden. N&auml;here Informationen im Handbuch.";
//neu in MMM 0.3
$GLOBALS['strUnableToWriteConfig']                   = 'Die &Auml;nderungen konnten nicht in die Konfigurationsdatei &uuml;bernommen werden';
$GLOBALS['strUnableToWritePrefs']                    = 'Die Voreinstellungen konnten nicht in die Datenbank geschrieben werden.';

// neu in MMM 0.3 (General Settings)
$GLOBALS['generalSettings']                          = 'Allgemeine Grundeinstellungen des Sytems';
$GLOBALS['uiEnabled']                                = 'Nutzer-Interface aktivieren';
$GLOBALS['defaultLanguage']                          = 'Standard-Sprache<br />(Jeder Nutzer kann seine eigene Systemsprache w&auml;hlen)';
$GLOBALS['requireSSL']                               = 'Erzwinge SSL-Zugang zum Nutzer-Interface';
$GLOBALS['sslPort']                                  = 'Vom Web-Server genutzer SSL-Port';

// Database
$GLOBALS['strDatabaseSettings']			= "Datenbankeinstellungen";
$GLOBALS['strDatabaseServer']			= "Datenbank Server";
$GLOBALS['strDbLocal']				= "Verbindung zum lokalen Server mittels Sockets"; // Pg only
$GLOBALS['strDbHost']				= "Datenbank Hostname";
$GLOBALS['strDbPort']				= "Datenbank Portnummer";
$GLOBALS['strDbUser']				= "Datenbank Benutzername";
$GLOBALS['strDbPassword']			= "Datenbank Passwort";
$GLOBALS['strDbName']			= "Datenbank Name";

$GLOBALS['strDatabaseOptimalisations']		= " Datenbank Optimierung";
$GLOBALS['strPersistentConnections']		= "Dauerhafte (persistente) Verbindung zur Datenbank";
$GLOBALS['strCompatibilityMode']		= "Kompatibilit&auml;tsmodus (Datenbank)";
$GLOBALS['strCantConnectToDb']		= "Verbindung zur Datenbank nicht m&ouml;glich";
//neu in MMM 0.3
$GLOBALS['strDbType']                                = 'Datenbank Typ';

//Invocation neu in MMM 0.3
$GLOBALS['strInvocationAndDelivery']                 = 'Einstellungen Bannercode';
$GLOBALS['strAllowedInvocationTypes']                = 'Allowed Invocation Types';
$GLOBALS['strIncovationDefaults']                    = 'Incovation Defaults';
$GLOBALS['strEnable3rdPartyTrackingByDefault']       = 'Enable 3rd Party Clicktracking by Default';

// Invocation and Delivery
$GLOBALS['strUseAcl']				= "Einschr&auml;nkungen w&auml;hrend der Bannerauslieferung werden ber&uuml;cksichtigt";
$GLOBALS['strDeliverySettings']			= "Einstellungen f&uuml;r Bannerauslieferung";
$GLOBALS['strCacheType']			= "Cache-Type f&uuml;r Bannerauslieferung";
$GLOBALS['strCacheFiles']			= "Dateien";
$GLOBALS['strCacheDatabase']			= "Datenbank";
$GLOBALS['strCacheShmop']			= "Shared memory/Shmop";
$GLOBALS['strCacheSysvshm']			= "Shared memory/Sysvshm";
$GLOBALS['strExperimental']			= "Experimentell";
$GLOBALS['strKeywordRetrieval']		= "Schl&uuml;sselwortselektion";
$GLOBALS['strBannerRetrieval']			= "Modus f&uuml;r Bannerselektion";
$GLOBALS['strRetrieveRandom']			= "Zufallsbasierte Bannerselektion (Voreinstellung)";
$GLOBALS['strRetrieveNormalSeq']		= "Sequentielle Bannerselektion";
$GLOBALS['strWeightSeq']			= "Gewichtungsabh&auml;ngige Bannerselektion ";
$GLOBALS['strFullSeq']				= " Streng sequentielle Bannerselektion ";
$GLOBALS['strUseConditionalKeys']		= "Logische Operatoren sind bei Direktselektion zul&auml;ssig ";
$GLOBALS['strUseMultipleKeys']			= "Mehrere Schl&uuml;sselw&ouml;rter sind f&uuml;r die Direktselektion zugelassen ";
$GLOBALS['strZonesSettings']			= "Selektion &uuml;ber Zonen";
$GLOBALS['strZoneCache']			= "Einrichten von Zwischenspeichern (Cache) f&uuml;r Zonen. Beschleunigt die Bannerauslieferung";
$GLOBALS['strZoneCacheLimit']			= "Aktualisierungsintervall der Zwischenspeicher (Cache) in Sekunden";
$GLOBALS['strZoneCacheLimitErr']		= "Aktualisierungsintervall mu&szlig; ein positiver ganzzahliger Wert sein";
$GLOBALS['strP3PSettings']			= "P3P-Datenschutzrichtlinien";
$GLOBALS['strUseP3P']				= "Verwendung von P3P-Richtlinien";
$GLOBALS['strP3PCompactPolicy']		= "P3P-Datenschutzrichtlinien (kompakte Form)";
$GLOBALS['strP3PPolicyLocation']		= "Speicherort der P3P-Richtlinien";
//neu in MMM 0.3 (delivery settings)
$GLOBALS['strDeliveryAcls']                          = '&Uuml;berpr&uuml;fe die Auslieferungseinschr&auml;nkungen eines Banners w&auml;hrend der Auslieferung';
$GLOBALS['strDeliveryBanner']                        = 'Allgemeine Einstellungen der Werbemittelauslieferung';
$GLOBALS['strDeliveryCacheEnable']                   = 'Auslieferungs-Cache aktivieren';
$GLOBALS['strDeliveryCacheLimit']                    = 'Zeitintervall zwischen Cache-Aktualisierungen (in Sek.)';
$GLOBALS['strDeliveryCacheType']                     = 'Typ des Auslieferungs-Caches';
$GLOBALS['strDeliveryCaching']                       = 'Allgemeine Einstellungen des Auslieferungs-Caches';
$GLOBALS['strDeliveryCtDelimiter']                   = 'Begrenzung des 3rd Party Kick-Trackings';
$GLOBALS['strDeliveryExecPhp']                       = 'PHP-Code in Werbemitteln wird ausgef&uuml;hrt<br />(Achtung: Starkes Sicherheitsrisiko)';
$GLOBALS['strDeliveryFilenames']                     = 'Namen der Dateien, die das System zur Werbemittelauslieferung nutzt';
$GLOBALS['strDeliveryFilenamesAdClick']              = 'Ad Click';
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
$GLOBALS['strDeliveryFilenamesAdConversionVars']     = 'Ad Conversion Variablen';
$GLOBALS['strDeliveryObfuscate']                     = 'Bei der Auslieferung die Gruppe eines Werbemittels verschleiern';
$GLOBALS['strOrigin']                                = 'Nutze remote origin server';
$GLOBALS['strOriginType']                            = 'Origin server Typ';
$GLOBALS['strOriginHost']                            = 'Hostname des origin server';
$GLOBALS['strOriginPort']                            = 'Port-Nummer der origin Datenbank';
$GLOBALS['strOriginScript']                          = 'Script-Datei f&uuml;r origin Datenbank';
$GLOBALS['strOriginTypeXMLRPC']                      = 'XMLRPC';
$GLOBALS['strOriginTimeout']                         = 'Origin timeout (Sekunden)';
$GLOBALS['strOriginProtocol']                        = 'Origin-Server Protokoll';

$GLOBALS['strP3PSettings']                           = 'P3P-Datenschutzrichtlinien';
$GLOBALS['strP3PCompactPolicy']                      = 'P3P-Datenschutzrichtlinien (kompakte Form)';
$GLOBALS['strP3PPolicyLocation']                     = 'Speicherort der P3P-Richtlinien';

$GLOBALS['strTypeDirError']                          = 'Der Web-Server hat keine Schreibrechte auf das lokale Verzeichnis';

$GLOBALS['strTypeFTPDirectory']                      = 'Host-Verzeichnis';
$GLOBALS['strTypeFTPUsername']                       = 'Login';
$GLOBALS['strTypeFTPPassword']                       = 'Passwort';
$GLOBALS['strTypeFTPErrorDir']                       = 'Das angegebene Verzeichnis auf dem FTP-Host exisitiert nicht';
$GLOBALS['strTypeFTPErrorConnect']                   = 'Verbindung zum FTP-Server nicht m&ouml;glich, da Nutzername oder Passwort falsch sind';
$GLOBALS['strTypeFTPErrorHost']                      = 'Der FTP-Host is nicht korrekt';

$GLOBALS['strTypeWebDir']                            = 'Lokales Verzeichnis';
$GLOBALS['strWebPath']                               = '&Uuml;bersicht ' . MAX_PRODUCT_NAME . ' Server-Pfade';
$GLOBALS['strTypeWebSettings']                       = 'Allgemeine Einstellungen zur lokalen Speicherung von Werbemitteln';
$GLOBALS['strTypeWebMode']                           = 'Speicherart';
$GLOBALS['strTypeWebModeLocal']                      = 'Lokales Verzeichnis';
$GLOBALS['strTypeDirError']                          = 'Der Web-Server hat keine Schreibrechte auf das lokale Verzeichnis';
$GLOBALS['strTypeWebModeFtp']                        = 'Externer FTP-Server';

// Banner Settings
$GLOBALS['strBannerSettings']			= "Bannereinstellungen";
$GLOBALS['strAllowedBannerTypes']		= "Zugelassene Bannertypen (Mehrfachnennung m&ouml;glich)";
$GLOBALS['strTypeSqlAllow']			= "Banner in Datenbank speichern (SQL)";
$GLOBALS['strTypeWebAllow']			= "Banner auf Web-Server (lokal)";
$GLOBALS['strTypeUrlAllow']			= "Banner &uuml;ber URL verwalten";
$GLOBALS['strTypeHtmlAllow']			= "HTML-Banner";
$GLOBALS['strTypeTxtAllow']			= "Textanzeigen";

$GLOBALS['strTypeWebSettings']		= "Bannerkonfiguration auf Web-Server (lokal)";
$GLOBALS['strTypeWebMode']			= "Speichermethode";
$GLOBALS['strTypeWebModeLocal']		= "Lokales Verzeichnis";
$GLOBALS['strTypeWebModeFtp']		= "Externer FTP-Server";
$GLOBALS['strTypeWebDir']			= "Web-Server-Verzeichnis";
$GLOBALS['strTypeWebFtp']			= "FTP-Bannerserver";
$GLOBALS['strTypeWebUrl']			= "(&ouml;ffentliche) URL";
$GLOBALS['strTypeWebSslUrl']			= "(&ouml;ffentliche) URL (SSL)";
$GLOBALS['strTypeFTPHost']			= "FTP-Host";
$GLOBALS['strTypeFTPDirectory']		= "FTP-Verzeichnis";
$GLOBALS['strTypeFTPUsername']		= "FTP-Benutzername";
$GLOBALS['strTypeFTPPassword']		= "FTP-Passwort";
$GLOBALS['strTypeFTPErrorDir']		= "FTP-Verzeichnis existiert nicht";
$GLOBALS['strTypeFTPErrorConnect']		= "Verbindung zum FTP Server nicht m&ouml;glich. Benutzername oder Passwort waren fehlerhaft";
$GLOBALS['strTypeFTPErrorHost']			= "Hostname f&uuml;r FTP-Server ist fehlerhaft";
$GLOBALS['strTypeDirError']				= "Das lokale Verzeichnis existiert nicht";



$GLOBALS['strDefaultBanners']			= "Ersatzbanner <i>(kein regul&auml;res Banner steht zur Verf&uuml;gung)</i>";
$GLOBALS['strDefaultBannerUrl']		= "Bild-URL f&uuml;r Ersatzbanner";
$GLOBALS['strDefaultBannerDestination']      = 'Ziel-URL f&uuml;r Ersatzbanner';
$GLOBALS['strTypeHtmlSettings']		= "Optionen f&uuml;r HTML-Banner";

$GLOBALS['strTypeHtmlAuto']			= "HTML-Code zum Aufzeichnen der AdClicks modifizieren";
$GLOBALS['strTypeHtmlPhp']			= "Ausf&uuml;hrbarer PHP-Code ist in HTML-Banner zugelassen ";



// Host information and Geotargeting
$GLOBALS['strHostAndGeo']			= "Geotargeting (Hostinformation und Standortbestimmung) der Besucher";

$GLOBALS['strRemoteHost']			= "Host des Besuchers";
$GLOBALS['strReverseLookup']			= "Es wird versucht, den Name des Hosts f&uuml;r den Besucher zu ermitteln, wenn er nicht mitgeliefert wird";
$GLOBALS['strProxyLookup']				= "Es wird versucht, die  IP-Adresse des Besuchers zu ermitteln, wenn er einen Proxy-Server nutzt";

$GLOBALS['strGeotargeting']			= "Allgemeine Einstellungen Geotargeting";
$GLOBALS['strGeotrackingType']			= "Datenbanktypen f&uuml;r Geotargeting ";
$GLOBALS['strGeotrackingLocation'] 		= "Standort der Datenbank f&uuml;r Geotargeting";
$GLOBALS['strGeotrackingLocationError'] = "Keine Datenbank f&uuml;r Geotargeting an der genannten Adresse gefunden";
$GLOBALS['strGeoStoreCookie']			= "Speichern des Ergebnisses in einem Cookie zur sp&auml;teren Nutzung";
//neu in MMM 0.3 (Geotargeting)
$GLOBALS['strGeoSaveStats']                          = 'Speichere die GeoIP-Daten in den Datenbank-Logs';
$GLOBALS['strGeoShowUnavailable']                    = 'Zeige die durch Geotargeting verursachten Auslieferungslimitierungen an, auch wenn keine GeoIP-Daten verf&uuml;gbar sind';
$GLOBALS['strGeotargetingSettings']                  = 'Einstellungen Geotargeting';
$GLOBALS['strGeotargetingType']                      = 'Geotargeting Modultyp';
$GLOBALS['strGeotargetingGeoipCountryLocation']      = 'Speicherort der MaxMind GeoIP L&auml;nderdatenbank<br />(Leer lassen um freie Datenbank zu nutzen)';
$GLOBALS['strGeotargetingGeoipRegionLocation']       = 'Speicherort der MaxMind GeoIP Regionendatenbank';
$GLOBALS['strGeotargetingGeoipCityLocation']         = 'Speicherort der MaxMind GeoIP St&auml;dtedatenbank';
$GLOBALS['strGeotargetingGeoipAreaLocation']         = 'Speicherort der MaxMind GeoIP Gebietsdatenbank';
$GLOBALS['strGeotargetingGeoipDmaLocation']          = 'Speicherort der MaxMind GeoIP DMA-Databank (nur USA)';
$GLOBALS['strGeotargetingGeoipOrgLocation']          = 'Speicherort der MaxMind GeoIP Organisationendatenbank';
$GLOBALS['strGeotargetingGeoipIspLocation']          = 'Speicherort der MaxMind GeoIP ISP-Datenbank';
$GLOBALS['strGeotargetingGeoipNetspeedLocation']     = 'Speicherort der MaxMind GeoIP Bandbreitendatenbank';
$GLOBALS['strGeotrackingGeoipCountryLocationError']  = 'Die MaxMind GeoIP L&auml;nderdatenbank konnte im angegebenen Verzeichnis nicht gefunden werden';
$GLOBALS['strGeotrackingGeoipRegionLocationError']   = 'Die MaxMind GeoIP Regionendatenbank konnte im angegebenen Verzeichnis nicht gefunden werden';
$GLOBALS['strGeotrackingGeoipCityLocationError']     = 'Die MaxMind GeoIP St&auml;dtedatenbank konnte im angegebenen Verzeichnis nicht gefunden werden';
$GLOBALS['strGeotrackingGeoipAreaLocationError']     = 'Die MaxMind GeoIP Gebietsdatenbank konnte im angegebenen Verzeichnis nicht gefunden werden';
$GLOBALS['strGeotrackingGeoipDmaLocationError']      = 'Die MaxMind GeoIP DMA-Datenbank konnte im angegebenen Verzeichnis nicht gefunden werden';
$GLOBALS['strGeotrackingGeoipOrgLocationError']      = 'Die MaxMind GeoIP Organisationendatenbank konnte im angegebenen Verzeichnis nicht gefunden werden';
$GLOBALS['strGeotrackingGeoipIspLocationError']      = 'Die MaxMind GeoIP ISP-Datenbank konnte im angegebenen Verzeichnis nicht gefunden werden';
$GLOBALS['strGeotrackingGeoipNetspeedLocationError'] = 'Die MaxMind GeoIP Bandbreitendatenbank konnte im angegebenen Verzeichnis nicht gefunden werden';


// Statistics Settings
$GLOBALS['strStatisticsSettings']			= "Statistikeinstellungen";

$GLOBALS['strStatisticsFormat']			= "Statistikformat";
$GLOBALS['strCompactStats']				= " Statistikformat ";
$GLOBALS['strLogAdviews']				= "Jede Bannerauslieferung wird als ein AdView protokolliert";
$GLOBALS['strLogAdclicks']				= "Jeder Klick auf ein Banner wird als ein AdClick protokolliert";
$GLOBALS['strLogSource']				= "Die Parameter der Quelle werden  bei der Bannerauslieferung protokolliert";
$GLOBALS['strGeoLogStats']				= "Das Land des Besuchers wird protokolliert";
$GLOBALS['strLogHostnameOrIP']			= "Hostname oder IP-Adresse des Besuchers wird protokolliert";
$GLOBALS['strLogIPOnly']				= "Ausschlie&szlig;lich die IP-Adresse des Besuchers wird protokolliert, auch wenn der Hostname erkannt ist";
$GLOBALS['strLogIP']					= "Die IP-Adresse des Besuchers wird protokolliert";
$GLOBALS['strLogBeacon']				= " Ein Beacon (1x1-Pixel) wird verwendet, um sicherzustellen, da&szlig; nur vollst&auml;ndige Bannerauslieferungen protokolliert werden ";

$GLOBALS['strRemoteHosts']				= "Host des Besuchers";
$GLOBALS['strIgnoreHosts']				= "AdViews und AdClicks f&uuml;r Besucher mit folgenden IP-Adressen oder Hostnamen bleiben in den Statistiken unber&uuml;cksichtigt";
$GLOBALS['strBlockAdViews']				= "Reloadsperre (Zeitraum in Sek.)";
$GLOBALS['strBlockAdClicks']			= " Reclicksperre (Zeitraum in Sek.) ";

$GLOBALS['strPreventLogging']			= "Protokollieren verhindern";
$GLOBALS['strEmailWarnings']			= "Warnungen per E-Mail";
$GLOBALS['strAdminEmailHeaders']		= "Kopfzeile f&uuml;r alle E-Mails, die versandt werden";
$GLOBALS['strWarnLimit']				= "Warnung per E-Mail bei Unterschreiten der definierten Untergrenze";
$GLOBALS['strWarnLimitErr']				= "Warnlimit mu&szlig; eine positive Ganzzahl sein";
$GLOBALS['strWarnAdmin']				= "Warnung per E-Mail an den Administrator, wenn eine Kampagne ausgelaufen ist";
$GLOBALS['strWarnClient']				= "Warnung per E-Mail an den Werbetreibenden, wenn eine Kampagne ausgelaufen ist";
$GLOBALS['strQmailPatch']				= "Kopfzeile auch f&uuml;r qMail lesbar machen";

$GLOBALS['strAutoCleanTables']			= "Datenbank l&ouml;schen";
$GLOBALS['strAutoCleanStats']			= "Statistiken l&ouml;schen";
$GLOBALS['strAutoCleanUserlog']		= "Benutzerprotokoll l&ouml;schen";
$GLOBALS['strAutoCleanStatsWeeks']		= "Zeitraum in Wochen, nachdem Statistiken gel&ouml;scht werden <br /><i>(jedoch mindestens 3 Wochen)</i>";
$GLOBALS['strAutoCleanUserlogWeeks']		= "Zeitraum in Wochen, nachdem Statistiken gel&ouml;scht werden <br /><i>(3 Wochen mindestens)</i>";
$GLOBALS['strAutoCleanErr']			= "Der Zeitraum, nach dem die Daten gel&ouml;scht werden sollen, mu&szlig; mindestens 3 Wochen betragen";
$GLOBALS['strAutoCleanVacuum']		= "VACUUM ANALYZE Tabellen jede Nacht"; // only Pg

//neu in MMM 0.3 (mit alten Werten oben abstimmen)
$GLOBALS['strBlockAdViewsError']                     = 'Intervall f&uuml;r Reload-Sperre mu&szlig; eine positive ganze Zahl sein';
$GLOBALS['strBlockAdClicksError']                    = 'Intervall f&uuml;r Reklick-Sperre mu&szlig; eine positive ganze Zahl sein';
$GLOBALS['strBlockAdConversions']                    = 'Keine Tracker-Impression protokollieren, wenn der Nutzer die Seite mit dem Tracker-Code im angegeben Zeitintervall gesehen hat (in Sekunden)';
$GLOBALS['strBlockAdConversionsError']               = 'Intervall f&uuml;r Tracking-Sperre mu&szlig; eine positive ganze Zahl sein';
$GLOBALS['strDefaultImpConWindow']                   = 'Standard Ad Impression Connection Window (Sekunden)';
$GLOBALS['strDefaultImpConWindowError']              = 'Wenn gesetzt, mu&szlig; der Standard Ad Impression Connection Window eine positive ganze Zahl sein';
$GLOBALS['strDefaultCliConWindow']                   = 'Standard Ad Click Connection Window (Sekunden)';
$GLOBALS['strDefaultCliConWindowError']              = 'Wenn gesetzt, mu&szlig; der Standard Ad Click Connection Window eine positive ganze Zahl sein';
$GLOBALS['strLogAdRequests']                         = 'Protokolliere bei jedem Aufruf eines Werbemittels auf dem Server einen Ad Request';
$GLOBALS['strLogAdImpressions']                      = 'Protokolliere eine Ad Impression, wenn ein Werbemittel beim Nutzer angekommen ist (Truecount)';
$GLOBALS['strLogAdClicks']                           = 'Protoklliere einen Ad Click , wenn ein Nutzer auf ein Werbemittel klickt';
$GLOBALS['strLogTrackerImpressions']                 = 'Protokolliere eine Tracker Impression, wenn ein Nutzer eine Seite mit Tracker-Code vollst&auml;ndig l&auml;dt.';

$GLOBALS['strMaintenaceSettings']                    = 'Allgemine Wartungseinstellungen';
$GLOBALS['strMaintenanceAdServerInstalled']          = 'Verarbeite Statistiken der Ad-Server-Module';
$GLOBALS['strMaintenanceTrackerInstalled']           = 'Verarbeite Statistiken f&uuml;r Tracker-Module';
$GLOBALS['strMaintenanceOI']                         = 'Wartungsintervall (in Minuten)';
$GLOBALS['strMaintenanceOIError']                    = 'Dieses Wartungsintervall ist nicht zul&auml;ssig - bitte konsultieren Sie die Dokumentation';
$GLOBALS['strMaintenanceCompactStats']               = 'L&ouml;schen der Original-Statistiken nach der Verarbeitung?';
$GLOBALS['strMaintenanceCompactStatsGrace']          = 'Karenzzeit bevor verarbeitete Statistiken gel&ouml;scht werden (Sekunden)';
$GLOBALS['strPrioritySettings']                      = 'Allgemeine Dringlichkeitseinstellungen';
$GLOBALS['strPriorityInstantUpdate']                 = 'Aktualisiere Werbemittel die &auml;lter sind als...';
$GLOBALS['strSniff']                = 'Bestimme das Betriebssystem und den Browsertyp eines Besuchers mit phpSniff';
$GLOBALS['strStatisticsLogging']                     = 'Allgemeine Protokollierungseinstellungen';
$GLOBALS['strWarnAgency']                            = 'Warnung per E-Mail an die Agentur kurz bevor eine Kampagne ausl&auml;uft';
$GLOBALS['strWarnCompactStatsGrace']                 = 'Die Karenzzeit bevor die Statistiken kompaktiert werden mu&szlig; eine positive ganze Zahl sein';

// Administrator settings
$GLOBALS['strAdministratorSettings']		= "Einstellungen f&uuml;r Administrator";
$GLOBALS['strLoginCredentials']			= "Login";
$GLOBALS['strAdminUsername']			= "Benutzername (Admin)";
$GLOBALS['strInvalidUsername']			= "Benutzername fehlerhaft";
$GLOBALS['strBasicInformation']			= "Basisinformation";
$GLOBALS['strAdminFullName']			= "Vorname Name";
$GLOBALS['strAdminEmail']			= "E-Mail";
$GLOBALS['strCompanyName']			= "Firma";
$GLOBALS['strAdminCheckUpdates']		= "Pr&uuml;fen, ob neue Programmversionen vorhanden sind";
$GLOBALS['strAdminCheckEveryLogin']		= "Bei jedem Login";
$GLOBALS['strAdminCheckDaily']		= "T&auml;glich";
$GLOBALS['strAdminCheckWeekly']		= "W&ouml;chentlich";
$GLOBALS['strAdminCheckMonthly']		= "Monatlich";
$GLOBALS['strAdminCheckNever']		= "Nie";
$GLOBALS['strAdminNovice']			= "L&ouml;schvorg&auml;nge im Admin-Bereich nur mit Sicherheitsbest&auml;tigung";
$GLOBALS['strUserlogEmail']			= "Alle ausgehenden E-Mails protokollieren ";
$GLOBALS['strUserlogPriority']			= "St&uuml;ndliche Rekalkulation der Priorit&auml;ten wird protokolliert";
$GLOBALS['strUserlogAutoClean']		= "Protokollieren des S&auml;uberns der Datenbank";

//User interface settings
$GLOBALS['strGuiSettings']			= "Konfiguration Benutzerbereich (Inhaber des AdServers)";

$GLOBALS['strGeneralSettings']				= "Allgemeine Grundeinstellungen des Sytems";
$GLOBALS['strAppName']				= "Name oder Bezeichnung der Anwendung";
$GLOBALS['strMyHeader']				= "Kopfzeile im Admin-Bereich";
$GLOBALS['strMyHeaderError']		= "Die Datei f&uuml;r die Kopfzeile wurde an angegebenen Adresse nicht vorgefunden";
$GLOBALS['strMyFooter']				= "Fu&szlig;zeile im Admin-Bereich";
$GLOBALS['strMyFooterError']		= "Die Datei f&uuml;r die Fu&uuml;zeile wurde an angegebenen Adresse nicht vorgefunden";
$GLOBALS['strGzipContentCompression']		= "Komprimieren mit GZIP";

$GLOBALS['strClientInterface']			= "Nutzeroberfl&auml;che f&uuml;r Werbetreibende";
$GLOBALS['strClientWelcomeEnabled']		= "Begr&uuml;&szlig;ungstext f&uuml;r Werbetreibende verwenden";
$GLOBALS['strClientWelcomeText']		= "Begr&uuml;&szlig;ungstext<br /><i>(HTML Tags sind zugelassen)</i>";
//neu in MMM 0.3
$GLOBALS['strColorError']                            = 'Bitte geben Sie die Farben im RGB-Format an, z.B. \'0066CC\'';
$GLOBALS['strDefaultTrackerStatus']                  = 'Standardstatus Tracker';
$GLOBALS['strGuiHeaderForegroundColor']              = 'Vordergrundfarbe der Kopfzeile';
$GLOBALS['strGuiHeaderBackgroundColor']              = 'Hintergrundfarbe der Kopfzeile';
$GLOBALS['strGuiActiveTabColor']                     = 'Farbe des aktiven Reiters';
$GLOBALS['strGuiHeaderTextColor']                    = 'Textfarbe in der Kopfzeile';
$GLOBALS['strMyLogo']                                = 'Name der individuellen Logo-Datei';
$GLOBALS['strMyLogoError']                           = 'Diese Logo-Datei  ist im Verzeichnis admin/images nicht vorhanden';

// Interface defaults
$GLOBALS['strInterfaceDefaults']		= "Einstellungen der Nutzeroberfl&auml;che";

$GLOBALS['strInventory']			= "Inventar-Seiten";
$GLOBALS['strShowCampaignInfo']		= "Anzeigen zus&auml;tzlicher Informationen auf der Seite <i>&Uuml;bersicht Kampagnen</i>";
$GLOBALS['strShowBannerInfo']			= "Anzeigen zus&auml;tzlicher Werbemittelinformationen auf der Seite <i>&uuml;bersicht Werbemittel</i> ";
$GLOBALS['strShowCampaignPreview']		= "Vorschau aller Werbemittel auf der Seite  <i>&Uuml;bersicht Werbemittel</i>";
$GLOBALS['strShowBannerHTML']			= "Anzeige des Banners anstelle des HTML-Codes bei Vorschau von HTML-Bannern";
$GLOBALS['strShowBannerPreview']		= "Werbemittelvorschau oben auf allen Seiten mit Bezug zum Werbemittel";
$GLOBALS['strHideInactive']			= "Verbergen inaktiver Elemente auf den &Uuml;bersichtsseiten";
$GLOBALS['strGUIShowMatchingBanners']		= "Anzeige des zugeh&ouml;renden Werbemittels auf der Seite <i>Verkn&uuml;pfte Werbemittel</i>";
$GLOBALS['strGUIShowParentCampaigns']		= "Anzeige der zugeh&ouml;renden Kampagne auf der Seite <i>Vekn&uuml;pfte Werbemittel</i>";
$GLOBALS['strGUILinkCompactLimit']		= "Verbergen nicht verkn&uuml;pfter Werbemittel auf der Seite <i>Verkn&uuml;pfte Werbemittel </i>, sofern es mehr sind als ";

$GLOBALS['strStatisticsDefaults'] 		= "Statistiken";
$GLOBALS['strBeginOfWeek']			= "Wochenbeginn";
$GLOBALS['strPercentageDecimals']		= "Dezimalstellen bei Prozentangaben";

$GLOBALS['strWeightDefaults']			= "Gewichtung (Voreinstellung)";
$GLOBALS['strDefaultBannerWeight']		= "Bannergewichtung (Voreinstellung)";
$GLOBALS['strDefaultCampaignWeight']		= "Kampagnengewichtung (Voreinstellung)";
$GLOBALS['strDefaultBannerWErr']		= "Voreinstellung f&uuml;r Bannergewichtung mu&szlig; eine positive Ganzzahl sein";
$GLOBALS['strDefaultCampaignWErr']		= " Voreinstellung f&uuml;r Kampagne mu&szlig; eine positive Ganzzahl sein";


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
$GLOBALS['strDebugUsername']                         = 'mCal, SQL-Server Nutzername';
$GLOBALS['strDebugPassword']                         = 'mCal, SQL-Server Pa&szlig;wort';

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
