<?php // $Revision: 1.19.2.3 $

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
$GLOBALS['strInstall'] = "Installation";
$GLOBALS['strChooseInstallLanguage'] = "Wahlen Sie die Sprache fur den Installationsproze?";
$GLOBALS['strLanguageSelection'] = "Sprachauswahl";
$GLOBALS['strDatabaseSettings'] = "Datenbankeinstellungen";
$GLOBALS['strAdminSettings'] = "Einstellung fur Administrator";
$GLOBALS['strAdvancedSettings'] = "Erganzende Einstellungen";
$GLOBALS['strOtherSettings'] = "Andere Einstellungen";

$GLOBALS['strWarning'] = "Warnung";
$GLOBALS['strFatalError'] = "Ein schwerer Fehler ist aufgetreten";
$GLOBALS['strUpdateError'] = "Wahrend des Updates ist ein Fehler aufgetreten";
$GLOBALS['strUpdateDatabaseError'] = "Aus unbekannten Grunden war die Aktualisierung der Datenbankstruktur nicht erfolgreich. Es wird empfohlen, zu versuchen, mit <b>Wiederhole Update</b> das Problem zu beheben. Sollte der Fehler - Ihrer Meinung nach - die Funktionalitat von ".$phpAds_productname." nicht beruhren, konnen Sie durch <b>Fehler ignorieren</b>  fortfahren. Das Ignorieren des Fehlers wird nicht empfohlen!";
$GLOBALS['strAlreadyInstalled'] = $phpAds_productname." ist bereits auf diesem System installiert. Zur Konfiguration nutzen Sie das <a href='settings-index.php'>Konfigurationsmenu</a>"; 
$GLOBALS['strCouldNotConnectToDB'] = "Verbindung zur Datenbank war nicht moglich. Bitte vorgenommene Einstellung prufen. Prufen Sie ggf., ob die von Ihnen angegebene Datenbank uberhaupt auf dem Datenbank-Server vorhanden ist. ".$phpAds_productname." erstellt die Datenbank  <i>nicht</i> automatisch. ";
$GLOBALS['strCreateTableTestFailed'] = "Der von Ihnen angegebene Nutzer hat nicht die notwendigen Zugriffsrechte, um die Datenbankstruktur anlegen zu konnen. Wenden Sie sich an den Systemverwalter.";
$GLOBALS['strUpdateTableTestFailed'] = " Der von Ihnen angegebene Nutzer hat nicht die notwendigen Zugriffsrechte, um die Datenbank zu aktualisieren. Wenden Sie sich an den Systemverwalter.";
$GLOBALS['strTablePrefixInvalid'] = "Ungultiges Vorzeichen (Prafix) im Tabellennamen";
$GLOBALS['strTableInUse'] = "Die genannte Datenbank wird bereits von ".$phpAds_productname.", genutzt. Verwenden Sie einen anderen Prafix oder lesen Sie im Handbuch die Hinweise fur ein Upgrade.";
$GLOBALS['strTableWrongType'] = "Der gewahlte Tabellentype wird bei der Installation von ".$phpAds_dbmsname." nicht unterstutzt";
$GLOBALS['strMayNotFunction'] = "Folgende Probleme sind zu beheben, um fortzufahren";
$GLOBALS['strFixProblemsBefore'] = "Folgende Teile mussen korrigiert werden, bevor der Installationsproze? von ".$phpAds_productname." fortgesetzt werden kann. Informationen uber Fehlermeldungen finden sich im Handbuch.";
$GLOBALS['strFixProblemsAfter'] = "Sollten Sie die oben aufgefuhrten Fehler nicht selbst heben konnen, nehmen Sie Kontakt mit der Systemadministration Ihres Servers auf. Diese wird Ihnen weiterhelfen konnen.";
$GLOBALS['strIgnoreWarnings'] = "Ignoriere Warnungen";
$GLOBALS['strWarningDBavailable'] = "Die eingesetzte PHP-Version unterstutzt nicht die Verbindung zum ".$phpAds_dbmsname." Datenbankserver. Die PHP- ".$phpAds_dbmsname."-Erweiterung wird benotigt.";
$GLOBALS['strWarningPHPversion'] = $phpAds_productname." benotigt PHP 4.0 oder hoher, um korrekt genutzt werden zu konnen. Sie nutzten {php_version}.";
$GLOBALS['strWarningRegisterGlobals'] = "Die PHP-Konfigurationsvaribable <i>register_globals</i> mu? gesetzt werden.";
$GLOBALS['strWarningMagicQuotesGPC'] = " Die PHP-Konfigurationsvaribable <i> magic_quotes_gpc</i> mu? gesetzt werden.";
$GLOBALS['strWarningMagicQuotesRuntime'] = " Die PHP-Konfigurationsvaribable <i> magic_quotes_runtime</i> mu? deaktiviert werden.";
$GLOBALS['strWarningFileUploads'] = " Die PHP-Konfigurationsvaribable <i> file_uploads</i> mu? gesetzt werden.";
$GLOBALS['strWarningTrackVars'] = " Die PHP-Konfigurationsvaribable <i> track_vars</i> mu? gesetzt werden.";
$GLOBALS['strWarningPREG'] = "Die verwendete PHP-Version unterstutzt nicht PERL-kompatible Ausdrucke. Um fortfahren zu konnen wird die PHP-Erweiterung <i>PREG</i> benotigt.";
$GLOBALS['strConfigLockedDetected'] = $phpAds_productname." hat erkannt, da? die Datei <b>config.inc.php</b> schreibgeschutzt ist.<br> Die Installation kann aber ohne Schreibberechtigung nicht fortgesetzt werden. <br>Weitere Informationen finden sich im Handbuch."; 

$GLOBALS['strCantUpdateDB']  = "Ein Update der Datenbank ist derzeit nicht moglich. Wenn Sie die Installation fortsetzen, werden alle existierende Banner, Statistiken und Inserenten geloscht. ";
$GLOBALS['strIgnoreErrors'] = "Fehler ignorieren";
$GLOBALS['strRetryUpdate'] = "Wiederhole Update";
$GLOBALS['strTableNames'] = "Tabellenname";
$GLOBALS['strTablesPrefix'] = "Prafix zum Tabellenname";
$GLOBALS['strTablesType'] = "Tabellentype";
$GLOBALS['strInstallWelcome'] = "Willkommen bei ".$phpAds_productname;
$GLOBALS['strInstallMessage'] = "Bevor ".$phpAds_productname." genutzt werden kann, mussen die Einstellungen konfiguriert  <br> sowie die Datenbank geschaffen (create) werden. Drucken Sie <b>Weiter</b> , um fortzufahren.";
$GLOBALS['strInstallSuccess'] = "<b>die Installation von ".$phpAds_productname." war erfolgreich.</b><br><br>Damit ".$phpAds_productname." korrekt arbeitet, mu? sichergestellt sein, da? das Wartungsmodul (maintenance.php) stundlich aktiviert wird. Nahere Informationen finden sich im Handbuch. <br><br>
Fur weitere Einstellungen auf der Konfigurationsseite drucken Sie  <b>Weiter</b>. 
<BR>
Der Schreibschutz der Datei <i>config.inc.php</i> sollte aus Sicherheitsgrunden wieder gesetzt werden, sobald die Installation beendet ist.";
$GLOBALS['strUpdateSuccess'] = "<b>Das Update von ".$phpAds_productname." war erfolgreich.</b><br><br>
Damit ".$phpAds_productname." korrekt arbeitet, mu? sichergestellt sein, da? das Wartungsmodul (maintenance.php) stundlich aktiviert wird. Nahere Informationen finden sich im Handbuch. <br><br>
Fur weitere Einstellungen auf der Konfigurationsseite drucken Sie  <b>Weiter</b>. 
<BR>
Der Schreibschutz der Datei <i>config.inc.php</i> sollte aus Sicherheitsgrunden wieder gesetzt werden.";

$GLOBALS['strInstallNotSuccessful'] = "<b>Die Installation von ".$phpAds_productname." war nicht erfolgreich</b><br><br>
Teile des Installationsprozesses wurden nicht beendet. Das Problem ist moglicherweise nur temporar. In diesem Fall drucken Sie <b> Weiter</b> und beginnen Sie den Installationsproze? von neuem. Naheres zu Fehlermeldungen und -behebung findet sich im Handbuch.";
$GLOBALS['strErrorOccured'] = "Der folgende Fehler ist aufgetreten:";
$GLOBALS['strErrorInstallDatabase'] = "Die Datenbankstruktur konnte nicht angelegt werden.";
$GLOBALS['strErrorInstallConfig'] = "Die Konfigurationsdatei oder die Datenbank konnten nicht aktualisiert werden.";
$GLOBALS['strErrorInstallDbConnect'] = "Eine Verbindung zur Datenbank war nicht moglich.";

$GLOBALS['strUrlPrefix'] = "URL Prafix";

$GLOBALS['strProceed'] = "Weiter &gt;";
$GLOBALS['strInvalidUserPwd'] = "Fehlerhafter Benutzername oder Passwort";

$GLOBALS['strUpgrade'] = "Prorammerganzung (Upgrade)";
$GLOBALS['strSystemUpToDate'] = "Das System ist up to date. Eine Erganzung (Upgrade) ist nicht notwendig. <br>
Drucken Sie <b>Weiter</b>, um zur Startseite zu gelangen.";
$GLOBALS['strSystemNeedsUpgrade'] = "Die Datenbankstruktur und die Konfigurationsdateien sollten aktualisiert werden. Drucken Sie <b>Weiter</b> fur den Start des Aktualisierungslauf.
 <br><br>Abhangig von der derzeitig genutzten Version und der Anzahl der vorhandenen Statistiken kann dieser Proze? Ihre Datenbank stark belasten. Das Upgrade kann einige Minuten dauern.";
$GLOBALS['strSystemUpgradeBusy'] = "Aktualisierung des Systems lauft. Bitte warten ...";
$GLOBALS['strSystemRebuildingCache'] = "Cache wird neu erstellt. Bitte warten ...";
$GLOBALS['strServiceUnavalable'] = "Dieser Service ist zur Zeit nicht erreichbar. System wird aktualisiert...";

$GLOBALS['strConfigNotWritable'] = "Fur die Datei <i>config.inc.php</i>  besteht Schreibschutz";
$GLOBALS['strPhpBug20144'] = "Die von Ihnen eingesetzte Version von PHP hat einen <a href='http://bugs.php.net/bug.php?id=20114' target='_blank'>schwerwiegenden Fehler</a>. Dadurch arbeitet ".$phpAds_productname." nicht korrekt. Es wird PHP 4.3.0 oder hoher benotigt. Andernfalls kann die Installation nicht fortgesetzt werden.";





/*********************************************************/
/* Configuration translations                            */
/*********************************************************/

// Global
$GLOBALS['strChooseSection'] = "Bereichsauswahl";
$GLOBALS['strDayFullNames'] = array("Sonntag","Montag","Dienstag","Mittwoch","Donnerstag","Freitag","Samstag");
$GLOBALS['strEditConfigNotPossible']   = "Anderungen der Systemeinstellung sind nicht moglich. Es besteht fur die Konfigurationsdatei  <i>config.inc.php</i> Schreibschutz. ".
  "Fur Anderungen mu? der Schreibschutz aufgehoben werden.";
$GLOBALS['strEditConfigPossible'] = "Unbefugte Systemanderungen sind moglich. Die Zugriffsrechte der Konfigurationsdatei <i>config.inc.php</i> sind auf Schreibbrechtigung gesetzt. ".
  "Zur Sicherung des System sollte der Schreibschutz gesetzt werden. Nahere Informationen im Handbuch.";



// Database
$GLOBALS['strDatabaseSettings'] = "Datenbankeinstellungen";
$GLOBALS['strDatabaseServer'] = "Datenbank Server";
$GLOBALS['strDbLocal'] = "Verbindung zum lokalen Server mittels Sockets"; // Pg only
$GLOBALS['strDbHost'] = "Datenbank Hostname";
$GLOBALS['strDbPort'] = "Datenbank Portnummer";
$GLOBALS['strDbUser'] = "Datenbank Benutzername";
$GLOBALS['strDbPassword'] = "Datenbank Passwort";
$GLOBALS['strDbName'] = "Datenbank Name";

$GLOBALS['strDatabaseOptimalisations'] = " Datenbankoptimierungen";
$GLOBALS['strPersistentConnections'] = "Dauerhafte Verbindung zur Datenbank";
$GLOBALS['strInsertDelayed'] = "Datenbank wird zeitlich versetzt beschrieben";
$GLOBALS['strCompatibilityMode'] = "Kompatibilitatsmodus (Datenbank)";
$GLOBALS['strCantConnectToDb'] = "Verbindung zur Datenbank nicht moglich";


// Invocation and Delivery
$GLOBALS['strInvocationAndDelivery'] = "Einstellungen fur Bannercode und -auslieferung";

$GLOBALS['strAllowedInvocationTypes'] = "Zugelassene Bannercodes (Mehrfachauswahl moglich)";
$GLOBALS['strAllowRemoteInvocation'] = "Normaler Bannercode (Remote)";
$GLOBALS['strAllowRemoteJavascript'] = "Bannercode fur Javascript ";
$GLOBALS['strAllowRemoteFrames'] = "Bannercode fur Frames (iframe/ilayer)";
$GLOBALS['strAllowRemoteXMLRPC'] = "Bannercode bei Nutzung von XML-RPC";
$GLOBALS['strAllowLocalmode'] = "Lokaler Modus";
$GLOBALS['strAllowInterstitial'] = "Interstitial oder Floating DHTML";
$GLOBALS['strAllowPopups'] = "PopUp";

$GLOBALS['strUseAcl'] = "Einschrankungen wahrend der Bannerauslieferung werden berucksichtigt";

$GLOBALS['strDeliverySettings'] = "Einstellungen fur Bannerauslieferung";
$GLOBALS['strCacheType'] = "Cache-Type fur Bannerauslieferung";
$GLOBALS['strCacheFiles'] = "Datei-Cache";
$GLOBALS['strCacheDatabase'] = "Datenbank";
$GLOBALS['strCacheShmop'] = "Shared memory/Shmop";
$GLOBALS['strCacheSysvshm'] = "Shared memory/Sysvshm";
$GLOBALS['strExperimental'] = "Experimental";
$GLOBALS['strKeywordRetrieval'] = "Schlusselwortselektion";
$GLOBALS['strBannerRetrieval'] = "Modus fur Bannerselektion";
$GLOBALS['strRetrieveRandom'] = "Zufallsbasierte Bannerselektion (Voreinstellung)";
$GLOBALS['strRetrieveNormalSeq'] = "Sequentielle Bannerselektion";
$GLOBALS['strWeightSeq'] = "Gewichtungsabhangige Bannerselektion ";
$GLOBALS['strFullSeq'] = " Streng sequentielle Bannerselektion ";
$GLOBALS['strUseConditionalKeys'] = "Logische Operatoren sind bei Direktselektion zulassig ";
$GLOBALS['strUseMultipleKeys'] = "Mehrere Schlusselworter sind fur die Direktselektionzugelassen ";

$GLOBALS['strZonesSettings'] = "Selektion uber Zonen";
$GLOBALS['strZoneCache'] = "Einrichten von Zwischenspeichern (Cache) fur Zonen. Beschleunigt die Bannerauslieferung";
$GLOBALS['strZoneCacheLimit'] = "Aktualisierungsintervall der Zwischenspeicher (Cache) in Sekunden";
$GLOBALS['strZoneCacheLimitErr'] = "Aktualisierungsintervall mu? ein positiver ganzzahliger Wert sein";

$GLOBALS['strP3PSettings'] = "P3P Privacy Policies";
$GLOBALS['strUseP3P'] = "Verwendung von P3P Policies";
$GLOBALS['strP3PCompactPolicy'] = "P3P Compact Policies";
$GLOBALS['strP3PPolicyLocation'] = "P3P Policies Location"; 



// Banner Settings
$GLOBALS['strBannerSettings'] = "Bannereinstellungen";

$GLOBALS['strAllowedBannerTypes'] = "Zugelassene Bannertypen (Mehrfachnennung moglich)";
$GLOBALS['strTypeSqlAllow'] = "Banner in Datenbank speichern (SQL)";
$GLOBALS['strTypeWebAllow'] = "Banner auf Webserver (lokal)";
$GLOBALS['strTypeUrlAllow'] = "Banner uber URL verwalten";
$GLOBALS['strTypeHtmlAllow'] = "HTML-Banners";
$GLOBALS['strTypeTxtAllow'] = "Textanzeigen";

$GLOBALS['strTypeWebSettings'] = "Bannerkonfiguration auf Webserver (lokal)";
$GLOBALS['strTypeWebMode'] = "Speichermethode";
$GLOBALS['strTypeWebModeLocal'] = "Lokales Verzeichnis";
$GLOBALS['strTypeWebModeFtp'] = "Externer FTP-Server";
$GLOBALS['strTypeWebDir'] = "Webserver-Verzeichnis";  
$GLOBALS['strTypeWebFtp'] = "FTP-Bannerserver";
$GLOBALS['strTypeWebUrl'] = "(offentliche) URL"; 
$GLOBALS['strTypeFTPHost'] = "FTP-Host";
$GLOBALS['strTypeFTPDirectory'] = "FTP-Verzeichnis";
$GLOBALS['strTypeFTPUsername'] = "FTP-Benutzername";
$GLOBALS['strTypeFTPPassword'] = "FTP-Passwort";
$GLOBALS['strTypeFTPErrorDir'] = "FTP-Verzeichnis existiert nicht";
$GLOBALS['strTypeFTPErrorConnect'] = "Verbindung zum FTP Server nicht moglich. Benutzername oder Passwort waren fehlerhaft";
$GLOBALS['strTypeFTPErrorHost'] = "Hostname fur FTP-Server ist fehlerhaft";
$GLOBALS['strTypeDirError'] = "Das lokale Verzeichnis existiert nicht";



$GLOBALS['strDefaultBanners'] = "Ersatzbanner <i>(kein regulares Banner steht zur Verfugung)</i>";
$GLOBALS['strDefaultBannerUrl'] = "Bild-URL fur Ersatzbanner";
$GLOBALS['strDefaultBannerTarget'] = "Ziel-URL fur Ersatzbanner";

$GLOBALS['strTypeHtmlSettings'] = "Optionen fur HTML-Banner";

$GLOBALS['strTypeHtmlAuto'] = "HTML-Code zum Aufzeichnen der AdClicks modifizieren";
$GLOBALS['strTypeHtmlPhp'] = "Ausfuhrbarer PHP-Code ist in HTML-Banner zugelassen ";



// Host information and Geotargeting
$GLOBALS['strHostAndGeo'] = "Geotargeting (Hostinformation und Standortbestimmung) der Besucher";

$GLOBALS['strRemoteHost'] = "Host des Besuchers";
$GLOBALS['strReverseLookup'] = "Es wird versucht, den Name des Hosts fur den Besucher zu ermitteln, wenn er nicht mitgeliefert wird";
$GLOBALS['strProxyLookup'] = "Es wird versucht, die  IP-Adresse des Besuchers zu ermitteln, wenn er einen Proxy-Server nutzt";

$GLOBALS['strGeotargeting'] = "Geotargeting (Standortbestimmung) ";
$GLOBALS['strGeotrackingType'] = "Datenbanktypen fur Geotargeting ";
$GLOBALS['strGeotrackingLocation'] = "Standort der Datenbank fur Geotargeting";
$GLOBALS['strGeotrackingLocationError'] = "Keine Datenbank fur Geotargeting an der genannten Adresse gefunden";
$GLOBALS['strGeotrackingLocationNoHTTP'] = "Die von Ihnen angegebene Adresse ist <b>kein</b> lokales Verzeichnis auf dem Rechner (der Festplatte) des Servers. Es ist die URL einer WEB-Datei. Die richtige Schreibweise fur ein lokales Verzeichnis sollte ahnlich aussehen wie:<br><i>{example}</i>.<BR> 
Um Geotargeting nutzen zu konnen, mu? korrekt angegeben werden, wohin die Datenbank kopiert wurde. ";
$GLOBALS['strGeoStoreCookie'] = "Speichern des Ergebnisses in einem Cookie zur spateren Nutzung";



// Statistics Settings
$GLOBALS['strStatisticsSettings'] = "Statistikeinstellungen";

$GLOBALS['strStatisticsFormat'] = "Statistikformat";
$GLOBALS['strCompactStats'] = " Statistikformat ";
$GLOBALS['strLogAdviews'] = "Jede Bannerauslieferung wird als ein AdView protokolliert";
$GLOBALS['strLogAdclicks'] = "Jeder Klick auf ein Banner wird als ein AdClick protokolliert";
$GLOBALS['strLogSource'] = "Die Parameter der Quelle werden  bei der Bannerauslieferung protokolliert";
$GLOBALS['strGeoLogStats'] = "Das Land des Besuchers wird protokolliert";
$GLOBALS['strLogHostnameOrIP'] = "Hostname oder IP-Adresse des Besuchers wird protokolliert";
$GLOBALS['strLogIPOnly'] = "Ausschlie?lich die IP-Adresse des Besuchers wird protokolliert, auch wenn der Hostname erkannt ist";
$GLOBALS['strLogIP'] = "Die IP-Adresse des Besuchers wird protokolliert";
$GLOBALS['strLogBeacon'] = " Ein Beacon (Minibild) wird verwendet, um sicherzustellen, da? nur vollstandige Bannerauslieferungen protokolliert werden ";

$GLOBALS['strRemoteHosts'] = "Host des Besuchers";
$GLOBALS['strIgnoreHosts'] = "AdViews und AdClicks fur Besucher mit folgenden IP-Adressen oder Hostnamen bleiben in den Statistiken unberucksichtigt";
$GLOBALS['strBlockAdviews'] = "Reloadsperre (Zeitraum in Sek.)";
$GLOBALS['strBlockAdclicks'] = " Reclicksperre (Zeitraum in Sek.) ";

$GLOBALS['strPreventLogging'] = "Protokollieren verhindern";
$GLOBALS['strEmailWarnings'] = "Warnungen per eMail";
$GLOBALS['strAdminEmailHeaders'] = "Kopfzeile fur alle eMails, die versandt werden";
$GLOBALS['strWarnLimit'] = "Warnung per eMail bei Unterschreiten der definierten Untergrenze";
$GLOBALS['strWarnLimitErr'] = "Warnlimit mu? eine positive Ganzzahl sein";
$GLOBALS['strWarnAdmin'] = "Warnung per eMail an den Administrator, wenn eine Kampagne ausgelaufen ist";
$GLOBALS['strWarnClient'] = "Warnung per eMail an den Inserenten, wenn eine Kampagne ausgelaufen ist";
$GLOBALS['strQmailPatch'] = "Kopfzeile auch fur qMail lesbar machen";

$GLOBALS['strAutoCleanTables'] = "Datenbank loschen";
$GLOBALS['strAutoCleanStats'] = "Statistiken loschen";
$GLOBALS['strAutoCleanUserlog'] = "Benutzerprotokoll loschen"; 
$GLOBALS['strAutoCleanStatsWeeks'] = "Zeitraum in Wochen, nachdem Statistiken geloscht werden <br><i>(jedoch mindestens 3 Wochen)</i>";
$GLOBALS['strAutoCleanUserlogWeeks'] = "Zeitraum in Wochen, nachdem Statistiken geloscht werden <br><i>(3 Wochen mindestens)</i>";
$GLOBALS['strAutoCleanErr'] = "Der Zeitraum, nach dem die Daten geloscht werden sollen, mu? mindestens 3 Wochen betragen";
$GLOBALS['strAutoCleanVacuum'] = "VACUUM ANALYZE Tabellen jede Nacht"; // only Pg


// Administrator settings
$GLOBALS['strAdministratorSettings'] = "Einstellungen fur Administrator";

$GLOBALS['strLoginCredentials'] = "Erkennungsprufung";
$GLOBALS['strAdminUsername'] = "Benutzername (Admin)";
$GLOBALS['strInvalidUsername'] = "Benutzername fehlerhaft";

$GLOBALS['strBasicInformation'] = "Basisinformation";
$GLOBALS['strAdminFullName'] = "Name, Vorname";
$GLOBALS['strAdminEmail'] = "E-Mail";
$GLOBALS['strCompanyName'] = "Firma";

$GLOBALS['strAdminCheckUpdates'] = "Prufen, ob neue Programmversionen vorhanden sind";
$GLOBALS['strAdminCheckEveryLogin'] = "Bei jedem Login";
$GLOBALS['strAdminCheckDaily'] = "Taglich";
$GLOBALS['strAdminCheckWeekly'] = "Wochentlich";
$GLOBALS['strAdminCheckMonthly'] = "Monatlich";
$GLOBALS['strAdminCheckNever'] = "Nie"; 

$GLOBALS['strAdminNovice'] = "Loschvorgange im Admin-Bereich nur mit Sicherheitsbestatigung";
$GLOBALS['strUserlogEmail'] = "Alle ausgehende eMails protokollieren ";
$GLOBALS['strUserlogPriority'] = "Stundliche Rekalkulation der Prioritaten wird protokolliert";
$GLOBALS['strUserlogAutoClean'] = "Protokollieren des Sauberns der Datenbank";


// User interface settings
$GLOBALS['strGuiSettings'] = "Konfiguration Benutzerbereich (Inhaber des AdServers)";

$GLOBALS['strGeneralSettings'] = "Einstellungen fur das Gesamtprogramm";
$GLOBALS['strAppName'] = "Name oder Bezeichnung der Anwendung";
$GLOBALS['strMyHeader'] = "Kopfzeile im Admin-Bereich";
$GLOBALS['strMyHeaderError'] = "Die Datei fur die Kopfzeile wurde an angegebenen Adresse nicht vorgefunden";
$GLOBALS['strMyFooter'] = "Fu?zeile im Admin-Bereich";
$GLOBALS['strMyFooterError'] = "Die Datei fur die Fu?zeile wurde an angegebenen Adresse nicht vorgefunden";
$GLOBALS['strGzipContentCompression'] = "Komprimieren mit GZIP";

$GLOBALS['strClientInterface'] = "Inserentenbereich";
$GLOBALS['strClientWelcomeEnabled'] = "Begru?ungstext fur Inserenten verwenden";
$GLOBALS['strClientWelcomeText'] = "Begru?ungstext<br><i>(HTML Tags sind zugelassen)</i>";



// Interface defaults
$GLOBALS['strInterfaceDefaults'] = "Einstellung der Voreinstellungen";

$GLOBALS['strInventory'] = "Bestandsverzeichnis";
$GLOBALS['strShowCampaignInfo'] = "Anzeigen zusatzlicher Informationen auf der Seite <i>Ubersicht Kampagnen</i>"; 
$GLOBALS['strShowBannerInfo'] = "Anzeigen zusatzlicher Bannerinformationen auf der Seite <i>Ubersicht Banner</i> ";
$GLOBALS['strShowCampaignPreview'] = "Vorschau aller Banner auf der Seite  <i>Ubersicht Banner </i>";
$GLOBALS['strShowBannerHTML'] = "Anzeige des Banners anstelle des HTML-Codes bei Vorschau von HTML-Bannern ";
$GLOBALS['strShowBannerPreview'] = "Bannervorschau oben auf allen Seiten mit dem Bezug zum Banner ";
$GLOBALS['strHideInactive'] = "Verbergen inaktive Teile auf den Ubersichtsseiten";
$GLOBALS['strGUIShowMatchingBanners'] = "Anzeige des zugehorenden Banner auf der Seite <i>Verknupfte Banner</i>";
$GLOBALS['strGUIShowParentCampaigns'] = "Anzeige der zugehorenden Kampagne auf der Seite <i>Veknupfte Banner</i>";
$GLOBALS['strGUILinkCompactLimit'] = "Verbergen nicht verknupfter Banner auf der Seite <i>Verknupfte Banner</i>, sofern es mehr sind als ";

$GLOBALS['strStatisticsDefaults'] = "Statistiken";
$GLOBALS['strBeginOfWeek'] = "Wochenbeginn";
$GLOBALS['strPercentageDecimals'] = "Dezimalstellen bei Prozentangaben";

$GLOBALS['strWeightDefaults'] = "Gewichtung (Voreinstellung)";
$GLOBALS['strDefaultBannerWeight'] = "Gewichtung Banner (Voreinstellung)";
$GLOBALS['strDefaultCampaignWeight'] = "Gewichtung Kampagne (Voreinstellung)";
$GLOBALS['strDefaultBannerWErr'] = "Voreinstellung fur Bannergewichtung mu? eine positive Ganzzahl sein";
$GLOBALS['strDefaultCampaignWErr'] = " Voreinstellung fur Kampagne mu? eine positive Ganzzahl sein";




// Not used at the moment
$GLOBALS['strTableBorderColor'] = "Table Border Color";
$GLOBALS['strTableBackColor'] = "Table Back Color";
$GLOBALS['strTableBackColorAlt'] = "Table Back Color (Alternative)";
$GLOBALS['strMainBackColor'] = "Main Back Color";
$GLOBALS['strOverrideGD'] = "Override GD Imageformat";
$GLOBALS['strTimeZone'] = "Time Zone";

?>