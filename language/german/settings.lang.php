<?php // $Revision: 1.19.2.1 $

/************************************************************************/
/* phpAdsNew 2                                                          */
/* ===========                                                          */
/*                                                                      */
/* Copyright (c) 2000-2003 by the phpAdsNew developers                  */
/* For more information visit: http://www.phpadsnew.com                 */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/


// German
// Installer translation strings
$GLOBALS['strInstall']				= "Installation";
$GLOBALS['strChooseInstallLanguage']		= "Wählen Sie die Sprache für den Installationsprozeß";
$GLOBALS['strLanguageSelection']		= "Sprachauswahl";
$GLOBALS['strDatabaseSettings']			= "Datenbankeinstellungen";
$GLOBALS['strAdminSettings']			= "Einstellung für Administrator";
$GLOBALS['strAdvancedSettings']		= "Ergänzende Einstellungen";
$GLOBALS['strOtherSettings']			= "Andere Einstellungen";

$GLOBALS['strWarning']				= "Warnung";
$GLOBALS['strFatalError']			= "Ein schwerer Fehler ist aufgetreten";
$GLOBALS['strUpdateError']			= "Während des Updates ist ein Fehler aufgetreten";
$GLOBALS['strUpdateDatabaseError']	= "Aus unbekannten Gründen war die Aktualisierung der Datenbankstruktur nicht erfolgreich. Es wird empfohlen, zu versuchen, mit <b>Wiederhole Update</b> das Problem zu beheben. Sollte der Fehler - Ihrer Meinung nach - die Funktionalität von ".$phpAds_productname." nicht berühren, können Sie durch <b>Fehler ignorieren</b>  fortfahren. Das Ignorieren des Fehlers wird nicht empfohlen!";
$GLOBALS['strAlreadyInstalled']			= $phpAds_productname." ist bereits auf diesem System installiert. Zur Konfiguration nutzen Sie das <a href='settings-index.php'>Konfigurationsmenü</a>"; 
$GLOBALS['strCouldNotConnectToDB']		= "Verbindung zur Datenbank war nicht möglich. Bitte vorgenommene Einstellung prüfen.";
$GLOBALS['strCreateTableTestFailed']		= "Der von Ihnen angegebene Nutzer hat nicht die notwendigen Zugriffsrechte, um die Datenbankstruktur anlegen zu können. Wenden Sie sich an den Systemverwalter.";
$GLOBALS['strUpdateTableTestFailed']		= " Der von Ihnen angegebene Nutzer hat nicht die notwendigen Zugriffsrechte, um die Datenbank zu aktualisieren. Wenden Sie sich an den Systemverwalter.";
$GLOBALS['strTablePrefixInvalid']		= "Ungültiges Vorzeichen (Präfix) im Tabellennamen";
$GLOBALS['strTableInUse']			= "Die genannte Datenbank wird bereits von ".$phpAds_productname.", genutzt. Verwenden Sie einen anderen Präfix oder lesen Sie im Handbuch die Hinweise für ein Upgrade.";
$GLOBALS['strTableWrongType']		= "Der gewählte Tabellentype wird bei der Installation von ".$phpAds_dbmsname." nicht unterstützt";
$GLOBALS['strMayNotFunction']			= "Folgende Probleme sind zu beheben, um fortzufahren";
$GLOBALS['strFixProblemsBefore']		= "Folgende Teile müssen korrigiert werden, bevor der Installationsprozeß von ".$phpAds_productname." fortgesetzt werden kann. Informationen über Fehlermeldungen finden sich im Handbuch.";
$GLOBALS['strFixProblemsAfter']			= "Sollten Sie die oben aufgeführten Fehler nicht selbst heben können, nehmen Sie Kontakt mit der Systemadministration Ihres Servers auf. Diese wird Ihnen weiterhelfen können.";
$GLOBALS['strIgnoreWarnings']			= "Ignoriere Warnungen";
$GLOBALS['strWarningDBavailable']		= "Die eingesetzte PHP-Version unterstützt nicht die Verbindung zum ".$phpAds_dbmsname." Datenbankserver. Die PHP- ".$phpAds_dbmsname."-Erweiterung wird benötigt.";
$GLOBALS['strWarningPHPversion']		= $phpAds_productname." benötigt PHP 4.0 oder höher, um korrekt genutzt werden zu können. Sie nutzten {php_version}.";
$GLOBALS['strWarningRegisterGlobals']		= "Die PHP-Konfigurationsvaribable <i>register_globals</i> muß gesetzt werden.";
$GLOBALS['strWarningMagicQuotesGPC']		= " Die PHP-Konfigurationsvaribable <i> magic_quotes_gpc</i> muß gesetzt werden.";
$GLOBALS['strWarningMagicQuotesRuntime']	= " Die PHP-Konfigurationsvaribable <i> magic_quotes_runtime</i> muß deaktiviert werden.";
$GLOBALS['strWarningFileUploads']		= " Die PHP-Konfigurationsvaribable <i> file_uploads</i> muß gesetzt werden.";
$GLOBALS['strWarningTrackVars']			= " Die PHP-Konfigurationsvaribable <i> track_vars</i> muß gesetzt werden.";
$GLOBALS['strWarningPREG']				= "Die verwendete PHP-Version unterstützt nicht PERL-kompatible Ausdrücke. Um fortfahren zu können wird die PHP-Erweiterung <i>PREG</i> benötigt.";
$GLOBALS['strConfigLockedDetected']		= $phpAds_productname." hat erkannt, daß die Datei <b>config.inc.php</b> schreibgeschützt ist.<br> Die Installation kann aber ohne Schreibberechtigung nicht fortgesetzt werden. <br>Weitere Informationen finden sich im Handbuch."; 

$GLOBALS['strCantUpdateDB']  			= "Ein Update der Datenbank ist derzeit nicht möglich. Wenn Sie die Installation fortsetzen, werden alle existierende Banner, Statistiken und Inserenten gelöscht. ";
$GLOBALS['strIgnoreErrors']			= "Fehler ignorieren";
$GLOBALS['strRetryUpdate']			= "Wiederhole Update";
$GLOBALS['strTableNames']			= "Tabellenname";
$GLOBALS['strTablesPrefix']			= "Präfix zum Tabellenname";
$GLOBALS['strTablesType']			= "Tabellentype";
$GLOBALS['strInstallWelcome']			= "Willkommen bei ".$phpAds_productname;
$GLOBALS['strInstallMessage']			= "Bevor ".$phpAds_productname." genutzt werden kann, müssen die Einstellungen konfiguriert  <br> sowie die Datenbank geschaffen (create) werden. Drücken Sie <b>Weiter</b> , um fortzufahren.";
$GLOBALS['strInstallSuccess']			= "<b>die Installation von ".$phpAds_productname." war erfolgreich.</b><br><br>Damit ".$phpAds_productname." korrekt arbeitet, muß sichergestellt sein, daß das Wartungsmodul (maintenance.php) stündlich aktiviert wird. Nähere Informationen finden sich im Handbuch. <br><br>
Für weitere Einstellungen auf der Konfigurationsseite drücken Sie  <b>Weiter</b>. 
<BR>
Der Schreibschutz der Datei <i>config.inc.php</i> sollte aus Sicherheitsgründen wieder gesetzt werden.";
$GLOBALS['strUpdateSuccess']		= "<b>Das Update von ".$phpAds_productname." war erfolgreich.</b><br><br>
Damit ".$phpAds_productname." korrekt arbeitet, muß sichergestellt sein, daß das Wartungsmodul (maintenance.php) stündlich aktiviert wird. Nähere Informationen finden sich im Handbuch. <br><br>
Für weitere Einstellungen auf der Konfigurationsseite drücken Sie  <b>Weiter</b>. 
<BR>
Der Schreibschutz der Datei <i>config.inc.php</i> sollte aus Sicherheitsgründen wieder gesetzt werden.";

$GLOBALS['strInstallNotSuccessful']		= "<b>Die Installation von ".$phpAds_productname." war nicht erfolgreich</b><br><br>
Teile des Installationsprozesses wurden nicht beendet. Das Problem ist möglicherweise nur temporär. In diesem Fall drücken Sie <b> Weiter</b> und beginnen Sie den Installationsprozeß von neuem. Näheres zu Fehlermeldungen und -behebung findet sich im Handbuch.";
$GLOBALS['strErrorOccured']			= "Der folgende Fehler ist aufgetreten:";
$GLOBALS['strErrorInstallDatabase']		= "Die Datenbankstruktur konnte nicht angelegt werden.";
$GLOBALS['strErrorInstallConfig']		= "Die Konfigurationsdatei oder die Datenbank konnten nicht aktualisiert werden.";
$GLOBALS['strErrorInstallDbConnect']		= "Eine Verbindung zur Datenbank war nicht möglich.";

$GLOBALS['strUrlPrefix']			= "URL Präfix";

$GLOBALS['strProceed']				= "Weiter &gt;";
$GLOBALS['strInvalidUserPwd']			= "Fehlerhafter Benutzername oder Passwort";

$GLOBALS['strUpgrade']				= "Prorammergänzung (Upgrade)";
$GLOBALS['strSystemUpToDate']		= "Das System ist up to date. Eine Ergänzung (Upgrade) ist nicht notwendig. <br>
Drücken Sie <b>Weiter</b>, um zur Startseite zu gelangen.";
$GLOBALS['strSystemNeedsUpgrade']		= "Die Datenbankstruktur und die Konfigurationsdateien sollten aktualisiert werden. Drücken Sie <b>Weiter</b> für den Start des Aktualisierungslauf.
 <br><br>Abhängig von der derzeitig genutzten Version und der Anzahl der vorhandenen Statistiken kann dieser Prozeß Ihre Datenbank stark belasten. Das Upgrade kann einige Minuten dauern.";
$GLOBALS['strSystemUpgradeBusy']		= "Aktualisierung des Systems läuft. Bitte warten ...";
$GLOBALS['strSystemRebuildingCache']		= "Cache wird neu erstellt. Bitte warten ...";
$GLOBALS['strServiceUnavalable']		= "Dieser Service ist zur Zeit nicht erreichbar. System wird aktualisiert...";

$GLOBALS['strConfigNotWritable']		= "Für die Datei <i>config.inc.php</i>  besteht Schreibschutz";



/*********************************************************/
/* Configuration translations                            */
/*********************************************************/

// Global
$GLOBALS['strChooseSection']			= "Bereichsauswahl";
$GLOBALS['strDayFullNames'] 			= array("Sonntag","Montag","Dienstag","Mittwoch","Donnerstag","Freitag","Samstag");
$GLOBALS['strEditConfigNotPossible']   		= "Änderungen der Systemeinstellung nicht möglich. Für die Konfigurationsdatei  <i>config.inc.php</i> besteht Schreibschutz. ".
										  "Für Änderungen muß der Schreibschutz aufgehoben werden.";
$GLOBALS['strEditConfigPossible']		= "Unbefugte Systemänderungen sind möglich. Die Zugriffsrechte der Konfigurationsdatei <i>config.inc.php</i> sind auf Schreibbrechtigung gesetzt. ".
										  "Zur Sicherung des System sollte der Schreibschutz gesetzt werden. Nähere Informationen im Handbuch.";



// Database
$GLOBALS['strDatabaseSettings']			= "Datenbankeinstellungen";
$GLOBALS['strDatabaseServer']			= "Datenbank Server";
$GLOBALS['strDbLocal']				= "Verbindung zum lokalen Server mittels Sockets"; // Pg only
$GLOBALS['strDbHost']				= "Datenbank Hostname";
$GLOBALS['strDbPort']				= "Datenbank Portnummer";
$GLOBALS['strDbUser']				= "Datenbank Benutzername";
$GLOBALS['strDbPassword']			= "Datenbank Passwort";
$GLOBALS['strDbName']			= "Datenbank Name";

$GLOBALS['strDatabaseOptimalisations']		= " Datenbankoptimierungen";
$GLOBALS['strPersistentConnections']		= "Dauerhafte Verbindung zur Datenbank";
$GLOBALS['strInsertDelayed']			= "Datenbank wird zeitlich versetzt beschrieben";
$GLOBALS['strCompatibilityMode']		= "Kompatibilitätsmodus (Datenbank)";
$GLOBALS['strCantConnectToDb']		= "Verbindung zur Datenbank nicht möglich";


// Invocation and Delivery
$GLOBALS['strInvocationAndDelivery']		= "Einstellungen für Bannercode und -auslieferung";

$GLOBALS['strAllowedInvocationTypes']		= "Zugelassene Bannercodes (Mehrfachauswahl möglich)";
$GLOBALS['strAllowRemoteInvocation']		= "Normaler Bannercode (Remote)";
$GLOBALS['strAllowRemoteJavascript']		= "Bannercode für Javascript ";
$GLOBALS['strAllowRemoteFrames']		= "Bannercode für Frames (iframe/ilayer)";
$GLOBALS['strAllowRemoteXMLRPC']		= "Bannercode bei Nutzung von XML-RPC";
$GLOBALS['strAllowLocalmode']			= "Lokaler Modus";
$GLOBALS['strAllowInterstitial']			= "Interstitial oder Floating DHTML";
$GLOBALS['strAllowPopups']			= "PopUp";

$GLOBALS['strUseAcl']				= "Einschränkungen während der Bannerauslieferung werden berücksichtigt";

$GLOBALS['strDeliverySettings']			= "Einstellungen für Bannerauslieferung";
$GLOBALS['strCacheType']			= "Cache-Type für Bannerauslieferung";
$GLOBALS['strCacheFiles']			= "Dateien";
$GLOBALS['strCacheDatabase']			= "Datenbank";
$GLOBALS['strCacheShmop']			= "Shared memory/Shmop";
$GLOBALS['strCacheSysvshm']			= "Shared memory/Sysvshm";
$GLOBALS['strExperimental']			= "Experimental";
$GLOBALS['strKeywordRetrieval']		= "Schlüsselwortselektion";
$GLOBALS['strBannerRetrieval']			= "Modus für Bannerselektion";
$GLOBALS['strRetrieveRandom']			= "Zufallsbasierte Bannerselektion (Voreinstellung)";
$GLOBALS['strRetrieveNormalSeq']		= "Sequentielle Bannerselektion";
$GLOBALS['strWeightSeq']			= "Gewichtungsabhängige Bannerselektion ";
$GLOBALS['strFullSeq']				= " Streng sequentielle Bannerselektion ";
$GLOBALS['strUseConditionalKeys']		= "Logische Operatoren sind bei Direktselektion zulässig ";
$GLOBALS['strUseMultipleKeys']			= "Mehrere Schlüsselwörter sind für die Direktselektion zugelassen ";

$GLOBALS['strZonesSettings']			= "Selektion über Zonen";
$GLOBALS['strZoneCache']			= "Einrichten von Zwischenspeichern (Cache) für Zonen. Beschleunigt die Bannerauslieferung";
$GLOBALS['strZoneCacheLimit']			= "Aktualisierungsintervall der Zwischenspeicher (Cache) in Sekunden";
$GLOBALS['strZoneCacheLimitErr']		= "Aktualisierungsintervall muß ein positiver ganzzahliger Wert sein";

$GLOBALS['strP3PSettings']			= "P3P Privacy Policies";
$GLOBALS['strUseP3P']				= "Verwendung von P3P Policies";
$GLOBALS['strP3PCompactPolicy']		= "P3P Compact Policies";
$GLOBALS['strP3PPolicyLocation']		= "P3P Policies Location"; 



// Banner Settings
$GLOBALS['strBannerSettings']			= "Bannereinstellungen";

$GLOBALS['strAllowedBannerTypes']		= "Zugelassene Bannertypen (Mehrfachnennung möglich)";
$GLOBALS['strTypeSqlAllow']			= "Banner in Datenbank speichern (SQL)";
$GLOBALS['strTypeWebAllow']			= "Banner auf Webserver (lokal)";
$GLOBALS['strTypeUrlAllow']			= "Banner über URL verwalten";
$GLOBALS['strTypeHtmlAllow']			= "HTML-Banners";
$GLOBALS['strTypeTxtAllow']			= "Textanzeigen";

$GLOBALS['strTypeWebSettings']		= "Bannerkonfiguration auf Webserver (lokal)";
$GLOBALS['strTypeWebMode']			= "Speichermethode";
$GLOBALS['strTypeWebModeLocal']		= "Lokales Verzeichnis";
$GLOBALS['strTypeWebModeFtp']		= "Externer FTP-Server";
$GLOBALS['strTypeWebDir']			= "Webserver-Verzeichnis";  
$GLOBALS['strTypeWebFtp']			= "FTP-Bannerserver";
$GLOBALS['strTypeWebUrl']			= "(öffentliche) URL"; 
$GLOBALS['strTypeFTPHost']			= "FTP-Host";
$GLOBALS['strTypeFTPDirectory']		= "FTP-Verzeichnis";
$GLOBALS['strTypeFTPUsername']		= "FTP-Benutzername";
$GLOBALS['strTypeFTPPassword']		= "FTP-Passwort";
$GLOBALS['strTypeFTPErrorDir']		= "FTP-Verzeichnis existiert nicht";
$GLOBALS['strTypeFTPErrorConnect']		= "Verbindung zum FTP Server nicht möglich. Benutzername oder Passwort waren fehlerhaft";
$GLOBALS['strTypeFTPErrorHost']			= "Hostname für FTP-Server ist fehlerhaft";
$GLOBALS['strTypeDirError']				= "Das lokale Verzeichnis existiert nicht";



$GLOBALS['strDefaultBanners']			= "Ersatzbanner <i>(kein reguläres Banner steht zur Verfügung)</i>";
$GLOBALS['strDefaultBannerUrl']		= "Bild-URL für Ersatzbanner";
$GLOBALS['strDefaultBannerTarget']		= "Ziel-URL für Ersatzbanner";

$GLOBALS['strTypeHtmlSettings']		= "Optionen für HTML-Banner";

$GLOBALS['strTypeHtmlAuto']			= "HTML-Code zum Aufzeichnen der AdClicks modifizieren";
$GLOBALS['strTypeHtmlPhp']			= "Ausführbarer PHP-Code ist in HTML-Banner zugelassen ";



// Host information and Geotargeting
$GLOBALS['strHostAndGeo']			= "Geotargeting (Hostinformation und Standortbestimmung) der Besucher";

$GLOBALS['strRemoteHost']			= "Host des Besuchers";
$GLOBALS['strReverseLookup']			= "Es wird versucht, den Name des Hosts für den Besucher zu ermitteln, wenn er nicht mitgeliefert wird";
$GLOBALS['strProxyLookup']				= "Es wird versucht, die  IP-Adresse des Besuchers zu ermitteln, wenn er einen Proxy-Server nutzt";

$GLOBALS['strGeotargeting']			= "Geotargeting (Standortbestimmung) ";
$GLOBALS['strGeotrackingType']			= "Datenbanktypen für Geotargeting ";
$GLOBALS['strGeotrackingLocation'] 		= "Standort der Datenbank für Geotargeting";
$GLOBALS['strGeotrackingLocationError'] = "Keine Datenbank für Geotargeting an der genannten Adresse gefunden";
$GLOBALS['strGeoStoreCookie']			= "Speichern des Ergebnisses in einem Cookie zur späteren Nutzung";



// Statistics Settings
$GLOBALS['strStatisticsSettings']			= "Statistikeinstellungen";

$GLOBALS['strStatisticsFormat']			= "Statistikformat";
$GLOBALS['strCompactStats']				= " Statistikformat ";
$GLOBALS['strLogAdviews']				= "Jede Bannerauslieferung wird als ein AdView protokolliert";
$GLOBALS['strLogAdclicks']				= "Jeder Klick auf ein Banner wird als ein AdClick protokolliert";
$GLOBALS['strLogSource']				= "Die Parameter der Quelle werden  bei der Bannerauslieferung protokolliert";
$GLOBALS['strGeoLogStats']				= "Das Land des Besuchers wird protokolliert";
$GLOBALS['strLogHostnameOrIP']			= "Hostname oder IP-Adresse des Besuchers wird protokolliert";
$GLOBALS['strLogIPOnly']				= "Ausschließlich die IP-Adresse des Besuchers wird protokolliert, auch wenn der Hostname erkannt ist";
$GLOBALS['strLogIP']					= "Die IP-Adresse des Besuchers wird protokolliert";
$GLOBALS['strLogBeacon']				= " Ein Beacon (Minibild) wird verwendet, um sicherzustellen, daß nur vollständige Bannerauslieferungen protokolliert werden ";

$GLOBALS['strRemoteHosts']				= "Host des Besuchers";
$GLOBALS['strIgnoreHosts']				= "AdViews und AdClicks für Besucher mit folgenden IP-Adressen oder Hostnamen bleiben in den Statistiken unberücksichtigt";
$GLOBALS['strBlockAdviews']				= "Reloadsperre (Zeitraum in Sek.)";
$GLOBALS['strBlockAdclicks']			= " Reclicksperre (Zeitraum in Sek.) ";

$GLOBALS['strPreventLogging']			= "Protokollieren verhindern";
$GLOBALS['strEmailWarnings']			= "Warnungen per eMail";
$GLOBALS['strAdminEmailHeaders']		= "Kopfzeile für alle eMails, die versandt werden";
$GLOBALS['strWarnLimit']				= "Warnung per eMail bei Unterschreiten der definierten Untergrenze";
$GLOBALS['strWarnLimitErr']				= "Warnlimit muß eine positive Ganzzahl sein";
$GLOBALS['strWarnAdmin']				= "Warnung per eMail an den Administrator, wenn eine Kampagne ausgelaufen ist";
$GLOBALS['strWarnClient']				= "Warnung per eMail an den Inserenten, wenn eine Kampagne ausgelaufen ist";
$GLOBALS['strQmailPatch']				= "Kopfzeile auch für qMail lesbar machen";

$GLOBALS['strAutoCleanTables']			= "Datenbank löschen";
$GLOBALS['strAutoCleanStats']			= "Statistiken löschen";
$GLOBALS['strAutoCleanUserlog']		= "Benutzerprotokoll löschen"; 
$GLOBALS['strAutoCleanStatsWeeks']		= "Zeitraum in Wochen, nachdem Statistiken gelöscht werden <br><i>(jedoch mindestens 3 Wochen)</i>";
$GLOBALS['strAutoCleanUserlogWeeks']		= "Zeitraum in Wochen, nachdem Statistiken gelöscht werden <br><i>(3 Wochen mindestens)</i>";
$GLOBALS['strAutoCleanErr']			= "Der Zeitraum, nach dem die Daten gelöscht werden sollen, muß mindestens 3 Wochen betragen";
$GLOBALS['strAutoCleanVacuum']		= "VACUUM ANALYZE Tabellen jede Nacht"; // only Pg


// Administrator settings
$GLOBALS['strAdministratorSettings']		= "Einstellungen für Administrator";

$GLOBALS['strLoginCredentials']			= "Erkennungsprüfung";
$GLOBALS['strAdminUsername']			= "Benutzername (Admin)";
$GLOBALS['strInvalidUsername']			= "Benutzername fehlerhaft";

$GLOBALS['strBasicInformation']			= "Basisinformation";
$GLOBALS['strAdminFullName']			= "Name, Vorname";
$GLOBALS['strAdminEmail']			= "E-Mail";
$GLOBALS['strCompanyName']			= "Firma";

$GLOBALS['strAdminCheckUpdates']		= "Prüfen, ob neue Programmversionen vorhanden sind";
$GLOBALS['strAdminCheckEveryLogin']		= "Bei jedem Login";
$GLOBALS['strAdminCheckDaily']		= "Täglich";
$GLOBALS['strAdminCheckWeekly']		= "Wöchentlich";
$GLOBALS['strAdminCheckMonthly']		= "Monatlich";
$GLOBALS['strAdminCheckNever']		= "Nie"; 

$GLOBALS['strAdminNovice']			= "Löschvorgänge im Admin-Bereich nur mit Sicherheitsbestätigung";
$GLOBALS['strUserlogEmail']			= "Alle ausgehende eMails protokollieren ";
$GLOBALS['strUserlogPriority']			= "Stündliche Rekalkulation der Prioritäten wird protokolliert";
$GLOBALS['strUserlogAutoClean']		= "Protokollieren des Säuberns der Datenbank";


// User interface settings
$GLOBALS['strGuiSettings']			= "Konfiguration Benutzerbereich (Inhaber des AdServers)";

$GLOBALS['strGeneralSettings']				= "Einstellungen für das Gesamtprogramm";
$GLOBALS['strAppName']				= "Name oder Bezeichnung der Anwendung";
$GLOBALS['strMyHeader']				= "Kopfzeile im Admin-Bereich";
$GLOBALS['strMyHeaderError']		= "Die Datei für die Kopfzeile wurde an angegebenen Adresse nicht vorgefunden";
$GLOBALS['strMyFooter']				= "Fußzeile im Admin-Bereich";
$GLOBALS['strMyFooterError']		= "Die Datei für die Fußzeile wurde an angegebenen Adresse nicht vorgefunden";
$GLOBALS['strGzipContentCompression']		= "Komprimieren mit GZIP";

$GLOBALS['strClientInterface']			= "Inserentenbereich";
$GLOBALS['strClientWelcomeEnabled']		= "Begrüßungstext für Inserenten verwenden";
$GLOBALS['strClientWelcomeText']		= "Begrüßungstext<br><i>(HTML Tags sind zugelassen)</i>";



// Interface defaults
$GLOBALS['strInterfaceDefaults']		= "Einstellung der Voreinstellungen";

$GLOBALS['strInventory']			= "Bestandsverzeichnis";
$GLOBALS['strShowCampaignInfo']		= "Anzeigen zusätzlicher Informationen auf der Seite <i>Übersicht Kampagnen</i>"; 
$GLOBALS['strShowBannerInfo']			= "Anzeigen zusätzlicher Bannerinformationen auf der Seite <i>Übersicht Banner</i> ";
$GLOBALS['strShowCampaignPreview']		= "Vorschau aller Banner auf der Seite  <i>Übersicht Banner </i>";
$GLOBALS['strShowBannerHTML']			= "Anzeige des Banners anstelle des HTML-Codes bei Vorschau von HTML-Bannern ";
$GLOBALS['strShowBannerPreview']		= "Bannervorschau oben auf allen Seiten mit dem Bezug zum Banner ";
$GLOBALS['strHideInactive']			= "Verbergen inaktive Teile auf den Übersichtsseiten";
$GLOBALS['strGUIShowMatchingBanners']		= "Anzeige des zugehörenden Banner auf der Seite <i>Verknüpfte Banner</i>";
$GLOBALS['strGUIShowParentCampaigns']		= "Anzeige der zugehörenden Kampagne auf der Seite <i>Veknüpfte Banner</i>";
$GLOBALS['strGUILinkCompactLimit']		= "Verbergen nicht verknüpfter Banner auf der Seite <i>Verknüpfte Banner</i>, sofern es mehr sind als ";

$GLOBALS['strStatisticsDefaults'] 		= "Statistiken";
$GLOBALS['strBeginOfWeek']			= "Wochenbeginn";
$GLOBALS['strPercentageDecimals']		= "Dezimalstellen bei Prozentangaben";

$GLOBALS['strWeightDefaults']			= "Gewichtung (Voreinstellung)";
$GLOBALS['strDefaultBannerWeight']		= "Gewichtung Banner (Voreinstellung)";
$GLOBALS['strDefaultCampaignWeight']		= "Gewichtung Kampagne (Voreinstellung)";
$GLOBALS['strDefaultBannerWErr']		= "Voreinstellung für Bannergewichtung muß eine positive Ganzzahl sein";
$GLOBALS['strDefaultCampaignWErr']		= " Voreinstellung für Kampagne muß eine positive Ganzzahl sein";




// Not used at the moment
$GLOBALS['strTableBorderColor']		= "Table Border Color";
$GLOBALS['strTableBackColor']			= "Table Back Color";
$GLOBALS['strTableBackColorAlt']		= "Table Back Color (Alternative)";
$GLOBALS['strMainBackColor']			= "Main Back Color";
$GLOBALS['strOverrideGD']			= "Override GD Imageformat";
$GLOBALS['strTimeZone']			= "Time Zone";

?>
